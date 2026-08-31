<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * export.php - Customer Export Studio (CSV / Excel / Print)
 * DT Brand's & Jai Hanuman Tex - Live Production Standard
 *
 * The three generators on this page are real: each builds a Blob and clicks a
 * download link, so a file genuinely lands on the admin's disk. What they used
 * to put in that file was a `mockCustomers` array of eight invented people
 * carrying real-format phone numbers, Indian and international alike, and
 * invented lifetime spends. The admin downloaded a spreadsheet of strangers,
 * and unlike a toast that lies, that file outlives the session: it gets mailed
 * on, and imported into a WhatsApp broadcast list. Every row now comes from the
 * customers table, and a field with no column behind it is no longer offered.
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/CustomerManager.php';

use DTBrand\Database;
use DTBrand\CustomerManager;

$customers = CustomerManager::getAll();

// Last purchase date and postal code are not columns on `customers`: one is the
// newest order for that customer, the other belongs to their default address.
// Two grouped queries, so this stays flat rather than one lookup per row.
$lastOrders = [];
$pincodes   = [];
$pdo = Database::getConnection();
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $q = $pdo->query("SELECT `customer_id`, MAX(`created_at`) AS `last_order` FROM `orders` GROUP BY `customer_id`");
        foreach (($q ? $q->fetchAll(\PDO::FETCH_ASSOC) : []) as $r) {
            $lastOrders[(int)$r['customer_id']] = (string)$r['last_order'];
        }
    } catch (\Exception $e) {
        // No order history readable. The column exports blank rather than a guess.
    }
    try {
        // is_default ASC means the default address is written last and wins.
        $q = $pdo->query("SELECT `customer_id`, `pincode` FROM `addresses` ORDER BY `is_default` ASC, `id` ASC");
        foreach (($q ? $q->fetchAll(\PDO::FETCH_ASSOC) : []) as $r) {
            $pincodes[(int)$r['customer_id']] = (string)$r['pincode'];
        }
    } catch (\Exception $e) {
        // Same: blank, not invented.
    }
}

$exportRows = [];
foreach ($customers as $c) {
    $orders = (int)$c['total_orders'];
    $spend  = (float)$c['lifetime_spend'];
    $exportRows[] = [
        'id'         => (int)$c['id'],
        'name'       => (string)$c['name'],
        'phone'      => (string)$c['phone'],
        'email'      => (string)$c['email'],
        'type'       => (string)$c['type'],
        'tier'       => (string)$c['tier'],
        'gstin'      => (string)$c['gstin'],
        'spend'      => $spend,
        'orders'     => $orders,
        // AOV is derived, never stored. With no orders there is no average, and
        // exporting 0 would read as "spends nothing per order".
        'aov'        => $orders > 0 ? round($spend / $orders, 2) : '',
        'last_order' => $lastOrders[(int)$c['id']] ?? '',
        'joined'     => (string)$c['created_at'],
        'city'       => (string)$c['city'],
        'state'      => (string)$c['state'],
        'pincode'    => $pincodes[(int)$c['id']] ?? '',
        'credit'     => (float)$c['credit_limit'],
        'balance'    => (float)$c['outstanding_balance'],
        'status'     => (string)$c['status'],
    ];
}

// Direct CSV stream for ?download=1. This path did read the real table, but it
// fabricated whatever it could not find: `total_spent` is not a key getAll()
// returns, so `?? 4899` stamped every single row with a lifetime spend of
// Rs 4,899, and `?? 1` gave every customer one order.
if (isset($_GET['download']) && $_GET['download'] == '1') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=dt_customers_export_' . date('Y_m_d_His') . '.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Customer ID', 'Full Name', 'Phone', 'Email', 'Account Type', 'Tier',
                      'GSTIN', 'Total Orders', 'Lifetime Spend (INR)', 'Avg Order Value (INR)',
                      'Last Order', 'City', 'State', 'Pincode', 'Credit Limit (INR)',
                      'Outstanding (INR)', 'Status', 'Registered']);
    foreach ($exportRows as $r) {
        fputcsv($output, [
            $r['id'], $r['name'], $r['phone'], $r['email'], $r['type'], $r['tier'],
            $r['gstin'], $r['orders'], $r['spend'], $r['aov'], $r['last_order'],
            $r['city'], $r['state'], $r['pincode'], $r['credit'], $r['balance'],
            $r['status'], $r['joined'],
        ]);
    }
    fclose($output);
    exit;
}

// Real cohort sizes for the scope dropdown. Every option used to carry a
// hardcoded figure -- "4,820 Shoppers", "312 Shoppers", "1,240 Shoppers" -- so
// an admin chose a cohort believing it held over a thousand buyers.
$cutoff60 = strtotime('-60 days');
$scopeCounts = ['all' => count($exportRows), 'vip' => 0, 'frequent' => 0, 'gujarat' => 0,
                'wholesale' => 0, 'reseller' => 0, 'retail' => 0, 'pending' => 0, 'dormant' => 0];
foreach ($exportRows as $r) {
    if (stripos($r['tier'], 'vip') !== false || $r['spend'] >= 25000) $scopeCounts['vip']++;
    if ($r['orders'] >= 3) $scopeCounts['frequent']++;
    $st = strtoupper(trim($r['state']));
    if ($st === 'GJ' || $st === 'GUJARAT') $scopeCounts['gujarat']++;
    if ($r['type'] === 'wholesale') $scopeCounts['wholesale']++;
    if ($r['type'] === 'reseller')  $scopeCounts['reseller']++;
    if ($r['type'] === 'retail')    $scopeCounts['retail']++;
    if ($r['status'] === 'pending') $scopeCounts['pending']++;
    $lo = $r['last_order'] !== '' ? strtotime($r['last_order']) : false;
    if ($lo === false || $lo < $cutoff60) $scopeCounts['dormant']++;
}

$page_title = "Customer Export Studio";
$active_nav = "customers";
$active_subnav = "export";

// The Labels & Cohorts page links here as export.php?scope=wholesale. Validated
// against the computed keys, so an unknown or hand-edited scope falls back to
// "all" rather than preselecting an option the generators cannot honour.
$preScope = isset($_GET['scope']) ? strtolower(trim((string)$_GET['scope'])) : 'all';
if (!array_key_exists($preScope, $scopeCounts)) { $preScope = 'all'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <style>
        .dt-export-format-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            background: #FFFFFF;
            border: 1.5px solid #EAE5D9;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
        }
        .dt-export-format-card:hover {
            border-color: #D4AF37;
            background: #FAF8F4;
            transform: translateY(-1px);
        }
        .dt-export-format-card.active {
            border-color: #B8860B;
            background: #FAF5E8;
            box-shadow: 0 4px 12px rgba(184, 134, 11, 0.15);
        }
        .dt-export-format-icon {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
            font-weight: 900;
        }
        .dt-export-group-box {
            background: #FAF8F4;
            border: 1.2px solid #EAE5D9;
            border-radius: 10px;
            padding: 14px 16px;
        }
        .dt-field-check-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.76rem;
            font-weight: 700;
            color: #181512;
            cursor: pointer;
            padding: 4px 0;
        }
        .dt-field-check-label input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: #8A681F;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:16px;">
                <!-- Page Header -->
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer Export Studio</span>
                            <span class="dt-cust-badge gold">Data Reports</span>
                        </h1>
                        <p class="dt-cust-subtitle">Generate custom downloadable CSV spreadsheets, Microsoft Excel workbooks, or formatted PDF dossiers.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>All Customers</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="triggerQuickCsvDownload()">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Quick CSV Export</span>
                        </button>
                    </div>
                </div>

                <!-- 4-Card Master KPI Ribbon -->
                <div class="dt-cust-kpi-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
                    <!-- Card 1: Total Base -->
                    <div class="dt-cust-kpi-card active">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">TOTAL EXPORTABLE BASE</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#8A681F;"><?php echo number_format(count($exportRows)); ?></div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta"><?php echo number_format($scopeCounts['wholesale'] + $scopeCounts['reseller']); ?> trade &middot; <?php echo number_format($scopeCounts['retail']); ?> retail</span>
                            <span style="color:#78716C;">customers table</span>
                        </div>
                    </div>

                    <!-- Card 2: Attributes -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">AVAILABLE ATTRIBUTES</span>
                            <div class="dt-cust-kpi-icon emerald">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#15803D;">18 Fields</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">Demographics &amp; Orders</span>
                            <span style="color:#15803D; font-weight:800;">Real columns</span>
                        </div>
                    </div>

                    <!-- Card 3: Formats -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">SUPPORTED FORMATS</span>
                            <div class="dt-cust-kpi-icon purple">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val">3 Formats</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">CSV • XLS • Print</span>
                            <span style="color:#78716C;">Built in browser</span>
                        </div>
                    </div>

                    <!-- Card 4: Security -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">FILE CONTENTS</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#181512; font-size:1.2rem;">Handle With Care</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">Names, phones &amp; spend</span>
                            <span style="color:#78716C;">Nothing is logged</span>
                        </div>
                    </div>
                </div>

                <!-- Export Wizard Card -->
                <div class="dt-card" style="max-width:920px; width:100%; margin:0 auto; padding:22px 26px;">
                    <div class="dt-card-head" style="margin-bottom:18px; border-bottom:1.2px solid #F1ECE1; padding-bottom:12px;">
                        <div>
                            <h3 class="dt-card-title">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>Configure Customer Export Parameters</span>
                            </h3>
                            <p style="font-size:0.75rem; color:#78716C; margin:3px 0 0 0;">Customize audience segments, export format, and attributes to generate tailored reports.</p>
                        </div>
                    </div>

                    <form id="dtExportForm" onsubmit="handleCustomerExport(event)" style="display:flex; flex-direction:column; gap:20px;">
                        <!-- 1. Select Export Format -->
                        <div>
                            <label style="font-size:0.78rem; font-weight:800; color:#181512; display:block; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:10px;">1. Select Export File Format</label>
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                                <!-- CSV -->
                                <div class="dt-export-format-card active" onclick="selectExportFormat('csv', this)">
                                    <input type="radio" name="export_format" value="csv" checked style="display:none;">
                                    <div class="dt-export-format-icon" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">
                                        CSV
                                    </div>
                                    <div>
                                        <strong style="font-size:0.85rem; color:#181512; display:block;">CSV Spreadsheet</strong>
                                        <small style="font-size:0.68rem; color:#78716C;">Universal UTF-8 text dataset</small>
                                    </div>
                                </div>

                                <!-- Excel -->
                                <div class="dt-export-format-card" onclick="selectExportFormat('excel', this)">
                                    <input type="radio" name="export_format" value="excel" style="display:none;">
                                    <div class="dt-export-format-icon" style="background:#DCFCE7; color:#15803D; border:1px solid #86EFAC;">
                                        XLS
                                    </div>
                                    <div>
                                        <strong style="font-size:0.85rem; color:#181512; display:block;">Excel Workbook</strong>
                                        <small style="font-size:0.68rem; color:#78716C;">.xls table, opens in Excel</small>
                                    </div>
                                </div>

                                <!-- PDF -->
                                <div class="dt-export-format-card" onclick="selectExportFormat('pdf', this)">
                                    <input type="radio" name="export_format" value="pdf" style="display:none;">
                                    <div class="dt-export-format-icon" style="background:#EFF6FF; color:#1D4ED8; border:1px solid #BFDBFE;">
                                        PDF
                                    </div>
                                    <div>
                                        <strong style="font-size:0.85rem; color:#181512; display:block;">Printable PDF</strong>
                                        <small style="font-size:0.68rem; color:#78716C;">Print preview &rarr; Save as PDF</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Audience Scope -->
                        <div>
                            <label style="font-size:0.78rem; font-weight:800; color:#181512; display:block; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:8px;">2. Audience Scope &amp; Target Cohort</label>
                            <select id="dtExportAudienceScope" class="dt-cust-select" onchange="updateExportEstimate()" style="width:100%; height:40px; font-size:0.82rem; font-weight:700; background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:8px;">
                                <?php
                                $scopeLabels = [
                                    'all'       => 'All Registered Customers',
                                    'vip'       => 'VIP / High-Value (VIP tier or LTV ≥ ₹25,000)',
                                    'frequent'  => 'Repeat Buyers (3+ orders)',
                                    'gujarat'   => 'Gujarat Buyers',
                                    'wholesale' => 'Wholesale Accounts',
                                    'reseller'  => 'Reseller Accounts',
                                    'retail'    => 'Retail Shoppers',
                                    'pending'   => 'Awaiting Approval',
                                    'dormant'   => 'No Order in 60+ Days (includes never ordered)',
                                ];
                                foreach ($scopeLabels as $k => $label): ?>
                                    <option value="<?php echo $k; ?>"<?php echo $preScope === $k ? ' selected' : ''; ?>><?php echo $label; ?> (<?php echo number_format($scopeCounts[$k]); ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- 3. Fields & Attributes to Include -->
                        <div>
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; flex-wrap:wrap; gap:8px;">
                                <label style="font-size:0.78rem; font-weight:800; color:#181512; text-transform:uppercase; letter-spacing:0.03em; margin:0;">3. Data Fields &amp; Attributes to Include</label>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:2px 8px; font-size:0.68rem;" onclick="toggleAllFields(true)">Select All</button>
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:2px 8px; font-size:0.68rem;" onclick="toggleAllFields(false)">Clear All</button>
                                </div>
                            </div>

                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:14px;">
                                <!-- Contact & identity -->
                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#8A681F; text-transform:uppercase; display:block; margin-bottom:8px;">Contact &amp; Identity</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="id" checked> Customer ID</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="name" checked> Full Name</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="phone" checked> WhatsApp / Phone Number</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="email" checked> Email Address</label>
                                </div>

                                <!-- Account & classification -->
                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#8A681F; text-transform:uppercase; display:block; margin-bottom:8px;">Account &amp; Classification</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="type" checked> Account Type (Retail / Wholesale / Reseller)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="tier" checked> Tier</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="gstin" checked> GSTIN</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="status" checked> Status (Active / Pending / Suspended)</label>
                                </div>

                                <!-- Orders & financials -->
                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#15803D; text-transform:uppercase; display:block; margin-bottom:8px;">Orders &amp; Financials</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="spend" checked> Lifetime Spend (₹)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="orders" checked> Total Orders</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="aov" checked> Average Order Value</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="last_order" checked> Last Order Date</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="credit"> Credit Limit (₹)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="balance"> Outstanding Balance (₹)</label>
                                </div>

                                <!-- Location & registration -->
                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#1D4ED8; text-transform:uppercase; display:block; margin-bottom:8px;">Location &amp; Registration</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="city" checked> City</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="state" checked> State</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="pincode"> Pincode (default address)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="joined" checked> Registered On</label>
                                </div>
                            </div>

                            <p style="font-size:0.7rem; color:#78716C; margin:10px 0 0 0;">
                                Country and free-form tags are not offered: neither is stored anywhere in this
                                database, so both columns would export blank for every customer.
                            </p>
                        <!-- 4. Export Summary Bar -->
                        <div style="background:#FAF8F4; border:1.2px solid #EAE5D9; border-radius:10px; padding:12px 16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                            <div style="font-size:0.75rem; color:#181512;">
                                <strong>This export:</strong> <span id="dtExportEstimate">-</span>
                            </div>
                            <span class="dt-cust-badge emerald" style="font-size:0.65rem;">Built from the live customers table</span>
                        </div>

                        <!-- 5. Form Actions -->
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; border-top:1.5px solid #F1ECE1; padding-top:16px;">
                            <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="submit" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:8px; padding:0 22px; height:40px;">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>Generate &amp; Download File</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script>
let currentFormat = 'csv';

/*
 * Every row below is a real customer. This used to be a `mockCustomers` array
 * of eight invented people, and the CSV / XLS / print generators are genuinely
 * functional -- so the admin ended up with a real file full of strangers.
 *
 * JSON_HEX_TAG matters: a customer registers their own name, and without it a
 * name containing </script> would break out of this block.
 */
const exportRows = <?php echo json_encode($exportRows, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); ?>;

// Labels shared by all three generators, so a column cannot be titled one thing
// in the CSV and another in the workbook.
const EXPORT_FIELD_LABELS = {
    id: "Customer ID", name: "Full Name", phone: "Phone Number", email: "Email Address",
    type: "Account Type", tier: "Tier", gstin: "GSTIN", status: "Status",
    spend: "Lifetime Spend (INR)", orders: "Total Orders", aov: "Avg Order Value (INR)",
    last_order: "Last Order Date", credit: "Credit Limit (INR)", balance: "Outstanding (INR)",
    city: "City", state: "State", pincode: "Pincode", joined: "Registered On"
};

const CURRENCY_FIELDS = ['spend', 'aov', 'credit', 'balance'];

function escHtml(v) {
    return String(v)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

// A blank cell must stay blank. Number('') is 0, so formatting unconditionally
// would turn "this customer has never ordered" into a confident Rs 0.00 AOV.
function fmtCell(field, raw) {
    const val = (raw === undefined || raw === null) ? '' : raw;
    if (val === '') return '';
    if (CURRENCY_FIELDS.indexOf(field) !== -1) {
        const n = Number(val);
        return isNaN(n) ? String(val) : n.toLocaleString('en-IN', { maximumFractionDigits: 2 });
    }
    return String(val);
}

function selectExportFormat(fmt, el) {
    currentFormat = fmt;
    document.querySelectorAll('.dt-export-format-card').forEach(c => c.classList.remove('active'));
    if (el) el.classList.add('active');
    const radio = el ? el.querySelector('input[type="radio"]') : null;
    if (radio) radio.checked = true;
    updateExportEstimate();
}

function toggleAllFields(check) {
    document.querySelectorAll('input[name="fields[]"]').forEach(cb => cb.checked = check);
    updateExportEstimate();
}

function getSelectedFields() {
    const checked = [];
    document.querySelectorAll('input[name="fields[]"]:checked').forEach(cb => checked.push(cb.value));
    return checked.length ? checked : ['id', 'name', 'phone', 'email', 'type', 'spend', 'orders', 'city'];
}

function parseTs(v) {
    return v ? Date.parse(String(v).replace(' ', 'T')) : NaN;
}

/*
 * The old cohorts filtered on `country`, `tags` and `aov` -- none of which is a
 * column -- and "dormant" tested status === 'Inactive', a value the status ENUM
 * cannot hold, so it matched nothing however long a buyer had been away.
 */
function filterCustomersByScope(scope) {
    const cutoff60 = Date.now() - 60 * 86400000;
    if (scope === 'vip')       return exportRows.filter(c => /vip/i.test(String(c.tier)) || Number(c.spend) >= 25000);
    if (scope === 'frequent')  return exportRows.filter(c => Number(c.orders) >= 3);
    if (scope === 'gujarat')   return exportRows.filter(c => ['GJ', 'GUJARAT'].indexOf(String(c.state).trim().toUpperCase()) !== -1);
    if (scope === 'wholesale') return exportRows.filter(c => c.type === 'wholesale');
    if (scope === 'reseller')  return exportRows.filter(c => c.type === 'reseller');
    if (scope === 'retail')    return exportRows.filter(c => c.type === 'retail');
    if (scope === 'pending')   return exportRows.filter(c => c.status === 'pending');
    if (scope === 'dormant')   return exportRows.filter(c => {
        const t = parseTs(c.last_order);
        return isNaN(t) || t < cutoff60;
    });
    return exportRows.slice();
}

// The summary bar read "CSV File (~340 KB) - 4,820 Records" whatever was
// selected, in a database that has nothing like 4,820 customers.
function updateExportEstimate() {
    const est = document.getElementById('dtExportEstimate');
    if (!est) return;
    const scopeEl = document.getElementById('dtExportAudienceScope');
    const n = filterCustomersByScope(scopeEl ? scopeEl.value : 'all').length;
    const cols = getSelectedFields().length;
    const label = currentFormat === 'csv' ? 'CSV file'
                : currentFormat === 'excel' ? 'Excel (.xls) table'
                : 'Print preview';
    est.innerText = label + ' \u2014 ' + n + ' record' + (n === 1 ? '' : 's')
                  + ' \u00d7 ' + cols + ' field' + (cols === 1 ? '' : 's');
}

function handleCustomerExport(e) {
    if (e) e.preventDefault();
    const scopeEl = document.getElementById('dtExportAudienceScope');
    const scope = scopeEl ? scopeEl.value : 'all';
    const selectedFields = getSelectedFields();
    const records = filterCustomersByScope(scope);

    // Writing a headers-only file and reporting "export complete" would read as
    // "these customers were exported" when there were none.
    if (!records.length) {
        window.showToast(exportRows.length === 0
            ? '\u26a0 There are no customers in the database yet, so nothing was exported.'
            : '\u26a0 No customer matches that cohort \u2014 nothing was exported.');
        return;
    }

    if (currentFormat === 'csv') {
        downloadCsvFile(records, selectedFields);
    } else if (currentFormat === 'excel') {
        downloadExcelFile(records, selectedFields);
    } else if (currentFormat === 'pdf') {
        generatePdfDossier(records, selectedFields);
    }
}

function triggerQuickCsvDownload() {
    currentFormat = 'csv';
    handleCustomerExport();
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[name="fields[]"]').forEach(function (cb) {
        cb.addEventListener('change', updateExportEstimate);
    });
    updateExportEstimate();
});

// ── 1. CSV Generator ──
function downloadCsvFile(records, fields) {
    const headers = fields.map(f => `"${EXPORT_FIELD_LABELS[f] || f}"`).join(",");
    const rows = records.map(r => {
        // Raw values, not the display-formatted ones: a spreadsheet needs 48500,
        // not "48,500", or the column will not add up.
        return fields.map(f => {
            const v = (r[f] === undefined || r[f] === null) ? '' : r[f];
            return `"${String(v).replace(/"/g, '""')}"`;
        }).join(",");
    });

    const csvData = "\uFEFF" + headers + "\n" + rows.join("\n");
    const blob = new Blob([csvData], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    link.href = url;
    link.download = `DT_Brands_Customers_Export_${new Date().toISOString().slice(0, 10)}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);

    window.showToast(`✓ CSV saved \u2014 ${records.length} customer${records.length === 1 ? '' : 's'}.`);
}

// ── 2. Excel Workbook (.xls XML/HTML) Generator ──
function downloadExcelFile(records, fields) {
    let tableHtml = `<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
    <head><meta charset="utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Customers</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->
    <style>
        th { background-color: #B8860B; color: #FFFFFF; font-weight: bold; padding: 10px; border: 1px solid #8A681F; }
        td { padding: 8px; border: 1px solid #EAE5D9; font-family: 'Segoe UI', Arial, sans-serif; font-size: 11pt; }
        .currency { color: #8A681F; font-weight: bold; }
        .vip { background-color: #FAF5E8; color: #8A681F; font-weight: bold; }
    </style></head><body>
    <h2>DT Brand's & Jai Hanuman Tex — Customer Master Report</h2>
    <p>Generated on: ${new Date().toLocaleString()} | Total Records: ${records.length}</p>
    <table><thead><tr>`;

    fields.forEach(f => {
        tableHtml += `<th>${escHtml(EXPORT_FIELD_LABELS[f] || f)}</th>`;
    });
    tableHtml += `</tr></thead><tbody>`;

    // Customers type their own names, so every cell is escaped. Unescaped, a
    // name containing a tag broke the table apart for every row after it.
    records.forEach(r => {
        tableHtml += `<tr>`;
        fields.forEach(f => {
            const shown = fmtCell(f, r[f]);
            if (CURRENCY_FIELDS.indexOf(f) !== -1) {
                tableHtml += `<td class="currency">${shown === '' ? '' : '₹' + escHtml(shown)}</td>`;
            } else if (f === 'tier' && /vip/i.test(shown)) {
                tableHtml += `<td class="vip">${escHtml(shown)}</td>`;
            } else {
                tableHtml += `<td>${escHtml(shown)}</td>`;
            }
        });
        tableHtml += `</tr>`;
    });

    tableHtml += `</tbody></table></body></html>`;

    const blob = new Blob([tableHtml], { type: "application/vnd.ms-excel;charset=utf-8" });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    link.href = url;
    link.download = `DT_Brands_Customers_Report_${new Date().toISOString().slice(0, 10)}.xls`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);

    // An HTML table with an .xls extension, which Excel opens after warning that
    // the format and the extension do not match. Saying so beats the admin
    // thinking the file is corrupt.
    window.showToast(`✓ Excel file saved \u2014 ${records.length} customer${records.length === 1 ? '' : 's'}. Excel may warn about the file format; opening it is safe.`);
}

// ── 3. Printable PDF Dossier Generator ──
function generatePdfDossier(records, fields) {
    const printWin = window.open('', '_blank', 'width=900,height=700');
    if (!printWin) {
        window.showToast('⚠️ Popups blocked. Please allow popups for PDF printing.');
        return;
    }

    let printHtml = `<!DOCTYPE html>
    <html>
    <head>
        <title>DT Brand's — Customer Dossier Report</title>
        <style>
            body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; padding: 24px; color: #181512; }
            .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #8A681F; padding-bottom: 14px; margin-bottom: 20px; }
            .logo { font-size: 20px; font-weight: 900; color: #8A681F; }
            .meta { font-size: 11px; color: #78716C; text-align: right; }
            .kpi-strip { display: flex; gap: 12px; margin-bottom: 20px; }
            .kpi-box { flex: 1; padding: 10px; border: 1px solid #EAE5D9; border-radius: 8px; background: #FAF8F4; text-align: center; }
            .kpi-val { font-size: 16px; font-weight: 900; color: #8A681F; }
            .kpi-lbl { font-size: 9px; font-weight: 800; color: #78716C; text-transform: uppercase; }
            table { width: 100%; border-collapse: collapse; font-size: 11px; }
            th { background: #FAF5E8; color: #8A681F; text-align: left; padding: 8px; border-bottom: 1.5px solid #D4AF37; font-weight: 800; }
            td { padding: 8px; border-bottom: 1px solid #F1ECE1; }
            .vip-pill { display: inline-block; padding: 2px 6px; border-radius: 10px; background: #FAF5E8; color: #8A681F; font-weight: bold; border: 1px solid #D4AF37; font-size: 9px; }
            @media print {
                body { padding: 0; }
                @page { size: landscape; margin: 12mm; }
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div>
                <div class="logo">👑 DT BRAND'S &amp; JAI HANUMAN TEX</div>
                <div style="font-size:12px; font-weight:700; color:#181512; margin-top:2px;">Official Customer Executive Dossier</div>
            </div>
            <div class="meta">
                <div><strong>Export Date:</strong> ${new Date().toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' })}</div>
                <div><strong>Records Exported:</strong> ${records.length} Shoppers</div>
            </div>
        </div>

        <div class="kpi-strip">
            <div class="kpi-box">
                <div class="kpi-val">${records.length}</div>
                <div class="kpi-lbl">Target Shoppers</div>
            </div>
            <div class="kpi-box">
                <div class="kpi-val">₹${records.reduce((acc, r) => acc + Number(r.spend || 0), 0).toLocaleString('en-IN')}</div>
                <div class="kpi-lbl">Aggregate LTV</div>
            </div>
            <div class="kpi-box">
                <div class="kpi-val">${records.reduce((acc, r) => acc + Number(r.orders || 0), 0)}</div>
                <div class="kpi-lbl">Total Orders</div>
            </div>
            <div class="kpi-box">
                <div class="kpi-val">${escHtml(document.getElementById('dtExportAudienceScope') ? document.getElementById('dtExportAudienceScope').selectedOptions[0].text.replace(/\s*\(.*$/, '') : 'All')}</div>
                <div class="kpi-lbl">Cohort</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>`;

    fields.forEach(f => {
        printHtml += `<th>${escHtml(EXPORT_FIELD_LABELS[f] || f)}</th>`;
    });
    printHtml += `</tr></thead><tbody>`;

    // document.write into a same-origin window runs whatever it is given, so an
    // unescaped customer name here was script execution, not just broken layout.
    records.forEach(r => {
        printHtml += `<tr>`;
        fields.forEach(f => {
            const shown = fmtCell(f, r[f]);
            if (CURRENCY_FIELDS.indexOf(f) !== -1) {
                printHtml += `<td style="font-weight:bold; color:#8A681F;">${shown === '' ? '\u2014' : '₹' + escHtml(shown)}</td>`;
            } else if (f === 'tier' && /vip/i.test(shown)) {
                printHtml += `<td><span class="vip-pill">${escHtml(shown)}</span></td>`;
            } else {
                printHtml += `<td>${shown === '' ? '\u2014' : escHtml(shown)}</td>`;
            }
        });
        printHtml += `</tr>`;
    });

    printHtml += `</tbody></table>
        <div style="margin-top:24px; font-size:10px; color:#78716C; text-align:center; border-top:1px solid #EAE5D9; padding-top:10px;">
            Confidential &amp; Proprietary • DT Brand's &amp; Jai Hanuman Tex Management Suite
        </div>
        <script>
            window.onload = function() {
                window.print();
            };
        <\/script>
    </body>
    </html>`;

    printWin.document.open();
    printWin.document.write(printHtml);
    printWin.document.close();

    // No PDF is produced here: this opens the browser print dialog, where the
    // admin chooses "Save as PDF". Claiming a PDF had been generated sent people
    // looking in their downloads folder for a file that was never written.
    window.showToast(`✓ Print preview opened for ${records.length} customer${records.length === 1 ? '' : 's'} \u2014 choose "Save as PDF" to keep a copy.`);
}
</script>
</body>
</html>
