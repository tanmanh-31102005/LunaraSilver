@extends('admin.layouts.app')

@section('title', 'Chi tiết mã giảm giá ' . $coupon->code . ' | Lunara Admin')
@section('page_title', 'Chi tiết mã giảm giá: ' . $coupon->code)

@section('breadcrumb')
    <li><a href="{{ route('admin.coupons.index') }}">Mã giảm giá</a></li>
    <li class="active">{{ $coupon->code }}</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="h5 mb-0 fw-bold text-dark font-monospace">{{ $coupon->code }}</h2>
                @if($coupon->is_active)
                    <span class="badge bg-success">Đang hoạt động</span>
                @else
                    <span class="badge bg-secondary">Tạm tắt</span>
                @endif
                @if($coupon->isExpired())
                    <span class="badge bg-danger">Hết hạn</span>
                @endif
            </div>
            <p class="text-muted small mb-0">Xem thông tin chi tiết và nhật ký các đơn hàng đã áp dụng mã ưu đãi này.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.coupons.toggle', $coupon) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="admin-btn admin-btn--secondary">
                    <i class="bi bi-power"></i> {{ $coupon->is_active ? 'Tắt kích hoạt' : 'Bật kích hoạt' }}
                </button>
            </form>
            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="admin-btn admin-btn--primary">
                <i class="bi bi-pencil"></i> Chỉnh sửa
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    {{-- Overview Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="admin-card p-3 h-100">
                <div class="text-muted small fw-medium mb-1"><i class="bi bi-tag-fill me-1 text-primary"></i> Giá trị ưu đãi</div>
                @if($coupon->type === \App\Models\Coupon::TYPE_PERCENTAGE)
                    <div class="fs-4 fw-bold text-dark">Giảm {{ (float) $coupon->value }}%</div>
                    @if($coupon->maximum_discount > 0)
                        <div class="small text-muted mt-1">Giảm tối đa: <strong>{{ number_format($coupon->maximum_discount, 0, ',', '.') }} ₫</strong></div>
                    @endif
                @else
                    <div class="fs-4 fw-bold text-dark">Giảm {{ number_format($coupon->value, 0, ',', '.') }} ₫</div>
                    <div class="small text-muted mt-1">Số tiền cố định trừ trực tiếp vào đơn</div>
                @endif
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="admin-card p-3 h-100">
                <div class="text-muted small fw-medium mb-1"><i class="bi bi-cart-check me-1 text-success"></i> Điều kiện áp dụng</div>
                <div class="fs-6 fw-bold text-dark">
                    {{ $coupon->minimum_order > 0 ? 'Đơn tối thiểu ' . number_format($coupon->minimum_order, 0, ',', '.') . ' ₫' : 'Không giới hạn đơn tối thiểu' }}
                </div>
                <div class="small text-muted mt-1">
                    @if($coupon->starts_at || $coupon->expires_at)
                        {{ $coupon->starts_at ? 'Từ ' . $coupon->starts_at->format('d/m/Y') : '' }}
                        {{ $coupon->expires_at ? 'Đến ' . $coupon->expires_at->format('d/m/Y') : 'Không hạn kết thúc' }}
                    @else
                        Áp dụng không giới hạn thời gian
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="admin-card p-3 h-100">
                <div class="text-muted small fw-medium mb-1"><i class="bi bi-people me-1 text-info"></i> Lượt sử dụng</div>
                <div class="fs-4 fw-bold text-dark">
                    <span class="font-monospace">{{ $coupon->used_count }}</span>
                    <span class="text-muted fs-6">/ {{ $coupon->usage_limit !== null ? $coupon->usage_limit : '∞' }} lượt</span>
                </div>
                <div class="small text-muted mt-1">
                    Mỗi khách hàng: <strong>{{ $coupon->usage_limit_per_user ? $coupon->usage_limit_per_user . ' lần' : 'Không giới hạn' }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Advanced Restrictions & Scope --}}
    @if($coupon->is_first_order_only || !empty($coupon->applicable_categories) || !empty($coupon->applicable_products) || !empty($coupon->applicable_customer_emails))
        <div class="admin-card p-3 mb-4">
            <h4 class="h6 fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-shield-lock-fill text-primary"></i>
                <span>Phạm vi & Giới hạn nâng cao</span>
            </h4>
            <div class="row g-3">
                @if($coupon->is_first_order_only)
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="p-2 border rounded bg-light h-100">
                            <div class="text-muted small fw-medium mb-1"><i class="bi bi-person-check text-success me-1"></i> Khách hàng mới</div>
                            <span class="badge bg-success">Chỉ áp dụng cho đơn đầu tiên</span>
                        </div>
                    </div>
                @endif

                @if(!empty($coupon->applicable_categories))
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="p-2 border rounded bg-light h-100">
                            <div class="text-muted small fw-medium mb-1"><i class="bi bi-tags text-primary me-1"></i> Danh mục giới hạn</div>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                @forelse($restrictedCategories as $cat)
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ $cat->name }}</span>
                                @empty
                                    @foreach($coupon->applicable_categories as $catId)
                                        <span class="badge bg-secondary">ID #{{ $catId }}</span>
                                    @endforeach
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($coupon->applicable_products))
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="p-2 border rounded bg-light h-100">
                            <div class="text-muted small fw-medium mb-1"><i class="bi bi-gem text-warning me-1"></i> Sản phẩm giới hạn</div>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                @forelse($restrictedProducts as $prod)
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ $prod->name }}</span>
                                @empty
                                    @foreach($coupon->applicable_products as $prodId)
                                        <span class="badge bg-secondary">SP #{{ $prodId }}</span>
                                    @endforeach
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($coupon->applicable_customer_emails))
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="p-2 border rounded bg-light h-100">
                            <div class="text-muted small fw-medium mb-1"><i class="bi bi-envelope text-info me-1"></i> Email khách hàng được phép</div>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                @foreach($coupon->applicable_customer_emails as $em)
                                    <span class="badge bg-secondary bg-opacity-25 text-dark font-monospace">{{ $em }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
    <div class="admin-card">
        <div class="admin-card-header d-flex align-items-center justify-content-between p-3 border-bottom">
            <h3 class="admin-card-title h6 mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-muted"></i>
                <span>Lịch sử sử dụng trong đơn hàng</span>
            </h3>
            <span class="badge bg-light text-muted border">{{ $usages->total() }} lượt ghi nhận</span>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 140px;">Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th class="text-end">Tổng đơn</th>
                        <th style="width: 130px;" class="text-center">Trạng thái</th>
                        <th>Thời gian áp dụng</th>
                        <th>Thời gian hoàn lại</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usages as $usage)
                        <tr>
                            <td>
                                @if($usage->order)
                                    <a href="{{ route('admin.orders.show', $usage->order) }}" class="fw-bold font-monospace text-primary text-decoration-none">
                                        {{ $usage->order->order_code }}
                                    </a>
                                @else
                                    <span class="text-muted font-monospace">Đơn #{{ $usage->order_id }}</span>
                                @endif
                            </td>
                            <td>
                                @if($usage->user)
                                    <div class="fw-medium text-dark">{{ $usage->user->name }}</div>
                                    <div class="small text-muted">{{ $usage->user->email }}</div>
                                @elseif($usage->order)
                                    <div class="fw-medium text-dark">{{ $usage->order->customer_name }}</div>
                                    <div class="small text-muted">{{ $usage->order->customer_email }}</div>
                                @else
                                    <span class="text-muted small">Khách vãng lai</span>
                                @endif
                            </td>
                            <td class="text-end font-monospace fw-medium text-dark">
                                @if($usage->order)
                                    {{ number_format((float) $usage->order->grand_total, 0, ',', '.') }} ₫
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-center">
                                @if($usage->status === \App\Models\CouponUsage::STATUS_APPLIED)
                                    <span class="badge bg-success bg-opacity-75 text-white">Đã áp dụng</span>
                                @elseif($usage->status === \App\Models\CouponUsage::STATUS_RELEASED)
                                    <span class="badge bg-secondary text-white">Đã hoàn lại</span>
                                @else
                                    <span class="badge bg-light text-dark border">{{ $usage->status }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="small text-dark">{{ $usage->used_at ? $usage->used_at->format('d/m/Y H:i') : ($usage->created_at ? $usage->created_at->format('d/m/Y H:i') : '—') }}</span>
                            </td>
                            <td>
                                @if($usage->released_at)
                                    <span class="small text-danger">{{ $usage->released_at->format('d/m/Y H:i') }}</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-1 text-secondary"></i>
                                Chưa có đơn hàng nào áp dụng mã giảm giá này.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($usages->hasPages())
            <div class="p-3 border-top d-flex justify-content-center">
                {{ $usages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
