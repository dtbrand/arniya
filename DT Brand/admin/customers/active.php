<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * active.php — Active Verified Customers Hub
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
require_once __DIR__ . '/../../src/CustomerManager.php';

use DTBrand\CustomerManager;

// This page includes customer-table.php and customer-list.js but never used to
// serialise any rows for them, so the only thing it ever displayed was the
// sample roster that customer-list.js carried as a fallback.
$customersList = CustomerManager::getAll();
$activeCount = 0;
foreach ($customersList as $c) {
    if (($c['status'] ?? '') === 'active') $activeCount++;
}

$page_title = "Active Verified Customers";
$active_nav = "customers";
$active_subnav = "active";
$active_filter = "active";
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
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container">
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Active Verified Customers</span>
                            <span class="dt-cust-badge green"><?php echo number_format($activeCount); ?> Active</span>
                        </h1>
                        <p class="dt-cust-subtitle">Shoppers with active accounts, verified mobile numbers, and recent purchase activity.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">← All Customers</a>
                        <a href="/admin/customers/export.php" class="dt-btn dt-btn-gold">Export Active List</a>
                    </div>
                </div>

                <?php include __DIR__ . '/components/customer-stats.php'; ?>
                <?php include __DIR__ . '/components/customer-search.php'; ?>
                <?php include __DIR__ . '/components/customer-table.php'; ?>
            </div>

            <?php include __DIR__ . '/components/customer-filters.php'; ?>
            <?php include __DIR__ . '/components/customer-status.php'; ?>
            <?php include __DIR__ . '/components/bulk-actions.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
    window.dbCustomersData = <?= json_encode($customersList) ?>;
</script>
<script src="/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/customers/assets/js/customer-list.js?v=<?php echo time(); ?>"></script>
<script src="/admin/customers/assets/js/customer-filters.js?v=<?php echo time(); ?>"></script>
<script src="/admin/customers/assets/js/customer-status.js?v=<?php echo time(); ?>"></script>
<script src="/admin/customers/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof filterCustomersByStatus === 'function') {
        filterCustomersByStatus('active');
    }
});
</script>
</body>
</html>
