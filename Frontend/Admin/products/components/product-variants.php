<?php
/**
 * product-variants.php — Dynamic Variant Combinations Matrix
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between;">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
            <span>Attributes &amp; Variant Matrix</span>
        </h3>
        <button type="button" class="wp-button" onclick="if(typeof generateVariantMatrix==='function') generateVariantMatrix();">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>Generate Variants</span>
        </button>
    </div>
    <div class="dt-form-sec-body">
        <div class="dt-variant-generator-box" style="margin-bottom:10px;">
            <div style="font-weight:700; font-size:12px; margin-bottom:6px; color:#1d2327;">Active Attributes:</div>
            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                <span class="adm-badge gold">Color: Crimson Red</span>
                <span class="adm-badge gold">Color: Bottle Green</span>
                <span class="adm-badge gold">Color: Royal Blue</span>
                <span class="adm-badge gold">Fabric: Pure Mulberry Silk</span>
            </div>
        </div>

        <div class="dt-table-wrap">
            <table class="dt-data-table" style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr>
                        <th style="padding:6px 8px;">Variant Combination</th>
                        <th style="padding:6px 8px;">Variant SKU</th>
                        <th style="padding:6px 8px;">Retail (₹)</th>
                        <th style="padding:6px 8px;">Wholesale (₹)</th>
                        <th style="padding:6px 8px;">Stock</th>
                        <th style="padding:6px 8px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding:6px 8px;"><strong>Crimson Red / Pure Silk</strong></td>
                        <td style="padding:6px 8px;"><code>KLN-SR-111-RED</code></td>
                        <td style="padding:6px 8px;"><input type="number" class="adm-form-input" style="width:90px; height:26px; padding:0 6px;" value="4490"></td>
                        <td style="padding:6px 8px;"><input type="number" class="adm-form-input" style="width:90px; height:26px; padding:0 6px;" value="2850"></td>
                        <td style="padding:6px 8px;"><input type="number" class="adm-form-input" style="width:70px; height:26px; padding:0 6px;" value="18"></td>
                        <td style="padding:6px 8px;"><span class="adm-badge success">In Stock</span></td>
                    </tr>
                    <tr>
                        <td style="padding:6px 8px;"><strong>Bottle Green / Pure Silk</strong></td>
                        <td style="padding:6px 8px;"><code>KLN-SR-111-GRN</code></td>
                        <td style="padding:6px 8px;"><input type="number" class="adm-form-input" style="width:90px; height:26px; padding:0 6px;" value="4490"></td>
                        <td style="padding:6px 8px;"><input type="number" class="adm-form-input" style="width:90px; height:26px; padding:0 6px;" value="2850"></td>
                        <td style="padding:6px 8px;"><input type="number" class="adm-form-input" style="width:70px; height:26px; padding:0 6px;" value="15"></td>
                        <td style="padding:6px 8px;"><span class="adm-badge success">In Stock</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
