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

    <!-- ══ 1. 4-CARD PRICING KPI RIBBON ══ -->
    <div class="dt-pricing-kpi-grid">
        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">ACTIVE MARGIN TIERS</span>
                <div class="dt-pricing-kpi-icon">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val">4 Tiers</div>
            <div class="dt-pricing-kpi-bot">
                <span>Platinum, Gold, Silver, Bronze</span>
                <span style="color:#8A681F; font-weight:800;">100% Configured</span>
            </div>
        </div>

        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">CATALOG COVERAGE</span>
                <div class="dt-pricing-kpi-icon blue">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val">1,240 SKUs</div>
            <div class="dt-pricing-kpi-bot">
                <span>16 Fabric Categories</span>
                <span style="color:#1D4ED8; font-weight:800;">Live B2B Pricing</span>
            </div>
        </div>

        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">AVG WHOLESALE DISCOUNT</span>
                <div class="dt-pricing-kpi-icon emerald">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val" style="color:#15803D;">28.5% OFF</div>
            <div class="dt-pricing-kpi-bot">
                <span>Across All Categories</span>
                <span style="color:#15803D; font-weight:800;">₹2,470 Avg / Saree</span>
            </div>
        </div>

        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">VOLUME SLAB REBATE</span>
                <div class="dt-pricing-kpi-icon">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val" style="color:#8A681F;">+6.5% Max</div>
            <div class="dt-pricing-kpi-bot">
                <span>For Lots > 250 Sarees</span>
                <span style="color:#8A681F; font-weight:800;">Factory Direct</span>
            </div>
        </div>
    </div>

    <!-- ══ 2. TIER SELECTION STRIP (LUXURY SEGMENTED CONTROLS) ══ -->
    <div class="dt-card" style="padding:14px 18px;">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
            <div>
                <span style="font-size:0.68rem; color:#8A681F; font-weight:800; text-transform:uppercase; letter-spacing:0.04em;">TIER MARGIN MATRIX</span>
                <h4 style="font-size:0.95rem; font-weight:800; color:#181512; margin:2px 0 0 0;">Select Commercial Tier to Preview Margins</h4>
            </div>
            <div class="dt-pricing-tier-pills-wrap">
                <button type="button" class="dt-pricing-tier-btn <?php echo (strpos($active_tier, 'platinum') !== false) ? 'active' : ''; ?>" onclick="switchPricingTier('platinum', 35, 'PLATINUM VIP (35% OFF)', this)">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span>Platinum VIP (35% Off)</span>
                </button>
                <button type="button" class="dt-pricing-tier-btn <?php echo (strpos($active_tier, 'gold') !== false) ? 'active' : ''; ?>" onclick="switchPricingTier('gold', 28, 'GOLD DISTRIBUTOR (28% OFF)', this)">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="8" r="6"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                    <span>Gold Distributor (28% Off)</span>
                </button>
                <button type="button" class="dt-pricing-tier-btn <?php echo (strpos($active_tier, 'silver') !== false) ? 'active' : ''; ?>" onclick="switchPricingTier('silver', 20, 'SILVER BULK (20% OFF)', this)">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>Silver Bulk (20% Off)</span>
                </button>
                <button type="button" class="dt-pricing-tier-btn <?php echo (strpos($active_tier, 'bronze') !== false) ? 'active' : ''; ?>" onclick="switchPricingTier('bronze', 12, 'BRONZE STARTER (12% OFF)', this)">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    <span>Bronze Starter (12% Off)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ══ 3. MAIN CATEGORY MARGINS TABLE ══ -->
    <div class="dt-card">
        <div class="dt-card-head">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:32px; height:32px; border-radius:8px; background:linear-gradient(135deg, #FFE57F, #D4AF37); border:1px solid #8A681F; display:flex; align-items:center; justify-content:center; color:#181512; font-weight:900; font-size:1.1rem; box-shadow:0 2px 6px rgba(184,134,11,0.25);">₹</div>
                <div>
                    <h4 class="dt-card-title" style="display:flex; align-items:center; gap:8px;">
                        <span>Assigned Wholesale Category Margins</span>
                        <span class="dt-status-pill-clean gold" id="activeTierNameLabel"><?php echo $wholesale ? htmlspecialchars($wholesale['tier_short']) : 'PLATINUM VIP (35% OFF)'; ?></span>
                    </h4>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <button type="button" class="dt-btn dt-btn-dark dt-btn-sm" onclick="openAddCategoryRuleModal()">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#FAF5E8" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
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
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div style="width:30px; height:30px; border-radius:8px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z"></path></svg>
                                    </div>
                                    <span class="cat-name-text" style="font-size:0.83rem;"><?php echo htmlspecialchars($m['cat']); ?></span>
                                </div>
                            </td>
                            <td style="text-align:center; white-space:nowrap;">
                                <span class="dt-status-pill-clean emerald margin-badge" style="font-size:0.76rem;"><?php echo $m['margin']; ?>% OFF</span>
                            </td>
                            <td style="text-align:center; font-weight:700; color:#8A681F; white-space:nowrap;" class="moq-cell"><?php echo $m['moq']; ?> pcs</td>
                            <td style="text-align:right; color:#78716C; text-decoration:line-through; white-space:nowrap; font-size:0.82rem;" class="retail-cell"><?php echo $m['retail_base']; ?></td>
                            <td style="text-align:right; font-weight:900; color:#15803D; font-size:0.92rem; white-space:nowrap;" class="whl-price-cell"><?php echo $m['whl_price']; ?></td>
                            <td style="text-align:right; white-space:nowrap;">
                                <span class="dt-status-pill-clean gold savings-cell" style="font-size:0.75rem;">₹<?php echo number_format($savings); ?></span>
                            </td>
                            <td style="text-align:right; white-space:nowrap; padding-right:18px;">
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openEditCategoryMarginModal('<?php echo addslashes($m['cat']); ?>', <?php echo $m['margin']; ?>, <?php echo $m['moq']; ?>, 'marginRow_<?php echo $idx; ?>')">
                                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    <span>Edit Margin</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ══ 4. DUAL BOTTOM CARDS: VOLUME REBATE SLABS & LIVE SIMULATOR ══ -->
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

        <!-- 2. Live Interactive B2B Pricing Calculator with Luxury Glass Result Box -->
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
                        <input type="number" id="calcMrpInput" value="3500" oninput="runPriceSimulator()" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.85rem; font-weight:800; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.7rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Order Saree Qty (Pcs)</label>
                        <input type="number" id="calcQtyInput" value="120" oninput="runPriceSimulator()" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.85rem; font-weight:800; box-sizing:border-box;">
                    </div>
                </div>

                <!-- Simulation Output Box (Master Obsidian Luxury Box) -->
                <div class="dt-sim-result-box">
                    <div class="dt-sim-item">
                        <span class="dt-sim-label">EFFECTIVE MARGIN:</span>
                        <strong id="calcEffectiveMargin" class="dt-sim-val green">39.0% OFF</strong>
                    </div>
                    <div class="dt-sim-item">
                        <span class="dt-sim-label">NET WHOLESALE / PC:</span>
                        <strong id="calcNetPricePerPc" class="dt-sim-val gold">₹2,135</strong>
                    </div>
                    <div class="dt-sim-item">
                        <span class="dt-sim-label">TOTAL PO INVOICE:</span>
                        <strong id="calcTotalInvoice" class="dt-sim-val">₹2,56,200</strong>
                    </div>
                    <div class="dt-sim-item">
                        <span class="dt-sim-label">WHOLESALER SAVINGS:</span>
                        <strong id="calcTotalSavings" class="dt-sim-val green">₹1,63,800</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


