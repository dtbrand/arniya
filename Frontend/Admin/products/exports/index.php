<?php
$page_title = "Product Export Studio";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Export — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/products.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Product Export Studio</span></h1>
                    <p>Export catalog data to CSV, Excel, or PDF format with custom field selections.</p>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products</a>
                </div>
            </div>
            <div class="adm-card">
                <div class="adm-card-head"><h3 class="adm-card-title"><span>Select Export Scope & Format</span></h3></div>
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                    <div style="padding:18px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px; text-align:center;">
                        <div style="font-size:2rem; margin-bottom:6px;">📄</div>
                        <strong>Export All 1,240 Products (CSV)</strong>
                        <p style="font-size:0.75rem; color:#7A7266; margin:6px 0 14px;">Includes SKU, retail price, wholesale MOQ rate, stock, and HSN.</p>
                        <button class="adm-btn-primary adm-btn-sm" onclick="window.exportCurrentTable('all_products_catalog')">📥 Download CSV</button>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
