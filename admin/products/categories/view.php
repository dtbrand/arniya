<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * view.php — Category Details & Filtered Products Catalogue
 * DT Brand's & Jai Hanuman Tex
 *
 * $catId used to default to 1, so opening this page without an id showed
 * whichever category came first as though it had been asked for. The meta card
 * always showed /assets/images/product1.png regardless of the stored image, put
 * the description in an <h3> even when there was none, and printed
 * "HSN Code: 5007 (5% GST) - Display Type: Default" for every category —
 * `categories` has neither column.
 */
require_once __DIR__ . '/../../../src/ProductCatalog.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$page_title = "Category Overview";
$active_nav = "products";
$active_subnav = "categories";

$catId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$category = null;
$dbDown = false;

if ($catId > 0) {
    $db = Database::getConnection();
    if ($db === null || Database::isMockMode()) {
        $dbDown = true;
    } else {
        try {
            $stmt = $db->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
            $stmt->execute([$catId]);
            $category = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        } catch (\Exception $e) {
            $dbDown = true;
        }
    }
}

if (!$category) {
    http_response_code($dbDown ? 503 : 404);
    $cvMsg = $dbDown
        ? 'The database is not reachable, so this category could not be loaded.'
        : ($catId > 0
            ? 'Category #' . $catId . ' does not exist.'
            : 'No category id was given.');
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Category not found</title>';
    echo '<link rel="stylesheet" href="/admin/Asset/css/admin.css"></head><body>';
    echo '<div style="max-width:560px;margin:80px auto;padding:28px;border:1.5px solid #D4AF37;border-radius:10px;font-family:system-ui,sans-serif;">';
    echo '<h1 style="font-size:20px;margin:0 0 10px;">Category not found</h1>';
    echo '<p style="color:#646970;">' . htmlspecialchars($cvMsg) . '</p>';
    echo '<p><a href="/admin/products/categories/">Back to product categories</a></p>';
    echo '</div></body></html>';
    exit;
}

$catName = (string)($category['name'] ?? '');
$catSlug = (string)($category['slug'] ?? '');
$catDesc = trim((string)($category['description'] ?? ''));
$catStatus = strtolower(trim((string)($category['status'] ?? 'active'))) === 'inactive' ? 'inactive' : 'active';

$catImg = trim((string)($category['image'] ?? ''));
if ($catImg !== '' && (stripos($catImg, 'data:') === 0 || preg_match('#(category-sarees|hero-banner|product1)\.png$#i', $catImg))) {
    $catImg = '';
}

// Drafts belong in an admin listing, and a product can be attached by id or by
// the denormalised name, so both are accepted.
$productsList = array_values(array_filter(ProductCatalog::getAll(true), static function ($p) use ($catId, $catName) {
    if ((int)($p['category_id'] ?? 0) === $catId && $catId > 0) { return true; }
    return $catName !== '' && strcasecmp((string)($p['category'] ?? ''), $catName) === 0;
}));
$prodCount = count($productsList);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category: <?php echo htmlspecialchars($catName); ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/products.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 12px 16px;">

            <!-- Header -->
            <div class="wp-heading-wrap" style="justify-content: space-between;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline">Category: <?php echo htmlspecialchars($catName); ?></h1>
                    <span class="wp-page-title-action gold" style="font-weight:700;"><?php echo $prodCount; ?> Products</span>
                    <a href="/admin/products/categories/" class="wp-page-title-action secondary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back to Categories</span>
                    </a>
                </div>
                <div>
                    <a href="/admin/products/categories/edit.php?id=<?php echo $catId; ?>" class="wp-button primary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <span>Edit Category</span>
                    </a>
                </div>
            </div>

            <!-- Meta Card -->
            <div style="background:#fff; border:1px solid #c3c4c7; padding:12px 16px; border-radius:3px; margin-bottom:14px; display:flex; align-items:center; gap:16px;">
                <?php if ($catImg !== ''): ?>
                    <img src="<?php echo htmlspecialchars($catImg); ?>" style="width:54px; height:54px; object-fit:cover; border:1px solid #c3c4c7; border-radius:3px;" alt="<?php echo htmlspecialchars($catName); ?>">
                <?php else: ?>
                    <span title="No image set" style="width:54px; height:54px; border:1px dashed #c3c4c7; border-radius:3px; display:flex; align-items:center; justify-content:center; font-size:10px; color:#a7aaad; flex-shrink:0;">no image</span>
                <?php endif; ?>
                <div>
                    <h3 style="font-size:14px; font-weight:700; color:#1d2327; margin:0 0 2px 0;">
                        <?php echo $catDesc !== '' ? htmlspecialchars($catDesc) : '<span style="color:#a7aaad; font-weight:600;">No description saved for this category.</span>'; ?>
                    </h3>
                    <p style="font-size:12px; color:#646970; margin:0;">
                        Slug: <code><?php echo htmlspecialchars($catSlug); ?></code>
                        &bull; Status: <strong style="color:<?php echo $catStatus === 'active' ? '#15803D' : '#646970'; ?>;"><?php echo $catStatus === 'active' ? 'Active' : 'Hidden from the shop'; ?></strong>
                        &bull; <a href="/shop?category=<?php echo urlencode($catSlug); ?>" target="_blank" rel="noopener">View on shop</a>
                    </p>
                </div>
            </div>

            <!-- Filtered Products Table -->
            <div class="wp-table-card">
                <div class="wp-tablenav" style="padding: 6px 8px; margin: 0; border-bottom: 1px solid #c3c4c7; background: #f6f7f7;">
                    <span style="font-size:12px; font-weight:600; color:#2c3338;">Products in "<?php echo htmlspecialchars($catName); ?>" (<?php echo $prodCount; ?> items)</span>
                </div>
                <?php include_once __DIR__ . '/../components/product-table.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>

