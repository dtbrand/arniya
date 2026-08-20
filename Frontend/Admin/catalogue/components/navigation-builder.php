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
        <button type="button" class="dt-btn-action-sm gold" onclick="if(window.DT_NAVIGATION) window.DT_NAVIGATION.saveMenu(); else if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('✅ Navigation menu updated live!')" style="height:28px; padding:0 12px; font-size:11px;">Save Menu Structure</button>
    </div>

    <div style="padding:16px;">
        <div class="dt-nav-builder-layout">
            <!-- Left Side: Add Links & Presets Box -->
            <div>
                <!-- Add Custom Link -->
                <div class="dt-nav-avail-box" style="margin-bottom:14px;">
                    <h4 style="font-size:12.5px; font-weight:800; color:#181512; margin:0 0 10px 0; display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                        <span>Add Custom Menu Link</span>
                    </h4>
                    <div class="dt-form-group">
                        <label class="dt-form-label">Link Text / Label <span style="color:#DC2626;">*</span></label>
                        <input type="text" id="newMenuTitle" class="dt-form-input" placeholder="e.g. Surat Wholesale Depot">
                    </div>
                    <div class="dt-form-group">
                        <label class="dt-form-label">Destination URL</label>
                        <input type="text" id="newMenuUrl" class="dt-form-input" placeholder="e.g. /wholesale/surat-depot">
                    </div>
                    <button type="button" class="dt-btn-action-sm gold" onclick="window.DT_NAVIGATION.addMenuItem()" style="width:100%; height:32px; justify-content:center; font-size:11.5px; font-weight:800;">+ Add to Menu Tree</button>
                </div>

                <!-- Quick Category Inserter -->
                <div class="dt-nav-avail-box">
                    <h4 style="font-size:12px; font-weight:800; color:#181512; margin:0 0 8px 0;">Quick Add Categories</h4>
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.quickAdd('Silk Sarees', '/shop/silk-sarees')" style="justify-content:space-between; height:26px; font-size:11px;">
                            <span>Silk Sarees</span>
                            <span style="color:#8A681F; font-weight:800;">+ Add</span>
                        </button>
                        <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.quickAdd('Bridal Lehengas', '/shop/bridal-lehengas')" style="justify-content:space-between; height:26px; font-size:11px;">
                            <span>Bridal Lehengas</span>
                            <span style="color:#8A681F; font-weight:800;">+ Add</span>
                        </button>
                        <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.quickAdd('Designer Kurtis', '/shop/designer-kurtis')" style="justify-content:space-between; height:26px; font-size:11px;">
                            <span>Designer Kurtis</span>
                            <span style="color:#8A681F; font-weight:800;">+ Add</span>
                        </button>
                        <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.quickAdd('Surat Heritage 2026', '/collection/surat-heritage-silk')" style="justify-content:space-between; height:26px; font-size:11px;">
                            <span>Surat Heritage 2026</span>
                            <span style="color:#8A681F; font-weight:800;">+ Add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Side: Active Menu Structure Tree -->
            <div class="dt-nav-struct-box">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; padding-bottom:8px; border-bottom:1px solid #f1f5f9;">
                    <div>
                        <h4 style="font-size:13px; font-weight:800; color:#181512; margin:0;">Main Store Header Navigation Tree</h4>
                        <div style="font-size:11px; color:#64748b; margin-top:2px;">Drag items with mouse to reorder hierarchy. Use Indent to create sub-menus.</div>
                    </div>
                    <span class="dt-badge gold" id="menuCountBadge">4 Top Items</span>
                </div>

                <ul class="dt-menu-nest-list" id="navMenuList">
                    <!-- Item 1 -->
                    <li class="dt-menu-nest-item" draggable="true" id="nav-item-1">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="dt-menu-drag-grip" title="Drag to reorder">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="9" cy="12" r="1.2"></circle><circle cx="9" cy="5" r="1.2"></circle><circle cx="9" cy="19" r="1.2"></circle><circle cx="15" cy="12" r="1.2"></circle><circle cx="15" cy="5" r="1.2"></circle><circle cx="15" cy="19" r="1.2"></circle></svg>
                            </span>
                            <strong class="dt-menu-label" style="font-size:12px; color:#181512;">Silk Sarees</strong>
                            <code class="dt-menu-url" style="font-size:10.5px; color:#64748b;">/shop/silk-sarees</code>
                        </div>
                        <div style="display:flex; gap:4px; align-items:center;">
                            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.toggleIndent(this)" style="height:24px; padding:0 8px; font-size:10.5px;">Indent →</button>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_NAVIGATION.removeItem(this)" style="height:24px; padding:0 6px; font-size:10.5px;">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </li>

                    <!-- Item 2 (Child) -->
                    <li class="dt-menu-nest-item is-child" draggable="true" id="nav-item-2">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="dt-menu-drag-grip" title="Drag to reorder">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="9" cy="12" r="1.2"></circle><circle cx="9" cy="5" r="1.2"></circle><circle cx="9" cy="19" r="1.2"></circle><circle cx="15" cy="12" r="1.2"></circle><circle cx="15" cy="5" r="1.2"></circle><circle cx="15" cy="19" r="1.2"></circle></svg>
                            </span>
                            <strong class="dt-menu-label" style="font-size:12px; color:#181512;">Kanjivaram Silk</strong>
                            <code class="dt-menu-url" style="font-size:10.5px; color:#64748b;">/shop/silk-sarees/kanjivaram</code>
                        </div>
                        <div style="display:flex; gap:4px; align-items:center;">
                            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.toggleIndent(this)" style="height:24px; padding:0 8px; font-size:10.5px;">← Outdent</button>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_NAVIGATION.removeItem(this)" style="height:24px; padding:0 6px; font-size:10.5px;">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </li>

                    <!-- Item 3 -->
                    <li class="dt-menu-nest-item" draggable="true" id="nav-item-3">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="dt-menu-drag-grip" title="Drag to reorder">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="9" cy="12" r="1.2"></circle><circle cx="9" cy="5" r="1.2"></circle><circle cx="9" cy="19" r="1.2"></circle><circle cx="15" cy="12" r="1.2"></circle><circle cx="15" cy="5" r="1.2"></circle><circle cx="15" cy="19" r="1.2"></circle></svg>
                            </span>
                            <strong class="dt-menu-label" style="font-size:12px; color:#181512;">Bridal Lehengas</strong>
                            <code class="dt-menu-url" style="font-size:10.5px; color:#64748b;">/shop/bridal-lehengas</code>
                        </div>
                        <div style="display:flex; gap:4px; align-items:center;">
                            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.toggleIndent(this)" style="height:24px; padding:0 8px; font-size:10.5px;">Indent →</button>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_NAVIGATION.removeItem(this)" style="height:24px; padding:0 6px; font-size:10.5px;">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </li>

                    <!-- Item 4 -->
                    <li class="dt-menu-nest-item" draggable="true" id="nav-item-4">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="dt-menu-drag-grip" title="Drag to reorder">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="9" cy="12" r="1.2"></circle><circle cx="9" cy="5" r="1.2"></circle><circle cx="9" cy="19" r="1.2"></circle><circle cx="15" cy="12" r="1.2"></circle><circle cx="15" cy="5" r="1.2"></circle><circle cx="15" cy="19" r="1.2"></circle></svg>
                            </span>
                            <strong class="dt-menu-label" style="font-size:12px; color:#181512;">Wholesale Hub</strong>
                            <code class="dt-menu-url" style="font-size:10.5px; color:#64748b;">/wholesale/</code>
                        </div>
                        <div style="display:flex; gap:4px; align-items:center;">
                            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.toggleIndent(this)" style="height:24px; padding:0 8px; font-size:10.5px;">Indent →</button>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_NAVIGATION.removeItem(this)" style="height:24px; padding:0 6px; font-size:10.5px;">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Dual Live Preview Box (Desktop Mega Menu vs Mobile Navigation Drawer) -->
        <div style="margin-top:20px; padding-top:16px; border-top:1px solid #e2e8f0;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <h4 style="font-size:13px; font-weight:800; color:#181512; margin:0;">Live Navigation Preview</h4>
                <div class="dt-device-switcher">
                    <button type="button" class="dt-device-btn active" id="btnNavDesk" onclick="window.DT_NAVIGATION.switchNavPreview('desk')">🖥️ Desktop Mega Menu</button>
                    <button type="button" class="dt-device-btn" id="btnNavMob" onclick="window.DT_NAVIGATION.switchNavPreview('mob')">📱 Mobile App Drawer</button>
                </div>
            </div>

            <!-- Desktop Mega Menu View -->
            <div id="navPrevDesk" class="dt-mega-menu-grid">
                <div>
                    <div class="dt-mega-col-title">Silk Sarees</div>
                    <a href="javascript:void(0)" class="dt-mega-link">Kanjivaram Silk</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Banarasi Brocade</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Chanderi Zari</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Tussar Silk Handloom</a>
                </div>
                <div>
                    <div class="dt-mega-col-title">Bridal Wear</div>
                    <a href="javascript:void(0)" class="dt-mega-link">Zardosi Velvet Lehengas</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Semi-Stitched Sets</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Festive Anarkalis</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Bridal Dupattas</a>
                </div>
                <div>
                    <div class="dt-mega-col-title">Collections</div>
                    <a href="javascript:void(0)" class="dt-mega-link">Surat Heritage 2026</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Festive Season Lot</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Reseller Low MOQ Deals</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Silk Mark Certified</a>
                </div>
                <div>
                    <div class="dt-mega-col-title">Wholesale B2B</div>
                    <a href="javascript:void(0)" class="dt-mega-link">Surat Central Depot</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Bulk MOQ Enquiries</a>
                    <a href="javascript:void(0)" class="dt-mega-link">Reseller WhatsApp Hub</a>
                    <a href="javascript:void(0)" class="dt-mega-link">GST Invoice Portal</a>
                </div>
            </div>

            <!-- Mobile Off-Canvas Drawer View -->
            <div id="navPrevMob" style="display:none; padding:10px 0;">
                <div class="dt-mobile-nav-drawer">
                    <div class="dt-mob-drawer-header">
                        <span>👑 DT BRAND'S MENU</span>
                        <span style="font-size:12px; color:#D4AF37;">✕</span>
                    </div>
                    <div class="dt-mob-drawer-body">
                        <a href="javascript:void(0)" class="dt-mob-menu-link">
                            <span>Silk Sarees</span>
                            <span>›</span>
                        </a>
                        <a href="javascript:void(0)" class="dt-mob-menu-link is-sub">
                            <span>└ Kanjivaram Silk</span>
                        </a>
                        <a href="javascript:void(0)" class="dt-mob-menu-link is-sub">
                            <span>└ Banarasi Brocade</span>
                        </a>
                        <a href="javascript:void(0)" class="dt-mob-menu-link">
                            <span>Bridal Lehengas</span>
                            <span>›</span>
                        </a>
                        <a href="javascript:void(0)" class="dt-mob-menu-link is-sub">
                            <span>└ Zardosi Velvet</span>
                        </a>
                        <a href="javascript:void(0)" class="dt-mob-menu-link">
                            <span>Collections</span>
                            <span>›</span>
                        </a>
                        <a href="javascript:void(0)" class="dt-mob-menu-link">
                            <span>Wholesale Depot</span>
                            <span style="color:#15803D; font-size:10px;">B2B</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
