<?php
/**
 * delivered.php — Delivered Orders Filtered View
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Delivered Orders";
$active_nav = "orders";
$active_subnav = "delivered";
$active_status_key = "delivered";
$filter_status = "delivered";
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
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/orders/assets/css/order-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/orders/assets/css/order-status.css?v=<?php echo time(); ?>">
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
                            <span>Delivered Orders</span>
                            <span class="dt-title-counter-badge">
                                <span class="dt-counter-dot" style="background:#15803D; box-shadow:0 0 0 2px rgba(21,128,61,0.2);"></span>
                                <strong>1,542</strong> Delivered (94.9%)
                            </span>
                        </h1>
                        <p class="dt-orders-subtitle">Successfully completed consignments with confirmed recipient signatures and OTP delivery logs.</p>
                    </div>
                    <div class="dt-orders-actions">
                        <a href="/DT%20Brand/admin/orders/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>View All Orders</span>
                        </a>
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

<script src="/DT%20Brand/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/orders/assets/js/order-view.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/orders/assets/js/order-list.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/orders/assets/js/order-filters.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/orders/assets/js/order-status.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/orders/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
</body>
</html>
