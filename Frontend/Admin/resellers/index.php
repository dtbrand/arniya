<?php
/**
 * index.php - DT Brand's Admin Resellers Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Resellers Network & Payouts Hub";
$active_nav = "resellers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resellers Network & Payouts Hub - DT Brand's Admin</title>
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
                        <span>Resellers Network & Payouts Hub</span>
                        <span class="adm-badge gold">348 Resellers</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage boutique social sellers, margin settings, and weekly payout settlements.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Active Resellers</span>
                <div class="adm-kpi-icon-box">🤝</div>
            </div>
            <div class="adm-kpi-val">348</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Across 22 States</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Reseller Orders</span>
                <div class="adm-kpi-icon-box">🛍️</div>
            </div>
            <div class="adm-kpi-val">842</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">₹14.8L Gross Volume</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Pending Payouts</span>
                <div class="adm-kpi-icon-box">💳</div>
            </div>
            <div class="adm-kpi-val">₹48,500</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta down">12 Reseller Requests</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Avg Margin Earned</span>
                <div class="adm-kpi-icon-box">✨</div>
            </div>
            <div class="adm-kpi-val">₹420/pc</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">12.6% Reseller Share</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; color:#181512;">Reseller Performance & Margin Payouts</h3></div>
                <button class="adm-btn-primary" onclick="window.showToast('Processing Batch Reseller Payouts...')">⚡ Settle All Payouts</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Reseller ID & Name</th>
                            <th>Boutique Store Name</th>
                            <th>Phone / City</th>
                            <th>Orders Dispatched</th>
                            <th>Total Sales</th>
                            <th>Earned Margins</th>
                            <th>KYC Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>#RS-801</strong><br>Ananya Roy</td>
                            <td><strong>Ananya Boutique</strong></td>
                            <td>+91 97118 23901 • Jaipur, RJ</td>
                            <td><strong>142 pcs</strong></td>
                            <td>₹3,84,000</td>
                            <td><strong style="color:#15803D;">₹42,600</strong></td>
                            <td><span class="adm-badge success">Verified</span></td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('WhatsApp Payout Alert sent!')">💬</button></td>
                        </tr>
                        <tr>
                            <td><strong>#RS-802</strong><br>Simran Kaur</td>
                            <td><strong>Simran Ethnic Weaves</strong></td>
                            <td>+91 98110 59281 • Ludhiana, PB</td>
                            <td><strong>88 pcs</strong></td>
                            <td>₹2,10,000</td>
                            <td><strong style="color:#15803D;">₹24,800</strong></td>
                            <td><span class="adm-badge success">Verified</span></td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('WhatsApp Payout Alert sent!')">💬</button></td>
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
