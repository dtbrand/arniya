<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * sales.php — DT Brand's Master Sales Breakdown & Channel Analytics
 * DT Brand's & Jai Hanuman Tex — Pure Live Data Architecture
 */

require_once __DIR__ . '/../../src/Database.php';
use DTBrand\Database;

$pdo = Database::getConnection();
$liveDb = ($pdo !== null && !Database::isMockMode());

$channelStats = [];
$totalOrders = 0;
$totalRevenue = 0.0;
$b2bRevenue = 0.0;
$retailerRevenue = 0.0;
$d2cRevenue = 0.0;
$resellerRevenue = 0.0;
$b2bCount = 0;
$retailerCount = 0;
$d2cCount = 0;
$resellerCount = 0;

if ($liveDb) {
    try {
        $rows = Database::query("
            SELECT CASE WHEN channel IS NOT NULL AND channel != '' THEN channel ELSE 'online' END as ch, 
                   COUNT(*) as cnt, 
                   COALESCE(SUM(total_amount), 0) as rev 
            FROM orders 
            WHERE COALESCE(fulfillment_status, order_status, 'processing') != 'cancelled' 
            GROUP BY ch 
            ORDER BY rev DESC
        ");

        foreach ($rows as $r) {
            $chKey = strtolower(trim($r['ch']));
            $cnt = (int)$r['cnt'];
            $rev = (float)$r['rev'];

            $totalOrders += $cnt;
            $totalRevenue += $rev;

            $name = 'D2C Retail Storefront';
            $sub = 'Direct shopper web portal, express checkout & UPI';
            $color = '#1D4ED8';
            $badgeBg = '#EFF6FF';
            $badgeColor = '#1D4ED8';

            if (in_array($chKey, ['wholesale', 'b2b', 'trade'], true)) {
                $name = 'B2B Wholesale Portal';
                $sub = 'Surat factory bales, paithani sets & wholesale lots';
                $color = '#8A681F';
                $badgeBg = '#FAF5E8';
                $badgeColor = '#8A681F';
                $b2bRevenue += $rev;
                $b2bCount += $cnt;
            } elseif (in_array($chKey, ['retailer', 'retail_trade'], true)) {
                $name = 'B2B Retailer Trade';
                $sub = 'Verified retailer shopkeepers, catalog orders & full sets';
                $color = '#B45309';
                $badgeBg = '#FEF3C7';
                $badgeColor = '#B45309';
                $retailerRevenue += $rev;
                $retailerCount += $cnt;
            } elseif (in_array($chKey, ['reseller', 'whatsapp', 'social'], true)) {
                $name = 'Reseller Network & WhatsApp';
                $sub = 'Boutique resellers, social catalogs & margin share';
                $color = '#15803D';
                $badgeBg = '#DCFCE7';
                $badgeColor = '#15803D';
                $resellerRevenue += $rev;
                $resellerCount += $cnt;
            } else {
                $d2cRevenue += $rev;
                $d2cCount += $cnt;
            }

            $channelStats[] = [
                'key' => $chKey,
                'name' => $name,
                'subtitle' => $sub,
                'count' => $cnt,
                'revenue' => $rev,
                'color' => $color,
                'badge_bg' => $badgeBg,
                'badge_color' => $badgeColor
            ];
        }
    } catch (\Throwable $e) {
        error_log("Sales channel report error: " . $e->getMessage());
    }
}

$blendedAov = $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0.0;
$rupeeSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';

if (isset($_GET['download']) && $_GET['download'] === 'sales') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=DT_Channel_Sales_Report_' . date('Y_m') . '.csv');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Sales Channel', 'Total Orders', 'Gross Revenue (INR)', 'Channel Share %', 'Avg Order Value (AOV)', 'Status']);
    if (!empty($channelStats)) {
        foreach ($channelStats as $cs) {
            $share = $totalRevenue > 0 ? round(($cs['revenue'] / $totalRevenue) * 100, 2) : 0.0;
            $aov = $cs['count'] > 0 ? round($cs['revenue'] / $cs['count'], 2) : 0.0;
            fputcsv($out, [
                $cs['name'],
                $cs['count'],
                number_format($cs['revenue'], 2, '.', ''),
                $share . '%',
                number_format($aov, 2, '.', ''),
                'Active Stream'
            ]);
        }
    }
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
    <title><?php echo $page_title; ?> — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
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
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Sales Breakdown &amp; Channel Analytics</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?= number_format($totalOrders) ?> Recorded Orders</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Detailed multi-channel volume tracking across B2B Wholesale, D2C Retail, and WhatsApp Reseller networks.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Financial Reports</span>
                    </a>
                    <a href="/admin/reports/sales.php?download=sales" class="dt-btn dt-btn-gold" style="text-decoration:none; height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Export Channel Sales CSV</span>
                    </a>
                </div>
            </div>

            <!-- 4-Card Sales KPI Ribbon -->
            <div class="dt-sales-kpi-grid">
                <div class="dt-sales-kpi-card">
                    <div class="dt-sales-kpi-label">B2B Trade &amp; Wholesale</div>
                    <div class="dt-sales-kpi-val" style="color:#8A681F;"><?= $rupeeSvg ?> <?= number_format($b2bRevenue + $retailerRevenue) ?></div>
                    <div style="font-size:0.72rem; color:#15803D; margin-top:2px; font-weight:700;">
                        <?= $totalRevenue > 0 ? round((($b2bRevenue + $retailerRevenue) / $totalRevenue) * 100, 1) : 0 ?>% of Total • <?= number_format($b2bCount + $retailerCount) ?> Trade Orders
                    </div>
                </div>
                <div class="dt-sales-kpi-card">
                    <div class="dt-sales-kpi-label">D2C Retail Storefront</div>
                    <div class="dt-sales-kpi-val" style="color:#181512;"><?= $rupeeSvg ?> <?= number_format($d2cRevenue) ?></div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">
                        <?= $totalRevenue > 0 ? round(($d2cRevenue / $totalRevenue) * 100, 1) : 0 ?>% of Total • <?= number_format($d2cCount) ?> Orders
                    </div>
                </div>
                <div class="dt-sales-kpi-card">
                    <div class="dt-sales-kpi-label">WhatsApp Resellers</div>
                    <div class="dt-sales-kpi-val" style="color:#15803D;"><?= $rupeeSvg ?> <?= number_format($resellerRevenue) ?></div>
                    <div style="font-size:0.72rem; color:#15803D; margin-top:2px; font-weight:700;">
                        <?= number_format($resellerCount) ?> VIP Inquiries Converted
                    </div>
                </div>
                <div class="dt-sales-kpi-card">
                    <div class="dt-sales-kpi-label">Blended Average Order Value</div>
                    <div class="dt-sales-kpi-val" style="color:#181512;"><?= $rupeeSvg ?> <?= number_format($blendedAov) ?></div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">Across <?= number_format($totalOrders) ?> Recorded Orders</div>
                </div>
            </div>

            <!-- Channel Performance Matrix Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <span>Multi-Channel Performance Matrix</span>
                    </h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">Live Synchronized</span>
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
                                <th style="text-align:right;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($channelStats)): ?>
                                <?php foreach ($channelStats as $cs): ?>
                                    <?php 
                                        $share = $totalRevenue > 0 ? round(($cs['revenue'] / $totalRevenue) * 100, 1) : 0;
                                        $aov = $cs['count'] > 0 ? round($cs['revenue'] / $cs['count']) : 0;
                                    ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($cs['name']) ?></strong>
                                            <div style="font-size:11px; color:#64748B;"><?= htmlspecialchars($cs['subtitle']) ?></div>
                                        </td>
                                        <td><span class="adm-badge" style="background:<?= $cs['badge_bg'] ?>; color:<?= $cs['badge_color'] ?>; font-weight:700;"><?= number_format($cs['count']) ?> Orders</span></td>
                                        <td><strong style="color:<?= $cs['color'] ?>; font-size:13.5px;"><?= $rupeeSvg ?> <?= number_format($cs['revenue']) ?></strong></td>
                                        <td>
                                            <div style="display:flex; align-items:center; gap:8px;">
                                                <div style="flex:1; height:6px; background:#EAE5D9; border-radius:3px; overflow:hidden; min-width:60px;">
                                                    <div style="width:<?= min(100, max(2, $share)) ?>%; height:100%; background:<?= $cs['color'] ?>;"></div>
                                                </div>
                                                <span style="font-size:11.5px; font-weight:700;"><?= $share ?>%</span>
                                            </div>
                                        </td>
                                        <td><strong><?= $rupeeSvg ?> <?= number_format($aov) ?></strong></td>
                                        <td style="text-align:right;"><span style="color:#15803D; font-weight:800;">Active Stream</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; padding:32px; color:#64748B;">
                                        No channel orders found in the database. Customer transactions will automatically appear here.
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
