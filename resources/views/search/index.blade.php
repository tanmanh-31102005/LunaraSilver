@extends('layouts.app')

@section('title', $query ? 'Tìm kiếm “'.$query.'” | Lunara Silver' : 'Tìm kiếm sản phẩm | Lunara Silver')
@section('meta_description', 'Tìm kiếm tác phẩm trang sức bạc 925 cao cấp và bài viết cẩm nang trang sức tại Lunara Silver.')
@section('robots', 'noindex,follow')
@section('canonical', route('search'))
@section('main_class', 'search-page-main')

@section('content')
<div class="lunara-container py-4 py-md-5">
    <x-breadcrumb :items="[['label' => 'Tìm kiếm']]" />

    <header class="search-header mb-4 mb-md-5 text-center">
        <span class="text-uppercase tracking-widest small text-muted d-block mb-1">KẾT QUẢ TÌM KIẾM</span>
        @if($query)
            <h1 class="h3 font-serif mb-2">Tìm kiếm: “<span class="text-primary">{{ $query }}</span>”</h1>
            <p class="text-muted small mb-0">Tìm thấy {{ $totalProducts }} thiết kế trang sức @if($posts->isNotEmpty()) và {{ $posts->count() }} bài viết @endif</p>
        @else
            <h1 class="h3 font-serif mb-2">Tìm kiếm tại Lunara</h1>
            <p class="text-muted small mb-0">Nhập tên sản phẩm, mã SKU, chất liệu hoặc bài viết cần tìm.</p>
        @endif

        {{-- Search input bar on results page --}}
        <div class="search-bar-wrapper mx-auto mt-4" style="max-width: 580px;">
            <form action="{{ route('search') }}" method="get" class="d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="search" name="q" value="{{ $query }}" class="form-control border-start-0 ps-0" placeholder="Tìm dây chuyền, nhẫn, vòng tay, SKU..." required minlength="2">
                    <button class="btn btn-dark px-4" type="submit">Tìm</button>
                </div>
            </form>
        </div>
    </header>

    @if($categories->isNotEmpty())
        <div class="search-categories-chips mb-4 text-center">
            <span class="small text-muted me-2">Danh mục liên quan:</span>
            <div class="d-inline-flex flex-wrap gap-2 justify-content-center mt-2 mt-md-0">
                @foreach($categories as $cat)
                    <a href="{{ route('products.category', $cat->slug) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Products Results --}}
    @if($products->isNotEmpty())
        <section class="search-products mb-5" aria-labelledby="search-products-title">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h2 id="search-products-title" class="h5 font-serif mb-0">
                    Sản Phẩm ({{ $products->total() }})
                </h2>
                <span class="text-muted small">Trang {{ $products->currentPage() }} / {{ $products->lastPage() }}</span>
            </div>
            <div class="product-grid">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            @if($products->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </section>
    @elseif($query)
        {{-- Empty Search State (Phase 19.53) --}}
        <div class="search-empty card border-0 shadow-sm rounded-3 p-5 text-center bg-white my-4">
            <div class="mb-3">
                <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
            </div>
            <h2 class="h5 font-serif text-dark mb-2">Không tìm thấy kết quả phù hợp cho “{{ $query }}”</h2>
            <p class="text-muted small mb-4 mx-auto" style="max-width: 440px;">
                Thử tìm bằng từ khóa khác hoặc khám phá các danh mục trang sức bạc tinh tế bên dưới:
            </p>
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="{{ route('products.category', 'day-chuyen') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">Dây chuyền</a>
                <a href="{{ route('products.category', 'nhan') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">Nhẫn ánh trăng</a>
                <a href="{{ route('products.category', 'vong-tay') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">Vòng tay tinh tú</a>
                <a href="{{ route('products.category', 'bo-trang-suc') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">Bộ trang sức</a>
                <a href="{{ route('products.category', 'set-qua-tang') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">Set quà tặng</a>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-dark rounded-pill px-3">Tất cả sản phẩm</a>
            </div>
        </div>
    @endif

    {{-- Blog Results --}}
    @if($posts->isNotEmpty())
        <section class="search-posts mt-5" aria-labelledby="search-posts-title">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h2 id="search-posts-title" class="h5 font-serif mb-0">
                    Bài Viết & Cẩm Nang ({{ $posts->count() }})
                </h2>
                <a href="{{ route('blog.index') }}" class="small text-muted text-decoration-none">Đến Blog Lunara →</a>
            </div>
            <div class="row g-3 g-md-4">
                @foreach($posts as $post)
                    <div class="col-12 col-md-4">
                        <article class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                            @if($post->cover_image_url)
                                <a href="{{ route('blog.show', $post->slug) }}" class="ratio ratio-16x9 d-block">
                                    <img src="{{ asset($post->cover_image_url) }}" alt="{{ $post->title }}" class="object-fit-cover w-100 h-100" loading="lazy">
                                </a>
                            @endif
                            <div class="card-body p-3 d-flex flex-column">
                                <span class="text-uppercase text-muted" style="font-size: 0.72rem;">{{ $post->category?->name ?? 'Tạp chí' }}</span>
                                <h3 class="h6 font-serif mb-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none">{{ $post->title }}</a>
                                </h3>
                                <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.8125rem;">
                                    {{ Str::limit(strip_tags($post->excerpt ?: $post->body), 90) }}
                                </p>
                                <a href="{{ route('blog.show', $post->slug) }}" class="small text-dark fw-medium mt-auto">
                                    Đọc bài viết →
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
