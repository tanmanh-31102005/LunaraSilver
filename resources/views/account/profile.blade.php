@extends('layouts.account')

@section('title', 'Thông tin cá nhân | Lunara Silver')

@php
    $accountBreadcrumbs = [['label' => 'Thông tin cá nhân']];
@endphp

@section('account_content')
<div class="account-profile">
    <div class="card border-0 shadow-sm rounded-3 bg-white">
        <div class="card-header bg-transparent border-bottom py-3">
            <h2 class="h5 mb-0 fw-bold">Thông tin cá nhân</h2>
            <p class="text-muted small mb-0">Cập nhật họ tên và địa chỉ email liên hệ của bạn.</p>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('account.profile.update') }}" method="post">
                @csrf
                @method('PATCH')

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="name" class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}"
                               required
                               autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label fw-semibold">Địa chỉ Email <span class="text-danger">*</span></label>
                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}"
                               required
                               autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mt-4 pt-2 border-top d-flex justify-content-end">
                        <button type="submit" class="lunara-button lunara-button--dark py-2 px-4">
                            <i class="bi bi-check2 me-1"></i> Lưu thay đổi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
