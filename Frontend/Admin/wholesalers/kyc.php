<?php
/**
 * kyc.php - DT Brand's Admin GST & Trade Document Verification
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "GST & Trade Document Verification";
$active_nav = "wholesalers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GST & Trade Document Verification - DT Brand's Admin</title>
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
                        <span>GST & Trade Document Verification</span>
                        <span class="adm-badge gold">KYC Suite</span>
                    </h1>
                    <p class="adm-page-subtitle">Verify GSTIN portal certificates, Udyam registration, and PAN cards.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/wholesalers/" class="adm-btn-secondary">← Back to Wholesalers Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📋 GSTIN Online Verification Portal</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('GST Verification Successful!')">Verify with GST Portal</button>
            </div>
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Enter 15-digit GSTIN Number</label>
                    <input type="text" class="adm-form-input" placeholder="e.g. 24AAACV1234F1Z5">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">PAN Number</label>
                    <input type="text" class="adm-form-input" placeholder="e.g. AAACV1234F">
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
