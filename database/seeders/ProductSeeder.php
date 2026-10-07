<?php
// database/seeders/ProductSeeder.php - Seeder data awal untuk tabel produk

class ProductSeeder {
    public function run(PDO $db) {
        $stmt = $db->query("SELECT COUNT(*) as total FROM produk");
        if ($stmt->fetch()['total'] == 0) {
            $sql = "INSERT INTO produk (nama, kategori, harga, stok) VALUES
                ('MacBook Pro M3 Max 16\"', 'Laptop & Komputer', 38500000, 5),
                ('Dell UltraSharp 34\" Curved Monitor', 'Display & Monitor', 12500000, 8),
                ('Keychron Q1 Pro Wireless Mechanical', 'Aksesoris', 2900000, 20),
                ('Logitech MX Master 3S', 'Aksesoris', 1650000, 35),
                ('Sony WH-1000XM5 Noise Canceling', 'Audio', 4999000, 15)";
            $db->exec($sql);
            echo "   \033[32m✔\033[0m Seeder [ProductSeeder] berhasil diisi.\n";
        } else {
            echo "   \033[33mℹ\033[0m Seeder [ProductSeeder] dilewati (tabel sudah memiliki data).\n";
        }
    }
}
