<?php
/**
 * index.php - DT Brand's Admin Wholesalers Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Wholesalers B2B Consignment Hub";
$active_nav = "wholesalers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesalers B2B Consignment Hub - DT Brand's Admin</title>
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
                        <span>Wholesalers B2B Consignment Hub</span>
                        <span class="adm-badge gold">46 VIP Wholesalers</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage bulk textile consignments, GST verification, and trade credit terms.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Active Wholesalers</span>
                <div class="adm-kpi-icon-box">🏢</div>
            </div>
            <div class="adm-kpi-val">46</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Tier 1 VIP Partners</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Consignments MTD</span>
                <div class="adm-kpi-icon-box">📦</div>
            </div>
            <div class="adm-kpi-val">68</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">₹28.4L B2B Revenue</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Pending KYC</span>
                <div class="adm-kpi-icon-box">📋</div>
            </div>
            <div class="adm-kpi-val">2</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta down">GST Verification Needed</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Avg Consignment</span>
                <div class="adm-kpi-icon-box">💎</div>
            </div>
            <div class="adm-kpi-val">₹64,500</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">24-48 pcs MOQ Lot</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; color:#181512;">Wholesaler Master Roster</h3></div>
                <div class="adm-page-actions">
                    <button class="adm-btn-primary" onclick="window.showToast('Adding New Wholesaler Partner...')">+ Add Wholesaler</button>
                </div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Partner ID & Business</th>
                            <th>Owner / Contact</th>
                            <th>GSTIN Number</th>
                            <th>Trade Tier</th>
                            <th>Payment Terms</th>
                            <th>Total Spend</th>
                            <th>KYC Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>#WS-101</strong><br><strong>Vardhman Textiles</strong></td>
                            <td>Rajesh Kumar<br><small style="color:#8A681F;">+91 98220 19283 • Surat</small></td>
                            <td><code>24AAACV1234F1Z5</code></td>
                            <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:2px 8px; border-radius:6px;">Tier 1 VIP</span></td>
                            <td>Net 15 Days</td>
                            <td><strong>₹8,45,000</strong> (14 orders)</td>
                            <td><span class="adm-badge success">Verified</span></td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('Opening WhatsApp VIP Chat...')">💬</button></td>
                        </tr>
                        <tr>
                            <td><strong>#WS-102</strong><br><strong>Shree Ambika Silks</strong></td>
                            <td>Mahesh Patel<br><small style="color:#8A681F;">+91 98980 34211 • Ahmedabad</small></td>
                            <td><code>24AABCS5432G1Z8</code></td>
                            <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:2px 8px; border-radius:6px;">Gold Partner</span></td>
                            <td>Immediate Bank Wire</td>
                            <td><strong>₹4,20,000</strong> (8 orders)</td>
                            <td><span class="adm-badge warning">Pending GST</span></td>
                            <td><button class="adm-btn-secondary" style="padding:3px 8px; font-size:0.72rem;" onclick="window.showToast('GST Verified!')">Approve</button></td>
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
