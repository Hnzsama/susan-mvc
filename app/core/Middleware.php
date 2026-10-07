<?php
// app/core/Middleware.php - Core Middleware Pipeline & Registry ala Laravel

interface MiddlewareInterface {
    /**
     * Handle incoming request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Closure $next);
}

class Middleware {
    /**
     * Daftar alias middleware yang terdaftar di aplikasi
     */
    protected static $aliases = [
        'auth'  => 'AuthMiddleware',
        'guest' => 'GuestMiddleware',
        'admin' => 'AdminMiddleware',
    ];

    /**
     * Daftarkan alias middleware baru secara dinamis
     */
    public static function register(string $alias, string $class) {
        self::$aliases[$alias] = $class;
    }

    /**
     * Dapatkan class name dari alias
     */
    public static function resolve(string $name): string {
        return self::$aliases[$name] ?? $name;
    }

    /**
     * Jalankan rantai middleware (Pipeline / Onion Architecture)
     * 
     * @param array $middlewares Daftar middleware yang harus dilalui
     * @param Closure $destination Controller Action / Closure tujuan akhir
     * @return mixed
     */
    public static function pipeline(array $middlewares, Closure $destination) {
        if (empty($middlewares)) {
            return $destination();
        }

        $pipeline = array_reduce(
            array_reverse($middlewares),
            function ($next, $middlewareName) {
                return function () use ($next, $middlewareName) {
                    $className = self::resolve($middlewareName);

                    // Auto-load class middleware jika belum dimuat
                    if (!class_exists($className)) {
                        $path = __DIR__ . '/../middlewares/' . $className . '.php';
                        if (file_exists($path)) {
                            require_once $path;
                        } else {
                            die("Middleware [{$className}] tidak ditemukan di folder app/middlewares/!");
                        }
                    }

                    $instance = new $className();
                    if (!method_exists($instance, 'handle')) {
                        die("Middleware [{$className}] harus memiliki method handle(Closure \$next)!");
                    }

                    return $instance->handle($next);
                };
            },
            $destination
        );

        return $pipeline();
    }
}
