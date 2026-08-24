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
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Active Campaigns</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">3 Live</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Festive Silk Mela</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Coupons Redeemed</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">482</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">₹1,24,000 Discount</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Flash Sale GMV</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">₹6.84L</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">↑ +28% Sales Spike</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Campaign ROI</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        </div>
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
                    <h3 class="adm-card-title"><span>Active Coupons & Promo Codes</span></h3>
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
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
