<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * hierarchy.php — Category Hierarchy & Taxonomy Tree View
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Category Hierarchy";
$active_nav = "catalogue";
$active_subnav = "hierarchy";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Hierarchy ‹ DT Brand's Catalogue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/hierarchy.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div>
                    <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Category Hierarchy &amp; Tree</h1>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Visual tree view of parent, child subcategories and product counts.</p>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/admin/catalogue/categories/add.php" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">+ Add Root Category</a>
                    <a href="/admin/catalogue/subcategories/add.php" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">+ Add Subcategory</a>
                </div>
            </div>

            <?php include_once __DIR__ . '/components/hierarchy-tree.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/admin/catalogue/assets/js/hierarchy.js?v=<?php echo time(); ?>"></script>
</body>
</html>
