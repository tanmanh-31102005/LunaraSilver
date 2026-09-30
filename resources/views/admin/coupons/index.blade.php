@extends('admin.layouts.app')

@section('title', 'Quản lý mã giảm giá | Lunara Admin')
@section('page_title', 'Quản lý mã giảm giá')

@section('breadcrumb')
    <li class="active">Mã giảm giá</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Danh sách mã giảm giá & Khuyến mãi</h2>
            <p class="text-muted small mb-0">Quản trị các chương trình coupon, voucher ưu đãi cho khách hàng Lunara Silver.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.coupons.create') }}" class="admin-btn admin-btn--primary">
                <i class="bi bi-plus-lg"></i> Tạo mã mới
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-4">
            <div class="admin-card p-3 d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary fs-4">
                    <i class="bi bi-ticket-perforated"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Tổng mã ưu đãi</div>
                    <div class="fs-4 fw-bold text-dark">{{ number_format($stats['total'] ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="admin-card p-3 d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success fs-4">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Đang kích hoạt</div>
                    <div class="fs-4 fw-bold text-success">{{ number_format($stats['active'] ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="admin-card p-3 d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-secondary bg-opacity-10 text-secondary fs-4">
                    <i class="bi bi-pause-circle"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Tạm tắt kích hoạt</div>
                    <div class="fs-4 fw-bold text-secondary">{{ number_format($stats['inactive'] ?? 0) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="admin-card mb-4">
        <div class="p-3">
            <form action="{{ route('admin.coupons.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Tìm theo mã ưu đãi (VD: LUNARA10)..." aria-label="Tìm kiếm">
                </div>

                <div class="col-md-3">
                    <select name="type" class="form-select form-select-sm">
                        <option value="">-- Tất cả loại giảm giá --</option>
                        <option value="percentage" {{ request('type') === 'percentage' ? 'selected' : '' }}>Giảm theo % (Phần trăm)</option>
                        <option value="fixed" {{ request('type') === 'fixed' ? 'selected' : '' }}>Giảm số tiền cố định (VNĐ)</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tạm dừng</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="admin-btn admin-btn--primary btn-sm flex-grow-1">
                        <i class="bi bi-filter"></i> Lọc
                    </button>
                    @if(request()->hasAny(['q', 'type', 'status']))
                        <a href="{{ route('admin.coupons.index') }}" class="admin-btn admin-btn--secondary btn-sm" title="Xóa bộ lọc">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Coupon Table --}}
    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 140px;">Mã ưu đãi</th>
                        <th>Loại & Mức giảm</th>
                        <th>Điều kiện áp dụng</th>
                        <th>Lượt dùng / Giới hạn</th>
                        <th>Thời hạn</th>
                        <th style="width: 120px;" class="text-center">Trạng thái</th>
                        <th class="text-end" style="width: 170px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td>
                                <a href="{{ route('admin.coupons.show', $coupon) }}" class="fw-bold font-monospace text-primary text-decoration-none fs-6">
                                    {{ $coupon->code }}
                                </a>
                            </td>
                            <td>
                                @if($coupon->type === \App\Models\Coupon::TYPE_PERCENTAGE)
                                    <span class="badge bg-info text-dark font-monospace">Giảm {{ (float) $coupon->value }}%</span>
                                    @if($coupon->maximum_discount > 0)
                                        <div class="small text-muted mt-1">Tối đa: {{ number_format($coupon->maximum_discount, 0, ',', '.') }} ₫</div>
                                    @endif
                                @else
                                    <span class="badge bg-success text-white font-monospace">Giảm {{ number_format($coupon->value, 0, ',', '.') }} ₫</span>
                                @endif
                            </td>
                            <td>
                                @if($coupon->minimum_order > 0)
                                    <div class="small text-dark">Đơn từ: <strong class="font-monospace">{{ number_format($coupon->minimum_order, 0, ',', '.') }} ₫</strong></div>
                                @else
                                    <span class="small text-muted">Không giới hạn đơn tối thiểu</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <strong class="font-monospace text-dark">{{ $coupon->used_count }}</strong>
                                    <span class="text-muted">/ {{ $coupon->usage_limit !== null ? $coupon->usage_limit : '∞' }} lượt</span>
                                </div>
                                @if($coupon->usage_limit_per_user)
                                    <small class="text-muted d-block">Tối đa {{ $coupon->usage_limit_per_user }} lượt/khách</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $isExpired = $coupon->isExpired();
                                    $notStarted = ! $coupon->hasStarted();
                                @endphp
                                @if($notStarted)
                                    <x-ui.status-badge status="pending" label="Chưa bắt đầu" size="sm" />
                                    <div class="small text-muted mt-1">Từ: {{ $coupon->starts_at?->format('d/m/Y H:i') }}</div>
                                @elseif($isExpired)
                                    <x-ui.status-badge status="failed" label="Đã hết hạn" size="sm" />
                                    <div class="small text-muted mt-1">Hết: {{ $coupon->expires_at?->format('d/m/Y H:i') }}</div>
                                @else
                                    <x-ui.status-badge status="active" label="Đang áp dụng" size="sm" />
                                    @if($coupon->expires_at)
                                        <div class="small text-muted mt-1">Hết: {{ $coupon->expires_at->format('d/m/Y H:i') }}</div>
                                    @else
                                        <div class="small text-muted mt-1">Vô thời hạn</div>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.coupons.toggle', $coupon) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $coupon->is_active ? 'btn-success' : 'btn-outline-secondary' }} py-0 px-2 rounded-pill" style="font-size: 0.78rem;" title="Bấm để {{ $coupon->is_active ? 'tắt' : 'bật' }}">
                                        {{ $coupon->is_active ? 'Bật' : 'Tắt' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.coupons.show', $coupon) }}" class="admin-btn admin-btn--secondary btn-sm p-1 px-2" title="Chi tiết & Lịch sử sử dụng">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="admin-btn admin-btn--secondary btn-sm p-1 px-2" title="Chỉnh sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $coupon->used_count > 0 ? "Mã này đã có {$coupon->used_count} lượt dùng. Hệ thống sẽ vô hiệu hóa (tắt kích hoạt) thay vì xóa hoàn toàn để bảo toàn dữ liệu đơn hàng. Tiếp tục?" : "Bạn có chắc chắn muốn xóa mã ưu đãi {$coupon->code} không?" }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn--danger btn-sm p-1 px-2" title="{{ $coupon->used_count > 0 ? 'Vô hiệu hóa mã' : 'Xóa mã' }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-ticket-perforated fs-1 d-block mb-2 text-secondary"></i>
                                Chưa có mã giảm giá nào. Hãy bấm "Tạo mã mới" để bắt đầu chiến dịch khuyến mãi!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($coupons->hasPages())
            <div class="p-3 border-top d-flex justify-content-center">
                {{ $coupons->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
