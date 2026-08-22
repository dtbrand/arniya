<?php
/**
 * wholesale-business.php — DT Brand's & Jai Hanuman Tex
 * Business Legal Information, GSTIN & Warehouse Address Card (100% Dynamic)
 */

require_once __DIR__ . '/wholesale-data.php';
$whl_id = isset($_GET['id']) ? $_GET['id'] : (isset($wholesale['id']) ? $wholesale['id'] : 'WHL-8012');
$wholesale = isset($wholesale) && is_array($wholesale) ? $wholesale : getWholesalePartner($whl_id);
?>
<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            <h4 class="dt-card-title">Business Legal Entity &amp; Tax Profile</h4>
        </div>
        <a href="/Frontend/Admin/wholesale/edit.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">Edit Business Info</a>
    </div>

    <div style="padding:18px; display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px; font-size:0.78rem;">
        <div>
            <span style="font-size:0.68rem; color:#78716C; font-weight:700; display:block;">LEGAL ENTITY NAME:</span>
            <strong style="color:#181512; font-size:0.86rem;"><?php echo htmlspecialchars($wholesale['legal_name']); ?></strong>
        </div>
        <div>
            <span style="font-size:0.68rem; color:#78716C; font-weight:700; display:block;">TRADE / BRAND NAME:</span>
            <strong style="color:#181512; font-size:0.86rem;"><?php echo htmlspecialchars($wholesale['name']); ?></strong>
        </div>
        <div>
            <span style="font-size:0.68rem; color:#78716C; font-weight:700; display:block;">BUSINESS STRUCTURE:</span>
            <strong style="color:#181512;"><?php echo htmlspecialchars($wholesale['structure']); ?></strong>
        </div>
        <div>
            <span style="font-size:0.68rem; color:#78716C; font-weight:700; display:block;">GSTIN TAX IDENTIFIER:</span>
            <strong style="font-family:monospace; color:#8A681F; font-size:0.9rem;"><?php echo htmlspecialchars($wholesale['gstin']); ?></strong>
        </div>
        <div>
            <span style="font-size:0.68rem; color:#78716C; font-weight:700; display:block;">COMPANY PAN:</span>
            <strong style="font-family:monospace; color:#181512;"><?php echo htmlspecialchars($wholesale['pan']); ?></strong>
        </div>
        <div>
            <span style="font-size:0.68rem; color:#78716C; font-weight:700; display:block;">PRIMARY DISPATCH WAREHOUSE:</span>
            <strong style="color:#181512;"><?php echo htmlspecialchars($wholesale['address']); ?></strong>
        </div>
    </div>
</div>
