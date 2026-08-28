<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-summary.php — Financial Summary Metrics Card for Customer 360 View
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 *
 * Every figure in this strip used to be a literal: Rs 28,450 lifetime spend,
 * "6 Orders", Rs 4,741 AOV, "Top 2.5% Customer", "100% Delivered" and
 * "Zero RTO Returns" -- printed identically on every customer's dossier. They
 * now come from the customer row and the loaded order list.
 */
require_once __DIR__ . '/../../../src/CustomerManager.php';

use DTBrand\CustomerManager;

$sumCust = isset($dossierCustomer) ? $dossierCustomer : null;
if ($sumCust === null) {
    $sid = (int)preg_replace('/[^0-9]/', '', isset($_GET['id']) ? (string)$_GET['id'] : '');
    $sumCust = $sid > 0 ? CustomerManager::getById($sid) : null;
}
$sumOrders = (isset($dossierOrders) && is_array($dossierOrders)) ? $dossierOrders : [];

// Prefer the orders actually on file. The customers table also carries running
// totals (total_orders / lifetime_spend) which the storefront maintains, so
// fall back to those when no order rows were loaded.
$paidStatuses = ['paid', 'credit'];
$orderCount = count($sumOrders);
$spend = 0.0;
$delivered = 0;
$cancelled = 0;
foreach ($sumOrders as $o) {
    if (in_array(strtolower((string)($o['payment_status'] ?? '')), $paidStatuses, true)) {
        $spend += (float)($o['total_amount'] ?? 0);
    }
    $fs = strtolower((string)($o['fulfillment_status'] ?? ''));
    if ($fs === 'delivered') $delivered++;
    if ($fs === 'cancelled') $cancelled++;
}

if ($orderCount === 0 && $sumCust !== null) {
    $orderCount = (int)($sumCust['total_orders'] ?? 0);
    $spend = (float)($sumCust['lifetime_spend'] ?? 0);
}

$aov = $orderCount > 0 ? $spend / $orderCount : 0;
$deliveredPct = count($sumOrders) > 0 ? round(($delivered / count($sumOrders)) * 100) : null;
$cancelledPct = count($sumOrders) > 0 ? round(($cancelled / count($sumOrders)) * 100, 1) : null;
$outstanding = $sumCust !== null ? (float)($sumCust['outstanding_balance'] ?? 0) : 0;
$creditLimit = $sumCust !== null ? (float)($sumCust['credit_limit'] ?? 0) : 0;
?>

<!-- ══ FINANCIAL 4-STAT STRIP ══ -->
<div class="dt-cust-fin-strip">
    <div class="dt-cust-fin-box">
        <span class="dt-cust-fin-label">LIFETIME SPEND</span>
        <span class="dt-cust-fin-val" style="color:#8A681F;">₹<?php echo number_format($spend); ?></span>
        <span style="font-size:0.65rem; color:#78716C; font-weight:600;">Paid &amp; credit orders</span>
    </div>

    <div class="dt-cust-fin-box">
        <span class="dt-cust-fin-label">TOTAL ORDERS</span>
        <span class="dt-cust-fin-val"><?php echo number_format($orderCount); ?> <?php echo $orderCount === 1 ? 'Order' : 'Orders'; ?></span>
        <span style="font-size:0.65rem; color:#78716C; font-weight:600;">
            <?php if ($deliveredPct !== null): ?>
                <?php echo $deliveredPct; ?>% delivered
            <?php else: ?>
                No order rows on file
            <?php endif; ?>
        </span>
    </div>

    <div class="dt-cust-fin-box">
        <span class="dt-cust-fin-label">AVG ORDER VALUE</span>
        <span class="dt-cust-fin-val">₹<?php echo number_format($aov); ?></span>
        <span style="font-size:0.65rem; color:#78716C; font-weight:600;">
            <?php echo $orderCount > 0 ? 'Across ' . number_format($orderCount) . ' orders' : 'No orders yet'; ?>
        </span>
    </div>

    <div class="dt-cust-fin-box">
        <?php // The schema has no returns/RMA table, so "Return rate" cannot be
              // computed. Outstanding balance is a real column and is what an
              // admin looking at a trade account actually needs here. ?>
        <span class="dt-cust-fin-label">OUTSTANDING</span>
        <span class="dt-cust-fin-val" style="color:<?php echo $outstanding > 0 ? '#B45309' : '#15803D'; ?>;">₹<?php echo number_format($outstanding); ?></span>
        <span style="font-size:0.65rem; color:#78716C; font-weight:600;">
            <?php if ($creditLimit > 0): ?>
                of ₹<?php echo number_format($creditLimit); ?> credit limit
            <?php elseif ($cancelledPct !== null && $cancelledPct > 0): ?>
                <?php echo $cancelledPct; ?>% cancelled
            <?php else: ?>
                No credit limit set
            <?php endif; ?>
        </span>
    </div>
</div>
