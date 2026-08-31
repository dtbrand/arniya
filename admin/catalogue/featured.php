<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * featured.php — Featured Catalogue Sections Manager
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Featured Catalogue";
$active_nav = "catalogue";
$active_subnav = "featured";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Catalogue ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/collections.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div>
                    <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Featured Catalogue Hub</h1>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Manage homepage hero spotlights, featured gold ribbons, and top category banners.</p>
                </div>
            </div>

            <!-- Featured Categories Grid -->
            <div class="dt-cat-card" style="margin-bottom:16px;">
                <div class="dt-cat-card-header">
                    <h3 class="dt-cat-card-title">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="#8A681F" stroke="#8A681F" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Featured Categories on Homepage Ribbon</span>
                    </h3>
                </div>
                <div style="padding:16px;">
                    <?php include_once __DIR__ . '/components/category-card.php'; ?>
                </div>
            </div>

            <!-- Featured Collections -->
            <?php include_once __DIR__ . '/components/collection-table.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
</body>
</html>
