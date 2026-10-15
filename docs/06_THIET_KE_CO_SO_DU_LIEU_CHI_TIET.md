# 🗄️ LUNARA SILVER — TÀI LIỆU THIẾT KẾ CƠ SỞ DỮ LIỆU CHI TIẾT
## TOÀN BỘ 37 BẢNG DỮ LIỆU, CHỨC NĂNG NGHIỆP VỤ & VỊ TRÍ CODE MÃ NGUỒN ÁNH XẠ

> **Mục đích tài liệu:** Cung cấp tài liệu tra cứu toàn diện về kiến trúc Cơ sở dữ liệu (Database Schema) của hệ thống **Lunara Silver** phục vụ báo cáo đồ án, thuyết minh kỹ thuật và bảo vệ tốt nghiệp trước Hội đồng chấm thi. Tài liệu liệt kê chính xác **37 bảng dữ liệu** được phân bổ theo 10 phân hệ nghiệp vụ, chỉ rõ mục đích lưu trữ, các tính năng tương ứng và vị trí từng tập tin mã nguồn (Migration, Model, Controller, Service, Blade View).

---

## 📑 MỤC LỤC TỔNG QUAN

1. [Tổng Quan Kiến Trúc Cơ Sở Dữ Liệu (Database Overview)](#1-tổng-quan-kiến-trúc-cơ-sở-dữ-liệu-database-overview)
2. [Bảng Tra Cứu Nhanh 37 Bảng Dữ Liệu (Master Reference Matrix)](#2-bảng-tra-cứu-nhanh-37-bảng-dữ-liệu-master-reference-matrix)
3. [Chi Tiết 10 Phân Hệ Dữ Liệu & Vị Trí Code Ánh Xạ](#3-chi-tiết-10-phân-hệ-dữ-liệu--vị-trí-code-ánh-xạ)
   - [Phân hệ 1: Quản trị Người dùng & Xác thực (3 bảng)](#phân-hệ-1-quản-trị-người-dùng--xác-thực-3-bảng)
   - [Phân hệ 2: Danh mục, Sản phẩm, Tồn kho & Combo (4 bảng)](#phân-hệ-2-danh-mục-sản-phẩm-tồn-kho--combo-4-bảng)
   - [Phân hệ 3: Khách hàng, Giỏ hàng & Yêu thích (4 bảng)](#phân-hệ-3-khách-hàng-giỏ-hàng--yêu-thích-4-bảng)
   - [Phân hệ 4: Đơn hàng & Quản lý Quy trình Xử lý (4 bảng)](#phân-hệ-4-đơn-hàng--quản-lý-quy-trình-xử-lý-4-bảng)
   - [Phân hệ 5: Thanh toán & Hoàn tiền VNPay (2 bảng)](#phân-hệ-5-thanh-toán--hoàn-tiền-vnpay-2-bảng)
   - [Phân hệ 6: Khuyến mãi & Mã giảm giá (2 bảng)](#phân-hệ-6-khuyến-mãi--mã-giảm-giá-2-bảng)
   - [Phân hệ 7: Đánh giá & Phản hồi Khách hàng (2 bảng)](#phân-hệ-7-đánh-giá--phản-hồi-khách-hàng-2-bảng)
   - [Phân hệ 8: Chăm sóc Khách hàng, Liên hệ & Hỗ trợ (5 bảng)](#phân-hệ-8-chăm-sóc-khách-hàng-liên-hệ--hỗ-trợ-5-bảng)
   - [Phân hệ 9: Nội dung, Blog & Marketing (4 bảng)](#phân-hệ-9-nội-dung-blog--marketing-4-bảng)
   - [Phân hệ 10: Cấu hình Hệ thống & Hạ tầng Framework (7 bảng)](#phân-hệ-10-cấu-hình-hệ-thống--hạ-tầng-framework-7-bảng)
4. [5 Giải Thuật Dữ Liệu Độc Quyền Cần Nhấn Mạnh Khi Báo Cáo](#4-5-giải-thuật-dữ-liệu-độc-quyền-cần-nhấn-mạnh-khi-báo-cáo)

---

## 1. TỔNG QUAN KIẾN TRÚC CƠ SỞ DỮ LIỆU (DATABASE OVERVIEW)

* **Hệ quản trị CSDL:** MySQL 8.0 / MariaDB 10.4.
* **Quy chuẩn thiết kế:** Chuẩn hóa dữ liệu bậc **3NF (Third Normal Form)**, đảm bảo không trùng lặp và toàn vẹn tham chiếu.
* **Bộ mã hóa ký tự (Charset / Collation):** `utf8mb4` / `utf8mb4_unicode_ci` (hỗ trợ lưu tiếng Việt có dấu và biểu tượng cảm xúc Emoji).
* **Storage Engine:** `InnoDB` (hỗ trợ Transaction ACID, Foreign Key Constraints và Pessimistic Row-level Locking `lockForUpdate()`).
* **Tổng số bảng thực tế:** **37 bảng** (trong đó có 30 bảng nghiệp vụ trực tiếp và 7 bảng phục vụ hạ tầng Framework Laravel).

```
                      ┌────────────────────────────────┐
                      │             USERS              │
                      └────────┬──────────────┬────────┘
                               │              │
                    ┌──────────▼────┐    ┌────▼──────────┐
                    │   ADDRESSES   │    │  ORDERS /     │
                    └───────────────┘    │  PAYMENTS     │
                                         └───────┬───────┘
                                                 │
                                         ┌───────▼───────┐
                                         │  ORDER_ITEMS  │
                                         └───────┬───────┘
                                                 │
                      ┌──────────────────────────▼─────┐
                      │            PRODUCTS            │
                      └────────┬──────────────┬────────┘
                               │              │
                    ┌──────────▼────┐    ┌────▼──────────┐
                    │ BUNDLE_ITEMS  │    │PRODUCT_IMAGES │
                    └───────────────┘    └───────────────┘
```

---

## 2. BẢNG TRA CỨU NHANH 37 BẢNG DỮ LIỆU (MASTER REFERENCE MATRIX)

| STT | Tên bảng (Table Name) | Số cột | Phân hệ nghiệp vụ | Chức năng lưu trữ chính | Eloquent Model tương ứng |
| :---: | :--- | :---: | :--- | :--- | :--- |
| **1** | `users` | 9 | Quản trị người dùng | Tài khoản khách hàng & Quản trị viên (Admin) | [User.php](file:///d:/Lunara/app/Models/User.php) |
| **2** | `password_reset_tokens` | 3 | Quản trị người dùng | Token đặt lại mật khẩu an toàn theo thời gian | Framework Driver |
| **3** | `sessions` | 6 | Quản trị người dùng | Phiên đăng nhập người dùng trên database | Framework Driver |
| **4** | `categories` | 12 | Catalog & Danh mục | Cây danh mục sản phẩm đa cấp & thông số SEO | [Category.php](file:///d:/Lunara/app/Models/Category.php) |
| **5** | `products` | 25 | Catalog & Tồn kho | 45 sản phẩm (Single, Bundle combo, Gift Set) | [Product.php](file:///d:/Lunara/app/Models/Product.php) |
| **6** | `product_images` | 9 | Catalog & Media | Bộ ảnh đa góc chụp sản phẩm liên kết Cloudinary | [ProductImage.php](file:///d:/Lunara/app/Models/ProductImage.php) |
| **7** | `bundle_items` | 7 | Catalog & Tồn kho | Công thức cấu thành (BOM) combo & set quà tặng | [BundleItem.php](file:///d:/Lunara/app/Models/BundleItem.php) |
| **8** | `addresses` | 11 | Khách hàng | Sổ địa chỉ giao hàng và địa chỉ mặc định | [Address.php](file:///d:/Lunara/app/Models/Address.php) |
| **9** | `carts` | 5 | Giỏ hàng | Giỏ hàng thành viên & khách vãng lai (Session) | [Cart.php](file:///d:/Lunara/app/Models/Cart.php) |
| **10** | `cart_items` | 8 | Giỏ hàng | Chi tiết món hàng trong giỏ & lời chúc thiệp | [CartItem.php](file:///d:/Lunara/app/Models/CartItem.php) |
| **11** | `wishlists` | 5 | Khách hàng | Danh sách sản phẩm yêu thích (Thả tim) | [Wishlist.php](file:///d:/Lunara/app/Models/Wishlist.php) |
| **12** | `orders` | 23 | Quản lý Đơn hàng | Đơn hàng, địa chỉ snapshot, tổng tiền, trạng thái | [Order.php](file:///d:/Lunara/app/Models/Order.php) |
| **13** | `order_items` | 11 | Quản lý Đơn hàng | Bản chụp bất biến sản phẩm tại thời điểm mua | [OrderItem.php](file:///d:/Lunara/app/Models/OrderItem.php) |
| **14** | `order_item_components`| 9 | Quản lý Đơn hàng | Chi tiết linh kiện combo bị trừ kho thực tế | [OrderItemComponent.php](file:///d:/Lunara/app/Models/OrderItemComponent.php) |
| **15** | `order_status_histories`| 7 | Quản lý Đơn hàng | Băng ghi vết kiểm toán (Audit Trail) vòng đời đơn | [OrderStatusHistory.php](file:///d:/Lunara/app/Models/OrderStatusHistory.php) |
| **16** | `payments` | 20 | Cổng thanh toán | Giao dịch thanh toán trực tuyến VNPay Sandbox & COD| [Payment.php](file:///d:/Lunara/app/Models/Payment.php) |
| **17** | `payment_refunds` | 18 | Cổng thanh toán | Yêu cầu và kết quả hoàn tiền qua VNPay API | [PaymentRefund.php](file:///d:/Lunara/app/Models/PaymentRefund.php) |
| **18** | `coupons` | 19 | Khuyến mãi | Kho mã giảm giá với Rule Engine thông minh | [Coupon.php](file:///d:/Lunara/app/Models/Coupon.php) |
| **19** | `coupon_usages` | 9 | Khuyến mãi | Giữ chỗ 2 pha (Held/Used) chống cướp voucher | [CouponUsage.php](file:///d:/Lunara/app/Models/CouponUsage.php) |
| **20** | `reviews` | 16 | Đánh giá & Xếp hạng | Đánh giá sao, nhận xét mua hàng đã xác minh | [Review.php](file:///d:/Lunara/app/Models/Review.php) |
| **21** | `review_media` | 7 | Đánh giá & Xếp hạng | Ảnh thực tế đính kèm của khách hàng (Cloudinary) | [ReviewMedia.php](file:///d:/Lunara/app/Models/ReviewMedia.php) |
| **22** | `contact_messages` | 14 | Hỗ trợ & CSKH | Phiếu hỗ trợ khách hàng, mã tham chiếu SUP | [ContactMessage.php](file:///d:/Lunara/app/Models/ContactMessage.php) |
| **23** | `support_conversations`| 11 | Hỗ trợ & CSKH | Phiên Live Chat giữa khách và chuyên viên tư vấn | [SupportConversation.php](file:///d:/Lunara/app/Models/SupportConversation.php) |
| **24** | `support_messages` | 9 | Hỗ trợ & CSKH | Từng tin nhắn thời gian thực trong phiên Live Chat | [SupportMessage.php](file:///d:/Lunara/app/Models/SupportMessage.php) |
| **25** | `faqs` | 8 | Hỗ trợ & CSKH | Ngân hàng câu hỏi thường gặp theo chủ đề | [Faq.php](file:///d:/Lunara/app/Models/Faq.php) |
| **26** | `email_logs` | 10 | Hỗ trợ & Hệ thống | Nhật ký kiểm toán gửi email tự động (SMTP) | [EmailLog.php](file:///d:/Lunara/app/Models/EmailLog.php) |
| **27** | `banners` | 11 | Marketing & Banner | Slider trang chủ, banner sự kiện khuyến mãi | [Banner.php](file:///d:/Lunara/app/Models/Banner.php) |
| **28** | `posts` | 19 | Blog & Nội dung | Bài viết cẩm nang trang sức, phong thủy bạc | [Post.php](file:///d:/Lunara/app/Models/Post.php) |
| **29** | `post_categories` | 8 | Blog & Nội dung | Chuyên mục phân loại bài viết kiến thức | [PostCategory.php](file:///d:/Lunara/app/Models/PostCategory.php) |
| **30** | `seo_redirects` | 5 | SEO & Điều hướng | Chuyển hướng 301/302 giữ trọn vẹn thứ hạng SEO | [SeoRedirect.php](file:///d:/Lunara/app/Models/SeoRedirect.php) |
| **31** | `settings` | 7 | Cấu hình website | Cấu hình tham số Key-Value toàn trang | [Setting.php](file:///d:/Lunara/app/Models/Setting.php) |
| **32** | `cache` | 3 | Hạ tầng Laravel | Lưu trữ bộ nhớ đệm tăng tốc query CSDL | Framework Driver |
| **33** | `cache_locks` | 3 | Hạ tầng Laravel | Khóa nguyên tử (Atomic Lock) chống race condition| Framework Driver |
| **34** | `jobs` | 7 | Hạ tầng Laravel | Hàng đợi tác vụ ngầm (Queue Jobs) | Framework Driver |
| **35** | `job_batches` | 10 | Hạ tầng Laravel | Quản lý thực thi job song song theo cụm | Framework Driver |
| **36** | `failed_jobs` | 7 | Hạ tầng Laravel | Ghi nhận lỗi khi job chạy nền thất bại | Framework Driver |
| **37** | `migrations` | 3 | Hạ tầng Laravel | Lịch sử thực thi các file migration schema | Framework Driver |

---

## 3. CHI TIẾT 10 PHÂN HỆ DỮ LIỆU & VỊ TRÍ CODE ÁNH XẠ

### Phân hệ 1: Quản trị Người dùng & Xác thực (3 bảng)

#### 1. Bảng `users` (9 cột)
* **Các cột chính:** `id` (PK), `name`, `email` (Unique), `email_verified_at`, `password`, `role` (`customer`, `admin`), `remember_token`, `created_at`, `updated_at`.
* **Mục đích nghiệp vụ:** Quản lý toàn bộ danh tính người dùng trong hệ sinh thái Lunara Silver, phân quyền 2 cấp độ: Khách hàng mua sắm (`customer`) và Quản trị viên (`admin`).
* **Tính năng ứng dụng:** Đăng ký, đăng nhập bảo mật Bcrypt cost 12, phân quyền truy cập trang quản trị Admin, quản lý hồ sơ và đổi mật khẩu.
* **Vị trí code ánh xạ:**
  - **Migration:** [database/migrations/0001_01_01_000000_create_users_table.php](file:///d:/Lunara/database/migrations/0001_01_01_000000_create_users_table.php)
  - **Model:** [app/Models/User.php](file:///d:/Lunara/app/Models/User.php)
  - **Controllers:** [AuthController.php](file:///d:/Lunara/app/Http/Controllers/AuthController.php), [AccountController.php](file:///d:/Lunara/app/Http/Controllers/AccountController.php), [Admin/CustomerController.php](file:///d:/Lunara/app/Http/Controllers/Admin/CustomerController.php)
  - **Services:** [Admin/CustomerInsightsService.php](file:///d:/Lunara/app/Services/Admin/CustomerInsightsService.php)
  - **Blade Views:** `resources/views/auth/login.blade.php`, `resources/views/auth/register.blade.php`, `resources/views/admin/customers/`

#### 2. Bảng `password_reset_tokens` (3 cột)
* **Các cột chính:** `email` (PK), `token`, `created_at`.
* **Mục đích nghiệp vụ:** Lưu trữ mã băm xác thực 1 lần khi người dùng yêu cầu khôi phục mật khẩu qua email.
* **Vị trí code:** [AuthController.php](file:///d:/Lunara/app/Http/Controllers/AuthController.php).

#### 3. Bảng `sessions` (6 cột)
* **Các cột chính:** `id` (PK, varchar 255), `user_id` (FK), `ip_address`, `user_agent`, `payload`, `last_activity`.
* **Mục đích nghiệp vụ:** Quản lý trạng thái phiên làm việc trong database (`SESSION_DRIVER=database`), giúp hệ thống hoạt động ổn định trên môi trường Shared Hosting không có Redis.
* **Vị trí code:** Cấu hình trong [.env](file:///d:/Lunara/.env) (`SESSION_DRIVER=database`) và `config/session.php`.

---

### Phân hệ 2: Danh mục, Sản phẩm, Tồn kho & Combo (4 bảng)

#### 4. Bảng `categories` (12 cột)
* **Các cột chính:** `id` (PK), `parent_id` (FK tự trỏ), `name`, `slug` (Unique), `description`, `seo_title`, `seo_description`, `seo_intro`, `sort_order`, `is_active`, `created_at`, `updated_at`.
* **Mục đích nghiệp vụ:** Quản lý danh mục sản phẩm theo cấu trúc cây (Dây chuyền, Nhẫn, Vòng tay, Bộ trang sức, Set quà tặng) cùng trường SEO chuyên biệt.
* **Tính năng ứng dụng:** Mega Menu 2 cấp, phân trang danh mục, lọc theo phân loại, sinh thẻ meta SEO Canonical.
* **Vị trí code ánh xạ:**
  - **Migration:** [database/migrations/2026_09_20_000001_create_catalog_tables.php](file:///d:/Lunara/database/migrations/2026_09_20_000001_create_catalog_tables.php)
  - **Model:** [app/Models/Category.php](file:///d:/Lunara/app/Models/Category.php)
  - **Controllers:** [ProductController.php](file:///d:/Lunara/app/Http/Controllers/ProductController.php), [Admin/CategoryController.php](file:///d:/Lunara/app/Http/Controllers/Admin/CategoryController.php)
  - **Services:** [NavigationService.php](file:///d:/Lunara/app/Services/NavigationService.php), [SeoService.php](file:///d:/Lunara/app/Services/SeoService.php)
  - **Blade Views:** `resources/views/products/index.blade.php`, `resources/views/components/mega-menu.blade.php`, `resources/views/admin/categories/`

#### 5. Bảng `products` (25 cột)
* **Các cột chính:** `id` (PK), `category_id` (FK), `sku` (Unique), `name`, `slug` (Unique), `product_type` (`single`, `bundle`, `gift_set`), `price`, `sale_price`, `stock_quantity`, `material`, `gender`, `is_active`, `is_featured`, `view_count`, `average_rating`, `review_count`, `seo_title`, `seo_description`.
* **Mục đích nghiệp vụ:** Lưu trữ thông tin 45 sản phẩm thực tế, quản lý giá bán, giá sale, thuộc tính trang sức bạc 925 và số lượng tồn kho vật lý.
* **Tính năng ứng dụng:** Xem chi tiết sản phẩm, lọc theo giá/chất liệu, tìm kiếm từ khóa, tính toán tồn kho khả dụng (`calculateAvailableStock()`).
* **Vị trí code ánh xạ:**
  - **Migration:** [database/migrations/2026_09_20_000001_create_catalog_tables.php](file:///d:/Lunara/database/migrations/2026_09_20_000001_create_catalog_tables.php)
  - **Model:** [app/Models/Product.php](file:///d:/Lunara/app/Models/Product.php)
  - **Controllers:** [ProductController.php](file:///d:/Lunara/app/Http/Controllers/ProductController.php), [Admin/ProductController.php](file:///d:/Lunara/app/Http/Controllers/Admin/ProductController.php)
  - **Services:** [ProductService.php](file:///d:/Lunara/app/Services/ProductService.php), [OrderInventoryService.php](file:///d:/Lunara/app/Services/OrderInventoryService.php)
  - **Blade Views:** `resources/views/products/index.blade.php`, `resources/views/products/show.blade.php`, `resources/views/admin/products/`

#### 6. Bảng `product_images` (9 cột)
* **Các cột chính:** `id` (PK), `product_id` (FK), `cloudinary_public_id`, `image_url`, `image_role` (`primary`, `gallery`, `thumbnail`), `sort_order`, `alt_text`.
* **Mục đích nghiệp vụ:** Quản lý thư viện ảnh đa góc chụp của trang sức liên kết CDN đám mây Cloudinary.
* **Vị trí code ánh xạ:**
  - **Model:** [app/Models/ProductImage.php](file:///d:/Lunara/app/Models/ProductImage.php)
  - **Services:** [CloudinaryService.php](file:///d:/Lunara/app/Services/CloudinaryService.php)
  - **Blade Views:** Thumbnail carousel tại [resources/views/products/show.blade.php](file:///d:/Lunara/resources/views/products/show.blade.php).

#### 7. Bảng `bundle_items` (7 cột)
* **Các cột chính:** `id` (PK), `bundle_product_id` (FK trỏ tới sản phẩm cha), `component_product_id` (FK trỏ tới sản phẩm con), `quantity`, `sort_order`.
* **Mục đích nghiệp vụ:** Định nghĩa công thức cấu thành cho sản phẩm Combo/Gift Set.
* **Tính năng ứng dụng:** Giải thuật tính tồn kho ảo động: Tồn kho combo bằng số lượng nhỏ nhất của các linh kiện đơn lẻ thành phần chia cho định mức yêu cầu.
* **Vị trí code ánh xạ:**
  - **Model:** [app/Models/BundleItem.php](file:///d:/Lunara/app/Models/BundleItem.php)
  - **Services:** [OrderInventoryService.php](file:///d:/Lunara/app/Services/OrderInventoryService.php)
  - **Blade Views:** Hiển thị danh mục linh kiện trong set tại `products/show.blade.php`.

---

### Phân hệ 3: Khách hàng, Giỏ hàng & Yêu thích (4 bảng)

#### 8. Bảng `addresses` (11 cột)
* **Các cột chính:** `id` (PK), `user_id` (FK), `recipient_name`, `phone`, `address_line`, `ward`, `district`, `city`, `is_default`.
* **Mục đích nghiệp vụ:** Lưu trữ sổ địa chỉ giao nhận của khách hàng; cho phép đặt một địa chỉ mặc định để tự động điền khi thanh toán.
* **Vị trí code:** [app/Models/Address.php](file:///d:/Lunara/app/Models/Address.php), [AccountController.php](file:///d:/Lunara/app/Http/Controllers/AccountController.php), [CheckoutController.php](file:///d:/Lunara/app/Http/Controllers/CheckoutController.php).

#### 9. Bảng `carts` (5 cột)
* **Các cột chính:** `id` (PK), `user_id` (FK, nullable), `session_id` (varchar 100, nullable), `created_at`, `updated_at`.
* **Mục đích nghiệp vụ:** Quản lý giỏ hàng cho cả khách vãng lai (Guest) và người dùng đăng nhập; tự động kích hoạt logic gộp giỏ hàng (Cart Merge) khi đăng nhập.
* **Vị trí code:** [app/Models/Cart.php](file:///d:/Lunara/app/Models/Cart.php), [CartService.php](file:///d:/Lunara/app/Services/CartService.php).

#### 10. Bảng `cart_items` (8 cột)
* **Các cột chính:** `id` (PK), `cart_id` (FK), `product_id` (FK), `quantity`, `unit_price`, `gift_message` (varchar 500).
* **Mục đích nghiệp vụ:** Lưu chi tiết từng món đồ trong giỏ hàng và thông điệp lời chúc đính kèm (Gift Message).
* **Vị trí code:** [app/Models/CartItem.php](file:///d:/Lunara/app/Models/CartItem.php), [CartController.php](file:///d:/Lunara/app/Http/Controllers/CartController.php), [CartService.php](file:///d:/Lunara/app/Services/CartService.php).

#### 11. Bảng `wishlists` (5 cột)
* **Các cột chính:** `id` (PK), `user_id` (FK), `product_id` (FK), `created_at`, `updated_at`.
* **Mục đích nghiệp vụ:** Danh sách sản phẩm mong muốn (Thả tim) của khách hàng thành viên.
* **Vị trí code:** [app/Models/Wishlist.php](file:///d:/Lunara/app/Models/Wishlist.php), [WishlistService.php](file:///d:/Lunara/app/Services/WishlistService.php).

---

### Phân hệ 4: Đơn hàng & Quản lý Quy trình Xử lý (4 bảng)

#### 12. Bảng `orders` (23 cột)
* **Các cột chính:** `id` (PK), `user_id` (FK, nullable), `order_code` (Unique), `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `shipping_city`, `subtotal`, `shipping_fee`, `discount_amount`, `grand_total`, `payment_method` (`cod`, `vnpay`), `payment_status` (`pending`, `paid`, `failed`, `refunded`), `order_status` (`pending`, `confirmed`, `processing`, `shipping`, `completed`, `cancelled`), `coupon_code`, `admin_notes`, `cancelled_at`, `completed_at`.
* **Mục đích nghiệp vụ:** Bảng trung tâm quản lý đơn đặt hàng với mã giao dịch độc nhất (`order_code`), quản lý số tiền thanh toán, địa chỉ nhận hàng và quy trình chuyển đổi trạng thái đơn.
* **Vị trí code ánh xạ:**
  - **Migration:** [database/migrations/2026_09_20_000003_create_order_tables.php](file:///d:/Lunara/database/migrations/2026_09_20_000003_create_order_tables.php)
  - **Model:** [app/Models/Order.php](file:///d:/Lunara/app/Models/Order.php)
  - **Controllers:** [CheckoutController.php](file:///d:/Lunara/app/Http/Controllers/CheckoutController.php), [OrderTrackingController.php](file:///d:/Lunara/app/Http/Controllers/OrderTrackingController.php), [Admin/OrderController.php](file:///d:/Lunara/app/Http/Controllers/Admin/OrderController.php)
  - **Services:** [CheckoutService.php](file:///d:/Lunara/app/Services/CheckoutService.php), [OrderStatusService.php](file:///d:/Lunara/app/Services/OrderStatusService.php), [Admin/AnalyticsService.php](file:///d:/Lunara/app/Services/Admin/AnalyticsService.php)
  - **Blade Views:** `resources/views/checkout/success.blade.php`, `resources/views/orders/tracking.blade.php`, `resources/views/admin/orders/`

#### 13. Bảng `order_items` (11 cột)
* **Các cột chính:** `id` (PK), `order_id` (FK), `product_id` (FK), `product_name`, `product_sku`, `unit_price`, `quantity`, `subtotal`, `gift_message`.
* **Mục đích nghiệp vụ:** Lưu **Bản chụp Bất biến (Immutable Snapshot)** của sản phẩm tại thời điểm mua. Ngay cả khi sản phẩm gốc đổi tên hay đổi giá, bản ghi trong bảng này vẫn bảo toàn nguyên vẹn phục vụ kế toán và đối soát.
* **Vị trí code:** [app/Models/OrderItem.php](file:///d:/Lunara/app/Models/OrderItem.php), [CheckoutService.php](file:///d:/Lunara/app/Services/CheckoutService.php).

#### 14. Bảng `order_item_components` (9 cột)
* **Các cột chính:** `id` (PK), `order_item_id` (FK), `product_id` (FK), `product_sku`, `product_name`, `quantity_per_item`, `total_quantity`.
* **Mục đích nghiệp vụ:** Ghi nhận danh sách bóc tách linh kiện của sản phẩm Combo/Set Quà Tặng được trừ kho thực tế. Giúp hệ thống hoàn lại chính xác từng món đơn lẻ khi đơn hàng bị hủy (`restockOrder()`).
* **Vị trí code:** [app/Models/OrderItemComponent.php](file:///d:/Lunara/app/Models/OrderItemComponent.php), [OrderInventoryService.php](file:///d:/Lunara/app/Services/OrderInventoryService.php).

#### 15. Bảng `order_status_histories` (7 cột)
* **Các cột chính:** `id` (PK), `order_id` (FK), `from_status`, `to_status`, `changed_by` (FK trỏ tới `users`), `note`, `created_at`.
* **Mục đích nghiệp vụ:** Băng ghi kiểm toán (Audit Trail) lịch sử thay đổi trạng thái đơn hàng theo máy trạng thái tuần tự; ngăn ngừa việc nhảy cóc trạng thái phi logic.
* **Vị trí code:** [app/Models/OrderStatusHistory.php](file:///d:/Lunara/app/Models/OrderStatusHistory.php), [OrderStatusService.php](file:///d:/Lunara/app/Services/OrderStatusService.php).

---

### Phân hệ 5: Thanh toán & Hoàn tiền VNPay (2 bảng)

#### 16. Bảng `payments` (20 cột)
* **Các cột chính:** `id` (PK), `order_id` (FK), `provider` (`vnpay`, `cod`), `transaction_id`, `txn_ref`, `amount`, `vnp_transaction_no`, `vnp_bank_code`, `vnp_card_type`, `vnp_response_code`, `vnp_transaction_status`, `status` (`pending`, `paid`, `failed`, `refunded`), `paid_at`.
* **Mục đích nghiệp vụ:** Quản lý giao dịch cổng thanh toán VNPay Sandbox; lưu trữ toàn bộ tham số kỹ thuật để đối soát đối chiếu qua cơ chế IPN Webhook và Return Callback.
* **Vị trí code ánh xạ:**
  - **Model:** [app/Models/Payment.php](file:///d:/Lunara/app/Models/Payment.php)
  - **Controllers:** [VNPayController.php](file:///d:/Lunara/app/Http/Controllers/VNPayController.php)
  - **Services:** [VNPay/VNPayService.php](file:///d:/Lunara/app/Services/VNPay/VNPayService.php)
  - **Blade Views:** `resources/views/payment/vnpay_return.blade.php`.

#### 17. Bảng `payment_refunds` (18 cột)
* **Các cột chính:** `id` (PK), `payment_id` (FK), `order_id` (FK), `request_id`, `refund_type` (`02` toàn phần, `03` một phần), `amount`, `status` (`requested`, `success`, `rejected`), `vnp_response_code`, `reason`, `processed_by`.
* **Mục đích nghiệp vụ:** Quản lý quy trình hoàn tiền tự động qua API Hoàn tiền VNPay (`refundTransaction`).
* **Vị trí code:** [app/Models/PaymentRefund.php](file:///d:/Lunara/app/Models/PaymentRefund.php), [Admin/RefundController.php](file:///d:/Lunara/app/Http/Controllers/Admin/RefundController.php), [VNPay/VNPayService.php](file:///d:/Lunara/app/Services/VNPay/VNPayService.php).

---

### Phân hệ 6: Khuyến mãi & Mã giảm giá (2 bảng)

#### 18. Bảng `coupons` (19 cột)
* **Các cột chính:** `id` (PK), `code` (Unique), `type` (`percent`, `fixed`), `value`, `minimum_order`, `maximum_discount`, `starts_at`, `expires_at`, `usage_limit`, `usage_limit_per_user`, `times_used`, `is_active`, `category_ids` (JSON), `product_ids` (JSON).
* **Mục đích nghiệp vụ:** Lưu trữ kho voucher khuyến mãi với bộ quy tắc Rule Engine nâng cao: giảm theo %, giảm cố định, chặn giá trị giảm tối đa, yêu cầu giá trị đơn tối thiểu, giới hạn theo danh mục/sản phẩm cụ thể.
* **Vị trí code ánh xạ:**
  - **Model:** [app/Models/Coupon.php](file:///d:/Lunara/app/Models/Coupon.php)
  - **Controllers:** [Admin/CouponController.php](file:///d:/Lunara/app/Http/Controllers/Admin/CouponController.php)
  - **Services:** [CouponService.php](file:///d:/Lunara/app/Services/CouponService.php)
  - **Blade Views:** `resources/views/cart/index.blade.php`, `resources/views/admin/coupons/`

#### 19. Bảng `coupon_usages` (9 cột)
* **Các cột chính:** `id` (PK), `coupon_id` (FK), `user_id` (FK), `order_id` (FK), `status` (`held`, `used`, `released`), `used_at`, `released_at`.
* **Mục đích nghiệp vụ:** Triển khai cơ chế Giữ chỗ Voucher 2 pha (Two-phase Reservation): Khi khách bắt đầu Checkout thì giữ chỗ (`held`), khi đặt hàng thành công thì chốt (`used`), nếu khách hủy thì tự động nhả mã (`released`) để tránh cướp mã (Race Condition).
* **Vị trí code:** [app/Models/CouponUsage.php](file:///d:/Lunara/app/Models/CouponUsage.php), [CouponService.php](file:///d:/Lunara/app/Services/CouponService.php).

---

### Phân hệ 7: Đánh giá & Phản hồi Khách hàng (2 bảng)

#### 20. Bảng `reviews` (16 cột)
* **Các cột chính:** `id` (PK), `user_id` (FK), `product_id` (FK), `order_item_id` (FK), `rating` (tinyint 1-5), `title`, `content`, `is_verified_purchase` (boolean), `status` (`pending`, `approved`, `rejected`), `admin_reply`, `helpful_count`.
* **Mục đích nghiệp vụ:** Quản lý đánh giá sao và nhận xét từ khách hàng; tự động đánh dấu huy hiệu Người mua đã xác minh (`is_verified_purchase`) nếu khách đã từng mua sản phẩm trong đơn hoàn thành.
* **Vị trí code ánh xạ:**
  - **Model:** [app/Models/Review.php](file:///d:/Lunara/app/Models/Review.php)
  - **Controllers:** [ReviewController.php](file:///d:/Lunara/app/Http/Controllers/ReviewController.php), [Admin/ReviewController.php](file:///d:/Lunara/app/Http/Controllers/Admin/ReviewController.php)
  - **Services:** [ReviewService.php](file:///d:/Lunara/app/Services/ReviewService.php)
  - **Blade Views:** `resources/views/products/_reviews_section.blade.php`, `resources/views/admin/reviews/`

#### 21. Bảng `review_media` (7 cột)
* **Các cột chính:** `id` (PK), `review_id` (FK), `public_id`, `image_url`, `sort_order`.
* **Mục đích nghiệp vụ:** Lưu trữ hình ảnh thực tế do khách hàng chụp và tải lên khi đánh giá sản phẩm (lưu trên Cloudinary).
* **Vị trí code:** [app/Models/ReviewMedia.php](file:///d:/Lunara/app/Models/ReviewMedia.php), [ReviewService.php](file:///d:/Lunara/app/Services/ReviewService.php).

---

### Phân hệ 8: Chăm sóc Khách hàng, Liên hệ & Hỗ trợ (5 bảng)

#### 22. Bảng `contact_messages` (14 cột)
* **Các cột chính:** `id` (PK), `reference` (Unique, ví dụ `SUP-20261015-XYZ`), `user_id` (FK, nullable), `order_id` (FK, nullable), `name`, `email`, `phone`, `subject`, `message`, `status` (`new`, `in_progress`, `resolved`, `closed`), `assigned_to` (FK), `internal_notes`.
* **Mục đích nghiệp vụ:** Tiếp nhận và quản lý các yêu cầu liên hệ, khiếu nại, tư vấn kích cỡ nhẫn hoặc hỗ trợ đơn hàng.
* **Vị trí code ánh xạ:**
  - **Model:** [app/Models/ContactMessage.php](file:///d:/Lunara/app/Models/ContactMessage.php)
  - **Controllers:** [SupportController.php](file:///d:/Lunara/app/Http/Controllers/SupportController.php), [Admin/SupportController.php](file:///d:/Lunara/app/Http/Controllers/Admin/SupportController.php)
  - **Services:** [SupportEmailService.php](file:///d:/Lunara/app/Services/SupportEmailService.php)
  - **Blade Views:** `resources/views/support/contact.blade.php`, `resources/views/admin/support/index.blade.php`, `resources/views/admin/support/show.blade.php`

#### 23. Bảng `support_conversations` (11 cột)
* **Các cột chính:** `id` (PK), `reference` (Unique), `user_id` (FK, nullable), `guest_token` (varchar 64, nullable), `customer_name`, `customer_email`, `status` (`open`, `assigned`, `closed`), `assigned_to` (FK), `last_message_at`.
* **Mục đích nghiệp vụ:** Quản lý phiên hội thoại Live Support (Chat trực tuyến) hỗ trợ cả khách thành viên và khách vãng lai qua token.
* **Vị trí code:** [app/Models/SupportConversation.php](file:///d:/Lunara/app/Models/SupportConversation.php), [SupportController.php](file:///d:/Lunara/app/Http/Controllers/SupportController.php).

#### 24. Bảng `support_messages` (9 cột)
* **Các cột chính:** `id` (PK), `conversation_id` (FK), `sender_type` (`customer`, `admin`), `sender_id`, `sender_name`, `message`, `read_at`.
* **Mục đích nghiệp vụ:** Lưu từng dòng tin nhắn thời gian thực trong phiên Live Chat.
* **Vị trí code:** [app/Models/SupportMessage.php](file:///d:/Lunara/app/Models/SupportMessage.php).

#### 25. Bảng `faqs` (8 cột)
* **Các cột chính:** `id` (PK), `category` (`shipping`, `payment`, `product`, `warranty`, `return`), `question`, `answer`, `sort_order`, `is_active`.
* **Mục đích nghiệp vụ:** Lưu trữ ngân hàng câu hỏi thường gặp tại Trung tâm trợ giúp khách hàng.
* **Vị trí code:** [app/Models/Faq.php](file:///d:/Lunara/app/Models/Faq.php), [SupportController.php](file:///d:/Lunara/app/Http/Controllers/SupportController.php), [Admin/FaqController.php](file:///d:/Lunara/app/Http/Controllers/Admin/FaqController.php).

#### 26. Bảng `email_logs` (10 cột)
* **Các cột chính:** `id` (PK), `type` (`contact_received`, `admin_new_request`, `support_reply`, `support_resolved`), `recipient`, `related_type` (Mô hình đa hình Polymorphic), `related_id`, `status` (`sent`, `failed`), `error_message`, `sent_at`.
* **Mục đích nghiệp vụ:** Băng ghi kiểm toán toàn bộ email gửi tự động qua SMTP; hỗ trợ hiển thị lịch sử gửi email trực tiếp trên trang chi tiết ticket trong Admin.
* **Vị trí code:** [app/Models/EmailLog.php](file:///d:/Lunara/app/Models/EmailLog.php), [SupportEmailService.php](file:///d:/Lunara/app/Services/SupportEmailService.php), [admin/support/show.blade.php](file:///d:/Lunara/resources/views/admin/support/show.blade.php).

---

### Phân hệ 9: Nội dung, Blog & Marketing (4 bảng)

#### 27. Bảng `banners` (11 cột)
* **Các cột chính:** `id` (PK), `title`, `subtitle`, `image_url`, `cloudinary_public_id`, `button_text`, `link`, `sort_order`, `is_active`.
* **Mục đích nghiệp vụ:** Quản lý các banner trình chiếu Hero Slider tại trang chủ Lunara Silver.
* **Vị trí code:** [app/Models/Banner.php](file:///d:/Lunara/app/Models/Banner.php), [BannerService.php](file:///d:/Lunara/app/Services/BannerService.php), `resources/views/components/hero-slider.blade.php`.

#### 28. Bảng `posts` (19 cột)
* **Các cột chính:** `id` (PK), `post_category_id` (FK), `author_id` (FK), `title`, `slug` (Unique), `excerpt`, `content`, `image_url`, `cover_image_url`, `is_published`, `published_at`, `view_count`, `seo_title`, `seo_description`.
* **Mục đích nghiệp vụ:** Quản lý bài viết cẩm nang kiến thức trang sức, bảo quản bạc, phong thủy và câu chuyện nghệ nhân chế tác.
* **Vị trí code:** [app/Models/Post.php](file:///d:/Lunara/app/Models/Post.php), [BlogController.php](file:///d:/Lunara/app/Http/Controllers/BlogController.php), [Admin/PostController.php](file:///d:/Lunara/app/Http/Controllers/Admin/PostController.php).

#### 29. Bảng `post_categories` (8 cột)
* **Các cột chính:** `id` (PK), `name`, `slug` (Unique), `description`, `sort_order`, `is_active`.
* **Mục đích nghiệp vụ:** Phân loại các nhóm bài viết (Kiến thức trang sức, Phong thủy bạc, Tin tức thương hiệu).
* **Vị trí code:** [app/Models/PostCategory.php](file:///d:/Lunara/app/Models/PostCategory.php), [BlogController.php](file:///d:/Lunara/app/Http/Controllers/BlogController.php).

#### 30. Bảng `seo_redirects` (5 cột)
* **Các cột chính:** `id` (PK), `old_path`, `new_path`, `status_code` (`301`, `302`), `created_at`.
* **Mục đích nghiệp vụ:** Quản lý chuyển hướng đường dẫn tự động; chặn lỗi 404 và bảo toàn giá trị SEO PageRank khi đổi slug bài viết hoặc sản phẩm.
* **Vị trí code:** [app/Models/SeoRedirect.php](file:///d:/Lunara/app/Models/SeoRedirect.php), [app/Http/Middleware/SeoRedirectMiddleware.php](file:///d:/Lunara/app/Http/Middleware/SeoRedirectMiddleware.php).

---

### Phân hệ 10: Cấu hình Hệ thống & Hạ tầng Framework (7 bảng)

#### 31. Bảng `settings` (7 cột)
* **Các cột chính:** `id` (PK), `key` (Unique), `value`, `type`, `group`, `created_at`, `updated_at`.
* **Mục đích nghiệp vụ:** Lưu trữ các biến cấu hình động toàn trang (Hotline, email hỗ trợ, dòng thông báo khuyến mãi đầu trang `LUNARA_ANNOUNCEMENT`).
* **Vị trí code:** [app/Models/Setting.php](file:///d:/Lunara/app/Models/Setting.php), [Admin/SettingController.php](file:///d:/Lunara/app/Http/Controllers/Admin/SettingController.php).

#### 32. Bảng `cache` (3 cột)
* **Các cột chính:** `key` (PK), `value`, `expiration`.
* **Mục đích nghiệp vụ:** Lưu trữ bộ nhớ đệm tăng tốc query danh mục và cấu hình khi chạy `CACHE_STORE=database`.

#### 33. Bảng `cache_locks` (3 cột)
* **Các cột chính:** `key` (PK), `owner`, `expiration`.
* **Mục đích nghiệp vụ:** Khóa tài nguyên nguyên tử (Atomic Lock) chống race condition trong các tác vụ thanh toán đồng thời.

#### 34. Bảng `jobs` (7 cột)
* **Các cột chính:** `id` (PK), `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`.
* **Mục đích nghiệp vụ:** Hàng đợi xử lý công việc ngầm (Background Jobs) khi chạy chế độ `QUEUE_CONNECTION=database`.

#### 35. Bảng `job_batches` (10 cột)
* **Các cột chính:** `id` (PK), `name`, `total_jobs`, `pending_jobs`, `failed_jobs`, `failed_job_ids`, `options`, `cancelled_at`, `created_at`, `finished_at`.
* **Mục đích nghiệp vụ:** Quản lý các đợt thực thi job theo cụm lô của Laravel.

#### 36. Bảng `failed_jobs` (7 cột)
* **Các cột chính:** `id` (PK), `uuid` (Unique), `connection`, `queue`, `payload`, `exception`, `failed_at`.
* **Mục đích nghiệp vụ:** Ghi vết chi tiết nguyên nhân và stack trace của các hàng đợi bị lỗi để phục vụ debug.

#### 37. Bảng `migrations` (3 cột)
* **Các cột chính:** `id` (PK), `migration`, `batch`.
* **Mục đích nghiệp vụ:** Theo dõi các file migration schema đã được thực thi vào cơ sở dữ liệu.

---

## 4. 5 GIẢI THUẬT DỮ LIỆU ĐỘC QUYỀN CẦN NHẤN MẠNH KHI BÁO CÁO

Khi thuyết trình đồ án trước Hội đồng chấm thi, sinh viên nên nhấn mạnh **5 điểm sáng tạo kiến trúc dữ liệu độc quyền** đã giải quyết triệt để các bài toán khó của thương mại điện tử thực tế:

### 1. Bản Chụp Bất Biến (Immutable Snapshot Pattern)
* **Bảng áp dụng:** `order_items`
* **Vấn đề giải quyết:** Nếu lưu đơn hàng bằng cách trỏ Foreign Key trực tiếp vào bảng `products`, khi người quản trị đổi tên, đổi giá hoặc xóa sản phẩm trong tương lai, toàn bộ lịch sử đơn hàng cũ và báo cáo tài chính sẽ bị sai lệch.
* **Giải pháp Lunara Silver:** Bảng `order_items` lưu cứng bản chụp (`product_name`, `product_sku`, `unit_price`, `subtotal`) độc lập hoàn toàn với bảng `products`.

### 2. Tồn Kho Ảo Động Cho Combo & Set Quà (Dynamic Virtual Inventory)
* **Bảng áp dụng:** `products`, `bundle_items`, `order_item_components`
* **Vấn đề giải quyết:** Bán Set Quà Tặng (gồm dây chuyền + nhẫn + hộp quà). Nếu cộng dồn tồn kho cố định sẽ gây bán vượt mức (Overselling) khi linh kiện đơn lẻ đã bị khách khác mua hết.
* **Giải pháp Lunara Silver:** Tồn kho combo được tính động bằng thuật toán:
  $$\text{Tồn kho Combo} = \min_{i \in \text{Components}} \left\lfloor \frac{\text{Stock}_i}{\text{Quantity}_i} \right\rfloor$$
  Khi khách chốt đơn, bảng `order_item_components` ghi vết trừ trực tiếp vào tồn kho vật lý của từng linh kiện đơn lẻ.

### 3. Giữ Chỗ Voucher 2 Pha (Two-Phase Coupon Reservation)
* **Bảng áp dụng:** `coupons`, `coupon_usages`
* **Vấn đề giải quyết:** Chống cướp voucher (Race Condition) và chống mất voucher khi thanh toán VNPay thất bại.
* **Giải pháp Lunara Silver:** Giai đoạn 1 (Checkout): Ghi bản ghi `coupon_usages` với trạng thái `held` và khóa tạm thời. Giai đoạn 2 (Thanh toán thành công): Chuyển thành `used`. Nếu khách hủy hoặc giao dịch hết hạn: Kích hoạt nhả mã `released`.

### 4. Băng Ghi Kiểm Toán Vòng Đời Đơn Hàng (State Machine Audit Trail)
* **Bảng áp dụng:** `orders`, `order_status_histories`
* **Vấn đề giải quyết:** Đảm bảo toàn vẹn quy trình vận hành và chống tranh chấp pháp lý/đối soát khiếu nại.
* **Giải pháp Lunara Silver:** Mọi bước chuyển trạng thái (Pending -> Confirmed -> Processing -> Shipping -> Completed) bắt buộc phải đi qua máy trạng thái và tự động tạo 1 bản ghi lịch sử có đối tượng thực hiện (`changed_by`) và lý do.

### 5. Ghi Log Email Đa Hình (Polymorphic Email Delivery Audit)
* **Bảng áp dụng:** `email_logs`, `contact_messages`
* **Vấn đề giải quyết:** Minh bạch hóa trạng thái gửi nhận thư điện tử tự động trên máy chủ Shared Hosting.
* **Giải pháp Lunara Silver:** Bảng `email_logs` sử dụng quan hệ đa hình `related_type` và `related_id` để kết nối linh hoạt với bất kỳ thực thể nào (`ContactMessage`, `Order`), lưu mã lỗi SMTP chi tiết và hiển thị ngay trên giao diện quản trị Admin.

---

<p align="center">
  <strong>LUNARA SILVER — KIẾN TRÚC DỮ LIỆU CHUẨN MỰC & VẬN HÀNH BỀN VỮNG</strong><br>
  Tài liệu chuẩn hóa phục vụ báo cáo Đồ án tốt nghiệp Công nghệ thông tin / Kỹ thuật phần mềm.
</p>
