<?php
/**
 * admin/notifications/providers.php — Gateway Providers Health Monitor & Security Vault
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

$page_title = "Gateway Providers Health Monitor";
$active_nav = "notifications";
$active_subnav = "providers";

// Section 31 Mandate: Secrets are NEVER displayed (masked at model layer)
$providers = NotificationManager::getProviders();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gateway Providers Health Monitor — DT Brand's Admin</title>
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
                        <span>Gateway Providers Health Monitor</span>
                        <span class="adm-badge gold" style="font-size:0.7rem; font-weight:800;">4 CLOUD CARRIERS</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Real-time connectivity, latency diagnostics &amp; zero-leak encrypted credential vault across WhatsApp, SMTP, SMS &amp; FCM.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/notifications/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700;">&larr; Hub</a>
                    <a href="/admin/notifications/logs.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700;">Delivery Ledger</a>
                </div>
            </div>

            <!-- Zero Plaintext Secrets Security Guarantee Banner -->
            <div class="adm-card" style="margin-bottom:20px; padding:16px 20px; border-left:4px solid #15803D; background:#F7FEE7;">
                <div style="display:flex; align-items:flex-start; gap:12px;">
                    <div style="width:36px; height:36px; border-radius:8px; background:#DCFCE7; color:#15803D; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <div>
                        <strong style="font-size:0.95rem; color:#14532D; display:block;">Zero Plaintext Secret Exposure Guarantee (Section 31 Mandate)</strong>
                        <p style="margin:2px 0 0 0; font-size:0.8rem; color:#166534; line-height:1.45;">
                            All cloud API tokens, private authentication keys, SMTP passwords, and server credentials are encrypted and strictly masked (<span class="dt-secret-pill">••••••••••••••••</span>). Production keys are loaded via Hostinger environment variables.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Provider Cards Grid -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(340px, 1fr)); gap:18px;">
                <?php foreach ($providers as $p): ?>
                    <?php
                        $cfg = json_decode($p['config_json'] ?? '{}', true) ?: [];
                        $borderCol = match($p['channel']) {
                            'whatsapp' => '#15803D',
                            'email' => '#1D4ED8',
                            'sms' => '#8A681F',
                            default => '#9333EA'
                        };
                    ?>
                    <div class="adm-card" style="margin-bottom:0; border:1.5px solid #EAE5D9; border-top:4px solid <?= $borderCol ?>; display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                                <div>
                                    <h3 style="margin:0 0 2px 0; font-size:1rem; font-weight:800; color:#111827;">
                                        <?= htmlspecialchars($p['display_name']) ?>
                                    </h3>
                                    <code style="font-size:0.75rem; color:#64748B;">key: <?= htmlspecialchars($p['provider_key']) ?></code>
                                </div>
                                <span class="dt-status-badge delivered">
                                    <span class="dt-radar-dot-green"></span>
                                    <?= htmlspecialchars($p['status']) ?>
                                </span>
                            </div>

                            <!-- Provider Parameters & Masked Secrets Table -->
                            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:12px; margin-bottom:14px;">
                                <span style="font-size:0.7rem; font-weight:800; color:#64748B; text-transform:uppercase; display:block; margin-bottom:6px;">Parameters &amp; Security Vault:</span>
                                <table style="width:100%; font-size:0.78rem; border-collapse:collapse;">
                                    <?php foreach ($cfg as $k => $v): ?>
                                        <tr style="border-bottom:1px solid #EDF2F7;">
                                            <td style="padding:4px 0; color:#64748B; font-weight:600;"><?= htmlspecialchars($k) ?></td>
                                            <td style="padding:4px 0; text-align:right;">
                                                <?php if (str_contains($v, '••••')): ?>
                                                    <span class="dt-secret-pill"><?= htmlspecialchars($v) ?></span>
                                                <?php else: ?>
                                                    <code style="background:#FFFFFF; padding:2px 6px; border-radius:4px; border:1px solid #CBD5E1; color:#1E293B; font-weight:700;"><?= htmlspecialchars($v) ?></code>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>

                            <!-- Health Metrics -->
                            <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.78rem; color:#64748B; margin-bottom:14px;">
                                <div>
                                    Ping Latency: <strong id="latency-<?= htmlspecialchars($p['provider_key']) ?>" style="color:<?= $borderCol ?>;"><?= (int)($p['latency_ms'] ?? 35) ?>ms</strong>
                                </div>
                                <div>
                                    Last Ping: <span style="color:#111827; font-weight:600;"><?= htmlspecialchars(date('H:i:s', strtotime($p['last_health_check'] ?? 'now'))) ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div style="border-top:1px solid #EAE5D9; padding-top:12px; display:flex; justify-content:flex-end;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:6px;" onclick="window.DTNotifications.testProvider('<?= addslashes($p['provider_key']) ?>', this)">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <span>Ping Handshake</span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/notifications/notifications.js?v=<?php echo time(); ?>"></script>
</body>
</html>
