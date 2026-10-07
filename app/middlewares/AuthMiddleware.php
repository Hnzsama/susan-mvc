<?php
// app/middlewares/AuthMiddleware.php - Middleware Otentikasi Pengguna

require_once __DIR__ . '/../core/Middleware.php';

class AuthMiddleware implements MiddlewareInterface {
    /**
     * Pastikan pengguna sudah login sebelum mengakses rute ini
     */
    public function handle(Closure $next) {
        if (!Session::has('user')) {
            Session::flash('warning', 'Silakan login terlebih dahulu untuk mengakses halaman ini!');
            return redirect('home');
        }

        return $next();
    }
}
