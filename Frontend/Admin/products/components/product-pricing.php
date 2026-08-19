<?php
/**
 * product-pricing.php — Multi-Tier Pricing & Volume Slabs (100+ / 200+)
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" style="color:#8A681F;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <span>Price &amp; Multi-Tier Volume Schedule</span>
        </h3>
        <button type="button" class="wp-button" onclick="addNewVolumeTier()">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>+ Add Volume Tier</span>
        </button>
    </div>
    <div class="dt-form-sec-body">
        <!-- 1. Core 4 Master Prices -->
        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label class="adm-form-label">Price (MRP / Regular) ₹</label>
                <input type="number" id="pFormMrp" class="adm-form-input" placeholder="e.g. 5990" value="5990">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Sale Price (Retail Offer) ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormRetail" class="adm-form-input" placeholder="e.g. 4490" value="4490">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Purchase Price (Weaving / Cost) ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormCost" class="adm-form-input" placeholder="e.g. 2100" value="2100">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Reseller Price (WhatsApp Dropship) ₹</label>
                <input type="number" id="pFormReseller" class="adm-form-input" placeholder="e.g. 3450" value="3450">
            </div>
        </div>

        <!-- 2. Scrollable Multi-Tier Volume Pricing List (100+ / 200+ pcs) -->
        <div style="margin-top:14px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <label class="adm-form-label" style="margin:0; font-weight:700;">Volume Slabs &amp; Tier Price List (Scrollable 100+ &amp; 200+)</label>
                <small style="color:#646970; font-size:11px;">Prices apply automatically in cart based on MOQ</small>
            </div>
            
            <div style="max-height: 220px; overflow-y: auto; border: 1px solid #c3c4c7; border-radius: 4px;">
                <table class="wp-list-table" id="dtVolumeTierTable" style="margin:0; width:100%;">
                    <thead>
                        <tr style="position:sticky; top:0; z-index:2; background:#f6f7f7;">
                            <th style="padding:6px 8px;">Tier Name</th>
                            <th style="padding:6px 8px;">MOQ Range</th>
                            <th style="padding:6px 8px;">Price / Piece (₹)</th>
                            <th style="padding:6px 8px;">Target Channel</th>
                            <th style="padding:6px 8px; text-align:right;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="dtVolumeTierBody">
                        <!-- Tier 1: Retail -->
                        <tr id="tier-row-1">
                            <td style="padding:6px 8px;"><strong>Tier 1: Single Piece (Retail)</strong></td>
                            <td style="padding:6px 8px;"><code>1 - 7 pcs</code></td>
                            <td style="padding:6px 8px;"><input type="number" class="adm-form-input tier-price" style="width:100px; height:26px; padding:0 6px;" value="4490"></td>
                            <td style="padding:6px 8px;"><span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px; padding:1px 6px;">Customers</span></td>
                            <td style="padding:6px 8px; text-align:right;"><span style="color:#8c8f94; font-size:11px;">Base</span></td>
                        </tr>

                        <!-- Tier 2: Wholesale 8+ -->
                        <tr id="tier-row-2">
                            <td style="padding:6px 8px;"><strong>Tier 2: Semi-Wholesale (Shop MOQ)</strong></td>
                            <td style="padding:6px 8px;"><code>8 - 29 pcs</code></td>
                            <td style="padding:6px 8px;"><input type="number" class="adm-form-input tier-price" style="width:100px; height:26px; padding:0 6px;" value="2850"></td>
                            <td style="padding:6px 8px;"><span class="adm-badge" style="background:#FAF5FF; color:#7E22CE; font-size:10.5px; padding:1px 6px;">Retailers</span></td>
                            <td style="padding:6px 8px; text-align:right;"><button type="button" class="wp-button" style="height:20px; font-size:10px; color:#b32d2e;" onclick="deleteVolumeTier('tier-row-2')">✕</button></td>
                        </tr>

                        <!-- Tier 3: Bulk 30+ -->
                        <tr id="tier-row-3">
                            <td style="padding:6px 8px;"><strong>Tier 3: Bulk Consignment</strong></td>
                            <td style="padding:6px 8px;"><code>30 - 99 pcs</code></td>
                            <td style="padding:6px 8px;"><input type="number" class="adm-form-input tier-price" style="width:100px; height:26px; padding:0 6px;" value="2650"></td>
                            <td style="padding:6px 8px;"><span class="adm-badge gold" style="font-size:10.5px; padding:1px 6px;">Wholesalers</span></td>
                            <td style="padding:6px 8px; text-align:right;"><button type="button" class="wp-button" style="height:20px; font-size:10px; color:#b32d2e;" onclick="deleteVolumeTier('tier-row-3')">✕</button></td>
                        </tr>

                        <!-- Tier 4: Bulk 100+ -->
                        <tr id="tier-row-4" style="background:#FAF5E8;">
                            <td style="padding:6px 8px;"><strong style="color:#8A681F;">Tier 4: Master Lot 100+</strong></td>
                            <td style="padding:6px 8px;"><code style="background:#fff; font-weight:700;">100 - 199 pcs</code></td>
                            <td style="padding:6px 8px;"><input type="number" class="adm-form-input tier-price" style="width:100px; height:26px; padding:0 6px; font-weight:700; color:#8A681F;" value="2350"></td>
                            <td style="padding:6px 8px;"><span class="adm-badge gold" style="font-size:10.5px; padding:1px 6px;">Master Wholesalers</span></td>
                            <td style="padding:6px 8px; text-align:right;"><button type="button" class="wp-button" style="height:20px; font-size:10px; color:#b32d2e;" onclick="deleteVolumeTier('tier-row-4')">✕</button></td>
                        </tr>

                        <!-- Tier 5: Factory 200+ -->
                        <tr id="tier-row-5" style="background:#F0FDF4;">
                            <td style="padding:6px 8px;"><strong style="color:#15803D;">Tier 5: Direct Mill Container 200+</strong></td>
                            <td style="padding:6px 8px;"><code style="background:#fff; font-weight:700; color:#15803D;">200+ pcs</code></td>
                            <td style="padding:6px 8px;"><input type="number" class="adm-form-input tier-price" style="width:100px; height:26px; padding:0 6px; font-weight:700; color:#15803D;" value="2180"></td>
                            <td style="padding:6px 8px;"><span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-size:10.5px; padding:1px 6px;">Mill Distributors</span></td>
                            <td style="padding:6px 8px; text-align:right;"><button type="button" class="wp-button" style="height:20px; font-size:10px; color:#b32d2e;" onclick="deleteVolumeTier('tier-row-5')">✕</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function addNewVolumeTier() {
    const minQty = prompt('Enter Minimum Quantity for new volume tier (e.g. 500):', '500');
    if (!minQty || isNaN(minQty)) return;

    const price = prompt(`Enter Unit Price (₹) for ${minQty}+ pcs:`, '2120');
    if (!price || isNaN(price)) return;

    const newId = 'tier-row-' + Date.now();
    const tbody = document.getElementById('dtVolumeTierBody');
    const tr = document.createElement('tr');
    tr.id = newId;
    tr.style.background = '#FAF5E8';
    tr.innerHTML = `
        <td style="padding:6px 8px;"><strong style="color:#8A681F;">Tier: Factory Lot ${minQty}+</strong></td>
        <td style="padding:6px 8px;"><code>${minQty}+ pcs</code></td>
        <td style="padding:6px 8px;"><input type="number" class="adm-form-input tier-price" style="width:100px; height:26px; padding:0 6px; font-weight:700; color:#8A681F;" value="${price}"></td>
        <td style="padding:6px 8px;"><span class="adm-badge gold" style="font-size:10.5px; padding:1px 6px;">Super Wholesalers</span></td>
        <td style="padding:6px 8px; text-align:right;"><button type="button" class="wp-button" style="height:20px; font-size:10px; color:#b32d2e;" onclick="deleteVolumeTier('${newId}')">✕</button></td>
    `;
    tbody.appendChild(tr);

    if (typeof window.showToast === 'function') {
        window.showToast(`✨ Volume Tier ${minQty}+ pcs added!`);
    }
}

function deleteVolumeTier(id) {
    const row = document.getElementById(id);
    if (row) {
        row.remove();
        if (typeof window.showToast === 'function') {
            window.showToast('Volume tier removed');
        }
    }
}
</script>
