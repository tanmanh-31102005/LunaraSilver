# 🚀 HƯỚNG DẪN CHẠY NHANH DỰ ÁN LUNARA SILVER (DƯỚI 60 GIÂY)

> **Dành cho Giảng viên, Hội đồng chấm đồ án hoặc người dùng mới muốn chạy ngay website trên máy tính cá nhân.**

---

## ⚡ 3 BƯỚC KHỞI CHẠY SIÊU TỐC

### Bước 1: Bật Cơ sở dữ liệu MySQL
* Mở phần mềm **XAMPP Control Panel** (hoặc **Laragon**).
* Nhấn nút **Start** tại dịch vụ **MySQL**.
* Mở trình duyệt truy cập `http://localhost/phpmyadmin`, tạo một Database mới có tên:
  * Tên Database: `lunara_silver`
  * Bảng mã (Collation): `utf8mb4_unicode_ci`

---

### Bước 2: Thiết lập Tự Động (Setup)
* Nhấp đúp chuột vào file:
  ```text
  setup.bat
  ```
* Hệ thống sẽ tự động cấu hình file `.env`, sinh khóa bảo mật, tạo Symbolic Link cho ảnh và hỏi bạn có muốn tự động tạo bảng CSDL không.
* Nhập `Y` để hệ thống tự động nạp toàn bộ 45 sản phẩm và cấu hình ban đầu.

> 💡 **Lưu ý về phiên bản PHP:**  
> Dự án yêu cầu **PHP 8.2 trở lên**. Nếu máy của bạn đang dùng XAMPP phiên bản cũ (PHP 8.0), file `setup.bat` sẽ hỏi và **tự động tải PHP 8.2 Portable chính thức (khoảng 32MB) về thư mục dự án**, bạn không cần phải gỡ cài đặt hay cấu hình lại máy tính!

---

### Bước 3: Khởi chạy Website
* Nhấp đúp chuột vào file:
  ```text
  start.bat
  ```
* Máy chủ web sẽ tự động chạy tại: **`http://127.0.0.1:8000`** và tự động mở trình duyệt sau 2 giây!

---

## 🔑 TÀI KHOẢN TRẢI NGHIỆM CÓ SẴN

| Vai trò | Email đăng nhập | Mật khẩu | Chức năng nổi bật |
| :--- | :--- | :---: | :--- |
| **Quản trị viên (Admin)** | `admin@lunarasilver.com` | `password` | Truy cập `/admin`, xem Doanh thu thuần, Customer 360, duyệt Review, quản lý Combo, Hủy đơn & Hoàn tiền VNPay tự động. |
| **Khách hàng thân thiết** | `customer@lunarasilver.com` | `password` | Xem lịch sử đơn hàng, gửi Đánh giá Người mua đã xác thực (Verified Buyer Review). |
| **Khách hàng mới** | `newuser@lunarasilver.com` | `password` | Thử nghiệm áp dụng mã giảm giá dành riêng cho đơn đầu tiên (`CHAOMUNG`). |

---

## 📚 TÀI LIỆU BÁO CÁO & HỌC THUẬT

Toàn bộ tài liệu chi tiết nằm trong thư mục [**`docs/`**](file:///d:/Lunara/docs/):
* [**`docs/final/Bao_cao_Do_An_Lunara_Silver_Hoan_Chinh_FinalVisual.pdf`**](file:///d:/Lunara/docs/final/Bao_cao_Do_An_Lunara_Silver_Hoan_Chinh_FinalVisual.pdf): Báo cáo tốt nghiệp hoàn chỉnh chuẩn in ấn.
* [**`docs/01_KIEN_TRUC_VA_HE_THONG_TOAN_DIEN.md`**](file:///d:/Lunara/docs/01_KIEN_TRUC_VA_HE_THONG_TOAN_DIEN.md): Tài liệu kiến trúc toàn diện, Use Case, ERD 20+ bảng và 12 Sequence Diagrams.
* [**`docs/03_SO_TAY_VAN_HANH_NGUOI_DUNG_VA_ADMIN.md`**](file:///d:/Lunara/docs/03_SO_TAY_VAN_HANH_NGUOI_DUNG_VA_ADMIN.md): Kịch bản Demo thực chiến 8 bước phục vụ bảo vệ đồ án.
