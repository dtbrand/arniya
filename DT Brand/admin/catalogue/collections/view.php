<?php
/**
 * collections/view.php — View Collection Details with Master Styles
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Collection View";
$active_nav = "catalogue";
$active_subnav = "collections";
$coll_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$collections_db = [
    1 => [
        'title' => 'Surat Heritage Silk Festival',
        'slug' => 'surat-heritage-silk',
        'skus' => '64 SKUs',
        'schedule' => '2026/08/01 – 2026/11/30',
        'status_sub' => 'Active Festive Wholesale Assortment',
        'valuation' => '₹4.80 L',
        'views' => '18,340',
        'growth' => '+24.5% this month',
        'image' => '/Frontend/Shop/Asset/images/product1.png'
    ],
    2 => [
        'title' => 'Royal Bridal Grandeur 2026',
        'slug' => 'royal-bridal-2026',
        'skus' => '38 SKUs',
        'schedule' => 'All Season',
        'status_sub' => 'Luxury Zardosi & Velvet Lehengas',
        'valuation' => '₹8.40 L',
        'views' => '14,200',
        'growth' => '+28.0% this month',
        'image' => '/Frontend/Shop/Asset/images/product6.png'
    ],
    3 => [
        'title' => 'Diwali Festive Handloom Edit',
        'slug' => 'diwali-festive-edit',
        'skus' => '52 SKUs',
        'schedule' => '2026/09/15 – 2026/11/15',
        'status_sub' => 'Pure Katan & Chanderi Weaves',
        'valuation' => '₹3.90 L',
        'views' => '16,500',
        'growth' => '+19.2% this month',
        'image' => '/Frontend/Shop/Asset/images/product2.png'
    ],
    4 => [
        'title' => 'Summer Daily Wear Kurtis',
        'slug' => 'summer-daily-kurtis',
        'skus' => '45 SKUs',
        'schedule' => 'All Season',
        'status_sub' => 'Breathable Rayon & Mulmul Sets',
        'valuation' => '₹1.85 L',
        'views' => '22,400',
        'growth' => '+15.4% this month',
        'image' => '/Frontend/Shop/Asset/images/product4.png'
    ],
    5 => [
        'title' => 'Surat Central Depot Ready Stock',
        'slug' => 'surat-ready-stock',
        'skus' => '120 SKUs',
        'schedule' => 'Priority 24h Dispatch',
        'status_sub' => 'Fast Moving Wholesale Lots',
        'valuation' => '₹11.20 L',
        'views' => '29,800',
        'growth' => '+32.1% this month',
        'image' => '/Frontend/Shop/Asset/images/product5.png'
    ],
    6 => [
        'title' => 'Silk Mark Certified Heritage Sarees',
        'slug' => 'silk-mark-certified',
        'skus' => '40 SKUs',
        'schedule' => 'Certified Line',
        'status_sub' => 'Govt. Certified Pure Silk Weaves',
        'valuation' => '₹5.60 L',
        'views' => '12,900',
        'growth' => '+11.8% this month',
        'image' => '/Frontend/Shop/Asset/images/product1.png'
    ],
    7 => [
        'title' => 'Reseller Low MOQ Deals (MOQ 4)',
        'slug' => 'reseller-low-moq',
        'skus' => '75 SKUs',
        'schedule' => 'Reseller Special',
        'status_sub' => 'WhatsApp Reseller High Margin Assortment',
        'valuation' => '₹2.90 L',
        'views' => '34,100',
        'growth' => '+41.0% this month',
        'image' => '/Frontend/Shop/Asset/images/product3.png'
    ],
    8 => [
        'title' => 'Wedding Trousseau Master Box',
        'slug' => 'wedding-trousseau-box',
        'skus' => '30 SKUs',
        'schedule' => 'Wedding Season Lot',
        'status_sub' => 'Complete Bridal & Family Sets',
        'valuation' => '₹6.75 L',
        'views' => '9,400',
        'growth' => '+16.5% this month',
        'image' => '/Frontend/Shop/Asset/images/product6.png'
    ]
];

$coll = isset($collections_db[$coll_id]) ? $collections_db[$coll_id] : $collections_db[1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection Details: <?php echo htmlspecialchars($coll['title']); ?> ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/collections.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/merchandising.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <img src="<?php echo htmlspecialchars($coll['image']); ?>" onerror="this.src='/Shared/Asset/images/product1.png';" style="width:48px; height:48px; border-radius:6px; object-fit:cover; border:1px solid #D4AF37;">
                    <div>
                        <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;"><?php echo htmlspecialchars($coll['title']); ?></h1>
                        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">
                            <?php echo htmlspecialchars($coll['skus']); ?> Assigned • <?php echo htmlspecialchars($coll['status_sub']); ?> • 
                            Slug: <code>/collection/<?php echo htmlspecialchars($coll['slug']); ?></code>
                        </div>
                    </div>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/Frontend/Admin/catalogue/collections/edit.php?id=<?php echo $coll_id; ?>" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">Edit Collection</a>
                    <a href="/Frontend/Admin/catalogue/collections/" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">Back to Collections</a>
                </div>
            </div>

            <!-- Mini KPI Cards for Collection -->
            <div class="dt-cat-kpi-grid">
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">ASSIGNED PRODUCTS</div>
                        <div class="dt-cat-kpi-val"><?php echo htmlspecialchars($coll['skus']); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#15803D;">Ready Stock in Surat Depot</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">CAMPAIGN SCHEDULE</div>
                        <div class="dt-cat-kpi-val" style="font-size:13.5px; font-weight:800; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo htmlspecialchars($coll['schedule']); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#1D4ED8;">Active Live Promotion</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">COLLECTION VALUATION</div>
                        <div class="dt-cat-kpi-val"><?php echo htmlspecialchars($coll['valuation']); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#8A681F;">Wholesale Lot Value</div>
                    </div>
                </div>
                <div class="dt-cat-kpi-card">
                    <div class="dt-cat-kpi-meta">
                        <div class="dt-cat-kpi-label">PAGE VIEWS (30 DAYS)</div>
                        <div class="dt-cat-kpi-val"><?php echo htmlspecialchars($coll['views']); ?></div>
                        <div class="dt-cat-kpi-sub" style="color:#15803D;">▲ <?php echo htmlspecialchars($coll['growth']); ?></div>
                    </div>
                </div>
            </div>

            <!-- Linked Merchandising Section -->
            <?php 
            $cat_name = $coll['title'];
            include_once __DIR__ . '/../components/merchandising-panel.php'; 
            ?>

            <!-- SEO Preview Section -->
            <?php 
            $cat = [
                'name' => $coll['title'],
                'slug' => $coll['slug']
            ];
            include_once __DIR__ . '/../components/seo-panel.php'; 
            ?>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/collections.js?v=<?php echo time(); ?>"></script>
</body>
</html>
