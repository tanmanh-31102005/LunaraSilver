@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')
@section('page_title', 'Đơn hàng')

@section('breadcrumb')
    <li class="active">Đơn hàng</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Quản lý đơn hàng</h2>
            <p class="text-muted small mb-0">Theo dõi, xác nhận và xử lý vòng đời đơn hàng Lunara Silver.</p>
        </div>
    </div>

    {{-- Quick Status Tabs --}}
    <div class="d-flex align-items-center gap-2 overflow-x-auto pb-2 mb-3" style="white-space: nowrap;">
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['order_status', 'page']))) }}"
           class="admin-btn admin-btn--sm {{ empty($currentStatus) ? 'admin-btn--primary' : 'admin-btn--secondary' }}">
            Tất cả ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['order_status' => 'pending'])) }}"
           class="admin-btn admin-btn--sm {{ $currentStatus === 'pending' ? 'admin-btn--primary' : 'admin-btn--secondary' }}">
            Chờ xác nhận ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['order_status' => 'confirmed'])) }}"
           class="admin-btn admin-btn--sm {{ $currentStatus === 'confirmed' ? 'admin-btn--primary' : 'admin-btn--secondary' }}">
            Đã xác nhận ({{ $counts['confirmed'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['order_status' => 'processing'])) }}"
           class="admin-btn admin-btn--sm {{ $currentStatus === 'processing' ? 'admin-btn--primary' : 'admin-btn--secondary' }}">
            Đang xử lý ({{ $counts['processing'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['order_status' => 'shipping'])) }}"
           class="admin-btn admin-btn--sm {{ $currentStatus === 'shipping' ? 'admin-btn--primary' : 'admin-btn--secondary' }}">
            Đang giao ({{ $counts['shipping'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['order_status' => 'completed'])) }}"
           class="admin-btn admin-btn--sm {{ $currentStatus === 'completed' ? 'admin-btn--primary' : 'admin-btn--secondary' }}">
            Hoàn thành ({{ $counts['completed'] }})
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['order_status' => 'cancelled'])) }}"
           class="admin-btn admin-btn--sm {{ $currentStatus === 'cancelled' ? 'admin-btn--primary' : 'admin-btn--secondary' }}">
            Đã hủy ({{ $counts['cancelled'] }})
        </a>
    </div>

    {{-- Filter Toolbar --}}
    <form method="GET" action="{{ route('admin.orders.index') }}" class="admin-toolbar">
        @if (!empty($currentStatus))
            <input type="hidden" name="order_status" value="{{ $currentStatus }}">
        @endif

        <div class="admin-toolbar__search">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-transparent border-end-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text"
                       name="search"
                       class="form-control admin-input border-start-0 ps-0"
                       placeholder="Tìm mã đơn, tên khách, email, SĐT..."
                       value="{{ request('search') }}">
            </div>
        </div>

        <div class="admin-toolbar__filters">
            {{-- Payment Status Filter --}}
            <select name="payment_status" class="admin-select">
                <option value="">Thanh toán: Tất cả</option>
                <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                <option value="cancelled" {{ request('payment_status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Thất bại</option>
            </select>

            {{-- Payment Method Filter --}}
            <select name="payment_method" class="admin-select">
                <option value="">Phương thức: Tất cả</option>
                <option value="cod" {{ request('payment_method') === 'cod' ? 'selected' : '' }}>COD (Tiền mặt)</option>
            </select>

            {{-- Date Range --}}
            <input type="date"
                   name="from"
                   class="admin-input"
                   style="max-width: 135px;"
                   placeholder="Từ ngày"
                   title="Từ ngày đặt"
                   value="{{ request('from') }}">
            <span class="text-muted small">đến</span>
            <input type="date"
                   name="to"
                   class="admin-input"
                   style="max-width: 135px;"
                   placeholder="Đến ngày"
                   title="Đến ngày đặt"
                   value="{{ request('to') }}">

            {{-- Sort Option --}}
            <select name="sort" class="admin-select">
                <option value="">Mới nhất</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                <option value="total_desc" {{ request('sort') === 'total_desc' ? 'selected' : '' }}>Tổng tiền: Cao → Thấp</option>
                <option value="total_asc" {{ request('sort') === 'total_asc' ? 'selected' : '' }}>Tổng tiền: Thấp → Cao</option>
            </select>

            <button type="submit" class="admin-btn admin-btn--primary">
                <i class="bi bi-funnel"></i>
                <span>Lọc</span>
            </button>

            @if(request()->hasAny(['search', 'order_status', 'payment_status', 'payment_method', 'from', 'to', 'sort']))
                <a href="{{ route('admin.orders.index') }}" class="admin-btn admin-btn--secondary" title="Đặt lại bộ lọc">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    <span>Đặt lại</span>
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Orders Data Table --}}
<div class="admin-table-container">
    @if ($orders->isEmpty())
        <div class="text-center py-5">
            <div class="text-muted mb-2"><i class="bi bi-inbox fs-1"></i></div>
            <h6 class="fw-semibold text-dark mb-1">Không tìm thấy đơn hàng nào</h6>
            <p class="text-muted small mb-3">Thử thay đổi từ khóa tìm kiếm hoặc điều kiện lọc ngày/trạng thái.</p>
            @if(request()->hasAny(['search', 'order_status', 'payment_status', 'payment_method', 'from', 'to', 'sort']))
                <a href="{{ route('admin.orders.index') }}" class="admin-btn admin-btn--secondary admin-btn--sm">
                    Xóa bộ lọc
                </a>
            @endif
        </div>
    @else
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th class="text-center">Số món</th>
                        <th class="text-end">Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->order_code) }}" class="fw-semibold text-dark text-decoration-none" style="font-family: monospace; font-size: 0.88rem;">
                                    {{ $order->order_code }}
                                </a>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $order->customer_name }}</div>
                                <div class="text-muted" style="font-size: 0.76rem;">{{ $order->customer_phone }}</div>
                            </td>
                            <td class="text-nowrap text-muted" style="font-size: 0.82rem;">
                                {{ $order->placed_at ? $order->placed_at->format('d/m/Y H:i') : $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-center text-muted" style="font-size: 0.85rem;">
                                {{ $order->items_count }}
                            </td>
                            <td class="text-end fw-semibold text-dark" style="font-size: 0.88rem;">
                                {{ number_format($order->grand_total, 0, ',', '.') }}đ
                            </td>
                            <td>
                                @php
                                    $paymentClass = match($order->payment_status) {
                                        'paid' => 'admin-badge--paid',
                                        'failed' => 'admin-badge--failed',
                                        'cancelled' => 'admin-badge--cancelled',
                                        default => 'admin-badge--pending',
                                    };
                                @endphp
                                <span class="admin-badge admin-badge--dot {{ $paymentClass }}">
                                    {{ $order->payment_status_label }}
                                </span>
                                <div class="text-muted mt-1" style="font-size: 0.72rem; text-transform: uppercase;">
                                    {{ strtoupper($order->payment_method) }}
                                </div>
                            </td>
                            <td>
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
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order->order_code) }}"
                                   class="admin-btn admin-btn--secondary admin-btn--sm"
                                   title="Xem chi tiết đơn hàng">
                                    <i class="bi bi-eye"></i>
                                    <span>Chi tiết</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages() || $orders->total() > 0)
            <div class="admin-card-footer px-3 py-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-2 text-muted small">
                    <i class="bi bi-receipt text-secondary"></i>
                    <span>Hiển thị <strong class="text-dark fw-semibold">{{ $orders->firstItem() ?? 0 }} – {{ $orders->lastItem() ?? 0 }}</strong> trên tổng số <strong class="text-dark fw-semibold">{{ $orders->total() }}</strong> đơn hàng</span>
                </div>
                <div>
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
