<?php
declare(strict_types=1);
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/developer/diagnostics.php — Safe Developer System Diagnostics & Performance Profiler
 * DT Brand's & Jai Hanuman Tex — Section 37
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/DeveloperManager.php';

use DTBrand\Database;
use DTBrand\DeveloperManager;

$dev = DeveloperManager::getInstance();
$diag = $dev->getDiagnostics();
$apiKeys = $dev->getApiKeys();

$active_nav = 'developer';
$active_subnav = 'diagnostics';
$page_title = 'System Diagnostics & API Keys — DT Brand\'s Developer Studio';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="DT Brand's Developer Diagnostics — runtime profiling, memory utilization, extension health, and API key management.">
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
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <span>Developer Diagnostics &amp; API Keys</span>
                            <span class="dev-badge-gold">Zero Secret Leakage</span>
                        </h1>
                        <p>Real-time runtime profiler, PHP engine parameters, and service account API key governance.</p>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <button class="dt-btn-gold" onclick="openCreateKeyModal()">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Generate API Key
                        </button>
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
                    <a href="/admin/developer/migrations.php" class="dev-tab">Migrations</a>
                    <a href="/admin/developer/diagnostics.php" class="dev-tab active">Diagnostics</a>
                </div>

                <!-- KPI Ribbon -->
                <div class="dev-kpi-grid">
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>PHP Runtime</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div class="dev-kpi-value" style="font-size:1.4rem;"><?= htmlspecialchars($diag['php_version']) ?></div>
                        <div class="dev-kpi-sub"><?= htmlspecialchars($diag['server_os']) ?></div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Memory Profiler</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:#15803D;"><?= htmlspecialchars($diag['memory_current']) ?></div>
                        <div class="dev-kpi-sub">Peak: <?= htmlspecialchars($diag['memory_peak']) ?> / Limit: <?= htmlspecialchars($diag['memory_limit']) ?></div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>DB Ping Latency</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:#15803D;"><?= $diag['database_latency_ms'] ?>ms</div>
                        <div class="dev-kpi-sub"><?= htmlspecialchars($diag['database_status']) ?></div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>OPcache Accelerator</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.2"><path d="M12 2v4"></path><path d="M12 18v4"></path></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:<?= $diag['opcache_enabled'] ? '#15803D' : '#D97706' ?>; font-size:1.35rem;">
                            <?= $diag['opcache_enabled'] ? 'ACTIVE' : 'OFFLINE' ?>
                        </div>
                        <div class="dev-kpi-sub">Bytecode Caching</div>
                    </div>
                </div>

                <!-- Two-Column Grid: Extensions & Sanitized Environment -->
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(360px, 1fr)); gap:24px; margin-bottom:24px;">
                    <!-- Extensions Checklist -->
                    <div class="dev-card" style="margin-bottom:0;">
                        <div class="dev-card-header">
                            <h2>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                                <span>Core PHP Extensions</span>
                            </h2>
                        </div>
                        <div class="dev-table-wrapper">
                            <table class="dev-table">
                                <thead>
                                    <tr>
                                        <th>Extension</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $roles = [
                                        'pdo_mysql' => 'Relational MySQL Database Driver',
                                        'curl' => 'HTTP Client & Payment Gateways',
                                        'mbstring' => 'Multibyte UTF-8 & Hinglish String Processor',
                                        'openssl' => 'TLS/SSL & Cryptographic HMAC Verification',
                                        'json' => 'JSON Parser & REST API Serialization',
                                        'gd' => 'Dynamic Image Watermarking & Resizing',
                                        'opcache' => 'Precompiled Bytecode Memory Execution',
                                        'zip' => 'Database Backup Zip Compression'
                                    ];
                                    foreach ($diag['extensions'] as $ext => $loaded):
                                    ?>
                                    <tr>
                                        <td><span class="dev-endpoint-code"><?= htmlspecialchars($ext) ?></span></td>
                                        <td style="font-size:0.78rem; color:#64748B;"><?= htmlspecialchars($roles[$ext] ?? 'Core Component') ?></td>
                                        <td>
                                            <?php if ($loaded): ?>
                                                <span class="dev-status dev-status-success">LOADED</span>
                                            <?php else: ?>
                                                <span class="dev-status dev-status-danger">MISSING</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Sanitized Environment Variables -->
                    <div class="dev-card" style="margin-bottom:0;">
                        <div class="dev-card-header">
                            <h2>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                <span>Sanitized Configuration Variables</span>
                            </h2>
                            <span class="dev-status dev-status-success">Credentials Masked</span>
                        </div>
                        <div class="dev-terminal">
                            <div class="dev-terminal-header">
                                <div class="dev-terminal-dots">
                                    <div class="dev-terminal-dot dot-red"></div>
                                    <div class="dev-terminal-dot dot-yellow"></div>
                                    <div class="dev-terminal-dot dot-green"></div>
                                </div>
                                <span style="font-size:0.72rem; color:#94A3B8;">Environment Safe Dump</span>
                            </div>
                            <pre><?php
                            foreach ($diag['sanitized_env'] as $key => $val) {
                                echo htmlspecialchars("{$key} = {$val}\n");
                            }
                            ?></pre>
                        </div>
                    </div>
                </div>

                <!-- Developer API Keys Studio -->
                <div class="dev-card">
                    <div class="dev-card-header">
                        <h2>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <span>Developer API Keys &amp; Service Tokens</span>
                        </h2>
                        <button class="dt-btn-pale" onclick="openCreateKeyModal()">+ Create New Key</button>
                    </div>
                    <div class="dev-table-wrapper">
                        <table class="dev-table">
                            <thead>
                                <tr>
                                    <th>Key Prefix</th>
                                    <th>Name</th>
                                    <th>Role &amp; Scopes</th>
                                    <th>Rate Limit</th>
                                    <th>Last Used</th>
                                    <th>Status</th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($apiKeys)): ?>
                                <tr>
                                    <td colspan="7" style="text-align:center; padding:30px; color:#64748B;">No developer API keys registered. Click '+ Create New Key' to generate one.</td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($apiKeys as $k):
                                        $active = (int)($k['is_active'] ?? 1) === 1;
                                    ?>
                                    <tr id="key-row-<?= $k['id'] ?>">
                                        <td>
                                            <span class="dev-endpoint-code" style="font-weight:700;"><?= htmlspecialchars($k['key_prefix']) ?>••••</span>
                                        </td>
                                        <td>
                                            <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($k['name']) ?></div>
                                            <div style="font-size:0.75rem; color:#64748B;">Created <?= htmlspecialchars($k['created_at']) ?></div>
                                        </td>
                                        <td>
                                            <span class="dev-badge-gold" style="font-size:0.72rem;"><?= htmlspecialchars($k['role']) ?></span>
                                            <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">
                                                <?= htmlspecialchars((string)($k['scopes_json'] ?? '[]')) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="font-family:monospace; font-size:0.8rem;"><?= $k['rate_limit_rpm'] ?> req/min</span>
                                        </td>
                                        <td>
                                            <span style="font-size:0.78rem; color:#64748B;"><?= htmlspecialchars($k['last_used_at'] ?? 'Never') ?></span>
                                        </td>
                                        <td>
                                            <span class="dev-status <?= $active ? 'dev-status-success' : 'dev-status-danger' ?>">
                                                <?= $active ? 'Active' : 'Revoked' ?>
                                            </span>
                                        </td>
                                        <td style="text-align:right;">
                                            <?php if ($active): ?>
                                                <button class="dt-btn-pale" style="border-color:#DC2626; color:#DC2626; padding:4px 10px; font-size:0.75rem;" onclick="revokeKey(<?= $k['id'] ?>, this)">
                                                    Revoke
                                                </button>
                                            <?php else: ?>
                                                <span style="font-size:0.75rem; color:#64748B;">Revoked</span>
                                            <?php endif; ?>
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

<!-- Modal: Generate API Key -->
<div class="dev-modal-overlay" id="createKeyModal">
    <div class="dev-modal">
        <div class="dev-modal-header">
            <h3>Generate Developer API Key</h3>
            <button class="dev-modal-close" onclick="closeCreateKeyModal()">&times;</button>
        </div>
        <div id="createKeyFormView">
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:0.8rem; font-weight:700; color:#1F2937; margin-bottom:6px;">Service Account / Integration Name</label>
                <input type="text" id="newKeyName" class="dev-input" placeholder="e.g. Surat Warehouse POS / Mobile App Backend">
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:0.8rem; font-weight:700; color:#1F2937; margin-bottom:6px;">Role Tier</label>
                <select id="newKeyRole" class="dev-input">
                    <option value="read_only">Read-Only Integrator (Catalog &amp; Inventory)</option>
                    <option value="orders_manager">Orders Manager (Create &amp; Track Orders)</option>
                    <option value="full_access">Full Access API Key</option>
                </select>
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:0.8rem; font-weight:700; color:#1F2937; margin-bottom:6px;">Rate Limit (RPM)</label>
                <input type="number" id="newKeyRpm" class="dev-input" value="120" min="30" max="1200">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                <button class="dt-btn-pale" onclick="closeCreateKeyModal()">Cancel</button>
                <button class="dt-btn-gold" id="btnSubmitKey" onclick="submitCreateKey()">Generate Key</button>
            </div>
        </div>

        <div id="createKeyResultView" style="display:none;">
            <div style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D; padding:12px 16px; border-radius:8px; font-weight:700; font-size:0.85rem; margin-bottom:16px;">
                API Key Successfully Created!
            </div>
            <p style="font-size:0.82rem; color:#1F2937; margin-bottom:8px;">
                <strong>IMPORTANT:</strong> Copy and store this plaintext API key now. It will NEVER be displayed again in full.
            </p>
            <div class="dev-terminal" style="margin-bottom:16px;">
                <pre id="newKeyPlaintext"></pre>
            </div>
            <div style="display:flex; justify-content:flex-end;">
                <button class="dt-btn-gold" onclick="window.location.reload()">Done &bull; Reload Studio</button>
            </div>
        </div>
    </div>
</div>

<script src="/admin/developer/developer.js?v=<?= time() ?>"></script>
<script>
function openCreateKeyModal() {
    document.getElementById('createKeyModal').classList.add('active');
    document.getElementById('createKeyFormView').style.display = 'block';
    document.getElementById('createKeyResultView').style.display = 'none';
}

function closeCreateKeyModal() {
    document.getElementById('createKeyModal').classList.remove('active');
}

async function submitCreateKey() {
    const name = document.getElementById('newKeyName').value.trim();
    const role = document.getElementById('newKeyRole').value;
    const rate_limit = document.getElementById('newKeyRpm').value;
    const btn = document.getElementById('btnSubmitKey');

    if (!name) {
        DevStudio.toast('Please enter an integration name', 'error');
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Generating...';

    try {
        const res = await DevStudio.post('api_key_create', { name, role, rate_limit });
        if (res.status === 'success' && res.data) {
            document.getElementById('createKeyFormView').style.display = 'none';
            document.getElementById('createKeyResultView').style.display = 'block';
            document.getElementById('newKeyPlaintext').textContent = res.data.plain_token;
            DevStudio.toast('API Key generated successfully', 'success');
        } else {
            DevStudio.toast(res.message || 'Key generation failed', 'error');
            btn.disabled = false;
            btn.textContent = 'Generate Key';
        }
    } catch (e) {
        DevStudio.toast('Network error during key generation', 'error');
        btn.disabled = false;
        btn.textContent = 'Generate Key';
    }
}

async function revokeKey(id, btn) {
    if (!confirm('Are you sure you want to permanently revoke this API key? Applications using it will lose access immediately.')) {
        return;
    }

    if (btn) btn.disabled = true;
    try {
        const res = await DevStudio.post('api_key_revoke', { id });
        if (res.status === 'success') {
            DevStudio.toast('API key revoked successfully', 'success');
            const row = document.getElementById('key-row-' + id);
            if (row) {
                row.querySelector('.dev-status').className = 'dev-status dev-status-danger';
                row.querySelector('.dev-status').textContent = 'Revoked';
                btn.style.display = 'none';
            }
        } else {
            DevStudio.toast(res.message || 'Revocation failed', 'error');
            if (btn) btn.disabled = false;
        }
    } catch (e) {
        DevStudio.toast('Network error revoking key', 'error');
        if (btn) btn.disabled = false;
    }
}
</script>
</body>
</html>
