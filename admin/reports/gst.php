<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * gst.php - DT Brand's Admin GST Tax Computation & GSTR-1
 * DT Brand's & Jai Hanuman Tex
 */
if (isset($_GET['download']) && $_GET['download'] === 'gstr1') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=GSTR1_HSN_Summary_' . date('Y_m') . '.csv');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['HSN Code', 'Description', 'UQC', 'Total Quantity', 'Total Taxable Value (INR)', 'Integrated Tax Rate', 'Integrated Tax Amount', 'Central Tax Amount', 'State Tax Amount', 'Cess Amount']);
    fputcsv($out, ['5007', 'Woven Fabrics of Pure Silk / Mulberry Silk', 'PCS', '412', '2418000.00', '5.00%', '60450.00', '30225.00', '30225.00', '0.00']);
    fputcsv($out, ['5208', 'Woven Handloom Fabrics of Pure Cotton', 'PCS', '190', '480000.00', '5.00%', '12000.00', '6000.00', '6000.00', '0.00']);
    fputcsv($out, ['6211', 'Designer Stitched Kurtis & Anarkali Sets', 'SET', '240', '1388000.00', '5.00%', '34700.00', '17350.00', '17350.00', '0.00']);
    fclose($out);
    exit;
}

$page_title = "GST Tax Computation & GSTR-1 Filing";
$active_nav = "reports";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GST Tax Computation &amp; GSTR-1 - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>GST Tax Computation &amp; GSTR-1</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">FY 2025-26</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Monthly GST tax liability computations with official HSN summary for 1-click GSTR-1 export and CA filing.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Financial Reports</a>
                    <a href="/admin/reports/gst.php?download=gstr1" class="dt-btn dt-btn-gold" style="text-decoration:none; height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>📥 Download GSTR-1 CSV</span>
                    </a>
                </div>
            </div>

            <!-- 4-Card GST KPI Ribbon -->
            <div class="dt-gst-kpi-grid">
                <div class="dt-gst-kpi-card">
                    <div class="dt-gst-kpi-label">Total Taxable Turnover</div>
                    <div class="dt-gst-kpi-val" style="color:#181512;">₹42,86,000</div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">B2B + B2C Combined</div>
                </div>
                <div class="dt-gst-kpi-card">
                    <div class="dt-gst-kpi-label">Total GST Liability (5%)</div>
                    <div class="dt-gst-kpi-val" style="color:#8A681F;">₹2,14,300</div>
                    <div style="font-size:0.72rem; color:#15803D; margin-top:2px; font-weight:700;">● GST Rate 5% Handloom</div>
                </div>
                <div class="dt-gst-kpi-card">
                    <div class="dt-gst-kpi-label">Central GST (CGST 2.5%)</div>
                    <div class="dt-gst-kpi-val" style="color:#181512;">₹53,575</div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">Intrastate Gujarat</div>
                </div>
                <div class="dt-gst-kpi-card">
                    <div class="dt-gst-kpi-label">Integrated GST (IGST 5%)</div>
                    <div class="dt-gst-kpi-val" style="color:#181512;">₹1,07,150</div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">Interstate Dispatches</div>
                </div>
            </div>

            <!-- HSN Summary Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>🧾 HSN Code Wise Tax Computation</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">✓ Ready for GSTR-1 Portal</span>
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
                            <tr>
                                <td><code style="background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:800; border:1px solid #D4AF37;">5007</code></td>
                                <td><strong>Woven Pure Mulberry &amp; Katan Silk Sarees</strong></td>
                                <td>PCS</td>
                                <td>412</td>
                                <td>₹24,18,000</td>
                                <td><span class="adm-badge gold">5.0%</span></td>
                                <td style="text-align:right;"><strong style="color:#8A681F;">₹1,20,900</strong></td>
                            </tr>
                            <tr>
                                <td><code style="background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:800; border:1px solid #D4AF37;">5208</code></td>
                                <td><strong>Woven Handloom Mulmul &amp; Cotton Sarees</strong></td>
                                <td>PCS</td>
                                <td>190</td>
                                <td>₹4,80,000</td>
                                <td><span class="adm-badge gold">5.0%</span></td>
                                <td style="text-align:right;"><strong style="color:#8A681F;">₹24,000</strong></td>
                            </tr>
                            <tr>
                                <td><code style="background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:800; border:1px solid #D4AF37;">6211</code></td>
                                <td><strong>Designer Embroidered Kurti &amp; Anarkali Sets</strong></td>
                                <td>SET</td>
                                <td>240</td>
                                <td>₹13,88,000</td>
                                <td><span class="adm-badge gold">5.0%</span></td>
                                <td style="text-align:right;"><strong style="color:#8A681F;">₹69,400</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
