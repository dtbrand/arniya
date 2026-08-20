<?php
/**
 * refunds.php — Refund Management & Credit Notes Ledger
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Refund Management & Credit Notes";
$active_nav = "orders";
$active_subnav = "refunds";
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/order-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/order-status.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/refunds.css?v=<?php echo time(); ?>">
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
                            <span>Refunds &amp; Credit Notes Ledger</span>
                            <span class="dt-status-badge refunded"><span class="dt-status-dot"></span><span>₹24,420 Settled</span></span>
                        </h1>
                        <p class="dt-orders-subtitle">Track gateway payouts, UPI chargeback reversals, and B2B wholesale credit ledger balances.</p>
                    </div>
                    <div class="dt-orders-actions">
                        <a href="/Frontend/Admin/orders/index.php" class="dt-btn dt-btn-pale">← Back to Orders</a>
                    </div>
                </div>

                <!-- Refund Subnav -->
                <div class="dt-orders-subnav">
                    <a href="/Frontend/Admin/orders/refunds.php" class="dt-orders-subnav-pill active">All Refunds <small>6</small></a>
                    <a href="/Frontend/Admin/orders/refunds.php?tab=pending" class="dt-orders-subnav-pill">Pending Approval <small>1</small></a>
                    <a href="/Frontend/Admin/orders/refunds.php?tab=processing" class="dt-orders-subnav-pill">Gateway Processing <small>2</small></a>
                    <a href="/Frontend/Admin/orders/refunds.php?tab=settled" class="dt-orders-subnav-pill">Settled <small>3</small></a>
                </div>

                <!-- Refund Table Card -->
                <div class="dt-order-table-card">
                    <div class="dt-table-responsive">
                        <table class="dt-order-table">
                            <thead>
                                <tr>
                                    <th>Refund ID</th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Payout Method</th>
                                    <th>Refund Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-weight:800; color:#8A681F;">REF-4012</td>
                                    <td><a href="/Frontend/Admin/orders/view.php?id=DTB-001612" class="dt-order-id-link">DTB-001612</a></td>
                                    <td style="font-weight:700; color:#181512;">Meenakshi Silk House</td>
                                    <td style="font-size:11px; color:#475569;">ICICI Direct Bank Transfer</td>
                                    <td style="font-weight:800; color:#DC2626;">₹14,940</td>
                                    <td><span class="dt-status-badge delivered"><span class="dt-status-dot"></span><span>Settled</span></span></td>
                                    <td style="font-size:11px; color:#64748B;">20 Aug 2026</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:800; color:#8A681F;">REF-4011</td>
                                    <td><a href="/Frontend/Admin/orders/view.php?id=DTB-001609" class="dt-order-id-link">DTB-001609</a></td>
                                    <td style="font-weight:700; color:#181512;">Shweta Joshi</td>
                                    <td style="font-size:11px; color:#475569;">UPI Reversal (PhonePe)</td>
                                    <td style="font-weight:800; color:#DC2626;">₹4,990</td>
                                    <td><span class="dt-status-badge processing"><span class="dt-status-dot"></span><span>In Gateway</span></span></td>
                                    <td style="font-size:11px; color:#64748B;">19 Aug 2026</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php include __DIR__ . '/components/refund-panel.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/refunds.js?v=<?php echo time(); ?>"></script>
</body>
</html>
