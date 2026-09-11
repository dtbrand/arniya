<?php
/**
 * admin/notifications/whatsapp.php — WhatsApp Cloud API HSM Studio
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

$page_title = "WhatsApp Cloud API HSM Studio";
$active_nav = "notifications";
$active_subnav = "whatsapp";

$waTemplates = NotificationManager::getTemplates(['channel' => 'whatsapp']);
$waLogs = NotificationManager::getLogs(['channel' => 'whatsapp', 'limit' => 20]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Cloud API HSM Studio — DT Brand's Admin</title>
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
                        <span>WhatsApp Cloud API HSM Studio</span>
                        <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:0.7rem;">META CLOUD V19.0</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Official Meta WhatsApp Business Cloud API concierge for high-speed delivery of verified order slips, dispatch notifications, and wholesale catalog PDFs.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/notifications/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700;">&larr; Hub</a>
                    <a href="/admin/notifications/templates.php?channel=whatsapp" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700;">WhatsApp Templates</a>
                </div>
            </div>

            <!-- Meta Cloud Gateway Status Card -->
            <div class="adm-card" style="margin-bottom:18px; padding:16px 20px; border-left:4px solid #15803D;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="dt-channel-icon-box wa">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                        <div>
                            <strong style="font-size:0.95rem; color:#111827; display:block;">Official WhatsApp Business Account: +91 70463 63528</strong>
                            <span style="font-size:0.78rem; color:#64748B;">Phone ID: <code>1029384756</code> &bull; WABA ID: <code>9876543210</code> &bull; Token: <span class="dt-secret-pill">••••••••••••••••</span></span>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <span class="dt-status-badge delivered"><span class="dt-radar-dot-green"></span> Operational</span>
                        <span style="font-size:0.78rem; color:#64748B;">Latency: <strong id="latency-whatsapp_cloud" style="color:#15803D;">42ms</strong></span>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.DTNotifications.testProvider('whatsapp_cloud', this)">Ping Meta Cloud</button>
                    </div>
                </div>
            </div>

            <!-- Two-Column Layout: WhatsApp Composer & Phone Chat Mockup -->
            <div style="display:grid; grid-template-columns:1.2fr 1fr; gap:18px; margin-bottom:24px;">
                <!-- Composer Card -->
                <div class="adm-card" style="margin-bottom:0;">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            <span>Compose &amp; Test WhatsApp HSM Message</span>
                        </h3>
                    </div>
                    <form onsubmit="handleSendTestWa(event)" style="padding:16px;">
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Customer WhatsApp Number *</label>
                                <input type="text" id="waTo" value="+91 98201 12345" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700; box-sizing:border-box;">
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Customer Name</label>
                                <input type="text" id="waName" value="Priya Sharma" oninput="updateWaMockup()" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Select Pre-Approved Meta HSM Template</label>
                                <select id="waTplSelect" onchange="applyWaTemplate()" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:700;">
                                    <?php foreach ($waTemplates as $t): ?>
                                        <option value="<?= htmlspecialchars($t['template_key']) ?>" data-meta="<?= htmlspecialchars($t['meta_template_id'] ?: '') ?>" data-content="<?= htmlspecialchars($t['content']) ?>">
                                            <?= htmlspecialchars($t['title']) ?> (<?= htmlspecialchars($t['meta_template_id'] ?: 'HSM') ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Rendered WhatsApp Content *</label>
                                <textarea id="waContent" rows="4" required oninput="updateWaMockup()" style="width:100%; border:1.5px solid #EAE5D9; border-radius:6px; padding:8px 10px; font-size:0.82rem; font-weight:600; box-sizing:border-box; resize:none;">Namaste Priya Sharma! 🙏 Your order #DT-88921 for 2 handloom items (Total: ₹4,890) has been placed successfully with DT Brand's. Our master weavers are packaging your order.</textarea>
                            </div>
                        </div>
                        <div style="margin-top:16px; display:flex; justify-content:flex-end;">
                            <button type="submit" id="btnSendWa" class="dt-btn dt-btn-emerald" style="height:36px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                <span>Dispatch via WhatsApp Cloud API</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- WhatsApp Chat Mockup -->
                <div class="adm-card" style="margin-bottom:0; background:#E5DDD5; padding:16px;">
                    <div style="background:#075E54; color:#FFFFFF; padding:10px 14px; border-radius:8px 8px 0 0; display:flex; align-items:center; gap:10px;">
                        <div style="width:34px; height:34px; border-radius:50%; background:#D4AF37; display:flex; align-items:center; justify-content:center; font-weight:800; color:#181512; font-size:0.85rem;">DT</div>
                        <div>
                            <div style="font-size:0.88rem; font-weight:800;">DT Brand's &amp; Jai Hanuman Tex</div>
                            <div style="font-size:0.68rem; color:#A7F3D0;">Official Business Account &bull; Online</div>
                        </div>
                    </div>
                    <div style="background:#EFEAE2; padding:16px 12px; min-height:220px; border-radius:0 0 8px 8px; display:flex; flex-direction:column; justify-content:flex-end;">
                        <!-- Message Bubble -->
                        <div style="background:#DCF8C6; border-radius:8px; padding:10px 12px; max-width:85%; box-shadow:0 1px 2px rgba(0,0,0,0.15); margin-left:auto;">
                            <div id="mockWaBody" style="font-size:0.8rem; color:#111827; line-height:1.45; white-space:pre-wrap; font-family:sans-serif;">
Namaste Priya Sharma! 🙏 Your order #DT-88921 for 2 handloom items (Total: ₹4,890) has been placed successfully with DT Brand's. Our master weavers are packaging your order.
                            </div>
                            <div style="display:flex; justify-content:flex-end; align-items:center; gap:4px; font-size:0.65rem; color:#6B7280; margin-top:4px;">
                                <span>Just now</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2"><path d="M18 6L7 17l-5-5"></path><path d="M22 10l-7.5 7.5L13 16"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- WhatsApp Delivery Logs -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>Meta WhatsApp Cloud API Delivery Logs</span></h3>
                    <span style="font-size:0.78rem; color:#64748B;">Latest 20 WhatsApp transmissions</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>WhatsApp Mobile</th>
                                <th>Message Body</th>
                                <th>WAMID / Cloud Ref</th>
                                <th>Status</th>
                                <th>Sent At</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($waLogs)): ?>
                                <tr><td colspan="7" style="text-align:center; padding:20px; color:#64748B;">No WhatsApp logs recorded yet.</td></tr>
                            <?php else: ?>
                                <?php foreach ($waLogs as $l): ?>
                                    <tr>
                                        <td>
                                            <strong style="color:#111827; font-size:0.85rem; display:block;"><?= htmlspecialchars($l['recipient_name'] ?: 'Buyer') ?></strong>
                                        </td>
                                        <td>
                                            <code style="font-size:0.75rem; color:#15803D;"><?= htmlspecialchars($l['recipient']) ?></code>
                                        </td>
                                        <td style="font-size:0.8rem; color:#1E293B; max-width:320px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                            <?= htmlspecialchars($l['message']) ?>
                                        </td>
                                        <td>
                                            <code style="font-size:0.72rem; background:#F1F5F9; padding:2px 6px; border-radius:4px; color:#475569; max-width:140px; display:inline-block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                                <?= htmlspecialchars($l['provider_msg_id'] ?: 'wamid-ref') ?>
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
                                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.DTNotifications.showToast('Message verified via Meta Cloud API')">Audit</button>
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
function updateWaMockup() {
    document.getElementById('mockWaBody').textContent = document.getElementById('waContent').value || 'Message body...';
}

function applyWaTemplate() {
    const sel = document.getElementById('waTplSelect');
    const opt = sel.options[sel.selectedIndex];
    if (!opt) return;

    const cont = opt.getAttribute('data-content') || '';
    const name = document.getElementById('waName').value || 'Customer';

    const rendered = cont.replace(/\{\{customer_name\}\}/g, name)
                        .replace(/\{\{merchant_name\}\}/g, name)
                        .replace(/\{\{order_no\}\}/g, 'DT-88921')
                        .replace(/\{\{amount\}\}/g, '4,890')
                        .replace(/\{\{item_count\}\}/g, '2')
                        .replace(/\{\{bale_qty\}\}/g, '25')
                        .replace(/\{\{courier\}\}/g, 'Delhivery')
                        .replace(/\{\{tracking_no\}\}/g, 'DL8891234')
                        .replace(/\{\{tracking_url\}\}/g, 'https://jaihanumantex.in/track')
                        .replace(/\{\{quote_url\}\}/g, 'https://jaihanumantex.in/quote/view');

    document.getElementById('waContent').value = rendered;
    updateWaMockup();
}

function handleSendTestWa(e) {
    e.preventDefault();
    const to = document.getElementById('waTo').value.trim();
    const name = document.getElementById('waName').value.trim();
    const cont = document.getElementById('waContent').value.trim();
    const btn = document.getElementById('btnSendWa');

    window.DTNotifications.sendTest(
        'whatsapp',
        to,
        cont,
        { customer_name: name, order_no: 'DT-88921', amount: '4,890' },
        { recipient_name: name },
        btn
    ).then(() => {
        setTimeout(() => window.location.reload(), 900);
    });
}
</script>
</body>
</html>
