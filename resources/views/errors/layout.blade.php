<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Lunara Silver</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css'])
    <style>
        .error-page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, #faf9f6 0%, #f4f1eb 100%);
            color: #1e293b;
            font-family: 'Inter', system-ui, sans-serif;
        }
        .error-header {
            padding: 24px 0;
            border-bottom: 1px solid rgba(212, 197, 185, 0.3);
            text-align: center;
        }
        .error-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 16px;
        }
        .error-card {
            max-width: 580px;
            width: 100%;
            background: #ffffff;
            border: 1px solid rgba(212, 197, 185, 0.45);
            border-radius: 16px;
            padding: 48px 36px;
            text-align: center;
            box-shadow: 0 10px 30px -5px rgba(26, 32, 44, 0.06);
            position: relative;
            overflow: hidden;
        }
        .error-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #d4af37, #f3e5ab, #d4af37);
        }
        .error-code {
            font-family: 'Playfair Display', serif;
            font-size: 5rem;
            font-weight: 600;
            line-height: 1;
            color: #0f172a;
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }
        .error-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.65rem;
            color: #1e293b;
            margin-bottom: 16px;
        }
        .error-desc {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.65;
            margin-bottom: 32px;
        }
        .error-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }
        .error-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .error-btn--primary {
            background-color: #0f172a;
            color: #ffffff;
        }
        .error-btn--primary:hover {
            background-color: #1e293b;
            color: #ffffff;
        }
        .error-btn--outline {
            border: 1px solid #cbd5e1;
            background-color: transparent;
            color: #334155;
        }
        .error-btn--outline:hover {
            border-color: #94a3b8;
            background-color: #f8fafc;
            color: #0f172a;
        }
        .error-footer {
            padding: 20px 0;
            text-align: center;
            font-size: 0.8rem;
            color: #94a3b8;
            border-top: 1px solid rgba(212, 197, 185, 0.2);
        }
    </style>
</head>
<body class="error-page-wrapper">
    <header class="error-header">
        <a href="{{ route('home') }}" aria-label="Lunara Silver — Về trang chủ">
            <img src="{{ route('media.show', ['path' => 'lunara-logo-dark.svg']) }}" alt="Lunara Silver" width="160" height="66" style="height: 48px; width: auto;">
        </a>
    </header>

    <main class="error-main" id="main-content">
        <div class="error-card">
            <div class="error-code">@yield('code')</div>
            <h1 class="error-title">@yield('headline')</h1>
            <p class="error-desc">@yield('message')</p>
            <div class="error-actions">
                @yield('actions')
            </div>
        </div>
    </main>

    <footer class="error-footer">
        <span>© {{ date('Y') }} Lunara Silver · Shine with your own moonlight.</span>
    </footer>
</body>
</html>
