@extends('admin.layouts.app')

@section('title', 'Danh sách khách hàng | Lunara Admin')
@section('page_title', 'Quản lý khách hàng')

@section('breadcrumb')
    <li class="active">Khách hàng</li>
@endsection

@section('content')
<div class="mb-4">
    {{-- Header with Summary and Actions --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Danh bạ khách hàng (Customer Directory)</h2>
            <p class="text-muted small mb-0">Quản lý hồ sơ, tần suất mua sắm và giá trị vòng đời khách hàng (Lifetime Spend).</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.export', ['type' => 'customers']) }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2" style="font-size: 0.82rem; height: 36px;">
                <i class="bi bi-download"></i>
                <span>Xuất danh sách (CSV)</span>
            </a>
        </div>
    </div>

    {{-- Filter Tabs & Search Bar --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: var(--radius-md);">
        <div class="card-body p-3">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                {{-- Segment Filter Tabs --}}
                <div class="d-flex flex-wrap align-items-center gap-1">
                    <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['filter' => 'all', 'page' => 1])) }}"
                       class="btn btn-sm {{ $currentFilter === 'all' ? 'btn-dark' : 'btn-light border' }}" style="font-size: 0.8rem;">
                        Tất cả
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['filter' => 'new', 'page' => 1])) }}"
                       class="btn btn-sm {{ $currentFilter === 'new' ? 'btn-dark' : 'btn-light border' }}" style="font-size: 0.8rem;">
                        <i class="bi bi-sparkles me-1 text-warning"></i> Khách mới (&le; 30 ngày)
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['filter' => 'repeat', 'page' => 1])) }}"
                       class="btn btn-sm {{ $currentFilter === 'repeat' ? 'btn-dark' : 'btn-light border' }}" style="font-size: 0.8rem;">
                        <i class="bi bi-repeat me-1 text-primary"></i> Mua lặp lại (&ge; 2 đơn)
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['filter' => 'high_value', 'page' => 1])) }}"
                       class="btn btn-sm {{ $currentFilter === 'high_value' ? 'btn-dark' : 'btn-light border' }}" style="font-size: 0.8rem;">
                        <i class="bi bi-gem me-1 text-success"></i> Khách VIP (&ge; 5M)
                    </a>
                    <a href="{{ route('admin.customers.index', array_merge(request()->query(), ['filter' => 'no_orders', 'page' => 1])) }}"
                       class="btn btn-sm {{ $currentFilter === 'no_orders' ? 'btn-dark' : 'btn-light border' }}" style="font-size: 0.8rem;">
                        Chưa có đơn
                    </a>
                </div>

                {{-- Search & Sort Form --}}
                <form method="GET" action="{{ route('admin.customers.index') }}" class="d-flex align-items-center gap-2">
                    <input type="hidden" name="filter" value="{{ $currentFilter }}">

                    <div class="input-group input-group-sm" style="max-width: 260px;">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ $search }}" class="form-control border-start-0 shadow-none" placeholder="Tìm tên, email, SĐT..." style="font-size: 0.8rem;">
                        @if ($search)
                            <a href="{{ route('admin.customers.index', ['filter' => $currentFilter]) }}" class="btn btn-outline-secondary" title="Xóa tìm kiếm"><i class="bi bi-x"></i></a>
                        @endif
                    </div>

                    <select name="sort" class="form-select form-select-sm shadow-none" style="font-size: 0.8rem; width: 140px;" onchange="this.form.submit()">
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="spent" {{ $sort === 'spent' ? 'selected' : '' }}>Chi tiêu cao</option>
                        <option value="orders" {{ $sort === 'orders' ? 'selected' : '' }}>Nhiều đơn nhất</option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                    </select>

                    <button type="submit" class="btn btn-sm btn-outline-dark" style="font-size: 0.8rem;">Lọc</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Customer Table --}}
    <div class="card border-0 shadow-sm" style="border-radius: var(--radius-md); overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 25%;">Khách hàng</th>
                        <th>Email</th>
                        <th class="text-center">Ngày tham gia</th>
                        <th class="text-center">Đơn hoàn thành</th>
                        <th class="text-end">Chi tiêu trọn đời</th>
                        <th class="text-center">Lần đặt cuối</th>
                        <th class="text-center">Phân khúc</th>
                        <th class="text-end" style="width: 100px;">Hồ sơ 360</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $c)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-semibold text-uppercase" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                        {{ mb_substr($c->name ?: 'U', 0, 1) }}
                                    </div>
                                    <div class="text-truncate">
                                        <a href="{{ route('admin.customers.show', $c->id) }}" class="fw-bold text-dark text-decoration-none text-truncate d-block">
                                            {{ $c->name }}
                                        </a>
                                        <div class="text-muted" style="font-size: 0.72rem;">ID: #{{ $c->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $c->email }}</span>
                            </td>
                            <td class="text-center text-muted small">
                                {{ $c->created_at ? $c->created_at->format('d/m/Y') : '—' }}
                            </td>
                            <td class="text-center">
                                <span class="fw-bold {{ $c->completed_orders_count > 0 ? 'text-success' : 'text-muted' }}">
                                    {{ $c->completed_orders_count }}
                                </span>
                                <span class="text-muted" style="font-size: 0.72rem;">/ {{ $c->orders_count }} đơn</span>
                            </td>
                            <td class="text-end fw-bold text-dark">
                                {{ number_format($c->lifetime_spend, 0, ',', '.') }}₫
                            </td>
                            <td class="text-center text-muted small">
                                {{ $c->last_order_at ? \Carbon\Carbon::parse($c->last_order_at)->format('d/m/Y') : '—' }}
                            </td>
                            <td class="text-center">
                                @if ($c->segment === 'HIGH_VALUE')
                                    <span class="badge bg-warning-subtle text-warning-emphasis border rounded-pill px-2 py-1" style="font-size: 0.68rem;"><i class="bi bi-gem me-1"></i>VIP</span>
                                @elseif ($c->segment === 'REPEAT')
                                    <span class="badge bg-primary-subtle text-primary border rounded-pill px-2 py-1" style="font-size: 0.68rem;"><i class="bi bi-repeat me-1"></i>Thân thiết</span>
                                @elseif ($c->segment === 'NEW')
                                    <span class="badge bg-info-subtle text-info border rounded-pill px-2 py-1" style="font-size: 0.68rem;"><i class="bi bi-stars me-1"></i>Mới</span>
                                @else
                                    <span class="badge bg-light text-muted border rounded-pill px-2 py-1" style="font-size: 0.68rem;">Tiêu chuẩn</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.customers.show', $c->id) }}" class="btn btn-sm btn-light border py-1 px-2 d-inline-flex align-items-center gap-1" title="Xem Customer 360">
                                    <i class="bi bi-person-lines-fill"></i>
                                    <span class="d-none d-md-inline" style="font-size: 0.75rem;">360°</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-people fs-2 d-block mb-2 text-muted opacity-50"></i>
                                Không tìm thấy khách hàng nào phù hợp với bộ lọc hiện tại.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($customers->hasPages())
            <div class="card-footer bg-white p-3 border-top d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Hiển thị {{ $customers->firstItem() }} - {{ $customers->lastItem() }} trên {{ $customers->total() }} khách hàng
                </div>
                <div>
                    {{ $customers->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
