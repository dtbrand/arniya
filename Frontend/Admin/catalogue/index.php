<?php
/**
 * index.php — DT Brand's Master Catalogue Management Dashboard
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Catalogue";
$active_nav = "catalogue";
$active_subnav = "overview";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue ‹ DT Brand's Admin Suite</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/hierarchy.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/collections.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <!-- 1. Header Toolbar with Luxury Brand Gold Buttons -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Catalogue</h1>
                        <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:2px 8px;">Master Architecture</span>
                    </div>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Manage DT Brands catalogue structure, taxonomy hierarchy, collections, and merchandising.</p>
                </div>
                
                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <a href="/Frontend/Admin/catalogue/categories/add.php" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Category</span>
                    </a>
                    <a href="/Frontend/Admin/catalogue/collections/add.php" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Add Collection</span>
                    </a>
                    <a href="/Frontend/Admin/catalogue/navigation.php" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                        <span>Manage Navigation</span>
                    </a>
                    <a href="/Frontend/Admin/catalogue/banners/" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <span>Manage Banners</span>
                    </a>
                </div>
            </div>

            <!-- 2. KPI Cards Ribbon -->
            <?php include_once __DIR__ . '/components/catalogue-stats.php'; ?>

            <!-- 3. Catalogue Flow Overview Map -->
            <div class="dt-cat-flow-card">
                <div style="font-size:12px; font-weight:800; color:#8A681F; text-transform:uppercase; margin-bottom:10px;">
                    👑 DT BRAND'S WHOLESALE CATALOGUE TAXONOMY FLOW
                </div>
                <div class="dt-cat-flow-steps">
                    <a href="/Frontend/Admin/catalogue/categories/" class="dt-cat-flow-step" style="text-decoration:none;">
                        <div class="dt-cat-flow-num">Step 1</div>
                        <div class="dt-cat-flow-title">16 Root Categories</div>
                        <div class="dt-cat-flow-count">14 Active Live</div>
                    </a>
                    <a href="/Frontend/Admin/catalogue/subcategories/" class="dt-cat-flow-step" style="text-decoration:none;">
                        <div class="dt-cat-flow-num">Step 2</div>
                        <div class="dt-cat-flow-title">42 Subcategories</div>
                        <div class="dt-cat-flow-count">Fabric &amp; Weave Types</div>
                    </a>
                    <a href="/Frontend/Admin/catalogue/collections/" class="dt-cat-flow-step" style="text-decoration:none;">
                        <div class="dt-cat-flow-num">Step 3</div>
                        <div class="dt-cat-flow-title">8 Curated Collections</div>
                        <div class="dt-cat-flow-count">Festive &amp; Bridal Lines</div>
                    </a>
                    <a href="/Frontend/Admin/products/" class="dt-cat-flow-step" style="text-decoration:none;">
                        <div class="dt-cat-flow-num">Step 4</div>
                        <div class="dt-cat-flow-title">1,240 Total SKUs</div>
                        <div class="dt-cat-flow-count">Surat Central Depot Stock</div>
                    </a>
                </div>
            </div>

            <!-- 4. Filter Toolbar -->
            <?php include_once __DIR__ . '/components/category-filters.php'; ?>

            <!-- 5. Primary Category Table -->
            <?php include_once __DIR__ . '/components/category-table.php'; ?>

            <!-- 6. Collections Preview Section -->
            <?php include_once __DIR__ . '/components/collection-table.php'; ?>

            <!-- 7. Storefront Landing Simulator Preview -->
            <?php include_once __DIR__ . '/components/category-preview.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/hierarchy.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/categories.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/collections.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/banners.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/navigation.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/merchandising.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/filters.js?v=<?php echo time(); ?>"></script>
</body>
</html>
