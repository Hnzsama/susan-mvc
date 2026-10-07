<!-- ================= BOOTSTRAP 5 MOBILE BOTTOM FLOATING DOCK ================= -->
<div class="mobile-bottom-dock" id="bottom-dock">
  
  <a href="#navbar" class="bottom-dock-btn active" id="bnav-home">
    <i class="fa-solid fa-utensils"></i>
    <span>Menu Stand</span>
  </a>

  <a href="#vouchers-quick-list" class="bottom-dock-btn" id="bnav-promo">
    <i class="fa-solid fa-ticket"></i>
    <span>Promo</span>
  </a>

  <button type="button" class="bottom-dock-btn position-relative" id="bnav-wishlist">
    <i class="fa-solid fa-heart text-danger"></i>
    <span>Favorit</span>
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="bnav-wishlist-badge" style="display: none; font-size: 9px;">0</span>
  </button>

  <button type="button" class="bottom-dock-btn position-relative" id="bnav-cart" data-bs-toggle="offcanvas" data-bs-target="#cart-drawer">
    <i class="fa-solid fa-cart-shopping text-primary"></i>
    <span>Keranjang</span>
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" id="bnav-cart-badge" style="font-size: 9px;">0</span>
  </button>

</div>
