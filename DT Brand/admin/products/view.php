<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * view.php — Dynamic Next-Level Product Overview & Analytics Suite
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$page_title = "Product Overview";
$active_nav = "products";

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$p = $product_id > 0 ? ProductCatalog::getById($product_id) : null;

/*
 * A missing id used to default to 1, and an id that is not in the table fell
 * back to the first product in the catalogue - so this page showed one
 * product's photo, stock, prices, ratings and analytics under a different
 * product's id. Nothing is substituted now.
 */
if (!$p) {
    http_response_code(404);
    $askedFor = $product_id > 0 ? ('#' . $product_id) : '(none supplied)';
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">'
       . '<meta name="viewport" content="width=device-width, initial-scale=1.0">'
       . '<title>Product not found</title></head>'
       . '<body style="font-family:sans-serif; background:#f0f0f1; padding:40px; color:#1d2327;">'
       . '<div style="max-width:560px; margin:0 auto; background:#fff; border:1px solid #c3c4c7;'
       . ' border-left:4px solid #d63638; border-radius:4px; padding:24px;">'
       . '<h1 style="font-size:18px; margin:0 0 8px 0;">Product not found</h1>'
       . '<p style="font-size:13px; color:#646970; margin:0 0 16px 0;">No product with id '
       . htmlspecialchars($askedFor) . ' exists in the catalogue. It may have been deleted,'
       . ' or the link may be out of date.</p>'
       . '<a href="/admin/products/" style="display:inline-block; background:#2271b1; color:#fff;'
       . ' padding:8px 16px; border-radius:3px; text-decoration:none; font-size:13px; font-weight:600;">'
       . 'Back to catalog</a></div></body></html>';
    exit;
}

/*
 * Real counters only. The schema has no page-view or add-to-cart event log, so
 * "Total Views" (which was units sold x 12 + 1, under a "+18.4%" trend) and the
 * "17.4% Rate" line are gone. The cart figure counts live cart_items rows for
 * this product and saves come from wishlist_items.
 */
$sold_qty  = 0;
$total_rev = 0.0;
$inCarts   = 0;
$wishSaves = 0;
$createdAt = '';
$updatedAt = '';
$db = Database::getConnection();
if ($db !== null && !Database::isMockMode()) {
    try {
        $stmt = $db->prepare("SELECT COALESCE(SUM(quantity), 0) AS total_sold, COALESCE(SUM(total_price), 0) AS total_revenue FROM order_items WHERE product_id = ?");
        $stmt->execute([$p['id']]);
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($res) {
            $sold_qty  = (int)$res['total_sold'];
            $total_rev = (float)$res['total_revenue'];
        }
    } catch (\Exception $e) {}
    try {
        $stmt = $db->prepare("SELECT COALESCE(SUM(quantity), 0) FROM cart_items WHERE product_id = ?");
        $stmt->execute([$p['id']]);
        $inCarts = (int)$stmt->fetchColumn();
    } catch (\Exception $e) {}
    try {
        $stmt = $db->prepare("SELECT COUNT(*) FROM wishlist_items WHERE product_id = ?");
        $stmt->execute([$p['id']]);
        $wishSaves = (int)$stmt->fetchColumn();
    } catch (\Exception $e) {}
    try {
        $stmt = $db->prepare("SELECT created_at, updated_at FROM products WHERE id = ?");
        $stmt->execute([$p['id']]);
        $ts = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($ts) {
            $createdAt = (string)($ts['created_at'] ?? '');
            $updatedAt = (string)($ts['updated_at'] ?? '');
        }
    } catch (\Exception $e) {}
}

$ret_price = (float)($p['retail_price'] ?? 0);
$ws_price  = (float)($p['wholesale_price'] ?? 0);
$rs_price  = (float)($p['reseller_price'] ?? 0);
$mrp_price = (float)($p['mrp'] ?? 0);
$stockQty  = (int)($p['stock_qty'] ?? 0);
$reviewsN  = (int)($p['reviews_count'] ?? 0);
$ratingV   = (float)($p['rating'] ?? 0);

/*
 * Gross profit on what actually sold. The MRP used to be invented as retail x
 * 1.5 and the reseller price as retail x 0.7 whenever either was 0, and a flat
 * "35.1% Margin" was printed under the figure whatever the numbers were.
 */
$est_profit = ($sold_qty > 0 && $ws_price > 0) ? max(0.0, $total_rev - ($sold_qty * $ws_price)) : 0.0;

$dtMoney = static function (float $v): string {
    return $v > 0 ? '&#8377;' . number_format($v) : 'not set';
};

$statusKey    = (string)($p['status'] ?? '');
$statusLabels = [
    'in_stock'     => 'In stock',
    'low_stock'    => 'Low stock',
    'out_of_stock' => 'Out of stock',
    'draft'        => 'Draft - not on the storefront'
];

$prodColors = array_values(array_filter(array_map('strval', (array)($p['colors'] ?? [])), static fn($v) => trim($v) !== ''));
$prodSizes  = array_values(array_filter(array_map('strval', (array)($p['size'] ?? [])), static fn($v) => trim($v) !== ''));
$lotBits = [];
foreach (['single' => 'Single', 'half_set' => 'Half set', 'full_set' => 'Full set', 'master_bale' => 'Master bale'] as $lk => $ll) {
    $lq = (int)($p['moq_lots'][$lk] ?? 0);
    if ($lq > 0) { $lotBits[] = $ll . ': ' . $lq . ' pcs'; }
}

/*
 * Specification rows. Barcode ("8901234500<id>"), Brand ("DT Signature (Arniya
 * Heritage)"), saree length ("6.3 Meters (Includes 0.8m Running Blouse Piece)")
 * and HSN ("5007 (5% GST Rate)") were printed for every product, and the
 * products table has no barcode, brand, length or hsn column - all four were
 * invented. Fabric fell back to "100% Pure Mulberry Silk with 24K Gold Zari
 * Weave" and category to "Silk Sarees". Empty rows are left out below.
 */
$specRows = [
    'Product name' => (string)($p['name'] ?? ($p['title'] ?? '')),
    'SKU code'     => (string)($p['sku'] ?? ''),
    'Slug'         => (string)($p['slug'] ?? ''),
    'Category'     => (string)($p['category'] ?? ''),
    'Fabric'       => (string)($p['fabric'] ?? ''),
    'Weave'        => (string)($p['weave'] ?? ''),
    'Zari'         => (string)($p['zari_type'] ?? ''),
    'Pallu'        => (string)($p['pallu_style'] ?? ''),
    'Blouse piece' => (string)($p['blouse_piece'] ?? ''),
    'Occasion'     => (string)($p['occasion'] ?? ''),
    'Colours'      => implode(', ', $prodColors),
    'Sizes'        => implode(', ', $prodSizes),
    'Lot sizes'    => implode('  |  ', $lotBits),
    'Created'      => $createdAt,
    'Last updated' => $updatedAt
];

$prod = [
    'id'              => (int)$p['id'],
    'name'            => (string)($p['name'] ?? ($p['title'] ?? '')),
    'sku'             => (string)($p['sku'] ?? ''),
    'status'          => $statusLabels[$statusKey] ?? ($statusKey !== '' ? $statusKey : 'Unknown'),
    'status_is_live'  => in_array($statusKey, ['in_stock', 'low_stock'], true),
    'image'           => (string)($p['image'] ?? ProductCatalog::NO_IMAGE),
    'has_photo'       => !empty($p['has_photo']),
    'retail_price'    => $dtMoney($ret_price),
    'reseller_price'  => $dtMoney($rs_price),
    'wholesale_price' => $ws_price > 0
        ? $dtMoney($ws_price) . '/pc' . ((int)($p['moq'] ?? 0) > 0 ? ' (MOQ: ' . (int)$p['moq'] . ')' : '')
        : 'not set',
    'mrp'             => $dtMoney($mrp_price),
    'stock'           => number_format($stockQty) . ' units',
    'stock_color'     => $stockQty > 0 ? '#15803D' : '#DC2626',
    'sold'            => number_format($sold_qty) . ' pcs',
    'revenue'         => '&#8377;' . number_format($total_rev),
    'profit'          => '&#8377;' . number_format($est_profit),
    'in_carts'        => number_format($inCarts),
    'wish_saves'      => number_format($wishSaves),
    'rating'          => $reviewsN > 0 ? number_format($ratingV, 1) . ' &#9733;' : 'No reviews yet',
    'reviews'         => $reviewsN > 0 ? $reviewsN . ($reviewsN === 1 ? ' review' : ' reviews') : 'Nothing submitted yet'
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($prod['name']); ?> ‹ Product Overview</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/product-view.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 12px 16px;">
            
            <!-- WordPress Heading & Real SVG Action Bar -->
            <div class="wp-heading-wrap" style="justify-content: space-between; border-bottom: 1px solid #c3c4c7; padding-bottom: 10px; margin-bottom: 14px;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline"><?php echo htmlspecialchars($prod['name']); ?></h1>
                    <!-- The badge was always green ("adm-badge success") and always read
                         "Active in Catalog", because it compared the status against
                         'active' - a value the products.status ENUM does not have. -->
                    <span class="adm-badge <?php echo $prod['status_is_live'] ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($prod['status']); ?></span>
                    <a href="/admin/products/" class="wp-page-title-action secondary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back to Catalog</span>
                    </a>
                </div>
                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <button type="button" class="wp-button" onclick="window.shareProductWhatsApp(<?php echo $prod['id']; ?>)" title="Share on WhatsApp">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" style="color:#25D366;"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>WhatsApp Share</span>
                    </button>
                    <a href="/admin/products/duplicate.php?id=<?php echo $prod['id']; ?>" class="wp-button">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span>Duplicate</span>
                    </a>
                    <button type="button" class="wp-button" onclick="window.archiveProduct(<?php echo $prod['id']; ?>)">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                        <span>Archive</span>
                    </button>
                    <a href="/admin/products/edit.php?id=<?php echo $prod['id']; ?>" class="wp-button primary">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <span>Edit Product</span>
                    </a>
                </div>
            </div>

            <!-- Analytics KPIs Grid -->
            <!-- Every trend line here was a constant: "+18.4%" under views,
                 "17.4% Rate" under cart adds, "High Volume" under units sold and
                 "35.1% Margin" under profit, printed even for a product that has
                 never sold. Views are not reported at all any more - nothing in
                 the schema records them. -->
            <div class="dt-analytics-kpi-grid">
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">In Carts Now</div>
                    <div class="dt-ana-val"><?php echo $prod['in_carts']; ?></div>
                    <small style="color:#7A7266; font-weight:700;">pcs in live carts</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Wishlist Saves</div>
                    <div class="dt-ana-val"><?php echo $prod['wish_saves']; ?></div>
                    <small style="color:#7A7266; font-weight:700;">customers</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Units Sold</div>
                    <div class="dt-ana-val"><?php echo $prod['sold']; ?></div>
                    <small style="color:#7A7266; font-weight:700;">all paid &amp; pending orders</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Total Revenue</div>
                    <div class="dt-ana-val"><?php echo $prod['revenue']; ?></div>
                    <small style="color:#7A7266; font-weight:700;">from order items</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Gross Profit</div>
                    <div class="dt-ana-val"><?php echo $prod['profit']; ?></div>
                    <small style="color:#7A7266; font-weight:700;"><?php echo $est_profit > 0 ? 'revenue less wholesale cost' : 'needs sales and a wholesale rate'; ?></small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Customer Rating</div>
                    <div class="dt-ana-val" style="color:<?php echo $reviewsN > 0 ? '#DBA617' : '#7A7266'; ?>; <?php echo $reviewsN > 0 ? '' : 'font-size:15px;'; ?>"><?php echo $prod['rating']; ?></div>
                    <small style="color:#7A7266; font-weight:700;"><?php echo htmlspecialchars($prod['reviews']); ?></small>
                </div>
            </div>

            <!-- Inspection Grid -->
            <div class="dt-view-grid">
                <!-- Left Sticky Preview Card -->
                <div class="dt-view-sticky-card">
                    <!-- The onerror swap sent a photoless product to product1.png, so
                         the admin saw another product's saree on this page. -->
                    <img src="<?php echo htmlspecialchars($prod['image']); ?>" style="width:100%; height:260px; object-fit:<?php echo $prod['has_photo'] ? 'cover' : 'contain'; ?>; <?php echo $prod['has_photo'] ? '' : 'padding:40px; opacity:0.55;'; ?> border-radius:4px; border:1px solid #c3c4c7; background:#f6f7f7;" alt="<?php echo htmlspecialchars($prod['name']); ?>">
                    <?php if (!$prod['has_photo']): ?>
                        <div style="font-size:12px; color:#B32D2E; font-weight:600; margin-top:6px;">No photo has been uploaded for this product.</div>
                    <?php endif; ?>

                    <div style="margin-top:14px;">
                        <h4 style="font-size:13.5px; font-weight:700; color:#1d2327; margin:0 0 6px 0;">Multi-Tier Pricing</h4>
                        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:4px; padding:10px;">
                            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; color:#646970;">
                                <span>MRP:</span>
                                <strong><?php echo $prod['mrp']; ?></strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px;">
                                <span>Retail Price:</span>
                                <strong><?php echo $prod['retail_price']; ?></strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; color:#7E22CE;">
                                <span>Reseller Price:</span>
                                <strong><?php echo $prod['reseller_price']; ?></strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12.5px; font-weight:700; color:#8A681F; border-top:1px solid rgba(212,175,55,0.3); padding-top:4px;">
                                <span>Wholesale B2B:</span>
                                <strong><?php echo $prod['wholesale_price']; ?></strong>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:14px;">
                        <h4 style="font-size:13px; font-weight:700; color:#1d2327; margin:0 0 6px 0;">Warehouse Stock</h4>
                        <div style="background:#f6f7f7; border:1px solid #c3c4c7; border-radius:4px; padding:10px;">
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span>Current Available:</span>
                                <strong style="color:<?php echo $prod['stock_color']; ?>;"><?php echo $prod['stock']; ?></strong>
                            </div>
                            <!-- The bar below used to be stock/100 with a 5% floor, so an
                                 out-of-stock product still showed a filled sliver and 250
                                 units looked identical to 100. There is no reorder level in
                                 the schema to scale against, so the bar is gone and the
                                 catalogue status is shown instead. -->
                            <div style="display:flex; justify-content:space-between; font-size:12px; margin-top:6px; color:#646970;">
                                <span>Catalogue status:</span>
                                <strong><?php echo htmlspecialchars($prod['status']); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Specifications & Timeline -->
                <div style="display:flex; flex-direction:column; gap:14px;">
                    <!-- Product Details Card -->
                    <div style="background:#fff; border:1px solid #c3c4c7; border-radius:4px; padding:16px;">
                        <h3 style="font-size:14px; font-weight:700; color:#1d2327; margin:0 0 10px 0; border-bottom:1px solid #f0f0f1; padding-bottom:6px;">Specifications &amp; Details</h3>
                        <table style="width:100%; border-collapse:collapse; font-size:12.5px; color:#2c3338;">
                            <?php $specShown = 0; foreach ($specRows as $specLabel => $specValue): if (trim((string)$specValue) === '') { continue; } $specShown++; ?>
                            <tr>
                                <td style="width:140px; padding:6px 0; color:#646970; font-weight:600; vertical-align:top;"><?php echo htmlspecialchars($specLabel); ?>:</td>
                                <td>
                                    <?php if ($specLabel === 'Category'): ?>
                                        <a href="/admin/products/categories/" style="color:#2271b1; text-decoration:none;"><?php echo htmlspecialchars($specValue); ?></a>
                                    <?php elseif ($specLabel === 'SKU code' || $specLabel === 'Slug'): ?>
                                        <code><?php echo htmlspecialchars($specValue); ?></code>
                                    <?php else: ?>
                                        <?php echo htmlspecialchars($specValue); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if ($specShown === 0): ?>
                            <tr><td colspan="2" style="padding:8px 0; color:#646970;">No details have been filled in for this product yet.</td></tr>
                            <?php endif; ?>
                        </table>
                        <p style="font-size:11.5px; color:#7A7266; margin:10px 0 0 0;">Only the fields stored for this product are listed. Add or change them in <a href="/admin/products/edit.php?id=<?php echo $prod['id']; ?>" style="color:#2271b1;">Edit Product</a>.</p>
                    </div>

                    <!-- Audit Timeline Card -->
                    <div style="background:#fff; border:1px solid #c3c4c7; border-radius:4px; padding:16px;">
                        <h3 style="font-size:14px; font-weight:700; color:#1d2327; margin:0 0 12px 0; border-bottom:1px solid #f0f0f1; padding-bottom:6px; display:flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>Product Activity &amp; Audit Trail</span>
                        </h3>
                        <!-- Three entries were hardcoded here for every product: a
                             "Stock Dispatched (-25 pcs) for Wholesale Consignment
                             #ORD-9842" line, a price-update line and a "Product Created
                             & Published" line, all attributed to named staff on made-up
                             dates. There is no product audit table in the schema, so the
                             only history available is the row's own timestamps. -->
                        <div class="dt-timeline">
                            <?php if ($updatedAt !== '' && $updatedAt !== $createdAt): ?>
                            <div class="dt-timeline-item">
                                <div class="dt-timeline-dot"></div>
                                <div style="font-size:12.5px; font-weight:600; color:#1d2327;">Product record last updated</div>
                                <div class="dt-timeline-meta"><?php echo htmlspecialchars($updatedAt); ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if ($createdAt !== ''): ?>
                            <div class="dt-timeline-item">
                                <div class="dt-timeline-dot"></div>
                                <div style="font-size:12.5px; font-weight:600; color:#1d2327;">Product created</div>
                                <div class="dt-timeline-meta"><?php echo htmlspecialchars($createdAt); ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if ($createdAt === '' && $updatedAt === ''): ?>
                            <div style="font-size:12.5px; color:#646970;">No timestamps are recorded for this product.</div>
                            <?php endif; ?>
                        </div>
                        <p style="font-size:11.5px; color:#7A7266; margin:10px 0 0 0;">Per-field edit history (who changed a price or adjusted stock, and when) is not recorded anywhere yet, so it cannot be shown.</p>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
