@extends('admin.layouts.app')

@section('title', 'Customer 360 — ' . $user->name . ' | Lunara Admin')
@section('page_title', 'Customer 360')

@section('breadcrumb')
    <li><a href="{{ route('admin.customers.index') }}">Khách hàng</a></li>
    <li class="active">{{ $user->name }}</li>
@endsection

@section('content')
<div class="mb-4">
    {{-- Header Profile Banner --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: var(--radius-md); overflow: hidden;">
        <div class="card-body p-4 bg-white">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold fs-4 text-uppercase flex-shrink-0" style="width: 54px; height: 54px;">
                        {{ mb_substr($user->name ?: 'U', 0, 1) }}
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h2 class="h5 mb-0 fw-bold text-dark">{{ $user->name }}</h2>
                            @if ($summary['segment'] === 'HIGH_VALUE')
                                <span class="badge bg-warning-subtle text-warning-emphasis border rounded-pill px-2 py-1 small"><i class="bi bi-gem me-1"></i>VIP</span>
                            @elseif ($summary['segment'] === 'REPEAT')
                                <span class="badge bg-primary-subtle text-primary border rounded-pill px-2 py-1 small"><i class="bi bi-repeat me-1"></i>Thân thiết</span>
                            @elseif ($summary['segment'] === 'NEW')
                                <span class="badge bg-info-subtle text-info border rounded-pill px-2 py-1 small"><i class="bi bi-stars me-1"></i>Mới</span>
                            @else
                                <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small">Tiêu chuẩn</span>
                            @endif
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-3 text-muted small" style="font-size: 0.8rem;">
                            <span><i class="bi bi-envelope me-1"></i>{{ $user->email }}</span>
                            <span><i class="bi bi-calendar-event me-1"></i>Tham gia: {{ $user->created_at ? $user->created_at->format('d/m/Y') : '—' }}</span>
                            <span><i class="bi bi-shield-check me-1"></i>ID: #{{ $user->id }}</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                        <i class="bi bi-arrow-left"></i>
                        <span>Quay lại</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- CUSTOMER 360 SUMMARY KPI CARDS --}}
    <div class="row g-3 mb-4">
        {{-- Lifetime Spend --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: var(--radius-md);">
                <div class="text-muted small fw-semibold text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Tổng chi tiêu trọn đời</div>
                <div class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">
                    {{ number_format($summary['lifetime_spend'], 0, ',', '.') }}₫
                </div>
                <div class="text-muted small" style="font-size: 0.75rem;">Đơn hoàn thành trừ tiền hoàn</div>
            </div>
        </div>

        {{-- Completed Orders --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: var(--radius-md);">
                <div class="text-muted small fw-semibold text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Đơn hoàn thành</div>
                <div class="h3 fw-bold text-success mb-1" style="letter-spacing: -0.02em;">
                    {{ $summary['completed_orders'] }}
                </div>
                <div class="text-muted small" style="font-size: 0.75rem;">Trên tổng số {{ $summary['total_orders'] }} đơn đã đặt</div>
            </div>
        </div>

        {{-- AOV --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: var(--radius-md);">
                <div class="text-muted small fw-semibold text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Giá trị TB đơn (AOV)</div>
                <div class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">
                    {{ number_format($summary['aov'], 0, ',', '.') }}₫
                </div>
                <div class="text-muted small" style="font-size: 0.75rem;">Trung bình mỗi đơn thành công</div>
            </div>
        </div>

        {{-- Last Order --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: var(--radius-md);">
                <div class="text-muted small fw-semibold text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Lần đặt gần nhất</div>
                @if ($summary['last_order'])
                    <div class="h5 fw-bold text-dark mb-1">
                        {{ $summary['last_order']->created_at ? $summary['last_order']->created_at->format('d/m/Y') : '—' }}
                    </div>
                    <div class="small">
                        <a href="{{ route('admin.orders.show', $summary['last_order']->order_code) }}" class="text-primary text-decoration-none">
                            #{{ $summary['last_order']->order_code }}
                        </a>
                    </div>
                @else
                    <div class="h5 fw-bold text-muted mb-1">—</div>
                    <div class="text-muted small" style="font-size: 0.75rem;">Chưa có đơn hàng nào</div>
                @endif
            </div>
        </div>
    </div>

    {{-- CUSTOMER 360 TABS --}}
    <div class="card border-0 shadow-sm" style="border-radius: var(--radius-md);">
        <div class="card-header bg-white border-bottom p-0">
            <ul class="nav nav-tabs border-0 px-3 pt-2" id="customer360Tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-medium py-3 px-3 border-0 border-bottom border-2 border-dark" id="tab-orders" data-bs-toggle="tab" data-bs-target="#content-orders" type="button" role="tab" aria-selected="true">
                        <i class="bi bi-receipt me-1"></i> Lịch sử đơn hàng ({{ $orders->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-muted fw-medium py-3 px-3 border-0 border-bottom border-2 border-transparent" id="tab-reviews" data-bs-toggle="tab" data-bs-target="#content-reviews" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-star me-1"></i> Đánh giá sản phẩm ({{ $reviews->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-muted fw-medium py-3 px-3 border-0 border-bottom border-2 border-transparent" id="tab-support" data-bs-toggle="tab" data-bs-target="#content-support" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-headset me-1"></i> Hỗ trợ &amp; Live Chat ({{ $contact_messages->count() + $chat_conversations->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-muted fw-medium py-3 px-3 border-0 border-bottom border-2 border-transparent" id="tab-coupons" data-bs-toggle="tab" data-bs-target="#content-coupons" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-ticket-perforated me-1"></i> Mã giảm giá đã dùng ({{ $coupon_usages->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-muted fw-medium py-3 px-3 border-0 border-bottom border-2 border-transparent" id="tab-addresses" data-bs-toggle="tab" data-bs-target="#content-addresses" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-geo-alt me-1"></i> Sổ địa chỉ ({{ $addresses->count() }})
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="customer360TabsContent">
                {{-- TAB 1: ORDERS --}}
                <div class="tab-pane fade show active" id="content-orders" role="tabpanel" aria-labelledby="tab-orders">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Ngày đặt</th>
                                    <th>Sản phẩm</th>
                                    <th>Tổng tiền</th>
                                    <th>Thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th class="text-end">Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $ord)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $ord->order_code) }}" class="fw-bold text-primary text-decoration-none">
                                                #{{ $ord->order_code }}
                                            </a>
                                        </td>
                                        <td class="text-muted small">{{ $ord->created_at ? $ord->created_at->format('d/m/Y H:i') : '' }}</td>
                                        <td>
                                            <div class="small text-truncate" style="max-width: 240px;">
                                                {{ $ord->items->pluck('product_name')->join(', ') }}
                                            </div>
                                            <span class="text-muted" style="font-size: 0.72rem;">{{ $ord->items_count }} món</span>
                                        </td>
                                        <td class="fw-bold text-dark">{{ number_format((float) $ord->grand_total, 0, ',', '.') }}₫</td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ strtoupper($ord->payment_method) }}</span>
                                            <span class="badge {{ $ord->payment_status === 'paid' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-dark' }} border" style="font-size: 0.7rem;">
                                                {{ \App\Models\Order::PAYMENT_STATUS_LABELS[$ord->payment_status] ?? $ord->payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ match($ord->order_status) { 'completed' => 'bg-success', 'pending' => 'bg-warning text-dark', 'cancelled' => 'bg-danger', default => 'bg-secondary' } }} rounded-pill px-2 py-1" style="font-size: 0.72rem;">
                                                {{ \App\Models\Order::STATUS_LABELS[$ord->order_status] ?? $ord->order_status }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.orders.show', $ord->order_code) }}" class="btn btn-sm btn-light border py-1 px-2" title="Mở chi tiết đơn hàng">
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">Khách hàng chưa phát sinh đơn hàng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 2: REVIEWS --}}
                <div class="tab-pane fade" id="content-reviews" role="tabpanel" aria-labelledby="tab-reviews">
                    @forelse ($reviews as $rev)
                        <div class="p-3 border rounded-2 mb-3 bg-light">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold text-dark">{{ $rev->product ? $rev->product->name : 'Sản phẩm' }}</span>
                                    <div class="text-warning small">
                                        @for ($s = 1; $s <= 5; $s++)
                                            <i class="bi {{ $s <= $rev->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <span class="badge {{ $rev->status === 'approved' ? 'bg-success' : ($rev->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }} rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                                    {{ ucfirst($rev->status) }}
                                </span>
                            </div>
                            <p class="mb-1 small text-dark">{{ $rev->comment ?: $rev->content }}</p>
                            <div class="text-muted small" style="font-size: 0.72rem;">{{ $rev->created_at ? $rev->created_at->format('d/m/Y H:i') : '' }}</div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted small">Khách hàng chưa gửi đánh giá nào.</div>
                    @endforelse
                </div>

                {{-- TAB 3: SUPPORT & CHAT --}}
                <div class="tab-pane fade" id="content-support" role="tabpanel" aria-labelledby="tab-support">
                    <h6 class="fw-bold text-dark small text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 0.05em;">Ticket liên hệ / Hỗ trợ</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.82rem;">
                            <thead class="table-light">
                                <tr><th>Mã yêu cầu</th><th>Tiêu đề</th><th>Trạng thái</th><th>Ngày tạo</th><th>Thao tác</th></tr>
                            </thead>
                            <tbody>
                                @forelse ($contact_messages as $cm)
                                    <tr>
                                        <td><span class="fw-bold">#{{ $cm->reference }}</span></td>
                                        <td>{{ $cm->subject }}</td>
                                        <td>
                                            <span class="badge {{ match($cm->status) { 'new' => 'bg-danger', 'in_progress' => 'bg-warning text-dark', 'resolved' => 'bg-success', default => 'bg-secondary' } }}">
                                                {{ \App\Models\ContactMessage::STATUS_LABELS[$cm->status] ?? $cm->status }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">{{ $cm->created_at ? $cm->created_at->format('d/m/Y') : '' }}</td>
                                        <td><a href="{{ route('admin.support.show', $cm->id) }}" class="btn btn-sm btn-light border py-0 px-2 small">Xem ticket</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-3">Không có ticket hỗ trợ nào.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h6 class="fw-bold text-dark small text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 0.05em;">Phiên Live Chat</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.82rem;">
                            <thead class="table-light">
                                <tr><th>Mã phiên</th><th>Trạng thái</th><th>Tin nhắn cuối</th><th>Thao tác</th></tr>
                            </thead>
                            <tbody>
                                @forelse ($chat_conversations as $conv)
                                    <tr>
                                        <td><span class="fw-bold">#{{ $conv->reference }}</span></td>
                                        <td>
                                            <span class="badge {{ match($conv->status) { 'open' => 'bg-warning text-dark', 'assigned' => 'bg-primary', 'resolved' => 'bg-success', default => 'bg-secondary' } }}">
                                                {{ \App\Models\SupportConversation::STATUS_LABELS[$conv->status] ?? $conv->status }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">{{ $conv->last_message_at ? $conv->last_message_at->format('d/m/Y H:i') : '' }}</td>
                                        <td><a href="{{ route('admin.support.chat.show', $conv->id) }}" class="btn btn-sm btn-light border py-0 px-2 small">Mở chat</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-3">Chưa có phiên live chat nào.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 4: COUPONS --}}
                <div class="tab-pane fade" id="content-coupons" role="tabpanel" aria-labelledby="tab-coupons">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.82rem;">
                            <thead class="table-light">
                                <tr><th>Mã Coupon</th><th>Đơn áp dụng</th><th>Thời gian</th><th>Trạng thái</th></tr>
                            </thead>
                            <tbody>
                                @forelse ($coupon_usages as $cu)
                                    <tr>
                                        <td><span class="badge bg-light text-dark border fw-bold">{{ $cu->coupon ? $cu->coupon->code : '—' }}</span></td>
                                        <td>
                                            @if ($cu->order)
                                                <a href="{{ route('admin.orders.show', $cu->order->order_code) }}" class="text-primary text-decoration-none">#{{ $cu->order->order_code }}</a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-muted small">{{ $cu->used_at ? $cu->used_at->format('d/m/Y H:i') : '' }}</td>
                                        <td>
                                            <span class="badge {{ $cu->status === 'applied' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ \App\Models\CouponUsage::STATUS_LABELS[$cu->status] ?? $cu->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Khách hàng chưa sử dụng mã giảm giá nào.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 5: ADDRESSES --}}
                <div class="tab-pane fade" id="content-addresses" role="tabpanel" aria-labelledby="tab-addresses">
                    <div class="row g-3">
                        @forelse ($addresses as $addr)
                            <div class="col-md-6">
                                <div class="p-3 border rounded-2 h-100 bg-light position-relative">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-bold text-dark">{{ $addr->recipient_name }}</span>
                                        @if ($addr->is_default)
                                            <span class="badge bg-dark text-white rounded-pill px-2 py-1" style="font-size: 0.68rem;">Mặc định</span>
                                        @endif
                                    </div>
                                    <div class="small text-muted mb-1"><i class="bi bi-telephone me-1"></i>{{ $addr->phone }}</div>
                                    <div class="small text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $addr->address_line }}, {{ $addr->ward }}, {{ $addr->district }}, {{ $addr->city }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4 text-muted small">Khách hàng chưa lưu địa chỉ nào trong sổ địa chỉ.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
