<?php
// app/models/Tag.php - Model Many-to-Many Tags Produk

require_once __DIR__ . '/Product.php';

class Tag extends Model {
    protected static $table = 'tags';
    protected static $primaryKey = 'id';

    /**
     * Relasi Many-to-Many: Mengambil semua produk yang memiliki tag ini
     * @param int $tagId
     * @return array
     */
    public static function products(int $tagId) {
        return static::belongsToMany(Product::class, 'product_tag', 'tag_id', 'product_id', $tagId);
    }
}
