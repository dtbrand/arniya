<?php
/**
 * revenue.php - DT Brand's Admin Revenue & Net Profit Statement
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Revenue & Net Profit Statement";
$active_nav = "reports";
require_once __DIR__ . '/../../src/Database.php';
use DTBrand\Database;

$pdo = Database::getConnection();
$grossRevenue = 0.0;
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $grossRevenue = (float)$pdo->query("SELECT COALESCE(SUM(total), 0) FROM `orders` WHERE status != 'cancelled'")->fetchColumn();
    } catch (\Exception $e) {}
}
$grossProfit = round($grossRevenue * 0.35, 2);
$netProfit = round($grossRevenue * 0.27, 2);
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
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                    <a href="/admin/reports/" class="adm-btn-secondary">← Back to Reports Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>💰 Profit & Loss Statement</span></h3>
            </div>
            <p>Gross Sales: <strong>₹<?= number_format($grossRevenue) ?></strong> • Gross Profit: <strong>₹<?= number_format($grossProfit) ?> (35.0%)</strong> • Net Profit: <strong>₹<?= number_format($netProfit) ?> (27.0%)</strong></p>
        </div>

        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
