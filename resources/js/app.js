/**
 * SAVORIA BITES & BISTRO - MODULAR JAVASCRIPT ENTRYPOINT
 * Bundled and Minified via Vite with Bootstrap
 */

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
import { initTheme } from './modules/theme.js';
import { loadStoredData } from './modules/state.js';
import { updateOrderTypeBadgeUI } from './modules/order-type.js';
import { renderStands, renderCategories, renderVouchersQuickBar, renderMenuGrid, updateFavoritesUI } from './modules/menu.js';
import { updateCartUI, openCartDrawer, closeCartDrawer } from './modules/cart.js';
import { openCustomizationModal, closeCustomizationModal } from './modules/custom-modal.js';
import { openCheckoutModal, closeCheckoutModal } from './modules/checkout.js';
import { openQrisModal, closeQrisModal } from './modules/qris.js';
import { openTrackerModal, closeTrackerModal } from './modules/tracker.js';
import { attachEventListeners } from './modules/events.js';

// Expose modal/drawer controllers to window if needed
window.openCartDrawer = openCartDrawer;
window.closeCartDrawer = closeCartDrawer;
window.openCustomizationModal = openCustomizationModal;
window.closeCustomizationModal = closeCustomizationModal;
window.openCheckoutModal = openCheckoutModal;
window.closeCheckoutModal = closeCheckoutModal;
window.openQrisModal = openQrisModal;
window.closeQrisModal = closeQrisModal;
window.openTrackerModal = openTrackerModal;
window.closeTrackerModal = closeTrackerModal;

// Application bootstrap
document.addEventListener('DOMContentLoaded', () => {
  initTheme();
  loadStoredData();
  updateOrderTypeBadgeUI();
  renderStands();
  renderCategories();
  renderVouchersQuickBar();
  renderMenuGrid();
  updateCartUI();
  updateFavoritesUI();
  attachEventListeners();
});
