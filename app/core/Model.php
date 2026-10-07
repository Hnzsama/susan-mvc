<?php
// app/core/Model.php - Base Active Record & ORM Relationship Engine (1-to-1, 1-to-Many, Many-to-Many)

class Model {
    protected static $table;
    protected static $primaryKey = 'id';

    /**
     * Dapatkan nama tabel dari nama class jika properti $table tidak diatur
     */
    public static function getTable() {
        if (!empty(static::$table)) {
            return static::$table;
        }
        return strtolower(get_called_class()) . 's';
    }

    /**
     * Ambil semua record dari tabel
     */
    public static function all() {
        $db = new Database();
        $table = static::getTable();
        $primaryKey = static::$primaryKey;
        $db->query("SELECT * FROM {$table} ORDER BY {$primaryKey} DESC");
        return $db->resultSet();
    }

    /**
     * Ambil record berdasarkan ID (Primary Key)
     */
    public static function find($id) {
        $db = new Database();
        $table = static::getTable();
        $primaryKey = static::$primaryKey;
        $db->query("SELECT * FROM {$table} WHERE {$primaryKey} = :id LIMIT 1");
        $db->bind('id', $id);
        return $db->single();
    }

    /**
     * Cari record berdasarkan kolom tertentu
     */
    public static function where($column, $value) {
        $db = new Database();
        $table = static::getTable();
        $db->query("SELECT * FROM {$table} WHERE {$column} = :val");
        $db->bind('val', $value);
        return $db->resultSet();
    }

    /**
     * Cari satu record pertama berdasarkan kolom tertentu
     */
    public static function firstWhere($column, $value) {
        $db = new Database();
        $table = static::getTable();
        $db->query("SELECT * FROM {$table} WHERE {$column} = :val LIMIT 1");
        $db->bind('val', $value);
        return $db->single();
    }

    /**
     * Eksekusi raw SQL query kustom
     */
    public static function rawQuery($sql, $params = []) {
        $db = new Database();
        $db->query($sql);
        foreach ($params as $param => $val) {
            $db->bind($param, $val);
        }
        return $db->resultSet();
    }

    /**
     * Insert data baru ke database (Mirip Model::create($_POST))
     */
    public static function create(array $data) {
        $db = new Database();
        $table = static::getTable();

        // Hapus token CSRF atau field internal jika ada
        unset($data['_token'], $data['id']);

        $fields = array_keys($data);
        $columns = implode(', ', $fields);
        $placeholders = ':' . implode(', :', $fields);

        $db->query("INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})");
        foreach ($data as $key => $val) {
            $db->bind($key, $val);
        }
        $db->execute();
        return $db->rowCount();
    }

    /**
     * Update record berdasarkan ID
     */
    public static function update($id, array $data) {
        $db = new Database();
        $table = static::getTable();
        $primaryKey = static::$primaryKey;

        unset($data['_token'], $data[$primaryKey]);

        $sets = [];
        foreach (array_keys($data) as $field) {
            $sets[] = "{$field} = :{$field}";
        }
        $setString = implode(', ', $sets);

        $db->query("UPDATE {$table} SET {$setString} WHERE {$primaryKey} = :primary_id");
        foreach ($data as $key => $val) {
            $db->bind($key, $val);
        }
        $db->bind('primary_id', $id);
        $db->execute();
        return $db->rowCount();
    }

    /**
     * Hapus record berdasarkan ID
     */
    public static function delete($id) {
        $db = new Database();
        $table = static::getTable();
        $primaryKey = static::$primaryKey;

        $db->query("DELETE FROM {$table} WHERE {$primaryKey} = :id");
        $db->bind('id', $id);
        $db->execute();
        return $db->rowCount();
    }

    /**
     * Hitung total record dalam tabel
     */
    public static function count() {
        $db = new Database();
        $table = static::getTable();
        $db->query("SELECT COUNT(*) as total FROM {$table}");
        $row = $db->single();
        return (int)($row['total'] ?? 0);
    }

    // ========================================================
    // ORM RELATIONSHIP METHODS (1-to-1, 1-to-Many, Many-to-Many)
    // ========================================================

    /**
     * Relasi 1 to 1 (One-to-One)
     * Contoh: Product::detail($productId)
     */
    public static function hasOne($relatedModel, $foreignKey = null, $localId = null) {
        $db = new Database();
        $relatedTable = $relatedModel::getTable();
        $foreignKey = $foreignKey ?? 'product_id';
        
        $db->query("SELECT * FROM {$relatedTable} WHERE {$foreignKey} = :id LIMIT 1");
        $db->bind('id', $localId);
        return $db->single();
    }

    /**
     * Relasi 1 to Many (One-to-Many)
     * Contoh: Product::reviews($productId)
     */
    public static function hasMany($relatedModel, $foreignKey = null, $localId = null) {
        $db = new Database();
        $relatedTable = $relatedModel::getTable();
        $foreignKey = $foreignKey ?? 'product_id';

        $db->query("SELECT * FROM {$relatedTable} WHERE {$foreignKey} = :id ORDER BY id DESC");
        $db->bind('id', $localId);
        return $db->resultSet();
    }

    /**
     * Relasi Many to Many (Many-to-Many via Pivot Table)
     * Contoh: Product::tags($productId)
     */
    public static function belongsToMany($relatedModel, $pivotTable, $foreignPivotKey, $relatedPivotKey, $localId) {
        $db = new Database();
        $relatedTable = $relatedModel::getTable();

        $sql = "SELECT {$relatedTable}.* 
                FROM {$relatedTable} 
                INNER JOIN {$pivotTable} ON {$relatedTable}.id = {$pivotTable}.{$relatedPivotKey}
                WHERE {$pivotTable}.{$foreignPivotKey} = :local_id";

        $db->query($sql);
        $db->bind('local_id', $localId);
        return $db->resultSet();
    }
}
