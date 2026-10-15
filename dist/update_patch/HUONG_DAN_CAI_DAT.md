# HƯỚNG DẪN CÀI ĐẶT VÀ KHỞI CHẠY DỰ ÁN LUNARA SILVER
## Website Thương Mại Điện Tử Trang Sức Bạc Thủ Công Cao Cấp

---

Tài liệu này hướng dẫn chi tiết cách cài đặt, cấu hình cơ sở dữ liệu và khởi chạy dự án **Lunara Silver** trên máy tính mới (Windows, macOS hoặc Linux) để phục vụ chấm điểm, kiểm thử hoặc phát triển tiếp.

---

## 1. YÊU CẦU MÔI TRƯỜNG TỐI THIỂU

Để chạy được dự án, máy tính đích cần cài đặt:
1. **PHP**: Phiên bản `>= 8.2` (Khuyến nghị dùng **XAMPP 8.2+** hoặc **Laragon** trên Windows).
   - Các extension PHP cần được bật trong `php.ini`: `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`, `gd`, `zip`, `xml`, `bcmath`.
2. **Cơ sở dữ liệu**: MySQL `8.0+` hoặc MariaDB `10.4+` (đã tích hợp sẵn trong XAMPP / Laragon).
3. **Trình duyệt web**: Chrome, Edge, Firefox, Safari phiên bản mới.
4. *(Tùy chọn)*: **Composer** và **Node.js** chỉ cần thiết nếu bạn muốn cài thêm thư viện hoặc biên dịch lại giao diện. Gói phân phối đã tích hợp sẵn thư viện `vendor` và CSS/JS đã biên dịch `public/build`.

---

## 2. CÁCH 1: KHỞI CHẠY SIÊU NHANH BẰNG SCRIPT 1-CLICK (WINDOWS)
> *Dành cho người chấm bài hoặc chạy thử nghiệm nhanh chóng nhất trên Windows đã cài XAMPP/Laragon.*

### Bước 1: Khởi động MySQL
- Mở **XAMPP Control Panel** $\rightarrow$ Nhấn **Start** tại mục **MySQL** và **Apache**.
- (Hoặc nếu dùng Laragon: Nhấn **Start All**).

### Bước 2: Tạo CSDL & Import dữ liệu mẫu
1. Mở trình duyệt truy cập phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Nhấn **New** (Mới) để tạo cơ sở dữ liệu:
   - Tên CSDL: `lunara_silver`
   - Bảng mã (Collation): `utf8mb4_unicode_ci`
3. Nhấp chọn database `lunara_silver` vừa tạo ở cột bên trái $\rightarrow$ Chọn thẻ **Import** (Nhập khẩu).
4. Nhấn **Choose File** (Chọn tệp) $\rightarrow$ Chọn file **`lunara_silver_export.sql`** (ở ngay thư mục gốc dự án).
5. Cuộn xuống cuối trang và nhấn **Import** (hoặc **Go**).
   *(Dữ liệu đã nạp sẵn toàn bộ 29 bảng, 45 sản phẩm trang sức, hình ảnh fallback, danh mục, bài viết blog, đánh giá sao và tài khoản Admin)*.

### Bước 3: Chạy script khởi tạo và khởi động
1. Bấm đúp chuột vào file **`setup.bat`** để script tự động tạo tệp `.env`, sinh mã `APP_KEY`, tạo `storage:link` và dọn dẹp cache.
2. Bấm đúp chuột vào file **`start.bat`** để khởi động máy chủ và tự động mở website trên trình duyệt!

---

## 3. CÁCH 2: CÀI ĐẶT THỦ CÔNG TỪNG BƯỚC (CHO MỌI MÁY / HỆ ĐIỀU HÀNH)

Nếu bạn muốn thao tác bằng dòng lệnh (Command Prompt / PowerShell / Terminal macOS & Linux):

### Bước 1: Chuẩn bị tệp cấu hình `.env`
Sao chép tệp mẫu sang tệp cấu hình chính:
```bash
# Trên Windows PowerShell:
Copy-Item .env.example .env

# Trên Linux / macOS / Git Bash:
cp .env.example .env
```

### Bước 2: Cấu hình thông số kết nối Database
Mở tệp `.env` bằng trình soạn thảo bất kỳ và kiểm tra các dòng kết nối CSDL (mặc định cho XAMPP/Laragon):
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lunara_silver
DB_USERNAME=root
DB_PASSWORD=
```
*(Nếu mật khẩu root MySQL trên máy của bạn khác rỗng, hãy điền vào `DB_PASSWORD`)*.

### Bước 3: Tạo Khóa Bí mật Ứng dụng (App Key) & Symlink
```bash
php artisan key:generate
php artisan storage:link
```
*(Lưu ý trên Windows nếu chưa cấu hình PHP trong biến môi trường PATH, hãy dùng đường dẫn đầy đủ: `C:\xampp\php\php.exe artisan key:generate`)*.

### Bước 4: Tạo CSDL & Nạp dữ liệu
Bạn có 2 lựa chọn:
- **Lựa chọn A (Khuyên dùng)**: Import file `lunara_silver_export.sql` qua phpMyAdmin hoặc MySQL CLI:
  ```bash
  mysql -u root -p lunara_silver < lunara_silver_export.sql
  ```
- **Lựa chọn B (Dùng Artisan Migration & Seeder)**:
  ```bash
  php artisan migrate --force
  php artisan db:seed --force
  ```

### Bước 5: Khởi chạy máy chủ Laravel
```bash
php artisan serve
```
Mở trình duyệt truy cập: **`http://127.0.0.1:8000`**

---

## 4. TÀI KHOẢN ĐĂNG NHẬP & DỮ LIỆU KIỂM THỬ

### 1. Tài khoản Quản trị viên (Admin)
- **Đường dẫn đăng nhập**: [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)
- **Email**: `admin@lunara.vn`
- **Mật khẩu**: `admin123456`
- **Quyền hạn**: Truy cập toàn bộ khu vực quản trị tại [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin) (Quản lý sản phẩm, đơn hàng, duyệt đánh giá, cập nhật trạng thái giao hàng, bài viết, banner...).

### 2. Tài khoản Khách hàng (Customer)
- Bạn có thể nhấn nút **Đăng ký** trên thanh menu để tạo tài khoản mới ngay lập tức (mọi tài khoản đăng ký mới đều được gán vai trò an toàn `user`).
- Hoặc sử dụng tài khoản có sẵn trong CSDL: `tanmanhnsnguyen@gmail.com`.

### 3. Thông tin Thẻ Test VNPay Sandbox
Khi kiểm thử tính năng đặt hàng và thanh toán trực tuyến qua cổng **VNPay Sandbox**:
- **Ngân hàng**: `NCB`
- **Số thẻ**: `9704198526191432198`
- **Tên chủ thẻ**: `NGUYEN VAN A`
- **Ngày phát hành**: `07/15`
- **Mã OTP**: `123456`

---

## 5. HƯỚNG DẪN XỬ LÝ SỰ CỐ THƯỜNG GẶP (TROUBLESHOOTING)

| Vấn đề / Lỗi | Nguyên nhân | Cách khắc phục |
| :--- | :--- | :--- |
| **`Your Composer dependencies require a PHP version ">= 8.2.0". You are running 8.0.x`** | Máy tính đang chạy XAMPP phiên bản cũ (PHP 8.0 hoặc 7.4). Laravel 12 bắt buộc PHP >= 8.2.0. | **Cách 1 (Nhanh nhất)**: Nhấp đúp vào file **`get_php82.bat`** (hoặc chọn `Y` khi chạy `setup.bat`) để hệ thống tự động tải PHP 8.2 Portable về thư mục `php82/`. Không cần gỡ cài đặt hay cấu hình lại XAMPP cũ!<br>**Cách 2**: Tải và cài đặt bản XAMPP mới nhất (PHP 8.2+) từ [apachefriends.org](https://www.apachefriends.org/). |
| **`SQLSTATE[HY000] [2002] Connection refused`** | Dịch vụ MySQL chưa được bật trong XAMPP / Laragon | Mở XAMPP Control Panel và bấm nút **Start** tại hàng MySQL. |
| **`Access denied for user 'root'@'localhost'`** | Mật khẩu MySQL của máy bạn không khớp | Mở tệp `.env`, sửa lại giá trị `DB_PASSWORD=` cho đúng với mật khẩu MySQL trên máy của bạn. |
| **`Base table or view not found`** | Chưa tạo CSDL hoặc chưa import file SQL | Tạo database `lunara_silver` trong phpMyAdmin và Import file `lunara_silver_export.sql`. |
| **`Failed to listen on 127.0.0.1:8000 (reason: Address already in use)`** | Cổng 8000 đang bị một ứng dụng khác chiếm giữ | Chạy Artisan trên cổng khác: `php artisan serve --port=8080` rồi mở `http://127.0.0.1:8080`. |
| **`No application encryption key has been specified`** | Chưa khởi tạo `APP_KEY` trong tệp `.env` | Chạy lệnh: `php artisan key:generate`. |
| **`The filename, directory name, or volume label syntax is incorrect`** | Lệnh `php` chưa được thêm vào biến môi trường hệ thống Windows PATH | Sử dụng file `setup.bat` và `start.bat` có sẵn để tự động nhận diện đường dẫn PHP. |
| **Ảnh sản phẩm không hiển thị** | Máy không kết nối mạng hoặc không có Cloudinary | Hệ thống đã có cơ chế tự động nạp ảnh WebP chất lượng cao từ thư mục `public/media-previews/` và `media/`. Hãy chắc chắn đã chạy `php artisan storage:link`. |

---

## 6. KIỂM THỬ TỰ ĐỘNG (AUTOMATED TEST SUITE)
Dự án được trang bị hệ thống kiểm thử tự động toàn diện:
```bash
php artisan test
```
Độ bao phủ kiểm thử bao gồm: Giỏ hàng, Áp mã giảm giá, Phân quyền Admin, Quy trình tạo đơn COD & VNPay, Đánh giá sản phẩm đã mua, Fallback đa tầng Cloudinary / Local media.
