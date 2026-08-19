<?php
/**
 * view.php — Comprehensive Product Overview, Analytics & Audit Trail
 */
$page_title = "Product Overview";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Overview — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/products.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/product-view.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1>
                        <span>Kanjivaram Pure Silk Gold Zari Saree</span>
                        <span class="adm-badge success">Active in Catalog</span>
                    </h1>
                    <p>SKU: <strong>KLN-SR-111</strong> • Category: <strong>Silk Sarees</strong> • Fabric: <strong>Pure Mulberry Silk</strong></p>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Catalog</a>
                    <a href="/Frontend/Admin/products/duplicate.php?id=101" class="adm-btn-secondary">📋 Duplicate</a>
                    <button type="button" class="adm-btn-secondary" onclick="window.showToast('Archived SKU');">📦 Archive</button>
                    <a href="/Frontend/Admin/products/edit.php?id=101" class="adm-btn-primary">✏️ Edit Product</a>
                </div>
            </div>

            <!-- Product Analytics KPIs (Views, Cart, Orders, Revenue) -->
            <div class="dt-analytics-kpi-grid">
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Total Views</div>
                    <div class="dt-ana-val">4,820</div>
                    <small style="color:#15803D; font-weight:700;">↑ +18.4%</small>
                </div>
                <div class="dt-ana-card">
                    <div class="dt-ana-lbl">Cart Adds</div>
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
                    <div class="dt-ana-lbl">Wishlists</div>
                    <div class="dt-ana-val">380</div>
                    <small style="color:#8A681F; font-weight:700;">High Intent</small>
                </div>
            </div>

            <!-- Main Layout Grid -->
            <div class="dt-view-grid">
                <!-- Sticky Product Profile Card -->
                <div class="dt-view-sticky-card">
                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:100%; border-radius:8px; margin-bottom:14px;" alt="Product">
                    <div style="font-size:1.2rem; font-weight:800; color:#181512; margin-bottom:4px;">₹4,490 <small style="color:#7A7266; font-size:0.8rem;">(Retail)</small></div>
                    <div style="font-size:0.95rem; font-weight:800; color:#8A681F; margin-bottom:12px;">₹2,850/pc <small style="color:#7A7266; font-size:0.75rem;">(Wholesale MOQ 8)</small></div>
                    <p style="font-size:0.82rem; color:#7A7266; margin-bottom:14px;">Stock: <strong>45 units</strong> in Surat Central Hub</p>
                    <button type="button" class="adm-btn-primary" style="width:100%; justify-content:center;" onclick="window.shareProductWhatsApp(101)">💬 Share via WhatsApp</button>
                </div>

                <!-- Product Deep Breakdown -->
                <div>
                    <!-- Activity Timeline -->
                    <?php include_once __DIR__ . '/components/product-activity.php'; ?>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
