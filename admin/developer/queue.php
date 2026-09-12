<?php
declare(strict_types=1);
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/developer/queue.php — Background Job Queue Studio & Worker Monitor
 * DT Brand's & Jai Hanuman Tex — Section 37
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/DeveloperManager.php';

use DTBrand\Database;
use DTBrand\DeveloperManager;

$dev = DeveloperManager::getInstance();
$filterStatus = $_GET['status'] ?? 'all';
$stats = $dev->getQueueStats();
$jobs = $dev->getQueueJobs($filterStatus, 100);

$active_nav = 'developer';
$active_subnav = 'queue';
$page_title = 'Queue & Background Jobs — DT Brand\'s Developer Studio';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="DT Brand's Background Jobs Studio — queue depth, worker status, retry failed jobs, and manual dispatch.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/admin/developer/developer.css?v=<?= time() ?>">
</head>
<body class="sys-root">
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="dev-container">
                <!-- Page Header -->
                <div class="dev-header">
                    <div class="dev-header-titles">
                        <h1>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                <line x1="3" y1="18" x2="3.01" y2="18"></line>
                            </svg>
                            <span>Background Job Queue Studio</span>
                            <span class="dev-badge-gold"><?= $stats['pending'] ?> Pending Jobs</span>
                        </h1>
                        <p>Asynchronous queue execution engine for WhatsApp dispatches, order notifications, inventory reconciliations, and report builds.</p>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <button class="dt-btn-gold" onclick="DevStudio.runAllPendingJobs(this)">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Run All Pending Jobs
                        </button>
                    </div>
                </div>

                <!-- Subnav Tabs -->
                <div class="dev-subnav">
                    <a href="/admin/developer/index.php" class="dev-tab">Overview</a>
                    <a href="/admin/developer/api-registry.php" class="dev-tab">API Registry</a>
                    <a href="/admin/developer/api-health.php" class="dev-tab">API Health &amp; Latency</a>
                    <a href="/admin/developer/webhooks.php" class="dev-tab">Webhook Events</a>
                    <a href="/admin/developer/queue.php" class="dev-tab active">Queue / Jobs (<?= $stats['total'] ?>)</a>
                    <a href="/admin/developer/routes.php" class="dev-tab">Route Map</a>
                    <a href="/admin/developer/migrations.php" class="dev-tab">Migrations</a>
                    <a href="/admin/developer/diagnostics.php" class="dev-tab">Diagnostics</a>
                </div>

                <!-- KPI Ribbon -->
                <div class="dev-kpi-grid">
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Pending In Queue</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:#D97706;"><?= $stats['pending'] ?></div>
                        <div class="dev-kpi-sub">Ready for immediate execution</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Successfully Completed</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:#15803D;"><?= $stats['completed'] ?></div>
                        <div class="dev-kpi-sub">Processed with zero errors</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Failed / Dead Letter</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:<?= $stats['failed'] > 0 ? '#DC2626' : '#15803D' ?>;"><?= $stats['failed'] ?></div>
                        <div class="dev-kpi-sub">Eligible for manual retry</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Active Workers</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
                        </div>
                        <div class="dev-kpi-value"><?= $stats['active_workers'] ?></div>
                        <div class="dev-kpi-sub">Worker Queue Latency: <?= $stats['queue_latency_ms'] ?>ms</div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="dev-card" style="padding:16px 20px; margin-bottom:20px;">
                    <form method="GET" action="/admin/developer/queue.php" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                        <div style="display:flex; gap:10px;">
                            <select name="status" class="dev-input" style="width:auto;" onchange="this.form.submit()">
                                <option value="all" <?= $filterStatus === 'all' ? 'selected' : '' ?>>All Statuses</option>
                                <option value="pending" <?= $filterStatus === 'pending' ? 'selected' : '' ?>>Pending (<?= $stats['pending'] ?>)</option>
                                <option value="completed" <?= $filterStatus === 'completed' ? 'selected' : '' ?>>Completed (<?= $stats['completed'] ?>)</option>
                                <option value="failed" <?= $filterStatus === 'failed' ? 'selected' : '' ?>>Failed (<?= $stats['failed'] ?>)</option>
                            </select>
                        </div>
                        <div style="font-size:0.8rem; color:#64748B;">
                            Showing <?= count($jobs) ?> jobs
                        </div>
                    </form>
                </div>

                <!-- Queue Jobs Table -->
                <div class="dev-card">
                    <div class="dev-table-wrapper">
                        <table class="dev-table">
                            <thead>
                                <tr>
                                    <th>Job ID &amp; Type</th>
                                    <th>Queue</th>
                                    <th>Status</th>
                                    <th>Attempts</th>
                                    <th>Created</th>
                                    <th>Completed</th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($jobs)): ?>
                                <tr>
                                    <td colspan="7" style="text-align:center; padding:30px; color:#64748B;">No queue jobs found matching the selected status.</td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($jobs as $job):
                                        $st = $job['status'] ?? 'pending';
                                        $statusClass = match ($st) {
                                            'completed' => 'dev-status-success',
                                            'failed' => 'dev-status-danger',
                                            'running' => 'dev-status-info',
                                            default => 'dev-status-warning'
                                        };
                                    ?>
                                    <tr id="job-row-<?= htmlspecialchars($job['job_id']) ?>">
                                        <td>
                                            <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($job['job_type']) ?></div>
                                            <div class="dev-endpoint-code" style="margin-top:4px;"><?= htmlspecialchars($job['job_id']) ?></div>
                                            <?php if (!empty($job['error_message'])): ?>
                                                <div style="font-size:0.75rem; color:#DC2626; margin-top:4px;">
                                                    Error: <?= htmlspecialchars($job['error_message']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="dev-badge-gold" style="font-size:0.72rem;"><?= htmlspecialchars($job['queue_name']) ?></span>
                                        </td>
                                        <td class="job-status-cell">
                                            <span class="dev-status <?= $statusClass ?>"><?= htmlspecialchars($st) ?></span>
                                        </td>
                                        <td>
                                            <span style="font-size:0.8rem; color:#64748B;"><?= $job['attempts'] ?> / <?= $job['max_attempts'] ?></span>
                                        </td>
                                        <td>
                                            <span style="font-size:0.78rem; color:#64748B;"><?= htmlspecialchars($job['created_at']) ?></span>
                                        </td>
                                        <td>
                                            <span style="font-size:0.78rem; color:#64748B;"><?= htmlspecialchars($job['completed_at'] ?? '—') ?></span>
                                        </td>
                                        <td style="text-align:right;">
                                            <div style="display:inline-flex; gap:6px;">
                                                <button class="dt-btn-pale" onclick="DevStudio.showPayloadModal('Job <?= htmlspecialchars($job['job_id']) ?> Payload', <?= htmlspecialchars(json_encode($job['payload_json'])) ?>)">
                                                    Payload
                                                </button>
                                                <?php if ($st === 'pending'): ?>
                                                    <button class="dt-btn-gold" style="padding:4px 10px; font-size:0.75rem;" onclick="DevStudio.runQueueJob('<?= htmlspecialchars($job['job_id']) ?>', this)">
                                                        Run Now
                                                    </button>
                                                <?php elseif ($st === 'failed'): ?>
                                                    <button class="dt-btn-pale" style="padding:4px 10px; font-size:0.75rem; border-color:#DC2626; color:#DC2626;" onclick="retryJob('<?= htmlspecialchars($job['job_id']) ?>', this)">
                                                        Retry
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/developer/developer.js?v=<?= time() ?>"></script>
<script>
async function retryJob(jobId, btn) {
    if (btn) {
        btn.disabled = true;
        btn.textContent = 'Retrying...';
    }
    try {
        const res = await DevStudio.post('queue_retry', { job_id: jobId });
        if (res.status === 'success') {
            DevStudio.toast(`Job ${jobId} marked for immediate retry!`, 'success');
            const row = document.getElementById('job-row-' + jobId);
            if (row) {
                const cell = row.querySelector('.job-status-cell');
                if (cell) cell.innerHTML = '<span class="dev-status dev-status-warning">pending</span>';
            }
            if (btn) btn.textContent = 'Queued';
        } else {
            DevStudio.toast(res.message || 'Retry failed', 'error');
            if (btn) {
                btn.disabled = false;
                btn.textContent = 'Retry';
            }
        }
    } catch (e) {
        DevStudio.toast('Network error retrying job', 'error');
        if (btn) {
            btn.disabled = false;
            btn.textContent = 'Retry';
        }
    }
}
</script>
</body>
</html>
