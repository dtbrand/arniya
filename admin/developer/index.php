<?php
declare(strict_types=1);
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/developer/index.php — Master Developer & API Console
 * DT Brand's & Jai Hanuman Tex — Section 37
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/DeveloperManager.php';

use DTBrand\Database;
use DTBrand\DeveloperManager;

$dev = DeveloperManager::getInstance();
$registry = $dev->getApiRegistry();
$health = $dev->getApiHealth();
$queueStats = $dev->getQueueStats();
$webhooks = $dev->getWebhookEvents();
$routes = $dev->getRouteMap();

$active_nav = 'developer';
$active_subnav = 'index';
$page_title = 'Developer & API Console — DT Brand\'s';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="DT Brand's Developer & API Studio — API registry, health latency monitor, webhooks, queue, route map, and diagnostics.">
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
                                <polyline points="16 18 22 12 16 6"></polyline>
                                <polyline points="8 6 2 12 8 18"></polyline>
                            </svg>
                            <span>Developer &amp; API Admin Suite</span>
                            <span class="dev-badge-gold">Production V2 &bull; Section 37</span>
                        </h1>
                        <p>Real-time API telemetry, endpoint catalog, webhook ledger, queue processing, route integrity, and diagnostics.</p>
                    </div>
                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        <a href="/admin/developer/api-registry.php" class="dt-btn-pale">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                            API Playground
                        </a>
                        <a href="/admin/developer/api-health.php" class="dt-btn-gold">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                            Live Health Check
                        </a>
                    </div>
                </div>

                <!-- Subnav Tabs -->
                <div class="dev-subnav">
                    <a href="/admin/developer/index.php" class="dev-tab active">Overview</a>
                    <a href="/admin/developer/api-registry.php" class="dev-tab">API Registry (<?= count($registry) ?>)</a>
                    <a href="/admin/developer/api-health.php" class="dev-tab">API Health &amp; Latency</a>
                    <a href="/admin/developer/webhooks.php" class="dev-tab">Webhook Events (<?= count($webhooks) ?>)</a>
                    <a href="/admin/developer/queue.php" class="dev-tab">Queue / Jobs (<?= $queueStats['pending'] ?> pending)</a>
                    <a href="/admin/developer/routes.php" class="dev-tab">Route Map (<?= count($routes) ?>)</a>
                    <a href="/admin/developer/migrations.php" class="dev-tab">Migrations</a>
                    <a href="/admin/developer/diagnostics.php" class="dev-tab">Diagnostics</a>
                </div>

                <!-- KPI Ribbon -->
                <div class="dev-kpi-grid">
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Total Endpoints</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
                        </div>
                        <div class="dev-kpi-value"><?= count($registry) ?></div>
                        <div class="dev-kpi-sub" style="color:#15803D;">100% Fully Documented</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>API Health Score</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:#15803D;"><?= $health['health_score'] ?>%</div>
                        <div class="dev-kpi-sub">Uptime: <?= htmlspecialchars($health['uptime_percent']) ?></div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Average Latency</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div class="dev-kpi-value"><?= $health['avg_latency_ms'] ?>ms</div>
                        <div class="dev-kpi-sub" style="color:#15803D;">Ultra-Fast Execution</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Background Queue</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        </div>
                        <div class="dev-kpi-value"><?= $queueStats['pending'] ?></div>
                        <div class="dev-kpi-sub"><?= $queueStats['completed'] ?> processed, <?= $queueStats['failed'] ?> failed</div>
                    </div>
                </div>

                <!-- Two-Column Grid: Quick Ping & Webhooks Overview -->
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(420px, 1fr)); gap:24px; margin-bottom:24px;">
                    <!-- Core Endpoints Quick Ping -->
                    <div class="dev-card" style="margin-bottom:0;">
                        <div class="dev-card-header">
                            <h2>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <span>Core Endpoint Status</span>
                            </h2>
                            <a href="/admin/developer/api-health.php" class="dt-btn-pale" style="font-size:0.75rem;">Full Matrix</a>
                        </div>
                        <div class="dev-table-wrapper">
                            <table class="dev-table">
                                <thead>
                                    <tr>
                                        <th>Endpoint</th>
                                        <th>Method</th>
                                        <th>Ping Latency</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $quickList = array_slice($health['endpoints'], 0, 5);
                                    foreach ($quickList as $idx => $ep):
                                        $targetId = 'quick-ping-' . $idx;
                                    ?>
                                    <tr>
                                        <td>
                                            <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($ep['name']) ?></div>
                                            <div class="dev-endpoint-code" style="margin-top:4px;"><?= htmlspecialchars($ep['endpoint']) ?></div>
                                        </td>
                                        <td><span class="dev-method dev-method-<?= strtolower($ep['method']) ?>"><?= htmlspecialchars($ep['method']) ?></span></td>
                                        <td id="<?= $targetId ?>">
                                            <span class="dev-status dev-status-success"><?= $ep['status_code'] ?> OK</span>
                                            <span style="font-weight:700; margin-left:6px; color:#15803D;"><?= $ep['latency_ms'] ?>ms</span>
                                        </td>
                                        <td>
                                            <button class="dt-btn-pale" onclick="DevStudio.pingEndpoint('<?= htmlspecialchars($ep['endpoint']) ?>', '<?= htmlspecialchars($ep['method']) ?>', '<?= $targetId ?>')">
                                                Ping
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Webhook Events -->
                    <div class="dev-card" style="margin-bottom:0;">
                        <div class="dev-card-header">
                            <h2>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                <span>Recent Webhooks</span>
                            </h2>
                            <a href="/admin/developer/webhooks.php" class="dt-btn-pale" style="font-size:0.75rem;">View All</a>
                        </div>
                        <div class="dev-table-wrapper">
                            <table class="dev-table">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Gateway</th>
                                        <th>Status</th>
                                        <th>Payload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $recentWh = array_slice($webhooks, 0, 5);
                                    foreach ($recentWh as $wh):
                                        $isDelivered = ($wh['status'] ?? '') === 'delivered';
                                    ?>
                                    <tr id="wh-row-<?= htmlspecialchars($wh['event_id']) ?>">
                                        <td>
                                            <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($wh['event_type']) ?></div>
                                            <div style="font-size:0.72rem; color:#64748B;"><?= htmlspecialchars($wh['event_id']) ?></div>
                                        </td>
                                        <td>
                                            <span class="dev-status dev-status-info"><?= htmlspecialchars(strtoupper($wh['source_gateway'])) ?></span>
                                        </td>
                                        <td class="wh-status-cell">
                                            <span class="dev-status <?= $isDelivered ? 'dev-status-success' : 'dev-status-danger' ?>">
                                                <?= htmlspecialchars($wh['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="dt-btn-pale" onclick="DevStudio.showPayloadModal('Webhook <?= htmlspecialchars($wh['event_id']) ?>', <?= htmlspecialchars(json_encode($wh['payload_json'])) ?>)">
                                                Inspect
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quick Navigation Grid to Developer Tools -->
                <div class="dev-card">
                    <div class="dev-card-header">
                        <h2>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            <span>Developer Tools Directory</span>
                        </h2>
                    </div>
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
                        <a href="/admin/developer/api-registry.php" style="text-decoration:none; color:inherit; border:1px solid #E2E8F0; border-radius:10px; padding:18px; background:#F8FAFC; transition:all 0.2s;" onmouseover="this.style.borderColor='#D4AF37'; this.style.background='#FAF5E8';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC';">
                            <div style="display:flex; align-items:center; gap:10px; font-weight:700; color:#111827; font-size:1rem; margin-bottom:6px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                                <span>API Registry</span>
                            </div>
                            <p style="margin:0; font-size:0.8rem; color:#64748B;">Comprehensive API catalog, parameter schemas, live tester, and instant cURL snippets.</p>
                        </a>

                        <a href="/admin/developer/api-health.php" style="text-decoration:none; color:inherit; border:1px solid #E2E8F0; border-radius:10px; padding:18px; background:#F8FAFC; transition:all 0.2s;" onmouseover="this.style.borderColor='#D4AF37'; this.style.background='#FAF5E8';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC';">
                            <div style="display:flex; align-items:center; gap:10px; font-weight:700; color:#111827; font-size:1rem; margin-bottom:6px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                                <span>API Health &amp; Latency</span>
                            </div>
                            <p style="margin:0; font-size:0.8rem; color:#64748B;">Multi-point endpoint ping matrix, real-time response latency bars, and uptime metrics.</p>
                        </a>

                        <a href="/admin/developer/webhooks.php" style="text-decoration:none; color:inherit; border:1px solid #E2E8F0; border-radius:10px; padding:18px; background:#F8FAFC; transition:all 0.2s;" onmouseover="this.style.borderColor='#D4AF37'; this.style.background='#FAF5E8';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC';">
                            <div style="display:flex; align-items:center; gap:10px; font-weight:700; color:#111827; font-size:1rem; margin-bottom:6px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path></svg>
                                <span>Webhook Events</span>
                            </div>
                            <p style="margin:0; font-size:0.8rem; color:#64748B;">Inbound/outbound webhook delivery logs, payload inspection, 1-click redelivery &amp; HMAC tester.</p>
                        </a>

                        <a href="/admin/developer/queue.php" style="text-decoration:none; color:inherit; border:1px solid #E2E8F0; border-radius:10px; padding:18px; background:#F8FAFC; transition:all 0.2s;" onmouseover="this.style.borderColor='#D4AF37'; this.style.background='#FAF5E8';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC';">
                            <div style="display:flex; align-items:center; gap:10px; font-weight:700; color:#111827; font-size:1rem; margin-bottom:6px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line></svg>
                                <span>Queue / Jobs</span>
                            </div>
                            <p style="margin:0; font-size:0.8rem; color:#64748B;">Background job processing studio, worker queue depth, failed job retry, and manual trigger.</p>
                        </a>

                        <a href="/admin/developer/routes.php" style="text-decoration:none; color:inherit; border:1px solid #E2E8F0; border-radius:10px; padding:18px; background:#F8FAFC; transition:all 0.2s;" onmouseover="this.style.borderColor='#D4AF37'; this.style.background='#FAF5E8';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC';">
                            <div style="display:flex; align-items:center; gap:10px; font-weight:700; color:#111827; font-size:1rem; margin-bottom:6px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                                <span>Route Map &amp; Audit</span>
                            </div>
                            <p style="margin:0; font-size:0.8rem; color:#64748B;">Section 38 &amp; 122 Route Integrity Audit — detect orphaned links, view templates, and permissions.</p>
                        </a>

                        <a href="/admin/developer/diagnostics.php" style="text-decoration:none; color:inherit; border:1px solid #E2E8F0; border-radius:10px; padding:18px; background:#F8FAFC; transition:all 0.2s;" onmouseover="this.style.borderColor='#D4AF37'; this.style.background='#FAF5E8';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC';">
                            <div style="display:flex; align-items:center; gap:10px; font-weight:700; color:#111827; font-size:1rem; margin-bottom:6px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                <span>System Diagnostics</span>
                            </div>
                            <p style="margin:0; font-size:0.8rem; color:#64748B;">Safe runtime inspection, opcode status, memory usage, database latency, and zero secrets leaked.</p>
                        </a>
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
