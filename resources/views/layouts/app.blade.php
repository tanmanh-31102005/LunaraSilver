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
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            <nav class="site-header__nav d-none d-lg-flex" aria-label="Điều hướng chính">
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') && !request()->route('category') ? 'active' : '' }}">Sản phẩm</a>
                <a href="{{ route('products.category', 'day-chuyen') }}" class="{{ request()->routeIs('products.category') && request()->route('category') === 'day-chuyen' ? 'active' : '' }}">Dây chuyền</a>
                <a href="{{ route('products.category', 'nhan') }}" class="{{ request()->routeIs('products.category') && request()->route('category') === 'nhan' ? 'active' : '' }}">Nhẫn</a>
                <a href="{{ route('products.category', 'vong-tay') }}" class="{{ request()->routeIs('products.category') && request()->route('category') === 'vong-tay' ? 'active' : '' }}">Vòng tay</a>
                <a href="{{ route('products.category', 'bo-trang-suc') }}" class="{{ request()->routeIs('products.category') && request()->route('category') === 'bo-trang-suc' ? 'active' : '' }}">Bộ sưu tập</a>
                <a href="{{ route('products.category', 'set-qua-tang') }}" class="{{ request()->routeIs('products.category') && request()->route('category') === 'set-qua-tang' ? 'active' : '' }}">Quà tặng</a>
                <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
                <a href="{{ route('home') }}#story">Giới thiệu</a>
            </nav>
            <div class="site-header__actions">
                <button class="icon-button" type="button" data-bs-toggle="modal" data-bs-target="#siteSearch" aria-label="Tìm kiếm"><i class="bi bi-search" aria-hidden="true"></i></button>
                <button class="icon-button d-none d-lg-inline-flex" type="button" disabled aria-label="Danh sách yêu thích chưa khả dụng" title="Danh sách yêu thích sẽ được bổ sung"><i class="bi bi-heart" aria-hidden="true"></i></button>
                @auth
                    <a class="icon-button d-none d-lg-inline-flex" href="{{ route('account.dashboard') }}" aria-label="Tài khoản của tôi" title="Tài khoản của tôi"><i class="bi bi-person-check" aria-hidden="true"></i></a>
                    <form method="post" action="{{ route('logout') }}" class="d-none d-lg-block">@csrf<button class="icon-button" type="submit" aria-label="Đăng xuất" title="Đăng xuất"><i class="bi bi-box-arrow-right" aria-hidden="true"></i></button></form>
                @else
                    <a class="icon-button d-none d-lg-inline-flex" href="{{ route('login') }}" aria-label="Đăng nhập" title="Đăng nhập"><i class="bi bi-person" aria-hidden="true"></i></a>
                @endauth
                <button class="icon-button cart-trigger" type="button" data-bs-toggle="offcanvas" data-bs-target="#miniCart" aria-controls="miniCart" aria-label="Mở giỏ hàng"><i class="bi bi-bag" aria-hidden="true"></i><span class="cart-count" data-cart-count>{{ $headerCart['cart_count'] }}</span></button>
            </div>
        </div>
    </header>

    <div class="offcanvas offcanvas-start mobile-navigation" tabindex="-1" id="mobileNavigation" aria-labelledby="mobileNavigationTitle">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title h4 mb-0" id="mobileNavigationTitle">Lunara Silver</h2>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Đóng menu"></button>
        </div>
        <nav class="offcanvas-body" aria-label="Điều hướng di động">
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') && !request()->route('category') ? 'active' : '' }}">Sản phẩm</a>
            <a href="{{ route('products.category', 'day-chuyen') }}" class="{{ request()->routeIs('products.category') && request()->route('category') === 'day-chuyen' ? 'active' : '' }}">Dây chuyền</a>
            <a href="{{ route('products.category', 'nhan') }}" class="{{ request()->routeIs('products.category') && request()->route('category') === 'nhan' ? 'active' : '' }}">Nhẫn</a>
            <a href="{{ route('products.category', 'vong-tay') }}" class="{{ request()->routeIs('products.category') && request()->route('category') === 'vong-tay' ? 'active' : '' }}">Vòng tay</a>
            <a href="{{ route('products.category', 'bo-trang-suc') }}" class="{{ request()->routeIs('products.category') && request()->route('category') === 'bo-trang-suc' ? 'active' : '' }}">Bộ sưu tập</a>
            <a href="{{ route('products.category', 'set-qua-tang') }}" class="{{ request()->routeIs('products.category') && request()->route('category') === 'set-qua-tang' ? 'active' : '' }}">Quà tặng</a>
            <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Nhật ký Lunara (Blog)</a>
            <a href="{{ route('home') }}#story">Giới thiệu</a>
            <div class="mobile-navigation__divider"></div>
            @auth
                <div class="mobile-navigation__user-info mb-2 px-1">
                    <span class="text-muted small d-block">Đăng nhập bởi:</span>
                    <strong class="text-dark">{{ auth()->user()->name }}</strong>
                </div>
                <a href="{{ route('account.dashboard') }}"><i class="bi bi-person me-2"></i>Tài khoản của tôi</a>
                <a href="{{ route('account.orders.index') }}"><i class="bi bi-box-seam me-2"></i>Đơn mua của tôi</a>
                <form method="post" action="{{ route('logout') }}" class="mt-2">@csrf<button type="submit" class="text-danger w-100 text-start bg-transparent border-0 p-0"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button></form>
            @else
                <a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập</a>
                <a href="{{ route('register') }}"><i class="bi bi-person-plus me-2"></i>Đăng ký tài khoản</a>
            @endauth
            <span class="nav-unavailable mt-2" aria-label="Danh sách yêu thích chưa mở"><i class="bi bi-heart me-2"></i>Yêu thích (Sắp ra mắt)</span>
        </nav>
    </div>

    <div class="offcanvas offcanvas-end mini-cart" tabindex="-1" id="miniCart" aria-labelledby="miniCartTitle">
        <div class="offcanvas-header"><h2 class="offcanvas-title h4 mb-0" id="miniCartTitle">Giỏ hàng</h2><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Đóng giỏ hàng"></button></div>
        <div class="offcanvas-body">
            <div id="miniCartItems">
                @forelse(array_slice($headerCart['items'], 0, 3) as $item)
                    <div class="mini-cart__item">
                        @if($item['image_url'])<img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" width="64" height="80">@endif
                        <div><a href="{{ route('products.show', $item['slug']) }}">{{ $item['name'] }}</a><small>{{ $item['quantity'] }} × {{ $item['unit_price_display'] }}</small></div>
                    </div>
                @empty
                    <p>Giỏ hàng đang trống.</p>
                @endforelse
            </div>
            <div class="mini-cart__footer"><p>Tạm tính <strong id="miniCartSubtotal">{{ $headerCart['subtotal_display'] }}</strong></p><a class="lunara-button lunara-button--dark" href="{{ route('cart.index') }}">Xem giỏ hàng</a></div>
        </div>
    </div>

    @if(session('cart_warning'))
        <div class="lunara-container alert alert-warning my-3" role="alert">{{ session('cart_warning') }} <a href="{{ route('cart.index') }}">Xem giỏ hàng</a></div>
    @endif

    <div class="modal fade" id="siteSearch" tabindex="-1" aria-labelledby="siteSearchTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h2 class="modal-title h5" id="siteSearchTitle">Tìm sản phẩm</h2><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng tìm kiếm"></button></div><form action="{{ route('products.index') }}" method="get"><div class="modal-body"><label class="form-label" for="siteSearchQuery">Tên, SKU hoặc mô tả</label><input id="siteSearchQuery" class="form-control" type="search" name="q" required></div><div class="modal-footer"><button class="btn btn-dark" type="submit">Tìm kiếm</button></div></form></div></div>
    </div>

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
                <div class="site-footer__contact-info small text-muted mt-3" style="font-size: 0.8125rem; line-height: 1.6;">
                    <p class="mb-1"><i class="bi bi-geo-alt me-1 text-accent"></i> 140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Ho Chi Minh City</p>
                    <p class="mb-1"><i class="bi bi-telephone me-1 text-accent"></i> Hotline CSKH / Đặt hàng: <a href="tel:0971124922" class="text-white text-decoration-none">0971 124 922</a></p>
                    <p class="mb-1"><i class="bi bi-envelope me-1 text-accent"></i> Email: <a href="mailto:lunaraslivertrangsuc@gmail.com" class="text-white text-decoration-none">lunaraslivertrangsuc@gmail.com</a></p>
                    <p class="mb-0 text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i> Thứ Hai — Thứ Bảy: 08:30 - 20:30 (Chủ Nhật: 09:00 - 18:00)</p>
                </div>
            </div>
            <div>
                <h2>Bộ sưu tập</h2>
                <a href="{{ route('products.category', 'day-chuyen') }}">Dây chuyền</a>
                <a href="{{ route('products.category', 'nhan') }}">Nhẫn ánh trăng</a>
                <a href="{{ route('products.category', 'vong-tay') }}">Vòng tay tinh tú</a>
                <a href="{{ route('products.category', 'bo-trang-suc') }}">Bộ trang sức</a>
                <a href="{{ route('products.category', 'set-qua-tang') }}">Set quà tặng</a>
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
                <a href="{{ route('home') }}#story">Câu chuyện Lunara</a>
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
        <div class="lunara-container site-footer__bottom">
            <span>© {{ date('Y') }} Lunara Silver · All rights reserved.</span>
            <span>Shine with your own moonlight</span>
        </div>
    </footer>
    @include('partials.support_widget')
    @stack('scripts')
</body>
</html>
