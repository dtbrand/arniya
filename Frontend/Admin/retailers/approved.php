<?php
/**
 * approved.php - DT Brand's Admin Approved Retailer Showrooms
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Approved Retailer Showrooms";
$active_nav = "retailers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Retailer Showrooms - DT Brand's Admin</title>
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
                        <span>Approved Retailer Showrooms</span>
                        <span class="adm-badge gold">124 Outlets</span>
                    </h1>
                    <p class="adm-page-subtitle">Active retail store partners with wholesale catalog privileges.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/retailers/" class="adm-btn-secondary">← Back to Retailers Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Active Retailer Directory</h3></div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Store Name</th>
                            <th>Owner</th>
                            <th>City</th>
                            <th>Monthly Orders</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Meera Saree Palace</td>
                            <td>Kishore Shah</td>
                            <td>Mumbai, MH</td>
                            <td><strong>₹1,45,000 / mo</strong></td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('WhatsApp Opened!')">💬</button></td>
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
