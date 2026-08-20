<?php
/**
 * banner-manager.php — Category & Collection Banner Manager Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            <span>Active Hero &amp; Category Banners (6 Slots)</span>
        </h3>
        <a href="/Frontend/Admin/catalogue/banners/add.php" class="dt-btn-action-sm gold" style="height:28px; padding:0 12px; font-size:11px;">+ Add Banner</a>
    </div>

    <div style="padding:16px;">
        <div class="dt-banner-grid">
            <!-- Banner 1 -->
            <div class="dt-banner-card">
                <img src="/Frontend/Shop/Asset/images/product1.png" class="dt-banner-preview" alt="Silk Banner">
                <div class="dt-banner-content">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="font-size:13px; color:#181512;">Kanjivaram Festive Header</strong>
                        <span class="dt-badge green" style="cursor:pointer;" onclick="window.DT_BANNERS.toggleStatus(this, 'Kanjivaram Festive Header')">Active</span>
                    </div>
                    <div style="font-size:11px; color:#64748b; margin:4px 0;">Target: <code>/shop/silk-sarees</code></div>
                    <div class="dt-banner-meta">
                        <span>Position: Top Hero</span>
                        <span>Schedule: Active</span>
                    </div>
                    <div style="display:flex; gap:6px; margin-top:10px;">
                        <a href="/Frontend/Admin/catalogue/banners/edit.php?id=1" class="dt-btn-action-sm pale-gold" style="flex:1; height:24px; font-size:11px; justify-content:center; text-decoration:none;">Edit</a>
                        <button type="button" class="dt-btn-action-sm danger" onclick="this.closest('.dt-banner-card').remove(); window.DT_CATALOGUE.showToast('Banner removed');" style="height:24px; padding:0 8px; font-size:11px;">Delete</button>
                    </div>
                </div>
            </div>

            <!-- Banner 2 -->
            <div class="dt-banner-card">
                <img src="/Frontend/Shop/Asset/images/product6.png" class="dt-banner-preview" alt="Bridal Banner">
                <div class="dt-banner-content">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="font-size:13px; color:#181512;">Bridal Season Spotlight</strong>
                        <span class="dt-badge green" style="cursor:pointer;" onclick="window.DT_BANNERS.toggleStatus(this, 'Bridal Season Spotlight')">Active</span>
                    </div>
                    <div style="font-size:11px; color:#64748b; margin:4px 0;">Target: <code>/shop/bridal-lehengas</code></div>
                    <div class="dt-banner-meta">
                        <span>Position: Mid Section</span>
                        <span>Schedule: Active</span>
                    </div>
                    <div style="display:flex; gap:6px; margin-top:10px;">
                        <a href="/Frontend/Admin/catalogue/banners/edit.php?id=2" class="dt-btn-action-sm pale-gold" style="flex:1; height:24px; font-size:11px; justify-content:center; text-decoration:none;">Edit</a>
                        <button type="button" class="dt-btn-action-sm danger" onclick="this.closest('.dt-banner-card').remove(); window.DT_CATALOGUE.showToast('Banner removed');" style="height:24px; padding:0 8px; font-size:11px;">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
