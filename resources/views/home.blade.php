@extends('layouts.app')

@section('title', 'Lunara Silver — Shine with your own moonlight')
@section('meta_description', 'Khám phá trang sức bạc Lunara Silver lấy cảm hứng từ mặt trăng, các vì sao và dải ngân hà.')
@section('main_class', 'home-main')

@section('content')
    <x-hero-slider />

    <section class="home-section categories-section" aria-labelledby="categories-title">
        <div class="lunara-container">
            <x-section-heading eyebrow="DANH MỤC" title="Tìm dấu ấn của riêng bạn" id="categories-title" />
            <div class="category-grid">
                @forelse($categories as $category)
                    <a class="category-tile" href="{{ route('products.category', $category->slug) }}">
                        <div class="category-tile__media">
                            @if(!empty($category->preview_image))
                                <img src="{{ $category->preview_image }}" alt="{{ $category->name }}" width="360" height="460" loading="lazy" class="category-tile__img">
                            @endif
                            <div class="category-tile__overlay"></div>
                        </div>
                        <span class="category-tile__number">0{{ $loop->iteration }}</span>
                        <div class="category-tile__content">
                            <h3 class="category-tile__title">{{ $category->name }}</h3>
                            <span class="category-tile__count">{{ $category->products_count }} thiết kế</span>
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

    <section class="story-section" id="story" aria-labelledby="story-title">
        <div class="lunara-container story-section__inner">
            <div class="story-section__visual">
                <div class="story-mark-showcase">
                    <div class="story-mark-halo" aria-hidden="true"></div>
                    <div class="story-mark-ring" aria-hidden="true"></div>
                    <div class="story-moon-stars" aria-hidden="true">
                        <span class="star star--1">✦</span>
                        <span class="star star--2">✦</span>
                        <span class="star star--3">✦</span>
                    </div>
                    <img 
                        src="{{ route('media.show', ['path' => 'lunara-mark.svg']) }}" 
                        alt="Biểu tượng Lunara Silver" 
                        class="story-mark-img"
                        width="240" 
                        height="240"
                    >
                    <span class="story-moon-tag">LUNARA · EMBLEM</span>
                </div>
            </div>
            <div class="story-section__copy">
                <p class="eyebrow eyebrow--light">CÂU CHUYỆN LUNARA</p>
                <h2 id="story-title">Một ánh sáng<br><em>của riêng bạn.</em></h2>
                <p>Lunara Silver ra đời từ tình yêu với ánh trăng — nguồn sáng dịu dàng nhưng luôn hiện diện, soi rọi mọi hành trình dù đêm tối nhất.</p>

                <div class="story-pillars mt-4">
                    <div class="story-pillar">
                        <span class="story-pillar__icon">✦</span>
                        <div class="story-pillar__text">
                            <strong>Bạc 925 Tuyển Chọn</strong>
                            <small>Độ sáng bóng bền lâu, an toàn với làn da</small>
                        </div>
                    </div>
                    <div class="story-pillar">
                        <span class="story-pillar__icon">✦</span>
                        <div class="story-pillar__text">
                            <strong>Chế Tác Tinh Xảo</strong>
                            <small>Đường nét mềm mại, hoàn thiện thủ công tỉ mỉ</small>
                        </div>
                    </div>
                    <div class="story-pillar">
                        <span class="story-pillar__icon">✦</span>
                        <div class="story-pillar__text">
                            <strong>Cảm Hứng Thiên Văn</strong>
                            <small>Mỗi món trang sức là một câu chuyện vì sao</small>
                        </div>
                    </div>
                </div>

                <p class="story-section__slogan mt-4 mb-0">Shine with your own moonlight</p>
            </div>
        </div>
    </section>
@endsection
