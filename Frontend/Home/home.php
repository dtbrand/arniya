<?php
/**
 * home.php — DEDICATED NEW HOME PAGE
 * Premium Meesho-Style Ethnic E-Commerce, Reseller & Wholesale Shopping Hub
 * Preserving DT Brand's Heritage Gold UI, Header, Footer & Architecture as Source of Truth
 */

require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

// ── Rich Multi-Category Catalog Database (Dynamic Database-First Pipeline) ──
$products = ProductCatalog::getAll();
if (empty($products)) {
$products = [
    // ── Sarees ──
    [
        'id'              => 1,
        'sku'             => 'KLN-SR-111',
        'name'            => 'Nilambari Silk Saree with Rich Zari Pallu',
        'category'        => 'Sarees',
        'price'           => 4899,
        'old_price'       => 6500,
        'discount'        => 25,
        'wholesale_price' => 1399,
        'reseller_profit' => 2100,
        'moq'             => 8,
        'image'           => '/Frontend/Shop/Asset/images/product1.png',
        'badge'           => 'Bestseller',
        'rating'          => 4.9,
        'reviews_count'   => 142,
        'color'           => 'Navy Blue',
        'colors'          => ['Navy Blue', 'Royal Blue', 'Midnight Black'],
        'size'            => ['Free Size', 'M', 'L'],
        'fabric'          => 'Pure Silk',
        'in_stock'        => 95,
        'tier_prices'     => '8-15 pcs: ₹1,399 | 16-31 pcs: ₹1,299 | 32+ pcs: ₹1,219'
    ],
    [
        'id'              => 2,
        'sku'             => 'KLN-SR-110',
        'name'            => 'Royal Banarasi Meenakari Silk Saree',
        'category'        => 'Sarees',
        'price'           => 8499,
        'old_price'       => 11000,
        'discount'        => 23,
        'wholesale_price' => 2499,
        'reseller_profit' => 3500,
        'moq'             => 6,
        'image'           => '/Frontend/Shop/Asset/images/product2.png',
        'badge'           => 'Heritage',
        'rating'          => 4.9,
        'reviews_count'   => 98,
        'color'           => 'Maroon Red',
        'colors'          => ['Maroon Red', 'Deep Wine', 'Ruby Red'],
        'size'            => ['Free Size', 'S', 'M'],
        'fabric'          => 'Pure Katan Silk',
        'in_stock'        => 110,
        'tier_prices'     => '6-11 pcs: ₹2,499 | 12-23 pcs: ₹2,349 | 24+ pcs: ₹2,199'
    ],
    [
        'id'              => 3,
        'sku'             => 'KLN-SR-112',
        'name'            => 'Kanjivaram Temple Silk Bridal Saree',
        'category'        => 'Sarees',
        'price'           => 12999,
        'old_price'       => 16500,
        'discount'        => 21,
        'wholesale_price' => 3899,
        'reseller_profit' => 5100,
        'moq'             => 6,
        'image'           => '/Frontend/Shop/Asset/images/product3.png',
        'badge'           => 'Bridal Pick',
        'rating'          => 5.0,
        'reviews_count'   => 64,
        'color'           => 'Copper Gold',
        'colors'          => ['Copper Gold', 'Golden Ochre', 'Emerald Green'],
        'size'            => ['Free Size', 'L', 'XL'],
        'fabric'          => 'Pure Silk Zari',
        'in_stock'        => 85,
        'tier_prices'     => '6-11 pcs: ₹3,899 | 12-23 pcs: ₹3,699 | 24+ pcs: ₹3,499'
    ],
    [
        'id'              => 4,
        'sku'             => 'KLN-SR-104',
        'name'            => 'Pastel Georgette Floral Bloom Saree',
        'category'        => 'Sarees',
        'price'           => 3299,
        'old_price'       => 4500,
        'discount'        => 27,
        'wholesale_price' => 999,
        'reseller_profit' => 1300,
        'moq'             => 10,
        'image'           => '/Frontend/Shop/Asset/images/product4.png',
        'badge'           => 'Trending',
        'rating'          => 4.7,
        'reviews_count'   => 82,
        'color'           => 'Blush Pink',
        'colors'          => ['Blush Pink', 'Peach', 'Rose Petal'],
        'size'            => ['Free Size', 'S', 'M', 'L'],
        'fabric'          => 'Pure Georgette',
        'in_stock'        => 140,
        'tier_prices'     => '10-19 pcs: ₹999 | 20-39 pcs: ₹929 | 40+ pcs: ₹869'
    ],

    // ── Kurtis & Suit Sets ──
    [
        'id'              => 5,
        'sku'             => 'KLN-KT-109',
        'name'            => 'Party Festive Sharara Anarkali Kurti Set',
        'category'        => 'Kurtis',
        'price'           => 2799,
        'old_price'       => 3900,
        'discount'        => 28,
        'wholesale_price' => 989,
        'reseller_profit' => 1210,
        'moq'             => 8,
        'image'           => '/Frontend/Shop/Asset/images/product5.png',
        'badge'           => 'New Arrival',
        'rating'          => 4.8,
        'reviews_count'   => 115,
        'color'           => 'Teal Green',
        'colors'          => ['Teal Green', 'Mint', 'Bottle Green'],
        'size'            => ['XS', 'S', 'M', 'L', 'XL'],
        'fabric'          => 'Chanderi Gotapatti',
        'in_stock'        => 125,
        'tier_prices'     => '8-15 pcs: ₹989 | 16-31 pcs: ₹929 | 32+ pcs: ₹869'
    ],
    [
        'id'              => 6,
        'sku'             => 'KLN-LH-106',
        'name'            => 'Bridal Zardosi Heavy Velvet Lehenga Set',
        'category'        => 'Lehengas',
        'price'           => 24999,
        'old_price'       => 32000,
        'discount'        => 22,
        'wholesale_price' => 7999,
        'reseller_profit' => 9500,
        'moq'             => 4,
        'image'           => '/Frontend/Shop/Asset/images/product6.png',
        'badge'           => 'Royal Bridal',
        'rating'          => 5.0,
        'reviews_count'   => 47,
        'color'           => 'Crimson Red',
        'colors'          => ['Crimson Red', 'Ruby', 'Maroon Velvet'],
        'size'            => ['S', 'M', 'L', 'XL', 'Custom'],
        'fabric'          => 'Micro Velvet & Organza',
        'in_stock'        => 45,
        'tier_prices'     => '4-7 pcs: ₹7,999 | 8-15 pcs: ₹7,499 | 16+ pcs: ₹6,999'
    ],
    [
        'id'              => 7,
        'sku'             => 'KLN-KT-101',
        'name'            => 'Jaipuri Block Printed Pure Cotton Kurti',
        'category'        => 'Kurtis',
        'price'           => 1899,
        'old_price'       => 2600,
        'discount'        => 27,
        'wholesale_price' => 549,
        'reseller_profit' => 850,
        'moq'             => 12,
        'image'           => '/Frontend/Shop/Asset/images/product7.png',
        'badge'           => 'Super Value',
        'rating'          => 4.6,
        'reviews_count'   => 168,
        'color'           => 'Mustard Ochre',
        'colors'          => ['Mustard Ochre', 'Rust Gold', 'Indigo'],
        'size'            => ['Free Size', 'M', 'L', 'XL'],
        'fabric'          => '100% Pure Cotton',
        'in_stock'        => 210,
        'tier_prices'     => '12-23 pcs: ₹549 | 24-47 pcs: ₹499 | 48+ pcs: ₹449'
    ],
    [
        'id'              => 8,
        'sku'             => 'KLN-GW-108',
        'name'            => 'Ivory Designer Handwork Ethnic Gown',
        'category'        => 'Gowns',
        'price'           => 7499,
        'old_price'       => 9500,
        'discount'        => 21,
        'wholesale_price' => 2199,
        'reseller_profit' => 2800,
        'moq'             => 6,
        'image'           => '/Frontend/Shop/Asset/images/product8.png',
        'badge'           => 'Trending',
        'rating'          => 4.8,
        'reviews_count'   => 73,
        'color'           => 'Pearl White',
        'colors'          => ['Pearl White', 'Ivory', 'Champagne'],
        'size'            => ['S', 'M', 'L', 'XXL'],
        'fabric'          => 'Chiffon & Mirror Work',
        'in_stock'        => 80,
        'tier_prices'     => '6-11 pcs: ₹2,199 | 12-23 pcs: ₹2,049 | 24+ pcs: ₹1,899'
    ],
    [
        'id'              => 9,
        'sku'             => 'KLN-SU-115',
        'name'            => 'Kashmiri Embroidered Georgette Suit Set',
        'category'        => 'Suits',
        'price'           => 3499,
        'old_price'       => 4800,
        'discount'        => 27,
        'wholesale_price' => 1199,
        'reseller_profit' => 1500,
        'moq'             => 8,
        'image'           => '/Frontend/Shop/Asset/images/product7.png',
        'badge'           => 'Special Pick',
        'rating'          => 4.9,
        'reviews_count'   => 89,
        'color'           => 'Dusty Rose',
        'colors'          => ['Dusty Rose', 'Plum', 'Wine'],
        'size'            => ['S', 'M', 'L', 'XL'],
        'fabric'          => 'Pure Georgette',
        'in_stock'        => 65,
        'tier_prices'     => '8-15 pcs: ₹1,199 | 16-31 pcs: ₹1,099 | 32+ pcs: ₹999'
    ],
    [
        'id'              => 10,
        'sku'             => 'KLN-SR-105',
        'name'            => 'Kanjeevaram Temple Border Pattu Saree',
        'category'        => 'Sarees',
        'price'           => 5299,
        'old_price'       => 7200,
        'discount'        => 26,
        'wholesale_price' => 1699,
        'reseller_profit' => 2400,
        'moq'             => 6,
        'image'           => '/Frontend/Shop/Asset/images/product3.png',
        'badge'           => 'Hot Deal',
        'rating'          => 5.0,
        'reviews_count'   => 124,
        'color'           => 'Golden Ochre',
        'colors'          => ['Golden Ochre', 'Rani Pink', 'Royal Purple'],
        'size'            => ['Free Size', 'M', 'L'],
        'fabric'          => 'Pure Silk Pattu',
        'in_stock'        => 75,
        'tier_prices'     => '6-11 pcs: ₹1,699 | 12-23 pcs: ₹1,549 | 24+ pcs: ₹1,399'
    ],
];
}

$categoriesList = [
    [
        'name'        => 'Sarees',
        'count'       => '450+ Designs',
        'icon'        => '🥻',
        'img'         => '/Frontend/Shop/Asset/images/product1.png',
        'price_from'  => 'From ₹1,299',
        'badge'       => '🔥 Bestseller',
        'tagline'     => 'Banarasi & Kanjivaram'
    ],
    [
        'name'        => 'Kurtis',
        'count'       => '320+ Styles',
        'icon'        => '👗',
        'img'         => '/Frontend/Shop/Asset/images/product5.png',
        'price_from'  => 'From ₹549',
        'badge'       => '⚡ Trending',
        'tagline'     => 'Anarkali & Straight Sets'
    ],
    [
        'name'        => 'Gowns',
        'count'       => '180+ Couture',
        'icon'        => '✨',
        'img'         => '/Frontend/Shop/Asset/images/product8.png',
        'price_from'  => 'From ₹2,199',
        'badge'       => '👑 Designer',
        'tagline'     => 'Party Mirror Work'
    ],
    [
        'name'        => 'Lehengas',
        'count'       => '140+ Bridal',
        'icon'        => '👑',
        'img'         => '/Frontend/Shop/Asset/images/product6.png',
        'price_from'  => 'From ₹6,999',
        'badge'       => '💎 Bridal Pick',
        'tagline'     => 'Heavy Velvet & Flare'
    ],
    [
        'name'        => 'Suits',
        'count'       => '210+ Sets',
        'icon'        => '🌟',
        'img'         => '/Frontend/Shop/Asset/images/product7.png',
        'price_from'  => 'From ₹899',
        'badge'       => '🏷️ Flat 25% Off',
        'tagline'     => 'Sharara & Pant Sets'
    ],
    [
        'name'        => 'Dress Material',
        'count'       => '290+ Lots',
        'icon'        => '🧵',
        'img'         => '/Frontend/Shop/Asset/images/product4.png',
        'price_from'  => 'From ₹649',
        'badge'       => '🏭 Factory Price',
        'tagline'     => 'Unstitched Pure Cotton'
    ],
    [
        'name'        => 'Dupatta',
        'count'       => '160+ Silk Lots',
        'icon'        => '🧣',
        'img'         => '/Frontend/Shop/Asset/images/product2.png',
        'price_from'  => 'From ₹299',
        'badge'       => '✨ Silk Edit',
        'tagline'     => 'Banarasi Zari Border'
    ],
    [
        'name'        => 'Jewellery',
        'count'       => '120+ Kundan',
        'icon'        => '💍',
        'img'         => '/Frontend/Shop/Asset/images/product3.png',
        'price_from'  => 'From ₹499',
        'badge'       => '👑 Royal Kundan',
        'tagline'     => 'Choker & Bridal Sets'
    ],
];

$total_products = count($products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Shop direct from Surat manufacturers — sarees, kurtis, lehengas, suits, reseller margins & wholesale lots at DT Brand's." />
    <title>DT Brand's — Premium Ethnic Wear, Reseller & Wholesale Hub</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/Frontend/Home/Asset/css/home.css?v=<?php echo time(); ?>">

    <!-- ════════════ GLOBAL DATA BOOTSTRAP ════════════ -->
    <script>
        window.shopProductsData = <?php echo json_encode(array_values($products)); ?>;
        window.allProducts = window.shopProductsData;
        window.catalogProducts = window.allProducts;
        window.products = window.allProducts;
        window.openQuickView = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
        window.openQuickViewModal = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
    </script>
</head>
<body>

<!-- ════════════ SECTION 1: EXISTING HEADER PARTIAL ════════════ -->
<?php $hideHeaderSubnav = true; include_once __DIR__ . '/../Shop/Includes/shophader.php'; ?>

<div class="page-wrapper">

    <!-- ════════════ SECTION 2: QUICK ACCESS BAR ════════════ -->
    <section class="home-quick-access-section" aria-label="Quick Access">
        <div class="home-section-container">
            <div class="quick-access-grid">
                <a href="#section-trending" class="quick-card card-shop" onclick="document.getElementById('section-trending').scrollIntoView({behavior:'smooth'}); return false;">
                    <div class="quick-card-icon-wrap icon-shop">
                        <svg viewBox="0 0 24 24" class="quick-card-svg"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    </div>
                    <div class="quick-card-info">
                        <span class="quick-card-badge badge-shop">Storefront</span>
                        <h3 class="quick-card-title">Shop Collection</h3>
                        <p class="quick-card-sub">Latest 2026 Ethnic Wear</p>
                    </div>
                    <span class="quick-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                </a>

                <a href="/reseller" class="quick-card card-reseller">
                    <div class="quick-card-icon-wrap icon-reseller">
                        <svg viewBox="0 0 24 24" class="quick-card-svg"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    </div>
                    <div class="quick-card-info">
                        <span class="quick-card-badge badge-reseller">Zero Investment</span>
                        <h3 class="quick-card-title">Start Reselling</h3>
                        <p class="quick-card-sub">Earn Margins on WhatsApp</p>
                    </div>
                    <span class="quick-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                </a>

                <a href="/wholesale" class="quick-card card-wholesale">
                    <div class="quick-card-icon-wrap icon-wholesale">
                        <svg viewBox="0 0 24 24" class="quick-card-svg"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div class="quick-card-info">
                        <span class="quick-card-badge badge-wholesale">Factory Rates</span>
                        <h3 class="quick-card-title">Buy Wholesale</h3>
                        <p class="quick-card-sub">Bulk Lots & Quantity Slabs</p>
                    </div>
                    <span class="quick-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                </a>

                <a href="#section-offers" class="quick-card card-offers" onclick="document.getElementById('section-offers').scrollIntoView({behavior:'smooth'}); return false;">
                    <div class="quick-card-icon-wrap icon-offers">
                        <svg viewBox="0 0 24 24" class="quick-card-svg"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    </div>
                    <div class="quick-card-info">
                        <span class="quick-card-badge badge-offers">Save Up to 35%</span>
                        <h3 class="quick-card-title">Special Offers</h3>
                        <p class="quick-card-sub">Festive & Clearance Codes</p>
                    </div>
                    <span class="quick-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 5: SHOP BY CATEGORY (SMART LUXURY SCROLL RAIL) ════════════ -->
    <section class="home-section home-category-section" id="section-categories">
        <div class="home-section-container">
            <div class="home-section-header home-cat-section-header">
                <div>
                    <span class="home-section-tag">✨ CURATED ETHNIC COLLECTIONS</span>
                    <h2 class="home-section-title">Shop By Category</h2>
                </div>
                <div class="home-cat-header-actions">
                    <!-- Carousel Navigation Controls -->
                    <div class="home-cat-arrows-group">
                        <button type="button" class="home-cat-scroll-arrow prev" id="catScrollPrevBtn" onclick="if(typeof scrollCatRail==='function') scrollCatRail(-1);" aria-label="Previous categories">
                            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="home-cat-scroll-arrow next" id="catScrollNextBtn" onclick="if(typeof scrollCatRail==='function') scrollCatRail(1);" aria-label="Next categories">
                            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Smart Horizontal Scroll Rail -->
            <div class="home-cat-carousel-wrap">
                <div class="home-cat-scroll-track" id="homeCatScrollTrack">
                    <?php foreach ($categoriesList as $cat): ?>
                    <article class="home-cat-card" onclick="if(typeof window.filterHomeCategory==='function') window.filterHomeCategory('<?= $cat['name'] ?>');" role="button" tabindex="0">
                        <div class="home-cat-card-img-wrap">
                            <img src="<?= $cat['img'] ?>" alt="<?= $cat['name'] ?>" loading="lazy" class="home-cat-card-img" />
                        </div>
                        <div class="home-cat-card-body">
                            <h3 class="home-cat-card-name"><?= $cat['name'] ?></h3>
                            <p class="home-cat-card-tagline"><?= $cat['tagline'] ?? 'Exclusive Collection' ?></p>
                            <div class="home-cat-card-footer">
                                <span class="home-cat-card-count"><?= $cat['count'] ?></span>
                                <span class="home-cat-explore-btn">Explore &rsaquo;</span>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <!-- Custom Scroll Progress Bar -->
                <div class="home-cat-scrollbar-track" id="homeCatScrollbarTrack">
                    <div class="home-cat-scrollbar-thumb" id="homeCatScrollbarThumb"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 6: TRENDING NOW (MAIN STOREFRONT LISTING) ════════════ -->
    <section class="home-section home-trending-section" id="section-trending">
        <div class="home-section-container">
            <div class="home-section-header home-trending-section-header">
                <div>
                    <span class="home-section-tag trending-tag">🔥 HOTTEST PICKS THIS WEEK</span>
                    <h2 class="home-section-title">Trending Now</h2>
                </div>
                <div class="home-trending-header-actions">
                    <!-- Carousel Navigation Controls -->
                    <div class="home-trending-arrows-group">
                        <button type="button" class="trending-scroll-arrow prev" id="trendingScrollPrevBtn" onclick="if(typeof scrollTrendingRail==='function') scrollTrendingRail(-1);" aria-label="Previous products">
                            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="trending-scroll-arrow next" id="trendingScrollNextBtn" onclick="if(typeof scrollTrendingRail==='function') scrollTrendingRail(1);" aria-label="Next products">
                            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products 1-Line Continuous Rail -->
            <div class="trending-rail-container">
                <div class="products-grid products-scroll-rail" id="productsGrid" role="list">
            <?php foreach ($products as $p): ?>
            <?php
                $badge_class = !empty($p['badge']) ? 'badge-'.strtolower(preg_replace('/[^a-z0-9]/', '', $p['badge'])) : '';
                $pCols = !empty($p['colors']) ? $p['colors'] : [$p['color']];
                $pSizes = !empty($p['size']) ? $p['size'] : ['Free Size'];
            ?>
            <article class="product-card" role="listitem" data-product-id="<?= $p['id'] ?>" data-category="<?= htmlspecialchars($p['category']) ?>" data-price="<?= $p['price'] ?>" data-color="<?= htmlspecialchars($p['color']) ?>" data-discount="<?= $p['discount'] ?>">
                <div class="card-image-wrap">
                    <a href="../Single-Product/singleproduct.php?id=<?= $p['id'] ?>" style="display:block;width:100%;height:100%;">
                        <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="card-img" loading="lazy" />
                    </a>

                    <?php if (!empty($p['badge'])): ?>
                    <span class="card-badge <?= $badge_class ?>"><?= htmlspecialchars($p['badge']) ?></span>
                    <?php endif; ?>

                    <button class="card-wishlist-btn" data-id="<?= $p['id'] ?>" aria-label="Wishlist <?= htmlspecialchars($p['name']) ?>" onclick="if(typeof window.toggleWishlistProduct==='function'){ window.toggleWishlistProduct(<?= $p['id'] ?>); }">
                        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </button>

                    <button class="card-mobile-qv-btn quick-view-btn" data-id="<?= $p['id'] ?>" aria-label="Quick View" onclick="openQuickViewModal(<?= $p['id'] ?>)">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>

                    <div class="card-quick-view" aria-hidden="true">
                        <button class="quick-view-btn" onclick="openQuickViewModal(<?= $p['id'] ?>)">Quick View</button>
                    </div>

                    <!-- 1-Tap Share Button (Opens SmartShare) -->
                    <button type="button" class="card-share-btn" data-id="<?= $p['id'] ?>" aria-label="Share <?= htmlspecialchars($p['name']) ?>" title="Share on WhatsApp" onclick="event.stopPropagation();event.preventDefault();if(typeof window.shareProductCard==='function'){window.shareProductCard(<?= $p['id'] ?>);}">
                        <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                    </button>

                    <span class="card-cat-photo-tag"><?= htmlspecialchars($p['category']) ?></span>
                </div>

                <div class="card-body">
                    <div class="card-sku-rating-row">
                        <span class="card-sku-text"><?= $p['sku'] ?></span>
                        <span class="card-rating-badge">★ <?= number_format($p['rating'], 1) ?> (<?= $p['reviews_count'] ?>)</span>
                    </div>

                    <h3 class="card-name">
                        <a href="../Single-Product/singleproduct.php?id=<?= $p['id'] ?>">
                            <?= htmlspecialchars($p['name']) ?>
                        </a>
                    </h3>

                    <div class="card-info-text-row">
                        <span class="card-colors-text"><?= count($pCols) ?> Colours</span>
                        <span class="card-sizes-text"><?= htmlspecialchars(implode(', ', $pSizes)) ?></span>
                    </div>

                    <div class="card-price-row">
                        <span class="card-price">₹<?= number_format($p['price']) ?></span>
                        <?php if (!empty($p['old_price'])): ?>
                        <span class="card-old-price">₹<?= number_format($p['old_price']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($p['discount'])): ?>
                        <span class="card-price-discount"><?= $p['discount'] ?>% OFF</span>
                        <?php endif; ?>
                    </div>

                    <!-- 1-Tap Add To Cart Action Button -->
                    <div class="card-btn-row">
                        <button type="button" class="card-add-cart-btn" onclick="if(typeof window.addToCart==='function'){ window.addToCart(<?= $p['id'] ?>, 1); } else { showToast('Added to Cart!'); }">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            <span>Add to Cart</span>
                        </button>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 10: RESELLER BUSINESS BANNER (LUXURY GLASSMORPHIC) ════════════ -->
    <section class="home-banner-strip-section" aria-label="Reseller Opportunity Banner">
        <div class="home-section-container">
            <div class="reseller-promo-banner">
                <!-- Ambient Decorative Glow Orbs -->
                <div class="rpb-glow-orb rpb-glow-1" aria-hidden="true"></div>
                <div class="rpb-glow-orb rpb-glow-2" aria-hidden="true"></div>

                <div class="rpb-main-content">
                    <div class="rpb-left">
                        <!-- Top Badges Row -->
                        <div class="rpb-tag-row">
                            <span class="rpb-tag">
                                <svg viewBox="0 0 24 24" class="rpb-tag-icon"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <span>START YOUR OWN BOUTIQUE</span>
                            </span>
                            <span class="rpb-pill-badge">✨ ₹0 INVESTMENT</span>
                            <span class="rpb-pill-badge hide-mobile">💎 100% SURAT FACTORY DIRECT</span>
                        </div>

                        <!-- Title & Subtitle -->
                        <h2 class="rpb-title">Start Your Online Ethnic Wear Business Today</h2>
                        <p class="rpb-subtitle">Resell Surat’s finest silk sarees, designer kurtis & bridal lehengas on WhatsApp. Set your own profit margin & get doorstep delivery across India.</p>

                        <!-- 4 Interactive Steps with Real Vector SVG Icons -->
                        <div class="rpb-steps-grid">
                            <!-- Step 1 -->
                            <div class="rpb-step-card">
                                <div class="rpb-step-icon-box step-icon-1">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                                    </svg>
                                    <span class="rpb-step-num">01</span>
                                </div>
                                <div class="rpb-step-info">
                                    <span class="rpb-step-heading">Choose Products</span>
                                    <span class="rpb-step-desc">Pick from 500+ designs</span>
                                </div>
                            </div>

                            <div class="rpb-connector" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>

                            <!-- Step 2 -->
                            <div class="rpb-step-card">
                                <div class="rpb-step-icon-box step-icon-2">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path>
                                    </svg>
                                    <span class="rpb-step-num">02</span>
                                </div>
                                <div class="rpb-step-info">
                                    <span class="rpb-step-heading">Add Your Margin</span>
                                    <span class="rpb-step-desc">Earn ₹500–₹2,500/pc</span>
                                </div>
                            </div>

                            <div class="rpb-connector" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>

                            <!-- Step 3 -->
                            <div class="rpb-step-card">
                                <div class="rpb-step-icon-box step-icon-3">
                                    <svg viewBox="0 0 24 24">
                                        <circle cx="18" cy="5" r="3"></circle>
                                        <circle cx="6" cy="12" r="3"></circle>
                                        <circle cx="18" cy="19" r="3"></circle>
                                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                                    </svg>
                                    <span class="rpb-step-num">03</span>
                                </div>
                                <div class="rpb-step-info">
                                    <span class="rpb-step-heading">Share On WhatsApp</span>
                                    <span class="rpb-step-desc">1-Tap Smart Share</span>
                                </div>
                            </div>

                            <div class="rpb-connector" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>

                            <!-- Step 4 -->
                            <div class="rpb-step-card">
                                <div class="rpb-step-icon-box step-icon-4">
                                    <svg viewBox="0 0 24 24">
                                        <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                    <span class="rpb-step-num">04</span>
                                </div>
                                <div class="rpb-step-info">
                                    <span class="rpb-step-heading">Direct Bank Profit</span>
                                    <span class="rpb-step-desc">Instant weekly payout</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right CTAs -->
                    <div class="rpb-right">
                        <div class="rpb-cta-box">
                            <a href="/reseller" class="rpb-btn-primary">
                                <span>Start Reselling Free</span>
                                <svg viewBox="0 0 24 24" class="rpb-btn-arrow"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                            <a href="#section-how-reselling-works" class="rpb-btn-secondary" onclick="document.getElementById('section-how-reselling-works').scrollIntoView({behavior:'smooth'}); return false;">
                                <svg viewBox="0 0 24 24" class="rpb-info-icon"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8" fill="currentColor"></polygon></svg>
                                <span>How It Works</span>
                            </a>
                            <div class="rpb-trust-pill">
                                <span class="rpb-trust-dot"></span>
                                <span>10,000+ Active Indian Resellers</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 11: DEAL OF THE DAY (WITH COUNTDOWN) ════════════ -->
    <section class="home-section home-deals-section" id="section-deals">
        <div class="home-section-container">
            <div class="home-deal-header">
                <div class="deal-header-left">
                    <span class="home-section-tag deal-tag">⚡ LIMITED TIME FLASH SALE</span>
                    <h2 class="home-section-title">Deal of the Day — Up to 30% OFF</h2>
                </div>
                <div class="deal-header-actions">
                    <div class="deal-countdown-box" id="dealCountdownBox">
                        <span class="countdown-label">Ends in:</span>
                        <div class="countdown-digits">
                            <span class="cd-box"><strong id="cdHours">08</strong><small>hrs</small></span> :
                            <span class="cd-box"><strong id="cdMins">45</strong><small>mins</small></span> :
                            <span class="cd-box"><strong id="cdSecs">20</strong><small>secs</small></span>
                        </div>
                    </div>
                    <div class="deal-slider-arrows">
                        <button type="button" class="deal-nav-arrow deal-nav-prev" id="dealScrollPrevBtn" onclick="scrollDealsRail(-1)" aria-label="Previous deals">‹</button>
                        <button type="button" class="deal-nav-arrow deal-nav-next" id="dealScrollNextBtn" onclick="scrollDealsRail(1)" aria-label="Next deals">›</button>
                    </div>
                </div>
            </div>

            <!-- 1 Line Continuous Scroll on Desktop / 2 Lines Synchronized Scroll on Mobile -->
            <div class="home-deals-grid" id="homeDealsGrid">
                <?php foreach (array_slice($products, 0, 10) as $p): ?>
                <div class="home-deal-card">
                    <div class="deal-card-img-wrap">
                        <span class="deal-card-badge-top">SAVE <?= $p['discount'] ?>%</span>
                        <a href="../Single-Product/singleproduct.php?id=<?= $p['id'] ?>">
                            <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="deal-card-img" loading="lazy" />
                        </a>
                        <button type="button" class="deal-card-wish-btn" onclick="toggleWishlistProduct(<?= $p['id'] ?>)" aria-label="Add to wishlist">
                            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </button>
                    </div>
                    <div class="deal-card-body">
                        <div class="deal-sku-row">
                            <span class="deal-sku-text"><?= $p['sku'] ?></span>
                            <span class="deal-rating-badge">★ <?= $p['rating'] ?></span>
                        </div>
                        <h4 class="deal-card-title">
                            <a href="../Single-Product/singleproduct.php?id=<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></a>
                        </h4>
                        <div class="deal-card-prices">
                            <span class="deal-sale-price">₹<?= number_format($p['price']) ?></span>
                            <span class="deal-mrp">₹<?= number_format($p['old_price']) ?></span>
                        </div>
                        <div class="deal-stock-bar-wrap">
                            <div class="deal-stock-bar" style="width: <?= min(90, max(30, ($p['in_stock'] % 70) + 25)) ?>%;"></div>
                            <span class="deal-stock-text">🔥 Only <?= max(3, $p['in_stock'] % 12) ?> sets left</span>
                        </div>
                        <button type="button" class="deal-btn-claim" onclick="if(typeof window.addToCart==='function'){ window.addToCart(<?= $p['id'] ?>, 1); }">
                            <span>Claim Deal</span>
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>



    <!-- ════════════ SECTION 17: RETAILER BOUTIQUE & SMALL SHOP OWNER BANNER ════════════ -->
    <section class="home-banner-strip-section" id="section-retailer-promo" aria-label="Retailer Boutique Sourcing Banner">
        <div class="home-section-container">
            <div class="retailer-promo-banner">
                <!-- Ambient Decorative Glow Orbs -->
                <div class="ret-glow-orb ret-glow-1" aria-hidden="true"></div>
                <div class="ret-glow-orb ret-glow-2" aria-hidden="true"></div>

                <div class="ret-main-content">
                    <div class="ret-left">
                        <!-- Top Badges Row -->
                        <div class="ret-tag-row">
                            <span class="ret-tag">
                                <svg viewBox="0 0 24 24" class="ret-tag-icon"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>FOR SMALL SHOPS & HOME BOUTIQUES</span>
                            </span>
                            <span class="ret-pill-badge">📦 LOW MOQ (4–8 PCS)</span>
                            <span class="ret-pill-badge hide-mobile">💎 60%+ RETAIL MARGINS</span>
                        </div>

                        <!-- Title & Subtitle -->
                        <h2 class="ret-title">Stock Your Boutique Directly From Surat Looms</h2>
                        <p class="ret-subtitle">Tailored for small shopkeepers & home boutique owners. Order small trial lots, mix & match designs/colors, get full GST input tax credit, and enjoy express doorstep counter delivery.</p>

                        <!-- 4 Interactive Retailer Benefits with Real Vector SVG Icons -->
                        <div class="ret-steps-grid">
                            <!-- Benefit 1 -->
                            <div class="ret-step-card">
                                <div class="ret-step-icon-box ret-icon-1">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                    <span class="ret-step-num">01</span>
                                </div>
                                <div class="ret-step-info">
                                    <span class="ret-step-heading">Low MOQ 4–8 Pcs</span>
                                    <span class="ret-step-desc">Zero dead stock risk</span>
                                </div>
                            </div>

                            <div class="ret-connector" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>

                            <!-- Benefit 2 -->
                            <div class="ret-step-card">
                                <div class="ret-step-icon-box ret-icon-2">
                                    <svg viewBox="0 0 24 24">
                                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                        <line x1="8" y1="21" x2="16" y2="21"></line>
                                        <line x1="12" y1="17" x2="12" y2="21"></line>
                                    </svg>
                                    <span class="ret-step-num">02</span>
                                </div>
                                <div class="ret-step-info">
                                    <span class="ret-step-heading">Mix & Match Sets</span>
                                    <span class="ret-step-desc">Assorted colors & sizes</span>
                                </div>
                            </div>

                            <div class="ret-connector" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>

                            <!-- Benefit 3 -->
                            <div class="ret-step-card">
                                <div class="ret-step-icon-box ret-icon-3">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                    </svg>
                                    <span class="ret-step-num">03</span>
                                </div>
                                <div class="ret-step-info">
                                    <span class="ret-step-heading">Full GST & ITC Bill</span>
                                    <span class="ret-step-desc">100% Tax compliant billing</span>
                                </div>
                            </div>

                            <div class="ret-connector" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>

                            <!-- Benefit 4 -->
                            <div class="ret-step-card">
                                <div class="ret-step-icon-box ret-icon-4">
                                    <svg viewBox="0 0 24 24">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg>
                                    <span class="ret-step-num">04</span>
                                </div>
                                <div class="ret-step-info">
                                    <span class="ret-step-heading">Counter Delivery</span>
                                    <span class="ret-step-desc">48-hr insured dispatch</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right CTAs -->
                    <div class="ret-right">
                        <div class="ret-cta-box">
                            <a href="/retailer" class="ret-btn-primary">
                                <span>Open Retailer Hub</span>
                                <svg viewBox="0 0 24 24" class="ret-btn-arrow"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                            <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20I%20have%20a%20Boutique%20%2F%20Retail%20Shop.%20I%20want%20to%20buy%20small%20batch%20catalogs." target="_blank" class="ret-btn-secondary">
                                <svg viewBox="0 0 24 24" class="ret-chat-icon"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                <span>WhatsApp Boutique Desk</span>
                            </a>
                            <div class="ret-trust-pill">
                                <span class="ret-trust-dot"></span>
                                <span>15,000+ Boutique & Shop Owners</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 18: WHOLESALE CTA BANNER ════════════ -->
    <section class="home-banner-strip-section" id="section-wholesale-banner">
        <div class="home-section-container">
            <div class="wholesale-promo-banner">
                <div class="wpb-main-layout">
                    <!-- Left Content -->
                    <div class="wpb-left">
                        <div class="wpb-tag-row">
                            <span class="wpb-tag">
                                <span class="wpb-tag-pulse"></span>
                                🏭 DIRECT FACTORY CONTRACTS • B2B SOURCING
                            </span>
                            <span class="wpb-tag-gold">SURAT LOOM DIRECT</span>
                        </div>

                        <h2 class="wpb-title">Grow Your Wholesale Business <span class="wpb-title-gold">With Surat Manufacturer Pricing</span></h2>
                        <p class="wpb-desc">Unlock direct Surat textile mill rates, premium zero-defect QC, and express door logistics designed for volume wholesalers, mega stockists, and enterprise retailers.</p>

                        <!-- 4 High-Impact Luxury Value Pillars with Vector SVGs -->
                        <div class="wpb-pillars-grid">
                            <div class="wpb-pillar-card">
                                <div class="wpb-pillar-icon">
                                    <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                </div>
                                <div class="wpb-pillar-text">
                                    <strong>100% Factory Direct Rates</strong>
                                    <span>Zero Middlemen Margin Cut</span>
                                </div>
                            </div>

                            <div class="wpb-pillar-card">
                                <div class="wpb-pillar-icon">
                                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                </div>
                                <div class="wpb-pillar-text">
                                    <strong>Full GST Invoices</strong>
                                    <span>100% Tax ITC Credit Eligible</span>
                                </div>
                            </div>

                            <div class="wpb-pillar-card">
                                <div class="wpb-pillar-icon">
                                    <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                                </div>
                                <div class="wpb-pillar-text">
                                    <strong>Doorstep Transport</strong>
                                    <span>Safe Pan-India Express Delivery</span>
                                </div>
                            </div>

                            <div class="wpb-pillar-card">
                                <div class="wpb-pillar-icon">
                                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                                <div class="wpb-pillar-text">
                                    <strong>Dedicated B2B Manager</strong>
                                    <span>Instant WhatsApp Sourcing Desk</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right CTAs -->
                    <div class="wpb-right">
                        <div class="wpb-cta-badge">
                            <span class="wpb-cta-badge-dot"></span>
                            <span>Bulk Sourcing & Catalog Ready</span>
                        </div>
                        <a href="/wholesale" class="wpb-btn-primary">
                            <span>Explore Wholesale Catalog</span>
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%20DT%20Brand%27s%2C%20I%20want%20to%20source%20wholesale%20sarees%2C%20lehengas%20and%20kurtis%20at%20direct%20Surat%20manufacturer%20pricing." target="_blank" class="wpb-btn-secondary">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="#25D366"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                            <span>Chat With B2B Manager</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 19: COLLECTION BANNERS ════════════ -->
    <section class="home-section" id="section-collections">
        <div class="home-section-container">
            <div class="home-section-header">
                <div>
                    <span class="home-section-tag">🌟 EDITORIAL CURATIONS</span>
                    <h2 class="home-section-title">Signature Collections</h2>
                </div>
            </div>

            <div class="collections-banner-grid">
                <div class="col-banner-card col-bridal" onclick="if(typeof window.filterHomeCategory==='function') window.filterHomeCategory('Lehengas');">
                    <div class="col-banner-content">
                        <span class="col-tag">BRIDAL COUTURE</span>
                        <h3 class="col-title">Royal Velvet & Zardozi Lehengas</h3>
                        <span class="col-link">Explore Bridal &rarr;</span>
                    </div>
                </div>

                <div class="col-banner-card col-festive" onclick="if(typeof window.filterHomeCategory==='function') window.filterHomeCategory('Sarees');">
                    <div class="col-banner-content">
                        <span class="col-tag">FESTIVE SILKS</span>
                        <h3 class="col-title">Heritage Banarasi & Kanjivaram</h3>
                        <span class="col-link">Explore Silks &rarr;</span>
                    </div>
                </div>

                <div class="col-banner-card col-party" onclick="if(typeof window.filterHomeCategory==='function') window.filterHomeCategory('Kurtis');">
                    <div class="col-banner-content">
                        <span class="col-tag">PARTY WEAR</span>
                        <h3 class="col-title">Anarkali & Sharara Sets</h3>
                        <span class="col-link">Explore Kurtis &rarr;</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 20: RECOMMENDED FOR YOU (2-LINE HORIZONTAL SCROLL) ════════════ -->
    <section class="home-section rec-section" id="section-recommended">
        <div class="home-section-container">
            <!-- Luxury Section Header with Badges, Subtitle and Controls -->
            <div class="rec-section-header">
                <div class="rec-header-titles">
                    <div class="rec-ai-badge-wrap">
                        <span class="rec-ai-badge"><span class="rec-sparkle">✨</span> AI PERSONALIZED PICKS</span>
                        <span class="rec-match-pill">● 98% Match Rate</span>
                    </div>
                    <h2 class="home-section-title rec-title" id="recommendedTitle">Recommended For You</h2>
                    <p class="rec-subtitle">Tailored ethnic collections curated from Surat looms based on your browsing & boutique trends.</p>
                </div>
                
                <div class="rec-header-controls">
                    <div class="rec-nav-arrows">
                        <button type="button" class="rec-arrow-btn rec-prev-arrow" onclick="window.slideRecommended(-1)" aria-label="Previous Recommendations">
                            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="rec-arrow-btn rec-next-arrow" onclick="window.slideRecommended(1)" aria-label="Next Recommendations">
                            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Category Filter Pills Bar -->
            <div class="rec-filter-pills-bar">
                <button type="button" class="rec-filter-pill active" onclick="window.filterRecommendedCategory('All', this)">✨ All Picks (<?= count($products) ?>)</button>
                <button type="button" class="rec-filter-pill" onclick="window.filterRecommendedCategory('Sarees', this)">👑 Silk Sarees</button>
                <button type="button" class="rec-filter-pill" onclick="window.filterRecommendedCategory('Kurtis', this)">👗 Kurtis & Sets</button>
                <button type="button" class="rec-filter-pill" onclick="window.filterRecommendedCategory('Lehengas', this)">👰 Bridal Lehengas</button>
                <button type="button" class="rec-filter-pill" onclick="window.filterRecommendedCategory('Gowns', this)">💎 Designer Gowns</button>
            </div>

            <!-- 2-Line Horizontal Scrolling Multi-Row Track (Desktop: 5 per row, Mobile: 2 per row) -->
            <div class="rec-scroll-wrap" id="recScrollWrap">
                <div class="rec-scroll-track" id="recommendedGrid">
                    <?php 
                    // Duplicate products for rich continuous 2-row multi-page scroll
                    $allRecProducts = array_merge($products, $products);
                    foreach ($allRecProducts as $idx => $p): 
                        $aiScore = 95 + ($idx % 5);
                        $profit = !empty($p['reseller_profit']) ? $p['reseller_profit'] : round($p['price'] * 0.4);
                        $oldP = !empty($p['old_price']) ? $p['old_price'] : round($p['price'] * 1.5);
                        $disc = !empty($p['discount']) ? $p['discount'] : round((($oldP - $p['price']) / $oldP) * 100);
                        $rating = !empty($p['rating']) ? $p['rating'] : '4.9';
                        $reviews = !empty($p['reviews_count']) ? $p['reviews_count'] : 84;
                    ?>
                    <article class="rec-card" data-category="<?= htmlspecialchars($p['category']) ?>" data-product-id="<?= $p['id'] ?>">
                        <!-- Pure Luxury Image Showcase with Badges & Action Overlays -->
                        <div class="rec-img-wrap">
                            <a href="../Single-Product/singleproduct.php?id=<?= $p['id'] ?>" class="rec-img-link" title="<?= htmlspecialchars($p['name']) ?>">
                                <img src="<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="rec-card-img" loading="lazy" />
                            </a>
                            
                            <!-- AI Match & Discount Badges -->
                            <div class="rec-badges-top">
                                <span class="rec-badge-ai">✨ <?= $aiScore ?>% Match</span>
                                <span class="rec-badge-disc"><?= $disc ?>% OFF</span>
                            </div>

                            <!-- Quick Action Buttons Overlay -->
                            <div class="rec-overlay-actions">
                                <button type="button" class="rec-action-btn rec-wishlist-btn" onclick="toggleWishlist(<?= $p['id'] ?>); event.stopPropagation();" aria-label="Add to Wishlist" title="Add to Wishlist">
                                    <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                </button>
                                <button type="button" class="rec-action-btn rec-quickview-btn" onclick="if(typeof openQuickView==='function'){openQuickView(<?= $p['id'] ?>);}else{window.location.href='../Single-Product/singleproduct.php?id=<?= $p['id'] ?>';} event.stopPropagation();" aria-label="Quick View" title="Quick View">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Scroll Progress Track Indicator -->
            <div class="rec-scrollbar-track" id="recScrollbarTrack">
                <div class="rec-scrollbar-thumb" id="recScrollbarThumb"></div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 21: RECENTLY VIEWED ════════════ -->
    <section class="home-section" id="section-recently-viewed" style="display:none;">
        <div class="home-section-container">
            <div class="home-section-header">
                <div>
                    <span class="home-section-tag">🕒 BROWSING HISTORY</span>
                    <h2 class="home-section-title">Recently Viewed Products</h2>
                </div>
                <div class="home-section-actions" style="display:flex; align-items:center; gap:12px;">
                    <button type="button" class="home-section-sub-link" onclick="if(typeof window.clearRecentlyViewed==='function') window.clearRecentlyViewed();" style="background:none; border:none; color:var(--dark-gold, #8A681F); font-size:0.80rem; font-weight:700; cursor:pointer; text-decoration:underline;">Clear History ✕</button>
                    <div class="rv-scroll-nav-btns" style="display:flex; gap:6px;">
                        <button type="button" class="rv-nav-btn rv-prev-btn" onclick="window.slideRecentlyViewed(-1)" aria-label="Previous Recently Viewed">
                            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="rv-nav-btn rv-next-btn" onclick="window.slideRecentlyViewed(1)" aria-label="Next Recently Viewed">
                            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="recently-viewed-rail-wrap">
                <div class="recently-viewed-track" id="recentlyViewedTrack">
                    <!-- Dynamically populated from localStorage via JS -->
                </div>
            </div>
            <div class="rv-scrollbar-track" id="rvScrollbarTrack">
                <div class="rv-scrollbar-thumb" id="rvScrollbarThumb"></div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 23: HOW RESELLING WORKS ════════════ -->
    <section class="home-section workflow-section-reseller" id="section-how-reselling-works">
        <div class="home-section-container">
            <div class="home-section-header" style="text-align:center; justify-content:center;">
                <div>
                    <span class="home-section-tag workflow-tag-reseller">
                        <svg viewBox="0 0 24 24" class="tag-live-icon"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        ZERO INVESTMENT RESELLING
                    </span>
                    <h2 class="home-section-title">How Ethnic Wear Reselling Works</h2>
                    <p class="home-section-desc">Start earning without spending a single rupee on inventory or warehousing.</p>
                </div>
            </div>

            <div class="roadmap-grid">
                <!-- Step 01 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">01</span>
                    <div class="roadmap-icon-wrap rm-icon-reseller-1">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-float">
                            <defs>
                                <linearGradient id="resGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#F59E0B" />
                                    <stop offset="100%" stop-color="#D97706" />
                                </linearGradient>
                            </defs>
                            <!-- Shopping Bag -->
                            <rect x="14" y="22" width="36" height="34" rx="8" fill="url(#resGrad1)" opacity="0.15" />
                            <rect x="14" y="22" width="36" height="34" rx="8" stroke="#D97706" stroke-width="3" fill="none" />
                            <!-- Bag Handle -->
                            <path d="M24 22V15a8 8 0 0 1 16 0v7" stroke="#B45309" stroke-width="3" stroke-linecap="round" fill="none" />
                            <!-- Clothes Hanger & Saree -->
                            <path d="M32 28l-8 7h16z" fill="#F59E0B" />
                            <circle cx="32" cy="27" r="2" fill="#B45309" />
                            <!-- Sparkling Star -->
                            <path d="M46 12l1.5 3.5L51 17l-3.5 1.5L46 22l-1.5-3.5L41 17l3.5-1.5z" fill="#F59E0B" class="svg-anim-sparkle" />
                        </svg>
                    </div>
                    <h3 class="roadmap-title">Choose Products</h3>
                    <p class="roadmap-desc">Browse 1,000+ ready factory catalog sarees, kurtis & lehengas with HD media.</p>
                </div>

                <!-- Step 02 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">02</span>
                    <div class="roadmap-icon-wrap rm-icon-reseller-2">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-bounce">
                            <defs>
                                <linearGradient id="resGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#10B981" />
                                    <stop offset="100%" stop-color="#047857" />
                                </linearGradient>
                            </defs>
                            <!-- Gold Coin Backing -->
                            <circle cx="28" cy="34" r="16" fill="url(#resGrad2)" opacity="0.15" />
                            <circle cx="28" cy="34" r="16" stroke="#059669" stroke-width="3" fill="none" />
                            <!-- Rupee Symbol -->
                            <path d="M22 28h12M22 32h10M27 28v12M27 32a5 5 0 0 0 5-5M26 35l6 7" stroke="#047857" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
                            <!-- Profit Surge Badge -->
                            <rect x="36" y="14" width="22" height="14" rx="4" fill="#10B981" />
                            <path d="M41 22l3-3 3 2 5-5" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                            <polyline points="48 16 52 16 52 20" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" fill="none" />
                        </svg>
                    </div>
                    <h3 class="roadmap-title">Add Your Margin</h3>
                    <p class="roadmap-desc">Set your selling price. For example: Buy at ₹1,399, sell at ₹3,499 (₹2,100 profit).</p>
                </div>

                <!-- Step 03 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">03</span>
                    <div class="roadmap-icon-wrap rm-icon-reseller-3">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-pulse">
                            <defs>
                                <linearGradient id="resGrad3" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#6366F1" />
                                    <stop offset="100%" stop-color="#4338CA" />
                                </linearGradient>
                            </defs>
                            <!-- Central Node -->
                            <circle cx="20" cy="32" r="8" fill="url(#resGrad3)" opacity="0.2" />
                            <circle cx="20" cy="32" r="8" stroke="#4F46E5" stroke-width="3" fill="#FFFFFF" />
                            <circle cx="20" cy="32" r="3" fill="#4338CA" />
                            <!-- Outer Client Nodes -->
                            <circle cx="46" cy="18" r="6" stroke="#4F46E5" stroke-width="2.5" fill="#EEF2FF" />
                            <circle cx="46" cy="46" r="6" stroke="#4F46E5" stroke-width="2.5" fill="#EEF2FF" />
                            <!-- Share Signal Beams -->
                            <line x1="27" y1="28" x2="40" y2="21" stroke="#6366F1" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="2 2" />
                            <line x1="27" y1="36" x2="40" y2="43" stroke="#6366F1" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="2 2" />
                            <!-- WhatsApp / Chat Cloud -->
                            <path d="M43 16h6v4h-6z" fill="#4338CA" />
                            <path d="M43 44h6v4h-6z" fill="#4338CA" />
                        </svg>
                    </div>
                    <h3 class="roadmap-title">Share With Clients</h3>
                    <p class="roadmap-desc">1-tap share high-res photos and catalogs on WhatsApp, Instagram & Facebook.</p>
                </div>

                <!-- Step 04 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">04</span>
                    <div class="roadmap-icon-wrap rm-icon-reseller-4">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-float">
                            <defs>
                                <linearGradient id="resGrad4" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#EC4899" />
                                    <stop offset="100%" stop-color="#BE185D" />
                                </linearGradient>
                            </defs>
                            <!-- Bank Shield & Vault -->
                            <path d="M32 10L14 18v16c0 12 18 20 18 20s18-8 18-20V18L32 10z" fill="url(#resGrad4)" opacity="0.15" />
                            <path d="M32 10L14 18v16c0 12 18 20 18 20s18-8 18-20V18L32 10z" stroke="#DB2777" stroke-width="3" stroke-linejoin="round" fill="none" />
                            <!-- Verified Green Direct Credit Checkmark -->
                            <circle cx="32" cy="32" r="10" fill="#10B981" />
                            <path d="M28 32l3 3 6-6" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                        </svg>
                    </div>
                    <h3 class="roadmap-title">Earn Direct Profit</h3>
                    <p class="roadmap-desc">We dispatch under your boutique name; profit is credited directly to your bank account.</p>
                </div>
            </div>

            <div style="text-align:center; margin-top:32px;">
                <a href="/reseller" class="workflow-cta-btn">
                    <span>Start Reselling Today (Zero Cost)</span>
                    <span class="btn-arrow-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 23B: HOW RETAILER BOUTIQUE SOURCING WORKS ════════════ -->
    <section class="home-section workflow-section-retailer" id="section-how-retailer-works">
        <div class="home-section-container">
            <div class="home-section-header" style="text-align:center; justify-content:center;">
                <div>
                    <span class="home-section-tag workflow-tag-retailer">
                        <svg viewBox="0 0 24 24" class="tag-live-icon"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                        FOR SMALL SHOPS & HOME BOUTIQUES
                    </span>
                    <h2 class="home-section-title">How Retail Boutique Sourcing Works</h2>
                    <p class="home-section-desc">Low MOQ, mix & match designs, and Surat factory direct pricing for boutique owners.</p>
                </div>
            </div>

            <div class="roadmap-grid">
                <!-- Step 01 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">01</span>
                    <div class="roadmap-icon-wrap rm-icon-retailer-1">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-float">
                            <defs>
                                <linearGradient id="retGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#3B82F6" />
                                    <stop offset="100%" stop-color="#1D4ED8" />
                                </linearGradient>
                            </defs>
                            <!-- 3D Parcel Box -->
                            <path d="M32 12L14 22l18 10 18-10L32 12z" fill="url(#retGrad1)" opacity="0.2" />
                            <path d="M14 22v20l18 10V32L14 22z" fill="#93C5FD" opacity="0.4" />
                            <path d="M50 22v20L32 52V32l18-10z" fill="#60A5FA" opacity="0.4" />
                            <path d="M32 12L14 22l18 10 18-10L32 12zm0 40V32m-18-10v20l18 10 18-10V22" stroke="#2563EB" stroke-width="3" stroke-linejoin="round" fill="none" />
                            <!-- Low MOQ Badge -->
                            <circle cx="48" cy="18" r="8" fill="#F59E0B" />
                            <text x="48" y="21" font-size="8" font-weight="900" fill="#FFFFFF" text-anchor="middle" font-family="sans-serif">4pc</text>
                        </svg>
                    </div>
                    <h3 class="roadmap-title">Small Batch Lots</h3>
                    <p class="roadmap-desc">Order trial packs with low MOQ (4–8 pieces) to test trending styles with zero risk.</p>
                </div>

                <!-- Step 02 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">02</span>
                    <div class="roadmap-icon-wrap rm-icon-retailer-2">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-sparkle">
                            <defs>
                                <linearGradient id="retGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#F59E0B" />
                                    <stop offset="100%" stop-color="#B45309" />
                                </linearGradient>
                            </defs>
                            <!-- Swatches Palette Fan -->
                            <path d="M16 48L32 18l16 30H16z" fill="url(#retGrad2)" opacity="0.15" />
                            <!-- Color circles -->
                            <circle cx="24" cy="40" r="5" fill="#EF4444" />
                            <circle cx="32" cy="28" r="5" fill="#10B981" />
                            <circle cx="40" cy="40" r="5" fill="#3B82F6" />
                            <!-- Needle & Tailor Tape -->
                            <path d="M20 18l24 28" stroke="#D97706" stroke-width="3" stroke-linecap="round" />
                            <circle cx="20" cy="18" r="2" fill="#B45309" />
                        </svg>
                    </div>
                    <h3 class="roadmap-title">Mix & Match Styles</h3>
                    <p class="roadmap-desc">Pick assorted colors, blouse sizes & embroidery variations within the same catalog.</p>
                </div>

                <!-- Step 03 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">03</span>
                    <div class="roadmap-icon-wrap rm-icon-retailer-3">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-bounce">
                            <defs>
                                <linearGradient id="retGrad3" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#10B981" />
                                    <stop offset="100%" stop-color="#047857" />
                                </linearGradient>
                            </defs>
                            <!-- Official Invoice Paper -->
                            <path d="M18 12h20l12 12v28a4 4 0 0 1-4 4H18a4 4 0 0 1-4-4V16a4 4 0 0 1 4-4z" fill="url(#retGrad3)" opacity="0.15" />
                            <path d="M18 12h20l12 12v28a4 4 0 0 1-4 4H18a4 4 0 0 1-4-4V16a4 4 0 0 1 4-4z" stroke="#059669" stroke-width="3" fill="none" />
                            <polyline points="38 12 38 24 50 24" stroke="#059669" stroke-width="3" stroke-linejoin="round" fill="none" />
                            <!-- Lines -->
                            <line x1="22" y1="32" x2="34" y2="32" stroke="#047857" stroke-width="2.5" stroke-linecap="round" />
                            <line x1="22" y1="38" x2="42" y2="38" stroke="#047857" stroke-width="2.5" stroke-linecap="round" />
                            <!-- ITC 100% Stamp -->
                            <rect x="28" y="42" width="18" height="8" rx="2" fill="#10B981" />
                            <text x="37" y="48" font-size="5" font-weight="900" fill="#FFFFFF" text-anchor="middle" font-family="sans-serif">GST ITC</text>
                        </svg>
                    </div>
                    <h3 class="roadmap-title">GST ITC Invoices</h3>
                    <p class="roadmap-desc">Get complete B2B tax invoices with full Input Tax Credit (ITC) for your business.</p>
                </div>

                <!-- Step 04 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">04</span>
                    <div class="roadmap-icon-wrap rm-icon-retailer-4">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-pulse">
                            <defs>
                                <linearGradient id="retGrad4" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#8B5CF6" />
                                    <stop offset="100%" stop-color="#6D28D9" />
                                </linearGradient>
                            </defs>
                            <!-- Delivery Van -->
                            <rect x="12" y="24" width="26" height="20" rx="3" fill="url(#retGrad4)" opacity="0.2" />
                            <rect x="12" y="24" width="26" height="20" rx="3" stroke="#7C3AED" stroke-width="3" fill="none" />
                            <path d="M38 30h10l6 6v8h-16V30z" fill="url(#retGrad4)" opacity="0.2" />
                            <path d="M38 30h10l6 6v8h-16V30z" stroke="#7C3AED" stroke-width="3" stroke-linejoin="round" fill="none" />
                            <!-- Wheels -->
                            <circle cx="22" cy="48" r="5" fill="#1F2937" stroke="#7C3AED" stroke-width="2" />
                            <circle cx="46" cy="48" r="5" fill="#1F2937" stroke="#7C3AED" stroke-width="2" />
                            <!-- Speed Wind Lines -->
                            <line x1="4" y1="28" x2="8" y2="28" stroke="#A78BFA" stroke-width="2" stroke-linecap="round" />
                            <line x1="2" y1="34" x2="7" y2="34" stroke="#A78BFA" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="roadmap-title">Shop Counter Delivery</h3>
                    <p class="roadmap-desc">Insured door-to-door express parcel delivery directly to your boutique counter.</p>
                </div>
            </div>

            <div style="text-align:center; margin-top:32px;">
                <a href="/retailer" class="workflow-cta-btn">
                    <span>Explore Retailer Boutique Hub</span>
                    <span class="btn-arrow-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 24: HOW WHOLESALE WORKS ════════════ -->
    <section class="home-section workflow-section-wholesale" id="section-how-wholesale-works">
        <div class="home-section-container">
            <div class="home-section-header" style="text-align:center; justify-content:center;">
                <div>
                    <span class="home-section-tag workflow-tag-wholesale">
                        <svg viewBox="0 0 24 24" class="tag-live-icon"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        B2B BULK WORKFLOW
                    </span>
                    <h2 class="home-section-title">How Wholesale Purchasing Works</h2>
                    <p class="home-section-desc">Streamlined factory supply for large retail showrooms & traders across India.</p>
                </div>
            </div>

            <div class="roadmap-grid">
                <!-- Step 01 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">01</span>
                    <div class="roadmap-icon-wrap rm-icon-wholesale-1">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-float">
                            <defs>
                                <linearGradient id="whGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#EA580C" />
                                    <stop offset="100%" stop-color="#C2410C" />
                                </linearGradient>
                            </defs>
                            <!-- Factory Master Roll -->
                            <rect x="16" y="24" width="32" height="24" rx="4" fill="url(#whGrad1)" opacity="0.2" />
                            <rect x="16" y="24" width="32" height="24" rx="4" stroke="#EA580C" stroke-width="3" fill="none" />
                            <ellipse cx="48" cy="36" rx="4" ry="12" fill="#FED7AA" stroke="#EA580C" stroke-width="2" />
                            <!-- Loom Thread Lines -->
                            <line x1="20" y1="30" x2="44" y2="30" stroke="#C2410C" stroke-width="2" stroke-linecap="round" />
                            <line x1="20" y1="36" x2="44" y2="36" stroke="#C2410C" stroke-width="2" stroke-linecap="round" />
                            <line x1="20" y1="42" x2="44" y2="42" stroke="#C2410C" stroke-width="2" stroke-linecap="round" />
                            <!-- Set Lot Crown -->
                            <path d="M26 16l3 4 3-4 3 4 3-4v5H26z" fill="#EA580C" />
                        </svg>
                    </div>
                    <h3 class="roadmap-title">Select Full Sets</h3>
                    <p class="roadmap-desc">Explore full catalog set lots with clear MOQ slabs from 12 to 48 pieces.</p>
                </div>

                <!-- Step 02 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">02</span>
                    <div class="roadmap-icon-wrap rm-icon-wholesale-2">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-bounce">
                            <defs>
                                <linearGradient id="whGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#059669" />
                                    <stop offset="100%" stop-color="#047857" />
                                </linearGradient>
                            </defs>
                            <!-- Volume Tier Stair Bars -->
                            <rect x="14" y="38" width="8" height="14" rx="2" fill="#A7F3D0" stroke="#059669" stroke-width="2" />
                            <rect x="26" y="28" width="8" height="24" rx="2" fill="#6EE7B7" stroke="#059669" stroke-width="2" />
                            <rect x="38" y="18" width="8" height="34" rx="2" fill="url(#whGrad2)" stroke="#047857" stroke-width="2" />
                            <!-- Discount Up-Arrow Wave -->
                            <path d="M16 34l12-10 14-8" stroke="#047857" stroke-width="2.5" stroke-linecap="round" fill="none" />
                            <polygon points="46 16 42 16 45 19" fill="#047857" />
                        </svg>
                    </div>
                    <h3 class="roadmap-title">Volume Tier Slabs</h3>
                    <p class="roadmap-desc">Select higher quantities to unlock maximum tier discounts straight from the loom.</p>
                </div>

                <!-- Step 03 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">03</span>
                    <div class="roadmap-icon-wrap rm-icon-wholesale-3">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-sparkle">
                            <defs>
                                <linearGradient id="whGrad3" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#2563EB" />
                                    <stop offset="100%" stop-color="#1D4ED8" />
                                </linearGradient>
                            </defs>
                            <!-- Factory Tag & Mill Calculator -->
                            <path d="M18 16l18-6 16 16-18 18-16-16V16z" fill="url(#whGrad3)" opacity="0.15" />
                            <path d="M18 16l18-6 16 16-18 18-16-16V16z" stroke="#2563EB" stroke-width="3" stroke-linejoin="round" fill="none" />
                            <circle cx="26" cy="22" r="3" fill="#1D4ED8" />
                            <!-- Factory Direct Price Symbol -->
                            <text x="34" y="36" font-size="9" font-weight="900" fill="#1E40AF" font-family="sans-serif">₹NET</text>
                        </svg>
                    </div>
                    <h3 class="roadmap-title">Factory Net Pricing</h3>
                    <p class="roadmap-desc">Automatic wholesale tier discounts and GST input credit breakdown applied.</p>
                </div>

                <!-- Step 04 -->
                <div class="roadmap-step-card">
                    <span class="roadmap-num">04</span>
                    <div class="roadmap-icon-wrap rm-icon-wholesale-4">
                        <svg viewBox="0 0 64 64" class="workflow-svg svg-anim-pulse">
                            <defs>
                                <linearGradient id="whGrad4" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#9333EA" />
                                    <stop offset="100%" stop-color="#6B21A8" />
                                </linearGradient>
                            </defs>
                            <!-- Pan India Logistics Container Truck -->
                            <rect x="10" y="22" width="30" height="22" rx="3" fill="url(#whGrad4)" opacity="0.2" />
                            <rect x="10" y="22" width="30" height="22" rx="3" stroke="#9333EA" stroke-width="3" fill="none" />
                            <path d="M40 28h10l6 6v10H40V28z" fill="url(#whGrad4)" opacity="0.2" />
                            <path d="M40 28h10l6 6v10H40V28z" stroke="#9333EA" stroke-width="3" stroke-linejoin="round" fill="none" />
                            <!-- Heavy Wheels -->
                            <circle cx="20" cy="48" r="5" fill="#1F2937" stroke="#9333EA" stroke-width="2" />
                            <circle cx="32" cy="48" r="5" fill="#1F2937" stroke="#9333EA" stroke-width="2" />
                            <circle cx="48" cy="48" r="5" fill="#1F2937" stroke="#9333EA" stroke-width="2" />
                            <!-- GPS Location Beacon -->
                            <circle cx="25" cy="14" r="4" fill="#EF4444" />
                            <path d="M25 18v3" stroke="#EF4444" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="roadmap-title">Transport Logistics</h3>
                    <p class="roadmap-desc">Express transport parcel booking with door-to-door tracking across India.</p>
                </div>
            </div>

            <div style="text-align:center; margin-top:32px;">
                <a href="/wholesale" class="workflow-cta-btn">
                    <span>Browse Wholesale Lots</span>
                    <span class="btn-arrow-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 25: WHY CHOOSE US (8 VALUE PILLARS) ════════════ -->
    <section class="home-section section-why-us-luxury" id="section-why-choose-us">
        <div class="home-section-container">
            <div class="home-section-header" style="text-align:center; justify-content:center;">
                <div>
                    <span class="home-section-tag why-section-tag">
                        <svg viewBox="0 0 24 24" class="tag-live-icon"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        THE DT BRAND PROMISE
                    </span>
                    <h2 class="home-section-title">Why 50,000+ Buyers Trust DT Brand's</h2>
                    <p class="home-section-desc">Direct factory transparency, artisan craftsmanship, and zero-compromise quality assurance.</p>
                </div>
            </div>

            <div class="why-us-grid">
                <!-- Pillar 1: 100% Heritage Quality -->
                <div class="why-us-card">
                    <div class="why-icon-wrap why-icon-gold">
                        <svg viewBox="0 0 64 64" class="why-us-svg svg-anim-sparkle">
                            <defs>
                                <linearGradient id="whyGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#F59E0B" />
                                    <stop offset="100%" stop-color="#B45309" />
                                </linearGradient>
                            </defs>
                            <!-- 3D Luxury Diamond -->
                            <polygon points="32 10 50 24 32 54 14 24" fill="url(#whyGrad1)" opacity="0.2" />
                            <polygon points="32 10 50 24 32 54 14 24" stroke="#D97706" stroke-width="3" stroke-linejoin="round" fill="none" />
                            <line x1="14" y1="24" x2="50" y2="24" stroke="#D97706" stroke-width="2.5" />
                            <line x1="32" y1="10" x2="24" y2="24" stroke="#D97706" stroke-width="2" />
                            <line x1="32" y1="10" x2="40" y2="24" stroke="#D97706" stroke-width="2" />
                            <line x1="32" y1="54" x2="24" y2="24" stroke="#D97706" stroke-width="2" />
                            <line x1="32" y1="54" x2="40" y2="24" stroke="#D97706" stroke-width="2" />
                            <!-- Sparkle Star -->
                            <path d="M48 10l1 2.5L52 14l-3 1.5L48 18l-1-2.5L44 14l3-1.5z" fill="#F59E0B" />
                        </svg>
                    </div>
                    <h4 class="why-title">100% Heritage Quality</h4>
                    <p class="why-desc">Authentic silk and artisan zari craft tested for colorfastness and durability.</p>
                </div>

                <!-- Pillar 2: Surat Factory Pricing -->
                <div class="why-us-card">
                    <div class="why-icon-wrap why-icon-amber">
                        <svg viewBox="0 0 64 64" class="why-us-svg svg-anim-float">
                            <defs>
                                <linearGradient id="whyGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#EA580C" />
                                    <stop offset="100%" stop-color="#C2410C" />
                                </linearGradient>
                            </defs>
                            <!-- Factory Roof & Chimneys -->
                            <path d="M14 48V28l12 8V24l12 8V20l12 8v20H14z" fill="url(#whyGrad2)" opacity="0.2" />
                            <path d="M14 48V28l12 8V24l12 8V20l12 8v20H14z" stroke="#EA580C" stroke-width="3" stroke-linejoin="round" fill="none" />
                            <!-- Mill Windows -->
                            <rect x="20" y="38" width="6" height="6" rx="1" fill="#EA580C" />
                            <rect x="32" y="38" width="6" height="6" rx="1" fill="#EA580C" />
                            <rect x="44" y="38" width="6" height="6" rx="1" fill="#EA580C" />
                            <!-- Direct Rupee Coin -->
                            <circle cx="48" cy="14" r="8" fill="#F59E0B" />
                            <text x="48" y="17" font-size="9" font-weight="900" fill="#FFFFFF" text-anchor="middle" font-family="sans-serif">₹</text>
                        </svg>
                    </div>
                    <h4 class="why-title">Surat Factory Pricing</h4>
                    <p class="why-desc">Zero middlemen commissions. Direct manufacturer pricing for best margins.</p>
                </div>

                <!-- Pillar 3: Express Dispatch -->
                <div class="why-us-card">
                    <div class="why-icon-wrap why-icon-emerald">
                        <svg viewBox="0 0 64 64" class="why-us-svg svg-anim-pulse">
                            <defs>
                                <linearGradient id="whyGrad3" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#10B981" />
                                    <stop offset="100%" stop-color="#047857" />
                                </linearGradient>
                            </defs>
                            <!-- Express Van -->
                            <rect x="12" y="24" width="24" height="18" rx="3" fill="url(#whyGrad3)" opacity="0.2" />
                            <rect x="12" y="24" width="24" height="18" rx="3" stroke="#059669" stroke-width="3" fill="none" />
                            <path d="M36 30h10l6 6v6h-16V30z" fill="url(#whyGrad3)" opacity="0.2" />
                            <path d="M36 30h10l6 6v6h-16V30z" stroke="#059669" stroke-width="3" stroke-linejoin="round" fill="none" />
                            <!-- Wheels -->
                            <circle cx="20" cy="46" r="4.5" fill="#1F2937" stroke="#059669" stroke-width="2" />
                            <circle cx="44" cy="46" r="4.5" fill="#1F2937" stroke="#059669" stroke-width="2" />
                            <!-- Speed Lightning -->
                            <polygon points="26 10 18 20 25 20 22 28 30 18 23 18 26 10" fill="#F59E0B" />
                        </svg>
                    </div>
                    <h4 class="why-title">Express Dispatch</h4>
                    <p class="why-desc">98% of orders dispatched within 24 to 48 hours with door-to-door tracking.</p>
                </div>

                <!-- Pillar 4: 100% Secure Payments -->
                <div class="why-us-card">
                    <div class="why-icon-wrap why-icon-indigo">
                        <svg viewBox="0 0 64 64" class="why-us-svg svg-anim-bounce">
                            <defs>
                                <linearGradient id="whyGrad4" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#6366F1" />
                                    <stop offset="100%" stop-color="#4338CA" />
                                </linearGradient>
                            </defs>
                            <!-- Security Shield -->
                            <path d="M32 10L14 18v16c0 12 18 20 18 20s18-8 18-20V18L32 10z" fill="url(#whyGrad4)" opacity="0.2" />
                            <path d="M32 10L14 18v16c0 12 18 20 18 20s18-8 18-20V18L32 10z" stroke="#4F46E5" stroke-width="3" stroke-linejoin="round" fill="none" />
                            <!-- Padlock in Shield -->
                            <rect x="25" y="30" width="14" height="11" rx="2" fill="#4F46E5" />
                            <path d="M28 30v-4a4 4 0 0 1 8 0v4" stroke="#4F46E5" stroke-width="2.5" fill="none" />
                            <circle cx="32" cy="35" r="1.5" fill="#FFFFFF" />
                        </svg>
                    </div>
                    <h4 class="why-title">100% Secure Payments</h4>
                    <p class="why-desc">UPI, Cards, Netbanking, COD and NEFT/RTGS bank transfers supported.</p>
                </div>

                <!-- Pillar 5: Reseller Friendly -->
                <div class="why-us-card">
                    <div class="why-icon-wrap why-icon-rose">
                        <svg viewBox="0 0 64 64" class="why-us-svg svg-anim-float">
                            <defs>
                                <linearGradient id="whyGrad5" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#EC4899" />
                                    <stop offset="100%" stop-color="#BE185D" />
                                </linearGradient>
                            </defs>
                            <!-- White-label Parcel Box -->
                            <rect x="14" y="24" width="36" height="26" rx="4" fill="url(#whyGrad5)" opacity="0.2" />
                            <rect x="14" y="24" width="36" height="26" rx="4" stroke="#DB2777" stroke-width="3" fill="none" />
                            <line x1="14" y1="36" x2="50" y2="36" stroke="#DB2777" stroke-width="2.5" />
                            <line x1="32" y1="24" x2="32" y2="50" stroke="#DB2777" stroke-width="2.5" />
                            <!-- Ribbon Bow -->
                            <path d="M26 18c-4 0-6 3-4 6l10 0c2-3 0-6-4-6-2 0-2 2-2 2s0-2-2-2z" fill="#DB2777" />
                            <!-- Boutique Name Tag -->
                            <circle cx="46" cy="18" r="6" fill="#F43F5E" />
                            <path d="M44 18l1.5 1.5 3-3" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                        </svg>
                    </div>
                    <h4 class="why-title">Reseller Friendly</h4>
                    <p class="why-desc">White-label shipping under your boutique name with unbranded packaging.</p>
                </div>

                <!-- Pillar 6: Wholesale Volume Slabs -->
                <div class="why-us-card">
                    <div class="why-icon-wrap why-icon-cyan">
                        <svg viewBox="0 0 64 64" class="why-us-svg svg-anim-bounce">
                            <defs>
                                <linearGradient id="whyGrad6" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#06B6D4" />
                                    <stop offset="100%" stop-color="#0E7490" />
                                </linearGradient>
                            </defs>
                            <!-- 3D Crate Master Stacks -->
                            <rect x="12" y="32" width="18" height="18" rx="2" fill="url(#whyGrad6)" opacity="0.25" stroke="#0891B2" stroke-width="2.5" />
                            <rect x="34" y="22" width="18" height="28" rx="2" fill="url(#whyGrad6)" opacity="0.35" stroke="#0891B2" stroke-width="2.5" />
                            <!-- Tier Discount Up Arrow -->
                            <path d="M16 26l12-8 12-4" stroke="#0891B2" stroke-width="2.5" stroke-linecap="round" fill="none" />
                            <polygon points="44 14 38 15 41 18" fill="#0891B2" />
                            <!-- Discount Tag % -->
                            <circle cx="21" cy="41" r="5" fill="#0891B2" />
                            <text x="21" y="44" font-size="6" font-weight="900" fill="#FFFFFF" text-anchor="middle" font-family="sans-serif">%</text>
                        </svg>
                    </div>
                    <h4 class="why-title">Wholesale Volume Slabs</h4>
                    <p class="why-desc">Transparent tier discounts from 10 to 100+ pieces with GST invoices.</p>
                </div>

                <!-- Pillar 7: 24/7 WhatsApp Support -->
                <div class="why-us-card">
                    <div class="why-icon-wrap why-icon-green">
                        <svg viewBox="0 0 64 64" class="why-us-svg svg-anim-pulse">
                            <defs>
                                <linearGradient id="whyGrad7" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#22C55E" />
                                    <stop offset="100%" stop-color="#15803D" />
                                </linearGradient>
                            </defs>
                            <!-- WhatsApp Speech Cloud -->
                            <path d="M32 12c-12 0-22 9-22 20 0 4 1 8 3 11l-3 9 10-3c3 2 7 3 12 3 12 0 22-9 22-20s-10-20-22-20z" fill="url(#whyGrad7)" opacity="0.2" />
                            <path d="M32 12c-12 0-22 9-22 20 0 4 1 8 3 11l-3 9 10-3c3 2 7 3 12 3 12 0 22-9 22-20s-10-20-22-20z" stroke="#16A34A" stroke-width="3" stroke-linejoin="round" fill="none" />
                            <!-- Support Headset inside -->
                            <path d="M24 32a8 8 0 0 1 16 0v6" stroke="#16A34A" stroke-width="2.5" stroke-linecap="round" fill="none" />
                            <rect x="22" y="30" width="4" height="6" rx="2" fill="#16A34A" />
                            <rect x="38" y="30" width="4" height="6" rx="2" fill="#16A34A" />
                            <path d="M38 38h-4" stroke="#16A34A" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h4 class="why-title">24/7 WhatsApp Support</h4>
                    <p class="why-desc">Instant human support on WhatsApp for orders, tracking, and styling.</p>
                </div>

                <!-- Pillar 8: 7-Day Easy Returns -->
                <div class="why-us-card">
                    <div class="why-icon-wrap why-icon-purple">
                        <svg viewBox="0 0 64 64" class="why-us-svg svg-anim-sparkle">
                            <defs>
                                <linearGradient id="whyGrad8" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#A855F7" />
                                    <stop offset="100%" stop-color="#7E22CE" />
                                </linearGradient>
                            </defs>
                            <!-- 360 Cycle Exchange Arrows -->
                            <path d="M46 24A16 16 0 0 0 18 28" stroke="#9333EA" stroke-width="3.5" stroke-linecap="round" fill="none" />
                            <polygon points="42 18 48 24 42 30" fill="#9333EA" />
                            <path d="M18 40a16 16 0 0 0 28-4" stroke="#9333EA" stroke-width="3.5" stroke-linecap="round" fill="none" />
                            <polygon points="22 46 16 40 22 34" fill="#9333EA" />
                            <!-- 7D Guarantee Badge -->
                            <circle cx="32" cy="32" r="8" fill="#9333EA" />
                            <text x="32" y="35" font-size="7" font-weight="900" fill="#FFFFFF" text-anchor="middle" font-family="sans-serif">7D</text>
                        </svg>
                    </div>
                    <h4 class="why-title">7-Day Easy Returns</h4>
                    <p class="why-desc">Hassle-free replacement policy in case of any manufacturing defects.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 26: VERIFIED BUYER FEEDBACK (1-LINE HORIZONTAL SCROLL) ════════════ -->
    <section class="home-section section-reviews-luxury" id="section-reviews">
        <div class="home-section-container">
            <div class="home-section-header rev-header-flex">
                <div>
                    <span class="home-section-tag rev-section-tag">
                        <svg viewBox="0 0 24 24" class="tag-live-icon"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        VERIFIED BUYER FEEDBACK
                    </span>
                    <h2 class="home-section-title">What Our Customers, Resellers & Wholesalers Say</h2>
                    <p class="home-section-desc">Over 50,000+ verified buyers across India rate us 4.9/5 stars for authenticity, margin & express speed.</p>
                </div>
                
                <div class="rev-header-controls">
                    <!-- Tab Filter Navigation -->
                    <div class="reviews-tab-nav">
                        <button type="button" class="rev-tab-pill active" onclick="switchReviewTab('customers', this)">
                            <span>🏪 Retail Boutiques & Shops</span>
                        </button>
                        <button type="button" class="rev-tab-pill" onclick="switchReviewTab('resellers', this)">
                            <span>⚡ Reseller Partners</span>
                        </button>
                        <button type="button" class="rev-tab-pill" onclick="switchReviewTab('wholesale', this)">
                            <span>🏭 Wholesale Boutiques</span>
                        </button>
                    </div>

                    <!-- 1-Tap Navigation Arrows -->
                    <div class="rev-nav-arrows">
                        <button type="button" class="rev-arrow-btn" onclick="slideReviews('left')" aria-label="Previous Reviews">‹</button>
                        <button type="button" class="rev-arrow-btn" onclick="slideReviews('right')" aria-label="Next Reviews">›</button>
                    </div>
                </div>
            </div>

            <!-- 1-Line Scrolling Tracks Container -->
            <div class="reviews-track-wrap">
                <!-- Retailer & Boutique Reviews Track (1-Line) -->
                <div class="reviews-track active" id="tab-reviews-customers">
                    <!-- Retailer 1: Home Boutique -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-retailer">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Home Boutique
                            </span>
                        </div>
                        
                        <div class="rev-product-pill">
                            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                            <span>Small Batch 4pc Trial Lot • Silk Sarees</span>
                        </div>

                        <p class="rev-text">"I run a home boutique in Mumbai. DT Brand's 4-piece low MOQ lots let me curate fresh Surat silk sarees every 10 days without blocking huge capital. My boutique clients are thrilled with the rich zari finish!"</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-gold">PS</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Pooja Sharma</h5>
                                <span class="rev-location">📍 Mumbai • Owner, Pooja Designer Home Boutique</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Retailer 2: Small Shop Owner -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-retailer">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Small Shop Owner
                            </span>
                        </div>
                        
                        <div class="rev-product-pill">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <span>100% GST ITC Invoices • Direct Surat Rates</span>
                        </div>

                        <p class="rev-text">"Opening our small saree shop in Ahmedabad was made completely hassle-free with DT Brand. Authentic manufacturer pricing, fast 48-hour door delivery, and genuine GST ITC bills for full input tax credit."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-amber">AP</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Ananya Patel</h5>
                                <span class="rev-location">📍 Ahmedabad • Owner, Ananya Ethnic Wear Shop</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Retailer 3: Boutique Designer -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-retailer">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Boutique Designer
                            </span>
                        </div>
                        
                        <div class="rev-product-pill">
                            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                            <span>Mix & Match Lots • Bridal Velvet Lehengas</span>
                        </div>

                        <p class="rev-text">"We stock bridal lehengas and festive kurti sets for our boutique clients. The craftsmanship and heavy zardozi embroidery are flawless. 9 out of 10 walk-in customers buy on their first visit!"</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-emerald">RK</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Ritu Kapoor</h5>
                                <span class="rev-location">📍 Delhi • Founder, Ritu Bridal Studio & Boutique</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Retailer 4: Town Retail Shop -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-retailer">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Town Retail Shop
                            </span>
                        </div>
                        
                        <div class="rev-product-pill">
                            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/></svg>
                            <span>Express Courier • Door Counter Delivery</span>
                        </div>

                        <p class="rev-text">"For our town retail counter, ordering 8 to 16 sarees weekly has doubled our profit margins. The packaging is sturdy with zero damage, and the margin gives us a huge edge over local traders."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-indigo">MS</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Meenakshi Sundaram</h5>
                                <span class="rev-location">📍 Chennai • Owner, Sri Meenakshi Retail Silks</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Retailer 5: Home Studio Seller -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-retailer">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Home Studio Seller
                            </span>
                        </div>
                        
                        <div class="rev-product-pill">
                            <svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            <span>HD Draping Videos • Advance Client Bookings</span>
                        </div>

                        <p class="rev-text">"As a home boutique seller, having HD model draping videos and zero-watermark photos lets me take advance pre-orders effortlessly. DT Brand is our most reliable sourcing partner."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-purple">SM</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Shreya Mukherjee</h5>
                                <span class="rev-location">📍 Kolkata • Owner, Shreya Boutique & Studio</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>
                </div>

                <!-- Reseller Reviews Track (1-Line) -->
                <div class="reviews-track" id="tab-reviews-resellers" style="display:none;">
                    <!-- Reseller 1 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-reseller">
                                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                Top Reseller
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-profit">
                            <svg viewBox="0 0 24 24"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            <span>Monthly Margin: ₹48,200 Pure Profit</span>
                        </div>

                        <p class="rev-text">"I started reselling DT Brand's sarees on WhatsApp 4 months ago. Last month I earned ₹48,200 pure margin! Customers love the unbranded white-label packaging."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-emerald">SM</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Sunita Mehta</h5>
                                <span class="rev-location">📍 Pune • WhatsApp Reseller (₹48k/mo)</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Reseller 2 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-reseller">
                                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                Top Reseller
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-profit">
                            <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                            <span>1-Tap Social Smart Share</span>
                        </div>

                        <p class="rev-text">"1-tap WhatsApp sharing makes it effortless. The photos have zero watermarks, so my clients believe I stock everything in my own boutique."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-rose">KG</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Kavita Gupta</h5>
                                <span class="rev-location">📍 Jaipur • Instagram Boutique Owner</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Reseller 3 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-reseller">
                                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                Top Reseller
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-profit">
                            <svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                            <span>Weekly Direct Bank Payouts</span>
                        </div>

                        <p class="rev-text">"Payouts are credited directly to my bank account every Monday without fail. I have made over ₹1.4 Lakh total profit in 6 months."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-cyan">DN</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Deepa Nair</h5>
                                <span class="rev-location">📍 Kochi • Verified Reseller</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Reseller 4 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-reseller">
                                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                Top Reseller
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-profit">
                            <svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            <span>HD Live Video Reels Media</span>
                        </div>

                        <p class="rev-text">"High-definition video reels and model draping clips help me close 8-10 saree orders every single day on Facebook Marketplace."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-gold">PV</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Preeti Verma</h5>
                                <span class="rev-location">📍 Lucknow • Social Seller</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>
                </div>

                <!-- Wholesale Reviews Track (1-Line) -->
                <div class="reviews-track" id="tab-reviews-wholesale" style="display:none;">
                    <!-- Wholesale 1 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-wholesale">
                                <svg viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Wholesale Buyer
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-b2b">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <span>Monthly 100+ Pieces Lot • GST Invoices</span>
                        </div>

                        <p class="rev-text">"We order 50–100 pieces monthly for our 3 retail boutiques in Hyderabad. The tiered volume slabs save us over 20% compared to local middleman traders."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-indigo">VR</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Venkatesh Rao</h5>
                                <span class="rev-location">📍 Hyderabad • Retail Showroom Chain</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Wholesale 2 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-wholesale">
                                <svg viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Wholesale Buyer
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-b2b">
                            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/></svg>
                            <span>Pan-India Transport Parcel Delivery</span>
                        </div>

                        <p class="rev-text">"Best factory pricing straight from the Surat loom. GST billing is prompt, and transit parcel delivery to Kolkata is 100% insured and reliable."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-amber">MS</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Mukesh Shah</h5>
                                <span class="rev-location">📍 Surat & Kolkata • Textile Trader</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Wholesale 3 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-wholesale">
                                <svg viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Wholesale Buyer
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-b2b">
                            <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                            <span>Low MOQ Trial Packs (4-8 Pcs)</span>
                        </div>

                        <p class="rev-text">"Mix & match catalog trial lots allow us to test trending bridal colors with zero inventory risk. Our boutique sales doubled within 90 days."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-purple">SD</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Sangeeta Deshmukh</h5>
                                <span class="rev-location">📍 Nagpur, Maharashtra • Boutique Owner</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Real-Time Progress Scrollbar -->
            <div class="rev-scrollbar-track" id="revScrollbarTrack">
                <div class="rev-scrollbar-thumb" id="revScrollbarThumb"></div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 29: INSTAGRAM REELS & VIDEO FEED (6 DESKTOP • 3 MOBILE) ════════════ -->
    <section class="home-section section-reels-luxury" id="section-reels">
        <div class="home-section-container">
            <div class="home-section-header reels-header-flex">
                <div>
                    <span class="home-section-tag reels-section-tag">
                        <svg viewBox="0 0 24 24" class="tag-live-icon"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                        REAL PRODUCT VIDEOS
                    </span>
                    <h2 class="home-section-title">Watch Live Draping & Craftsmanship</h2>
                    <p class="home-section-desc">Experience 100% authentic silk luster, zari shine, and model draping before you buy.</p>
                </div>
                
                <div class="reels-header-controls">
                    <button type="button" class="reels-open-all-btn" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(0);">
                        <span>Watch Full Reels</span>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    </button>
                    <!-- 1-Tap Navigation Arrows -->
                    <div class="reels-nav-arrows">
                        <button type="button" class="reels-arrow-btn" onclick="scrollReelsRail(-1)" aria-label="Previous Reels">‹</button>
                        <button type="button" class="reels-arrow-btn" onclick="scrollReelsRail(1)" aria-label="Next Reels">›</button>
                    </div>
                </div>
            </div>

            <!-- 1-Line Reels Scrolling Rail Wrapper -->
            <div class="reels-track-wrap">
                <div class="home-reels-strip" id="homeReelsTrack">
                    <!-- Reel 1 -->
                    <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(0);" role="button" tabindex="0">
                        <div class="reel-media-box">
                            <img src="/Frontend/Shop/Asset/images/product1.png" alt="Pure Kanjivaram Zari Draping" class="reel-img" loading="lazy" />
                            <div class="reel-top-bar">
                                <span class="reel-live-tag"><span class="reel-pulse-dot"></span> LIVE</span>
                                <span class="reel-views-pill">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    24.5k
                                </span>
                            </div>
                            <div class="reel-center-play">
                                <div class="reel-play-btn">
                                    <svg viewBox="0 0 24 24" class="reel-play-svg"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                                </div>
                            </div>
                            <div class="reel-info-overlay">
                                <h4 class="reel-title">Pure Kanjivaram Zari Draping</h4>
                                <div class="reel-meta-row">
                                    <span class="reel-fabric">Pure Silk</span>
                                    <span class="reel-price">₹2,450</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reel 2 -->
                    <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(1);" role="button" tabindex="0">
                        <div class="reel-media-box">
                            <img src="/Frontend/Shop/Asset/images/product2.png" alt="Banarasi Meenakari Saree Close-up" class="reel-img" loading="lazy" />
                            <div class="reel-top-bar">
                                <span class="reel-live-tag reel-tag-loom"><span class="reel-pulse-dot gold"></span> LOOM</span>
                                <span class="reel-views-pill">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    18.2k
                                </span>
                            </div>
                            <div class="reel-center-play">
                                <div class="reel-play-btn">
                                    <svg viewBox="0 0 24 24" class="reel-play-svg"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                                </div>
                            </div>
                            <div class="reel-info-overlay">
                                <h4 class="reel-title">Banarasi Meenakari Weave</h4>
                                <div class="reel-meta-row">
                                    <span class="reel-fabric">Georgette</span>
                                    <span class="reel-price">₹1,850</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reel 3 -->
                    <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(2);" role="button" tabindex="0">
                        <div class="reel-media-box">
                            <img src="/Frontend/Shop/Asset/images/product6.png" alt="Royal Bridal Velvet Lehenga Flare" class="reel-img" loading="lazy" />
                            <div class="reel-top-bar">
                                <span class="reel-live-tag reel-tag-trend"><span class="reel-pulse-dot fire"></span> HOT</span>
                                <span class="reel-views-pill">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    31.0k
                                </span>
                            </div>
                            <div class="reel-center-play">
                                <div class="reel-play-btn">
                                    <svg viewBox="0 0 24 24" class="reel-play-svg"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                                </div>
                            </div>
                            <div class="reel-info-overlay">
                                <h4 class="reel-title">Bridal Velvet Lehenga Flare</h4>
                                <div class="reel-meta-row">
                                    <span class="reel-fabric">Velvet</span>
                                    <span class="reel-price">₹6,999</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reel 4 -->
                    <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(3);" role="button" tabindex="0">
                        <div class="reel-media-box">
                            <img src="/Frontend/Shop/Asset/images/product5.png" alt="Festive Sharara Anarkali Set" class="reel-img" loading="lazy" />
                            <div class="reel-top-bar">
                                <span class="reel-live-tag"><span class="reel-pulse-dot"></span> LIVE</span>
                                <span class="reel-views-pill">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    15.8k
                                </span>
                            </div>
                            <div class="reel-center-play">
                                <div class="reel-play-btn">
                                    <svg viewBox="0 0 24 24" class="reel-play-svg"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                                </div>
                            </div>
                            <div class="reel-info-overlay">
                                <h4 class="reel-title">Festive Gotapatti Anarkali</h4>
                                <div class="reel-meta-row">
                                    <span class="reel-fabric">Cotton Silk</span>
                                    <span class="reel-price">₹1,499</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reel 5 -->
                    <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(0);" role="button" tabindex="0">
                        <div class="reel-media-box">
                            <img src="/Frontend/Shop/Asset/images/product3.png" alt="Handcrafted Zardozi Craftsmanship" class="reel-img" loading="lazy" />
                            <div class="reel-top-bar">
                                <span class="reel-live-tag reel-tag-loom"><span class="reel-pulse-dot gold"></span> CRAFT</span>
                                <span class="reel-views-pill">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    28.7k
                                </span>
                            </div>
                            <div class="reel-center-play">
                                <div class="reel-play-btn">
                                    <svg viewBox="0 0 24 24" class="reel-play-svg"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                                </div>
                            </div>
                            <div class="reel-info-overlay">
                                <h4 class="reel-title">Zardozi Artisan Craft</h4>
                                <div class="reel-meta-row">
                                    <span class="reel-fabric">Silk Blend</span>
                                    <span class="reel-price">₹2,150</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reel 6 -->
                    <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(1);" role="button" tabindex="0">
                        <div class="reel-media-box">
                            <img src="/Frontend/Shop/Asset/images/product4.png" alt="Lucknowi Chikankari Mirror Flare" class="reel-img" loading="lazy" />
                            <div class="reel-top-bar">
                                <span class="reel-live-tag reel-tag-trend"><span class="reel-pulse-dot fire"></span> BEST</span>
                                <span class="reel-views-pill">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    39.4k
                                </span>
                            </div>
                            <div class="reel-center-play">
                                <div class="reel-play-btn">
                                    <svg viewBox="0 0 24 24" class="reel-play-svg"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                                </div>
                            </div>
                            <div class="reel-info-overlay">
                                <h4 class="reel-title">Lucknowi Mirror Saree</h4>
                                <div class="reel-meta-row">
                                    <span class="reel-fabric">Georgette</span>
                                    <span class="reel-price">₹1,799</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reel 7 -->
                    <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(2);" role="button" tabindex="0">
                        <div class="reel-media-box">
                            <img src="/Frontend/Shop/Asset/images/product7.png" alt="Surat Jacquard Loom Weaving" class="reel-img" loading="lazy" />
                            <div class="reel-top-bar">
                                <span class="reel-live-tag reel-tag-loom"><span class="reel-pulse-dot gold"></span> MILL</span>
                                <span class="reel-views-pill">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    52.1k
                                </span>
                            </div>
                            <div class="reel-center-play">
                                <div class="reel-play-btn">
                                    <svg viewBox="0 0 24 24" class="reel-play-svg"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                                </div>
                            </div>
                            <div class="reel-info-overlay">
                                <h4 class="reel-title">Surat Jacquard Loom Live</h4>
                                <div class="reel-meta-row">
                                    <span class="reel-fabric">Surat Net</span>
                                    <span class="reel-price">₹890</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reel 8 -->
                    <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(3);" role="button" tabindex="0">
                        <div class="reel-media-box">
                            <img src="/Frontend/Shop/Asset/images/product8.png" alt="Paithani Peacock Border Draping" class="reel-img" loading="lazy" />
                            <div class="reel-top-bar">
                                <span class="reel-live-tag"><span class="reel-pulse-dot"></span> LIVE</span>
                                <span class="reel-views-pill">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    22.6k
                                </span>
                            </div>
                            <div class="reel-center-play">
                                <div class="reel-play-btn">
                                    <svg viewBox="0 0 24 24" class="reel-play-svg"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                                </div>
                            </div>
                            <div class="reel-info-overlay">
                                <h4 class="reel-title">Paithani Peacock Silk Saree</h4>
                                <div class="reel-meta-row">
                                    <span class="reel-fabric">Pure Silk</span>
                                    <span class="reel-price">₹3,200</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Real-Time Progress Scrollbar -->
            <div class="reels-scrollbar-track" id="reelsScrollbarTrack">
                <div class="reels-scrollbar-thumb" id="reelsScrollbarThumb"></div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 30: WHATSAPP CONCIERGE CTA ════════════ -->
    <section class="home-wa-concierge-section">
        <div class="home-section-container">
            <div class="home-wa-card">
                <div class="home-wa-left">
                    <div class="home-wa-icon-large">
                        <svg viewBox="0 0 24 24" width="36" height="36" fill="#FFFFFF"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="home-wa-title">Need Styling Advice, Reseller Support or Wholesale Quotes?</h3>
                        <p class="home-wa-sub">Our fashion stylists and B2B managers are available live on WhatsApp.</p>
                    </div>
                </div>
                <div class="home-wa-right">
                    <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20I%20would%20like%20to%20know%20more%20about%20DT%20Brand%20products%2C%20reselling%20and%20wholesale." target="_blank" class="home-wa-btn">
                        <span>Chat on WhatsApp</span>
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div><!-- /.page-wrapper -->

<!-- ════════════ SECTION 31: SMART ANIMATED MOBILE BOTTOM FOOTER ════════════ -->
<?php include_once __DIR__ . '/homebottomfooter.php'; ?>

<!-- ════════════ MASTER MODAL SYSTEM INTEGRATIONS ════════════ -->
<?php include_once __DIR__ . '/../../Shared/Includes/quickview.php'; ?>
<?php include_once __DIR__ . '/../../Shared/Includes/smartshare.php'; ?>
<?php include_once __DIR__ . '/../../Shared/Includes/reels.php'; ?>
<?php include_once __DIR__ . '/../../Shared/Includes/cart.php'; ?>
<?php include_once __DIR__ . '/../../Shared/Includes/wishlist.php'; ?>
<?php include_once __DIR__ . '/../../Shared/Includes/checkout.php'; ?>
<?php include_once __DIR__ . '/../../Shared/Includes/account.php'; ?>

<div class="toast-container" id="toastContainer" aria-live="assertive" aria-atomic="true"></div>

<!-- ════════════ MASTER ENGINE SCRIPT ════════════ -->
<script src="/Frontend/Home/Asset/js/home.js?v=<?php echo time(); ?>"></script>

</body>
</html>
