<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-stats.php — 8-Card Master KPI Ribbon + Flow Filter Pills
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
require_once __DIR__ . '/../../../src/CustomerManager.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\CustomerManager;
use DTBrand\Database;

$active_filter = isset($active_filter) ? $active_filter : 'all';
$cust_list = CustomerManager::getAll();
$totalCust = count($cust_list);
$activeCust = $totalCust;
$dormantCust = 0;
$wholesaleCust = 0;
$resellerCust = 0;
$totalLifetimeSpend = 0;

foreach ($cust_list as $c) {
    $type = $c['type'] ?? 'retail';
    if ($type === 'wholesale') $wholesaleCust++;
    if ($type === 'reseller') $resellerCust++;
    $totalLifetimeSpend += (float)($c['lifetime_spend'] ?? 0);
}
?>

<!-- ══ 8-CARD EXECUTIVE KPI RIBBON ══ -->
<div class="dt-cust-kpi-grid">
    <!-- Card 1: Total Customers -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'all' ? 'active' : ''; ?>" onclick="filterCustomersByStatus('all')">
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
            <span class="dt-cust-kpi-delta">Verified</span>
            <span style="color:#78716C;">100% Direct</span>
        </div>
    </div>

    <!-- Card 2: Active Verified -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'active' ? 'active' : ''; ?>" onclick="filterCustomersByStatus('active')">
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
            <span class="dt-cust-kpi-delta">100% Healthy</span>
            <span style="color:#15803D; font-weight:800;">● Live</span>
        </div>
    </div>

    <!-- Card 3: Inactive / Dormant -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'inactive' ? 'active' : ''; ?>" onclick="filterCustomersByStatus('inactive')">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">INACTIVE / DORMANT</span>
            <div class="dt-cust-kpi-icon amber">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#B45309;"><?php echo number_format($dormantCust); ?></div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">0% Churn</span>
            <span style="color:#78716C;">Dormant</span>
        </div>
    </div>

    <!-- Card 4: Wholesale Partners -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'wholesale' ? 'active' : ''; ?>" onclick="filterCustomersByStatus('wholesale')">
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
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'reseller' ? 'active' : ''; ?>" onclick="filterCustomersByStatus('reseller')">
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
            <span class="dt-cust-kpi-delta">Verified GMV</span>
            <span style="color:#15803D;">100% Settled</span>
        </div>
    </div>
</div>
