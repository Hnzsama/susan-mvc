<?php
// app/models/ProductReview.php - Model 1-to-Many Review Produk

require_once __DIR__ . '/Product.php';

class ProductReview extends Model {
    protected static $table = 'product_reviews';
    protected static $primaryKey = 'id';

    /**
     * Relasi Inverse: Mengambil produk yang diulas
     * @param int $reviewId
     * @return array|false|null
     */
    public static function product(int $reviewId) {
        $review = static::find($reviewId);
        if (!$review) return null;
        return Product::find($review['product_id']);
    }

    /**
     * Mengambil semua ulasan lengkap dengan data produknya via ORM
     * @return array
     */
    public static function allWithProduct(): array {
        $reviews = static::all();
        foreach ($reviews as &$r) {
            $prod = Product::find($r['product_id']);
            $r['product'] = $prod;
            $r['nama_produk'] = $prod['nama'] ?? '-';
            $r['kategori_produk'] = $prod['kategori'] ?? '-';
        }
        return $reviews;
    }
}
