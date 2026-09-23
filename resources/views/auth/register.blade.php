@extends('layouts.app')

@section('title', 'Đăng ký - Lunara Silver')

@section('content')
    <div class="lunara-container py-5">
        <div class="card auth-card border-0 shadow-sm mx-auto" style="max-width: 480px">
            <div class="card-body p-4 p-md-5">
                <h1 class="h3 font-serif mb-4 text-center">Đăng ký</h1>

                @php
                    $intendedUrl = session('url.intended', '');
                    $fromCheckout = str_contains($intendedUrl, '/checkout');
                @endphp

                @if($fromCheckout)
                    <div class="alert alert-info border-0 shadow-sm mb-4 small" role="alert" style="background: rgba(184, 156, 169, 0.15); color: var(--lunara-midnight); border-left: 3px solid var(--lunara-accent) !important;">
                        <i class="bi bi-info-circle me-1"></i> Vui lòng đăng nhập hoặc đăng ký để tiếp tục thanh toán. Giỏ hàng của bạn vẫn được giữ nguyên.
                    </div>
                @endif

                <form method="post" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="name">Họ tên</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="password">Mật khẩu</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" autocomplete="new-password" minlength="8" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="password_confirmation">Xác nhận mật khẩu</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" required>
                    </div>
                    <button class="lunara-button lunara-button--dark w-100 py-2" type="submit">Đăng ký</button>
                </form>

                <div class="auth-divider my-4">
                    <span>hoặc</span>
                </div>

                <p class="auth-switch text-center mb-0 small">
                    Đã có tài khoản? <a href="{{ route('login') }}" class="auth-link fw-semibold">Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
@endsection
