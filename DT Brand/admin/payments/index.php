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
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total Collections</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">₹42,85,900</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">MTD Processed</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">UPI / Netbanking</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">₹28,40,000</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">66.2% Prepaid Share</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Bank Wire (B2B)</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="3" y1="21" x2="21" y2="21"></line><line x1="3" y1="10" x2="21" y2="10"></line><polyline points="5 6 12 3 19 6"></polyline><line x1="4" y1="10" x2="4" y2="21"></line><line x1="20" y1="10" x2="20" y2="21"></line><line x1="8" y1="14" x2="8" y2="17"></line><line x1="12" y1="14" x2="12" y2="17"></line><line x1="16" y1="14" x2="16" y2="17"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">₹12,40,000</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">NEFT / RTGS Large Lots</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">COD Remittances</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
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
                    <h3 class="adm-card-title"><span>Transaction & Settlement Ledger</span></h3>
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
<script src="/DT%20Brand/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
