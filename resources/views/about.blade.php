@extends('layouts.app')

@section('title', 'Câu chuyện Lunara | Lunara Silver')
@section('meta_description', 'Lunara Silver ra đời từ tình yêu với ánh trăng — nguồn sáng dịu dàng nhưng luôn hiện diện, soi rọi mỗi hành trình dù đêm tối nhất.')
@section('canonical', route('about'))
@section('og_type', 'website')
@section('main_class', 'about-main')

@push('schema')
<x-seo.json-ld :schema="app(\App\Services\StructuredDataService::class)->organizationSchema()" />
<x-seo.json-ld :schema="app(\App\Services\StructuredDataService::class)->breadcrumbSchema([['label' => 'Câu chuyện Lunara', 'url' => route('about')]])" />
@endpush

@section('content')
<div class="about-page">

    {{-- SECTION 01 — CINEMATIC VIDEO HERO --}}
    <section class="about-hero" aria-label="Giới thiệu Lunara Silver">
        <div class="about-hero__media">
            <video
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
                poster="{{ is_file(public_path('media-previews/hero.webp')) ? asset('media-previews/hero.webp') : route('media.show', ['path' => 'banner.jpg']) }}"
                class="about-hero__video"
                aria-hidden="true"
            >
                <source src="{{ route('media.show', ['path' => 'Animationbanner.mp4']) }}" type="video/mp4">
            </video>
            <div class="about-hero__overlay" aria-hidden="true"></div>
        </div>

        <div class="lunara-container about-hero__container">
            <div class="about-hero__content">
                <span class="about-hero__badge">
                    <span class="about-hero__badge-dot">✦</span> CÂU CHUYỆN LUNARA
                </span>
                <h1 class="about-hero__title">
                    Một ánh sáng<br>
                    <em>của riêng bạn.</em>
                </h1>
                <p class="about-hero__description">
                    Lunara Silver ra đời từ tình yêu với ánh trăng — nguồn sáng dịu dàng nhưng luôn hiện diện, soi rọi mỗi hành trình dù đêm tối nhất.
                </p>
                <div class="about-hero__actions">
                    <a href="#about-signature" class="about-hero__cta" id="heroScrollCta" aria-label="Khám phá câu chuyện Lunara Silver">
                        <span>KHÁM PHÁ CÂU CHUYỆN</span>
                        <i class="bi bi-arrow-down-short about-hero__arrow" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 02 — BRAND SIGNATURE (DẤU ẤN LUNARA) --}}
    <section class="about-signature" id="about-signature" aria-label="Dấu ấn thương hiệu Lunara">
        <div class="lunara-container">
            <div class="about-signature__inner about-reveal">
                <div class="about-signature__seal-wrapper">
                    <div class="about-signature__halo" aria-hidden="true"></div>
                    <img
                        src="{{ route('media.show', ['path' => 'lunara-mark.svg']) }}"
                        alt="Biểu tượng vầng trăng khuyết Lunara Silver"
                        class="about-signature__emblem"
                        width="96"
                        height="96"
                        loading="lazy"
                    >
                </div>
                <span class="about-signature__overline">✦ EST. 2024 · LUNARA ATELIER ✦</span>
                <span class="about-signature__brand">LUNARA SILVER</span>
                <p class="about-signature__slogan">Shine with your own moonlight</p>
                <div class="about-signature__divider" aria-hidden="true"></div>
            </div>
        </div>
    </section>

    {{-- SECTION 03 — KHỞI NGUỒN (ORIGIN STORY) --}}
    <section class="about-origin" aria-labelledby="origin-heading">
        <div class="lunara-container">
            <div class="about-origin__grid">
                <div class="about-origin__media-col about-reveal">
                    <div class="about-origin__frame">
                        <img 
                            src="{{ asset('media-previews/hero-2.webp') }}" 
                            alt="Cảm hứng ánh trăng Lunara Silver" 
                            class="about-origin__img"
                            width="580"
                            height="580"
                            loading="lazy"
                        >
                    </div>
                </div>

                <div class="about-origin__content-col about-reveal">
                    <span class="eyebrow">01 — KHỞI NGUỒN</span>
                    <h2 id="origin-heading" class="about-origin__heading">
                        Một cái tên được<br>sinh ra từ ánh trăng.
                    </h2>
                    <div class="about-origin__rule" aria-hidden="true"></div>

                    <blockquote class="about-origin__quote">
                        “Chúng tôi tin rằng món trang sức đẹp nhất không cần phải phô trương để được chú ý. Ánh trăng dịu êm luôn là nguồn sáng tinh khiết và bền bỉ nhất.”
                    </blockquote>

                    <p class="about-origin__text">
                        Lunara mang trong mình hình ảnh của ánh sáng dịu êm nơi bầu trời đêm... Không quá rực rỡ, không cần phô trương.
                    </p>
                    <p class="about-origin__text">
                        Một ánh sáng đủ để mỗi người tìm thấy vẻ đẹp, sự bình yên và tự tin của riêng mình trong từng khoảnh khắc cuộc sống. Mỗi giác cắt bạc 925 đều ôm ấp câu chuyện của sự nâng niu và thấu cảm.
                    </p>

                    <div class="about-origin__features mt-4">
                        <div class="about-origin__feat">
                            <i class="bi bi-moon-stars text-accent" aria-hidden="true"></i>
                            <div>
                                <strong>Vẻ Đẹp Tự Nhiên</strong>
                                <small>Hòa hợp cùng khí chất và phong cách riêng</small>
                            </div>
                        </div>
                        <div class="about-origin__feat">
                            <i class="bi bi-gem text-accent" aria-hidden="true"></i>
                            <div>
                                <strong>Sắc Bạc Vĩnh Cửu</strong>
                                <small>Bền bỉ, tinh khôi và an lành cho làn da</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 04 — VALUES (BA TRỤ CỘT GIÁ TRỊ) --}}
    <section class="about-values" aria-labelledby="values-heading">
        <div class="lunara-container">
            <div class="about-values__header about-reveal">
                <span class="eyebrow">GIÁ TRỊ CỐT LÕI</span>
                <h2 id="values-heading" class="about-values__heading">Ba Trụ Cột Lunara Silver</h2>
                <p class="about-values__sub">Sự cam kết bền vững về chất lượng nguyên liệu, tay nghề chế tác thủ công và triết lý thiên văn.</p>
                <div class="about-values__divider-line" aria-hidden="true"></div>
            </div>

            <div class="about-values__grid">
                <article class="about-value-card about-reveal">
                    <div class="about-value-card__header">
                        <span class="about-value-card__num" aria-hidden="true">01</span>
                        <span class="about-value-card__badge">TUYỂN CHỌN</span>
                    </div>
                    <h3 class="about-value-card__title">Bạc 925 Tuyển Chọn</h3>
                    <p class="about-value-card__desc">
                        Độ sáng bóng bền lâu, an toàn với làn da và giữ trọn sắc trắng tinh tế qua thời gian. Chuẩn tỷ lệ bạc quốc tế mang lại độ cứng cáp và tinh khiết cao nhất.
                    </p>
                    <div class="about-value-card__footer">
                        <span class="about-value-card__check"><i class="bi bi-shield-check me-1"></i> Chuẩn tỷ lệ tuổi bạc</span>
                    </div>
                </article>

                <article class="about-value-card about-reveal">
                    <div class="about-value-card__header">
                        <span class="about-value-card__num" aria-hidden="true">02</span>
                        <span class="about-value-card__badge">THỦ CÔNG</span>
                    </div>
                    <h3 class="about-value-card__title">Chế Tác Tinh Xảo</h3>
                    <p class="about-value-card__desc">
                        Đường nét mềm mại, hoàn thiện thủ công tỉ mỉ từng chi tiết từ ổ đá, các mắt nối dây chuyền đến từng chốt khóa tinh xảo, mượt mà trên từng điểm chạm.
                    </p>
                    <div class="about-value-card__footer">
                        <span class="about-value-card__check"><i class="bi bi-stars me-1"></i> Đánh bóng gương đa tầng</span>
                    </div>
                </article>

                <article class="about-value-card about-reveal">
                    <div class="about-value-card__header">
                        <span class="about-value-card__num" aria-hidden="true">03</span>
                        <span class="about-value-card__badge">THIÊN VĂN</span>
                    </div>
                    <h3 class="about-value-card__title">Cảm Hứng Thiên Văn</h3>
                    <p class="about-value-card__desc">
                        Mỗi món trang sức là một câu chuyện vì sao, biểu trưng cho những ước vọng, sự chở che và năng lượng an lành soi sáng hành trình cuộc sống của bạn.
                    </p>
                    <div class="about-value-card__footer">
                        <span class="about-value-card__check"><i class="bi bi-moon me-1"></i> Dấu ấn thiên hà độc bản</span>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- SECTION 05 — CINEMATIC STATEMENT (FULL-BLEED) --}}
    <section class="about-statement" aria-label="Tuyên ngôn thương hiệu Lunara">
        <div class="about-statement__backdrop" aria-hidden="true"></div>
        <div class="lunara-container about-statement__container">
            <div class="about-statement__inner about-reveal">
                <span class="about-statement__eyebrow">✦ LUNARA STATEMENT ✦</span>
                <h2 class="about-statement__title">TRANG SỨC KHÔNG CHỈ ĐỂ TỎA SÁNG.</h2>
                <p class="about-statement__quote">
                    Đó là cách mỗi người kể câu chuyện của riêng mình.
                </p>
                <div class="about-statement__line" aria-hidden="true"></div>
            </div>
        </div>
    </section>

    {{-- SECTION 06 — DESIGN PHILOSOPHY (4 GIAI ĐOẠN) --}}
    <section class="about-philosophy" aria-labelledby="philosophy-heading">
        <div class="lunara-container">
            <div class="about-philosophy__header about-reveal">
                <span class="eyebrow">02 — TỪ CẢM HỨNG ĐẾN THIẾT KẾ</span>
                <h2 id="philosophy-heading" class="about-philosophy__heading">Những đường nét được tạo nên từ một câu chuyện.</h2>
                <p class="about-philosophy__sub">Quy trình sáng tạo và chế tác thủ công chuẩn mực gửi trọn sự tinh tế trong mỗi công đoạn.</p>
                <div class="about-philosophy__divider-line" aria-hidden="true"></div>
            </div>

            <div class="about-philosophy__grid">
                <div class="about-step-card about-reveal">
                    <div class="about-step-card__top">
                        <span class="about-step-card__pill">BƯỚC 01</span>
                        <i class="bi bi-lightbulb about-step-card__icon" aria-hidden="true"></i>
                    </div>
                    <h3 class="about-step-card__name">CẢM HỨNG</h3>
                    <p class="about-step-card__text">Từ những vệt sáng huyền ảo của mặt trăng và các vì tinh tú trên bầu trời đêm sâu thẳm.</p>
                </div>

                <div class="about-step-card about-reveal">
                    <div class="about-step-card__top">
                        <span class="about-step-card__pill">BƯỚC 02</span>
                        <i class="bi bi-pencil-square about-step-card__icon" aria-hidden="true"></i>
                    </div>
                    <h3 class="about-step-card__name">THIẾT KẾ</h3>
                    <p class="about-step-card__text">Phác họa từng đường cong thanh thoát, tôn vinh dáng vẻ thanh lịch và khí chất tự nhiên.</p>
                </div>

                <div class="about-step-card about-reveal">
                    <div class="about-step-card__top">
                        <span class="about-step-card__pill">BƯỚC 03</span>
                        <i class="bi bi-hammer about-step-card__icon" aria-hidden="true"></i>
                    </div>
                    <h3 class="about-step-card__name">CHẾ TÁC</h3>
                    <p class="about-step-card__text">Đúc phôi bạc 925 tuyển chọn, gọt giũa và đính kết đá quý tỉ mỉ dưới bàn tay nghệ nhân.</p>
                </div>

                <div class="about-step-card about-reveal">
                    <div class="about-step-card__top">
                        <span class="about-step-card__pill">BƯỚC 04</span>
                        <i class="bi bi-box2-heart about-step-card__icon" aria-hidden="true"></i>
                    </div>
                    <h3 class="about-step-card__name">HOÀN THIỆN</h3>
                    <p class="about-step-card__text">Đánh bóng gương sáng trong, kiểm định khắt khe và đóng gói trân trọng trong từng hộp quà.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 07 — CELESTIAL WHISPERS (FEATURED COLLECTION) --}}
    @if($celestialCollection)
        <section class="about-collection" aria-labelledby="collection-heading">
            <div class="lunara-container">
                <div class="about-collection__grid">
                    <div class="about-collection__media about-reveal">
                        @php
                            $colImg = $celestialCollection->images->firstWhere('image_role', 'primary') ?? $celestialCollection->images->first();
                            $colImgUrl = $colImg?->displayUrl() ?? asset('media-previews/hero.webp');
                        @endphp
                        <img
                            src="{{ $colImgUrl }}"
                            alt="{{ $celestialCollection->name }} — Lunara Silver"
                            class="about-collection__img"
                            width="640"
                            height="500"
                            loading="lazy"
                        >
                        <div class="about-collection__badge-overlay">
                            <span>✦ BỘ SƯU TẬP TIÊU BIỂU</span>
                        </div>
                    </div>
                    <div class="about-collection__info about-reveal">
                        <span class="eyebrow">DẤU ẤN ĐẶC BIỆT</span>
                        <h2 id="collection-heading" class="about-collection__title">{{ $celestialCollection->name }}</h2>
                        <h3 class="about-collection__subtitle">Những lời thì thầm từ bầu trời đêm.</h3>
                        <p class="about-collection__desc">
                            {{ $celestialCollection->short_description ?: $celestialCollection->description ?: 'Bộ sưu tập lấy cảm hứng từ các chòm sao và chu kỳ trăng, mang vẻ đẹp huyền diệu và thanh lịch bất tận.' }}
                        </p>
                        <div>
                            <a href="{{ route('products.show', $celestialCollection->slug) }}" class="about-editorial-link">
                                <span>KHÁM PHÁ BỘ SƯU TẬP</span>
                                <i class="bi bi-arrow-right ms-2" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- SECTION 08 — JEWELRY EDITORIAL --}}
    @if(isset($categoryVisuals) && $categoryVisuals->isNotEmpty())
        <section class="about-categories" aria-labelledby="categories-heading">
            <div class="lunara-container">
                <div class="about-categories__header about-reveal">
                    <span class="eyebrow">BỘ SƯU TẬP THEO DANH MỤC</span>
                    <h2 id="categories-heading" class="about-categories__heading">
                        ĐƯỢC TẠO NÊN ĐỂ ĐỒNG HÀNH CÙNG BẠN
                    </h2>
                    <p class="about-categories__sub">Những tạo tác bạc 925 đồng điệu cùng từng nhịp sống và phong cách cá nhân.</p>
                    <div class="about-categories__divider-line" aria-hidden="true"></div>
                </div>

                <div class="about-categories__grid">
                    @foreach($categoryVisuals as $catItem)
                        <a href="{{ $catItem['url'] }}" class="about-cat-tile about-reveal">
                            <div class="about-cat-tile__media">
                                <img
                                    src="{{ $catItem['image_url'] }}"
                                    alt="{{ $catItem['alt'] }}"
                                    class="about-cat-tile__img"
                                    width="420"
                                    height="520"
                                    loading="lazy"
                                >
                                <div class="about-cat-tile__overlay"></div>
                            </div>
                            <span class="about-cat-tile__number">0{{ $loop->iteration }}</span>
                            <div class="about-cat-tile__content">
                                <h3 class="about-cat-tile__title">{{ $catItem['name'] }}</h3>
                                <span class="about-cat-tile__action">
                                    <span>Khám phá bộ sưu tập</span>
                                    <i class="bi bi-arrow-up-right ms-1" aria-hidden="true"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- SECTION 09 — BRAND QUOTE --}}
    <section class="about-quote" aria-label="Thông điệp Lunara Silver">
        <div class="lunara-container">
            <div class="about-quote__inner about-reveal">
                <span class="about-quote__mark" aria-hidden="true">“</span>
                <blockquote class="about-quote__text">
                    Shine with your<br>own moonlight.
                </blockquote>
                <cite class="about-quote__author">— LUNARA SILVER —</cite>
            </div>
        </div>
    </section>

    {{-- SECTION 10 — FINAL CTA (MIDNIGHT) --}}
    <section class="about-cta" aria-labelledby="cta-heading">
        <div class="lunara-container">
            <div class="about-cta__inner about-reveal">
                <span class="about-cta__badge">KHỞI ĐẦU HÀNH TRÌNH</span>
                <h2 id="cta-heading" class="about-cta__title">Mỗi người đều có một ánh sáng riêng.</h2>
                <p class="about-cta__desc">
                    Khám phá những thiết kế mang câu chuyện của bạn và tỏa sáng rực rỡ theo cách dịu dàng, tự tin nhất.
                </p>
                <div class="about-cta__actions">
                    <a href="{{ route('products.index') }}" class="about-cta__btn-primary">
                        <span>KHÁM PHÁ TẤT CẢ TRANG SỨC</span>
                        <i class="bi bi-arrow-right ms-2" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('contact') }}" class="about-cta__btn-secondary">
                        <span>LIÊN HỆ &amp; SHOWROOM</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
