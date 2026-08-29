<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * view.php — Customer 360° Profile & Deep Dossier
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/CustomerManager.php';

use DTBrand\Database;
use DTBrand\CustomerManager;

// Accept "42" or "CUST-42". This used to default to the string 'CUST-1042',
// which no row can match, and then every pane below rendered a hardcoded
// dossier for it -- so /view.php with no id showed a complete purchase history
// for a customer who does not exist.
$customer_id_raw = isset($_GET['id']) ? trim((string)$_GET['id']) : '';
$customer_id = (int)preg_replace('/[^0-9]/', '', $customer_id_raw);

// Loaded once here and read by the included panes, so a single page view does
// not run the same three queries four times.
$dossierCustomer  = $customer_id > 0 ? CustomerManager::getById($customer_id) : null;
$dossierOrders    = [];
$dossierAddresses = [];

if ($dossierCustomer !== null) {
    $pdo = Database::getConnection();
    if ($pdo !== null && !Database::isMockMode()) {
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
            $stmt->execute([$customer_id]);
            $dossierOrders = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Exception $e) {
            $dossierOrders = [];
        }

        try {
            $stmt = $pdo->prepare("
                SELECT `id`, `recipient_name`, `phone`, `address_line1`, `address_line2`,
                       `city`, `state`, `pincode`, `address_type`, `is_default`
                FROM `addresses`
                WHERE `customer_id` = ?
                ORDER BY `is_default` DESC, `id` ASC
            ");
            $stmt->execute([$customer_id]);
            $dossierAddresses = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Exception $e) {
            $dossierAddresses = [];
        }
    }
}

$dossierName = $dossierCustomer !== null ? (string)$dossierCustomer['name'] : '';
$page_title = $dossierCustomer !== null
    ? "Customer 360° Dossier — " . $dossierName
    : "Customer Not Found";
$active_nav = "customers";
$active_subnav = "view";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-view.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-profile.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container">
                <!-- Page Top Navigation Bar -->
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer 360° Dossier</span>
                            <?php if ($dossierCustomer !== null): ?>
                                <span class="dt-cust-badge gold">#<?php echo (int)$customer_id; ?></span>
                            <?php endif; ?>
                        </h1>
                        <p class="dt-cust-subtitle">
                            <?php if ($dossierCustomer !== null): ?>
                                Lifetime orders, address book and account standing for <?php echo htmlspecialchars($dossierName); ?>.
                            <?php else: ?>
                                No customer matches this link.
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">← Back to Customers</a>
                        <?php if ($dossierCustomer !== null): ?>
                            <a href="/admin/customers/edit.php?id=<?php echo (int)$customer_id; ?>" class="dt-btn dt-btn-gold">Edit Customer</a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- 2-Column Responsive Dossier Grid -->
                <div class="dt-cust-dossier-grid">
                    <!-- Left Column: Identity Card -->
                    <?php include __DIR__ . '/components/customer-profile.php'; ?>

                    <!-- Right Column: Main Tabbed Content Area -->
                    <div class="dt-cust-main-pane">
                        <?php if ($dossierCustomer === null): ?>
                            <div class="dt-cust-empty-state" style="padding:48px 24px;">
                                <div class="dt-cust-empty-icon">
                                    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                </div>
                                <h4 class="dt-cust-empty-title">Nothing to show</h4>
                                <p class="dt-cust-empty-sub">
                                    <?php if ($customer_id_raw === ''): ?>
                                        This page needs a customer id, for example <code>view.php?id=12</code>.
                                    <?php else: ?>
                                        No account matches <strong><?php echo htmlspecialchars($customer_id_raw); ?></strong>. It may have been deleted.
                                    <?php endif; ?>
                                </p>
                                <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">Browse Customers</a>
                            </div>
                        <?php else: ?>
                        <!-- Top Financial Strip -->
                        <?php include __DIR__ . '/components/customer-summary.php'; ?>

                        <!-- Interactive Tab Navigator -->
                        <div class="dt-cust-tab-nav">
                            <?php // Badge counts come from the loaded rows. They used to read 6 / 2 / 2 for everyone. ?>
                            <button type="button" class="dt-cust-tab-btn active" onclick="switchCustomerTab('orders', this)">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path></svg>
                                <span>Order History</span>
                                <span class="dt-cust-tab-badge"><?php echo count($dossierOrders); ?></span>
                            </button>

                            <button type="button" class="dt-cust-tab-btn" onclick="switchCustomerTab('addresses', this)">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Saved Addresses</span>
                                <span class="dt-cust-tab-badge"><?php echo count($dossierAddresses); ?></span>
                            </button>

                            <button type="button" class="dt-cust-tab-btn" onclick="switchCustomerTab('activity', this)">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                                <span>Audit Timeline</span>
                            </button>

                            <button type="button" class="dt-cust-tab-btn" onclick="switchCustomerTab('notes', this)">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                <span>Staff Notes</span>
                            </button>
                        </div>

                        <!-- Tab Panes -->
                        <div class="dt-cust-tab-content">
                            <div id="dtCustTabPane-orders" class="dt-cust-tab-pane" style="display:block;">
                                <?php include __DIR__ . '/components/customer-orders.php'; ?>
                            </div>

                            <div id="dtCustTabPane-addresses" class="dt-cust-tab-pane" style="display:none;">
                                <?php include __DIR__ . '/components/customer-addresses.php'; ?>
                            </div>

                            <div id="dtCustTabPane-activity" class="dt-cust-tab-pane" style="display:none;">
                                <?php include __DIR__ . '/components/customer-activity.php'; ?>
                            </div>

                            <div id="dtCustTabPane-notes" class="dt-cust-tab-pane" style="display:none;">
                                <?php include __DIR__ . '/components/customer-notes.php'; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Status Modal -->
            <?php include __DIR__ . '/components/customer-status.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/customers/assets/js/customer-view.js?v=<?php echo time(); ?>"></script>
<script src="/admin/customers/assets/js/customer-status.js?v=<?php echo time(); ?>"></script>
</body>
</html>
