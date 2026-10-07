<!-- ================= BOOTSTRAP 5 FOOTER PARTIAL ================= -->
<footer class="border-top bg-body-tertiary py-5 mt-5">
  <div class="container">
    <div class="row g-4 mb-4">
      
      <!-- Brand & Description -->
      <div class="col-lg-5">
        <a href="<?= url('/') ?>" class="d-flex align-items-center gap-2 fw-bold text-decoration-none mb-3">
          <span class="fs-3 text-primary"><i class="fa-solid fa-bowl-food"></i></span>
          <span class="fs-4 fw-bold text-body">NyamCenter<span class="text-primary">.</span></span>
        </a>
        <p class="text-muted small mb-3" style="max-width: 380px;">
          Restoran & Bistro modern penyedia aneka kuliner Nusantara dan Fusion berkualitas tinggi, dibuat segar dengan cita rasa terbaik.
        </p>
        <div class="d-flex flex-wrap gap-2">
          <span class="badge bg-body border text-muted rounded-pill px-3 py-2"><i class="fa-solid fa-motorcycle me-1 text-primary"></i> Pesan Antar Cepat</span>
          <span class="badge bg-body border text-muted rounded-pill px-3 py-2"><i class="fa-solid fa-qrcode me-1 text-danger"></i> QRIS & E-Wallet</span>
          <span class="badge bg-body border text-muted rounded-pill px-3 py-2"><i class="fa-solid fa-shield-halved me-1 text-success"></i> Halal & Higienis</span>
        </div>
      </div>

      <!-- Operational Hours & Location -->
      <div class="col-lg-3 col-md-6">
        <h6 class="fw-bold mb-3"><i class="fa-regular fa-clock me-1 text-primary"></i> Jam Operasional</h6>
        <p class="text-muted small mb-1">Senin - Minggu: 09:00 - 22:00 WIB</p>
        <p class="text-muted small mb-3">Dapur tutup: 21:30 WIB</p>
        
        <h6 class="fw-bold mb-2"><i class="fa-solid fa-location-dot me-1 text-primary"></i> Lokasi Resto</h6>
        <p class="text-muted small mb-1">Jl. Boulevard Kuliner No. 88, Surabaya</p>
        <p class="text-muted small mb-0"><i class="fa-brands fa-whatsapp text-success me-1"></i> +62 812-3456-7890</p>
      </div>

      <!-- Payment Methods -->
      <div class="col-lg-4 col-md-6">
        <h6 class="fw-bold mb-3"><i class="fa-regular fa-credit-card me-1 text-primary"></i> Metode Pembayaran</h6>
        <div class="d-flex flex-wrap gap-2 mb-3">
          <span class="badge bg-body border text-body rounded-3 px-3 py-2">QRIS</span>
          <span class="badge bg-body border text-body rounded-3 px-3 py-2">GoPay</span>
          <span class="badge bg-body border text-body rounded-3 px-3 py-2">OVO</span>
          <span class="badge bg-body border text-body rounded-3 px-3 py-2">ShopeePay</span>
          <span class="badge bg-body border text-body rounded-3 px-3 py-2">BCA / Mandiri</span>
          <span class="badge bg-body border text-body rounded-3 px-3 py-2">COD</span>
        </div>
      </div>

    </div>

    <hr class="border-secondary opacity-25 my-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-muted gap-2">
      <div>&copy; <?= date('Y') ?> <strong>NyamCenter</strong>. All rights reserved.</div>
      <div>Ditenagai oleh <strong>Inainu MVC & Bootstrap 5</strong></div>
    </div>
  </div>
</footer>
