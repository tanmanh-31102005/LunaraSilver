<?php

header('Content-Type: text/html; charset=utf-8');

$zipFile = __DIR__ . '/cloudinary_vendor.zip';
if (!file_exists($zipFile)) {
    $zipFile = __DIR__ . '/cloudinary-vendor-update.zip';
}

$targetDir = __DIR__ . '/vendor';

echo "<h2>🔧 Đang cập nhật thư viện Cloudinary cho Lunara Silver...</h2>";

// Clean up any corrupted literal backslash files in vendor directory
if (is_dir($targetDir)) {
    $entries = scandir($targetDir);
    $cleaned = 0;
    foreach ($entries as $entry) {
        if (strpos($entry, '\\') !== false) {
            $filePath = $targetDir . '/' . $entry;
            if (is_file($filePath)) {
                @unlink($filePath);
                $cleaned++;
            }
        }
    }
    if ($cleaned > 0) {
        echo "<p style='color:#666;'>🧹 Đã dọn dẹp $cleaned tệp lỗi định dạng cũ trong <code>vendor/</code>.</p>";
    }
}

if (!file_exists($zipFile)) {
    // If class already exists, report success
    if (file_exists($targetDir . '/autoload.php')) {
        require_once $targetDir . '/autoload.php';
        if (class_exists('Cloudinary\Cloudinary')) {
            echo "<h3 style='color:#198754;'>✅ Thư viện Cloudinary đã được nạp sẵn và hoạt động tốt!</h3>";
            echo "<p><a href='/admin/products/45/edit'>👉 Quay lại trang Quản trị Sản phẩm</a></p>";
            exit;
        }
    }
    echo "<p style='color:red;'>❌ Không tìm thấy tệp <code>" . basename($zipFile) . "</code>.</p>";
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

    // Verify autoload
    if (file_exists($targetDir . '/autoload.php')) {
        require_once $targetDir . '/autoload.php';
    }

    if (class_exists('Cloudinary\Cloudinary')) {
        echo "<h3 style='color:#198754; font-size: 20px;'>🎉 CẬP NHẬT THÀNH CÔNG 100%!</h3>";
        echo "<p>Đã nạp đầy đủ gói thư viện <strong>cloudinary/cloudinary_php</strong> vào <code>vendor/</code> của hosting.</p>";
        echo "<p>Đã kiểm tra lớp <code>Cloudinary\\Cloudinary</code>: <strong>HOẠT ĐỘNG HOÀN HẢO!</strong></p>";
        echo "<p>Lỗi <em>Class \"Cloudinary\\Cloudinary\" not found</em> đã được khắc phục hoàn toàn.</p>";
        echo "<p style='margin-top: 20px;'><a href='/admin/products/45/edit' style='display:inline-block;padding:10px 20px;background:#15171C;color:#ffffff;text-decoration:none;border-radius:6px;font-weight:600;'>👉 Quay lại trang Sửa Sản Phẩm & Tải ảnh lên Cloudinary</a></p>";
    } else {
        echo "<h3 style='color:orange;'>⚠️ Đã giải nén tệp nhưng chưa nạp được Class Cloudinary\\Cloudinary. Vui lòng kiểm tra lại.</h3>";
    }
} else {
    echo "<p style='color:red;'>❌ Không thể mở tệp zip (Mã lỗi: {$res}).</p>";
}
