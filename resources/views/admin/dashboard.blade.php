@extends('admin.layouts.app')

@section('title', 'Bảng điều khiển vận hành & Phân tích')
@section('page_title', 'Bảng điều khiển')

@section('breadcrumb')
    <li class="active">Tổng quan &amp; Phân tích</li>
@endsection

@section('content')
<div class="mb-4">
    {{-- Header with Date Range Filter & Data Export Center --}}
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Bảng điều khiển &amp; Chỉ số vận hành</h2>
            <p class="text-muted small mb-0">Dữ liệu tài chính, bán hàng và tồn kho thời gian thực — Múi giờ: Asia/Ho_Chi_Minh.</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            {{-- Date Range Selector Form --}}
            <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex flex-wrap align-items-center gap-2" id="adminDateRangeForm">
                <div class="dropdown">
                    <button class="btn btn-sm btn-white border shadow-sm dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.82rem; height: 36px;">
                        <i class="bi bi-calendar3 text-muted"></i>
                        <span class="fw-medium">{{ $ranges['label'] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border" style="font-size: 0.85rem;">
                        <li><a class="dropdown-item {{ $ranges['range'] === 'today' ? 'active fw-bold' : '' }}" href="{{ route('admin.dashboard', ['range' => 'today']) }}">Hôm nay</a></li>
                        <li><a class="dropdown-item {{ $ranges['range'] === '7d' ? 'active fw-bold' : '' }}" href="{{ route('admin.dashboard', ['range' => '7d']) }}">7 ngày qua</a></li>
                        <li><a class="dropdown-item {{ $ranges['range'] === '30d' ? 'active fw-bold' : '' }}" href="{{ route('admin.dashboard', ['range' => '30d']) }}">30 ngày qua (Mặc định)</a></li>
                        <li><a class="dropdown-item {{ $ranges['range'] === '90d' ? 'active fw-bold' : '' }}" href="{{ route('admin.dashboard', ['range' => '90d']) }}">90 ngày qua</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <button class="dropdown-item" type="button" data-bs-toggle="collapse" data-bs-target="#customDateCollapse" aria-expanded="{{ $ranges['range'] === 'custom' ? 'true' : 'false' }}">
                                <i class="bi bi-sliders me-1"></i> Tùy chỉnh ngày...
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="collapse {{ $ranges['range'] === 'custom' ? 'show' : '' }}" id="customDateCollapse">
                    <div class="d-flex align-items-center gap-1 bg-light p-1 rounded border">
                        <input type="hidden" name="range" value="custom">
                        <input type="date" name="from" value="{{ request('from', $ranges['start']->format('Y-m-d')) }}" class="form-control form-control-sm border-0 shadow-none px-2 py-1" style="font-size: 0.8rem; width: 130px;" aria-label="Từ ngày">
                        <span class="text-muted small">—</span>
                        <input type="date" name="to" value="{{ request('to', $ranges['end']->format('Y-m-d')) }}" class="form-control form-control-sm border-0 shadow-none px-2 py-1" style="font-size: 0.8rem; width: 130px;" aria-label="Đến ngày">
                        <button type="submit" class="btn btn-sm btn-dark px-2 py-1" style="font-size: 0.8rem;"><i class="bi bi-check2"></i> Lọc</button>
                    </div>
                </div>
            </form>

            {{-- Export Center Dropdown --}}
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2 shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.82rem; height: 36px;">
                    <i class="bi bi-download"></i>
                    <span>Xuất báo cáo</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border" style="font-size: 0.85rem;">
                    <li><h6 class="dropdown-header text-uppercase small" style="font-size: 0.7rem;">Xuất dữ liệu CSV (UTF-8)</h6></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.export', ['type' => 'revenue', 'range' => $ranges['range'], 'from' => request('from'), 'to' => request('to')]) }}"><i class="bi bi-graph-up text-muted"></i> Báo cáo doanh thu kỳ này</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.export', ['type' => 'orders', 'from' => request('from'), 'to' => request('to')]) }}"><i class="bi bi-receipt text-muted"></i> Danh sách đơn hàng</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.export', ['type' => 'inventory']) }}"><i class="bi bi-box-seam text-muted"></i> Tồn kho &amp; Combo</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.export', ['type' => 'customers']) }}"><i class="bi bi-people text-muted"></i> Danh bạ khách hàng</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.export', ['type' => 'products']) }}"><i class="bi bi-tags text-muted"></i> Toàn bộ catalog sản phẩm</a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.export', ['type' => 'coupons']) }}"><i class="bi bi-ticket-perforated text-muted"></i> Hiệu suất mã giảm giá</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Operational Catalog Summary Bar --}}
    <div class="d-flex flex-wrap align-items-center gap-3 mb-4 p-2 px-3 bg-white rounded border shadow-sm small text-muted">
        <div>
            <span class="text-secondary fw-semibold">Tổng sản phẩm:</span>
            <strong class="text-dark">{{ number_format($metrics['total_products']) }}</strong>
        </div>
        <div class="text-muted opacity-50">•</div>
        <div>
            <span class="text-secondary fw-semibold">Đang mở bán:</span>
            <strong class="text-success">{{ number_format($metrics['active_products']) }}</strong>
        </div>
        <div class="text-muted opacity-50">•</div>
        <div>
            <span class="text-secondary fw-semibold">Tổng danh mục:</span>
            <strong class="text-dark">{{ number_format($metrics['total_categories']) }}</strong>
        </div>
        <div class="text-muted opacity-50">•</div>
        <div>
            <span class="text-secondary fw-semibold">Tổng đơn hàng:</span>
            <strong class="text-dark">{{ number_format($metrics['total_orders']) }}</strong>
        </div>
        <div class="text-muted opacity-50">•</div>
        <div>
            <span class="text-secondary fw-semibold">Khách hàng:</span>
            <strong class="text-dark">{{ number_format($metrics['total_customers']) }}</strong>
        </div>
    </div>

    {{-- LAYER 1: PRIMARY KPI CARDS (NET REVENUE, COMPLETED ORDERS, AOV, UNITS SOLD) --}}
    <div class="row g-3 mb-4">
        {{-- Net Revenue --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: var(--radius-md); background: #ffffff;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.05em;">Doanh thu thuần</span>
                    <span class="badge bg-primary-subtle text-primary border rounded-pill px-2 py-1" style="font-size: 0.68rem;"><i class="bi bi-cash-coin me-1"></i>Thực thu</span>
                </div>
                <div class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">
                    {{ number_format($metrics['net_revenue']['current'], 0, ',', '.') }}₫
                </div>
                <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top small" style="font-size: 0.75rem;">
                    <div class="text-muted text-truncate me-2" title="Gộp: {{ number_format($metrics['gross_sales']['current'], 0, ',', '.') }}₫ | Hoàn: {{ number_format($metrics['refund_amount']['current'], 0, ',', '.') }}₫">
                        Gộp: {{ number_format($metrics['gross_sales']['current'], 0, ',', '.') }}₫
                    </div>
                    @if ($metrics['net_revenue']['change'] !== null)
                        <span class="{{ $metrics['net_revenue']['change'] >= 0 ? 'text-success' : 'text-danger' }} fw-semibold flex-shrink-0">
                            <i class="bi {{ $metrics['net_revenue']['change'] >= 0 ? 'bi-arrow-up-right' : 'bi-arrow-down-right' }}"></i>
                            {{ $metrics['net_revenue']['change'] >= 0 ? '+' : '' }}{{ $metrics['net_revenue']['change'] }}%
                        </span>
                    @else
                        <span class="text-muted fw-semibold flex-shrink-0" title="Kỳ trước không có dữ liệu so sánh">—</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Completed Orders --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: var(--radius-md); background: #ffffff;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.05em;">Đơn hoàn thành</span>
                    <span class="badge bg-success-subtle text-success border rounded-pill px-2 py-1" style="font-size: 0.68rem;"><i class="bi bi-check-circle me-1"></i>Completed</span>
                </div>
                <div class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">
                    {{ number_format($metrics['completed_orders']['current']) }}
                </div>
                <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top small" style="font-size: 0.75rem;">
                    <div class="text-muted text-truncate me-2">
                        Kỳ trước: {{ number_format($metrics['completed_orders']['previous']) }} đơn
                    </div>
                    @if ($metrics['completed_orders']['change'] !== null)
                        <span class="{{ $metrics['completed_orders']['change'] >= 0 ? 'text-success' : 'text-danger' }} fw-semibold flex-shrink-0">
                            <i class="bi {{ $metrics['completed_orders']['change'] >= 0 ? 'bi-arrow-up-right' : 'bi-arrow-down-right' }}"></i>
                            {{ $metrics['completed_orders']['change'] >= 0 ? '+' : '' }}{{ $metrics['completed_orders']['change'] }}%
                        </span>
                    @else
                        <span class="text-muted fw-semibold flex-shrink-0">—</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Average Order Value (AOV) --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: var(--radius-md); background: #ffffff;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.05em;">Giá trị TB đơn (AOV)</span>
                    <span class="badge bg-info-subtle text-info border rounded-pill px-2 py-1" style="font-size: 0.68rem;"><i class="bi bi-calculator me-1"></i>AOV</span>
                </div>
                <div class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">
                    {{ number_format($metrics['aov']['current'], 0, ',', '.') }}₫
                </div>
                <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top small" style="font-size: 0.75rem;">
                    <div class="text-muted text-truncate me-2">
                        Kỳ trước: {{ number_format($metrics['aov']['previous'], 0, ',', '.') }}₫
                    </div>
                    @if ($metrics['aov']['change'] !== null)
                        <span class="{{ $metrics['aov']['change'] >= 0 ? 'text-success' : 'text-danger' }} fw-semibold flex-shrink-0">
                            <i class="bi {{ $metrics['aov']['change'] >= 0 ? 'bi-arrow-up-right' : 'bi-arrow-down-right' }}"></i>
                            {{ $metrics['aov']['change'] >= 0 ? '+' : '' }}{{ $metrics['aov']['change'] }}%
                        </span>
                    @else
                        <span class="text-muted fw-semibold flex-shrink-0">—</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Units Sold --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: var(--radius-md); background: #ffffff;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-semibold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.05em;">Sản phẩm đã bán</span>
                    <span class="badge bg-warning-subtle text-warning-emphasis border rounded-pill px-2 py-1" style="font-size: 0.68rem;"><i class="bi bi-gem me-1"></i>Sản lượng</span>
                </div>
                <div class="h3 fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">
                    {{ number_format($metrics['units_sold']['current']) }}
                </div>
                <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top small" style="font-size: 0.75rem;">
                    <div class="text-muted text-truncate me-2">
                        Kỳ trước: {{ number_format($metrics['units_sold']['previous']) }} món
                    </div>
                    @if ($metrics['units_sold']['change'] !== null)
                        <span class="{{ $metrics['units_sold']['change'] >= 0 ? 'text-success' : 'text-danger' }} fw-semibold flex-shrink-0">
                            <i class="bi {{ $metrics['units_sold']['change'] >= 0 ? 'bi-arrow-up-right' : 'bi-arrow-down-right' }}"></i>
                            {{ $metrics['units_sold']['change'] >= 0 ? '+' : '' }}{{ $metrics['units_sold']['change'] }}%
                        </span>
                    @else
                        <span class="text-muted fw-semibold flex-shrink-0">—</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ATTENTION CENTER (CẦN XỬ LÝ) --}}
    @if (!empty($attentionItems))
        <div class="card border-0 shadow-sm mb-4" style="border-radius: var(--radius-md); overflow: hidden;">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-danger text-white rounded-pill px-2 py-1" style="font-size: 0.7rem;">CẦN XỬ LÝ</span>
                    <h3 class="h6 mb-0 fw-bold text-dark">Trung tâm kiểm soát vận hành (Attention Center)</h3>
                </div>
                <span class="text-muted small">Có {{ count($attentionItems) }} nhóm nghiệp vụ cần bạn can thiệp</span>
            </div>
            <div class="card-body p-3 p-md-4 bg-light">
                <div class="row g-3">
                    @foreach ($attentionItems as $item)
                        <div class="col-md-6 col-xl-4">
                            <a href="{{ $item['url'] }}" class="card h-100 text-decoration-none border shadow-none bg-white p-3 rounded-2 transition-all hover-shadow">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi {{ $item['icon'] }} fs-5 {{ $item['level'] === 'critical' ? 'text-danger' : ($item['level'] === 'warning' ? 'text-warning' : 'text-primary') }}"></i>
                                        <span class="fw-bold text-dark small">{{ $item['title'] }}</span>
                                    </div>
                                    <span class="badge {{ $item['badge_class'] }} rounded-pill px-2 py-1" style="font-size: 0.72rem;">{{ $item['count'] }}</span>
                                </div>
                                <p class="text-muted small mb-0" style="font-size: 0.78rem;">{{ $item['description'] }}</p>
                                <div class="mt-2 pt-2 border-top d-flex align-items-center justify-content-end text-primary small fw-semibold" style="font-size: 0.74rem;">
                                    <span>Xử lý ngay</span>
                                    <i class="bi bi-chevron-right ms-1"></i>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- LAYER 2: CHARTS & DISTRIBUTIONS --}}
    <div class="row g-4 mb-4">
        {{-- Revenue Trend Chart --}}
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100 p-3 p-md-4" style="border-radius: var(--radius-md);">
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-3 pb-2 border-bottom">
                    <div>
                        <h3 class="h6 mb-0 fw-bold text-dark">Xu hướng doanh thu (Revenue Trend)</h3>
                        <span class="text-muted small" style="font-size: 0.78rem;">Thực thu sau hoàn tiền theo chu kỳ {{ $ranges['label'] }}</span>
                    </div>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Toggle series">
                        <button type="button" class="btn btn-outline-dark active" id="btnToggleNet">Doanh thu thuần</button>
                        <button type="button" class="btn btn-outline-dark" id="btnToggleGross">Doanh số gộp</button>
                    </div>
                </div>

                {{-- Chart Canvas Container --}}
                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="revenueTrendChart"></canvas>
                </div>

                {{-- Fallback Table for Screen Readers or No-JS --}}
                <noscript>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-bordered small">
                            <thead><tr><th>Thời gian</th><th>Doanh số gộp</th><th>Doanh thu thuần</th></tr></thead>
                            <tbody>
                                @foreach ($revenueTrend['labels'] as $idx => $label)
                                    <tr>
                                        <td>{{ $label }}</td>
                                        <td>{{ number_format($revenueTrend['gross_sales'][$idx] ?? 0) }}₫</td>
                                        <td>{{ number_format($revenueTrend['net_revenue'][$idx] ?? 0) }}₫</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </noscript>
            </div>
        </div>

        {{-- Orders by Status & Payment Breakdown --}}
        <div class="col-xl-4">
            <div class="d-flex flex-column gap-4 h-100">
                {{-- Orders by Status --}}
                <div class="card border-0 shadow-sm p-3 p-md-4 flex-grow-1" style="border-radius: var(--radius-md);">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h3 class="h6 mb-0 fw-bold text-dark">Phân bổ trạng thái đơn</h3>
                        <a href="{{ route('admin.orders.index') }}" class="text-decoration-none small text-primary fw-semibold" style="font-size: 0.75rem;">Xem tất cả</a>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        @foreach ($ordersByStatus as $statusKey => $st)
                            <a href="{{ route('admin.orders.index', ['order_status' => $statusKey]) }}" class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none bg-light text-dark hover-bg-secondary-subtle">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge rounded-circle p-1 {{ match($statusKey) { 'completed' => 'bg-success', 'pending' => 'bg-warning', 'cancelled' => 'bg-danger', default => 'bg-secondary' } }}" style="width: 8px; height: 8px;"></span>
                                    <span class="small fw-medium">{{ $st['label'] }}</span>
                                </div>
                                <span class="badge bg-white text-dark border rounded-pill px-2 py-1 small">{{ $st['count'] }} đơn</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Payment Methods --}}
                <div class="card border-0 shadow-sm p-3 p-md-4" style="border-radius: var(--radius-md);">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h3 class="h6 mb-0 fw-bold text-dark">Phương thức thanh toán</h3>
                        <span class="text-muted small" style="font-size: 0.72rem;">{{ $ranges['label'] }}</span>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        @foreach ($paymentBreakdown as $payKey => $pb)
                            <div class="p-2 border rounded-2 d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="fw-semibold small text-dark">{{ $pb['label'] }}</div>
                                    <div class="text-muted" style="font-size: 0.72rem;">{{ $pb['orders_count'] }} giao dịch</div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold small text-dark">{{ number_format($pb['total_amount'], 0, ',', '.') }}₫</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- LAYER 3: TOP PRODUCTS & INVENTORY HEALTH --}}
    <div class="row g-4 mb-4">
        {{-- Top Products Table --}}
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100 p-3 p-md-4" style="border-radius: var(--radius-md);">
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-3 pb-2 border-bottom">
                    <div>
                        <h3 class="h6 mb-0 fw-bold text-dark">Top sản phẩm bán chạy</h3>
                        <span class="text-muted small" style="font-size: 0.75rem;">Chỉ tính đơn hoàn thành (Completed)</span>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['top_sort' => 'units'])) }}" class="btn btn-outline-secondary {{ $topSort === 'units' ? 'active' : '' }}" style="font-size: 0.75rem;">Theo số lượng</a>
                        <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['top_sort' => 'revenue'])) }}" class="btn btn-outline-secondary {{ $topSort === 'revenue' ? 'active' : '' }}" style="font-size: 0.75rem;">Theo doanh thu</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 45%;">Sản phẩm</th>
                                <th class="text-center">Đã bán</th>
                                <th class="text-end">Doanh thu</th>
                                <th class="text-center">Số đơn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topProducts as $tp)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($tp->product && $tp->product->primaryImage)
                                                <img src="{{ $tp->product->primaryImage->image_url }}" alt="" class="rounded border object-fit-cover" style="width: 32px; height: 32px;">
                                            @else
                                                <div class="bg-light rounded border d-flex align-items-center justify-content-center text-muted" style="width: 32px; height: 32px;"><i class="bi bi-gem"></i></div>
                                            @endif
                                            <div class="text-truncate">
                                                <a href="{{ $tp->product ? route('admin.products.edit', $tp->product->id) : '#' }}" class="fw-semibold text-dark text-decoration-none text-truncate d-block">
                                                    {{ $tp->product_name }}
                                                </a>
                                                <div class="text-muted" style="font-size: 0.72rem;">SKU: {{ $tp->product_sku }} @if (!$tp->is_active) <span class="badge bg-secondary-subtle text-secondary py-0 px-1">Tạm ẩn</span> @endif</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold">{{ number_format($tp->units_sold) }}</td>
                                    <td class="text-end fw-bold text-dark">{{ number_format($tp->total_revenue, 0, ',', '.') }}₫</td>
                                    <td class="text-center text-muted">{{ number_format($tp->total_orders) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Chưa có dữ liệu bán hàng trong kỳ này.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Inventory Health --}}
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100 p-3 p-md-4" style="border-radius: var(--radius-md);">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <div>
                        <h3 class="h6 mb-0 fw-bold text-dark">Sức khỏe tồn kho (Inventory Health)</h3>
                        <span class="text-muted small" style="font-size: 0.75rem;">Ngưỡng cảnh báo: &le; {{ $inventoryHealth['threshold'] }} cái</span>
                    </div>
                    <a href="{{ route('admin.products.index', ['stock_status' => 'low_stock']) }}" class="text-decoration-none small text-primary fw-semibold" style="font-size: 0.75rem;">Quản lý kho</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm / Bộ quà</th>
                                <th class="text-center">Loại</th>
                                <th class="text-center">Tồn khả dụng</th>
                                <th>Ghi chú giới hạn</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Troubled Bundles first --}}
                            @foreach ($inventoryHealth['troubled_bundles'] as $tb)
                                <tr>
                                    <td>
                                        <a href="{{ $tb['url'] }}" class="fw-semibold text-dark text-decoration-none">{{ $tb['name'] }}</a>
                                        <div class="text-muted" style="font-size: 0.72rem;">SKU: {{ $tb['sku'] }}</div>
                                    </td>
                                    <td class="text-center"><span class="badge bg-purple-subtle text-purple border rounded-pill px-2 py-1" style="font-size: 0.68rem; background: #f3e8ff; color: #7e22ce;">Bộ/Combo</span></td>
                                    <td class="text-center fw-bold {{ $tb['available'] <= 0 ? 'text-danger' : 'text-warning' }}">{{ $tb['available'] }}</td>
                                    <td>
                                        @if ($tb['limiting_component'])
                                            <span class="small text-danger d-block" style="font-size: 0.74rem;">
                                                <i class="bi bi-exclamation-triangle"></i> Thiếu: {{ $tb['limiting_component']['sku'] }} (còn {{ $tb['limiting_component']['stock'] }})
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Low stock singles --}}
                            @foreach ($inventoryHealth['low_stock_singles'] as $ls)
                                <tr>
                                    <td>
                                        <a href="{{ $ls['url'] }}" class="fw-semibold text-dark text-decoration-none">{{ $ls['name'] }}</a>
                                        <div class="text-muted" style="font-size: 0.72rem;">SKU: {{ $ls['sku'] }}</div>
                                    </td>
                                    <td class="text-center"><span class="badge bg-light text-dark border rounded-pill px-2 py-1" style="font-size: 0.68rem;">Đơn lẻ</span></td>
                                    <td class="text-center fw-bold text-warning">{{ $ls['available'] }}</td>
                                    <td><span class="badge bg-warning-subtle text-warning-emphasis border">Sắp hết hàng</span></td>
                                </tr>
                            @endforeach

                            @if (empty($inventoryHealth['troubled_bundles']) && empty($inventoryHealth['low_stock_singles']))
                                <tr>
                                    <td colspan="4" class="text-center text-success py-4">
                                        <i class="bi bi-check-circle fs-4 d-block mb-1"></i>
                                        Tất cả sản phẩm và bộ quà tặng đều đang có mức tồn an toàn.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- LAYER 4: RECENT ORDERS --}}
    <div class="card border-0 shadow-sm p-3 p-md-4" style="border-radius: var(--radius-md);">
        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
            <div>
                <h3 class="h6 mb-0 fw-bold text-dark">Đơn hàng mới nhất</h3>
                <span class="text-muted small" style="font-size: 0.75rem;">8 đơn đặt gần nhất trên hệ thống</span>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-dark" style="font-size: 0.78rem;">Xem tất cả đơn hàng</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái đơn</th>
                        <th>Thời gian</th>
                        <th class="text-end">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentOrders as $ro)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $ro->order_code) }}" class="fw-bold text-primary text-decoration-none">
                                    #{{ $ro->order_code }}
                                </a>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $ro->customer_name }}</div>
                                <div class="text-muted" style="font-size: 0.74rem;">{{ $ro->customer_phone ?: $ro->customer_email }}</div>
                            </td>
                            <td class="fw-bold text-dark">{{ number_format((float) $ro->grand_total, 0, ',', '.') }}₫</td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ strtoupper($ro->payment_method) }}</span>
                                <span class="badge {{ $ro->payment_status === 'paid' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-dark' }} border" style="font-size: 0.7rem;">
                                    {{ \App\Models\Order::PAYMENT_STATUS_LABELS[$ro->payment_status] ?? $ro->payment_status }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ match($ro->order_status) { 'completed' => 'bg-success', 'pending' => 'bg-warning text-dark', 'cancelled' => 'bg-danger', default => 'bg-secondary' } }} rounded-pill px-2 py-1" style="font-size: 0.72rem;">
                                    {{ \App\Models\Order::STATUS_LABELS[$ro->order_status] ?? $ro->order_status }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $ro->created_at ? $ro->created_at->format('d/m/Y H:i') : '' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $ro->order_code) }}" class="btn btn-sm btn-light border py-1 px-2" title="Xem chi tiết đơn hàng">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Chưa có đơn hàng nào được ghi nhận.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('revenueTrendChart');
    if (!ctx || typeof Chart === 'undefined') return;

    const labels = @json($revenueTrend['labels']);
    const netData = @json($revenueTrend['net_revenue']);
    const grossData = @json($revenueTrend['gross_sales']);

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Doanh thu thuần (Net Revenue)',
                    data: netData,
                    borderColor: '#1e293b',
                    backgroundColor: 'rgba(30, 41, 59, 0.06)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointRadius: labels.length > 30 ? 0 : 3,
                    pointHoverRadius: 5,
                    pointBackgroundColor: '#1e293b',
                },
                {
                    label: 'Doanh số gộp (Gross Sales)',
                    data: grossData,
                    borderColor: '#b49a73',
                    backgroundColor: 'transparent',
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.35,
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                    hidden: true // initially show Net Revenue primary
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        font: { size: 12, family: 'Inter' }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return context.dataset.label + ': ' + new Intl.NumberFormat('vi-VN').format(context.raw) + ' ₫';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, family: 'Inter' }, maxRotation: 45 }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: {
                        font: { size: 11, family: 'Inter' },
                        callback: function (value) {
                            if (value >= 1000000) return (value / 1000000).toFixed(1) + 'M';
                            if (value >= 1000) return (value / 1000).toFixed(0) + 'k';
                            return value;
                        }
                    }
                }
            }
        }
    });

    // Toggle button listeners
    const btnNet = document.getElementById('btnToggleNet');
    const btnGross = document.getElementById('btnToggleGross');

    if (btnNet && btnGross) {
        btnNet.addEventListener('click', function () {
            btnNet.classList.add('active');
            btnGross.classList.remove('active');
            chart.setDatasetVisibility(0, true);
            chart.setDatasetVisibility(1, false);
            chart.update();
        });

        btnGross.addEventListener('click', function () {
            btnGross.classList.add('active');
            btnNet.classList.remove('active');
            chart.setDatasetVisibility(0, true);
            chart.setDatasetVisibility(1, true);
            chart.update();
        });
    }
});
</script>
@endpush
