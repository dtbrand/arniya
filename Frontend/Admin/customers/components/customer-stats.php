<?php
/**
 * customer-stats.php — 8-Card Master KPI Ribbon + Flow Filter Pills
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$active_filter = isset($active_filter) ? $active_filter : 'all';
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
        <div class="dt-cust-kpi-val">4,820</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">↑ +348 this month</span>
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
        <div class="dt-cust-kpi-val" style="color:#15803D;">4,180</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">86.7% Healthy</span>
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
        <div class="dt-cust-kpi-val" style="color:#B45309;">640</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta down">13.3% Dormant</span>
            <span style="color:#B45309;">> 60 Days</span>
        </div>
    </div>

    <!-- Card 4: New Registrations -->
    <div class="dt-cust-kpi-card <?php echo $active_filter === 'new' ? 'active' : ''; ?>" onclick="filterCustomersByStatus('new')">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">NEW THIS MONTH</span>
            <div class="dt-cust-kpi-icon purple">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <line x1="19" y1="8" x2="19" y2="14"></line>
                    <line x1="22" y1="11" x2="16" y2="11"></line>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#7E22CE;">348</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">↑ +24.8% vs Mar</span>
            <span style="color:#7E22CE;">Fresh KYC</span>
        </div>
    </div>

    <!-- Card 5: Returning Shoppers -->
    <div class="dt-cust-kpi-card" onclick="filterCustomersByStatus('has_orders')">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">REPEAT BUYERS</span>
            <div class="dt-cust-kpi-icon gold">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <polyline points="17 1 21 5 17 9"></polyline>
                    <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                    <polyline points="7 23 3 19 7 15"></polyline>
                    <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val">1,850</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">38.4% Repeat Rate</span>
            <span style="color:#8A681F;">High Loyalty</span>
        </div>
    </div>

    <!-- Card 6: Customers with Orders -->
    <div class="dt-cust-kpi-card" onclick="filterCustomersByStatus('has_orders')">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">WITH ORDERS</span>
            <div class="dt-cust-kpi-icon emerald">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val">3,940</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta">81.7% Conversion</span>
            <span style="color:#15803D;">Active Buyers</span>
        </div>
    </div>

    <!-- Card 7: Without Orders -->
    <div class="dt-cust-kpi-card" onclick="filterCustomersByStatus('no_orders')">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">NO ORDERS YET</span>
            <div class="dt-cust-kpi-icon amber">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#78716C;">880</div>
        <div class="dt-cust-kpi-bot">
            <span class="dt-cust-kpi-delta muted">18.3% Abandoned</span>
            <span style="color:#8A681F;">Nudge Ready</span>
        </div>
    </div>

    <!-- Card 8: High Value VIPs -->
    <div class="dt-cust-kpi-card dark-card" onclick="filterCustomersByStatus('vip')">
        <div class="dt-cust-kpi-top">
            <span class="dt-cust-kpi-label">VIP HIGH-VALUE</span>
            <div class="dt-cust-kpi-icon gold" style="background:#FAF5E8; border:1px solid #D4AF37;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
        </div>
        <div class="dt-cust-kpi-val" style="color:#D4AF37;">312</div>
        <div class="dt-cust-kpi-bot">
            <span style="color:#D4AF37; font-weight:800;">LTV > ₹25,000</span>
            <span style="color:#FAF5E8;">Top 6.4%</span>
        </div>
    </div>
</div>

<!-- ══ STATUS FLOW FILTER PILLS ══ -->
<div class="dt-cust-filter-strip">
    <button type="button" class="dt-cust-pill-btn active" onclick="filterCustomersByStatus('all', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        <span>All Shoppers</span>
        <span class="dt-cust-pill-count">4,820</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterCustomersByStatus('active', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <span>Active Verified</span>
        <span class="dt-cust-pill-count">4,180</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterCustomersByStatus('inactive', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        <span>Inactive / Dormant</span>
        <span class="dt-cust-pill-count">640</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterCustomersByStatus('new', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
        <span>New Registrations</span>
        <span class="dt-cust-pill-count">348</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterCustomersByStatus('vip', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        <span>VIP High-Value</span>
        <span class="dt-cust-pill-count">312</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterCustomersByStatus('has_orders', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path></svg>
        <span>With Orders</span>
        <span class="dt-cust-pill-count">3,940</span>
    </button>
    <button type="button" class="dt-cust-pill-btn" onclick="filterCustomersByStatus('no_orders', this)">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
        <span>No Orders</span>
        <span class="dt-cust-pill-count">880</span>
    </button>
</div>
