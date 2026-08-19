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
            
            <!-- WordPress Heading & Real SVG Action Bar -->
            <div class="wp-heading-wrap" style="justify-content: space-between; border-bottom: 1px solid #c3c4c7; padding-bottom: 10px; margin-bottom: 14px;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline">Kanjivaram Pure Silk Gold Zari Saree</h1>
                    <span class="adm-badge success">Active in Catalog</span>
                    <a href="/Frontend/Admin/products/" class="wp-page-title-action secondary">← Back to Catalog</a>
                </div>
                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <button type="button" class="wp-button" onclick="window.shareProductWhatsApp(101)" title="Share on WhatsApp">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" style="color:#25D366;"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>WhatsApp Share</span>
                    </button>
                    <a href="/Frontend/Admin/products/duplicate.php?id=101" class="wp-button">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span>Duplicate</span>
                    </a>
                    <button type="button" class="wp-button" onclick="window.showToast('Product archived');">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                        <span>Archive</span>
                    </button>
                    <a href="/Frontend/Admin/products/edit.php?id=101" class="wp-button primary">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <span>Edit Product</span>
                    </a>
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
                        <h4 style="font-size:13.5px; font-weight:700; color:#1d2327; margin:0 0 6px 0;">Multi-Tier Pricing</h4>
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
                        <h3 style="font-size:14px; font-weight:700; color:#1d2327; margin:0 0 12px 0; border-bottom:1px solid #f0f0f1; padding-bottom:6px; display:flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>Audit Trail &amp; Activity Log</span>
                        </h3>
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
