<?php
// app/models/Product_model.php - Model khusus untuk menangani tabel produk

class Product_model {
    private $table = 'produk';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllProducts() {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC");
        return $this->db->resultSet();
    }

    public function getProductById($id) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataProduct($data) {
        $query = "INSERT INTO " . $this->table . " (nama, kategori, harga, stok) 
                  VALUES (:nama, :kategori, :harga, :stok)";
        
        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('kategori', $data['kategori']);
        $this->db->bind('harga', $data['harga']);
        $this->db->bind('stok', $data['stok']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahDataProduct($data) {
        $query = "UPDATE " . $this->table . " SET 
                    nama = :nama,
                    kategori = :kategori,
                    harga = :harga,
                    stok = :stok
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('kategori', $data['kategori']);
        $this->db->bind('harga', $data['harga']);
        $this->db->bind('stok', $data['stok']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusDataProduct($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();
        return $this->db->rowCount();
    }
}
