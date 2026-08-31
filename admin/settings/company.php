<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * company.php - DT Brand's Admin Company & Legal Business Profile
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Company & Legal Business Profile";
$active_nav = "settings";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company & Legal Business Profile - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Company & Legal Business Profile</span>
                        <span class="adm-badge gold">Legal Entity</span>
                    </h1>
                    <p class="adm-page-subtitle">Surat registered business name, GSTIN certificate, PAN, and corporate address.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/settings/" class="adm-btn-secondary">← Back to Settings Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>🏢 Legal Company Information</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Company Profile Saved!')">Save Profile</button>
            </div>
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Legal Business Name</label>
                    <input type="text" class="adm-form-input" value="Jai Hanuman Tex (DT Brand's)">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">GSTIN</label>
                    <input type="text" class="adm-form-input" value="24AAACV1234F1Z5">
                </div>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
