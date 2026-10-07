@extends('errors.layout')

@section('title', 'Hệ thống bảo trì (503)')
@section('code', '503')
@section('headline', 'Hệ thống đang bảo trì')
@section('message', 'Lunara Silver đang thực hiện nâng cấp định kỳ nhằm mang đến trải nghiệm mua sắm trang sức hoàn hảo nhất. Hệ thống sẽ trở lại hoạt động bình thường trong ít phút.')

@section('actions')
    <button type="button" onclick="window.location.reload();" class="error-btn error-btn--primary">Kiểm Tra Lại</button>
@endsection
