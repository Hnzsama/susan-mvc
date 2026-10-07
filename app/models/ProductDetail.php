<?php
// app/models/ProductDetail.php - Model 1-to-1 Detail Produk

require_once __DIR__ . '/Product.php';

class ProductDetail extends Model {
    protected static $table = 'product_details';
    protected static $primaryKey = 'id';

    /**
     * Relasi Inverse: Mengambil produk pemilik detail ini
     * @param int $detailId
     * @return array|false|null
     */
    public static function product(int $detailId) {
        $detail = static::find($detailId);
        if (!$detail) return null;
        return Product::find($detail['product_id']);
    }

    /**
     * Mengambil semua data detail lengkap dengan data produknya via ORM
     * @return array
     */
    public static function allWithProduct(): array {
        $details = static::all();
        foreach ($details as &$d) {
            $prod = Product::find($d['product_id']);
            $d['product'] = $prod;
            $d['nama_produk'] = $prod['nama'] ?? '-';
            $d['kategori'] = $prod['kategori'] ?? '-';
            $d['harga'] = $prod['harga'] ?? 0;
            $d['stok'] = $prod['stok'] ?? 0;
        }
        return $details;
    }
}
