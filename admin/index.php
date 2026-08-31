<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin.php — Luxury Executive Admin Dashboard & WhatsApp CRM Control Center
 * DT Brand's & Jai Hanuman Tex
 * 
 * Signature Heritage Gold Theme + Full CRM, Multi-Channel Commerce & Logistics
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/CustomerManager.php';
require_once __DIR__ . '/../src/OrderManager.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;
use DTBrand\CustomerManager;
use DTBrand\OrderManager;

$db = Database::getConnection();

// Real Dynamic Database Metrics
$allProducts = ProductCatalog::getAll(true);
$totalProductsCount = count($allProducts);
$categoriesList = ProductCatalog::getCategories();
$totalCategoriesCount = count($categoriesList);
$allCustomers = CustomerManager::getAll();
$totalCustomersCount = count($allCustomers);
$totalWholesaleCount = count(CustomerManager::getByType('wholesale'));
$totalResellerCount = count(CustomerManager::getByType('reseller'));
// Seeded empty on purpose. This used to be OrderManager::getAll(), which falls
// back to a built-in demo array when the database is unreachable AND reshapes
// live rows into its own key names ('customer', 'amount', 'status', 'source').
// Every widget on this page reads raw `orders` columns, so those demo rows
// rendered as ORD-0 / Rs 0 placeholder orders on a dead connection. The real
// rows are loaded below, only when there is a live database.
$recentOrdersList = [];
$totalOrdersCount = 0;

/**
 * ══ LIVE DASHBOARD ANALYTICS ══
 *
 * Every figure rendered below is read from real rows. Two rules the previous
 * version of this block broke, and both produced numbers that looked real:
 *
 *  1. Only use ENUM values the schema actually declares.
 *     `orders.fulfillment_status` is ENUM('unfulfilled','processing','dispatched',
 *     'delivered','cancelled') and `payment_status` is ENUM('pending','paid',
 *     'credit','refunded'). Queries for 'new', 'confirmed', 'packed', 'shipped'
 *     or 'unpaid' can never match a row, so they reported a permanent 0 that was
 *     indistinguishable from a genuine zero - while 'unfulfilled', the state a
 *     new order actually lands in, was counted nowhere on the page.
 *
 *  2. Be NULL-safe. `fulfillment_status != 'cancelled'` evaluates to NULL, not
 *     TRUE, on a row where the column is NULL, so MySQL silently dropped those
 *     orders from every sales total. That is one way a shop with real orders
 *     shows a total sale of zero.
 *
 * Each query is also wrapped individually. The old single shared catch reset
 * the order list, the order count and the sales total to zero if ANY one query
 * failed, so a single bad column blanked the whole dashboard.
 */
$dbLive = ($db !== null && !Database::isMockMode());
$notCancelled = "COALESCE(`fulfillment_status`, 'unfulfilled') <> 'cancelled'";

/** Scalar aggregate. Returns $fallback when there is no database. */
$dtNum = function (string $sql, float $fallback = 0.0) use ($db, $dbLive): float {
    if (!$dbLive) {
        return $fallback;
    }
    try {
        return (float)$db->query($sql)->fetchColumn();
    } catch (\Throwable $e) {
        error_log('DT dashboard aggregate failed: ' . $e->getMessage());
        return $fallback;
    }
};

/** Row set. Returns [] when there is no database, never mock rows. */
$dtRows = function (string $sql) use ($db, $dbLive): array {
    if (!$dbLive) {
        return [];
    }
    try {
        return $db->query($sql)->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    } catch (\Throwable $e) {
        error_log('DT dashboard rowset failed: ' . $e->getMessage());
        return [];
    }
};

if ($dbLive) {
    $recentOrdersList = $dtRows("SELECT * FROM `orders` ORDER BY `id` DESC LIMIT 10");
    $totalOrdersCount = (int)$dtNum("SELECT COUNT(*) FROM `orders`");
}


// ── Money, orders, customers and stock: all real ──
$totalSalesAmount = $dtNum("SELECT COALESCE(SUM(`total_amount`), 0) FROM `orders` WHERE {$notCancelled}");
$liveOrdersCount  = (int)$dtNum("SELECT COUNT(*) FROM `orders` WHERE {$notCancelled}");

// Net revenue is the goods value actually billed - subtotal less discount. This
// line used to read `round($totalSalesAmount * 0.35, 2)`: an invented 35% margin
// printed under the label "TOTAL REVENUE".
$netRevenueAmount   = $dtNum("SELECT COALESCE(SUM(`subtotal` - `discount`), 0) FROM `orders` WHERE {$notCancelled}");
$totalRevenueAmount = round($netRevenueAmount, 2);
$gstCollected       = $dtNum("SELECT COALESCE(SUM(`gst_amount`), 0) FROM `orders` WHERE {$notCancelled}");
$discountGiven      = $dtNum("SELECT COALESCE(SUM(`discount`), 0) FROM `orders` WHERE {$notCancelled}");

// 'unpaid' is not a value this ENUM declares. Money genuinely still owed sits in
// 'pending' (awaiting payment) and 'credit' (invoiced on trade credit terms).
$pendingPayments = $dtNum("SELECT COALESCE(SUM(`total_amount`), 0) FROM `orders` WHERE `payment_status` IN ('pending','credit')");
$pendingPayCount = (int)$dtNum("SELECT COUNT(*) FROM `orders` WHERE `payment_status` IN ('pending','credit')");
$paidOrdersCount = (int)$dtNum("SELECT COUNT(*) FROM `orders` WHERE `payment_status` = 'paid'");

$todaySales        = $dtNum("SELECT COALESCE(SUM(`total_amount`), 0) FROM `orders` WHERE DATE(`created_at`) = CURDATE() AND {$notCancelled}");
$liveOrdersToday   = (int)$dtNum("SELECT COUNT(*) FROM `orders` WHERE DATE(`created_at`) = CURDATE()");
$newCustomersToday = (int)$dtNum("SELECT COUNT(*) FROM `customers` WHERE DATE(`created_at`) = CURDATE()");
$avgOrderValue     = $liveOrdersCount > 0 ? round($totalSalesAmount / $liveOrdersCount, 2) : 0.0;

// Channel partner counts and turnover for the Wholesale Operations Hub cards,
// which advertised "46 Active Wholesalers / Rs 28.4L" and "348 Resellers Active
// / Rs 14.4L / +18.4%" on an empty database.
$wholesalePartners = (int)$dtNum("SELECT COUNT(*) FROM `customers` WHERE `type` = 'wholesale' AND `status` = 'active'");
$resellerPartners  = (int)$dtNum("SELECT COUNT(*) FROM `customers` WHERE `type` = 'reseller' AND `status` = 'active'");
$wholesaleRevenue  = $dtNum("SELECT COALESCE(SUM(`total_amount`), 0) FROM `orders` WHERE `channel` = 'wholesale' AND {$notCancelled}");
$resellerRevenue   = $dtNum("SELECT COALESCE(SUM(`total_amount`), 0) FROM `orders` WHERE `channel` = 'reseller' AND {$notCancelled}");
$wholesaleOrders   = (int)$dtNum("SELECT COUNT(*) FROM `orders` WHERE `channel` = 'wholesale' AND {$notCancelled}");
$resellerOrders    = (int)$dtNum("SELECT COUNT(*) FROM `orders` WHERE `channel` = 'reseller' AND {$notCancelled}");

/** Compact Indian currency: 2850000 -> Rs 28.5L. */
$dtShortInr = function (float $v): string {
    if ($v >= 10000000) { return '₹' . round($v / 10000000, 2) . 'Cr'; }
    if ($v >= 100000)   { return '₹' . round($v / 100000, 1) . 'L'; }
    if ($v >= 1000)     { return '₹' . round($v / 1000, 1) . 'k'; }
    return '₹' . number_format($v);
};

$totalStockQty = array_sum(array_column($allProducts, 'stock_qty'));
$lowStockCount = count(array_filter($allProducts, fn($p) => (int)($p['stock_qty'] ?? 0) <= 10));
$inStockCount  = count(array_filter($allProducts, fn($p) => ($p['status'] ?? '') === 'in_stock'));
$readyStockPct = $totalProductsCount > 0 ? round(($inStockCount / $totalProductsCount) * 100, 1) : 0.0;

/**
 * ── Fulfilment pipeline ──
 *
 * One grouped query keyed by the five values the ENUM actually holds, instead of
 * eleven separate COUNTs - seven of which ('new', 'pending', 'confirmed',
 * 'packed', 'out_for_delivery', 'returned', 'refunded' as a fulfilment state)
 * matched no possible row and so were guaranteed to print 0 forever.
 *
 * A refund is a PAYMENT state here, not a fulfilment state, so it is counted
 * from `payment_status` where it really lives.
 */
$fulfilMap = [
    'unfulfilled' => 0,
    'processing'  => 0,
    'dispatched'  => 0,
    'delivered'   => 0,
    'cancelled'   => 0,
];
foreach ($dtRows("SELECT COALESCE(`fulfillment_status`, 'unfulfilled') AS s, COUNT(*) AS c FROM `orders` GROUP BY s") as $fRow) {
    $fKey = strtolower(trim((string)($fRow['s'] ?? '')));
    if (array_key_exists($fKey, $fulfilMap)) {
        $fulfilMap[$fKey] = (int)$fRow['c'];
    }
}
$pipeUnfulfilled = $fulfilMap['unfulfilled'];
$pipeProcessing  = $fulfilMap['processing'];
$pipeShipped     = $fulfilMap['dispatched'];
$pipeDelivered   = $fulfilMap['delivered'];
$pipeCancelled   = $fulfilMap['cancelled'];
$pipeRefunded    = (int)$dtNum("SELECT COUNT(*) FROM `orders` WHERE `payment_status` = 'refunded'");

$openOrdersCount = $pipeUnfulfilled + $pipeProcessing;
$fulfillmentRate = $liveOrdersCount > 0 ? round(($pipeDelivered / $liveOrdersCount) * 100, 1) : 0.0;
$dispatchRate    = $liveOrdersCount > 0 ? round((($pipeShipped + $pipeDelivered) / $liveOrdersCount) * 100, 1) : 0.0;

/**
 * ── Sales time series ──
 *
 * Returns a bucketed series for one of the 1W / 1M / 1Y range pills together
 * with the immediately preceding period of the same length, so the chart can
 * draw a real comparison instead of the two hardcoded fraction arrays that used
 * to live in admin.js.
 *
 * Empty buckets are filled with 0 so the axis stays continuous. Bucket keys are
 * built in PHP and matched against MySQL's DATE()/DATE_FORMAT() output; both run
 * on the same host here, so they agree on the calendar day.
 */
$dtSeries = function (string $range) use ($dtRows, $notCancelled): array {
    $isYear = ($range === '1Y');
    $n      = ($range === '1W') ? 7 : ($isYear ? 12 : 30);
    $span   = $n * 2;
    $expr   = $isYear ? "DATE_FORMAT(`created_at`, '%Y-%m')" : "DATE(`created_at`)";
    $floor  = $isYear ? "DATE_FORMAT(CURDATE(), '%Y-%m-01')" : "CURDATE()";
    $unit   = $isYear ? 'MONTH' : 'DAY';

    $map = [];
    foreach ($dtRows(
        "SELECT {$expr} AS k, COALESCE(SUM(`total_amount`), 0) AS v, COUNT(*) AS c
           FROM `orders`
          WHERE {$notCancelled}
            AND `created_at` >= ({$floor} - INTERVAL " . ($span - 1) . " {$unit})
          GROUP BY k"
    ) as $sRow) {
        $map[(string)$sRow['k']] = ['v' => (float)$sRow['v'], 'c' => (int)$sRow['c']];
    }
    $labels = $current = $previous = [];
    $total = 0.0;
    $count = 0;
    $prevTotal = 0.0;

    for ($i = $span - 1; $i >= 0; $i--) {
        $key = $isYear
            ? date('Y-m', strtotime("first day of -{$i} month"))
            : date('Y-m-d', strtotime("-{$i} day"));
        $val = $map[$key]['v'] ?? 0.0;

        if ($i >= $n) {
            // Older half: the comparison period.
            $previous[] = round($val, 2);
            $prevTotal += $val;
        } else {
            // Newer half: the period the pill actually selected.
            $labels[]  = $isYear ? date('M', strtotime($key . '-01')) : date('j', strtotime($key));
            $current[] = round($val, 2);
            $total    += $val;
            $count    += (int)($map[$key]['c'] ?? 0);
        }
    }

    return [
        'labels'   => $labels,
        'current'  => $current,
        'previous' => $previous,
        'total'    => round($total, 2),
        'count'    => $count,
        'peak'     => ($total > 0) ? (int)array_search(max($current), $current, true) : -1,
        'growth'   => $prevTotal > 0
            ? round((($total - $prevTotal) / $prevTotal) * 100, 1)
            : ($total > 0 ? 100.0 : 0.0),
        'hasData'  => ($total > 0 || $prevTotal > 0),
    ];
};

$salesSeries = [
    '1W' => $dtSeries('1W'),
    '1M' => $dtSeries('1M'),
    '1Y' => $dtSeries('1Y'),
];
$salesSeriesDefault = $salesSeries['1M'];

/**
 * ── Revenue Analytics: real 7-day channel split ──
 *
 * `orders.channel` is ENUM('retail','wholesale','reseller','whatsapp'). Wholesale
 * is the B2B line, everything else is B2C. This panel used to print a frozen
 * "1-7 Apr, 2026" caption above hardcoded totals of Rs 42,85,900 / 28.4L / 14.4L.
 */
$revLabels = [];
$revDateKeys = [];
$revB2B = [];
$revB2C = [];
for ($i = 6; $i >= 0; $i--) {
    $rKey = date('Y-m-d', strtotime("-{$i} day"));
    $revDateKeys[] = $rKey;
    $revLabels[]   = date('d', strtotime($rKey));
    $revB2B[$rKey] = 0.0;
    $revB2C[$rKey] = 0.0;
}
foreach ($dtRows(
    "SELECT DATE(`created_at`) AS d, `channel` AS ch, COALESCE(SUM(`total_amount`), 0) AS v
       FROM `orders`
      WHERE {$notCancelled} AND `created_at` >= (CURDATE() - INTERVAL 6 DAY)
      GROUP BY d, ch"
) as $rRow) {
    $rKey = (string)($rRow['d'] ?? '');
    if (!array_key_exists($rKey, $revB2B)) {
        continue;
    }
    if (strtolower((string)($rRow['ch'] ?? '')) === 'wholesale') {
        $revB2B[$rKey] += (float)$rRow['v'];
    } else {
        $revB2C[$rKey] += (float)$rRow['v'];
    }
}
$revB2BSeries = array_map(fn($k) => round($revB2B[$k], 2), $revDateKeys);
$revB2CSeries = array_map(fn($k) => round($revB2C[$k], 2), $revDateKeys);
$revB2BTotal  = array_sum($revB2BSeries);
$revB2CTotal  = array_sum($revB2CSeries);
$revWeekTotal = $revB2BTotal + $revB2CTotal;
$revPrevWeekTotal = $dtNum(
    "SELECT COALESCE(SUM(`total_amount`), 0) FROM `orders`
      WHERE {$notCancelled}
        AND `created_at` >= (CURDATE() - INTERVAL 13 DAY)
        AND `created_at` <  (CURDATE() - INTERVAL 6 DAY)"
);
$revGrowth = $revPrevWeekTotal > 0
    ? round((($revWeekTotal - $revPrevWeekTotal) / $revPrevWeekTotal) * 100, 1)
    : ($revWeekTotal > 0 ? 100.0 : 0.0);
$revRangeLabel = date('j M', strtotime('-6 day')) . ' - ' . date('j M, Y');

/**
 * ── Category Breakdown ──
 *
 * Sold value per category, joined order_items -> orders -> products. The four
 * pods on this panel were hardcoded (Sarees 48% / Rs 20,57,200 / "842 Lots
 * Active", plus three more), which is why they read identically on a catalogue of
 * zero products. When nothing has sold yet we fall back to catalogue share - live
 * products per category - and the panel says which of the two it is showing,
 * rather than inventing revenue.
 */
$catRows = $dtRows(
    "SELECT COALESCE(NULLIF(TRIM(p.`category_name`), ''), 'Uncategorised') AS name,
            COALESCE(SUM(oi.`total_price`), 0) AS revenue,
            COALESCE(SUM(oi.`quantity`), 0) AS units
       FROM `order_items` oi
       INNER JOIN `orders` o ON o.`id` = oi.`order_id`
       LEFT JOIN `products` p ON p.`id` = oi.`product_id`
      WHERE COALESCE(o.`fulfillment_status`, 'unfulfilled') <> 'cancelled'
      GROUP BY name
      HAVING revenue > 0
      ORDER BY revenue DESC
      LIMIT 6"
);
$catMode      = 'sales';
$catBreakdown = [];
$catTotal     = 0.0;
foreach ($catRows as $cRow) {
    $catTotal += (float)$cRow['revenue'];
}
if ($catTotal > 0) {
    foreach ($catRows as $cRow) {
        $catBreakdown[] = [
            'name'  => (string)$cRow['name'],
            'value' => round((float)$cRow['revenue'], 2),
            'units' => (int)$cRow['units'],
            'pct'   => round(((float)$cRow['revenue'] / $catTotal) * 100, 1),
        ];
    }
} else {
    // Nothing has sold yet, so show how the live catalogue is actually distributed.
    $catMode   = 'catalogue';
    $catCounts = [];
    foreach ($allProducts as $cP) {
        $cName = trim((string)($cP['category_name'] ?? '')) ?: 'Uncategorised';
        $catCounts[$cName] = ($catCounts[$cName] ?? 0) + 1;
    }
    arsort($catCounts);
    $catCounts = array_slice($catCounts, 0, 6, true);
    $catTotal  = (float)array_sum($catCounts);
    foreach ($catCounts as $cName => $cCount) {
        $catBreakdown[] = [
            'name'  => (string)$cName,
            'value' => 0.0,
            'units' => (int)$cCount,
            'pct'   => $catTotal > 0 ? round(($cCount / $catTotal) * 100, 1) : 0.0,
        ];
    }
}

/**
 * ── Fast Moving Catalog Lots ──
 *
 * Ranked by units actually sold. The bar percentage used to be a product's share
 * of total stock quantity - a warehouse figure - displayed under a heading about
 * movement, with a bare `25` as the fallback.
 */
$fastMovingRows = $dtRows(
    "SELECT COALESCE(NULLIF(TRIM(oi.`product_title`), ''), 'Untitled product') AS title,
            COALESCE(SUM(oi.`quantity`), 0) AS units,
            COALESCE(SUM(oi.`total_price`), 0) AS revenue
       FROM `order_items` oi
       INNER JOIN `orders` o ON o.`id` = oi.`order_id`
      WHERE COALESCE(o.`fulfillment_status`, 'unfulfilled') <> 'cancelled'
      GROUP BY title
      HAVING units > 0
      ORDER BY units DESC
      LIMIT 4"
);
$fastMovingPeak = 0;
foreach ($fastMovingRows as $fRow) {
    $fastMovingPeak = max($fastMovingPeak, (int)$fRow['units']);
}

/**
 * ── Recent Order Stream / Recent Wholesale Orders ──
 *
 * Both tables now read from `$recentOrdersList`. The stream used to be two
 * hardcoded <tr> rows (ORD-9842 Ananya Sharma, ORD-9841 Vardhman Textiles) that
 * showed up on every install regardless of the database; the wholesale table
 * listed every channel under a "Wholesale" heading.
 */
$orderItemSummary = [];
$recentOrderIds = array_values(array_filter(array_map(
    fn($o) => (int)($o['id'] ?? 0),
    $recentOrdersList
)));
if ($recentOrderIds) {
    $idList = implode(',', array_map('intval', $recentOrderIds));
    foreach ($dtRows(
        "SELECT `order_id`,
                COUNT(*) AS line_count,
                COALESCE(SUM(`quantity`), 0) AS units,
                MIN(COALESCE(NULLIF(TRIM(`product_title`), ''), 'Item')) AS first_title
           FROM `order_items`
          WHERE `order_id` IN ({$idList})
          GROUP BY `order_id`"
    ) as $iRow) {
        $orderItemSummary[(int)$iRow['order_id']] = [
            'lines' => (int)$iRow['line_count'],
            'units' => (int)$iRow['units'],
            'title' => (string)$iRow['first_title'],
        ];
    }
}
$wholesaleOrdersList = array_values(array_filter(
    $recentOrdersList,
    fn($o) => strtolower((string)($o['channel'] ?? '')) === 'wholesale'
));

// Everything the hand-drawn canvases in admin.js need, so they plot real rows
// instead of the fraction arrays that were baked into the script file.
$dashPayload = [
    'hasOrders'  => ($liveOrdersCount > 0),
    // renderAppCircularGauge() in admin.js drew a fixed 84.5% arc while the
    // label beside it printed the real stock figure, so the ring and the number
    // disagreed. It now fills to value/target.
    'gauge'      => [
        'value'  => $totalStockQty,
        'target' => max(500, $totalStockQty),
    ],
    'sales'      => $salesSeries,
    'revenue'    => [
        'labels'   => $revLabels,
        'b2b'      => $revB2BSeries,
        'b2c'      => $revB2CSeries,
        'b2bTotal' => round($revB2BTotal, 2),
        'b2cTotal' => round($revB2CTotal, 2),
        'total'    => round($revWeekTotal, 2),
        'growth'   => $revGrowth,
        'range'    => $revRangeLabel,
    ],
    'categories' => ['mode' => $catMode, 'items' => $catBreakdown],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Executive Admin Dashboard & CRM — DT Brand's Luxury Ethnic</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Admin CSS Stylesheet -->
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="adm-layout">

    <!-- ══ LEFT SIDEBAR NAVIGATION ══ -->
    <?php include_once __DIR__ . '/Includes/adminsidebar.php'; ?>

    <!-- ══ MAIN CONTENT WRAPPER ══ -->
    <div class="adm-main">

        <!-- ══ TOP HEADER ══ -->
        <?php include_once __DIR__ . '/Includes/adminheader.php'; ?>

        <!-- ══ WHOLESALER-STYLE DESKTOP SUBNAV QUICK TABS STRIP ══ -->
        <nav class="adm-subnav-strip" id="admSubnavStrip">
            <ul class="adm-subnav-pills">
                <li>
                    <button class="adm-subnav-item active" id="subnav-overview" onclick="switchAdmTab('overview')">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Dashboard</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-products" onclick="switchAdmTab('products')">
                        <svg viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span>Products</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-orders" onclick="switchAdmTab('orders')">
                        <svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        <span>Orders</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-whatsapp" onclick="switchAdmTab('whatsapp')">
                        <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>WhatsApp CRM</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-partners" onclick="switchAdmTab('partners')">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        <span>Partners</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-customers" onclick="switchAdmTab('customers')">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>Customers</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-inventory" onclick="switchAdmTab('inventory')">
                        <svg viewBox="0 0 24 24"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path></svg>
                        <span>Inventory</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-pricing" onclick="switchAdmTab('pricing')">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path></svg>
                        <span>Pricing</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-shipping" onclick="switchAdmTab('shipping')">
                        <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon></svg>
                        <span>Shipping</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-payments" onclick="switchAdmTab('payments')">
                        <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        <span>Payments</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-marketing" onclick="switchAdmTab('marketing')">
                        <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        <span>Marketing</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-reviews" onclick="switchAdmTab('reviews')">
                        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Reviews</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-reports" onclick="switchAdmTab('reports')">
                        <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <span>Reports</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-cms" onclick="switchAdmTab('cms')">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path></svg>
                        <span>CMS</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-settings" onclick="switchAdmTab('settings')">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>Settings</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-system" onclick="switchAdmTab('system')">
                        <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>System</span>
                    </button>
                </li>
            </ul>
            <div style="font-size:0.75rem; color:#8A681F; font-weight:700; white-space:nowrap; display:flex; align-items:center; gap:6px;">
                <span>★ Master Admin Console</span>
            </div>
        </nav>

        <!-- ══ TAB PANELS CONTENT CONTAINER ══ -->
        <main class="adm-content">

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 1: EXECUTIVE OVERVIEW DASHBOARD
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel active" id="tab-overview">
                <!-- ══════════════════════════════════════════════════════════════
                     👑 NEXT-LEVEL MODERN MOBILE APP DASHBOARD UI SUITE
                ══════════════════════════════════════════════════════════════ -->
                <div class="adm-mobile-dashboard-suite">
                    <!-- A. Modern App Hero Greeting Card -->
                    <div class="adm-app-hero-card">
                        <div class="adm-app-hero-top">
                            <div class="adm-app-user-meta">
                                <img src="/assets/images/profile.png" onerror="this.src='/assets/images/product1.png';" alt="Gautam Sethi" class="adm-app-avatar">
                                <div>
                                    <div class="adm-app-greeting">Hi Gautam Sethi,</div>
                                    <div class="adm-app-subtext">Executive Super Admin</div>
                                </div>
                            </div>
                            <div class="adm-app-status-chip">
                                <span class="adm-pulse-dot" style="background:#4ADE80; box-shadow:0 0 6px #4ADE80;"></span>
                                <span>WhatsApp CRM Live</span>
                            </div>
                        </div>

                        <div class="adm-app-balance-box">
                            <div>
                                <div class="adm-app-bal-lbl">Today's Wholesale Revenue</div>
                                <div class="adm-app-bal-val">₹<?= number_format($todaySales) ?> <small style="font-size:11px; color:#4ADE80; font-family:'Plus Jakarta Sans'; font-weight:700;"><?= $todaySales > 0 ? '↑ Live' : 'Live Sync' ?></small></div>
                            </div>
                            <a href="/admin/products/add.php" class="adm-app-action-btn">
                                <svg viewBox="0 0 24 24" width="12" height="12" stroke="#181512" stroke-width="2.8" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                <span>Product</span>
                            </a>
                        </div>
                    </div>

                    <!-- B. Circular Gauge Usage & Stock Target Widget -->
                    <div class="adm-app-gauge-card">
                        <div class="adm-app-gauge-head">
                            <div class="adm-app-gauge-title">Surat Ready Stock &amp; Dispatches</div>
                            <div class="adm-app-gauge-badge">Active Drop 2026</div>
                        </div>
                        <div class="adm-app-gauge-body">
                            <div class="adm-app-gauge-canvas-wrap">
                                <canvas id="admAppCircularGauge" width="110" height="110" style="width:110px; height:110px; display:block;"></canvas>
                                <div class="adm-app-gauge-text">
                                    <div class="adm-app-gauge-val"><?= number_format($totalStockQty) ?></div><div class="adm-app-gauge-sub">/ <?= number_format(max(500, $totalStockQty)) ?> Pcs</div>
                                </div>
                            </div>
                            <div class="adm-app-gauge-stats">
                                <div class="adm-app-stat-pod">
                                    <div class="adm-app-stat-icon" style="background:#FAF5E8; color:#8A681F;">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                                    </div>
                                    <div class="adm-app-stat-info">
                                        <span class="adm-app-stat-lbl">SURAT READY STOCK</span>
                                        <span class="adm-app-stat-val" style="color:#8A681F;"><?= number_format($totalStockQty) ?> Units (<?= $totalProductsCount ?> SKUs)</span>
                                    </div>
                                </div>
                                <div class="adm-app-stat-pod">
                                    <div class="adm-app-stat-icon" style="background:#DCFCE7; color:#15803D;">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                    </div>
                                    <div class="adm-app-stat-info">
                                        <span class="adm-app-stat-lbl">TODAY'S ORDERS</span>
                                        <span class="adm-app-stat-val" style="color:#15803D;"><?= number_format($liveOrdersToday) ?> Today</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- C. 2-Column Luxury Operations Streams (Like Popular Plan) -->
                    <div>
                        <div class="adm-app-section-head">
                            <span class="adm-app-section-title">Wholesale Operations Hub</span>
                            <a href="javascript:void(0)" onclick="switchAdmTab('products')" class="adm-app-section-link">See All ↗</a>
                        </div>
                        <div class="adm-app-stream-grid">
                            <a href="javascript:void(0)" onclick="switchAdmTab('reports')" class="adm-app-stream-card">
                                <div class="adm-app-stream-top">
                                    <div class="adm-app-stream-icon-pod" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                                    </div>
                                    <!-- Was a permanent "Tier 1" badge. -->
                                    <span style="font-size:9.5px; font-weight:700; color:#15803D; background:#DCFCE7; padding:2px 6px; border-radius:10px;"><?= number_format($wholesaleOrders) ?> order<?= $wholesaleOrders === 1 ? '' : 's' ?></span>
                                </div>
                                <div class="adm-app-stream-title">B2B Wholesale</div>
                                <?php /* Was a hardcoded "46 Active Wholesalers". */ ?>
                                <div class="adm-app-stream-sub"><?= number_format($wholesalePartners) ?> Active Wholesaler<?= $wholesalePartners === 1 ? '' : 's' ?></div>
                                <div class="adm-app-stream-bottom">
                                    <?php /* Was a hardcoded Rs 28.4L. */ ?>
                                    <span class="adm-app-stream-price"><?= $dtShortInr($wholesaleRevenue) ?></span>
                                    <span class="adm-app-stream-chevron">›</span>
                                </div>
                            </a>

                            <a href="javascript:void(0)" onclick="switchAdmTab('partners')" class="adm-app-stream-card">
                                <div class="adm-app-stream-top">
                                    <div class="adm-app-stream-icon-pod" style="background:#EFF6FF; color:#1D4ED8; border:1px solid #93C5FD;">
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                                    </div>
                                    <?php /* Was a hardcoded "+18.4%" growth pill. */ ?>
                                    <span style="font-size:9.5px; font-weight:700; color:#1D4ED8; background:#EFF6FF; padding:2px 6px; border-radius:10px;"><?= number_format($resellerOrders) ?> order<?= $resellerOrders === 1 ? '' : 's' ?></span>
                                </div>
                                <div class="adm-app-stream-title">Reseller Hub</div>
                                <?php /* Was a hardcoded "348 Resellers Active". */ ?>
                                <div class="adm-app-stream-sub"><?= number_format($resellerPartners) ?> Reseller<?= $resellerPartners === 1 ? '' : 's' ?> Active</div>
                                <div class="adm-app-stream-bottom">
                                    <?php /* Was a hardcoded Rs 14.4L. */ ?>
                                    <span class="adm-app-stream-price"><?= $dtShortInr($resellerRevenue) ?></span>
                                    <span class="adm-app-stream-chevron">›</span>
                                </div>
                            </a>

                            <a href="javascript:void(0)" onclick="switchAdmTab('orders')" class="adm-app-stream-card">
                                <div class="adm-app-stream-top">
                                    <div class="adm-app-stream-icon-pod" style="background:#FEF3C7; color:#B45309; border:1px solid #FCD34D;">
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                    </div>
                                    <span style="font-size:9.5px; font-weight:700; color:#B45309; background:#FEF3C7; padding:2px 6px; border-radius:10px;"><?= $totalProductsCount ?> Active SKUs</span>
                                </div>
                                <div class="adm-app-stream-title">Consignments</div>
                                <div class="adm-app-stream-sub">Surat Central Depot</div>
                                <div class="adm-app-stream-bottom">
                                    <span class="adm-app-stream-price"><?= number_format($totalStockQty) ?> Pcs</span>
                                    <span class="adm-app-stream-chevron">›</span>
                                </div>
                            </a>

                            <a href="javascript:void(0)" onclick="switchAdmTab('orders')" class="adm-app-stream-card">
                                <div class="adm-app-stream-top">
                                    <div class="adm-app-stream-icon-pod" style="background:#FEE2E2; color:#DC2626; border:1px solid #FCA5A5;">
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    </div>
                                    <span style="font-size:9.5px; font-weight:700; color:#DC2626; background:#FEE2E2; padding:2px 6px; border-radius:10px;">Pending</span>
                                </div>
                                <div class="adm-app-stream-title">Clearance Needed</div>
                                <div class="adm-app-stream-sub"><?= $pendingPayments > 0 ? ('₹' . number_format($pendingPayments) . ' Pending') : 'All Invoices Cleared' ?></div><div class="adm-app-stream-bottom"><span class="adm-app-stream-price">₹<?= number_format($pendingPayments) ?></span>
                                    <span class="adm-app-stream-chevron">›</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- D. Recent Activity Stream (List View) -->
                    <div>
                        <div class="adm-app-section-head">
                            <span class="adm-app-section-title">Recent Activity Stream</span>
                            <a href="javascript:void(0)" onclick="switchAdmTab('orders')" class="adm-app-section-link">View Orders ↗</a>
                        </div>
                        <?php
                            // All four rows here were hardcoded: "Banarasi Silk Zari Saree
                            // (50 Pcs) / KLN-SR-111 / Rs 14,500 Wholesale / Dispatched",
                            // "Kanjivaram Bridal Heritage (25 Pcs)", "Chanderi Cotton Daily
                            // Wear (100 Pcs)" and "Surat Depot Bulk Consignment #882". None
                            // of those SKUs or orders exists, and they rendered even with an
                            // empty database.
                            $actFeed = array_slice($recentOrdersList, 0, 4);
                            $actStyle = [
                                'unfulfilled' => ['#FEF3C7', '#B45309', 'Unfulfilled'],
                                'processing'  => ['#FAF5E8', '#8A681F', 'Processing'],
                                'dispatched'  => ['#EFF6FF', '#1D4ED8', 'Dispatched'],
                                'delivered'   => ['#DCFCE7', '#15803D', 'Delivered'],
                                'cancelled'   => ['#FEE2E2', '#DC2626', 'Cancelled'],
                            ];
                        ?>
                        <div class="adm-app-activity-list">
                            <?php if (empty($actFeed)): ?>
                            <div class="adm-app-activity-item" style="justify-content:center; color:#8A8378; font-weight:600; font-size:0.8rem; padding:18px 10px;">
                                No order activity yet.
                            </div>
                            <?php endif; ?>
                            <?php foreach ($actFeed as $act):
                                $actId    = (int)($act['id'] ?? 0);
                                $actFul   = strtolower(trim((string)($act['fulfillment_status'] ?? ''))) ?: 'unfulfilled';
                                [$actBg, $actFg, $actLabel] = $actStyle[$actFul] ?? ['#F5F2EA', '#645D54', ucfirst($actFul)];
                                $actItems = $orderItemSummary[$actId] ?? null;
                                $actTitle = $actItems !== null ? $actItems['title'] : (trim((string)($act['customer_name'] ?? '')) ?: 'Order');
                                $actUnits = $actItems !== null ? (int)$actItems['units'] : 0;
                                $actNum   = trim((string)($act['order_number'] ?? '')) ?: ('ORD-' . $actId);
                                $actChan  = ucfirst(strtolower(trim((string)($act['channel'] ?? ''))) ?: 'retail');
                            ?>
                            <a href="javascript:void(0)" onclick="switchAdmTab('orders')" class="adm-app-activity-item">
                                <div class="adm-app-act-left">
                                    <div class="adm-app-act-icon-pod" style="background:<?= $actBg ?>; color:<?= $actFg ?>;">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                    </div>
                                    <div class="adm-app-act-meta">
                                        <span class="adm-app-act-title"><?= htmlspecialchars($actTitle) ?><?= $actUnits > 0 ? ' (' . number_format($actUnits) . ' Pcs)' : '' ?></span>
                                        <span class="adm-app-act-sub"><?= htmlspecialchars($actNum) ?> &bull; ₹<?= number_format((float)($act['total_amount'] ?? 0)) ?> <?= htmlspecialchars($actChan) ?></span>
                                    </div>
                                </div>
                                <div class="adm-app-act-right">
                                    <span class="adm-app-act-badge" style="background:<?= $actBg ?>; color:<?= $actFg ?>;"><?= htmlspecialchars($actLabel) ?></span>
                                    <span style="color:#B8860B; font-weight:800; font-size:13px;">›</span>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- Page Head -->
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Executive Command Center</span>
                            <span class="adm-badge gold" style="font-size:0.68rem;">DT Brand's Live</span>
                        </h1>
                        <p class="adm-page-subtitle">Real-time overview of Wholesale B2B, Reseller Margins, B2C Shop, and WhatsApp CRM pipeline.</p>
                    </div>
                    <div class="adm-page-actions">
                        <button class="adm-btn-secondary" onclick="window.exportTableToCSV('orders')">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export Sales CSV</span>
                        </button>
                        <button class="adm-btn-primary" onclick="openAddProductModal()">
                            <svg viewBox="0 0 24 24" width="13" height="13" stroke="#181512" stroke-width="2.8" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Add Product</span>
                        </button>
                    </div>
                </div>

                <!-- ════ LIVE BUSINESS STATUS TICKER ════ -->
                <section class="adm-live-ticker-strip">
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon" style="background:#DCFCE7; color:#15803D; border:1px solid #86EFAC;">
                            <span class="adm-pulse-dot" style="background:#16A34A;"></span>
                        </div>
                        <div>
                            <?php /*
                                Was a hardcoded "1" labelled "Live Users Online", which
                                initLiveTickers() in admin.js then replaced every 4 seconds with a
                                random walk floored at 90 - a fake visitor counter. Nothing here
                                tracks live sessions, so this tile now reports the orders genuinely
                                waiting on the team: unfulfilled + processing.
                            */ ?>
                            <div class="adm-live-ticker-val"><?php echo number_format($openOrdersCount); ?></div>
                            <div class="adm-live-ticker-lbl">Awaiting Action</div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon" style="background:#EFF6FF; color:#1D4ED8; border:1px solid #93C5FD;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        </div>
                        <div>
                            <!-- Was $totalOrdersCount: every order ever placed, under the label "Today". -->
                            <div class="adm-live-ticker-val"><?php echo number_format($liveOrdersToday); ?></div>
                            <div class="adm-live-ticker-lbl">Orders Today</div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><path d="M16 8h4l3 3v5h-7z"></path><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </div>
                        <div>
                            <!-- Was $activeCheckouts, a variable that was declared and then never assigned. -->
                            <div class="adm-live-ticker-val"><?php echo number_format($pipeShipped); ?></div><div class="adm-live-ticker-lbl">In Transit</div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon" style="background:#FEF3C7; color:#B45309; border:1px solid #FCD34D;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                        <div>
                            <div class="adm-live-ticker-val">₹<?php echo number_format($pendingPayments); ?></div>
                            <div class="adm-live-ticker-lbl">Pending Payments<?php echo $pendingPayCount > 0 ? ' (' . number_format($pendingPayCount) . ')' : ''; ?></div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon" style="background:#FAF8F4; color:#5A5348; border:1px solid #E2DFD7;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </div>
                        <div>
                            <!-- Was a literal 0 labelled "Active Cart Sessions"; no cart table exists to count. -->
                            <div class="adm-live-ticker-val">₹<?php echo number_format($todaySales); ?></div><div class="adm-live-ticker-lbl">Sale Today</div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon" style="background:#F3E8FF; color:#7E22CE; border:1px solid #D8B4FE;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                        </div>
                        <div>
                            <!-- Was +$totalCustomersCount: the entire customer base shown as today's signups. -->
                            <div class="adm-live-ticker-val">+<?php echo number_format($newCustomersToday); ?></div>
                            <div class="adm-live-ticker-lbl">New Today</div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon" style="background:#FEE2E2; color:#DC2626; border:1px solid #FCA5A5;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        </div>
                        <div>
                            <div class="adm-live-ticker-val"><?= number_format($lowStockCount) ?> Items</div><div class="adm-live-ticker-lbl">Stock Alert</div>
                        </div>
                    </div>
                </section>

                <!-- ══════════════════════════════════════════════════════════════
                     👑 DESKTOP REFERENCE DASHBOARD UI SUITE (EXACT REFERENCE MATCH)
                ══════════════════════════════════════════════════════════════ -->
                <div class="adm-desktop-ref-suite">
                    <!-- 1. 5-Card Top Hero Metric Row -->
                    <div class="adm-ref-kpi-strip">
                        <!-- Card 1: Total Orders -->
                        <div class="adm-ref-kpi-card" onclick="switchAdmTab('orders')">
                            <div class="adm-ref-kpi-top">
                                <span class="adm-ref-kpi-lbl">Total Orders</span>
                                <svg viewBox="0 0 54 22" width="54" height="22" fill="none">
                                    <path d="M 2 18 C 12 12, 22 20, 34 8 C 42 2, 48 10, 52 4" stroke="#8A681F" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="adm-ref-kpi-val"><?php echo number_format($totalOrdersCount); ?></div>
                            <div class="adm-ref-kpi-sub">Total verified orders</div>
                        </div>

                        <!-- Card 2: Total Sale (Dark Master Obsidian & Gold Card) -->
                        <div class="adm-ref-kpi-card dark-card" onclick="switchAdmTab('reports')">
                            <div class="adm-ref-kpi-top">
                                <span class="adm-ref-kpi-lbl">Total Sale</span>
                                <svg viewBox="0 0 54 22" width="54" height="22" fill="none">
                                    <path d="M 2 16 C 14 6, 26 20, 38 8 C 44 4, 48 8, 52 2" stroke="#D4AF37" stroke-width="2.4" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="adm-ref-kpi-val">₹<?php echo number_format($totalSalesAmount); ?></div>
                            <div class="adm-ref-kpi-sub">Real database orders</div>
                        </div>

                        <!-- Card 3: Net Revenue (goods value billed, excluding GST and shipping) -->
                        <div class="adm-ref-kpi-card" onclick="switchAdmTab('reports')">
                            <div class="adm-ref-kpi-top">
                                <span class="adm-ref-kpi-lbl">Net Revenue</span>
                                <svg viewBox="0 0 54 22" width="54" height="22" fill="none">
                                    <path d="M 2 18 C 14 10, 24 16, 36 6 C 42 2, 48 8, 52 4" stroke="#15803D" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="adm-ref-kpi-val">₹<?php echo number_format($totalRevenueAmount); ?></div>
                            <div class="adm-ref-kpi-sub">Goods value billed, ex-GST<?php echo $gstCollected > 0 ? ' &middot; ₹' . number_format($gstCollected) . ' GST' : ''; ?></div>
                        </div>

                        <!-- Card 4: Total Products -->
                        <div class="adm-ref-kpi-card" onclick="switchAdmTab('products')">
                            <div class="adm-ref-kpi-top">
                                <span class="adm-ref-kpi-lbl">Total Products</span>
                                <span class="adm-ref-pill purple">Live</span>
                            </div>
                            <div class="adm-ref-kpi-val"><?php echo number_format($totalProductsCount); ?></div>
                            <div class="adm-ref-kpi-sub">Available active SKUs</div>
                        </div>

                        <!-- Card 5: Total Categories -->
                        <div class="adm-ref-kpi-card" onclick="switchAdmTab('catalogue')">
                            <div class="adm-ref-kpi-top">
                                <span class="adm-ref-kpi-lbl">Total categories</span>
                                <span class="adm-ref-pill rose">Active</span>
                            </div>
                            <div class="adm-ref-kpi-val"><?php echo number_format($totalCategoriesCount); ?></div>
                            <div class="adm-ref-kpi-sub">Luxury categories</div>
                        </div>
                    </div>

                    <!-- 2. Master 2-Column Dashboard Layout -->
                    <div class="adm-ref-main-grid">
                        <!-- Left Column: Sales Chart + Recent Orders Table -->
                        <div class="adm-ref-left-col">
                            <!-- A. Sales Overview Chart Card -->
                            <div class="adm-ref-card">
                                <div class="adm-ref-card-head">
                                    <div>
                                        <h3 class="adm-ref-card-title">Sales Analytics</h3>
                                        <div id="admRefRangeCaption" style="font-size:0.72rem; color:#8A8378; font-weight:600; margin-top:2px;">Last 30 days &middot; <?php echo number_format($salesSeriesDefault['count']); ?> order<?php echo (int)$salesSeriesDefault['count'] === 1 ? '' : 's'; ?></div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <div class="adm-ref-time-pills">
                                            <button type="button" class="adm-ref-time-pill" onclick="switchAdmRefTimeRange('1W', this)">1W</button>
                                            <button type="button" class="adm-ref-time-pill active" onclick="switchAdmRefTimeRange('1M', this)">1M</button>
                                            <button type="button" class="adm-ref-time-pill" onclick="switchAdmRefTimeRange('1Y', this)">1Y</button>
                                        </div>
                                        <!--
                                            The two date-stepper buttons that used to sit here carried no
                                            onclick at all - clicking them did nothing. Replaced with the
                                            period the chart is genuinely plotting, which the range pills
                                            keep in sync.
                                        -->
                                        <div class="adm-ref-date-picker"><span id="admRefPeriodLabel"><?php echo date('j M', strtotime('-29 day')) . ' – ' . date('j M Y'); ?></span></div>
                                    </div>
                                </div>

                                <div class="adm-ref-sales-highlight">
                                    <div class="adm-ref-sales-amt">₹<?php echo number_format($salesSeriesDefault['total']); ?></div><div class="adm-ref-sales-growth"><?php
                                        if (!$salesSeriesDefault['hasData']) {
                                            echo 'No sales recorded in the last 30 days yet';
                                        } else {
                                            $salesGrowthVal = (float)$salesSeriesDefault['growth'];
                                            echo ($salesGrowthVal >= 0 ? '&#8599; +' : '&#8600; ') . number_format($salesGrowthVal, 1)
                                               . '% vs the previous 30 days &middot; ' . number_format($salesSeriesDefault['count']) . ' orders';
                                        }
                                    ?></div>
                                </div>

                                <div class="adm-ref-sales-chart-wrap">
                                    <canvas id="admRefSalesChart"></canvas>
                                </div>

                                <div class="adm-ref-legend-row">
                                    <div class="adm-ref-leg-item">
                                        <span class="adm-ref-leg-dot" style="background:#CBD5E1;"></span>
                                        <span id="admRefLegPrev">Previous 30 days</span>
                                    </div>
                                    <div class="adm-ref-leg-item">
                                        <span class="adm-ref-leg-dot" style="background:#D4AF37;"></span>
                                        <span id="admRefLegCur" style="color:#8A681F; font-weight:700;">Last 30 days</span>
                                    </div>
                                </div>
                            </div>

                            <!-- B. Recent Orders Table Card (World-Class Luxury Table) -->
                            <?php
                                // The heading read "Recent Wholesale Orders" while the loop below
                                // iterated every channel, so retail and WhatsApp orders showed up
                                // under a B2B title. Show the wholesale feed when one exists,
                                // otherwise show the real recent-order feed and label it honestly.
                                $ordFeedIsWholesale = !empty($wholesaleOrdersList);
                                $ordFeed = array_slice($ordFeedIsWholesale ? $wholesaleOrdersList : $recentOrdersList, 0, 6);
                            ?>
                            <div class="adm-ref-card" style="padding: 18px 22px;">
                                <div class="adm-ref-card-head" style="margin-bottom:14px;">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <div style="width:26px; height:26px; border-radius:7px; background:linear-gradient(135deg, #FAF5E8, #F3E8C8); border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.3">
                                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                            </svg>
                                        </div>
                                        <h3 class="adm-ref-card-title"><?php echo $ordFeedIsWholesale ? 'Recent Wholesale Orders' : 'Recent Orders (All Channels)'; ?></h3>
                                        <?php if (!empty($ordFeed)): ?>
                                        <span class="adm-ref-pill emerald" style="font-size:0.65rem; padding:2px 7px;">Live Feed</span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="javascript:void(0)" onclick="switchAdmTab('orders')" class="adm-ref-view-ord-btn" style="font-size:0.75rem; padding:5px 12px;">View All Orders (<?php echo number_format($totalOrdersCount); ?>) ↗</a>
                                </div>
                                <div class="adm-ref-table-wrap">
                                    <table class="adm-ref-table">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Date &amp; Time</th>
                                                <th>Customer &amp; Channel</th>
                                                <th>Payment</th>
                                                <th>Fulfillment Status</th>
                                                <th style="text-align:right;">Order Total</th>
                                                <th style="text-align:right;">Quick Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($ordFeed)): ?>
                                            <tr>
                                                <td colspan="7" style="text-align:center; padding:26px 10px; color:#8A8378; font-weight:600; font-size:0.82rem;">
                                                    No orders in the database yet. The first real checkout will appear here.
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php foreach ($ordFeed as $ord):
                                                $ordNum   = $ord['order_number'] ?? ('ORD-' . ($ord['id'] ?? '0'));
                                                $custName = trim((string)($ord['customer_name'] ?? '')) ?: 'Direct customer';
                                                // No phone fallback here any more. The old line substituted the
                                                // shop's own WhatsApp number when a customer had none, so
                                                // "message the customer" opened a chat with the shop itself.
                                                $custPhone = preg_replace('/[^0-9]/', '', (string)($ord['customer_phone'] ?? ''));
                                                $channel   = strtolower(trim((string)($ord['channel'] ?? ''))) ?: 'retail';
                                                $totalAmt  = (float)($ord['total_amount'] ?? 0);
                                                $payStatus = strtolower(trim((string)($ord['payment_status'] ?? ''))) ?: 'pending';
                                                // Defaulted to 'confirmed', a value this ENUM does not declare.
                                                $fulStatus = strtolower(trim((string)($ord['fulfillment_status'] ?? ''))) ?: 'unfulfilled';
                                                $dateStr   = !empty($ord['created_at']) ? date('M d • H:i', strtotime($ord['created_at'])) : '—';
                                                $itemInfo  = $orderItemSummary[(int)($ord['id'] ?? 0)] ?? null;

                                                $payPillMap = [
                                                    'paid'     => ['emerald', '✓ Paid'],
                                                    'pending'  => ['purple',  '● Awaiting payment'],
                                                    'credit'   => ['rose',    '● On credit'],
                                                    'refunded' => ['danger',  '↩ Refunded'],
                                                ];
                                                [$payPillClass, $payPillText] = $payPillMap[$payStatus] ?? ['purple', ucfirst($payStatus)];

                                                $fulPillMap = [
                                                    'unfulfilled' => ['purple',  '● Unfulfilled'],
                                                    'processing'  => ['purple',  '● Processing'],
                                                    'dispatched'  => ['rose',    '● Dispatched'],
                                                    'delivered'   => ['emerald', '✓ Delivered'],
                                                    'cancelled'   => ['danger',  '✕ Cancelled'],
                                                ];
                                                [$fulPillClass, $fulPillText] = $fulPillMap[$fulStatus] ?? ['purple', ucfirst($fulStatus)];

                                                $initials = strtoupper(substr($custName, 0, 2));
                                            ?>
                                            <tr>
                                                <td><span class="adm-ref-ord-badge">#<?= htmlspecialchars($ordNum) ?></span></td>
                                                <td style="color:#645D54; font-weight:600; font-size:12px;"><?= $dateStr ?></td>
                                                <td>
                                                    <div class="adm-ref-cust-cell">
                                                        <div class="adm-ref-cust-avatar" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;"><?= $initials ?></div>
                                                        <div>
                                                            <div class="adm-ref-cust-name"><?= htmlspecialchars($custName) ?></div>
                                                            <div class="adm-ref-cust-depot"><?= htmlspecialchars(ucfirst($channel)) ?><?= $custPhone !== '' ? ' &middot; +' . htmlspecialchars($custPhone) : '' ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="adm-ref-pill <?= $payPillClass ?>"><?= $payPillText ?></span></td>
                                                <td><span class="adm-ref-pill <?= $fulPillClass ?>"><?= $fulPillText ?></span></td>
                                                <td style="text-align:right;">
                                                    <div style="font-weight:800; color:#181512; font-size:0.92rem; font-family:'Plus Jakarta Sans', sans-serif;">₹<?= number_format($totalAmt) ?></div>
                                                    <!-- Was the filler line "Authentic Handloom" on every single row. -->
                                                    <div style="font-size:0.65rem; color:#78716C; font-weight:600;"><?php
                                                        if ($itemInfo !== null) {
                                                            echo number_format($itemInfo['units']) . ' pc' . ($itemInfo['units'] === 1 ? '' : 's')
                                                               . ' &middot; ' . number_format($itemInfo['lines']) . ' item' . ($itemInfo['lines'] === 1 ? '' : 's');
                                                        } else {
                                                            echo 'No line items recorded';
                                                        }
                                                    ?></div>
                                                </td>
                                                <td style="text-align:right;">
                                                    <div class="adm-ref-actions-cell">
                                                        <?php if ($custPhone !== ''): ?>
                                                        <a href="https://wa.me/<?= $custPhone ?>?text=Hello%20<?= urlencode($custName) ?>%2C%20regarding%20Order%20<?= urlencode($ordNum) ?>" target="_blank" rel="noopener" class="adm-ref-wa-btn" title="Message this customer on WhatsApp">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                                            </svg>
                                                        </a>
                                                        <?php endif; ?>
                                                        <a href="/admin/orders/view.php?id=<?= (int)($ord['id'] ?? 0) ?>" class="adm-ref-view-ord-btn">View ↗</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Store Performance + Fast Moving Lots -->
                        <div class="adm-ref-right-col">
                            <!-- 1. Store Performance Speedometer Gauge Card -->
                            <?php
                                /*
                                 * The gauge used to be drawn with stroke-dasharray="282.74"
                                 * stroke-dashoffset="14.4" and a head node pinned at cx="204"
                                 * cy="98" - a hardcoded 94.9% that never moved, on a store with
                                 * no orders. It now plots dispatch progress: how many live orders
                                 * have actually left the warehouse.
                                 *
                                 * 282.74 is the arc length of the 180-degree path below (pi * r,
                                 * r = 90), so the offset is the unfilled remainder. The head node
                                 * is the point on that arc at the same fraction, centre (120,125).
                                 */
                                $perfPct    = max(0.0, min(100.0, (float)$dispatchRate));
                                $perfFrac   = $perfPct / 100;
                                $perfOffset = round(282.74 * (1 - $perfFrac), 2);
                                $perfAngle  = M_PI * (1 - $perfFrac);
                                $perfHeadX  = round(120 + 90 * cos($perfAngle), 1);
                                $perfHeadY  = round(125 - 90 * sin($perfAngle), 1);
                            ?>
                            <div class="adm-ref-perf-card">
                                <div class="adm-ref-card-head" style="width:100%; margin-bottom:2px;">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <div style="width:26px; height:26px; border-radius:7px; background:linear-gradient(135deg, #FAF5E8, #F3E8C8); border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                                <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                                <path d="M4 22h16"></path>
                                                <path d="M10 14.66V17c0 .55-.45 1-1 1H7.5"></path>
                                                <path d="M14 14.66V17c0 .55.45 1 1 1h1.5"></path>
                                                <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="adm-ref-card-title">Store Performance</h3>
                                    </div>
                                    <!-- Was a permanent "Top 1% Tier" badge. -->
                                    <span class="adm-ref-pill <?php echo $liveOrdersCount > 0 ? 'emerald' : 'purple'; ?>" style="font-size:0.65rem; font-weight:800; padding:3px 9px;">
                                        <span style="width:6px; height:6px; border-radius:50%; background:<?php echo $liveOrdersCount > 0 ? '#15803D' : '#7E22CE'; ?>; display:inline-block;"></span>
                                        <?php echo $liveOrdersCount > 0 ? number_format($liveOrdersCount) . ' live order' . ($liveOrdersCount === 1 ? '' : 's') : 'No orders yet'; ?>
                                    </span>
                                </div>
                                
                                <!-- World-Class Radial Speedometer Dial -->
                                <div class="adm-ref-gauge-wrap">
                                    <svg viewBox="0 0 240 140" width="200" height="120" style="overflow:visible;">
                                        <defs>
                                            <linearGradient id="gaugeWorldGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                                <stop offset="0%" stop-color="#EF4444" />
                                                <stop offset="25%" stop-color="#F59E0B" />
                                                <stop offset="65%" stop-color="#D4AF37" />
                                                <stop offset="100%" stop-color="#10B981" />
                                            </linearGradient>
                                            <linearGradient id="gaugeTrackGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                                <stop offset="0%" stop-color="#F5F2EA" />
                                                <stop offset="100%" stop-color="#EBE5D8" />
                                            </linearGradient>
                                            <filter id="gaugeGlow" x="-20%" y="-20%" width="140%" height="140%">
                                                <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#D4AF37" flood-opacity="0.35" />
                                            </filter>
                                        </defs>

                                        <!-- Background track arc (180 deg) -->
                                        <path d="M 30 125 A 90 90 0 0 1 210 125" fill="none" stroke="url(#gaugeTrackGrad)" stroke-width="14" stroke-linecap="round" />
                                        
                                        <!-- Subtle graduation tick marks -->
                                        <circle cx="30" cy="125" r="2.5" fill="#CBD5E1" />
                                        <circle cx="56" cy="61" r="2.5" fill="#CBD5E1" />
                                        <circle cx="120" cy="35" r="2.5" fill="#CBD5E1" />
                                        <circle cx="184" cy="61" r="2.5" fill="#CBD5E1" />
                                        <circle cx="210" cy="125" r="2.5" fill="#CBD5E1" />

                                        <!-- Active progress arc: filled to the real dispatch percentage. -->
                                        <path d="M 30 125 A 90 90 0 0 1 210 125" fill="none" stroke="url(#gaugeWorldGrad)" stroke-width="14" stroke-linecap="round" stroke-dasharray="282.74" stroke-dashoffset="<?php echo $perfOffset; ?>" filter="url(#gaugeGlow)" />

                                        <?php if ($perfPct > 0): ?>
                                        <!-- Head node, positioned on the arc at the same fraction. -->
                                        <circle cx="<?php echo $perfHeadX; ?>" cy="<?php echo $perfHeadY; ?>" r="6" fill="#10B981" stroke="#FFFFFF" stroke-width="2" />
                                        <circle cx="<?php echo $perfHeadX; ?>" cy="<?php echo $perfHeadY; ?>" r="9.5" fill="none" stroke="#10B981" stroke-width="1.5" opacity="0.6" />
                                        <?php endif; ?>
                                    </svg>

                                    <div class="adm-ref-gauge-score">
                                        <span class="adm-ref-gauge-score-lbl">Dispatch Rate</span>
                                        <div class="adm-ref-gauge-score-val"><?php echo number_format($perfPct, 1); ?><span style="font-size:1.25rem; color:#8A681F; font-weight:800;">%</span></div>
                                        <div class="adm-ref-gauge-tier">
                                            <?php if ($liveOrdersCount > 0): ?>
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <?php echo number_format($pipeShipped + $pipeDelivered) . ' of ' . number_format($liveOrdersCount) . ' shipped'; ?>
                                            <?php else: ?>
                                            Awaiting first order
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    // Was: "Surat Wholesale fulfillment rate is 12% faster than last
                                    // week with 99.4% accuracy" - two invented figures, with no
                                    // week-over-week comparison and no accuracy metric anywhere in
                                    // the schema to derive them from.
                                ?>
                                <p class="adm-ref-perf-text"><?php
                                    if ($liveOrdersCount === 0) {
                                        echo 'No orders recorded yet, so there is nothing to measure. This gauge fills as orders are dispatched and delivered.';
                                    } else {
                                        echo '<strong style="color:#15803D;">' . number_format($pipeDelivered) . ' delivered</strong>, '
                                           . number_format($pipeShipped) . ' in transit, '
                                           . '<strong style="color:#8A681F;">' . number_format($openOrdersCount) . ' still open</strong>'
                                           . ($pipeCancelled > 0 ? ' &middot; ' . number_format($pipeCancelled) . ' cancelled' : '') . '.';
                                    }
                                ?></p>

                                <button type="button" class="adm-ref-view-btn" onclick="switchAdmTab('reports')">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#181512" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="20" x2="18" y2="10"></line>
                                        <line x1="12" y1="20" x2="12" y2="4"></line>
                                        <line x1="6" y1="20" x2="6" y2="14"></line>
                                    </svg>
                                    View Full Performance Analytics ↗
                                </button>

                                <div class="adm-ref-perf-stats-grid">
                                    <div class="adm-ref-stat-box" style="background:#F0FDF4; border:1px solid #BBF7D0;">
                                        <span class="adm-ref-stat-box-lbl" style="color:#15803D;">Delivered</span>
                                        <!-- Was $totalOrdersCount: every order ever placed, labelled "Completed". -->
                                        <span class="adm-ref-stat-box-val" style="color:#15803D;"><?php echo number_format($pipeDelivered); ?></span>
                                        <span style="font-size:0.62rem; color:#166534; font-weight:600;"><?php echo number_format($fulfillmentRate, 1); ?>% of live orders</span>
                                    </div>
                                    <div class="adm-ref-stat-box" style="background:#FAF5E8; border:1px solid #D4AF37;">
                                        <span class="adm-ref-stat-box-lbl" style="color:#8A681F;">In Transit</span>
                                        <?php /* Was a hardcoded 100% "On-Time Rate"; no delivery timestamps exist to compute one. */ ?>
                                        <span class="adm-ref-stat-box-val" style="color:#8A681F;"><?php echo number_format($pipeShipped); ?></span>
                                        <span style="font-size:0.62rem; color:#705114; font-weight:600;">Dispatched, en route</span>
                                    </div>
                                    <div class="adm-ref-stat-box" style="background:#FEF2F2; border:1px solid #FECACA;">
                                        <span class="adm-ref-stat-box-lbl" style="color:#DC2626;">Open</span>
                                        <!-- Was number_format($pendingPayments > 0 ? 1 : 0): a fake count of exactly 1. -->
                                        <span class="adm-ref-stat-box-val" style="color:#DC2626;"><?php echo number_format($openOrdersCount); ?></span>
                                        <span style="font-size:0.62rem; color:#991B1B; font-weight:600;">Unfulfilled + processing</span>
                                    </div>
                                </div>

                                <button type="button" class="adm-ref-prev-btn" onclick="switchAdmTab('reports')">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    Weekly Audit Log & History
                                </button>
                            </div>

                            <!-- 2. Fast Moving Catalog Lots & Stock Health Card -->
                            <div class="adm-ref-card" style="padding: 18px 20px;">
                                <div class="adm-ref-card-head" style="margin-bottom:12px;">
                                    <h3 class="adm-ref-card-title"><?php echo !empty($fastMovingRows) ? 'Fast Moving Catalog Lots' : 'Catalogue Stock Levels'; ?></h3>
                                    <a href="javascript:void(0)" onclick="switchAdmTab('products')" style="font-size:0.75rem; color:#8A681F; font-weight:800; text-decoration:none;">Stock Health ↗</a>
                                </div>

                                <div class="adm-ref-cat-list">
                                    <?php
                                    $dotColors = ['#8A681F', '#15803D', '#7E22CE', '#D97706'];
                                    $gradColors = ['linear-gradient(90deg, #8A681F, #D4AF37)', 'linear-gradient(90deg, #15803D, #22C55E)', 'linear-gradient(90deg, #7E22CE, #A855F7)', 'linear-gradient(90deg, #D97706, #F59E0B)'];
                                    /*
                                     * Ranked by units genuinely sold, from order_items. The old
                                     * version walked the first four products in the catalogue and
                                     * drew each one's share of TOTAL STOCK QUANTITY - a warehouse
                                     * number - under a heading about movement, falling back to a
                                     * bare 25. Until something sells there is no movement to rank,
                                     * so we show stock levels and retitle the card to say so.
                                     */
                                    if (!empty($fastMovingRows)):
                                        foreach ($fastMovingRows as $idx => $fmRow):
                                            $fTitle = (string)$fmRow['title'];
                                            $fUnits = (int)$fmRow['units'];
                                            $fRev   = (float)$fmRow['revenue'];
                                            $pct    = $fastMovingPeak > 0 ? max(4, (int)round(($fUnits / $fastMovingPeak) * 100)) : 0;
                                    ?>
                                    <div class="adm-ref-cat-item">
                                        <div class="adm-ref-cat-top">
                                            <span class="adm-ref-cat-name">
                                                <span class="adm-ref-leg-dot" style="background:<?= $dotColors[$idx % 4] ?>;"></span>
                                                <?= htmlspecialchars($fTitle) ?>
                                            </span>
                                            <span class="adm-ref-cat-val"><?= number_format($fUnits) ?> sold • ₹<?= number_format($fRev) ?></span>
                                        </div>
                                        <div class="adm-ref-progress-track">
                                            <div class="adm-ref-progress-bar" style="width: <?= $pct ?>%; background: <?= $gradColors[$idx % 4] ?>;"></div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php
                                    elseif (!empty($allProducts)):
                                        $stockSorted = $allProducts;
                                        usort($stockSorted, fn($a, $b) => (int)($b['stock_qty'] ?? 0) <=> (int)($a['stock_qty'] ?? 0));
                                        $stockPeak = max(1, (int)($stockSorted[0]['stock_qty'] ?? 0));
                                        foreach (array_slice($stockSorted, 0, 4) as $idx => $fp):
                                            $fTitle = trim((string)($fp['title'] ?? '')) ?: 'Untitled product';
                                            $fStock = (int)($fp['stock_qty'] ?? 0);
                                            $pct    = (int)round(($fStock / $stockPeak) * 100);
                                    ?>
                                    <div class="adm-ref-cat-item">
                                        <div class="adm-ref-cat-top">
                                            <span class="adm-ref-cat-name">
                                                <span class="adm-ref-leg-dot" style="background:<?= $dotColors[$idx % 4] ?>;"></span>
                                                <?= htmlspecialchars($fTitle) ?>
                                            </span>
                                            <span class="adm-ref-cat-val"><?= number_format($fStock) ?> pcs in stock</span>
                                        </div>
                                        <div class="adm-ref-progress-track">
                                            <div class="adm-ref-progress-bar" style="width: <?= $pct ?>%; background: <?= $gradColors[$idx % 4] ?>;"></div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <p style="font-size:0.7rem; color:#8A8378; font-weight:600; margin:6px 0 0;">Nothing has sold yet, so these are current stock levels, not sales velocity.</p>
                                    <?php else: ?>
                                    <p style="font-size:0.78rem; color:#8A8378; font-weight:600; text-align:center; padding:18px 6px; margin:0;">No products in the catalogue yet.</p>
                                    <?php endif; ?>
                                </div>

                                <div class="adm-ref-depot-banner">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <!-- Was "Surat Central Depot: 96.4% Ready Stock", printed even with zero products. -->
                                        <span style="font-size:0.72rem; color:#15803D; font-weight:700;"><?php
                                            echo $totalProductsCount > 0
                                                ? 'Ready stock: ' . number_format($readyStockPct, 1) . '% (' . number_format($inStockCount) . ' of ' . number_format($totalProductsCount) . ' SKUs in stock)'
                                                : 'No SKUs in the catalogue yet';
                                        ?></span>
                                    </div>
                                    <span class="adm-ref-pill <?php echo $lowStockCount > 0 ? 'danger' : 'emerald'; ?>" style="font-size:0.64rem; padding:2px 7px;"><?php echo $lowStockCount > 0 ? number_format($lowStockCount) . ' low' : 'All stocked'; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ════ ORDER STATUS PIPELINE FLOW ════ -->
                <div class="adm-card" style="margin-bottom:24px;">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title">
                            <span>📦 Order Status Fulfillment Pipeline</span>
                        </h3>
                        <button type="button" class="adm-btn-secondary adm-btn-sm" onclick="switchAdmTab('orders')">All Orders ↗</button>
                    </div>
                    <?php
                        /*
                         * Rebuilt to the five values `orders.fulfillment_status` actually
                         * declares, plus refunds read from `payment_status`, where a refund
                         * really lives. The previous board had eleven steps - New, Pending,
                         * Confirmed, Processing, Packed, Shipped, Out for Delivery,
                         * Delivered, Cancelled, Returned, Refunded - against a five-value
                         * ENUM. Seven of them were structurally incapable of ever showing
                         * anything but 0, and 'unfulfilled', the state every new order
                         * starts in, was not on the board at all.
                         */
                        $pipelineSteps = [
                            ['Unfulfilled', $pipeUnfulfilled, 'Awaiting action',  ''],
                            ['Processing',  $pipeProcessing,  'Being picked',     ''],
                            ['Dispatched',  $pipeShipped,     'In transit',       ''],
                            ['Delivered',   $pipeDelivered,   'Completed',        'var(--adm-emerald)'],
                            ['Cancelled',   $pipeCancelled,   'Cancelled',        'var(--adm-rose)'],
                            ['Refunded',    $pipeRefunded,    'Payment refunded', 'var(--adm-amber)'],
                        ];
                    ?>
                    <div class="adm-pipeline-wrap">
                        <?php foreach ($pipelineSteps as $psIdx => [$psName, $psCount, $psMeta, $psColor]): ?>
                        <div class="adm-pipeline-step<?= ($psIdx === 0 && $psCount > 0) ? ' active' : '' ?>" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name"><?= $psName ?></span>
                            <span class="adm-pipe-count"<?= $psColor !== '' ? ' style="color:' . $psColor . ';"' : '' ?>><?= number_format($psCount) ?></span>
                            <span class="adm-pipe-meta"><?= $psMeta ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($totalOrdersCount === 0): ?>
                    <p style="font-size:0.74rem; color:#8A8378; font-weight:600; margin:10px 2px 0;">No orders in the database yet, so every stage reads zero. New checkouts land in <strong>Unfulfilled</strong>.</p>
                    <?php endif; ?>
                </div>

                <!-- ════ MODERN SAAS/FINTECH CHARTS SECTION (2 LUXURY CARDS) ════ -->
                <div class="adm-charts-grid">
                    <!-- 1. Modern Revenue Analytics Card (World-Class Luxury UI) -->
                    <div class="adm-saas-chart-card">
                        <div class="adm-saas-card-head">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:26px; height:26px; border-radius:7px; background:linear-gradient(135deg, #FAF5E8, #F3E8C8); border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="20" x2="18" y2="10"></line>
                                        <line x1="12" y1="20" x2="12" y2="4"></line>
                                        <line x1="6" y1="20" x2="6" y2="14"></line>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="adm-saas-card-title">Revenue Analytics</h3>
                                    <!-- Was the frozen caption "Multi-channel sales • 1-7 Apr, 2026". -->
                                    <p class="adm-saas-card-sub">Multi-channel sales &bull; <?php echo htmlspecialchars($revRangeLabel, ENT_QUOTES); ?></p>
                                </div>
                            </div>
                            <button type="button" class="adm-ref-view-ord-btn" onclick="switchAdmTab('reports')">View Report ↗</button>
                        </div>

                        <div class="adm-saas-kpi-row" style="display:flex; align-items:baseline; gap:12px; margin-bottom:10px;">
                            <?php /* Was a hardcoded Rs 42,85,900 with a hardcoded "↗ +18.4% vs last week". */ ?>
                            <div class="adm-saas-kpi-val" style="font-size:1.8rem; font-weight:900; color:#181512; font-family:'Plus Jakarta Sans', sans-serif; letter-spacing:-0.02em;">₹<?php echo number_format($revWeekTotal); ?></div>
                            <?php if ($revWeekTotal > 0 || $revPrevWeekTotal > 0): ?>
                            <?php $revUp = ((float)$revGrowth >= 0); ?>
                            <div class="adm-saas-delta-badge" style="background:<?php echo $revUp ? '#DCFCE7' : '#FEE2E2'; ?>; border:1px solid <?php echo $revUp ? '#86EFAC' : '#FCA5A5'; ?>; color:<?php echo $revUp ? '#15803D' : '#DC2626'; ?>; padding:2px 8px; border-radius:12px; font-weight:800; font-size:0.7rem; display:inline-flex; align-items:center; gap:4px;">
                                <span><?php echo ($revUp ? '&#8599; +' : '&#8600; ') . number_format((float)$revGrowth, 1); ?>%</span>
                                <small style="font-size:0.64rem; font-weight:600; color:<?php echo $revUp ? '#166534' : '#991B1B'; ?>;">vs previous 7 days</small>
                            </div>
                            <?php else: ?>
                            <div class="adm-saas-delta-badge" style="background:#F5F2EA; border:1px solid #E2DFD7; color:#645D54; padding:2px 8px; border-radius:12px; font-weight:700; font-size:0.7rem;">No sales in this window</div>
                            <?php endif; ?>
                        </div>

                        <div class="adm-saas-canvas-wrap" style="height:190px;">
                            <canvas id="admRevenueChart"></canvas>
                        </div>

                        <div class="adm-saas-legend-row" style="display:flex; align-items:center; gap:18px; padding-top:10px; border-top:1.5px solid #F1ECE1; font-size:0.74rem;">
                            <div class="adm-saas-leg-item" style="display:inline-flex; align-items:center; gap:6px;">
                                <span class="adm-saas-leg-dot" style="background:#8A681F; width:8px; height:8px; border-radius:50%;"></span>
                                <span class="adm-saas-leg-lbl" style="font-weight:700; color:#645D54;">B2B Wholesale:</span>
                                <?php /* Was a hardcoded Rs 28.4L. */ ?>
                                <span class="adm-saas-leg-val" style="color:#8A681F; font-weight:800; font-family:'Plus Jakarta Sans', sans-serif;">₹<?php echo number_format($revB2BTotal); ?></span>
                            </div>
                            <div class="adm-saas-leg-item" style="display:inline-flex; align-items:center; gap:6px;">
                                <span class="adm-saas-leg-dot" style="background:#15803D; width:8px; height:8px; border-radius:50%;"></span>
                                <span class="adm-saas-leg-lbl" style="font-weight:700; color:#645D54;">B2C &amp; Resellers:</span>
                                <?php /* Was a hardcoded Rs 14.4L. */ ?>
                                <span class="adm-saas-leg-val" style="color:#15803D; font-weight:800; font-family:'Plus Jakarta Sans', sans-serif;">₹<?php echo number_format($revB2CTotal); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Modern Category Sales & Expense Breakdown Card (World-Class Luxury UI) -->
                    <div class="adm-saas-chart-card">
                        <div class="adm-saas-card-head">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:26px; height:26px; border-radius:7px; background:linear-gradient(135deg, #FAF5E8, #F3E8C8); border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="8" cy="9" r="5"></circle>
                                        <circle cx="16" cy="15" r="4"></circle>
                                        <circle cx="17" cy="6" r="2.5"></circle>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="adm-saas-card-title">Category Breakdown</h3>
                                    <!-- Was the frozen caption "Catalog share • 1-7 Apr, 2026". -->
                                    <p class="adm-saas-card-sub"><?php echo $catMode === 'sales' ? 'Sold value by category &bull; all time' : 'Catalogue share &bull; nothing sold yet'; ?></p>
                                </div>
                            </div>
                            <button type="button" class="adm-ref-view-ord-btn" onclick="switchAdmTab('products')">View Catalog ↗</button>
                        </div>

                        <div class="adm-saas-canvas-wrap" style="height:175px; display:flex; align-items:center; justify-content:center;">
                            <canvas id="admCategoryChart"></canvas>
                        </div>

                        <div class="adm-saas-category-grid">
                            <?php
                                // The four pods here were fully hardcoded - Sarees 48% /
                                // Rs 20,57,200 / "842 Lots Active", Kurtis & Rayon 32%, Lehengas
                                // 13% with a "Low Stock" flag, Dress Materials 7% - so they read
                                // identically on a catalogue with no products and no orders.
                                $catPalette = [
                                    ['#FAF5E8', '#D4AF37', '#8A681F', '#8A681F', 'linear-gradient(90deg, #8A681F, #D4AF37)', 'purple'],
                                    ['#DCFCE7', '#86EFAC', '#15803D', '#15803D', 'linear-gradient(90deg, #15803D, #22C55E)', 'emerald'],
                                    ['#F3E8FF', '#D8B4FE', '#7E22CE', '#7E22CE', 'linear-gradient(90deg, #7E22CE, #A855F7)', 'purple'],
                                    ['#FEF3C7', '#FCD34D', '#D97706', '#B45309', 'linear-gradient(90deg, #D97706, #F59E0B)', 'rose'],
                                ];
                            ?>
                            <?php if (empty($catBreakdown)): ?>
                            <p style="font-size:0.78rem; color:#8A8378; font-weight:600; text-align:center; padding:16px 6px; margin:0; grid-column:1/-1;">No categories with products or sales yet.</p>
                            <?php endif; ?>
                            <?php foreach (array_slice($catBreakdown, 0, 4) as $cbIdx => $cb):
                                [$cbTint, $cbBorder, $cbDot, $cbText, $cbBar, $cbPill] = $catPalette[$cbIdx % 4];
                                $cbSkus = 0;
                                $cbOut  = 0;
                                foreach ($allProducts as $cbP) {
                                    if ((trim((string)($cbP['category_name'] ?? '')) ?: 'Uncategorised') !== $cb['name']) {
                                        continue;
                                    }
                                    $cbSkus++;
                                    if (($cbP['status'] ?? '') !== 'in_stock') { $cbOut++; }
                                }
                            ?>
                            <div class="adm-saas-cat-pod" style="background:linear-gradient(135deg, <?= $cbTint ?> 0%, #FFFFFF 100%); border-color:<?= $cbBorder ?>;">
                                <div class="adm-saas-cat-top">
                                    <div class="adm-saas-cat-title-wrap">
                                        <div class="adm-saas-cat-icon" style="background:<?= $cbTint ?>; border:1px solid <?= $cbBorder ?>;">
                                            <span class="adm-saas-leg-dot" style="background:<?= $cbDot ?>;"></span>
                                        </div>
                                        <span class="adm-saas-cat-name"><?= htmlspecialchars($cb['name']) ?></span>
                                    </div>
                                    <span class="adm-ref-pill <?= $cbPill ?>" style="font-size:0.64rem; padding:1px 6px;"><?= number_format($cb['pct'], 1) ?>%</span>
                                </div>
                                <div class="adm-saas-cat-amt" style="color:<?= $cbText ?>;"><?= $catMode === 'sales' ? '₹' . number_format($cb['value']) : number_format($cb['units']) . ' SKUs' ?></div>
                                <div class="adm-saas-cat-progress">
                                    <div class="adm-saas-cat-bar" style="width:<?= max(2, min(100, (float)$cb['pct'])) ?>%; background:<?= $cbBar ?>;"></div>
                                </div>
                                <div class="adm-saas-cat-footer">
                                    <span><?= $catMode === 'sales' ? number_format($cb['units']) . ' pcs sold' : number_format($cb['units']) . ' product' . ((int)$cb['units'] === 1 ? '' : 's') ?></span>
                                    <span style="color:<?= $cbOut > 0 ? '#D97706' : '#15803D' ?>; font-weight:700;">● <?= $cbOut > 0 ? number_format($cbOut) . ' not in stock' : ($cbSkus > 0 ? 'In Stock' : 'No SKUs') ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Preview Table on Overview -->
                <div class="adm-table-card">
                    <div class="adm-table-toolbar">
                        <div>
                            <h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; color:#181512;">Recent Order Stream</h3>
                            <p style="font-size:0.75rem; color:#7A7266;">The 6 newest orders across every channel</p>
                        </div>
                        <button class="adm-btn-secondary" onclick="switchAdmTab('orders')">
                            <span>View All Orders →</span>
                        </button>
                    </div>
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer / Business</th>
                                    <th>Channel</th>
                                    <th>Items</th>
                                    <th>Total & Payment</th>
                                    <th>Status</th>
                                    <th>Quick WhatsApp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Both rows here were 100% hardcoded: ORD-9842 / Ananya Sharma /
                                    // "Nilambari Silk Saree (Qty: 1)" / Rs 4,899 / In Transit, and
                                    // ORD-9841 / "Vardhman Textiles (Rajesh K.)" / "Pure Dola Silk
                                    // Lot (Qty: 24 pcs)" / Rs 33,576 / Packed. They rendered on
                                    // every install regardless of the database, both carried the
                                    // shop's own phone number as the "customer" number, and their
                                    // WhatsApp buttons called sendOrderWhatsApp(), which resolves
                                    // the id against a demo array in admin.js, so they did nothing.
                                    $streamOrders = array_slice($recentOrdersList, 0, 6);
                                    $streamChanStyle = [
                                        'wholesale' => 'background:#FAF5E8; color:#8A681F;',
                                        'reseller'  => 'background:#F3E8FF; color:#7E22CE;',
                                        'whatsapp'  => 'background:#DCFCE7; color:#15803D;',
                                        'retail'    => 'background:#F8F6F0; color:#645D54;',
                                    ];
                                    $streamChanLabel = [
                                        'wholesale' => 'Wholesale B2B',
                                        'reseller'  => 'Reseller',
                                        'whatsapp'  => 'WhatsApp',
                                        'retail'    => 'B2C Retail',
                                    ];
                                    $streamFulBadge = [
                                        'unfulfilled' => ['warning', 'Unfulfilled'],
                                        'processing'  => ['info',    'Processing'],
                                        'dispatched'  => ['gold',    'Dispatched'],
                                        'delivered'   => ['success', 'Delivered'],
                                        'cancelled'   => ['danger',  'Cancelled'],
                                    ];
                                    $streamPayLabel = [
                                        'paid'     => ['#15803D', 'Paid'],
                                        'pending'  => ['#B45309', 'Payment pending'],
                                        'credit'   => ['#7E22CE', 'On credit'],
                                        'refunded' => ['#DC2626', 'Refunded'],
                                    ];
                                ?>
                                <?php if (empty($streamOrders)): ?>
                                <tr>
                                    <td colspan="7" style="text-align:center; padding:26px 10px; color:#8A8378; font-weight:600; font-size:0.82rem;">
                                        No orders yet. Every real checkout &mdash; retail, wholesale, reseller or WhatsApp &mdash; will appear here.
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <?php foreach ($streamOrders as $so):
                                    $soId    = (int)($so['id'] ?? 0);
                                    $soNum   = trim((string)($so['order_number'] ?? '')) ?: ('ORD-' . $soId);
                                    $soName  = trim((string)($so['customer_name'] ?? '')) ?: 'Direct customer';
                                    $soPhone = preg_replace('/[^0-9]/', '', (string)($so['customer_phone'] ?? ''));
                                    $soChan  = strtolower(trim((string)($so['channel'] ?? ''))) ?: 'retail';
                                    $soFul   = strtolower(trim((string)($so['fulfillment_status'] ?? ''))) ?: 'unfulfilled';
                                    $soPay   = strtolower(trim((string)($so['payment_status'] ?? ''))) ?: 'pending';
                                    $soMethod = trim((string)($so['payment_method'] ?? ''));
                                    $soItems = $orderItemSummary[$soId] ?? null;
                                    $soDate  = !empty($so['created_at']) ? date('d M Y, h:i A', strtotime((string)$so['created_at'])) : 'Date not recorded';
                                    [$soBadge, $soBadgeText] = $streamFulBadge[$soFul] ?? ['info', ucfirst($soFul)];
                                    [$soPayColor, $soPayText] = $streamPayLabel[$soPay] ?? ['#645D54', ucfirst($soPay)];
                                ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($soNum) ?></strong><br><small style="color:#8C8478;"><?= htmlspecialchars($soDate) ?></small></td>
                                    <td>
                                        <strong><?= htmlspecialchars($soName) ?></strong>
                                        <?php if ($soPhone !== ''): ?><br><small style="color:#8A681F;">+<?= htmlspecialchars($soPhone) ?></small><?php else: ?><br><small style="color:#A8A29E;">No phone on file</small><?php endif; ?>
                                    </td>
                                    <td><span style="font-weight:700; <?= $streamChanStyle[$soChan] ?? $streamChanStyle['retail'] ?> padding:2px 6px; border-radius:4px;"><?= htmlspecialchars($streamChanLabel[$soChan] ?? ucfirst($soChan)) ?></span></td>
                                    <td><?php
                                        if ($soItems !== null) {
                                            echo htmlspecialchars($soItems['title']);
                                            echo ' <small style="color:#8C8478;">(Qty: ' . number_format($soItems['units']) . ' pc' . ($soItems['units'] === 1 ? '' : 's') . ')</small>';
                                            if ($soItems['lines'] > 1) {
                                                echo '<br><small style="color:#8C8478;">+ ' . number_format($soItems['lines'] - 1) . ' more line item' . ($soItems['lines'] === 2 ? '' : 's') . '</small>';
                                            }
                                        } else {
                                            echo '<small style="color:#A8A29E;">No line items recorded</small>';
                                        }
                                    ?></td>
                                    <td>
                                        <strong>₹<?= number_format((float)($so['total_amount'] ?? 0)) ?></strong><br>
                                        <small style="color:<?= $soPayColor ?>;"><?= htmlspecialchars($soPayText) ?><?= $soMethod !== '' ? ' (' . htmlspecialchars(strtoupper($soMethod)) . ')' : '' ?></small>
                                    </td>
                                    <td><span class="adm-badge <?= $soBadge ?>"><?= htmlspecialchars($soBadgeText) ?></span></td>
                                    <td>
                                        <?php if ($soPhone !== ''): ?>
                                        <a class="adm-action-btn wa" href="https://wa.me/<?= $soPhone ?>?text=<?= urlencode("Hello {$soName}, regarding your order {$soNum} with DT Brand's.") ?>" target="_blank" rel="noopener" title="Message this customer on WhatsApp">
                                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        </a>
                                        <?php else: ?>
                                        <small style="color:#A8A29E; font-weight:600;">&mdash;</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 2: PRODUCTS & CATALOG MANAGEMENT
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-products">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Products &amp; Inventory</span>
                            <?php /* Was a hardcoded "1,240 SKUs" badge. */ ?>
                            <span class="adm-badge gold"><?php echo number_format($totalProductsCount); ?> SKU<?php echo $totalProductsCount === 1 ? '' : 's'; ?></span>
                        </h1>
                        <p class="adm-page-subtitle">Manage B2C Retail &amp; B2B Wholesale pricing, MOQ rules, stock alerts, and fabric specs.</p>
                    </div>
                    <div class="adm-page-actions">
                        <a href="/admin/products/imports/" class="adm-btn-secondary">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>📥 Import Wizard</span>
                        </a>
                        <button class="adm-btn-secondary" onclick="window.exportCurrentTable('products_catalog')">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <span>📤 Export CSV</span>
                        </button>
                        <a href="/admin/products/add.php" class="adm-btn-primary">
                            <svg viewBox="0 0 24 24" width="13" height="13" stroke="#181512" stroke-width="2.8" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Add Product</span>
                        </a>
                    </div>
                </div>

                <!-- ══ PRODUCT SUB-OPTION QUICK PILLS WITH 100% REAL VECTOR SVG ICONS ══ -->
                <div class="adm-prod-subnav-strip">
                    <a href="/admin/products/" class="adm-prod-pill active">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span>All Products</span>
                        <span class="adm-prod-pill-badge">1,240</span>
                    </a>
                    <a href="/admin/products/add.php" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Product</span>
                    </a>
                    <a href="/admin/products/categories/" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                        <span>Categories</span>
                        <span class="adm-prod-pill-badge">16</span>
                    </a>
                    <a href="/admin/products/brands/" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><circle cx="7.5" cy="7.5" r="1.5"></circle></svg>
                        <span>Brands</span>
                        <span class="adm-prod-pill-badge">4</span>
                    </a>
                    <a href="/admin/products/attributes/" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path></svg>
                        <span>Attributes</span>
                    </a>
                    <a href="/admin/products/variants/" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="16 3 21 3 21 8"></polyline><line x1="4" y1="20" x2="21" y2="3"></line><polyline points="21 16 21 21 16 21"></polyline><line x1="15" y1="15" x2="21" y2="21"></line></svg>
                        <span>Variants</span>
                    </a>
                    <a href="/admin/products/media/" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <span>Media</span>
                    </a>
                    <a href="/admin/products/featured/" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Featured</span>
                        <span class="adm-prod-pill-badge">48</span>
                    </a>
                    <a href="/admin/products/best-sellers/" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                        <span>Best Sellers</span>
                        <span class="adm-prod-pill-badge">32</span>
                    </a>
                    <a href="/admin/products/new-arrivals/" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15 8 21 9 17 14 18 20 12 17 6 20 7 14 3 9 9 8 12 2"></polygon></svg>
                        <span>New Arrivals</span>
                        <span class="adm-prod-pill-badge">64</span>
                    </a>
                    <a href="/admin/products/reviews/" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>Reviews</span>
                    </a>
                    <a href="/admin/products/imports/" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Import</span>
                    </a>
                    <a href="/admin/products/exports/" class="adm-prod-pill">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>Export</span>
                    </a>
                </div>

                <!-- ══ 4-CARD MASTER WHOLESALE KPI METRIC RIBBON ══ -->
                <div class="dt-kpi-ribbon">
                    <div class="dt-kpi-card">
                        <div class="dt-kpi-icon-wrap" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                            <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        </div>
                        <div class="dt-kpi-content">
                            <div class="dt-kpi-lbl">TOTAL PRODUCTS (SKUS)</div>
                            <div class="dt-kpi-val" style="color:#181512;">1,240 Products</div>
                        </div>
                    </div>

                    <div class="dt-kpi-card">
                        <div class="dt-kpi-icon-wrap" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D;">
                            <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        </div>
                        <div class="dt-kpi-content">
                            <div class="dt-kpi-lbl">SURAT READY STOCK</div>
                            <div class="dt-kpi-val" style="color:#15803D;"><?= number_format($totalStockQty) ?> Units</div>
                        </div>
                    </div>

                    <div class="dt-kpi-card">
                        <div class="dt-kpi-icon-wrap" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
                            <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                        <div class="dt-kpi-content">
                            <div class="dt-kpi-lbl">INVENTORY VALUATION</div>
                            <div class="dt-kpi-val" style="color:#1D4ED8;">₹<?= number_format(array_sum(array_map(fn($p) => ((int)($p['stock_qty'] ?? 0)) * ((float)($p['retail_price'] ?? 0)), $allProducts))) ?></div>
                        </div>

                    </div>

                    <div class="dt-kpi-card">
                        <div class="dt-kpi-icon-wrap" style="background:#FEF3C7; border:1px solid #FCD34D; color:#B45309;">
                            <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        </div>
                        <div class="dt-kpi-content">
                            <div class="dt-kpi-lbl">AVG RESALE MARGIN</div>
                            <div class="dt-kpi-val" style="color:#B45309;">+38.5% Margin</div>
                        </div>
                    </div>
                </div>

                <!-- ══ MASTER PRODUCT TABLE CARD ══ -->
                <div class="adm-table-card">
                    <!-- Table Search & Filters Toolbar -->
                    <div class="adm-table-toolbar">
                        <div class="adm-search-box" style="max-width:320px;">
                            <input type="text" id="admProdSearch" class="adm-search-input" placeholder="Search product name, SKU, fabric..." style="padding-left:12px;" oninput="if(typeof filterProducts==='function') filterProducts();">
                            <button type="button" id="admProdSearchClear" class="adm-search-clear" onclick="document.getElementById('admProdSearch').value=''; if(typeof filterProducts==='function') filterProducts();">✕</button>
                        </div>

                        <div class="adm-table-filters">
                            <select id="admProdCatFilter" class="adm-filter-select" onchange="filterProducts()">
                                <option value="all">All Categories</option>
                                <option value="Sarees">Silk &amp; Zari Sarees</option>
                                <option value="Banarasi">Banarasi Brocade</option>
                                <option value="Kurtis">Kurtis &amp; Sets</option>
                                <option value="Lehengas">Bridal Lehengas</option>
                                <option value="Dress Materials">Dress Materials</option>
                            </select>

                            <select id="admProdBrandFilter" class="adm-filter-select" onchange="filterProducts()">
                                <option value="all">All Brands</option>
                                <option value="DT Signature">DT Signature</option>
                                <option value="Arniya Heritage">Arniya Heritage</option>
                                <option value="DT Couture">DT Couture</option>
                            </select>

                            <select id="admProdStockFilter" class="adm-filter-select" onchange="filterProducts()">
                                <option value="all">All Stock Status</option>
                                <option value="In Stock">In Stock (&gt; 10 pcs)</option>
                                <option value="Low Stock">Low Stock (&lt; 5 pcs)</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>

                            <button type="button" class="adm-btn-secondary" style="height:34px; padding:0 10px; font-size:0.75rem;" onclick="document.getElementById('admProdSearch').value=''; document.getElementById('admProdCatFilter').value='all'; document.getElementById('admProdBrandFilter').value='all'; document.getElementById('admProdStockFilter').value='all'; filterProducts();">↺ Reset</button>
                        </div>
                    </div>

                    <!-- Products Table View -->
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th style="width:36px; text-align:center;">
                                        <input type="checkbox" onchange="window.toggleBulkSelectAll(this)" style="cursor:pointer;">
                                    </th>
                                    <th>Product Details</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Variants</th>
                                    <th>Pricing (Retail / Reseller / Wholesale)</th>
                                    <th>Wholesale MOQ</th>
                                    <th>Stock Units</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="admProductsTableBody">
                                <!-- Rendered dynamically by admin.js -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="dt-pagination">
                        <div class="dt-page-info">
                            Showing <strong>1 – 6</strong> of <strong>1,240</strong> products • Per page: <strong>25</strong>
                        </div>
                        <div class="dt-page-nav">
                            <button type="button" class="dt-page-btn" disabled>«</button>
                            <button type="button" class="dt-page-btn active">1</button>
                            <button type="button" class="dt-page-btn">2</button>
                            <button type="button" class="dt-page-btn">3</button>
                            <button type="button" class="dt-page-btn">»</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 3: ORDERS & LOGISTICS MANAGEMENT
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-orders">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">Multi-Channel Orders & Consignments</h1>
                        <p class="adm-page-subtitle">Track dispatches, print GST invoices, and notify customers via automated WhatsApp links.</p>
                    </div>
                    <div class="adm-page-actions">
                        <button class="adm-btn-secondary" onclick="window.exportTableToCSV('orders')">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export All Orders</span>
                        </button>
                    </div>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-toolbar">
                        <div class="adm-search-box" style="max-width:320px;">
                            <input type="text" id="admOrderSearch" class="adm-search-input" placeholder="Search order ID, customer, phone..." style="padding-left:12px;">
                            <button type="button" id="admOrderSearchClear" class="adm-search-clear">✕</button>
                        </div>

                        <div class="adm-table-filters">
                            <select id="admOrderChannelFilter" class="adm-filter-select" onchange="filterOrders()">
                                <option value="all">All Channels</option>
                                <option value="B2C Shop">B2C Shop</option>
                                <option value="Wholesale">Wholesale B2B</option>
                                <option value="Reseller">Reseller</option>
                                <option value="Retailer">Retailer</option>
                            </select>

                            <select id="admOrderStatusFilter" class="adm-filter-select" onchange="filterOrders()">
                                <option value="all">All Statuses</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Packed">Packed</option>
                                <option value="In Transit">In Transit</option>
                                <option value="Delivered">Delivered</option>
                            </select>
                        </div>
                    </div>

                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Order ID & Date</th>
                                    <th>Customer & City</th>
                                    <th>Sales Channel</th>
                                    <th>Order Items</th>
                                    <th>Amount & Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="admOrdersTableBody">
                                <!-- Rendered dynamically by admin.js -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 4: WHATSAPP CRM & BROADCAST CAMPAIGNS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-whatsapp">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>WhatsApp CRM & Broadcast Hub</span>
                            <span class="adm-badge" style="background:#DCFCE7; color:#15803D;">● Connected</span>
                        </h1>
                        <p class="adm-page-subtitle">Engage customers, convert wholesale catalog inquiries, and broadcast promotional campaigns.</p>
                    </div>
                </div>

                <div class="adm-wa-grid">
                    <!-- Left: Incoming Leads & Inquiries -->
                    <div class="adm-card">
                        <div class="adm-card-head">
                            <h3 class="adm-card-title">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                <span>Recent WhatsApp Inquiries</span>
                            </h3>
                            <span class="adm-badge green">4 New Leads</span>
                        </div>
                        <div class="adm-wa-lead-list" id="admWaLeadsList">
                            <!-- Rendered dynamically by admin.js -->
                        </div>
                    </div>

                    <!-- Right: Campaign Broadcaster -->
                    <div class="adm-card">
                        <div class="adm-card-head">
                            <h3 class="adm-card-title">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><polygon points="3 11 22 2 13 21 11 13 3 11"></polygon></svg>
                                <span>Broadcast Campaign Composer</span>
                            </h3>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div class="adm-form-group">
                                <label class="adm-form-label">Select Campaign Template</label>
                                <select id="admBroadcastTemplate" class="adm-form-select">
                                    <option value="catalogue">✨ Luxury Ethnic Fresh Catalogue 2026</option>
                                    <option value="festive">🔥 Festive Bonanza — 40% Off Wholesale</option>
                                    <option value="wholesale_drop">💎 Bulk Lot Price Drop Alert</option>
                                </select>
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Target Audience Group</label>
                                <select id="admBroadcastAudience" class="adm-form-select">
                                    <option value="all">All Contacts (1,420 Verified)</option>
                                    <option value="wholesalers">Verified Wholesalers Only (285)</option>
                                    <option value="resellers">Active Resellers (420)</option>
                                    <option value="vip">VIP Retail Customers (715)</option>
                                </select>
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Message Content (Dynamic Variables Supported)</label>
                                <textarea id="admBroadcastMessage" class="adm-form-textarea" rows="4">✨ *DT BRAND'S LUXURY ETHNIC FRESH CATALOGUE* ✨

Dear {Name},
Explore our latest 2026 Pure Silk Sarees & Designer Lehengas crafted for premium festive collections.

👉 *View & Order Online:* https://jaihanumantex.in/shop

_Special 15% VIP Discount Applied!_</textarea>
                            </div>

                            <!-- Live WhatsApp Bubble Preview -->
                            <div class="adm-form-group">
                                <label class="adm-form-label">Live WhatsApp Chat Preview</label>
                                <div class="adm-wa-preview-bubble" id="admBroadcastPreview">
                                    ✨ <strong>DT BRAND'S LUXURY ETHNIC FRESH CATALOGUE</strong> ✨<br><br>
                                    Dear Rajesh Kumar,<br>
                                    Explore our latest 2026 Pure Silk Sarees &amp; Designer Lehengas crafted for premium festive collections.<br><br>
                                    👉 <strong>View &amp; Order Online:</strong> https://jaihanumantex.in/shop<br><br>
                                    <em>Special 15% VIP Discount Applied!</em>
                                </div>
                            </div>

                            <button class="adm-btn-primary" style="justify-content:center; padding:12px;" onclick="window.launchBroadcast()">
                                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.5" fill="none"><polygon points="3 11 22 2 13 21 11 13 3 11"></polygon></svg>
                                <span>Launch WhatsApp Broadcast</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 5: WHOLESALERS & RESELLERS PARTNER HUB
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-partners">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">B2B Wholesalers & Reseller Network</h1>
                        <p class="adm-page-subtitle">Verify partner KYC, review GST numbers, assign volume discount tiers, and manage commission payouts.</p>
                    </div>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-toolbar">
                        <div class="adm-search-box" style="max-width:320px;">
                            <input type="text" id="admPartnerSearch" class="adm-search-input" placeholder="Search partner name, GST, phone..." style="padding-left:12px;">
                            <button type="button" id="admPartnerSearchClear" class="adm-search-clear">✕</button>
                        </div>
                    </div>

                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Partner ID</th>
                                    <th>Business / Contact Name</th>
                                    <th>Partner Type</th>
                                    <th>Pricing Tier</th>
                                    <th>GSTIN Number</th>
                                    <th>Total Business</th>
                                    <th>KYC Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="admPartnersTableBody">
                                <!-- Rendered dynamically by admin.js -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 6: CUSTOMER CRM DIRECTORY
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-customers">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">Customer CRM Directory</h1>
                        <p class="adm-page-subtitle">Complete directory of B2C and retail buyers with lifetime order history.</p>
                    </div>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-toolbar">
                        <div class="adm-search-box" style="max-width:320px;">
                            <input type="text" id="admCustomerSearch" class="adm-search-input" placeholder="Search customer name or phone..." style="padding-left:12px;">
                            <button type="button" id="admCustomerSearchClear" class="adm-search-clear">✕</button>
                        </div>
                    </div>

                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Phone & Email</th>
                                    <th>City & State</th>
                                    <th>Total Orders</th>
                                    <th>Lifetime Value</th>
                                    <th>Customer Tag</th>
                                    <th>Direct Action</th>
                                </tr>
                            </thead>
                            <tbody id="admCustomersTableBody">
                                <tr>
                                    <td><strong>Ananya Sharma</strong></td>
                                    <td>+91 7046363528<br><small style="color:#7A7266;">ananya@gmail.com</small></td>
                                    <td>Mumbai, MH</td>
                                    <td>6 Orders</td>
                                    <td><strong>₹28,450</strong></td>
                                    <td><span class="adm-badge gold">VIP Retail</span></td>
                                    <td>
                                        <button class="adm-action-btn wa" title="WhatsApp Customer" onclick="window.openDirectWhatsApp('7046363528', 'Namaste Ananya ji, regarding your order with DT Brand...')">
                                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Sneha Patel</strong></td>
                                    <td>+91 7046363528<br><small style="color:#7A7266;">sneha.patel@yahoo.com</small></td>
                                    <td>Ahmedabad, GJ</td>
                                    <td>4 Orders</td>
                                    <td><strong>₹16,900</strong></td>
                                    <td><span class="adm-badge info">Frequent Buyer</span></td>
                                    <td>
                                        <button class="adm-action-btn wa" title="WhatsApp Customer" onclick="window.openDirectWhatsApp('7046363528', 'Namaste Sneha ji, from DT Brand...')">
                                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 7: SALES & GST REPORTS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-reports">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">Sales, GST & Tax Reports</h1>
                        <p class="adm-page-subtitle">Monthly HSN-wise tax breakdowns, IGST, CGST, SGST ledgers, and exportable accounts.</p>
                    </div>
                </div>

                <div class="adm-kpi-grid">
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Taxable Turnover</span>
                            <div class="adm-kpi-icon-box">📊</div>
                        </div>
                        <div class="adm-kpi-val">₹38,96,270</div>
                        <div class="adm-kpi-bottom"><span class="adm-kpi-subtext">Current Fiscal Month</span></div>
                    </div>
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Total GST Output (5% / 12%)</span>
                            <div class="adm-kpi-icon-box green">📜</div>
                        </div>
                        <div class="adm-kpi-val">₹2,89,630</div>
                        <div class="adm-kpi-bottom"><span class="adm-kpi-subtext">CGST: ₹1.44L | SGST: ₹1.44L</span></div>
                    </div>
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Integrated Tax (IGST)</span>
                            <div class="adm-kpi-icon-box blue">🌐</div>
                        </div>
                        <div class="adm-kpi-val">₹1,00,000</div>
                        <div class="adm-kpi-bottom"><span class="adm-kpi-subtext">Inter-state Consignments</span></div>
                    </div>
                </div>

                <div class="adm-table-card" style="margin-top:16px;">
                    <div class="adm-table-toolbar">
                        <h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">HSN Code Wise Tax Breakdown</h3>
                        <button class="adm-btn-secondary" onclick="window.exportTableToCSV('orders')">
                            <span>Download Tax Audit CSV</span>
                        </button>
                    </div>
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>HSN Code</th>
                                    <th>Description</th>
                                    <th>GST Rate</th>
                                    <th>Total Quantity</th>
                                    <th>Taxable Value</th>
                                    <th>Total Tax Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>5007</code></td>
                                    <td>Pure Silk & Handloom Sarees</td>
                                    <td>5%</td>
                                    <td>840 pcs</td>
                                    <td>₹24,50,000</td>
                                    <td><strong>₹1,22,500</strong></td>
                                </tr>
                                <tr>
                                    <td><code>6204</code></td>
                                    <td>Kurtis, Sharara Sets & Lehengas</td>
                                    <td>5% / 12%</td>
                                    <td>620 pcs</td>
                                    <td>₹11,46,270</td>
                                    <td><strong>₹1,17,130</strong></td>
                                </tr>
                                <tr>
                                    <td><code>5208</code></td>
                                    <td>Cotton Dress Materials & Unstitched Suits</td>
                                    <td>5%</td>
                                    <td>390 pcs</td>
                                    <td>₹3,00,000</td>
                                    <td><strong>₹15,000</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 8: STORE & SYSTEM SETTINGS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-settings">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">Store Profile & Gateway Settings</h1>
                        <p class="adm-page-subtitle">Configure business details, WhatsApp CRM API credentials, and courier shipping integrations.</p>
                    </div>
                </div>

                <div class="adm-charts-grid">
                    <!-- Business Profile Info -->
                    <div class="adm-card">
                        <h3 class="adm-card-title">🏢 Brand & Legal Profile</h3>
                        <form onsubmit="event.preventDefault(); window.showToast('Store settings saved successfully!');" style="display:flex; flex-direction:column; gap:12px;">
                            <div class="adm-form-grid">
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Brand Name</label>
                                    <input type="text" class="adm-form-input" value="DT Brand's (Jai Hanuman Tex)">
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">GSTIN Number</label>
                                    <input type="text" class="adm-form-input" value="24AAACR4920M1Z2">
                                </div>
                                <div class="adm-form-group full">
                                    <label class="adm-form-label">Registered Warehouse Address</label>
                                    <input type="text" class="adm-form-input" value="Ring Road Textile Market, Surat, Gujarat - 395002">
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Support WhatsApp Number</label>
                                    <input type="text" class="adm-form-input" value="+91 70463 63528">
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Support Email</label>
                                    <input type="email" class="adm-form-input" value="support@jaihanumantex.in">
                                </div>
                            </div>
                            <button type="submit" class="adm-btn-primary" style="margin-top:10px; align-self:flex-start;">
                                <span>Save Changes</span>
                            </button>
                        </form>
                    </div>

                    <!-- Logistics & WhatsApp Gateways -->
                    <div class="adm-card">
                        <h3 class="adm-card-title">🚚 Courier & WhatsApp Gateways</h3>
                        <div style="display:flex; flex-direction:column; gap:14px; font-size:0.82rem;">
                            <div style="padding:10px; background:#FAF5E8; border:1px solid rgba(212,175,55,0.3); border-radius:8px;">
                                <strong style="color:#8A681F;">WhatsApp Cloud API Status</strong>
                                <p style="font-size:0.75rem; color:#5A4210; margin-top:2px;">Webhook Connected • 99.98% Deliverability</p>
                            </div>
                            <div style="padding:10px; background:#F8F6F0; border:1px solid #E5E1D7; border-radius:8px;">
                                <strong>Logistics Partners Configured</strong>
                                <p style="font-size:0.75rem; color:#7A7266; margin-top:2px;">Delhivery Surface, BlueDart Express, TCI Freight Cargo</p>
                            </div>
                            <div style="padding:10px; background:#DCFCE7; border:1px solid #BBF7D0; border-radius:8px;">
                                <strong style="color:#15803D;">SSL Security & Backup</strong>
                                <p style="font-size:0.75rem; color:#166534; margin-top:2px;">256-bit Encrypted • Hourly Automated Cloud Sync</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        
            <!-- ═══════════════════════════════════════════════════════════
                 TAB 9: PRICING & DISCOUNTS MATRIX
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-pricing">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Multi-Tier Pricing &amp; Discount Schedule</span>
                            <span class="adm-badge gold">Live B2B &amp; B2C</span>
                        </h1>
                        <p class="adm-page-subtitle">Configure wholesale MOQ volume tiers, reseller commission margins, and festive discount coupons.</p>
                    </div>
                    <div class="adm-page-actions">
                        <a href="/admin/pricing/discounts.php" class="adm-btn-secondary">🏷️ Manage Coupons</a>
                        <button class="adm-btn-secondary" onclick="window.exportCurrentTable('pricing_matrix')">📤 Export Pricing CSV</button>
                        <button class="adm-btn-primary" onclick="window.showToast('Add Price Tier Rule...')">+ Add Tier Rule</button>
                    </div>
                </div>

                <!-- Product Options Subnav Pills -->
                <div class="adm-prod-subnav-strip">
                    <a href="/admin/pricing/" class="adm-prod-pill active"><span>🏷️ All Pricing Rules</span></a>
                    <a href="/admin/pricing/retail.php" class="adm-prod-pill"><span>🛍️ Retail B2C Rates</span></a>
                    <a href="/admin/pricing/wholesale.php" class="adm-prod-pill"><span>🏭 Wholesale MOQ Rates</span></a>
                    <a href="/admin/pricing/reseller.php" class="adm-prod-pill"><span>🤝 Reseller Margins</span></a>
                    <a href="/admin/pricing/discounts.php" class="adm-prod-pill"><span>🎁 Festive Discounts</span></a>
                </div>

                <!-- 4 Pricing Summary Cards -->
                <div class="adm-kpi-grid" style="margin-bottom:20px;">
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top"><span class="adm-kpi-label">Active Price Tiers</span><div class="adm-kpi-icon-box gold">🏷️</div></div>
                        <div class="adm-kpi-val">4 Tiers</div>
                        <div class="adm-kpi-bottom"><span class="adm-badge gold">B2C, Reseller, Wholesale, Bulk</span></div>
                    </div>
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top"><span class="adm-kpi-label">Average Wholesale Margin</span><div class="adm-kpi-icon-box green">📈</div></div>
                        <div class="adm-kpi-val">34.8%</div>
                        <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Healthy B2B Spread</span></div>
                    </div>
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top"><span class="adm-kpi-label">Active Coupons</span><div class="adm-kpi-icon-box purple">🎁</div></div>
                        <div class="adm-kpi-val">6 Codes</div>
                        <div class="adm-kpi-bottom"><span class="adm-badge success">FESTIVE2026 Live</span></div>
                    </div>
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top"><span class="adm-kpi-label">GST Tax Slabs</span><div class="adm-kpi-icon-box blue">🏛️</div></div>
                        <div class="adm-kpi-val">5% &amp; 12%</div>
                        <div class="adm-kpi-bottom"><span class="adm-badge info">HSN 5007 &amp; 6204</span></div>
                    </div>
                </div>

                <!-- Pricing Table -->
                <div class="adm-table-card">
                    <div class="adm-table-toolbar">
                        <div class="adm-search-box" style="max-width:320px;">
                            <svg class="adm-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" class="adm-search-input" placeholder="Filter category or tier..." oninput="window.filterModuleTable(this.value, 'pricing')">
                        </div>
                    </div>
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Tier Name</th>
                                    <th>Target Channel</th>
                                    <th>MOQ Requirement</th>
                                    <th>Discount on MRP</th>
                                    <th>Payment Terms</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Retail Standard</strong></td>
                                    <td>Direct Consumers (B2C)</td>
                                    <td>1 Piece</td>
                                    <td>0% – 15% (MRP Base)</td>
                                    <td>Prepaid / COD</td>
                                    <td><span class="adm-badge success">Active</span></td>
                                    <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Edit Tier...')">Edit</button></td>
                                </tr>
                                <tr>
                                    <td><strong>Registered Reseller</strong></td>
                                    <td>WhatsApp &amp; Instagram Resellers</td>
                                    <td>1+ Pieces (Zero MOQ)</td>
                                    <td>20% – 25% Off Retail</td>
                                    <td>Instant UPI Payout</td>
                                    <td><span class="adm-badge success">Active</span></td>
                                    <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Edit Tier...')">Edit</button></td>
                                </tr>
                                <tr>
                                    <td><strong>Wholesale Tier 1</strong></td>
                                    <td>Verified B2B Retailers / Shops</td>
                                    <td>8+ Pieces per Design</td>
                                    <td>55% – 62% Off Retail</td>
                                    <td>Bank RTGS / Net 15</td>
                                    <td><span class="adm-badge gold">Primary B2B</span></td>
                                    <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Edit Tier...')">Edit</button></td>
                                </tr>
                                <tr>
                                    <td><strong>Bulk Mill Lots</strong></td>
                                    <td>Master Wholesalers / Distributors</td>
                                    <td>30+ Pieces (Full Bale)</td>
                                    <td>65% – 70% Off Retail</td>
                                    <td>Advance Wire Transfer</td>
                                    <td><span class="adm-badge info">VIP Only</span></td>
                                    <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Edit Tier...')">Edit</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 10: REVIEWS & RATINGS MODERATION
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-reviews">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Customer Reviews &amp; Social Proof</span>
                            <span class="adm-badge gold">4.9 ★ Rating</span>
                        </h1>
                        <p class="adm-page-subtitle">Moderate customer reviews, pin verified photo reviews to product pages, and respond to inquiries.</p>
                    </div>
                    <div class="adm-page-actions">
                        <a href="/admin/reviews/pending.php" class="adm-btn-secondary">⏳ Pending Moderation (2)</a>
                        <button class="adm-btn-secondary" onclick="window.exportCurrentTable('customer_reviews')">📤 Export Reviews</button>
                    </div>
                </div>

                <div class="adm-prod-subnav-strip">
                    <a href="/admin/reviews/" class="adm-prod-pill active"><span>⭐️ All Reviews (342)</span></a>
                    <a href="/admin/reviews/pending.php" class="adm-prod-pill"><span>⏳ Pending (2)</span></a>
                    <a href="/admin/reviews/approved.php" class="adm-prod-pill"><span>✅ Approved (338)</span></a>
                    <a href="/admin/reviews/rejected.php" class="adm-prod-pill"><span>🛑 Rejected (2)</span></a>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Product Details</th>
                                    <th>Star Rating</th>
                                    <th>Review Feedback</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Sunita Rao</strong><br><small style="color:#7A7266;">Hyderabad • Verified Buyer</small></td>
                                    <td><strong>Kanjivaram Pure Silk Gold Zari Saree</strong><br><small style="color:#8A681F;">SKU: KLN-SR-111</small></td>
                                    <td><span style="color:#F59E0B; font-weight:800;">★★★★★ 5.0</span></td>
                                    <td>"Authentic Kanjivaram pure silk fabric and the gold zari border has royal luster. Fast 2-day delivery!"</td>
                                    <td>Today, 11:20 AM</td>
                                    <td><span class="adm-badge success">Approved</span></td>
                                    <td>
                                        <div class="adm-action-btn-group">
                                            <button class="adm-action-btn" title="Pin to Homepage" onclick="window.showToast('📌 Pinned to Homepage showcase!')">📌</button>
                                            <button class="adm-action-btn wa" title="WhatsApp Thank You" onclick="window.showToast('WhatsApp appreciation message sent!')">💬</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Vardhman Textiles (Rajesh K.)</strong><br><small style="color:#8A681F;">Surat • Wholesale Partner</small></td>
                                    <td><strong>Pure Dola Silk Lot (24 pcs)</strong><br><small style="color:#8A681F;">SKU: KLN-SR-111-LOT</small></td>
                                    <td><span style="color:#F59E0B; font-weight:800;">★★★★★ 5.0</span></td>
                                    <td>"Our retail boutique customers loved every color. Excellent packaging and GST invoice provided promptly."</td>
                                    <td>Yesterday</td>
                                    <td><span class="adm-badge gold">B2B Verified</span></td>
                                    <td>
                                        <div class="adm-action-btn-group">
                                            <button class="adm-action-btn" title="Pin to B2B Testimonials" onclick="window.showToast('📌 Pinned to B2B page!')">📌</button>
                                            <button class="adm-action-btn wa" title="WhatsApp Thank You" onclick="window.showToast('WhatsApp message sent!')">💬</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 11: INVENTORY & WAREHOUSE HUBS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-inventory">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Warehouse Inventory &amp; Stock Hubs</span>
                            <span class="adm-badge gold">14,850 Total Units</span>
                        </h1>
                        <p class="adm-page-subtitle">Track stock allocations across Surat Central Mill Depot and Bhiwandi Logistics Hub.</p>
                    </div>
                    <div class="adm-page-actions">
                        <a href="/admin/inventory/stock-in.php" class="adm-btn-primary">+ Stock In (Procurement)</a>
                        <button class="adm-btn-secondary" onclick="window.exportCurrentTable('inventory_stock')">📤 Export Stock</button>
                    </div>
                </div>

                <div class="adm-prod-subnav-strip">
                    <a href="/admin/inventory/" class="adm-prod-pill active"><span>📦 All Inventory</span></a>
                    <a href="/admin/inventory/stock-in.php" class="adm-prod-pill"><span>📥 Stock In</span></a>
                    <a href="/admin/inventory/stock-out.php" class="adm-prod-pill"><span>📤 Stock Out</span></a>
                    <a href="/admin/inventory/low-stock.php" class="adm-prod-pill"><span>⚠️ Low Stock (14)</span></a>
                    <a href="/admin/inventory/adjustment.php" class="adm-prod-pill"><span>⚖️ Stock Adjustment</span></a>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>SKU &amp; Product</th>
                                    <th>Primary Hub</th>
                                    <th>In Stock</th>
                                    <th>Reserved</th>
                                    <th>Available to Sell</th>
                                    <th>Stock Health</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>KLN-SR-111</strong><br><small>Kanjivaram Silk Saree</small></td>
                                    <td>Surat Central Depot</td>
                                    <td><strong>110 units</strong></td>
                                    <td>15 units (Order #ORD-9841)</td>
                                    <td><strong style="color:#15803D;">95 units</strong></td>
                                    <td><span class="adm-badge success">Optimal</span></td>
                                    <td><a href="/admin/inventory/adjustment.php" class="adm-btn-secondary adm-btn-sm">Adjust</a></td>
                                </tr>
                                <tr>
                                    <td><strong>BRD-LH-902</strong><br><small>Bridal Zardosi Lehenga</small></td>
                                    <td>Surat Central Depot</td>
                                    <td><strong>4 units</strong></td>
                                    <td>1 unit</td>
                                    <td><strong style="color:#DC2626;">3 units</strong></td>
                                    <td><span class="adm-badge warning">Low Stock</span></td>
                                    <td><a href="/admin/inventory/stock-in.php" class="adm-btn-secondary adm-btn-sm">Restock</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 12: SHIPPING & LOGISTICS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-shipping">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Shipping Logistics &amp; Courier Manifests</span>
                            <span class="adm-badge gold">19,000+ Pincodes</span>
                        </h1>
                        <p class="adm-page-subtitle">Manage Delhivery, BlueDart &amp; TCI Freight logistics integrations and dispatch manifests.</p>
                    </div>
                    <div class="adm-page-actions">
                        <a href="/admin/shipping/tracking.php" class="adm-btn-secondary">🔍 Live Tracking</a>
                        <button class="adm-btn-primary" onclick="window.showToast('Generate Shipping Manifest...')">+ Create Manifest</button>
                    </div>
                </div>

                <div class="adm-prod-subnav-strip">
                    <a href="/admin/shipping/" class="adm-prod-pill active"><span>🚚 Active Shipments</span></a>
                    <a href="/admin/shipping/methods.php" class="adm-prod-pill"><span>📦 Courier Partners</span></a>
                    <a href="/admin/shipping/rates.php" class="adm-prod-pill"><span>💰 Shipping Rates</span></a>
                    <a href="/admin/shipping/tracking.php" class="adm-prod-pill"><span>📍 AWB Tracking</span></a>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>AWB Tracking #</th>
                                    <th>Order ID</th>
                                    <th>Courier Partner</th>
                                    <th>Destination</th>
                                    <th>Weight</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>DELHIVERY: DL789234901</code></td>
                                    <td><strong>ORD-9842</strong></td>
                                    <td>Delhivery Express (Air)</td>
                                    <td>Mumbai, MH (400001)</td>
                                    <td>0.85 kg</td>
                                    <td><span class="adm-badge info">In Transit</span></td>
                                    <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.sendOrderWhatsApp('ORD-9842')">Track</button></td>
                                </tr>
                                <tr>
                                    <td><code>TCI FREIGHT: TCI-66291</code></td>
                                    <td><strong>ORD-9841</strong></td>
                                    <td>TCI B2B Surface Heavy</td>
                                    <td>Surat, GJ (395002)</td>
                                    <td>18.50 kg (Lot)</td>
                                    <td><span class="adm-badge gold">Packed &amp; Manifested</span></td>
                                    <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.sendOrderWhatsApp('ORD-9841')">Track</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 13: PAYMENTS & FINANCIAL SETTLEMENTS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-payments">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Payments &amp; Financial Ledger</span>
                            <span class="adm-badge green">● Gateway Active</span>
                        </h1>
                        <p class="adm-page-subtitle">Track incoming UPI, NetBanking, RTGS transfers, COD remittances, and reseller commission payouts.</p>
                    </div>
                    <div class="adm-page-actions">
                        <button class="adm-btn-secondary" onclick="window.exportCurrentTable('payment_transactions')">📤 Export Ledger</button>
                    </div>
                </div>

                <div class="adm-prod-subnav-strip">
                    <a href="/admin/payments/" class="adm-prod-pill active"><span>💳 All Transactions</span></a>
                    <a href="/admin/payments/successful.php" class="adm-prod-pill"><span>✅ Successful</span></a>
                    <a href="/admin/payments/pending.php" class="adm-prod-pill"><span>⏳ Pending Verification</span></a>
                    <a href="/admin/payments/refunds.php" class="adm-prod-pill"><span>🔄 Refunds</span></a>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Order Reference</th>
                                    <th>Customer / Business</th>
                                    <th>Payment Mode</th>
                                    <th>Amount (₹)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>TXN-90218273</code></td>
                                    <td>ORD-9842</td>
                                    <td>Ananya Sharma</td>
                                    <td>UPI (Razorpay)</td>
                                    <td><strong>₹4,899</strong></td>
                                    <td><span class="adm-badge success">Captured</span></td>
                                </tr>
                                <tr>
                                    <td><code>RTGS-SURAT-8910</code></td>
                                    <td>ORD-9841</td>
                                    <td>Vardhman Textiles</td>
                                    <td>Bank RTGS Direct</td>
                                    <td><strong style="color:#8A681F;">₹33,576</strong></td>
                                    <td><span class="adm-badge success">Settled</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 14: MARKETING & CAMPAIGNS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-marketing">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Marketing &amp; Promotional Campaigns</span>
                        </h1>
                        <p class="adm-page-subtitle">Run flash sales, configure festive banner sliders, and distribute WhatsApp promo codes.</p>
                    </div>
                    <div class="adm-page-actions">
                        <a href="/admin/marketing/banners.php" class="adm-btn-secondary">🖼️ Homepage Banners</a>
                        <a href="/admin/marketing/coupons.php" class="adm-btn-primary">+ Create Coupon</a>
                    </div>
                </div>

                <div class="adm-prod-subnav-strip">
                    <a href="/admin/marketing/" class="adm-prod-pill active"><span>📢 All Campaigns</span></a>
                    <a href="/admin/marketing/banners.php" class="adm-prod-pill"><span>🖼️ Banners</span></a>
                    <a href="/admin/marketing/coupons.php" class="adm-prod-pill"><span>🎟️ Coupons</span></a>
                    <a href="/admin/marketing/campaigns.php" class="adm-prod-pill"><span>⚡ Flash Sales</span></a>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Coupon Code</th>
                                    <th>Discount Value</th>
                                    <th>Min Order Value</th>
                                    <th>Applicable Category</th>
                                    <th>Usage Count</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code style="font-weight:800; color:#8A681F; font-size:0.9rem;">FESTIVE2026</code></td>
                                    <td>15% Off (Max ₹1,500)</td>
                                    <td>₹2,999</td>
                                    <td>Silk Sarees &amp; Kurtis</td>
                                    <td>148 times</td>
                                    <td><span class="adm-badge success">Active</span></td>
                                </tr>
                                <tr>
                                    <td><code style="font-weight:800; color:#8A681F; font-size:0.9rem;">B2BVIPBULK</code></td>
                                    <td>Flat ₹3,000 Off</td>
                                    <td>₹25,000</td>
                                    <td>Wholesale Catalog Lots</td>
                                    <td>42 times</td>
                                    <td><span class="adm-badge gold">VIP B2B</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 15: CMS & STOREFRONT PAGES
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-cms">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>CMS &amp; Storefront Content Manager</span>
                        </h1>
                        <p class="adm-page-subtitle">Manage homepage hero announcements, brand story, contact address, and legal policies.</p>
                    </div>
                    <div class="adm-page-actions">
                        <a href="/admin/cms/homepage.php" class="adm-btn-primary">✏️ Edit Homepage Content</a>
                    </div>
                </div>

                <div class="adm-prod-subnav-strip">
                    <a href="/admin/cms/" class="adm-prod-pill active"><span>📄 All Pages</span></a>
                    <a href="/admin/cms/homepage.php" class="adm-prod-pill"><span>🏠 Homepage</span></a>
                    <a href="/admin/cms/about.php" class="adm-prod-pill"><span>📖 About DT Brand's</span></a>
                    <a href="/admin/cms/contact.php" class="adm-prod-pill"><span>📞 Contact &amp; Mills</span></a>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Page Title</th>
                                    <th>URL Route</th>
                                    <th>Last Updated</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Homepage &amp; Hero Sliders</strong></td>
                                    <td><code>/index.php</code></td>
                                    <td>Today, 02:00 PM</td>
                                    <td><span class="adm-badge success">Live</span></td>
                                    <td><a href="/admin/cms/homepage.php" class="adm-btn-secondary adm-btn-sm">Edit</a></td>
                                </tr>
                                <tr>
                                    <td><strong>About Heritage &amp; Weaving Mills</strong></td>
                                    <td><code>/Frontend/Home/about.php</code></td>
                                    <td>12 Aug 2026</td>
                                    <td><span class="adm-badge success">Live</span></td>
                                    <td><a href="/admin/cms/about.php" class="adm-btn-secondary adm-btn-sm">Edit</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 16: MEDIA LIBRARY & ASSET ASSETS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-media">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Media Library &amp; High-Res Assets</span>
                            <span class="adm-badge gold">480 Photos</span>
                        </h1>
                        <p class="adm-page-subtitle">Centralized media asset vault with WebP compression and instant CDN delivery.</p>
                    </div>
                    <div class="adm-page-actions">
                        <a href="/admin/media/upload.php" class="adm-btn-primary">📤 Upload New Media</a>
                    </div>
                </div>

                <div class="adm-prod-subnav-strip">
                    <a href="/admin/media/" class="adm-prod-pill active"><span>🖼️ All Media</span></a>
                    <a href="/admin/media/upload.php" class="adm-prod-pill"><span>📤 Upload Media</span></a>
                    <a href="/admin/media/gallery.php" class="adm-prod-pill"><span>📸 Gallery Folders</span></a>
                </div>

                <div class="dt-media-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(140px, 1fr)); gap:14px;">
                    <div class="adm-card" style="padding:8px; text-align:center;">
                        <img src="/assets/images/product1.png" style="width:100%; height:110px; object-fit:cover; border-radius:6px;">
                        <div style="font-size:0.7rem; font-weight:700; margin-top:6px;">product1.png</div>
                    </div>
                    <div class="adm-card" style="padding:8px; text-align:center;">
                        <img src="/assets/images/product2.png" style="width:100%; height:110px; object-fit:cover; border-radius:6px;">
                        <div style="font-size:0.7rem; font-weight:700; margin-top:6px;">product2.png</div>
                    </div>
                    <div class="adm-card" style="padding:8px; text-align:center;">
                        <img src="/assets/images/product3.png" style="width:100%; height:110px; object-fit:cover; border-radius:6px;">
                        <div style="font-size:0.7rem; font-weight:700; margin-top:6px;">product3.png</div>
                    </div>
                    <div class="adm-card" style="padding:8px; text-align:center;">
                        <img src="/assets/images/product4.png" style="width:100%; height:110px; object-fit:cover; border-radius:6px;">
                        <div style="font-size:0.7rem; font-weight:700; margin-top:6px;">product4.png</div>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 17: NOTIFICATIONS & BROADCAST ALERTS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-notifications">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Notifications &amp; Alerts Dispatch</span>
                        </h1>
                        <p class="adm-page-subtitle">Configure automated WhatsApp alerts, email receipts, and admin system triggers.</p>
                    </div>
                </div>

                <div class="adm-prod-subnav-strip">
                    <a href="/admin/notifications/" class="adm-prod-pill active"><span>🔔 All Alerts</span></a>
                    <a href="/admin/notifications/templates.php" class="adm-prod-pill"><span>📝 Message Templates</span></a>
                    <a href="/admin/notifications/push.php" class="adm-prod-pill"><span>📲 Push Notifications</span></a>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Trigger Event</th>
                                    <th>Notification Channel</th>
                                    <th>Recipients</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>New Order Received</strong></td>
                                    <td>WhatsApp + Admin Audio Chime</td>
                                    <td>Admin &amp; Customer</td>
                                    <td><span class="adm-badge success">Active</span></td>
                                    <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Template editor...')">Edit</button></td>
                                </tr>
                                <tr>
                                    <td><strong>Consignment Dispatched (AWB)</strong></td>
                                    <td>WhatsApp Automated Tracking Link</td>
                                    <td>Buyer Phone</td>
                                    <td><span class="adm-badge success">Active</span></td>
                                    <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Template editor...')">Edit</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 18: USERS & PERMISSION ROLES
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-users">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Admin Users &amp; Role-Based Access</span>
                        </h1>
                        <p class="adm-page-subtitle">Manage staff access permissions for catalog management, order processing, and accounting.</p>
                    </div>
                    <div class="adm-page-actions">
                        <a href="/admin/users/admins.php" class="adm-btn-primary">+ Add Staff Member</a>
                    </div>
                </div>

                <div class="adm-prod-subnav-strip">
                    <a href="/admin/users/" class="adm-prod-pill active"><span>👥 Staff Users</span></a>
                    <a href="/admin/users/roles.php" class="adm-prod-pill"><span>🛡️ Permission Roles</span></a>
                    <a href="/admin/users/activity-logs.php" class="adm-prod-pill"><span>📜 Audit Logs</span></a>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Email / Phone</th>
                                    <th>Role</th>
                                    <th>Last Login</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Gautam Sethi</strong></td>
                                    <td>gautam@jaihanumantex.in</td>
                                    <td><span class="adm-badge gold">Super Admin</span></td>
                                    <td>Active Now</td>
                                    <td><span class="adm-badge success">Active</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Surat Catalog Team</strong></td>
                                    <td>catalog@jaihanumantex.in</td>
                                    <td><span class="adm-badge info">Catalog Manager</span></td>
                                    <td>Today, 11:15 AM</td>
                                    <td><span class="adm-badge success">Active</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 19: SYSTEM HEALTH & DATABASE
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-system">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>System Health, Database &amp; APIs</span>
                            <span class="adm-badge green">● All Systems Nominal</span>
                        </h1>
                        <p class="adm-page-subtitle">Monitor server response time, MySQL database connections, and create instant backup snapshots.</p>
                    </div>
                    <div class="adm-page-actions">
                        <button class="adm-btn-primary" onclick="window.showToast('⚡ Database Backup Snapshot Created (backup_2026.sql)!')">💾 Backup Database Now</button>
                    </div>
                </div>

                <div class="adm-prod-subnav-strip">
                    <a href="/admin/system/" class="adm-prod-pill active"><span>🖥️ Server Status</span></a>
                    <a href="/admin/system/health.php" class="adm-prod-pill"><span>❤️ Health Check</span></a>
                    <a href="/admin/system/database.php" class="adm-prod-pill"><span>🗄️ MySQL Database</span></a>
                    <a href="/admin/system/backups.php" class="adm-prod-pill"><span>💾 Backups &amp; Snapshots</span></a>
                </div>

                <div class="adm-kpi-grid">
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top"><span class="adm-kpi-label">PHP Engine</span><div class="adm-kpi-icon-box purple">🐘</div></div>
                        <div class="adm-kpi-val">PHP 8.2+</div>
                        <div class="adm-kpi-bottom"><span class="adm-badge success">OPcache Enabled</span></div>
                    </div>
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top"><span class="adm-kpi-label">Database Storage</span><div class="adm-kpi-icon-box blue">🗄️</div></div>
                        <div class="adm-kpi-val">24.5 MB</div>
                        <div class="adm-kpi-bottom"><span class="adm-badge gold">MySQL InnoDB</span></div>
                    </div>
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top"><span class="adm-kpi-label">Server Uptime</span><div class="adm-kpi-icon-box green">⚡</div></div>
                        <div class="adm-kpi-val">99.98%</div>
                        <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Hostinger Cloud</span></div>
                    </div>
                </div>
            </section>

        </main>

        <!-- ══ BOTTOM STATUS FOOTER ══ -->
        <?php include_once __DIR__ . '/Includes/adminfooter.php'; ?>

    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     MODAL: ADD / EDIT PRODUCT
════════════════════════════════════════════════════════════ -->
<div class="adm-modal-backdrop" id="admProductModal">
    <div class="adm-modal-box">
        <div class="adm-modal-head">
            <h3 class="adm-modal-title" id="admProductModalTitle">Add New Product</h3>
            <button type="button" class="adm-modal-close-btn" onclick="closeAdmModal('admProductModal')">✕</button>
        </div>
        <form onsubmit="saveProductForm(event)">
            <div class="adm-modal-body">
                <input type="hidden" id="admProductId">
                <div class="adm-form-grid">
                    <div class="adm-form-group full">
                        <label class="adm-form-label">Product Title *</label>
                        <input type="text" id="admProductName" class="adm-form-input" placeholder="e.g. Pure Kanjivaram Bridal Art Silk Saree" required>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">SKU Code *</label>
                        <input type="text" id="admProductSku" class="adm-form-input" placeholder="KLN-SR-112" required>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">HSN Code *</label>
                        <input type="text" id="admProductHsn" class="adm-form-input" placeholder="5007" required>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Category *</label>
                        <select id="admProductCategory" class="adm-form-select">
                            <option value="Sarees">Sarees</option>
                            <option value="Kurtis">Kurtis</option>
                            <option value="Lehengas">Lehengas</option>
                            <option value="Gowns">Gowns</option>
                            <option value="Dress Materials">Dress Materials</option>
                        </select>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Fabric Specification</label>
                        <input type="text" id="admProductFabric" class="adm-form-input" placeholder="Pure Silk / Georgette / Rayon">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">B2C Retail Price (₹) *</label>
                        <input type="number" id="admProductRetailPrice" class="adm-form-input" placeholder="3499" required>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">B2B Wholesale Price (₹) *</label>
                        <input type="number" id="admProductWholesalePrice" class="adm-form-input" placeholder="1399" required>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Minimum Order Qty (MOQ)</label>
                        <input type="number" id="admProductMoq" class="adm-form-input" placeholder="8" value="8">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Available Stock (Units)</label>
                        <input type="number" id="admProductStock" class="adm-form-input" placeholder="100" value="50">
                    </div>
                    <div class="adm-form-group full">
                        <label class="adm-form-label">Stock Status</label>
                        <select id="admProductStatus" class="adm-form-select">
                            <option value="In Stock">In Stock</option>
                            <option value="Low Stock">Low Stock</option>
                            <option value="Out of Stock">Out of Stock</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="adm-modal-foot">
                <button type="button" class="adm-btn-secondary" onclick="closeAdmModal('admProductModal')">Cancel</button>
                <button type="submit" class="adm-btn-primary">Save Product</button>
            </div>
        </form>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     MODAL: GST INVOICE VIEW & PRINT
════════════════════════════════════════════════════════════ -->
<div class="adm-modal-backdrop" id="admInvoiceModal">
    <div class="adm-modal-box" style="max-width:620px;">
        <div class="adm-modal-head">
            <h3 class="adm-modal-title">Tax Invoice — DT Brand's</h3>
            <button type="button" class="adm-modal-close-btn" onclick="closeAdmModal('admInvoiceModal')">✕</button>
        </div>
        <div class="adm-modal-body" style="background:#FFFFFF; font-size:0.84rem;">
            <div style="display:flex; justify-content:space-between; border-bottom:1.5px solid #8A681F; padding-bottom:12px;">
                <div>
                    <h2 style="font-family:var(--adm-font-serif); color:#8A681F; font-size:1.2rem;">DT BRAND'S</h2>
                    <p style="font-size:0.72rem; color:#7A7266;">Jai Hanuman Tex • GSTIN: 24AAACR4920M1Z2<br>Ring Road, Surat, Gujarat</p>
                </div>
                <div style="text-align:right;">
                    <strong>Invoice #: <span id="invOrderNumber">ORD-9842</span></strong><br>
                    <small style="color:#7A7266;">Date: <span id="invOrderDate">Today</span></small>
                </div>
            </div>

            <div style="margin-top:12px; display:flex; justify-content:space-between;">
                <div>
                    <strong style="color:#8A681F; font-size:0.76rem; text-transform:uppercase;">Billed To:</strong><br>
                    <strong id="invCustomerName">Customer Name</strong><br>
                    <span id="invCustomerPhone">+91 7046363528</span><br>
                    <span id="invCustomerCity">City, State</span>
                </div>
                <div style="text-align:right;">
                    <strong style="color:#8A681F; font-size:0.76rem; text-transform:uppercase;">Payment:</strong><br>
                    <span>Status: <strong>PAID</strong></span>
                </div>
            </div>

            <div style="margin-top:16px; border-top:1px solid #E5E1D7; padding-top:12px;">
                <table style="width:100%; font-size:0.8rem; border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid #E5E1D7; color:#7A7266; text-align:left;">
                            <th style="padding:6px 0;">Item Description</th>
                            <th style="padding:6px 0; text-align:right;">Amount (INR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding:10px 0;" id="invItemDesc">Product Name</td>
                            <td style="padding:10px 0; text-align:right;" id="invItemTotal">₹4,899</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="border-top:1.5px solid #8A681F; font-weight:800; font-size:0.95rem;">
                            <td style="padding:10px 0;">Grand Total (Incl. GST):</td>
                            <td style="padding:10px 0; text-align:right; color:#8A681F;" id="invGrandTotal">₹4,899</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="adm-modal-foot">
            <button type="button" class="adm-btn-secondary" onclick="window.print()">🖨️ Print Invoice</button>
            <button type="button" class="adm-btn-primary" onclick="closeAdmModal('admInvoiceModal')">Close</button>
        </div>
    </div>
</div>

<!--
     Real dashboard series for the canvas charts. Before this existed,
     renderRefSalesChart(), renderRevenueChart() and renderCategoryDoughnut() in
     admin.js each drew from hardcoded arrays, so the Sales Analytics, Revenue
     Analytics and Category Breakdown graphs were identical on every install and
     contradicted the KPI numbers printed right above them.
-->
<script>window.DT_DASH = <?php echo json_encode($dashPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;</script>

<!-- Admin JavaScript Engine -->
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>

</body>
</html>
