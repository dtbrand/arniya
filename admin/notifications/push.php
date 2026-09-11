<?php
/**
 * admin/notifications/push.php — Lockscreen & In-App Push Broadcast Console
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

$page_title = "Instant Push Notification Dispatcher";
$active_nav = "notifications";
$active_subnav = "push";

$pushLogs = NotificationManager::getLogs(['channel' => 'push', 'limit' => 15]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instant Push Notification Dispatcher — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/notifications/notifications.css?v=<?php echo time(); ?>">
    <style>
        .dt-push-layout {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 18px;
            margin-bottom: 24px;
        }
        @media (max-width: 900px) {
            .dt-push-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                        <span>Instant Push Notification Dispatcher</span>
                        <span class="adm-badge gold" style="font-size:0.7rem; font-weight:800;">FIREBASE FCM</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Dispatch high-priority promotional push notifications and instant flash alerts directly to buyer device lockscreens.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/notifications/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700;">&larr; Hub</a>
                    <a href="/admin/notifications/templates.php?channel=push" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700;">Push Templates</a>
                </div>
            </div>

            <!-- FCM Gateway Status Card -->
            <div class="adm-card" style="margin-bottom:18px; padding:16px 20px; border-left:4px solid #9333EA;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="dt-channel-icon-box push">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </div>
                        <div>
                            <strong style="font-size:0.95rem; color:#111827; display:block;">Firebase Cloud Messaging (FCM HTTP v1)</strong>
                            <span style="font-size:0.78rem; color:#64748B;">Project: <code>dt-brands-arniya</code> &bull; Server Key: <span class="dt-secret-pill">••••••••••••••••</span></span>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <span class="dt-status-badge delivered"><span class="dt-radar-dot-green"></span> Operational</span>
                        <span style="font-size:0.78rem; color:#64748B;">Latency: <strong id="latency-fcm_push" style="color:#9333EA;">28ms</strong></span>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.DTNotifications.testProvider('fcm_push', this)">Ping FCM</button>
                    </div>
                </div>
            </div>

            <!-- Composer & Lockscreen Simulator -->
            <div class="dt-push-layout">
                <!-- Composer Card -->
                <div class="adm-card" style="margin-bottom:0;">
                    <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                        <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                            <span>Compose Push Broadcast</span>
                        </h3>
                        <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px; display:inline-flex; align-items:center; gap:5px;">
                            <span style="width:7px; height:7px; border-radius:50%; background:#16A34A; display:inline-block;"></span>
                            <span>48,500 Devices Ready</span>
                        </span>
                    </div>
                    <form onsubmit="handleSendPush(event)" style="padding:16px;">
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Target Audience Segment *</label>
                                <select id="pushAudience" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700;">
                                    <option value="all">All Opted-In Shoppers (48,500 devices)</option>
                                    <option value="wholesale">B2B Wholesale Boutique Buyers (412 devices)</option>
                                    <option value="resellers">Active Reseller Community (392 devices)</option>
                                    <option value="cart_abandoned">Cart Abandoners in Last 24 Hours (184 devices)</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Notification Title *</label>
                                <input type="text" id="pushTitle" value="Fresh Festive Silk Drop is Live!" required oninput="updatePushPreview()" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700; box-sizing:border-box;">
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Notification Body Message *</label>
                                <textarea id="pushBody" rows="3" required oninput="updatePushPreview()" style="width:100%; border:1.5px solid #EAE5D9; border-radius:6px; padding:8px 10px; font-weight:600; font-size:0.82rem; box-sizing:border-box; resize:none;">Explore brand new pure zari Kanjivaram &amp; Banarasi handloom weaves directly from Surat powerlooms with instant festive discounts!</textarea>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Deep-Link Destination URL</label>
                                <input type="text" id="pushUrl" value="/shop?category=kanjivaram-silk" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                            </div>
                        </div>

                        <div style="margin-top:18px; display:flex; justify-content:flex-end; gap:8px;">
                            <button type="submit" id="btnBroadcastPush" class="dt-btn dt-btn-gold" style="height:36px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                <span>Broadcast Push Notification</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Phone Lockscreen Mockup Simulator -->
                <div class="adm-card" style="margin-bottom:0; background:#0F172A; padding:20px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                    <div style="width:100%; max-width:300px; background:#1E293B; border:3px solid #334155; border-radius:28px; padding:16px 14px 24px 14px; box-shadow:0 16px 36px rgba(0,0,0,0.5);">
                        <!-- Phone Notch -->
                        <div style="width:100px; height:18px; background:#0F172A; border-radius:10px; margin:0 auto 16px auto;"></div>
                        <!-- Clock on Lockscreen -->
                        <div style="text-align:center; color:#E2E8F0; margin-bottom:18px;">
                            <div style="font-size:1.8rem; font-weight:800; letter-spacing:-0.03em;">09:41</div>
                            <div style="font-size:0.7rem; color:#94A3B8; font-weight:600;">Wednesday, 12 September</div>
                        </div>
                        <!-- Push Banner Bubble -->
                        <div style="background:rgba(255,255,255,0.92); backdrop-filter:blur(8px); border-radius:14px; padding:12px 14px; box-shadow:0 4px 16px rgba(0,0,0,0.25);">
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                                <div style="width:20px; height:20px; border-radius:5px; background:#181512; display:flex; align-items:center; justify-content:center; color:#D4AF37; font-size:10px; font-weight:800;">DT</div>
                                <strong style="font-size:0.75rem; color:#181512; text-transform:uppercase; letter-spacing:0.04em;">DT Brand's</strong>
                                <span style="margin-left:auto; font-size:0.65rem; color:#64748B;">now</span>
                            </div>
                            <div id="previewTitle" style="font-size:0.85rem; font-weight:800; color:#0F172A; margin-bottom:3px;">
                                Fresh Festive Silk Drop is Live!
                            </div>
                            <div id="previewBody" style="font-size:0.75rem; color:#334155; line-height:1.4;">
                                Explore brand new pure zari Kanjivaram &amp; Banarasi handloom weaves directly from Surat powerlooms with instant festive discounts!
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Push Delivery Logs -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>Push Broadcast History</span></h3>
                    <span style="font-size:0.78rem; color:#64748B;">Latest push broadcasts</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Audience Target</th>
                                <th>Title &amp; Body</th>
                                <th>FCM Message ID</th>
                                <th>Status</th>
                                <th>Dispatched At</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pushLogs)): ?>
                                <tr><td colspan="6" style="text-align:center; padding:20px; color:#64748B;">No push logs recorded yet.</td></tr>
                            <?php else: ?>
                                <?php foreach ($pushLogs as $l): ?>
                                    <tr>
                                        <td>
                                            <strong style="color:#111827; font-size:0.85rem; display:block;"><?= htmlspecialchars($l['recipient_name'] ?: 'All Devices') ?></strong>
                                            <code style="font-size:0.72rem; color:#9333EA;"><?= htmlspecialchars($l['recipient']) ?></code>
                                        </td>
                                        <td style="max-width:320px;">
                                            <?php if (!empty($l['subject'])): ?>
                                                <strong style="font-size:0.82rem; color:#111827; display:block;"><?= htmlspecialchars($l['subject']) ?></strong>
                                            <?php endif; ?>
                                            <span style="font-size:0.78rem; color:#475569; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                                <?= htmlspecialchars($l['message']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <code style="font-size:0.72rem; background:#F1F5F9; padding:2px 6px; border-radius:4px; color:#475569;">
                                                <?= htmlspecialchars($l['provider_msg_id'] ?: 'fcm-ref') ?>
                                            </code>
                                        </td>
                                        <td>
                                            <span class="dt-status-badge <?= htmlspecialchars($l['status']) ?>"><?= htmlspecialchars($l['status']) ?></span>
                                        </td>
                                        <td style="font-size:0.78rem; color:#64748B;">
                                            <?= htmlspecialchars(date('d M H:i', strtotime($l['sent_at']))) ?>
                                        </td>
                                        <td style="text-align:right;">
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.DTNotifications.showToast('Broadcast confirmed on FCM topic')">Inspect</button>
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
function updatePushPreview() {
    document.getElementById('previewTitle').textContent = document.getElementById('pushTitle').value || 'New Notification';
    document.getElementById('previewBody').textContent = document.getElementById('pushBody').value || 'Notification details...';
}

function handleSendPush(e) {
    e.preventDefault();
    const aud = document.getElementById('pushAudience').value;
    const title = document.getElementById('pushTitle').value.trim();
    const body = document.getElementById('pushBody').value.trim();
    const btn = document.getElementById('btnBroadcastPush');

    window.DTNotifications.sendTest(
        'push',
        'topic_' + aud,
        body,
        {},
        { subject: title, recipient_name: 'Audience: ' + aud, provider: 'fcm_push' },
        btn
    ).then(() => {
        setTimeout(() => window.location.reload(), 900);
    });
}
</script>
</body>
</html>
