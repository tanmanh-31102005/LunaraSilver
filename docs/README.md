# 📚 LUNARA SILVER — TRUNG TÂM TÀI LIỆU KỸ THUẬT & HỆ THỐNG
## HỆ THỐNG TÀI LIỆU CHUẨN MỰC DÀNH CHO NHÀ PHÁT TRIỂN, QUẢN TRỊ VIÊN & HỘI ĐỒNG ĐÁNH GIÁ

> Toàn bộ tài liệu của dự án **Lunara Silver** đã được chuẩn hóa, tinh gọn và phân loại khoa học thành **5 Bộ Tài liệu Cốt lõi** được đánh số thứ tự từ `01` đến `05`. Bạn có thể dễ dàng tra cứu toàn bộ thông tin về kiến trúc phần mềm, hướng dẫn cài đặt, vận hành và chuẩn bị bảo vệ đồ án một cách nhanh chóng nhất.

---

## 🗺️ BẢN ĐỒ TRA CỨU NHANH (DOCUMENTATION SITEMAP)

| Thứ Tự | Tên Tập Tin Tài Liệu | Nội Dung Chuyên Sâu Chính | Đối Tượng Độc Giả Phù Hợp |
| :---: | :--- | :--- | :--- |
| **01** | [**`01_KIEN_TRUC_VA_HE_THONG_TOAN_DIEN.md`**](file:///d:/Lunara/docs/01_KIEN_TRUC_VA_HE_THONG_TOAN_DIEN.md) | **Tài liệu kiến trúc số 1**: Mô hình phân tầng (Layered Architecture), Sơ đồ Use Case, Sơ đồ Thực thể Quan hệ (ERD 20+ bảng), Nguyên tắc Bản chụp Bất biến (Immutable Snapshot), Động cơ Tồn kho Ảo (Virtual Inventory), Cổng VNPay Sandbox V2, 12 Sơ đồ Tuần tự (Sequence Diagrams) bằng Mermaid, Bản đồ Mã nguồn. | Kiến trúc sư hệ thống, Lập trình viên Backend, Giảng viên chấm cấu trúc hệ thống. |
| **02** | [**`02_HUONG_DAN_CAI_DAT_VA_TRIEN_KHAI.md`**](file:///d:/Lunara/docs/02_HUONG_DAN_CAI_DAT_VA_TRIEN_KHAI.md) | **Cẩm nang cài đặt & triển khai**: Hướng dẫn chạy 1-Click trên Windows với bộ công cụ `setup.bat` và `start.bat`, cấu hình PHP 8.2 Portable, hướng dẫn chi tiết file `.env`, quy trình build Vite 7, hướng dẫn triển khai lên Shared Hosting không cần SSH (InfinityFree / cPanel Zero-SSH Suite), sao lưu & phục hồi thảm họa. | Người cài đặt thử nghiệm, Kỹ sư DevOps, Quản trị hệ thống máy chủ. |
| **03** | [**`03_SO_TAY_VAN_HANH_NGUOI_DUNG_VA_ADMIN.md`**](file:///d:/Lunara/docs/03_SO_TAY_VAN_HANH_NGUOI_DUNG_VA_ADMIN.md) | **Sổ tay vận hành thực tế**: Cẩm nang khách hàng (Catalog, bộ lọc đá quý, thiệp quà tặng, Mini Cart trượt, coupon, VNPay Sandbox, review Verified Buyer, live chat Concierge, phím tắt Ctrl+K). Cẩm nang Admin (Dashboard Doanh thu thuần Net Revenue, quản lý combo, ảnh Cloudinary, máy trạng thái đơn hàng, hoàn tiền tự động, Customer 360). **Kịch bản Demo thực chiến 8 bước**. | Khách hàng trải nghiệm, Quản trị viên kinh doanh, Sinh viên chuẩn bị Demo đồ án. |
| **04** | [**`04_KIEM_THU_BAO_MAT_VA_CONG_NGHE.md`**](file:///d:/Lunara/docs/04_KIEM_THU_BAO_MAT_VA_CONG_NGHE.md) | **Kiểm thử, bảo mật & công nghệ**: Ma trận công nghệ đóng băng (`composer.lock`, `package.json`), Báo cáo nghiệm thu **Bộ 367 bài kiểm thử tự động (100% Pass)**, Kiến trúc an toàn thông tin phòng thủ đa tầng OWASP Top 10 (Bcrypt Cost 12, Rate Limit Brute-Force, RBAC kép, IDOR OrderPolicy, XSS Whitelist, CSRF Tokens), Tối ưu Eager Loading O(1) và SEO Microdata JSON-LD. | Kỹ sư QA/QC, Chuyên viên An toàn thông tin, Người đánh giá chất lượng mã nguồn. |
| **05** | [**`05_HO_SO_DO_AN_VA_BAO_VE.md`**](file:///d:/Lunara/docs/05_HO_SO_DO_AN_VA_BAO_VE.md) | **Hồ sơ bảo vệ tốt nghiệp**: Bảng ánh xạ đối soát 8 Chuẩn đầu ra môn học/đồ án (CLO 1 đến CLO 8), Tổng hợp 6 điểm sáng tạo độc quyền, Kịch bản thuyết trình bảo vệ từng slide (Slide-by-slide script), Bộ câu hỏi phản biện tiêu biểu và gợi ý trả lời xuất sắc, Đánh giá giới hạn và lộ trình phát triển. | Sinh viên bảo vệ đồ án, Hội đồng chấm thi, Chuyên gia đánh giá đồ án tốt nghiệp. |

---

## 📊 CÁC TÀI LIỆU DỮ LIỆU ĐÍNH KÈM (DATA SHEETS)

* [**`ProductData.xlsx`**](file:///d:/Lunara/docs/ProductData.xlsx): Bảng tính Excel chuẩn hóa toàn bộ thông số kỹ thuật, giá bán và cấu hình linh kiện của 45 sản phẩm thực tế trong hệ thống.
* [**`VNPay_Sandbox_Test_Cards_Full.xlsx`**](file:///d:/Lunara/docs/VNPay_Sandbox_Test_Cards_Full.xlsx): Bảng danh mục các thẻ ngân hàng thử nghiệm (NCB, Agribank, Vietinbank...) và mã OTP dùng để test thanh toán VNPay Sandbox.

---

## 🏆 CÁC TẬP TIN BÁO CÁO HOÀN CHỈNH (DELIVERABLES)

Thư mục [**`docs/final/`**](file:///d:/Lunara/docs/final/) chứa bộ tài liệu báo cáo tốt nghiệp chính thức:
* [**`Bao_cao_Do_An_Lunara_Silver_Hoan_Chinh_FinalVisual.docx`**](file:///d:/Lunara/docs/final/Bao_cao_Do_An_Lunara_Silver_Hoan_Chinh_FinalVisual.docx): Tập tin Microsoft Word hoàn chỉnh (14.6 MB) với đầy đủ sơ đồ visual độ phân giải cao và bảng biểu căn lề A4 chuẩn mực.
* [**`Bao_cao_Do_An_Lunara_Silver_Hoan_Chinh_FinalVisual.pdf`**](file:///d:/Lunara/docs/final/Bao_cao_Do_An_Lunara_Silver_Hoan_Chinh_FinalVisual.pdf): Tập tin PDF xuất bản chính thức (7.58 MB) sẵn sàng in ấn và nộp cho nhà trường.
* [**`docs/final/assets/`**](file:///d:/Lunara/docs/final/assets/): Toàn bộ hình ảnh sơ đồ kiến trúc, sequence diagrams và ảnh chụp giao diện chất lượng cao.

---

## 🚀 HƯỚNG DẪN ĐỌC THEO TỪNG NHU CẦU

```text
[BẠN LÀ AI?]
    │
    ├── 1. "Tôi muốn chạy thử ngay dự án trên máy tính"
    │       └── Xem: 02_HUONG_DAN_CAI_DAT_VA_TRIEN_KHAI.md (Mục 2: Chạy 1-Click)
    │
    ├── 2. "Tôi muốn hiểu sâu kiến trúc, ERD và luồng dữ liệu"
    │       └── Xem: 01_KIEN_TRUC_VA_HE_THONG_TOAN_DIEN.md
    │
    ├── 3. "Tôi sắp lên thuyết trình bảo vệ đồ án trước Hội đồng"
    │       └── Xem: 05_HO_SO_DO_AN_VA_BAO_VE.md & 03_SO_TAY_VAN_HANH_NGUOI_DUNG_VA_ADMIN.md (Mục 4)
    │
    ├── 4. "Tôi muốn nghiệm thu kiểm thử tự động và bảo mật"
    │       └── Xem: 04_KIEM_THU_BAO_MAT_VA_CONG_NGHE.md
    │
    └── 5. "Tôi muốn nộp file báo cáo đồ án hoàn chỉnh"
            └── Mở: docs/final/Bao_cao_Do_An_Lunara_Silver_Hoan_Chinh_FinalVisual.pdf
```
