<?php
/**
 * retail-pricing.php — DT Brand's & Jai Hanuman Tex
 * Retail Pricing & Margin Management Component
 */
require_once __DIR__ . '/retail-data.php';
$skus = getRetailPricingSkus();
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <h4 class="dt-retail-card-title">Retail Pricing &amp; Margin Rules</h4>
        </div>
        <a href="/Frontend/Admin/pricing/" class="dt-btn dt-btn-pale dt-btn-sm">Global Pricing Suite →</a>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-retail-table">
            <thead>
                <tr>
                    <th>Product &amp; SKU</th>
                    <th>Category</th>
                    <th style="text-align:right;">MRP (₹)</th>
                    <th style="text-align:right;">Retail Selling Price (₹)</th>
                    <th style="text-align:right;">Discount / Margin</th>
                    <th style="text-align:right;">Stock Level</th>
                    <th>Status</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($skus as $s): 
                    $disc_pct = round((($s['mrp'] - $s['retail']) / $s['mrp']) * 100);
                ?>
                    <tr>
                        <td>
                            <strong style="color:#181512; font-size:0.8rem; display:block;"><?php echo htmlspecialchars($s['name']); ?></strong>
                            <span style="font-family:monospace; font-size:0.7rem; color:#8A681F; font-weight:800;"><?php echo $s['sku']; ?></span>
                        </td>
                        <td style="font-size:0.75rem; color:#78716C;"><?php echo $s['category']; ?></td>
                        <td style="text-align:right; color:#78716C; text-decoration:line-through;">₹<?php echo number_format($s['mrp']); ?></td>
                        <td style="text-align:right; font-weight:900; color:#181512; font-size:0.88rem;">₹<?php echo number_format($s['retail']); ?></td>
                        <td style="text-align:right;">
                            <span class="dt-price-badge-margin"><?php echo $disc_pct; ?>% OFF</span>
                        </td>
                        <td style="text-align:right; font-weight:800; color:#181512;"><?php echo $s['stock']; ?> pcs</td>
                        <td><span class="dt-status-pill-clean <?php echo $s['badge']; ?>"><?php echo $s['status']; ?></span></td>
                        <td style="text-align:right; white-space:nowrap;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openEditRetailPriceModal('<?php echo $s['sku']; ?>', '<?php echo addslashes($s['name']); ?>', <?php echo $s['mrp']; ?>, <?php echo $s['retail']; ?>)">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                <span>Edit Price</span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Retail Price Modal -->
<div id="dtEditRetailPriceModal" class="dt-modal-backdrop">
    <div class="dt-modal-dialog" style="max-width:440px;">
        <div class="dt-modal-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Edit Retail Price &amp; MRP</strong>
            </div>
            <button type="button" onclick="closeRetailModal('dtEditRetailPriceModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>
        <form onsubmit="submitEditRetailPrice(event)">
            <div class="dt-modal-body">
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">SKU Reference</label>
                    <input type="text" id="editPriceSku" class="dt-retail-input" readonly style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.8rem; background:#FAF8F4; font-family:monospace;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Product Title</label>
                    <input type="text" id="editPriceName" class="dt-retail-input" readonly style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.8rem; background:#FAF8F4;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">MRP (₹)</label>
                        <input type="number" id="editPriceMrp" class="dt-retail-input" required style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.85rem; font-weight:800;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Retail Price (₹)</label>
                        <input type="number" id="editPriceRetail" class="dt-retail-input" required style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.85rem; font-weight:800; color:#8A681F;">
                    </div>
                </div>
            </div>
            <div class="dt-modal-foot">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeRetailModal('dtEditRetailPriceModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Save Retail Price</button>
            </div>
        </form>
    </div>
</div>
