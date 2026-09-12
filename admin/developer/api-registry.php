<?php
declare(strict_types=1);
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/developer/api-registry.php — API Catalog & Playground
 * DT Brand's & Jai Hanuman Tex — Section 37
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/DeveloperManager.php';

use DTBrand\Database;
use DTBrand\DeveloperManager;

$dev = DeveloperManager::getInstance();
$registry = $dev->getApiRegistry();

$active_nav = 'developer';
$active_subnav = 'registry';
$page_title = 'API Registry & Catalog — DT Brand\'s Developer Studio';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="DT Brand's API Registry — complete catalog of all API endpoints, parameters, live test runner, and cURL snippets.">
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
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                            <span>API Registry &amp; Interactive Playground</span>
                            <span class="dev-badge-gold"><?= count($registry) ?> Endpoints Documented</span>
                        </h1>
                        <p>Centralized specification for all REST API endpoints, parameter schemas, authorization guards, and live testing.</p>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <a href="/admin/developer/api-health.php" class="dt-btn-gold">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                            Latency Monitor
                        </a>
                    </div>
                </div>

                <!-- Subnav Tabs -->
                <div class="dev-subnav">
                    <a href="/admin/developer/index.php" class="dev-tab">Overview</a>
                    <a href="/admin/developer/api-registry.php" class="dev-tab active">API Registry (<?= count($registry) ?>)</a>
                    <a href="/admin/developer/api-health.php" class="dev-tab">API Health &amp; Latency</a>
                    <a href="/admin/developer/webhooks.php" class="dev-tab">Webhook Events</a>
                    <a href="/admin/developer/queue.php" class="dev-tab">Queue / Jobs</a>
                    <a href="/admin/developer/routes.php" class="dev-tab">Route Map</a>
                    <a href="/admin/developer/migrations.php" class="dev-tab">Migrations</a>
                    <a href="/admin/developer/diagnostics.php" class="dev-tab">Diagnostics</a>
                </div>

                <!-- Controls & Search -->
                <div class="dev-card" style="padding:16px 20px; margin-bottom:20px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                        <div style="flex:1; min-width:280px; max-width:480px; position:relative;">
                            <input type="text" id="apiSearchInput" class="dev-input" placeholder="Search by endpoint name, path, category, or parameter..." style="padding-left:36px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2.2" style="position:absolute; left:12px; top:50%; transform:translateY(-50%);">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <span class="dev-status dev-status-info">Auth: Session / Bearer</span>
                            <span class="dev-status dev-status-success">Format: JSON</span>
                            <span class="dev-status dev-status-warning">Base: https://jaihanumantex.in</span>
                        </div>
                    </div>
                </div>

                <!-- API Registry Table -->
                <div class="dev-card">
                    <div class="dev-table-wrapper">
                        <table class="dev-table" id="apiRegistryTable">
                            <thead>
                                <tr>
                                    <th>Method</th>
                                    <th>Endpoint &amp; Name</th>
                                    <th>Category</th>
                                    <th>Auth Required</th>
                                    <th>Rate Limit</th>
                                    <th>Status</th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($registry as $key => $api):
                                    $i++;
                                    $targetId = 'reg-ping-' . $i;
                                    $methods = $api['methods'] ?? ['GET'];
                                    $primaryMethod = $methods[0];
                                ?>
                                <tr>
                                    <td>
                                        <?php foreach ($methods as $m): ?>
                                            <span class="dev-method dev-method-<?= strtolower($m) ?>"><?= htmlspecialchars($m) ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <div style="font-weight:700; color:#111827; font-size:0.92rem;"><?= htmlspecialchars($api['name']) ?></div>
                                        <div class="dev-endpoint-code" style="margin-top:4px;"><?= htmlspecialchars($api['endpoint']) ?></div>
                                        <div style="font-size:0.76rem; color:#64748B; margin-top:4px; max-width:450px;">
                                            <?= htmlspecialchars($api['description']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="dev-badge-gold" style="font-size:0.72rem;"><?= htmlspecialchars($api['category']) ?></span>
                                    </td>
                                    <td>
                                        <span style="font-weight:600; font-size:0.8rem; color:#1F2937;">
                                            <?= htmlspecialchars($api['auth']) ?>
                                        </span>
                                        <?php if ($api['csrf'] ?? false): ?>
                                            <div style="font-size:0.7rem; color:#B45309; font-weight:700;">CSRF Required</div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span style="font-family:monospace; font-size:0.8rem; color:#64748B;">
                                            <?= htmlspecialchars($api['rate_limit']) ?>
                                        </span>
                                    </td>
                                    <td id="<?= $targetId ?>">
                                        <span class="dev-status dev-status-success"><?= htmlspecialchars($api['status']) ?></span>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <button class="dt-btn-pale" title="Copy cURL Command" onclick="DevStudio.copyCurl('<?= htmlspecialchars($key) ?>')">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                                cURL
                                            </button>
                                            <button class="dt-btn-pale" title="Ping Endpoint" onclick="DevStudio.pingEndpoint('<?= htmlspecialchars($api['endpoint']) ?>', '<?= htmlspecialchars($primaryMethod) ?>', '<?= $targetId ?>')">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                                Ping
                                            </button>
                                            <button class="dt-btn-pale" title="View Schema &amp; Params" onclick="DevStudio.showPayloadModal('<?= htmlspecialchars($api['name']) ?> Specification', <?= htmlspecialchars(json_encode($api)) ?>)">
                                                Spec
                                            </button>
                                        </div>
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
document.addEventListener('DOMContentLoaded', function () {
    DevStudio.setupFilter('apiSearchInput', 'apiRegistryTable');
});
</script>
</body>
</html>
