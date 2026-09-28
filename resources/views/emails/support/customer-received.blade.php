@extends('emails.layout')

@section('content')
    <h2 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-top: 0; margin-bottom: 12px; letter-spacing: -0.01em;">
        Kính chào quý khách {{ $contactMessage->name }},
    </h2>

    <p style="font-size: 14px; color: #4a453f; line-height: 1.6; margin-bottom: 20px;">
        Lunara Silver đã nhận được thông tin liên hệ của quý khách. Đội ngũ chuyên viên chăm sóc khách hàng đang xử lý và sẽ phản hồi quý khách trong thời gian sớm nhất.
    </p>

    <table class="meta-table">
        <tr>
            <td class="label">Mã yêu cầu</td>
            <td class="value"><span class="badge">{{ $contactMessage->reference }}</span></td>
        </tr>
        <tr>
            <td class="label">Chủ đề</td>
            <td class="value">{{ $contactMessage->subject }}</td>
        </tr>
        @if($contactMessage->order)
            <tr>
                <td class="label">Đơn hàng liên quan</td>
                <td class="value">#{{ $contactMessage->order->order_code }}</td>
            </tr>
        @endif
        <tr>
            <td class="label">Thời gian tiếp nhận</td>
            <td class="value">{{ $contactMessage->created_at->format('H:i, d/m/Y') }}</td>
        </tr>
    </table>

    <div style="font-size: 13px; color: #8e8880; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em;">Nội dung quý khách gửi:</div>
    <div class="quote-box">
        {!! nl2br(e($contactMessage->message)) !!}
    </div>

    <div style="margin: 28px 0 10px; text-align: center;">
        <a href="{{ url('/support') }}" class="btn-primary" target="_blank">
            Đến Trung Tâm Hỗ Trợ
        </a>
    </div>

    <p style="font-size: 12px; color: #8e8880; text-align: center; margin-top: 16px;">
        Quý khách vui lòng lưu giữ mã yêu cầu <strong>{{ $contactMessage->reference }}</strong> khi cần hỗ trợ thêm.
    </p>
@endsection
