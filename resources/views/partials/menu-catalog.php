<!-- ================= BOOTSTRAP 5 MOBILE MENU CATALOG ================= -->
<section class="container px-3 my-3" id="menu-catalog">
  
  <!-- Stand / Tenant Directory Header -->
  <div class="d-flex justify-content-between align-items-center mb-2">
    <small class="text-uppercase text-muted fw-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">
      <i class="fa-solid fa-store text-primary me-1"></i> Stand Kuliner Pujasera
    </small>
    <span class="badge bg-body-tertiary border text-muted rounded-pill px-2 py-0.5" style="font-size: 10px;">
      14 Stand Aktif
    </span>
  </div>

  <!-- Stands Horizontal Navigation Scroll -->
  <div class="d-flex gap-2 overflow-x-auto pt-2 pb-2 px-1 mb-2 scrollbar-none" id="stands-container" role="tablist">
    <!-- Rendered via JS -->
  </div>

  <!-- Category Section Header -->
  <div class="mb-2">
    <small class="text-uppercase text-muted fw-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">
      <i class="fa-solid fa-utensils text-primary me-1"></i> Kategori Menu
    </small>
  </div>

  <!-- Categories Navigation Scroll -->
  <div class="d-flex gap-2 overflow-x-auto pt-2 pb-2 px-1 mb-3 scrollbar-none" id="categories-container" role="tablist">
    <!-- Rendered via JS -->
  </div>

  <!-- Quick Filter & Sort Row -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center gap-1">
      <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill px-2 py-1" style="font-size: 11px;">
        <i class="fa-solid fa-fire me-1 text-danger"></i> Menu Hits & Lezat
      </span>
    </div>

    <div class="d-flex align-items-center gap-1">
      <select id="sort-select" class="form-select form-select-sm rounded-pill bg-body-tertiary border-0 shadow-none text-muted" style="font-size: 11px; width: auto;">
        <option value="popular">Terpopuler 🔥</option>
        <option value="rating">Rating ⭐</option>
        <option value="price-asc">Termurah</option>
        <option value="price-desc">Termahal</option>
      </select>
    </div>
  </div>

  <!-- Menu Grid Cards (2 Columns) -->
  <div class="row g-2" id="menu-grid">
    <!-- Rendered via JS -->
  </div>

  <!-- Empty State -->
  <div class="text-center py-5" id="empty-state" style="display: none;">
    <div class="fs-1 text-muted mb-2 opacity-50">
      <i class="fa-solid fa-magnifying-glass"></i>
    </div>
    <h6 class="fw-bold mb-1">Menu Tidak Ditemukan</h6>
    <p class="text-muted small mb-3">Coba gunakan kata kunci pencarian yang lain.</p>
    <button class="btn btn-sm btn-outline-primary rounded-pill px-3" id="reset-filter-btn">
      <i class="fa-solid fa-rotate-left me-1"></i> Reset Pencarian
    </button>
  </div>

</section>
