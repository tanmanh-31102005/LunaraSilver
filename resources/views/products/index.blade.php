@extends('layouts.app')

@section('title', $category?->seo_title ?: ($category ? ($category->seo_display_name ?? $category->name).' Bạc 925 Cao Cấp | Lunara Silver' : 'Trang Sức Bạc Top 1 | Bộ Sưu Tập Bạc 925 Cao Cấp | Lunara Silver'))
@section('meta_description', $category?->seo_description ?: ($category ? ($category->description ?: 'Khám phá các thiết kế '.($category->seo_display_name ?? $category->name).' 925 cao cấp từ Lunara Silver.') : 'Khám phá bộ sưu tập trang sức bạc top 1 Lunara Silver chuẩn bạc 925: dây chuyền bạc nữ, nhẫn bạc đôi, vòng tay và lắc tay bạc cao cấp.'))
@section('main_class', 'listing-main')
@section('canonical', $category ? route('products.category', $category->slug) : route('products.index'))

@if(request()->anyFilled(['q', 'sort', 'material', 'stone', 'product_type', 'min_price', 'max_price', 'page']) || ($category && $products->total() === 0))
@section('robots', 'noindex,follow')
@endif

@push('schema')
<x-seo.json-ld :schema="app(\App\Services\StructuredDataService::class)->breadcrumbSchema($category ? [['label' => 'Sản phẩm', 'url' => route('products.index')], ['label' => $category->name, 'url' => route('products.category', $category->slug)]] : [['label' => 'Sản phẩm', 'url' => route('products.index')]])" />
@endpush

@section('content')
    <div class="lunara-container listing-page">
        <x-breadcrumb :items="$category ? [['label' => 'Sản phẩm', 'url' => route('products.index')], ['label' => $category->name]] : [['label' => 'Sản phẩm']]" />
        @php
            $taglines = [
                'day-chuyen' => 'Điểm sáng gần trái tim — Tỏa sáng vẻ đẹp thanh khiết của ánh trăng.',
                'nhan' => 'Chạm vào ánh trăng — Biểu tượng của những lời hứa vĩnh cửu.',
                'vong-tay' => 'Vẻ đẹp mềm mại ôm trọn cổ tay, lấp lánh như dải ngân hà.',
                'bo-trang-suc' => 'Sắc bạc, một tổng thể — Sự hòa quyện hoàn mỹ của các vì tinh tú.',
                'set-qua-tang' => 'Gửi trao ánh trăng diệu kỳ — Món quà trọn vẹn yêu thương.',
            ];
            $currentTagline = $category ? ($taglines[$category->slug] ?? ($category->description ?: 'Trang sức bạc cao cấp lấy cảm hứng từ ánh trăng.')) : 'Khám phá toàn bộ tác phẩm trang sức bạc 925 lấy cảm hứng từ vũ trụ.';
        @endphp

        <header class="listing-banner">
            <div class="listing-banner__inner">
                <span class="listing-banner__eyebrow">
                    ✦ LUNARA SILVER @if($category) · {{ mb_strtoupper($category->name) }} @endif ✦
                </span>
                <h1 class="listing-banner__title">{{ $pageTitle }}</h1>
                <p class="listing-banner__tagline">{{ $currentTagline }}</p>
                @if($category && !empty($category->seo_intro))
                    <div class="listing-banner__intro small text-muted mx-auto mt-2" style="max-width: 680px; font-size: 0.875rem; line-height: 1.6;">
                        {{ $category->seo_intro }}
                    </div>
                @endif
                <div class="listing-banner__meta">
                    <span class="listing-banner__count">{{ $products->total() }} thiết kế độc quyền</span>
                </div>
            </div>
        </header>

        <div class="listing-layout">
            <aside class="listing-sidebar d-none d-lg-block" aria-label="Danh mục và bộ lọc">
                @include('products._filters', ['prefix' => 'desktop'])
            </aside>
            <div class="listing-results">
                <div class="listing-toolbar">
                    <button class="btn listing-mobile-filter d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#listingFilters" aria-controls="listingFilters" aria-label="Mở bộ lọc">
                        <i class="bi bi-sliders" aria-hidden="true"></i> Bộ lọc @if(!empty($activeFilters))<span class="badge bg-dark rounded-pill ms-1">{{ count($activeFilters) }}</span>@endif
                    </button>
                    <span class="listing-count">@if($products->total()) Hiển thị {{ $products->firstItem() }}–{{ $products->lastItem() }} trong {{ $products->total() }} sản phẩm @else 0 sản phẩm @endif</span>
                    <form method="get" action="{{ $baseRoute }}" class="listing-sort">
                        @foreach($filters as $key => $value)@if($value !== null)<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endif @endforeach
                        <label for="listing-sort">Sắp xếp</label>
                        <select class="form-select" id="listing-sort" name="sort" aria-label="Sắp xếp sản phẩm" onchange="this.form.submit()">
                            <option value="newest" @selected($sort === 'newest')>Mới nhất</option>
                            <option value="price_asc" @selected($sort === 'price_asc')>Giá tăng dần</option>
                            <option value="price_desc" @selected($sort === 'price_desc')>Giá giảm dần</option>
                            <option value="name_asc" @selected($sort === 'name_asc')>Tên A–Z</option>
                        </select>
                    </form>
                </div>

                @if($category || $activeFilters)
                    <div class="listing-chips" aria-label="Bộ lọc đang dùng">
                        @if($category)<a href="{{ route('products.index', array_filter($filters, fn ($value) => $value !== null) + ($sort !== 'newest' ? ['sort' => $sort] : [])) }}" aria-label="Bỏ danh mục {{ $category->name }}">{{ $category->name }} <i class="bi bi-x" aria-hidden="true"></i></a>@endif
                        @foreach($activeFilters as $key => $value)
                            <a href="{{ $removeUrls[$key] }}" aria-label="Bỏ bộ lọc {{ $key }}: {{ $value }}">{{ ['q' => 'Tìm', 'min_price' => 'Từ', 'max_price' => 'Đến', 'type' => 'Loại', 'material' => 'Chất liệu', 'stone' => 'Đá'][$key] }}: {{ $value }} <i class="bi bi-x" aria-hidden="true"></i></a>
                        @endforeach
                        <a class="listing-chips__clear" href="{{ $category ? route('products.category', $category->slug) : route('products.index') }}">Xóa tất cả</a>
                    </div>
                @endif

                @if($products->isEmpty())
                    <x-empty-state title="Không tìm thấy sản phẩm phù hợp." message="Hãy thử thay đổi hoặc xóa bộ lọc." />
                    <div class="text-center"><a class="btn btn-outline-dark" href="{{ route('products.index') }}">Xem tất cả sản phẩm</a></div>
                @else
                    <div class="product-grid">
                        @foreach($products as $product)<x-product-card :product="$product" />@endforeach
                    </div>
                    <div class="listing-pagination">{{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-start listing-offcanvas" tabindex="-1" id="listingFilters" aria-labelledby="listingFiltersTitle">
        <div class="offcanvas-header"><h2 class="offcanvas-title h4 mb-0" id="listingFiltersTitle">Danh mục & bộ lọc</h2><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Đóng bộ lọc"></button></div>
        <div class="offcanvas-body">@include('products._filters', ['prefix' => 'mobile'])</div>
    </div>
@endsection

