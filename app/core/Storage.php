<?php
// app/core/Storage.php - Filesystem & Storage Engine ala Laravel

class Storage {
    private static $currentDisk = null;

    /**
     * Dapatkan konfigurasi disk filesystem
     */
    private static function getConfig(): array {
        $configFile = __DIR__ . '/../../config/filesystems.php';
        if (file_exists($configFile)) {
            return require $configFile;
        }
        return [
            'default' => 'public',
            'disks' => [
                'local'  => ['root' => __DIR__ . '/../../storage/app', 'url' => ''],
                'public' => ['root' => __DIR__ . '/../../storage/app/public', 'url' => 'storage'],
            ]
        ];
    }

    /**
     * Pilih disk penyimpanan ('local' atau 'public')
     */
    public static function disk(?string $name = null): self {
        $instance = new self();
        $config = self::getConfig();
        self::$currentDisk = $name ?? $config['default'] ?? 'public';
        return $instance;
    }

    /**
     * Dapatkan root path direktori dari disk aktif
     */
    private static function getRootPath(): string {
        $config = self::getConfig();
        $disk = self::$currentDisk ?? $config['default'] ?? 'public';
        $root = $config['disks'][$disk]['root'] ?? (__DIR__ . '/../../public/storage');
        
        if (!is_dir($root)) {
            mkdir($root, 0777, true);
        }
        return rtrim($root, '/');
    }

    /**
     * Simpan file string / raw data ke storage
     * Contoh: Storage::put('documents/file.txt', 'Halo Dunia')
     */
    public static function put(string $path, string $contents): bool {
        $root = self::getRootPath();
        $fullPath = $root . '/' . ltrim($path, '/');
        $dir = dirname($fullPath);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return file_put_contents($fullPath, $contents) !== false;
    }

    /**
     * Simpan file hasil upload dari form ($_FILES['gambar'])
     * Contoh: Storage::putFile('products', $_FILES['foto'])
     * @param string $folder Nama folder tujuan (contoh: 'products' atau 'avatars')
     * @param array $fileArray Array dari $_FILES['input_name']
     * @param string|null $customName Nama file kustom opsional
     * @return string|false Path relatif file yang tersimpan (contoh: 'products/img_64a9.png')
     */
    public static function putFile(string $folder, array $fileArray, ?string $customName = null) {
        if (!isset($fileArray['tmp_name']) || empty($fileArray['tmp_name']) || $fileArray['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $root = self::getRootPath();
        $targetDir = $root . '/' . trim($folder, '/');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $ext = strtolower(pathinfo($fileArray['name'], PATHINFO_EXTENSION));
        $filename = $customName ? ($customName . '.' . $ext) : (uniqid('file_', true) . '.' . $ext);
        $destPath = $targetDir . '/' . $filename;

        if (move_uploaded_file($fileArray['tmp_name'], $destPath)) {
            return trim($folder, '/') . '/' . $filename;
        }

        return false;
    }

    /**
     * Baca isi konten file dari storage
     */
    public static function get(string $path): ?string {
        $fullPath = self::getRootPath() . '/' . ltrim($path, '/');
        if (file_exists($fullPath)) {
            return file_get_contents($fullPath);
        }
        return null;
    }

    /**
     * Cek apakah file ada di storage
     */
    public static function exists(string $path): bool {
        $fullPath = self::getRootPath() . '/' . ltrim($path, '/');
        return file_exists($fullPath);
    }

    /**
     * Hapus file dari storage
     */
    public static function delete(string $path): bool {
        $fullPath = self::getRootPath() . '/' . ltrim($path, '/');
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        return false;
    }

    /**
     * Dapatkan URL publik untuk file (dapat dimasukkan ke tag <img src="...">)
     * Contoh: Storage::url('products/foto.jpg') => 'http://127.0.0.1:8000/storage/products/foto.jpg'
     */
    public static function url(string $path): string {
        $config = self::getConfig();
        $disk = self::$currentDisk ?? $config['default'] ?? 'public';
        
        if ($disk === 'public') {
            return url('storage/' . ltrim($path, '/'));
        }
        return '';
    }

    /**
     * Dapatkan ukuran file dalam bytes
     */
    public static function size(string $path): int {
        $fullPath = self::getRootPath() . '/' . ltrim($path, '/');
        return file_exists($fullPath) ? filesize($fullPath) : 0;
    }
}
