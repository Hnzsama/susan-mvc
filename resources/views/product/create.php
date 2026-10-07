<!-- resources/views/product/create.php -->
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0 text-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Produk Baru
                </h5>
            </div>
            <div class="card-body p-4 pt-2">
                <form action="<?= BASEURL ?>product/store" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" class="form-control rounded-3" id="nama" name="nama" required placeholder="Contoh: SSD NVMe 1TB">
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <input type="text" class="form-control rounded-3" id="kategori" name="kategori" required placeholder="Contoh: Hardware / Aksesoris">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="harga" class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number" class="form-control rounded-3" id="harga" name="harga" required placeholder="1250000">
                        </div>
                        <div class="col-md-6">
                            <label for="stok" class="form-label fw-semibold">Stok</label>
                            <input type="number" class="form-control rounded-3" id="stok" name="stok" required value="10">
                        </div>
                    </div>

                    <!-- Input Upload Foto Produk (Storage Engine) -->
                    <div class="mb-4">
                        <label for="gambar" class="form-label fw-semibold">
                            <i class="bi bi-image text-primary me-1"></i>Foto Produk (Opsional - Storage)
                        </label>
                        <input type="file" class="form-control rounded-3" id="gambar" name="gambar" accept="image/*">
                        <div class="form-text small">Format: JPG, PNG, WEBP (Maksimal 2 MB). Disimpan via <code>Storage::putFile()</code>.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= BASEURL ?>product" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
