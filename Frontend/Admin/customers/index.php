<?php
/**
 * index.php — Customer Management Master Dashboard & Directory
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
require_once __DIR__ . '/../../../src/CustomerManager.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\CustomerManager;
use DTBrand\Database;

$customersList = CustomerManager::getAll();
$totalCustomersCount = count($customersList);

$page_title = "Customer CRM & Directory";
$active_nav = "customers";
$active_subnav = "all";
$active_filter = "all";
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container">
                <!-- Page Header -->
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer CRM &amp; Shopper Directory</span>
                            <span class="dt-cust-badge gold"><?php echo number_format($totalCustomersCount); ?> Shoppers</span>
                        </h1>
                        <p class="dt-cust-subtitle">Manage retail customer profiles, lifetime purchases, repeat loyalty, and 1-click WhatsApp connect.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <button type="button" class="dt-btn dt-btn-pale" onclick="window.location.reload();">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                            <span>Refresh</span>
                        </button>
                        <a href="/Frontend/Admin/customers/export.php" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export All Shoppers</span>
                        </a>
                    </div>
                </div>

                <!-- 8-Card KPI Ribbon & Flow Pills -->
                <?php include __DIR__ . '/components/customer-stats.php'; ?>

                <!-- Toolbar & Debounced Live Search -->
                <?php include __DIR__ . '/components/customer-search.php'; ?>

                <!-- Master Customers Table -->
                <?php include __DIR__ . '/components/customer-table.php'; ?>
            </div>

            <!-- Modals & Drawers -->
            <?php include __DIR__ . '/components/customer-filters.php'; ?>
            <?php include __DIR__ . '/components/customer-status.php'; ?>
            <?php include __DIR__ . '/components/bulk-actions.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/customers/assets/js/customer-list.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/customers/assets/js/customer-filters.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/customers/assets/js/customer-status.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/customers/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
</body>
</html>
