@extends('layouts.app')

@section('title', $isPaid ? 'Thanh toán thành công - Lunara Silver' : 'Kết quả thanh toán - Lunara Silver')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header text-center py-4 border-0 {{ $isPaid ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-dark' }}">
                    @if($isPaid)
                        <div class="mb-3">
                            <span class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle shadow-sm" style="width: 72px; height: 72px;">
                                <i class="bi bi-check-lg" style="font-size: 2.5rem;"></i>
                            </span>
                        </div>
                        <h1 class="h4 fw-bold mb-1">Thanh toán thành công!</h1>
                        <p class="small text-muted mb-0">Cảm ơn quý khách đã tin tưởng và mua sắm tại Lunara Silver.</p>
                    @else
                        <div class="mb-3">
                            <span class="d-inline-flex align-items-center justify-content-center bg-warning text-dark rounded-circle shadow-sm" style="width: 72px; height: 72px;">
                                <i class="bi bi-exclamation-triangle" style="font-size: 2.2rem;"></i>
                            </span>
                        </div>
                        <h1 class="h4 fw-bold mb-1">Thanh toán chưa hoàn tất</h1>
                        <p class="small text-muted mb-0">{{ $message ?: 'Giao dịch chưa được xác nhận thành công.' }}</p>
                    @endif
                </div>

                <div class="card-body p-4">
                    @if(! $checksumValid)
                        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="bi bi-shield-x fs-4"></i>
                            <div>
                                <strong>Cảnh báo bảo mật:</strong> Chữ ký phản hồi từ cổng thanh toán không khớp. Vui lòng không thực hiện lại thao tác này.
                            </div>
                        </div>
                    @endif

                    @if($order)
                        <div class="bg-light p-3 rounded-3 mb-4">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Mã đơn hàng:</span>
                                <strong>{{ $order->order_code }}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Phương thức:</span>
                                <span class="badge bg-primary text-white">VNPay Sandbox</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Số tiền:</span>
                                <strong class="text-primary">{{ number_format($order->grand_total, 0, ',', '.') }} ₫</strong>
                            </div>
                            @if($payment && $payment->vnp_transaction_no)
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Mã giao dịch VNPay:</span>
                                    <code>{{ $payment->vnp_transaction_no }}</code>
                                </div>
                            @endif
                            @if($payment && $payment->vnp_bank_code)
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Ngân hàng / Ví:</span>
                                    <span>{{ $payment->vnp_bank_code }}</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted">Trạng thái thanh toán:</span>
                                <span>
                                    @if($order->payment_status === 'paid')
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Đã thanh toán</span>
                                    @elseif($order->payment_status === 'failed')
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Thất bại</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>{{ $order->payment_status_label }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex flex-column gap-2 mt-4">
                        @if($isPaid && $order)
                            <a href="{{ route('orders.success', $order->order_code) }}" class="btn btn-dark py-2 rounded-3 text-uppercase fw-semibold">
                                <i class="bi bi-receipt me-1"></i> Xem hóa đơn chi tiết
                            </a>
                        @elseif($order && $order->canRetryPayment())
                            <form action="{{ route('payment.vnpay.retry', $order->order_code) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 text-uppercase fw-semibold shadow-sm">
                                    <i class="bi bi-arrow-repeat me-1"></i> Thử thanh toán lại với VNPay
                                </button>
                            </form>
                            @auth
                                <a href="{{ route('account.orders.show', $order->order_code) }}" class="btn btn-outline-secondary py-2 rounded-3">
                                    Xem chi tiết đơn hàng trong tài khoản
                                </a>
                            @endauth
                        @endif

                        <a href="{{ route('products.index') }}" class="btn btn-link text-decoration-none text-muted text-center mt-1">
                            <i class="bi bi-arrow-left me-1"></i> Tiếp tục xem sản phẩm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
