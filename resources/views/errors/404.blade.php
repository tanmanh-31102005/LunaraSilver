@extends('errors.layout')

@section('title', 'Không tìm thấy trang (404)')
@section('code', '404')
@section('headline', 'Không tìm thấy trang')
@section('message', 'Trang quý khách đang tìm kiếm có thể đã đổi địa chỉ, bị gỡ bỏ hoặc tạm thời không khả dụng. Mời quý khách quay lại trang chủ hoặc tiếp tục khám phá bộ sưu tập trang sức Lunara Silver.')

@section('actions')
    <a href="{{ route('home') }}" class="error-btn error-btn--primary">Về Trang Chủ</a>
    <a href="{{ route('products.index') }}" class="error-btn error-btn--outline">Khám Phá Sản Phẩm</a>
@endsection
