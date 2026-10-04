@props([
    'productId',
    'isWishlisted' => null,
    'detail' => false,
])

@php
    if ($isWishlisted === null) {
        $user = auth()->user();
        $sessionIds = (array) request()->session()->get('guest_wishlist', []);
        $isWishlisted = app(\App\Services\WishlistService::class)->isWishlisted((int) $productId, $user, $sessionIds);
    }
@endphp

@if($detail)
    <button type="button"
            class="detail-wishlist-btn {{ $isWishlisted ? 'detail-wishlist-btn--active' : '' }}"
            data-wishlist-btn
            data-product-id="{{ $productId }}"
            aria-pressed="{{ $isWishlisted ? 'true' : 'false' }}"
            aria-label="{{ $isWishlisted ? 'Đã yêu thích sản phẩm' : 'Thêm vào yêu thích' }}">
        <i class="bi {{ $isWishlisted ? 'bi-heart-fill text-danger' : 'bi-heart' }}" aria-hidden="true"></i>
        <span class="detail-wishlist-btn__text">{{ $isWishlisted ? 'Đã yêu thích' : 'Yêu thích' }}</span>
    </button>
@else
    <button type="button"
            class="product-card__wishlist icon-button {{ $isWishlisted ? 'product-card__wishlist--active' : '' }}"
            data-wishlist-btn
            data-product-id="{{ $productId }}"
            aria-pressed="{{ $isWishlisted ? 'true' : 'false' }}"
            aria-label="{{ $isWishlisted ? 'Xóa khỏi yêu thích' : 'Thêm vào yêu thích' }}"
            title="{{ $isWishlisted ? 'Đã yêu thích' : 'Thêm vào yêu thích' }}">
        <i class="bi {{ $isWishlisted ? 'bi-heart-fill text-danger' : 'bi-heart' }}" aria-hidden="true"></i>
    </button>
@endif
