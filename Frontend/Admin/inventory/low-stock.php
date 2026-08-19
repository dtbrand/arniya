<?php
/**
 * low-stock.php - DT Brand's Admin Low Stock & Critical Restock Alarms
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Low Stock & Critical Restock Alarms";
$active_nav = "inventory";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock & Critical Restock Alarms - DT Brand's Admin</title>
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
                        <span>Low Stock & Critical Restock Alarms</span>
                        <span class="adm-badge gold">14 Critical SKUs</span>
                    </h1>
                    <p class="adm-page-subtitle">Items with available units below the safety threshold of 5 pcs.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/inventory/" class="adm-btn-secondary">← Back to Inventory Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Critical Low Stock SKUs</h3></div>
                <button class="adm-btn-primary" onclick="window.showToast('Purchase Orders Generated!')">⚡ Re-Order All</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>SKU & Product</th>
                            <th>Available</th>
                            <th>Threshold</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>CHD-CT-109</strong> (Chanderi Cotton)</td>
                            <td><strong style="color:#DC2626;">2 units</strong></td>
                            <td>10 units</td>
                            <td><button class="adm-btn-primary adm-btn-sm" onclick="window.showToast('Purchase Order Sent to Mill!')">⚡ Re-Order 50 pcs</button></td>
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
