<?php
// migrate.php - Migration Engine & CLI Tool untuk PHP MVC

require_once __DIR__ . '/app/init.php';

class MigrationRunner {
    private $db;
    private $migrationsDir;

    public function __construct() {
        $this->migrationsDir = __DIR__ . '/database/migrations';

        // Inisialisasi koneksi PDO
        try {
            if (DB_DRIVER === 'mysql') {
                $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
                $this->db = new PDO($dsn, DB_USER, DB_PASS);
            } else {
                $this->db = new PDO("sqlite:" . DB_FILE);
            }
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Buat tabel pelacak migrasi jika belum ada
            $this->createMigrationsTable();
        } catch (PDOException $e) {
            die("\033[31m[ERROR]\033[0m Koneksi Database Gagal: " . $e->getMessage() . "\n");
        }
    }

    private function createMigrationsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            migration VARCHAR(255) NOT NULL,
            batch INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->db->exec($sql);
    }

    public function applyMigrations() {
        $applied = $this->getAppliedMigrations();
        $files = scandir($this->migrationsDir);
        $toApply = array_diff($files, ['.', '..']);
        $newMigrations = [];

        // Dapatkan batch nomor berikutnya
        $stmt = $this->db->query("SELECT MAX(batch) as max_batch FROM migrations");
        $nextBatch = ((int)$stmt->fetch()['max_batch']) + 1;

        echo "\n\033[36m=== Menjalankan Migrasi Database ===\033[0m\n";

        foreach ($toApply as $migrationFile) {
            if (in_array($migrationFile, $applied)) {
                continue;
            }

            require_once $this->migrationsDir . '/' . $migrationFile;
            $className = pathinfo($migrationFile, PATHINFO_FILENAME);
            $instance = new $className();

            echo " ⏳ Menerapkan: \033[33m$migrationFile\033[0m ...";
            $instance->up($this->db);
            echo " \033[32m[SELESAI]\033[0m\n";

            $this->saveMigration($migrationFile, $nextBatch);
            $newMigrations[] = $migrationFile;
        }

        if (empty($newMigrations)) {
            echo " \033[32m✔ Semua migrasi sudah mutakhir (Nothing to migrate).\033[0m\n\n";
        } else {
            echo " \033[32m✔ Berhasil menerapkan " . count($newMigrations) . " migrasi (Batch $nextBatch).\033[0m\n\n";
        }
    }

    public function rollback() {
        $stmt = $this->db->query("SELECT MAX(batch) as max_batch FROM migrations");
        $lastBatch = (int)$stmt->fetch()['max_batch'];

        if ($lastBatch === 0) {
            echo "\n\033[33mℹ Tidak ada migrasi yang bisa di-rollback.\033[0m\n\n";
            return;
        }

        $stmt = $this->db->prepare("SELECT migration FROM migrations WHERE batch = :batch ORDER BY id DESC");
        $stmt->execute([':batch' => $lastBatch]);
        $migrations = $stmt->fetchAll();

        echo "\n\033[35m=== Rollback Migrasi (Batch $lastBatch) ===\033[0m\n";

        foreach ($migrations as $row) {
            $migrationFile = $row['migration'];
            require_once $this->migrationsDir . '/' . $migrationFile;
            $className = pathinfo($migrationFile, PATHINFO_FILENAME);
            $instance = new $className();

            echo " ⏪ Membatalkan: \033[33m$migrationFile\033[0m ...";
            $instance->down($this->db);
            echo " \033[32m[SELESAI]\033[0m\n";

            $delStmt = $this->db->prepare("DELETE FROM migrations WHERE migration = :migration");
            $delStmt->execute([':migration' => $migrationFile]);
        }

        echo " \033[32m✔ Rollback Batch $lastBatch berhasil dilakukan.\033[0m\n\n";
    }

    public function status() {
        $applied = $this->getAppliedMigrationsWithBatch();
        $files = array_diff(scandir($this->migrationsDir), ['.', '..']);

        echo "\n\033[36m=== Status Migrasi Database ===\033[0m\n";
        printf("+-%'-50s-+-%'-10s-+-%'-10s-+\n", "", "", "");
        printf("| %-50s | %-10s | %-10s |\n", "Nama File Migrasi", "Status", "Batch");
        printf("+-%'-50s-+-%'-10s-+-%'-10s-+\n", "", "", "");

        foreach ($files as $file) {
            $isApplied = isset($applied[$file]);
            $status = $isApplied ? "\033[32mYa\033[0m" : "\033[31mBelum\033[0m";
            $batch = $isApplied ? $applied[$file] : "-";
            printf("| %-50s | %-19s | %-10s |\n", $file, $status, $batch);
        }
        printf("+-%'-50s-+-%'-10s-+-%'-10s-+\n\n", "", "", "");
    }

    public function seed() {
        $seedersDir = __DIR__ . '/database/seeders';
        if (!is_dir($seedersDir)) return;

        echo "\n\033[36m=== Menjalankan Database Seeders ===\033[0m\n";
        $files = array_diff(scandir($seedersDir), ['.', '..']);
        foreach ($files as $file) {
            require_once $seedersDir . '/' . $file;
            $className = pathinfo($file, PATHINFO_FILENAME);
            $instance = new $className();
            $instance->run($this->db);
        }
        echo " \033[32m✔ Proses seeder selesai.\033[0m\n\n";
    }

    public function createMigration($name) {
        $name = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', $name));
        $count = count(array_diff(scandir($this->migrationsDir), ['.', '..'])) + 1;
        $prefix = sprintf("m%04d_", $count);
        $fileName = $prefix . $name . '.php';
        $className = $prefix . $name;

        $template = <<<PHP
<?php
// database/migrations/{$fileName}

require_once __DIR__ . '/../../app/core/Migration.php';

class {$className} extends Migration {
    public function up(PDO \$db) {
        // Tulis SQL CREATE TABLE / ALTER TABLE di sini
        // \$sql = "CREATE TABLE ...";
        // \$db->exec(\$sql);
    }

    public function down(PDO \$db) {
        // Tulis SQL DROP TABLE / ROLLBACK di sini
        // \$sql = "DROP TABLE IF EXISTS ...";
        // \$db->exec(\$sql);
    }
}
PHP;

        file_put_contents($this->migrationsDir . '/' . $fileName, $template);
        echo "\n\033[32m✔ File migrasi berhasil dibuat:\033[0m database/migrations/{$fileName}\n\n";
    }

    private function getAppliedMigrations() {
        $stmt = $this->db->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function getAppliedMigrationsWithBatch() {
        $stmt = $this->db->query("SELECT migration, batch FROM migrations");
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[$row['migration']] = $row['batch'];
        }
        return $results;
    }

    private function saveMigration($migration, $batch) {
        $stmt = $this->db->prepare("INSERT INTO migrations (migration, batch) VALUES (:m, :b)");
        $stmt->execute([':m' => $migration, ':b' => $batch]);
    }
}

// Handler Argumen CLI (Hanya jika dijalankan langsung: php migrate.php)
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === realpath(__FILE__)) {
    $runner = new MigrationRunner();
    $action = $argv[1] ?? 'migrate';

    switch ($action) {
        case '--rollback':
        case '-r':
            $runner->rollback();
            break;
        case '--status':
        case '-s':
            $runner->status();
            break;
        case '--seed':
            $runner->seed();
            break;
        case '--create':
        case '-c':
            $name = $argv[2] ?? 'custom_table';
            $runner->createMigration($name);
            break;
        case 'migrate':
        default:
            $runner->applyMigrations();
            if (in_array('--seed', $argv)) {
                $runner->seed();
            }
            break;
    }
}
