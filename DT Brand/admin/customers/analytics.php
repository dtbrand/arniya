<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * analytics.php - Customer analytics computed from `customers` and `orders`
 * DT Brand's & Jai Hanuman Tex - Live Production Standard
 *
 * Every number on this page used to be typed into the HTML. The KPI ribbon read
 * "AVG LIFETIME VALUE (LTV) ₹18,450 / ↑ +14.2% YoY / Across 4,820 Shoppers",
 * "REPEAT REORDER RATE 38.4% / 1,850 Repeat Buyers / +3.8% vs Benchmark",
 * "AVG REPURCHASE INTERVAL 26.4 Days" and "VIP REVENUE CONTRIBUTION 62.8%".
 * The growth chart plotted the PHP-free literals [420,580,610,540,690,720] and
 * [180,268,270,262,330,360] against a fixed y-axis of 800 and labelled them
 * "Live Trajectory". The retention matrix listed five cohorts (420/580/610/
 * 540/690 shoppers) with hand-picked percentages. "Customer Acquisition
 * Channels" split 4,820 people across WhatsApp/Showroom/Wholesale/Instagram
 * with per-channel LTVs - there is no acquisition-source column anywhere in
 * this schema, so not one of those four numbers could have been derived. The
 * RFM matrix ended at 312/1,850/1,240/640/778 and silently omitted customers
 * who have never ordered. "Export Report" toasted that a PDF was being
 * produced and produced nothing.
 *
 * This rewrite computes each figure from two reads: every customer row, and
 * every non-cancelled order. Where the schema cannot answer a question the
 * panel says so instead of inventing a number. `orders.channel` does exist, so
 * the channel panel is now an order-channel mix - which is what that column
 * records - rather than an acquisition attribution it cannot support.
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/CustomerManager.php';

use DTBrand\Database;
use DTBrand\CustomerManager;

$DT_ORDER_CAP = 200000;

$customers      = CustomerManager::getAll();
$totalCustomers = count($customers);

$pdo       = Database::getConnection();
$dbLive    = ($pdo !== null && !Database::isMockMode());
$loadError = '';
$orderRows = [];
$capped    = false;

if ($dbLive) {
    try {
        // Cancelled orders are excluded: counting them as revenue would inflate
        // lifetime value and count a cancellation as a retained customer.
        $st = $pdo->query("SELECT `customer_id`, `created_at`, `total_amount`, `channel`
                             FROM `orders`
                            WHERE `fulfillment_status` <> 'cancelled'
                            ORDER BY `created_at` ASC
                            LIMIT " . (int)$DT_ORDER_CAP);
        $orderRows = $st ? $st->fetchAll(\PDO::FETCH_ASSOC) : [];
        $capped    = count($orderRows) >= $DT_ORDER_CAP;
    } catch (\Exception $e) {
        $loadError = 'The orders table could not be read, so nothing below that depends on order history can be shown.';
    }
} else {
    $loadError = 'No database connection, so there is no customer or order history to analyse.';
}

// ── Per-customer order aggregate ────────────────────────────────────────────
// Built from the order rows rather than customers.total_orders / lifetime_spend
// so that recency, first-order date and revenue all come from the same source
// and cannot disagree with each other.
$agg = [];   // customer_id => [n, rev, first, last]
foreach ($orderRows as $o) {
    $cid = (int)$o['customer_id'];
    $ts  = strtotime((string)$o['created_at']);
    if ($ts === false) { $ts = null; }
    if (!isset($agg[$cid])) {
        $agg[$cid] = ['n' => 0, 'rev' => 0.0, 'first' => $ts, 'last' => $ts];
    }
    $agg[$cid]['n']++;
    $agg[$cid]['rev'] += (float)$o['total_amount'];
    if ($ts !== null) {
        if ($agg[$cid]['first'] === null || $ts < $agg[$cid]['first']) { $agg[$cid]['first'] = $ts; }
        if ($agg[$cid]['last']  === null || $ts > $agg[$cid]['last'])  { $agg[$cid]['last']  = $ts; }
    }
}

$totalOrders  = count($orderRows);
$totalRevenue = 0.0;
foreach ($agg as $a) { $totalRevenue += $a['rev']; }

// An aggregate row can exist for a customer_id that is no longer in the
// customers table (deleted account, historical order). Those orders still count
// as revenue, but they are not a *customer* for per-customer averages.
$knownIds = [];
foreach ($customers as $c) { $knownIds[(int)$c['id']] = true; }
$orphanOrders = 0;
foreach ($agg as $cid => $a) { if (!isset($knownIds[$cid])) { $orphanOrders += $a['n']; } }

$buyers       = 0;
$repeatBuyers = 0;
$revenues     = [];
foreach ($customers as $c) {
    $a = $agg[(int)$c['id']] ?? null;
    if ($a === null || $a['n'] < 1) continue;
    $buyers++;
    if ($a['n'] >= 2) $repeatBuyers++;
    $revenues[] = $a['rev'];
}
$neverOrdered = $totalCustomers - $buyers;

// ── KPI 1: average lifetime value ───────────────────────────────────────────
// Two denominators, because they answer different questions and the old card
// quietly conflated them: revenue per *buyer* is what a buyer is worth, revenue
// per *registered customer* is what a signup is worth.
$buyerRevenue = array_sum($revenues);
$ltvPerBuyer  = $buyers > 0 ? $buyerRevenue / $buyers : 0.0;
$ltvPerSignup = $totalCustomers > 0 ? $buyerRevenue / $totalCustomers : 0.0;

// ── KPI 2: repeat rate ──────────────────────────────────────────────────────
$repeatRate = $buyers > 0 ? ($repeatBuyers / $buyers) * 100 : 0.0;

// ── KPI 3: average repurchase interval ──────────────────────────────────────
// One figure per repeat customer - the mean gap between their own orders - then
// averaged across those customers, so a single very frequent buyer cannot drag
// the whole number down.
$intervalSum   = 0.0;
$intervalCount = 0;
foreach ($customers as $c) {
    $a = $agg[(int)$c['id']] ?? null;
    if ($a === null || $a['n'] < 2) continue;
    if ($a['first'] === null || $a['last'] === null) continue;
    $span = $a['last'] - $a['first'];
    if ($span <= 0) continue;   // several orders on the same day: no interval yet
    $intervalSum += ($span / 86400) / ($a['n'] - 1);
    $intervalCount++;
}
$avgInterval = $intervalCount > 0 ? $intervalSum / $intervalCount : null;

// ── KPI 4: revenue share of the top decile of buyers ────────────────────────
// The old card asserted "Top 15% VIP Shoppers - 62.8%". Below 10 buyers a
// decile is a single person, so the card says how many people it is counting.
rsort($revenues);
$topN      = $buyers > 0 ? max(1, (int)ceil($buyers * 0.10)) : 0;
$topRev    = 0.0;
for ($i = 0; $i < $topN && $i < count($revenues); $i++) { $topRev += $revenues[$i]; }
$topShare  = $buyerRevenue > 0 ? ($topRev / $buyerRevenue) * 100 : 0.0;

// ── Monthly series: registrations, orders, repeat orders ─────────────────────
$monthKeys   = [];
$monthLabels = [];
$anchor      = (int)date('Y') * 12 + ((int)date('n') - 1);
for ($i = 11; $i >= 0; $i--) {
    $m   = $anchor - $i;
    $y   = intdiv($m, 12);
    $mo  = ($m % 12) + 1;
    $key = sprintf('%04d-%02d', $y, $mo);
    $monthKeys[]   = $key;
    $monthLabels[] = date('M Y', mktime(0, 0, 0, $mo, 1, $y));
}
$regByMonth    = array_fill_keys($monthKeys, 0);
$ordByMonth    = array_fill_keys($monthKeys, 0);
$repeatByMonth = array_fill_keys($monthKeys, 0);
$revByMonth    = array_fill_keys($monthKeys, 0.0);

foreach ($customers as $c) {
    $ts = $c['created_at'] !== '' ? strtotime($c['created_at']) : false;
    if ($ts === false) continue;
    $k = date('Y-m', $ts);
    if (isset($regByMonth[$k])) $regByMonth[$k]++;
}

$seenBuyer = [];
foreach ($orderRows as $o) {          // already sorted oldest first
    $cid = (int)$o['customer_id'];
    $ts  = strtotime((string)$o['created_at']);
    $isRepeat = isset($seenBuyer[$cid]);
    $seenBuyer[$cid] = true;
    if ($ts === false) continue;
    $k = date('Y-m', $ts);
    if (!isset($ordByMonth[$k])) continue;
    $ordByMonth[$k]++;
    $revByMonth[$k] += (float)$o['total_amount'];
    if ($isRepeat) $repeatByMonth[$k]++;
}

$hasMonthlyData = (array_sum($regByMonth) + array_sum($ordByMonth)) > 0;
$newRegTotal    = array_sum($regByMonth);
$ordTotal12     = array_sum($ordByMonth);
$repeatTotal12  = array_sum($repeatByMonth);

// ── Cohort retention ────────────────────────────────────────────────────────
// A cohort is the month a customer registered. Mx is the share of that cohort
// that placed at least one order x whole months later. A cell is left blank -
// not zeroed - when that month has not happened yet, because "no data" and "no
// one came back" are different facts.
$monthIndex = function ($ts) { return ((int)date('Y', $ts)) * 12 + ((int)date('n', $ts) - 1); };

// One pass over the orders instead of re-scanning them inside the customer loop.
$orderMonthsByCustomer = [];
foreach ($orderRows as $o) {
    $ots = strtotime((string)$o['created_at']);
    if ($ots === false) continue;
    $orderMonthsByCustomer[(int)$o['customer_id']][$monthIndex($ots)] = true;
}

$cohortMembers = [];   // monthIdx => customer count
$cohortHits    = [];   // monthIdx => [offset => count]
foreach ($customers as $c) {
    $ts = $c['created_at'] !== '' ? strtotime($c['created_at']) : false;
    if ($ts === false) continue;
    $ci = $monthIndex($ts);
    if (!isset($cohortMembers[$ci])) {
        $cohortMembers[$ci] = 0;
        $cohortHits[$ci]    = array_fill(0, 5, 0);
    }
    $cohortMembers[$ci]++;

    foreach (array_keys($orderMonthsByCustomer[(int)$c['id']] ?? []) as $om) {
        $off = $om - $ci;
        if ($off >= 0 && $off <= 4) { $cohortHits[$ci][$off]++; }
    }
}
krsort($cohortMembers);
$cohorts = [];
foreach ($cohortMembers as $ci => $n) {
    if (count($cohorts) >= 6) break;
    $cohorts[] = [
        'idx'     => $ci,
        'label'   => date('M Y', mktime(0, 0, 0, ($ci % 12) + 1, 1, intdiv($ci, 12))),
        'members' => $n,
        'hits'    => $cohortHits[$ci],
        'elapsed' => $anchor - $ci,   // whole months since the cohort registered
    ];
}

// ── Order channel mix ───────────────────────────────────────────────────────
// `orders.channel` is ENUM('retail','wholesale','reseller','whatsapp'). It
// records how the order was placed, not how the customer was acquired, so the
// panel is labelled accordingly. All four values are listed even at zero, so an
// unused channel reads as unused rather than as absent.
$channelDefs = [
    'whatsapp'  => ['label' => 'WhatsApp Order',        'dot' => '#15803D', 'grad' => 'linear-gradient(90deg, #15803D, #22C55E)'],
    'retail'    => ['label' => 'Retail Storefront',     'dot' => '#8A681F', 'grad' => 'linear-gradient(90deg, #B8860B, #D4AF37)'],
    'wholesale' => ['label' => 'Wholesale (B2B lot)',   'dot' => '#7E22CE', 'grad' => 'linear-gradient(90deg, #7E22CE, #A855F7)'],
    'reseller'  => ['label' => 'Reseller',              'dot' => '#1D4ED8', 'grad' => 'linear-gradient(90deg, #1D4ED8, #60A5FA)'],
];
$channelStats = [];
foreach ($channelDefs as $k => $d) { $channelStats[$k] = ['orders' => 0, 'rev' => 0.0]; }
$unknownChannel = ['orders' => 0, 'rev' => 0.0];
foreach ($orderRows as $o) {
    $ch = strtolower(trim((string)($o['channel'] ?? '')));
    $amt = (float)$o['total_amount'];
    if (isset($channelStats[$ch])) { $channelStats[$ch]['orders']++; $channelStats[$ch]['rev'] += $amt; }
    else { $unknownChannel['orders']++; $unknownChannel['rev'] += $amt; }
}
$channelRevTotal = 0.0;
foreach ($channelStats as $s) { $channelRevTotal += $s['rev']; }
$channelRevTotal += $unknownChannel['rev'];
$activeChannels = 0;
foreach ($channelStats as $s) { if ($s['orders'] > 0) $activeChannels++; }
if ($unknownChannel['orders'] > 0) $activeChannels++;

// ── RFM buckets ─────────────────────────────────────────────────────────────
// Mutually exclusive, evaluated top to bottom, and they include a "never
// ordered" bucket the old matrix left out - so the counts add up to the whole
// customer base and the total can be checked against the directory.
$now = time();
$rfm = [
    'champion'  => 0, 'loyal' => 0, 'potential' => 0,
    'at_risk'   => 0, 'dormant' => 0, 'never' => 0,
];
foreach ($customers as $c) {
    $a = $agg[(int)$c['id']] ?? null;
    if ($a === null || $a['n'] < 1 || $a['last'] === null) { $rfm['never']++; continue; }
    $days = ($now - $a['last']) / 86400;
    if     ($days > 120)                                    $rfm['dormant']++;
    elseif ($days > 60)                                     $rfm['at_risk']++;
    elseif ($a['rev'] >= 50000 && $a['n'] >= 2)             $rfm['champion']++;
    elseif ($a['n'] >= 3)                                   $rfm['loyal']++;
    else                                                    $rfm['potential']++;
}

// These buckets deliberately carry no "view customers" deep link. The directory
// filters on customers.total_orders and customers.lifetime_spend; these buckets
// are computed from non-cancelled orders and include a recency test the
// directory cannot apply. A link would open a list whose count disagreed with
// the card above it. Use the Cohort Builder, which matches on the same columns
// it displays.
$rfmDefs = [
    ['key' => 'champion',  'label' => 'Champions',    'rule' => 'Spend &ge; &#8377;50,000 and 2+ orders, ordered in the last 60 days', 'bar' => '#D4AF37', 'ink' => '#8A681F'],
    ['key' => 'loyal',     'label' => 'Loyalists',    'rule' => '3+ orders, ordered in the last 60 days',                              'bar' => '#15803D', 'ink' => '#15803D'],
    ['key' => 'potential', 'label' => 'Potential',    'rule' => '1 or 2 orders, ordered in the last 60 days',                          'bar' => '#1D4ED8', 'ink' => '#1D4ED8'],
    ['key' => 'at_risk',   'label' => 'At Risk',      'rule' => 'Last order 61 to 120 days ago',                                       'bar' => '#B45309', 'ink' => '#B45309'],
    ['key' => 'dormant',   'label' => 'Dormant',      'rule' => 'Last order more than 120 days ago',                                   'bar' => '#DC2626', 'ink' => '#DC2626'],
    ['key' => 'never',     'label' => 'Never Ordered','rule' => 'Registered with no order on record',                                  'bar' => '#78716C', 'ink' => '#57534E'],
];
$rfmTotal = array_sum($rfm);

function dt_an_pct($part, $whole)
{
    if ($whole <= 0) return '0%';
    return number_format(($part / $whole) * 100, 1) . '%';
}

function dt_an_money($n)
{
    return '&#8377;' . number_format((float)$n, 0);
}

// Data the chart draws. Real months, real counts, and no fixed y-axis maximum.
$chartPayload = [
    'labels'  => $monthLabels,
    'signups' => array_values($regByMonth),
    'orders'  => array_values($ordByMonth),
    'repeat'  => array_values($repeatByMonth),
];

$page_title    = "Customer Analytics";
$active_nav    = "customers";
$active_subnav = "analytics";
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
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-analytics.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:16px;">

                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer Analytics</span>
                            <span class="dt-cust-badge gold"><?php echo number_format($totalCustomers); ?> Customer<?php echo $totalCustomers === 1 ? '' : 's'; ?> &middot; <?php echo number_format($totalOrders); ?> Order<?php echo $totalOrders === 1 ? '' : 's'; ?></span>
                        </h1>
                        <p class="dt-cust-subtitle">Computed at page load from the customers table and every non-cancelled order. Nothing here is a stored or estimated figure.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>All Customers</span>
                        </a>
                        <!--
                          "Export Report" used to toast that a PDF/Excel report was
                          being produced; no report was ever generated. The Export
                          Studio is the one place in this admin that really writes a
                          file, so the button now goes there.
                        -->
                        <a href="/admin/customers/export.php" class="dt-btn dt-btn-gold" style="text-decoration:none;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.6"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export Customer Data</span>
                        </a>
                    </div>
                </div>

                <?php if ($loadError !== ''): ?>
                    <div class="dt-card" style="padding:14px 18px; border-left:3px solid #DC2626;">
                        <div style="font-size:0.86rem; font-weight:800; color:#181512;">Order history unavailable</div>
                        <p style="font-size:0.79rem; color:#57534E; margin:5px 0 0; line-height:1.55;"><?php echo htmlspecialchars($loadError); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($capped): ?>
                    <div class="dt-card" style="padding:14px 18px; border-left:3px solid #B45309;">
                        <div style="font-size:0.86rem; font-weight:800; color:#181512;">Reading the most recent <?php echo number_format($DT_ORDER_CAP); ?> orders only</div>
                        <p style="font-size:0.79rem; color:#57534E; margin:5px 0 0; line-height:1.55;">The order table is larger than this page reads in one request, so the figures below cover a subset. Treat them as a floor, not a total.</p>
                    </div>
                <?php endif; ?>

                <?php if ($orphanOrders > 0): ?>
                    <div class="dt-card" style="padding:14px 18px; border-left:3px solid #B45309;">
                        <div style="font-size:0.86rem; font-weight:800; color:#181512;"><?php echo number_format($orphanOrders); ?> order<?php echo $orphanOrders === 1 ? '' : 's'; ?> belong to a customer_id that is no longer in the customers table</div>
                        <p style="font-size:0.79rem; color:#57534E; margin:5px 0 0; line-height:1.55;">Their revenue is still real, but they cannot be counted in any per-customer average below.</p>
                    </div>
                <?php endif; ?>

                <div class="dt-cust-kpi-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
                    <div class="dt-cust-kpi-card active">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">AVG LIFETIME VALUE PER BUYER</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#8A681F;"><?php echo $buyers > 0 ? dt_an_money($ltvPerBuyer) : '&mdash;'; ?></div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta"><?php echo dt_an_money($buyerRevenue); ?> from <?php echo number_format($buyers); ?> buyer<?php echo $buyers === 1 ? '' : 's'; ?></span>
                            <span style="color:#78716C;"><?php echo $totalCustomers > 0 ? dt_an_money($ltvPerSignup) . ' per signup' : 'no customers yet'; ?></span>
                        </div>
                    </div>

                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">REPEAT PURCHASE RATE</span>
                            <div class="dt-cust-kpi-icon emerald">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:<?php echo $buyers > 0 ? '#15803D' : '#A8A29E'; ?>;"><?php echo $buyers > 0 ? number_format($repeatRate, 1) . '%' : '&mdash;'; ?></div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta"><?php echo number_format($repeatBuyers); ?> of <?php echo number_format($buyers); ?> bought twice or more</span>
                            <span style="color:#78716C;"><?php echo number_format($neverOrdered); ?> never ordered</span>
                        </div>
                    </div>

                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">AVG REPURCHASE INTERVAL</span>
                            <div class="dt-cust-kpi-icon purple">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:<?php echo $avgInterval !== null ? '#181512' : '#A8A29E'; ?>;"><?php echo $avgInterval !== null ? number_format($avgInterval, 1) . ' days' : '&mdash;'; ?></div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta"><?php echo $avgInterval !== null ? 'Mean gap across ' . number_format($intervalCount) . ' repeat buyer' . ($intervalCount === 1 ? '' : 's') : 'No customer has two orders on different days yet'; ?></span>
                        </div>
                    </div>

                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">TOP 10% REVENUE SHARE</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:<?php echo $buyerRevenue > 0 ? '#B8860B' : '#A8A29E'; ?>;"><?php echo $buyerRevenue > 0 ? number_format($topShare, 1) . '%' : '&mdash;'; ?></div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta"><?php echo $topN > 0 ? 'Highest-spending ' . number_format($topN) . ' buyer' . ($topN === 1 ? '' : 's') . ' &mdash; ' . dt_an_money($topRev) : 'No revenue on record'; ?></span>
                            <?php if ($buyers > 0 && $buyers < 10): ?><span style="color:#B45309; font-weight:700;">Only <?php echo number_format($buyers); ?> buyers &mdash; a decile is 1 person</span><?php endif; ?>
                        </div>
                    </div>
                </div>


                <div class="dt-analytics-grid">
                    <div class="dt-analytics-card">
                        <div class="dt-analytics-head">
                            <div>
                                <h3 class="dt-card-title" style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                    <span>Signups and Orders, Last 12 Months</span>
                                </h3>
                                <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Registrations from <code>customers.created_at</code>, orders from <code>orders.created_at</code>, both counted per calendar month.</p>
                            </div>
                        </div>

                        <?php if (!$hasMonthlyData): ?>
                            <div style="padding:34px 16px; text-align:center; color:#78716C; font-size:0.82rem;">
                                No customer registered and no order was placed in the last 12 months, so there is no line to draw.
                            </div>
                        <?php else: ?>
                            <div class="dt-analytics-canvas-wrap">
                                <canvas id="dtCustGrowthCanvas" width="520" height="210"></canvas>
                            </div>
                            <div class="dt-analytics-legend">
                                <div style="display:flex; align-items:center; gap:6px;">
                                    <span class="dt-analytics-dot" style="background:#8A681F;"></span>
                                    <span>New signups (<?php echo number_format($newRegTotal); ?> in 12 months)</span>
                                </div>
                                <div style="display:flex; align-items:center; gap:6px;">
                                    <span class="dt-analytics-dot" style="background:#15803D;"></span>
                                    <span>Orders (<?php echo number_format($ordTotal12); ?>, of which <?php echo number_format($repeatTotal12); ?> repeat)</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="dt-analytics-card">
                        <div class="dt-analytics-head">
                            <div>
                                <h3 class="dt-card-title" style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                    <span>Signup Cohort Retention</span>
                                </h3>
                                <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Share of each signup month that placed an order that many months later. A blank cell is a month that has not happened yet, not a zero.</p>
                            </div>
                        </div>

                        <?php if (empty($cohorts)): ?>
                            <div style="padding:34px 16px; text-align:center; color:#78716C; font-size:0.82rem;">
                                No customer has a usable registration date, so no cohort can be formed.
                            </div>
                        <?php else: ?>
                            <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
                                <table class="dt-cohort-table">
                                    <thead>
                                        <tr>
                                            <th>Signup Month</th>
                                            <th>Customers</th>
                                            <th>M0</th><th>M1</th><th>M2</th><th>M3</th><th>M4</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($cohorts as $co): ?>
                                        <tr>
                                            <td style="font-weight:800; color:#181512; text-align:left; padding-left:8px;"><?php echo htmlspecialchars($co['label']); ?></td>
                                            <td style="font-weight:700; color:#78716C;"><?php echo number_format($co['members']); ?></td>
                                            <?php for ($m = 0; $m <= 4; $m++): ?>
                                                <?php if ($m > $co['elapsed']): ?>
                                                    <td style="color:#9CA3AF;" title="This month has not elapsed for this cohort">&mdash;</td>
                                                <?php else:
                                                    $hit = $co['hits'][$m];
                                                    $p   = $co['members'] > 0 ? ($hit / $co['members']) * 100 : 0;
                                                    if ($p >= 35)      { $bg = '#DCFCE7'; $fg = '#15803D'; }
                                                    elseif ($p >= 15)  { $bg = '#E2F9E8'; $fg = '#166534'; }
                                                    elseif ($p > 0)    { $bg = '#EFFCF3'; $fg = '#166534'; }
                                                    else               { $bg = '#F5F5F4'; $fg = '#78716C'; }
                                                ?>
                                                    <td class="dt-cohort-cell" style="background:<?php echo $bg; ?>; color:<?php echo $fg; ?>;" title="<?php echo number_format($hit); ?> of <?php echo number_format($co['members']); ?> ordered"><?php echo number_format($p, 1); ?>%</td>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="dt-analytics-grid">
                    <div class="dt-analytics-card">
                        <div class="dt-analytics-head">
                            <div>
                                <h3 class="dt-card-title" style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                    <span>Order Channel Mix</span>
                                </h3>
                                <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">From <code>orders.channel</code> &mdash; how each order was placed. This schema records no acquisition source, so it cannot say where a customer came from.</p>
                            </div>
                            <span class="dt-cust-badge gold" style="font-size:0.65rem;"><?php echo $activeChannels; ?> in use</span>
                        </div>

                        <?php if ($totalOrders === 0): ?>
                            <div style="padding:34px 16px; text-align:center; color:#78716C; font-size:0.82rem;">
                                No orders on record, so no channel has a share.
                            </div>
                        <?php else: ?>
                            <div style="display:flex; flex-direction:column; gap:10px;">
                                <?php
                                $chRows = [];
                                foreach ($channelDefs as $k => $d) {
                                    $chRows[] = ['label' => $d['label'], 'dot' => $d['dot'], 'grad' => $d['grad'],
                                                 'orders' => $channelStats[$k]['orders'], 'rev' => $channelStats[$k]['rev']];
                                }
                                if ($unknownChannel['orders'] > 0) {
                                    $chRows[] = ['label' => 'Channel not recorded', 'dot' => '#78716C',
                                                 'grad' => 'linear-gradient(90deg, #A8A29E, #D6D3D1)',
                                                 'orders' => $unknownChannel['orders'], 'rev' => $unknownChannel['rev']];
                                }
                                usort($chRows, function ($a, $b) { return $b['orders'] <=> $a['orders']; });
                                foreach ($chRows as $ch):
                                    $share = $totalOrders > 0 ? ($ch['orders'] / $totalOrders) * 100 : 0;
                                    $aov   = $ch['orders'] > 0 ? $ch['rev'] / $ch['orders'] : 0;
                                ?>
                                    <div class="dt-channel-item">
                                        <div class="dt-channel-meta">
                                            <div style="display:flex; align-items:center; gap:6px;">
                                                <span style="width:8px; height:8px; border-radius:50%; background:<?php echo $ch['dot']; ?>; display:inline-block;"></span>
                                                <span><?php echo htmlspecialchars($ch['label']); ?></span>
                                            </div>
                                            <div style="text-align:right;">
                                                <strong><?php echo number_format($ch['orders']); ?> (<?php echo number_format($share, 1); ?>%)</strong>
                                                <span style="font-size:0.68rem; color:<?php echo $ch['orders'] > 0 ? '#8A681F' : '#A8A29E'; ?>; margin-left:6px;">
                                                    <?php echo $ch['orders'] > 0 ? 'Avg order ' . dt_an_money($aov) : 'never used'; ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="dt-channel-bar-wrap">
                                            <div class="dt-channel-bar" style="width:<?php echo number_format($share, 2); ?>%; background:<?php echo $ch['grad']; ?>;"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <p style="font-size:0.7rem; color:#78716C; margin:12px 0 0;">
                                Revenue across all channels: <strong><?php echo dt_an_money($channelRevTotal); ?></strong> over <?php echo number_format($totalOrders); ?> non-cancelled order<?php echo $totalOrders === 1 ? '' : 's'; ?>.
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="dt-analytics-card">
                        <div class="dt-analytics-head">
                            <div>
                                <h3 class="dt-card-title" style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    <span>Recency, Frequency &amp; Value Buckets</span>
                                </h3>
                                <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Each customer falls in exactly one bucket, so these add up to the whole base.</p>
                            </div>
                            <a href="/admin/customers/segments.php" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:2px 8px; font-size:0.7rem; text-decoration:none;">Cohort Builder</a>
                        </div>

                        <div class="dt-rfm-grid">
                            <?php foreach ($rfmDefs as $d):
                                $n = $rfm[$d['key']];
                            ?>
                                <div class="dt-rfm-tier-card" style="border-left:3px solid <?php echo $d['bar']; ?>;">
                                    <div style="display:flex; align-items:center; justify-content:space-between; gap:6px;">
                                        <span style="font-size:0.68rem; font-weight:800; color:<?php echo $d['ink']; ?>; text-transform:uppercase;"><?php echo htmlspecialchars($d['label']); ?></span>
                                        <span style="font-size:0.62rem; font-weight:700; color:#78716C;"><?php echo dt_an_pct($n, $rfmTotal); ?></span>
                                    </div>
                                    <div style="font-size:1.15rem; font-weight:900; color:<?php echo $n > 0 ? '#181512' : '#A8A29E'; ?>;"><?php echo number_format($n); ?></div>
                                    <div style="font-size:0.65rem; color:#78716C; line-height:1.45;"><?php echo $d['rule']; ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <p style="font-size:0.7rem; color:#78716C; margin:12px 0 0;">
                            <?php echo number_format($rfmTotal); ?> customer<?php echo $rfmTotal === 1 ? '' : 's'; ?> placed across six buckets
                            <?php if ($rfmTotal !== $totalCustomers): ?>
                                &mdash; <strong style="color:#B45309;"><?php echo number_format(abs($totalCustomers - $rfmTotal)); ?> unaccounted for</strong>, which should not happen; the directory holds <?php echo number_format($totalCustomers); ?>.
                            <?php else: ?>
                                &mdash; matching the <?php echo number_format($totalCustomers); ?> in the directory.
                            <?php endif; ?>
                            Recency is measured against the newest non-cancelled order, so a cancelled order does not keep a customer looking active.
                        </p>
                    </div>

                </div>


            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script>
    // The old chart hardcoded [420,580,610,540,690,720] against a fixed y-axis
    // of 800 and called it "Live Trajectory". These are the real monthly counts.
    window.dtAnalytics = <?php echo json_encode($chartPayload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); ?>;
</script>
<script>
(function () {
    'use strict';

    function draw() {
        var data = window.dtAnalytics || {};
        var labels = data.labels || [];
        var signups = data.signups || [];
        var orders = data.orders || [];
        var canvas = document.getElementById('dtCustGrowthCanvas');
        if (!canvas || !canvas.getContext || labels.length < 2) return;

        var ctx = canvas.getContext('2d');
        var dpr = window.devicePixelRatio || 1;
        var w = (canvas.parentElement && canvas.parentElement.clientWidth) || 480;
        var h = 210;
        canvas.width = w * dpr;
        canvas.height = h * dpr;
        canvas.style.width = w + 'px';
        canvas.style.height = h + 'px';
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        ctx.clearRect(0, 0, w, h);

        // Scale to the tallest real value. A fixed maximum would flatten a small
        // shop's data into a line along the axis and exaggerate a large one.
        var peak = 0;
        signups.concat(orders).forEach(function (v) { if (Number(v) > peak) peak = Number(v); });
        var maxVal = peak > 0 ? peak * 1.15 : 1;

        var padL = 38, padR = 22, padT = 18, padB = 30;
        var cW = w - padL - padR;
        var cH = h - padT - padB;
        var step = cW / (labels.length - 1);
        var xAt = function (i) { return padL + i * step; };
        var yAt = function (v) { return h - padB - ((Number(v) || 0) / maxVal) * cH; };

        ctx.strokeStyle = '#F0ECE1';
        ctx.lineWidth = 1;
        ctx.setLineDash([4, 4]);
        for (var g = 0; g <= 3; g++) {
            var gy = padT + (cH / 3) * g;
            ctx.beginPath(); ctx.moveTo(padL, gy); ctx.lineTo(w - padR, gy); ctx.stroke();
        }
        ctx.setLineDash([]);

        // Y-axis: the real peak and zero, so the shape can be read as a quantity.
        ctx.fillStyle = '#A8A29E';
        ctx.font = '700 9px Plus Jakarta Sans, sans-serif';
        ctx.textAlign = 'right';
        ctx.fillText(String(Math.round(maxVal)), padL - 6, padT + 4);
        ctx.fillText('0', padL - 6, h - padB + 3);

        var series = [
            { vals: signups, stroke: '#8A681F', fill: 'rgba(184, 134, 11, 0.22)' },
            { vals: orders,  stroke: '#15803D', fill: 'rgba(21, 128, 61, 0.18)' }
        ];
        series.forEach(function (s) {
            var grad = ctx.createLinearGradient(0, padT, 0, h - padB);
            grad.addColorStop(0, s.fill);
            grad.addColorStop(1, 'rgba(255,255,255,0)');
            ctx.fillStyle = grad;
            ctx.beginPath();
            ctx.moveTo(padL, h - padB);
            labels.forEach(function (l, i) { ctx.lineTo(xAt(i), yAt(s.vals[i])); });
            ctx.lineTo(w - padR, h - padB);
            ctx.closePath();
            ctx.fill();

            ctx.strokeStyle = s.stroke;
            ctx.lineWidth = 2.6;
            ctx.beginPath();
            labels.forEach(function (l, i) {
                var x = xAt(i), y = yAt(s.vals[i]);
                if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
            });
            ctx.stroke();

            ctx.fillStyle = s.stroke;
            labels.forEach(function (l, i) {
                ctx.beginPath();
                ctx.arc(xAt(i), yAt(s.vals[i]), 3.4, 0, Math.PI * 2);
                ctx.fill();
            });
        });

        // 12 labels do not fit; every other month keeps them legible.
        ctx.fillStyle = '#78716C';
        ctx.font = '700 9px Plus Jakarta Sans, sans-serif';
        ctx.textAlign = 'center';
        labels.forEach(function (l, i) {
            if (i % 2 !== 0 && i !== labels.length - 1) return;
            ctx.fillText(String(l).replace(' 20', " '"), xAt(i), h - padB + 16);
        });
    }

    document.addEventListener('DOMContentLoaded', draw);
    var t = null;
    window.addEventListener('resize', function () {
        clearTimeout(t);
        t = setTimeout(draw, 150);
    });
})();
</script>


</body>
</html>
