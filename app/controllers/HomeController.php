<?php
// app/controllers/HomeController.php - Controller Halaman Utama / Dashboard

class HomeController extends Controller {
    public function index() {
        $data['judul'] = 'NyamCenter - Pemesanan Makanan Online Modern';
        $data['total_produk'] = Product::count();
        
        return $this->view('home/index', $data, 'layouts/app');
    }
}
