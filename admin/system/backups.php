<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/backups.php — Database Backup Management
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/SystemManager.php';
use DTBrand\SystemManager;

$sm      = SystemManager::getInstance();
$csrf    = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(16));
$_SESSION['csrf_token'] = $csrf;

$backups = $sm->getBackupHistory();

$totalSize = array_sum(array_column($backups, 'size_bytes'));
function fmtBytes(int $b): string {
    if ($b >= 1073741824) return round($b/1073741824,2).' GB';
    if ($b >= 1048576)    return round($b/1048576,2).' MB';
    if ($b >= 1024)       return round($b/1024,2).' KB';
    return $b.' B';
}

$active_nav    = 'system';
$active_subnav = 'backups';
$page_title    = 'Database Backups — DT Brand\'s';
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
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>
                        Database Backups
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:.82rem;">Automated and manual MySQL dumps with compression and password-protected deletion.</p>
                </div>
                <div style="display:flex;gap:8px;">
                    <button class="sys-btn-gold" onclick="sysRunBackup()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>
                        Run Backup Now
                    </button>
                    <a href="/admin/system/" class="sys-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                        Suite
                    </a>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="sys-health-grid" style="margin-bottom:20px;">
                <div class="sys-health-card pass">
                    <div class="sys-health-icon pass"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg></div>
                    <div class="sys-health-label">Total Backups</div>
                    <div class="sys-health-value"><?= count($backups) ?></div>
                    <div class="sys-health-meta">All time</div>
                </div>
                <div class="sys-health-card <?= !empty($backups) ? 'pass' : 'warn' ?>">
                    <div class="sys-health-icon <?= !empty($backups) ? 'pass' : 'warn' ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="sys-health-label">Latest Backup</div>
                    <div class="sys-health-value" style="font-size:12px;"><?= !empty($backups) ? htmlspecialchars($backups[0]['created_at'] ?? '—') : 'Never' ?></div>
                    <div class="sys-health-meta"><?= !empty($backups) ? htmlspecialchars($backups[0]['filename'] ?? '') : 'Run your first backup' ?></div>
                </div>
                <div class="sys-health-card pass">
                    <div class="sys-health-icon pass">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div class="sys-health-label">Total Storage</div>
                    <div class="sys-health-value"><?= fmtBytes((int)$totalSize) ?></div>
                    <div class="sys-health-meta">Compressed SQL dumps</div>
                </div>
                <div class="sys-health-card pass">
                    <div class="sys-health-icon pass">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div class="sys-health-label">Auto-Backup</div>
                    <div class="sys-health-value">Daily</div>
                    <div class="sys-health-meta">Cron: 0 2 * * *</div>
                </div>
            </div>

            <!-- Backup Table -->
            <div class="sys-card">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">Backup Archive (<?= count($backups) ?> files)</h3>
                </div>
                <div class="sys-table-wrap">
                    <table class="sys-table">
                        <thead>
                            <tr>
                                <th>Filename</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Created At</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th style="width:100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($backups)): ?>
                            <tr><td colspan="7" style="padding:24px;text-align:center;color:#94A3B8;font-size:13px;">No backups found. Run your first backup now.</td></tr>
                        <?php else: ?>
                        <?php foreach ($backups as $bk): ?>
                            <tr>
                                <td class="mono" style="font-size:11.5px;"><?= htmlspecialchars($bk['filename'] ?? '—') ?></td>
                                <td>
                                    <span class="sys-health-badge" style="background:#EFF6FF;color:#1D4ED8;font-size:.65rem;">
                                        <?= htmlspecialchars(strtoupper($bk['type'] ?? 'db')) ?>
                                    </span>
                                </td>
                                <td class="mono"><?= htmlspecialchars(fmtBytes((int)($bk['size_bytes'] ?? 0))) ?></td>
                                <td class="mono" style="white-space:nowrap;"><?= htmlspecialchars($bk['created_at'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($bk['created_by_name'] ?? 'System') ?></td>
                                <td>
                                    <span class="sys-health-badge <?= ($bk['status'] ?? '') === 'success' ? 'pass' : 'fail' ?>" style="font-size:.65rem;">
                                        <?= strtoupper($bk['status'] ?? 'ok') ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;">
                                        <?php if (!empty($bk['filename'])): ?>
                                        <a href="/backups/<?= htmlspecialchars(rawurlencode($bk['filename'])) ?>" class="sys-btn-pale" style="font-size:11px;padding:4px 9px;" download>
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                        </a>
                                        <?php endif; ?>
                                        <button class="sys-btn-danger" style="font-size:11px;padding:4px 9px;"
                                            onclick="sysDeleteBackup('<?= htmlspecialchars($bk['filename'] ?? '') ?>')">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                    </div>
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
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/system/system.js?v=<?= time() ?>"></script>
<script>
async function sysRunBackup() {
    if (!confirm('Trigger a full database backup now?')) return;
    try {
        const data = await sysPost('/api/system.php', { action: 'backup_run', _csrf: '<?= htmlspecialchars($csrf) ?>' });
        sysToast(data.message || 'Backup started.', data.success ? 'success' : 'error');
        if (data.success) setTimeout(() => location.reload(), 2000);
    } catch (e) { sysToast('Backup failed.', 'error'); }
}
async function sysDeleteBackup(file) {
    if (!file) return;
    const pwd = prompt('Enter admin password to delete backup "' + file + '":');
    if (!pwd) return;
    try {
        const data = await sysPost('/api/system.php', {
            action: 'backup_delete',
            file,
            password: pwd,
            _csrf: '<?= htmlspecialchars($csrf) ?>'
        });
        sysToast(data.message || 'Done.', data.success ? 'success' : 'error');
        if (data.success) setTimeout(() => location.reload(), 1400);
    } catch(e) { sysToast('Delete failed.', 'error'); }
}
</script>
</body>
</html>