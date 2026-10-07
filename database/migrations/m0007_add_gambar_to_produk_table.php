<?php
// database/migrations/m0007_add_gambar_to_produk_table.php
// Menambahkan kolom gambar pada tabel produk untuk upload foto

require_once __DIR__ . '/../../app/core/Migration.php';

class m0007_add_gambar_to_produk_table extends Migration {
    public function up(PDO $db) {
        // Tambahkan kolom gambar jika belum ada
        try {
            $db->exec("ALTER TABLE produk ADD COLUMN gambar TEXT NULL");
        } catch (PDOException $e) {
            // Kolom mungkin sudah ada
        }
    }

    public function down(PDO $db) {
        // Rollback (SQLite 3.35.0+ mendukung DROP COLUMN)
        try {
            $db->exec("ALTER TABLE produk DROP COLUMN gambar");
        } catch (PDOException $e) {
            // Fallback jika versi sqlite lama
        }
    }
}
