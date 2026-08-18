<?php
/**
 * home.php — DEDICATED NEW HOME PAGE
 * Premium Meesho-Style Ethnic E-Commerce, Reseller & Wholesale Shopping Hub
 * Preserving DT Brand's Heritage Gold UI, Header, Footer & Architecture as Source of Truth
 */

// ── Rich Multi-Category Catalog Database ──
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

                <a href="/Frontend/Reseller/reseller.php" class="quick-card card-reseller">
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

                <a href="/Frontend/Wholesale/wholesale.php" class="quick-card card-wholesale">
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

    <!-- ════════════ SECTION 10: RESELLER BUSINESS BANNER ════════════ -->
    <section class="home-banner-strip-section">
        <div class="home-section-container">
            <div class="reseller-promo-banner">
                <div class="rpb-left">
                    <span class="rpb-tag">⚡ START YOUR OWN BOUTIQUE</span>
                    <h2 class="rpb-title">Start Your Online Ethnic Wear Business Today</h2>
                    <div class="rpb-steps-row">
                        <div class="rpb-step"><span>01</span> Choose Products</div>
                        <div class="rpb-arrow">&rarr;</div>
                        <div class="rpb-step"><span>02</span> Add Your Margin</div>
                        <div class="rpb-arrow">&rarr;</div>
                        <div class="rpb-step"><span>03</span> Share With Clients</div>
                        <div class="rpb-arrow">&rarr;</div>
                        <div class="rpb-step"><span>04</span> Earn Direct Profit</div>
                    </div>
                </div>
                <div class="rpb-right">
                    <a href="/Frontend/Reseller/reseller.php" class="rpb-btn-primary">Start Reselling Free &rarr;</a>
                    <a href="#section-how-reselling-works" class="rpb-btn-secondary" onclick="document.getElementById('section-how-reselling-works').scrollIntoView({behavior:'smooth'}); return false;">How It Works</a>
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

    <!-- ════════════ SECTION 12: NEW ARRIVALS ════════════ -->
    <section class="home-section home-section-soft-bg" id="section-new-arrivals">
        <div class="home-section-container">
            <div class="home-section-header">
                <div>
                    <span class="home-section-tag">✨ FRESH FROM SURAT LOOMS</span>
                    <h2 class="home-section-title">New Arrivals — 2026 Festive Drop</h2>
                </div>
                <a href="#section-trending" class="home-section-sub-link">Browse Full Drop &rarr;</a>
            </div>

            <div class="products-grid">
                <?php foreach (array_slice($products, 4, 4) as $p): ?>
                <article class="product-card">
                    <div class="card-image-wrap">
                        <a href="../Single-Product/singleproduct.php?id=<?= $p['id'] ?>">
                            <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="card-img" />
                        </a>
                        <span class="card-badge badge-new">New Drop</span>
                        <button class="card-wishlist-btn" onclick="toggleWishlistProduct(<?= $p['id'] ?>)">
                            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="card-sku-rating-row">
                            <span class="card-sku-text"><?= $p['sku'] ?></span>
                            <span class="card-rating-badge">★ <?= $p['rating'] ?></span>
                        </div>
                        <h3 class="card-name"><a href="../Single-Product/singleproduct.php?id=<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></a></h3>
                        <div class="card-price-row">
                            <span class="card-price">₹<?= number_format($p['price']) ?></span>
                            <span class="card-old-price">₹<?= number_format($p['old_price']) ?></span>
                        </div>
                        <div class="card-btn-row">
                            <button type="button" class="card-add-cart-btn" onclick="addToCart(<?= $p['id'] ?>, 1)">Add to Cart</button>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 13: BEST SELLERS ════════════ -->
    <section class="home-section" id="section-bestsellers">
        <div class="home-section-container">
            <div class="home-section-header">
                <div>
                    <span class="home-section-tag">👑 ALL-TIME CUSTOMER FAVORITES</span>
                    <h2 class="home-section-title">Best Sellers — 5-Star Rated Heritage Sarees</h2>
                </div>
            </div>

            <div class="products-grid">
                <?php foreach (array_slice($products, 0, 4) as $p): ?>
                <article class="product-card">
                    <div class="card-image-wrap">
                        <a href="../Single-Product/singleproduct.php?id=<?= $p['id'] ?>">
                            <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="card-img" />
                        </a>
                        <span class="card-badge badge-bestseller">👑 Top Seller</span>
                        <button class="card-wishlist-btn" onclick="toggleWishlistProduct(<?= $p['id'] ?>)">
                            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="card-sku-rating-row">
                            <span class="card-sku-text"><?= $p['sku'] ?></span>
                            <span class="card-rating-badge">★ <?= $p['rating'] ?> (<?= $p['reviews_count'] ?> reviews)</span>
                        </div>
                        <h3 class="card-name"><a href="../Single-Product/singleproduct.php?id=<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></a></h3>
                        <div class="card-price-row">
                            <span class="card-price">₹<?= number_format($p['price']) ?></span>
                            <span class="card-price-discount"><?= $p['discount'] ?>% OFF</span>
                        </div>
                        <div class="card-btn-row">
                            <button type="button" class="card-add-cart-btn" onclick="addToCart(<?= $p['id'] ?>, 1)">Add to Cart</button>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 18: WHOLESALE CTA BANNER ════════════ -->
    <section class="home-banner-strip-section">
        <div class="home-section-container">
            <div class="wholesale-promo-banner">
                <div class="wpb-left">
                    <span class="wpb-tag">🏭 DIRECT FACTORY CONTRACTS</span>
                    <h2 class="wpb-title">Grow Your Retail Boutique With Surat Manufacturer Pricing</h2>
                    <ul class="wpb-perks-list">
                        <li>✓ 100% Factory Direct Rates — No Middlemen</li>
                        <li>✓ Full GST Invoices & ITC Credit Supported</li>
                        <li>✓ Doorstep Transport & Courier Delivery Across India</li>
                        <li>✓ Dedicated B2B Relationship Manager</li>
                    </ul>
                </div>
                <div class="wpb-right">
                    <a href="/Frontend/Wholesale/wholesale.php" class="wpb-btn-primary">Explore Wholesale Catalog &rarr;</a>
                    <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20I%20want%20wholesale%20catalog%20and%20rates" target="_blank" class="wpb-btn-secondary">💬 Chat With B2B Manager</a>
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

    <!-- ════════════ SECTION 20: RECOMMENDED FOR YOU ════════════ -->
    <section class="home-section home-section-soft-bg" id="section-recommended">
        <div class="home-section-container">
            <div class="home-section-header">
                <div>
                    <span class="home-section-tag">✨ PERSONALIZED PICKS</span>
                    <h2 class="home-section-title" id="recommendedTitle">Recommended For You</h2>
                </div>
            </div>

            <div class="products-grid" id="recommendedGrid">
                <?php foreach (array_slice($products, 2, 4) as $p): ?>
                <article class="product-card">
                    <div class="card-image-wrap">
                        <a href="../Single-Product/singleproduct.php?id=<?= $p['id'] ?>">
                            <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="card-img" />
                        </a>
                        <span class="card-badge badge-trending">Recommended</span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-name"><a href="../Single-Product/singleproduct.php?id=<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></a></h3>
                        <div class="card-price-row">
                            <span class="card-price">₹<?= number_format($p['price']) ?></span>
                            <span class="card-price-discount"><?= $p['discount'] ?>% OFF</span>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
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
                <button type="button" class="home-section-sub-link" onclick="if(typeof window.clearRecentlyViewed==='function') window.clearRecentlyViewed();">Clear History</button>
            </div>

            <div class="recently-viewed-track" id="recentlyViewedTrack">
                <!-- Dynamically populated from localStorage via JS -->
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 23: HOW RESELLING WORKS ════════════ -->
    <section class="home-section home-section-soft-bg" id="section-how-reselling-works">
        <div class="home-section-container">
            <div class="home-section-header" style="text-align:center; justify-content:center;">
                <div>
                    <span class="home-section-tag">⚡ 4 EASY STEPS</span>
                    <h2 class="home-section-title">How Ethnic Wear Reselling Works</h2>
                    <p class="home-section-desc">Start earning without spending a single rupee on inventory or warehousing.</p>
                </div>
            </div>

            <div class="roadmap-grid">
                <div class="roadmap-step-card">
                    <div class="roadmap-num">01</div>
                    <div class="roadmap-icon">👗</div>
                    <h3 class="roadmap-title">Choose Products</h3>
                    <p class="roadmap-desc">Browse 1000+ ready factory catalog sarees, kurtis & lehengas.</p>
                </div>

                <div class="roadmap-step-card">
                    <div class="roadmap-num">02</div>
                    <div class="roadmap-icon">💰</div>
                    <h3 class="roadmap-title">Add Your Margin</h3>
                    <p class="roadmap-desc">Set your own selling price. For example: Buy at ₹1,399, sell at ₹3,499 (₹2,100 profit).</p>
                </div>

                <div class="roadmap-step-card">
                    <div class="roadmap-num">03</div>
                    <div class="roadmap-icon">📲</div>
                    <h3 class="roadmap-title">Share With Clients</h3>
                    <p class="roadmap-desc">1-tap share high-res photos and descriptions on WhatsApp & Instagram.</p>
                </div>

                <div class="roadmap-step-card">
                    <div class="roadmap-num">04</div>
                    <div class="roadmap-icon">🏦</div>
                    <h3 class="roadmap-title">Earn Direct Profit</h3>
                    <p class="roadmap-desc">We dispatch under your name; your profit is credited directly to your bank account.</p>
                </div>
            </div>

            <div style="text-align:center; margin-top:24px;">
                <a href="/Frontend/Reseller/reseller.php" class="home-btn-gold">Start Reselling Today (Zero Cost) &rarr;</a>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 24: HOW WHOLESALE WORKS ════════════ -->
    <section class="home-section" id="section-how-wholesale-works">
        <div class="home-section-container">
            <div class="home-section-header" style="text-align:center; justify-content:center;">
                <div>
                    <span class="home-section-tag">🏭 B2B BULK WORKFLOW</span>
                    <h2 class="home-section-title">How Wholesale Purchasing Works</h2>
                    <p class="home-section-desc">Streamlined factory supply for retail shop owners across India.</p>
                </div>
            </div>

            <div class="roadmap-grid">
                <div class="roadmap-step-card">
                    <div class="roadmap-num">01</div>
                    <div class="roadmap-icon">📦</div>
                    <h3 class="roadmap-title">Select Products</h3>
                    <p class="roadmap-desc">Explore B2B lots with clear MOQ from 6 to 24 pieces.</p>
                </div>

                <div class="roadmap-step-card">
                    <div class="roadmap-num">02</div>
                    <div class="roadmap-icon">📊</div>
                    <h3 class="roadmap-title">Choose Quantity</h3>
                    <p class="roadmap-desc">Select higher quantities to unlock deeper volume tier slabs.</p>
                </div>

                <div class="roadmap-step-card">
                    <div class="roadmap-num">03</div>
                    <div class="roadmap-icon">🧾</div>
                    <h3 class="roadmap-title">Get Factory Price</h3>
                    <p class="roadmap-desc">Automatic slab discounts and GST input credit breakdown applied.</p>
                </div>

                <div class="roadmap-step-card">
                    <div class="roadmap-num">04</div>
                    <div class="roadmap-icon">🚚</div>
                    <h3 class="roadmap-title">Express Dispatch</h3>
                    <p class="roadmap-desc">Fast transport logistics with real-time tracking to your shop doorstep.</p>
                </div>
            </div>

            <div style="text-align:center; margin-top:24px;">
                <a href="/Frontend/Wholesale/wholesale.php" class="home-btn-gold">Browse Wholesale Lots &rarr;</a>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 25: WHY CHOOSE US (8 VALUE PILLARS) ════════════ -->
    <section class="home-section home-section-soft-bg" id="section-why-choose-us">
        <div class="home-section-container">
            <div class="home-section-header" style="text-align:center; justify-content:center;">
                <div>
                    <span class="home-section-tag">💎 THE DT BRAND PROMISE</span>
                    <h2 class="home-section-title">Why 50,000+ Buyers Trust DT Brand's</h2>
                </div>
            </div>

            <div class="why-us-grid">
                <div class="why-card">
                    <div class="why-icon">💎</div>
                    <h4 class="why-title">100% Heritage Quality</h4>
                    <p class="why-desc">Authentic silk and artisan zari craft tested for colorfastness and durability.</p>
                </div>

                <div class="why-card">
                    <div class="why-icon">🏭</div>
                    <h4 class="why-title">Surat Factory Pricing</h4>
                    <p class="why-desc">Zero middlemen commissions. Direct manufacturer pricing for best margins.</p>
                </div>

                <div class="why-card">
                    <div class="why-icon">🚚</div>
                    <h4 class="why-title">Express Dispatch</h4>
                    <p class="why-desc">98% of orders dispatched within 24 to 48 hours with door-to-door tracking.</p>
                </div>

                <div class="why-card">
                    <div class="why-icon">🔒</div>
                    <h4 class="why-title">100% Secure Payments</h4>
                    <p class="why-desc">UPI, Cards, Netbanking, COD and NEFT/RTGS bank transfers supported.</p>
                </div>

                <div class="why-card">
                    <div class="why-icon">⚡</div>
                    <h4 class="why-title">Reseller Friendly</h4>
                    <p class="why-desc">White-label shipping under your boutique name with unbranded packaging.</p>
                </div>

                <div class="why-card">
                    <div class="why-icon">📦</div>
                    <h4 class="why-title">Wholesale Volume Slabs</h4>
                    <p class="why-desc">Transparent tier discounts from 10 to 100+ pieces with GST invoices.</p>
                </div>

                <div class="why-card">
                    <div class="why-icon">💬</div>
                    <h4 class="why-title">24/7 WhatsApp Support</h4>
                    <p class="why-desc">Instant human support on WhatsApp for orders, tracking, and styling.</p>
                </div>

                <div class="why-card">
                    <div class="why-icon">🔄</div>
                    <h4 class="why-title">7-Day Easy Returns</h4>
                    <p class="why-desc">Hassle-free replacement policy in case of any manufacturing defects.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 26, 27, 28: REVIEWS (CUSTOMERS, RESELLERS, WHOLESALE) ════════════ -->
    <section class="home-section" id="section-reviews">
        <div class="home-section-container">
            <div class="home-section-header">
                <div>
                    <span class="home-section-tag">⭐ VERIFIED BUYER FEEDBACK</span>
                    <h2 class="home-section-title">What Our Customers, Resellers & Wholesalers Say</h2>
                </div>
                <div class="reviews-tab-nav">
                    <button type="button" class="rev-tab-btn active" onclick="if(typeof window.switchReviewTab==='function') window.switchReviewTab('customers');">Retail Buyers</button>
                    <button type="button" class="rev-tab-btn" onclick="if(typeof window.switchReviewTab==='function') window.switchReviewTab('resellers');">Reseller Partners</button>
                    <button type="button" class="rev-tab-btn" onclick="if(typeof window.switchReviewTab==='function') window.switchReviewTab('wholesale');">Wholesale Boutiques</button>
                </div>
            </div>

            <!-- Customer Reviews Tab -->
            <div class="reviews-tab-content active" id="tab-reviews-customers">
                <div class="reviews-grid">
                    <div class="review-card">
                        <div class="rev-stars">★★★★★</div>
                        <p class="rev-text">"Ordered the Nilambari Silk Saree for my cousin's wedding. The zari work and richness of pure silk exceeded my expectations. Delivered in 3 days!"</p>
                        <div class="rev-author-row">
                            <div class="rev-avatar">PS</div>
                            <div>
                                <h5 class="rev-name">Pooja Sharma</h5>
                                <span class="rev-location">📍 Mumbai • Verified Buyer</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="rev-stars">★★★★★</div>
                        <p class="rev-text">"The Bridal Velvet Lehenga is stunning. The zardozi embroidery is heavy and authentic. Exactly as shown in the photos!"</p>
                        <div class="rev-author-row">
                            <div class="rev-avatar">AP</div>
                            <div>
                                <h5 class="rev-name">Ananya Patel</h5>
                                <span class="rev-location">📍 Ahmedabad • Verified Buyer</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="rev-stars">★★★★★</div>
                        <p class="rev-text">"Superb quality cotton kurti set. Very soft fabric and elegant gotapatti lace. Highly recommended for festive wear."</p>
                        <div class="rev-author-row">
                            <div class="rev-avatar">RK</div>
                            <div>
                                <h5 class="rev-name">Ritu Kapoor</h5>
                                <span class="rev-location">📍 Delhi • Verified Buyer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reseller Reviews Tab -->
            <div class="reviews-tab-content" id="tab-reviews-resellers" style="display:none;">
                <div class="reviews-grid">
                    <div class="review-card">
                        <div class="rev-stars">★★★★★</div>
                        <p class="rev-text">"I started reselling DT Brand's sarees on WhatsApp 4 months ago. Last month I earned ₹48,200 pure margin! Customers love the packaging."</p>
                        <div class="rev-author-row">
                            <div class="rev-avatar" style="background:#059669;">SM</div>
                            <div>
                                <h5 class="rev-name">Sunita Mehta</h5>
                                <span class="rev-location">📍 Pune • Reseller Partner (₹48k/mo)</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="rev-stars">★★★★★</div>
                        <p class="rev-text">"1-tap WhatsApp sharing makes it effortless. The photos have no watermarks, so my clients think I stock everything myself."</p>
                        <div class="rev-author-row">
                            <div class="rev-avatar" style="background:#059669;">KG</div>
                            <div>
                                <h5 class="rev-name">Kavita Gupta</h5>
                                <span class="rev-location">📍 Jaipur • Reseller Partner</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wholesale Reviews Tab -->
            <div class="reviews-tab-content" id="tab-reviews-wholesale" style="display:none;">
                <div class="reviews-grid">
                    <div class="review-card">
                        <div class="rev-stars">★★★★★</div>
                        <p class="rev-text">"We order 50–100 pieces monthly for our 3 retail boutiques in Hyderabad. The tiered volume slabs save us over 20% compared to local traders."</p>
                        <div class="rev-author-row">
                            <div class="rev-avatar" style="background:#8A681F;">VR</div>
                            <div>
                                <h5 class="rev-name">Venkatesh Rao</h5>
                                <span class="rev-location">📍 Hyderabad • Boutique Owner</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="rev-stars">★★★★★</div>
                        <p class="rev-text">"Best factory pricing in Surat. GST billing is prompt, and transit delivery by transport is reliable. Great team support."</p>
                        <div class="rev-author-row">
                            <div class="rev-avatar" style="background:#8A681F;">MS</div>
                            <div>
                                <h5 class="rev-name">Mukesh Shah</h5>
                                <span class="rev-location">📍 Surat / Kolkata • Wholesaler</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 29: INSTAGRAM REELS & VIDEO FEED ════════════ -->
    <section class="home-section home-section-soft-bg" id="section-reels">
        <div class="home-section-container">
            <div class="home-section-header">
                <div>
                    <span class="home-section-tag">🎬 REAL PRODUCT VIDEOS</span>
                    <h2 class="home-section-title">Watch Live Draping & Craftsmanship</h2>
                </div>
                <button type="button" class="home-section-sub-link" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal();">Open Full Reels &rarr;</button>
            </div>

            <div class="home-reels-strip">
                <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(0);">
                    <img src="/Frontend/Shop/Asset/images/product1.png" alt="Reel 1" />
                    <div class="reel-play-overlay">
                        <span class="reel-play-icon">▶</span>
                        <span class="reel-views">24.5k views</span>
                    </div>
                    <div class="reel-caption">Pure Kanjivaram Zari Draping</div>
                </div>

                <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(1);">
                    <img src="/Frontend/Shop/Asset/images/product2.png" alt="Reel 2" />
                    <div class="reel-play-overlay">
                        <span class="reel-play-icon">▶</span>
                        <span class="reel-views">18.2k views</span>
                    </div>
                    <div class="reel-caption">Banarasi Meenakari Saree Close-up</div>
                </div>

                <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(2);">
                    <img src="/Frontend/Shop/Asset/images/product6.png" alt="Reel 3" />
                    <div class="reel-play-overlay">
                        <span class="reel-play-icon">▶</span>
                        <span class="reel-views">31.0k views</span>
                    </div>
                    <div class="reel-caption">Royal Bridal Velvet Lehenga Flare</div>
                </div>

                <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(3);">
                    <img src="/Frontend/Shop/Asset/images/product5.png" alt="Reel 4" />
                    <div class="reel-play-overlay">
                        <span class="reel-play-icon">▶</span>
                        <span class="reel-views">15.8k views</span>
                    </div>
                    <div class="reel-caption">Festive Sharara Anarkali Set</div>
                </div>
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

<!-- ════════════ SECTION 31: EXISTING FOOTER PARTIAL ════════════ -->
<?php include_once __DIR__ . '/../Shop/Includes/shopbottomfotoer.php'; ?>

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
