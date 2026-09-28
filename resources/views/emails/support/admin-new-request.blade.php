@extends('emails.layout')

@section('content')
    <h2 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-top: 0; margin-bottom: 12px;">
        Yêu cầu hỗ trợ mới từ khách hàng
    </h2>

    <p style="font-size: 14px; color: #4a453f; line-height: 1.6; margin-bottom: 20px;">
        Hệ thống vừa tiếp nhận một yêu cầu hỗ trợ mới trên website Lunara Silver. Vui lòng kiểm tra và xử lý:
    </p>

    <table class="meta-table">
        <tr>
            <td class="label">Mã yêu cầu</td>
            <td class="value"><span class="badge">{{ $contactMessage->reference }}</span></td>
        </tr>
        <tr>
            <td class="label">Khách hàng</td>
            <td class="value">{{ $contactMessage->name }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td class="value">{{ $contactMessage->email }}</td>
        </tr>
        @if($contactMessage->phone)
            <tr>
                <td class="label">Số điện thoại</td>
                <td class="value">{{ $contactMessage->phone }}</td>
            </tr>
        @endif
        @if($contactMessage->order)
            <tr>
                <td class="label">Mã đơn hàng</td>
                <td class="value"><strong>#{{ $contactMessage->order->order_code }}</strong></td>
            </tr>
        @endif
        <tr>
            <td class="label">Chủ đề</td>
            <td class="value">{{ $contactMessage->subject }}</td>
        </tr>
        <tr>
            <td class="label">Thời gian tạo</td>
            <td class="value">{{ $contactMessage->created_at->format('H:i, d/m/Y') }}</td>
        </tr>
    </table>

    <div style="font-size: 13px; color: #8e8880; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em;">Nội dung tin nhắn:</div>
    <div class="quote-box">
        {!! nl2br(e($contactMessage->message)) !!}
    </div>

    <div style="margin: 28px 0 10px; text-align: center;">
        <a href="{{ route('admin.support.show', $contactMessage->id) }}" class="btn-primary" target="_blank">
            Xử lý yêu cầu trong Admin
        </a>
    </div>
@endsection
