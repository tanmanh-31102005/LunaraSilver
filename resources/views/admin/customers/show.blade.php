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
                        <i class="bi bi-receipt me-1"></i> Lịch sử đơn hàng ({{ $counts['orders'] ?? (isset($orders) ? ($orders instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $orders->total() : $orders->count()) : 0) }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-muted fw-medium py-3 px-3 border-0 border-bottom border-2 border-transparent" id="tab-reviews" data-bs-toggle="tab" data-bs-target="#content-reviews" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-star me-1"></i> Đánh giá sản phẩm ({{ $counts['reviews'] ?? 0 }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-muted fw-medium py-3 px-3 border-0 border-bottom border-2 border-transparent" id="tab-support" data-bs-toggle="tab" data-bs-target="#content-support" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-headset me-1"></i> Hỗ trợ &amp; Live Chat ({{ $counts['support'] ?? 0 }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-muted fw-medium py-3 px-3 border-0 border-bottom border-2 border-transparent" id="tab-coupons" data-bs-toggle="tab" data-bs-target="#content-coupons" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-ticket-perforated me-1"></i> Mã giảm giá đã dùng ({{ $counts['coupons'] ?? 0 }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-muted fw-medium py-3 px-3 border-0 border-bottom border-2 border-transparent" id="tab-addresses" data-bs-toggle="tab" data-bs-target="#content-addresses" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-geo-alt me-1"></i> Sổ địa chỉ ({{ $counts['addresses'] ?? 0 }})
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="customer360TabsContent">
                {{-- TAB 1: ORDERS (Preloaded) --}}
                <div class="tab-pane fade show active" id="content-orders" role="tabpanel" aria-labelledby="tab-orders" data-tab="orders" data-loaded="1">
                    @include('admin.customers.tabs.orders', ['orders' => $orders, 'user' => $user])
                </div>

                {{-- TAB 2: REVIEWS (Lazy loaded on click) --}}
                <div class="tab-pane fade" id="content-reviews" role="tabpanel" aria-labelledby="tab-reviews" data-tab="reviews" data-loaded="0">
                    <div class="text-center py-5 text-muted">
                        <div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div>
                        <span class="small">Đang tải đánh giá sản phẩm...</span>
                    </div>
                </div>

                {{-- TAB 3: SUPPORT & CHAT (Lazy loaded on click) --}}
                <div class="tab-pane fade" id="content-support" role="tabpanel" aria-labelledby="tab-support" data-tab="support" data-loaded="0">
                    <div class="text-center py-5 text-muted">
                        <div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div>
                        <span class="small">Đang tải lịch sử hỗ trợ &amp; live chat...</span>
                    </div>
                </div>

                {{-- TAB 4: COUPONS (Lazy loaded on click) --}}
                <div class="tab-pane fade" id="content-coupons" role="tabpanel" aria-labelledby="tab-coupons" data-tab="coupons" data-loaded="0">
                    <div class="text-center py-5 text-muted">
                        <div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div>
                        <span class="small">Đang tải mã giảm giá...</span>
                    </div>
                </div>

                {{-- TAB 5: ADDRESSES (Lazy loaded on click) --}}
                <div class="tab-pane fade" id="content-addresses" role="tabpanel" aria-labelledby="tab-addresses" data-tab="addresses" data-loaded="0">
                    <div class="text-center py-5 text-muted">
                        <div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div>
                        <span class="small">Đang tải danh sách địa chỉ...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('#customer360Tabs button[data-bs-toggle="tab"]');
    tabs.forEach(tabBtn => {
        tabBtn.addEventListener('shown.bs.tab', function() {
            // Update visual active tab indicator
            tabs.forEach(t => {
                t.classList.remove('border-dark');
                t.classList.add('text-muted', 'border-transparent');
            });
            tabBtn.classList.remove('text-muted', 'border-transparent');
            tabBtn.classList.add('border-dark');

            const targetId = tabBtn.getAttribute('data-bs-target');
            const pane = document.querySelector(targetId);
            if (!pane) return;

            const tabName = pane.getAttribute('data-tab');
            const isLoaded = pane.getAttribute('data-loaded');

            if (tabName && isLoaded === '0') {
                const url = '{{ route("admin.customers.tab", ["user" => $user->id, "tab" => ":tab"]) }}'.replace(':tab', tabName);
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => {
                        if (!res.ok) throw new Error('Network error');
                        return res.text();
                    })
                    .then(html => {
                        pane.innerHTML = html;
                        pane.setAttribute('data-loaded', '1');
                    })
                    .catch(() => {
                        pane.innerHTML = '<div class="text-danger small py-4 text-center"><i class="bi bi-exclamation-triangle me-1"></i>Không thể tải dữ liệu tab. Vui lòng tải lại trang.</div>';
                    });
            }
        });
    });
});
</script>
@endpush
