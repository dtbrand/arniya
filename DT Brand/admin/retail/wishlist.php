<?php
/**
 * wishlist.php — DT Brand's & Jai Hanuman Tex
 * Retail Customer Wishlist Demand & Popularity Index
 */
$page_title = "Retail Wishlist Demand";
$active_nav = "retail";
$active_subnav = "wishlist";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Demand - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-retail-container">
                <div class="dt-retail-head">
                    <div>
                        <h1 class="dt-retail-title">
                            <span>Customer Wishlist Demand</span>
                            <span class="dt-status-pill-clean gold">Buying Intent</span>
                        </h1>
                        <p class="dt-retail-subtitle">Analyze items most frequently saved to wishlists and conversion rates to purchased orders.</p>
                    </div>
                </div>

                <?php include_once __DIR__ . '/components/retail-wishlist.php'; ?>
            </div>

        </main>
    </div>
</div>

<script src="/DT%20Brand/admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
</body>
</html>
