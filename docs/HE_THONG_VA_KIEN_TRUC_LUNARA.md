# 📘 TÀI LIỆU TOÀN DIỆN VỀ KIẾN TRÚC, NGHIỆP VỤ & TỰ ĐỘNG HÓA VẬN HÀNH
## DỰ ÁN THƯƠNG MẠI ĐIỆN TỬ TRANG SỨC BẠC CAO CẤP — LUNARA SILVER

> **Tài liệu này được biên soạn cho các nhà phát triển, sinh viên và chuyên gia đánh giá hệ thống nhằm nắm bắt toàn bộ tư duy thiết kế, nghiệp vụ chuyên sâu, kiến trúc mã nguồn và các giải pháp tự động hóa triển khai độc đáo của dự án.**

---

## MỤC LỤC

1. [TỔNG QUAN HỆ THỐNG & ĐỊNH HƯỚNG THƯƠNG HIỆU](#1-tổng-quan-hệ-thống--định-hướng-thương-hiệu)
2. [KIẾN TRÚC DỮ LIỆU & BẢN CHỤP BẤT BIẾN (IMMUTABLE SNAPSHOT)](#2-kiến-trúc-dữ-liệu--bản-chụp-bất-biến-immutable-snapshot)
3. [MÔ HÌNH TỒN KHO ẢO ĐỘC QUYỀN (DYNAMIC VIRTUAL INVENTORY)](#3-mô-hình-tồn-kho-ảo-độc-quyền-dynamic-virtual-inventory)
4. [TÍCH HỢP CỔNG THANH TOÁN VNPAY SANDBOX V2 TOÀN DIỆN](#4-tích-hợp-cổng-thanh-toán-vnpay-sandbox-v2-toàn-diện)
5. [HỆ THỐNG QUẢN TRỊ ẢNH ĐÁM MÂY CLOUDINARY](#5-hệ-thống-quản-trị-ảnh-đám-mây-cloudinary)
6. [KIẾN TRÚC MÃ NGUỒN & CÁC PATTERN NÂNG CAO (SERVICE LAYER)](#6-kiến-trúc-mã-nguồn--các-pattern-nâng-cao-service-layer)
7. [BỘ CÔNG CỤ TỰ ĐỘNG HÓA TRIỂN KHAI & CHẨN ĐOÁN KHÔNG CẦN SSH](#7-bộ-công-cụ-tự-động-hóa-triển-khai--chẩn-đoán-không-cần-ssh)
8. [CHIẾN LƯỢC KIỂM THỬ TỰ ĐỘNG (AUTOMATED TESTING STRATEGY)](#8-chiến-lược-kiểm-thử-tự-động-automated-testing-strategy)

---

## 1. TỔNG QUAN HỆ THỐNG & ĐỊNH HƯỚNG THƯƠNG HIỆU

### 1.1 Bối Cảnh Nghiệp Vụ
**Lunara Silver** là nền tảng e-commerce chuyên biệt dành cho thương hiệu trang sức bạc cao cấp. Danh mục sản phẩm được chuẩn hóa từ dữ liệu thực tế gồm 45 sản phẩm:
- **30 sản phẩm bán lẻ đơn chiếc (`single`)**: 10 dây chuyền (`LNS-DCxxx`), 10 nhẫn (`LNS-NHxxx`), 10 vòng tay (`LNS-VTxxx`).
- **10 bộ sưu tập / Set (`collection`)**: Combo phối hợp nhiều sản phẩm đơn lẻ (`LNS-SETxxx`).
- **5 set quà tặng cao cấp (`gift`)**: Hộp quà kết hợp trang sức và phụ kiện cao cấp (`LNS-QTxxx`).

### 1.2 Triết Lý Thiết Kế: Celestial Luxury Minimalism
Hệ thống giao diện được thiết kế theo chủ nghĩa tối giản sang trọng với cảm hứng ánh trăng:
- **Midnight (`#1A1C2C`)**: Đại diện cho bầu trời đêm huyền bí, dùng cho Header, Hero slider, Footer và các nút tương tác chính.
- **Silver (`#C0C0C0`) & Mauve (`#B8A7B7`)**: Tạo điểm nhấn lấp lánh của kim loại bạc và ánh sắc đá quý.
- **Ivory (`#F7F5F2`) & Cream (`#E6E2DD`)**: Tạo không gian nền ấm áp, thanh lịch, giúp hình ảnh sản phẩm nổi bật tối đa.
- **Hệ thống Font chữ**: Tiêu đề sử dụng font serif cổ điển thanh mảnh (*Playfair Display / Cormorant Garamond*), nội dung sử dụng font sans-serif hiện đại (*Inter / Manrope*).

---

## 2. KIẾN TRÚC DỮ LIỆU & BẢN CHỤP BẤT BIẾN (IMMUTABLE SNAPSHOT)

### 2.1 Sơ Đồ Thực Thể Quan Hệ (Entity Relationship Overview)

```text
+-------------------+         +-------------------+         +------------------------+
|    categories     | 1     n |     products      | 1     n |      bundle_items      |
|-------------------|---------|-------------------|---------|------------------------|
| id, name, slug    |         | id, sku, name,    |         | bundle_id (FK:product) |
+-------------------+         | product_type,     |         | component_id (FK)      |
                              | regular_price,    |         | quantity               |
                              | sale_price, stock |         +------------------------+
                              +---------+---------+
                                        | 1
                                        | n
                              +---------+---------+
                              |  product_images   |
                              |-------------------|
                              | id, product_id,   |
                              | image_url, role,  |
                              | public_id, sort   |
                              +-------------------+

+-------------------+ 1     n +-------------------+ 1     n +------------------------+
|       users       |---------|      orders       |---------|      order_items       |
|-------------------|         |-------------------|         |------------------------|
| id, name, email,  |         | id, order_code,   |         | id, order_id,          |
| password, role    |         | user_id, status,  |         | product_id (nullable), |
+-------------------+         | total_amount,     |         | snapshot_name,         |
                              | shipping_snapshot |         | snapshot_sku, price    |
                              +---------+---------+         +-----------+------------+
                                        | 1                                 | 1
                                        | n                                 | n
                              +---------+---------+         +-----------+------------+
                              |     payments      |         | order_item_components  |
                              |-------------------|         |------------------------|
                              | id, order_id,     |         | item_id, component_id, |
                              | method, status,   |         | component_sku, qty     |
                              | txn_ref, amount   |         +------------------------+
                              +-------------------+
```

### 2.2 Nguyên Tắc Bản Chụp Bất Biến (Immutable Snapshot Principle)
Trong các đồ án hoặc hệ thống nghiệp dư, khi lưu đơn hàng, lập trình viên thường chỉ lưu `product_id` và `address_id` dưới dạng Foreign Key liên kết động. Khi người dùng thay đổi địa chỉ hoặc Admin sửa giá/xóa sản phẩm, lịch sử các đơn hàng cũ sẽ bị biến dạng hoặc gây crash hệ thống!

**Giải pháp của Lunara Silver**:
1. **Shipping Address Snapshot**: Khi đặt hàng, toàn bộ họ tên, số điện thoại, địa chỉ chi tiết, tỉnh/thành được serialize và lưu trực tiếp vào trường `orders.shipping_address` (JSON/Text). Sau này khách hàng có đổi hoặc xóa địa chỉ trong sổ địa chỉ, đơn hàng đã đặt hoàn toàn không bị ảnh hưởng.
2. **Order Item Snapshot**: Bảng `order_items` lưu trữ bản sao độc lập của `snapshot_product_name`, `snapshot_sku`, `unit_price`, `subtotal`. Khóa ngoại `product_id` được đặt `SET NULL` khi xóa sản phẩm gốc. Dù sản phẩm có bị xóa khỏi catalog, trang chi tiết đơn hàng vẫn hiển thị tên, mã và giá chuẩn xác như thời điểm mua.
3. **Bundle Component Breakdown Snapshot**: Bảng `order_item_components` lưu trữ chi tiết từng linh kiện của sản phẩm combo tại thời điểm đặt. Nhờ đó, nếu sau này Admin có thay đổi công thức phối của combo, hệ thống khi xử lý hủy đơn vẫn hoàn kho chính xác theo linh kiện của thời điểm đặt hàng.

---

## 3. MÔ HÌNH TỒN KHO ẢO ĐỘC QUYỀN (DYNAMIC VIRTUAL INVENTORY)

### 3.1 Vấn Đề Nghiệp Vụ Của Combo / Set Quà Tặng
Một chiếc nhẫn bạc mã `LNS-NH001` vừa có thể bán lẻ cho khách A, vừa nằm trong Bộ sưu tập `LNS-SET001` bán cho khách B, lại vừa nằm trong Hộp quà `LNS-QT005` bán cho khách C. Nếu gán số lượng tồn kho cứng cho từng combo, hệ thống sẽ bị ảo số lượng và dẫn đến tình trạng bán vượt quá số lượng hàng có trong kho thật (Overselling).

### 3.2 Thuật Toán Tồn Kho Động (Dynamic Calculation Engine)
Trong Lunara Silver:
- **Sản phẩm đơn lẻ (`single`)**: Tồn kho là giá trị số học thực `products.stock_quantity`.
- **Bộ sưu tập (`collection`) và Quà tặng (`gift`)**: Tồn kho lưu trong DB luôn mang tính placeholder (`stock_quantity = 0`). Số lượng khả dụng bán ra được tính toán động theo thời gian thực dựa trên các linh kiện thành phần:

$$\text{AvailableQuantity}(B) = \min_{c \in \text{Components}(B)} \left( \left\lfloor \frac{\text{Stock}(c)}{\text{RequiredQty}(c)} \right\rfloor \right)$$

Nếu một combo có 3 linh kiện, trong đó linh kiện 1 còn 10 cái, linh kiện 2 còn 4 cái, linh kiện 3 hết hàng (0 cái), thì số lượng combo có thể bán ra tức thời là $\min(10, 4, 0) = 0$ (Hết hàng).

### 3.3 Thuật Toán Tổng Hợp Nhu Cầu Tồn Kho Chéo (Cross-Demand Aggregator)
Khi khách hàng đưa vào giỏ hàng vừa sản phẩm lẻ vừa sản phẩm combo có chung linh kiện:
Ví dụ: Trong giỏ có 2 chiếc nhẫn `NH001` và 1 Set `SET001` (bên trong chứa 1 chiếc `NH001`).
- Tổng nhu cầu của `NH001` là: $2 + (1 \times 1) = 3$ chiếc.
- Lớp `CartService` và `CheckoutService` sẽ tổng hợp toàn bộ nhu cầu của từng SKU linh kiện trước khi kiểm tra số lượng tồn thật trong database.

### 3.4 Khóa Giao Dịch Chống Race-Condition Khi Đặt Hàng
Khi bấm Đặt hàng, `CheckoutService` bao bọc toàn bộ logic trong một Database Transaction:
```php
DB::transaction(function () use ($cart, $orderData) {
    // 1. Lock các dòng sản phẩm trong DB để chống xung đột nhiều người mua cùng lúc
    // 2. Trừ kho linh kiện của bundle hoặc sản phẩm lẻ
    // 3. Tự động chuyển stock_status sang 'out_of_stock' nếu tồn kho về 0
    // 4. Lưu order và snapshot thành phần
});
```

---

## 4. TÍCH HỢP CỔNG THANH TOÁN VNPAY SANDBOX V2 TOÀN DIỆN

Lunara Silver xây dựng luồng tích hợp cổng thanh toán trực tuyến VNPay Sandbox theo chuẩn tài liệu V2 của VNPAY:

```text
[Khách Hàng] -------- (1) Chọn VNPay & Đặt Hàng -------> [Lunara Server]
                                                                |
                                                      (Tạo URL ký SHA512)
                                                                v
[Khách Hàng] <----- (2) Chuyển hướng sang VNPay <--------------+
     |
(Thanh toán thẻ NCB)
     |
     +------------ (3) Webhook IPN (Bất đồng bộ Server-to-Server) --------> [VNPayController::ipn]
     |                                                                           |
     |                                                                   (Xác thực chữ ký,
     |                                                                    chống trùng lặp,
     |                                                                    cập nhật PAID)
     |
     +------------ (4) Return URL (Trình duyệt quay về) ------------------> [VNPayController::return]
                                                                                 |
                                                                        (Gọi QueryDR API
                                                                         đối soát trực tiếp,
                                                                         chuyển sang Success)
```

### 4.1 Tạo Chữ Ký Bảo Mật HMAC-SHA512
Các tham số gửi sang VNPay (`vnp_TmnCode`, `vnp_Amount`, `vnp_TxnRef`, `vnp_OrderInfo`, `vnp_ReturnUrl`,...) được sắp xếp theo thứ tự bảng chữ cái (alphabetical sort), URL-encoded chuẩn RFC 3986 và băm bằng thuật toán **HMAC-SHA512** với khóa bí mật `VNPAY_HASH_SECRET`.

### 4.2 Xử Lý IPN Bất Đồng Bộ Chống Trùng Lặp (Idempotent Webhook)
Khi VNPay gửi thông báo trạng thái giao dịch về webhook `/payment/vnpay/ipn`:
1. Kiểm tra chữ ký `vnp_SecureHash`.
2. Kiểm tra xem mã giao dịch `vnp_TxnRef` có tồn tại trong hệ thống hay không.
3. Kiểm tra số tiền `vnp_Amount` có khớp với đơn hàng hay không (tránh tấn công thay đổi số tiền).
4. **Idempotency**: Nếu trạng thái đơn hàng đã là `paid`, hệ thống phản hồi ngay `{"RspCode":"02","Message":"Order already confirmed"}` mà không xử lý lại, tránh lỗi double-update.

### 4.3 Cơ Chế QueryDR (Query Transaction API) Tại Return URL
Khi khách hàng được điều hướng về trang `/payment/vnpay/return`, thay vì chỉ tin tưởng vào các tham số URL truyền qua trình duyệt (vốn có thể bị can thiệp), `PaymentReconciliationService` sẽ chủ động gửi một request HTTPS POST đến máy chủ API của VNPay (`merchant_webapi/api/transaction`) để truy vấn trực tiếp trạng thái thực của giao dịch trước khi xác nhận đơn hàng thành công.

### 4.4 Thử Lại Thanh Toán (Payment Retry) & Hoàn Tiền Tự Động (Refund API)
- **Retry**: Nếu thanh toán lần đầu bị lỗi hoặc khách hủy giao dịch, đơn hàng được giữ ở trạng thái `pending`. Khách hàng có thể nhấn nút "Thử thanh toán lại" trên trang chi tiết đơn hàng để tạo một phiên thanh toán mới mà không bị nhân đôi số lượng trừ tồn kho.
- **Tự động Hoàn tiền**: Khi Admin hủy một đơn hàng đã thanh toán qua VNPay, `RefundService` sẽ tự động ký yêu cầu hoàn tiền (Transaction Type `02` - Full Refund hoặc `03` - Partial Refund) gửi đến VNPay và tự động hoàn lại số lượng tồn kho cho từng linh kiện.

---

## 5. HỆ THỐNG QUẢN TRỊ ẢNH ĐÁM MÂY CLOUDINARY

Hệ thống quản lý ảnh trang sức chuyên nghiệp với **Cloudinary PHP SDK v3.x**:

### 5.1 Phân Định Vai Trò Hình Ảnh (Image Roles)
Mỗi sản phẩm có thể có nhiều hình ảnh với các vai trò độc lập:
- **`primary`**: Ảnh đại diện chính, xuất hiện trên danh mục và card sản phẩm.
- **`hover`**: Ảnh thứ hai, tự động hiển thị khi người dùng di chuột (hover effect) vào card sản phẩm trên trang chủ và danh mục.
- **`gallery`**: Các góc chụp chi tiết, ảnh người mẫu đeo trang sức, hiển thị trong slider trang chi tiết sản phẩm.

### 5.2 Xử Lý Đồng Bộ & Dọn Dẹp Rác
- Khi tải ảnh lên, `CloudinaryService` tự động đưa ảnh vào thư mục phân cấp `lunara/products/{sku}/`.
- Khi người dùng cập nhật ảnh đại diện mới, ảnh cũ trên Cloudinary sẽ được xóa tự động thông qua `public_id`.
- Khi xóa ảnh khỏi sản phẩm, hệ thống sẽ gọi API Cloudinary để xóa tài sản trên đám mây trước khi xóa record trong database.
- **Cơ chế Fallback thông minh**: Trong trường hợp hosting chưa cấu hình Cloudinary API hoặc mất mạng, hàm `ProductImage::displayUrl()` sẽ tự động chuyển hướng sử dụng ảnh WebP local từ `public/media-previews/` hoặc ảnh gốc trong `media/`, đảm bảo website không bao giờ bị lỗi hiển thị ảnh vỡ.

---

## 6. KIẾN TRÚC MÃ NGUỒN & CÁC PATTERN NÂNG CAO (SERVICE LAYER)

Hệ thống tuân thủ chặt chẽ nguyên lý **Separation of Concerns (SoC)** và **Thin Controllers, Rich Domain/Services**:

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Account/          # Quản lý hồ sơ, địa chỉ, đơn hàng cá nhân
│   │   ├── Admin/            # Điều hành kinh doanh, sản phẩm, đơn hàng
│   │   ├── Auth/             # Đăng ký, đăng nhập, quên mật khẩu
│   │   ├── CartController.php      # Giao tiếp API Giỏ hàng (JSON + HTML)
│   │   ├── CheckoutController.php  # Xử lý quy trình mua hàng
│   │   ├── HomeController.php      # Tải trang chủ & tối ưu n+1 query
│   │   ├── ProductController.php   # Catalog & chi tiết sản phẩm
│   │   └── VNPayController.php     # Callback và IPN Webhook
│   └── Middleware/
│       └── AdminMiddleware.php     # Chặn truy cập trái phép vào /admin
├── Models/                         # 22 Eloquent Models với các quan hệ chặt chẽ
└── Services/
    ├── CartService.php             # Xử lý giỏ hàng, gộp giỏ, kiểm tra tồn
    ├── CheckoutService.php         # Tạo đơn, snapshot thông tin, lock kho
    ├── CloudinaryService.php       # Tương tác API Cloudinary
    ├── OrderInventoryService.php   # Trừ kho, hoàn kho linh kiện
    ├── OrderStatusService.php      # Quản lý máy trạng thái đơn hàng (State Machine)
    └── VNPay/
        ├── VNPayService.php        # Ký mã và tạo URL thanh toán
        ├── RefundService.php       # Xử lý hoàn tiền
        ├── PaymentReconciliationService.php # Đối soát QueryDR
        └── VNPayQueryResult.php    # DTO đóng gói dữ liệu phản hồi
```

---

## 7. BỘ CÔNG CỤ TỰ ĐỘNG HÓA TRIỂN KHAI & CHẨN ĐOÁN KHÔNG CẦN SSH

Điểm sáng tạo đặc biệt của dự án là bộ giải pháp vận hành trên **Shared Hosting miễn phí (InfinityFree)** — nơi không có quyền truy cập dòng lệnh (SSH/CLI).

### 7.1 Kỹ Thuật Định Tuyến Document Root Bằng `.htaccess`
Thông thường, Laravel yêu cầu Document Root của máy chủ phải trỏ vào thư mục `public/`. Tuy nhiên trên Shared Hosting cPanel/InfinityFree, thư mục gốc bị cố định là `htdocs/`.
Nếu copy file `index.php` ra ngoài thư mục gốc, hệ thống sẽ gặp lỗi nạp đường dẫn và lộ toàn bộ file `.env` ra ngoài internet!

**Giải pháp của Lunara Silver**: Đặt tệp `.htaccess` tại thư mục gốc `htdocs/`:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    # Chặn lặp vô tận nếu request đã ở trong public/
    RewriteRule ^public/ - [L]

    # Nếu là tệp thật thì phục vụ trực tiếp
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d

    # Định tuyến ngầm toàn bộ request vào /public
    RewriteRule ^(.*)$ /public/$1 [L]
</IfModule>
```
Đồng thời, bên trong `public/.htaccess`, hệ thống có luật chặn truy cập trực tiếp vào các file có đuôi nhạy cảm như `.env`, `.sql`, `.git`.

---

### 7.2 Bộ Ba Tự Động Hóa Vận Hành Qua Giao Diện Web

#### 1. `diag.php` — Bộ Chẩn Đoán Sức Khỏe Toàn Diện (System Diagnostics)
- **Tự động phân quyền thư mục**: Kiểm tra và tự động `mkdir` cấp quyền `0777` cho `storage/framework/views`, `storage/framework/cache`, `storage/framework/sessions`, `bootstrap/cache`.
- **Kiểm tra 10 Extension PHP quan trọng**: Báo đèn xanh/đỏ cho `pdo`, `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `bcmath`...
- **Kiểm tra tính toàn vẹn cấu trúc file**: Phát hiện các lỗi kéo thả nhầm file qua FTP (ví dụ: phát hiện kéo nhầm thư mục `app` vào bên trong `bootstrap/app`).
- **Giả lập Khởi động Laravel Kernel (Request Simulation)**: Nạp `vendor/autoload.php` và `bootstrap/app.php`, khởi tạo HTTP Kernel và dispatch một request giả lập `GET /`. Nếu có bất kỳ lỗi cú pháp, thiếu cấu hình hay lỗi logic nào, script sẽ chặn lại và in ra toàn bộ **Exception Message, Class Name, File, Line và 12 dòng Stack Trace** rõ ràng.
- **Xóa Cache Một Chạm**: Cho phép xóa toàn bộ compiled views và bootstrap cache bằng tham số `?clear_cache=1`.

#### 2. `sync_phase13.php` — Bộ Đồng Bộ Cấu Hình & Chạy Migration Tự Động
- **Tự động cập nhật `.env`**: Đọc tệp `.env` trên host, kiểm tra nếu thiếu các biến VNPay (`VNPAY_TMN_CODE`, `VNPAY_HASH_SECRET`, `VNPAY_RETURN_URL`...) thì tự động nối thêm vào cuối tệp mà không làm ảnh hưởng các cấu hình cũ.
- **Thực thi Artisan Migration qua PHP**: Khởi động Console Kernel và gọi:
  ```php
  \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
  ```
  Nhờ đó bảng `payments` và các cột mới được thêm vào database trên host mà không cần mở terminal!
- **Làm mới bộ nhớ đệm**: Tự động gọi `Artisan::call('optimize:clear')`.
- **Bảng Kiểm Toán Trực Quan (Live Audit Table)**: Trích xuất 5 đơn hàng mới nhất và các lần thanh toán liên quan, hiển thị trực quan cấu trúc cột của bảng `orders` và `payments` để lập trình viên nghiệm thu ngay.

#### 3. `update_vendor.php` — Bộ Cập Nhật Thư Viện Nhanh Không Cần Composer
- Thư mục `vendor/` có hàng chục nghìn tệp nhỏ. Khi thêm một package mới như `cloudinary/cloudinary_php`, nếu tải từng file qua FTP sẽ rất chậm và dễ bị đứt mạng giữa chừng.
- **Giải pháp**: Đóng gói các tệp vendor bổ sung thành `cloudinary_vendor.zip` (chỉ 1.1 MB). File `update_vendor.php` sẽ mở file zip bằng lớp `ZipArchive` tích hợp sẵn của PHP trên server, tự động giải nén đè vào `vendor/`, sửa lỗi đường dẫn và kiểm tra xem lớp `Cloudinary\Cloudinary` đã hoạt động hay chưa.

---

## 8. CHIẾN LƯỢC KIỂM THỬ TỰ ĐỘNG (AUTOMATED TESTING STRATEGY)

Hệ thống được bảo vệ bởi bộ kiểm thử tự động toàn diện với **240 test cases và 1200 assertions**, đạt tỷ lệ vượt qua **100%**:

```text
Tests:    240 passed (1200 assertions)
Duration: ~40s - 45s
```

### Các Nhóm Kiểm Thử Trọng Tâm:
1. **Kiểm thử Tồn kho & Giỏ hàng (`CartTest`, `InventoryAvailabilityTest`)**:
   - Khách vãng lai và thành viên thêm sản phẩm vào giỏ.
   - Kiểm tra trần tồn kho của sản phẩm đơn lẻ.
   - Thử nghiệm tình huống phức tạp: Mua combo với số lượng tồn kho linh kiện giới hạn.
   - Thử nghiệm tình huống giỏ hàng chứa đồng thời sản phẩm lẻ và sản phẩm combo có chung linh kiện.
   - Gộp giỏ hàng (Cart Merging) khi khách vãng lai đăng nhập và cảnh báo nếu có sản phẩm đổi giá hoặc hết hàng.
2. **Kiểm thử Quy trình Thanh toán (`CheckoutTest`)**:
   - Bảo vệ token thanh toán một lần (Single-use Checkout Token).
   - Kiểm tra tính toán chính xác tổng tiền và phí vận chuyển.
   - Kiểm tra snapshot thông tin sản phẩm và địa chỉ bất biến.
   - Kiểm tra trừ tồn kho linh kiện thành phần sau khi đặt thành công.
3. **Kiểm thử Cổng Thanh toán VNPay (`VNPayPaymentTest`)**:
   - Kiểm thử tạo chữ ký URL thanh toán chuẩn HMAC-SHA512.
   - Kiểm thử tính bất biến (Idempotency) của Webhook IPN khi gửi lặp lại nhiều lần.
   - Kiểm thử cơ chế đối soát QueryDR khi người dùng quay về từ VNPay.
   - Kiểm thử thanh toán lại (Retry) và hoàn tiền tự động khi hủy đơn.
4. **Kiểm thử Quản trị & Bảo mật (`AdminAccessTest`, `AdminOrderManagementTest`, `ProductImageManagementTest`)**:
   - Chặn người dùng thường và khách vãng lai truy cập vào `/admin`.
   - Kiểm thử quy trình chuyển đổi trạng thái đơn hàng hợp lệ và từ chối các bước nhảy trạng thái sai logic.
   - Kiểm thử khôi phục tồn kho chính xác theo từng linh kiện khi hủy đơn.
   - Kiểm thử tải ảnh lên Cloudinary và xóa an toàn tài sản trên đám mây.

---

<p align="center">
  Tài liệu này là tài sản kỹ thuật của dự án <strong>Lunara Silver</strong>.<br>
  Được thiết kế để chia sẻ kiến thức chuẩn mực về phát triển Laravel hiện đại và kỹ năng vận hành thực chiến.
</p>
