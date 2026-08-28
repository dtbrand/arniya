<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * tags.php - Customer Labels & Cohorts
 * DT Brand's & Jai Hanuman Tex - Live Production Standard
 *
 * This page used to be a "Tagging Studio" for a feature this database does not
 * have. There is no tags table and no column on `customers` that could hold a
 * free-form label, so every tag shown here was a PHP literal: twelve invented
 * tags with invented audience sizes, headlined "12 TOTAL ACTIVE TAGS",
 * "4,820 TAGGED CUSTOMERS - 100% Shopper Coverage" and "Frequent Buyer -
 * 1,850 Shoppers - 38.3% Share". Creating a tag prepended a row to the table
 * and toasted 'Tag "X" created successfully!'; the row vanished on reload.
 *
 * That is worse than a cosmetic lie. Tags are what a shop segments a WhatsApp
 * broadcast by, so an admin was planning festive campaigns against audiences
 * that did not exist, and "Broadcast" promised to message 1,850 people who were
 * never a group.
 *
 * The page now shows the two classifications that ARE stored - `customers.tier`
 * (free text, set per customer in Edit) and `customers.type` - plus cohorts
 * derived live from spend, order count, state and order history. Every count
 * below is counted, and every link goes somewhere that filters on that column.
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/CustomerManager.php';

use DTBrand\Database;
use DTBrand\CustomerManager;

$customers      = CustomerManager::getAll();
$totalCustomers = count($customers);

// Dormancy needs the newest order per customer, which is not a column on
// `customers`. One grouped query rather than a lookup per row.
$lastOrders = [];
$pdo = Database::getConnection();
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $q = $pdo->query("SELECT `customer_id`, MAX(`created_at`) AS `last_order` FROM `orders` GROUP BY `customer_id`");
        foreach (($q ? $q->fetchAll(\PDO::FETCH_ASSOC) : []) as $r) {
            $lastOrders[(int)$r['customer_id']] = (string)$r['last_order'];
        }
    } catch (\Exception $e) {
        // No readable order history: the dormant cohort then counts every
        // customer as never-ordered, which is what "no order on record" means.
    }
}

// Tier is free text, so "VIP" and "vip" are the same label to a human. Group
// case-insensitively and display the spelling that appears first.
$tierGroups = [];
$untieredCount = 0;
$cutoff60 = strtotime('-60 days');

$cohortCounts = array_fill_keys(
    ['vip', 'frequent', 'no_orders', 'dormant', 'gujarat', 'wholesale',
     'reseller', 'retail', 'pending', 'suspended', 'gstin', 'balance'], 0
);

foreach ($customers as $c) {
    $tier   = trim((string)($c['tier'] ?? ''));
    $orders = (int)($c['total_orders'] ?? 0);
    $spend  = (float)($c['lifetime_spend'] ?? 0);
    $type   = (string)($c['type'] ?? 'retail');
    $state  = strtoupper(trim((string)($c['state'] ?? '')));

    if ($tier === '') {
        $untieredCount++;
    } else {
        $key = strtolower($tier);
        if (!isset($tierGroups[$key])) {
            $tierGroups[$key] = ['label' => $tier, 'count' => 0, 'spend' => 0.0, 'orders' => 0];
        }
        $tierGroups[$key]['count']++;
        $tierGroups[$key]['spend']  += $spend;
        $tierGroups[$key]['orders'] += $orders;
    }

    if (stripos($tier, 'vip') !== false || $spend >= 25000) $cohortCounts['vip']++;
    if ($orders >= 3)  $cohortCounts['frequent']++;
    if ($orders === 0) $cohortCounts['no_orders']++;
    if ($state === 'GJ' || $state === 'GUJARAT') $cohortCounts['gujarat']++;
    if ($type === 'wholesale') $cohortCounts['wholesale']++;
    if ($type === 'reseller')  $cohortCounts['reseller']++;
    if ($type === 'retail')    $cohortCounts['retail']++;
    if (($c['status'] ?? '') === 'pending')   $cohortCounts['pending']++;
    if (($c['status'] ?? '') === 'suspended') $cohortCounts['suspended']++;
    if (trim((string)($c['gstin'] ?? '')) !== '') $cohortCounts['gstin']++;
    if ((float)($c['outstanding_balance'] ?? 0) > 0) $cohortCounts['balance']++;

    $lo = isset($lastOrders[(int)$c['id']]) ? strtotime($lastOrders[(int)$c['id']]) : false;
    if ($lo === false || $lo < $cutoff60) $cohortCounts['dormant']++;
}

// Largest label first, so the directory reads as a real distribution.
uasort($tierGroups, function ($a, $b) { return $b['count'] <=> $a['count']; });
$tieredCount = $totalCustomers - $untieredCount;
$maxTierCount = 0;
foreach ($tierGroups as $g) { if ($g['count'] > $maxTierCount) $maxTierCount = $g['count']; }

// Every cohort below is a column this database really has. `list` says whether
// the customer directory can filter on it client-side (it holds no per-customer
// last-order date, so dormancy is export-only), and `export` carries the Export
// Studio scope key when one exists - no button is drawn for a destination that
// cannot honour it.
$cohortDefs = [
    ['key' => 'vip',       'label' => 'VIP / High-Value',      'color' => 'gold',   'list' => true,  'export' => 'vip',
     'rule' => 'Tier contains "VIP", or lifetime spend &ge; &#8377;25,000', 'source' => 'tier + lifetime_spend'],
    ['key' => 'frequent',  'label' => 'Repeat Buyers',         'color' => 'green',  'list' => true,  'export' => 'frequent',
     'rule' => 'Three or more orders on record',              'source' => 'total_orders'],
    ['key' => 'no_orders', 'label' => 'Never Ordered',         'color' => 'amber',  'list' => true,  'export' => '',
     'rule' => 'Registered but has never placed an order',    'source' => 'total_orders'],
    ['key' => 'dormant',   'label' => 'No Order in 60+ Days',  'color' => 'amber',  'list' => false, 'export' => 'dormant',
     'rule' => 'Newest order older than 60 days, or none at all', 'source' => 'orders.created_at'],
    ['key' => 'gujarat',   'label' => 'Gujarat Buyers',        'color' => 'green',  'list' => true,  'export' => 'gujarat',
     'rule' => 'State recorded as Gujarat / GJ',              'source' => 'state'],
    ['key' => 'wholesale', 'label' => 'Wholesale Accounts',    'color' => 'gold',   'list' => true,  'export' => 'wholesale',
     'rule' => 'Account type = wholesale',                    'source' => 'type'],
    ['key' => 'reseller',  'label' => 'Reseller Accounts',     'color' => 'blue',   'list' => true,  'export' => 'reseller',
     'rule' => 'Account type = reseller',                     'source' => 'type'],
    ['key' => 'retail',    'label' => 'Retail Shoppers',       'color' => 'purple', 'list' => true,  'export' => 'retail',
     'rule' => 'Account type = retail',                       'source' => 'type'],
    ['key' => 'pending',   'label' => 'Awaiting Approval',     'color' => 'amber',  'list' => true,  'export' => 'pending',
     'rule' => 'Status = pending &mdash; cannot sign in yet',  'source' => 'status'],
    ['key' => 'suspended', 'label' => 'Suspended',             'color' => 'amber',  'list' => true,  'export' => '',
     'rule' => 'Status = suspended &mdash; sign-in and trade pricing blocked', 'source' => 'status'],
    ['key' => 'gstin',     'label' => 'GSTIN on File',         'color' => 'blue',   'list' => true,  'export' => '',
     'rule' => 'A GST registration number is recorded',       'source' => 'gstin'],
    ['key' => 'balance',   'label' => 'Outstanding Balance',   'color' => 'amber',  'list' => true,  'export' => '',
     'rule' => 'Owes money &mdash; outstanding balance above zero', 'source' => 'outstanding_balance'],
];

$cohorts = [];
$maxCohortCount = 0;
$largestCohort  = ['label' => '&mdash;', 'count' => 0];
foreach ($cohortDefs as $d) {
    $d['count'] = $cohortCounts[$d['key']];
    $cohorts[] = $d;
    if ($d['count'] > $maxCohortCount) $maxCohortCount = $d['count'];
    if ($d['count'] > $largestCohort['count']) $largestCohort = ['label' => $d['label'], 'count' => $d['count']];
}

function dt_pct($part, $whole)
{
    if ($whole <= 0) return '0%';
    return number_format(($part / $whole) * 100, 1) . '%';
}

$page_title = "Customer Labels & Cohorts";
$active_nav = "customers";
$active_subnav = "tags";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> &lsaquo; DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-profile.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            <div class="dt-customers-container">
                <!-- Page Header -->
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer Labels &amp; Cohorts</span>
                            <span class="dt-cust-badge gold"><?php echo number_format($totalCustomers); ?> Customer<?php echo $totalCustomers === 1 ? '' : 's'; ?></span>
                        </h1>
                        <p class="dt-cust-subtitle">Tier labels stored on each customer, and cohorts counted live from spend, orders, state and account type.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>All Customers</span>
                        </a>
                        <a href="/admin/customers/export.php" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export Studio</span>
                        </a>
                    </div>
                </div>

                <!--
                  Every figure in this ribbon used to be a literal: 12 tags,
                  4,820 tagged customers at "100% Shopper Coverage", and a
                  "Frequent Buyer" tag holding "1,850 Shoppers / 38.3% Share" -
                  in a database with no tags table at all.
                -->
                <div class="dt-cust-kpi-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); margin-bottom:18px;">
                    <div class="dt-cust-kpi-card active">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">CUSTOMERS ON RECORD</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val"><?php echo number_format($totalCustomers); ?></div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta"><?php echo number_format($cohortCounts['wholesale'] + $cohortCounts['reseller']); ?> trade</span>
                            <span style="color:#78716C;"><?php echo number_format($cohortCounts['retail']); ?> retail</span>
                        </div>
                    </div>

                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">TIER LABELS IN USE</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#8A681F;"><?php echo number_format(count($tierGroups)); ?></div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta"><?php echo number_format($tieredCount); ?> customer<?php echo $tieredCount === 1 ? '' : 's'; ?> tiered</span>
                            <span style="color:#78716C;"><?php echo dt_pct($tieredCount, $totalCustomers); ?> of base</span>
                        </div>
                    </div>

                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">LARGEST COHORT</span>
                            <div class="dt-cust-kpi-icon emerald">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#15803D; font-size:1.15rem;"><?php echo $largestCohort['count'] > 0 ? $largestCohort['label'] : 'No cohort has members'; ?></div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta"><?php echo number_format($largestCohort['count']); ?> customer<?php echo $largestCohort['count'] === 1 ? '' : 's'; ?></span>
                            <span style="color:#15803D; font-weight:800;"><?php echo dt_pct($largestCohort['count'], $totalCustomers); ?> of base</span>
                        </div>
                    </div>

                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">NO TIER SET</span>
                            <div class="dt-cust-kpi-icon purple">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val"><?php echo number_format($untieredCount); ?></div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta"><?php echo dt_pct($untieredCount, $totalCustomers); ?> of base</span>
                            <span style="color:#78716C;">Set it in Edit</span>
                        </div>
                    </div>
                </div>

                <?php include __DIR__ . '/components/customer-tags.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/customers/assets/js/customer-tags.js?v=<?php echo time(); ?>"></script>
</body>
</html>
