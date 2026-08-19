<?php
/**
 * index.php - DT Brand's Admin Retailers Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Retailers B2B Accounts Suite";
$active_nav = "retailers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailers B2B Accounts Suite - DT Brand's Admin</title>
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
                        <span>Retailers B2B Accounts Suite</span>
                        <span class="adm-badge gold">124 Outlets</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage boutique showrooms, regional textile retail outlets, and recurring orders.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Active Retailers</span>
                <div class="adm-kpi-icon-box">🏬</div>
            </div>
            <div class="adm-kpi-val">124</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Across 18 Cities</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Monthly Retailer Sales</span>
                <div class="adm-kpi-icon-box">📈</div>
            </div>
            <div class="adm-kpi-val">₹8,24,000</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">↑ +12.4% vs last mo</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Average Order Value</span>
                <div class="adm-kpi-icon-box">🛍️</div>
            </div>
            <div class="adm-kpi-val">₹18,400</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">12-24 pcs/order</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Payment Terms</span>
                <div class="adm-kpi-icon-box">💳</div>
            </div>
            <div class="adm-kpi-val">Net 7 / COD</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">98% On-Time Settle</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div class="adm-table-filters">
                    <select class="adm-filter-select">
                        <option>All Regions (Surat, Mumbai, Delhi, Jaipur)</option>
                        <option>West Zone (Gujarat / Maharashtra)</option>
                        <option>North Zone (Delhi / Punjab / Rajasthan)</option>
                        <option>South Zone (Bengaluru / Hyderabad)</option>
                    </select>
                </div>
                <div class="adm-page-actions">
                    <button class="adm-btn-primary" onclick="window.showToast('Adding New Retailer Account...')">+ Add Retailer Account</button>
                </div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Store ID & Name</th>
                            <th>Proprietor</th>
                            <th>City / State</th>
                            <th>GSTIN</th>
                            <th>Monthly Volume</th>
                            <th>Account Tier</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>#RET-201</strong><br><strong>Meera Saree Palace</strong></td>
                            <td>Kishore Shah<br><small style="color:#8A681F;">+91 98200 44123</small></td>
                            <td>Mumbai, MH</td>
                            <td><code>27AAACM9981K1Z2</code></td>
                            <td><strong>₹1,45,000</strong> (8 orders)</td>
                            <td><span class="adm-badge gold">Premium Retailer</span></td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('Connecting via WhatsApp...')">💬</button></td>
                        </tr>
                        <tr>
                            <td><strong>#RET-202</strong><br><strong>Dulhan Saree Emporium</strong></td>
                            <td>Ramesh Verma<br><small style="color:#8A681F;">+91 98112 33451</small></td>
                            <td>Jaipur, RJ</td>
                            <td><code>08AAACD4412L1Z9</code></td>
                            <td><strong>₹98,000</strong> (5 orders)</td>
                            <td><span class="adm-badge success">Active</span></td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('Connecting via WhatsApp...')">💬</button></td>
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
