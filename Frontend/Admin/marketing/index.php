<?php
/**
 * index.php - DT Brand's Admin Marketing Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Marketing Campaigns & Promo Studio";
$active_nav = "marketing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketing Campaigns & Promo Studio - DT Brand's Admin</title>
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
                        <span>Marketing Campaigns & Promo Studio</span>
                        <span class="adm-badge gold">Active Campaigns</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage top banners, festive flash sale countdowns, and discount coupon codes.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Active Campaigns</span>
                <div class="adm-kpi-icon-box">📢</div>
            </div>
            <div class="adm-kpi-val">3 Live</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Festive Silk Mela</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Coupons Redeemed</span>
                <div class="adm-kpi-icon-box">🎟️</div>
            </div>
            <div class="adm-kpi-val">482</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">₹1,24,000 Discount</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Flash Sale GMV</span>
                <div class="adm-kpi-icon-box">⚡</div>
            </div>
            <div class="adm-kpi-val">₹6.84L</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">↑ +28% Sales Spike</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Campaign ROI</span>
                <div class="adm-kpi-icon-box">📈</div>
            </div>
            <div class="adm-kpi-val">6.4x</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">WhatsApp + Social</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>🎟️ Active Coupons & Promo Codes</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Opening Create Coupon Dialog...')">+ Create New Coupon</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Coupon Code</th>
                            <th>Discount Type</th>
                            <th>Min. Order Value</th>
                            <th>Target Audience</th>
                            <th>Redemptions</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong style="color:#8A681F; font-size:0.9rem;">FESTIVE15</strong></td>
                            <td>15% Flat Discount</td>
                            <td>₹2,999</td>
                            <td>All Retail Buyers</td>
                            <td><strong>284 used</strong></td>
                            <td><span class="adm-badge success">Active</span></td>
                        </tr>
                        <tr>
                            <td><strong style="color:#8A681F; font-size:0.9rem;">VIPWHOLESALE5</strong></td>
                            <td>5% Extra on Lot</td>
                            <td>₹50,000</td>
                            <td>Wholesale Partners</td>
                            <td><strong>42 used</strong></td>
                            <td><span class="adm-badge gold">VIP Tier</span></td>
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
