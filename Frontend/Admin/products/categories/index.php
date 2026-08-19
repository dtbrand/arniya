<?php
$page_title = "Categories Management";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/categories.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Categories Management</span><span class="adm-badge gold">16 Taxonomies</span></h1>
                    <p>Manage textile category collections, HSN codes, and sub-category associations.</p>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products</a>
                    <a href="/Frontend/Admin/products/categories/add.php" class="adm-btn-primary">+ Add Category</a>
                </div>
            </div>

            <div class="dt-cat-grid">
                <div class="dt-cat-card">
                    <div class="dt-cat-icon">👗</div>
                    <div style="flex:1;">
                        <h4 style="font-weight:800; font-size:1rem;">Silk Sarees</h4>
                        <p style="font-size:0.75rem; color:#7A7266;">420 SKUs • HSN: 5007 (5% GST)</p>
                    </div>
                    <a href="/Frontend/Admin/products/categories/edit.php?id=1" class="adm-btn-secondary adm-btn-sm">Edit</a>
                </div>
                <div class="dt-cat-card">
                    <div class="dt-cat-icon">✨</div>
                    <div style="flex:1;">
                        <h4 style="font-weight:800; font-size:1rem;">Banarasi Brocade</h4>
                        <p style="font-size:0.75rem; color:#7A7266;">280 SKUs • HSN: 5007 (5% GST)</p>
                    </div>
                    <a href="/Frontend/Admin/products/categories/edit.php?id=2" class="adm-btn-secondary adm-btn-sm">Edit</a>
                </div>
                <div class="dt-cat-card">
                    <div class="dt-cat-icon">👑</div>
                    <div style="flex:1;">
                        <h4 style="font-weight:800; font-size:1rem;">Bridal Lehengas</h4>
                        <p style="font-size:0.75rem; color:#7A7266;">160 SKUs • HSN: 6204 (12% GST)</p>
                    </div>
                    <a href="/Frontend/Admin/products/categories/edit.php?id=3" class="adm-btn-secondary adm-btn-sm">Edit</a>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
