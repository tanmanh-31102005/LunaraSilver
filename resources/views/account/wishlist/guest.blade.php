@extends('layouts.app')

@section('title', 'Sản phẩm yêu thích | Lunara Silver')
@section('robots', 'noindex,follow')
@section('main_class', 'wishlist-guest-main')

@section('content')
<div class="lunara-container py-4 py-md-5">
    <x-breadcrumb :items="[['label' => 'Sản phẩm yêu thích']]" />

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 font-serif text-dark mb-1">Danh Sách Yêu Thích</h1>
            <p class="text-muted small mb-0">Những thiết kế bạn đã lưu lại trong phiên duyệt web hiện tại.</p>
        </div>
        <div>
            <span class="badge bg-dark-subtle text-dark border px-3 py-2" id="wishlistHeaderCount">
                {{ $count }} sản phẩm
            </span>
        </div>
    </div>

    {{-- Guest Callout Banner (Phase 19.16 - 19.17) --}}
    <div class="card border-0 shadow-sm rounded-3 p-3 p-md-4 mb-4 bg-light border-start border-4 border-dark">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 rounded-circle bg-white text-dark shadow-sm">
                    <i class="bi bi-cloud-arrow-up fs-4"></i>
                </div>
                <div>
                    <h2 class="h6 mb-1 text-dark">Lưu giữ danh sách yêu thích vĩnh viễn</h2>
                    <p class="text-muted small mb-0">Đăng nhập hoặc đăng ký tài khoản để đồng bộ danh sách này và truy cập trên mọi thiết bị.</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-dark text-nowrap px-3">Đăng nhập</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-dark text-nowrap px-3">Tạo tài khoản</a>
            </div>
        </div>
    </div>

    @include('account.wishlist._items', ['products' => $products])
</div>
@endsection
