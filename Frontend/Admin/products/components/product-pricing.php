<?php
/**
 * product-pricing.php — Complete Multi-Tier Pricing Schedule with Auto Customer Markup Rule
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" style="color:#8A681F;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <span>Multi-Tier Pricing Schedule</span>
        </h3>
        <span class="adm-badge gold" style="font-size:11px; padding:2px 8px;">
            ⚡ Auto-Markup Rule Active (&lt;500: +200 | 500-1200: +300 | 1200-2000: +400 | 2000+: +500)
        </span>
    </div>
    <div class="dt-form-sec-body">
        
        <!-- Complete All-In-One Price Grid -->
        <div class="adm-form-grid">
            <!-- 1. Purchase / Cost Price -->
            <div class="adm-form-group">
                <label class="adm-form-label">Purchase Price (Weaving / Cost) ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormCost" class="adm-form-input" placeholder="e.g. 2100" value="2100" oninput="calculateAllPrices(this.value)">
                <small style="color:#646970; font-size:11px; margin-top:3px; display:block;">Base manufacturing / procurement cost</small>
            </div>

            <!-- 2. Customer Sale Price -->
            <div class="adm-form-group">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <label class="adm-form-label" style="margin:0;">Customer Sale Price (Retail) ₹ <span style="color:#b32d2e;">*</span></label>
                    <span id="custMarkupBadge" class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10px; padding:1px 5px;">+₹500 Added</span>
                </div>
                <input type="number" id="pFormRetail" class="adm-form-input" style="font-weight:700; color:#181512;" placeholder="e.g. 2600" value="2600">
                <small id="custPriceFormulaHint" style="color:#15803D; font-size:11px; margin-top:3px; display:block;">Auto: Base ₹2,100 + ₹500 (Customer Rule)</small>
            </div>

            <!-- 3. MRP / Regular Price -->
            <div class="adm-form-group">
                <label class="adm-form-label">Price (MRP / Regular Benchmark) ₹</label>
                <input type="number" id="pFormMrp" class="adm-form-input" placeholder="e.g. 3490" value="3490">
                <small style="color:#646970; font-size:11px; margin-top:3px; display:block;">Original benchmark printed price</small>
            </div>

            <!-- 4. Reseller Price -->
            <div class="adm-form-group">
                <label class="adm-form-label">Reseller Price (WhatsApp Dropship) ₹</label>
                <input type="number" id="pFormReseller" class="adm-form-input" placeholder="e.g. 2350" value="2350">
                <small style="color:#7E22CE; font-size:11px; margin-top:3px; display:block;">For WhatsApp catalog &amp; social sellers</small>
            </div>

            <!-- 5. Wholesale Price (MOQ 8+) -->
            <div class="adm-form-group">
                <label class="adm-form-label">Wholesale Price (MOQ 8+ pcs) ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormWholesale" class="adm-form-input" placeholder="e.g. 2300" value="2300">
                <small style="color:#8A681F; font-size:11px; margin-top:3px; display:block;">B2B Shop owners &amp; boutique orders</small>
            </div>

            <!-- 6. Bulk Mill Lot (MOQ 30+) -->
            <div class="adm-form-group">
                <label class="adm-form-label">Bulk Mill Lot Price (MOQ 30+ pcs) ₹</label>
                <input type="number" id="pFormBulk30" class="adm-form-input" placeholder="e.g. 2220" value="2220">
                <small style="color:#8A681F; font-size:11px; margin-top:3px; display:block;">Semi-wholesalers consignment lot</small>
            </div>

            <!-- 7. Volume 100+ pcs Price -->
            <div class="adm-form-group">
                <label class="adm-form-label">Volume 100+ pcs Lot Price ₹</label>
                <input type="number" id="pFormBulk100" class="adm-form-input" style="font-weight:700; color:#8A681F;" placeholder="e.g. 2180" value="2180">
                <small style="color:#8A681F; font-size:11px; margin-top:3px; display:block;">Master wholesale lot (100+ units)</small>
            </div>

            <!-- 8. Volume 200+ pcs Price -->
            <div class="adm-form-group">
                <label class="adm-form-label">Volume 200+ pcs Container Mill Lot ₹</label>
                <input type="number" id="pFormBulk200" class="adm-form-input" style="font-weight:700; color:#15803D;" placeholder="e.g. 2130" value="2130">
                <small style="color:#15803D; font-size:11px; margin-top:3px; display:block;">Direct factory container rate (200+ units)</small>
            </div>
        </div>

        <!-- Profit Margin Summary Card -->
        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:4px; padding:10px 14px; margin-top:12px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
            <div style="font-size:12px;">
                <span style="color:#7A7266;">Customer Retail Margin:</span>
                <strong id="marginRetailText" style="color:#15803D; margin-left:4px;">₹500 / pc (19.2%)</strong>
            </div>
            <div style="font-size:12px;">
                <span style="color:#7A7266;">Wholesale Margin:</span>
                <strong id="marginWholesaleText" style="color:#8A681F; margin-left:4px;">₹200 / pc (8.7%)</strong>
            </div>
            <div style="font-size:12px;">
                <span style="color:#7A7266;">Volume 200+ Mill Margin:</span>
                <strong id="margin200Text" style="color:#15803D; margin-left:4px;">₹30 / pc (1.4%)</strong>
            </div>
            <div style="font-size:12px;">
                <span style="color:#7A7266;">GST Slab:</span>
                <strong>5% (HSN 5007)</strong>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * Smart Customer Pricing Formula:
 * - Below 500      => +200
 * - 500 to 1200   => +300
 * - 1200 to 2000  => +400
 * - Above 2000    => +500
 */
function getCustomerMarkup(cost) {
    if (cost < 500) return 200;
    if (cost <= 1200) return 300;
    if (cost <= 2000) return 400;
    return 500;
}

function calculateAllPrices(costVal) {
    const cost = parseFloat(costVal) || 0;
    if (cost <= 0) return;

    // 1. Customer Markup
    const markup = getCustomerMarkup(cost);
    const customerPrice = cost + markup;

    // 2. MRP (Customer Price + ~30-35% buffer)
    const mrp = Math.round((customerPrice * 1.35) / 10) * 10;

    // 3. Reseller Price (Cost + 50% of markup)
    const reseller = Math.round((cost + (markup * 0.5)) / 10) * 10;

    // 4. Wholesale Price (Cost + 40% of markup)
    const wholesale = Math.round((cost + (markup * 0.4)) / 10) * 10;

    // 5. Bulk 30+ Price (Cost + 25% of markup)
    const bulk30 = Math.round((cost + (markup * 0.25)) / 10) * 10;

    // 6. Bulk 100+ Price (Cost + 15% of markup)
    const bulk100 = Math.round((cost + (markup * 0.15)) / 10) * 10;

    // 7. Bulk 200+ Price (Cost + 6% of markup)
    const bulk200 = Math.round((cost + (markup * 0.06)) / 10) * 10;

    // Set values into inputs
    document.getElementById('pFormRetail').value = customerPrice;
    document.getElementById('pFormMrp').value = mrp;
    document.getElementById('pFormReseller').value = reseller;
    document.getElementById('pFormWholesale').value = wholesale;
    document.getElementById('pFormBulk30').value = bulk30;
    document.getElementById('pFormBulk100').value = bulk100;
    document.getElementById('pFormBulk200').value = bulk200;

    // Update hints & badges
    const badge = document.getElementById('custMarkupBadge');
    if (badge) badge.textContent = `+₹${markup} Added`;

    const hint = document.getElementById('custPriceFormulaHint');
    if (hint) hint.textContent = `Auto: Base ₹${cost.toLocaleString('en-IN')} + ₹${markup} (Customer Rule)`;

    // Update Margin Summaries
    const retMargin = customerPrice - cost;
    const retPct = ((retMargin / customerPrice) * 100).toFixed(1);
    document.getElementById('marginRetailText').textContent = `₹${retMargin} / pc (${retPct}%)`;

    const wsMargin = wholesale - cost;
    const wsPct = ((wsMargin / wholesale) * 100).toFixed(1);
    document.getElementById('marginWholesaleText').textContent = `₹${wsMargin} / pc (${wsPct}%)`;

    const m200Margin = bulk200 - cost;
    const m200Pct = ((m200Margin / bulk200) * 100).toFixed(1);
    document.getElementById('margin200Text').textContent = `₹${m200Margin} / pc (${m200Pct}%)`;
}
</script>
