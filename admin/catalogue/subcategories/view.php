<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * subcategories/view.php — View Subcategory Details with Master Styles
 * DT Brand's & Jai Hanuman Tex
 *
 * Previously rendered one of five hard-coded demo subcategories regardless
 * of the requested id. Now loads the real `subcategories` row, joins the
 * parent `categories` row, and computes linked-product stats from the live
 * products table. Page-view analytics are not tracked yet, so that card
 * says so honestly.
 */
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\Database;

$page_title = "Subcategory View";
$active_nav = "catalogue";
$active_subnav = "subcategories";
$subcat_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$subcat = null;
$pdoSc = Database::getConnection();
if ($pdoSc !== null && !Database::isMockMode() && $subcat_id > 0) {
    try {
        $rows = Database::query(
            'SELECT s.*, c.name AS parent_name, c.image AS parent_image
             FROM subcategories s
             LEFT JOIN categories c ON s.category_id = c.id
             WHERE s.id = ? LIMIT 1',
            [$subcat_id]
        );
        if (!empty($rows)) {
            $subcat = $rows[0];
        }
    } catch (\Throwable $e) {
        $subcat = null;
    }
}

if ($subcat === null) {
    $subcat = [
        'id' => $subcat_id,
        'name' => 'Unknown subcategory',
        'slug' => '',
        'category_id' => 0,
        'parent_name' => '—',
        'parent_image' => '',
        'status' => 'inactive',
    ];
}

// Live linked-product stats, computed from the products table.
$scSkuCount = 0;
$scValuation = 0.0;
if ($pdoSc !== null && !Database::isMockMode() && $subcat_id > 0) {
    try {
        // Products link to categories, not subcategories, so the SKU count is
        // scoped to the parent category of this sub-line.
        $catId = (int)($subcat['category_id'] ?? 0);
        if ($catId > 0) {
            $agg = Database::fetchOne(
                'SELECT COUNT(*) AS c, COALESCE(SUM(stock_qty * wholesale_price),0) AS v
                 FROM products WHERE category_id = ?',
                [$catId]
            );
            $scSkuCount = (int)($agg['c'] ?? 0);
            $scValuation = (float)($agg['v'] ?? 0);
        }
    } catch (\Throwable $e) {
        // keep zeros
    }
}

$scValuationTxt = $scValuation >= 100000
    ? ('₹' . number_format($scValuation / 100000, 2) . ' Lakhs')
    : ('₹' . number_format($scValuation, 2));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategory Details: <?php echo htmlspecialchars((string)$subcat['name']); ?> ‹ DT Brand's</title>
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
                    <img src="/assets/images/no-image.svg" onerror="this.onerror=null; this.src='/assets/images/no-image.svg';" style="width:48px; height:48px; border-radius:6px; object-fit:cover; border:1px solid #D4AF37;">
                    <div>
                        <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;"><?php echo htmlspecialchars((string)$subcat['name']); ?></h1>
                        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">
                            Parent Category: <a href="/admin/catalogue/categories/view.php?id=<?php echo (int)($subcat['category_id'] ?? 0); ?>" style="color:#8A681F; font-weight:700; text-decoration:none;"><?php echo htmlspecialchars((string)($subcat['parent_name'] ?? '—')); ?></a> •
                            Slug: <code>/shop/<?php echo htmlspecialchars((string)$subcat['slug']); ?></code> • <?php echo (int)$scSkuCount ?> SKUs in parent line
                        </div>
                    </div>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/admin/catalogue/subcategories/edit.php?id=<?php echo (int)$subcat_id; ?>" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">Edit Subcategory</a>
                    <a href="/admin/catalogue/subcategories/" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">Back to List</a>
                </div>
            </div>

            <!-- Mini KPI Cards for Subcategory -->
            <div class="dt-cat-kpi-grid">
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">PARENT LINE SKUS</div>
                        <div class="dt-cat-kpi-val"><?php echo (int)$scSkuCount ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#15803D;">products in the parent category</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">PARENT CATEGORY</div>
                        <div class="dt-cat-kpi-val" style="font-size:14px; font-weight:800; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo htmlspecialchars((string)($subcat['parent_name'] ?? '—')); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#1D4ED8;">direct root line</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">PARENT LINE VALUATION</div>
                        <div class="dt-cat-kpi-val"><?php echo htmlspecialchars($scValuationTxt); ?></div>
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
            $cat_name = (string)$subcat['name'];
            include_once __DIR__ . '/../components/merchandising-panel.php';
            ?>

            <!-- SEO Preview Section -->
            <?php
            $cat = [
                'name' => (string)$subcat['name'],
                'slug' => (string)$subcat['slug'],
            ];
            include_once __DIR__ . '/../components/seo-panel.php';
            ?>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/admin/catalogue/assets/js/categories.js?v=<?php echo time(); ?>"></script>
</body>
</html>