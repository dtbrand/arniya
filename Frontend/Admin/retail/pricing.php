<?php
/**
 * pricing.php — DT Brand's & Jai Hanuman Tex
 * Retail Pricing & Margins
 */
$page_title = "Retail Pricing & Margins";
$active_nav = "retail";
$active_subnav = "pricing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Pricing - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/retail/assets/css/retail-pricing.css?v=<?php echo time(); ?>">
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
                            <span>Retail Pricing &amp; Margins</span>
                            <span class="dt-status-pill-clean gold">Direct Consumer Rates</span>
                        </h1>
                        <p class="dt-retail-subtitle">Manage MRP, retail selling price, and instant discount margins across all saree collections.</p>
                    </div>
                </div>

                <?php include_once __DIR__ . '/components/retail-pricing.php'; ?>
            </div>

        </main>
    </div>
</div>

<script src="/Frontend/Admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/retail/assets/js/retail-pricing.js?v=<?php echo time(); ?>"></script>
</body>
</html>
