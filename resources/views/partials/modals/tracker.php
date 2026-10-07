<!-- ================= BOOTSTRAP 5 MODAL: LIVE ORDER TRACKER & STRUK ================= -->
<div class="modal fade" id="tracker-modal-backdrop" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" id="tracker-modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      
      <div class="modal-header border-bottom p-4">
        <div>
          <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-1 mb-2">
            <i class="fa-solid fa-circle-dot me-1"></i> Pesanan Aktif Real-Time
          </span>
          <h5 class="modal-title fw-bold" id="tracker-headline">Pesanan Sedang Diproses!</h5>
          <small class="text-muted">ID Pesanan: <strong id="tracker-order-id">#SAV-12345</strong></small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="tracker-modal-close" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <!-- Timeline Stepper List Group -->
        <div class="list-group list-group-flush mb-4" id="order-stepper">
          <div class="list-group-item d-flex gap-3 py-3 border-0 bg-transparent" id="step-1">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; flex-shrink: 0;">
              <i class="fa-solid fa-clipboard-check"></i>
            </div>
            <div>
              <h6 class="fw-bold mb-1">Pesanan Diterima</h6>
              <p class="text-muted small mb-1">Pesanan telah diverifikasi oleh kasir & sistem.</p>
              <small class="text-primary fw-semibold" id="step-1-time">Baru saja</small>
            </div>
          </div>

          <div class="list-group-item d-flex gap-3 py-3 border-0 bg-transparent" id="step-2">
            <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; flex-shrink: 0;">
              <i class="fa-solid fa-kitchen-set"></i>
            </div>
            <div>
              <h6 class="fw-bold mb-1">Sedang Dimasak oleh Chef</h6>
              <p class="text-muted small mb-1">Bahan segar sedang diracik dengan higienis.</p>
              <small class="text-warning fw-semibold" id="step-2-time">Estimasi 12 Menit</small>
            </div>
          </div>

          <div class="list-group-item d-flex gap-3 py-3 border-0 bg-transparent opacity-50" id="step-3">
            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; flex-shrink: 0;">
              <i class="fa-solid fa-motorcycle"></i>
            </div>
            <div>
              <h6 class="fw-bold mb-1" id="step-3-title">Dalam Pengantaran</h6>
              <p class="text-muted small mb-1" id="step-3-desc">Driver membawa makanan hangat menuju alamat Anda.</p>
              <small class="text-muted" id="step-3-time">Menunggu penjemputan</small>
            </div>
          </div>

          <div class="list-group-item d-flex gap-3 py-3 border-0 bg-transparent opacity-50" id="step-4">
            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; flex-shrink: 0;">
              <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
              <h6 class="fw-bold mb-1" id="step-4-title">Tiba di Tujuan & Selesai</h6>
              <p class="text-muted small mb-1">Selamat menikmati hidangan lezat NyamCenter!</p>
              <small class="text-muted" id="step-4-time">Estimasi 25 Menit</small>
            </div>
          </div>
        </div>

        <!-- Quick Fast-Forward Simulation Controller -->
        <div class="alert alert-warning d-flex justify-content-between align-items-center p-3 mb-4 rounded-3">
          <small class="me-2"><i class="fa-regular fa-lightbulb me-1"></i> Simulasi otomatis berlangsung setiap beberapa detik:</small>
          <button class="btn btn-sm btn-warning rounded-pill fw-semibold" id="fast-forward-step-btn">
            <i class="fa-solid fa-forward-step me-1"></i> Percepat Status
          </button>
        </div>

        <!-- Printable Digital Receipt -->
        <div class="card bg-body-tertiary border rounded-3 p-4 font-monospace" id="printable-receipt">
          <div class="text-center mb-3">
            <h6 class="fw-bold mb-0"><i class="fa-solid fa-bowl-food me-1"></i> NYAMCENTER BITES & BISTRO</h6>
            <small class="text-muted">Jl. Boulevard Kuliner No. 88, Surabaya</small>
            <hr class="border-secondary my-2">
          </div>

          <div class="small mb-3">
            <div class="d-flex justify-content-between"><span>No. Transaksi:</span><strong id="receipt-id">#NYAM-0000</strong></div>
            <div class="d-flex justify-content-between"><span>Waktu:</span><span id="receipt-date">21/09/2026, 12:00</span></div>
            <div class="d-flex justify-content-between"><span>Pelanggan:</span><span id="receipt-customer">Kristina</span></div>
            <div class="d-flex justify-content-between"><span>Metode / Layanan:</span><span id="receipt-type">Delivery (QRIS)</span></div>
            <div class="d-flex justify-content-between"><span>Tujuan / Meja:</span><span id="receipt-address">Jl. Mawar No. 12</span></div>
            <hr class="border-secondary my-2">
          </div>

          <!-- Receipt Item List -->
          <div class="small mb-3" id="receipt-items-list">
            <!-- Rendered via JS -->
          </div>

          <div class="small mb-3">
            <hr class="border-secondary my-2">
            <div class="d-flex justify-content-between"><span>Subtotal:</span><span id="rc-subtotal">Rp 0</span></div>
            <div class="d-flex justify-content-between text-success" id="rc-discount-row" style="display: none !important;"><span>Diskon Kupon:</span><span id="rc-discount">-Rp 0</span></div>
            <div class="d-flex justify-content-between"><span>Ongkir:</span><span id="rc-shipping">Rp 12.000</span></div>
            <div class="d-flex justify-content-between"><span>Pajak Resto (10%):</span><span id="rc-tax">Rp 0</span></div>
            <hr class="border-secondary my-2">
            <div class="d-flex justify-content-between fs-6 fw-bold"><span>TOTAL BAYAR:</span><span class="text-primary" id="rc-grand-total">Rp 0</span></div>
          </div>

          <div class="text-center small text-muted">
            <p class="mb-0 fw-bold text-success">*** LUNAS / PAID ***</p>
            <p class="mb-0">Terima kasih telah memesan di NyamCenter!</p>
          </div>
        </div>
      </div>

      <div class="modal-footer d-flex justify-content-between p-3 border-top bg-body">
        <button type="button" class="btn btn-outline-secondary rounded-pill px-3" id="print-receipt-btn">
          <i class="fa-solid fa-print me-1"></i> Cetak Struk
        </button>
        <button type="button" class="btn btn-primary rounded-pill px-4" id="order-again-btn" data-bs-dismiss="modal">
          <i class="fa-solid fa-bag-shopping me-1"></i> Pesan Menu Lain
        </button>
      </div>

    </div>
  </div>
</div>
