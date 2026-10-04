<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

header('Content-Type: text/html; charset=utf-8');

echo "<div style='font-family:sans-serif;max-width:850px;margin:2rem auto;padding:2rem;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;'>";
echo "<h2 style='color:#0f172a;margin-top:0;'>🚀 Đồng bộ PHASE 18 (SEO Architecture & Structured Data)</h2>";

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
    echo '<h3>📦 1. Đang thực thi database migrations (Phase 18)...</h3>';
    Artisan::call('migrate', ['--force' => true]);
    $migrateOutput = Artisan::output();
    echo "<pre style='background:#1e293b;color:#f8fafc;padding:1rem;border-radius:8px;font-size:0.85rem;overflow:auto;'>".htmlspecialchars($migrateOutput).'</pre>';
    echo "<p style='color:#16a34a;'>✅ Quá trình migrate cơ sở dữ liệu đã hoàn tất.</p>";

    echo '<h3>🔍 2. Kiểm tra schema columns (SEO Fields & Redirects)...</h3>';
    $catCols = Schema::getColumnListing('categories');
    $redirectsExists = Schema::hasTable('seo_redirects');

    $checkResults = [
        'categories.seo_title' => in_array('seo_title', $catCols, true),
        'categories.seo_description' => in_array('seo_description', $catCols, true),
        'categories.seo_intro' => in_array('seo_intro', $catCols, true),
        'table: seo_redirects' => $redirectsExists,
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

    echo "<p style='margin-top:1.5rem;color:#16a34a;font-weight:bold;'>🎉 HOÀN TẤT ĐỒNG BỘ PHASE 18 (SEO ARCHITECTURE) TRÊN INFINITYFREE!</p>";
} catch (Throwable $e) {
    echo "<p style='color:#dc2626;'>❌ Lỗi: ".htmlspecialchars($e->getMessage()).'</p>';
    echo "<pre style='background:#fef2f2;color:#991b1b;padding:1rem;border-radius:8px;font-size:0.8rem;overflow:auto;'>".htmlspecialchars($e->getTraceAsString()).'</pre>';
}

echo '</div>';
