<?php
/**
 * cancelled.php - DT Brand's Admin Cancelled & Voided Orders
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Cancelled & Voided Orders";
$active_nav = "orders";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelled & Voided Orders - DT Brand's Admin</title>
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
                        <span>Cancelled & Voided Orders</span>
                        <span class="adm-badge gold">14 Cancelled</span>
                    </h1>
                    <p class="adm-page-subtitle">Audit log of buyer cancellations, stock rollbacks, and payment refunds.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/orders/" class="adm-btn-secondary">← Back to Orders Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Cancelled Orders Log</h3></div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Reason</th>
                            <th>Refund Status</th>
                            <th>Stock Restored</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>#ORD-9812</strong></td>
                            <td>Vikas Mehta</td>
                            <td>Customer changed delivery address</td>
                            <td><span class="adm-badge success">100% Refunded</span></td>
                            <td><span class="adm-badge success">Restored (+2 pcs)</span></td>
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
