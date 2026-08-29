<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-tags.php - Stored tier labels + derived cohorts
 * DT Brand's & Jai Hanuman Tex - Live Production Standard
 *
 * This component used to open with a $master_tags array of twelve invented tags
 * ("Saree Enthusiast" - 840, "COD Verified" - 3,100, "NRI Global Exporter" -
 * 486) and a Create Tag form. Nothing it created could be saved: there is no
 * tags table, and no column on `customers` that could hold a free-form label.
 * Two of the invented rules were not even expressible - "Country != India" over
 * a table with no country column, "Zero COD RTO History" with no returns table.
 *
 * It now renders only what is really stored, and is included from tags.php,
 * which computes $tierGroups, $cohorts and the totals.
 */
if (!isset($cohorts) || !is_array($cohorts)) {
    // Included directly rather than through tags.php: say so instead of
    // rendering an empty studio that looks like a database with no customers.
    echo '<div class="dt-card" style="padding:18px 20px;">'
       . '<strong>Open this from Customers &rsaquo; Labels &amp; Cohorts.</strong>'
       . '<p style="margin:6px 0 0; font-size:0.8rem; color:#78716C;">This panel is a fragment of '
       . '<code>admin/customers/tags.php</code> and cannot count anything on its own.</p></div>';
    return;
}
if (!isset($tierGroups))    { $tierGroups = []; }
if (!isset($untieredCount)) { $untieredCount = 0; }
if (!isset($maxTierCount))  { $maxTierCount = 0; }
if (!isset($maxCohortCount)){ $maxCohortCount = 0; }
if (!isset($totalCustomers)){ $totalCustomers = 0; }
if (!function_exists('dt_pct')) {
    function dt_pct($part, $whole) { return $whole > 0 ? number_format(($part / $whole) * 100, 1) . '%' : '0%'; }
}
$listUrl = '/admin/customers/index.php';
?>

<div style="display:flex; flex-direction:column; gap:18px;">

    <!-- ══ WHY THERE IS NO TAG CREATOR ══ -->
    <div class="dt-card" style="padding:16px 20px; border-left:3px solid #B8860B;">
        <div style="display:flex; align-items:flex-start; gap:12px;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#8A681F" stroke-width="2.3" style="flex-shrink:0; margin-top:2px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <div>
                <div style="font-size:0.88rem; font-weight:800; color:#181512;">Free-form tags are not stored in this database</div>
                <p style="font-size:0.79rem; color:#57534E; margin:5px 0 0; line-height:1.55;">
                    There is no tags table and no column on <code>customers</code> that could hold one, so a
                    &ldquo;create tag&rdquo; box could only ever add a chip that disappeared on reload. The label that
                    <em>is</em> saved per customer is <strong>Tier</strong> &mdash; set it in
                    <a href="<?php echo $listUrl; ?>" style="color:#8A681F; font-weight:700;">Customers</a> &rsaquo; open a customer &rsaquo; Edit &rsaquo; Classification.
                    Everything below is counted from the live table each time this page loads.
                </p>
            </div>
        </div>
    </div>
    <!-- ══ STORED TIER LABELS ══ -->
    <div class="dt-card" style="padding:0; overflow:hidden;">
        <div style="padding:12px 18px; background:#FAF8F4; border-bottom:1.2px solid #EAE5D9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
            <div style="font-size:0.88rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                <span>Tier Labels Stored on Customers</span>
                <span class="dt-cust-badge gold" style="font-size:0.62rem;"><?php echo number_format(count($tierGroups)); ?> in use</span>
            </div>
            <div style="font-size:0.72rem; color:#78716C; font-weight:600;">Source: <code>customers.tier</code> &mdash; free text, matched case-insensitively</div>
        </div>

        <?php if (empty($tierGroups)): ?>
            <div style="padding:26px 20px; text-align:center;">
                <div style="font-size:0.85rem; font-weight:800; color:#181512;">No customer carries a tier label yet</div>
                <p style="font-size:0.78rem; color:#78716C; margin:6px 0 0;">
                    Open any customer and set Tier under Classification &mdash; typical values here are Gold, Silver, VIP or a mill name.
                    Once even one is saved, this table counts them.
                </p>
            </div>
        <?php else: ?>
        <div style="overflow-x:auto; -webkit-overflow-scrolling:touch; width:100%;">
            <table class="dt-cust-table" style="width:100%; min-width:760px; border-collapse:collapse;">
                <thead>
                    <tr style="background:#F9F6F0; border-bottom:1.5px solid #EAE5D9;">
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Tier Label</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Customers</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:right; text-transform:uppercase;">Lifetime Spend</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:right; text-transform:uppercase;">Orders</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:right; text-transform:uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $palette = ['gold', 'green', 'blue', 'purple', 'amber']; $i = 0; ?>
                    <?php foreach ($tierGroups as $g): $color = $palette[$i++ % count($palette)]; ?>
                        <tr class="dt-tag-row" data-tag-name="<?php echo htmlspecialchars(strtolower($g['label'] . ' tier label')); ?>" style="border-bottom:1px solid #F1ECE1;">
                            <td style="padding:12px 16px;">
                                <span class="dt-cust-tag-chip <?php echo $color; ?>"><span><?php echo htmlspecialchars($g['label']); ?></span></span>
                            </td>
                            <td style="padding:12px 16px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <strong style="font-size:0.95rem; font-weight:900; color:#181512;"><?php echo number_format($g['count']); ?></strong>
                                    <span style="font-size:0.7rem; color:#78716C; font-weight:700;"><?php echo dt_pct($g['count'], $totalCustomers); ?></span>
                                    <div style="flex:1; max-width:80px; height:6px; background:#EAE5D9; border-radius:3px; overflow:hidden;">
                                        <div style="width:<?php echo $maxTierCount > 0 ? min(100, round(($g['count'] / $maxTierCount) * 100)) : 0; ?>%; height:100%; background:linear-gradient(90deg, #B8860B, #D4AF37); border-radius:3px;"></div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 16px; text-align:right; font-size:0.82rem; font-weight:800; color:#181512;">&#8377;<?php echo number_format($g['spend'], 2); ?></td>
                            <td style="padding:12px 16px; text-align:right; font-size:0.82rem; font-weight:700; color:#181512;"><?php echo number_format($g['orders']); ?></td>
                            <td style="padding:12px 16px; text-align:right;">
                                <a href="<?php echo $listUrl; ?>?tier=<?php echo urlencode($g['label']); ?>" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:3px 8px; font-size:0.72rem; text-decoration:none;" title="Open the directory filtered to this tier">View Customers</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if ($untieredCount > 0): ?>
                        <tr class="dt-tag-row" data-tag-name="no tier set untiered unlabelled" style="border-bottom:1px solid #F1ECE1; background:#FDFCFA;">
                            <td style="padding:12px 16px;">
                                <span style="font-size:0.8rem; font-weight:800; color:#78716C;">(no tier set)</span>
                            </td>
                            <td style="padding:12px 16px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <strong style="font-size:0.95rem; font-weight:900; color:#181512;"><?php echo number_format($untieredCount); ?></strong>
                                    <span style="font-size:0.7rem; color:#78716C; font-weight:700;"><?php echo dt_pct($untieredCount, $totalCustomers); ?></span>
                                </div>
                            </td>
                            <td style="padding:12px 16px; text-align:right; color:#A8A29E;">&mdash;</td>
                            <td style="padding:12px 16px; text-align:right; color:#A8A29E;">&mdash;</td>
                            <td style="padding:12px 16px; text-align:right;">
                                <a href="<?php echo $listUrl; ?>?cohort=untiered" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:3px 8px; font-size:0.72rem; text-decoration:none;">View Customers</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <!-- ══ DERIVED COHORTS ══ -->
    <div class="dt-card" style="padding:0; overflow:hidden;">
        <div style="padding:12px 18px; background:#FAF8F4; border-bottom:1.2px solid #EAE5D9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div style="font-size:0.88rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                <span>Cohorts Counted From Live Columns</span>
            </div>

            <div style="display:flex; align-items:center; gap:8px;">
                <div style="position:relative; width:250px;">
                    <input type="text" id="dtTagSearchInput" class="dt-input-field no-icon" placeholder="Search labels, cohorts or rules..." oninput="filterTagsTable(this.value)" style="height:36px; font-size:0.78rem; padding:0 28px 0 12px; width:100%; box-sizing:border-box; background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:8px;">
                    <button type="button" id="dtTagSearchClearBtn" onclick="filterTagsTable('')" style="display:none; position:absolute; right:8px; top:50%; transform:translateY(-50%); background:#EAE5D9; border:none; color:#181512; cursor:pointer; font-size:0.68rem; width:18px; height:18px; border-radius:50%; align-items:center; justify-content:center; padding:0;">&#10005;</button>
                </div>
                <span id="dtTagSearchCount" style="font-size:0.72rem; color:#78716C; font-weight:700;"></span>
            </div>
        </div>

        <div style="overflow-x:auto; -webkit-overflow-scrolling:touch; width:100%;">
            <table class="dt-cust-table" id="dtTagsMasterTable" style="width:100%; min-width:820px; border-collapse:collapse;">
                <thead>
                    <tr style="background:#F9F6F0; border-bottom:1.5px solid #EAE5D9;">
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Cohort</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">How It Is Counted</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Customers</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:right; text-transform:uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cohorts as $co): ?>
                        <tr class="dt-tag-row" data-tag-name="<?php echo htmlspecialchars(strtolower($co['label'] . ' ' . strip_tags($co['rule']) . ' ' . $co['source'])); ?>" style="border-bottom:1px solid #F1ECE1;">
                            <td style="padding:12px 16px;">
                                <span class="dt-cust-tag-chip <?php echo htmlspecialchars($co['color']); ?>"><span><?php echo htmlspecialchars($co['label']); ?></span></span>
                            </td>
                            <td style="padding:12px 16px;">
                                <div style="font-size:0.75rem; font-weight:700; color:#181512;"><?php echo $co['rule']; ?></div>
                                <code style="font-size:0.66rem; color:#78716C;"><?php echo htmlspecialchars($co['source']); ?></code>
                            </td>
                            <td style="padding:12px 16px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <strong style="font-size:0.95rem; font-weight:900; color:<?php echo $co['count'] > 0 ? '#181512' : '#A8A29E'; ?>;"><?php echo number_format($co['count']); ?></strong>
                                    <span style="font-size:0.7rem; color:#78716C; font-weight:700;"><?php echo dt_pct($co['count'], $totalCustomers); ?></span>
                                    <div style="flex:1; max-width:80px; height:6px; background:#EAE5D9; border-radius:3px; overflow:hidden;">
                                        <div style="width:<?php echo $maxCohortCount > 0 ? min(100, round(($co['count'] / $maxCohortCount) * 100)) : 0; ?>%; height:100%; background:linear-gradient(90deg, #B8860B, #D4AF37); border-radius:3px;"></div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 16px; text-align:right;">
                                <div style="display:inline-flex; align-items:center; gap:6px;">
                                    <?php if ($co['list'] && $co['count'] > 0): ?>
                                        <a href="<?php echo $listUrl; ?>?cohort=<?php echo urlencode($co['key']); ?>" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:3px 8px; font-size:0.72rem; text-decoration:none;">View Customers</a>
                                    <?php elseif (!$co['list']): ?>
                                        <!-- The directory holds no per-customer last-order date, so dormancy
                                             cannot be filtered there. Offering the button anyway would send
                                             the admin to an unfiltered list of everyone. -->
                                        <span style="font-size:0.68rem; color:#A8A29E; font-weight:700;" title="The customer directory carries no last-order date">Export only</span>
                                    <?php endif; ?>

                                    <?php if ($co['export'] !== '' && $co['count'] > 0): ?>
                                        <a href="/admin/customers/export.php?scope=<?php echo urlencode($co['export']); ?>" class="dt-btn dt-btn-gold dt-btn-sm" style="padding:3px 8px; font-size:0.72rem; text-decoration:none;" title="Opens the Export Studio with this cohort selected">Export</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!--
          The old actions column carried a WhatsApp "Broadcast" button that only
          toasted "Preparing 1-Click WhatsApp Broadcast to 1,850 customers...".
          Nothing was prepared and nothing was sent - there is no broadcast
          integration in this codebase. Export gives the phone list for real.
        -->
        <div style="padding:10px 18px; background:#FAF8F4; border-top:1.2px solid #EAE5D9; font-size:0.72rem; color:#78716C;">
            To message a cohort, export it and import the phone column into WhatsApp Business &mdash; there is no broadcast sender wired into this admin.
        </div>
    </div>

</div>
