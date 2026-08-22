<?php
/**
 * wholesale-pricing.php — DT Brand's & Jai Hanuman Tex
 * Multi-Tier Wholesale Margin Rules & Catalog Discounts (100% Dynamic)
 */
require_once __DIR__ . '/wholesale-data.php';
$whl_id = isset($_GET['id']) ? $_GET['id'] : (isset($wholesale['id']) ? $wholesale['id'] : 'WHL-8012');
$wholesale = isset($wholesale) && is_array($wholesale) ? $wholesale : getWholesalePartner($whl_id);
$category_margins = getWholesaleCategoryMargins($wholesale['id']);
?>

<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <h4 class="dt-card-title">Assigned Wholesale Category Margins (<?php echo htmlspecialchars($wholesale['tier_short']); ?>)</h4>
        </div>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="recalculateAllWholesaleMargins()">
            <span>Sync Live Margins</span>
        </button>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-wholesale-table">
            <thead>
                <tr>
                    <th style="white-space:nowrap;">Fabric / Saree Category</th>
                    <th style="text-align:center; white-space:nowrap;">Assigned Margin</th>
                    <th style="text-align:center; white-space:nowrap;">Min Lot (MOQ)</th>
                    <th style="text-align:right; white-space:nowrap;">Sample Retail MRP</th>
                    <th style="text-align:right; white-space:nowrap;">Net Wholesale B2B Price</th>
                    <th style="text-align:right; white-space:nowrap;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($category_margins as $m): ?>
                    <tr style="border-bottom:1px solid #F1ECE1;">
                        <td style="font-weight:800; color:#181512; white-space:nowrap;"><?php echo $m['cat']; ?></td>
                        <td style="text-align:center; white-space:nowrap;">
                            <span class="dt-status-pill-clean emerald" style="font-size:0.75rem;"><?php echo $m['margin']; ?>% OFF</span>
                        </td>
                        <td style="text-align:center; font-weight:700; color:#8A681F; white-space:nowrap;"><?php echo $m['moq']; ?> pcs</td>
                        <td style="text-align:right; color:#78716C; text-decoration:line-through; white-space:nowrap;"><?php echo $m['retail_base']; ?></td>
                        <td style="text-align:right; font-weight:900; color:#15803D; font-size:0.88rem; white-space:nowrap;"><?php echo $m['whl_price']; ?></td>
                        <td style="text-align:right; white-space:nowrap;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openEditCategoryMarginModal('<?php echo addslashes($m['cat']); ?>', <?php echo $m['margin']; ?>, <?php echo $m['moq']; ?>)">
                                <span>Edit Margin</span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
