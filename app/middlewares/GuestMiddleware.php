<?php
// app/middlewares/GuestMiddleware.php - Middleware untuk Pengunjung (Belum Login)

require_once __DIR__ . '/../core/Middleware.php';

class GuestMiddleware implements MiddlewareInterface {
    /**
     * Pastikan pengguna belum login (misal untuk halaman Login / Register)
     */
    public function handle(Closure $next) {
        if (Session::has('user')) {
            Session::flash('info', 'Anda sudah dalam keadaan login.');
            return redirect('home');
        }

        return $next();
    }
}
