<?php
/**
 * payouts.php - DT Brand's Admin Weekly Reseller Payouts Hub
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Weekly Reseller Payouts Hub";
$active_nav = "resellers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Reseller Payouts Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                        <span>Weekly Reseller Payouts Hub</span>
                        <span class="adm-badge gold">₹48,500 Pending</span>
                    </h1>
                    <p class="adm-page-subtitle">Batch settle earned profit margins directly to reseller bank accounts.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/resellers/" class="adm-btn-secondary">← Back to Resellers Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>⚡ Batch Margin Settlement</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Batch Payout of ₹48,500 Sent!')">🚀 Settle All 12 Payouts</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Reseller</th>
                            <th>Payout Amount</th>
                            <th>Beneficiary Account</th>
                            <th>Orders Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ananya Roy</td>
                            <td><strong>₹8,400</strong></td>
                            <td>HDFC Bank (..1234)</td>
                            <td>28 pcs</td>
                            <td><button class="adm-btn-primary adm-btn-sm" onclick="window.showToast('₹8,400 Transferred via IMPS!')">Pay ₹8,400</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
