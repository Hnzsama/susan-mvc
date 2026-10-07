<?php
// routes/web.php - Definisi Routing Aplikasi Inainu MVC ala Laravel

use Carbon\Carbon;

// 1. Route Halaman Utama / Dashboard
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

// 2. Route Dokumentasi Interaktif SPA (Modular Bahasa Bayi Edition)
Route::get('/docs', function() {
    require __DIR__ . '/../docs/index.html';
});
Route::get('/docs/pages/{page}', function($page) {
    $cleanPage = basename($page);
    $path = __DIR__ . '/../docs/pages/' . $cleanPage;
    if (file_exists($path)) {
        header('Content-Type: text/html; charset=utf-8');
        readfile($path);
        exit;
    }
    http_response_code(404);
    echo '<div class="alert alert-danger">Halaman dokumentasi tidak ditemukan!</div>';
});

// 3. CONTOH ROUTE DENGAN MIDDLEWARE (Satpam Rute)
// -------------------------------------------------------------
// A. Single Middleware: Hanya user yang sudah login yang bisa akses
Route::get('/vip-area', function() {
    $user = Session::get('user');
    echo "<div style='font-family: sans-serif; padding: 2rem;'>";
    echo "<h2 style='color: #16a34a;'>🎉 Selamat datang di VIP Area!</h2>";
    echo "<p>Halo <strong>" . htmlspecialchars($user['nama'] ?? 'User') . "</strong>, Anda berhasil melewati <code>AuthMiddleware</code>!</p>";
    echo "<a href='" . BASEURL . "home'>&larr; Kembali ke Beranda</a>";
    echo "</div>";
})->middleware('auth');

// B. Multi Middleware: Wajib Login DAN Role harus 'admin'
Route::get('/admin/secret', function() {
    echo "<div style='font-family: sans-serif; padding: 2rem;'>";
    echo "<h2 style='color: #2563eb;'>🛡️ Area Rahasia Administrator</h2>";
    echo "<p>Anda berhasil melewati <code>AuthMiddleware</code> dan <code>AdminMiddleware</code>!</p>";
    echo "<a href='" . BASEURL . "home'>&larr; Kembali ke Beranda</a>";
    echo "</div>";
})->middleware(['auth', 'admin']);

// C. Route Grouping: Membungkus banyak rute dalam satu Middleware
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard/statistik', function() {
        echo "<div style='font-family: sans-serif; padding: 2rem;'>";
        echo "<h2>📊 Statistik Penjualan (Khusus Member)</h2>";
        echo "<a href='" . BASEURL . "home'>&larr; Kembali</a>";
        echo "</div>";
    });
});

// D. Route Bantuan untuk Simulasi Login & Logout
Route::get('/test-login', function() {
    Session::set('user', ['id' => 1, 'nama' => 'Budi Santoso', 'role' => 'admin']);
    Session::flash('success', 'Berhasil Login Simulasi sebagai Admin (Budi Santoso)! Coba akses /vip-area atau /admin/secret sekarang.');
    return redirect('home');
});

Route::get('/test-logout', function() {
    Session::remove('user');
    Session::flash('info', 'Anda telah Logout. Akses ke rute VIP/Admin sekarang akan ditolak oleh middleware.');
    return redirect('home');
});

// 4. CONTOH ROUTE MENGGUNAKAN PACKAGE DARI COMPOSER (nesbot/carbon)
// -------------------------------------------------------------
Route::get('/demo-composer', function() {
    Carbon::setLocale('id'); // Bahasa Indonesia
    $sekarang = Carbon::now();
    $waktuLalu = Carbon::now()->subMinutes(25);
    $eventMendatang = Carbon::now()->addDays(3);

    echo "<div style='font-family: sans-serif; padding: 2rem; max-width: 600px; margin: auto; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;'>";
    echo "<h2 style='color: #0f172a;'>📦 Demo Package Composer: <code>nesbot/carbon</code></h2>";
    echo "<p>Package berhasil dimuat secara otomatis via <code>vendor/autoload.php</code>!</p>";
    echo "<hr>";
    echo "<p><strong>Waktu Sekarang:</strong> " . $sekarang->translatedFormat('l, d F Y - H:i:s') . "</p>";
    echo "<p><strong>Waktu Relatif (diffForHumans):</strong> " . $waktuLalu->diffForHumans() . " <em>(25 menit lalu)</em></p>";
    echo "<p><strong>Event Mendatang:</strong> " . $eventMendatang->diffForHumans() . "</p>";
    echo "<hr>";
    echo "<a href='" . BASEURL . "home' style='color: #2563eb; text-decoration: none;'>&larr; Kembali ke Beranda</a>";
    echo "</div>";
});

// 5. Route Manajemen Produk (Tabel Master `produk`)
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/create', [ProductController::class, 'create']);
Route::post('/product/store', [ProductController::class, 'store']);
Route::get('/product/edit/{id}', [ProductController::class, 'edit']);
Route::post('/product/update', [ProductController::class, 'update']);
Route::get('/product/delete/{id}', [ProductController::class, 'delete']);

// 6. Route Detail & Spesifikasi Produk (Tabel `product_details` - One-to-One)
Route::get('/product-detail', [ProductDetailController::class, 'index']);
Route::get('/product-detail/delete/{id}', [ProductDetailController::class, 'delete']);

// 7. Route Ulasan & Rating (Tabel `product_reviews` - One-to-Many)
Route::get('/review', [ReviewController::class, 'index']);
Route::post('/review/store', [ReviewController::class, 'store']);
Route::get('/review/delete/{id}', [ReviewController::class, 'delete']);

// 8. Route Master Tags (Tabel `tags` & `product_tag` - Many-to-Many)
Route::get('/tag', [TagController::class, 'index']);
Route::post('/tag/store', [TagController::class, 'store']);
Route::get('/tag/delete/{id}', [TagController::class, 'delete']);

// 9. Route Data Siswa (Tabel `student`)
Route::get('/student', [StudentController::class, 'index']);
Route::post('/student/store', [StudentController::class, 'store']);
Route::get('/student/delete/{id}', [StudentController::class, 'delete']);
