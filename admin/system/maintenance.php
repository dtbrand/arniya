<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/maintenance.php — Site Maintenance Mode Control Centre
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/SystemManager.php';
use DTBrand\SystemManager;

$sm     = SystemManager::getInstance();
$csrf   = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(16));
$_SESSION['csrf_token'] = $csrf;

$maintenanceStatus = $sm->getMaintenanceStatus();
$isActive  = !empty($maintenanceStatus['active']);
$enabledAt = $maintenanceStatus['enabled_at'] ?? null;
$enabledBy = $maintenanceStatus['enabled_by'] ?? null;
$message   = $maintenanceStatus['message'] ?? 'We\'re performing scheduled maintenance. We\'ll be back shortly.';
$eta       = $maintenanceStatus['eta'] ?? '';

$active_nav    = 'system';
$active_subnav = 'maintenance';
$page_title    = 'Maintenance Mode — DT Brand\'s';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/admin/system/system.css?v=<?= time() ?>">
</head>
<body class="sys-root">
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="adm-page-head" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:18px;">
                <div>
                    <h1 class="adm-page-title" style="display:flex;align-items:center;gap:8px;margin:0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                        Maintenance Mode
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:.82rem;">Toggle the public site maintenance page with a custom message and ETA.</p>
                </div>
                <a href="/admin/system/" class="sys-btn-pale">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                    Suite
                </a>
            </div>

            <!-- Current Status Banner -->
            <div class="sys-maintenance-banner <?= $isActive ? '' : 'inactive' ?>" style="margin-bottom:20px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <?php if ($isActive): ?>
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    <?php else: ?>
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    <?php endif; ?>
                </svg>
                <div style="flex:1;">
                    <div style="font-size:15px;font-weight:800;margin-bottom:2px;">
                        <?= $isActive ? 'MAINTENANCE MODE IS ACTIVE' : 'Site is Live — Maintenance Mode Disabled' ?>
                    </div>
                    <div style="font-size:12px;opacity:.85;">
                        <?php if ($isActive): ?>
                        Enabled <?= $enabledAt ? 'at ' . htmlspecialchars($enabledAt) : '' ?>
                        <?= $enabledBy ? ' by ' . htmlspecialchars($enabledBy) : '' ?>
                        <?php else: ?>
                        Public storefront is fully operational.
                        <?php endif; ?>
                    </div>
                </div>
                <button class="<?= $isActive ? 'sys-btn-gold' : 'sys-btn-danger' ?>"
                    onclick="sysToggleMaintenance(<?= $isActive ? 'false' : 'true' ?>)">
                    <?= $isActive ? 'Disable Maintenance' : 'Enable Maintenance Mode' ?>
                </button>
            </div>

            <!-- Maintenance Message Config -->
            <div class="sys-card">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">Maintenance Page Configuration</h3>
                    <button class="sys-btn-gold" onclick="saveMaintConfig()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/></svg>
                        Save Config
                    </button>
                </div>
                <div class="sys-card-body">
                    <div class="sys-settings-grid">
                        <div class="sys-field" style="grid-column:1/-1;">
                            <label class="sys-field-label">Public Maintenance Message</label>
                            <textarea id="maintMessage" class="sys-textarea" rows="3"><?= htmlspecialchars($message) ?></textarea>
                        </div>
                        <div class="sys-field">
                            <label class="sys-field-label">Estimated Return Time (ETA)</label>
                            <input type="datetime-local" id="maintEta" class="sys-input" value="<?= htmlspecialchars($eta) ?>">
                            <span class="sys-field-hint">Leave blank to hide the ETA countdown.</span>
                        </div>
                        <div class="sys-field">
                            <label class="sys-field-label">Bypass IPs (comma-separated)</label>
                            <input type="text" id="maintBypassIps" class="sys-input"
                                value="<?= htmlspecialchars($maintenanceStatus['bypass_ips'] ?? '127.0.0.1') ?>"
                                placeholder="127.0.0.1, 192.168.1.1">
                            <span class="sys-field-hint">These IPs will see the live site even during maintenance.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Impact Notice -->
            <div style="background:#FEF3C7;border:1.5px solid #FDE68A;border-radius:12px;padding:18px 20px;margin-top:16px;display:flex;gap:12px;align-items:flex-start;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.2" style="flex-shrink:0;margin-top:1px;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <div>
                    <div style="font-size:13px;font-weight:800;color:#92400E;margin-bottom:6px;">What happens when Maintenance Mode is active?</div>
                    <ul style="font-size:12px;color:#78350F;margin:0;padding-left:18px;line-height:1.7;">
                        <li>All public storefront requests return a 503 maintenance page.</li>
                        <li>The admin panel (/admin/) remains fully accessible.</li>
                        <li>Bypass IPs see the live site normally.</li>
                        <li>Cron jobs and webhooks continue to run unaffected.</li>
                        <li>All maintenance toggles are logged in the Audit Trail.</li>
                    </ul>
                </div>
            </div>

            <!-- Re-auth modal (reused across all danger ops) -->
            <div id="sysDangerModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);z-index:99999;align-items:center;justify-content:center;">
                <div style="background:#FFFFFF;border-radius:14px;padding:28px;max-width:440px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
                    <h3 style="font-size:16px;font-weight:800;color:#DC2626;margin:0 0 6px;display:flex;align-items:center;gap:8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        Confirm Operation
                    </h3>
                    <p id="sysDangerLabel" style="font-size:13px;color:#64748B;margin:0 0 16px;"></p>
                    <div class="sys-field" style="margin-bottom:14px;">
                        <label class="sys-field-label">Admin Password (re-authentication)</label>
                        <input type="password" id="sysDangerPwd" class="sys-input" autocomplete="current-password">
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;">
                        <button class="sys-btn-pale" onclick="sysCloseDangerModal()">Cancel</button>
                        <button id="sysDangerConfirmBtn" class="sys-btn-danger">Confirm</button>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/system/system.js?v=<?= time() ?>"></script>
<script>
async function sysToggleMaintenance(enable) {
    if (!confirm((enable ? 'Enable' : 'Disable') + ' maintenance mode?')) return;
    const pwd = prompt('Enter your admin password to confirm:');
    if (!pwd) return;
    try {
        const data = await sysPost('/api/system.php', {
            action: 'maintenance_toggle',
            enable: enable ? 1 : 0,
            password: pwd,
            _csrf: '<?= htmlspecialchars($csrf) ?>'
        });
        sysToast(data.message || 'Done.', data.success ? 'success' : 'error');
        if (data.success) setTimeout(() => location.reload(), 1400);
    } catch (e) { sysToast('Operation failed.', 'error'); }
}

async function saveMaintConfig() {
    const data = await sysPost('/api/system.php', {
        action: 'general',
        section: 'maintenance',
        maintenance_message:  document.getElementById('maintMessage').value,
        maintenance_eta:      document.getElementById('maintEta').value,
        maintenance_bypass:   document.getElementById('maintBypassIps').value,
        _csrf: '<?= htmlspecialchars($csrf) ?>'
    });
    sysToast(data.message || 'Saved.', data.success ? 'success' : 'error');
}
</script>
</body>
</html>
