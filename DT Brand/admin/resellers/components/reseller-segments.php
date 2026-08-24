<?php
/**
 * reseller-segments.php — DT Brand's & Jai Hanuman Tex
 * Reseller Cohorts, Performance Clusters & Partner Directory Component
 */
$total_resellers = 348;
$high_growth = 136;
$top_gmv = "₹48.6 Lakhs";
$dormant_count = 52;

$segments = [
    [
        'id' => 'elite',
        'name' => 'Elite Power Resellers',
        'sub' => 'Quarterly GMV ≥ ₹5 Lakhs • MOQ ≥ 10 Pcs • Bulk Volume',
        'count' => '42 Partners',
        'margin' => '30% Master Margin',
        'color' => 'gold',
        'gmv_share' => '44% of GMV'
    ],
    [
        'id' => 'dropship',
        'name' => 'High-Frequency Dropshippers',
        'sub' => 'Orders ≥ 20 / Month • Fast Dispatch • 1-Pc Dropshipping',
        'count' => '94 Partners',
        'margin' => '22% Dropship Margin',
        'color' => 'emerald',
        'gmv_share' => '31% of GMV'
    ],
    [
        'id' => 'boutique',
        'name' => 'Emerging Social Boutique Sellers',
        'sub' => 'Instagram & WhatsApp Community Commerce • Custom Bundles',
        'count' => '160 Partners',
        'margin' => '15% Standard Margin',
        'color' => 'blue',
        'gmv_share' => '18% of GMV'
    ],
    [
        'id' => 'dormant',
        'name' => 'Credit Watch & Dormant',
        'sub' => 'No orders in last 45 days or revolving credit limit exhausted',
        'count' => '52 Partners',
        'margin' => 'Audit Required',
        'color' => 'amber',
        'gmv_share' => '7% of GMV'
    ]
];

$partners = [
    [
        'id' => 'RES-1048',
        'name' => 'Arniya Silk Heritage',
        'city' => 'Surat, Gujarat',
        'cohort_id' => 'elite',
        'cohort_name' => 'Elite Power Reseller',
        'color' => 'gold',
        'quarterly_gmv' => '₹6,45,000',
        'frequency' => '38 Orders/Mo',
        'margin' => '30% Tier-1',
        'health' => 'Excellent (₹85k Avail)'
    ],
    [
        'id' => 'RES-1049',
        'name' => 'Surat Fab Sarees Hub',
        'city' => 'Surat, Gujarat',
        'cohort_id' => 'dropship',
        'cohort_name' => 'High-Frequency Dropshipper',
        'color' => 'emerald',
        'quarterly_gmv' => '₹3,80,000',
        'frequency' => '29 Orders/Mo',
        'margin' => '22% Dropship',
        'health' => 'Good (₹42k Avail)'
    ],
    [
        'id' => 'RES-1050',
        'name' => 'Royal Banarasi Heritage',
        'city' => 'Varanasi, UP',
        'cohort_id' => 'elite',
        'cohort_name' => 'Elite Power Reseller',
        'color' => 'gold',
        'quarterly_gmv' => '₹5,90,000',
        'frequency' => '32 Orders/Mo',
        'margin' => '30% Tier-1',
        'health' => 'Excellent (₹1.1L Avail)'
    ],
    [
        'id' => 'RES-1051',
        'name' => 'Kanchipuram Silk Palace',
        'city' => 'Chennai, Tamil Nadu',
        'cohort_id' => 'boutique',
        'cohort_name' => 'Social Boutique Seller',
        'color' => 'blue',
        'quarterly_gmv' => '₹1,65,000',
        'frequency' => '12 Orders/Mo',
        'margin' => '15% Standard',
        'health' => 'Normal (₹25k Avail)'
    ],
    [
        'id' => 'RES-1052',
        'name' => 'Jaipur Block Handloom Hub',
        'city' => 'Jaipur, Rajasthan',
        'cohort_id' => 'dropship',
        'cohort_name' => 'High-Frequency Dropshipper',
        'color' => 'emerald',
        'quarterly_gmv' => '₹2,40,000',
        'frequency' => '22 Orders/Mo',
        'margin' => '22% Dropship',
        'health' => 'Good (₹30k Avail)'
    ],
    [
        'id' => 'RES-1053',
        'name' => 'Kolkata Silk Emporium',
        'city' => 'Kolkata, West Bengal',
        'cohort_id' => 'dormant',
        'cohort_name' => 'Credit Watch & Dormant',
        'color' => 'amber',
        'quarterly_gmv' => '₹38,000',
        'frequency' => '0 Orders (48d)',
        'margin' => 'Review Needed',
        'health' => 'Exhausted (₹0 Avail)'
    ]
];
?>

<div style="display:flex; flex-direction:column; gap:16px;">
    <!-- ══════════════════════════════════════════════════════════════
         4-CARD KPI RIBBON
    ══════════════════════════════════════════════════════════════ -->
    <div class="dt-segment-kpi-grid">
        <!-- Card 1: Total Segmented -->
        <div class="dt-segment-stat-card">
            <div class="dt-segment-stat-icon gold">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
            <div>
                <span style="font-size:0.7rem; color:#78716C; font-weight:700; text-transform:uppercase;">Total Resellers</span>
                <strong style="font-size:1.25rem; font-weight:900; color:#181512; display:block;"><?php echo $total_resellers; ?> Partners</strong>
            </div>
        </div>

        <!-- Card 2: High Growth -->
        <div class="dt-segment-stat-card">
            <div class="dt-segment-stat-icon emerald">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
            </div>
            <div>
                <span style="font-size:0.7rem; color:#78716C; font-weight:700; text-transform:uppercase;">High-Velocity Cohorts</span>
                <strong style="font-size:1.25rem; font-weight:900; color:#15803D; display:block;"><?php echo $high_growth; ?> Partners (39%)</strong>
            </div>
        </div>

        <!-- Card 3: Top GMV -->
        <div class="dt-segment-stat-card">
            <div class="dt-segment-stat-icon gold">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            </div>
            <div>
                <span style="font-size:0.7rem; color:#78716C; font-weight:700; text-transform:uppercase;">Elite GMV Contribution</span>
                <strong style="font-size:1.25rem; font-weight:900; color:#8A681F; display:block;"><?php echo $top_gmv; ?></strong>
            </div>
        </div>

        <!-- Card 4: Dormant -->
        <div class="dt-segment-stat-card">
            <div class="dt-segment-stat-icon amber">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <div>
                <span style="font-size:0.7rem; color:#78716C; font-weight:700; text-transform:uppercase;">Dormant / At-Risk</span>
                <strong style="font-size:1.25rem; font-weight:900; color:#B45309; display:block;"><?php echo $dormant_count; ?> Partners (15%)</strong>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════
         4 DYNAMIC COHORT CARDS
    ══════════════════════════════════════════════════════════════ -->
    <div class="dt-card" style="padding:18px; background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.02);">
        <div class="dt-card-head" style="margin-bottom:14px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <div>
                    <h4 style="font-size:0.95rem; font-weight:800; color:#181512; margin:0;">Reseller Performance Cohorts &amp; Dynamic Clusters</h4>
                    <p style="font-size:0.7rem; color:#78716C; margin:1px 0 0 0;">Automatic partner tiering based on GMV velocity, order frequency, and credit health.</p>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="showAllCohorts()">
                    <span>Show All (348)</span>
                </button>
                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openCreateSegmentModal()">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>+ New Segment</span>
                </button>
            </div>
        </div>

        <div class="dt-cohort-grid">
            <?php foreach ($segments as $s): ?>
                <div id="cohortCard_<?php echo $s['id']; ?>" class="dt-cohort-card">
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                            <strong style="font-size:0.88rem; color:#181512; font-weight:800;"><?php echo htmlspecialchars($s['name']); ?></strong>
                            <span class="dt-status-pill-clean <?php echo $s['color']; ?>"><?php echo $s['count']; ?></span>
                        </div>
                        <p style="font-size:0.72rem; color:#78716C; margin:0 0 12px 0; line-height:1.4;"><?php echo htmlspecialchars($s['sub']); ?></p>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #EAE5D9; padding-top:10px; margin-top:6px;">
                        <div>
                            <span style="font-size:0.75rem; font-weight:800; color:#8A681F; display:block;"><?php echo $s['margin']; ?></span>
                            <small style="font-size:0.68rem; color:#78716C; font-weight:600;"><?php echo $s['gmv_share']; ?></small>
                        </div>
                        <div style="display:flex; align-items:center; gap:6px;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="filterByCohort('<?php echo $s['id']; ?>', '<?php echo addslashes($s['name']); ?>')">
                                <span>View Cohort</span>
                            </button>
                            <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="padding:4px 8px;" title="WhatsApp Broadcast" onclick="openCohortBroadcastModal('<?php echo $s['id']; ?>', '<?php echo addslashes($s['name']); ?>', '<?php echo $s['count']; ?>')">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#FFFFFF" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════
         COHORT PARTNER DIRECTORY & AUDIT TABLE
    ══════════════════════════════════════════════════════════════ -->
    <div id="cohortDirectorySection" class="dt-card" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.02); overflow:hidden;">
        
        <!-- Directory Toolbar -->
        <div style="padding:14px 18px; border-bottom:1.5px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <div>
                    <h4 style="font-size:0.92rem; font-weight:800; color:#181512; margin:0;">
                        <span>Cohort Partner Directory</span>
                        <span id="activeCohortBadge" class="dt-status-pill-clean gold" style="font-size:0.68rem; margin-left:6px;">Showing All Cohorts (348)</span>
                    </h4>
                    <p style="font-size:0.7rem; color:#78716C; margin:1px 0 0 0;">Review individual partner performance metrics, order velocity, and margin assignments.</p>
                </div>
            </div>

            <!-- Search & Filter Controls -->
            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <!-- Live Search Box -->
                <div style="position:relative; width:220px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#78716C" stroke-width="2.2" style="position:absolute; left:9px; top:50%; transform:translateY(-50%); pointer-events:none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="partnerSearchInput" class="dt-cust-search-input" style="width:100%; height:32px; padding-left:28px; font-size:0.74rem;" placeholder="Search Partner, City, ID..." oninput="filterPartnerDirectory()">
                </div>

                <!-- Cohort Dropdown Filter -->
                <select id="partnerCohortFilter" class="dt-cust-select" style="height:32px; font-size:0.74rem; padding:0 8px; border-radius:6px;" onchange="onCohortFilterChange()">
                    <option value="all">All Cohorts (348)</option>
                    <option value="elite">Elite Power Resellers (42)</option>
                    <option value="dropship">High-Frequency Dropshippers (94)</option>
                    <option value="boutique">Emerging Social Boutiques (160)</option>
                    <option value="dormant">Credit Watch &amp; Dormant (52)</option>
                </select>
            </div>
        </div>

        <!-- Directory Table -->
        <div style="overflow-x:auto; width:100%;">
            <table class="dt-segment-table">
                <thead>
                    <tr>
                        <th style="white-space:nowrap;">Reseller ID</th>
                        <th style="white-space:nowrap;">Partner Name &amp; Hub</th>
                        <th style="white-space:nowrap;">Performance Cohort</th>
                        <th style="text-align:right; white-space:nowrap;">Quarterly GMV (₹)</th>
                        <th style="white-space:nowrap;">Order Frequency</th>
                        <th style="white-space:nowrap;">Margin Tier</th>
                        <th style="white-space:nowrap;">Credit Health</th>
                        <th style="text-align:right; white-space:nowrap;">Action</th>
                    </tr>
                </thead>
                <tbody id="partnerDirectoryTbody">
                    <?php foreach ($partners as $p): ?>
                        <tr id="<?php echo $p['id']; ?>" class="partner-dir-row" data-cohort="<?php echo $p['cohort_id']; ?>" style="border-bottom:1px solid #F1ECE1;">
                            <td class="partner-id-cell" style="font-family:monospace; font-weight:800; color:#8A681F; white-space:nowrap;"><?php echo $p['id']; ?></td>
                            <td class="partner-name-cell" style="font-weight:800; color:#181512; white-space:nowrap;">
                                <div>
                                    <a href="/DT%20Brand/admin/resellers/view.php?id=<?php echo $p['id']; ?>" style="color:#181512; text-decoration:none; font-weight:800;"><?php echo htmlspecialchars($p['name']); ?></a>
                                    <div style="font-size:0.7rem; color:#78716C; font-weight:500;"><?php echo htmlspecialchars($p['city']); ?></div>
                                </div>
                            </td>
                            <td class="partner-cohort-cell" style="white-space:nowrap;">
                                <span class="dt-status-pill-clean <?php echo $p['color']; ?>">
                                    <?php echo $p['cohort_name']; ?>
                                </span>
                            </td>
                            <td style="text-align:right; font-weight:900; color:#181512; font-size:0.85rem; white-space:nowrap;">
                                <?php echo $p['quarterly_gmv']; ?>
                            </td>
                            <td style="color:#181512; font-weight:600; font-size:0.75rem; white-space:nowrap;"><?php echo $p['frequency']; ?></td>
                            <td style="color:#8A681F; font-weight:800; font-size:0.75rem; white-space:nowrap;"><?php echo $p['margin']; ?></td>
                            <td style="font-size:0.72rem; font-weight:700; white-space:nowrap; color:<?php echo $p['cohort_id'] === 'dormant' ? '#DC2626' : '#15803D'; ?>;">
                                <?php echo $p['health']; ?>
                            </td>
                            <td style="text-align:right; white-space:nowrap;">
                                <div style="display:flex; justify-content:flex-end; gap:6px;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openReassignModal('<?php echo $p['id']; ?>', '<?php echo addslashes($p['name']); ?>', '<?php echo $p['cohort_id']; ?>')">
                                        <span>Re-assign</span>
                                    </button>
                                    <a href="/DT%20Brand/admin/resellers/view.php?id=<?php echo $p['id']; ?>" class="dt-btn dt-btn-info dt-btn-sm">
                                        <span>Manage</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
