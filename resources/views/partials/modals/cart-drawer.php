<!-- ================= BOOTSTRAP 5 OFFCANVAS CART DRAWER ================= -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="cart-drawer" aria-labelledby="cart-drawer-label" style="width: 450px; max-width: 100vw;">
  <div class="offcanvas-header border-bottom">
    <div class="d-flex align-items-center gap-2">
      <span class="text-primary fs-5"><i class="fa-solid fa-cart-shopping"></i></span>
      <h5 class="offcanvas-title fw-bold mb-0" id="cart-drawer-label">Keranjang Belanja</h5>
      <span class="badge bg-primary rounded-pill ms-2" id="drawer-item-count">0 item</span>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" id="cart-close-btn" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body d-flex flex-column p-3 gap-3">
    <!-- Free Delivery Progress Bar -->
    <div class="card bg-body-tertiary border-0 rounded-3 p-3">
      <div class="d-flex justify-content-between align-items-center mb-2 small fw-semibold">
        <span><i class="fa-solid fa-motorcycle text-success me-1"></i> <span id="free-shipping-text">Tambah Rp 25.000 lagi untuk Gratis Ongkir!</span></span>
      </div>
      <div class="progress" style="height: 6px;">
        <div class="progress-bar bg-success" id="shipping-progress-fill" role="progressbar" style="width: 0%;"></div>
      </div>
    </div>

    <!-- Cart Item List -->
    <div class="cart-items-container flex-grow-1 overflow-auto" id="cart-items-container">
      <!-- Rendered via JS -->
    </div>

    <!-- Voucher Promo Box -->
    <div class="card bg-body-tertiary border-0 rounded-3 p-3">
      <div class="input-group">
        <input 
          type="text" 
          id="voucher-input" 
          class="form-control bg-body border rounded-start-pill text-uppercase px-3" 
          placeholder="Kode voucher promo..." 
          autocomplete="off"
        >
        <button class="btn btn-primary rounded-end-pill px-3 fw-semibold" id="apply-voucher-btn">Terapkan</button>
      </div>
      <div class="alert alert-success d-flex justify-content-between align-items-center py-2 px-3 mt-2 mb-0 rounded-3" id="applied-voucher-alert" style="display: none !important;">
        <div class="small">
          <i class="fa-solid fa-ticket me-1"></i> <strong id="applied-voucher-code">KODE</strong>
          <span class="ms-2 text-muted" id="applied-voucher-desc">Hemat Rp 20.000</span>
        </div>
        <button type="button" class="btn-close btn-close-sm" id="remove-voucher-btn" title="Hapus voucher"></button>
      </div>
    </div>

    <!-- Cart Calculations -->
    <div class="card bg-body-tertiary border-0 rounded-3 p-3 small">
      <div class="d-flex justify-content-between mb-1">
        <span class="text-muted">Subtotal Item</span>
        <span class="fw-semibold" id="summary-subtotal">Rp 0</span>
      </div>
      <div class="d-flex justify-content-between mb-1 text-success" id="summary-discount-row" style="display: none !important;">
        <span>Diskon Voucher</span>
        <span class="fw-semibold" id="summary-discount">-Rp 0</span>
      </div>
      <div class="d-flex justify-content-between mb-1">
        <span class="text-muted">Ongkos Kirim</span>
        <span class="fw-semibold" id="summary-shipping">Rp 12.000</span>
      </div>
      <div class="d-flex justify-content-between mb-2">
        <span class="text-muted">Pajak Restoran (PB1 10%)</span>
        <span class="fw-semibold" id="summary-tax">Rp 0</span>
      </div>
      <hr class="my-2">
      <div class="d-flex justify-content-between align-items-center fs-6 fw-bold">
        <span>Total Pembayaran</span>
        <span class="text-primary fs-5" id="summary-grand-total">Rp 0</span>
      </div>
    </div>
  </div>

  <div class="offcanvas-footer p-3 border-top bg-body">
    <button class="btn btn-primary w-100 py-2 fw-semibold rounded-pill" id="proceed-to-checkout-btn">
      <span>Lanjut ke Pembayaran</span>
      <i class="fa-solid fa-arrow-right ms-2"></i>
    </button>
  </div>
</div>
