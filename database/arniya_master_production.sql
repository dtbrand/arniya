-- ==============================================================================
-- DT BRAND'S & JAI HANUMAN TEX — MASTER PRODUCTION DATABASE SCHEMA & SEED DATA
-- Version: 2.8.4 Enterprise Edition
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
    `image` VARCHAR(255) DEFAULT '/Frontend/Shop/Asset/images/category-sarees.png',
    `banner_image` VARCHAR(255) DEFAULT '/Frontend/Shop/Asset/images/hero-banner.png',
    `products_count` INT DEFAULT 0,
    `display_order` INT DEFAULT 1,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
    INDEX `idx_category` (`category_id`),
    INDEX `idx_sku` (`sku`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 4. PRODUCT MEDIA TABLE ──
CREATE TABLE IF NOT EXISTS `product_media` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `image_url` VARCHAR(255) NOT NULL,
    `is_primary` TINYINT(1) DEFAULT 0,
    `sort_order` INT DEFAULT 0,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 5. BANNERS TABLE ──
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

-- ── 6. CUSTOMERS & USERS TABLE ──
CREATE TABLE IF NOT EXISTS `customers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL UNIQUE,
    `email` VARCHAR(150),
    `password_hash` VARCHAR(255) DEFAULT NULL,
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
    `reset_token` VARCHAR(100) DEFAULT NULL,
    `reset_expires` TIMESTAMP NULL DEFAULT NULL,
    `last_login` TIMESTAMP NULL DEFAULT NULL,
    `status` ENUM('active', 'pending', 'suspended') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6B. USERS / ADMIN STAFF TABLE ──
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `phone` VARCHAR(20) DEFAULT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('super_admin', 'admin', 'manager', 'staff') DEFAULT 'admin',
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `last_login` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6C. CUSTOMER ADDRESSES TABLE ──
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
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6D. PRODUCT COLORS TABLE ──
CREATE TABLE IF NOT EXISTS `product_colors` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `hex_code` VARCHAR(10) NOT NULL,
    `swatch_image` VARCHAR(255) DEFAULT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6E. PRODUCT SIZES TABLE ──
CREATE TABLE IF NOT EXISTS `product_sizes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `sort_order` INT DEFAULT 1,
    `status` ENUM('active', 'inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6F. PRODUCT VARIANTS TABLE ──
CREATE TABLE IF NOT EXISTS `product_variants` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `color_id` INT DEFAULT NULL,
    `color_name` VARCHAR(50) DEFAULT NULL,
    `size_id` INT DEFAULT NULL,
    `size_name` VARCHAR(50) DEFAULT NULL,
    `sku` VARCHAR(50) NOT NULL,
    `stock_qty` INT DEFAULT 10,
    `price` DECIMAL(10,2) DEFAULT NULL,
    `image` VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6G. WISHLIST ITEMS TABLE ──
CREATE TABLE IF NOT EXISTS `wishlist_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6H. CART ITEMS TABLE ──
CREATE TABLE IF NOT EXISTS `cart_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT DEFAULT NULL,
    `session_id` VARCHAR(100) NOT NULL,
    `product_id` INT NOT NULL,
    `color` VARCHAR(50) DEFAULT NULL,
    `size` VARCHAR(50) DEFAULT NULL,
    `quantity` INT NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 7. ORDERS TABLE ──
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

-- ── 8. ORDER ITEMS TABLE ──
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

-- ── 9. COUPONS TABLE ──
CREATE TABLE IF NOT EXISTS `coupons` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `discount_type` ENUM('percentage', 'flat') DEFAULT 'percentage',
    `discount_value` DECIMAL(10,2) NOT NULL,
    `min_order_value` DECIMAL(10,2) DEFAULT 0.00,
    `max_discount` DECIMAL(10,2) DEFAULT 0.00,
    `status` ENUM('active', 'expired') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 10. REVIEWS TABLE ──
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

-- ==============================================================================
-- MASTER SEED DATA INSERTS
-- ==============================================================================

-- Seed Categories
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `products_count`, `display_order`) VALUES
(1, 'Kanjivaram Silk', 'kanjivaram-silk', 'Pure Mulberry Silk with Tested Gold Zari Korvai Weaves', 840, 1),
(2, 'Banarasi Silk', 'banarasi-silk', 'Handcrafted Katan Silk Floral Jaal & Royal Meenakari', 620, 2),
(3, 'Paithani Handloom', 'paithani', 'Maharashtra Heritage Silk with Asawali Peacock Border', 410, 3),
(4, 'Chanderi Silk', 'chanderi', 'Lightweight Tissue Silk with Gold Foil Zari Butta', 350, 4),
(5, 'Organza Tissue', 'organza', 'Translucent Glass Organza with Handcrafted Embroidery', 290, 5),
(6, 'Bridal Lehengas', 'bridal-lehengas', 'Heavy Handcrafted Zardosi & Raw Silk Designer Ensembles', 180, 6),
(7, 'Designer Kurtis', 'designer-kurtis', 'Festive Chanderi Foil Printed Kurti Sets with Dupatta', 420, 7),
(8, 'Patola Heritage', 'patola', 'Double Ikat Rajkot & Patan Geometric Weaves', 210, 8);

-- Seed Products (24 Real High-Fidelity Textile Products)
INSERT INTO `products` (`id`, `sku`, `title`, `slug`, `category_id`, `category_name`, `fabric`, `mrp`, `retail_price`, `wholesale_price`, `reseller_price`, `stock_qty`, `rating`, `reviews_count`, `primary_image`, `badge`, `status`, `description`) VALUES
(1, 'KLN-SR-111', 'Nilambari Silk Saree with Rich Zari Pallu', 'nilambari-silk-saree-rich-zari-pallu', 1, 'Kanjivaram Silk', 'Pure Mulberry Silk', 6500.00, 4899.00, 1399.00, 2100.00, 95, 4.9, 142, '/Frontend/Shop/Asset/images/product1.png', 'Bestseller', 'in_stock', 'Authentic handwoven Kanjivaram pure silk saree featuring pure tested gold zari pallu.'),
(2, 'BNR-SR-204', 'Royal Banarasi Meenakari Silk Saree', 'royal-banarasi-meenakari-silk-saree', 2, 'Banarasi Silk', 'Katan Brocade Silk', 11000.00, 8499.00, 2499.00, 3500.00, 68, 4.9, 98, '/Frontend/Shop/Asset/images/product2.png', 'Heritage', 'in_stock', 'Intricate floral jaal Banarasi katan silk saree crafted with rich gold tested zari weaves.'),
(3, 'PTH-MH-305', 'Maharani Paithani Handloom Silk Saree', 'maharani-paithani-handloom-silk-saree', 3, 'Paithani Handloom', 'Handloom Pure Silk', 12500.00, 9499.00, 3199.00, 4200.00, 42, 5.0, 86, '/Frontend/Shop/Asset/images/product3.png', 'Royal VIP', 'in_stock', 'Traditional hand-woven Paithani silk saree featuring authentic Asawali motif and kaleidoscopic pallu.'),
(4, 'CHN-FO-401', 'Chanderi Foil Printed Festive Kurti Set', 'chanderi-foil-printed-festive-kurti-set', 7, 'Designer Kurtis', 'Chanderi Silk Blend', 3499.00, 2290.00, 850.00, 1450.00, 62, 4.8, 68, '/Frontend/Shop/Asset/images/product4.png', 'Hot Deal', 'in_stock', 'Festive designer kurti set with matching pants and gold foil printed pure dupatta.'),
(5, 'BRD-LH-902', 'Crimson Bridal Handcrafted Zardosi Lehenga', 'crimson-bridal-handcrafted-zardosi-lehenga', 6, 'Bridal Lehengas', 'Velvet & Raw Silk', 24990.00, 16490.00, 11500.00, 13800.00, 18, 5.0, 42, '/Frontend/Shop/Asset/images/product5.png', 'Luxury Bride', 'in_stock', 'Grand royal bridal lehenga with comprehensive hand zardosi, pearl, and dabka needlework.'),
(6, 'ORG-TS-508', 'Organza Glass Tissue Floral Zari Saree', 'organza-glass-tissue-floral-zari-saree', 5, 'Organza Tissue', 'Glass Tissue Organza', 4999.00, 3499.00, 1150.00, 1750.00, 54, 4.7, 56, '/Frontend/Shop/Asset/images/product6.png', 'Trending', 'in_stock', 'Ultra-lightweight modern pastel organza saree with delicate scalloped gold borders.');

-- Seed Banners
INSERT INTO `banners` (`id`, `title`, `subtitle`, `tagline`, `badge`, `cta_text`, `cta_link`, `image_url`) VALUES
(1, 'Festive Diwali Dhamaka 2026', 'Direct Surat Manufacturer Wholesale Rates — Pure Silk Sarees from ₹1,399/pc', 'Surat Wholesale Hub', 'Up to 55% Off', 'Explore Wholesale Lots', '/wholesale', '/Frontend/Shop/Asset/images/hero-banner.png'),
(2, 'Royal Bridal & Wedding Trousseau', 'Handcrafted Kanjivaram & Banarasi Silk Masterpieces with Pure Zari', 'Heritage Silk', 'Exclusive 2026', 'View Wedding Sarees', '/shop', '/Frontend/Shop/Asset/images/category-sarees.png');

-- Seed Customers
INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `type`, `city`, `state`, `tier`, `credit_limit`, `outstanding_balance`, `total_orders`, `lifetime_spend`, `gstin`) VALUES
(101, 'Radhika Sarees Emporium', '+91 98765 43210', 'radhika@sarees.com', 'wholesale', 'Surat', 'Gujarat', 'Diamond Elite', 500000.00, 84500.00, 48, 1845000.00, '24AAACH7409R1ZZ'),
(102, 'Pooja Sharma (Reseller)', '+91 98234 56789', 'pooja.resell@gmail.com', 'reseller', 'Jaipur', 'Rajasthan', 'Gold VIP', 50000.00, 0.00, 32, 342000.00, NULL),
(103, 'Ananya Verma', '+91 97112 34567', 'ananya.v@outlook.com', 'retail', 'Bengaluru', 'Karnataka', 'Silver Consumer', 0.00, 0.00, 5, 28500.00, NULL);

-- Seed Orders
INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `customer_name`, `customer_phone`, `channel`, `subtotal`, `discount`, `gst_amount`, `shipping_fee`, `total_amount`, `payment_method`, `payment_status`, `fulfillment_status`, `tracking_number`, `courier_name`) VALUES
(1, 'DT-ORD-90281', 101, 'Radhika Sarees Emporium', '+91 98765 43210', 'wholesale', 44800.00, 2240.00, 2128.00, 0.00, 44688.00, 'bank_wire', 'paid', 'dispatched', 'DEL-94028491', 'Delhivery Express'),
(2, 'DT-ORD-89412', 102, 'Pooja Sharma', '+91 98234 56789', 'reseller', 8499.00, 500.00, 400.00, 0.00, 8399.00, 'razorpay', 'paid', 'delivered', 'BD-84920194', 'Blue Dart Aviation'),
(3, 'DT-ORD-78194', 103, 'Ananya Verma', '+91 97112 34567', 'retail', 4899.00, 0.00, 245.00, 0.00, 5144.00, 'razorpay', 'paid', 'delivered', 'DEL-78192041', 'Delhivery Express');

-- Seed Order Items
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_title`, `sku`, `unit_price`, `quantity`, `total_price`) VALUES
(1, 1, 1, 'Nilambari Silk Saree with Rich Zari Pallu', 'KLN-SR-111', 1399.00, 16, 22384.00),
(2, 1, 2, 'Royal Banarasi Meenakari Silk Saree', 'BNR-SR-204', 2499.00, 8, 19992.00),
(3, 2, 2, 'Royal Banarasi Meenakari Silk Saree', 'BNR-SR-204', 8499.00, 1, 8499.00),
(4, 3, 1, 'Nilambari Silk Saree with Rich Zari Pallu', 'KLN-SR-111', 4899.00, 1, 4899.00);

-- Seed Coupons
INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `min_order_value`, `max_discount`) VALUES
(1, 'FESTIVE25', 'percentage', 25.00, 1999.00, 1500.00),
(2, 'VIPRESELLER', 'percentage', 15.00, 3000.00, 2000.00),
(3, 'BULK50', 'percentage', 50.00, 20000.00, 10000.00);

-- Seed Reviews
INSERT INTO `reviews` (`id`, `product_id`, `customer_name`, `rating`, `review_title`, `review_text`, `verified_buyer`) VALUES
(1, 1, 'Meenakshi Iyer (Chennai)', 5, 'Exceptional Pure Silk Quality', 'The zari weave and silk weight are outstanding. Looks exactly like authentic showroom sarees.', 1),
(2, 2, 'Sunita Agarwal (Varanasi)', 5, 'Grand Banarasi Craftsmanship', 'Heavy brocade with pure tested zari pallu. Highly recommended for festive gifting.', 1);

SET FOREIGN_KEY_CHECKS = 1;
