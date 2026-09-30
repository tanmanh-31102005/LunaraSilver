@extends('admin.layouts.app')

@section('title', 'Tạo mã giảm giá mới | Lunara Admin')
@section('page_title', 'Tạo mã giảm giá')

@section('breadcrumb')
    <li><a href="{{ route('admin.coupons.index') }}">Mã giảm giá</a></li>
    <li class="active">Tạo mới</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Tạo chương trình ưu đãi / Mã giảm giá</h2>
            <p class="text-muted small mb-0">Thiết lập các điều kiện giảm giá theo phần trăm hoặc số tiền cố định cho khách hàng.</p>
        </div>
        <a href="{{ route('admin.coupons.index') }}" class="admin-btn admin-btn--secondary">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="admin-card">
                <div class="p-4">
                    <form action="{{ route('admin.coupons.store') }}" method="POST" id="couponForm">
                        @csrf

                        <div class="row g-3">
                            {{-- Mã code --}}
                            <div class="col-md-6">
                                <label for="couponCode" class="form-label small fw-medium text-dark">
                                    Mã ưu đãi (Code) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-ticket-perforated"></i></span>
                                    <input type="text" name="code" id="couponCode"
                                           class="form-control text-uppercase font-monospace @error('code') is-invalid @enderror"
                                           value="{{ old('code') }}" placeholder="VD: LUNARA10, CHAOHEXINH" required autofocus>
                                </div>
                                <small class="text-muted">Mã sẽ tự động chuyển thành chữ hoa khi lưu.</small>
                                @error('code')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Loại giảm giá --}}
                            <div class="col-md-6">
                                <label for="couponType" class="form-label small fw-medium text-dark">
                                    Loại giảm giá <span class="text-danger">*</span>
                                </label>
                                <select name="type" id="couponType" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="percentage" {{ old('type', 'percentage') === 'percentage' ? 'selected' : '' }}>Giảm theo % (Phần trăm giá trị)</option>
                                    <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Giảm số tiền cố định (VNĐ)</option>
                                </select>
                                @error('type')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Giá trị giảm --}}
                            <div class="col-md-6">
                                <label for="couponValue" class="form-label small fw-medium text-dark">
                                    Giá trị giảm <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0.01" name="value" id="couponValue"
                                           class="form-control font-monospace @error('value') is-invalid @enderror"
                                           value="{{ old('value') }}" placeholder="VD: 10 (nếu %) hoặc 50000 (nếu VNĐ)" required>
                                    <span class="input-group-text" id="valueUnit">%</span>
                                </div>
                                @error('value')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Giảm tối đa (cho percentage) --}}
                            <div class="col-md-6" id="maxDiscountWrapper">
                                <label for="couponMaxDiscount" class="form-label small fw-medium text-dark">
                                    Mức giảm tối đa (VNĐ)
                                </label>
                                <div class="input-group">
                                    <input type="number" step="1000" min="0" name="maximum_discount" id="couponMaxDiscount"
                                           class="form-control font-monospace @error('maximum_discount') is-invalid @enderror"
                                           value="{{ old('maximum_discount') }}" placeholder="Để trống nếu không giới hạn trần">
                                    <span class="input-group-text">₫</span>
                                </div>
                                <small class="text-muted">Áp dụng để chặn trần giảm giá khi giảm theo %.</small>
                                @error('maximum_discount')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Đơn tối thiểu --}}
                            <div class="col-md-6">
                                <label for="couponMinOrder" class="form-label small fw-medium text-dark">
                                    Giá trị đơn hàng tối thiểu (VNĐ)
                                </label>
                                <div class="input-group">
                                    <input type="number" step="1000" min="0" name="minimum_order" id="couponMinOrder"
                                           class="form-control font-monospace @error('minimum_order') is-invalid @enderror"
                                           value="{{ old('minimum_order', 0) }}" placeholder="VD: 300000">
                                    <span class="input-group-text">₫</span>
                                </div>
                                <small class="text-muted">Tổng phụ (subtotal) phải đạt mức này để được áp dụng mã.</small>
                                @error('minimum_order')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Giới hạn tổng số lượt dùng --}}
                            <div class="col-md-3">
                                <label for="couponUsageLimit" class="form-label small fw-medium text-dark">
                                    Tổng lượt sử dụng
                                </label>
                                <input type="number" min="1" step="1" name="usage_limit" id="couponUsageLimit"
                                       class="form-control font-monospace @error('usage_limit') is-invalid @enderror"
                                       value="{{ old('usage_limit') }}" placeholder="VD: 100">
                                <small class="text-muted">Để trống = Vô hạn.</small>
                                @error('usage_limit')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Giới hạn lượt dùng trên mỗi tài khoản --}}
                            <div class="col-md-3">
                                <label for="couponUsageLimitPerUser" class="form-label small fw-medium text-dark">
                                    Lượt dùng / khách
                                </label>
                                <input type="number" min="1" step="1" name="usage_limit_per_user" id="couponUsageLimitPerUser"
                                       class="form-control font-monospace @error('usage_limit_per_user') is-invalid @enderror"
                                       value="{{ old('usage_limit_per_user', 1) }}" placeholder="VD: 1">
                                <small class="text-muted">Mỗi tài khoản được dùng tối đa.</small>
                                @error('usage_limit_per_user')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Ngày bắt đầu --}}
                            <div class="col-md-6">
                                <label for="couponStartsAt" class="form-label small fw-medium text-dark">
                                    Thời gian bắt đầu áp dụng
                                </label>
                                <input type="datetime-local" name="starts_at" id="couponStartsAt"
                                       class="form-control @error('starts_at') is-invalid @enderror"
                                       value="{{ old('starts_at') }}">
                                <small class="text-muted">Để trống nếu áp dụng ngay lập tức.</small>
                                @error('starts_at')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Ngày hết hạn --}}
                            <div class="col-md-6">
                                <label for="couponExpiresAt" class="form-label small fw-medium text-dark">
                                    Thời gian hết hạn
                                </label>
                                <input type="datetime-local" name="expires_at" id="couponExpiresAt"
                                       class="form-control @error('expires_at') is-invalid @enderror"
                                       value="{{ old('expires_at') }}">
                                <small class="text-muted">Để trống nếu không có thời hạn kết thúc.</small>
                                @error('expires_at')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kích hoạt --}}
                            <div class="col-12 mt-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="couponIsActive" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-medium text-dark" for="couponIsActive">
                                        Kích hoạt mã giảm giá này ngay lập tức
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.coupons.index') }}" class="admin-btn admin-btn--secondary">
                                Hủy bỏ
                            </a>
                            <button type="submit" class="admin-btn admin-btn--primary">
                                <i class="bi bi-check-lg"></i> Lưu mã giảm giá
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('couponType');
        const unitSpan = document.getElementById('valueUnit');
        const maxDiscountWrapper = document.getElementById('maxDiscountWrapper');

        function updateTypeDisplay() {
            if (typeSelect.value === 'percentage') {
                unitSpan.textContent = '%';
                maxDiscountWrapper.style.display = 'block';
            } else {
                unitSpan.textContent = '₫';
                maxDiscountWrapper.style.display = 'none';
            }
        }

        typeSelect.addEventListener('change', updateTypeDisplay);
        updateTypeDisplay();
    });
</script>
@endsection
