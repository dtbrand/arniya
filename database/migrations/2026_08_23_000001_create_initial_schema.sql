-- Migration: 2026_08_23_000001_create_initial_schema.sql
-- DT Brand's & Jai Hanuman Tex Core Database Schema

CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sku` VARCHAR(50) NOT NULL UNIQUE,
    `title` VARCHAR(255) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `fabric` VARCHAR(100) DEFAULT 'Silk',
    `mrp` DECIMAL(10,2) NOT NULL,
    `wholesale_price` DECIMAL(10,2) NOT NULL,
    `reseller_price` DECIMAL(10,2) NOT NULL,
    `stock_qty` INT DEFAULT 0,
    `status` ENUM('in_stock', 'low_stock', 'out_of_stock', 'draft') DEFAULT 'in_stock',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_number` VARCHAR(50) NOT NULL UNIQUE,
    `customer_id` INT NOT NULL,
    `channel` ENUM('retail', 'wholesale', 'reseller', 'whatsapp') DEFAULT 'retail',
    `subtotal` DECIMAL(12,2) NOT NULL,
    `discount` DECIMAL(10,2) DEFAULT 0.00,
    `gst_amount` DECIMAL(10,2) DEFAULT 0.00,
    `total_amount` DECIMAL(12,2) NOT NULL,
    `payment_status` ENUM('pending', 'paid', 'credit', 'refunded') DEFAULT 'pending',
    `fulfillment_status` ENUM('unfulfilled', 'processing', 'dispatched', 'delivered', 'cancelled') DEFAULT 'unfulfilled',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_customer_id` (`customer_id`),
    INDEX `idx_order_number` (`order_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
