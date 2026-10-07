<!-- ================= BOOTSTRAP 5 MODAL: DETAIL / KUSTOMISASI MENU ================= -->
<div class="modal fade" id="custom-modal-backdrop" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="custom-modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow overflow-hidden">
      
      <div class="position-relative">
        <img src="" alt="" id="modal-menu-img" class="w-100 object-fit-cover" style="height: 220px;">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3 bg-white p-2 rounded-circle shadow-sm" data-bs-dismiss="modal" id="custom-modal-close" aria-label="Close"></button>
        <div class="position-absolute bottom-0 start-0 m-3 d-flex gap-2">
          <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2" id="modal-menu-category">Kategori</span>
          <span class="badge bg-warning text-dark rounded-pill px-3 py-2 d-flex align-items-center gap-1" id="modal-menu-rating">
            <i class="fa-solid fa-star"></i> 4.9
          </span>
        </div>
      </div>

      <div class="modal-body p-4">
        <h4 class="fw-bold mb-1" id="modal-menu-title">Nama Makanan</h4>
        <p class="text-muted small mb-3" id="modal-menu-desc">Deskripsi makanan lengkap...</p>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <span class="fs-4 fw-bold text-primary" id="modal-base-price">Rp 0</span>
            <span class="text-muted text-decoration-line-through ms-2 small" id="modal-old-price" style="display: none;">Rp 0</span>
          </div>
          <span class="badge bg-body-secondary text-body-secondary rounded-pill px-3 py-2" id="modal-prep-time">
            <i class="fa-regular fa-clock me-1"></i> 15 min
          </span>
        </div>

        <hr class="my-3">

        <!-- Opsi Porsi -->
        <div class="mb-3" id="portion-section">
          <label class="form-label fw-bold small d-flex justify-content-between">
            <span>Pilihan Porsi</span>
            <span class="badge bg-primary-subtle text-primary-emphasis">Wajib (Pilih 1)</span>
          </label>
          <div class="d-flex flex-column gap-2" id="portion-options-container">
            <!-- Rendered dynamically via JS -->
          </div>
        </div>

        <!-- Opsi Level Kepedasan / Rasa -->
        <div class="mb-3" id="spicy-section">
          <label class="form-label fw-bold small d-flex justify-content-between">
            <span>Level Kepedasan / Varian</span>
            <span class="badge bg-primary-subtle text-primary-emphasis">Wajib (Pilih 1)</span>
          </label>
          <div class="d-flex flex-column gap-2" id="spicy-options-container">
            <!-- Rendered dynamically via JS -->
          </div>
        </div>

        <!-- Opsi Topping Tambahan -->
        <div class="mb-3" id="topping-section">
          <label class="form-label fw-bold small d-flex justify-content-between">
            <span>Topping Tambahan (Opsional)</span>
            <span class="text-muted">Bisa pilih lebih dari 1</span>
          </label>
          <div class="d-flex flex-column gap-2" id="topping-options-container">
            <!-- Rendered dynamically via JS -->
          </div>
        </div>

        <!-- Catatan Khusus -->
        <div class="mb-2">
          <label class="form-label fw-bold small" for="modal-notes-input">
            <span>Catatan Khusus untuk Koki</span>
            <span class="text-muted small fw-normal ms-1">(Opsional)</span>
          </label>
          <textarea 
            id="modal-notes-input" 
            class="form-control" 
            rows="2" 
            placeholder="Contoh: Jangan pakai bawang goreng, sambal dipisah ya koki..."
            maxlength="150"
          ></textarea>
        </div>
      </div>

      <div class="modal-footer d-flex justify-content-between align-items-center p-3 border-top bg-body">
        <!-- Modern Pill Stepper -->
        <div class="d-inline-flex align-items-center bg-body-tertiary border rounded-pill p-1 shadow-sm">
          <button class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center p-0 border-0" style="width: 32px; height: 32px;" type="button" id="modal-qty-minus" aria-label="Kurangi">
            <i class="fa-solid fa-minus" style="font-size: 11px;"></i>
          </button>
          <span class="fw-bold px-3 text-body" id="modal-qty-display" style="min-width: 36px; text-align: center; font-size: 15px;">1</span>
          <button class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center p-0 shadow-sm" style="width: 32px; height: 32px;" type="button" id="modal-qty-plus" aria-label="Tambah">
            <i class="fa-solid fa-plus" style="font-size: 11px;"></i>
          </button>
        </div>

        <button class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm d-flex align-items-center gap-2" id="modal-confirm-add-btn">
          <span>Tambah</span>
          <span class="badge bg-white text-primary rounded-pill px-2 py-1 fw-bold" id="modal-total-add-price">Rp 0</span>
        </button>
      </div>

    </div>
  </div>
</div>
