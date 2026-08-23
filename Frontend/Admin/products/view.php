<?php
/**
 * view.php — Dynamic Next-Level Product Overview & Analytics Suite
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../../src/ProductCatalog.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$page_title = "Product Overview";
$active_nav = "products";

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$p = ProductCatalog::getById($product_id);
if (!$p) {
    $all = ProductCatalog::getAll();
    $p = !empty($all) ? $all[0] : null;
}

if ($p) {
    $prod = [
        'id' => $p['id'],
        'name' => $p['title'] ?? $p['name'],
        'sku' => $p['sku'],
        'barcode' => '8901234500' . $p['id'],
        'category' => $p['category'] ?? 'Silk Sarees',
        'brand' => 'DT Signature (Arniya Heritage)',
        'fabric' => $p['fabric'] ?? '100% Pure Mulberry Silk with 24K Gold Zari Weave',
        'length' => '6.3 Meters (Includes 0.8m Running Blouse Piece)',
        'hsn' => '5007 (5% GST Rate)',
        'retail_price' => '₹' . number_format($p['retail_price'] ?? $p['price']),
        'mrp' => '₹' . number_format($p['old_price'] ?? $p['mrp']),
        'reseller_price' => '₹' . number_format($p['reseller_price'] ?? ($p['retail_price'] * 0.7)),
        'wholesale_price' => '₹' . number_format($p['wholesale_price']) . '/pc (MOQ: ' . ($p['moq'] ?? 8) . ')',
        'stock' => ($p['stock_qty'] ?? 50) . ' units',
        'stock_pct' => '80%',
        'stock_color' => '#15803D',
        'image' => $p['image'] ?? '/Frontend/Shop/Asset/images/product1.png',
        'views' => '4,820',
        'cart_adds' => '842',
        'sold' => '142 pcs',
        'revenue' => '₹' . number_format(($p['retail_price'] ?? 4899) * 85),
        'profit' => '₹' . number_format((($p['retail_price'] ?? 4899) - ($p['wholesale_price'] ?? 1399)) * 85),
        'rating' => number_format($p['rating'] ?? 4.9, 1) . ' ★',
        'reviews' => ($p['reviews_count'] ?? 85) . ' Reviews',
        'status' => 'Active in Catalog'
    ];
} else {
$catalog_products = [
    101 => [
        'id' => 101,
        'name' => 'Kanjivaram Pure Silk Gold Zari Saree',
        'sku' => 'KLN-SR-111',
        'barcode' => '8901234500111',
        'category' => 'Silk Sarees',
        'brand' => 'DT Signature (Arniya Heritage)',
        'fabric' => '100% Pure Mulberry Silk with 24K Gold Zari Weave',
        'length' => '6.3 Meters (Includes 0.8m Running Blouse Piece)',
        'hsn' => '5007 (5% GST Rate)',
        'retail_price' => '₹4,490',
        'mrp' => '₹5,990',
        'reseller_price' => '₹3,450',
        'wholesale_price' => '₹2,850/pc (MOQ: 8)',
        'stock' => '45 units',
        'stock_pct' => '75%',
        'stock_color' => '#15803D',
        'image' => '/Shared/Asset/images/product1.png',
        'views' => '4,820',
        'cart_adds' => '842',
        'sold' => '142 pcs',
        'revenue' => '₹4,04,700',
        'profit' => '₹1,42,000',
        'rating' => '5.0 ★',
        'reviews' => '128 Reviews',
        'status' => 'Active in Catalog'
    ],
    102 => [
        'id' => 102,
        'name' => 'Banarasi Royal Brocade Weave Saree',
        'sku' => 'BNR-SR-204',
        'barcode' => '8901234500204',
        'category' => 'Banarasi Brocade',
        'brand' => 'Arniya Heritage',
        'fabric' => 'Katan Silk with Heritage Floral Brocade Jaal',
        'length' => '6.3 Meters (Includes 0.8m Running Blouse Piece)',
        'hsn' => '5007 (5% GST Rate)',
        'retail_price' => '₹4,990',
        'mrp' => '₹6,490',
        'reseller_price' => '₹3,950',
        'wholesale_price' => '₹3,200/pc (MOQ: 8)',
        'stock' => '28 units',
        'stock_pct' => '50%',
        'stock_color' => '#15803D',
        'image' => '/Shared/Asset/images/product2.png',
        'views' => '3,910',
        'cart_adds' => '612',
        'sold' => '98 pcs',
        'revenue' => '₹3,13,600',
        'profit' => '₹1,12,000',
        'rating' => '4.9 ★',
        'reviews' => '94 Reviews',
        'status' => 'Active in Catalog'
    ],
    103 => [
        'id' => 103,
        'name' => 'Crimson Bridal Handcrafted Zardosi Lehenga',
        'sku' => 'BRD-LH-902',
        'barcode' => '8901234500902',
        'category' => 'Bridal Lehengas',
        'brand' => 'DT Couture',
        'fabric' => 'Micro Velvet & Raw Silk with Heavy Dabka Work',
        'length' => 'Full Flare 4.2m Lehenga + Dupatta & Blouse Piece',
        'hsn' => '6204 (12% GST Rate)',
        'retail_price' => '₹16,490',
        'mrp' => '₹21,990',
        'reseller_price' => '₹13,500',
        'wholesale_price' => '₹11,500/pc (MOQ: 2)',
        'stock' => '4 units (Low Stock)',
        'stock_pct' => '15%',
        'stock_color' => '#b32d2e',
        'image' => '/Shared/Asset/images/product3.png',
        'views' => '6,420',
        'cart_adds' => '1,120',
        'sold' => '42 pcs',
        'revenue' => '₹4,83,000',
        'profit' => '₹1,85,000',
        'rating' => '5.0 ★',
        'reviews' => '42 Reviews',
        'status' => 'Active in Catalog'
    ],
    104 => [
        'id' => 104,
        'name' => 'Chanderi Foil Printed Festive Kurti Set',
        'sku' => 'KRT-CH-440',
        'barcode' => '8901234500440',
        'category' => 'Designer Kurtis',
        'brand' => 'DT Signature',
        'fabric' => 'Pure Chanderi Silk with Foil Gotta Detailing',
        'length' => 'Kurti 46 inch + Pant & Dupatta Set',
        'hsn' => '6204 (12% GST Rate)',
        'retail_price' => '₹2,490',
        'mrp' => '₹3,490',
        'reseller_price' => '₹1,850',
        'wholesale_price' => '₹1,450/pc (MOQ: 12)',
        'stock' => '65 units',
        'stock_pct' => '85%',
        'stock_color' => '#15803D',
        'image' => '/Shared/Asset/images/product4.png',
        'views' => '2,840',
        'cart_adds' => '490',
        'sold' => '115 pcs',
        'revenue' => '₹1,66,750',
        'profit' => '₹62,000',
        'rating' => '4.8 ★',
        'reviews' => '58 Reviews',
        'status' => 'Active in Catalog'
    ]
];

$prod = isset($catalog_products[$product_id]) ? $catalog_products[$product_id] : $catalog_products[101];
}
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/product-view.css?v=<?php echo time(); ?>">
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
                    <span class="adm-badge success"><?php echo htmlspecialchars($prod['status']); ?></span>
                    <a href="/Frontend/Admin/products/" class="wp-page-title-action secondary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back to Catalog</span>
                    </a>
                </div>
                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <button type="button" class="wp-button" onclick="window.shareProductWhatsApp(<?php echo $prod['id']; ?>)" title="Share on WhatsApp">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" style="color:#25D366;"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>WhatsApp Share</span>
                    </button>
                    <a href="/Frontend/Admin/products/duplicate.php?id=<?php echo $prod['id']; ?>" class="wp-button">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span>Duplicate</span>
                    </a>
                    <button type="button" class="wp-button" onclick="window.archiveProduct(<?php echo $prod['id']; ?>)">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                        <span>Archive</span>
                    </button>
                    <a href="/Frontend/Admin/products/edit.php?id=<?php echo $prod['id']; ?>" class="wp-button primary">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <span>Edit Product</span>
                    </a>
                </div>
            </div>

            <!-- Analytics KPIs Grid -->
            <div class="dt-analytics-kpi-grid">
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Total Views</div>
                    <div class="dt-ana-val"><?php echo $prod['views']; ?></div>
                    <small style="color:#15803D; font-weight:700;">↑ +18.4%</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Cart Additions</div>
                    <div class="dt-ana-val"><?php echo $prod['cart_adds']; ?></div>
                    <small style="color:#15803D; font-weight:700;">17.4% Rate</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Units Sold</div>
                    <div class="dt-ana-val"><?php echo $prod['sold']; ?></div>
                    <small style="color:#15803D; font-weight:700;">High Volume</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Total Revenue</div>
                    <div class="dt-ana-val"><?php echo $prod['revenue']; ?></div>
                    <small style="color:#8A681F; font-weight:700;">B2B + B2C</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Gross Profit</div>
                    <div class="dt-ana-val"><?php echo $prod['profit']; ?></div>
                    <small style="color:#15803D; font-weight:700;">35.1% Margin</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Customer Rating</div>
                    <div class="dt-ana-val" style="color:#DBA617;"><?php echo $prod['rating']; ?></div>
                    <small style="color:#7A7266; font-weight:700;"><?php echo $prod['reviews']; ?></small>
                </div>
            </div>

            <!-- Inspection Grid -->
            <div class="dt-view-grid">
                <!-- Left Sticky Preview Card -->
                <div class="dt-view-sticky-card">
                    <img src="<?php echo $prod['image']; ?>" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:100%; height:260px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7;" alt="<?php echo htmlspecialchars($prod['name']); ?>">
                    
                    <div style="margin-top:14px;">
                        <h4 style="font-size:13.5px; font-weight:700; color:#1d2327; margin:0 0 6px 0;">Multi-Tier Pricing</h4>
                        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:4px; padding:10px;">
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
                            <div style="height:6px; background:#e0e0e0; border-radius:3px; margin-top:6px; overflow:hidden;">
                                <div style="width:<?php echo $prod['stock_pct']; ?>; height:100%; background:<?php echo $prod['stock_color']; ?>;"></div>
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
                            <tr><td style="width:140px; padding:6px 0; color:#646970; font-weight:600;">Product Name:</td><td><strong><?php echo htmlspecialchars($prod['name']); ?></strong></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">SKU Code:</td><td><code><?php echo htmlspecialchars($prod['sku']); ?></code></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">Barcode:</td><td><code><?php echo htmlspecialchars($prod['barcode']); ?></code></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">Category:</td><td><a href="/Frontend/Admin/products/categories/" style="color:#2271b1; text-decoration:none;"><?php echo htmlspecialchars($prod['category']); ?></a></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">Brand / Collection:</td><td><strong><?php echo htmlspecialchars($prod['brand']); ?></strong></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">Fabric Material:</td><td><?php echo htmlspecialchars($prod['fabric']); ?></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">Saree / Dress Length:</td><td><?php echo htmlspecialchars($prod['length']); ?></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">HSN Code &amp; GST:</td><td><code><?php echo htmlspecialchars($prod['hsn']); ?></code></td></tr>
                        </table>
                    </div>

                    <!-- Audit Timeline Card -->
                    <div style="background:#fff; border:1px solid #c3c4c7; border-radius:4px; padding:16px;">
                        <h3 style="font-size:14px; font-weight:700; color:#1d2327; margin:0 0 12px 0; border-bottom:1px solid #f0f0f1; padding-bottom:6px; display:flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>Product Activity &amp; Audit Trail</span>
                        </h3>
                        <div class="dt-timeline">
                            <div class="dt-timeline-item">
                                <div class="dt-timeline-dot"></div>
                                <div style="font-size:12.5px; font-weight:600; color:#1d2327;">Stock Dispatched (-25 pcs) for Wholesale Consignment #ORD-9842</div>
                                <div class="dt-timeline-meta">By Gautam Sethi (Super Admin) • Today, 11:20 AM</div>
                            </div>
                            <div class="dt-timeline-item">
                                <div class="dt-timeline-dot"></div>
                                <div style="font-size:12.5px; font-weight:600; color:#1d2327;">Wholesale MOQ Price Updated to <?php echo $prod['wholesale_price']; ?></div>
                                <div class="dt-timeline-meta">By Gautam Sethi (Super Admin) • Yesterday, 04:15 PM</div>
                            </div>
                            <div class="dt-timeline-item">
                                <div class="dt-timeline-dot"></div>
                                <div style="font-size:12.5px; font-weight:600; color:#1d2327;">Product Created &amp; Published to Online Catalog</div>
                                <div class="dt-timeline-meta">By Surat Catalog Team • 10 Aug 2026</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
