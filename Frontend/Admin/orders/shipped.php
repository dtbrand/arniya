<?php
/**
 * shipped.php - DT Brand's Admin In-Transit Shipments
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "In-Transit Shipments";
$active_nav = "orders";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In-Transit Shipments - DT Brand's Admin</title>
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
                        <span>In-Transit Shipments</span>
                        <span class="adm-badge gold">84 In Transit</span>
                    </h1>
                    <p class="adm-page-subtitle">Live parcel tracking across Surface Cargo, Express Air, and TCI Freight.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/orders/" class="adm-btn-secondary">← Back to Orders Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Live Shipped Consignments</h3></div>
                <button class="adm-btn-secondary" onclick="window.showToast('Syncing Courier API Tracking...')">🔄 Sync Live AWB</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>AWB Tracking</th>
                            <th>Order ID</th>
                            <th>Destination</th>
                            <th>Courier</th>
                            <th>Expected Delivery</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>DEL-994820192</code></td>
                            <td><strong>#ORD-9842</strong></td>
                            <td>Surat → Delhi</td>
                            <td>TCI Freight Cargo</td>
                            <td>Tomorrow, 02:00 PM</td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('WhatsApp tracking update sent!')">💬</button></td>
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
