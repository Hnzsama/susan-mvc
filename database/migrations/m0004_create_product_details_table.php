<?php
// database/migrations/m0004_create_product_details_table.php
// Relasi: ONE-TO-ONE (1 to 1) -> 1 Produk memiliki tepat 1 Detail Spesifikasi

require_once __DIR__ . '/../../app/core/Migration.php';

class m0004_create_product_details_table extends Migration {
    public function up(PDO $db) {
        // Kolom product_id diberi UNIQUE agar 1 produk hanya bisa punya 1 data detail (1 to 1)
        $sql = "CREATE TABLE IF NOT EXISTS product_details (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            product_id INTEGER NOT NULL UNIQUE,
            deskripsi TEXT,
            berat_gram INTEGER DEFAULT 0,
            garansi_bulan INTEGER DEFAULT 0,
            spesifikasi TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES produk (id) ON DELETE CASCADE
        )";
        $db->exec($sql);

        // Contoh Data Awal (Dummy Data)
        $db->exec("INSERT OR IGNORE INTO product_details (product_id, deskripsi, berat_gram, garansi_bulan, spesifikasi) VALUES
            (1, 'Laptop flagship Apple dengan chipset M3 Max terkencang untuk kebutuhan video editing dan programming berat.', 2100, 24, 'RAM 36GB, SSD 1TB, Liquid Retina XDR'),
            (2, 'Monitor resolusi 4K dengan lengkungan 1500R yang nyaman untuk produktivitas multitasking.', 6500, 36, 'IPS Panel, 144Hz, HDR400, USB-C 90W PD'),
            (3, 'Keyboard mekanikal dengan switch gateron pro yellow dan konektivitas tri-mode wireless.', 850, 12, 'Hot-swappable, RGB Backlight, Baterai 4000mAh')
        ");
    }

    public function down(PDO $db) {
        $sql = "DROP TABLE IF EXISTS product_details";
        $db->exec($sql);
    }
}
