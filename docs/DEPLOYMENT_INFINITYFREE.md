# Hướng dẫn Triển khai & Tự Động Hóa Lunara Silver Lên InfinityFree Hosting

Tài liệu này cung cấp quy trình hoàn chỉnh và chi tiết nhất để đưa dự án **Lunara Silver** lên tên miền thực tế:
🌐 **`https://lunarasilver.infinityfreeapp.com`** *(Tài khoản: `if0_42986888`)*.

Đồng thời, tài liệu hướng dẫn cách vận hành **Bộ công cụ Tự động hóa & Chẩn đoán không cần SSH/CLI** độc quyền được thiết kế riêng cho môi trường Shared Hosting miễn phí.

---

## I. Thách thức Khi Đưa Laravel 12 Lên Shared Hosting & Giải pháp

Shared Hosting (như InfinityFree, cPanel giá rẻ) có những hạn chế kỹ thuật khắt khe:
1. **Không có SSH / Terminal**: Không thể gõ lệnh `php artisan migrate`, `php artisan config:cache` hay `composer install`.
2. **Thư mục gốc cố định (`htdocs/`)**: Laravel yêu cầu Document Root trỏ vào `public/`, nếu không cấu hình đúng sẽ gây lỗi 403, 500 hoặc làm lộ mã nguồn nhạy cảm (`.env`, `storage/`).
3. **Giới hạn số lượng tệp (Inodes) & Giới hạn thời gian tải FTP**: Thư mục `vendor/` chứa hàng chục nghìn file nhỏ, nếu upload từng file qua FTP sẽ mất nhiều giờ và dễ đứt gãy.
4. **Khó bắt lỗi runtime**: Khi gặp lỗi HTTP 500, hosting free chỉ hiển thị trang trắng hoặc thông báo chung chung, không có debug chi tiết.

### 👉 Giải pháp Tự động hóa Đã Xây Dựng Trong Dự Án

Hệ thống đã chuẩn bị sẵn bộ công cụ tự động hóa tại thư mục gốc `d:\Lunara`:

| Tệp tin | Vị trí | Mục đích & Cơ chế hoạt động |
| :--- | :--- | :--- |
| **`diag.php`** | `d:\Lunara\diag.php` | **Bộ Chẩn đoán Sức khỏe Hệ thống**: Kiểm tra 10 extension PHP, quyền ghi `storage/`, tính toàn vẹn cấu trúc file, kết nối DB PDO, giả lập request `GET /` để bắt lỗi runtime chi tiết, đọc log `storage/logs/laravel.log` và nút xóa cache `?clear_cache=1`. |
| **`sync_phase13.php`** | `d:\Lunara\sync_phase13.php` | **Bộ Tự Động Migrate & Sync Config**: Tự động chèn biến môi trường VNPay vào `.env`, khởi chạy `Artisan::call('migrate', ['--force' => true])` qua giao diện web, xóa cache và hiển thị bảng kiểm toán 5 đơn hàng mới nhất. |
| **`update_vendor.php`** | `d:\Lunara\update_vendor.php` | **Bộ Cập nhật Thư viện Nhanh**: Tự động giải nén tệp `cloudinary_vendor.zip` bằng `ZipArchive` trực tiếp trên server, khắc phục lỗi đường dẫn và nạp Class mà không cần chạy Composer trên host. |
| **`.htaccess`** | `d:\Lunara\.htaccess` | **Định tuyến Thông minh**: Chuyển tiếp toàn bộ request từ `htdocs/` vào `public/` mà không gây loop 500, đồng thời chặn truy cập trực tiếp vào các tệp bảo mật (`.env`, `vendor/`, `storage/`). |
| **`lunara_silver_export.sql`** | `d:\Lunara\lunara_silver_export.sql` | **Bản sao lưu CSDL chuẩn UTF-8mb4**: Nạp sẵn 45 sản phẩm, danh mục, hình ảnh, tài khoản admin `admin@lunara.vn`. |
| **`.env.production`** | `d:\Lunara\.env.production` | File cấu hình chuẩn production đã điền sẵn `APP_KEY`, thông số DB host và các dịch vụ. |
| **`public/build/`** | `d:\Lunara\public\build\` | CSS/JS đã được biên dịch tối ưu qua Vite (`npm run build`). |

---

## II. Quy trình 4 Bước Triển khai Thực Tế

### Bước 1: Tạo Database và Import dữ liệu trên InfinityFree

1. Đăng nhập trang quản trị InfinityFree: [https://dash.infinityfree.com](https://dash.infinityfree.com)
2. Chọn tài khoản **`if0_42986888`** $\rightarrow$ Bấm nút **Control Panel** (vPanel).
3. Trong vPanel, tìm mục **Databases** $\rightarrow$ Chọn **MySQL Databases**:
   - Tại ô *Create New Database*, nhập tên: `lunara` $\rightarrow$ Bấm **Create Database**.
   - Tên cơ sở dữ liệu hoàn chỉnh sẽ có dạng: `if0_42986888_lunara`.
4. Ghi lại các thông số kết nối hiển thị trên bảng:
   - **MySQL Hostname**: `sql305.infinityfree.com` (hoặc hostname tương ứng của tài khoản).
   - **MySQL Database Name**: `if0_42986888_lunara`
   - **MySQL Username**: `if0_42986888`
   - **MySQL Password**: `manh31102005` (mật khẩu hosting vPanel của bạn).
5. Mở công cụ **phpMyAdmin**:
   - Chọn database `if0_42986888_lunara` ở cột bên trái.
   - Chọn tab **Import** trên thanh menu.
   - Nhấn **Choose File** $\rightarrow$ Chọn tệp `d:\Lunara\lunara_silver_export.sql`.
   - Bấm nút **Import** (hoặc **Go**) ở cuối trang.
   - Chờ thông báo màu xanh hoàn tất.

---

### Bước 2: Chuẩn bị tệp cấu hình `.env` cho Hosting

Mở tệp `d:\Lunara\.env.production` (hoặc copy từ `.env.production.example` thành `.env`) và xác nhận các thông số:
```env
APP_NAME="Lunara Silver"
APP_ENV=production
APP_KEY=base64:cjhbd2p1aWdpZWV1dmJ3NmQ5d2J2eXN3eWZldHN5YWU=
APP_DEBUG=false
APP_URL=https://lunarasilver.infinityfreeapp.com

DB_CONNECTION=mysql
DB_HOST=sql305.infinityfree.com
DB_PORT=3306
DB_DATABASE=if0_42986888_lunara
DB_USERNAME=if0_42986888
DB_PASSWORD=manh31102005

SESSION_DRIVER=database
QUEUE_CONNECTION=sync
CACHE_STORE=file

# VNPay Sandbox
VNPAY_SANDBOX=true
VNPAY_TMN_CODE=7OO2Y0S8
VNPAY_HASH_SECRET=TRPSTTTYPHQWBATDQWCUWMANEWXLZMGE
VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNPAY_RETURN_URL="https://lunarasilver.infinityfreeapp.com/payment/vnpay/return"
```

---

### Bước 3: Đưa Mã Nguồn Lên Thư Mục `htdocs/` Của Hosting

Bạn có thể lựa chọn 1 trong 2 cách sau:

#### Cách 1: Nén ZIP và tải qua Online File Manager (Nhanh nhất & Tránh sót file)
1. Trên máy tính cá nhân, trước khi nén, đảm bảo đã chạy lệnh build giao diện:
   ```bash
   npm run build
   ```
2. Chọn các thư mục và file sau để nén thành 1 file duy nhất `deploy_lunara.zip`:
   - File gốc: `.htaccess`, `.env`, `composer.json`, `index.php`, `diag.php`, `sync_phase13.php`, `update_vendor.php`, `cloudinary_vendor.zip`
   - Thư mục: `app/`, `bootstrap/`, `config/`, `database/`, `media/`, `public/`, `resources/`, `routes/`, `storage/`, `vendor/`
   > ⛔ **CỰC KỲ QUAN TRỌNG — TUYỆT ĐỐI KHÔNG NÉN CÁC MỤC SAU**:
   > - `node_modules/` *(hàng nghìn file nặng gây tràn dung lượng host)*
   > - `.git/` *(lịch sử commit không cần thiết trên live host)*
   > - `tests/` *(unit test không chạy trên production)*
   > - `lunara_silver_export.sql` *(đã import xong vào DB)*
3. Mở **Online File Manager** trên vPanel InfinityFree $\rightarrow$ Mở thư mục **`htdocs/`**.
4. Nhấn **Upload** file `deploy_lunara.zip` lên.
5. Chuột phải vào file zip trên File Manager $\rightarrow$ Chọn **Extract** để giải nén trực tiếp trên server.
6. Xóa file `deploy_lunara.zip` sau khi giải nén để tiết kiệm dung lượng.

#### Cách 2: Sử dụng phần mềm FileZilla Client (FTP)
1. Tải và mở **FileZilla Client**.
2. Điền thông tin kết nối FTP:
   - **Host**: `ftpupload.net`
   - **Username**: `if0_42986888`
   - **Password**: `manh31102005`
   - **Port**: `21` $\rightarrow$ Nhấn **Quickconnect**.
3. Cột bên phải (Remote): Vào thư mục `htdocs/`.
4. Cột bên trái (Local): Mở thư mục dự án `d:\Lunara`.
5. Kéo thả các tệp/thư mục tương tự như Cách 1 sang `htdocs/`.

---

### Bước 4: Chạy Bộ Tự Động Hóa & Kiểm Tra Hệ Thống Trực Tuyến

Sau khi tải mã nguồn lên, thực hiện 3 bước kiểm tra và kích hoạt tự động qua trình duyệt:

#### 1. Kiểm tra sức khỏe toàn diện qua `diag.php`
Truy cập: **`https://lunarasilver.infinityfreeapp.com/diag.php`**
- Trang kiểm tra sẽ tự động:
  - Xác nhận phiên bản PHP và các extension bắt buộc (`pdo_mysql`, `mbstring`, `fileinfo`...).
  - Tự động tạo thư mục và cấp quyền ghi cho `storage/` và `bootstrap/cache/`.
  - Kiểm tra kết nối PDO trực tiếp đến cơ sở dữ liệu `if0_42986888_lunara`.
  - Khởi động Laravel HTTP Kernel và giả lập request `GET /`.
  - Nếu hiển thị **"🎉 HOÀN TOÀN THÀNH CÔNG! Trang chủ trả về HTTP 200 OK"** nghĩa là hệ thống sẵn sàng 100%!

#### 2. Chạy đồng bộ Migration & Cấu hình qua `sync_phase13.php`
Truy cập: **`https://lunarasilver.infinityfreeapp.com/sync_phase13.php`**
- Script sẽ tự động:
  - Bổ sung cấu hình VNPay Sandbox vào `.env` nếu thiếu.
  - Chạy `Artisan::call('migrate', ['--force' => true])` để cập nhật bảng `payments` và các cột mới nhất.
  - Dọn dẹp cache Laravel bằng `Artisan::call('optimize:clear')`.
  - Hiển thị bảng tra cứu đơn hàng và giao dịch thanh toán trực quan.

#### 3. Nếu thiếu thư viện Cloudinary, chạy `update_vendor.php`
Truy cập: **`https://lunarasilver.infinityfreeapp.com/update_vendor.php`**
- Script sẽ tự động giải nén gói `cloudinary_vendor.zip` vào `vendor/` và nạp Class `Cloudinary\Cloudinary` ngay trên hosting.

---

## III. Nghiệm Thu & Vận Hành Trên Live

Truy cập trang chủ chính thức: **`https://lunarasilver.infinityfreeapp.com`**

### 1. Kiểm tra Phía Khách Hàng (Storefront)
- [x] Trang chủ hiển thị sắc nét Logo Lunara Silver, Hero Carousel 3 slide, typography sang trọng.
- [x] Các danh mục: Dây chuyền, Nhẫn, Vòng tay, Bộ sưu tập, Set Quà tặng.
- [x] Trang chi tiết sản phẩm hiển thị ảnh, thông số kỹ thuật và tình trạng tồn kho.
- [x] Thêm sản phẩm vào giỏ hàng AJAX, cập nhật số lượng và đặt hàng thành công.
- [x] Thử nghiệm thanh toán trực tuyến qua cổng VNPay Sandbox bằng thẻ test NCB.

### 2. Kiểm tra Phía Quản Trị Viên (Admin Portal)
- Đường dẫn: `https://lunarasilver.infinityfreeapp.com/login`
- Đăng nhập tài khoản:
  - **Email**: `admin@lunara.vn`
  - **Mật khẩu**: `admin123456`
- Truy cập vào **`/admin`**:
  - Xem Dashboard thống kê doanh thu và đơn hàng.
  - Quản lý sản phẩm, chỉnh sửa tồn kho nhanh, quản lý thư viện ảnh Cloudinary.
  - Quản lý đơn hàng, đổi trạng thái và đối soát giao dịch VNPay.

---

## IV. Quy Trình Cập Nhật Tính Năng Mới Từ Máy Cá Nhân Lên Live Host

Khi bạn code thêm tính năng mới trên máy local (`d:\Lunara`), quy trình cập nhật cực kỳ nhanh chóng:

```text
               +------------------------------------+
               |  Lập trình & Test tại Local máy    |
               |  (http://127.0.0.1:8000)           |
               +-----------------+------------------+
                                 |
         +-----------------------+-----------------------+
         | (Nếu sửa PHP/Blade)                           | (Nếu sửa CSS/JS)
         v                                               v
+-------------------------------+             +-----------------------------+
| Dùng FileZilla upload đúng    |             | Chạy lệnh: `npm run build`  |
| file PHP/Blade vừa sửa lên host|             | Upload thư mục `public/build`|
| (Mất chỉ 2 - 5 giây!)         |             +-----------------------------+
+-------------------------------+                            |
         |                                                   |
         +-----------------------+---------------------------+
                                 |
                                 v
               +------------------------------------+
               | (Nếu có migration CSDL mới)        |
               | Mở trình duyệt vào link:           |
               | /sync_phase13.php để tự động migrate|
               +------------------------------------+
```
