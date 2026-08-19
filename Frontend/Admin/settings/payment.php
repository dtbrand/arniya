<?php
/**
 * payment.php - DT Brand's Admin Payment Gateways Configuration
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Payment Gateways Configuration";
$active_nav = "settings";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateways Configuration - DT Brand's Admin</title>
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
                        <span>Payment Gateways Configuration</span>
                        <span class="adm-badge gold">Gateways</span>
                    </h1>
                    <p class="adm-page-subtitle">Razorpay, Cashfree, UPI QR, and Bank Account settings.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/settings/" class="adm-btn-secondary">← Back to Settings Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>💳 Gateway Credentials</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Gateway Keys Saved!')">Save Credentials</button>
            </div>
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Razorpay Key ID</label>
                    <input type="text" class="adm-form-input" value="rzp_live_99482019482">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">UPI Merchant VPA</label>
                    <input type="text" class="adm-form-input" value="jaihanumantex@hdfcbank">
                </div>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
