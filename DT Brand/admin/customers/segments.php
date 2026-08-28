<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * segments.php - Live Cohort Builder
 * DT Brand's & Jai Hanuman Tex - Live Production Standard
 *
 * This page used to show six "dynamic segments" with invented audiences -
 * 312 VIP spenders, 1,240 Gujarat shoppers, 890 wholesale lot orderers, 486
 * "International & NRI Buyers" matched on "Country != India" over a table with
 * no country column, and 512 "Festive Silk Repeaters" matched on "Tags = Saree
 * Lover" with no tags table. Each card offered Sync ("Audience synced! Live
 * records updated in real-time.") and a WhatsApp broadcast to a number of
 * people that was a PHP literal.
 *
 * The New Segment modal was worse: it appended a card whose audience size came
 * from Math.floor(Math.random() * 450) + 120 and toasted 'Segment "X" created
 * with live cohort tracking!'. A staff member could size a festive campaign
 * from a random number and lose the segment on reload.
 *
 * There is no segments table, so nothing here can be saved - and this page no
 * longer pretends otherwise. It is now a builder: criteria are matched against
 * the real customers table, the count is the count, the preview lists the
 * actual people, and the cohort can be exported or its phone numbers copied.
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/CustomerManager.php';

use DTBrand\Database;
use DTBrand\CustomerManager;

$customers = CustomerManager::getAll();

// Dormancy needs the newest order per customer; `customers` carries no such
// column. One grouped query rather than a lookup per row.
$lastOrders = [];
$pdo = Database::getConnection();
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $q = $pdo->query("SELECT `customer_id`, MAX(`created_at`) AS `last_order` FROM `orders` GROUP BY `customer_id`");
        foreach (($q ? $q->fetchAll(\PDO::FETCH_ASSOC) : []) as $r) {
            $lastOrders[(int)$r['customer_id']] = (string)$r['last_order'];
        }
    } catch (\Exception $e) {
        // Unreadable order history: every customer then counts as never having
        // ordered, which is what "no order on record" means.
    }
}

$segRows = [];
$statesSeen = [];
$tiersSeen  = [];
foreach ($customers as $c) {
    $state = trim((string)($c['state'] ?? ''));
    $tier  = trim((string)($c['tier'] ?? ''));
    if ($state !== '') { $statesSeen[strtoupper($state)] = $state; }
    if ($tier !== '')  { $tiersSeen[strtolower($tier)] = $tier; }

    $segRows[] = [
        'id'      => (int)$c['id'],
        'name'    => (string)($c['name'] ?? ''),
        'phone'   => (string)($c['phone'] ?? ''),
        'email'   => (string)($c['email'] ?? ''),
        'city'    => (string)($c['city'] ?? ''),
        'state'   => $state,
        'type'    => (string)($c['type'] ?? 'retail'),
        'tier'    => $tier,
        'status'  => (string)($c['status'] ?? 'active'),
        'spend'   => (float)($c['lifetime_spend'] ?? 0),
        'orders'  => (int)($c['total_orders'] ?? 0),
        'gstin'   => trim((string)($c['gstin'] ?? '')),
        'balance' => (float)($c['outstanding_balance'] ?? 0),
        'last'    => $lastOrders[(int)$c['id']] ?? '',
    ];
}
ksort($statesSeen);
ksort($tiersSeen);

$page_title = "Live Cohort Builder";
$active_nav = "customers";
$active_subnav = "segments";
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
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-segments.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container">
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Live Cohort Builder</span>
                            <span class="dt-cust-badge gold"><?php echo number_format(count($segRows)); ?> Customer<?php echo count($segRows) === 1 ? '' : 's'; ?></span>
                        </h1>
                        <p class="dt-cust-subtitle">Match criteria against the live customers table, see exactly who qualifies, then export the cohort or copy its phone numbers.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale" style="display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>All Customers</span>
                        </a>
                        <a href="/admin/customers/tags.php" class="dt-btn dt-btn-pale" style="display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                            <span>Labels &amp; Cohorts</span>
                        </a>
                    </div>
                </div>

                <?php include __DIR__ . '/components/customer-segments.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
    // The whole cohort engine runs against these rows. They come from the
    // customers table plus one grouped orders query -- nothing is generated.
    window.dtSegmentRows = <?php echo json_encode($segRows, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); ?>;
</script>
<script src="/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/customers/assets/js/customer-segments.js?v=<?php echo time(); ?>"></script>
</body>
</html>
