<?php
/**
 * revenue.php - DT Brand's Admin Revenue & Net Profit Statement
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Revenue & Net Profit Statement";
$active_nav = "reports";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue & Net Profit Statement - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Revenue & Net Profit Statement</span>
                        <span class="adm-badge gold">P&L Statement</span>
                    </h1>
                    <p class="adm-page-subtitle">Profit and loss calculations including fabric costs, weaving expenses, and net profit.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/DT%20Brand/admin/reports/" class="adm-btn-secondary">← Back to Reports Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>💰 Profit & Loss Statement</span></h3>
            </div>
            <p>Gross Profit: <strong>₹14,92,400 (34.8%)</strong> • Net Profit: <strong>₹11,45,200 (26.7%)</strong></p>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/DT%20Brand/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
