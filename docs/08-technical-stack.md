# 08. BẢNG TỔNG HỢP CÔNG NGHỆ THỰC TẾ (TECHNICAL STACK MATRIX)

---

## 1. NGUYÊN TẮC KIỂM TOÁN CÔNG NGHỆ

Toàn bộ thông tin phiên bản trong tài liệu này được trích xuất trực tiếp từ tệp khóa phụ thuộc thực tế của dự án:
- `composer.lock` (Backend PHP & Laravel dependencies)
- `package.json` & `package-lock.json` (Frontend & Asset pipeline dependencies)

Tuyệt đối không sử dụng phiên bản phỏng đoán hoặc không tồn tại trong mã nguồn đóng băng của hệ thống.

---

## 2. MA TRẬN CÔNG NGHỆ HỆ THỐNG (SYSTEM TECHNOLOGY STACK)

| Công nghệ / Thư viện | Phiên bản thực tế (Lock version) | Phân loại | Mục đích & Vai trò trong hệ thống |
| :--- | :---: | :---: | :--- |
| **PHP Runtime** | `8.2.12` (`^8.2`) | Language Runtime | Môi trường thực thi mã nguồn backend chính, hỗ trợ Type Safety và Readonly properties. |
| **Laravel Framework** | `v12.69.2` | Core Web Framework | Bộ khung kiến trúc MVC, Routing, Eloquent ORM, Middleware, Service Container và Database Migrations. |
| **MariaDB / MySQL** | `10.4.32` / `8.0+` | Relational Database | Hệ quản trị cơ sở dữ liệu quan hệ lưu trữ 35 bảng, đảm bảo toàn vẹn giao dịch ACID qua InnoDB Engine. |
| **Cloudinary PHP SDK**| `3.1.3` | Cloud Storage SDK | Giao tiếp API lưu trữ, nén ảnh WebP tự động và phân phối đa phương tiện toàn cầu. |
| **Laravel Tinker** | `v2.11.1` | Developer Tool | Giao diện dòng lệnh REPL tương tác trực tiếp với Eloquent Models và Services. |
| **Symfony HttpFoundation**| `v7.4.19` | Low-level HTTP | Thư viện trừu tượng hóa HTTP Request, Response, Cookies và Session underlying của Laravel. |
| **Vite** | `7.3.6` | Frontend Bundler | Công cụ đóng gói tài nguyên frontend thế hệ mới, biên dịch CSS/JS siêu tốc và quản lý manifest. |
| **Laravel Vite Plugin**| `2.0.0` | Build Tool Integration | Tích hợp Vite vào quy trình kết xuất Blade Templates thông qua chỉ thị `@vite`. |
| **Bootstrap** | `5.3.8` | CSS/UI Framework | Hệ thống lưới Responsive Grid, Flexbox utilities và các thành phần giao diện cơ bản. |
| **Bootstrap Icons** | `1.13.1` | Icon Vector Library | Bộ biểu tượng vector định dạng SVG/WebFont cho nút giỏ hàng, kính lúp tìm kiếm và trạng thái. |
| **Axios** | `1.11.0` | HTTP Client JS | Thư viện JavaScript gửi yêu cầu bất đồng bộ (AJAX) cho Live Search và Mini Cart. |
| **Concurrently** | `9.0.1` | CLI Dev Tool | Hỗ trợ chạy đồng thời máy chủ PHP, Vite và Queue listener trong môi trường phát triển local. |
| **Chart.js** | `4.4.x` (CDN) | Visualization Library | Thư viện vẽ biểu đồ doanh thu theo thời gian trên trang Quản trị (Admin Dashboard). |
| **PHPUnit** | `11.5.56` | Testing Framework | Khung thực thi 367 bài kiểm thử tự động (Feature & Unit Tests) bảo đảm hệ thống không hồi quy lỗi. |
| **Laravel Pint** | `v1.30.4` | Code Formatter | Công cụ tự động chuẩn hóa toàn bộ mã nguồn PHP theo tiêu chuẩn PSR-12. |
| **FakerPHP** | `v1.24.1` | Testing / Seeding | Sinh dữ liệu giả lập tự nhiên (Tên, địa chỉ, số điện thoại) phục vụ CatalogSeeder và Tests. |

---

## 3. CÁC CỔNG DỊCH VỤ & NỀN TẢNG BÊN NGOÀI (EXTERNAL SERVICES)

| Tên dịch vụ bên ngoài | Phiên bản giao thức | Phương thức tích hợp | Mục đích sử dụng |
| :--- | :---: | :---: | :--- |
| **Cổng Thanh toán VNPay**| `2.1.0` API | Redirect & REST API | Xử lý thanh toán thẻ ngân hàng, mã VNPAY-QR, đối soát QueryDr và API hoàn tiền trực tuyến. |
| **Cloudinary Media API** | v1_1` REST API | HTTPS API & CDN | Lưu trữ hình ảnh sản phẩm, ảnh review của khách hàng và tự động tạo thumbnail WebP. |
| **Google SMTP Mail** | TLS / Port 587 | SMTP Protocol | Gửi thư điện tử xác nhận đơn hàng, hóa đơn điện tử và phản hồi tư vấn tự động. |
| **InfinityFree Hosting** | Apache 2.4 / PHP 8.2 | FTP Deployment | Môi trường máy chủ sản xuất lưu trữ website tại `https://lunarasilver.infinityfreeapp.com`. |
