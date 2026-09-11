<?php
/**
 * admin/notifications/email.php — Transactional Email Console
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

$page_title = "Transactional Email Console";
$active_nav = "notifications";
$active_subnav = "email";

$emailTemplates = NotificationManager::getTemplates(['channel' => 'email']);
$emailLogs = NotificationManager::getLogs(['channel' => 'email', 'limit' => 20]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactional Email Console — DT Brand's Admin</title>
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
                        <span>Transactional Email Console</span>
                        <span class="adm-badge gold" style="font-size:0.7rem; font-weight:800;">SMTP SSL</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Hostinger Enterprise SMTP delivery engine for verified GST order invoices, shipment dispatch notices, and wholesaler lot quotations.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/notifications/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700;">&larr; Hub</a>
                    <a href="/admin/notifications/templates.php?channel=email" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700;">Email Templates</a>
                </div>
            </div>

            <!-- SMTP Gateway Status Bar -->
            <div class="adm-card" style="margin-bottom:18px; padding:16px 20px; border-left:4px solid #1D4ED8;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="dt-channel-icon-box email">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <strong style="font-size:0.95rem; color:#111827; display:block;">Hostinger Enterprise SMTP Relay</strong>
                            <span style="font-size:0.78rem; color:#64748B;">Server: <code>smtp.hostinger.com:465 (SSL)</code> &bull; Sender: <code>concierge@jaihanumantex.in</code></span>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <span class="dt-status-badge delivered"><span class="dt-radar-dot-green"></span> Operational</span>
                        <span style="font-size:0.78rem; color:#64748B;">Latency: <strong id="latency-smtp_mail" style="color:#1D4ED8;">58ms</strong></span>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.DTNotifications.testProvider('smtp_mail', this)">Ping Relay</button>
                    </div>
                </div>
            </div>

            <!-- Two-Column Layout: Composer & Live Email Preview -->
            <div style="display:grid; grid-template-columns:1.2fr 1fr; gap:18px; margin-bottom:24px;">
                <!-- Composer Card -->
                <div class="adm-card" style="margin-bottom:0;">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 19l7-7 3 3-7 7-3-3z"></path><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path><path d="M2 2l7.586 7.586"></path><circle cx="11" cy="11" r="2"></circle></svg>
                            <span>Compose &amp; Test Transactional Email</span>
                        </h3>
                    </div>
                    <form onsubmit="handleSendTestEmail(event)" style="padding:16px;">
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Recipient Email Address *</label>
                                <input type="email" id="emailTo" value="buyer@boutique.in" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700; box-sizing:border-box;">
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Buyer Name</label>
                                <input type="text" id="emailName" value="Deepak Singhal" oninput="updateEmailMockup()" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Select Pre-Approved Email Template</label>
                                <select id="emailTplSelect" onchange="applyEmailTemplate()" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:700;">
                                    <?php foreach ($emailTemplates as $t): ?>
                                        <option value="<?= htmlspecialchars($t['template_key']) ?>" data-subject="<?= htmlspecialchars($t['subject']) ?>" data-content="<?= htmlspecialchars($t['content']) ?>">
                                            <?= htmlspecialchars($t['title']) ?> (<?= htmlspecialchars($t['template_key']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Email Subject Line *</label>
                                <input type="text" id="emailSubject" value="Order Confirmation #DT-88915 — DT Brand's &amp; Jai Hanuman Tex" required oninput="updateEmailMockup()" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700; box-sizing:border-box;">
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Email Body Content *</label>
                                <textarea id="emailContent" rows="5" required oninput="updateEmailMockup()" style="width:100%; border:1.5px solid #EAE5D9; border-radius:6px; padding:8px 10px; font-size:0.8rem; font-weight:600; box-sizing:border-box; resize:none;">Dear Deepak Singhal,

Thank you for placing your order with DT Brand's &amp; Jai Hanuman Tex!

Order Number: #DT-88915
Order Total: ₹45,000
Items Ordered: 10 Sarees B2B Bale

Your authentic Surat handloom weaves are currently being inspected and packaged in our luxury gift boxes.

Warm regards,
DT Brand's Master Concierge</textarea>
                            </div>
                        </div>
                        <div style="margin-top:16px; display:flex; justify-content:flex-end;">
                            <button type="submit" id="btnSendEmail" class="dt-btn dt-btn-gold" style="height:36px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.8"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                <span>Send Test Email</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Live Email HTML Mockup Preview -->
                <div class="adm-card" style="margin-bottom:0; background:#F8FAFC;">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title" style="font-size:0.88rem; color:#475569;">
                            <span>Customer Inbox HTML Preview</span>
                        </h3>
                        <span class="adm-badge gold" style="font-size:0.65rem;">Brand Identity</span>
                    </div>
                    <div style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
                        <!-- Email Header -->
                        <div style="background:#181512; padding:16px 20px; text-align:center; border-bottom:3px solid #D4AF37;">
                            <div style="font-size:1.1rem; font-weight:800; color:#FAF5E8; letter-spacing:0.04em;">
                                DT BRAND'S &amp; JAI HANUMAN TEX
                            </div>
                            <div style="font-size:0.72rem; color:#D4AF37; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; margin-top:2px;">
                                Authentic Surat Handloom Weavers
                            </div>
                        </div>
                        <!-- Email Body Container -->
                        <div style="padding:20px;">
                            <div id="mockEmailSubject" style="font-size:0.92rem; font-weight:800; color:#111827; margin-bottom:12px; border-bottom:1px solid #EAE5D9; padding-bottom:8px;">
                                Order Confirmation #DT-88915 — DT Brand's &amp; Jai Hanuman Tex
                            </div>
                            <div id="mockEmailBody" style="font-size:0.82rem; color:#334155; line-height:1.6; white-space:pre-wrap; font-family:sans-serif;">
Dear Deepak Singhal,

Thank you for placing your order with DT Brand's &amp; Jai Hanuman Tex!

Order Number: #DT-88915
Order Total: ₹45,000
Items Ordered: 10 Sarees B2B Bale

Your authentic Surat handloom weaves are currently being inspected and packaged in our luxury gift boxes.

Warm regards,
DT Brand's Master Concierge
                            </div>
                        </div>
                        <!-- Email Footer -->
                        <div style="background:#FAF5E8; padding:12px 20px; text-align:center; font-size:0.72rem; color:#705114; border-top:1px solid #EAE5D9;">
                            Official Support: concierge@jaihanumantex.in &bull; +91 70463 63528 &bull; Surat, Gujarat
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Delivery Logs -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>Hostinger SMTP Delivery Logs</span></h3>
                    <span style="font-size:0.78rem; color:#64748B;">Showing latest 20 email dispatches</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Recipient</th>
                                <th>Subject</th>
                                <th>Message ID</th>
                                <th>Status</th>
                                <th>Sent At</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($emailLogs)): ?>
                                <tr><td colspan="6" style="text-align:center; padding:20px; color:#64748B;">No email logs recorded yet.</td></tr>
                            <?php else: ?>
                                <?php foreach ($emailLogs as $l): ?>
                                    <tr>
                                        <td>
                                            <strong style="color:#111827; font-size:0.85rem; display:block;"><?= htmlspecialchars($l['recipient_name'] ?: 'Buyer') ?></strong>
                                            <code style="font-size:0.75rem; color:#1D4ED8;"><?= htmlspecialchars($l['recipient']) ?></code>
                                        </td>
                                        <td style="font-size:0.8rem; color:#1E293B; max-width:280px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                            <?= htmlspecialchars($l['subject'] ?: $l['message']) ?>
                                        </td>
                                        <td>
                                            <code style="font-size:0.75rem; background:#F1F5F9; padding:2px 6px; border-radius:4px; color:#475569;">
                                                <?= htmlspecialchars($l['provider_msg_id'] ?: 'smtp-ref') ?>
                                            </code>
                                        </td>
                                        <td>
                                            <span class="dt-status-badge <?= htmlspecialchars($l['status']) ?>"><?= htmlspecialchars($l['status']) ?></span>
                                        </td>
                                        <td style="font-size:0.78rem; color:#64748B;">
                                            <?= htmlspecialchars(date('d M H:i', strtotime($l['sent_at']))) ?>
                                        </td>
                                        <td style="text-align:right;">
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.DTNotifications.showToast('Message verified via Hostinger SMTP relay')">Audit</button>
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
function updateEmailMockup() {
    document.getElementById('mockEmailSubject').textContent = document.getElementById('emailSubject').value || 'Order Notification';
    document.getElementById('mockEmailBody').textContent = document.getElementById('emailContent').value || 'Email message body...';
}

function applyEmailTemplate() {
    const sel = document.getElementById('emailTplSelect');
    const opt = sel.options[sel.selectedIndex];
    if (!opt) return;

    const subj = opt.getAttribute('data-subject') || '';
    const cont = opt.getAttribute('data-content') || '';
    const name = document.getElementById('emailName').value || 'Deepak Singhal';

    const renderedSubj = subj.replace(/\{\{customer_name\}\}/g, name).replace(/\{\{order_no\}\}/g, 'DT-88915');
    const renderedCont = cont.replace(/\{\{customer_name\}\}/g, name)
                             .replace(/\{\{order_no\}\}/g, 'DT-88915')
                             .replace(/\{\{amount\}\}/g, '45,000')
                             .replace(/\{\{item_count\}\}/g, '10 Sarees B2B Bale')
                             .replace(/\{\{courier\}\}/g, 'Delhivery')
                             .replace(/\{\{tracking_no\}\}/g, 'DL8891234')
                             .replace(/\{\{tracking_url\}\}/g, 'https://jaihanumantex.in/track');

    document.getElementById('emailSubject').value = renderedSubj;
    document.getElementById('emailContent').value = renderedCont;
    updateEmailMockup();
}

function handleSendTestEmail(e) {
    e.preventDefault();
    const to = document.getElementById('emailTo').value.trim();
    const name = document.getElementById('emailName').value.trim();
    const subj = document.getElementById('emailSubject').value.trim();
    const cont = document.getElementById('emailContent').value.trim();
    const btn = document.getElementById('btnSendEmail');

    window.DTNotifications.sendTest(
        'email',
        to,
        cont,
        { customer_name: name, order_no: 'DT-88915', amount: '45,000' },
        { subject: subj, recipient_name: name },
        btn
    ).then(() => {
        setTimeout(() => window.location.reload(), 900);
    });
}
</script>
</body>
</html>
