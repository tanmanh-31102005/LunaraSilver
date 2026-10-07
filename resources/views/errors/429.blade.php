@extends('errors.layout')

@section('title', 'Quá nhiều yêu cầu (429)')
@section('code', '429')
@section('headline', 'Yêu cầu quá giới hạn')
@section('message', 'Hệ thống ghi nhận quá nhiều lượt yêu cầu liên tiếp từ thiết bị của quý khách nhằm đảm bảo an toàn vận hành. Vui lòng tạm nghỉ vài giây trước khi tiếp tục thao tác.')

@section('actions')
    <button type="button" onclick="window.location.reload();" class="error-btn error-btn--primary">Thử Lại Sau Giây Lát</button>
    <a href="{{ route('home') }}" class="error-btn error-btn--outline">Về Trang Chủ</a>
@endsection
