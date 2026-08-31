<?php
/**
 * api/seed_demo_catalog.php — Seed Master Categories, Subcategories & Demo Products
 * DT Brand's & Jai Hanuman Tex — Live Database Seeder
 */
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

$pdo = Database::getConnection();

if ($pdo === null) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed.'
    ], JSON_PRETTY_PRINT);
    exit;
}

try {
    // 1. Ensure categories table exists
    $pdo->exec("
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
    ");

    // 2. Ensure subcategories table exists
    $pdo->exec("
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
    ");

    // 3. Add sub_category / subcategory column to products if not exists
    $colStmt = $pdo->query("SHOW COLUMNS FROM `products` LIKE 'sub_category'");
    if (!$colStmt->fetch()) {
        $colStmt2 = $pdo->query("SHOW COLUMNS FROM `products` LIKE 'subcategory'");
        if (!$colStmt2->fetch()) {
            $pdo->exec("ALTER TABLE `products` ADD COLUMN `sub_category` VARCHAR(100) DEFAULT '' AFTER `category_name`");
        }
    }

    // 4. Define the 4 Main Pillars & Subcategories
    $catalogStructure = [
        [
            'name' => 'Saree',
            'slug' => 'saree',
            'description' => 'Authentic Surat Handloom Silk, Banarasi, Kanjivaram & Paithani Sarees',
            'image' => '/assets/images/product1.png',
            'display_order' => 1,
            'subcategories' => [
                ['name' => 'Banarasi Kadwa Silk', 'slug' => 'banarasi-kadwa-silk', 'desc' => 'Pure Katan & Georgette Meenakari Kadwa weaves from Varanasi looms.'],
                ['name' => 'Kanjivaram Pure Zari', 'slug' => 'kanjivaram-pure-zari', 'desc' => 'Royal Korvai border temple designs with tested gold zari.'],
                ['name' => 'Yeola Paithani Handloom', 'slug' => 'yeola-paithani-handloom', 'desc' => 'Traditional peacock pallu and muniya border pure silk sarees.'],
                ['name' => 'Pastel Organza & Tissue', 'slug' => 'pastel-organza-tissue', 'desc' => 'Lightweight party & cocktail tissue weaves with delicate zari.'],
                ['name' => 'Chanderi Cotton Silk', 'slug' => 'chanderi-cotton-silk', 'desc' => 'Breathable festive handloom weaves with gold booti.'],
                ['name' => 'Bandhani & Patola Heritage', 'slug' => 'bandhani-patola-heritage', 'desc' => 'Authentic double ikat Gujarati Patola and tie-dye Bandhani.'],
            ]
        ],
        [
            'name' => 'Lehenga',
            'slug' => 'lehenga',
            'description' => 'Royal Bridal, Velvet, Zardozi & Sangeet Designer Lehengas',
            'image' => '/assets/images/product3.png',
            'display_order' => 2,
            'subcategories' => [
                ['name' => 'Bridal Velvet Lehengas', 'slug' => 'bridal-velvet-lehengas', 'desc' => 'Heavy micro-velvet bridal ensembles with heritage dori & zardozi.'],
                ['name' => 'Handcrafted Zardozi Silk', 'slug' => 'zardozi-silk-lehengas', 'desc' => 'Pure raw silk lehengas with intricate antique gold zari work.'],
                ['name' => 'Floral Organza & Net', 'slug' => 'organza-net-lehengas', 'desc' => 'Modern lightweight lehengas for sangeet and cocktail soirees.'],
                ['name' => 'Pastel Reception Ensembles', 'slug' => 'pastel-reception-ensembles', 'desc' => 'Contemporary pastel tones with pearl and cut-dana embellishments.'],
            ]
        ],
        [
            'name' => 'Gown',
            'slug' => 'gown',
            'description' => 'Contemporary Indo-Western, Georgette Drape & Reception Gowns',
            'image' => '/assets/images/product5.png',
            'display_order' => 3,
            'subcategories' => [
                ['name' => 'Indo-Western Drape Gowns', 'slug' => 'indo-western-drape-gowns', 'desc' => 'Pre-draped silhouette gowns with hand-embroidered bustiers.'],
                ['name' => 'Floor-Length Georgette Gowns', 'slug' => 'georgette-party-gowns', 'desc' => 'Flowing blooming georgette gowns with heavy flared skirts.'],
                ['name' => 'Sequined Evening Gowns', 'slug' => 'sequined-evening-gowns', 'desc' => 'All-over dual-tone sequins for glamorous cocktail receptions.'],
                ['name' => 'Anarkali Silhouette Gowns', 'slug' => 'anarkali-silhouette-gowns', 'desc' => 'Full-flair traditional silhouette with royal gotta patti & mirror work.'],
            ]
        ],
        [
            'name' => 'Kurti',
            'slug' => 'kurti',
            'description' => 'Ready-to-Wear Designer 3-Piece Kurti Sets & Festive Tunics',
            'image' => '/assets/images/product2.png',
            'display_order' => 4,
            'subcategories' => [
                ['name' => '3-Piece Festive Kurti Sets', 'slug' => '3-piece-festive-kurti-sets', 'desc' => 'Complete matching kurti, tailored pants and organza dupatta sets.'],
                ['name' => 'Straight Cut Designer Kurtis', 'slug' => 'straight-designer-silk-kurtis', 'desc' => 'Elegant office & boutique straight kurtis in pure silk and chanderi.'],
                ['name' => 'Flared Anarkali & Angrakha', 'slug' => 'flared-anarkali-angrakha-kurtis', 'desc' => 'Dramatic flare angrakha kurtis with latkan and dori details.'],
                ['name' => 'Printed Muslin & Cotton Sets', 'slug' => 'printed-muslin-cotton-kurtis', 'desc' => 'Skin-friendly breathable hand-block printed everyday wear.'],
            ]
        ]
    ];

    $catIdMap = [];
    $subcatIdMap = [];

    // Seed Categories & Subcategories
    foreach ($catalogStructure as $cat) {
        $stmt = $pdo->prepare("
            INSERT INTO `categories` (`name`, `slug`, `description`, `image`, `display_order`, `status`)
            VALUES (?, ?, ?, ?, ?, 'active')
            ON DUPLICATE KEY UPDATE 
                `name` = VALUES(`name`),
                `description` = VALUES(`description`),
                `display_order` = VALUES(`display_order`),
                `status` = 'active'
        ");
        $stmt->execute([$cat['name'], $cat['slug'], $cat['description'], $cat['image'], $cat['display_order']]);
        
        $cRow = $pdo->query("SELECT id FROM `categories` WHERE `slug` = " . $pdo->quote($cat['slug']))->fetch();
        $catId = (int)$cRow['id'];
        $catIdMap[$cat['name']] = $catId;

        foreach ($cat['subcategories'] as $sc) {
            $scStmt = $pdo->prepare("
                INSERT INTO `subcategories` (`category_id`, `name`, `slug`, `description`, `status`)
                VALUES (?, ?, ?, ?, 'active')
                ON DUPLICATE KEY UPDATE
                    `category_id` = VALUES(`category_id`),
                    `name` = VALUES(`name`),
                    `description` = VALUES(`description`),
                    `status` = 'active'
            ");
            $scStmt->execute([$catId, $sc['name'], $sc['slug'], $sc['desc']]);
            $subcatIdMap[$sc['name']] = $sc['slug'];
        }
    }

    // 5. Rich Demo Products Definition for all 4 Pillars
    $demoProducts = [
        // ─── SAREE PILLAR ───
        [
            'sku' => 'DTB-SAR-001',
            'title' => 'Royal Heritage Kanjivaram Pure Zari Brocade Saree',
            'slug' => 'royal-heritage-kanjivaram-pure-zari-brocade-saree',
            'category_name' => 'Saree',
            'sub_category' => 'Kanjivaram Pure Zari',
            'fabric' => 'Pure Mulberry Silk',
            'weave' => 'Kanchipuram Korvai Handloom',
            'zari_type' => 'Tested Gold Zari (0.8g)',
            'mrp' => 6999.00,
            'retail_price' => 3850.00,
            'wholesale_price' => 2450.00,
            'reseller_price' => 2750.00,
            'primary_image' => '/assets/images/product1.png',
            'badge' => 'Bestseller',
            'description' => 'Woven on traditional pit-looms in Kanchipuram with pure mulberry silk and authentic tested gold zari. Features classic temple borders and a rich brocade pallu.'
        ],
        [
            'sku' => 'DTB-SAR-002',
            'title' => 'Varanasi Kadwa Katan Silk Bridal Meenakari Saree',
            'slug' => 'varanasi-kadwa-katan-silk-bridal-meenakari-saree',
            'category_name' => 'Saree',
            'sub_category' => 'Banarasi Kadwa Silk',
            'fabric' => 'Pure Katan Silk',
            'weave' => 'Handloom Kadwa Booti',
            'zari_type' => 'Antique Gold & Silver Zari',
            'mrp' => 8499.00,
            'retail_price' => 4650.00,
            'wholesale_price' => 3100.00,
            'reseller_price' => 3450.00,
            'primary_image' => '/assets/images/product2.png',
            'badge' => 'Royal Heritage',
            'description' => 'Mastercraft Banarasi katan silk saree created using ancient Kadwa hand-weaving technique with dual-tone meenakari floral motifs.'
        ],
        [
            'sku' => 'DTB-SAR-003',
            'title' => 'Yeola Paithani Muniya Peacock Border Silk Saree',
            'slug' => 'yeola-paithani-muniya-peacock-border-silk-saree',
            'category_name' => 'Saree',
            'sub_category' => 'Yeola Paithani Handloom',
            'fabric' => 'Pure Handloom Silk',
            'weave' => 'Tapestry Weave Paithani',
            'zari_type' => 'Tested Gold Zari',
            'mrp' => 9999.00,
            'retail_price' => 5400.00,
            'wholesale_price' => 3800.00,
            'reseller_price' => 4150.00,
            'primary_image' => '/assets/images/product3.png',
            'badge' => 'Heritage Weave',
            'description' => 'Authentic Maharashtra Yeola Paithani featuring handwoven dancing peacocks on the rich pallu with signature green muniya borders.'
        ],
        [
            'sku' => 'DTB-SAR-004',
            'title' => 'Pastel Mint Organza Tissue Handloom Zari Saree',
            'slug' => 'pastel-mint-organza-tissue-handloom-zari-saree',
            'category_name' => 'Saree',
            'sub_category' => 'Pastel Organza & Tissue',
            'fabric' => 'Pure Organza Tissue',
            'weave' => 'Fine Sheer Weave',
            'zari_type' => 'Fine Platinum & Rose Gold Zari',
            'mrp' => 4999.00,
            'retail_price' => 2850.00,
            'wholesale_price' => 1750.00,
            'reseller_price' => 1950.00,
            'primary_image' => '/assets/images/product4.png',
            'badge' => 'New Arrival',
            'description' => 'Airy lightweight pastel tissue organza saree with delicate floral vine zari border and shimmering metallic finish for cocktail soirees.'
        ],

        // ─── LEHENGA PILLAR ───
        [
            'sku' => 'DTB-LEH-001',
            'title' => 'Maharani Crimson Bridal Micro Velvet Zardozi Lehenga Set',
            'slug' => 'maharani-crimson-bridal-micro-velvet-zardozi-lehenga-set',
            'category_name' => 'Lehenga',
            'sub_category' => 'Bridal Velvet Lehengas',
            'fabric' => 'Premium Micro Velvet (9000)',
            'weave' => 'Handcrafted Dori & Zardozi',
            'zari_type' => 'Matte Antique Gold Zari',
            'mrp' => 24999.00,
            'retail_price' => 14999.00,
            'wholesale_price' => 9800.00,
            'reseller_price' => 10950.00,
            'primary_image' => '/assets/images/product5.png',
            'badge' => 'Bridal Couture',
            'description' => 'Sumptuous 9000-grade micro velvet bridal lehenga with 4.5-meter circular flare, fully embellished with antique zardozi, badla, and pearl craftsmanship.'
        ],
        [
            'sku' => 'DTB-LEH-002',
            'title' => 'Noor Pastel Peach Organza Floral Bridal Lehenga Set',
            'slug' => 'noor-pastel-peach-organza-floral-bridal-lehenga-set',
            'category_name' => 'Lehenga',
            'sub_category' => 'Floral Organza & Net',
            'fabric' => 'Pure Viscose Organza',
            'weave' => 'Resham Thread & 3mm Sequins',
            'zari_type' => 'Light Gold Shimmer Thread',
            'mrp' => 18999.00,
            'retail_price' => 11499.00,
            'wholesale_price' => 7450.00,
            'reseller_price' => 8250.00,
            'primary_image' => '/assets/images/product6.png',
            'badge' => 'Trending Sangeet',
            'description' => 'Romantic pastel organza lehenga adorned with subtle resham thread work, micro-sequins, and a custom sweetheart neckline blouse.'
        ],

        // ─── GOWN PILLAR ───
        [
            'sku' => 'DTB-GWN-001',
            'title' => 'Aura Midnight Blue Indo-Western Drape Silhouette Gown',
            'slug' => 'aura-midnight-blue-indo-western-drape-silhouette-gown',
            'category_name' => 'Gown',
            'sub_category' => 'Indo-Western Drape Gowns',
            'fabric' => 'Pure Blooming Georgette',
            'weave' => 'Hand Cut-Dana & Pearl Work',
            'zari_type' => 'Metallic Gunmetal Highlights',
            'mrp' => 9999.00,
            'retail_price' => 5899.00,
            'wholesale_price' => 3650.00,
            'reseller_price' => 4150.00,
            'primary_image' => '/assets/images/product7.png',
            'badge' => 'Celebrity Look',
            'description' => 'Pre-draped architectural Indo-Western gown with asymmetrical pleated shoulder cape, cinched embellished waistline, and flared skirt.'
        ],
        [
            'sku' => 'DTB-GWN-002',
            'title' => 'Rose Gold Shimmer Sequined Floor-Length Evening Gown',
            'slug' => 'rose-gold-shimmer-sequined-floor-length-evening-gown',
            'category_name' => 'Gown',
            'sub_category' => 'Sequined Evening Gowns',
            'fabric' => 'Shimmer Lycra & Soft Net',
            'weave' => 'Dual-Tone Heavy Micro Sequins',
            'zari_type' => 'Rose Gold Metallic Accent',
            'mrp' => 11499.00,
            'retail_price' => 6499.00,
            'wholesale_price' => 4100.00,
            'reseller_price' => 4650.00,
            'primary_image' => '/assets/images/product8.png',
            'badge' => 'Partywear Drop',
            'description' => 'High-impact floor-sweeping gown saturated in luminous rose-gold sequins with inner crepe lining and padded corset bust.'
        ],

        // ─── KURTI PILLAR ───
        [
            'sku' => 'DTB-KUR-001',
            'title' => 'Kashmiri Tilla Embroidered Chanderi Silk 3-Piece Kurti Set',
            'slug' => 'kashmiri-tilla-embroidered-chanderi-silk-3-piece-kurti-set',
            'category_name' => 'Kurti',
            'sub_category' => '3-Piece Festive Kurti Sets',
            'fabric' => 'Chanderi Silk & Cotton Mulmul',
            'weave' => 'Tilla Zari Needlecraft',
            'zari_type' => 'Fine Gold Tilla Wire',
            'mrp' => 4899.00,
            'retail_price' => 2899.00,
            'wholesale_price' => 1650.00,
            'reseller_price' => 1850.00,
            'primary_image' => '/assets/images/product2.png',
            'badge' => '3-Piece Set',
            'description' => 'Festive 3-piece ensemble consisting of an embroidered Chanderi silk tunic, cigarette pants with lace trims, and a digital floral organza dupatta.'
        ],
        [
            'sku' => 'DTB-KUR-002',
            'title' => 'Gulbahar Hand-Block Pure Muslin Kurti Pant Set',
            'slug' => 'gulbahar-hand-block-pure-muslin-kurti-pant-set',
            'category_name' => 'Kurti',
            'sub_category' => 'Printed Muslin & Cotton Sets',
            'fabric' => '100% Pure Muslin Cotton',
            'weave' => 'Surat Artisanal Block Print',
            'zari_type' => 'Gotta Patti Lace Detailing',
            'mrp' => 3299.00,
            'retail_price' => 1899.00,
            'wholesale_price' => 1050.00,
            'reseller_price' => 1190.00,
            'primary_image' => '/assets/images/product4.png',
            'badge' => 'Daily Luxury',
            'description' => 'Ultra-soft hand-block printed muslin cotton set with delicate gotta patti yoke, straight fit trousers, and matching printed mulmul dupatta.'
        ]
    ];

    $insertedProducts = 0;
    foreach ($demoProducts as $dp) {
        $cId = $catIdMap[$dp['category_name']] ?? 1;

        $pStmt = $pdo->prepare("
            INSERT INTO `products` (
                `sku`, `title`, `slug`, `category_id`, `category_name`, `sub_category`,
                `fabric`, `weave`, `zari_type`, `mrp`, `retail_price`, `wholesale_price`, `reseller_price`,
                `moq_single`, `moq_half_set`, `moq_full_set`, `moq_master_bale`, `stock_qty`, `rating`, `reviews_count`,
                `primary_image`, `badge`, `is_featured`, `is_bestseller`, `status`, `description`
            )
            VALUES (
                ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?, ?,
                1, 4, 8, 24, 65, 4.9, 142,
                ?, ?, 1, 1, 'in_stock', ?
            )
            ON DUPLICATE KEY UPDATE
                `title` = VALUES(`title`),
                `category_id` = VALUES(`category_id`),
                `category_name` = VALUES(`category_name`),
                `sub_category` = VALUES(`sub_category`),
                `fabric` = VALUES(`fabric`),
                `weave` = VALUES(`weave`),
                `zari_type` = VALUES(`zari_type`),
                `mrp` = VALUES(`mrp`),
                `retail_price` = VALUES(`retail_price`),
                `wholesale_price` = VALUES(`wholesale_price`),
                `reseller_price` = VALUES(`reseller_price`),
                `primary_image` = VALUES(`primary_image`),
                `badge` = VALUES(`badge`),
                `status` = 'in_stock',
                `description` = VALUES(`description`)
        ");

        $pStmt->execute([
            $dp['sku'],
            $dp['title'],
            $dp['slug'],
            $cId,
            $dp['category_name'],
            $dp['sub_category'],
            $dp['fabric'],
            $dp['weave'],
            $dp['zari_type'],
            $dp['mrp'],
            $dp['retail_price'],
            $dp['wholesale_price'],
            $dp['reseller_price'],
            $dp['primary_image'],
            $dp['badge'],
            $dp['description']
        ]);
        $insertedProducts++;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Demo Catalog successfully seeded with Saree, Lehenga, Gown, Kurti main & subcategories and demo products.',
        'seeded_categories' => array_keys($catIdMap),
        'seeded_subcategories' => array_keys($subcatIdMap),
        'seeded_products_count' => $insertedProducts
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
