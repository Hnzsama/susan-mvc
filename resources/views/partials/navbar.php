<!-- ================= BOOTSTRAP 5 MOBILE APP HEADER ================= -->
<header class="navbar border-bottom sticky-top bg-body py-2 px-3 shadow-sm d-flex flex-column gap-2" id="navbar">
  <!-- Top Bar: Logo & Actions -->
  <div class="w-100 d-flex justify-content-between align-items-center">
    
    <!-- Logo -->
    <a href="<?= url('/') ?>" class="navbar-brand d-flex align-items-center gap-2 fw-bold text-decoration-none m-0" id="brand-logo" aria-label="NyamCenter Home">
      <span class="fs-4 text-primary"><i class="fa-solid fa-bowl-food"></i></span>
      <div class="d-flex flex-column leading-none">
        <span class="fs-6 fw-bold text-body">NyamCenter<span class="text-primary">.</span></span>
        <small class="text-muted" style="font-size: 10px; margin-top: -2px;">Pujasera Sentra Kuliner</small>
      </div>
    </a>

    <!-- Action Chips -->
    <div class="d-flex align-items-center gap-2">
      <!-- Order Type Switcher -->
      <button class="nav-action-btn rounded-pill d-flex align-items-center gap-2 px-3 fw-semibold" id="order-type-toggle-btn" title="Ubah metode pemesanan" style="font-size: 11.5px; padding: 5px 12px;">
        <span id="order-type-icon" class="text-primary d-inline-flex align-items-center"><i class="fa-solid fa-motorcycle"></i></span>
        <span id="order-type-label">Delivery</span>
      </button>

      <!-- Theme Toggle Button -->
      <button class="nav-action-btn rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 32px; height: 32px;" id="theme-toggle-btn" aria-label="Ganti Tema">
        <i class="fa-solid fa-sun text-warning theme-icon-sun" style="font-size: 13px;"></i>
        <i class="fa-solid fa-moon text-info theme-icon-moon d-none" style="font-size: 13px;"></i>
      </button>

      <!-- Wishlist Button -->
      <button class="nav-action-btn rounded-circle position-relative d-flex align-items-center justify-content-center p-0" style="width: 32px; height: 32px;" id="wishlist-btn" title="Menu Favorit" aria-label="Menu Favorit">
        <i class="fa-solid fa-heart text-danger" style="font-size: 13px;"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="wishlist-badge" style="display: none; font-size: 9px;">0</span>
      </button>
    </div>

  </div>

  <!-- Search Input Bar -->
  <div class="w-100 position-relative">
    <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="pointer-events: none; z-index: 5;"></i>
    <input 
      type="text" 
      id="search-input" 
      class="form-control rounded-pill bg-body-tertiary border ps-5 pe-5 py-2 shadow-none" 
      placeholder="Cari nasi goreng, ayam geprek, kopi..." 
      autocomplete="off"
      style="font-size: 13px;"
    >
    <button id="search-clear-btn" class="btn btn-sm text-muted position-absolute top-50 end-0 translate-middle-y me-2 rounded-circle border-0 p-1" type="button" style="display: none; z-index: 5;" title="Hapus pencarian">
      <i class="fa-solid fa-xmark"></i>
    </button>
  </div>
</header>
