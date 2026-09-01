<?php
/* DT admin access guard (auto-inserted) */ 
$__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; 
if (is_file($__dtg)) require_once $__dtg;

/**
 * index.php - DT Brand's Master Payments & Audit Ledger
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\Database;
use DTBrand\PaymentManager;

$page_title = "Payment Gateways & Ledger Settlement";
$active_nav = "payments";
$active_subnav = "index";

$pdo = Database::getConnection();

// Summary Metrics
$totalCollections = 0.0;
$upiCollections = 0.0;
$cardCollections = 0.0;
$codCollections = 0.0;
$pendingVerificationsCount = 0;

$filterGateway = trim((string)($_GET['gateway'] ?? ''));
$filterStatus = trim((string)($_GET['status'] ?? ''));
$searchQuery = trim((string)($_GET['q'] ?? ''));

$transactions = [];

if ($pdo !== null && !Database::isMockMode()) {
    try {
        // Compute Metrics
        $metricStmt = $pdo->query("
            SELECT 
                SUM(CASE WHEN `status` = 'captured' THEN `amount` ELSE 0 END) as total_collected,
                SUM(CASE WHEN `gateway` = 'direct_upi' AND `status` = 'captured' THEN `amount` ELSE 0 END) as upi_collected,
                SUM(CASE WHEN `gateway` IN ('razorpay', 'cashfree') AND `status` = 'captured' THEN `amount` ELSE 0 END) as card_collected,
                SUM(CASE WHEN `gateway` = 'cod' THEN `amount` ELSE 0 END) as cod_total,
                SUM(CASE WHEN `status` IN ('pending', 'authorized') THEN 1 ELSE 0 END) as pending_count
            FROM `payment_transactions`
        ");
        $metrics = $metricStmt->fetch(PDO::FETCH_ASSOC) ?: [];
        $totalCollections = (float)($metrics['total_collected'] ?? 0);
        $upiCollections = (float)($metrics['upi_collected'] ?? 0);
        $cardCollections = (float)($metrics['card_collected'] ?? 0);
        $codCollections = (float)($metrics['cod_total'] ?? 0);
        $pendingVerificationsCount = (int)($metrics['pending_count'] ?? 0);

        // Build Filtered Query
        $where = [];
        $params = [];

        if (!empty($filterGateway)) {
            $where[] = "`gateway` = :gateway";
            $params[':gateway'] = $filterGateway;
        }
        if (!empty($filterStatus)) {
            $where[] = "`status` = :status";
            $params[':status'] = $filterStatus;
        }
        if (!empty($searchQuery)) {
            $where[] = "(`order_number` LIKE :q OR `customer_name` LIKE :q OR `customer_phone` LIKE :q OR `utr_reference` LIKE :q OR `gateway_payment_id` LIKE :q)";
            $params[':q'] = "%{$searchQuery}%";
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
        $sql = "SELECT * FROM `payment_transactions` {$whereClause} ORDER BY `id` DESC LIMIT 100";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (\Throwable $e) {
        error_log("Admin Payments index query error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateways &amp; Ledger Settlement - DT Brand's Admin</title>
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
        .dt-payload-modal-bg {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(4px);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .dt-payload-modal-bg.active { display: flex; }
        .dt-payload-card {
            background: #FFFFFF;
            border-radius: 12px;
            width: 100%;
            max-width: 600px;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
            border: 1.5px solid #D4AF37;
            box-shadow: 0 16px 40px rgba(0,0,0,0.25);
            overflow: hidden;
        }
        .dt-payload-body {
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
                        <span>Payment Gateways &amp; Ledger Settlement</span>
                        <span class="adm-badge gold">100% Real Audit</span>
                    </h1>
                    <p class="adm-page-subtitle">Unified ledger tracking Instant UPI, Razorpay, Cashfree, COD, and UTR settlement verification.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/settings/payment.php" class="adm-btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>Gateway Studio</span>
                    </a>
                </div>
            </div>

            <!-- KPI Metric Cards with Real Indian Rupee (₹) SVGs -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total Verified Revenue</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">₹<?= number_format($totalCollections, 2) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Live Database Collections</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Instant UPI Collections</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">₹<?= number_format($upiCollections, 2) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Direct 0% Fee UPI Transfers</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Cards &amp; NetBanking PG</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">₹<?= number_format($cardCollections, 2) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Razorpay &amp; Cashfree</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Pending Verification Queue</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:<?= $pendingVerificationsCount > 0 ? '#B45309' : '#15803D' ?>;"><?= $pendingVerificationsCount ?></div>
                    <div class="adm-kpi-bottom">
                        <a href="/admin/payments/pending.php" style="font-size:0.75rem; color:#8A681F; font-weight:700; text-decoration:none;">Review Pending UTRs →</a>
                    </div>
                </div>
            </div>

            <!-- Dynamic Search & Filters Bar -->
            <form method="GET" class="dt-filter-bar">
                <input type="text" name="q" class="dt-search-input" placeholder="Search by Order #, Customer, Phone, or UTR..." value="<?= htmlspecialchars($searchQuery) ?>">
                
                <select name="gateway" class="dt-filter-select">
                    <option value="">All Gateways</option>
                    <option value="direct_upi" <?= $filterGateway === 'direct_upi' ? 'selected' : '' ?>>Instant Direct UPI</option>
                    <option value="razorpay" <?= $filterGateway === 'razorpay' ? 'selected' : '' ?>>Razorpay PG</option>
                    <option value="cashfree" <?= $filterGateway === 'cashfree' ? 'selected' : '' ?>>Cashfree PG</option>
                    <option value="cod" <?= $filterGateway === 'cod' ? 'selected' : '' ?>>Cash on Delivery</option>
                    <option value="whatsapp_pay" <?= $filterGateway === 'whatsapp_pay' ? 'selected' : '' ?>>WhatsApp Pay</option>
                </select>

                <select name="status" class="dt-filter-select">
                    <option value="">All Statuses</option>
                    <option value="captured" <?= $filterStatus === 'captured' ? 'selected' : '' ?>>Captured / Paid</option>
                    <option value="pending" <?= $filterStatus === 'pending' ? 'selected' : '' ?>>Pending Verification</option>
                    <option value="authorized" <?= $filterStatus === 'authorized' ? 'selected' : '' ?>>Authorized</option>
                    <option value="failed" <?= $filterStatus === 'failed' ? 'selected' : '' ?>>Failed</option>
                    <option value="refunded" <?= $filterStatus === 'refunded' ? 'selected' : '' ?>>Refunded</option>
                </select>

                <button type="submit" class="adm-btn-primary" style="padding:8px 16px;">Filter</button>
                <?php if (!empty($filterGateway) || !empty($filterStatus) || !empty($searchQuery)): ?>
                    <a href="/admin/payments/" class="adm-btn-secondary" style="padding:8px 12px;">Reset</a>
                <?php endif; ?>
            </form>

            <!-- Transactions Audit Table -->
            <div class="adm-table-card">
                <div class="adm-table-toolbar">
                    <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; margin:0;">Transaction Audit Trail (<?= count($transactions) ?> Records)</h3></div>
                    <button class="adm-btn-secondary" onclick="exportTableToCSV('payments_ledger.csv')">📥 Export CSV</button>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table" id="paymentsLedgerTable">
                        <thead>
                            <tr>
                                <th>Tx ID</th>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Gateway</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>UTR / Gateway Ref</th>
                                <th>Date &amp; Time</th>
                                <th>Audit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($transactions)): ?>
                                <?php foreach ($transactions as $tx): ?>
                                    <tr>
                                        <td>#<?= $tx['id'] ?></td>
                                        <td><strong><?= htmlspecialchars($tx['order_number']) ?></strong></td>
                                        <td>
                                            <?= htmlspecialchars($tx['customer_name'] ?? 'Guest Customer') ?><br>
                                            <span style="font-size:0.72rem; color:#64748B;"><?= htmlspecialchars($tx['customer_phone'] ?? '') ?></span>
                                        </td>
                                        <td>
                                            <span class="adm-badge <?= $tx['gateway'] === 'direct_upi' ? 'gold' : ($tx['gateway'] === 'razorpay' ? 'blue' : 'gray') ?>">
                                                <?= strtoupper(htmlspecialchars($tx['gateway'])) ?>
                                            </span>
                                        </td>
                                        <td><strong>₹<?= number_format((float)$tx['amount'], 2) ?></strong></td>
                                        <td>
                                            <?php 
                                            $statusBadge = 'gray';
                                            if ($tx['status'] === 'captured') $statusBadge = 'success';
                                            elseif ($tx['status'] === 'pending') $statusBadge = 'amber';
                                            elseif ($tx['status'] === 'failed') $statusBadge = 'danger';
                                            ?>
                                            <span class="adm-badge <?= $statusBadge ?>"><?= ucfirst(htmlspecialchars($tx['status'])) ?></span>
                                        </td>
                                        <td>
                                            <?php if (!empty($tx['utr_reference'])): ?>
                                                <code style="background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:700;"><?= htmlspecialchars($tx['utr_reference']) ?></code>
                                            <?php elseif (!empty($tx['gateway_payment_id'])): ?>
                                                <span style="font-size:0.75rem; color:#475569; font-family:monospace;"><?= htmlspecialchars($tx['gateway_payment_id']) ?></span>
                                            <?php else: ?>
                                                <span style="color:#94A3B8; font-size:0.75rem;">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-size:0.75rem; color:#64748B;"><?= date('d M Y, h:i A', strtotime($tx['created_at'])) ?></td>
                                        <td>
                                            <button type="button" class="adm-btn-secondary adm-btn-sm" style="padding:3px 8px; font-size:0.72rem;" onclick="viewPayload(<?= htmlspecialchars(json_encode($tx), ENT_QUOTES, 'UTF-8') ?>)">
                                                🔍 Payload
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" style="text-align:center; padding:35px; color:#64748B;">
                                        ✨ No transactions found matching current filter criteria.
                                    </td>
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

<!-- Modal: Raw Payload & Audit Viewer -->
<div class="dt-payload-modal-bg" id="payloadModalBg" onclick="if(event.target===this)this.classList.remove('active');">
    <div class="dt-payload-card">
        <div style="padding:14px 18px; border-bottom:1px solid #E2E8F0; display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin:0; font-size:0.95rem; font-family:var(--adm-font-serif); color:#8A681F;" id="payloadModalTitle">Transaction Audit Record</h3>
            <button type="button" style="background:none; border:none; font-size:18px; cursor:pointer; color:#64748B;" onclick="document.getElementById('payloadModalBg').classList.remove('active')">✕</button>
        </div>
        <div class="dt-payload-body" id="payloadModalContent"></div>
    </div>
</div>

<script>
function viewPayload(tx) {
    document.getElementById('payloadModalTitle').textContent = `Transaction #${tx.id} — Order ${tx.order_number}`;
    document.getElementById('payloadModalContent').textContent = JSON.stringify(tx, null, 4);
    document.getElementById('payloadModalBg').classList.add('active');
}

function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("#paymentsLedgerTable tr");
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        for (var j = 0; j < cols.length - 1; j++) {
            var text = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").replace(/"/g, '""');
            row.push('"' + text.trim() + '"');
        }
        csv.push(row.join(","));
    }
    var csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
    var downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
