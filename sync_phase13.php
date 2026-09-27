<?php

header('Content-Type: text/html; charset=utf-8');

echo "<div style='font-family:sans-serif;max-width:800px;margin:2rem auto;padding:2rem;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;'>";
echo "<h2 style='color:#0f172a;margin-top:0;'>🚀 Đồng bộ PHASE 13 — VNPay Sandbox, QueryDr & Hoàn tiền</h2>";

// 1. Kiểm tra và đồng bộ cấu hình VNPay vào .env
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    $needsUpdate = false;

    $vnpayVars = [
        'APP_TIMEZONE' => 'Asia/Ho_Chi_Minh',
        'VNPAY_SANDBOX' => 'true',
        'VNPAY_TMN_CODE' => '7OO2Y0S8',
        'VNPAY_HASH_SECRET' => 'TRPSTTTYPHQWBATDQWCUWMANEWXLZMGE',
        'VNPAY_URL' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
        'VNPAY_API_URL' => 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction',
        'VNPAY_RETURN_URL' => 'https://lunarasilver.infinityfreeapp.com/payment/vnpay/return',
        'VNPAY_RECONCILIATION_MODE' => 'query',
    ];

    $appended = "\n# VNPay Sandbox Payment Gateway (Phase 13)\n";
    foreach ($vnpayVars as $key => $val) {
        if (!str_contains($envContent, $key . '=')) {
            $appended .= "{$key}={$val}\n";
            $needsUpdate = true;
        }
    }

    if ($needsUpdate) {
        file_put_contents($envPath, $envContent . $appended);
        echo "<p style='color:#16a34a;'>✅ Đã tự động cập nhật biến môi trường VNPay vào tệp <code>.env</code>.</p>";
    } else {
        echo "<p style='color:#0284c7;'>ℹ️ Cấu hình VNPay đã tồn tại trong <code>.env</code>.</p>";
    }
} else {
    echo "<p style='color:#dc2626;'>⚠️ Không tìm thấy tệp <code>.env</code> ở thư mục gốc.</p>";
}

// 2. Khởi tạo Laravel Kernel để chạy Migrations
$autoload = __DIR__ . '/vendor/autoload.php';
$bootstrap = __DIR__ . '/bootstrap/app.php';

if (!file_exists($autoload) || !file_exists($bootstrap)) {
    echo "<p style='color:#dc2626;'>❌ Không tìm thấy Laravel autoload hoặc bootstrap.</p>";
    echo "</div>";
    exit;
}

require_once $autoload;
$app = require_once $bootstrap;

/** @var \Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "<h3>📦 Đang thực thi database migrations...</h3>";
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    $migrateOutput = \Illuminate\Support\Facades\Artisan::output();
    echo "<pre style='background:#1e293b;color:#f8fafc;padding:1rem;border-radius:8px;font-size:0.85rem;overflow:auto;'>" . htmlspecialchars($migrateOutput) . "</pre>";
    echo "<p style='color:#16a34a;'>✅ Quá trình migrate cơ sở dữ liệu đã hoàn tất.</p>";

    echo "<h3>🧹 Đang dọn dẹp bộ nhớ đệm (Cache & View)...</h3>";
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    $clearOutput = \Illuminate\Support\Facades\Artisan::output();
    echo "<pre style='background:#1e293b;color:#f8fafc;padding:1rem;border-radius:8px;font-size:0.85rem;overflow:auto;'>" . htmlspecialchars($clearOutput) . "</pre>";
    echo "<p style='color:#16a34a;'>✅ Đã làm mới cache hệ thống.</p>";

    echo "<hr style='border:0;border-top:1px solid #cbd5e1;margin:1.5rem 0;'>";
    echo "<h3 style='color:#16a34a;'>🎉 PHASE 13 đã sẵn sàng trên InfinityFree!</h3>";
    echo "<p><a href='/' style='display:inline-block;padding:0.6rem 1.2rem;background:#0f172a;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;'>👉 Xem trang chủ Lunara Silver</a></p>";
} catch (\Throwable $e) {
    echo "<p style='color:#dc2626;'>❌ Lỗi: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre style='background:#fef2f2;color:#991b1b;padding:1rem;border-radius:8px;font-size:0.85rem;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

echo "</div>";
