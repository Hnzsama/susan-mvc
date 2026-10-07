<?php
// database/migrations/m0006_create_tags_and_product_tag_table.php
// Relasi: MANY-TO-MANY (N to M) -> 1 Produk bisa punya BANYAK Tag, dan 1 Tag bisa dimiliki BANYAK Produk.
// Menggunakan tabel pivot/junction: `product_tag`

require_once __DIR__ . '/../../app/core/Migration.php';

class m0006_create_tags_and_product_tag_table extends Migration {
    public function up(PDO $db) {
        // 1. Tabel Master Tags
        $sqlTags = "CREATE TABLE IF NOT EXISTS tags (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nama_tag TEXT NOT NULL UNIQUE,
            slug TEXT NOT NULL UNIQUE,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $db->exec($sqlTags);

        // 2. Tabel Pivot / Perantara (product_tag)
        $sqlPivot = "CREATE TABLE IF NOT EXISTS product_tag (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            product_id INTEGER NOT NULL,
            tag_id INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES produk (id) ON DELETE CASCADE,
            FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE,
            UNIQUE(product_id, tag_id)
        )";
        $db->exec($sqlPivot);

        // Isi Data Tags Master
        $db->exec("INSERT OR IGNORE INTO tags (id, nama_tag, slug) VALUES
            (1, 'Best Seller', 'best-seller'),
            (2, 'Diskon Spesial', 'diskon-spesial'),
            (3, 'Elektronik & Gadget', 'elektronik-gadget'),
            (4, 'Gaming Setup', 'gaming-setup'),
            (5, 'Produktivitas Kerja', 'produktivitas-kerja')
        ");

        // Isi Relasi Many-to-Many di Tabel Pivot
        // Produk 1 (MacBook): Punya tag Best Seller (1), Elektronik (3), Produktivitas (5)
        // Produk 2 (Monitor): Punya tag Gaming Setup (4), Produktivitas (5)
        // Produk 3 (Keyboard): Punya tag Best Seller (1), Gaming Setup (4)
        $db->exec("INSERT OR IGNORE INTO product_tag (product_id, tag_id) VALUES
            (1, 1),
            (1, 3),
            (1, 5),
            (2, 4),
            (2, 5),
            (3, 1),
            (3, 4)
        ");
    }

    public function down(PDO $db) {
        $db->exec("DROP TABLE IF EXISTS product_tag");
        $db->exec("DROP TABLE IF EXISTS tags");
    }
}
