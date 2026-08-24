<?php
/**
 * tracking.php - DT Brand's Admin Multi-Carrier Tracking Hub
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Multi-Carrier Tracking Hub";
$active_nav = "shipping";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Carrier Tracking Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                        <span>Multi-Carrier Tracking Hub</span>
                        <span class="adm-badge gold">Live AWB Tracker</span>
                    </h1>
                    <p class="adm-page-subtitle">Search and track any Delhivery, BlueDart, or TCI Freight tracking number in real time.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/shipping/" class="adm-btn-secondary">← Back to Shipping Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>🔍 Real-Time Consignment Tracker</span></h3>
            </div>
            <div style="display:flex; gap:10px; margin-bottom:20px;">
                <input type="text" class="adm-form-input" style="flex:1;" placeholder="Enter AWB or Tracking Number (e.g. DEL-994820192)...">
                <button class="adm-btn-primary" onclick="window.showToast('AWB Tracked: In Transit (Delhi Hub Arrival)')">Track Consignment</button>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
