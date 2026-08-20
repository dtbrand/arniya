<?php
/**
 * view.php — Premium Single Order Details Page
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($_GET['id']) ? trim($_GET['id']) : 'DTB-001624';

// Sample master order model
$order = [
    'id' => $order_id,
    'date' => '21 Aug 2026, 11:20 AM',
    'customer' => 'Rajesh Kumar (Vardhman Tex)',
    'customer_type' => 'Wholesale B2B',
    'phone' => '+91 98220 19283',
    'email' => 'rajesh@vardhmantex.com',
    'status' => 'shipped',
    'amount' => 112250,
    'discount' => 0,
    'payment_method' => 'Bank Wire / RTGS',
    'payment_status' => 'paid',
    'payment_ref' => 'UTR-9821039812',
    'shipping_method' => 'Surat Central Depot Cargo Express',
    'carrier' => 'VRL Logistics',
    'tracking_id' => 'VRL-SURAT-99821',
    'notes' => 'Ship via VRL Ring Road Depot directly to Surat central warehouse.',
    'address' => [
        'billing' => "Shop 42, Textile Market\nRing Road, Surat, Gujarat - 395002\nGSTIN: 24AAECJ1928K1Z5",
        'shipping' => "Godown 12, Transport Nagar\nSurat, Gujarat - 395010\nContact: +91 98220 19283"
    ],
    'items' => [
        [
            'name' => 'Kanjivaram Silk Saree Pure Zari Weave',
            'sku' => 'KNJ-001',
            'variant' => 'Royal Ruby / 5.5m + Blouse',
            'qty' => 25,
            'price' => 4490,
            'img' => '/Shared/Asset/images/product1.png'
        ]
    ]
];

$page_title = "Order " . $order['id'];
$active_nav = "orders";
$active_subnav = "";
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
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/order-view.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/order-status.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-orders-container">
                <!-- Page Top Action Bar -->
                <div class="dt-orders-head">
                    <div class="dt-orders-title-group">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <a href="/Frontend/Admin/orders/index.php" style="color:#64748B; text-decoration:none; font-size:12px; font-weight:700;">← Orders</a>
                            <span style="color:#CBD5E1;">/</span>
                            <h1 class="dt-orders-title" style="margin:0; font-size:18px;">
                                <span>Order #<?php echo htmlspecialchars($order['id']); ?></span>
                            </h1>
                            <span class="dt-status-badge <?php echo $order['status']; ?>">
                                <span class="dt-status-dot"></span>
                                <span><?php echo str_replace('_', ' ', $order['status']); ?></span>
                            </span>
                        </div>
                        <p class="dt-orders-subtitle">Placed on <?php echo $order['date']; ?> • B2B Wholesale Consignment</p>
                    </div>

                    <div class="dt-orders-actions">
                        <a href="/Frontend/Admin/orders/invoice.php?id=<?php echo $order['id']; ?>" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            <span>Tax Invoice</span>
                        </a>
                        <a href="/Frontend/Admin/orders/packing-slip.php?id=<?php echo $order['id']; ?>" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            <span>Packing Slip</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_STATUS.openStatusModal('<?php echo $order['id']; ?>', '<?php echo $order['status']; ?>')">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <span>Update Status</span>
                        </button>
                    </div>
                </div>

                <!-- Visual Order Fulfillment Stepper -->
                <?php include __DIR__ . '/components/order-status-timeline.php'; ?>

                <!-- 2-Column Responsive Order Grid -->
                <div class="dt-view-grid">
                    <!-- Left Column: Line Items, Addresses, Notes -->
                    <div>
                        <?php include __DIR__ . '/components/order-items.php'; ?>
                        <?php include __DIR__ . '/components/order-address.php'; ?>
                        <?php include __DIR__ . '/components/order-notes.php'; ?>
                        <?php include __DIR__ . '/components/order-activity.php'; ?>
                    </div>

                    <!-- Right Column: Financial Summary, Customer Profile, Payment & Shipping -->
                    <div>
                        <?php include __DIR__ . '/components/order-summary.php'; ?>
                        <?php include __DIR__ . '/components/customer-summary.php'; ?>
                        <?php include __DIR__ . '/components/shipping-summary.php'; ?>
                        <?php include __DIR__ . '/components/payment-summary.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Modals -->
            <?php include __DIR__ . '/components/order-actions.php'; ?>
            <?php include __DIR__ . '/components/refund-panel.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/order-view.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/order-status.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/refunds.js?v=<?php echo time(); ?>"></script>
</body>
</html>
