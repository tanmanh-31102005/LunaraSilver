# LUNARA SILVER — TÀI LIỆU VẬN HÀNH & TRIỂN KHAI (DEPLOYMENT MANIFEST)

Tài liệu đặc tả toàn diện quy trình triển khai, đóng gói và phát hành hệ thống **Lunara Silver** lên môi trường sản xuất (Production / InfinityFree Shared Hosting).

---

## 1. TỔNG QUAN KIẾN TRÚC MÔI TRƯỜNG TRIỂN KHAI

| Thành phần | Môi trường Local / Staging | Môi trường Production (InfinityFree) |
| :--- | :--- | :--- |
| **Domain** | `http://127.0.0.1:8000` / `localhost` | `https://lunarasilver.infinityfreeapp.com` |
| **Web Server** | PHP Built-in Server / Apache XAMPP | Apache 2.4 (Virtual Host `htdocs`) |
| **PHP Version** | PHP 8.2+ / 8.3 | PHP 8.2.x |
| **Database** | MariaDB 10.4+ / MySQL 8.0 | MySQL 5.7+ (Database `if0_42986888_lunara`) |
| **Media Delivery** | Local Fallback (`media/`, `public/media-previews/`) | Cloudinary Global CDN + Local WebP fallback |
| **Payment** | VNPay Sandbox | VNPay Sandbox Gateway (Mode: QueryDr + IPN) |
| **Asset Pipeline** | Vite Dev Server | Vite Precompiled Bundle (`public/build/`) |

---

## 2. DANH MỤC TỆP ĐỒNG BỘ (UPLOADED ARTIFACTS)

Quy trình phát hành tự động qua `scripts/deploy_direct.py` đồng bộ trực tiếp các tệp tin cốt lõi vào thư mục `htdocs/`:

### A. Nhân hệ thống & Định tuyến (Bootstrap, Middleware & Routes)
- `bootstrap/app.php` — Cấu hình ứng dụng, tin cậy Reverse Proxy, đăng ký Middleware.
- `app/Http/Middleware/SecurityHeadersMiddleware.php` — Bảo vệ HTTP headers (CSP, HSTS-safe, nosniff, frame protection).
- `app/Http/Middleware/EnsureUserIsAdmin.php` — Phân quyền quản trị viên.
- `app/Http/Middleware/SeoRedirectMiddleware.php` — Quản lý 301 SEO redirects.
- `routes/web.php` — Bản đồ 143 route công khai và quản trị.

### B. Nghiệp vụ Quản trị & Dịch vụ Khách hàng (Admin Intelligence & Customer 360)
- `app/Http/Controllers/Admin/DashboardController.php` — Dashboard điều hành kinh doanh & KPI.
- `app/Http/Controllers/Admin/CustomerController.php` — Hồ sơ khách hàng Customer 360.
- `app/Http/Controllers/Admin/AdminSearchController.php` — Command Palette toàn hệ thống.
- `app/Http/Controllers/Admin/ExportController.php` — Xuất báo cáo CSV streaming chunked.
- `app/Services/Admin/AnalyticsService.php` — Thống kê & tính toán tài chính có caching.
- `app/Services/Admin/AttentionService.php` — Cảnh báo vận hành (Hết hàng, đơn trễ).
- `app/Services/Admin/CustomerInsightsService.php` — Phân tích hành vi, LTV, RFM khách hàng.
- `app/Services/Admin/AdminSearchService.php` — Tìm kiếm thông minh theo tiền tố.
- `app/Services/Admin/ExportService.php` — Truy vấn gom nhóm pre-aggregated.

### C. Giao diện Người dùng & Thành phần Tương tác (Storefront & Shared Views)
- `resources/views/layouts/app.blade.php` — Khung giao diện chính chuẩn SEO & WCAG 2.2 AA.
- `resources/views/home.blade.php` — Trang chủ tối ưu Core Web Vitals.
- `resources/views/components/hero-slider.blade.php` — Hero slider tải ưu tiên fetchpriority="high".
- `resources/views/components/mega-menu.blade.php` — Mega Menu đa cấp điều hướng bàn phím.
- `resources/views/components/search-overlay.blade.php` — Hộp tìm kiếm live suggestions có bẫy tiêu điểm.
- `resources/views/components/cart-drawer.blade.php` — Giỏ hàng trượt accessible.
- `resources/views/products/_reviews_section.blade.php` — Khung đánh giá có screen-reader sao.
- `resources/views/admin/customers/tabs/*.blade.php` — 5 tabs lazy loading Customer 360.

### D. Hệ thống Báo lỗi Cao cấp (Custom Luxury Error Views)
- `resources/views/errors/layout.blade.php` — Layout độc lập, zero-dependency.
- `resources/views/errors/404.blade.php` — Không tìm thấy trang.
- `resources/views/errors/403.blade.php` — Quyền truy cập bị từ chối.
- `resources/views/errors/419.blade.php` — Hết hạn phiên làm việc (CSRF).
- `resources/views/errors/429.blade.php` — Giới hạn tần suất thao tác (Rate Limit).
- `resources/views/errors/500.blade.php` — Sự cố gián đoạn không rò rỉ mã nguồn.
- `resources/views/errors/503.blade.php` — Thông báo bảo trì định kỳ.

### E. Tài nguyên Đã Biên dịch (Vite Production Bundles)
- `public/build/manifest.json` — Ánh xạ tài nguyên tĩnh.
- `public/build/assets/app-*.css` — CSS chính của cửa hàng.
- `public/build/assets/admin-*.css` — CSS dành riêng cho khu vực quản trị.
- `public/build/assets/app-*.js` — Toàn bộ logic frontend vanilla JS.

---

## 3. DANH MỤC LOẠI TRỪ (EXCLUDED ARTIFACTS)

Tuyệt đối **KHÔNG** đưa các tài nguyên sau lên Git hoặc quy trình phát hành:
1. `.env` (Biến môi trường bí mật chứa mật khẩu database, VNPay hash secret, Gmail password).
2. `node_modules/` (Thư viện Node.js dung lượng lớn).
3. `vendor/` (Đã được triển khai sẵn trên hosting, không ghi đè qua FTP thường).
4. `backup/` (Bản sao lưu CSDL chứa thông tin khách hàng).
5. `scratch/` (Các script kiểm thử và benchmark nội bộ).
6. `.git/` (Lịch sử phiên bản).
7. `tests/` (Mã nguồn kiểm thử tự động chỉ chạy môi trường CI/Local).
8. `storage/logs/*.log` (File nhật ký vận hành cũ).

---

## 4. QUY TRÌNH BIÊN DỊCH VÀ PHÁT HÀNH (BUILD & DEPLOYMENT RUNBOOK)

### Bước 1: Kiểm thử và biên dịch cục bộ (Local Build)
```bash
# 1. Chạy toàn bộ 367+ tests hồi quy
C:\xampp\php\php.exe artisan test

# 2. Chuẩn hóa định dạng mã nguồn PSR-12
C:\xampp\php\php.exe vendor/bin/pint

# 3. Biên dịch tài nguyên tĩnh production
npm run build
```

### Bước 2: Đồng bộ hóa lên Hosting (Deploy Direct)
```bash
python scripts/deploy_direct.py
```
Script sẽ tự động:
1. Đăng nhập FTP bảo mật vào máy chủ InfinityFree.
2. Tải toàn bộ 51+ tệp tin được cập nhật vào đúng vị trí cây thư mục.
3. Tự động xóa bộ nhớ đệm view đã biên dịch (`storage/framework/views/*.php`) trên hosting để giao diện mới có hiệu lực tức thì.

### Bước 3: Đồng bộ trạng thái và dọn Cache máy chủ (Post-sync Trigger)
Kích hoạt script chẩn đoán `diag.php` trên trình duyệt hoặc cURL:
```
GET https://lunarasilver.infinityfreeapp.com/diag.php?clear_cache=1&sync_posts=1&migrate=1
```

---

## 5. CÁC HẠN CHẾ ĐÃ BIẾT CỦA HOSTING INFINITYFREE & GIẢI PHÁP

1. **Cơ chế Anti-Bot AES Challenge (`__test` cookie)**:
   - *Đặc điểm*: Máy chủ InfinityFree tự động chặn các HTTP client không có trình thông dịch JavaScript (như cURL, Postman hoặc Python requests thuần) bằng trang chuyển tiếp AES `aes.js`.
   - *Giải pháp*: Xây dựng bộ giải mã `benchmark_production_live.cjs` dùng Node.js VM tự động tính toán cookie `__test` gửi kèm request để đo lường TTFB chính xác.
2. **Không hỗ trợ SSH / Terminal / Composer CLI**:
   - *Đặc điểm*: Không thể chạy `php artisan` trực tiếp trên máy chủ.
   - *Giải pháp*: Tất cả lệnh migration, tối ưu hóa CSDL, dọn cache được tích hợp an toàn qua endpoint `diag.php` (bảo vệ quyền truy cập và chỉ chạy khi có token/tham số xác thực).
3. **Giới hạn Thời gian Thực thi (Execution Time Limit 30s) & Bộ nhớ (Memory Limit 128MB)**:
   - *Đặc điểm*: Các truy vấn lớn hoặc xuất dữ liệu toàn bộ sẽ gây lỗi Fatal Timeout 504.
   - *Giải pháp*: Sử dụng stream export chunking (`chunkById(200)`), pre-aggregated queries, và loại bỏ hoàn toàn các vòng lặp N+1 trong Customer 360 và Dashboard.
4. **Giới hạn Kết nối Đồng thời FTP (FTP Concurrency Limit)**:
   - *Đặc điểm*: Tải lên đồng thời nhiều luồng FTP sẽ bị ngắt kết nối `421 Too many connections`.
   - *Giải pháp*: Tối ưu script `deploy_direct.py` chạy theo cơ chế tuần tự đơn luồng ổn định, có kiểm tra thư mục cha tự động.
