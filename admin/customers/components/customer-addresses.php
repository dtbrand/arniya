<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-addresses.php — Customer Shipping & Billing Address Management
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 *
 * This pane used to print two invented postal addresses ("Plot No. 42, Pocket
 * B-4, Sector 11, Rohini, New Delhi" and a Gurugram office) with a real-format
 * phone number, on every customer's dossier. The addresses table exists, so the
 * cards below are the customer's own saved addresses.
 */
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\Database;

$addrCustId = (int)preg_replace('/[^0-9]/', '', isset($_GET['id']) ? (string)$_GET['id'] : '');

if (isset($dossierAddresses) && is_array($dossierAddresses)) {
    $addrRows = $dossierAddresses;
} else {
    $addrRows = [];
    $pdo = Database::getConnection();
    if ($addrCustId > 0 && $pdo !== null && !Database::isMockMode()) {
        try {
            $stmt = $pdo->prepare("
                SELECT `id`, `recipient_name`, `phone`, `address_line1`, `address_line2`,
                       `city`, `state`, `pincode`, `address_type`, `is_default`
                FROM `addresses`
                WHERE `customer_id` = ?
                ORDER BY `is_default` DESC, `id` ASC
            ");
            $stmt->execute([$addrCustId]);
            $addrRows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Exception $e) {
            $addrRows = [];
        }
    }
}

$addrTypeLabels = ['home' => 'Home Address', 'work' => 'Work / Office Address', 'warehouse' => 'Warehouse Address'];
?>

<!-- ══ CUSTOMER ADDRESS BOOK ══ -->
<div>
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
        <h4 style="font-size:0.9rem; font-weight:800; color:#181512; margin:0;">
            Saved Addresses (<?php echo count($addrRows); ?>)
        </h4>
        <?php // The "+ Add Address" button only ever raised a toast; there is no
              // admin-side address form or endpoint, so it is not shown rather
              // than offered and then silently doing nothing. Customers manage
              // their own address book from /account.php. ?>
    </div>

    <?php if (count($addrRows) === 0): ?>
        <div class="dt-cust-empty-state" style="padding:32px 20px;">
            <div class="dt-cust-empty-icon">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            </div>
            <h4 class="dt-cust-empty-title">No Saved Addresses</h4>
            <p class="dt-cust-empty-sub">This customer has not saved a delivery address yet. Addresses added during checkout appear here.</p>
        </div>
    <?php else: ?>
    <div class="dt-cust-address-grid">
        <?php foreach ($addrRows as $a):
            $isDefault = !empty($a['is_default']);
            $type = strtolower((string)($a['address_type'] ?? 'home'));
            $label = $addrTypeLabels[$type] ?? 'Address';
            if ($isDefault) $label = 'Default Shipping Address';
        ?>
        <div class="dt-cust-address-card <?php echo $isDefault ? 'default' : ''; ?>">
            <div>
                <div class="dt-cust-address-head">
                    <span class="dt-cust-address-type" style="<?php echo $isDefault ? '' : 'color:#78716C;'; ?>">
                        <?php if ($type === 'work' || $type === 'warehouse'): ?>
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        <?php else: ?>
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <?php endif; ?>
                        <?php echo htmlspecialchars($label); ?>
                    </span>
                    <?php if ($isDefault): ?>
                        <span class="dt-status-pill active" style="font-size:0.6rem;">Default</span>
                    <?php endif; ?>
                </div>
                <div class="dt-cust-address-body" style="margin-top:8px;">
                    <strong><?php echo htmlspecialchars((string)$a['recipient_name']); ?></strong><br>
                    <?php echo htmlspecialchars((string)$a['address_line1']); ?><br>
                    <?php if (trim((string)($a['address_line2'] ?? '')) !== ''): ?>
                        <?php echo htmlspecialchars((string)$a['address_line2']); ?><br>
                    <?php endif; ?>
                    <?php echo htmlspecialchars((string)$a['city'] . ', ' . (string)$a['state'] . ' — ' . (string)$a['pincode']); ?><br>
                    Phone: <?php echo htmlspecialchars((string)$a['phone']); ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
