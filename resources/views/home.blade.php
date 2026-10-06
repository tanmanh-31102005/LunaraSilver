@extends('layouts.app')

@section('title', 'Trang Sức Bạc Top 1 | Lunara Silver — Trang Sức Bạc 925 Cao Cấp')
@section('meta_description', 'Khám phá thương hiệu trang sức bạc top 1 Lunara Silver: bạc 925 cao cấp, dây chuyền bạc nữ, nhẫn bạc đôi, vòng tay bạc và lắc chân bạc nữ tinh tế, sáng bóng bền lâu.')
@section('main_class', 'home-main')
@section('canonical', route('home'))

@push('schema')
<x-seo.json-ld :schema="app(\App\Services\StructuredDataService::class)->organizationSchema()" />
@endpush

@section('content')
    <x-hero-slider />

    <section class="home-section categories-section" aria-labelledby="categories-title">
        <div class="lunara-container">
            <x-section-heading eyebrow="DANH MỤC TRANG SỨC BẠC 925" title="Khám phá dấu ấn phong cách của riêng bạn" description="Tuyển chọn trang sức bạc nữ, nhẫn bạc đôi, dây chuyền bạc và lắc tay bạc thiết kế độc quyền." id="categories-title" />
            <div class="category-grid">
                @forelse($categories as $category)
                    <a class="category-tile" href="{{ route('products.category', $category->slug) }}">
                        <div class="category-tile__media">
                            @if(!empty($category->preview_image))
                                <img src="{{ $category->preview_image }}" alt="{{ $category->seo_display_name ?? $category->name }}" width="360" height="460" loading="lazy" class="category-tile__img">
                            @endif
                            <div class="category-tile__overlay"></div>
                        </div>
                        <span class="category-tile__number">0{{ $loop->iteration }}</span>
                        <div class="category-tile__content">
                            <h3 class="category-tile__title">{{ $category->seo_display_name ?? $category->name }}</h3>
                            <span class="category-tile__count">{{ $category->products_count }} thiết kế bạc 925</span>
                        </div>
                        <span class="category-tile__action" aria-hidden="true">
                            <i class="bi bi-arrow-up-right"></i>
                        </span>
                    </a>
                @empty
                    <x-empty-state title="Chưa có danh mục" />
                @endforelse
            </div>
        </div>
    </section>

    <section class="home-section home-section--soft" id="catalog" aria-labelledby="catalog-title">
        <div class="lunara-container">
            <x-section-heading eyebrow="SẢN PHẨM" title="Khám phá Lunara" description="Những thiết kế trong catalog Lunara Silver." id="catalog-title" />
            <div class="product-grid">
                @forelse($featured as $product)
                    <x-product-card :product="$product" />
                @empty
                    <x-empty-state />
                @endforelse
            </div>
        </div>
    </section>

    <section class="home-section" id="collections" aria-labelledby="collections-title">
        <div class="lunara-container">
            <x-section-heading eyebrow="BỘ TRANG SỨC" title="Sắc bạc, một tổng thể" description="Các bộ trang sức từ catalog Lunara Silver." id="collections-title" />
            <div class="product-grid">
                @forelse($collections as $product)
                    <x-product-card :product="$product" />
                @empty
                    <x-empty-state title="Chưa có bộ trang sức" />
                @endforelse
            </div>
        </div>
    </section>

    <section class="home-section home-section--soft" id="necklaces" aria-labelledby="necklaces-title">
        <div class="lunara-container">
            <x-section-heading eyebrow="DÂY CHUYỀN" title="Điểm sáng gần trái tim" id="necklaces-title" />
            <div class="product-grid">
                @forelse($necklaces as $product)
                    <x-product-card :product="$product" />
                @empty
                    <x-empty-state title="Chưa có dây chuyền" />
                @endforelse
            </div>
        </div>
    </section>

    <section class="home-section" id="rings-bracelets" aria-labelledby="rings-title">
        <div class="lunara-container">
            <x-section-heading eyebrow="NHẪN & VÒNG TAY" title="Chạm vào ánh trăng" id="rings-title" />
            <div class="product-grid">
                @forelse($rings->concat($bracelets) as $product)
                    <x-product-card :product="$product" />
                @empty
                    <x-empty-state title="Chưa có nhẫn hoặc vòng tay" />
                @endforelse
            </div>
        </div>
    </section>

    <section class="home-section home-section--soft gifts-section" id="gifts" aria-labelledby="gifts-title">
        <div class="lunara-container">
            <x-section-heading eyebrow="SET QUÀ TẶNG" title="Gửi một chút ánh trăng" description="Những set quà tặng có thật trong catalog Lunara Silver." id="gifts-title" />
            <div class="product-grid">
                @forelse($gifts as $product)
                    <x-product-card :product="$product" />
                @empty
                    <x-empty-state title="Chưa có set quà tặng" />
                @endforelse
            </div>
        </div>
    </section>

    {{-- Lunara Journal Editorial Section --}}
    @if(isset($latestPosts) && $latestPosts->count() > 0)
        <section class="journal-section py-5 my-3" aria-labelledby="journal-title">
            <div class="lunara-container">
                <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between mb-4 pb-2 border-bottom">
                    <div>
                        <p class="text-uppercase tracking-wider text-muted small fw-semibold mb-1">KIẾN THỨC & CẢM HỨNG</p>
                        <h2 id="journal-title" class="h3 font-serif fw-normal text-dark mb-0">Nhật Ký Lunara</h2>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('blog.index') }}" class="small text-dark fw-medium text-decoration-none">
                            Xem tất cả bài viết <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($latestPosts as $post)
                        <div class="col-12 col-md-4">
                            <article class="blog-card">
                                <a href="{{ route('blog.show', $post->slug) }}" class="blog-card__media">
                                    <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="blog-card__img" loading="lazy">
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
                                        {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 90) }}
                                    </p>
                                    <div class="blog-card__footer">
                                        <span class="blog-card__author" title="Tác giả: {{ $post->author->name ?? 'Lunara Editor' }}">
                                            <i class="bi bi-feather me-1" aria-hidden="true"></i>{{ $post->author->name ?? 'Lunara Editor' }}
                                        </span>
                                        <a href="{{ route('blog.show', $post->slug) }}" class="blog-card__link">
                                            Đọc tiếp <i class="bi bi-chevron-right ms-1" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(!empty($recentlyViewed) && $recentlyViewed->isNotEmpty())
        <section class="home-section home-section--soft" id="recently-viewed" aria-labelledby="recent-title">
            <div class="lunara-container">
                <x-section-heading eyebrow="ĐÃ XEM GẦN ĐÂY" title="Tiếp tục khám phá" description="Những thiết kế bạn đã quan tâm trong các chuyến ghé thăm trước." id="recent-title" />
                <div class="product-grid">
                    @foreach($recentlyViewed as $recent)
                        <x-product-card :product="$recent" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="story-section story-section--cinematic" id="story" aria-labelledby="story-title">
        <div class="story-section__media" aria-hidden="true">
            <video
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
                poster="{{ is_file(public_path('media-previews/hero.webp')) ? asset('media-previews/hero.webp') : route('media.show', ['path' => 'banner.jpg']) }}"
                class="story-section__video"
            >
                <source src="{{ route('media.show', ['path' => 'Animationbanner.mp4']) }}" type="video/mp4">
            </video>
            <div class="story-section__overlay"></div>
        </div>

        <div class="lunara-container story-section__container">
            <div class="story-section__content">
                <p class="eyebrow eyebrow--light">CÂU CHUYỆN LUNARA</p>
                <h2 id="story-title" class="story-section__title">
                    Một ánh sáng<br>
                    <em>của riêng bạn.</em>
                </h2>
                <p class="story-section__lead">
                    Lunara Silver ra đời từ tình yêu với ánh trăng — nguồn sáng dịu dàng nhưng luôn hiện diện, soi rọi mọi hành trình dù đêm tối nhất.
                </p>

                <div class="story-pillars-editorial mt-4">
                    <div class="story-pillar-editorial">
                        <span class="story-pillar-editorial__num">01</span>
                        <div class="story-pillar-editorial__body">
                            <strong>Bạc 925 Tuyển Chọn</strong>
                            <small>Độ sáng bóng bền lâu, an toàn với làn da</small>
                        </div>
                    </div>
                    <div class="story-pillar-editorial">
                        <span class="story-pillar-editorial__num">02</span>
                        <div class="story-pillar-editorial__body">
                            <strong>Chế Tác Tinh Xảo</strong>
                            <small>Đường nét mềm mại, hoàn thiện thủ công tỉ mỉ</small>
                        </div>
                    </div>
                    <div class="story-pillar-editorial">
                        <span class="story-pillar-editorial__num">03</span>
                        <div class="story-pillar-editorial__body">
                            <strong>Cảm Hứng Thiên Văn</strong>
                            <small>Mỗi món trang sức là một câu chuyện vì sao</small>
                        </div>
                    </div>
                </div>

                <div class="story-section__footer mt-4 pt-2">
                    <p class="story-section__slogan mb-3">Shine with your own moonlight</p>
                    <a href="{{ route('about') }}" class="story-section__cta">
                        <span>Khám phá toàn bộ câu chuyện</span>
                        <i class="bi bi-arrow-right ms-2" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- SEO Topical Authority & E-E-A-T Brand Section --}}
    <section class="seo-brand-section py-5 bg-white border-top" aria-labelledby="seo-brand-title">
        <div class="lunara-container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <header class="text-center mb-4">
                        <span class="text-uppercase small tracking-wider text-muted fw-semibold" style="letter-spacing: 1px;">✦ THƯƠNG HIỆU UY TÍN ✦</span>
                        <h2 id="seo-brand-title" class="h3 font-serif fw-normal text-dark mt-1 mb-2">
                            Lunara Silver — Thương Hiệu Trang Sức Bạc Top 1 Tuyển Chọn
                        </h2>
                        <div class="mx-auto bg-dark opacity-25" style="width: 48px; height: 1px;"></div>
                    </header>

                    <div class="seo-brand-content text-muted small" style="line-height: 1.8; font-size: 0.925rem;">
                        <p class="mb-3">
                            Chào mừng bạn đến với <strong>Lunara Silver</strong>, điểm đến tin cậy khi tìm kiếm <strong>trang sức bạc top 1</strong> với chuẩn chất lượng <strong>bạc 925</strong> cao cấp. Lấy cảm hứng từ ánh trăng thanh khiết và các vì tinh tú, Lunara tự hào mang đến thế giới trang sức bạc đa dạng, từ thiết kế thanh lịch thường ngày đến các tác phẩm kim hoàn sang trọng cho những dịp ý nghĩa nhất.
                        </p>

                        <div class="row g-3 my-3">
                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-3 bg-light border h-100">
                                    <h3 class="h6 font-serif fw-semibold text-dark mb-2">
                                        <a href="{{ route('products.category', 'day-chuyen') }}" class="text-dark text-decoration-none">Dây Chuyền Bạc Nữ & Vòng Cổ Bạc</a>
                                    </h3>
                                    <p class="mb-0 text-muted" style="font-size: 0.85rem;">
                                        Tuyển chọn các mẫu <a href="{{ route('products.category', 'day-chuyen') }}" class="text-decoration-underline text-secondary">dây chuyền bạc nữ sợi nhỏ</a>, dây chuyền bạc 925 đính đá tinh khiết. Lunara cũng cung cấp các thiết kế <a href="{{ route('products.index', ['q' => 'dây chuyền bạc nam']) }}" class="text-decoration-underline text-secondary">dây chuyền bạc nam</a> mạnh mẽ, mang lại nét thu hút riêng biệt.
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-3 bg-light border h-100">
                                    <h3 class="h6 font-serif fw-semibold text-dark mb-2">
                                        <a href="{{ route('products.category', 'nhan') }}" class="text-dark text-decoration-none">Nhẫn Bạc 925 & Nhẫn Bạc Đôi</a>
                                    </h3>
                                    <p class="mb-0 text-muted" style="font-size: 0.85rem;">
                                        Khám phá vẻ đẹp tinh tế của <a href="{{ route('products.category', 'nhan') }}" class="text-decoration-underline text-secondary">nhẫn bạc nữ</a>, nhẫn xoắn dải ngân hà cùng các mẫu <a href="{{ route('products.index', ['q' => 'nhẫn bạc đôi']) }}" class="text-decoration-underline text-secondary">nhẫn bạc đôi nam nữ</a> (nhẫn cặp bạc) khắc họa lời hứa yêu thương vĩnh cửu và các thiết kế <a href="{{ route('products.index', ['q' => 'nhẫn nam bạc']) }}" class="text-decoration-underline text-secondary">nhẫn bạc nam</a> lịch lãm.
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-3 bg-light border h-100">
                                    <h3 class="h6 font-serif fw-semibold text-dark mb-2">
                                        <a href="{{ route('products.category', 'vong-tay') }}" class="text-dark text-decoration-none">Vòng Tay Bạc Nữ & Lắc Tay Bạc</a>
                                    </h3>
                                    <p class="mb-0 text-muted" style="font-size: 0.85rem;">
                                        Tôn vinh cổ tay mềm mại cùng <a href="{{ route('products.category', 'vong-tay') }}" class="text-decoration-underline text-secondary">vòng tay bạc nữ đẹp</a>, lắc tay bạc tinh xảo, phối hợp hoàn hảo với các mẫu <a href="{{ route('products.index', ['q' => 'lắc chân bạc nữ']) }}" class="text-decoration-underline text-secondary">lắc chân bạc nữ</a> và vòng bạc đôi thời thượng.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <p class="mt-3 mb-0 text-center text-muted" style="font-size: 0.875rem;">
                            <em>Lunara Silver cam kết 100% chuẩn bạc 925 sáng bóng bền lâu, an toàn tuyệt đối cho làn da, kèm hộp quà nhung cao cấp và dịch vụ bảo hành làm sáng trọn đời.</em>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
