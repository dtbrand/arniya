<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-segments.php - Cohort criteria panel, presets and live results
 * DT Brand's & Jai Hanuman Tex - Live Production Standard
 *
 * The six segment cards that used to live here were hand-written HTML with
 * hand-written audience sizes. Two of them could not have been computed at all:
 * "Country != India" (no country column) and "Tags = Saree Lover" (no tags
 * table). The presets below are the same idea expressed against columns that
 * exist, and each carries a count taken from the rows segments.php loaded.
 */
if (!isset($segRows) || !is_array($segRows)) {
    echo '<div class="dt-card" style="padding:18px 20px;">'
       . '<strong>Open this from Customers &rsaquo; Segments.</strong>'
       . '<p style="margin:6px 0 0; font-size:0.8rem; color:#78716C;">This panel is a fragment of '
       . '<code>admin/customers/segments.php</code> and has no customer rows of its own.</p></div>';
    return;
}
if (!isset($statesSeen)) { $statesSeen = []; }
if (!isset($tiersSeen))  { $tiersSeen  = []; }

$segTotal = count($segRows);
$cut60 = strtotime('-60 days');
$presetCounts = ['vip' => 0, 'repeat' => 0, 'never' => 0, 'dormant' => 0, 'gujarat' => 0, 'trade' => 0];
foreach ($segRows as $r) {
    if ($r['spend'] >= 25000) $presetCounts['vip']++;
    if ($r['orders'] >= 3)    $presetCounts['repeat']++;
    if ($r['orders'] === 0)   $presetCounts['never']++;
    $st = strtoupper($r['state']);
    if ($st === 'GJ' || $st === 'GUJARAT') $presetCounts['gujarat']++;
    if ($r['type'] === 'wholesale' || $r['type'] === 'reseller') $presetCounts['trade']++;
    $lo = $r['last'] !== '' ? strtotime($r['last']) : false;
    if ($lo === false || $lo < $cut60) $presetCounts['dormant']++;
}

$presets = [
    ['key' => 'vip',     'name' => 'High-Value Buyers',   'sub' => 'Lifetime spend &ge; &#8377;25,000',        'count' => $presetCounts['vip'],     'icon' => 'star'],
    ['key' => 'repeat',  'name' => 'Repeat Buyers',       'sub' => 'Three or more orders placed',              'count' => $presetCounts['repeat'],  'icon' => 'repeat'],
    ['key' => 'never',   'name' => 'Registered, No Order','sub' => 'Signed up but never bought',               'count' => $presetCounts['never'],   'icon' => 'cart'],
    ['key' => 'dormant', 'name' => 'Dormant 60+ Days',    'sub' => 'No order in the last 60 days',             'count' => $presetCounts['dormant'], 'icon' => 'clock'],
    ['key' => 'gujarat', 'name' => 'Gujarat Buyers',      'sub' => 'State recorded as Gujarat / GJ',           'count' => $presetCounts['gujarat'], 'icon' => 'pin'],
    ['key' => 'trade',   'name' => 'Trade Accounts',      'sub' => 'Wholesale and reseller accounts',          'count' => $presetCounts['trade'],   'icon' => 'box'],
];

$presetIcons = [
    'star'   => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>',
    'repeat' => '<path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>',
    'cart'   => '<circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>',
    'clock'  => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>',
    'pin'    => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>',
    'box'    => '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line>',
];
$inputStyle = 'width:100%; height:38px; box-sizing:border-box; background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; font-weight:600; color:#181512;';
$labelStyle = 'display:block; font-size:0.73rem; font-weight:800; color:#181512; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:5px;';
?>

<div style="display:flex; flex-direction:column; gap:18px;">

    <!-- ══ WHY NOTHING IS SAVED ══ -->
    <div class="dt-card" style="padding:16px 20px; border-left:3px solid #B8860B;">
        <div style="display:flex; align-items:flex-start; gap:12px;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#8A681F" stroke-width="2.3" style="flex-shrink:0; margin-top:2px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <div>
                <div style="font-size:0.88rem; font-weight:800; color:#181512;">Cohorts are computed, not stored</div>
                <p style="font-size:0.79rem; color:#57534E; margin:5px 0 0; line-height:1.55;">
                    This database has no segments table, so a saved segment would be a name with nothing behind it.
                    Build the cohort here instead: the count updates as you change the criteria, the preview lists the
                    real customers who qualify, and Export CSV writes exactly those rows.
                    Criteria are matched against <?php echo number_format($segTotal); ?> customer<?php echo $segTotal === 1 ? '' : 's'; ?> loaded from the live table.
                </p>
            </div>
        </div>
    </div>
    <!-- ══ PRESET COHORTS (REAL COUNTS) ══ -->
    <div>
        <div style="font-size:0.75rem; font-weight:800; color:#78716C; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:10px;">
            Start From a Preset &mdash; counts are live
        </div>
        <div class="dt-segment-grid" id="dtSegmentsGridContainer">
            <?php foreach ($presets as $p): ?>
                <div class="dt-segment-card" data-segment-title="<?php echo htmlspecialchars($p['name']); ?>" style="cursor:pointer;" onclick="applySegmentPreset('<?php echo $p['key']; ?>')" title="Load these criteria into the builder">
                    <div class="dt-segment-head">
                        <div class="dt-segment-title-wrap">
                            <div class="dt-segment-icon-box" style="background:#FAF5E8; border-color:#D4AF37; color:#8A681F;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><?php echo $presetIcons[$p['icon']]; ?></svg>
                            </div>
                            <div>
                                <h4 class="dt-segment-name"><?php echo htmlspecialchars($p['name']); ?></h4>
                                <p class="dt-segment-sub"><?php echo $p['sub']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="dt-segment-stats">
                        <div>
                            <div class="dt-segment-count" style="color:<?php echo $p['count'] > 0 ? '#181512' : '#A8A29E'; ?>;"><?php echo number_format($p['count']); ?></div>
                            <small style="color:#78716C; font-size:0.68rem; font-weight:700;">
                                Match<?php echo $p['count'] === 1 ? '' : 'es'; ?> now
                                <?php if ($segTotal > 0): ?>&middot; <?php echo number_format(($p['count'] / $segTotal) * 100, 1); ?>%<?php endif; ?>
                            </small>
                        </div>
                        <span class="dt-btn dt-btn-pale dt-btn-sm" style="padding:3px 10px; font-size:0.72rem;">Load</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ══ CRITERIA BUILDER ══ -->
    <div class="dt-card" style="padding:18px 20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
            <div>
                <h4 style="font-size:1rem; font-weight:800; color:#181512; margin:0;">Cohort Criteria</h4>
                <p style="font-size:0.75rem; color:#78716C; margin:3px 0 0 0;">Every field maps to a column on <code>customers</code>, except dormancy which reads the newest order date.</p>
            </div>
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:4px 12px; font-size:0.75rem;" onclick="resetSegmentCriteria()">Clear Criteria</button>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(190px, 1fr)); gap:12px;">
            <div>
                <label style="<?php echo $labelStyle; ?>" for="dtSegType">Account Type</label>
                <select id="dtSegType" class="dt-cust-select" style="<?php echo $inputStyle; ?>" onchange="runSegmentMatch()">
                    <option value="">Any type</option>
                    <option value="retail">Retail</option>
                    <option value="wholesale">Wholesale</option>
                    <option value="reseller">Reseller</option>
                    <option value="trade">Trade (wholesale + reseller)</option>
                </select>
            </div>

            <div>
                <label style="<?php echo $labelStyle; ?>" for="dtSegStatus">Account Status</label>
                <select id="dtSegStatus" class="dt-cust-select" style="<?php echo $inputStyle; ?>" onchange="runSegmentMatch()">
                    <option value="">Any status</option>
                    <option value="active">Active &mdash; can sign in</option>
                    <option value="pending">Pending approval</option>
                    <option value="suspended">Suspended</option>
                </select>
            </div>

            <div>
                <label style="<?php echo $labelStyle; ?>" for="dtSegState">State</label>
                <select id="dtSegState" class="dt-cust-select" style="<?php echo $inputStyle; ?>" onchange="runSegmentMatch()">
                    <option value="">Any state</option>
                    <?php foreach ($statesSeen as $upper => $display): ?>
                        <option value="<?php echo htmlspecialchars($upper); ?>"><?php echo htmlspecialchars($display); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (empty($statesSeen)): ?>
                    <div style="font-size:0.68rem; color:#A8A29E; margin-top:4px;">No customer has a state recorded yet.</div>
                <?php endif; ?>
            </div>

            <div>
                <label style="<?php echo $labelStyle; ?>" for="dtSegTier">Tier Label</label>
                <select id="dtSegTier" class="dt-cust-select" style="<?php echo $inputStyle; ?>" onchange="runSegmentMatch()">
                    <option value="">Any tier</option>
                    <option value="__none__">(no tier set)</option>
                    <?php foreach ($tiersSeen as $lower => $display): ?>
                        <option value="<?php echo htmlspecialchars($lower); ?>"><?php echo htmlspecialchars($display); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label style="<?php echo $labelStyle; ?>" for="dtSegMinSpend">Min Lifetime Spend (&#8377;)</label>
                <input type="number" id="dtSegMinSpend" min="0" step="1" placeholder="e.g. 25000" style="<?php echo $inputStyle; ?>" oninput="runSegmentMatch()">
            </div>

            <div>
                <label style="<?php echo $labelStyle; ?>" for="dtSegMinOrders">Min Orders Placed</label>
                <input type="number" id="dtSegMinOrders" min="0" step="1" placeholder="e.g. 3" style="<?php echo $inputStyle; ?>" oninput="runSegmentMatch()">
            </div>

            <div>
                <label style="<?php echo $labelStyle; ?>" for="dtSegOrdering">Order History</label>
                <select id="dtSegOrdering" class="dt-cust-select" style="<?php echo $inputStyle; ?>" onchange="runSegmentMatch()">
                    <option value="">Any</option>
                    <option value="has">Has ordered at least once</option>
                    <option value="never">Has never ordered</option>
                </select>
            </div>

            <div>
                <label style="<?php echo $labelStyle; ?>" for="dtSegDormantDays">No Order in Last N Days</label>
                <input type="number" id="dtSegDormantDays" min="1" step="1" placeholder="e.g. 60" style="<?php echo $inputStyle; ?>" oninput="runSegmentMatch()">
                <div style="font-size:0.68rem; color:#A8A29E; margin-top:4px;">Includes customers who never ordered.</div>
            </div>

            <div>
                <label style="<?php echo $labelStyle; ?>" for="dtSegExtra">Also Require</label>
                <select id="dtSegExtra" class="dt-cust-select" style="<?php echo $inputStyle; ?>" onchange="runSegmentMatch()">
                    <option value="">Nothing else</option>
                    <option value="gstin">GSTIN on file</option>
                    <option value="balance">Outstanding balance above zero</option>
                    <option value="email">Email address on file</option>
                </select>
            </div>
        </div>
    </div>

    <!-- ══ LIVE RESULT ══ -->
    <div class="dt-card" style="padding:0; overflow:hidden;">
        <div style="padding:14px 18px; background:#FAF8F4; border-bottom:1.2px solid #EAE5D9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div>
                <div style="font-size:0.72rem; font-weight:800; color:#78716C; text-transform:uppercase; letter-spacing:0.04em;">Matching Customers</div>
                <div style="display:flex; align-items:baseline; gap:8px; margin-top:2px;">
                    <span id="dtSegMatchCount" style="font-size:1.5rem; font-weight:900; color:#181512;"><?php echo number_format($segTotal); ?></span>
                    <span id="dtSegMatchPct" style="font-size:0.75rem; font-weight:700; color:#78716C;">of <?php echo number_format($segTotal); ?> &mdash; no criteria set</span>
                </div>
            </div>

            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <!--
                  The old card actions were "Sync" (toasted 'Audience synced!
                  Live records updated in real-time.' after an 800ms timer and
                  touched nothing) and "WhatsApp" (toasted that a broadcast to
                  N customers was being prepared; there is no broadcast sender
                  in this codebase). Both are replaced by actions that really
                  produce the thing they name.
                -->
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="height:34px; padding:0 12px; font-size:0.75rem; display:inline-flex; align-items:center; gap:5px;" onclick="copySegmentPhones()">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    <span>Copy Phone Numbers</span>
                </button>
                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" style="height:34px; padding:0 14px; font-size:0.75rem; display:inline-flex; align-items:center; gap:5px;" onclick="exportSegmentCsv()">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Export CSV</span>
                </button>
            </div>
        </div>

        <div id="dtSegCriteriaSummary" style="padding:8px 18px; background:#FDFCFA; border-bottom:1px solid #F1ECE1; font-size:0.72rem; color:#78716C; font-weight:600;">
            Showing every customer &mdash; set a criterion above to narrow the cohort.
        </div>

        <div style="overflow-x:auto; -webkit-overflow-scrolling:touch; width:100%;">
            <table class="dt-cust-table" style="width:100%; min-width:820px; border-collapse:collapse;">
                <thead>
                    <tr style="background:#F9F6F0; border-bottom:1.5px solid #EAE5D9;">
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Customer</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Phone</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Type / Tier</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Location</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:right; text-transform:uppercase;">Orders</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:right; text-transform:uppercase;">Lifetime Spend</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Last Order</th>
                    </tr>
                </thead>
                <tbody id="dtSegPreviewBody"></tbody>
            </table>
        </div>

        <div id="dtSegPreviewNote" style="padding:10px 18px; background:#FAF8F4; border-top:1.2px solid #EAE5D9; font-size:0.72rem; color:#78716C;"></div>
    </div>

</div>
