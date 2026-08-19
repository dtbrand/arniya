<?php
/**
 * edit.php — Next-Level Product Edit Studio (WordPress & WooCommerce Style)
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Edit Product";
$active_nav = "products";
$edit_product_name = "Kanjivaram Pure Silk Gold Zari Saree";
$edit_sku = "KLN-SR-111";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/product-form.css?v=<?php echo time(); ?>">
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
                    <h1 class="wp-heading-inline">Edit Product</h1>
                    <span class="wp-page-title-action gold" style="font-weight:700;">SKU: KLN-SR-111</span>
                    <a href="/Frontend/Admin/products/add.php" class="wp-page-title-action secondary">+ Add New</a>
                    <a href="/Frontend/Admin/products/" class="wp-page-title-action secondary">← Back to Catalog</a>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">
                    <a href="/Frontend/Admin/products/view.php?id=101" class="wp-button">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>View Details</span>
                    </a>
                    <button type="button" class="wp-button" onclick="window.open('/Frontend/Single-Product/singleproduct.php?id=101', '_blank')">Preview Storefront</button>
                    <button type="button" class="wp-button primary" onclick="window.showToast('✨ Product updated successfully!')">Update Product</button>
                </div>
            </div>

            <!-- Multi-Section Form Grid -->
            <div class="dt-form-grid-layout">
                <!-- Left Column -->
                <div>
                    <?php include_once __DIR__ . '/components/product-form.php'; ?>
                    <?php include_once __DIR__ . '/components/product-gallery.php'; ?>
                    <?php include_once __DIR__ . '/components/product-pricing.php'; ?>
                    <?php include_once __DIR__ . '/components/product-variants.php'; ?>
                    <?php include_once __DIR__ . '/components/product-seo.php'; ?>
                </div>

                <!-- Right Column -->
                <div>
                    <?php include_once __DIR__ . '/components/product-status.php'; ?>
                    <?php include_once __DIR__ . '/components/product-inventory.php'; ?>
                    <?php include_once __DIR__ . '/components/product-shipping.php'; ?>
                    <?php include_once __DIR__ . '/components/product-permissions.php'; ?>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/products/assets/js/product-form.js?v=<?php echo time(); ?>"></script>
</body>
</html>
