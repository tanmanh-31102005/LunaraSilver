@extends('errors.layout')

@section('title', 'Phiên làm việc hết hạn (419)')
@section('code', '419')
@section('headline', 'Phiên làm việc đã hết hạn')
@section('message', 'Phiên thao tác hoặc mã bảo mật xác thực của quý khách đã hết thời hạn bảo lưu. Vui lòng tải lại trang và thực hiện lại thao tác.')

@section('actions')
    <button type="button" onclick="window.location.reload();" class="error-btn error-btn--primary">Tải Lại Trang</button>
    <a href="{{ route('home') }}" class="error-btn error-btn--outline">Về Trang Chủ</a>
@endsection
