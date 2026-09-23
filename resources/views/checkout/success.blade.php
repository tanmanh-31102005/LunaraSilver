@extends('layouts.app')

@section('title', 'Đặt hàng thành công | Lunara Silver')
@section('main_class', 'order-success-main')

@section('content')
    <div class="lunara-container order-success-page py-5">
        <div class="order-success-card">
            <div class="text-center mb-4">
                <div class="order-success-icon">
                    <i class="bi bi-check2-circle text-success" style="font-size: 3.5rem;"></i>
                </div>
                <h1 class="h2 mt-2">Đặt hàng thành công!</h1>
                <p class="text-muted">Cảm ơn quý khách đã tin tưởng và lựa chọn trang sức bạc Lunara Silver.</p>
                <div class="order-code-badge d-inline-block px-3 py-2 bg-light border rounded">
                    <span>Mã đơn hàng:</span> <strong class="text-dark">{{ $order->order_code }}</strong>
                </div>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-12 col-lg-7">
                    <div class="order-details-box p-4 border rounded bg-white">
                        <h2 class="h5 border-bottom pb-2 mb-3">Chi tiết đơn hàng</h2>
                        <div class="order-items-list">
                            @foreach($order->items as $item)
                                <div class="order-item-row d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <div class="d-flex align-items-center gap-3">
                                        @php
                                            $image = $item->product?->images?->firstWhere('image_role', 'primary') ?: $item->product?->images?->first();
                                        @endphp
                                        <div class="order-item-thumb">
                                            @if($image)
                                                <img src="{{ $image->displayUrl() }}" alt="{{ $item->product_name }}" width="50" height="62" style="object-fit: cover;" class="rounded border">
                                            @else
                                                <span class="d-inline-flex justify-content-center align-items-center bg-light border rounded" style="width: 50px; height: 62px;"><i class="bi bi-image text-muted"></i></span>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="h6 mb-0">{{ $item->product_name }}</h3>
                                            <small class="text-muted">SKU: {{ $item->product_sku }} | Số lượng: {{ $item->quantity }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <strong>{{ number_format((int) str_replace('.', '', $item->subtotal) / 100, 0, ',', '.') }} ₫</strong>
                                        <div><small class="text-muted">{{ number_format((int) str_replace('.', '', $item->unit_price) / 100, 0, ',', '.') }} ₫ / sp</small></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="order-totals-box mt-3 pt-2">
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-muted">Tạm tính:</span>
                                <span>{{ number_format((int) str_replace('.', '', $order->subtotal) / 100, 0, ',', '.') }} ₫</span>
                            </div>
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-muted">Phí vận chuyển:</span>
                                <span>{{ number_format((int) str_replace('.', '', $order->shipping_fee) / 100, 0, ',', '.') }} ₫</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-top mt-2">
                                <span class="h6 mb-0">Tổng thanh toán:</span>
                                <strong class="h5 mb-0 text-dark">{{ number_format((int) str_replace('.', '', $order->grand_total) / 100, 0, ',', '.') }} ₫</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="order-shipping-box p-4 border rounded bg-light mb-3">
                        <h2 class="h5 border-bottom pb-2 mb-3">Thông tin giao nhận</h2>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2"><strong>Người nhận:</strong> {{ $order->customer_name }}</li>
                            <li class="mb-2"><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</li>
                            <li class="mb-2"><strong>Email:</strong> {{ $order->customer_email }}</li>
                            <li class="mb-2"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }}</li>
                            @if($order->shipping_note)
                                <li class="mb-2"><strong>Ghi chú giao:</strong> {{ $order->shipping_note }}</li>
                            @endif
                            @if($order->customer_note)
                                <li class="mb-2"><strong>Ghi chú đơn:</strong> {{ $order->customer_note }}</li>
                            @endif
                        </ul>
                    </div>

                    <div class="order-payment-box p-4 border rounded bg-light">
                        <h2 class="h5 border-bottom pb-2 mb-3">Thanh toán & Trạng thái</h2>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2"><strong>Phương thức:</strong> Thanh toán khi nhận hàng (COD)</li>
                            <li class="mb-2">
                                <strong>Thanh toán:</strong>
                                <span class="badge bg-warning text-dark">Chờ thanh toán khi nhận hàng</span>
                            </li>
                            <li class="mb-2">
                                <strong>Đơn hàng:</strong>
                                <span class="badge bg-secondary">Đang chờ xử lý</span>
                            </li>
                            @if($order->placed_at)
                                <li class="mb-0 text-muted"><strong>Thời gian đặt:</strong> {{ $order->placed_at->format('d/m/Y H:i') }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a class="lunara-button lunara-button--dark px-4 py-2" href="{{ route('products.index') }}">
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
@endsection
