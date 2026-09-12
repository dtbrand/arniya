<?php
declare(strict_types=1);
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/developer/webhooks.php — Inbound & Outbound Webhook Ledger & Sandbox
 * DT Brand's & Jai Hanuman Tex — Section 37
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/DeveloperManager.php';

use DTBrand\Database;
use DTBrand\DeveloperManager;

$dev = DeveloperManager::getInstance();
$filterStatus = $_GET['status'] ?? 'all';
$filterGateway = $_GET['gateway'] ?? 'all';
$filterDirection = $_GET['direction'] ?? 'all';

$webhooks = $dev->getWebhookEvents([
    'status' => $filterStatus,
    'gateway' => $filterGateway,
    'direction' => $filterDirection
]);

$allWebhooks = $dev->getWebhookEvents();
$deliveredCount = count(array_filter($allWebhooks, fn($w) => ($w['status'] ?? '') === 'delivered'));
$failedCount = count(array_filter($allWebhooks, fn($w) => ($w['status'] ?? '') === 'failed'));
$totalCount = count($allWebhooks);
$successRate = $totalCount > 0 ? (int)round(($deliveredCount / $totalCount) * 100) : 100;

$active_nav = 'developer';
$active_subnav = 'webhooks';
$page_title = 'Webhook Events & Deliveries — DT Brand\'s Developer Studio';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="DT Brand's Webhook Ledger — inbound and outbound event deliveries, payload inspector, redelivery, and HMAC testing.">
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
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <span>Webhook Events &amp; Delivery Ledger</span>
                            <span class="dev-badge-gold"><?= $totalCount ?> Total Events</span>
                        </h1>
                        <p>Forensic ledger of all inbound gateway callbacks (Razorpay, Cashfree, WhatsApp) and outbound dispatch integrations.</p>
                    </div>
                </div>

                <!-- Subnav Tabs -->
                <div class="dev-subnav">
                    <a href="/admin/developer/index.php" class="dev-tab">Overview</a>
                    <a href="/admin/developer/api-registry.php" class="dev-tab">API Registry</a>
                    <a href="/admin/developer/api-health.php" class="dev-tab">API Health &amp; Latency</a>
                    <a href="/admin/developer/webhooks.php" class="dev-tab active">Webhook Events (<?= $totalCount ?>)</a>
                    <a href="/admin/developer/queue.php" class="dev-tab">Queue / Jobs</a>
                    <a href="/admin/developer/routes.php" class="dev-tab">Route Map</a>
                    <a href="/admin/developer/migrations.php" class="dev-tab">Migrations</a>
                    <a href="/admin/developer/diagnostics.php" class="dev-tab">Diagnostics</a>
                </div>

                <!-- KPI Ribbon -->
                <div class="dev-kpi-grid">
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Delivery Success Rate</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:#15803D;"><?= $successRate ?>%</div>
                        <div class="dev-kpi-sub"><?= $deliveredCount ?> successful deliveries</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Failed / Retrying</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:<?= $failedCount > 0 ? '#DC2626' : '#15803D' ?>;"><?= $failedCount ?></div>
                        <div class="dev-kpi-sub">Auto-retry exponential backoff</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>Active Gateways</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        </div>
                        <div class="dev-kpi-value">4</div>
                        <div class="dev-kpi-sub">Razorpay, Cashfree, WhatsApp, Shiprocket</div>
                    </div>
                    <div class="dev-kpi-card">
                        <div class="dev-kpi-label">
                            <span>HMAC Security</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <div class="dev-kpi-value" style="color:#15803D; font-size:1.4rem;">SHA-256</div>
                        <div class="dev-kpi-sub">Constant-time hash_equals verified</div>
                    </div>
                </div>

                <!-- Filters & Controls -->
                <div class="dev-card" style="padding:16px 20px; margin-bottom:20px;">
                    <form method="GET" action="/admin/developer/webhooks.php" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                        <div style="display:flex; gap:10px; flex-wrap:wrap;">
                            <select name="status" class="dev-input" style="width:auto;" onchange="this.form.submit()">
                                <option value="all" <?= $filterStatus === 'all' ? 'selected' : '' ?>>All Statuses</option>
                                <option value="delivered" <?= $filterStatus === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="failed" <?= $filterStatus === 'failed' ? 'selected' : '' ?>>Failed</option>
                                <option value="pending" <?= $filterStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
                            </select>

                            <select name="gateway" class="dev-input" style="width:auto;" onchange="this.form.submit()">
                                <option value="all" <?= $filterGateway === 'all' ? 'selected' : '' ?>>All Gateways</option>
                                <option value="razorpay" <?= $filterGateway === 'razorpay' ? 'selected' : '' ?>>Razorpay</option>
                                <option value="cashfree" <?= $filterGateway === 'cashfree' ? 'selected' : '' ?>>Cashfree</option>
                                <option value="whatsapp" <?= $filterGateway === 'whatsapp' ? 'selected' : '' ?>>WhatsApp</option>
                                <option value="shiprocket" <?= $filterGateway === 'shiprocket' ? 'selected' : '' ?>>Shiprocket</option>
                            </select>

                            <select name="direction" class="dev-input" style="width:auto;" onchange="this.form.submit()">
                                <option value="all" <?= $filterDirection === 'all' ? 'selected' : '' ?>>All Directions</option>
                                <option value="inbound" <?= $filterDirection === 'inbound' ? 'selected' : '' ?>>Inbound</option>
                                <option value="outbound" <?= $filterDirection === 'outbound' ? 'selected' : '' ?>>Outbound</option>
                            </select>
                        </div>
                        <div>
                            <button type="button" class="dt-btn-pale" onclick="document.getElementById('hmacSandboxCard').scrollIntoView({behavior:'smooth'})">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                HMAC Signature Tool
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Webhooks Table -->
                <div class="dev-card">
                    <div class="dev-table-wrapper">
                        <table class="dev-table">
                            <thead>
                                <tr>
                                    <th>Event ID &amp; Type</th>
                                    <th>Direction</th>
                                    <th>Gateway</th>
                                    <th>HTTP Code</th>
                                    <th>Status</th>
                                    <th>Attempts</th>
                                    <th>Timestamp</th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($webhooks)): ?>
                                <tr>
                                    <td colspan="8" style="text-align:center; padding:30px; color:#64748B;">No webhook records matching the selected filter.</td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($webhooks as $wh):
                                        $isDelivered = ($wh['status'] ?? '') === 'delivered';
                                        $isInbound = ($wh['direction'] ?? '') === 'inbound';
                                    ?>
                                    <tr id="wh-row-<?= htmlspecialchars($wh['event_id']) ?>">
                                        <td>
                                            <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($wh['event_type']) ?></div>
                                            <div class="dev-endpoint-code" style="margin-top:4px;"><?= htmlspecialchars($wh['event_id']) ?></div>
                                        </td>
                                        <td>
                                            <span class="dev-status <?= $isInbound ? 'dev-status-info' : 'dev-status-warning' ?>" style="font-size:0.7rem;">
                                                <?= strtoupper($wh['direction'] ?? 'inbound') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="dev-badge-gold" style="font-size:0.72rem;"><?= htmlspecialchars(strtoupper($wh['source_gateway'])) ?></span>
                                        </td>
                                        <td>
                                            <span style="font-weight:700; font-family:monospace; color:<?= $wh['http_status'] == 200 ? '#15803D' : '#DC2626' ?>;">
                                                <?= htmlspecialchars((string)($wh['http_status'] ?? '—')) ?>
                                            </span>
                                        </td>
                                        <td class="wh-status-cell">
                                            <span class="dev-status <?= $isDelivered ? 'dev-status-success' : 'dev-status-danger' ?>">
                                                <?= htmlspecialchars($wh['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span style="font-size:0.8rem; color:#64748B;"><?= $wh['attempts'] ?> / <?= $wh['max_attempts'] ?></span>
                                        </td>
                                        <td>
                                            <span style="font-size:0.78rem; color:#64748B;"><?= htmlspecialchars($wh['created_at']) ?></span>
                                        </td>
                                        <td style="text-align:right;">
                                            <div style="display:inline-flex; gap:6px;">
                                                <button class="dt-btn-pale" onclick="DevStudio.showPayloadModal('Webhook <?= htmlspecialchars($wh['event_id']) ?> Payload', <?= htmlspecialchars(json_encode($wh['payload_json'])) ?>)">
                                                    Payload
                                                </button>
                                                <?php if (!$isDelivered): ?>
                                                    <button class="dt-btn-gold" style="padding:4px 10px; font-size:0.75rem;" onclick="DevStudio.retryWebhook('<?= htmlspecialchars($wh['event_id']) ?>', this)">
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

                <!-- Interactive HMAC Signature Verification Tool -->
                <div class="dev-card" id="hmacSandboxCard">
                    <div class="dev-card-header">
                        <h2>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>HMAC-SHA256 Signature Verification Simulator</span>
                        </h2>
                        <span class="dev-status dev-status-success">Real-Time Cryptographic Engine</span>
                    </div>
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:20px;">
                        <div>
                            <div style="margin-bottom:14px;">
                                <label style="display:block; font-size:0.8rem; font-weight:700; color:#1F2937; margin-bottom:6px;">Gateway Provider</label>
                                <select id="hmacGateway" class="dev-input">
                                    <option value="razorpay">Razorpay (Hex Digest &bull; X-Razorpay-Signature)</option>
                                    <option value="cashfree">Cashfree (Base64 Encoded &bull; x-webhook-signature)</option>
                                    <option value="whatsapp">WhatsApp Cloud API (sha256=... &bull; X-Hub-Signature-256)</option>
                                    <option value="custom">Standard Webhook (Hex Digest)</option>
                                </select>
                            </div>
                            <div style="margin-bottom:14px;">
                                <label style="display:block; font-size:0.8rem; font-weight:700; color:#1F2937; margin-bottom:6px;">Webhook Secret Key</label>
                                <input type="text" id="hmacSecret" class="dev-input" value="dtbrand_webhook_secret_key_2026" placeholder="Enter webhook signing secret">
                            </div>
                            <div style="margin-bottom:14px;">
                                <label style="display:block; font-size:0.8rem; font-weight:700; color:#1F2937; margin-bottom:6px;">Raw JSON Payload</label>
                                <textarea id="hmacPayload" class="dev-input" rows="5" style="font-family:monospace; font-size:0.8rem;">{"event":"payment.captured","order_id":"JH-2026-9021","amount":6200.00}</textarea>
                            </div>
                            <button class="dt-btn-gold" onclick="calculateHmac()">Generate Signature</button>
                        </div>
                        <div>
                            <label style="display:block; font-size:0.8rem; font-weight:700; color:#1F2937; margin-bottom:6px;">Computed Header &amp; Verification</label>
                            <div class="dev-terminal" style="min-height:200px;">
                                <div class="dev-terminal-header">
                                    <div class="dev-terminal-dots">
                                        <div class="dev-terminal-dot dot-red"></div>
                                        <div class="dev-terminal-dot dot-yellow"></div>
                                        <div class="dev-terminal-dot dot-green"></div>
                                    </div>
                                    <span style="font-size:0.72rem; color:#94A3B8;">HMAC Inspector</span>
                                </div>
                                <pre id="hmacOutput">// Click 'Generate Signature' to calculate cryptographic digest.</pre>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/developer/developer.js?v=<?= time() ?>"></script>
<script>
async function calculateHmac() {
    const gateway = document.getElementById('hmacGateway').value;
    const secret = document.getElementById('hmacSecret').value;
    const payload = document.getElementById('hmacPayload').value;
    const out = document.getElementById('hmacOutput');

    out.textContent = 'Calculating signature...';
    try {
        const res = await DevStudio.post('hmac_test', { gateway, secret, payload });
        if (res.status === 'success' && res.data) {
            const d = res.data;
            out.textContent = [
                `// Gateway: ${d.gateway.toUpperCase()}`,
                `// Algorithm: HMAC-${d.algorithm.toUpperCase()}`,
                `Calculated Digest: ${d.calculated_signature}`,
                `\nExpected Request Header:`,
                `${d.headers_format}`,
                `\nPHP Verification Logic:`,
                `hash_equals($computed, $_SERVER['${gateway === 'razorpay' ? 'HTTP_X_RAZORPAY_SIGNATURE' : (gateway === 'cashfree' ? 'HTTP_X_WEBHOOK_SIGNATURE' : 'HTTP_X_HUB_SIGNATURE_256')}']) === true`
            ].join('\n');
            DevStudio.toast('HMAC signature generated successfully', 'success');
        } else {
            out.textContent = '// Failed to calculate signature: ' + (res.message || 'Unknown');
        }
    } catch (e) {
        out.textContent = '// Request error calculating signature';
    }
}
</script>
</body>
</html>
