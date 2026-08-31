<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-stats.php — 8-Card Master KPI Ribbon + Flow Filter Pills
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
require_once __DIR__ . '/../../../src/CustomerManager.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\CustomerManager;
use DTBrand\Database;

$active_filter = isset($active_filter) ? $active_filter : 'all';
// Reuse the list the including page already read rather than reading the whole
// customers table a second time on every page load.
$cust_list = (isset($customersList) && is_array($customersList)) ? $customersList : CustomerManager::getAll();
$totalCust = count($cust_list);

// Counted from the real status column. This used to read
// "$activeCust = $totalCust; $dormantCust = 0;", which asserted that every
// customer was active and none dormant -- so a suspended account or a trade
// application still awaiting approval was reported as a healthy live shopper.
$activeCust = 0;
$pendingCust = 0;
$suspendedCust = 0;
$wholesaleCust = 0;
$resellerCust = 0;
$retailCust = 0;
$totalLifetimeSpend = 0;

foreach ($cust_list as $c) {
    switch ($c['status'] ?? 'active') {
        case 'active':    $activeCust++;    break;
        case 'pending':   $pendingCust++;   break;
        case 'suspended': $suspendedCust++; break;
    }
    switch ($c['type'] ?? 'retail') {
        case 'wholesale': $wholesaleCust++; break;
        case 'reseller':  $resellerCust++;  break;
        default:          $retailCust++;    break;
    }
    $totalLifetimeSpend += (float)($c['lifetime_spend'] ?? 0);
}

$activePct = $totalCust > 0 ? round(($activeCust / $totalCust) * 100) : 0;
$tradeCust = $wholesaleCust + $resellerCust;
?>

<!-- ══ 8-CARD EXECUTIVE KPI RIBBON ══ -->
<!--
  data-filter marks the cards that act as filter tabs, and data-default-filter
  records which one this page opens on. Clicking a card filtered the table but
  the gold highlight never moved -- it was fixed at page load by PHP -- so an
  admin on index.php who clicked "Wholesale B2B" saw a wholesale-only list with
  "Total Shoppers" still highlighted, and no way to tell which cohort was on
  screen. customer-list.js now moves the highlight with the list.
-->
<div class="dt-cust-kpi-grid" data-default-filter="<?php echo htmlspecialchars($active_filter); ?>">
    <!-- Card 1: Total Customers -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'all' ? 'active' : ''; ?>" data-filter="all" onclick="filterCustomersByStatus('all')">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">TOTAL SHOPPERS</span>
            <div class="dt-cust-kpi-icon gold">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val"><?php echo number_format($totalCust); ?></div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta"><?php echo number_format($retailCust); ?> retail</span>
            <span style="color:#78716C;"><?php echo number_format($tradeCust); ?> trade</span>
        </div>
    </div>

    <!-- Card 2: Active Verified -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'active' ? 'active' : ''; ?>" data-filter="active" onclick="filterCustomersByStatus('active')">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">ACTIVE ACCOUNTS</span>
            <div class="dt-cust-kpi-icon emerald">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#15803D;"><?php echo number_format($activeCust); ?></div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta"><?php echo $activePct; ?>% of shoppers</span>
            <span style="color:#15803D; font-weight:800;">● Can sign in</span>
        </div>
    </div>

    <!-- Card 3: Suspended, with the pending-approval backlog beside it -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'inactive' ? 'active' : ''; ?>" data-filter="suspended" onclick="filterCustomersByStatus('suspended')">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">SUSPENDED</span>
            <div class="dt-cust-kpi-icon amber">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#B45309;"><?php echo number_format($suspendedCust); ?></div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">Cannot sign in</span>
            <?php if ($pendingCust > 0): ?>
                <a href="/admin/customers/pending.php" onclick="event.stopPropagation();" style="color:#8A681F; font-weight:800; text-decoration:none;">
                    <?php echo number_format($pendingCust); ?> awaiting approval →
                </a>
            <?php else: ?>
                <span style="color:#78716C;">No pending applications</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Card 4: Wholesale Partners -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'wholesale' ? 'active' : ''; ?>" data-filter="wholesale" onclick="filterCustomersByStatus('wholesale')">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">WHOLESALE B2B</span>
            <div class="dt-cust-kpi-icon gold">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#8A681F;"><?php echo number_format($wholesaleCust); ?></div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">Depot Accounts</span>
            <span style="color:#78716C;">Tier 1</span>
        </div>
    </div>

    <!-- Card 5: Resellers -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'reseller' ? 'active' : ''; ?>" data-filter="reseller" onclick="filterCustomersByStatus('reseller')">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">VIP RESELLERS</span>
            <div class="dt-cust-kpi-icon purple">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#7E22CE;"><?php echo number_format($resellerCust); ?></div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">WhatsApp Partners</span>
            <span style="color:#78716C;">Active</span>
        </div>
    </div>

    <!-- Card 6: Cumulative Spend -->
    <div class="dt-cust-kpi-card">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">LIFETIME GMV</span>
            <div class="dt-cust-kpi-icon emerald">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#15803D;">₹<?php echo number_format($totalLifetimeSpend); ?></div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">Sum of lifetime_spend</span>
            <span style="color:#78716C;">Across <?php echo number_format($totalCust); ?> accounts</span>
        </div>
    </div>
</div>
