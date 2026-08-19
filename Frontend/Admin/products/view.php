<?php
/**
 * view.php — Next-Level Product Overview & Analytics Suite
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Product Overview";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanjivaram Pure Silk Gold Zari Saree ‹ Product Overview</title>
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
            
            <!-- WordPress Heading & Action Bar -->
            <div class="wp-heading-wrap" style="justify-content: space-between; border-bottom: 1px solid #c3c4c7; padding-bottom: 10px; margin-bottom: 14px;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <h1 class="wp-heading-inline">Kanjivaram Pure Silk Gold Zari Saree</h1>
                    <span class="adm-badge success">Active in Shop</span>
                    <a href="/Frontend/Admin/products/" class="wp-page-title-action secondary">← Back to Catalog</a>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">
                    <button type="button" class="wp-button" onclick="window.shareProductWhatsApp(101)">WhatsApp Share</button>
                    <a href="/Frontend/Admin/products/duplicate.php?id=101" class="wp-button">Duplicate</a>
                    <a href="/Frontend/Admin/products/edit.php?id=101" class="wp-button primary">Edit Product</a>
                </div>
            </div>

            <!-- Analytics KPIs Grid -->
            <div class="dt-analytics-kpi-grid">
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Total Views</div>
                    <div class="dt-ana-val">4,820</div>
                    <small style="color:#15803D; font-weight:700;">↑ +18.4%</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Cart Additions</div>
                    <div class="dt-ana-val">842</div>
                    <small style="color:#15803D; font-weight:700;">17.4% Rate</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Units Sold</div>
                    <div class="dt-ana-val">142 pcs</div>
                    <small style="color:#15803D; font-weight:700;">High Volume</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Total Revenue</div>
                    <div class="dt-ana-val">₹4,04,700</div>
                    <small style="color:#8A681F; font-weight:700;">B2B + B2C</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Gross Profit</div>
                    <div class="dt-ana-val">₹1,42,000</div>
                    <small style="color:#15803D; font-weight:700;">35.1% Margin</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Customer Rating</div>
                    <div class="dt-ana-val" style="color:#DBA617;">5.0 ★</div>
                    <small style="color:#7A7266; font-weight:700;">128 Reviews</small>
                </div>
            </div>

            <!-- Inspection Grid -->
            <div class="dt-view-grid">
                <!-- Left Sticky Preview Card -->
                <div class="dt-view-sticky-card">
                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:100%; height:260px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7;" alt="Product">
                    
                    <div style="margin-top:14px;">
                        <h4 style="font-size:14px; font-weight:700; color:#1d2327; margin:0 0 6px 0;">Multi-Tier Pricing</h4>
                        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:4px; padding:10px;">
                            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px;">
                                <span>Retail Price:</span>
                                <strong>₹4,490</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; color:#7E22CE;">
                                <span>Reseller Price:</span>
                                <strong>₹3,450</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12.5px; font-weight:700; color:#8A681F; border-top:1px solid rgba(212,175,55,0.3); padding-top:4px;">
                                <span>Wholesale B2B:</span>
                                <strong>₹2,850/pc (MOQ: 8)</strong>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:14px;">
                        <h4 style="font-size:13px; font-weight:700; color:#1d2327; margin:0 0 6px 0;">Warehouse Stock</h4>
                        <div style="background:#f6f7f7; border:1px solid #c3c4c7; border-radius:4px; padding:10px;">
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span>Current Available:</span>
                                <strong style="color:#15803D;">45 units</strong>
                            </div>
                            <div style="height:6px; background:#e0e0e0; border-radius:3px; margin-top:6px; overflow:hidden;">
                                <div style="width:75%; height:100%; background:#15803D;"></div>
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
                            <tr><td style="width:140px; padding:6px 0; color:#646970; font-weight:600;">Product Name:</td><td><strong>Kanjivaram Pure Silk Gold Zari Saree</strong></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">SKU Code:</td><td><code>KLN-SR-111</code></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">Barcode:</td><td><code>8901234500111</code></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">Category:</td><td><a href="/Frontend/Admin/products/categories/" style="color:#2271b1; text-decoration:none;">Silk Sarees</a></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">Brand / Collection:</td><td><strong>DT Signature (Arniya Heritage)</strong></td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">Fabric Material:</td><td>100% Pure Mulberry Silk with 24K Gold Zari Weave</td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">Saree Length:</td><td>6.3 Meters (Includes 0.8m Running Blouse Piece)</td></tr>
                            <tr><td style="padding:6px 0; color:#646970; font-weight:600;">HSN Code &amp; GST:</td><td><code>5007</code> (5% GST Rate)</td></tr>
                        </table>
                    </div>

                    <!-- Audit Timeline Card -->
                    <div style="background:#fff; border:1px solid #c3c4c7; border-radius:4px; padding:16px;">
                        <h3 style="font-size:14px; font-weight:700; color:#1d2327; margin:0 0 12px 0; border-bottom:1px solid #f0f0f1; padding-bottom:6px;">Audit Trail &amp; Activity Log</h3>
                        <div class="dt-timeline">
                            <div class="dt-timeline-item">
                                <div class="dt-timeline-dot"></div>
                                <div style="font-size:12.5px; font-weight:600; color:#1d2327;">Product Updated by Gautam Sethi</div>
                                <div class="dt-timeline-meta">Today at 11:20 AM • Adjusted wholesale price to ₹2,850/pc</div>
                            </div>
                            <div class="dt-timeline-item">
                                <div class="dt-timeline-dot"></div>
                                <div style="font-size:12.5px; font-weight:600; color:#1d2327;">Stock Restocked (+20 units)</div>
                                <div class="dt-timeline-meta">Yesterday at 04:15 PM • Received from Kanchipuram Weaving Unit</div>
                            </div>
                            <div class="dt-timeline-item">
                                <div class="dt-timeline-dot"></div>
                                <div style="font-size:12.5px; font-weight:600; color:#1d2327;">SKU Created &amp; Published</div>
                                <div class="dt-timeline-meta">2026/08/01 • Initial catalogue listing</div>
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
