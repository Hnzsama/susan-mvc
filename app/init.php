<?php
// app/init.php - Inisialisasi dan Import file-file utama aplikasi MVC

// 0. Muat Composer Autoloader jika ada vendor/
$composerAutoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
}

// 1. Muat Loader Environment Variables (.env)
require_once __DIR__ . '/core/Env.php';
Env::load(__DIR__ . '/../.env');

// 2. Muat Konfigurasi & Core Engine
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/core/Session.php';
require_once __DIR__ . '/core/Csrf.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/core/Validator.php';
require_once __DIR__ . '/core/Storage.php';
require_once __DIR__ . '/core/Middleware.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Route.php';
require_once __DIR__ . '/core/App.php';
require_once __DIR__ . '/core/helpers.php';

// Inisialisasi session jika belum
Session::start();

// 3. Autoloader untuk Models, Controllers & Middlewares (PSR-0 style auto import)
spl_autoload_register(function ($class) {
    $modelPath = __DIR__ . '/models/' . $class . '.php';
    if (file_exists($modelPath)) {
        require_once $modelPath;
        return;
    }

    $controllerPath = __DIR__ . '/controllers/' . $class . '.php';
    if (file_exists($controllerPath)) {
        require_once $controllerPath;
        return;
    }

    $middlewarePath = __DIR__ . '/middlewares/' . $class . '.php';
    if (file_exists($middlewarePath)) {
        require_once $middlewarePath;
        return;
    }
});

// 4. Muat Definisi Routes Web
$routesFile = __DIR__ . '/../routes/web.php';
if (file_exists($routesFile)) {
    require_once $routesFile;
}
