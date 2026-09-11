<?php
/**
 * admin/notifications/sms.php — DLT High-Priority SMS Console
 * Section 31 (Notification Admin)
 * DT Brand's & Jai Hanuman Tex
 */

$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) require_once $__dtg;

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/NotificationManager.php';

use DTBrand\Database;
use DTBrand\NotificationManager;

$page_title = "DLT High-Priority SMS Console";
$active_nav = "notifications";
$active_subnav = "sms";

$smsTemplates = NotificationManager::getTemplates(['channel' => 'sms']);
$smsLogs = NotificationManager::getLogs(['channel' => 'sms', 'limit' => 20]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DLT High-Priority SMS Console — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/notifications/notifications.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <!-- Page Header -->
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:18px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:10px; margin:0;">
                        <span>DLT High-Priority SMS Console</span>
                        <span class="adm-badge gold" style="font-size:0.7rem; font-weight:800;">HEADER: DTHNTX</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        TRAI-compliant transactional SMS gateway for instant order dispatch, OTP logins, and warehouse parcel tracking.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/notifications/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700;">&larr; Hub</a>
                    <a href="/admin/notifications/templates.php?channel=sms" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700;">SMS Templates</a>
                </div>
            </div>

            <!-- TRAI DLT Compliance Status Card -->
            <div class="adm-card" style="margin-bottom:18px; padding:16px 20px; border-left:4px solid #8A681F;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="dt-channel-icon-box sms">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                        </div>
                        <div>
                            <strong style="font-size:0.95rem; color:#111827; display:block;">TRAI DLT Registered Sender ID: DTHNTX</strong>
                            <span style="font-size:0.78rem; color:#64748B;">Entity ID: <code>140116123456789</code> &bull; Gateway: MSG91 Transactional High-Priority Route</span>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <span class="dt-status-badge delivered"><span class="dt-radar-dot-green"></span> DLT Approved</span>
                        <span style="font-size:0.78rem; color:#64748B;">Latency: <strong id="latency-msg91_sms" style="color:#8A681F;">35ms</strong></span>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.DTNotifications.testProvider('msg91_sms', this)">Ping MSG91</button>
                    </div>
                </div>
            </div>

            <!-- Two-Column Composer & Phone Preview -->
            <div style="display:grid; grid-template-columns:1.2fr 1fr; gap:18px; margin-bottom:24px;">
                <!-- Composer Card -->
                <div class="adm-card" style="margin-bottom:0;">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                            <span>Compose DLT Transactional SMS</span>
                        </h3>
                    </div>
                    <form onsubmit="handleSendTestSms(event)" style="padding:16px;">
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Recipient Mobile (+91 Indian Mobile) *</label>
                                <input type="text" id="smsTo" value="+91 97234 98765" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700; box-sizing:border-box;">
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Buyer Name</label>
                                <input type="text" id="smsName" value="Ananya Mehta" oninput="updateSmsMockup()" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Select Pre-Registered DLT Template</label>
                                <select id="smsTplSelect" onchange="applySmsTemplate()" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:700;">
                                    <?php foreach ($smsTemplates as $t): ?>
                                        <option value="<?= htmlspecialchars($t['template_key']) ?>" data-dlt="<?= htmlspecialchars($t['dlt_template_id'] ?: '') ?>" data-content="<?= htmlspecialchars($t['content']) ?>">
                                            <?= htmlspecialchars($t['title']) ?> [<?= htmlspecialchars($t['dlt_template_id'] ?: 'DLT') ?>]
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                                    <label style="font-size:0.75rem; font-weight:700; color:#111827;">DLT SMS Text *</label>
                                    <span id="smsCharCount" style="font-size:0.72rem; color:#8A681F; font-weight:700;">118 / 160 chars (1 SMS credit)</span>
                                </div>
                                <textarea id="smsContent" rows="4" required oninput="updateSmsMockup()" style="width:100%; border:1.5px solid #EAE5D9; border-radius:6px; padding:8px 10px; font-size:0.82rem; font-weight:600; box-sizing:border-box; resize:none;">DT Brand order #DT-88902 dispatched via Delhivery AWB DL98234112. Track at https://jaihanumantex.in/track - DTHNTX</textarea>
                            </div>
                        </div>
                        <div style="margin-top:16px; display:flex; justify-content:flex-end;">
                            <button type="submit" id="btnSendSms" class="dt-btn dt-btn-gold" style="height:36px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.8"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <span>Send DLT SMS</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Live Phone SMS Mockup Preview -->
                <div class="adm-card" style="margin-bottom:0; background:#F8FAFC;">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title" style="font-size:0.88rem; color:#475569;">
                            <span>Phone SMS Inbox Preview</span>
                        </h3>
                        <span class="adm-badge gold" style="font-size:0.65rem;">DTHNTX</span>
                    </div>
                    <div style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:16px; padding:18px; box-shadow:0 4px 12px rgba(0,0,0,0.05); max-width:320px; margin:0 auto;">
                        <div style="display:flex; align-items:center; justify-content:center; gap:6px; margin-bottom:12px; border-bottom:1px solid #F1F5F9; padding-bottom:8px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span style="font-size:0.75rem; font-weight:800; color:#1E293B;">VK-DTHNTX</span>
                        </div>
                        <div style="background:#FAF5E8; border:1.5px solid #D4AF37; border-radius:12px; padding:12px; font-size:0.8rem; color:#181512; line-height:1.45; box-shadow:0 2px 6px rgba(184,134,11,0.15);">
                            <div id="mockSmsBody" style="white-space:pre-wrap; font-family:sans-serif;">
DT Brand order #DT-88902 dispatched via Delhivery AWB DL98234112. Track at https://jaihanumantex.in/track - DTHNTX
                            </div>
                            <div style="text-align:right; font-size:0.65rem; color:#8A681F; margin-top:6px; font-weight:700;">
                                Delivered &bull; Just now
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SMS Delivery Logs -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>DLT SMS Delivery Ledger</span></h3>
                    <span style="font-size:0.78rem; color:#64748B;">Latest 20 SMS transmissions</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Recipient Mobile</th>
                                <th>Message Body</th>
                                <th>Gateway Msg ID</th>
                                <th>Status</th>
                                <th>Sent At</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($smsLogs)): ?>
                                <tr><td colspan="6" style="text-align:center; padding:20px; color:#64748B;">No SMS logs recorded yet.</td></tr>
                            <?php else: ?>
                                <?php foreach ($smsLogs as $l): ?>
                                    <tr>
                                        <td>
                                            <strong style="color:#111827; font-size:0.85rem; display:block;"><?= htmlspecialchars($l['recipient_name'] ?: 'Customer') ?></strong>
                                            <code style="font-size:0.75rem; color:#8A681F;"><?= htmlspecialchars($l['recipient']) ?></code>
                                        </td>
                                        <td style="font-size:0.8rem; color:#1E293B; max-width:320px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                            <?= htmlspecialchars($l['message']) ?>
                                        </td>
                                        <td>
                                            <code style="font-size:0.75rem; background:#F1F5F9; padding:2px 6px; border-radius:4px; color:#475569;">
                                                <?= htmlspecialchars($l['provider_msg_id'] ?: 'msg91-ref') ?>
                                            </code>
                                        </td>
                                        <td>
                                            <span class="dt-status-badge <?= htmlspecialchars($l['status']) ?>"><?= htmlspecialchars($l['status']) ?></span>
                                        </td>
                                        <td style="font-size:0.78rem; color:#64748B;">
                                            <?= htmlspecialchars(date('d M H:i', strtotime($l['sent_at']))) ?>
                                        </td>
                                        <td style="text-align:right;">
                                            <?php if ($l['status'] === 'failed'): ?>
                                                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.DTNotifications.retryMessage(<?= (int)$l['id'] ?>, this)">Retry</button>
                                            <?php else: ?>
                                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.DTNotifications.showToast('SMS verified via MSG91 DLT gateway')">Audit</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/notifications/notifications.js?v=<?php echo time(); ?>"></script>
<script>
function updateSmsMockup() {
    const text = document.getElementById('smsContent').value || '';
    document.getElementById('mockSmsBody').textContent = text;
    const len = text.length;
    const credits = Math.max(1, Math.ceil(len / 160));
    document.getElementById('smsCharCount').textContent = `${len} / ${credits * 160} chars (${credits} SMS credit${credits > 1 ? 's' : ''})`;
}

function applySmsTemplate() {
    const sel = document.getElementById('smsTplSelect');
    const opt = sel.options[sel.selectedIndex];
    if (!opt) return;

    const cont = opt.getAttribute('data-content') || '';
    const name = document.getElementById('smsName').value || 'Customer';

    const rendered = cont.replace(/\{\{customer_name\}\}/g, name)
                        .replace(/\{\{order_no\}\}/g, 'DT-88902')
                        .replace(/\{\{amount\}\}/g, '2,400')
                        .replace(/\{\{courier\}\}/g, 'Delhivery')
                        .replace(/\{\{tracking_no\}\}/g, 'DL98234112')
                        .replace(/\{\{tracking_url\}\}/g, 'https://jaihanumantex.in/track');

    document.getElementById('smsContent').value = rendered;
    updateSmsMockup();
}

function handleSendTestSms(e) {
    e.preventDefault();
    const to = document.getElementById('smsTo').value.trim();
    const name = document.getElementById('smsName').value.trim();
    const cont = document.getElementById('smsContent').value.trim();
    const btn = document.getElementById('btnSendSms');

    window.DTNotifications.sendTest(
        'sms',
        to,
        cont,
        { customer_name: name, order_no: 'DT-88902', amount: '2,400' },
        { recipient_name: name },
        btn
    ).then(() => {
        setTimeout(() => window.location.reload(), 900);
    });
}
</script>
</body>
</html>
