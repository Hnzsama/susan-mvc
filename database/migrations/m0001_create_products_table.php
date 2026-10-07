<?php
// database/migrations/m0001_create_products_table.php

require_once __DIR__ . '/../../app/core/Migration.php';

class m0001_create_products_table extends Migration {
    public function up(PDO $db) {
        $sql = "CREATE TABLE IF NOT EXISTS produk (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nama TEXT NOT NULL,
            kategori TEXT NOT NULL,
            harga INTEGER NOT NULL,
            stok INTEGER NOT NULL DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $db->exec($sql);
    }

    public function down(PDO $db) {
        $sql = "DROP TABLE IF EXISTS produk";
        $db->exec($sql);
    }
}
