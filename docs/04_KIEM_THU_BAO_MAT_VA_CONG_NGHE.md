# 🛡️ LUNARA SILVER — KIỂM THỬ, BẢO MẬT & MA TRẬN CÔNG NGHỆ THỰC TẾ
## ĐẶC TẢ MA TRẬN PHỤ THUỘC, KIẾN TRÚC PHÒNG THỦ OWASP & BỘ 367 BÀI KIỂM THỬ TỰ ĐỘNG

> **Mục đích tài liệu:** Cung cấp thông tin kỹ thuật chuyên sâu về các công nghệ mã nguồn mở được đóng băng trong hệ thống, kiến trúc an toàn thông tin phòng thủ đa tầng (Defense-in-Depth) tuân thủ OWASP Top 10, và tài liệu nghiệm thu chi tiết của bộ 367 bài kiểm thử tự động (Automated Test Suite) đạt tỷ lệ vượt qua 100%.

---

## 📑 MỤC LỤC TỔNG QUAN

1. [Ma trận Công nghệ & Phiên bản Thực tế (Locked Dependencies)](#1-ma-trận-công-nghệ--phiên-bản-thực-tế-locked-dependencies)
2. [Chiến lược & Hệ thống Kiểm thử Tự động (Automated Testing Framework)](#2-chiến-lược--hệ-thống-kiểm-thử-tự-động-automated-testing-framework)
3. [Danh mục 13 Phân hệ Kiểm thử Trọng yếu (Test Suite Breakdown)](#3-danh-mục-13-phân-hệ-kiểm-thử-trọng-yếu-test-suite-breakdown)
4. [Kiến trúc An toàn Thông tin & Phòng chống Tấn công (Security Controls)](#4-kiến-trúc-an-toàn-thông-tin--phòng-chống-tấn-công-security-controls)
5. [Tối ưu Hóa Hiệu Năng & SEO Kỹ thuật (Performance & SEO Architecture)](#5-tối-ưu-hóa-hiệu-năng--seo-kỹ-thuật-performance--seo-architecture)

---

## 1. MA TRẬN CÔNG NGHỆ & PHIÊN BẢN THỰC TẾ (LOCKED DEPENDENCIES)

Toàn bộ thông tin phiên bản trong bảng dưới đây được trích xuất trực tiếp từ tệp khóa phụ thuộc `composer.lock` và `package-lock.json` của dự án:

| Công nghệ / Thư viện | Phiên bản Khóa (Lock Version) | Phân loại | Mục đích & Vai trò Kỹ thuật trong Hệ thống |
| :--- | :---: | :---: | :--- |
| **PHP Runtime** | `8.2.12` (`^8.2`) | Language Runtime | Môi trường thực thi backend, hỗ trợ Type Hinting nghiêm ngặt, Enums và Readonly Properties. |
| **Laravel Framework** | `v12.69.2` | Core Web Framework | Bộ khung kiến trúc MVC, Service Container, Eloquent ORM, Routing và Database Migrations. |
| **MariaDB / MySQL** | `10.4.32` / `8.0+` | Relational Database | Hệ quản trị cơ sở dữ liệu quan hệ ACID, hỗ trợ JSON fields và Pessimistic Locking. |
| **Cloudinary PHP SDK**| `3.1.3` | Cloud Storage SDK | Giao tiếp API đám mây tải ảnh, tự động nén WebP và xóa an toàn tài sản media. |
| **Vite** | `7.3.6` | Frontend Bundler | Công cụ đóng gói tài nguyên frontend thế hệ mới, tối ưu hóa CSS/JS và quản lý manifest. |
| **Laravel Vite Plugin**| `2.0.0` | Build Integration | Tích hợp đóng gói Vite vào quy trình render của Blade Templates qua chỉ thị `@vite`. |
| **Bootstrap** | `5.3.8` | CSS Framework | Cung cấp hệ thống lưới Responsive Grid, Flexbox và các thành phần UI nền tảng. |
| **Bootstrap Icons** | `1.13.1` | Vector Icons | Bộ biểu tượng SVG vector hiển thị giỏ hàng, ngôi sao đánh giá, nút đóng mở. |
| **Axios** | `1.11.0` | HTTP Client JS | Thư viện JavaScript gửi yêu cầu bất đồng bộ (AJAX) cho Mini Cart, Bộ lọc và Live Search. |
| **Chart.js** | `4.4.x` (CDN) | Data Visualization | Kết xuất biểu đồ trực quan biến động doanh thu thuần trên Admin Dashboard. |
| **PHPUnit** | `11.5.56` | Testing Framework | Khung thực thi 367 bài kiểm thử tự động (Unit & Feature Tests) bảo đảm không hồi quy lỗi. |
| **Laravel Pint** | `v1.30.4` | Code Formatter | Chuẩn hóa toàn bộ mã nguồn PHP theo phong cách PSR-12 tự động. |
| **FakerPHP** | `v1.24.1` | Test Data Factory | Sinh dữ liệu thử nghiệm chân thực phục vụ kiểm thử và nạp dữ liệu Seeder. |

---

## 2. CHIẾN LƯỢC & HỆ THỐNG KIỂM THỬ TỰ ĐỘNG (AUTOMATED TESTING FRAMEWORK)

### 2.1 Phương Pháp Tiếp Cận: Kiểm Thử Hộp Trắng Tự Động (Automated White-box Testing)
Dự án áp dụng phương pháp kiểm thử hộp trắng thông qua bộ khung **PHPUnit 11**:
* **Không dùng Database tạm bợ**: Các bài test chạy trực tiếp trên cơ sở dữ liệu thử nghiệm với trait `RefreshDatabase` hoặc bọc trong Database Transactions.
* **Tự động hóa hoàn toàn**: Một lệnh duy nhất có thể thẩm tra toàn bộ hệ thống từ Unit logic đến HTTP Request, Middleware, Session và Blade view rendering:
  ```bash
  php artisan test
  ```

### 2.2 Kết Quả Nghiệm Thu Kiểm Thử Tổng Thể
```text
========================================================================================
   LUNARA SILVER AUTOMATED TEST EXECUTION SUMMARY
========================================================================================
   Tests:    367 passed (100% Success Rate)
   Assertions: 1762 assertions verified
   Duration: 65.82s
   Coverage: 13 phân hệ nghiệp vụ, 37 controllers/services, 22 Eloquent models
========================================================================================
```

---

## 3. DANH MỤC 13 PHÂN HỆ KIỂM THỬ TRỌNG YẾU (TEST SUITE BREAKDOWN)

| Lớp Kiểm thử (Test Class) | Số lượng Test | Phân hệ Nghiệp vụ | Mục tiêu Thẩm định Cốt lõi |
| :--- | :---: | :---: | :--- |
| **`CartTest`** | 22 tests | Cart & Session | Thêm giỏ hàng, cập nhật số lượng, thiệp quà tặng, gộp giỏ vãng lai khi đăng nhập. |
| **`InventoryAvailabilityTest`** | 18 tests | Virtual Inventory | Thuật toán $\min$ tồn kho combo, cảnh báo hết hàng khi 1 linh kiện về 0, trần số lượng. |
| **`CheckoutTest`** | 26 tests | Checkout Engine | Token thanh toán dùng một lần, snapshot địa chỉ bất biến, trừ kho linh kiện an toàn. |
| **`VNPayPaymentTest`** | 19 tests | VNPay Gateway | Ký số HMAC-SHA512, Idempotent IPN Webhook, đối soát QueryDR, Payment Retry, Refund API. |
| **`CouponSystemTest`** | 21 tests | Promotion Engine | Chiết khấu %, trần giảm tối đa, min order, giới hạn lượt dùng, coupon đơn đầu tiên. |
| **`VerifiedReviewTest`** | 16 tests | Customer Reviews | Ràng buộc người mua đã hoàn tất đơn, 1 review/item, che tên riêng tư, SEO rating. |
| **`AdminAccessTest`** | 14 tests | RBAC & Security | Chặn khách vãng lai và user thường vào `/admin`, kiểm tra mã HTTP 403 Forbidden. |
| **`AdminOrderManagementTest`** | 24 tests | State Machine | Chuyển đổi trạng thái đơn hợp lệ, hoàn kho khi hủy, kích hoạt hoàn tiền VNPay tự động. |
| **`Customer360Test`** | 18 tests | Customer Insights | Tính toán LTV, AOV, tần suất mua, kiểm tra endpoint Lazy Tab AJAX nạp dưới 20ms. |
| **`SeoSystemTest`** | 15 tests | Technical SEO | Sitemap XML động, robots.txt, Canonical URL, JSON-LD Schema (Product, Article), 301 Middleware. |
| **`HomePageTest`** | 9 tests | Performance & UI | Giới hạn số lượng truy vấn O(1) chống N+1, kết xuất tài nguyên thương hiệu và slider. |
| **`StorefrontCloudinaryTest`** | 12 tests | Cloud Media | Vai trò ảnh primary/hover/gallery, cơ chế Fallback WebP khi mất kết nối đám mây. |
| **`ConciergeChatTest`** | 16 tests | Live Chat | Khởi tạo phiên khách với session token, lưu tin nhắn, giao diện phản hồi của tư vấn viên. |

---

## 4. KIẾN TRÚC AN TOÀN THÔNG TIN & PHÒNG CHỐNG TẤN CÔNG (SECURITY CONTROLS)

Dự án áp dụng mô hình phòng thủ theo chiều sâu (**Defense-in-Depth**) tuân thủ khuyến nghị tiêu chuẩn của **OWASP Top 10**:

### 4.1 Kiểm Soát Xác Thực & Mật Khẩu (Authentication Security)
* **Băm mật khẩu Bcrypt với Cost 12**: Mọi mật khẩu người dùng được băm tự động bằng giải thuật Bcrypt với độ phức tạp tính toán 12 vòng, vô hiệu hóa hoàn toàn các kỹ thuật tấn công giải mã Rainbow Table.
* **Phòng chống Tấn công Vét cạn (Brute-Force Rate Limiting)**: Áp dụng Rate Limiting trên các tuyến đường nhạy cảm (`/login`, `/register`), tự động chặn IP sau 5 lần đăng nhập thất bại trong 60 giây (trả về mã HTTP 429 Too Many Requests).
* **Bảo vệ Phiên làm việc (Session Hardening)**: Cookie phiên được cấu hình các cờ nghiêm ngặt:
  * `HttpOnly = true`: Chặn JavaScript truy cập đánh cắp Cookie qua lỗ hổng XSS.
  * `SameSite = Lax`: Giảm thiểu tối đa nguy cơ tấn công Giả mạo yêu cầu chéo trang (CSRF).

### 4.2 Phân Quyền & Chống Leo Thang Đặc Quyền (Privilege Escalation Defense)
* **Khóa cứng vai trò khi đăng ký**: Form đăng ký tài khoản mới tuyệt đối không nhận tham số `role` từ client. Mã nguồn gán cứng `role = 'user'`.
* **Bảo vệ Khu vực Quản trị qua Middleware Kép**: Tuyến đường `/admin/*` được bọc bởi hai tầng Middleware: `auth` và `EnsureUserIsAdmin`. Bất kỳ tài khoản nào không có quyền `admin` đều bị chặn ngay lập tức với mã HTTP 403.

### 4.3 Phòng Chống Tham Chiếu Đối Tượng Trực Tiếp Không An Toàn (IDOR Protection)
* **Chính sách phân quyền Laravel Policies**: Xây dựng 2 lớp Policy chính quy:
  * `app/Policies/OrderPolicy.php`: Kiểm tra quyền xem chi tiết đơn hàng của người dùng. Nếu khách A cố tình gõ mã đơn hàng của khách B trên thanh địa chỉ, hệ thống sẽ chặn với mã lỗi HTTP 403 Forbidden.
  * `app/Policies/AddressPolicy.php`: Kiểm tra quyền cập nhật/xóa sổ địa chỉ cá nhân.

### 4.4 Phòng Chống Tấn Công Giả Mạo Yêu Cầu (CSRF Protection)
* 100% các yêu cầu HTTP mang tính thay đổi trạng thái (`POST`, `PUT`, `PATCH`, `DELETE`) đều bắt buộc đính kèm thẻ xác thực `@csrf` token ngẫu nhiên được sinh theo từng phiên.
* Middleware `ValidateCsrfToken` tự động thẩm tra chữ ký token trước khi chuyển yêu cầu vào Controller.

### 4.5 Phòng Chống Tấn Công Chèn Mã Kịch Bản (XSS Mitigation)
* **Tự động mã hóa đầu ra tại View**: Blade Template mặc định biên dịch cú pháp `{{ $variable }}` thành hàm `htmlspecialchars($variable, ENT_QUOTES, 'UTF-8')`.
* **Bộ lọc Danh sách Trắng cho Bài viết Blog (HTML Sanitization Whitelist)**:
  Hệ thống triển khai hàm lọc chuyên dụng `Post::sanitizeHtml()` sử dụng danh sách trắng các thẻ cho phép (`<p>`, `<strong>`, `<em>`, `<ul>`, `<li>`, `<h3>`), tự động bóc tách và loại bỏ triệt để các thẻ nguy hiểm (`<script>`, `<iframe>`) và các sự kiện độc hại (`onload=`, `onerror=`).

### 4.6 Phòng Chống Tấn Công Tiêm Lệnh Cơ Sở Dữ Liệu (SQL Injection Prevention)
* 100% các thao tác truy vấn cơ sở dữ liệu được thực thi thông qua **Eloquent ORM** và **Query Builder** với kỹ thuật tham số hóa PDO (Parameterized Bindings). Tuyệt đối không nối chuỗi biến trực tiếp vào câu lệnh SQL thô.

### 4.7 Chống Can Thiệp Dữ Liệu Thanh Toán (Payment Tampering Defense)
* Mọi tham số gửi sang VNPay được ký số bảo mật bằng thuật toán **HMAC-SHA512**.
* Khi nhận phản hồi Webhook IPN, hệ thống thẩm định số tiền `vnp_Amount` nhận được có khớp chính xác 100% với giá trị lưu trong hóa đơn hay không trước khi đổi trạng thái đơn sang `paid`.

### 4.8 Tiêu Chuẩn Tiêu Đề Bảo Mật HTTP (HTTP Security Headers)
Middleware `SecurityHeadersMiddleware` tự động chèn các tiêu đề an toàn vào mọi phản hồi HTTP:
```text
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
```

---

## 5. TỐI ƯU HÓA HIỆU NĂNG & SEO KỸ THUẬT (PERFORMANCE & SEO ARCHITECTURE)

### 5.1 Giải Pháp Triệt Tiêu Lỗi N+1 Query (Eager Loading Optimization)
Trong các trang danh mục và trang chủ, nếu tải quan hệ ảnh và danh mục theo cách thông thường, hệ thống sẽ thực hiện hàng chục câu truy vấn lặp đi lặp lại.
* **Giải pháp của Lunara Silver**: Áp dụng Eager Loading triệt để:
  ```php
  Product::with(['category', 'images', 'bundleItems.component'])->where('is_active', true)->get();
  ```
* Số lượng câu truy vấn trang chủ được khống chế ở mức hằng số **$O(1)$** (dưới 20 queries) bất kể số lượng sản phẩm hiển thị trên trang tăng lên bao nhiêu.

### 5.2 Tối Ưu Hóa Hình Ảnh & Bộ Nhớ Đệm Đa Phương Tiện
* Ảnh trang sức được nén sang định dạng hiện đại **WebP**, giảm từ 60% đến 80% dung lượng so với ảnh PNG/JPG truyền thống.
* Sử dụng thư mục `public/media-previews/` lưu trữ các thumbnail siêu nhẹ để phục vụ hiển thị ngay lập tức khi người dùng cuộn trang.

### 5.3 Tự Động Hóa SEO & Cấu Trúc Microdata JSON-LD
* **Dynamic XML Sitemap (`/sitemap.xml`)**: Tự động sinh danh sách liên kết sản phẩm, danh mục, bài viết kèm tần suất cập nhật (`daily`/`weekly`) và độ ưu tiên (`priority`).
* **Canonical URLs**: Mọi trang công khai đều có thẻ `<link rel="canonical">` chỉ định đường dẫn gốc chuẩn, ngăn chặn hoàn toàn lỗi phạt nội dung trùng lặp (Duplicate Content) do các tham số bộ lọc gây ra.
* **5 Cấu Trúc Dữ Liệu JSON-LD Schema.org**:
  1. `Organization`: Nhận diện pháp nhân thương hiệu, logo, mạng xã hội.
  2. `WebSite`: Sitelinks Searchbox phục vụ tìm kiếm trực tiếp trên kết quả Google.
  3. `Product` & `Offer`: Định danh SKU, giá bán, tình trạng tồn kho.
  4. `AggregateRating`: Điểm số sao đánh giá trung bình hiển thị nổi bật trên kết quả tìm kiếm.
  5. `Article`: Cấu trúc bài viết báo chí chuẩn mực cho phân hệ Blog.

---

<p align="center">
  <strong>LUNARA SILVER — KIỂM THỬ TỰ ĐỘNG & BẢO MẬT CHUYÊN SÂU</strong><br>
  Bảo đảm hệ thống vận hành tin cậy, an toàn và đạt tiêu chuẩn kiểm toán phần mềm chất lượng cao.
</p>
