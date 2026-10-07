<?php
// app/middlewares/AdminMiddleware.php - Middleware Proteksi Hak Akses Admin

require_once __DIR__ . '/../core/Middleware.php';

class AdminMiddleware implements MiddlewareInterface {
    /**
     * Pastikan pengguna memiliki peran (role) sebagai admin
     */
    public function handle(Closure $next) {
        $user = Session::get('user');

        if (!$user || !isset($user['role']) || strtolower($user['role']) !== 'admin') {
            Session::flash('danger', 'Akses ditolak! Halaman ini hanya diperuntukkan bagi Administrator.');
            return redirect('home');
        }

        return $next();
    }
}
