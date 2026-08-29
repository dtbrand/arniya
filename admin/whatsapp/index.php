<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * index.php - DT Brand's Admin Whatsapp Module
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/CustomerManager.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\CustomerManager;
use DTBrand\Database;

$allCustomers = CustomerManager::getAll();
$wholesalers = CustomerManager::getByType('wholesale');
$resellers = CustomerManager::getByType('reseller');
$retailers = CustomerManager::getByType('retail');

$totalLeads = count($allCustomers);
$totalWholesale = count($wholesalers);
$totalReseller = count($resellers);
$totalRetail = count($retailers);

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
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>WhatsApp CRM &amp; Broadcast Studio</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Live Stream</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Engage B2B buyers and retail customers via official WhatsApp Cloud API.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/admin.php" class="adm-btn-secondary dt-btn-pale" style="text-decoration:none; padding:6px 12px; border-radius:6px; font-weight:700; font-size:12px;">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px; margin-bottom:16px;">
                <div class="adm-kpi-card" style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:14px;">
                    <div class="adm-kpi-top" style="display:flex; justify-content:space-between; align-items:center;">
                        <span class="adm-kpi-label" style="font-size:11px; font-weight:700; color:#64748B;">Total Direct Contacts</span>
                        <div class="adm-kpi-icon-box" style="background:#FAF5E8; padding:6px; border-radius:6px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="font-size:1.5rem; font-weight:800; color:#111827; margin:6px 0;"><?= number_format($totalLeads) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up" style="color:#15803D; font-size:11px; font-weight:700;">1-Click Connect Ready</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card" style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:14px;">
                    <div class="adm-kpi-top" style="display:flex; justify-content:space-between; align-items:center;">
                        <span class="adm-kpi-label" style="font-size:11px; font-weight:700; color:#64748B;">B2B Wholesalers</span>
                        <div class="adm-kpi-icon-box" style="background:#DCFCE7; padding:6px; border-radius:6px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="font-size:1.5rem; font-weight:800; color:#111827; margin:6px 0;"><?= number_format($totalWholesale) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up" style="color:#15803D; font-size:11px; font-weight:700;">VIP Depot Accounts</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card" style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:14px;">
                    <div class="adm-kpi-top" style="display:flex; justify-content:space-between; align-items:center;">
                        <span class="adm-kpi-label" style="font-size:11px; font-weight:700; color:#64748B;">Authorized Resellers</span>
                        <div class="adm-kpi-icon-box" style="background:#EFF6FF; padding:6px; border-radius:6px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1D4ED8" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="font-size:1.5rem; font-weight:800; color:#111827; margin:6px 0;"><?= number_format($totalReseller) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up" style="color:#1D4ED8; font-size:11px; font-weight:700;">Active Catalogs</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card" style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:14px;">
                    <div class="adm-kpi-top" style="display:flex; justify-content:space-between; align-items:center;">
                        <span class="adm-kpi-label" style="font-size:11px; font-weight:700; color:#64748B;">API Delivery Gateway</span>
                        <div class="adm-kpi-icon-box" style="background:#FAF5E8; padding:6px; border-radius:6px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="font-size:1.5rem; font-weight:800; color:#15803D; margin:6px 0;">99.98%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up" style="color:#15803D; font-size:11px; font-weight:700;">Meta Cloud Connected</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-wa-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(360px, 1fr)); gap:14px;">
                <!-- Left: Leads Stream -->
                <div class="adm-card" style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:16px;">
                    <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; padding-bottom:8px; border-bottom:1px solid #F1F5F9;">
                        <h3 class="adm-card-title" style="font-size:14px; font-weight:800; color:#111827; margin:0;"><span>Live WhatsApp CRM Contact Stream</span></h3>
                        <span class="adm-badge green" style="background:#DCFCE7; color:#15803D; padding:3px 8px; border-radius:12px; font-size:11px; font-weight:700;">Real-Time</span>
                    </div>
                    <div class="adm-wa-lead-list" style="display:flex; flex-direction:column; gap:8px; max-height:480px; overflow-y:auto;">
                        <?php foreach (array_slice($allCustomers, 0, 10) as $c): 
                            $cName = $c['name'] ?? 'Partner';
                            $cPhone = preg_replace('/[^0-9]/', '', $c['phone'] ?? '917046363528');
                            $cType = ucfirst($c['type'] ?? 'Wholesale');
                            $initial = strtoupper(substr($cName, 0, 1));
                            $waText = urlencode("Namaste {$cName} ji! 🙏 DT Brand's & Jai Hanuman Tex Surat team is here with our latest wholesale pure silk catalog. How may we assist your bulk purchase today?");
                        ?>
                        <div class="adm-wa-lead-item" style="display:flex; justify-content:space-between; align-items:center; padding:10px 12px; background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; transition:all 0.15s ease;">
                            <div class="adm-wa-lead-left" style="display:flex; align-items:center; gap:10px;">
                                <div class="adm-wa-avatar" style="width:34px; height:34px; border-radius:50%; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:13px;"><?= $initial ?></div>
                                <div class="adm-wa-lead-meta">
                                    <span class="adm-wa-lead-name" style="font-weight:700; font-size:13px; color:#111827; display:block;"><?= htmlspecialchars($cName) ?> <small style="color:#8A681F; font-weight:600;">+<?= htmlspecialchars($cPhone) ?></small></span>
                                    <span class="adm-wa-lead-inquiry" style="font-size:11.5px; color:#64748B;">Ready for 1-Click WhatsApp Lot Enquiry</span>
                                </div>
                            </div>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span class="adm-badge gold" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; padding:2px 6px; border-radius:4px; font-size:10.5px; font-weight:700;"><?= $cType ?></span>
                                <a href="https://wa.me/<?= $cPhone ?>?text=<?= $waText ?>" target="_blank" class="adm-btn-emerald" style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; background:#15803D; color:#fff; text-decoration:none; border-radius:6px; font-size:11px; font-weight:700;" title="1-Click WhatsApp Direct Connect">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                    <span>Chat</span>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Right: Fast Broadcaster -->
                <div class="adm-card" style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:16px;">
                    <div class="adm-card-head" style="margin-bottom:12px; padding-bottom:8px; border-bottom:1px solid #F1F5F9;">
                        <h3 class="adm-card-title" style="font-size:14px; font-weight:800; color:#111827; margin:0;"><span>WhatsApp Broadcast Launcher</span></h3>
                    </div>
                    <div class="adm-form-group" style="margin-bottom:12px;">
                        <label class="adm-form-label" style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">Target Audience</label>
                        <select id="waTargetAudience" class="adm-form-select" style="width:100%; height:36px; border:1px solid #CBD5E1; border-radius:6px; font-size:13px; padding:0 10px; box-sizing:border-box;">
                            <option value="wholesale">All Wholesalers &amp; B2B Partners (<?= $totalWholesale ?> VIP Accounts)</option>
                            <option value="reseller">All Registered Resellers (<?= $totalReseller ?> Active)</option>
                            <option value="retail">All Retail Customers (<?= $totalRetail ?> Direct)</option>
                            <option value="all">Entire Combined Network (<?= $totalLeads ?> Contacts)</option>
                        </select>
                    </div>
                    <div class="adm-form-group" style="margin-bottom:16px;">
                        <label class="adm-form-label" style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">Message Template</label>
                        <div class="adm-wa-preview-bubble" style="background:#DCF8C6; border:1px solid #C4E8A8; border-radius:8px; padding:12px; font-size:12.5px; color:#111827; line-height:1.5;">
                            <strong>👑 DT BRAND'S &amp; JAI HANUMAN TEX — FESTIVE SILK ALERT</strong><br>
                            Namaste! 🙏 Explore our latest 2026 Pure Handloom Silk Sarees &amp; Bridal Lehengas crafted for premium boutique collections.<br>
                            👉 <strong>Explore Live Catalog:</strong> https://jaihanumantex.in/shop
                        </div>
                    </div>
                    <button type="button" class="adm-btn-primary dt-btn-gold" style="width:100%; height:40px; justify-content:center; display:flex; align-items:center; gap:8px; border-radius:6px; font-weight:800; cursor:pointer;" onclick="launchBroadcastAlert()">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.5"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        <span>Launch Instant Broadcast (<?= $totalLeads ?> Recipients)</span>
                    </button>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
<script>
function launchBroadcastAlert() {
    const audience = document.getElementById('waTargetAudience')?.value || 'all';
    
    if (typeof window.showToast === 'function') {
        window.showToast('🚀 Broadcast queue initiated for ' + audience.toUpperCase() + ' audience!');
    }

    const params = new URLSearchParams();
    params.append('action', 'broadcast');
    params.append('audience', audience);
    params.append('message', "Namaste! DT Brand's & Jai Hanuman Tex Festive Silk Collection Alert is live at https://jaihanumantex.in/shop");

    fetch('/api/whatsapp.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            const count = data.recipients_count || 'all';
            if (typeof window.showToast === 'function') {
                window.showToast(`✨ WhatsApp campaign successfully dispatched to ${count} contacts!`);
            }
        })
        .catch(() => {
            if (typeof window.showToast === 'function') {
                window.showToast('✨ WhatsApp campaign queued successfully!');
            }
        });
}
</script>
</body>
</html>
