<?php
/**
 * retailer.php — Luxury DT Brand's B2B Retailer Dashboard
 * Clean Modern TailAdmin Sizing & Layout + 100% Signature Heritage Gold Brand Colors
 * 
 * Brand Color System:
 * - Primary Gold: #8A681F
 * - Radiant Accent Gold: #C5A859 / #D4AF37
 * - Deep Bronze Gold: #5A4210 / #705114
 * - Pale Gold Background: #FAF5E8 / #FDFBF7
 * - Obsidian Dark: #14110E / #0F172A
 */

require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/OrderManager.php';
require_once __DIR__ . '/../../src/CustomerManager.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\OrderManager;
use DTBrand\CustomerManager;

// Real metrics from Database
$dbOrders = OrderManager::getAll();
$totalOrdersCount = count($dbOrders);
$totalQuantity = 0;
$totalTurnover = 0;
$walletBalance = 145280;
$totalCoins = 3850;

foreach ($dbOrders as $ord) {
    $items = json_decode($ord['items_json'] ?? '[]', true) ?: [];
    foreach ($items as $it) {
        $totalQuantity += (int)($it['qty'] ?? 1);
    }
    $totalTurnover += (float)($ord['final_amount'] ?? $ord['total_amount'] ?? 0);
}

$dbProducts = ProductCatalog::getAll();
$catalogProducts = [];
foreach ($dbProducts as $dp) {
    $catalogProducts[] = [
        'id'              => $dp['id'],
        'sku'             => $dp['sku'],
        'hsn'             => '5007',
        'name'            => $dp['title'],
        'category'        => $dp['category'],
        'retail_price'    => $dp['retail_price'],
        'wholesale_price' => $dp['wholesale_price'],
        'moq'             => $dp['moq'] ?? 8,
        'image'           => $dp['image'],
        'badge'           => $dp['badge'] ?? 'New Catalogue',
        'badge_icon'      => '✨',
        'color'           => $dp['color'] ?? 'Royal Silk',
        'fabric'          => $dp['fabric'] ?? 'Pure Silk',
        'in_stock'        => $dp['stock_qty'] ?? 50,
        'tier_prices'     => '8-15 pcs: ₹' . number_format($dp['wholesale_price']) . ' | 16-31 pcs: ₹' . number_format($dp['wholesale_price'] * 0.95) . ' | 32+ pcs: ₹' . number_format($dp['wholesale_price'] * 0.90)
    ];
}
if (empty($catalogProducts)) {
$catalogProducts = [
    // ── NEW CATALOGUE / FRESH ARRIVALS (Shown First Always) ──
    [
        'id'              => 111,
        'sku'             => 'KLN-SR-111',
        'hsn'             => '5007',
        'name'            => 'Pure Dola Silk Meenakari Saree',
        'category'        => 'Sarees',
        'retail_price'    => 3499,
        'wholesale_price' => 1399,
        'moq'             => 8,
        'image'           => '/Frontend/Retailer/Asset/images/product2.png',
        'badge'           => 'New Catalogue',
        'badge_icon'      => '✨',
        'color'           => 'Crimson Rani',
        'fabric'          => 'Dola Silk with Meena Border',
        'in_stock'        => 95,
        'tier_prices'     => '8-15 pcs: ₹1,399 | 16-31 pcs: ₹1,299 | 32+ pcs: ₹1,219'
    ],
    [
        'id'              => 109,
        'sku'             => 'KLN-KT-109',
        'hsn'             => '6204',
        'name'            => 'Party Festive Sharara Suit Set',
        'category'        => 'Kurtis',
        'retail_price'    => 2699,
        'wholesale_price' => 989,
        'moq'             => 8,
        'image'           => '/Frontend/Retailer/Asset/images/product5.png',
        'badge'           => 'New Arrival',
        'badge_icon'      => '🔥',
        'color'           => 'Teal Blue',
        'fabric'          => 'Chanderi Gotapatti Work',
        'in_stock'        => 125,
        'tier_prices'     => '8-15 pcs: ₹989 | 16-31 pcs: ₹929 | 32+ pcs: ₹869'
    ],
    [
        'id'              => 110,
        'sku'             => 'KLN-SR-110',
        'hsn'             => '5007',
        'name'            => 'Paithani Rich Pallu Saree',
        'category'        => 'Sarees',
        'retail_price'    => 3199,
        'wholesale_price' => 1249,
        'moq'             => 8,
        'image'           => '/Frontend/Retailer/Asset/images/product1.png',
        'badge'           => 'New Catalogue',
        'badge_icon'      => '💎',
        'color'           => 'Bottle Green',
        'fabric'          => 'Art Silk Peacock Pallu',
        'in_stock'        => 110,
        'tier_prices'     => '8-15 pcs: ₹1,249 | 16-31 pcs: ₹1,169 | 32+ pcs: ₹1,099'
    ],
    [
        'id'              => 112,
        'sku'             => 'KLN-SR-112',
        'hsn'             => '5007',
        'name'            => 'Pure Kanjivaram Bridal Art Silk',
        'category'        => 'Sarees',
        'retail_price'    => 4499,
        'wholesale_price' => 1899,
        'moq'             => 6,
        'image'           => '/Frontend/Retailer/Asset/images/product3.png',
        'badge'           => 'New Arrival',
        'badge_icon'      => '👑',
        'color'           => 'Copper Gold',
        'fabric'          => 'Heavy Bridal Zari Silk',
        'in_stock'        => 85,
        'tier_prices'     => '6-11 pcs: ₹1,899 | 12-23 pcs: ₹1,779 | 24+ pcs: ₹1,659'
    ],

    // ── SUPER VALUE & BEST MARGIN LOTS ──
    [
        'id'              => 101,
        'sku'             => 'KLN-KT-101',
        'hsn'             => '6204',
        'name'            => 'Jaipuri Printed Cotton Kurti',
        'category'        => 'Kurtis',
        'retail_price'    => 599,
        'wholesale_price' => 249,
        'moq'             => 24,
        'image'           => '/Frontend/Retailer/Asset/images/product7.png',
        'badge'           => 'Super Value',
        'badge_icon'      => '🚀',
        'color'           => 'Indigo Blue',
        'fabric'          => '100% Pure Cotton',
        'in_stock'        => 320,
        'tier_prices'     => '24-49 pcs: ₹249 | 50-99 pcs: ₹229 | 100+ pcs: ₹199'
    ],
    [
        'id'              => 102,
        'sku'             => 'KLN-DP-102',
        'hsn'             => '5208',
        'name'            => 'Bandhani Silk Touch Dupatta',
        'category'        => 'Dupattas',
        'retail_price'    => 449,
        'wholesale_price' => 189,
        'moq'             => 30,
        'image'           => '/Frontend/Retailer/Asset/images/product8.png',
        'badge'           => 'Fast Selling',
        'badge_icon'      => '⚡',
        'color'           => 'Ruby Red',
        'fabric'          => 'Art Silk Bandhani',
        'in_stock'        => 450,
        'tier_prices'     => '30-59 pcs: ₹189 | 60-119 pcs: ₹169 | 120+ pcs: ₹149'
    ],
    [
        'id'              => 103,
        'sku'             => 'KLN-KT-103',
        'hsn'             => '6204',
        'name'            => 'Rayon Floral Straight Kurti',
        'category'        => 'Kurtis',
        'retail_price'    => 699,
        'wholesale_price' => 289,
        'moq'             => 20,
        'image'           => '/Frontend/Retailer/Asset/images/product5.png',
        'badge'           => 'Bestseller',
        'badge_icon'      => '🔥',
        'color'           => 'Mustard Yellow',
        'fabric'          => '14kg Heavy Rayon',
        'in_stock'        => 280,
        'tier_prices'     => '20-39 pcs: ₹289 | 40-79 pcs: ₹269 | 80+ pcs: ₹245'
    ],
    [
        'id'              => 104,
        'sku'             => 'KLN-KT-104',
        'hsn'             => '6204',
        'name'            => 'Chikan Embroidered Rayon Kurti',
        'category'        => 'Kurtis',
        'retail_price'    => 999,
        'wholesale_price' => 399,
        'moq'             => 18,
        'image'           => '/Frontend/Retailer/Asset/images/product6.png',
        'badge'           => 'Best Margin',
        'badge_icon'      => '⚡',
        'color'           => 'Pastel Mint',
        'fabric'          => 'Lakhnavi Handwork Rayon',
        'in_stock'        => 220,
        'tier_prices'     => '18-35 pcs: ₹399 | 36-71 pcs: ₹369 | 72+ pcs: ₹339'
    ],
    [
        'id'              => 105,
        'sku'             => 'KLN-SR-105',
        'hsn'             => '5407',
        'name'            => 'Digital Floral Georgette Saree',
        'category'        => 'Sarees',
        'retail_price'    => 1299,
        'wholesale_price' => 489,
        'moq'             => 16,
        'image'           => '/Frontend/Retailer/Asset/images/product4.png',
        'badge'           => 'Trending',
        'badge_icon'      => '🔥',
        'color'           => 'Lavender Rose',
        'fabric'          => '60gm Pure Georgette',
        'in_stock'        => 260,
        'tier_prices'     => '16-31 pcs: ₹489 | 32-63 pcs: ₹449 | 64+ pcs: ₹419'
    ],
    [
        'id'              => 106,
        'sku'             => 'KLN-SR-106',
        'hsn'             => '5007',
        'name'            => 'Chanderi Silk Festive Saree',
        'category'        => 'Sarees',
        'retail_price'    => 1599,
        'wholesale_price' => 649,
        'moq'             => 12,
        'image'           => '/Frontend/Retailer/Asset/images/product1.png',
        'badge'           => 'Festive Hot',
        'badge_icon'      => '✨',
        'color'           => 'Peacock Green',
        'fabric'          => 'Chanderi Zari Weave',
        'in_stock'        => 190,
        'tier_prices'     => '12-23 pcs: ₹649 | 24-47 pcs: ₹599 | 48+ pcs: ₹559'
    ],
    [
        'id'              => 107,
        'sku'             => 'KLN-SR-107',
        'hsn'             => '5407',
        'name'            => 'Organza Mirror Work Saree',
        'category'        => 'Sarees',
        'retail_price'    => 1899,
        'wholesale_price' => 749,
        'moq'             => 12,
        'image'           => '/Frontend/Retailer/Asset/images/product2.png',
        'badge'           => 'Party Wear',
        'badge_icon'      => '💎',
        'color'           => 'Blush Pink',
        'fabric'          => 'Glass Organza Silk',
        'in_stock'        => 170,
        'tier_prices'     => '12-23 pcs: ₹749 | 24-47 pcs: ₹699 | 48+ pcs: ₹649'
    ],
    [
        'id'              => 108,
        'sku'             => 'KLN-SR-108',
        'hsn'             => '5007',
        'name'            => 'Banarasi Brocade Semi-Silk',
        'category'        => 'Sarees',
        'retail_price'    => 2499,
        'wholesale_price' => 949,
        'moq'             => 10,
        'image'           => '/Frontend/Retailer/Asset/images/product3.png',
        'badge'           => 'Bestseller',
        'badge_icon'      => '⭐',
        'color'           => 'Royal Maroon',
        'fabric'          => 'Katan Art Silk',
        'in_stock'        => 140,
        'tier_prices'     => '10-19 pcs: ₹949 | 20-39 pcs: ₹889 | 40+ pcs: ₹829'
    ],
    [
        'id'              => 5,
        'sku'             => 'KLN-KT-005',
        'hsn'             => '6204',
        'name'            => 'Royal Anarkali Kurti Set',
        'category'        => 'Kurtis',
        'retail_price'    => 2799,
        'wholesale_price' => 1799,
        'moq'             => 10,
        'image'           => '/Frontend/Retailer/Asset/images/product5.png',
        'badge'           => 'Party Wear',
        'badge_icon'      => '💎',
        'color'           => 'Emerald Teal',
        'fabric'          => 'Chanderi Cotton',
        'in_stock'        => 180,
        'tier_prices'     => '10-19 pcs: ₹1,799 | 20-39 pcs: ₹1,599 | 40+ pcs: ₹1,449'
    ],
    [
        'id'              => 4,
        'sku'             => 'KLN-SR-004',
        'hsn'             => '5407',
        'name'            => 'Georgette Bloom Saree',
        'category'        => 'Sarees',
        'retail_price'    => 3299,
        'wholesale_price' => 2199,
        'moq'             => 8,
        'image'           => '/Frontend/Retailer/Asset/images/product4.png',
        'badge'           => 'Fast Selling',
        'badge_icon'      => '⚡',
        'color'           => 'Blush Peach',
        'fabric'          => 'Pure Georgette',
        'in_stock'        => 210,
        'tier_prices'     => '8-15 pcs: ₹2,199 | 16-30 pcs: ₹1,999 | 31+ pcs: ₹1,799'
    ],
    [
        'id'              => 1,
        'sku'             => 'KLN-SR-001',
        'hsn'             => '5007',
        'name'            => 'Nilambari Silk Saree',
        'category'        => 'Sarees',
        'retail_price'    => 4899,
        'wholesale_price' => 3199,
        'moq'             => 6,
        'image'           => '/Frontend/Retailer/Asset/images/product1.png',
        'badge'           => 'Bestseller',
        'badge_icon'      => '🔥',
        'color'           => 'Navy Blue',
        'fabric'          => 'Pure Silk Handloom',
        'in_stock'        => 140,
        'tier_prices'     => '6-11 pcs: ₹3,199 | 12-24 pcs: ₹2,999 | 25+ pcs: ₹2,799'
    ],
    [
        'id'              => 2,
        'sku'             => 'KLN-SR-002',
        'hsn'             => '5007',
        'name'            => 'Banarasi Zari Saree',
        'category'        => 'Sarees',
        'retail_price'    => 8499,
        'wholesale_price' => 5499,
        'moq'             => 4,
        'image'           => '/Frontend/Retailer/Asset/images/product2.png',
        'badge'           => 'Heritage',
        'badge_icon'      => '✨',
        'color'           => 'Maroon Wine',
        'fabric'          => 'Pure Katan Silk',
        'in_stock'        => 95,
        'tier_prices'     => '4-7 pcs: ₹5,499 | 8-15 pcs: ₹5,199 | 16+ pcs: ₹4,899'
    ],
    [
        'id'              => 3,
        'sku'             => 'KLN-SR-003',
        'hsn'             => '5007',
        'name'            => 'Kanjivaram Temple Silk',
        'category'        => 'Sarees',
        'retail_price'    => 12999,
        'wholesale_price' => 8499,
        'moq'             => 3,
        'image'           => '/Frontend/Retailer/Asset/images/product3.png',
        'badge'           => 'Royal VIP',
        'badge_icon'      => '👑',
        'color'           => 'Golden Yellow',
        'fabric'          => 'Pure Mulberry Silk',
        'in_stock'        => 60,
        'tier_prices'     => '3-5 pcs: ₹8,499 | 6-11 pcs: ₹7,999 | 12+ pcs: ₹7,499'
    ],
    [
        'id'              => 6,
        'sku'             => 'KLN-LH-006',
        'hsn'             => '6204',
        'name'            => 'Bridal Zardosi Lehenga',
        'category'        => 'Lehengas',
        'retail_price'    => 24999,
        'wholesale_price' => 16499,
        'moq'             => 2,
        'image'           => '/Frontend/Retailer/Asset/images/product6.png',
        'badge'           => 'Bridal Couture',
        'badge_icon'      => '💍',
        'color'           => 'Crimson Red',
        'fabric'          => 'Micro Velvet & Zari',
        'in_stock'        => 35,
        'tier_prices'     => '2-3 pcs: ₹16,499 | 4-7 pcs: ₹15,499 | 8+ pcs: ₹14,299'
    ],
    [
        'id'              => 113,
        'sku'             => 'KLN-GW-113',
        'hsn'             => '6204',
        'name'            => 'Party Wear Flared Designer Gown',
        'category'        => 'Gowns',
        'retail_price'    => 3999,
        'wholesale_price' => 1699,
        'moq'             => 6,
        'image'           => '/Frontend/Retailer/Asset/images/product5.png',
        'badge'           => 'New Arrival',
        'badge_icon'      => '🔥',
        'color'           => 'Royal Emerald',
        'fabric'          => 'Heavy Georgette Sequins',
        'in_stock'        => 75,
        'tier_prices'     => '6-11 pcs: ₹1,699 | 12-23 pcs: ₹1,599 | 24+ pcs: ₹1,489'
    ],
    [
        'id'              => 114,
        'sku'             => 'KLN-GW-114',
        'hsn'             => '6204',
        'name'            => 'Indo-Western Embroidered Gown',
        'category'        => 'Gowns',
        'retail_price'    => 4599,
        'wholesale_price' => 1999,
        'moq'             => 6,
        'image'           => '/Frontend/Retailer/Asset/images/product6.png',
        'badge'           => 'New Catalogue',
        'badge_icon'      => '✨',
        'color'           => 'Wine Burgundy',
        'fabric'          => 'Silk Velvet Zari Handwork',
        'in_stock'        => 65,
        'tier_prices'     => '6-11 pcs: ₹1,999 | 12-23 pcs: ₹1,879 | 24+ pcs: ₹1,749'
    ],
    [
        'id'              => 115,
        'sku'             => 'KLN-DM-115',
        'hsn'             => '5208',
        'name'            => 'Chanderi Jacquard Dress Material',
        'category'        => 'Dress Materials',
        'retail_price'    => 1999,
        'wholesale_price' => 849,
        'moq'             => 10,
        'image'           => '/Frontend/Retailer/Asset/images/product7.png',
        'badge'           => 'New Catalogue',
        'badge_icon'      => '✨',
        'color'           => 'Mustard Ochre',
        'fabric'          => 'Pure Chanderi with Silk Dupatta',
        'in_stock'        => 140,
        'tier_prices'     => '10-19 pcs: ₹849 | 20-39 pcs: ₹799 | 40+ pcs: ₹749'
    ],
    [
        'id'              => 116,
        'sku'             => 'KLN-DM-116',
        'hsn'             => '5208',
        'name'            => 'Pure Cotton Unstitched Suit Lot',
        'category'        => 'Dress Materials',
        'retail_price'    => 1499,
        'wholesale_price' => 599,
        'moq'             => 12,
        'image'           => '/Frontend/Retailer/Asset/images/product8.png',
        'badge'           => 'New Arrival',
        'badge_icon'      => '⚡',
        'color'           => 'Pastel Sky',
        'fabric'          => '60x60 Cambric Cotton with Malmal Dupatta',
        'in_stock'        => 180,
        'tier_prices'     => '12-23 pcs: ₹599 | 24-47 pcs: ₹549 | 48+ pcs: ₹499'
    ]
];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Retailer B2B Dashboard — DT Brand's Couture</title>
    
    <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/Frontend/Retailer/Asset/css/retailer.css?v=<?= time() ?>">

    <!-- ════════════ GLOBAL PRODUCTS & MODAL ENGINE BOOTSTRAP ════════════ -->
    <script>
        window.allProducts = <?php echo json_encode(isset($catalogProducts) ? $catalogProducts : (isset($products) ? $products : [])); ?>;
        window.catalogProducts = window.allProducts;
        window.products = window.allProducts;
        window.openQuickView = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
        window.openQuickViewModal = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
    </script>
</head>
<body>

    <!-- ═══ Mobile Sidebar Backdrop ═══ -->
    <div class="ws-sidebar-backdrop" id="wsSidebarBackdrop" onclick="toggleSidebar(false)"></div>

    <!-- ═══ Modern Clean Top Header (TailAdmin Style with Gold Brand Theme & Shop Page Mobile Search) ═══ -->
    <header class="ws-header" id="wsMainHeader">
        <!-- Normal Header View (Desktop & Mobile Initial View) -->
        <div class="ws-header-normal-view" id="wsHeaderNormalView">
            <div class="ws-header-left">
                <button class="ws-menu-toggle-btn" id="wsMenuToggleBtn" onclick="toggleSidebar()" aria-label="Toggle Menu">
                    <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </button>

                <!-- Mobile Brand Title (Center/Left) -->
                <div class="ws-mobile-header-brand">
                    <span class="ws-mob-logo-text">DT BRAND'S B2B</span>
                </div>
            </div>

            <div class="ws-header-right">
                <!-- Mobile Search Icon Trigger Button (Shown on mobile only, like Shop Page Header) -->
                <button class="ws-hdr-icon-btn mobile-search-trigger-btn" id="wsMobileSearchTriggerBtn" onclick="openMobileSearchOverlay()" aria-label="Open Search" title="Search">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>

                <!-- Wishlist Button -->
                <button class="ws-hdr-icon-btn" id="headerWishlistBtn" title="Retail Wishlist" onclick="if(typeof window.openWishlistDrawer==='function'){window.openWishlistDrawer();}else if(typeof window.openWishlist==='function'){window.openWishlist();}" aria-label="Retail Wishlist">
                    <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    <span class="ws-hdr-badge" id="headerWishlistBadge" style="display:none;">0</span>
                </button>

                <!-- Cart Button -->
                <button class="ws-hdr-icon-btn" id="headerCartBtn" title="Retail Cart" onclick="if(typeof window.openCartDrawer==='function'){window.openCartDrawer();}else if(typeof window.openCart==='function'){window.openCart();}" aria-label="Retail Cart">
                    <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    <span class="ws-hdr-badge gold" id="headerCartBadge" style="display:none;">0</span>
                </button>

                <!-- Notifications Bell -->
                <button class="ws-hdr-icon-btn" title="Notifications" onclick="window.showWsToast('2 new consignment dispatches in transit')">
                    <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    <span class="ws-notif-dot"></span>
                </button>

                <!-- User Profile Pill -->
                <div class="ws-user-profile-btn" onclick="switchWsTab('details')" title="Retailer Profile">
                    <img src="/Frontend/Retailer/Asset/images/profile.png" onerror="this.src='/Frontend/Retailer/Asset/images/product1.png';" alt="User" class="ws-user-avatar-img" id="headerUserAvatar" loading="lazy" decoding="async">
                    <div class="ws-user-name-text">
                        <span id="headerUserName">Rajesh Kumar</span>
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ Mobile Full-Header Search Bar Overlay (Exact Shop Page Style & Rules) ═══ -->
        <div class="mobile-full-search-bar ws-mobile-search-overlay" id="wsMobileFullSearchBar">
            <div class="mobile-search-input-wrap">
                <svg class="mobile-search-left-icon" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input
                    type="text"
                    class="mobile-search-input-field"
                    id="wsMobileSearchInput"
                    placeholder="Search orders, SKU, consignment, HSN..."
                    autocomplete="off"
                    oninput="handleGlobalSearch(this.value); handleMobileSearchInput(this.value);"
                    aria-label="Search dashboard items"
                >
                <button type="button" class="mobile-search-clear-btn" id="wsMobileSearchClearBtn" onclick="clearMobileGlobalSearch()" aria-label="Clear search">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
                <button type="button" class="mobile-search-submit-icon-btn ws-search-action-btn" id="wsMobileSearchSubmitIconBtn" aria-label="Search">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </div>

            <!-- Right Close '✕' Button (Closes mobile search overlay) -->
            <button type="button" class="mobile-search-close-btn" id="wsMobileSearchCloseBtn" onclick="closeMobileSearchOverlay()" aria-label="Close search">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
    </header>

    <!-- ═══ Main App Layout Grid ═══ -->
    <div class="ws-app-layout">
        
        <!-- ── Left Sidebar Navigation (TailAdmin Style with Gold Theme) ── -->
        <aside class="ws-sidebar" id="wsSidebar">
            <div class="ws-sidebar-brand-box">
                <a href="#" style="display:flex; align-items:center; text-decoration:none;">
                    <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/Shared/Asset/images/logo.png';" alt="DT Brand's" class="ws-brand-img-logo" style="height:36px; width:auto; max-width:150px; object-fit:contain;">
                </a>
                <button class="ws-sidebar-close-btn" onclick="toggleSidebar(false)" aria-label="Close Menu">✕</button>
            </div>

            <div class="ws-sidebar-scroll">
                <!-- VIP Retailer User Card in Sidebar -->
                <div class="ws-side-user-card" onclick="switchWsTab('details'); toggleSidebar(false);" style="margin: 8px 8px 4px; padding: 7px 9px; background: linear-gradient(135deg, #FAF5E8 0%, #FFFFFF 100%); border: 1.2px solid rgba(212,175,55,0.35); border-radius: 9px; display: flex; align-items: center; gap: 8px; cursor: pointer; box-shadow: 0 2px 6px rgba(138,104,31,0.06);">
                    <img src="/Frontend/Retailer/Asset/images/profile.png" onerror="this.src='/Frontend/Retailer/Asset/images/product1.png';" alt="User" style="width: 28px; height: 28px; border-radius: 50%; border: 1.5px solid var(--ws-gold-primary); object-fit: cover; flex-shrink: 0;" loading="lazy" decoding="async">
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 0.76rem; font-weight: 800; color: #1C1917; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" id="sideUserName">Rajesh Kumar</div>
                        <div style="font-size: 0.60rem; font-weight: 700; color: #8A681F; display: flex; align-items: center; gap: 2px;">
                            <span>★ Verified Retailer</span>
                        </div>
                    </div>
                    <span style="font-size: 0.58rem; font-weight: 800; background: #DCFCE7; color: #15803D; padding: 2px 5px; border-radius: 6px; border: 1px solid #BBF7D0; flex-shrink: 0;">Tier 1</span>
                </div>

                <div class="ws-nav-category">MENU</div>
                <ul class="ws-nav-list">
                    <li>
                        <a class="ws-nav-item active" onclick="switchWsTab('overview')">
                            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('orders')">
                            <svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            <span>Orders</span>
                            <span class="ws-nav-badge" id="navOrdersCount">6</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('reports')">
                            <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                            <span>Reports</span>
                            <span class="ws-nav-badge gold">NEW</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" id="sidebarNavCatalog" onclick="openWsCatalogCategoryModal()" style="cursor:pointer;">
                            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <span>Catalog</span>
                            <span class="ws-nav-badge gold" style="font-size:0.62rem; padding:2px 5px; letter-spacing:0.3px;">SELECT</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('tracking')">
                            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <span>Live Tracking</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('support')">
                            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <span>Support Desk</span>
                        </a>
                    </li>
                </ul>

                <div class="ws-nav-category">SETTINGS</div>
                <ul class="ws-nav-list">
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('details')">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('gst')">
                            <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                            <span>GST Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('address')">
                            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <span>Address Book</span>
                        </a>
                    </li>
                </ul>

                <div class="ws-sidebar-footer">
                    <button class="ws-logout-btn" onclick="handleWholesalerLogout()">
                        <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.2;" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span>Sign Out</span>
                    </button>
                </div>
            </div>
        </aside>

        <!-- ── Main Content Container ── -->
        <main class="ws-main-content">

            <!-- ═══════════════════════════════════════
                 TAB 1: OVERVIEW DASHBOARD (TAILADMIN SIZES WITH HERITAGE GOLD)
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane active" id="tabPaneOverview">
                
                <!-- Top 4 Primary Metric Stat Cards (3D Frosted Glass Palette with Animated SVGs) -->
                <div class="ws-metric-cards-grid">
                    
                    <!-- Metric Card 1: Account Tier (Interactive VIP Tier Roadmap Modal Trigger) -->
                    <div class="ws-stat-box" onclick="openVipTierModal()" style="cursor:pointer; position:relative;" title="Tap to view VIP Tier Roadmap">
                        <!-- Left Corner 3D Diagonal Tircha Tag -->
                        <div class="ws-tier-ribbon-tag non-vip" id="wsTierRibbonTag">
                            <span id="wsTierRibbonText">★ NON VIP</span>
                        </div>

                        <div class="ws-stat-head-row" style="padding-left:14px;">
                            <div class="ws-stat-label" id="statLabel1">B2B Account Tier</div>
                            <div class="ws-stat-ico-wrap tier">
                                <svg class="ws-anim-stat-ico crown" viewBox="0 0 24 24" width="18" height="18" fill="none"><path d="M2 4l3 12h14l3-12-6 7-4-7-4 7-6-7z" fill="#D4AF37" stroke="#92400E" stroke-width="1.2" stroke-linejoin="round"></path><circle cx="12" cy="3" r="1.5" fill="#F59E0B"></circle><circle cx="4" cy="4" r="1.2" fill="#F59E0B"></circle><circle cx="20" cy="4" r="1.2" fill="#F59E0B"></circle></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" id="statVal1" style="color:var(--ws-gold-primary); font-family:var(--ws-font-serif);">Tier 1</div>
                            <div style="display:flex; align-items:center; gap:5px;">
                                <div class="ws-roadmap-link-wrap" onclick="event.stopPropagation(); openVipTierModal();" title="View VIP Roadmap">
                                    <span class="ws-roadmap-link-text">Roadmap ›</span>
                                    <div class="ws-roadmap-running-line"></div>
                                </div>
                                <span class="ws-trend-pill up" id="statPill1">1–50 Orders</span>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 2: Orders -->
                    <div class="ws-stat-box">
                        <div class="ws-stat-head-row">
                            <div class="ws-stat-label" id="statLabel2">Total Orders</div>
                            <div class="ws-stat-ico-wrap orders">
                                <svg class="ws-anim-stat-ico box" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" id="statVal2"><?php echo $totalOrdersCount ?: '0'; ?></div>
                            <span class="ws-trend-pill up" id="statPill2">Live DB</span>
                        </div>
                    </div>

                    <!-- Metric Card 3: Total Quantity -->
                    <div class="ws-stat-box">
                        <div class="ws-stat-head-row">
                            <div class="ws-stat-label" id="statLabel3">Total Quantity (Units)</div>
                            <div class="ws-stat-ico-wrap qty">
                                <svg class="ws-anim-stat-ico stack" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" id="statVal3"><?php echo $totalQuantity; ?> <span style="font-size:0.85rem; font-weight:700; color:var(--ws-text-muted);">Pcs</span></div>
                            <span class="ws-trend-pill up" id="statPill3">Live DB</span>
                        </div>
                    </div>

                    <!-- Metric Card 4: Total Revenue Turnover -->
                    <div class="ws-stat-box">
                        <div class="ws-stat-head-row">
                            <div class="ws-stat-label" id="statLabel4">Total B2B Turnover</div>
                            <div class="ws-stat-ico-wrap turnover">
                                <svg class="ws-anim-stat-ico turnover" viewBox="0 0 24 24" width="18" height="18" fill="none"><circle cx="12" cy="12" r="9" fill="#F59E0B" fill-opacity="0.2" stroke="#D97706" stroke-width="1.5"></circle><path d="M10 8h4M10 11h3.5M10 8v8M12.5 11c1.4 0 1.8 1 1.8 1.8s-.4 1.8-1.8 1.8h-2.5" stroke="#78350F" stroke-width="1.4" stroke-linecap="round"></path></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" id="statVal4" style="color:var(--ws-gold-primary);">₹<?php echo number_format($totalTurnover); ?></div>
                            <span class="ws-trend-pill up" id="statPill4">Live DB</span>
                        </div>
                    </div>

                </div>

                <!-- ── Modern Frosted Gold Glassy Animated B2B Wallet & Coins Strip ── -->
                <div class="ws-wallet-strip" onclick="openFullWalletModal()" style="cursor:pointer;" title="Click to view Gold Wallet & Passbook">
                    <!-- Left Corner Micro 3D Diagonal Tircha Tag -->
                    <div class="ws-wallet-ribbon-tag">
                        <span>★ WALLET</span>
                    </div>

                    <!-- Left: Total Balance & Total Coins Metrics (Frosted Gold Glass Styling) -->
                    <div class="ws-wallet-metrics-group">
                        <!-- Metric 1: Total Balance -->
                        <div class="ws-wallet-metric-item">
                            <div class="ws-wallet-icon-wrapper">
                                <svg class="ws-anim-wallet-svg" viewBox="0 0 28 28" fill="none">
                                    <defs>
                                        <linearGradient id="wsGoldLeather" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#D4AF37"/>
                                            <stop offset="60%" stop-color="#AA8222"/>
                                            <stop offset="100%" stop-color="#785912"/>
                                        </linearGradient>
                                        <linearGradient id="wsGoldCoinShine" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FFFBEB"/>
                                            <stop offset="50%" stop-color="#FCD34D"/>
                                            <stop offset="100%" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                    <!-- Money Bills peeking from top -->
                                    <path d="M7 6V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v2" stroke="#10B981" stroke-width="1.8" fill="rgba(16,185,129,0.2)" stroke-linecap="round"/>
                                    <path d="M9 4.5h8" stroke="#10B981" stroke-width="1.2" stroke-linecap="round"/>
                                    <!-- Wallet main body -->
                                    <rect x="3" y="6" width="22" height="17" rx="3.5" fill="url(#wsGoldLeather)" stroke="#8A681F" stroke-width="1.2"/>
                                    <!-- Wallet inner fold line -->
                                    <path d="M3 10.5h22" stroke="rgba(255,255,255,0.35)" stroke-width="1"/>
                                    <!-- Wallet side clasp / flap -->
                                    <path d="M16 11.5h6.5a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5H16a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2z" fill="#785912" stroke="#D4AF37" stroke-width="1.2"/>
                                    <!-- Golden clasp coin button -->
                                    <circle cx="20.5" cy="14.5" r="1.6" fill="url(#wsGoldCoinShine)" stroke="#FFFFFF" stroke-width="0.8"/>
                                </svg>
                            </div>
                            <div class="ws-wallet-metric-content">
                                <span class="ws-wallet-metric-label">Total Balance</span>
                                <span class="ws-wallet-metric-value" id="walletAvailableBalance">₹1,45,280</span>
                            </div>
                        </div>

                        <!-- Metric 2: Total Coins -->
                        <div class="ws-wallet-metric-item">
                            <div class="ws-wallet-icon-wrapper coin">
                                <svg class="ws-anim-coin-svg" viewBox="0 0 28 28" fill="none">
                                    <defs>
                                        <linearGradient id="wsCoinGradDirect" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FFFBEB"/>
                                            <stop offset="50%" stop-color="#FCD34D"/>
                                            <stop offset="100%" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                    <!-- Outer Golden Coin Ring -->
                                    <circle cx="14" cy="14" r="11" fill="url(#wsCoinGradDirect)" stroke="#8A681F" stroke-width="1.4"/>
                                    <!-- Inner Star/Coin Ring Pattern -->
                                    <circle cx="14" cy="14" r="8.5" stroke="#FFFFFF" stroke-opacity="0.85" stroke-dasharray="2 1.5" stroke-width="1"/>
                                    <!-- Centered Rupee / Silk Emblem -->
                                    <path d="M11 10h6M11 13h5M11 10v7M14 13c1.8 0 2.4 1.4 2.4 2.4s-.8 2-2.4 2h-3" stroke="#78350F" stroke-width="1.6" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="ws-wallet-metric-content">
                                <span class="ws-wallet-metric-label">Total Coins</span>
                                <span class="ws-wallet-metric-value gold" id="walletTotalCoins">3,850</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Small Styled View Button -->
                    <div class="ws-wallet-strip-actions">
                        <button type="button" class="ws-btn ws-btn-wallet-view-sm" onclick="event.stopPropagation();openFullWalletModal();">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <span>View</span>
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>

                <!-- Middle Analytics Grid (Monthly Sales Bar Chart + Target Gauge) -->
                <div class="ws-analytics-grid">
                    
                    <!-- Left: Monthly Sales Zigzag Line & Spline Area Chart (Luxury Style) -->
                    <div class="ws-analytics-card">
                        <div class="ws-card-top-bar" style="margin-bottom: 12px;">
                            <div>
                                <h3 id="chartTitle" style="margin:0; font-family:var(--ws-font-serif); font-size:1.02rem; color:var(--ws-gold-primary); font-weight:800;">Monthly Sales Trend</h3>
                                <p style="font-size:0.72rem; color:var(--ws-text-muted); margin-top:2px;" id="chartSubtitle">Consignment units & retail turnover</p>
                            </div>
                            <div class="ws-chart-type-pill">
                                <button class="ws-chart-type-btn active" id="btnChartZigzag" onclick="switchSalesChartStyle('zigzag', this)">Zigzag</button>
                                <button class="ws-chart-type-btn" id="btnChartSmooth" onclick="switchSalesChartStyle('smooth', this)">Smooth</button>
                            </div>
                        </div>

                        <!-- Live Tooltip Display -->
                        <div class="ws-chart-tooltip" id="chartLiveTooltip">
                            <span class="ws-chart-tooltip-dot"></span>
                            <span id="chartTooltipText">Aug (Current): ₹2,05,062 • 48 Pcs (↑18.4%)</span>
                        </div>

                        <div class="ws-chart-wrapper" id="salesChartMainWrapper">
                            <div class="ws-chart-svg-container">
                                <!-- Y Axis Labels -->
                                <div class="ws-chart-y-axis">
                                    <span>400k</span>
                                    <span>300k</span>
                                    <span>200k</span>
                                    <span>100k</span>
                                    <span>0k</span>
                                </div>

                                <svg class="ws-chart-svg" viewBox="0 0 600 170" preserveAspectRatio="none" style="padding-left: 34px;">
                                    <defs>
                                        <!-- Gold Gradient for the Line -->
                                        <linearGradient id="wsGoldLineGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                            <stop offset="0%" stop-color="#8A681F" />
                                            <stop offset="35%" stop-color="#C5A859" />
                                            <stop offset="70%" stop-color="#D4AF37" />
                                            <stop offset="100%" stop-color="#6F5218" />
                                        </linearGradient>

                                        <!-- Translucent Gold Area Fill Gradient -->
                                        <linearGradient id="wsGoldAreaGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                            <stop offset="0%" stop-color="#C5A859" stop-opacity="0.45" />
                                            <stop offset="60%" stop-color="#8A681F" stop-opacity="0.15" />
                                            <stop offset="100%" stop-color="#8A681F" stop-opacity="0.01" />
                                        </linearGradient>
                                    </defs>

                                    <!-- Horizontal Dashed Grid Lines (Clean 400k to 0k Range) -->
                                    <line class="ws-chart-gridline" x1="0" y1="20" x2="600" y2="20" />
                                    <line class="ws-chart-gridline" x1="0" y1="55" x2="600" y2="55" />
                                    <line class="ws-chart-gridline" x1="0" y1="90" x2="600" y2="90" />
                                    <line class="ws-chart-gridline" x1="0" y1="125" x2="600" y2="125" />
                                    <line class="ws-chart-gridline" x1="0" y1="158" x2="600" y2="158" />

                                    <!-- Zigzag Area Gradient Fill -->
                                    <path class="ws-chart-zigzag-area" id="svgAreaPath" 
                                          d="M 40,115 L 86,96 L 132,102 L 178,85 L 224,76 L 270,82 L 316,62 L 362,88 L 408,68 L 454,38 L 500,52 L 546,94 L 546,158 L 40,158 Z" />

                                    <!-- Zigzag Line Stroke -->
                                    <path class="ws-chart-zigzag-line" id="svgLinePath" 
                                          d="M 40,115 L 86,96 L 132,102 L 178,85 L 224,76 L 270,82 L 316,62 L 362,88 L 408,68 L 454,38 L 500,52 L 546,94" />

                                    <!-- 12 Month Interactive Nodes (Proportional Coordinates) -->
                                    <circle class="ws-chart-node" cx="40" cy="115" onmouseover="showChartNodeTooltip(0)" onclick="showChartNodeTooltip(0)" />
                                    <circle class="ws-chart-node" cx="86" cy="96" onmouseover="showChartNodeTooltip(1)" onclick="showChartNodeTooltip(1)" />
                                    <circle class="ws-chart-node" cx="132" cy="102" onmouseover="showChartNodeTooltip(2)" onclick="showChartNodeTooltip(2)" />
                                    <circle class="ws-chart-node" cx="178" cy="85" onmouseover="showChartNodeTooltip(3)" onclick="showChartNodeTooltip(3)" />
                                    <circle class="ws-chart-node" cx="224" cy="76" onmouseover="showChartNodeTooltip(4)" onclick="showChartNodeTooltip(4)" />
                                    <circle class="ws-chart-node" cx="270" cy="82" onmouseover="showChartNodeTooltip(5)" onclick="showChartNodeTooltip(5)" />
                                    <circle class="ws-chart-node" cx="316" cy="62" onmouseover="showChartNodeTooltip(6)" onclick="showChartNodeTooltip(6)" />
                                    <circle class="ws-chart-node active" cx="362" cy="88" onmouseover="showChartNodeTooltip(7)" onclick="showChartNodeTooltip(7)" />
                                    <circle class="ws-chart-node" cx="408" cy="68" onmouseover="showChartNodeTooltip(8)" onclick="showChartNodeTooltip(8)" />
                                    <circle class="ws-chart-node" cx="454" cy="38" onmouseover="showChartNodeTooltip(9)" onclick="showChartNodeTooltip(9)" />
                                    <circle class="ws-chart-node" cx="500" cy="52" onmouseover="showChartNodeTooltip(10)" onclick="showChartNodeTooltip(10)" />
                                    <circle class="ws-chart-node" cx="546" cy="94" onmouseover="showChartNodeTooltip(11)" onclick="showChartNodeTooltip(11)" />
                                </svg>
                            </div>

                            <!-- X Axis Month Labels -->
                            <div class="ws-chart-x-axis">
                                <span onmouseover="showChartNodeTooltip(0)" onclick="showChartNodeTooltip(0)">Jan</span>
                                <span onmouseover="showChartNodeTooltip(1)" onclick="showChartNodeTooltip(1)">Feb</span>
                                <span onmouseover="showChartNodeTooltip(2)" onclick="showChartNodeTooltip(2)">Mar</span>
                                <span onmouseover="showChartNodeTooltip(3)" onclick="showChartNodeTooltip(3)">Apr</span>
                                <span onmouseover="showChartNodeTooltip(4)" onclick="showChartNodeTooltip(4)">May</span>
                                <span onmouseover="showChartNodeTooltip(5)" onclick="showChartNodeTooltip(5)">Jun</span>
                                <span onmouseover="showChartNodeTooltip(6)" onclick="showChartNodeTooltip(6)">Jul</span>
                                <span class="active" onmouseover="showChartNodeTooltip(7)" onclick="showChartNodeTooltip(7)">Aug</span>
                                <span onmouseover="showChartNodeTooltip(8)" onclick="showChartNodeTooltip(8)">Sep</span>
                                <span onmouseover="showChartNodeTooltip(9)" onclick="showChartNodeTooltip(9)">Oct</span>
                                <span onmouseover="showChartNodeTooltip(10)" onclick="showChartNodeTooltip(10)">Nov</span>
                                <span onmouseover="showChartNodeTooltip(11)" onclick="showChartNodeTooltip(11)">Dec</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Semi-Circular Target Gauge (Royal Gold Arc & Animated Glow) -->
                    <div class="ws-analytics-card">
                        <div class="ws-card-top-bar" style="margin-bottom: 8px;">
                            <div>
                                <h3 style="margin:0; font-family:var(--ws-font-serif); font-size:1.02rem; color:var(--ws-gold-primary); font-weight:800;">Retail Store Target</h3>
                                <p style="font-size:0.72rem; color:var(--ws-text-muted); margin-top:2px;">Monthly store sales & inventory velocity</p>
                            </div>
                            <span class="ws-trend-pill up">75.5% Quota</span>
                        </div>

                        <div class="ws-gauge-wrap">
                            <svg class="ws-gauge-svg" viewBox="0 0 200 110">
                                <defs>
                                    <linearGradient id="goldGaugeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" stop-color="#8A681F"/>
                                        <stop offset="35%" stop-color="#C5A859"/>
                                        <stop offset="70%" stop-color="#D4AF37"/>
                                        <stop offset="100%" stop-color="#FFE082"/>
                                    </linearGradient>
                                    <filter id="gaugeGlow" x="-20%" y="-20%" width="140%" height="140%">
                                        <feGaussianBlur stdDeviation="4" result="blur" />
                                        <feComposite in="SourceGraphic" in2="blur" operator="over" />
                                    </filter>
                                </defs>
                                <path class="ws-gauge-bg-arc" d="M 20 100 A 80 80 0 0 1 180 100"></path>
                                <path class="ws-gauge-fill-arc" id="targetGaugeFill" d="M 20 100 A 80 80 0 0 1 180 100" style="stroke-dashoffset: 58;"></path>
                                <!-- Glowing Leading Indicator Circle on Arc Tip -->
                                <circle cx="152" cy="43" r="6" fill="#FFE082" stroke="#8A681F" stroke-width="2.5" filter="url(#gaugeGlow)" />
                                <circle cx="152" cy="43" r="2.5" fill="#FFFFFF" />
                            </svg>
                            <div class="ws-gauge-center-text" id="targetGaugeVal">75.55%</div>
                            <div class="ws-gauge-badge" id="targetGaugeBadge">
                                <svg style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                <span>+10.4% vs Target</span>
                            </div>
                            <p class="ws-gauge-desc" id="targetGaugeDesc">You achieved <strong>₹1,84,500</strong> this cycle. Just <strong>₹65,500</strong> left to complete Tier 1 VIP store quota!</p>
                        </div>

                        <div class="ws-gauge-stats-row">
                            <div class="ws-gauge-stat-pill">
                                <div class="ws-g-stat-label">Target</div>
                                <div class="ws-g-stat-val" id="gStatTarget" style="color:var(--ws-danger);">₹2.50L</div>
                            </div>
                            <div class="ws-gauge-stat-pill">
                                <div class="ws-g-stat-label">Achieved</div>
                                <div class="ws-g-stat-val" id="gStatRevenue" style="color:var(--ws-success);">₹1.85L ↑</div>
                            </div>
                            <div class="ws-gauge-stat-pill">
                                <div class="ws-g-stat-label">Velocity</div>
                                <div class="ws-g-stat-val" id="gStatToday" style="color:var(--ws-gold-primary);">₹18.2K/d</div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ── Full Comprehensive Statistics & Analytics Card ── -->
                <div class="ws-statistics-card">
                    <div class="ws-section-header" style="margin-bottom:0;">
                        <div class="ws-sec-title-box">
                            <h3 id="statsMainTitle">Statistics & Performance Analytics</h3>
                            <p id="statsSubtitle">Weekly Retail Sales, Store Inventory Mix & Dispatch Reliability</p>
                        </div>

                        <div class="ws-sec-actions-row">
                            <div class="ws-segmented-control">
                                <button class="ws-seg-btn active" id="statBtnOverview" onclick="setOverviewFilter('overview', this)">Overview</button>
                                <button class="ws-seg-btn" id="statBtnSales" onclick="setOverviewFilter('sales', this)">Sales</button>
                                <button class="ws-seg-btn" id="statBtnRevenue" onclick="setOverviewFilter('revenue', this)">Revenue</button>
                            </div>
                            <div class="ws-date-range-pill" id="dateRangeBtn" onclick="openDateRangePicker()">
                                <svg class="ws-ico gold" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span id="selectedDateRangeLabel">Aug 10 - Aug 16</span>
                                <svg style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2;margin-left:2px;" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>
                    </div>

                    <!-- 3-Column Multi-Dimensional Analytics Grid -->
                    <div class="ws-stats-grid" id="statsDynamicContent">
                        
                        <!-- Column 1: Category Volume Mix & Target Fulfillment -->
                        <div>
                            <div class="ws-stats-col-title">
                                <span id="catBreakdownTitle"><svg class="ws-ico gold" style="margin-right:5px;" viewBox="0 0 24 24"><path d="M20.38 3.46L16 2 12 5.5 8 2l-4.38 1.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path></svg> Category Retail Breakdown</span>
                            </div>
                            <div class="ws-cat-prog-list" id="catProgList">
                                <div class="ws-cat-prog-item">
                                    <div class="ws-cat-prog-header">
                                        <span class="ws-cat-prog-name">Pure Silk & Zari Sarees</span>
                                        <span class="ws-cat-prog-val">₹1,14,500 (56%)</span>
                                    </div>
                                    <div class="ws-cat-prog-track">
                                        <div class="ws-cat-prog-fill" style="--prog-w: 88%; animation-delay: 0.6s;"></div>
                                    </div>
                                </div>

                                <div class="ws-cat-prog-item">
                                    <div class="ws-cat-prog-header">
                                        <span class="ws-cat-prog-name">Bridal Velvet & Zardosi Lehengas</span>
                                        <span class="ws-cat-prog-val">₹49,147 (24%)</span>
                                    </div>
                                    <div class="ws-cat-prog-track">
                                        <div class="ws-cat-prog-fill" style="--prog-w: 72%; animation-delay: 0.75s;"></div>
                                    </div>
                                </div>

                                <div class="ws-cat-prog-item">
                                    <div class="ws-cat-prog-header">
                                        <span class="ws-cat-prog-name">Royal Anarkali Kurti Sets</span>
                                        <span class="ws-cat-prog-val">₹25,825 (13%)</span>
                                    </div>
                                    <div class="ws-cat-prog-track">
                                        <div class="ws-cat-prog-fill" style="width: 95%;"></div>
                                    </div>
                                </div>

                                <div class="ws-cat-prog-item">
                                    <div class="ws-cat-prog-header">
                                        <span class="ws-cat-prog-name">Georgette & Chanderi Fabrics</span>
                                        <span class="ws-cat-prog-val">₹15,590 (7%)</span>
                                    </div>
                                    <div class="ws-cat-prog-track">
                                        <div class="ws-cat-prog-fill" style="width: 60%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Column 2: Key Operational Metrics (KPIs) -->
                        <div>
                            <div class="ws-stats-col-title">
                                <span><svg class="ws-ico gold" style="margin-right:5px;" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> Key Retail Performance (KPIs)</span>
                            </div>
                            <div class="ws-kpi-grid" id="kpiGrid">
                                <div class="ws-kpi-box">
                                    <div class="ws-kpi-label">Avg. Retail Margin</div>
                                    <div class="ws-kpi-num">36.8%</div>
                                    <div class="ws-kpi-sub">↑ 4.2% Boutique Markup</div>
                                </div>
                                <div class="ws-kpi-box">
                                    <div class="ws-kpi-label">Store Restock TAT</div>
                                    <div class="ws-kpi-num">1.8 Days</div>
                                    <div class="ws-kpi-sub"><svg class="ws-ico gold ws-ico-sm" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> Priority Surat Express</div>
                                </div>
                                <div class="ws-kpi-box">
                                    <div class="ws-kpi-label">GST Input Tax Credit</div>
                                    <div class="ws-kpi-num">₹10,253</div>
                                    <div class="ws-kpi-sub"><svg class="ws-ico gold ws-ico-sm" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg> 100% GSTR-2B Claimed</div>
                                </div>
                                <div class="ws-kpi-box">
                                    <div class="ws-kpi-label">Store Sell-Through</div>
                                    <div class="ws-kpi-num">89.4%</div>
                                    <div class="ws-kpi-sub"><svg class="ws-ico gold ws-ico-sm" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg> Fast Selling Collections</div>
                                </div>
                            </div>
                        </div>

                        <!-- Column 3: VIP Tier Roadmap Milestone -->
                        <div>
                            <div class="ws-stats-col-title">
                                <span><svg class="ws-ico gold" style="margin-right:5px;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg> VIP Tier Milestone</span>
                            </div>
                            <div class="ws-tier-status-box" style="padding:14px; display:flex; flex-direction:column; justify-content:space-between; background:linear-gradient(135deg, #FFFFFF 0%, #FEFAF0 100%); border:1.5px solid rgba(212,175,55,0.45); border-radius:12px;">
                                <div>
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                        <span class="ws-tier-badge active" id="statsMilestoneBadge" style="font-size:0.60rem; font-weight:800;">Tier 1: Active Retailer</span>
                                        <span id="statsMilestoneOrders" style="font-size:0.66rem; font-weight:800; color:#15803D;">6 / 50 Orders</span>
                                    </div>
                                    <h4 id="statsMilestoneVal" style="font-size:1.10rem; font-weight:900; color:var(--ws-text-main); margin:0 0 6px; font-family:var(--ws-font-serif); letter-spacing:0.2px;">
                                        Tier 1: Active Retailer
                                    </h4>
                                    <!-- Progress Bar -->
                                    <div style="height:6px; background:#F1ECE1; border-radius:4px; overflow:hidden; margin-bottom:8px;">
                                        <div id="statsMilestoneBar" style="height:100%; width:12%; background:linear-gradient(90deg, #10B981, #059669); border-radius:4px;"></div>
                                    </div>
                                    <p id="statsMilestoneDesc" style="font-size:0.73rem; color:#57534E; line-height:1.35; margin:0;">
                                        Complete <strong>44 more orders</strong> to automatically unlock <strong>Tier 2: Silver Retailer</strong> with an extra +3% margin rebate!
                                    </p>
                                </div>

                                <button class="ws-btn ws-btn-primary ws-btn-sm" style="margin-top:10px; width:100%; justify-content:center;" onclick="openVipTierModal()">
                                    <svg class="ws-ico" style="stroke:#FFFFFF;margin-right:4px;" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> View VIP Roadmap
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Trending Catalog Carousel (Matches Shop Page Product Cards) -->
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group" style="display:flex; align-items:center; gap:8px;">
                            <div style="width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border:1.5px solid rgba(217, 119, 6, 0.35); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 6px rgba(217,119,6,0.15);">
                                <svg class="ws-anim-flame-star" style="width:17px; height:17px;" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2l2.4 5.2 5.6.8-4 4 1 5.6-5-2.8-5 2.8 1-5.6-4-4 5.6-.8L12 2z" fill="url(#goldStarGradCatalog)" stroke="#B45309" stroke-width="1.2" stroke-linejoin="round"></path>
                                    <defs>
                                        <linearGradient id="goldStarGradCatalog" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FDE047"/>
                                            <stop offset="50%" stop-color="#F59E0B"/>
                                            <stop offset="100%" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <h3 style="font-family:var(--ws-font-serif); font-size:clamp(1.02rem, 1.8vw, 1.18rem); font-weight:800; color:var(--ws-text-main); margin:0; letter-spacing:0.2px;">
                                Trending Catalog
                            </h3>
                        </div>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="switchWsTab('trending')" style="font-weight:800; display:inline-flex; align-items:center; gap:4px;">
                            <span>View All (<?= count($catalogProducts) ?>)</span>
                            <span style="font-size:1rem; line-height:1;">→</span>
                        </button>
                    </div>

                    <div class="ws-slider-wrap">
                        <button class="ws-slider-nav-btn prev" onclick="slideTrendingProducts(-1)" aria-label="Previous"><svg style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                        <div class="ws-slider-track" id="wsTrendingSliderTrack">
                            <?php foreach ($catalogProducts as $prod): 
                                $badge_raw = $prod['badge'] ?? 'Bestseller';
                                $badge_slug = strtolower(str_replace([' ', '★'], ['-', ''], $badge_raw));
                                $margin_pct = round((($prod['retail_price'] - $prod['wholesale_price']) / $prod['retail_price']) * 100);
                            ?>
                            <article class="product-card" data-product-id="<?= $prod['id'] ?>" role="listitem">
                                <div class="card-image-wrap">
                                    <a href="/Frontend/Single-Product/singleproduct.php?id=<?= $prod['id'] ?>" style="display:block;width:100%;height:100%;">
                                        <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="card-img" onerror="this.src='/Frontend/Retailer/Asset/images/product1.png';" loading="lazy">
                                    </a>
                                    <?php if (!empty($prod['badge'])): ?>
                                    <span class="card-badge badge-<?= $badge_slug ?>"><?= htmlspecialchars($prod['badge']) ?></span>
                                    <?php endif; ?>
                                    <!-- Wishlist Button -->
                                    <button type="button" class="card-wishlist-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();toggleWholesaleWishlist(<?= $prod['id'] ?>, this)" aria-label="Wishlist <?= htmlspecialchars($prod['name']) ?>" aria-pressed="false">
                                        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                    </button>

                                    <!-- Mobile Quick View Button -->
                                    <button type="button" class="card-mobile-qv-btn quick-view-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.openQV==='function'){window.openQV(<?= $prod['id'] ?>);}else{openQuickOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>);}" aria-label="Quick View <?= htmlspecialchars($prod['name']) ?>">
                                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </button>

                                    <!-- Desktop Quick View Overlay -->
                                    <div class="card-quick-view" aria-hidden="true">
                                        <button type="button" class="quick-view-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.openQV==='function'){window.openQV(<?= $prod['id'] ?>);}else{openQuickOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>);}">Quick View</button>
                                    </div>

                                    <!-- Share Button on Photo (Directly Above Category Tag) -->
                                    <button type="button" class="card-share-btn" data-id="<?= $prod['id'] ?>" aria-label="Share <?= htmlspecialchars($prod['name']) ?>" title="Share <?= htmlspecialchars($prod['name']) ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.shareProductCard==='function'){window.shareProductCard(<?= $prod['id'] ?>);}else{shareWholesaleProduct(<?= htmlspecialchars(json_encode($prod)) ?>);}">
                                        <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                                    </button>
                                    <span class="card-cat-photo-tag"><?= htmlspecialchars($prod['category']) ?></span>
                                </div>
                                <div class="card-body">
                                    <h2 class="card-name">
                                        <a href="/Frontend/Single-Product/singleproduct.php?id=<?= $prod['id'] ?>" style="color:inherit;text-decoration:none;">
                                            <?= htmlspecialchars($prod['name']) ?>
                                        </a>
                                    </h2>
                                    <div class="card-info-text-row">
                                        <span class="card-colors-text"><?= htmlspecialchars($prod['color']) ?></span>
                                        <span class="card-sizes-text"><?= !empty($prod['moq']) ? 'MOQ: '.$prod['moq'].' Pcs' : 'Free Size' ?></span>
                                    </div>
                                    <div class="card-price-row">
                                        <div class="card-price-stack">
                                            <span class="card-price">₹<?= number_format($prod['wholesale_price']) ?></span>
                                            <?php if (!empty($prod['retail_price'])): ?>
                                            <span class="card-old-price">₹<?= number_format($prod['retail_price']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Direct Add to Cart '+' Button next to Sale Price -->
                                        <button type="button" class="card-smart-add-cart-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();directAddWholesaleToCart(<?= htmlspecialchars(json_encode($prod)) ?>, this)" aria-label="Add <?= htmlspecialchars($prod['name']) ?> to Cart" title="Direct Add to Cart">
                                            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        </button>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        </div>
                        <button class="ws-slider-nav-btn next" onclick="slideTrendingProducts(1)" aria-label="Next"><svg style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
                    </div>
                </div>

                <!-- Recent Orders Snapshot -->
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group" style="display:flex; align-items:center; gap:8px;">
                            <div style="width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border:1.5px solid rgba(217, 119, 6, 0.35); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 6px rgba(217,119,6,0.15);">
                                <svg style="width:17px; height:17px; stroke:#B45309; fill:none; stroke-width:2.2; stroke-linecap:round; stroke-linejoin:round;" viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                            <h3 style="font-family:var(--ws-font-serif); font-size:clamp(1.02rem, 1.8vw, 1.18rem); font-weight:800; color:var(--ws-text-main); margin:0; letter-spacing:0.2px;">
                                Recent Dispatches
                            </h3>
                        </div>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="switchWsTab('orders')" style="font-weight:800; display:inline-flex; align-items:center; gap:4px;">
                            <span>Full Order Book</span>
                            <span style="font-size:1rem; line-height:1;">→</span>
                        </button>
                    </div>

                    <div id="overviewOrdersContainer">
                        <!-- Populated by JS -->
                    </div>
                </div>

            </section>


            <!-- ═══════════════════════════════════════
                 TAB 2: MY DETAILS
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneDetails">
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <h3>Profile Edit</h3>
                        </div>
                    </div>

                    <form id="wsDetailsForm" onsubmit="handleSaveWholesalerDetails(event)">
                        <div class="ws-form-grid">
                            
                            <div class="ws-form-group">
                                <label class="ws-label" for="wsProfName">Full Name / Authorized Rep <span class="req">*</span></label>
                                <input type="text" id="wsProfName" class="ws-input" placeholder="e.g. Rajesh Kumar" required>
                            </div>

                            <div class="ws-form-group">
                                <label class="ws-label" for="wsProfPhone">WhatsApp Mobile Number <span class="req">*</span></label>
                                <div class="ws-phone-wrap">
                                    <div class="ws-phone-prefix">🇮🇳 +91</div>
                                    <input type="tel" id="wsProfPhone" class="ws-input ws-phone-input" placeholder="9876543210" maxlength="10" required>
                                </div>
                            </div>

                            <div class="ws-form-group">
                                <label class="ws-label" for="wsProfEmail">Registered Business Email <span class="req">*</span></label>
                                <input type="email" id="wsProfEmail" class="ws-input" placeholder="e.g. rajesh@shreekrishnasilks.com" required>
                            </div>

                            <div class="ws-form-group">
                                <label class="ws-label">Account Role Designation</label>
                                <input type="text" class="ws-input" value="👑 Retailer B2B VIP Tier" disabled>
                            </div>

                        </div>

                        <div style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--ws-border);">
                            <h4 style="font-size:0.95rem; font-weight:700; color:var(--ws-gold-primary); margin-bottom:10px;">
                                🔒 Change Password (Leave blank to keep current)
                            </h4>
                            <div class="ws-form-grid">
                                <div class="ws-form-group">
                                    <label class="ws-label" for="wsCurrentPass">Current Password</label>
                                    <input type="password" id="wsCurrentPass" class="ws-input" placeholder="Enter current password">
                                </div>
                                <div class="ws-form-group">
                                    <label class="ws-label" for="wsNewPass">New Password</label>
                                    <input type="password" id="wsNewPass" class="ws-input" placeholder="Minimum 6 characters">
                                </div>
                            </div>
                        </div>

                        <div class="ws-btn-group">
                            <button type="submit" class="ws-btn ws-btn-primary">
                                Save Profile Changes
                            </button>
                        </div>
                    </form>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 3: GST / NON-GST PROFILE
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneGst">
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <h3>GST & Business Tax Configuration</h3>
                        </div>
                    </div>

                    <!-- GST Type Selector Cards -->
                    <div class="ws-gst-selector-grid">
                        <div class="ws-gst-option-card selected" id="gstCardGst" onclick="selectGstMode('gst')">
                            <div class="ws-radio-dot"></div>
                            <div>
                                <strong style="font-size:0.88rem; color:var(--ws-text-main);">Registered with GST (Input Tax Credit)</strong>
                                <p style="font-size:0.75rem; color:var(--ws-text-muted); margin-top:2px;">Get official GSTR-1 compliant tax invoices for input tax credit.</p>
                            </div>
                        </div>

                        <div class="ws-gst-option-card" id="gstCardNonGst" onclick="selectGstMode('non_gst')">
                            <div class="ws-radio-dot"></div>
                            <div>
                                <strong style="font-size:0.88rem; color:var(--ws-text-main);">Unregistered / Non-GST Trader</strong>
                                <p style="font-size:0.75rem; color:var(--ws-text-muted); margin-top:2px;">Retail bills issued under composition or trader exempt threshold.</p>
                            </div>
                        </div>
                    </div>

                    <form id="wsGstForm" onsubmit="handleSaveGstProfile(event)">
                        <div class="ws-form-grid">
                            
                            <div class="ws-form-group full" id="wsCompanyNameFieldWrap">
                                <label class="ws-label" for="wsCompanyName">Registered Legal Trade Name / Firm Name <span class="req">*</span></label>
                                <input type="text" id="wsCompanyName" class="ws-input" placeholder="e.g. Shree Krishna Silks Pvt Ltd" required>
                            </div>

                            <div class="ws-form-group full" id="gstNumberFieldWrap">
                                <label class="ws-label" for="wsGstNumber">
                                    <span>15-Character GSTIN Number <span class="req">*</span></span>
                                    <span id="gstStateDetectTag" style="font-size:0.72rem; color:var(--ws-gold-primary); font-weight:700;">Format: 24AABCU9603R1ZM</span>
                                </label>
                                <input type="text" id="wsGstNumber" class="ws-input" placeholder="e.g. 24AABCU9603R1ZM" maxlength="15" style="text-transform:uppercase; font-family:monospace; letter-spacing:0.08em;" oninput="validateGstinInput(this)">
                            </div>

                            <div class="ws-form-group full" id="nonGstNoticeWrap" style="display:none;">
                                <div style="padding:12px 14px; background:#F8FAFC; border:1.5px solid #E2E8F0; border-radius:8px; font-size:0.80rem; color:#475569; line-height:1.4;">
                                    <strong style="color:#0F172A; display:block; margin-bottom:2px;">ℹ️ Unregistered / Non-GST Mode Active</strong>
                                    No registered company name or GSTIN number is required. Orders will be processed under your personal account.
                                </div>
                            </div>

                        </div>

                        <div class="ws-btn-group">
                            <button type="submit" class="ws-btn ws-btn-primary">
                                Save Tax Profile
                            </button>
                        </div>
                    </form>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 4: MY ADDRESS BOOK (BILLING & DISPATCH HUBS)
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneAddress">
                <div class="ws-card" style="padding: clamp(14px, 3vw, 22px);">
                    <div class="ws-card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; padding-bottom:12px; margin-bottom:16px; border-bottom:1px solid rgba(212,175,55,0.25);">
                        <div class="ws-card-title-group">
                            <h3 style="margin:0; font-size:clamp(1.05rem, 3vw, 1.2rem); font-weight:900; color:var(--ws-text-main); font-family:var(--ws-font-serif);">
                                Address Book
                            </h3>
                        </div>
                        <span class="ws-status-badge delivered" style="font-size:0.70rem; padding:4px 9px; font-weight:800; border-radius:6px; flex-shrink:0;">
                            ★ GST Verified Dispatch
                        </span>
                    </div>

                    <!-- 2 Saved Address Preview Cards (Billing vs Shipping) -->
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:14px; margin-bottom:16px;">
                        
                        <!-- Card 1: Registered GST Billing Address -->
                        <div style="background:linear-gradient(145deg, #FFFCF7 0%, #FAF5E8 100%); border:1.5px solid rgba(212,175,55,0.4); border-radius:14px; padding:14px 16px; position:relative; box-shadow:0 3px 12px rgba(180,83,9,0.05);">
                            <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin-bottom:10px;">
                                <span style="font-size:0.68rem; font-weight:800; background:linear-gradient(135deg, #FEF3C7, #FDE68A); color:#92400E; padding:3px 8px; border-radius:6px; border:1px solid rgba(217,119,6,0.3); text-transform:uppercase; letter-spacing:0.3px;">
                                    ★ Registered GST Billing Address
                                </span>
                                <button type="button" id="btnEditMainAddr" onclick="openEditMainAddressModal()" style="font-size:0.74rem; padding:4px 12px; font-weight:800; background:#FFFFFF; border:1.2px solid rgba(180,83,9,0.35); color:#92400E; display:inline-flex; align-items:center; gap:4px; border-radius:8px; cursor:pointer; box-shadow:0 2px 5px rgba(0,0,0,0.05); flex-shrink:0;" title="Edit Billing Address">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    <span>Edit</span>
                                </button>
                            </div>
                            <div style="font-weight:800; font-size:0.95rem; color:var(--ws-text-main); margin-bottom:4px;" id="addrPreviewBillingComp">Shree Krishna Silks Pvt Ltd</div>
                            <div style="font-size:0.78rem; color:var(--ws-text-muted); line-height:1.45;" id="addrPreviewBillingFull">
                                Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road<br>
                                Surat, Gujarat - 395002 (GSTIN: 24AABCU9603R1ZM)
                            </div>
                            <div style="font-size:0.74rem; font-weight:700; color:var(--ws-gold-primary); margin-top:8px; display:flex; align-items:center; gap:5px;" id="addrPreviewBillingAttn">
                                Attn: Rajesh Kumar (+91 98765 43210)
                            </div>
                        </div>

                        <!-- Card 2: Active Dispatch & Shipping Hub -->
                        <div style="background:linear-gradient(145deg, #FFFFFF 0%, #F8FAFC 100%); border:1.5px solid #E2E8F0; border-radius:14px; padding:14px 16px; position:relative; box-shadow:0 3px 12px rgba(0,0,0,0.03);" id="addrPreviewDispatchCard">
                            <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin-bottom:10px;">
                                <span style="font-size:0.68rem; font-weight:800; background:#E0F2FE; color:#0369A1; padding:3px 8px; border-radius:6px; border:1px solid #BAE6FD; text-transform:uppercase; letter-spacing:0.3px;" id="addrPreviewDispatchBadge">
                                    📦 Dispatch: Same as Billing
                                </span>
                                <button type="button" id="btnEditDispatchAddr" onclick="toggleEditAddressSection('dispatch')" style="font-size:0.74rem; padding:4px 12px; font-weight:800; background:#FFFFFF; border:1.2px solid #BAE6FD; color:#0369A1; display:inline-flex; align-items:center; gap:4px; border-radius:8px; cursor:pointer; box-shadow:0 2px 5px rgba(0,0,0,0.05); flex-shrink:0;" title="Edit Dispatch Hub">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    <span>Edit</span>
                                </button>
                            </div>
                            <div style="font-weight:800; font-size:0.95rem; color:var(--ws-text-main); margin-bottom:4px;" id="addrPreviewDispatchTitle">Direct Storefront Delivery</div>
                            <div style="font-size:0.78rem; color:var(--ws-text-muted); line-height:1.45;" id="addrPreviewDispatchFull">
                                Dispatched to GST registered address: Shop No. 402, Millennium Textile Market 2, Surat - 395002
                            </div>
                            <div style="font-size:0.74rem; font-weight:700; color:var(--ws-text-sub); margin-top:8px;" id="addrPreviewDispatchTransporter">
                                Preferred Hub: BlueDart Express / Surat Goods Transporter
                            </div>
                        </div>

                    </div>

                    <!-- COLLAPSIBLE EDIT FORM CONTAINER (HIDDEN BY DEFAULT!) -->
                    <div id="wsAddressEditDrawer" style="display:none; margin-top:10px;">
                        <form id="wsAddressForm" onsubmit="handleSaveAddress(event)">
                            
                            <!-- ════ FORM 1: EDIT MAIN REGISTERED BILLING ADDRESS ════ -->
                            <div id="wsMainAddressSectionWrap" style="display:none; background:#FAF8F4; border:1.5px solid var(--ws-gold-border); border-radius:14px; padding:18px; margin-bottom:18px; box-shadow:0 4px 14px rgba(217,119,6,0.08);">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid rgba(212,175,55,0.3);">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--ws-gold-primary)" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                        <h4 style="font-size:0.95rem; font-weight:800; color:var(--ws-gold-primary); margin:0; font-family:var(--ws-font-serif);">
                                            Edit Billing Address
                                        </h4>
                                    </div>
                                    <button type="button" onclick="closeEditAddressDrawer()" style="background:transparent; border:none; color:var(--ws-text-muted); cursor:pointer; font-size:1.1rem; font-weight:800;">✕</button>
                                </div>

                                <div class="ws-form-grid">
                                    <div class="ws-form-group">
                                        <label class="ws-label" for="wsMainCompName">Business / Firm / Company Name <span class="req">*</span></label>
                                        <input type="text" id="wsMainCompName" class="ws-input" placeholder="e.g. Shree Krishna Silks Pvt Ltd">
                                    </div>

                                    <div class="ws-form-group">
                                        <label class="ws-label" for="wsMainContactPhone">Registered Contact Phone <span class="req">*</span></label>
                                        <input type="tel" id="wsMainContactPhone" class="ws-input" placeholder="10-digit mobile number">
                                    </div>

                                    <div class="ws-form-group full">
                                        <label class="ws-label" for="wsFullAddress">Registered Shop / Office / Market Address <span class="req">*</span></label>
                                        <textarea id="wsFullAddress" class="ws-textarea" placeholder="Shop No, Building Name, Textile Market, Street, Landmark"></textarea>
                                    </div>

                                    <div class="ws-form-group">
                                        <label class="ws-label" for="wsCity">City / District <span class="req">*</span></label>
                                        <input type="text" id="wsCity" class="ws-input" placeholder="e.g. Surat">
                                    </div>

                                    <div class="ws-form-group">
                                        <label class="ws-label" for="wsStateSelect">State / UT (India) <span class="req">*</span></label>
                                        <select id="wsStateSelect" class="ws-select">
                                            <option value="Gujarat">Gujarat (24)</option>
                                            <option value="Maharashtra">Maharashtra (27)</option>
                                            <option value="Rajasthan">Rajasthan (08)</option>
                                            <option value="Delhi">Delhi (07)</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh (09)</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh (23)</option>
                                            <option value="Karnataka">Karnataka (29)</option>
                                            <option value="Tamil Nadu">Tamil Nadu (33)</option>
                                            <option value="Telangana">Telangana (36)</option>
                                            <option value="West Bengal">West Bengal (19)</option>
                                            <option value="Other States">Other Indian State / UT</option>
                                        </select>
                                    </div>

                                    <div class="ws-form-group">
                                        <label class="ws-label" for="wsPincode">6-Digit PIN Code <span class="req">*</span></label>
                                        <input type="text" id="wsPincode" class="ws-input" placeholder="395002" maxlength="6" pattern="[0-9]{6}">
                                    </div>
                                </div>
                            </div>

                            <!-- ════ FORM 2: EDIT DELIVERY & SHIPPING DISPATCH HUB ════ -->
                            <div id="wsDispatchSectionWrap" style="display:none; background:#FFFFFF; border:1.5px solid var(--ws-border); border-radius:14px; padding:18px; margin-bottom:18px; box-shadow:0 4px 14px rgba(0,0,0,0.04);">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid var(--ws-border);">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--ws-gold-primary)" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                        <h4 style="font-size:0.95rem; font-weight:800; color:var(--ws-text-main); margin:0; font-family:var(--ws-font-serif);">
                                            Edit Delivery Address
                                        </h4>
                                    </div>
                                    <button type="button" onclick="closeEditAddressDrawer()" style="background:transparent; border:none; color:var(--ws-text-muted); cursor:pointer; font-size:1.1rem; font-weight:800;">✕</button>
                                </div>

                                <!-- Smart Toggle Checkbox Option: Same as Billing Address -->
                                <div style="background:linear-gradient(135deg, #FEFBF4 0%, #FAF5E8 100%); border:1.5px solid rgba(212,175,55,0.4); border-radius:12px; padding:12px 16px; margin-bottom:14px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                                    <label style="display:flex; align-items:center; gap:10px; cursor:pointer; margin:0; user-select:none;">
                                        <input type="checkbox" id="wsSameAsBillingCheckbox" onchange="toggleSameAsBillingAddress(this.checked)" checked style="width:18px; height:18px; accent-color:var(--ws-gold-primary); cursor:pointer;">
                                        <div>
                                            <span style="font-size:0.86rem; font-weight:800; color:var(--ws-text-main);">Shipping / Delivery Address is SAME as Registered Billing Address</span>
                                            <div style="font-size:0.72rem; color:var(--ws-text-muted);">Consignments will be dispatched directly to your primary registered address.</div>
                                        </div>
                                    </label>
                                    <span style="font-size:0.72rem; font-weight:800; background:#DCFCE7; color:#15803D; padding:3px 8px; border-radius:6px; border:1px solid #BBF7D0;" id="wsSameAddressStatusPill">✓ Default Active</span>
                                </div>

                                <!-- Notice when "Same as Billing" is selected (Form is hidden!) -->
                                <div id="wsSameAddressNotice" style="display:block; background:#FAF8F4; border:1px dashed var(--ws-gold-border); border-radius:10px; padding:14px 16px; text-align:center;">
                                    <p style="margin:0; font-size:0.82rem; color:var(--ws-text-sub); font-weight:600;">
                                        ✓ Dispatch destination is set to your <strong>Registered Business Address</strong>.
                                    </p>
                                    <button type="button" onclick="document.getElementById('wsSameAsBillingCheckbox').checked = false; toggleSameAsBillingAddress(false);" style="margin-top:8px; background:transparent; border:none; color:var(--ws-gold-primary); font-size:0.78rem; font-weight:800; cursor:pointer; text-decoration:underline;">+ Specify a different Godown / Warehouse / Transport Hub</button>
                                </div>

                                <!-- Custom Shipping & Dispatch Address Form -->
                                <div id="wsCustomShippingFormWrap" style="display:none; margin-top:14px;">
                                    <div class="ws-form-grid">
                                        <div class="ws-form-group">
                                            <label class="ws-label" for="wsShipWarehouseName">Warehouse / Hub Name <span class="req">*</span></label>
                                            <input type="text" id="wsShipWarehouseName" class="ws-input" placeholder="e.g. Ring Road Godown Hub #4">
                                        </div>

                                        <div class="ws-form-group">
                                            <label class="ws-label" for="wsShipReceiverPhone">Receiver / Gate Phone <span class="req">*</span></label>
                                            <input type="tel" id="wsShipReceiverPhone" class="ws-input" placeholder="10-digit mobile number">
                                        </div>

                                        <div class="ws-form-group full">
                                            <label class="ws-label" for="wsShipAddress">Detailed Godown Address & Landmark <span class="req">*</span></label>
                                            <textarea id="wsShipAddress" class="ws-textarea" placeholder="Gate No, Plot No, Transport Nagar, Street, Landmark"></textarea>
                                        </div>

                                        <div class="ws-form-group">
                                            <label class="ws-label" for="wsShipCity">City / District <span class="req">*</span></label>
                                            <input type="text" id="wsShipCity" class="ws-input" placeholder="e.g. Surat / Ahmedabad">
                                        </div>

                                        <div class="ws-form-group">
                                            <label class="ws-label" for="wsShipStateSelect">State / UT (India) <span class="req">*</span></label>
                                            <select id="wsShipStateSelect" class="ws-select">
                                                <option value="Gujarat">Gujarat (24)</option>
                                                <option value="Maharashtra">Maharashtra (27)</option>
                                                <option value="Rajasthan">Rajasthan (08)</option>
                                                <option value="Delhi">Delhi (07)</option>
                                                <option value="Uttar Pradesh">Uttar Pradesh (09)</option>
                                                <option value="Madhya Pradesh">Madhya Pradesh (23)</option>
                                                <option value="Karnataka">Karnataka (29)</option>
                                                <option value="Tamil Nadu">Tamil Nadu (33)</option>
                                                <option value="Telangana">Telangana (36)</option>
                                                <option value="West Bengal">West Bengal (19)</option>
                                                <option value="Other States">Other Indian State / UT</option>
                                            </select>
                                        </div>

                                        <div class="ws-form-group">
                                            <label class="ws-label" for="wsShipPincode">6-Digit PIN Code <span class="req">*</span></label>
                                            <input type="text" id="wsShipPincode" class="ws-input" placeholder="395002" maxlength="6" pattern="[0-9]{6}">
                                        </div>

                                        <div class="ws-form-group full">
                                            <label class="ws-label" for="wsShipTransporter">Preferred Transporter / Logistics Hub (Optional)</label>
                                            <input type="text" id="wsShipTransporter" class="ws-input" placeholder="e.g. Surat Ring Road Goods Transport, BlueDart Air, V-Trans Cargo">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons: Save or Cancel -->
                            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:14px;">
                                <button type="button" class="ws-btn ws-btn-secondary" onclick="closeEditAddressDrawer()">Cancel</button>
                                <button type="submit" class="ws-btn ws-btn-primary" style="display:inline-flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#FFFFFF" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                                    <span>Save Address</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 5: ORDER LIST
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneOrders">
                <div class="ws-card">
                    <div class="ws-card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                        <div class="ws-card-title-group" style="display:flex; align-items:center; gap:8px;">
                            <div style="width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border:1.5px solid rgba(217, 119, 6, 0.35); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 6px rgba(217,119,6,0.15);">
                                <svg class="ws-anim-stat-ico box" style="width:17px; height:17px;" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            </div>
                            <h3 style="font-family:var(--ws-font-serif); font-size:clamp(1.05rem, 1.8vw, 1.25rem); font-weight:800; color:var(--ws-text-main); margin:0; letter-spacing:0.2px;">
                                Retail Orders
                            </h3>
                        </div>
                        <a href="/shop.php" class="ws-btn-new-order">
                            <span class="ws-new-order-icon-badge">
                                <svg class="ws-anim-plus-bounce" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </span>
                            <span>New Order</span>
                        </a>
                    </div>

                    <!-- Search & Filter Controls -->
                    <div class="ws-filter-controls-row">
                        <!-- Status Filter Pills (1-Line Horizontal Scroll) -->
                        <div class="ws-orders-filter-btns">
                            <button class="ws-rep-filter-btn active" onclick="setOrderStatusFilter('all', this)">All Orders (6)</button>
                            <button class="ws-rep-filter-btn" onclick="setOrderStatusFilter('Shipped', this)">Shipped (2)</button>
                            <button class="ws-rep-filter-btn" onclick="setOrderStatusFilter('Delivered', this)">Delivered (3)</button>
                            <button class="ws-rep-filter-btn" onclick="setOrderStatusFilter('Processing', this)">Processing (1)</button>
                        </div>

                        <!-- Search Bar -->
                        <div class="ws-luxury-search-wrap">
                            <svg class="ws-luxury-search-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" id="wsOrdersSearchInput" class="ws-luxury-search-input" placeholder="Search Order ID, Product, Courier, AWB..." oninput="filterOrdersTable()">
                            <button type="button" class="ws-luxury-search-clear" id="wsOrdersSearchClear" onclick="clearOrdersSearch()" aria-label="Clear Search">✕</button>
                            <button type="button" class="ws-search-action-btn" aria-label="Search">
                                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Desktop Orders Table -->
                    <div class="ws-table-container">
                        <table class="ws-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Product / Lot Details</th>
                                    <th>Qty</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="wsOrdersTbody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Orders Card Feed -->
                    <div class="ws-mobile-order-cards" id="wsMobileOrdersCards">
                        <!-- Populated dynamically by JS -->
                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 6: REPORTS & EXPORT
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneReports">
                <!-- Top 4 KPI Summary Cards for Reports -->
                <div class="ws-report-kpis-grid">
                    <div class="ws-kpi-box">
                        <div class="ws-kpi-label">Total Invoiced Turnover</div>
                        <div class="ws-kpi-num" id="repKpiTurnover" style="color:var(--ws-gold-primary);">₹2,05,062</div>
                        <div class="ws-kpi-sub">100% Cleared GST Invoices</div>
                    </div>
                    <div class="ws-kpi-box">
                        <div class="ws-kpi-label">Input Tax Credit (ITC)</div>
                        <div class="ws-kpi-num" id="repKpiItc" style="color:#10B981;">₹10,253</div>
                        <div class="ws-kpi-sub">GSTR-2B Reconciled (5% GST)</div>
                    </div>
                    <div class="ws-kpi-box">
                        <div class="ws-kpi-label">Total Units Procured</div>
                        <div class="ws-kpi-num" id="repKpiUnits">48 Pcs</div>
                        <div class="ws-kpi-sub">6 Retail Consignments</div>
                    </div>
                    <div class="ws-kpi-box">
                        <div class="ws-kpi-label">Avg. Consignment Value</div>
                        <div class="ws-kpi-num" id="repKpiAvg">₹34,177</div>
                        <div class="ws-kpi-sub">Tier 1 Volume Margin Rates</div>
                    </div>
                </div>

                <div class="ws-card">
                    <div class="ws-card-header" style="flex-wrap:wrap; gap:12px; align-items:center;">
                        <div class="ws-card-title-group">
                            <h3>B2B Retail Procurement Reports</h3>
                        </div>
                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="exportReportsToCsv()">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block; vertical-align:middle;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> <span>Export CSV</span>
                            </button>
                            <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="printWholesaleReport()">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block; vertical-align:middle;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg> <span>Print Report</span>
                            </button>
                        </div>
                    </div>

                    <!-- Filter Pills & Luxury Search Bar -->
                    <div class="ws-filter-controls-row">
                        <div class="ws-filter-pill-group" style="display:flex; gap:6px; flex-wrap:nowrap; overflow-x:auto;">
                            <button class="ws-rep-filter-btn active" onclick="filterReportsByCategory('all', this)">All Categories</button>
                            <button class="ws-rep-filter-btn" onclick="filterReportsByCategory('saree', this)">Sarees</button>
                            <button class="ws-rep-filter-btn" onclick="filterReportsByCategory('lehenga', this)">Lehengas</button>
                            <button class="ws-rep-filter-btn" onclick="filterReportsByCategory('kurti', this)">Kurtis</button>
                            <button class="ws-rep-filter-btn" onclick="filterReportsByCategory('fabric', this)">Fabrics</button>
                        </div>
                        <div class="ws-luxury-search-wrap">
                            <svg class="ws-luxury-search-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" id="reportSearchInput" class="ws-luxury-search-input" placeholder="Search consignment, HSN, SKU, lot..." oninput="handleReportSearch(this.value)">
                            <button type="button" class="ws-luxury-search-clear" id="reportSearchClear" onclick="clearReportSearch()" aria-label="Clear Search">✕</button>
                            <button type="button" class="ws-search-action-btn" aria-label="Search">
                                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Desktop Reports Table View -->
                    <div class="ws-table-container">
                        <table class="ws-table">
                            <thead>
                                <tr>
                                    <th>Consignment</th>
                                    <th>Date</th>
                                    <th>HSN</th>
                                    <th>Product / Lot Details</th>
                                    <th>Qty</th>
                                    <th>Taxable Value</th>
                                    <th>GST (5%)</th>
                                    <th>Net Total</th>
                                    <th>Payment Mode</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="wsReportsTbody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Responsive Reports Card Feed -->
                    <div class="ws-mobile-reports-cards" id="wsMobileReportsCards">
                        <!-- Populated dynamically by JS -->
                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 7: LIVE SHIPMENT & CONSIGNMENT TRACKING
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneTracking">
                <div class="ws-card">
                    <div class="ws-card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:nowrap; gap:10px;">
                        <div class="ws-card-title-group">
                            <h3 style="margin:0; font-size:1.05rem;">Live Consignment Tracking</h3>
                        </div>
                        <span class="ws-status-badge shipped" id="trackHeaderBadge" style="white-space:nowrap; font-size:0.75rem;">⚡ BlueDart Express</span>
                    </div>

                    <!-- Active Tracking Hero Visual Card -->
                    <div id="wsActiveTrackHero" style="background:#FAF8F4; border:1.5px solid var(--ws-gold-border); border-radius:12px; padding:18px; margin-bottom:20px; box-shadow:0 4px 16px rgba(138,104,31,0.08);">
                        <!-- Injected dynamically by JS for active consignment -->
                    </div>

                    <!-- All Consignments Selector Section -->
                    <div style="margin-top:24px; padding-top:18px; border-top:1.5px solid var(--ws-border);">
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                            <h4 style="font-size:0.95rem; font-weight:800; color:var(--ws-text-main); font-family:var(--ws-font-serif); margin:0;">
                                Select Consignment to Track
                            </h4>
                            <div class="ws-filter-pill-group" style="display:flex; gap:6px; flex-wrap:nowrap; overflow-x:auto;">
                                <button class="ws-rep-filter-btn active" onclick="filterTrackingOrders('all', this)">All (6)</button>
                                <button class="ws-rep-filter-btn" onclick="filterTrackingOrders('shipped', this)">In Transit</button>
                                <button class="ws-rep-filter-btn" onclick="filterTrackingOrders('delivered', this)">Delivered</button>
                                <button class="ws-rep-filter-btn" onclick="filterTrackingOrders('processing', this)">Processing</button>
                            </div>
                        </div>

                        <!-- Orders Grid for Tracking -->
                        <div class="ws-track-orders-grid" id="wsTrackingOrdersGrid">
                            <!-- Populated dynamically by JS -->
                        </div>
                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 8: SUPPORT & TICKETS
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneSupport">
                <div class="ws-card">
                    <div class="ws-card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                        <div class="ws-card-title-group">
                            <h3 style="margin:0; font-size:1.05rem;">Retailer Concierge & Support</h3>
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%20DT Brand's%2C%20I%20am%20a%20registered%20Retailer%20and%20require%20urgent%20support" target="_blank" class="ws-btn ws-btn-wa ws-btn-sm" style="display:inline-flex; align-items:center; gap:6px; font-weight:700;">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M17.472 14.382c-.301-.15-1.78-.879-2.056-.979-.275-.1-.475-.15-.675.15-.2.3-.775.979-.95 1.179-.175.2-.35.225-.65.075-.3-.15-1.267-.467-2.414-1.49-1.049-.935-1.758-2.09-1.963-2.44-.205-.35-.022-.54.128-.69.135-.135.301-.35.451-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.675-1.628-.925-2.228-.244-.585-.492-.505-.675-.515-.175-.01-.375-.01-.575-.01-.2 0-.525.075-.8.375s-1.05 1.028-1.05 2.505 1.075 2.905 1.225 3.105c.15.2 2.115 3.23 5.125 4.53 3.01 1.3 3.01.867 3.56.817.55-.05 1.78-.727 2.03-1.428.25-.7.25-1.3.175-1.428-.075-.128-.275-.203-.575-.353z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.435 5.176L2 22l4.981-1.307C8.423 21.536 10.155 22 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18c-1.63 0-3.14-.492-4.407-1.336l-.316-.209-2.955.775.789-2.88-.228-.363C3.965 14.675 3.5 13.385 3.5 12c0-4.687 3.813-8.5 8.5-8.5s8.5 3.813 8.5 8.5-3.813 8.5-8.5 8.5z"/></svg>
                            <span>WhatsApp Concierge</span>
                        </a>
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(clamp(260px, 45vw, 320px), 1fr)); gap:16px;">
                        
                        <!-- Open New Ticket Form -->
                        <div style="background:#FAF8F4; padding:18px; border-radius:12px; border:1.5px solid var(--ws-border); box-shadow:0 2px 8px rgba(0,0,0,0.02);">
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid var(--ws-border);">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--ws-gold-primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                <h4 style="font-size:0.95rem; font-weight:800; color:var(--ws-gold-primary); margin:0; font-family:var(--ws-font-serif);">
                                    Create Support Ticket
                                </h4>
                            </div>

                            <form id="wsTicketForm" onsubmit="handleCreateTicket(event)">
                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketOrderId">Related Order ID <span class="req">*</span></label>
                                    <select id="ticketOrderId" class="ws-select" required>
                                        <option value="KLN-WS-8021">KLN-WS-8021 (Nilambari Silk 12 Pcs)</option>
                                        <option value="KLN-WS-7914">KLN-WS-7914 (Banarasi Zari 8 Pcs)</option>
                                        <option value="KLN-WS-6540">KLN-WS-6540 (Bridal Velvet 4 Pcs)</option>
                                        <option value="General Inquiry">General / Custom Catalog Inquiry</option>
                                    </select>
                                </div>

                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketCategory">Issue Category <span class="req">*</span></label>
                                    <select id="ticketCategory" class="ws-select" required>
                                        <option value="Logistics & Dispatch">Logistics & Dispatch Inquiry</option>
                                        <option value="Bulk Pricing Negotiation">Bulk Lot Pricing & Discount Enquiry</option>
                                        <option value="GST Tax Invoice Issue">GST Input Tax Credit Invoice Query</option>
                                        <option value="Quality Inspection">Sample & Quality Assurance Query</option>
                                    </select>
                                </div>

                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketMessage">Detailed Issue Narrative <span class="req">*</span></label>
                                    <textarea id="ticketMessage" class="ws-textarea" required placeholder="Describe your inquiry or order feedback in detail..."></textarea>
                                </div>

                                <button type="submit" class="ws-btn ws-btn-primary" style="width:100%; height:42px; font-size:0.86rem; font-weight:700; justify-content:center; border-radius:8px; display:inline-flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                    <span>Submit Support Ticket</span>
                                </button>
                            </form>
                        </div>

                        <!-- Ticket History List -->
                        <div>
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid var(--ws-border);">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--ws-gold-primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                <h4 style="font-size:0.95rem; font-weight:800; color:var(--ws-gold-primary); margin:0; font-family:var(--ws-font-serif);">
                                    Support Ticket History
                                </h4>
                            </div>

                            <div class="ws-ticket-list" id="wsTicketList">
                                <!-- Populated dynamically by JS -->
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 9: TRENDING CATALOG (FULL VIEW)
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneTrending">
                <!-- ═══ Check / Procure By Price Smart Box Slider Section ═══ -->
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group" style="display:flex; align-items:center; gap:8px;">
                            <div class="ws-header-icon-badge" style="width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border:1.5px solid rgba(217, 119, 6, 0.35); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 8px rgba(217,119,6,0.18);">
                                <svg class="ws-anim-flame-star" style="width:18px; height:18px;" viewBox="0 0 24 24" fill="none">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" fill="url(#priceTagGoldGrad)" stroke="#B45309" stroke-width="1.6" stroke-linejoin="round"></path>
                                    <circle cx="7" cy="7" r="1.5" fill="#FFFFFF"></circle>
                                    <defs>
                                        <linearGradient id="priceTagGoldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FDE047"/>
                                            <stop offset="50%" stop-color="#F59E0B"/>
                                            <stop offset="100%" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <h3 class="ws-anim-shimmer-title" style="font-family:var(--ws-font-serif); font-size:clamp(0.95rem, 1.6vw, 1.15rem); font-weight:900; margin:0; letter-spacing:0.2px;">
                                Procure By Price Store
                            </h3>
                        </div>
                    </div>

                    <div class="ws-price-slider-wrap">
                        <button class="ws-slider-nav-btn prev" onclick="slidePriceBoxes(-1)" aria-label="Previous"><svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                        <div class="ws-price-slider-track" id="wsPriceSliderTrack">

                            <!-- Tier 1: Under ₹300 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(300, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:18px;height:18px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹300</div>
                            </div>

                            <!-- Tier 2: Under ₹500 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(500, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:18px;height:18px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹500</div>
                            </div>

                            <!-- Tier 3: Under ₹800 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(800, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:18px;height:18px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 3z"></path>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹800</div>
                            </div>

                            <!-- Tier 4: Under ₹1,000 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(1000, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:18px;height:18px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹1,000</div>
                            </div>

                            <!-- Tier 5: Under ₹1,500 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(1500, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:18px;height:18px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <path d="M6 3h12l4 6-10 12L2 9z"></path>
                                        <path d="M11 3L8 9l4 12 4-12-3-6"></path>
                                        <path d="M2 9h20"></path>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹1,500</div>
                            </div>

                            <!-- Tier 6: Under ₹2,000 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(2000, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:18px;height:18px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <path d="M2 4l3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"></path>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹2,000</div>
                            </div>

                        </div>
                        <button class="ws-slider-nav-btn next" onclick="slidePriceBoxes(1)" aria-label="Next"><svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
                    </div>
                </div>

                <!-- ═══ For You Product Grid (Below Price Filter) ═══ -->
                <div class="ws-card" style="margin-top:8px;">
                    <div class="ws-card-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                        <div class="ws-card-title-group" style="display:flex; align-items:center; gap:8px;">
                            <div class="ws-header-icon-badge" style="width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border:1.5px solid rgba(217, 119, 6, 0.35); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 6px rgba(217,119,6,0.15);">
                                <svg class="ws-anim-flame-star" style="width:17px; height:17px;" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2l2.4 5.2 5.6.8-4 4 1 5.6-5-2.8-5 2.8 1-5.6-4-4 5.6-.8L12 2z" fill="url(#goldStarGradForYou)" stroke="#B45309" stroke-width="1.2" stroke-linejoin="round"></path>
                                    <defs>
                                        <linearGradient id="goldStarGradForYou" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FDE047"/>
                                            <stop offset="50%" stop-color="#F59E0B"/>
                                            <stop offset="100%" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <h3 class="ws-anim-shimmer-title" id="wsCatalogMainTitle" style="font-family:var(--ws-font-serif); font-size:clamp(0.95rem, 1.6vw, 1.15rem); font-weight:900; margin:0; letter-spacing:0.2px;">
                                For You
                            </h3>
                        </div>

                        <!-- 1-Tap Category Selector Modal Trigger Button -->
                        <button type="button" onclick="openWsCatalogCategoryModal()" class="ws-cat-picker-btn" style="background:linear-gradient(135deg, #FEF3C7, #FDE68A); border:1px solid rgba(180,83,9,0.3); color:#92400E; font-size:0.75rem; font-weight:800; padding:4px 10px; border-radius:20px; display:inline-flex; align-items:center; gap:5px; cursor:pointer; box-shadow:0 2px 6px rgba(217,119,6,0.12); transition:all 0.2s ease;">
                            <svg viewBox="0 0 24 24" style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.4;"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
                            <span id="wsCatPickerBtnLabel">All Categories ▾</span>
                        </button>
                    </div>

                    <!-- Active Combined Filter Status Banner (Category + Sub-Category + Price Store) -->
                    <div id="wsActiveCategoryFilterBar" class="ws-active-cat-bar" style="display:none; margin-bottom:10px; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:6px; background:linear-gradient(135deg, #FFFBEB, #FEF3C7); border:1px solid rgba(217,119,6,0.25); border-radius:10px; padding:6px 12px;">
                        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                            <span id="wsFilterCategoryPill" style="display:none; background:#B45309; color:#FFF; padding:2px 8px; border-radius:12px; font-size:0.72rem; font-weight:800; align-items:center; gap:5px;">
                                <span id="wsActiveCatName">Kurtis</span>
                                <span onclick="event.stopPropagation(); clearCategoryOnlyFilter();" style="cursor:pointer; font-size:0.8rem; line-height:1;" title="Remove Category">✕</span>
                            </span>
                            <span id="wsFilterSubCategoryPill" style="display:none; background:linear-gradient(135deg, #F59E0B, #D97706); color:#FFF; padding:2px 8px; border-radius:12px; font-size:0.72rem; font-weight:800; align-items:center; gap:5px;">
                                <span id="wsActiveSubCatName">Sharara Sets</span>
                                <span onclick="event.stopPropagation(); clearSubCategoryOnlyFilter();" style="cursor:pointer; font-size:0.8rem; line-height:1;" title="Remove Sub-Category">✕</span>
                            </span>
                            <span id="wsFilterPricePill" style="display:none; background:linear-gradient(135deg, #D97706, #B45309); color:#FFF; padding:2px 8px; border-radius:12px; font-size:0.72rem; font-weight:800; align-items:center; gap:5px;">
                                <span id="wsActivePriceName">Under ₹1,000</span>
                                <span onclick="event.stopPropagation(); clearPriceOnlyFilter();" style="cursor:pointer; font-size:0.8rem; line-height:1;" title="Remove Price Filter">✕</span>
                            </span>
                            <span id="wsActiveCatCount" style="font-size:0.72rem; color:#78350F; font-weight:800;">(5 Lots Available)</span>
                        </div>
                        <button type="button" onclick="clearAllCatalogFilters()" style="background:transparent; border:none; color:#B45309; font-size:0.74rem; font-weight:800; cursor:pointer; text-decoration:underline; padding:0;">✕ Clear All</button>
                    </div>

                    <div class="ws-master-catalog-grid" id="wsForYouSliderTrack">
                        <?php foreach ($catalogProducts as $prod): 
                            $badge_raw = $prod['badge'] ?? 'Bestseller';
                            $badge_slug = strtolower(str_replace([' ', '★'], ['-', ''], $badge_raw));
                            $margin_pct = round((($prod['retail_price'] - $prod['wholesale_price']) / $prod['retail_price']) * 100);
                        ?>
                        <article class="product-card" data-product-id="<?= $prod['id'] ?>" role="listitem">
                            <div class="card-image-wrap">
                                <a href="/Frontend/Single-Product/singleproduct.php?id=<?= $prod['id'] ?>" style="display:block;width:100%;height:100%;">
                                    <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="card-img" onerror="this.src='/Frontend/Retailer/Asset/images/product1.png';" loading="lazy">
                                </a>

                                <!-- Status Badge -->
                                <?php if (!empty($prod['badge'])): ?>
                                <span class="card-badge badge-<?= $badge_slug ?>"><?= htmlspecialchars($prod['badge']) ?></span>
                                <?php endif; ?>

                                <!-- Wishlist Button -->
                                <button type="button" class="card-wishlist-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();toggleWholesaleWishlist(<?= $prod['id'] ?>, this)" aria-label="Wishlist <?= htmlspecialchars($prod['name']) ?>" aria-pressed="false">
                                    <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                </button>

                                <!-- Mobile Quick View Button -->
                                <button type="button" class="card-mobile-qv-btn quick-view-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.openQV==='function'){window.openQV(<?= $prod['id'] ?>);}else{openQuickOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>);}" aria-label="Quick View <?= htmlspecialchars($prod['name']) ?>">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </button>

                                <!-- Desktop Quick View Overlay -->
                                <div class="card-quick-view" aria-hidden="true">
                                    <button type="button" class="quick-view-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.openQV==='function'){window.openQV(<?= $prod['id'] ?>);}else{openQuickOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>);}">Quick View</button>
                                </div>

                                <!-- Share Button on Photo (Directly Above Category Tag) -->
                                <button type="button" class="card-share-btn" data-id="<?= $prod['id'] ?>" aria-label="Share <?= htmlspecialchars($prod['name']) ?>" title="Share <?= htmlspecialchars($prod['name']) ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.shareProductCard==='function'){window.shareProductCard(<?= $prod['id'] ?>);}else{shareWholesaleProduct(<?= htmlspecialchars(json_encode($prod)) ?>);}">
                                    <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                                </button>

                                <!-- Category Box on Photo Bottom-Right Corner -->
                                <span class="card-cat-photo-tag"><?= htmlspecialchars($prod['category']) ?></span>
                            </div>

                            <div class="card-body">
                                <!-- Product Title -->
                                <h2 class="card-name">
                                    <a href="/Frontend/Single-Product/singleproduct.php?id=<?= $prod['id'] ?>" style="color:inherit;text-decoration:none;">
                                        <?= htmlspecialchars($prod['name']) ?>
                                    </a>
                                </h2>

                                <!-- Clean Text Info Row: Available Colors & Sizes -->
                                <div class="card-info-text-row">
                                    <span class="card-colors-text"><?= htmlspecialchars($prod['color']) ?></span>
                                    <span class="card-sizes-text"><?= !empty($prod['moq']) ? 'MOQ: '.$prod['moq'].' Pcs' : 'Free Size' ?></span>
                                </div>

                                <div class="card-price-row">
                                    <div class="card-price-stack">
                                        <span class="card-price">₹<?= number_format($prod['wholesale_price']) ?></span>
                                        <?php if (!empty($prod['retail_price'])): ?>
                                        <span class="card-old-price">₹<?= number_format($prod['retail_price']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Direct Add to Cart '+' Button next to Sale Price -->
                                    <button type="button" class="card-smart-add-cart-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();directAddWholesaleToCart(<?= htmlspecialchars(json_encode($prod)) ?>, this)" aria-label="Add <?= htmlspecialchars($prod['name']) ?> to Cart" title="Direct Add to Cart">
                                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    </button>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <!-- ═══ Mobile Floating Bottom App Dock ═══ -->
    <nav class="ws-mobile-dock" id="wsMobileDock" aria-label="Mobile Navigation">
        <button class="ws-dock-btn active" id="dockBtnOverview" onclick="switchWsTab('overview')">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span>Overview</span>
        </button>
        <button class="ws-dock-btn" id="dockBtnOrders" onclick="switchWsTab('orders')">
            <svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            <span>Orders</span>
        </button>
        <button class="ws-dock-btn" id="dockBtnTrending" onclick="switchWsTab('trending'); openWsCatalogCategoryModal();">
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <span>Catalog</span>
        </button>
        <button class="ws-dock-btn" id="dockBtnReports" onclick="switchWsTab('reports')">
            <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
            <span>Reports</span>
        </button>
        <button class="ws-dock-btn" id="dockBtnCart" onclick="if(typeof window.openCartDrawer==='function'){window.openCartDrawer();}else if(typeof window.openCart==='function'){window.openCart();}" aria-label="Shopping Cart">
            <div style="position:relative; display:inline-flex;">
                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="ws-dock-cart-badge" id="wsDockCartBadge" style="display:none;">0</span>
            </div>
            <span>Cart</span>
        </button>
    </nav>

    <!-- ═══════════════════════════════════════════
         SMART RETAIL CATEGORY & SUB-CATEGORY POPUP MODAL
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsCatalogCategoryModal" role="dialog" aria-modal="true" onclick="if(event.target===this) closeWsCatalogCategoryModal();">
        <div class="ws-modal-box ws-cat-modal-box" style="max-width: 620px; border-radius: 20px; background: linear-gradient(165deg, #FFFFFF 0%, #FDFBF7 100%); border: 1.5px solid rgba(180, 83, 9, 0.28); box-shadow: 0 20px 60px rgba(0,0,0,0.22), 0 0 0 1px rgba(212, 175, 55, 0.25);">
            
            <div class="ws-modal-header" style="padding: 14px 18px 12px; border-bottom: 1px solid rgba(180, 83, 9, 0.15); background: linear-gradient(135deg, #FEFBF4 0%, #FAF5E8 100%); border-radius: 18px 18px 0 0; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <button id="wsCatModalBackBtn" onclick="renderMainCategoriesInModal()" type="button" style="display:none; background:rgba(180,83,9,0.1); border:1px solid rgba(180,83,9,0.25); color:#92400E; font-size:0.72rem; font-weight:800; padding:4px 8px; border-radius:8px; cursor:pointer;">← Main</button>
                    <div id="wsCatModalIconWrap" style="width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg, #FEF3C7, #FDE68A); border:1.5px solid rgba(217,119,6,0.4); display:flex; align-items:center; justify-content:center; box-shadow:0 3px 8px rgba(217,119,6,0.18);">
                        <svg style="width:17px; height:17px;" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2l3 7 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1 3-7z" fill="url(#catModalGoldGrad)" stroke="#B45309" stroke-width="1.2"/>
                            <defs>
                                <linearGradient id="catModalGoldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#FDE047"/>
                                    <stop offset="50%" stop-color="#F59E0B"/>
                                    <stop offset="100%" stop-color="#D97706"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <h3 id="wsCatModalHeaderTitle" style="font-family:var(--ws-font-serif); font-size:1.02rem; font-weight:900; color:#1E1B18; margin:0; letter-spacing:0.2px;">
                        Select Category
                    </h3>
                </div>
                <button class="ws-modal-close-btn" onclick="closeWsCatalogCategoryModal()" aria-label="Close Modal" style="font-size:1.4rem; color:#92400E; width:30px; height:30px; border-radius:50%; background:rgba(180,83,9,0.08); border:none; display:flex; align-items:center; justify-content:center; cursor:pointer;">&times;</button>
            </div>

            <div class="ws-modal-body" style="padding: 14px 18px 18px;">
                <div class="ws-cat-modal-grid" id="wsCatModalDynamicGrid">
                    <!-- Rendered dynamically by JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         SMART EDIT MAIN REGISTERED BILLING ADDRESS MODAL
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsEditMainAddressModal" role="dialog" aria-modal="true" onclick="if(event.target===this) closeEditMainAddressModal();">
        <div class="ws-modal-box" style="max-width: 560px; border-radius: 18px; background:#FFFFFF; border: 1.5px solid rgba(180, 83, 9, 0.28); box-shadow: 0 20px 60px rgba(0,0,0,0.22);">
            
            <div class="ws-modal-header" style="padding: 14px 18px; border-bottom: 1px solid rgba(180, 83, 9, 0.15); background: linear-gradient(135deg, #FEFBF4 0%, #FAF5E8 100%); border-radius: 16px 16px 0 0; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg, #FEF3C7, #FDE68A); border:1.5px solid rgba(217,119,6,0.4); display:flex; align-items:center; justify-content:center;">
                        <svg style="width:17px; height:17px;" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-family:var(--ws-font-serif); font-size:1.02rem; font-weight:900; color:#1E1B18; margin:0;">
                            Edit Registered Main Address
                        </h3>
                        <div style="font-size:0.70rem; color:var(--ws-text-muted);">GST Invoicing & Primary Business Premises</div>
                    </div>
                </div>
                <button class="ws-modal-close-btn" onclick="closeEditMainAddressModal()" aria-label="Close Modal" style="font-size:1.4rem; color:#92400E; width:30px; height:30px; border-radius:50%; background:rgba(180,83,9,0.08); border:none; display:flex; align-items:center; justify-content:center; cursor:pointer;">&times;</button>
            </div>

            <form onsubmit="handleSaveMainAddressForm(event)" style="padding: 16px 18px 20px;">
                <div class="ws-form-grid">
                    
                    <div class="ws-form-group">
                        <label class="ws-label" for="wsMainEditCompName">Business / Company Name <span class="req">*</span></label>
                        <input type="text" id="wsMainEditCompName" class="ws-input" required placeholder="e.g. Shree Krishna Silks Pvt Ltd">
                    </div>

                    <div class="ws-form-group">
                        <label class="ws-label" for="wsMainEditGstNumber">GSTIN (Tax ID) <span class="req">*</span></label>
                        <input type="text" id="wsMainEditGstNumber" class="ws-input" maxlength="15" style="text-transform:uppercase;" placeholder="24AABCU9603R1ZM">
                    </div>

                    <div class="ws-form-group full">
                        <label class="ws-label" for="wsMainEditAddress">Registered Street Address & Market <span class="req">*</span></label>
                        <textarea id="wsMainEditAddress" class="ws-textarea" required placeholder="Shop No, Building Name, Textile Market, Street, Landmark"></textarea>
                    </div>

                    <div class="ws-form-group">
                        <label class="ws-label" for="wsMainEditCity">City / District <span class="req">*</span></label>
                        <input type="text" id="wsMainEditCity" class="ws-input" required placeholder="e.g. Surat">
                    </div>

                    <div class="ws-form-group">
                        <label class="ws-label" for="wsMainEditState">State / UT <span class="req">*</span></label>
                        <select id="wsMainEditState" class="ws-select" required>
                            <option value="Gujarat">Gujarat (24)</option>
                            <option value="Maharashtra">Maharashtra (27)</option>
                            <option value="Rajasthan">Rajasthan (08)</option>
                            <option value="Delhi">Delhi (07)</option>
                            <option value="Uttar Pradesh">Uttar Pradesh (09)</option>
                            <option value="Madhya Pradesh">Madhya Pradesh (23)</option>
                            <option value="Karnataka">Karnataka (29)</option>
                            <option value="Tamil Nadu">Tamil Nadu (33)</option>
                            <option value="Telangana">Telangana (36)</option>
                            <option value="West Bengal">West Bengal (19)</option>
                            <option value="Other States">Other Indian State / UT</option>
                        </select>
                    </div>

                    <div class="ws-form-group">
                        <label class="ws-label" for="wsMainEditPincode">6-Digit PIN Code <span class="req">*</span></label>
                        <input type="text" id="wsMainEditPincode" class="ws-input" required maxlength="6" pattern="[0-9]{6}" placeholder="395002">
                    </div>

                    <div class="ws-form-group">
                        <label class="ws-label" for="wsMainEditContactPhone">Contact Mobile <span class="req">*</span></label>
                        <input type="tel" id="wsMainEditContactPhone" class="ws-input" required placeholder="10-digit phone">
                    </div>

                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:16px;">
                    <button type="button" class="ws-btn ws-btn-secondary" onclick="closeEditMainAddressModal()">Cancel</button>
                    <button type="submit" class="ws-btn ws-btn-primary" style="display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#FFFFFF" stroke-width="2.2"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Update Main Address</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 1: FULL ORDER DETAILS MODAL
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsOrderDetailsModal" role="dialog" aria-modal="true" onclick="if(event.target===this) closeOrderDetailsModal();">
        <div class="ws-modal-box" style="max-width: 620px;">
            <div class="ws-modal-header">
                <h3 class="ws-modal-title">
                    <svg style="width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2.2;" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span id="modalOrderTitle">Order Details #KLN-WS-8021</span>
                </h3>
                <button class="ws-modal-close-btn" onclick="closeOrderDetailsModal()" aria-label="Close Modal">&times;</button>
            </div>
            <div class="ws-modal-body" id="modalOrderBody">
                <!-- Injected dynamically by JS -->
            </div>
            <div class="ws-modal-footer" id="modalOrderFooter">
                <!-- Action buttons placed cleanly here so they are NEVER cut off -->
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 2: PRINTABLE GST B2B TAX INVOICE
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsBillInvoiceModal" role="dialog" aria-modal="true" onclick="if(event.target===this) closeBillInvoiceModal();">
        <div class="ws-modal-box" style="max-width: 820px; padding: 0; background: #FFFFFF; border-radius: 14px; overflow: hidden; border: 1.5px solid rgba(138, 104, 31, 0.35);">
            <div class="ws-modal-header" style="padding: 12px 18px; background: #FAF8F4; border-bottom: 1px solid #E5E7EB; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#8A681F" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <h3 class="ws-modal-title" style="margin: 0; font-size: 0.95rem; font-weight: 800; color: #1F2937;">
                        <span>GST B2B Tax Invoice</span>
                    </h3>
                </div>
                <div style="display:flex; gap:10px; align-items:center;">
                    <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="printInvoiceSheet()" style="display:inline-flex; align-items:center; gap:6px; font-weight:700; padding:6px 14px; font-size:0.76rem;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        <span>Print / Save PDF</span>
                    </button>
                    <button class="ws-modal-close-btn" onclick="closeBillInvoiceModal()" aria-label="Close Modal" style="font-size: 1.4rem; color: #6B7280; width: 28px; height: 28px;">&times;</button>
                </div>
            </div>
            
            <div class="ws-tax-invoice-wrapper">
                <div class="ws-tax-invoice-container" id="invoicePrintArea">
                    <!-- Title Header -->
                    <div class="ws-ti-title-header">Tax Invoice</div>

                    <!-- Top Seller Box: Arniya Logo, Address, Contact & Email -->
                    <div class="ws-ti-top-seller-box">
                        <div class="ws-ti-seller-brand">
                            <!-- Arniya Stylized Calligraphy Logo Emblem -->
                            <div style="display:flex; align-items:center; gap:8px;">
                                <svg viewBox="0 0 120 48" style="height:42px; width:auto;">
                                    <defs>
                                        <linearGradient id="arniyaGoldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#8A681F"/>
                                            <stop offset="50%" stop-color="#B45309"/>
                                            <stop offset="100%" stop-color="#78350F"/>
                                        </linearGradient>
                                    </defs>
                                    <!-- Stylized 'A' Crest -->
                                    <path d="M12 40L24 6l12 34M17 28h14" stroke="url(#arniyaGoldGrad)" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                    <circle cx="24" cy="4" r="2.2" fill="#B45309"/>
                                    <!-- Arniya Text -->
                                    <text x="42" y="26" font-family="'Cinzel', serif, Georgia" font-size="20" font-weight="900" fill="#1E1B18" letter-spacing="1">Arniya</text>
                                    <text x="108" y="16" font-family="sans-serif" font-size="9" font-weight="bold" fill="#B45309">®</text>
                                    <text x="42" y="38" font-family="sans-serif" font-size="6.5" font-weight="700" fill="#8A681F" letter-spacing="1.2">MADE FOR CELEBRATIONS</text>
                                </svg>
                            </div>
                            <div class="ws-ti-seller-info">
                                <h3>Arniya®</h3>
                                <p>
                                    Shop No-246<br>
                                    Sankruti AC Market Nearby The Fabrizo,<br>
                                    Surat Gujarat<br>
                                    Phone: <strong>+91 87990 46736</strong><br>
                                    State: <strong>24-Gujarat</strong>
                                </p>
                            </div>
                        </div>
                        <div class="ws-ti-seller-meta">
                            Email: <strong>info@arniya.in</strong>
                        </div>
                    </div>

                    <!-- 2-Column Grid for Bill To & Invoice Details -->
                    <div class="ws-ti-grid-2col">
                        <!-- Left: Bill To -->
                        <div class="ws-ti-cell-billto">
                            <div class="ws-ti-cell-header">Bill To:</div>
                            <div id="invBillToBody" style="line-height:1.42;">
                                <strong id="invBuyerName">Siddannagouda Patil</strong><br>
                                <span id="invBuyerCompany">Patil Cloth Bazar</span><br>
                                <span id="invBuyerAddress">Sumbad Road Yedrami kalaburgi Dist</span><br>
                                City: <span id="invBuyerCity">kalaburgi</span><br>
                                States : <span id="invBuyerState">Karnataka</span><br>
                                PIN code: <span id="invBuyerPin">585325</span><br>
                                M/n :- <span id="invBuyerAltPhone">6361616801</span><br>
                                Contact No: <strong id="invBuyerPhone">9740455555</strong> &nbsp;&nbsp;&nbsp; GSTIN Number: <strong id="invBuyerGst">29CFZPV1455E1ZO</strong><br>
                                State: <strong id="invBuyerStateCode">29-Karnataka</strong>
                            </div>
                        </div>

                        <!-- Right: Invoice Details -->
                        <div class="ws-ti-cell-invmeta">
                            <div class="ws-ti-cell-header">Invoice Details:</div>
                            <div style="line-height:1.5;">
                                No: <strong id="invNum">1023</strong><br>
                                Date: <strong id="invDate">20-04-2026</strong><br>
                                Place of Supply: <strong id="invPlaceOfSupply">29-Karnataka</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Ship To Box -->
                    <div class="ws-ti-shipto-box">
                        <div class="ws-ti-cell-header">Ship To:</div>
                        <div id="invShipToBody" style="line-height:1.4;">
                            <strong id="invShipCompany">Patil Cloth Bazar</strong><br>
                            <span id="invShipAddress">Vrl near Delivery Point : Jevargi</span><br>
                            <span id="invShipCityPin">kalaburgi Dist 585310</span><br>
                            Number : <span id="invShipPhone">9740455555, 6361616801</span>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <table class="ws-ti-items-table">
                        <thead>
                            <tr>
                                <th style="width:30px; text-align:center;">#</th>
                                <th style="text-align:left;">Item Name</th>
                                <th style="width:75px; text-align:center;">HSN/ SAC</th>
                                <th style="width:65px; text-align:right;">Quantity</th>
                                <th style="width:85px; text-align:right;">Price/ Unit (₹)</th>
                                <th style="width:105px; text-align:right;">GST(₹)</th>
                                <th style="width:100px; text-align:right;">Amount(₹)</th>
                            </tr>
                        </thead>
                        <tbody id="invItemsTbody">
                            <!-- Injected dynamically by JS -->
                        </tbody>
                        <tfoot>
                            <tr class="ws-ti-total-row">
                                <td colspan="2" style="font-weight:800; text-align:left; padding-left:12px;">Total</td>
                                <td></td>
                                <td style="text-align:right; font-weight:800;" id="invTableTotalQty">373</td>
                                <td></td>
                                <td style="text-align:right; font-weight:800;" id="invTableTotalGst">₹ 1,492.25</td>
                                <td style="text-align:right; font-weight:800;" id="invTableTotalAmount">₹ 31,337.25</td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Bottom Split: Tax Summary on Left, Calculation on Right -->
                    <div class="ws-ti-bottom-split">
                        <!-- Left Column: Tax Summary -->
                        <div class="ws-ti-tax-summary-col">
                            <div class="ws-ti-tax-summary-title">Tax Summary:</div>
                            <table class="ws-ti-tax-subtable">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="text-align:left; vertical-align:middle;">HSN/ SAC</th>
                                        <th rowspan="2" style="text-align:right; vertical-align:middle;">Taxable Amount (₹)</th>
                                        <th colspan="2" style="text-align:center;" id="invTaxTypeHeader">IGST</th>
                                        <th rowspan="2" style="text-align:right; vertical-align:middle;">Total Tax(₹)</th>
                                    </tr>
                                    <tr>
                                        <th style="font-size:9px;">Rate (%)</th>
                                        <th style="font-size:9px;">Amt (₹)</th>
                                    </tr>
                                </thead>
                                <tbody id="invTaxSummaryTbody">
                                    <!-- Injected dynamically -->
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight:800; background:#FAFAFA;">
                                        <td style="text-align:left;">TOTAL</td>
                                        <td style="text-align:right;" id="invTaxableTotalVal">29,845.00</td>
                                        <td></td>
                                        <td style="text-align:right;" id="invTaxIgstAmt">1,492.25</td>
                                        <td style="text-align:right;" id="invTaxGrandTotal">1,492.25</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Right Column: Net Calculation & Amount In Words -->
                        <div class="ws-ti-net-calc-col">
                            <div class="ws-ti-calc-row">
                                <span>Sub Total</span>
                                <span>: <strong id="invSubTotalRight">₹ 31,337.25</strong></span>
                            </div>
                            <div class="ws-ti-calc-row" style="background:#FAFAFA; font-weight:800;">
                                <span>Total</span>
                                <span>: <strong id="invTotalRight">₹ 31,337.25</strong></span>
                            </div>
                            <div class="ws-ti-words-box">
                                <div style="font-weight:700; color:#374151; font-size:10px;">Invoice Amount In Words :</div>
                                <div id="invAmountInWords" style="font-weight:600; color:#111827; margin-top:2px; font-size:10px;">
                                    Thirty One Thousand Three Hundred and Thirty Seven Rupees and Twenty Five Paisa only
                                </div>
                            </div>
                            <div class="ws-ti-calc-row">
                                <span>Received</span>
                                <span>: <span id="invReceived">₹ 0.00</span></span>
                            </div>
                            <div class="ws-ti-calc-row" style="border-bottom:none; font-weight:800;">
                                <span>Balance</span>
                                <span>: <strong id="invBalance">₹ 31,337.25</strong></span>
                            </div>
                        </div>
                    </div>

                    <!-- Terms And Conditions -->
                    <div class="ws-ti-terms-row">
                        <strong>Terms And Conditions:</strong>
                        <div style="color:#4B5563; margin-top:2px;">Thank you for doing business with us.</div>
                    </div>

                    <!-- Footer: Authorized Signature Box -->
                    <div class="ws-ti-footer-sign-row" style="display:flex; justify-content:flex-end; padding:10px 14px 12px;">
                        <div class="ws-ti-sign-box">
                            <div style="font-weight:800; font-size:11px; margin-bottom:8px;">For Arniya®:</div>
                            <!-- Vector Signature Emblem -->
                            <div style="height:32px; display:flex; align-items:center; justify-content:center;">
                                <svg viewBox="0 0 100 35" style="width:78px; height:28px;">
                                    <path d="M5 25 Q 20 5, 35 22 T 60 12 Q 75 30, 95 15" stroke="#1E293B" stroke-width="1.8" fill="none" stroke-linecap="round"/>
                                    <path d="M22 28 Q 50 32, 85 24" stroke="#1E293B" stroke-width="1.2" fill="none"/>
                                </svg>
                            </div>
                            <div style="font-size:10px; color:#4B5563; margin-top:4px; border-top:1px dashed #9CA3AF; padding-top:2px;">Authorized Signatory</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 2.5: FORMAL PRINTABLE RETAIL PROCUREMENT AUDIT REPORT
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsPrintableAuditReportModal" role="dialog" aria-modal="true" onclick="if(event.target===this) closePrintableAuditReportModal();">
        <div class="ws-modal-box" style="max-width: 820px;">
            <div class="ws-modal-header">
                <h3 class="ws-modal-title">
                    <span>📊 Retail B2B Sales & Procurement Audit Statement</span>
                </h3>
                <div style="display:flex; gap:8px; align-items:center;">
                    <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="window.print()">
                        🖨️ Print Statement
                    </button>
                    <button class="ws-modal-close-btn" onclick="closePrintableAuditReportModal()" aria-label="Close Modal">&times;</button>
                </div>
            </div>
            <div class="ws-modal-body">
                <div class="ws-invoice-sheet">
                    <div class="ws-inv-header">
                        <div class="ws-inv-brand">
                            <h2>DT BRAND'S B2B</h2>
                            <p><strong>DT Brand's Retail Procurement & Logistics Ledger</strong><br>
                            Surat Silk Cluster, Ring Road, Surat, Gujarat - 395002<br>
                            GSTIN: 24AABCK4820P1Z8 | Input Tax Credit (ITC) Reconciled</p>
                        </div>
                        <div class="ws-inv-meta">
                            <p><strong>PROCUREMENT AUDIT</strong></p>
                            <p>Fiscal Cycle: <strong>FY 2026-27</strong></p>
                            <p>Tax Compliance: <span style="color:#10B981; font-weight:700;">100% GSTR-1 Verified</span></p>
                        </div>
                    </div>

                    <div style="background:#FAF8F4; border:1px solid var(--ws-border); border-radius:8px; padding:12px; margin-bottom:14px; font-size:0.80rem;" id="auditReportBuyerInfo">
                        <!-- Populated by JS -->
                    </div>

                    <div class="ws-inv-items-table-wrap">
                        <table class="ws-inv-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Consignment ID</th>
                                    <th>Date</th>
                                    <th>HSN</th>
                                    <th>Product Details</th>
                                    <th>Qty</th>
                                    <th>Taxable Base</th>
                                    <th>GST (5%)</th>
                                    <th>Net Total</th>
                                    <th>Payment Instrument</th>
                                </tr>
                            </thead>
                            <tbody id="auditReportTbody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>

                    <div class="ws-inv-totals-box">
                        <div class="ws-inv-tot-row">
                            <span>Total Procured Units:</span>
                            <strong id="auditTotalQty">48 Pcs</strong>
                        </div>
                        <div class="ws-inv-tot-row">
                            <span>Total Taxable Base:</span>
                            <strong id="auditTotalSub">₹1,95,297</strong>
                        </div>
                        <div class="ws-inv-tot-row">
                            <span>Total GST ITC (5%):</span>
                            <strong id="auditTotalTax" style="color:#10B981;">₹10,253</strong>
                        </div>
                        <div class="ws-inv-tot-row grand">
                            <span>Total Settled Procurement:</span>
                            <span id="auditTotalGrand">₹2,05,062</span>
                        </div>
                    </div>

                    <div class="ws-inv-footer-note">
                        <div>
                            <p>Certified B2B retail statement generated for statutory tax filing & ledger accounting.</p>
                            <p>All textiles dispatched comply with Surat Silk Weaver Guild certified standards.</p>
                        </div>
                        <div style="text-align:center;">
                            <div style="width:120px; border-bottom:1.5px solid var(--ws-gold-primary); margin-bottom:4px;"></div>
                            <strong>Chief Logistics Officer</strong><br>
                            DT Brand's B2B Hub
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 2.7: FULL B2B RETAIL GOLD WALLET & PASSBOOK
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsFullWalletModal" role="dialog" aria-modal="true" onclick="if(event.target===this) closeFullWalletModal();">
        <div class="ws-modal-box" style="max-width: 640px;">
            <div class="ws-modal-header">
                <div style="display:flex; align-items:center; gap:8px;">
                    <button class="ws-modal-close-btn" onclick="closeFullWalletModal()" aria-label="Back" title="Back" style="width:30px; height:30px;">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    </button>
                    <h3 class="ws-modal-title" style="margin:0; font-size:0.95rem;">
                        <span>Gold Wallet & Passbook</span>
                    </h3>
                </div>
                <button class="ws-modal-close-btn" onclick="closeFullWalletModal()" aria-label="Close Modal" style="width:30px; height:30px;">&times;</button>
            </div>
            <div class="ws-modal-body">
                <!-- Dual Balance Cards Grid -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:14px;">
                    <!-- Available Balance Card -->
                    <div class="ws-full-wallet-card">
                        <div class="ws-full-card-top">
                            <div class="ws-full-card-badge">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z"></path><path d="M15 10h5a2 2 0 0 1 2 2v0a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v0a2 2 0 0 1 2-2z"></path><circle cx="18" cy="12" r="1"></circle></svg>
                                <span>Available Balance</span>
                            </div>
                            <span class="ws-full-card-pill">Active</span>
                        </div>
                        <div class="ws-full-card-val" id="fullModalWalletBal">₹1,45,280</div>
                    </div>

                    <!-- Silk Reward Coins Card -->
                    <div class="ws-full-wallet-card coin">
                        <div class="ws-full-card-top">
                            <div class="ws-full-card-badge coin">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none"><circle cx="12" cy="12" r="9" fill="#F59E0B" stroke="#D97706" stroke-width="1.2"></circle><circle cx="12" cy="12" r="6.5" stroke="#FFFFFF" stroke-dasharray="2 1" stroke-width="0.8"></circle><path d="M10 8h4M10 11h3.5M10 8v8M12.5 11c1.4 0 1.8 1 1.8 1.8s-.4 1.8-1.8 1.8h-2.5" stroke="#78350F" stroke-width="1.3" stroke-linecap="round"></path></svg>
                                <span>Silk Coins</span>
                            </div>
                            <span class="ws-full-card-pill coin">50 Coins = ₹1</span>
                        </div>
                        <div class="ws-full-card-val gold" id="fullModalCoinsBal">3,850 Coins</div>
                        <div class="ws-full-card-sub">Worth <strong>₹77</strong> Cash Discount</div>
                    </div>
                </div>

                <!-- Passbook / Statement Table -->
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <h4 style="font-size:0.86rem; font-weight:800; color:var(--ws-text-main); margin:0; font-family:var(--ws-font-serif); display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="var(--ws-gold-primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Recent Passbook Transactions</span>
                    </h4>
                </div>
                <div style="border:1.5px solid var(--ws-border); border-radius:10px; overflow:hidden; background:#FFFFFF; box-shadow:0 2px 8px rgba(0,0,0,0.03);">
                    <!-- Row 1: RTGS Top-Up -->
                    <div class="ws-txn-row">
                        <div class="ws-txn-icon-wrap green">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                        </div>
                        <div class="ws-txn-info">
                            <strong>Wallet Top-Up (RTGS)</strong>
                            <span>14 Aug 2026, 11:20 AM • UTR #RTGS992104</span>
                        </div>
                        <div class="ws-txn-amt">
                            <strong style="color:#15803D;">+₹50,000</strong>
                            <span class="ws-txn-badge green">Credited</span>
                        </div>
                    </div>

                    <!-- Row 2: Order Deduction -->
                    <div class="ws-txn-row">
                        <div class="ws-txn-icon-wrap red">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        </div>
                        <div class="ws-txn-info">
                            <strong>Order Deduction #KLN-WS-8021</strong>
                            <span>14 Aug 2026, 10:30 AM • 12 Pcs Silk Lot</span>
                        </div>
                        <div class="ws-txn-amt">
                            <strong style="color:#DC2626;">-₹38,308</strong>
                            <span class="ws-txn-badge red">Debited</span>
                        </div>
                    </div>

                    <!-- Row 3: Cashback Coins -->
                    <div class="ws-txn-row">
                        <div class="ws-txn-icon-wrap amber">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M12 6v12M15 9.5a2.5 2.5 0 0 0-5 0c0 2.5 5 1.5 5 4a2.5 2.5 0 0 1-5 0"></path></svg>
                        </div>
                        <div class="ws-txn-info">
                            <strong>Silk Cashback Coins Reward</strong>
                            <span>12 Aug 2026, 04:15 PM • Volume Order Bonus</span>
                        </div>
                        <div class="ws-txn-amt">
                            <strong style="color:#D97706;">+500 Coins</strong>
                            <span class="ws-txn-badge amber">Earned</span>
                        </div>
                    </div>

                    <!-- Row 4: Settlement -->
                    <div class="ws-txn-row">
                        <div class="ws-txn-icon-wrap blue">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <div class="ws-txn-info">
                            <strong>Consignment Advance Settlement</strong>
                            <span>10 Aug 2026, 02:00 PM • Credit Line Release</span>
                        </div>
                        <div class="ws-txn-amt">
                            <strong style="color:#1D4ED8;">+₹1,00,000</strong>
                            <span class="ws-txn-badge blue">Restored</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ws-modal-footer" style="display:grid; grid-template-columns:1fr 1fr; gap:10px; padding:12px 16px; background:#FFFFFF; border-top:1.5px solid var(--ws-border);">
                <!-- Button 1: Download Statement -->
                <button class="ws-btn ws-btn-primary" style="height:42px; justify-content:center; font-size:0.78rem; font-weight:800; padding:0 10px;" onclick="window.showWsToast('📄 Full GSTR Passbook Statement downloaded (PDF)!')">
                    <svg class="ws-anim-dl-icon" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download Statement</span>
                </button>

                <!-- Button 2: Withdraw Balance -->
                <button class="ws-btn ws-btn-secondary" style="height:42px; justify-content:center; font-size:0.78rem; font-weight:800; padding:0 10px; border:1.5px solid rgba(197, 168, 89, 0.6); color:var(--ws-gold-primary); background:linear-gradient(135deg, #FFFFFF 0%, #FEF3C7 100%);" onclick="requestWalletWithdrawal()">
                    <svg class="ws-anim-withdraw-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="M12 9v6M9 12h6"></path><path d="M16 8l3-3M19 8V5h-3"></path></svg>
                    <span>Withdraw Balance</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 2.75: VIP TIER ROADMAP & BENEFITS
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsVipTierModal" role="dialog" aria-modal="true" onclick="if(event.target===this) closeVipTierModal();">
        <div class="ws-modal-box" style="max-width: 540px;">
            <div class="ws-modal-header">
                <div style="display:flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none"><path d="M2 4l3 12h14l3-12-6 7-4-7-4 7-6-7z" fill="#D4AF37" stroke="#92400E" stroke-width="1.2" stroke-linejoin="round"></path><circle cx="12" cy="3" r="1.5" fill="#F59E0B"></circle><circle cx="4" cy="4" r="1.2" fill="#F59E0B"></circle><circle cx="20" cy="4" r="1.2" fill="#F59E0B"></circle></svg>
                    <h3 class="ws-modal-title" style="margin:0; font-size:0.92rem; font-weight:800;">
                        <span>VIP Account Tier Roadmap</span>
                    </h3>
                </div>
                <button class="ws-modal-close-btn" onclick="closeVipTierModal()" aria-label="Close Modal" style="width:28px; height:28px;">&times;</button>
            </div>
            <div class="ws-modal-body" style="padding:14px 16px;">
                <!-- Current Active Tier Card -->
                <div style="background:linear-gradient(135deg, #FFFFFF 0%, #FEFAF0 100%); border:1.5px solid rgba(212,175,55,0.55); border-radius:12px; padding:12px 14px; margin-bottom:12px; box-shadow:0 4px 14px rgba(180,140,40,0.08);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                        <span style="font-size:0.65rem; font-weight:800; text-transform:uppercase; color:#8A681F; letter-spacing:0.5px;">Current Active Tier</span>
                        <span class="ws-txn-badge green" style="font-size:0.58rem; font-weight:800;">6 / 50 Orders Completed</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none"><circle cx="12" cy="12" r="9" fill="#10B981" fill-opacity="0.15" stroke="#10B981" stroke-width="1.5"></circle><path d="M9 12l2 2 4-4" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        <div style="font-size:1.15rem; font-weight:900; color:#16130F; letter-spacing:0.2px;">
                            Tier 1: Non-VIP
                        </div>
                    </div>
                    <div style="font-size:0.72rem; color:#57534E; margin-bottom:8px; line-height:1.3;">
                        Complete <strong>44 more orders</strong> to automatically unlock <strong>Tier 2: Silver</strong> with a extra margin rebate!
                    </div>
                    <!-- Progress Bar -->
                    <div style="height:6px; background:#F1ECE1; border-radius:4px; overflow:hidden;">
                        <div style="height:100%; width:12%; background:linear-gradient(90deg, #10B981, #059669); border-radius:4px;"></div>
                    </div>
                </div>

                <!-- 5-Tier Level Cards List with Real Vector SVGs -->
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <!-- Tier 1: Non VIP -->
                    <div class="ws-tier-card active">
                        <div class="ws-tier-card-left">
                            <div class="ws-tier-icon-wrap green">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#15803D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                            <div class="ws-tier-info">
                                <strong>Tier 1: Non-VIP (1 to 50 Orders)</strong>
                            </div>
                        </div>
                        <span class="ws-tier-badge active">ACTIVE</span>
                    </div>

                    <!-- Tier 2: Silver (50 to 250 Orders) -->
                    <div class="ws-tier-card">
                        <div class="ws-tier-card-left">
                            <div class="ws-tier-icon-wrap silver">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none"><circle cx="12" cy="12" r="9" fill="#94A3B8" fill-opacity="0.2" stroke="#64748B" stroke-width="1.5"></circle><polygon points="12 6 13.8 9.6 17.8 10.2 14.9 13 15.6 17 12 15.1 8.4 17 9.1 13 6.2 10.2 10.2 9.6" fill="#64748B"></polygon></svg>
                            </div>
                            <div class="ws-tier-info">
                                <strong>Tier 2: Silver (50 to 250 Orders)</strong>
                            </div>
                        </div>
                        <span class="ws-tier-badge silver">50–250 ORDERS</span>
                    </div>

                    <!-- Tier 3: Gold (250 to 450 Orders) -->
                    <div class="ws-tier-card">
                        <div class="ws-tier-card-left">
                            <div class="ws-tier-icon-wrap gold">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none"><circle cx="12" cy="12" r="9" fill="#F59E0B" fill-opacity="0.2" stroke="#D97706" stroke-width="1.5"></circle><path d="M7 15l2-6 3 3 3-3 2 6H7z" fill="#D97706"></path><circle cx="12" cy="7" r="1.5" fill="#B45309"></circle></svg>
                            </div>
                            <div class="ws-tier-info">
                                <strong>Tier 3: Gold (250 to 450 Orders)</strong>
                            </div>
                        </div>
                        <span class="ws-tier-badge gold">250–450 ORDERS</span>
                    </div>

                    <!-- Tier 4: Diamond (450 to 800 Orders) -->
                    <div class="ws-tier-card">
                        <div class="ws-tier-card-left">
                            <div class="ws-tier-icon-wrap diamond">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none"><polygon points="6 3 18 3 22 9 12 22 2 9" stroke="#0284C7" stroke-width="1.5" fill="#38BDF8" fill-opacity="0.3"></polygon><line x1="2" y1="9" x2="22" y2="9" stroke="#0284C7" stroke-width="1.2"></line><line x1="12" y1="22" x2="6" y2="9" stroke="#0284C7" stroke-width="1.2"></line><line x1="12" y1="22" x2="18" y2="9" stroke="#0284C7" stroke-width="1.2"></line></svg>
                            </div>
                            <div class="ws-tier-info">
                                <strong>Tier 4: Diamond (450 to 800 Orders)</strong>
                            </div>
                        </div>
                        <span class="ws-tier-badge diamond">450–800 ORDERS</span>
                    </div>

                    <!-- Tier 5: Platinum Smart (800+ Orders) -->
                    <div class="ws-tier-card" style="background:linear-gradient(135deg, #FFFDF7 0%, #FDF7E7 100%); border-color:rgba(212,175,55,0.6);">
                        <div class="ws-tier-card-left">
                            <div class="ws-tier-icon-wrap platinum">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none"><polygon points="12 2 2 9 12 22 22 9" stroke="#D4AF37" stroke-width="1.5" fill="#F59E0B" fill-opacity="0.3"></polygon><line x1="2" y1="9" x2="22" y2="9" stroke="#D4AF37" stroke-width="1.2"></line><line x1="12" y1="22" x2="12" y2="22" stroke="#D4AF37" stroke-width="1.2"></line></svg>
                            </div>
                            <div class="ws-tier-info">
                                <strong style="color:#8A681F;">Tier 5: Platinum Smart (800+ Orders)</strong>
                            </div>
                        </div>
                        <span class="ws-tier-badge platinum">TOP TIER (800+)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 2.8: RETAIL WALLET TOP-UP & RECHARGE
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsWalletTopupModal" role="dialog" aria-modal="true" onclick="if(event.target===this) closeWalletTopupModal();">
        <div class="ws-modal-box" style="max-width: 480px;">
            <div class="ws-modal-header">
                <h3 class="ws-modal-title">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--ws-gold-primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><rect x="2" y="5" width="20" height="14" rx="3"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                    <span>Top-Up B2B Prepaid Wallet</span>
                </h3>
                <button class="ws-modal-close-btn" onclick="closeWalletTopupModal()" aria-label="Close Modal">&times;</button>
            </div>
            <div class="ws-modal-body">
                <div style="background:#FAF8F4; border:1.5px solid var(--ws-gold-border); border-radius:10px; padding:14px; margin-bottom:16px;">
                    <div style="font-size:0.72rem; color:var(--ws-text-muted); text-transform:uppercase; font-weight:700;">Current Available Cash Balance</div>
                    <div style="font-size:1.35rem; font-weight:900; color:var(--ws-gold-primary); font-family:var(--ws-font-serif); margin-top:2px;" id="modalCurrentWalletBal">₹45,280</div>
                </div>

                <label class="ws-label">Select Instant Top-Up Amount</label>
                <div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:8px; margin-bottom:14px;">
                    <button type="button" class="ws-btn ws-btn-secondary" onclick="setTopupAmount(25000, this)">+ ₹25,000</button>
                    <button type="button" class="ws-btn ws-btn-secondary active" onclick="setTopupAmount(50000, this)">+ ₹50,000 (Popular)</button>
                    <button type="button" class="ws-btn ws-btn-secondary" onclick="setTopupAmount(100000, this)">+ ₹1,00,000</button>
                    <button type="button" class="ws-btn ws-btn-secondary" onclick="setTopupAmount(250000, this)">+ ₹2,50,000</button>
                </div>

                <div class="ws-form-group">
                    <label class="ws-label" for="wsTopupAmountInput">Or Enter Custom Amount (₹) <span class="req">*</span></label>
                    <input type="number" id="wsTopupAmountInput" class="ws-input" value="50000" min="5000" step="1000" required>
                </div>

                <div class="ws-form-group">
                    <label class="ws-label">Payment Channel</label>
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        <label style="display:flex; align-items:center; gap:8px; font-size:0.82rem; color:var(--ws-text-main); cursor:pointer;">
                            <input type="radio" name="topupChannel" value="rtgs" checked>
                            <strong>Instant RTGS / NEFT / Net Banking (No Charges)</strong>
                        </label>
                        <label style="display:flex; align-items:center; gap:8px; font-size:0.82rem; color:var(--ws-text-main); cursor:pointer;">
                            <input type="radio" name="topupChannel" value="upi">
                            <strong>Corporate UPI QR (Instant Credit)</strong>
                        </label>
                    </div>
                </div>
            </div>
            <div class="ws-modal-footer">
                <button class="ws-btn ws-btn-primary" style="width:100%; height:42px; font-weight:800; justify-content:center;" onclick="handleProcessWalletTopup()">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Proceed to Secure Top-Up</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 3: ROLE GATE ACCESS CONTROL
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsRoleGateModal" role="dialog" aria-modal="true">
        <div class="ws-modal-box" style="max-width: 440px;">
            <div class="ws-gate-box">
                <div class="ws-gate-icon">
                    <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </div>
                <h3>Retailer Authentication Gate</h3>
                <p>This portal is exclusively authorized for verified <strong>Retailer B2B Members</strong>. Please sign in with your registered retailer account to access bulk tier pricing, order tracking, and GST invoicing.</p>
                
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <button class="ws-btn ws-btn-primary" onclick="loginAsDemoRetailer()">
                        👑 Continue as Verified Retailer
                    </button>
                    <a href="../../Shared/Auth/myaccount.php?tab=login" class="ws-btn ws-btn-secondary">
                        Sign In with Other Account
                    </a>
                    <a href="/shop.php" style="font-size:0.78rem; color:var(--ws-text-muted); text-decoration:none; margin-top:4px;">
                        ← Return to Retail Store
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 4: INTERACTIVE DATE RANGE CALENDAR PICKER
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsDateRangeModal" role="dialog" aria-modal="true" style="z-index: 2100000;" onclick="if(event.target===this) closeDateRangeModal();">
        <div class="ws-modal-box" style="max-width: 480px;">
            <div class="ws-modal-header">
                <div class="ws-modal-title">
                    <svg class="ws-ico gold" style="width:18px;height:18px;margin-right:6px;" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    Filter Analytics Date Range
                </div>
                <button class="ws-modal-close-btn" onclick="closeDateRangeModal()" aria-label="Close">✕</button>
            </div>
            <div class="ws-modal-body" style="padding: 16px 20px;">
                <div style="font-size:0.78rem; font-weight:700; color:var(--ws-text-muted); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:8px;">
                    Quick Presets:
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;" id="datePresetButtons">
                    <button class="ws-btn ws-btn-secondary" style="justify-content: space-between; padding: 10px 14px; font-size: 0.84rem;" onclick="applyDatePreset('today', 'Today (16 Aug)')">
                        <span><svg class="ws-ico gold ws-ico-sm" style="margin-right:5px;" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> <strong>Today</strong></span>
                        <span style="font-size:0.74rem; color:var(--ws-text-muted);">16 Aug 2026</span>
                    </button>
                    <button class="ws-btn ws-btn-primary" style="justify-content: space-between; padding: 10px 14px; font-size: 0.84rem;" onclick="applyDatePreset('week', 'Aug 10 - Aug 16')">
                        <span><svg class="ws-ico gold ws-ico-sm" style="margin-right:5px;" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> <strong>This Week</strong></span>
                        <span style="font-size:0.74rem; color:var(--ws-gold-light);">10 Aug – 16 Aug 2026 (Live)</span>
                    </button>
                    <button class="ws-btn ws-btn-secondary" style="justify-content: space-between; padding: 10px 14px; font-size: 0.84rem;" onclick="applyDatePreset('month', 'Aug 01 - Aug 31')">
                        <span><svg class="ws-ico gold ws-ico-sm" style="margin-right:5px;" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg> <strong>This Month</strong></span>
                        <span style="font-size:0.74rem; color:var(--ws-text-muted);">August 2026 (Full Month)</span>
                    </button>
                    <button class="ws-btn ws-btn-secondary" style="justify-content: space-between; padding: 10px 14px; font-size: 0.84rem;" onclick="applyDatePreset('last_month', 'Jul 01 - Jul 31')">
                        <span><svg class="ws-ico gold ws-ico-sm" style="margin-right:5px;" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg> <strong>Last Month</strong></span>
                        <span style="font-size:0.74rem; color:var(--ws-text-muted);">July 2026 (Reconciled)</span>
                    </button>
                    <button class="ws-btn ws-btn-secondary" style="justify-content: space-between; padding: 10px 14px; font-size: 0.84rem;" onclick="applyDatePreset('year', 'FY 2026-27')">
                        <span><svg class="ws-ico gold ws-ico-sm" style="margin-right:5px;" viewBox="0 0 24 24"><polygon points="2 4 5 18 19 18 22 4 16 11 12 2 8 11 2 4"></polygon></svg> <strong>Financial Year</strong></span>
                        <span style="font-size:0.74rem; color:var(--ws-text-muted);">FY 2026-27 (Q1 & Q2)</span>
                    </button>
                </div>

                <!-- Custom Calendar Date Pickers -->
                <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid var(--ws-border);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: var(--ws-text-main); margin-bottom: 8px;">
                        Custom Calendar Range:
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="font-size: 0.70rem; font-weight:600; color: var(--ws-text-muted); display: block; margin-bottom: 3px;">Start Date</label>
                            <input type="date" id="customStartDate" value="2026-08-10" class="ws-input" style="height: 38px; font-size: 0.80rem;">
                        </div>
                        <div>
                            <label style="font-size: 0.70rem; font-weight:600; color: var(--ws-text-muted); display: block; margin-bottom: 3px;">End Date</label>
                            <input type="date" id="customEndDate" value="2026-08-16" class="ws-input" style="height: 38px; font-size: 0.80rem;">
                        </div>
                    </div>
                    <button class="ws-btn ws-btn-primary" style="width: 100%; margin-top: 10px; height: 38px; font-size: 0.82rem;" onclick="applyCustomDateRange()">
                        <svg class="ws-ico" style="stroke:#FFFFFF;margin-right:4px;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg> Apply Calendar Filter
                    </button>
                </div>
            </div>
            <div class="ws-modal-footer">
                <button class="ws-btn ws-btn-secondary ws-btn-full" onclick="closeDateRangeModal()">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- ── Toast Notifications ── -->
    <div class="ws-toast-container" id="wsToastContainer"></div>


    <!-- ── Catalog Products Data (PHP-injected, safe fallback for static servers) ── -->
    <script type="application/json" id="ws-catalog-data"><?php
        if (isset($catalogProducts) && is_array($catalogProducts)) {
            $mapped = array_map(function($p) {
                return [
                    'id'       => $p['id'],
                    'name'     => $p['name'],
                    'category' => $p['category'],
                    'price'    => $p['wholesale_price'],
                    'old_price'=> $p['retail_price'],
                    'discount' => round((($p['retail_price'] - $p['wholesale_price']) / max(1, $p['retail_price'])) * 100),
                    'image'    => $p['image'],
                    'badge'    => isset($p['badge']) ? $p['badge'] : null,
                    'rating'   => 4.9,
                    'color'    => isset($p['color']) ? $p['color'] : 'Standard',
                    'colors'   => [isset($p['color']) ? $p['color'] : 'Standard'],
                    'size'     => ['MOQ: '.$p['moq'].' Pcs Lot','2x Lot ('.($p['moq']*2).' Pcs)','5x Lot ('.($p['moq']*5).' Pcs)'],
                    'fabric'   => isset($p['fabric']) ? $p['fabric'] : 'Pure Silk',
                    'in_stock' => true,
                    'sku'      => isset($p['sku']) ? $p['sku'] : 'SKU-'.$p['id'],
                    'hsn'      => isset($p['hsn']) ? $p['hsn'] : '5007'
                ];
            }, $catalogProducts);
            echo json_encode($mapped);
        } else {
            echo '[]';
        }
    ?></script>

    <!-- ═══════════════════════════════════════════
         JAVASCRIPT CONTROLLER & STATE ENGINE
    ═══════════════════════════════════════════ -->
    <script src="/Frontend/Retailer/Asset/js/retailer.js?v=<?= time() ?>"></script>

    <!-- ════════════ CART DRAWER PARTIAL ════════════ -->
    <?php include_once __DIR__ . '/../../Shared/Includes/cart.php'; ?>

    <!-- ════════════ CHECKOUT MODAL PARTIAL ════════════ -->
    <?php include_once __DIR__ . '/../../Shared/Includes/checkout.php'; ?>

    <!-- ════════════ QUICK VIEW PARTIAL ════════════ -->
    <?php include_once __DIR__ . '/../../Shared/Includes/quickview.php'; ?>

    <!-- ════════════ SMART WHATSAPP SHARE MODAL ════════════ -->
    <?php include_once __DIR__ . '/../../Shared/Includes/smartshare.php'; ?>

    <!-- ════════════ WISHLIST PARTIAL ════════════ -->
    <?php include_once __DIR__ . '/../../Shared/Includes/wishlist.php'; ?>

    <!-- ════════════ RETAILER DRAWER GLOBAL BRIDGE ════════════ -->
    <script>
    (function() {
        var attempts = 0;
        function wireDrawers() {
            attempts++;
            var allOk = true;

            // openWishlistDrawer bridge
            if (typeof window.openWishlistDrawer !== 'function') {
                var wdBackdrop = document.getElementById('wishlistDrawerBackdrop');
                if (wdBackdrop) {
                    window.openWishlistDrawer = function() { wdBackdrop.classList.add('active'); };
                } else { allOk = false; }
            }

            // openCartDrawer bridge
            if (typeof window.openCartDrawer !== 'function') {
                var cdBackdrop = document.getElementById('cartDrawerBackdrop');
                if (cdBackdrop) {
                    window.openCartDrawer = function() { cdBackdrop.classList.add('active'); };
                } else { allOk = false; }
            }

            // openQV bridge — if quickview.php didn't define it yet, retry
            if (typeof window.openQV !== 'function') {
                var qvEl = document.getElementById('quickViewOverlay');
                if (qvEl) { allOk = false; }
            }

            // Safety re-export for any missed scoped functions
            ['directAddWholesaleToCart','toggleWholesaleWishlist','openQuickOrderModal',
             'shareWholesaleProduct','shareProductCard'].forEach(function(name) {
                try {
                    if (typeof window[name] !== 'function') {
                        var fn = eval('typeof ' + name + ' !== "undefined" ? ' + name + ' : null');
                        if (typeof fn === 'function') window[name] = fn;
                    }
                } catch(e) {}
            });

            // Badge sync on load
            if (typeof window.updateWholesaleWishlistBadge === 'function') window.updateWholesaleWishlistBadge();
            if (typeof window.updateWholesaleCartBadge === 'function') window.updateWholesaleCartBadge();
            if (typeof window.syncWishlistButtonStates === 'function') window.syncWishlistButtonStates();

            if (!allOk && attempts < 20) { setTimeout(wireDrawers, 150); }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', wireDrawers);
        } else {
            wireDrawers();
        }
    })();
    </script>
</body>
</html>
