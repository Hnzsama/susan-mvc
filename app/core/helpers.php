<?php
// app/core/helpers.php - Global Helper Functions ala Laravel

if (!function_exists('view')) {
    /**
     * Render view dengan data dan layout opsional
     */
    function view($view, $data = [], $layout = null) {
        $controller = new Controller();
        return $controller->view($view, $data, $layout);
    }
}

if (!function_exists('include_view')) {
    /**
     * Helper include partial view
     */
    function include_view($viewPath, $data = []) {
        extract($data);
        $normalized = str_replace('.', '/', $viewPath);
        $base = __DIR__ . '/../../resources/views/' . $normalized;
        if (file_exists($base . '.php')) {
            require $base . '.php';
        } elseif (file_exists($base . '.blade.php')) {
            require $base . '.blade.php';
        }
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect ke URL tertentu dengan opsi flash message
     */
    function redirect($url, $flash = null) {
        if ($flash && is_array($flash)) {
            foreach ($flash as $key => $msg) {
                Session::flash($key, $msg);
            }
        }
        
        $target = filter_var($url, FILTER_VALIDATE_URL) ? $url : BASEURL . ltrim($url, '/');
        header('Location: ' . $target);
        exit;
    }
}

if (!function_exists('url')) {
    /**
     * Menghasilkan URL lengkap berdasarkan BASEURL
     */
    function url($path = '') {
        return BASEURL . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    /**
     * Helper untuk asset publik (css, js, images)
     */
    function asset($path = '') {
        return url('public/' . ltrim($path, '/'));
    }
}

if (!function_exists('session')) {
    /**
     * Akses session get / set secara singkat
     */
    function session($key = null, $default = null) {
        if (is_null($key)) {
            return $_SESSION ?? [];
        }
        return Session::get($key, $default);
    }
}

if (!function_exists('flash')) {
    /**
     * Mengambil atau menyetel flash message
     */
    function flash($key, $value = null) {
        if (!is_null($value)) {
            Session::flash($key, $value);
            return;
        }
        return Session::getFlash($key);
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Dapatkan CSRF Token aktif
     */
    function csrf_token() {
        return Csrf::getToken();
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Render hidden input form untuk CSRF
     */
    function csrf_field() {
        return Csrf::field();
    }
}

if (!function_exists('old')) {
    /**
     * Ambil data input sebelumnya dari session jika ada
     */
    function old($key, $default = '') {
        return Session::getFlash('old_' . $key, $default);
    }
}

if (!function_exists('dd')) {
    /**
     * Dump and Die khas Laravel untuk debugging profesional
     */
    function dd(...$vars) {
        echo '<style>
            .dd-wrapper { background: #1e1e2e; color: #cdd6f4; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; padding: 20px; font-size: 14px; line-height: 1.5; border-radius: 8px; margin: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); }
            .dd-badge { background: #f38ba8; color: #11111b; padding: 2px 8px; border-radius: 4px; font-weight: bold; margin-bottom: 12px; display: inline-block; font-size: 12px; }
            .dd-content { background: #181825; padding: 15px; border-radius: 6px; border-left: 4px solid #89b4fa; overflow-x: auto; }
        </style>';
        echo '<div class="dd-wrapper"><span class="dd-badge">INAINU DEBUGGER (dd)</span>';
        foreach ($vars as $var) {
            echo '<pre class="dd-content">';
            var_dump($var);
            echo '</pre>';
        }
        echo '</div>';
        die();
    }
}

if (!function_exists('vite')) {
    /**
     * Vite Asset Loader ala Laravel (@vite)
     * Otomatis mendeteksi Dev Server (npm run dev) atau Build Production (public/build)
     */
    function vite($entries = ['resources/css/app.css', 'resources/js/app.js']) {
        if (is_string($entries)) {
            $entries = [$entries];
        }

        $hotFile = __DIR__ . '/../../public/hot';
        
        // 1. Mode Dev Server (npm run dev)
        if (file_exists($hotFile)) {
            $url = rtrim(file_get_contents($hotFile));
            $tags = [];
            $tags[] = '<script type="module" src="' . $url . '/@vite/client"></script>';
            foreach ($entries as $entry) {
                $clean = ltrim($entry, '/');
                if (str_ends_with($clean, '.css')) {
                    $tags[] = '<link rel="stylesheet" href="' . $url . '/' . $clean . '">';
                } elseif (str_ends_with($clean, '.js')) {
                    $tags[] = '<script type="module" src="' . $url . '/' . $clean . '"></script>';
                }
            }
            return implode("\n  ", $tags);
        }

        // 2. Mode Production Build (public/build/manifest.json)
        $manifestPath = __DIR__ . '/../../public/build/manifest.json';
        if (!file_exists($manifestPath)) {
            $manifestPath = __DIR__ . '/../../public/build/.vite/manifest.json';
        }

        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            $tags = [];
            foreach ($entries as $entry) {
                $cleanEntry = ltrim($entry, '/');
                if (isset($manifest[$cleanEntry])) {
                    $file = $manifest[$cleanEntry]['file'];
                    if (str_ends_with($file, '.css')) {
                        $tags[] = '<link rel="stylesheet" href="/build/' . $file . '">';
                    } elseif (str_ends_with($file, '.js')) {
                        $tags[] = '<script type="module" src="/build/' . $file . '"></script>';
                    }

                    // Muat CSS yang dihasilkan dari JS bundle jika ada
                    if (!empty($manifest[$cleanEntry]['css'])) {
                        foreach ($manifest[$cleanEntry]['css'] as $cssFile) {
                            $tags[] = '<link rel="stylesheet" href="/build/' . $cssFile . '">';
                        }
                    }
                }
            }
            return implode("\n  ", array_unique($tags));
        }

        // 3. Fallback jika manifest belum di-build
        return '<link rel="stylesheet" href="/resources/css/app.css">' . "\n  " . '<script type="module" src="/resources/js/app.js"></script>';
    }
}
