-- ==============================================================================
-- DT BRAND'S & JAI HANUMAN TEX — MASTER PRODUCTION DATABASE SCHEMA
-- Version: 3.2.0 Complete Unified Production Schema
-- Target: MySQL 8.0+ / MariaDB / Hostinger Live Production
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+05:30";

-- ── 1. CATEGORIES TABLE ──
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT,
    `image` VARCHAR(255) DEFAULT '/assets/images/category-sarees.png',
    `banner_image` VARCHAR(255) DEFAULT '/assets/images/hero-banner.png',
    `products_count` INT DEFAULT 0,
    `display_order` INT DEFAULT 1,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_cat_slug` (`slug`),
    INDEX `idx_cat_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 2. SUBCATEGORIES TABLE ──
CREATE TABLE IF NOT EXISTS `subcategories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_subcat_category` (`category_id`),
    INDEX `idx_subcat_slug` (`slug`),
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 3. PRODUCTS TABLE ──
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sku` VARCHAR(50) NOT NULL UNIQUE,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `category_id` INT DEFAULT 1,
    `category_name` VARCHAR(100) NOT NULL,
    `fabric` VARCHAR(100) DEFAULT 'Pure Silk',
    `weave` VARCHAR(100) DEFAULT 'Handloom Brocade',
    `zari_type` VARCHAR(100) DEFAULT 'Tested Gold Zari',
    `pallu_style` VARCHAR(100) DEFAULT 'Heavy Rich Zari Pallu',
    `blouse_piece` VARCHAR(100) DEFAULT 'Running Blouse Included (0.8m)',
    `occasion` VARCHAR(100) DEFAULT 'Bridal & Festive',
    `mrp` DECIMAL(10,2) NOT NULL,
    `retail_price` DECIMAL(10,2) NOT NULL,
    `wholesale_price` DECIMAL(10,2) NOT NULL,
    `reseller_price` DECIMAL(10,2) NOT NULL,
    `moq_single` INT DEFAULT 1,
    `moq_half_set` INT DEFAULT 4,
    `moq_full_set` INT DEFAULT 8,
    `moq_master_bale` INT DEFAULT 24,
    `stock_qty` INT DEFAULT 50,
    `rating` DECIMAL(2,1) DEFAULT 4.9,
    `reviews_count` INT DEFAULT 120,
    `primary_image` VARCHAR(255) NOT NULL,
    `badge` VARCHAR(50) DEFAULT 'Bestseller',
    `is_featured` TINYINT(1) DEFAULT 1,
    `is_bestseller` TINYINT(1) DEFAULT 1,
    `status` ENUM('in_stock', 'low_stock', 'out_of_stock', 'draft') DEFAULT 'in_stock',
    `description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_products_category` (`category_id`),
    INDEX `idx_products_sku` (`sku`),
    INDEX `idx_products_slug` (`slug`),
    INDEX `idx_products_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 4. PRODUCT MEDIA TABLE ──
CREATE TABLE IF NOT EXISTS `product_media` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `image_url` VARCHAR(255) NOT NULL,
    `is_primary` TINYINT(1) DEFAULT 0,
    `sort_order` INT DEFAULT 0,
    INDEX `idx_media_product` (`product_id`),
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 5. PRODUCT COLORS TABLE ──
CREATE TABLE IF NOT EXISTS `product_colors` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `hex_code` VARCHAR(10) NOT NULL,
    `swatch_image` VARCHAR(255) DEFAULT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6. PRODUCT SIZES TABLE ──
CREATE TABLE IF NOT EXISTS `product_sizes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `sort_order` INT DEFAULT 1,
    `status` ENUM('active', 'inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 7. PRODUCT VARIANTS TABLE ──
CREATE TABLE IF NOT EXISTS `product_variants` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `color_id` INT DEFAULT NULL,
    `color_name` VARCHAR(50) DEFAULT NULL,
    `size_id` INT DEFAULT NULL,
    `size_name` VARCHAR(50) DEFAULT NULL,
    `sku` VARCHAR(50) NOT NULL UNIQUE,
    `stock_qty` INT DEFAULT 10,
    `mrp` DECIMAL(10,2) DEFAULT NULL,
    `price` DECIMAL(10,2) DEFAULT NULL,
    `wholesale_price` DECIMAL(10,2) DEFAULT NULL,
    `reseller_price` DECIMAL(10,2) DEFAULT NULL,
    `image` VARCHAR(255) DEFAULT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_variant_product` (`product_id`),
    INDEX `idx_variant_color` (`color_id`),
    INDEX `idx_variant_size` (`size_id`),
    UNIQUE KEY `uniq_prod_color_size` (`product_id`, `color_id`, `size_id`),
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 8. CUSTOMERS TABLE ──
CREATE TABLE IF NOT EXISTS `customers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL UNIQUE,
    `email` VARCHAR(150),
    `password_hash` VARCHAR(255) DEFAULT NULL,
    `type` ENUM('retail', 'wholesale', 'reseller', 'retailer') DEFAULT 'retail',
    `city` VARCHAR(100),
    `state` VARCHAR(100),
    `tier` VARCHAR(50) DEFAULT 'Standard',
    `credit_limit` DECIMAL(12,2) DEFAULT 0.00,
    `outstanding_balance` DECIMAL(12,2) DEFAULT 0.00,
    `total_orders` INT DEFAULT 0,
    `lifetime_spend` DECIMAL(12,2) DEFAULT 0.00,
    `gstin` VARCHAR(20) DEFAULT NULL,
    `pan` VARCHAR(20) DEFAULT NULL,
    `kyc_status` ENUM('unverified', 'pending', 'verified', 'rejected') DEFAULT 'unverified',
    `commission_rate` DECIMAL(5,2) DEFAULT 0.00,
    `reset_token` VARCHAR(100) DEFAULT NULL,
    `reset_expires` TIMESTAMP NULL DEFAULT NULL,
    `last_login` TIMESTAMP NULL DEFAULT NULL,
    `status` ENUM('active', 'pending', 'suspended') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_cust_phone` (`phone`),
    INDEX `idx_cust_email` (`email`),
    INDEX `idx_cust_type` (`type`),
    INDEX `idx_cust_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 9. USERS / ADMIN STAFF TABLE ──
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `phone` VARCHAR(20) DEFAULT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('super_admin', 'admin', 'manager', 'staff') DEFAULT 'admin',
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `last_login` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 10. CUSTOMER ADDRESSES TABLE ──
CREATE TABLE IF NOT EXISTS `addresses` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT NOT NULL,
    `recipient_name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `address_line1` VARCHAR(255) NOT NULL,
    `address_line2` VARCHAR(255),
    `city` VARCHAR(100) NOT NULL,
    `state` VARCHAR(100) NOT NULL,
    `pincode` VARCHAR(10) NOT NULL,
    `address_type` ENUM('home', 'work', 'warehouse') DEFAULT 'home',
    `is_default` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_addr_customer` (`customer_id`),
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 11. CART ITEMS TABLE ──
CREATE TABLE IF NOT EXISTS `cart_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT DEFAULT NULL,
    `session_id` VARCHAR(100) NOT NULL,
    `product_id` INT NOT NULL,
    `variant_id` INT DEFAULT NULL,
    `color` VARCHAR(50) DEFAULT NULL,
    `size` VARCHAR(50) DEFAULT NULL,
    `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `quantity` INT NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_cart_session` (`session_id`),
    INDEX `idx_cart_customer` (`customer_id`),
    INDEX `idx_cart_variant` (`variant_id`),
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 12. WISHLIST ITEMS TABLE ──
CREATE TABLE IF NOT EXISTS `wishlist_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `variant_id` INT DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_wishlist_customer` (`customer_id`),
    INDEX `idx_wishlist_product` (`product_id`),
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 13. ORDERS TABLE ──
CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_number` VARCHAR(50) NOT NULL UNIQUE,
    `customer_id` INT DEFAULT NULL,
    `customer_name` VARCHAR(150) NOT NULL,
    `customer_phone` VARCHAR(20) NOT NULL,
    `customer_email` VARCHAR(150) DEFAULT NULL,
    `channel` ENUM('retail', 'wholesale', 'reseller', 'retailer', 'whatsapp') DEFAULT 'retail',
    `subtotal` DECIMAL(12,2) NOT NULL,
    `discount` DECIMAL(10,2) DEFAULT 0.00,
    `gst_rate` DECIMAL(4,2) DEFAULT 5.00,
    `gst_amount` DECIMAL(10,2) DEFAULT 0.00,
    `shipping_fee` DECIMAL(10,2) DEFAULT 0.00,
    `total_amount` DECIMAL(12,2) NOT NULL,
    `payment_method` ENUM('cod', 'razorpay', 'bank_transfer', 'wallet', 'credit') DEFAULT 'razorpay',
    `payment_status` ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    `order_status` ENUM('new', 'processing', 'packed', 'shipped', 'delivered', 'cancelled', 'returned') DEFAULT 'new',
    `shipping_address` TEXT NOT NULL,
    `shipping_city` VARCHAR(100) DEFAULT NULL,
    `shipping_state` VARCHAR(100) DEFAULT NULL,
    `shipping_pincode` VARCHAR(10) DEFAULT NULL,
    `awb_number` VARCHAR(50) DEFAULT NULL,
    `courier_partner` VARCHAR(50) DEFAULT NULL,
    `tracking_url` VARCHAR(255) DEFAULT NULL,
    `notes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_order_number` (`order_number`),
    INDEX `idx_order_customer` (`customer_id`),
    INDEX `idx_order_status` (`order_status`),
    INDEX `idx_order_payment` (`payment_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 14. ORDER ITEMS TABLE ──
CREATE TABLE IF NOT EXISTS `order_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `variant_id` INT DEFAULT NULL,
    `product_title` VARCHAR(255) NOT NULL,
    `sku` VARCHAR(50) NOT NULL,
    `color` VARCHAR(50) DEFAULT NULL,
    `size` VARCHAR(50) DEFAULT NULL,
    `unit_price` DECIMAL(10,2) NOT NULL,
    `quantity` INT NOT NULL DEFAULT 1,
    `subtotal` DECIMAL(12,2) NOT NULL,
    INDEX `idx_item_order` (`order_id`),
    INDEX `idx_item_product` (`product_id`),
    INDEX `idx_item_variant` (`variant_id`),
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 15. COUPONS TABLE ──
CREATE TABLE IF NOT EXISTS `coupons` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `title` VARCHAR(150) NOT NULL,
    `discount_type` ENUM('percentage', 'fixed') NOT NULL DEFAULT 'percentage',
    `discount_value` DECIMAL(10,2) NOT NULL,
    `min_order_amount` DECIMAL(10,2) DEFAULT 0.00,
    `max_discount` DECIMAL(10,2) DEFAULT NULL,
    `usage_limit` INT DEFAULT 1000,
    `used_count` INT DEFAULT 0,
    `channel` ENUM('all', 'retail', 'wholesale', 'reseller', 'retailer') DEFAULT 'all',
    `status` ENUM('active', 'inactive', 'expired') DEFAULT 'active',
    `starts_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `expires_at` DATETIME DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_coupon_code` (`code`),
    INDEX `idx_coupon_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 16. WEBHOOK EVENTS TABLE ──
CREATE TABLE IF NOT EXISTS `webhook_events` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `provider` VARCHAR(50) NOT NULL,
    `event_id` VARCHAR(150) NOT NULL UNIQUE,
    `payload` JSON NOT NULL,
    `signature_valid` TINYINT(1) DEFAULT 1,
    `status` ENUM('received', 'processing', 'processed', 'failed') DEFAULT 'received',
    `attempts` INT DEFAULT 1,
    `error` TEXT DEFAULT NULL,
    `received_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `processed_at` TIMESTAMP NULL DEFAULT NULL,
    INDEX `idx_webhook_provider` (`provider`),
    INDEX `idx_webhook_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 17. NOTIFICATIONS TABLE ──
CREATE TABLE IF NOT EXISTS `notifications` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT NULL,
    `customer_id` INT DEFAULT NULL,
    `type` VARCHAR(50) NOT NULL,
    `title` VARCHAR(150) NOT NULL,
    `message` TEXT NOT NULL,
    `link` VARCHAR(255) DEFAULT NULL,
    `is_read` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_notif_user` (`user_id`),
    INDEX `idx_notif_read` (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 18. AUDIT LOGS TABLE ──
CREATE TABLE IF NOT EXISTS `audit_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT NULL,
    `user_name` VARCHAR(100) DEFAULT 'system',
    `action` VARCHAR(100) NOT NULL,
    `entity_type` VARCHAR(50) NOT NULL,
    `entity_id` VARCHAR(50) NOT NULL,
    `old_values` JSON DEFAULT NULL,
    `new_values` JSON DEFAULT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `user_agent` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_audit_action` (`action`),
    INDEX `idx_audit_entity` (`entity_type`, `entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
