@extends('layouts.account')

@section('title', 'Sổ địa chỉ | Lunara Silver')

@php
    $accountBreadcrumbs = [['label' => 'Sổ địa chỉ']];
@endphp

@section('account_content')
<div class="account-addresses">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h2 class="h5 mb-1 fw-bold">Sổ địa chỉ nhận hàng</h2>
            <p class="text-muted small mb-0">Quản lý các địa chỉ giao hàng để thanh toán nhanh chóng hơn.</p>
        </div>
        <div>
            <button type="button" class="lunara-button lunara-button--dark py-2 px-3 small" data-bs-toggle="modal" data-bs-target="#createAddressModal">
                <i class="bi bi-plus-lg me-1"></i> Thêm địa chỉ mới
            </button>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="mb-1 fw-bold">Vui lòng kiểm tra lại thông tin địa chỉ:</p>
            <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($addresses->isEmpty())
        <div class="card border-0 shadow-sm rounded-3 p-5 text-center bg-white">
            <div class="mb-3 text-muted" style="font-size: 3rem;"><i class="bi bi-geo-alt"></i></div>
            <h3 class="h5 text-muted mb-2">Bạn chưa lưu địa chỉ giao hàng.</h3>
            <p class="small text-muted mb-4">Lưu địa chỉ giúp bạn tiết kiệm thời gian điền thông tin trong mỗi lần mua sắm.</p>
            <div>
                <button type="button" class="lunara-button lunara-button--dark py-2 px-4" data-bs-toggle="modal" data-bs-target="#createAddressModal">
                    <i class="bi bi-plus-lg me-1"></i> Thêm địa chỉ đầu tiên
                </button>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach($addresses as $addr)
                <div class="col-12 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 h-100 bg-white address-card {{ $addr->is_default ? 'border-primary-subtle' : '' }}">
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h3 class="h6 fw-bold mb-0 text-dark">{{ $addr->recipient_name }}</h3>
                                    @if($addr->is_default)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle small">
                                            <i class="bi bi-check2"></i> Mặc định
                                        </span>
                                    @endif
                                </div>
                                <div class="text-muted small mb-2">
                                    <i class="bi bi-telephone me-1"></i> {{ $addr->phone }}
                                </div>
                                <div class="text-muted small mb-3">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    {{ $addr->address_line }}
                                    @if($addr->ward), {{ $addr->ward }}@endif
                                    @if($addr->district), {{ $addr->district }}@endif
                                    , {{ $addr->city }}
                                </div>
                            </div>

                            <div class="pt-3 border-top d-flex flex-wrap align-items-center justify-content-between gap-2 mt-auto">
                                <div>
                                    @if(! $addr->is_default)
                                        <form action="{{ route('account.addresses.default', $addr->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-link text-decoration-none p-0 text-primary small">
                                                Đặt làm mặc định
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary py-1 px-2 small"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editAddressModal{{ $addr->id }}"
                                            aria-label="Sửa địa chỉ của {{ $addr->recipient_name }}">
                                        <i class="bi bi-pencil me-1"></i> Sửa
                                    </button>

                                    <form action="{{ route('account.addresses.destroy', $addr->id) }}"
                                          method="post"
                                          class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2 small" aria-label="Xóa địa chỉ của {{ $addr->recipient_name }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Address Modal -->
                <div class="modal fade" id="editAddressModal{{ $addr->id }}" tabindex="-1" aria-labelledby="editAddressModalLabel{{ $addr->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <form action="{{ route('account.addresses.update', $addr->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="modal-header border-bottom">
                                    <h4 class="modal-title h5 fw-bold" id="editAddressModalLabel{{ $addr->id }}">Cập nhật địa chỉ</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label for="edit_recipient_name_{{ $addr->id }}" class="form-label small fw-semibold">Họ tên người nhận <span class="text-danger">*</span></label>
                                            <input type="text" id="edit_recipient_name_{{ $addr->id }}" name="recipient_name" class="form-control" value="{{ old('recipient_name', $addr->recipient_name) }}" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="edit_phone_{{ $addr->id }}" class="form-label small fw-semibold">Số điện thoại <span class="text-danger">*</span></label>
                                            <input type="tel" id="edit_phone_{{ $addr->id }}" name="phone" class="form-control" value="{{ old('phone', $addr->phone) }}" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="edit_address_line_{{ $addr->id }}" class="form-label small fw-semibold">Địa chỉ chi tiết (số nhà, đường) <span class="text-danger">*</span></label>
                                            <input type="text" id="edit_address_line_{{ $addr->id }}" name="address_line" class="form-control" value="{{ old('address_line', $addr->address_line) }}" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="edit_ward_{{ $addr->id }}" class="form-label small fw-semibold">Phường / Xã (tùy chọn)</label>
                                            <input type="text" id="edit_ward_{{ $addr->id }}" name="ward" class="form-control" value="{{ old('ward', $addr->ward) }}">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="edit_district_{{ $addr->id }}" class="form-label small fw-semibold">Quận / Huyện (tùy chọn)</label>
                                            <input type="text" id="edit_district_{{ $addr->id }}" name="district" class="form-control" value="{{ old('district', $addr->district) }}">
                                        </div>
                                        <div class="col-12">
                                            <label for="edit_city_{{ $addr->id }}" class="form-label small fw-semibold">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                            <input type="text" id="edit_city_{{ $addr->id }}" name="city" class="form-control" value="{{ old('city', $addr->city) }}" required>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_default" value="1" id="edit_is_default_{{ $addr->id }}" {{ $addr->is_default ? 'checked' : '' }}>
                                                <label class="form-check-label small" for="edit_is_default_{{ $addr->id }}">
                                                    Đặt làm địa chỉ nhận hàng mặc định
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-top bg-light">
                                    <button type="button" class="btn btn-outline-secondary py-1 px-3 small" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="lunara-button lunara-button--dark py-1 px-3 small">Cập nhật</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Create Address Modal -->
    <div class="modal fade" id="createAddressModal" tabindex="-1" aria-labelledby="createAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('account.addresses.store') }}" method="post">
                    @csrf
                    <div class="modal-header border-bottom">
                        <h4 class="modal-title h5 fw-bold" id="createAddressModalLabel">Thêm địa chỉ nhận hàng mới</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="create_recipient_name" class="form-label small fw-semibold">Họ tên người nhận <span class="text-danger">*</span></label>
                                <input type="text" id="create_recipient_name" name="recipient_name" class="form-control" value="{{ old('recipient_name', auth()->user()->name) }}" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="create_phone" class="form-label small fw-semibold">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" id="create_phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Ví dụ: 0901234567" required>
                            </div>
                            <div class="col-12">
                                <label for="create_address_line" class="form-label small fw-semibold">Địa chỉ chi tiết (số nhà, đường) <span class="text-danger">*</span></label>
                                <input type="text" id="create_address_line" name="address_line" class="form-control" value="{{ old('address_line') }}" placeholder="Ví dụ: 123 Lê Lợi" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="create_ward" class="form-label small fw-semibold">Phường / Xà (tùy chọn)</label>
                                <input type="text" id="create_ward" name="ward" class="form-control" value="{{ old('ward') }}">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="create_district" class="form-label small fw-semibold">Quận / Huyện (tùy chọn)</label>
                                <input type="text" id="create_district" name="district" class="form-control" value="{{ old('district') }}">
                            </div>
                            <div class="col-12">
                                <label for="create_city" class="form-label small fw-semibold">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                <input type="text" id="create_city" name="city" class="form-control" value="{{ old('city', 'Hồ Chí Minh') }}" required>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_default" value="1" id="create_is_default" {{ $addresses->isEmpty() ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="create_is_default">
                                        Đặt làm địa chỉ nhận hàng mặc định
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top bg-light">
                        <button type="button" class="btn btn-outline-secondary py-1 px-3 small" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="lunara-button lunara-button--dark py-1 px-3 small">Lưu địa chỉ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
