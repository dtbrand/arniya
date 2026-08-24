<?php
/**
 * subcategories/edit.php — Edit Subcategory
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Edit Subcategory";
$active_nav = "catalogue";
$active_subnav = "subcategories";

$subcat_id = isset($_GET['id']) ? intval($_GET['id']) : 101;
$category_data = [
    'name' => ($subcat_id === 102 ? 'Banarasi Brocade' : ($subcat_id === 103 ? 'Chanderi & Tussar' : 'Kanjivaram Silk')),
    'slug' => ($subcat_id === 102 ? 'banarasi-brocade' : ($subcat_id === 103 ? 'chanderi-tussar' : 'kanjivaram-silk')),
    'parent' => 'Silk Sarees',
    'desc' => 'Pure silk fabric with zari work, authentic temple borders and wholesale lots.',
    'short_desc' => 'Surat Central Depot Kanjivaram Weaves',
    'image' => '/Frontend/Shop/Asset/images/product1.png',
    'banner' => '/Frontend/Shop/Asset/images/product2.png',
    'display_style' => 'grid',
    'active' => 1,
    'featured' => 0,
    'show_menu' => 1,
    'show_home' => 0,
    'show_search' => 1,
    'show_filters' => 1
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subcategory ‹ DT Brand's Catalogue</title>
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
                    <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Edit Subcategory: <?php echo htmlspecialchars($category_data['name']); ?></h1>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Parent Category: <strong><?php echo htmlspecialchars($category_data['parent']); ?></strong></p>
                </div>
            </div>

            <?php include_once __DIR__ . '/../components/category-form.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/DT%20Brand/admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/catalogue/assets/js/categories.js?v=<?php echo time(); ?>"></script>
</body>
</html>
