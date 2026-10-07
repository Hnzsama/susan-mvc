<?php
// app/controllers/ReviewController.php - Controller Manajemen Reviews / Ulasan (One-to-Many)

require_once __DIR__ . '/../models/ProductReview.php';
require_once __DIR__ . '/../models/Product.php';

class ReviewController extends Controller {
    public function index() {
        $data['judul'] = 'Kelola Ulasan Produk (One-to-Many)';
        
        // Mengambil ulasan lengkap beserta relasi produk menggunakan ORM
        $data['reviews'] = ProductReview::allWithProduct();
        $data['products'] = Product::all();

        $this->view('templates/header', $data);
        $this->view('review/index', $data);
        $this->view('templates/footer');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validateToken()) {
                Session::flash('danger', 'Token CSRF tidak valid!');
                return redirect('review');
            }

            // Validasi request input ala Laravel
            $validated = $this->validate([
                'product_id'    => 'required|integer',
                'reviewer_name' => 'required|min:3|max:100',
                'rating'        => 'required|integer|min:1|max:5',
                'komentar'      => 'required|min:3'
            ], $_POST, 'review');

            if (ProductReview::create($validated) > 0) {
                Session::flash('success', 'Ulasan berhasil ditambahkan!');
            } else {
                Session::flash('danger', 'Gagal menambahkan ulasan!');
            }
            return redirect('review');
        }
    }

    public function delete($id = null) {
        if ($id && ProductReview::delete($id) > 0) {
            Session::flash('success', 'Ulasan berhasil dihapus!');
        } else {
            Session::flash('danger', 'Gagal menghapus ulasan!');
        }
        return redirect('review');
    }
}
