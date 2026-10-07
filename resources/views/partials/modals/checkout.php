<!-- ================= BOOTSTRAP 5 MODAL: CHECKOUT & PEMBAYARAN ================= -->
<div class="modal fade" id="checkout-modal-backdrop" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" id="checkout-modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow overflow-hidden">
      
      <div class="modal-header border-bottom p-3 p-md-4 bg-body">
        <div class="d-flex align-items-center gap-3">
          <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; flex-shrink: 0;">
            <i class="fa-solid fa-bag-shopping fs-5"></i>
          </div>
          <div>
            <h5 class="modal-title fw-bold mb-0 text-body">Formulir Pesanan & Pembayaran</h5>
            <small class="text-muted">Lengkapi detail untuk memproses pesanan lezat Anda</small>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="checkout-modal-close" aria-label="Close"></button>
      </div>

      <div class="modal-body p-3 p-md-4">
        <form id="checkout-form" onsubmit="return false;">
          <!-- Tipe Layanan Pesanan -->
          <div class="mb-4">
            <label class="form-label fw-bold small text-body mb-2">Tipe Layanan Pesanan</label>
            <div class="row g-2">
              <div class="col-4">
                <input type="radio" class="btn-check" name="orderType" id="order-type-delivery" value="delivery" checked autocomplete="off">
                <label class="service-type-card w-100 h-100 d-flex flex-column align-items-center justify-content-center gap-1" for="order-type-delivery">
                  <i class="fa-solid fa-motorcycle fs-5 mb-1"></i>
                  <span class="fw-bold small">Pesan Antar</span>
                  <small class="text-muted" style="font-size: 11px;">Antar Alamat</small>
                </label>
              </div>
              <div class="col-4">
                <input type="radio" class="btn-check" name="orderType" id="order-type-dinein" value="dinein" autocomplete="off">
                <label class="service-type-card w-100 h-100 d-flex flex-column align-items-center justify-content-center gap-1" for="order-type-dinein">
                  <i class="fa-solid fa-utensils fs-5 mb-1"></i>
                  <span class="fw-bold small">Dine In</span>
                  <small class="text-muted" style="font-size: 11px;">Makan di Tempat</small>
                </label>
              </div>
              <div class="col-4">
                <input type="radio" class="btn-check" name="orderType" id="order-type-takeaway" value="takeaway" autocomplete="off">
                <label class="service-type-card w-100 h-100 d-flex flex-column align-items-center justify-content-center gap-1" for="order-type-takeaway">
                  <i class="fa-solid fa-box-archive fs-5 mb-1"></i>
                  <span class="fw-bold small">Takeaway</span>
                  <small class="text-muted" style="font-size: 11px;">Bawa Pulang</small>
                </label>
              </div>
            </div>
          </div>

          <!-- Data Pemesan -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold small text-body" for="cust-name">
                <i class="fa-regular fa-user me-1 text-primary"></i> Nama Pemesan <span class="text-danger">*</span>
              </label>
              <input type="text" id="cust-name" class="form-control rounded-3 py-2 bg-body border shadow-none" placeholder="Masukkan nama Anda" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold small text-body" for="cust-phone">
                <i class="fa-brands fa-whatsapp me-1 text-success"></i> Nomor WhatsApp <span class="text-danger">*</span>
              </label>
              <input type="tel" id="cust-phone" class="form-control rounded-3 py-2 bg-body border shadow-none" placeholder="08123456789" required>
            </div>
          </div>

          <!-- Dynamic Destination Input -->
          <div class="mb-4" id="destination-group">
            <label class="form-label fw-semibold small text-body" id="destination-label" for="cust-destination">
              <i class="fa-solid fa-location-dot me-1 text-danger"></i> Alamat Pengiriman Lengkap <span class="text-danger">*</span>
            </label>
            <textarea 
              id="cust-destination" 
              class="form-control rounded-3 py-2 bg-body border shadow-none" 
              rows="2" 
              placeholder="Jl. Mawar No. 12, Kel. Sukolilo, Surabaya (Patokan depan minimarket)"
              required
            ></textarea>
          </div>

          <!-- Pilihan Metode Pembayaran -->
          <div class="mb-4">
            <label class="form-label fw-bold small text-body mb-2">Metode Pembayaran</label>
            <div class="row g-2">
              <div class="col-md-6">
                <input type="radio" class="btn-check" name="paymentMethod" id="pm-qris" value="qris" checked autocomplete="off">
                <label class="payment-card w-100" for="pm-qris">
                  <span class="fs-4 text-danger"><i class="fa-solid fa-qrcode"></i></span>
                  <div class="flex-grow-1">
                    <strong class="d-block small text-body">QRIS Dinamis</strong>
                    <small class="text-muted" style="font-size: 11px;">GoPay, OVO, Dana, ShopeePay, BCA</small>
                  </div>
                </label>
              </div>
              <div class="col-md-6">
                <input type="radio" class="btn-check" name="paymentMethod" id="pm-ewallet" value="ewallet" autocomplete="off">
                <label class="payment-card w-100" for="pm-ewallet">
                  <span class="fs-4 text-info"><i class="fa-solid fa-wallet"></i></span>
                  <div class="flex-grow-1">
                    <strong class="d-block small text-body">E-Wallet Instan</strong>
                    <small class="text-muted" style="font-size: 11px;">GoPay / OVO / ShopeePay / DANA</small>
                  </div>
                </label>
              </div>
              <div class="col-md-6">
                <input type="radio" class="btn-check" name="paymentMethod" id="pm-va" value="va" autocomplete="off">
                <label class="payment-card w-100" for="pm-va">
                  <span class="fs-4 text-warning"><i class="fa-solid fa-building-columns"></i></span>
                  <div class="flex-grow-1">
                    <strong class="d-block small text-body">Transfer VA Bank</strong>
                    <small class="text-muted" style="font-size: 11px;">BCA, Mandiri, BRI Virtual Account</small>
                  </div>
                </label>
              </div>
              <div class="col-md-6">
                <input type="radio" class="btn-check" name="paymentMethod" id="pm-cash" value="cash" autocomplete="off">
                <label class="payment-card w-100" for="pm-cash">
                  <span class="fs-4 text-success"><i class="fa-solid fa-money-bill-wave"></i></span>
                  <div class="flex-grow-1">
                    <strong class="d-block small text-body">Bayar Tunai / COD</strong>
                    <small class="text-muted" style="font-size: 11px;">Bayar saat makanan tiba</small>
                  </div>
                </label>
              </div>
            </div>
          </div>

          <!-- Ringkasan Checkout Box -->
          <div class="card bg-body-tertiary border-0 rounded-4 p-3 mb-2 small shadow-sm">
            <div class="fw-bold mb-2 text-body">Ringkasan Biaya Akhir</div>
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Total Menu (<span id="co-item-count">0</span> item):</span>
              <span class="fw-semibold text-body" id="co-subtotal">Rp 0</span>
            </div>
            <div class="d-flex justify-content-between mb-1 text-success" id="co-discount-row" style="display: none !important;">
              <span>Potongan Voucher:</span>
              <span class="fw-semibold" id="co-discount">-Rp 0</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Biaya Layanan & Ongkir:</span>
              <span class="fw-semibold text-body" id="co-shipping">Rp 12.000</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted">Pajak Restoran PB1 (10%):</span>
              <span class="fw-semibold text-body" id="co-tax">Rp 0</span>
            </div>
            <hr class="my-2 border-secondary opacity-25">
            <div class="d-flex justify-content-between align-items-center fs-6 fw-bold">
              <span class="text-body">Total Tagihan:</span>
              <span class="text-primary fs-5" id="co-total">Rp 0</span>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer d-flex justify-content-between align-items-center p-3 border-top bg-body">
        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" id="checkout-cancel-btn" data-bs-dismiss="modal">
          <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </button>
        <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm d-flex align-items-center gap-2" id="confirm-payment-btn">
          <span>Konfirmasi & Bayar</span>
          <span class="badge bg-white text-primary rounded-pill px-2 py-1 fw-bold" id="confirm-payment-amount">Rp 0</span>
        </button>
      </div>

    </div>
  </div>
</div>
