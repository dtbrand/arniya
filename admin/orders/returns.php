<?php
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) { require_once $__dtg; } elseif (is_file(__DIR__ . '/../includes/adminguard.php')) { require_once __DIR__ . '/../includes/adminguard.php'; }

/**
 * returns.php — Return Merchandise Authorization (RMA) Management
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Return Requests & RMA Management";
$active_nav = "orders";
$active_subnav = "returns";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> — DT Brand's Admin</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#8A681F">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= @filemtime(__DIR__ . '/../assets/css/admin.css') ?: '3.2.1' ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/orders.css?v=<?= @filemtime(__DIR__ . '/assets/css/orders.css') ?: '3.2.1' ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/order-list.css?v=<?= @filemtime(__DIR__ . '/assets/css/order-list.css') ?: '3.2.1' ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/order-status.css?v=<?= @filemtime(__DIR__ . '/assets/css/order-status.css') ?: '3.2.1' ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/returns.css?v=<?= @filemtime(__DIR__ . '/assets/css/returns.css') ?: '3.2.1' ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-orders-container">
                <div class="dt-orders-head">
                    <div class="dt-orders-title-group">
                        <h1 class="dt-orders-title">
                            <span>Return Merchandise Authorizations (RMA)</span>
                            <span class="dt-title-counter-badge">
                                <span class="dt-counter-dot" style="background:#B45309; box-shadow:0 0 0 2px rgba(180,83,9,0.2);"></span>
<?php
require_once __DIR__ . '/../../src/OrderManager.php';
$orders_all = \DTBrand\OrderManager::getAll();
$matching_count = count(array_filter($orders_all, function($o) {
    return in_array($o['status'] ?? '', ['returned', 'return_requested', 'return_in_transit', 'return_received'], true);
}));
?>
                                <strong><?php echo number_format($matching_count); ?></strong> Active RMAs
                            </span>
                        </h1>
                        <p class="dt-orders-subtitle">Manage customer returns, defect reviews, Surat depot dock inspections, and reverse pickups.</p>
                    </div>
                    <div class="dt-orders-actions">
                        <a href="/admin/orders/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Orders</span>
                        </a>
                    </div>
                </div>

                <?php $current_tab = $_GET['tab'] ?? 'all'; ?>
                <!-- Returns Subnav -->
                <div class="dt-orders-subnav">
                    <a href="/admin/orders/returns.php" class="dt-orders-subnav-pill <?php echo $current_tab === 'all' ? 'active' : ''; ?>">All Returns <small>8</small></a>
                    <a href="/admin/orders/returns.php?tab=requested" class="dt-orders-subnav-pill <?php echo $current_tab === 'requested' ? 'active' : ''; ?>">Requested <small>2</small></a>
                    <a href="/admin/orders/returns.php?tab=approved" class="dt-orders-subnav-pill <?php echo $current_tab === 'approved' ? 'active' : ''; ?>">Approved for Pickup <small>3</small></a>
                    <a href="/admin/orders/returns.php?tab=received" class="dt-orders-subnav-pill <?php echo $current_tab === 'received' ? 'active' : ''; ?>">Depot Inspection <small>2</small></a>
                    <a href="/admin/orders/returns.php?tab=completed" class="dt-orders-subnav-pill <?php echo $current_tab === 'completed' ? 'active' : ''; ?>">Completed <small>1</small></a>
                </div>

                <!-- Return Table Panel -->
                <?php include __DIR__ . '/components/return-panel.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/orders/assets/js/orders.js?v=<?= @filemtime(__DIR__ . '/assets/js/orders.js') ?: '3.2.1' ?>"></script>
<script src="/admin/orders/assets/js/returns.js?v=<?= @filemtime(__DIR__ . '/assets/js/returns.js') ?: '3.2.1' ?>"></script>
</body>
</html>
