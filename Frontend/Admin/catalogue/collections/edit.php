<?php
/**
 * collections/edit.php — Edit Collection
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Edit Collection";
$active_nav = "catalogue";
$active_subnav = "collections";

$coll_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$collections_db = [
    1 => [
        'title' => 'Surat Heritage Silk Festival',
        'slug' => 'surat-heritage-silk',
        'desc' => 'Exclusive festive wholesale assortment with certified zari and pure silk handloom sarees.',
        'start_date' => '2026-08-01',
        'end_date' => '2026-11-30',
        'active' => 1,
        'featured' => 1
    ],
    2 => [
        'title' => 'Royal Bridal Grandeur 2026',
        'slug' => 'royal-bridal-2026',
        'desc' => 'Luxury Zardosi, Velvet, and Hand-Embroidered Bridal Lehengas for boutique wholesale orders.',
        'start_date' => '2026-01-01',
        'end_date' => '',
        'active' => 1,
        'featured' => 1
    ],
    3 => [
        'title' => 'Diwali Festive Handloom Edit',
        'slug' => 'diwali-festive-edit',
        'desc' => 'Pure Katan and Chanderi festive weaves curated for high margin festive retail sales.',
        'start_date' => '2026-09-15',
        'end_date' => '2026-11-15',
        'active' => 1,
        'featured' => 1
    ],
    4 => [
        'title' => 'Summer Daily Wear Kurtis',
        'slug' => 'summer-daily-kurtis',
        'desc' => 'Breathable Rayon and Mulmul sets for everyday wholesale resale.',
        'start_date' => '2026-03-01',
        'end_date' => '',
        'active' => 1,
        'featured' => 0
    ],
    5 => [
        'title' => 'Surat Central Depot Ready Stock',
        'slug' => 'surat-ready-stock',
        'desc' => 'Fast 24-hour dispatch lots directly from Surat central textile warehouse.',
        'start_date' => '2026-01-01',
        'end_date' => '',
        'active' => 1,
        'featured' => 1
    ],
    6 => [
        'title' => 'Silk Mark Certified Heritage Sarees',
        'slug' => 'silk-mark-certified',
        'desc' => 'Authentic Government certified pure silk weaves with official Silk Mark hologram validation.',
        'start_date' => '2026-01-01',
        'end_date' => '',
        'active' => 1,
        'featured' => 1
    ],
    7 => [
        'title' => 'Reseller Low MOQ Deals (MOQ 4)',
        'slug' => 'reseller-low-moq',
        'desc' => 'Fast moving catalogues tailored for home entrepreneurs and WhatsApp resellers.',
        'start_date' => '2026-01-01',
        'end_date' => '',
        'active' => 1,
        'featured' => 0
    ],
    8 => [
        'title' => 'Wedding Trousseau Master Box',
        'slug' => 'wedding-trousseau-box',
        'desc' => 'Complete bridal and family festive assortments packaged in luxury velvet boxes.',
        'start_date' => '2026-10-01',
        'end_date' => '2027-02-28',
        'active' => 1,
        'featured' => 1
    ]
];

$collection = isset($collections_db[$coll_id]) ? $collections_db[$coll_id] : $collections_db[1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Collection: <?php echo htmlspecialchars($collection['title']); ?> ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/categories.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/collections.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div>
                    <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Edit Collection: <?php echo htmlspecialchars($collection['title']); ?></h1>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Manage products and promotional schedule for this curated collection.</p>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/Frontend/Admin/catalogue/collections/view.php?id=<?php echo $coll_id; ?>" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 12px; font-size:11.5px;">View Live</a>
                    <a href="/Frontend/Admin/catalogue/collections/" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">Back to Collections</a>
                </div>
            </div>

            <?php include_once __DIR__ . '/../components/collection-form.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/categories.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/collections.js?v=<?php echo time(); ?>"></script>
</body>
</html>
