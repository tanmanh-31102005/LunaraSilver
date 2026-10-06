@php
if (!isset($slides)) {
    $dbBanners = \App\Models\Banner::query()->active()->ordered()->get();
    if ($dbBanners->isNotEmpty()) {
        $slides = $dbBanners->map(function ($banner, $index) {
            $defaultTitles = [
                'Trang Sức Bạc Top 1',
                'Dây Chuyền Bạc Nữ & Nhẫn Bạc 925',
                'Nhẫn Bạc Đôi & Vòng Tay Bạc Cao Cấp',
            ];
            $defaultOverlines = [
                'LUNARA SILVER · THƯƠNG HIỆU UY TÍN',
                'BỘ SƯU TẬP BẠC 925 TINH TUYỂN',
                'KỶ NIỆM & QUÀ TẶNG Ý NGHĨA',
            ];
            $defaultDescs = [
                'Chuyên trang sức bạc nữ, dây chuyền bạc 925, nhẫn bạc đôi và lắc tay bạc cao cấp. Thiết kế tinh xảo, sáng bóng bền lâu và bảo hành trọn đời.',
                'Tuyển chọn dây chuyền bạc nữ sợi nhỏ, nhẫn bạc nữ đính đá và lắc tay bạc thời thượng, tôn vinh thần thái quyến rũ và nét đẹp tinh khôi.',
                'Nhẫn đôi bạc nam nữ, vòng tay đôi bạc 925 cao cấp kèm hộp quà nhung sang trọng, túi xách cao cấp và thiệp viết tay Lunara.',
            ];
            $defaultTags = [
                ['Bạc 925 Chuẩn Quốc Tế', 'Dây Chuyền Bạc Nữ', 'Nhẫn Bạc 925', 'Lắc Tay Bạc'],
                ['Dây Chuyền Bạc Nữ Sợi Nhỏ', 'Nhẫn Bạc Nữ Đính Đá', 'Lắc Tay Bạc Nữ'],
                ['Nhẫn Bạc Đôi Nam Nữ', 'Vòng Tay Bạc Đôi', 'Set Quà Tặng Bạc'],
            ];

            return [
                'id' => 'hero-slide-db-' . $banner->id,
                'overline' => $banner->subtitle ?: ($defaultOverlines[$index % 3]),
                'title' => $banner->title ?: ($defaultTitles[$index % 3]),
                'description' => $defaultDescs[$index % 3],
                'highlights' => $defaultTags[$index % 3],
                'cta_label' => $banner->button_text ?: ($index === 0 ? 'Khám phá ngay' : ($index === 1 ? 'Xem dây chuyền & nhẫn bạc' : 'Khám phá quà tặng')),
                'cta_url' => $banner->link ?: route('products.index'),
                'image' => $banner->displayUrl(),
                'image_alt' => $banner->title ?: 'Trang sức bạc top 1 Lunara Silver',
                'position' => 'center center',
                'mobile_position' => 'center center',
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
        'description' => 'Chuyên trang sức bạc nữ, dây chuyền bạc 925, nhẫn bạc đôi và lắc tay bạc cao cấp chế tác tinh xảo, sáng bóng bền lâu.',
        'highlights' => ['Bạc 925 Chuẩn Quốc Tế', 'Dây Chuyền Bạc Nữ', 'Nhẫn Bạc 925', 'Lắc Tay Bạc'],
        'cta_label' => 'Khám phá ngay',
        'cta_url' => route('products.index'),
        'image' => asset('media-previews/hero.webp'),
        'image_alt' => 'Trang sức bạc top 1 Lunara Silver - Bạc 925 cao cấp',
        'position' => 'center center',
        'mobile_position' => 'center center',
        'preload' => true,
    ],
    [
        'id' => 'hero-slide-2',
        'overline' => 'BỘ SƯU TẬP BẠC 925 TINH TUYỂN',
        'title' => 'Dây Chuyền Bạc Nữ & Nhẫn Bạc 925',
        'description' => 'Tuyển chọn dây chuyền bạc nữ sợi nhỏ, nhẫn bạc nữ đính đá và lắc tay bạc thời thượng, tôn vinh thần thái quyến rũ và nét đẹp tinh khôi.',
        'highlights' => ['Dây Chuyền Bạc Nữ Sợi Nhỏ', 'Nhẫn Bạc Nữ Đính Đá', 'Lắc Tay Bạc Nữ'],
        'cta_label' => 'Xem dây chuyền & nhẫn bạc',
        'cta_url' => route('products.category', 'day-chuyen'),
        'image' => asset('media-previews/hero-2.webp'),
        'image_alt' => 'Dây chuyền bạc nữ và nhẫn bạc 925 cao cấp Lunara Silver',
        'position' => 'center center',
        'mobile_position' => 'center center',
        'preload' => false,
    ],
    [
        'id' => 'hero-slide-3',
        'overline' => 'KỶ NIỆM & QUÀ TẶNG Ý NGHĨA',
        'title' => 'Nhẫn Bạc Đôi & Vòng Tay Bạc Cao Cấp',
        'description' => 'Nhẫn đôi bạc nam nữ, vòng tay đôi bạc 925 cao cấp kèm hộp quà nhung sang trọng, túi xách cao cấp và thiệp viết tay Lunara trao trọn yêu thương.',
        'highlights' => ['Nhẫn Bạc Đôi Nam Nữ', 'Vòng Tay Bạc Đôi', 'Set Quà Tặng Bạc'],
        'cta_label' => 'Khám phá quà tặng',
        'cta_url' => route('products.category', 'set-qua-tang'),
        'image' => asset('media-previews/hero-3.webp'),
        'image_alt' => 'Nhẫn bạc đôi và hộp quà tặng trang sức bạc Lunara Silver',
        'position' => 'center center',
        'mobile_position' => 'center center',
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
                        @if($loop->first)
                            <h1 class="hero-slide__title">{{ $slide['title'] }}</h1>
                        @else
                            <h2 class="hero-slide__title">{{ $slide['title'] }}</h2>
                        @endif
                        @if(!empty($slide['highlights']))
                            <div class="hero-slide__tags" aria-label="Từ khóa nổi bật">
                                @foreach($slide['highlights'] as $tag)
                                    <span class="hero-slide__tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
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
