<?php
/**
 * edit.php — Dynamic Product Edit Studio (WordPress & WooCommerce Style)
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Edit Product";
$active_nav = "products";

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 101;

$catalog_products = [
    101 => ['id' => 101, 'name' => 'Kanjivaram Pure Silk Gold Zari Saree', 'sku' => 'KLN-SR-111', 'category' => 'Silk Sarees', 'brand' => 'DT Signature'],
    102 => ['id' => 102, 'name' => 'Banarasi Royal Brocade Weave Saree', 'sku' => 'BNR-SR-204', 'category' => 'Banarasi Brocade', 'brand' => 'Arniya Heritage'],
    103 => ['id' => 103, 'name' => 'Crimson Bridal Handcrafted Zardosi Lehenga', 'sku' => 'BRD-LH-902', 'category' => 'Bridal Lehengas', 'brand' => 'DT Couture'],
    104 => ['id' => 104, 'name' => 'Chanderi Foil Printed Festive Kurti Set', 'sku' => 'KRT-CH-440', 'category' => 'Designer Kurtis', 'brand' => 'DT Signature']
];

$prod = isset($catalog_products[$product_id]) ? $catalog_products[$product_id] : $catalog_products[101];
$edit_product_name = $prod['name'];
$edit_sku = $prod['sku'];
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
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline">Edit Product</h1>
                    <span class="wp-page-title-action gold" style="font-weight:700;">SKU: <?php echo htmlspecialchars($prod['sku']); ?></span>
                    <a href="/Frontend/Admin/products/add.php" class="wp-page-title-action secondary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add New</span>
                    </a>
                    <a href="/Frontend/Admin/products/" class="wp-page-title-action secondary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back to Catalog</span>
                    </a>
                </div>
                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <a href="/Frontend/Admin/products/view.php?id=<?php echo $prod['id']; ?>" class="wp-button">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>View Details</span>
                    </a>
                    <button type="button" class="wp-button" onclick="window.open('/Frontend/Single-Product/singleproduct.php?id=<?php echo $prod['id']; ?>', '_blank')">Preview Storefront</button>
                    <button type="button" class="wp-button primary" onclick="window.showToast('✨ Product updated successfully!')">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Update Product</span>
                    </button>
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
<script src="/Frontend/Admin/products/assets/js/product-gallery.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/products/assets/js/product-form.js?v=<?php echo time(); ?>"></script>
</body>
</html>
