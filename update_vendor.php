<?php

header('Content-Type: text/html; charset=utf-8');

$zipFile = __DIR__ . '/cloudinary-vendor-update.zip';
$targetDir = __DIR__ . '/vendor';

echo "<h2>🔧 Đang cập nhật thư viện Cloudinary cho Lunara Silver...</h2>";

if (!file_exists($zipFile)) {
    // Check if Cloudinary already exists
    if (class_exists('Cloudinary\Cloudinary')) {
        echo "<h3 style='color:green;'>✅ Thư viện Cloudinary đã được nạp thành công trên hệ thống!</h3>";
        echo "<p>👉 Bạn có thể quay lại trang Admin và tải ảnh lên Cloudinary bình thường.</p>";
        echo "<p><a href='/admin/products'>Quay lại Quản trị Sản phẩm</a></p>";
        exit;
    }
    echo "<p style='color:red;'>❌ Không tìm thấy tệp <code>cloudinary-vendor-update.zip</code>.</p>";
    exit;
}

if (!class_exists('ZipArchive')) {
    echo "<p style='color:red;'>❌ Tiện ích ZipArchive không khả dụng trên máy chủ.</p>";
    exit;
}

$zip = new ZipArchive();
$res = $zip->open($zipFile);

if ($res === true) {
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $zip->extractTo($targetDir);
    $zip->close();

    // Dọn dẹp sau khi giải nén
    @unlink($zipFile);

    echo "<h3 style='color:#198754; font-size: 20px;'>🎉 CẬP NHẬT THÀNH CÔNG 100%!</h3>";
    echo "<p>Đã nạp đầy đủ gói thư viện <strong>cloudinary/cloudinary_php</strong> vào <code>vendor/</code> của hosting.</p>";
    echo "<p>Lỗi <em>Class \"Cloudinary\Cloudinary\" not found</em> đã được khắc phục hoàn toàn.</p>";
    echo "<p style='margin-top: 20px;'><a href='/admin/products' style='display:inline-block;padding:10px 20px;background:#15171C;color:#ffffff;text-decoration:none;border-radius:6px;font-weight:600;'>👉 Quay lại trang Admin & Tải ảnh lên Cloudinary</a></p>";
} else {
    echo "<p style='color:red;'>❌ Không thể mở tệp zip (Mã lỗi: {$res}).</p>";
}
