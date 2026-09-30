@extends('layouts.app')

@section('title', ($currentCategory ? $currentCategory->name . ' — ' : '') . 'Nhật ký Lunara | Editorial Journal & Jewelry Knowledge')
@section('meta_description', 'Khám phá thế giới trang sức bạc 925, cẩm nang bảo quản, bí quyết phối đồ và câu chuyện chế tác từ Lunara Silver.')
@section('main_class', 'blog-main')

@section('content')
<div class="lunara-container">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0 small text-muted">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Trang chủ</a></li>
            @if($currentCategory)
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-decoration-none text-muted">Nhật ký Lunara</a></li>
                <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">{{ $currentCategory->name }}</li>
            @else
                <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">Nhật ký Lunara</li>
            @endif
        </ol>
    </nav>

    {{-- Editorial Header --}}
    <header class="blog-header text-center">
        <p class="blog-header__eyebrow">Lunara Journal & Editorial</p>
        <h1 class="blog-header__title">
            {{ $currentCategory ? $currentCategory->name : 'Nhật Ký Ánh Trăng' }}
        </h1>
        <p class="blog-header__desc">
            {{ $currentCategory && $currentCategory->description ? $currentCategory->description : 'Cẩm nang trang sức bạc 925, nghệ thuật phối lớp tinh tế và những câu chuyện thủ công mang đậm cảm hứng từ ánh trăng thanh lịch.' }}
        </p>
    </header>

    {{-- Filter & Search Toolbar --}}
    <div class="blog-toolbar">
        {{-- Category Filter Pills --}}
        <div class="blog-toolbar__categories">
            <a href="{{ route('blog.index') }}" 
               class="blog-tab {{ ! $currentCategory ? 'blog-tab--active' : '' }}">
                Tất cả
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('blog.category', $cat->slug) }}" 
                   class="blog-tab {{ $currentCategory && $currentCategory->id === $cat->id ? 'blog-tab--active' : '' }}">
                    <span>{{ $cat->name }}</span>
                    @if($cat->posts_count > 0)
                        <span class="blog-tab__count">{{ $cat->posts_count }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Search Bar --}}
        <form action="{{ route('blog.index') }}" method="GET" class="blog-search-form">
            @if($currentCategory)
                <input type="hidden" name="category" value="{{ $currentCategory->slug }}">
            @endif
            <div class="blog-search-input-wrap">
                <i class="bi bi-search blog-search-icon" aria-hidden="true"></i>
                <input type="search" name="q" value="{{ $search ?? '' }}" 
                       class="blog-search-input" placeholder="Tìm kiếm bài viết..." aria-label="Tìm kiếm bài viết">
                @if(!empty($search))
                    <a href="{{ $currentCategory ? route('blog.category', $currentCategory->slug) : route('blog.index') }}" 
                       class="blog-search-clear" title="Xóa tìm kiếm">
                        <i class="bi bi-x-circle-fill" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Featured Article (Only on page 1 and when not searching) --}}
    @if($featuredPost)
        <article class="blog-featured-card mb-5">
            <div class="row g-0 align-items-stretch">
                <div class="col-12 col-lg-7">
                    <a href="{{ route('blog.show', $featuredPost->slug) }}" class="blog-featured-card__media">
                        <img src="{{ $featuredPost->cover_image }}" 
                             alt="{{ $featuredPost->title }}" 
                             class="blog-featured-card__img"
                             loading="eager">
                        <span class="blog-featured-card__badge">
                            <i class="bi bi-stars" aria-hidden="true"></i> NỔI BẬT
                        </span>
                    </a>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="blog-featured-card__content">
                        <div class="blog-meta mb-3">
                            @if($featuredPost->category)
                                <a href="{{ route('blog.category', $featuredPost->category->slug) }}" class="blog-meta__category">
                                    {{ $featuredPost->category->name }}
                                </a>
                                <span class="blog-meta__divider">•</span>
                            @endif
                            <span class="blog-meta__item">{{ $featuredPost->published_at ? $featuredPost->published_at->format('d/m/Y') : '' }}</span>
                            <span class="blog-meta__divider">•</span>
                            <span class="blog-meta__item"><i class="bi bi-clock me-1" aria-hidden="true"></i>{{ $featuredPost->reading_time }} phút đọc</span>
                        </div>

                        <h2 class="blog-featured-card__title">
                            <a href="{{ route('blog.show', $featuredPost->slug) }}">
                                {{ $featuredPost->title }}
                            </a>
                        </h2>

                        <p class="blog-featured-card__excerpt">
                            {{ $featuredPost->excerpt ?: Str::limit(strip_tags($featuredPost->content), 180) }}
                        </p>

                        <div class="blog-featured-card__action mt-auto">
                            <x-ui.button href="{{ route('blog.show', $featuredPost->slug) }}" variant="primary" size="md">
                                Đọc bài viết <i class="bi bi-arrow-right ms-2" aria-hidden="true"></i>
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    @endif

    {{-- Articles Grid --}}
    @if($posts->count() > 0)
        <div class="row g-4 mb-5">
            @foreach($posts as $post)
                <div class="col-12 col-md-6 col-lg-4">
                    <article class="blog-card">
                        <a href="{{ route('blog.show', $post->slug) }}" class="blog-card__media">
                            <img src="{{ $post->cover_image }}" 
                                 alt="{{ $post->title }}" 
                                 class="blog-card__img" 
                                 loading="lazy">
                            @if($post->category)
                                <span class="blog-card__category">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                        </a>
                        <div class="blog-card__body">
                            <div class="blog-meta mb-2">
                                <span class="blog-meta__item">{{ $post->published_at ? $post->published_at->format('d/m/Y') : '' }}</span>
                                <span class="blog-meta__divider">•</span>
                                <span class="blog-meta__item"><i class="bi bi-clock me-1" aria-hidden="true"></i>{{ $post->reading_time }} phút đọc</span>
                            </div>

                            <h3 class="blog-card__title">
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <p class="blog-card__excerpt">
                                {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                            </p>

                            <div class="blog-card__footer">
                                <span class="blog-card__author" title="Tác giả: {{ $post->author->name ?? 'Lunara Editor' }}">
                                    <i class="bi bi-feather me-1" aria-hidden="true"></i>{{ $post->author->name ?? 'Lunara Editor' }}
                                </span>
                                <a href="{{ route('blog.show', $post->slug) }}" class="blog-card__link">
                                    Xem chi tiết <i class="bi bi-chevron-right ms-1" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div class="d-flex justify-content-center pt-3">
                {{ $posts->links() }}
            </div>
        @endif
    @else
        <div class="blog-empty-state text-center">
            <div class="blog-empty-state__icon mb-3">
                <i class="bi bi-journal-x" aria-hidden="true"></i>
            </div>
            <h3 class="blog-empty-state__title mb-2">Chưa tìm thấy bài viết phù hợp</h3>
            <p class="blog-empty-state__desc mb-4">Vui lòng thử tìm kiếm với từ khóa khác hoặc quay lại danh sách tất cả bài viết.</p>
            <x-ui.button href="{{ route('blog.index') }}" variant="secondary" size="md">
                Xem tất cả bài viết
            </x-ui.button>
        </div>
    @endif
</div>
@endsection
