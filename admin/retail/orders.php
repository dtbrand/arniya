<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * orders.php — DT Brand's & Jai Hanuman Tex
 * Retail Orders Management
 */
$page_title = "Retail Orders";
$active_nav = "retail";
$active_subnav = "orders";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Orders - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/retail/assets/css/retail-orders.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-retail-container">
                <div class="dt-retail-head">
                    <div>
                        <h1 class="dt-retail-title">
                            <span>Retail Orders &amp; Dispatches</span>
                            <span class="dt-status-pill-clean emerald">1,624 Orders</span>
                        </h1>
                        <p class="dt-retail-subtitle">Direct retail customer orders, payment receipts, and express courier fulfillments.</p>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <a href="/admin/orders/" class="dt-btn dt-btn-gold">
                            <span>All Orders Suite →</span>
                        </a>
                    </div>
                </div>

                <?php include_once __DIR__ . '/components/retail-order-table.php'; ?>
            </div>

        </main>
    </div>
</div>

<?php include_once __DIR__ . '/components/bulk-actions.php'; ?>

<script src="/admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
<script src="/admin/retail/assets/js/retail-orders.js?v=<?php echo time(); ?>"></script>
<script src="/admin/retail/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
</body>
</html>
