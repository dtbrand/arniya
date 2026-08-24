<?php
/**
 * DT Brand/index.php — Master E-Commerce Home Page
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/ProductCatalog.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$products = ProductCatalog::getAll();
$categoriesDetails = ProductCatalog::getCategoriesWithDetails();
$selectedCategory = 'All';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Shop direct from Surat manufacturers — pure silk sarees, kurtis, lehengas, reseller margins & wholesale lots at DT Brand's." />
    <title>DT Brand's &bull; Jai Hanuman Tex — Premium Handloom Silk & Wholesale Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/assets/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/shop.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/modals.css?v=<?= time() ?>">

    <script>
        window.allProducts = <?= json_encode(array_values($products)) ?>;
        window.allCategories = <?= json_encode($categoriesDetails) ?>;
    </script>
</head>
<body>

    <!-- Master Header with Amazon-Style Search & Attached Gold Subnav -->
    <?php include_once __DIR__ . '/includes/header.php'; ?>

    <main class="dt-home-main">

        <!-- Hero Banner Slider -->
        <section class="dt-hero-slider-wrap">
            <div class="dt-hero-slider dt-hero-luxury-card">
                <div class="dt-hero-slide-track">
                    <div class="dt-hero-slide" onclick="window.location.href='/shop.php';">
                        <div class="dt-hero-content">
                            <span class="dt-hero-tag">✨ SURAT DIRECT MILL WHOLESALE</span>
                            <h1 class="dt-hero-title">Pure Kanjivaram & Banarasi Silk Heritage</h1>
                            <p class="dt-hero-desc">Authentic handloom zari brocades with 100% Silk Mark Certification. Direct factory pricing for retail, resellers, and wholesale.</p>
                            <a href="/shop.php" class="dt-btn-gold">Explore Festive Catalog &rarr;</a>
                        </div>
                        <div class="dt-hero-img-wrap">
                            <img src="/assets/images/product1.png" alt="Pure Silk Saree" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Round Category Rail Carousel -->
        <section class="dt-category-rail-section">
            <div class="dt-category-rail-track" id="dtCatRailTrack">
                <button type="button" class="dt-cat-circle-item active" data-cat="All" onclick="filterByBanner('All')">
                    <div class="dt-cat-circle-ring">
                        <div class="dt-cat-circle-inner">
                            <span class="cat-icon">✦</span>
                        </div>
                    </div>
                    <span class="dt-cat-circle-label">All Designs</span>
                </button>
                <?php foreach ($categoriesDetails as $cat): ?>
                <button type="button" class="dt-cat-circle-item" data-cat="<?= htmlspecialchars($cat['name']) ?>" onclick="filterByBanner('<?= htmlspecialchars(addslashes($cat['name'])) ?>')">
                    <div class="dt-cat-circle-ring">
                        <div class="dt-cat-circle-inner">
                            <img src="<?= htmlspecialchars($cat['image']) ?>" alt="<?= htmlspecialchars($cat['name']) ?>" loading="lazy" />
                        </div>
                    </div>
                    <span class="dt-cat-circle-label"><?= htmlspecialchars($cat['name']) ?></span>
                </button>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- 3-Pillar Wholesale / Reseller / Retail Hub Strip -->
        <section class="dt-hub-pillars-section" style="max-width:1440px; margin:0 auto 24px; padding:0 20px;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:14px;">
                <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:10px; padding:16px; display:flex; align-items:center; gap:14px; box-shadow:0 2px 10px rgba(138,104,31,0.08);">
                    <div style="width:44px; height:44px; border-radius:8px; background:#FAF5E8; display:flex; align-items:center; justify-content:center; font-size:1.4rem;">📦</div>
                    <div>
                        <h4 style="font-size:0.92rem; font-weight:800; color:#111827; margin-bottom:2px;">B2B Wholesale Lots</h4>
                        <p style="font-size:0.75rem; color:#6B7280; margin-bottom:6px;">Direct Surat mill rates with bale discounts.</p>
                        <a href="/wholesale.php" class="dt-btn-pale" style="padding:2px 8px; font-size:0.72rem;">Wholesale Hub &rarr;</a>
                    </div>
                </div>
                <div style="background:#FFFFFF; border:1.5px solid #15803D; border-radius:10px; padding:16px; display:flex; align-items:center; gap:14px; box-shadow:0 2px 10px rgba(21,128,61,0.08);">
                    <div style="width:44px; height:44px; border-radius:8px; background:#DCFCE7; display:flex; align-items:center; justify-content:center; font-size:1.4rem;">💰</div>
                    <div>
                        <h4 style="font-size:0.92rem; font-weight:800; color:#111827; margin-bottom:2px;">Zero-Investment Reselling</h4>
                        <p style="font-size:0.75rem; color:#6B7280; margin-bottom:6px;">Share on WhatsApp, add margins & earn.</p>
                        <a href="/reseller.php" class="dt-btn-pale" style="padding:2px 8px; font-size:0.72rem; border-color:#15803D; color:#15803D;">Reseller Desk &rarr;</a>
                    </div>
                </div>
                <div style="background:#FFFFFF; border:1.5px solid #1D4ED8; border-radius:10px; padding:16px; display:flex; align-items:center; gap:14px; box-shadow:0 2px 10px rgba(29,78,216,0.08);">
                    <div style="width:44px; height:44px; border-radius:8px; background:#EFF6FF; display:flex; align-items:center; justify-content:center; font-size:1.4rem;">✨</div>
                    <div>
                        <h4 style="font-size:0.92rem; font-weight:800; color:#111827; margin-bottom:2px;">Retail Silk Shopping</h4>
                        <p style="font-size:0.75rem; color:#6B7280; margin-bottom:6px;">Single piece order with luxury gift packaging.</p>
                        <a href="/shop.php" class="dt-btn-pale" style="padding:2px 8px; font-size:0.72rem; border-color:#1D4ED8; color:#1D4ED8;">Shop Retail &rarr;</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Product Grid & Interactive Layout -->
        <section class="dt-shop-layout">
            
            <!-- Left Sidebar Filter -->
            <aside class="dt-filter-sidebar">
                <div class="dt-sf-header">
                    <h3 class="dt-sf-title">Filter Collections</h3>
                    <button type="button" class="dt-sf-clear-btn" onclick="clearAllFilters()">Reset</button>
                </div>

                <!-- Fabric Filter -->
                <div class="dt-sf-section">
                    <div class="dt-sf-section-header">Fabric Type</div>
                    <div class="dt-sf-chips">
                        <button type="button" class="dt-sf-chip" data-group="fabric" data-val="Silk">Pure Silk</button>
                        <button type="button" class="dt-sf-chip" data-group="fabric" data-val="Cotton">Mulmul Cotton</button>
                        <button type="button" class="dt-sf-chip" data-group="fabric" data-val="Organza">Glass Organza</button>
                        <button type="button" class="dt-sf-chip" data-group="fabric" data-val="Georgette">Viscose Georgette</button>
                        <button type="button" class="dt-sf-chip" data-group="fabric" data-val="Velvet">Micro Velvet</button>
                    </div>
                </div>

                <!-- Price Slider -->
                <div class="dt-sf-section">
                    <div class="dt-sf-section-header">Maximum Price</div>
                    <div class="dt-price-slider-wrap">
                        <div class="dt-price-display-row">
                            <span>₹500</span>
                            <span id="dtPriceMaxDisplay">₹35,000</span>
                        </div>
                        <input type="range" class="dt-range-input" id="dtPriceRange" min="500" max="35000" step="500" value="35000" />
                    </div>
                </div>

                <!-- Color Swatches -->
                <div class="dt-sf-section">
                    <div class="dt-sf-section-header">Color Palette</div>
                    <div class="dt-sf-swatches">
                        <div class="dt-swatch-pill" data-color="Red"><span class="dt-swatch-dot" style="background:#DC2626;"></span> Red</div>
                        <div class="dt-swatch-pill" data-color="Gold"><span class="dt-swatch-dot" style="background:#D4AF37;"></span> Gold</div>
                        <div class="dt-swatch-pill" data-color="Blue"><span class="dt-swatch-dot" style="background:#1D4ED8;"></span> Blue</div>
                        <div class="dt-swatch-pill" data-color="Green"><span class="dt-swatch-dot" style="background:#15803D;"></span> Green</div>
                        <div class="dt-swatch-pill" data-color="Yellow"><span class="dt-swatch-dot" style="background:#EAB308;"></span> Yellow</div>
                        <div class="dt-swatch-pill" data-color="Wine"><span class="dt-swatch-dot" style="background:#701A75;"></span> Wine</div>
                    </div>
                </div>

            </aside>

            <!-- Products Grid Area -->
            <div class="dt-products-area">
                <div class="dt-products-top-bar">
                    <div class="dt-ptb-count" id="dtPtbCount">Showing <?= count($products) ?> Products</div>
                    <div class="dt-ptb-sort-wrap">
                        <span class="dt-ptb-sort-label">Sort By:</span>
                        <select class="dt-ptb-sort-select" id="dtPtbSortSelect">
                            <option value="recommended">Recommended</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="discount">Highest Discount</option>
                        </select>
                    </div>
                </div>

                <!-- Active Filter Tags Bar -->
                <div class="dt-active-tags-bar" id="dtActiveTagsBar"></div>

                <!-- Master Products Grid -->
                <div class="dt-products-grid" id="dtProductsGrid">
                    <?php foreach ($products as $p): ?>
                    <div class="dt-product-card" 
                        data-id="<?= $p['id'] ?>"
                        data-category="<?= htmlspecialchars($p['category']) ?>"
                        data-fabric="<?= htmlspecialchars($p['fabric'] ?? '') ?>"
                        data-price="<?= $p['price'] ?>"
                        data-colors="<?= htmlspecialchars(implode(',', $p['colors'] ?? [])) ?>"
                        data-sizes="<?= htmlspecialchars(implode(',', $p['size'] ?? [])) ?>"
                        data-title="<?= htmlspecialchars($p['title'] ?? $p['name']) ?>"
                        data-sku="<?= htmlspecialchars($p['sku'] ?? '') ?>"
                        data-discount="<?= $p['discount'] ?? 0 ?>"
                    >
                        <div class="dt-card-img-wrap">
                            <span class="dt-card-badge"><?= htmlspecialchars($p['badge'] ?? 'Bestseller') ?></span>
                            
                            <button type="button" class="dt-card-wishlist-btn" onclick="toggleWishlist(<?= htmlspecialchars(json_encode($p)) ?>)" aria-label="Save to Wishlist">
                                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                            </button>

                            <button type="button" class="dt-card-share-btn" onclick="openSmartShare(<?= $p['id'] ?>)" aria-label="Share on WhatsApp">
                                <svg viewBox="0 0 24 24"><path fill="#15803D" d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg>
                            </button>

                            <span class="dt-card-cat-tag"><?= htmlspecialchars($p['category']) ?></span>

                            <a href="/product.php?id=<?= $p['id'] ?>">
                                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name'] ?? $p['title']) ?>" class="dt-card-img" loading="lazy" />
                            </a>
                        </div>

                        <div class="dt-card-body">
                            <a href="/product.php?id=<?= $p['id'] ?>" class="dt-card-title"><?= htmlspecialchars($p['name'] ?? $p['title']) ?></a>
                            
                            <div class="dt-card-info-row">
                                <span>★ <?= $p['rating'] ?? '4.9' ?> (<?= $p['reviews_count'] ?? 120 ?>)</span>
                                <span>&bull;</span>
                                <span><?= htmlspecialchars($p['fabric'] ?? 'Pure Silk') ?></span>
                            </div>

                            <div class="dt-card-price-row">
                                <span class="dt-card-price">₹<?= number_format($p['price']) ?></span>
                                <?php if (!empty($p['old_price'])): ?>
                                <span class="dt-card-old-price">₹<?= number_format($p['old_price']) ?></span>
                                <span class="dt-card-discount"><?= $p['discount'] ?>% OFF</span>
                                <?php endif; ?>
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px; margin-top:10px;">
                                <button type="button" class="dt-btn-gold" style="padding:6px 8px; font-size:0.75rem;" onclick="addToCart(<?= htmlspecialchars(json_encode($p)) ?>, 1, 'single')">
                                    <span>Add to Bag</span>
                                </button>
                                <button type="button" class="dt-btn-pale" style="padding:6px 8px; font-size:0.75rem;" onclick="openQuickView(<?= $p['id'] ?>)">
                                    <span>Quick View</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </section>

        <!-- Live Video Reels Carousel Section -->
        <section style="max-width:1440px; margin:40px auto; padding:0 20px;">
            <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:18px;">
                <div>
                    <span style="font-size:0.75rem; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.05em;">🎬 REAL DRAPING &amp; WEAVE VIDEOS</span>
                    <h2 style="font-size:1.4rem; font-weight:800; color:#111827; margin:4px 0 0;">Trending Saree Reels</h2>
                </div>
                <a href="/shop.php" class="dt-btn-pale" style="font-size:0.78rem;">View All Catalog &rarr;</a>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:14px;">
                <?php for($r = 1; $r <= 4; $r++): ?>
                <div style="position:relative; border-radius:12px; overflow:hidden; aspect-ratio:9/14; background:#181512; cursor:pointer; box-shadow:0 4px 14px rgba(0,0,0,0.15);" onclick="openReelsModal(<?= $r - 1 ?>)">
                    <img src="/assets/images/product<?= $r ?>.png" alt="Reel Video" style="width:100%; height:100%; object-fit:cover;" />
                    <div style="position:absolute; top:10px; left:10px; background:rgba(0,0,0,0.6); backdrop-filter:blur(6px); color:#FFF; font-size:0.68rem; font-weight:700; padding:3px 8px; border-radius:20px; display:flex; align-items:center; gap:5px;">
                        <span style="width:6px; height:6px; border-radius:50%; background:#DC2626; display:inline-block;"></span> LIVE
                    </div>
                    <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                        <div style="width:48px; height:48px; border-radius:50%; background:rgba(212,175,55,0.9); display:flex; align-items:center; justify-content:center; box-shadow:0 0 16px rgba(212,175,55,0.8);">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="#111827"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                        </div>
                    </div>
                    <div style="position:absolute; bottom:0; inset-inline:0; padding:14px; background:linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 100%); color:#FFF;">
                        <h4 style="font-size:0.85rem; font-weight:700; margin:0 0 2px;">Handloom Pure Silk Saree</h4>
                        <span style="font-size:0.75rem; color:#D4AF37; font-weight:800;">₹4,899 &bull; Quick Order</span>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </section>

        <!-- Verified Customer Reviews Strip -->
        <section style="max-width:1440px; margin:40px auto; padding:0 20px;">
            <div style="background:#FAF8F4; border:1.5px solid #D4AF37; border-radius:14px; padding:28px 24px; box-shadow:0 4px 20px rgba(138,104,31,0.08);">
                <div style="text-align:center; max-width:600px; margin:0 auto 24px;">
                    <span style="font-size:0.75rem; font-weight:800; color:#8A681F; text-transform:uppercase;">⭐ TRUSTED BY 50,000+ CUSTOMERS &amp; RESELLERS</span>
                    <h2 style="font-size:1.35rem; font-weight:800; color:#111827; margin:4px 0 0;">What Our Buyers Say</h2>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
                    <div style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:10px; padding:16px;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                            <strong>Meera Sundaram</strong>
                            <span style="color:#B8860B;">★★★★★</span>
                        </div>
                        <p style="font-size:0.82rem; color:#4B5563; line-height:1.5; margin:0 0 8px;">"The Nilambari Kanjivaram silk saree was absolutely royal! True tested zari with Silk Mark tag. 100% genuine factory price."</p>
                        <span style="font-size:0.72rem; color:#15803D; font-weight:700;">✔ Verified Buyer &bull; Chennai</span>
                    </div>
                    <div style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:10px; padding:16px;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                            <strong>Rajesh Aggarwal</strong>
                            <span style="color:#B8860B;">★★★★★</span>
                        </div>
                        <p style="font-size:0.82rem; color:#4B5563; line-height:1.5; margin:0 0 8px;">"Purchased 12 bales for our Surat textile showroom. Outstanding fabric consistency and fast dispatch within 24 hours."</p>
                        <span style="font-size:0.72rem; color:#15803D; font-weight:700;">✔ Wholesale Partner &bull; Jaipur</span>
                    </div>
                    <div style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:10px; padding:16px;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                            <strong>Shweta Gupta</strong>
                            <span style="color:#B8860B;">★★★★★</span>
                        </div>
                        <p style="font-size:0.82rem; color:#4B5563; line-height:1.5; margin:0 0 8px;">"The 1-click WhatsApp Smart Share tool makes reselling so easy. Already completed 42 orders this festive season!"</p>
                        <span style="font-size:0.72rem; color:#15803D; font-weight:700;">✔ Top Reseller &bull; Delhi</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- WhatsApp Concierge CTA Strip -->
        <section style="max-width:1440px; margin:30px auto 40px; padding:0 20px;">
            <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 100%); border:1.5px solid #D4AF37; border-radius:14px; padding:24px 28px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
                <div>
                    <h3 style="font-size:1.15rem; font-weight:800; color:#FAF5E8; margin:0 0 4px;">Need Saree Styling, Reseller Margin Help, or Bulk Bale Quotes?</h3>
                    <p style="font-size:0.8rem; color:#D1D5DB; margin:0;">Our Surat mill master weavers and wholesale advisors are live on WhatsApp.</p>
                </div>
                <a href="https://wa.me/919876543210?text=Hi%20DT%20Brands,%20I%20need%20assistance%20with%20products%20and%20wholesale%20rates." target="_blank" rel="noopener" class="dt-btn-emerald" style="padding:10px 20px; font-size:0.88rem;">
                    <svg viewBox="0 0 24 24" width="18" height="18"><path fill="#FFF" d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg>
                    <span>Connect on WhatsApp Live</span>
                </a>
            </div>
        </section>

    </main>

    <!-- Master Footer -->
    <?php include_once __DIR__ . '/includes/footer.php'; ?>

    <!-- Mobile Floating Bottom App Bar -->
    <?php include_once __DIR__ . '/includes/mobile_bottom_nav.php'; ?>

    <!-- Shared Modals (Cart, Wishlist, Checkout, Auth, QuickView, SmartShare, Reels) -->
    <?php include_once __DIR__ . '/shared/cart_drawer.php'; ?>
    <?php include_once __DIR__ . '/shared/wishlist_drawer.php'; ?>
    <?php include_once __DIR__ . '/shared/checkout_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/auth_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/quickview_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/smart_share_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/reels_modal.php'; ?>

    <!-- Master Scripts -->
    <script src="/assets/js/core.js?v=<?= time() ?>"></script>
    <script src="/assets/js/header.js?v=<?= time() ?>"></script>
    <script src="/assets/js/shop.js?v=<?= time() ?>"></script>
    <script src="/assets/js/modals.js?v=<?= time() ?>"></script>

</body>
</html>
