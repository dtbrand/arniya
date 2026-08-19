<?php
/**
 * push.php - DT Brand's Admin Instant Push Notification Dispatcher
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Instant Push Notification Dispatcher";
$active_nav = "notifications";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instant Push Notification Dispatcher - DT Brand's Admin</title>
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
                        <span>Instant Push Notification Dispatcher</span>
                        <span class="adm-badge gold">Push Dispatch</span>
                    </h1>
                    <p class="adm-page-subtitle">Send instant browser push alerts to opted-in mobile and desktop buyers.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/notifications/" class="adm-btn-secondary">← Back to Notifications Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>🔔 Instant Push Dispatcher</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Push notification sent to 4,820 users!')">🚀 Send Push Alert</button>
            </div>
            <div class="adm-form-grid">
                <div class="adm-form-group full">
                    <label class="adm-form-label">Alert Title</label>
                    <input type="text" class="adm-form-input" value="✨ Fresh Pure Silk Festive Drop is Live!">
                </div>
                <div class="adm-form-group full">
                    <label class="adm-form-label">Alert Body Message</label>
                    <textarea class="adm-form-textarea" rows="2">Explore new Kanjivaram and Banarasi weaves at exclusive festival discounts. Tap to view.</textarea>
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
