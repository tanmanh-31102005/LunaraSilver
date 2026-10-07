# LUNARA SILVER — QUY TRÌNH SAO LƯU & KHÔI PHỤC THẢM HỌA (BACKUP & DISASTER RECOVERY)

Tài liệu hướng dẫn quy trình vận hành an toàn cho hệ thống thương mại điện tử **Lunara Silver** (áp dụng cho môi trường Production / InfinityFree và Staging/Local).

---

## 1. SAO LƯU CƠ SỞ DỮ LIỆU (DATABASE BACKUP)

### A. Tần suất khuyến nghị
- **Sao lưu tự động/định kỳ**: Hàng ngày lúc 01:00 AM (giờ ít traffic).
- **Sao lưu thủ công**: Bắt buộc thực hiện trước mỗi đợt deploy/migration lớn.

### B. Lệnh trích xuất qua CLI (MySQL / MariaDB)
```bash
# Trích xuất toàn bộ schema và dữ liệu (bảo toàn UTF-8mb4 và transaction)
mysqldump -u <db_user> -p<db_password> \
  --host=<db_host> \
  --single-transaction \
  --quick \
  --default-character-set=utf8mb4 \
  --routines \
  --triggers \
  <database_name> > lunara_backup_$(date +\%Y\%m\%d_\%H\%M\%S).sql
```

### C. Sao lưu qua giao diện phpMyAdmin (Dành cho InfinityFree / Shared Hosting)
1. Truy cập **Control Panel** $\rightarrow$ **phpMyAdmin**.
2. Chọn cơ sở dữ liệu `if0_42986888_lunara`.
3. Nhấp tab **Export (Xuất)**.
4. Chọn phương thức **Custom (Tùy chỉnh)**:
   - Tables: Chọn tất cả các bảng.
   - Output: Lưu file dưới định dạng `gzipped` hoặc `.sql`.
   - Object creation options: Tích chọn `Add DROP TABLE / VIEW / PROCEDURE / FUNCTION / EVENT`.
5. Bấm **Export** và lưu trữ file `.sql.gz` an toàn trên ổ đĩa mã hóa hoặc cloud nội bộ.

### D. Quy trình khôi phục (Database Restore)
```bash
mysql -u <db_user> -p<db_password> --host=<db_host> <database_name> < lunara_backup_YYYYMMDD.sql
```

---

## 2. BẢO MẬT BIẾN MÔI TRƯỜNG (.ENV & SECRETS)

### A. Nguyên tắc bất di bất dịch
- **Tuyệt đối không commit `.env` vào Git repository.**
- Tệp `.gitignore` luôn chứa `.env`, `.env.backup`, `.env.production`.
- Các API Keys quan trọng:
  - `VNPAY_HASH_SECRET`, `VNPAY_TMN_CODE`
  - `CLOUDINARY_URL`, `CLOUDINARY_API_SECRET`
  - `MAIL_PASSWORD` (Google App Password)
  - `DB_PASSWORD`

### B. Lưu trữ dự phòng khóa bảo mật
- Bản sao lưu `.env` của Production được mã hóa bằng GPG/KeePass/1Password nội bộ của quản trị viên.
- Khi có bất kỳ nghi vấn rò rỉ nào, quản trị viên tiến hành **Rotate Secrets** ngay lập tức (đổi key trên cổng VNPay, Cloudinary và App Password của Gmail).

---

## 3. TÀI NGUYÊN HÌNH ẢNH & MEDIA NGOÀI (CLOUDINARY & ASSETS)

- **Cloudinary Assets**: Hình ảnh trang sức và review media khách hàng được lưu trữ an toàn trên CDN toàn cầu của Cloudinary với backup phân tán.
- **Local Fallback Assets**: Thư mục `media/` và `public/media-previews/` trên mã nguồn Git chứa sẵn bộ banner gốc (`banner.jpg`, `banner2.jpg`, `banner3.jpg`, `hero.webp`) để làm fallback an toàn trong trường hợp CDN gặp sự cố.

---

## 4. QUẢN LÝ MÃ NGUỒN GIT (GIT SOURCE CODE)

- Toàn bộ lịch sử phát triển qua các Phase 1–23 được gắn tag cụ thể.
- Kiểm tra thường xuyên bằng `git status` và các công cụ audit secret để bảo đảm không có file tạm (`scratch/`, logs, database dump) bị đưa lên kho mã nguồn công khai.

---

## 5. KỊCH BẢN KHÔI PHỤC HỆ THỐNG TỪ ĐẦU (DISASTER RECOVERY RUNBOOK)

Khi toàn bộ server hosting gặp sự cố sập hoặc chuyển sang máy chủ mới:
1. **Clone mã nguồn**: `git clone <repo_url> htdocs`
2. **Cài đặt PHP Dependencies**: `composer install --no-dev --optimize-autoloader`
3. **Cài đặt Node Dependencies & Build**: `npm ci && npm run build`
4. **Cấu hình `.env`**: Khôi phục tệp `.env` sản xuất từ kho lưu trữ bảo mật.
5. **Khôi phục Database**: Import tệp dump SQL gần nhất vào MariaDB.
6. **Chạy Migration**: `php artisan migrate --force`
7. **Xóa & Tối ưu Cache**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
8. **Kiểm tra sức khỏe hệ thống**: Chạy kiểm tra `/up` và `diag.php` để xác nhận HTTP 200 OK.
