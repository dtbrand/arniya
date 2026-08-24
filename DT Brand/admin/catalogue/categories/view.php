<?php
/**
 * categories/view.php — Category Deep Details, Analytics & Linked Products
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Category Details";
$active_nav = "catalogue";
$active_subnav = "categories";
$cat_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$categories_db = [
    1 => [
        'name' => 'Silk Sarees & Handlooms',
        'slug' => 'silk-sarees',
        'subcats' => '3 Types (Kanjivaram, Banarasi, Chanderi)',
        'skus' => '420 SKUs',
        'status_sub' => 'Ready Stock in Surat Depot',
        'valuation' => '₹18.40 L',
        'views' => '24,580',
        'growth' => '+18.4% this month',
        'image' => '/Frontend/Shop/Asset/images/product1.png'
    ],
    2 => [
        'name' => 'Bridal & Festive Lehengas',
        'slug' => 'bridal-lehengas',
        'subcats' => '2 Types (Zardosi Velvet, Semi-Stitched Sets)',
        'skus' => '280 SKUs',
        'status_sub' => 'Surat Handcrafted Master Line',
        'valuation' => '₹14.50 L',
        'views' => '19,240',
        'growth' => '+22.6% this month',
        'image' => '/Frontend/Shop/Asset/images/product6.png'
    ],
    3 => [
        'name' => 'Designer Kurtis & Tunics',
        'slug' => 'designer-kurtis',
        'subcats' => '2 Types (Anarkali Sets, Straight Cut Foil)',
        'skus' => '310 SKUs',
        'status_sub' => 'Fast Moving Ready Catalogues',
        'valuation' => '₹8.90 L',
        'views' => '31,800',
        'growth' => '+15.2% this month',
        'image' => '/Frontend/Shop/Asset/images/product4.png'
    ],
    4 => [
        'name' => 'Dress Materials & Unstitched',
        'slug' => 'dress-materials',
        'subcats' => '4 Types (Pure Cotton, Chanderi, Modal Silk)',
        'skus' => '230 SKUs',
        'status_sub' => 'Bulk Lot Wholesaler Stock',
        'valuation' => '₹6.75 L',
        'views' => '14,350',
        'growth' => '+9.8% this month',
        'image' => '/Frontend/Shop/Asset/images/product5.png'
    ],
    5 => [
        'name' => 'Banarasi Brocades',
        'slug' => 'banarasi-brocades',
        'subcats' => '3 Types (Kadhwa Zari, Tanchoi, Meenakari)',
        'skus' => '185 SKUs',
        'status_sub' => 'Heritage Handloom Certified',
        'valuation' => '₹12.20 L',
        'views' => '16,700',
        'growth' => '+14.1% this month',
        'image' => '/Frontend/Shop/Asset/images/product2.png'
    ],
    6 => [
        'name' => 'Festive Dupattas & Stoles',
        'slug' => 'festive-dupattas',
        'subcats' => '2 Types (Bandhani, Banarasi Rich Stoles)',
        'skus' => '95 SKUs',
        'status_sub' => 'Seasonal Accessory Stock',
        'valuation' => '₹2.80 L',
        'views' => '8,900',
        'growth' => '+5.4% this month',
        'image' => '/Frontend/Shop/Asset/images/product3.png'
    ]
];

$cat = isset($categories_db[$cat_id]) ? $categories_db[$cat_id] : $categories_db[1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details: <?php echo htmlspecialchars($cat['name']); ?> ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/catalogue/assets/css/categories.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/catalogue/assets/css/merchandising.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <img src="<?php echo htmlspecialchars($cat['image']); ?>" onerror="this.src='/Shared/Asset/images/product1.png';" style="width:48px; height:48px; border-radius:6px; object-fit:cover; border:1px solid #D4AF37;">
                    <div>
                        <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;"><?php echo htmlspecialchars($cat['name']); ?></h1>
                        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">Slug: <code>/shop/<?php echo htmlspecialchars($cat['slug']); ?></code> • <?php echo htmlspecialchars($cat['skus']); ?> Active</div>
                    </div>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/DT%20Brand/admin/catalogue/categories/edit.php?id=<?php echo $cat_id; ?>" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">Edit Category</a>
                    <a href="/DT%20Brand/admin/catalogue/categories/" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">Back to Categories</a>
                </div>
            </div>

            <!-- Mini KPI Cards for Category -->
            <div class="dt-cat-kpi-grid">
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">LINKED PRODUCTS</div>
                        <div class="dt-cat-kpi-val"><?php echo htmlspecialchars($cat['skus']); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#15803D;"><?php echo htmlspecialchars($cat['status_sub']); ?></div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">SUBCATEGORIES</div>
                        <div class="dt-cat-kpi-val"><?php echo explode(' ', $cat['subcats'])[0]; ?> Types</div>
                        <div class="dt-cat-kpi-sub" style="color:#1D4ED8;"><?php echo htmlspecialchars($cat['subcats']); ?></div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">CATEGORY VALUATION</div>
                        <div class="dt-cat-kpi-val"><?php echo htmlspecialchars($cat['valuation']); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#8A681F;">Wholesale Asset Value</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">PAGE VIEWS (30 DAYS)</div>
                        <div class="dt-cat-kpi-val"><?php echo htmlspecialchars($cat['views']); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#15803D;">▲ <?php echo htmlspecialchars($cat['growth']); ?></div>
                    </div>
                </div>
            </div>

            <!-- Linked Merchandising Section -->
            <?php 
            $cat_name = $cat['name'];
            include_once __DIR__ . '/../components/merchandising-panel.php'; 
            ?>

            <!-- SEO Preview Section -->
            <?php include_once __DIR__ . '/../components/seo-panel.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/DT%20Brand/admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/catalogue/assets/js/categories.js?v=<?php echo time(); ?>"></script>
</body>
</html>
