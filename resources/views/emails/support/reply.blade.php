@extends('emails.layout')

@section('content')
    <h2 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-top: 0; margin-bottom: 12px;">
        Kính chào quý khách {{ $customerName }},
    </h2>

    <p style="font-size: 14px; color: #4a453f; line-height: 1.6; margin-bottom: 20px;">
        Chuyên viên tư vấn của Lunara Silver đã phản hồi yêu cầu hỗ trợ <span class="badge">{{ $reference }}</span> của quý khách:
    </p>

    <div class="quote-box" style="border-left-color: #1a1a1a; background-color: #f7f6f2;">
        {!! nl2br(e($replyContent)) !!}
    </div>

    @if($originalSubject)
        <table class="meta-table">
            <tr>
                <td class="label">Mã yêu cầu</td>
                <td class="value">{{ $reference }}</td>
            </tr>
            <tr>
                <td class="label">Chủ đề gốc</td>
                <td class="value">{{ $originalSubject }}</td>
            </tr>
        </table>
    @endif

    <div style="margin: 28px 0 10px; text-align: center;">
        <a href="{{ $actionUrl ?? url('/support') }}" class="btn-primary" target="_blank">
            Xem Trung Tâm Hỗ Trợ
        </a>
    </div>

    <p style="font-size: 13px; color: #8e8880; line-height: 1.5; margin-top: 20px;">
        Nếu quý khách cần trao đổi thêm, quý khách có thể gửi phản hồi trực tiếp hoặc sử dụng tính năng Trò chuyện trực tuyến trên website của chúng tôi.
    </p>
@endsection
