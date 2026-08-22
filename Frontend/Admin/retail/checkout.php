<?php
/**
 * checkout.php — DT Brand's & Jai Hanuman Tex
 * Retail 7-Step Checkout Funnel Diagnostics
 */
$page_title = "Checkout Funnel Diagnostics";
$active_nav = "retail";
$active_subnav = "checkout";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Funnel - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/retail/assets/css/retail-checkout.css?v=<?php echo time(); ?>">
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
                            <span>Checkout Funnel Diagnostics</span>
                            <span class="dt-status-pill-clean emerald">33.5% Conversion</span>
                        </h1>
                        <p class="dt-retail-subtitle">Step-by-step conversion funnel analysis from Cart to Order Placement.</p>
                    </div>
                </div>

                <?php include_once __DIR__ . '/components/retail-checkout.php'; ?>
            </div>

        </main>
    </div>
</div>

<script src="/Frontend/Admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/retail/assets/js/retail-checkout.js?v=<?php echo time(); ?>"></script>
</body>
</html>
