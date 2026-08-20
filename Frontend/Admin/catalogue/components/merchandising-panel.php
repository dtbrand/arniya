<?php
/**
 * merchandising-panel.php — Visual Merchandising, Product Pinning & Sorting Rules Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
            <span>Visual Merchandising: Silk Sarees (Position Priority)</span>
        </h3>
        <div style="display:flex; gap:6px;">
            <select class="wp-select" style="height:28px; font-size:11.5px;">
                <option>Category: Silk Sarees</option>
                <option>Category: Bridal Lehengas</option>
                <option>Category: Designer Kurtis</option>
            </select>
            <button type="button" class="dt-btn-action-sm gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('✅ Merchandising order saved live!')" style="height:28px; padding:0 12px; font-size:11px;">Save Merchandising</button>
        </div>
    </div>

    <div style="padding:16px;">
        <div class="dt-merch-grid">
            <!-- Product 1 (Pinned) -->
            <div class="dt-merch-item is-pinned" id="merch-item-1">
                <span class="dt-merch-rank-badge">#1 PINNED</span>
                <img src="/Frontend/Shop/Asset/images/product1.png" class="dt-merch-img" alt="Kanjivaram Silk">
                <strong style="font-size:12px; color:#181512;">Kanjivaram Gold Zari</strong>
                <div style="font-size:11px; color:#15803D; font-weight:700; margin:2px 0;">₹2,850 <small style="color:#64748b;">(Wholesale)</small></div>
                <div class="dt-merch-ctrls">
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.togglePin(this, 'merch-item-1', 'Kanjivaram Gold Zari')" style="height:22px; padding:0 6px; font-size:10px;">⭐ Pinned</button>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.toggleHide(this, 'merch-item-1', 'Kanjivaram Gold Zari')" style="height:22px; padding:0 6px; font-size:10px;">👁️ Hide</button>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="dt-merch-item" id="merch-item-2">
                <span class="dt-merch-rank-badge">#2</span>
                <img src="/Frontend/Shop/Asset/images/product2.png" class="dt-merch-img" alt="Banarasi Saree">
                <strong style="font-size:12px; color:#181512;">Banarasi Royal Brocade</strong>
                <div style="font-size:11px; color:#15803D; font-weight:700; margin:2px 0;">₹3,200 <small style="color:#64748b;">(Wholesale)</small></div>
                <div class="dt-merch-ctrls">
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.togglePin(this, 'merch-item-2', 'Banarasi Royal Brocade')" style="height:22px; padding:0 6px; font-size:10px;">📌 Pin to Top</button>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.toggleHide(this, 'merch-item-2', 'Banarasi Royal Brocade')" style="height:22px; padding:0 6px; font-size:10px;">👁️ Hide</button>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="dt-merch-item" id="merch-item-3">
                <span class="dt-merch-rank-badge">#3</span>
                <img src="/Frontend/Shop/Asset/images/product3.png" class="dt-merch-img" alt="Temple Silk">
                <strong style="font-size:12px; color:#181512;">Temple Border Chanderi</strong>
                <div style="font-size:11px; color:#15803D; font-weight:700; margin:2px 0;">₹2,400 <small style="color:#64748b;">(Wholesale)</small></div>
                <div class="dt-merch-ctrls">
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.togglePin(this, 'merch-item-3', 'Temple Border Chanderi')" style="height:22px; padding:0 6px; font-size:10px;">📌 Pin to Top</button>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_MERCH.toggleHide(this, 'merch-item-3', 'Temple Border Chanderi')" style="height:22px; padding:0 6px; font-size:10px;">👁️ Hide</button>
                </div>
            </div>
        </div>
    </div>
</div>
