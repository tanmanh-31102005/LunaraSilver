@props(['product'])

@php
    $primary = $product->images->firstWhere('image_role', 'primary');
    $hover = $product->images->firstWhere('image_role', 'hover');
    $available = $product->isInStock();
@endphp

<article {{ $attributes->class(['product-card']) }} data-sku="{{ $product->sku }}" data-available="{{ $available ? 'true' : 'false' }}">
    <div class="product-card__media {{ $hover ? 'product-card__media--has-hover' : '' }} {{ $product->product_type === 'gift' ? 'product-card__media--gift' : '' }} {{ in_array($product->product_type, ['gift', 'collection']) ? 'product-card__media--bundle' : '' }}">
        @if($primary)
            <a href="{{ route('products.show', $product->slug) }}" aria-label="Xem sản phẩm {{ $product->name }}">
                <img class="product-card__image product-card__image--primary" src="{{ $primary->displayUrl() }}" alt="{{ $primary->alt_text ?: $product->name }}" width="520" height="620" loading="lazy">
                @if($hover)
                    <img class="product-card__image product-card__image--hover" src="{{ $hover->displayUrl() }}" alt="" width="520" height="620" loading="lazy" aria-hidden="true">
                @endif
            </a>
        @else
            <div class="product-card__no-image" aria-label="Chưa có ảnh sản phẩm"><i class="bi bi-image" aria-hidden="true"></i></div>
        @endif
        @if($available)
            <x-product-badge :product="$product" class="product-card__badge" />
        @else
            <span class="product-badge product-badge--soldout product-card__badge">Hết hàng</span>
        @endif
        <x-wishlist-button :productId="$product->id" />
        <div class="product-card__quick-bar">
            <a href="{{ route('products.show', $product->slug) }}" class="product-card__quick-action" title="Xem chi tiết {{ $product->name }}">
                <i class="bi bi-eye me-1"></i> <span>Xem nhanh</span>
            </a>
            @if($available)
                <button type="button" class="product-card__quick-action product-card__quick-action--add" data-quick-add="{{ $product->id }}" title="Thêm nhanh vào giỏ">
                    <i class="bi bi-bag-plus me-1"></i> <span>Thêm giỏ</span>
                </button>
            @endif
        </div>
    </div>
    <div class="product-card__body">
        <div class="product-card__meta-top d-flex justify-content-between align-items-center mb-1">
            <span class="product-card__category">{{ $product->category->name }}</span>
            @if($product->approved_reviews_count > 0)
                <span class="product-card__rating d-inline-flex align-items-center gap-1" title="{{ $product->approved_reviews_avg_rating }}/5 sao" aria-label="Đánh giá: {{ $product->approved_reviews_avg_rating }}/5 sao ({{ $product->approved_reviews_count }} lượt)">
                    <i class="bi bi-star-fill text-warning" style="font-size: 0.72rem;"></i>
                    <span class="fw-semibold text-dark" style="font-size: 0.78rem;">{{ $product->approved_reviews_avg_rating }}</span>
                    <span class="text-muted" style="font-size: 0.72rem;">({{ $product->approved_reviews_count }})</span>
                </span>
            @endif
        </div>
        <h3><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
        <x-price :product="$product" />
        <a class="product-card__link" href="{{ route('products.show', $product->slug) }}" aria-label="Xem sản phẩm {{ $product->name }}">Xem sản phẩm <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
    </div>
</article>
