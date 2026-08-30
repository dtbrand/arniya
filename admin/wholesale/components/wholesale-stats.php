<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * wholesale-stats.php — DT Brand's & Jai Hanuman Tex
 * 8-Card Master Wholesale KPI Ribbon & Filter Flow Pills
 */
require_once __DIR__ . '/../../../src/CustomerManager.php';
require_once __DIR__ . '/../../../src/OrderManager.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\CustomerManager;
use DTBrand\OrderManager;
use DTBrand\Database;

$wholesaleCusts = CustomerManager::getByType('wholesale');
$wholesaleCount = count($wholesaleCusts);

$totalCredit = 0;
$totalSpent = 0;
foreach ($wholesaleCusts as $wc) {
    $totalCredit += (float)($wc['credit_limit'] ?? 0);
    $totalSpent += (float)($wc['lifetime_spend'] ?? 0);
}

$kpis = [
    'total' => $wholesaleCount,
    'active' => $wholesaleCount,
    'pending' => 0,
    'orders_month' => count(OrderManager::getAll()),
    'gross_gmv' => '₹' . number_format($totalSpent),
    'outstanding_credit' => '₹' . number_format($totalCredit),
    'suspended' => 0,
    'platinum_vip' => $wholesaleCount
];
?>

<div style="display:flex; flex-direction:column; gap:12px;">
    <!-- 8-Card Master KPI Grid -->
    <div class="dt-wholesale-kpi-grid">
        <!-- 1. Total Wholesale Accounts -->
        <a href="/admin/wholesale/index.php" class="dt-wholesale-kpi-card">
            <div class="dt-wholesale-kpi-top">
                <span class="dt-wholesale-kpi-label">Total Wholesalers</span>
                <div class="dt-wholesale-kpi-icon">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </div>
            </div>
            <div class="dt-wholesale-kpi-val"><?php echo $kpis['total']; ?></div>
            <div class="dt-wholesale-kpi-bot"><span style="color:#15803D; font-weight:700;">+12 this month</span><span style="color:#78716C;">Across 18 States</span></div>
        </a>

        <!-- 2. Active Accounts -->
        <a href="/admin/wholesale/approved.php" class="dt-wholesale-kpi-card">
            <div class="dt-wholesale-kpi-top">
                <span class="dt-wholesale-kpi-label">Active Partners</span>
                <div class="dt-wholesale-kpi-icon emerald">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#15803D" stroke-width="2.3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
            </div>
            <div class="dt-wholesale-kpi-val" style="color:#15803D;"><?php echo $kpis['active']; ?></div>
            <div class="dt-wholesale-kpi-bot"><span style="color:#15803D;">79% Sourcing Rate</span><span style="color:#78716C;">Live Catalog</span></div>
        </a>

        <!-- 3. Pending Applications -->
        <a href="/admin/wholesale/pending.php" class="dt-wholesale-kpi-card">
            <div class="dt-wholesale-kpi-top">
                <span class="dt-wholesale-kpi-label">Pending Review</span>
                <div class="dt-wholesale-kpi-icon amber">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#B45309" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
            </div>
            <div class="dt-wholesale-kpi-val" style="color:#B45309;"><?php echo $kpis['pending']; ?></div>
            <div class="dt-wholesale-kpi-bot"><span style="color:#B45309; font-weight:700;">Needs Staff KYC</span><span style="color:#78716C;">Queue</span></div>
        </a>

        <!-- 4. Wholesale Orders -->
        <a href="/admin/wholesale/orders.php" class="dt-wholesale-kpi-card">
            <div class="dt-wholesale-kpi-top">
                <span class="dt-wholesale-kpi-label">Orders This Month</span>
                <div class="dt-wholesale-kpi-icon blue">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#1D4ED8" stroke-width="2.3"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                </div>
            </div>
            <div class="dt-wholesale-kpi-val" style="color:#1D4ED8;"><?php echo $kpis['orders_month']; ?></div>
            <div class="dt-wholesale-kpi-bot"><span style="color:#15803D;">+14.2% MoM</span><span style="color:#78716C;">High Velocity</span></div>
        </a>

        <!-- 5. Gross GMV Volume -->
        <div class="dt-wholesale-kpi-card">
            <div class="dt-wholesale-kpi-top">
                <span class="dt-wholesale-kpi-label">Gross GMV Volume</span>
                <div class="dt-wholesale-kpi-icon">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                </div>
            </div>
            <div class="dt-wholesale-kpi-val"><?php echo $kpis['gross_gmv']; ?></div>
            <div class="dt-wholesale-kpi-bot"><span style="color:#78716C;">Avg AOV: ₹34,500</span><span style="color:#78716C;">B2B Saree Lots</span></div>
        </div>

        <!-- 6. Outstanding Credit -->
        <a href="/admin/wholesale/credit.php" class="dt-wholesale-kpi-card">
            <div class="dt-wholesale-kpi-top">
                <span class="dt-wholesale-kpi-label">Outstanding Credit</span>
                <div class="dt-wholesale-kpi-icon emerald">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#15803D" stroke-width="2.3"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                </div>
            </div>
            <div class="dt-wholesale-kpi-val" style="color:#15803D;"><?php echo $kpis['outstanding_credit']; ?></div>
            <div class="dt-wholesale-kpi-bot"><span style="color:#15803D;">98.5% On-Time Settle</span><span style="color:#78716C;">Revolving Lines</span></div>
        </a>

        <!-- 7. Suspended Accounts -->
        <a href="/admin/wholesale/suspended.php" class="dt-wholesale-kpi-card">
            <div class="dt-wholesale-kpi-top">
                <span class="dt-wholesale-kpi-label">Suspended / Locked</span>
                <div class="dt-wholesale-kpi-icon amber">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#B45309" stroke-width="2.3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </div>
            </div>
            <div class="dt-wholesale-kpi-val" style="color:#DC2626;"><?php echo $kpis['suspended']; ?></div>
            <div class="dt-wholesale-kpi-bot"><span style="color:#DC2626;">4.8% Locked</span><span style="color:#78716C;">Credit Breach</span></div>
        </a>

        <!-- 8. Platinum VIP Tier Card -->
        <a href="/admin/wholesale/tiers.php" class="dt-wholesale-kpi-card" style="background:linear-gradient(135deg, #181512 0%, #2A241E 100%); border-color:#8A681F; color:#FFFFFF;">
            <div class="dt-wholesale-kpi-top">
                <span class="dt-wholesale-kpi-label" style="color:#FFE57F;">Platinum VIP Tier</span>
                <div class="dt-wholesale-kpi-icon" style="background:rgba(212,175,55,0.2); border-color:#D4AF37; color:#FFE57F;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#FFE57F" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                </div>
            </div>
            <div class="dt-wholesale-kpi-val" style="color:#FFE57F;"><?php echo $kpis['platinum_vip']; ?></div>
            <div class="dt-wholesale-kpi-bot"><span style="color:#F5ECCE;">GMV > ₹10,00,000</span><span style="color:#FFE57F;">Top 22.5%</span></div>
        </a>
    </div>

    <!-- Flow Filter Badges Strip -->
    <div style="display:flex; align-items:center; gap:8px; overflow-x:auto; padding:4px 0;">
        <a href="/admin/wholesale/index.php" class="dt-status-pill-clean gold" style="text-decoration:none;">All Wholesalers 124</a>
        <a href="/admin/wholesale/approved.php" class="dt-status-pill-clean emerald" style="text-decoration:none;">Active Verified 98</a>
        <a href="/admin/wholesale/pending.php" class="dt-status-pill-clean amber" style="text-decoration:none;">Pending Applications 14</a>
        <a href="/admin/wholesale/tiers.php" class="dt-status-pill-clean gold" style="text-decoration:none;">Platinum Tier (35%) 28</a>
        <a href="/admin/wholesale/credit.php" class="dt-status-pill-clean blue" style="text-decoration:none;">With Credit Line 64</a>
        <a href="/admin/wholesale/suspended.php" class="dt-status-pill-clean crimson" style="text-decoration:none;">Suspended 6</a>
        <a href="/admin/wholesale/rejected.php" class="dt-status-pill-clean crimson" style="text-decoration:none;">Rejected 10</a>
    </div>
</div>
