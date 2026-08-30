<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * sales.php — DT Brand's & Jai Hanuman Tex
 * Retail Sales Performance Analysis
 */
$page_title = "Retail Sales Performance";
$active_nav = "retail";
$active_subnav = "sales";
require_once __DIR__ . '/components/retail-data.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Sales - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/retail/assets/css/retail-sales.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/retail/assets/css/retail-analytics.css?v=<?php echo time(); ?>">
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
                            <span>Retail Sales Analysis</span>
                            <span class="dt-status-pill-clean emerald">₹58,40,000 GMV</span>
                        </h1>
                        <p class="dt-retail-subtitle">Gross sales, channel distribution, order volumes, and average ticket sizes.</p>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <a href="/admin/retail/revenue.php" class="dt-btn dt-btn-pale">
                            <span>Net Revenue Studio →</span>
                        </a>
                    </div>
                </div>

                <div class="dt-sales-summary-grid">
                    <div class="dt-sales-breakdown-card">
                        <span class="dt-sales-breakdown-label">Gross Retail Sales</span>
                        <div class="dt-sales-breakdown-val">₹64,20,000</div>
                        <span style="font-size:0.7rem; color:#15803D; font-weight:700;">+24.8% vs last year</span>
                    </div>
                    <div class="dt-sales-breakdown-card">
                        <span class="dt-sales-breakdown-label">Coupon Discounts Given</span>
                        <div class="dt-sales-breakdown-val" style="color:#DC2626;">- ₹3,80,000</div>
                        <span style="font-size:0.7rem; color:#78716C;">5.9% of gross sales</span>
                    </div>
                    <div class="dt-sales-breakdown-card">
                        <span class="dt-sales-breakdown-label">Returns / RMA Deductions</span>
                        <div class="dt-sales-breakdown-val" style="color:#B45309;">- ₹18,400</div>
                        <span style="font-size:0.7rem; color:#15803D; font-weight:700;">0.31% return rate (Very Low)</span>
                    </div>
                    <div class="dt-sales-breakdown-card">
                        <span class="dt-sales-breakdown-label">Net Settled Revenue</span>
                        <div class="dt-sales-breakdown-val" style="color:#15803D;">₹60,21,600</div>
                        <span style="font-size:0.7rem; color:#8A681F; font-weight:800;">100% Verified Bank Credit</span>
                    </div>
                </div>

                <?php include_once __DIR__ . '/components/retail-sales-chart.php'; ?>
            </div>

        </main>
    </div>
</div>

<script src="/admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
<script src="/admin/retail/assets/js/retail-dashboard.js?v=<?php echo time(); ?>"></script>
</body>
</html>
