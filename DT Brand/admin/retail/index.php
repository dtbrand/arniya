<?php
/**
 * index.php — DT Brand's & Jai Hanuman Tex
 * Master Retail Management Dashboard
 */
$page_title = "Retail Management Hub";
$active_nav = "retail";
$active_subnav = "dashboard";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Management - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/retail/assets/css/retail-dashboard.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/retail/assets/css/retail-analytics.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-retail-container">
                <!-- ══ TOP HEADER ══ -->
                <div class="dt-retail-head">
                    <div>
                        <h1 class="dt-retail-title">
                            <span>Retail Management</span>
                            <span class="dt-status-pill-clean gold">Direct-to-Consumer Suite</span>
                        </h1>
                        <p class="dt-retail-subtitle">Manage DT Brands retail sales, customers, orders and shopping activity.</p>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/DT%20Brand/admin/retail/customers.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                            <span>Retail Customers</span>
                        </a>
                        <a href="/DT%20Brand/admin/retail/orders.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                            <span>Retail Orders</span>
                        </a>
                        <a href="/DT%20Brand/admin/retail/export.php" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export Studio</span>
                        </a>
                    </div>
                </div>

                <!-- ══ 12-CARD MASTER KPI RIBBON ══ -->
                <?php include_once __DIR__ . '/components/retail-stats.php'; ?>

                <!-- ══ SALES VELOCITY CHART ══ -->
                <?php include_once __DIR__ . '/components/retail-sales-chart.php'; ?>

                <!-- ══ RECENT RETAIL ORDERS TABLE ══ -->
                <?php include_once __DIR__ . '/components/retail-order-table.php'; ?>

                <!-- ══ RETAIL CUSTOMER DIRECTORY PREVIEW ══ -->
                <?php include_once __DIR__ . '/components/retail-customer-table.php'; ?>

                <!-- ══ 7-STEP CHECKOUT FUNNEL ══ -->
                <?php include_once __DIR__ . '/components/retail-checkout.php'; ?>

                <!-- ══ ABANDONED CARTS RECOVERY ══ -->
                <?php include_once __DIR__ . '/components/abandoned-cart-table.php'; ?>

            </div>

        </main>
    </div>
</div>

<?php include_once __DIR__ . '/components/bulk-actions.php'; ?>

<script src="/DT%20Brand/admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/retail/assets/js/retail-dashboard.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/retail/assets/js/retail-customers.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/retail/assets/js/retail-orders.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/retail/assets/js/retail-cart.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/retail/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
</body>
</html>
