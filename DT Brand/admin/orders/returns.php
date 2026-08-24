<?php
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
    <title><?php echo $page_title; ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/order-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/order-status.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/returns.css?v=<?php echo time(); ?>">
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
                            <span>Return Merchandise Authorizations (RMA)</span>
                            <span class="dt-title-counter-badge">
                                <span class="dt-counter-dot" style="background:#B45309; box-shadow:0 0 0 2px rgba(180,83,9,0.2);"></span>
                                <strong>8</strong> Active RMAs
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
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/returns.js?v=<?php echo time(); ?>"></script>
</body>
</html>
