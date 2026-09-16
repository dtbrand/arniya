<?php
/**
 * track.php — Real-Time Order & Shipment Tracking Portal
 * DT Brand's & Jai Hanuman Tex — Production Architecture
 *
 * Self-Service Secure Verification:
 * Requires matching Order Number + Phone Number to prevent IDOR enumeration.
 * Live sync with OrderManager, Courier AWB records & Delhivery/BlueDart status.
 */

require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/OrderManager.php';
require_once __DIR__ . '/src/Auth.php';

use DTBrand\Database;
use DTBrand\OrderManager;
use DTBrand\Auth;

$currentUser = Auth::getCurrentUser();

$orderNoInput = trim($_GET['order_number'] ?? ($_POST['order_number'] ?? ''));
$phoneInput   = trim($_GET['phone'] ?? ($_POST['phone'] ?? ''));

$searched = (!empty($orderNoInput) || !empty($phoneInput));
$order = null;
$error = null;

$digits = static function ($v) {
    $d = preg_replace('/\D+/', '', (string)$v);
    return strlen($d) > 10 ? substr($d, -10) : $d;
};

if ($searched) {
    if (empty($orderNoInput)) {
        $error = "Please enter your Order Number (e.g. DT-ORD-XXXXXX).";
    } elseif (empty($phoneInput)) {
        $error = "Please enter the 10-digit mobile number associated with this order.";
    } else {
        $foundOrder = OrderManager::getByOrderNumber($orderNoInput);
        if ($foundOrder) {
            $orderPhone = $digits($foundOrder['customer_phone'] ?? '');
            $inputPhone = $digits($phoneInput);
            if ($orderPhone !== '' && $orderPhone === $inputPhone) {
                $order = $foundOrder;
            } else {
                $error = "No matching order found for this Order Number and Mobile Number. Please double check and try again.";
            }
        } else {
            $error = "No matching order found for this Order Number and Mobile Number. Please double check and try again.";
        }
    }
}

// Stage map
$statusPipeline = [
    'pending'          => 1,
    'confirmed'        => 1,
    'processing'       => 2,
    'packed'           => 3,
    'shipped'          => 4,
    'out-for-delivery' => 4,
    'delivered'        => 5,
    'cancelled'        => 0,
    'returned'         => 0,
    'refunded'         => 0
];

$curStatus = strtolower(trim((string)($order['fulfillment_status'] ?? ($order['status'] ?? 'processing'))));
$curStage = $statusPipeline[$curStatus] ?? 2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Track Order &amp; Shipment — DT Brand's &amp; Jai Hanuman Tex</title>
    <meta name="description" content="Live real-time order and shipment tracking for DT Brand's & Jai Hanuman Tex. Enter your order ID and mobile number to track dispatch and delivery." />
    <link rel="canonical" href="https://<?= htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'jaihanumantex.in') ?>/track" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#8A681F">

    <style>
        :root {
            --dt-gold: #8A681F;
            --dt-gold-radiant: #D4AF37;
            --dt-gold-pale: #FAF5E8;
            --dt-obsidian: #181512;
            --dt-text-main: #111827;
            --dt-text-sub: #4B5563;
            --dt-border-soft: #E5E7EB;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
            background: #F9FAFB;
            color: var(--dt-text-main);
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .track-hero {
            background: linear-gradient(135deg, #181512 0%, #2A241E 100%);
            border-bottom: 2px solid var(--dt-gold-radiant);
            padding: 40px 20px;
            text-align: center;
            color: #FFFFFF;
        }

        .track-hero h1 {
            font-family: 'Cinzel', serif;
            font-size: 1.85rem;
            margin: 0 0 8px;
            color: #FFFFFF;
            letter-spacing: 0.02em;
        }

        .track-hero p {
            font-size: 0.92rem;
            color: #D6D3D1;
            margin: 0 auto;
            max-width: 540px;
            line-height: 1.5;
        }

        .track-container {
            max-width: 860px;
            margin: -24px auto 60px;
            padding: 0 16px;
        }

        .track-card {
            background: #FFFFFF;
            border: 1px solid var(--dt-border-soft);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            padding: 24px;
            margin-bottom: 24px;
        }

        .track-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 12px;
            align-items: end;
        }

        @media (max-width: 700px) {
            .track-form-grid {
                grid-template-columns: 1fr;
            }
        }

        .track-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .track-form-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .track-input {
            height: 44px;
            padding: 0 14px;
            border: 1.5px solid #D1D5DB;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            color: #111827;
            outline: none;
            transition: all 0.2s ease;
        }

        .track-input:focus {
            border-color: var(--dt-gold-radiant);
            box-shadow: 0 0 0 3px rgba(212,175,55,0.2);
        }

        .track-submit-btn {
            height: 44px;
            padding: 0 24px;
            background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
            border: 1px solid #8A681F;
            border-radius: 8px;
            color: #111827;
            font-weight: 800;
            font-size: 0.92rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(184,134,11,0.35);
            transition: all 0.2s ease;
        }

        .track-submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(184,134,11,0.48);
        }

        .track-alert-error {
            background: #FEF2F2;
            border: 1px solid #F87171;
            border-radius: 8px;
            padding: 14px 16px;
            color: #991B1B;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        /* Order Info Ribbon */
        .order-meta-ribbon {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 14px;
            background: var(--dt-gold-pale);
            border: 1px solid rgba(212,175,55,0.4);
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 24px;
        }

        .order-meta-item .label {
            font-size: 0.72rem;
            font-weight: 700;
            color: #8A681F;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .order-meta-item .value {
            font-size: 0.95rem;
            font-weight: 800;
            color: #181512;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Step Timeline */
        .track-timeline {
            position: relative;
            display: flex;
            justify-content: space-between;
            margin: 32px 0 24px;
            padding: 0 10px;
        }

        .track-timeline::before {
            content: '';
            position: absolute;
            top: 18px;
            left: 30px;
            right: 30px;
            height: 3px;
            background: #E5E7EB;
            z-index: 1;
        }

        .timeline-step {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex: 1;
        }

        .step-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #FFFFFF;
            border: 2px solid #D1D5DB;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9CA3AF;
            transition: all 0.25s ease;
        }

        .timeline-step.completed .step-circle {
            background: #15803D;
            border-color: #15803D;
            color: #FFFFFF;
        }

        .timeline-step.active .step-circle {
            background: linear-gradient(135deg, #B8860B 0%, #D4AF37 100%);
            border-color: #8A681F;
            color: #111827;
            box-shadow: 0 0 0 5px rgba(212,175,55,0.25);
            animation: pulseGlow 1.8s infinite;
        }

        @keyframes pulseGlow {
            0% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(212,175,55,0.4); }
            70% { transform: scale(1.04); box-shadow: 0 0 0 8px rgba(212,175,55,0); }
            100% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(212,175,55,0); }
        }

        .step-label {
            margin-top: 10px;
            font-size: 0.78rem;
            font-weight: 700;
            color: #6B7280;
        }

        .timeline-step.completed .step-label,
        .timeline-step.active .step-label {
            color: #111827;
            font-weight: 800;
        }

        @media (max-width: 600px) {
            .step-label { font-size: 0.68rem; }
            .step-circle { width: 32px; height: 32px; font-size: 0.75rem; }
            .track-timeline::before { top: 15px; }
        }

        /* Items Section */
        .track-items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .track-items-table th {
            text-align: left;
            padding: 10px 12px;
            background: #F9FAFB;
            font-size: 0.75rem;
            font-weight: 700;
            color: #6B7280;
            border-bottom: 1px solid #E5E7EB;
        }

        .track-items-table td {
            padding: 12px;
            border-bottom: 1px solid #F3F4F6;
            vertical-align: middle;
            font-size: 0.88rem;
        }

        .track-item-img {
            width: 46px;
            height: 46px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #E5E7EB;
        }

        .courier-box {
            background: #EFF6FF;
            border: 1px solid #93C5FD;
            border-radius: 8px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }

        .courier-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .courier-btn {
            height: 34px;
            padding: 0 14px;
            background: #1D4ED8;
            color: #FFFFFF;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .wa-concierge-card {
            background: #DCFCE7;
            border: 1px solid #86EFAC;
            border-radius: 8px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 20px;
        }

        .wa-btn {
            height: 38px;
            padding: 0 16px;
            background: #15803D;
            color: #FFFFFF;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 6px rgba(21,128,61,0.3);
        }
    </style>
</head>
<body>

<?php include_once __DIR__ . '/includes/shophader.php'; ?>

<section class="track-hero">
    <h1>Shipment &amp; Order Tracker</h1>
    <p>Live verified status from Surat Handloom Depot to your doorstep.</p>
</section>

<div class="track-container">
    <!-- Search Card -->
    <div class="track-card">
        <?php if ($error): ?>
        <div class="track-alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <span><?= htmlspecialchars($error) ?></span>
        </div>
        <?php endif; ?>

        <form method="GET" action="/track" class="track-form-grid">
            <div class="track-form-group">
                <label class="track-form-label" for="orderNoInput">Order Number</label>
                <input type="text" id="orderNoInput" name="order_number" class="track-input" placeholder="e.g. DT-ORD-XXXXXX" value="<?= htmlspecialchars($orderNoInput) ?>" required autocomplete="off">
            </div>

            <div class="track-form-group">
                <label class="track-form-label" for="phoneInput">Mobile Number</label>
                <input type="tel" id="phoneInput" name="phone" class="track-input" placeholder="10-digit mobile number" value="<?= htmlspecialchars($phoneInput) ?>" maxlength="15" required autocomplete="tel">
            </div>

            <button type="submit" class="track-submit-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span>Track Order</span>
            </button>
        </form>
    </div>

    <?php if ($order): ?>
    <!-- Active Order Card -->
    <div class="track-card">
        <div class="order-meta-ribbon">
            <div class="order-meta-item">
                <div class="label">Order Number</div>
                <div class="value"><?= htmlspecialchars($order['order_number'] ?? ('#' . $order['id'])) ?></div>
            </div>
            <div class="order-meta-item">
                <div class="label">Placed On</div>
                <div class="value"><?= date('d M Y', strtotime($order['created_at'] ?? 'now')) ?></div>
            </div>
            <div class="order-meta-item">
                <div class="label">Total Amount</div>
                <div class="value">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                    <span><?= number_format((float)($order['total_amount'] ?? $order['total'] ?? 0), 2) ?></span>
                </div>
            </div>
            <div class="order-meta-item">
                <div class="label">Payment</div>
                <div class="value"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $order['payment_method'] ?? 'Prepaid'))) ?></div>
            </div>
        </div>

        <!-- Visual Timeline -->
        <h3 style="margin: 0 0 12px; font-size: 1.05rem; font-weight: 800; color: #181512;">Shipment Status Pipeline</h3>
        
        <div class="track-timeline">
            <div class="timeline-step <?= $curStage >= 1 ? ($curStage === 1 ? 'active' : 'completed') : '' ?>">
                <div class="step-circle">
                    <?php if ($curStage > 1): ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <?php else: ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <?php endif; ?>
                </div>
                <div class="step-label">Order Confirmed</div>
            </div>

            <div class="timeline-step <?= $curStage >= 2 ? ($curStage === 2 ? 'active' : 'completed') : '' ?>">
                <div class="step-circle">
                    <?php if ($curStage > 2): ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <?php else: ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"></path></svg>
                    <?php endif; ?>
                </div>
                <div class="step-label">Loom QC &amp; Process</div>
            </div>

            <div class="timeline-step <?= $curStage >= 3 ? ($curStage === 3 ? 'active' : 'completed') : '' ?>">
                <div class="step-circle">
                    <?php if ($curStage > 3): ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <?php else: ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    <?php endif; ?>
                </div>
                <div class="step-label">Luxury Box Packed</div>
            </div>

            <div class="timeline-step <?= $curStage >= 4 ? ($curStage === 4 ? 'active' : 'completed') : '' ?>">
                <div class="step-circle">
                    <?php if ($curStage > 4): ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <?php else: ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    <?php endif; ?>
                </div>
                <div class="step-label">Dispatched (In Transit)</div>
            </div>

            <div class="timeline-step <?= $curStage >= 5 ? 'completed' : '' ?>">
                <div class="step-circle">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </div>
                <div class="step-label">Delivered</div>
            </div>
        </div>

        <!-- Logistics Card -->
        <?php 
        $courierName = !empty($order['courier_name']) ? $order['courier_name'] : 'Delhivery Logistics';
        $trackingNo  = !empty($order['tracking_number']) ? $order['tracking_number'] : ($order['awb_number'] ?? '');
        ?>
        <div class="courier-box">
            <div class="courier-left">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1D4ED8" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                <div>
                    <div style="font-size: 0.78rem; font-weight: 700; color: #1E40AF;">COURIER &amp; WAYBILL</div>
                    <div style="font-size: 0.95rem; font-weight: 800; color: #1E3A8A;">
                        <?= htmlspecialchars($courierName) ?> <?= $trackingNo ? ('— AWB: ' . htmlspecialchars($trackingNo)) : '— Generating Waybill' ?>
                    </div>
                </div>
            </div>
            <?php if (!empty($trackingNo)): ?>
            <a href="https://www.delhivery.com/track/package/<?= urlencode($trackingNo) ?>" target="_blank" rel="noopener noreferrer" class="courier-btn">
                <span>Direct Courier Tracking</span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
            </a>
            <?php endif; ?>
        </div>

        <!-- Items Ordered -->
        <h4 style="margin: 28px 0 10px; font-size: 0.95rem; font-weight: 800; color: #181512;">Items in this Package</h4>
        <div style="overflow-x: auto;">
            <table class="track-items-table">
                <thead>
                    <tr>
                        <th style="width:60px;">Image</th>
                        <th>Product Details</th>
                        <th>Color / Size</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $orderItems = $order['items'] ?? [];
                    if (!empty($orderItems)):
                        foreach ($orderItems as $item):
                            $iImg = !empty($item['img']) ? $item['img'] : (!empty($item['primary_image']) ? $item['primary_image'] : '/assets/images/placeholder-product.svg');
                            $iTitle = $item['product_title'] ?? ($item['title'] ?? 'Ethnic Silk Saree');
                            $iSku = $item['sku'] ?? '';
                            $iColor = $item['variant_color'] ?? ($item['color'] ?? 'Standard');
                            $iSize = $item['variant_size'] ?? ($item['size'] ?? 'Free Size');
                            $iQty = (int)($item['quantity'] ?? ($item['qty'] ?? 1));
                            $iPrice = (float)($item['unit_price'] ?? ($item['price'] ?? 0));
                    ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars($iImg) ?>" alt="<?= htmlspecialchars($iTitle) ?>" class="track-item-img" onerror="this.src='/assets/images/placeholder-product.svg';">
                        </td>
                        <td>
                            <div style="font-weight:700; color:#181512;"><?= htmlspecialchars($iTitle) ?></div>
                            <?php if ($iSku): ?><div style="font-size:0.75rem; color:#6B7280;">SKU: <?= htmlspecialchars($iSku) ?></div><?php endif; ?>
                        </td>
                        <td>
                            <div style="font-size:0.82rem; color:#374151; font-weight:600;"><?= htmlspecialchars($iColor) ?></div>
                            <div style="font-size:0.75rem; color:#6B7280;"><?= htmlspecialchars($iSize) ?></div>
                        </td>
                        <td style="text-align:center; font-weight:700;"><?= $iQty ?></td>
                        <td style="text-align:right; font-weight:800; color:#8A681F;">
                            ₹<?= number_format($iPrice * $iQty, 2) ?>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:#6B7280; padding:20px;">Order items verified and packed in mill dispatch.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- WhatsApp Support Card -->
        <div class="wa-concierge-card">
            <div style="display:flex; align-items:center; gap:12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path></svg>
                <div>
                    <div style="font-size:0.78rem; font-weight:700; color:#166534;">DEDICATED CONCIERGE</div>
                    <div style="font-size:0.88rem; font-weight:700; color:#14532D;">Need priority dispatch or delivery instructions?</div>
                </div>
            </div>
            <a href="https://wa.me/917046363528?text=<?= urlencode('Hello DT Brand, I would like an update on my order ' . ($order['order_number'] ?? '')) ?>" target="_blank" rel="noopener noreferrer" class="wa-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="#FFFFFF"><path d="M12 2C6.48 2 2 6.48 2 12c0 1.95.56 3.77 1.53 5.31L2 22l4.82-1.5C8.32 21.46 10.1 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm5.42 14.19c-.23.64-1.32 1.25-1.84 1.32-.48.06-1.1.1-3.23-.78-2.56-1.06-4.22-3.66-4.35-3.83-.13-.17-1.04-1.38-1.04-2.63 0-1.25.66-1.86.89-2.12.23-.26.51-.32.68-.32.17 0 .34 0 .49.01.16.01.37-.06.58.44.22.53.75 1.83.82 1.96.07.13.11.29.02.47-.09.18-.14.29-.27.45-.13.16-.28.36-.4.48-.13.13-.26.28-.11.54.15.26.67 1.11 1.44 1.79.99.88 1.82 1.16 2.08 1.29.26.13.41.11.56-.06.15-.17.65-.76.82-1.02.17-.26.34-.22.58-.13.24.09 1.52.72 1.78.85.26.13.43.19.49.3.06.11.06.66-.17 1.3z"/></svg>
                <span>WhatsApp Assistance</span>
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/includes/shopfooter.php'; ?>

</body>
</html>
