<?php
/**
 * @var string $judul
 * @var array $reviews
 * @var array $products
 */
$reviews = $reviews ?? [];
$products = $products ?? [];
?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="fw-bold mb-1 text-dark">Kelola Ulasan & Rating Produk</h3>
        <p class="text-muted small mb-0">Tabel <code>product_reviews</code> berelasi <strong>One-to-Many</strong> dengan <code>produk</code>.</p>
    </div>
    <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahReview">
        <i class="bi bi-plus-lg me-1"></i> Tulis Ulasan Baru
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width: 70px;">ID</th>
                    <th>Produk yang Diulas</th>
                    <th>Nama Reviewer</th>
                    <th>Rating Bintang</th>
                    <th>Komentar Ulasan</th>
                    <th>Waktu Dibuat</th>
                    <th class="text-center pe-4" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reviews)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Belum ada ulasan ulasan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($reviews as $r): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#<?= $r['id'] ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($r['nama_produk']) ?></div>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill small px-2 py-0">
                                    <?= htmlspecialchars($r['kategori_produk']) ?>
                                </span>
                            </td>
                            <td>
                                <i class="bi bi-person-circle me-1 text-primary"></i><?= htmlspecialchars($r['reviewer_name']) ?>
                            </td>
                            <td>
                                <div class="text-warning small">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?= $i <= $r['rating'] ? '-fill' : '' ?>"></i>
                                    <?php endfor; ?>
                                    <span class="text-dark fw-bold ms-1">(<?= $r['rating'] ?>/5)</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary small"><?= htmlspecialchars($r['komentar']) ?></span>
                            </td>
                            <td class="text-muted small"><?= $r['created_at'] ?></td>
                            <td class="text-center pe-4">
                                <a href="<?= BASEURL ?>review/delete/<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus ulasan ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tulis Ulasan -->
<div class="modal fade" id="modalTambahReview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="<?= BASEURL ?>review/store" method="POST">
                <input type="hidden" name="_token" value="<?= Csrf::generateToken() ?>">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Tambah Ulasan Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 d-flex flex-column gap-3">
                    <div>
                        <label class="form-label fw-semibold">Pilih Produk</label>
                        <select name="product_id" class="form-select rounded-3" required>
                            <option value="">-- Pilih Produk --</option>
                            <?php foreach ($products as $prod): ?>
                                <option value="<?= $prod['id'] ?>"><?= htmlspecialchars($prod['nama']) ?> (ID: #<?= $prod['id'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Nama Reviewer</label>
                        <input type="text" name="reviewer_name" class="form-control rounded-3" placeholder="Contoh: Budi Santoso" required>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Rating (1 - 5 Bintang)</label>
                        <select name="rating" class="form-select rounded-3" required>
                            <option value="5">⭐⭐⭐⭐⭐ (5 Bintang - Sangat Puas)</option>
                            <option value="4">⭐⭐⭐⭐ (4 Bintang - Puas)</option>
                            <option value="3">⭐⭐⭐ (3 Bintang - Cukup)</option>
                            <option value="2">⭐⭐ (2 Bintang - Kurang)</option>
                            <option value="1">⭐ (1 Bintang - Sangat Kecewa)</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Komentar / Ulasan</label>
                        <textarea name="komentar" class="form-control rounded-3" rows="3" placeholder="Tuliskan pengalaman menggunakan produk ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>
