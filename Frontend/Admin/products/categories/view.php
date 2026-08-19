<?php
/**
 * view.php — Category Details & Filtered Products Catalogue
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Category Overview";
$active_nav = "products";
$active_subnav = "categories";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category: Silk Sarees ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 12px 16px;">

            <!-- Header -->
            <div class="wp-heading-wrap" style="justify-content: space-between;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <h1 class="wp-heading-inline">Category: Silk Sarees</h1>
                    <span class="wp-page-title-action gold" style="font-weight:700;">420 Products</span>
                    <a href="/Frontend/Admin/products/categories/" class="wp-page-title-action secondary">← Back to Categories</a>
                </div>
                <div>
                    <a href="/Frontend/Admin/products/categories/edit.php?id=1" class="wp-button primary">Edit Category</a>
                </div>
            </div>

            <!-- Meta Card -->
            <div style="background:#fff; border:1px solid #c3c4c7; padding:12px 16px; border-radius:3px; margin-bottom:14px; display:flex; align-items:center; gap:16px;">
                <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:54px; height:54px; object-fit:cover; border:1px solid #c3c4c7; border-radius:3px;" alt="Silk Sarees">
                <div>
                    <h3 style="font-size:14px; font-weight:700; color:#1d2327; margin:0 0 2px 0;">Pure Mulberry &amp; Kanjivaram Bridal Silks</h3>
                    <p style="font-size:12px; color:#646970; margin:0;">Slug: <code>silk-sarees</code> • HSN Code: <strong>5007 (5% GST)</strong> • Display Type: <strong>Default</strong></p>
                </div>
            </div>

            <!-- Filtered Products Table -->
            <div class="wp-table-card">
                <div class="wp-tablenav" style="padding: 6px 8px; margin: 0; border-bottom: 1px solid #c3c4c7; background: #f6f7f7;">
                    <span style="font-size:12px; font-weight:600; color:#2c3338;">Products in "Silk Sarees" (420 items)</span>
                </div>
                <?php include_once __DIR__ . '/../components/product-table.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
