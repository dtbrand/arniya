<?php
/**
 * admin/notifications/failed.php — Dead-Letter Queue & Failed Retry Console
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

$page_title = "Failed Messages & Dead-Letter Queue";
$active_nav = "notifications";
$active_subnav = "failed";

$failedMessages = NotificationManager::getFailedMessages();
$failedIds = array_map(fn($m) => (int)$m['id'], $failedMessages);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Failed Messages &amp; Dead-Letter Queue — DT Brand's Admin</title>
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
                        <span>Failed Messages &amp; Dead-Letter Queue (DLQ)</span>
                        <span class="adm-badge" style="background:#FEF2F2; color:#DC2626; border:1px solid #FECACA; font-weight:800; font-size:0.7rem;">
                            <?= count($failedMessages) ?> FAILED
                        </span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Inspect gateway transmission rejections, telecom DLT routing errors, and execute instant single or batch message recovery.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/notifications/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700;">&larr; Hub</a>
                    <?php if (!empty($failedMessages)): ?>
                        <button type="button" id="btnBatchRetry" class="dt-btn dt-btn-gold" style="height:34px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="triggerBatchRetry()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.8"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                            <span>Batch Retry All (<?= count($failedMessages) ?>)</span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Dead-Letter Queue Status Alert Banner -->
            <div class="adm-card" style="margin-bottom:18px; padding:16px 20px; border-left:4px solid #DC2626; background:#FFFBFB;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div style="display:flex; align-items:flex-start; gap:12px;">
                        <div style="width:36px; height:36px; border-radius:8px; background:#FEE2E2; color:#DC2626; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                        <div>
                            <strong style="font-size:0.95rem; color:#991B1B; display:block;">Dead-Letter Queue Message Isolation Protocol</strong>
                            <p style="margin:2px 0 0 0; font-size:0.8rem; color:#7F1D1D; line-height:1.4;">
                                Messages rejected due to transient carrier downtime, rate limits, or DLT route re-alignments are retained with full payload integrity. Retrying routes through our primary fallback cluster.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Failed Messages Table -->
            <div class="adm-card">
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Channel</th>
                                <th>Recipient Target</th>
                                <th>Failed Content Preview</th>
                                <th>Error Diagnostics</th>
                                <th>Retries</th>
                                <th>Sent At</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($failedMessages)): ?>
                                <tr>
                                    <td colspan="7" style="text-align:center; padding:36px; color:#15803D;">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2" style="margin-bottom:8px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        <div style="font-size:0.95rem; font-weight:800; color:#15803D;">Zero Failed Messages in Queue!</div>
                                        <div style="font-size:0.78rem; color:#64748B; margin-top:2px;">All multi-channel notifications are successfully delivered to recipients.</div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($failedMessages as $f): ?>
                                    <tr>
                                        <td>
                                            <?php if ($f['channel'] === 'whatsapp'): ?>
                                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700;">WhatsApp</span>
                                            <?php elseif ($f['channel'] === 'email'): ?>
                                                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-weight:700;">Email</span>
                                            <?php elseif ($f['channel'] === 'sms'): ?>
                                                <span class="adm-badge" style="background:#FAF5E8; color:#8A681F; font-weight:700;">SMS</span>
                                            <?php else: ?>
                                                <span class="adm-badge" style="background:#F3E8FF; color:#9333EA; font-weight:700;">Push</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong style="color:#111827; font-size:0.85rem; display:block;"><?= htmlspecialchars($f['recipient_name'] ?: 'Customer') ?></strong>
                                            <code style="font-size:0.75rem; color:#DC2626;"><?= htmlspecialchars($f['recipient']) ?></code>
                                        </td>
                                        <td style="max-width:280px;">
                                            <span style="font-size:0.78rem; color:#475569; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                                <?= htmlspecialchars($f['message']) ?>
                                            </span>
                                        </td>
                                        <td style="max-width:260px;">
                                            <div style="color:#B91C1C; font-size:0.75rem; font-weight:700; line-height:1.35; background:#FEF2F2; border:1px solid #FECACA; padding:4px 8px; border-radius:4px;">
                                                <?= htmlspecialchars($f['error_message'] ?: 'Carrier rejected transmission.') ?>
                                            </div>
                                        </td>
                                        <td style="font-size:0.78rem; color:#64748B;">
                                            <strong><?= (int)$f['retry_count'] ?></strong> tries
                                            <?php if (!empty($f['last_retry_at'])): ?>
                                                <div style="font-size:0.7rem; color:#94A3B8;">(Last: <?= date('H:i', strtotime($f['last_retry_at'])) ?>)</div>
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-size:0.78rem; color:#64748B;">
                                            <?= htmlspecialchars(date('d M H:i', strtotime($f['sent_at']))) ?>
                                        </td>
                                        <td style="text-align:right;">
                                            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="window.DTNotifications.retryMessage(<?= (int)$f['id'] ?>, this)">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.5"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                                <span>Retry</span>
                                            </button>
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
const failedIds = <?= json_encode($failedIds) ?>;

function triggerBatchRetry() {
    const btn = document.getElementById('btnBatchRetry');
    window.DTNotifications.batchRetry(failedIds, btn);
}
</script>
</body>
</html>
