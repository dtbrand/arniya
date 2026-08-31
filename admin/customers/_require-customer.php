<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * _require-customer.php — Shared guard for the standalone per-customer panes.
 * DT Brand's & Jai Hanuman Tex
 *
 * admin/customers/{orders,addresses,activity,notes}.php each include one pane
 * from the 360 dossier on its own. None of them passed a customer id, so before
 * the panes were made real they simply printed the same sample data ("6 orders"
 * for Pooja Sharma) whatever the URL said, and afterwards they would have shown
 * a permanently empty table.
 *
 * Including this file resolves ?id= and, when it names no real customer, prints
 * a prompt and returns false so the caller can skip the pane.
 *
 * Usage:  $dtPaneCustomer = null; $dtPaneOk = include __DIR__ . '/_require-customer.php';
 */
require_once __DIR__ . '/../../src/CustomerManager.php';

$dtPaneIdRaw = isset($_GET['id']) ? trim((string)$_GET['id']) : '';
$dtPaneId    = (int)preg_replace('/[^0-9]/', '', $dtPaneIdRaw);
$dtPaneCustomer = $dtPaneId > 0 ? \DTBrand\CustomerManager::getById($dtPaneId) : null;

if ($dtPaneCustomer !== null) {
    return true;
}
?>
<div class="dt-cust-empty-state" style="padding:44px 24px;">
    <div class="dt-cust-empty-icon">
        <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle>
        </svg>
    </div>
    <h4 class="dt-cust-empty-title">
        <?php echo $dtPaneIdRaw === '' ? 'Choose a Customer' : 'Customer Not Found'; ?>
    </h4>
    <p class="dt-cust-empty-sub">
        <?php if ($dtPaneIdRaw === ''): ?>
            This view shows one customer at a time. Open it from a customer's record, or add
            <code>?id=&lt;customer id&gt;</code> to the address.
        <?php else: ?>
            No account matches <strong><?php echo htmlspecialchars($dtPaneIdRaw); ?></strong>.
        <?php endif; ?>
    </p>
    <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">Browse Customers</a>
</div>
<?php
return false;
