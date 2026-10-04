/**
 * Lunara Wishlist Client Interactions (Phase 19.14 - 19.24)
 */

export function initWishlist() {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-wishlist-btn]');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        const productId = btn.dataset.productId;
        if (!productId || btn.disabled) return;

        btn.disabled = true;
        const originalHtml = btn.innerHTML;

        try {
            const response = await fetch(`/wishlist/${productId}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf || ''
                }
            });

            if (!response.ok) throw new Error('Request failed');
            const data = await response.json();

            if (data.success) {
                // Update all buttons for this product across the page
                updateWishlistButtons(productId, data.added);

                // Update all header & account count badges
                updateWishlistCount(data.count);

                // Toast feedback
                if (window.LunaraToast) {
                    window.LunaraToast.show(data.message, 'success');
                }

                // If on wishlist page and item was removed
                const pageItem = document.querySelector(`[data-wishlist-page-item="${productId}"]`);
                if (pageItem && !data.added) {
                    pageItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    pageItem.style.opacity = '0';
                    pageItem.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        pageItem.remove();
                        if (data.count === 0) {
                            window.location.reload();
                        }
                    }, 300);
                }
            } else {
                throw new Error(data.message || 'Lỗi không xác định');
            }
        } catch (err) {
            console.error('Wishlist error:', err);
            if (window.LunaraToast) {
                window.LunaraToast.show('Không thể thực hiện lúc này. Vui lòng thử lại.', 'error');
            }
        } finally {
            btn.disabled = false;
        }
    });

    // Wishlist page remove buttons
    document.querySelectorAll('[data-wishlist-remove]').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = btn.dataset.wishlistRemove;
            if (!productId || btn.disabled) return;

            btn.disabled = true;
            try {
                const response = await fetch(`/wishlist/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf || ''
                    }
                });

                if (!response.ok) throw new Error('Request failed');
                const data = await response.json();

                if (data.success) {
                    updateWishlistCount(data.count);
                    updateWishlistButtons(productId, false);

                    if (window.LunaraToast) {
                        window.LunaraToast.show(data.message, 'success');
                    }

                    const pageItem = document.querySelector(`[data-wishlist-page-item="${productId}"]`);
                    if (pageItem) {
                        pageItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        pageItem.style.opacity = '0';
                        pageItem.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            pageItem.remove();
                            if (data.count === 0) {
                                window.location.reload();
                            }
                        }, 300);
                    }
                }
            } catch (err) {
                if (window.LunaraToast) {
                    window.LunaraToast.show('Không thể thực hiện lúc này. Vui lòng thử lại.', 'error');
                }
            } finally {
                btn.disabled = false;
            }
        });
    });
}

function updateWishlistButtons(productId, isWishlisted) {
    document.querySelectorAll(`[data-wishlist-btn][data-product-id="${productId}"]`).forEach(btn => {
        btn.setAttribute('aria-pressed', isWishlisted ? 'true' : 'false');

        const isDetail = btn.classList.contains('detail-wishlist-btn');

        if (isDetail) {
            btn.classList.toggle('detail-wishlist-btn--active', isWishlisted);
            const icon = btn.querySelector('i.bi');
            if (icon) {
                icon.className = `bi ${isWishlisted ? 'bi-heart-fill text-danger' : 'bi-heart'}`;
            }
            const text = btn.querySelector('.detail-wishlist-btn__text');
            if (text) {
                text.textContent = isWishlisted ? 'Đã yêu thích' : 'Yêu thích';
            }
            btn.setAttribute('aria-label', isWishlisted ? 'Đã yêu thích sản phẩm' : 'Thêm vào yêu thích');
        } else {
            btn.classList.toggle('product-card__wishlist--active', isWishlisted);
            const icon = btn.querySelector('i.bi');
            if (icon) {
                icon.className = `bi ${isWishlisted ? 'bi-heart-fill text-danger' : 'bi-heart'}`;
            }
            btn.setAttribute('aria-label', isWishlisted ? 'Xóa khỏi yêu thích' : 'Thêm vào yêu thích');
            btn.setAttribute('title', isWishlisted ? 'Đã yêu thích' : 'Thêm vào yêu thích');
        }
    });
}

function updateWishlistCount(count) {
    document.querySelectorAll('[data-wishlist-count]').forEach(el => {
        el.textContent = count;
    });
}
