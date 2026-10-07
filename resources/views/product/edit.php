<?php
/**
 * @var string $judul
 * @var array $produk
 */
$produk = $produk ?? ['id' => '', 'nama' => '', 'kategori' => '', 'harga' => 0, 'stok' => 0, 'gambar' => ''];
?>
<!-- resources/views/product/edit.php -->
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0 text-warning">
                    <i class="bi bi-pencil-square me-2"></i>Edit Produk #<?= $produk['id'] ?>
                </h5>
            </div>
            <div class="card-body p-4 pt-2">
                <form action="<?= BASEURL ?>product/update" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $produk['id'] ?>">

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" class="form-control rounded-3" id="nama" name="nama" required value="<?= htmlspecialchars($produk['nama']) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <input type="text" class="form-control rounded-3" id="kategori" name="kategori" required value="<?= htmlspecialchars($produk['kategori']) ?>">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="harga" class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number" class="form-control rounded-3" id="harga" name="harga" required value="<?= $produk['harga'] ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="stok" class="form-label fw-semibold">Stok</label>
                            <input type="number" class="form-control rounded-3" id="stok" name="stok" required value="<?= $produk['stok'] ?>">
                        </div>
                    </div>

                    <!-- Upload & Preview Foto Produk -->
                    <div class="mb-4">
                        <label for="gambar" class="form-label fw-semibold">
                            <i class="bi bi-image text-primary me-1"></i>Foto Produk (Ganti Gambar)
                        </label>
                        <?php if (!empty($produk['gambar'])): ?>
                            <div class="d-flex align-items-center gap-3 p-2 border rounded-3 bg-light mb-2">
                                <img src="<?= Storage::url($produk['gambar']) ?>" alt="Foto Produk" class="rounded-3 shadow-sm object-fit-cover" style="width: 60px; height: 60px;">
                                <div class="small">
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 250px;"><?= htmlspecialchars($produk['gambar']) ?></div>
                                    <span class="badge bg-success-subtle text-success-emphasis">Foto Aktif di Storage</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control rounded-3" id="gambar" name="gambar" accept="image/*">
                        <div class="form-text small">Pilih file baru jika ingin mengganti gambar produk. Format: JPG, PNG, WEBP.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= BASEURL ?>product" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-warning rounded-pill px-4 fw-semibold">Update Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
