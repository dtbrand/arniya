<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * retail-segments.php — DT Brand's & Jai Hanuman Tex
 * Retail Customer Segments & Behavioral Cohorts Component
 */
require_once __DIR__ . '/retail-data.php';
$segments = getRetailSegments();
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a10 10 0 0 1 10 10"></path></svg>
            <h4 class="dt-retail-card-title">Retail Customer Cohorts &amp; Segments</h4>
        </div>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openCreateRetailSegmentModal()">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.6"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>Create Cohort</span>
        </button>
    </div>

    <div style="padding:16px; display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
        <?php foreach ($segments as $s): ?>
            <div style="background:#FAF8F4; border:1.2px solid #EAE5D9; border-radius:10px; padding:14px; display:flex; flex-direction:column; justify-content:space-between; gap:10px;">
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <strong style="color:#181512; font-size:0.85rem;"><?php echo htmlspecialchars($s['name']); ?></strong>
                        <span class="dt-status-pill-clean <?php echo $s['badge']; ?>"><?php echo $s['count']; ?> Users</span>
                    </div>
                    <span style="font-size:0.72rem; color:#78716C; display:block; margin-top:4px;"><?php echo $s['criteria']; ?></span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px dashed #EAE5D9; padding-top:8px;">
                    <span style="font-size:0.75rem; font-weight:800; color:#15803D;"><?php echo $s['share']; ?></span>
                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="broadcastToRetailSegment('<?php echo addslashes($s['name']); ?>', <?php echo $s['count']; ?>)">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#FFFFFF" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>Campaign</span>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Create Segment Modal -->
<div id="dtCreateRetailSegmentModal" class="dt-modal-backdrop">
    <div class="dt-modal-dialog" style="max-width:440px;">
        <div class="dt-modal-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a10 10 0 0 1 10 10"></path></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Create Retail Customer Segment</strong>
            </div>
            <button type="button" onclick="closeRetailModal('dtCreateRetailSegmentModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>
        <form onsubmit="submitCreateRetailSegment(event)">
            <div class="dt-modal-body">
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Segment Name</label>
                    <input type="text" id="newSegmentName" class="dt-retail-input" required placeholder="e.g. Wedding Season Heavy Buyers" style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.8rem;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Filter Criteria Rule</label>
                    <select class="dt-retail-input" style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.78rem;">
                        <option value="spent_high">Total Spent > ₹20,000</option>
                        <option value="frequent">Orders Placed >= 3 in 60 Days</option>
                        <option value="cart_abandon">Abandoned Cart Active > 7 Days</option>
                    </select>
                </div>
            </div>
            <div class="dt-modal-foot">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeRetailModal('dtCreateRetailSegmentModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Save Segment</button>
            </div>
        </form>
    </div>
</div>
