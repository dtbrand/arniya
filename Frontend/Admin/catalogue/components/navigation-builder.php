<?php
/**
 * navigation-builder.php — Visual Menu & Mega Menu Navigation Builder Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            <span>Visual Navigation &amp; Mega Menu Builder</span>
        </h3>
        <button type="button" class="dt-btn-action-sm gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('✅ Navigation menu updated live!')" style="height:28px; padding:0 12px; font-size:11px;">Save Menu Structure</button>
    </div>

    <div style="padding:16px;">
        <div class="dt-nav-builder-layout">
            <!-- Available Items to Add -->
            <div class="dt-nav-avail-box">
                <h4 style="font-size:12.5px; font-weight:800; color:#181512; margin:0 0 10px 0;">Add Custom Menu Link</h4>
                <div class="dt-form-group">
                    <label class="dt-form-label">Link Label</label>
                    <input type="text" id="newMenuTitle" class="dt-form-input" placeholder="e.g. Surat Wholesale Depot">
                </div>
                <div class="dt-form-group">
                    <label class="dt-form-label">Destination URL</label>
                    <input type="text" id="newMenuUrl" class="dt-form-input" placeholder="e.g. /wholesale/">
                </div>
                <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.addMenuItem()" style="width:100%; height:30px; justify-content:center; font-size:11px;">+ Add to Menu</button>
            </div>

            <!-- Active Menu Structure List -->
            <div class="dt-nav-struct-box">
                <h4 style="font-size:12.5px; font-weight:800; color:#181512; margin:0 0 10px 0;">Main Store Header Navigation Tree</h4>
                <ul class="dt-menu-nest-list" id="navMenuList">
                    <li class="dt-menu-nest-item">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="cursor:grab; color:#94a3b8;">☰</span>
                            <strong>Silk Sarees</strong>
                            <code style="font-size:10.5px; color:#64748b;">/shop/silk-sarees</code>
                        </div>
                        <div style="display:flex; gap:4px;">
                            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.toggleIndent(this)" style="height:24px; padding:0 8px; font-size:10.5px;">Indent</button>
                            <button type="button" class="dt-btn-action-sm danger" onclick="this.closest('.dt-menu-nest-item').remove()" style="height:24px; padding:0 8px; font-size:10.5px;">Remove</button>
                        </div>
                    </li>
                    <li class="dt-menu-nest-item is-child">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="cursor:grab; color:#94a3b8;">☰</span>
                            <strong>Kanjivaram Silk</strong>
                            <code style="font-size:10.5px; color:#64748b;">/shop/silk-sarees/kanjivaram</code>
                        </div>
                        <div style="display:flex; gap:4px;">
                            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.toggleIndent(this)" style="height:24px; padding:0 8px; font-size:10.5px;">Indent</button>
                            <button type="button" class="dt-btn-action-sm danger" onclick="this.closest('.dt-menu-nest-item').remove()" style="height:24px; padding:0 8px; font-size:10.5px;">Remove</button>
                        </div>
                    </li>
                    <li class="dt-menu-nest-item">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="cursor:grab; color:#94a3b8;">☰</span>
                            <strong>Bridal Lehengas</strong>
                            <code style="font-size:10.5px; color:#64748b;">/shop/bridal-lehengas</code>
                        </div>
                        <div style="display:flex; gap:4px;">
                            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.toggleIndent(this)" style="height:24px; padding:0 8px; font-size:10.5px;">Indent</button>
                            <button type="button" class="dt-btn-action-sm danger" onclick="this.closest('.dt-menu-nest-item').remove()" style="height:24px; padding:0 8px; font-size:10.5px;">Remove</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mega Menu Preview Box -->
        <div style="margin-top:20px;">
            <h4 style="font-size:13px; font-weight:800; color:#181512; margin-bottom:8px;">Live Mega Menu Desktop Layout Preview</h4>
            <div class="dt-mega-menu-grid">
                <div>
                    <div class="dt-mega-col-title">Silk Sarees</div>
                    <a href="javascript:void(0)" class="dt-mega-link">Kanjivaram Silk</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Banarasi Brocade</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Chanderi Zari</a>
                </div>
                <div>
                    <div class="dt-mega-col-title">Bridal Wear</div>
                    <a href="javascript:void(0)" class="dt-mega-link">Zardosi Lehengas</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Semi-Stitched Sets</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Festive Anarkalis</a>
                </div>
                <div>
                    <div class="dt-mega-col-title">Collections</div>
                    <a href="javascript:void(0)" class="dt-mega-link">Surat Heritage 2026</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Festive Season Lot</a>
                    <a href="javascript:void(0)" class="dt-mega-link">New Arrivals</a>
                </div>
                <div>
                    <div class="dt-mega-col-title">Wholesale B2B</div>
                    <a href="javascript:void(0)" class="dt-mega-link">Surat Central Depot</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Bulk MOQ Enquiries</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Reseller Hub</a>
                </div>
            </div>
        </div>
    </div>
</div>
