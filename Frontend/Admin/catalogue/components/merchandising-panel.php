<?php
/**
 * merchandising-panel.php — Visual Merchandising, Product Pinning & Sorting Rules Component
 * DT Brand's & Jai Hanuman Tex
 */
$display_cat_name = isset($cat_name) && !empty($cat_name) ? $cat_name : 'Silk Sarees';
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            <span>Visual Merchandising: <?php echo htmlspecialchars($display_cat_name); ?> (Position Priority)</span>
        </h3>
        <div style="display:flex; gap:6px; align-items:center;">
            <select class="wp-select" style="height:28px; font-size:11.5px; min-width:180px;">
                <option <?php echo $display_cat_name === 'Silk Sarees & Handlooms' ? 'selected' : ''; ?>>Category: Silk Sarees</option>
                <option <?php echo $display_cat_name === 'Bridal & Festive Lehengas' ? 'selected' : ''; ?>>Category: Bridal Lehengas</option>
                <option <?php echo $display_cat_name === 'Designer Kurtis & Tunics' ? 'selected' : ''; ?>>Category: Designer Kurtis</option>
                <option <?php echo $display_cat_name === 'Dress Materials & Unstitched' ? 'selected' : ''; ?>>Category: Dress Materials</option>
                <option <?php echo $display_cat_name === 'Banarasi Brocades' ? 'selected' : ''; ?>>Category: Banarasi Brocades</option>
            </select>
            <button type="button" class="dt-btn-action-sm gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('✅ Merchandising order saved live!')" style="height:28px; padding:0 12px; font-size:11px;">Save Merchandising</button>
        </div>
    </div>

    <div style="padding:16px;">
        <div class="dt-merch-grid">
            <!-- Product 1 (Pinned) -->
            <div class="dt-merch-item is-pinned" id="merch-item-1">
                <span class="dt-merch-rank-badge">#1 PINNED</span>
                <img src="/Frontend/Shop/Asset/images/product1.png" class="dt-merch-img" alt="Product 1">
                <strong style="font-size:12px; color:#181512;">Kanjivaram Gold Zari</strong>
                <div style="font-size:11px; color:#15803D; font-weight:700; margin:2px 0;">₹2,850 <small style="color:#64748b;">(Wholesale)</small></div>
                <div class="dt-merch-ctrls">
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.togglePin(this, 'merch-item-1', 'Kanjivaram Gold Zari')" style="height:22px; padding:0 6px; font-size:10px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="#8A681F" stroke="#8A681F" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Pinned</span>
                    </button>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.toggleHide(this, 'merch-item-1', 'Kanjivaram Gold Zari')" style="height:22px; padding:0 6px; font-size:10px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>Hide</span>
                    </button>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="dt-merch-item" id="merch-item-2">
                <span class="dt-merch-rank-badge">#2</span>
                <img src="/Frontend/Shop/Asset/images/product6.png" onerror="this.src='/Shared/Asset/images/product3.png';" class="dt-merch-img" alt="Product 2">
                <strong style="font-size:12px; color:#181512;">Royal Velvet Bridal Zardosi</strong>
                <div style="font-size:11px; color:#15803D; font-weight:700; margin:2px 0;">₹11,500 <small style="color:#64748b;">(Wholesale)</small></div>
                <div class="dt-merch-ctrls">
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.togglePin(this, 'merch-item-2', 'Royal Velvet Bridal Zardosi')" style="height:22px; padding:0 6px; font-size:10px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="12" y1="17" x2="12" y2="22"></line><path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"></path></svg>
                        <span>Pin to Top</span>
                    </button>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.toggleHide(this, 'merch-item-2', 'Royal Velvet Bridal Zardosi')" style="height:22px; padding:0 6px; font-size:10px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>Hide</span>
                    </button>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="dt-merch-item" id="merch-item-3">
                <span class="dt-merch-rank-badge">#3</span>
                <img src="/Frontend/Shop/Asset/images/product2.png" class="dt-merch-img" alt="Product 3">
                <strong style="font-size:12px; color:#181512;">Banarasi Kadhwa Brocade</strong>
                <div style="font-size:11px; color:#15803D; font-weight:700; margin:2px 0;">₹3,200 <small style="color:#64748b;">(Wholesale)</small></div>
                <div class="dt-merch-ctrls">
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.togglePin(this, 'merch-item-3', 'Banarasi Kadhwa Brocade')" style="height:22px; padding:0 6px; font-size:10px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="12" y1="17" x2="12" y2="22"></line><path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"></path></svg>
                        <span>Pin to Top</span>
                    </button>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.toggleHide(this, 'merch-item-3', 'Banarasi Kadhwa Brocade')" style="height:22px; padding:0 6px; font-size:10px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>Hide</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
