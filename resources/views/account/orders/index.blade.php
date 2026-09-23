@extends('layouts.account')

@section('title', 'Lịch sử đơn hàng | Lunara Silver')

@php
    $accountBreadcrumbs = [['label' => 'Đơn hàng']];
@endphp

@section('account_content')
<div class="account-orders">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold">Lịch sử đơn hàng</h2>
            <p class="text-muted small mb-0">Theo dõi trạng thái xử lý và giao hàng cho các đơn hàng của bạn.</p>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="card border-0 shadow-sm rounded-3 p-5 text-center bg-white">
            <div class="mb-3 text-muted" style="font-size: 3rem;"><i class="bi bi-box-seam"></i></div>
            <h3 class="h5 text-muted mb-2">Bạn chưa có đơn hàng nào.</h3>
            <p class="small text-muted mb-4">Các đơn hàng bạn đã đặt sẽ hiển thị đầy đủ tại đây.</p>
            <div>
                <a href="{{ route('products.index') }}" class="lunara-button lunara-button--dark py-2 px-4">
                    <i class="bi bi-gem me-1"></i> Tiếp tục mua sắm
                </a>
            </div>
        </div>
    @else
        <!-- Desktop Table View -->
        <div class="card border-0 shadow-sm rounded-3 bg-white d-none d-md-block overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" aria-label="Bảng lịch sử đơn hàng">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th scope="col" class="py-3 px-3">Mã đơn hàng</th>
                            <th scope="col" class="py-3">Ngày đặt</th>
                            <th scope="col" class="py-3 text-center">Số lượng</th>
                            <th scope="col" class="py-3">Tổng thanh toán</th>
                            <th scope="col" class="py-3">Thanh toán</th>
                            <th scope="col" class="py-3">Trạng thái đơn</th>
                            <th scope="col" class="py-3 text-end px-3">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="px-3">
                                    <span class="fw-bold font-monospace text-dark">{{ $order->order_code }}</span>
                                </td>
                                <td class="small text-muted">
                                    {{ $order->placed_at ? $order->placed_at->format('H:i d/m/Y') : $order->created_at->format('H:i d/m/Y') }}
                                </td>
                                <td class="text-center small">
                                    {{ $order->items_count }} sản phẩm
                                </td>
                                <td>
                                    <strong class="text-dark">{{ number_format($order->grand_total, 0, ',', '.') }} ₫</strong>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border small">
                                        {{ $order->payment_status_label }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($order->order_status) {
                                            'pending' => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                                            'confirmed' => 'bg-info-subtle text-info border border-info-subtle',
                                            'processing' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                            'shipping' => 'bg-warning-subtle text-warning border border-warning-subtle',
                                            'completed' => 'bg-success-subtle text-success border border-success-subtle',
                                            'cancelled' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                            default => 'bg-secondary text-white',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} small">
                                        {{ $order->order_status_label }}
                                    </span>
                                </td>
                                <td class="text-end px-3">
                                    <a href="{{ route('account.orders.show', $order->order_code) }}" class="btn btn-sm btn-outline-dark py-1 px-3 small">
                                        Chi tiết
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Cards View -->
        <div class="d-flex flex-column gap-3 d-md-none mb-4">
            @foreach($orders as $order)
                <div class="card border-0 shadow-sm rounded-3 bg-white p-3">
                    <div class="d-flex justify-content-between align-items-start border-bottom pb-2 mb-2">
                        <div>
                            <span class="fw-bold font-monospace text-dark">{{ $order->order_code }}</span>
                            <div class="text-muted small">
                                {{ $order->placed_at ? $order->placed_at->format('H:i d/m/Y') : $order->created_at->format('H:i d/m/Y') }}
                            </div>
                        </div>
                        <div>
                            <span class="badge bg-secondary-subtle text-dark border small">
                                {{ $order->order_status_label }}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <small class="text-muted d-block">{{ $order->items_count }} sản phẩm</small>
                            <strong class="text-dark">{{ number_format($order->grand_total, 0, ',', '.') }} ₫</strong>
                        </div>
                        <span class="badge bg-light text-dark border small">
                            {{ $order->payment_status_label }}
                        </span>
                    </div>
                    <div>
                        <a href="{{ route('account.orders.show', $order->order_code) }}" class="lunara-button lunara-button--outline w-100 py-2 small text-center">
                            Xem chi tiết đơn hàng
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
