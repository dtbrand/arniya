<?php
/**
 * index.php — Orders & Logistics Fulfillment Center Main Dashboard
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Orders & Logistics Fulfillment Center";
$active_nav = "orders";
$active_subnav = "all";
$active_status_key = "all";
$filter_status = "all";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/order-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/order-status.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-orders-container">
                <!-- Page Header -->
                <div class="dt-orders-head">
                    <div class="dt-orders-title-group">
                        <h1 class="dt-orders-title">
                            <span>Orders &amp; Logistics Fulfillment Center</span>
                            <span class="dt-kpi-badge up" style="font-size:10px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">1,624 Total Orders</span>
                        </h1>
                        <p class="dt-orders-subtitle">Manage wholesale depot dispatches, reseller commissions, and retail parcel deliveries.</p>
                    </div>
                    <div class="dt-orders-actions">
                        <button type="button" class="dt-btn dt-btn-pale" onclick="window.location.reload();">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                            <span>Refresh</span>
                        </button>
                        <a href="/Frontend/Admin/orders/export.php" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export All Orders</span>
                        </a>
                    </div>
                </div>

                <!-- 12-Card KPI Metrics Ribbon -->
                <?php include __DIR__ . '/components/order-stats.php'; ?>

                <!-- Toolbar & Debounced Live Search -->
                <?php include __DIR__ . '/components/order-search.php'; ?>

                <!-- Master Orders Table -->
                <?php include __DIR__ . '/components/order-table.php'; ?>
            </div>

            <!-- Modals & Drawers -->
            <?php include __DIR__ . '/components/order-filters.php'; ?>
            <?php include __DIR__ . '/components/order-actions.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/order-list.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/order-filters.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/order-status.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
</body>
</html>
