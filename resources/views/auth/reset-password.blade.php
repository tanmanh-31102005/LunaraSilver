@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu - Lunara Silver')

@section('content')
    <div class="lunara-container py-5">
        <div class="card auth-card border-0 shadow-sm mx-auto" style="max-width: 480px">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h1 class="h3 font-serif mb-2">Đặt lại mật khẩu</h1>
                    <p class="text-muted small mb-0">Tạo mật khẩu mới an toàn cho tài khoản Lunara của bạn.</p>
                </div>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="email">Địa chỉ Email <span class="text-danger">*</span></label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email', $email) }}" autocomplete="email" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="password">Mật khẩu mới <span class="text-danger">*</span></label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" autocomplete="new-password" required minlength="8">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="password_confirmation">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required minlength="8">
                    </div>

                    <button class="lunara-button lunara-button--dark w-100 py-2 mb-3" type="submit">
                        <i class="bi bi-shield-check me-1"></i> Cập nhật mật khẩu mới
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="auth-link small">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
