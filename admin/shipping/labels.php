<?php
/* DT admin access guard (auto-inserted) */
$__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
if (is_file($__dtg)) {
    require_once $__dtg;
} else if (is_file(__DIR__ . '/../includes/adminguard.php')) {
    require_once __DIR__ . '/../includes/adminguard.php';
}

/**
 * labels.php — Shipping Labels & Thermal Barcode Manifest Studio
 * Section 27: Shipping Admin Architecture & Logistics Suite
 * DT Brand's & Jai Hanuman Tex — Surat Logistics Depot
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/OrderManager.php';

use DTBrand\Database;
use DTBrand\OrderManager;

$page_title = "Shipping Labels & Dispatch Manifest Studio";
$active_nav = "shipping";
$active_subnav = "labels";

$orderId = trim((string)($_GET['order_id'] ?? ''));
$pdo = Database::getConnection();
$orderList = [];
$selectedOrder = null;

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("SELECT id, order_number, customer_name, customer_phone, total_amount, shipping_address, payment_method, courier_name, tracking_number, created_at FROM `orders` ORDER BY id DESC LIMIT 50");
        $orderList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Throwable $e) {}
}

if (empty($orderList)) {
    $orderList = OrderManager::getAll();
}

if (!empty($orderId)) {
    foreach ($orderList as $o) {
        if ((string)$o['id'] === $orderId || (string)($o['order_number'] ?? '') === $orderId) {
            $selectedOrder = $o;
            break;
        }
    }
}

if (!$selectedOrder && !empty($orderList)) {
    $selectedOrder = $orderList[0];
}

$orderNum = $selectedOrder['order_number'] ?? ('DTB-' . str_pad((string)($selectedOrder['id'] ?? 1001), 6, '0', STR_PAD_LEFT));
$awb = !empty($selectedOrder['tracking_number']) ? $selectedOrder['tracking_number'] : ('DELH' . strtoupper(substr(md5($orderNum), 0, 10)));
$courier = !empty($selectedOrder['courier_name']) ? $selectedOrder['courier_name'] : 'Delhivery Express Surface';
$buyerName = $selectedOrder['customer_name'] ?? 'Trade Partner';
$buyerPhone = $selectedOrder['customer_phone'] ?? '+91 98251 00000';
$shippingAddress = $selectedOrder['shipping_address'] ?? 'Wholesale Market Road, Ahmedabad, Gujarat - 380001';
$orderTotal = (float)($selectedOrder['total_amount'] ?? 4500.00);
$payMethod = $selectedOrder['payment_method'] ?? 'PREPAID';
$isCod = (stripos($payMethod, 'cod') !== false || stripos($payMethod, 'cash on delivery') !== false);

preg_match('/\b\d{6}\b/', $shippingAddress, $pinMatch);
$pincode = $pinMatch[0] ?? '380001';

$rupeeSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Labels &amp; Barcode Studio - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        /* Thermal 4x6 Label Container */
        .dt-thermal-label {
            width: 420px;
            min-height: 590px;
            background: #FFFFFF;
            border: 2px solid #111827;
            border-radius: 4px;
            margin: 0 auto;
            padding: 16px;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            color: #111827;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: relative;
        }

        .dt-label-header {
            border-bottom: 2px solid #111827;
            padding-bottom: 10px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .dt-label-brand-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 900;
            font-size: 15px;
            letter-spacing: -0.02em;
            color: #111827;
            margin: 0;
            line-height: 1.2;
        }

        .dt-label-brand-sub {
            font-size: 9.5px;
            color: #4B5563;
            margin: 2px 0 0 0;
            font-weight: 600;
        }

        .dt-label-section {
            border-bottom: 1.5px solid #111827;
            padding: 8px 0;
            font-size: 11px;
        }

        .dt-barcode-box {
            text-align: center;
            padding: 10px 0 6px 0;
            border-bottom: 2px solid #111827;
        }

        .dt-barcode-sim {
            display: inline-block;
            height: 48px;
            width: 90%;
            background: repeating-linear-gradient(
                90deg,
                #111827,
                #111827 2px,
                #FFFFFF 2px,
                #FFFFFF 4px,
                #111827 4px,
                #111827 7px,
                #FFFFFF 7px,
                #FFFFFF 9px,
                #111827 9px,
                #111827 10px,
                #FFFFFF 10px,
                #FFFFFF 13px,
                #111827 13px,
                #111827 16px,
                #FFFFFF 16px,
                #FFFFFF 18px
            );
        }

        .dt-barcode-text {
            font-family: monospace;
            font-weight: 800;
            font-size: 14px;
            letter-spacing: 2px;
            margin-top: 4px;
            color: #111827;
        }

        .dt-label-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-bottom: 1.5px solid #111827;
        }

        .dt-label-cell {
            padding: 8px;
            font-size: 11px;
        }

        .dt-label-cell:first-child {
            border-right: 1.5px solid #111827;
        }

        .dt-label-tag {
            font-weight: 800;
            font-size: 13px;
            padding: 4px 8px;
            display: inline-block;
            border: 1.5px solid #111827;
            text-align: center;
        }

        /* Print Media Styles for 4x6 / A4 */
        @media print {
            body * {
                visibility: hidden;
            }
            .adm-sidebar, .adm-header, .adm-page-head, .dt-label-controls, .adm-footer {
                display: none !important;
            }
            #thermalLabelPrintArea, #thermalLabelPrintArea * {
                visibility: visible;
            }
            #thermalLabelPrintArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 4in;
                height: 6in;
                margin: 0;
                padding: 10px;
                border: none !important;
                box-shadow: none !important;
            }
            @page {
                size: 4in 6in;
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
            <div class="adm-page-head dt-label-controls" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Shipping Labels &amp; Barcode Manifest</span>
                        <span class="adm-badge gold">Standard 4x6 Thermal &amp; A4</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Generate high-resolution dispatch barcode labels with Surat depot GSTIN and verified consignee data.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/shipping/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Shipments</span>
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="window.print()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        <span>Print 4x6 Label</span>
                    </button>
                </div>
            </div>

            <!-- Selector Toolbar -->
            <div class="adm-card dt-label-controls" style="margin-bottom:20px; padding:14px 18px; background:#FAF8F4; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <label style="font-size:12px; font-weight:700; color:#374151;">Select Consignment Order:</label>
                    <select onchange="location.href='/admin/shipping/labels.php?order_id=' + this.value;" style="border:1px solid #D1D5DB; border-radius:6px; padding:6px 12px; font-size:12.5px; font-weight:700; color:#111827; background:#FFFFFF;">
                        <?php foreach ($orderList as $ol): ?>
                            <?php $oid = $ol['id']; $onum = $ol['order_number'] ?? ('DTB-' . $oid); ?>
                            <option value="<?= $oid ?>" <?= ((string)$oid === (string)($selectedOrder['id'] ?? '') || $onum === ($selectedOrder['order_number'] ?? '')) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($onum) ?> — <?= htmlspecialchars($ol['customer_name'] ?? 'Customer') ?> (₹<?= number_format((float)($ol['total_amount'] ?? 0), 2) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="font-size:12px; font-weight:700; color:#8A681F; display:inline-flex; align-items:center; gap:6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                    <span>Courier Manifest Ready</span>
                </div>
            </div>

            <!-- Print Preview Section -->
            <div style="padding:20px 0; background:#F8FAFC; border-radius:12px; border:1px solid #E2E8F0; text-align:center;">
                <div id="thermalLabelPrintArea" class="dt-thermal-label">
                    <!-- Brand & Courier Header -->
                    <div class="dt-label-header">
                        <div style="text-align:left;">
                            <h2 class="dt-label-brand-title">DT BRAND'S &amp; JAI HANUMAN TEX</h2>
                            <p class="dt-label-brand-sub">SURAT CENTRAL MILL LOGISTICS DEPOT</p>
                            <p style="font-size:9px; color:#4B5563; margin:2px 0 0 0;">GSTIN: 24AAACD1234F1Z8 | Contact: +91 70463 63528</p>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-weight:900; font-size:14px; text-transform:uppercase;"><?= htmlspecialchars($courier) ?></div>
                            <span class="dt-label-tag" style="margin-top:4px; font-size:11px; background:<?= $isCod ? '#FEF2F2' : '#F0FDF4' ?>; color:<?= $isCod ? '#991B1B' : '#166534' ?>;">
                                <?= $isCod ? 'CASH ON DELIVERY' : 'PREPAID' ?>
                            </span>
                        </div>
                    </div>

                    <!-- Dispatch Barcode -->
                    <div class="dt-barcode-box">
                        <div class="dt-barcode-sim"></div>
                        <div class="dt-barcode-text"><?= htmlspecialchars($awb) ?></div>
                        <div style="font-size:10px; color:#4B5563; font-weight:600;">AWB / WAYBILL TRACKING IDENTIFIER</div>
                    </div>

                    <!-- Routing Pincode & Order Ref -->
                    <div class="dt-label-grid">
                        <div class="dt-label-cell" style="text-align:left;">
                            <span style="font-size:9.5px; font-weight:700; color:#64748B; text-transform:uppercase;">Destination PIN</span>
                            <div style="font-size:22px; font-weight:900; letter-spacing:1px; margin-top:2px;"><?= htmlspecialchars($pincode) ?></div>
                        </div>
                        <div class="dt-label-cell" style="text-align:right;">
                            <span style="font-size:9.5px; font-weight:700; color:#64748B; text-transform:uppercase;">Order Reference</span>
                            <div style="font-size:15px; font-weight:800; margin-top:4px; font-family:monospace;"><?= htmlspecialchars($orderNum) ?></div>
                        </div>
                    </div>

                    <!-- Ship To / Consignee Details -->
                    <div class="dt-label-section" style="text-align:left;">
                        <div style="font-size:9.5px; font-weight:800; color:#64748B; text-transform:uppercase; margin-bottom:4px;">SHIP TO / RECIPIENT:</div>
                        <div style="font-weight:900; font-size:14px; color:#111827; margin-bottom:2px;"><?= htmlspecialchars($buyerName) ?></div>
                        <div style="font-size:11px; line-height:1.4; color:#1F2937; margin-bottom:4px; font-weight:500;">
                            <?= nl2br(htmlspecialchars($shippingAddress)) ?>
                        </div>
                        <div style="font-weight:700; font-size:12px; color:#111827;">Phone: <?= htmlspecialchars($buyerPhone) ?></div>
                    </div>

                    <!-- Consignment Specifications -->
                    <div class="dt-label-grid">
                        <div class="dt-label-cell" style="text-align:left;">
                            <div style="font-size:9.5px; font-weight:700; color:#64748B;">CONSIGNMENT WEIGHT</div>
                            <div style="font-weight:800; font-size:12px; margin-top:2px;">1.20 KG (DEAD) / 1.50 VOL</div>
                            <div style="font-size:9.5px; font-weight:700; color:#64748B; margin-top:4px;">DIMENSIONS</div>
                            <div style="font-weight:800; font-size:11px;">30 x 25 x 8 cm</div>
                        </div>
                        <div class="dt-label-cell" style="text-align:right;">
                            <div style="font-size:9.5px; font-weight:700; color:#64748B;">COLLECTIBLE AMOUNT</div>
                            <div style="font-size:18px; font-weight:900; margin-top:2px; display:inline-flex; align-items:center; gap:2px;">
                                <?= $rupeeSvg ?> <?= $isCod ? number_format($orderTotal, 2) : '0.00' ?>
                            </div>
                            <div style="font-size:9.5px; font-weight:700; color:#64748B; margin-top:4px;">DISPATCH DATE</div>
                            <div style="font-weight:800; font-size:11px;"><?= date('d-M-Y') ?></div>
                        </div>
                    </div>

                    <!-- Shipper Return Address -->
                    <div style="text-align:left; padding-top:8px; font-size:9.5px; color:#4B5563; line-height:1.3;">
                        <strong>RETURN IF UNDELIVERED TO:</strong><br>
                        DT Brand's &amp; Jai Hanuman Tex Central Logistics Godown,<br>
                        Plot #42, Ring Road Textile Market Hub, Surat, Gujarat - 395002.<br>
                        Contact: +91 70463 63528 | Web: https://jaihanumantex.in
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
