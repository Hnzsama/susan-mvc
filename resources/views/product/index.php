<?php
/**
 * @var string $judul
 * @var array $produk
 */
$produk = $produk ?? [];
?>
<!-- resources/views/product/index.php -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="fw-bold mb-1 text-dark">Katalog Produk & Relasi Data</h3>
        <p class="text-muted small mb-0">Menampilkan data produk lengkap dengan relasi ORM (1-to-1 Detail, 1-to-Many Reviews, Many-to-Many Tags).</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASEURL ?>product/create" class="btn btn-primary rounded-pill px-3 shadow-sm d-flex align-items-center gap-1">
            <i class="bi bi-plus-lg"></i> Tambah Produk
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width: 70px;">ID</th>
                    <th style="min-width: 220px;">Produk & Tags (N:M)</th>
                    <th style="min-width: 140px;">Kategori</th>
                    <th style="min-width: 240px;">Detail & Garansi (1:1)</th>
                    <th style="min-width: 160px;">Rating & Review (1:N)</th>
                    <th style="min-width: 140px;">Harga & Stok</th>
                    <th class="text-center pe-4" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produk)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                            Tidak ada data produk ditemukan.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produk as $p): ?>
                        <tr>
                            <!-- ID -->
                            <td class="ps-4 text-muted fw-bold">#<?= $p['id'] ?></td>

                            <!-- Nama Produk, Foto dari Storage & Many-to-Many Tags -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (!empty($p['gambar'])): ?>
                                        <img src="<?= Storage::url($p['gambar']) ?>" alt="Foto" class="rounded-3 border object-fit-cover shadow-sm flex-shrink-0" style="width: 48px; height: 48px;">
                                    <?php else: ?>
                                        <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted flex-shrink-0" style="width: 48px; height: 48px;">
                                            <i class="bi bi-image text-secondary fs-5"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($p['nama']) ?></div>
                                        <!-- Relasi Many-to-Many Tags -->
                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                            <?php if (!empty($p['tags'])): ?>
                                                <?php foreach ($p['tags'] as $tag): ?>
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill small px-2 py-0">
                                                        <i class="bi bi-tag-fill me-1 small"></i><?= htmlspecialchars($tag['nama_tag']) ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-2 fw-medium">
                                    <?= htmlspecialchars($p['kategori']) ?>
                                </span>
                            </td>

                            <!-- Relasi 1-to-1 Detail Spesifikasi -->
                            <td>
                                <?php if (!empty($p['detail'])): ?>
                                    <div class="small mb-1 text-dark fw-semibold">
                                        <i class="bi bi-shield-check text-success me-1"></i>Garansi: <?= $p['detail']['garansi_bulan'] ?> Bulan
                                        <span class="text-muted fw-normal ms-2">| Berat: <?= $p['detail']['berat_gram'] ?>g</span>
                                    </div>
                                    <div class="small text-muted text-truncate" style="max-width: 260px;" title="<?= htmlspecialchars($p['detail']['deskripsi']) ?>">
                                        <?= htmlspecialchars($p['detail']['deskripsi']) ?>
                                    </div>
                                    <?php if (!empty($p['detail']['spesifikasi'])): ?>
                                        <div class="small text-secondary font-monospace mt-1 bg-light rounded px-2 py-1">
                                            <i class="bi bi-cpu me-1"></i><?= htmlspecialchars($p['detail']['spesifikasi']) ?>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small">Belum ada detail spesifikasi</span>
                                <?php endif; ?>
                            </td>

                            <!-- Relasi 1-to-Many Review & Rating -->
                            <td>
                                <?php if ($p['total_reviews'] > 0): ?>
                                    <div class="d-flex align-items-center gap-1 mb-1">
                                        <div class="text-warning fw-bold small">
                                            <i class="bi bi-star-fill"></i> <?= $p['avg_rating'] ?>
                                        </div>
                                        <span class="text-muted small">(<?= $p['total_reviews'] ?> ulasan)</span>
                                    </div>
                                    <!-- Tombol Trigger Modal Review -->
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-0 small" data-bs-toggle="modal" data-bs-target="#modalReview<?= $p['id'] ?>">
                                        <i class="bi bi-chat-left-text me-1"></i>Lihat Ulasan
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted small fst-italic">Belum ada ulasan</span>
                                <?php endif; ?>
                            </td>

                            <!-- Harga & Stok -->
                            <td>
                                <div class="fw-bold text-primary">Rp <?= number_format($p['harga'], 0, ',', '.') ?></div>
                                <div class="mt-1">
                                    <span class="badge <?= $p['stok'] > 5 ? 'bg-success-subtle text-success-emphasis border border-success-subtle' : 'bg-danger-subtle text-danger-emphasis border border-danger-subtle' ?> rounded-pill px-2 py-1">
                                        <i class="bi bi-box-seam me-1"></i><?= $p['stok'] ?> unit
                                    </span>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="text-center pe-4">
                                <div class="btn-group">
                                    <a href="<?= BASEURL ?>product/edit/<?= $p['id'] ?>" class="btn btn-sm btn-outline-warning rounded-start-pill px-3" title="Edit Produk">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= BASEURL ?>product/delete/<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger rounded-end-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" title="Hapus Produk">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Review (1-to-Many) untuk Produk Ini -->
                        <?php if ($p['total_reviews'] > 0): ?>
                            <div class="modal fade" id="modalReview<?= $p['id'] ?>" tabindex="-1" aria-labelledby="modalReviewLabel<?= $p['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-bottom">
                                            <div>
                                                <h5 class="modal-title fw-bold" id="modalReviewLabel<?= $p['id'] ?>">Ulasan Pembeli: <?= htmlspecialchars($p['nama']) ?></h5>
                                                <div class="text-warning small mt-1">
                                                    <i class="bi bi-star-fill"></i> <?= $p['avg_rating'] ?> / 5.0 (Total <?= $p['total_reviews'] ?> ulasan)
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="d-flex flex-column gap-3">
                                                <?php foreach ($p['reviews'] as $rev): ?>
                                                    <div class="p-3 rounded-3 bg-light border">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <strong class="text-dark"><i class="bi bi-person-circle me-1 text-primary"></i><?= htmlspecialchars($rev['reviewer_name']) ?></strong>
                                                            <div class="text-warning small">
                                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                    <i class="bi bi-star<?= $i <= $rev['rating'] ? '-fill' : '' ?>"></i>
                                                                <?php endfor; ?>
                                                            </div>
                                                        </div>
                                                        <p class="text-secondary small mb-1"><?= htmlspecialchars($rev['komentar']) ?></p>
                                                        <span class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i><?= $rev['created_at'] ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top">
                                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
