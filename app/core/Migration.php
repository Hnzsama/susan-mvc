<?php
// app/core/Migration.php - Base Class untuk File Migrasi

abstract class Migration {
    /**
     * Jalankan migrasi (CREATE TABLE / ALTER / dll)
     * @param PDO $db
     */
    abstract public function up(PDO $db);

    /**
     * Batalkan migrasi (DROP TABLE / ROLLBACK / dll)
     * @param PDO $db
     */
    abstract public function down(PDO $db);
}
