@extends('layouts.app')

@section('main_class', 'account-main')

@section('content')
<div class="lunara-container account-page py-4">
    <x-breadcrumb :items="array_merge([['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Tài khoản', 'url' => route('account.dashboard')]], $accountBreadcrumbs ?? [])" />

    <div class="account-header mb-4">
        <h1 class="h3 font-serif mb-1">Tài khoản của tôi</h1>
        <p class="text-muted small mb-0">Quản lý thông tin cá nhân, sổ địa chỉ và theo dõi tình trạng các đơn hàng của bạn.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    <div class="account-layout row g-4">
        <!-- Sidebar Navigation -->
        <aside class="col-12 col-lg-3 account-sidebar">
            <div class="account-nav-card card border-0 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <div class="account-user-snippet d-flex align-items-center gap-3 pb-3 mb-3 border-bottom">
                        <div class="account-avatar rounded-circle d-flex align-items-center justify-content-center bg-dark text-white fw-bold" style="width: 44px; height: 44px; font-size: 1.1rem;">
                            {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <h2 class="h6 mb-0 text-truncate">{{ auth()->user()->name }}</h2>
                            <small class="text-muted text-truncate d-block">{{ auth()->user()->email }}</small>
                        </div>
                    </div>

                    <nav class="account-nav d-flex flex-column gap-1" aria-label="Điều hướng tài khoản">
                        <a href="{{ route('account.dashboard') }}" class="account-nav-link {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid me-2"></i> Tổng quan
                        </a>
                        <a href="{{ route('account.profile.edit') }}" class="account-nav-link {{ request()->routeIs('account.profile.*') ? 'active' : '' }}">
                            <i class="bi bi-person me-2"></i> Thông tin cá nhân
                        </a>
                        <a href="{{ route('account.addresses.index') }}" class="account-nav-link {{ request()->routeIs('account.addresses.*') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt me-2"></i> Sổ địa chỉ
                        </a>
                        <a href="{{ route('account.orders.index') }}" class="account-nav-link {{ request()->routeIs('account.orders.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam me-2"></i> Lịch sử đơn hàng
                        </a>
                        <a href="{{ route('account.password.edit') }}" class="account-nav-link {{ request()->routeIs('account.password.*') ? 'active' : '' }}">
                            <i class="bi bi-shield-lock me-2"></i> Đổi mật khẩu
                        </a>
                        <div class="border-top my-2"></div>
                        <form action="{{ route('logout') }}" method="post" class="m-0">
                            @csrf
                            <button type="submit" class="account-nav-link account-nav-link--logout w-100 text-start border-0 bg-transparent text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="col-12 col-lg-9 account-content">
            @yield('account_content')
        </div>
    </div>
</div>
@endsection
