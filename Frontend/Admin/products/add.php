<?php
/**
 * add.php — Multi-Section Add Product Studio
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Add Product";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product — DT Brand's Admin</title>
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
                        <span>Add Product</span>
                        <span class="adm-badge gold">New SKU</span>
                    </h1>
                    <p>Create a new textile product with multi-tier pricing, media gallery, and variant matrices.</p>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">Cancel</a>
                    <button type="button" class="adm-btn-secondary" onclick="window.showToast('Draft saved successfully!')">Save Draft</button>
                    <button type="button" class="adm-btn-primary" onclick="window.showToast('✨ Product published to live catalog!')">Save & Publish</button>
                </div>
            </div>

            <div class="dt-form-grid-layout">
                <!-- Left Main Column -->
                <div>
                    <!-- 1. Basic Information -->
                    <?php include_once __DIR__ . '/components/product-form.php'; ?>

                    <!-- 2. Product Media Upload -->
                    <?php include_once __DIR__ . '/components/product-gallery.php'; ?>

                    <!-- 3. Multi-Tier Pricing -->
                    <?php include_once __DIR__ . '/components/product-pricing.php'; ?>

                    <!-- 4. Variants Matrix -->
                    <?php include_once __DIR__ . '/components/product-variants.php'; ?>

                    <!-- 5. SEO Section -->
                    <?php include_once __DIR__ . '/components/product-seo.php'; ?>
                </div>

                <!-- Right Sidebar Column -->
                <div>
                    <!-- Visibility & Publishing -->
                    <?php include_once __DIR__ . '/components/product-status.php'; ?>

                    <!-- Inventory Section -->
                    <?php include_once __DIR__ . '/components/product-inventory.php'; ?>

                    <!-- Shipping Section -->
                    <?php include_once __DIR__ . '/components/product-shipping.php'; ?>

                    <!-- Permissions Gate -->
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
