@extends('errors.layout')

@section('title', 'Lỗi hệ thống (500)')
@section('code', '500')
@section('headline', 'Đã xảy ra sự cố gián đoạn')
@section('message', 'Hệ thống máy chủ đang gặp trục trặc kỹ thuật tạm thời trong quá trình xử lý yêu cầu. Đội ngũ kỹ thuật Lunara Silver đã được thông báo và đang tiến hành khắc phục nhanh chóng.')

@section('actions')
    <button type="button" onclick="window.location.reload();" class="error-btn error-btn--primary">Tải Lại Trang</button>
    <a href="{{ route('home') }}" class="error-btn error-btn--outline">Về Trang Chủ</a>
@endsection
