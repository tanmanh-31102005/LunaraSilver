<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | Lunara Silver</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    <style>
        /* Strict single sidebar guard - absolutely never display two sidebars */
        @media (min-width: 992px) {
            #adminMobileSidebar, .offcanvas-backdrop { display: none !important; }
            #adminSidebar { display: flex !important; }
        }
        @media (max-width: 991.98px) {
            #adminSidebar { display: none !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="admin-body">
    <div class="admin-shell" id="adminShell">
        {{-- Desktop Sidebar --}}
        <aside class="admin-sidebar d-none d-lg-flex" id="adminSidebar" aria-label="Thanh điều hướng quản trị">
            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__brand" title="Lunara Silver Admin">
                <img src="{{ route('media.show', ['path' => 'lunara-logo-dark.svg']) }}" alt="Lunara Silver" class="admin-sidebar__logo admin-logo-full">
                <img src="{{ route('media.show', ['path' => 'lunara-mark.svg']) }}" alt="Lunara" class="admin-sidebar__logo admin-logo-mark d-none" style="max-height: 32px; width: auto;">
                <span class="admin-sidebar__badge">Admin</span>
            </a>

            <nav class="admin-sidebar__nav" aria-label="Menu quản trị">
                <div class="admin-nav-group">
                    <div class="admin-nav-group__title">TỔNG QUAN</div>
                    <a href="{{ route('admin.dashboard') }}"
                       class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'admin-nav-item--active' : '' }}"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Bảng điều khiển">
                        <i class="bi bi-grid"></i>
                        <span>Bảng điều khiển</span>
                    </a>
                </div>

                <div class="admin-nav-group">
                    <div class="admin-nav-group__title">DANH MỤC & SẢN PHẨM</div>
                    <a href="{{ route('admin.products.index') }}"
                       class="admin-nav-item {{ request()->routeIs('admin.products.*') ? 'admin-nav-item--active' : '' }}"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Sản phẩm">
                        <i class="bi bi-box-seam"></i>
                        <span>Sản phẩm</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                       class="admin-nav-item {{ request()->routeIs('admin.categories.*') ? 'admin-nav-item--active' : '' }}"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Danh mục">
                        <i class="bi bi-tags"></i>
                        <span>Danh mục</span>
                    </a>
                </div>

                <div class="admin-nav-group">
                    <div class="admin-nav-group__title">BÁN HÀNG</div>
                    <a href="{{ route('admin.orders.index') }}"
                       class="admin-nav-item {{ request()->routeIs('admin.orders.*') ? 'admin-nav-item--active' : '' }}"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Đơn hàng">
                        <i class="bi bi-receipt"></i>
                        <span>Đơn hàng</span>
                    </a>
                </div>

                <div class="admin-nav-group">
                    <div class="admin-nav-group__title">MARKETING</div>
                    <a href="{{ route('admin.coupons.index') }}"
                       class="admin-nav-item {{ request()->routeIs('admin.coupons.*') ? 'admin-nav-item--active' : '' }}"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Mã giảm giá">
                        <i class="bi bi-ticket-perforated"></i>
                        <span>Mã giảm giá</span>
                    </a>
                </div>

                <div class="admin-nav-group">
                    <div class="admin-nav-group__title">NỘI DUNG</div>
                    <a href="{{ route('admin.posts.index') }}"
                       class="admin-nav-item {{ request()->routeIs('admin.posts.*') ? 'admin-nav-item--active' : '' }}"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý bài viết blog">
                        <i class="bi bi-journal-text"></i>
                        <span>Bài viết</span>
                    </a>
                    <a href="{{ route('admin.post-categories.index') }}"
                       class="admin-nav-item {{ request()->routeIs('admin.post-categories.*') ? 'admin-nav-item--active' : '' }}"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Danh mục blog">
                        <i class="bi bi-folder2-open"></i>
                        <span>Danh mục Blog</span>
                    </a>
                </div>

                <div class="admin-nav-group">
                    <div class="admin-nav-group__title">KHÁCH HÀNG</div>
                    <a href="{{ route('admin.customers.index') }}"
                       class="admin-nav-item {{ request()->routeIs('admin.customers.*') ? 'admin-nav-item--active' : '' }}"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý khách hàng">
                        <i class="bi bi-people"></i>
                        <span>Khách hàng</span>
                    </a>

                    <a href="{{ route('admin.reviews.index') }}"
                       class="admin-nav-item {{ request()->routeIs('admin.reviews.*') ? 'admin-nav-item--active' : '' }}"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Đánh giá sản phẩm">
                        <i class="bi bi-star"></i>
                        <span>Đánh giá</span>
                    </a>

                    <a href="{{ route('admin.support.index') }}"
                       class="admin-nav-item {{ request()->routeIs('admin.support.*') ? 'admin-nav-item--active' : '' }}"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Hỗ trợ khách hàng">
                        <i class="bi bi-headset"></i>
                        <span>Hỗ trợ</span>
                    </a>

                    <a href="{{ route('admin.faqs.index') }}"
                       class="admin-nav-item {{ request()->routeIs('admin.faqs.*') ? 'admin-nav-item--active' : '' }}"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý FAQ">
                        <i class="bi bi-question-circle"></i>
                        <span>FAQ</span>
                    </a>
                </div>
            </nav>

            <div class="admin-sidebar__footer">
                <a href="{{ route('home') }}" class="admin-btn admin-btn--secondary w-100" target="_blank" rel="noopener" title="Mở cửa hàng trong tab mới">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>Xem cửa hàng</span>
                </a>
            </div>
        </aside>

        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start bg-dark text-white d-lg-none" tabindex="-1" id="adminMobileSidebar" aria-labelledby="adminMobileSidebarLabel" style="width: 260px; background-color: var(--admin-sidebar-bg) !important;">
            <div class="offcanvas-header border-bottom border-secondary py-3 px-3">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ route('media.show', ['path' => 'lunara-logo-dark.svg']) }}" alt="Lunara Silver" class="admin-sidebar__logo" style="max-height: 42px; width: auto;">
                    <span class="admin-sidebar__badge">Admin</span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Đóng"></button>
            </div>
            <div class="offcanvas-body p-3 d-flex flex-column">
                <nav class="admin-sidebar__nav p-0 flex-grow-1" aria-label="Menu quản trị mobile">
                    <div class="admin-nav-group">
                        <div class="admin-nav-group__title text-white-50">TỔNG QUAN</div>
                        <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'admin-nav-item--active' : '' }}">
                            <i class="bi bi-grid"></i>
                            <span>Bảng điều khiển</span>
                        </a>
                    </div>

                    <div class="admin-nav-group">
                        <div class="admin-nav-group__title text-white-50">DANH MỤC & SẢN PHẨM</div>
                        <a href="{{ route('admin.products.index') }}" class="admin-nav-item {{ request()->routeIs('admin.products.*') ? 'admin-nav-item--active' : '' }}">
                            <i class="bi bi-box-seam"></i>
                            <span>Sản phẩm</span>
                        </a>

                        <a href="{{ route('admin.categories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.categories.*') ? 'admin-nav-item--active' : '' }}">
                            <i class="bi bi-tags"></i>
                            <span>Danh mục</span>
                        </a>
                    </div>

                    <div class="admin-nav-group">
                        <div class="admin-nav-group__title text-white-50">BÁN HÀNG</div>
                        <a href="{{ route('admin.orders.index') }}" class="admin-nav-item {{ request()->routeIs('admin.orders.*') ? 'admin-nav-item--active' : '' }}">
                            <i class="bi bi-receipt"></i>
                            <span>Đơn hàng</span>
                        </a>
                    </div>

                    <div class="admin-nav-group">
                        <div class="admin-nav-group__title text-white-50">MARKETING</div>
                        <a href="{{ route('admin.coupons.index') }}" class="admin-nav-item {{ request()->routeIs('admin.coupons.*') ? 'admin-nav-item--active' : '' }}">
                            <i class="bi bi-ticket-perforated"></i>
                            <span>Mã giảm giá</span>
                        </a>
                    </div>

                    <div class="admin-nav-group">
                        <div class="admin-nav-group__title text-white-50">NỘI DUNG</div>
                        <a href="{{ route('admin.posts.index') }}" class="admin-nav-item {{ request()->routeIs('admin.posts.*') ? 'admin-nav-item--active' : '' }}">
                            <i class="bi bi-journal-text"></i>
                            <span>Bài viết</span>
                        </a>
                        <a href="{{ route('admin.post-categories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.post-categories.*') ? 'admin-nav-item--active' : '' }}">
                            <i class="bi bi-folder2-open"></i>
                            <span>Danh mục Blog</span>
                        </a>
                    </div>

                    <div class="admin-nav-group">
                        <div class="admin-nav-group__title text-white-50">KHÁCH HÀNG</div>
                        <a href="{{ route('admin.customers.index') }}" class="admin-nav-item {{ request()->routeIs('admin.customers.*') ? 'admin-nav-item--active' : '' }}">
                            <i class="bi bi-people"></i>
                            <span>Khách hàng</span>
                        </a>

                        <a href="{{ route('admin.reviews.index') }}" class="admin-nav-item {{ request()->routeIs('admin.reviews.*') ? 'admin-nav-item--active' : '' }}">
                            <i class="bi bi-star"></i>
                            <span>Đánh giá</span>
                        </a>

                        <a href="{{ route('admin.support.index') }}" class="admin-nav-item {{ request()->routeIs('admin.support.*') ? 'admin-nav-item--active' : '' }}">
                            <i class="bi bi-headset"></i>
                            <span>Hỗ trợ</span>
                        </a>

                        <a href="{{ route('admin.faqs.index') }}" class="admin-nav-item {{ request()->routeIs('admin.faqs.*') ? 'admin-nav-item--active' : '' }}">
                            <i class="bi bi-question-circle"></i>
                            <span>FAQ</span>
                        </a>
                    </div>
                </nav>

                <div class="pt-3 border-top border-secondary">
                    <a href="{{ route('home') }}" class="admin-btn admin-btn--secondary w-100" target="_blank" rel="noopener">
                        <i class="bi bi-box-arrow-up-right"></i>
                        <span>Xem cửa hàng</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Main Shell Area --}}
        <div class="admin-main">
            {{-- Topbar --}}
            <header class="admin-topbar">
                <div class="admin-topbar__left">
                    {{-- Toggle Button: Collapses sidebar on Desktop, Opens Offcanvas on Mobile --}}
                    <button class="admin-topbar__toggle d-none d-lg-flex" type="button" id="sidebarCollapseBtn" title="Thu gọn / Mở rộng thanh bên" aria-label="Thu gọn / Mở rộng thanh bên">
                        <i class="bi bi-layout-sidebar-inset fs-6"></i>
                    </button>
                    <button class="admin-topbar__toggle d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMobileSidebar" aria-controls="adminMobileSidebar" aria-label="Mở menu quản trị">
                        <i class="bi bi-list fs-5"></i>
                    </button>

                    <div>
                        <ol class="admin-breadcrumb">
                            <li><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            @yield('breadcrumb')
                        </ol>
                        <h1 class="h6 mb-0 fw-bold" style="letter-spacing: -0.01em;">@yield('page_title', 'Dashboard')</h1>
                    </div>
                </div>

                {{-- Global Search Bar Trigger --}}
                <div class="admin-topbar__search mx-2 mx-md-3 flex-grow-1" style="max-width: 380px;">
                    <button type="button" class="btn btn-sm btn-light border text-start w-100 d-flex align-items-center justify-content-between px-3 py-1 text-muted rounded-pill shadow-none" id="adminGlobalSearchTrigger" aria-label="Tìm kiếm toàn hệ thống (Ctrl+K)" style="background: #f8fafc; font-size: 0.82rem; height: 36px;">
                        <span class="d-flex align-items-center gap-2 text-truncate">
                            <i class="bi bi-search text-muted"></i>
                            <span class="text-truncate">Tìm đơn hàng, SKU, khách hàng...</span>
                        </span>
                        <kbd class="badge bg-secondary-subtle text-secondary border px-1 py-0 fw-normal d-none d-sm-inline" style="font-size: 0.68rem;">Ctrl K</kbd>
                    </button>
                </div>

                <div class="admin-topbar__right">
                    <a href="{{ route('home') }}" class="admin-store-link d-none d-sm-inline-flex" target="_blank" rel="noopener" title="Xem giao diện khách hàng">
                        <i class="bi bi-box-arrow-up-right"></i>
                        <span>Xem cửa hàng</span>
                    </a>

                    {{-- Admin Profile Dropdown --}}
                    <div class="dropdown">
                        <button class="admin-user-btn dropdown-toggle" type="button" id="adminUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="admin-user-avatar">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="admin-user-info d-none d-md-block">
                                <div class="admin-user-name">{{ auth()->user()->name ?? 'Quản trị viên' }}</div>
                                <div class="admin-user-role">Administrator</div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border" aria-labelledby="adminUserDropdown" style="font-size: 0.85rem; min-width: 180px;">
                            <li class="px-3 py-2 border-bottom d-md-none">
                                <div class="fw-semibold">{{ auth()->user()->name }}</div>
                                <div class="text-muted small">Administrator</div>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('account.dashboard') }}">
                                    <i class="bi bi-person text-muted"></i>
                                    <span>Tài khoản của tôi</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('home') }}" target="_blank">
                                    <i class="bi bi-box-arrow-up-right text-muted"></i>
                                    <span>Xem cửa hàng</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger d-flex align-items-center gap-2">
                                        <i class="bi bi-box-arrow-right"></i>
                                        <span>Đăng xuất</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="admin-content" id="main-content">
                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3 py-2 px-3 small border-0 shadow-sm" role="alert" style="background-color: #ecfdf5; color: #065f46; border-left: 3px solid #10b981 !important;">
                        <i class="bi bi-check-circle-fill fs-6 text-success"></i>
                        <div class="flex-grow-1 fw-medium">{{ session('success') }}</div>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center gap-2 mb-3 py-2 px-3 small border-0 shadow-sm" role="alert" style="background-color: #fffbeb; color: #92400e; border-left: 3px solid #f59e0b !important;">
                        <i class="bi bi-exclamation-triangle-fill fs-6 text-warning"></i>
                        <div class="flex-grow-1 fw-medium">{{ session('warning') }}</div>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2 mb-3 py-2 px-3 small border-0 shadow-sm" role="alert" style="background-color: #f0f9ff; color: #075985; border-left: 3px solid #0ea5e9 !important;">
                        <i class="bi bi-info-circle-fill fs-6 text-info"></i>
                        <div class="flex-grow-1 fw-medium">{{ session('info') }}</div>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3 py-2 px-3 small border-0 shadow-sm" role="alert" style="background-color: #fef2f2; color: #991b1b; border-left: 3px solid #ef4444 !important;">
                        <i class="bi bi-x-circle-fill fs-6 text-danger"></i>
                        <div class="flex-grow-1 fw-medium">{{ session('error') }}</div>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-3 p-3 border-0 shadow-sm" role="alert" style="background-color: #fef2f2; color: #991b1b; border-left: 3px solid #ef4444 !important;">
                        <div class="fw-semibold mb-1 d-flex align-items-center gap-2 small">
                            <i class="bi bi-exclamation-octagon-fill text-danger"></i>
                            <span>Vui lòng kiểm tra lại thông tin:</span>
                        </div>
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Reusable Admin Action Confirmation Modal --}}
    <div class="modal fade" id="adminConfirmModal" tabindex="-1" aria-labelledby="adminConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-header py-2 px-3 border-bottom">
                    <h6 class="modal-title fw-bold fs-6" id="adminConfirmModalLabel">Xác nhận</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body py-3 px-3 small text-muted" id="adminConfirmModalBody">
                    Bạn có chắc chắn muốn thực hiện thao tác này?
                </div>
                <div class="modal-footer py-2 px-3 border-top gap-2">
                    <button type="button" class="admin-btn admin-btn--secondary admin-btn--sm" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="admin-btn admin-btn--danger admin-btn--sm" id="adminConfirmModalBtn">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Global Search Command Palette Modal (Ctrl + K) --}}
    <div class="modal fade" id="adminGlobalSearchModal" tabindex="-1" aria-labelledby="adminGlobalSearchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-3" style="overflow: hidden;">
                <div class="modal-header p-3 border-bottom" style="background: #f8fafc;">
                    <div class="input-group input-group-lg border-0 shadow-none">
                        <span class="input-group-text bg-transparent border-0 pe-2"><i class="bi bi-search text-primary fs-5"></i></span>
                        <input type="text" class="form-control bg-transparent border-0 shadow-none fs-6" id="adminGlobalSearchInput" placeholder="Nhập mã đơn (LNS-), SKU, email, tên khách hàng, số điện thoại..." autocomplete="off">
                        <button class="btn btn-link text-muted p-0 text-decoration-none" type="button" data-bs-dismiss="modal" aria-label="Đóng"><kbd class="bg-white border text-muted px-2 py-1 small">ESC</kbd></button>
                    </div>
                </div>
                <div class="modal-body p-3" id="adminGlobalSearchResults" style="max-height: 480px; min-height: 200px;">
                    <div class="text-center py-5 text-muted small" id="adminGlobalSearchEmpty">
                        <i class="bi bi-binoculars fs-1 d-block mb-2 text-muted opacity-50"></i>
                        <span class="fw-medium">Tìm nhanh dữ liệu vận hành toàn hệ thống</span>
                        <div class="mt-2 text-muted-50" style="font-size: 0.78rem;">Hỗ trợ: Mã đơn hàng (LNS-), Mã SKU, Tên/Email khách hàng, Mã yêu cầu hỗ trợ (SUP-)...</div>
                    </div>
                    <div id="adminGlobalSearchResultsContainer" class="d-none"></div>
                </div>
                <div class="modal-footer py-2 px-3 bg-light border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small" style="font-size: 0.75rem;"><kbd class="px-1 py-0">↑</kbd> <kbd class="px-1 py-0">↓</kbd> Di chuyển • <kbd class="px-1 py-0">Enter</kbd> Chọn • <kbd class="px-1 py-0">ESC</kbd> Đóng</span>
                    <span class="badge bg-secondary-subtle text-secondary border">Lunara Admin Intelligence</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Persistent Collapsible Sidebar
            const shell = document.getElementById('adminShell');
            const collapseBtn = document.getElementById('sidebarCollapseBtn');
            const logoFull = document.querySelector('.admin-logo-full');
            const logoMark = document.querySelector('.admin-logo-mark');

            function applySidebarState(isCollapsed) {
                if (!shell) return;
                if (isCollapsed) {
                    shell.classList.add('admin-shell--collapsed');
                    if (logoFull) logoFull.classList.add('d-none');
                    if (logoMark) logoMark.classList.remove('d-none');
                } else {
                    shell.classList.remove('admin-shell--collapsed');
                    if (logoFull) logoFull.classList.remove('d-none');
                    if (logoMark) logoMark.classList.add('d-none');
                }
            }

            const savedState = localStorage.getItem('lunara_admin_sidebar_collapsed');
            if (savedState === 'true') {
                applySidebarState(true);
            }

            if (collapseBtn) {
                collapseBtn.addEventListener('click', function() {
                    const isCurrentlyCollapsed = shell.classList.contains('admin-shell--collapsed');
                    const newState = !isCurrentlyCollapsed;
                    applySidebarState(newState);
                    localStorage.setItem('lunara_admin_sidebar_collapsed', newState ? 'true' : 'false');
                });
            }

            // Initialize Bootstrap Tooltips
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Global Confirmation Modal Helper
            window.adminConfirm = function(options) {
                const modalEl = document.getElementById('adminConfirmModal');
                if (!modalEl) return options.onConfirm && options.onConfirm();

                const titleEl = document.getElementById('adminConfirmModalLabel');
                const bodyEl = document.getElementById('adminConfirmModalBody');
                const btnEl = document.getElementById('adminConfirmModalBtn');

                if (titleEl) titleEl.textContent = options.title || 'Xác nhận thao tác';
                if (bodyEl) bodyEl.textContent = options.message || 'Bạn có chắc chắn muốn thực hiện thao tác này?';
                if (btnEl) {
                    btnEl.textContent = options.confirmText || 'Đồng ý';
                    btnEl.className = 'admin-btn admin-btn--sm ' + (options.confirmClass || 'admin-btn--danger');

                    const newBtn = btnEl.cloneNode(true);
                    btnEl.parentNode.replaceChild(newBtn, btnEl);

                    newBtn.addEventListener('click', function() {
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();
                        if (options.onConfirm) options.onConfirm();
                    });
                }

                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            };

            // Phase 21: Global Command Palette Search (Ctrl + K / Cmd + K)
            const searchModalEl = document.getElementById('adminGlobalSearchModal');
            const searchTriggerBtn = document.getElementById('adminGlobalSearchTrigger');
            const searchInput = document.getElementById('adminGlobalSearchInput');
            const resultsEmpty = document.getElementById('adminGlobalSearchEmpty');
            const resultsContainer = document.getElementById('adminGlobalSearchResultsContainer');

            let searchModalInstance = null;
            if (searchModalEl) {
                searchModalInstance = new bootstrap.Modal(searchModalEl);

                searchModalEl.addEventListener('shown.bs.modal', function() {
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                });
            }

            if (searchTriggerBtn && searchModalInstance) {
                searchTriggerBtn.addEventListener('click', function() {
                    searchModalInstance.show();
                });
            }

            // Global keyboard shortcuts (Ctrl+K or Cmd+K)
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    if (searchModalInstance) {
                        searchModalInstance.show();
                    }
                }
            });

            let searchDebounceTimer = null;
            let currentSelectedIndex = -1;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const q = searchInput.value.trim();
                    clearTimeout(searchDebounceTimer);

                    if (q.length < 2) {
                        resultsContainer.innerHTML = '';
                        resultsContainer.classList.add('d-none');
                        resultsEmpty.classList.remove('d-none');
                        return;
                    }

                    searchDebounceTimer = setTimeout(function() {
                        fetch('{{ route("admin.search.global") }}?q=' + encodeURIComponent(q), {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            renderSearchResults(data.groups || []);
                        })
                        .catch(() => {
                            resultsContainer.innerHTML = '<div class="text-danger small p-3 text-center">Lỗi khi tìm kiếm dữ liệu.</div>';
                            resultsContainer.classList.remove('d-none');
                            resultsEmpty.classList.add('d-none');
                        });
                    }, 250);
                });

                // Keyboard arrow navigation & Enter
                searchInput.addEventListener('keydown', function(e) {
                    const items = resultsContainer.querySelectorAll('.admin-search-item');
                    if (!items.length) return;

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        currentSelectedIndex = (currentSelectedIndex + 1) % items.length;
                        updateSelectedItem(items);
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        currentSelectedIndex = (currentSelectedIndex - 1 + items.length) % items.length;
                        updateSelectedItem(items);
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (currentSelectedIndex >= 0 && items[currentSelectedIndex]) {
                            items[currentSelectedIndex].click();
                        } else if (items.length > 0) {
                            items[0].click();
                        }
                    }
                });
            }

            function updateSelectedItem(items) {
                items.forEach((item, idx) => {
                    if (idx === currentSelectedIndex) {
                        item.classList.add('active', 'bg-light');
                        item.scrollIntoView({ block: 'nearest' });
                    } else {
                        item.classList.remove('active', 'bg-light');
                    }
                });
            }

            function renderSearchResults(groups) {
                currentSelectedIndex = -1;
                if (!groups.length) {
                    resultsEmpty.classList.add('d-none');
                    resultsContainer.classList.remove('d-none');
                    resultsContainer.innerHTML = '<div class="text-center py-4 text-muted small">Không tìm thấy kết quả phù hợp.</div>';
                    return;
                }

                resultsEmpty.classList.add('d-none');
                resultsContainer.classList.remove('d-none');

                let html = '';
                groups.forEach(group => {
                    html += `
                        <div class="admin-search-group mb-3">
                            <div class="d-flex align-items-center gap-2 px-2 py-1 text-muted text-uppercase fw-bold border-bottom" style="font-size: 0.68rem; letter-spacing: 0.08em;">
                                <i class="bi ${group.icon}"></i>
                                <span>${group.group}</span>
                            </div>
                            <div class="list-group list-group-flush mt-1">
                    `;

                    group.items.forEach(item => {
                        const badgeHtml = item.badge ? `<span class="badge ${item.badge_class || 'bg-secondary'} rounded-pill" style="font-size: 0.68rem;">${item.badge}</span>` : '';
                        html += `
                            <a href="${item.url}" class="admin-search-item list-group-item list-group-item-action border-0 rounded-2 px-3 py-2 d-flex align-items-center justify-content-between text-decoration-none">
                                <div class="me-2 text-truncate">
                                    <div class="fw-semibold text-dark small text-truncate">${escapeHtml(item.title)}</div>
                                    <div class="text-muted text-truncate" style="font-size: 0.75rem;">${escapeHtml(item.subtitle)}</div>
                                </div>
                                <div>${badgeHtml}</div>
                            </a>
                        `;
                    });

                    html += `
                            </div>
                        </div>
                    `;
                });

                resultsContainer.innerHTML = html;
            }

            function escapeHtml(text) {
                if (!text) return '';
                const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
                return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

