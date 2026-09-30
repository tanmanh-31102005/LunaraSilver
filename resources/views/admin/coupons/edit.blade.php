@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa mã giảm giá | Lunara Admin')
@section('page_title', 'Chỉnh sửa mã giảm giá')

@section('breadcrumb')
    <li><a href="{{ route('admin.coupons.index') }}">Mã giảm giá</a></li>
    <li class="active">{{ $coupon->code }}</li>
@endsection

@section('content')
<div class="mb-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold text-dark">Chỉnh sửa mã ưu đãi: <span class="font-monospace text-primary">{{ $coupon->code }}</span></h2>
            <p class="text-muted small mb-0">Cập nhật thông tin chi tiết, điều kiện và giới hạn áp dụng.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.coupons.show', $coupon) }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-eye"></i> Xem lịch sử
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="admin-btn admin-btn--secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    @if($coupon->used_count > 0)
        <div class="alert alert-warning d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div>
                <strong>Lưu ý:</strong> Mã này đã có <strong>{{ $coupon->used_count }}</strong> lượt sử dụng trong các đơn hàng trước đó. Hãy cẩn trọng khi sửa đổi mức giảm hoặc điều kiện áp dụng để tránh ảnh hưởng đến các giao dịch đã ghi nhận.
            </div>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="admin-card">
                <div class="p-4">
                    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" id="couponForm">
                        @csrf
                        @method('PUT')

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
                                           value="{{ old('code', $coupon->code) }}" required>
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
                                    <option value="percentage" {{ old('type', $coupon->type) === 'percentage' ? 'selected' : '' }}>Giảm theo % (Phần trăm giá trị)</option>
                                    <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>Giảm số tiền cố định (VNĐ)</option>
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
                                           value="{{ old('value', (float) $coupon->value) }}" required>
                                    <span class="input-group-text" id="valueUnit">{{ $coupon->type === 'percentage' ? '%' : '₫' }}</span>
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
                                           value="{{ old('maximum_discount', $coupon->maximum_discount ? (float) $coupon->maximum_discount : '') }}" placeholder="Không giới hạn trần">
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
                                           value="{{ old('minimum_order', (float) ($coupon->minimum_order ?? 0)) }}">
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
                                       value="{{ old('usage_limit', $coupon->usage_limit) }}" placeholder="Vô hạn">
                                <small class="text-muted">Đã dùng: {{ $coupon->used_count }}.</small>
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
                                       value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user ?? 1) }}">
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
                                       value="{{ old('starts_at', $coupon->starts_at?->format('Y-m-d\TH:i')) }}">
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
                                       value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d\TH:i')) }}">
                                <small class="text-muted">Để trống nếu không có thời hạn kết thúc.</small>
                                @error('expires_at')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Advanced Scope Restrictions (Option A) --}}
                            <div class="col-12 mt-4 pt-3 border-top">
                                <h3 class="h6 fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                                    <i class="bi bi-shield-lock text-primary"></i>
                                    <span>Quy tắc áp dụng nâng cao (Tùy chọn)</span>
                                </h3>
                                <p class="text-muted small mb-3">Nếu để trống, mã sẽ áp dụng cho tất cả sản phẩm, danh mục và mọi khách hàng.</p>

                                <div class="row g-3">
                                    {{-- First-Order Only --}}
                                    <div class="col-12">
                                        <div class="form-check form-switch p-3 bg-light rounded-3 border">
                                            <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" name="is_first_order_only" id="couponIsFirstOrderOnly" value="1" {{ old('is_first_order_only', $coupon->is_first_order_only) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold text-dark" for="couponIsFirstOrderOnly">
                                                <i class="bi bi-person-plus text-primary me-1"></i> Chỉ áp dụng cho đơn hàng đầu tiên (Khách hàng mới)
                                            </label>
                                            <small class="text-muted d-block mt-1 ps-4 ms-2">Hệ thống sẽ từ chối nếu tài khoản hoặc email của khách đã từng có bất kỳ đơn hàng nào trước đó.</small>
                                        </div>
                                    </div>

                                    {{-- Category specific --}}
                                    <div class="col-md-6">
                                        <label for="couponCategories" class="form-label small fw-medium text-dark">
                                            Áp dụng riêng cho danh mục (Category-specific)
                                        </label>
                                        @php
                                            $selectedCats = (array) old('applicable_categories', $coupon->applicable_categories ?? []);
                                        @endphp
                                        <select name="applicable_categories[]" id="couponCategories" class="form-select font-monospace" multiple size="4">
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCats) ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Giữ Ctrl / Cmd để chọn nhiều danh mục. Chiết khấu sẽ chỉ tính trên các sản phẩm thuộc danh mục đã chọn.</small>
                                    </div>

                                    {{-- Product specific --}}
                                    <div class="col-md-6">
                                        <label for="couponProducts" class="form-label small fw-medium text-dark">
                                            Áp dụng riêng cho sản phẩm (Product-specific)
                                        </label>
                                        @php
                                            $selectedProds = (array) old('applicable_products', $coupon->applicable_products ?? []);
                                        @endphp
                                        <select name="applicable_products[]" id="couponProducts" class="form-select font-monospace" multiple size="4">
                                            @foreach($products as $prod)
                                                <option value="{{ $prod->id }}" {{ in_array($prod->id, $selectedProds) ? 'selected' : '' }}>
                                                    [{{ $prod->sku }}] {{ $prod->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Giữ Ctrl / Cmd để chọn nhiều sản phẩm. Chiết khấu chỉ áp dụng cho các sản phẩm này.</small>
                                    </div>

                                    {{-- Customer specific --}}
                                    <div class="col-12">
                                        <label for="couponCustomerEmails" class="form-label small fw-medium text-dark">
                                            Chỉ định email khách hàng (Customer-specific)
                                        </label>
                                        @php
                                            $emailsStr = old('applicable_customer_emails', is_array($coupon->applicable_customer_emails) ? implode("\n", $coupon->applicable_customer_emails) : $coupon->applicable_customer_emails);
                                        @endphp
                                        <textarea name="applicable_customer_emails" id="couponCustomerEmails" class="form-control font-monospace" rows="2" placeholder="Ví dụ: vip@gmail.com, khachthanthiet@yahoo.com (nhập phân cách bằng dấu phẩy hoặc xuống dòng)">{{ $emailsStr }}</textarea>
                                        <small class="text-muted">Chỉ các tài khoản đăng nhập hoặc đơn hàng có email trong danh sách này mới được áp dụng.</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Kích hoạt --}}
                            <div class="col-12 mt-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="couponIsActive" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-medium text-dark" for="couponIsActive">
                                        Kích hoạt mã giảm giá này
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.coupons.index') }}" class="admin-btn admin-btn--secondary">
                                Hủy bỏ
                            </a>
                            <button type="submit" class="admin-btn admin-btn--primary">
                                <i class="bi bi-check-lg"></i> Cập nhật mã giảm giá
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
