<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * categories/view.php — Category Deep Details, Analytics & Linked Products
 * DT Brand's & Jai Hanuman Tex
 *
 * The previous revision rendered one of six hard-coded demo categories
 * ("420 SKUs", "24,580 views", "+18.4% growth") regardless of which category
 * id was opened. Every number now comes from the live `categories` and
 * `products` tables; when a metric has no source (page views are not tracked
 * yet) the card says so instead of inventing a figure.
 */
require_once __DIR__ . '/../../../src/Database.php';
require_once __DIR__ . '/../../../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

$page_title = "Category Details";
$active_nav = "catalogue";
$active_subnav = "categories";
$cat_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$cat = null;
$pdoCat = Database::getConnection();
if ($pdoCat !== null && !Database::isMockMode() && $cat_id > 0) {
    try {
        $rows = Database::query('SELECT * FROM categories WHERE id = ? LIMIT 1', [$cat_id]);
        if (!empty($rows)) {
            $cat = $rows[0];
        }
    } catch (\Throwable $e) {
        $cat = null;
    }
}

if ($cat === null) {
    $cat = [
        'id' => $cat_id,
        'name' => 'Unknown category',
        'slug' => '',
        'description' => '',
        'image' => '',
        'status' => 'inactive',
        'display_order' => 0,
    ];
}

// Live product counts for this category — computed, never fabricated.
$catSkuCount = 0;
$catValuation = 0.0;
$catStockUnits = 0;
if ($pdoCat !== null && !Database::isMockMode() && $cat_id > 0) {
    try {
        $agg = Database::fetchOne(
            'SELECT COUNT(*) AS c, COALESCE(SUM(stock_qty * wholesale_price),0) AS v, COALESCE(SUM(stock_qty),0) AS u
             FROM products WHERE category_id = ?',
            [$cat_id]
        );
        $catSkuCount = (int)($agg['c'] ?? 0);
        $catValuation = (float)($agg['v'] ?? 0);
        $catStockUnits = (int)($agg['u'] ?? 0);
    } catch (\Throwable $e) {
        // keep zeros
    }
}
$catSubcatCount = 0;
if ($pdoCat !== null && !Database::isMockMode() && $cat_id > 0) {
    try {
        $sc = Database::fetchOne('SELECT COUNT(*) AS c FROM subcategories WHERE category_id = ?', [$cat_id]);
        $catSubcatCount = (int)($sc['c'] ?? 0);
    } catch (\Throwable $e) {
        // keep zero
    }
}

$valuationTxt = $catValuation >= 100000
    ? ('₹' . number_format($catValuation / 100000, 2) . ' Lakhs')
    : ('₹' . number_format($catValuation, 2));
$catImageUrl = (string)($cat['image'] ?? '');
if ($catImageUrl === '') {
    $catImageUrl = '/assets/images/no-image.svg';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details: <?php echo htmlspecialchars((string)$cat['name']); ?> ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/categories.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/merchandising.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <img src="<?php echo htmlspecialchars($catImageUrl); ?>" onerror="this.onerror=null; this.src='/assets/images/no-image.svg';" style="width:48px; height:48px; border-radius:6px; object-fit:cover; border:1px solid #D4AF37;">
                    <div>
                        <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;"><?php echo htmlspecialchars((string)$cat['name']); ?></h1>
                        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">Slug: <code>/shop/<?php echo htmlspecialchars((string)$cat['slug']); ?></code> • <?php echo (int)$catSkuCount ?> Active SKUs</div>
                    </div>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/admin/catalogue/categories/edit.php?id=<?php echo (int)$cat_id; ?>" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">Edit Category</a>
                    <a href="/admin/catalogue/categories/" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">Back to Categories</a>
                </div>
            </div>

            <!-- Mini KPI Cards for Category -->
            <div class="dt-cat-kpi-grid">
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">LINKED PRODUCTS</div>
                        <div class="dt-cat-kpi-val"><?php echo (int)$catSkuCount ?> SKUs</div>
                        <div class="dt-cat-kpi-sub" style="color:#15803D;"><?php echo (int)$catStockUnits ?> units in stock</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">SUBCATEGORIES</div>
                        <div class="dt-cat-kpi-val"><?php echo (int)$catSubcatCount ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#1D4ED8;">live rows in subcategories table</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">CATEGORY VALUATION</div>
                        <div class="dt-cat-kpi-val"><?php echo htmlspecialchars($valuationTxt); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#8A681F;">stock × wholesale price</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">PAGE VIEWS (30 DAYS)</div>
                        <div class="dt-cat-kpi-val">—</div>
                        <div class="dt-cat-kpi-sub" style="color:#64748B;">view tracking not yet wired (see AI/KNOWN_ISSUES.md)</div>
                    </div>
                </div>
            </div>

            <!-- Linked Merchandising Section -->
            <?php
            $cat_name = (string)$cat['name'];
            include_once __DIR__ . '/../components/merchandising-panel.php';
            ?>

            <!-- SEO Preview Section -->
            <?php include_once __DIR__ . '/../components/seo-panel.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/admin/catalogue/assets/js/categories.js?v=<?php echo time(); ?>"></script>
</body>
</html>