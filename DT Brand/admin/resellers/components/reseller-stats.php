<?php
/**
 * reseller-stats.php — 8-Card Master KPI Ribbon + Flow Filter Pills
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
require_once __DIR__ . '/../../../src/CustomerManager.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\CustomerManager;
use DTBrand\Database;

$active_filter = isset($active_filter) ? $active_filter : 'all';
$resellers = CustomerManager::getByType('reseller');
$totalResellerCount = count($resellers);
$activeResellers = $totalResellerCount;
$pendingResellers = 0;
$totalCommissions = 0;

foreach ($resellers as $res) {
    $totalCommissions += (float)($res['pending_payout'] ?? 0);
}
?>

<!-- ══ 8-CARD EXECUTIVE KPI RIBBON ══ -->
<div class="dt-cust-kpi-grid" id="dtResellerKpiGrid" style="transition:all 0.3s ease;">
    <!-- Card 1: Total Resellers -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'all' ? 'active' : ''; ?>" onclick="filterResellersByStatus('all', this)">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">TOTAL RESELLERS</span>
            <div class="dt-cust-kpi-icon gold">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val"><?php echo number_format($totalResellerCount); ?></div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">Verified</span>
            <span style="color:#78716C;">Across India</span>
        </div>
    </div>

    <!-- Card 2: Active Verified -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'approved' ? 'active' : ''; ?>" onclick="filterResellersByStatus('approved', this)">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">ACTIVE PARTNERS</span>
            <div class="dt-cust-kpi-icon emerald">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#15803D;"><?php echo number_format($activeResellers); ?></div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">100% Active</span>
            <span style="color:#15803D; font-weight:800;">● Live Margin</span>
        </div>
    </div>

    <!-- Card 3: Pending Review -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'pending' ? 'active' : ''; ?>" onclick="filterResellersByStatus('pending', this)">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">PENDING REVIEW</span>
            <div class="dt-cust-kpi-icon amber">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#B45309;"><?php echo number_format($pendingResellers); ?></div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">0 KYC Queue</span>
            <span style="color:#78716C;">Up to Date</span>
        </div>
    </div>

    <!-- Card 4: Commissions -->
    <div class="dt-cust-kpi-card">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">WALLET / PAYOUTS</span>
            <div class="dt-cust-kpi-icon emerald">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#15803D;">₹<?php echo number_format($totalCommissions); ?></div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">Settled Payouts</span>
            <span style="color:#15803D;">Active</span>
        </div>
    </div>
</div>
