<?php

use App\Models\Faq;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

header('Content-Type: text/html; charset=utf-8');

echo "<div style='font-family:sans-serif;max-width:800px;margin:2rem auto;padding:2rem;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;'>";
echo "<h2 style='color:#0f172a;margin-top:0;'>🚀 Đồng bộ PHASE 14 — Customer Support Center & Gmail SMTP</h2>";

// 1. Kiểm tra và đồng bộ cấu hình Gmail SMTP vào .env
$envPath = __DIR__.'/.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    $needsUpdate = false;

    $mailVars = [
        'MAIL_MAILER' => 'smtp',
        'MAIL_SCHEME' => 'smtp',
        'MAIL_HOST' => 'smtp.gmail.com',
        'MAIL_PORT' => '587',
        'MAIL_USERNAME' => 'lunaraslivertrangsuc@gmail.com',
        'MAIL_PASSWORD' => '"bijr huja qlef uyyc"',
        'MAIL_ENCRYPTION' => 'tls',
        'MAIL_FROM_ADDRESS' => 'lunaraslivertrangsuc@gmail.com',
        'MAIL_FROM_NAME' => '"Lunara Silver"',
    ];

    $appended = "\n# Gmail SMTP (Phase 14)\n";
    foreach ($mailVars as $key => $val) {
        if (! str_contains($envContent, $key.'=')) {
            $appended .= "{$key}={$val}\n";
            $needsUpdate = true;
        } else {
            // Update key if existing value was null or log
            $pattern = '/^'.preg_quote($key).'=.*/m';
            if ($key === 'MAIL_MAILER' && preg_match('/^MAIL_MAILER=(log|array)/m', $envContent)) {
                $envContent = preg_replace('/^MAIL_MAILER=.*/m', 'MAIL_MAILER=smtp', $envContent);
                $needsUpdate = true;
            } elseif ($key === 'MAIL_HOST' && preg_match('/^MAIL_HOST=(127\.0\.0\.1|localhost)/m', $envContent)) {
                $envContent = preg_replace('/^MAIL_HOST=.*/m', 'MAIL_HOST=smtp.gmail.com', $envContent);
                $needsUpdate = true;
            } elseif ($key === 'MAIL_PORT' && preg_match('/^MAIL_PORT=(2525|1025)/m', $envContent)) {
                $envContent = preg_replace('/^MAIL_PORT=.*/m', 'MAIL_PORT=587', $envContent);
                $needsUpdate = true;
            } elseif ($key === 'MAIL_USERNAME' && (str_contains($envContent, 'MAIL_USERNAME=null') || str_contains($envContent, 'MAIL_USERNAME='))) {
                $envContent = preg_replace('/^MAIL_USERNAME=.*/m', 'MAIL_USERNAME=lunaraslivertrangsuc@gmail.com', $envContent);
                $needsUpdate = true;
            } elseif ($key === 'MAIL_PASSWORD' && (str_contains($envContent, 'MAIL_PASSWORD=null') || str_contains($envContent, 'MAIL_PASSWORD='))) {
                $envContent = preg_replace('/^MAIL_PASSWORD=.*/m', 'MAIL_PASSWORD="bijr huja qlef uyyc"', $envContent);
                $needsUpdate = true;
            }
        }
    }

    if ($needsUpdate) {
        file_put_contents($envPath, $envContent.$appended);
        echo "<p style='color:#16a34a;'>✅ Đã tự động cập nhật cấu hình Gmail SMTP vào tệp <code>.env</code>.</p>";
    } else {
        echo "<p style='color:#0284c7;'>ℹ️ Cấu hình Mail đã tồn tại trong <code>.env</code>.</p>";
    }
} else {
    echo "<p style='color:#dc2626;'>⚠️ Không tìm thấy tệp <code>.env</code> ở thư mục gốc.</p>";
}

// 2. Khởi tạo Laravel Kernel để chạy Migrations
$autoload = __DIR__.'/vendor/autoload.php';
$bootstrap = __DIR__.'/bootstrap/app.php';

if (! file_exists($autoload) || ! file_exists($bootstrap)) {
    echo "<p style='color:#dc2626;'>❌ Không tìm thấy Laravel autoload hoặc bootstrap.</p>";
    echo '</div>';
    exit;
}

require_once $autoload;
$app = require_once $bootstrap;

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

try {
    echo '<h3>📦 Đang thực thi database migrations...</h3>';
    Artisan::call('migrate', ['--force' => true]);
    $migrateOutput = Artisan::output();
    echo "<pre style='background:#1e293b;color:#f8fafc;padding:1rem;border-radius:8px;font-size:0.85rem;overflow:auto;'>".htmlspecialchars($migrateOutput).'</pre>';
    echo "<p style='color:#16a34a;'>✅ Quá trình migrate cơ sở dữ liệu đã hoàn tất.</p>";

    // 3. Seed FAQ nếu bảng trống
    if (Faq::count() === 0) {
        echo '<h3>🌱 Đang khởi tạo dữ liệu câu hỏi thường gặp (FAQ Seeder)...</h3>';
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\FaqSeeder', '--force' => true]);
        echo "<p style='color:#16a34a;'>✅ Đã nạp thành công bộ câu hỏi FAQ chuẩn Lunara Silver.</p>";
    }

    echo '<h3>🧹 Đang dọn dẹp bộ nhớ đệm (Cache & View)...</h3>';
    Artisan::call('optimize:clear');
    $clearOutput = Artisan::output();
    echo "<pre style='background:#1e293b;color:#f8fafc;padding:1rem;border-radius:8px;font-size:0.85rem;overflow:auto;'>".htmlspecialchars($clearOutput).'</pre>';
    echo "<p style='color:#16a34a;'>✅ Đã làm mới toàn bộ bộ nhớ đệm ứng dụng.</p>";

    // 4. Kiểm tra các bảng Phase 14 trong CSDL
    $tables = ['faqs', 'contact_messages', 'support_conversations', 'support_messages', 'email_logs'];
    echo '<h3>🔍 Kiểm tra tính sẵn sàng của bảng cơ sở dữ liệu:</h3>';
    echo '<ul>';
    foreach ($tables as $table) {
        $count = DB::table($table)->count();
        echo "<li>Bảng <code>{$table}</code>: <strong style='color:#16a34a;'>SẴN SÀNG</strong> ({$count} bản ghi)</li>";
    }
    echo '</ul>';

    echo "<div style='margin-top:2rem;padding:1rem;background:#ecfdf5;border:1px solid #6ee7b7;border-radius:8px;'>";
    echo "<h4 style='color:#065f46;margin-top:0;'>🎉 ĐỒNG BỘ PHASE 14 HOÀN TẤT THÀNH CÔNG!</h4>";
    echo "<p style='color:#047857;margin-bottom:0;'>Hệ thống Trung tâm hỗ trợ (FAQ, Contact Form, Admin Inbox, Live Chat polling, Gmail SMTP) đã sẵn sàng phục vụ.</p>";
    echo "<div style='margin-top:1rem;'>";
    echo "<a href='/support' style='display:inline-block;padding:0.5rem 1rem;background:#0f172a;color:#fff;text-decoration:none;border-radius:6px;margin-right:0.5rem;'>Xem Trung tâm hỗ trợ</a>";
    echo "<a href='/admin/support' style='display:inline-block;padding:0.5rem 1rem;background:#0284c7;color:#fff;text-decoration:none;border-radius:6px;'>Truy cập Admin Support</a>";
    echo '</div>';
    echo '</div>';

} catch (Throwable $e) {
    echo "<div style='margin-top:2rem;padding:1rem;background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;'>";
    echo "<h4 style='color:#991b1b;margin-top:0;'>❌ LỖI TRONG QUÁ TRÌNH ĐỒNG BỘ</h4>";
    echo "<pre style='color:#b91c1c;white-space:pre-wrap;'>".htmlspecialchars($e->getMessage()).'</pre>';
    echo "<pre style='color:#b91c1c;font-size:0.75rem;white-space:pre-wrap;'>".htmlspecialchars($e->getTraceAsString()).'</pre>';
    echo '</div>';
}

echo '</div>';
