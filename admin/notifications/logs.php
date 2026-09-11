<?php
/**
 * admin/notifications/logs.php — Multi-Channel Delivery Logs Ledger
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

$page_title = "Delivery Logs Ledger";
$active_nav = "notifications";
$active_subnav = "logs";

$channel = $_GET['channel'] ?? 'all';
$status = $_GET['status'] ?? 'all';
$search = trim($_GET['search'] ?? '');

$logs = NotificationManager::getLogs([
    'channel' => $channel,
    'status' => $status,
    'search' => $search,
    'limit' => 100
]);

$stats = NotificationManager::getNotificationStats();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Logs Ledger — DT Brand's Admin</title>
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
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        <span>Delivery Logs Ledger</span>
                        <span class="adm-badge gold" style="font-size:0.7rem; font-weight:800;"><?= count($logs) ?> ENTRIES</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Real-time transmission ledger across WhatsApp, Email, SMS and Push with latency tracking and carrier delivery receipts.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/notifications/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Hub</span>
                    </a>
                    <a href="/admin/notifications/failed.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700; color:#DC2626; border-color:#FECACA; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <span>Failed Messages (<?= $stats['failed_count'] ?>)</span>
                    </a>
                </div>
            </div>

            <!-- Filter Toolbar -->
            <div class="adm-card" style="margin-bottom:16px; padding:12px 16px;">
                <form method="GET" action="" style="display:flex; gap:12px; flex-wrap:wrap; align-items:center; justify-content:space-between;">
                    <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                        <div style="display:flex; align-items:center; gap:4px;">
                            <span style="font-size:0.75rem; font-weight:700; color:#475569;">Channel:</span>
                            <select name="channel" onchange="this.form.submit()" style="height:32px; border:1px solid #CBD5E1; border-radius:6px; padding:0 8px; font-size:0.8rem; font-weight:600;">
                                <option value="all" <?= $channel === 'all' ? 'selected' : '' ?>>All Channels</option>
                                <option value="whatsapp" <?= $channel === 'whatsapp' ? 'selected' : '' ?>>WhatsApp</option>
                                <option value="email" <?= $channel === 'email' ? 'selected' : '' ?>>Email</option>
                                <option value="sms" <?= $channel === 'sms' ? 'selected' : '' ?>>SMS</option>
                                <option value="push" <?= $channel === 'push' ? 'selected' : '' ?>>Push</option>
                            </select>
                        </div>
                        <div style="display:flex; align-items:center; gap:4px;">
                            <span style="font-size:0.75rem; font-weight:700; color:#475569;">Status:</span>
                            <select name="status" onchange="this.form.submit()" style="height:32px; border:1px solid #CBD5E1; border-radius:6px; padding:0 8px; font-size:0.8rem; font-weight:600;">
                                <option value="all" <?= $status === 'all' ? 'selected' : '' ?>>All Statuses</option>
                                <option value="delivered" <?= $status === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="sent" <?= $status === 'sent' ? 'selected' : '' ?>>Sent</option>
                                <option value="failed" <?= $status === 'failed' ? 'selected' : '' ?>>Failed</option>
                            </select>
                        </div>
                    </div>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search recipient, message, or subject..." style="height:32px; border:1px solid #CBD5E1; border-radius:6px; padding:0 10px; font-size:0.8rem; min-width:240px;">
                        <button type="submit" class="dt-btn dt-btn-gold" style="height:32px; padding:0 12px; font-size:0.78rem; font-weight:800; display:inline-flex; align-items:center; gap:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.5"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                            <span>Filter</span>
                        </button>
                        <?php if ($channel !== 'all' || $status !== 'all' || !empty($search)): ?>
                            <a href="/admin/notifications/logs.php" class="dt-btn dt-btn-pale" style="height:32px; padding:0 10px; font-size:0.78rem; font-weight:700; text-decoration:none;">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Delivery Logs Table -->
            <div class="adm-card">
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Channel</th>
                                <th>Recipient Target</th>
                                <th>Template Key</th>
                                <th>Message Body Preview</th>
                                <th>Gateway Provider</th>
                                <th>Status</th>
                                <th>Sent At</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs)): ?>
                                <tr><td colspan="9" style="text-align:center; padding:30px; color:#64748B;">No notification dispatch logs found matching criteria.</td></tr>
                            <?php else: ?>
                                <?php foreach ($logs as $l): ?>
                                    <tr>
                                        <td><code style="font-size:0.75rem; color:#64748B;">#<?= $l['id'] ?></code></td>
                                        <td>
                                            <?php if ($l['channel'] === 'whatsapp'): ?>
                                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700;">WhatsApp</span>
                                            <?php elseif ($l['channel'] === 'email'): ?>
                                                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-weight:700;">Email</span>
                                            <?php elseif ($l['channel'] === 'sms'): ?>
                                                <span class="adm-badge" style="background:#FAF5E8; color:#8A681F; font-weight:700;">SMS</span>
                                            <?php else: ?>
                                                <span class="adm-badge" style="background:#F3E8FF; color:#9333EA; font-weight:700;">Push</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong style="font-size:0.85rem; color:#111827; display:block;"><?= htmlspecialchars($l['recipient_name'] ?: 'Customer') ?></strong>
                                            <span style="font-size:0.75rem; color:#64748B; font-family:monospace;"><?= htmlspecialchars($l['recipient']) ?></span>
                                        </td>
                                        <td>
                                            <code style="font-size:0.72rem; background:#F8FAFC; border:1px solid #E2E8F0; padding:2px 6px; border-radius:4px; color:#475569;">
                                                <?= htmlspecialchars($l['template_key'] ?: 'custom') ?>
                                            </code>
                                        </td>
                                        <td style="max-width:280px;">
                                            <?php if (!empty($l['subject'])): ?>
                                                <strong style="font-size:0.8rem; color:#111827; display:block;"><?= htmlspecialchars($l['subject']) ?></strong>
                                            <?php endif; ?>
                                            <span style="font-size:0.78rem; color:#475569; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                                <?= htmlspecialchars($l['message']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <code style="font-size:0.72rem; background:#F1F5F9; padding:2px 6px; border-radius:4px; color:#334155;">
                                                <?= htmlspecialchars($l['provider'] ?: 'gateway') ?>
                                            </code>
                                        </td>
                                        <td>
                                            <span class="dt-status-badge <?= htmlspecialchars($l['status']) ?>">
                                                <?= htmlspecialchars($l['status']) ?>
                                            </span>
                                        </td>
                                        <td style="font-size:0.78rem; color:#64748B;">
                                            <?= htmlspecialchars(date('d M H:i', strtotime($l['sent_at']))) ?>
                                        </td>
                                        <td style="text-align:right;">
                                            <?php if ($l['status'] === 'failed'): ?>
                                                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.DTNotifications.retryMessage(<?= (int)$l['id'] ?>, this)">Retry</button>
                                            <?php else: ?>
                                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick='viewPayloadModal(<?= htmlspecialchars(json_encode($l), ENT_QUOTES, "UTF-8") ?>)'>View</button>
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

<!-- Detailed Payload Modal -->
<div id="logDetailModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:540px; padding:24px; box-shadow:0 12px 36px rgba(0,0,0,0.25); border:1.5px solid #D4AF37;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
            <h3 style="margin:0; font-size:1.05rem; font-weight:800; color:#111827;">Notification Payload Audit</h3>
            <button type="button" onclick="closeLogDetailModal()" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:#64748B;">&times;</button>
        </div>
        <div id="logDetailBody" style="font-size:0.82rem; color:#334155; line-height:1.5; background:#F8FAFC; padding:14px; border-radius:8px; border:1px solid #E2E8F0; max-height:360px; overflow-y:auto; word-break:break-all;">
        </div>
        <div style="margin-top:16px; text-align:right;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeLogDetailModal()">Close</button>
        </div>
    </div>
</div>

<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/notifications/notifications.js?v=<?php echo time(); ?>"></script>
<script>
function viewPayloadModal(l) {
    document.getElementById('logDetailBody').innerHTML = `
        <p><strong>Log ID:</strong> #${l.id}</p>
        <p><strong>Channel:</strong> <span class="adm-badge gold">${l.channel.toUpperCase()}</span></p>
        <p><strong>Recipient:</strong> ${l.recipient_name} (${l.recipient})</p>
        <p><strong>Template Key:</strong> <code>${l.template_key || 'raw_text'}</code></p>
        <p><strong>Gateway Provider:</strong> ${l.provider}</p>
        <p><strong>Provider Message ID:</strong> <code>${l.provider_msg_id || 'N/A'}</code></p>
        <p><strong>Status:</strong> <span class="dt-status-badge ${l.status}">${l.status}</span></p>
        <p><strong>Sent Timestamp:</strong> ${l.sent_at}</p>
        ${l.delivered_at ? `<p><strong>Delivered Timestamp:</strong> ${l.delivered_at}</p>` : ''}
        ${l.retry_count > 0 ? `<p><strong>Retry Attempts:</strong> ${l.retry_count} (Last: ${l.last_retry_at})</p>` : ''}
        ${l.error_message ? `<p style="color:#DC2626;"><strong>Error Reason:</strong> ${l.error_message}</p>` : ''}
        <div style="margin-top:10px;">
            <strong>Full Rendered Message Body:</strong>
            <div style="background:#FFFFFF; padding:10px; border:1px solid #CBD5E1; border-radius:6px; margin-top:4px; white-space:pre-wrap; font-family:sans-serif;">${l.message}</div>
        </div>
    `;
    const m = document.getElementById('logDetailModal');
    if (m) m.style.display = 'flex';
}
function closeLogDetailModal() {
    const m = document.getElementById('logDetailModal');
    if (m) m.style.display = 'none';
}
</script>
</body>
</html>
