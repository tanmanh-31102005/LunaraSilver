@extends('layouts.app')

@section('title', ($currentCategory ? $currentCategory->name . ' — ' : '') . 'Nhật ký Lunara | Editorial Journal & Jewelry Knowledge')
@section('meta_description', 'Khám phá thế giới trang sức bạc 925, cẩm nang bảo quản, bí quyết phối đồ và câu chuyện chế tác từ Lunara Silver.')

@section('content')
<div class="blog-index py-5">
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
        <div class="text-center mx-auto mb-5" style="max-width: 760px;">
            <p class="text-uppercase tracking-widest text-muted small fw-semibold mb-2">Lunara Journal & Editorial</p>
            <h1 class="display-5 font-serif fw-normal text-dark mb-3">
                {{ $currentCategory ? $currentCategory->name : 'Nhật Ký Ánh Trăng' }}
            </h1>
            <p class="lead text-muted fs-6 mb-0">
                {{ $currentCategory && $currentCategory->description ? $currentCategory->description : 'Cẩm nang trang sức bạc 925, nghệ thuật phối lớp tinh tế và những câu chuyện thủ công mang đậm cảm hứng từ ánh trăng thanh lịch.' }}
            </p>
        </div>

        {{-- Filter & Search Toolbar --}}
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-5 pb-3 border-bottom">
            {{-- Category Filter Pills --}}
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('blog.index') }}" 
                   class="btn btn-sm {{ ! $currentCategory ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-3">
                    Tất cả
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog.category', $cat->slug) }}" 
                       class="btn btn-sm {{ $currentCategory && $currentCategory->id === $cat->id ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-3">
                        {{ $cat->name }}
                        @if($cat->posts_count > 0)
                            <span class="badge {{ $currentCategory && $currentCategory->id === $cat->id ? 'bg-light text-dark' : 'bg-secondary bg-opacity-25 text-dark' }} ms-1">{{ $cat->posts_count }}</span>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- Search Bar --}}
            <form action="{{ route('blog.index') }}" method="GET" class="d-flex align-items-center gap-2" style="min-width: 260px;">
                @if($currentCategory)
                    <input type="hidden" name="category" value="{{ $currentCategory->slug }}">
                @endif
                <div class="input-group input-group-sm">
                    <input type="search" name="q" value="{{ $search ?? '' }}" 
                           class="form-control" placeholder="Tìm kiếm bài viết..." aria-label="Tìm kiếm bài viết">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                @if(!empty($search))
                    <a href="{{ $currentCategory ? route('blog.category', $currentCategory->slug) : route('blog.index') }}" 
                       class="btn btn-sm btn-link text-muted p-0 text-decoration-none" title="Xóa tìm kiếm">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                @endif
            </form>
        </div>

        {{-- Featured Article (Only on page 1 and when not searching) --}}
        @if($featuredPost)
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
                <div class="row g-0 align-items-center">
                    <div class="col-12 col-lg-7">
                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="d-block overflow-hidden position-relative" style="height: 100%; min-height: 380px;">
                            <img src="{{ $featuredPost->cover_image }}" 
                                 alt="{{ $featuredPost->title }}" 
                                 class="w-100 h-100 object-fit-cover transition-transform" 
                                 style="transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);">
                            <span class="position-absolute top-0 start-0 m-3 badge bg-dark text-white px-3 py-2 rounded-pill fw-medium letter-spacing-1">
                                <i class="bi bi-stars me-1 text-warning"></i> NỔI BẬT
                            </span>
                        </a>
                    </div>
                    <div class="col-12 col-lg-5 p-4 p-md-5">
                        <div class="d-flex align-items-center gap-2 text-muted small mb-3">
                            @if($featuredPost->category)
                                <a href="{{ route('blog.category', $featuredPost->category->slug) }}" class="badge bg-light text-dark text-decoration-none border px-2 py-1">
                                    {{ $featuredPost->category->name }}
                                </a>
                                <span>•</span>
                            @endif
                            <span>{{ $featuredPost->published_at ? $featuredPost->published_at->format('d/m/Y') : '' }}</span>
                            <span>•</span>
                            <span><i class="bi bi-clock me-1"></i>{{ $featuredPost->reading_time }} phút đọc</span>
                        </div>
                        <h2 class="h3 font-serif fw-normal mb-3 text-dark">
                            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="text-dark text-decoration-none hover-primary">
                                {{ $featuredPost->title }}
                            </a>
                        </h2>
                        <p class="text-muted mb-4 line-clamp-3">
                            {{ $featuredPost->excerpt ?: Str::limit(strip_tags($featuredPost->content), 160) }}
                        </p>
                        <div>
                            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="lunara-button lunara-button--dark">
                                Đọc bài viết <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Articles Grid --}}
        @if($posts->count() > 0)
            <div class="row g-4 mb-5">
                @foreach($posts as $post)
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden bg-white d-flex flex-column">
                            <a href="{{ route('blog.show', $post->slug) }}" class="d-block overflow-hidden position-relative ratio ratio-16x9">
                                <img src="{{ $post->cover_image }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-100 h-100 object-fit-cover" 
                                     loading="lazy">
                                @if($post->category)
                                    <span class="position-absolute top-0 start-0 m-2 badge bg-white text-dark shadow-sm px-2 py-1 small">
                                        {{ $post->category->name }}
                                    </span>
                                @endif
                            </a>
                            <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                <div class="text-muted small mb-2 d-flex align-items-center gap-2">
                                    <span>{{ $post->published_at ? $post->published_at->format('d/m/Y') : '' }}</span>
                                    <span>•</span>
                                    <span>{{ $post->reading_time }} phút đọc</span>
                                </div>
                                <h3 class="h5 font-serif fw-normal mb-2 text-dark">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-muted small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                                </p>
                                <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                                    <span class="small text-muted">Bởi {{ $post->author->name ?? 'Lunara Editor' }}</span>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="small text-dark fw-medium text-decoration-none">
                                        Xem chi tiết <i class="bi bi-chevron-right small"></i>
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
            <div class="text-center py-5 my-5">
                <i class="bi bi-journal-x fs-1 text-muted d-block mb-3"></i>
                <h3 class="h5 text-dark fw-normal mb-2">Chưa tìm thấy bài viết phù hợp</h3>
                <p class="text-muted small mb-4">Vui lòng thử tìm kiếm với từ khóa khác hoặc quay lại danh sách tất cả bài viết.</p>
                <a href="{{ route('blog.index') }}" class="btn btn-outline-dark rounded-pill px-4">
                    Xem tất cả bài viết
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
