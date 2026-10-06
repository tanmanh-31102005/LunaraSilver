<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <x-seo.meta 
        :title="$__env->yieldContent('title') ?: 'Lunara Silver | Trang sức bạc tinh tế'"
        :description="$__env->yieldContent('meta_description') ?: 'Trang sức bạc 925 cao cấp Lunara Silver lấy cảm hứng từ vẻ đẹp huyền diệu của mặt trăng và các vì sao. Tinh tế, thanh lịch và tỏa sáng theo cách của riêng bạn.'"
        :canonical="$__env->yieldContent('canonical')"
        :robots="$__env->yieldContent('robots')"
        :ogType="$__env->yieldContent('og_type')"
        :ogImage="$__env->yieldContent('og_image')"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    @stack('schema')
</head>
<body>
    <a class="skip-link" href="#main-content">Chuyển đến nội dung</a>
    <x-announcement-bar :message="config('lunara.announcement')" />

    <header class="site-header">
        <div class="site-header__inner lunara-container">
            <button class="icon-button site-header__menu d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavigation" aria-controls="mobileNavigation" aria-label="Mở menu">
                <i class="bi bi-list" aria-hidden="true"></i>
            </button>
            <a class="site-header__logo" href="{{ route('home') }}" aria-label="Lunara Silver — Trang chủ">
                <img src="{{ route('media.show', ['path' => 'lunara-logo-light.svg']) }}" alt="Lunara Silver" width="180" height="75">
            </a>
            <nav class="site-header__nav d-none d-lg-flex" aria-label="Điều hướng chính" id="mainNavigation">
                <a href="{{ route('products.index') }}"
                   class="nav-link-mega {{ request()->routeIs('products.*') && !in_array(request()->route('category'), ['bo-trang-suc', 'set-qua-tang']) ? 'active' : '' }}"
                   data-mega-trigger="trang-suc"
                   id="nav-item-trang-suc"
                   aria-haspopup="true"
                   aria-expanded="false"
                   aria-controls="mega-panel-trang-suc">
                    Trang sức
                </a>
                <a href="{{ route('products.category', 'bo-trang-suc') }}"
                   class="nav-link-mega {{ request()->routeIs('products.category') && request()->route('category') === 'bo-trang-suc' ? 'active' : '' }}"
                   data-mega-trigger="bo-suu-tap"
                   id="nav-item-bo-suu-tap"
                   aria-haspopup="true"
                   aria-expanded="false"
                   aria-controls="mega-panel-bo-suu-tap">
                    Bộ sưu tập
                </a>
                <a href="{{ route('products.category', 'set-qua-tang') }}"
                   class="nav-link-mega {{ request()->routeIs('products.category') && request()->route('category') === 'set-qua-tang' ? 'active' : '' }}"
                   data-mega-trigger="qua-tang"
                   id="nav-item-qua-tang"
                   aria-haspopup="true"
                   aria-expanded="false"
                   aria-controls="mega-panel-qua-tang">
                    Quà tặng
                </a>
                <a href="{{ route('blog.index') }}"
                   class="nav-link-mega {{ request()->routeIs('blog.*') ? 'active' : '' }}"
                   data-mega-trigger="blog"
                   id="nav-item-blog"
                   aria-haspopup="true"
                   aria-expanded="false"
                   aria-controls="mega-panel-blog">
                    Blog
                </a>
                <a href="{{ route('about') }}"
                   class="nav-link-mega {{ request()->routeIs('about') ? 'active' : '' }}"
                   data-mega-trigger="gioi-thieu"
                   id="nav-item-gioi-thieu"
                   aria-haspopup="true"
                   aria-expanded="false"
                   aria-controls="mega-panel-gioi-thieu">
                    Giới thiệu
                </a>
            </nav>
            <div class="site-header__actions">
                <button class="icon-button" type="button" data-search-open aria-label="Tìm kiếm"><i class="bi bi-search" aria-hidden="true"></i></button>
                <a class="icon-button position-relative wishlist-trigger d-none d-lg-inline-flex" href="{{ route('account.wishlist') }}" aria-label="Danh sách yêu thích" title="Sản phẩm yêu thích">
                    <i class="bi bi-heart" aria-hidden="true"></i>
                    <span class="wishlist-count {{ ($headerWishlistCount ?? 0) > 0 ? '' : 'd-none' }}" data-wishlist-count>{{ $headerWishlistCount ?? 0 }}</span>
                </a>
                @auth
                    <a class="icon-button d-none d-lg-inline-flex" href="{{ route('account.dashboard') }}" aria-label="Tài khoản của tôi" title="Tài khoản của tôi"><i class="bi bi-person-check" aria-hidden="true"></i></a>
                    <form method="post" action="{{ route('logout') }}" class="d-none d-lg-block">@csrf<button class="icon-button" type="submit" aria-label="Đăng xuất" title="Đăng xuất"><i class="bi bi-box-arrow-right" aria-hidden="true"></i></button></form>
                @else
                    <a class="icon-button d-none d-lg-inline-flex" href="{{ route('login') }}" aria-label="Đăng nhập" title="Đăng nhập"><i class="bi bi-person" aria-hidden="true"></i></a>
                @endauth
                <button class="icon-button cart-trigger" type="button" data-bs-toggle="offcanvas" data-bs-target="#miniCart" aria-controls="miniCart" aria-label="Mở giỏ hàng"><i class="bi bi-bag" aria-hidden="true"></i><span class="cart-count" data-cart-count>{{ $headerCart['cart_count'] }}</span></button>
            </div>
        </div>
        <x-mega-menu :navData="$navData ?? []" />
    </header>
    <div class="mega-menu-backdrop" id="megaMenuBackdrop" hidden></div>

    <div class="offcanvas offcanvas-start mobile-navigation" tabindex="-1" id="mobileNavigation" aria-labelledby="mobileNavigationTitle">
        <div class="offcanvas-header border-bottom">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ route('media.show', ['path' => 'lunara-logo-dark.svg']) }}" alt="Lunara Silver" width="130" height="42" style="height: 36px; width: auto;">
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Đóng menu"></button>
        </div>
        <nav class="offcanvas-body p-3" aria-label="Điều hướng di động">
            {{-- SEO Brand Assurance Header --}}
            <div class="mobile-nav-seo-header mb-3 pb-3 border-bottom d-flex align-items-center justify-content-between">
                <div>
                    <span class="d-block text-dark fw-bold" style="font-size: 0.88rem; letter-spacing: 0.02em;">Trang Sức Bạc 925 Cao Cấp</span>
                    <span class="d-block text-muted small" style="font-size: 0.74rem;">Bảo hành &amp; đánh sáng trọn đời</span>
                </div>
                <span class="badge bg-dark text-white rounded-pill px-2 py-1" style="font-size: 0.65rem; letter-spacing: 0.06em; flex-shrink: 0; width: auto !important; min-height: 0 !important;">TOP 1</span>
            </div>

            {{-- Categories Section (Standardized SEO) --}}
            <div class="mobile-nav-group mb-2">
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.08em; font-size: 0.78rem;">DANH MỤC TRANG SỨC BẠC</span>
                    <button class="btn btn-sm btn-link text-muted p-0 text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileTrangSucCollapse" aria-expanded="true" aria-controls="mobileTrangSucCollapse">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse show mt-2" id="mobileTrangSucCollapse">
                    <a href="{{ route('products.index') }}" class="mobile-nav-cat-item d-flex align-items-center justify-content-between py-2 px-2 rounded text-decoration-none {{ request()->routeIs('products.index') && !request()->route('category') ? 'bg-light fw-bold text-dark' : 'text-dark' }}">
                        <span class="small fw-medium">Tất cả sản phẩm</span>
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill" style="font-size: 0.7rem; width: auto !important; min-height: 0 !important;">Khám phá</span>
                    </a>
                    @foreach($navData['categories'] ?? [] as $mCat)
                        <a href="{{ $mCat['url'] }}" class="mobile-nav-cat-item d-flex align-items-center justify-content-between py-2 px-2 rounded text-decoration-none {{ request()->is('danh-muc/' . $mCat['slug']) ? 'bg-light fw-bold text-dark' : 'text-dark' }}">
                            <span class="small fw-medium">{{ $mCat['display_name'] ?? $mCat['name'] }}</span>
                            <span class="badge bg-light text-muted border rounded-pill" style="font-size: 0.7rem; width: auto !important; min-height: 0 !important;">{{ $mCat['count'] }} sp</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('products.category', 'bo-trang-suc') }}" class="d-flex align-items-center justify-content-between py-2 border-bottom text-dark fw-semibold text-decoration-none small">
                <span>BỘ SƯU TẬP TRANG SỨC BẠC</span>
                <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
            </a>
            <a href="{{ route('products.category', 'set-qua-tang') }}" class="d-flex align-items-center justify-content-between py-2 border-bottom text-dark fw-semibold text-decoration-none small">
                <span>SET QUÀ TẶNG BẠC CAO CẤP</span>
                <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
            </a>
            <a href="{{ route('blog.index') }}" class="d-flex align-items-center justify-content-between py-2 border-bottom text-dark fw-semibold text-decoration-none small">
                <span>NHẬT KÝ LUNARA (BLOG)</span>
                <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
            </a>
            <a href="{{ route('about') }}" class="d-flex align-items-center justify-content-between py-2 border-bottom text-dark fw-semibold text-decoration-none small {{ request()->routeIs('about') ? 'active' : '' }}">
                <span>GIỚI THIỆU THƯƠNG HIỆU</span>
                <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
            </a>

            {{-- Popular SEO Keywords in Mobile Menu --}}
            <div class="mobile-nav-keywords my-3 pt-2">
                <span class="d-block text-muted text-uppercase mb-2 fw-semibold" style="font-size: 0.68rem; letter-spacing: 0.08em;">Từ khóa tìm kiếm phổ biến:</span>
                <div class="d-flex flex-wrap gap-1">
                    <a href="{{ route('products.index', ['q' => 'trang sức bạc top 1']) }}" class="badge bg-light text-dark border text-decoration-none fw-normal py-1 px-2" style="font-size: 0.72rem; width: auto !important; min-height: 0 !important;">Trang sức bạc top 1</a>
                    <a href="{{ route('products.category', 'day-chuyen') }}" class="badge bg-light text-dark border text-decoration-none fw-normal py-1 px-2" style="font-size: 0.72rem; width: auto !important; min-height: 0 !important;">Dây chuyền bạc nữ</a>
                    <a href="{{ route('products.category', 'nhan') }}" class="badge bg-light text-dark border text-decoration-none fw-normal py-1 px-2" style="font-size: 0.72rem; width: auto !important; min-height: 0 !important;">Nhẫn bạc 925</a>
                    <a href="{{ route('products.category', 'vong-tay') }}" class="badge bg-light text-dark border text-decoration-none fw-normal py-1 px-2" style="font-size: 0.72rem; width: auto !important; min-height: 0 !important;">Lắc tay bạc</a>
                    <a href="{{ route('products.index', ['q' => 'nhẫn bạc đôi']) }}" class="badge bg-light text-dark border text-decoration-none fw-normal py-1 px-2" style="font-size: 0.72rem; width: auto !important; min-height: 0 !important;">Nhẫn bạc đôi</a>
                </div>
            </div>

            <div class="mobile-navigation__divider my-3"></div>
            @auth
                <div class="mobile-navigation__user-info mb-2 px-1">
                    <span class="text-muted small d-block">Đăng nhập bởi:</span>
                    <strong class="text-dark">{{ auth()->user()->name }}</strong>
                </div>
                <a href="{{ route('account.dashboard') }}" class="d-flex align-items-center py-2 text-decoration-none text-dark small"><i class="bi bi-person me-2"></i>Tài khoản của tôi</a>
                <a href="{{ route('account.orders.index') }}" class="d-flex align-items-center py-2 text-decoration-none text-dark small"><i class="bi bi-box-seam me-2"></i>Đơn mua của tôi</a>
                <form method="post" action="{{ route('logout') }}" class="mt-2">@csrf<button type="submit" class="text-danger w-100 text-start bg-transparent border-0 p-0 small"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button></form>
            @else
                <a href="{{ route('login') }}" class="d-flex align-items-center py-2 text-decoration-none text-dark small"><i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập</a>
                <a href="{{ route('register') }}" class="d-flex align-items-center py-2 text-decoration-none text-dark small"><i class="bi bi-person-plus me-2"></i>Đăng ký tài khoản</a>
            @endauth
            <a href="{{ route('account.wishlist') }}" class="d-flex align-items-center justify-content-between py-2 text-decoration-none text-dark small mt-1">
                <span><i class="bi bi-heart me-2"></i>Yêu thích</span>
                <span class="badge bg-dark text-white rounded-pill px-2 py-1" data-wishlist-count style="font-size: 0.7rem; width: auto !important; min-height: 0 !important;">{{ $headerWishlistCount ?? 0 }}</span>
            </a>
        </nav>
    </div>

    <x-cart-drawer :headerCart="$headerCart" />

    <x-search-overlay />

    @if(session('cart_warning'))
        <div class="lunara-container alert alert-warning my-3" role="alert">{{ session('cart_warning') }} <a href="{{ route('cart.index') }}">Xem giỏ hàng</a></div>
    @endif

    <main id="main-content" class="@yield('main_class', 'page-main')">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="lunara-container site-footer__grid">
            <div class="site-footer__brand">
                <a href="{{ route('home') }}" aria-label="Lunara Silver — Trang chủ">
                    <img src="{{ route('media.show', ['path' => 'lunara-logo-dark.svg']) }}" alt="Lunara Silver" width="185" height="78">
                </a>
                <p class="site-footer__slogan">Shine with your own moonlight.</p>
                <p class="site-footer__about">Trang sức bạc 925 cao cấp lấy cảm hứng từ vẻ đẹp huyền diệu của mặt trăng và các vì sao. Tinh tế, thanh lịch và tỏa sáng theo cách của riêng bạn.</p>
                <div class="site-footer__contact">
                    <div class="site-footer__contact-item">
                        <i class="bi bi-geo-alt site-footer__contact-icon"></i>
                        <div class="site-footer__contact-text">
                            <span>140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Ho Chi Minh City</span>
                        </div>
                    </div>
                    <div class="site-footer__contact-item">
                        <i class="bi bi-telephone site-footer__contact-icon"></i>
                        <div class="site-footer__contact-text">
                            <span class="site-footer__contact-label">Hotline CSKH / Đặt hàng: </span>
                            <a href="tel:0971124922">0971 124 922</a>
                        </div>
                    </div>
                    <div class="site-footer__contact-item">
                        <i class="bi bi-envelope site-footer__contact-icon"></i>
                        <div class="site-footer__contact-text">
                            <span class="site-footer__contact-label">Email: </span>
                            <a href="mailto:lunaraslivertrangsuc@gmail.com">lunaraslivertrangsuc@gmail.com</a>
                        </div>
                    </div>
                    <div class="site-footer__contact-item site-footer__contact-hours">
                        <i class="bi bi-clock site-footer__contact-icon"></i>
                        <div class="site-footer__contact-text">
                            <span>Thứ Hai — Thứ Bảy: 08:30 - 20:30 (Chủ Nhật: 09:00 - 18:00)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h2>Bộ sưu tập Bạc 925</h2>
                <a href="{{ route('products.category', 'day-chuyen') }}">Dây chuyền bạc nữ & nam</a>
                <a href="{{ route('products.category', 'nhan') }}">Nhẫn bạc 925 & Nhẫn đôi</a>
                <a href="{{ route('products.category', 'vong-tay') }}">Vòng tay & Lắc tay bạc</a>
                <a href="{{ route('products.category', 'bo-trang-suc') }}">Bộ trang sức bạc 925</a>
                <a href="{{ route('products.category', 'set-qua-tang') }}">Set quà tặng trang sức bạc</a>
            </div>
            <div>
                <h2>Khách hàng</h2>
                <a href="{{ route('account.dashboard') }}">Tài khoản của tôi</a>
                <a href="{{ route('account.orders.index') }}">Lịch sử đơn hàng</a>
                <a href="{{ route('account.addresses.index') }}">Sổ địa chỉ</a>
                <a href="{{ route('cart.index') }}">Giỏ hàng</a>
                <a href="{{ route('support.faq') }}">Trung tâm hỗ trợ & FAQ</a>
                <a href="{{ route('support.faq', ['category' => 'Đổi trả']) }}">Chính sách đổi trả & bảo hành</a>
                <a href="{{ route('contact') }}">Liên hệ chúng tôi</a>
                <a href="{{ route('blog.index') }}">Nhật ký Lunara (Blog)</a>
                <a href="{{ route('about') }}">Câu chuyện Lunara</a>
            </div>
            <div class="site-footer__pledges">
                <h2>Cam kết chất lượng</h2>
                <div class="footer-pledge">
                    <strong>✦ Bạc 925 Tuyển Chọn</strong>
                    <p>Chuẩn độ tinh khiết, sáng bóng bền lâu và an toàn cho da.</p>
                </div>
                <div class="footer-pledge">
                    <strong>✦ Hộp Quà & Thiệp Kèm</strong>
                    <p>Hộp nhung và túi Lunara sang trọng nâng niu từng món quà.</p>
                </div>
                <div class="footer-pledge">
                    <strong>✦ Giao Hàng & Đồng Kiểm</strong>
                    <p>Kiểm tra hàng tận tay trước khi thanh toán COD toàn quốc.</p>
                </div>
            </div>
        </div>

        {{-- SEO Discovery Keywords Bar --}}
        <div class="lunara-container pt-3 pb-2 border-top border-secondary border-opacity-10">
            <div class="d-flex flex-wrap align-items-center gap-2 small text-muted" style="font-size: 0.78rem;">
                <span class="fw-semibold text-dark text-uppercase me-1" style="letter-spacing: 0.5px;">Xu hướng tìm kiếm:</span>
                <a href="{{ route('products.index', ['q' => 'trang sức bạc top 1']) }}" class="text-secondary text-decoration-none">Trang sức bạc top 1</a> <span class="opacity-50">•</span>
                <a href="{{ route('products.category', 'day-chuyen') }}" class="text-secondary text-decoration-none">Dây chuyền bạc nữ</a> <span class="opacity-50">•</span>
                <a href="{{ route('products.category', 'nhan') }}" class="text-secondary text-decoration-none">Nhẫn bạc 925</a> <span class="opacity-50">•</span>
                <a href="{{ route('products.index', ['q' => 'nhẫn bạc đôi']) }}" class="text-secondary text-decoration-none">Nhẫn bạc đôi nam nữ</a> <span class="opacity-50">•</span>
                <a href="{{ route('products.category', 'vong-tay') }}" class="text-secondary text-decoration-none">Vòng tay bạc nữ đẹp</a> <span class="opacity-50">•</span>
                <a href="{{ route('products.category', 'vong-tay') }}" class="text-secondary text-decoration-none">Lắc tay bạc</a> <span class="opacity-50">•</span>
                <a href="{{ route('products.index', ['q' => 'lắc chân bạc nữ']) }}" class="text-secondary text-decoration-none">Lắc chân bạc nữ</a> <span class="opacity-50">•</span>
                <a href="{{ route('products.index', ['q' => 'nhẫn cặp bạc']) }}" class="text-secondary text-decoration-none">Nhẫn cặp bạc</a> <span class="opacity-50">•</span>
                <a href="{{ route('products.index', ['q' => 'dây chuyền bạc nam']) }}" class="text-secondary text-decoration-none">Dây chuyền bạc nam</a> <span class="opacity-50">•</span>
                <a href="{{ route('products.category', 'bo-trang-suc') }}" class="text-secondary text-decoration-none">Bộ trang sức bạc nữ</a> <span class="opacity-50">•</span>
                <a href="{{ route('products.category', 'set-qua-tang') }}" class="text-secondary text-decoration-none">Set quà tặng bạc 925</a>
            </div>
        </div>

        <div class="lunara-container site-footer__bottom">
            <span>© {{ date('Y') }} Lunara Silver · All rights reserved.</span>
            <span>Shine with your own moonlight</span>
        </div>
    </footer>
    <x-toast-container />

    {{-- Mobile App Sticky Bottom Bar --}}
    <nav class="mobile-bottom-bar d-lg-none" aria-label="Thanh điều hướng di động">
        <a href="{{ route('home') }}" class="mobile-bottom-bar__item {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="bi bi-house{{ request()->routeIs('home') ? '-door-fill' : '-door' }}"></i>
            <span>Trang chủ</span>
        </a>
        <button type="button" class="mobile-bottom-bar__item" data-bs-toggle="offcanvas" data-bs-target="#mobileNavigation" aria-controls="mobileNavigation">
            <i class="bi bi-grid-fill"></i>
            <span>Danh mục</span>
        </button>
        <a href="{{ route('account.wishlist') }}" class="mobile-bottom-bar__item {{ request()->routeIs('account.wishlist') ? 'active' : '' }}">
            <div class="position-relative d-inline-block">
                <i class="bi bi-heart{{ request()->routeIs('account.wishlist') ? '-fill text-danger' : '' }}"></i>
                <span class="mobile-bottom-bar__badge {{ ($headerWishlistCount ?? 0) > 0 ? '' : 'd-none' }}" data-wishlist-count>{{ $headerWishlistCount ?? 0 }}</span>
            </div>
            <span>Yêu thích</span>
        </a>
        <button type="button" class="mobile-bottom-bar__item cart-trigger" data-bs-toggle="offcanvas" data-bs-target="#miniCart" aria-controls="miniCart">
            <div class="position-relative d-inline-block">
                <i class="bi bi-bag"></i>
                <span class="mobile-bottom-bar__badge" data-cart-count>{{ $headerCart['cart_count'] ?? 0 }}</span>
            </div>
            <span>Giỏ hàng</span>
        </button>
        <a href="{{ auth()->check() ? route('account.dashboard') : route('login') }}" class="mobile-bottom-bar__item {{ request()->routeIs('account.*') || request()->routeIs('login') ? 'active' : '' }}">
            <i class="bi bi-person{{ auth()->check() ? '-check-fill' : '' }}"></i>
            <span>{{ auth()->check() ? 'Tài khoản' : 'Đăng nhập' }}</span>
        </a>
    </nav>

    @include('partials.support_widget')
    @stack('scripts')
</body>
</html>
