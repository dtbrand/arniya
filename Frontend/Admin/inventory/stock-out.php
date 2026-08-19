<?php
/**
 * stock-out.php - DT Brand's Admin Stock Outward & Dispatch Log
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Stock Outward & Dispatch Log";
$active_nav = "inventory";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Outward & Dispatch Log - DT Brand's Admin</title>
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
                        <span>Stock Outward & Dispatch Log</span>
                        <span class="adm-badge gold">Dispatches</span>
                    </h1>
                    <p class="adm-page-subtitle">Log of all stock deductions for order fulfillment, samples, and trade exhibitions.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/inventory/" class="adm-btn-secondary">← Back to Inventory Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Stock Outward Log</h3></div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Date / Time</th>
                            <th>SKU</th>
                            <th>Deducted Qty</th>
                            <th>Order ID / Purpose</th>
                            <th>Operator</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Today, 11:30 AM</td>
                            <td>KLN-SR-111</td>
                            <td><strong>-25 pcs</strong></td>
                            <td>#ORD-9842 (Vardhman B2B)</td>
                            <td>Surat Dispatch Staff</td>
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
