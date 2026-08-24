<?php
/**
 * index.php - DT Brand's Admin Settings Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Store Settings & Business Profile";
$active_nav = "settings";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Settings & Business Profile - DT Brand's Admin</title>
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
                        <span>Store Settings & Business Profile</span>
                        <span class="adm-badge gold">DT Brand's System</span>
                    </h1>
                    <p class="adm-page-subtitle">Configure company details, GSTIN, WhatsApp API credentials, and payment gateways.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Store Status</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Online</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Production Mode</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">GST Active</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">24AAACV1234F1Z5</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Verified Surat Hub</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Payment Gateway</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Razorpay Active</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">UPI / Cards / Netbanking</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">WhatsApp API</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Meta Connected</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Phone: 919800000000</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Store Profile Configuration</span></h3>
                    <button class="adm-btn-primary" onclick="window.showToast('Settings saved successfully!')">Save Configuration</button>
                </div>
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label">Brand Name</label>
                        <input type="text" class="adm-form-input" value="DT Brand's (Jai Hanuman Tex)">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Support Email</label>
                        <input type="email" class="adm-form-input" value="support@jaihanumantex.in">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">WhatsApp Business Number</label>
                        <input type="text" class="adm-form-input" value="+91 98220 19283">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">GSTIN Registration</label>
                        <input type="text" class="adm-form-input" value="24AAACV1234F1Z5">
                    </div>
                    <div class="adm-form-group full">
                        <label class="adm-form-label">Warehouse Address</label>
                        <textarea class="adm-form-textarea" rows="2">Ring Road Textile Market, Surat, Gujarat - 395002</textarea>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
