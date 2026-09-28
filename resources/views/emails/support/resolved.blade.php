@extends('emails.layout')

@section('content')
    <h2 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-top: 0; margin-bottom: 12px;">
        Kính chào quý khách {{ $contactMessage->name }},
    </h2>

    <p style="font-size: 14px; color: #4a453f; line-height: 1.6; margin-bottom: 20px;">
        Yêu cầu hỗ trợ của quý khách đã được giải quyết hoàn tất. Cảm ơn quý khách đã tin tưởng và đồng hành cùng Lunara Silver.
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
        <tr>
            <td class="label">Trạng thái</td>
            <td class="value" style="color: #2e7d32; font-weight: 600;">Đã giải quyết</td>
        </tr>
        <tr>
            <td class="label">Thời gian cập nhật</td>
            <td class="value">{{ $contactMessage->updated_at->format('H:i, d/m/Y') }}</td>
        </tr>
    </table>

    <div style="margin: 28px 0 10px; text-align: center;">
        <a href="{{ $actionUrl ?? url('/support') }}" class="btn-primary" target="_blank">
            Đến Trung Tâm Hỗ Trợ
        </a>
    </div>

    <p style="font-size: 13px; color: #8e8880; line-height: 1.5; margin-top: 20px;">
        Nếu quý khách vẫn còn bất kỳ thắc mắc nào, xin vui lòng tạo một yêu cầu mới hoặc liên hệ trực tiếp với chúng tôi.
    </p>
@endsection
