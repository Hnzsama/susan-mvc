<?php
// app/core/Database.php - Database Wrapper PDO (Mendukung SQLite & MySQL dari .env)

class Database {
    private $dbh;
    private $stmt;

    public function __construct() {
        try {
            if (DB_DRIVER === 'mysql') {
                $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
                $this->dbh = new PDO($dsn, DB_USER, DB_PASS);
            } else {
                $this->dbh = new PDO("sqlite:" . DB_FILE);
            }

            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Migrasi otomatis tabel jika menggunakan SQLite
            if (DB_DRIVER === 'sqlite') {
                $this->dbh->exec("CREATE TABLE IF NOT EXISTS produk (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nama TEXT NOT NULL,
                    kategori TEXT NOT NULL,
                    harga INTEGER NOT NULL,
                    stok INTEGER NOT NULL,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )");

                $check = $this->dbh->query("SELECT COUNT(*) as total FROM produk")->fetch();
                if ($check['total'] == 0) {
                    $this->dbh->exec("INSERT INTO produk (nama, kategori, harga, stok) VALUES
                        ('MacBook Pro M3 Max', 'Laptop & PC', 38000000, 5),
                        ('Monitor 4K Ultrawide 34\"', 'Display', 8500000, 12),
                        ('Mechanical Keyboard Wireless', 'Aksesoris', 1200000, 30)");
                }
            }
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }
}
