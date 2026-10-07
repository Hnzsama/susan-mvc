<?php
// config/filesystems.php - Konfigurasi Filesystem & Storage ala Laravel

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    | Disk default yang digunakan saat memanggil Storage::put(), Storage::get(), dll.
    | Opsi: 'local', 'public'
    */
    'default' => env('FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    | Lokasi direktori penyimpanan file di server dan path URL publiknya.
    */
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root'   => __DIR__ . '/../storage/app',
            'url'    => '',
        ],

        'public' => [
            'driver'     => 'local',
            'root'       => __DIR__ . '/../storage/app/public',
            'url'        => 'storage', // Diakses via public/storage symlink
            'visibility' => 'public',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    | Daftar symbolic links yang dibuat saat menjalankan `php susan storage:link`.
    */
    'links' => [
        __DIR__ . '/../public/storage' => __DIR__ . '/../storage/app/public',
    ],
];
