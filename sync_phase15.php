<?php

use App\Models\Coupon;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

header('Content-Type: text/html; charset=utf-8');

echo "<div style='font-family:sans-serif;max-width:850px;margin:2rem auto;padding:2rem;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;'>";
echo "<h2 style='color:#0f172a;margin-top:0;'>🎟️ Đồng bộ PHASE 15 — Promotion & Coupon Engine</h2>";

// 1. Khởi tạo Laravel Kernel
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
    echo '<h3>📦 1. Đang thực thi database migrations...</h3>';
    Artisan::call('migrate', ['--force' => true]);
    $migrateOutput = Artisan::output();
    echo "<pre style='background:#1e293b;color:#f8fafc;padding:1rem;border-radius:8px;font-size:0.85rem;overflow:auto;'>".htmlspecialchars($migrateOutput).'</pre>';
    echo "<p style='color:#16a34a;'>✅ Quá trình migrate cơ sở dữ liệu đã hoàn tất.</p>";

    echo '<h3>🔍 2. Kiểm tra schema columns...</h3>';
    $couponCols = Schema::getColumnListing('coupons');
    $usageCols = Schema::getColumnListing('coupon_usages');
    $orderCols = Schema::getColumnListing('orders');

    $checkResults = [
        'coupons.usage_limit_per_user' => in_array('usage_limit_per_user', $couponCols, true),
        'coupon_usages.status' => in_array('status', $usageCols, true),
        'coupon_usages.used_at' => in_array('used_at', $usageCols, true),
        'coupon_usages.released_at' => in_array('released_at', $usageCols, true),
        'orders.coupon_code' => in_array('coupon_code', $orderCols, true),
    ];

    echo "<ul style='font-size:0.9rem;line-height:1.8;'>";
    foreach ($checkResults as $col => $exists) {
        $icon = $exists ? '✅' : '❌';
        $status = $exists ? 'ĐÃ TỒN TẠI' : 'CHƯA TỒN TẠI';
        echo "<li>{$icon} Cột <code>{$col}</code>: <strong>{$status}</strong></li>";
    }
    echo '</ul>';

    echo '<h3>🌱 3. Khởi tạo mã khuyến mãi mẫu nếu chưa có...</h3>';
    if (Coupon::count() === 0) {
        Coupon::create([
            'code' => 'LUNARA10',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 10,
            'minimum_order' => 200000,
            'maximum_discount' => 100000,
            'usage_limit' => 100,
            'usage_limit_per_user' => 2,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'LUNARA50K',
            'type' => Coupon::TYPE_FIXED,
            'value' => 50000,
            'minimum_order' => 300000,
            'usage_limit' => 50,
            'usage_limit_per_user' => 1,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'CHAOHEXINH',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 15,
            'minimum_order' => 400000,
            'maximum_discount' => 150000,
            'usage_limit' => 200,
            'usage_limit_per_user' => 1,
            'is_active' => true,
        ]);

        echo "<p style='color:#16a34a;'>✅ Đã nạp 3 mã ưu đãi mẫu (<code>LUNARA10</code>, <code>LUNARA50K</code>, <code>CHAOHEXINH</code>).</p>";
    } else {
        echo "<p style='color:#0284c7;'>ℹ️ Đã có ".Coupon::count().' mã ưu đãi trong cơ sở dữ liệu.</p>';
    }

    echo '<h3>🧹 4. Đang dọn dẹp bộ nhớ đệm (Cache, Route & View)...</h3>';
    Artisan::call('optimize:clear');
    $clearOutput = Artisan::output();
    echo "<pre style='background:#1e293b;color:#f8fafc;padding:1rem;border-radius:8px;font-size:0.85rem;overflow:auto;'>".htmlspecialchars($clearOutput).'</pre>';
    echo "<p style='color:#16a34a;'>✅ Đã làm mới cache hệ thống.</p>";

    echo '<h3>🎟️ 5. Danh sách mã giảm giá hiện có trên Host...</h3>';
    $coupons = Coupon::all();
    echo "<table border='1' cellpadding='8' style='border-collapse:collapse;width:100%;font-size:0.85rem;background:#fff;'>";
    echo "<tr style='background:#f1f5f9;'><th>ID</th><th>Mã Code</th><th>Loại</th><th>Giá trị</th><th>Đơn tối thiểu</th><th>Giảm tối đa</th><th>Lượt dùng</th><th>Trạng thái</th></tr>";
    foreach ($coupons as $c) {
        $valDisplay = $c->type === 'percentage' ? (float) $c->value.'%' : number_format($c->value, 0, ',', '.').' ₫';
        $minDisplay = $c->minimum_order ? number_format($c->minimum_order, 0, ',', '.').' ₫' : '0 ₫';
        $maxDisplay = $c->maximum_discount ? number_format($c->maximum_discount, 0, ',', '.').' ₫' : '—';
        $stDisplay = $c->is_active ? "<span style='color:green;font-weight:bold;'>Bật</span>" : "<span style='color:red;'>Tắt</span>";
        echo "<tr>
            <td>{$c->id}</td>
            <td><b>{$c->code}</b></td>
            <td>{$c->type}</td>
            <td>{$valDisplay}</td>
            <td>{$minDisplay}</td>
            <td>{$maxDisplay}</td>
            <td>{$c->used_count} / ".($c->usage_limit ?: '∞')."</td>
            <td>{$stDisplay}</td>
        </tr>";
    }
    echo '</table>';

    echo "<p style='margin-top:1.5rem;color:#16a34a;font-weight:bold;'>🎉 HOÀN TẤT ĐỒNG BỘ PHASE 15 TRÊN INFINITYFREE!</p>";
} catch (Throwable $e) {
    echo "<p style='color:#dc2626;'>❌ Lỗi: ".htmlspecialchars($e->getMessage()).'</p>';
    echo "<pre style='background:#fef2f2;color:#991b1b;padding:1rem;border-radius:8px;font-size:0.8rem;overflow:auto;'>".htmlspecialchars($e->getTraceAsString()).'</pre>';
}

echo '</div>';
