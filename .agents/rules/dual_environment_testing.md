# Quy tắc kiểm thử đồng thời trên cả 2 môi trường: Local & Live

Từ Phase 13 trở đi, mọi thay đổi mã nguồn, tính năng mới hoặc sửa lỗi trong dự án Lunara Silver đều phải được thực hiện và kiểm thử trên cả hai môi trường:

## 1. Môi trường Local (Máy phát triển cá nhân)
- **Địa chỉ**: `http://127.0.0.1:8000`
- **Database**: MySQL cục bộ (`127.0.0.1:3306 / lunara_silver`)
- **Quy trình kiểm thử**:
  - Chạy `php artisan migrate` để đảm bảo migration cục bộ đồng bộ.
  - Chạy đầy đủ test suite: `php artisan test` (đảm bảo 100% test assertions pass).
  - Kiểm tra các file `.env`, cache `php artisan optimize:clear`.

## 2. Môi trường Live Demo (InfinityFree Hosting)
- **Địa chỉ**: `https://lunarasilver.infinityfreeapp.com/`
- **Database**: Remote MySQL InfinityFree (`if0_39011709_lunara_silver`)
- **Quy trình triển khai & kiểm thử**:
  - Tự động deploy code qua GitHub Actions (`.github/workflows/deploy.yml`) bằng FTP khi push lên nhánh `main`.
  - Thực thi đồng bộ và làm mới cache hosting thông qua URL: `https://lunarasilver.infinityfreeapp.com/sync_phase13.php` (hoặc script đồng bộ tương ứng).
  - Kiểm tra trực tiếp dữ liệu trên Live Host (kiểm tra status đơn hàng, payment attempts, return callback).
