<?php

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

header('Content-Type: text/html; charset=utf-8');

echo "<div style='font-family:sans-serif;max-width:850px;margin:2rem auto;padding:2rem;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;'>";
echo "<h2 style='color:#0f172a;margin-top:0;'>📰 Đồng bộ PHASE 15 (Option A) & PHASE 16 (Blog Journal)</h2>";

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

    echo '<h3>🔍 2. Kiểm tra schema columns (Coupons & Blog)...</h3>';
    $couponCols = Schema::getColumnListing('coupons');
    $postCols = Schema::getColumnListing('posts');
    $categoryCols = Schema::getColumnListing('post_categories');

    $checkResults = [
        'coupons.is_first_order_only' => in_array('is_first_order_only', $couponCols, true),
        'coupons.applicable_categories' => in_array('applicable_categories', $couponCols, true),
        'coupons.applicable_products' => in_array('applicable_products', $couponCols, true),
        'coupons.applicable_customer_emails' => in_array('applicable_customer_emails', $couponCols, true),
        'posts.author_id' => in_array('author_id', $postCols, true),
        'posts.cover_image_url' => in_array('cover_image_url', $postCols, true),
        'posts.status' => in_array('status', $postCols, true),
        'posts.is_featured' => in_array('is_featured', $postCols, true),
        'posts.reading_time_minutes' => in_array('reading_time_minutes', $postCols, true),
        'post_categories.description' => in_array('description', $categoryCols, true),
        'post_categories.is_active' => in_array('is_active', $categoryCols, true),
    ];

    echo "<ul style='font-size:0.9rem;line-height:1.8;'>";
    foreach ($checkResults as $col => $exists) {
        $icon = $exists ? '✅' : '❌';
        $status = $exists ? 'ĐÃ TỒN TẠI' : 'CHƯA TỒN TẠI';
        echo "<li>{$icon} Cột <code>{$col}</code>: <strong>{$status}</strong></li>";
    }
    echo '</ul>';

    echo '<h3>🌱 3. Nạp danh mục và bài viết mẫu (BlogSeeder)...</h3>';
    Artisan::call('db:seed', ['--class' => 'BlogSeeder', '--force' => true]);
    $seedOutput = Artisan::output();
    echo "<pre style='background:#1e293b;color:#f8fafc;padding:1rem;border-radius:8px;font-size:0.85rem;overflow:auto;'>".htmlspecialchars($seedOutput).'</pre>';
    echo "<p style='color:#16a34a;'>✅ Đã nạp danh mục và bài viết blog Lunara Journal.</p>";

    echo '<h3>🧹 4. Đang dọn dẹp bộ nhớ đệm (Cache, Route & View)...</h3>';
    Artisan::call('optimize:clear');
    $clearOutput = Artisan::output();
    echo "<pre style='background:#1e293b;color:#f8fafc;padding:1rem;border-radius:8px;font-size:0.85rem;overflow:auto;'>".htmlspecialchars($clearOutput).'</pre>';
    echo "<p style='color:#16a34a;'>✅ Đã làm mới cache hệ thống.</p>";

    echo '<h3>📚 5. Thống kê bài viết hiện có trên Host...</h3>';
    $postCategories = PostCategory::withCount('posts')->get();
    echo "<ul style='font-size:0.9rem;'>";
    foreach ($postCategories as $pcat) {
        echo "<li><b>{$pcat->name}</b> (<code>{$pcat->slug}</code>): {$pcat->posts_count} bài viết</li>";
    }
    echo '</ul>';

    $posts = Post::latest()->get();
    echo "<table border='1' cellpadding='8' style='border-collapse:collapse;width:100%;font-size:0.85rem;background:#fff;'>";
    echo "<tr style='background:#f1f5f9;'><th>ID</th><th>Tiêu đề</th><th>Slug</th><th>Trạng thái</th><th>Nổi bật</th><th>Thời gian đọc</th></tr>";
    foreach ($posts as $p) {
        $st = $p->status === 'published' ? "<span style='color:green;font-weight:bold;'>Xuất bản</span>" : "<span style='color:orange;'>Bản nháp</span>";
        $feat = $p->is_featured ? '⭐ Có' : 'Không';
        echo "<tr>
            <td>{$p->id}</td>
            <td><b>{$p->title}</b></td>
            <td><code>{$p->slug}</code></td>
            <td>{$st}</td>
            <td>{$feat}</td>
            <td>{$p->reading_time} phút</td>
        </tr>";
    }
    echo '</table>';

    echo "<p style='margin-top:1.5rem;color:#16a34a;font-weight:bold;'>🎉 HOÀN TẤT ĐỒNG BỘ PHASE 15 (OPTION A) & PHASE 16 TRÊN INFINITYFREE!</p>";
} catch (Throwable $e) {
    echo "<p style='color:#dc2626;'>❌ Lỗi: ".htmlspecialchars($e->getMessage()).'</p>';
    echo "<pre style='background:#fef2f2;color:#991b1b;padding:1rem;border-radius:8px;font-size:0.8rem;overflow:auto;'>".htmlspecialchars($e->getTraceAsString()).'</pre>';
}

echo '</div>';
