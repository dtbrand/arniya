<?php
/**
 * kyc.php - DT Brand's Admin Reseller Bank & UPI Verification
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Reseller Bank & UPI Verification";
$active_nav = "resellers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseller Bank & UPI Verification - DT Brand's Admin</title>
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
                        <span>Reseller Bank & UPI Verification</span>
                        <span class="adm-badge gold">Bank Verification</span>
                    </h1>
                    <p class="adm-page-subtitle">Verify UPI IDs and bank account details for instant margin payouts.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/resellers/" class="adm-btn-secondary">← Back to Resellers Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>💳 Reseller Bank Account Roster</span></h3>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Reseller</th>
                            <th>Bank Name</th>
                            <th>Account # / UPI ID</th>
                            <th>IFSC Code</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ananya Roy</td>
                            <td>HDFC Bank</td>
                            <td><code>ananya@okhdfcbank</code></td>
                            <td>HDFC0001234</td>
                            <td><span class="adm-badge success">Verified</span></td>
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
