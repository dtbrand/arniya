<?php
/**
 * analytics.php — DT Brand's & Jai Hanuman Tex
 * Retail Sourcing & Sales Velocity Growth Analytics
 */
$page_title = "Retail Growth Analytics";
$active_nav = "retail";
$active_subnav = "analytics";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Analytics - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/retail/assets/css/retail-analytics.css?v=<?php echo time(); ?>">
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
                            <span>Retail Growth Analytics</span>
                            <span class="dt-status-pill-clean emerald">+28.4% YoY</span>
                        </h1>
                        <p class="dt-retail-subtitle">Direct consumer acquisition velocity, customer repeat ratios, and product category demand.</p>
                    </div>
                    <button type="button" class="dt-btn dt-btn-gold" onclick="exportRetailCsvReport('Velocity')">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Export Analytics CSV</span>
                    </button>
                </div>

                <!-- ══ 12-CARD MASTER KPI RIBBON ══ -->
                <?php include_once __DIR__ . '/components/retail-stats.php'; ?>

                <!-- ══ SALES VELOCITY CHART ══ -->
                <?php include_once __DIR__ . '/components/retail-sales-chart.php'; ?>

                <!-- ══ 7-STEP CHECKOUT FUNNEL ══ -->
                <?php include_once __DIR__ . '/components/retail-checkout.php'; ?>
            </div>

        </main>
    </div>
</div>

<script src="/Frontend/Admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/retail/assets/js/retail-dashboard.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/retail/assets/js/retail-analytics.js?v=<?php echo time(); ?>"></script>
</body>
</html>
