<?php
/**
 * inactive.php — Inactive & Dormant Customer Accounts Hub
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$page_title = "Inactive & Dormant Customers";
$active_nav = "customers";
$active_subnav = "inactive";
$active_filter = "inactive";
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
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container">
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Inactive &amp; Dormant Customers</span>
                            <span class="dt-cust-badge" style="background:#FEF3C7; color:#B45309; border:1px solid #FCD34D;">640 Dormant</span>
                        </h1>
                        <p class="dt-cust-subtitle">Shoppers with no purchases in the last 60+ days or accounts pending re-engagement campaigns.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/DT%20Brand/admin/customers/index.php" class="dt-btn dt-btn-pale">← All Customers</a>
                        <a href="/DT%20Brand/admin/customers/export.php" class="dt-btn dt-btn-gold">Export Dormant List</a>
                    </div>
                </div>

                <?php include __DIR__ . '/components/customer-stats.php'; ?>
                <?php include __DIR__ . '/components/customer-search.php'; ?>
                <?php include __DIR__ . '/components/customer-table.php'; ?>
            </div>

            <?php include __DIR__ . '/components/customer-filters.php'; ?>
            <?php include __DIR__ . '/components/customer-status.php'; ?>
            <?php include __DIR__ . '/components/bulk-actions.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/DT%20Brand/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/customers/assets/js/customer-list.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/customers/assets/js/customer-filters.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/customers/assets/js/customer-status.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/customers/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof filterCustomersByStatus === 'function') {
        filterCustomersByStatus('inactive');
    }
});
</script>
</body>
</html>
