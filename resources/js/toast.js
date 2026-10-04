/**
 * Lunara Toast Notification System (Phase 19.57)
 */
export function showToast(message, type = 'success', duration = 3500) {
    const container = document.querySelector('#lunaraToastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `lunara-toast lunara-toast--${type}`;
    toast.setAttribute('role', 'status');
    toast.setAttribute('aria-live', 'polite');

    let iconClass = 'bi-check-circle-fill';
    if (type === 'error') iconClass = 'bi-exclamation-circle-fill';
    if (type === 'info') iconClass = 'bi-info-circle-fill';

    toast.innerHTML = `
        <i class="bi ${iconClass} lunara-toast__icon" aria-hidden="true"></i>
        <div class="lunara-toast__body">${escapeHtml(message)}</div>
        <button type="button" class="lunara-toast__close" aria-label="Đóng thông báo">
            <i class="bi bi-x-lg"></i>
        </button>
    `;

    const closeBtn = toast.querySelector('.lunara-toast__close');
    const dismiss = () => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(16px)';
        setTimeout(() => toast.remove(), 250);
    };

    if (closeBtn) {
        closeBtn.addEventListener('click', dismiss);
    }

    container.appendChild(toast);

    if (duration > 0) {
        setTimeout(dismiss, duration);
    }
}

function escapeHtml(string) {
    const div = document.createElement('div');
    div.textContent = string;
    return div.innerHTML;
}

window.LunaraToast = {
    show: showToast,
    success: (msg, duration) => showToast(msg, 'success', duration),
    error: (msg, duration) => showToast(msg, 'error', duration),
    info: (msg, duration) => showToast(msg, 'info', duration),
};
