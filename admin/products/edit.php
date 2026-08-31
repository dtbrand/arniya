<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * edit.php — Dynamic Product Edit Studio (WordPress & WooCommerce Style)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$page_title = "Edit Product";
$active_nav = "products";

// A missing id used to fall back to intval(null) = 1, then to "the first product
// in the catalogue", then to a hardcoded Kanjivaram row. Editing ?id=9999 opened
// a DIFFERENT product with its real id in #pFormId, so pressing Update silently
// overwrote whichever product happened to be first.
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$prod = $product_id > 0 ? ProductCatalog::getById($product_id) : null;
if (!$prod) {
    http_response_code(404);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">'
        . '<title>Product not found</title>'
        . '<link rel="stylesheet" href="/admin/assets/css/admin.css"></head><body>'
        . '<div style="max-width:520px;margin:80px auto;padding:22px;border:1px solid #c3c4c7;background:#fff;'
        . 'font-family:system-ui,sans-serif;">'
        . '<h1 style="font-size:18px;margin:0 0 8px;">Product not found</h1>'
        . '<p style="font-size:13px;color:#646970;margin:0 0 14px;">No product exists with id '
        . htmlspecialchars((string)$product_id) . '. Nothing was loaded, so nothing can be overwritten.</p>'
        . '<a href="/admin/products/" style="font-size:13px;font-weight:700;color:#8A681F;">Back to the catalogue</a>'
        . '</div></body></html>';
    exit;
}

$edit_product_name = $prod['title'] ?? $prod['name'];
$edit_sku = $prod['sku'] ?? '';
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
                    <h1 class="wp-heading-inline">Edit Product</h1>
                    <span class="wp-page-title-action gold" style="font-weight:700;">SKU: <?php echo htmlspecialchars($prod['sku']); ?></span>
                    <a href="/admin/products/add.php" class="wp-page-title-action secondary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add New</span>
                    </a>
                    <a href="/admin/products/" class="wp-page-title-action secondary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back to Catalog</span>
                    </a>
                </div>
                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <a href="/product.php?id=<?php echo (int)$prod['id']; ?>" target="_blank" class="wp-button">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>Preview Storefront</span>
                    </a>
                    <button type="button" class="wp-button primary dt-btn-gold" data-dt-save onclick="saveProductToDatabase(false, <?php echo (int)$prod['id']; ?>)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Update Product</span>
                    </button>
                </div>
            </div>

            <input type="hidden" id="pFormId" value="<?php echo $prod['id']; ?>">

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
<script>
// The edit form used to open with an empty media panel and empty variants even
// when the product had both in the database, so pressing Update wiped them.
window.DT_PRODUCT = <?php echo json_encode([
    // 'images'/'has_photo', not 'image'/'gallery': those two substitute the
    // no-image placeholder for a product with no photos, and prefilling that
    // would post the placeholder back as if it were a real cover photo.
    'primary_image' => !empty($prod['has_photo']) ? ($prod['image'] ?? '') : '',
    'gallery'       => array_values($prod['images'] ?? []),
    'videos'        => array_values($prod['videos'] ?? []),
    'embeds'        => array_values($prod['embed_links'] ?? []),
    'variants'      => array_values($prod['variants'] ?? []),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.dtPrefillMedia === 'function') { window.dtPrefillMedia(window.DT_PRODUCT); }
    if (typeof window.dtPrefillVariants === 'function') { window.dtPrefillVariants(window.DT_PRODUCT.variants); }
});
</script>
</body>
</html>
