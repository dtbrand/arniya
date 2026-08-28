<?php
/**
 * singleproduct.php — Dedicated Luxury Single Product Page (PDP)
 * Fully responsive on Mobile and Desktop with touch-swipe gallery,
 * Size Chart Modal, Pincode Estimator, WhatsApp Order, and Cart Integration.
 */

require_once __DIR__ . '/src/ProductCatalog.php';
require_once __DIR__ . '/src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

// ── Dynamic Database-First PDP Catalog Loader ──
$catalogProducts = ProductCatalog::getAll();
$products = [];
foreach ($catalogProducts as $cp) {
    $products[$cp['id']] = $cp;
}
// DT_MARK_PDP_HEAD

// ── Resolve the requested product: SKU, slug or numeric id ──
$pidParam  = isset($_GET['id']) ? trim((string)$_GET['id']) : '';
$slugParam = isset($_GET['slug']) ? trim((string)$_GET['slug']) : '';
$skuParam  = isset($_GET['sku']) ? trim((string)$_GET['sku']) : '';

$product = null;
if ($skuParam !== '') {
    $product = ProductCatalog::getBySku($skuParam);
}
if (!$product && $slugParam !== '') {
    $product = ProductCatalog::getBySlug($slugParam);
}
if (!$product && ctype_digit($pidParam)) {
    $product = ProductCatalog::getById((int)$pidParam);
}

// An unknown id used to fall through to `reset($products)`, so /product.php?id=9999
// rendered the first product's photos, price and SKU under the requested URL,
// and a request that reached an empty catalogue rendered one of eight sarees
// hardcoded in this file that no order could ever be fulfilled from.
if (!$product) {
    http_response_code(404);
    $pdpAlternatives = array_slice(array_values($catalogProducts), 0, 4);
    require __DIR__ . '/includes/product-not-found.php';
    exit;
}
// ── Normalised scalars. mapRow() returns '' / [] for anything the mill has not
// filled in, never a missing key, so `?? 'Pure Silk'`-style defaults could not
require_once __DIR__ . '/src/Auth.php';
$pdpUser = \DTBrand\Auth::getCurrentUser();
$pdpUserRole = strtolower(trim((string)($pdpUser['type'] ?? 'guest')));
if ($pdpUserRole === '' || $pdpUserRole === 'customer') { $pdpUserRole = 'retail'; }
if (!in_array($pdpUserRole, ['retail', 'wholesale', 'reseller', 'retailer'], true)) {
    $pdpUserRole = 'retail';
}
$isTradeRole = in_array($pdpUserRole, ['wholesale', 'retailer'], true);

$pSellingType = $product['selling_type'] ?? 'single_piece';
$isFullSetProduct = ($pSellingType === 'full_set');

$pSaleDisc = (float)($product['sale_discount'] ?? ($product['sale_price'] ?? 0));

// Role-based price resolution
if ($pSellingType === 'single_piece') {
    if ($pdpUserRole === 'reseller') {
        $pBasePrice = (float)($product['reseller_price'] ?? $product['retail_price']);
    } elseif ($pdpUserRole === 'wholesale') {
        $pBasePrice = (float)($product['wholesale_price'] ?? $product['retail_price']);
    } elseif ($pdpUserRole === 'retailer') {
        $pBasePrice = (float)($product['retail_price'] ?? $product['price']);
    } else { // Guest or Retail Customer
        $pBasePrice = (float)($product['customer_price'] ?? $product['retail_price'] ?? $product['price']);
    }
} else { // Full Set
    $pBasePrice = (float)($product['wholesale_price'] ?? $product['retail_price'] ?? $product['price']);
}

$pPrice = max(0, $pBasePrice - $pSaleDisc);

$pName        = $product['name'] !== '' ? $product['name'] : ($product['sku'] !== '' ? $product['sku'] : 'Untitled product');
$pSku         = (string)$product['sku'];
$pCategory    = (string)$product['category'];
$pFabric      = (string)$product['fabric'];
$pDescription = (string)$product['description'];
$pMrp         = ($pSaleDisc > 0) ? $pBasePrice : (float)$product['old_price'];
$pDiscount    = ($pMrp > $pPrice && $pPrice > 0) ? (int)round((($pMrp - $pPrice) / $pMrp) * 100) : 0;
$pRating      = (float)$product['rating'];
$pReviewCount = (int)$product['reviews_count'];
$pStockQty    = (int)$product['stock_qty'];
$pInStock     = !empty($product['in_stock']);
$pColors      = array_values(array_filter(array_map('strval', (array)$product['colors']), static fn($c) => trim($c) !== ''));
$pSizes       = array_values(array_filter(array_map('strval', (array)$product['size']), static fn($s) => trim($s) !== ''));
$pdpNoImage   = ProductCatalog::NO_IMAGE;

$fullSetPieces = max(1, (int)($product['full_set_pieces'] ?? count($product['variants'] ?? [])));
$fullSetTotalRate = round($pPrice * $fullSetPieces, 2);

// ── Gallery media: pure high-res photos for slider & thumbnails ──
$pdpImages = [];
foreach ((array)$product['images'] as $mImg) {
    $mImg = trim((string)$mImg);
    if ($mImg !== '' && $mImg !== $pdpNoImage) {
        $pdpImages[] = $mImg;
    }
}
if ($pdpImages === [] && !empty($product['image']) && $product['image'] !== $pdpNoImage) {
    $pdpImages[] = $product['image'];
}
$pdpPoster = $pdpImages !== [] ? $pdpImages[0] : $pdpNoImage;

// ── Product Videos & Embeds for 3D HD Video Reel Trigger ──
$pdpVideos = [];
foreach ((array)$product['videos'] as $mVid) {
    $mVid = trim((string)$mVid);
    if ($mVid !== '') {
        $pdpVideos[] = ['kind' => 'video', 'src' => $mVid];
    }
}
if ($pdpVideos === [] && !empty($product['video'])) {
    $pdpVideos[] = ['kind' => 'video', 'src' => trim((string)$product['video'])];
}
foreach ((array)$product['embeds'] as $mEmb) {
    $mEmb = trim((string)$mEmb);
    if ($mEmb !== '') {
        $pdpVideos[] = ['kind' => 'embed', 'src' => $mEmb];
    }
}
if ($pdpVideos === [] && !empty($product['embed'])) {
    $pdpVideos[] = ['kind' => 'embed', 'src' => trim((string)$product['embed'])];
}
$pdpHasVideos = $pdpVideos !== [];
$pdpVideoCount = count($pdpVideos);
$pdpHasMedia = $pdpImages !== [];
// ── Specifications: every row comes from a column the mill filled in ──
// This block used to assert 'Matching Silk Blouse Piece Included', 'Pure Tested
// Gold Zari Jacquard', 'Dry Clean Only' and '1 Piece (With Silk Mark
// Certification)' for every product in the catalogue, including cotton ones.
$currentSpecs = [];
$specCandidates = [
    'Category'      => $pCategory,
    'Fabric'        => $pFabric,
    'Weave / Craft' => (string)$product['weave'],
    'Zari'          => (string)$product['zari_type'],
    'Pallu'         => (string)$product['pallu_style'],
    'Blouse Piece'  => (string)$product['blouse_piece'],
    'Occasion'      => (string)$product['occasion'],
    'Colours'       => implode(', ', $pColors),
    'Sizes'         => implode(', ', $pSizes),
    'SKU'           => $pSku
];
foreach ($specCandidates as $specTitle => $specVal) {
    $specVal = trim((string)$specVal);
    if ($specVal !== '') {
        $currentSpecs[] = ['title' => $specTitle, 'val' => $specVal];
    }
}
$currentSpecs[] = [
    'title' => 'Availability',
    'val'   => $pInStock ? ($pStockQty > 0 ? $pStockQty . ' in stock' : 'In stock') : 'Out of stock'
];

// ── Accordion detail lists, built from the same real values ──
$currentDetails = ['design_lines' => [], 'size_fit' => [], 'material_care' => []];
if ($pDescription !== '') {
    $currentDetails['design_lines'][] = $pDescription;
}
foreach ([
    'Fabric'       => $pFabric,
    'Weave'        => (string)$product['weave'],
    'Zari'         => (string)$product['zari_type'],
    'Pallu'        => (string)$product['pallu_style'],
    'Blouse piece' => (string)$product['blouse_piece'],
    'Occasion'     => (string)$product['occasion']
] as $dLabel => $dVal) {
    $dVal = trim((string)$dVal);
    if ($dVal !== '') {
        $currentDetails['design_lines'][] = $dLabel . ': ' . $dVal;
        if ($dLabel === 'Fabric') {
            $currentDetails['material_care'][] = 'Fabric: ' . $dVal;
        }
    }
}
if ($pSizes !== []) {
    $currentDetails['size_fit'][] = 'Available sizes: ' . implode(', ', $pSizes);
}
if ($pColors !== []) {
    $currentDetails['size_fit'][] = 'Available colours: ' . implode(', ', $pColors);
}
$currentDetails = array_filter($currentDetails, static fn($lines) => $lines !== []);
// ── Reviews: the approved rows this product actually has ──
// Seven reviews used to be hardcoded above -- named shoppers, named cities,
// "2 days ago", helpful counts -- and were printed on every product page in the
// catalogue, including products nobody had bought. The reviews table is the
// only source, and it holds no city, occasion, photo or helpful count.
$customerReviews  = ProductCatalog::getReviews((int)$product['id'], 24);
$reviewBreakdown  = ProductCatalog::reviewBreakdown((int)$product['id']);
$reviewTotal      = array_sum($reviewBreakdown);

// ── Colour swatches come from the palette the admin picked hexes in ──
$pdpSwatch = static function (string $name): string {
    return ProductCatalog::colorHex($name);
};

// Storefront WhatsApp number. Every surface in this project - storefront,
// admin, invoices and seed data - now carries this one number, set by the owner.
// Change it here and the PDP, quick-view and share sheets all follow.
$pdpWaNumber = '917046363528';

// ── Related products: real catalogue rows, never this product ──
$relatedItems = array_values(array_filter(
    $catalogProducts,
    static fn($it) => (int)($it['id'] ?? 0) !== (int)$product['id']
));
$relatedItems = array_slice($relatedItems, 0, 12);

/** "3 days ago" for a reviews.created_at timestamp. */
function pdp_relative_date(string $ts): string
{
    $when = strtotime($ts);
    if ($when === false || $when <= 0) {
        return '';
    }
    $mins = max(1, (int)floor((time() - $when) / 60));
    if ($mins < 60)          { return $mins . ($mins === 1 ? ' minute ago' : ' minutes ago'); }
    $hours = (int)floor($mins / 60);
    if ($hours < 24)         { return $hours . ($hours === 1 ? ' hour ago' : ' hours ago'); }
    $days = (int)floor($hours / 24);
    if ($days < 7)           { return $days . ($days === 1 ? ' day ago' : ' days ago'); }
    if ($days < 31)          { $w = (int)floor($days / 7); return $w . ($w === 1 ? ' week ago' : ' weeks ago'); }
    if ($days < 365)         { $m = (int)floor($days / 30); return $m . ($m === 1 ? ' month ago' : ' months ago'); }
    $y = (int)floor($days / 365);
    return $y . ($y === 1 ? ' year ago' : ' years ago');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?= htmlspecialchars($pName) ?> — DT Brand's | Ethnic Luxury</title>
<meta name="description" content="<?= htmlspecialchars($pDescription !== '' ? mb_substr($pDescription, 0, 160) : trim($pName . ' — ' . $pCategory, ' —')) ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

<link rel="stylesheet" href="/assets/css/singleproduct.css?v=1787020000">

    <!-- ════════════ GLOBAL PRODUCTS & MODAL ENGINE BOOTSTRAP ════════════ -->
    <script>
        window.allProducts = <?php echo json_encode($catalogProducts, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
        window.catalogProducts = window.allProducts;
        window.products = window.allProducts;
        window.openQuickView = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
        window.openQuickViewModal = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
    </script>
</head>
<body>

<!-- ════════════ HEADER PARTIAL ════════════ -->
<?php include_once __DIR__ . '/includes/singelproduthader.php'; ?>

<!-- ════════════ MAIN PRODUCT DETAIL CONTENT ════════════ -->
<main class="pdp-main-wrapper">
    <div class="pdp-layout-grid">
        
        <!-- ── Left: Interactive Swipeable Gallery ── -->
        <div class="pdp-gallery-column">
            <div class="pdp-gallery-slider" id="pdpGallerySlider">
                <?php if (!empty($product['badge'])): ?>
                <span class="pdp-badge-tag"><?= htmlspecialchars($product['badge']) ?></span>
                <?php endif; ?>

                <button class="pdp-zoom-btn" title="View Fullscreen Image" onclick="openFullscreenImage()">
                    <svg viewBox="0 0 24 24"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
                </button>

                <!-- Navigation Arrows (Desktop) -->
                <button class="pdp-slider-arrow prev" id="pdpSlidePrev" aria-label="Previous image" onclick="slidePdpGallery(-1)">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <button class="pdp-slider-arrow next" id="pdpSlideNext" aria-label="Next image" onclick="slidePdpGallery(1)">
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </button>

                <!-- Swipeable Track (Pure Photos Only) -->
                <div class="pdp-slider-track" id="pdpSliderTrack">
                    <?php if (!$pdpHasMedia): ?>
                    <div class="pdp-slide pdp-slide-empty" data-idx="0">
                        <img src="<?= htmlspecialchars($pdpNoImage) ?>" alt="" style="opacity:.45;" />
                        <span class="pdp-empty-media-note">No photo has been uploaded for this product yet.</span>
                    </div>
                    <?php else: ?>
                    <?php foreach ($pdpImages as $index => $imgSrc): ?>
                    <div class="pdp-slide" data-idx="<?= $index ?>">
                        <img
                            src="<?= htmlspecialchars($imgSrc) ?>"
                            alt="<?= htmlspecialchars($pName) ?> - View <?= $index + 1 ?>"
                        />
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- 3D Luxury HD Video / Reels Animated Floating Trigger (Bottom-Left Corner) -->
                <?php if ($pdpHasVideos): ?>
                <button type="button" class="pdp-3d-reel-btn" id="pdp3dVideoBtn" onclick="openProductVideosReel(window.currentProductData || <?= htmlspecialchars(json_encode($product, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP), ENT_QUOTES, 'UTF-8') ?>)" aria-label="Watch HD Video Reels">
                    <div class="pdp-3d-radar-ring ring-1"></div>
                    <div class="pdp-3d-radar-ring ring-2"></div>
                    <div class="pdp-3d-btn-capsule">
                        <div class="pdp-3d-icon-disc">
                            <svg viewBox="0 0 24 24" class="pdp-3d-reel-svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <polygon points="10 8 16 12 10 16 10 8" fill="#111827" stroke="none"></polygon>
                            </svg>
                        </div>
                        <div class="pdp-3d-label-box">
                            <div class="pdp-3d-top-line">
                                <span class="pdp-3d-live-dot"></span>
                                <span class="pdp-3d-badge-tag">HD REELS</span>
                                <?php if ($pdpVideoCount > 1): ?>
                                <span class="pdp-3d-count-pill"><?= $pdpVideoCount ?> Videos</span>
                                <?php endif; ?>
                            </div>
                            <div class="pdp-3d-action-text">
                                <span>360° Drape Video</span>
                                <svg viewBox="0 0 24 24" class="pdp-3d-arrow-svg"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </div>
                </button>
                <?php endif; ?>

                <!-- Slide Index Counter -->
                <div class="pdp-slide-counter" id="pdpSlideCounter">1 / <?= max(1, count($pdpImages)) ?></div>
            </div>

            <!-- Mobile & Desktop Pagination Dots -->
            <div class="pdp-gallery-dots" id="pdpGalleryDots"></div>

            <!-- Multi-Photo Thumbnails (Photos Only) -->
            <?php if (count($pdpImages) > 1): ?>
            <div class="pdp-thumbnails-strip" id="pdpThumbnailsStrip">
                <?php foreach ($pdpImages as $index => $imgSrc): ?>
                <div class="pdp-thumb-item <?= $index === 0 ? 'active' : '' ?>" data-idx="<?= $index ?>" onclick="goToSlide(<?= $index ?>)">
                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Thumb <?= $index + 1 ?>" />
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- ── Right: Product Details & Conversion Actions ── -->
        <div class="pdp-details-column">
            <div>
                <span class="pdp-brand-tag">DT BRAND'S ETHNIC LUXURY</span>
                <h1 class="pdp-title"><?= htmlspecialchars($pName) ?></h1>
            </div>

            <!-- Rating Row — the pill and the count only appear when approved reviews exist.
                 This row used to print a star score and "N Verified Reviews" for every
                 product, including ones nobody has reviewed. -->
            <div class="pdp-rating-row">
                <?php if ($pReviewCount > 0 && $pRating > 0): ?>
                <div class="pdp-rating-pill">
                    <span>★ <?= number_format($pRating, 1) ?></span>
                </div>
                <span class="pdp-review-count"><?= (int)$pReviewCount ?> Verified Review<?= $pReviewCount === 1 ? '' : 's' ?></span>
                <?php else: ?>
                <span class="pdp-review-count">No reviews yet</span>
                <?php endif; ?>
                <?php if ($pSku !== ''): ?>
                <span class="pdp-sku-badge">SKU: <?= htmlspecialchars($pSku) ?></span>
                <?php endif; ?>
            </div>

            <!-- Price Card (Next-Level Luxury & Clear Visibility) -->
            <div class="pdp-price-card">
                <div class="pdp-price-main-row">
                    <?php if ($pPrice > 0): ?>
                    <span class="pdp-price-val">₹<?= number_format($pPrice) ?></span>
                    <?php if ($isFullSetProduct): ?>
                    <span style="font-size:0.85rem; font-weight:700; color:#8A681F; margin-left:4px;">/ pc</span>
                    <span style="font-size:0.92rem; font-weight:800; color:#181512; background:#FAF5E8; border:1px solid #D4AF37; padding:2px 8px; border-radius:4px; margin-left:8px;">₹<?= number_format($fullSetTotalRate) ?> / Set (<?= $fullSetPieces ?> pcs)</span>
                    <?php endif; ?>
                    <?php else: ?>
                    <span class="pdp-price-val">Price on request</span>
                    <?php endif; ?>
                    <?php if ($pMrp > $pPrice && $pPrice > 0 && !$isFullSetProduct): ?>
                    <span class="pdp-mrp-val">MRP ₹<?= number_format($pMrp) ?></span>
                    <?php endif; ?>
                    <?php if ($pSaleDisc > 0 && !$isFullSetProduct): ?>
                    <span class="pdp-discount-badge" style="background:#FEF3C7; color:#B45309; font-weight:800;">SAVE ₹<?= (int)$pSaleDisc ?></span>
                    <?php elseif ($pDiscount > 0 && $pMrp > $pPrice && !$isFullSetProduct): ?>
                    <span class="pdp-discount-badge"><?= (int)$pDiscount ?>% OFF</span>
                    <?php endif; ?>
                </div>
                <div class="pdp-tax-line">
                    <span>Inclusive of all taxes</span> • <span class="green">⚡ Fast Delivery in 3–5 Days</span>
                </div>
                <!-- Animated Luxury Perks Strip. -->
                <div class="pdp-animated-perks-strip">
                    <?php if ($pFabric !== ''): ?>
                    <div class="pdp-perk-badge">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg pulse" fill="currentColor"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
                        <span class="pdp-perk-text"><?= htmlspecialchars($pFabric) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="pdp-perk-badge">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg flash" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        <span class="pdp-perk-text">Fast 24-48h Dispatch</span>
                    </div>
                    <div class="pdp-perk-badge">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg spin" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                        <span class="pdp-perk-text">7-Day Easy Exchange</span>
                    </div>
                    <div class="pdp-perk-badge">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="8" width="18" height="13" rx="2"/><path d="M12 8v13"/><path d="M19 12H5"/><path d="M12 3a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3z"/></svg>
                        <span class="pdp-perk-text">Royal Gift Packaging</span>
                    </div>
                </div>
            </div>

            <?php if ($isFullSetProduct): ?>
                <?php if (!$isTradeRole): ?>
                <!-- B2B Wholesale Exclusive Lock Card for Guest / Customer / Reseller -->
                <div class="pdp-fullset-lock-card" style="background:#FAF8F2; border:1.5px solid #D4AF37; border-radius:10px; padding:16px 18px; margin:14px 0;">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                        <span style="font-size:18px;">👑</span>
                        <strong style="font-size:13px; color:#5A4210; text-transform:uppercase; letter-spacing:0.5px;">B2B Trade Full Set Exclusive</strong>
                    </div>
                    <p style="font-size:12px; color:#64748B; margin:0 0 12px; line-height:1.5;">
                        This product is sold as a Complete Catalog Set (<?= $fullSetPieces ?> pieces) exclusively to verified <strong>Retailers &amp; Wholesalers</strong>. Retail customer purchasing is not available for full sets.
                    </p>
                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        <a href="/account?tab=b2b_apply" class="dt-btn-gold" style="padding:7px 16px; font-size:12px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                            <span>Apply for Wholesale Account</span> &rarr;
                        </a>
                        <a href="/account" class="dt-btn-pale" style="padding:7px 16px; font-size:12px; text-decoration:none;">Sign In as Trade Partner</a>
                    </div>
                </div>
                <?php else: ?>
                <!-- Full Set Trade Breakdown Card for Retailer / Wholesaler -->
                <div class="pdp-fullset-trade-card" style="background:linear-gradient(135deg, #181512 0%, #2A241E 100%); border:1.5px solid #D4AF37; border-radius:10px; padding:16px 18px; color:#FAF5E8; margin:14px 0; box-shadow:0 4px 16px rgba(0,0,0,0.25);">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; border-bottom:1px solid rgba(212,175,55,0.35); padding-bottom:10px; margin-bottom:10px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#D4AF37" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                            <strong style="font-size:13px; color:#FFE57F; letter-spacing:0.5px;">FULL SET INCLUSIONS (<?= $fullSetPieces ?> PIECES)</strong>
                        </div>
                        <span class="adm-badge gold" style="font-size:11px; padding:3px 10px;"><?= count($pColors) ?> Colors &bull; <?= $fullSetPieces ?> Pieces Total</span>
                    </div>
                    <div style="font-size:11px; color:#D6D3D1; margin-bottom:10px;">
                        The Full Set bundle contains all <?= $fullSetPieces ?> configured Color &times; Size combinations. Set rate: <strong>₹<?= number_format($fullSetTotalRate) ?></strong> (₹<?= number_format($pPrice) ?> / piece):
                    </div>
                    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(180px, 1fr)); gap:6px; max-height:140px; overflow-y:auto; padding-right:4px;">
                        <?php foreach ($product['full_set_variants'] ?? $product['variants'] as $fsv): ?>
                        <div style="display:flex; align-items:center; gap:6px; background:rgba(255,255,255,0.06); border:1px solid rgba(212,175,55,0.25); border-radius:4px; padding:4px 8px; font-size:11px;">
                            <span style="color:#22C55E; font-weight:800;">✓</span>
                            <span style="width:8px; height:8px; border-radius:50%; background:<?= htmlspecialchars($pdpSwatch($fsv['color'] ?? '')) ?>; display:inline-block; border:1px solid #fff;"></span>
                            <strong style="color:#FAF5E8;"><?= htmlspecialchars($fsv['color'] ?? 'Standard') ?></strong>
                            <span style="color:#D4AF37;">/</span>
                            <span style="color:#D6D3D1;"><?= htmlspecialchars($fsv['size'] ?? 'Standard') ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <!-- Single Piece Mode: Colour Swatches -->
                <?php if ($pColors !== []): ?>
                <div>
                    <div class="pdp-section-header">
                        <span>SELECT COLOUR: <strong class="pdp-selected-txt" id="pdpSelectedColorName"><?= htmlspecialchars($pColors[0]) ?></strong></span>
                    </div>
                    <div class="pdp-color-swatches" id="pdpColorSwatches">
                        <?php foreach ($pColors as $idx => $c): ?>
                        <button
                            class="pdp-color-btn <?= $idx === 0 ? 'active' : '' ?>"
                            data-color="<?= htmlspecialchars($c) ?>"
                            style="background-color: <?= htmlspecialchars($pdpSwatch($c)) ?>;"
                            title="<?= htmlspecialchars($c) ?>"
                            onclick="selectPdpColor(this)"
                        ></button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Single Piece Mode: Size Selector -->
                <?php if ($pSizes !== []): ?>
                <div>
                    <div class="pdp-section-header">
                        <span>SELECT SIZE</span>
                        <span class="pdp-size-guide-link" onclick="openSizeGuideModal()">📏 View Size Chart</span>
                    </div>
                    <div class="pdp-size-grid" id="pdpSizeGrid">
                        <?php foreach ($pSizes as $idx => $s): ?>
                        <button class="pdp-size-btn <?= $idx === 0 ? 'active' : '' ?>" data-size="<?= htmlspecialchars($s) ?>" onclick="selectPdpSize(this)">
                            <?= htmlspecialchars($s) ?>
                        </button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Actions (Quantity, Add to Bag, Buy Now) -->
            <div class="pdp-actions-container">
                <?php if ($isFullSetProduct && !$isTradeRole): ?>
                <div style="font-size:11.5px; color:#64748B; font-weight:600; text-align:center; padding:6px 0;">
                    To order this Full Set catalog, please sign in with an approved trade account.
                </div>
                <?php elseif (!$pInStock): ?>
                <div class="pdp-oos-note" style="background:#FEF2F2; border:1px solid #FECACA; color:#991B1B; border-radius:10px; padding:12px 14px; font-size:0.82rem; font-weight:600; line-height:1.5;">
                    This product is out of stock. Message us on WhatsApp and we will tell you when it is back, or suggest the closest piece we have.
                </div>
                <a class="pdp-wa-order-btn" style="text-decoration:none;" target="_blank" rel="noopener"
                   href="https://api.whatsapp.com/send?phone=<?= rawurlencode($pdpWaNumber) ?>&amp;text=<?= rawurlencode('Hi, is ' . $pName . ($pSku !== '' ? ' (SKU: ' . $pSku . ')' : '') . ' coming back in stock?') ?>">
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    <span>Ask about restock on WhatsApp</span>
                </a>
                <?php else: ?>
                <div class="pdp-qty-row">
                    <span style="font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.06em;">
                        <?= $isFullSetProduct ? 'Quantity (Sets):' : 'Quantity:' ?>
                    </span>
                    <div class="pdp-qty-box">
                        <button class="pdp-qty-btn" onclick="updatePdpQty(-1)">−</button>
                        <span class="pdp-qty-num" id="pdpQtyVal">1</span>
                        <button class="pdp-qty-btn" onclick="updatePdpQty(1)">+</button>
                    </div>
                    <?php if ($isFullSetProduct): ?>
                    <span style="font-size:0.72rem; font-weight:700; color:#8A681F;" id="pdpTotalPiecesBadge"><?= $fullSetPieces ?> physical pieces</span>
                    <?php elseif ($pStockQty > 0): ?>
                    <span style="font-size:0.72rem; font-weight:700; color:#15803D;"><?= (int)$pStockQty ?> in stock</span>
                    <?php endif; ?>
                </div>

                <div class="pdp-btn-row">
                    <button class="pdp-atc-btn" onclick="handlePdpAddToCart()">
                        <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        <span><?= $isFullSetProduct ? 'Add Full Set To Bag' : 'Add To Bag' ?></span>
                    </button>

                    <button class="pdp-buy-btn" onclick="handlePdpBuyNow()">
                        <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        <span><?= $isFullSetProduct ? 'Buy Full Set Now' : 'Buy Now' ?></span>
                    </button>
                </div>

                <!-- Direct WhatsApp Order Checkout Trigger -->
                <button
                    type="button"
                    class="pdp-wa-order-btn"
                    onclick="openPdpWhatsAppOrderModal()"
                    aria-label="Instant Order via WhatsApp"
                >
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    <span>Instant Order via WhatsApp</span>
                </button>
                <?php endif; ?>
            </div>

            <!-- Pincode Delivery Estimator -->
            <div class="pdp-delivery-box">
                <div class="pdp-del-title">
                    <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    <span>Check Estimated Delivery & COD</span>
                </div>
                <div class="pdp-pincode-input-row">
                    <input type="text" id="pdpPincodeInput" class="pdp-pincode-input" placeholder="Enter 6-digit Pincode (e.g. 395002)" maxlength="6" />
                    <button class="pdp-pincode-btn" onclick="checkPincodeDelivery()">Check</button>
                </div>
                <div class="pdp-pincode-result" id="pdpPincodeResult"></div>
            </div>

            <!-- Accordion Details & Specifications -->
            <div class="pdp-accordion-wrap">
                <!-- 1. Product Details (Myntra Style) -->
                <div class="pdp-acc-item open">
                    <button type="button" class="pdp-acc-header" onclick="togglePdpAcc(this)" aria-expanded="true">
                        <div class="pdp-acc-title-group">
                            <div class="pdp-acc-icon-box">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            </div>
                            <span class="pdp-acc-title-text">Product Details</span>
                        </div>
                        <div class="pdp-acc-chevron-wrap">
                            <svg viewBox="0 0 24 24" class="pdp-acc-chevron"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </button>
                    <div class="pdp-acc-body">
                        <div class="pdp-myntra-details-wrap">
                            <?php
                            // Only sections the catalogue actually filled in. $currentDetails is
                            // array_filter'd in the controller, so a product with no fabric or
                            // no size variants simply has no Material & Care / Size & Fit block
                            // instead of the old "Dry Clean Only" / "Free Size" boilerplate.
                            $pdpDetailHeadings = [
                                'design_lines'  => 'Design Details',
                                'size_fit'      => 'Size & Fit',
                                'material_care' => 'Material & Care'
                            ];
                            $pdpHasDetails = false;
                            foreach ($pdpDetailHeadings as $dKey => $dHeading):
                                $dLines = isset($currentDetails[$dKey]) ? (array)$currentDetails[$dKey] : [];
                                if ($dLines === []) { continue; }
                                $pdpHasDetails = true;
                            ?>
                            <div class="pdp-myntra-section-block">
                                <h4 class="pdp-myntra-heading"><?= htmlspecialchars($dHeading) ?></h4>
                                <div class="pdp-myntra-list">
                                    <?php foreach ($dLines as $line): ?>
                                    <div class="pdp-myntra-list-item"><?= htmlspecialchars((string)$line) ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php if (!$pdpHasDetails): ?>
                            <div class="pdp-myntra-section-block">
                                <div class="pdp-myntra-list">
                                    <div class="pdp-myntra-list-item">Detailed specifications have not been published for this product yet. Message us on WhatsApp and we will confirm them for you.</div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- 2. Specifications -->
                <div class="pdp-acc-item">
                    <button type="button" class="pdp-acc-header" onclick="togglePdpAcc(this)" aria-expanded="false">
                        <div class="pdp-acc-title-group">
                            <div class="pdp-acc-icon-box">
                                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                            </div>
                            <span class="pdp-acc-title-text">Fabric & Garment Specifications</span>
                        </div>
                        <div class="pdp-acc-chevron-wrap">
                            <svg viewBox="0 0 24 24" class="pdp-acc-chevron"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </button>
                    <div class="pdp-acc-body">
                        <div class="pdp-myntra-spec-grid">
                            <?php foreach ($currentSpecs as $spec): ?>
                            <div class="pdp-myntra-spec-cell">
                                <span class="pdp-myntra-spec-title"><?= htmlspecialchars($spec['title']) ?></span>
                                <span class="pdp-myntra-spec-val"><?= htmlspecialchars($spec['val']) ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 3. Fast Delivery, 100% Original & Fast Exchange -->
                <div class="pdp-acc-item">
                    <button type="button" class="pdp-acc-header" onclick="togglePdpAcc(this)" aria-expanded="false">
                        <div class="pdp-acc-title-group">
                            <div class="pdp-acc-icon-box">
                                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                            </div>
                            <span class="pdp-acc-title-text">Fast Delivery, 100% Original & Fast Exchange</span>
                        </div>
                        <div class="pdp-acc-chevron-wrap">
                            <svg viewBox="0 0 24 24" class="pdp-acc-chevron"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </button>
                    <div class="pdp-acc-body">
                        <div class="pdp-trust-cards-list">
                            <div class="pdp-trust-mini-card gold">
                                <div class="pdp-trust-mini-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
                                </div>
                                <div class="pdp-trust-mini-text">
                                    <h5>100% Original Certified Handloom</h5>
                                    <p>Authentic ethnic couture directly sourced from DT Brand's master weavers with silk authenticity guarantee.</p>
                                </div>
                            </div>
                            <div class="pdp-trust-mini-card green">
                                <div class="pdp-trust-mini-icon">
                                    <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                </div>
                                <div class="pdp-trust-mini-text">
                                    <h5>⚡ Fast Express Priority Dispatch</h5>
                                    <p>Dispatched within 24–48 hours with live SMS/WhatsApp shipment tracking across 19,000+ Indian pincodes.</p>
                                </div>
                            </div>
                            <div class="pdp-trust-mini-card blue">
                                <div class="pdp-trust-mini-icon">
                                    <svg viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                                </div>
                                <div class="pdp-trust-mini-text">
                                    <h5>💎 7-Day Fast Doorstep Exchange</h5>
                                    <p>Zero-hassle size or fit exchanges arranged instantly with doorstep pickup via our dedicated WhatsApp concierge.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ════ CUSTOMER REVIEWS & RATINGS BREAKDOWN ════ -->
    <section class="pdp-reviews-section" id="pdpReviewsSection">
        <h2 class="pdp-section-title-large">Verified Customer Reviews</h2>
        
        <div class="pdp-rev-header-grid">
            <div class="pdp-overall-score">
                <?php if ($reviewTotal > 0): ?>
                <div class="pdp-big-rating"><?= number_format($pRating, 1) ?></div>
                <div class="pdp-big-stars"><?= str_repeat('★', max(1, min(5, (int)round($pRating)))) ?></div>
                <div class="pdp-score-sub">Based on <?= (int)$reviewTotal ?> published review<?= $reviewTotal === 1 ? '' : 's' ?></div>
                <?php else: ?>
                <div class="pdp-big-rating">—</div>
                <div class="pdp-score-sub">No reviews published yet</div>
                <?php endif; ?>
            </div>

            <!-- Star histogram. This was a fixed 88 / 9 / 2 / 1 / 0 split printed on
                 every product; it is now GROUP BY rating over approved reviews. -->
            <div class="pdp-bars-wrap">
                <?php for ($star = 5; $star >= 1; $star--):
                    $starCount = (int)($reviewBreakdown[$star] ?? 0);
                    $starPct = $reviewTotal > 0 ? (int)round(($starCount / $reviewTotal) * 100) : 0;
                ?>
                <div class="pdp-bar-row"><span><?= $star ?> Star</span><div class="pdp-bar-track"><div class="pdp-bar-fill" style="width: <?= $starPct ?>%;"></div></div><span><?= $starPct ?>%</span></div>
                <?php endfor; ?>
            </div>

            <div style="display:flex; flex-direction:column; gap:10px; align-items:flex-end;">
                <button class="pdp-write-rev-btn" onclick="openWriteReviewModal()">
                    <span>✍️ Write a Review</span>
                </button>
            </div>
        </div>

        <!-- Auto-Sliding Carousel Wrapper -->
        <div class="pdp-reviews-carousel-wrap" id="pdpRevCarouselWrap">
            <button class="pdp-rev-arrow prev" id="pdpRevPrev" aria-label="Previous review" onclick="slidePdpReviews(-1)">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="pdp-rev-arrow next" id="pdpRevNext" aria-label="Next review" onclick="slidePdpReviews(1)">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <div class="pdp-reviews-track" id="pdpReviewsTrack">
                <?php if ($customerReviews === []): ?>
                <article class="pdp-review-card pdp-review-empty">
                    <p class="pdp-rc-text">No reviews have been published for this product yet. If you have bought it, yours would be the first — use “Write a Review” above and it will appear here once our team has checked it.</p>
                </article>
                <?php else: ?>
                <?php foreach ($customerReviews as $rev):
                    $revName    = trim((string)$rev['name']) !== '' ? trim((string)$rev['name']) : 'Verified shopper';
                    $initial    = strtoupper(mb_substr($revName, 0, 1));
                    $revRating  = max(1, min(5, (int)$rev['rating']));
                    $revWhen    = pdp_relative_date((string)$rev['created_at']);
                ?>
                <article class="pdp-review-card" data-rating="<?= $revRating ?>">
                    <div class="pdp-rc-top">
                        <div class="pdp-rc-avatar"><?= htmlspecialchars($initial) ?></div>
                        <div class="pdp-rc-meta">
                            <div class="pdp-rc-name">
                                <span><?= htmlspecialchars($revName) ?></span>
                            </div>
                            <?php if ($revWhen !== ''): ?>
                            <!-- The reviews table has no city column; this used to print
                                 an invented city beside every name. -->
                            <span class="pdp-rc-loc-date"><?= htmlspecialchars($revWhen) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="pdp-rc-rating-right">
                            <?php if (!empty($rev['verified'])): ?>
                            <span class="pdp-verified-badge">✓ Verified</span>
                            <?php endif; ?>
                            <div class="pdp-rc-stars"><?= str_repeat('★', $revRating) ?></div>
                        </div>
                    </div>

                    <?php if (trim((string)$rev['title']) !== ''): ?>
                    <strong class="pdp-rc-title"><?= htmlspecialchars((string)$rev['title']) ?></strong>
                    <?php endif; ?>

                    <?php if (trim((string)$rev['text']) !== ''): ?>
                    <p class="pdp-rc-text">
                        “<?= htmlspecialchars((string)$rev['text']) ?>”
                    </p>
                    <?php endif; ?>
                    <!-- The "Helpful? 👍 (N)" button counted nothing: there is no helpful
                         column and the click only incremented a number in the DOM. -->
                </article>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Dots -->
            <div class="pdp-rev-dots" id="pdpRevDots"></div>
        </div>
    </section>

    <!-- ════ RELATED PRODUCTS CAROUSEL ════ -->
    <section class="pdp-bottom-section" id="pdpRelatedSection">
        <h2 class="pdp-section-title-large">You May Also Admire</h2>

        <div class="pdp-rel-carousel-wrap" id="pdpRelCarouselWrap">
            <!-- Navigation Arrows (Desktop) -->
            <button class="pdp-rel-arrow prev" id="pdpRelPrev" aria-label="Previous related products" onclick="slidePdpRelated(-1)">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="pdp-rel-arrow next" id="pdpRelNext" aria-label="Next related products" onclick="slidePdpRelated(1)">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <!-- Scrollable Track (2-show on mobile). $relatedItems is built in the
                 controller from the live catalogue; this used to re-filter $products,
                 which no longer exists here, with a loose !== on mixed-type ids. -->
            <div class="pdp-rel-track" id="pdpRelTrack">
                <?php foreach ($relatedItems as $rel):
                    $relName  = trim((string)($rel['name'] ?? ''));
                    $relName  = $relName !== '' ? $relName : 'Untitled product';
                    $relImg   = trim((string)($rel['image'] ?? ''));
                    $relPrice = (float)($rel['price'] ?? 0);
                    $relMrp   = (float)($rel['old_price'] ?? 0);
                    $relDisc  = (int)($rel['discount'] ?? 0);
                ?>
                <a href="/product/<?= (int)($rel['id'] ?? 0) ?>" class="pdp-rel-card">
                    <div class="pdp-rel-img-wrap">
                        <?php if (!empty($rel['badge'])): ?>
                        <span class="pdp-rel-badge"><?= htmlspecialchars((string)$rel['badge']) ?></span>
                        <?php endif; ?>
                        <img src="<?= htmlspecialchars($relImg !== '' ? $relImg : $pdpNoImage) ?>" alt="<?= htmlspecialchars($relName) ?>" loading="lazy" />
                    </div>
                    <div class="pdp-rel-body">
                        <?php if (trim((string)($rel['category'] ?? '')) !== ''): ?>
                        <span class="pdp-rel-cat"><?= htmlspecialchars((string)$rel['category']) ?></span>
                        <?php endif; ?>
                        <h3 class="pdp-rel-title"><?= htmlspecialchars($relName) ?></h3>
                        <div class="pdp-rel-price-row">
                            <span class="pdp-rel-price"><?= $relPrice > 0 ? '₹' . number_format($relPrice) : 'Price on request' ?></span>
                            <?php if ($relMrp > $relPrice && $relPrice > 0): ?>
                            <span class="pdp-rel-mrp">₹<?= number_format($relMrp) ?></span>
                            <?php endif; ?>
                            <?php if ($relDisc > 0 && $relMrp > $relPrice): ?>
                            <span class="pdp-rel-disc"><?= $relDisc ?>% OFF</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
                <?php if ($relatedItems === []): ?>
                <p style="font-size:0.82rem; color:var(--mid-text); margin:0; padding:8px 2px;">No other products are published yet.</p>
                <?php endif; ?>
            </div>

            <!-- Dots -->
            <div class="pdp-rel-dots" id="pdpRelDots"></div>
        </div>
    </section>
</main>

<!-- ════ SIZE GUIDE MODAL ════ -->
<div class="pdp-modal-overlay" id="pdpSizeChartModal" role="dialog" aria-modal="true" aria-label="Size Guide">
    <div class="pdp-modal-box">
        <div class="pdp-modal-header">
            <h3 class="pdp-modal-title">📏 Royal Size & Measurement Guide</h3>
            <button class="pdp-modal-close-btn" onclick="closeSizeGuideModal()">&times;</button>
        </div>
        <div class="pdp-modal-body">
            <p style="font-size:0.8rem; color:var(--mid-text); line-height:1.5;">
                All measurements are tailored with standard Indian ethnic comfort allowances. Custom sizing adjustments can also be requested via our WhatsApp stylist.
            </p>
            <table class="pdp-size-table">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Bust (Inches)</th>
                        <th>Waist (Inches)</th>
                        <th>Hip (Inches)</th>
                        <th>Garment Length</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>XS</strong></td><td>32" - 34"</td><td>26" - 28"</td><td>36"</td><td>Standard 54"</td></tr>
                    <tr><td><strong>S</strong></td><td>34" - 36"</td><td>28" - 30"</td><td>38"</td><td>Standard 54"</td></tr>
                    <tr><td><strong>M</strong></td><td>36" - 38"</td><td>30" - 32"</td><td>40"</td><td>Standard 55"</td></tr>
                    <tr><td><strong>L</strong></td><td>38" - 40"</td><td>32" - 34"</td><td>42"</td><td>Standard 55"</td></tr>
                    <tr><td><strong>XL</strong></td><td>40" - 42"</td><td>34" - 36"</td><td>44"</td><td>Standard 56"</td></tr>
                    <tr><td><strong>Free Size</strong></td><td>34" - 44"</td><td>Adjustable</td><td>Free</td><td>Saree 5.5m + 0.8m Blouse</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ════ WRITE A REVIEW MODAL ════ -->
<div class="pdp-modal-overlay" id="pdpWriteReviewModal" role="dialog" aria-modal="true" aria-label="Write a Review">
    <div class="pdp-modal-box" style="max-width: 520px;">
        <div class="pdp-modal-header">
            <h3 class="pdp-modal-title">✍️ Write a Customer Review</h3>
            <button class="pdp-modal-close-btn" onclick="closeWriteReviewModal()">&times;</button>
        </div>
        <div class="pdp-modal-body">
            <form id="pdpReviewForm" onsubmit="submitCustomerReview(event)" style="display:flex; flex-direction:column; gap:14px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:6px;">Your Overall Rating</label>
                    <div id="pdpStarRatingSelector" style="display:flex; gap:6px; font-size:1.6rem; color:#F59E0B; cursor:pointer;">
                        <span data-val="1" onclick="setReviewRating(1)">★</span>
                        <span data-val="2" onclick="setReviewRating(2)">★</span>
                        <span data-val="3" onclick="setReviewRating(3)">★</span>
                        <span data-val="4" onclick="setReviewRating(4)">★</span>
                        <span data-val="5" onclick="setReviewRating(5)">★</span>
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:4px;" for="revName">Full Name *</label>
                    <input type="text" id="revName" required placeholder="e.g. Radhika Sharma" style="width:100%; height:40px; border:1.5px solid var(--soft-platinum); border-radius:8px; padding:0 12px; font-family:var(--font-sans); font-size:0.85rem;" />
                </div>

                <?php /* The City / State and "Occasion Worn" inputs were removed: the
                         reviews table has no column for either, so whatever the shopper
                         typed was thrown away after being painted into a DOM card. The
                         review_title column, which the admin moderation screens do show,
                         had no input at all. */ ?>
                <div>
                    <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:4px;" for="revTitle">Review Headline</label>
                    <input type="text" id="revTitle" maxlength="150" placeholder="e.g. Beautiful zari work, true to the photos" style="width:100%; height:40px; border:1.5px solid var(--soft-platinum); border-radius:8px; padding:0 12px; font-family:var(--font-sans); font-size:0.85rem;" />
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:4px;" for="revText">Your Review Narrative *</label>
                    <textarea id="revText" required rows="3" placeholder="Describe the fabric, the zari, the fit and the packaging..." style="width:100%; border:1.5px solid var(--soft-platinum); border-radius:8px; padding:10px 12px; font-family:var(--font-sans); font-size:0.85rem; resize:vertical;"></textarea>
                </div>

                <p style="margin:0; font-size:0.72rem; color:var(--mid-text); line-height:1.5;">
                    Reviews are checked by our team before they appear on the page.
                </p>

                <button type="submit" id="revSubmitBtn" class="pdp-buy-btn" style="width:100%; padding:12px; border-radius:8px; font-size:0.82rem;">Submit Review</button>
            </form>
        </div>
    </div>
</div>

<!-- ════ INSTANT WHATSAPP QUICK ORDER CHECKOUT MODAL ════ -->
<div class="pdp-modal-overlay" id="pdpWhatsAppOrderModal" role="dialog" aria-modal="true" aria-label="Instant WhatsApp Checkout">
    <div class="pdp-wa-modal-box">
        <!-- Brand Header (Matching checkout.php .co-header) -->
        <div class="pdp-wa-co-header">
            <div class="pdp-wa-co-brand">
                <div class="pdp-wa-co-icon">
                    <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </div>
                <div class="pdp-wa-co-title-group">
                    <h3>DT BRAND'S</h3>
                    <span>Luxury Ethnic • WhatsApp Checkout</span>
                </div>
            </div>
            <button class="pdp-wa-co-close-btn" onclick="closePdpWhatsAppOrderModal()" aria-label="Close">&times;</button>
        </div>

        <div class="pdp-wa-modal-body">
            <!-- Order Item Summary Card (Matching checkout.php) -->
            <div class="pdp-wa-sec-card">
                <div class="pdp-wa-modal-product">
                    <img src="<?= htmlspecialchars($pdpPoster) ?>" alt="<?= htmlspecialchars($pName) ?>" class="pdp-wa-modal-img" id="pdpWaModalImg" />
                    <div class="pdp-wa-modal-info">
                        <div class="pdp-wa-modal-name"><?= htmlspecialchars($pName) ?></div>
                        <div class="pdp-wa-modal-meta">
                            <?php /* Colour and size only appear when the product has variants;
                                     they used to default to the invented 'Standard' / 'Free Size',
                                     which then travelled into the WhatsApp order message. */ ?>
                            <?php if ($pColors !== []): ?>
                            <span>Color: <strong id="pdpWaModalColor" style="color:var(--dark-text);"><?= htmlspecialchars($pColors[0]) ?></strong></span>
                            <?php endif; ?>
                            <?php if ($pSizes !== []): ?>
                            <span>Size: <strong id="pdpWaModalSize" style="color:var(--dark-text);"><?= htmlspecialchars($pSizes[0]) ?></strong></span>
                            <?php endif; ?>
                            <span>Qty: <strong id="pdpWaModalQty" style="color:var(--dark-text);">1</strong></span>
                        </div>
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:2px;">
                            <span class="pdp-wa-modal-price" id="pdpWaModalPrice"><?= $pPrice > 0 ? '₹' . number_format($pPrice) : 'Price on request' ?></span>
                            <span style="font-size:0.65rem; color:#2E7D32; font-weight:800; background:#E8F5E9; padding:2px 7px; border-radius:4px;">⚡ Free Delivery (3–5 Days)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Checkout Form -->
            <form id="pdpWhatsAppOrderForm" onsubmit="submitPdpWhatsAppOrder(event)" style="display:flex; flex-direction:column; gap:12px;">
                
                <!-- Section 1: Customer Contact Details Card (ALWAYS VISIBLE & OPEN) -->
                <div class="pdp-wa-sec-card">
                    <div class="pdp-wa-card-header">
                        <div class="pdp-wa-card-title">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>Customer Contact Details</span>
                        </div>
                    </div>

                    <div class="pdp-wa-input-group">
                        <label class="pdp-wa-label" for="pdpWaName">Customer Full Name <span class="required">*</span></label>
                        <input type="text" id="pdpWaName" required placeholder="Enter Customer Full Name (e.g. Priya Sharma)" class="pdp-wa-input" autocomplete="name" />
                    </div>

                    <div class="pdp-wa-input-group">
                        <label class="pdp-wa-label" for="pdpWaPhone">WhatsApp Mobile Number <span class="required">*</span></label>
                        <div class="pdp-wa-phone-wrap">
                            <div class="pdp-wa-phone-prefix">🇮🇳 +91</div>
                            <input type="text" id="pdpWaPhone" required placeholder="70463 63528" class="pdp-wa-input pdp-wa-phone-input" autocomplete="tel" />
                        </div>
                    </div>
                </div>

                <!-- Section 2: Delivery & Billing Address Card (COLLAPSIBLE / OPTIONAL) -->
                <div class="pdp-wa-sec-card pdp-wa-addr-collapse-wrap" id="pdpWaAddrCollapseWrap">
                    <button type="button" class="pdp-wa-addr-toggle-btn" onclick="togglePdpWaAddressSection()" aria-expanded="false">
                        <div class="pdp-wa-card-title">
                            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>Delivery & Billing Address</span>
                            <span style="font-size:0.62rem; background:#FAF5E8; color:#8A681F; padding:2px 6px; border-radius:4px; font-weight:700; border:1px solid rgba(138,104,31,0.2);">Optional</span>
                        </div>
                        <span class="pdp-wa-addr-arrow" id="pdpWaAddrArrow" style="font-size:0.75rem; color:#8A681F; transition:transform 0.25s;">▼</span>
                    </button>

                    <div class="pdp-wa-addr-collapsible-body" id="pdpWaAddrBody" style="display:none; flex-direction:column; gap:9px; margin-top:10px; padding-top:8px; border-top:1px dashed rgba(138,104,31,0.25);">
                        <!-- Full Address -->
                        <div class="pdp-wa-input-group">
                            <label class="pdp-wa-label" for="pdpWaAddress">House / Flat No., Street, Landmark</label>
                            <input type="text" id="pdpWaAddress" placeholder="e.g. Flat 402, Royal Palms, Bandra West" class="pdp-wa-input" autocomplete="street-address" />
                        </div>

                        <!-- City, State & Pincode Grid -->
                        <div class="pdp-wa-loc-grid">
                            <div class="pdp-wa-input-group">
                                <label class="pdp-wa-label" for="pdpWaCity">City</label>
                                <input type="text" id="pdpWaCity" placeholder="e.g. Mumbai" class="pdp-wa-input" />
                            </div>
                            <div class="pdp-wa-input-group">
                                <label class="pdp-wa-label" for="pdpWaState">State</label>
                                <input type="text" id="pdpWaState" placeholder="e.g. Maharashtra" class="pdp-wa-input" />
                            </div>
                            <div class="pdp-wa-input-group pdp-wa-col-pin">
                                <label class="pdp-wa-label" for="pdpWaPincode">Pincode</label>
                                <input type="text" id="pdpWaPincode" placeholder="400050" maxlength="8" class="pdp-wa-input" autocomplete="postal-code" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Payment Preference Card (Matching checkout.php) -->
                <div class="pdp-wa-sec-card">
                    <div class="pdp-wa-card-header">
                        <div class="pdp-wa-card-title">
                            <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            <span>Payment Preference</span>
                        </div>
                    </div>

                    <div class="pdp-wa-payment-grid">
                        <label class="pdp-wa-pay-card selected" id="pdpWaPayCodCard" onclick="selectPdpWaPayment('cod')">
                            <input type="radio" name="pdpWaPayment" id="pdpWaRadioCod" value="Cash on Delivery (COD)" checked style="display:none;" />
                            <div class="pdp-wa-pay-radio"></div>
                            <div class="pdp-wa-pay-icon cod">
                                <svg viewBox="0 0 24 24"><path d="M21 18v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v1"/><polyline points="10 12 14 12 14 16"/><line x1="10" y1="14" x2="14" y2="14"/><rect x="14" y="6" width="7" height="12" rx="2"/></svg>
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:0.75rem; font-weight:800; color:#24211C; line-height:1.2;">Cash on Delivery</div>
                                <div style="font-size:0.62rem; color:#5A5348;">Pay upon arrival</div>
                            </div>
                        </label>

                        <label class="pdp-wa-pay-card" id="pdpWaPayUpiCard" onclick="selectPdpWaPayment('upi')">
                            <input type="radio" name="pdpWaPayment" id="pdpWaRadioUpi" value="UPI on WhatsApp (GPay / PhonePe / Paytm)" style="display:none;" />
                            <div class="pdp-wa-pay-radio"></div>
                            <div class="pdp-wa-pay-icon upi">
                                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:0.75rem; font-weight:800; color:#24211C; line-height:1.2;">UPI on WhatsApp</div>
                                <div style="font-size:0.62rem; color:#5A5348;">Instant scan / pay</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="pdp-wa-submit-btn">
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    <span>Confirm Order & Send to WhatsApp</span>
                </button>

                <!-- Trust Badges Row (All in 1 Single Line on Mobile) -->
                <div class="pdp-wa-trust-row">
                    <span class="pdp-wa-trust-item">🔒 256-Bit Encrypted</span>
                    <span class="pdp-wa-trust-dot">•</span>
                    <span class="pdp-wa-trust-item">⚡ 3–5 Day Delivery</span>
                    <span class="pdp-wa-trust-dot">•</span>
                    <span class="pdp-wa-trust-item">💎 100% Authentic</span>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ════ TOAST CONTAINER ════ -->
<div class="toast-container" id="toastContainer" aria-live="assertive" aria-atomic="true"></div>

<!-- ════ FOOTER PARTIAL ════ -->
<?php include_once __DIR__ . '/includes/singelprodutbottomfotoer.php'; ?>

<!-- ════ CART DRAWER PARTIAL ════ -->
<?php include_once __DIR__ . '/shared/quickview.php'; ?>
    <?php include_once __DIR__ . '/shared/cart.php'; ?>

<!-- ════ WISHLIST DRAWER PARTIAL ════ -->
<?php include_once __DIR__ . '/shared/wishlist.php'; ?>

<!-- ════ CHECKOUT MODAL PARTIAL ════ -->
<?php include_once __DIR__ . '/shared/checkout.php'; ?>

<!-- ════ SCRIPT ENGINE ════ -->
<script>
        window.currentProductData = <?= json_encode($product, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
        window.totalSlidesCount = <?= max(1, count($pdpImages)) ?>;
        window.pdpVideosData = <?= json_encode($pdpVideos, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
        window.pdpWhatsAppNumber = <?= json_encode($pdpWaNumber) ?>;
    </script>
    <script src="/assets/js/singleproduct.js?v=1787020000"></script>

<!-- ════════════ SMART WHATSAPP SHARE MODAL (Meesho-Grade Flow) ════════════ -->
<?php include_once __DIR__ . '/shared/smartshare.php'; ?>

<?php include_once __DIR__ . '/shared/reels.php'; ?>
<?php include_once __DIR__ . '/shared/account.php'; ?>
</body>
</html>
