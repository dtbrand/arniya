<?php
/**
 * cart.php — DT Brand's & Jai Hanuman Tex
 * Retail Live Shopping Bag Monitor
 */
$page_title = "Retail Live Carts";
$active_nav = "retail";
$active_subnav = "cart";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Shopping Bags - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/retail/assets/css/retail-cart.css?v=<?php echo time(); ?>">
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
                            <span>Live Shopping Bags</span>
                            <span class="dt-status-pill-clean emerald">42 Active Sessions</span>
                        </h1>
                        <p class="dt-retail-subtitle">Real-time customer cart sessions, added saree quantities, and potential cart values.</p>
                    </div>
                    <a href="/admin/retail/abandoned-carts.php" class="dt-btn dt-btn-gold">
                        <span>Abandoned Carts Studio →</span>
                    </a>
                </div>

                <?php include_once __DIR__ . '/components/retail-cart.php'; ?>
            </div>

        </main>
    </div>
</div>

<script src="/admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
<script src="/admin/retail/assets/js/retail-cart.js?v=<?php echo time(); ?>"></script>
</body>
</html>
