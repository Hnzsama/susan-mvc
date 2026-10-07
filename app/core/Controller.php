<?php
// app/core/Controller.php - Base Controller untuk Database Query, Request Validation, & Rendering View

class Controller {
    /**
     * Objek Database Wrapper PDO untuk menjalankan query SQL langsung
     * @var Database
     */
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Validasi input request ala Laravel
     * @param array $rules Contoh: ['nama' => 'required|min:3|max:150', 'harga' => 'required|numeric|min:1000']
     * @param array $data Input data (default: $_POST jika kosong)
     * @param string|null $redirectUrl URL redirect jika validasi gagal
     * @return array Data tervalidasi dan tersanitasi
     */
    public function validate(array $rules, array $data = [], ?string $redirectUrl = null): array {
        if (empty($data)) {
            $data = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
        }

        $validator = new Validator($data, $rules);
        if ($validator->fails()) {
            $allErrors = $validator->errors();
            
            // Simpan flash errors dan old inputs ke session
            Session::flash('danger', implode('<br>', $allErrors));
            Session::flash('errors', $allErrors);
            Session::flash('old', $data);

            if ($redirectUrl) {
                redirect($redirectUrl);
            } else {
                $referer = $_SERVER['HTTP_REFERER'] ?? (BASEURL . 'product');
                header('Location: ' . $referer);
                exit;
            }
        }

        return $validator->validated();
    }

    /**
     * Render file view ke browser
     */
    public function view($view, $data = [], $layout = null) {
        // Ekstrak array $data menjadi variabel lokal di view
        extract($data);
        
        $normalized = str_replace('.', '/', $view);
        $viewFile = __DIR__ . '/../../resources/views/' . $normalized . '.php';
        if (!file_exists($viewFile)) {
            $viewFile = __DIR__ . '/../../resources/views/' . $normalized . '.blade.php';
        }

        if (!file_exists($viewFile)) {
            die("View file [resources/views/{$view}.php] tidak ditemukan!");
        }

        if ($layout) {
            ob_start();
            require $viewFile;
            $slot = ob_get_clean();

            $layoutNormalized = str_replace('.', '/', $layout);
            $layoutFile = __DIR__ . '/../../resources/views/' . $layoutNormalized . '.php';
            if (!file_exists($layoutFile)) {
                $layoutFile = __DIR__ . '/../../resources/views/' . $layoutNormalized . '.blade.php';
            }

            if (file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                echo $slot;
            }
        } else {
            require $viewFile;
        }
    }

    /**
     * Memuat Model jika diperlukan
     */
    public function model($model) {
        $modelFile = __DIR__ . '/../models/' . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        } else {
            die("Model file [{$model}] tidak ditemukan!");
        }
    }
}
