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
            <span>Active Hero &amp; Multi-Size Banners (6 Active Slots)</span>
        </h3>
        <div style="display:flex; gap:6px; align-items:center;">
            <a href="/DT%20Brand/admin/catalogue/banners/reorder.php" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px; text-decoration:none;">Reorder Banners</a>
            <a href="/DT%20Brand/admin/catalogue/banners/add.php" class="dt-btn-action-sm gold" style="height:28px; padding:0 12px; font-size:11px; text-decoration:none;">+ Add Banner</a>
        </div>
    </div>

    <div style="padding:16px;">
        <div class="dt-banner-grid">
            <!-- Banner 1 -->
            <div class="dt-banner-card">
                <div class="dt-banner-preview-box">
                    <img src="/assets/images/product1.png" class="dt-banner-preview" alt="Silk Banner">
                </div>
                <div class="dt-banner-content">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="font-size:13px; color:#181512;">Surat Heritage Silk Festival</strong>
                        <span class="dt-badge green" style="cursor:pointer;" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Banner status updated!')">Active</span>
                    </div>
                    <div class="dt-size-badge-wrap">
                        <span class="dt-size-pill desktop">🖥️ 1920 × 600 (16:5)</span>
                        <span class="dt-size-pill mobile">📱 1080 × 1350 (4:5)</span>
                    </div>
                    <div style="font-size:11px; color:#64748b; margin:2px 0;">Target: <code>/shop/silk-sarees</code></div>
                    <div class="dt-banner-meta">
                        <span>Slot: Homepage Main Hero</span>
                        <span style="color:#15803D; font-weight:700;">Priority #1</span>
                    </div>
                    <div style="display:flex; gap:6px; margin-top:10px;">
                        <a href="/DT%20Brand/admin/catalogue/banners/edit.php?id=1" class="dt-btn-action-sm pale-gold" style="flex:1; height:26px; font-size:11px; justify-content:center; text-decoration:none;">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <span>Edit Banner</span>
                        </a>
                        <button type="button" class="dt-btn-action-sm danger" onclick="this.closest('.dt-banner-card').remove(); if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Banner deleted successfully!');" style="height:26px; padding:0 8px; font-size:11px;">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Banner 2 -->
            <div class="dt-banner-card">
                <div class="dt-banner-preview-box">
                    <img src="/assets/images/product6.png" class="dt-banner-preview" alt="Bridal Banner">
                </div>
                <div class="dt-banner-content">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="font-size:13px; color:#181512;">Bridal Season Spotlight 2026</strong>
                        <span class="dt-badge green" style="cursor:pointer;" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Banner status updated!')">Active</span>
                    </div>
                    <div class="dt-size-badge-wrap">
                        <span class="dt-size-pill desktop">🖥️ 1920 × 450 (4:1)</span>
                        <span class="dt-size-pill mobile">📱 1080 × 1080 (1:1)</span>
                    </div>
                    <div style="font-size:11px; color:#64748b; margin:2px 0;">Target: <code>/shop/bridal-lehengas</code></div>
                    <div class="dt-banner-meta">
                        <span>Slot: Category Header</span>
                        <span style="color:#15803D; font-weight:700;">Priority #2</span>
                    </div>
                    <div style="display:flex; gap:6px; margin-top:10px;">
                        <a href="/DT%20Brand/admin/catalogue/banners/edit.php?id=2" class="dt-btn-action-sm pale-gold" style="flex:1; height:26px; font-size:11px; justify-content:center; text-decoration:none;">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <span>Edit Banner</span>
                        </a>
                        <button type="button" class="dt-btn-action-sm danger" onclick="this.closest('.dt-banner-card').remove(); if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Banner deleted successfully!');" style="height:26px; padding:0 8px; font-size:11px;">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Banner 3 -->
            <div class="dt-banner-card">
                <div class="dt-banner-preview-box">
                    <img src="/assets/images/product3.png" class="dt-banner-preview" alt="Reseller Deals Banner">
                </div>
                <div class="dt-banner-content">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="font-size:13px; color:#181512;">Reseller Low MOQ Mega Deals</strong>
                        <span class="dt-badge green" style="cursor:pointer;" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Banner status updated!')">Active</span>
                    </div>
                    <div class="dt-size-badge-wrap">
                        <span class="dt-size-pill desktop">🖥️ 1200 × 500 (12:5)</span>
                        <span class="dt-size-pill mobile">📱 1080 × 1350 (4:5)</span>
                    </div>
                    <div style="font-size:11px; color:#64748b; margin:2px 0;">Target: <code>/collection/reseller-low-moq</code></div>
                    <div class="dt-banner-meta">
                        <span>Slot: Collection Spotlight</span>
                        <span style="color:#15803D; font-weight:700;">Priority #3</span>
                    </div>
                    <div style="display:flex; gap:6px; margin-top:10px;">
                        <a href="/DT%20Brand/admin/catalogue/banners/edit.php?id=1" class="dt-btn-action-sm pale-gold" style="flex:1; height:26px; font-size:11px; justify-content:center; text-decoration:none;">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <span>Edit Banner</span>
                        </a>
                        <button type="button" class="dt-btn-action-sm danger" onclick="this.closest('.dt-banner-card').remove(); if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Banner deleted successfully!');" style="height:26px; padding:0 8px; font-size:11px;">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
