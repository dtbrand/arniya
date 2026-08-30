<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * shipped.php — Shipped Orders Filtered View
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Shipped Orders";
$active_nav = "orders";
$active_subnav = "shipped";
$active_status_key = "shipped";
$filter_status = "shipped";
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
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/order-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/order-status.css?v=<?php echo time(); ?>">
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
                            <span>Dispatched &amp; In-Transit Consignments</span>
                            <span class="dt-title-counter-badge">
                                <span class="dt-counter-dot" style="background:#1D4ED8; box-shadow:0 0 0 2px rgba(29,78,216,0.2);"></span>
                                <strong>84</strong> Shipped
                            </span>
                        </h1>
                        <p class="dt-orders-subtitle">Active carrier consignments en route via VRL Logistics, BlueDart, Delhivery, and DTDC.</p>
                    </div>
                    <div class="dt-orders-actions">
                        <a href="/admin/orders/index.php" class="dt-btn dt-btn-pale">
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

<script src="/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/order-view.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/order-list.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/order-filters.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/order-status.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
</body>
</html>
