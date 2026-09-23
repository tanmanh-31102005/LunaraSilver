-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: lunara_silver
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address_line` text NOT NULL,
  `ward` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (1,1,'Nguyễn Tấn Mạnh','0332247231','Đại học Tôn Đức Thắng',NULL,NULL,'Hồ Chí Minh',1,'2026-09-20 10:58:20','2026-09-20 10:58:20');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `image_url` text NOT NULL,
  `cloudinary_public_id` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bundle_items`
--

DROP TABLE IF EXISTS `bundle_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bundle_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bundle_product_id` bigint(20) unsigned NOT NULL,
  `component_product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bundle_items_bundle_product_id_component_product_id_unique` (`bundle_product_id`,`component_product_id`),
  KEY `bundle_items_bundle_product_id_index` (`bundle_product_id`),
  KEY `bundle_items_component_product_id_index` (`component_product_id`),
  CONSTRAINT `bundle_items_bundle_product_id_foreign` FOREIGN KEY (`bundle_product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bundle_items_component_product_id_foreign` FOREIGN KEY (`component_product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bundle_items`
--

LOCK TABLES `bundle_items` WRITE;
/*!40000 ALTER TABLE `bundle_items` DISABLE KEYS */;
INSERT INTO `bundle_items` VALUES (1,31,5,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(2,31,14,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(3,31,22,1,2,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(4,32,7,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(5,32,17,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(6,32,23,1,2,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(7,33,8,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(8,33,15,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(9,33,30,1,2,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(10,34,1,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(11,34,13,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(12,34,26,1,2,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(13,35,6,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(14,35,12,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(15,35,21,1,2,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(16,36,10,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(17,36,20,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(18,36,24,1,2,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(19,37,9,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(20,37,11,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(21,37,29,1,2,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(22,38,4,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(23,38,16,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(24,38,25,1,2,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(25,39,2,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(26,39,18,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(27,39,28,1,2,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(28,40,3,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(29,40,17,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(30,40,27,1,2,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(31,41,1,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(32,41,15,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(33,42,27,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(34,42,12,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(35,43,9,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(36,43,29,1,1,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(37,43,20,1,2,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(38,44,8,1,0,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(41,45,19,2,0,'2026-09-22 06:38:57','2026-09-22 06:38:57');
/*!40000 ALTER TABLE `bundle_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('lunara-silver-cache-5c785c036466adea360111aa28563bfd556b5fba','i:1;',1790090541),('lunara-silver-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1790090541;',1790090541);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
INSERT INTO `cart_items` VALUES (22,11,40,4,850000.00,'2026-09-21 08:33:44','2026-09-21 08:34:31');
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carts_user_id_unique` (`user_id`),
  UNIQUE KEY `carts_session_id_unique` (`session_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (2,NULL,'WVZYfpOFpp02DRg6e7wK1pcTJ3G0GwFUXcPyab2qCdzr42iuU4zV84FOxLvSX7Kb','2026-09-20 04:55:30','2026-09-20 04:55:30'),(3,1,NULL,'2026-09-20 08:52:33','2026-09-20 08:52:33'),(11,4,NULL,'2026-09-21 08:33:44','2026-09-21 08:33:44');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,NULL,'Dây chuyền','day-chuyen',NULL,1,0,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(2,NULL,'Nhẫn','nhan',NULL,1,1,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(3,NULL,'Vòng tay','vong-tay',NULL,1,2,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(4,NULL,'Bộ trang sức','bo-trang-suc',NULL,1,3,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(5,NULL,'Set quà tặng','set-qua-tang',NULL,1,4,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(6,NULL,'Vàng','vang',NULL,0,0,'2026-09-21 09:00:04','2026-09-21 09:01:52'),(7,NULL,'Bông','bong',NULL,1,0,'2026-09-22 08:53:42','2026-09-22 08:53:42');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupon_usages`
--

DROP TABLE IF EXISTS `coupon_usages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_usages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupon_usages_coupon_id_order_id_unique` (`coupon_id`,`order_id`),
  KEY `coupon_usages_user_id_foreign` (`user_id`),
  KEY `coupon_usages_order_id_foreign` (`order_id`),
  CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`),
  CONSTRAINT `coupon_usages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon_usages`
--

LOCK TABLES `coupon_usages` WRITE;
/*!40000 ALTER TABLE `coupon_usages` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupon_usages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `minimum_order` decimal(15,2) DEFAULT NULL,
  `maximum_discount` decimal(15,2) DEFAULT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `usage_limit` int(10) unsigned DEFAULT NULL,
  `used_count` int(10) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_09_20_000001_create_catalog_tables',2),(5,'2026_09_20_000002_create_customer_tables',2),(6,'2026_09_20_000003_create_order_tables',2),(7,'2026_09_20_000004_create_engagement_tables',2),(8,'2026_09_20_000005_create_content_tables',2),(9,'2026_09_22_000001_create_order_management_tables',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item_components`
--

DROP TABLE IF EXISTS `order_item_components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_item_components` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_item_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `product_sku` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity_per_item` int(10) unsigned NOT NULL,
  `total_quantity` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_item_components_order_item_id_foreign` (`order_item_id`),
  KEY `order_item_components_product_id_foreign` (`product_id`),
  CONSTRAINT `order_item_components_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_item_components_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item_components`
--

LOCK TABLES `order_item_components` WRITE;
/*!40000 ALTER TABLE `order_item_components` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_item_components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,4,'Dây chuyền Lunara Tinh Quang Chuyển Động','LNS-DC004',450000.00,1,450000.00,'2026-09-20 08:16:03','2026-09-20 08:16:03'),(2,2,44,'Lunara Gift Box – Sinh Nhật Lấp Lánh','LNS-GIFT004',340000.00,1,340000.00,'2026-09-20 08:54:09','2026-09-20 08:54:09'),(3,2,43,'Lunara Gift Box – Trọn Vẹn Yêu Thương','LNS-GIFT003',1050000.00,1,1050000.00,'2026-09-20 08:54:09','2026-09-20 08:54:09'),(4,3,3,'Dây chuyền Lunara Ái Tinh Hồn','LNS-DC003',370000.00,1,370000.00,'2026-09-20 21:21:15','2026-09-20 21:21:15'),(5,3,41,'Lunara Gift Box – Dịu Dàng','LNS-GIFT001',600000.00,2,1200000.00,'2026-09-20 21:21:15','2026-09-20 21:21:15');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status_histories`
--

DROP TABLE IF EXISTS `order_status_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status_histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `from_status` varchar(255) DEFAULT NULL,
  `to_status` varchar(255) NOT NULL,
  `changed_by` bigint(20) unsigned DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_status_histories_order_id_foreign` (`order_id`),
  KEY `order_status_histories_changed_by_foreign` (`changed_by`),
  CONSTRAINT `order_status_histories_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_status_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status_histories`
--

LOCK TABLES `order_status_histories` WRITE;
/*!40000 ALTER TABLE `order_status_histories` DISABLE KEYS */;
INSERT INTO `order_status_histories` VALUES (1,3,'pending','confirmed',4,NULL,'2026-09-22 08:45:47'),(2,3,'confirmed','processing',4,NULL,'2026-09-22 08:45:55'),(3,3,'processing','shipping',4,NULL,'2026-09-22 08:46:02'),(4,3,'shipping','completed',4,NULL,'2026-09-22 08:46:08'),(5,2,'pending','confirmed',4,NULL,'2026-09-22 08:55:37'),(6,2,'confirmed','processing',4,NULL,'2026-09-22 08:55:49'),(7,2,'processing','shipping',4,NULL,'2026-09-22 08:56:01'),(8,2,'shipping','completed',4,NULL,'2026-09-22 08:56:15');
/*!40000 ALTER TABLE `order_status_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `order_code` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(30) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_note` text DEFAULT NULL,
  `shipping_method` varchar(30) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_code_unique` (`order_code`),
  KEY `orders_user_id_index` (`user_id`),
  KEY `orders_order_status_index` (`order_status`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,NULL,'LNS-20260920-DW7ZVI','Nguyễn Tấn Mạnh','tanmhnsnguyen@gmail.com','033224231','sdaddasds','Hồ Chí Minh',NULL,'standard',450000.00,0.00,0.00,450000.00,'cod','pending','pending',NULL,NULL,'2026-09-20 08:16:03','2026-09-20 08:16:03','2026-09-20 08:16:03'),(2,1,'LNS-20260920-AUGCUT','Nguyễn Tấn Mạnh','tanmanhnsnguyen@gmail.com','0332247231','3070, Phạm Thế Hiển','Hồ Chí Minh',NULL,'standard',1390000.00,0.00,0.00,1390000.00,'cod','paid','completed',NULL,NULL,'2026-09-20 08:54:09','2026-09-20 08:54:09','2026-09-22 08:56:15'),(3,1,'LNS-20260921-TPGMTO','Nguyễn Tấn Mạnh','tanmanhnsnguyen@gmail.com','0332247231','Đại học Tôn Đức Thắng','Hồ Chí Minh',NULL,'standard',1570000.00,0.00,0.00,1570000.00,'cod','paid','completed',NULL,NULL,'2026-09-20 21:21:15','2026-09-20 21:21:15','2026-09-22 08:46:08');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `provider` varchar(30) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `request_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`request_data`)),
  `response_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response_data`)),
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_order_id_unique` (`order_id`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,'cod',NULL,450000.00,'pending',NULL,NULL,NULL,'2026-09-20 08:16:03','2026-09-20 08:16:03'),(2,2,'cod',NULL,1390000.00,'paid',NULL,NULL,'2026-09-22 08:56:15','2026-09-20 08:54:09','2026-09-22 08:56:15'),(3,3,'cod',NULL,1570000.00,'paid',NULL,NULL,'2026-09-22 08:46:08','2026-09-20 21:21:15','2026-09-22 08:46:08');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_categories`
--

DROP TABLE IF EXISTS `post_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_categories`
--

LOCK TABLES `post_categories` WRITE;
/*!40000 ALTER TABLE `post_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_category_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `image_url` text DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_post_category_id_foreign` (`post_category_id`),
  CONSTRAINT `posts_post_category_id_foreign` FOREIGN KEY (`post_category_id`) REFERENCES `post_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `cloudinary_public_id` varchar(255) DEFAULT NULL,
  `image_url` text NOT NULL,
  `image_role` varchar(20) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `alt_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_index` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,1,NULL,'media/Product/dc001.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(2,2,NULL,'media/Product/dc002.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(3,3,NULL,'media/Product/dc003.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(4,4,NULL,'media/Product/dc004.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(5,5,NULL,'media/Product/dc005.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(6,6,NULL,'media/Product/dc006.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(7,7,NULL,'media/Product/dc007.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(8,8,NULL,'media/Product/dc008.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(9,9,NULL,'media/Product/dc009.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(10,10,NULL,'media/Product/dc0010.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(11,11,NULL,'media/Product/nh001.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(12,12,NULL,'media/Product/nh002.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(13,13,NULL,'media/Product/nh003.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(14,14,NULL,'media/Product/nh004.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(15,15,NULL,'media/Product/nh005.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(16,16,NULL,'media/Product/nh006.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(17,17,NULL,'media/Product/nh007.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(18,18,NULL,'media/Product/nh008.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(19,19,NULL,'media/Product/nh009.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(20,20,NULL,'media/Product/nh0010.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(21,21,NULL,'media/Product/vt001.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(22,22,NULL,'media/Product/vt002.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(23,23,NULL,'media/Product/vt003.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(24,24,NULL,'media/Product/vt004.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(25,25,NULL,'media/Product/vt005.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(26,26,NULL,'media/Product/vt006.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(27,27,NULL,'media/Product/vt007.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(28,28,NULL,'media/Product/vt008.jpg','primary',0,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03'),(29,29,NULL,'media/Product/vt009.jpg','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(30,30,NULL,'media/Product/vt0010.jpg','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(31,31,NULL,'media/Collection/set 1(1).jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(32,31,NULL,'media/Collection/set 1(2).png','hover',1,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(33,32,NULL,'media/Collection/set 2(1).jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(34,32,NULL,'media/Collection/set 2(2).jpg.png','hover',1,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(35,33,NULL,'media/Collection/set 3(1).jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(36,33,NULL,'media/Collection/set 3(2).jpg.png','hover',1,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(37,34,NULL,'media/Collection/set 4(1).jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(38,34,NULL,'media/Collection/set 4(2).jpg.png','hover',1,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(39,35,NULL,'media/Collection/set 5(1).jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(40,35,NULL,'media/Collection/set 5(2).jpg.png','hover',1,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(41,36,NULL,'media/Collection/set 6(2).jpg.png','hover',1,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(42,37,NULL,'media/Collection/set 7(1).jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(43,37,NULL,'media/Collection/set 7(2).jpg.png','hover',1,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(44,38,NULL,'media/Collection/set 8(1).jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(45,38,NULL,'media/Collection/set 8(2).jpg.png','hover',1,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(46,39,NULL,'media/Collection/set 9(1).jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(47,39,NULL,'media/Collection/set 9(2).jpg.png','hover',1,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(48,40,NULL,'media/Collection/set 10(1).jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(49,40,NULL,'media/Collection/set 10(2).jpg.png','hover',1,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(50,41,NULL,'media/Gift/set qua 1.jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(51,42,NULL,'media/Gift/set qua 2.jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(52,43,NULL,'media/Gift/set qua 3.jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(53,44,NULL,'media/Gift/set qua 4.jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(54,45,NULL,'media/Gift/set qua 5.jpg.png','primary',0,NULL,'2026-09-20 02:51:04','2026-09-20 02:51:04'),(55,36,NULL,'media/Collection/set 6(1).jpg.png','primary',0,NULL,'2026-09-20 02:53:55','2026-09-20 02:53:55');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `sku` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `product_type` varchar(20) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `regular_price` decimal(15,2) NOT NULL,
  `sale_price` decimal(15,2) DEFAULT NULL,
  `stock_quantity` int(10) unsigned NOT NULL DEFAULT 0,
  `stock_status` varchar(20) NOT NULL DEFAULT 'out_of_stock',
  `material` varchar(255) DEFAULT NULL,
  `stone` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `size_info` text DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sold_count` int(10) unsigned NOT NULL DEFAULT 0,
  `view_count` int(10) unsigned NOT NULL DEFAULT 0,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_index` (`category_id`),
  KEY `products_product_type_index` (`product_type`),
  KEY `products_is_active_index` (`is_active`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'LNS-DC001','Dây chuyền Lunara Thái Dương Lam','day-chuyen-lunara-thai-duong-lam','single','Mặt trời và đá lam mạnh mẽ, chữa lành','Tên gọi thể hiện sự kết hợp giữa mặt trời tỏa sáng rực rỡ và viên đá xanh lam (lam) làm tâm điểm, mang lại vẻ đẹp mạnh mẽ nhưng cũng đầy sự chữa lành của đại dương và bầu trời.',450000.00,390000.00,18,'in_stock','Bạc 925 đính đá Sapphire xanh','Sapphire xanh','3.2g','45cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 21:21:15',NULL),(2,1,'LNS-DC002','Dây chuyền Lunara Tinh Tú Hoàn','day-chuyen-lunara-tinh-tu-hoan','single','Vòng tròn đá nạm hoàn hảo, vĩnh cửu','Một vòng tròn nạm đá kim cương hoàn hảo, tượng trưng cho một vòng tuần hoàn vĩnh cửu của các vì tinh tú trên bầu trời, tinh tế và không bao giờ kết thúc.',400000.00,350000.00,25,'in_stock','Bạc 925 đính đá kim cương nhân tạo (CZ)','CZ (mô phỏng kim cương)','2.6g','42cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(3,1,'LNS-DC003','Dây chuyền Lunara Ái Tinh Hồn','day-chuyen-lunara-ai-tinh-hon','single','Trái tim đính đá Moissanite rực rỡ','Kết hợp hình ảnh trái tim nạm đá lấp lánh với viên đá moissanite lớn ở trung tâm, tượng trưng cho tâm hồn tinh khiết và tình yêu cháy bỏng, rực rỡ như một ngôi sao.',420000.00,370000.00,21,'in_stock','Bạc 925 đính đá Moissanite','Moissanite','3.0g','44cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 21:21:15',NULL),(4,1,'LNS-DC004','Dây chuyền Lunara Tinh Quang Chuyển Động','day-chuyen-lunara-tinh-quang-chuyen-dong','single','Xoắn ốc ánh sáng quanh đá trung tâm','Tên gọi gợi tả sự xoắn ốc (swirl) nạm đá bao quanh viên đá moissanite trung tâm, như một dòng chảy ánh sáng (tinh quang) đang không ngừng chuyển động và tỏa sáng.',520000.00,450000.00,14,'in_stock','Bạc 925 đính đá Moissanite','Moissanite','3.5g','45cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 08:16:03',NULL),(5,1,'LNS-DC005','Dây chuyền Lunara Thiên Vũ Chòm Sao','day-chuyen-lunara-thien-vu-chom-sao','single','Vũ trụ thu nhỏ với nhiều charm sao','Một thiết kế phức tạp với nhiều charm sao, hành tinh và viên đá pha lê màu xanh, tượng trưng cho cả một vũ trụ thu nhỏ, một thiên hà rực rỡ với các chòm sao kỳ vĩ ngự trị trên ngực người đeo.',480000.00,420000.00,18,'in_stock','Bạc 925 đính pha lê xanh','Pha lê xanh','3.8g','46cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(6,1,'LNS-DC006','Dây chuyền Lunara Phấn Ngôi Sao Lấp Lánh','day-chuyen-lunara-phan-ngoi-sao-lap-lanh','single','Đá hồng phấn giữa ngôi sao lấp lánh','Nổi bật với viên đá moissanite màu hồng phấn ở tâm của một ngôi sao lấp lánh phức tạp, mang lại vẻ đẹp mềm mại, nữ tính và lãng mạn nhất.',530000.00,460000.00,14,'in_stock','Bạc 925 đính đá Moissanite hồng phấn','Moissanite hồng','3.4g','44cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(7,1,'LNS-DC007','Dây chuyền Lunara Hạo Nguyệt Ôm Hừng','day-chuyen-lunara-hao-nguyet-om-hung','single','Trăng khuyết ôm lấy ánh sáng hừng đông','\"Mặt trăng ôm lấy ánh sáng hừng đông\". Thiết kế vầng trăng khuyết nạm đá ôm lấy một viên đá moissanite cabochon lớn màu trắng mờ, gợi nhớ đến ánh trăng dịu dàng và tinh khiết như sương.',460000.00,400000.00,20,'in_stock','Bạc 925 đính đá Moissanite cabochon','Moissanite trắng mờ','2.9g','43cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(8,1,'LNS-DC008','Dây chuyền Lunara Băng Tinh Nguyệt Khuyết','day-chuyen-lunara-bang-tinh-nguyet-khuyet','single','Trăng khuyết với tinh thể đá trong như băng','Vầng trăng khuyết nạm đá với một cụm đá nhỏ ở một góc, tượng trưng cho một vầng trăng được hình thành từ các tinh thể đá moissanite trong suốt và sắc sảo như băng.',440000.00,380000.00,23,'in_stock','Bạc 925 đính đá Moissanite','Moissanite','2.7g','42cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 08:54:09',NULL),(9,1,'LNS-DC009','Dây chuyền Lunara Thanh Nguyệt Sao Tinh','day-chuyen-lunara-thanh-nguyet-sao-tinh','single','Trăng khuyết trơn cùng ngôi sao nạm đá','\"Mặt trăng trơn và các ngôi sao đôi\". Thiết kế mặt trăng khuyết trơn đánh bóng với một ngôi sao nhỏ nạm đá treo trong lòng, thể hiện nét đẹp cổ điển, thanh lịch và thanh khiết.',540000.00,470000.00,11,'in_stock','Bạc 925 đánh bóng, đính đá nhỏ','Đá nhỏ (CZ)','3.6g','45cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 08:54:09',NULL),(10,1,'LNS-DC010','Dây chuyền Lunara Lưu Tinh Tuyến Cong','day-chuyen-lunara-luu-tinh-tuyen-cong','single','Dải sao chổi cong lấp lánh đá và sao','Một cụm gồm nhiều viên đá moissanite và ngôi sao xếp thành một dải cong tinh xảo, tựa như một dải sao chổi hoặc dải thiên hà (lưu tinh tuyến) đang chuyển động trên bầu trời đêm.',490000.00,430000.00,17,'in_stock','Bạc 925 đính đá Moissanite','Moissanite','3.3g','44cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(11,2,'LNS-NH001','Nhẫn Lunara Nguyệt Tinh','nhan-lunara-nguyet-tinh','single','Trăng khuyết và vì sao trơn tinh tế','Sự kết hợp nguyên bản và tinh tế nhất giữa trăng khuyết và một vì sao. Thiết kế trơn đơn giản mang vẻ đẹp thanh lịch, nguyên sơ của bầu trời đêm.',290000.00,250000.00,35,'in_stock','Bạc 925','-','1.8g','6-9 (điều chỉnh được)',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(12,2,'LNS-NH002','Nhẫn Lunara Song Tinh','nhan-lunara-song-tinh','single','Nhẫn hở hai ngôi sao gắn kết','Thiết kế nhẫn hở với hai ngôi sao (một đính đá lấp lánh, một tinh giản rỗng ruột) tượng trưng cho sự gắn kết, đồng hành tỏa sáng.',400000.00,350000.00,20,'in_stock','Bạc 925 (một bên đính đá)','CZ nhỏ (1 bên)','2.2g','6-9',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(13,2,'LNS-NH003','Nhẫn Lunara Lam Dạ','nhan-lunara-lam-da','single','Đá Sapphire xanh thẳm bí ẩn quyến rũ','\"Đêm xanh mờ ảo\". Điểm nhấn viên đá sapphire xanh thẳm đặt trong lòng vì sao, e ấp bên mặt trăng nạm đá lấp lánh, mang lại vẻ đẹp bí ẩn và quyến rũ.',300000.00,260000.00,30,'in_stock','Bạc 925 đính đá Sapphire xanh','Sapphire xanh','1.9g','6-9',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(14,2,'LNS-NH004','Nhẫn Lunara Vũ Trụ','nhan-lunara-vu-tru','single','Dải sáng quanh đá như hành tinh thu nhỏ','Thiết kế có họa tiết dải sáng bao quanh viên đá (giống như sao Thổ/hành tinh) cùng các vì sao nhỏ, tượng trưng cho một vũ trụ thu nhỏ ngự trị trên ngón tay người đeo.',310000.00,270000.00,28,'in_stock','Bạc 925 đính đá + charm sao nhỏ','CZ','1.7g','6-9',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(15,2,'LNS-NH005','Nhẫn Lunara Tinh Thủy','nhan-lunara-tinh-thuy','single','Đá ngọc bích trong trẻo cùng vì sao','Sự kết hợp giữa viên đá màu xanh ngọc bích trong trẻo như giọt nước (thủy) và các vì sao (tinh). Cảm giác mang lại sự chữa lành, thanh khiết và rạng rỡ.',320000.00,280000.00,24,'in_stock','Bạc 925 đính đá Ngọc bích (Jade)','Ngọc bích xanh','2.0g','6-9',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 21:21:15',NULL),(16,2,'LNS-NH006','Nhẫn Lunara Quỹ Đạo','nhan-lunara-quy-dao','single','Đai kép vắt chéo như quỹ đạo sao','Thiết kế nhẫn đai kép vắt chéo nhau tựa như quỹ đạo của các vì sao xoay quanh mặt trăng, thể hiện một nét đẹp hiện đại và độc đáo.',280000.00,240000.00,32,'in_stock','Bạc 925','-','2.1g','Free size',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(17,2,'LNS-NH007','Nhẫn Lunara Bạch Nguyệt','nhan-lunara-bach-nguyet','single','Đá cabochon tròn như trăng rằm dịu dàng','\"Mặt trăng trắng\". Điểm nhấn là viên đá to bản bo tròn (cabochon) gợi nhớ đến vầng trăng rằm tỏa sáng dịu dàng, được che chở bởi vầng trăng khuyết phía trên.',370000.00,320000.00,15,'in_stock','Bạc 925 đính đá cabochon','Đá trắng (cabochon)','1.6g','6-9',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(18,2,'LNS-NH008','Nhẫn Lunara Dạ Khúc','nhan-lunara-da-khuc','single','Trăng khuyết to bản nạm 3 đá nhỏ','Khúc hát của đêm. Vầng trăng khuyết to bản được nạm thêm 3 viên đá nhỏ, đi kèm ngôi sao lấp lánh tạo nên sự mềm mại, sắc sảo nhưng không kém phần thơ mộng.',270000.00,230000.00,33,'in_stock','Bạc 925 đính 3 đá nhỏ + sao','CZ nhỏ','1.5g','6-9',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(19,2,'LNS-NH009','Nhẫn Lunara Ngân Hà','nhan-lunara-ngan-ha','single','Nhẫn đính dải ngôi sao lấp lánh như ngân hà','Chiếc nhẫn đính hàng loạt ngôi sao lớn nhỏ lấp lánh dọc thân, tựa như bạn đang mang trọn một dải ngân hà rực rỡ trên tay.',330000.00,290000.00,26,'in_stock','Bạc 925 đính nhiều đá nhỏ (dải ngôi sao)','CZ nhỏ (dải sao)','2.0g','6-9 (điều chỉnh được)',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(20,2,'LNS-NH010','Nhẫn Lunara Bắc Đẩu','nhan-lunara-bac-dau','single','Ngôi sao 8 cánh dẫn đường, kiên định','Ngôi sao 8 cánh mang hình dáng của la bàn hay sao Bắc Đẩu - ngôi sao sáng nhất và có nhiệm vụ dẫn đường. Mang thông điệp về sự kiên định và ánh sáng rực rỡ nhất của người đeo.',340000.00,300000.00,23,'in_stock','Bạc 925','-','2.0g','6-9',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 08:54:09',NULL),(21,3,'LNS-VT001','Vòng Lunara Nguyệt Hồng','vong-lunara-nguyet-hong','single','Đá hồng cabochon trong lòng trăng khuyết','Nổi bật với viên đá hồng cabochon trong lòng vầng trăng khuyết, tượng trưng cho ánh trăng hồng dịu dàng và tình yêu nồng thắm.',390000.00,340000.00,22,'in_stock','Bạc 925 đính đá cabochon hồng','Đá hồng (cabochon)','3.8g','17cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(22,3,'LNS-VT002','Vòng Lunara Hành Tinh','vong-lunara-hanh-tinh','single','Hình ảnh hành tinh có vành đai bao quanh','Chiếc vòng mang hình ảnh một hành tinh chi tiết với vành đai bao quanh (như Sao Thổ), được bao quanh bởi nhiều ngôi sao nhỏ, tượng trưng cho vẻ đẹp bí ẩn và bao la của vũ trụ.',350000.00,300000.00,26,'in_stock','Bạc 925 đính đá, charm hành tinh','CZ nhỏ','4.0g','16-18cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(23,3,'LNS-VT003','Vòng Lunara Song Nguyệt','vong-lunara-song-nguyet','single','Charm trăng khuyết và sao đan xen','\"Hai Mặt Trăng\". Thiết kế vòng với nhiều charm hình trăng khuyết và sao đan xen dọc theo chuỗi, thể hiện sự lặp lại và kết nối của các chu kỳ thiên thể.',410000.00,360000.00,19,'in_stock','Bạc 925 nhiều charm trăng khuyết & sao','-','4.2g','17cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(24,3,'LNS-VT004','Vòng Lunara Tinh Tú','vong-lunara-tinh-tu','single','Một ngôi sao lớn làm tâm điểm','Tập trung vào một ngôi sao lớn, sắc nét làm tâm điểm, tỏa sáng rực rỡ và duy nhất, giống như ngôi sao dẫn đường Bắc Đẩu.',330000.00,280000.00,24,'in_stock','Bạc 925 đính đá charm sao lớn','CZ','3.5g','16-18cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(25,3,'LNS-VT005','Vòng Lunara Nhật Nguyệt','vong-lunara-nhat-nguyet','single','Đủ charm mặt trời, sao chổi, trăng khuyết','\"Mặt Trời và Mặt Trăng\". Chiếc vòng tuyệt đẹp tập hợp đầy đủ các charm: Mặt Trời tỏa sáng, một viên đá trong suốt (như Sao chổi), ngôi sao, và vầng trăng khuyết nhỏ, biểu thị sự hài hòa của trời đất.',400000.00,350000.00,21,'in_stock','Bạc 925 nhiều charm (mặt trời/sao/trăng)','Đá trong suốt (CZ)','4.1g','17cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(26,3,'LNS-VT006','Vòng Lunara Nguyệt Lam','vong-lunara-nguyet-lam','single','Đá cabochon xanh lam trong trăng khuyết','\"Mặt Trăng Xanh\". Điểm nhấn là viên đá cabochon màu xanh lam độc đáo trong lòng trăng khuyết nạm đá, gợi cảm giác về một đêm trăng xanh hiếm có và huyền ảo.',420000.00,370000.00,16,'in_stock','Bạc 925 đính đá cabochon xanh lam','Đá xanh lam (cabochon)','4.8g','16-18cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(27,3,'LNS-VT007','Vòng Lunara Thiên Hà','vong-lunara-thien-ha','single','Chuỗi hạt bạc đan xen charm sao trăng','\"Con đường Thiên hà\". Thiết kế vòng với chuỗi hạt bạc rải rác đan xen các charm sao và trăng nhỏ, tựa như một con đường lấp lánh băng qua các vì sao.',360000.00,310000.00,23,'in_stock','Bạc 925 chuỗi hạt + charm sao trăng','-','3.6g','17cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(28,3,'LNS-VT008','Vòng Lunara Đa Tinh','vong-lunara-da-tinh','single','Hàng loạt charm sao với đá trung tâm','\"Nhiều Ngôi Sao\". Vòng có hàng loạt các charm sao lấp lánh (với một viên đá trung tâm lớn hơn) dọc theo chuỗi, tượng trưng cho một bầu trời đêm dày đặc sao.',340000.00,290000.00,27,'in_stock','Bạc 925 nhiều charm sao đính đá','CZ','3.9g','16-18cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(29,3,'LNS-VT009','Vòng Lunara Thiên Đàng','vong-lunara-thien-dang','single','Charm trăng khuyết và sao lộng lẫy','\"Cung điện Thiên đàng\". Chiếc vòng với các charm vầng trăng khuyết và sao lấp lánh (nạm đá) được sắp xếp vui tươi và lộng lẫy, tựa như các vì tinh tú nơi thiên đường.',460000.00,400000.00,13,'in_stock','Bạc 925 nhiều charm nạm đá','CZ nhỏ','5.0g','17cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 08:54:09',NULL),(30,3,'LNS-VT010','Vòng Lunara Thiên Cơ','vong-lunara-thien-co','single','Charm hành tinh cơ khí cùng vành đai và sao','\"Kỳ quan Thiên thể\". Charm trung tâm phức tạp, kết hợp một viên đá cabochon lớn làm hành tinh với các vành đai và ngôi sao xung quanh, như một kỳ quan cơ khí của vũ trụ.',440000.00,380000.00,16,'in_stock','Bạc 925 đính đá cabochon lớn + charm','Đá cabochon lớn','4.6g','16-18cm',0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(31,4,'LNS-SET001','Bản Giao Hưởng Vũ Trụ','ban-giao-huong-vu-tru','collection','LNS-DC005 (Thiên Vũ Chòm Sao); LNS-NH004 (Vũ Trụ); LNS-VT002 (Hành Tinh)','Chủ đề: Vũ Trụ Vô Tận',840000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(32,4,'LNS-SET002','Ánh Trăng Tinh Khôi','anh-trang-tinh-khoi','collection','LNS-DC007 (Hạo Nguyệt Ôm Hừng); LNS-NH007 (Bạch Nguyệt Cabochon); LNS-VT003 (Song Nguyệt)','Chủ đề: Dịu Dàng Đá Trắng Moonstone',920000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(33,4,'LNS-SET003','Giọt Ngân Hà','giot-ngan-ha','collection','LNS-DC008 (Băng Tinh Nguyệt Khuyết); LNS-NH005 (Tinh Thủy); LNS-VT010 (Thiên Cơ)','Chủ đề: Xanh Ngọc Bích & Cabochon',880000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(34,4,'LNS-SET004','Lam Dạ Bí Ẩn','lam-da-bi-an','collection','LNS-DC001 (Thái Dương Lam); LNS-NH003 (Lam Dạ); LNS-VT006 (Nguyệt Lam)','Chủ đề: Sang Trọng Sapphire',870000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(35,4,'LNS-SET005','Giấc Mơ Hồng','giac-mo-hong','collection','LNS-DC006 (Phấn Ngôi Sao); LNS-NH002 (Song Tinh Bạc); LNS-VT001 (Nguyệt Hồng)','Chủ đề: Ngọt Ngào Đá Hồng Phấn',980000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(36,4,'LNS-SET006','Bắc Đẩu Tỏa Sáng','bac-dau-toa-sang','collection','LNS-DC010 (Lưu Tinh Tuyến Cong); LNS-NH010 (Bắc Đẩu); LNS-VT004 (Tinh Tú)','Chủ đề: Sức Mạnh Ngôi Sao',860000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(37,4,'LNS-SET007','Nguyên Bản Cổ Điển','nguyen-ban-co-dien','collection','LNS-DC009 (Thanh Nguyệt Sao Tinh); LNS-NH001 (Nguyệt Tinh Bạc Trơn); LNS-VT009 (Thiên Đàng)','Chủ đề: Thiên Đàng Đa Dạng',950000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(38,4,'LNS-SET008','Nhật Nguyệt Giao Hòa','nhat-nguyet-giao-hoa','collection','LNS-DC004 (Tinh Quang Chuyển Động); LNS-NH006 (Quỹ Đạo); LNS-VT005 (Nhật Nguyệt)','Chủ đề: Hài Hòa Trời Đất',880000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(39,4,'LNS-SET009','Dải Tinh Không','dai-tinh-khong','collection','LNS-DC002 (Tinh Tú Hoàn); LNS-NH008 (Dạ Khúc bản to); LNS-VT008 (Đa Tinh)','Chủ đề: Lộng Lẫy Moissanite',740000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(40,4,'LNS-SET010','Khúc Tình Ca Bầu Trời','khuc-tinh-ca-bau-troi','collection','LNS-DC003 (Ái Tinh Hồn); LNS-NH007 (Bạch Nguyệt); LNS-VT007 (Thiên Hà Trơn)','Chủ đề: Tình Yêu & Moonstone',850000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(41,5,'LNS-GIFT001','Lunara Gift Box – Dịu Dàng','lunara-gift-box-diu-dang','gift','LNS-DC001 (Thái Dương Lam); LNS-NH005 (Tinh Thủy)','Giá đã gồm chiết khấu ~10% + hộp quà, túi vải, thiệp chúc tặng kèm',600000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(42,5,'LNS-GIFT002','Lunara Gift Box – Tỏa Sáng','lunara-gift-box-toa-sang','gift','LNS-VT007 (Thiên Hà); LNS-NH002 (Song Tinh)','Giá đã gồm chiết khấu ~10% + hộp quà cao cấp',590000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(43,5,'LNS-GIFT003','Lunara Gift Box – Trọn Vẹn Yêu Thương','lunara-gift-box-tron-ven-yeu-thuong','gift','LNS-DC009 (Thanh Nguyệt Sao Tinh); LNS-VT009 (Thiên Đàng); LNS-NH010 (Bắc Đẩu)','Set quà tặng cao cấp nhất — giá đã gồm chiết khấu ~10%',1050000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(44,5,'LNS-GIFT004','Lunara Gift Box – Sinh Nhật Lấp Lánh','lunara-gift-box-sinh-nhat-lap-lanh','gift','LNS-DC008 (Băng Tinh Nguyệt Khuyết) + charm mini (không bán lẻ) + nến thơm mini (không bán lẻ)','Giá thấp hơn giá lẻ dây chuyền gốc dù tặng kèm charm mini + nến thơm',340000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-20 02:51:03',NULL),(45,5,'LNS-GIFT005','Lunara Gift Box – Đôi Ta','lunara-gift-box-doi-ta','gift','2 × LNS-NH001 (Nhẫn Nguyệt Tinh) — mỗi người 1 chiếc, thiết kế trơn tối giản phù hợp làm nhẫn đôi','Giá đã gồm chiết khấu ~10% + hộp đôi thiết kế riêng',450000.00,NULL,0,'out_of_stock',NULL,NULL,NULL,NULL,0,1,0,0,NULL,NULL,'2026-09-20 02:51:03','2026-09-22 06:38:57',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL,
  `comment` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('XXD6Q6TgKTweW3sGd9Rhx0OTt6esgZjNFd1tfA2x',4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYVRZaWgxM0Z5SzJiak42anhhbVEzaXlndDIzTHAwU292WHNGVG14dSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==',1790092707),('yY2rIPTFBGeOZe8k8W28MrAdUMYF56uXl7WrKYTn',4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU1ZRYzI2WlkyQ0tLQW5yVlRtMk1hNzI2azFwMFRYRFRIb2VQZXpRVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9',1790092689);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'string',
  `group` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Nguyễn Tấn Mạnh','tanmanhnsnguyen@gmail.com',NULL,'$2y$12$LamWRaS.qMhPFuMGPCfVheBl.AaNOBYTWlI68JeJY7x4Z9C86mTlC','user',NULL,'2026-09-20 08:52:33','2026-09-20 08:52:33'),(4,'Quản trị viên Lunara','admin@lunara.vn',NULL,'$2y$12$nEmmdbgwjpk097HNyFrm6uORsBR.N.wiUeqPKMIpjkppUVvKv99HC','admin',NULL,'2026-09-21 08:24:55','2026-09-21 08:24:55');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  KEY `wishlists_product_id_foreign` (`product_id`),
  CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-23 11:04:33
