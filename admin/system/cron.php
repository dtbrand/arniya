<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/cron.php — Cron Scheduler & Job Monitor
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/SystemManager.php';
use DTBrand\SystemManager;

$sm   = SystemManager::getInstance();
$csrf = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(16));
$_SESSION['csrf_token'] = $csrf;

$jobs = $sm->getCronJobs();

$active_nav    = 'system';
$active_subnav = 'cron';
$page_title    = 'Cron Scheduler — DT Brand\'s';
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
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Cron Scheduler
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:.82rem;">Manage recurring automated tasks — view schedules, enable/disable, and trigger manual runs.</p>
                </div>
                <a href="/admin/system/" class="sys-btn-pale">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                    Suite
                </a>
            </div>

            <!-- Cron Jobs List -->
            <div class="sys-card">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Registered Cron Jobs (<?= count($jobs) ?>)
                    </h3>
                    <span class="sys-health-badge pass" style="font-size:.68rem;"><?= count(array_filter($jobs, fn($j) => !empty($j['enabled']))) ?> Active</span>
                </div>
                <div style="padding:0;">
                    <?php if (empty($jobs)): ?>
                    <div style="padding:32px;text-align:center;color:#94A3B8;font-size:13px;">No cron jobs registered.</div>
                    <?php endif; ?>
                    <?php foreach ($jobs as $job):
                        $enabled = !empty($job['enabled']);
                        $lastRun = $job['last_run'] ?? null;
                        $nextRun = $job['next_run'] ?? null;
                        $lastStatus = $job['last_status'] ?? 'unknown';
                    ?>
                    <div class="sys-list-item">
                        <div class="sys-list-icon" style="background:<?= $enabled ? '#DCFCE7' : '#F1F5F9' ?>;color:<?= $enabled ? '#15803D' : '#94A3B8' ?>;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="sys-list-body">
                            <div class="sys-list-name"><?= htmlspecialchars($job['name'] ?? $job['job_name'] ?? '—') ?></div>
                            <div class="sys-list-meta">
                                Schedule: <strong><?= htmlspecialchars($job['schedule'] ?? '* * * * *') ?></strong>
                                &nbsp;|&nbsp; Last run: <?= htmlspecialchars($lastRun ?? 'Never') ?>
                                &nbsp;|&nbsp; Next: <?= htmlspecialchars($nextRun ?? '—') ?>
                            </div>
                        </div>
                        <div class="sys-list-actions">
                            <!-- Last run status badge -->
                            <?php if ($lastStatus === 'success'): ?>
                            <span class="sys-health-badge pass" style="font-size:.65rem;">OK</span>
                            <?php elseif ($lastStatus === 'failed'): ?>
                            <span class="sys-health-badge fail" style="font-size:.65rem;">Failed</span>
                            <?php else: ?>
                            <span class="sys-health-badge" style="font-size:.65rem;background:#F1F5F9;color:#64748B;">—</span>
                            <?php endif; ?>

                            <!-- Enable/Disable Toggle -->
                            <label class="sys-toggle" title="<?= $enabled ? 'Click to disable' : 'Click to enable' ?>">
                                <input type="checkbox" <?= $enabled ? 'checked' : '' ?>
                                    onchange="sysCronToggle('<?= htmlspecialchars($job['job_name'] ?? $job['name'] ?? '') ?>', this.checked)">
                                <span class="sys-toggle-slider"></span>
                            </label>

                            <!-- Manual Run -->
                            <button class="sys-btn-pale" style="font-size:11px;padding:5px 10px;"
                                onclick="sysCronRun('<?= htmlspecialchars($job['job_name'] ?? $job['name'] ?? '') ?>')">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                Run Now
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Cron Table (detailed) -->
            <div class="sys-card" style="margin-top:16px;">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">Cron Execution History</h3>
                </div>
                <div class="sys-table-wrap">
                    <table class="sys-table">
                        <thead>
                            <tr>
                                <th>Job Name</th>
                                <th>Schedule (Cron Expression)</th>
                                <th>Last Executed</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Enabled</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($jobs as $job): ?>
                            <tr>
                                <td style="font-weight:700;color:#1F2937;"><?= htmlspecialchars($job['name'] ?? $job['job_name'] ?? '—') ?></td>
                                <td class="mono"><?= htmlspecialchars($job['schedule'] ?? '—') ?></td>
                                <td class="mono"><?= htmlspecialchars($job['last_run'] ?? 'Never') ?></td>
                                <td class="mono"><?= htmlspecialchars(isset($job['last_duration_ms']) ? $job['last_duration_ms'].'ms' : '—') ?></td>
                                <td>
                                    <?php $s = $job['last_status'] ?? 'unknown'; ?>
                                    <span class="sys-lvl <?= $s === 'success' ? 'sys-lvl-success' : ($s === 'failed' ? 'sys-lvl-error' : 'sys-lvl-debug') ?>"><?= htmlspecialchars(strtoupper($s)) ?></span>
                                </td>
                                <td>
                                    <?php if (!empty($job['enabled'])): ?>
                                    <span class="sys-health-badge pass">On</span>
                                    <?php else: ?>
                                    <span class="sys-health-badge" style="background:#F1F5F9;color:#64748B;">Off</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($jobs)): ?>
                            <tr><td colspan="6" style="padding:24px;text-align:center;color:#94A3B8;font-size:13px;">No jobs registered.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cron Setup Guide -->
            <div class="sys-card" style="margin-top:16px;">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">Hostinger Cron Configuration</h3>
                </div>
                <div class="sys-card-body">
                    <p style="font-size:12.5px;color:#64748B;margin:0 0 12px;">Add the following command to Hostinger hPanel → Cron Jobs (every minute):</p>
                    <pre class="sys-log-pre" style="max-height:60px;font-size:12px;">* * * * * php <?= htmlspecialchars($_SERVER['DOCUMENT_ROOT'] ?? '/home/u602484543/domains/jaihanumantex.in/public_html') ?>/cron/runner.php >> /dev/null 2>&1</pre>
                    <p style="font-size:11.5px;color:#94A3B8;margin:10px 0 0;">Alternatively set up individual jobs per-task for more granular control.</p>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/system/system.js?v=<?= time() ?>"></script>
<script>
async function sysCronToggle(job, enabled) {
    try {
        const data = await sysPost('/api/system.php', { action: 'cron_toggle', job, enabled: enabled ? 1 : 0, _csrf: '<?= htmlspecialchars($csrf) ?>' });
        sysToast(data.message || 'Cron updated.', data.success ? 'success' : 'error');
    } catch (e) { sysToast('Toggle failed.', 'error'); }
}
</script>
</body>
</html>
