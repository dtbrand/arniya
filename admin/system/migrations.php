<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/migrations.php — Database Migration Governance Centre
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/SystemManager.php';
use DTBrand\SystemManager;

$sm         = SystemManager::getInstance();
$migrations = $sm->getMigrationHistory();

$active_nav    = 'system';
$active_subnav = 'migrations';
$page_title    = 'Database Migrations — DT Brand\'s';

$applied  = array_filter($migrations, fn($m) => $m['status'] === 'applied');
$pending  = array_filter($migrations, fn($m) => $m['status'] === 'pending');
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
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                        Database Migration Governance
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:.82rem;">All schema migrations follow <strong>docs/database-safety.md</strong>: zero-destructive, transactional, idempotent.</p>
                </div>
                <div style="display:flex;gap:8px;">
                    <span class="sys-health-badge pass" style="font-size:.72rem;"><?= count($applied) ?> Applied</span>
                    <?php if (!empty($pending)): ?>
                    <span class="sys-health-badge warn" style="font-size:.72rem;"><?= count($pending) ?> Pending</span>
                    <?php endif; ?>
                    <a href="/admin/system/" class="sys-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                        Suite
                    </a>
                </div>
            </div>

            <!-- Migration Table -->
            <div class="sys-card">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        Canonical Migration History (<?= count($migrations) ?> total)
                    </h3>
                </div>
                <div class="sys-table-wrap">
                    <table class="sys-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Migration Identifier</th>
                                <th>Scope & Impact</th>
                                <th>Applied At</th>
                                <th>Exec Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($migrations as $i => $mig): ?>
                            <tr>
                                <td style="font-weight:700;color:#94A3B8;"><?= str_pad((string)($i+1), 2, '0', STR_PAD_LEFT) ?></td>
                                <td class="mono" style="max-width:300px;white-space:normal;word-break:break-word;"><?= htmlspecialchars($mig['migration']) ?></td>
                                <td style="color:#475569;font-size:12px;"><?= htmlspecialchars($mig['description'] ?? '') ?></td>
                                <td class="mono" style="white-space:nowrap;"><?= htmlspecialchars($mig['applied_at'] ?? '—') ?></td>
                                <td class="mono"><?= htmlspecialchars(isset($mig['execution_time_ms']) ? $mig['execution_time_ms'].'ms' : '—') ?></td>
                                <td>
                                    <?php if ($mig['status'] === 'applied'): ?>
                                    <span class="sys-health-badge pass">
                                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="20 6 9 17 4 12"/></svg>
                                        Applied
                                    </span>
                                    <?php elseif ($mig['status'] === 'pending'): ?>
                                    <span class="sys-health-badge warn">Pending</span>
                                    <?php else: ?>
                                    <span class="sys-health-badge fail">Failed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($migrations)): ?>
                            <tr><td colspan="6" style="padding:24px;text-align:center;color:#94A3B8;font-size:13px;">No migration records found.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- DB Safety Policy Card -->
            <div class="sys-card" style="margin-top:16px;">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Database Safety Policy
                    </h3>
                </div>
                <div class="sys-card-body">
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;">
                        <?php
                        $policies = [
                            ['icon'=>'<polyline points="20 6 9 17 4 12"/>',                                          'title'=>'Zero-Destructive Operations', 'desc'=>'No DROP TABLE or TRUNCATE in any migration. All schema changes are additive.'],
                            ['icon'=>'<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.66 4 3 9 3"/>',   'title'=>'Transactional Tracking',      'desc'=>'All migrations logged in _migrations with timestamp & execution time.'],
                            ['icon'=>'<polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>', 'title'=>'Idempotent Definitions',  'desc'=>'Every migration uses CREATE TABLE IF NOT EXISTS / ADD COLUMN IF NOT EXISTS.'],
                            ['icon'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>', 'title'=>'Rollback Safety', 'desc'=>'Rollback scripts stored alongside each migration for emergency revert.'],
                        ];
                        foreach ($policies as $p): ?>
                        <div style="padding:14px;background:#FAF5E8;border:1px solid #E6CA65;border-radius:10px;">
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                                <div style="width:30px;height:30px;background:#FFF9E6;border-radius:7px;display:flex;align-items:center;justify-content:center;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><?= $p['icon'] ?></svg>
                                </div>
                                <div style="font-size:12.5px;font-weight:800;color:#5A4210;"><?= htmlspecialchars($p['title']) ?></div>
                            </div>
                            <div style="font-size:11.5px;color:#705114;line-height:1.5;"><?= htmlspecialchars($p['desc']) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/system/system.js?v=<?= time() ?>"></script>
</body>
</html>
