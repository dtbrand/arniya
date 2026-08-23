<?php
/**
 * pending.php - DT Brand's Admin Pending Payments & Invoices
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Pending Payments & Invoices";
$active_nav = "payments";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Payments & Invoices - DT Brand's Admin</title>
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
                        <span>Pending Payments & Invoices</span>
                        <span class="adm-badge gold">2 Invoices</span>
                    </h1>
                    <p class="adm-page-subtitle">Awaiting NEFT / RTGS bank wire verification from wholesale partners.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/payments/" class="adm-btn-secondary">← Back to Payments Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Pending Bank Wire Verification</h3></div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Wholesaler</th>
                            <th>Amount</th>
                            <th>UTR #</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ORD-9843</td>
                            <td>Shree Ambika Silks</td>
                            <td><strong>₹42,000</strong></td>
                            <td><code>HDFC99482019</code></td>
                            <td><button class="adm-btn-primary adm-btn-sm" onclick="window.showToast('Payment Verified!')">✓ Verify & Settle</button></td>
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
