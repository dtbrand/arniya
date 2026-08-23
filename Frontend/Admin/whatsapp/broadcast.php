<?php
/**
 * broadcast.php - DT Brand's Admin WhatsApp Broadcast Studio
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "WhatsApp Broadcast Studio";
$active_nav = "whatsapp";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Broadcast Studio - DT Brand's Admin</title>
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
                        <span>WhatsApp Broadcast Studio</span>
                        <span class="adm-badge gold">Broadcaster</span>
                    </h1>
                    <p class="adm-page-subtitle">Send customized WhatsApp promotional messages to verified B2B wholesale buyers.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/whatsapp/" class="adm-btn-secondary">← Back to Whatsapp Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📢 WhatsApp Broadcast Launcher</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('🚀 Broadcast sent to 46 VIP partners!')">🚀 Launch Broadcast</button>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Audience</label>
                <select class="adm-form-select">
                    <option>All Wholesalers (46 VIP)</option>
                    <option>All Resellers (348)</option>
                </select>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
