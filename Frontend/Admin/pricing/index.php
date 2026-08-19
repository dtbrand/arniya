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
                        <span>Multi-Tier Price & Margin Matrix</span>
                        <span class="adm-badge gold">Tiered System</span>
                    </h1>
                    <p class="adm-page-subtitle">Define customized wholesale MOQ pricing, reseller margins, and festive discount coupons.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Wholesale Discount</span>
                <div class="adm-kpi-icon-box">🏷️</div>
            </div>
            <div class="adm-kpi-val">35% - 45%</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">On MOQs of 8-24 pcs</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Reseller Margin Pool</span>
                <div class="adm-kpi-icon-box">🤝</div>
            </div>
            <div class="adm-kpi-val">12% - 18%</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Earned Per Piece</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Active Promo Codes</span>
                <div class="adm-kpi-icon-box">🎟️</div>
            </div>
            <div class="adm-kpi-val">6 Codes</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Festive & VIP Tiers</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Bulk Lot Discount</span>
                <div class="adm-kpi-icon-box">📦</div>
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
                <h3 class="adm-card-title"><span>🏷️ Tier Pricing Configuration Matrix</span></h3>
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
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
