<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

header('Content-Type: text/html; charset=utf-8');

echo "<div style='font-family:sans-serif;max-width:850px;margin:2rem auto;padding:2rem;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;'>";
echo "<h2 style='color:#0f172a;margin-top:0;'>🚀 Đồng bộ PHASE 20 (Verified Reviews, Trust & Product Discovery)</h2>";

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
    echo '<h3>📦 1. Đang thực thi database migrations (Phase 20)...</h3>';
    Artisan::call('migrate', ['--force' => true]);
    $migrateOutput = Artisan::output();
    echo "<pre style='background:#1e293b;color:#f8fafc;padding:1rem;border-radius:8px;font-size:0.85rem;overflow:auto;'>".htmlspecialchars($migrateOutput).'</pre>';
    echo "<p style='color:#16a34a;'>✅ Quá trình migrate cơ sở dữ liệu đã hoàn tất.</p>";

    echo '<h3>🔍 2. Kiểm tra schema columns & tables (Phase 20)...</h3>';
    $reviewCols = Schema::getColumnListing('reviews');
    $cartCols = Schema::getColumnListing('cart_items');
    $orderItemCols = Schema::getColumnListing('order_items');
    $mediaExists = Schema::hasTable('review_media');

    $checkResults = [
        'reviews.order_item_id' => in_array('order_item_id', $reviewCols, true),
        'reviews.verified_purchase' => in_array('verified_purchase', $reviewCols, true),
        'reviews.title' => in_array('title', $reviewCols, true),
        'reviews.content' => in_array('content', $reviewCols, true),
        'reviews.admin_reply' => in_array('admin_reply', $reviewCols, true),
        'table: review_media' => $mediaExists,
        'cart_items.gift_message' => in_array('gift_message', $cartCols, true),
        'order_items.gift_message' => in_array('gift_message', $orderItemCols, true),
    ];

    echo "<ul style='font-size:0.9rem;line-height:1.8;'>";
    foreach ($checkResults as $col => $exists) {
        $icon = $exists ? '✅' : '❌';
        $status = $exists ? 'ĐÃ TỒN TẠI' : 'CHƯA TỒN TẠI';
        echo "<li>{$icon} <code>{$col}</code>: <strong>{$status}</strong></li>";
    }
    echo '</ul>';

    echo '<h3>🧹 3. Đang dọn dẹp bộ nhớ đệm (Cache, Route & View)...</h3>';
    Artisan::call('optimize:clear');
    $clearOutput = Artisan::output();
    echo "<pre style='background:#1e293b;color:#f8fafc;padding:1rem;border-radius:8px;font-size:0.85rem;overflow:auto;'>".htmlspecialchars($clearOutput).'</pre>';
    echo "<p style='color:#16a34a;'>✅ Đã làm mới cache hệ thống.</p>";

    echo "<p style='margin-top:1.5rem;color:#16a34a;font-weight:bold;'>🎉 HOÀN TẤT ĐỒNG BỘ PHASE 20 (VERIFIED REVIEWS & DISCOVERY) TRÊN INFINITYFREE!</p>";
} catch (Throwable $e) {
    echo "<p style='color:#dc2626;'>❌ Lỗi: ".htmlspecialchars($e->getMessage()).'</p>';
    echo "<pre style='background:#fef2f2;color:#991b1b;padding:1rem;border-radius:8px;font-size:0.8rem;overflow:auto;'>".htmlspecialchars($e->getTraceAsString()).'</pre>';
}

echo '</div>';
