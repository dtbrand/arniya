<?php
/**
 * wholesale-pricing.php — DT Brand's & Jai Hanuman Tex
 * Multi-Tier Wholesale Margin Rules, Volume Slabs & Dynamic Pricing Calculator (100% Dynamic)
 */
require_once __DIR__ . '/wholesale-data.php';
$whl_id = isset($_GET['id']) ? $_GET['id'] : (isset($wholesale['id']) ? $wholesale['id'] : null);
$wholesale = $whl_id ? getWholesalePartner($whl_id) : null;
$active_tier = $wholesale ? $wholesale['tier_raw'] : 'platinum wholesale';
$category_margins = getWholesaleCategoryMargins($wholesale ? $wholesale['id'] : 'WHL-8012');
?>

<div style="display:flex; flex-direction:column; gap:16px;">
    <!-- ══ TIER SELECTION STRIP (INTERACTIVE) ══ -->
    <div class="dt-card" style="padding:14px 18px;">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
            <div>
                <span style="font-size:0.68rem; color:#8A681F; font-weight:800; text-transform:uppercase; letter-spacing:0.04em;">TIER MARGIN PROFILE</span>
                <h4 style="font-size:0.95rem; font-weight:800; color:#181512; margin:2px 0 0 0;">Active Commercial Margin Tier</h4>
            </div>
            <div class="dt-wholesale-tabs-nav" style="border:none; padding:0; width:auto; gap:6px;">
                <button type="button" class="dt-wholesale-tab-btn <?php echo (strpos($active_tier, 'platinum') !== false) ? 'active' : ''; ?>" onclick="switchPricingTier('platinum', 35, 'PLATINUM VIP', this)">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span>Platinum VIP (35% Off)</span>
                </button>
                <button type="button" class="dt-wholesale-tab-btn <?php echo (strpos($active_tier, 'gold') !== false) ? 'active' : ''; ?>" onclick="switchPricingTier('gold', 28, 'GOLD VIP', this)">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="8" r="6"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                    <span>Gold Distributor (28% Off)</span>
                </button>
                <button type="button" class="dt-wholesale-tab-btn <?php echo (strpos($active_tier, 'silver') !== false) ? 'active' : ''; ?>" onclick="switchPricingTier('silver', 20, 'SILVER BULK', this)">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>Silver Bulk (20% Off)</span>
                </button>
                <button type="button" class="dt-wholesale-tab-btn <?php echo (strpos($active_tier, 'bronze') !== false) ? 'active' : ''; ?>" onclick="switchPricingTier('bronze', 12, 'BRONZE STARTER', this)">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    <span>Bronze Starter (12% Off)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ══ MAIN CATEGORY MARGINS TABLE ══ -->
    <div class="dt-card">
        <div class="dt-card-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                <h4 class="dt-card-title">Assigned Wholesale Category Margins (<span id="activeTierNameLabel"><?php echo $wholesale ? htmlspecialchars($wholesale['tier_short']) : 'PLATINUM VIP'; ?></span>)</h4>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openAddCategoryRuleModal()">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Add Category Rule</span>
                </button>
                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="recalculateAllWholesaleMargins()">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.3"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                    <span>Sync Live Margins</span>
                </button>
            </div>
        </div>

        <div class="dt-wholesale-table-wrap">
            <table class="dt-wholesale-table" id="pricingCategoryTable">
                <thead>
                    <tr>
                        <th style="white-space:nowrap;">Fabric / Saree Category</th>
                        <th style="text-align:center; white-space:nowrap;">Assigned Margin</th>
                        <th style="text-align:center; white-space:nowrap;">Min Lot (MOQ)</th>
                        <th style="text-align:right; white-space:nowrap;">Sample Retail MRP</th>
                        <th style="text-align:right; white-space:nowrap;">Net Wholesale B2B Price</th>
                        <th style="text-align:right; white-space:nowrap;">Per Saree Savings</th>
                        <th style="text-align:right; white-space:nowrap; padding-right:18px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="pricingCategoryTableBody">
                    <?php foreach ($category_margins as $idx => $m): 
                        $retail_num = (float)str_replace(['₹', ','], '', $m['retail_base']);
                        $whl_num = (float)str_replace(['₹', ','], '', $m['whl_price']);
                        $savings = max(0, $retail_num - $whl_num);
                    ?>
                        <tr id="marginRow_<?php echo $idx; ?>" data-cat="<?php echo htmlspecialchars($m['cat']); ?>" data-retail="<?php echo $retail_num; ?>" data-offset="<?php echo ($m['margin'] - (isset($wholesale['margin_pct']) ? $wholesale['margin_pct'] : 35)); ?>">
                            <td style="font-weight:800; color:#181512; white-space:nowrap;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div style="width:28px; height:28px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z"></path></svg>
                                    </div>
                                    <span class="cat-name-text"><?php echo htmlspecialchars($m['cat']); ?></span>
                                </div>
                            </td>
                            <td style="text-align:center; white-space:nowrap;">
                                <span class="dt-status-pill-clean emerald margin-badge" style="font-size:0.75rem;"><?php echo $m['margin']; ?>% OFF</span>
                            </td>
                            <td style="text-align:center; font-weight:700; color:#8A681F; white-space:nowrap;" class="moq-cell"><?php echo $m['moq']; ?> pcs</td>
                            <td style="text-align:right; color:#78716C; text-decoration:line-through; white-space:nowrap;" class="retail-cell"><?php echo $m['retail_base']; ?></td>
                            <td style="text-align:right; font-weight:900; color:#15803D; font-size:0.88rem; white-space:nowrap;" class="whl-price-cell"><?php echo $m['whl_price']; ?></td>
                            <td style="text-align:right; font-weight:800; color:#8A681F; font-size:0.8rem; white-space:nowrap;" class="savings-cell">₹<?php echo number_format($savings); ?></td>
                            <td style="text-align:right; white-space:nowrap; padding-right:18px;">
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openEditCategoryMarginModal('<?php echo addslashes($m['cat']); ?>', <?php echo $m['margin']; ?>, <?php echo $m['moq']; ?>, 'marginRow_<?php echo $idx; ?>')">
                                    <span>Edit Margin</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ══ DUAL BOTTOM CARDS: VOLUME REBATE SLABS & LIVE SIMULATOR ══ -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:16px;">
        
        <!-- 1. Volume Slabs Table -->
        <div class="dt-card">
            <div class="dt-card-head">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <h4 class="dt-card-title">Bulk Order Volume Rebate Slabs</h4>
                </div>
                <span class="dt-status-pill-clean gold">Cumulative Discount</span>
            </div>
            <div style="padding:16px;">
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px 14px; font-size:0.78rem;">
                        <div>
                            <strong style="color:#181512;">Standard Lot (12 – 49 Sarees)</strong>
                            <small style="display:block; color:#78716C; font-size:0.68rem;">Base Tier Category Margin</small>
                        </div>
                        <span class="dt-status-pill-clean blue">Base Margin</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px 14px; font-size:0.78rem;">
                        <div>
                            <strong style="color:#181512;">Tier-1 Volume (50 – 99 Sarees)</strong>
                            <small style="display:block; color:#78716C; font-size:0.68rem;">+2.0% Additional lot discount</small>
                        </div>
                        <span class="dt-status-pill-clean emerald">+2.0% EXTRA</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px 14px; font-size:0.78rem;">
                        <div>
                            <strong style="color:#181512;">Tier-2 Volume (100 – 249 Sarees)</strong>
                            <small style="display:block; color:#78716C; font-size:0.68rem;">+4.0% Additional lot discount</small>
                        </div>
                        <span class="dt-status-pill-clean emerald">+4.0% EXTRA</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px 14px; font-size:0.78rem;">
                        <div>
                            <strong style="color:#181512;">Master Container (250+ Sarees)</strong>
                            <small style="display:block; color:#78716C; font-size:0.68rem;">+6.5% Direct factory procurement discount</small>
                        </div>
                        <span class="dt-status-pill-clean gold">+6.5% FACTORY REBATE</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Live Interactive B2B Pricing Calculator -->
        <div class="dt-card">
            <div class="dt-card-head">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="8" y1="6" x2="16" y2="6"></line><line x1="16" y1="14" x2="16" y2="18"></line><path d="M8 10h.01M12 10h.01M16 10h.01M8 14h.01M12 14h.01M8 18h.01M12 18h.01"></path></svg>
                    <h4 class="dt-card-title">Live B2B Pricing &amp; Margin Simulator</h4>
                </div>
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="resetPricingCalculator()">Reset</button>
            </div>
            <div style="padding:16px; display:flex; flex-direction:column; gap:12px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.7rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Sample Retail MRP (₹)</label>
                        <input type="number" id="calcMrpInput" value="3500" oninput="runPriceSimulator()" style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.82rem; font-weight:800; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.7rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Order Saree Qty</label>
                        <input type="number" id="calcQtyInput" value="120" oninput="runPriceSimulator()" style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.82rem; font-weight:800; box-sizing:border-box;">
                    </div>
                </div>

                <!-- Simulation Output Box -->
                <div style="background:#FAF8F4; border:1.5px solid #D4AF37; border-radius:8px; padding:12px; display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <span style="font-size:0.65rem; color:#78716C; font-weight:700; display:block;">EFFECTIVE MARGIN:</span>
                        <strong id="calcEffectiveMargin" style="font-size:1.15rem; color:#15803D; font-weight:900;">39.0% OFF</strong>
                    </div>
                    <div>
                        <span style="font-size:0.65rem; color:#78716C; font-weight:700; display:block;">NET WHOLESALE / PC:</span>
                        <strong id="calcNetPricePerPc" style="font-size:1.15rem; color:#181512; font-weight:900;">₹2,135</strong>
                    </div>
                    <div>
                        <span style="font-size:0.65rem; color:#78716C; font-weight:700; display:block;">TOTAL PO INVOICE (₹):</span>
                        <strong id="calcTotalInvoice" style="font-size:0.95rem; color:#8A681F; font-weight:900;">₹2,56,200</strong>
                    </div>
                    <div>
                        <span style="font-size:0.65rem; color:#78716C; font-weight:700; display:block;">WHOLESALER SAVINGS:</span>
                        <strong id="calcTotalSavings" style="font-size:0.95rem; color:#15803D; font-weight:900;">₹1,63,800</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

