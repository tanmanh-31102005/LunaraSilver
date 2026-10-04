@extends('layouts.account')

@section('title', 'Sản phẩm yêu thích | Lunara Silver')

@php
    $accountBreadcrumbs = [['label' => 'Sản phẩm yêu thích']];
@endphp

@section('account_content')
<div class="account-wishlist">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <div>
            <h1 class="h4 font-serif text-dark mb-1">Sản Phẩm Yêu Thích</h1>
            <p class="text-muted small mb-0">Lưu lại những thiết kế trang sức bạn quan tâm để dễ dàng xem lại và đặt mua.</p>
        </div>
        <div>
            <span class="badge bg-dark-subtle text-dark border px-3 py-2" id="wishlistHeaderCount">
                {{ $count }} sản phẩm
            </span>
        </div>
    </div>

    @include('account.wishlist._items', ['products' => $products])
</div>
@endsection
