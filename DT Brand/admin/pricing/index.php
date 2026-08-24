<?php
/**
 * index.php - DT Brand's Admin Pricing Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Multi-Tier Price & Margin Matrix";
$active_nav = "pricing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Tier Price & Margin Matrix - DT Brand's Admin</title>
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
                        <span>Multi-Tier Price & Margin Matrix</span>
                        <span class="adm-badge gold">Tiered System</span>
                    </h1>
                    <p class="adm-page-subtitle">Define customized wholesale MOQ pricing, reseller margins, and festive discount coupons.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Wholesale Discount</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">35% - 45%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">On MOQs of 8-24 pcs</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Reseller Margin Pool</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">12% - 18%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Earned Per Piece</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Active Promo Codes</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">6 Codes</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Festive & VIP Tiers</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Bulk Lot Discount</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Extra 5%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Orders > 50 pcs</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Tier Pricing Configuration Matrix</span></h3>
                    <button class="adm-btn-primary" onclick="window.showToast('Price Matrix Saved!')">Update Price Matrix</button>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Retail MRP</th>
                                <th>Reseller Price</th>
                                <th>Wholesale (8+ pcs)</th>
                                <th>Bulk Lot (30+ pcs)</th>
                                <th>Target Gross Margin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Kanjivaram Silk Sarees</strong></td>
                                <td>₹4,490 / pc</td>
                                <td><strong style="color:#7E22CE;">₹3,450 / pc</strong></td>
                                <td><strong style="color:#8A681F;">₹2,850 / pc</strong></td>
                                <td><strong style="color:#15803D;">₹2,650 / pc</strong></td>
                                <td><span class="adm-badge success">38.4% Margin</span></td>
                            </tr>
                            <tr>
                                <td><strong>Banarasi Brocade Sarees</strong></td>
                                <td>₹4,990 / pc</td>
                                <td><strong style="color:#7E22CE;">₹3,850 / pc</strong></td>
                                <td><strong style="color:#8A681F;">₹3,200 / pc</strong></td>
                                <td><strong style="color:#15803D;">₹2,950 / pc</strong></td>
                                <td><span class="adm-badge success">35.2% Margin</span></td>
                            </tr>
                            <tr>
                                <td><strong>Bridal Zardosi Lehengas</strong></td>
                                <td>₹16,490 / pc</td>
                                <td><strong style="color:#7E22CE;">₹13,200 / pc</strong></td>
                                <td><strong style="color:#8A681F;">₹11,500 / pc</strong></td>
                                <td><strong style="color:#15803D;">₹10,500 / pc</strong></td>
                                <td><span class="adm-badge success">42.1% Margin</span></td>
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
