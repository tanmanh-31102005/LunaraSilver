# 🚀 LUNARA SILVER — CẨM NANG TOÀN DIỆN VỀ CÀI ĐẶT & TRIỂN KHAI HỆ THỐNG
## HƯỚNG DẪN 1-CLICK WINDOWS, MÔI TRƯỜNG LOCAL & PRODUCTION SHARED HOSTING (ZERO-SSH)

> **Mục đích tài liệu:** Cung cấp hướng dẫn toàn diện, từng bước để cài đặt, cấu hình, vận hành và khắc phục sự cố hệ thống **Lunara Silver** trên mọi môi trường: từ máy tính cá nhân Windows của người chấm đồ án đến môi trường máy chủ thực tế (Shared Hosting cPanel / InfinityFree) không có quyền truy cập dòng lệnh SSH.

---

## 📑 MỤC LỤC TỔNG QUAN

1. [Yêu cầu Tiên quyết Hệ thống (System Requirements)](#1-yêu-cầu-tiên-quyết-hệ-thống-system-requirements)
2. [Cài đặt Siêu tốc 1-Click trên Windows (Khuyến nghị cho Nghiệm thu Đồ án)](#2-cài-đặt-siêu-tốc-1-click-trên-windows-khuyến-nghị-cho-nghiệm-thu-đồ-án)
3. [Cài đặt Thủ công Dành cho Lập trình viên (Manual CLI Setup)](#3-cài-đặt-thủ-công-dành-cho-lập-trình-viên-manual-cli-setup)
4. [Bảng Giải thích Chi tiết Cấu hình Môi trường (.env)](#4-bảng-giải-thích-chi-tiết-cấu-hình-môi-trường-env)
5. [Quy trình Quản trị & Biên dịch Frontend (Vite & Assets Pipeline)](#5-quy-trình-quản-trị--biên-dịch-frontend-vite--assets-pipeline)
6. [Triển khai Lên Shared Hosting Miễn phí Không Cần SSH (InfinityFree / cPanel)](#6-triển-khai-lên-shared-hosting-miễn-phí-không-cần-ssh-infinityfree--cpanel)
7. [Chiến lược Sao lưu & Khôi phục Thảm họa (Backup & Recovery Runbook)](#7-chiến-lược-sao-lưu--khôi-phục-thảm-họa-backup--recovery-runbook)
8. [Cẩm nang Xử lý Sự cố Thường gặp (Troubleshooting Matrix)](#8-cẩm-nang-xử-lý-sự-cố-thường-gặp-troubleshooting-matrix)

---

## 1. YÊU CẦU TIÊN QUYẾT HỆ THỐNG (SYSTEM REQUIREMENTS)

| Thành phần | Yêu cầu Tối thiểu | Phiên bản Khuyến nghị | Ghi chú & Mục đích |
| :--- | :---: | :---: | :--- |
| **Hệ điều hành** | Windows 10 / macOS 11 / Linux | Windows 11 / Ubuntu 22.04 | Tương thích đa nền tảng |
| **PHP Runtime** | PHP >= 8.2.0 | **PHP 8.2.12** / 8.2.34 | Bắt buộc cho Laravel 12 (Cần các extension: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `curl`) |
| **Cơ sở Dữ liệu** | MariaDB 10.4+ / MySQL 8.0+ | **MySQL 8.0** / MariaDB 10.4.32 | Bắt buộc hỗ trợ InnoDB và JSON data type |
| **Web Server** | Built-in CLI / Apache 2.4 | Apache 2.4 / Nginx | Hỗ trợ `mod_rewrite` URL rewriting |
| **Node.js & npm** | Node >= 18.0.0 | **Node.js 20.x LTS** | Chỉ cần khi muốn biên dịch lại CSS/JS từ mã nguồn |
| **Composer** | Composer >= 2.2.0 | **Composer 2.7.x** | Chỉ cần khi muốn cập nhật thư viện PHP |

---

## 2. CÀI ĐẶT SIÊU TỐC 1-CLICK TRÊN WINDOWS (KHUYẾN NGHỊ CHO NGHIỆM THU ĐỒ ÁN)

Nhằm giúp Giảng viên, Hội đồng chấm thi hoặc người dùng mới có thể chạy ngay hệ thống trong **dưới 60 giây** mà không cần cài đặt môi trường phức tạp, Lunara Silver cung cấp bộ công cụ tự động hóa hoàn toàn:

### Bước 1: Chuẩn bị Cơ sở Dữ liệu
1. Mở phần mềm **XAMPP Control Panel** (hoặc Laragon).
2. Nhấn nút **Start** tại dịch vụ **MySQL**.
3. Mở trình duyệt truy cập `http://localhost/phpmyadmin`, tạo một cơ sở dữ liệu mới với tên:
   * **Database name:** `lunara_silver`
   * **Collation:** `utf8mb4_unicode_ci`

### Bước 2: Tự động Tải PHP 8.2 Portable (Nếu máy chỉ có PHP cũ)
* Nếu máy tính của bạn chưa có PHP hoặc phiên bản PHP của XAMPP đang dưới 8.2 (ví dụ: PHP 8.0):
* Bạn chỉ cần nhấp đúp chuột vào file:
  ```text
  dist/update_patch/get_php82.bat
  ```
* Hệ thống sẽ tự động tải bản PHP 8.2 Portable chính thức từ máy chủ PHP Windows, giải nén vào thư mục `php82/` trong dự án và tự cấu hình sẵn file `php.ini`.

### Bước 3: Khởi tạo Toàn bộ Dự án Tự động
* Nhấp đúp chuột vào file:
  ```text
  dist/update_patch/setup.bat
  ```
* File này sẽ tự động:
  1. Phát hiện đường dẫn PHP phù hợp nhất (ưu tiên `php82/` portable hoặc PHP hệ thống).
  2. Tạo file `.env` từ `.env.example` nếu chưa có.
  3. Tự động sinh `APP_KEY` bí mật.
  4. Thực thi migrations và nạp dữ liệu mẫu 45 sản phẩm thực tế (`php artisan migrate:fresh --seed`).
  5. Tạo liên kết lưu trữ công khai (`php artisan storage:link`).

### Bước 4: Khởi động Máy chủ Web
* Nhấp đúp chuột vào file:
  ```text
  dist/update_patch/start.bat
  ```
* Máy chủ Laravel sẽ tự động khởi động tại `http://127.0.0.1:8000` và tự động mở trình duyệt web của bạn sau 2 giây.

---

## 3. CÀI ĐẶT THỦ CÔNG DÀNH CHO LẬP TRÌNH VIÊN (MANUAL CLI SETUP)

Dành cho các lập trình viên muốn cài đặt từ đầu qua giao diện dòng lệnh:

```bash
# 1. Di chuyển vào thư mục dự án
cd d:\Lunara

# 2. Cài đặt các gói phụ thuộc PHP từ composer.lock
composer install --no-dev --optimize-autoloader

# 3. Tạo tệp cấu hình môi trường từ mẫu
cp .env.example .env

# 4. Tạo khóa bảo mật ứng dụng
php artisan key:generate

# 5. Cấu hình thông tin kết nối MySQL trong file .env (DB_DATABASE=lunara_silver)

# 6. Khởi tạo cơ sở dữ liệu và nạp toàn bộ danh mục 45 sản phẩm chuẩn hóa
php artisan migrate:fresh --seed

# 7. Tạo liên kết Symbolic Link cho thư mục lưu trữ ảnh công khai
php artisan storage:link

# 8. Cài đặt và biên dịch tài nguyên giao diện (Frontend Assets)
npm install
npm run build

# 9. Khởi chạy máy chủ phát triển
php artisan serve --host=127.0.0.1 --port=8000
```

Truy cập website tại: `http://127.0.0.1:8000`

---

## 4. BẢNG GIẢI THÍCH CHI TIẾT CẤU HÌNH MÔI TRƯỜNG (.ENV)

| Tên biến cấu hình | Giá trị mẫu khuyến nghị | Ý nghĩa & Mục đích sử dụng |
| :--- | :--- | :--- |
| `APP_NAME` | `"Lunara Silver"` | Tên thương hiệu hiển thị trên thanh tiêu đề và email |
| `APP_ENV` | `local` (hoặc `production`) | Chế độ môi trường (local hiển thị lỗi chi tiết, production ẩn lỗi) |
| `APP_DEBUG` | `true` (local) / `false` (prod) | Bật/tắt thanh gỡ lỗi chi tiết |
| `APP_URL` | `http://127.0.0.1:8000` | Đường dẫn gốc của website phục vụ sinh link SEO và Canonical |
| `DB_CONNECTION` | `mysql` | Hệ quản trị cơ sở dữ liệu sử dụng |
| `DB_HOST` | `127.0.0.1` | Địa chỉ máy chủ CSDL (dùng 127.0.0.1 thay cho localhost để tối ưu kết nối) |
| `DB_PORT` | `3306` | Cổng dịch vụ MySQL mặc định |
| `DB_DATABASE` | `lunara_silver` | Tên cơ sở dữ liệu của dự án |
| `DB_USERNAME` | `root` | Tài khoản quản trị cơ sở dữ liệu |
| `DB_PASSWORD` | `""` (để trống trên XAMPP) | Mật khẩu truy cập cơ sở dữ liệu |
| `VNPAY_TMN_CODE` | `2QXUI4B4` | Mã định danh Merchant Sandbox được cấp bởi VNPay |
| `VNPAY_HASH_SECRET`| `RAOCTWS324888QWJ6P4408799484P` | Chuỗi khóa bí mật ký số giao dịch HMAC-SHA512 |
| `VNPAY_URL` | `https://sandbox.vnpayment.vn/paymentv2/vpcpay.html` | Cổng thanh toán Sandbox trực tuyến |
| `VNPAY_RETURN_URL` | `http://127.0.0.1:8000/payment/vnpay/return` | Địa chỉ nhận phản hồi từ trình duyệt sau thanh toán |
| `CLOUDINARY_URL` | `cloudinary://API_KEY:API_SECRET@CLOUD_NAME` | Chuỗi kết nối API lưu trữ ảnh đám mây Cloudinary |
| `MAIL_MAILER` | `smtp` | Phương thức gửi thư điện tử thông báo |
| `MAIL_HOST` | `smtp.gmail.com` | Máy chủ gửi thư SMTP của Google |
| `MAIL_PORT` | `587` | Cổng bảo mật STARTTLS |

---

## 5. QUY TRÌNH QUẢN TRỊ & BIÊN DỊCH FRONTEND (VITE & ASSETS PIPELINE)

### 5.1 Kiến Trúc Đóng Gói Với Vite 7
Hệ thống sử dụng **Vite v7.3.6** với plugin `laravel-vite-plugin`:
* **Điểm vào (Entry Points)**:
  * `resources/css/app.css` (Style trang chủ, catalog, giỏ hàng, chi tiết)
  * `resources/css/admin.css` (Style trung tâm điều hành Admin)
  * `resources/js/app.js` (Logic tương tác AJAX, mini-cart, review modal)
* **Kết quả biên dịch sản xuất (`npm run build`)**:
  * Tài nguyên được tối ưu hóa, nén gzip và lưu vào thư mục `public/build/assets/`.
  * Tập tin manifest `public/build/manifest.json` ánh xạ đường dẫn tài nguyên tĩnh phục vụ hàm `@vite` của Laravel.

### 5.2 Khắc Phục Lỗi Mất CSS Khi Chạy Local (IPv6 Loopback Mismatch)
* **Vấn đề đã xử lý:** Khi chạy `npm run dev`, nếu không chỉ định rõ địa chỉ IP, Vite sẽ lắng nghe trên IPv6 `http://[::1]:5173`. Trình duyệt khi mở trên IPv4 `http://127.0.0.1:8000` sẽ bị chặn kết nối chéo dẫn đến giao diện bị mất CSS.
* **Cấu hình chuẩn hóa trong `vite.config.js`:**
  ```javascript
  server: {
      host: '127.0.0.1',
      port: 5173,
      hmr: {
          host: '127.0.0.1',
      },
  }
  ```
* **Nguyên tắc vận hành:**
  * **Để xem demo hoặc nghiệm thu đồ án:** Bạn **không cần chạy `npm run dev`**. Bộ tài nguyên đã được build sẵn tại `public/build` (CSS 450 KB). Chỉ cần chạy server PHP là trang web luôn hiển thị đầy đủ giao diện.
  * **Chỉ chạy `npm run dev`** khi lập trình viên cần chỉnh sửa trực tiếp mã nguồn CSS/JS trong `resources/`.

---

## 6. TRIỂN KHAI LÊN SHARED HOSTING MIỄN PHÍ KHÔNG CẦN SSH (INFINITYFREE / CPANEL)

Một đóng góp thực tiễn nổi bật của dự án là giải pháp đưa toàn bộ ứng dụng Laravel hiện đại lên nền tảng **Shared Hosting miễn phí (InfinityFree)** — nơi không có quyền truy cập dòng lệnh terminal (SSH) và cấu trúc Document Root bị cố định tại `htdocs/`.

### 6.1 Kỹ Thuật Định Tuyến Document Root Bằng `.htaccess`
Thông thường, Laravel yêu cầu Document Root phải trỏ vào `public/`. Nếu đưa toàn bộ dự án vào `htdocs/` trên InfinityFree, server sẽ báo lỗi 403 Forbidden hoặc để lộ file `.env`.

**Giải pháp của Lunara Silver:**
1. Đặt tệp `index.php` tại thư mục gốc `htdocs/` chuyển tiếp yêu cầu:
   ```php
   <?php
   require_once __DIR__.'/public/index.php';
   ```
2. Cấu hình tệp `.htaccess` tại thư mục gốc `htdocs/`:
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^public/ - [L]
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule ^(.*)$ /public/$1 [L]
   </IfModule>
   ```
3. Khóa bảo mật trong `public/.htaccess`: Chặn người dùng tải trực tiếp các tệp đuôi nhạy cảm `.env`, `.sql`, `.git`, `.json`.

### 6.2 Bộ Ba Công Cụ Vận Hành Tự Động Qua Web (Zero-SSH Suite)

#### 1. `diag.php` — Bộ Chẩn Đoán Sức Khỏe Toàn Diện (System Diagnostics)
* Truy cập qua trình duyệt: `https://ten-mien-cua-ban.com/diag.php`
* **Chức năng tự động:**
  * Tự tạo và cấp quyền ghi `0777` cho các thư mục cache: `storage/framework/views`, `storage/framework/cache`, `storage/framework/sessions`, `bootstrap/cache`.
  * Kiểm tra trạng thái 10 PHP Extensions quan trọng (`pdo_mysql`, `mbstring`, `fileinfo`, `bcmath`...).
  * Giả lập khởi động Laravel Kernel bằng một request thử nghiệm `GET /`. Nếu có lỗi code hoặc cú pháp, script sẽ in ra toàn bộ Exception Message và Stack Trace rõ ràng thay vì trang trắng HTTP 500 mơ hồ.
  * Bổ sung nút xóa bộ nhớ đệm nhanh: `?clear_cache=1`.

#### 2. `sync_phase13.php` — Bộ Đồng Bộ Cấu Hình & Chạy Migration Qua Web
* Truy cập qua trình duyệt: `https://ten-mien-cua-ban.com/sync_phase13.php`
* **Chức năng tự động:**
  * Tự kiểm tra và bổ sung các biến môi trường VNPay còn thiếu vào file `.env` trên host mà không ghi đè các cấu hình cũ.
  * Tự động khởi chạy lệnh di chuyển dữ liệu Laravel trực tiếp qua code PHP:
    ```php
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    ```
  * Xóa cache tối ưu hóa: `Artisan::call('optimize:clear')`.
  * Hiển thị bảng Live Audit Table kiểm tra trực tiếp các cột mới trong bảng `orders` và `payments`.

#### 3. `update_vendor.php` — Bộ Cập Nhật Thư Viện Nhanh Không Cần Composer
* Khi cần bổ sung thư viện nặng (ví dụ: Cloudinary SDK) mà không thể chạy `composer require` trên host và việc tải hàng nghìn file nhỏ qua FTP quá chậm:
* Nén thư mục bổ sung thành file zip duy nhất.
* Script `update_vendor.php` sử dụng lớp `ZipArchive` của PHP để giải nén trực tiếp trên máy chủ chỉ trong 2 giây, giúp tiết kiệm 95% thời gian triển khai.

---

## 7. CHIẾN LƯỢC SAO LƯU & KHÔI PHỤC THẢM HỌA (BACKUP & RECOVERY RUNBOOK)

### 7.1 Chiến Lược Sao Lưu (Backup Strategy)
1. **Cơ sở dữ liệu (Database)**:
   * Bản sao lưu định kỳ được lưu trữ tại `backup/lunara_local_YYYY-MM-DD.sql`.
   * Lệnh xuất bản sao lưu nhanh qua mysqldump:
     ```bash
     mysqldump -u root -p lunara_silver > backup/lunara_backup_latest.sql
     ```
2. **Dữ liệu Tệp Đa phương tiện (Media & Assets)**:
   * Ảnh gốc sản phẩm được bảo toàn tại thư mục `media/Product/`, `media/Collection/`, `media/Gift/`.
   * Ảnh đám mây được lưu trữ bất biến trên Cloudinary Media CDN.

### 7.2 Quy Trình Phục Hồi Thảm Họa (Disaster Recovery Runbook)
Khi máy chủ gặp sự cố mất dữ liệu hoặc cần chuyển dời sang máy chủ mới:
1. **Bước 1 (Dựng lại Codebase)**: Tải mã nguồn sạch từ kho lưu trữ hoặc giải nén gói phân phối `dist/LunaraSilver_CleanSource.zip`.
2. **Bước 2 (Khôi phục CSDL)**: Tạo cơ sở dữ liệu trống `lunara_silver` và nạp bản SQL sao lưu:
   ```bash
   mysql -u root -p lunara_silver < backup/lunara_local_YYYY-MM-DD.sql
   ```
3. **Bước 3 (Đồng bộ Môi trường)**: Cấu hình lại các biến kết nối trong file `.env`.
4. **Bước 4 (Tái tạo Cache)**: Chạy lệnh dọn sạch và nạp lại cấu hình:
   ```bash
   php artisan optimize:clear
   php artisan storage:link
   ```

---

## 8. CẨM NANG XỬ LÝ SỰ CỐ THƯỜNG GẶP (TROUBLESHOOTING MATRIX)

| Hiện tượng lỗi | Nguyên nhân gốc rễ | Giải pháp xử lý triệt để |
| :--- | :--- | :--- |
| **Giao diện mất toàn bộ CSS / HTML thô** | Tồn tại file `public/hot` trỏ về port Vite không hoạt động hoặc xung đột IPv6 `[::1]`. | Xóa file `public/hot`. Chạy `npm run build` để đưa tài nguyên vào `public/build`. |
| **Lỗi `Class "ZipArchive" not found`** | PHP trên máy chưa bật extension zip trong `php.ini`. | Mở file `php.ini`, tìm dòng `;extension=zip` và bỏ dấu chấm phẩy `;` phía trước, sau đó khởi động lại server. |
| **Lỗi `Unable to load dynamic library 'bcmath'`** | Đường dẫn extension trong `php.ini` trỏ sai hoặc thiếu file `php_bcmath.dll`. | Bộ công cụ `start.bat` của dự án đã tích hợp sẵn đoạn mã PowerShell tự động comment dòng này để không gây gián đoạn. |
| **Lỗi HTTP 403 Forbidden trên Hosting** | Web server không nhận diện được index file trong thư mục gốc `htdocs`. | Đảm bảo file `index.php` và `.htaccess` đã được tải lên đúng tại thư mục gốc `htdocs/`. |
| **Lỗi HTTP 500 khi upload ảnh lớn** | Cấu hình `upload_max_filesize` và `post_max_size` trong `php.ini` quá thấp. | Nâng giá trị `upload_max_filesize = 10M` và `post_max_size = 12M` trong file `php.ini`. |
| **Lỗi sai lệch số tiền VNPay** | Đơn vị tiền tệ gửi sang VNPay chưa được nhân 100 theo quy định của VNPAY. | Kiểm tra lớp `VNPayService.php`, đảm bảo số tiền gửi đi được nhân với 100: `$vnp_Amount = $amount * 100`. |

---

<p align="center">
  <strong>LUNARA SILVER — TỰ ĐỘNG HÓA VẬN HÀNH & TRIỂN KHAI</strong><br>
  Cẩm nang kỹ thuật thực chiến đảm bảo hệ thống vận hành ổn định 24/7 trên mọi nền tảng máy chủ.
</p>
