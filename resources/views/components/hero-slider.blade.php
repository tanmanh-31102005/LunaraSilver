@php
if (!isset($slides)) {
    $dbBanners = \App\Models\Banner::query()->active()->ordered()->get();
    if ($dbBanners->isNotEmpty()) {
        $slides = $dbBanners->map(function ($banner, $index) {
            return [
                'id' => 'hero-slide-db-' . $banner->id,
                'overline' => $banner->subtitle ?: ($index === 0 ? 'LUNARA SILVER · THƯƠNG HIỆU UY TÍN' : 'LUNARA SILVER'),
                'title' => $banner->title ?: ($index === 0 ? 'Trang Sức Bạc Top 1' : 'Tỏa sáng cùng nhịp điệu riêng của bạn'),
                'description' => $banner->subtitle ?: ($index === 0 ? 'Thương hiệu trang sức bạc 925 hàng đầu — Tuyển chọn dây chuyền bạc nữ, nhẫn bạc đôi, lắc tay bạc và bộ sưu tập độc quyền.' : ''),
                'cta_label' => $banner->button_text ?: 'Khám phá bộ sưu tập',
                'cta_url' => $banner->link ?: route('products.index'),
                'image' => $banner->displayUrl(),
                'image_alt' => $banner->title ?: 'Trang sức bạc top 1 Lunara Silver',
                'position' => '72% center',
                'mobile_position' => '72% center',
                'preload' => $index === 0,
            ];
        })->toArray();
    }
}

$slides = $slides ?? [
    [
        'id' => 'hero-slide-1',
        'overline' => 'LUNARA SILVER · THƯƠNG HIỆU UY TÍN',
        'title' => 'Trang Sức Bạc Top 1',
        'description' => 'Thương hiệu trang sức bạc 925 hàng đầu — Tuyển chọn dây chuyền bạc nữ, nhẫn bạc đôi, lắc tay bạc và bộ sưu tập ánh trăng độc quyền.',
        'cta_label' => 'Khám phá ngay',
        'cta_url' => route('products.index'),
        'image' => asset('media-previews/hero.webp'),
        'image_alt' => 'Trang sức bạc top 1 Lunara Silver',
        'position' => '72% center',
        'mobile_position' => '72% center',
        'preload' => true,
    ],
    [
        'id' => 'hero-slide-2',
        'overline' => 'BỘ SƯU TẬP BẠC 925 TINH TUYỂN',
        'title' => 'Dây Chuyền Bạc Nữ & Nhẫn Bạc 925',
        'description' => 'Tỏa sáng cùng trang sức bạc nữ thiết kế thanh lịch, giác cắt đá Moissanite và Moonstone hoàn mỹ.',
        'cta_label' => 'Xem dây chuyền & nhẫn bạc',
        'cta_url' => route('products.category', 'day-chuyen'),
        'image' => asset('media-previews/hero-2.webp'),
        'image_alt' => 'Dây chuyền bạc nữ và nhẫn bạc 925 Lunara Silver',
        'position' => '75% center',
        'mobile_position' => '75% center',
        'preload' => false,
    ],
    [
        'id' => 'hero-slide-3',
        'overline' => 'KỶ NIỆM & QUÀ TẶNG Ý NGHĨA',
        'title' => 'Nhẫn Bạc Đôi & Vòng Tay Bạc Cao Cấp',
        'description' => 'Gắn kết yêu thương với nhẫn bạc cặp, lắc chân bạc nữ và set quà tặng trang sức bạc sang trọng.',
        'cta_label' => 'Khám phá quà tặng',
        'cta_url' => route('products.category', 'set-qua-tang'),
        'image' => asset('media-previews/hero-3.webp'),
        'image_alt' => 'Nhẫn bạc đôi và vòng tay bạc Lunara Silver',
        'position' => '78% center',
        'mobile_position' => '78% center',
        'preload' => false,
    ],
];
@endphp

<section 
    class="hero-slider" 
    id="heroSlider" 
    aria-roledescription="carousel" 
    aria-label="Banner nổi bật Lunara Silver"
    data-autoplay="true"
    data-interval="5500"
>
    {{-- Carousel Track / Slides --}}
    <div class="hero-slider__track">
        @foreach($slides as $index => $slide)
            <article 
                class="hero-slide {{ $loop->first ? 'hero-slide--active' : '' }}" 
                id="{{ $slide['id'] }}"
                role="group" 
                aria-roledescription="slide" 
                aria-label="{{ $index + 1 }} / {{ count($slides) }}: {{ $slide['title'] }}"
                aria-hidden="{{ $loop->first ? 'false' : 'true' }}"
                data-slide-index="{{ $index }}"
            >
                <div class="hero-slide__media">
                    <img 
                        class="hero-slide__image" 
                        src="{{ $slide['image'] }}" 
                        alt="{{ $slide['image_alt'] }}" 
                        width="1920" 
                        height="820"
                        @if(!empty($slide['preload']))
                            fetchpriority="high" 
                            loading="eager"
                        @else
                            loading="lazy"
                        @endif
                        style="--desktop-pos: {{ $slide['position'] }}; --mobile-pos: {{ $slide['mobile_position'] }};"
                    >
                    <div class="hero-slide__overlay" aria-hidden="true"></div>
                </div>

                <div class="lunara-container hero-slide__container">
                    <div class="hero-slide__content">
                        <span class="hero-slide__overline">{{ $slide['overline'] }}</span>
                        <h1 class="hero-slide__title">{{ $slide['title'] }}</h1>
                        <p class="hero-slide__description">{{ $slide['description'] }}</p>
                        <div class="hero-slide__actions">
                            <a href="{{ $slide['cta_url'] }}" class="hero-slide__cta">
                                {{ $slide['cta_label'] }}
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    {{-- Bottom Controller Bar (Indicators + Index + Nav) --}}
    <div class="hero-slider__controls-wrap">
        <div class="lunara-container hero-slider__controls-inner">
            {{-- Line Progress Indicators --}}
            <nav class="hero-slider__indicators" role="tablist" aria-label="Danh sách slide">
                @foreach($slides as $index => $slide)
                    <button 
                        type="button" 
                        class="hero-indicator {{ $loop->first ? 'hero-indicator--active' : '' }}" 
                        role="tab" 
                        id="hero-tab-{{ $index }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}" 
                        aria-controls="{{ $slide['id'] }}"
                        aria-label="Chuyển đến slide {{ $index + 1 }}: {{ $slide['overline'] }}"
                        data-slide-target="{{ $index }}"
                    >
                        <span class="hero-indicator__num">0{{ $index + 1 }}</span>
                        <span class="hero-indicator__line" aria-hidden="true">
                            <span class="hero-indicator__progress"></span>
                        </span>
                    </button>
                @endforeach
            </nav>

            {{-- Prev / Next Desktop Navigation --}}
            <div class="hero-slider__arrows d-none d-md-flex" aria-label="Điều hướng banner">
                <button 
                    type="button" 
                    class="hero-slider__arrow hero-slider__arrow--prev" 
                    id="heroSliderPrev" 
                    aria-label="Slide trước"
                >
                    <i class="bi bi-chevron-left" aria-hidden="true"></i>
                </button>
                <button 
                    type="button" 
                    class="hero-slider__arrow hero-slider__arrow--next" 
                    id="heroSliderNext" 
                    aria-label="Slide tiếp theo"
                >
                    <i class="bi bi-chevron-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Accessible pause control for screen readers / keyboard users --}}
    <button 
        type="button" 
        class="hero-slider__pause visually-hidden-focusable" 
        id="heroSliderPauseBtn" 
        aria-pressed="false"
        aria-label="Tạm dừng tự động chuyển banner"
    >
        Tạm dừng trình chiếu
    </button>
</section>
