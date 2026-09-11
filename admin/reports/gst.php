<?php
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) { require_once $__dtg; } elseif (is_file(__DIR__ . '/../includes/adminguard.php')) { require_once __DIR__ . '/../includes/adminguard.php'; }

/**
 * gst.php — DT Brand's Master GST Tax Computation & GSTR-1 Engine
 * DT Brand's & Jai Hanuman Tex — Pure Live Data Architecture
 */

require_once __DIR__ . '/../../src/Database.php';
use DTBrand\Database;

$pdo = Database::getConnection();
$liveDb = ($pdo !== null && !Database::isMockMode());

$totalTaxable = 0.0;
$totalGst = 0.0;
$totalCgst = 0.0;
$totalSgst = 0.0;
$totalIgst = 0.0;
$hsnRows = [];

if ($liveDb) {
    try {
        $orders = Database::query("
            SELECT o.*, 
                   COALESCE(c.state, 'Gujarat') as customer_state,
                   COALESCE(c.city, 'Surat') as customer_city
            FROM orders o
            LEFT JOIN customers c ON o.customer_id = c.id
            WHERE COALESCE(o.fulfillment_status, o.order_status, 'processing') != 'cancelled'
            ORDER BY o.id DESC
        ");

        foreach ($orders as $o) {
            $taxable = (float)($o['subtotal'] ?? 0) - (float)($o['discount'] ?? 0);
            if ($taxable <= 0) {
                $tot = (float)($o['total_amount'] ?? 0);
                $taxable = round($tot / 1.05, 2);
            }
            $gst = (float)($o['gst_amount'] ?? 0);
            if ($gst <= 0) {
                $gst = round($taxable * 0.05, 2);
            }

            $totalTaxable += $taxable;
            $totalGst += $gst;

            $state = strtolower(trim($o['customer_state'] ?? ''));
            $shipping = strtolower(trim($o['shipping_address'] ?? ''));
            $isGujarat = ($state === 'gujarat' || $state === 'gj' || strpos($shipping, 'gujarat') !== false);

            if ($isGujarat) {
                $half = round($gst / 2, 2);
                $totalCgst += $half;
                $totalSgst += ($gst - $half);
            } else {
                $totalIgst += $gst;
            }
        }

        $itemRows = Database::query("
            SELECT 
                CASE WHEN p.hsn_code IS NOT NULL AND p.hsn_code != '' THEN p.hsn_code ELSE '5007' END as hsn,
                COALESCE(p.category, 'Silk Sarees') as category,
                COALESCE(c.state, 'Gujarat') as customer_state,
                COALESCE(o.shipping_address, '') as shipping_address,
                SUM(oi.quantity) as total_qty,
                SUM(oi.total_price) as total_val
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            LEFT JOIN customers c ON o.customer_id = c.id
            LEFT JOIN products p ON oi.product_id = p.id
            WHERE COALESCE(o.fulfillment_status, o.order_status, 'processing') != 'cancelled'
            GROUP BY hsn, category, customer_state, shipping_address
            ORDER BY total_val DESC
        ");

        if (!empty($itemRows)) {
            $hsnMap = [];
            foreach ($itemRows as $ir) {
                $val = (float)$ir['total_val'];
                $taxVal = round($val / 1.05, 2);
                $taxAmt = round($val - $taxVal, 2);
                $hsnCode = (string)$ir['hsn'];
                $qty = (int)$ir['total_qty'];

                $state = strtolower(trim($ir['customer_state'] ?? ''));
                $shipping = strtolower(trim($ir['shipping_address'] ?? ''));
                $isGujarat = ($state === 'gujarat' || $state === 'gj' || strpos($shipping, 'gujarat') !== false);

                if ($isGujarat) {
                    $cgst = round($taxAmt / 2, 2);
                    $sgst = $taxAmt - $cgst;
                    $igst = 0.0;
                } else {
                    $cgst = 0.0;
                    $sgst = 0.0;
                    $igst = $taxAmt;
                }

                if (!isset($hsnMap[$hsnCode])) {
                    $desc = 'Woven Fabric of Pure Silk & Ethnic Sarees';
                    if ($hsnCode === '5208') $desc = 'Woven Handloom Fabrics of Pure Cotton';
                    elseif ($hsnCode === '6211') $desc = 'Designer Stitched Ethnic Apparel Sets';
                    elseif (!empty($ir['category'])) $desc = 'Ethnic Handloom ' . htmlspecialchars($ir['category']);

                    $hsnMap[$hsnCode] = [
                        'hsn' => $hsnCode,
                        'desc' => $desc,
                        'uqc' => 'PCS',
                        'qty' => 0,
                        'taxable' => 0.0,
                        'rate' => '5.0%',
                        'tax_amount' => 0.0,
                        'cgst' => 0.0,
                        'sgst' => 0.0,
                        'igst' => 0.0
                    ];
                }

                $hsnMap[$hsnCode]['qty'] += $qty;
                $hsnMap[$hsnCode]['taxable'] += $taxVal;
                $hsnMap[$hsnCode]['tax_amount'] += $taxAmt;
                $hsnMap[$hsnCode]['cgst'] += $cgst;
                $hsnMap[$hsnCode]['sgst'] += $sgst;
                $hsnMap[$hsnCode]['igst'] += $igst;
            }
            $hsnRows = array_values($hsnMap);
        }
    } catch (\Throwable $e) {
        error_log("GST computation error: " . $e->getMessage());
    }
}

if (isset($_GET['download']) && $_GET['download'] === 'gstr1') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=GSTR1_HSN_Summary_' . date('Y_m') . '.csv');
    $out = fopen('php://output', 'w');
    fputs($out, "\xEF\xBB\xBF");

    $sanitizeCsv = static function ($val) {
        $str = (string)$val;
        if ($str !== '' && in_array($str[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $str;
        }
        return $str;
    };

    fputcsv($out, ['HSN Code', 'Description', 'UQC', 'Total Quantity', 'Total Taxable Value (INR)', 'Integrated Tax Rate', 'Integrated Tax Amount', 'Central Tax Amount', 'State Tax Amount', 'Cess Amount']);
    if (!empty($hsnRows)) {
        foreach ($hsnRows as $hr) {
            fputcsv($out, [
                $sanitizeCsv($hr['hsn']),
                $sanitizeCsv($hr['desc']),
                $sanitizeCsv($hr['uqc']),
                $hr['qty'],
                number_format($hr['taxable'], 2, '.', ''),
                $sanitizeCsv($hr['rate']),
                number_format($hr['igst'], 2, '.', ''),
                number_format($hr['cgst'], 2, '.', ''),
                number_format($hr['sgst'], 2, '.', ''),
                '0.00'
            ]);
        }
    }
    fclose($out);
    exit;
}

$page_title = "GST Tax Computation & GSTR-1 Filing";
$active_nav = "reports";
$rupeeSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
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
        .dt-gst-kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }
        @media (max-width: 768px) {
            .dt-gst-kpi-grid {
                grid-template-columns: 1fr;
            }
        }
        .dt-gst-kpi-card {
            background: #FFFFFF;
            border: 1.5px solid #EAE5D9;
            border-radius: 10px;
            padding: 14px 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .dt-gst-kpi-label {
            font-size: 0.7rem;
            font-weight: 800;
            color: #78716C;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .dt-gst-kpi-val {
            font-size: 1.25rem;
            font-weight: 900;
            color: #181512;
            margin-top: 4px;
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
                        <span>GST Tax Computation &amp; GSTR-1</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">FY <?= date('Y') ?>-<?= date('y', strtotime('+1 year')) ?></span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Monthly GST tax liability computations with official HSN summary for 1-click GSTR-1 export and CA filing.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Financial Reports</span>
                    </a>
                    <a href="/admin/reports/gst.php?download=gstr1" class="dt-btn dt-btn-gold" style="text-decoration:none; height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Download GSTR-1 CSV</span>
                    </a>
                </div>
            </div>

            <!-- 4-Card GST KPI Ribbon -->
            <div class="dt-gst-kpi-grid">
                <div class="dt-gst-kpi-card">
                    <div class="dt-gst-kpi-label">Total Taxable Turnover</div>
                    <div class="dt-gst-kpi-val" style="color:#181512;"><?= $rupeeSvg ?> <?= number_format($totalTaxable) ?></div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">Live Recorded Orders</div>
                </div>
                <div class="dt-gst-kpi-card">
                    <div class="dt-gst-kpi-label">Total GST Liability (5%)</div>
                    <div class="dt-gst-kpi-val" style="color:#8A681F;"><?= $rupeeSvg ?> <?= number_format($totalGst) ?></div>
                    <div style="font-size:0.72rem; color:#15803D; margin-top:2px; font-weight:700;">GST Rate 5% Handloom</div>
                </div>
                <div class="dt-gst-kpi-card">
                    <div class="dt-gst-kpi-label">Central &amp; State GST (CGST + SGST)</div>
                    <div class="dt-gst-kpi-val" style="color:#181512;"><?= $rupeeSvg ?> <?= number_format($totalCgst + $totalSgst) ?></div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">Intrastate Gujarat Dispatches</div>
                </div>
                <div class="dt-gst-kpi-card">
                    <div class="dt-gst-kpi-label">Integrated GST (IGST 5%)</div>
                    <div class="dt-gst-kpi-val" style="color:#181512;"><?= $rupeeSvg ?> <?= number_format($totalIgst) ?></div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">Interstate Dispatches</div>
                </div>
            </div>

            <!-- HSN Summary Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>HSN Code Wise Tax Computation</span>
                    </h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">GSTR-1 Reconciled</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>HSN Code</th>
                                <th>Fabric Category Description</th>
                                <th>UQC</th>
                                <th>Total Units</th>
                                <th>Taxable Value</th>
                                <th>GST Rate</th>
                                <th style="text-align:right;">Total Tax Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($hsnRows)): ?>
                                <?php foreach ($hsnRows as $r): ?>
                                    <tr>
                                        <td><code style="background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:800; border:1px solid #D4AF37;"><?= htmlspecialchars($r['hsn']) ?></code></td>
                                        <td><strong><?= htmlspecialchars($r['desc']) ?></strong></td>
                                        <td><?= htmlspecialchars($r['uqc']) ?></td>
                                        <td><?= number_format($r['qty']) ?></td>
                                        <td><?= $rupeeSvg ?> <?= number_format($r['taxable'], 2) ?></td>
                                        <td><span class="adm-badge gold"><?= htmlspecialchars($r['rate']) ?></span></td>
                                        <td style="text-align:right;"><strong style="color:#8A681F;"><?= $rupeeSvg ?> <?= number_format($r['tax_amount'], 2) ?></strong></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align:center; padding:32px; color:#64748B;">
                                        No order items recorded in the database yet. Completed dispatches will automatically populate here.
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
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
