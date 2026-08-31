-- ═══════════════════════════════════════════════════════════════════════════
-- DT Brand's & Jai Hanuman Tex — Migration 2026_08_31_000001
-- Master Ethnic Pillars: Saree, Lehenga, Gown, Kurti + Subcategories & Demo Catalog
-- ═══════════════════════════════════════════════════════════════════════════

CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT,
    `image` VARCHAR(255) DEFAULT '/assets/images/product1.png',
    `banner_image` VARCHAR(255) DEFAULT '/assets/images/product1.png',
    `products_count` INT DEFAULT 0,
    `display_order` INT DEFAULT 1,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_cat_slug` (`slug`),
    INDEX `idx_cat_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `subcategories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_subcat_category` (`category_id`),
    INDEX `idx_subcat_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 1. Main Categories
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `display_order`, `status`)
VALUES 
(1, 'Saree', 'saree', 'Authentic Surat Handloom Silk, Banarasi, Kanjivaram & Paithani Sarees', '/assets/images/product1.png', 1, 'active'),
(2, 'Lehenga', 'lehenga', 'Royal Bridal, Velvet, Zardozi & Sangeet Designer Lehengas', '/assets/images/product3.png', 2, 'active'),
(3, 'Gown', 'gown', 'Contemporary Indo-Western, Georgette Drape & Reception Gowns', '/assets/images/product5.png', 3, 'active'),
(4, 'Kurti', 'kurti', 'Ready-to-Wear Designer 3-Piece Kurti Sets & Festive Tunics', '/assets/images/product2.png', 4, 'active')
ON DUPLICATE KEY UPDATE 
`name` = VALUES(`name`),
`description` = VALUES(`description`),
`display_order` = VALUES(`display_order`),
`status` = 'active';

-- 2. Saree Subcategories
INSERT INTO `subcategories` (`category_id`, `name`, `slug`, `description`, `status`)
VALUES 
(1, 'Banarasi Kadwa Silk', 'banarasi-kadwa-silk', 'Pure Katan & Georgette Meenakari Kadwa weaves from Varanasi looms.', 'active'),
(1, 'Kanjivaram Pure Zari', 'kanjivaram-pure-zari', 'Royal Korvai border temple designs with tested gold zari.', 'active'),
(1, 'Yeola Paithani Handloom', 'yeola-paithani-handloom', 'Traditional peacock pallu and muniya border pure silk sarees.', 'active'),
(1, 'Pastel Organza & Tissue', 'pastel-organza-tissue', 'Lightweight party & cocktail tissue weaves with delicate zari.', 'active'),
(1, 'Chanderi Cotton Silk', 'chanderi-cotton-silk', 'Breathable festive handloom weaves with gold booti.', 'active'),
(1, 'Bandhani & Patola Heritage', 'bandhani-patola-heritage', 'Authentic double ikat Gujarati Patola and tie-dye Bandhani.', 'active')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`), `status` = 'active';

-- 3. Lehenga Subcategories
INSERT INTO `subcategories` (`category_id`, `name`, `slug`, `description`, `status`)
VALUES 
(2, 'Bridal Velvet Lehengas', 'bridal-velvet-lehengas', 'Heavy micro-velvet bridal ensembles with heritage dori & zardozi.', 'active'),
(2, 'Handcrafted Zardozi Silk', 'zardozi-silk-lehengas', 'Pure raw silk lehengas with intricate antique gold zari work.', 'active'),
(2, 'Floral Organza & Net', 'organza-net-lehengas', 'Modern lightweight lehengas for sangeet and cocktail soirees.', 'active'),
(2, 'Pastel Reception Ensembles', 'pastel-reception-ensembles', 'Contemporary pastel tones with pearl and cut-dana embellishments.', 'active')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`), `status` = 'active';

-- 4. Gown Subcategories
INSERT INTO `subcategories` (`category_id`, `name`, `slug`, `description`, `status`)
VALUES 
(3, 'Indo-Western Drape Gowns', 'indo-western-drape-gowns', 'Pre-draped silhouette gowns with hand-embroidered bustiers.', 'active'),
(3, 'Floor-Length Georgette Gowns', 'georgette-party-gowns', 'Flowing blooming georgette gowns with heavy flared skirts.', 'active'),
(3, 'Sequined Evening Gowns', 'sequined-evening-gowns', 'All-over dual-tone sequins for glamorous cocktail receptions.', 'active'),
(3, 'Anarkali Silhouette Gowns', 'anarkali-silhouette-gowns', 'Full-flair traditional silhouette with royal gotta patti & mirror work.', 'active')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`), `status` = 'active';

-- 5. Kurti Subcategories
INSERT INTO `subcategories` (`category_id`, `name`, `slug`, `description`, `status`)
VALUES 
(4, '3-Piece Festive Kurti Sets', '3-piece-festive-kurti-sets', 'Complete matching kurti, tailored pants and organza dupatta sets.', 'active'),
(4, 'Straight Cut Designer Kurtis', 'straight-designer-silk-kurtis', 'Elegant office & boutique straight kurtis in pure silk and chanderi.', 'active'),
(4, 'Flared Anarkali & Angrakha', 'flared-anarkali-angrakha-kurtis', 'Dramatic flare angrakha kurtis with latkan and dori details.', 'active'),
(4, 'Printed Muslin & Cotton Sets', 'printed-muslin-cotton-kurtis', 'Skin-friendly breathable hand-block printed everyday wear.', 'active')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`), `status` = 'active';
