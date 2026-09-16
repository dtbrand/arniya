<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * broadcast.php — DT Brand's & Jai Hanuman Tex WhatsApp Broadcast Studio
 * Unified Master Broadcast Launcher & Audience Deep Link Engine
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "WhatsApp Broadcast Studio";
$active_nav = "whatsapp";
$current_subnav = "broadcast";

$audiences = [];
$pdoWa = Database::getConnection();
if ($pdoWa !== null && !Database::isMockMode()) {
    try {
        $rows = Database::query(
            "SELECT type, COUNT(*) AS c FROM customers
             WHERE status = 'active' AND phone != ''
             GROUP BY type"
        );
        $labels = [
            'wholesale' => 'Wholesale VIP Partners',
            'reseller'  => 'Reseller Network',
            'retailer'  => 'Retailer & Boutique Owners',
            'retail'    => 'Direct Retail Shoppers',
        ];
        foreach ($rows as $r) {
            $type = (string)$r['type'];
            if (!isset($labels[$type])) continue;
            $audiences[] = ['type' => $type, 'label' => $labels[$type], 'count' => (int)$r['c']];
        }
    } catch (\Throwable $e) {
        $audiences = [];
    }
}

if (empty($audiences)) {
    $audiences = [
        ['type' => 'wholesale', 'label' => 'Wholesale VIP Partners', 'count' => 18],
        ['type' => 'reseller', 'label' => 'Reseller Network', 'count' => 34],
        ['type' => 'retailer', 'label' => 'Retailer & Boutique Owners', 'count' => 12],
        ['type' => 'retail', 'label' => 'Direct Retail Shoppers', 'count' => 28]
    ];
}

$hasToken = trim((string)getenv('WHATSAPP_ACCESS_TOKEN')) !== ''
    && strpos((string)getenv('WHATSAPP_ACCESS_TOKEN'), 'replace') === false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Broadcast Studio — DT Brand's &amp; Jai Hanuman Tex</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#8A681F">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= @filemtime(__DIR__ . '/../assets/css/admin.css') ?: '3.2.1' ?>">
    <link rel="stylesheet" href="/admin/whatsapp/whatsapp.css?v=<?= @filemtime(__DIR__ . '/whatsapp.css') ?: '3.2.1' ?>">
</head>
<body class="wa-suite">
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <!-- Page Header -->
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span>WhatsApp Broadcast Studio</span>
                        <span class="adm-badge" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800; font-size:0.7rem;">CAMPAIGN ENGINE</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Dispatch automated broadcasts to trade partners or build individual 1-click wa.me action streams.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/whatsapp/" class="wa-btn-pale" style="text-decoration:none;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Concierge Hub</span>
                    </a>
                </div>
            </div>

            <!-- Unified WhatsApp Tabs -->
            <div style="display:flex; gap:6px; overflow-x:auto; margin-bottom:16px; padding-bottom:4px; border-bottom:1px solid #E2E8F0;">
                <a href="/admin/whatsapp/" class="wa-btn-pale" style="padding:6px 12px; font-size:12px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    <span>Concierge Hub</span>
                </a>
                <a href="/admin/whatsapp/broadcast.php" class="wa-btn-emerald" style="padding:6px 12px; font-size:12px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    <span>Broadcast Studio</span>
                </a>
                <a href="/admin/whatsapp/leads.php" class="wa-btn-pale" style="padding:6px 12px; font-size:12px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                    <span>Lead Pipeline</span>
                </a>
                <a href="/admin/whatsapp/templates.php" class="wa-btn-pale" style="padding:6px 12px; font-size:12px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Message Templates &amp; HSM</span>
                </a>
                <a href="/admin/whatsapp/templates.php?tab=gateway" class="wa-btn-pale" style="padding:6px 12px; font-size:12px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    <span>Cloud API Gateway</span>
                </a>
            </div>

            <!-- Two Column Split: Broadcast Form + Live Simulation -->
            <div class="wa-grid-split" style="display:grid; grid-template-columns:1.2fr 1fr; gap:16px;">
                
                <!-- Campaign Builder Card -->
                <div class="adm-card" style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:18px; margin-bottom:0;">
                    <div class="adm-card-head" style="margin-bottom:14px; padding-bottom:8px; border-bottom:1px solid #F1F5F9; display:flex; justify-content:space-between; align-items:center;">
                        <h3 class="adm-card-title" style="font-size:14px; font-weight:800; color:#111827; margin:0;">
                            <span>Campaign Audience &amp; Message Builder</span>
                        </h3>
                        <span class="adm-badge <?= $hasToken ? 'green' : 'gold' ?>">
                            <?= $hasToken ? 'Meta Cloud API V19.0 Active' : 'Dual Mode: Cloud API + Direct wa.me' ?>
                        </span>
                    </div>

                    <div class="adm-form-group" style="margin-bottom:12px;">
                        <label class="adm-form-label" style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">Target Audience</label>
                        <select class="adm-form-select wa-select" id="dtWaAudience" style="width:100%; height:38px; border:1px solid #CBD5E1; border-radius:6px; font-size:13px; padding:0 10px; box-sizing:border-box;">
                            <?php foreach ($audiences as $a): ?>
                                <option value="<?= htmlspecialchars($a['type']) ?>"><?= htmlspecialchars($a['label']) ?> (<?= (int)$a['count'] ?> Verified Contacts)</option>
                            <?php endforeach; ?>
                            <option value="all">Entire Combined Network (All Trade Tiers)</option>
                        </select>
                    </div>

                    <div class="adm-form-group" style="margin-bottom:12px;">
                        <label class="adm-form-label" style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">Quick Template Preset</label>
                        <select id="dtPresetSelect" class="adm-form-select wa-select" style="width:100%; height:38px; border:1px solid #CBD5E1; border-radius:6px; font-size:13px; padding:0 10px; box-sizing:border-box;" onchange="applyPresetTemplate()">
                            <option value="festive">Festive Pure Silk &amp; Banarasi Weaves Drop</option>
                            <option value="wholesale_offer">Surat Master Lot Wholesale Discount (15% Off)</option>
                            <option value="order_status">B2B Order Dispatch &amp; Live Tracking Notice</option>
                        </select>
                    </div>

                    <div class="adm-form-group" style="margin-bottom:14px;">
                        <label class="adm-form-label" style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">Campaign Message Text</label>
                        <textarea class="adm-form-input wa-textarea" id="dtWaMsg" rows="4" style="width:100%; height:auto; padding:10px 12px; font-size:12.5px; box-sizing:border-box; resize:none;" oninput="DTWhatsApp.syncMockup('dtWaMsg', 'bcastMockupBody')">Namaste! DT Brand's &amp; Jai Hanuman Tex is offering factory-direct rates on our latest pure Silk &amp; Banarasi Saree lots. View catalogue: https://jaihanumantex.in/shop</textarea>
                    </div>

                    <!-- Progress bar -->
                    <div class="wa-progress-track" style="margin-bottom:14px;">
                        <div class="wa-progress-fill" id="dtBcastProgress"></div>
                    </div>

                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        <button type="button" class="wa-btn-gold" style="flex:1; height:38px;" onclick="DTWhatsApp.launchBroadcast('dtWaAudience', 'dtWaMsg', 'dtBcastProgress')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.5"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                            <span>Launch Cloud Broadcast</span>
                        </button>
                        <button type="button" class="wa-btn-pale" style="height:38px;" onclick="buildBroadcastLinks()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            <span>Generate wa.me Links</span>
                        </button>
                    </div>

                    <!-- Generated Links Output List -->
                    <div id="dtWaOut" style="display:none; margin-top:14px; background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:12px; max-height:220px; overflow-y:auto; font-size:12px;"></div>
                </div>

                <!-- Right: Phone Chat Frame Mockup -->
                <div class="wa-phone-container">
                    <div class="wa-phone-notch"></div>
                    <div class="wa-phone-screen">
                        <div class="wa-phone-header">
                            <div class="wa-phone-avatar">DT</div>
                            <div class="wa-phone-meta">
                                <h4>DT Brand's &amp; Jai Hanuman Tex</h4>
                                <span><span class="wa-radar-dot"></span> Official Business Account &bull; Online</span>
                            </div>
                        </div>
                        <div class="wa-phone-body">
                            <div class="wa-chat-bubble wa-bubble-received">
                                <div>Namaste! Welcome to DT Brand's &amp; Jai Hanuman Tex Surat handloom catalog concierge.</div>
                                <div class="wa-bubble-time">10:45 AM</div>
                            </div>
                            <div class="wa-chat-bubble wa-bubble-sent">
                                <div id="bcastMockupBody">Namaste! DT Brand's &amp; Jai Hanuman Tex is offering factory-direct rates on our latest pure Silk &amp; Banarasi Saree lots. View catalogue: https://jaihanumantex.in/shop</div>
                                <div class="wa-bubble-time">
                                    <span>Just now</span>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.4"><path d="M18 6L7 17l-5-5"></path><path d="M22 10l-7.5 7.5L13 16"></path></svg>
                                </div>
                            </div>
                        </div>
                        <div class="wa-phone-footer">
                            <input type="text" class="wa-phone-input" placeholder="Type a message" readonly value="Ready for 1-Tap Reply">
                            <button type="button" class="wa-phone-send-btn">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/assets/js/admin.js?v=<?= @filemtime(__DIR__ . '/../assets/js/admin.js') ?: '3.2.1' ?>"></script>
<script src="/admin/whatsapp/whatsapp.js?v=<?= @filemtime(__DIR__ . '/whatsapp.js') ?: '3.2.1' ?>"></script>
<script>
function applyPresetTemplate() {
    const val = document.getElementById('dtPresetSelect').value;
    const msg = document.getElementById('dtWaMsg');
    if (val === 'festive') {
        msg.value = "Namaste! DT Brand's & Jai Hanuman Tex Festive Silk Collection is now available. Pure Kanjivaram & Banarasi Handloom with Surat wholesale pricing: https://jaihanumantex.in/shop";
    } else if (val === 'wholesale_offer') {
        msg.value = "Namaste Partner! Exclusive Surat Loom Discount: Order 10+ Master Bales this week and receive an instant 15% wholesale rebate. Enquire with your mill manager now!";
    } else if (val === 'order_status') {
        msg.value = "Namaste! Your pure silk order has been dispatched from Surat Handloom Depot via Delhivery Express. Live tracking: https://jaihanumantex.in/track";
    }
    DTWhatsApp.syncMockup('dtWaMsg', 'bcastMockupBody');
}

function buildBroadcastLinks() {
    const type = document.getElementById('dtWaAudience').value;
    const msg = document.getElementById('dtWaMsg').value.trim();
    const out = document.getElementById('dtWaOut');
    if (!type) return;

    out.style.display = 'block';
    out.innerHTML = '<div style="color:#64748B;">Fetching verified audience contacts…</div>';

    fetch('/api/whatsapp/audience.php?type=' + encodeURIComponent(type), { credentials: 'same-origin' })
        .then(r => r.json())
        .then(d => {
            if (d && d.success === false) {
                out.innerHTML = '<div style="color:#DC2626;">' + (d.message || 'Failed to fetch contacts') + '</div>';
                return;
            }
            const customers = d.customers || [];
            if (!customers.length) {
                out.innerHTML = '<div style="color:#64748B;">No matching customers with phone numbers.</div>';
                return;
            }
            let html = '<div style="font-weight:700; margin-bottom:8px; color:#111827;">' + customers.length + ' 1-Click WhatsApp Action Links:</div>';
            customers.forEach(c => {
                let phone = String(c.phone || '').replace(/[^0-9]/g, '');
                if (phone.length === 10) phone = '91' + phone;
                const link = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(msg);
                html += `
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid #F1F5F9;">
                        <span><strong>${c.name}</strong> <small style="color:#64748B;">(+${phone})</small></span>
                        <a href="${link}" target="_blank" rel="noopener" class="wa-btn-emerald" style="padding:3px 8px; font-size:11px;">Open Chat &rarr;</a>
                    </div>
                `;
            });
            out.innerHTML = html;
        })
        .catch(() => {
            out.innerHTML = '<div style="color:#DC2626;">Could not reach the server.</div>';
        });
}
</script>
</body>
</html>