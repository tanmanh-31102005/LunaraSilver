-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 11, 2026 lúc 11:11 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `lunara_silver`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address_line` text NOT NULL,
  `ward` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `recipient_name`, `phone`, `address_line`, `ward`, `district`, `city`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nguyễn Tấn Mạnh', '0332247231', 'Đại học Tôn Đức Thắng', NULL, NULL, 'Hồ Chí Minh', 1, '2026-09-20 10:58:20', '2026-09-20 10:58:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `image_url` text NOT NULL,
  `cloudinary_public_id` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bundle_items`
--

CREATE TABLE `bundle_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bundle_product_id` bigint(20) UNSIGNED NOT NULL,
  `component_product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bundle_items`
--

INSERT INTO `bundle_items` (`id`, `bundle_product_id`, `component_product_id`, `quantity`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 31, 5, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(2, 31, 14, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(3, 31, 22, 1, 2, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(4, 32, 7, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(5, 32, 17, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(6, 32, 23, 1, 2, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(7, 33, 8, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(8, 33, 15, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(9, 33, 30, 1, 2, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(10, 34, 1, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(11, 34, 13, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(12, 34, 26, 1, 2, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(13, 35, 6, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(14, 35, 12, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(15, 35, 21, 1, 2, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(16, 36, 10, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(17, 36, 20, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(18, 36, 24, 1, 2, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(19, 37, 9, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(20, 37, 11, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(21, 37, 29, 1, 2, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(22, 38, 4, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(23, 38, 16, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(24, 38, 25, 1, 2, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(25, 39, 2, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(26, 39, 18, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(27, 39, 28, 1, 2, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(28, 40, 3, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(29, 40, 17, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(30, 40, 27, 1, 2, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(31, 41, 1, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(32, 41, 15, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(33, 42, 27, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(34, 42, 12, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(35, 43, 9, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(36, 43, 29, 1, 1, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(37, 43, 20, 1, 2, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(38, 44, 8, 1, 0, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(41, 45, 19, 2, 0, '2026-09-22 06:38:57', '2026-09-22 06:38:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('lunara-silver-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:2;', 1791464755),
('lunara-silver-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1791464755;', 1791464755),
('lunara-silver-cache-admin.dashboard.attention_items', 'a:2:{i:0;a:8:{s:2:\"id\";s:14:\"pending_orders\";s:5:\"level\";s:7:\"warning\";s:5:\"title\";s:35:\"Đơn hàng mới chờ xác nhận\";s:5:\"count\";i:74;s:11:\"description\";s:72:\"Có 74 đơn hàng đang chờ duyệt xuất kho & xử lý đóng gói\";s:3:\"url\";s:55:\"http://127.0.0.1:8000/admin/orders?order_status=pending\";s:4:\"icon\";s:16:\"bi-clock-history\";s:11:\"badge_class\";s:20:\"bg-warning text-dark\";}i:1;a:8:{s:2:\"id\";s:18:\"unresolved_support\";s:5:\"level\";s:6:\"normal\";s:5:\"title\";s:38:\"Hỗ trợ khách hàng chưa xử lý\";s:5:\"count\";i:1;s:11:\"description\";s:57:\"Có 0 ticket liên hệ và 1 phiên live chat đang mở\";s:3:\"url\";s:35:\"http://127.0.0.1:8000/admin/support\";s:4:\"icon\";s:10:\"bi-headset\";s:11:\"badge_class\";s:17:\"bg-info text-dark\";}}', 1791464755),
('lunara-silver-cache-admin.dashboard.inventory_health.6', 'a:4:{s:9:\"threshold\";i:5;s:17:\"low_stock_singles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:20:\"out_of_stock_singles\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:16:\"troubled_bundles\";a:0:{}}', 1791464798),
('lunara-silver-cache-admin.dashboard.metrics.1788800400.1791392399', 'a:19:{s:11:\"net_revenue\";a:3:{s:7:\"current\";d:273490000;s:8:\"previous\";d:0;s:6:\"change\";N;}s:11:\"gross_sales\";a:3:{s:7:\"current\";d:335350000;s:8:\"previous\";d:0;s:6:\"change\";N;}s:13:\"refund_amount\";a:3:{s:7:\"current\";d:61860000;s:8:\"previous\";d:0;s:6:\"change\";N;}s:16:\"completed_orders\";a:3:{s:7:\"current\";i:256;s:8:\"previous\";i:0;s:6:\"change\";N;}s:3:\"aov\";a:3:{s:7:\"current\";d:1309960.94;s:8:\"previous\";d:0;s:6:\"change\";N;}s:10:\"units_sold\";a:3:{s:7:\"current\";i:958;s:8:\"previous\";i:0;s:6:\"change\";N;}s:13:\"new_customers\";a:3:{s:7:\"current\";i:40;s:8:\"previous\";i:27;s:6:\"change\";d:48.1;}s:15:\"total_customers\";i:105;s:14:\"total_products\";i:45;s:16:\"total_categories\";i:7;s:15:\"active_products\";i:45;s:12:\"total_orders\";i:520;s:14:\"pending_orders\";i:73;s:17:\"low_stock_singles\";i:0;s:20:\"refund_pending_count\";i:0;s:18:\"unresolved_support\";i:0;s:21:\"pending_reviews_count\";i:0;s:20:\"approved_reviews_avg\";d:0;s:19:\"low_stock_threshold\";i:5;}', 1791383297),
('lunara-silver-cache-admin.dashboard.metrics.1788886800.1791478799', 'a:19:{s:11:\"net_revenue\";a:3:{s:7:\"current\";d:273490000;s:8:\"previous\";d:0;s:6:\"change\";N;}s:11:\"gross_sales\";a:3:{s:7:\"current\";d:335350000;s:8:\"previous\";d:0;s:6:\"change\";N;}s:13:\"refund_amount\";a:3:{s:7:\"current\";d:61860000;s:8:\"previous\";d:0;s:6:\"change\";N;}s:16:\"completed_orders\";a:3:{s:7:\"current\";i:256;s:8:\"previous\";i:0;s:6:\"change\";N;}s:3:\"aov\";a:3:{s:7:\"current\";d:1309960.94;s:8:\"previous\";d:0;s:6:\"change\";N;}s:10:\"units_sold\";a:3:{s:7:\"current\";i:958;s:8:\"previous\";i:0;s:6:\"change\";N;}s:13:\"new_customers\";a:3:{s:7:\"current\";i:39;s:8:\"previous\";i:28;s:6:\"change\";d:39.3;}s:15:\"total_customers\";i:105;s:14:\"total_products\";i:45;s:16:\"total_categories\";i:7;s:15:\"active_products\";i:45;s:12:\"total_orders\";i:521;s:14:\"pending_orders\";i:74;s:17:\"low_stock_singles\";i:0;s:20:\"refund_pending_count\";i:0;s:18:\"unresolved_support\";i:0;s:21:\"pending_reviews_count\";i:0;s:20:\"approved_reviews_avg\";d:0;s:19:\"low_stock_threshold\";i:5;}', 1791464798),
('lunara-silver-cache-admin.dashboard.orders_status.1788800400.1791392399', 'a:6:{s:7:\"pending\";a:2:{s:5:\"label\";s:17:\"Chờ xác nhận\";s:5:\"count\";i:73;}s:9:\"confirmed\";a:2:{s:5:\"label\";s:16:\"Đã xác nhận\";s:5:\"count\";i:0;}s:10:\"processing\";a:2:{s:5:\"label\";s:14:\"Đang xử lý\";s:5:\"count\";i:104;}s:8:\"shipping\";a:2:{s:5:\"label\";s:16:\"Đang giao hàng\";s:5:\"count\";i:0;}s:9:\"completed\";a:2:{s:5:\"label\";s:12:\"Hoàn thành\";s:5:\"count\";i:256;}s:9:\"cancelled\";a:2:{s:5:\"label\";s:10:\"Đã hủy\";s:5:\"count\";i:87;}}', 1791383237),
('lunara-silver-cache-admin.dashboard.orders_status.1788886800.1791478799', 'a:6:{s:7:\"pending\";a:2:{s:5:\"label\";s:17:\"Chờ xác nhận\";s:5:\"count\";i:74;}s:9:\"confirmed\";a:2:{s:5:\"label\";s:16:\"Đã xác nhận\";s:5:\"count\";i:0;}s:10:\"processing\";a:2:{s:5:\"label\";s:14:\"Đang xử lý\";s:5:\"count\";i:104;}s:8:\"shipping\";a:2:{s:5:\"label\";s:16:\"Đang giao hàng\";s:5:\"count\";i:0;}s:9:\"completed\";a:2:{s:5:\"label\";s:12:\"Hoàn thành\";s:5:\"count\";i:256;}s:9:\"cancelled\";a:2:{s:5:\"label\";s:10:\"Đã hủy\";s:5:\"count\";i:87;}}', 1791464815),
('lunara-silver-cache-admin.dashboard.payment.1788800400.1791392399', 'a:3:{s:3:\"cod\";a:3:{s:5:\"label\";s:15:\"Thanh toán COD\";s:12:\"orders_count\";i:166;s:12:\"total_amount\";d:221860000;}s:13:\"bank_transfer\";a:3:{s:5:\"label\";s:28:\"Chuyển khoản ngân hàng\";s:12:\"orders_count\";i:184;s:12:\"total_amount\";d:237990000;}s:5:\"vnpay\";a:3:{s:5:\"label\";s:12:\"VNPay Online\";s:12:\"orders_count\";i:170;s:12:\"total_amount\";d:229400000;}}', 1791383237),
('lunara-silver-cache-admin.dashboard.payment.1788886800.1791478799', 'a:3:{s:3:\"cod\";a:3:{s:5:\"label\";s:15:\"Thanh toán COD\";s:12:\"orders_count\";i:167;s:12:\"total_amount\";d:225650000;}s:13:\"bank_transfer\";a:3:{s:5:\"label\";s:28:\"Chuyển khoản ngân hàng\";s:12:\"orders_count\";i:184;s:12:\"total_amount\";d:237990000;}s:5:\"vnpay\";a:3:{s:5:\"label\";s:12:\"VNPay Online\";s:12:\"orders_count\";i:170;s:12:\"total_amount\";d:229400000;}}', 1791464815);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('lunara-silver-cache-admin.dashboard.top_products.units.6.1788800400.1791392399', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:6:{i:0;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:8;s:12:\"product_name\";s:49:\"Dây chuyền Lunara Băng Tinh Nguyệt Khuyết\";s:11:\"product_sku\";s:9:\"LNS-DC008\";s:10:\"units_sold\";s:2:\"43\";s:13:\"total_revenue\";s:11:\"16340000.00\";s:12:\"total_orders\";i:28;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:8;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC008\";s:4:\"name\";s:49:\"Dây chuyền Lunara Băng Tinh Nguyệt Khuyết\";s:4:\"slug\";s:41:\"day-chuyen-lunara-bang-tinh-nguyet-khuyet\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:54:\"Trăng khuyết với tinh thể đá trong như băng\";s:11:\"description\";s:218:\"Vầng trăng khuyết nạm đá với một cụm đá nhỏ ở một góc, tượng trưng cho một vầng trăng được hình thành từ các tinh thể đá moissanite trong suốt và sắc sảo như băng.\";s:13:\"regular_price\";s:9:\"440000.00\";s:10:\"sale_price\";s:9:\"380000.00\";s:14:\"stock_quantity\";i:23;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:32:\"Bạc 925 đính đá Moissanite\";s:5:\"stone\";s:10:\"Moissanite\";s:6:\"weight\";s:4:\"2.7g\";s:9:\"size_info\";s:4:\"42cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 15:54:09\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:8;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC008\";s:4:\"name\";s:49:\"Dây chuyền Lunara Băng Tinh Nguyệt Khuyết\";s:4:\"slug\";s:41:\"day-chuyen-lunara-bang-tinh-nguyet-khuyet\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:54:\"Trăng khuyết với tinh thể đá trong như băng\";s:11:\"description\";s:218:\"Vầng trăng khuyết nạm đá với một cụm đá nhỏ ở một góc, tượng trưng cho một vầng trăng được hình thành từ các tinh thể đá moissanite trong suốt và sắc sảo như băng.\";s:13:\"regular_price\";s:9:\"440000.00\";s:10:\"sale_price\";s:9:\"380000.00\";s:14:\"stock_quantity\";i:23;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:32:\"Bạc 925 đính đá Moissanite\";s:5:\"stone\";s:10:\"Moissanite\";s:6:\"weight\";s:4:\"2.7g\";s:9:\"size_info\";s:4:\"42cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 15:54:09\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:8;s:10:\"product_id\";i:8;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc008.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:8;s:10:\"product_id\";i:8;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc008.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:8;s:12:\"product_name\";s:49:\"Dây chuyền Lunara Băng Tinh Nguyệt Khuyết\";s:11:\"product_sku\";s:9:\"LNS-DC008\";s:10:\"units_sold\";s:2:\"43\";s:13:\"total_revenue\";s:11:\"16340000.00\";s:12:\"total_orders\";i:28;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:3;s:12:\"product_name\";s:35:\"Dây chuyền Lunara Ái Tinh Hồn\";s:11:\"product_sku\";s:9:\"LNS-DC003\";s:10:\"units_sold\";s:2:\"39\";s:13:\"total_revenue\";s:11:\"14430000.00\";s:12:\"total_orders\";i:26;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:3;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC003\";s:4:\"name\";s:35:\"Dây chuyền Lunara Ái Tinh Hồn\";s:4:\"slug\";s:29:\"day-chuyen-lunara-ai-tinh-hon\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:43:\"Trái tim đính đá Moissanite rực rỡ\";s:11:\"description\";s:212:\"Kết hợp hình ảnh trái tim nạm đá lấp lánh với viên đá moissanite lớn ở trung tâm, tượng trưng cho tâm hồn tinh khiết và tình yêu cháy bỏng, rực rỡ như một ngôi sao.\";s:13:\"regular_price\";s:9:\"420000.00\";s:10:\"sale_price\";s:9:\"370000.00\";s:14:\"stock_quantity\";i:21;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:32:\"Bạc 925 đính đá Moissanite\";s:5:\"stone\";s:10:\"Moissanite\";s:6:\"weight\";s:4:\"3.0g\";s:9:\"size_info\";s:4:\"44cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-21 04:21:15\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:3;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC003\";s:4:\"name\";s:35:\"Dây chuyền Lunara Ái Tinh Hồn\";s:4:\"slug\";s:29:\"day-chuyen-lunara-ai-tinh-hon\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:43:\"Trái tim đính đá Moissanite rực rỡ\";s:11:\"description\";s:212:\"Kết hợp hình ảnh trái tim nạm đá lấp lánh với viên đá moissanite lớn ở trung tâm, tượng trưng cho tâm hồn tinh khiết và tình yêu cháy bỏng, rực rỡ như một ngôi sao.\";s:13:\"regular_price\";s:9:\"420000.00\";s:10:\"sale_price\";s:9:\"370000.00\";s:14:\"stock_quantity\";i:21;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:32:\"Bạc 925 đính đá Moissanite\";s:5:\"stone\";s:10:\"Moissanite\";s:6:\"weight\";s:4:\"3.0g\";s:9:\"size_info\";s:4:\"44cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-21 04:21:15\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:3;s:10:\"product_id\";i:3;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc003.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:3;s:10:\"product_id\";i:3;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc003.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:3;s:12:\"product_name\";s:35:\"Dây chuyền Lunara Ái Tinh Hồn\";s:11:\"product_sku\";s:9:\"LNS-DC003\";s:10:\"units_sold\";s:2:\"39\";s:13:\"total_revenue\";s:11:\"14430000.00\";s:12:\"total_orders\";i:26;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:16;s:12:\"product_name\";s:26:\"Nhẫn Lunara Quỹ Đạo\";s:11:\"product_sku\";s:9:\"LNS-NH006\";s:10:\"units_sold\";s:2:\"37\";s:13:\"total_revenue\";s:10:\"8880000.00\";s:12:\"total_orders\";i:25;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:16;s:11:\"category_id\";i:2;s:3:\"sku\";s:9:\"LNS-NH006\";s:4:\"name\";s:26:\"Nhẫn Lunara Quỹ Đạo\";s:4:\"slug\";s:19:\"nhan-lunara-quy-dao\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:43:\"Đai kép vắt chéo như quỹ đạo sao\";s:11:\"description\";s:177:\"Thiết kế nhẫn đai kép vắt chéo nhau tựa như quỹ đạo của các vì sao xoay quanh mặt trăng, thể hiện một nét đẹp hiện đại và độc đáo.\";s:13:\"regular_price\";s:9:\"280000.00\";s:10:\"sale_price\";s:9:\"240000.00\";s:14:\"stock_quantity\";i:32;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:9:\"Bạc 925\";s:5:\"stone\";s:1:\"-\";s:6:\"weight\";s:4:\"2.1g\";s:9:\"size_info\";s:9:\"Free size\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:16;s:11:\"category_id\";i:2;s:3:\"sku\";s:9:\"LNS-NH006\";s:4:\"name\";s:26:\"Nhẫn Lunara Quỹ Đạo\";s:4:\"slug\";s:19:\"nhan-lunara-quy-dao\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:43:\"Đai kép vắt chéo như quỹ đạo sao\";s:11:\"description\";s:177:\"Thiết kế nhẫn đai kép vắt chéo nhau tựa như quỹ đạo của các vì sao xoay quanh mặt trăng, thể hiện một nét đẹp hiện đại và độc đáo.\";s:13:\"regular_price\";s:9:\"280000.00\";s:10:\"sale_price\";s:9:\"240000.00\";s:14:\"stock_quantity\";i:32;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:9:\"Bạc 925\";s:5:\"stone\";s:1:\"-\";s:6:\"weight\";s:4:\"2.1g\";s:9:\"size_info\";s:9:\"Free size\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:16;s:10:\"product_id\";i:16;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/nh006.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:16;s:10:\"product_id\";i:16;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/nh006.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:16;s:12:\"product_name\";s:26:\"Nhẫn Lunara Quỹ Đạo\";s:11:\"product_sku\";s:9:\"LNS-NH006\";s:10:\"units_sold\";s:2:\"37\";s:13:\"total_revenue\";s:10:\"8880000.00\";s:12:\"total_orders\";i:25;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:15;s:12:\"product_name\";s:25:\"Nhẫn Lunara Tinh Thủy\";s:11:\"product_sku\";s:9:\"LNS-NH005\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"10080000.00\";s:12:\"total_orders\";i:22;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:15;s:11:\"category_id\";i:2;s:3:\"sku\";s:9:\"LNS-NH005\";s:4:\"name\";s:25:\"Nhẫn Lunara Tinh Thủy\";s:4:\"slug\";s:21:\"nhan-lunara-tinh-thuy\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:44:\"Đá ngọc bích trong trẻo cùng vì sao\";s:11:\"description\";s:197:\"Sự kết hợp giữa viên đá màu xanh ngọc bích trong trẻo như giọt nước (thủy) và các vì sao (tinh). Cảm giác mang lại sự chữa lành, thanh khiết và rạng rỡ.\";s:13:\"regular_price\";s:9:\"320000.00\";s:10:\"sale_price\";s:9:\"280000.00\";s:14:\"stock_quantity\";i:24;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:41:\"Bạc 925 đính đá Ngọc bích (Jade)\";s:5:\"stone\";s:17:\"Ngọc bích xanh\";s:6:\"weight\";s:4:\"2.0g\";s:9:\"size_info\";s:3:\"6-9\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-21 04:21:15\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:15;s:11:\"category_id\";i:2;s:3:\"sku\";s:9:\"LNS-NH005\";s:4:\"name\";s:25:\"Nhẫn Lunara Tinh Thủy\";s:4:\"slug\";s:21:\"nhan-lunara-tinh-thuy\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:44:\"Đá ngọc bích trong trẻo cùng vì sao\";s:11:\"description\";s:197:\"Sự kết hợp giữa viên đá màu xanh ngọc bích trong trẻo như giọt nước (thủy) và các vì sao (tinh). Cảm giác mang lại sự chữa lành, thanh khiết và rạng rỡ.\";s:13:\"regular_price\";s:9:\"320000.00\";s:10:\"sale_price\";s:9:\"280000.00\";s:14:\"stock_quantity\";i:24;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:41:\"Bạc 925 đính đá Ngọc bích (Jade)\";s:5:\"stone\";s:17:\"Ngọc bích xanh\";s:6:\"weight\";s:4:\"2.0g\";s:9:\"size_info\";s:3:\"6-9\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-21 04:21:15\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:15;s:10:\"product_id\";i:15;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/nh005.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:15;s:10:\"product_id\";i:15;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/nh005.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:15;s:12:\"product_name\";s:25:\"Nhẫn Lunara Tinh Thủy\";s:11:\"product_sku\";s:9:\"LNS-NH005\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"10080000.00\";s:12:\"total_orders\";i:22;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:7;s:12:\"product_name\";s:46:\"Dây chuyền Lunara Hạo Nguyệt Ôm Hừng\";s:11:\"product_sku\";s:9:\"LNS-DC007\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"14400000.00\";s:12:\"total_orders\";i:25;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:7;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC007\";s:4:\"name\";s:46:\"Dây chuyền Lunara Hạo Nguyệt Ôm Hừng\";s:4:\"slug\";s:36:\"day-chuyen-lunara-hao-nguyet-om-hung\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:50:\"Trăng khuyết ôm lấy ánh sáng hừng đông\";s:11:\"description\";s:243:\"\"Mặt trăng ôm lấy ánh sáng hừng đông\". Thiết kế vầng trăng khuyết nạm đá ôm lấy một viên đá moissanite cabochon lớn màu trắng mờ, gợi nhớ đến ánh trăng dịu dàng và tinh khiết như sương.\";s:13:\"regular_price\";s:9:\"460000.00\";s:10:\"sale_price\";s:9:\"400000.00\";s:14:\"stock_quantity\";i:20;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:41:\"Bạc 925 đính đá Moissanite cabochon\";s:5:\"stone\";s:23:\"Moissanite trắng mờ\";s:6:\"weight\";s:4:\"2.9g\";s:9:\"size_info\";s:4:\"43cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:7;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC007\";s:4:\"name\";s:46:\"Dây chuyền Lunara Hạo Nguyệt Ôm Hừng\";s:4:\"slug\";s:36:\"day-chuyen-lunara-hao-nguyet-om-hung\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:50:\"Trăng khuyết ôm lấy ánh sáng hừng đông\";s:11:\"description\";s:243:\"\"Mặt trăng ôm lấy ánh sáng hừng đông\". Thiết kế vầng trăng khuyết nạm đá ôm lấy một viên đá moissanite cabochon lớn màu trắng mờ, gợi nhớ đến ánh trăng dịu dàng và tinh khiết như sương.\";s:13:\"regular_price\";s:9:\"460000.00\";s:10:\"sale_price\";s:9:\"400000.00\";s:14:\"stock_quantity\";i:20;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:41:\"Bạc 925 đính đá Moissanite cabochon\";s:5:\"stone\";s:23:\"Moissanite trắng mờ\";s:6:\"weight\";s:4:\"2.9g\";s:9:\"size_info\";s:4:\"43cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:7;s:10:\"product_id\";i:7;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc007.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:7;s:10:\"product_id\";i:7;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc007.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:7;s:12:\"product_name\";s:46:\"Dây chuyền Lunara Hạo Nguyệt Ôm Hừng\";s:11:\"product_sku\";s:9:\"LNS-DC007\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"14400000.00\";s:12:\"total_orders\";i:25;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:24;s:12:\"product_name\";s:21:\"Vòng Lunara Tinh Tú\";s:11:\"product_sku\";s:9:\"LNS-VT004\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"10080000.00\";s:12:\"total_orders\";i:24;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:24;s:11:\"category_id\";i:3;s:3:\"sku\";s:9:\"LNS-VT004\";s:4:\"name\";s:21:\"Vòng Lunara Tinh Tú\";s:4:\"slug\";s:19:\"vong-lunara-tinh-tu\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:39:\"Một ngôi sao lớn làm tâm điểm\";s:11:\"description\";s:161:\"Tập trung vào một ngôi sao lớn, sắc nét làm tâm điểm, tỏa sáng rực rỡ và duy nhất, giống như ngôi sao dẫn đường Bắc Đẩu.\";s:13:\"regular_price\";s:9:\"330000.00\";s:10:\"sale_price\";s:9:\"280000.00\";s:14:\"stock_quantity\";i:24;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:37:\"Bạc 925 đính đá charm sao lớn\";s:5:\"stone\";s:2:\"CZ\";s:6:\"weight\";s:4:\"3.5g\";s:9:\"size_info\";s:7:\"16-18cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:24;s:11:\"category_id\";i:3;s:3:\"sku\";s:9:\"LNS-VT004\";s:4:\"name\";s:21:\"Vòng Lunara Tinh Tú\";s:4:\"slug\";s:19:\"vong-lunara-tinh-tu\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:39:\"Một ngôi sao lớn làm tâm điểm\";s:11:\"description\";s:161:\"Tập trung vào một ngôi sao lớn, sắc nét làm tâm điểm, tỏa sáng rực rỡ và duy nhất, giống như ngôi sao dẫn đường Bắc Đẩu.\";s:13:\"regular_price\";s:9:\"330000.00\";s:10:\"sale_price\";s:9:\"280000.00\";s:14:\"stock_quantity\";i:24;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:37:\"Bạc 925 đính đá charm sao lớn\";s:5:\"stone\";s:2:\"CZ\";s:6:\"weight\";s:4:\"3.5g\";s:9:\"size_info\";s:7:\"16-18cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:24;s:10:\"product_id\";i:24;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/vt004.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:24;s:10:\"product_id\";i:24;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/vt004.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:24;s:12:\"product_name\";s:21:\"Vòng Lunara Tinh Tú\";s:11:\"product_sku\";s:9:\"LNS-VT004\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"10080000.00\";s:12:\"total_orders\";i:24;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1791383417);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('lunara-silver-cache-admin.dashboard.top_products.units.6.1788886800.1791478799', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:6:{i:0;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:8;s:12:\"product_name\";s:49:\"Dây chuyền Lunara Băng Tinh Nguyệt Khuyết\";s:11:\"product_sku\";s:9:\"LNS-DC008\";s:10:\"units_sold\";s:2:\"43\";s:13:\"total_revenue\";s:11:\"16340000.00\";s:12:\"total_orders\";i:28;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:8;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC008\";s:4:\"name\";s:49:\"Dây chuyền Lunara Băng Tinh Nguyệt Khuyết\";s:4:\"slug\";s:41:\"day-chuyen-lunara-bang-tinh-nguyet-khuyet\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:54:\"Trăng khuyết với tinh thể đá trong như băng\";s:11:\"description\";s:218:\"Vầng trăng khuyết nạm đá với một cụm đá nhỏ ở một góc, tượng trưng cho một vầng trăng được hình thành từ các tinh thể đá moissanite trong suốt và sắc sảo như băng.\";s:13:\"regular_price\";s:9:\"440000.00\";s:10:\"sale_price\";s:9:\"380000.00\";s:14:\"stock_quantity\";i:23;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:32:\"Bạc 925 đính đá Moissanite\";s:5:\"stone\";s:10:\"Moissanite\";s:6:\"weight\";s:4:\"2.7g\";s:9:\"size_info\";s:4:\"42cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 15:54:09\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:8;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC008\";s:4:\"name\";s:49:\"Dây chuyền Lunara Băng Tinh Nguyệt Khuyết\";s:4:\"slug\";s:41:\"day-chuyen-lunara-bang-tinh-nguyet-khuyet\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:54:\"Trăng khuyết với tinh thể đá trong như băng\";s:11:\"description\";s:218:\"Vầng trăng khuyết nạm đá với một cụm đá nhỏ ở một góc, tượng trưng cho một vầng trăng được hình thành từ các tinh thể đá moissanite trong suốt và sắc sảo như băng.\";s:13:\"regular_price\";s:9:\"440000.00\";s:10:\"sale_price\";s:9:\"380000.00\";s:14:\"stock_quantity\";i:23;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:32:\"Bạc 925 đính đá Moissanite\";s:5:\"stone\";s:10:\"Moissanite\";s:6:\"weight\";s:4:\"2.7g\";s:9:\"size_info\";s:4:\"42cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 15:54:09\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:8;s:10:\"product_id\";i:8;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc008.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:8;s:10:\"product_id\";i:8;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc008.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:8;s:12:\"product_name\";s:49:\"Dây chuyền Lunara Băng Tinh Nguyệt Khuyết\";s:11:\"product_sku\";s:9:\"LNS-DC008\";s:10:\"units_sold\";s:2:\"43\";s:13:\"total_revenue\";s:11:\"16340000.00\";s:12:\"total_orders\";i:28;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:3;s:12:\"product_name\";s:35:\"Dây chuyền Lunara Ái Tinh Hồn\";s:11:\"product_sku\";s:9:\"LNS-DC003\";s:10:\"units_sold\";s:2:\"39\";s:13:\"total_revenue\";s:11:\"14430000.00\";s:12:\"total_orders\";i:26;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:3;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC003\";s:4:\"name\";s:35:\"Dây chuyền Lunara Ái Tinh Hồn\";s:4:\"slug\";s:29:\"day-chuyen-lunara-ai-tinh-hon\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:43:\"Trái tim đính đá Moissanite rực rỡ\";s:11:\"description\";s:212:\"Kết hợp hình ảnh trái tim nạm đá lấp lánh với viên đá moissanite lớn ở trung tâm, tượng trưng cho tâm hồn tinh khiết và tình yêu cháy bỏng, rực rỡ như một ngôi sao.\";s:13:\"regular_price\";s:9:\"420000.00\";s:10:\"sale_price\";s:9:\"370000.00\";s:14:\"stock_quantity\";i:17;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:32:\"Bạc 925 đính đá Moissanite\";s:5:\"stone\";s:10:\"Moissanite\";s:6:\"weight\";s:4:\"3.0g\";s:9:\"size_info\";s:4:\"44cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-10-08 20:00:18\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:3;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC003\";s:4:\"name\";s:35:\"Dây chuyền Lunara Ái Tinh Hồn\";s:4:\"slug\";s:29:\"day-chuyen-lunara-ai-tinh-hon\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:43:\"Trái tim đính đá Moissanite rực rỡ\";s:11:\"description\";s:212:\"Kết hợp hình ảnh trái tim nạm đá lấp lánh với viên đá moissanite lớn ở trung tâm, tượng trưng cho tâm hồn tinh khiết và tình yêu cháy bỏng, rực rỡ như một ngôi sao.\";s:13:\"regular_price\";s:9:\"420000.00\";s:10:\"sale_price\";s:9:\"370000.00\";s:14:\"stock_quantity\";i:17;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:32:\"Bạc 925 đính đá Moissanite\";s:5:\"stone\";s:10:\"Moissanite\";s:6:\"weight\";s:4:\"3.0g\";s:9:\"size_info\";s:4:\"44cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-10-08 20:00:18\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:3;s:10:\"product_id\";i:3;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc003.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:3;s:10:\"product_id\";i:3;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc003.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:3;s:12:\"product_name\";s:35:\"Dây chuyền Lunara Ái Tinh Hồn\";s:11:\"product_sku\";s:9:\"LNS-DC003\";s:10:\"units_sold\";s:2:\"39\";s:13:\"total_revenue\";s:11:\"14430000.00\";s:12:\"total_orders\";i:26;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:16;s:12:\"product_name\";s:26:\"Nhẫn Lunara Quỹ Đạo\";s:11:\"product_sku\";s:9:\"LNS-NH006\";s:10:\"units_sold\";s:2:\"37\";s:13:\"total_revenue\";s:10:\"8880000.00\";s:12:\"total_orders\";i:25;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:16;s:11:\"category_id\";i:2;s:3:\"sku\";s:9:\"LNS-NH006\";s:4:\"name\";s:26:\"Nhẫn Lunara Quỹ Đạo\";s:4:\"slug\";s:19:\"nhan-lunara-quy-dao\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:43:\"Đai kép vắt chéo như quỹ đạo sao\";s:11:\"description\";s:177:\"Thiết kế nhẫn đai kép vắt chéo nhau tựa như quỹ đạo của các vì sao xoay quanh mặt trăng, thể hiện một nét đẹp hiện đại và độc đáo.\";s:13:\"regular_price\";s:9:\"280000.00\";s:10:\"sale_price\";s:9:\"240000.00\";s:14:\"stock_quantity\";i:32;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:9:\"Bạc 925\";s:5:\"stone\";s:1:\"-\";s:6:\"weight\";s:4:\"2.1g\";s:9:\"size_info\";s:9:\"Free size\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:16;s:11:\"category_id\";i:2;s:3:\"sku\";s:9:\"LNS-NH006\";s:4:\"name\";s:26:\"Nhẫn Lunara Quỹ Đạo\";s:4:\"slug\";s:19:\"nhan-lunara-quy-dao\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:43:\"Đai kép vắt chéo như quỹ đạo sao\";s:11:\"description\";s:177:\"Thiết kế nhẫn đai kép vắt chéo nhau tựa như quỹ đạo của các vì sao xoay quanh mặt trăng, thể hiện một nét đẹp hiện đại và độc đáo.\";s:13:\"regular_price\";s:9:\"280000.00\";s:10:\"sale_price\";s:9:\"240000.00\";s:14:\"stock_quantity\";i:32;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:9:\"Bạc 925\";s:5:\"stone\";s:1:\"-\";s:6:\"weight\";s:4:\"2.1g\";s:9:\"size_info\";s:9:\"Free size\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:16;s:10:\"product_id\";i:16;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/nh006.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:16;s:10:\"product_id\";i:16;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/nh006.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:16;s:12:\"product_name\";s:26:\"Nhẫn Lunara Quỹ Đạo\";s:11:\"product_sku\";s:9:\"LNS-NH006\";s:10:\"units_sold\";s:2:\"37\";s:13:\"total_revenue\";s:10:\"8880000.00\";s:12:\"total_orders\";i:25;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:15;s:12:\"product_name\";s:25:\"Nhẫn Lunara Tinh Thủy\";s:11:\"product_sku\";s:9:\"LNS-NH005\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"10080000.00\";s:12:\"total_orders\";i:22;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:15;s:11:\"category_id\";i:2;s:3:\"sku\";s:9:\"LNS-NH005\";s:4:\"name\";s:25:\"Nhẫn Lunara Tinh Thủy\";s:4:\"slug\";s:21:\"nhan-lunara-tinh-thuy\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:44:\"Đá ngọc bích trong trẻo cùng vì sao\";s:11:\"description\";s:197:\"Sự kết hợp giữa viên đá màu xanh ngọc bích trong trẻo như giọt nước (thủy) và các vì sao (tinh). Cảm giác mang lại sự chữa lành, thanh khiết và rạng rỡ.\";s:13:\"regular_price\";s:9:\"320000.00\";s:10:\"sale_price\";s:9:\"280000.00\";s:14:\"stock_quantity\";i:24;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:41:\"Bạc 925 đính đá Ngọc bích (Jade)\";s:5:\"stone\";s:17:\"Ngọc bích xanh\";s:6:\"weight\";s:4:\"2.0g\";s:9:\"size_info\";s:3:\"6-9\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-21 04:21:15\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:15;s:11:\"category_id\";i:2;s:3:\"sku\";s:9:\"LNS-NH005\";s:4:\"name\";s:25:\"Nhẫn Lunara Tinh Thủy\";s:4:\"slug\";s:21:\"nhan-lunara-tinh-thuy\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:44:\"Đá ngọc bích trong trẻo cùng vì sao\";s:11:\"description\";s:197:\"Sự kết hợp giữa viên đá màu xanh ngọc bích trong trẻo như giọt nước (thủy) và các vì sao (tinh). Cảm giác mang lại sự chữa lành, thanh khiết và rạng rỡ.\";s:13:\"regular_price\";s:9:\"320000.00\";s:10:\"sale_price\";s:9:\"280000.00\";s:14:\"stock_quantity\";i:24;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:41:\"Bạc 925 đính đá Ngọc bích (Jade)\";s:5:\"stone\";s:17:\"Ngọc bích xanh\";s:6:\"weight\";s:4:\"2.0g\";s:9:\"size_info\";s:3:\"6-9\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-21 04:21:15\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:15;s:10:\"product_id\";i:15;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/nh005.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:15;s:10:\"product_id\";i:15;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/nh005.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:15;s:12:\"product_name\";s:25:\"Nhẫn Lunara Tinh Thủy\";s:11:\"product_sku\";s:9:\"LNS-NH005\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"10080000.00\";s:12:\"total_orders\";i:22;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:7;s:12:\"product_name\";s:46:\"Dây chuyền Lunara Hạo Nguyệt Ôm Hừng\";s:11:\"product_sku\";s:9:\"LNS-DC007\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"14400000.00\";s:12:\"total_orders\";i:25;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:7;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC007\";s:4:\"name\";s:46:\"Dây chuyền Lunara Hạo Nguyệt Ôm Hừng\";s:4:\"slug\";s:36:\"day-chuyen-lunara-hao-nguyet-om-hung\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:50:\"Trăng khuyết ôm lấy ánh sáng hừng đông\";s:11:\"description\";s:243:\"\"Mặt trăng ôm lấy ánh sáng hừng đông\". Thiết kế vầng trăng khuyết nạm đá ôm lấy một viên đá moissanite cabochon lớn màu trắng mờ, gợi nhớ đến ánh trăng dịu dàng và tinh khiết như sương.\";s:13:\"regular_price\";s:9:\"460000.00\";s:10:\"sale_price\";s:9:\"400000.00\";s:14:\"stock_quantity\";i:20;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:41:\"Bạc 925 đính đá Moissanite cabochon\";s:5:\"stone\";s:23:\"Moissanite trắng mờ\";s:6:\"weight\";s:4:\"2.9g\";s:9:\"size_info\";s:4:\"43cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:7;s:11:\"category_id\";i:1;s:3:\"sku\";s:9:\"LNS-DC007\";s:4:\"name\";s:46:\"Dây chuyền Lunara Hạo Nguyệt Ôm Hừng\";s:4:\"slug\";s:36:\"day-chuyen-lunara-hao-nguyet-om-hung\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:50:\"Trăng khuyết ôm lấy ánh sáng hừng đông\";s:11:\"description\";s:243:\"\"Mặt trăng ôm lấy ánh sáng hừng đông\". Thiết kế vầng trăng khuyết nạm đá ôm lấy một viên đá moissanite cabochon lớn màu trắng mờ, gợi nhớ đến ánh trăng dịu dàng và tinh khiết như sương.\";s:13:\"regular_price\";s:9:\"460000.00\";s:10:\"sale_price\";s:9:\"400000.00\";s:14:\"stock_quantity\";i:20;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:41:\"Bạc 925 đính đá Moissanite cabochon\";s:5:\"stone\";s:23:\"Moissanite trắng mờ\";s:6:\"weight\";s:4:\"2.9g\";s:9:\"size_info\";s:4:\"43cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:7;s:10:\"product_id\";i:7;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc007.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:7;s:10:\"product_id\";i:7;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/dc007.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:7;s:12:\"product_name\";s:46:\"Dây chuyền Lunara Hạo Nguyệt Ôm Hừng\";s:11:\"product_sku\";s:9:\"LNS-DC007\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"14400000.00\";s:12:\"total_orders\";i:25;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:20:\"App\\Models\\OrderItem\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:11:\"order_items\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:10:\"product_id\";i:24;s:12:\"product_name\";s:21:\"Vòng Lunara Tinh Tú\";s:11:\"product_sku\";s:9:\"LNS-VT004\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"10080000.00\";s:12:\"total_orders\";i:24;s:7:\"product\";O:18:\"App\\Models\\Product\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:24;s:11:\"category_id\";i:3;s:3:\"sku\";s:9:\"LNS-VT004\";s:4:\"name\";s:21:\"Vòng Lunara Tinh Tú\";s:4:\"slug\";s:19:\"vong-lunara-tinh-tu\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:39:\"Một ngôi sao lớn làm tâm điểm\";s:11:\"description\";s:161:\"Tập trung vào một ngôi sao lớn, sắc nét làm tâm điểm, tỏa sáng rực rỡ và duy nhất, giống như ngôi sao dẫn đường Bắc Đẩu.\";s:13:\"regular_price\";s:9:\"330000.00\";s:10:\"sale_price\";s:9:\"280000.00\";s:14:\"stock_quantity\";i:24;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:37:\"Bạc 925 đính đá charm sao lớn\";s:5:\"stone\";s:2:\"CZ\";s:6:\"weight\";s:4:\"3.5g\";s:9:\"size_info\";s:7:\"16-18cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:24;s:11:\"category_id\";i:3;s:3:\"sku\";s:9:\"LNS-VT004\";s:4:\"name\";s:21:\"Vòng Lunara Tinh Tú\";s:4:\"slug\";s:19:\"vong-lunara-tinh-tu\";s:12:\"product_type\";s:6:\"single\";s:17:\"short_description\";s:39:\"Một ngôi sao lớn làm tâm điểm\";s:11:\"description\";s:161:\"Tập trung vào một ngôi sao lớn, sắc nét làm tâm điểm, tỏa sáng rực rỡ và duy nhất, giống như ngôi sao dẫn đường Bắc Đẩu.\";s:13:\"regular_price\";s:9:\"330000.00\";s:10:\"sale_price\";s:9:\"280000.00\";s:14:\"stock_quantity\";i:24;s:12:\"stock_status\";s:8:\"in_stock\";s:8:\"material\";s:37:\"Bạc 925 đính đá charm sao lớn\";s:5:\"stone\";s:2:\"CZ\";s:6:\"weight\";s:4:\"3.5g\";s:9:\"size_info\";s:7:\"16-18cm\";s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:10:\"sold_count\";i:0;s:10:\"view_count\";i:0;s:9:\"seo_title\";N;s:15:\"seo_description\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:8:{s:13:\"regular_price\";s:9:\"decimal:2\";s:10:\"sale_price\";s:9:\"decimal:2\";s:14:\"stock_quantity\";s:7:\"integer\";s:11:\"is_featured\";s:7:\"boolean\";s:9:\"is_active\";s:7:\"boolean\";s:10:\"sold_count\";s:7:\"integer\";s:10:\"view_count\";s:7:\"integer\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"primaryImage\";O:23:\"App\\Models\\ProductImage\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"product_images\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:24;s:10:\"product_id\";i:24;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/vt004.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:24;s:10:\"product_id\";i:24;s:20:\"cloudinary_public_id\";N;s:9:\"image_url\";s:23:\"media/Product/vt004.jpg\";s:10:\"image_role\";s:7:\"primary\";s:10:\"sort_order\";i:0;s:8:\"alt_text\";N;s:10:\"created_at\";s:19:\"2026-09-20 09:51:03\";s:10:\"updated_at\";s:19:\"2026-09-20 09:51:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:10:\"sort_order\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:10:\"product_id\";i:1;s:20:\"cloudinary_public_id\";i:2;s:9:\"image_url\";i:3;s:10:\"image_role\";i:4;s:10:\"sort_order\";i:5;s:8:\"alt_text\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:11:\"category_id\";i:1;s:3:\"sku\";i:2;s:4:\"name\";i:3;s:4:\"slug\";i:4;s:12:\"product_type\";i:5;s:17:\"short_description\";i:6;s:11:\"description\";i:7;s:13:\"regular_price\";i:8;s:10:\"sale_price\";i:9;s:14:\"stock_quantity\";i:10;s:12:\"stock_status\";i:11;s:8:\"material\";i:12;s:5:\"stone\";i:13;s:6:\"weight\";i:14;s:9:\"size_info\";i:15;s:11:\"is_featured\";i:16;s:9:\"is_active\";i:17;s:10:\"sold_count\";i:18;s:10:\"view_count\";i:19;s:9:\"seo_title\";i:20;s:15:\"seo_description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:24:\"\0*\0memoizedRatingSummary\";N;s:16:\"\0*\0forceDeleting\";b:0;}s:9:\"is_active\";b:1;s:12:\"product_type\";s:6:\"single\";}s:11:\"\0*\0original\";a:6:{s:10:\"product_id\";i:24;s:12:\"product_name\";s:21:\"Vòng Lunara Tinh Tú\";s:11:\"product_sku\";s:9:\"LNS-VT004\";s:10:\"units_sold\";s:2:\"36\";s:13:\"total_revenue\";s:11:\"10080000.00\";s:12:\"total_orders\";i:24;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"unit_price\";s:9:\"decimal:2\";s:8:\"quantity\";s:7:\"integer\";s:8:\"subtotal\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:8:\"order_id\";i:1;s:10:\"product_id\";i:2;s:12:\"product_name\";i:3;s:11:\"product_sku\";i:4;s:10:\"unit_price\";i:5;s:8:\"quantity\";i:6;s:8:\"subtotal\";i:7;s:12:\"gift_message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1791465042),
('lunara-silver-cache-admin.dashboard.trend.30d.1788800400.1791392399', 'a:3:{s:6:\"labels\";a:30:{i:0;s:5:\"08/09\";i:1;s:5:\"09/09\";i:2;s:5:\"10/09\";i:3;s:5:\"11/09\";i:4;s:5:\"12/09\";i:5;s:5:\"13/09\";i:6;s:5:\"14/09\";i:7;s:5:\"15/09\";i:8;s:5:\"16/09\";i:9;s:5:\"17/09\";i:10;s:5:\"18/09\";i:11;s:5:\"19/09\";i:12;s:5:\"20/09\";i:13;s:5:\"21/09\";i:14;s:5:\"22/09\";i:15;s:5:\"23/09\";i:16;s:5:\"24/09\";i:17;s:5:\"25/09\";i:18;s:5:\"26/09\";i:19;s:5:\"27/09\";i:20;s:5:\"28/09\";i:21;s:5:\"29/09\";i:22;s:5:\"30/09\";i:23;s:5:\"01/10\";i:24;s:5:\"02/10\";i:25;s:5:\"03/10\";i:26;s:5:\"04/10\";i:27;s:5:\"05/10\";i:28;s:5:\"06/10\";i:29;s:5:\"07/10\";}s:11:\"net_revenue\";a:30:{i:0;d:0;i:1;d:0;i:2;d:0;i:3;d:0;i:4;d:0;i:5;d:0;i:6;d:0;i:7;d:0;i:8;d:0;i:9;d:0;i:10;d:0;i:11;d:0;i:12;d:1390000;i:13;d:1570000;i:14;d:0;i:15;d:0;i:16;d:0;i:17;d:0;i:18;d:0;i:19;d:0;i:20;d:0;i:21;d:0;i:22;d:0;i:23;d:0;i:24;d:0;i:25;d:0;i:26;d:0;i:27;d:0;i:28;d:0;i:29;d:270530000;}s:11:\"gross_sales\";a:30:{i:0;d:0;i:1;d:0;i:2;d:0;i:3;d:0;i:4;d:0;i:5;d:0;i:6;d:0;i:7;d:0;i:8;d:0;i:9;d:0;i:10;d:0;i:11;d:0;i:12;d:1390000;i:13;d:1570000;i:14;d:0;i:15;d:0;i:16;d:0;i:17;d:0;i:18;d:0;i:19;d:0;i:20;d:0;i:21;d:0;i:22;d:0;i:23;d:0;i:24;d:0;i:25;d:0;i:26;d:0;i:27;d:0;i:28;d:0;i:29;d:332390000;}}', 1791383297),
('lunara-silver-cache-admin.dashboard.trend.30d.1788886800.1791478799', 'a:3:{s:6:\"labels\";a:30:{i:0;s:5:\"09/09\";i:1;s:5:\"10/09\";i:2;s:5:\"11/09\";i:3;s:5:\"12/09\";i:4;s:5:\"13/09\";i:5;s:5:\"14/09\";i:6;s:5:\"15/09\";i:7;s:5:\"16/09\";i:8;s:5:\"17/09\";i:9;s:5:\"18/09\";i:10;s:5:\"19/09\";i:11;s:5:\"20/09\";i:12;s:5:\"21/09\";i:13;s:5:\"22/09\";i:14;s:5:\"23/09\";i:15;s:5:\"24/09\";i:16;s:5:\"25/09\";i:17;s:5:\"26/09\";i:18;s:5:\"27/09\";i:19;s:5:\"28/09\";i:20;s:5:\"29/09\";i:21;s:5:\"30/09\";i:22;s:5:\"01/10\";i:23;s:5:\"02/10\";i:24;s:5:\"03/10\";i:25;s:5:\"04/10\";i:26;s:5:\"05/10\";i:27;s:5:\"06/10\";i:28;s:5:\"07/10\";i:29;s:5:\"08/10\";}s:11:\"net_revenue\";a:30:{i:0;d:0;i:1;d:0;i:2;d:0;i:3;d:0;i:4;d:0;i:5;d:0;i:6;d:0;i:7;d:0;i:8;d:0;i:9;d:0;i:10;d:0;i:11;d:1390000;i:12;d:1570000;i:13;d:0;i:14;d:0;i:15;d:0;i:16;d:0;i:17;d:0;i:18;d:0;i:19;d:0;i:20;d:0;i:21;d:0;i:22;d:0;i:23;d:0;i:24;d:0;i:25;d:0;i:26;d:0;i:27;d:0;i:28;d:270530000;i:29;d:0;}s:11:\"gross_sales\";a:30:{i:0;d:0;i:1;d:0;i:2;d:0;i:3;d:0;i:4;d:0;i:5;d:0;i:6;d:0;i:7;d:0;i:8;d:0;i:9;d:0;i:10;d:0;i:11;d:1390000;i:12;d:1570000;i:13;d:0;i:14;d:0;i:15;d:0;i:16;d:0;i:17;d:0;i:18;d:0;i:19;d:0;i:20;d:0;i:21;d:0;i:22;d:0;i:23;d:0;i:24;d:0;i:25;d:0;i:26;d:0;i:27;d:0;i:28;d:332390000;i:29;d:0;}}', 1791464798);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('lunara-silver-cache-lunara.navigation_data', 'a:5:{s:10:\"categories\";a:6:{i:0;a:6:{s:2:\"id\";i:1;s:4:\"name\";s:13:\"Dây chuyền\";s:12:\"display_name\";s:19:\"Dây chuyền bạc\";s:4:\"slug\";s:10:\"day-chuyen\";s:3:\"url\";s:41:\"http://127.0.0.1:8000/products/day-chuyen\";s:5:\"count\";i:10;}i:1;a:6:{s:2:\"id\";i:7;s:4:\"name\";s:5:\"Bông\";s:12:\"display_name\";s:11:\"Bông Bạc\";s:4:\"slug\";s:4:\"bong\";s:3:\"url\";s:35:\"http://127.0.0.1:8000/products/bong\";s:5:\"count\";i:0;}i:2;a:6:{s:2:\"id\";i:2;s:4:\"name\";s:6:\"Nhẫn\";s:12:\"display_name\";s:31:\"Nhẫn bạc 925 & Nhẫn đôi\";s:4:\"slug\";s:4:\"nhan\";s:3:\"url\";s:35:\"http://127.0.0.1:8000/products/nhan\";s:5:\"count\";i:10;}i:3;a:6:{s:2:\"id\";i:3;s:4:\"name\";s:9:\"Vòng tay\";s:12:\"display_name\";s:27:\"Vòng tay & Lắc tay bạc\";s:4:\"slug\";s:8:\"vong-tay\";s:3:\"url\";s:39:\"http://127.0.0.1:8000/products/vong-tay\";s:5:\"count\";i:10;}i:4;a:6:{s:2:\"id\";i:4;s:4:\"name\";s:16:\"Bộ trang sức\";s:12:\"display_name\";s:26:\"Bộ trang sức bạc 925\";s:4:\"slug\";s:12:\"bo-trang-suc\";s:3:\"url\";s:43:\"http://127.0.0.1:8000/products/bo-trang-suc\";s:5:\"count\";i:10;}i:5;a:6:{s:2:\"id\";i:5;s:4:\"name\";s:15:\"Set quà tặng\";s:12:\"display_name\";s:33:\"Set quà tặng trang sức bạc\";s:4:\"slug\";s:12:\"set-qua-tang\";s:3:\"url\";s:43:\"http://127.0.0.1:8000/products/set-qua-tang\";s:5:\"count\";i:5;}}s:16:\"featuredProducts\";a:2:{i:0;a:9:{s:2:\"id\";i:30;s:4:\"name\";s:23:\"Vòng Lunara Thiên Cơ\";s:4:\"slug\";s:20:\"vong-lunara-thien-co\";s:3:\"url\";s:50:\"http://127.0.0.1:8000/product/vong-lunara-thien-co\";s:13:\"price_display\";s:11:\"380.000 ₫\";s:21:\"regular_price_display\";s:11:\"440.000 ₫\";s:10:\"is_on_sale\";b:1;s:9:\"image_url\";s:82:\"http://127.0.0.1:8000/media-previews/d1b7d6be2b0a21f33d41e2bb00e89ec969ab7b62.webp\";s:13:\"category_name\";s:9:\"Vòng tay\";}i:1;a:9:{s:2:\"id\";i:29;s:4:\"name\";s:26:\"Vòng Lunara Thiên Đàng\";s:4:\"slug\";s:22:\"vong-lunara-thien-dang\";s:3:\"url\";s:52:\"http://127.0.0.1:8000/product/vong-lunara-thien-dang\";s:13:\"price_display\";s:11:\"400.000 ₫\";s:21:\"regular_price_display\";s:11:\"460.000 ₫\";s:10:\"is_on_sale\";b:1;s:9:\"image_url\";s:82:\"http://127.0.0.1:8000/media-previews/b02ddbfce1f51e7941ffe251e86f4f081ab1c2f0.webp\";s:13:\"category_name\";s:9:\"Vòng tay\";}}s:11:\"collections\";a:3:{i:0;a:7:{s:2:\"id\";i:31;s:4:\"name\";s:29:\"Bản Giao Hưởng Vũ Trụ\";s:4:\"slug\";s:21:\"ban-giao-huong-vu-tru\";s:3:\"url\";s:51:\"http://127.0.0.1:8000/product/ban-giao-huong-vu-tru\";s:13:\"price_display\";s:11:\"840.000 ₫\";s:9:\"image_url\";s:82:\"http://127.0.0.1:8000/media-previews/e5b3efc2d12d4af06f139a5dbddb040f50ab8433.webp\";s:7:\"summary\";s:79:\"LNS-DC005 (Thiên Vũ Chòm Sao); LNS-NH004 (Vũ Trụ); LNS-VT002 (Hành Tinh)\";}i:1;a:7:{s:2:\"id\";i:32;s:4:\"name\";s:22:\"Ánh Trăng Tinh Khôi\";s:4:\"slug\";s:19:\"anh-trang-tinh-khoi\";s:3:\"url\";s:49:\"http://127.0.0.1:8000/product/anh-trang-tinh-khoi\";s:13:\"price_display\";s:11:\"920.000 ₫\";s:9:\"image_url\";s:82:\"http://127.0.0.1:8000/media-previews/0a251d5d988c65416cc7ac2963111f7971fca60e.webp\";s:7:\"summary\";s:102:\"LNS-DC007 (Hạo Nguyệt Ôm Hừng); LNS-NH007 (Bạch Nguyệt Cabochon); LNS-VT003 (Song Nguyệt)\";}i:2;a:7:{s:2:\"id\";i:33;s:4:\"name\";s:16:\"Giọt Ngân Hà\";s:4:\"slug\";s:12:\"giot-ngan-ha\";s:3:\"url\";s:42:\"http://127.0.0.1:8000/product/giot-ngan-ha\";s:13:\"price_display\";s:11:\"880.000 ₫\";s:9:\"image_url\";s:82:\"http://127.0.0.1:8000/media-previews/fe307befea532373e2265473e3d18ce9cc22260c.webp\";s:7:\"summary\";s:89:\"LNS-DC008 (Băng Tinh Nguyệt Khuyết); LNS-NH005 (Tinh Thủy); LNS-VT010 (Thiên Cơ)\";}}s:8:\"giftSets\";a:3:{i:0;a:7:{s:2:\"id\";i:41;s:4:\"name\";s:31:\"Lunara Gift Box – Dịu Dàng\";s:4:\"slug\";s:24:\"lunara-gift-box-diu-dang\";s:3:\"url\";s:54:\"http://127.0.0.1:8000/product/lunara-gift-box-diu-dang\";s:13:\"price_display\";s:11:\"600.000 ₫\";s:9:\"image_url\";s:82:\"http://127.0.0.1:8000/media-previews/7fa08d38929ca4d62a614906f778aa35645c6789.webp\";s:7:\"summary\";s:54:\"LNS-DC001 (Thái Dương Lam); LNS-NH005 (Tinh Thủy)\";}i:1;a:7:{s:2:\"id\";i:42;s:4:\"name\";s:31:\"Lunara Gift Box – Tỏa Sáng\";s:4:\"slug\";s:24:\"lunara-gift-box-toa-sang\";s:3:\"url\";s:54:\"http://127.0.0.1:8000/product/lunara-gift-box-toa-sang\";s:13:\"price_display\";s:11:\"590.000 ₫\";s:9:\"image_url\";s:82:\"http://127.0.0.1:8000/media-previews/ab7d1f4ce6cbe06bf996633467696969725c63c2.webp\";s:7:\"summary\";s:45:\"LNS-VT007 (Thiên Hà); LNS-NH002 (Song Tinh)\";}i:2;a:7:{s:2:\"id\";i:43;s:4:\"name\";s:46:\"Lunara Gift Box – Trọn Vẹn Yêu Thương\";s:4:\"slug\";s:35:\"lunara-gift-box-tron-ven-yeu-thuong\";s:3:\"url\";s:65:\"http://127.0.0.1:8000/product/lunara-gift-box-tron-ven-yeu-thuong\";s:13:\"price_display\";s:13:\"1.050.000 ₫\";s:9:\"image_url\";s:82:\"http://127.0.0.1:8000/media-previews/75bb21dd2d0b754190b2c00b35105bc004afe1c7.webp\";s:7:\"summary\";s:88:\"LNS-DC009 (Thanh Nguyệt Sao Tinh); LNS-VT009 (Thiên Đàng); LNS-NH010 (Bắc Đẩu)\";}}s:14:\"blogCategories\";a:3:{i:0;a:5:{s:2:\"id\";i:1;s:4:\"name\";s:22:\"Bảo quản bạc 925\";s:4:\"slug\";s:16:\"bao-quan-bac-925\";s:3:\"url\";s:52:\"http://127.0.0.1:8000/blog/category/bao-quan-bac-925\";s:5:\"count\";i:1;}i:1;a:5:{s:2:\"id\";i:2;s:4:\"name\";s:29:\"Bộ sưu tập & Phong cách\";s:4:\"slug\";s:21:\"bo-suu-tap-phong-cach\";s:3:\"url\";s:57:\"http://127.0.0.1:8000/blog/category/bo-suu-tap-phong-cach\";s:5:\"count\";i:1;}i:2;a:5:{s:2:\"id\";i:3;s:4:\"name\";s:22:\"Cẩm nang trang sức\";s:4:\"slug\";s:18:\"cam-nang-trang-suc\";s:3:\"url\";s:54:\"http://127.0.0.1:8000/blog/category/cam-nang-trang-suc\";s:5:\"count\";i:1;}}}', 1791467620);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `created_at`, `updated_at`) VALUES
(2, NULL, 'WVZYfpOFpp02DRg6e7wK1pcTJ3G0GwFUXcPyab2qCdzr42iuU4zV84FOxLvSX7Kb', '2026-09-20 04:55:30', '2026-09-20 04:55:30'),
(3, 1, NULL, '2026-09-20 08:52:33', '2026-09-20 08:52:33'),
(11, 4, NULL, '2026-09-21 08:33:44', '2026-09-21 08:33:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `gift_message` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `seo_intro` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `description`, `seo_title`, `seo_description`, `seo_intro`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Dây chuyền', 'day-chuyen', NULL, NULL, NULL, NULL, 1, 0, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(2, NULL, 'Nhẫn', 'nhan', NULL, NULL, NULL, NULL, 1, 1, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(3, NULL, 'Vòng tay', 'vong-tay', NULL, NULL, NULL, NULL, 1, 2, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(4, NULL, 'Bộ trang sức', 'bo-trang-suc', NULL, NULL, NULL, NULL, 1, 3, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(5, NULL, 'Set quà tặng', 'set-qua-tang', NULL, NULL, NULL, NULL, 1, 4, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(6, NULL, 'Vàng', 'vang', NULL, NULL, NULL, NULL, 0, 0, '2026-09-21 09:00:04', '2026-09-21 09:01:52'),
(7, NULL, 'Bông', 'bong', NULL, NULL, NULL, NULL, 1, 0, '2026-09-22 08:53:42', '2026-09-22 08:53:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(40) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'new',
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `internal_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `minimum_order` decimal(15,2) DEFAULT NULL,
  `maximum_discount` decimal(15,2) DEFAULT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `usage_limit` int(10) UNSIGNED DEFAULT NULL,
  `usage_limit_per_user` int(10) UNSIGNED DEFAULT NULL,
  `used_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_first_order_only` tinyint(1) NOT NULL DEFAULT 0,
  `applicable_categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_categories`)),
  `applicable_products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_products`)),
  `applicable_customer_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_customer_ids`)),
  `applicable_customer_emails` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_customer_emails`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `minimum_order`, `maximum_discount`, `starts_at`, `expires_at`, `usage_limit`, `usage_limit_per_user`, `used_count`, `is_active`, `is_first_order_only`, `applicable_categories`, `applicable_products`, `applicable_customer_ids`, `applicable_customer_emails`, `created_at`, `updated_at`) VALUES
(1, 'LUNARA10', 'percentage', 10.00, 200000.00, 100000.00, NULL, NULL, 100, 2, 0, 1, 0, NULL, NULL, NULL, NULL, '2026-09-30 13:15:03', '2026-09-30 13:15:03'),
(2, 'LUNARA50K', 'fixed', 50000.00, 300000.00, NULL, NULL, NULL, 50, 1, 0, 1, 0, NULL, NULL, NULL, NULL, '2026-09-30 13:15:03', '2026-09-30 13:15:03'),
(3, 'CHAOHEXINH', 'percentage', 15.00, 400000.00, 150000.00, NULL, NULL, 200, 1, 0, 1, 0, NULL, NULL, NULL, NULL, '2026-09-30 13:15:03', '2026-09-30 13:15:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'applied',
  `used_at` timestamp NULL DEFAULT NULL,
  `released_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `email_logs`
--

CREATE TABLE `email_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `related_type` varchar(100) DEFAULT NULL,
  `related_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `error_message` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(100) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `faqs`
--

INSERT INTO `faqs` (`id`, `category`, `question`, `answer`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Đặt hàng', 'Làm thế nào để đặt hàng tại Lunara Silver?', 'Quý khách có thể lựa chọn các tuyệt tác trang sức yêu thích, thêm vào giỏ hàng và tiến hành thanh toán qua giao diện trực tuyến tinh giản của Lunara. Chúng tôi hỗ trợ cả đặt hàng bằng tài khoản thành viên hoặc hình thức khách vãng lai (Guest).', 1, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38'),
(2, 'Đặt hàng', 'Tôi có thể thay đổi hoặc hủy đơn hàng sau khi đặt không?', 'Nếu đơn hàng của quý khách đang ở trạng thái \"Chờ xác nhận\", quý khách có thể liên hệ ngay với bộ phận chăm sóc khách hàng qua Hotline/Live Chat hoặc biểu mẫu Liên hệ để được hỗ trợ điều chỉnh hoặc hủy đơn.', 2, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38'),
(3, 'Thanh toán', 'Lunara Silver hỗ trợ những hình thức thanh toán nào?', 'Lunara Silver hỗ trợ 2 phương thức thanh toán an toàn và tiện lợi: Thanh toán khi nhận hàng (COD) và Thanh toán trực tuyến qua cổng VNPay (hỗ trợ thẻ ATM nội địa, QR Code ngân hàng, và thẻ quốc tế Visa/MasterCard).', 1, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38'),
(4, 'VNPay', 'Nếu thanh toán VNPay gặp sự cố hoặc bị gián đoạn thì xử lý thế nào?', 'Đơn hàng của quý khách sẽ được giữ lại ở trạng thái \"Chờ thanh toán\". Quý khách có thể truy cập trang Chi tiết đơn hàng để thực hiện lại thanh toán (Retry VNPay) trong vòng 15 phút hoặc chuyển đổi phương thức sang COD nếu cần thiết.', 1, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38'),
(5, 'VNPay', 'Sau khi trừ tiền trong tài khoản nhưng trang báo lỗi thì tôi phải làm sao?', 'Hệ thống tự động thực hiện đối soát và cập nhật đơn hàng. Quý khách vui lòng lưu lại mã giao dịch ngân hàng và liên hệ với Lunara qua mục Hỗ trợ để chuyên viên kiểm tra và kích hoạt đơn hàng ngay lập tức.', 2, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38'),
(6, 'Giao hàng', 'Thời gian và chi phí giao hàng của Lunara Silver như thế nào?', 'Thời gian giao hàng tiêu chuẩn từ 2-4 ngày làm việc đối với các tỉnh thành trên toàn quốc. Các đơn hàng đều được đóng gói theo quy chuẩn hộp quà trang sức cao cấp và niêm phong bảo mật.', 1, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38'),
(7, 'Giao hàng', 'Tôi có được kiểm tra sản phẩm trước khi nhận hàng không?', 'Quý khách hoàn toàn có quyền đồng kiểm tra ngoại quan hộp bưu kiện và sản phẩm cùng nhân viên giao nhận trước khi thanh toán hoặc ký nhận.', 2, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38'),
(8, 'Đổi trả', 'Chính sách đổi trả sản phẩm tại Lunara Silver?', 'Lunara chấp nhận đổi sản phẩm trong vòng 7 ngày kể từ khi quý khách nhận hàng, áp dụng với các sản phẩm còn nguyên tem mác, hộp đựng nguyên vẹn và chưa qua sử dụng. Nếu phát sinh lỗi kỹ thuật chế tác từ Lunara, chúng tôi đổi mới 100% miễn phí vận chuyển.', 1, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38'),
(9, 'Tài khoản', 'Lợi ích khi đăng ký tài khoản thành viên Lunara?', 'Tài khoản thành viên giúp quý khách theo dõi chi tiết lịch sử đơn hàng, lưu địa chỉ giao nhận quen thuộc, nhận ưu đãi độc quyền dành riêng cho khách hàng thân thiết và trải nghiệm dịch vụ hỗ trợ ưu tiên.', 1, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38'),
(10, 'Khuyến mãi', 'Làm sao để áp dụng mã giảm giá khi mua sắm?', 'Tại trang Giỏ hàng hoặc Thanh toán, quý khách chỉ cần nhập mã ưu đãi vào ô \"Mã ưu đãi\" và bấm Áp dụng. Hệ thống sẽ tự động tính toán mức khấu trừ phù hợp với giá trị đơn hàng.', 1, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38'),
(11, 'Bảo quản trang sức', 'Làm cách nào để trang sức bạc luôn giữ được độ sáng bóng?', 'Nên tránh để trang sức bạc 925 tiếp xúc trực tiếp với hóa chất tẩy rửa mạnh, nước hoa hoặc clo trong hồ bơi. Khi không sử dụng, hãy lau khô bằng khăn mềm chuyên dụng và cất giữ trong hộp chống ẩm kèm túi zip kín khí của Lunara.', 1, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38'),
(12, 'Bảo quản trang sức', 'Lunara Silver có hỗ trợ làm sáng và đánh bóng trang sức không?', 'Tất cả sản phẩm chính hãng của Lunara đều được hưởng dịch vụ làm sáng và vệ sinh trang sức miễn phí trọn đời tại hệ thống cửa hàng và xưởng chế tác của chúng tôi.', 2, 1, '2026-09-28 15:55:38', '2026-09-28 15:55:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_20_000001_create_catalog_tables', 2),
(5, '2026_09_20_000002_create_customer_tables', 2),
(6, '2026_09_20_000003_create_order_tables', 2),
(7, '2026_09_20_000004_create_engagement_tables', 2),
(8, '2026_09_20_000005_create_content_tables', 2),
(9, '2026_09_22_000001_create_order_management_tables', 3),
(10, '2026_09_27_000001_create_payment_attempts_and_refunds_tables', 4),
(11, '2026_09_28_000001_create_support_and_faq_tables', 5),
(12, '2026_09_30_000001_update_coupons_and_orders_for_phase15', 6),
(13, '2026_09_30_000002_add_advanced_rules_to_coupons_table', 7),
(14, '2026_09_30_000003_update_posts_and_categories_for_phase16', 8),
(15, '2026_10_02_000001_create_seo_redirects_and_category_seo_fields', 9),
(16, '2026_10_04_185915_add_verified_reviews_and_media_and_gift_support', 9),
(17, '2026_10_07_000001_add_performance_indexes_for_phase21_5', 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_code` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(30) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_note` text DEFAULT NULL,
  `shipping_method` varchar(30) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` decimal(15,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(15,2) NOT NULL,
  `payment_method` varchar(30) NOT NULL,
  `payment_status` varchar(30) NOT NULL DEFAULT 'pending',
  `order_status` varchar(30) NOT NULL DEFAULT 'pending',
  `inventory_restored_at` timestamp NULL DEFAULT NULL,
  `customer_note` text DEFAULT NULL,
  `placed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_code`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `shipping_city`, `shipping_note`, `shipping_method`, `subtotal`, `coupon_code`, `discount_amount`, `shipping_fee`, `grand_total`, `payment_method`, `payment_status`, `order_status`, `inventory_restored_at`, `customer_note`, `placed_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 'LNS-20260920-DW7ZVI', 'Nguyễn Tấn Mạnh', 'tanmhnsnguyen@gmail.com', '033224231', 'sdaddasds', 'Hồ Chí Minh', NULL, 'standard', 450000.00, NULL, 0.00, 0.00, 450000.00, 'cod', 'pending', 'pending', NULL, NULL, '2026-09-20 08:16:03', '2026-09-20 08:16:03', '2026-09-20 08:16:03'),
(2, 1, 'LNS-20260920-AUGCUT', 'Nguyễn Tấn Mạnh', 'tanmanhnsnguyen@gmail.com', '0332247231', '3070, Phạm Thế Hiển', 'Hồ Chí Minh', NULL, 'standard', 1390000.00, NULL, 0.00, 0.00, 1390000.00, 'cod', 'paid', 'completed', NULL, NULL, '2026-09-20 08:54:09', '2026-09-20 08:54:09', '2026-09-22 08:56:15'),
(3, 1, 'LNS-20260921-TPGMTO', 'Nguyễn Tấn Mạnh', 'tanmanhnsnguyen@gmail.com', '0332247231', 'Đại học Tôn Đức Thắng', 'Hồ Chí Minh', NULL, 'standard', 1570000.00, NULL, 0.00, 0.00, 1570000.00, 'cod', 'paid', 'completed', NULL, NULL, '2026-09-20 21:21:15', '2026-09-20 21:21:15', '2026-09-22 08:46:08'),
(48, 343, 'LNS260711ZTEK001', 'Khách hàng 343', 'perf_customer_343@testlunara.local', '0975511808', 'Số 11 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(49, 384, 'LNS260915TGLJ002', 'Khách hàng 384', 'perf_customer_384@testlunara.local', '0949496374', 'Số 182 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1450000.00, NULL, 0.00, 30000.00, 1480000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(50, 393, 'LNS260804OLMW003', 'Khách hàng 393', 'perf_customer_393@testlunara.local', '0993248819', 'Số 117 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1300000.00, NULL, 0.00, 30000.00, 1330000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(51, 408, 'LNS260721G28Q004', 'Khách hàng 408', 'perf_customer_408@testlunara.local', '0957971157', 'Số 151 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1120000.00, NULL, 0.00, 30000.00, 1150000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(52, 342, 'LNS260911LA0O005', 'Khách hàng 342', 'perf_customer_342@testlunara.local', '0988769633', 'Số 185 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1420000.00, NULL, 0.00, 30000.00, 1450000.00, 'vnpay', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(53, 382, 'LNS260805JPDG006', 'Khách hàng 382', 'perf_customer_382@testlunara.local', '0983845182', 'Số 188 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1440000.00, NULL, 0.00, 30000.00, 1470000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(54, 321, 'LNS260908JQTW007', 'Khách hàng 321', 'perf_customer_321@testlunara.local', '0941218631', 'Số 44 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 810000.00, NULL, 0.00, 30000.00, 840000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(55, 402, 'LNS260805VLBT008', 'Khách hàng 402', 'perf_customer_402@testlunara.local', '0988475826', 'Số 125 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 890000.00, NULL, 0.00, 30000.00, 920000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(56, 405, 'LNS260720GOO1009', 'Khách hàng 405', 'perf_customer_405@testlunara.local', '0911963792', 'Số 179 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1070000.00, NULL, 0.00, 30000.00, 1100000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(57, 402, 'LNS260907LELB010', 'Khách hàng 402', 'perf_customer_402@testlunara.local', '0956252476', 'Số 142 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 980000.00, NULL, 0.00, 30000.00, 1010000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(58, 328, 'LNS2607266SZR011', 'Khách hàng 328', 'perf_customer_328@testlunara.local', '0918774701', 'Số 181 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1010000.00, NULL, 0.00, 30000.00, 1040000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(59, 374, 'LNS260824OCDC012', 'Khách hàng 374', 'perf_customer_374@testlunara.local', '0923619761', 'Số 13 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 940000.00, NULL, 0.00, 30000.00, 970000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(60, 349, 'LNS260721U06P013', 'Khách hàng 349', 'perf_customer_349@testlunara.local', '0942894036', 'Số 79 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1160000.00, NULL, 0.00, 30000.00, 1190000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(61, 382, 'LNS2609278IWM014', 'Khách hàng 382', 'perf_customer_382@testlunara.local', '0925843052', 'Số 72 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1420000.00, NULL, 0.00, 30000.00, 1450000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(62, 352, 'LNS260910K9ZV015', 'Khách hàng 352', 'perf_customer_352@testlunara.local', '0919828015', 'Số 175 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1810000.00, NULL, 0.00, 30000.00, 1840000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(63, 333, 'LNS260815UPUW016', 'Khách hàng 333', 'perf_customer_333@testlunara.local', '0950110608', 'Số 155 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 900000.00, NULL, 0.00, 30000.00, 930000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(64, 359, 'LNS260930SFWS017', 'Khách hàng 359', 'perf_customer_359@testlunara.local', '0982018362', 'Số 119 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1040000.00, NULL, 0.00, 30000.00, 1070000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(65, 324, 'LNS260811KOX9018', 'Khách hàng 324', 'perf_customer_324@testlunara.local', '0929973002', 'Số 179 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1240000.00, NULL, 0.00, 30000.00, 1270000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(66, 395, 'LNS260913KNMS019', 'Khách hàng 395', 'perf_customer_395@testlunara.local', '0917848720', 'Số 77 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 730000.00, NULL, 0.00, 30000.00, 760000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(67, 389, 'LNS260722697E020', 'Khách hàng 389', 'perf_customer_389@testlunara.local', '0936756511', 'Số 63 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1360000.00, NULL, 0.00, 30000.00, 1390000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(68, 353, 'LNS260911IRCG021', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0954475240', 'Số 22 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1200000.00, NULL, 0.00, 30000.00, 1230000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(69, 362, 'LNS260721KO8R022', 'Khách hàng 362', 'perf_customer_362@testlunara.local', '0943647065', 'Số 91 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1550000.00, NULL, 0.00, 30000.00, 1580000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(70, 357, 'LNS260906NTVJ023', 'Khách hàng 357', 'perf_customer_357@testlunara.local', '0921431567', 'Số 90 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1600000.00, NULL, 0.00, 30000.00, 1630000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(71, 367, 'LNS260804SOKO024', 'Khách hàng 367', 'perf_customer_367@testlunara.local', '0973684319', 'Số 85 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1550000.00, NULL, 0.00, 30000.00, 1580000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(72, 358, 'LNS260903TVDF025', 'Khách hàng 358', 'perf_customer_358@testlunara.local', '0931102053', 'Số 27 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1790000.00, NULL, 0.00, 30000.00, 1820000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(73, 411, 'LNS2609307CMV026', 'Khách hàng 411', 'perf_customer_411@testlunara.local', '0985471000', 'Số 98 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 900000.00, NULL, 0.00, 30000.00, 930000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(74, 345, 'LNS260930K2JM027', 'Khách hàng 345', 'perf_customer_345@testlunara.local', '0998421881', 'Số 165 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2100000.00, NULL, 0.00, 30000.00, 2130000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(75, 397, 'LNS260912B7O3028', 'Khách hàng 397', 'perf_customer_397@testlunara.local', '0988167880', 'Số 5 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1140000.00, NULL, 0.00, 30000.00, 1170000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(76, 403, 'LNS260727A9OF029', 'Khách hàng 403', 'perf_customer_403@testlunara.local', '0951946122', 'Số 155 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1250000.00, NULL, 0.00, 30000.00, 1280000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(77, 377, 'LNS260814SBX9030', 'Khách hàng 377', 'perf_customer_377@testlunara.local', '0990197036', 'Số 159 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1240000.00, NULL, 0.00, 30000.00, 1270000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(78, 331, 'LNS260711DZCT031', 'Khách hàng 331', 'perf_customer_331@testlunara.local', '0961836625', 'Số 140 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 970000.00, NULL, 0.00, 30000.00, 1000000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(79, 415, 'LNS260827QKC9032', 'Khách hàng 415', 'perf_customer_415@testlunara.local', '0958996094', 'Số 87 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1740000.00, NULL, 0.00, 30000.00, 1770000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(80, 396, 'LNS2609306PC0033', 'Khách hàng 396', 'perf_customer_396@testlunara.local', '0972013373', 'Số 155 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1360000.00, NULL, 0.00, 30000.00, 1390000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(81, 364, 'LNS260713RTVO034', 'Khách hàng 364', 'perf_customer_364@testlunara.local', '0913444867', 'Số 141 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 730000.00, NULL, 0.00, 30000.00, 760000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(82, 355, 'LNS26091289RO035', 'Khách hàng 355', 'perf_customer_355@testlunara.local', '0959721913', 'Số 144 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1030000.00, NULL, 0.00, 30000.00, 1060000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(83, 391, 'LNS260806EUQE036', 'Khách hàng 391', 'perf_customer_391@testlunara.local', '0968069547', 'Số 191 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 820000.00, NULL, 0.00, 30000.00, 850000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(84, 354, 'LNS260713UXBS037', 'Khách hàng 354', 'perf_customer_354@testlunara.local', '0929285102', 'Số 167 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1490000.00, NULL, 0.00, 30000.00, 1520000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(85, 354, 'LNS260818Q3LY038', 'Khách hàng 354', 'perf_customer_354@testlunara.local', '0982679571', 'Số 188 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1090000.00, NULL, 0.00, 30000.00, 1120000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(86, 361, 'LNS260730T5BC039', 'Khách hàng 361', 'perf_customer_361@testlunara.local', '0953680466', 'Số 128 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 780000.00, NULL, 0.00, 30000.00, 810000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(87, 370, 'LNS260728MJGV040', 'Khách hàng 370', 'perf_customer_370@testlunara.local', '0972343366', 'Số 115 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1160000.00, NULL, 0.00, 30000.00, 1190000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(88, 1, 'LNS2607148ESR041', 'Khách hàng 1', 'perf_customer_1@testlunara.local', '0968306741', 'Số 162 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 890000.00, NULL, 0.00, 30000.00, 920000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(89, 327, 'LNS260819LHO8042', 'Khách hàng 327', 'perf_customer_327@testlunara.local', '0921128379', 'Số 42 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1000000.00, NULL, 0.00, 30000.00, 1030000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(90, 368, 'LNS2609034V4E043', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0927999566', 'Số 107 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1860000.00, NULL, 0.00, 30000.00, 1890000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(91, 402, 'LNS260720OA63044', 'Khách hàng 402', 'perf_customer_402@testlunara.local', '0985956551', 'Số 104 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 960000.00, NULL, 0.00, 30000.00, 990000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(92, 318, 'LNS260920RXHO045', 'Khách hàng 318', 'perf_customer_318@testlunara.local', '0968459293', 'Số 123 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 840000.00, NULL, 0.00, 30000.00, 870000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(93, 343, 'LNS260918A7U5046', 'Khách hàng 343', 'perf_customer_343@testlunara.local', '0966086829', 'Số 21 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 900000.00, NULL, 0.00, 30000.00, 930000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(94, 357, 'LNS260817EKNT047', 'Khách hàng 357', 'perf_customer_357@testlunara.local', '0964506628', 'Số 138 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 690000.00, NULL, 0.00, 30000.00, 720000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(95, 350, 'LNS260913XYCK048', 'Khách hàng 350', 'perf_customer_350@testlunara.local', '0923404492', 'Số 96 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1000000.00, NULL, 0.00, 30000.00, 1030000.00, 'vnpay', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(96, 349, 'LNS26081890MR049', 'Khách hàng 349', 'perf_customer_349@testlunara.local', '0953631544', 'Số 189 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(97, 319, 'LNS260809VZ9L050', 'Khách hàng 319', 'perf_customer_319@testlunara.local', '0960689123', 'Số 57 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1540000.00, NULL, 0.00, 30000.00, 1570000.00, 'vnpay', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(98, 323, 'LNS261001WX9H051', 'Khách hàng 323', 'perf_customer_323@testlunara.local', '0939089285', 'Số 192 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1570000.00, NULL, 0.00, 30000.00, 1600000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(99, 373, 'LNS261004PRWH052', 'Khách hàng 373', 'perf_customer_373@testlunara.local', '0986813663', 'Số 81 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1480000.00, NULL, 0.00, 30000.00, 1510000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(100, 343, 'LNS260815FNS9053', 'Khách hàng 343', 'perf_customer_343@testlunara.local', '0938120699', 'Số 129 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1090000.00, NULL, 0.00, 30000.00, 1120000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(101, 363, 'LNS260825TD2Q054', 'Khách hàng 363', 'perf_customer_363@testlunara.local', '0995191983', 'Số 47 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 630000.00, NULL, 0.00, 30000.00, 660000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(102, 334, 'LNS260810FMYG055', 'Khách hàng 334', 'perf_customer_334@testlunara.local', '0945906335', 'Số 142 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 880000.00, NULL, 0.00, 30000.00, 910000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(103, 334, 'LNS2609035EE6056', 'Khách hàng 334', 'perf_customer_334@testlunara.local', '0956839648', 'Số 179 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1220000.00, NULL, 0.00, 30000.00, 1250000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(104, 387, 'LNS261001DLMC057', 'Khách hàng 387', 'perf_customer_387@testlunara.local', '0986853816', 'Số 153 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2000000.00, NULL, 0.00, 30000.00, 2030000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(105, 397, 'LNS2609285OXZ058', 'Khách hàng 397', 'perf_customer_397@testlunara.local', '0930048202', 'Số 134 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1110000.00, NULL, 0.00, 30000.00, 1140000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(106, 396, 'LNS260827CQAS059', 'Khách hàng 396', 'perf_customer_396@testlunara.local', '0924738657', 'Số 49 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1840000.00, NULL, 0.00, 30000.00, 1870000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(107, 346, 'LNS260830KUBM060', 'Khách hàng 346', 'perf_customer_346@testlunara.local', '0974403674', 'Số 33 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 950000.00, NULL, 0.00, 30000.00, 980000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(108, 328, 'LNS260713VH9V061', 'Khách hàng 328', 'perf_customer_328@testlunara.local', '0942454165', 'Số 185 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1120000.00, NULL, 0.00, 30000.00, 1150000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(109, 411, 'LNS260816NNFJ062', 'Khách hàng 411', 'perf_customer_411@testlunara.local', '0918544577', 'Số 199 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1150000.00, NULL, 0.00, 30000.00, 1180000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(110, 343, 'LNS260920NLHE063', 'Khách hàng 343', 'perf_customer_343@testlunara.local', '0990019697', 'Số 90 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 670000.00, NULL, 0.00, 30000.00, 700000.00, 'vnpay', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(111, 333, 'LNS260724QYFN064', 'Khách hàng 333', 'perf_customer_333@testlunara.local', '0943050511', 'Số 1 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2100000.00, NULL, 0.00, 30000.00, 2130000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(112, 365, 'LNS260721RUQK065', 'Khách hàng 365', 'perf_customer_365@testlunara.local', '0933718383', 'Số 178 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 570000.00, NULL, 0.00, 30000.00, 600000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(113, 342, 'LNS260907KIYM066', 'Khách hàng 342', 'perf_customer_342@testlunara.local', '0999636738', 'Số 61 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1460000.00, NULL, 0.00, 30000.00, 1490000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(114, 347, 'LNS260723VCDJ067', 'Khách hàng 347', 'perf_customer_347@testlunara.local', '0939469988', 'Số 4 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 740000.00, NULL, 0.00, 30000.00, 770000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(115, 337, 'LNS260731RKWZ068', 'Khách hàng 337', 'perf_customer_337@testlunara.local', '0946133163', 'Số 21 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1180000.00, NULL, 0.00, 30000.00, 1210000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(116, 353, 'LNS260813XSMU069', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0932774491', 'Số 74 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1010000.00, NULL, 0.00, 30000.00, 1040000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(117, 358, 'LNS260717DAQI070', 'Khách hàng 358', 'perf_customer_358@testlunara.local', '0997260433', 'Số 103 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1050000.00, NULL, 0.00, 30000.00, 1080000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(118, 390, 'LNS260924E9O8071', 'Khách hàng 390', 'perf_customer_390@testlunara.local', '0966885988', 'Số 189 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1480000.00, NULL, 0.00, 30000.00, 1510000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(119, 354, 'LNS260819RPRA072', 'Khách hàng 354', 'perf_customer_354@testlunara.local', '0980046522', 'Số 10 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1540000.00, NULL, 0.00, 30000.00, 1570000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(120, 411, 'LNS260812IRRU073', 'Khách hàng 411', 'perf_customer_411@testlunara.local', '0934320083', 'Số 75 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1560000.00, NULL, 0.00, 30000.00, 1590000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(121, 397, 'LNS260722YXNC074', 'Khách hàng 397', 'perf_customer_397@testlunara.local', '0981027713', 'Số 7 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1460000.00, NULL, 0.00, 30000.00, 1490000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(122, 359, 'LNS260924FFH9075', 'Khách hàng 359', 'perf_customer_359@testlunara.local', '0919779913', 'Số 77 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1340000.00, NULL, 0.00, 30000.00, 1370000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(123, 332, 'LNS2609084ETD076', 'Khách hàng 332', 'perf_customer_332@testlunara.local', '0939577837', 'Số 185 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1060000.00, NULL, 0.00, 30000.00, 1090000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(124, 390, 'LNS260720UB3L077', 'Khách hàng 390', 'perf_customer_390@testlunara.local', '0928649810', 'Số 84 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1110000.00, NULL, 0.00, 30000.00, 1140000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(125, 406, 'LNS260802BYVY078', 'Khách hàng 406', 'perf_customer_406@testlunara.local', '0911845156', 'Số 88 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1680000.00, NULL, 0.00, 30000.00, 1710000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(126, 372, 'LNS260725TFQ6079', 'Khách hàng 372', 'perf_customer_372@testlunara.local', '0929574575', 'Số 54 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1450000.00, NULL, 0.00, 30000.00, 1480000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(127, 384, 'LNS261006XZ18080', 'Khách hàng 384', 'perf_customer_384@testlunara.local', '0963756462', 'Số 175 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1820000.00, NULL, 0.00, 30000.00, 1850000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(128, 413, 'LNS260917GHM0081', 'Khách hàng 413', 'perf_customer_413@testlunara.local', '0918294132', 'Số 74 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1460000.00, NULL, 0.00, 30000.00, 1490000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(129, 364, 'LNS2608315QLD082', 'Khách hàng 364', 'perf_customer_364@testlunara.local', '0979041062', 'Số 56 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1670000.00, NULL, 0.00, 30000.00, 1700000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(130, 416, 'LNS261003IFPH083', 'Khách hàng 416', 'perf_customer_416@testlunara.local', '0962855992', 'Số 187 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1460000.00, NULL, 0.00, 30000.00, 1490000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(131, 368, 'LNS260805NHDQ084', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0910473387', 'Số 148 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 920000.00, NULL, 0.00, 30000.00, 950000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(132, 355, 'LNS2607223QSU085', 'Khách hàng 355', 'perf_customer_355@testlunara.local', '0977703412', 'Số 108 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1200000.00, NULL, 0.00, 30000.00, 1230000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(133, 335, 'LNS260712WFUQ086', 'Khách hàng 335', 'perf_customer_335@testlunara.local', '0973095473', 'Số 44 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1810000.00, NULL, 0.00, 30000.00, 1840000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(134, 361, 'LNS260926HK31087', 'Khách hàng 361', 'perf_customer_361@testlunara.local', '0944144160', 'Số 22 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 960000.00, NULL, 0.00, 30000.00, 990000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(135, 349, 'LNS26081529IV088', 'Khách hàng 349', 'perf_customer_349@testlunara.local', '0923841735', 'Số 155 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1590000.00, NULL, 0.00, 30000.00, 1620000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(136, 389, 'LNS260903MD8K089', 'Khách hàng 389', 'perf_customer_389@testlunara.local', '0961304747', 'Số 24 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1660000.00, NULL, 0.00, 30000.00, 1690000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(137, 343, 'LNS260803VKGB090', 'Khách hàng 343', 'perf_customer_343@testlunara.local', '0931641962', 'Số 100 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1510000.00, NULL, 0.00, 30000.00, 1540000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(138, 382, 'LNS260904Q93N091', 'Khách hàng 382', 'perf_customer_382@testlunara.local', '0911403090', 'Số 153 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1640000.00, NULL, 0.00, 30000.00, 1670000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(139, 405, 'LNS260930KWON092', 'Khách hàng 405', 'perf_customer_405@testlunara.local', '0993506358', 'Số 118 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1270000.00, NULL, 0.00, 30000.00, 1300000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(140, 352, 'LNS260913G74S093', 'Khách hàng 352', 'perf_customer_352@testlunara.local', '0912156504', 'Số 51 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1270000.00, NULL, 0.00, 30000.00, 1300000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(141, 353, 'LNS260912NC9S094', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0984315981', 'Số 81 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1270000.00, NULL, 0.00, 30000.00, 1300000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(142, 324, 'LNS260720AFET095', 'Khách hàng 324', 'perf_customer_324@testlunara.local', '0938012178', 'Số 2 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1030000.00, NULL, 0.00, 30000.00, 1060000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(143, 379, 'LNS260928EIVC096', 'Khách hàng 379', 'perf_customer_379@testlunara.local', '0995197170', 'Số 105 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 650000.00, NULL, 0.00, 30000.00, 680000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(144, 332, 'LNS260902LJ1F097', 'Khách hàng 332', 'perf_customer_332@testlunara.local', '0949792664', 'Số 19 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1800000.00, NULL, 0.00, 30000.00, 1830000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(145, 402, 'LNS260718FFGU098', 'Khách hàng 402', 'perf_customer_402@testlunara.local', '0924501087', 'Số 37 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 710000.00, NULL, 0.00, 30000.00, 740000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(146, 385, 'LNS261003OTJG099', 'Khách hàng 385', 'perf_customer_385@testlunara.local', '0919389536', 'Số 74 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2070000.00, NULL, 0.00, 30000.00, 2100000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(147, 320, 'LNS260808AIGT100', 'Khách hàng 320', 'perf_customer_320@testlunara.local', '0991809354', 'Số 11 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1640000.00, NULL, 0.00, 30000.00, 1670000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(148, 369, 'LNS260805GAE8101', 'Khách hàng 369', 'perf_customer_369@testlunara.local', '0962613099', 'Số 100 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1420000.00, NULL, 0.00, 30000.00, 1450000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(149, 403, 'LNS260717UDPU102', 'Khách hàng 403', 'perf_customer_403@testlunara.local', '0981477431', 'Số 112 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 770000.00, NULL, 0.00, 30000.00, 800000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(150, 389, 'LNS260909CKD2103', 'Khách hàng 389', 'perf_customer_389@testlunara.local', '0936481621', 'Số 4 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1110000.00, NULL, 0.00, 30000.00, 1140000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(151, 370, 'LNS260910HUBE104', 'Khách hàng 370', 'perf_customer_370@testlunara.local', '0990825264', 'Số 147 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1220000.00, NULL, 0.00, 30000.00, 1250000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(152, 397, 'LNS260710SY2B105', 'Khách hàng 397', 'perf_customer_397@testlunara.local', '0937751635', 'Số 16 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1360000.00, NULL, 0.00, 30000.00, 1390000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(153, 353, 'LNS260712KVMS106', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0943343412', 'Số 10 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 690000.00, NULL, 0.00, 30000.00, 720000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(154, 331, 'LNS260926DYHH107', 'Khách hàng 331', 'perf_customer_331@testlunara.local', '0940382946', 'Số 58 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(155, 344, 'LNS260717N6UT108', 'Khách hàng 344', 'perf_customer_344@testlunara.local', '0922989427', 'Số 73 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 930000.00, NULL, 0.00, 30000.00, 960000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(156, 408, 'LNS260710VSMI109', 'Khách hàng 408', 'perf_customer_408@testlunara.local', '0954062371', 'Số 120 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1630000.00, NULL, 0.00, 30000.00, 1660000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(157, 375, 'LNS2607281JIO110', 'Khách hàng 375', 'perf_customer_375@testlunara.local', '0971146735', 'Số 23 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(158, 317, 'LNS2607119FE4111', 'Khách hàng 317', 'perf_customer_317@testlunara.local', '0977714215', 'Số 103 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1160000.00, NULL, 0.00, 30000.00, 1190000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(159, 339, 'LNS261002HDVC112', 'Khách hàng 339', 'perf_customer_339@testlunara.local', '0936569356', 'Số 7 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1700000.00, NULL, 0.00, 30000.00, 1730000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(160, 390, 'LNS260802K9DW113', 'Khách hàng 390', 'perf_customer_390@testlunara.local', '0976743364', 'Số 178 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1400000.00, NULL, 0.00, 30000.00, 1430000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(161, 389, 'LNS260711XEMM114', 'Khách hàng 389', 'perf_customer_389@testlunara.local', '0983713768', 'Số 143 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1260000.00, NULL, 0.00, 30000.00, 1290000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(162, 365, 'LNS261002TX4S115', 'Khách hàng 365', 'perf_customer_365@testlunara.local', '0976145316', 'Số 64 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 630000.00, NULL, 0.00, 30000.00, 660000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(163, 363, 'LNS2608209F5D116', 'Khách hàng 363', 'perf_customer_363@testlunara.local', '0943197223', 'Số 16 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1520000.00, NULL, 0.00, 30000.00, 1550000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(164, 340, 'LNS260725QUGT117', 'Khách hàng 340', 'perf_customer_340@testlunara.local', '0911880688', 'Số 76 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1840000.00, NULL, 0.00, 30000.00, 1870000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(165, 319, 'LNS260814RSCI118', 'Khách hàng 319', 'perf_customer_319@testlunara.local', '0914172365', 'Số 101 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1420000.00, NULL, 0.00, 30000.00, 1450000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(166, 344, 'LNS260711NQPM119', 'Khách hàng 344', 'perf_customer_344@testlunara.local', '0911388283', 'Số 58 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1680000.00, NULL, 0.00, 30000.00, 1710000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(167, 413, 'LNS260718XYSU120', 'Khách hàng 413', 'perf_customer_413@testlunara.local', '0954013070', 'Số 8 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1350000.00, NULL, 0.00, 30000.00, 1380000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(168, 392, 'LNS2608275VOR121', 'Khách hàng 392', 'perf_customer_392@testlunara.local', '0983746452', 'Số 14 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1290000.00, NULL, 0.00, 30000.00, 1320000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(169, 397, 'LNS260810MOAG122', 'Khách hàng 397', 'perf_customer_397@testlunara.local', '0943202428', 'Số 45 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1030000.00, NULL, 0.00, 30000.00, 1060000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(170, 368, 'LNS260904CB66123', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0971922306', 'Số 33 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1050000.00, NULL, 0.00, 30000.00, 1080000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(171, 398, 'LNS260819RXHS124', 'Khách hàng 398', 'perf_customer_398@testlunara.local', '0991677828', 'Số 79 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1370000.00, NULL, 0.00, 30000.00, 1400000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(172, 371, 'LNS260913RV0K125', 'Khách hàng 371', 'perf_customer_371@testlunara.local', '0930607674', 'Số 186 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1060000.00, NULL, 0.00, 30000.00, 1090000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(173, 372, 'LNS260801GAM0126', 'Khách hàng 372', 'perf_customer_372@testlunara.local', '0920594963', 'Số 49 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1530000.00, NULL, 0.00, 30000.00, 1560000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(174, 370, 'LNS260815UQ7I127', 'Khách hàng 370', 'perf_customer_370@testlunara.local', '0983557342', 'Số 29 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1930000.00, NULL, 0.00, 30000.00, 1960000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(175, 387, 'LNS260912AQPL128', 'Khách hàng 387', 'perf_customer_387@testlunara.local', '0920749690', 'Số 186 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 920000.00, NULL, 0.00, 30000.00, 950000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(176, 352, 'LNS260716PNGA129', 'Khách hàng 352', 'perf_customer_352@testlunara.local', '0970969830', 'Số 45 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1260000.00, NULL, 0.00, 30000.00, 1290000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(177, 415, 'LNS2607100UOJ130', 'Khách hàng 415', 'perf_customer_415@testlunara.local', '0938326317', 'Số 47 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1380000.00, NULL, 0.00, 30000.00, 1410000.00, 'vnpay', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(178, 369, 'LNS260906J80N131', 'Khách hàng 369', 'perf_customer_369@testlunara.local', '0970167993', 'Số 166 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1020000.00, NULL, 0.00, 30000.00, 1050000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(179, 353, 'LNS260721YGWA132', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0946951916', 'Số 17 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1320000.00, NULL, 0.00, 30000.00, 1350000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(180, 409, 'LNS260712RKDC133', 'Khách hàng 409', 'perf_customer_409@testlunara.local', '0936892779', 'Số 3 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1380000.00, NULL, 0.00, 30000.00, 1410000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(181, 357, 'LNS260831HIZZ134', 'Khách hàng 357', 'perf_customer_357@testlunara.local', '0990100152', 'Số 104 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1910000.00, NULL, 0.00, 30000.00, 1940000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(182, 403, 'LNS260826IEYE135', 'Khách hàng 403', 'perf_customer_403@testlunara.local', '0969994984', 'Số 62 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1320000.00, NULL, 0.00, 30000.00, 1350000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(183, 327, 'LNS260925SKSM136', 'Khách hàng 327', 'perf_customer_327@testlunara.local', '0948197542', 'Số 162 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1940000.00, NULL, 0.00, 30000.00, 1970000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(184, 401, 'LNS260917HXGM137', 'Khách hàng 401', 'perf_customer_401@testlunara.local', '0912015305', 'Số 128 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 920000.00, NULL, 0.00, 30000.00, 950000.00, 'vnpay', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(185, 386, 'LNS260719OH4I138', 'Khách hàng 386', 'perf_customer_386@testlunara.local', '0962604317', 'Số 17 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1350000.00, NULL, 0.00, 30000.00, 1380000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(186, 318, 'LNS260903H2PS139', 'Khách hàng 318', 'perf_customer_318@testlunara.local', '0972591386', 'Số 13 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1940000.00, NULL, 0.00, 30000.00, 1970000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(187, 393, 'LNS260811K0PR140', 'Khách hàng 393', 'perf_customer_393@testlunara.local', '0953734160', 'Số 152 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2140000.00, NULL, 0.00, 30000.00, 2170000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(188, 346, 'LNS2608150WT8141', 'Khách hàng 346', 'perf_customer_346@testlunara.local', '0966537557', 'Số 189 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 660000.00, NULL, 0.00, 30000.00, 690000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(189, 319, 'LNS260903GL45142', 'Khách hàng 319', 'perf_customer_319@testlunara.local', '0990205194', 'Số 177 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1420000.00, NULL, 0.00, 30000.00, 1450000.00, 'vnpay', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(190, 393, 'LNS2609153YPW143', 'Khách hàng 393', 'perf_customer_393@testlunara.local', '0963006455', 'Số 188 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 850000.00, NULL, 0.00, 30000.00, 880000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(191, 361, 'LNS260809AYFB144', 'Khách hàng 361', 'perf_customer_361@testlunara.local', '0993779321', 'Số 92 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1700000.00, NULL, 0.00, 30000.00, 1730000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(192, 383, 'LNS260806UCDM145', 'Khách hàng 383', 'perf_customer_383@testlunara.local', '0983577604', 'Số 51 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1340000.00, NULL, 0.00, 30000.00, 1370000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(193, 381, 'LNS2608177NFU146', 'Khách hàng 381', 'perf_customer_381@testlunara.local', '0990377599', 'Số 84 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 990000.00, NULL, 0.00, 30000.00, 1020000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(194, 360, 'LNS260814JIRQ147', 'Khách hàng 360', 'perf_customer_360@testlunara.local', '0965041182', 'Số 119 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1350000.00, NULL, 0.00, 30000.00, 1380000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(195, 322, 'LNS260922WO9P148', 'Khách hàng 322', 'perf_customer_322@testlunara.local', '0921662199', 'Số 136 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 730000.00, NULL, 0.00, 30000.00, 760000.00, 'vnpay', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(196, 355, 'LNS2608300GQ1149', 'Khách hàng 355', 'perf_customer_355@testlunara.local', '0919367537', 'Số 132 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1510000.00, NULL, 0.00, 30000.00, 1540000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(197, 404, 'LNS260724BG0F150', 'Khách hàng 404', 'perf_customer_404@testlunara.local', '0987378386', 'Số 84 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1370000.00, NULL, 0.00, 30000.00, 1400000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(198, 316, 'LNS261005KNQK151', 'Khách hàng 316', 'perf_customer_316@testlunara.local', '0926565912', 'Số 195 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1010000.00, NULL, 0.00, 30000.00, 1040000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(199, 338, 'LNS260710ACTE152', 'Khách hàng 338', 'perf_customer_338@testlunara.local', '0953776688', 'Số 45 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1830000.00, NULL, 0.00, 30000.00, 1860000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(200, 316, 'LNS26082885KP153', 'Khách hàng 316', 'perf_customer_316@testlunara.local', '0985981956', 'Số 166 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1360000.00, NULL, 0.00, 30000.00, 1390000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(201, 356, 'LNS260715KQEP154', 'Khách hàng 356', 'perf_customer_356@testlunara.local', '0949933088', 'Số 106 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 860000.00, NULL, 0.00, 30000.00, 890000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(202, 329, 'LNS260829VXHG155', 'Khách hàng 329', 'perf_customer_329@testlunara.local', '0942401821', 'Số 34 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 950000.00, NULL, 0.00, 30000.00, 980000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(203, 344, 'LNS261002NNP2156', 'Khách hàng 344', 'perf_customer_344@testlunara.local', '0934062420', 'Số 78 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1480000.00, NULL, 0.00, 30000.00, 1510000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(204, 323, 'LNS260914VIW7157', 'Khách hàng 323', 'perf_customer_323@testlunara.local', '0956569264', 'Số 111 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 720000.00, NULL, 0.00, 30000.00, 750000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(205, 394, 'LNS2607116XAN158', 'Khách hàng 394', 'perf_customer_394@testlunara.local', '0989768850', 'Số 17 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2000000.00, NULL, 0.00, 30000.00, 2030000.00, 'vnpay', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(206, 400, 'LNS260827FQQT159', 'Khách hàng 400', 'perf_customer_400@testlunara.local', '0959586823', 'Số 25 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1480000.00, NULL, 0.00, 30000.00, 1510000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23');
INSERT INTO `orders` (`id`, `user_id`, `order_code`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `shipping_city`, `shipping_note`, `shipping_method`, `subtotal`, `coupon_code`, `discount_amount`, `shipping_fee`, `grand_total`, `payment_method`, `payment_status`, `order_status`, `inventory_restored_at`, `customer_note`, `placed_at`, `created_at`, `updated_at`) VALUES
(207, 1, 'LNS260727CNBW160', 'Khách hàng 1', 'perf_customer_1@testlunara.local', '0993490190', 'Số 42 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1520000.00, NULL, 0.00, 30000.00, 1550000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(208, 362, 'LNS260711L2GS161', 'Khách hàng 362', 'perf_customer_362@testlunara.local', '0915428536', 'Số 146 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 850000.00, NULL, 0.00, 30000.00, 880000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(209, 346, 'LNS2609228ZHS162', 'Khách hàng 346', 'perf_customer_346@testlunara.local', '0989836758', 'Số 149 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1270000.00, NULL, 0.00, 30000.00, 1300000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(210, 322, 'LNS2609088WKV163', 'Khách hàng 322', 'perf_customer_322@testlunara.local', '0998414163', 'Số 166 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1790000.00, NULL, 0.00, 30000.00, 1820000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(211, 411, 'LNS260902XBXC164', 'Khách hàng 411', 'perf_customer_411@testlunara.local', '0941031328', 'Số 129 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1140000.00, NULL, 0.00, 30000.00, 1170000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(212, 390, 'LNS260717VR32165', 'Khách hàng 390', 'perf_customer_390@testlunara.local', '0984674163', 'Số 55 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1360000.00, NULL, 0.00, 30000.00, 1390000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(213, 368, 'LNS260718TRMD166', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0912091169', 'Số 80 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1950000.00, NULL, 0.00, 30000.00, 1980000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(214, 321, 'LNS261005ZHKK167', 'Khách hàng 321', 'perf_customer_321@testlunara.local', '0961938823', 'Số 160 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1480000.00, NULL, 0.00, 30000.00, 1510000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(215, 373, 'LNS260715SYN1168', 'Khách hàng 373', 'perf_customer_373@testlunara.local', '0956173595', 'Số 38 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1200000.00, NULL, 0.00, 30000.00, 1230000.00, 'vnpay', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(216, 408, 'LNS260719ZT3Q169', 'Khách hàng 408', 'perf_customer_408@testlunara.local', '0942985913', 'Số 58 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 870000.00, NULL, 0.00, 30000.00, 900000.00, 'vnpay', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(217, 332, 'LNS260820AJXN170', 'Khách hàng 332', 'perf_customer_332@testlunara.local', '0923377165', 'Số 192 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1760000.00, NULL, 0.00, 30000.00, 1790000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(218, 337, 'LNS260914WBRV171', 'Khách hàng 337', 'perf_customer_337@testlunara.local', '0913433770', 'Số 67 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'vnpay', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(219, 364, 'LNS260721CRLK172', 'Khách hàng 364', 'perf_customer_364@testlunara.local', '0977038185', 'Số 75 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1880000.00, NULL, 0.00, 30000.00, 1910000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(220, 409, 'LNS260812JP23173', 'Khách hàng 409', 'perf_customer_409@testlunara.local', '0925360284', 'Số 61 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1410000.00, NULL, 0.00, 30000.00, 1440000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(221, 412, 'LNS260802VK90174', 'Khách hàng 412', 'perf_customer_412@testlunara.local', '0929715705', 'Số 104 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1080000.00, NULL, 0.00, 30000.00, 1110000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(222, 334, 'LNS260723BDCC175', 'Khách hàng 334', 'perf_customer_334@testlunara.local', '0914316069', 'Số 76 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1450000.00, NULL, 0.00, 30000.00, 1480000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(223, 409, 'LNS260716ZQYY176', 'Khách hàng 409', 'perf_customer_409@testlunara.local', '0921304637', 'Số 138 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2190000.00, NULL, 0.00, 30000.00, 2220000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(224, 404, 'LNS260723UMCS177', 'Khách hàng 404', 'perf_customer_404@testlunara.local', '0924988246', 'Số 63 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 810000.00, NULL, 0.00, 30000.00, 840000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(225, 322, 'LNS260906XHNI178', 'Khách hàng 322', 'perf_customer_322@testlunara.local', '0998647540', 'Số 178 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1690000.00, NULL, 0.00, 30000.00, 1720000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(226, 368, 'LNS260806IIZL179', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0924306748', 'Số 110 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 850000.00, NULL, 0.00, 30000.00, 880000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(227, 317, 'LNS260829FL1N180', 'Khách hàng 317', 'perf_customer_317@testlunara.local', '0933112948', 'Số 127 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1920000.00, NULL, 0.00, 30000.00, 1950000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(228, 388, 'LNS260725XRGF181', 'Khách hàng 388', 'perf_customer_388@testlunara.local', '0916045234', 'Số 84 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1360000.00, NULL, 0.00, 30000.00, 1390000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(229, 335, 'LNS260913SZI7182', 'Khách hàng 335', 'perf_customer_335@testlunara.local', '0993992383', 'Số 4 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1530000.00, NULL, 0.00, 30000.00, 1560000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(230, 334, 'LNS260715KZDR183', 'Khách hàng 334', 'perf_customer_334@testlunara.local', '0974590361', 'Số 121 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 730000.00, NULL, 0.00, 30000.00, 760000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(231, 327, 'LNS260831KIK5184', 'Khách hàng 327', 'perf_customer_327@testlunara.local', '0915028917', 'Số 181 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1520000.00, NULL, 0.00, 30000.00, 1550000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(232, 328, 'LNS260730QIBT185', 'Khách hàng 328', 'perf_customer_328@testlunara.local', '0985753235', 'Số 97 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1370000.00, NULL, 0.00, 30000.00, 1400000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(233, 349, 'LNS261001VRTE186', 'Khách hàng 349', 'perf_customer_349@testlunara.local', '0955019724', 'Số 111 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 900000.00, NULL, 0.00, 30000.00, 930000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(234, 404, 'LNS260818NTU4187', 'Khách hàng 404', 'perf_customer_404@testlunara.local', '0946241598', 'Số 85 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1560000.00, NULL, 0.00, 30000.00, 1590000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(235, 371, 'LNS260826JT0U188', 'Khách hàng 371', 'perf_customer_371@testlunara.local', '0935937148', 'Số 86 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1080000.00, NULL, 0.00, 30000.00, 1110000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(236, 5, 'LNS260818ASAL189', 'Khách hàng 5', 'perf_customer_5@testlunara.local', '0995224596', 'Số 140 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1280000.00, NULL, 0.00, 30000.00, 1310000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(237, 320, 'LNS260710ZRUN190', 'Khách hàng 320', 'perf_customer_320@testlunara.local', '0994461459', 'Số 99 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 900000.00, NULL, 0.00, 30000.00, 930000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(238, 371, 'LNS2609281Z8Q191', 'Khách hàng 371', 'perf_customer_371@testlunara.local', '0919278580', 'Số 135 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 990000.00, NULL, 0.00, 30000.00, 1020000.00, 'vnpay', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(239, 325, 'LNS260827OUHE192', 'Khách hàng 325', 'perf_customer_325@testlunara.local', '0967764785', 'Số 172 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1510000.00, NULL, 0.00, 30000.00, 1540000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(240, 401, 'LNS260822FTRT193', 'Khách hàng 401', 'perf_customer_401@testlunara.local', '0982635280', 'Số 12 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 910000.00, NULL, 0.00, 30000.00, 940000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(241, 361, 'LNS2607142IOR194', 'Khách hàng 361', 'perf_customer_361@testlunara.local', '0980984446', 'Số 4 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1060000.00, NULL, 0.00, 30000.00, 1090000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(242, 316, 'LNS260729UUSH195', 'Khách hàng 316', 'perf_customer_316@testlunara.local', '0931943076', 'Số 152 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1180000.00, NULL, 0.00, 30000.00, 1210000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(243, 405, 'LNS2610020PAH196', 'Khách hàng 405', 'perf_customer_405@testlunara.local', '0993659474', 'Số 84 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 590000.00, NULL, 0.00, 30000.00, 620000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(244, 344, 'LNS2609254QSD197', 'Khách hàng 344', 'perf_customer_344@testlunara.local', '0987416064', 'Số 144 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 890000.00, NULL, 0.00, 30000.00, 920000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(245, 413, 'LNS2607284PLO198', 'Khách hàng 413', 'perf_customer_413@testlunara.local', '0947923097', 'Số 58 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 550000.00, NULL, 0.00, 30000.00, 580000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(246, 317, 'LNS261003UMYT199', 'Khách hàng 317', 'perf_customer_317@testlunara.local', '0973488498', 'Số 76 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1130000.00, NULL, 0.00, 30000.00, 1160000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(247, 356, 'LNS260807QWX8200', 'Khách hàng 356', 'perf_customer_356@testlunara.local', '0923714568', 'Số 23 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1390000.00, NULL, 0.00, 30000.00, 1420000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(248, 359, 'LNS260805MMAG201', 'Khách hàng 359', 'perf_customer_359@testlunara.local', '0914719055', 'Số 102 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1580000.00, NULL, 0.00, 30000.00, 1610000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(249, 333, 'LNS260817MBDC202', 'Khách hàng 333', 'perf_customer_333@testlunara.local', '0994526521', 'Số 7 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1120000.00, NULL, 0.00, 30000.00, 1150000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(250, 336, 'LNS260720DOMR203', 'Khách hàng 336', 'perf_customer_336@testlunara.local', '0961139629', 'Số 126 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1060000.00, NULL, 0.00, 30000.00, 1090000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(251, 393, 'LNS260904OTQH204', 'Khách hàng 393', 'perf_customer_393@testlunara.local', '0917405431', 'Số 167 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1440000.00, NULL, 0.00, 30000.00, 1470000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(252, 335, 'LNS260725AISI205', 'Khách hàng 335', 'perf_customer_335@testlunara.local', '0966892112', 'Số 83 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1490000.00, NULL, 0.00, 30000.00, 1520000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(253, 364, 'LNS260824YB0X206', 'Khách hàng 364', 'perf_customer_364@testlunara.local', '0919613161', 'Số 118 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1440000.00, NULL, 0.00, 30000.00, 1470000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(254, 327, 'LNS260819ZP7X207', 'Khách hàng 327', 'perf_customer_327@testlunara.local', '0926625864', 'Số 188 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1600000.00, NULL, 0.00, 30000.00, 1630000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(255, 381, 'LNS260927G6XF208', 'Khách hàng 381', 'perf_customer_381@testlunara.local', '0986226397', 'Số 96 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1400000.00, NULL, 0.00, 30000.00, 1430000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(256, 338, 'LNS260814HTES209', 'Khách hàng 338', 'perf_customer_338@testlunara.local', '0972170010', 'Số 102 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 720000.00, NULL, 0.00, 30000.00, 750000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(257, 386, 'LNS2608041DLT210', 'Khách hàng 386', 'perf_customer_386@testlunara.local', '0952568431', 'Số 104 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 990000.00, NULL, 0.00, 30000.00, 1020000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(258, 1, 'LNS2609055UXT211', 'Khách hàng 1', 'perf_customer_1@testlunara.local', '0928283782', 'Số 41 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1780000.00, NULL, 0.00, 30000.00, 1810000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(259, 333, 'LNS261006V3CM212', 'Khách hàng 333', 'perf_customer_333@testlunara.local', '0942454066', 'Số 181 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1190000.00, NULL, 0.00, 30000.00, 1220000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(260, 371, 'LNS260925HEZN213', 'Khách hàng 371', 'perf_customer_371@testlunara.local', '0982793603', 'Số 47 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 820000.00, NULL, 0.00, 30000.00, 850000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(261, 385, 'LNS260830WU56214', 'Khách hàng 385', 'perf_customer_385@testlunara.local', '0959024965', 'Số 99 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1600000.00, NULL, 0.00, 30000.00, 1630000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(262, 332, 'LNS260713KQBA215', 'Khách hàng 332', 'perf_customer_332@testlunara.local', '0993310340', 'Số 179 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1480000.00, NULL, 0.00, 30000.00, 1510000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(263, 337, 'LNS260928KXLG216', 'Khách hàng 337', 'perf_customer_337@testlunara.local', '0921633339', 'Số 58 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1270000.00, NULL, 0.00, 30000.00, 1300000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(264, 340, 'LNS260731ZFWP217', 'Khách hàng 340', 'perf_customer_340@testlunara.local', '0997221584', 'Số 197 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 600000.00, NULL, 0.00, 30000.00, 630000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(265, 320, 'LNS260724FBWM218', 'Khách hàng 320', 'perf_customer_320@testlunara.local', '0959681853', 'Số 124 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1990000.00, NULL, 0.00, 30000.00, 2020000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(266, 380, 'LNS260827BWCA219', 'Khách hàng 380', 'perf_customer_380@testlunara.local', '0955509346', 'Số 13 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 980000.00, NULL, 0.00, 30000.00, 1010000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(267, 341, 'LNS260923HZPW220', 'Khách hàng 341', 'perf_customer_341@testlunara.local', '0955049248', 'Số 112 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 780000.00, NULL, 0.00, 30000.00, 810000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(268, 392, 'LNS2608077F2F221', 'Khách hàng 392', 'perf_customer_392@testlunara.local', '0915607392', 'Số 95 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 920000.00, NULL, 0.00, 30000.00, 950000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(269, 345, 'LNS260716CM6V222', 'Khách hàng 345', 'perf_customer_345@testlunara.local', '0958625779', 'Số 80 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 520000.00, NULL, 0.00, 30000.00, 550000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(270, 387, 'LNS260824ZDMJ223', 'Khách hàng 387', 'perf_customer_387@testlunara.local', '0953792197', 'Số 36 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1320000.00, NULL, 0.00, 30000.00, 1350000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(271, 417, 'LNS260815DMHU224', 'Khách hàng 417', 'perf_customer_417@testlunara.local', '0923532734', 'Số 110 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1920000.00, NULL, 0.00, 30000.00, 1950000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(272, 376, 'LNS260822QKAW225', 'Khách hàng 376', 'perf_customer_376@testlunara.local', '0931618221', 'Số 9 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1370000.00, NULL, 0.00, 30000.00, 1400000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(273, 368, 'LNS260801IQES226', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0976990696', 'Số 67 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1580000.00, NULL, 0.00, 30000.00, 1610000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(274, 403, 'LNS260715LW1W227', 'Khách hàng 403', 'perf_customer_403@testlunara.local', '0970903582', 'Số 11 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1540000.00, NULL, 0.00, 30000.00, 1570000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(275, 359, 'LNS260904TEBC228', 'Khách hàng 359', 'perf_customer_359@testlunara.local', '0944471938', 'Số 126 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1060000.00, NULL, 0.00, 30000.00, 1090000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(276, 319, 'LNS260731V7M4229', 'Khách hàng 319', 'perf_customer_319@testlunara.local', '0958868191', 'Số 135 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1220000.00, NULL, 0.00, 30000.00, 1250000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(277, 342, 'LNS260825TMWM230', 'Khách hàng 342', 'perf_customer_342@testlunara.local', '0930988848', 'Số 16 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1760000.00, NULL, 0.00, 30000.00, 1790000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(278, 415, 'LNS261001H7OH231', 'Khách hàng 415', 'perf_customer_415@testlunara.local', '0997508736', 'Số 21 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 730000.00, NULL, 0.00, 30000.00, 760000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(279, 378, 'LNS260710EH0V232', 'Khách hàng 378', 'perf_customer_378@testlunara.local', '0928259394', 'Số 138 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 640000.00, NULL, 0.00, 30000.00, 670000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(280, 389, 'LNS26071210PP233', 'Khách hàng 389', 'perf_customer_389@testlunara.local', '0935259847', 'Số 195 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 750000.00, NULL, 0.00, 30000.00, 780000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(281, 5, 'LNS260821BSCL234', 'Khách hàng 5', 'perf_customer_5@testlunara.local', '0995063049', 'Số 75 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1660000.00, NULL, 0.00, 30000.00, 1690000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(282, 334, 'LNS260907HT2J235', 'Khách hàng 334', 'perf_customer_334@testlunara.local', '0922741727', 'Số 189 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 830000.00, NULL, 0.00, 30000.00, 860000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(283, 337, 'LNS260809F0LX236', 'Khách hàng 337', 'perf_customer_337@testlunara.local', '0995101530', 'Số 59 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1360000.00, NULL, 0.00, 30000.00, 1390000.00, 'vnpay', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(284, 399, 'LNS260921YSKL237', 'Khách hàng 399', 'perf_customer_399@testlunara.local', '0914738956', 'Số 187 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1730000.00, NULL, 0.00, 30000.00, 1760000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(285, 353, 'LNS260820LKDL238', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0946747451', 'Số 119 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1000000.00, NULL, 0.00, 30000.00, 1030000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(286, 382, 'LNS260904EBBD239', 'Khách hàng 382', 'perf_customer_382@testlunara.local', '0980808327', 'Số 130 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1200000.00, NULL, 0.00, 30000.00, 1230000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(287, 320, 'LNS260725GQ9Z240', 'Khách hàng 320', 'perf_customer_320@testlunara.local', '0984479845', 'Số 200 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 750000.00, NULL, 0.00, 30000.00, 780000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(288, 327, 'LNS260724QW6U241', 'Khách hàng 327', 'perf_customer_327@testlunara.local', '0939304859', 'Số 142 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1860000.00, NULL, 0.00, 30000.00, 1890000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(289, 345, 'LNS260717YRL4242', 'Khách hàng 345', 'perf_customer_345@testlunara.local', '0981673073', 'Số 14 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1040000.00, NULL, 0.00, 30000.00, 1070000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(290, 315, 'LNS260913R8ZL243', 'Khách hàng 315', 'perf_customer_315@testlunara.local', '0978558541', 'Số 85 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1280000.00, NULL, 0.00, 30000.00, 1310000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(291, 373, 'LNS260710YUOT244', 'Khách hàng 373', 'perf_customer_373@testlunara.local', '0913593339', 'Số 194 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1660000.00, NULL, 0.00, 30000.00, 1690000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(292, 352, 'LNS260819VO0I245', 'Khách hàng 352', 'perf_customer_352@testlunara.local', '0993761210', 'Số 185 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1070000.00, NULL, 0.00, 30000.00, 1100000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(293, 340, 'LNS260831GIC3246', 'Khách hàng 340', 'perf_customer_340@testlunara.local', '0998905248', 'Số 147 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1280000.00, NULL, 0.00, 30000.00, 1310000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(294, 329, 'LNS2609203NI7247', 'Khách hàng 329', 'perf_customer_329@testlunara.local', '0915358251', 'Số 93 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1130000.00, NULL, 0.00, 30000.00, 1160000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(295, 381, 'LNS260713MAGW248', 'Khách hàng 381', 'perf_customer_381@testlunara.local', '0962972501', 'Số 154 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1620000.00, NULL, 0.00, 30000.00, 1650000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(296, 316, 'LNS260922CB4V249', 'Khách hàng 316', 'perf_customer_316@testlunara.local', '0960494905', 'Số 45 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1190000.00, NULL, 0.00, 30000.00, 1220000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(297, 389, 'LNS260919TRA1250', 'Khách hàng 389', 'perf_customer_389@testlunara.local', '0920590362', 'Số 103 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1000000.00, NULL, 0.00, 30000.00, 1030000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(298, 402, 'LNS260724SZGG251', 'Khách hàng 402', 'perf_customer_402@testlunara.local', '0969094926', 'Số 53 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1180000.00, NULL, 0.00, 30000.00, 1210000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(299, 351, 'LNS2608283MZC252', 'Khách hàng 351', 'perf_customer_351@testlunara.local', '0934267528', 'Số 171 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 620000.00, NULL, 0.00, 30000.00, 650000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(300, 406, 'LNS2607256HKG253', 'Khách hàng 406', 'perf_customer_406@testlunara.local', '0931455925', 'Số 66 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1460000.00, NULL, 0.00, 30000.00, 1490000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(301, 394, 'LNS261001D5KX254', 'Khách hàng 394', 'perf_customer_394@testlunara.local', '0931340533', 'Số 138 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1170000.00, NULL, 0.00, 30000.00, 1200000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(302, 348, 'LNS260831RV5S255', 'Khách hàng 348', 'perf_customer_348@testlunara.local', '0974650555', 'Số 181 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 770000.00, NULL, 0.00, 30000.00, 800000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(303, 374, 'LNS260828ALLZ256', 'Khách hàng 374', 'perf_customer_374@testlunara.local', '0922247357', 'Số 156 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 890000.00, NULL, 0.00, 30000.00, 920000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(304, 334, 'LNS260802QFLS257', 'Khách hàng 334', 'perf_customer_334@testlunara.local', '0917352257', 'Số 189 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 740000.00, NULL, 0.00, 30000.00, 770000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(305, 315, 'LNS260825B3OY258', 'Khách hàng 315', 'perf_customer_315@testlunara.local', '0950098588', 'Số 118 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 850000.00, NULL, 0.00, 30000.00, 880000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(306, 322, 'LNS2608267CJQ259', 'Khách hàng 322', 'perf_customer_322@testlunara.local', '0935629298', 'Số 73 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 870000.00, NULL, 0.00, 30000.00, 900000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(307, 381, 'LNS260909CFRE260', 'Khách hàng 381', 'perf_customer_381@testlunara.local', '0952911800', 'Số 134 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1040000.00, NULL, 0.00, 30000.00, 1070000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(308, 335, 'LNS260908SCRN261', 'Khách hàng 335', 'perf_customer_335@testlunara.local', '0960938490', 'Số 106 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 580000.00, NULL, 0.00, 30000.00, 610000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(309, 344, 'LNS260805V3W3262', 'Khách hàng 344', 'perf_customer_344@testlunara.local', '0951778150', 'Số 51 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1230000.00, NULL, 0.00, 30000.00, 1260000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(310, 377, 'LNS260730KNUX263', 'Khách hàng 377', 'perf_customer_377@testlunara.local', '0916611268', 'Số 67 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1770000.00, NULL, 0.00, 30000.00, 1800000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(311, 330, 'LNS260727HSVG264', 'Khách hàng 330', 'perf_customer_330@testlunara.local', '0917403689', 'Số 80 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1010000.00, NULL, 0.00, 30000.00, 1040000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(312, 364, 'LNS26092716O1265', 'Khách hàng 364', 'perf_customer_364@testlunara.local', '0911554316', 'Số 83 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1020000.00, NULL, 0.00, 30000.00, 1050000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(313, 366, 'LNS260802AH6U266', 'Khách hàng 366', 'perf_customer_366@testlunara.local', '0943667955', 'Số 134 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1700000.00, NULL, 0.00, 30000.00, 1730000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(314, 356, 'LNS2608128FEX267', 'Khách hàng 356', 'perf_customer_356@testlunara.local', '0983222909', 'Số 172 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1730000.00, NULL, 0.00, 30000.00, 1760000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(315, 386, 'LNS260731SW2D268', 'Khách hàng 386', 'perf_customer_386@testlunara.local', '0922666374', 'Số 140 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1280000.00, NULL, 0.00, 30000.00, 1310000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(316, 316, 'LNS260906YAUX269', 'Khách hàng 316', 'perf_customer_316@testlunara.local', '0958667883', 'Số 127 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1360000.00, NULL, 0.00, 30000.00, 1390000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(317, 415, 'LNS2610011NEX270', 'Khách hàng 415', 'perf_customer_415@testlunara.local', '0942542328', 'Số 154 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 690000.00, NULL, 0.00, 30000.00, 720000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(318, 368, 'LNS2609119UH1271', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0964464615', 'Số 3 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 850000.00, NULL, 0.00, 30000.00, 880000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(319, 337, 'LNS260801WY46272', 'Khách hàng 337', 'perf_customer_337@testlunara.local', '0974103261', 'Số 160 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1620000.00, NULL, 0.00, 30000.00, 1650000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(320, 325, 'LNS260728PWSG273', 'Khách hàng 325', 'perf_customer_325@testlunara.local', '0932009312', 'Số 53 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2000000.00, NULL, 0.00, 30000.00, 2030000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(321, 368, 'LNS2609084GFP274', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0980968688', 'Số 164 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1670000.00, NULL, 0.00, 30000.00, 1700000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(322, 362, 'LNS2607199VJH275', 'Khách hàng 362', 'perf_customer_362@testlunara.local', '0923487785', 'Số 32 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1410000.00, NULL, 0.00, 30000.00, 1440000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(323, 409, 'LNS260907D2OA276', 'Khách hàng 409', 'perf_customer_409@testlunara.local', '0915813155', 'Số 132 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1900000.00, NULL, 0.00, 30000.00, 1930000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(324, 348, 'LNS260831SMHM277', 'Khách hàng 348', 'perf_customer_348@testlunara.local', '0924807214', 'Số 13 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2010000.00, NULL, 0.00, 30000.00, 2040000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(325, 357, 'LNS260819JRJZ278', 'Khách hàng 357', 'perf_customer_357@testlunara.local', '0965307220', 'Số 167 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1270000.00, NULL, 0.00, 30000.00, 1300000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(326, 336, 'LNS2609184PES279', 'Khách hàng 336', 'perf_customer_336@testlunara.local', '0920855747', 'Số 193 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1320000.00, NULL, 0.00, 30000.00, 1350000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(327, 317, 'LNS260919OR6X280', 'Khách hàng 317', 'perf_customer_317@testlunara.local', '0918195572', 'Số 27 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1310000.00, NULL, 0.00, 30000.00, 1340000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(328, 391, 'LNS260731029S281', 'Khách hàng 391', 'perf_customer_391@testlunara.local', '0934950786', 'Số 81 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1850000.00, NULL, 0.00, 30000.00, 1880000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(329, 340, 'LNS260805O9DQ282', 'Khách hàng 340', 'perf_customer_340@testlunara.local', '0966123131', 'Số 168 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1390000.00, NULL, 0.00, 30000.00, 1420000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(330, 393, 'LNS260729IP0G283', 'Khách hàng 393', 'perf_customer_393@testlunara.local', '0920914659', 'Số 21 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1500000.00, NULL, 0.00, 30000.00, 1530000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(331, 354, 'LNS260819TTFY284', 'Khách hàng 354', 'perf_customer_354@testlunara.local', '0962063933', 'Số 133 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1150000.00, NULL, 0.00, 30000.00, 1180000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(332, 367, 'LNS260823J0BB285', 'Khách hàng 367', 'perf_customer_367@testlunara.local', '0944399794', 'Số 87 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2060000.00, NULL, 0.00, 30000.00, 2090000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(333, 382, 'LNS260730Z2AN286', 'Khách hàng 382', 'perf_customer_382@testlunara.local', '0993864671', 'Số 144 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1110000.00, NULL, 0.00, 30000.00, 1140000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(334, 329, 'LNS261006LKVH287', 'Khách hàng 329', 'perf_customer_329@testlunara.local', '0927405593', 'Số 38 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1130000.00, NULL, 0.00, 30000.00, 1160000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(335, 398, 'LNS260809IXVI288', 'Khách hàng 398', 'perf_customer_398@testlunara.local', '0999610600', 'Số 50 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1030000.00, NULL, 0.00, 30000.00, 1060000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(336, 330, 'LNS260714UIDR289', 'Khách hàng 330', 'perf_customer_330@testlunara.local', '0945168658', 'Số 17 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1290000.00, NULL, 0.00, 30000.00, 1320000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(337, 407, 'LNS260822DFQY290', 'Khách hàng 407', 'perf_customer_407@testlunara.local', '0946645259', 'Số 12 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1030000.00, NULL, 0.00, 30000.00, 1060000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(338, 415, 'LNS2609109IPE291', 'Khách hàng 415', 'perf_customer_415@testlunara.local', '0916531382', 'Số 46 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 850000.00, NULL, 0.00, 30000.00, 880000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(339, 413, 'LNS260831XN2D292', 'Khách hàng 413', 'perf_customer_413@testlunara.local', '0926619487', 'Số 132 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1340000.00, NULL, 0.00, 30000.00, 1370000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(340, 346, 'LNS260806IEYT293', 'Khách hàng 346', 'perf_customer_346@testlunara.local', '0915072346', 'Số 182 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1890000.00, NULL, 0.00, 30000.00, 1920000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(341, 364, 'LNS2609011UT6294', 'Khách hàng 364', 'perf_customer_364@testlunara.local', '0978511395', 'Số 7 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1230000.00, NULL, 0.00, 30000.00, 1260000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(342, 346, 'LNS261004AUVT295', 'Khách hàng 346', 'perf_customer_346@testlunara.local', '0989369740', 'Số 120 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1550000.00, NULL, 0.00, 30000.00, 1580000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(343, 379, 'LNS2607215CB1296', 'Khách hàng 379', 'perf_customer_379@testlunara.local', '0947160280', 'Số 97 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1500000.00, NULL, 0.00, 30000.00, 1530000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(344, 378, 'LNS260909GTFG297', 'Khách hàng 378', 'perf_customer_378@testlunara.local', '0984993108', 'Số 146 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1560000.00, NULL, 0.00, 30000.00, 1590000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(345, 353, 'LNS260806Y0PC298', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0981548704', 'Số 121 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 730000.00, NULL, 0.00, 30000.00, 760000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(346, 391, 'LNS260917OFOD299', 'Khách hàng 391', 'perf_customer_391@testlunara.local', '0947891274', 'Số 65 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(347, 392, 'LNS260914DKEB300', 'Khách hàng 392', 'perf_customer_392@testlunara.local', '0967411172', 'Số 16 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 650000.00, NULL, 0.00, 30000.00, 680000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(348, 414, 'LNS2609287MHK301', 'Khách hàng 414', 'perf_customer_414@testlunara.local', '0948046340', 'Số 40 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1570000.00, NULL, 0.00, 30000.00, 1600000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(349, 406, 'LNS260816P4QO302', 'Khách hàng 406', 'perf_customer_406@testlunara.local', '0956929477', 'Số 85 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1830000.00, NULL, 0.00, 30000.00, 1860000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(350, 342, 'LNS260831AD85303', 'Khách hàng 342', 'perf_customer_342@testlunara.local', '0994895142', 'Số 189 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2000000.00, NULL, 0.00, 30000.00, 2030000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(351, 358, 'LNS260929XKBM304', 'Khách hàng 358', 'perf_customer_358@testlunara.local', '0919814089', 'Số 130 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1190000.00, NULL, 0.00, 30000.00, 1220000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(352, 358, 'LNS260914XC6U305', 'Khách hàng 358', 'perf_customer_358@testlunara.local', '0990990141', 'Số 110 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1160000.00, NULL, 0.00, 30000.00, 1190000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(353, 395, 'LNS260914JPUZ306', 'Khách hàng 395', 'perf_customer_395@testlunara.local', '0936399911', 'Số 128 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1480000.00, NULL, 0.00, 30000.00, 1510000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(354, 390, 'LNS260823EIHB307', 'Khách hàng 390', 'perf_customer_390@testlunara.local', '0954498290', 'Số 65 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1340000.00, NULL, 0.00, 30000.00, 1370000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(355, 374, 'LNS261003WPM6308', 'Khách hàng 374', 'perf_customer_374@testlunara.local', '0921449677', 'Số 37 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1320000.00, NULL, 0.00, 30000.00, 1350000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(356, 330, 'LNS260804MGHT309', 'Khách hàng 330', 'perf_customer_330@testlunara.local', '0960377548', 'Số 166 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1570000.00, NULL, 0.00, 30000.00, 1600000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(357, 366, 'LNS261006CVZF310', 'Khách hàng 366', 'perf_customer_366@testlunara.local', '0911344581', 'Số 61 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 660000.00, NULL, 0.00, 30000.00, 690000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(358, 388, 'LNS260715FGHE311', 'Khách hàng 388', 'perf_customer_388@testlunara.local', '0965084061', 'Số 48 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1000000.00, NULL, 0.00, 30000.00, 1030000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(359, 325, 'LNS260914RIWU312', 'Khách hàng 325', 'perf_customer_325@testlunara.local', '0939589681', 'Số 154 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2240000.00, NULL, 0.00, 30000.00, 2270000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(360, 383, 'LNS260901AOXM313', 'Khách hàng 383', 'perf_customer_383@testlunara.local', '0914932288', 'Số 51 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1300000.00, NULL, 0.00, 30000.00, 1330000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(361, 397, 'LNS260731O7T3314', 'Khách hàng 397', 'perf_customer_397@testlunara.local', '0997772340', 'Số 79 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1350000.00, NULL, 0.00, 30000.00, 1380000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(362, 360, 'LNS260714L6NE315', 'Khách hàng 360', 'perf_customer_360@testlunara.local', '0979650932', 'Số 38 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2210000.00, NULL, 0.00, 30000.00, 2240000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(363, 371, 'LNS261007DI5R316', 'Khách hàng 371', 'perf_customer_371@testlunara.local', '0932121693', 'Số 113 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 870000.00, NULL, 0.00, 30000.00, 900000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(364, 354, 'LNS260816PAE6317', 'Khách hàng 354', 'perf_customer_354@testlunara.local', '0984908358', 'Số 83 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1330000.00, NULL, 0.00, 30000.00, 1360000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(365, 366, 'LNS260722STDO318', 'Khách hàng 366', 'perf_customer_366@testlunara.local', '0964068978', 'Số 34 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1400000.00, NULL, 0.00, 30000.00, 1430000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(366, 395, 'LNS260809QVAP319', 'Khách hàng 395', 'perf_customer_395@testlunara.local', '0910949850', 'Số 101 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1560000.00, NULL, 0.00, 30000.00, 1590000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(367, 406, 'LNS260901KLOC320', 'Khách hàng 406', 'perf_customer_406@testlunara.local', '0946599705', 'Số 95 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2230000.00, NULL, 0.00, 30000.00, 2260000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24');
INSERT INTO `orders` (`id`, `user_id`, `order_code`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `shipping_city`, `shipping_note`, `shipping_method`, `subtotal`, `coupon_code`, `discount_amount`, `shipping_fee`, `grand_total`, `payment_method`, `payment_status`, `order_status`, `inventory_restored_at`, `customer_note`, `placed_at`, `created_at`, `updated_at`) VALUES
(368, 381, 'LNS260828FN52321', 'Khách hàng 381', 'perf_customer_381@testlunara.local', '0974004331', 'Số 57 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2240000.00, NULL, 0.00, 30000.00, 2270000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(369, 347, 'LNS260723LHNP322', 'Khách hàng 347', 'perf_customer_347@testlunara.local', '0990121160', 'Số 158 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 550000.00, NULL, 0.00, 30000.00, 580000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(370, 318, 'LNS260801WAXF323', 'Khách hàng 318', 'perf_customer_318@testlunara.local', '0980687430', 'Số 19 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1060000.00, NULL, 0.00, 30000.00, 1090000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(371, 344, 'LNS260714UQXK324', 'Khách hàng 344', 'perf_customer_344@testlunara.local', '0987023665', 'Số 123 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(372, 366, 'LNS2608082JJ6325', 'Khách hàng 366', 'perf_customer_366@testlunara.local', '0939034323', 'Số 106 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1170000.00, NULL, 0.00, 30000.00, 1200000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(373, 316, 'LNS260819AG38326', 'Khách hàng 316', 'perf_customer_316@testlunara.local', '0953150908', 'Số 80 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1640000.00, NULL, 0.00, 30000.00, 1670000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(374, 368, 'LNS2607117XVV327', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0938769399', 'Số 95 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1510000.00, NULL, 0.00, 30000.00, 1540000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(375, 382, 'LNS260811CRV7328', 'Khách hàng 382', 'perf_customer_382@testlunara.local', '0984564162', 'Số 122 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1370000.00, NULL, 0.00, 30000.00, 1400000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(376, 391, 'LNS2609046GFD329', 'Khách hàng 391', 'perf_customer_391@testlunara.local', '0970597449', 'Số 176 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1450000.00, NULL, 0.00, 30000.00, 1480000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(377, 378, 'LNS260719Q8NP330', 'Khách hàng 378', 'perf_customer_378@testlunara.local', '0931916704', 'Số 154 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 980000.00, NULL, 0.00, 30000.00, 1010000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(378, 407, 'LNS260812AJIY331', 'Khách hàng 407', 'perf_customer_407@testlunara.local', '0953689821', 'Số 92 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1410000.00, NULL, 0.00, 30000.00, 1440000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(379, 368, 'LNS260928USDP332', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0970347676', 'Số 107 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1480000.00, NULL, 0.00, 30000.00, 1510000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(380, 361, 'LNS260910SGEB333', 'Khách hàng 361', 'perf_customer_361@testlunara.local', '0981355768', 'Số 34 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1890000.00, NULL, 0.00, 30000.00, 1920000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(381, 391, 'LNS260929X1VQ334', 'Khách hàng 391', 'perf_customer_391@testlunara.local', '0978460142', 'Số 20 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1830000.00, NULL, 0.00, 30000.00, 1860000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(382, 319, 'LNS260730WUA6335', 'Khách hàng 319', 'perf_customer_319@testlunara.local', '0954554372', 'Số 28 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1570000.00, NULL, 0.00, 30000.00, 1600000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(383, 341, 'LNS2608112LQJ336', 'Khách hàng 341', 'perf_customer_341@testlunara.local', '0918868429', 'Số 124 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1280000.00, NULL, 0.00, 30000.00, 1310000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(384, 402, 'LNS260828SBP7337', 'Khách hàng 402', 'perf_customer_402@testlunara.local', '0956338279', 'Số 110 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1340000.00, NULL, 0.00, 30000.00, 1370000.00, 'vnpay', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(385, 373, 'LNS260929DRWH338', 'Khách hàng 373', 'perf_customer_373@testlunara.local', '0972106643', 'Số 20 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1430000.00, NULL, 0.00, 30000.00, 1460000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(386, 388, 'LNS260713MY9Q339', 'Khách hàng 388', 'perf_customer_388@testlunara.local', '0977890637', 'Số 8 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1460000.00, NULL, 0.00, 30000.00, 1490000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(387, 361, 'LNS261004IVQC340', 'Khách hàng 361', 'perf_customer_361@testlunara.local', '0924298093', 'Số 46 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1620000.00, NULL, 0.00, 30000.00, 1650000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(388, 395, 'LNS260801MFKO341', 'Khách hàng 395', 'perf_customer_395@testlunara.local', '0924283942', 'Số 87 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1980000.00, NULL, 0.00, 30000.00, 2010000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(389, 322, 'LNS2607257HY2342', 'Khách hàng 322', 'perf_customer_322@testlunara.local', '0987899902', 'Số 169 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1530000.00, NULL, 0.00, 30000.00, 1560000.00, 'vnpay', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(390, 317, 'LNS260920VSY0343', 'Khách hàng 317', 'perf_customer_317@testlunara.local', '0937190046', 'Số 193 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1060000.00, NULL, 0.00, 30000.00, 1090000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(391, 401, 'LNS260727RY3Z344', 'Khách hàng 401', 'perf_customer_401@testlunara.local', '0956700760', 'Số 104 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1460000.00, NULL, 0.00, 30000.00, 1490000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(392, 402, 'LNS261003OES1345', 'Khách hàng 402', 'perf_customer_402@testlunara.local', '0924672497', 'Số 55 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1040000.00, NULL, 0.00, 30000.00, 1070000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(393, 338, 'LNS260811WMMV346', 'Khách hàng 338', 'perf_customer_338@testlunara.local', '0955380393', 'Số 185 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 980000.00, NULL, 0.00, 30000.00, 1010000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(394, 336, 'LNS260717JNLI347', 'Khách hàng 336', 'perf_customer_336@testlunara.local', '0976012902', 'Số 100 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1220000.00, NULL, 0.00, 30000.00, 1250000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(395, 403, 'LNS260729LKEZ348', 'Khách hàng 403', 'perf_customer_403@testlunara.local', '0940869714', 'Số 147 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1520000.00, NULL, 0.00, 30000.00, 1550000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(396, 318, 'LNS260917J6EI349', 'Khách hàng 318', 'perf_customer_318@testlunara.local', '0954429000', 'Số 166 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1480000.00, NULL, 0.00, 30000.00, 1510000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(397, 372, 'LNS260927JLAP350', 'Khách hàng 372', 'perf_customer_372@testlunara.local', '0947450532', 'Số 23 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1680000.00, NULL, 0.00, 30000.00, 1710000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(398, 362, 'LNS260828PDHI351', 'Khách hàng 362', 'perf_customer_362@testlunara.local', '0992719001', 'Số 91 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 910000.00, NULL, 0.00, 30000.00, 940000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(399, 388, 'LNS260927LARP352', 'Khách hàng 388', 'perf_customer_388@testlunara.local', '0949153820', 'Số 92 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1020000.00, NULL, 0.00, 30000.00, 1050000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(400, 389, 'LNS2609140VT1353', 'Khách hàng 389', 'perf_customer_389@testlunara.local', '0938089070', 'Số 71 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1520000.00, NULL, 0.00, 30000.00, 1550000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(401, 5, 'LNS260804YYSU354', 'Khách hàng 5', 'perf_customer_5@testlunara.local', '0967930762', 'Số 198 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1000000.00, NULL, 0.00, 30000.00, 1030000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(402, 402, 'LNS260917AIYG355', 'Khách hàng 402', 'perf_customer_402@testlunara.local', '0986906393', 'Số 51 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1610000.00, NULL, 0.00, 30000.00, 1640000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(403, 357, 'LNS260715J1SZ356', 'Khách hàng 357', 'perf_customer_357@testlunara.local', '0992257428', 'Số 76 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1130000.00, NULL, 0.00, 30000.00, 1160000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(404, 5, 'LNS260908Y70Y357', 'Khách hàng 5', 'perf_customer_5@testlunara.local', '0961034868', 'Số 140 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1220000.00, NULL, 0.00, 30000.00, 1250000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(405, 398, 'LNS260818MX5O358', 'Khách hàng 398', 'perf_customer_398@testlunara.local', '0978172948', 'Số 2 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1060000.00, NULL, 0.00, 30000.00, 1090000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(406, 364, 'LNS260929BG5G359', 'Khách hàng 364', 'perf_customer_364@testlunara.local', '0963508351', 'Số 87 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 910000.00, NULL, 0.00, 30000.00, 940000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(407, 358, 'LNS260824COGH360', 'Khách hàng 358', 'perf_customer_358@testlunara.local', '0942403707', 'Số 146 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1350000.00, NULL, 0.00, 30000.00, 1380000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(408, 353, 'LNS260825LGBA361', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0932103987', 'Số 172 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1070000.00, NULL, 0.00, 30000.00, 1100000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(409, 371, 'LNS26090308QS362', 'Khách hàng 371', 'perf_customer_371@testlunara.local', '0969070739', 'Số 75 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 750000.00, NULL, 0.00, 30000.00, 780000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(410, 389, 'LNS260722THHG363', 'Khách hàng 389', 'perf_customer_389@testlunara.local', '0919064873', 'Số 45 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1400000.00, NULL, 0.00, 30000.00, 1430000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(411, 388, 'LNS26082429FC364', 'Khách hàng 388', 'perf_customer_388@testlunara.local', '0986753759', 'Số 49 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1120000.00, NULL, 0.00, 30000.00, 1150000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(412, 372, 'LNS2608032HJ3365', 'Khách hàng 372', 'perf_customer_372@testlunara.local', '0931167676', 'Số 13 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1700000.00, NULL, 0.00, 30000.00, 1730000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(413, 351, 'LNS260816LEEL366', 'Khách hàng 351', 'perf_customer_351@testlunara.local', '0941149713', 'Số 146 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2060000.00, NULL, 0.00, 30000.00, 2090000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(414, 361, 'LNS2608272WDA367', 'Khách hàng 361', 'perf_customer_361@testlunara.local', '0950199216', 'Số 148 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1080000.00, NULL, 0.00, 30000.00, 1110000.00, 'vnpay', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(415, 332, 'LNS260915TBO8368', 'Khách hàng 332', 'perf_customer_332@testlunara.local', '0917354978', 'Số 149 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 990000.00, NULL, 0.00, 30000.00, 1020000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(416, 375, 'LNS260819AKAG369', 'Khách hàng 375', 'perf_customer_375@testlunara.local', '0926801311', 'Số 35 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1830000.00, NULL, 0.00, 30000.00, 1860000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(417, 399, 'LNS2607224ZCE370', 'Khách hàng 399', 'perf_customer_399@testlunara.local', '0979182424', 'Số 93 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1400000.00, NULL, 0.00, 30000.00, 1430000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(418, 326, 'LNS260826BJUV371', 'Khách hàng 326', 'perf_customer_326@testlunara.local', '0975716967', 'Số 21 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1740000.00, NULL, 0.00, 30000.00, 1770000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(419, 388, 'LNS2608133ILT372', 'Khách hàng 388', 'perf_customer_388@testlunara.local', '0939521744', 'Số 194 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1640000.00, NULL, 0.00, 30000.00, 1670000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(420, 403, 'LNS261001JQA9373', 'Khách hàng 403', 'perf_customer_403@testlunara.local', '0996829156', 'Số 95 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1460000.00, NULL, 0.00, 30000.00, 1490000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(421, 373, 'LNS261006J9JM374', 'Khách hàng 373', 'perf_customer_373@testlunara.local', '0985438758', 'Số 121 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1130000.00, NULL, 0.00, 30000.00, 1160000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(422, 338, 'LNS260808HCHQ375', 'Khách hàng 338', 'perf_customer_338@testlunara.local', '0975247118', 'Số 43 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1450000.00, NULL, 0.00, 30000.00, 1480000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(423, 363, 'LNS260720DWI4376', 'Khách hàng 363', 'perf_customer_363@testlunara.local', '0927302021', 'Số 115 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1720000.00, NULL, 0.00, 30000.00, 1750000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(424, 393, 'LNS260910HTLV377', 'Khách hàng 393', 'perf_customer_393@testlunara.local', '0920971304', 'Số 16 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1680000.00, NULL, 0.00, 30000.00, 1710000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(425, 325, 'LNS260714HEPS378', 'Khách hàng 325', 'perf_customer_325@testlunara.local', '0917590700', 'Số 114 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 800000.00, NULL, 0.00, 30000.00, 830000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(426, 326, 'LNS260918ZML0379', 'Khách hàng 326', 'perf_customer_326@testlunara.local', '0958041115', 'Số 64 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1270000.00, NULL, 0.00, 30000.00, 1300000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(427, 364, 'LNS261002RLA6380', 'Khách hàng 364', 'perf_customer_364@testlunara.local', '0996576278', 'Số 149 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(428, 340, 'LNS260824YXWA381', 'Khách hàng 340', 'perf_customer_340@testlunara.local', '0985306359', 'Số 153 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1480000.00, NULL, 0.00, 30000.00, 1510000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(429, 384, 'LNS260815K1YK382', 'Khách hàng 384', 'perf_customer_384@testlunara.local', '0973011302', 'Số 82 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1360000.00, NULL, 0.00, 30000.00, 1390000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(430, 357, 'LNS26083111BD383', 'Khách hàng 357', 'perf_customer_357@testlunara.local', '0981246352', 'Số 30 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1760000.00, NULL, 0.00, 30000.00, 1790000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(431, 377, 'LNS260725P66W384', 'Khách hàng 377', 'perf_customer_377@testlunara.local', '0927423711', 'Số 96 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1960000.00, NULL, 0.00, 30000.00, 1990000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(432, 413, 'LNS260724BTDK385', 'Khách hàng 413', 'perf_customer_413@testlunara.local', '0983486918', 'Số 100 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(433, 393, 'LNS260925OMDO386', 'Khách hàng 393', 'perf_customer_393@testlunara.local', '0961442773', 'Số 45 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1760000.00, NULL, 0.00, 30000.00, 1790000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(434, 398, 'LNS260901ODIL387', 'Khách hàng 398', 'perf_customer_398@testlunara.local', '0915778084', 'Số 175 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 480000.00, NULL, 0.00, 30000.00, 510000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(435, 405, 'LNS260729UERC388', 'Khách hàng 405', 'perf_customer_405@testlunara.local', '0990039739', 'Số 181 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1030000.00, NULL, 0.00, 30000.00, 1060000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(436, 324, 'LNS260729N4OP389', 'Khách hàng 324', 'perf_customer_324@testlunara.local', '0956640047', 'Số 150 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1660000.00, NULL, 0.00, 30000.00, 1690000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(437, 319, 'LNS260927QBMA390', 'Khách hàng 319', 'perf_customer_319@testlunara.local', '0992654362', 'Số 38 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 820000.00, NULL, 0.00, 30000.00, 850000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(438, 357, 'LNS260815HZID391', 'Khách hàng 357', 'perf_customer_357@testlunara.local', '0967733325', 'Số 46 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1790000.00, NULL, 0.00, 30000.00, 1820000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(439, 374, 'LNS260827BM8C392', 'Khách hàng 374', 'perf_customer_374@testlunara.local', '0929071655', 'Số 198 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1810000.00, NULL, 0.00, 30000.00, 1840000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(440, 344, 'LNS260823KB3U393', 'Khách hàng 344', 'perf_customer_344@testlunara.local', '0941646784', 'Số 154 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1670000.00, NULL, 0.00, 30000.00, 1700000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(441, 316, 'LNS260927MGAG394', 'Khách hàng 316', 'perf_customer_316@testlunara.local', '0981503439', 'Số 60 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1550000.00, NULL, 0.00, 30000.00, 1580000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(442, 325, 'LNS260730YARH395', 'Khách hàng 325', 'perf_customer_325@testlunara.local', '0983457730', 'Số 134 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1720000.00, NULL, 0.00, 30000.00, 1750000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(443, 353, 'LNS2609119R69396', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0942072820', 'Số 192 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1020000.00, NULL, 0.00, 30000.00, 1050000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(444, 355, 'LNS260711EODD397', 'Khách hàng 355', 'perf_customer_355@testlunara.local', '0925811925', 'Số 193 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1960000.00, NULL, 0.00, 30000.00, 1990000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(445, 392, 'LNS260924GMIP398', 'Khách hàng 392', 'perf_customer_392@testlunara.local', '0986639395', 'Số 168 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1660000.00, NULL, 0.00, 30000.00, 1690000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(446, 363, 'LNS260916TV7U399', 'Khách hàng 363', 'perf_customer_363@testlunara.local', '0938393012', 'Số 24 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1900000.00, NULL, 0.00, 30000.00, 1930000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(447, 317, 'LNS260929P0K1400', 'Khách hàng 317', 'perf_customer_317@testlunara.local', '0983331138', 'Số 36 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1040000.00, NULL, 0.00, 30000.00, 1070000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(448, 398, 'LNS2610020JJR401', 'Khách hàng 398', 'perf_customer_398@testlunara.local', '0923872545', 'Số 26 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1160000.00, NULL, 0.00, 30000.00, 1190000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(449, 385, 'LNS260717ZVT9402', 'Khách hàng 385', 'perf_customer_385@testlunara.local', '0930059429', 'Số 21 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 760000.00, NULL, 0.00, 30000.00, 790000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(450, 339, 'LNS260921QVO1403', 'Khách hàng 339', 'perf_customer_339@testlunara.local', '0991728932', 'Số 130 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1420000.00, NULL, 0.00, 30000.00, 1450000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(451, 375, 'LNS2609248RBH404', 'Khách hàng 375', 'perf_customer_375@testlunara.local', '0992858973', 'Số 80 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1080000.00, NULL, 0.00, 30000.00, 1110000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(452, 384, 'LNS260715IAIV405', 'Khách hàng 384', 'perf_customer_384@testlunara.local', '0954610317', 'Số 187 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1560000.00, NULL, 0.00, 30000.00, 1590000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(453, 408, 'LNS261005JFNP406', 'Khách hàng 408', 'perf_customer_408@testlunara.local', '0953331120', 'Số 110 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1300000.00, NULL, 0.00, 30000.00, 1330000.00, 'cod', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(454, 358, 'LNS26092240M6407', 'Khách hàng 358', 'perf_customer_358@testlunara.local', '0960783659', 'Số 19 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 870000.00, NULL, 0.00, 30000.00, 900000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(455, 337, 'LNS260901AFHA408', 'Khách hàng 337', 'perf_customer_337@testlunara.local', '0955355764', 'Số 45 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1060000.00, NULL, 0.00, 30000.00, 1090000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(456, 349, 'LNS260927JRCB409', 'Khách hàng 349', 'perf_customer_349@testlunara.local', '0948748507', 'Số 144 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1700000.00, NULL, 0.00, 30000.00, 1730000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(457, 368, 'LNS260804MPZV410', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0912087463', 'Số 56 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 470000.00, NULL, 0.00, 30000.00, 500000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(458, 368, 'LNS260917BWO1411', 'Khách hàng 368', 'perf_customer_368@testlunara.local', '0967155247', 'Số 164 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 670000.00, NULL, 0.00, 30000.00, 700000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(459, 366, 'LNS260722HSEJ412', 'Khách hàng 366', 'perf_customer_366@testlunara.local', '0938694465', 'Số 110 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1780000.00, NULL, 0.00, 30000.00, 1810000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(460, 404, 'LNS260826WGIM413', 'Khách hàng 404', 'perf_customer_404@testlunara.local', '0934066382', 'Số 188 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1190000.00, NULL, 0.00, 30000.00, 1220000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(461, 404, 'LNS260809HJ4R414', 'Khách hàng 404', 'perf_customer_404@testlunara.local', '0938377089', 'Số 49 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1190000.00, NULL, 0.00, 30000.00, 1220000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(462, 1, 'LNS260911FAEA415', 'Khách hàng 1', 'perf_customer_1@testlunara.local', '0983883199', 'Số 122 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1360000.00, NULL, 0.00, 30000.00, 1390000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(463, 409, 'LNS261001VTRI416', 'Khách hàng 409', 'perf_customer_409@testlunara.local', '0957309858', 'Số 160 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1280000.00, NULL, 0.00, 30000.00, 1310000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(464, 1, 'LNS260906FA6O417', 'Khách hàng 1', 'perf_customer_1@testlunara.local', '0955781926', 'Số 23 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1580000.00, NULL, 0.00, 30000.00, 1610000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(465, 347, 'LNS260921DA10418', 'Khách hàng 347', 'perf_customer_347@testlunara.local', '0976462551', 'Số 28 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1660000.00, NULL, 0.00, 30000.00, 1690000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(466, 373, 'LNS260909D9HG419', 'Khách hàng 373', 'perf_customer_373@testlunara.local', '0939925128', 'Số 124 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 950000.00, NULL, 0.00, 30000.00, 980000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(467, 414, 'LNS260805Q3X3420', 'Khách hàng 414', 'perf_customer_414@testlunara.local', '0954898044', 'Số 26 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 840000.00, NULL, 0.00, 30000.00, 870000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(468, 327, 'LNS260726BAYK421', 'Khách hàng 327', 'perf_customer_327@testlunara.local', '0910224246', 'Số 155 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1180000.00, NULL, 0.00, 30000.00, 1210000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(469, 370, 'LNS260913EN84422', 'Khách hàng 370', 'perf_customer_370@testlunara.local', '0941714071', 'Số 41 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1140000.00, NULL, 0.00, 30000.00, 1170000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(470, 330, 'LNS260826WYBA423', 'Khách hàng 330', 'perf_customer_330@testlunara.local', '0933035589', 'Số 195 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 940000.00, NULL, 0.00, 30000.00, 970000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(471, 390, 'LNS260811NMMK424', 'Khách hàng 390', 'perf_customer_390@testlunara.local', '0988042625', 'Số 76 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 960000.00, NULL, 0.00, 30000.00, 990000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(472, 355, 'LNS260815MY71425', 'Khách hàng 355', 'perf_customer_355@testlunara.local', '0991238841', 'Số 184 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1410000.00, NULL, 0.00, 30000.00, 1440000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(473, 5, 'LNS26091403TV426', 'Khách hàng 5', 'perf_customer_5@testlunara.local', '0969731130', 'Số 194 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1540000.00, NULL, 0.00, 30000.00, 1570000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(474, 359, 'LNS260730YHCL427', 'Khách hàng 359', 'perf_customer_359@testlunara.local', '0911368058', 'Số 146 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1940000.00, NULL, 0.00, 30000.00, 1970000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(475, 316, 'LNS260927CWHJ428', 'Khách hàng 316', 'perf_customer_316@testlunara.local', '0971629556', 'Số 95 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1630000.00, NULL, 0.00, 30000.00, 1660000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(476, 399, 'LNS260807XM4Q429', 'Khách hàng 399', 'perf_customer_399@testlunara.local', '0934314280', 'Số 87 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1720000.00, NULL, 0.00, 30000.00, 1750000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(477, 407, 'LNS260723JX6K430', 'Khách hàng 407', 'perf_customer_407@testlunara.local', '0969647204', 'Số 200 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1740000.00, NULL, 0.00, 30000.00, 1770000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(478, 400, 'LNS260829AR2E431', 'Khách hàng 400', 'perf_customer_400@testlunara.local', '0916123609', 'Số 36 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 850000.00, NULL, 0.00, 30000.00, 880000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(479, 342, 'LNS260919CVOM432', 'Khách hàng 342', 'perf_customer_342@testlunara.local', '0949574324', 'Số 65 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1120000.00, NULL, 0.00, 30000.00, 1150000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(480, 349, 'LNS260914LXZF433', 'Khách hàng 349', 'perf_customer_349@testlunara.local', '0955675944', 'Số 59 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1680000.00, NULL, 0.00, 30000.00, 1710000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(481, 369, 'LNS260906OXSI434', 'Khách hàng 369', 'perf_customer_369@testlunara.local', '0968585129', 'Số 113 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1640000.00, NULL, 0.00, 30000.00, 1670000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(482, 349, 'LNS260722LXRG435', 'Khách hàng 349', 'perf_customer_349@testlunara.local', '0946003652', 'Số 53 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1060000.00, NULL, 0.00, 30000.00, 1090000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(483, 401, 'LNS260810P9YL436', 'Khách hàng 401', 'perf_customer_401@testlunara.local', '0932940590', 'Số 54 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1090000.00, NULL, 0.00, 30000.00, 1120000.00, 'vnpay', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(484, 317, 'LNS260804TAGV437', 'Khách hàng 317', 'perf_customer_317@testlunara.local', '0994866056', 'Số 107 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1330000.00, NULL, 0.00, 30000.00, 1360000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(485, 336, 'LNS260921OVIA438', 'Khách hàng 336', 'perf_customer_336@testlunara.local', '0980888065', 'Số 191 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1760000.00, NULL, 0.00, 30000.00, 1790000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(486, 370, 'LNS260930GKHH439', 'Khách hàng 370', 'perf_customer_370@testlunara.local', '0918900241', 'Số 3 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1220000.00, NULL, 0.00, 30000.00, 1250000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(487, 315, 'LNS2607202SO5440', 'Khách hàng 315', 'perf_customer_315@testlunara.local', '0940432501', 'Số 165 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 710000.00, NULL, 0.00, 30000.00, 740000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(488, 371, 'LNS260906J79K441', 'Khách hàng 371', 'perf_customer_371@testlunara.local', '0924756234', 'Số 156 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 840000.00, NULL, 0.00, 30000.00, 870000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(489, 338, 'LNS260831LJO5442', 'Khách hàng 338', 'perf_customer_338@testlunara.local', '0915304133', 'Số 156 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 880000.00, NULL, 0.00, 30000.00, 910000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(490, 414, 'LNS260723FLJZ443', 'Khách hàng 414', 'perf_customer_414@testlunara.local', '0960345292', 'Số 82 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1730000.00, NULL, 0.00, 30000.00, 1760000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(491, 1, 'LNS260924EG2B444', 'Khách hàng 1', 'perf_customer_1@testlunara.local', '0945878144', 'Số 131 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1250000.00, NULL, 0.00, 30000.00, 1280000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(492, 395, 'LNS260901KWCX445', 'Khách hàng 395', 'perf_customer_395@testlunara.local', '0985047188', 'Số 174 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(493, 319, 'LNS261002P6AI446', 'Khách hàng 319', 'perf_customer_319@testlunara.local', '0940545652', 'Số 65 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1460000.00, NULL, 0.00, 30000.00, 1490000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(494, 406, 'LNS260905ZI1F447', 'Khách hàng 406', 'perf_customer_406@testlunara.local', '0952308746', 'Số 155 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1030000.00, NULL, 0.00, 30000.00, 1060000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(495, 369, 'LNS260802G7NI448', 'Khách hàng 369', 'perf_customer_369@testlunara.local', '0933345986', 'Số 144 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1340000.00, NULL, 0.00, 30000.00, 1370000.00, 'vnpay', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(496, 414, 'LNS260807TSGZ449', 'Khách hàng 414', 'perf_customer_414@testlunara.local', '0935669710', 'Số 166 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 960000.00, NULL, 0.00, 30000.00, 990000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:25'),
(497, 343, 'LNS260805RDFF450', 'Khách hàng 343', 'perf_customer_343@testlunara.local', '0949511180', 'Số 58 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1930000.00, NULL, 0.00, 30000.00, 1960000.00, 'vnpay', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(498, 378, 'LNS260714BL4O451', 'Khách hàng 378', 'perf_customer_378@testlunara.local', '0927098450', 'Số 179 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1420000.00, NULL, 0.00, 30000.00, 1450000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(499, 383, 'LNS260916RRLK452', 'Khách hàng 383', 'perf_customer_383@testlunara.local', '0981767462', 'Số 121 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1060000.00, NULL, 0.00, 30000.00, 1090000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(500, 327, 'LNS260811V3JS453', 'Khách hàng 327', 'perf_customer_327@testlunara.local', '0925189669', 'Số 11 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1600000.00, NULL, 0.00, 30000.00, 1630000.00, 'bank_transfer', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(501, 377, 'LNS260914XHOJ454', 'Khách hàng 377', 'perf_customer_377@testlunara.local', '0961135295', 'Số 110 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1300000.00, NULL, 0.00, 30000.00, 1330000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(502, 371, 'LNS261002987R455', 'Khách hàng 371', 'perf_customer_371@testlunara.local', '0916245753', 'Số 180 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1430000.00, NULL, 0.00, 30000.00, 1460000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(503, 331, 'LNS26091102KY456', 'Khách hàng 331', 'perf_customer_331@testlunara.local', '0975793610', 'Số 142 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1640000.00, NULL, 0.00, 30000.00, 1670000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(504, 399, 'LNS260822BUFC457', 'Khách hàng 399', 'perf_customer_399@testlunara.local', '0950228244', 'Số 44 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2100000.00, NULL, 0.00, 30000.00, 2130000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(505, 366, 'LNS260712UNCN458', 'Khách hàng 366', 'perf_customer_366@testlunara.local', '0989540509', 'Số 194 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1140000.00, NULL, 0.00, 30000.00, 1170000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(506, 380, 'LNS2610031PLU459', 'Khách hàng 380', 'perf_customer_380@testlunara.local', '0959700920', 'Số 175 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 560000.00, NULL, 0.00, 30000.00, 590000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(507, 416, 'LNS260904L45B460', 'Khách hàng 416', 'perf_customer_416@testlunara.local', '0990146606', 'Số 35 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1130000.00, NULL, 0.00, 30000.00, 1160000.00, 'bank_transfer', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(508, 355, 'LNS2610036MAX461', 'Khách hàng 355', 'perf_customer_355@testlunara.local', '0963957387', 'Số 199 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1150000.00, NULL, 0.00, 30000.00, 1180000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(509, 415, 'LNS260903RCHF462', 'Khách hàng 415', 'perf_customer_415@testlunara.local', '0941252441', 'Số 171 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1160000.00, NULL, 0.00, 30000.00, 1190000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(510, 322, 'LNS260906JIKX463', 'Khách hàng 322', 'perf_customer_322@testlunara.local', '0959541500', 'Số 152 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 610000.00, NULL, 0.00, 30000.00, 640000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(511, 355, 'LNS260807SSEZ464', 'Khách hàng 355', 'perf_customer_355@testlunara.local', '0911231250', 'Số 184 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 730000.00, NULL, 0.00, 30000.00, 760000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(512, 360, 'LNS26090299HN465', 'Khách hàng 360', 'perf_customer_360@testlunara.local', '0911966457', 'Số 37 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 880000.00, NULL, 0.00, 30000.00, 910000.00, 'vnpay', 'paid', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(513, 332, 'LNS261007ZUSK466', 'Khách hàng 332', 'perf_customer_332@testlunara.local', '0965153870', 'Số 133 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1770000.00, NULL, 0.00, 30000.00, 1800000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(514, 316, 'LNS260716ZC5B467', 'Khách hàng 316', 'perf_customer_316@testlunara.local', '0990889784', 'Số 60 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(515, 407, 'LNS260730MUNX468', 'Khách hàng 407', 'perf_customer_407@testlunara.local', '0965819715', 'Số 159 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1620000.00, NULL, 0.00, 30000.00, 1650000.00, 'bank_transfer', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(516, 347, 'LNS260923D74N469', 'Khách hàng 347', 'perf_customer_347@testlunara.local', '0926222949', 'Số 117 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1380000.00, NULL, 0.00, 30000.00, 1410000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(517, 353, 'LNS2609048KDS470', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0977359531', 'Số 89 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 980000.00, NULL, 0.00, 30000.00, 1010000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(518, 331, 'LNS260831DUOR471', 'Khách hàng 331', 'perf_customer_331@testlunara.local', '0967765992', 'Số 143 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1590000.00, NULL, 0.00, 30000.00, 1620000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(519, 371, 'LNS261006UCT8472', 'Khách hàng 371', 'perf_customer_371@testlunara.local', '0974058978', 'Số 80 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 980000.00, NULL, 0.00, 30000.00, 1010000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(520, 377, 'LNS260824FXJ6473', 'Khách hàng 377', 'perf_customer_377@testlunara.local', '0995892204', 'Số 140 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1030000.00, NULL, 0.00, 30000.00, 1060000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(521, 380, 'LNS260728NYF3474', 'Khách hàng 380', 'perf_customer_380@testlunara.local', '0941518162', 'Số 71 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1530000.00, NULL, 0.00, 30000.00, 1560000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(522, 382, 'LNS2608165N4E475', 'Khách hàng 382', 'perf_customer_382@testlunara.local', '0948212337', 'Số 109 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'bank_transfer', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(523, 392, 'LNS260731PCBD476', 'Khách hàng 392', 'perf_customer_392@testlunara.local', '0999881179', 'Số 74 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1090000.00, NULL, 0.00, 30000.00, 1120000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(524, 353, 'LNS26080153Q6477', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0979392114', 'Số 155 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1050000.00, NULL, 0.00, 30000.00, 1080000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(525, 348, 'LNS260915K9AZ478', 'Khách hàng 348', 'perf_customer_348@testlunara.local', '0956229882', 'Số 21 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1220000.00, NULL, 0.00, 30000.00, 1250000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(526, 347, 'LNS260716KKWE479', 'Khách hàng 347', 'perf_customer_347@testlunara.local', '0916166648', 'Số 42 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1660000.00, NULL, 0.00, 30000.00, 1690000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(527, 417, 'LNS2608229OWY480', 'Khách hàng 417', 'perf_customer_417@testlunara.local', '0982333838', 'Số 76 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1610000.00, NULL, 0.00, 30000.00, 1640000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(528, 327, 'LNS260923JRNT481', 'Khách hàng 327', 'perf_customer_327@testlunara.local', '0936268187', 'Số 147 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1380000.00, NULL, 0.00, 30000.00, 1410000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25');
INSERT INTO `orders` (`id`, `user_id`, `order_code`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `shipping_city`, `shipping_note`, `shipping_method`, `subtotal`, `coupon_code`, `discount_amount`, `shipping_fee`, `grand_total`, `payment_method`, `payment_status`, `order_status`, `inventory_restored_at`, `customer_note`, `placed_at`, `created_at`, `updated_at`) VALUES
(529, 340, 'LNS261005O3Z7482', 'Khách hàng 340', 'perf_customer_340@testlunara.local', '0934742179', 'Số 31 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1830000.00, NULL, 0.00, 30000.00, 1860000.00, 'vnpay', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(530, 347, 'LNS260827RLJY483', 'Khách hàng 347', 'perf_customer_347@testlunara.local', '0913628540', 'Số 7 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1360000.00, NULL, 0.00, 30000.00, 1390000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(531, 353, 'LNS260816S9XP484', 'Khách hàng 353', 'perf_customer_353@testlunara.local', '0922682821', 'Số 60 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 840000.00, NULL, 0.00, 30000.00, 870000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(532, 325, 'LNS2608033QM4485', 'Khách hàng 325', 'perf_customer_325@testlunara.local', '0972443740', 'Số 54 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1130000.00, NULL, 0.00, 30000.00, 1160000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(533, 407, 'LNS26092590DH486', 'Khách hàng 407', 'perf_customer_407@testlunara.local', '0922136282', 'Số 131 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 780000.00, NULL, 0.00, 30000.00, 810000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(534, 354, 'LNS260906ZDSO487', 'Khách hàng 354', 'perf_customer_354@testlunara.local', '0957255335', 'Số 11 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 700000.00, NULL, 0.00, 30000.00, 730000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(535, 410, 'LNS260912CCEV488', 'Khách hàng 410', 'perf_customer_410@testlunara.local', '0926393755', 'Số 3 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1530000.00, NULL, 0.00, 30000.00, 1560000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(536, 395, 'LNS260912TSZ0489', 'Khách hàng 395', 'perf_customer_395@testlunara.local', '0928354339', 'Số 27 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 520000.00, NULL, 0.00, 30000.00, 550000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(537, 340, 'LNS260923XSJN490', 'Khách hàng 340', 'perf_customer_340@testlunara.local', '0942624274', 'Số 74 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1660000.00, NULL, 0.00, 30000.00, 1690000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(538, 339, 'LNS260829GZHZ491', 'Khách hàng 339', 'perf_customer_339@testlunara.local', '0981347539', 'Số 6 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1050000.00, NULL, 0.00, 30000.00, 1080000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(539, 341, 'LNS2607183CA0492', 'Khách hàng 341', 'perf_customer_341@testlunara.local', '0982211451', 'Số 150 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 830000.00, NULL, 0.00, 30000.00, 860000.00, 'vnpay', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(540, 394, 'LNS260726IXCL493', 'Khách hàng 394', 'perf_customer_394@testlunara.local', '0993455661', 'Số 156 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1560000.00, NULL, 0.00, 30000.00, 1590000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(541, 354, 'LNS260808FSMK494', 'Khách hàng 354', 'perf_customer_354@testlunara.local', '0928218314', 'Số 142 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2420000.00, NULL, 0.00, 30000.00, 2450000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(542, 315, 'LNS260719T4BE495', 'Khách hàng 315', 'perf_customer_315@testlunara.local', '0977367913', 'Số 6 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1090000.00, NULL, 0.00, 30000.00, 1120000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(543, 346, 'LNS260926QC8F496', 'Khách hàng 346', 'perf_customer_346@testlunara.local', '0987826950', 'Số 184 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1440000.00, NULL, 0.00, 30000.00, 1470000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(544, 354, 'LNS260721KP5Y497', 'Khách hàng 354', 'perf_customer_354@testlunara.local', '0996826845', 'Số 100 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1540000.00, NULL, 0.00, 30000.00, 1570000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(545, 339, 'LNS260811W4YG498', 'Khách hàng 339', 'perf_customer_339@testlunara.local', '0957235018', 'Số 1 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1340000.00, NULL, 0.00, 30000.00, 1370000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(546, 389, 'LNS260731XKQW499', 'Khách hàng 389', 'perf_customer_389@testlunara.local', '0998997006', 'Số 68 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1660000.00, NULL, 0.00, 30000.00, 1690000.00, 'bank_transfer', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(547, 315, 'LNS26082422S2500', 'Khách hàng 315', 'perf_customer_315@testlunara.local', '0974873458', 'Số 161 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1180000.00, NULL, 0.00, 30000.00, 1210000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(548, 394, 'LNS260924MNEB501', 'Khách hàng 394', 'perf_customer_394@testlunara.local', '0993434926', 'Số 119 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1250000.00, NULL, 0.00, 30000.00, 1280000.00, 'cod', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(549, 5, 'LNS2608158SMH502', 'Khách hàng 5', 'perf_customer_5@testlunara.local', '0911106611', 'Số 165 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2100000.00, NULL, 0.00, 30000.00, 2130000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(550, 327, 'LNS260801RXX8503', 'Khách hàng 327', 'perf_customer_327@testlunara.local', '0991177059', 'Số 143 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1760000.00, NULL, 0.00, 30000.00, 1790000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(551, 320, 'LNS2607206JSP504', 'Khách hàng 320', 'perf_customer_320@testlunara.local', '0938217644', 'Số 45 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 920000.00, NULL, 0.00, 30000.00, 950000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(552, 415, 'LNS260924QKJU505', 'Khách hàng 415', 'perf_customer_415@testlunara.local', '0955003946', 'Số 109 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1420000.00, NULL, 0.00, 30000.00, 1450000.00, 'vnpay', 'pending', 'pending', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(553, 343, 'LNS260723URT3506', 'Khách hàng 343', 'perf_customer_343@testlunara.local', '0954711014', 'Số 150 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1440000.00, NULL, 0.00, 30000.00, 1470000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(554, 350, 'LNS260924WJ34507', 'Khách hàng 350', 'perf_customer_350@testlunara.local', '0958823091', 'Số 145 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'bank_transfer', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(555, 324, 'LNS260924ZZLR508', 'Khách hàng 324', 'perf_customer_324@testlunara.local', '0961625592', 'Số 200 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1100000.00, NULL, 0.00, 30000.00, 1130000.00, 'vnpay', 'paid', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(556, 343, 'LNS261007OFKQ509', 'Khách hàng 343', 'perf_customer_343@testlunara.local', '0988288525', 'Số 121 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 650000.00, NULL, 0.00, 30000.00, 680000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(557, 348, 'LNS260907EGFU510', 'Khách hàng 348', 'perf_customer_348@testlunara.local', '0956381669', 'Số 40 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1800000.00, NULL, 0.00, 30000.00, 1830000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(558, 354, 'LNS2608142TQK511', 'Khách hàng 354', 'perf_customer_354@testlunara.local', '0957833047', 'Số 30 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1500000.00, NULL, 0.00, 30000.00, 1530000.00, 'cod', 'pending', 'processing', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(559, 355, 'LNS260718GCMH512', 'Khách hàng 355', 'perf_customer_355@testlunara.local', '0925159752', 'Số 132 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1420000.00, NULL, 0.00, 30000.00, 1450000.00, 'cod', 'refunded', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(560, 323, 'LNS260724RADE513', 'Khách hàng 323', 'perf_customer_323@testlunara.local', '0937663727', 'Số 48 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1620000.00, NULL, 0.00, 30000.00, 1650000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(561, 324, 'LNS260924GNQT514', 'Khách hàng 324', 'perf_customer_324@testlunara.local', '0981762458', 'Số 147 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 2200000.00, NULL, 0.00, 30000.00, 2230000.00, 'cod', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(562, 318, 'LNS260802RTFO515', 'Khách hàng 318', 'perf_customer_318@testlunara.local', '0931446308', 'Số 50 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1040000.00, NULL, 0.00, 30000.00, 1070000.00, 'bank_transfer', 'failed', 'cancelled', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(563, 324, 'LNS260719UYLF516', 'Khách hàng 324', 'perf_customer_324@testlunara.local', '0946536093', 'Số 123 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 910000.00, NULL, 0.00, 30000.00, 940000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(564, 373, 'LNS2610015LCH517', 'Khách hàng 373', 'perf_customer_373@testlunara.local', '0930716564', 'Số 135 Đường Nguyễn Huệ', 'TP. Hồ Chí Minh', NULL, 'standard', 1080000.00, NULL, 0.00, 30000.00, 1110000.00, 'vnpay', 'paid', 'completed', NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(565, 4, 'LNS-20261008-EELSTF', 'Quản trị viên Lunara', 'admin@lunara.vn', '0912345678', '123 Phố Tràng Tiền, Quận Hoàn Kiếm', 'Hồ Chí Minh', NULL, 'standard', 3790000.00, NULL, 0.00, 0.00, 3790000.00, 'cod', 'pending', 'pending', NULL, NULL, '2026-10-08 13:00:18', '2026-10-08 13:00:18', '2026-10-08 13:00:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `gift_message` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_sku`, `unit_price`, `quantity`, `subtotal`, `gift_message`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-09-20 08:16:03', '2026-09-20 08:16:03'),
(2, 2, 44, 'Lunara Gift Box – Sinh Nhật Lấp Lánh', 'LNS-GIFT004', 340000.00, 1, 340000.00, NULL, '2026-09-20 08:54:09', '2026-09-20 08:54:09'),
(3, 2, 43, 'Lunara Gift Box – Trọn Vẹn Yêu Thương', 'LNS-GIFT003', 1050000.00, 1, 1050000.00, NULL, '2026-09-20 08:54:09', '2026-09-20 08:54:09'),
(4, 3, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-09-20 21:21:15', '2026-09-20 21:21:15'),
(5, 3, 41, 'Lunara Gift Box – Dịu Dàng', 'LNS-GIFT001', 600000.00, 2, 1200000.00, NULL, '2026-09-20 21:21:15', '2026-09-20 21:21:15'),
(113, 48, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(114, 48, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(115, 48, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(116, 49, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(117, 49, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(118, 49, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(119, 50, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(120, 50, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(121, 51, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(122, 51, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(123, 52, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(124, 52, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(125, 53, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(126, 53, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(127, 54, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(128, 54, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(129, 55, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(130, 55, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(131, 55, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(132, 56, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(133, 56, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(134, 56, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(135, 57, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(136, 57, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(137, 58, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(138, 58, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(139, 59, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(140, 59, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(141, 60, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(142, 60, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(143, 60, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(144, 61, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(145, 61, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(146, 61, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(147, 62, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(148, 62, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(149, 62, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(150, 63, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(151, 63, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(152, 64, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(153, 64, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(154, 65, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(155, 65, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(156, 66, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(157, 66, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(158, 67, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(159, 67, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(160, 68, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(161, 68, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(162, 69, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(163, 69, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(164, 69, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(165, 70, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(166, 70, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(167, 70, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(168, 71, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(169, 71, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(170, 71, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(171, 72, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(172, 72, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(173, 72, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(174, 73, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(175, 73, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(176, 74, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(177, 74, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(178, 74, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(179, 75, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(180, 75, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(181, 76, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(182, 76, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(183, 77, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(184, 77, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(185, 78, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(186, 78, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(187, 79, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(188, 79, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(189, 79, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(190, 80, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(191, 80, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(192, 81, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(193, 81, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(194, 82, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(195, 82, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(196, 83, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(197, 83, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(198, 84, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(199, 84, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(200, 84, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(201, 85, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(202, 85, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(203, 86, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(204, 86, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(205, 87, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(206, 87, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(207, 88, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(208, 88, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(209, 89, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(210, 89, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(211, 89, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(212, 90, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(213, 90, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(214, 90, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(215, 91, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(216, 91, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(217, 91, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(218, 92, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(219, 92, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(220, 93, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(221, 93, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(222, 94, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(223, 94, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(224, 95, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(225, 95, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(226, 96, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(227, 96, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(228, 97, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(229, 97, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(230, 97, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(231, 98, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(232, 98, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(233, 98, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(234, 99, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(235, 99, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(236, 99, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(237, 100, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(238, 100, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(239, 101, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(240, 101, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(241, 102, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(242, 102, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(243, 103, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(244, 103, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(245, 103, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(246, 104, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(247, 104, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(248, 104, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(249, 105, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(250, 105, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(251, 105, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(252, 106, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(253, 106, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(254, 106, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(255, 107, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(256, 107, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(257, 108, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(258, 108, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(259, 109, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(260, 109, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(261, 110, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(262, 110, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(263, 111, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(264, 111, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(265, 111, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(266, 112, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(267, 112, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(268, 113, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(269, 113, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(270, 113, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(271, 114, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(272, 114, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(273, 115, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(274, 115, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(275, 116, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(276, 116, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(277, 116, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(278, 117, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(279, 117, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(280, 118, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(281, 118, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(282, 118, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(283, 119, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(284, 119, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(285, 119, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(286, 120, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(287, 120, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(288, 120, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(289, 121, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(290, 121, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(291, 121, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(292, 122, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(293, 122, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(294, 123, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(295, 123, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(296, 124, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(297, 124, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(298, 125, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(299, 125, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(300, 125, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(301, 126, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(302, 126, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(303, 126, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(304, 127, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(305, 127, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(306, 127, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(307, 128, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(308, 128, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(309, 128, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(310, 129, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(311, 129, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(312, 129, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(313, 130, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(314, 130, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(315, 131, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(316, 131, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(317, 132, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(318, 132, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(319, 133, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(320, 133, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(321, 133, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(322, 134, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(323, 134, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(324, 135, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(325, 135, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(326, 135, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(327, 136, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(328, 136, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(329, 136, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(330, 137, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(331, 137, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(332, 137, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(333, 138, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(334, 138, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(335, 138, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(336, 139, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(337, 139, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(338, 139, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(339, 140, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(340, 140, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(341, 141, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(342, 141, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(343, 141, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(344, 142, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(345, 142, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(346, 143, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(347, 143, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(348, 144, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(349, 144, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(350, 144, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(351, 145, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(352, 145, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(353, 146, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(354, 146, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(355, 146, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(356, 147, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(357, 147, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(358, 147, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(359, 148, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(360, 148, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(361, 148, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(362, 149, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(363, 149, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(364, 150, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(365, 150, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(366, 150, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(367, 151, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(368, 151, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(369, 152, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(370, 152, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(371, 153, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(372, 153, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(373, 154, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(374, 154, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(375, 155, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(376, 155, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(377, 155, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(378, 156, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(379, 156, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(380, 156, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(381, 157, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(382, 157, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(383, 158, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(384, 158, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(385, 159, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(386, 159, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(387, 160, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(388, 160, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(389, 160, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(390, 161, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(391, 161, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(392, 161, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(393, 162, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(394, 162, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(395, 163, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(396, 163, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(397, 163, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(398, 164, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(399, 164, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(400, 164, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(401, 165, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(402, 165, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(403, 165, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(404, 166, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(405, 166, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(406, 167, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(407, 167, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(408, 167, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(409, 168, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(410, 168, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(411, 168, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(412, 169, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(413, 169, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(414, 170, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(415, 170, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(416, 170, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(417, 171, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(418, 171, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(419, 171, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(420, 172, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(421, 172, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(422, 173, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(423, 173, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(424, 173, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(425, 174, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(426, 174, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(427, 174, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(428, 175, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(429, 175, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(430, 176, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(431, 176, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(432, 177, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(433, 177, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(434, 178, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(435, 178, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(436, 178, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(437, 179, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(438, 179, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(439, 180, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(440, 180, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(441, 180, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(442, 181, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(443, 181, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(444, 181, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(445, 182, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(446, 182, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(447, 183, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(448, 183, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(449, 183, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(450, 184, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(451, 184, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(452, 185, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(453, 185, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(454, 185, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(455, 186, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(456, 186, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(457, 186, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(458, 187, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(459, 187, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(460, 187, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(461, 188, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(462, 188, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(463, 189, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(464, 189, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(465, 189, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(466, 190, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(467, 190, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(468, 191, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(469, 191, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(470, 191, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(471, 192, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(472, 192, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(473, 193, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(474, 193, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(475, 193, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(476, 194, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(477, 194, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(478, 194, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(479, 195, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(480, 195, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_sku`, `unit_price`, `quantity`, `subtotal`, `gift_message`, `created_at`, `updated_at`) VALUES
(481, 196, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(482, 196, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(483, 196, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(484, 197, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(485, 197, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(486, 197, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(487, 198, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(488, 198, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(489, 198, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(490, 199, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(491, 199, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(492, 199, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(493, 200, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(494, 200, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(495, 201, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(496, 201, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(497, 202, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(498, 202, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(499, 203, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(500, 203, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(501, 203, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(502, 204, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(503, 204, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(504, 205, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(505, 205, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(506, 205, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(507, 206, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(508, 206, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(509, 206, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(510, 207, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(511, 207, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(512, 208, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(513, 208, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(514, 209, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(515, 209, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(516, 209, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(517, 210, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(518, 210, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(519, 210, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(520, 211, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(521, 211, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(522, 212, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(523, 212, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(524, 212, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(525, 213, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(526, 213, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(527, 213, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(528, 214, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(529, 214, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(530, 214, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(531, 215, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(532, 215, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(533, 216, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(534, 216, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(535, 217, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(536, 217, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(537, 217, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(538, 218, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(539, 218, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(540, 219, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(541, 219, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(542, 219, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(543, 220, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(544, 220, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(545, 221, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(546, 221, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(547, 222, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(548, 222, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(549, 222, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(550, 223, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(551, 223, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(552, 223, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(553, 224, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(554, 224, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(555, 225, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(556, 225, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(557, 225, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(558, 226, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(559, 226, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(560, 227, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(561, 227, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(562, 227, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(563, 228, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(564, 228, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(565, 229, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(566, 229, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(567, 229, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(568, 230, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(569, 230, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(570, 231, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(571, 231, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(572, 232, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(573, 232, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(574, 232, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(575, 233, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(576, 233, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(577, 234, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(578, 234, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(579, 234, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(580, 235, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(581, 235, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(582, 235, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(583, 236, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(584, 236, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(585, 236, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(586, 237, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(587, 237, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(588, 238, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(589, 238, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(590, 239, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(591, 239, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(592, 239, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(593, 240, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(594, 240, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(595, 241, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(596, 241, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(597, 242, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(598, 242, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(599, 242, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(600, 243, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(601, 243, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(602, 244, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(603, 244, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(604, 245, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(605, 245, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(606, 246, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(607, 246, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(608, 246, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(609, 247, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(610, 247, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(611, 247, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(612, 248, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(613, 248, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(614, 248, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(615, 249, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(616, 249, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(617, 250, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(618, 250, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(619, 250, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(620, 251, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(621, 251, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(622, 251, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(623, 252, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(624, 252, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(625, 252, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(626, 253, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(627, 253, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(628, 253, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(629, 254, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(630, 254, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(631, 254, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(632, 255, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(633, 255, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(634, 255, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(635, 256, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(636, 256, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(637, 257, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(638, 257, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(639, 258, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(640, 258, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(641, 258, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(642, 259, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(643, 259, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(644, 259, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(645, 260, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(646, 260, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(647, 261, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(648, 261, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(649, 262, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(650, 262, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(651, 262, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(652, 263, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(653, 263, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(654, 264, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(655, 264, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(656, 265, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(657, 265, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(658, 265, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(659, 266, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(660, 266, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(661, 266, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(662, 267, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(663, 267, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(664, 268, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(665, 268, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(666, 269, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(667, 269, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(668, 270, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(669, 270, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(670, 271, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(671, 271, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(672, 271, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(673, 272, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(674, 272, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(675, 272, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(676, 273, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(677, 273, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(678, 273, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(679, 274, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(680, 274, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(681, 274, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(682, 275, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(683, 275, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(684, 275, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(685, 276, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(686, 276, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(687, 277, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(688, 277, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(689, 277, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(690, 278, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(691, 278, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(692, 279, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(693, 279, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(694, 280, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(695, 280, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(696, 281, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(697, 281, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(698, 281, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(699, 282, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(700, 282, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(701, 283, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(702, 283, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(703, 283, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(704, 284, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(705, 284, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(706, 284, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(707, 285, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(708, 285, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(709, 286, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(710, 286, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(711, 287, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(712, 287, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(713, 288, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(714, 288, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(715, 288, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(716, 289, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(717, 289, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(718, 290, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(719, 290, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(720, 291, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(721, 291, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(722, 291, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(723, 292, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(724, 292, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(725, 293, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(726, 293, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(727, 294, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(728, 294, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(729, 295, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(730, 295, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(731, 295, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(732, 296, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(733, 296, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(734, 296, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(735, 297, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(736, 297, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(737, 298, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(738, 298, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(739, 298, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(740, 299, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(741, 299, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(742, 300, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(743, 300, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(744, 300, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(745, 301, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(746, 301, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(747, 302, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(748, 302, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(749, 303, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(750, 303, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(751, 304, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(752, 304, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(753, 305, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(754, 305, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(755, 305, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(756, 306, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(757, 306, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(758, 307, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(759, 307, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(760, 308, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(761, 308, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(762, 309, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(763, 309, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(764, 309, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(765, 310, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(766, 310, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(767, 310, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(768, 311, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(769, 311, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(770, 311, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(771, 312, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(772, 312, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(773, 312, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(774, 313, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(775, 313, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(776, 313, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(777, 314, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(778, 314, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(779, 314, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(780, 315, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(781, 315, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(782, 315, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(783, 316, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(784, 316, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(785, 316, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(786, 317, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(787, 317, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(788, 318, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(789, 318, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(790, 319, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(791, 319, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(792, 319, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(793, 320, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(794, 320, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(795, 320, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(796, 321, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(797, 321, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(798, 321, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(799, 322, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(800, 322, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(801, 322, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(802, 323, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(803, 323, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(804, 323, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(805, 324, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(806, 324, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(807, 324, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(808, 325, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(809, 325, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(810, 325, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(811, 326, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(812, 326, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(813, 326, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(814, 327, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(815, 327, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(816, 327, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(817, 328, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(818, 328, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(819, 328, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(820, 329, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(821, 329, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(822, 329, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(823, 330, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(824, 330, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(825, 330, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(826, 331, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(827, 331, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(828, 332, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(829, 332, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(830, 332, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(831, 333, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(832, 333, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(833, 334, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(834, 334, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(835, 335, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(836, 335, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(837, 336, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(838, 336, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(839, 336, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(840, 337, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(841, 337, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(842, 338, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(843, 338, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(844, 339, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(845, 339, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(846, 339, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(847, 340, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(848, 340, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(849, 340, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(850, 341, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(851, 341, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(852, 342, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(853, 342, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_sku`, `unit_price`, `quantity`, `subtotal`, `gift_message`, `created_at`, `updated_at`) VALUES
(854, 342, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(855, 343, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(856, 343, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(857, 343, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(858, 344, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(859, 344, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(860, 344, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(861, 345, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(862, 345, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(863, 346, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(864, 346, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(865, 346, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(866, 347, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(867, 347, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(868, 348, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(869, 348, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(870, 348, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(871, 349, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(872, 349, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(873, 349, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(874, 350, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(875, 350, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(876, 350, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(877, 351, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(878, 351, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(879, 351, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(880, 352, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(881, 352, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(882, 353, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(883, 353, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(884, 353, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(885, 354, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(886, 354, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(887, 354, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(888, 355, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(889, 355, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(890, 355, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(891, 356, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(892, 356, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(893, 356, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(894, 357, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(895, 357, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(896, 358, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(897, 358, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(898, 358, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(899, 359, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(900, 359, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(901, 359, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(902, 360, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(903, 360, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(904, 361, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(905, 361, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(906, 361, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(907, 362, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(908, 362, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(909, 362, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(910, 363, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(911, 363, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(912, 364, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(913, 364, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(914, 364, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(915, 365, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(916, 365, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(917, 365, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(918, 366, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(919, 366, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(920, 366, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(921, 367, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(922, 367, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(923, 367, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(924, 368, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(925, 368, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(926, 368, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(927, 369, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(928, 369, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(929, 370, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(930, 370, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(931, 370, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(932, 371, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(933, 371, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(934, 372, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(935, 372, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(936, 373, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(937, 373, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(938, 374, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(939, 374, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(940, 374, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(941, 375, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(942, 375, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(943, 375, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(944, 376, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(945, 376, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(946, 376, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(947, 377, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(948, 377, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(949, 378, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(950, 378, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(951, 378, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(952, 379, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(953, 379, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(954, 379, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(955, 380, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(956, 380, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(957, 380, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(958, 381, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(959, 381, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(960, 381, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(961, 382, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(962, 382, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(963, 382, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(964, 383, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(965, 383, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(966, 383, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(967, 384, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(968, 384, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(969, 384, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(970, 385, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(971, 385, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(972, 385, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(973, 386, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(974, 386, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(975, 387, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(976, 387, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(977, 387, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(978, 388, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(979, 388, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(980, 388, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(981, 389, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(982, 389, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(983, 389, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(984, 390, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(985, 390, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(986, 391, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(987, 391, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(988, 392, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(989, 392, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(990, 392, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(991, 393, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(992, 393, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(993, 394, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(994, 394, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(995, 395, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(996, 395, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(997, 395, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(998, 396, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(999, 396, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1000, 396, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1001, 397, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1002, 397, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1003, 397, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1004, 398, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1005, 398, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1006, 399, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1007, 399, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1008, 399, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1009, 400, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1010, 400, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1011, 400, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1012, 401, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1013, 401, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1014, 402, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1015, 402, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1016, 402, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1017, 403, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1018, 403, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1019, 404, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1020, 404, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1021, 405, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1022, 405, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1023, 406, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1024, 406, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1025, 406, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1026, 407, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1027, 407, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1028, 407, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1029, 408, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1030, 408, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1031, 409, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1032, 409, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1033, 410, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1034, 410, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1035, 411, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1036, 411, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1037, 412, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1038, 412, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1039, 412, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1040, 413, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1041, 413, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1042, 413, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1043, 414, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1044, 414, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1045, 415, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1046, 415, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1047, 415, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1048, 416, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1049, 416, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1050, 416, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1051, 417, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1052, 417, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1053, 418, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1054, 418, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1055, 418, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1056, 419, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1057, 419, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1058, 419, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1059, 420, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1060, 420, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1061, 420, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1062, 421, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1063, 421, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1064, 422, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1065, 422, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1066, 422, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1067, 423, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1068, 423, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1069, 424, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1070, 424, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1071, 424, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1072, 425, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1073, 425, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1074, 426, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1075, 426, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1076, 426, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1077, 427, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1078, 427, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1079, 427, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1080, 428, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1081, 428, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1082, 429, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1083, 429, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1084, 430, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1085, 430, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1086, 430, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1087, 431, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1088, 431, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1089, 431, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1090, 432, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1091, 432, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1092, 432, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1093, 433, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1094, 433, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1095, 433, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1096, 434, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1097, 434, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1098, 435, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1099, 435, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1100, 436, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1101, 436, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1102, 436, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1103, 437, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1104, 437, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1105, 438, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1106, 438, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1107, 438, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1108, 439, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1109, 439, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1110, 439, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1111, 440, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1112, 440, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1113, 440, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1114, 441, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1115, 441, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1116, 441, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1117, 442, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1118, 442, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1119, 442, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1120, 443, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1121, 443, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1122, 444, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1123, 444, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1124, 444, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1125, 445, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1126, 445, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1127, 445, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1128, 446, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1129, 446, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1130, 446, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1131, 447, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1132, 447, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 1, 340000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1133, 448, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1134, 448, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1135, 448, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1136, 449, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1137, 449, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1138, 450, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1139, 450, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1140, 450, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1141, 451, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1142, 451, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1143, 451, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1144, 452, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1145, 452, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1146, 452, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1147, 453, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1148, 453, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1149, 453, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1150, 454, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1151, 454, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1152, 455, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1153, 455, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1154, 456, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1155, 456, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1156, 456, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1157, 457, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1158, 457, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1159, 458, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1160, 458, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1161, 459, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1162, 459, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1163, 460, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1164, 460, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1165, 461, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1166, 461, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1167, 462, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1168, 462, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1169, 462, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1170, 463, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1171, 463, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1172, 464, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1173, 464, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1174, 464, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1175, 465, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1176, 465, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1177, 466, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1178, 466, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1179, 466, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1180, 467, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1181, 467, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1182, 467, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1183, 468, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1184, 468, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1185, 469, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1186, 469, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1187, 469, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1188, 470, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1189, 470, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1190, 471, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1191, 471, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1192, 471, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1193, 472, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1194, 472, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1195, 472, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1196, 473, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1197, 473, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1198, 474, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1199, 474, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1200, 474, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1201, 475, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1202, 475, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1203, 475, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1204, 476, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1205, 476, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1206, 476, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1207, 477, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1208, 477, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1209, 477, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1210, 478, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1211, 478, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1212, 479, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1213, 479, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1214, 480, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1215, 480, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1216, 481, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1217, 481, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1218, 481, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1219, 482, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1220, 482, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1221, 483, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1222, 483, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1223, 484, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1224, 484, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_sku`, `unit_price`, `quantity`, `subtotal`, `gift_message`, `created_at`, `updated_at`) VALUES
(1225, 484, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1226, 485, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1227, 485, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1228, 485, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1229, 486, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1230, 486, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1231, 487, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1232, 487, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1233, 488, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1234, 488, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1235, 489, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1236, 489, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1237, 490, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1238, 490, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1239, 490, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1240, 491, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1241, 491, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1242, 491, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1243, 492, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1244, 492, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1245, 492, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1246, 493, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1247, 493, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1248, 493, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1249, 494, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1250, 494, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1251, 494, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1252, 495, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1253, 495, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1254, 496, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(1255, 496, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1256, 496, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1257, 497, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1258, 497, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1259, 497, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1260, 498, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1261, 498, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1262, 498, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1263, 499, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1264, 499, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1265, 500, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1266, 500, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1267, 501, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1268, 501, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1269, 501, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1270, 502, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1271, 502, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1272, 502, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1273, 503, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1274, 503, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1275, 504, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1276, 504, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1277, 504, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1278, 505, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1279, 505, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1280, 506, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1281, 506, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1282, 507, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1283, 507, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1284, 508, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1285, 508, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1286, 508, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1287, 509, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1288, 509, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1289, 510, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1290, 510, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1291, 511, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1292, 511, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1293, 512, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1294, 512, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1295, 513, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 1, 250000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1296, 513, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1297, 513, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1298, 514, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1299, 514, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1300, 514, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1301, 515, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1302, 515, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1303, 515, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1304, 516, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1305, 516, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1306, 517, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1307, 517, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1308, 517, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1309, 518, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 2, 520000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1310, 518, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1311, 518, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1312, 519, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1313, 519, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1314, 520, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1315, 520, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1316, 521, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1317, 521, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1318, 521, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1319, 522, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1320, 522, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1321, 522, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1322, 523, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1323, 523, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 2, 640000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1324, 524, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1325, 524, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1326, 524, 28, 'Vòng Lunara Đa Tinh', 'LNS-VT008', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1327, 525, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1328, 525, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1329, 525, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1330, 526, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1331, 526, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1332, 526, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1333, 527, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1334, 527, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1335, 527, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1336, 528, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 2, 460000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1337, 528, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1338, 529, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1339, 529, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1340, 529, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1341, 530, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1342, 530, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1343, 530, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 1, 430000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1344, 531, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1345, 531, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1346, 532, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1347, 532, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1348, 532, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1349, 533, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 2, 540000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1350, 533, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1351, 534, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1352, 534, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1353, 535, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1354, 535, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1355, 535, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 2, 480000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1356, 536, 18, 'Nhẫn Lunara Dạ Khúc', 'LNS-NH008', 230000.00, 1, 230000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1357, 536, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 1, 290000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1358, 537, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 1, 460000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1359, 537, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1360, 537, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1361, 538, 22, 'Vòng Lunara Hành Tinh', 'LNS-VT002', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1362, 538, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 1, 450000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1363, 539, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1364, 539, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1365, 540, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1366, 540, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1367, 541, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1368, 541, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1369, 541, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1370, 542, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1371, 542, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 1, 370000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1372, 543, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1373, 543, 11, 'Nhẫn Lunara Nguyệt Tinh', 'LNS-NH001', 250000.00, 2, 500000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1374, 544, 19, 'Nhẫn Lunara Ngân Hà', 'LNS-NH009', 290000.00, 2, 580000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1375, 544, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1376, 544, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1377, 545, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1378, 545, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 1, 310000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1379, 545, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1380, 546, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1381, 546, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1382, 547, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1383, 547, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 2, 940000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1384, 548, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1385, 548, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 1, 420000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1386, 548, 9, 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'LNS-DC009', 470000.00, 1, 470000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1387, 549, 8, 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'LNS-DC008', 380000.00, 2, 760000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1388, 549, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1389, 549, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1390, 550, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1391, 550, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1392, 550, 16, 'Nhẫn Lunara Quỹ Đạo', 'LNS-NH006', 240000.00, 1, 240000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1393, 551, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 1, 300000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1394, 551, 27, 'Vòng Lunara Thiên Hà', 'LNS-VT007', 310000.00, 2, 620000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1395, 552, 10, 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'LNS-DC010', 430000.00, 2, 860000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1396, 552, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1397, 553, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 2, 780000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1398, 553, 15, 'Nhẫn Lunara Tinh Thủy', 'LNS-NH005', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1399, 553, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1400, 554, 13, 'Nhẫn Lunara Lam Dạ', 'LNS-NH003', 260000.00, 1, 260000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1401, 554, 5, 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'LNS-DC005', 420000.00, 2, 840000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1402, 555, 29, 'Vòng Lunara Thiên Đàng', 'LNS-VT009', 400000.00, 1, 400000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1403, 555, 12, 'Nhẫn Lunara Song Tinh', 'LNS-NH002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1404, 556, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1405, 556, 14, 'Nhẫn Lunara Vũ Trụ', 'LNS-NH004', 270000.00, 1, 270000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1406, 557, 2, 'Dây chuyền Lunara Tinh Tú Hoàn', 'LNS-DC002', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1407, 557, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 1, 360000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1408, 557, 26, 'Vòng Lunara Nguyệt Lam', 'LNS-VT006', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1409, 558, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1410, 558, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1411, 559, 3, 'Dây chuyền Lunara Ái Tinh Hồn', 'LNS-DC003', 370000.00, 2, 740000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1412, 559, 21, 'Vòng Lunara Nguyệt Hồng', 'LNS-VT001', 340000.00, 2, 680000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1413, 560, 6, 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'LNS-DC006', 460000.00, 2, 920000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1414, 560, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1415, 560, 30, 'Vòng Lunara Thiên Cơ', 'LNS-VT010', 380000.00, 1, 380000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1416, 561, 20, 'Nhẫn Lunara Bắc Đẩu', 'LNS-NH010', 300000.00, 2, 600000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1417, 561, 4, 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'LNS-DC004', 450000.00, 2, 900000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1418, 561, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 2, 700000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1419, 562, 23, 'Vòng Lunara Song Nguyệt', 'LNS-VT003', 360000.00, 2, 720000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1420, 562, 17, 'Nhẫn Lunara Bạch Nguyệt', 'LNS-NH007', 320000.00, 1, 320000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1421, 563, 25, 'Vòng Lunara Nhật Nguyệt', 'LNS-VT005', 350000.00, 1, 350000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1422, 563, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 2, 560000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1423, 564, 24, 'Vòng Lunara Tinh Tú', 'LNS-VT004', 280000.00, 1, 280000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1424, 564, 7, 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'LNS-DC007', 400000.00, 2, 800000.00, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(1425, 565, 40, 'Khúc Tình Ca Bầu Trời', 'LNS-SET010', 850000.00, 4, 3400000.00, NULL, '2026-10-08 13:00:18', '2026-10-08 13:00:18'),
(1426, 565, 1, 'Dây chuyền Lunara Thái Dương Lam', 'LNS-DC001', 390000.00, 1, 390000.00, NULL, '2026-10-08 13:00:18', '2026-10-08 13:00:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_item_components`
--

CREATE TABLE `order_item_components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_sku` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity_per_item` int(10) UNSIGNED NOT NULL,
  `total_quantity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_item_components`
--

INSERT INTO `order_item_components` (`id`, `order_item_id`, `product_id`, `product_sku`, `product_name`, `quantity_per_item`, `total_quantity`, `created_at`, `updated_at`) VALUES
(1, 1425, NULL, 'LNS-DC003', 'Dây chuyền Lunara Ái Tinh Hồn', 1, 4, '2026-10-08 13:00:18', '2026-10-08 13:00:18'),
(2, 1425, NULL, 'LNS-NH007', 'Nhẫn Lunara Bạch Nguyệt', 1, 4, '2026-10-08 13:00:18', '2026-10-08 13:00:18'),
(3, 1425, NULL, 'LNS-VT007', 'Vòng Lunara Thiên Hà', 1, 4, '2026-10-08 13:00:18', '2026-10-08 13:00:18'),
(4, 1426, 1, 'LNS-DC001', 'Dây chuyền Lunara Thái Dương Lam', 1, 1, '2026-10-08 13:00:18', '2026-10-08 13:00:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_status_histories`
--

CREATE TABLE `order_status_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `from_status` varchar(255) DEFAULT NULL,
  `to_status` varchar(255) NOT NULL,
  `changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_status_histories`
--

INSERT INTO `order_status_histories` (`id`, `order_id`, `from_status`, `to_status`, `changed_by`, `note`, `created_at`) VALUES
(1, 3, 'pending', 'confirmed', 4, NULL, '2026-09-22 08:45:47'),
(2, 3, 'confirmed', 'processing', 4, NULL, '2026-09-22 08:45:55'),
(3, 3, 'processing', 'shipping', 4, NULL, '2026-09-22 08:46:02'),
(4, 3, 'shipping', 'completed', 4, NULL, '2026-09-22 08:46:08'),
(5, 2, 'pending', 'confirmed', 4, NULL, '2026-09-22 08:55:37'),
(6, 2, 'confirmed', 'processing', 4, NULL, '2026-09-22 08:55:49'),
(7, 2, 'processing', 'shipping', 4, NULL, '2026-09-22 08:56:01'),
(8, 2, 'shipping', 'completed', 4, NULL, '2026-09-22 08:56:15'),
(9, 565, NULL, 'pending', NULL, 'Đơn hàng được khởi tạo thành công qua checkout COD.', '2026-10-08 13:00:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(30) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `txn_ref` varchar(64) DEFAULT NULL,
  `vnp_transaction_no` varchar(64) DEFAULT NULL,
  `vnp_bank_code` varchar(30) DEFAULT NULL,
  `vnp_card_type` varchar(30) DEFAULT NULL,
  `vnp_pay_date` varchar(30) DEFAULT NULL,
  `vnp_create_date` varchar(14) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `request_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`request_data`)),
  `response_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response_data`)),
  `paid_at` timestamp NULL DEFAULT NULL,
  `last_queried_at` timestamp NULL DEFAULT NULL,
  `query_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `failure_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `provider`, `transaction_id`, `txn_ref`, `vnp_transaction_no`, `vnp_bank_code`, `vnp_card_type`, `vnp_pay_date`, `vnp_create_date`, `amount`, `status`, `request_data`, `response_data`, `paid_at`, `last_queried_at`, `query_count`, `failure_reason`, `created_at`, `updated_at`) VALUES
(1, 1, 'cod', NULL, NULL, NULL, NULL, NULL, NULL, '20260927220346', 450000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-09-20 08:16:03', '2026-09-27 15:03:46'),
(2, 2, 'cod', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1390000.00, 'paid', NULL, NULL, '2026-09-22 08:56:15', NULL, 0, NULL, '2026-09-20 08:54:09', '2026-09-22 08:56:15'),
(3, 3, 'cod', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1570000.00, 'paid', NULL, NULL, '2026-09-22 08:46:08', NULL, 0, NULL, '2026-09-20 21:21:15', '2026-09-22 08:46:08'),
(47, 48, 'vnpay', NULL, 'TXNSCXRF3GOLQMK', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(48, 49, 'bank_transfer', NULL, 'TXNAYJFRTZY4GRQ', NULL, NULL, NULL, NULL, NULL, 1480000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(49, 50, 'bank_transfer', NULL, 'TXN3DDSZ2L3I0I2', NULL, NULL, NULL, NULL, NULL, 1330000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(50, 51, 'cod', NULL, 'TXNEG3F0WHFIYGA', NULL, NULL, NULL, NULL, NULL, 1150000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(51, 52, 'vnpay', NULL, 'TXNUBGAPF16PGNG', NULL, NULL, NULL, NULL, NULL, 1450000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(52, 53, 'cod', NULL, 'TXNAWFQNB0C1DN8', NULL, NULL, NULL, NULL, NULL, 1470000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(53, 54, 'vnpay', NULL, 'TXNFWYHFUP82CBM', NULL, NULL, NULL, NULL, NULL, 840000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(54, 55, 'vnpay', NULL, 'TXNVMSHHKFDFR9Z', NULL, NULL, NULL, NULL, NULL, 920000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(55, 56, 'vnpay', NULL, 'TXNSN4T6J8SAAMY', NULL, NULL, NULL, NULL, NULL, 1100000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(56, 57, 'cod', NULL, 'TXNZIU9VAZZSTFV', NULL, NULL, NULL, NULL, NULL, 1010000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(57, 58, 'vnpay', NULL, 'TXNGETPP9AOKRTU', NULL, NULL, NULL, NULL, NULL, 1040000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(58, 59, 'bank_transfer', NULL, 'TXN7GL5WAK0D30O', NULL, NULL, NULL, NULL, NULL, 970000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(59, 60, 'bank_transfer', NULL, 'TXN9VZERQ6SUFHG', NULL, NULL, NULL, NULL, NULL, 1190000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(60, 61, 'vnpay', NULL, 'TXNDKM1MWSGFA63', NULL, NULL, NULL, NULL, NULL, 1450000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(61, 62, 'cod', NULL, 'TXNUZHX3S76DDHL', NULL, NULL, NULL, NULL, NULL, 1840000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(62, 63, 'vnpay', NULL, 'TXNRGE7RMAXPJ38', NULL, NULL, NULL, NULL, NULL, 930000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(63, 64, 'cod', NULL, 'TXNT7AZKFJT4FNV', NULL, NULL, NULL, NULL, NULL, 1070000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(64, 65, 'cod', NULL, 'TXNI3SSPFHNJDGY', NULL, NULL, NULL, NULL, NULL, 1270000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(65, 66, 'cod', NULL, 'TXNCLNDBZO1WIRY', NULL, NULL, NULL, NULL, NULL, 760000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(66, 67, 'cod', NULL, 'TXNBMP8DXLFOYUB', NULL, NULL, NULL, NULL, NULL, 1390000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(67, 68, 'cod', NULL, 'TXNPIP7MDSNSKNQ', NULL, NULL, NULL, NULL, NULL, 1230000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(68, 69, 'bank_transfer', NULL, 'TXNFKO7FTWZS3TO', NULL, NULL, NULL, NULL, NULL, 1580000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(69, 70, 'bank_transfer', NULL, 'TXNHSTKKCRAVYJ8', NULL, NULL, NULL, NULL, NULL, 1630000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(70, 71, 'cod', NULL, 'TXNRHXCWC1OLOK3', NULL, NULL, NULL, NULL, NULL, 1580000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(71, 72, 'vnpay', NULL, 'TXNGPIZTKVBFT5H', NULL, NULL, NULL, NULL, NULL, 1820000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(72, 73, 'cod', NULL, 'TXN61G1BQ6YZ25Y', NULL, NULL, NULL, NULL, NULL, 930000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(73, 74, 'vnpay', NULL, 'TXNYXMHYYGFY48M', NULL, NULL, NULL, NULL, NULL, 2130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(74, 75, 'bank_transfer', NULL, 'TXNBYXWKAYLPIHI', NULL, NULL, NULL, NULL, NULL, 1170000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(75, 76, 'vnpay', NULL, 'TXNIQAJWKZY24AG', NULL, NULL, NULL, NULL, NULL, 1280000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(76, 77, 'bank_transfer', NULL, 'TXNAO7IESFYV8QI', NULL, NULL, NULL, NULL, NULL, 1270000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(77, 78, 'cod', NULL, 'TXNJMGDCM1YWDON', NULL, NULL, NULL, NULL, NULL, 1000000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(78, 79, 'cod', NULL, 'TXNCYGMNADX7MDT', NULL, NULL, NULL, NULL, NULL, 1770000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(79, 80, 'cod', NULL, 'TXNTNGMRYMVNU1Y', NULL, NULL, NULL, NULL, NULL, 1390000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(80, 81, 'bank_transfer', NULL, 'TXN4KLQNV2PC3GX', NULL, NULL, NULL, NULL, NULL, 760000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(81, 82, 'cod', NULL, 'TXNIEQ285UGRTPR', NULL, NULL, NULL, NULL, NULL, 1060000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(82, 83, 'cod', NULL, 'TXNS2SLXPWVGJN1', NULL, NULL, NULL, NULL, NULL, 850000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(83, 84, 'cod', NULL, 'TXNMVW9Q0NG7TKQ', NULL, NULL, NULL, NULL, NULL, 1520000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(84, 85, 'cod', NULL, 'TXNFYWJ3AMWX0MO', NULL, NULL, NULL, NULL, NULL, 1120000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(85, 86, 'bank_transfer', NULL, 'TXNYEUW5XEMHE7J', NULL, NULL, NULL, NULL, NULL, 810000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(86, 87, 'cod', NULL, 'TXNBSEAVJAGJEON', NULL, NULL, NULL, NULL, NULL, 1190000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(87, 88, 'bank_transfer', NULL, 'TXNSXEA5NMMMEFT', NULL, NULL, NULL, NULL, NULL, 920000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(88, 89, 'bank_transfer', NULL, 'TXNAYBFNC6AJ9XQ', NULL, NULL, NULL, NULL, NULL, 1030000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(89, 90, 'cod', NULL, 'TXNRYJ1G9RU8QA4', NULL, NULL, NULL, NULL, NULL, 1890000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(90, 91, 'cod', NULL, 'TXN7XQOCHY4YYPE', NULL, NULL, NULL, NULL, NULL, 990000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(91, 92, 'bank_transfer', NULL, 'TXNZMGYIPEZW2IN', NULL, NULL, NULL, NULL, NULL, 870000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(92, 93, 'cod', NULL, 'TXNXMFBCOWVLEQ9', NULL, NULL, NULL, NULL, NULL, 930000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(93, 94, 'cod', NULL, 'TXNQUDW2VJXFZYU', NULL, NULL, NULL, NULL, NULL, 720000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(94, 95, 'vnpay', NULL, 'TXNB0DUKCONWPFQ', NULL, NULL, NULL, NULL, NULL, 1030000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(95, 96, 'bank_transfer', NULL, 'TXNDA6EGJAE2OCE', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(96, 97, 'vnpay', NULL, 'TXNRSMYDSWPCO0P', NULL, NULL, NULL, NULL, NULL, 1570000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(97, 98, 'bank_transfer', NULL, 'TXNXKPV7D6REGBK', NULL, NULL, NULL, NULL, NULL, 1600000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(98, 99, 'cod', NULL, 'TXNSTBYKB065KW2', NULL, NULL, NULL, NULL, NULL, 1510000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(99, 100, 'vnpay', NULL, 'TXNTUP2R2PDYJ4H', NULL, NULL, NULL, NULL, NULL, 1120000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(100, 101, 'bank_transfer', NULL, 'TXNMTVCC07ZYZBX', NULL, NULL, NULL, NULL, NULL, 660000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(101, 102, 'cod', NULL, 'TXNQ0UD6KUCBVFL', NULL, NULL, NULL, NULL, NULL, 910000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(102, 103, 'bank_transfer', NULL, 'TXN9M84GZJFRCZ6', NULL, NULL, NULL, NULL, NULL, 1250000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(103, 104, 'vnpay', NULL, 'TXNMDRNEHGRSKBT', NULL, NULL, NULL, NULL, NULL, 2030000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(104, 105, 'vnpay', NULL, 'TXNSV3VNJJQRQ3B', NULL, NULL, NULL, NULL, NULL, 1140000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(105, 106, 'cod', NULL, 'TXNUT3JFYU9IPSX', NULL, NULL, NULL, NULL, NULL, 1870000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(106, 107, 'bank_transfer', NULL, 'TXNKYX8JM1KUMCN', NULL, NULL, NULL, NULL, NULL, 980000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(107, 108, 'vnpay', NULL, 'TXNYAJV9CCLWBYF', NULL, NULL, NULL, NULL, NULL, 1150000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(108, 109, 'cod', NULL, 'TXNIUM4NNQDMXMT', NULL, NULL, NULL, NULL, NULL, 1180000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(109, 110, 'vnpay', NULL, 'TXNMDGTJBG0134L', NULL, NULL, NULL, NULL, NULL, 700000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(110, 111, 'cod', NULL, 'TXNNSTRL7MUVGPE', NULL, NULL, NULL, NULL, NULL, 2130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(111, 112, 'cod', NULL, 'TXNZXDD7C5UTDO9', NULL, NULL, NULL, NULL, NULL, 600000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(112, 113, 'bank_transfer', NULL, 'TXNHOOVDMU0R1YO', NULL, NULL, NULL, NULL, NULL, 1490000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(113, 114, 'bank_transfer', NULL, 'TXNMFYHMSK2LUFI', NULL, NULL, NULL, NULL, NULL, 770000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(114, 115, 'bank_transfer', NULL, 'TXNXQVHFD5ZWFBH', NULL, NULL, NULL, NULL, NULL, 1210000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(115, 116, 'bank_transfer', NULL, 'TXN3KBGMZIE9AVE', NULL, NULL, NULL, NULL, NULL, 1040000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(116, 117, 'vnpay', NULL, 'TXNOFOWSVPAMU5L', NULL, NULL, NULL, NULL, NULL, 1080000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(117, 118, 'cod', NULL, 'TXNMHFUJYCGNZ28', NULL, NULL, NULL, NULL, NULL, 1510000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(118, 119, 'cod', NULL, 'TXNAIK9LXR3DOGS', NULL, NULL, NULL, NULL, NULL, 1570000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(119, 120, 'cod', NULL, 'TXNDHSLRGL6TD0O', NULL, NULL, NULL, NULL, NULL, 1590000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(120, 121, 'bank_transfer', NULL, 'TXNKUUQGQISVFZX', NULL, NULL, NULL, NULL, NULL, 1490000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(121, 122, 'cod', NULL, 'TXNCK65FQIVOQ8K', NULL, NULL, NULL, NULL, NULL, 1370000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(122, 123, 'cod', NULL, 'TXNZ1NI0UE7MT6Z', NULL, NULL, NULL, NULL, NULL, 1090000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(123, 124, 'vnpay', NULL, 'TXNFOLRKSMR8MXQ', NULL, NULL, NULL, NULL, NULL, 1140000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(124, 125, 'bank_transfer', NULL, 'TXNN9IKIR8TLAKZ', NULL, NULL, NULL, NULL, NULL, 1710000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(125, 126, 'vnpay', NULL, 'TXNWZGKAKSCGC2A', NULL, NULL, NULL, NULL, NULL, 1480000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(126, 127, 'vnpay', NULL, 'TXNLHPUY0NR7XPD', NULL, NULL, NULL, NULL, NULL, 1850000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(127, 128, 'bank_transfer', NULL, 'TXNOXJJEEFNRNUQ', NULL, NULL, NULL, NULL, NULL, 1490000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(128, 129, 'vnpay', NULL, 'TXNWZZMMY3Q0YMT', NULL, NULL, NULL, NULL, NULL, 1700000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(129, 130, 'cod', NULL, 'TXNKDELUT22LSAN', NULL, NULL, NULL, NULL, NULL, 1490000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(130, 131, 'vnpay', NULL, 'TXNEVGYVKRD2JQR', NULL, NULL, NULL, NULL, NULL, 950000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(131, 132, 'vnpay', NULL, 'TXNY0PABRJELKCF', NULL, NULL, NULL, NULL, NULL, 1230000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(132, 133, 'vnpay', NULL, 'TXN81ZJVGRNJ1MV', NULL, NULL, NULL, NULL, NULL, 1840000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(133, 134, 'bank_transfer', NULL, 'TXN8LO9G4JNSGWG', NULL, NULL, NULL, NULL, NULL, 990000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(134, 135, 'bank_transfer', NULL, 'TXN74G6TN0ZLVGX', NULL, NULL, NULL, NULL, NULL, 1620000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(135, 136, 'bank_transfer', NULL, 'TXNMKN9UY4FT1BK', NULL, NULL, NULL, NULL, NULL, 1690000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(136, 137, 'bank_transfer', NULL, 'TXNLRDGSANR8WZP', NULL, NULL, NULL, NULL, NULL, 1540000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(137, 138, 'vnpay', NULL, 'TXNKTDULJSHRQWI', NULL, NULL, NULL, NULL, NULL, 1670000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(138, 139, 'vnpay', NULL, 'TXNQLX7ENAGPS4D', NULL, NULL, NULL, NULL, NULL, 1300000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(139, 140, 'vnpay', NULL, 'TXN8HSWGPC1E7WD', NULL, NULL, NULL, NULL, NULL, 1300000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(140, 141, 'cod', NULL, 'TXNH4JBRTY57JZT', NULL, NULL, NULL, NULL, NULL, 1300000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(141, 142, 'bank_transfer', NULL, 'TXNG5ALAHGPTFBK', NULL, NULL, NULL, NULL, NULL, 1060000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(142, 143, 'cod', NULL, 'TXNXR1RQSHBNRWU', NULL, NULL, NULL, NULL, NULL, 680000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(143, 144, 'cod', NULL, 'TXNBBLPOFLETU6O', NULL, NULL, NULL, NULL, NULL, 1830000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(144, 145, 'bank_transfer', NULL, 'TXNRON5TYJA85AK', NULL, NULL, NULL, NULL, NULL, 740000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(145, 146, 'vnpay', NULL, 'TXNSQCMZXHGNTSE', NULL, NULL, NULL, NULL, NULL, 2100000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(146, 147, 'cod', NULL, 'TXNIQAAAQPQTL5N', NULL, NULL, NULL, NULL, NULL, 1670000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(147, 148, 'bank_transfer', NULL, 'TXNL2QNJQCFTMIK', NULL, NULL, NULL, NULL, NULL, 1450000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(148, 149, 'vnpay', NULL, 'TXN9TTRIAUBH4RJ', NULL, NULL, NULL, NULL, NULL, 800000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(149, 150, 'bank_transfer', NULL, 'TXNZI42MXT6GLXW', NULL, NULL, NULL, NULL, NULL, 1140000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(150, 151, 'bank_transfer', NULL, 'TXNBMNMWZLTL291', NULL, NULL, NULL, NULL, NULL, 1250000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(151, 152, 'bank_transfer', NULL, 'TXNGCDSORLEB8IM', NULL, NULL, NULL, NULL, NULL, 1390000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(152, 153, 'cod', NULL, 'TXNQD5RPGKWETOI', NULL, NULL, NULL, NULL, NULL, 720000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(153, 154, 'cod', NULL, 'TXN0DAQGPOUMP9L', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(154, 155, 'bank_transfer', NULL, 'TXNSTDAOXXPBMOP', NULL, NULL, NULL, NULL, NULL, 960000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(155, 156, 'bank_transfer', NULL, 'TXNVOMMXRYHDGIM', NULL, NULL, NULL, NULL, NULL, 1660000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(156, 157, 'bank_transfer', NULL, 'TXNCSW9UPIL38LV', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(157, 158, 'vnpay', NULL, 'TXN1K7T4LQHEZ8P', NULL, NULL, NULL, NULL, NULL, 1190000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(158, 159, 'vnpay', NULL, 'TXN86BJTP3NYCIG', NULL, NULL, NULL, NULL, NULL, 1730000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(159, 160, 'bank_transfer', NULL, 'TXNA75XDYXUDUGL', NULL, NULL, NULL, NULL, NULL, 1430000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(160, 161, 'bank_transfer', NULL, 'TXNW2ZPE7AQYXH7', NULL, NULL, NULL, NULL, NULL, 1290000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(161, 162, 'vnpay', NULL, 'TXNXL4XYRPXPCXG', NULL, NULL, NULL, NULL, NULL, 660000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(162, 163, 'cod', NULL, 'TXN5EJSZLXRNJAO', NULL, NULL, NULL, NULL, NULL, 1550000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(163, 164, 'vnpay', NULL, 'TXNWCCQPEKRHUAC', NULL, NULL, NULL, NULL, NULL, 1870000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(164, 165, 'cod', NULL, 'TXNC97BNAE3QYYO', NULL, NULL, NULL, NULL, NULL, 1450000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(165, 166, 'cod', NULL, 'TXNCGZRF7DVPGVT', NULL, NULL, NULL, NULL, NULL, 1710000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(166, 167, 'cod', NULL, 'TXNSYYZG1IT7E52', NULL, NULL, NULL, NULL, NULL, 1380000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(167, 168, 'vnpay', NULL, 'TXNRGFGSLQDUXBK', NULL, NULL, NULL, NULL, NULL, 1320000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(168, 169, 'bank_transfer', NULL, 'TXNYD77Z95PDKYN', NULL, NULL, NULL, NULL, NULL, 1060000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(169, 170, 'bank_transfer', NULL, 'TXNS5FSFWLC4D8K', NULL, NULL, NULL, NULL, NULL, 1080000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(170, 171, 'bank_transfer', NULL, 'TXNG0XGCWFCXUG4', NULL, NULL, NULL, NULL, NULL, 1400000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(171, 172, 'vnpay', NULL, 'TXNYYVGTNTIC08A', NULL, NULL, NULL, NULL, NULL, 1090000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(172, 173, 'cod', NULL, 'TXNBBZVGJ5BG6UT', NULL, NULL, NULL, NULL, NULL, 1560000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(173, 174, 'vnpay', NULL, 'TXNOCGIZPTZTHUE', NULL, NULL, NULL, NULL, NULL, 1960000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(174, 175, 'bank_transfer', NULL, 'TXNHSXN9ISGB32C', NULL, NULL, NULL, NULL, NULL, 950000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(175, 176, 'bank_transfer', NULL, 'TXNDAAIIXO9B2L1', NULL, NULL, NULL, NULL, NULL, 1290000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(176, 177, 'vnpay', NULL, 'TXNSUROXOIDAOIS', NULL, NULL, NULL, NULL, NULL, 1410000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(177, 178, 'vnpay', NULL, 'TXN0MY5OBECBBGG', NULL, NULL, NULL, NULL, NULL, 1050000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(178, 179, 'bank_transfer', NULL, 'TXNYFEV0FNBIL01', NULL, NULL, NULL, NULL, NULL, 1350000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(179, 180, 'cod', NULL, 'TXNUHRQMSXF04NP', NULL, NULL, NULL, NULL, NULL, 1410000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(180, 181, 'bank_transfer', NULL, 'TXNS39EXTHVDLCK', NULL, NULL, NULL, NULL, NULL, 1940000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(181, 182, 'bank_transfer', NULL, 'TXND3ECR7PCCO3M', NULL, NULL, NULL, NULL, NULL, 1350000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(182, 183, 'vnpay', NULL, 'TXNPMHYDS7NDU9Q', NULL, NULL, NULL, NULL, NULL, 1970000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(183, 184, 'vnpay', NULL, 'TXNOQD1V9EGSJXB', NULL, NULL, NULL, NULL, NULL, 950000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(184, 185, 'vnpay', NULL, 'TXN13ZDQPTJDYWE', NULL, NULL, NULL, NULL, NULL, 1380000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(185, 186, 'vnpay', NULL, 'TXNC1VFECZZEK4R', NULL, NULL, NULL, NULL, NULL, 1970000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(186, 187, 'bank_transfer', NULL, 'TXN95FILMY837Z9', NULL, NULL, NULL, NULL, NULL, 2170000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(187, 188, 'bank_transfer', NULL, 'TXNCTCDAV5IRW0J', NULL, NULL, NULL, NULL, NULL, 690000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(188, 189, 'vnpay', NULL, 'TXN0LSFS2ECWVKZ', NULL, NULL, NULL, NULL, NULL, 1450000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(189, 190, 'cod', NULL, 'TXNNIQXNZNLZOGI', NULL, NULL, NULL, NULL, NULL, 880000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(190, 191, 'bank_transfer', NULL, 'TXNCV7W9XIMDQPW', NULL, NULL, NULL, NULL, NULL, 1730000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(191, 192, 'cod', NULL, 'TXNVZFBEK4RKT60', NULL, NULL, NULL, NULL, NULL, 1370000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(192, 193, 'cod', NULL, 'TXNNV98SNOXMCJW', NULL, NULL, NULL, NULL, NULL, 1020000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(193, 194, 'cod', NULL, 'TXN5JTT9BEEQZC3', NULL, NULL, NULL, NULL, NULL, 1380000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(194, 195, 'vnpay', NULL, 'TXN0UBOWBF4PCVM', NULL, NULL, NULL, NULL, NULL, 760000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(195, 196, 'bank_transfer', NULL, 'TXNAEWPX9ACD79I', NULL, NULL, NULL, NULL, NULL, 1540000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(196, 197, 'bank_transfer', NULL, 'TXNLU6QHEER2IHN', NULL, NULL, NULL, NULL, NULL, 1400000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(197, 198, 'bank_transfer', NULL, 'TXNOJPTSPEULKN7', NULL, NULL, NULL, NULL, NULL, 1040000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(198, 199, 'vnpay', NULL, 'TXNUYNGTVMPZOZV', NULL, NULL, NULL, NULL, NULL, 1860000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(199, 200, 'bank_transfer', NULL, 'TXNIHLKLHFFTMM0', NULL, NULL, NULL, NULL, NULL, 1390000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(200, 201, 'bank_transfer', NULL, 'TXNYPHMZEIJVFLK', NULL, NULL, NULL, NULL, NULL, 890000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(201, 202, 'vnpay', NULL, 'TXNUI0XWR6GIDTF', NULL, NULL, NULL, NULL, NULL, 980000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(202, 203, 'vnpay', NULL, 'TXNJDNQINHK0CTH', NULL, NULL, NULL, NULL, NULL, 1510000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(203, 204, 'cod', NULL, 'TXNY73JJ5YOXGGT', NULL, NULL, NULL, NULL, NULL, 750000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(204, 205, 'vnpay', NULL, 'TXNVUT0KMMZRBHB', NULL, NULL, NULL, NULL, NULL, 2030000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(205, 206, 'cod', NULL, 'TXNJZ6T6LSFRWVU', NULL, NULL, NULL, NULL, NULL, 1510000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(206, 207, 'bank_transfer', NULL, 'TXNZZXAFLEIVAMW', NULL, NULL, NULL, NULL, NULL, 1550000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(207, 208, 'bank_transfer', NULL, 'TXNUIJPYLLS35LK', NULL, NULL, NULL, NULL, NULL, 880000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(208, 209, 'bank_transfer', NULL, 'TXNAOXJG8IMO3CO', NULL, NULL, NULL, NULL, NULL, 1300000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(209, 210, 'bank_transfer', NULL, 'TXNTENXJZOCM01N', NULL, NULL, NULL, NULL, NULL, 1820000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(210, 211, 'bank_transfer', NULL, 'TXNXBNT0OLMPFKN', NULL, NULL, NULL, NULL, NULL, 1170000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(211, 212, 'bank_transfer', NULL, 'TXN0JUCG6UDIV1H', NULL, NULL, NULL, NULL, NULL, 1390000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(212, 213, 'vnpay', NULL, 'TXNGWRBQIMU8NZZ', NULL, NULL, NULL, NULL, NULL, 1980000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(213, 214, 'cod', NULL, 'TXNCZ2EU3P9VP06', NULL, NULL, NULL, NULL, NULL, 1510000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(214, 215, 'vnpay', NULL, 'TXN518REQORUPN2', NULL, NULL, NULL, NULL, NULL, 1230000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(215, 216, 'vnpay', NULL, 'TXNLDMJVUYCNDTP', NULL, NULL, NULL, NULL, NULL, 900000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(216, 217, 'cod', NULL, 'TXNDKLCUSLOYIOZ', NULL, NULL, NULL, NULL, NULL, 1790000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(217, 218, 'vnpay', NULL, 'TXNL8ZTQPJUNP9V', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(218, 219, 'cod', NULL, 'TXN5AVIAGCJQMCT', NULL, NULL, NULL, NULL, NULL, 1910000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(219, 220, 'cod', NULL, 'TXNFISYIQC5G5RU', NULL, NULL, NULL, NULL, NULL, 1440000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(220, 221, 'cod', NULL, 'TXNWQ8ESCDTSU3A', NULL, NULL, NULL, NULL, NULL, 1110000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(221, 222, 'bank_transfer', NULL, 'TXNTUIGK2Y2X4FU', NULL, NULL, NULL, NULL, NULL, 1480000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(222, 223, 'vnpay', NULL, 'TXNCVRQWQ3UTLON', NULL, NULL, NULL, NULL, NULL, 2220000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(223, 224, 'cod', NULL, 'TXNCHDD29IMI5VO', NULL, NULL, NULL, NULL, NULL, 840000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(224, 225, 'vnpay', NULL, 'TXNRPGJEIZAORTQ', NULL, NULL, NULL, NULL, NULL, 1720000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(225, 226, 'bank_transfer', NULL, 'TXNNG3D07AHPHIK', NULL, NULL, NULL, NULL, NULL, 880000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(226, 227, 'bank_transfer', NULL, 'TXN9LHC0DOFRQPL', NULL, NULL, NULL, NULL, NULL, 1950000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(227, 228, 'cod', NULL, 'TXNBJCN5N6TOB8O', NULL, NULL, NULL, NULL, NULL, 1390000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(228, 229, 'bank_transfer', NULL, 'TXN03YNH4IZHKE6', NULL, NULL, NULL, NULL, NULL, 1560000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(229, 230, 'cod', NULL, 'TXN4ORF5ASR7OZM', NULL, NULL, NULL, NULL, NULL, 760000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(230, 231, 'vnpay', NULL, 'TXNI2MNA7BVR5CU', NULL, NULL, NULL, NULL, NULL, 1550000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(231, 232, 'cod', NULL, 'TXNVMRJQB2GPMD7', NULL, NULL, NULL, NULL, NULL, 1400000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(232, 233, 'bank_transfer', NULL, 'TXNUFM2XDQDPWSE', NULL, NULL, NULL, NULL, NULL, 930000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(233, 234, 'vnpay', NULL, 'TXNYQLVSISBZEGW', NULL, NULL, NULL, NULL, NULL, 1590000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(234, 235, 'bank_transfer', NULL, 'TXNC9HGDTHX5NBM', NULL, NULL, NULL, NULL, NULL, 1110000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(235, 236, 'cod', NULL, 'TXNLCYKZSODIFFC', NULL, NULL, NULL, NULL, NULL, 1310000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(236, 237, 'vnpay', NULL, 'TXNDC1DANBG8GQ4', NULL, NULL, NULL, NULL, NULL, 930000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(237, 238, 'vnpay', NULL, 'TXNBV3CSDQF255Z', NULL, NULL, NULL, NULL, NULL, 1020000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(238, 239, 'cod', NULL, 'TXNSHS4YWELIAKN', NULL, NULL, NULL, NULL, NULL, 1540000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(239, 240, 'vnpay', NULL, 'TXN7VXMD9JOFZX2', NULL, NULL, NULL, NULL, NULL, 940000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(240, 241, 'cod', NULL, 'TXNJLEGDGVOVXMU', NULL, NULL, NULL, NULL, NULL, 1090000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(241, 242, 'bank_transfer', NULL, 'TXNAGGLHKDXGROB', NULL, NULL, NULL, NULL, NULL, 1210000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(242, 243, 'cod', NULL, 'TXNQE2PUEAUQVWF', NULL, NULL, NULL, NULL, NULL, 620000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(243, 244, 'bank_transfer', NULL, 'TXNSFNOWOF4KCZ6', NULL, NULL, NULL, NULL, NULL, 920000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(244, 245, 'bank_transfer', NULL, 'TXNWSBS9TRJFJGW', NULL, NULL, NULL, NULL, NULL, 580000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(245, 246, 'bank_transfer', NULL, 'TXNTMILRM2MELW6', NULL, NULL, NULL, NULL, NULL, 1160000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(246, 247, 'bank_transfer', NULL, 'TXNN8EYS7BVOOG9', NULL, NULL, NULL, NULL, NULL, 1420000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(247, 248, 'cod', NULL, 'TXNRA6ALRVOPYY5', NULL, NULL, NULL, NULL, NULL, 1610000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(248, 249, 'bank_transfer', NULL, 'TXNXOE3PMOAU6OQ', NULL, NULL, NULL, NULL, NULL, 1150000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(249, 250, 'vnpay', NULL, 'TXNLAOPLH0JWOFS', NULL, NULL, NULL, NULL, NULL, 1090000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(250, 251, 'bank_transfer', NULL, 'TXNNHFV2HNDZJKJ', NULL, NULL, NULL, NULL, NULL, 1470000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(251, 252, 'bank_transfer', NULL, 'TXNINTKBWFP4SYM', NULL, NULL, NULL, NULL, NULL, 1520000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(252, 253, 'cod', NULL, 'TXNSV1MJDXBFEUO', NULL, NULL, NULL, NULL, NULL, 1470000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(253, 254, 'bank_transfer', NULL, 'TXNWD7WPXIBUDOS', NULL, NULL, NULL, NULL, NULL, 1630000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(254, 255, 'vnpay', NULL, 'TXNLJB9Z5HWX6CW', NULL, NULL, NULL, NULL, NULL, 1430000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(255, 256, 'vnpay', NULL, 'TXNTKHQC7SPGRPN', NULL, NULL, NULL, NULL, NULL, 750000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(256, 257, 'cod', NULL, 'TXN9FEZBIHKOMAG', NULL, NULL, NULL, NULL, NULL, 1020000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(257, 258, 'bank_transfer', NULL, 'TXNY2EV0DWPJD04', NULL, NULL, NULL, NULL, NULL, 1810000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(258, 259, 'bank_transfer', NULL, 'TXNOPLSBPPF6P8Z', NULL, NULL, NULL, NULL, NULL, 1220000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(259, 260, 'bank_transfer', NULL, 'TXNVCWWR5QMC2EM', NULL, NULL, NULL, NULL, NULL, 850000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(260, 261, 'vnpay', NULL, 'TXNL2EA6VQQP7MP', NULL, NULL, NULL, NULL, NULL, 1630000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(261, 262, 'bank_transfer', NULL, 'TXNIDJMPGGTRBPV', NULL, NULL, NULL, NULL, NULL, 1510000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(262, 263, 'bank_transfer', NULL, 'TXNNZSQDTSGT3CS', NULL, NULL, NULL, NULL, NULL, 1300000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(263, 264, 'cod', NULL, 'TXN578MOM0Z0GK9', NULL, NULL, NULL, NULL, NULL, 630000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(264, 265, 'bank_transfer', NULL, 'TXNWUDGEH1UXUIS', NULL, NULL, NULL, NULL, NULL, 2020000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(265, 266, 'bank_transfer', NULL, 'TXNIA21WHYN0YHF', NULL, NULL, NULL, NULL, NULL, 1010000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(266, 267, 'cod', NULL, 'TXNCZRTMLC8ZIY7', NULL, NULL, NULL, NULL, NULL, 810000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(267, 268, 'cod', NULL, 'TXNDWNPMACDTTT3', NULL, NULL, NULL, NULL, NULL, 950000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(268, 269, 'vnpay', NULL, 'TXNAXO0AU7GLDSD', NULL, NULL, NULL, NULL, NULL, 550000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(269, 270, 'bank_transfer', NULL, 'TXNFEHCA26DVCAM', NULL, NULL, NULL, NULL, NULL, 1350000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(270, 271, 'cod', NULL, 'TXNN8CRSPWXXJCM', NULL, NULL, NULL, NULL, NULL, 1950000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(271, 272, 'vnpay', NULL, 'TXNVIDMCJQGVBG6', NULL, NULL, NULL, NULL, NULL, 1400000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(272, 273, 'cod', NULL, 'TXN3CWVCASHF1TH', NULL, NULL, NULL, NULL, NULL, 1610000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(273, 274, 'cod', NULL, 'TXNQQSNXX093TF6', NULL, NULL, NULL, NULL, NULL, 1570000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(274, 275, 'cod', NULL, 'TXNODCNIH9GJLKU', NULL, NULL, NULL, NULL, NULL, 1090000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(275, 276, 'bank_transfer', NULL, 'TXNW7AR6I2XHT5A', NULL, NULL, NULL, NULL, NULL, 1250000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(276, 277, 'vnpay', NULL, 'TXNUNYV6RBIPT5F', NULL, NULL, NULL, NULL, NULL, 1790000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(277, 278, 'bank_transfer', NULL, 'TXN7RYSGOSX3RCT', NULL, NULL, NULL, NULL, NULL, 760000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(278, 279, 'cod', NULL, 'TXNQNN6HWJMSG0O', NULL, NULL, NULL, NULL, NULL, 670000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(279, 280, 'vnpay', NULL, 'TXNCTUVZTBLE7MZ', NULL, NULL, NULL, NULL, NULL, 780000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(280, 281, 'bank_transfer', NULL, 'TXNLCJVK1SEO3JU', NULL, NULL, NULL, NULL, NULL, 1690000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(281, 282, 'cod', NULL, 'TXN1WINW2ZARMOI', NULL, NULL, NULL, NULL, NULL, 860000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(282, 283, 'vnpay', NULL, 'TXNROQN2PPEYW4X', NULL, NULL, NULL, NULL, NULL, 1390000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(283, 284, 'cod', NULL, 'TXNE5YNYCM70O0W', NULL, NULL, NULL, NULL, NULL, 1760000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(284, 285, 'bank_transfer', NULL, 'TXN5S1TUTZIEJ7L', NULL, NULL, NULL, NULL, NULL, 1030000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(285, 286, 'cod', NULL, 'TXNKNR3XZW478AV', NULL, NULL, NULL, NULL, NULL, 1230000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(286, 287, 'vnpay', NULL, 'TXN720SSHOMB1PL', NULL, NULL, NULL, NULL, NULL, 780000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(287, 288, 'bank_transfer', NULL, 'TXNLAX5EILPLXSX', NULL, NULL, NULL, NULL, NULL, 1890000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(288, 289, 'vnpay', NULL, 'TXNC1D2KX8JWKIY', NULL, NULL, NULL, NULL, NULL, 1070000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(289, 290, 'vnpay', NULL, 'TXNSJBUGYBZIX9U', NULL, NULL, NULL, NULL, NULL, 1310000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(290, 291, 'cod', NULL, 'TXNQDQPO7NOWTI0', NULL, NULL, NULL, NULL, NULL, 1690000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(291, 292, 'vnpay', NULL, 'TXND7HVAWE0REEZ', NULL, NULL, NULL, NULL, NULL, 1100000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(292, 293, 'vnpay', NULL, 'TXNWXKOIJXRBMS8', NULL, NULL, NULL, NULL, NULL, 1310000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(293, 294, 'vnpay', NULL, 'TXN7D1KMW8VF6AA', NULL, NULL, NULL, NULL, NULL, 1160000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(294, 295, 'bank_transfer', NULL, 'TXNZWCEOM7WXBIW', NULL, NULL, NULL, NULL, NULL, 1650000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(295, 296, 'cod', NULL, 'TXNPOIEUDCKNE8N', NULL, NULL, NULL, NULL, NULL, 1220000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(296, 297, 'vnpay', NULL, 'TXNJTQPLNWYHWWS', NULL, NULL, NULL, NULL, NULL, 1030000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(297, 298, 'bank_transfer', NULL, 'TXNF80JJLNT4X0E', NULL, NULL, NULL, NULL, NULL, 1210000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(298, 299, 'bank_transfer', NULL, 'TXN0C29TWXD2RAU', NULL, NULL, NULL, NULL, NULL, 650000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(299, 300, 'cod', NULL, 'TXNET0Y4JMHKRQM', NULL, NULL, NULL, NULL, NULL, 1490000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(300, 301, 'vnpay', NULL, 'TXNFYNIX4RPJ4CP', NULL, NULL, NULL, NULL, NULL, 1200000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(301, 302, 'cod', NULL, 'TXNXMOZRCKCULSY', NULL, NULL, NULL, NULL, NULL, 800000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(302, 303, 'cod', NULL, 'TXNBYHAARBELUSC', NULL, NULL, NULL, NULL, NULL, 920000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(303, 304, 'bank_transfer', NULL, 'TXNGILU3II6IOOI', NULL, NULL, NULL, NULL, NULL, 770000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(304, 305, 'bank_transfer', NULL, 'TXNLNQGVBCJ4Z9F', NULL, NULL, NULL, NULL, NULL, 880000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(305, 306, 'cod', NULL, 'TXNSPQGDQOIWLJL', NULL, NULL, NULL, NULL, NULL, 900000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(306, 307, 'bank_transfer', NULL, 'TXNZS1ORO2CF5MD', NULL, NULL, NULL, NULL, NULL, 1070000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(307, 308, 'cod', NULL, 'TXNLYBPX8QTEZ6S', NULL, NULL, NULL, NULL, NULL, 610000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(308, 309, 'cod', NULL, 'TXNVFQPU5BWJVO3', NULL, NULL, NULL, NULL, NULL, 1260000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(309, 310, 'cod', NULL, 'TXNKTD6W2QAAVX6', NULL, NULL, NULL, NULL, NULL, 1800000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(310, 311, 'bank_transfer', NULL, 'TXNKZIJYW8I7JLB', NULL, NULL, NULL, NULL, NULL, 1040000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(311, 312, 'bank_transfer', NULL, 'TXNV7C9L3ZVQM0J', NULL, NULL, NULL, NULL, NULL, 1050000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(312, 313, 'vnpay', NULL, 'TXNEYLKCMN2BUCQ', NULL, NULL, NULL, NULL, NULL, 1730000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(313, 314, 'bank_transfer', NULL, 'TXNCUUF5W5T4JXJ', NULL, NULL, NULL, NULL, NULL, 1760000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(314, 315, 'vnpay', NULL, 'TXN6ZIQDXJUNYZU', NULL, NULL, NULL, NULL, NULL, 1310000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(315, 316, 'bank_transfer', NULL, 'TXNOURQHMGOZWJV', NULL, NULL, NULL, NULL, NULL, 1390000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(316, 317, 'vnpay', NULL, 'TXNWXWZO298O2ZT', NULL, NULL, NULL, NULL, NULL, 720000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(317, 318, 'bank_transfer', NULL, 'TXNYJO9CVTATPZT', NULL, NULL, NULL, NULL, NULL, 880000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(318, 319, 'cod', NULL, 'TXNRWDATWGMSMJI', NULL, NULL, NULL, NULL, NULL, 1650000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(319, 320, 'cod', NULL, 'TXNLD1UBYPXV0ML', NULL, NULL, NULL, NULL, NULL, 2030000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(320, 321, 'bank_transfer', NULL, 'TXNQWDVCYM9883D', NULL, NULL, NULL, NULL, NULL, 1700000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(321, 322, 'vnpay', NULL, 'TXNE0IV7BE0B2RP', NULL, NULL, NULL, NULL, NULL, 1440000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(322, 323, 'vnpay', NULL, 'TXN05UYXREHERKI', NULL, NULL, NULL, NULL, NULL, 1930000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(323, 324, 'cod', NULL, 'TXNDGQTTMUUVJLU', NULL, NULL, NULL, NULL, NULL, 2040000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(324, 325, 'cod', NULL, 'TXNCLTBJNRQNPEP', NULL, NULL, NULL, NULL, NULL, 1300000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(325, 326, 'bank_transfer', NULL, 'TXNFCMVNGR4NLNJ', NULL, NULL, NULL, NULL, NULL, 1350000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24');
INSERT INTO `payments` (`id`, `order_id`, `provider`, `transaction_id`, `txn_ref`, `vnp_transaction_no`, `vnp_bank_code`, `vnp_card_type`, `vnp_pay_date`, `vnp_create_date`, `amount`, `status`, `request_data`, `response_data`, `paid_at`, `last_queried_at`, `query_count`, `failure_reason`, `created_at`, `updated_at`) VALUES
(326, 327, 'vnpay', NULL, 'TXNFIPON0RGHJ1R', NULL, NULL, NULL, NULL, NULL, 1340000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(327, 328, 'cod', NULL, 'TXN6V2E3OQ0D1VT', NULL, NULL, NULL, NULL, NULL, 1880000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(328, 329, 'cod', NULL, 'TXNE6GZ2Y9FKLIS', NULL, NULL, NULL, NULL, NULL, 1420000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(329, 330, 'cod', NULL, 'TXNAA5ET9VIKNVJ', NULL, NULL, NULL, NULL, NULL, 1530000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(330, 331, 'bank_transfer', NULL, 'TXN7LOG4JPOQHKO', NULL, NULL, NULL, NULL, NULL, 1180000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(331, 332, 'vnpay', NULL, 'TXNOGSXK4OIKS8R', NULL, NULL, NULL, NULL, NULL, 2090000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(332, 333, 'vnpay', NULL, 'TXNNMNDFJPWLADQ', NULL, NULL, NULL, NULL, NULL, 1140000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(333, 334, 'vnpay', NULL, 'TXNEFWAZLBYTIDB', NULL, NULL, NULL, NULL, NULL, 1160000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(334, 335, 'bank_transfer', NULL, 'TXN0AZIW6P6V5JX', NULL, NULL, NULL, NULL, NULL, 1060000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(335, 336, 'vnpay', NULL, 'TXNVDNT9G3IWKPM', NULL, NULL, NULL, NULL, NULL, 1320000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(336, 337, 'bank_transfer', NULL, 'TXNLGMKXJPBZ7CP', NULL, NULL, NULL, NULL, NULL, 1060000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(337, 338, 'bank_transfer', NULL, 'TXN3UEBTMNOQMLP', NULL, NULL, NULL, NULL, NULL, 880000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(338, 339, 'bank_transfer', NULL, 'TXNDLRHMADTXH2Y', NULL, NULL, NULL, NULL, NULL, 1370000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(339, 340, 'bank_transfer', NULL, 'TXNVVBNJJ6HBMVP', NULL, NULL, NULL, NULL, NULL, 1920000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(340, 341, 'vnpay', NULL, 'TXNDBTYXUQFD4SQ', NULL, NULL, NULL, NULL, NULL, 1260000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(341, 342, 'bank_transfer', NULL, 'TXNXPMFLYLF1VYQ', NULL, NULL, NULL, NULL, NULL, 1580000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(342, 343, 'vnpay', NULL, 'TXNPTMDCMLCMH3M', NULL, NULL, NULL, NULL, NULL, 1530000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(343, 344, 'vnpay', NULL, 'TXNFCPI4GFYGEJT', NULL, NULL, NULL, NULL, NULL, 1590000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(344, 345, 'bank_transfer', NULL, 'TXNU2OTIZUD7RQM', NULL, NULL, NULL, NULL, NULL, 760000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(345, 346, 'bank_transfer', NULL, 'TXNSLPIQ8TXII58', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(346, 347, 'vnpay', NULL, 'TXNNWQJZXE22U56', NULL, NULL, NULL, NULL, NULL, 680000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(347, 348, 'bank_transfer', NULL, 'TXNBW1PDV0SKDBL', NULL, NULL, NULL, NULL, NULL, 1600000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(348, 349, 'cod', NULL, 'TXNBX5LGECSWVJY', NULL, NULL, NULL, NULL, NULL, 1860000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(349, 350, 'bank_transfer', NULL, 'TXNFLY2TVYP2REW', NULL, NULL, NULL, NULL, NULL, 2030000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(350, 351, 'cod', NULL, 'TXNBLF87ZX3MEEU', NULL, NULL, NULL, NULL, NULL, 1220000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(351, 352, 'bank_transfer', NULL, 'TXNFBLXWFH86VNS', NULL, NULL, NULL, NULL, NULL, 1190000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(352, 353, 'vnpay', NULL, 'TXNYU5FPSDKG0BC', NULL, NULL, NULL, NULL, NULL, 1510000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(353, 354, 'vnpay', NULL, 'TXNC0HD3U5RNTG0', NULL, NULL, NULL, NULL, NULL, 1370000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(354, 355, 'bank_transfer', NULL, 'TXNFWXAEODOQADF', NULL, NULL, NULL, NULL, NULL, 1350000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(355, 356, 'vnpay', NULL, 'TXNW8NTI3INJPBW', NULL, NULL, NULL, NULL, NULL, 1600000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(356, 357, 'vnpay', NULL, 'TXNLZNVEJEJPNP8', NULL, NULL, NULL, NULL, NULL, 690000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(357, 358, 'bank_transfer', NULL, 'TXNYWBVZ60UOQIN', NULL, NULL, NULL, NULL, NULL, 1030000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(358, 359, 'vnpay', NULL, 'TXNRBXBSAU8OV26', NULL, NULL, NULL, NULL, NULL, 2270000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(359, 360, 'bank_transfer', NULL, 'TXNLEXKWVHBO5AY', NULL, NULL, NULL, NULL, NULL, 1330000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(360, 361, 'bank_transfer', NULL, 'TXNIIPXXKUHXJOJ', NULL, NULL, NULL, NULL, NULL, 1380000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(361, 362, 'cod', NULL, 'TXNWAOOMKVH71EL', NULL, NULL, NULL, NULL, NULL, 2240000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(362, 363, 'bank_transfer', NULL, 'TXN8623S2M4WRIP', NULL, NULL, NULL, NULL, NULL, 900000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(363, 364, 'cod', NULL, 'TXNKYUWGDUEZX3E', NULL, NULL, NULL, NULL, NULL, 1360000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(364, 365, 'vnpay', NULL, 'TXN2BNZQRPWM8DA', NULL, NULL, NULL, NULL, NULL, 1430000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(365, 366, 'vnpay', NULL, 'TXN88I2PBVQBU83', NULL, NULL, NULL, NULL, NULL, 1590000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(366, 367, 'vnpay', NULL, 'TXNQ4WTXDDK3A0S', NULL, NULL, NULL, NULL, NULL, 2260000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(367, 368, 'cod', NULL, 'TXN0R1U0ZZS6OVK', NULL, NULL, NULL, NULL, NULL, 2270000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(368, 369, 'bank_transfer', NULL, 'TXN7C3OLGBSUSV6', NULL, NULL, NULL, NULL, NULL, 580000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(369, 370, 'bank_transfer', NULL, 'TXNWPF45FWACVQN', NULL, NULL, NULL, NULL, NULL, 1090000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(370, 371, 'cod', NULL, 'TXNR1DH3C0WMVF0', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(371, 372, 'vnpay', NULL, 'TXN17AMOSXTK4TU', NULL, NULL, NULL, NULL, NULL, 1200000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(372, 373, 'bank_transfer', NULL, 'TXNS6OJULQRNDNM', NULL, NULL, NULL, NULL, NULL, 1670000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(373, 374, 'vnpay', NULL, 'TXNZDM6CIOS2ZGW', NULL, NULL, NULL, NULL, NULL, 1540000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(374, 375, 'cod', NULL, 'TXNS0CSKQZD9TPV', NULL, NULL, NULL, NULL, NULL, 1400000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(375, 376, 'vnpay', NULL, 'TXNDV6SIEXC4GI9', NULL, NULL, NULL, NULL, NULL, 1480000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(376, 377, 'vnpay', NULL, 'TXNRG1ME2SWI89F', NULL, NULL, NULL, NULL, NULL, 1010000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(377, 378, 'bank_transfer', NULL, 'TXNHUUNGCAKB9MU', NULL, NULL, NULL, NULL, NULL, 1440000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(378, 379, 'vnpay', NULL, 'TXN67W4XU4YTQWY', NULL, NULL, NULL, NULL, NULL, 1510000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(379, 380, 'cod', NULL, 'TXNZEVPPP6T2MM2', NULL, NULL, NULL, NULL, NULL, 1920000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(380, 381, 'bank_transfer', NULL, 'TXNOJAREQBAOUBS', NULL, NULL, NULL, NULL, NULL, 1860000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(381, 382, 'cod', NULL, 'TXNHRMC87HGQ8RW', NULL, NULL, NULL, NULL, NULL, 1600000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(382, 383, 'vnpay', NULL, 'TXN39GHQ1NN7HE8', NULL, NULL, NULL, NULL, NULL, 1310000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(383, 384, 'vnpay', NULL, 'TXNMS2SUQEE2XDJ', NULL, NULL, NULL, NULL, NULL, 1370000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(384, 385, 'bank_transfer', NULL, 'TXNVQYY28C4ADKB', NULL, NULL, NULL, NULL, NULL, 1460000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(385, 386, 'bank_transfer', NULL, 'TXNDEDKGWENW8HF', NULL, NULL, NULL, NULL, NULL, 1490000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(386, 387, 'vnpay', NULL, 'TXNZAPSGWHIYRHM', NULL, NULL, NULL, NULL, NULL, 1650000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(387, 388, 'vnpay', NULL, 'TXNQSXTAYAELV3I', NULL, NULL, NULL, NULL, NULL, 2010000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(388, 389, 'vnpay', NULL, 'TXNYRNCBC25LCFZ', NULL, NULL, NULL, NULL, NULL, 1560000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(389, 390, 'bank_transfer', NULL, 'TXN7HXFEUUQP0LE', NULL, NULL, NULL, NULL, NULL, 1090000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(390, 391, 'bank_transfer', NULL, 'TXNCH35RVTZQM0O', NULL, NULL, NULL, NULL, NULL, 1490000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(391, 392, 'vnpay', NULL, 'TXN8MENCQWWRCSO', NULL, NULL, NULL, NULL, NULL, 1070000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(392, 393, 'bank_transfer', NULL, 'TXNHEDDJ4AF1TAK', NULL, NULL, NULL, NULL, NULL, 1010000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(393, 394, 'vnpay', NULL, 'TXNT5N2C6YZAEXS', NULL, NULL, NULL, NULL, NULL, 1250000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(394, 395, 'vnpay', NULL, 'TXNC3B5AXSPRZUI', NULL, NULL, NULL, NULL, NULL, 1550000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(395, 396, 'bank_transfer', NULL, 'TXNGBENVUKLIGPN', NULL, NULL, NULL, NULL, NULL, 1510000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(396, 397, 'cod', NULL, 'TXNESHNRQQUQIWD', NULL, NULL, NULL, NULL, NULL, 1710000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(397, 398, 'cod', NULL, 'TXNOWBUWDDC1WV0', NULL, NULL, NULL, NULL, NULL, 940000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(398, 399, 'cod', NULL, 'TXNLWGFYOIPWKLE', NULL, NULL, NULL, NULL, NULL, 1050000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(399, 400, 'vnpay', NULL, 'TXNEDQDZERWJQYD', NULL, NULL, NULL, NULL, NULL, 1550000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(400, 401, 'vnpay', NULL, 'TXNSRBRAEHMNZN5', NULL, NULL, NULL, NULL, NULL, 1030000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(401, 402, 'bank_transfer', NULL, 'TXNFEPVA5SLMQQS', NULL, NULL, NULL, NULL, NULL, 1640000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(402, 403, 'bank_transfer', NULL, 'TXNKFZB8IOWFWHR', NULL, NULL, NULL, NULL, NULL, 1160000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(403, 404, 'bank_transfer', NULL, 'TXNBPD3ELXO18NQ', NULL, NULL, NULL, NULL, NULL, 1250000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(404, 405, 'bank_transfer', NULL, 'TXN8UYUVXU5RU4V', NULL, NULL, NULL, NULL, NULL, 1090000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(405, 406, 'bank_transfer', NULL, 'TXNARTW81QFVIXO', NULL, NULL, NULL, NULL, NULL, 940000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(406, 407, 'cod', NULL, 'TXNDLYECJEBULBI', NULL, NULL, NULL, NULL, NULL, 1380000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(407, 408, 'bank_transfer', NULL, 'TXNGSGBDJJLW8CV', NULL, NULL, NULL, NULL, NULL, 1100000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(408, 409, 'vnpay', NULL, 'TXNAUODLFFBP0MH', NULL, NULL, NULL, NULL, NULL, 780000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(409, 410, 'vnpay', NULL, 'TXNPDOOS5AFV64G', NULL, NULL, NULL, NULL, NULL, 1430000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(410, 411, 'cod', NULL, 'TXN71FIB3EVZRSW', NULL, NULL, NULL, NULL, NULL, 1150000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(411, 412, 'bank_transfer', NULL, 'TXN8GDKGPAFWGGH', NULL, NULL, NULL, NULL, NULL, 1730000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(412, 413, 'vnpay', NULL, 'TXNKROJILRRPIXW', NULL, NULL, NULL, NULL, NULL, 2090000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(413, 414, 'vnpay', NULL, 'TXN1U9ONJWVIB6P', NULL, NULL, NULL, NULL, NULL, 1110000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(414, 415, 'cod', NULL, 'TXNM2RLUTIF3K6O', NULL, NULL, NULL, NULL, NULL, 1020000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(415, 416, 'bank_transfer', NULL, 'TXN8WQKGDZRCDDH', NULL, NULL, NULL, NULL, NULL, 1860000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(416, 417, 'bank_transfer', NULL, 'TXNOI2O337ZTSNV', NULL, NULL, NULL, NULL, NULL, 1430000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(417, 418, 'cod', NULL, 'TXNLEH5KPSTCRVR', NULL, NULL, NULL, NULL, NULL, 1770000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(418, 419, 'bank_transfer', NULL, 'TXNASGEICAKJEBY', NULL, NULL, NULL, NULL, NULL, 1670000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(419, 420, 'vnpay', NULL, 'TXNVGIADSK19T6Z', NULL, NULL, NULL, NULL, NULL, 1490000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(420, 421, 'vnpay', NULL, 'TXNN25HTQAAXUL6', NULL, NULL, NULL, NULL, NULL, 1160000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(421, 422, 'vnpay', NULL, 'TXNBETWUOEH3QYP', NULL, NULL, NULL, NULL, NULL, 1480000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(422, 423, 'vnpay', NULL, 'TXNNGTBRXQ1B9W4', NULL, NULL, NULL, NULL, NULL, 1750000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(423, 424, 'cod', NULL, 'TXNLOOGZOGZRWVQ', NULL, NULL, NULL, NULL, NULL, 1710000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(424, 425, 'cod', NULL, 'TXNIMERZRDS9K9W', NULL, NULL, NULL, NULL, NULL, 830000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(425, 426, 'vnpay', NULL, 'TXN5N024VRMMZPE', NULL, NULL, NULL, NULL, NULL, 1300000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(426, 427, 'bank_transfer', NULL, 'TXN1T6HEGRCUABJ', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(427, 428, 'vnpay', NULL, 'TXN6EMTUH0UWX6U', NULL, NULL, NULL, NULL, NULL, 1510000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(428, 429, 'bank_transfer', NULL, 'TXNA7D3DMDM0S5O', NULL, NULL, NULL, NULL, NULL, 1390000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(429, 430, 'vnpay', NULL, 'TXNKQXOCVBNA8UK', NULL, NULL, NULL, NULL, NULL, 1790000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(430, 431, 'cod', NULL, 'TXNYQ3KZIMIDHRH', NULL, NULL, NULL, NULL, NULL, 1990000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(431, 432, 'cod', NULL, 'TXNY9IPSCWJKDCC', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(432, 433, 'cod', NULL, 'TXNBHEZKT7XXV1K', NULL, NULL, NULL, NULL, NULL, 1790000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(433, 434, 'cod', NULL, 'TXNRB1FTVD0QY27', NULL, NULL, NULL, NULL, NULL, 510000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(434, 435, 'vnpay', NULL, 'TXNROAZ7WUL3IGI', NULL, NULL, NULL, NULL, NULL, 1060000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(435, 436, 'bank_transfer', NULL, 'TXNWPL9MRX70SDJ', NULL, NULL, NULL, NULL, NULL, 1690000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(436, 437, 'bank_transfer', NULL, 'TXNECRLIPUTVUEY', NULL, NULL, NULL, NULL, NULL, 850000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(437, 438, 'cod', NULL, 'TXNDWC7NCWYT8ES', NULL, NULL, NULL, NULL, NULL, 1820000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(438, 439, 'bank_transfer', NULL, 'TXNWC08TXV1SOYW', NULL, NULL, NULL, NULL, NULL, 1840000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(439, 440, 'cod', NULL, 'TXNAHKOKBZ5PM8G', NULL, NULL, NULL, NULL, NULL, 1700000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(440, 441, 'vnpay', NULL, 'TXNQ0MND0SQJM2G', NULL, NULL, NULL, NULL, NULL, 1580000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(441, 442, 'vnpay', NULL, 'TXNPG8MYMLYIIES', NULL, NULL, NULL, NULL, NULL, 1750000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(442, 443, 'cod', NULL, 'TXNW3ELHEDSTY7C', NULL, NULL, NULL, NULL, NULL, 1050000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(443, 444, 'vnpay', NULL, 'TXNSOWFTSHVZDNN', NULL, NULL, NULL, NULL, NULL, 1990000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(444, 445, 'vnpay', NULL, 'TXNG5ZJFEIFY2D8', NULL, NULL, NULL, NULL, NULL, 1690000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(445, 446, 'cod', NULL, 'TXNJFEMO39QVZXG', NULL, NULL, NULL, NULL, NULL, 1930000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(446, 447, 'vnpay', NULL, 'TXNSMGYVKJSFL7Q', NULL, NULL, NULL, NULL, NULL, 1070000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(447, 448, 'vnpay', NULL, 'TXNCIHDOWLIR8DF', NULL, NULL, NULL, NULL, NULL, 1190000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(448, 449, 'bank_transfer', NULL, 'TXNGNLLNKHICXBR', NULL, NULL, NULL, NULL, NULL, 790000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(449, 450, 'bank_transfer', NULL, 'TXNBFKMSUIPIBCS', NULL, NULL, NULL, NULL, NULL, 1450000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(450, 451, 'bank_transfer', NULL, 'TXNZBSN5AGNZJ39', NULL, NULL, NULL, NULL, NULL, 1110000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(451, 452, 'bank_transfer', NULL, 'TXNNEFH6N56QZQ8', NULL, NULL, NULL, NULL, NULL, 1590000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(452, 453, 'cod', NULL, 'TXNIIEEGQE56CZA', NULL, NULL, NULL, NULL, NULL, 1330000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(453, 454, 'bank_transfer', NULL, 'TXNWBT9KCILJDBO', NULL, NULL, NULL, NULL, NULL, 900000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(454, 455, 'cod', NULL, 'TXNCELRYYXLOWSH', NULL, NULL, NULL, NULL, NULL, 1090000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(455, 456, 'cod', NULL, 'TXNRHY6AH8GSSIK', NULL, NULL, NULL, NULL, NULL, 1730000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(456, 457, 'vnpay', NULL, 'TXNM4MBM5Y3IQDM', NULL, NULL, NULL, NULL, NULL, 500000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(457, 458, 'vnpay', NULL, 'TXN6YBD0BU0VRBZ', NULL, NULL, NULL, NULL, NULL, 700000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(458, 459, 'cod', NULL, 'TXNA8LYBDQBNA89', NULL, NULL, NULL, NULL, NULL, 1810000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(459, 460, 'cod', NULL, 'TXNG6MZOS4T8JKM', NULL, NULL, NULL, NULL, NULL, 1220000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(460, 461, 'cod', NULL, 'TXNNYYM48PXYYKF', NULL, NULL, NULL, NULL, NULL, 1220000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(461, 462, 'cod', NULL, 'TXNTP4981TC2HIA', NULL, NULL, NULL, NULL, NULL, 1390000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(462, 463, 'cod', NULL, 'TXNKTWAVFFPZHFQ', NULL, NULL, NULL, NULL, NULL, 1310000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(463, 464, 'cod', NULL, 'TXNBNJ0E0VYVG6E', NULL, NULL, NULL, NULL, NULL, 1610000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(464, 465, 'bank_transfer', NULL, 'TXNWBVSLVOSXOYV', NULL, NULL, NULL, NULL, NULL, 1690000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(465, 466, 'vnpay', NULL, 'TXNVSWQIAXDAEWH', NULL, NULL, NULL, NULL, NULL, 980000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(466, 467, 'cod', NULL, 'TXNLPUR8VLSRMYI', NULL, NULL, NULL, NULL, NULL, 870000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(467, 468, 'vnpay', NULL, 'TXNVIGKHSZVSD61', NULL, NULL, NULL, NULL, NULL, 1210000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(468, 469, 'cod', NULL, 'TXNRYPQSJIOY7JX', NULL, NULL, NULL, NULL, NULL, 1170000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(469, 470, 'vnpay', NULL, 'TXNGHPFAPPIPGTL', NULL, NULL, NULL, NULL, NULL, 970000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(470, 471, 'cod', NULL, 'TXNVANMS4DFLVXU', NULL, NULL, NULL, NULL, NULL, 990000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(471, 472, 'bank_transfer', NULL, 'TXNCGSXG7LWWJWM', NULL, NULL, NULL, NULL, NULL, 1440000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(472, 473, 'bank_transfer', NULL, 'TXNQQPZWKDBESUN', NULL, NULL, NULL, NULL, NULL, 1570000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(473, 474, 'bank_transfer', NULL, 'TXNZVUHOLR88H2S', NULL, NULL, NULL, NULL, NULL, 1970000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(474, 475, 'bank_transfer', NULL, 'TXNONWOVHI2PBNP', NULL, NULL, NULL, NULL, NULL, 1660000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(475, 476, 'vnpay', NULL, 'TXN6B1MKYD7FBWB', NULL, NULL, NULL, NULL, NULL, 1750000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(476, 477, 'bank_transfer', NULL, 'TXNAG5UGUISRUMP', NULL, NULL, NULL, NULL, NULL, 1770000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(477, 478, 'cod', NULL, 'TXNYS3LEGYN2VEM', NULL, NULL, NULL, NULL, NULL, 880000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(478, 479, 'vnpay', NULL, 'TXN7ZZAFYFAWSAF', NULL, NULL, NULL, NULL, NULL, 1150000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(479, 480, 'vnpay', NULL, 'TXNAXXH7Y4KEAGA', NULL, NULL, NULL, NULL, NULL, 1710000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(480, 481, 'cod', NULL, 'TXNG83WBW2ACDDS', NULL, NULL, NULL, NULL, NULL, 1670000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(481, 482, 'cod', NULL, 'TXNXK06EWDBZ30Y', NULL, NULL, NULL, NULL, NULL, 1090000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(482, 483, 'vnpay', NULL, 'TXN9HY85VB9BOIR', NULL, NULL, NULL, NULL, NULL, 1120000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(483, 484, 'cod', NULL, 'TXNEKFHXQFNJXUQ', NULL, NULL, NULL, NULL, NULL, 1360000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(484, 485, 'bank_transfer', NULL, 'TXNTRHYSQJMLPZU', NULL, NULL, NULL, NULL, NULL, 1790000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(485, 486, 'vnpay', NULL, 'TXNZWZNE45MHFFN', NULL, NULL, NULL, NULL, NULL, 1250000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(486, 487, 'vnpay', NULL, 'TXNFP028LYZDX4F', NULL, NULL, NULL, NULL, NULL, 740000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(487, 488, 'bank_transfer', NULL, 'TXN52M9JVKATJLS', NULL, NULL, NULL, NULL, NULL, 870000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(488, 489, 'cod', NULL, 'TXNP4G6X9GWYZHE', NULL, NULL, NULL, NULL, NULL, 910000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(489, 490, 'vnpay', NULL, 'TXNTNY3CJ08F9TH', NULL, NULL, NULL, NULL, NULL, 1760000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(490, 491, 'bank_transfer', NULL, 'TXN1JBEPNHFV8UA', NULL, NULL, NULL, NULL, NULL, 1280000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(491, 492, 'bank_transfer', NULL, 'TXNAIC0E82BRC2Q', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(492, 493, 'vnpay', NULL, 'TXN3EHKCAT3H7PN', NULL, NULL, NULL, NULL, NULL, 1490000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(493, 494, 'cod', NULL, 'TXNFWE1HZOKTVVH', NULL, NULL, NULL, NULL, NULL, 1060000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(494, 495, 'vnpay', NULL, 'TXN9BHRRAYZ2UFD', NULL, NULL, NULL, NULL, NULL, 1370000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(495, 496, 'cod', NULL, 'TXN4A03Y0QVL2JL', NULL, NULL, NULL, NULL, NULL, 990000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(496, 497, 'vnpay', NULL, 'TXNYBZ1XXOIUWG7', NULL, NULL, NULL, NULL, NULL, 1960000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(497, 498, 'vnpay', NULL, 'TXNH6ZBTGTUIS8Y', NULL, NULL, NULL, NULL, NULL, 1450000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(498, 499, 'bank_transfer', NULL, 'TXNAIUHBERTPAUW', NULL, NULL, NULL, NULL, NULL, 1090000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(499, 500, 'bank_transfer', NULL, 'TXNABRAHHBXBSDA', NULL, NULL, NULL, NULL, NULL, 1630000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(500, 501, 'cod', NULL, 'TXNUZBR30AD3VGR', NULL, NULL, NULL, NULL, NULL, 1330000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(501, 502, 'cod', NULL, 'TXNR1HC5AWDDWCD', NULL, NULL, NULL, NULL, NULL, 1460000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(502, 503, 'bank_transfer', NULL, 'TXNCD691N3J6FES', NULL, NULL, NULL, NULL, NULL, 1670000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(503, 504, 'bank_transfer', NULL, 'TXNPNEP6MHODUJ0', NULL, NULL, NULL, NULL, NULL, 2130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(504, 505, 'vnpay', NULL, 'TXNUO5QZMGD9UFZ', NULL, NULL, NULL, NULL, NULL, 1170000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(505, 506, 'vnpay', NULL, 'TXNZPPYLYFUUHRD', NULL, NULL, NULL, NULL, NULL, 590000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(506, 507, 'bank_transfer', NULL, 'TXN4ZIY55MYUOKB', NULL, NULL, NULL, NULL, NULL, 1160000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(507, 508, 'cod', NULL, 'TXNXCNSXYPMVFPG', NULL, NULL, NULL, NULL, NULL, 1180000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(508, 509, 'bank_transfer', NULL, 'TXNDUH6SMEGOC5L', NULL, NULL, NULL, NULL, NULL, 1190000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(509, 510, 'bank_transfer', NULL, 'TXNPYH28OOHMGAP', NULL, NULL, NULL, NULL, NULL, 640000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(510, 511, 'bank_transfer', NULL, 'TXNC3NHKISDQDWQ', NULL, NULL, NULL, NULL, NULL, 760000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(511, 512, 'vnpay', NULL, 'TXNTDHE83KAQGAY', NULL, NULL, NULL, NULL, NULL, 910000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(512, 513, 'cod', NULL, 'TXNXWKDX2NUEPJX', NULL, NULL, NULL, NULL, NULL, 1800000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(513, 514, 'bank_transfer', NULL, 'TXNFQJZIWXF6FR5', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(514, 515, 'bank_transfer', NULL, 'TXN9KEQXEK66X9N', NULL, NULL, NULL, NULL, NULL, 1650000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(515, 516, 'cod', NULL, 'TXNEEF3FDR10MLP', NULL, NULL, NULL, NULL, NULL, 1410000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(516, 517, 'bank_transfer', NULL, 'TXNHDQ2NPYMZ21G', NULL, NULL, NULL, NULL, NULL, 1010000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(517, 518, 'vnpay', NULL, 'TXNRDJVLLFFDDGB', NULL, NULL, NULL, NULL, NULL, 1620000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(518, 519, 'vnpay', NULL, 'TXNRMDGOOBEAOQ1', NULL, NULL, NULL, NULL, NULL, 1010000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(519, 520, 'cod', NULL, 'TXNECQ9MY1F0NI7', NULL, NULL, NULL, NULL, NULL, 1060000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(520, 521, 'bank_transfer', NULL, 'TXNZKGQP5T5EM05', NULL, NULL, NULL, NULL, NULL, 1560000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(521, 522, 'bank_transfer', NULL, 'TXNJLF7RKXOWF1B', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(522, 523, 'vnpay', NULL, 'TXNTVIZULQBIRUY', NULL, NULL, NULL, NULL, NULL, 1120000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(523, 524, 'vnpay', NULL, 'TXNLRWABALEWJYD', NULL, NULL, NULL, NULL, NULL, 1080000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(524, 525, 'bank_transfer', NULL, 'TXN7JYQKEB2EB0O', NULL, NULL, NULL, NULL, NULL, 1250000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(525, 526, 'bank_transfer', NULL, 'TXNUWZCXTEEDLK4', NULL, NULL, NULL, NULL, NULL, 1690000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(526, 527, 'bank_transfer', NULL, 'TXNMQRKRYQVO0LZ', NULL, NULL, NULL, NULL, NULL, 1640000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(527, 528, 'vnpay', NULL, 'TXNREFHQSXISCON', NULL, NULL, NULL, NULL, NULL, 1410000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(528, 529, 'vnpay', NULL, 'TXNRQ5Y5BNRY33T', NULL, NULL, NULL, NULL, NULL, 1860000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(529, 530, 'cod', NULL, 'TXNJBNKQP4636DL', NULL, NULL, NULL, NULL, NULL, 1390000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(530, 531, 'bank_transfer', NULL, 'TXNPBVU4ZN3X7O5', NULL, NULL, NULL, NULL, NULL, 870000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(531, 532, 'cod', NULL, 'TXNU11IQTWBVTAA', NULL, NULL, NULL, NULL, NULL, 1160000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(532, 533, 'vnpay', NULL, 'TXN3I5EVMX2DTMT', NULL, NULL, NULL, NULL, NULL, 810000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(533, 534, 'cod', NULL, 'TXNOPCN5F72A1QL', NULL, NULL, NULL, NULL, NULL, 730000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(534, 535, 'cod', NULL, 'TXNTWKCDP8VGCKB', NULL, NULL, NULL, NULL, NULL, 1560000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(535, 536, 'bank_transfer', NULL, 'TXN6MZ15ULQBBSL', NULL, NULL, NULL, NULL, NULL, 550000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(536, 537, 'vnpay', NULL, 'TXNNVNXC9P6QKK8', NULL, NULL, NULL, NULL, NULL, 1690000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(537, 538, 'cod', NULL, 'TXNXHN9AQQAFFU6', NULL, NULL, NULL, NULL, NULL, 1080000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(538, 539, 'vnpay', NULL, 'TXN3LXH9SI7VFKF', NULL, NULL, NULL, NULL, NULL, 860000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(539, 540, 'vnpay', NULL, 'TXNWB9ZF07PFQ9B', NULL, NULL, NULL, NULL, NULL, 1590000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(540, 541, 'cod', NULL, 'TXN0VNFVYYG6IIK', NULL, NULL, NULL, NULL, NULL, 2450000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(541, 542, 'cod', NULL, 'TXNOWMZEN8W60CB', NULL, NULL, NULL, NULL, NULL, 1120000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(542, 543, 'cod', NULL, 'TXNZW29HMEMYHLG', NULL, NULL, NULL, NULL, NULL, 1470000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(543, 544, 'bank_transfer', NULL, 'TXNPIWROQSOO6TU', NULL, NULL, NULL, NULL, NULL, 1570000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(544, 545, 'vnpay', NULL, 'TXNHH3JAZAM6GQT', NULL, NULL, NULL, NULL, NULL, 1370000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(545, 546, 'bank_transfer', NULL, 'TXNMFAKFBDFY6O2', NULL, NULL, NULL, NULL, NULL, 1690000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(546, 547, 'cod', NULL, 'TXN8RGJRTULCFG3', NULL, NULL, NULL, NULL, NULL, 1210000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(547, 548, 'cod', NULL, 'TXNFFMP9SD2J3SO', NULL, NULL, NULL, NULL, NULL, 1280000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(548, 549, 'cod', NULL, 'TXNMRWRVC1GFWZO', NULL, NULL, NULL, NULL, NULL, 2130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(549, 550, 'vnpay', NULL, 'TXN3VZLRVAVQM54', NULL, NULL, NULL, NULL, NULL, 1790000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(550, 551, 'bank_transfer', NULL, 'TXNCAQOKW7LXCZG', NULL, NULL, NULL, NULL, NULL, 950000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(551, 552, 'vnpay', NULL, 'TXN3PB4Q1DJX46L', NULL, NULL, NULL, NULL, NULL, 1450000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(552, 553, 'vnpay', NULL, 'TXNIPWHMWPLSQ9H', NULL, NULL, NULL, NULL, NULL, 1470000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(553, 554, 'bank_transfer', NULL, 'TXNKCS8HBADFFAA', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(554, 555, 'vnpay', NULL, 'TXNEKLWSQLXABZ7', NULL, NULL, NULL, NULL, NULL, 1130000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(555, 556, 'cod', NULL, 'TXNCVX2LQEYNBP3', NULL, NULL, NULL, NULL, NULL, 680000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(556, 557, 'cod', NULL, 'TXNQMO60HB2ZXJZ', NULL, NULL, NULL, NULL, NULL, 1830000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(557, 558, 'cod', NULL, 'TXNKLR0NGMEZEXX', NULL, NULL, NULL, NULL, NULL, 1530000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(558, 559, 'cod', NULL, 'TXNNGTJ3NMD1KWM', NULL, NULL, NULL, NULL, NULL, 1450000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(559, 560, 'vnpay', NULL, 'TXNXAT821QKMFUP', NULL, NULL, NULL, NULL, NULL, 1650000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(560, 561, 'cod', NULL, 'TXN8REJFM3ZLLWG', NULL, NULL, NULL, NULL, NULL, 2230000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(561, 562, 'bank_transfer', NULL, 'TXNWWCKHPJ6NNQW', NULL, NULL, NULL, NULL, NULL, 1070000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(562, 563, 'vnpay', NULL, 'TXNOCQRQEL9GSSK', NULL, NULL, NULL, NULL, NULL, 940000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(563, 564, 'vnpay', NULL, 'TXNJXDEKISTTSYI', NULL, NULL, NULL, NULL, NULL, 1110000.00, 'paid', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(564, 565, 'cod', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3790000.00, 'pending', NULL, NULL, NULL, NULL, 0, NULL, '2026-10-08 13:00:18', '2026-10-08 13:00:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_refunds`
--

CREATE TABLE `payment_refunds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `request_id` varchar(64) NOT NULL,
  `refund_type` varchar(20) NOT NULL DEFAULT 'full',
  `amount` decimal(15,2) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'requested',
  `reason` text DEFAULT NULL,
  `requested_by` varchar(100) DEFAULT NULL,
  `vnp_transaction_no` varchar(64) DEFAULT NULL,
  `vnp_response_code` varchar(10) DEFAULT NULL,
  `vnp_transaction_status` varchar(10) DEFAULT NULL,
  `request_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`request_payload`)),
  `response_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response_payload`)),
  `requested_at` timestamp NULL DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_refunds`
--

INSERT INTO `payment_refunds` (`id`, `payment_id`, `order_id`, `request_id`, `refund_type`, `amount`, `status`, `reason`, `requested_by`, `vnp_transaction_no`, `vnp_response_code`, `vnp_transaction_status`, `request_payload`, `response_payload`, `requested_at`, `processed_at`, `created_at`, `updated_at`) VALUES
(1, 60, 61, 'REFH854RZKWXU', 'full', 1450000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(2, 62, 63, 'REFZELUKQ6XUO', 'full', 930000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(3, 68, 69, 'REFX5B213EWS3', 'full', 1580000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(4, 71, 72, 'REFF0GM7Q3QKY', 'full', 1820000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(5, 80, 81, 'REF0UAFVSSS4R', 'full', 760000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(6, 84, 85, 'REF1UVASZRR5G', 'full', 1120000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(7, 107, 108, 'REFZTKEGK8JJ3', 'full', 1150000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(8, 118, 119, 'REFS2BATXHZNG', 'full', 1570000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(9, 127, 128, 'REFC6TBB6FUNF', 'full', 1490000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(10, 139, 140, 'REFRSG33KBX0C', 'full', 1300000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(11, 141, 142, 'REF9U4ZWYESPJ', 'full', 1060000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(12, 164, 165, 'REFSMOAE01NBX', 'full', 1450000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(13, 169, 170, 'REFU59S1FS7JK', 'full', 1080000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(14, 178, 179, 'REFJE00YDGWTZ', 'full', 1350000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(15, 189, 190, 'REFP87EAIEOE8', 'full', 880000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(16, 206, 207, 'REFFJXITXACO8', 'full', 1550000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(17, 212, 213, 'REFAS3BEVUX0X', 'full', 1980000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(18, 233, 234, 'REFANXTUQXK10', 'full', 1590000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:23', '2026-10-07 14:09:23'),
(19, 239, 240, 'REFTS3EQ7AOHH', 'full', 940000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(20, 242, 243, 'REF6WOXFRRCUA', 'full', 620000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(21, 261, 262, 'REFLM4MSQTQFP', 'full', 1510000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(22, 262, 263, 'REFXRIJWH7NIR', 'full', 1300000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(23, 268, 269, 'REFVWX1QYG4WX', 'full', 550000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(24, 277, 278, 'REFW9NVHXOPT3', 'full', 760000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(25, 278, 279, 'REFR8E8KJIFBP', 'full', 670000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(26, 295, 296, 'REFFNYUSR8QEV', 'full', 1220000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(27, 304, 305, 'REF5HXH1642IN', 'full', 880000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(28, 314, 315, 'REF2Z3TLI1SXS', 'full', 1310000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(29, 364, 365, 'REF4BVTRPIZST', 'full', 1430000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(30, 367, 368, 'REFHFUWZMGFC4', 'full', 2270000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(31, 379, 380, 'REFGZ7SGIFPP1', 'full', 1920000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(32, 381, 382, 'REFDAWFFPMUHH', 'full', 1600000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(33, 390, 391, 'REFSE0DSVHHGO', 'full', 1490000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(34, 396, 397, 'REFW24TDV5AKL', 'full', 1710000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(35, 403, 404, 'REFGUELVNSPFU', 'full', 1250000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(36, 404, 405, 'REFS7DFF9CT3G', 'full', 1090000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(37, 419, 420, 'REFUTJXTDF5HC', 'full', 1490000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(38, 428, 429, 'REFCLQDA7W12K', 'full', 1390000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(39, 441, 442, 'REF3DWYH3GYFM', 'full', 1750000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(40, 444, 445, 'REFKO8RBIFWL9', 'full', 1690000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(41, 490, 491, 'REFW03YEHOGHZ', 'full', 1280000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(42, 491, 492, 'REFM8BHCQMNS6', 'full', 1130000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:24', '2026-10-07 14:09:24'),
(43, 498, 499, 'REFMTVSNGALMV', 'full', 1090000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(44, 510, 511, 'REFIXREN9CGN1', 'full', 760000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(45, 521, 522, 'REFQY51ULFKWV', 'full', 1130000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(46, 538, 539, 'REF0IRRJL5OXO', 'full', 860000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(47, 546, 547, 'REFSAKJYHJ32O', 'full', 1210000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25'),
(48, 558, 559, 'REFXYQ3GNV6IL', 'full', 1450000.00, 'succeeded', 'Customer cancellation test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-07 14:09:25', '2026-10-07 14:09:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `image_url` text DEFAULT NULL,
  `cover_image_url` text DEFAULT NULL,
  `cloudinary_public_id` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(32) NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `reading_time_minutes` int(11) NOT NULL DEFAULT 0,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `post_category_id`, `author_id`, `title`, `slug`, `excerpt`, `content`, `image_url`, `cover_image_url`, `cloudinary_public_id`, `is_published`, `status`, `is_featured`, `reading_time_minutes`, `seo_title`, `seo_description`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'Bí Quyết Bảo Quản Trang Sức Bạc 925 Sáng Bóng Tại Nhà', 'bi-quyet-bao-quan-trang-suc-bac-925-sang-bong-tai-nha', 'Trang sức bạc 925 bị xỉn màu là hiện tượng hóa học tự nhiên. Khám phá 5 cách làm sáng bạc đơn giản, hiệu quả ngay tại nhà mà không làm trầy xước bề mặt.', '<h2>Vì sao trang sức bạc 925 bị xuống màu?</h2>\n<p>Nhiều người lầm tưởng rằng bạc bị đen hay xỉn màu là do bạc kém chất lượng. Tuy nhiên trên thực tế, <strong>bạc nguyên chất hoặc bạc 925 chuẩn quốc tế</strong> phản ứng tự nhiên với lưu huỳnh (lưu huỳnh có trong không khí, mồ hui và các loại hóa mỹ phẩm) tạo thành kết tủa bạc sunfua màu đen bám trên bề mặt.</p>\n<blockquote>Chỉ cần biết cách chăm sóc đúng điệu, món trang sức bạc của bạn sẽ luôn giữ được vẹn nguyên ánh sáng thuần khiết như thuở ban đầu.</blockquote>\n<h2>5 Cách làm sáng bạc 925 tại nhà đơn giản và hiệu quả</h2>\n<h3>1. Dùng khăn lau bạc chuyên dụng Lunara</h3>\n<p>Mỗi đơn hàng tại Lunara Silver đều được gửi kèm khăn lau bạc chuyên dụng chứa hoạt chất làm sạch và bảo vệ bề mặt. Bạn chỉ cần lau nhẹ nhàng trực tiếp lên bề mặt trang sức, vết xỉn màu sẽ nhanh chóng biến mất mà không gây trầy xước.</p>\n<h3>2. Sử dụng dung dịch baking soda và muối ấm</h3>\n<ul>\n<li>Chuẩn bị một bát nước ấm có lót một lớp giấy bạc (aluminum foil).</li>\n<li>Cho vào 1 thìa baking soda và 1 thìa muối tinh.</li>\n<li>Ngâm trang sức bạc trong khoảng 5-10 phút để phản ứng điện hóa loại bỏ lớp sunfua đen.</li>\n<li>Rửa lại bằng nước sạch và lau khô bằng khăn mềm.</li>\n</ul>\n<h3>3. Bảo quản trong hộp kín hoặc túi zip</h3>\n<p>Khi không sử dụng, hãy cất giữ trang sức trong hộp đựng Lunara có lót nhung êm ái hoặc túi zip kín gió. Tránh để trang sức tiếp xúc trực tiếp với không khí ẩm ướt hoặc ánh nắng mặt trời gắt gao.</p>', 'media/banner.jpg', 'media/banner.jpg', NULL, 1, 'published', 1, 4, 'Bí Quyết Bảo Quản Trang Sức Bạc 925 Sáng Bóng Tại Nhà | Lunara', 'Mẹo làm sáng trang sức bạc 925 tại nhà đơn giản, hiệu quả với baking soda và khăn lau bạc chuyên dụng. Giữ trang sức Lunara luôn rực rỡ.', '2026-09-27 13:55:24', '2026-09-30 13:43:47', '2026-09-30 13:55:24'),
(2, 2, 4, 'Nghệ Thuật Phối Lớp (Layering) Dây Chuyền Bạc Chuẩn Quiet Luxury', 'nghe-thuat-phoi-lop-layering-day-chuyen-bac-chuan-quiet-luxury', 'Cách xếp lớp nhiều sợi dây chuyền bạc thanh mảnh tạo điểm nhấn sang trọng cho phần xương quai xanh mà không hề rối mắt hay nặng nề.', '<h2>Quy tắc độ dài so le (Graduated Lengths)</h2>\n<p>Nguyên tắc vàng đầu tiên khi phối nhiều sợi dây chuyền là lựa chọn các độ dài khác nhau. Một combo phối lớp hoàn hảo thường bao gồm 2 đến 3 sợi:</p>\n<ul>\n<li><strong>Sợi ngắn nhất (38 - 40cm):</strong> Dây chuyền choker thanh mảnh ôm sát chân cổ hoặc sợi xích mảnh tối giản.</li>\n<li><strong>Sợi trung tâm (42 - 45cm):</strong> Dây chuyền có mặt điểm xuyết như mặt trăng khuyết Lunara Crescent Moon hoặc viên đá zircon sáng lấp lánh.</li>\n<li><strong>Sợi dài nhất (50 - 55cm):</strong> Mặt dây chuyền hình giọt nước hoặc biểu tượng ngôi sao thả dài nhẹ nhàng.</li>\n</ul>\n<blockquote>Sự tinh tế của phong cách Quiet Luxury không nằm ở kích thước phô trương, mà nằm ở độ tỉ mỉ trong từng đường nét cắt gọt và sự hài hòa giữa các tầng lớp.</blockquote>\n<h2>Kết hợp các kết cấu sợi dây (Textural Contrast)</h2>\n<p>Đừng ngần ngại kết hợp sợi dây chuyền trơn bóng (Snake Chain) cùng sợi mắt xích mảnh (Cable Chain). Sự tương phản nhẹ nhàng về mặt xúc giác tạo nên chiều sâu cuốn hút mà vẫn giữ trọn vẻ đẹp thanh lịch vượt thời gian.</p>', 'media/banner2.jpg', 'media/banner2.jpg', NULL, 1, 'published', 0, 3, 'Nghệ Thuật Phối Lớp Dây Chuyền Bạc Chuẩn Quiet Luxury | Lunara', 'Hướng dẫn phối lớp (layering) dây chuyền bạc 925 thanh lịch, tinh tế tôn vinh vẻ đẹp kiêu sa và thanh lịch của phái nữ.', '2026-09-28 13:55:24', '2026-09-30 13:43:47', '2026-10-06 13:40:58'),
(3, 3, 4, 'Ý Nghĩa Biểu Tượng Mặt Trăng Và Vì Sao Trong Trang Sức Lunara', 'y-nghia-bieu-tuong-mat-trang-va-vi-sao-trong-trang-suc-lunara', 'Mặt trăng biểu trưng cho sự dịu dàng và tái sinh, trong khi vì sao mang đến hy vọng và định hướng. Lắng nghe câu chuyện đằng sau từng thiết kế Lunara.', '<h2>Mặt trăng — Biểu tượng của vẻ đẹp nội tâm và sự chữa lành</h2>\n<p>Từ thời cổ đại, mặt trăng đã luôn gắn liền với tính nữ, trực giác và chu kỳ tái sinh dịu dàng của tự nhiên. Dưới ánh trăng, mọi ồn ào của ban ngày dường như nhường chỗ cho sự tĩnh lặng và an yên.</p>\n<p>Tại Lunara Silver, mỗi tạo tác trang sức bạc mang hình tượng trăng khuyết (Crescent Moon) đều gửi gắm thông điệp:</p>\n<blockquote>\"Bạn không cần phải luôn rực rỡ và tròn đầy như trăng rằm mới được xem là hoàn hảo. Ở bất kỳ giai đoạn nào của cuộc đời, bạn đều sở hữu một nét đẹp độc bản và xứng đáng được trân quý.\"</blockquote>\n<h2>Ngôi sao Bắc Đẩu — Ánh sáng dẫn lối niềm hy vọng</h2>\n<p>Đồng hành cùng ánh trăng là những vì tinh tú lấp lánh giữa màn đêm. Biểu tượng ngôi sao 4 cánh và 8 cánh đính đá Zirconia cao cấp tượng trưng cho niềm hy vọng kiên định và ngọn hải đăng soi sáng con đường bạn lựa chọn bước đi.</p>', 'media/banner3.jpg', 'media/banner3.jpg', NULL, 1, 'published', 0, 3, 'Ý Nghĩa Biểu Tượng Mặt Trăng Và Vì Sao | Lunara Silver', 'Khám phá ý nghĩa phong thủy và tinh thần của trang sức mặt trăng và vì sao bạc 925 tại Lunara Silver.', '2026-09-29 13:55:24', '2026-09-30 13:43:47', '2026-10-06 13:40:58'),
(4, 2, 4, 'Bản Nháp: Xu Hướng Trang Sức Tối Giản Mùa Thu Đông 2026', 'ban-nhap-xu-huong-trang-suc-toi-gian-mua-thu-dong-2026', 'Bài viết bản nháp đang trong quá trình biên tập nội dung, chỉ quản trị viên có quyền xem trước trên giao diện.', '<p>Đây là bài viết bản nháp kiểm tra tính năng bảo mật phân quyền. Chỉ quản trị viên mới có thể xem trước bài viết này tại storefront.</p>', 'media/Collection/set 1(1).jpg.png', 'media/Collection/set 1(1).jpg.png', NULL, 0, 'draft', 0, 1, NULL, NULL, NULL, '2026-09-30 13:43:47', '2026-09-30 13:55:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_categories`
--

CREATE TABLE `post_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `post_categories`
--

INSERT INTO `post_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Bảo quản bạc 925', 'bao-quan-bac-925', 'Mẹo vệ sinh, chăm sóc và giữ trang sức bạc 925 luôn sáng bóng tinh khiết như mới.', 1, 1, '2026-09-30 13:43:47', '2026-09-30 13:43:47'),
(2, 'Bộ sưu tập & Phong cách', 'bo-suu-tap-phong-cach', 'Khám phá cảm hứng sáng tạo, xu hướng trang sức Quiet Luxury và bí quyết phối đồ sang trọng.', 2, 1, '2026-09-30 13:43:47', '2026-09-30 13:43:47'),
(3, 'Cẩm nang trang sức', 'cam-nang-trang-suc', 'Kiến thức chọn size nhẫn, ý nghĩa biểu tượng mặt trăng tinh tú và câu chuyện kim hoàn.', 3, 1, '2026-09-30 13:43:47', '2026-09-30 13:43:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `product_type` varchar(20) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `regular_price` decimal(15,2) NOT NULL,
  `sale_price` decimal(15,2) DEFAULT NULL,
  `stock_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `stock_status` varchar(20) NOT NULL DEFAULT 'out_of_stock',
  `material` varchar(255) DEFAULT NULL,
  `stone` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `size_info` text DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sold_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `view_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `sku`, `name`, `slug`, `product_type`, `short_description`, `description`, `regular_price`, `sale_price`, `stock_quantity`, `stock_status`, `material`, `stone`, `weight`, `size_info`, `is_featured`, `is_active`, `sold_count`, `view_count`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'LNS-DC001', 'Dây chuyền Lunara Thái Dương Lam', 'day-chuyen-lunara-thai-duong-lam', 'single', 'Mặt trời và đá lam mạnh mẽ, chữa lành', 'Tên gọi thể hiện sự kết hợp giữa mặt trời tỏa sáng rực rỡ và viên đá xanh lam (lam) làm tâm điểm, mang lại vẻ đẹp mạnh mẽ nhưng cũng đầy sự chữa lành của đại dương và bầu trời.', 450000.00, 390000.00, 17, 'in_stock', 'Bạc 925 đính đá Sapphire xanh', 'Sapphire xanh', '3.2g', '45cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-10-08 13:00:18', NULL),
(2, 1, 'LNS-DC002', 'Dây chuyền Lunara Tinh Tú Hoàn', 'day-chuyen-lunara-tinh-tu-hoan', 'single', 'Vòng tròn đá nạm hoàn hảo, vĩnh cửu', 'Một vòng tròn nạm đá kim cương hoàn hảo, tượng trưng cho một vòng tuần hoàn vĩnh cửu của các vì tinh tú trên bầu trời, tinh tế và không bao giờ kết thúc.', 400000.00, 350000.00, 25, 'in_stock', 'Bạc 925 đính đá kim cương nhân tạo (CZ)', 'CZ (mô phỏng kim cương)', '2.6g', '42cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(3, 1, 'LNS-DC003', 'Dây chuyền Lunara Ái Tinh Hồn', 'day-chuyen-lunara-ai-tinh-hon', 'single', 'Trái tim đính đá Moissanite rực rỡ', 'Kết hợp hình ảnh trái tim nạm đá lấp lánh với viên đá moissanite lớn ở trung tâm, tượng trưng cho tâm hồn tinh khiết và tình yêu cháy bỏng, rực rỡ như một ngôi sao.', 420000.00, 370000.00, 17, 'in_stock', 'Bạc 925 đính đá Moissanite', 'Moissanite', '3.0g', '44cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-10-08 13:00:18', NULL),
(4, 1, 'LNS-DC004', 'Dây chuyền Lunara Tinh Quang Chuyển Động', 'day-chuyen-lunara-tinh-quang-chuyen-dong', 'single', 'Xoắn ốc ánh sáng quanh đá trung tâm', 'Tên gọi gợi tả sự xoắn ốc (swirl) nạm đá bao quanh viên đá moissanite trung tâm, như một dòng chảy ánh sáng (tinh quang) đang không ngừng chuyển động và tỏa sáng.', 520000.00, 450000.00, 14, 'in_stock', 'Bạc 925 đính đá Moissanite', 'Moissanite', '3.5g', '45cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 08:16:03', NULL),
(5, 1, 'LNS-DC005', 'Dây chuyền Lunara Thiên Vũ Chòm Sao', 'day-chuyen-lunara-thien-vu-chom-sao', 'single', 'Vũ trụ thu nhỏ với nhiều charm sao', 'Một thiết kế phức tạp với nhiều charm sao, hành tinh và viên đá pha lê màu xanh, tượng trưng cho cả một vũ trụ thu nhỏ, một thiên hà rực rỡ với các chòm sao kỳ vĩ ngự trị trên ngực người đeo.', 480000.00, 420000.00, 18, 'in_stock', 'Bạc 925 đính pha lê xanh', 'Pha lê xanh', '3.8g', '46cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(6, 1, 'LNS-DC006', 'Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh', 'day-chuyen-lunara-phan-ngoi-sao-lap-lanh', 'single', 'Đá hồng phấn giữa ngôi sao lấp lánh', 'Nổi bật với viên đá moissanite màu hồng phấn ở tâm của một ngôi sao lấp lánh phức tạp, mang lại vẻ đẹp mềm mại, nữ tính và lãng mạn nhất.', 530000.00, 460000.00, 14, 'in_stock', 'Bạc 925 đính đá Moissanite hồng phấn', 'Moissanite hồng', '3.4g', '44cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(7, 1, 'LNS-DC007', 'Dây chuyền Lunara Hạo Nguyệt Ôm Hừng', 'day-chuyen-lunara-hao-nguyet-om-hung', 'single', 'Trăng khuyết ôm lấy ánh sáng hừng đông', '\"Mặt trăng ôm lấy ánh sáng hừng đông\". Thiết kế vầng trăng khuyết nạm đá ôm lấy một viên đá moissanite cabochon lớn màu trắng mờ, gợi nhớ đến ánh trăng dịu dàng và tinh khiết như sương.', 460000.00, 400000.00, 20, 'in_stock', 'Bạc 925 đính đá Moissanite cabochon', 'Moissanite trắng mờ', '2.9g', '43cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(8, 1, 'LNS-DC008', 'Dây chuyền Lunara Băng Tinh Nguyệt Khuyết', 'day-chuyen-lunara-bang-tinh-nguyet-khuyet', 'single', 'Trăng khuyết với tinh thể đá trong như băng', 'Vầng trăng khuyết nạm đá với một cụm đá nhỏ ở một góc, tượng trưng cho một vầng trăng được hình thành từ các tinh thể đá moissanite trong suốt và sắc sảo như băng.', 440000.00, 380000.00, 23, 'in_stock', 'Bạc 925 đính đá Moissanite', 'Moissanite', '2.7g', '42cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 08:54:09', NULL),
(9, 1, 'LNS-DC009', 'Dây chuyền Lunara Thanh Nguyệt Sao Tinh', 'day-chuyen-lunara-thanh-nguyet-sao-tinh', 'single', 'Trăng khuyết trơn cùng ngôi sao nạm đá', '\"Mặt trăng trơn và các ngôi sao đôi\". Thiết kế mặt trăng khuyết trơn đánh bóng với một ngôi sao nhỏ nạm đá treo trong lòng, thể hiện nét đẹp cổ điển, thanh lịch và thanh khiết.', 540000.00, 470000.00, 11, 'in_stock', 'Bạc 925 đánh bóng, đính đá nhỏ', 'Đá nhỏ (CZ)', '3.6g', '45cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 08:54:09', NULL),
(10, 1, 'LNS-DC010', 'Dây chuyền Lunara Lưu Tinh Tuyến Cong', 'day-chuyen-lunara-luu-tinh-tuyen-cong', 'single', 'Dải sao chổi cong lấp lánh đá và sao', 'Một cụm gồm nhiều viên đá moissanite và ngôi sao xếp thành một dải cong tinh xảo, tựa như một dải sao chổi hoặc dải thiên hà (lưu tinh tuyến) đang chuyển động trên bầu trời đêm.', 490000.00, 430000.00, 17, 'in_stock', 'Bạc 925 đính đá Moissanite', 'Moissanite', '3.3g', '44cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(11, 2, 'LNS-NH001', 'Nhẫn Lunara Nguyệt Tinh', 'nhan-lunara-nguyet-tinh', 'single', 'Trăng khuyết và vì sao trơn tinh tế', 'Sự kết hợp nguyên bản và tinh tế nhất giữa trăng khuyết và một vì sao. Thiết kế trơn đơn giản mang vẻ đẹp thanh lịch, nguyên sơ của bầu trời đêm.', 290000.00, 250000.00, 35, 'in_stock', 'Bạc 925', '-', '1.8g', '6-9 (điều chỉnh được)', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(12, 2, 'LNS-NH002', 'Nhẫn Lunara Song Tinh', 'nhan-lunara-song-tinh', 'single', 'Nhẫn hở hai ngôi sao gắn kết', 'Thiết kế nhẫn hở với hai ngôi sao (một đính đá lấp lánh, một tinh giản rỗng ruột) tượng trưng cho sự gắn kết, đồng hành tỏa sáng.', 400000.00, 350000.00, 20, 'in_stock', 'Bạc 925 (một bên đính đá)', 'CZ nhỏ (1 bên)', '2.2g', '6-9', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(13, 2, 'LNS-NH003', 'Nhẫn Lunara Lam Dạ', 'nhan-lunara-lam-da', 'single', 'Đá Sapphire xanh thẳm bí ẩn quyến rũ', '\"Đêm xanh mờ ảo\". Điểm nhấn viên đá sapphire xanh thẳm đặt trong lòng vì sao, e ấp bên mặt trăng nạm đá lấp lánh, mang lại vẻ đẹp bí ẩn và quyến rũ.', 300000.00, 260000.00, 30, 'in_stock', 'Bạc 925 đính đá Sapphire xanh', 'Sapphire xanh', '1.9g', '6-9', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(14, 2, 'LNS-NH004', 'Nhẫn Lunara Vũ Trụ', 'nhan-lunara-vu-tru', 'single', 'Dải sáng quanh đá như hành tinh thu nhỏ', 'Thiết kế có họa tiết dải sáng bao quanh viên đá (giống như sao Thổ/hành tinh) cùng các vì sao nhỏ, tượng trưng cho một vũ trụ thu nhỏ ngự trị trên ngón tay người đeo.', 310000.00, 270000.00, 28, 'in_stock', 'Bạc 925 đính đá + charm sao nhỏ', 'CZ', '1.7g', '6-9', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(15, 2, 'LNS-NH005', 'Nhẫn Lunara Tinh Thủy', 'nhan-lunara-tinh-thuy', 'single', 'Đá ngọc bích trong trẻo cùng vì sao', 'Sự kết hợp giữa viên đá màu xanh ngọc bích trong trẻo như giọt nước (thủy) và các vì sao (tinh). Cảm giác mang lại sự chữa lành, thanh khiết và rạng rỡ.', 320000.00, 280000.00, 24, 'in_stock', 'Bạc 925 đính đá Ngọc bích (Jade)', 'Ngọc bích xanh', '2.0g', '6-9', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 21:21:15', NULL),
(16, 2, 'LNS-NH006', 'Nhẫn Lunara Quỹ Đạo', 'nhan-lunara-quy-dao', 'single', 'Đai kép vắt chéo như quỹ đạo sao', 'Thiết kế nhẫn đai kép vắt chéo nhau tựa như quỹ đạo của các vì sao xoay quanh mặt trăng, thể hiện một nét đẹp hiện đại và độc đáo.', 280000.00, 240000.00, 32, 'in_stock', 'Bạc 925', '-', '2.1g', 'Free size', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(17, 2, 'LNS-NH007', 'Nhẫn Lunara Bạch Nguyệt', 'nhan-lunara-bach-nguyet', 'single', 'Đá cabochon tròn như trăng rằm dịu dàng', '\"Mặt trăng trắng\". Điểm nhấn là viên đá to bản bo tròn (cabochon) gợi nhớ đến vầng trăng rằm tỏa sáng dịu dàng, được che chở bởi vầng trăng khuyết phía trên.', 370000.00, 320000.00, 11, 'in_stock', 'Bạc 925 đính đá cabochon', 'Đá trắng (cabochon)', '1.6g', '6-9', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-10-08 13:00:18', NULL),
(18, 2, 'LNS-NH008', 'Nhẫn Lunara Dạ Khúc', 'nhan-lunara-da-khuc', 'single', 'Trăng khuyết to bản nạm 3 đá nhỏ', 'Khúc hát của đêm. Vầng trăng khuyết to bản được nạm thêm 3 viên đá nhỏ, đi kèm ngôi sao lấp lánh tạo nên sự mềm mại, sắc sảo nhưng không kém phần thơ mộng.', 270000.00, 230000.00, 33, 'in_stock', 'Bạc 925 đính 3 đá nhỏ + sao', 'CZ nhỏ', '1.5g', '6-9', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(19, 2, 'LNS-NH009', 'Nhẫn Lunara Ngân Hà', 'nhan-lunara-ngan-ha', 'single', 'Nhẫn đính dải ngôi sao lấp lánh như ngân hà', 'Chiếc nhẫn đính hàng loạt ngôi sao lớn nhỏ lấp lánh dọc thân, tựa như bạn đang mang trọn một dải ngân hà rực rỡ trên tay.', 330000.00, 290000.00, 26, 'in_stock', 'Bạc 925 đính nhiều đá nhỏ (dải ngôi sao)', 'CZ nhỏ (dải sao)', '2.0g', '6-9 (điều chỉnh được)', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(20, 2, 'LNS-NH010', 'Nhẫn Lunara Bắc Đẩu', 'nhan-lunara-bac-dau', 'single', 'Ngôi sao 8 cánh dẫn đường, kiên định', 'Ngôi sao 8 cánh mang hình dáng của la bàn hay sao Bắc Đẩu - ngôi sao sáng nhất và có nhiệm vụ dẫn đường. Mang thông điệp về sự kiên định và ánh sáng rực rỡ nhất của người đeo.', 340000.00, 300000.00, 23, 'in_stock', 'Bạc 925', '-', '2.0g', '6-9', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 08:54:09', NULL),
(21, 3, 'LNS-VT001', 'Vòng Lunara Nguyệt Hồng', 'vong-lunara-nguyet-hong', 'single', 'Đá hồng cabochon trong lòng trăng khuyết', 'Nổi bật với viên đá hồng cabochon trong lòng vầng trăng khuyết, tượng trưng cho ánh trăng hồng dịu dàng và tình yêu nồng thắm.', 390000.00, 340000.00, 22, 'in_stock', 'Bạc 925 đính đá cabochon hồng', 'Đá hồng (cabochon)', '3.8g', '17cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(22, 3, 'LNS-VT002', 'Vòng Lunara Hành Tinh', 'vong-lunara-hanh-tinh', 'single', 'Hình ảnh hành tinh có vành đai bao quanh', 'Chiếc vòng mang hình ảnh một hành tinh chi tiết với vành đai bao quanh (như Sao Thổ), được bao quanh bởi nhiều ngôi sao nhỏ, tượng trưng cho vẻ đẹp bí ẩn và bao la của vũ trụ.', 350000.00, 300000.00, 26, 'in_stock', 'Bạc 925 đính đá, charm hành tinh', 'CZ nhỏ', '4.0g', '16-18cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(23, 3, 'LNS-VT003', 'Vòng Lunara Song Nguyệt', 'vong-lunara-song-nguyet', 'single', 'Charm trăng khuyết và sao đan xen', '\"Hai Mặt Trăng\". Thiết kế vòng với nhiều charm hình trăng khuyết và sao đan xen dọc theo chuỗi, thể hiện sự lặp lại và kết nối của các chu kỳ thiên thể.', 410000.00, 360000.00, 19, 'in_stock', 'Bạc 925 nhiều charm trăng khuyết & sao', '-', '4.2g', '17cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(24, 3, 'LNS-VT004', 'Vòng Lunara Tinh Tú', 'vong-lunara-tinh-tu', 'single', 'Một ngôi sao lớn làm tâm điểm', 'Tập trung vào một ngôi sao lớn, sắc nét làm tâm điểm, tỏa sáng rực rỡ và duy nhất, giống như ngôi sao dẫn đường Bắc Đẩu.', 330000.00, 280000.00, 24, 'in_stock', 'Bạc 925 đính đá charm sao lớn', 'CZ', '3.5g', '16-18cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(25, 3, 'LNS-VT005', 'Vòng Lunara Nhật Nguyệt', 'vong-lunara-nhat-nguyet', 'single', 'Đủ charm mặt trời, sao chổi, trăng khuyết', '\"Mặt Trời và Mặt Trăng\". Chiếc vòng tuyệt đẹp tập hợp đầy đủ các charm: Mặt Trời tỏa sáng, một viên đá trong suốt (như Sao chổi), ngôi sao, và vầng trăng khuyết nhỏ, biểu thị sự hài hòa của trời đất.', 400000.00, 350000.00, 21, 'in_stock', 'Bạc 925 nhiều charm (mặt trời/sao/trăng)', 'Đá trong suốt (CZ)', '4.1g', '17cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(26, 3, 'LNS-VT006', 'Vòng Lunara Nguyệt Lam', 'vong-lunara-nguyet-lam', 'single', 'Đá cabochon xanh lam trong trăng khuyết', '\"Mặt Trăng Xanh\". Điểm nhấn là viên đá cabochon màu xanh lam độc đáo trong lòng trăng khuyết nạm đá, gợi cảm giác về một đêm trăng xanh hiếm có và huyền ảo.', 420000.00, 370000.00, 16, 'in_stock', 'Bạc 925 đính đá cabochon xanh lam', 'Đá xanh lam (cabochon)', '4.8g', '16-18cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(27, 3, 'LNS-VT007', 'Vòng Lunara Thiên Hà', 'vong-lunara-thien-ha', 'single', 'Chuỗi hạt bạc đan xen charm sao trăng', '\"Con đường Thiên hà\". Thiết kế vòng với chuỗi hạt bạc rải rác đan xen các charm sao và trăng nhỏ, tựa như một con đường lấp lánh băng qua các vì sao.', 360000.00, 310000.00, 19, 'in_stock', 'Bạc 925 chuỗi hạt + charm sao trăng', '-', '3.6g', '17cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-10-08 13:00:18', NULL),
(28, 3, 'LNS-VT008', 'Vòng Lunara Đa Tinh', 'vong-lunara-da-tinh', 'single', 'Hàng loạt charm sao với đá trung tâm', '\"Nhiều Ngôi Sao\". Vòng có hàng loạt các charm sao lấp lánh (với một viên đá trung tâm lớn hơn) dọc theo chuỗi, tượng trưng cho một bầu trời đêm dày đặc sao.', 340000.00, 290000.00, 27, 'in_stock', 'Bạc 925 nhiều charm sao đính đá', 'CZ', '3.9g', '16-18cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(29, 3, 'LNS-VT009', 'Vòng Lunara Thiên Đàng', 'vong-lunara-thien-dang', 'single', 'Charm trăng khuyết và sao lộng lẫy', '\"Cung điện Thiên đàng\". Chiếc vòng với các charm vầng trăng khuyết và sao lấp lánh (nạm đá) được sắp xếp vui tươi và lộng lẫy, tựa như các vì tinh tú nơi thiên đường.', 460000.00, 400000.00, 13, 'in_stock', 'Bạc 925 nhiều charm nạm đá', 'CZ nhỏ', '5.0g', '17cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 08:54:09', NULL),
(30, 3, 'LNS-VT010', 'Vòng Lunara Thiên Cơ', 'vong-lunara-thien-co', 'single', 'Charm hành tinh cơ khí cùng vành đai và sao', '\"Kỳ quan Thiên thể\". Charm trung tâm phức tạp, kết hợp một viên đá cabochon lớn làm hành tinh với các vành đai và ngôi sao xung quanh, như một kỳ quan cơ khí của vũ trụ.', 440000.00, 380000.00, 16, 'in_stock', 'Bạc 925 đính đá cabochon lớn + charm', 'Đá cabochon lớn', '4.6g', '16-18cm', 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(31, 4, 'LNS-SET001', 'Bản Giao Hưởng Vũ Trụ', 'ban-giao-huong-vu-tru', 'collection', 'LNS-DC005 (Thiên Vũ Chòm Sao); LNS-NH004 (Vũ Trụ); LNS-VT002 (Hành Tinh)', 'Chủ đề: Vũ Trụ Vô Tận', 840000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(32, 4, 'LNS-SET002', 'Ánh Trăng Tinh Khôi', 'anh-trang-tinh-khoi', 'collection', 'LNS-DC007 (Hạo Nguyệt Ôm Hừng); LNS-NH007 (Bạch Nguyệt Cabochon); LNS-VT003 (Song Nguyệt)', 'Chủ đề: Dịu Dàng Đá Trắng Moonstone', 920000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(33, 4, 'LNS-SET003', 'Giọt Ngân Hà', 'giot-ngan-ha', 'collection', 'LNS-DC008 (Băng Tinh Nguyệt Khuyết); LNS-NH005 (Tinh Thủy); LNS-VT010 (Thiên Cơ)', 'Chủ đề: Xanh Ngọc Bích & Cabochon', 880000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(34, 4, 'LNS-SET004', 'Lam Dạ Bí Ẩn', 'lam-da-bi-an', 'collection', 'LNS-DC001 (Thái Dương Lam); LNS-NH003 (Lam Dạ); LNS-VT006 (Nguyệt Lam)', 'Chủ đề: Sang Trọng Sapphire', 870000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(35, 4, 'LNS-SET005', 'Giấc Mơ Hồng', 'giac-mo-hong', 'collection', 'LNS-DC006 (Phấn Ngôi Sao); LNS-NH002 (Song Tinh Bạc); LNS-VT001 (Nguyệt Hồng)', 'Chủ đề: Ngọt Ngào Đá Hồng Phấn', 980000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(36, 4, 'LNS-SET006', 'Bắc Đẩu Tỏa Sáng', 'bac-dau-toa-sang', 'collection', 'LNS-DC010 (Lưu Tinh Tuyến Cong); LNS-NH010 (Bắc Đẩu); LNS-VT004 (Tinh Tú)', 'Chủ đề: Sức Mạnh Ngôi Sao', 860000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(37, 4, 'LNS-SET007', 'Nguyên Bản Cổ Điển', 'nguyen-ban-co-dien', 'collection', 'LNS-DC009 (Thanh Nguyệt Sao Tinh); LNS-NH001 (Nguyệt Tinh Bạc Trơn); LNS-VT009 (Thiên Đàng)', 'Chủ đề: Thiên Đàng Đa Dạng', 950000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(38, 4, 'LNS-SET008', 'Nhật Nguyệt Giao Hòa', 'nhat-nguyet-giao-hoa', 'collection', 'LNS-DC004 (Tinh Quang Chuyển Động); LNS-NH006 (Quỹ Đạo); LNS-VT005 (Nhật Nguyệt)', 'Chủ đề: Hài Hòa Trời Đất', 880000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(39, 4, 'LNS-SET009', 'Dải Tinh Không', 'dai-tinh-khong', 'collection', 'LNS-DC002 (Tinh Tú Hoàn); LNS-NH008 (Dạ Khúc bản to); LNS-VT008 (Đa Tinh)', 'Chủ đề: Lộng Lẫy Moissanite', 740000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(40, 4, 'LNS-SET010', 'Khúc Tình Ca Bầu Trời', 'khuc-tinh-ca-bau-troi', 'collection', 'LNS-DC003 (Ái Tinh Hồn); LNS-NH007 (Bạch Nguyệt); LNS-VT007 (Thiên Hà Trơn)', 'Chủ đề: Tình Yêu & Moonstone', 850000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(41, 5, 'LNS-GIFT001', 'Lunara Gift Box – Dịu Dàng', 'lunara-gift-box-diu-dang', 'gift', 'LNS-DC001 (Thái Dương Lam); LNS-NH005 (Tinh Thủy)', 'Giá đã gồm chiết khấu ~10% + hộp quà, túi vải, thiệp chúc tặng kèm', 600000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(42, 5, 'LNS-GIFT002', 'Lunara Gift Box – Tỏa Sáng', 'lunara-gift-box-toa-sang', 'gift', 'LNS-VT007 (Thiên Hà); LNS-NH002 (Song Tinh)', 'Giá đã gồm chiết khấu ~10% + hộp quà cao cấp', 590000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(43, 5, 'LNS-GIFT003', 'Lunara Gift Box – Trọn Vẹn Yêu Thương', 'lunara-gift-box-tron-ven-yeu-thuong', 'gift', 'LNS-DC009 (Thanh Nguyệt Sao Tinh); LNS-VT009 (Thiên Đàng); LNS-NH010 (Bắc Đẩu)', 'Set quà tặng cao cấp nhất — giá đã gồm chiết khấu ~10%', 1050000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(44, 5, 'LNS-GIFT004', 'Lunara Gift Box – Sinh Nhật Lấp Lánh', 'lunara-gift-box-sinh-nhat-lap-lanh', 'gift', 'LNS-DC008 (Băng Tinh Nguyệt Khuyết) + charm mini (không bán lẻ) + nến thơm mini (không bán lẻ)', 'Giá thấp hơn giá lẻ dây chuyền gốc dù tặng kèm charm mini + nến thơm', 340000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03', NULL),
(45, 5, 'LNS-GIFT005', 'Lunara Gift Box – Đôi Ta', 'lunara-gift-box-doi-ta', 'gift', '2 × LNS-NH001 (Nhẫn Nguyệt Tinh) — mỗi người 1 chiếc, thiết kế trơn tối giản phù hợp làm nhẫn đôi', 'Giá đã gồm chiết khấu ~10% + hộp đôi thiết kế riêng', 450000.00, NULL, 0, 'out_of_stock', NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '2026-09-20 02:51:03', '2026-09-22 06:38:57', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `cloudinary_public_id` varchar(255) DEFAULT NULL,
  `image_url` text NOT NULL,
  `image_role` varchar(20) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `alt_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `cloudinary_public_id`, `image_url`, `image_role`, `sort_order`, `alt_text`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'media/Product/dc001.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(2, 2, NULL, 'media/Product/dc002.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(3, 3, NULL, 'media/Product/dc003.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(4, 4, NULL, 'media/Product/dc004.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(5, 5, NULL, 'media/Product/dc005.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(6, 6, NULL, 'media/Product/dc006.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(7, 7, NULL, 'media/Product/dc007.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(8, 8, NULL, 'media/Product/dc008.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(9, 9, NULL, 'media/Product/dc009.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(10, 10, NULL, 'media/Product/dc0010.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(11, 11, NULL, 'media/Product/nh001.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(12, 12, NULL, 'media/Product/nh002.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(13, 13, NULL, 'media/Product/nh003.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(14, 14, NULL, 'media/Product/nh004.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(15, 15, NULL, 'media/Product/nh005.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(16, 16, NULL, 'media/Product/nh006.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(17, 17, NULL, 'media/Product/nh007.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(18, 18, NULL, 'media/Product/nh008.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(19, 19, NULL, 'media/Product/nh009.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(20, 20, NULL, 'media/Product/nh0010.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(21, 21, NULL, 'media/Product/vt001.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(22, 22, NULL, 'media/Product/vt002.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(23, 23, NULL, 'media/Product/vt003.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(24, 24, NULL, 'media/Product/vt004.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(25, 25, NULL, 'media/Product/vt005.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(26, 26, NULL, 'media/Product/vt006.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(27, 27, NULL, 'media/Product/vt007.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(28, 28, NULL, 'media/Product/vt008.jpg', 'primary', 0, NULL, '2026-09-20 02:51:03', '2026-09-20 02:51:03'),
(29, 29, NULL, 'media/Product/vt009.jpg', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(30, 30, NULL, 'media/Product/vt0010.jpg', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(31, 31, NULL, 'media/Collection/set 1(1).jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(32, 31, NULL, 'media/Collection/set 1(2).png', 'hover', 1, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(33, 32, NULL, 'media/Collection/set 2(1).jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(34, 32, NULL, 'media/Collection/set 2(2).jpg.png', 'hover', 1, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(35, 33, NULL, 'media/Collection/set 3(1).jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(36, 33, NULL, 'media/Collection/set 3(2).jpg.png', 'hover', 1, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(37, 34, NULL, 'media/Collection/set 4(1).jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(38, 34, NULL, 'media/Collection/set 4(2).jpg.png', 'hover', 1, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(39, 35, NULL, 'media/Collection/set 5(1).jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(40, 35, NULL, 'media/Collection/set 5(2).jpg.png', 'hover', 1, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(41, 36, NULL, 'media/Collection/set 6(2).jpg.png', 'hover', 1, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(42, 37, NULL, 'media/Collection/set 7(1).jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(43, 37, NULL, 'media/Collection/set 7(2).jpg.png', 'hover', 1, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(44, 38, NULL, 'media/Collection/set 8(1).jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(45, 38, NULL, 'media/Collection/set 8(2).jpg.png', 'hover', 1, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(46, 39, NULL, 'media/Collection/set 9(1).jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(47, 39, NULL, 'media/Collection/set 9(2).jpg.png', 'hover', 1, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(48, 40, NULL, 'media/Collection/set 10(1).jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(49, 40, NULL, 'media/Collection/set 10(2).jpg.png', 'hover', 1, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(50, 41, NULL, 'media/Gift/set qua 1.jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(51, 42, NULL, 'media/Gift/set qua 2.jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(52, 43, NULL, 'media/Gift/set qua 3.jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(53, 44, NULL, 'media/Gift/set qua 4.jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(54, 45, NULL, 'media/Gift/set qua 5.jpg.png', 'primary', 0, NULL, '2026-09-20 02:51:04', '2026-09-20 02:51:04'),
(55, 36, NULL, 'media/Collection/set 6(1).jpg.png', 'primary', 0, NULL, '2026-09-20 02:53:55', '2026-09-20 02:53:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(120) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `verified_purchase` tinyint(1) NOT NULL DEFAULT 0,
  `admin_reply` text DEFAULT NULL,
  `admin_replied_at` timestamp NULL DEFAULT NULL,
  `admin_replied_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review_media`
--

CREATE TABLE `review_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `public_id` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `sort_order` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seo_redirects`
--

CREATE TABLE `seo_redirects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `old_path` varchar(500) NOT NULL,
  `new_path` varchar(500) NOT NULL,
  `status_code` smallint(5) UNSIGNED NOT NULL DEFAULT 301,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('18Ri5zLhXLtErqSW7cJsIILXCMjPB50xkBUutZ8r', NULL, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQXJnd1ZSZ0N4aUFWUUx3SHJaenlNQm4yOXU1ZkhaY0d1eHFhY0kzRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9sb2NhbGhvc3QvcHJvZHVjdHMiO3M6NToicm91dGUiO3M6MTQ6InByb2R1Y3RzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791460160),
('2bdHnBq61ngdRoZ6CtCAsBOzTt1n419vVywQLOWU', 4, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUkdPNnhmQjBqWG9jb2xQR2FKWXVQbDJ6YWZZZk54SG80OXdjQktCViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vb3JkZXJzIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5vcmRlcnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1791460160),
('3MAYMiPVhAsFuwoobBq3MfVmt6sfIIxWYe7EzMMm', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/151.0.7922.34 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVGZGR2h5SnJEWHYyYjROMjFOdjdmMG1ITG00N2lPMXB5czNqTXpxUyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1791464747),
('5cfQY9COOaYEXwKgUFqxWKdOZvmmX4Frcvx3tarX', NULL, '127.0.0.1', 'Python-urllib/3.14', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid0ZDS0xsaVhnREliT0dhSUloWVlkUkFScG1EazZxTVVyYVdEdGV3VSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791464020),
('5w61tWhrsZ7uF1qqemTBHFpGSaqIttjWnB2hqOqJ', 4, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieU5SYUsxT1YwNzJYYWxrVkhGU0l2Q2NyUjQ4SU13UkdIZ0JWWERoTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vY3VzdG9tZXJzLzEvdGFiL29yZGVycyI7czo1OiJyb3V0ZSI7czoxOToiYWRtaW4uY3VzdG9tZXJzLnRhYiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791460214),
('AnDgHx1ztdlt9E4DtnQnYxbchWjvPINJORZQJii6', 4, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibG1URHVna0RyTERJRHk5MEF3dndXNzJqSWZacXRyZFJ5MWdjdzJzVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vY3VzdG9tZXJzIjtzOjU6InJvdXRlIjtzOjIxOiJhZG1pbi5jdXN0b21lcnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1791460160),
('DarWnScm0gz8ViYhNx1rNe7RnvfiCL9YT3Q3gFpA', NULL, '127.0.0.1', 'Symfony', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRFV1ODNPVzQzSGNzaWM3UTBMZUdWNlljYm82N3ZGczMzZWtqOVkxVCI7czoxNToicmVjZW50bHlfdmlld2VkIjthOjE6e2k6MDtpOjE7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjU3OiJodHRwOi8vbG9jYWxob3N0L3Byb2R1Y3QvZGF5LWNodXllbi1sdW5hcmEtdGhhaS1kdW9uZy1sYW0iO3M6NToicm91dGUiO3M6MTM6InByb2R1Y3RzLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1791460160),
('dHNgTJI3UbXawOiMYrrHiTkRtBhHwiPm1MapYp5O', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/151.0.7922.34 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSzRZOVB5T0tQSzdIdm5qMk5veGdadWRGVUszb0tjMlRXYnp5Y3oxRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1791464549),
('EevsSIz0eP3n86Vy4ezY1lLlrtOlKJAmYSeJHqZt', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/151.0.7922.34 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiM25Ob1NpVWdIeUVkOEdHQ2hYZmd1QnNFbExLNU9kem5mRjJ0Ymc2WCI7czoxNToicmVjZW50bHlfdmlld2VkIjthOjE6e2k6MDtpOjE7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjU0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vb3JkZXJzL0xOUy0yMDI2MTAwOC1FRUxTVEYiO3M6NToicm91dGUiO3M6MTc6ImFkbWluLm9yZGVycy5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDtzOjE1OiJsYXN0X29yZGVyX2NvZGUiO3M6MTk6IkxOUy0yMDI2MTAwOC1FRUxTVEYiO3M6MTc6ImF1dGhvcml6ZWRfb3JkZXJzIjthOjE6e2k6MDtpOjU2NTt9fQ==', 1791464427),
('IWBwuRzSNCHXnRK7JiPHKr3sSYUi3G9YnxgnDdm7', NULL, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1c2b1IwTWZJelFVWkdMSUU4RWNlSXZjc1B3dmtEM0VKSWNoUVdCSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791460160),
('jRGaEs4yv9bzCg9fVFMr0ImEU78FKhsmqcqyFPz3', NULL, '127.0.0.1', 'Python-urllib/3.14', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV3ZzNEJzQ1BJNGNGeEN0QU9FZlExRFRWWmVzZXFnZFhOSnYzV1JxVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791464023),
('OwJkVO9eGbKB6MpeRzNZN8Nnv5RHXqDJbrcXsTj8', 4, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkxvelU2OFE4ZzE5Z3hUT3E4ZVE1YUpTdEZ3WDY1Um83allnU3hMRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vY3VzdG9tZXJzLzEiO3M6NToicm91dGUiO3M6MjA6ImFkbWluLmN1c3RvbWVycy5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791460160),
('qlXHjtqoKFyuBdl2mYg09R19tIF1ClD3rncwj1tq', 4, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUHRBMjNaQmxFZ25KUXNhWVVLdlJNcDZzbGVlMGkydjNLdnI0VTFPWiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4vcHJvZHVjdHMiO3M6NToicm91dGUiO3M6MjA6ImFkbWluLnByb2R1Y3RzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791460160),
('QswIMQFdE6OWKAHQTVoAlM9Wzl6TMJwgfAVhCoTX', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/151.0.7922.34 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiejhIb0FqSlNGOWlZYWxzRDdBbFhDbU1pZ2h3em1YOUFyQWVGYUZWQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1791464697),
('tnxwNC24Y8A4XP5vhrCCOiYf6V4afyBhusdHKo2J', 4, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzRtVFVTWUtac2Zvc0tBQWJET3FKUWJqdmtnRVZ1UkN1aWMwT0pMTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4iO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791460160),
('U66lEpCUdqtgqdtbXsZ14caOiZSCBdiPEv1zc1A9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/151.0.7922.34 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVkxZOW14a2hCOG5rMG1nQjIwTkxWRmgwbWhIOGtGcFVmWkxPMzBiaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZWRpYS9sdW5hcmEtbG9nby1kYXJrLnN2ZyI7czo1OiJyb3V0ZSI7czoxMDoibWVkaWEuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791464325),
('vId2dfbYBkWdAY3IVxGsgrmdWgoTDdbyAnIx3u3E', 4, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib3lSOWhyQUU2TXM0dWxXNnJPeXlCdGtzcFR6c2Rvc1Q2Q1d5NzQ0USI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW4iO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791460185),
('XTLkDbqCbvITawIEoXSAkG59s0hW9d2v1JfbGD5e', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/151.0.7922.34 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoielRjTTMxbzEzOFc1QWN1cE56a0xESVp2QkN1Z0JGTHhVQW12bGRiMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1791464621);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'string',
  `group` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support_conversations`
--

CREATE TABLE `support_conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(40) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guest_token` varchar(64) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'open',
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `support_conversations`
--

INSERT INTO `support_conversations` (`id`, `reference`, `user_id`, `guest_token`, `customer_name`, `customer_email`, `status`, `assigned_to`, `last_message_at`, `created_at`, `updated_at`) VALUES
(1, 'CHAT-20261004-NLNHAR', NULL, 'uHqyB4759Tpg4sxh1EgL5Qp7SrvFHBuoXvxIbA1twzS71jw9MAQN91VeuKY3', 'Khách vãng lai', NULL, 'open', NULL, '2026-10-04 15:05:24', '2026-10-04 15:05:24', '2026-10-04 15:05:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` varchar(20) NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Tấn Mạnh', 'tanmanhnsnguyen@gmail.com', NULL, '$2y$12$LamWRaS.qMhPFuMGPCfVheBl.AaNOBYTWlI68JeJY7x4Z9C86mTlC', 'user', NULL, '2026-09-20 08:52:33', '2026-09-20 08:52:33'),
(4, 'Quản trị viên Lunara', 'admin@lunara.vn', NULL, '$2y$12$nEmmdbgwjpk097HNyFrm6uORsBR.N.wiUeqPKMIpjkppUVvKv99HC', 'admin', NULL, '2026-09-21 08:24:55', '2026-09-21 08:24:55'),
(5, 'Lương Hà Trang', 'lunaraslivertrangsuc@gmail.m', NULL, '$2y$12$/l83KesrsvA702dyTl2B3.NIDzP0IDIoMAzPNfH.vYU5Mjut733GS', 'user', NULL, '2026-10-04 15:12:24', '2026-10-04 15:12:24'),
(315, 'Khách hàng Test 1', 'perf_customer_1@testlunara.local', NULL, '$2y$12$9wltTuFLdf35ouGzim9Qse/N6ZypZL3OYVt4ACQe9c0WeJ8l.ZF2q', 'user', NULL, '2026-07-21 14:09:00', '2026-10-07 14:09:00'),
(316, 'Khách hàng Test 2', 'perf_customer_2@testlunara.local', NULL, '$2y$12$5byrc8TEj3N5zuJ6X2QJzeGh9Li5NikEQpWlNCENoLAeui28kysu6', 'user', NULL, '2026-10-06 14:09:00', '2026-10-07 14:09:00'),
(317, 'Khách hàng Test 3', 'perf_customer_3@testlunara.local', NULL, '$2y$12$QhqpJQRHy1QEEOPi9VN5YuphmFQS3AuVuwd7/zYnWapUtDU2ka1eq', 'user', NULL, '2026-09-21 14:09:00', '2026-10-07 14:09:00'),
(318, 'Khách hàng Test 4', 'perf_customer_4@testlunara.local', NULL, '$2y$12$4hhzMBHNiXLhOE.hLki0wO88lg6rMA4C2w70NfKPI5b9tdJL1HYYy', 'user', NULL, '2026-10-01 14:09:00', '2026-10-07 14:09:00'),
(319, 'Khách hàng Test 5', 'perf_customer_5@testlunara.local', NULL, '$2y$12$fChvu/KzYWWtno0RH/4kMu1nFEOlyAe9Fx6KIuKqcFouCE0RqUN0y', 'user', NULL, '2026-10-03 14:09:00', '2026-10-07 14:09:00'),
(320, 'Khách hàng Test 6', 'perf_customer_6@testlunara.local', NULL, '$2y$12$34zRcer0ulYp8JtkPzZqzOUKppEerpSDHsETa5r3Q0HNHS/7B7YAa', 'user', NULL, '2026-09-14 14:09:00', '2026-10-07 14:09:00'),
(321, 'Khách hàng Test 7', 'perf_customer_7@testlunara.local', NULL, '$2y$12$4zXZXy5ggHoROULk5fQ6oeRU4hhA9dmNDjgyEb/bY2YY6Riy8YINS', 'user', NULL, '2026-07-25 14:09:00', '2026-10-07 14:09:00'),
(322, 'Khách hàng Test 8', 'perf_customer_8@testlunara.local', NULL, '$2y$12$ge.hH6aoA1o6/Zy2aWJPVe49XQFMlvZSWqgiZZv/vVw8pHBvuUpVy', 'user', NULL, '2026-07-28 14:09:00', '2026-10-07 14:09:00'),
(323, 'Khách hàng Test 9', 'perf_customer_9@testlunara.local', NULL, '$2y$12$hr4E4nvxP6xQ0n/U2fna2.Ly35lk9D..lykOOBi8PTs.lh7GqxSMi', 'user', NULL, '2026-07-25 14:09:00', '2026-10-07 14:09:00'),
(324, 'Khách hàng Test 10', 'perf_customer_10@testlunara.local', NULL, '$2y$12$icEn5H6Ol2ms6EgkzhkWAuhnit.Piih5Re2sAVNh1gqY2jzWGKtl.', 'user', NULL, '2026-08-20 14:09:00', '2026-10-07 14:09:00'),
(325, 'Khách hàng Test 11', 'perf_customer_11@testlunara.local', NULL, '$2y$12$Cb25bDCRiMcL6prRdBcVuOpHccGlb6Y5OV/n25XrD0UXwKo1jtC12', 'user', NULL, '2026-08-20 14:09:00', '2026-10-07 14:09:00'),
(326, 'Khách hàng Test 12', 'perf_customer_12@testlunara.local', NULL, '$2y$12$lQ46z/q3LZFvR//JAuGmBOYF6XqfAyGgjd6qViT6EVpmpj3sLSRmy', 'user', NULL, '2026-09-08 14:09:00', '2026-10-07 14:09:00'),
(327, 'Khách hàng Test 13', 'perf_customer_13@testlunara.local', NULL, '$2y$12$0nHNGNsGvZHBCw2X5DbXVe6Z4zKyiETT75lcEiqMWUFb1CkRQ9Zt2', 'user', NULL, '2026-08-03 14:09:00', '2026-10-07 14:09:00'),
(328, 'Khách hàng Test 14', 'perf_customer_14@testlunara.local', NULL, '$2y$12$gqRpaJ5mMbueaL91VQzBo.TcKmFWTr.iFk6oyitwZVjoG6PZt4QMy', 'user', NULL, '2026-09-27 14:09:00', '2026-10-07 14:09:00'),
(329, 'Khách hàng Test 15', 'perf_customer_15@testlunara.local', NULL, '$2y$12$p1kF/Iog701I.agbpV9A2OBHjA2esB4b.JAwysn94P7mwED7Chnuy', 'user', NULL, '2026-07-14 14:09:00', '2026-10-07 14:09:00'),
(330, 'Khách hàng Test 16', 'perf_customer_16@testlunara.local', NULL, '$2y$12$45MG4p.5hnsuUXvsry3V/.eXuEmRMW5OAIK35bu.nk/3NlnnRIXgK', 'user', NULL, '2026-09-16 14:09:00', '2026-10-07 14:09:00'),
(331, 'Khách hàng Test 17', 'perf_customer_17@testlunara.local', NULL, '$2y$12$VnI53FK5c2vXOzdBUbfsZ.5wzG6GTmfeRlTgHQ0eqiN8hFgSa4vfK', 'user', NULL, '2026-07-19 14:09:00', '2026-10-07 14:09:00'),
(332, 'Khách hàng Test 18', 'perf_customer_18@testlunara.local', NULL, '$2y$12$nILf/7Jl8tEUBpptWqjbaealKHL66IZ9jMYtGrRfxZm6HA71FvDhG', 'user', NULL, '2026-09-12 14:09:00', '2026-10-07 14:09:00'),
(333, 'Khách hàng Test 19', 'perf_customer_19@testlunara.local', NULL, '$2y$12$EPMIOgFtmG7rnG/zvL2ihOWHG.zaiV8mR5aQUyeCbo.Zvv4hOU5O6', 'user', NULL, '2026-10-01 14:09:00', '2026-10-07 14:09:00'),
(334, 'Khách hàng Test 20', 'perf_customer_20@testlunara.local', NULL, '$2y$12$dRA9G2AuqWJIN5T3/6ARJO3MrAI/wI2jHZDDg.KjoGm0WMiES1Xgq', 'user', NULL, '2026-08-31 14:09:00', '2026-10-07 14:09:00'),
(335, 'Khách hàng Test 21', 'perf_customer_21@testlunara.local', NULL, '$2y$12$mVWRHL1fLRDKJgErB8l.VOXryFqmE3joxWIdsKO.ooFzk804t1vDi', 'user', NULL, '2026-07-17 14:09:00', '2026-10-07 14:09:00'),
(336, 'Khách hàng Test 22', 'perf_customer_22@testlunara.local', NULL, '$2y$12$tTfPI3QVf.Yslk83fhUcceiYCMfhc49zuK3ZeLRPaTduEkCHhonmu', 'user', NULL, '2026-08-04 14:09:00', '2026-10-07 14:09:00'),
(337, 'Khách hàng Test 23', 'perf_customer_23@testlunara.local', NULL, '$2y$12$NWyOWWFVJ7riYruntuIyXO5LOwlRnJB8JuEcnGWnKGE7NbsTtFZRG', 'user', NULL, '2026-08-24 14:09:00', '2026-10-07 14:09:00'),
(338, 'Khách hàng Test 24', 'perf_customer_24@testlunara.local', NULL, '$2y$12$PVATbnUmZpvn3HGi0Dp5M.dG2UQDB7nunTFBjel5Q6nxXf9UIfCDO', 'user', NULL, '2026-09-09 14:09:00', '2026-10-07 14:09:00'),
(339, 'Khách hàng Test 25', 'perf_customer_25@testlunara.local', NULL, '$2y$12$Z3wFw8YDQi0lnW2l4JbW4ui1WMpi1iO7HrJrBBaQNUX7vEa7RVJWC', 'user', NULL, '2026-08-18 14:09:00', '2026-10-07 14:09:00'),
(340, 'Khách hàng Test 26', 'perf_customer_26@testlunara.local', NULL, '$2y$12$5vvWqPSQWRypR0JjvmPxvOYIZiy3m32gW92P0pZi3uOFY1EUFUNOS', 'user', NULL, '2026-07-25 14:09:00', '2026-10-07 14:09:00'),
(341, 'Khách hàng Test 27', 'perf_customer_27@testlunara.local', NULL, '$2y$12$sz7fN/GKjS9B2.ur7urMWeFX.HUo8ChW5VvCyzjl7vzMRAwUYRCa2', 'user', NULL, '2026-09-23 14:09:00', '2026-10-07 14:09:00'),
(342, 'Khách hàng Test 28', 'perf_customer_28@testlunara.local', NULL, '$2y$12$Qxzoqr8r0fFtfW3RPNalzeT4Gr.gEmFzgX7BliFwN1zW8aeDzPgAq', 'user', NULL, '2026-10-04 14:09:00', '2026-10-07 14:09:00'),
(343, 'Khách hàng Test 29', 'perf_customer_29@testlunara.local', NULL, '$2y$12$Ha3B9CqtApDL/Lus9Ihk0./HA0qtuoa1ntN/omEw6YjWooYmzVe7u', 'user', NULL, '2026-09-12 14:09:00', '2026-10-07 14:09:00'),
(344, 'Khách hàng Test 30', 'perf_customer_30@testlunara.local', NULL, '$2y$12$Re.vC.u73o/ghvROdKvshOzOI4FWlcUBMD5HYWroGK/TVuYdcRDnC', 'user', NULL, '2026-08-01 14:09:00', '2026-10-07 14:09:00'),
(345, 'Khách hàng Test 31', 'perf_customer_31@testlunara.local', NULL, '$2y$12$hi/JOit5Us824Ni/ZQeKl.QyQS0dwrRxbKzqr8miAS3eqqbq1yUlW', 'user', NULL, '2026-09-23 14:09:00', '2026-10-07 14:09:00'),
(346, 'Khách hàng Test 32', 'perf_customer_32@testlunara.local', NULL, '$2y$12$Yqiq9HKz4n8JcuSvXZc0/O.EOae9cRqC1hBRdDcebpe62vkrqMLNq', 'user', NULL, '2026-07-13 14:09:00', '2026-10-07 14:09:00'),
(347, 'Khách hàng Test 33', 'perf_customer_33@testlunara.local', NULL, '$2y$12$EvQi9YcI7k6MTNCCOsd6H.xyeC9lCCGfzkZ/yqhcJjj.eqRoVDF5m', 'user', NULL, '2026-09-07 14:09:00', '2026-10-07 14:09:00'),
(348, 'Khách hàng Test 34', 'perf_customer_34@testlunara.local', NULL, '$2y$12$LIIOasjTa9xryuibxmzsUuXjt3ZKXFt2LH//.l7M/t7mLYEH5EpFu', 'user', NULL, '2026-07-13 14:09:00', '2026-10-07 14:09:00'),
(349, 'Khách hàng Test 35', 'perf_customer_35@testlunara.local', NULL, '$2y$12$n832KKF71fY/C1OsFt3iN.WdMdGvz761a7r2bI0x/fW5uFmVS6PDG', 'user', NULL, '2026-09-14 14:09:00', '2026-10-07 14:09:00'),
(350, 'Khách hàng Test 36', 'perf_customer_36@testlunara.local', NULL, '$2y$12$B9NEz0BJD9kCR5FzBD2lZe/l.K7yhwpi/U56RB3CUz5idy7w2cJv6', 'user', NULL, '2026-09-27 14:09:00', '2026-10-07 14:09:00'),
(351, 'Khách hàng Test 37', 'perf_customer_37@testlunara.local', NULL, '$2y$12$pGWg5TZfEWQ9x0N6q0.2weOMkwzB46ripbx3cqh8DDhfNrq82lLSe', 'user', NULL, '2026-10-03 14:09:00', '2026-10-07 14:09:00'),
(352, 'Khách hàng Test 38', 'perf_customer_38@testlunara.local', NULL, '$2y$12$9W8L.ddGO74TE8dqb9EyqOxO6XLRjP3KU.LcOaXLam31m0ojuREIS', 'user', NULL, '2026-08-21 14:09:00', '2026-10-07 14:09:00'),
(353, 'Khách hàng Test 39', 'perf_customer_39@testlunara.local', NULL, '$2y$12$PijqMdVotHpfUR6aq2JP4uN0dCYWcnuYSeEL/jptxJ4wB3LMtES9O', 'user', NULL, '2026-08-06 14:09:00', '2026-10-07 14:09:00'),
(354, 'Khách hàng Test 40', 'perf_customer_40@testlunara.local', NULL, '$2y$12$kZAyYUPH0aIPtaYcPuBc3eTVE6Spw/ELDlhGaKN7kjC.CJmRfKJey', 'user', NULL, '2026-10-05 14:09:00', '2026-10-07 14:09:00'),
(355, 'Khách hàng Test 41', 'perf_customer_41@testlunara.local', NULL, '$2y$12$zQfp.XDMwTckEkKWi2HhO.FdXTIDV4/YPD2/CHVB/sTc880JdErse', 'user', NULL, '2026-09-18 14:09:00', '2026-10-07 14:09:00'),
(356, 'Khách hàng Test 42', 'perf_customer_42@testlunara.local', NULL, '$2y$12$HnC720AO/crBc4Jl15CVU.QgfRl4UiBB4Ys3LBEHTS8TbPHuISbei', 'user', NULL, '2026-07-29 14:09:00', '2026-10-07 14:09:00'),
(357, 'Khách hàng Test 43', 'perf_customer_43@testlunara.local', NULL, '$2y$12$PHgwXaaDyNloEVgCKiyJA.CJhmAhZaaJ7Z3.8gg0zHiAsqlGEeice', 'user', NULL, '2026-08-28 14:09:00', '2026-10-07 14:09:00'),
(358, 'Khách hàng Test 44', 'perf_customer_44@testlunara.local', NULL, '$2y$12$i15aIA5VmDDBx/NhkJQHg.yji7JqNumEXt/IS7FlNskds8TxhkodK', 'user', NULL, '2026-07-11 14:09:00', '2026-10-07 14:09:00'),
(359, 'Khách hàng Test 45', 'perf_customer_45@testlunara.local', NULL, '$2y$12$9xPdBqCEYKknpJ6eB8ezhu/kq4aZ1VcqLOLChUH84F3i/BXQ1Mx16', 'user', NULL, '2026-08-18 14:09:00', '2026-10-07 14:09:00'),
(360, 'Khách hàng Test 46', 'perf_customer_46@testlunara.local', NULL, '$2y$12$IgbWuRzaLk0iILX/6ja9NeM0b9jiDKhsCTKjY18kmhzXMbsVMw4wi', 'user', NULL, '2026-08-26 14:09:00', '2026-10-07 14:09:00'),
(361, 'Khách hàng Test 47', 'perf_customer_47@testlunara.local', NULL, '$2y$12$O4cb2Fnhk8/1uCq9VYgALOaztqDMevW5oM2RgkgcS1eGEYuHgecJa', 'user', NULL, '2026-09-17 14:09:00', '2026-10-07 14:09:00'),
(362, 'Khách hàng Test 48', 'perf_customer_48@testlunara.local', NULL, '$2y$12$R1Lva065w.mQKYkv/aOCVuweAGYqLqIpAoSSx55gO7DXS1P3iSH/.', 'user', NULL, '2026-08-16 14:09:00', '2026-10-07 14:09:00'),
(363, 'Khách hàng Test 49', 'perf_customer_49@testlunara.local', NULL, '$2y$12$wWSgn.UZeJtFLgRGrojPc.uQwtZ6AYQwhm3ZNI.hqHmfSqFslDMne', 'user', NULL, '2026-07-19 14:09:00', '2026-10-07 14:09:00'),
(364, 'Khách hàng Test 50', 'perf_customer_50@testlunara.local', NULL, '$2y$12$IATtda4JIE3JHok6uQnPaOAYmMX1kBlXut11xdlpxei6u7SkKSsQ.', 'user', NULL, '2026-07-13 14:09:00', '2026-10-07 14:09:00'),
(365, 'Khách hàng Test 51', 'perf_customer_51@testlunara.local', NULL, '$2y$12$J5.rUedVcrA1KgwJwJX/fOFQWOzBjIFUSVvyUXsHFO5z1VMtX2rXy', 'user', NULL, '2026-07-11 14:09:00', '2026-10-07 14:09:00'),
(366, 'Khách hàng Test 52', 'perf_customer_52@testlunara.local', NULL, '$2y$12$XOQmWS9s38PpU2oTIQsRxeZ2ieAtp2gCwffcbReZTsZU0o9tlREOi', 'user', NULL, '2026-07-14 14:09:00', '2026-10-07 14:09:00'),
(367, 'Khách hàng Test 53', 'perf_customer_53@testlunara.local', NULL, '$2y$12$BG7EBTjPHk6AgKvjawy8H.iuFVwKQ03BmMc2qs96Hdww1rG4GQDY2', 'user', NULL, '2026-07-27 14:09:00', '2026-10-07 14:09:00'),
(368, 'Khách hàng Test 54', 'perf_customer_54@testlunara.local', NULL, '$2y$12$S3/o844ZdCChswd.0xTdiOn1iuvLvZhVldoWr1svCJqd7KWNU.xT.', 'user', NULL, '2026-08-15 14:09:00', '2026-10-07 14:09:00'),
(369, 'Khách hàng Test 55', 'perf_customer_55@testlunara.local', NULL, '$2y$12$CNcNJnwH6ZZ210nxhcwM9.Oi2B13VjFQdJf6iwTGNJCjEh5w7IUIe', 'user', NULL, '2026-07-14 14:09:00', '2026-10-07 14:09:00'),
(370, 'Khách hàng Test 56', 'perf_customer_56@testlunara.local', NULL, '$2y$12$mXea34sLMqjrzodJB5TV8u9nHz9CSNZBHcFDdseM/ElUrhXHHma4y', 'user', NULL, '2026-09-11 14:09:00', '2026-10-07 14:09:00'),
(371, 'Khách hàng Test 57', 'perf_customer_57@testlunara.local', NULL, '$2y$12$c63kpkcHuLL2nOwG/dSHSu.6d8wSVb2bu3T1OcfDlxm4xFBUk2wRK', 'user', NULL, '2026-09-24 14:09:00', '2026-10-07 14:09:00'),
(372, 'Khách hàng Test 58', 'perf_customer_58@testlunara.local', NULL, '$2y$12$6GPlp/wChp.nvkiQ3iYmVeGLz5CHxg3zQKMEuQ2YmYmdPslzicGQC', 'user', NULL, '2026-08-24 14:09:00', '2026-10-07 14:09:00'),
(373, 'Khách hàng Test 59', 'perf_customer_59@testlunara.local', NULL, '$2y$12$3VQqZ85yXg4EHMC/Qc1jq.bqE1IMQFE.N7Nk00F09/2kiQkg1lXJC', 'user', NULL, '2026-07-25 14:09:00', '2026-10-07 14:09:00'),
(374, 'Khách hàng Test 60', 'perf_customer_60@testlunara.local', NULL, '$2y$12$x1FfWjTy6i1u95varhJ6aegRpW9wG6pAckSY818TNDsxZLYc9.sP2', 'user', NULL, '2026-08-25 14:09:00', '2026-10-07 14:09:00'),
(375, 'Khách hàng Test 61', 'perf_customer_61@testlunara.local', NULL, '$2y$12$Y3ylMuyf3OTFuAe8R/CQcedvEb3yB4lp4wI5dKGezVm0O01LUmo7i', 'user', NULL, '2026-10-02 14:09:00', '2026-10-07 14:09:00'),
(376, 'Khách hàng Test 62', 'perf_customer_62@testlunara.local', NULL, '$2y$12$Pp.q3B0VV2V2Z7C6jAF0X.nMUH/Fg7BYg01o8pFj1wj71kjDyHsUi', 'user', NULL, '2026-07-20 14:09:00', '2026-10-07 14:09:00'),
(377, 'Khách hàng Test 63', 'perf_customer_63@testlunara.local', NULL, '$2y$12$YETu8NORgWvxx2Qj2f8TbOq4.m42QDI/KFNEGbWO8m3pRpRpeM1UG', 'user', NULL, '2026-10-05 14:09:00', '2026-10-07 14:09:00'),
(378, 'Khách hàng Test 64', 'perf_customer_64@testlunara.local', NULL, '$2y$12$cAu04O62hM0JIoMnM.4UR.04vqO6pi1BSZyjcoFP3yiwTGCC4jxDi', 'user', NULL, '2026-09-27 14:09:00', '2026-10-07 14:09:00'),
(379, 'Khách hàng Test 65', 'perf_customer_65@testlunara.local', NULL, '$2y$12$F4MLIsInFUzl4Rw1equ.COJLa9P7.MsocoyHDOEw2MSVGSyA1QBS.', 'user', NULL, '2026-09-21 14:09:00', '2026-10-07 14:09:00'),
(380, 'Khách hàng Test 66', 'perf_customer_66@testlunara.local', NULL, '$2y$12$OXjqsnVUA0WAyRx2n0zSqua4n0AWOq24Hpa5ip6RuiS.Sy8kGKa3i', 'user', NULL, '2026-08-25 14:09:00', '2026-10-07 14:09:00'),
(381, 'Khách hàng Test 67', 'perf_customer_67@testlunara.local', NULL, '$2y$12$W1BxZSaXUZq6hIlEQ/VbseQAW/93gSnFE6WLpSJ.o2C8PuMCiFbfC', 'user', NULL, '2026-08-11 14:09:00', '2026-10-07 14:09:00'),
(382, 'Khách hàng Test 68', 'perf_customer_68@testlunara.local', NULL, '$2y$12$qkq5WMerJu4gqGAuOtl.9e82Xc6AFyjy/DSHkBQCDPJaMy4MSDQxy', 'user', NULL, '2026-07-15 14:09:00', '2026-10-07 14:09:00'),
(383, 'Khách hàng Test 69', 'perf_customer_69@testlunara.local', NULL, '$2y$12$TTJK/WUwaf8pXawpGdrYL.12ALrNV7XstjNDxRN8UPiQZk6/ThaMC', 'user', NULL, '2026-07-31 14:09:00', '2026-10-07 14:09:00'),
(384, 'Khách hàng Test 70', 'perf_customer_70@testlunara.local', NULL, '$2y$12$piP9bz1gWKoipw0Kk58qyegCU/oJ0zB/NV1WZUlPGRHkSU8dneoeO', 'user', NULL, '2026-07-19 14:09:00', '2026-10-07 14:09:00'),
(385, 'Khách hàng Test 71', 'perf_customer_71@testlunara.local', NULL, '$2y$12$sOFm7uQ0ieaqkLnjmb4dVORzzswNHuXUWfEQ1Dcbg3Sgd22QMcFVq', 'user', NULL, '2026-07-27 14:09:00', '2026-10-07 14:09:00'),
(386, 'Khách hàng Test 72', 'perf_customer_72@testlunara.local', NULL, '$2y$12$wNW47unBykXonDawXOkfOOPZJx84SRqiIGsnTyIRGZQV3oWxbTm1i', 'user', NULL, '2026-10-04 14:09:00', '2026-10-07 14:09:00'),
(387, 'Khách hàng Test 73', 'perf_customer_73@testlunara.local', NULL, '$2y$12$Fy.mx6R8uBfFKU41M8jWfONItfqj6sRCoRF0puQs0EqBhvlKHo25C', 'user', NULL, '2026-07-23 14:09:00', '2026-10-07 14:09:00'),
(388, 'Khách hàng Test 74', 'perf_customer_74@testlunara.local', NULL, '$2y$12$oswDmEbSxjZMh6RberPN3exFu8SSt5txtnBgJGQlf0bd71k3HBnnS', 'user', NULL, '2026-10-06 14:09:00', '2026-10-07 14:09:00'),
(389, 'Khách hàng Test 75', 'perf_customer_75@testlunara.local', NULL, '$2y$12$mq8gPDc6ALWXev5BVORsruiI0ztDMO5duA5Lk8HjpjrEtTk5QQMni', 'user', NULL, '2026-09-09 14:09:00', '2026-10-07 14:09:00'),
(390, 'Khách hàng Test 76', 'perf_customer_76@testlunara.local', NULL, '$2y$12$AWOFqnQkhbcT0cbWqJ8DsOcMairiw4ghPlnIB5OHvmEOGfSfgBfHi', 'user', NULL, '2026-09-18 14:09:00', '2026-10-07 14:09:00'),
(391, 'Khách hàng Test 77', 'perf_customer_77@testlunara.local', NULL, '$2y$12$iC03e9V5FQcVV58kwa5xMuDxbcURLrJnkLAkt9AgDLXB8WHQFjrmu', 'user', NULL, '2026-09-27 14:09:00', '2026-10-07 14:09:00'),
(392, 'Khách hàng Test 78', 'perf_customer_78@testlunara.local', NULL, '$2y$12$QbYW7eCT21iVuaXwe2Yv4OVkpI/36R1yaqvpm/cuaGOQoqg5HJm9a', 'user', NULL, '2026-09-26 14:09:00', '2026-10-07 14:09:00'),
(393, 'Khách hàng Test 79', 'perf_customer_79@testlunara.local', NULL, '$2y$12$/O.JOioimKf3X/XdxQQ99OqTai8N27N1UADWdnVj6fgIG8KgBaNfW', 'user', NULL, '2026-08-30 14:09:00', '2026-10-07 14:09:00'),
(394, 'Khách hàng Test 80', 'perf_customer_80@testlunara.local', NULL, '$2y$12$sdabimKH.daBlM7dXVlPxerm6UMgzaSAAUTEsycxCzkfhRWGoojRG', 'user', NULL, '2026-09-30 14:09:00', '2026-10-07 14:09:00'),
(395, 'Khách hàng Test 81', 'perf_customer_81@testlunara.local', NULL, '$2y$12$hsFx/WfAqNl0wvY/mh7yPe5jBQtRSEwRbN2rfoxP587smBRhJzHpy', 'user', NULL, '2026-09-02 14:09:00', '2026-10-07 14:09:00'),
(396, 'Khách hàng Test 82', 'perf_customer_82@testlunara.local', NULL, '$2y$12$xmxQj8H4YwLjaRzsZUfvH.f.DjuFJmId2dJwLr5BW6l50CiNzXFd6', 'user', NULL, '2026-08-31 14:09:00', '2026-10-07 14:09:00'),
(397, 'Khách hàng Test 83', 'perf_customer_83@testlunara.local', NULL, '$2y$12$8/l8pzGJBRXg90XIpnbUOOcAjgte6EHmmQXSMNcBiEp8HXu.s04Xy', 'user', NULL, '2026-10-05 14:09:00', '2026-10-07 14:09:00'),
(398, 'Khách hàng Test 84', 'perf_customer_84@testlunara.local', NULL, '$2y$12$AtAHk6UPunUQihhp5S/V2.CbgufXGMjeytRE/u8XW6lNPE19vr/IC', 'user', NULL, '2026-08-05 14:09:00', '2026-10-07 14:09:00'),
(399, 'Khách hàng Test 85', 'perf_customer_85@testlunara.local', NULL, '$2y$12$af0PyRPzFjG5KTHR5u6YXeZqOnur5ALtgM/IUi.oWh/yBOBsCBLr2', 'user', NULL, '2026-07-20 14:09:00', '2026-10-07 14:09:00'),
(400, 'Khách hàng Test 86', 'perf_customer_86@testlunara.local', NULL, '$2y$12$w/wwD62/ILlbL4DSXSjA3ej7NJ5bWIToGKx.dUC8ZUHvEwrVIFOtS', 'user', NULL, '2026-08-16 14:09:00', '2026-10-07 14:09:00'),
(401, 'Khách hàng Test 87', 'perf_customer_87@testlunara.local', NULL, '$2y$12$Rdvzar9Y2jiRTrrk4Wmkk.8uHbWZ.4G3f6FDxPXu7HCaaE7xlHQE2', 'user', NULL, '2026-08-05 14:09:00', '2026-10-07 14:09:00'),
(402, 'Khách hàng Test 88', 'perf_customer_88@testlunara.local', NULL, '$2y$12$tHFr.yhU93NqNIViSPQ6Hu7j7.SwxFk.dcDyufxCtCOf3R6msS/Ba', 'user', NULL, '2026-08-29 14:09:00', '2026-10-07 14:09:00'),
(403, 'Khách hàng Test 89', 'perf_customer_89@testlunara.local', NULL, '$2y$12$ErJnKdRAudiz3QYysFcUKeZo04kK2peLk0ID785RRyYjxmbNpBHPG', 'user', NULL, '2026-08-16 14:09:00', '2026-10-07 14:09:00'),
(404, 'Khách hàng Test 90', 'perf_customer_90@testlunara.local', NULL, '$2y$12$YVUUuWfldq9dhVep9hkVIO7DGluhMukoOBAo45k2bHHYh5WuRv05K', 'user', NULL, '2026-09-18 14:09:00', '2026-10-07 14:09:00'),
(405, 'Khách hàng Test 91', 'perf_customer_91@testlunara.local', NULL, '$2y$12$t5YXgaYwkcZ2plOdcnyLie3jilLdppyWVUS6Wc4oW4FH1trdw5tv2', 'user', NULL, '2026-08-01 14:09:00', '2026-10-07 14:09:00'),
(406, 'Khách hàng Test 92', 'perf_customer_92@testlunara.local', NULL, '$2y$12$TsH7/D.I0VPDA3JhFSMXqOlzBWq84PbtTW8w1HCyFRVfq2RSVbojG', 'user', NULL, '2026-07-23 14:09:00', '2026-10-07 14:09:00'),
(407, 'Khách hàng Test 93', 'perf_customer_93@testlunara.local', NULL, '$2y$12$QNP4jystvoAb2eb27qTRQeZ7yZ0Kgn7g9Y8y9CIozCpByXP4Zd0/q', 'user', NULL, '2026-09-14 14:09:00', '2026-10-07 14:09:00'),
(408, 'Khách hàng Test 94', 'perf_customer_94@testlunara.local', NULL, '$2y$12$sTI7/veMXalIGSheUq27YuNvI4j/YGEC3wdIWubAuO9.gh7z78zJi', 'user', NULL, '2026-08-15 14:09:00', '2026-10-07 14:09:00'),
(409, 'Khách hàng Test 95', 'perf_customer_95@testlunara.local', NULL, '$2y$12$Xnwxnp/sOnkG6fm0AfBWZOQlrpUMqonuv6BpRj/JBvhZjV0VSfJvW', 'user', NULL, '2026-08-29 14:09:00', '2026-10-07 14:09:00'),
(410, 'Khách hàng Test 96', 'perf_customer_96@testlunara.local', NULL, '$2y$12$yFhTOGUapFgAEVjjI.daY.18Ha5kE5MGPi48yWZMeZj04u/Fjw4j.', 'user', NULL, '2026-08-01 14:09:00', '2026-10-07 14:09:00'),
(411, 'Khách hàng Test 97', 'perf_customer_97@testlunara.local', NULL, '$2y$12$y1CUBfZVrjuUfEAGOVZqhOWFfjwfDu5lXZlOBgpx.nFf49eIcLqoq', 'user', NULL, '2026-08-30 14:09:00', '2026-10-07 14:09:00'),
(412, 'Khách hàng Test 98', 'perf_customer_98@testlunara.local', NULL, '$2y$12$odkeaCJLiZKtpuLvTGr8TONG5ZNGhfwrGfOf.MbR9bTJHu8hYU1DC', 'user', NULL, '2026-08-07 14:09:00', '2026-10-07 14:09:00'),
(413, 'Khách hàng Test 99', 'perf_customer_99@testlunara.local', NULL, '$2y$12$RsVymgHMzdlIa8snW4MtXeyVdRFyC2ZPj7PD7bHqmtMq2djd5BHtC', 'user', NULL, '2026-09-07 14:09:00', '2026-10-07 14:09:00'),
(414, 'Khách hàng Test 100', 'perf_customer_100@testlunara.local', NULL, '$2y$12$bnbybwy517geHKoI28G0C.M7klwzbQl9jD4HbyiCPaFyuP67G/8DO', 'user', NULL, '2026-09-21 14:09:00', '2026-10-07 14:09:00'),
(415, 'Khách hàng Test 101', 'perf_customer_101@testlunara.local', NULL, '$2y$12$hnjjFS0qTzZtVd9r7.sJ.OrFwPI9a0WrQ.OTwjM92lXGWg5M1qj5.', 'user', NULL, '2026-09-01 14:09:00', '2026-10-07 14:09:00'),
(416, 'Khách hàng Test 102', 'perf_customer_102@testlunara.local', NULL, '$2y$12$g4tX5UrOI9RJgaeXt3nD4Od9bxBo0bpNmZxdCYdBEYE3CNSijvrO.', 'user', NULL, '2026-07-17 14:09:00', '2026-10-07 14:09:00'),
(417, 'Khách hàng Test 103', 'perf_customer_103@testlunara.local', NULL, '$2y$12$ZOCF7m3pSzkTlQqEBlXMSOIq9NmbLhE.yMWbx6hWMtySzJMp8GG8G', 'user', NULL, '2026-07-28 14:09:00', '2026-10-07 14:09:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 5, 31, '2026-10-04 15:12:24', '2026-10-04 15:12:24');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `bundle_items`
--
ALTER TABLE `bundle_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bundle_items_bundle_product_id_component_product_id_unique` (`bundle_product_id`,`component_product_id`),
  ADD KEY `bundle_items_bundle_product_id_index` (`bundle_product_id`),
  ADD KEY `bundle_items_component_product_id_index` (`component_product_id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `carts_session_id_unique` (`session_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Chỉ mục cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact_messages_reference_unique` (`reference`),
  ADD KEY `contact_messages_user_id_foreign` (`user_id`),
  ADD KEY `contact_messages_order_id_foreign` (`order_id`),
  ADD KEY `contact_messages_assigned_to_foreign` (`assigned_to`),
  ADD KEY `contact_messages_status_created_at_index` (`status`,`created_at`),
  ADD KEY `contact_messages_email_created_at_index` (`email`,`created_at`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Chỉ mục cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_usages_coupon_id_order_id_unique` (`coupon_id`,`order_id`),
  ADD KEY `coupon_usages_user_id_foreign` (`user_id`),
  ADD KEY `coupon_usages_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_logs_type_status_index` (`type`,`status`),
  ADD KEY `email_logs_related_type_related_id_index` (`related_type`,`related_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_category_is_active_sort_order_index` (`category`,`is_active`,`sort_order`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_code_unique` (`order_code`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_order_status_index` (`order_status`),
  ADD KEY `orders_status_created_at_idx` (`order_status`,`created_at`),
  ADD KEY `orders_user_status_created_idx` (`user_id`,`order_status`,`created_at`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `order_item_components`
--
ALTER TABLE `order_item_components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_components_order_item_id_foreign` (`order_item_id`),
  ADD KEY `order_item_components_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `order_status_histories`
--
ALTER TABLE `order_status_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_status_histories_order_id_foreign` (`order_id`),
  ADD KEY `order_status_histories_changed_by_foreign` (`changed_by`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_txn_ref_unique` (`txn_ref`),
  ADD KEY `payments_order_status_idx` (`order_id`,`status`);

--
-- Chỉ mục cho bảng `payment_refunds`
--
ALTER TABLE `payment_refunds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_refunds_request_id_unique` (`request_id`),
  ADD KEY `payment_refunds_order_id_status_index` (`order_id`,`status`),
  ADD KEY `payment_refunds_payment_id_status_index` (`payment_id`,`status`),
  ADD KEY `payment_refunds_status_created_at_idx` (`status`,`created_at`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_post_category_id_foreign` (`post_category_id`),
  ADD KEY `posts_author_id_foreign` (`author_id`);

--
-- Chỉ mục cho bảng `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_index` (`category_id`),
  ADD KEY `products_product_type_index` (`product_type`),
  ADD KEY `products_is_active_index` (`is_active`),
  ADD KEY `products_active_type_idx` (`is_active`,`product_type`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_index` (`product_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_order_item_id_unique` (`order_item_id`),
  ADD KEY `reviews_admin_replied_by_foreign` (`admin_replied_by`),
  ADD KEY `reviews_product_id_status_index` (`product_id`,`status`),
  ADD KEY `reviews_user_id_status_index` (`user_id`,`status`),
  ADD KEY `reviews_status_created_at_idx` (`status`,`created_at`);

--
-- Chỉ mục cho bảng `review_media`
--
ALTER TABLE `review_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_media_review_id_sort_order_index` (`review_id`,`sort_order`);

--
-- Chỉ mục cho bảng `seo_redirects`
--
ALTER TABLE `seo_redirects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seo_redirects_old_path_unique` (`old_path`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Chỉ mục cho bảng `support_conversations`
--
ALTER TABLE `support_conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `support_conversations_reference_unique` (`reference`),
  ADD KEY `support_conversations_user_id_foreign` (`user_id`),
  ADD KEY `support_conversations_assigned_to_foreign` (`assigned_to`),
  ADD KEY `support_conversations_status_last_message_at_index` (`status`,`last_message_at`),
  ADD KEY `support_conversations_guest_token_index` (`guest_token`);

--
-- Chỉ mục cho bảng `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_messages_sender_id_foreign` (`sender_id`),
  ADD KEY `support_messages_conversation_id_created_at_index` (`conversation_id`,`created_at`),
  ADD KEY `support_messages_conversation_id_read_at_index` (`conversation_id`,`read_at`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bundle_items`
--
ALTER TABLE `bundle_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=566;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1427;

--
-- AUTO_INCREMENT cho bảng `order_item_components`
--
ALTER TABLE `order_item_components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `order_status_histories`
--
ALTER TABLE `order_status_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=565;

--
-- AUTO_INCREMENT cho bảng `payment_refunds`
--
ALTER TABLE `payment_refunds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `review_media`
--
ALTER TABLE `review_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `seo_redirects`
--
ALTER TABLE `seo_redirects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `support_conversations`
--
ALTER TABLE `support_conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=418;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `bundle_items`
--
ALTER TABLE `bundle_items`
  ADD CONSTRAINT `bundle_items_bundle_product_id_foreign` FOREIGN KEY (`bundle_product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bundle_items_component_product_id_foreign` FOREIGN KEY (`component_product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `contact_messages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `contact_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`),
  ADD CONSTRAINT `coupon_usages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_item_components`
--
ALTER TABLE `order_item_components`
  ADD CONSTRAINT `order_item_components_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_components_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_status_histories`
--
ALTER TABLE `order_status_histories`
  ADD CONSTRAINT `order_status_histories_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_status_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payment_refunds`
--
ALTER TABLE `payment_refunds`
  ADD CONSTRAINT `payment_refunds_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_refunds_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `posts_post_category_id_foreign` FOREIGN KEY (`post_category_id`) REFERENCES `post_categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_admin_replied_by_foreign` FOREIGN KEY (`admin_replied_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `review_media`
--
ALTER TABLE `review_media`
  ADD CONSTRAINT `review_media_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `support_conversations`
--
ALTER TABLE `support_conversations`
  ADD CONSTRAINT `support_conversations_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `support_conversations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `support_messages`
--
ALTER TABLE `support_messages`
  ADD CONSTRAINT `support_messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `support_conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `support_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
