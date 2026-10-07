<?php
// public/index.php - Front Controller / Single Entry Point

// Muat bootstrap loader file
require_once __DIR__ . '/../app/init.php';

// Inisialisasi dan jalankan router aplikasi
$app = new App();
