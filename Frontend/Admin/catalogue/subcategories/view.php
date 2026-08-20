<?php
/**
 * subcategories/view.php — View Subcategory Details
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Subcategory View";
$active_nav = "catalogue";
$active_subnav = "subcategories";
$subcat_id = isset($_GET['id']) ? intval($_GET['id']) : 101;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategory Details: Kanjivaram Silk ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <img src="/Frontend/Shop/Asset/images/product1.png" style="width:44px; height:44px; border-radius:4px; object-fit:cover; border:1px solid #D4AF37;">
                    <div>
                        <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Kanjivaram Silk</h1>
                        <div style="font-size:11.5px; color:#64748b;">Parent: <a href="/Frontend/Admin/catalogue/categories/view.php?id=1" style="color:#8A681F; font-weight:700; text-decoration:none;">Silk Sarees</a> • 160 Active SKUs</div>
                    </div>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/Frontend/Admin/catalogue/subcategories/edit.php?id=<?php echo $subcat_id; ?>" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">Edit Subcategory</a>
                    <a href="/Frontend/Admin/catalogue/subcategories/" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">Back to List</a>
                </div>
            </div>

            <?php include_once __DIR__ . '/../components/merchandising-panel.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
</body>
</html>
