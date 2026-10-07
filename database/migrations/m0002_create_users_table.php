<?php
// database/migrations/m0002_create_users_table.php

require_once __DIR__ . '/../../app/core/Migration.php';

class m0002_create_users_table extends Migration {
    public function up(PDO $db) {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            role TEXT DEFAULT 'user',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $db->exec($sql);
    }

    public function down(PDO $db) {
        $sql = "DROP TABLE IF EXISTS users";
        $db->exec($sql);
    }
}
