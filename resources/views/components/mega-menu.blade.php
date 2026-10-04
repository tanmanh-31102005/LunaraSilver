@props(['navData' => []])

<div class="mega-menu" id="megaMenu" role="region" aria-label="Menu điều hướng mở rộng" hidden>
    {{-- Transparent hover corridor bridge to prevent accidental closure --}}
    <div class="mega-menu__bridge"></div>

    <div class="mega-menu__container lunara-container">
        {{-- Panel 1: TRANG SỨC --}}
        <div class="mega-menu__panel" id="mega-panel-trang-suc" data-mega-panel="trang-suc" role="tabpanel" aria-labelledby="nav-item-trang-suc">
            <div class="mega-menu__grid mega-menu__grid--4col">
                {{-- Col 1: Khám phá --}}
                <div class="mega-menu__col">
                    <span class="mega-menu__heading">Khám phá</span>
                    <ul class="mega-menu__list">
                        <li><a href="{{ route('products.index') }}" class="mega-menu__link fw-semibold">Tất cả sản phẩm</a></li>
                        <li><a href="{{ route('products.index', ['sort' => 'newest']) }}" class="mega-menu__link"><span class="badge-dot me-1"></span> Hàng mới về</a></li>
                        <li><a href="{{ route('products.index', ['sort' => 'price_desc']) }}" class="mega-menu__link">Bán chạy nhất</a></li>
                        <li><a href="{{ route('products.index', ['material' => 'Bạc 925']) }}" class="mega-menu__link">Bạc S925 Tuyển chọn</a></li>
                    </ul>
                </div>

                {{-- Col 2: Loại trang sức (Real DB Categories) --}}
                <div class="mega-menu__col">
                    <span class="mega-menu__heading">Loại trang sức</span>
                    <ul class="mega-menu__list">
                        @foreach($navData['categories'] ?? [] as $cat)
                            <li>
                                <a href="{{ $cat['url'] }}" class="mega-menu__link d-flex justify-content-between align-items-center">
                                    <span>{{ $cat['name'] }}</span>
                                    @if(!empty($cat['count']))
                                        <small class="text-muted mega-menu__count">{{ $cat['count'] }}</small>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Col 3: Gợi ý nổi bật (2 Real Products) --}}
                <div class="mega-menu__col">
                    <span class="mega-menu__heading">Sản phẩm nổi bật</span>
                    <div class="mega-menu__products">
                        @foreach($navData['featuredProducts'] ?? [] as $fp)
                            <a href="{{ $fp['url'] }}" class="mega-product-card">
                                <div class="mega-product-card__thumb">
                                    @if($fp['image_url'])
                                        <img src="{{ $fp['image_url'] }}" alt="{{ $fp['name'] }}" loading="lazy" width="64" height="64">
                                    @else
                                        <div class="mega-product-card__placeholder"><i class="bi bi-gem"></i></div>
                                    @endif
                                </div>
                                <div class="mega-product-card__info">
                                    <span class="mega-product-card__cat">{{ $fp['category_name'] }}</span>
                                    <h4 class="mega-product-card__title">{{ $fp['name'] }}</h4>
                                    <span class="mega-product-card__price">{{ $fp['price_display'] }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Col 4: Editorial Showcase --}}
                <div class="mega-menu__col mega-menu__col--editorial">
                    <div class="mega-editorial-card">
                        <div class="mega-editorial-card__media">
                            <img src="{{ asset('media-previews/hero-2.webp') }}" alt="Ánh Trăng Tuyển Chọn" loading="lazy">
                        </div>
                        <div class="mega-editorial-card__body">
                            <span class="mega-editorial-card__eyebrow">✦ LUNARA ATELIER ✦</span>
                            <h3 class="mega-editorial-card__title">Ánh Trăng Tuyển Chọn</h3>
                            <p class="mega-editorial-card__desc">Chuẩn độ tinh khiết S925, chạm khắc tinh xảo từng giác cắt ánh sáng.</p>
                            <a href="{{ route('products.index') }}" class="mega-editorial-card__action">Khám phá tác phẩm →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel 2: BỘ SƯU TẬP --}}
        <div class="mega-menu__panel" id="mega-panel-bo-suu-tap" data-mega-panel="bo-suu-tap" role="tabpanel" aria-labelledby="nav-item-bo-suu-tap" hidden>
            <div class="mega-menu__grid mega-menu__grid--3col">
                {{-- Col 1: Cảm hứng --}}
                <div class="mega-menu__col">
                    <span class="mega-menu__heading">Bộ sưu tập độc quyền</span>
                    <h3 class="h4 font-serif text-dark mb-2">Celestial Whispers</h3>
                    <p class="text-muted small mb-4" style="line-height: 1.7;">
                        Lấy cảm hứng từ sự huyền bí của dải ngân hà và ánh trăng thanh khiết. Mỗi thiết kế là một tác phẩm kim hoàn tôn vinh vẻ đẹp tự tại của người phụ nữ.
                    </p>
                    <a href="{{ route('products.category', 'bo-trang-suc') }}" class="lunara-button lunara-button--dark py-2 px-3 small">
                        Xem tất cả bộ sưu tập →
                    </a>
                </div>

                {{-- Col 2: Các bộ phối tiêu biểu (Real DB Collections) --}}
                <div class="mega-menu__col">
                    <span class="mega-menu__heading">Các bộ phối tiêu biểu</span>
                    <div class="mega-menu__products">
                        @forelse($navData['collections'] ?? [] as $col)
                            <a href="{{ $col['url'] }}" class="mega-product-card">
                                <div class="mega-product-card__thumb">
                                    @if($col['image_url'])
                                        <img src="{{ $col['image_url'] }}" alt="{{ $col['name'] }}" loading="lazy" width="64" height="64">
                                    @else
                                        <div class="mega-product-card__placeholder"><i class="bi bi-stars"></i></div>
                                    @endif
                                </div>
                                <div class="mega-product-card__info">
                                    <h4 class="mega-product-card__title">{{ $col['name'] }}</h4>
                                    <span class="mega-product-card__price">{{ $col['price_display'] }}</span>
                                    <small class="text-muted d-block text-truncate" style="max-width: 220px;">{{ $col['summary'] }}</small>
                                </div>
                            </a>
                        @empty
                            <p class="text-muted small">Đang cập nhật các bộ sưu tập mới.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Col 3: Editorial Visual --}}
                <div class="mega-menu__col mega-menu__col--editorial">
                    <div class="mega-editorial-card">
                        <div class="mega-editorial-card__media">
                            <img src="{{ asset('media-previews/hero-3.webp') }}" alt="Bộ sưu tập Lunara" loading="lazy">
                        </div>
                        <div class="mega-editorial-card__body">
                            <span class="mega-editorial-card__eyebrow">✦ BỘ PHỐI TINH TÚ ✦</span>
                            <h3 class="mega-editorial-card__title">The Celestial Line</h3>
                            <a href="{{ route('products.category', 'bo-trang-suc') }}" class="mega-editorial-card__action">Trải nghiệm bộ sưu tập →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel 3: QUÀ TẶNG --}}
        <div class="mega-menu__panel" id="mega-panel-qua-tang" data-mega-panel="qua-tang" role="tabpanel" aria-labelledby="nav-item-qua-tang" hidden>
            <div class="mega-menu__grid mega-menu__grid--3col">
                {{-- Col 1: Gợi ý tặng quà --}}
                <div class="mega-menu__col">
                    <span class="mega-menu__heading">Gợi ý quà tặng</span>
                    <ul class="mega-menu__list">
                        <li><a href="{{ route('products.category', 'set-qua-tang') }}" class="mega-menu__link fw-semibold">Tất cả set quà tặng</a></li>
                        <li><a href="{{ route('products.category', 'set-qua-tang') }}" class="mega-menu__link">Quà sinh nhật & Dịp kỷ niệm</a></li>
                        <li><a href="{{ route('products.category', 'nhan') }}" class="mega-menu__link">Nhẫn trao gửi yêu thương</a></li>
                    </ul>
                    <div class="p-3 bg-light rounded-2 mt-3 border">
                        <small class="text-dark fw-semibold d-block mb-1">✦ Đặc quyền quà tặng Lunara</small>
                        <small class="text-muted d-block" style="line-height: 1.5;">Tặng kèm hộp nhung Lunara sang trọng, túi xách cao cấp và thiệp viết tay theo yêu cầu.</small>
                    </div>
                </div>

                {{-- Col 2: Set quà nổi bật (Real DB Gifts) --}}
                <div class="mega-menu__col">
                    <span class="mega-menu__heading">Set quà tuyển chọn</span>
                    <div class="mega-menu__products">
                        @forelse($navData['giftSets'] ?? [] as $gift)
                            <a href="{{ $gift['url'] }}" class="mega-product-card">
                                <div class="mega-product-card__thumb">
                                    @if($gift['image_url'])
                                        <img src="{{ $gift['image_url'] }}" alt="{{ $gift['name'] }}" loading="lazy" width="64" height="64">
                                    @else
                                        <div class="mega-product-card__placeholder"><i class="bi bi-gift"></i></div>
                                    @endif
                                </div>
                                <div class="mega-product-card__info">
                                    <h4 class="mega-product-card__title">{{ $gift['name'] }}</h4>
                                    <span class="mega-product-card__price">{{ $gift['price_display'] }}</span>
                                    <small class="text-muted d-block text-truncate" style="max-width: 220px;">{{ $gift['summary'] }}</small>
                                </div>
                            </a>
                        @empty
                            <p class="text-muted small">Đang cập nhật các set quà tặng.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Col 3: Editorial Gift Visual --}}
                <div class="mega-menu__col mega-menu__col--editorial">
                    <div class="mega-editorial-card">
                        <div class="mega-editorial-card__media">
                            <img src="{{ asset('media-previews/hero-1.webp') }}" alt="Hộp Quà Ánh Trăng" loading="lazy">
                        </div>
                        <div class="mega-editorial-card__body">
                            <span class="mega-editorial-card__eyebrow">✦ HỘP QUÀ & THIỆP KÈM ✦</span>
                            <h3 class="mega-editorial-card__title">Gửi Trao Yêu Thương</h3>
                            <a href="{{ route('products.category', 'set-qua-tang') }}" class="mega-editorial-card__action">Chọn quà tặng ngay →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel 4: BLOG / NHẬT KÝ LUNARA --}}
        <div class="mega-menu__panel" id="mega-panel-blog" data-mega-panel="blog" role="tabpanel" aria-labelledby="nav-item-blog" hidden>
            <div class="mega-menu__grid mega-menu__grid--compact">
                {{-- Col 1: Chuyên mục cẩm nang --}}
                <div class="mega-menu__col">
                    <span class="mega-menu__heading">Chuyên mục cẩm nang</span>
                    <ul class="mega-menu__list">
                        <li><a href="{{ route('blog.index') }}" class="mega-menu__link fw-semibold">Tất cả bài viết</a></li>
                        @foreach($navData['blogCategories'] ?? [] as $bcat)
                            <li>
                                <a href="{{ $bcat['url'] }}" class="mega-menu__link d-flex justify-content-between align-items-center">
                                    <span>{{ $bcat['name'] }}</span>
                                    @if(!empty($bcat['count']))
                                        <small class="text-muted mega-menu__count">{{ $bcat['count'] }}</small>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Col 2: Cảm hứng bài viết --}}
                <div class="mega-menu__col">
                    <span class="mega-menu__heading">Nhật ký trang sức</span>
                    <p class="text-muted small mb-3" style="line-height: 1.6;">
                        Nơi chia sẻ kiến thức kim hoàn, cách nhận biết độ tinh khiết bạc S925, bí quyết bảo quản và phong cách phối trang sức đón đầu xu hướng.
                    </p>
                    <a href="{{ route('blog.index') }}" class="mega-menu__link fw-semibold text-dark">
                        Xem bài viết mới nhất →
                    </a>
                </div>

                {{-- Col 3: Editorial Visual --}}
                <div class="mega-menu__col mega-menu__col--editorial">
                    <div class="mega-editorial-card">
                        <div class="mega-editorial-card__media">
                            <img src="{{ asset('media-previews/hero-2.webp') }}" alt="Lunara Journal" loading="lazy">
                        </div>
                        <div class="mega-editorial-card__body">
                            <span class="mega-editorial-card__eyebrow">✦ LUNARA JOURNAL ✦</span>
                            <h3 class="mega-editorial-card__title">Cảm Hứng &amp; Phong Cách</h3>
                            <a href="{{ route('blog.index') }}" class="mega-editorial-card__action">Khám phá cẩm nang →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Panel 5: GIỚI THIỆU --}}
        <div class="mega-menu__panel" id="mega-panel-gioi-thieu" data-mega-panel="gioi-thieu" role="tabpanel" aria-labelledby="nav-item-gioi-thieu" hidden>
            <div class="mega-menu__grid mega-menu__grid--compact">
                <div class="mega-menu__col">
                    <span class="mega-menu__heading">Thương hiệu</span>
                    <ul class="mega-menu__list">
                        <li><a href="{{ route('home') }}#story" class="mega-menu__link fw-semibold">Câu chuyện Lunara</a></li>
                        <li><a href="{{ route('contact') }}" class="mega-menu__link">Liên hệ & Showroom</a></li>
                    </ul>
                </div>
                <div class="mega-menu__col">
                    <span class="mega-menu__heading">Chăm sóc khách hàng</span>
                    <ul class="mega-menu__list">
                        <li><a href="{{ route('support.faq') }}" class="mega-menu__link">Trung tâm hỗ trợ & FAQ</a></li>
                        <li><a href="{{ route('support.faq', ['category' => 'Đổi trả']) }}" class="mega-menu__link">Chính sách đổi trả & bảo hành</a></li>
                        <li><a href="tel:0971124922" class="mega-menu__link text-dark fw-semibold"><i class="bi bi-telephone me-1 text-muted"></i> Hotline: 0971 124 922</a></li>
                    </ul>
                </div>
                <div class="mega-menu__col mega-menu__col--editorial">
                    <div class="p-4 bg-light rounded-2 border">
                        <span class="d-block small text-uppercase tracking-widest text-muted mb-1">✦ SHINE WITH YOUR MOONLIGHT ✦</span>
                        <h4 class="h5 font-serif text-dark mb-2">Trang Sức Bạc 925 Tuyển Chọn</h4>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">
                            Lunara mang đến trải nghiệm trang sức tinh tế, chuẩn xác về tuổi bạc và sự chu đáo trong từng điểm chạm dịch vụ.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


