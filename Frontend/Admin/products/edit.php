<?php
/**
 * edit.php — Edit Product Specifications & Live Pricing
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
    <title>Edit Product — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/products.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/product-form.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/variants.css?v=<?php echo time(); ?>">
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
                        <span>Edit Product</span>
                        <span class="adm-badge gold">KLN-SR-111</span>
                    </h1>
                    <p>Editing Kanjivaram Pure Silk Gold Zari Saree.</p>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/view.php?id=101" class="adm-btn-secondary">👁️ View Product</a>
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">Cancel</a>
                    <button type="button" class="adm-btn-secondary" onclick="window.showToast('Previewing in new tab...'); window.open('/Frontend/Single-Product/singleproduct.php?id=101', '_blank');">👁️ Preview Shop</button>
                    <button type="button" class="adm-btn-primary" onclick="window.showToast('Product changes saved successfully!')">Save Changes</button>
                </div>
            </div>

            <!-- Form Content -->
            <div class="dt-form-grid-layout">
                <div>
                    <?php include_once __DIR__ . '/components/product-form.php'; ?>
                    <?php include_once __DIR__ . '/components/product-gallery.php'; ?>
                    <?php include_once __DIR__ . '/components/product-pricing.php'; ?>
                    <?php include_once __DIR__ . '/components/product-variants.php'; ?>
                    <?php include_once __DIR__ . '/components/product-seo.php'; ?>
                </div>
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
<script src="/Frontend/Admin/products/assets/js/product-gallery.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/products/assets/js/variants.js?v=<?php echo time(); ?>"></script>
</body>
</html>
