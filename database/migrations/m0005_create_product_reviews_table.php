<?php
// database/migrations/m0005_create_product_reviews_table.php
// Relasi: ONE-TO-MANY (1 to N) -> 1 Produk memiliki BANYAK Review/Ulasan Pembeli

require_once __DIR__ . '/../../app/core/Migration.php';

class m0005_create_product_reviews_table extends Migration {
    public function up(PDO $db) {
        // product_id TIDAK unique, sehingga 1 produk bisa memiliki banyak ulasan
        $sql = "CREATE TABLE IF NOT EXISTS product_reviews (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            product_id INTEGER NOT NULL,
            reviewer_name TEXT NOT NULL,
            rating INTEGER NOT NULL CHECK(rating >= 1 AND rating <= 5),
            komentar TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES produk (id) ON DELETE CASCADE
        )";
        $db->exec($sql);

        // Contoh Data Ulasan (Banyak review untuk produk id = 1 dan id = 2)
        $db->exec("INSERT OR IGNORE INTO product_reviews (product_id, reviewer_name, rating, komentar) VALUES
            (1, 'Budi Santoso', 5, 'Performa luar biasa kencang, render 4K video tanpa lag sama sekali!'),
            (1, 'Siti Rahma', 5, 'Baterai sangat awet untuk ngoding seharian di cafe.'),
            (1, 'Agus Setiawan', 4, 'Bagus banget, cuma harganya lumayan mahal.'),
            (2, 'Dimas Pratama', 5, 'Layar jernih, warna akurat banget untuk grading foto.'),
            (3, 'Reza Fauzi', 5, 'Suara switch empuk dan baterai tahan hingga 2 minggu.')
        ");
    }

    public function down(PDO $db) {
        $sql = "DROP TABLE IF EXISTS product_reviews";
        $db->exec($sql);
    }
}
