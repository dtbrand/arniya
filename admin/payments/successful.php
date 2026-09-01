<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * successful.php - DT Brand's Admin Settled Payments Ledger
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Settled Payments Ledger";
$active_nav = "payments";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settled Payments Ledger - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Settled Payments Ledger</span>
                        <span class="adm-badge gold">₹42.85L Settled</span>
                    </h1>
                    <p class="adm-page-subtitle">Complete ledger of successful UPI, netbanking, and bank wire transactions.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/payments/" class="adm-btn-secondary">← Back to Payments Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Settled Transactions</h3></div>
                <button class="adm-btn-secondary" onclick="window.location.href='/admin/orders/export.php?download=1&format=csv';">📥 Export Ledger</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Txn ID</th>
                            <th>Order</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>TXN-884192</code></td>
                            <td>#ORD-9842</td>
                            <td><strong>₹1,12,250</strong></td>
                            <td>NEFT Bank Wire</td>
                            <td><span class="adm-badge success">Settled</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
