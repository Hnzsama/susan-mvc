<?php
// app/controllers/ProductDetailController.php - Controller Detail & Spesifikasi Produk (One-to-One)

require_once __DIR__ . '/../models/ProductDetail.php';

class ProductDetailController extends Controller {
    public function index() {
        $data['judul'] = 'Kelola Detail Spesifikasi Produk (One-to-One)';

        // Mengambil data detail lengkap beserta relasi produk menggunakan ORM
        $data['details'] = ProductDetail::allWithProduct();

        $this->view('templates/header', $data);
        $this->view('product_detail/index', $data);
        $this->view('templates/footer');
    }

    public function delete($id = null) {
        if ($id && ProductDetail::delete($id) > 0) {
            Session::flash('success', 'Detail spesifikasi berhasil dihapus!');
        } else {
            Session::flash('danger', 'Gagal menghapus detail spesifikasi!');
        }
        return redirect('product-detail');
    }
}
