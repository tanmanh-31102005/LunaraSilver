/**
 * Lunara Cart Drawer & Mini-Cart UX (Phase 19.31 - 19.38)
 */
import * as bootstrap from 'bootstrap';

const FREESHIP_THRESHOLD = 500000;

function escapeHtml(str) {
    if (!str) return '';
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function formatVnd(number) {
    return new Intl.NumberFormat('vi-VN').format(Math.max(0, Math.round(number))) + ' ₫';
}

export function initCartDrawer() {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const drawerEl = document.querySelector('#miniCart');
    let offcanvas = null;

    if (drawerEl) {
        offcanvas = bootstrap.Offcanvas.getOrCreateInstance(drawerEl);
    }

    function openDrawer() {
        if (offcanvas) {
            offcanvas.show();
        }
    }

    // Render Drawer contents given server CartService summary data
    function renderDrawer(data) {
        if (!data) return;

        // 1. Update count badges
        const count = data.cart_count ?? 0;
        document.querySelectorAll('[data-cart-count]').forEach(el => {
            el.textContent = count;
        });
        document.querySelectorAll('[data-drawer-count]').forEach(el => {
            el.textContent = count;
        });

        // 2. Subtotal
        const subtotalEl = document.querySelector('#miniCartSubtotal');
        if (subtotalEl) {
            subtotalEl.textContent = data.subtotal_display || formatVnd(data.subtotal || 0);
        }

        // 3. Coupon & Discount row
        const couponRow = document.querySelector('#drawerCouponRow');
        const discountEl = document.querySelector('#drawerDiscount');
        if (couponRow) {
            if (data.coupon_applied) {
                couponRow.classList.remove('d-none');
                if (discountEl) discountEl.textContent = data.discount_display;
            } else {
                couponRow.classList.add('d-none');
            }
        }

        // 4. Free shipping progress meter
        const subtotalNum = Number(data.subtotal || 0);
        const remaining = Math.max(0, FREESHIP_THRESHOLD - subtotalNum);
        const percent = Math.min(100, Math.max(0, (subtotalNum / FREESHIP_THRESHOLD) * 100));

        const freeshipBar = document.querySelector('#drawerFreeshipBar');
        const freeshipText = document.querySelector('#drawerFreeshipText');
        if (freeshipBar) {
            freeshipBar.style.width = `${percent}%`;
            freeshipBar.setAttribute('aria-valuenow', percent);
        }
        if (freeshipText) {
            if (remaining <= 0) {
                freeshipText.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i> <strong>Bạn được Miễn Phí Vận Chuyển toàn quốc!</strong>';
            } else {
                freeshipText.innerHTML = `Mua thêm <strong class="text-dark">${formatVnd(remaining)}</strong> để được <strong>Freeship</strong>`;
            }
        }

        // 5. Items container & footer
        const itemsContainer = document.querySelector('#miniCartItems');
        const footer = document.querySelector('#miniCartFooter');
        const items = data.items || [];

        if (itemsContainer) {
            if (items.length === 0) {
                if (footer) footer.classList.add('d-none');
                itemsContainer.innerHTML = `
                    <div class="cart-drawer__empty text-center py-5 my-auto" id="drawerEmptyState">
                        <div class="mb-3">
                            <i class="bi bi-bag-x text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="h5 font-serif text-dark mb-2">Giỏ hàng của bạn đang trống</h3>
                        <p class="text-muted small mb-4">Khám phá các thiết kế trang sức bạc ánh trăng tinh tế của Lunara.</p>
                        <a href="/products" class="lunara-button lunara-button--dark px-4 py-2" data-bs-dismiss="offcanvas">
                            Khám phá Lunara
                        </a>
                    </div>
                `;
            } else {
                if (footer) footer.classList.remove('d-none');
                let itemsHtml = '';
                items.forEach(item => {
                    const imgHtml = item.image_url
                        ? `<img src="${escapeHtml(item.image_url)}" alt="${escapeHtml(item.name)}" class="object-fit-cover w-100 h-100">`
                        : `<div class="bg-light d-flex align-items-center justify-content-center text-muted"><i class="bi bi-image"></i></div>`;

                    const badgeHtml = item.type !== 'single'
                        ? `<span class="badge bg-secondary-subtle text-secondary ms-1">${item.type === 'gift' ? 'Set quà' : 'Bộ combo'}</span>`
                        : '';

                    itemsHtml += `
                        <div class="cart-drawer__item d-flex gap-3 py-3 border-bottom position-relative" data-cart-item-id="${item.id}">
                            <a href="${escapeHtml(item.url)}" class="cart-drawer__thumb ratio ratio-1x1 rounded overflow-hidden flex-shrink-0" style="width: 72px; height: 72px;">
                                ${imgHtml}
                            </a>
                            <div class="cart-drawer__details flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                    <h3 class="h6 mb-0 font-serif line-clamp-2">
                                        <a href="${escapeHtml(item.url)}" class="text-dark text-decoration-none">${escapeHtml(item.name)}</a>
                                    </h3>
                                    <button type="button" class="btn btn-link btn-sm p-0 text-muted drawer-remove-btn" data-cart-remove="${item.id}" aria-label="Xóa ${escapeHtml(item.name)}" title="Xóa">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                                <div class="small text-muted mb-2">
                                    <span>${escapeHtml(item.unit_price_display)}</span>
                                    ${badgeHtml}
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stepper-widget stepper-widget--sm">
                                        <button type="button" class="stepper-btn drawer-qty-btn" data-qty-action="minus" data-item-id="${item.id}" aria-label="Giảm"><i class="bi bi-dash"></i></button>
                                        <input type="number" class="form-control stepper-input drawer-qty-input" value="${item.quantity}" min="1" max="99" data-item-id="${item.id}" readonly>
                                        <button type="button" class="stepper-btn drawer-qty-btn" data-qty-action="plus" data-item-id="${item.id}" aria-label="Tăng"><i class="bi bi-plus"></i></button>
                                    </div>
                                    <span class="fw-semibold text-dark small" data-item-subtotal>${escapeHtml(item.line_subtotal_display)}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });
                itemsContainer.innerHTML = itemsHtml;
            }
        }

        // Sync main /cart page if open
        const pageSubtotal = document.querySelector('[data-cart-subtotal]');
        if (pageSubtotal) pageSubtotal.textContent = data.subtotal_display;

        const discountRow = document.querySelector('[data-cart-discount-row]');
        const discountVal = document.querySelector('[data-cart-discount]');
        const grandTotalVal = document.querySelector('[data-cart-grandtotal]');

        if (discountRow) {
            discountRow.style.setProperty('display', data.coupon_applied ? 'flex' : 'none', 'important');
            if (discountVal) discountVal.textContent = data.discount_display;
        }
        if (grandTotalVal) {
            grandTotalVal.textContent = data.grand_total_display || data.subtotal_display;
        }

        document.querySelectorAll('[data-cart-item]').forEach(row => {
            const item = items.find(candidate => candidate.id === Number(row.dataset.cartItem));
            if (!item) {
                row.remove();
                return;
            }
            const qInput = row.querySelector('[name="quantity"]');
            if (qInput) qInput.value = item.quantity;
            const lineSubtotal = row.querySelector('[data-line-subtotal]');
            if (lineSubtotal) lineSubtotal.textContent = item.line_subtotal_display;
        });

        if (document.querySelector('#cartLayout') && items.length === 0) {
            window.location.reload();
        }
    }

    // AJAX helper for cart actions
    async function executeCartAction(url, method, payload) {
        const response = await fetch(url, {
            method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf || ''
            },
            body: payload ? JSON.stringify(payload) : undefined
        });

        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Thao tác không thành công.');
        }

        renderDrawer(data);
        return data;
    }

    // 1. Intercept Product Detail Add to Cart form
    document.querySelectorAll('[data-add-cart]').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            const values = new FormData(form);
            const productId = Number(values.get('product_id'));
            const quantity = Number(values.get('quantity')) || 1;

            if (!productId) return;

            const originalHtml = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Đang thêm...';
            }

            try {
                const data = await executeCartAction('/cart/items', 'POST', {
                    product_id: productId,
                    quantity: quantity
                });

                if (window.LunaraToast) {
                    window.LunaraToast.show(data.message || 'Đã thêm vào giỏ hàng.', 'success');
                }
                openDrawer();
            } catch (err) {
                if (window.LunaraToast) {
                    window.LunaraToast.show(err.message || 'Không thể thêm vào giỏ hàng.', 'error');
                }
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                }
            }
        });
    });

    // 2. Intercept Quick Add from Product Cards
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-quick-add]');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        const productId = Number(btn.dataset.quickAdd);
        if (!productId || btn.disabled) return;

        btn.disabled = true;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        try {
            const data = await executeCartAction('/cart/items', 'POST', {
                product_id: productId,
                quantity: 1
            });

            if (window.LunaraToast) {
                window.LunaraToast.show(data.message || 'Đã thêm vào giỏ hàng.', 'success');
            }
            openDrawer();
        } catch (err) {
            if (window.LunaraToast) {
                window.LunaraToast.show(err.message || 'Không thể thêm vào giỏ hàng.', 'error');
            }
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }
    });

    // 3. Intercept Mobile Sticky Bar Add to Cart
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-sticky-add-cart]');
        if (!btn) return;

        e.preventDefault();
        const productId = Number(btn.dataset.productId);
        if (!productId || btn.disabled) return;

        btn.disabled = true;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>';

        try {
            const data = await executeCartAction('/cart/items', 'POST', {
                product_id: productId,
                quantity: 1
            });

            if (window.LunaraToast) {
                window.LunaraToast.show(data.message || 'Đã thêm vào giỏ hàng.', 'success');
            }
            openDrawer();
        } catch (err) {
            if (window.LunaraToast) {
                window.LunaraToast.show(err.message || 'Không thể thêm vào giỏ hàng.', 'error');
            }
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }
    });

    // 4. Drawer Quantity Stepper (+ / -)
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.drawer-qty-btn');
        if (!btn) return;

        e.preventDefault();
        const action = btn.dataset.qtyAction;
        const itemId = Number(btn.dataset.itemId);
        const itemRow = btn.closest('.cart-drawer__item');
        const input = itemRow?.querySelector('.drawer-qty-input');
        if (!itemId || !input || btn.disabled) return;

        let currentQty = Number(input.value) || 1;
        let newQty = action === 'plus' ? currentQty + 1 : currentQty - 1;

        if (newQty < 1) return;

        btn.disabled = true;
        try {
            await executeCartAction(`/cart/items/${itemId}`, 'PATCH', { quantity: newQty });
        } catch (err) {
            if (window.LunaraToast) {
                window.LunaraToast.show(err.message || 'Không thể cập nhật số lượng.', 'error');
            }
        } finally {
            btn.disabled = false;
        }
    });

    // 5. Drawer Remove item
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-cart-remove]');
        if (!btn || !btn.closest('#miniCart')) return;

        e.preventDefault();
        const itemId = Number(btn.dataset.cartRemove);
        if (!itemId || btn.disabled) return;

        btn.disabled = true;
        try {
            const data = await executeCartAction(`/cart/items/${itemId}`, 'DELETE');
            if (window.LunaraToast) {
                window.LunaraToast.show(data.message || 'Đã xóa sản phẩm khỏi giỏ.', 'info');
            }
        } catch (err) {
            if (window.LunaraToast) {
                window.LunaraToast.show(err.message || 'Không thể xóa sản phẩm.', 'error');
            }
        } finally {
            btn.disabled = false;
        }
    });
}
