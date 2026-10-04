import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import './toast';
import { initSearchOverlay } from './search-overlay';
import { initWishlist } from './wishlist';
import { initCartDrawer } from './cart-drawer';
import { initMobileStickyBar } from './mobile-sticky-bar';

const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

function renderCart(data) {
    document.querySelectorAll('[data-cart-count]').forEach((element) => {
        element.textContent = data.cart_count;
    });
    document.querySelectorAll('[data-drawer-count]').forEach((element) => {
        element.textContent = data.cart_count;
    });

    const pageSubtotal = document.querySelector('[data-cart-subtotal]');
    if (pageSubtotal) pageSubtotal.textContent = data.subtotal_display;

    const discountRow = document.querySelector('[data-cart-discount-row]');
    const discountVal = document.querySelector('[data-cart-discount]');
    const couponCodeVal = document.querySelector('[data-cart-coupon-code]');
    const grandTotalVal = document.querySelector('[data-cart-grandtotal]');

    if (discountRow) {
        if (data.coupon_applied) {
            discountRow.style.setProperty('display', 'flex', 'important');
            if (discountVal) discountVal.textContent = data.discount_display;
            if (couponCodeVal && data.coupon_code) couponCodeVal.textContent = data.coupon_code;
        } else {
            discountRow.style.setProperty('display', 'none', 'important');
        }
    }
    if (grandTotalVal) {
        grandTotalVal.textContent = data.grand_total_display || data.subtotal_display;
    }

    document.querySelectorAll('[data-cart-item]').forEach((row) => {
        const item = data.items.find((candidate) => candidate.id === Number(row.dataset.cartItem));
        if (!item) {
            row.remove();
            return;
        }
        const qInput = row.querySelector('[name="quantity"]');
        if (qInput) qInput.value = item.quantity;
        const subtotalEl = row.querySelector('[data-line-subtotal]');
        if (subtotalEl) subtotalEl.textContent = item.line_subtotal_display;
    });
    if (document.querySelector('#cartLayout') && !data.items.length) window.location.reload();
}

async function cartRequest(url, method, payload, feedback) {
    try {
        const response = await fetch(url, {
            method,
            headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf || '' },
            body: payload ? JSON.stringify(payload) : undefined,
        });
        const data = await response.json();
        if (feedback) feedback.textContent = data.message || 'Không thể cập nhật giỏ hàng.';
        if (data.items) renderCart(data);
    } catch {
        if (feedback) feedback.textContent = 'Không thể kết nối. Vui lòng thử lại.';
    }
}

// Full /cart page update forms
document.querySelectorAll('[data-cart-update]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        cartRequest(form.action, 'PATCH', { quantity: Number(new FormData(form).get('quantity')) }, document.querySelector('#cartPageFeedback'));
    });
});

document.querySelectorAll('[data-cart-remove]').forEach((button) => {
    if (!button.closest('#miniCart')) {
        button.addEventListener('click', () => {
            cartRequest(button.dataset.url, 'DELETE', null, document.querySelector('#cartPageFeedback'));
        });
    }
});

document.querySelectorAll('[data-cart-clear]').forEach((button) => {
    button.addEventListener('click', () => {
        if (window.confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng không?')) {
            cartRequest(button.dataset.url, 'DELETE', null, document.querySelector('#cartPageFeedback'));
        }
    });
});

// Checkout form submission loading state
const checkoutForm = document.querySelector('#checkoutForm');
if (checkoutForm) {
    checkoutForm.addEventListener('submit', () => {
        const btn = checkoutForm.querySelector('#submitOrderBtn');
        if (btn && checkoutForm.checkValidity()) {
            btn.disabled = true;
            btn.textContent = 'Đang xử lý đơn hàng...';
        }
    });
}

// Saved address selector on checkout
const savedAddressSelect = document.querySelector('#savedAddressSelect');
if (savedAddressSelect) {
    savedAddressSelect.addEventListener('change', (e) => {
        const option = e.target.options[e.target.selectedIndex];
        if (option && option.dataset.name) {
            const nameInput = document.querySelector('#customer_name');
            const phoneInput = document.querySelector('#customer_phone');
            const addressInput = document.querySelector('#shipping_address');
            const cityInput = document.querySelector('#shipping_city');

            if (nameInput) nameInput.value = option.dataset.name;
            if (phoneInput) phoneInput.value = option.dataset.phone;
            if (addressInput) addressInput.value = option.dataset.address;
            if (cityInput) cityInput.value = option.dataset.city;
        }
    });
}

// Quantity Stepper Widget (for product detail page stepper)
document.querySelectorAll('[data-stepper]').forEach((button) => {
    button.addEventListener('click', () => {
        const input = button.closest('.stepper-widget')?.querySelector('.stepper-input');
        if (!input || input.disabled) return;
        const min = Number(input.min) || 1;
        const max = Number(input.max) || 999;
        let val = Number(input.value) || 1;
        if (button.dataset.stepper === 'plus') {
            if (val < max) val++;
        } else if (button.dataset.stepper === 'minus') {
            if (val > min) val--;
        }
        input.value = val;
        input.dispatchEvent(new Event('change', { bubbles: true }));
    });
});

// "Mua ngay" (Buy Now) Button -> add to cart & redirect directly to checkout
document.querySelectorAll('[data-buy-now]').forEach((button) => {
    button.addEventListener('click', async () => {
        const form = button.closest('form');
        if (!form) return;
        const values = new FormData(form);
        const feedback = form.querySelector('.cart-feedback');
        button.disabled = true;
        const originalText = button.innerHTML;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Đang xử lý...';
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf || '' },
                body: JSON.stringify({
                    product_id: Number(values.get('product_id')),
                    quantity: Number(values.get('quantity')),
                }),
            });
            const data = await response.json();
            if (data.items) {
                window.location.href = '/checkout';
            } else {
                if (feedback) feedback.textContent = data.message || 'Không thể thêm vào giỏ.';
                button.disabled = false;
                button.innerHTML = originalText;
            }
        } catch {
            if (feedback) feedback.textContent = 'Lỗi kết nối. Vui lòng thử lại.';
            button.disabled = false;
            button.innerHTML = originalText;
        }
    });
});

// Lunara Premium Hero Slider (3-Slide Carousel)
function initHeroSlider() {
    const slider = document.querySelector('#heroSlider');
    if (!slider) return;

    const slides = Array.from(slider.querySelectorAll('.hero-slide'));
    const indicators = Array.from(slider.querySelectorAll('.hero-indicator'));
    const prevBtn = slider.querySelector('#heroSliderPrev');
    const nextBtn = slider.querySelector('#heroSliderNext');
    const pauseBtn = slider.querySelector('#heroSliderPauseBtn');

    if (!slides.length) return;

    let currentIndex = 0;
    let timer = null;
    let isPaused = false;
    let manualPaused = false;
    const interval = Number(slider.dataset.interval) || 5500;
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function goToSlide(newIndex) {
        const targetIndex = (newIndex + slides.length) % slides.length;
        if (targetIndex === currentIndex && slides[currentIndex].classList.contains('hero-slide--active')) {
            return;
        }

        const prevSlide = slides[currentIndex];
        const nextSlide = slides[targetIndex];

        slides.forEach((s) => {
            if (s !== prevSlide && s !== nextSlide) {
                s.style.zIndex = '0';
            }
        });
        prevSlide.style.zIndex = '1';
        nextSlide.style.zIndex = '2';

        prevSlide.classList.remove('hero-slide--active');
        prevSlide.setAttribute('aria-hidden', 'true');

        if (indicators[currentIndex]) {
            indicators[currentIndex].classList.remove('hero-indicator--active');
            indicators[currentIndex].setAttribute('aria-selected', 'false');
        }

        currentIndex = targetIndex;

        nextSlide.classList.add('hero-slide--active');
        nextSlide.setAttribute('aria-hidden', 'false');

        if (indicators[currentIndex]) {
            indicators[currentIndex].classList.add('hero-indicator--active');
            indicators[currentIndex].setAttribute('aria-selected', 'true');
        }
    }

    function startAutoplay() {
        if (prefersReducedMotion || manualPaused) return;
        stopAutoplay();
        timer = setInterval(() => {
            if (!isPaused && !manualPaused && document.visibilityState === 'visible') {
                goToSlide(currentIndex + 1);
            }
        }, interval);
    }

    function stopAutoplay() {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    function handleUserAction(action) {
        action();
        startAutoplay();
    }

    indicators.forEach((indicator, idx) => {
        indicator.addEventListener('click', () => {
            handleUserAction(() => goToSlide(idx));
        });
    });

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            handleUserAction(() => goToSlide(currentIndex - 1));
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            handleUserAction(() => goToSlide(currentIndex + 1));
        });
    }

    if (pauseBtn) {
        pauseBtn.addEventListener('click', () => {
            manualPaused = !manualPaused;
            pauseBtn.setAttribute('aria-pressed', manualPaused ? 'true' : 'false');
            pauseBtn.textContent = manualPaused ? 'Tiếp tục trình chiếu' : 'Tạm dừng trình chiếu';
            if (manualPaused) {
                stopAutoplay();
            } else {
                startAutoplay();
            }
        });
    }

    slider.addEventListener('mouseenter', () => { isPaused = true; });
    slider.addEventListener('mouseleave', () => { isPaused = false; });
    slider.addEventListener('focusin', () => { isPaused = true; });
    slider.addEventListener('focusout', (e) => {
        if (!slider.contains(e.relatedTarget)) {
            isPaused = false;
        }
    });

    slider.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            handleUserAction(() => goToSlide(currentIndex - 1));
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            handleUserAction(() => goToSlide(currentIndex + 1));
        }
    });

    let touchStartX = 0;
    let touchStartY = 0;

    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
        isPaused = true;
    }, { passive: true });

    slider.addEventListener('touchend', (e) => {
        const touchEndX = e.changedTouches[0].screenX;
        const touchEndY = e.changedTouches[0].screenY;
        const diffX = touchEndX - touchStartX;
        const diffY = touchEndY - touchStartY;

        isPaused = false;
        if (Math.abs(diffX) > 45 && Math.abs(diffX) > Math.abs(diffY)) {
            if (diffX < 0) {
                handleUserAction(() => goToSlide(currentIndex + 1));
            } else {
                handleUserAction(() => goToSlide(currentIndex - 1));
            }
        }
    }, { passive: true });

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden') {
            stopAutoplay();
        } else if (!manualPaused) {
            startAutoplay();
        }
    });

    startAutoplay();
}

// Master Initialization for Phase 19 Modern Architecture
function initApp() {
    initSearchOverlay();
    initWishlist();
    initCartDrawer();
    initMobileStickyBar();
    initHeroSlider();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initApp);
} else {
    initApp();
}
