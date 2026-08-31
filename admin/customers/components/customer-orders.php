<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-orders.php — Customer Orders History Table Component
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 *
 * This pane used to be three hardcoded <tr> blocks -- ORD-9842, ORD-9418 and
 * ORD-8920, with invented totals, couriers and payment modes -- shown on every
 * customer's dossier under the heading "Recent Purchase History (6 Orders)".
 * Each row linked to /admin/orders/view.php?id=ORD-9842, an order that does not
 * exist. The rows now come from the orders table.
 */
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\Database;

$ordCustId = (int)preg_replace('/[^0-9]/', '', isset($_GET['id']) ? (string)$_GET['id'] : '');

if (isset($dossierOrders) && is_array($dossierOrders)) {
    $ordRows = $dossierOrders;
} else {
    $ordRows = [];
    $pdo = Database::getConnection();
    if ($ordCustId > 0 && $pdo !== null && !Database::isMockMode()) {
        try {
            $stmt = $pdo->prepare("
                SELECT o.`id`, o.`order_number`, o.`created_at`, o.`total_amount`,
                       o.`payment_method`, o.`payment_status`, o.`fulfillment_status`,
                       o.`tracking_number`, o.`courier_name`, o.`channel`,
                       (SELECT COUNT(*) FROM `order_items` oi WHERE oi.`order_id` = o.`id`) AS item_count,
                       (SELECT GROUP_CONCAT(oi2.`product_title` SEPARATOR ', ')
                          FROM `order_items` oi2 WHERE oi2.`order_id` = o.`id`) AS item_titles
                FROM `orders` o
                WHERE o.`customer_id` = ?
                ORDER BY o.`created_at` DESC, o.`id` DESC
            ");
            $stmt->execute([$ordCustId]);
            $ordRows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Exception $e) {
            $ordRows = [];
        }
    }
}

$ordCount = count($ordRows);

// Fulfillment ENUM: unfulfilled | processing | dispatched | delivered | cancelled
if (!function_exists('dt_ord_pill')) {
    function dt_ord_pill(string $status): string
    {
        switch (strtolower($status)) {
            case 'delivered':   return 'active';
            case 'cancelled':   return 'suspended';
            case 'dispatched':  return 'vip';
            default:            return 'inactive';
        }
    }
}
?>

<!-- ══ CUSTOMER RECENT ORDERS SUB-TABLE ══ -->
<div class="dt-cust-table-wrap" style="border:none; box-shadow:none;">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
        <h4 style="font-size:0.9rem; font-weight:800; color:#181512; margin:0;">
            Purchase History (<?php echo number_format($ordCount); ?> <?php echo $ordCount === 1 ? 'Order' : 'Orders'; ?>)
        </h4>
        <?php if ($ordCount > 0): ?>
            <a href="/admin/orders/index.php?search=<?php echo (int)$ordCustId; ?>" class="dt-btn dt-btn-pale dt-btn-sm">View Full Order Stream →</a>
        <?php endif; ?>
    </div>

    <?php if ($ordCount === 0): ?>
        <div class="dt-cust-empty-state" style="padding:32px 20px;">
            <div class="dt-cust-empty-icon">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            </div>
            <h4 class="dt-cust-empty-title">No Orders Yet</h4>
            <p class="dt-cust-empty-sub">This customer has not placed an order. Orders appear here as soon as one is recorded.</p>
        </div>
    <?php else: ?>
    <table class="dt-cust-table" style="min-width:700px;">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Items Ordered</th>
                <th>Total Value</th>
                <th>Payment</th>
                <th>Status</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ordRows as $o):
                $oid    = (int)($o['id'] ?? 0);
                $onum   = (string)($o['order_number'] ?? '');
                $items  = (int)($o['item_count'] ?? 0);
                $titles = trim((string)($o['item_titles'] ?? ''));
                if (strlen($titles) > 60) $titles = substr($titles, 0, 57) . '...';
                $fs     = (string)($o['fulfillment_status'] ?? '');
                $ps     = (string)($o['payment_status'] ?? '');
                $when   = !empty($o['created_at']) ? date('d M Y', strtotime($o['created_at'])) : '—';
            ?>
            <tr>
                <td><a href="/admin/orders/view.php?id=<?php echo $oid; ?>" style="color:#8A681F; font-weight:800; text-decoration:none; font-family:monospace;">#<?php echo htmlspecialchars($onum); ?></a></td>
                <td><?php echo htmlspecialchars($when); ?></td>
                <td>
                    <strong><?php echo $items; ?> <?php echo $items === 1 ? 'Item' : 'Items'; ?></strong>
                    <?php if ($titles !== ''): ?><br><small style="color:#78716C; font-size:0.65rem;"><?php echo htmlspecialchars($titles); ?></small><?php endif; ?>
                </td>
                <td><strong style="color:#181512;">₹<?php echo number_format((float)($o['total_amount'] ?? 0)); ?></strong></td>
                <td>
                    <span class="dt-status-pill <?php echo $ps === 'paid' ? 'active' : ($ps === 'refunded' ? 'suspended' : 'inactive'); ?>" style="font-size:0.65rem;">
                        <?php echo htmlspecialchars(strtoupper((string)($o['payment_method'] ?? '')) . ' · ' . ucfirst($ps)); ?>
                    </span>
                </td>
                <td><span class="dt-status-pill <?php echo dt_ord_pill($fs); ?>" style="font-size:0.65rem;">● <?php echo htmlspecialchars(ucfirst($fs)); ?></span></td>
                <td style="text-align:right;">
                    <a href="/admin/orders/view.php?id=<?php echo $oid; ?>" class="dt-cust-act-btn" title="View Order Details">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
