-- ══════════════════════════════════════════════════════════════════════════
-- Migration: 2026_09_12_000005_create_marketing_content_tables.sql
-- Description: Section 29 Marketing & Content Admin Database Schema
-- DT Brand's & Jai Hanuman Tex
-- ══════════════════════════════════════════════════════════════════════════

-- 1. Enhance banners table with type, tagline, badge, mobile image, and background
SET @_col1 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='banners' AND COLUMN_NAME='banner_type');
SET @_sql1 = IF(@_col1=0, "ALTER TABLE `banners` ADD COLUMN `banner_type` VARCHAR(50) NOT NULL DEFAULT 'hero_slider' AFTER `id`", 'SELECT 1');
PREPARE _s1 FROM @_sql1; EXECUTE _s1; DEALLOCATE PREPARE _s1;

SET @_col2 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='banners' AND COLUMN_NAME='tagline');
SET @_sql2 = IF(@_col2=0, 'ALTER TABLE `banners` ADD COLUMN `tagline` VARCHAR(255) NULL AFTER `subtitle`', 'SELECT 1');
PREPARE _s2 FROM @_sql2; EXECUTE _s2; DEALLOCATE PREPARE _s2;

SET @_col3 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='banners' AND COLUMN_NAME='badge');
SET @_sql3 = IF(@_col3=0, 'ALTER TABLE `banners` ADD COLUMN `badge` VARCHAR(100) NULL AFTER `tagline`', 'SELECT 1');
PREPARE _s3 FROM @_sql3; EXECUTE _s3; DEALLOCATE PREPARE _s3;

SET @_col4 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='banners' AND COLUMN_NAME='image_mobile');
SET @_sql4 = IF(@_col4=0, 'ALTER TABLE `banners` ADD COLUMN `image_mobile` VARCHAR(255) NULL AFTER `image`', 'SELECT 1');
PREPARE _s4 FROM @_sql4; EXECUTE _s4; DEALLOCATE PREPARE _s4;

SET @_col5 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='banners' AND COLUMN_NAME='bg_color');
SET @_sql5 = IF(@_col5=0, "ALTER TABLE `banners` ADD COLUMN `bg_color` VARCHAR(50) NOT NULL DEFAULT '#181512' AFTER `image_mobile`", 'SELECT 1');
PREPARE _s5 FROM @_sql5; EXECUTE _s5; DEALLOCATE PREPARE _s5;

-- 2. Homepage Sections & Order
CREATE TABLE IF NOT EXISTS `homepage_sections` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `section_key` VARCHAR(60) NOT NULL UNIQUE,
    `title` VARCHAR(150) NOT NULL,
    `subtitle` VARCHAR(255) NULL,
    `section_type` VARCHAR(50) NOT NULL DEFAULT 'product_grid',
    `display_order` INT NOT NULL DEFAULT 1,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `config_json` LONGTEXT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_hs_order` (`display_order`),
    INDEX `idx_hs_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Curated Collections
CREATE TABLE IF NOT EXISTS `curated_collections` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL UNIQUE,
    `tagline` VARCHAR(255) NULL,
    `image_url` VARCHAR(255) NULL,
    `badge` VARCHAR(100) NULL,
    `display_order` INT NOT NULL DEFAULT 1,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `product_ids_json` LONGTEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_cc_order` (`display_order`),
    INDEX `idx_cc_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Curated Product Lists (Featured, Best Sellers, New Arrivals)
CREATE TABLE IF NOT EXISTS `curated_product_lists` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `list_type` VARCHAR(50) NOT NULL,
    `product_id` INT UNSIGNED NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 1,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_cpl_type` (`list_type`),
    INDEX `idx_cpl_order` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Top Bar Announcements & Marquee
CREATE TABLE IF NOT EXISTS `announcements` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `message` VARCHAR(255) NOT NULL,
    `link_url` VARCHAR(255) NULL,
    `bg_color` VARCHAR(50) NOT NULL DEFAULT '#8A681F',
    `text_color` VARCHAR(50) NOT NULL DEFAULT '#FFFFFF',
    `is_marquee` TINYINT(1) NOT NULL DEFAULT 1,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `display_order` INT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_ann_active` (`is_active`),
    INDEX `idx_ann_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. SEO Metadata per Route
CREATE TABLE IF NOT EXISTS `seo_metadata` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `page_route` VARCHAR(100) NOT NULL UNIQUE,
    `meta_title` VARCHAR(255) NOT NULL,
    `meta_description` TEXT NULL,
    `meta_keywords` TEXT NULL,
    `og_image` VARCHAR(255) NULL,
    `canonical_url` VARCHAR(255) NULL,
    `structured_json` LONGTEXT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Social & WhatsApp Share Templates
CREATE TABLE IF NOT EXISTS `share_templates` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `channel` VARCHAR(50) NOT NULL UNIQUE,
    `title` VARCHAR(100) NOT NULL,
    `template_body` TEXT NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Official Social Media Channels
CREATE TABLE IF NOT EXISTS `social_channels` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `platform` VARCHAR(50) NOT NULL UNIQUE,
    `display_name` VARCHAR(100) NOT NULL,
    `account_url` VARCHAR(255) NOT NULL,
    `icon_key` VARCHAR(50) NOT NULL DEFAULT 'globe',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 1,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Seed Default Values for Instant Out-of-the-Box Operation
INSERT IGNORE INTO `announcements` (`id`, `message`, `link_url`, `bg_color`, `text_color`, `is_marquee`, `is_active`, `display_order`)
VALUES (1, 'Surat Mill Direct Wholesale & Reseller HUB • 100% Cash On Delivery Available • Instant Dispatch', '/shop.php', '#8A681F', '#FFFFFF', 1, 1, 1);

INSERT IGNORE INTO `social_channels` (`platform`, `display_name`, `account_url`, `icon_key`, `is_active`, `sort_order`)
VALUES 
('whatsapp', 'Official WhatsApp Concierge', 'https://wa.me/917046363528', 'whatsapp', 1, 1),
('instagram', 'Instagram Showcase', 'https://instagram.com/dtbrands', 'instagram', 1, 2),
('youtube', 'YouTube Mill Channel', 'https://youtube.com/@dtbrands', 'youtube', 1, 3),
('facebook', 'Facebook Official Page', 'https://facebook.com/dtbrands', 'facebook', 1, 4),
('telegram', 'Telegram B2B Broadcast', 'https://t.me/dtbrands', 'send', 1, 5);

INSERT IGNORE INTO `share_templates` (`channel`, `title`, `template_body`, `is_active`)
VALUES 
('whatsapp', 'Reseller 1-Click WhatsApp Lot', "Namaste! ✨ Check out this premium saree catalogue from DT Brand's & Jai Hanuman Tex:\n\n👗 *{title}*\n⭐ SKU: {sku}\n💰 Wholesale Price: Rs {price}\n📦 MOQ / Pack: Ready Stock\n\nDirect Mill Order Link:\n{link}\n\n100% Quality Assured from Surat Mill Depot.", 1),
('reseller', 'Reseller Margin Share', "✨ *Exclusive Saree Collection* ✨\n\n*{title}*\nCode: {sku}\nSpecial Price: Rs {reseller_price}\n\nOrder with Cash On Delivery: {link}", 1);

INSERT IGNORE INTO `seo_metadata` (`page_route`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`)
VALUES 
('home', "DT Brand's & Jai Hanuman Tex — Premier Surat Sarees Wholesale & Reseller HUB", "Direct from Surat weaving mill. Premium designer sarees, wedding silks, georgette, and cotton at direct wholesale mill prices. 100% COD & fast delivery.", 'surat sarees wholesale, b2b saree manufacturer, jai hanuman tex, dt brands, reseller sarees', 'https://jaihanumantex.in/'),
('wholesale', "Wholesale Saree Catalogue & Bulk Lot Inquiry — DT Brand's", "Wholesale saree catalogues, MOQ lots, GST invoicing, and factory direct pricing for textile showrooms and bulk retailers.", 'wholesale sarees, bulk sarees surat, mill direct sarees, b2b textile', 'https://jaihanumantex.in/wholesale.php');
