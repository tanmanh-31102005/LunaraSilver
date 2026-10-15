# 🎓 LUNARA SILVER — HỒ SƠ ĐỒ ÁN & KỊCH BẢN BẢO VỆ TỐT NGHIỆP
## ÁNH XẠ CHUẨN ĐẦU RA HỌC PHẦN, ĐIỂM SÁNG TẠO ĐỘC QUYỀN & KỊCH BẢN THUYẾT TRÌNH HỘI ĐỒNG

> **Mục đích tài liệu:** Cung cấp tài liệu bảo vệ đồ án chuyên nghiệp dành cho sinh viên và nhóm phát triển: bảng đối soát chuẩn đầu ra môn học/đồ án mã nguồn mở, tổng hợp các đóng góp kỹ thuật sáng tạo độc quyền, kịch bản thuyết trình từng slide (Presentation Script) và lộ trình phát triển nâng cấp hệ thống.

---

## 📑 MỤC LỤC TỔNG QUAN

1. [Bảng Đối soát Chuẩn Đầu ra Học phần / Đồ án (Academic Mapping)](#1-bảng-đối-soát-chuẩn-đầu-ra-học-phần--đồ-án-academic-mapping)
2. [Tổng hợp 6 Đóng góp Kỹ thuật Sáng tạo Độc quyền](#2-tổng-hợp-6-đóng-góp-kỹ-thuật-sáng-tạo-độc-quyền)
3. [Kịch bản Thuyết trình Bảo vệ Đồ án Chi tiết (Slide-by-Slide Script)](#3-kịch-bản-thuyết-trình-bảo-vệ-đồ-án-chi-tiết-slide-by-slide-script)
4. [Bộ Câu hỏi Phản biện Tiêu biểu của Hội đồng & Gợi ý Trả lời](#4-bộ-câu-hỏi-phản-biện-tiêu-biểu-của-hội-đồng--gợi-ý-trả-lời)
5. [Đánh giá Giới hạn & Lộ trình Phát triển Tương lai (Roadmap)](#5-đánh-giá-giới-hạn--lộ-trình-phát-triển-tương-lai-roadmap)

---

## 1. BẢNG ĐỐI SOÁT CHUẨN ĐẦU RA HỌC PHẦN / ĐỒ ÁN (ACADEMIC MAPPING)

| Chuẩn Đầu Ra (Learning Outcome) | Yêu cầu Đồ án Chuẩn mực | Minh chứng Kỹ thuật Triển khai Thực tế trong Lunara Silver | Đánh giá Mức độ Đạt |
| :--- | :--- | :--- | :---: |
| **CLO 1: Phân tích & Đặc tả Yêu cầu** | Phân tích bài toán e-commerce, lập danh mục chức năng, mô tả quy trình nghiệp vụ. | Xây dựng tài liệu đặc tả 13 phân hệ, catalog 45 sản phẩm thực tế (30 single, 10 combo, 5 gift set), bảng ma trận phân quyền tác nhân rõ ràng. | **100% Đạt Xuất sắc** |
| **CLO 2: Thiết kế Kiến trúc & Dữ liệu** | Mô hình hóa Use Case, vẽ sơ đồ thực thể quan hệ (ERD), sơ đồ luồng dữ liệu hoặc tuần tự. | Xây dựng ERD 20+ bảng chuẩn 3NF, 12 Sơ đồ Tuần tự Sequence Diagrams bằng Mermaid, áp dụng Layered Architecture và Service Layer Pattern. | **100% Đạt Xuất sắc** |
| **CLO 3: Lập trình với Framework Hiện đại** | Xây dựng ứng dụng web sử dụng một framework mã nguồn mở phổ biến (Laravel, Django, Spring). | Ứng dụng **Laravel 12.69.2**, PHP 8.2, áp dụng SoC (Separation of Concerns), Thin Controllers, Rich Domain Services, 22 Eloquent Models. | **100% Đạt Xuất sắc** |
| **CLO 4: Cơ sở Dữ liệu & Toàn vẹn ACID** | Quản trị CSDL quan hệ, sử dụng Transaction, chống xung đột dữ liệu và bất toàn vẹn. | Áp dụng nguyên tắc Bản chụp Bất biến (Immutable Snapshot), Pessimistic Locking (`lockForUpdate`), giải thuật Tồn kho Ảo Động chống overselling. | **100% Đạt Xuất sắc** |
| **CLO 5: Tích hợp Dịch vụ Bên ngoài** | Tích hợp ít nhất 1 cổng dịch vụ ngoài (Thanh toán, Email, Đám mây). | Tích hợp thành công **VNPay Sandbox V2** (IPN Webhook, QueryDR, Refund API), **Cloudinary PHP SDK 3.x** quản trị ảnh đám mây, Google SMTP Mail. | **100% Đạt Xuất sắc** |
| **CLO 6: An toàn Thông tin & Bảo mật** | Tuân thủ các nguyên tắc lập trình an toàn, phòng chống tấn công OWASP Top 10. | Bcrypt Cost 12, Rate Limiting Brute-force, Session Hardening, RBAC kép, IDOR OrderPolicy, XSS Whitelist Filter, CSRF Tokens, Parameterized Queries. | **100% Đạt Xuất sắc** |
| **CLO 7: Kiểm thử Phần mềm Đảm bảo Chất lượng** | Viết và thực thi các kịch bản kiểm thử hộp trắng / hộp đen tự động. | Bộ kiểm thử tự động toàn diện với **367 bài test**, **1,762 assertions**, đạt tỷ lệ vượt qua **100% Pass** qua khung PHPUnit 11. | **100% Đạt Xuất sắc** |
| **CLO 8: Triển khai & Vận hành Thực tế** | Triển khai website lên môi trường máy chủ internet thực tế. | Triển khai thành công lên **InfinityFree Shared Hosting** bằng kỹ thuật định tuyến `.htaccess` và bộ công cụ Zero-SSH Automation (`diag.php`, `sync_phase13.php`). | **100% Đạt Xuất sắc** |

---

## 2. TỔNG HỢP 6 ĐÓNG GÓP KỸ THUẬT SÁNG TẠO ĐỘC QUYỀN

Khác biệt hoàn toàn so với các đồ án thương mại điện tử khuôn mẫu thông thường, **Lunara Silver** đóng góp 6 giải pháp kỹ thuật có tính ứng dụng thực tiễn rất cao:

```text
+---------------------------------------------------------------------------------------+
|                    6 ĐÓNG GÓP KỸ THUẬT ĐỘC QUYỀN CỦA LUNARA SILVER                    |
+---------------------------------------------------------------------------------------+
| 1. ĐỘNG CƠ TỒN KHO ẢO ĐỘNG (Dynamic Virtual Inventory Engine cho Combo / Gift Set)    |
| 2. NGUYÊN TẮC BẢN CHỤP BẤT BIẾN (Immutable Snapshot: Địa chỉ, Linh kiện, Hóa đơn)    |
| 3. TÍCH HỢP VNPAY V2 TOÀN DIỆN (QueryDR tại Return URL, Idempotent IPN, Refund API)  |
| 4. BỘ CÔNG CỤ TỰ ĐỘNG HÓA VẬN HÀNH KHÔNG CẦN SSH (Zero-SSH Shared Hosting Suite)      |
| 5. ĐÁNH GIÁ NGƯỜI MUA ĐÃ XÁC THỰC (Verified Buyer Reviews) & CHE TÊN RIÊNG TƯ         |
| 6. TRUNG TÂM ADMIN CUSTOMER 360 & KIẾN TRÚC TẢI LƯỜI LAZY TAB AJAX (< 20ms)           |
+---------------------------------------------------------------------------------------+
```

1. **Động cơ Tồn kho Ảo Động (Virtual Inventory Engine)**:
   * Loại bỏ hoàn toàn việc gán tồn kho cứng cho Bộ sưu tập và Quà tặng.
   * Tính toán tức thời số lượng bán khả dụng theo thuật toán $\min$ của tồn kho các linh kiện thành phần.
   * Giải thuật tổng hợp nhu cầu chéo (Cross-Demand Aggregator) ngăn chặn triệt để tình trạng bán vượt tồn kho (Overselling) khi giỏ hàng chứa lẫn lộn cả sản phẩm lẻ và combo.
2. **Nguyên tắc Bản chụp Bất biến (Immutable Snapshot)**:
   * Đóng băng độc lập tên sản phẩm, mã SKU, giá bán, linh kiện combo, lời chúc thiệp và địa chỉ giao hàng tại thời điểm đặt hàng.
   * Lịch sử đơn hàng luôn trường tồn chính xác 100%, không bị sai lệch hay crash kể cả khi Admin thay đổi giá hoặc xóa sản phẩm gốc khỏi danh mục.
3. **Tích hợp VNPay V2 Toàn Diện & Chuẩn Mực**:
   * Triển khai đầy đủ chữ ký số bảo mật **HMAC-SHA512**.
   * Webhook IPN xử lý bất đồng bộ chống lặp (Idempotent).
   * Cơ chế **QueryDR API** tại Return URL chủ động xác minh với máy chủ VNPay trước khi ghi nhận thành công.
   * Khả năng Thử lại thanh toán (Payment Retry) và Hoàn tiền tự động (Automated Refund) khi hủy đơn.
4. **Bộ Công cụ Vận hành Tự động Không Cần SSH (Zero-SSH Suite)**:
   * Giúp một ứng dụng Laravel 12 hiện đại vận hành trơn tru trên Shared Hosting miễn phí chỉ thông qua giao diện web:
   * `diag.php` (tự động phân quyền storage, kiểm tra extension, mô phỏng kernel).
   * `sync_phase13.php` (chạy migration và thêm biến .env qua code PHP).
   * `update_vendor.php` (cập nhật thư viện nhanh bằng file zip).
5. **Đánh giá Người Mua Đã Xác Thực (Verified Buyer Review)**:
   * Chỉ cho phép khách hàng đã mua sản phẩm trong đơn hàng completed gửi đánh giá.
   * Che tên riêng tư (`Ng*** A.`) bảo vệ quyền nhân thân của khách hàng.
   * Tự động sinh cấu trúc SEO Google `AggregateRating`.
6. **Customer 360 & Kiến trúc Lazy Tab AJAX**:
   * Cung cấp góc nhìn toàn diện về LTV (Lifetime Value) và tần suất mua hàng.
   * 4 tab chuyên sâu tải lười qua AJAX, duy trì tốc độ nạp trang Admin dưới **20ms**.

---

## 3. KỊCH BẢN THUYẾT TRÌNH BẢO VỆ ĐỒ ÁN CHI TIẾT (SLIDE-BY-SLIDE SCRIPT)

Thời lượng dự kiến: **10 - 12 phút**.

### Slide 1: Giới Thiệu Đề Tài (1 phút)
* **Tiêu đề:** Xây Dựng Nền Tảng Thương Mại Điện Tử Trang Sức Bạc Cao Cấp — Lunara Silver Trên Nền Tảng Laravel 12.
* **Lời nói:** *"Kính thưa quý Thầy Cô trong Hội đồng chấm thi! Hôm nay, em xin đại diện nhóm trình bày đề tài đồ án tốt nghiệp: Lunara Silver. Đề tài hướng tới việc giải quyết bài toán kinh doanh trực tuyến cho ngành hàng trang sức bạc cao cấp với các nghiệp vụ đặc thù như combo linh kiện, thiệp quà tặng viết tay và thanh toán trực tuyến an toàn."*

### Slide 2: Vấn Đề Nghiệp Vụ & Sứ Mệnh Lunara Silver (1.5 phút)
* **Nội dung:** Thách thức của ngành trang sức (quản lý tồn kho combo phức tạp, nguy cơ overselling, bảo mật thanh toán, trải nghiệm mua sắm sang trọng).
* **Lời nói:** *"Trong các hệ thống e-commerce thông thường, một chiếc nhẫn bạc khi vừa bán lẻ, vừa nằm trong set quà tặng rất dễ bị bán khống số lượng. Đồng thời, hóa đơn cũ thường bị sai lệch khi giá vàng bạc biến động. Lunara Silver ra đời với định hướng giải quyết triệt để các bài toán này bằng kiến trúc phần mềm chuẩn mực."*

### Slide 3: Kiến Trúc Hệ Thống & Ma Trận Công Nghệ (1.5 phút)
* **Nội dung:** Layered Architecture, Laravel 12, PHP 8.2, MariaDB, Cloudinary SDK, Vite 7.
* **Lời nói:** *"Hệ thống áp dụng mô hình phân lớp rõ ràng. Tầng Controller được giữ siêu mỏng, toàn bộ nghiệp vụ phức tạp được đẩy vào Service Layer chuyên trách như CartService, CheckoutService, VirtualInventoryEngine, VNPayService. Cơ sở dữ liệu gồm 20 bảng chuẩn hóa 3NF bảo đảm toàn vẹn giao dịch ACID."*

### Slide 4: Điểm Sáng Tạo 1 — Động Cơ Tồn Kho Ảo & Bản Chụp Bất Biến (2 phút)
* **Nội dung:** Công thức $\min$ tồn kho linh kiện, giải thuật Cross-Demand Aggregator, Immutable Snapshot.
* **Lời nói:** *"Điểm sáng tạo cốt lõi đầu tiên của dự án là Động cơ Tồn kho Ảo Động. Các combo và hộp quà không lưu tồn kho cứng mà tính toán theo thời gian thực từ các linh kiện đơn lẻ. Khi khách mua combo và sản phẩm lẻ có chung linh kiện, hệ thống sẽ tổng hợp nhu cầu chéo và dùng Database Transaction khóa kho để bảo đảm không xảy ra tranh chấp. Đồng thời, mọi đơn hàng đều được chụp lại snapshot bất biến về sản phẩm, linh kiện và địa chỉ."*

### Slide 5: Điểm Sáng Tạo 2 — Tích Hợp VNPay Sandbox V2 & Zero-SSH Deployment (2 phút)
* **Nội dung:** Ký số HMAC-SHA512, Idempotent IPN, QueryDR đối soát, Refund API, Bộ ba Zero-SSH Automation.
* **Lời nói:** *"Hệ thống tích hợp cổng thanh toán VNPay Sandbox V2 toàn diện với cơ chế QueryDR đối soát trực tiếp với API VNPay khi khách quay về trình duyệt. Khi Admin hủy đơn hàng, hệ thống tự động kích hoạt hoàn tiền qua VNPay và tự động trả lại tồn kho linh kiện. Ngoài ra, nhóm đã phát triển bộ công cụ Zero-SSH độc đáo giúp đưa toàn bộ ứng dụng Laravel lên Shared Hosting InfinityFree mà không cần quyền SSH."*

### Slide 6: Kiểm Thử Tự Động & An Toàn Thông Tin (1.5 phút)
* **Nội dung:** 367 bài test tự động (100% Pass), bảo mật OWASP Top 10.
* **Lời nói:** *"Độ tin cậy của hệ thống được bảo chứng bằng bộ 367 bài kiểm thử tự động đạt tỷ lệ vượt qua 100%. Về an toàn thông tin, hệ thống tuân thủ nghiêm ngặt OWASP Top 10 với mật khẩu Bcrypt Cost 12, Rate Limiting chống Brute-force, phân quyền RBAC kép, kiểm soát IDOR bằng Policy và tự động sanitize mã độc XSS."*

### Slide 7: Chuyển Sang Phần Trình Diễn Hệ Thống Trực Tiếp (Live Demo) (1 phút)
* **Lời nói:** *"Sau đây, em xin phép kính mời quý Thầy Cô cùng theo dõi phần trình diễn trực tiếp các chức năng thực chiến của hệ thống trên môi trường máy chủ."*
* *(Thực hiện theo Kịch bản 8 bước tại File 03).*

### Slide 8: Kết Luận & Hướng Phát Triển (0.5 phút)
* **Lời nói:** *"Hệ thống Lunara Silver đã hoàn thành 100% mục tiêu đề ra và sẵn sàng cho việc đưa vào vận hành thương mại. Nhóm xin chân thành cảm ơn quý Thầy Cô đã lắng nghe và rất mong nhận được những ý kiến đóng góp quý báu!"*

---

## 4. BỘ CÂU HỎI PHẢN BIỆN TIÊU BIỂU CỦA HỘI ĐỒNG & GỢI Ý TRẢ LỜI

### Câu hỏi 1: Tại sao hệ thống không lưu số lượng tồn kho cứng cho Bộ sưu tập và Hộp quà tặng?
* **Gợi ý trả lời:** *"Thưa Thầy Cô, nếu lưu số lượng cứng cho combo (ví dụ: gán Set 1 có 10 bộ), trong khi linh kiện của Set 1 là chiếc Nhẫn NH001 cũng được bán lẻ độc lập. Khi khách hàng mua hết nhẫn NH001 trên catalog bán lẻ, nhưng Set 1 trong CSDL vẫn hiển thị còn 10 bộ. Điều này dẫn đến lỗi kinh doanh nghiêm trọng là bán khống hàng không có thật trong kho. Việc sử dụng Động cơ Tồn kho Ảo giúp hệ thống tính toán tức thời theo số lượng linh kiện thực tế, khi bất kỳ linh kiện nào hết hàng thì toàn bộ các combo chứa linh kiện đó lập tức chuyển sang hết hàng tự động."*

### Câu hỏi 2: Làm thế nào hệ thống chống được tình trạng hai khách hàng cùng đặt mua sản phẩm cuối cùng vào một thời điểm (Race Condition)?
* **Gợi ý trả lời:** *"Dạ thưa Thầy Cô, trong lớp `CheckoutService`, toàn bộ quá trình kiểm tra và trừ kho được đặt bên trong một `DB::transaction`. Hệ thống sử dụng kỹ thuật Pessimistic Locking với mệnh đề `lockForUpdate` trên các dòng bản ghi của sản phẩm linh kiện. Khi giao dịch của khách hàng thứ nhất đang xử lý, cơ sở dữ liệu sẽ khóa tạm thời các dòng dữ liệu đó, buộc giao dịch của khách hàng thứ hai phải chờ. Giao dịch sau khi đọc lại sẽ thấy tồn kho đã về 0 và thông báo hết hàng chính xác, ngăn chặn hoàn toàn race condition."*

### Câu hỏi 3: Nếu khách hàng giả mạo tham số URL trả về từ VNPay thì hệ thống xử lý như thế nào?
* **Gợi ý trả lời:** *"Thưa Thầy Cô, hệ thống áp dụng cơ chế phòng thủ 2 tầng: Thứ nhất, thẩm tra chữ ký số HMAC-SHA512 của tham số URL xem có khớp với Secret Key hay không. Thứ hai, điểm đặc biệt của Lunara Silver là tại Return URL, hệ thống không chỉ đọc tham số trình duyệt mà còn chủ động gọi API `QueryDR` sang máy chủ của VNPay để truy vấn trực tiếp trạng thái thật. Đồng thời, luồng webhook IPN độc lập từ server VNPay cũng thẩm tra và cập nhật trạng thái đơn hàng bất đồng bộ, bảo đảm tính toàn vẹn tuyệt đối."*

---

## 5. ĐÁNH GIÁ GIỚI HẠN & LỘ TRÌNH PHÁT TRIỂN TƯƠNG LAI (ROADMAP)

### 5.1 Giới Hạn Hiện Tại Của Hệ Thống
1. **Chưa tích hợp API Tính phí ship động theo tọa độ**: Hiện tại phí vận chuyển được áp dụng theo mức tiêu chuẩn (30.000đ) và miễn phí toàn quốc cho đơn từ 500.000đ trở lên. Chưa kết nối trực tiếp với API tính cước theo khoảng cách địa lý của Giao Hàng Nhanh (GHN) hay Giao Hàng Tiết Kiệm (GHTK).
2. **Chưa hỗ trợ Cổng thanh toán quốc tế**: Hiện tại cổng thanh toán trực tuyến tập trung vào thẻ ngân hàng nội địa và QR Code qua VNPay, chưa tích hợp Stripe hay PayPal cho khách hàng nước ngoài.

### 5.2 Lộ Trình Phát Triển Nâng Cấp (Phase Tiếp Theo)
* **Giai đoạn 1**: Xây dựng Ứng dụng Di động Native (Mobile App) cho iOS và Android sử dụng Flutter kết nối qua RESTful API của Laravel.
* **Giai đoạn 2**: Tích hợp Trí tuệ Nhân tạo (AI Recommendation Engine): Tự động phân tích hình dáng khuôn mặt và phong cách trang phục từ ảnh selfie của khách hàng để gợi ý mẫu dây chuyền và khuyên tai bạc phù hợp nhất.
* **Giai đoạn 3**: Tích hợp Hóa đơn Điện tử chuẩn Tổng cục Thuế Việt Nam (VNPT-Invoice / Viettel Sinvoice).

---

<p align="center">
  <strong>LUNARA SILVER — BẢO VỆ ĐỒ ÁN TỐT NGHIỆP XUẤT SẮC</strong><br>
  Tài liệu kỹ thuật và học thuật chuẩn mực, tự tin chinh phục Hội đồng chấm thi.
</p>
