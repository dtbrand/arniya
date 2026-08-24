<?php
/**
 * addresses.php — Customer Address Book Management
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$page_title = "Customer Saved Addresses";
$active_nav = "customers";
$active_subnav = "addresses";
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
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-profile.css?v=<?php echo time(); ?>">
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
                            <span>Customer Address Books</span>
                            <span class="dt-cust-badge gold">Shipping &amp; Billing</span>
                        </h1>
                        <p class="dt-cust-subtitle">Verify pin codes, state tax jurisdictions, and courier dispatch addresses.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">← Back to Directory</a>
                    </div>
                </div>

                <div class="dt-card">
                    <?php include __DIR__ . '/components/customer-addresses.php'; ?>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
</body>
</html>
