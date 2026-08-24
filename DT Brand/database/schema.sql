-- ==============================================================================
-- DT BRAND'S & JAI HANUMAN TEX — MASTER PRODUCTION DATABASE SCHEMA
-- Version: 3.0.0 Clean Architecture Edition
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
    `image` VARCHAR(255) DEFAULT '/assets/images/product1.png',
    `banner_image` VARCHAR(255) DEFAULT '/assets/images/hero-banner.png',
    `products_count` INT DEFAULT 0,
    `display_order` INT DEFAULT 1,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 2. PRODUCTS TABLE ──
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
    INDEX `idx_category` (`category_id`),
    INDEX `idx_sku` (`sku`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 3. CUSTOMERS & USERS TABLE ──
CREATE TABLE IF NOT EXISTS `customers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL UNIQUE,
    `email` VARCHAR(150),
    `password_hash` VARCHAR(255) NOT NULL,
    `company_name` VARCHAR(150),
    `gst_number` VARCHAR(20),
    `type` ENUM('retail', 'wholesale', 'reseller', 'retailer') DEFAULT 'retail',
    `status` ENUM('active', 'pending_approval', 'suspended') DEFAULT 'active',
    `tier` VARCHAR(50) DEFAULT 'Standard',
    `city` VARCHAR(100),
    `state` VARCHAR(100),
    `pincode` VARCHAR(10),
    `address` TEXT,
    `credit_limit` DECIMAL(10,2) DEFAULT 0.00,
    `outstanding_balance` DECIMAL(10,2) DEFAULT 0.00,
    `reseller_commission_rate` DECIMAL(5,2) DEFAULT 10.00,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 4. ORDERS TABLE ──
CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_number` VARCHAR(50) NOT NULL UNIQUE,
    `customer_id` INT DEFAULT 0,
    `customer_name` VARCHAR(150) NOT NULL,
    `customer_phone` VARCHAR(20) NOT NULL,
    `channel` ENUM('retail', 'wholesale', 'reseller', 'whatsapp') DEFAULT 'retail',
    `subtotal` DECIMAL(10,2) NOT NULL,
    `discount` DECIMAL(10,2) DEFAULT 0.00,
    `gst_rate` DECIMAL(4,2) DEFAULT 5.00,
    `gst_amount` DECIMAL(10,2) DEFAULT 0.00,
    `shipping_fee` DECIMAL(10,2) DEFAULT 0.00,
    `total_amount` DECIMAL(10,2) NOT NULL,
    `payment_method` VARCHAR(50) DEFAULT 'razorpay',
    `payment_status` ENUM('pending', 'paid', 'failed', 'cod') DEFAULT 'paid',
    `fulfillment_status` ENUM('pending', 'confirmed', 'processing', 'dispatched', 'delivered', 'cancelled') DEFAULT 'confirmed',
    `tracking_number` VARCHAR(100),
    `courier_name` VARCHAR(100) DEFAULT 'Delhivery Express',
    `shipping_address` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 5. ORDER ITEMS TABLE ──
CREATE TABLE IF NOT EXISTS `order_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `product_name` VARCHAR(255) NOT NULL,
    `sku` VARCHAR(50),
    `lot_type` VARCHAR(50) DEFAULT 'single',
    `quantity` INT NOT NULL DEFAULT 1,
    `unit_price` DECIMAL(10,2) NOT NULL,
    `total_price` DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6. REVIEWS TABLE ──
CREATE TABLE IF NOT EXISTS `reviews` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `customer_name` VARCHAR(100) NOT NULL,
    `rating` INT NOT NULL DEFAULT 5,
    `review_text` TEXT NOT NULL,
    `city` VARCHAR(100),
    `status` ENUM('approved', 'pending', 'rejected') DEFAULT 'approved',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
