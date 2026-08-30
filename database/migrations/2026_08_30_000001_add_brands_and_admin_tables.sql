-- DT Brand's & Jai Hanuman Tex — BRANDS, ATTRIBUTES & ADMIN SUPPORT TABLES
-- Idempotent: every CREATE TABLE here uses IF NOT EXISTS, so re-applying this
-- migration against an existing schema is a no-op.

CREATE TABLE IF NOT EXISTS `product_brands` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL UNIQUE,
    `description` TEXT NULL,
    `logo_url` VARCHAR(255) NULL,
    `tier` VARCHAR(50) NULL,
    `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_brand_slug` (`slug`),
    INDEX `idx_brand_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `product_attributes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `type` ENUM('text','select','color','size','swatch') NOT NULL DEFAULT 'text',
    `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_attr_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `banners` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `subtitle` VARCHAR(255) NULL,
    `image` VARCHAR(255) NULL,
    `cta_text` VARCHAR(100) NULL,
    `cta_url` VARCHAR(255) NULL,
    `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `display_order` INT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_banner_status` (`status`),
    INDEX `idx_banner_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cms_pages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `title` VARCHAR(255) NOT NULL,
    `content` LONGTEXT NULL,
    `status` ENUM('draft','published','archived') NOT NULL DEFAULT 'draft',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_cms_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `settings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `key_name` VARCHAR(100) NOT NULL UNIQUE,
    `value` TEXT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;