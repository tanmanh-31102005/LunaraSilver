@extends('errors.layout')

@section('title', 'Truy cập bị từ chối (403)')
@section('code', '403')
@section('headline', 'Truy cập bị từ chối')
@section('message', 'Quý khách không có quyền truy cập vào tài nguyên hoặc khu vực này. Vui lòng đăng nhập bằng tài khoản có thẩm quyền hoặc quay về trang chủ.')

@section('actions')
    <a href="{{ route('home') }}" class="error-btn error-btn--primary">Về Trang Chủ</a>
    <a href="{{ route('login') }}" class="error-btn error-btn--outline">Đăng Nhập</a>
@endsection
