<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * view.php — Premium Single Order Details Page
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/OrderManager.php';

use DTBrand\Database;
use DTBrand\OrderManager;

$order_id = isset($_GET['id']) ? trim($_GET['id']) : '';
$order = null;
$dt_order_error = '';

if ($order_id === '') {
    $dt_order_error = 'No order was requested. Open an order from the list.';
}

$pdo = Database::getConnection();
if ($order_id !== '' && ($pdo === null || Database::isMockMode())) {
    $dt_order_error = 'The database is not reachable, so this order cannot be loaded.';
}

if ($order_id !== '' && $dt_order_error === '') {
    try {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_number = ? OR id = ? LIMIT 1");
        $stmt->execute([$order_id, (int)$order_id]);
        $dbOrder = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$dbOrder) {
            $dt_order_error = 'Order "' . $order_id . '" does not exist.';
        } else {
            // Real line items. This page used to read a non-existent
            // orders.items_json column, so $parsedItems was always empty and every
            // order — however large — displayed one invented line,
            // "Royal Heritage Silk Saree / DT-SR-001", priced at the order total.
            $itemRows = [];
            try {
                $iStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ? ORDER BY id ASC");
                $iStmt->execute([(int)$dbOrder['id']]);
                $itemRows = $iStmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
            } catch (\Exception $ie) {
                $itemRows = [];
            }

            // DT_MARK_ORDER_ITEMS
            $parsedItems = [];
            foreach ($itemRows as $ir) {
                $variantBits = array_filter([
                    trim((string)($ir['variant_color'] ?? '')),
                    trim((string)($ir['variant_size'] ?? '')),
                ], static fn($v) => $v !== '');

                $parsedItems[] = [
                    'name'    => (string)($ir['product_title'] ?? ''),
                    'sku'     => (string)($ir['sku'] ?? ''),
                    // Blank when the shopper chose nothing, instead of the old
                    // invented "Standard 5.5m + Blouse".
                    'variant' => implode(' / ', $variantBits),
                    'qty'     => (int)($ir['quantity'] ?? 0),
                    'price'   => (float)($ir['unit_price'] ?? 0),
                    'total'   => (float)($ir['total_price'] ?? 0),
                    'product_id' => (int)($ir['product_id'] ?? 0),
                    'img'     => '',
                ];
            }

            // Product photos come from the catalogue, so a line shows the real
            // saree or the placeholder - never another product's picture.
            $prodIds = array_values(array_filter(array_map(static fn($i) => $i['product_id'], $parsedItems)));
            if (!empty($prodIds)) {
                try {
                    $ph = implode(',', array_fill(0, count($prodIds), '?'));
                    $pStmt = $pdo->prepare("SELECT id, primary_image FROM products WHERE id IN ({$ph})");
                    $pStmt->execute($prodIds);
                    $imgMap = [];
                    foreach ($pStmt->fetchAll(\PDO::FETCH_ASSOC) as $pr) {
                        $imgMap[(int)$pr['id']] = (string)($pr['primary_image'] ?? '');
                    }
                    foreach ($parsedItems as $k => $pi) {
                        $found = $imgMap[$pi['product_id']] ?? '';
                        $parsedItems[$k]['img'] = $found !== '' ? $found : '/assets/images/no-image.svg';
                    }
                } catch (\Exception $pe) {}
            }

            // DT_MARK_ORDER_ARRAY
            // Every value below is either stored on the row or left empty. The
            // page used to manufacture a phone number, an email, a payment
            // reference (TXN-<md5>), a tracking id (DLV-<md5>), a shipping method
            // and a Surat address for orders that had none of those.
            $custEmail = '';
            if (!empty($dbOrder['customer_id'])) {
                try {
                    $eStmt = $pdo->prepare("SELECT email FROM customers WHERE id = ? LIMIT 1");
                    $eStmt->execute([(int)$dbOrder['customer_id']]);
                    $custEmail = (string)($eStmt->fetchColumn() ?: '');
                } catch (\Exception $ee) {}
            }

            $order = [
                'id' => (string)($dbOrder['order_number'] ?: ('DTB-' . str_pad((string)$dbOrder['id'], 6, '0', STR_PAD_LEFT))),
                'db_id' => (int)$dbOrder['id'],
                'date' => !empty($dbOrder['created_at']) ? date('d M Y, h:i A', strtotime($dbOrder['created_at'])) : '',
                'customer' => (string)($dbOrder['customer_name'] ?? ''),
                'customer_type' => ucfirst((string)($dbOrder['channel'] ?? 'retail')) . ' order',
                'channel' => (string)($dbOrder['channel'] ?? ''),
                'phone' => (string)($dbOrder['customer_phone'] ?? ''),
                'email' => $custEmail,
                'status' => strtolower((string)($dbOrder['fulfillment_status'] ?? 'processing')),
                'amount' => (float)($dbOrder['total_amount'] ?? 0),
                'subtotal' => (float)($dbOrder['subtotal'] ?? 0),
                'discount' => (float)($dbOrder['discount'] ?? 0),
                'gst_rate' => (float)($dbOrder['gst_rate'] ?? 0),
                'gst_amount' => (float)($dbOrder['gst_amount'] ?? 0),
                'shipping_fee' => (float)($dbOrder['shipping_fee'] ?? 0),
                'payment_method' => strtoupper((string)($dbOrder['payment_method'] ?? '')),
                'payment_status' => strtolower((string)($dbOrder['payment_status'] ?? '')),
                'payment_ref' => '',
                'shipping_method' => '',
                'carrier' => (string)($dbOrder['courier_name'] ?? ''),
                'tracking_id' => (string)($dbOrder['tracking_number'] ?? ''),
                'notes' => '',
                'items_count' => count($parsedItems),
                'address' => [
                    'billing' => (string)($dbOrder['shipping_address'] ?? ''),
                    'shipping' => (string)($dbOrder['shipping_address'] ?? ''),
                ],
                'items' => $parsedItems,
            ];
        }
    } catch (\Exception $e) {
        $dt_order_error = 'This order could not be read: ' . $e->getMessage();
    }
}

// A missing order says so. It used to fall through to a fabricated 15-piece
// Rs.54,900 "Wholesale Consignee (Surat Depot)" order, so a mistyped id looked
// like a real consignment.
if (!$order) {
    $dbDown = ($pdo === null || Database::isMockMode());
    http_response_code($dbDown ? 503 : 404);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Order not found</title>';
    echo '<link rel="stylesheet" href="/admin/assets/css/admin.css"></head><body>';
    echo '<div style="max-width:560px;margin:80px auto;padding:28px;border:1.5px solid #D4AF37;border-radius:10px;font-family:system-ui,sans-serif;">';
    echo '<h1 style="font-size:20px;margin:0 0 10px;">Order not found</h1>';
    echo '<p style="color:#646970;">' . htmlspecialchars($dt_order_error ?: 'This order could not be loaded.') . '</p>';
    echo '<p><a href="/admin/orders/index.php">Back to orders</a></p>';
    echo '</div></body></html>';
    exit;
}

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
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
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
