@extends('admin.layouts.app')

@section('title', 'Bảng điều khiển vận hành')
@section('page_title', 'Bảng điều khiển')

@section('breadcrumb')
    <li class="active">Tổng quan</li>
@endsection

@section('content')
<div class="mb-4">
    {{-- Header with description and primary action --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Tổng quan vận hành</h2>
            <p class="text-muted small mb-0">Hệ thống quản lý catalog, tồn kho và đơn hàng Lunara Silver.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn--primary">
                <i class="bi bi-plus-lg"></i>
                <span>Thêm sản phẩm</span>
            </a>
            <a href="{{ route('admin.categories.create') }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-folder-plus"></i>
                <span>Thêm danh mục</span>
            </a>
        </div>
    </div>

    {{-- LAYER 1: OPERATIONAL METRIC CARDS --}}
    <div class="row g-3 mb-4">
        {{-- Total Products --}}
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="admin-metric-card">
                    <div class="admin-metric-label">Tổng sản phẩm</div>
                    <div class="admin-metric-value">{{ number_format($metrics['total_products']) }}</div>
                    <div class="admin-metric-desc">Toàn bộ catalog</div>
                </div>
            </a>
        </div>

        {{-- Active Products --}}
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.products.index', ['is_active' => '1']) }}" class="text-decoration-none">
                <div class="admin-metric-card">
                    <div class="admin-metric-label">Đang mở bán</div>
                    <div class="admin-metric-value text-success">{{ number_format($metrics['active_products']) }}</div>
                    <div class="admin-metric-desc">Hiển thị storefront</div>
                </div>
            </a>
        </div>

        {{-- Low-stock Singles --}}
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.products.index', ['product_type' => 'single', 'stock_status' => 'low_stock']) }}" class="text-decoration-none">
                <div class="admin-metric-card">
                    <div class="admin-metric-label">Sắp hết hàng</div>
                    <div class="admin-metric-value {{ $metrics['low_stock_singles'] > 0 ? 'text-warning' : 'text-dark' }}">
                        {{ number_format($metrics['low_stock_singles']) }}
                    </div>
                    <div class="admin-metric-desc">Tồn &le; {{ $metrics['low_stock_threshold'] }} (Single)</div>
                </div>
            </a>
        </div>

        {{-- Out of stock Singles --}}
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.products.index', ['stock_status' => 'out_of_stock']) }}" class="text-decoration-none">
                <div class="admin-metric-card">
                    <div class="admin-metric-label">Hết hàng</div>
                    <div class="admin-metric-value {{ $metrics['out_of_stock_singles'] > 0 ? 'text-danger' : 'text-muted' }}">
                        {{ number_format($metrics['out_of_stock_singles']) }}
                    </div>
                    <div class="admin-metric-desc">Tồn = 0 (Single)</div>
                </div>
            </a>
        </div>

        {{-- Pending Orders --}}
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.orders.index', ['order_status' => 'pending']) }}" class="text-decoration-none">
                <div class="admin-metric-card" style="border-color: #fde68a;">
                    <div class="admin-metric-label text-warning-emphasis">Đơn chờ xử lý</div>
                    <div class="admin-metric-value text-warning-emphasis">{{ number_format($metrics['pending_orders']) }}</div>
                    <div class="admin-metric-desc">Cần xác nhận / xuất kho</div>
                </div>
            </a>
        </div>

        {{-- Total Orders --}}
        <div class="col-sm-6 col-xl-2">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                <div class="admin-metric-card">
                    <div class="admin-metric-label">Tổng đơn hàng</div>
                    <div class="admin-metric-value">{{ number_format($metrics['total_orders']) }}</div>
                    <div class="admin-metric-desc">Đã ghi nhận</div>
                </div>
            </a>
        </div>
    </div>

    {{-- LAYER 2: ATTENTION REQUIRED (CẦN XỬ LÝ) --}}
    <div class="row g-4 mb-4">
        {{-- Low Stock Singles Alert Block --}}
        <div class="col-lg-6">
            <div class="admin-card h-100">
                <div class="admin-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="admin-badge admin-badge--low_stock">Cần chú ý</span>
                        <h3 class="admin-card-title">Sản phẩm sắp hết hàng (Tồn &le; {{ $metrics['low_stock_threshold'] }})</h3>
                    </div>
                    <a href="{{ route('admin.products.index', ['product_type' => 'single', 'stock_status' => 'low_stock']) }}" class="text-muted text-decoration-none small">
                        Xem tất cả
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Ảnh</th>
                                <th>Mã SKU & Tên</th>
                                <th class="text-center">Tồn kho</th>
                                <th class="text-end">Xử lý</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lowStockProducts as $lp)
                                <tr>
                                    <td>
                                        @if ($lp->primaryImage)
                                            <img src="{{ route('media.show', ['path' => $lp->primaryImage->image_url]) }}" alt="{{ $lp->name }}" class="rounded border" style="width: 38px; height: 38px; object-fit: cover;">
                                        @else
                                            <div class="rounded border bg-light text-muted d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 0.75rem;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-truncate" style="max-width: 220px;" title="{{ $lp->name }}">{{ $lp->name }}</div>
                                        <div class="small text-muted font-monospace">{{ $lp->sku }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="admin-badge admin-badge--low_stock font-monospace">
                                            {{ $lp->stock_quantity }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.products.edit', $lp) }}" class="admin-btn admin-btn--secondary admin-btn--sm">
                                            Nhập kho
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">
                                        <i class="bi bi-check-circle text-success me-1"></i> Không có sản phẩm nào sắp hết hàng.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Out of Stock Block --}}
        <div class="col-lg-6">
            <div class="admin-card h-100">
                <div class="admin-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="admin-badge admin-badge--out_of_stock">Hết hàng</span>
                        <h3 class="admin-card-title">Sản phẩm hết hàng (Tồn = 0)</h3>
                    </div>
                    <a href="{{ route('admin.products.index', ['stock_status' => 'out_of_stock']) }}" class="text-muted text-decoration-none small">
                        Xem tất cả
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Ảnh</th>
                                <th>Mã SKU & Tên</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-end">Xử lý</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($outOfStockProducts as $op)
                                <tr>
                                    <td>
                                        @if ($op->primaryImage)
                                            <img src="{{ route('media.show', ['path' => $op->primaryImage->image_url]) }}" alt="{{ $op->name }}" class="rounded border" style="width: 38px; height: 38px; object-fit: cover;">
                                        @else
                                            <div class="rounded border bg-light text-muted d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 0.75rem;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-truncate" style="max-width: 220px;" title="{{ $op->name }}">{{ $op->name }}</div>
                                        <div class="small text-muted font-monospace">{{ $op->sku }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="admin-badge admin-badge--out_of_stock">Hết hàng</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.products.edit', $op) }}" class="admin-btn admin-btn--secondary admin-btn--sm">
                                            Cập nhật
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">
                                        <i class="bi bi-check-circle text-success me-1"></i> Tất cả sản phẩm đơn đều còn hàng.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- LAYER 3: RECENT CATALOG & ORDERS ACTIVITY --}}
    <div class="row g-4">
        {{-- Recent Products --}}
        <div class="col-lg-7">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Sản phẩm mới cập nhật</h3>
                    <a href="{{ route('admin.products.index') }}" class="text-muted text-decoration-none small">Xem tất cả catalog</a>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Ảnh</th>
                                <th>Tên & SKU</th>
                                <th>Loại</th>
                                <th class="text-end">Giá bán</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentProducts as $product)
                                <tr>
                                    <td>
                                        @if ($product->primaryImage)
                                            <img src="{{ route('media.show', ['path' => $product->primaryImage->image_url]) }}" alt="{{ $product->name }}" class="rounded border" style="width: 38px; height: 38px; object-fit: cover;">
                                        @else
                                            <div class="rounded border bg-light text-muted d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 0.75rem;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-truncate" style="max-width: 220px;" title="{{ $product->name }}">
                                            {{ $product->name }}
                                        </div>
                                        <div class="small text-muted font-monospace">{{ $product->sku }}</div>
                                    </td>
                                    <td>
                                        @if ($product->product_type === 'single')
                                            <span class="admin-badge bg-light text-secondary border">Single</span>
                                        @elseif ($product->product_type === 'collection')
                                            <span class="admin-badge bg-light text-primary border">Collection</span>
                                        @else
                                            <span class="admin-badge bg-light text-info border">Gift</span>
                                        @endif
                                    </td>
                                    <td class="text-end font-monospace text-dark">
                                        {{ number_format($product->sale_price ?? $product->regular_price, 0, ',', '.') }}đ
                                    </td>
                                    <td class="text-center">
                                        @if ($product->is_active)
                                            <span class="admin-badge admin-badge--in_stock">Active</span>
                                        @else
                                            <span class="admin-badge admin-badge--out_of_stock">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="admin-btn admin-btn--secondary admin-btn--sm" title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted small">Chưa có sản phẩm nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="col-lg-5">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Đơn hàng gần đây</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-muted text-decoration-none small">Xem tất cả đơn hàng</a>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th class="text-end">Tổng tiền</th>
                                <th class="text-center">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->order_code) }}" class="font-monospace fw-semibold small text-dark text-decoration-none">
                                            {{ $order->order_code }}
                                        </a>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="text-truncate fw-medium small" style="max-width: 120px;">{{ $order->customer_name }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $order->customer_phone }}</div>
                                    </td>
                                    <td class="text-end font-monospace small fw-semibold text-dark">
                                        {{ number_format($order->grand_total, 0, ',', '.') }}đ
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $ordClass = match($order->order_status) {
                                                'pending' => 'admin-badge--pending',
                                                'confirmed' => 'admin-badge--confirmed',
                                                'processing' => 'admin-badge--processing',
                                                'shipping' => 'admin-badge--shipping',
                                                'completed' => 'admin-badge--completed',
                                                'cancelled' => 'admin-badge--cancelled',
                                                default => 'admin-badge--pending',
                                            };
                                        @endphp
                                        <span class="admin-badge admin-badge--dot {{ $ordClass }}">
                                            {{ $order->order_status_label }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">Chưa có đơn hàng nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
