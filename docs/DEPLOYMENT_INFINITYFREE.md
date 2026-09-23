# Hướng dẫn Triển khai Lunara Silver lên InfinityFree Hosting

Tài liệu này hướng dẫn chi tiết cách đưa dự án **Lunara Silver** lên tên miền **`lunarasilver.infinityfreeapp.com`** (Tài khoản: `if0_42986888`) và quy trình tiếp tục phát triển tính năng song song trên máy tính cá nhân.

---

## I. Các tệp đã được chuẩn bị sẵn trong dự án

Hệ thống đã tự động tạo sẵn toàn bộ tài nguyên cần thiết trong thư mục gốc `d:\Lunara`:

| Tệp tin | Vị trí | Mục đích |
| :--- | :--- | :--- |
| **`lunara_silver_export.sql`** | `d:\Lunara\lunara_silver_export.sql` | Bản sao lưu toàn bộ cơ sở dữ liệu MySQL chuẩn UTF-8 (gồm 45 sản phẩm, danh mục, hình ảnh, tài khoản quản trị). Dùng để **Import vào phpMyAdmin**. |
| **`.htaccess`** | `d:\Lunara\.htaccess` | Cấu hình cho thư mục gốc `htdocs/`. Tự động chuyển hướng yêu cầu vào `public/` và **khóa an toàn** các file nhạy cảm (`.env`, `vendor/`, `app/`, `storage/`). |
| **`.env.production.example`** | `d:\Lunara\.env.production.example` | Mẫu cấu hình môi trường cho InfinityFree với `APP_KEY` nguyên bản, `APP_ENV=production`, `APP_DEBUG=false`. |
| **`public/build/`** | `d:\Lunara\public\build\` | Toàn bộ CSS, JS, Bootstrap Icons đã được biên dịch production bằng Vite (`npm run build`). |

---

## II. Hướng dẫn 4 bước triển khai thực tế

### Bước 1: Tạo Database và Import dữ liệu trên InfinityFree

1. Đăng nhập vào trang quản trị InfinityFree: [https://dash.infinityfree.com](https://dash.infinityfree.com)
2. Chọn tài khoản **`if0_42986888`** $\rightarrow$ Bấm nút **Control Panel** (hoặc vPanel).
3. Trong giao diện vPanel, tìm mục **Databases** $\rightarrow$ Chọn **MySQL Databases**:
   - Tại ô *Create New Database*, nhập tên (ví dụ: `lunara`) $\rightarrow$ Bấm **Create Database**.
   - Hệ thống sẽ tạo database có tên dạng: `if0_42986888_lunara`.
4. Nhìn sang bảng thông tin kết nối MySQL bên phải / phía trên, ghi lại:
   - **MySQL Hostname** (thường có dạng `sqlXXX.infinityfree.com` hoặc `sqlXXX.epizy.com`).
   - **MySQL Database Name** (`if0_42986888_lunara`).
   - **MySQL Username** (`if0_42986888`).
   - **MySQL Password** (chính là mật khẩu tài khoản hosting InfinityFree của bạn).
5. Quay lại danh sách database vừa tạo $\rightarrow$ Bấm vào nút **Admin** (hoặc mở **phpMyAdmin**):
   - Chọn database `if0_42986888_lunara` ở cột bên trái.
   - Chọn tab **Import** ở thanh menu trên cùng.
   - Nhấn **Choose File** $\rightarrow$ Chọn tệp `d:\Lunara\lunara_silver_export.sql`.
   - Giữ nguyên các tùy chọn mặc định $\rightarrow$ Kéo xuống dưới bấm nút **Go** (hoặc **Import**).
   - Đợi thông báo thành công màu xanh: *"Import has been successfully finished, XX queries executed"*.

---

### Bước 2: Chuẩn bị tệp cấu hình `.env` cho Hosting

1. Mở tệp `d:\Lunara\.env.production.example` trên máy tính.
2. Cập nhật thông số database bạn vừa lấy ở Bước 1:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=sqlXXX.infinityfree.com
   DB_PORT=3306
   DB_DATABASE=if0_42986888_lunara
   DB_USERNAME=if0_42986888
   DB_PASSWORD=MẬT_KHẨU_HOSTING_CỦA_BẠN
   ```
3. Lưu tệp này lại thành tên **`.env`** (để chuẩn bị upload lên thư mục `htdocs/`).

---

### Bước 3: Tải mã nguồn lên thư mục `htdocs/` của Hosting

#### Cách 1: Sử dụng FileZilla (Khuyên dùng - Ổn định nhất)
1. Tải và mở phần mềm **FileZilla Client**.
2. Lấy thông tin FTP trong trang quản trị InfinityFree (tab *FTP Details*):
   - **Host**: `ftpupload.net` (hoặc IP hiển thị trong trang).
   - **Username**: `if0_42986888`
   - **Password**: Mật khẩu hosting của bạn.
   - **Port**: `21`
   - Bấm **Quickconnect**.
3. Cột bên phải (Remote site): Mở thư mục **`htdocs/`**.
4. Cột bên trái (Local site): Mở thư mục **`d:\Lunara`**.
5. Chọn các thư mục và tệp sau để tải lên `htdocs/`:
   - `.htaccess` *(tệp vừa tạo ở thư mục gốc)*
   - `.env` *(tệp cấu hình production vừa sửa ở Bước 2)*
   - Thư mục: `app/`, `bootstrap/`, `config/`, `database/`, `media/`, `public/`, `resources/`, `routes/`, `storage/`, `vendor/`
6. **LƯU Ý CỰC KỲ QUAN TRỌNG - KHÔNG UPLOAD CÁC MỤC SAU**:
   - `node_modules/` *(hơn 20.000 file nặng không dùng trên host)*
   - `.git/` *(lịch sử git)*
   - `tests/` *(unit test)*
   - `lunara_silver_export.sql` *(file sql đã import xong, không để trên host)*

#### Cách 2: Nén ZIP và tải qua Online File Manager
1. Nếu dùng Online File Manager trên web, bạn có thể nén các thư mục trên thành 1 file zip.
2. Tải file zip vào `htdocs/` $\rightarrow$ Nhấp chuột phải chọn **Extract** $\rightarrow$ Xóa file zip sau khi giải nén xong.

---

### Bước 4: Kiểm tra nghiệm thu trên tên miền Live

Sau khi tải xong, truy cập: **`https://lunarasilver.infinityfreeapp.com`**

1. **Kiểm tra Storefront**:
   - Trang chủ hiển thị đầy đủ Hero banner 3 slide, logo Lunara Silver màu sắc nét.
   - Danh mục sản phẩm (Dây chuyền, Nhẫn, Vòng tay, Bộ sưu tập, Quà tặng).
   - Trang chi tiết sản phẩm, ảnh sản phẩm từ `media/` hiển thị sắc nét.
   - Thử thêm sản phẩm vào giỏ hàng và đặt hàng thử (COD).
2. **Kiểm tra Admin Dashboard**:
   - Truy cập `https://lunarasilver.infinityfreeapp.com/admin`
   - Đăng nhập bằng tài khoản Administrator:
     - **Email**: `admin@lunara.vn`
     - **Password**: `admin123` (hoặc mật khẩu admin bạn đã tạo)
   - Kiểm tra Bảng điều khiển, Sản phẩm, Danh mục và Quản lý đơn hàng.

---

## III. Quy trình tiếp tục phát triển các tính năng tiếp theo

Sau khi website đã online, bạn tiếp tục phát triển các phase tiếp theo theo chu trình:

1. **Lập trình tại máy local (`d:\Lunara`)**:
   - Mở IDE và tiếp tục làm việc cùng AI Assistant trên máy tính của bạn (`http://127.0.0.1:8000`).
   - Phát triển các tính năng mới: VNPay Gateway, Mã giảm giá (Coupons), Đánh giá sản phẩm (Reviews), Quản lý người dùng nâng cao.
   - Chạy test tự động bằng lệnh `php artisan test` để đảm bảo 100% test pass.
2. **Cập nhật lên Live Hosting**:
   - **Nếu chỉ sửa file PHP / Blade (code/giao diện)**: Dùng FileZilla upload đúng những file vừa sửa (ví dụ: `app/Http/Controllers/...` hoặc `resources/views/...`). Quá trình này chỉ mất 3 - 5 giây!
   - **Nếu có sửa file CSS / JS**: Chạy lệnh `npm run build` ở máy local, sau đó upload thư mục `public/build/` lên host.
   - **Nếu có Migration cơ sở dữ liệu mới**: Chạy câu lệnh SQL bổ sung vào phpMyAdmin trên vPanel.
