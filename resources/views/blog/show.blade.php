@extends('layouts.app')

@section('title', ($post->seo_title ?: $post->title) . ' | Lunara Journal')
@section('meta_description', $post->seo_description ?: ($post->excerpt ?: Str::limit(strip_tags($post->content), 155)))

@push('styles')
<style>
    .article-body {
        font-size: 1.0625rem;
        line-height: 1.85;
        color: #2b2b2b;
    }
    .article-body p {
        margin-bottom: 1.75rem;
    }
    .article-body h2 {
        font-family: var(--font-serif, "Playfair Display", Georgia, serif);
        font-size: 1.75rem;
        font-weight: 500;
        margin-top: 2.75rem;
        margin-bottom: 1.25rem;
        color: #111;
        letter-spacing: -0.01em;
    }
    .article-body h3 {
        font-family: var(--font-serif, "Playfair Display", Georgia, serif);
        font-size: 1.35rem;
        font-weight: 500;
        margin-top: 2.25rem;
        margin-bottom: 1rem;
        color: #1a1a1a;
    }
    .article-body blockquote {
        border-left: 3px solid #111;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: #4a4a4a;
        font-size: 1.125rem;
    }
    .article-body ul, .article-body ol {
        margin-bottom: 1.75rem;
        padding-left: 1.5rem;
    }
    .article-body li {
        margin-bottom: 0.5rem;
    }
    .article-body img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 2rem 0;
    }
    .article-body figure {
        margin: 2rem 0;
        text-align: center;
    }
    .article-body figcaption {
        font-size: 0.875rem;
        color: #777;
        margin-top: 0.5rem;
        font-style: italic;
    }
</style>
@endpush

@section('content')
<article class="blog-detail py-5">
    <div class="lunara-container">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0 small text-muted">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-decoration-none text-muted">Nhật ký Lunara</a></li>
                @if($post->category)
                    <li class="breadcrumb-item"><a href="{{ route('blog.category', $post->category->slug) }}" class="text-decoration-none text-muted">{{ $post->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-dark fw-medium text-truncate" style="max-width: 280px;" aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>

        {{-- Draft Preview Notice for Admin --}}
        @if(! $post->isPublished())
            <div class="alert alert-warning border-warning shadow-sm d-flex align-items-center gap-3 mb-4 mx-auto" style="max-width: 820px;" role="alert">
                <i class="bi bi-eye-fill fs-4 text-warning"></i>
                <div class="flex-grow-1">
                    <strong>Chế độ xem trước (Bản nháp)</strong>
                    <div class="small">Bài viết này chưa được xuất bản công khai. Bạn đang xem với tư cách Quản trị viên.</div>
                </div>
                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-dark text-nowrap">Chỉnh sửa</a>
            </div>
        @endif

        {{-- Header Section --}}
        <header class="text-center mx-auto mb-4" style="max-width: 820px;">
            @if($post->category)
                <a href="{{ route('blog.category', $post->category->slug) }}" 
                   class="badge bg-light text-dark border px-3 py-2 rounded-pill text-decoration-none small text-uppercase tracking-wider mb-3">
                    {{ $post->category->name }}
                </a>
            @endif

            <h1 class="display-5 font-serif fw-normal text-dark mb-4" style="line-height: 1.25;">
                {{ $post->title }}
            </h1>

            <div class="d-flex align-items-center justify-content-center gap-3 text-muted small flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-circle bg-dark text-white d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 11px;">
                        {{ strtoupper(substr($post->author->name ?? 'L', 0, 1)) }}
                    </span>
                    <span class="text-dark fw-medium">{{ $post->author->name ?? 'Lunara Editorial' }}</span>
                </div>
                <span>•</span>
                <span><i class="bi bi-calendar3 me-1"></i>{{ $post->published_at ? $post->published_at->format('d/m/Y') : 'Chưa xuất bản' }}</span>
                <span>•</span>
                <span><i class="bi bi-clock me-1"></i>{{ $post->reading_time }} phút đọc</span>
            </div>
        </header>

        {{-- Hero Cover Image --}}
        @if($post->cover_image)
            <div class="mx-auto mb-5 rounded-4 overflow-hidden shadow-sm ratio ratio-21x9" style="max-width: 980px; max-height: 480px;">
                <img src="{{ $post->cover_image }}" 
                     alt="{{ $post->title }}" 
                     class="w-100 h-100 object-fit-cover">
            </div>
        @endif

        {{-- Article Reading Body (760px max width for optimal reading experience) --}}
        <div class="mx-auto article-body px-2" style="max-width: 760px;">
            @if($post->excerpt)
                <p class="lead text-dark fw-normal fst-italic pb-3 mb-4 border-bottom" style="font-size: 1.2rem; line-height: 1.7;">
                    {{ $post->excerpt }}
                </p>
            @endif

            <div class="article-content">
                {!! $post->sanitized_content !!}
            </div>

            {{-- Article Footer / Share Bar --}}
            <div class="pt-4 mt-5 border-top d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small fw-medium">Chia sẻ bài viết:</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 34px; height: 34px; padding: 0;"
                            onclick="navigator.clipboard.writeText(window.location.href); alert('Đã sao chép liên kết vào clipboard!');"
                            title="Sao chép liên kết">
                        <i class="bi bi-link-45deg"></i>
                    </button>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                       target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center;"
                       title="Chia sẻ lên Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                </div>

                <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại Nhật ký
                </a>
            </div>

            {{-- Editorial Signature Box --}}
            <div class="card border-0 bg-light p-4 rounded-4 my-5 text-center">
                <div class="mx-auto mb-2 text-dark font-serif fs-5">Lunara Silver Editorial</div>
                <p class="text-muted small mb-0" style="max-width: 500px; margin: 0 auto;">
                    Mỗi món trang sức tại Lunara không chỉ là phụ kiện, mà là một lời nhắc nhở dịu dàng rằng bạn luôn có thể tỏa sáng theo cách riêng dưới ánh trăng của chính mình.
                </p>
            </div>
        </div>

        {{-- Related Articles Section --}}
        @if($relatedPosts && $relatedPosts->count() > 0)
            <div class="pt-5 mt-5 border-top">
                <div class="text-center mb-5">
                    <p class="text-uppercase tracking-wider text-muted small fw-semibold mb-1">Gợi ý dành cho bạn</p>
                    <h2 class="h3 font-serif fw-normal text-dark">Bài viết cùng chủ đề</h2>
                </div>

                <div class="row g-4">
                    @foreach($relatedPosts as $rel)
                        <div class="col-12 col-md-4">
                            <article class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                                <a href="{{ route('blog.show', $rel->slug) }}" class="d-block overflow-hidden ratio ratio-16x9">
                                    <img src="{{ $rel->cover_image }}" alt="{{ $rel->title }}" class="w-100 h-100 object-fit-cover" loading="lazy">
                                </a>
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="text-muted small mb-2">
                                        <span>{{ $rel->published_at ? $rel->published_at->format('d/m/Y') : '' }}</span>
                                        <span>•</span>
                                        <span>{{ $rel->reading_time }} phút đọc</span>
                                    </div>
                                    <h3 class="h6 font-serif fw-normal mb-2 text-dark">
                                        <a href="{{ route('blog.show', $rel->slug) }}" class="text-dark text-decoration-none">
                                            {{ $rel->title }}
                                        </a>
                                    </h3>
                                    <p class="text-muted small mb-3 flex-grow-1 line-clamp-2">
                                        {{ $rel->excerpt ?: Str::limit(strip_tags($rel->content), 90) }}
                                    </p>
                                    <a href="{{ route('blog.show', $rel->slug) }}" class="small text-dark fw-medium text-decoration-none">
                                        Đọc tiếp <i class="bi bi-chevron-right small"></i>
                                    </a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>
@endsection
