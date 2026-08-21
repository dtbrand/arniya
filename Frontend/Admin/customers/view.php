<?php
/**
 * view.php — Customer 360° Profile & Deep Dossier
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$customer_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'CUST-1042';
$page_title = "Customer 360° Dossier #" . $customer_id;
$active_nav = "customers";
$active_subnav = "view";
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-view.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-profile.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container">
                <!-- Page Top Navigation Bar -->
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer 360° Dossier</span>
                            <span class="dt-cust-badge gold">#<?php echo $customer_id; ?></span>
                        </h1>
                        <p class="dt-cust-subtitle">Comprehensive overview of lifetime orders, address book, internal notes, and activity timeline.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/Frontend/Admin/customers/index.php" class="dt-btn dt-btn-pale">← Back to Customers</a>
                        <a href="/Frontend/Admin/customers/edit.php?id=<?php echo $customer_id; ?>" class="dt-btn dt-btn-gold">Edit Customer</a>
                    </div>
                </div>

                <!-- 2-Column Responsive Dossier Grid -->
                <div class="dt-cust-dossier-grid">
                    <!-- Left Column: Identity Card -->
                    <?php include __DIR__ . '/components/customer-profile.php'; ?>

                    <!-- Right Column: Main Tabbed Content Area -->
                    <div class="dt-cust-main-pane">
                        <!-- Top Financial Strip -->
                        <?php include __DIR__ . '/components/customer-summary.php'; ?>

                        <!-- Interactive Tab Navigator -->
                        <div class="dt-cust-tab-nav">
                            <button type="button" class="dt-cust-tab-btn active" onclick="switchCustomerTab('orders', this)">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path></svg>
                                <span>Order History</span>
                                <span class="dt-cust-tab-badge">6</span>
                            </button>

                            <button type="button" class="dt-cust-tab-btn" onclick="switchCustomerTab('addresses', this)">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Saved Addresses</span>
                                <span class="dt-cust-tab-badge">2</span>
                            </button>

                            <button type="button" class="dt-cust-tab-btn" onclick="switchCustomerTab('activity', this)">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                                <span>Audit Timeline</span>
                            </button>

                            <button type="button" class="dt-cust-tab-btn" onclick="switchCustomerTab('notes', this)">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                <span>Staff Notes</span>
                                <span class="dt-cust-tab-badge">2</span>
                            </button>
                        </div>

                        <!-- Tab Panes -->
                        <div class="dt-cust-tab-content">
                            <div id="dtCustTabPane-orders" class="dt-cust-tab-pane" style="display:block;">
                                <?php include __DIR__ . '/components/customer-orders.php'; ?>
                            </div>

                            <div id="dtCustTabPane-addresses" class="dt-cust-tab-pane" style="display:none;">
                                <?php include __DIR__ . '/components/customer-addresses.php'; ?>
                            </div>

                            <div id="dtCustTabPane-activity" class="dt-cust-tab-pane" style="display:none;">
                                <?php include __DIR__ . '/components/customer-activity.php'; ?>
                            </div>

                            <div id="dtCustTabPane-notes" class="dt-cust-tab-pane" style="display:none;">
                                <?php include __DIR__ . '/components/customer-notes.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Modal -->
            <?php include __DIR__ . '/components/customer-status.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/customers/assets/js/customer-view.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/customers/assets/js/customer-status.js?v=<?php echo time(); ?>"></script>
</body>
</html>
