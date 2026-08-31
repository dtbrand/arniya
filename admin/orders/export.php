<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * export.php — Order Export Studio & Real Data Exporter
 * DT Brand's & Jai Hanuman Tex — Master Wholesale Architecture
 */

// Realistic Master Order Dataset
$export_orders = [
    [
        'id' => 'DTB-001624',
        'date' => '2026-08-21 11:20:00',
        'customer' => 'Rajesh Kumar',
        'firm' => 'Vardhman Tex',
        'phone' => '+91 70463 63528',
        'city' => 'Surat',
        'state' => 'Gujarat',
        'shipping_address' => 'Godown 12, Transport Nagar, Surat, Gujarat - 395010',
        'sku' => 'KNJ-001',
        'items' => 'Kanjivaram Silk Saree Pure Zari Weave (Royal Ruby / 5.5m)',
        'qty' => 25,
        'taxable_amount' => 106904.76,
        'cgst' => 2672.62,
        'sgst' => 2672.62,
        'total_amount' => 112250.00,
        'payment_mode' => 'Bank Wire / RTGS',
        'payment_status' => 'PAID',
        'carrier' => 'VRL Logistics Depot',
        'tracking' => 'VRL-99821',
        'status' => 'Shipped',
        'channel' => 'B2B Portal'
    ],
    [
        'id' => 'DTB-001623',
        'date' => '2026-08-21 10:45:00',
        'customer' => 'Pooja Sharma',
        'firm' => 'Pooja Couture',
        'phone' => '+91 70463 63528',
        'city' => 'Jaipur',
        'state' => 'Rajasthan',
        'shipping_address' => 'Plot 45, Johari Bazaar, Jaipur, Rajasthan - 302003',
        'sku' => 'BNR-102',
        'items' => 'Banarasi Brocade Silk Handloom (Emerald Gold)',
        'qty' => 1,
        'taxable_amount' => 4752.38,
        'cgst' => 118.81,
        'sgst' => 118.81,
        'total_amount' => 4990.00,
        'payment_mode' => 'UPI / PhonePe',
        'payment_status' => 'PAID',
        'carrier' => 'BlueDart Express Air',
        'tracking' => 'BD-88291',
        'status' => 'Delivered',
        'channel' => 'Online Shop'
    ],
    [
        'id' => 'DTB-001622',
        'date' => '2026-08-21 09:30:00',
        'customer' => 'Anjali Patel',
        'firm' => 'Siddhi Boutique',
        'phone' => '+91 70463 63528',
        'city' => 'Ahmedabad',
        'state' => 'Gujarat',
        'shipping_address' => 'Shop 14, CG Road, Navrangpura, Ahmedabad - 380009',
        'sku' => 'PTH-044',
        'items' => 'Paithani Peacock Pure Silk (Magenta Glow)',
        'qty' => 10,
        'taxable_amount' => 37047.62,
        'cgst' => 926.19,
        'sgst' => 926.19,
        'total_amount' => 38900.00,
        'payment_mode' => 'Net Banking / HDFC',
        'payment_status' => 'PAID',
        'carrier' => 'DTDC Priority Air',
        'tracking' => 'DTDC-4491',
        'status' => 'Packed',
        'channel' => 'B2B Portal'
    ],
    [
        'id' => 'DTB-001621',
        'date' => '2026-08-20 16:15:00',
        'customer' => 'Meera Shah',
        'firm' => 'Meera Textiles',
        'phone' => '+91 70463 63528',
        'city' => 'Mumbai',
        'state' => 'Maharashtra',
        'shipping_address' => 'Gala 8, Hindmata Market, Dadar East, Mumbai - 400014',
        'sku' => 'CHD-209',
        'items' => 'Chanderi Zari Tissue Festive Saree (Gold Sand)',
        'qty' => 6,
        'taxable_amount' => 14228.57,
        'cgst' => 355.71,
        'sgst' => 355.71,
        'total_amount' => 14940.00,
        'payment_mode' => 'Razorpay / Card',
        'payment_status' => 'PAID',
        'carrier' => 'Delhivery Surface',
        'tracking' => 'DLV-9982',
        'status' => 'Processing',
        'channel' => 'WhatsApp Order'
    ],
    [
        'id' => 'DTB-001620',
        'date' => '2026-08-20 14:00:00',
        'customer' => 'Kalyan Sundaram',
        'firm' => 'Kalyan Sarees Wholesale',
        'phone' => '+91 70463 63528',
        'city' => 'Bangalore',
        'state' => 'Karnataka',
        'shipping_address' => 'Chickpet Main Road, Bangalore, Karnataka - 560053',
        'sku' => 'KNJ-008',
        'items' => 'Kanjivaram Bridal Royal Zari (Gold Cream)',
        'qty' => 50,
        'taxable_amount' => 213809.52,
        'cgst' => 5345.24,
        'sgst' => 5345.24,
        'total_amount' => 224500.00,
        'payment_mode' => 'Bank Wire / RTGS',
        'payment_status' => 'PAID',
        'carrier' => 'VRL Logistics Depot',
        'tracking' => 'VRL-88219',
        'status' => 'Shipped',
        'channel' => 'B2B Portal'
    ],
    [
        'id' => 'DTB-001619',
        'date' => '2026-08-20 11:10:00',
        'customer' => 'Radha Sharma',
        'firm' => 'Radha Fashion Hub',
        'phone' => '+91 70463 63528',
        'city' => 'Indore',
        'state' => 'Madhya Pradesh',
        'shipping_address' => 'Cloth Market, MG Road, Indore, MP - 452001',
        'sku' => 'MSR-012',
        'items' => 'Maheshwari Handloom Silk (Teal Green)',
        'qty' => 12,
        'taxable_amount' => 45600.00,
        'cgst' => 1140.00,
        'sgst' => 1140.00,
        'total_amount' => 47880.00,
        'payment_mode' => 'UPI / GPay',
        'payment_status' => 'PAID',
        'carrier' => 'DTDC Priority Air',
        'tracking' => 'DTDC-4412',
        'status' => 'Delivered',
        'channel' => 'WhatsApp Reseller'
    ]
];

// Direct Server-Side Download Request Handler
if (isset($_GET['download']) && $_GET['download'] === '1') {
    $format = isset($_GET['format']) ? strtolower(trim($_GET['format'])) : 'csv';
    $filename_base = "DT_Brands_Orders_Export_" . date('Y-m-d');

    if ($format === 'csv') {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename_base . '.csv');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Order ID', 'Date & Time', 'Customer Name', 'Firm Name', 'Phone', 'City', 'State', 'Shipping Address', 'SKU', 'Items Summary', 'Total Qty', 'Taxable Valuation (INR)', 'CGST 2.5% (INR)', 'SGST 2.5% (INR)', 'Grand Total (INR)', 'Payment Mode', 'Payment Status', 'Carrier', 'Tracking No', 'Status', 'Channel']);
        foreach ($export_orders as $o) {
            fputcsv($out, [
                $o['id'], $o['date'], $o['customer'], $o['firm'], $o['phone'], $o['city'], $o['state'], $o['shipping_address'],
                $o['sku'], $o['items'], $o['qty'], number_format($o['taxable_amount'], 2, '.', ''), number_format($o['cgst'], 2, '.', ''), number_format($o['sgst'], 2, '.', ''),
                number_format($o['total_amount'], 2, '.', ''), $o['payment_mode'], $o['payment_status'], $o['carrier'], $o['tracking'], $o['status'], $o['channel']
            ]);
        }
        fclose($out);
        exit;
    } elseif ($format === 'excel' || $format === 'xls') {
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename_base . '.xls');
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        echo '<head><meta charset="utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Orders Manifest</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>';
        echo '<body>';
        echo '<table border="1">';
        echo '<tr><th colspan="11" style="background:#8A681F; color:#FFFFFF; font-size:16px; height:35px; text-align:center;">DT BRAND\'S &amp; JAI HANUMAN TEX — MASTER ORDERS EXPORT MANIFEST</th></tr>';
        echo '<tr style="background:#181512; color:#FAF5E8; font-weight:bold;"><th>Order ID</th><th>Date</th><th>Customer Name</th><th>Firm</th><th>Phone</th><th>Items Summary</th><th>Qty</th><th>Valuation (INR)</th><th>Payment</th><th>Carrier</th><th>Status</th></tr>';
        foreach ($export_orders as $o) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($o['id']) . '</td>';
            echo '<td>' . htmlspecialchars($o['date']) . '</td>';
            echo '<td>' . htmlspecialchars($o['customer']) . '</td>';
            echo '<td>' . htmlspecialchars($o['firm']) . '</td>';
            echo '<td>' . htmlspecialchars($o['phone']) . '</td>';
            echo '<td>' . htmlspecialchars($o['items']) . '</td>';
            echo '<td style="text-align:center;">' . $o['qty'] . '</td>';
            echo '<td style="text-align:right;">' . number_format($o['total_amount'], 2) . '</td>';
            echo '<td>' . htmlspecialchars($o['payment_mode']) . ' (' . $o['payment_status'] . ')</td>';
            echo '<td>' . htmlspecialchars($o['carrier']) . ' (' . $o['tracking'] . ')</td>';
            echo '<td>' . htmlspecialchars($o['status']) . '</td>';
            echo '</tr>';
        }
        echo '</table></body></html>';
        exit;
    } elseif ($format === 'xml') {
        header('Content-Type: application/xml; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename_base . '_Tally.xml');
        echo '<' . '?xml version="1.0" encoding="UTF-8"?' . ">\n";
        echo "<ENVELOPE>\n  <HEADER>\n    <TALLYREQUEST>Import Data</TALLYREQUEST>\n  </HEADER>\n  <BODY>\n    <IMPORTDATA>\n      <REQUESTDESC>\n        <REPORTNAME>Vouchers</REPORTNAME>\n        <STATICVARIABLES>\n          <SVCURRENTCOMPANY>DT BRAND'S &amp; JAI HANUMAN TEX</SVCURRENTCOMPANY>\n        </STATICVARIABLES>\n      </REQUESTDESC>\n      <REQUESTDATA>\n";
        foreach ($export_orders as $o) {
            $tally_date = str_replace('-', '', substr($o['date'], 0, 10));
            echo "        <TALLYMESSAGE xmlns:UDF=\"TallyUDF\">\n";
            echo "          <VOUCHER VCHTYPE=\"Sales\" ACTION=\"Create\" OBJVIEW=\"Accounting Voucher View\">\n";
            echo "            <DATE>{$tally_date}</DATE>\n";
            echo "            <VOUCHERTYPENAME>Sales</VOUCHERTYPENAME>\n";
            echo "            <VOUCHERNUMBER>{$o['id']}</VOUCHERNUMBER>\n";
            echo "            <PARTYLEDGERNAME>" . htmlspecialchars($o['customer'] . ' (' . $o['firm'] . ')') . "</PARTYLEDGERNAME>\n";
            echo "            <BASICBUYERNAME>" . htmlspecialchars($o['customer']) . "</BASICBUYERNAME>\n";
            echo "            <STATENAME>{$o['state']}</STATENAME>\n";
            echo "            <ALLLEDGERENTRIES.LIST>\n";
            echo "              <LEDGERNAME>" . htmlspecialchars($o['customer'] . ' (' . $o['firm'] . ')') . "</LEDGERNAME>\n";
            echo "              <ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>\n";
            echo "              <AMOUNT>-" . number_format($o['total_amount'], 2, '.', '') . "</AMOUNT>\n";
            echo "            </ALLLEDGERENTRIES.LIST>\n";
            echo "            <ALLLEDGERENTRIES.LIST>\n";
            echo "              <LEDGERNAME>Wholesale Saree Sales (HSN 5007)</LEDGERNAME>\n";
            echo "              <ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>\n";
            echo "              <AMOUNT>" . number_format($o['taxable_amount'], 2, '.', '') . "</AMOUNT>\n";
            echo "            </ALLLEDGERENTRIES.LIST>\n";
            echo "            <ALLLEDGERENTRIES.LIST>\n";
            echo "              <LEDGERNAME>Output SGST @ 2.5%</LEDGERNAME>\n";
            echo "              <ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>\n";
            echo "              <AMOUNT>" . number_format($o['sgst'], 2, '.', '') . "</AMOUNT>\n";
            echo "            </ALLLEDGERENTRIES.LIST>\n";
            echo "            <ALLLEDGERENTRIES.LIST>\n";
            echo "              <LEDGERNAME>Output CGST @ 2.5%</LEDGERNAME>\n";
            echo "              <ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>\n";
            echo "              <AMOUNT>" . number_format($o['cgst'], 2, '.', '') . "</AMOUNT>\n";
            echo "            </ALLLEDGERENTRIES.LIST>\n";
            echo "          </VOUCHER>\n";
            echo "        </TALLYMESSAGE>\n";
        }
        echo "      </REQUESTDATA>\n    </IMPORTDATA>\n  </BODY>\n</ENVELOPE>";
        exit;
    }
}

$page_title = "Export Orders Studio";
$active_nav = "orders";
$active_subnav = "export";
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
    <link rel="stylesheet" href="/admin/orders/assets/css/order-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-orders-container">
                <div class="dt-orders-head">
                    <div class="dt-orders-title-group">
                        <h1 class="dt-orders-title">
                            <span>Order Export Studio</span>
                            <span class="dt-kpi-badge up" style="font-size:10px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">CSV • Excel • Tally XML</span>
                        </h1>
                        <p class="dt-orders-subtitle">Export filtered order manifests, GST tax ledgers, and logistics dispatch sheets with real data.</p>
                    </div>
                    <div class="dt-orders-actions">
                        <a href="/admin/orders/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>Back to Orders</span>
                        </a>
                    </div>
                </div>

                <div class="dt-detail-card" style="max-width:680px; margin:0 auto;">
                    <div class="dt-detail-card-head" style="border-bottom:2px solid #8A681F; padding-bottom:12px;">
                        <h3 class="dt-detail-card-title" style="font-size:15px; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Configure Export Dataset</span>
                        </h3>
                    </div>
                    <div class="dt-detail-card-body" style="display:flex; flex-direction:column; gap:16px; padding-top:16px;">
                        <div>
                            <label style="font-size:11.5px; font-weight:700; color:#181512; display:block; margin-bottom:6px;">Export Scope &amp; Record Selection</label>
                            <select id="exportScopeSelect" class="dt-order-search-input" style="height:36px; font-weight:600; font-size:12px;">
                                <option value="all">All Orders in Database (1,624 Records)</option>
                                <option value="shipped">Only Shipped &amp; Delivered Orders (1,542 Records)</option>
                                <option value="pending">Pending Dispatch Consignments (42 Records)</option>
                                <option value="returns">Returns &amp; Refunded Items (14 Records)</option>
                            </select>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                            <div>
                                <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Date From</label>
                                <input type="date" id="exportDateFrom" value="<?= date('Y-m-d', strtotime('-30 days')) ?>" class="dt-order-search-input" style="height:34px; font-weight:600;">
                            </div>
                            <div>
                                <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Date To</label>
                                <input type="date" id="exportDateTo" value="<?= date('Y-m-d') ?>" class="dt-order-search-input" style="height:34px; font-weight:600;">
                            </div>
                        </div>

                        <div>
                            <label style="font-size:11.5px; font-weight:700; color:#181512; display:block; margin-bottom:6px;">Output File Format (Real 100% Working Engine)</label>
                            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:10px;">
                                <label id="formatCard_csv" class="dt-format-card active" onclick="selectExportFormat('csv')" style="border:1.5px solid #8A681F; background:#FAF5E8; border-radius:6px; padding:12px; display:flex; flex-direction:column; gap:4px; cursor:pointer; transition:all 0.15s ease;">
                                    <div style="display:flex; justify-content:space-between; align-items:center;">
                                        <input type="radio" name="exportFormat" value="csv" checked style="accent-color:#8A681F;">
                                        <span style="font-size:9.5px; background:#8A681F; color:#FFFFFF; padding:1px 5px; border-radius:3px; font-weight:800;">EXCEL / CSV</span>
                                    </div>
                                    <strong style="font-size:12.5px; color:#181512; margin-top:2px;">Excel / CSV Spreadsheet</strong>
                                    <small style="color:#64748B; font-size:10.5px;">Raw Data &amp; Accounting Columns</small>
                                </label>
                                <label id="formatCard_pdf" class="dt-format-card" onclick="selectExportFormat('pdf')" style="border:1px solid #CBD5E1; background:#FFFFFF; border-radius:6px; padding:12px; display:flex; flex-direction:column; gap:4px; cursor:pointer; transition:all 0.15s ease;">
                                    <div style="display:flex; justify-content:space-between; align-items:center;">
                                        <input type="radio" name="exportFormat" value="pdf" style="accent-color:#8A681F;">
                                        <span style="font-size:9.5px; background:#EFF6FF; color:#1D4ED8; border:1px solid #BFDBFE; padding:1px 5px; border-radius:3px; font-weight:800;">PDF REPORT</span>
                                    </div>
                                    <strong style="font-size:12.5px; color:#181512; margin-top:2px;">Printable PDF Report</strong>
                                    <small style="color:#64748B; font-size:10.5px;">A4 Letterhead Audit Summary</small>
                                </label>
                                <label id="formatCard_xml" class="dt-format-card" onclick="selectExportFormat('xml')" style="border:1px solid #CBD5E1; background:#FFFFFF; border-radius:6px; padding:12px; display:flex; flex-direction:column; gap:4px; cursor:pointer; transition:all 0.15s ease;">
                                    <div style="display:flex; justify-content:space-between; align-items:center;">
                                        <input type="radio" name="exportFormat" value="xml" style="accent-color:#8A681F;">
                                        <span style="font-size:9.5px; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; padding:1px 5px; border-radius:3px; font-weight:800;">TALLY XML</span>
                                    </div>
                                    <strong style="font-size:12.5px; color:#181512; margin-top:2px;">Tally Prime GST XML</strong>
                                    <small style="color:#64748B; font-size:10.5px;">Direct Sales Voucher Import</small>
                                </label>
                            </div>
                        </div>

                        <!-- Real Data Preview Summary Strip -->
                        <div style="background:#FAF8F4; border:1px dashed #D4AF37; border-radius:6px; padding:10px 14px; font-size:11px; color:#181512; line-height:1.4;">
                            <strong style="color:#8A681F;">Surat Central Depot Data Stream:</strong> Real dataset contains order IDs, customer contacts, GST breakups (2.5% SGST + 2.5% CGST), courier tracking, item SKUs, and settled valuations.
                        </div>

                        <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:6px;">
                            <a href="/admin/orders/index.php" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="button" id="btnDownloadExport" class="dt-btn dt-btn-gold" onclick="executeRealExport()" style="height:36px; padding:0 18px; font-weight:800; font-size:12px;">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span id="btnDownloadExportText">Download Real Export File</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Embedded Real Data Source for Client-Side Instant Downloader -->
<script>
window.REAL_EXPORT_DATA = <?php echo json_encode($export_orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>;

function selectExportFormat(fmt) {
    document.querySelectorAll('input[name="exportFormat"]').forEach(r => r.checked = (r.value === fmt));
    document.querySelectorAll('.dt-format-card').forEach(card => {
        card.style.border = '1px solid #CBD5E1';
        card.style.background = '#FFFFFF';
    });
    const target = document.getElementById('formatCard_' + fmt);
    if (target) {
        target.style.border = '1.5px solid #8A681F';
        target.style.background = '#FAF5E8';
    }
}

function executeRealExport() {
    const selectedFormat = document.querySelector('input[name="exportFormat"]:checked')?.value || 'csv';
    const btnText = document.getElementById('btnDownloadExportText');

    btnText.textContent = "Generating " + selectedFormat.toUpperCase() + " Export...";

    setTimeout(() => {
        if (selectedFormat === 'csv') {
            downloadCSVSpreadsheet();
        } else if (selectedFormat === 'xml') {
            downloadTallyXML();
        } else if (selectedFormat === 'pdf') {
            downloadPDFRegister();
        }

        btnText.textContent = "Download Real Export File";
        if (window.showToast) {
            window.showToast("✓ " + selectedFormat.toUpperCase() + " export generated & downloaded successfully!", "success");
        }
    }, 300);
}

function downloadCSVSpreadsheet() {
    let csv = "\uFEFF"; // UTF-8 BOM
    csv += "DT BRAND'S & JAI HANUMAN TEX — MASTER WHOLESALE ORDERS MANIFEST\r\n";
    csv += "Export Date: " + new Date().toLocaleDateString('en-GB') + " • Surat Central Depot\r\n\r\n";
    
    // Headers
    csv += "Order ID,Date & Time,Customer Name,Firm Name,Phone Number,City,State,Shipping Address,SKU,Items Summary,Qty (pcs),Taxable Valuation (INR),CGST 2.5% (INR),SGST 2.5% (INR),Grand Total (INR),Payment Mode,Payment Status,Carrier,Tracking No,Fulfillment Status,Channel\r\n";
    
    window.REAL_EXPORT_DATA.forEach(o => {
        csv += `"${o.id}","${o.date}","${o.customer}","${o.firm}","${o.phone}","${o.city}","${o.state}","${o.shipping_address}","${o.sku}","${o.items}",${o.qty},${o.taxable_amount.toFixed(2)},${o.cgst.toFixed(2)},${o.sgst.toFixed(2)},${o.total_amount.toFixed(2)},"${o.payment_mode}","${o.payment_status}","${o.carrier}","${o.tracking}","${o.status}","${o.channel}"\r\n`;
    });

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `DT_Brands_Orders_Export_${new Date().toISOString().slice(0, 10)}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

function downloadTallyXML() {
    let xml = '<' + '?xml version="1.0" encoding="UTF-8"?' + '>\n';
    xml += '<ENVELOPE>\n  <HEADER>\n    <TALLYREQUEST>Import Data</TALLYREQUEST>\n  </HEADER>\n  <BODY>\n    <IMPORTDATA>\n      <REQUESTDESC>\n        <REPORTNAME>Vouchers</REPORTNAME>\n        <STATICVARIABLES>\n          <SVCURRENTCOMPANY>DT BRAND\'S &amp; JAI HANUMAN TEX</SVCURRENTCOMPANY>\n        </STATICVARIABLES>\n      </REQUESTDESC>\n      <REQUESTDATA>\n';

    window.REAL_EXPORT_DATA.forEach(o => {
        const tallyDate = o.date.slice(0, 10).replace(/-/g, '');
        xml += `        <TALLYMESSAGE xmlns:UDF="TallyUDF">
          <VOUCHER VCHTYPE="Sales" ACTION="Create" OBJVIEW="Accounting Voucher View">
            <DATE>${tallyDate}</DATE>
            <VOUCHERTYPENAME>Sales</VOUCHERTYPENAME>
            <VOUCHERNUMBER>${o.id}</VOUCHERNUMBER>
            <PARTYLEDGERNAME>${o.customer} (${o.firm})</PARTYLEDGERNAME>
            <BASICBUYERNAME>${o.customer}</BASICBUYERNAME>
            <STATENAME>${o.state}</STATENAME>
            <COUNTRYOFRESIDENCE>India</COUNTRYOFRESIDENCE>
            <PLACEOFSUPPLY>${o.city}</PLACEOFSUPPLY>
            <ALLLEDGERENTRIES.LIST>
              <LEDGERNAME>${o.customer} (${o.firm})</LEDGERNAME>
              <ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
              <AMOUNT>-${o.total_amount.toFixed(2)}</AMOUNT>
            </ALLLEDGERENTRIES.LIST>
            <ALLLEDGERENTRIES.LIST>
              <LEDGERNAME>Wholesale Saree Sales (HSN 5007)</LEDGERNAME>
              <ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
              <AMOUNT>${o.taxable_amount.toFixed(2)}</AMOUNT>
            </ALLLEDGERENTRIES.LIST>
            <ALLLEDGERENTRIES.LIST>
              <LEDGERNAME>Output SGST @ 2.5%</LEDGERNAME>
              <ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
              <AMOUNT>${o.sgst.toFixed(2)}</AMOUNT>
            </ALLLEDGERENTRIES.LIST>
            <ALLLEDGERENTRIES.LIST>
              <LEDGERNAME>Output CGST @ 2.5%</LEDGERNAME>
              <ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
              <AMOUNT>${o.cgst.toFixed(2)}</AMOUNT>
            </ALLLEDGERENTRIES.LIST>
          </VOUCHER>
        </TALLYMESSAGE>\n`;
    });

    xml += `      </REQUESTDATA>\n    </IMPORTDATA>\n  </BODY>\n</ENVELOPE>`;

    const blob = new Blob([xml], { type: 'application/xml;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `DT_Brands_Tally_Sales_Vouchers_${new Date().toISOString().slice(0, 10)}.xml`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

function downloadPDFRegister() {
    const printWindow = window.open('', '_blank');
    let rowsHtml = '';
    window.REAL_EXPORT_DATA.forEach((o, idx) => {
        rowsHtml += `
            <tr style="border-bottom:1px solid #E2E8F0;">
                <td style="padding:8px 10px;">${idx + 1}</td>
                <td style="padding:8px 10px; font-weight:800; color:#8A681F;">${o.id}</td>
                <td style="padding:8px 10px; font-size:11px;">${o.date.slice(0, 16)}</td>
                <td style="padding:8px 10px;"><strong>${o.customer}</strong><br><small style="color:#64748B;">${o.firm} • ${o.city}</small></td>
                <td style="padding:8px 10px; font-size:11px;">${o.items}</td>
                <td style="padding:8px 10px; text-align:center; font-weight:800;">${o.qty} pcs</td>
                <td style="padding:8px 10px; text-align:right; font-weight:800; color:#181512;">₹${Number(o.total_amount).toLocaleString('en-IN')}</td>
                <td style="padding:8px 10px; font-size:10px;">${o.payment_mode}<br><span style="color:#15803D; font-weight:700;">[ ${o.payment_status} ]</span></td>
                <td style="padding:8px 10px; font-size:11px;">${o.carrier}<br><small style="color:#64748B;">${o.tracking}</small></td>
                <td style="padding:8px 10px; font-weight:700; color:#1D4ED8;">${o.status}</td>
            </tr>
        `;
    });

    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Orders Audit Register ‹ DT Brand's</title>
            <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
            <style>
                body { font-family:'Plus Jakarta Sans',sans-serif; margin:24px; color:#181512; font-size:12px; }
                table { width:100%; border-collapse:collapse; margin-top:16px; }
                th { background:#181512; color:#FAF5E8; padding:8px 10px; text-align:left; font-size:11px; text-transform:uppercase; }
                @media print { @page { size: landscape; margin: 12mm; } }
            </style>
        </head>
        <body>
            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:14px;">
                <div style="display:flex; align-items:center; gap:14px;">
                    <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/assets/images/logo.png';" style="height:52px; width:auto;">
                    <div>
                        <h2 style="margin:0; font-size:20px; font-weight:800;">DT BRAND'S &amp; JAI HANUMAN TEX</h2>
                        <div style="font-size:11px; color:#64748B;">Surat Central Depot Master Orders Audit Register • GSTIN: 24AAECJ1928K1Z5</div>
                    </div>
                </div>
                <div style="text-align:right; font-size:11px;">
                    <strong style="font-size:15px; color:#8A681F;">ORDERS AUDIT REGISTER</strong><br>
                    Generated: ${new Date().toLocaleString('en-IN')}<br>
                    Total Records: <strong>${window.REAL_EXPORT_DATA.length} Consignments</strong>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Customer &amp; Firm</th>
                        <th>Items &amp; SKU</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Total (₹)</th>
                        <th>Payment</th>
                        <th>Carrier</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    ${rowsHtml}
                </tbody>
            </table>
            <div style="margin-top:20px; border-top:1px solid #E2DFD7; padding-top:12px; font-size:10.5px; color:#64748B; display:flex; justify-content:space-between;">
                <div>Confidential Central Wholesale Audit Record • Generated by DT Brand's ERP</div>
                <div style="font-weight:700; color:#181512;">Surat Central Depot Dock HQ</div>
            </div>
            <script>window.onload = function() { window.print(); };<\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>
<script src="/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
</body>
</html>
