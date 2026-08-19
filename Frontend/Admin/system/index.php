<?php
/**
 * index.php - DT Brand's Admin System Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "System Diagnostics & Server Health";
$active_nav = "system";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Diagnostics & Server Health - DT Brand's Admin</title>
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
                        <span>System Diagnostics & Server Health</span>
                        <span class="adm-badge gold">100% Operational</span>
                    </h1>
                    <p class="adm-page-subtitle">Monitor PHP execution, MySQL database latencies, hourly backups, and cache performance.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">PHP Version</span>
                <div class="adm-kpi-icon-box">⚡</div>
            </div>
            <div class="adm-kpi-val">PHP 8.2</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">OPcache Enabled</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Database Query Latency</span>
                <div class="adm-kpi-icon-box">🗄️</div>
            </div>
            <div class="adm-kpi-val">1.2 ms</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Optimal Performance</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Server Storage</span>
                <div class="adm-kpi-icon-box">💾</div>
            </div>
            <div class="adm-kpi-val">42% Free</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">28.4 GB Available</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Automated Backup</span>
                <div class="adm-kpi-icon-box">🛡️</div>
            </div>
            <div class="adm-kpi-val">Hourly OK</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Last run: 15 mins ago</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>⚡ Live System Health Meters</span></h3>
                <button class="adm-btn-secondary" onclick="window.showToast('Running system diagnostics...')">🔄 Run Diagnostics</button>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
                <div style="padding:14px; background:#DCFCE7; border:1px solid #BBF7D0; border-radius:6px; color:#15803D;">
                    <strong>● Apache Engine:</strong> Active OK
                </div>
                <div style="padding:14px; background:#DCFCE7; border:1px solid #BBF7D0; border-radius:6px; color:#15803D;">
                    <strong>● MySQL Database:</strong> Connected (1.2ms)
                </div>
                <div style="padding:14px; background:#DCFCE7; border:1px solid #BBF7D0; border-radius:6px; color:#15803D;">
                    <strong>● SSL Certificate:</strong> Valid (256-bit)
                </div>
                <div style="padding:14px; background:#DCFCE7; border:1px solid #BBF7D0; border-radius:6px; color:#15803D;">
                    <strong>● WhatsApp API:</strong> 99.98% Up
                </div>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
