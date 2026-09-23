@extends('layouts.account')

@section('title', 'Tổng quan tài khoản | Lunara Silver')

@php
    $accountBreadcrumbs = [['label' => 'Tổng quan']];
@endphp

@section('account_content')
<div class="account-dashboard">
    <!-- Welcome Banner -->
    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <span class="text-uppercase text-muted fw-semibold small letter-spacing-1">Xin chào mừng trở lại</span>
                <h2 class="h4 font-serif text-dark mb-1">{{ $user->name }}</h2>
                <p class="text-muted small mb-0">Rất vui được đồng hành cùng bạn trên hành trình tỏa sáng với Lunara Silver.</p>
            </div>
            <div>
                <a href="{{ route('products.index') }}" class="lunara-button lunara-button--outline py-2 px-3 text-nowrap">
                    <i class="bi bi-gem me-1"></i> Khám phá trang sức
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small">Đơn hàng của bạn</span>
                    <div class="p-2 rounded-circle bg-light text-primary"><i class="bi bi-bag-check"></i></div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h3 mb-0 fw-bold">{{ $ordersCount }}</span>
                    <span class="text-muted small">đơn hàng</span>
                </div>
                <a href="{{ route('account.orders.index') }}" class="small text-decoration-none mt-2 d-inline-block text-primary">
                    Xem tất cả đơn hàng →
                </a>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small">Địa chỉ đã lưu</span>
                    <div class="p-2 rounded-circle bg-light text-primary"><i class="bi bi-geo-alt"></i></div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h3 mb-0 fw-bold">{{ $addressesCount }}</span>
                    <span class="text-muted small">địa chỉ</span>
                </div>
                <a href="{{ route('account.addresses.index') }}" class="small text-decoration-none mt-2 d-inline-block text-primary">
                    Quản lý sổ địa chỉ →
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Order Widget -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-3 h-100 bg-white">
                <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h3 class="h6 mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i> Đơn hàng gần nhất</h3>
                    @if($latestOrder)
                        <a href="{{ route('account.orders.index') }}" class="small text-muted text-decoration-none">Tất cả</a>
                    @endif
                </div>
                <div class="card-body p-4">
                    @if($latestOrder)
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-start border-bottom pb-3">
                                <div>
                                    <span class="fw-bold font-monospace">{{ $latestOrder->order_code }}</span>
                                    <div class="text-muted small mt-1">
                                        Ngày đặt: {{ $latestOrder->placed_at ? $latestOrder->placed_at->format('H:i d/m/Y') : $latestOrder->created_at->format('H:i d/m/Y') }}
                                    </div>
                                </div>
                                <div>
                                    <span class="badge bg-secondary">{{ $latestOrder->order_status_label }}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small d-block">Tổng thanh toán</span>
                                    <strong class="h5 mb-0 text-dark">{{ number_format($latestOrder->grand_total, 0, ',', '.') }} ₫</strong>
                                </div>
                                <a href="{{ route('account.orders.show', $latestOrder->order_code) }}" class="lunara-button lunara-button--outline py-1 px-3 small">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3 text-muted" style="font-size: 2.5rem;"><i class="bi bi-bag-x"></i></div>
                            <h4 class="h6 text-muted mb-2">Bạn chưa có đơn hàng nào.</h4>
                            <p class="small text-muted mb-3">Hãy dạo xem các bộ sưu tập tinh tế từ bạc 925 của Lunara Silver.</p>
                            <a href="{{ route('products.index') }}" class="lunara-button lunara-button--dark py-2 px-3 small">
                                Tiếp tục mua sắm
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Default Address Widget -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-3 h-100 bg-white">
                <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h3 class="h6 mb-0 fw-bold"><i class="bi bi-house-door me-2 text-primary"></i> Địa chỉ mặc định</h3>
                    <a href="{{ route('account.addresses.index') }}" class="small text-muted text-decoration-none">Sửa</a>
                </div>
                <div class="card-body p-4">
                    @if($defaultAddress)
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <strong>{{ $defaultAddress->recipient_name }}</strong>
                                <span class="badge bg-success-subtle text-success border border-success-subtle small">Mặc định</span>
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-telephone me-1"></i> {{ $defaultAddress->phone }}
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ $defaultAddress->address_line }}
                                @if($defaultAddress->ward), {{ $defaultAddress->ward }}@endif
                                @if($defaultAddress->district), {{ $defaultAddress->district }}@endif
                                , {{ $defaultAddress->city }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3 text-muted" style="font-size: 2.5rem;"><i class="bi bi-geo"></i></div>
                            <h4 class="h6 text-muted mb-2">Bạn chưa lưu địa chỉ mặc định.</h4>
                            <p class="small text-muted mb-3">Lưu địa chỉ giúp bạn thanh toán nhanh hơn cho các lần mua sau.</p>
                            <a href="{{ route('account.addresses.index') }}" class="lunara-button lunara-button--outline py-2 px-3 small">
                                Thêm địa chỉ
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
