<?php
// app/models/Product.php - Model Produk dengan ORM & Relasi Lengkap (1-1, 1-N, N-M)

require_once __DIR__ . '/ProductDetail.php';
require_once __DIR__ . '/ProductReview.php';
require_once __DIR__ . '/Tag.php';

class Product extends Model {
    protected static $table = 'produk';
    protected static $primaryKey = 'id';

    /**
     * Relasi 1-to-1 (One-to-One): Mengambil detail spesifikasi produk
     * @param int $productId
     * @return array|false
     */
    public static function detail(int $productId) {
        return static::hasOne(ProductDetail::class, 'product_id', $productId);
    }

    /**
     * Relasi 1-to-Many (One-to-Many): Mengambil semua ulasan/review untuk produk ini
     * @param int $productId
     * @return array
     */
    public static function reviews(int $productId) {
        return static::hasMany(ProductReview::class, 'product_id', $productId);
    }

    /**
     * Relasi Many-to-Many (Many-to-Many): Mengambil semua label/tags produk via tabel pivot
     * @param int $productId
     * @return array
     */
    public static function tags(int $productId) {
        return static::belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id', $productId);
    }

    /**
     * Contoh Custom SQL JOIN Query di Model: Ambil Produk beserta Detail & Ringkasan Rating
     * @return array
     */
    public static function allWithDetails() {
        $sql = "SELECT p.*, d.deskripsi, d.berat_gram, d.garansi_bulan, d.spesifikasi,
                       COUNT(r.id) as total_review, AVG(r.rating) as avg_rating
                FROM produk p
                LEFT JOIN product_details d ON p.id = d.product_id
                LEFT JOIN product_reviews r ON p.id = r.product_id
                GROUP BY p.id
                ORDER BY p.id DESC";
        return static::rawQuery($sql);
    }
}
