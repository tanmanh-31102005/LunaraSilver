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
                    <p><span>Tạm tính</span><strong data-cart-subtotal>{{ $cartSummary['subtotal_display'] }}</strong></p>
                    <small>Phí vận chuyển sẽ được tính ở bước thanh toán.</small>
                    <a class="lunara-button lunara-button--dark w-100 mt-3 text-center text-decoration-none" href="{{ route('checkout.show') }}">Tiến hành thanh toán</a>
                    <button class="cart-clear-button" type="button" data-cart-clear data-url="{{ route('cart.clear') }}" aria-label="Xóa toàn bộ giỏ hàng">Xóa toàn bộ giỏ hàng</button>
                </aside>
            </div>
        @else
            <x-empty-state title="Giỏ hàng đang trống." message="Khám phá các sản phẩm Lunara Silver." />
            <p class="text-center"><a class="lunara-button lunara-button--dark" href="{{ route('products.index') }}">Xem sản phẩm</a></p>
        @endif
    </div>
@endsection
