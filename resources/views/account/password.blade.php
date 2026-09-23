@extends('layouts.account')

@section('title', 'Đổi mật khẩu | Lunara Silver')

@php
    $accountBreadcrumbs = [['label' => 'Đổi mật khẩu']];
@endphp

@section('account_content')
<div class="account-password">
    <div class="card border-0 shadow-sm rounded-3 bg-white">
        <div class="card-header bg-transparent border-bottom py-3">
            <h2 class="h5 mb-0 fw-bold">Đổi mật khẩu</h2>
            <p class="text-muted small mb-0">Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác.</p>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('account.password.update') }}" method="post" autocomplete="off">
                @csrf
                @method('PATCH')

                <div class="row g-3">
                    <div class="col-12 col-md-8">
                        <label for="current_password" class="form-label fw-semibold">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                        <input type="password"
                               id="current_password"
                               name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               required
                               autocomplete="current-password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-8">
                        <label for="password" class="form-label fw-semibold">Mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required
                               autocomplete="new-password">
                        <small class="text-muted d-block mt-1">Mật khẩu mới phải có ít nhất 8 ký tự.</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-8">
                        <label for="password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="form-control"
                               required
                               autocomplete="new-password">
                    </div>

                    <div class="col-12 mt-4 pt-2 border-top d-flex justify-content-end">
                        <button type="submit" class="lunara-button lunara-button--dark py-2 px-4">
                            <i class="bi bi-shield-check me-1"></i> Cập nhật mật khẩu
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
