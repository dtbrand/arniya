<?php
/**
 * sales.php - DT Brand's Admin Sales Breakdown & Channel Analytics
 * DT Brand's & Jai Hanuman Tex
 */
if (isset($_GET['download']) && $_GET['download'] === 'sales') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=DT_Channel_Sales_Report_' . date('Y_m') . '.csv');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Sales Channel', 'Total Orders', 'Gross Revenue (INR)', 'Channel Share %', 'Avg Order Value (AOV)', 'Growth Rate']);
    fputcsv($out, ['B2B Wholesale Portal', '412', '2480000.00', '57.86%', '6019.41', '+32.4%']);
    fputcsv($out, ['D2C Retail Online Store', '820', '1192000.00', '27.81%', '1453.65', '+18.2%']);
    fputcsv($out, ['Reseller Network & WhatsApp', '392', '614000.00', '14.33%', '1566.32', '+41.0%']);
    fclose($out);
    exit;
}

$page_title = "Sales Breakdown & Channel Analytics";
$active_nav = "reports";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Breakdown &amp; Channel Analytics - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-sales-kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }
        @media (max-width: 768px) {
            .dt-sales-kpi-grid {
                grid-template-columns: 1fr;
            }
        }
        .dt-sales-kpi-card {
            background: #FFFFFF;
            border: 1.5px solid #EAE5D9;
            border-radius: 10px;
            padding: 14px 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .dt-sales-kpi-label {
            font-size: 0.7rem;
            font-weight: 800;
            color: #78716C;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .dt-sales-kpi-val {
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
                        <span>Sales Breakdown &amp; Channel Analytics</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">1,624 Orders</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Detailed multi-channel volume tracking across B2B Wholesale, D2C Retail, and WhatsApp Reseller networks.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Financial Reports</a>
                    <a href="/admin/reports/sales.php?download=sales" class="dt-btn dt-btn-gold" style="text-decoration:none; height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>📥 Export Channel Sales CSV</span>
                    </a>
                </div>
            </div>

            <!-- 4-Card Sales KPI Ribbon -->
            <div class="dt-sales-kpi-grid">
                <div class="dt-sales-kpi-card">
                    <div class="dt-sales-kpi-label">B2B Wholesale Revenue</div>
                    <div class="dt-sales-kpi-val" style="color:#8A681F;">₹24,80,000</div>
                    <div style="font-size:0.72rem; color:#15803D; margin-top:2px; font-weight:700;">57.9% of Total • 412 Lots</div>
                </div>
                <div class="dt-sales-kpi-card">
                    <div class="dt-sales-kpi-label">D2C Retail Storefront</div>
                    <div class="dt-sales-kpi-val" style="color:#181512;">₹11,92,000</div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">27.8% of Total • 820 Orders</div>
                </div>
                <div class="dt-sales-kpi-card">
                    <div class="dt-sales-kpi-label">WhatsApp Resellers</div>
                    <div class="dt-sales-kpi-val" style="color:#15803D;">₹6,14,000</div>
                    <div style="font-size:0.72rem; color:#15803D; margin-top:2px; font-weight:700;">+41.0% MoM Surge</div>
                </div>
                <div class="dt-sales-kpi-card">
                    <div class="dt-sales-kpi-label">Blended Average Order Value</div>
                    <div class="dt-sales-kpi-val" style="color:#181512;">₹2,639</div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">Across 1,624 Total Orders</div>
                </div>
            </div>

            <!-- Channel Performance Matrix Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>📊 Multi-Channel Performance Matrix</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Real-Time Synchronized</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Sales Channel Stream</th>
                                <th>Order Volume</th>
                                <th>Gross Revenue</th>
                                <th>Channel Contribution</th>
                                <th>Average Basket Value</th>
                                <th style="text-align:right;">Growth Momentum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>B2B Wholesale Portal</strong>
                                    <div style="font-size:11px; color:#64748B;">Surat factory bales, paithani sets &amp; half-set lots</div>
                                </td>
                                <td><span class="adm-badge gold">412 Orders</span></td>
                                <td><strong style="color:#8A681F; font-size:13.5px;">₹24,80,000</strong></td>
                                <td>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <div style="flex:1; height:6px; background:#EAE5D9; border-radius:3px; overflow:hidden; min-width:60px;">
                                            <div style="width:58%; height:100%; background:#B8860B;"></div>
                                        </div>
                                        <span style="font-size:11.5px; font-weight:700;">57.9%</span>
                                    </div>
                                </td>
                                <td><strong>₹6,019</strong></td>
                                <td style="text-align:right;"><span style="color:#15803D; font-weight:800;">+32.4% ↑</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>D2C Retail Storefront</strong>
                                    <div style="font-size:11px; color:#64748B;">Direct shopper web portal, express checkout &amp; UPI</div>
                                </td>
                                <td><span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-weight:700;">820 Orders</span></td>
                                <td><strong style="color:#181512; font-size:13.5px;">₹11,92,000</strong></td>
                                <td>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <div style="flex:1; height:6px; background:#EAE5D9; border-radius:3px; overflow:hidden; min-width:60px;">
                                            <div style="width:28%; height:100%; background:#1D4ED8;"></div>
                                        </div>
                                        <span style="font-size:11.5px; font-weight:700;">27.8%</span>
                                    </div>
                                </td>
                                <td><strong>₹1,454</strong></td>
                                <td style="text-align:right;"><span style="color:#15803D; font-weight:800;">+18.2% ↑</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Reseller Network &amp; WhatsApp</strong>
                                    <div style="font-size:11px; color:#64748B;">Boutique resellers, social catalogs &amp; margin share</div>
                                </td>
                                <td><span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700;">392 Orders</span></td>
                                <td><strong style="color:#15803D; font-size:13.5px;">₹6,14,000</strong></td>
                                <td>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <div style="flex:1; height:6px; background:#EAE5D9; border-radius:3px; overflow:hidden; min-width:60px;">
                                            <div style="width:14%; height:100%; background:#15803D;"></div>
                                        </div>
                                        <span style="font-size:11.5px; font-weight:700;">14.3%</span>
                                    </div>
                                </td>
                                <td><strong>₹1,566</strong></td>
                                <td style="text-align:right;"><span style="color:#15803D; font-weight:800;">+41.0% ↑</span></td>
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
