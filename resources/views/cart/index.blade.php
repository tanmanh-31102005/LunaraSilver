@extends('layouts.app')

@section('title', 'Giỏ hàng | Lunara Silver')
@section('main_class', 'cart-main')

@section('content')
    <div class="lunara-container cart-page">
        <x-breadcrumb :items="[['label' => 'Giỏ hàng']]" />
        <h1>Giỏ hàng</h1>
        <p class="cart-feedback" id="cartPageFeedback" role="status" aria-live="polite"></p>

        @if($cartSummary['items'])
            <div class="cart-layout" id="cartLayout">
                <div class="cart-lines">
                    @foreach($cartSummary['items'] as $item)
                        <article class="cart-line" data-cart-item="{{ $item['id'] }}">
                            <div class="cart-line__media">
                                @if($item['image_url'])<img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" width="110" height="138" loading="lazy">@else<span role="img" aria-label="Chưa có ảnh sản phẩm"><i class="bi bi-image" aria-hidden="true"></i></span>@endif
                            </div>
                            <div class="cart-line__details">
                                <h2><a href="{{ route('products.show', $item['slug']) }}">{{ $item['name'] }}</a></h2>
                                <p>SKU: {{ $item['sku'] }}</p>
                                @if($item['type'] !== 'single')<small>{{ $item['type'] === 'gift' ? 'Set quà tặng' : 'Bộ trang sức' }}</small>@endif
                                <span class="cart-line__unit">{{ $item['unit_price_display'] }} / sản phẩm</span>
                            </div>
                            <form class="cart-line__quantity" action="{{ route('cart.items.update', $item['id']) }}" method="post" data-cart-update>
                                @csrf @method('PATCH')
                                <label for="cart-quantity-{{ $item['id'] }}">Số lượng</label>
                                <div><input class="form-control" id="cart-quantity-{{ $item['id'] }}" type="number" name="quantity" min="1" max="1000" value="{{ $item['quantity'] }}" required><button class="btn btn-outline-dark" type="submit">Cập nhật</button></div>
                            </form>
                            <div class="cart-line__end"><strong data-line-subtotal>{{ $item['line_subtotal_display'] }}</strong><button class="cart-line__remove" type="button" data-cart-remove data-url="{{ route('cart.items.destroy', $item['id']) }}" aria-label="Xóa {{ $item['name'] }} khỏi giỏ hàng">Xóa</button></div>
                        </article>
                    @endforeach
                </div>
                <aside class="cart-summary" aria-label="Tóm tắt giỏ hàng">
                    <h2>Tóm tắt</h2>

                    <div class="cart-summary__lines mb-3">
                        <p class="d-flex justify-content-between align-items-center mb-2">
                            <span>Tạm tính</span>
                            <strong data-cart-subtotal>{{ $cartSummary['subtotal_display'] }}</strong>
                        </p>
                        
                        <p class="d-flex justify-content-between align-items-center mb-2 text-success" data-cart-discount-row style="{{ $cartSummary['coupon_applied'] ? '' : 'display: none !important;' }}">
                            <span>Giảm giá (<span data-cart-coupon-code>{{ $cartSummary['coupon_code'] ?? 'Ưu đãi' }}</span>)</span>
                            <strong data-cart-discount>{{ $cartSummary['discount_display'] }}</strong>
                        </p>

                        <p class="d-flex justify-content-between align-items-center mb-2 text-muted small">
                            <span>Phí vận chuyển</span>
                            <span>Tính khi thanh toán</span>
                        </p>

                        <hr class="my-2">

                        <p class="d-flex justify-content-between align-items-center mb-0 fs-5 fw-bold text-dark">
                            <span>Tổng cộng</span>
                            <strong class="text-primary" data-cart-grandtotal>{{ $cartSummary['grand_total_display'] }}</strong>
                        </p>
                    </div>

                    {{-- Coupon / Voucher Box --}}
                    <div class="cart-coupon-box p-3 bg-light rounded-3 border mb-3">
                        <div class="d-flex align-items-center gap-1 mb-2 fw-semibold text-dark small">
                            <i class="bi bi-ticket-perforated text-primary"></i>
                            <span>Mã giảm giá / Voucher</span>
                        </div>

                        @if(session('coupon_success'))
                            <div class="alert alert-success py-1 px-2 mb-2 small" role="alert">
                                <i class="bi bi-check-circle me-1"></i> {{ session('coupon_success') }}
                            </div>
                        @endif
                        @if($errors->has('coupon'))
                            <div class="alert alert-danger py-1 px-2 mb-2 small" role="alert">
                                <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first('coupon') }}
                            </div>
                        @endif

                        @if($cartSummary['coupon_applied'])
                            <div class="d-flex align-items-center justify-content-between p-2 bg-white rounded border">
                                <div>
                                    <span class="badge bg-primary text-white font-monospace">{{ $cartSummary['coupon_code'] }}</span>
                                    <span class="text-success small fw-bold ms-1">{{ $cartSummary['discount_display'] }}</span>
                                </div>
                                <form action="{{ route('cart.coupon.remove') }}" method="post" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 0.78rem;" type="submit" aria-label="Gỡ mã giảm giá">
                                        <i class="bi bi-x-lg"></i> Gỡ
                                    </button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('cart.coupon.apply') }}" method="post" class="d-flex gap-2">
                                @csrf
                                <input class="form-control form-control-sm font-monospace text-uppercase" type="text" name="code" placeholder="Mã ưu đãi (VD: LUNARA10)" value="{{ old('code') }}" required aria-label="Mã giảm giá">
                                <button class="btn btn-sm btn-dark text-nowrap px-3" type="submit">Áp dụng</button>
                            </form>
                        @endif
                    </div>

                    <a class="lunara-button lunara-button--dark w-100 text-center text-decoration-none" href="{{ route('checkout.show') }}">Tiến hành thanh toán</a>
                    <button class="cart-clear-button mt-2" type="button" data-cart-clear data-url="{{ route('cart.clear') }}" aria-label="Xóa toàn bộ giỏ hàng">Xóa toàn bộ giỏ hàng</button>
                </aside>
            </div>
        @else
            <x-empty-state title="Giỏ hàng đang trống." message="Khám phá các sản phẩm Lunara Silver." />
            <p class="text-center"><a class="lunara-button lunara-button--dark" href="{{ route('products.index') }}">Xem sản phẩm</a></p>
        @endif
    </div>
@endsection
