<?php
/**
 * collections.php — Collections Management Hub
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Collections";
$active_nav = "catalogue";
$active_subnav = "collections";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collections ‹ DT Brand's Catalogue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/catalogue/assets/css/collections.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div>
                    <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Curated Collections</h1>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Group seasonal assortments, festive highlights, and trending lines without modifying category taxonomy.</p>
                </div>
                <a href="/DT%20Brand/admin/catalogue/collections/add.php" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">+ Add Collection</a>
            </div>

            <?php include_once __DIR__ . '/components/collection-table.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/DT%20Brand/admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/catalogue/assets/js/collections.js?v=<?php echo time(); ?>"></script>
</body>
</html>
