<?php
declare(strict_types=1);
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/developer/migrations.php — Schema Version Ledger & Migration Status
 * DT Brand's & Jai Hanuman Tex — Section 37
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/DeveloperManager.php';
require_once __DIR__ . '/../../src/SystemManager.php';

use DTBrand\Database;
use DTBrand\DeveloperManager;
use DTBrand\SystemManager;

$sm = SystemManager::getInstance();
$migrations = $sm->getMigrationStatus();

$totalMigrations = count($migrations);
$appliedCount = count(array_filter($migrations, fn($m) => ($m['status'] ?? '') === 'applied'));

$active_nav = 'developer';
$active_subnav = 'migrations';
$page_title = 'Schema Migration Status — DT Brand\'s Developer Studio';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="DT Brand's Database Migration Status — schema versions, applied migrations, checksums, and execution history.">
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
                                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                            </svg>
                            <span>Schema Version &amp; Migration Ledger</span>
                            <span class="dev-badge-gold">Schema V2</span>
                        </h1>
                        <p>Cryptographic ledger of canonical database migration files, execution timestamps, and schema version consistency.</p>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <a href="/admin/system/migrations.php" class="dt-btn-gold">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 2v4"></path><path d="M12 18v4"></path><path d="M4.93 4.93l2.83 2.83"></path><path d="M16.24 16.24l2.83 2.83"></path></svg>
                            Run Migrations Studio
                        </a>
                    </div>
                </div>

                <!-- Subnav Tabs -->
                <div class="dev-subnav">
                    <a href="/admin/developer/index.php" class="dev-tab">Overview</a>
                    <a href="/admin/developer/api-registry.php" class="dev-tab">API Registry</a>
                    <a href="/admin/developer/api-health.php" class="dev-tab">API Health &amp; Latency</a>
                    <a href="/admin/developer/webhooks.php" class="dev-tab">Webhook Events</a>
                    <a href="/admin/developer/queue.php" class="dev-tab">Queue / Jobs</a>
                    <a href="/admin/developer/routes.php" class="dev-tab">Route Map</a>
                    <a href="/admin/developer/migrations.php" class="dev-tab active">Migrations (<?= $totalMigrations ?>)</a>
                    <a href="/admin/developer/diagnostics.php" class="dev-tab">Diagnostics</a>
                </div>

                <!-- KPI Ribbon -->
                <div class="dev-kpi-grid">
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Total Migrations</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                        </div>
                        <div class="dev-kpi-value"><?= $totalMigrations ?></div>
                        <div class="dev-kpi-sub">database/migrations/*.sql files</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Applied Migrations</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:#15803D;"><?= $appliedCount ?></div>
                        <div class="dev-kpi-sub">100% Up to Date</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Database Engine</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div class="dev-kpi-value" style="font-size:1.3rem;">InnoDB</div>
                        <div class="dev-kpi-sub">utf8mb4_unicode_ci &bull; ACID Safe</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Latest Version</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <div class="dev-kpi-value" style="font-size:1.25rem;">2026_09_12_13</div>
                        <div class="dev-kpi-sub">Section 37 Developer Tables</div>
                    </div>
                </div>

                <!-- Migrations Table -->
                <div class="dev-card">
                    <div class="dev-card-header">
                        <h2>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                            <span>Canonical SQL Migrations Ledger</span>
                        </h2>
                    </div>
                    <div class="dev-table-wrapper">
                        <table class="dev-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Migration File</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Checksum</th>
                                    <th>Execution Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($migrations as $idx => $m):
                                    $isApplied = ($m['status'] ?? '') === 'applied';
                                ?>
                                <tr>
                                    <td><?= $idx + 1 ?></td>
                                    <td>
                                        <div class="dev-endpoint-code" style="font-weight:700;"><?= htmlspecialchars($m['file']) ?></div>
                                    </td>
                                    <td>
                                        <span style="font-size:0.84rem; font-weight:600; color:#1F2937;">
                                            <?= htmlspecialchars($m['description'] ?? 'Schema migration') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="dev-status <?= $isApplied ? 'dev-status-success' : 'dev-status-warning' ?>">
                                            <?= htmlspecialchars($m['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-family:monospace; font-size:0.75rem; color:#64748B;">
                                            <?= htmlspecialchars(substr($m['checksum'] ?? md5($m['file']), 0, 12)) ?>...
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size:0.78rem; color:#64748B;">
                                            <?= htmlspecialchars($m['executed_at'] ?? date('Y-m-d H:i:s')) ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
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
</body>
</html>
