<?php
/**
 * categories/index.php — Primary Category List Table
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Categories";
$active_nav = "catalogue";
$active_subnav = "categories";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories ‹ DT Brand's Catalogue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/catalogue/assets/css/categories.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div>
                    <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Categories</h1>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Manage master product categories, sub-classifications, and display options.</p>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/DT%20Brand/admin/catalogue/categories/add.php" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">+ Add Category</a>
                    <a href="/DT%20Brand/admin/catalogue/categories/reorder.php" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">Reorder</a>
                </div>
            </div>

            <?php include_once __DIR__ . '/../components/category-filters.php'; ?>
            <?php include_once __DIR__ . '/../components/category-table.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/DT%20Brand/admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/catalogue/assets/js/categories.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/catalogue/assets/js/filters.js?v=<?php echo time(); ?>"></script>
</body>
</html>
