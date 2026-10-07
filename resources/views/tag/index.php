<?php
/**
 * @var string $judul
 * @var array $tags
 */
$tags = $tags ?? [];
?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="fw-bold mb-1 text-dark">Kelola Master Tags</h3>
        <p class="text-muted small mb-0">Tabel <code>tags</code> terhubung dengan <code>produk</code> melalui relasi <strong>Many-to-Many</strong> (tabel pivot <code>product_tag</code>).</p>
    </div>
    <!-- Button Trigger Modal Tambah Tag -->
    <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahTag">
        <i class="bi bi-plus-lg me-1"></i> Tambah Tag Baru
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width: 70px;">ID</th>
                    <th>Nama Tag</th>
                    <th>Slug</th>
                    <th>Produk yang Terhubung (Many-to-Many)</th>
                    <th class="text-center pe-4" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tags)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada tag.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($tags as $t): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#<?= $t['id'] ?></td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 fw-semibold fs-6">
                                    <i class="bi bi-tag-fill me-1"></i><?= htmlspecialchars($t['nama_tag']) ?>
                                </span>
                            </td>
                            <td><code><?= htmlspecialchars($t['slug']) ?></code></td>
                            <td>
                                <?php if (!empty($t['products'])): ?>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php foreach ($t['products'] as $prod): ?>
                                            <span class="badge bg-light text-dark border rounded-pill px-2 py-1 small">
                                                <i class="bi bi-box me-1 text-primary"></i><?= htmlspecialchars($prod['nama']) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted small fst-italic">Belum dipasang ke produk mana pun</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <a href="<?= BASEURL ?>tag/delete/<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus tag ini?')">
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

<!-- Modal Tambah Tag -->
<div class="modal fade" id="modalTambahTag" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="<?= BASEURL ?>tag/store" method="POST">
                <input type="hidden" name="_token" value="<?= Csrf::generateToken() ?>">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Tambah Tag Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <label class="form-label fw-semibold">Nama Label / Tag</label>
                    <input type="text" name="nama_tag" class="form-control rounded-3" placeholder="Contoh: Flash Sale, New Arrival" required>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Tag</button>
                </div>
            </form>
        </div>
    </div>
</div>
