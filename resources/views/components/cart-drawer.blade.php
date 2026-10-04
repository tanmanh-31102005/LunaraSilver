<div class="offcanvas offcanvas-end cart-drawer" tabindex="-1" id="miniCart" aria-labelledby="miniCartTitle" data-bs-backdrop="true">
    <div class="offcanvas-header border-bottom py-3">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-bag fs-5 text-dark"></i>
            <h2 class="offcanvas-title h5 mb-0 font-serif" id="miniCartTitle">Giỏ Hàng</h2>
            <span class="badge bg-dark-subtle text-dark rounded-pill ms-1" data-drawer-count>{{ $headerCart['cart_count'] ?? 0 }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Đóng giỏ hàng"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-0">
        {{-- Free shipping progress bar (Phase 19 polish) --}}
        @php
            $subtotalNum = (float) ($headerCart['subtotal'] ?? 0);
            $freeshipThreshold = 500000;
            $percent = min(100, max(0, ($subtotalNum / $freeshipThreshold) * 100));
            $remaining = max(0, $freeshipThreshold - $subtotalNum);
        @endphp
        <div class="cart-drawer__freeship p-3 bg-light border-bottom" id="drawerFreeshipBanner">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="small text-muted" id="drawerFreeshipText">
                    @if($remaining <= 0)
                        <i class="bi bi-check-circle-fill text-success me-1"></i> <strong>Bạn được Miễn Phí Vận Chuyển toàn quốc!</strong>
                    @else
                        Mua thêm <strong class="text-dark">{{ number_format($remaining, 0, ',', '.') }} ₫</strong> để được <strong>Freeship</strong>
                    @endif
                </span>
            </div>
            <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-dark" id="drawerFreeshipBar" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        {{-- Cart items list --}}
        <div class="cart-drawer__items flex-grow-1 overflow-y-auto p-3" id="miniCartItems">
            @forelse($headerCart['items'] as $item)
                <div class="cart-drawer__item d-flex gap-3 py-3 border-bottom position-relative" data-cart-item-id="{{ $item['id'] }}">
                    <a href="{{ $item['url'] }}" class="cart-drawer__thumb ratio ratio-1x1 rounded overflow-hidden flex-shrink-0" style="width: 72px; height: 72px;">
                        @if($item['image_url'])
                            <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="object-fit-cover w-100 h-100">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center text-muted"><i class="bi bi-image"></i></div>
                        @endif
                    </a>
                    <div class="cart-drawer__details flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                            <h3 class="h6 mb-0 font-serif line-clamp-2">
                                <a href="{{ $item['url'] }}" class="text-dark text-decoration-none">{{ $item['name'] }}</a>
                            </h3>
                            <button type="button" class="btn btn-link btn-sm p-0 text-muted drawer-remove-btn" data-cart-remove="{{ $item['id'] }}" aria-label="Xóa {{ $item['name'] }}" title="Xóa">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                        <div class="small text-muted mb-2">
                            <span>{{ $item['unit_price_display'] }}</span>
                            @if($item['type'] !== 'single')
                                <span class="badge bg-secondary-subtle text-secondary ms-1">{{ $item['type'] === 'gift' ? 'Set quà' : 'Bộ combo' }}</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="stepper-widget stepper-widget--sm">
                                <button type="button" class="stepper-btn drawer-qty-btn" data-qty-action="minus" data-item-id="{{ $item['id'] }}" aria-label="Giảm"><i class="bi bi-dash"></i></button>
                                <input type="number" class="form-control stepper-input drawer-qty-input" value="{{ $item['quantity'] }}" min="1" max="99" data-item-id="{{ $item['id'] }}" readonly>
                                <button type="button" class="stepper-btn drawer-qty-btn" data-qty-action="plus" data-item-id="{{ $item['id'] }}" aria-label="Tăng"><i class="bi bi-plus"></i></button>
                            </div>
                            <span class="fw-semibold text-dark small" data-item-subtotal>{{ $item['line_subtotal_display'] }}</span>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty Cart State (Phase 19.55) --}}
                <div class="cart-drawer__empty text-center py-5 my-auto" id="drawerEmptyState">
                    <div class="mb-3">
                        <i class="bi bi-bag-x text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="h5 font-serif text-dark mb-2">Giỏ hàng của bạn đang trống</h3>
                    <p class="text-muted small mb-4">Khám phá các thiết kế trang sức bạc ánh trăng tinh tế của Lunara.</p>
                    <a href="{{ route('products.index') }}" class="lunara-button lunara-button--dark px-4 py-2" data-bs-dismiss="offcanvas">
                        Khám phá Lunara
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Footer summary & CTA --}}
        <div class="cart-drawer__footer border-top p-3 bg-white {{ empty($headerCart['items']) ? 'd-none' : '' }}" id="miniCartFooter">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted">Tạm tính:</span>
                <strong class="h5 font-serif mb-0 text-dark" id="miniCartSubtotal">{{ $headerCart['subtotal_display'] ?? '0 ₫' }}</strong>
            </div>
            @if(!empty($headerCart['coupon_applied']))
                <div class="d-flex justify-content-between align-items-center mb-2 text-success small" id="drawerCouponRow">
                    <span>Mã ưu đãi ({{ $headerCart['coupon_code'] }}):</span>
                    <span id="drawerDiscount">{{ $headerCart['discount_display'] }}</span>
                </div>
            @endif
            <p class="text-muted small mb-3" style="font-size: 0.75rem;">Phí vận chuyển và thuế sẽ được tính toán chi tiết tại trang thanh toán.</p>
            <div class="d-grid gap-2">
                <a href="{{ route('checkout.show') }}" class="lunara-button lunara-button--dark text-center py-2 text-uppercase fw-semibold" style="letter-spacing: 0.05em;">
                    <i class="bi bi-shield-check me-1"></i> Tiến Hành Thanh Toán
                </a>
                <a href="{{ route('cart.index') }}" class="lunara-button lunara-button--outline text-center py-2">
                    Xem chi tiết giỏ hàng
                </a>
            </div>
        </div>
    </div>
</div>
