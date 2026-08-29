<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-activity.php — Chronological Audit Trail & Activity Timeline
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 *
 * This pane used to be six hardcoded events, identical on every dossier, and
 * they were not vague placeholders: they asserted a login IP (103.24.12.98), a
 * device ("Mobile Chrome / Android 14"), a courier AWB (8849201948) and a
 * quoted product review. None of that is recorded anywhere in the schema.
 *
 * There is no audit/activity table, so the timeline below is derived from the
 * events the database does timestamp: account creation, last sign-in, and each
 * order with its current fulfillment state. Reviews are deliberately excluded
 * -- the reviews table stores only customer_name with no customer_id, so
 * attributing one to this account would be a guess.
 */
require_once __DIR__ . '/../../../src/CustomerManager.php';

use DTBrand\CustomerManager;

$actCustId = (int)preg_replace('/[^0-9]/', '', isset($_GET['id']) ? (string)$_GET['id'] : '');
$actCust = isset($dossierCustomer) ? $dossierCustomer : ($actCustId > 0 ? CustomerManager::getById($actCustId) : null);
$actOrders = (isset($dossierOrders) && is_array($dossierOrders)) ? $dossierOrders : [];

$events = [];

foreach ($actOrders as $o) {
    $ts = !empty($o['created_at']) ? strtotime($o['created_at']) : 0;
    if ($ts <= 0) continue;
    $meta = ['₹' . number_format((float)($o['total_amount'] ?? 0))];
    if (!empty($o['payment_method'])) {
        $meta[] = strtoupper((string)$o['payment_method']) . ' · ' . ucfirst((string)($o['payment_status'] ?? ''));
    }
    if (!empty($o['channel'])) $meta[] = ucfirst((string)$o['channel']) . ' channel';
    $fs = strtolower((string)($o['fulfillment_status'] ?? ''));
    $events[] = [
        'ts'    => $ts,
        'dot'   => $fs === 'cancelled' ? 'amber' : ($fs === 'delivered' ? 'green' : ''),
        'title' => 'Placed order #' . (string)($o['order_number'] ?? '') . ' — currently ' . ($fs !== '' ? $fs : 'unknown'),
        'meta'  => $meta,
    ];

    // The schema keeps only the current fulfillment_status with no history, so
    // a dispatch or delivery cannot be given its own date. The tracking number
    // is attached to the order event instead of inventing a courier scan time.
    if (!empty($o['tracking_number'])) {
        $events[count($events) - 1]['meta'][] =
            trim((string)($o['courier_name'] ?? 'Courier')) . ' AWB: ' . (string)$o['tracking_number'];
    }
}

if ($actCust !== null && !empty($actCust['last_login'])) {
    $ts = strtotime((string)$actCust['last_login']);
    if ($ts > 0) {
        $events[] = ['ts' => $ts, 'dot' => '', 'title' => 'Last signed in', 'meta' => []];
    }
}

if ($actCust !== null && !empty($actCust['created_at'])) {
    $ts = strtotime((string)$actCust['created_at']);
    if ($ts > 0) {
        $meta = [];
        if (!empty($actCust['type'])) $meta[] = ucfirst((string)$actCust['type']) . ' account';
        if (!empty($actCust['city']))  $meta[] = (string)$actCust['city'];
        $events[] = ['ts' => $ts, 'dot' => 'green', 'title' => 'Account created', 'meta' => $meta];
    }
}

usort($events, function ($a, $b) { return $b['ts'] <=> $a['ts']; });
?>

<!-- ══ CUSTOMER ACTIVITY TIMELINE ══ -->
<div>
    <h4 style="font-size:0.9rem; font-weight:800; color:#181512; margin:0 0 6px 0;">Account Activity</h4>
    <p style="font-size:0.7rem; color:#8C8478; margin:0 0 16px 0;">
        Derived from recorded timestamps. Page views, logins before the most recent one, and cart activity are not logged.
    </p>

    <?php if (count($events) === 0): ?>
        <div class="dt-cust-empty-state" style="padding:32px 20px;">
            <div class="dt-cust-empty-icon">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
            </div>
            <h4 class="dt-cust-empty-title">No Recorded Activity</h4>
            <p class="dt-cust-empty-sub">Nothing has been timestamped against this account yet.</p>
        </div>
    <?php else: ?>
    <div class="dt-cust-timeline">
        <?php foreach ($events as $ev): ?>
        <div class="dt-cust-timeline-item">
            <div class="dt-cust-timeline-dot <?php echo $ev['dot']; ?>"></div>
            <div class="dt-cust-timeline-title"><?php echo htmlspecialchars($ev['title']); ?></div>
            <div class="dt-cust-timeline-meta">
                <span><?php echo date('d M Y \a\t h:i A', $ev['ts']); ?></span>
                <?php foreach ($ev['meta'] as $m): ?>
                    <span>• <?php echo htmlspecialchars($m); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
