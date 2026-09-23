@extends('layouts.account')

@section('title', 'Chi tiết đơn hàng ' . $order->order_code . ' | Lunara Silver')

@php
    $accountBreadcrumbs = [
        ['label' => 'Đơn hàng', 'url' => route('account.orders.index')],
        ['label' => $order->order_code],
    ];
@endphp

@section('account_content')
<div class="account-order-detail">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('account.orders.index') }}" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
            <h2 class="h5 mb-1 fw-bold">Chi tiết đơn hàng: <span class="font-monospace text-primary">{{ $order->order_code }}</span></h2>
            <p class="text-muted small mb-0">
                Đặt ngày: {{ $order->placed_at ? $order->placed_at->format('H:i d/m/Y') : $order->created_at->format('H:i d/m/Y') }}
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            @php
                $orderBadgeClass = match($order->order_status) {
                    'pending' => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                    'confirmed' => 'bg-info-subtle text-info border border-info-subtle',
                    'processing' => 'bg-primary-subtle text-primary border border-primary-subtle',
                    'shipping' => 'bg-warning-subtle text-warning border border-warning-subtle',
                    'completed' => 'bg-success-subtle text-success border border-success-subtle',
                    'cancelled' => 'bg-danger-subtle text-danger border border-danger-subtle',
                    default => 'bg-secondary text-white',
                };
            @endphp
            <span class="badge {{ $orderBadgeClass }} px-3 py-2">
                {{ $order->order_status_label }}
            </span>
            <span class="badge bg-light text-dark border px-3 py-2">
                {{ $order->payment_status_label }}
            </span>
        </div>
    </div>

    <!-- Customer & Shipping Snapshot -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100 bg-white">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h3 class="h6 mb-0 fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i> Địa chỉ nhận hàng</h3>
                </div>
                <div class="card-body p-4">
                    <div class="mb-2">
                        <strong class="d-block text-dark">{{ $order->customer_name }}</strong>
                        <span class="text-muted small"><i class="bi bi-telephone me-1"></i> {{ $order->customer_phone }}</span>
                        <span class="text-muted small d-block"><i class="bi bi-envelope me-1"></i> {{ $order->customer_email }}</span>
                    </div>
                    <div class="text-muted small mt-2">
                        {{ $order->shipping_address }}, {{ $order->shipping_city }}
                    </div>
                    @if($order->shipping_note)
                        <div class="mt-3 p-2 bg-light rounded small border">
                            <strong class="text-dark d-block">Ghi chú giao hàng:</strong>
                            <span class="text-muted">{{ $order->shipping_note }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100 bg-white">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h3 class="h6 mb-0 fw-bold"><i class="bi bi-credit-card me-2 text-primary"></i> Thanh toán & Vận chuyển</h3>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <small class="text-muted d-block">Phương thức thanh toán</small>
                        <strong class="text-dark">{{ $order->payment_method_label }}</strong>
                        <div class="text-muted small mt-1">Trạng thái: {{ $order->payment_status_label }}</div>
                    </div>
                    <div class="border-top pt-3">
                        <small class="text-muted d-block">Phương thức giao hàng</small>
                        <strong class="text-dark">Giao hàng tiêu chuẩn</strong>
                        <div class="text-muted small mt-1">Phí vận chuyển: {{ number_format($order->shipping_fee, 0, ',', '.') }} ₫</div>
                    </div>
                    @if($order->customer_note)
                        <div class="mt-3 p-2 bg-light rounded small border">
                            <strong class="text-dark d-block">Ghi chú từ khách hàng:</strong>
                            <span class="text-muted">{{ $order->customer_note }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Items Snapshot -->
    <div class="card border-0 shadow-sm rounded-3 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-transparent border-bottom py-3">
            <h3 class="h6 mb-0 fw-bold"><i class="bi bi-bag-check me-2 text-primary"></i> Danh sách sản phẩm</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0" aria-label="Sản phẩm trong đơn hàng">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th scope="col" class="py-3 px-3">Sản phẩm</th>
                            <th scope="col" class="py-3">SKU</th>
                            <th scope="col" class="py-3 text-center">Đơn giá</th>
                            <th scope="col" class="py-3 text-center">Số lượng</th>
                            <th scope="col" class="py-3 text-end px-3">Tạm tính</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-3">
                                    <div class="d-flex align-items-center gap-3">
                                        @php
                                            $primaryImage = $item->product?->images?->first();
                                            $imageUrl = $primaryImage ? $primaryImage->image_url : null;
                                        @endphp
                                        <div class="rounded border overflow-hidden bg-light flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 54px; height: 68px;">
                                            @if($imageUrl)
                                                <img src="{{ $imageUrl }}" alt="{{ $item->product_name }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                                            @else
                                                <i class="bi bi-image text-muted" style="font-size: 1.2rem;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            @if($item->product && $item->product->slug)
                                                <a href="{{ route('products.show', $item->product->slug) }}" class="fw-semibold text-dark text-decoration-none">
                                                    {{ $item->product_name }}
                                                </a>
                                            @else
                                                <span class="fw-semibold text-dark">{{ $item->product_name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="font-monospace text-muted small">{{ $item->product_sku }}</span>
                                </td>
                                <td class="text-center text-muted small">
                                    {{ number_format($item->unit_price, 0, ',', '.') }} ₫
                                </td>
                                <td class="text-center fw-semibold">
                                    {{ $item->quantity }}
                                </td>
                                <td class="text-end px-3">
                                    <strong class="text-dark">{{ number_format($item->subtotal, 0, ',', '.') }} ₫</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light p-4 border-top">
            <div class="row justify-content-end">
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="d-flex justify-content-between py-1 text-muted small">
                        <span>Tạm tính</span>
                        <span>{{ number_format($order->subtotal, 0, ',', '.') }} ₫</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="d-flex justify-content-between py-1 text-muted small">
                            <span>Giảm giá</span>
                            <span>-{{ number_format($order->discount_amount, 0, ',', '.') }} ₫</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between py-1 text-muted small">
                        <span>Phí vận chuyển</span>
                        <span>{{ number_format($order->shipping_fee, 0, ',', '.') }} ₫</span>
                    </div>
                    <div class="d-flex justify-content-between pt-2 border-top mt-2">
                        <span class="fw-bold h6 mb-0 text-dark">Tổng thanh toán</span>
                        <strong class="h5 mb-0 text-primary">{{ number_format($order->grand_total, 0, ',', '.') }} ₫</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
