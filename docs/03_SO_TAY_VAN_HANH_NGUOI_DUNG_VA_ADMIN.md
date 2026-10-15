# 📖 LUNARA SILVER — SỔ TAY VẬN HÀNH NGƯỜI DÙNG & QUẢN TRỊ VIÊN
## CẨM NANG HƯỚNG DẪN KHÁCH HÀNG, QUẢN TRỊ ADMIN & KỊCH BẢN TRÌNH DIỄN ĐỒ ÁN (LIVE DEMO)

> **Mục đích tài liệu:** Hướng dẫn trực quan, chi tiết từng tính năng dành cho hai đối tượng người dùng chính của hệ thống: Khách hàng mua sắm (Storefront) và Quản trị viên doanh nghiệp (Admin). Đồng thời cung cấp kịch bản trình diễn thực chiến 8 bước phục vụ hội đồng chấm thi và bảo vệ đồ án tốt nghiệp.

---

## 📑 MỤC LỤC TỔNG QUAN

1. [Thông tin Đăng nhập Mẫu & Môi trường Trải nghiệm](#1-thông-tin-đăng-nhập-mẫu--môi-trường-trải-nghiệm)
2. [Cẩm nang Vận hành Dành cho Khách hàng (Customer Manual)](#2-cẩm-nang-vận-hành-dành-cho-khách-hàng-customer-manual)
3. [Cẩm nang Vận hành Dành cho Quản trị viên (Admin Command Center)](#3-cẩm-nang-vận-hành-dành-cho-quản-trị-viên-admin-command-center)
4. [Kịch bản Trình diễn Thực chiến 8 Bước (Defense Demo Script)](#4-kịch-bản-trình-diễn-thực-chiến-8-bước-defense-demo-script)

---

## 1. THÔNG TIN ĐĂNG NHẬP MẪU & MÔI TRƯỜNG TRẢI NGHIỆM

Hệ thống đã chuẩn hóa sẵn các tài khoản thử nghiệm đầy đủ dữ liệu lịch sử phục vụ nghiệm thu:

| Vai trò (Role) | Địa chỉ Email | Mật khẩu truy cập | Mục đích sử dụng thử nghiệm |
| :--- | :--- | :---: | :--- |
| **Quản trị viên (Super Admin)** | `admin@lunarasilver.com` | `password` | Toàn quyền kiểm soát Admin, quản lý sản phẩm, đơn hàng, khách hàng 360, duyệt review, xem doanh thu thuần. |
| **Khách hàng thân thiết (VIP Customer)**| `customer@lunarasilver.com`| `password` | Khách hàng đã có sẵn các đơn hàng completed để thử nghiệm tính năng Đánh giá Verified Buyer và xem lịch sử đơn. |
| **Khách hàng mới (New Customer)** | `newuser@lunarasilver.com` | `password` | Thử nghiệm áp dụng mã giảm giá dành riêng cho đơn đầu tiên (`is_first_order_only`). |

*Đường dẫn truy cập:*
* **Cửa hàng (Storefront):** `http://127.0.0.1:8000`
* **Khu vực Quản trị (Admin Portal):** `http://127.0.0.1:8000/admin`

---

## 2. CẨM NANG VẬN HÀNH DÀNH CHO KHÁCH HÀNG (CUSTOMER MANUAL)

### 2.1 Khám Phá Trang Sức & Bộ Lọc Nâng Cao
1. **Duyệt Danh mục Đa cấp**: Khách hàng có thể truy cập menu chính để khám phá: Dây chuyền, Nhẫn, Vòng tay, Bộ sưu tập (`Collection`) và Hộp quà tặng (`Gift`).
2. **Bộ lọc Thông minh (Smart Filters)**:
   * **Khoảng giá**: Lọc sản phẩm dưới 300.000đ, từ 300.000đ - 500.000đ, hoặc trên 500.000đ.
   * **Đá quý đính kèm**: Lọc nhanh các mẫu đính đá Moissanite lấp lánh, Thạch anh hoặc Đá nhân tạo Zirconia.
   * **Sắp xếp**: Theo giá tăng dần, giá giảm dần, hoặc sản phẩm mới nhất.
3. **Hiệu ứng Xem trước Hình ảnh (Image Hover Effect)**:
   * Trên mỗi thẻ sản phẩm, khi di chuột (hover) vào thẻ, hình ảnh sẽ mượt mà chuyển sang góc chụp thứ hai (`hover image`), giúp khách hàng chiêm ngưỡng trang sức từ nhiều góc độ mà chưa cần tải lại trang.
4. **Tìm kiếm Nhanh Bằng Phím Tắt Command Palette (Ctrl+K)**:
   * Nhấn tổ hợp phím `Ctrl + K` (hoặc biểu tượng kính lúp trên thanh điều hướng) để mở khung tìm kiếm trung tâm. Nhập từ khóa (ví dụ: *"Nhẫn"*, *"Ánh Trăng"*) để nhận gợi ý sản phẩm tức thì.

### 2.2 Trải Nghiệm Giỏ Hàng & Tùy Biến Thiệp Quà Tặng Viết Tay
1. **Thêm vào Giỏ Hàng**:
   * Tại trang chi tiết sản phẩm, chọn số lượng và bấm nút **"Thêm vào Giỏ hàng"**.
   * Với các Hộp Quà Tặng cao cấp (`gift`), khách hàng có thể tích chọn ô **"Gửi kèm thiệp viết tay"** và nhập lời chúc riêng tư (tối đa 250 ký tự). Nội dung lời chúc này sẽ được lưu bất biến vào hóa đơn.
2. **Ngăn Kéo Giỏ Hàng Trượt (Slide-out Mini Cart Drawer)**:
   * Khi thêm sản phẩm thành công, ngăn kéo giỏ hàng bên phải màn hình sẽ tự động trượt ra.
   * Khách hàng có thể tăng/giảm số lượng hoặc xóa sản phẩm ngay trong Drawer bằng các thao tác AJAX bất đồng bộ siêu mượt mà không làm chuyển trang.
3. **Thanh Tiến Trình Miễn Phí Vận Chuyển (Free Shipping Bar)**:
   * Hệ thống hiển thị thanh thông báo sinh động: *"Mua thêm 110.000đ để được Freeship toàn quốc!"*.

### 2.3 Áp Dụng Mã Giảm Giá & Thanh Toán An Toàn
1. **Áp Mã Coupon**:
   * Tại trang Giỏ hàng hoặc trang Thanh toán, nhập mã ưu đãi (ví dụ: `LUNARA10` - giảm 10%, hoặc `CHAOMUNG` - giảm 50k cho đơn đầu).
   * Hệ thống sẽ tự động kiểm tra điều kiện giá trị đơn tối thiểu, trần giảm giá tối đa và hiển thị số tiền tiết kiệm được.
2. **Chọn Phương Thức Thanh Toán**:
   * **Thanh toán khi nhận hàng (COD)**: Đơn hàng được xác nhận ngay với trạng thái chờ xử lý (`pending`).
   * **Thanh toán trực tuyến qua VNPAY Sandbox**:
     * Hệ thống chuyển hướng khách hàng sang Cổng VNPay chính thức.
     * Sử dụng thẻ thử nghiệm ngân hàng NCB:
       * **Số thẻ:** `9704198526191432198`
       * **Tên chủ thẻ:** `NGUYEN VAN A`
       * **Ngày phát hành:** `07/15`
       * **Mã OTP xác thực:** `123456`
     * Sau khi thanh toán thành công, hệ thống tự động quay về trang Xác nhận Đơn hàng (`/payment/vnpay/return`).

### 2.4 Quản Lý Tài Khoản Cá Nhân & Đánh Giá Đã Mua Hàng
1. **Sổ Địa Chỉ Giao Hàng (Address Book)**:
   * Lưu trữ nhiều địa chỉ giao hàng (Nhà riêng, Văn phòng).
   * Chọn địa chỉ mặc định để tự động điền khi thanh toán đơn hàng sau.
2. **Theo Dõi Tiến Độ Đơn Hàng (Order Tracking)**:
   * Xem tiến trình di chuyển của gói hàng: *Chờ xác nhận* $\rightarrow$ *Đang chuẩn bị* $\rightarrow$ *Đang vận chuyển* $\rightarrow$ *Giao thành công*.
   * Nút **"Thử thanh toán lại"**: Xuất hiện khi thanh toán VNPay trước đó bị gián đoạn, cho phép thanh toán lại mà không làm trùng lặp đơn.
3. **Gửi Đánh Giá Người Mua Đã Xác Thực (Verified Buyer Review)**:
   * Khi đơn hàng đạt trạng thái `completed`, nút **"Viết đánh giá"** sẽ sáng lên.
   * Khách hàng chấm điểm số sao (1 đến 5 sao) và chia sẻ cảm nhận thực tế.
   * Tên khách hàng trên trang sản phẩm được tự động ẩn bớt ký tự giữa (ví dụ: `Ng*** A.`) để bảo đảm quyền riêng tư tuyệt đối.

### 2.5 Trợ Lý Tư Vấn Trực Tuyến Lunara Concierge
* Nhấp vào biểu tượng Bong bóng chat tròn ở góc phải dưới màn hình.
* Chọn các nút câu hỏi tư vấn nhanh:
  * *"Tư vấn chọn size nhẫn"*
  * *"Chính sách bảo hành và đánh sáng bạc 925"*
  * *"Thời gian giao hàng"*
* Khách hàng cũng có thể gõ nội dung câu hỏi riêng, tư vấn viên Admin sẽ phản hồi trực tiếp.

---

## 3. CẨM NANG VẬN HÀNH DÀNH CHO QUẢN TRỊ VIÊN (ADMIN COMMAND CENTER)

Truy cập đường dẫn: `http://127.0.0.1:8000/admin` (Đăng nhập tài khoản `admin@lunarasilver.com`).

### 3.1 Bảng Điều Khiển Tổng Quan (Admin Dashboard)
1. **Chỉ Số Tài Chính Thuần (Net Revenue)**:
   * Hệ thống hiển thị doanh thu thực tế sau khi đã trừ đi các đơn bị hoàn tiền VNPay và chiết khấu coupon.
2. **Thẻ Chỉ Số Kinh Doanh Cốt Lõi**:
   * Tổng đơn hàng mới trong ngày.
   * Tổng số lượng khách hàng đã đăng ký.
   * Số lượng đánh giá đang chờ duyệt.
   * Cảnh báo sản phẩm sắp hết hàng (kho $\le 3$ sản phẩm).
3. **Biểu Đồ Xu Hướng Doanh Thu (Chart.js)**:
   * Đồ thị đường và cột trực quan thể hiện biến động dòng tiền theo tuần/tháng.

### 3.2 Quản Lý Sản Phẩm Đơn & Bộ Sản Phẩm Combo
1. **Tạo / Cập Nhật Sản Phẩm Đơn Lẻ (`single`)**:
   * Quản lý mã SKU, tên sản phẩm, giá niêm yết, giá khuyến mãi, số lượng tồn kho thực tế.
   * Chọn trạng thái: Còn hàng (`in_stock`) hoặc Hết hàng (`out_of_stock`).
2. **Tạo / Cấu Hình Bộ Sưu Tập (`collection`) & Quà Tặng (`gift`)**:
   * Nhập thông tin chung của combo (Tên Set, giá bán combo).
   * **Phân bổ Linh kiện thành phần:** Chọn các sản phẩm đơn cấu thành Set và nhập số lượng mỗi món (ví dụ: Set 1 gồm 1 Dây chuyền `DC001` + 1 Nhẫn `NH001`).
   * *Lưu ý quan trọng:* Tồn kho của Set sẽ do Động cơ Tồn kho Ảo tự động tính toán từ linh kiện thành phần, Admin không cần nhập tồn kho thủ công cho combo.

### 3.3 Quản Lý Hình Ảnh Sản Phẩm Với Cloudinary CDN
1. **Tải Lên Ảnh Sản Phẩm**:
   * Tại màn hình chỉnh sửa sản phẩm, chọn tệp ảnh từ máy tính.
   * Ảnh được tải trực tiếp lên Cloudinary CDN và tự động phân vào thư mục `lunara/products/{sku}/`.
2. **Phân Định Vai Trò Hình Ảnh**:
   * Gán vai trò `primary` cho ảnh đại diện chính.
   * Gán vai trò `hover` cho ảnh đổi góc khi rê chuột.
   * Gán vai trò `gallery` cho các ảnh chi tiết phụ.
3. **Xóa Ảnh An Toàn**: Khi Admin bấm xóa một ảnh, hệ thống tự động gọi API Cloudinary để hủy tài sản trên đám mây trước khi xóa dữ liệu trong database.

### 3.4 Quản Lý Đơn Hàng & Xử Lý Hoàn Tiền VNPay Trực Tuyến
1. **Máy Trạng Thái Đơn Hàng (State Machine Enforcement)**:
   * Hệ thống chỉ cho phép chuyển đổi trạng thái đơn hợp lệ:
     * `pending` $\rightarrow$ `processing` $\rightarrow$ `shipping` $\rightarrow$ `completed`.
     * Hoặc `pending` / `processing` $\rightarrow$ `cancelled`.
   * Ngăn chặn các thao tác nhảy cóc sai logic nghiệp vụ (ví dụ: không thể nhảy từ `pending` sang `completed` khi chưa xử lý).
2. **Quy Trình Hủy Đơn & Tự Động Hoàn Tiền (Refund API)**:
   * Với đơn hàng đã thanh toán qua VNPay (`payment_status = paid`):
   * Khi Admin nhấn nút **"Hủy đơn hàng"**, một hộp thoại xác nhận hoàn tiền sẽ hiện ra.
   * Hệ thống sẽ tự động gọi API `Refund` của VNPay để chuyển tiền trả lại thẻ ngân hàng của khách, ghi nhận giao dịch refund trong bảng `payments`, đồng thời **tự động hoàn lại số lượng tồn kho linh kiện** vào kho hàng.

### 3.5 Kiểm Duyệt & Phản Hồi Đánh Giá (Review Moderation)
1. **Hàng Đợi Kiểm Duyệt (Pending Reviews)**:
   * Admin duyệt qua danh sách các đánh giá mới gửi từ khách hàng đã mua sản phẩm.
   * Bấm **"Phê duyệt (Approve)"** để đánh giá hiển thị công khai trên website và cập nhật điểm SEO AggregateRating.
   * Bấm **"Từ chối (Reject)"** nếu nội dung đánh giá vi phạm tiêu chuẩn cộng đồng.
2. **Phản Hồi Chính Thức (Merchant Reply)**:
   * Admin có thể nhập nội dung chăm sóc khách hàng (ví dụ: *"Cảm ơn quý khách đã tin dùng trang sức Lunara Silver!"*). Lời phản hồi sẽ hiển thị trang trọng ngay dưới đánh giá của khách hàng.

### 3.6 Quản Lý Chiến Dịch Khuyến Mãi (Coupon Campaigns)
* Bấm **"Thêm Mã Khuyến Mãi"**:
  * Thiết lập mã code (ví dụ: `SUMMERSALE`).
  * Chọn loại: Chiết khấu phần trăm (%) hoặc số tiền cố định (VNĐ).
  * Đặt hạn mức: Giá trị đơn tối thiểu (`min_order_amount`), số tiền giảm tối đa (`max_discount_amount`).
  * Đặt giới hạn: Tổng số lượt dùng toàn hệ thống và số lượt dùng tối đa trên mỗi tài khoản.
  * Tùy chọn: Dành riêng cho đơn hàng đầu tiên (`is_first_order_only`).

### 3.7 Hồ Sơ Khách Hàng 360 & Tải Lười AJAX (Customer 360 Insights)
* Truy cập mục **Khách hàng** $\rightarrow$ Chọn một khách hàng cụ thể:
* Màn hình mở ra tức thì với các chỉ số tổng hợp:
  * **LTV (Lifetime Value)**: Tổng giá trị mua hàng tích lũy.
  * **AOV**: Giá trị trung bình trên mỗi đơn.
  * Tổng số đơn đã đặt và tỷ lệ hoàn tất.
* **4 Tab Chuyên Sâu Tải Lười (Lazy Tabs)**:
  * Nhấp vào tab *Đơn hàng*, *Đánh giá*, hoặc *Sổ địa chỉ*.
  * Hệ thống chỉ nạp dữ liệu chi tiết của tab đó qua AJAX, bảo đảm trang quản trị luôn phản hồi mượt mà dưới **20ms**.

### 3.8 Quản Trị Bài Viết Blog / Nhật Ký Lunara
* Soạn thảo bài viết chia sẻ phong cách, kiến thức bảo quản trang sức bạc.
* Tích hợp bộ lọc làm sạch HTML (`Post::sanitizeHtml()`), loại bỏ triệt để các mã kịch bản XSS nguy hiểm nhưng bảo toàn bố cục văn bản đẹp mắt.
* Tự động sinh thẻ `Article` Schema phục vụ tối ưu hóa công cụ tìm kiếm Google.

---

## 4. KỊCH BẢN TRÌNH DIỄN THỰC CHIẾN 8 BƯỚC (DEFENSE DEMO SCRIPT)

Kịch bản được thiết kế chuẩn xác để trình bày trước Hội đồng chấm thi trong vòng **10 - 15 phút**:

```text
+-----------------------------------------------------------------------------------+
|               KỊCH BẢN TRÌNH DIỄN ĐỒ ÁN LUNARA SILVER (8 BƯỚC)                    |
+-----------------------------------------------------------------------------------+
| 1. Khám phá Storefront & Hiệu ứng Celestial Luxury (Hover ảnh, Lọc, Ctrl+K)      |
| 2. Thử nghiệm Động cơ Tồn kho Ảo (Virtual Inventory) trên Combo / Gift Box        |
| 3. Trải nghiệm Giỏ hàng Trượt & Gửi Kèm Thiệp Viết Tay                            |
| 4. Áp dụng Mã Giảm Giá Đa Điều Kiện (Coupon Engine)                               |
| 5. Đặt hàng & Thanh toán Trực tuyến Qua VNPay Sandbox V2                          |
| 6. Nghiệm thu Đối soát QueryDR tại Return URL & Kiểm tra Snapshot Bất biến       |
| 7. Gửi Đánh giá Người Mua Đã Xác Thực (Verified Buyer Review)                     |
| 8. Đăng nhập Admin Command Center: Net Revenue, Customer 360, Hủy Đơn & Hoàn Tiền|
+-----------------------------------------------------------------------------------+
```

### Bước 1: Trình Diễn Giao Diện Đẳng Cấp & Tìm Kiếm Thông Minh (2 phút)
* **Thao tác:** Mở trang chủ `http://127.0.0.1:8000`. Lướt qua Hero Slider và Banner chủ đề ánh trăng.
* **Điểm nhấn thuyết trình:**
  * Giải thích triết lý màu sắc *Celestial Luxury Minimalism* (Midnight Navy, Silver Sparkle, Pure Silk Ivory).
  * Rê chuột qua thẻ sản phẩm để thấy hiệu ứng đổi sang ảnh góc chụp thứ 2 (`hover image`).
  * Nhấn `Ctrl + K` mở thanh tìm kiếm Command Palette, gõ *"Nhẫn"* để chứng minh tính năng tìm kiếm phím tắt thời gian thực.

### Bước 2: Trình Diễn Động Cơ Tồn Kho Ảo (Dynamic Virtual Inventory) (2 phút)
* **Thao tác:** Mở trang chi tiết Bộ sưu tập `LNS-SET001` hoặc Set Quà Tặng `LNS-QT001`.
* **Điểm nhấn thuyết trình:**
  * Giải thích bài toán: Combo không lưu tồn kho cứng để tránh bán khống hàng (Overselling).
  * Chỉ rõ các linh kiện thành phần cấu thành Set (ví dụ: 1 Dây chuyền + 1 Nhẫn).
  * Giải thích công thức toán học: Tồn kho combo được tính động bằng $\min$ của tồn kho các linh kiện thành phần.

### Bước 3: Thêm Thiệp Quà Tặng & Giỏ Hàng Trượt Mini Cart (1.5 phút)
* **Thao tác:** Chọn mua 1 Set Quà Tặng, tích chọn "Gửi kèm thiệp quà tặng", gõ lời chúc: *"Chúc bạn sinh nhật vui vẻ và tỏa sáng cùng Lunara Silver!"*. Nhấn **Thêm vào giỏ**.
* **Điểm nhấn thuyết trình:**
  * Ngăn kéo giỏ hàng bên phải tự động trượt ra mượt mà không load lại trang.
  * Lời chúc thiệp quà tặng được hiển thị ngay dưới sản phẩm.
  * Thử tăng giảm số lượng bằng nút `+` / `-` qua AJAX.

### Bước 4: Áp Dụng Mã Giảm Giá Đa Điều Kiện (1.5 phút)
* **Thao tác:** Đi đến trang Giỏ hàng. Nhập mã coupon `LUNARA10` (giảm 10%).
* **Điểm nhấn thuyết trình:**
  * Hệ thống thẩm tra điều kiện: Thời hạn mã, số lượt dùng toàn hệ thống, hạn mức trên tài khoản.
  * Hiển thị dòng chiết khấu rõ ràng, tổng tiền thanh toán được cập nhật tự động.

### Bước 5: Đặt Hàng & Thanh Toán VNPay Sandbox V2 (2 phút)
* **Thao tác:** Bấm Tiến hành Thanh toán. Điền thông tin người nhận. Chọn phương thức **Thanh toán qua VNPAY**. Nhấn nút **Đặt hàng**.
* **Điểm nhấn thuyết trình:**
  * Trình duyệt chuyển hướng mượt mà sang Cổng thanh toán VNPAY chính thức.
  * Giải thích cơ chế bảo mật: Toàn bộ tham số được ký băm bảo mật bằng thuật toán **HMAC-SHA512**.
  * Nhập thông tin thẻ test ngân hàng NCB (`9704198526191432198`, `NGUYEN VAN A`, OTP `123456`) và bấm Xác nhận thanh toán.

### Bước 6: Nghiệm Thu Đối Soát QueryDR & Snapshot Bất Biến (1.5 phút)
* **Thao tác:** Sau khi thanh toán, VNPAY điều hướng trở lại website Lunara Silver.
* **Điểm nhấn thuyết trình:**
  * Trình bày cơ chế **QueryDR API**: Thay vì chỉ tin vào URL trình duyệt, máy chủ Lunara chủ động gọi API sang VNPay để đối soát trạng thái thực tế.
  * Mở chi tiết đơn hàng: Chứng minh nguyên tắc **Bản chụp Bất biến (Immutable Snapshot)** — Toàn bộ tên sản phẩm, giá bán, linh kiện combo, lời chúc thiệp và địa chỉ giao hàng được đóng băng độc lập, không bị ảnh hưởng nếu dữ liệu gốc thay đổi.

### Bước 7: Trình Diễn Đánh Giá Verified Buyer (1.5 phút)
* **Thao tác:** Đăng nhập tài khoản `customer@lunarasilver.com`. Vào mục Đơn hàng của tôi $\rightarrow$ Đơn hàng đã hoàn tất $\rightarrow$ Bấm **Viết đánh giá**.
* **Điểm nhấn thuyết trình:**
  * Chỉ khách hàng đã mua sản phẩm trong đơn hoàn tất mới có quyền đánh giá (Chống review giả mạo).
  * Gửi đánh giá 5 sao. Quay ra trang sản phẩm: Chỉ ra tên khách hàng được tự động che giấu riêng tư (`Ng*** A.`).

### Bước 8: Trung Tâm Quản Trị Admin Command Center (3 phút)
* **Thao tác:** Đăng nhập `admin@lunarasilver.com` tại `/admin`.
* **Điểm nhấn thuyết trình:**
  * **Dashboard:** Giới thiệu công thức tính Doanh thu thuần (Net Revenue).
  * **Customer 360:** Mở hồ sơ khách hàng, lướt qua các tab Lazy Tab AJAX tải dưới 20ms.
  * **Duyệt Review:** Phê duyệt đánh giá vừa gửi và gõ phản hồi thương hiệu.
  * **Hủy đơn & Hoàn tiền tự động:** Chọn đơn hàng VNPay vừa đặt ở Bước 5, bấm Hủy đơn. Chứng minh hệ thống tự động gọi API Hoàn tiền sang VNPay và tự động cộng trả lại tồn kho linh kiện vào kho hàng!

---

<p align="center">
  <strong>LUNARA SILVER — CẨM NANG VẬN HÀNH & KỊCH BẢN NGHIỆM THU</strong><br>
  Tài liệu chuẩn bị kỹ lưỡng cho buổi bảo vệ đồ án chuyên nghiệp, ấn tượng và thuyết phục.
</p>
