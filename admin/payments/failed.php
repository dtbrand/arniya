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
 * failed.php — Failed Payments & Dropped Checkouts Recovery Hub
 * Section 28 (Payment Admin)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\Database;
use DTBrand\PaymentManager;

$page_title = "Failed Payments & Recovery Hub";
$active_nav = "payments";
$active_subnav = "failed";

$pdo = Database::getConnection();

$failedTransactions = [];
$totalValueAtRisk = 0.0;
$totalFailedCount = 0;
$recoveredCount = 0;

$filterGateway = trim((string)($_GET['gateway'] ?? ''));
$searchQuery = trim((string)($_GET['q'] ?? ''));

if ($pdo !== null && !Database::isMockMode()) {
    try {
        // Summary KPIs
        $metricStmt = $pdo->query("
            SELECT 
                COUNT(*) as failed_cnt,
                COALESCE(SUM(amount), 0) as risk_val,
                SUM(CASE WHEN recovered_at IS NOT NULL THEN 1 ELSE 0 END) as recovered_cnt
            FROM `payment_transactions`
            WHERE `status` = 'failed'
        ");
        $metrics = $metricStmt->fetch(PDO::FETCH_ASSOC) ?: [];
        $totalFailedCount = (int)($metrics['failed_cnt'] ?? 0);
        $totalValueAtRisk = (float)($metrics['risk_val'] ?? 0.0);
        $recoveredCount = (int)($metrics['recovered_cnt'] ?? 0);

        // Filtered List
        $where = ["`status` = 'failed'"];
        $params = [];

        if (!empty($filterGateway)) {
            $where[] = "`gateway` = :gateway";
            $params[':gateway'] = $filterGateway;
        }
        if (!empty($searchQuery)) {
            $where[] = "(`order_number` LIKE :q OR `customer_name` LIKE :q OR `customer_phone` LIKE :q OR `failure_reason` LIKE :q)";
            $params[':q'] = "%{$searchQuery}%";
        }

        $whereClause = "WHERE " . implode(" AND ", $where);
        $stmt = $pdo->prepare("SELECT * FROM `payment_transactions` {$whereClause} ORDER BY `id` DESC LIMIT 100");
        $stmt->execute($params);
        $failedTransactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (\Throwable $e) {
        error_log("Failed payments query error: " . $e->getMessage());
    }
}

$rupeeSvg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Failed Payments &amp; Recovery Hub — DT Brand's Admin</title>
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
                        <span>Failed Payments &amp; Recovery Hub</span>
                        <span class="adm-badge danger"><?= $totalFailedCount ?> Incidents</span>
                    </h1>
                    <p class="adm-page-subtitle">Track dropped gateways, bank timeouts, and re-engage customers via 1-Click WhatsApp payment links.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/payments/" class="dt-btn dt-btn-pale" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; padding:6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Transactions Ledger</span>
                    </a>
                </div>
            </div>

            <!-- KPI Metric Ribbon -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Value at Risk</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:#DC2626;"><?= $rupeeSvg ?> <?= number_format($totalValueAtRisk, 2) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta down">Total Interrupted Cart Value</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Failed Incidents</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $totalFailedCount ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta down">Card Declines, UPI &amp; Bank Drops</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Successfully Recovered</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:#15803D;"><?= $recoveredCount ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Customer Re-engaged Orders</span>
                    </div>
                </div>
            </div>

            <!-- Filter Bar -->
            <form method="GET" class="dt-filter-bar">
                <input type="text" name="q" class="dt-search-input" placeholder="Search by Order #, Customer, Phone, or Error Reason..." value="<?= htmlspecialchars($searchQuery) ?>">
                
                <select name="gateway" class="dt-filter-select">
                    <option value="">All Gateways</option>
                    <option value="razorpay" <?= $filterGateway === 'razorpay' ? 'selected' : '' ?>>Razorpay</option>
                    <option value="cashfree" <?= $filterGateway === 'cashfree' ? 'selected' : '' ?>>Cashfree</option>
                    <option value="direct_upi" <?= $filterGateway === 'direct_upi' ? 'selected' : '' ?>>Direct UPI</option>
                </select>

                <button type="submit" class="dt-btn dt-btn-gold" style="padding:8px 16px; display:inline-flex; align-items:center; gap:6px; font-size:12.5px; font-weight:800;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <span>Filter</span>
                </button>
                <?php if (!empty($filterGateway) || !empty($searchQuery)): ?>
                    <a href="/admin/payments/failed.php" class="dt-btn dt-btn-pale" style="text-decoration:none; padding:8px 14px; font-size:12px; font-weight:700;">Reset</a>
                <?php endif; ?>
            </form>

            <!-- Table Card -->
            <div class="adm-table-card">
                <div class="adm-table-toolbar">
                    <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; margin:0;">Failed Transactions &amp; Recovery Queue</h3></div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Tx ID</th>
                                <th>Order #</th>
                                <th>Customer &amp; Contact</th>
                                <th>Gateway</th>
                                <th>Amount</th>
                                <th>Failure Reason</th>
                                <th>Failed Time</th>
                                <th>1-Click Recovery</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($failedTransactions)): ?>
                                <?php foreach ($failedTransactions as $f): ?>
                                    <?php 
                                    $phone = preg_replace('/[^0-9]/', '', (string)($f['customer_phone'] ?? ''));
                                    $custName = htmlspecialchars($f['customer_name'] ?: 'Customer');
                                    $ordNo = htmlspecialchars($f['order_number']);
                                    $amtStr = number_format((float)$f['amount'], 2);
                                    
                                    // 1-Click WhatsApp Direct Deep Link
                                    $waMsg = "Namaste {$custName}! We noticed that your payment of Rs {$amtStr} for Order #{$ordNo} at DT Brand's & Jai Hanuman Tex could not be completed. \n\nYou can easily complete your payment here: https://jaihanumantex.in/checkout.php?retry_order={$ordNo}\n\nIf you need any assistance, our mill concierge is here to help!";
                                    $waUrl = "https://api.whatsapp.com/send?phone=91{$phone}&text=" . rawurlencode($waMsg);
                                    ?>
                                    <tr>
                                        <td>#<?= $f['id'] ?></td>
                                        <td><strong><?= $ordNo ?></strong></td>
                                        <td>
                                            <?= $custName ?><br>
                                            <span style="font-size:0.75rem; color:#64748B;"><?= htmlspecialchars($f['customer_phone'] ?: 'No Phone') ?></span>
                                        </td>
                                        <td><span class="adm-badge gray"><?= strtoupper(htmlspecialchars($f['gateway'])) ?></span></td>
                                        <td><strong style="color:#DC2626;"><?= $rupeeSvg ?> <?= $amtStr ?></strong></td>
                                        <td>
                                            <span style="font-size:0.78rem; color:#DC2626; font-weight:600;">
                                                <?= htmlspecialchars($f['failure_reason'] ?: ($f['notes'] ?: 'Payment dropped or bank declined')) ?>
                                            </span>
                                        </td>
                                        <td style="font-size:0.75rem; color:#64748B;"><?= date('d M Y, h:i A', strtotime($f['created_at'])) ?></td>
                                        <td>
                                            <?php if (!empty($phone)): ?>
                                                <a href="<?= $waUrl ?>" target="_blank" rel="noopener noreferrer" class="dt-btn dt-btn-emerald dt-btn-sm" style="text-decoration:none; display:inline-flex; align-items:center; gap:5px; padding:4px 10px; font-size:0.75rem; font-weight:700;">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                                    <span>WhatsApp Recovery</span>
                                                </a>
                                            <?php else: ?>
                                                <span style="color:#94A3B8; font-size:0.75rem;">No Phone Provided</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align:center; padding:35px; color:#15803D;">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2" style="margin-bottom:8px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        <p style="margin:0; font-weight:700;">Zero failed payments recorded. All checkouts successfully captured!</p>
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
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
