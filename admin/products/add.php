<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * add.php — Multi-Section Add Product Studio
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$page_title = "Add Product";
$active_nav = "products";
$active_subnav = "add";

$cloned_id = isset($_GET['cloned_from']) ? intval($_GET['cloned_from']) : 0;
$prod = null;
if ($cloned_id > 0) {
    $orig = ProductCatalog::getById($cloned_id);
    if ($orig) {
        $prod = $orig;
        $prod['id'] = 0;
        $prod['title'] = ($orig['title'] ?? $orig['name']) . ' (Copy)';
        $prod['sku'] = ($orig['sku'] ?? 'SKU') . '-COPY';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/product-form.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/variants.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 12px 16px;">
            
            <!-- WordPress Heading & Action Bar -->
            <div class="wp-heading-wrap" style="justify-content: space-between; border-bottom: 1px solid #c3c4c7; padding-bottom: 10px; margin-bottom: 14px;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline">Add New Product</h1>
                    <span class="wp-page-title-action gold" style="font-weight:700;">NEW SKU</span>
                    <a href="/admin/products/" class="wp-page-title-action secondary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>All Products</span>
                    </a>
                </div>
                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <a href="/admin/products/" class="wp-button">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        <span>Cancel</span>
                    </a>
                    <button type="button" class="wp-button" data-dt-save onclick="window.saveProductToDatabase && window.saveProductToDatabase(true);">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        <span>Save Draft</span>
                    </button>
                    <button type="button" class="wp-button primary" data-dt-save onclick="window.saveProductToDatabase && window.saveProductToDatabase(false);">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Save &amp; Publish</span>
                    </button>
                </div>
            </div>

            <!-- Multi-Section Form Grid -->
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
                    <?php include_once __DIR__ . '/components/product-inventory.php'; ?>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/products/assets/js/product-gallery.js?v=<?php echo time(); ?>"></script>
<script src="/admin/products/assets/js/variants.js?v=<?php echo time(); ?>"></script>
<script src="/admin/products/assets/js/product-form.js?v=<?php echo time(); ?>"></script>
</body>
</html>
