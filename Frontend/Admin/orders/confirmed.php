<?php
/**
 * confirmed.php — Confirmed Orders Filtered View
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Confirmed Orders";
$active_nav = "orders";
$active_subnav = "confirmed";
$active_status_key = "confirmed";
$filter_status = "confirmed";
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
                <div class="dt-orders-head">
                    <div class="dt-orders-title-group">
                        <h1 class="dt-orders-title">
                            <span>Payment Confirmed Orders</span>
                            <span class="dt-status-badge confirmed"><span class="dt-status-dot"></span><span>42 Confirmed</span></span>
                        </h1>
                        <p class="dt-orders-subtitle">Orders with verified payments ready for fulfillment and loom allocation.</p>
                    </div>
                    <div class="dt-orders-actions">
                        <a href="/Frontend/Admin/orders/index.php" class="dt-btn dt-btn-pale">← View All Orders</a>
                    </div>
                </div>

                <?php include __DIR__ . '/components/order-stats.php'; ?>
                <?php include __DIR__ . '/components/order-search.php'; ?>
                <?php include __DIR__ . '/components/order-table.php'; ?>
            </div>

            <?php include __DIR__ . '/components/order-drawer.php'; ?>
            <?php include __DIR__ . '/components/order-filters.php'; ?>
            <?php include __DIR__ . '/components/order-actions.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/order-view.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/order-list.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/order-filters.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/order-status.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
</body>
</html>
