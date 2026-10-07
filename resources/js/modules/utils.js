/**
 * Currency Formatting & Bootstrap 5 Toast Notification Helpers
 */

export function formatRupiah(number) {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    maximumFractionDigits: 0
  }).format(number);
}

export function showToast(message, type = 'info') {
  const container = document.getElementById('toast-container');
  if (!container) return;

  const toastEl = document.createElement('div');
  const bgClass = type === 'success' ? 'text-bg-success' : (type === 'error' ? 'text-bg-danger' : 'text-bg-primary');
  
  toastEl.className = `toast align-items-center ${bgClass} border-0 shadow-lg rounded-3 mb-2 show`;
  toastEl.setAttribute('role', 'alert');
  toastEl.setAttribute('aria-live', 'assertive');
  toastEl.setAttribute('aria-atomic', 'true');

  let icon = '<i class="fa-solid fa-circle-info me-2"></i>';
  if (type === 'success') icon = '<i class="fa-solid fa-circle-check me-2"></i>';
  if (type === 'error') icon = '<i class="fa-solid fa-triangle-exclamation me-2"></i>';

  toastEl.innerHTML = `
    <div class="d-flex">
      <div class="toast-body d-flex align-items-center py-2 px-3 fw-semibold">
        ${icon}
        <span>${message}</span>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  `;

  container.appendChild(toastEl);

  if (window.bootstrap && window.bootstrap.Toast) {
    const bsToast = new window.bootstrap.Toast(toastEl, { delay: 3500 });
    bsToast.show();
    toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
  } else {
    setTimeout(() => {
      toastEl.classList.remove('show');
      setTimeout(() => toastEl.remove(), 300);
    }, 3500);
  }
}
