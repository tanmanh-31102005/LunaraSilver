@extends('layouts.app')

@section('title', $product->seo_title ?: ($product->name.' | Lunara Silver'))
@section('meta_description', $product->seo_description ?: ($metaDescription ?: ($product->name.' trang sức bạc 925 cao cấp từ Lunara Silver.')))
@section('main_class', 'detail-main')
@section('canonical', route('products.show', $product->slug))
@section('og_type', 'product')
@section('og_image', $product->primary_image_url ?: ($images->first()?->displayUrl() ?? null))

@push('schema')
<x-seo.json-ld :schema="app(\App\Services\StructuredDataService::class)->productSchema($product)" />
<x-seo.json-ld :schema="app(\App\Services\StructuredDataService::class)->breadcrumbSchema([['label' => 'Sản phẩm', 'url' => route('products.index')], ['label' => $product->category->name, 'url' => route('products.category', $product->category->slug)], ['label' => $product->name, 'url' => route('products.show', $product->slug)]])" />
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
            </section>

            <section class="detail-info" aria-labelledby="product-name">
                <div class="detail-meta-header">
                    <div class="detail-meta-header__left">
                        <a class="detail-category" href="{{ route('products.category', $product->category->slug) }}">{{ $product->category->name }}</a>
                        <span class="detail-meta-header__sep">/</span>
                        <span class="detail-sku">SKU: {{ $product->sku }}</span>
                    </div>
                    @if($ratingSummary['total'] > 0)
                        <a href="#reviews" class="detail-meta-rating text-decoration-none" title="Đánh giá chất lượng {{ $ratingSummary['average'] }}/5 sao">
                            <div class="detail-rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($ratingSummary['average'] >= $i)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @elseif($ratingSummary['average'] >= $i - 0.5)
                                        <i class="bi bi-star-half text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="detail-rating-text">{{ $ratingSummary['average'] }} <small>({{ $ratingSummary['total'] }})</small></span>
                        </a>
                    @else
                        <a href="#reviews" class="detail-meta-rating text-decoration-none text-muted" title="Chưa có đánh giá">
                            <span class="small fst-italic"><i class="bi bi-star me-1"></i>Chưa có đánh giá</span>
                        </a>
                    @endif
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

                    @if($product->product_type === 'gift')
                        <div class="gift-experience-box mb-3 p-3 rounded border" style="background: rgba(245, 240, 235, 0.5); border-color: rgba(200, 180, 160, 0.4) !important;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-gift text-champagne fs-5"></i>
                                <label for="gift-message-input" class="fw-semibold small text-uppercase tracking-wider mb-0 text-dark">
                                    Lời nhắn cho người nhận (Tùy chọn)
                                </label>
                            </div>
                            <textarea
                                id="gift-message-input"
                                name="gift_message"
                                class="form-control form-control-sm bg-white"
                                rows="2"
                                maxlength="500"
                                placeholder="Gửi gắm lời chúc yêu thương của bạn, Lunara sẽ viết tay kèm thiệp trang trọng..."
                            ></textarea>
                            <div class="d-flex justify-content-between mt-1 text-muted" style="font-size: 0.72rem;">
                                <span><i class="bi bi-patch-check me-1 text-accent"></i>Tặng kèm thiệp viết tay Lunara</span>
                                <span>Tối đa 500 ký tự</span>
                            </div>
                        </div>
                    @endif

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
                            <x-wishlist-button :productId="$product->id" :detail="true" />
                        </div>
                    </div>

                    <p class="cart-feedback" role="status" aria-live="polite"></p>
                </form>

                <div class="detail-trust-strip">
                    <div class="trust-badge-cell">
                        <i class="bi bi-gem trust-badge-cell__icon"></i>
                        <div class="trust-badge-cell__content">
                            <strong>Bạc Ý S925 Chuẩn</strong>
                            <span>Kèm thẻ kiểm định tuổi bạc</span>
                        </div>
                    </div>
                    <div class="trust-badge-cell">
                        <i class="bi bi-credit-card trust-badge-cell__icon"></i>
                        <div class="trust-badge-cell__content">
                            <strong>Thanh Toán An Tâm</strong>
                            <span>Hỗ trợ COD & VNPay tiện lợi</span>
                        </div>
                    </div>
                    <div class="trust-badge-cell">
                        <i class="bi bi-arrow-repeat trust-badge-cell__icon"></i>
                        <div class="trust-badge-cell__content">
                            <strong>Đổi Trả 7 Ngày</strong>
                            <span>Đồng kiểm an tâm khi nhận hàng</span>
                        </div>
                    </div>
                    <div class="trust-badge-cell">
                        <i class="bi bi-headset trust-badge-cell__icon"></i>
                        <div class="trust-badge-cell__content">
                            <strong>Hỗ Trợ Tận Tâm</strong>
                            <a href="{{ route('contact') }}" class="text-decoration-none text-muted">Hotline 0971 124 922</a>
                        </div>
                    </div>
                </div>

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
                            <div class="detail-policy-contact mt-3 pt-3 border-top small" style="font-size: 0.8125rem; line-height: 1.6; color: var(--ln-color-muted);">
                                <div class="fw-medium text-dark mb-1"><i class="bi bi-shield-check me-1 text-accent"></i> Hỗ trợ chính sách & Đổi trả / Bảo hành:</div>
                                <div><i class="bi bi-geo-alt me-1"></i> <strong>Địa chỉ:</strong> 140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Ho Chi Minh City</div>
                                <div><i class="bi bi-telephone me-1"></i> <strong>Hotline CSKH / Đặt hàng:</strong> <a href="tel:0971124922" class="text-dark fw-medium text-decoration-none">0971 124 922</a></div>
                                <div><i class="bi bi-envelope me-1"></i> <strong>Email liên hệ:</strong> <a href="mailto:lunaraslivertrangsuc@gmail.com" class="text-dark text-decoration-none">lunaraslivertrangsuc@gmail.com</a></div>
                                <div><i class="bi bi-clock me-1"></i> <strong>Giờ làm việc:</strong> Thứ Hai — Thứ Bảy: 08:30 - 20:30 (Chủ Nhật: 09:00 - 18:00)</div>
                            </div>
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


        {{-- Complete the Look / Hoàn thiện phong cách (Phase 20) --}}
        @if($completeTheLook->isNotEmpty())
            <section class="detail-section detail-complete-look my-5" aria-labelledby="complete-look-heading">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 border-bottom pb-3">
                    <div>
                        <span class="text-uppercase tracking-widest small text-muted d-block mb-1">Gợi ý phối đồ Lunara</span>
                        <h2 id="complete-look-heading" class="h3 font-serif mb-0">Hoàn Thiện Phong Cách</h2>
                    </div>
                    @if($parentCollection)
                        <a href="{{ route('products.show', $parentCollection->slug) }}" class="text-dark small fw-medium text-decoration-none mt-2 mt-md-0 d-inline-flex align-items-center gap-1">
                            <span>Khám phá trọn bộ <strong>{{ $parentCollection->name }}</strong></span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    @else
                        <p class="text-muted small mb-0 mt-2 mt-md-0">Kết hợp cùng các thiết kế trang sức bạc 925 đồng điệu để tạo nên vẻ đẹp tỏa sáng tinh tế.</p>
                    @endif
                </div>
                <div class="product-grid">
                    @foreach($completeTheLook as $lookItem)
                        <x-product-card :product="$lookItem" />
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Verified Reviews & Trust (Phase 20) --}}
        @include('products._reviews_section')

        @if($relatedProducts->isNotEmpty())
            <section class="detail-section detail-related" aria-labelledby="related-heading">
                <h2 id="related-heading">Sản phẩm liên quan</h2>
                <div class="product-grid">
                    @foreach($relatedProducts as $related)<x-product-card :product="$related" />@endforeach
                </div>
            </section>
        @endif

        {{-- Recently Viewed / Bạn vừa xem (Phase 19.25 - 19.29) --}}
        @if(!empty($recentlyViewed) && $recentlyViewed->isNotEmpty())
            <section class="detail-section detail-recently-viewed my-5" aria-labelledby="recently-viewed-heading">
                <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-3">
                    <div>
                        <span class="text-uppercase tracking-widest small text-muted d-block mb-1">Đã xem gần đây</span>
                        <h2 id="recently-viewed-heading" class="h4 font-serif mb-0">Bạn Vừa Xem</h2>
                    </div>
                </div>
                <div class="product-grid">
                    @foreach($recentlyViewed as $recentItem)
                        <x-product-card :product="$recentItem" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    @include('products._sticky_bar', ['product' => $product])
@endsection
