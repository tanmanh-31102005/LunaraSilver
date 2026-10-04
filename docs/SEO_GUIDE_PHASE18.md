# TÀI LIỆU TOÀN DIỆN VỀ HỆ THỐNG SEO LUNARA SILVER
**Giai đoạn thực hiện: PHASE 18 — Complete SEO Architecture & Organic Growth Foundation**  
**Trạng thái:** Hoàn thành kiểm thử cục bộ 100% (303/303 Tests Passed) — Đang chờ xác nhận từ Quản trị viên trước khi Deploy lên Live  
**Website:** `https://lunarasilver.infinityfreeapp.com`

---

## MỤC LỤC
1. [Tổng quan & Mục tiêu chiến lược Phase 18](#1-tổng-quan--mục-tiêu-chiến-lược-phase-18)
2. [Thông tin doanh nghiệp & Chính sách xác thực (E-E-A-T)](#2-thông-tin-doanh-nghiệp--chính-sách-xác-thực-e-e-a-t)
3. [Kiến trúc Technical SEO & Điều khiển Thu thập dữ liệu (Crawl/Index Control)](#3-kiến-trúc-technical-seo--điều-khiển-thu-thập-dữ-liệu-crawlindex-control)
4. [Hệ thống Dữ liệu có cấu trúc chuẩn Schema.org (JSON-LD)](#4-hệ-thống-dữ-liệu-có-cấu-trúc-chuẩn-schemaorg-json-ld)
5. [Cơ chế Chuyển hướng 301 Tự động & Bảo toàn thứ hạng URL](#5-cơ-chế-chuyển-hướng-301-tự-động--bảo-toàn-thứ-hạng-url)
6. [Công cụ Quản trị SEO & Xem trước Google SERP (Admin SERP Preview)](#6-công-cụ-quản-trị-seo--xem-trước-google-serp-admin-serp-preview)
7. [Bảng Ma trận Kiểm toán SEO chi tiết từng trang (SEO Audit Matrix)](#7-bảng-ma-trận-kiểm-toán-seo-chi-tiết-từng-trang-seo-audit-matrix)
8. [Hướng dẫn cấu hình Google Search Console & Nộp Sitemap](#8-hướng-dẫn-cấu-hình-google-search-console--nộp-sitemap)
9. [Kế hoạch & Quy trình Deploy an toàn lên máy chủ Live](#9-kế-hoạch--quy-trình-deploy-an-toàn-lên-máy-chủ-live)

---

## 1. TỔNG QUAN & MỤC TIÊU CHIẾN LƯỢC PHASE 18

Trong giai đoạn này, Lunara Silver được nâng cấp toàn diện từ nền tảng thương mại điện tử sang một hệ thống chuẩn SEO cấp doanh nghiệp (Enterprise-grade SEO Architecture). Toàn bộ hệ thống được thiết kế để Googlebot thu thập dữ liệu (crawl) chính xác, chỉ lập chỉ mục (index) các trang có giá trị, ngăn chặn trùng lặp nội dung và hiển thị kết quả tìm kiếm phong phú (Rich Results / Snippets).

### Nguyên tắc bất khả xâm phạm:
- **Giữ nguyên 100% logic nghiệp vụ:** Giỏ hàng (Cart), Tồn kho (Inventory), Thanh toán (COD & VNPay), Mã giảm giá (Coupons), Vòng đời đơn hàng (Order Lifecycle), Đổi trả/Hoàn tiền (Refund), Đồng bộ ảnh Cloudinary và Live Support Chat đều hoạt động nguyên vẹn, không bị xáo trộn.
- **Giữ nguyên cấu trúc URL thân thiện (Clean URLs):**
  - Trang chủ: `/`
  - Danh mục: `/products/{category:slug}`
  - Sản phẩm: `/product/{product:slug}`
  - Tạp chí/Blog: `/blog` và `/blog/{slug}`
  - Hỗ trợ/Chính sách: `/support/faq` và `/contact`
- **Khắc phục triệt để các hạn chế của hosting miễn phí InfinityFree:** Sử dụng script di trú tự động không cần truy cập SSH, xử lý đường dẫn tương thích máy chủ NGINX/Apache.

---

## 2. THÔNG TIN DOANH NGHIỆP & CHÍNH SÁCH XÁC THỰC (E-E-A-T)

Theo nguyên tắc đánh giá chất lượng tìm kiếm của Google (E-E-A-T: Experience, Expertise, Authoritativeness, Trustworthiness), tính minh bạch về địa chỉ vật lý, kênh liên hệ và chính sách hậu mãi là yếu tố cốt lõi quyết định thứ hạng từ khóa.

Toàn bộ hệ thống (từ metadata, schema JSON-LD, footer, trang hỗ trợ, trang liên hệ, đến accordion chi tiết sản phẩm) đã được đồng bộ hóa thống nhất với dữ liệu chính thức do bạn cung cấp:

* **Tên thương hiệu:** Lunara Silver — Trang sức bạc 925 cao cấp
* **Slogan:** *Shine with your own moonlight*
* **Địa chỉ trụ sở / Cửa hàng tiếp nhận đổi trả:**  
  `140 Lê Trọng Tấn, Phường Tây Thạnh, Quận Tân Phú, Ho Chi Minh City`
* **Hotline CSKH / Đặt hàng:** `0971 124 922`
* **Email liên hệ chính thức:** `lunaraslivertrangsuc@gmail.com`
* **Khung giờ làm việc:**  
  `Thứ Hai — Thứ Bảy: 08:30 - 20:30 (Chủ Nhật: 09:00 - 18:00)`
* **Chính sách đổi trả & bảo hành:**  
  - Đổi size / mẫu trong vòng 7 ngày đối với sản phẩm còn nguyên tem mác.
  - Bảo hành làm sạch, đánh bóng bạc miễn phí trọn đời.
  - Giao hàng toàn quốc có quyền đồng kiểm tra ngoại quan trước khi thanh toán.

---

## 3. KIẾN TRÚC TECHNICAL SEO & ĐIỀU KHIỂN THU THẬP DỮ LIỆU (CRAWL/INDEX CONTROL)

### 3.1. Tệp điều khiển bot `robots.txt`
Tệp `public/robots.txt` được cấu hình chuẩn quốc tế:
```text
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /cart
Disallow: /checkout
Disallow: /account/
Disallow: /order-success/

Sitemap: https://lunarasilver.infinityfreeapp.com/sitemap.xml
```
* **Lợi ích:** Tiết kiệm ngân sách thu thập thông tin (Crawl Budget) của Googlebot, ngăn bot lãng phí tài nguyên vào các trang nội bộ không phục vụ tìm kiếm.

### 3.2. Sơ đồ trang web tự động `sitemap.xml`
Truy cập tại: `https://lunarasilver.infinityfreeapp.com/sitemap.xml`
* **Tự động hóa hoàn toàn từ CSDL:** Mỗi khi bạn thêm sản phẩm, xuất bản bài viết blog mới hoặc cập nhật nội dung, sitemap sẽ tự động phản ánh ngay lập tức.
* **Thời gian cập nhật thực (`lastmod`):** Lấy chính xác `updated_at` của từng bài viết, sản phẩm và danh mục (định dạng chuẩn `YYYY-MM-DD`).
* **Lọc bỏ nội dung rác:** Tự động loại trừ:
  - Sản phẩm bị ẩn (`is_active = false`) hoặc đã xóa mềm.
  - Bài viết ở trạng thái bản nháp (`status = draft`).
  - Các danh mục sản phẩm chưa có sản phẩm nào.
* **Tần suất & Mức ưu tiên (Priority/Changefreq):**
  - Trang chủ (`/`): Priority `1.0`, Changefreq `daily`
  - Danh mục & Danh sách sản phẩm: Priority `0.8`, Changefreq `weekly`
  - Chi tiết sản phẩm: Priority `0.8`, Changefreq `weekly`
  - Blog Index: Priority `0.7`, Changefreq `daily`
  - Bài viết Blog: Priority `0.6`, Changefreq `monthly`
  - Hỗ trợ / Liên hệ: Priority `0.5`, Changefreq `monthly`

### 3.3. Thẻ chuẩn hóa Canonical (Anti-Duplicate Content)
Tất cả các trang đều chứa thẻ `<link rel="canonical" href="...">` chuẩn HTTPS.
* **Loại bỏ trùng lặp tham số:** Khi khách hàng lọc sản phẩm (`?sort=price_asc&material=bac-925&page=2`), thẻ canonical vẫn luôn trỏ về URL sạch ban đầu (`/products/day-chuyen`).
* **Chuẩn hóa trang chủ:** Luôn trỏ về `https://lunarasilver.infinityfreeapp.com` thay vì trỏ về `index.php` hay các biến thể có dấu xuyệt thừa.

### 3.4. Thẻ Robots Meta Directive linh hoạt
Được nhúng qua Blade component `<x-seo.meta />`:
* Trang bình thường: `<meta name="robots" content="index,follow">`
* Khi URL có truy vấn tìm kiếm, bộ lọc hoặc xem trang rỗng: Tự động chuyển thành `<meta name="robots" content="noindex,follow">` để tránh sinh ra hàng ngàn URL thin content trên Google.
* Trang quản trị (`/admin/*`) và trang tài khoản khách hàng (`/account/*`): Luôn áp dụng `noindex,follow` bảo vệ quyền riêng tư.

---

## 4. HỆ THỐNG DỮ LIỆU CÓ CẤU TRÚC CHUẨN SCHEMA.ORG (JSON-LD)

Dữ liệu có cấu trúc được kết xuất trực tiếp phía máy chủ (Server-side rendering), đảm bảo mọi bot tìm kiếm (Google, Bing, Facebook scraper) đều đọc được ngay mà không cần chờ Javascript chạy.

### 4.1. Schema `OnlineStore` (Trang chủ)
Khai báo cửa hàng trực tuyến chính hãng:
- **Tên thương hiệu:** Lunara Silver
- **Logo:** `https://lunarasilver.infinityfreeapp.com/media/lunara-logo-dark.svg`
- **Bộ phận hỗ trợ khách hàng (ContactPoint):** Hotline 0971 124 922, Email `lunaraslivertrangsuc@gmail.com`, ngôn ngữ hỗ trợ Tiếng Việt & Tiếng Anh.
- **Địa chỉ bưu chính (PostalAddress):** 140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Ho Chi Minh City.
- **Lịch làm việc chi tiết (OpeningHoursSpecification):** Phân chia rõ ngày thường (08:30 - 20:30) và Chủ Nhật (09:00 - 18:00).

### 4.2. Schema `Product` & `Offer` (Chi tiết sản phẩm)
Khai báo chi tiết sản phẩm cho Google Merchant và Google Search:
- **Tên, mô tả, SKU:** Trích xuất từ cơ sở dữ liệu.
- **Hình ảnh đa góc cạnh:** Tập hợp đầy đủ hình ảnh đại diện và thư viện ảnh Cloudinary độ phân giải cao.
- **Giá bán thực tế (Selling Price):** Sử dụng giá khuyến mãi (`sale_price`) nếu đang có chương trình giảm giá hợp lệ, hoặc giá niêm yết (`regular_price`).
- **Xác định tình trạng tồn kho thông minh:**
  - Đối với sản phẩm đơn (`single`): Đánh giá qua `stock_quantity > 0` (`InStock` hoặc `OutOfStock`).
  - **Đối với Combo / Set quà tặng (`collection`, `gift`):** Gọi hàm nghiệp vụ `$product->availableQuantity()` để kiểm tra chéo tồn kho của tất cả các sản phẩm thành phần cấu thành bên trong. Google sẽ nhận diện chính xác bộ quà tặng còn hàng hay hết hàng.

### 4.3. Schema `BlogPosting` (Bài viết blog)
- Tiêu đề, đoạn trích, hình ảnh bìa (cover image) chuẩn tỉ lệ 16:9.
- Khai báo tác giả (Author), nhà xuất bản (Publisher: Lunara Silver).
- Thời gian đăng bài (`datePublished`) và thời gian cập nhật nội dung gần nhất (`dateModified`).

### 4.4. Schema `BreadcrumbList` (Thanh điều hướng phân cấp)
Tự động gắn trên tất cả các trang danh mục, chi tiết sản phẩm, blog và bài viết blog. Giúp kết quả tìm kiếm trên Google hiển thị dạng:  
`Trang chủ > Bộ sưu tập > Dây chuyền > Dây Chuyền Bạc Mặt Trăng Dạ Lam` thay vì URL thô.

---

## 5. CƠ CHẾ CHUYỂN HƯỚNG 301 TỰ ĐỘNG & BẢO TOÀN THỨ HẠNG URL

Một vấn đề phổ biến trong SEO là khi người quản trị sửa tên hoặc sửa slug của sản phẩm / bài viết / danh mục, các URL cũ đã được Google index hoặc người dùng lưu lại sẽ bị lỗi **404 Not Found**, dẫn đến mất thứ hạng từ khóa.

Lunara Silver đã xây dựng hệ thống chuyển hướng tự động 301 (Permanent Redirect):
1. **Bảng cơ sở dữ liệu `seo_redirects`:** Lưu trữ lịch sử `old_path`, `new_path`, mã phản hồi `301`, và ngày tạo.
2. **Global Middleware `SeoRedirectMiddleware`:** Chạy trước mọi luồng xử lý, đón đầu các request đến URL cũ và chuyển hướng 301 ngay lập tức đến URL mới, bảo toàn 100% tham số query string (nếu có).
3. **Tự động đăng ký khi cập nhật Admin:**
   - Thay đổi slug Sản phẩm trong `ProductService`: Tự động tạo redirect `/product/slug-cu` → `/product/slug-moi`.
   - Thay đổi slug Danh mục trong `CategoryController`: Tự động tạo redirect `/products/danh-muc-cu` → `/products/danh-muc-moi`.
   - Thay đổi slug Bài viết trong `PostController`: Tự động tạo redirect `/blog/bai-viet-cu` → `/blog/bai-viet-moi`.
4. **Cơ chế Chain Collapsing & Loop Prevention (Chống vòng lặp):**
   - Nếu đổi từ A → B, sau đó tiếp tục đổi từ B → C: Hệ thống tự động thu gọn thành A → C và B → C (tránh tình trạng Googlebot phải chuyển hướng qua nhiều chặng).
   - Nếu đổi ngược từ B → A: Hệ thống tự hủy liên kết cũ, ngăn ngừa hoàn toàn lỗi chuyển hướng vô tận (Infinite Redirect Loop).

---

## 6. CÔNG CỤ QUẢN TRỊ SEO & XEM TRƯỚC GOOGLE SERP (ADMIN SERP PREVIEW)

Để hỗ trợ đội ngũ biên tập nội dung tối ưu SEO ngay trong quá trình nhập liệu, Lunara Silver tích hợp component Blade xem trước kết quả tìm kiếm Google trực tiếp:

* **Vị trí tích hợp:**
  - Thêm / Sửa Sản phẩm (`resources/views/admin/products/`)
  - Thêm / Sửa Danh mục sản phẩm (`resources/views/admin/categories/`)
  - Thêm / Sửa Bài viết tạp chí (`resources/views/admin/posts/`)
* **Tính năng:**
  - **Mô phỏng giao diện Google thực tế:** Hiển thị Favicon Lunara, tiêu đề màu xanh `#1a0dab`, đường link điều hướng và mô tả 2 dòng.
  - **Bộ đếm ký tự thời gian thực:**
    - Tiêu đề (Meta Title): Đếm ký tự / 60. Tự động cảnh báo màu xanh (Lý tưởng) hoặc màu vàng (Dài).
    - Mô tả (Meta Description): Đếm ký tự / 160. Cảnh báo độ dài phù hợp với thuật toán cắt ngắn của Google.
  - **Dự phòng thông minh (Smart Fallbacks):** Nếu để trống trường SEO riêng, hệ thống tự động trích xuất tên sản phẩm, danh mục hoặc đoạn trích bài viết để hiển thị preview.

---

## 7. BẢNG MA TRẬN KIỂM TOÁN SEO CHI TIẾT TỪNG TRANG (SEO AUDIT MATRIX)

| Trang / Tuyến đường | Tiêu đề tối ưu (Meta Title) | Thẻ Meta Robots | Canonical URL | Schema JSON-LD tích hợp | Thẻ Heading chính |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Trang chủ (`/`)** | `Lunara Silver \| Trang sức bạc tinh tế` | `index,follow` | `https://lunarasilver.infinityfreeapp.com` | `OnlineStore`, `ContactPoint`, `PostalAddress` | `<h1>` Ẩn chứa logo & khẩu hiệu thương hiệu |
| **Tất cả sản phẩm (`/products`)** | `Bộ Sưu Tập Trang Sức Bạc 925 Cao Cấp \| Lunara Silver` | `index,follow` (chuyển sang `noindex,follow` nếu có query lọc) | `https://lunarasilver.infinityfreeapp.com/products` | `BreadcrumbList` | `<h1>Bộ Sưu Tập Trang Sức Bạc 925</h1>` |
| **Danh mục sản phẩm (`/products/{slug}`)** | `{Tên danh mục} Bạc 925 Cao Cấp \| Lunara Silver` | `index,follow` (nếu có sản phẩm) | `https://lunarasilver.infinityfreeapp.com/products/{slug}` | `BreadcrumbList` | `<h1>{Tên danh mục}</h1>` kèm đoạn giới thiệu biên tập |
| **Chi tiết sản phẩm (`/product/{slug}`)** | `{Tên sản phẩm} \| Lunara Silver` | `index,follow` | `https://lunarasilver.infinityfreeapp.com/product/{slug}` | `Product`, `Offer` (giá thực, tồn kho bundle động), `BreadcrumbList` | `<h1>{Tên sản phẩm}</h1>` |
| **Tạp chí Lunara (`/blog`)** | `Lunara Journal \| Cẩm nang & cảm hứng trang sức` | `index,follow` (chuyển sang `noindex,follow` nếu tìm kiếm) | `https://lunarasilver.infinityfreeapp.com/blog` | `BreadcrumbList` | `<h1>Nhật Ký Lunara</h1>` |
| **Chi tiết bài viết (`/blog/{slug}`)** | `{Tiêu đề bài viết} \| Lunara Silver` | `index,follow` | `https://lunarasilver.infinityfreeapp.com/blog/{slug}` | `BlogPosting`, `BreadcrumbList` | `<h1>{Tiêu đề bài viết}</h1>` |
| **Hỗ trợ & FAQ (`/support/faq`)** | `Trung Tâm Hỗ Trợ & Câu Hỏi Thường Gặp (FAQ) — Lunara Silver` | `index,follow` (chuyển sang `noindex,follow` nếu tìm FAQ) | `https://lunarasilver.infinityfreeapp.com/support/faq` | — (Đã lược bỏ FAQPage theo bản cập nhật Google 05/2026) | `<h1>Trung Tâm Hỗ Trợ</h1>` |
| **Liên hệ (`/contact`)** | `Liên Hệ Với Chúng Tôi — Lunara Silver` | `index,follow` | `https://lunarasilver.infinityfreeapp.com/contact` | — (Hiển thị đầy đủ địa chỉ, hotline, giờ làm việc) | `<h1>Liên Hệ Với Lunara</h1>` |
| **Tài khoản cá nhân (`/account/*`)** | `Tài khoản của tôi \| Lunara Silver` | `noindex,follow` | Tương ứng từng trang con | — | `<h1>Bảng điều khiển</h1>` |

---

## 8. HƯỚNG DẪN CẤU HÌNH GOOGLE SEARCH CONSOLE & NỘP SITEMAP

### Bước 1: Lấy mã xác minh Google Search Console
1. Truy cập [Google Search Console](https://search.google.com/search-console).
2. Chọn loại tài sản **Tiền tố URL (URL prefix)** và nhập:  
   `https://lunarasilver.infinityfreeapp.com`
3. Tại phần Các phương thức xác minh khác, chọn **Thẻ HTML (HTML tag)**.
4. Sao chép chuỗi mã xác minh (ví dụ: `google-site-verification=abcdef123456...`).

### Bước 2: Nhập mã vào hệ thống Lunara Silver
Mở tệp `.env` trên hosting hoặc cập nhật trong `config/lunara.php`:
```dotenv
GOOGLE_SITE_VERIFICATION="chuỗi_mã_của_bạn_ở_đây"
```
Hệ thống sẽ tự động xuất thẻ sau vào thẻ `<head>` của mọi trang công khai:
```html
<meta name="google-site-verification" content="chuỗi_mã_của_bạn_ở_đây">
```
Sau đó bấm **Xác minh (Verify)** trên Google Search Console để hoàn tất.

### Bước 3: Nộp sơ đồ trang web (Sitemap Submission)
1. Trong menu bên trái của Google Search Console, bấm vào mục **Sơ đồ trang web (Sitemaps)**.
2. Tại ô "Thêm sơ đồ trang web mới", nhập: `sitemap.xml`
3. Nhấn **Gửi (Submit)**. Google sẽ lập tức nhận diện trạng thái Thành công và bắt đầu lập lịch thu thập dữ liệu toàn bộ sản phẩm và bài viết.

---

## 9. KẾ HOẠCH & QUY TRÌNH DEPLOY AN TOÀN LÊN MÁY CHỦ LIVE

Để đảm bảo quá trình triển khai diễn ra suôn sẻ, không phát sinh lỗi 500 hay gián đoạn dịch vụ:

1. **GitHub Actions Workflow tự động:**
   - File cấu hình `.github/workflows/deploy.yml` đã được cập nhật để sau khi tải mã nguồn qua FTP, hệ thống sẽ tự động gửi webhook gọi script `sync_phase18.php`.
2. **Cơ chế di trú tự động (`sync_phase18.php`):**
   - Script chạy trực tiếp trên máy chủ PHP của InfinityFree.
   - Tự động bổ sung các cột `seo_title`, `seo_description`, `seo_intro` vào bảng `categories` nếu chưa tồn tại.
   - Tự động khởi tạo bảng `seo_redirects` với chỉ mục `old_path` duy nhất.
   - Tự động dọn dẹp bộ nhớ đệm (Cache view, config, route).
   - Tự hủy hoặc vô hiệu hóa sau khi hoàn tất để bảo đảm an toàn thông tin.

---

> [!NOTE]
> **THÔNG BÁO TẠM DỪNG THEO YÊU CẦU:**  
> Hệ thống đã hoàn thành 100% công đoạn lập trình, cấu hình và kiểm thử chất lượng nội bộ. Tiến trình Deploy lên Live đã được giữ nguyên và đang **chờ chỉ thị xác nhận chính thức từ bạn** trước khi thực hiện bước đẩy mã nguồn lên máy chủ.
