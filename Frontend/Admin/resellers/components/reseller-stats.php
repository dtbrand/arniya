<?php
/**
 * reseller-stats.php — 8-Card Master KPI Ribbon + Flow Filter Pills
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$active_filter = isset($active_filter) ? $active_filter : 'all';
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
        <div class="dt-cust-kpi-val">348</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">↑ +24 this month</span>
            <span style="color:#78716C;">Across 22 States</span>
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
        <div class="dt-cust-kpi-val" style="color:#15803D;">296</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">85.1% Active</span>
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
        <div class="dt-cust-kpi-val" style="color:#B45309;">24</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta down">Needs Staff KYC</span>
            <span style="color:#B45309;">Queue</span>
        </div>
    </div>

    <!-- Card 4: Orders This Month -->
    <div class="dt-cust-kpi-card" onclick="filterResellersByStatus('orders', this)">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">ORDERS THIS MONTH</span>
            <div class="dt-cust-kpi-icon purple">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#7E22CE;">842</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">↑ +18.4% MoM</span>
            <span style="color:#7E22CE;">Fast Velocity</span>
        </div>
    </div>

    <!-- Card 5: Reseller GMV Volume -->
    <div class="dt-cust-kpi-card" onclick="filterResellersByStatus('all', this)">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">GROSS GMV VOLUME</span>
            <div class="dt-cust-kpi-icon gold">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val">₹48.6L</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">Avg AOV ₹14.2K</span>
            <span style="color:#8A681F;">B2B Wholesale</span>
        </div>
    </div>

    <!-- Card 6: Utilized Credit -->
    <div class="dt-cust-kpi-card" onclick="filterResellersByStatus('credit', this)">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">OUTSTANDING CREDIT</span>
            <div class="dt-cust-kpi-icon emerald">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#15803D;">₹8.42L</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">98% On-Time Settle</span>
            <span style="color:#15803D;">Revolving Line</span>
        </div>
    </div>

    <!-- Card 7: Suspended Accounts -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'suspended' ? 'active' : ''; ?>" onclick="filterResellersByStatus('suspended', this)">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">SUSPENDED / LOCKED</span>
            <div class="dt-cust-kpi-icon amber">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#78716C;">12</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta muted">3.4% Locked</span>
            <span style="color:#8A681F;">Credit Breach</span>
        </div>
    </div>

    <!-- Card 8: Luxury Ambient Dark Card - Platinum Elite Partners -->
    <div class="dt-cust-kpi-card dark-card" onclick="filterResellersByStatus('platinum', this)">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">PLATINUM ELITE VIP</span>
            <div class="dt-cust-kpi-icon gold" style="background:#FAF5E8; border:1px solid #D4AF37;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#D4AF37;">42</div>
        <div class="dt-cust-kpi-bot">
            <span style="color:#D4AF37; font-weight:800;">GMV > ₹5,00,000</span>
            <span style="color:#FAF5E8;">Top 12.1%</span>
        </div>
    </div>
</div>

<!-- ══ STATUS FLOW FILTER PILLS ══ -->
<div class="dt-cust-filter-strip" id="dtResellerFilterStrip" style="transition:all 0.3s ease;">
    <button type="button" class="dt-cust-pill-btn active" onclick="filterResellersByStatus('all', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        <span>All Resellers</span>
        <span class="dt-cust-pill-count">348</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterResellersByStatus('approved', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <span>Active Verified</span>
        <span class="dt-cust-pill-count">296</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterResellersByStatus('pending', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
        <span>Pending Applications</span>
        <span class="dt-cust-pill-count" style="background:#FEF3C7; color:#B45309;">24</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterResellersByStatus('platinum', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        <span>Platinum Elite (30% Margin)</span>
        <span class="dt-cust-pill-count">42</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterResellersByStatus('credit', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
        <span>With Credit Line</span>
        <span class="dt-cust-pill-count">112</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterResellersByStatus('suspended', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        <span>Suspended</span>
        <span class="dt-cust-pill-count">12</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterResellersByStatus('rejected', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        <span>Rejected</span>
        <span class="dt-cust-pill-count">16</span>
    </button>
</div>
