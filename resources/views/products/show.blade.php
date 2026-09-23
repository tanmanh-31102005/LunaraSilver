@extends('layouts.app')

@section('title', e($product->name).' | Lunara Silver')
@section('meta_description', e($metaDescription))
@section('main_class', 'detail-main')

@push('styles')
    <link rel="canonical" href="{{ route('products.show', $product->slug) }}">
@endpush

@section('content')
    <div class="lunara-container detail-page">
        <x-breadcrumb :items="[['label' => $product->category->name, 'url' => route('products.category', $product->category->slug)], ['label' => $product->name]]" />

        <div class="detail-hero">
            <section class="detail-gallery {{ $product->product_type !== 'single' ? 'detail-gallery--bundle' : '' }}" aria-label="Hình ảnh sản phẩm">
                @if($images->isNotEmpty())
                    <div id="productGallery" class="carousel slide" data-bs-interval="false" data-bs-touch="true" aria-label="Hình ảnh {{ $product->name }}">
                        <div class="carousel-inner">
                            @foreach($images as $image)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <img src="{{ $image->displayUrl() }}" alt="{{ $image->alt_text ?: $product->name }}" width="760" height="950" @if($loop->first) fetchpriority="high" @else loading="lazy" @endif>
                                </div>
                            @endforeach
                        </div>
                        @if($images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productGallery" data-bs-slide="prev" aria-label="Ảnh trước"><span class="carousel-control-prev-icon" aria-hidden="true"></span></button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productGallery" data-bs-slide="next" aria-label="Ảnh tiếp theo"><span class="carousel-control-next-icon" aria-hidden="true"></span></button>
                            <div class="detail-thumbnails carousel-indicators" aria-label="Chọn ảnh sản phẩm">
                                @foreach($images as $image)
                                    <button class="detail-thumbnail @if($loop->first) active @endif" type="button" data-bs-target="#productGallery" data-bs-slide-to="{{ $loop->index }}" aria-label="Xem ảnh {{ $loop->iteration }} của {{ $product->name }}" @if($loop->first) aria-current="true" @endif>
                                        <img src="{{ $image->displayUrl() }}" alt="" width="90" height="110" loading="lazy">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="detail-gallery__empty" role="img" aria-label="Chưa có ảnh sản phẩm"><i class="bi bi-image" aria-hidden="true"></i></div>
                @endif

                <div class="detail-unboxing-card">
                    <div class="detail-unboxing-card__head">
                        <i class="bi bi-box2-heart text-champagne"></i>
                        <span>Đặc quyền đóng gói & Quà tặng Lunara</span>
                    </div>
                    <div class="detail-unboxing-card__grid">
                        <div class="unboxing-perk">
                            <i class="bi bi-gift"></i>
                            <div>
                                <strong>Hộp quà nhung Ánh Trăng</strong>
                                <p>Tặng kèm miễn phí cho mọi đơn hàng</p>
                            </div>
                        </div>
                        <div class="unboxing-perk">
                            <i class="bi bi-patch-check"></i>
                            <div>
                                <strong>Thẻ kiểm định Bạc Ý S925</strong>
                                <p>Cam kết chuẩn tuổi & bảo hành trọn đời</p>
                            </div>
                        </div>
                        <div class="unboxing-perk">
                            <i class="bi bi-stars"></i>
                            <div>
                                <strong>Khăn lau bạc Nano chuyên dụng</strong>
                                <p>Giúp trang sức luôn sáng bóng lấp lánh</p>
                            </div>
                        </div>
                        <div class="unboxing-perk">
                            <i class="bi bi-envelope-paper-heart"></i>
                            <div>
                                <strong>Thiệp chúc viết tay cao cấp</strong>
                                <p>Gửi trọn lời yêu thương ý nghĩa</p>
                            </div>
                        </div>
                    </div>
                    <div class="detail-unboxing-card__footer">
                        <span class="unboxing-support">
                            <i class="bi bi-chat-dots me-1"></i> Cần tư vấn nhanh về mẫu mã & kích cỡ? 
                            <a href="{{ route('home') }}#story" class="unboxing-link">Hỗ trợ 24/7 <i class="bi bi-arrow-right-short"></i></a>
                        </span>
                    </div>
                </div>
            </section>

            <section class="detail-info" aria-labelledby="product-name">
                <div class="detail-meta-header">
                    <div class="detail-meta-header__left">
                        <a class="detail-category" href="{{ route('products.category', $product->category->slug) }}">{{ $product->category->name }}</a>
                        <span class="detail-meta-header__sep">/</span>
                        <span class="detail-sku">SKU: {{ $product->sku }}</span>
                    </div>
                    <div class="detail-meta-rating" title="Đánh giá chất lượng 4.9/5 sao">
                        <div class="detail-rating-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <span class="detail-rating-text">4.9 <small>(36)</small></span>
                    </div>
                </div>

                <h1 id="product-name" class="detail-title">{{ $product->name }}</h1>

                <div class="detail-pricing-stock">
                    <div class="detail-pricing-group">
                        <x-price :product="$product" class="detail-price" />
                        @if($product->discountPercent() !== null)
                            <span class="detail-discount">Giảm {{ $product->discountPercent() }}%</span>
                        @endif
                    </div>

                    <div class="detail-stock-status">
                        @if($product->isInStock())
                            <p class="detail-stock detail-stock--available">
                                <span class="stock-pulse"></span>
                                Còn hàng @if($product->product_type !== 'single') · Có thể đặt {{ $product->availableQuantity() }} bộ @endif
                            </p>
                        @else
                            <p class="detail-stock detail-stock--unavailable">
                                <i class="bi bi-x-circle" aria-hidden="true"></i> Hết hàng
                            </p>
                        @endif
                    </div>
                </div>

                @if($product->product_type !== 'single' && $product->bundleItems->isNotEmpty())
                    <div class="curated-inclusions-card">
                        <div class="curated-inclusions-card__header">
                            <i class="bi {{ $product->product_type === 'gift' ? 'bi-gift' : 'bi-stars' }}" aria-hidden="true"></i>
                            <span>{{ $product->product_type === 'gift' ? 'Set quà tặng bao gồm' : 'Phối bộ trang sức bao gồm' }} ({{ $product->bundleItems->count() }} món tinh xảo)</span>
                        </div>
                        <div class="curated-inclusions-chips">
                            @foreach($product->bundleItems as $bItem)
                                @php($comp = $bItem->component)
                                @if($comp)
                                    @php($cImg = $comp->images->firstWhere('image_role', 'primary') ?: $comp->images->first())
                                    <div class="inclusion-chip">
                                        <div class="inclusion-chip__thumb">
                                            @if($cImg)
                                                <img src="{{ $cImg->displayUrl() }}" alt="{{ $comp->name }}" width="40" height="40" loading="lazy">
                                            @else
                                                <i class="bi bi-gem"></i>
                                            @endif
                                            <span class="inclusion-chip__badge">{{ $bItem->quantity }}x</span>
                                        </div>
                                        <div class="inclusion-chip__body">
                                            <a href="{{ route('products.show', $comp->slug) }}" class="inclusion-chip__name" title="{{ $comp->name }}">{{ $comp->name }}</a>
                                            <span class="inclusion-chip__sku">{{ $comp->sku }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @elseif($product->short_description)
                    <div class="detail-summary-wrapper">
                        <p class="detail-summary">{{ $product->short_description }}</p>
                    </div>
                @endif

                <form class="detail-cta" action="{{ route('cart.items.store') }}" method="post" data-add-cart>
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="detail-cta__control-row">
                        <div class="detail-quantity-box">
                            <label for="detail-quantity" class="detail-quantity-label">Số lượng</label>
                            <div class="stepper-widget">
                                <button type="button" class="stepper-btn" data-stepper="minus" aria-label="Giảm số lượng" @disabled(! $product->isInStock())><i class="bi bi-dash"></i></button>
                                <input class="form-control stepper-input" id="detail-quantity" type="number" name="quantity" min="1" max="{{ $product->availableQuantity() }}" value="1" required @disabled(! $product->isInStock())>
                                <button type="button" class="stepper-btn" data-stepper="plus" aria-label="Tăng số lượng" @disabled(! $product->isInStock())><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                        <div class="detail-cta__actions">
                            <button class="lunara-button lunara-button--dark detail-cta__cart-btn" type="submit" @disabled(! $product->isInStock())>
                                <i class="bi bi-bag-plus me-1"></i> Thêm vào giỏ
                            </button>
                            <button class="lunara-button lunara-button--buy-now detail-cta__buynow-btn" type="button" data-buy-now @disabled(! $product->isInStock())>
                                <i class="bi bi-lightning-charge me-1"></i> Mua ngay
                            </button>
                        </div>
                    </div>

                    <p class="cart-feedback" role="status" aria-live="polite"></p>
                </form>

                <div class="detail-trust-strip">
                    <div class="trust-badge-cell">
                        <i class="bi bi-gem trust-badge-cell__icon"></i>
                        <div class="trust-badge-cell__content">
                            <strong>Bạc Ý S925 Chuẩn</strong>
                            <span>Kèm thẻ bảo hành chính hãng</span>
                        </div>
                    </div>
                    <div class="trust-badge-cell">
                        <i class="bi bi-truck trust-badge-cell__icon"></i>
                        <div class="trust-badge-cell__content">
                            <strong>Freeship Từ 500k</strong>
                            <span>Giao toàn quốc, đồng kiểm</span>
                        </div>
                    </div>
                    <div class="trust-badge-cell">
                        <i class="bi bi-gift trust-badge-cell__icon"></i>
                        <div class="trust-badge-cell__content">
                            <strong>Tặng Kèm Hộp Quà</strong>
                            <span>Đóng gói cao cấp ánh trăng</span>
                        </div>
                    </div>
                    <div class="trust-badge-cell">
                        <i class="bi bi-arrow-repeat trust-badge-cell__icon"></i>
                        <div class="trust-badge-cell__content">
                            <strong>Đổi Trả 7 Ngày</strong>
                            <span>Đánh sáng trọn đời miễn phí</span>
                        </div>
                    </div>
                </div>

                <div class="detail-accordions">
                    @if($product->description)
                        <details class="detail-accordion">
                            <summary class="detail-accordion__summary">
                                <span><i class="bi bi-stars me-2"></i> Câu chuyện thiết kế & Ý nghĩa</span>
                                <i class="bi bi-chevron-down detail-accordion__arrow"></i>
                            </summary>
                            <div class="detail-accordion__body">
                                <p class="detail-description">{{ $product->description }}</p>
                            </div>
                        </details>
                    @endif

                    @if($specifications)
                        <details class="detail-accordion">
                            <summary class="detail-accordion__summary">
                                <span><i class="bi bi-sliders2 me-2"></i> Thông số chế tác & Chi tiết</span>
                                <i class="bi bi-chevron-down detail-accordion__arrow"></i>
                            </summary>
                            <div class="detail-accordion__body">
                                <dl class="detail-specifications">
                                    @foreach($specifications as $label => $value)
                                        <div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>
                                    @endforeach
                                </dl>
                            </div>
                        </details>
                    @endif

                    <details class="detail-accordion">
                        <summary class="detail-accordion__summary">
                            <span><i class="bi bi-box-seam me-2"></i> Chính sách giao hàng & Đổi trả</span>
                            <i class="bi bi-chevron-down detail-accordion__arrow"></i>
                        </summary>
                        <div class="detail-accordion__body">
                            <ul class="detail-accordion__list">
                                <li><strong>Hỏa tốc 1 - 2 ngày:</strong> Khu vực TP.HCM & Hà Nội. Các tỉnh thành khác từ 2 - 4 ngày.</li>
                                <li><strong>Đồng kiểm an tâm:</strong> Bạn được quyền mở kiện hàng kiểm tra trước khi thanh toán cho shipper.</li>
                                <li><strong>Đổi mới trong 7 ngày:</strong> Đổi size hoặc đổi mẫu nếu chưa qua sử dụng và còn nguyên tem mác.</li>
                            </ul>
                        </div>
                    </details>

                    <details class="detail-accordion">
                        <summary class="detail-accordion__summary">
                            <span><i class="bi bi-shield-check me-2"></i> Hướng dẫn bảo quản trang sức bạc</span>
                            <i class="bi bi-chevron-down detail-accordion__arrow"></i>
                        </summary>
                        <div class="detail-accordion__body">
                            <ul class="detail-accordion__list">
                                <li>Tránh để bạc tiếp xúc trực tiếp với nước hoa, cồn, clo hồ bơi, lưu huỳnh hoặc chất tẩy rửa.</li>
                                <li>Sau khi sử dụng, lau nhẹ bằng khăn chuyên dụng tặng kèm và bảo quản trong hộp kín của Lunara.</li>
                                <li>Lunara Silver hỗ trợ làm sạch, đánh bóng miễn phí trọn đời tại tất cả các kênh hỗ trợ.</li>
                            </ul>
                        </div>
                    </details>
                </div>
            </section>
        </div>

        @if($product->product_type !== 'single' && $product->bundleItems->isNotEmpty())
            <section class="detail-section" aria-labelledby="bundle-heading">
                <h2 id="bundle-heading">Bộ sản phẩm gồm</h2>
                <div class="bundle-items">
                    @foreach($product->bundleItems as $item)
                        @php($component = $item->component)
                        @if($component)
                            @php($componentImage = $component->images->firstWhere('image_role', 'primary') ?: $component->images->first())
                            <article class="bundle-item">
                                @if($componentImage)
                                    <img src="{{ $componentImage->displayUrl() }}" alt="{{ $componentImage->alt_text ?: $component->name }}" width="120" height="150" loading="lazy">
                                @else
                                    <div class="bundle-item__no-image" role="img" aria-label="Chưa có ảnh {{ $component->name }}"><i class="bi bi-image" aria-hidden="true"></i></div>
                                @endif
                                <div class="bundle-item__content">
                                    <h3>{{ $item->quantity }} × {{ $component->name }}</h3>
                                    <p>SKU: {{ $component->sku }}</p>
                                    <x-price :product="$component" />
                                    <span class="bundle-item__stock">{{ $component->isInStock() ? 'Còn hàng' : 'Hết hàng' }}</span>
                                    @if($component->is_active)
                                        <a href="{{ route('products.show', $component->slug) }}">Xem sản phẩm <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                            </article>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif


        @if($relatedProducts->isNotEmpty())
            <section class="detail-section detail-related" aria-labelledby="related-heading">
                <h2 id="related-heading">Sản phẩm liên quan</h2>
                <div class="product-grid">
                    @foreach($relatedProducts as $related)<x-product-card :product="$related" />@endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
