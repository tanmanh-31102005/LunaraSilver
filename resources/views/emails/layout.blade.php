<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Lunara Silver' }}</title>
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
        body { margin: 0; padding: 0; width: 100% !important; background-color: #f8f6f2; color: #15171c; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f8f6f2; padding: 40px 16px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden; }
        .header { text-align: center; padding: 36px 30px 24px; border-bottom: 1px solid #e5e7eb; background-color: #ffffff; }
        .header-logo-text { font-family: 'Cormorant Garamond', Georgia, serif; font-size: 22px; letter-spacing: 0.2em; text-transform: uppercase; color: #15171c; margin: 0; font-weight: 500; }
        .header-subtext { font-size: 11px; letter-spacing: 0.15em; text-transform: uppercase; color: #717782; margin-top: 6px; }
        .content { padding: 36px 36px 28px; }
        .footer { padding: 24px 30px; text-align: center; font-size: 12px; color: #717782; border-top: 1px solid #e5e7eb; background-color: #f8f6f2; }
        .footer a { color: #15171c; text-decoration: underline; }
        .btn-primary { display: inline-block; background-color: #15171c; color: #ffffff !important; padding: 12px 28px; text-decoration: none; font-size: 13px; letter-spacing: 0.08em; text-transform: uppercase; border-radius: 6px; font-weight: 500; }
        .badge { display: inline-block; padding: 4px 10px; font-size: 12px; letter-spacing: 0.05em; background-color: #f1efec; color: #15171c; border-radius: 4px; }
        .meta-table { width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; }
        .meta-table td { padding: 10px 14px; font-size: 13px; border-bottom: 1px solid #e5e7eb; }
        .meta-table td.label { color: #717782; width: 35%; }
        .meta-table td.value { color: #15171c; font-weight: 500; }
        .meta-table tr:last-child td { border-bottom: none; }
        .quote-box { background-color: #f8f6f2; border-left: 3px solid #b59a75; padding: 14px 18px; margin: 18px 0; font-size: 13px; color: #15171c; line-height: 1.6; border-radius: 0 4px 4px 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table role="presentation" class="container" width="100%" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td class="header">
                    <a href="{{ config('app.url') }}" target="_blank" style="text-decoration: none; color: inherit;">
                        <h1 class="header-logo-text">LUNARA SILVER</h1>
                        <div class="header-subtext">Haute Joaillerie &bull; Dịch vụ khách hàng</div>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="content">
                    @yield('content')
                </td>
            </tr>
            <tr>
                <td class="footer">
                    <p style="margin: 0 0 8px;">Lunara Silver — Tinh hoa trang sức bạc thủ công cao cấp.</p>
                    <p style="margin: 0 0 8px;">Nếu cần thêm thông tin, quý khách có thể liên hệ với chúng tôi tại <a href="{{ url('/support') }}">Trung tâm hỗ trợ</a>.</p>
                    <p style="margin: 12px 0 0; font-size: 11px; color: #a9a49c;">&copy; {{ date('Y') }} Lunara Silver. All rights reserved.</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
