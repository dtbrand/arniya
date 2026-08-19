<?php
/**
 * index.php - DT Brand's Admin Payments Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Payment Gateways & Ledger Settlement";
$active_nav = "payments";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateways & Ledger Settlement - DT Brand's Admin</title>
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
                        <span>Payment Gateways & Ledger Settlement</span>
                        <span class="adm-badge gold">99.2% Success</span>
                    </h1>
                    <p class="adm-page-subtitle">Track UPI, NEFT Bank Wire, COD remittances, Razorpay gateways, and refunds.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Total Collections</span>
                <div class="adm-kpi-icon-box">💳</div>
            </div>
            <div class="adm-kpi-val">₹42,85,900</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">MTD Processed</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">UPI / Netbanking</span>
                <div class="adm-kpi-icon-box">⚡</div>
            </div>
            <div class="adm-kpi-val">₹28,40,000</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">66.2% Prepaid Share</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Bank Wire (B2B)</span>
                <div class="adm-kpi-icon-box">🏦</div>
            </div>
            <div class="adm-kpi-val">₹12,40,000</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">NEFT / RTGS Large Lots</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">COD Remittances</span>
                <div class="adm-kpi-icon-box">💵</div>
            </div>
            <div class="adm-kpi-val">₹2,05,900</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Settled via Delhivery</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>💳 Transaction & Settlement Ledger</span></h3>
                <button class="adm-btn-secondary" onclick="window.showToast('Downloading Payment Ledger CSV...')">📥 Export Ledger</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Txn ID</th>
                            <th>Order ID</th>
                            <th>Buyer</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Gateway Ref.</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>TXN-884192</code></td>
                            <td><strong>#ORD-9842</strong></td>
                            <td>Rajesh Kumar (Vardhman)</td>
                            <td><strong>₹1,12,250</strong></td>
                            <td>NEFT Bank Wire</td>
                            <td>HDFC99482019</td>
                            <td><span class="adm-badge success">Settled</span></td>
                        </tr>
                        <tr>
                            <td><code>TXN-884191</code></td>
                            <td><strong>#ORD-9841</strong></td>
                            <td>Pooja Sharma</td>
                            <td><strong>₹4,990</strong></td>
                            <td>UPI Instant</td>
                            <td>rzp_live_994821</td>
                            <td><span class="adm-badge success">Settled</span></td>
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
