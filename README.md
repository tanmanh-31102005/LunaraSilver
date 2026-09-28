# 🌙 Lunara Silver — Trang Sức Bạc Cao Cấp

<p align="center">
  <img src="media/lunara-logo-dark.svg" alt="Lunara Silver Logo" width="220">
</p>

<p align="center">
  <em>“Shine with your own moonlight”</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5.3">
  <img src="https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
  <img src="https://img.shields.io/badge/Tests-240%20Passed%20(1200%20asserts)-success?style=for-the-badge" alt="Tests Passed">
</p>

---

## 📖 Mục Lục

- [1. Giới thiệu Dự án](#1-giới-thiệu-dự-án)
- [2. Tính năng Nổi bật](#2-tính-năng-nổi-bật)
  - [2.1 Trải nghiệm Khách hàng (Storefront)](#21-trải-nghiệm-khách-hàng-storefront)
  - [2.2 Mô hình Tồn kho Ảo (Dynamic Virtual Inventory)](#22-mô-hình-tồn-kho-ảo-dynamic-virtual-inventory)
  - [2.3 Cổng Thanh toán VNPay & COD](#23-cổng-thanh-toán-vnpay--cod)
  - [2.4 Quản lý Ảnh Đám mây Cloudinary](#24-quản-lý-ảnh-đám-mây-cloudinary)
  - [2.5 Cổng Tài khoản Khách hàng (Customer Portal)](#25-cổng-tài-khoản-khách-hàng-customer-portal)
  - [2.6 Hệ thống Quản trị Toàn diện (Admin Portal)](#26-hệ-thống-quản-trị-toàn-diện-admin-portal)
- [3. Kiến trúc & Công nghệ](#3-kiến-trúc--công-nghệ)
- [4. Yêu cầu Hệ thống](#4-yêu-cầu-hệ-thống)
- [5. Hướng dẫn Cài đặt & Chạy Local](#5-hướng-dẫn-cài-đặt--chạy-local)
- [6. Tài khoản Mặc định & Thử nghiệm](#6-tài-khoản-mặc-định--thử-nghiệm)
- [7. Kiểm thử Tự động (Automated Testing)](#7-kiểm-thử-tự-động-automated-testing)
- [8. Hướng dẫn Đẩy Code lên Git / GitHub](#8-hướng-dẫn-đẩy-code-lên-git--github)
- [9. Hướng dẫn Triển khai & Tự Động Hóa (Deployment & Automation)](#9-hướng-dẫn-triển-khai--tự-động-hóa-deployment--automation)
  - [9.1 Bộ Công Cụ Tự Động Hóa Vận Hành Không Cần SSH](#91-bộ-công-cụ-tự-động-hóa-vận-hành-không-cần-ssh)
  - [9.2 Triển khai lên Hosting (cPanel / DirectAdmin / InfinityFree)](#92-triển-khai-lên-hosting-cpanel--directadmin--infinityfree)
  - [9.3 Triển khai lên VPS Linux (Ubuntu + Nginx + PHP-FPM)](#93-triển-khai-lên-vps-linux-ubuntu--nginx--php-fpm)
  - [9.4 Quy trình Tối ưu & Checklist Bảo mật Production](#94-quy-trình-tối-ưu--checklist-bảo-mật-production)
- [10. Cấu trúc Thư mục Dự án](#10-cấu-trúc-thư-mục-dự-án)
- [11. Tài liệu Tham khảo & Nghiên cứu](#11-tài-liệu-tham-khảo--nghiên-cứu)

---

## 1. Giới thiệu Dự án

**Lunara Silver** là nền tảng thương mại điện tử chuyên biệt cho thương hiệu trang sức bạc cao cấp. Dự án được thiết kế theo phong cách thẩm mỹ **Celestial Luxury Minimalism** — tối giản, sang trọng, thanh lịch với tông màu chủ đạo ánh trăng:
- **Midnight** (`#1A1C2C`): Tạo chiều sâu quý phái cho Header, Hero và Footer.
- **Silver & Mauve** (`#C0C0C0`, `#B8A7B7`): Điểm nhấn ánh kim tinh tế.
- **Ivory & Cream** (`#F7F5F2`, `#E6E2DD`): Không gian trưng bày sản phẩm mềm mại, cao cấp.

Dự án được xây dựng trên nền tảng **Laravel 12**, tuân thủ nghiêm ngặt mô hình kiến trúc MVC, Service Layer Pattern, kiểm thử tự động toàn diện với **240 test cases (1200 assertions)** đảm bảo tính ổn định và toàn vẹn dữ liệu ở cấp độ doanh nghiệp.

---

## 2. Tính năng Nổi bật

### 2.1 Trải nghiệm Khách hàng (Storefront)
- **Trang chủ lôi cuốn**: Banner Hero Carousel đa khung hình tối ưu WebP, thanh thông báo khuyến mãi (Announcement Bar), danh mục nổi bật, khối giới thiệu thương hiệu và cam kết chất lượng.
- **Bộ lọc danh mục đa chiều**: Lọc theo danh mục (Dây chuyền, Nhẫn, Vòng tay, Bộ sưu tập, Quà tặng), phân loại sản phẩm, chất liệu bạc, loại đá quý đính kèm, khoảng giá và sắp xếp linh hoạt.
- **Trang chi tiết sản phẩm chuyên sâu**: Gallery đa góc nhìn (Primary, Hover, Gallery thumbnails), thông số kỹ thuật (chất liệu, trọng lượng, kích cỡ), tình trạng tồn kho tức thời, sản phẩm liên quan cùng phân khúc.
- **Giỏ hàng thời gian thực (AJAX Cart)**: Thêm vào giỏ nhanh, cập nhật số lượng, xóa sản phẩm mượt mà với Fetch API không cần reload trang. Tự động kiểm tra trần tồn kho ngay khi tương tác.

### 2.2 Mô hình Tồn kho Ảo (Dynamic Virtual Inventory)
Khắc phục triệt để nhược điểm của các hệ thống bán lẻ thông thường, Lunara Silver chia sản phẩm thành 3 nhóm:
1. **Sản phẩm Đơn lẻ (`single`)**: Quản lý tồn kho thực tế trực tiếp theo `stock_quantity`.
2. **Bộ sưu tập (`collection`)**: Là combo kết hợp nhiều sản phẩm đơn lẻ.
3. **Hộp quà (`gift`)**: Bộ quà tặng cao cấp bao gồm các sản phẩm lẻ cùng phụ kiện.

> **Quy tắc tồn kho ảo**: Sản phẩm bundle không lưu số lượng cố định mà được tính toán động tại thời điểm truy vấn:  
> $$\text{Available Quantity} = \min \left( \left\lfloor \frac{\text{Component Stock}}{\text{Required Quantity}} \right\rfloor \right)$$  
> Khi khách đặt mua bundle, hệ thống tự động trừ tồn kho của từng sản phẩm thành phần tương ứng, ngăn chặn tuyệt đối tình trạng overselling hoặc lệch tồn kho chéo.

### 2.3 Cổng Thanh toán VNPay & COD
- **Thanh toán khi nhận hàng (COD)**: Quy trình xác nhận đơn hàng chuẩn hóa.
- **Cổng thanh toán điện tử VNPay (Sandbox V2)**:
  - Mã hóa chữ ký bảo mật **HMAC-SHA512** chuẩn quốc tế.
  - Xử lý **Webhook IPN (Instant Payment Notification)** bất đồng bộ, chống trùng lặp giao dịch (Idempotency).
  - Tự động đối soát giao dịch thời gian thực qua **QueryDR API** khi người dùng quay lại từ cổng thanh toán.
  - Cho phép người dùng thử thanh toán lại (**Retry Payment**) nếu giao dịch ban đầu bị gián đoạn.
  - Hỗ trợ hoàn tiền tự động (**Refund API**) khi quản trị viên hủy đơn hàng đã thanh toán qua VNPay.

### 2.4 Quản lý Ảnh Đám mây Cloudinary
- Tích hợp **Cloudinary PHP SDK v3.x** cho lưu trữ và phân phối hình ảnh qua CDN toàn cầu.
- Quản lý vai trò hình ảnh rõ ràng: **Ảnh chính (Primary)**, **Ảnh di chuột (Hover)**, và **Ảnh bộ sưu tập (Gallery)**.
- Giao diện Admin cho phép tải lên nhiều ảnh cùng lúc, kéo thả sắp xếp thứ tự hiển thị, tự động đồng bộ dọn dẹp ảnh trên Cloud khi xóa trong hệ thống.
- Cơ chế Fallback an toàn: Tự động chuyển đổi giữa ảnh local và ảnh Cloudinary mà không làm vỡ giao diện.

### 2.5 Cổng Tài khoản Khách hàng (Customer Portal)
- Hệ thống xác thực an toàn: Đăng ký, đăng nhập với cơ chế chống Brute-force (`throttle:6,1`), quy trình lấy lại mật khẩu qua email kèm token bảo mật.
- Tự động gộp giỏ hàng (Cart Merging): Khách vãng lai đăng nhập hoặc đăng ký tài khoản sẽ được tự động giữ nguyên và gộp các sản phẩm trong giỏ hàng trước đó.
- Sổ địa chỉ giao hàng thông minh: Quản lý nhiều địa chỉ nhận hàng, tự động duy trì duy nhất 1 địa chỉ mặc định, tự động điền sẵn khi vào trang thanh toán.
- Lịch sử & Theo dõi đơn hàng: Xem danh sách và chi tiết đơn hàng với cơ chế **Bản chụp Bất biến (Immutable Snapshot)** — thông tin tên, SKU, giá tại thời điểm mua được lưu độc lập, đảm bảo không bao giờ bị biến đổi ngay cả khi sản phẩm gốc bị thay đổi hoặc xóa bỏ.

### 2.6 Hệ thống Quản trị Toàn diện (Admin Portal)
- Truy cập an toàn qua Middleware phân quyền: `/admin` (Chỉ tài khoản quyền `admin`).
- **Dashboard Quản trị**: Báo cáo tổng quan doanh thu, số lượng đơn hàng, danh sách sản phẩm sắp hết hàng cần nhập, và danh sách đơn mới nhất.
- **Quản lý Danh mục (Category Management)**: Thêm/Sửa/Xóa danh mục, tự động tạo slug chuẩn SEO, cơ chế khóa an toàn chặn xóa danh mục đang chứa sản phẩm.
- **Quản lý Sản phẩm (Product Management)**:
  - Bộ lọc thông minh theo từ khóa, SKU, danh mục, phân loại sản phẩm.
  - Thao tác nhanh tại danh sách (Quick Actions): Bật/Tắt trạng thái hiển thị, cập nhật tồn kho tức thời không tải lại trang.
  - Nhân bản sản phẩm (Duplicate): Sao chép nhanh cấu hình sản phẩm và danh sách linh kiện bundle với SKU mới.
  - Thao tác hàng loạt (Bulk Actions): Kích hoạt hoặc ẩn hàng loạt sản phẩm.
- **Quản lý Đơn hàng (Order Management)**:
  - Bộ lọc đơn hàng theo mã đơn, khách hàng, trạng thái xử lý, trạng thái thanh toán, khoảng thời gian.
  - Quy trình chuyển đổi trạng thái đơn hàng nghiêm ngặt kèm ghi nhận nhật ký kiểm toán (`OrderStatusHistory`).
  - Hủy đơn hàng an toàn: Tự động hoàn lại số lượng tồn kho cho từng sản phẩm đơn lẻ hoặc các thành phần của bundle.
  - Xử lý hoàn tiền VNPay trực tiếp từ trang chi tiết đơn hàng.

---

## 3. Kiến trúc & Công nghệ

| Tầng (Layer) | Công nghệ / Thư viện | Vai trò |
| :--- | :--- | :--- |
| **Backend Framework** | Laravel 12.x (PHP 8.2+) | Xương sống ứng dụng, Routing, Middleware, Eloquent ORM |
| **Kiến trúc Mã nguồn** | Service Layer Pattern | Tách biệt logic nghiệp vụ: `CartService`, `CheckoutService`, `CloudinaryService`, `VNPayService`, `OrderInventoryService`, `OrderStatusService` |
| **Frontend Architecture**| Blade Components + Bootstrap 5.3 | Reusable UI Components, Mobile-first Responsive, Semantic HTML |
| **Build Tooling** | Vite 7.x + Laravel Vite Plugin | Bundling CSS, JS, Bootstrap Icons, Hot Module Replacement (HMR) |
| **Database** | MySQL / MariaDB (UTF-8mb4) | Quản lý dữ liệu quan hệ, Foreign Keys, Transactions, Indexing |
| **Cloud Media** | Cloudinary PHP SDK 3.x | CDN lưu trữ và phân phối hình ảnh chất lượng cao |
| **Payment Gateway** | VNPay Sandbox API (V2) | Tích hợp cổng thanh toán trực tuyến, IPN, QueryDR, Refund |
| **Testing Framework** | PHPUnit 11.x + Laravel Testing | Bộ test toàn diện Feature & Unit (240 tests, 1200 assertions) |

---

## 4. Yêu cầu Hệ thống

Để khởi chạy dự án trên máy tính cá nhân hoặc máy chủ, cần đáp ứng các điều kiện sau:

- **PHP**: Phiên bản `>= 8.2`
  - Các extension PHP bắt buộc: `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`, `gd`, `zip`, `xml`.
- **Composer**: Phiên bản `2.x`
- **Node.js**: Phiên bản `>= 18.x` & **npm** `>= 9.x`
- **Database**: MySQL `>= 8.0` hoặc MariaDB `>= 10.4` (ví dụ thông qua XAMPP, Laragon, hoặc Docker)
- **Git**: Đã cài đặt Git command-line

---

## 5. Hướng dẫn Cài đặt & Chạy Local

Thực hiện lần lượt các bước dưới đây trên terminal (PowerShell / Command Prompt / Terminal):

### Bước 1: Sao chép mã nguồn (Clone Repository)
```bash
git clone https://github.com/tanmanh-31102005/LunaraSilver.git
cd LunaraSilver
```

### Bước 2: Cài đặt các gói phụ thuộc PHP (Composer)
```bash
composer install
```
*(Nếu trên Windows sử dụng XAMPP và composer.phar riêng, chạy lệnh tương đương: `& 'C:\xampp\php\php.exe' -d extension=zip "$env:LOCALAPPDATA\Composer\composer.phar" install`)*

### Bước 3: Cài đặt các gói phụ thuộc Frontend (Node/NPM)
```bash
npm install
```

### Bước 4: Thiết lập file môi trường `.env`
Sao chép file cấu hình mẫu:
```bash
cp .env.example .env
```
*(Trên Windows PowerShell: `Copy-Item .env.example .env`)*

Tạo mã khóa ứng dụng (`APP_KEY`):
```bash
php artisan key:generate
```

Mở file `.env` vừa tạo và chỉnh sửa thông số kết nối cơ sở dữ liệu:
```env
APP_NAME="Lunara Silver"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lunara_silver
DB_USERNAME=root
DB_PASSWORD=
```

*(Tùy chọn) Cấu hình Cloudinary và VNPay Sandbox nếu muốn thử nghiệm đầy đủ tính năng online:*
```env
# Cloudinary (Ảnh đám mây)
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret

# VNPay Sandbox
VNPAY_SANDBOX=true
VNPAY_TMN_CODE=your_tmn_code
VNPAY_HASH_SECRET=your_hash_secret
VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNPAY_RETURN_URL="${APP_URL}/payment/vnpay/return"
```

### Bước 5: Khởi tạo Cơ sở Dữ liệu & Dữ liệu Mẫu (Migration & Seeder)
Đảm bảo dịch vụ MySQL đang chạy (ví dụ bấm **Start** MySQL trên XAMPP Control Panel), sau đó tạo database tên `lunara_silver` trong phpMyAdmin hoặc qua lệnh SQL:
```sql
CREATE DATABASE `lunara_silver` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Chạy migration và seed dữ liệu catalog sản phẩm thực tế:
```bash
php artisan migrate
php artisan db:seed
php artisan db:seed --class=AdminUserSeeder
```
> **Lưu ý**: Lệnh seeder sẽ nhập đầy đủ 45 sản phẩm (gồm 30 sản phẩm đơn lẻ, 10 bộ sưu tập, 5 set quà tặng) kèm danh mục, hình ảnh và tạo tài khoản Admin mặc định.

### Bước 6: Biên dịch giao diện & Khởi động Web Server

Mở Terminal thứ nhất để biên dịch CSS/JS và theo dõi thay đổi:
```bash
npm run dev
```

Mở Terminal thứ hai để chạy máy chủ phát triển Laravel:
```bash
php artisan serve
```

Truy cập website trên trình duyệt: **`http://127.0.0.1:8000`**

---

## 6. Tài khoản Mặc định & Thử nghiệm

### Tài khoản Quản trị viên (Admin)
- **Đường dẫn**: `http://127.0.0.1:8000/login` $\rightarrow$ Tự động chuyển hướng vào `/admin`
- **Email**: `admin@lunara.vn`
- **Mật khẩu**: `admin123456`

### Tài khoản Khách hàng Thử nghiệm (Customer)
- Bạn có thể nhấn vào **Đăng ký** trên thanh điều hướng để tạo tài khoản khách hàng mới với bất kỳ email nào.
- Mọi tài khoản tạo công khai qua form Đăng ký đều mặc định nhận quyền `user` (hệ thống chặn không cho phép nâng quyền admin trái phép).

### Thông tin Thẻ Test VNPay Sandbox
Khi chọn thanh toán qua **VNPay Sandbox**, sử dụng thông tin thẻ test của ngân hàng NCB:
- **Ngân hàng**: `NCB`
- **Số thẻ**: `9704198526191432198`
- **Tên chủ thẻ**: `NGUYEN VAN A`
- **Ngày phát hành**: `07/15`
- **Mã OTP**: `123456`

---

## 7. Kiểm thử Tự động (Automated Testing)

Dự án trang bị bộ test tự động đầy đủ, bao phủ toàn bộ logic giỏ hàng, đặt hàng, trừ tồn kho, bundle ảo, phân quyền admin, VNPay và Cloudinary:

Chạy toàn bộ 240 test cases:
```bash
php artisan test
```

*(Hoặc trên môi trường dùng đường dẫn PHP chỉ định: `& 'C:\xampp\php\php.exe' artisan test`)*

Kết quả mong đợi:
```text
Tests:    240 passed (1200 assertions)
Duration: ~40s - 45s
```

---

## 8. Hướng dẫn Đẩy Code lên Git / GitHub

Quy trình quản lý phiên bản chuẩn khi bạn tiếp tục chỉnh sửa hoặc thêm tính năng mới:

### 8.1 Quy trình Push Code Cơ Bản (Main Branch)

```bash
# 1. Kiểm tra các file vừa sửa đổi hoặc tạo mới
git status

# 2. Thêm các thay đổi vào khu vực chờ commit
git add .

# 3. Ghi lại commit với thông điệp rõ ràng theo chuẩn Conventional Commits
git commit -m "feat: hoàn thiện tính năng XYZ"
# Ví dụ các prefix commit chuẩn:
# feat: tính năng mới
# fix: sửa lỗi
# docs: cập nhật tài liệu
# style: chỉnh sửa giao diện / css
# refactor: tái cấu trúc mã nguồn

# 4. Kéo các thay đổi mới nhất từ GitHub về (tránh xung đột)
git pull origin main --rebase

# 5. Đẩy code lên GitHub
git push origin main
```

### 8.2 Quy trình Làm việc theo Nhánh (Feature Branch Workflow)
Khi làm tính năng phức tạp hoặc làm việc nhóm:
```bash
# Tạo nhánh mới và chuyển sang nhánh đó
git checkout -b feature/voucher-discount

# Code tính năng, sau đó add và commit
git add .
git commit -m "feat: bổ sung chức năng áp mã giảm giá"

# Đẩy nhánh mới lên GitHub
git push -u origin feature/voucher-discount

# Sau đó vào GitHub tạo Pull Request (PR) để review và merge vào main.
```

### 8.3 Những Lưu Ý Quan Trọng Về Bảo Mật Khi Dùng Git
> [!CAUTION]
> **Tuyệt đối KHÔNG commit các thông tin sau lên GitHub công khai:**
> - File `.env` chứa mật khẩu database, `APP_KEY`, API Key Cloudinary, Secret Key VNPay.
> - Thư mục `vendor/` (đã nằm trong `.gitignore`, cài qua `composer install`).
> - Thư mục `node_modules/` (đã nằm trong `.gitignore`, cài qua `npm install`).
> - Các file backup dữ liệu lớn chứa dữ liệu nhạy cảm của khách hàng.

---

## 9. Hướng dẫn Triển khai & Tự Động Hóa (Deployment & Automation)

Dự án Lunara Silver được thiết kế với cơ chế triển khai linh hoạt, đặc biệt sở hữu **Bộ giải pháp tự động hóa vận hành không cần SSH/CLI** độc quyền, giúp chạy mượt mà trên cả môi trường Shared Hosting miễn phí lẫn VPS Linux cao cấp.

---

### 9.1 Bộ Công Cụ Tự Động Hóa Vận Hành Không Cần SSH

Khi triển khai Laravel lên Shared Hosting (cPanel / DirectAdmin / InfinityFree), rào cản lớn nhất là **không có quyền truy cập dòng lệnh (SSH/CLI)** để gõ lệnh `artisan` hoặc `composer`. Dự án đã tích hợp sẵn 4 công cụ tự động hóa chạy trực tiếp qua trình duyệt web:

1. **`diag.php` (Hệ thống Chẩn đoán Sức khỏe Toàn diện - System Diagnostics)**:
   - Truy cập: `https://your-domain.com/diag.php`
   - Tự động kiểm tra phiên bản PHP và 10 extensions cốt lõi (`pdo_mysql`, `mbstring`, `fileinfo`...).
   - Tự động tạo thư mục và cấp quyền ghi `0777` cho `storage/` và `bootstrap/cache/`.
   - Kiểm tra kết nối cơ sở dữ liệu PDO trực tiếp và đếm số lượng bảng.
   - Nạp Laravel Application, khởi tạo HTTP Kernel và giả lập gửi request `GET /` để bắt lỗi runtime ở tầng sâu nhất, hiển thị trực quan thông điệp lỗi và Stack Trace.
   - Trích xuất 15 dòng lỗi gần nhất từ `storage/logs/laravel.log` và cung cấp nút xóa cache một chạm `?clear_cache=1`.

2. **`sync_phase13.php` (Bộ Đồng Bộ Cấu Hình & Chạy Migration Tự Động)**:
   - Truy cập: `https://your-domain.com/sync_phase13.php`
   - Tự động kiểm tra và chèn các biến cấu hình VNPay vào `.env` mà không làm mất dữ liệu cũ.
   - Khởi động Console Kernel và thực thi `Artisan::call('migrate', ['--force' => true])` qua web.
   - Tự động dọn dẹp cache bằng `Artisan::call('optimize:clear')`.
   - Hiển thị bảng tra cứu trực quan 5 đơn hàng và giao dịch thanh toán mới nhất trên hosting.

3. **`update_vendor.php` (Bộ Cập Nhật Thư Viện Nhanh Không Cần Composer)**:
   - Truy cập: `https://your-domain.com/update_vendor.php`
   - Giải quyết bài toán upload hàng chục nghìn file vendor qua FTP bị timeout hoặc lỗi đường dẫn Windows/Linux.
   - Tự động mở và giải nén tệp `cloudinary_vendor.zip` (1.1 MB) vào `vendor/` bằng `ZipArchive`, nạp autoloader và kiểm tra sự tồn tại của class `Cloudinary\Cloudinary`.

4. **Định tuyến Document Root bằng `.htaccess` Thông minh**:
   - Tệp `.htaccess` tại thư mục gốc tự động chuyển tiếp tất cả request từ `htdocs/` vào `public/` mà không gây loop 500, đồng thời khóa an toàn các tệp `.env`, `storage/`, `vendor/` khỏi sự truy cập công khai từ bên ngoài.

---

### 9.2 Triển khai lên Hosting (cPanel / DirectAdmin / InfinityFree)

Dự án đã chuẩn bị sẵn tài liệu chi tiết từng bước tại [`docs/DEPLOYMENT_INFINITYFREE.md`](docs/DEPLOYMENT_INFINITYFREE.md).

1. **Chuẩn bị Database trên Hosting**:
   - Vào cPanel/vPanel $\rightarrow$ Chọn **MySQL Databases** $\rightarrow$ Tạo database mới (ví dụ: `if0_42986888_lunara`).
   - Mở **phpMyAdmin** trên hosting $\rightarrow$ Chọn database vừa tạo $\rightarrow$ Nhấn tab **Import** $\rightarrow$ Tải file `lunara_silver_export.sql` lên và bấm **Go** (nạp sẵn 45 sản phẩm và tài khoản admin).
2. **Biên dịch Frontend trước khi upload**:
   - Tại máy local, chạy lệnh:
     ```bash
     npm run build
     ```
   - Thư mục `public/build/` sẽ được tạo ra chứa đầy đủ CSS/JS đã được minify.
3. **Cấu hình file `.env` trên Hosting**:
   - Mở file `.env.production` (hoặc nhân bản từ `.env.production.example` thành `.env`) và cập nhật thông số kết nối DB từ hosting:
     ```env
     APP_NAME="Lunara Silver"
     APP_ENV=production
     APP_KEY=base64:cjhbd2p1aWdpZWV1dmJ3NmQ5d2J2eXN3eWZldHN5YWU=
     APP_DEBUG=false
     APP_URL=https://your-domain.com

     DB_CONNECTION=mysql
     DB_HOST=sqlXXX.your-host.com
     DB_PORT=3306
     DB_DATABASE=your_db_name
     DB_USERNAME=your_db_user
     DB_PASSWORD=your_db_password
     ```
4. **Tải mã nguồn lên thư mục `htdocs/` (hoặc `public_html/`)**:
   - **Cách khuyên dùng**: Nén thành file zip duy nhất trên máy tính (chứa `.htaccess`, `.env`, `diag.php`, `sync_phase13.php`, `update_vendor.php`, `app/`, `bootstrap/`, `config/`, `database/`, `media/`, `public/`, `resources/`, `routes/`, `storage/`, `vendor/`), upload lên thư mục `htdocs/` qua Online File Manager rồi chọn **Extract**.
   - **LƯU Ý**: KHÔNG tải lên `node_modules/`, `.git/`, `tests/`.
5. **Kích hoạt & Nghiệm thu tự động**:
   - Mở `https://your-domain.com/diag.php` kiểm tra đèn xanh hệ thống.
   - Mở `https://your-domain.com/sync_phase13.php` để đồng bộ CSDL.
   - Truy cập trang chủ `https://your-domain.com` để trải nghiệm website chính thức.

---

### 9.3 Triển khai lên VPS Linux (Ubuntu + Nginx + PHP-FPM)

Dành cho môi trường sản xuất thực tế trên DigitalOcean, AWS EC2, Linode, Vultr hoặc Hetzner:

#### 1. Cài đặt các gói phần mềm trên Server
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx mysql-server php8.2-fpm php8.2-mysql php8.2-curl php8.2-mbstring php8.2-xml php8.2-zip php8.2-gd git unzip
sudo apt install -y certbot python3-certbot-nginx
```

#### 2. Kéo mã nguồn và cài đặt
```bash
cd /var/www
sudo git clone https://github.com/tanmanh-31102005/LunaraSilver.git lunara
cd lunara

# Cài đặt PHP dependencies
composer install --no-dev --optimize-autoloader

# Cấu hình môi trường
cp .env.example .env
nano .env   # Cập nhật APP_ENV=production, APP_DEBUG=false, DB credentials

php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan db:seed --class=AdminUserSeeder --force

# Cài đặt và build Node
npm install
npm run build

# Phân quyền thư mục cho Nginx
sudo chown -R www-data:www-data /var/www/lunara
sudo chmod -R 775 /var/www/lunara/storage /var/www/lunara/bootstrap/cache
```

#### 3. Cấu hình Nginx Virtual Host
Tạo file cấu hình `/etc/nginx/sites-available/lunara`:
```nginx
server {
    listen 80;
    server_name lunarasilver.vn www.lunarasilver.vn;
    root /var/www/lunara/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Kích hoạt site và cài đặt chứng chỉ SSL miễn phí:
```bash
sudo ln -s /etc/nginx/sites-available/lunara /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Cài đặt SSL Let's Encrypt tự động
sudo certbot --nginx -d lunarasilver.vn -d www.lunarasilver.vn
```

---

### Quy trình Tối ưu & Checklist Bảo mật Production

Mỗi khi cập nhật phiên bản mới lên máy chủ Production, hãy chạy bộ lệnh tối ưu sau để tăng tốc website gấp 3-5 lần:

```bash
# 1. Xóa và tối ưu hóa bộ nhớ đệm cấu hình & định tuyến
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 2. Tối ưu autoloader của Composer
composer dump-autoload --optimize --no-dev --classmap-authoritative

# 3. Đảm bảo cấu hình bảo mật
# - APP_DEBUG=false (Bắt buộc! Tránh làm lộ thông tin database khi có lỗi)
# - APP_ENV=production
# - Khóa quyền đọc file .env (chmod 600 .env)
```

---

## 10. Cấu trúc Thư mục Dự án

```text
Lunara/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Account/          # Hồ sơ, Mật khẩu, Sổ địa chỉ, Đơn hàng khách
│   │   │   ├── Admin/            # Dashboard, Quản lý Sản phẩm, Danh mục, Đơn hàng, Ảnh
│   │   │   ├── Auth/             # Đăng ký, Đăng nhập, Quên/Đổi mật khẩu
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ProductController.php
│   │   │   └── VNPayController.php
│   │   └── Middleware/           # AdminMiddleware, Auth check
│   ├── Models/                   # Product, BundleItem, Order, Payment, Cart, Address...
│   └── Services/
│       ├── CartService.php       # Logic giỏ hàng & kiểm tra tồn kho
│       ├── CheckoutService.php   # Xử lý giao dịch đặt hàng & lock tồn kho
│       ├── CloudinaryService.php # Upload, sync & delete ảnh trên Cloud
│       ├── OrderStatusService.php# Quản lý vòng đời trạng thái đơn hàng & audit log
│       └── VNPay/                # VNPayService, RefundService, Reconciliation
├── database/
│   ├── data/catalog.json         # Nguồn dữ liệu catalog sản phẩm chuẩn hóa
│   ├── migrations/               # Cấu trúc bảng CSDL
│   └── seeders/                  # Seeders danh mục, sản phẩm, admin
├── docs/                         # Tài liệu đặc tả nghiệp vụ, kiến trúc & hướng dẫn
│   ├── Cau-truc-Website-Lunara-Silver.docx
│   ├── DEPLOYMENT_INFINITYFREE.md       # Hướng dẫn chi tiết triển khai InfinityFree
│   ├── HE_THONG_VA_KIEN_TRUC_LUNARA.md  # Sổ tay kiến trúc, nghiệp vụ & tự động hóa chuyên sâu
│   ├── MasterPlan.txt                   # Kế hoạch phát triển chi tiết qua các giai đoạn
│   ├── ProductData.xlsx                 # Nguồn dữ liệu danh mục & sản phẩm chuẩn hóa
│   └── VNPay_Sandbox_Test_Cards_Full.xlsx # Thông tin thẻ ngân hàng thử nghiệm VNPay
├── media/                        # Nguồn hình ảnh gốc (Product, Collection, Gift)
├── public/
│   ├── build/                    # Tài nguyên CSS, JS biên dịch từ Vite
│   ├── media-previews/           # Ảnh WebP tối ưu hóa cho trang chủ & catalog
│   ├── .htaccess                 # Rewrite rule định tuyến cho Apache/LiteSpeed
│   └── index.php
├── resources/
│   ├── css/                      # Custom CSS & Design tokens
│   ├── js/                       # AJAX Cart, UI interactions
│   └── views/
│       ├── account/              # Giao diện trang khách hàng
│       ├── admin/                # Giao diện trang quản trị
│       ├── auth/                 # Giao diện đăng nhập, đăng ký, quên mật khẩu
│       ├── components/           # Blade Components (navbar, footer, cards, badges...)
│       ├── layouts/              # Master layouts (app, admin)
│       └── ...                   # Home, Products, Cart, Checkout
├── routes/
│   ├── web.php                   # Định tuyến toàn bộ Storefront, Account, Admin, VNPay
│   └── console.php
├── tests/                        # 240 Automated tests bao phủ toàn bộ hệ thống
├── .htaccess                     # Định tuyến request gốc vào /public & bảo vệ file nhạy cảm
├── diag.php                      # Bộ chẩn đoán sức khỏe hệ thống & giả lập request
├── sync_phase13.php              # Bộ tự động đồng bộ cấu hình .env & chạy migration trên web
├── update_vendor.php             # Bộ cập nhật tự động gói vendor bằng ZipArchive
└── lunara_silver_export.sql      # Bản snapshot cơ sở dữ liệu mẫu chuẩn UTF-8mb4
```

---

## 11. Tài liệu Tham khảo & Nghiên cứu

- 📘 **[Sổ Tay Kiến Trúc, Nghiệp Vụ & Tự Động Hóa Vận Hành](docs/HE_THONG_VA_KIEN_TRUC_LUNARA.md)**: *Tài liệu chi tiết chuyên sâu nhất dành cho việc học tập, giải thích toàn bộ luồng xử lý Inventory ảo, VNPay Sandbox, Snapshot đơn hàng và bộ ba script chẩn đoán.*
- 🚀 **[Hướng dẫn Triển khai Hosting InfinityFree](docs/DEPLOYMENT_INFINITYFREE.md)**: *Quy trình từng bước đưa website lên domain `lunarasilver.infinityfreeapp.com`.*
- 📋 **[Tài liệu Kiến trúc & Sitemap](docs/Cau-truc-Website-Lunara-Silver.docx)**: *Định nghĩa luồng trải nghiệm khách hàng và sitemap chuẩn.*
- 📊 **[Dữ liệu Sản phẩm Gốc (Excel)](docs/ProductData.xlsx)**: *Nguồn dữ liệu gốc cho 45 sản phẩm, thông số bạc, đá, size và bộ sưu tập.*
- 💳 **[Danh sách Thẻ Test VNPay Sandbox](docs/VNPay_Sandbox_Test_Cards_Full.xlsx)**: *Danh sách thông tin thẻ ngân hàng thử nghiệm cổng thanh toán VNPay.*

---

<p align="center">
  Phát triển với sự tâm huyết dành cho thương hiệu <strong>Lunara Silver</strong>.<br>
  © 2026 Lunara Silver. All rights reserved.
</p>
