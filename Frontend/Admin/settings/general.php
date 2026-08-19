<?php
/**
 * general.php - DT Brand's Admin General Store Settings
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "General Store Settings";
$active_nav = "settings";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Store Settings - DT Brand's Admin</title>
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
                        <span>General Store Settings</span>
                        <span class="adm-badge gold">Store Config</span>
                    </h1>
                    <p class="adm-page-subtitle">Store title, currency (INR ₹), timezone, and default language settings.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/settings/" class="adm-btn-secondary">← Back to Settings Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>⚙️ General Settings</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('General Settings Saved!')">Save Settings</button>
            </div>
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Store Currency</label>
                    <input type="text" class="adm-form-input" value="INR (₹) - Indian Rupee" readonly>
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Timezone</label>
                    <input type="text" class="adm-form-input" value="Asia/Kolkata (IST +5:30)" readonly>
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
