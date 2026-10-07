<?php
// app/controllers/Home.php - Controller untuk Halaman Utama / Dashboard

class Home extends Controller {
    public function index() {
        $data['judul'] = 'Beranda MVC';

        // SQL Query langsung di controller: Hitung total data produk
        $this->db->query("SELECT COUNT(*) as total FROM produk");
        $row = $this->db->single();
        $data['total_produk'] = (int)($row['total'] ?? 0);
        
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}
