<?php
/**
 * categories/edit.php — Edit Category Page
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Edit Category";
$active_nav = "catalogue";
$active_subnav = "categories";

$cat_id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$category_data = [
    'name' => ($cat_id === 2 ? 'Bridal Lehengas' : ($cat_id === 3 ? 'Designer Kurtis' : 'Silk Sarees')),
    'slug' => ($cat_id === 2 ? 'bridal-lehengas' : ($cat_id === 3 ? 'designer-kurtis' : 'silk-sarees')),
    'parent' => '',
    'desc' => 'Surat central depot master handloom and powerloom weaves. Certified pure silk and zari border designs.',
    'short_desc' => 'Authentic Surat Pure Silk & Jacquard Weaves',
    'image' => ($cat_id === 2 ? '/assets/images/product6.png' : ($cat_id === 3 ? '/assets/images/product4.png' : '/assets/images/product1.png')),
    'banner' => '/assets/images/product2.png',
    'display_style' => 'banner_grid',
    'active' => 1,
    'featured' => 1,
    'show_menu' => 1,
    'show_home' => 1,
    'show_search' => 1,
    'show_filters' => 1
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category: <?php echo htmlspecialchars($category_data['name']); ?> ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/categories.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div>
                    <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Edit Category: <?php echo htmlspecialchars($category_data['name']); ?></h1>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Update category metadata, banner imagery, and storefront merchandising rules.</p>
                </div>
                <a href="/admin/catalogue/categories/view.php?id=<?php echo $cat_id; ?>" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 12px; font-size:11.5px;">View Live Page</a>
            </div>

            <?php include_once __DIR__ . '/../components/category-form.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/admin/catalogue/assets/js/categories.js?v=<?php echo time(); ?>"></script>
</body>
</html>
