<?php
/**
 * index.php - DT Brand's Admin Notifications Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Push & Automated Notifications Hub";
$active_nav = "notifications";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Push & Automated Notifications Hub - DT Brand's Admin</title>
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
                        <span>Push & Automated Notifications Hub</span>
                        <span class="adm-badge gold">Multi-Channel</span>
                    </h1>
                    <p class="adm-page-subtitle">Dispatch order dispatch alerts, WhatsApp notices, and restock alarms.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Dispatched Today</span>
                <div class="adm-kpi-icon-box">🔔</div>
            </div>
            <div class="adm-kpi-val">142 Alerts</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">WhatsApp + SMS</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Delivery Rate</span>
                <div class="adm-kpi-icon-box">📱</div>
            </div>
            <div class="adm-kpi-val">99.8%</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Instant Handshake</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Templates Active</span>
                <div class="adm-kpi-icon-box">📝</div>
            </div>
            <div class="adm-kpi-val">14 Templates</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">B2B & B2C Flow</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Open Rate</span>
                <div class="adm-kpi-icon-box">👁️</div>
            </div>
            <div class="adm-kpi-val">84.2%</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">WhatsApp Engagement</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>🔔 Automated Trigger Notification Rules</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Adding New Notification Rule...')">+ New Trigger</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Trigger Event</th>
                            <th>Channel</th>
                            <th>Template Name</th>
                            <th>Auto-Send Condition</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Order Dispatched</strong></td>
                            <td><span class="adm-badge success">WhatsApp + SMS</span></td>
                            <td><code>order_dispatch_v2</code></td>
                            <td>When AWB tracking number is attached</td>
                            <td><span class="adm-badge success">Active</span></td>
                        </tr>
                        <tr>
                            <td><strong>Low Stock Warning</strong></td>
                            <td><span class="adm-badge info">Admin Email</span></td>
                            <td><code>admin_low_stock_alarm</code></td>
                            <td>When SKU stock falls below 5 pcs</td>
                            <td><span class="adm-badge success">Active</span></td>
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
