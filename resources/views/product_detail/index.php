<?php
/**
 * @var string $judul
 * @var array $details
 */
$details = $details ?? [];
?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="fw-bold mb-1 text-dark">Kelola Detail Spesifikasi Produk</h3>
        <p class="text-muted small mb-0">Tabel <code>product_details</code> berelasi <strong>One-to-One</strong> dengan <code>produk</code> (1 produk memiliki tepat 1 detail spesifikasi).</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width: 70px;">ID</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi Lengkap</th>
                    <th>Spesifikasi Hardware</th>
                    <th>Berat</th>
                    <th>Masa Garansi</th>
                    <th class="text-center pe-4" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($details)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Belum ada data detail produk.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($details as $d): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#<?= $d['id'] ?></td>
                            <td>
                                <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($d['nama_produk']) ?></div>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill small px-2 py-0">
                                    <?= htmlspecialchars($d['kategori']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="small text-secondary"><?= htmlspecialchars($d['deskripsi']) ?></span>
                            </td>
                            <td>
                                <code class="small text-dark bg-light px-2 py-1 rounded d-inline-block">
                                    <?= htmlspecialchars($d['spesifikasi'] ?? '-') ?>
                                </code>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= $d['berat_gram'] ?> gram</span></td>
                            <td>
                                <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle rounded-pill px-3 py-1">
                                    <i class="bi bi-shield-check me-1"></i><?= $d['garansi_bulan'] ?> Bulan
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="<?= BASEURL ?>product-detail/delete/<?= $d['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus data detail ini?')">
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
