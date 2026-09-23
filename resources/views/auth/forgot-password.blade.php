@extends('layouts.app')

@section('title', 'Quên mật khẩu - Lunara Silver')

@section('content')
    <div class="lunara-container py-5">
        <div class="card auth-card border-0 shadow-sm mx-auto" style="max-width: 480px">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h1 class="h3 font-serif mb-2">Quên mật khẩu</h1>
                    <p class="text-muted small mb-0">Nhập địa chỉ email đã đăng ký để nhận liên kết khôi phục mật khẩu.</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                <form method="post" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="email">Địa chỉ Email <span class="text-danger">*</span></label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus placeholder="example@domain.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button class="lunara-button lunara-button--dark w-100 py-2 mb-3" type="submit">
                        <i class="bi bi-send me-1"></i> Gửi liên kết đặt lại mật khẩu
                    </button>
                </form>

                <div class="auth-divider my-3">
                    <span>hoặc</span>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="auth-link small">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
