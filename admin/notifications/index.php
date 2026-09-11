<?php
/**
 * admin/notifications/index.php — Multi-Channel Notification Hub
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

$page_title = "Multi-Channel Notification Hub";
$active_nav = "notifications";
$active_subnav = "";

// Fetch stats and live data
$stats = NotificationManager::getNotificationStats();
$recentLogs = NotificationManager::getLogs(['limit' => 10]);
$providers = NotificationManager::getProviders();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Channel Notification Hub — DT Brand's Admin</title>
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
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:20px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:10px; margin:0;">
                        <span>Multi-Channel Notification Hub</span>
                        <span class="adm-badge gold" style="font-size:0.72rem; font-weight:800;">ENTERPRISE V3.1</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Real-time gateway monitoring for WhatsApp Cloud API, Hostinger SMTP, MSG91 DLT SMS &amp; FCM Push.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/notifications/failed.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <span>Dead-Letter Queue (<?= $stats['failed_count'] ?>)</span>
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:34px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="openQuickTestModal()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.8"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>+ Test Dispatch</span>
                    </button>
                </div>
            </div>

            <!-- KPI Metric Ribbon -->
            <div class="dt-notif-kpi-grid">
                <div class="dt-notif-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Dispatched Today</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= number_format($stats['dispatched_today']) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">High Delivery Volume</span>
                    </div>
                </div>

                <div class="dt-notif-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Delivery Success Rate</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $stats['delivery_rate'] ?>%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up"><span class="dt-radar-dot-green"></span> SLA Target Met</span>
                    </div>
                </div>

                <div class="dt-notif-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Active Templates</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $stats['active_templates'] ?></div>
                    <div class="adm-kpi-bottom">
                        <a href="/admin/notifications/templates.php" style="color:#8A681F; font-size:0.75rem; font-weight:700; text-decoration:none;">Manage Templates &rarr;</a>
                    </div>
                </div>

                <div class="dt-notif-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Dead-Letter / Failed</span>
                        <div class="adm-kpi-icon-box" style="background:#FEF2F2;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:<?= $stats['failed_count'] > 0 ? '#DC2626' : '#15803D' ?>;"><?= $stats['failed_count'] ?></div>
                    <div class="adm-kpi-bottom">
                        <a href="/admin/notifications/failed.php" style="color:#DC2626; font-size:0.75rem; font-weight:700; text-decoration:none;">View &amp; Retry DLQ &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Multi-Channel Quick Status Cards -->
            <div class="dt-notif-channel-grid">
                <!-- WhatsApp Cloud API -->
                <div class="dt-notif-channel-card active-wa">
                    <div>
                        <div class="dt-channel-header">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="dt-channel-icon-box wa">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                </div>
                                <div>
                                    <strong style="color:#111827; font-size:0.92rem; display:block;">WhatsApp Cloud API</strong>
                                    <span style="font-size:0.75rem; color:#15803D; font-weight:700;">Meta Pre-Approved HSM</span>
                                </div>
                            </div>
                            <span class="dt-status-badge delivered"><span class="dt-radar-dot-green"></span> Live</span>
                        </div>
                        <p style="font-size:0.8rem; color:#475569; margin:8px 0 14px 0; line-height:1.4;">
                            Dispatches verified order receipts, wholesale quotes, and AWB tracking links directly to customer WhatsApp.
                        </p>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #EAE5D9; padding-top:12px; margin-top:10px;">
                        <span style="font-size:0.75rem; color:#64748B;">Total: <strong><?= $stats['channels']['whatsapp'] ?> msgs</strong></span>
                        <div style="display:flex; gap:6px;">
                            <a href="/admin/notifications/whatsapp.php" class="dt-btn dt-btn-pale" style="height:28px; font-size:11px; font-weight:700; text-decoration:none;">Console</a>
                            <button type="button" class="dt-btn dt-btn-emerald" style="height:28px; font-size:11px; font-weight:700;" onclick="quickTestChannel('whatsapp')">Quick Test</button>
                        </div>
                    </div>
                </div>

                <!-- Transactional Email -->
                <div class="dt-notif-channel-card active-email">
                    <div>
                        <div class="dt-channel-header">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="dt-channel-icon-box email">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                </div>
                                <div>
                                    <strong style="color:#111827; font-size:0.92rem; display:block;">Transactional Email</strong>
                                    <span style="font-size:0.75rem; color:#1D4ED8; font-weight:700;">Hostinger SMTP (SSL)</span>
                                </div>
                            </div>
                            <span class="dt-status-badge delivered"><span class="dt-radar-dot-green"></span> Live</span>
                        </div>
                        <p style="font-size:0.8rem; color:#475569; margin:8px 0 14px 0; line-height:1.4;">
                            Sends PDF invoices, order confirmations, and reseller dispatch statements via concierge@jaihanumantex.in.
                        </p>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #EAE5D9; padding-top:12px; margin-top:10px;">
                        <span style="font-size:0.75rem; color:#64748B;">Total: <strong><?= $stats['channels']['email'] ?> emails</strong></span>
                        <div style="display:flex; gap:6px;">
                            <a href="/admin/notifications/email.php" class="dt-btn dt-btn-pale" style="height:28px; font-size:11px; font-weight:700; text-decoration:none;">Console</a>
                            <button type="button" class="dt-btn dt-btn-gold" style="height:28px; font-size:11px; font-weight:800;" onclick="quickTestChannel('email')">Quick Test</button>
                        </div>
                    </div>
                </div>

                <!-- DLT SMS Gateway -->
                <div class="dt-notif-channel-card active-sms">
                    <div>
                        <div class="dt-channel-header">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="dt-channel-icon-box sms">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                                </div>
                                <div>
                                    <strong style="color:#111827; font-size:0.92rem; display:block;">DLT High-Priority SMS</strong>
                                    <span style="font-size:0.75rem; color:#8A681F; font-weight:700;">MSG91 Header: DTHNTX</span>
                                </div>
                            </div>
                            <span class="dt-status-badge delivered"><span class="dt-radar-dot-green"></span> Live</span>
                        </div>
                        <p style="font-size:0.8rem; color:#475569; margin:8px 0 14px 0; line-height:1.4;">
                            TRAI DLT-registered transactional SMS for urgent OTP authentications, courier AWB alerts, and warehouse dispatches.
                        </p>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #EAE5D9; padding-top:12px; margin-top:10px;">
                        <span style="font-size:0.75rem; color:#64748B;">Total: <strong><?= $stats['channels']['sms'] ?> SMS</strong></span>
                        <div style="display:flex; gap:6px;">
                            <a href="/admin/notifications/sms.php" class="dt-btn dt-btn-pale" style="height:28px; font-size:11px; font-weight:700; text-decoration:none;">Console</a>
                            <button type="button" class="dt-btn dt-btn-gold" style="height:28px; font-size:11px; font-weight:800;" onclick="quickTestChannel('sms')">Quick Test</button>
                        </div>
                    </div>
                </div>

                <!-- Web & Mobile Push -->
                <div class="dt-notif-channel-card active-push">
                    <div>
                        <div class="dt-channel-header">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="dt-channel-icon-box push">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                </div>
                                <div>
                                    <strong style="color:#111827; font-size:0.92rem; display:block;">Push &amp; In-App</strong>
                                    <span style="font-size:0.75rem; color:#9333EA; font-weight:700;">Firebase FCM Cloud</span>
                                </div>
                            </div>
                            <span class="dt-status-badge delivered"><span class="dt-radar-dot-green"></span> Live</span>
                        </div>
                        <p style="font-size:0.8rem; color:#475569; margin:8px 0 14px 0; line-height:1.4;">
                            Instant device lockscreen banners and in-app notifications for festive silk drops, live offers, and price drops.
                        </p>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #EAE5D9; padding-top:12px; margin-top:10px;">
                        <span style="font-size:0.75rem; color:#64748B;">Total: <strong><?= $stats['channels']['push'] ?> pushes</strong></span>
                        <div style="display:flex; gap:6px;">
                            <a href="/admin/notifications/push.php" class="dt-btn dt-btn-pale" style="height:28px; font-size:11px; font-weight:700; text-decoration:none;">Console</a>
                            <button type="button" class="dt-btn dt-btn-gold" style="height:28px; font-size:11px; font-weight:800;" onclick="quickTestChannel('push')">Quick Test</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Delivery Logs Table -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div>
                        <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>Recent Dispatch &amp; Delivery Ledger</span>
                        </h3>
                    </div>
                    <div style="display:flex; gap:8px;">
                        <a href="/admin/notifications/logs.php" class="dt-btn dt-btn-pale" style="height:30px; font-size:11.5px; font-weight:700; text-decoration:none;">View Full Ledger &rarr;</a>
                    </div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Channel</th>
                                <th>Recipient</th>
                                <th>Subject / Message Preview</th>
                                <th>Provider</th>
                                <th>Status</th>
                                <th>Sent At</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentLogs)): ?>
                                <tr>
                                    <td colspan="7" style="text-align:center; padding:24px; color:#64748B;">No notification dispatch records logged yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recentLogs as $log): ?>
                                    <tr>
                                        <td>
                                            <?php if ($log['channel'] === 'whatsapp'): ?>
                                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700;">WhatsApp</span>
                                            <?php elseif ($log['channel'] === 'email'): ?>
                                                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-weight:700;">Email</span>
                                            <?php elseif ($log['channel'] === 'sms'): ?>
                                                <span class="adm-badge" style="background:#FAF5E8; color:#8A681F; font-weight:700;">SMS</span>
                                            <?php else: ?>
                                                <span class="adm-badge" style="background:#F3E8FF; color:#9333EA; font-weight:700;">Push</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong style="color:#111827; font-size:0.85rem; display:block;"><?= htmlspecialchars($log['recipient_name'] ?: 'Buyer') ?></strong>
                                            <span style="font-size:0.75rem; color:#64748B; font-family:monospace;"><?= htmlspecialchars($log['recipient']) ?></span>
                                        </td>
                                        <td style="max-width:320px;">
                                            <?php if (!empty($log['subject'])): ?>
                                                <strong style="color:#111827; font-size:0.8rem; display:block;"><?= htmlspecialchars($log['subject']) ?></strong>
                                            <?php endif; ?>
                                            <span style="font-size:0.78rem; color:#475569; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                                <?= htmlspecialchars($log['message']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <code style="font-size:0.75rem; background:#F1F5F9; padding:2px 6px; border-radius:4px; color:#334155;">
                                                <?= htmlspecialchars($log['provider'] ?: 'gateway') ?>
                                            </code>
                                        </td>
                                        <td>
                                            <?php if ($log['status'] === 'delivered'): ?>
                                                <span class="dt-status-badge delivered">Delivered</span>
                                            <?php elseif ($log['status'] === 'sent'): ?>
                                                <span class="dt-status-badge sent">Sent</span>
                                            <?php elseif ($log['status'] === 'queued'): ?>
                                                <span class="dt-status-badge queued">Queued</span>
                                            <?php else: ?>
                                                <span class="dt-status-badge failed">Failed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-size:0.78rem; color:#64748B;">
                                            <?= htmlspecialchars(date('d M H:i', strtotime($log['sent_at']))) ?>
                                        </td>
                                        <td style="text-align:right;">
                                            <?php if ($log['status'] === 'failed'): ?>
                                                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.DTNotifications.retryMessage(<?= (int)$log['id'] ?>, this)">Retry</button>
                                            <?php else: ?>
                                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="viewLogPayload(<?= htmlspecialchars(json_encode($log)) ?>)">View</button>
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

<!-- Quick Test Dispatch Modal -->
<div id="quickTestModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:500px; padding:24px; box-shadow:0 12px 36px rgba(0,0,0,0.25); border:1.5px solid #D4AF37;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="margin:0; font-size:1.1rem; font-weight:800; color:#111827; display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                <span>Quick Test Dispatch</span>
            </h3>
            <button type="button" onclick="closeQuickTestModal()" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:#64748B;">&times;</button>
        </div>
        <form onsubmit="handleQuickDispatch(event)">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Delivery Channel *</label>
                    <select id="quickChannel" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700;" onchange="updateQuickRecipientPlaceholder()">
                        <option value="whatsapp">WhatsApp Cloud API (+91 Indian Mobile)</option>
                        <option value="email">Transactional Email (Hostinger SMTP)</option>
                        <option value="sms">DLT Transactional SMS (10-Digit Mobile)</option>
                        <option value="push">Firebase Cloud Messaging (Device Token / Topic)</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Recipient Target *</label>
                    <input type="text" id="quickRecipient" placeholder="+91 98201 12345" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Recipient Name</label>
                    <input type="text" id="quickName" value="Priya Sharma" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Sample Message Body / Template *</label>
                    <textarea id="quickContent" rows="3" required style="width:100%; border:1.5px solid #EAE5D9; border-radius:6px; padding:8px 10px; font-size:0.8rem; font-weight:600; box-sizing:border-box; resize:none;">Namaste {{customer_name}}! 🙏 Your handloom sample dispatch for order #{{order_no}} is verified by DT Brand's &amp; Jai Hanuman Tex.</textarea>
                </div>
            </div>
            <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeQuickTestModal()">Cancel</button>
                <button type="submit" id="btnQuickSubmit" class="dt-btn dt-btn-gold">Dispatch Notification</button>
            </div>
        </form>
    </div>
</div>

<!-- View Payload Modal -->
<div id="payloadModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:540px; padding:24px; box-shadow:0 12px 36px rgba(0,0,0,0.25); border:1.5px solid #D4AF37;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
            <h3 style="margin:0; font-size:1.05rem; font-weight:800; color:#111827;">Dispatch Message Payload Details</h3>
            <button type="button" onclick="closePayloadModal()" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:#64748B;">&times;</button>
        </div>
        <div id="payloadDetails" style="font-size:0.82rem; color:#334155; line-height:1.5; background:#F8FAFC; padding:14px; border-radius:8px; border:1px solid #E2E8F0; max-height:360px; overflow-y:auto; word-break:break-all;">
        </div>
        <div style="margin-top:16px; text-align:right;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closePayloadModal()">Close</button>
        </div>
    </div>
</div>

<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/notifications/notifications.js?v=<?php echo time(); ?>"></script>
<script>
function openQuickTestModal() {
    const m = document.getElementById('quickTestModal');
    if (m) m.style.display = 'flex';
}
function closeQuickTestModal() {
    const m = document.getElementById('quickTestModal');
    if (m) m.style.display = 'none';
}
function updateQuickRecipientPlaceholder() {
    const ch = document.getElementById('quickChannel').value;
    const inp = document.getElementById('quickRecipient');
    if (ch === 'whatsapp' || ch === 'sms') {
        inp.placeholder = '+91 98201 12345';
        inp.value = '+91 98201 12345';
    } else if (ch === 'email') {
        inp.placeholder = 'buyer@boutique.in';
        inp.value = 'buyer@boutique.in';
    } else {
        inp.placeholder = 'fcm_device_token_xyz';
        inp.value = 'all_registered_devices';
    }
}
function quickTestChannel(channel) {
    document.getElementById('quickChannel').value = channel;
    updateQuickRecipientPlaceholder();
    openQuickTestModal();
}
function handleQuickDispatch(e) {
    e.preventDefault();
    const ch = document.getElementById('quickChannel').value;
    const rec = document.getElementById('quickRecipient').value.trim();
    const name = document.getElementById('quickName').value.trim();
    const content = document.getElementById('quickContent').value.trim();
    const btn = document.getElementById('btnQuickSubmit');

    window.DTNotifications.sendTest(
        ch,
        rec,
        content,
        { customer_name: name, order_no: 'DT-88990', amount: '12,450' },
        { recipient_name: name },
        btn
    ).then(() => {
        closeQuickTestModal();
        setTimeout(() => window.location.reload(), 1000);
    });
}
function viewLogPayload(log) {
    const det = document.getElementById('payloadDetails');
    det.innerHTML = `
        <p><strong>Log ID:</strong> #${log.id}</p>
        <p><strong>Channel:</strong> <span class="adm-badge gold">${log.channel.toUpperCase()}</span></p>
        <p><strong>Recipient:</strong> ${log.recipient_name} (${log.recipient})</p>
        <p><strong>Provider:</strong> ${log.provider}</p>
        <p><strong>Provider Msg ID:</strong> <code>${log.provider_msg_id || 'N/A'}</code></p>
        <p><strong>Status:</strong> ${log.status}</p>
        <p><strong>Sent At:</strong> ${log.sent_at}</p>
        ${log.delivered_at ? `<p><strong>Delivered At:</strong> ${log.delivered_at}</p>` : ''}
        ${log.error_message ? `<p style="color:#DC2626;"><strong>Error:</strong> ${log.error_message}</p>` : ''}
        <div style="margin-top:10px;">
            <strong>Rendered Message Content:</strong>
            <div style="background:#FFFFFF; padding:10px; border:1px solid #CBD5E1; border-radius:6px; margin-top:4px; white-space:pre-wrap; font-family:sans-serif;">${log.message}</div>
        </div>
    `;
    const m = document.getElementById('payloadModal');
    if (m) m.style.display = 'flex';
}
function closePayloadModal() {
    const m = document.getElementById('payloadModal');
    if (m) m.style.display = 'none';
}
</script>
</body>
</html>
