<?php
/**
 * @var string $judul
 * @var array $students
 */
$students = $students ?? [];
?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="fw-bold mb-1 text-dark">Daftar Data Siswa (Student)</h3>
        <p class="text-muted small mb-0">Tabel <code>student</code> dari migrasi <code>m0003_create_students_table</code>.</p>
    </div>
    <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahStudent">
        <i class="bi bi-plus-lg me-1"></i> Tambah Siswa Baru
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width: 70px;">ID</th>
                    <th>Nama Siswa</th>
                    <th>Kategori / Kelas</th>
                    <th>Biaya SPP (Harga)</th>
                    <th>Poin / Stok</th>
                    <th class="text-center pe-4" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($students)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada data siswa.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($students as $s): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#<?= $s['id'] ?></td>
                            <td class="fw-bold text-dark"><?= htmlspecialchars($s['nama']) ?></td>
                            <td><span class="badge bg-info-subtle text-info-emphasis rounded-pill px-3 py-2"><?= htmlspecialchars($s['kategori']) ?></span></td>
                            <td class="fw-semibold text-primary">Rp <?= number_format($s['harga'] ?? 0, 0, ',', '.') ?></td>
                            <td><span class="badge bg-secondary rounded-pill"><?= $s['stok'] ?? 0 ?></span></td>
                            <td class="text-center pe-4">
                                <a href="<?= BASEURL ?>student/delete/<?= $s['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus siswa ini?')">
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

<!-- Modal Tambah Student -->
<div class="modal fade" id="modalTambahStudent" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="<?= BASEURL ?>student/store" method="POST">
                <input type="hidden" name="_token" value="<?= Csrf::generateToken() ?>">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Tambah Siswa Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 d-flex flex-column gap-3">
                    <div>
                        <label class="form-label fw-semibold">Nama Siswa</label>
                        <input type="text" name="nama" class="form-control rounded-3" placeholder="Contoh: Rian Pratama" required>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Jurusan / Kategori</label>
                        <input type="text" name="kategori" class="form-control rounded-3" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Biaya SPP</label>
                        <input type="number" name="harga" class="form-control rounded-3" value="250000" required>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Poin Presensi</label>
                        <input type="number" name="stok" class="form-control rounded-3" value="100" required>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Siswa</button>
                </div>
            </form>
        </div>
    </div>
</div>
