@extends('layouts.app')

@section('title', 'Đăng nhập - Lunara Silver')

@section('content')
    <div class="lunara-container py-5">
        <div class="card auth-card border-0 shadow-sm mx-auto" style="max-width: 480px">
            <div class="card-body p-4 p-md-5">
                <h1 class="h3 font-serif mb-4 text-center">Đăng nhập</h1>

                @php
                    $intendedUrl = session('url.intended', '');
                    $fromCheckout = str_contains($intendedUrl, '/checkout');
                @endphp

                @if($fromCheckout)
                    <div class="alert alert-info border-0 shadow-sm mb-4 small" role="alert" style="background: rgba(184, 156, 169, 0.15); color: var(--lunara-midnight); border-left: 3px solid var(--lunara-accent) !important;">
                        <i class="bi bi-info-circle me-1"></i> Vui lòng đăng nhập hoặc đăng ký để tiếp tục thanh toán. Giỏ hàng của bạn vẫn được giữ nguyên.
                    </div>
                @endif

                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                <form method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label fw-semibold mb-0" for="password">Mật khẩu</label>
                            <a href="{{ route('password.request') }}" class="auth-sublink small">Quên mật khẩu?</a>
                        </div>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" autocomplete="current-password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button class="lunara-button lunara-button--dark w-100 py-2" type="submit">Đăng nhập</button>
                </form>

                <div class="auth-divider my-4">
                    <span>hoặc</span>
                </div>

                <p class="auth-switch text-center mb-0 small">
                    Chưa có tài khoản? <a href="{{ route('register') }}" class="auth-link fw-semibold">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </div>
@endsection
