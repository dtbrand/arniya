<?php
/* DT admin access guard (auto-inserted with dual relative fallback) */
$__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = __DIR__ . '/../includes/adminguard.php';
    if (!is_file($__dtg)) {
        $__dtg = dirname(__DIR__, 2) . '/admin/includes/adminguard.php';
    }
}
if (is_file($__dtg)) require_once $__dtg;

/**
 * webhooks.php — Webhook Events & Replay Deduplication Auditor
 * Section 28 (Payment Admin)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\Database;
use DTBrand\PaymentManager;

$page_title = "Webhook Events & Replay Auditor";
$active_nav = "payments";
$active_subnav = "webhooks";

$pdo = Database::getConnection();

$webhooks = [];
$totalEvents = 0;
$processedCount = 0;
$replayIgnoredCount = 0;
$failedCount = 0;

$filterGateway = trim((string)($_GET['gateway'] ?? ''));
$filterStatus = trim((string)($_GET['status'] ?? ''));
$searchQuery = trim((string)($_GET['q'] ?? ''));

if ($pdo !== null && !Database::isMockMode()) {
    try {
        // Compute Summary Metrics
        $metricStmt = $pdo->query("
            SELECT 
                COUNT(*) as total_events,
                SUM(CASE WHEN `status` = 'PROCESSED' THEN 1 ELSE 0 END) as processed_cnt,
                SUM(CASE WHEN `status` = 'REPLAY_IGNORED' THEN 1 ELSE 0 END) as replay_cnt,
                SUM(CASE WHEN `status` = 'FAILED' THEN 1 ELSE 0 END) as failed_cnt
            FROM `payment_webhooks`
        ");
        $metrics = $metricStmt->fetch(PDO::FETCH_ASSOC) ?: [];
        $totalEvents = (int)($metrics['total_events'] ?? 0);
        $processedCount = (int)($metrics['processed_cnt'] ?? 0);
        $replayIgnoredCount = (int)($metrics['replay_cnt'] ?? 0);
        $failedCount = (int)($metrics['failed_cnt'] ?? 0);

        // Filtered List
        $where = [];
        $params = [];

        if (!empty($filterGateway)) {
            $where[] = "`gateway` = :gw";
            $params[':gw'] = $filterGateway;
        }
        if (!empty($filterStatus)) {
            $where[] = "`status` = :st";
            $params[':st'] = $filterStatus;
        }
        if (!empty($searchQuery)) {
            $where[] = "(`event_id` LIKE :q OR `event_type` LIKE :q OR `ip_address` LIKE :q OR `payload_json` LIKE :q)";
            $params[':q'] = "%{$searchQuery}%";
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
        $stmt = $pdo->prepare("SELECT * FROM `payment_webhooks` {$whereClause} ORDER BY `id` DESC LIMIT 100");
        $stmt->execute($params);
        $webhooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (\Throwable $e) {
        error_log("Webhook auditor query error: " . $e->getMessage());
    }
}

$rupeeSvg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webhook Events &amp; Replay Auditor — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-filter-bar {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 18px;
            background: #FFFFFF;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid #E2E8F0;
        }
        .dt-filter-select, .dt-search-input {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #CBD5E1;
            background: #F8FAFC;
            font-size: 0.82rem;
            color: #1E293B;
            font-weight: 500;
        }
        .dt-search-input { flex: 1; min-width: 200px; }
        .dt-modal-bg {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(4px);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .dt-modal-bg.active { display: flex; }
        .dt-modal-card {
            background: #FFFFFF;
            border-radius: 12px;
            width: 100%;
            max-width: 650px;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
            border: 1.5px solid #D4AF37;
            box-shadow: 0 16px 40px rgba(0,0,0,0.25);
            overflow: hidden;
        }
        .dt-modal-body {
            padding: 16px;
            overflow-y: auto;
            background: #0F172A;
            color: #38BDF8;
            font-family: monospace;
            font-size: 0.78rem;
            line-height: 1.5;
            white-space: pre-wrap;
            word-break: break-all;
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Webhook Events &amp; Replay Auditor</span>
                        <span class="adm-badge gold"><?= $totalEvents ?> Events Logged</span>
                    </h1>
                    <p class="adm-page-subtitle">Server-to-server webhook telemetry, HMAC verification checks, and automated duplicate replay prevention.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/payments/" class="dt-btn dt-btn-pale" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; padding:6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Transactions Ledger</span>
                    </a>
                    <a href="/admin/payments/audit.php" class="dt-btn dt-btn-gold" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:800; padding:6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span>Security Audit</span>
                    </a>
                </div>
            </div>

            <!-- KPI Metric Ribbon -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total Webhooks</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $totalEvents ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">All Incoming Payloads</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Processed &amp; Captured</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:#15803D;"><?= $processedCount ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Single Stock Decrement Confirmed</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Replay Deduplicated</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1D4ED8" stroke-width="2.2"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:#1D4ED8;"><?= $replayIgnoredCount ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Duplicate Retries Skipped Safely</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Rejected / Invalid</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:<?= $failedCount > 0 ? '#DC2626' : '#15803D' ?>;"><?= $failedCount ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta down">Signature or Tamper Blocked</span>
                    </div>
                </div>
            </div>

            <!-- Filter Bar -->
            <form method="GET" class="dt-filter-bar">
                <input type="text" name="q" class="dt-search-input" placeholder="Search by Event ID, Type, IP, or Payload Order #..." value="<?= htmlspecialchars($searchQuery) ?>">
                
                <select name="gateway" class="dt-filter-select">
                    <option value="">All Gateways</option>
                    <option value="razorpay" <?= $filterGateway === 'razorpay' ? 'selected' : '' ?>>Razorpay</option>
                    <option value="cashfree" <?= $filterGateway === 'cashfree' ? 'selected' : '' ?>>Cashfree</option>
                </select>

                <select name="status" class="dt-filter-select">
                    <option value="">All Statuses</option>
                    <option value="PROCESSED" <?= $filterStatus === 'PROCESSED' ? 'selected' : '' ?>>PROCESSED</option>
                    <option value="REPLAY_IGNORED" <?= $filterStatus === 'REPLAY_IGNORED' ? 'selected' : '' ?>>REPLAY_IGNORED</option>
                    <option value="FAILED" <?= $filterStatus === 'FAILED' ? 'selected' : '' ?>>FAILED</option>
                </select>

                <button type="submit" class="dt-btn dt-btn-gold" style="padding:8px 16px; display:inline-flex; align-items:center; gap:6px; font-size:12.5px; font-weight:800;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <span>Filter</span>
                </button>
                <?php if (!empty($filterGateway) || !empty($filterStatus) || !empty($searchQuery)): ?>
                    <a href="/admin/payments/webhooks.php" class="dt-btn dt-btn-pale" style="text-decoration:none; padding:8px 14px; font-size:12px; font-weight:700;">Reset</a>
                <?php endif; ?>
            </form>

            <!-- Table Card -->
            <div class="adm-table-card">
                <div class="adm-table-toolbar">
                    <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; margin:0;">Incoming Webhook Event Stream</h3></div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Log ID</th>
                                <th>Gateway</th>
                                <th>Event ID</th>
                                <th>Event Type</th>
                                <th>IP Address</th>
                                <th>Status</th>
                                <th>Received At</th>
                                <th>Payload</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($webhooks)): ?>
                                <?php foreach ($webhooks as $wh): ?>
                                    <tr>
                                        <td>#<?= $wh['id'] ?></td>
                                        <td><span class="adm-badge blue"><?= strtoupper(htmlspecialchars($wh['gateway'])) ?></span></td>
                                        <td><code style="font-size:0.75rem; color:#8A681F; font-weight:700;"><?= htmlspecialchars($wh['event_id'] ?: 'N/A') ?></code></td>
                                        <td><strong><?= htmlspecialchars($wh['event_type']) ?></strong></td>
                                        <td><span style="font-size:0.75rem; color:#64748B; font-family:monospace;"><?= htmlspecialchars($wh['ip_address'] ?? '127.0.0.1') ?></span></td>
                                        <td>
                                            <?php 
                                            $stClass = 'gray';
                                            if ($wh['status'] === 'PROCESSED') $stClass = 'success';
                                            elseif ($wh['status'] === 'REPLAY_IGNORED') $stClass = 'blue';
                                            elseif ($wh['status'] === 'FAILED') $stClass = 'danger';
                                            ?>
                                            <span class="adm-badge <?= $stClass ?>"><?= htmlspecialchars($wh['status']) ?></span>
                                        </td>
                                        <td style="font-size:0.75rem; color:#64748B;"><?= date('d M Y, h:i:s A', strtotime($wh['processed_at'])) ?></td>
                                        <td>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px; padding:3px 8px; font-size:0.72rem;" onclick="viewPayloadModal(<?= htmlspecialchars(json_encode($wh), ENT_QUOTES, 'UTF-8') ?>)">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                                <span>Payload</span>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align:center; padding:35px; color:#64748B;">No webhook events recorded matching filters.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Modal: Raw Webhook Payload Viewer -->
<div class="dt-modal-bg" id="whModalBg" onclick="if(event.target===this)this.classList.remove('active');">
    <div class="dt-modal-card">
        <div style="padding:14px 18px; border-bottom:1px solid #E2E8F0; display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin:0; font-size:0.95rem; font-family:var(--adm-font-serif); color:#8A681F;" id="whModalTitle">Webhook Event Payload</h3>
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="border:none; padding:4px; display:inline-flex; align-items:center; justify-content:center; cursor:pointer;" onclick="document.getElementById('whModalBg').classList.remove('active')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="dt-modal-body" id="whModalContent"></div>
    </div>
</div>

<script>
function viewPayloadModal(wh) {
    document.getElementById('whModalTitle').textContent = `Webhook #${wh.id} — ${wh.gateway.toUpperCase()} ${wh.event_type}`;
    var content = wh.payload_json;
    try {
        var parsed = JSON.parse(content);
        content = JSON.stringify(parsed, null, 4);
    } catch(e) {}
    document.getElementById('whModalContent').textContent = content;
    document.getElementById('whModalBg').classList.add('active');
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
