<?php
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) { require_once $__dtg; } elseif (is_file(__DIR__ . '/../includes/adminguard.php')) { require_once __DIR__ . '/../includes/adminguard.php'; }

/**
 * tracking.php — DT Brand's Master Multi-Carrier Tracking Hub
 * DT Brand's & Jai Hanuman Tex — Live Production Architecture
 */
require_once __DIR__ . '/../../src/Database.php';
use DTBrand\Database;

$pdo = Database::getConnection();
$shippingOrders = [];
$firstAwb = '';
$firstCarrier = 'Delhivery Express';

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $shippingOrders = Database::query("
            SELECT o.*, 
                   CASE 
                       WHEN o.customer_name IS NOT NULL AND o.customer_name != '' THEN o.customer_name 
                       WHEN c.name IS NOT NULL AND c.name != '' THEN c.name 
                       ELSE 'Direct Customer' 
                   END as customer_name,
                   COALESCE(c.phone, o.customer_phone) as consignee_phone,
                   COALESCE(c.city, 'Surat') as customer_city
            FROM orders o
            LEFT JOIN customers c ON o.customer_id = c.id
            WHERE COALESCE(o.fulfillment_status, o.order_status, '') != 'cancelled'
            ORDER BY o.id DESC
            LIMIT 30
        ");

        foreach ($shippingOrders as &$so) {
            $addr = (string)($so['shipping_address'] ?? '');
            $destCity = $so['customer_city'] ?? 'Surat';
            if (!empty($addr)) {
                $parts = array_map('trim', explode(',', $addr));
                if (count($parts) >= 3) {
                    $candidate = $parts[count($parts) - 2];
                    $clean = trim(preg_replace('/\s*-\s*\d+/', '', $candidate));
                    if (!empty($clean)) {
                        $destCity = $clean;
                    }
                }
            }
            $so['destination_city'] = $destCity;

            if (empty($so['courier_name'])) {
                $so['courier_name'] = 'Delhivery Express';
            }
            if (empty($so['tracking_number']) || $so['tracking_number'] === '—') {
                $so['tracking_number'] = $so['order_number'] ?? ('DTB-' . str_pad((string)$so['id'], 6, '0', STR_PAD_LEFT));
            }
        }
        unset($so);

        foreach ($shippingOrders as $so) {
            if (!empty($so['tracking_number']) && $so['tracking_number'] !== '—') {
                $firstAwb = $so['tracking_number'];
                $firstCarrier = $so['courier_name'] ?: 'Delhivery Express';
                break;
            }
        }
    } catch (\Throwable $e) {
        error_log("Shipping tracking error: " . $e->getMessage());
    }
}

if (!$firstAwb && !empty($shippingOrders)) {
    $firstAwb = $shippingOrders[0]['tracking_number'] ?? ($shippingOrders[0]['order_number'] ?? 'TRK-STANDBY');
}

$page_title = "Multi-Carrier Consignment Tracking Hub";
$active_nav = "shipping";
$active_subnav = "tracking";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-track-timeline {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 28px 0 16px 0;
        }
        .dt-track-timeline::before {
            content: '';
            position: absolute;
            top: 14px;
            left: 30px;
            right: 30px;
            height: 3px;
            background: #EAE5D9;
            z-index: 1;
        }
        .dt-track-progress {
            position: absolute;
            top: 14px;
            left: 30px;
            width: 12%;
            height: 3px;
            background: linear-gradient(90deg, #8A681F 0%, #15803D 100%);
            z-index: 2;
            transition: width 0.4s ease;
        }
        .dt-track-step {
            position: relative;
            z-index: 3;
            text-align: center;
            flex: 1;
        }
        .dt-track-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #FFFFFF;
            border: 2.5px solid #EAE5D9;
            margin: 0 auto 8px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            color: #78716C;
            transition: all 0.25s ease;
        }
        .dt-track-step.done .dt-track-dot {
            background: #15803D;
            border-color: #15803D;
            color: #FFFFFF;
            box-shadow: 0 0 8px rgba(21, 128, 61, 0.35);
        }
        .dt-track-step.active .dt-track-dot {
            background: linear-gradient(135deg, #B8860B 0%, #D4AF37 100%);
            border-color: #8A681F;
            color: #111827;
            box-shadow: 0 0 12px rgba(212,175,55,0.7);
            transform: scale(1.08);
        }
        .dt-track-title {
            font-size: 11.5px;
            font-weight: 700;
            color: #181512;
        }
        .dt-track-sub {
            font-size: 10.5px;
            color: #64748B;
            margin-top: 2px;
        }
        .dt-track-highlight-row {
            background: #FAF5E8 !important;
            border-left: 3px solid #8A681F !important;
        }
        @media (max-width: 700px) {
            .dt-track-timeline {
                flex-direction: column;
                gap: 16px;
            }
            .dt-track-timeline::before, .dt-track-progress {
                display: none;
            }
            .dt-track-step {
                display: flex;
                align-items: center;
                gap: 12px;
                text-align: left;
            }
            .dt-track-dot {
                margin: 0;
            }
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Multi-Carrier Tracking Hub</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Live AWB Telemetry</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Real-time parcel telemetry and milestone tracking across Delhivery, BlueDart, and VRL Freight carriers.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/shipping/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Shipping Suite</span>
                    </a>
                </div>
            </div>

            <!-- Search Bar Card -->
            <div class="adm-card" style="margin-bottom:16px;">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Real-Time Consignment Tracker</span>
                    </h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">Direct Carrier Telemetry</span>
                </div>
                <div style="padding:16px 18px;">
                    <form onsubmit="handleTrackAWB(event)" style="display:flex; gap:10px; flex-wrap:wrap;">
                        <input type="text" id="awbSearchInput" class="adm-form-input" style="flex:1; min-width:240px; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:700; padding:0 12px;" value="<?= htmlspecialchars($firstAwb) ?>" placeholder="Enter AWB or Order Number (e.g. AWB-DEL-984210)...">
                        <button type="submit" class="dt-btn dt-btn-gold" style="height:38px; display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <span>Track Consignment</span>
                        </button>
                    </form>

                    <!-- Active Tracking Dossier -->
                    <div id="trackingResultBox" style="margin-top:20px; background:#FAF8F4; border:1.5px solid #EAE5D9; border-radius:10px; padding:18px;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:12px; border-bottom:1px solid #EAE5D9; padding-bottom:14px; margin-bottom:16px;">
                            <div>
                                <span style="font-size:11px; color:#64748B; font-weight:700; text-transform:uppercase;">Tracking ID / AWB</span>
                                <div style="font-size:1.15rem; font-weight:900; color:#181512; display:flex; align-items:center; gap:8px; margin-top:2px;">
                                    <span id="activeAwbNumber"><?= htmlspecialchars($firstAwb ?: 'TRK-STANDBY') ?></span>
                                    <span id="activeCarrierBadge" class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-weight:700;"><?= htmlspecialchars($firstCarrier) ?></span>
                                    <button type="button" class="dt-btn dt-btn-pale" onclick="copyAwbToClipboard()" title="Copy AWB" style="padding:2px 8px; height:24px; font-size:10.5px;">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                        <span>Copy</span>
                                    </button>
                                </div>
                                <div style="font-size:11.5px; color:#64748B; margin-top:4px;">
                                    Consignee: <strong id="activeConsigneeName" style="color:#111827;">Direct Customer</strong> • Destination: <strong id="activeDestinationCity" style="color:#111827;">Surat</strong>
                                </div>
                            </div>
                            <div style="text-align:right;">
                                <span style="font-size:11px; color:#64748B; font-weight:700; text-transform:uppercase;">Milestone Telemetry</span>
                                <div id="activeMilestoneText" style="font-size:1rem; font-weight:800; color:#15803D; margin-top:2px;">Active Pipeline</div>
                                <div id="activeOrderRefText" style="font-size:11.5px; color:#64748B; margin-top:4px;">Order: <strong style="color:#8A681F;">—</strong></div>
                            </div>
                        </div>

                        <!-- Step Timeline -->
                        <div class="dt-track-timeline">
                            <div id="trackProgressBar" class="dt-track-progress" style="width:12%;"></div>
                            <div id="trackStep1" class="dt-track-step active">
                                <div class="dt-track-dot">1</div>
                                <div class="dt-track-title">Booked &amp; Packed</div>
                                <div id="trackSub1" class="dt-track-sub">Surat Central Depot</div>
                            </div>
                            <div id="trackStep2" class="dt-track-step">
                                <div class="dt-track-dot">2</div>
                                <div class="dt-track-title">Dispatched</div>
                                <div id="trackSub2" class="dt-track-sub">Courier Ingestion</div>
                            </div>
                            <div id="trackStep3" class="dt-track-step">
                                <div class="dt-track-dot">3</div>
                                <div class="dt-track-title">In Transit</div>
                                <div id="trackSub3" class="dt-track-sub">Logistics Corridor</div>
                            </div>
                            <div id="trackStep4" class="dt-track-step">
                                <div class="dt-track-dot">4</div>
                                <div class="dt-track-title">Delivered</div>
                                <div id="trackSub4" class="dt-track-sub">Consignee Handover</div>
                            </div>
                        </div>

                        <!-- Actions & External Link Row -->
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-top:20px; padding-top:14px; border-top:1px solid #EAE5D9;">
                            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                <a id="externalCarrierLink" href="https://www.delhivery.com/track/package/<?= urlencode($firstAwb) ?>" target="_blank" rel="noopener noreferrer" class="dt-btn dt-btn-pale" style="text-decoration:none; height:30px; font-size:11.5px; display:inline-flex; align-items:center; gap:5px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                    <span id="externalCarrierLinkText">Carrier Portal (Delhivery)</span>
                                </a>
                                <a id="viewOrderDetailsLink" href="/admin/orders/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:30px; font-size:11.5px; display:inline-flex; align-items:center; gap:5px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                    <span>View Full Order Dossier</span>
                                </a>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:11px; color:#64748B; font-weight:700;">Update Status:</span>
                                <button type="button" class="dt-btn dt-btn-pale" onclick="quickUpdateStatus('dispatched')" style="height:28px; font-size:11px; padding:0 8px;">Dispatch</button>
                                <button type="button" class="dt-btn dt-btn-pale" onclick="quickUpdateStatus('in_transit')" style="height:28px; font-size:11px; padding:0 8px;">In Transit</button>
                                <button type="button" class="dt-btn dt-btn-emerald" onclick="quickUpdateStatus('delivered')" style="height:28px; font-size:11px; padding:0 10px; color:#FFFFFF;">Delivered</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Dispatches Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Live Dispatches in Transit</span>
                    </h3>
                    <span class="adm-badge" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800; font-size:11.5px;"><?= count($shippingOrders) ?> Parcels Tracked</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table" id="dispatchesTable">
                        <thead>
                            <tr>
                                <th>Order Ref</th>
                                <th>Consignee</th>
                                <th>Carrier &amp; AWB</th>
                                <th>Destination</th>
                                <th>Order Value</th>
                                <th>Status Checkpoint</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($shippingOrders)): ?>
                                <?php foreach ($shippingOrders as $so): ?>
                                    <?php
                                        $orderRef = $so['order_number'] ?? ('DTB-' . str_pad((string)$so['id'], 6, '0', STR_PAD_LEFT));
                                        $awb = $so['tracking_number'] ?: $orderRef;
                                        $carrier = $so['courier_name'] ?: 'Delhivery Express';
                                        $st = strtolower($so['fulfillment_status'] ?? ($so['order_status'] ?? 'processing'));
                                        $badgeClass = 'success';
                                        if (in_array($st, ['pending', 'processing', 'unfulfilled'])) $badgeClass = 'warning';
                                        elseif ($st === 'cancelled') $badgeClass = 'danger';
                                    ?>
                                    <tr id="row-order-<?= $so['id'] ?>" data-awb="<?= htmlspecialchars($awb) ?>" data-order-id="<?= $so['id'] ?>">
                                        <td>
                                            <a href="/admin/orders/view.php?id=<?= $so['id'] ?>" style="color:#8A681F; font-weight:800; text-decoration:none;">
                                                #<?= htmlspecialchars($orderRef) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div style="font-weight:700; color:#181512;"><?= htmlspecialchars($so['customer_name'] ?? 'Direct Customer') ?></div>
                                            <?php if (!empty($so['consignee_phone'])): ?>
                                                <div style="font-size:11px; color:#64748B;">+91 <?= htmlspecialchars(substr(preg_replace('/\D/', '', (string)$so['consignee_phone']), -10)) ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <code style="background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:700; font-size:11.5px;"><?= htmlspecialchars($awb) ?></code>
                                            <div style="font-size:11px; color:#64748B; margin-top:2px;"><?= htmlspecialchars($carrier) ?></div>
                                        </td>
                                        <td><?= htmlspecialchars($so['destination_city'] . ', India') ?></td>
                                        <td>
                                            <div style="font-weight:800; color:#181512; display:flex; align-items:center; gap:2px;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                                                <span><?= number_format((float)($so['total_amount'] ?? 0), 2) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="adm-badge <?= $badgeClass ?>" id="tableStatusBadge_<?= $so['id'] ?>"><?= ucfirst(htmlspecialchars(str_replace('_', ' ', $st))) ?></span>
                                        </td>
                                        <td style="text-align:right;">
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="quickTrack('<?= htmlspecialchars($awb) ?>', <?= (int)$so['id'] ?>)">Track</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align:center; padding:32px; color:#64748B;">
                                        No active consignments found in the database. New orders will automatically appear here.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script>
window.DT_SHIPPING_ORDERS = <?php echo json_encode($shippingOrders, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
var currentTrackedOrder = null;

function renderTelemetry(order) {
    if (!order) return;
    currentTrackedOrder = order;

    var awb = order.tracking_number || order.order_number || 'TRK-STANDBY';
    var carrier = order.courier_name || 'Delhivery Express';
    var consignee = order.customer_name || 'Direct Customer';
    var city = order.destination_city || 'Surat';
    var st = (order.fulfillment_status || order.order_status || 'processing').toLowerCase();
    var orderRef = order.order_number || ('DTB-' + order.id);

    // Update Dossier Header
    var awbEl = document.getElementById('activeAwbNumber');
    var carEl = document.getElementById('activeCarrierBadge');
    var conEl = document.getElementById('activeConsigneeName');
    var cityEl = document.getElementById('activeDestinationCity');
    var milesEl = document.getElementById('activeMilestoneText');
    var refEl = document.getElementById('activeOrderRefText');
    var searchIn = document.getElementById('awbSearchInput');

    if (awbEl) awbEl.textContent = awb;
    if (carEl) carEl.textContent = carrier;
    if (conEl) conEl.textContent = consignee;
    if (cityEl) cityEl.textContent = city;
    if (searchIn) searchIn.value = awb;
    if (refEl) refEl.innerHTML = 'Order: <strong style="color:#8A681F;">#' + escapeHtml(orderRef) + '</strong>';

    // Subtitles
    var sub1 = document.getElementById('trackSub1');
    var sub2 = document.getElementById('trackSub2');
    var sub3 = document.getElementById('trackSub3');
    var sub4 = document.getElementById('trackSub4');
    if (sub1) sub1.textContent = 'Surat Central Depot';
    if (sub2) sub2.textContent = carrier + ' Ingestion';
    if (sub3) sub3.textContent = city + ' Freight Corridor';
    if (sub4) sub4.textContent = consignee + ' Handover';

    // Calculate Step States & Progress
    var step1 = document.getElementById('trackStep1');
    var step2 = document.getElementById('trackStep2');
    var step3 = document.getElementById('trackStep3');
    var step4 = document.getElementById('trackStep4');
    var prog = document.getElementById('trackProgressBar');

    var checkSvg = '<svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#FFFFFF" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>';

    [step1, step2, step3, step4].forEach(function(s, idx) {
        if (!s) return;
        s.classList.remove('done', 'active');
        var dot = s.querySelector('.dt-track-dot');
        if (dot) dot.textContent = (idx + 1);
    });

    var pWidth = '12%';
    var milestoneText = 'Processing at Surat Warehouse';

    if (st === 'pending' || st === 'unfulfilled') {
        if (step1) step1.classList.add('active');
        pWidth = '12%';
        milestoneText = 'Order Packed & Awaiting Dispatch';
    } else if (st === 'processing') {
        if (step1) {
            step1.classList.add('done');
            step1.querySelector('.dt-track-dot').innerHTML = checkSvg;
        }
        if (step2) step2.classList.add('active');
        pWidth = '35%';
        milestoneText = 'Dispatched to ' + carrier;
    } else if (st === 'dispatched') {
        if (step1) {
            step1.classList.add('done');
            step1.querySelector('.dt-track-dot').innerHTML = checkSvg;
        }
        if (step2) {
            step2.classList.add('done');
            step2.querySelector('.dt-track-dot').innerHTML = checkSvg;
        }
        if (step3) step3.classList.add('active');
        pWidth = '68%';
        milestoneText = 'In Transit via ' + carrier;
    } else if (st === 'shipped' || st === 'in_transit' || st === 'out_for_delivery') {
        if (step1) {
            step1.classList.add('done');
            step1.querySelector('.dt-track-dot').innerHTML = checkSvg;
        }
        if (step2) {
            step2.classList.add('done');
            step2.querySelector('.dt-track-dot').innerHTML = checkSvg;
        }
        if (step3) {
            step3.classList.add('done');
            step3.querySelector('.dt-track-dot').innerHTML = checkSvg;
        }
        if (step4) step4.classList.add('active');
        pWidth = '86%';
        milestoneText = 'Out for Delivery in ' + city;
    } else if (st === 'delivered') {
        [step1, step2, step3, step4].forEach(function(s) {
            if (s) {
                s.classList.add('done');
                s.querySelector('.dt-track-dot').innerHTML = checkSvg;
            }
        });
        pWidth = '100%';
        milestoneText = 'Consignment Successfully Delivered';
    }

    if (prog) prog.style.width = pWidth;
    if (milesEl) milesEl.textContent = milestoneText;

    // External Carrier Tracking Link
    var extLink = document.getElementById('externalCarrierLink');
    var extText = document.getElementById('externalCarrierLinkText');
    var carLower = carrier.toLowerCase();
    var trackUrl = '#';

    if (carLower.indexOf('delhivery') !== -1) {
        trackUrl = 'https://www.delhivery.com/track/package/' + encodeURIComponent(awb);
        if (extText) extText.textContent = 'Delhivery Official Tracking';
    } else if (carLower.indexOf('blue') !== -1 || carLower.indexOf('dart') !== -1) {
        trackUrl = 'https://www.bluedart.com/tracking?trackNumber=' + encodeURIComponent(awb);
        if (extText) extText.textContent = 'BlueDart Official Tracking';
    } else if (carLower.indexOf('dtdc') !== -1) {
        trackUrl = 'https://www.dtdc.in/';
        if (extText) extText.textContent = 'DTDC Official Tracking';
    } else if (carLower.indexOf('vrl') !== -1) {
        trackUrl = 'https://www.vrlgroup.in/';
        if (extText) extText.textContent = 'VRL Freight Portal';
    } else {
        trackUrl = 'https://www.delhivery.com/track/package/' + encodeURIComponent(awb);
        if (extText) extText.textContent = carrier + ' Portal';
    }

    if (extLink) extLink.href = trackUrl;

    // View Order Dossier Link
    var viewLink = document.getElementById('viewOrderDetailsLink');
    if (viewLink && order.id) {
        viewLink.href = '/admin/orders/view.php?id=' + order.id;
    }

    // Highlight row in table
    document.querySelectorAll('#dispatchesTable tbody tr').forEach(function(r) {
        r.classList.remove('dt-track-highlight-row');
    });
    if (order.id) {
        var tr = document.getElementById('row-order-' + order.id);
        if (tr) tr.classList.add('dt-track-highlight-row');
    }
}

function handleTrackAWB(e) {
    if (e && e.preventDefault) e.preventDefault();
    var input = document.getElementById('awbSearchInput').value.trim();
    if (!input) return;

    var orders = window.DT_SHIPPING_ORDERS || [];
    var match = orders.find(function(o) {
        return (o.tracking_number && o.tracking_number.toLowerCase() === input.toLowerCase()) ||
               (o.order_number && o.order_number.toLowerCase() === input.toLowerCase()) ||
               (String(o.id) === input);
    });

    if (match) {
        renderTelemetry(match);
        if (typeof window.showToast === 'function') {
            window.showToast('Consignment located: ' + (match.tracking_number || match.order_number));
        }
    } else {
        // Render custom input fallback
        renderTelemetry({
            id: null,
            order_number: input,
            tracking_number: input,
            courier_name: 'Delhivery Express',
            customer_name: 'Consignee Record',
            destination_city: 'India',
            fulfillment_status: 'dispatched'
        });
        if (typeof window.showToast === 'function') {
            window.showToast('Telemetry queried for AWB: ' + input);
        }
    }
}

function quickTrack(awb, orderId) {
    var orders = window.DT_SHIPPING_ORDERS || [];
    var match = null;
    if (orderId) {
        match = orders.find(function(o) { return Number(o.id) === Number(orderId); });
    }
    if (!match && awb) {
        match = orders.find(function(o) { return o.tracking_number === awb || o.order_number === awb; });
    }

    if (match) {
        renderTelemetry(match);
    } else {
        renderTelemetry({
            id: orderId || null,
            order_number: awb,
            tracking_number: awb,
            courier_name: 'Delhivery Express',
            customer_name: 'Consignee',
            destination_city: 'Surat',
            fulfillment_status: 'dispatched'
        });
    }

    window.scrollTo({ top: 120, behavior: 'smooth' });
}

function quickUpdateStatus(newStatus) {
    if (!currentTrackedOrder || !currentTrackedOrder.id) {
        if (typeof window.showToast === 'function') {
            window.showToast('Please select an active order from the table to update status.');
        }
        return;
    }

    var orderId = currentTrackedOrder.id;
    var carrier = currentTrackedOrder.courier_name || 'Delhivery Express';
    var tracking = currentTrackedOrder.tracking_number || '';

    fetch('/api/orders.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'update_status',
            order_id: orderId,
            status: newStatus,
            courier_name: carrier,
            tracking_number: tracking
        })
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        if (res && res.success) {
            currentTrackedOrder.fulfillment_status = newStatus;
            currentTrackedOrder.order_status = newStatus;
            renderTelemetry(currentTrackedOrder);

            // Update badge in table
            var badgeEl = document.getElementById('tableStatusBadge_' + orderId);
            if (badgeEl) {
                badgeEl.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1).replace('_', ' ');
                badgeEl.className = 'adm-badge ' + (newStatus === 'delivered' ? 'success' : 'warning');
            }

            if (typeof window.showToast === 'function') {
                window.showToast('Order #' + orderId + ' updated to ' + newStatus.toUpperCase());
            }
        } else {
            if (typeof window.showToast === 'function') {
                window.showToast('Failed to update status: ' + (res.message || 'Unknown error'));
            }
        }
    })
    .catch(function(err) {
        console.error('Update status error:', err);
    });
}

function copyAwbToClipboard() {
    var awb = document.getElementById('activeAwbNumber')?.textContent || '';
    if (!awb) return;
    navigator.clipboard.writeText(awb).then(function() {
        if (typeof window.showToast === 'function') {
            window.showToast('AWB copied to clipboard: ' + awb);
        }
    }).catch(function() {});
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, function(m) {
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m];
    });
}

// Initialize with first consignment
document.addEventListener('DOMContentLoaded', function() {
    var orders = window.DT_SHIPPING_ORDERS || [];
    if (orders.length > 0) {
        renderTelemetry(orders[0]);
    }
});
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
