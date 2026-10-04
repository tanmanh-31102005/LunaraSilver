/**
 * Lunara Modern Search Overlay & Suggestions (Phase 19.3 - 19.13, 19.60)
 */

const STORAGE_KEY = 'lunara_recent_searches';
const MAX_RECENT = 5;

function escapeHtml(str) {
    if (!str) return '';
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

export function initSearchOverlay() {
    const overlay = document.querySelector('#searchOverlay');
    if (!overlay) return;

    const input = document.querySelector('#searchOverlayInput');
    const form = document.querySelector('#searchOverlayForm');
    const clearBtn = document.querySelector('#searchOverlayClear');
    const recentSection = document.querySelector('#searchRecentSection');
    const recentChips = document.querySelector('#searchRecentChips');
    const clearRecentBtn = document.querySelector('#clearRecentSearchBtn');
    const quickSection = document.querySelector('#searchQuickSection');
    const resultsContainer = document.querySelector('#searchResultsContainer');
    const loadingIndicator = document.querySelector('#searchLoadingIndicator');
    const suggestionsContent = document.querySelector('#searchSuggestionsContent');
    const viewAllWrap = document.querySelector('#searchViewAllWrap');
    const viewAllLink = document.querySelector('#searchViewAllLink');
    const viewAllTerm = document.querySelector('#searchViewAllTerm');

    let debounceTimer = null;
    let abortController = null;
    let lastFocusedElement = null;

    // LocalStorage Recent Searches Management
    function getRecentSearches() {
        try {
            const data = localStorage.getItem(STORAGE_KEY);
            return data ? JSON.parse(data) : [];
        } catch {
            return [];
        }
    }

    function saveRecentSearch(query) {
        const trimmed = query.trim();
        if (!trimmed || trimmed.length < 2) return;

        let recent = getRecentSearches();
        recent = recent.filter(item => item.toLowerCase() !== trimmed.toLowerCase());
        recent.unshift(trimmed);
        if (recent.length > MAX_RECENT) {
            recent = recent.slice(0, MAX_RECENT);
        }

        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(recent));
        } catch (e) {
            console.warn('Could not save recent search to localStorage', e);
        }
    }

    function renderRecentSearches() {
        if (!recentSection || !recentChips) return;
        const recent = getRecentSearches();

        if (recent.length === 0) {
            recentSection.classList.add('d-none');
            return;
        }

        recentSection.classList.remove('d-none');
        recentChips.innerHTML = '';

        recent.forEach(term => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'search-chip search-chip--recent';
            button.innerHTML = `<i class="bi bi-clock-history me-1" aria-hidden="true"></i> ${escapeHtml(term)}`;
            button.addEventListener('click', () => {
                if (input) {
                    input.value = term;
                    input.focus();
                    performSearch(term);
                }
            });
            recentChips.appendChild(button);
        });
    }

    if (clearRecentBtn) {
        clearRecentBtn.addEventListener('click', () => {
            try {
                localStorage.removeItem(STORAGE_KEY);
            } catch {}
            renderRecentSearches();
        });
    }

    // Overlay Open / Close / Focus Trap
    function openOverlay() {
        lastFocusedElement = document.activeElement;
        overlay.removeAttribute('hidden');
        document.body.style.overflow = 'hidden';
        renderRecentSearches();

        setTimeout(() => {
            if (input) {
                input.focus();
                if (input.value.trim().length >= 2) {
                    performSearch(input.value.trim());
                } else {
                    resetToDefaultView();
                }
            }
        }, 60);
    }

    function closeOverlay() {
        overlay.setAttribute('hidden', '');
        document.body.style.overflow = '';
        if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
            lastFocusedElement.focus();
        }
    }

    document.querySelectorAll('[data-search-open]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openOverlay();
        });
    });

    document.querySelectorAll('[data-search-close]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            closeOverlay();
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !overlay.hasAttribute('hidden')) {
            e.preventDefault();
            closeOverlay();
        }
    });

    // Reset overlay view back to Recent + Quick
    function resetToDefaultView() {
        if (resultsContainer) resultsContainer.classList.add('d-none');
        if (quickSection) quickSection.classList.remove('d-none');
        if (clearBtn) clearBtn.classList.add('d-none');
        renderRecentSearches();
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            if (input) {
                input.value = '';
                input.focus();
            }
            resetToDefaultView();
        });
    }

    // Live Suggestions Fetch
    async function performSearch(query) {
        const trimmed = query.trim();
        if (clearBtn) {
            clearBtn.classList.toggle('d-none', trimmed.length === 0);
        }

        if (trimmed.length < 2) {
            resetToDefaultView();
            return;
        }

        if (recentSection) recentSection.classList.add('d-none');
        if (quickSection) quickSection.classList.add('d-none');
        if (resultsContainer) resultsContainer.classList.remove('d-none');
        if (loadingIndicator) loadingIndicator.classList.remove('d-none');
        if (suggestionsContent) suggestionsContent.innerHTML = '';
        if (viewAllWrap) viewAllWrap.classList.add('d-none');

        if (abortController) {
            abortController.abort();
        }
        abortController = new AbortController();

        try {
            const response = await fetch(`/api/search/suggestions?q=${encodeURIComponent(trimmed)}`, {
                headers: { 'Accept': 'application/json' },
                signal: abortController.signal
            });

            if (!response.ok) throw new Error('Network error');
            const data = await response.json();

            if (loadingIndicator) loadingIndicator.classList.add('d-none');
            renderSuggestions(data, trimmed);
        } catch (err) {
            if (err.name === 'AbortError') return;
            if (loadingIndicator) loadingIndicator.classList.add('d-none');
            if (suggestionsContent) {
                suggestionsContent.innerHTML = `
                    <div class="text-center py-4 text-muted small">
                        Không thể tải gợi ý lúc này. Nhấn Enter để xem trang kết quả.
                    </div>
                `;
            }
        }
    }

    function renderSuggestions(data, query) {
        if (!suggestionsContent) return;

        const hasProducts = data.products && data.products.length > 0;
        const hasCategories = data.categories && data.categories.length > 0;
        const hasPosts = data.posts && data.posts.length > 0;

        if (!hasProducts && !hasCategories && !hasPosts) {
            // Phase 19.53: Empty state with suggested categories
            suggestionsContent.innerHTML = `
                <div class="search-overlay__empty text-center py-5">
                    <p class="h6 mb-2 text-dark font-serif">Không tìm thấy kết quả nào cho “${escapeHtml(query)}”.</p>
                    <p class="text-muted small mb-4">Thử tìm bằng từ khóa khác hoặc khám phá danh mục nổi bật:</p>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="/products/day-chuyen" class="search-chip">Dây chuyền</a>
                        <a href="/products/nhan" class="search-chip">Nhẫn ánh trăng</a>
                        <a href="/products/vong-tay" class="search-chip">Vòng tay tinh tú</a>
                        <a href="/products/bo-trang-suc" class="search-chip">Bộ trang sức</a>
                        <a href="/products/set-qua-tang" class="search-chip">Set quà tặng</a>
                    </div>
                </div>
            `;
            if (viewAllWrap) viewAllWrap.classList.add('d-none');
            return;
        }

        let html = '';

        // 1. Categories suggestions
        if (hasCategories) {
            html += `
                <div class="mb-3">
                    <span class="search-overlay__section-title d-block mb-2">Danh mục phù hợp</span>
                    <div class="d-flex flex-wrap gap-2">
            `;
            data.categories.forEach(cat => {
                html += `
                    <a href="${escapeHtml(cat.url)}" class="search-chip">
                        <i class="bi bi-tag me-1 text-muted" aria-hidden="true"></i> ${escapeHtml(cat.name)}
                    </a>
                `;
            });
            html += `</div></div>`;
        }

        // 2. Products suggestions
        if (hasProducts) {
            html += `
                <div class="mb-3">
                    <span class="search-overlay__section-title d-block mb-2">Sản phẩm (${data.products.length})</span>
                    <div class="search-suggestion-list">
            `;
            data.products.forEach(prod => {
                const imgTag = prod.image_url
                    ? `<img src="${escapeHtml(prod.image_url)}" alt="${escapeHtml(prod.name)}" class="search-suggestion-thumb">`
                    : `<div class="search-suggestion-thumb d-flex align-items-center justify-content-center text-muted"><i class="bi bi-image"></i></div>`;

                const stockBadge = prod.in_stock ? '' : '<span class="badge bg-secondary-subtle text-secondary ms-2 small">Hết hàng</span>';

                html += `
                    <a href="${escapeHtml(prod.url)}" class="search-suggestion-item">
                        ${imgTag}
                        <div class="search-suggestion-meta">
                            <div class="search-suggestion-name">${escapeHtml(prod.name)} ${stockBadge}</div>
                            <div class="search-suggestion-category">${escapeHtml(prod.category_name)} · SKU: ${escapeHtml(prod.sku)}</div>
                        </div>
                        <div class="search-suggestion-price">${escapeHtml(prod.price_display)}</div>
                    </a>
                `;
            });
            html += `</div></div>`;
        }

        // 3. Blog posts suggestions
        if (hasPosts) {
            html += `
                <div class="mb-3">
                    <span class="search-overlay__section-title d-block mb-2">Bài viết Lunara (${data.posts.length})</span>
                    <div class="search-suggestion-list">
            `;
            data.posts.forEach(post => {
                html += `
                    <a href="${escapeHtml(post.url)}" class="search-suggestion-item">
                        <i class="bi bi-journal-text text-muted fs-5 me-1" aria-hidden="true"></i>
                        <div class="search-suggestion-meta">
                            <div class="search-suggestion-name">${escapeHtml(post.title)}</div>
                            <div class="text-muted small text-truncate" style="max-width: 480px;">${escapeHtml(post.excerpt)}</div>
                        </div>
                        <i class="bi bi-arrow-right text-muted small"></i>
                    </a>
                `;
            });
            html += `</div></div>`;
        }

        suggestionsContent.innerHTML = html;

        // View All link setup
        if (viewAllWrap && viewAllLink && viewAllTerm) {
            viewAllTerm.textContent = query;
            viewAllLink.href = `/search?q=${encodeURIComponent(query)}`;
            viewAllWrap.classList.remove('d-none');
        }
    }

    // Input debounce (300ms)
    if (input) {
        input.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            const val = input.value;
            debounceTimer = setTimeout(() => {
                performSearch(val);
            }, 300);
        });
    }

    // Submit form -> save to recent searches
    if (form) {
        form.addEventListener('submit', () => {
            if (input && input.value.trim().length >= 2) {
                saveRecentSearch(input.value.trim());
            }
        });
    }
}
