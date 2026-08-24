<?php
/**
 * view.php — Premium Single Order Details Page
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($_GET['id']) ? trim($_GET['id']) : 'DTB-001624';

// Complete master order dictionary
$all_orders_data = [
    'DTB-001624' => [
        'id' => 'DTB-001624',
        'date' => '21 Aug 2026, 11:20 AM',
        'customer' => 'Rajesh Kumar (Vardhman Tex)',
        'customer_type' => 'Wholesale B2B Reseller',
        'phone' => '+91 98220 19283',
        'email' => 'rajesh@vardhmantex.com',
        'status' => 'cancelled',
        'amount' => 112250,
        'discount' => 0,
        'payment_method' => 'Bank Wire / RTGS',
        'payment_status' => 'paid',
        'payment_ref' => 'UTR-9821039812',
        'shipping_method' => 'Surat Central Depot Cargo Express',
        'carrier' => 'VRL Logistics Depot',
        'tracking_id' => 'VRL-99821',
        'notes' => 'Consignment cancelled per buyer request due to logistics schedule change.',
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
                'img' => '/assets/images/product1.png'
            ]
        ]
    ],
    'DTB-001623' => [
        'id' => 'DTB-001623',
        'date' => '21 Aug 2026, 10:45 AM',
        'customer' => 'Pooja Sharma',
        'customer_type' => 'Retail Customer (B2C)',
        'phone' => '+91 98765 43210',
        'email' => 'pooja.sharma@gmail.com',
        'status' => 'delivered',
        'amount' => 4990,
        'discount' => 0,
        'payment_method' => 'UPI / PhonePe',
        'payment_status' => 'paid',
        'payment_ref' => 'UPI-99210982-Pay',
        'shipping_method' => 'BlueDart Air Express',
        'carrier' => 'BlueDart Express',
        'tracking_id' => 'BD-88291',
        'notes' => 'Parcel delivered safely at customer residence with digital OTP verification.',
        'address' => [
            'billing' => "Flat 402, Lotus Heights\nAndheri West, Mumbai, Maharashtra - 400053",
            'shipping' => "Flat 402, Lotus Heights\nAndheri West, Mumbai, Maharashtra - 400053\nContact: +91 98765 43210"
        ],
        'items' => [
            [
                'name' => 'Banarasi Katan Pure Silk Festive Saree',
                'sku' => 'BNR-012',
                'variant' => 'Emerald Green / 5.5m',
                'qty' => 1,
                'price' => 4990,
                'img' => '/assets/images/product2.png'
            ]
        ]
    ],
    'DTB-001622' => [
        'id' => 'DTB-001622',
        'date' => '20 Aug 2026, 04:30 PM',
        'customer' => 'Surat Central Saree Depot (Direct Consignment)',
        'customer_type' => 'B2B Wholesale Lot',
        'phone' => '+91 98250 88771',
        'email' => 'orders@suratdepot.com',
        'status' => 'packed',
        'amount' => 38900,
        'discount' => 0,
        'payment_method' => 'Bank Wire / RTGS',
        'payment_status' => 'paid',
        'payment_ref' => 'UTR-10928374',
        'shipping_method' => 'DTDC Express Cargo',
        'carrier' => 'DTDC Priority',
        'tracking_id' => 'DTDC-4491',
        'notes' => 'Packed in 2 heavy-duty tamper-proof master cartons. Ready for dispatch.',
        'address' => [
            'billing' => "Unit 10, Ring Road Textile Market\nSurat, Gujarat - 395002\nGSTIN: 24BBDPT9981K1Z2",
            'shipping' => "Godown B, Transport Nagar\nSurat, Gujarat - 395010"
        ],
        'items' => [
            [
                'name' => 'Chanderi Zari Handloom Cotton Silk Saree',
                'sku' => 'CHN-044',
                'variant' => 'Mustard Gold / Assorted Lot',
                'qty' => 10,
                'price' => 3890,
                'img' => '/assets/images/product3.png'
            ]
        ]
    ]
];

// Fallback to master template if ID not in predefined map
$order = isset($all_orders_data[$order_id]) ? $all_orders_data[$order_id] : [
    'id' => $order_id,
    'date' => '21 Aug 2026, 11:20 AM',
    'customer' => 'Wholesale Consignee (Surat Depot)',
    'customer_type' => 'Wholesale B2B Reseller',
    'phone' => '+91 98220 19283',
    'email' => 'orders@dtbrands.in',
    'status' => 'processing',
    'amount' => 54900,
    'discount' => 0,
    'payment_method' => 'Bank Wire / RTGS',
    'payment_status' => 'paid',
    'payment_ref' => 'UTR-' . substr(md5($order_id), 0, 10),
    'shipping_method' => 'Surat Central Depot Cargo Express',
    'carrier' => 'VRL Logistics Depot',
    'tracking_id' => 'VRL-' . substr($order_id, -5),
    'notes' => 'Verified order manifest. Ready for Surat central dispatch.',
    'address' => [
        'billing' => "Shop 42, Textile Market\nRing Road, Surat, Gujarat - 395002",
        'shipping' => "Godown 12, Transport Nagar\nSurat, Gujarat - 395010"
    ],
    'items' => [
        [
            'name' => 'Surat Pure Silk Festive Collection Lot',
            'sku' => 'SRT-099',
            'variant' => 'Assorted Handloom / 5.5m',
            'qty' => 15,
            'price' => 3660,
            'img' => '/assets/images/product1.png'
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
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/order-view.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/order-status.css?v=<?php echo time(); ?>">
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
                            <a href="/admin/orders/index.php" style="color:#64748B; text-decoration:none; font-size:12px; font-weight:700;">← Orders</a>
                            <span style="color:#CBD5E1;">/</span>
                            <h1 class="dt-orders-title" style="margin:0; font-size:18px;">
                                <span>Order #<?php echo htmlspecialchars($order['id']); ?></span>
                            </h1>
                            <span id="viewPageStatusBadge" data-order-id="<?php echo $order['id']; ?>" class="dt-status-badge <?php echo $order['status']; ?>">
                                <span class="dt-status-dot"></span>
                                <span><?php echo str_replace('_', ' ', $order['status']); ?></span>
                            </span>
                        </div>
                        <p class="dt-orders-subtitle">Placed on <?php echo $order['date']; ?> • B2B Wholesale Consignment</p>
                    </div>

                    <div class="dt-orders-actions">
                        <a href="/admin/orders/invoice.php?id=<?php echo $order['id']; ?>" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            <span>Tax Invoice</span>
                        </a>
                        <a href="/admin/orders/packing-slip.php?id=<?php echo $order['id']; ?>" class="dt-btn dt-btn-pale">
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
            <?php include __DIR__ . '/components/customer-ledger.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/order-view.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/order-status.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/refunds.js?v=<?php echo time(); ?>"></script>
</body>
</html>
