<?php
/**
 * revenue.php — DT Brand's & Jai Hanuman Tex
 * Retail Net Revenue & Financial Reconciliation
 */
$page_title = "Retail Net Revenue";
$active_nav = "retail";
$active_subnav = "revenue";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Revenue - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/retail/assets/css/retail-sales.css?v=<?php echo time(); ?>">
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
                            <span>Retail Revenue Studio</span>
                            <span class="dt-status-pill-clean gold">Financial Overview</span>
                        </h1>
                        <p class="dt-retail-subtitle">Settled revenue, tax collections (GST), gateway charges, and net profit margins.</p>
                    </div>
                </div>

                <div class="dt-sales-summary-grid">
                    <div class="dt-sales-breakdown-card">
                        <span class="dt-sales-breakdown-label">Net Sales Revenue</span>
                        <div class="dt-sales-breakdown-val" style="color:#15803D;">₹60,21,600</div>
                    </div>
                    <div class="dt-sales-breakdown-card">
                        <span class="dt-sales-breakdown-label">GST 5% Collected</span>
                        <div class="dt-sales-breakdown-val" style="color:#8A681F;">₹3,01,080</div>
                    </div>
                    <div class="dt-sales-breakdown-card">
                        <span class="dt-sales-breakdown-label">Payment Gateway Fee (2%)</span>
                        <div class="dt-sales-breakdown-val" style="color:#78716C;">₹1,20,432</div>
                    </div>
                    <div class="dt-sales-breakdown-card">
                        <span class="dt-sales-breakdown-label">Estimated Gross Margin</span>
                        <div class="dt-sales-breakdown-val" style="color:#181512;">42.8%</div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="/admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
</body>
</html>
