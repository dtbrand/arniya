<?php
/**
 * sales.php - DT Brand's Admin Sales Breakdown & Channel Analytics
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Sales Breakdown & Channel Analytics";
$active_nav = "reports";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Breakdown & Channel Analytics - DT Brand's Admin</title>
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
                        <span>Sales Breakdown & Channel Analytics</span>
                        <span class="adm-badge gold">Sales Analytics</span>
                    </h1>
                    <p class="adm-page-subtitle">Detailed order-level sales reports split across Wholesale, Reseller, and Retail.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/reports/" class="adm-btn-secondary">← Back to Reports Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📊 Sales Analytics</span></h3>
                <button class="adm-btn-secondary" onclick="window.showToast('Exporting Sales CSV...')">📥 Export CSV</button>
            </div>
            <p>Total Revenue MTD: <strong>₹42,85,900</strong> across 1,624 orders.</p>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
