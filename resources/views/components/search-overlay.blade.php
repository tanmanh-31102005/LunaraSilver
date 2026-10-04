<div class="search-overlay" id="searchOverlay" role="dialog" aria-modal="true" aria-labelledby="searchOverlayTitle" hidden>
    <div class="search-overlay__backdrop" data-search-close></div>
    <div class="search-overlay__panel">
        <div class="lunara-container">
            <div class="search-overlay__header">
                <form action="{{ route('search') }}" method="get" class="search-overlay__form" id="searchOverlayForm">
                    <i class="bi bi-search search-overlay__search-icon" aria-hidden="true"></i>
                    <input type="search"
                           id="searchOverlayInput"
                           name="q"
                           class="search-overlay__input"
                           placeholder="Tìm kiếm sản phẩm, danh mục, bài viết..."
                           autocomplete="off"
                           spellcheck="false"
                           aria-label="Tìm kiếm trang sức Lunara">
                    <button type="button" class="search-overlay__clear d-none" id="searchOverlayClear" aria-label="Xóa từ khóa">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                    <button type="button" class="search-overlay__close icon-button" data-search-close aria-label="Đóng tìm kiếm (ESC)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </form>
            </div>

            <div class="search-overlay__body" id="searchOverlayBody">
                {{-- Recent Searches (LocalStorage) --}}
                <div class="search-overlay__section search-overlay__recent" id="searchRecentSection">
                    <div class="search-overlay__section-header">
                        <span class="search-overlay__section-title"><i class="bi bi-clock-history me-1"></i> Tìm kiếm gần đây</span>
                        <button type="button" class="btn btn-link btn-sm p-0 text-muted text-decoration-none" id="clearRecentSearchBtn">Xóa lịch sử</button>
                    </div>
                    <div class="search-overlay__chips" id="searchRecentChips"></div>
                </div>

                {{-- Popular Categories Quick Links --}}
                <div class="search-overlay__section search-overlay__quick" id="searchQuickSection">
                    <span class="search-overlay__section-title">Khám phá nhanh</span>
                    <div class="search-overlay__chips">
                        <a href="{{ route('products.category', 'day-chuyen') }}" class="search-chip">Dây chuyền</a>
                        <a href="{{ route('products.category', 'nhan') }}" class="search-chip">Nhẫn ánh trăng</a>
                        <a href="{{ route('products.category', 'vong-tay') }}" class="search-chip">Vòng tay tinh tú</a>
                        <a href="{{ route('products.category', 'bo-trang-suc') }}" class="search-chip">Bộ trang sức</a>
                        <a href="{{ route('products.category', 'set-qua-tang') }}" class="search-chip">Set quà tặng</a>
                    </div>
                </div>

                {{-- Live Results Container (filled via AJAX) --}}
                <div class="search-overlay__results d-none" id="searchResultsContainer">
                    <div class="search-overlay__loading text-center py-4 d-none" id="searchLoadingIndicator">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                        <span class="text-muted small">Đang tìm kiếm...</span>
                    </div>

                    <div id="searchSuggestionsContent"></div>

                    <div class="search-overlay__view-all d-none text-center pt-3 border-top mt-3" id="searchViewAllWrap">
                        <a href="#" class="lunara-button lunara-button--outline py-2 px-4" id="searchViewAllLink">
                            Xem tất cả kết quả cho “<span id="searchViewAllTerm"></span>” →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
