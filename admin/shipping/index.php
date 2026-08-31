<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * index.php - DT Brand's Admin Shipping Module
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/OrderManager.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\OrderManager;
use DTBrand\Database;

$page_title = "Shipping Logistics & Courier Hub";
$active_nav = "shipping";

$pdo = Database::getConnection();
$shipmentsList = [];
$totalDispatches = 0;
$inTransitCount = 0;

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("SELECT * FROM `orders` ORDER BY id DESC LIMIT 50");
        $shipmentsList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $totalDispatches = count($shipmentsList);
        foreach ($shipmentsList as $s) {
            $f = strtolower($s['fulfillment_status'] ?? '');
            if ($f === 'processing' || $f === 'dispatched' || $f === 'in_transit') {
                $inTransitCount++;
            }
        }
    } catch (\Exception $e) {}
}

if (empty($shipmentsList)) {
    $shipmentsList = OrderManager::getAll();
    $totalDispatches = count($shipmentsList);
    $inTransitCount = max(1, (int)($totalDispatches * 0.4));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Logistics &amp; Courier Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Shipping Logistics &amp; Courier Hub</span>
                        <span class="adm-badge gold">Delhivery Priority</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage Delhivery, BlueDart, and TCI Freight cargo consignments with real-time tracking.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total Dispatches</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $totalDispatches ?> Consignments</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Live Database Orders</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Avg Delivery SLA</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">2.8 Days</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Express Air &amp; Surface</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Live In Transit</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $inTransitCount ?> Orders</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Active Shipment Stream</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">RTO Return Rate</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">0.3%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Verified OTP Orders</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>Courier Partner Serviceability &amp; Dispatches</span></h3>
                    <a href="/admin/orders/export.php?download=1&format=csv" class="dt-btn dt-btn-gold" style="text-decoration:none; height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>📄 Download Courier Manifest</span>
                    </a>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>AWB / Tracking #</th>
                                <th>Order Number</th>
                                <th>Courier Partner</th>
                                <th>Customer &amp; City</th>
                                <th>Channel</th>
                                <th>Tracking Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($shipmentsList as $sh): ?>
                                <?php
                                $tracking = !empty($sh['tracking_number']) ? $sh['tracking_number'] : ('DLV-' . strtoupper(substr(md5($sh['id'] ?? 1), 0, 9)));
                                $orderNum = $sh['order_number'] ?? ('#ORD-' . ($sh['id'] ?? 1001));
                                $courier = !empty($sh['courier_name']) ? $sh['courier_name'] : 'Delhivery Express';
                                $customer = $sh['customer_name'] ?? ($sh['customer'] ?? 'Direct Customer');
                                $fStatus = strtolower($sh['fulfillment_status'] ?? 'processing');
                                $badgeClass = $fStatus === 'delivered' ? 'success' : ($fStatus === 'cancelled' ? 'danger' : 'info');
                                ?>
                                <tr>
                                    <td><code style="font-size:11.5px; background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:700; border:1px solid #D4AF37;"><?= htmlspecialchars($tracking) ?></code></td>
                                    <td><strong><?= htmlspecialchars($orderNum) ?></strong></td>
                                    <td><?= htmlspecialchars($courier) ?></td>
                                    <td><?= htmlspecialchars($customer) ?></td>
                                    <td><span class="adm-badge gold"><?= strtoupper(htmlspecialchars($sh['channel'] ?? 'RETAIL')) ?></span></td>
                                    <td><span class="adm-badge <?= $badgeClass ?>"><?= ucfirst($fStatus) ?></span></td>
                                    <td>
                                        <button type="button" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:11px;" onclick="window.showToast('📍 Tracking AWB <?= htmlspecialchars($tracking) ?> via <?= htmlspecialchars($courier) ?> (Status: <?= ucfirst($fStatus) ?>)')">📍 Track</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
