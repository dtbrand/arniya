<?php
/**
 * view.php — Category Details & Filtered Products Catalogue
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../../../src/ProductCatalog.php';
require_once __DIR__ . '/../../../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$page_title = "Category Overview";
$active_nav = "products";
$active_subnav = "categories";

$catId = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$category = null;

$db = Database::getConnection();
if ($db !== null && !Database::isMockMode()) {
    try {
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$catId]);
        $category = $stmt->fetch(\PDO::FETCH_ASSOC);
    } catch (\Exception $e) {}
}

if (!$category) {
    header('Location: /Frontend/Admin/products/categories/');
    exit;
}

$catName = $category['name'];
$catSlug = $category['slug'] ?? strtolower(str_replace(' ', '-', $catName));
$catDesc = $category['description'] ?? '';

$productsList = ProductCatalog::filter(['category' => $catName]);
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/products.css?v=<?php echo time(); ?>">
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
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline">Category: <?php echo htmlspecialchars($catName); ?></h1>
                    <span class="wp-page-title-action gold" style="font-weight:700;"><?php echo $prodCount; ?> Products</span>
                    <a href="/Frontend/Admin/products/categories/" class="wp-page-title-action secondary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back to Categories</span>
                    </a>
                </div>
                <div>
                    <a href="/Frontend/Admin/products/categories/edit.php?id=<?php echo $catId; ?>" class="wp-button primary">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <span>Edit Category</span>
                    </a>
                </div>
            </div>

            <!-- Meta Card -->
            <div style="background:#fff; border:1px solid #c3c4c7; padding:12px 16px; border-radius:3px; margin-bottom:14px; display:flex; align-items:center; gap:16px;">
                <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:54px; height:54px; object-fit:cover; border:1px solid #c3c4c7; border-radius:3px;" alt="<?php echo htmlspecialchars($catName); ?>">
                <div>
                    <h3 style="font-size:14px; font-weight:700; color:#1d2327; margin:0 0 2px 0;"><?php echo htmlspecialchars($catDesc); ?></h3>
                    <p style="font-size:12px; color:#646970; margin:0;">Slug: <code><?php echo htmlspecialchars($catSlug); ?></code> • HSN Code: <strong>5007 (5% GST)</strong> • Display Type: <strong>Default</strong></p>
                </div>
            </div>

            <!-- Filtered Products Table -->
            <div class="wp-table-card">
                <div class="wp-tablenav" style="padding: 6px 8px; margin: 0; border-bottom: 1px solid #c3c4c7; background: #f6f7f7;">
                    <span style="font-size:12px; font-weight:600; color:#2c3338;">Products in "<?php echo htmlspecialchars($catName); ?>" (<?php echo $prodCount; ?> items)</span>
                </div>
                <?php include_once __DIR__ . '/../components/product-table.php'; ?>
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
