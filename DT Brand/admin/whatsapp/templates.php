<?php
/**
 * templates.php - DT Brand's Admin Meta WhatsApp Cloud API Templates
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Meta WhatsApp Cloud API Templates";
$active_nav = "whatsapp";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meta WhatsApp Cloud API Templates - DT Brand's Admin</title>
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
                        <span>Meta WhatsApp Cloud API Templates</span>
                        <span class="adm-badge gold">12 Templates</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage pre-approved WhatsApp message templates for order notifications.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/DT%20Brand/admin/whatsapp/" class="adm-btn-secondary">← Back to Whatsapp Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📝 Pre-Approved WhatsApp Templates</span></h3>
            </div>
            <p>1. <code>order_dispatch_v2</code> (Dispatched with AWB Tracking)<br>2. <code>welcome_vip_wholesaler</code> (VIP Account Welcome)<br>3. <code>reseller_margin_payout</code> (Margin Transfer Alert)</p>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/DT%20Brand/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
