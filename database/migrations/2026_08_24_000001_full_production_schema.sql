-- Migration: 2026_08_24_000001_full_production_schema.sql
-- DT Brand's & Jai Hanuman Tex — Complete Enterprise Production Database Schema

SET FOREIGN_KEY_CHECKS = 0;

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
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `subcategories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS `product_media` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `image_url` VARCHAR(255) NOT NULL,
    `is_primary` TINYINT(1) DEFAULT 0,
    `sort_order` INT DEFAULT 0,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `banners` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150) NOT NULL,
    `subtitle` VARCHAR(255),
    `tagline` VARCHAR(100),
    `badge` VARCHAR(50),
    `cta_text` VARCHAR(50) DEFAULT 'Shop Wholesale Now',
    `cta_link` VARCHAR(255) DEFAULT '/shop',
    `image_url` VARCHAR(255) NOT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `display_order` INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `customers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL UNIQUE,
    `email` VARCHAR(150),
    `type` ENUM('retail', 'wholesale', 'reseller') DEFAULT 'retail',
    `city` VARCHAR(100),
    `state` VARCHAR(100),
    `tier` VARCHAR(50) DEFAULT 'Standard',
    `credit_limit` DECIMAL(12,2) DEFAULT 0.00,
    `outstanding_balance` DECIMAL(12,2) DEFAULT 0.00,
    `total_orders` INT DEFAULT 0,
    `lifetime_spend` DECIMAL(12,2) DEFAULT 0.00,
    `gstin` VARCHAR(20) DEFAULT NULL,
    `pan` VARCHAR(20) DEFAULT NULL,
    `commission_rate` DECIMAL(5,2) DEFAULT 0.00,
    `status` ENUM('active', 'pending', 'suspended') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_number` VARCHAR(50) NOT NULL UNIQUE,
    `customer_id` INT NOT NULL,
    `customer_name` VARCHAR(150) NOT NULL,
    `customer_phone` VARCHAR(20) NOT NULL,
    `channel` ENUM('retail', 'wholesale', 'reseller', 'whatsapp') DEFAULT 'retail',
    `subtotal` DECIMAL(12,2) NOT NULL,
    `discount` DECIMAL(10,2) DEFAULT 0.00,
    `gst_rate` DECIMAL(4,2) DEFAULT 5.00,
    `gst_amount` DECIMAL(10,2) DEFAULT 0.00,
    `shipping_fee` DECIMAL(10,2) DEFAULT 0.00,
    `total_amount` DECIMAL(12,2) NOT NULL,
    `payment_method` VARCHAR(50) DEFAULT 'razorpay',
    `payment_status` ENUM('pending', 'paid', 'credit', 'refunded') DEFAULT 'paid',
    `fulfillment_status` ENUM('unfulfilled', 'processing', 'dispatched', 'delivered', 'cancelled') DEFAULT 'dispatched',
    `tracking_number` VARCHAR(100) DEFAULT NULL,
    `courier_name` VARCHAR(100) DEFAULT 'Delhivery Express',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_order_number` (`order_number`),
    INDEX `idx_customer` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `order_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `product_title` VARCHAR(255) NOT NULL,
    `sku` VARCHAR(50) NOT NULL,
    `unit_price` DECIMAL(10,2) NOT NULL,
    `quantity` INT NOT NULL DEFAULT 1,
    `total_price` DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `coupons` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `discount_type` ENUM('percentage', 'flat') DEFAULT 'percentage',
    `discount_value` DECIMAL(10,2) NOT NULL,
    `min_order_value` DECIMAL(10,2) DEFAULT 0.00,
    `max_discount` DECIMAL(10,2) DEFAULT 0.00,
    `status` ENUM('active', 'expired') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `reviews` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `customer_name` VARCHAR(100) NOT NULL,
    `rating` INT NOT NULL DEFAULT 5,
    `review_title` VARCHAR(150),
    `review_text` TEXT NOT NULL,
    `verified_buyer` TINYINT(1) DEFAULT 1,
    `status` ENUM('approved', 'pending', 'rejected') DEFAULT 'approved',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
