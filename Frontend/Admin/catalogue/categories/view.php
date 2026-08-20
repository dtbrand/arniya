<?php
/**
 * categories/view.php — Category Deep Details, Analytics & Linked Products
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Category Details";
$active_nav = "catalogue";
$active_subnav = "categories";
$cat_id = isset($_GET['id']) ? intval($_GET['id']) : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details: Silk Sarees ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/categories.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <img src="/Frontend/Shop/Asset/images/product1.png" style="width:48px; height:48px; border-radius:6px; object-fit:cover; border:1px solid #D4AF37;">
                    <div>
                        <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Silk Sarees &amp; Handlooms</h1>
                        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">Slug: <code>/shop/silk-sarees</code> • 420 SKUs Active</div>
                    </div>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/Frontend/Admin/catalogue/categories/edit.php?id=<?php echo $cat_id; ?>" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">Edit Category</a>
                    <a href="/Frontend/Admin/catalogue/categories/" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">Back to Categories</a>
                </div>
            </div>

            <!-- Mini KPI Cards for Category -->
            <div class="dt-cat-kpi-grid">
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">LINKED PRODUCTS</div>
                        <div class="dt-cat-kpi-val">420 SKUs</div>
                        <div class="dt-cat-kpi-sub" style="color:#15803D;">Ready Stock in Surat Depot</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">SUBCATEGORIES</div>
                        <div class="dt-cat-kpi-val">3 Types</div>
                        <div class="dt-cat-kpi-sub" style="color:#1D4ED8;">Kanjivaram, Banarasi, Chanderi</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">CATEGORY VALUATION</div>
                        <div class="dt-cat-kpi-val">₹18.40 L</div>
                        <div class="dt-cat-kpi-sub" style="color:#8A681F;">Wholesale Asset Value</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">PAGE VIEWS (30 DAYS)</div>
                        <div class="dt-cat-kpi-val">24,580</div>
                        <div class="dt-cat-kpi-sub" style="color:#15803D;">▲ +18.4% this month</div>
                    </div>
                </div>
            </div>

            <!-- Linked Merchandising Section -->
            <?php include_once __DIR__ . '/../components/merchandising-panel.php'; ?>

            <!-- SEO Preview Section -->
            <?php include_once __DIR__ . '/../components/seo-panel.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/categories.js?v=<?php echo time(); ?>"></script>
</body>
</html>
