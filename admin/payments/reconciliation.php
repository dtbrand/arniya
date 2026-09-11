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
 * reconciliation.php — 3-Way Financial Reconciliation Console
 * Section 28 (Payment Admin)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\Database;
use DTBrand\PaymentManager;

$page_title = "Financial 3-Way Reconciliation";
$active_nav = "payments";
$active_subnav = "reconciliation";

$reconciliationData = PaymentManager::reconcileOrders(['limit' => 150]);
$summary = $reconciliationData['summary'] ?? [];
$records = $reconciliationData['records'] ?? [];

$rupeeSvg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Reconciliation — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
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
                        <span>Financial 3-Way Reconciliation</span>
                        <span class="adm-badge <?= ($summary['discrepancy_count'] ?? 0) === 0 ? 'success' : 'amber' ?>">
                            <?= ($summary['discrepancy_count'] ?? 0) === 0 ? '100% BALANCED' : ($summary['discrepancy_count'] . ' DISCREPANCIES') ?>
                        </span>
                    </h1>
                    <p class="adm-page-subtitle">Continuous reconciliation across Storefront Orders, Gateway Captures, and Bank UTR settlements.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/payments/" class="dt-btn dt-btn-pale" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; padding:6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Transactions Ledger</span>
                    </a>
                    <button type="button" class="dt-btn dt-btn-pale" onclick="exportReconciliationCSV()" style="display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; padding:6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Export CSV</span>
                    </button>
                    <a href="/admin/payments/reconciliation.php" class="dt-btn dt-btn-gold" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:800; padding:6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        <span>Re-Run Audit</span>
                    </a>
                </div>
            </div>

            <!-- KPI Ribbon -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Audited Orders</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= (int)($summary['total_orders'] ?? 0) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Storefront &amp; API Volume</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Matched &amp; Balanced</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:#15803D;"><?= $rupeeSvg ?> <?= number_format((float)($summary['matched_amount'] ?? 0), 2) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up"><?= (int)($summary['reconciled_count'] ?? 0) ?> Orders Fully Reconciled</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Discrepancy Variance</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:<?= ($summary['discrepancy_count'] ?? 0) > 0 ? '#DC2626' : '#15803D' ?>;">
                        <?= $rupeeSvg ?> <?= number_format((float)($summary['discrepancy_amount'] ?? 0), 2) ?>
                    </div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta down"><?= (int)($summary['discrepancy_count'] ?? 0) ?> Exceptions Flagged</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Unpaid with Capture</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:<?= ($summary['unpaid_captured_count'] ?? 0) > 0 ? '#DC2626' : '#15803D' ?>;">
                        <?= (int)($summary['unpaid_captured_count'] ?? 0) ?>
                    </div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta down">Captured but Unmarked</span>
                    </div>
                </div>
            </div>

            <!-- Reconciliation Table -->
            <div class="adm-table-card">
                <div class="adm-table-toolbar">
                    <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; margin:0;">3-Way Audit Ledger (<?= count($records) ?> Audited Items)</h3></div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table" id="reconTable">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Order Total</th>
                                <th>Storefront Status</th>
                                <th>Gateway</th>
                                <th>Gateway Total</th>
                                <th>Variance</th>
                                <th>Gateway Ref / UTR</th>
                                <th>Status</th>
                                <th>Audit Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($records)): ?>
                                <?php foreach ($records as $r): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($r['order_number']) ?></strong></td>
                                        <td><strong><?= $rupeeSvg ?> <?= number_format((float)$r['order_amount'], 2) ?></strong></td>
                                        <td>
                                            <span class="adm-badge <?= $r['order_status'] === 'paid' ? 'success' : 'amber' ?>">
                                                <?= strtoupper(htmlspecialchars($r['order_status'])) ?>
                                            </span>
                                        </td>
                                        <td><span class="adm-badge gray"><?= strtoupper(htmlspecialchars($r['gateway'])) ?></span></td>
                                        <td><?= $rupeeSvg ?> <?= number_format((float)$r['gateway_amount'], 2) ?></td>
                                        <td>
                                            <?php if ($r['discrepancy_amount'] > 0.05): ?>
                                                <strong style="color:#DC2626;"><?= $rupeeSvg ?> <?= number_format((float)$r['discrepancy_amount'], 2) ?></strong>
                                            <?php else: ?>
                                                <span style="color:#15803D; font-weight:700;">₹ 0.00</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><code style="font-size:0.75rem;"><?= htmlspecialchars($r['gateway_ref']) ?></code></td>
                                        <td>
                                            <?php 
                                            $bClass = 'gray';
                                            if ($r['status'] === 'matched') $bClass = 'success';
                                            elseif ($r['status'] === 'unpaid_order') $bClass = 'danger';
                                            elseif ($r['status'] === 'discrepancy') $bClass = 'amber';
                                            ?>
                                            <span class="adm-badge <?= $bClass ?>"><?= strtoupper(str_replace('_', ' ', $r['status'])) ?></span>
                                        </td>
                                        <td style="font-size:0.75rem; color:#64748B; max-width:240px;"><?= htmlspecialchars($r['notes']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" style="text-align:center; padding:35px; color:#64748B;">No orders available for reconciliation audit.</td>
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

<script>
function exportReconciliationCSV() {
    var csv = [];
    var rows = document.querySelectorAll("#reconTable tr");
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        for (var j = 0; j < cols.length; j++) {
            var text = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").replace(/"/g, '""');
            row.push('"' + text.trim() + '"');
        }
        csv.push(row.join(","));
    }
    var csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
    var downloadLink = document.createElement("a");
    downloadLink.download = "reconciliation_audit_" + (new Date().toISOString().slice(0,10)) + ".csv";
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
