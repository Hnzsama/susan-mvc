<?php
// app/controllers/ProductController.php - Controller Manajemen Produk (CRUD) & Storage Upload

require_once __DIR__ . '/../models/Product.php';

class ProductController extends Controller {
    public function index() {
        $data['judul'] = 'Daftar Produk Lengkap & Relasi';
        $products = Product::all();

        // Muat relasi ORM (1-to-1 detail, 1-to-Many reviews, Many-to-Many tags) untuk setiap produk
        foreach ($products as &$p) {
            $p['detail']  = Product::detail($p['id']);
            $p['reviews'] = Product::reviews($p['id']);
            $p['tags']    = Product::tags($p['id']);
            
            // Hitung rata-rata rating dari relasi reviews
            if (!empty($p['reviews'])) {
                $totalScore = array_sum(array_column($p['reviews'], 'rating'));
                $p['avg_rating'] = round($totalScore / count($p['reviews']), 1);
                $p['total_reviews'] = count($p['reviews']);
            } else {
                $p['avg_rating'] = null;
                $p['total_reviews'] = 0;
            }
        }
        unset($p);

        $data['produk'] = $products;

        $this->view('templates/header', $data);
        $this->view('product/index', $data);
        $this->view('templates/footer');
    }

    public function create() {
        $data['judul'] = 'Tambah Produk Baru';

        $this->view('templates/header', $data);
        $this->view('product/create', $data);
        $this->view('templates/footer');
    }

    /**
     * Simpan Produk Baru dengan Validasi & Upload Gambar Storage
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Validasi Keamanan Token CSRF
            if (!Csrf::validateToken()) {
                Session::flash('danger', 'Token CSRF tidak valid atau sesi telah kadaluarsa!');
                return redirect('product/create');
            }

            // 2. Validasi Request Input
            $validated = $this->validate([
                'nama'     => 'required|min:3|max:150',
                'kategori' => 'required|string',
                'harga'    => 'required|numeric|min:1000',
                'stok'     => 'required|integer|min:0'
            ], $_POST, 'product/create');

            // 3. Handle Upload File Gambar via Storage Engine
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                
                if (!in_array($ext, $allowedExts)) {
                    Session::flash('danger', 'Format gambar harus berupa JPG, PNG, WEBP, atau GIF!');
                    return redirect('product/create');
                }

                if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
                    Session::flash('danger', 'Ukuran gambar tidak boleh melebihi 2 MB!');
                    return redirect('product/create');
                }

                $uploadedPath = Storage::putFile('products', $_FILES['gambar']);
                if ($uploadedPath) {
                    $validated['gambar'] = $uploadedPath;
                }
            }

            // 4. Simpan ke Database
            if (Product::create($validated) > 0) {
                Session::flash('success', "Produk '{$validated['nama']}' berhasil ditambahkan!");
                return redirect('product');
            } else {
                Session::flash('danger', 'Gagal menambahkan produk ke database!');
                return redirect('product/create');
            }
        }
    }

    public function edit($id = null) {
        $validId = filter_var($id, FILTER_VALIDATE_INT);
        if (!$validId) {
            Session::flash('danger', 'ID Produk tidak valid!');
            return redirect('product');
        }

        $data['judul'] = 'Edit Produk';
        $data['produk'] = Product::find($validId);

        if (!$data['produk']) {
            Session::flash('danger', 'Produk tidak ditemukan!');
            return redirect('product');
        }

        $data['detail']  = Product::detail($validId);
        $data['reviews'] = Product::reviews($validId);
        $data['tags']    = Product::tags($validId);

        $this->view('templates/header', $data);
        $this->view('product/edit', $data);
        $this->view('templates/footer');
    }

    /**
     * Update Produk dengan Dukungan Ganti Gambar Storage
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Validasi Token CSRF
            if (!Csrf::validateToken()) {
                Session::flash('danger', 'Token CSRF tidak valid atau sesi telah kadaluarsa!');
                return redirect('product');
            }

            // 2. Validasi ID Produk & Eksistensi di Database
            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
            $existing = $id ? Product::find($id) : null;
            if (!$existing) {
                Session::flash('danger', 'Produk yang ingin diubah tidak ditemukan!');
                return redirect('product');
            }

            // 3. Validasi Request Input
            $validated = $this->validate([
                'nama'     => 'required|min:3|max:150',
                'kategori' => 'required|string',
                'harga'    => 'required|numeric|min:1000',
                'stok'     => 'required|integer|min:0'
            ], $_POST, 'product/edit/' . $id);

            // 4. Handle Ganti Gambar Baru
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                
                if (!in_array($ext, $allowedExts)) {
                    Session::flash('danger', 'Format gambar harus berupa JPG, PNG, WEBP, atau GIF!');
                    return redirect('product/edit/' . $id);
                }

                if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
                    Session::flash('danger', 'Ukuran gambar tidak boleh melebihi 2 MB!');
                    return redirect('product/edit/' . $id);
                }

                // Hapus foto lama dari storage jika ada
                if (!empty($existing['gambar'])) {
                    Storage::delete($existing['gambar']);
                }

                $uploadedPath = Storage::putFile('products', $_FILES['gambar']);
                if ($uploadedPath) {
                    $validated['gambar'] = $uploadedPath;
                }
            }

            // 5. Update Data ke Database
            if (Product::update($id, $validated) > 0) {
                Session::flash('success', "Data produk '{$validated['nama']}' berhasil diperbarui!");
            } else {
                Session::flash('info', 'Tidak ada perubahan data pada produk.');
            }
            return redirect('product');
        }
    }

    /**
     * Hapus Produk & Berkas Gambar Terkait dari Storage
     */
    public function delete($id = null) {
        $validId = filter_var($id, FILTER_VALIDATE_INT);
        if (!$validId) {
            Session::flash('danger', 'ID Produk tidak valid atau kosong!');
            return redirect('product');
        }

        $existing = Product::find($validId);
        if (!$existing) {
            Session::flash('danger', 'Produk tidak ditemukan atau sudah dihapus sebelumnya!');
            return redirect('product');
        }

        // Hapus file gambar dari storage jika ada
        if (!empty($existing['gambar'])) {
            Storage::delete($existing['gambar']);
        }

        if (Product::delete($validId) > 0) {
            Session::flash('success', "Produk '{$existing['nama']}' berhasil dihapus!");
        } else {
            Session::flash('danger', 'Gagal menghapus produk dari database!');
        }
        return redirect('product');
    }
}
