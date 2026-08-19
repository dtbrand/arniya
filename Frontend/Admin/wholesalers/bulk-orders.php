<?php
/**
 * bulk-orders.php - DT Brand's Admin Bulk Lot & Consignment Orders
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Bulk Lot & Consignment Orders";
$active_nav = "wholesalers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Lot & Consignment Orders - DT Brand's Admin</title>
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
                        <span>Bulk Lot & Consignment Orders</span>
                        <span class="adm-badge gold">Lots > 50 pcs</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage large full-bale consignments directly from Surat weaving mills.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/wholesalers/" class="adm-btn-secondary">← Back to Wholesalers Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Bulk Bale Consignments</h3></div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Bale Consignment #</th>
                            <th>Partner</th>
                            <th>Fabric Lot</th>
                            <th>Bale Qty</th>
                            <th>Consignment Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>BALE-2026-081</code></td>
                            <td>Vardhman Textiles</td>
                            <td>Kanjivaram Silk Bale Lot</td>
                            <td><strong>100 pcs</strong></td>
                            <td><strong>₹2,65,000</strong></td>
                            <td><span class="adm-badge success">Dispatched via TCI</span></td>
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
