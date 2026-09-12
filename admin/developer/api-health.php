<?php
declare(strict_types=1);
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/developer/api-health.php — API Health & Latency Matrix
 * DT Brand's & Jai Hanuman Tex — Section 37
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/DeveloperManager.php';

use DTBrand\Database;
use DTBrand\DeveloperManager;

$dev = DeveloperManager::getInstance();
$health = $dev->getApiHealth();

$active_nav = 'developer';
$active_subnav = 'health';
$page_title = 'API Health & Latency Monitor — DT Brand\'s Developer Studio';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="DT Brand's API Health Monitor — real-time endpoint latency matrix, uptime metrics, and response times.">
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
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                            </svg>
                            <span>API Health &amp; Latency Matrix</span>
                            <span class="dev-badge-gold">Live Telemetry</span>
                        </h1>
                        <p>Continuous monitoring of critical API route responsiveness, HTTP status codes, and server execution latencies.</p>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <button class="dt-btn-gold" onclick="window.location.reload();">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                            Re-Test All Endpoints
                        </button>
                    </div>
                </div>

                <!-- Subnav Tabs -->
                <div class="dev-subnav">
                    <a href="/admin/developer/index.php" class="dev-tab">Overview</a>
                    <a href="/admin/developer/api-registry.php" class="dev-tab">API Registry</a>
                    <a href="/admin/developer/api-health.php" class="dev-tab active">API Health &amp; Latency</a>
                    <a href="/admin/developer/webhooks.php" class="dev-tab">Webhook Events</a>
                    <a href="/admin/developer/queue.php" class="dev-tab">Queue / Jobs</a>
                    <a href="/admin/developer/routes.php" class="dev-tab">Route Map</a>
                    <a href="/admin/developer/migrations.php" class="dev-tab">Migrations</a>
                    <a href="/admin/developer/diagnostics.php" class="dev-tab">Diagnostics</a>
                </div>

                <!-- KPI Ribbon -->
                <div class="dev-kpi-grid">
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>System Health Score</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:#15803D;"><?= $health['health_score'] ?>%</div>
                        <div class="dev-kpi-sub"><?= $health['healthy_count'] ?> of <?= $health['total_endpoints'] ?> endpoints 100% operational</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Service Uptime (30d)</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div class="dev-kpi-value"><?= htmlspecialchars($health['uptime_percent']) ?></div>
                        <div class="dev-kpi-sub" style="color:#15803D;">Zero critical downtime recorded</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Avg Response Latency</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
                        <div class="dev-kpi-value"><?= $health['avg_latency_ms'] ?>ms</div>
                        <div class="dev-kpi-sub" style="color:#15803D;">Benchmark: Target &lt; 150ms</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Last Full Sweep</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                        <div class="dev-kpi-value" style="font-size:1.2rem; margin-top:6px;"><?= htmlspecialchars($health['checked_at']) ?></div>
                        <div class="dev-kpi-sub">Real-Time Continuous Scan</div>
                    </div>
                </div>

                <!-- Health Matrix Table -->
                <div class="dev-card">
                    <div class="dev-card-header">
                        <h2>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                            <span>Endpoint Responsiveness &amp; Latency Matrix</span>
                        </h2>
                        <div style="display:flex; gap:12px; font-size:0.78rem;">
                            <span style="display:inline-flex; align-items:center; gap:4px;"><span style="width:10px; height:10px; background:#15803D; border-radius:2px;"></span> &lt; 120ms (Fast)</span>
                            <span style="display:inline-flex; align-items:center; gap:4px;"><span style="width:10px; height:10px; background:#D97706; border-radius:2px;"></span> 120-300ms (Moderate)</span>
                            <span style="display:inline-flex; align-items:center; gap:4px;"><span style="width:10px; height:10px; background:#DC2626; border-radius:2px;"></span> &gt; 300ms (Degraded)</span>
                        </div>
                    </div>

                    <div class="dev-table-wrapper">
                        <table class="dev-table">
                            <thead>
                                <tr>
                                    <th>Service &amp; Endpoint</th>
                                    <th>Method</th>
                                    <th>Tier</th>
                                    <th>HTTP Status</th>
                                    <th>Response Latency</th>
                                    <th>Health Grade</th>
                                    <th style="text-align:right;">Quick Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($health['endpoints'] as $idx => $ep):
                                    $cellId = 'hp-cell-' . $idx;
                                    $lat = $ep['latency_ms'];
                                    $latPercent = min(100, max(10, (int)($lat / 3)));
                                    $latClass = $lat < 120 ? 'dev-latency-fast' : ($lat < 300 ? 'dev-latency-moderate' : 'dev-latency-slow');
                                    $latColor = $lat < 120 ? '#15803D' : ($lat < 300 ? '#D97706' : '#DC2626');
                                    $isCrit = $ep['critical'] ?? false;
                                ?>
                                <tr>
                                    <td>
                                        <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($ep['name']) ?></div>
                                        <div class="dev-endpoint-code" style="margin-top:4px;"><?= htmlspecialchars($ep['endpoint']) ?></div>
                                    </td>
                                    <td>
                                        <span class="dev-method dev-method-<?= strtolower($ep['method']) ?>"><?= htmlspecialchars($ep['method']) ?></span>
                                    </td>
                                    <td>
                                        <?php if ($isCrit): ?>
                                            <span class="dev-status dev-status-danger" style="font-size:0.7rem;">CRITICAL</span>
                                        <?php else: ?>
                                            <span class="dev-status dev-status-info" style="font-size:0.7rem;">STANDARD</span>
                                        <?php endif; ?>
                                    </td>
                                    <td id="status-code-<?= $idx ?>">
                                        <span class="dev-status dev-status-success"><?= $ep['status_code'] ?> OK</span>
                                    </td>
                                    <td id="latency-cell-<?= $idx ?>">
                                        <div class="dev-latency-bar-wrap">
                                            <div class="dev-latency-bar <?= $latClass ?>" style="width: <?= $latPercent ?>%;"></div>
                                        </div>
                                        <span style="font-weight:700; color:<?= $latColor ?>; font-size:0.84rem;"><?= $lat ?>ms</span>
                                    </td>
                                    <td id="grade-cell-<?= $idx ?>">
                                        <span class="dev-status dev-status-success"><?= ucfirst($ep['health_status']) ?></span>
                                    </td>
                                    <td style="text-align:right;">
                                        <button class="dt-btn-pale" onclick="testHealthRow(<?= $idx ?>, '<?= htmlspecialchars($ep['endpoint']) ?>', '<?= htmlspecialchars($ep['method']) ?>')">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                            Test Now
                                        </button>
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
<script>
async function testHealthRow(idx, endpoint, method) {
    const latCell = document.getElementById('latency-cell-' + idx);
    const codeCell = document.getElementById('status-code-' + idx);
    const gradeCell = document.getElementById('grade-cell-' + idx);

    if (codeCell) codeCell.innerHTML = '<span class="dev-status dev-status-warning">Testing...</span>';

    try {
        const res = await DevStudio.post('api_ping', { endpoint, method });
        if (res.status === 'success' && res.ping) {
            const p = res.ping;
            const lat = p.latency_ms;
            const latPercent = Math.min(100, Math.max(10, Math.round(lat / 3)));
            const latClass = lat < 120 ? 'dev-latency-fast' : (lat < 300 ? 'dev-latency-moderate' : 'dev-latency-slow');
            const latColor = lat < 120 ? '#15803D' : (lat < 300 ? '#D97706' : '#DC2626');

            if (codeCell) codeCell.innerHTML = `<span class="dev-status dev-status-success">${p.status_code} OK</span>`;
            if (latCell) {
                latCell.innerHTML = `
                    <div class="dev-latency-bar-wrap">
                        <div class="dev-latency-bar ${latClass}" style="width: ${latPercent}%;"></div>
                    </div>
                    <span style="font-weight:700; color:${latColor}; font-size:0.84rem;">${lat}ms</span>
                `;
            }
            if (gradeCell) {
                gradeCell.innerHTML = `<span class="dev-status dev-status-success">${lat < 120 ? 'Healthy' : (lat < 300 ? 'Moderate' : 'Degraded')}</span>`;
            }
            DevStudio.toast(`Tested ${endpoint}: ${lat}ms (${p.status_code})`, 'success');
        } else {
            if (codeCell) codeCell.innerHTML = '<span class="dev-status dev-status-danger">Failed</span>';
            DevStudio.toast('Ping test failed', 'error');
        }
    } catch (e) {
        if (codeCell) codeCell.innerHTML = '<span class="dev-status dev-status-danger">Offline</span>';
        DevStudio.toast('Network error during test', 'error');
    }
}
</script>
</body>
</html>
