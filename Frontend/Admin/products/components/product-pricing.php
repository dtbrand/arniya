<?php
/**
 * product-pricing.php — Smart Auto-Markup Pricing & Multi-Tier Volume Schedule
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" style="color:#8A681F;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <span>Price &amp; Smart Multi-Tier Volume Schedule</span>
        </h3>
        <div style="display:flex; align-items:center; gap:6px;">
            <button type="button" class="wp-button secondary" id="btnAutoMarkupToggle" onclick="toggleAutoMarkup()" style="font-size:11.5px; height:26px;">
                <span id="autoMarkupStatusIcon">⚡</span>
                <span id="autoMarkupStatusText">Auto-Markup: ON</span>
            </button>
            <button type="button" class="wp-button" onclick="addNewVolumeTier()" style="font-size:11.5px; height:26px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Add Volume Tier</span>
            </button>
        </div>
    </div>
    <div class="dt-form-sec-body">
        
        <!-- Smart Markup Rule Visual Bar -->
        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.45); border-radius:6px; padding:8px 12px; margin-bottom:12px;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:6px;">
                <div style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#5A4210;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="#8A681F"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    <span>Auto Customer Markup Formula:</span>
                </div>
                <div style="display:flex; gap:6px; flex-wrap:wrap; font-size:11px;">
                    <span class="adm-badge" style="background:#fff; border:1px solid #E5E1D7; color:#181512;">&lt; ₹500 ➔ <strong>+₹200</strong></span>
                    <span class="adm-badge" style="background:#fff; border:1px solid #E5E1D7; color:#181512;">₹500 - ₹1200 ➔ <strong>+₹300</strong></span>
                    <span class="adm-badge" style="background:#fff; border:1px solid #E5E1D7; color:#181512;">₹1200 - ₹2000 ➔ <strong>+₹400</strong></span>
                    <span class="adm-badge gold">&gt; ₹2000 ➔ <strong>+₹500</strong></span>
                </div>
            </div>
        </div>

        <!-- 1. Core 4 Master Prices -->
        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label class="adm-form-label">Purchase Price (Weaving / Base Cost) ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormCost" class="adm-form-input" placeholder="e.g. 2100" value="2100" oninput="handleCostPriceChange(this.value)">
                <small style="color:#646970; font-size:11px; margin-top:3px; display:block;">Base cost automatically calculates customer price</small>
            </div>
            
            <div class="adm-form-group">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <label class="adm-form-label" style="margin:0;">Customer Sale Price (Retail) ₹ <span style="color:#b32d2e;">*</span></label>
                    <span id="badgeMarkupApplied" class="adm-badge gold" style="font-size:10px; padding:1px 5px;">+₹500 Added</span>
                </div>
                <input type="number" id="pFormRetail" class="adm-form-input" style="font-weight:700; color:#181512; background:#fff;" placeholder="e.g. 2600" value="2600" oninput="handleManualRetailChange(this.value)">
                <small id="retailPriceHint" style="color:#15803D; font-size:11px; margin-top:3px; display:block;">Auto-calculated: Base ₹2,100 + ₹500</small>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">Price (MRP / Regular Benchmark) ₹</label>
                <input type="number" id="pFormMrp" class="adm-form-input" placeholder="e.g. 3490" value="3490">
                <small style="color:#646970; font-size:11px; margin-top:3px; display:block;">Crossed-out anchor price</small>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">Reseller Price (WhatsApp Dropship) ₹</label>
                <input type="number" id="pFormReseller" class="adm-form-input" placeholder="e.g. 2350" value="2350">
                <small style="color:#7E22CE; font-size:11px; margin-top:3px; display:block;">Direct margin for WhatsApp resellers</small>
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
                        <!-- Tier 1: Retail Customer -->
                        <tr id="tier-row-1">
                            <td style="padding:6px 8px;"><strong>Tier 1: Single Piece (Customer)</strong></td>
                            <td style="padding:6px 8px;"><code>1 - 7 pcs</code></td>
                            <td style="padding:6px 8px;"><input type="number" id="tier1PriceInput" class="adm-form-input tier-price" style="width:100px; height:26px; padding:0 6px; font-weight:700;" value="2600" oninput="document.getElementById('pFormRetail').value=this.value;"></td>
                            <td style="padding:6px 8px;"><span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px; padding:1px 6px;">Customers</span></td>
                            <td style="padding:6px 8px; text-align:right;"><span style="color:#8c8f94; font-size:11px;">Base</span></td>
                        </tr>

                        <!-- Tier 2: Wholesale 8+ -->
                        <tr id="tier-row-2">
                            <td style="padding:6px 8px;"><strong>Tier 2: Semi-Wholesale (Shop MOQ)</strong></td>
                            <td style="padding:6px 8px;"><code>8 - 29 pcs</code></td>
                            <td style="padding:6px 8px;"><input type="number" id="tier2PriceInput" class="adm-form-input tier-price" style="width:100px; height:26px; padding:0 6px;" value="2350"></td>
                            <td style="padding:6px 8px;"><span class="adm-badge" style="background:#FAF5FF; color:#7E22CE; font-size:10.5px; padding:1px 6px;">Retailers</span></td>
                            <td style="padding:6px 8px; text-align:right;"><button type="button" class="wp-button" style="height:20px; font-size:10px; color:#b32d2e;" onclick="deleteVolumeTier('tier-row-2')">✕</button></td>
                        </tr>

                        <!-- Tier 3: Bulk 30+ -->
                        <tr id="tier-row-3">
                            <td style="padding:6px 8px;"><strong>Tier 3: Bulk Consignment</strong></td>
                            <td style="padding:6px 8px;"><code>30 - 99 pcs</code></td>
                            <td style="padding:6px 8px;"><input type="number" id="tier3PriceInput" class="adm-form-input tier-price" style="width:100px; height:26px; padding:0 6px;" value="2250"></td>
                            <td style="padding:6px 8px;"><span class="adm-badge gold" style="font-size:10.5px; padding:1px 6px;">Wholesalers</span></td>
                            <td style="padding:6px 8px; text-align:right;"><button type="button" class="wp-button" style="height:20px; font-size:10px; color:#b32d2e;" onclick="deleteVolumeTier('tier-row-3')">✕</button></td>
                        </tr>

                        <!-- Tier 4: Bulk 100+ -->
                        <tr id="tier-row-4" style="background:#FAF5E8;">
                            <td style="padding:6px 8px;"><strong style="color:#8A681F;">Tier 4: Master Lot 100+</strong></td>
                            <td style="padding:6px 8px;"><code style="background:#fff; font-weight:700;">100 - 199 pcs</code></td>
                            <td style="padding:6px 8px;"><input type="number" id="tier4PriceInput" class="adm-form-input tier-price" style="width:100px; height:26px; padding:0 6px; font-weight:700; color:#8A681F;" value="2180"></td>
                            <td style="padding:6px 8px;"><span class="adm-badge gold" style="font-size:10.5px; padding:1px 6px;">Master Wholesalers</span></td>
                            <td style="padding:6px 8px; text-align:right;"><button type="button" class="wp-button" style="height:20px; font-size:10px; color:#b32d2e;" onclick="deleteVolumeTier('tier-row-4')">✕</button></td>
                        </tr>

                        <!-- Tier 5: Factory 200+ -->
                        <tr id="tier-row-5" style="background:#F0FDF4;">
                            <td style="padding:6px 8px;"><strong style="color:#15803D;">Tier 5: Direct Mill Container 200+</strong></td>
                            <td style="padding:6px 8px;"><code style="background:#fff; font-weight:700; color:#15803D;">200+ pcs</code></td>
                            <td style="padding:6px 8px;"><input type="number" id="tier5PriceInput" class="adm-form-input tier-price" style="width:100px; height:26px; padding:0 6px; font-weight:700; color:#15803D;" value="2120"></td>
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
let autoMarkupEnabled = true;

/**
 * Formula:
 * - < 500     => +200
 * - 500-1200  => +300
 * - 1200-2000 => +400
 * - > 2000    => +500
 */
function getMarkupAmount(cost) {
    if (cost < 500) return 200;
    if (cost <= 1200) return 300;
    if (cost <= 2000) return 400;
    return 500;
}

function handleCostPriceChange(val) {
    const cost = parseFloat(val) || 0;
    if (cost <= 0) return;

    if (autoMarkupEnabled) {
        const markup = getMarkupAmount(cost);
        const customerPrice = cost + markup;
        const mrp = Math.round(customerPrice * 1.35 / 10) * 10;
        const reseller = Math.round((cost + (markup * 0.5)) / 10) * 10;

        document.getElementById('pFormRetail').value = customerPrice;
        document.getElementById('pFormMrp').value = mrp;
        document.getElementById('pFormReseller').value = reseller;
        
        const tier1 = document.getElementById('tier1PriceInput');
        if (tier1) tier1.value = customerPrice;

        const badge = document.getElementById('badgeMarkupApplied');
        if (badge) badge.textContent = `+₹${markup} Added`;

        const hint = document.getElementById('retailPriceHint');
        if (hint) {
            hint.textContent = `Auto-calculated: Base ₹${cost.toLocaleString('en-IN')} + ₹${markup}`;
            hint.style.color = '#15803D';
        }
    }
}

function handleManualRetailChange(val) {
    const customerPrice = parseFloat(val) || 0;
    const tier1 = document.getElementById('tier1PriceInput');
    if (tier1) tier1.value = customerPrice;

    const hint = document.getElementById('retailPriceHint');
    if (hint) {
        hint.textContent = 'Custom manual price set';
        hint.style.color = '#7A7266';
    }
    const badge = document.getElementById('badgeMarkupApplied');
    if (badge) badge.textContent = 'Custom';
}

function toggleAutoMarkup() {
    autoMarkupEnabled = !autoMarkupEnabled;
    const text = document.getElementById('autoMarkupStatusText');
    const icon = document.getElementById('autoMarkupStatusIcon');
    const btn = document.getElementById('btnAutoMarkupToggle');

    if (autoMarkupEnabled) {
        text.textContent = 'Auto-Markup: ON';
        icon.textContent = '⚡';
        btn.classList.remove('secondary');
        const costVal = document.getElementById('pFormCost')?.value || 2100;
        handleCostPriceChange(costVal);
        if (typeof window.showToast === 'function') {
            window.showToast('⚡ Smart Auto-Markup enabled (+200 / +300 / +400 / +500)');
        }
    } else {
        text.textContent = 'Auto-Markup: OFF (Manual)';
        icon.textContent = '✏️';
        btn.classList.add('secondary');
        if (typeof window.showToast === 'function') {
            window.showToast('✏️ Manual edit mode active');
        }
    }
}

function addNewVolumeTier() {
    const minQty = prompt('Enter Minimum Quantity for new volume tier (e.g. 500):', '500');
    if (!minQty || isNaN(minQty)) return;

    const price = prompt(`Enter Unit Price (₹) for ${minQty}+ pcs:`, '2100');
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
