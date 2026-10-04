@extends('layouts.app')

@section('title', ($post->seo_title ?: $post->title) . ' | Lunara Journal')
@section('meta_description', $post->seo_description ?: ($post->excerpt ?: Str::limit(strip_tags($post->content), 155)))
@section('canonical', route('blog.show', $post->slug))
@section('og_type', 'article')
@section('og_image', $post->cover_image_url ?: $post->image_url)

@push('schema')
<x-seo.json-ld :schema="app(\App\Services\StructuredDataService::class)->blogPostingSchema($post)" />
<x-seo.json-ld :schema="app(\App\Services\StructuredDataService::class)->breadcrumbSchema([['label' => 'Nhật ký Lunara', 'url' => route('blog.index')], ['label' => $post->category?->name ?? 'Bài viết', 'url' => $post->category ? route('blog.category', $post->category->slug) : route('blog.index')], ['label' => $post->title, 'url' => route('blog.show', $post->slug)]])" />
@endpush

@push('styles')
<style>
    .article-body {
        font-family: var(--ln-font-ui);
        font-size: var(--ln-text-body-lg);
        line-height: 1.85;
        color: var(--ln-color-ink);
    }
    .article-body p {
        margin-bottom: var(--ln-space-5);
    }
    .article-body h2 {
        font-family: var(--ln-font-display);
        font-size: var(--ln-text-h2);
        font-weight: 500;
        margin-top: var(--ln-space-7);
        margin-bottom: var(--ln-space-4);
        color: var(--ln-color-ink);
        letter-spacing: -0.01em;
    }
    .article-body h3 {
        font-family: var(--ln-font-display);
        font-size: var(--ln-text-h3);
        font-weight: 500;
        margin-top: var(--ln-space-6);
        margin-bottom: var(--ln-space-3);
        color: var(--ln-color-ink);
    }
    .article-body blockquote {
        border-left: 3px solid var(--ln-color-accent);
        padding-left: var(--ln-space-5);
        margin: var(--ln-space-6) 0;
        font-style: italic;
        color: var(--ln-color-muted);
        font-size: var(--ln-text-body-lg);
    }
    .article-body ul, .article-body ol {
        margin-bottom: var(--ln-space-5);
        padding-left: var(--ln-space-5);
    }
    .article-body li {
        margin-bottom: var(--ln-space-2);
    }
    .article-body img {
        max-width: 100%;
        height: auto;
        border-radius: var(--ln-radius-md);
        margin: var(--ln-space-6) 0;
    }
    .article-body figure {
        margin: var(--ln-space-6) 0;
        text-align: center;
    }
    .article-body figcaption {
        font-size: var(--ln-text-small);
        color: var(--ln-color-muted);
        margin-top: var(--ln-space-2);
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
                            <article class="blog-card">
                                <a href="{{ route('blog.show', $rel->slug) }}" class="blog-card__media">
                                    <img src="{{ $rel->cover_image }}" alt="{{ $rel->title }}" class="blog-card__img" loading="lazy">
                                    @if($rel->category)
                                        <span class="blog-card__category">
                                            {{ $rel->category->name }}
                                        </span>
                                    @endif
                                </a>
                                <div class="blog-card__body">
                                    <div class="blog-meta mb-2">
                                        <span class="blog-meta__item">{{ $rel->published_at ? $rel->published_at->format('d/m/Y') : '' }}</span>
                                        <span class="blog-meta__divider">•</span>
                                        <span class="blog-meta__item"><i class="bi bi-clock me-1" aria-hidden="true"></i>{{ $rel->reading_time }} phút đọc</span>
                                    </div>
                                    <h3 class="blog-card__title">
                                        <a href="{{ route('blog.show', $rel->slug) }}">
                                            {{ $rel->title }}
                                        </a>
                                    </h3>
                                    <p class="blog-card__excerpt">
                                        {{ $rel->excerpt ?: Str::limit(strip_tags($rel->content), 90) }}
                                    </p>
                                    <div class="blog-card__footer">
                                        <span class="blog-card__author" title="Tác giả: {{ $rel->author->name ?? 'Lunara Editor' }}">
                                            <i class="bi bi-feather me-1" aria-hidden="true"></i>{{ $rel->author->name ?? 'Lunara Editor' }}
                                        </span>
                                        <a href="{{ route('blog.show', $rel->slug) }}" class="blog-card__link">
                                            Đọc tiếp <i class="bi bi-chevron-right ms-1" aria-hidden="true"></i>
                                        </a>
                                    </div>
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
