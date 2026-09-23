@php
$slides = $slides ?? [
    [
        'id' => 'hero-slide-1',
        'overline' => 'BỘ SƯU TẬP ÁNH TRĂNG',
        'title' => 'Tỏa sáng cùng nhịp điệu riêng của bạn',
        'description' => 'Khám phá những thiết kế bạc lấy cảm hứng từ bầu trời đêm.',
        'cta_label' => 'Khám phá bộ sưu tập',
        'cta_url' => route('products.category', 'bo-trang-suc'),
        'image' => asset('media-previews/hero.webp'),
        'image_alt' => 'Bộ sưu tập trang sức bạc Ánh Trăng Lunara',
        'position' => '72% center',
        'mobile_position' => '72% center',
        'preload' => true,
    ],
    [
        'id' => 'hero-slide-2',
        'overline' => 'LUNARA SILVER',
        'title' => 'Trang sức cho những khoảnh khắc đáng nhớ',
        'description' => 'Những đường nét tinh tế, thanh lịch và hiện đại.',
        'cta_label' => 'Xem sản phẩm',
        'cta_url' => route('products.index'),
        'image' => asset('media-previews/hero-2.webp'),
        'image_alt' => 'Trang sức bạc thanh lịch Lunara Silver',
        'position' => '75% center',
        'mobile_position' => '75% center',
        'preload' => false,
    ],
    [
        'id' => 'hero-slide-3',
        'overline' => 'QUÀ TẶNG TỪ ÁNH TRĂNG',
        'title' => 'Một món quà nhỏ, một dấu ấn thật lâu',
        'description' => 'Khám phá những lựa chọn quà tặng tinh tế từ Lunara.',
        'cta_label' => 'Khám phá quà tặng',
        'cta_url' => route('products.category', 'set-qua-tang'),
        'image' => asset('media-previews/hero-3.webp'),
        'image_alt' => 'Hộp quà tặng trang sức bạc Lunara Silver',
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
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button 
                    type="button" 
                    class="hero-slider__arrow hero-slider__arrow--next" 
                    id="heroSliderNext" 
                    aria-label="Slide tiếp theo"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
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
