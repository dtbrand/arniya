<?php
/**
 * DT Brand/product.php — Master Single Product (PDP) Page
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/ProductCatalog.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$productId = 1;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = (int)$_GET['id'];
} elseif (isset($_GET['slug']) && !empty($_GET['slug'])) {
    $found = ProductCatalog::getBySlug($_GET['slug']);
    if ($found) {
        $productId = (int)$found['id'];
    } elseif (is_numeric($_GET['slug'])) {
        $productId = (int)$_GET['slug'];
    }
} elseif (isset($_SERVER['PATH_INFO']) && !empty($_SERVER['PATH_INFO'])) {
    $seg = trim($_SERVER['PATH_INFO'], '/');
    if (is_numeric($seg)) {
        $productId = (int)$seg;
    } else {
        $found = ProductCatalog::getBySlug($seg);
        if ($found) $productId = (int)$found['id'];
    }
} elseif (isset($_SERVER['REQUEST_URI'])) {
    $uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (preg_match('#product/([0-9]+)#i', $uriPath, $m)) {
        $productId = (int)$m[1];
    } elseif (preg_match('#product/([a-zA-Z0-9_-]+)#i', $uriPath, $m)) {
        $found = ProductCatalog::getBySlug($m[1]);
        if ($found) $productId = (int)$found['id'];
    }
}

$product = ProductCatalog::getById($productId);
if (!$product) {
    $product = ProductCatalog::getById(1);
}

$recommendations = ProductCatalog::getRecommendations($product['id'], 4);
$categoriesDetails = ProductCatalog::getCategoriesWithDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="<?= htmlspecialchars($product['description']) ?>" />
    <title><?= htmlspecialchars($product['name']) ?> &bull; DT Brand's</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/assets/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/shop.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/modals.css?v=<?= time() ?>">

    <style>
        .dt-pdp-layout {
            max-width: 1280px;
            margin: 20px auto 40px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            gap: 36px;
        }
        @media (max-width: 860px) {
            .dt-pdp-layout { grid-template-columns: 1fr; gap: 20px; }
        }
        .dt-pdp-gallery-wrap {
            position: sticky;
            top: 100px;
            height: fit-content;
        }
        .dt-pdp-main-img-card {
            width: 100%;
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .dt-pdp-main-img {
            width: 100%;
            height: auto;
            aspect-ratio: 3/4;
            object-fit: cover;
            display: block;
        }
        .dt-pdp-thumbs {
            display: flex;
            gap: 10px;
            margin-top: 12px;
            overflow-x: auto;
        }
        .dt-pdp-thumb {
            width: 64px;
            height: 80px;
            border-radius: 6px;
            border: 1.5px solid #E5E7EB;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.2s;
        }
        .dt-pdp-thumb.active, .dt-pdp-thumb:hover {
            border-color: #8A681F;
            box-shadow: 0 0 10px rgba(138,104,31,0.3);
        }

        /* Details */
        .dt-pdp-breadcrumb {
            font-size: 0.78rem;
            color: #6B7280;
            margin-bottom: 8px;
        }
        .dt-pdp-breadcrumb a { color: #8A681F; text-decoration: none; font-weight: 600; }
        .dt-pdp-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #111827;
            line-height: 1.25;
            margin-bottom: 8px;
        }
        .dt-pdp-meta-row {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.82rem;
            color: #4B5563;
            margin-bottom: 16px;
        }
        .dt-pdp-price-card {
            background: #FAF8F4;
            border: 1.5px solid #D4AF37;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
        }
        .dt-pdp-price-main {
            display: flex;
            align-items: baseline;
            gap: 10px;
            margin-bottom: 4px;
        }
        .dt-pdp-price { font-size: 1.8rem; font-weight: 800; color: #111827; }
        .dt-pdp-old-price { font-size: 1.1rem; color: #9CA3AF; text-decoration: line-through; }
        .dt-pdp-discount { font-size: 0.85rem; font-weight: 800; color: #15803D; background: #DCFCE7; padding: 2px 8px; border-radius: 4px; }

        /* B2B Lot Pricing Matrix */
        .dt-lot-tier-matrix {
            margin: 16px 0;
        }
        .dt-lot-tier-title {
            font-size: 0.82rem;
            font-weight: 800;
            color: #705114;
            margin-bottom: 8px;
        }
        .dt-lot-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 8px;
        }
        .dt-lot-card {
            background: #FFFFFF;
            border: 1.5px solid #E5E7EB;
            border-radius: 8px;
            padding: 10px 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.15s;
        }
        .dt-lot-card:hover, .dt-lot-card.active {
            border-color: #8A681F;
            background: #FAF5E8;
        }
        .dt-lot-card-name { font-size: 0.76rem; font-weight: 700; color: #111827; }
        .dt-lot-card-price { font-size: 0.95rem; font-weight: 800; color: #8A681F; margin: 2px 0; }
        .dt-lot-card-moq { font-size: 0.68rem; color: #6B7280; }

        /* Actions */
        .dt-pdp-action-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin: 20px 0;
        }
        .dt-pdp-specs-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 0.84rem;
        }
        .dt-pdp-specs-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #E5E7EB;
        }
        .dt-pdp-specs-table td.label {
            font-weight: 700;
            color: #6B7280;
            width: 35%;
            background: #FAF8F4;
        }
    </style>
</head>
<body>

    <!-- Master Header with Amazon-Style Search & Attached Gold Subnav -->
    <?php include_once __DIR__ . '/includes/header.php'; ?>

    <main class="dt-pdp-main">
        <div class="dt-pdp-layout">
            
            <!-- Left: Gallery -->
            <div class="dt-pdp-gallery-wrap">
                <div class="dt-pdp-main-img-card">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" id="dtPdpMainImg" class="dt-pdp-main-img" />
                    <span class="dt-card-badge"><?= htmlspecialchars($product['badge'] ?? 'Bestseller') ?></span>
                </div>
                <div class="dt-pdp-thumbs">
                    <?php 
                    $gallery = !empty($product['gallery']) ? $product['gallery'] : [$product['image']];
                    foreach ($gallery as $gIdx => $gImg): ?>
                    <img src="<?= htmlspecialchars($gImg) ?>" alt="Thumb" class="dt-pdp-thumb <?= $gIdx === 0 ? 'active' : '' ?>" onclick="document.getElementById('dtPdpMainImg').src='<?= htmlspecialchars($gImg) ?>'; document.querySelectorAll('.dt-pdp-thumb').forEach(t=>t.classList.remove('active')); this.classList.add('active');" />
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right: Details & Lot Buying Options -->
            <div class="dt-pdp-details-wrap">
                <div class="dt-pdp-breadcrumb">
                    <a href="/">Home</a> &rsaquo;
                    <a href="/shop.php?category=<?= urlencode($product['category']) ?>"><?= htmlspecialchars($product['category']) ?></a> &rsaquo;
                    <span><?= htmlspecialchars($product['sku']) ?></span>
                </div>

                <h1 class="dt-pdp-title"><?= htmlspecialchars($product['name']) ?></h1>
                
                <div class="dt-pdp-meta-row">
                    <span>SKU: <strong><?= htmlspecialchars($product['sku']) ?></strong></span>
                    <span>&bull;</span>
                    <span>★ <?= $product['rating'] ?? '4.9' ?> (<?= $product['reviews_count'] ?? 142 ?> verified reviews)</span>
                    <span>&bull;</span>
                    <span style="color:#15803D; font-weight:700;">In Stock (<?= $product['stock_qty'] ?? 50 ?> Pcs)</span>
                </div>

                <!-- Price Box -->
                <div class="dt-pdp-price-card">
                    <div class="dt-pdp-price-main">
                        <span class="dt-pdp-price" id="dtPdpPriceDisplay">₹<?= number_format($product['price']) ?></span>
                        <span class="dt-pdp-old-price">₹<?= number_format($product['mrp']) ?></span>
                        <span class="dt-pdp-discount"><?= $product['discount'] ?>% OFF</span>
                    </div>
                    <p style="font-size:0.75rem; color:#6B7280;">Inclusive of 5% GST &bull; Direct Surat Handloom Manufacturer Rate</p>
                </div>

                <!-- B2B Wholesale Lot Tier Matrix -->
                <div class="dt-lot-tier-matrix">
                    <div class="dt-lot-tier-title">📦 CHOOSE ORDER QUANTITY & TIER:</div>
                    <div class="dt-lot-grid">
                        <div class="dt-lot-card active" data-lot="single" data-price="<?= $product['retail_price'] ?>" data-moq="1" onclick="selectPdpLot(this)">
                            <div class="dt-lot-card-name">Single Sample</div>
                            <div class="dt-lot-card-price">₹<?= number_format($product['retail_price']) ?></div>
                            <div class="dt-lot-card-moq">MOQ: 1 Pc</div>
                        </div>
                        <div class="dt-lot-card" data-lot="half_set" data-price="<?= round($product['wholesale_price'] * 1.15) ?>" data-moq="4" onclick="selectPdpLot(this)">
                            <div class="dt-lot-card-name">Half Set (4 Pcs)</div>
                            <div class="dt-lot-card-price">₹<?= number_format(round($product['wholesale_price'] * 1.15)) ?>/pc</div>
                            <div class="dt-lot-card-moq">Wholesale MOQ</div>
                        </div>
                        <div class="dt-lot-card" data-lot="full_set" data-price="<?= $product['wholesale_price'] ?>" data-moq="8" onclick="selectPdpLot(this)">
                            <div class="dt-lot-card-name">Full Set (8 Pcs)</div>
                            <div class="dt-lot-card-price">₹<?= number_format($product['wholesale_price']) ?>/pc</div>
                            <div class="dt-lot-card-moq">Catalog Box</div>
                        </div>
                        <div class="dt-lot-card" data-lot="master_bale" data-price="<?= round($product['wholesale_price'] * 0.90) ?>" data-moq="24" onclick="selectPdpLot(this)">
                            <div class="dt-lot-card-name">Master Bale (24+)</div>
                            <div class="dt-lot-card-price">₹<?= number_format(round($product['wholesale_price'] * 0.90)) ?>/pc</div>
                            <div class="dt-lot-card-moq">Mill Direct</div>
                        </div>
                    </div>
                </div>

                <!-- Quantity Stepper -->
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:16px;">
                    <span style="font-size:0.82rem; font-weight:700; color:#1F2937;">Quantity:</span>
                    <div class="dt-qty-stepper">
                        <button type="button" onclick="adjustPdpQty(-1)">−</button>
                        <input type="number" id="dtPdpQtyInput" value="1" min="1" readonly />
                        <button type="button" onclick="adjustPdpQty(1)">+</button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="dt-pdp-action-grid">
                    <button type="button" class="dt-btn-gold" style="height:44px; font-size:0.9rem;" onclick="addPdpToCart()">
                        <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>Add to Bag</span>
                    </button>
                    <button type="button" class="dt-btn-dark" style="height:44px; font-size:0.9rem;" onclick="buyNowPdp()">
                        <span>⚡ Instant Checkout</span>
                    </button>
                </div>

                <!-- WhatsApp Enquiry & Smart Share -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:24px;">
                    <a href="https://wa.me/919876543210?text=Hi%20DT%20Brands,%20I%20am%20enquiring%20about%20<?= urlencode($product['name']) ?>%20(SKU:%20<?= urlencode($product['sku']) ?>)" target="_blank" rel="noopener" class="dt-btn-emerald">
                        <svg viewBox="0 0 24 24"><path fill="#FFF" d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg>
                        <span>WhatsApp Enquiry</span>
                    </a>
                    <button type="button" class="dt-btn-pale" onclick="openSmartShare(<?= $product['id'] ?>)">
                        <span>💬 WhatsApp Smart Share</span>
                    </button>
                </div>

                <!-- Product Specifications Table -->
                <h3 style="font-size:1rem; font-weight:800; color:#111827; margin-bottom:8px;">Handloom Specifications</h3>
                <table class="dt-pdp-specs-table">
                    <tr><td class="label">Fabric</td><td><?= htmlspecialchars($product['fabric'] ?? 'Pure Mulberry Silk') ?></td></tr>
                    <tr><td class="label">Weave Type</td><td><?= htmlspecialchars($product['weave'] ?? 'Handloom Korvai Weave') ?></td></tr>
                    <tr><td class="label">Zari Type</td><td>Tested Real Gold / Silver Zari</td></tr>
                    <tr><td class="label">Blouse Piece</td><td>Running Blouse Piece Included (0.80 Mtr)</td></tr>
                    <tr><td class="label">Length</td><td>6.30 Meters (With Blouse)</td></tr>
                    <tr><td class="label">Care Instructions</td><td>Strictly Dry Clean Only</td></tr>
                </table>

                <p style="font-size:0.85rem; color:#4B5563; line-height:1.6; margin-bottom:24px;">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                </p>

            </div>

        </div>

        <!-- Matching Recommendations -->
        <section style="max-width:1280px; margin:40px auto; padding:0 20px;">
            <h3 style="font-size:1.3rem; font-weight:800; color:#111827; margin-bottom:16px;">You May Also Love</h3>
            <div class="dt-products-grid">
                <?php foreach ($recommendations as $rec): ?>
                <div class="dt-product-card">
                    <div class="dt-card-img-wrap">
                        <span class="dt-card-badge"><?= htmlspecialchars($rec['badge'] ?? 'Bestseller') ?></span>
                        <a href="/product.php?id=<?= $rec['id'] ?>">
                            <img src="<?= htmlspecialchars($rec['image']) ?>" alt="<?= htmlspecialchars($rec['name']) ?>" class="dt-card-img" />
                        </a>
                    </div>
                    <div class="dt-card-body">
                        <a href="/product.php?id=<?= $rec['id'] ?>" class="dt-card-title"><?= htmlspecialchars($rec['name']) ?></a>
                        <div class="dt-card-price-row">
                            <span class="dt-card-price">₹<?= number_format($rec['price']) ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
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
    <script src="/assets/js/modals.js?v=<?= time() ?>"></script>

    <script>
        var currentPdpProduct = <?= json_encode($product) ?>;
        var currentPdpLot = 'single';
        var currentPdpMoq = 1;
        var currentPdpPrice = Number(currentPdpProduct.price);

        function selectPdpLot(card) {
            document.querySelectorAll('.dt-lot-card').forEach(function(c) { c.classList.remove('active'); });
            card.classList.add('active');
            currentPdpLot = card.dataset.lot;
            currentPdpMoq = Number(card.dataset.moq || 1);
            currentPdpPrice = Number(card.dataset.price || currentPdpProduct.price);

            var disp = document.getElementById('dtPdpPriceDisplay');
            if (disp) disp.textContent = '₹' + currentPdpPrice.toLocaleString('en-IN');

            var qtyInput = document.getElementById('dtPdpQtyInput');
            if (qtyInput) qtyInput.value = currentPdpMoq;
        }

        function adjustPdpQty(change) {
            var input = document.getElementById('dtPdpQtyInput');
            if (!input) return;
            var val = Math.max(currentPdpMoq, Number(input.value) + change);
            input.value = val;
        }

        function addPdpToCart() {
            var input = document.getElementById('dtPdpQtyInput');
            var q = input ? Number(input.value) : 1;
            var prodCopy = Object.assign({}, currentPdpProduct, { price: currentPdpPrice });
            window.addToCart(prodCopy, q, currentPdpLot);
            window.openCartDrawer();
        }

        function buyNowPdp() {
            addPdpToCart();
            window.openCheckoutModal();
        }
    </script>

</body>
</html>
