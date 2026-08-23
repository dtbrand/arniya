<?php
/**
 * index.php - DT Brand's Admin Whatsapp Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "WhatsApp CRM & Broadcast Studio";
$active_nav = "whatsapp";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp CRM & Broadcast Studio - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                        <span>WhatsApp CRM & Broadcast Studio</span>
                        <span class="adm-badge gold">Live Stream</span>
                    </h1>
                    <p class="adm-page-subtitle">Engage B2B buyers and retail customers via official WhatsApp Cloud API.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total Inquiries</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">842</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">1-Click Connect</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Broadcast Audience</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">4,820</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Opted-in Buyers</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">CRM Conversion</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">68%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">High Intent Leads</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">API Status</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">99.98%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Meta Cloud Connected</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-wa-grid">
                <!-- Left: Leads Stream -->
                <div class="adm-card">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title"><span>Live WhatsApp CRM Inquiry Stream</span></h3>
                        <span class="adm-badge green">Real-Time</span>
                    </div>
                    <div class="adm-wa-lead-list">
                        <div class="adm-wa-lead-item" onclick="window.showToast('Connecting WhatsApp...')">
                            <div class="adm-wa-lead-left">
                                <div class="adm-wa-avatar">R</div>
                                <div class="adm-wa-lead-meta">
                                    <span class="adm-wa-lead-name">Rajesh Kumar <small style="color:#8A681F;">+91 98220 19283</small></span>
                                    <span class="adm-wa-lead-inquiry">Inquiry for 50 pcs Kanjivaram Silk lot...</span>
                                </div>
                            </div>
                            <span class="adm-badge gold">Wholesale B2B</span>
                        </div>
                        <div class="adm-wa-lead-item" onclick="window.showToast('Connecting WhatsApp...')">
                            <div class="adm-wa-lead-left">
                                <div class="adm-wa-avatar">P</div>
                                <div class="adm-wa-lead-meta">
                                    <span class="adm-wa-lead-name">Pooja Sharma <small style="color:#8A681F;">+91 98110 29381</small></span>
                                    <span class="adm-wa-lead-inquiry">Asked for tracking link on Order #ORD-9841</span>
                                </div>
                            </div>
                            <span class="adm-badge info">B2C Retail</span>
                        </div>
                    </div>
                </div>
                <!-- Right: Fast Broadcaster -->
                <div class="adm-card">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title"><span>WhatsApp Broadcast Launcher</span></h3>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Target Audience</label>
                        <select class="adm-form-select">
                            <option>All Wholesalers & B2B Partners (46 VIP)</option>
                            <option>All Registered Resellers (348)</option>
                            <option>All Retail Customers (4,820)</option>
                        </select>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Message Template</label>
                        <div class="adm-wa-preview-bubble">
                            <strong>DT BRAND'S FRESH CATALOGUE ALERT</strong><br>
                            Namaste {Name}, explore our latest 2026 Pure Silk Sarees & Designer Lehengas crafted for festive collections.<br>
                            👉 <strong>View:</strong> https://jaihanumantex.in/Frontend/Shop/shop.php
                        </div>
                    </div>
                    <button class="adm-btn-primary" style="width:100%; justify-content:center;" onclick="window.showToast('Broadcast sent to VIP partners!')">Launch Instant Broadcast</button>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
