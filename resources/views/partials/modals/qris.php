<!-- ================= BOOTSTRAP 5 MODAL: SIMULASI PEMBAYARAN QRIS ================= -->
<div class="modal fade" id="qris-modal-backdrop" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;" id="qris-modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow text-center p-4">
      
      <div class="mb-3">
        <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold fs-6 mb-1">QRIS</span>
        <h6 class="fw-bold mb-0">NYAMCENTER BISTRO & KULINER</h6>
        <small class="text-muted">Inv: <span id="qris-invoice-id">#NYAM-88912</span></small>
      </div>

      <!-- QR Code Dynamic Render -->
      <div class="d-flex flex-column align-items-center mb-3">
        <div class="p-3 bg-white rounded-3 shadow-sm mb-2" id="qr-display-box">
          <svg class="qr-svg-mock" width="180" height="180" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <rect width="200" height="200" fill="#ffffff" rx="10"/>
            <rect x="20" y="20" width="45" height="45" fill="#111827"/>
            <rect x="27" y="27" width="31" height="31" fill="#ffffff"/>
            <rect x="33" y="33" width="19" height="19" fill="#111827"/>
            <rect x="135" y="20" width="45" height="45" fill="#111827"/>
            <rect x="142" y="27" width="31" height="31" fill="#ffffff"/>
            <rect x="148" y="33" width="19" height="19" fill="#111827"/>
            <rect x="20" y="135" width="45" height="45" fill="#111827"/>
            <rect x="27" y="142" width="31" height="31" fill="#ffffff"/>
            <rect x="33" y="148" width="19" height="19" fill="#111827"/>
            <g fill="#111827">
              <rect x="75" y="22" width="10" height="10"/>
              <rect x="90" y="22" width="10" height="10"/>
              <rect x="110" y="22" width="10" height="10"/>
              <rect x="75" y="38" width="15" height="10"/>
              <rect x="105" y="38" width="15" height="10"/>
              <rect x="22" y="75" width="10" height="10"/>
              <rect x="38" y="85" width="12" height="10"/>
              <rect x="55" y="75" width="10" height="15"/>
              <rect x="75" y="75" width="50" height="50" rx="8" fill="#f97316"/>
              <text x="100" y="105" font-size="24" text-anchor="middle" fill="#ffffff">🍲</text>
              <rect x="135" y="75" width="12" height="12"/>
              <rect x="155" y="85" width="20" height="10"/>
              <rect x="140" y="105" width="15" height="10"/>
              <rect x="165" y="120" width="15" height="15"/>
              <rect x="75" y="135" width="12" height="12"/>
              <rect x="95" y="140" width="25" height="10"/>
              <rect x="130" y="140" width="10" height="15"/>
              <rect x="85" y="160" width="20" height="15"/>
              <rect x="115" y="165" width="20" height="10"/>
              <rect x="145" y="160" width="30" height="15"/>
            </g>
          </svg>
        </div>
        <div class="badge bg-danger-subtle text-danger-emphasis rounded-pill px-3 py-2 small">
          <span>Selesaikan dalam: </span>
          <strong id="qris-countdown">04:59</strong>
        </div>
      </div>

      <div class="card bg-body-tertiary border-0 rounded-3 p-3 mb-3">
        <small class="text-muted d-block">Total Tagihan:</small>
        <span class="fs-4 fw-bold text-primary" id="qris-nominal-value">Rp 0</span>
      </div>

      <div class="d-flex flex-column gap-2">
        <button class="btn btn-primary rounded-pill py-2 fw-semibold" id="mock-pay-success-btn">
          <i class="fa-solid fa-circle-check me-2"></i>
          <span>Simulasikan Bayar Sukses</span>
        </button>
        <button class="btn btn-outline-secondary rounded-pill py-2" id="cancel-qris-btn" data-bs-dismiss="modal">Batal / Ganti Metode</button>
      </div>

    </div>
  </div>
</div>
