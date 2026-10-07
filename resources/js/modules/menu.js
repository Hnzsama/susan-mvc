/**
 * Menu Rendering, Category Filtering, Sorting, and Favorites (Pujasera Mobile Version)
 */

import { AppState, saveFavoritesToStorage } from './state.js';
import { formatRupiah, showToast } from './utils.js';
import { MENU_CATEGORIES, MENU_ITEMS, PROMO_VOUCHERS, PUJASERA_STANDS } from './data.js';
import { applyVoucherCode } from './cart.js';
import { openCustomizationModal } from './custom-modal.js';

export function renderStands() {
  const container = document.getElementById('stands-container');
  if (!container) return;

  container.innerHTML = PUJASERA_STANDS.map(stand => `
    <button 
      class="stand-chip ${stand.id === AppState.activeStand ? 'active' : ''}" 
      data-stand-id="${stand.id}"
      role="tab"
      aria-selected="${stand.id === AppState.activeStand}"
    >
      <i class="${stand.icon} text-primary"></i>
      <span>${stand.name}</span>
    </button>
  `).join('');

  container.querySelectorAll('.stand-chip').forEach(btn => {
    btn.addEventListener('click', () => {
      const standId = btn.getAttribute('data-stand-id');
      AppState.activeStand = standId;
      container.querySelectorAll('.stand-chip').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      renderMenuGrid();
    });
  });
}

export function renderCategories() {
  const container = document.getElementById('categories-container');
  if (!container) return;

  container.innerHTML = MENU_CATEGORIES.map(cat => `
    <button 
      class="category-chip ${cat.id === AppState.activeCategory ? 'active' : ''}" 
      data-category-id="${cat.id}"
      role="tab"
      aria-selected="${cat.id === AppState.activeCategory}"
    >
      <span class="me-1">${cat.icon}</span>
      <span>${cat.name}</span>
    </button>
  `).join('');

  container.querySelectorAll('.category-chip').forEach(btn => {
    btn.addEventListener('click', () => {
      const catId = btn.getAttribute('data-category-id');
      AppState.activeCategory = catId;
      container.querySelectorAll('.category-chip').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      renderMenuGrid();
    });
  });
}

export function renderVouchersQuickBar() {
  const container = document.getElementById('vouchers-quick-list');
  if (!container) return;

  container.innerHTML = PROMO_VOUCHERS.map(v => `
    <div class="flex-shrink-0" style="width: 240px; scroll-snap-align: start;">
      <div class="card bg-body-tertiary border rounded-4 p-3 d-flex flex-row align-items-center gap-3 cursor-pointer voucher-card h-100 shadow-sm" data-voucher-code="${v.code}" title="Klik untuk pakai kupon ${v.code}">
        <span class="fs-4 text-primary"><i class="fa-solid fa-ticket"></i></span>
        <div class="flex-grow-1 min-w-0">
          <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill px-2 py-1 mb-1 fw-bold" style="font-size: 10px;">${v.code}</span>
          <h6 class="fw-bold mb-0 text-body text-truncate" style="font-size: 12px;">${v.title}</h6>
          <small class="text-muted d-block mt-1" style="font-size: 10px; line-height: 1.2;">${v.description}</small>
        </div>
      </div>
    </div>
  `).join('');

  container.querySelectorAll('.voucher-card').forEach(card => {
    card.addEventListener('click', () => {
      const code = card.getAttribute('data-voucher-code');
      applyVoucherCode(code, true);
    });
  });
}

export function renderMenuGrid() {
  const container = document.getElementById('menu-grid');
  const emptyState = document.getElementById('empty-state');
  if (!container) return;

  let items = MENU_ITEMS.filter(item => {
    if (AppState.activeCategory !== 'all' && item.category !== AppState.activeCategory) {
      return false;
    }
    if (AppState.activeStand !== 'all') {
      const standObj = PUJASERA_STANDS.find(s => s.id === AppState.activeStand);
      if (standObj && item.stand) {
        const cleanStand = standObj.name.toLowerCase();
        const itemStand = item.stand.toLowerCase();
        if (!itemStand.includes(cleanStand.split('•')[0].trim().toLowerCase())) {
          return false;
        }
      }
    }
    if (AppState.searchQuery.trim() !== '') {
      const q = AppState.searchQuery.toLowerCase().trim();
      const matchName = item.name.toLowerCase().includes(q);
      const matchDesc = item.description.toLowerCase().includes(q);
      const matchCat = item.category.toLowerCase().includes(q);
      const matchStand = item.stand && item.stand.toLowerCase().includes(q);
      if (!matchName && !matchDesc && !matchCat && !matchStand) return false;
    }
    if (AppState.filterPromo && !item.isPromo) return false;
    if (AppState.filterBestSeller && !item.isBestSeller) return false;

    return true;
  });

  items.sort((a, b) => {
    if (AppState.sortBy === 'rating') return b.rating - a.rating;
    if (AppState.sortBy === 'price-asc') return a.price - b.price;
    if (AppState.sortBy === 'price-desc') return b.price - a.price;
    return b.reviewsCount - a.reviewsCount;
  });

  if (items.length === 0) {
    container.style.display = 'none';
    if (emptyState) emptyState.style.display = 'block';
    return;
  }

  container.style.display = 'flex';
  if (emptyState) emptyState.style.display = 'none';

  container.innerHTML = items.map(item => {
    const isFav = AppState.favorites.includes(item.id);
    const hasDiscount = item.originalPrice && item.originalPrice > item.price;
    const discountPct = hasDiscount ? Math.round(((item.originalPrice - item.price) / item.originalPrice) * 100) : 0;

    return `
      <div class="col-6">
        <div class="card h-100 border rounded-4 menu-card bg-body-tertiary overflow-hidden shadow-sm" data-item-id="${item.id}" style="cursor: pointer;">
          
          <div class="position-relative overflow-hidden" style="height: 130px;">
            <img 
              src="${item.image}" 
              alt="${item.name}" 
              class="w-100 h-100 object-fit-cover" 
              loading="lazy"
              onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&auto=format&fit=crop&q=80';"
            >
            <div class="position-absolute top-0 start-0 m-2 d-flex flex-column gap-1">
              ${item.isBestSeller ? '<span class="badge bg-warning text-dark rounded-pill px-2 py-1" style="font-size: 9px;"><i class="fa-solid fa-fire me-1"></i> Hits</span>' : ''}
              ${hasDiscount ? `<span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 9px;"><i class="fa-solid fa-tag me-1"></i> -${discountPct}%</span>` : ''}
            </div>

            <button 
              type="button" 
              class="btn btn-sm btn-light bg-white rounded-circle position-absolute top-0 end-0 m-2 shadow-sm card-fav-btn p-0 d-flex align-items-center justify-content-center" 
              style="width: 28px; height: 28px;"
              data-item-id="${item.id}" 
              title="${isFav ? 'Hapus favorit' : 'Favorit'}"
            >
              <i class="fa-${isFav ? 'solid' : 'regular'} fa-heart ${isFav ? 'text-danger' : 'text-muted'}" style="font-size: 11px;"></i>
            </button>

            <span class="badge bg-dark bg-opacity-75 text-white rounded-pill position-absolute bottom-0 end-0 m-2 px-2 py-1" style="font-size: 9px;">
              <i class="fa-regular fa-clock me-1"></i> ${item.prepTime}
            </span>
          </div>

          <div class="card-body p-2 p-sm-3 d-flex flex-column">
            <span class="text-primary fw-bold text-uppercase text-truncate mb-1" style="font-size: 9px; letter-spacing: 0.3px;">
              <i class="fa-solid fa-store me-1"></i> ${item.stand || 'Stand Pujasera'}
            </span>

            <h6 class="fw-bold mb-1 text-truncate text-body" style="font-size: 13px;">${item.name}</h6>
            
            <div class="d-flex align-items-center gap-1 mb-2 text-muted" style="font-size: 11px;">
              <i class="fa-solid fa-star text-warning"></i> <span>${item.rating.toFixed(1)}</span>
              <span class="mx-1">•</span>
              <span>${item.reviewsCount}+ terjual</span>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-auto pt-1">
              <div>
                <span class="fw-bold text-primary" style="font-size: 13px;">${formatRupiah(item.price)}</span>
                ${hasDiscount ? `<small class="text-muted text-decoration-line-through d-block" style="font-size: 10px;">${formatRupiah(item.originalPrice)}</small>` : ''}
              </div>

              <button class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center p-0 shadow-sm open-custom-btn" style="width: 32px; height: 32px;" data-item-id="${item.id}" aria-label="Tambah Menu">
                <i class="fa-solid fa-plus" style="font-size: 12px;"></i>
              </button>
            </div>
          </div>

        </div>
      </div>
    `;
  }).join('');

  container.querySelectorAll('.open-custom-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const itemId = btn.getAttribute('data-item-id');
      openCustomizationModal(itemId);
    });
  });

  container.querySelectorAll('.menu-card').forEach(card => {
    card.addEventListener('click', (e) => {
      if (e.target.closest('.card-fav-btn') || e.target.closest('.open-custom-btn')) return;
      const itemId = card.getAttribute('data-item-id');
      openCustomizationModal(itemId);
    });
  });

  container.querySelectorAll('.card-fav-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const itemId = btn.getAttribute('data-item-id');
      toggleFavorite(itemId);
    });
  });
}

export function toggleFavorite(itemId) {
  const index = AppState.favorites.indexOf(itemId);
  if (index > -1) {
    AppState.favorites.splice(index, 1);
    showToast('Dihapus dari menu favorit');
  } else {
    AppState.favorites.push(itemId);
    showToast('Ditambahkan ke menu favorit ❤️', 'success');
  }

  saveFavoritesToStorage();
  updateFavoritesUI();
  renderMenuGrid();
}

export function updateFavoritesUI() {
  const badge = document.getElementById('wishlist-badge');
  const bnavBadge = document.getElementById('bnav-wishlist-badge');
  const count = AppState.favorites.length;

  if (badge) {
    badge.style.display = count > 0 ? 'inline-block' : 'none';
    badge.textContent = count;
  }
  if (bnavBadge) {
    bnavBadge.style.display = count > 0 ? 'inline-block' : 'none';
    bnavBadge.textContent = count;
  }
}
