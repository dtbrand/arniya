<?php
/* DT admin access guard */ $__dtg = __DIR__ . '/../includes/adminguard.php'; if (!is_file($__dtg)) $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * resellers.php — VIP Reseller Partner CRM Hub
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
require_once __DIR__ . '/../../src/CustomerManager.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\CustomerManager;
use DTBrand\Database;

$customersList = CustomerManager::getAll();
$resellerCount = 0;
$resellerSpend = 0.0;
foreach ($customersList as $c) {
    if (($c['type'] ?? '') === 'reseller') {
        $resellerCount++;
        $resellerSpend += (float)($c['lifetime_spend'] ?? 0);
    }
}

$page_title = "VIP Resellers CRM";
$active_nav = "customers";
$active_subnav = "resellers";
$active_filter = "reseller";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container">
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>VIP Resellers CRM</span>
                            <span class="dt-cust-badge purple" style="background:#F3E8FF; color:#7E22CE; border:1px solid #D8B4FE;"><?php echo number_format($resellerCount); ?> Resellers</span>
                        </h1>
                        <p class="dt-cust-subtitle">Manage active WhatsApp and social commerce resellers, commission payouts, single-piece dropshipping orders, and 1-click catalogue sharing.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin-right:4px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>All Customers</span>
                        </a>
                        <a href="/admin/customers/export.php?type=reseller" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.3" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export Resellers CSV</span>
                        </a>
                        <a href="/admin/customers/new.php?type=reseller" class="dt-btn dt-btn-dark">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3" style="margin-right:4px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>+ Add Reseller</span>
                        </a>
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
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
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
        filterCustomersByStatus('reseller');
    }
});
</script>
</body>
</html>
