<?php
/**
 * variant-table.php — Dynamic Variant Generator Matrix
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title"><span>🎨 Product Variants & Attributes</span></h3>
        <button type="button" class="adm-btn-secondary adm-btn-sm" onclick="window.generateVariantMatrix()">+ Generate Variants</button>
    </div>
    <div class="dt-form-sec-body">
        <div class="dt-variant-generator-box">
            <div style="font-weight:700; font-size:0.85rem; margin-bottom:8px;">Active Attributes:</div>
            <div>
                <span class="dt-attr-chip">Color: Crimson Red ✕</span>
                <span class="dt-attr-chip">Color: Bottle Green ✕</span>
                <span class="dt-attr-chip">Color: Royal Blue ✕</span>
                <span class="dt-attr-chip">Fabric: Pure Silk ✕</span>
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
