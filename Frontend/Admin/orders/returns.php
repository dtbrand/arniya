<?php
/**
 * returns.php - DT Brand's Admin Returns & Replacement Center
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Returns & Replacement Center";
$active_nav = "orders";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returns & Replacement Center - DT Brand's Admin</title>
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
                        <span>Returns & Replacement Center</span>
                        <span class="adm-badge gold">3 Active RTOs</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage return consignments, quality inspection, and exchange shipments.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/orders/" class="adm-btn-secondary">← Back to Orders Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Return Requests & QC Inspection</h3></div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Return ID</th>
                            <th>Original Order</th>
                            <th>Item Returned</th>
                            <th>QC Status</th>
                            <th>Resolution</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>#RET-401</strong></td>
                            <td>#ORD-9780</td>
                            <td>Banarasi Brocade (Red)</td>
                            <td><span class="adm-badge warning">Inspecting at Surat Hub</span></td>
                            <td><button class="adm-btn-primary adm-btn-sm" onclick="window.showToast('Replacement Saree Dispatched!')">Dispatch Exchange</button></td>
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
