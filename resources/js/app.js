import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

function renderCart(data) {
    document.querySelectorAll('[data-cart-count]').forEach((element) => {
        element.textContent = data.cart_count;
    });
    const subtotal = document.querySelector('#miniCartSubtotal');
    if (subtotal) subtotal.textContent = data.subtotal_display;

    const mini = document.querySelector('#miniCartItems');
    if (mini) {
        mini.replaceChildren();
        if (!data.items.length) {
            const empty = document.createElement('p');
            empty.textContent = 'Giỏ hàng đang trống.';
            mini.append(empty);
        }
        data.items.slice(0, 3).forEach((item) => {
            const row = document.createElement('div');
            row.className = 'mini-cart__item';
            if (item.image_url) {
                const image = document.createElement('img');
                image.src = item.image_url;
                image.alt = item.name;
                image.width = 64;
                image.height = 80;
                row.append(image);
            }
            const details = document.createElement('div');
            const link = document.createElement('a');
            link.href = item.url;
            link.textContent = item.name;
            const quantity = document.createElement('small');
            quantity.textContent = `${item.quantity} × ${item.unit_price_display}`;
            details.append(link, quantity);
            row.append(details);
            mini.append(row);
        });
    }

    const pageSubtotal = document.querySelector('[data-cart-subtotal]');
    if (pageSubtotal) pageSubtotal.textContent = data.subtotal_display;
    document.querySelectorAll('[data-cart-item]').forEach((row) => {
        const item = data.items.find((candidate) => candidate.id === Number(row.dataset.cartItem));
        if (!item) {
            row.remove();
            return;
        }
        row.querySelector('[name="quantity"]').value = item.quantity;
        row.querySelector('[data-line-subtotal]').textContent = item.line_subtotal_display;
    });
    if (document.querySelector('#cartLayout') && !data.items.length) window.location.reload();
}

async function cartRequest(url, method, payload, feedback) {
    try {
        const response = await fetch(url, {
            method,
            headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: payload ? JSON.stringify(payload) : undefined,
        });
        const data = await response.json();
        if (feedback) feedback.textContent = data.message || 'Không thể cập nhật giỏ hàng.';
        if (data.items) renderCart(data);
    } catch {
        if (feedback) feedback.textContent = 'Không thể kết nối. Vui lòng thử lại.';
    }
}

document.querySelectorAll('[data-add-cart]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const values = new FormData(form);
        cartRequest(form.action, 'POST', {
            product_id: Number(values.get('product_id')),
            quantity: Number(values.get('quantity')),
        }, form.querySelector('.cart-feedback'));
    });
});

document.querySelectorAll('[data-cart-update]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        cartRequest(form.action, 'PATCH', { quantity: Number(new FormData(form).get('quantity')) }, document.querySelector('#cartPageFeedback'));
    });
});

document.querySelectorAll('[data-cart-remove]').forEach((button) => {
    button.addEventListener('click', () => {
        cartRequest(button.dataset.url, 'DELETE', null, document.querySelector('#cartPageFeedback'));
    });
});

document.querySelectorAll('[data-cart-clear]').forEach((button) => {
    button.addEventListener('click', () => {
        if (window.confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng không?')) {
            cartRequest(button.dataset.url, 'DELETE', null, document.querySelector('#cartPageFeedback'));
        }
    });
});

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

// Quantity Stepper Widget
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

// "Mua ngay" (Buy Now) Button
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
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
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

// Quick Add from Product Cards
document.querySelectorAll('[data-quick-add]').forEach((button) => {
    button.addEventListener('click', async (e) => {
        e.preventDefault();
        e.stopPropagation();
        const productId = Number(button.dataset.quickAdd);
        if (!productId) return;
        const originalHtml = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        try {
            const response = await fetch('/cart/items', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ product_id: productId, quantity: 1 }),
            });
            const data = await response.json();
            if (data.items) {
                renderCart(data);
                button.innerHTML = '<i class="bi bi-check2 me-1"></i> Đã thêm';
                setTimeout(() => {
                    button.disabled = false;
                    button.innerHTML = originalHtml;
                }, 1600);
            } else {
                button.disabled = false;
                button.innerHTML = originalHtml;
            }
        } catch {
            button.disabled = false;
            button.innerHTML = originalHtml;
        }
    });
});

// ==========================================================================
// Lunara Premium Hero Slider (3-Slide Carousel)
// ==========================================================================
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

    // Indicator clicks
    indicators.forEach((indicator, idx) => {
        indicator.addEventListener('click', () => {
            handleUserAction(() => goToSlide(idx));
        });
    });

    // Prev / Next clicks
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

    // Accessible pause button
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

    // Hover pause (desktop)
    slider.addEventListener('mouseenter', () => {
        isPaused = true;
    });

    slider.addEventListener('mouseleave', () => {
        isPaused = false;
    });

    // Keyboard focus pause
    slider.addEventListener('focusin', () => {
        isPaused = true;
    });

    slider.addEventListener('focusout', (e) => {
        if (!slider.contains(e.relatedTarget)) {
            isPaused = false;
        }
    });

    // Arrow keys navigation
    slider.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            handleUserAction(() => goToSlide(currentIndex - 1));
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            handleUserAction(() => goToSlide(currentIndex + 1));
        }
    });

    // Touch swipe gestures (mobile)
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

        // Horizontal swipe if X travel > 45px and greater than Y travel
        if (Math.abs(diffX) > 45 && Math.abs(diffX) > Math.abs(diffY)) {
            if (diffX < 0) {
                handleUserAction(() => goToSlide(currentIndex + 1));
            } else {
                handleUserAction(() => goToSlide(currentIndex - 1));
            }
        }
    }, { passive: true });

    // Page visibility change
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden') {
            stopAutoplay();
        } else if (!manualPaused) {
            startAutoplay();
        }
    });

    // Start on load
    startAutoplay();
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeroSlider);
} else {
    initHeroSlider();
}

