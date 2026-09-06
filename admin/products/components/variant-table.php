<?php
/**
 * variant-table.php — Dynamic Variant Generator Matrix
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title" style="display:flex; align-items:center; gap:8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"></path></svg>
            <span>Product Variants &amp; Attributes</span>
        </h3>
        <button type="button" class="dt-btn dt-btn-pale adm-btn-sm" onclick="window.generateVariantMatrix()">+ Generate Variants</button>
    </div>
    <div class="dt-form-sec-body">
        <div class="dt-variant-generator-box">
            <div style="font-weight:700; font-size:0.85rem; margin-bottom:8px;">Active Attributes:</div>
            <div>
                <span class="dt-attr-chip" style="display:inline-flex; align-items:center; gap:6px;"><span>Color: Crimson Red</span><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="cursor:pointer;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>
                <span class="dt-attr-chip" style="display:inline-flex; align-items:center; gap:6px;"><span>Color: Bottle Green</span><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="cursor:pointer;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>
                <span class="dt-attr-chip" style="display:inline-flex; align-items:center; gap:6px;"><span>Color: Royal Blue</span><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="cursor:pointer;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>
                <span class="dt-attr-chip" style="display:inline-flex; align-items:center; gap:6px;"><span>Fabric: Pure Silk</span><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="cursor:pointer;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>
            </div>
        </div>

        <div class="dt-table-wrap">
            <table class="dt-data-table">
                <thead>
                    <tr>
                        <th>Variant Combination</th>
                        <th>Variant SKU</th>
                        <th>Retail Price (₹)</th>
                        <th>Wholesale Price (₹)</th>
                        <th>Stock Units</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Crimson Red / Pure Silk</strong></td>
                        <td><code>KLN-SR-111-RED</code></td>
                        <td><input type="number" class="adm-form-input" style="width:100px; padding:4px 8px;" value="4490"></td>
                        <td><input type="number" class="adm-form-input" style="width:100px; padding:4px 8px;" value="2850"></td>
                        <td><input type="number" class="adm-form-input" style="width:80px; padding:4px 8px;" value="18"></td>
                        <td><span class="adm-badge success">In Stock</span></td>
                    </tr>
                    <tr>
                        <td><strong>Bottle Green / Pure Silk</strong></td>
                        <td><code>KLN-SR-111-GRN</code></td>
                        <td><input type="number" class="adm-form-input" style="width:100px; padding:4px 8px;" value="4490"></td>
                        <td><input type="number" class="adm-form-input" style="width:100px; padding:4px 8px;" value="2850"></td>
                        <td><input type="number" class="adm-form-input" style="width:80px; padding:4px 8px;" value="15"></td>
                        <td><span class="adm-badge success">In Stock</span></td>
                    </tr>
                    <tr>
                        <td><strong>Royal Blue / Pure Silk</strong></td>
                        <td><code>KLN-SR-111-BLU</code></td>
                        <td><input type="number" class="adm-form-input" style="width:100px; padding:4px 8px;" value="4490"></td>
                        <td><input type="number" class="adm-form-input" style="width:100px; padding:4px 8px;" value="12"></td>
                        <td><input type="number" class="adm-form-input" style="width:80px; padding:4px 8px;" value="12"></td>
                        <td><span class="adm-badge success">In Stock</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
