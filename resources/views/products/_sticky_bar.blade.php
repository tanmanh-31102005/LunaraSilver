@php
    $inStock = $product->isInStock();
@endphp

<div class="mobile-sticky-bar d-lg-none" id="mobileStickyBar" aria-hidden="true">
    <div class="mobile-sticky-bar__inner">
        <div class="mobile-sticky-bar__info">
            <span class="mobile-sticky-bar__name text-truncate">{{ $product->name }}</span>
            <div class="mobile-sticky-bar__price">
                <x-price :product="$product" />
            </div>
        </div>
        <div class="mobile-sticky-bar__action">
            @if($inStock)
                <button type="button"
                        class="lunara-button lunara-button--dark mobile-sticky-bar__btn"
                        data-sticky-add-cart
                        data-product-id="{{ $product->id }}">
                    <i class="bi bi-bag-plus me-1"></i> Thêm giỏ
                </button>
            @else
                <button type="button" class="lunara-button lunara-button--disabled mobile-sticky-bar__btn" disabled>
                    Hết hàng
                </button>
            @endif
        </div>
    </div>
</div>
