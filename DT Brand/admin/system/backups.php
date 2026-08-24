<?php
/**
 * backups.php - DT Brand's Admin Automated Hourly Snapshots & Backups
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Automated Hourly Snapshots & Backups";
$active_nav = "system";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automated Hourly Snapshots & Backups - DT Brand's Admin</title>
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
                        <span>Automated Hourly Snapshots & Backups</span>
                        <span class="adm-badge gold">Hourly OK</span>
                    </h1>
                    <p class="adm-page-subtitle">Automated database and file system snapshots with 1-click restore.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/DT%20Brand/admin/system/" class="adm-btn-secondary">← Back to System Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>💾 Snapshot Backups</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Creating Full System Backup...')">+ Create Instant Snapshot</button>
            </div>
            <p>Last automated snapshot: <strong>Today, 12:00 AM (Size: 18.4 MB)</strong> — <span class="adm-badge success">Verified OK</span></p>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/DT%20Brand/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
