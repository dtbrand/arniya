<?php
/**
 * customers.php — DT Brand's & Jai Hanuman Tex
 * Retail Customer Management Directory
 */
$page_title = "Retail Customers";
$active_nav = "retail";
$active_subnav = "customers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Customers - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/retail/assets/css/retail-customers.css?v=<?php echo time(); ?>">
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
                            <span>Retail Customers</span>
                            <span class="dt-status-pill-clean gold">4,820 Profiles</span>
                        </h1>
                        <p class="dt-retail-subtitle">Direct consumers, ordering frequency, lifetime spending, and loyalty tiers.</p>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <a href="/Frontend/Admin/retail/segments.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a10 10 0 0 1 10 10"></path></svg>
                            <span>Customer Segments</span>
                        </a>
                        <a href="/Frontend/Admin/customers/" class="dt-btn dt-btn-gold">
                            <span>All CRM Customers →</span>
                        </a>
                    </div>
                </div>

                <?php include_once __DIR__ . '/components/retail-customer-table.php'; ?>
            </div>

        </main>
    </div>
</div>

<?php include_once __DIR__ . '/components/bulk-actions.php'; ?>

<script src="/Frontend/Admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/retail/assets/js/retail-customers.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/retail/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
</body>
</html>
