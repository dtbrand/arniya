<?php
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) { require_once $__dtg; } elseif (is_file(__DIR__ . '/../includes/adminguard.php')) { require_once __DIR__ . '/../includes/adminguard.php'; }

/**
 * export.php — Warehouse Inventory & Stock Valuation Exporter
 * DT Brand's & Jai Hanuman Tex — Master Wholesale Architecture
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/InventoryManager.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;
use DTBrand\InventoryManager;

$exportType = trim($_GET['type'] ?? 'stock');

$sanitizeCsv = static function ($val) {
    $str = (string)$val;
    if ($str !== '' && in_array($str[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
        return "'" . $str;
    }
    return $str;
};

// 1. Direct CSV Download for Ledger
if ($exportType === 'ledger') {
    $records = InventoryManager::getLedger([], 5000, 0);
    $filename = "DT_Brands_Inventory_Ledger_" . date('Y-m-d') . ".csv";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    $out = fopen('php://output', 'w');
    fputs($out, "\xEF\xBB\xBF"); // UTF-8 BOM
    fputcsv($out, ['Audit ID', 'Timestamp', 'SKU', 'Product Title', 'Movement Type', 'Previous Qty', 'Adjustment Qty', 'New Qty', 'Reason / Observation', 'Reference ID', 'Operator']);

    foreach ($records as $r) {
        fputcsv($out, [
            $r['id'],
            $sanitizeCsv($r['created_at']),
            $sanitizeCsv($r['sku'] ?? '—'),
            $sanitizeCsv($r['product_title'] ?? '—'),
            $sanitizeCsv(strtoupper($r['movement_type'] ?? 'ADJUSTMENT')),
            (int)$r['previous_qty'],
            (int)$r['adjustment_qty'],
            (int)$r['new_qty'],
            $sanitizeCsv($r['reason'] ?? '—'),
            $sanitizeCsv($r['reference_id'] ?? '—'),
            $sanitizeCsv($r['operator'] ?? 'Admin')
        ]);
    }
    fclose($out);
    exit;
}

// 2. Direct CSV Download for Current Stock Valuation
if (isset($_GET['download']) && $_GET['download'] === '1') {
    $allProds = ProductCatalog::getAll(true);
    $filename = "DT_Brands_Depot_Stock_Valuation_" . date('Y-m-d') . ".csv";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    $out = fopen('php://output', 'w');
    fputs($out, "\xEF\xBB\xBF"); // UTF-8 BOM
    fputcsv($out, ['Product ID', 'SKU', 'Product Title', 'Category', 'Available Depot Stock', 'Wholesale Price (INR)', 'Retail MRP (INR)', 'Inventory Valuation (INR)', 'Stock Status', 'Warehouse Location']);

    foreach ($allProds as $p) {
        $qty = (int)($p['stock_qty'] ?? 0);
        $wp = (float)($p['wholesale_price'] ?? 0);
        $mrp = (float)($p['price'] ?? 0);
        $valuation = round($qty * $wp, 2);
        $status = $qty <= 0 ? 'Out of Stock' : ($qty <= 15 ? 'Low Stock' : 'In Stock');

        fputcsv($out, [
            $p['id'],
            $sanitizeCsv($p['sku'] ?? 'SKU-' . $p['id']),
            $sanitizeCsv($p['title'] ?? 'Textile Product'),
            $sanitizeCsv($p['category'] ?? 'Silk Sarees'),
            $qty,
            number_format($wp, 2, '.', ''),
            number_format($mrp, 2, '.', ''),
            number_format($valuation, 2, '.', ''),
            $sanitizeCsv($status),
            'Surat Central Depot (Ring Road)'
        ]);
    }
    fclose($out);
    exit;
}

$page_title = "Inventory Stock & Valuation Exporter";
$active_nav = "inventory";
$metrics = InventoryManager::getSummaryMetrics();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Export Studio — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
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
                        <span>Inventory Stock &amp; Valuation Exporter</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">CA &amp; Audit Ready</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Generate certified CSV datasets with UTF-8 BOM encoding for Surat godown stocktakes, Tally ERP, and CA ledger audits.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/inventory/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Inventory Depot</span>
                    </a>
                </div>
            </div>

            <!-- Submodule Navigation -->
            <?php include_once __DIR__ . '/components/nav.php'; ?>

            <!-- Export Cards Grid -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; max-width:960px; margin-top:20px;">
                <!-- Card 1: Current Stock Levels -->
                <div class="adm-card" style="padding:24px; display:flex; flex-direction:column; justify-content:space-between;">
                    <div>
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                            <div style="width:40px; height:40px; border-radius:10px; background:#FAF5E8; border:1.5px solid #D4AF37; display:flex; align-items:center; justify-content:center;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                            <div>
                                <h3 style="margin:0; font-size:16px; font-weight:800; color:#181512;">Current Depot Stock Valuation</h3>
                                <span style="font-size:11.5px; color:#64748B;">All Active &amp; Draft SKUs with Unit Balances</span>
                            </div>
                        </div>
                        <p style="font-size:12.5px; color:#475569; line-height:1.5; margin-bottom:16px;">
                            Includes SKU codes, wholesale valuations, category classifications, and current quantities at Surat Central Hub.
                        </p>
                        <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px; margin-bottom:20px; font-size:12px;">
                            <div>Total SKUs: <strong><?= number_format($metrics['total_skus']) ?></strong></div>
                            <div style="margin-top:4px;">Total Depot Units: <strong><?= number_format($metrics['total_stock_units']) ?> pcs</strong></div>
                            <div style="margin-top:4px;">Current Valuation: <strong style="color:#8A681F;"><?= $metrics['valuation_formatted'] ?></strong></div>
                        </div>
                    </div>
                    <a href="/admin/inventory/export.php?download=1" class="dt-btn dt-btn-gold" style="text-decoration:none; height:40px; display:inline-flex; align-items:center; justify-content:center; gap:8px; font-size:13px; font-weight:800;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Download Stock Valuation CSV</span>
                    </a>
                </div>

                <!-- Card 2: Inventory Movement Ledger -->
                <div class="adm-card" style="padding:24px; display:flex; flex-direction:column; justify-content:space-between;">
                    <div>
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                            <div style="width:40px; height:40px; border-radius:10px; background:#DCFCE7; border:1.5px solid #86EFAC; display:flex; align-items:center; justify-content:center;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                            <div>
                                <h3 style="margin:0; font-size:16px; font-weight:800; color:#181512;">Stock Movement Audit Journal</h3>
                                <span style="font-size:11.5px; color:#64748B;">Complete Historical Audit Ledger</span>
                            </div>
                        </div>
                        <p style="font-size:12.5px; color:#475569; line-height:1.5; margin-bottom:16px;">
                            Complete journal of factory inward consignments, B2B wholesale parcel dispatches, physical reconciliations, and operator signatures.
                        </p>
                        <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px; margin-bottom:20px; font-size:12px;">
                            <div>Encoding: <strong>UTF-8 with BOM (\xEF\xBB\xBF)</strong></div>
                            <div style="margin-top:4px;">Security: <strong>Formula Injection Sanitized</strong></div>
                            <div style="margin-top:4px;">Compatibility: <strong>Microsoft Excel, Tally ERP, Google Sheets</strong></div>
                        </div>
                    </div>
                    <a href="/admin/inventory/export.php?type=ledger" class="dt-btn dt-btn-dark" style="text-decoration:none; height:40px; display:inline-flex; align-items:center; justify-content:center; gap:8px; font-size:13px; font-weight:750;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Download Movement Ledger CSV</span>
                    </a>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
