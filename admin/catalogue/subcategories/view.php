<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * subcategories/view.php — View Subcategory Details with Master Styles
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Subcategory View";
$active_nav = "catalogue";
$active_subnav = "subcategories";
$subcat_id = isset($_GET['id']) ? intval($_GET['id']) : 101;

$subcategories_db = [
    101 => [
        'name' => 'Kanjivaram Silk',
        'slug' => 'kanjivaram-silk',
        'parent' => 'Silk Sarees & Handlooms',
        'parent_id' => 1,
        'skus' => '160 SKUs',
        'status_sub' => 'Heavy Gold Zari Border Lots',
        'valuation' => '₹7.20 L',
        'views' => '11,450',
        'growth' => '+14.2% this month',
        'image' => '/assets/images/product1.png'
    ],
    102 => [
        'name' => 'Banarasi Brocade',
        'slug' => 'banarasi-brocade',
        'parent' => 'Silk Sarees & Handlooms',
        'parent_id' => 1,
        'skus' => '140 SKUs',
        'status_sub' => 'Kadhwa & Meenakari Weaves',
        'valuation' => '₹6.80 L',
        'views' => '9,230',
        'growth' => '+18.1% this month',
        'image' => '/assets/images/product2.png'
    ],
    103 => [
        'name' => 'Chanderi & Tussar',
        'slug' => 'chanderi-tussar',
        'parent' => 'Silk Sarees & Handlooms',
        'parent_id' => 1,
        'skus' => '120 SKUs',
        'status_sub' => 'Lightweight Festive Handlooms',
        'valuation' => '₹4.40 L',
        'views' => '7,800',
        'growth' => '+9.5% this month',
        'image' => '/assets/images/product3.png'
    ],
    201 => [
        'name' => 'Zardosi Velvet Lehengas',
        'slug' => 'zardosi-velvet-lehengas',
        'parent' => 'Bridal & Festive Lehengas',
        'parent_id' => 2,
        'skus' => '120 SKUs',
        'status_sub' => 'Heavy Bridal Boutique Line',
        'valuation' => '₹9.60 L',
        'views' => '14,200',
        'growth' => '+24.5% this month',
        'image' => '/assets/images/product6.png'
    ],
    202 => [
        'name' => 'Semi-Stitched Festive Sets',
        'slug' => 'semi-stitched-festive-sets',
        'parent' => 'Bridal & Festive Lehengas',
        'parent_id' => 2,
        'skus' => '160 SKUs',
        'status_sub' => 'Reseller Fast Dispatch Sets',
        'valuation' => '₹4.90 L',
        'views' => '8,150',
        'growth' => '+12.0% this month',
        'image' => '/assets/images/product6.png'
    ]
];

$subcat = isset($subcategories_db[$subcat_id]) ? $subcategories_db[$subcat_id] : $subcategories_db[101];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategory Details: <?php echo htmlspecialchars($subcat['name']); ?> ‹ DT Brand's</title>
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
                    <img src="<?php echo htmlspecialchars($subcat['image']); ?>" onerror="this.src='/assets/images/product1.png';" style="width:48px; height:48px; border-radius:6px; object-fit:cover; border:1px solid #D4AF37;">
                    <div>
                        <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;"><?php echo htmlspecialchars($subcat['name']); ?></h1>
                        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">
                            Parent Category: <a href="/admin/catalogue/categories/view.php?id=<?php echo $subcat['parent_id']; ?>" style="color:#8A681F; font-weight:700; text-decoration:none;"><?php echo htmlspecialchars($subcat['parent']); ?></a> • 
                            Slug: <code>/shop/<?php echo htmlspecialchars($subcat['slug']); ?></code> • <?php echo htmlspecialchars($subcat['skus']); ?> Active
                        </div>
                    </div>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/admin/catalogue/subcategories/edit.php?id=<?php echo $subcat_id; ?>" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">Edit Subcategory</a>
                    <a href="/admin/catalogue/subcategories/" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">Back to List</a>
                </div>
            </div>

            <!-- Mini KPI Cards for Subcategory -->
            <div class="dt-cat-kpi-grid">
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">LINKED PRODUCTS</div>
                        <div class="dt-cat-kpi-val"><?php echo htmlspecialchars($subcat['skus']); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#15803D;"><?php echo htmlspecialchars($subcat['status_sub']); ?></div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">PARENT CATEGORY</div>
                        <div class="dt-cat-kpi-val" style="font-size:14px; font-weight:800; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo htmlspecialchars($subcat['parent']); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#1D4ED8;">Direct Root Line</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">SUB-LINE VALUATION</div>
                        <div class="dt-cat-kpi-val"><?php echo htmlspecialchars($subcat['valuation']); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#8A681F;">Wholesale Stock Value</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">PAGE VIEWS (30 DAYS)</div>
                        <div class="dt-cat-kpi-val"><?php echo htmlspecialchars($subcat['views']); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#15803D;">▲ <?php echo htmlspecialchars($subcat['growth']); ?></div>
                    </div>
                </div>
            </div>

            <!-- Linked Merchandising Section -->
            <?php 
            $cat_name = $subcat['name'];
            include_once __DIR__ . '/../components/merchandising-panel.php'; 
            ?>

            <!-- SEO Preview Section -->
            <?php 
            $cat = [
                'name' => $subcat['name'],
                'slug' => $subcat['slug']
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
