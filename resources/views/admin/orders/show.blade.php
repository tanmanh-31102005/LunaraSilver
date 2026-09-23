@extends('admin.layouts.app')

@section('title', 'Đơn hàng ' . $order->order_code)
@section('page_title', 'Chi tiết đơn hàng')

@section('breadcrumb')
    <li><a href="{{ route('admin.orders.index') }}">Đơn hàng</a></li>
    <li>/</li>
    <li class="active font-monospace">{{ $order->order_code }}</li>
@endsection

@section('content')
<div class="mb-4">
    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
        <div>
            <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                <a href="{{ route('admin.orders.index') }}" class="admin-btn admin-btn--secondary admin-btn--sm me-2" title="Quay lại danh sách">
                    <i class="bi bi-arrow-left"></i>
                    <span>Danh sách</span>
                </a>
                <h2 class="h5 mb-0 fw-bold text-dark font-monospace">{{ $order->order_code }}</h2>
                @php
                    $statusClass = match($order->order_status) {
                        'pending' => 'admin-badge--pending',
                        'confirmed' => 'admin-badge--confirmed',
                        'processing' => 'admin-badge--processing',
                        'shipping' => 'admin-badge--shipping',
                        'completed' => 'admin-badge--completed',
                        'cancelled' => 'admin-badge--cancelled',
                        default => 'admin-badge--pending',
                    };
                @endphp
                <span class="admin-badge admin-badge--dot {{ $statusClass }}">
                    {{ $order->order_status_label }}
                </span>
            </div>
            <div class="text-muted small mt-1">
                <span>Đặt hàng lúc: <strong>{{ $order->placed_at ? $order->placed_at->format('d/m/Y H:i:s') : $order->created_at->format('d/m/Y H:i:s') }}</strong></span>
                @if ($order->inventory_restored_at)
                    <span class="ms-2 px-2 py-0-5 rounded bg-info-subtle text-info-emphasis border border-info-subtle" style="font-size: 0.74rem;">
                        <i class="bi bi-arrow-counterclockwise"></i> Tồn kho đã hoàn lại lúc {{ $order->inventory_restored_at->format('d/m/Y H:i') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small">Tổng thanh toán:</span>
            <span class="fs-5 fw-bold text-dark font-monospace">{{ number_format($order->grand_total, 0, ',', '.') }}đ</span>
        </div>
    </div>

    {{-- Visual Order Lifecycle Stepper (Thanh tiến trình 5 bước) --}}
    @if ($order->order_status === 'cancelled')
        <div class="alert alert-danger d-flex align-items-center gap-3 p-3 mb-4 rounded-3 border-0 shadow-sm" style="background-color: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444 !important;">
            <i class="bi bi-x-circle-fill fs-3 text-danger flex-shrink-0"></i>
            <div>
                <h6 class="fw-bold mb-1">Đơn hàng này đã bị hủy</h6>
                <div class="small">
                    Đơn hàng đã được đánh dấu hủy và số lượng tồn kho của các sản phẩm đơn/linh kiện bundle đã được hoàn lại an toàn vào kho.
                </div>
            </div>
        </div>
    @else
        @php
            $steps = [
                'pending' => ['title' => 'Chờ xác nhận', 'icon' => 'bi-clock'],
                'confirmed' => ['title' => 'Đã xác nhận', 'icon' => 'bi-check-circle'],
                'processing' => ['title' => 'Đang xử lý', 'icon' => 'bi-gear'],
                'shipping' => ['title' => 'Đang giao hàng', 'icon' => 'bi-truck'],
                'completed' => ['title' => 'Hoàn thành', 'icon' => 'bi-check2-all'],
            ];
            $orderKeys = array_keys($steps);
            $currentIndex = array_search($order->order_status, $orderKeys, true);
            if ($currentIndex === false) $currentIndex = 0;
            $progressPercent = ($currentIndex / (count($orderKeys) - 1)) * 100;
        @endphp
        <div class="admin-stepper">
            <div class="admin-stepper__track"></div>
            <div class="admin-stepper__progress" style="width: calc({{ $progressPercent }}% * (1 - 90px / 100%));"></div>

            @foreach ($steps as $key => $step)
                @php
                    $stepIndex = array_search($key, $orderKeys, true);
                    $stepClass = '';
                    if ($stepIndex < $currentIndex) {
                        $stepClass = 'admin-stepper__step--completed';
                    } elseif ($stepIndex === $currentIndex) {
                        $stepClass = 'admin-stepper__step--active';
                    }
                @endphp
                <div class="admin-stepper__step {{ $stepClass }}">
                    <div class="admin-stepper__node">
                        @if ($stepIndex < $currentIndex)
                            <i class="bi bi-check-lg fs-6"></i>
                        @else
                            <i class="bi {{ $step['icon'] }} fs-6"></i>
                        @endif
                    </div>
                    <div class="admin-stepper__title">{{ $step['title'] }}</div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row g-4">
        {{-- Left Column: Order Items, Components Snapshot & Summary --}}
        <div class="col-lg-8">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h3 class="admin-card-title d-flex align-items-center gap-2">
                        <i class="bi bi-box-seam text-muted"></i>
                        <span>Sản phẩm trong đơn hàng</span>
                    </h3>
                    <span class="admin-badge bg-light text-muted border">{{ $order->items->count() }} mặt hàng</span>
                </div>

                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 55px;">Ảnh</th>
                                <th>Sản phẩm & Snapshot</th>
                                <th>Mã SKU</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Tạm tính</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>
                                        @if ($item->product && $item->product->primaryImage)
                                            <img src="{{ route('media.show', ['path' => $item->product->primaryImage->image_url]) }}"
                                                 alt="{{ $item->product_name }}"
                                                 class="rounded border"
                                                 style="width: 48px; height: 48px; object-fit: cover;">
                                        @else
                                            <div class="rounded border bg-light text-muted d-flex align-items-center justify-content-center"
                                                 style="width: 48px; height: 48px; font-size: 0.85rem;">
                                                <i class="bi bi-gem"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $item->product_name }}</div>
                                        @if ($item->product)
                                            <a href="{{ route('admin.products.edit', $item->product) }}" class="text-muted text-decoration-none small d-inline-flex align-items-center gap-1 mt-1" style="font-size: 0.76rem;" target="_blank">
                                                <span>Xem chi tiết catalog</span>
                                                <i class="bi bi-box-arrow-up-right" style="font-size: 0.7rem;"></i>
                                            </a>
                                        @else
                                            <span class="text-muted small" style="font-size: 0.74rem;">(Sản phẩm gốc đã ngừng kinh doanh)</span>
                                        @endif

                                        {{-- Components Snapshot for Bundles --}}
                                        @if ($item->components->isNotEmpty())
                                            <div class="mt-2 p-2 rounded bg-light border" style="font-size: 0.78rem;">
                                                <div class="text-muted fw-semibold mb-1 d-flex align-items-center gap-1">
                                                    <i class="bi bi-diagram-3"></i>
                                                    <span>Linh kiện cấu thành lúc đặt:</span>
                                                </div>
                                                <ul class="list-unstyled mb-0 ps-1">
                                                    @foreach ($item->components as $component)
                                                        <li class="text-secondary d-flex justify-content-between gap-2 py-0-5">
                                                            <span>• {{ $component->product_name }} <span class="font-monospace text-muted">({{ $component->product_sku }})</span></span>
                                                            <span class="fw-medium font-monospace">{{ $component->quantity_per_item }}x / bộ <span class="text-dark">(Tổng: {{ $component->total_quantity }})</span></span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="font-monospace text-muted" style="font-size: 0.82rem;">
                                        <span class="px-2 py-1 bg-light rounded border">{{ $item->product_sku }}</span>
                                    </td>
                                    <td class="text-end text-dark font-monospace" style="font-size: 0.88rem;">
                                        {{ number_format($item->unit_price, 0, ',', '.') }}đ
                                    </td>
                                    <td class="text-center fw-bold text-dark">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="text-end fw-bold text-dark font-monospace" style="font-size: 0.92rem;">
                                        {{ number_format($item->subtotal, 0, ',', '.') }}đ
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Order Summary Totals --}}
                <div class="p-3 border-top bg-light bg-opacity-40">
                    <div class="d-flex justify-content-end">
                        <div style="min-width: 280px; max-width: 340px; font-size: 0.88rem;">
                            <div class="d-flex justify-content-between py-1 text-muted">
                                <span>Tạm tính hàng hóa:</span>
                                <span class="font-monospace">{{ number_format($order->subtotal, 0, ',', '.') }}đ</span>
                            </div>
                            @if ($order->discount_total > 0)
                                <div class="d-flex justify-content-between py-1 text-danger">
                                    <span>Giảm giá khuyến mãi:</span>
                                    <span class="font-monospace">-{{ number_format($order->discount_total, 0, ',', '.') }}đ</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between py-1 text-muted">
                                <span>Phí vận chuyển:</span>
                                <span class="font-monospace">{{ $order->shipping_fee > 0 ? number_format($order->shipping_fee, 0, ',', '.') . 'đ' : 'Miễn phí' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-top mt-2 fw-bold text-dark fs-6">
                                <span>Tổng cộng thanh toán:</span>
                                <span class="font-monospace text-dark fs-5">{{ number_format($order->grand_total, 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Audit Timeline --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-muted"></i>
                        <span>Lịch sử trạng thái & Kiểm toán (Audit Timeline)</span>
                    </h3>
                </div>
                <div class="admin-card-body">
                    @if ($order->statusHistories->isEmpty())
                        <div class="text-muted small py-2">Chưa có bản ghi lịch sử nào.</div>
                    @else
                        <div class="admin-timeline">
                            @foreach ($order->statusHistories as $history)
                                <div class="admin-timeline__item">
                                    <div class="admin-timeline__dot {{ $loop->first ? 'admin-timeline__dot--active' : '' }}"></div>
                                    <div class="admin-timeline__title">
                                        {{ $history->to_status_label }}
                                        @if ($history->from_status)
                                            <span class="text-muted fw-normal small">(chuyển từ {{ $history->from_status_label }})</span>
                                        @endif
                                    </div>
                                    <div class="admin-timeline__time">
                                        {{ $history->created_at->format('d/m/Y H:i:s') }}
                                        @if ($history->changedBy)
                                            • Thực hiện bởi: <strong class="text-dark">{{ $history->changedBy->name }}</strong>
                                        @else
                                            • Hệ thống tự động
                                        @endif
                                    </div>
                                    @if ($history->note)
                                        <div class="admin-timeline__note">
                                            <i class="bi bi-chat-left-text me-1 text-muted"></i> {{ $history->note }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column: Status Operations, Customer, Shipping & Payment --}}
        <div class="col-lg-4">
            {{-- Workflow Control Box --}}
            <div class="admin-card mb-4" style="border-top: 3px solid #111318;">
                <div class="admin-card-header">
                    <h3 class="admin-card-title d-flex align-items-center gap-2">
                        <i class="bi bi-sliders2 text-muted"></i>
                        <span>Quy trình xử lý đơn</span>
                    </h3>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <div class="text-muted small mb-1">Trạng thái hiện tại:</div>
                        <span class="admin-badge admin-badge--dot {{ $statusClass }} fs-6 py-1-5 px-3">
                            {{ $order->order_status_label }}
                        </span>
                    </div>

                    @if (!empty($allowedTransitions))
                        <div class="border-top pt-3">
                            <div class="text-muted small fw-semibold mb-2">Thao tác hợp lệ tiếp theo:</div>

                            @foreach ($allowedTransitions as $nextStatus)
                                @if ($nextStatus === 'confirmed')
                                    <form method="POST" action="{{ route('admin.orders.status', $order->order_code) }}" class="mb-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="order_status" value="confirmed">
                                        <button type="submit" class="admin-btn admin-btn--primary w-100 justify-content-center py-2">
                                            <i class="bi bi-check-circle"></i>
                                            <span>Xác nhận đơn hàng</span>
                                        </button>
                                    </form>
                                @elseif ($nextStatus === 'processing')
                                    <form method="POST" action="{{ route('admin.orders.status', $order->order_code) }}" class="mb-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="order_status" value="processing">
                                        <button type="submit" class="admin-btn admin-btn--primary w-100 justify-content-center py-2">
                                            <i class="bi bi-gear-wide-connected"></i>
                                            <span>Bắt đầu xử lý đơn</span>
                                        </button>
                                    </form>
                                @elseif ($nextStatus === 'shipping')
                                    <form method="POST" action="{{ route('admin.orders.status', $order->order_code) }}" class="mb-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="order_status" value="shipping">
                                        <button type="submit" class="admin-btn admin-btn--primary w-100 justify-content-center py-2">
                                            <i class="bi bi-truck"></i>
                                            <span>Xuất kho & Giao hàng</span>
                                        </button>
                                    </form>
                                @elseif ($nextStatus === 'completed')
                                    <form method="POST" action="{{ route('admin.orders.status', $order->order_code) }}" class="mb-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="order_status" value="completed">
                                        <button type="submit" class="admin-btn admin-btn--primary w-100 justify-content-center py-2" style="background-color: #059669; border-color: #059669;">
                                            <i class="bi bi-check2-all"></i>
                                            <span>Đánh dấu hoàn thành</span>
                                        </button>
                                    </form>
                                @elseif ($nextStatus === 'cancelled')
                                    <button type="button" class="admin-btn admin-btn--danger-outline w-100 justify-content-center mt-2 py-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                        <i class="bi bi-x-circle"></i>
                                        <span>Hủy đơn hàng...</span>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="border-top pt-3 text-muted small">
                            <i class="bi bi-info-circle me-1"></i>
                            Đơn hàng đã ở trạng thái kết thúc <strong>({{ $order->order_status_label }})</strong>.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Customer Information --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h3 class="admin-card-title d-flex align-items-center gap-2">
                        <i class="bi bi-person text-muted"></i>
                        <span>Thông tin khách hàng</span>
                    </h3>
                </div>
                <div class="admin-card-body" style="font-size: 0.88rem;">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="admin-user-avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">
                            {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold text-dark">{{ $order->customer_name }}</div>
                            <div class="text-muted small">Khách hàng</div>
                        </div>
                    </div>

                    <div class="pt-2 border-top">
                        <div class="d-flex align-items-center gap-2 py-1 text-muted">
                            <i class="bi bi-envelope"></i>
                            <a href="mailto:{{ $order->customer_email }}" class="text-dark text-decoration-none">{{ $order->customer_email }}</a>
                        </div>
                        <div class="d-flex align-items-center gap-2 py-1 text-muted">
                            <i class="bi bi-telephone"></i>
                            <a href="tel:{{ $order->customer_phone }}" class="text-dark text-decoration-none font-monospace">{{ $order->customer_phone }}</a>
                        </div>
                    </div>

                    @if ($order->user)
                        <div class="pt-2 mt-1 border-top text-muted small">
                            <span>Tài khoản thành viên: </span>
                            <span class="fw-semibold text-dark">{{ $order->user->name }}</span>
                        </div>
                    @else
                        <div class="pt-2 mt-1 border-top text-muted small">
                            <span>(Khách vãng lai chưa tạo tài khoản)</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Shipping Information --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h3 class="admin-card-title d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt text-muted"></i>
                        <span>Địa chỉ nhận hàng</span>
                    </h3>
                </div>
                <div class="admin-card-body" style="font-size: 0.88rem;">
                    @php
                        $shipping = $order->shipping_snapshot ?? [];
                    @endphp
                    <div class="fw-semibold text-dark mb-1">{{ $shipping['recipient_name'] ?? $order->customer_name }}</div>
                    <div class="text-muted font-monospace mb-2" style="font-size: 0.82rem;">{{ $shipping['phone'] ?? $order->customer_phone }}</div>
                    <div class="text-dark py-1">
                        {{ $shipping['address_line'] ?? '' }}
                        @if (!empty($shipping['ward'])), {{ $shipping['ward'] }}@endif
                        @if (!empty($shipping['district'])), {{ $shipping['district'] }}@endif
                        @if (!empty($shipping['city'])), {{ $shipping['city'] }}@endif
                    </div>

                    @if ($order->shipping_note)
                        <div class="mt-2 p-2 rounded bg-light border text-muted small">
                            <span class="fw-bold text-dark">Ghi chú giao hàng:</span> {{ $order->shipping_note }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Payment Information --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title d-flex align-items-center gap-2">
                        <i class="bi bi-credit-card text-muted"></i>
                        <span>Thanh toán</span>
                    </h3>
                </div>
                <div class="admin-card-body" style="font-size: 0.88rem;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Phương thức:</span>
                        <span class="fw-semibold text-dark">{{ strtoupper($order->payment_method) }} (Tiền mặt khi nhận)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Trạng thái:</span>
                        @php
                            $payClass = match($order->payment_status) {
                                'paid' => 'admin-badge--paid',
                                'failed' => 'admin-badge--failed',
                                'cancelled' => 'admin-badge--cancelled',
                                default => 'admin-badge--pending',
                            };
                        @endphp
                        <span class="admin-badge admin-badge--dot {{ $payClass }}">
                            {{ $order->payment_status_label }}
                        </span>
                    </div>
                    @if ($order->payment && $order->payment->paid_at)
                        <div class="d-flex justify-content-between align-items-center text-muted small pt-2 border-top">
                            <span>Thời điểm thanh toán:</span>
                            <span class="font-monospace text-dark">{{ $order->payment->paid_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cancel Order Modal --}}
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
            <form method="POST" action="{{ route('admin.orders.cancel', $order->order_code) }}">
                @csrf
                <div class="modal-header py-3 px-3 border-bottom bg-danger-subtle text-danger-emphasis">
                    <h6 class="modal-title fw-bold d-flex align-items-center gap-2" id="cancelOrderModalLabel">
                        <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                        <span>Xác nhận hủy đơn hàng</span>
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body py-3 px-3">
                    <p class="small text-dark mb-3">
                        Bạn có chắc chắn muốn hủy đơn hàng <strong class="font-monospace">{{ $order->order_code }}</strong>?
                    </p>
                    <div class="p-2 mb-3 rounded bg-warning bg-opacity-10 border border-warning-subtle text-dark small">
                        <i class="bi bi-info-circle text-warning-emphasis me-1"></i>
                        <strong>Hoàn tồn kho:</strong> Hệ thống sẽ tự động hoàn trả số lượng các linh kiện/sản phẩm đơn cấu thành đơn hàng này về kho.
                    </div>
                    <div class="mb-2">
                        <label for="cancel_note" class="form-label small fw-semibold text-dark">Lý do hủy đơn (tùy chọn):</label>
                        <textarea name="note" id="cancel_note" rows="3" class="form-control admin-input h-auto" placeholder="Nhập lý do hủy (khách yêu cầu, không liên lạc được,...)"></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2 px-3 border-top gap-2 bg-light">
                    <button type="button" class="admin-btn admin-btn--secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="admin-btn admin-btn--danger">
                        <i class="bi bi-x-circle"></i>
                        <span>Xác nhận hủy đơn</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
