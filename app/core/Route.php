<?php
// app/core/Route.php - Declarative Router Engine ala Laravel dengan Middleware Pipeline

class Route {
    private static $routes = [];
    private static $groupMiddlewares = [];

    /**
     * Daftarkan route GET
     */
    public static function get($uri, $action) {
        return self::addRoute('GET', $uri, $action);
    }

    /**
     * Daftarkan route POST
     */
    public static function post($uri, $action) {
        return self::addRoute('POST', $uri, $action);
    }

    /**
     * Daftarkan route PUT (Mendukung form method spoofing _method=PUT)
     */
    public static function put($uri, $action) {
        return self::addRoute('PUT', $uri, $action);
    }

    /**
     * Daftarkan route DELETE (Mendukung form method spoofing _method=DELETE)
     */
    public static function delete($uri, $action) {
        return self::addRoute('DELETE', $uri, $action);
    }

    /**
     * Internal handler untuk menyimpan route ke registry
     */
    private static function addRoute($method, $uri, $action) {
        $uri = '/' . trim($uri, '/');
        $index = count(self::$routes);

        self::$routes[$index] = [
            'method'      => strtoupper($method),
            'uri'         => $uri,
            'action'      => $action,
            'middlewares' => self::$groupMiddlewares
        ];

        return new class($index) {
            private $routeIndex;

            public function __construct($index) {
                $this->routeIndex = $index;
            }

            /**
             * Tambahkan middleware ke rute (string atau array)
             * Contoh: ->middleware('auth') atau ->middleware(['auth', 'admin'])
             */
            public function middleware($middleware) {
                Route::attachMiddleware($this->routeIndex, $middleware);
                return $this;
            }
        };
    }

    /**
     * Attach middleware ke rute tertentu berdasarkan index
     */
    public static function attachMiddleware($index, $middleware) {
        if (!isset(self::$routes[$index])) {
            return;
        }

        $list = is_array($middleware) ? $middleware : [$middleware];
        foreach ($list as $m) {
            if (!in_array($m, self::$routes[$index]['middlewares'])) {
                self::$routes[$index]['middlewares'][] = $m;
            }
        }
    }

    /**
     * Grouping route dengan middleware
     * Contoh: Route::middleware(['auth'])->group(function() { ... });
     */
    public static function middleware($middleware) {
        $list = is_array($middleware) ? $middleware : [$middleware];

        return new class($list) {
            private $middlewares;

            public function __construct(array $middlewares) {
                $this->middlewares = $middlewares;
            }

            public function group(Closure $callback) {
                Route::beginGroup($this->middlewares);
                $callback();
                Route::endGroup();
            }
        };
    }

    public static function beginGroup(array $middlewares) {
        self::$groupMiddlewares = array_merge(self::$groupMiddlewares, $middlewares);
    }

    public static function endGroup() {
        self::$groupMiddlewares = [];
    }

    /**
     * Ambil semua route yang terdaftar
     */
    public static function getRoutes() {
        return self::$routes;
    }

    /**
     * Jalankan request dispatcher berdasarkan URL dan HTTP Method
     */
    public static function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // Normalisasi HEAD menjadi GET
        if ($requestMethod === 'HEAD') {
            $requestMethod = 'GET';
        }

        // Dukung method spoofing via $_POST['_method'] (misal PUT / DELETE)
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        $requestUri = self::getRequestUri();

        foreach (self::$routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            // Ubah placeholder seperti {id} atau {slug} menjadi Regex pattern
            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '([^/]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches); // Hilangkan full match

                // Eksekusi Pipeline Middleware sebelum masuk ke Controller
                $middlewares = $route['middlewares'] ?? [];
                
                return Middleware::pipeline($middlewares, function () use ($route, $matches) {
                    return self::executeAction($route['action'], $matches);
                });
            }
        }

        // Jika tidak ada route yang cocok, render 404
        self::render404($requestUri);
    }

    /**
     * Normalisasi Request URI
     */
    private static function getRequestUri() {
        // 1. Dukung format query ?url=...
        if (isset($_GET['url'])) {
            $uri = '/' . trim($_GET['url'], '/');
            return filter_var($uri, FILTER_SANITIZE_URL);
        }

        // 2. Format Pretty URL / RESTful
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $scriptName = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        
        if ($scriptName !== '/' && strpos($uri, $scriptName) === 0) {
            $uri = substr($uri, strlen($scriptName));
        }

        $uri = preg_replace('#^/index\.php#', '', $uri);
        $uri = '/' . trim($uri, '/');

        return filter_var($uri, FILTER_SANITIZE_URL);
    }

    /**
     * Eksekusi controller method atau closure
     */
    private static function executeAction($action, $params = []) {
        // 1. Jika berupa Closure / Fungsi Anonim
        if (is_callable($action)) {
            return call_user_func_array($action, $params);
        }

        // 2. Jika berupa Array: [ProductController::class, 'index'] atau ['ProductController', 'index']
        if (is_array($action)) {
            $controllerName = $action[0];
            $methodName = $action[1] ?? 'index';
        }
        // 3. Jika berupa String: 'ProductController@index'
        elseif (is_string($action) && strpos($action, '@') !== false) {
            list($controllerName, $methodName) = explode('@', $action);
        } else {
            die("Format action route tidak valid!");
        }

        // Pastikan Controller file dimuat jika belum
        if (!class_exists($controllerName)) {
            $file = __DIR__ . '/../controllers/' . $controllerName . '.php';
            if (file_exists($file)) {
                require_once $file;
            } else {
                die("Controller [{$controllerName}] tidak ditemukan!");
            }
        }

        $controllerInstance = new $controllerName();

        if (!method_exists($controllerInstance, $methodName)) {
            die("Method [{$methodName}] tidak ditemukan di Controller [{$controllerName}]!");
        }

        return call_user_func_array([$controllerInstance, $methodName], $params);
    }

    /**
     * Tampilan 404 Not Found yang rapi ala Laravel
     */
    private static function render404($uri) {
        http_response_code(404);
        echo '<!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>404 - Halaman Tidak Ditemukan</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
            <div class="text-center p-5 bg-white rounded-4 shadow-sm" style="max-width: 500px;">
                <h1 class="display-1 fw-bold text-danger">404</h1>
                <h4 class="fw-bold text-dark mb-3">Halaman Tidak Ditemukan</h4>
                <p class="text-muted mb-4">Route <code class="text-danger">' . htmlspecialchars($uri) . '</code> tidak terdaftar di <code>routes/web.php</code>.</p>
                <a href="' . BASEURL . '" class="btn btn-primary rounded-pill px-4">Kembali ke Beranda</a>
            </div>
        </body>
        </html>';
        exit;
    }
}
