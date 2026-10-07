<?php
// app/config/config.php - Konfigurasi Konstan Global menggunakan .env

define('APP_NAME', env('APP_NAME', 'Inainu MVC Studio'));
define('APP_ENV', env('APP_ENV', 'development'));
define('BASEURL', env('APP_URL', 'index.php?url='));

// Konfigurasi Database dari .env
define('DB_DRIVER', env('DB_DRIVER', 'sqlite'));
define('DB_FILE', __DIR__ . '/' . env('DB_FILE', '../database.sqlite'));

// Konfigurasi MySQL jika DB_DRIVER=mysql
define('DB_HOST', env('DB_HOST', '127.0.0.1'));
define('DB_PORT', env('DB_PORT', '3306'));
define('DB_NAME', env('DB_NAME', 'inainu_db'));
define('DB_USER', env('DB_USER', 'root'));
define('DB_PASS', env('DB_PASS', ''));
