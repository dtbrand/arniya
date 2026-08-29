<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * refunded.php — Refunded Orders Filtered View
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Refunded Orders";
$active_nav = "orders";
$active_subnav = "refunded";
$active_status_key = "refunded";
$filter_status = "refunded";
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
                            <span>Refunded Orders &amp; Credit Notes</span>
                            <span class="dt-title-counter-badge">
                                <span class="dt-counter-dot" style="background:#8A681F; box-shadow:0 0 0 2px rgba(138,104,31,0.2);"></span>
                                <strong>6</strong> Refunded
                            </span>
                        </h1>
                        <p class="dt-orders-subtitle">Orders with settled refunds processed through original gateways or B2B credit ledger adjustments.</p>
                    </div>
                    <div class="dt-orders-actions">
                        <a href="/admin/orders/refunds.php" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            <span>Manage Refunds Ledger</span>
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
