<?php
/**
 * product-variants.php — 100% Authentic WooCommerce Attributes & Variations Studio
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section" style="padding: 0; overflow: hidden; border: 1px solid #c3c4c7; border-radius: 4px; background: #fff;">
    <!-- 1. WooCommerce Product Data Header Bar -->
    <div style="background: #f6f7f7; border-bottom: 1px solid #c3c4c7; padding: 8px 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-weight: 700; font-size: 13px; color: #1d2327;">Product data:</span>
            <select class="adm-form-select" id="wcProductTypeSelect" style="width: auto; height: 28px; font-size: 12.5px; font-weight: 600; padding: 0 8px;" onchange="toggleWcProductType(this.value)">
                <option value="variable" selected>Variable product</option>
                <option value="simple">Simple product</option>
                <option value="grouped">Grouped product</option>
                <option value="external">External/Affiliate product</option>
            </select>
        </div>
        <div style="display: flex; align-items: center; gap: 12px; font-size: 12px; color: #2c3338;">
            <label style="display: flex; align-items: center; gap: 4px; cursor: pointer;">
                <input type="checkbox"> <span>Virtual</span>
            </label>
            <label style="display: flex; align-items: center; gap: 4px; cursor: pointer;">
                <input type="checkbox"> <span>Downloadable</span>
            </label>
        </div>
    </div>

    <!-- 2. WooCommerce Tabbed Container -->
    <div style="display: flex; min-height: 280px;">
        <!-- Left WooCommerce Tabs Sidebar -->
        <div style="width: 150px; background: #fafafa; border-right: 1px solid #c3c4c7; display: flex; flex-direction: column;">
            <button type="button" class="wc-tab-btn active" id="tabBtnAttributes" onclick="switchWcTab('attributes')" style="padding: 10px 12px; font-size: 12.5px; font-weight: 600; text-align: left; background: #fff; border: none; border-bottom: 1px solid #f0f0f1; border-left: 3px solid #8A681F; cursor: pointer; color: #1d2327; display: flex; align-items: center; gap: 6px;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                <span>Attributes</span>
            </button>
            <button type="button" class="wc-tab-btn" id="tabBtnVariations" onclick="switchWcTab('variations')" style="padding: 10px 12px; font-size: 12.5px; font-weight: 600; text-align: left; background: transparent; border: none; border-bottom: 1px solid #f0f0f1; border-left: 3px solid transparent; cursor: pointer; color: #646970; display: flex; align-items: center; gap: 6px;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                <span>Variations (<span id="wcVarCountBadge">3</span>)</span>
            </button>
        </div>

        <!-- Right WooCommerce Tab Panels -->
        <div style="flex: 1; padding: 14px 16px; background: #fff;">
            
            <!-- PANEL 1: ATTRIBUTES -->
            <div id="wcPanelAttributes">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <select id="wcNewAttrSelect" class="adm-form-select" style="width: 170px; height: 28px; font-size: 12px;">
                            <option value="Color">Custom product attribute</option>
                            <option value="Color">Color</option>
                            <option value="Size">Size / Length</option>
                            <option value="Fabric">Fabric Material</option>
                        </select>
                        <button type="button" class="wp-button" onclick="addWcAttributeBox()" style="height: 28px; font-size: 12px;">Add</button>
                    </div>
                    <button type="button" class="wp-button primary" onclick="saveWcAttributes()" style="height: 28px; font-size: 12px;">Save attributes</button>
                </div>

                <!-- Attribute Accordion 1: Color -->
                <div class="wc-attr-box" style="border: 1px solid #c3c4c7; border-radius: 3px; margin-bottom: 10px; background: #fff;">
                    <div style="background: #f6f7f7; padding: 8px 10px; border-bottom: 1px solid #c3c4c7; display: flex; align-items: center; justify-content: space-between; font-size: 12.5px; font-weight: 700; color: #1d2327;">
                        <span>Color</span>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" style="background:none; border:none; color:#2271b1; cursor:pointer; font-size:11.5px;" onclick="this.closest('.wc-attr-box').querySelector('.wc-attr-body').classList.toggle('hidden')">Toggle</button>
                            <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px;" onclick="this.closest('.wc-attr-box').remove(); window.showToast('Attribute removed');">Remove</button>
                        </div>
                    </div>
                    <div class="wc-attr-body" style="padding: 10px 12px;">
                        <div style="display: grid; grid-template-columns: 180px 1fr; gap: 14px;">
                            <div>
                                <label class="adm-form-label" style="font-size: 11.5px;">Name:</label>
                                <input type="text" class="adm-form-input" value="Color" style="height: 28px; font-size: 12px;">
                                <div style="margin-top: 10px; display: flex; flex-direction: column; gap: 6px; font-size: 11.5px; color: #2c3338;">
                                    <label style="display: flex; align-items: center; gap: 4px; cursor: pointer;">
                                        <input type="checkbox" checked> <span>Visible on the product page</span>
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 4px; cursor: pointer;">
                                        <input type="checkbox" checked class="attr-used-for-var"> <span>Used for variations</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                    <label class="adm-form-label" style="font-size: 11.5px; margin: 0;">Value(s):</label>
                                    <small style="color: #646970; font-size: 11px;">Separate values with a pipe (|)</small>
                                </div>
                                <textarea class="adm-form-textarea" rows="3" style="font-size: 12px;" placeholder="Crimson Red | Bottle Green | Royal Blue">Crimson Red | Bottle Green | Royal Blue</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attribute Accordion 2: Size -->
                <div class="wc-attr-box" style="border: 1px solid #c3c4c7; border-radius: 3px; margin-bottom: 10px; background: #fff;">
                    <div style="background: #f6f7f7; padding: 8px 10px; border-bottom: 1px solid #c3c4c7; display: flex; align-items: center; justify-content: space-between; font-size: 12.5px; font-weight: 700; color: #1d2327;">
                        <span>Size</span>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" style="background:none; border:none; color:#2271b1; cursor:pointer; font-size:11.5px;" onclick="this.closest('.wc-attr-box').querySelector('.wc-attr-body').classList.toggle('hidden')">Toggle</button>
                            <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px;" onclick="this.closest('.wc-attr-box').remove(); window.showToast('Attribute removed');">Remove</button>
                        </div>
                    </div>
                    <div class="wc-attr-body" style="padding: 10px 12px;">
                        <div style="display: grid; grid-template-columns: 180px 1fr; gap: 14px;">
                            <div>
                                <label class="adm-form-label" style="font-size: 11.5px;">Name:</label>
                                <input type="text" class="adm-form-input" value="Size" style="height: 28px; font-size: 12px;">
                                <div style="margin-top: 10px; display: flex; flex-direction: column; gap: 6px; font-size: 11.5px; color: #2c3338;">
                                    <label style="display: flex; align-items: center; gap: 4px; cursor: pointer;">
                                        <input type="checkbox" checked> <span>Visible on the product page</span>
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 4px; cursor: pointer;">
                                        <input type="checkbox" checked class="attr-used-for-var"> <span>Used for variations</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                    <label class="adm-form-label" style="font-size: 11.5px; margin: 0;">Value(s):</label>
                                    <small style="color: #646970; font-size: 11px;">Separate values with a pipe (|)</small>
                                </div>
                                <textarea class="adm-form-textarea" rows="2" style="font-size: 12px;" placeholder="Free Size (6.3m)">Free Size (6.3m)</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL 2: VARIATIONS (WOOCOMMERCE ACCORDION STUDIO) -->
            <div id="wcPanelVariations" style="display: none;">
                <!-- Variations Action Toolbar -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px; background: #f6f7f7; padding: 6px 10px; border: 1px solid #c3c4c7; border-radius: 3px;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <select id="wcVarBulkActionSelect" class="adm-form-select" style="width: 250px; height: 28px; font-size: 12px;">
                            <option value="generate">Generate variations from all attributes</option>
                            <option value="add">Add variation</option>
                            <option value="set_prices">Set regular prices (₹)</option>
                            <option value="set_sale_prices">Set sale prices (₹)</option>
                            <option value="set_stock">Set stock quantity</option>
                        </select>
                        <button type="button" class="wp-button" onclick="executeWcVarAction()" style="height: 28px; font-size: 12px;">Go</button>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <button type="button" class="wp-page-title-action secondary" style="font-size: 11px; padding: 2px 8px;" onclick="expandAllWcVariations()">Expand All</button>
                        <button type="button" class="wp-button primary" onclick="window.showToast('✨ Variations saved successfully!')" style="height: 28px; font-size: 12px;">Save changes</button>
                    </div>
                </div>

                <!-- Variations List Container -->
                <div id="wcVariationsList" style="display: flex; flex-direction: column; gap: 8px;">
                    
                    <!-- Variation 1: Crimson Red -->
                    <div class="wc-variation-card" id="var-item-1" style="border: 1px solid #c3c4c7; border-radius: 3px; background: #fff;">
                        <div class="wc-var-header" style="background: #fdfdfd; padding: 6px 10px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f0f0f1; cursor: pointer;" onclick="toggleVariationCard('var-item-1')">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="color: #646970; font-size: 13px;">☰</span>
                                <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width: 28px; height: 28px; object-fit: cover; border-radius: 2px; border: 1px solid #c3c4c7;" alt="Thumbnail">
                                <strong style="font-size: 12.5px; color: #1d2327;">#101-RED Crimson Red, Free Size (6.3m)</strong>
                                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10px;">₹900</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 11.5px; color: #b32d2e;" onclick="event.stopPropagation(); removeVariationCard('var-item-1')">Remove</span>
                                <span style="font-size: 11px; color: #646970;">▼</span>
                            </div>
                        </div>
                        <div class="wc-var-body" style="padding: 12px; display: flex; flex-direction: column; gap: 10px;">
                            <div style="display: flex; gap: 14px; align-items: flex-start;">
                                <div style="width: 70px; text-align: center;">
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="wc-var-preview-img" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #c3c4c7; border-radius: 3px; cursor: pointer;" title="Upload Variation Image" onclick="this.nextElementSibling.click()">
                                    <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);window.showToast('Variation photo updated');}">
                                    <small style="font-size: 9.5px; color: #2271b1; cursor: pointer; display: block; margin-top: 2px;" onclick="this.previousElementSibling.click()">Set image</small>
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; gap: 12px; margin-bottom: 8px; font-size: 11.5px; color: #2c3338;">
                                        <label style="display: flex; align-items: center; gap: 4px;"><input type="checkbox" checked> <span>Enabled</span></label>
                                        <label style="display: flex; align-items: center; gap: 4px;"><input type="checkbox" checked> <span>Manage stock?</span></label>
                                    </div>
                                    <div class="adm-form-grid" style="grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 8px;">
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">SKU:</label>
                                            <input type="text" class="adm-form-input" style="height: 26px; font-size: 11.5px;" value="KLN-SR-111-RED">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Regular price (₹):</label>
                                            <input type="number" class="adm-form-input wc-var-reg" style="height: 26px; font-size: 11.5px;" value="1000">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Sale price (₹):</label>
                                            <input type="number" class="adm-form-input wc-var-sale" style="height: 26px; font-size: 11.5px; font-weight:700; color:#181512;" value="900">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Stock quantity:</label>
                                            <input type="number" class="adm-form-input wc-var-stock" style="height: 26px; font-size: 11.5px;" value="18">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Stock status:</label>
                                            <select class="adm-form-select" style="height: 26px; font-size: 11px; padding: 0 4px;">
                                                <option selected>In stock</option>
                                                <option>Out of stock</option>
                                                <option>On backorder</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Variation 2: Bottle Green -->
                    <div class="wc-variation-card" id="var-item-2" style="border: 1px solid #c3c4c7; border-radius: 3px; background: #fff;">
                        <div class="wc-var-header" style="background: #fdfdfd; padding: 6px 10px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f0f0f1; cursor: pointer;" onclick="toggleVariationCard('var-item-2')">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="color: #646970; font-size: 13px;">☰</span>
                                <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" style="width: 28px; height: 28px; object-fit: cover; border-radius: 2px; border: 1px solid #c3c4c7;" alt="Thumbnail">
                                <strong style="font-size: 12.5px; color: #1d2327;">#101-GRN Bottle Green, Free Size (6.3m)</strong>
                                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10px;">₹900</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 11.5px; color: #b32d2e;" onclick="event.stopPropagation(); removeVariationCard('var-item-2')">Remove</span>
                                <span style="font-size: 11px; color: #646970;">▼</span>
                            </div>
                        </div>
                        <div class="wc-var-body" style="padding: 12px; display: flex; flex-direction: column; gap: 10px;">
                            <div style="display: flex; gap: 14px; align-items: flex-start;">
                                <div style="width: 70px; text-align: center;">
                                    <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="wc-var-preview-img" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #c3c4c7; border-radius: 3px; cursor: pointer;" title="Upload Variation Image" onclick="this.nextElementSibling.click()">
                                    <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);window.showToast('Variation photo updated');}">
                                    <small style="font-size: 9.5px; color: #2271b1; cursor: pointer; display: block; margin-top: 2px;" onclick="this.previousElementSibling.click()">Set image</small>
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; gap: 12px; margin-bottom: 8px; font-size: 11.5px; color: #2c3338;">
                                        <label style="display: flex; align-items: center; gap: 4px;"><input type="checkbox" checked> <span>Enabled</span></label>
                                        <label style="display: flex; align-items: center; gap: 4px;"><input type="checkbox" checked> <span>Manage stock?</span></label>
                                    </div>
                                    <div class="adm-form-grid" style="grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 8px;">
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">SKU:</label>
                                            <input type="text" class="adm-form-input" style="height: 26px; font-size: 11.5px;" value="KLN-SR-111-GRN">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Regular price (₹):</label>
                                            <input type="number" class="adm-form-input wc-var-reg" style="height: 26px; font-size: 11.5px;" value="1000">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Sale price (₹):</label>
                                            <input type="number" class="adm-form-input wc-var-sale" style="height: 26px; font-size: 11.5px; font-weight:700; color:#181512;" value="900">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Stock quantity:</label>
                                            <input type="number" class="adm-form-input wc-var-stock" style="height: 26px; font-size: 11.5px;" value="15">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Stock status:</label>
                                            <select class="adm-form-select" style="height: 26px; font-size: 11px; padding: 0 4px;">
                                                <option selected>In stock</option>
                                                <option>Out of stock</option>
                                                <option>On backorder</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Variation 3: Royal Blue -->
                    <div class="wc-variation-card" id="var-item-3" style="border: 1px solid #c3c4c7; border-radius: 3px; background: #fff;">
                        <div class="wc-var-header" style="background: #fdfdfd; padding: 6px 10px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f0f0f1; cursor: pointer;" onclick="toggleVariationCard('var-item-3')">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="color: #646970; font-size: 13px;">☰</span>
                                <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" style="width: 28px; height: 28px; object-fit: cover; border-radius: 2px; border: 1px solid #c3c4c7;" alt="Thumbnail">
                                <strong style="font-size: 12.5px; color: #1d2327;">#101-BLU Royal Blue, Free Size (6.3m)</strong>
                                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10px;">₹900</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 11.5px; color: #b32d2e;" onclick="event.stopPropagation(); removeVariationCard('var-item-3')">Remove</span>
                                <span style="font-size: 11px; color: #646970;">▼</span>
                            </div>
                        </div>
                        <div class="wc-var-body" style="padding: 12px; display: flex; flex-direction: column; gap: 10px;">
                            <div style="display: flex; gap: 14px; align-items: flex-start;">
                                <div style="width: 70px; text-align: center;">
                                    <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" class="wc-var-preview-img" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #c3c4c7; border-radius: 3px; cursor: pointer;" title="Upload Variation Image" onclick="this.nextElementSibling.click()">
                                    <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);window.showToast('Variation photo updated');}">
                                    <small style="font-size: 9.5px; color: #2271b1; cursor: pointer; display: block; margin-top: 2px;" onclick="this.previousElementSibling.click()">Set image</small>
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; gap: 12px; margin-bottom: 8px; font-size: 11.5px; color: #2c3338;">
                                        <label style="display: flex; align-items: center; gap: 4px;"><input type="checkbox" checked> <span>Enabled</span></label>
                                        <label style="display: flex; align-items: center; gap: 4px;"><input type="checkbox" checked> <span>Manage stock?</span></label>
                                    </div>
                                    <div class="adm-form-grid" style="grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 8px;">
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">SKU:</label>
                                            <input type="text" class="adm-form-input" style="height: 26px; font-size: 11.5px;" value="KLN-SR-111-BLU">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Regular price (₹):</label>
                                            <input type="number" class="adm-form-input wc-var-reg" style="height: 26px; font-size: 11.5px;" value="1000">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Sale price (₹):</label>
                                            <input type="number" class="adm-form-input wc-var-sale" style="height: 26px; font-size: 11.5px; font-weight:700; color:#181512;" value="900">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Stock quantity:</label>
                                            <input type="number" class="adm-form-input wc-var-stock" style="height: 26px; font-size: 11.5px;" value="12">
                                        </div>
                                        <div>
                                            <label class="adm-form-label" style="font-size: 11px;">Stock status:</label>
                                            <select class="adm-form-select" style="height: 26px; font-size: 11px; padding: 0 4px;">
                                                <option selected>In stock</option>
                                                <option>Out of stock</option>
                                                <option>On backorder</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function switchWcTab(tab) {
    const btnAttr = document.getElementById('tabBtnAttributes');
    const btnVar = document.getElementById('tabBtnVariations');
    const panelAttr = document.getElementById('wcPanelAttributes');
    const panelVar = document.getElementById('wcPanelVariations');

    if (tab === 'attributes') {
        btnAttr.style.background = '#fff';
        btnAttr.style.borderLeft = '3px solid #8A681F';
        btnAttr.style.color = '#1d2327';

        btnVar.style.background = 'transparent';
        btnVar.style.borderLeft = '3px solid transparent';
        btnVar.style.color = '#646970';

        panelAttr.style.display = 'block';
        panelVar.style.display = 'none';
    } else {
        btnVar.style.background = '#fff';
        btnVar.style.borderLeft = '3px solid #8A681F';
        btnVar.style.color = '#1d2327';

        btnAttr.style.background = 'transparent';
        btnAttr.style.borderLeft = '3px solid transparent';
        btnAttr.style.color = '#646970';

        panelVar.style.display = 'block';
        panelAttr.style.display = 'none';
    }
}

function toggleVariationCard(cardId) {
    const card = document.getElementById(cardId);
    if (!card) return;
    const body = card.querySelector('.wc-var-body');
    if (body) {
        body.style.display = (body.style.display === 'none') ? 'flex' : 'none';
    }
}

function expandAllWcVariations() {
    document.querySelectorAll('.wc-var-body').forEach(b => b.style.display = 'flex');
    if (typeof window.showToast === 'function') {
        window.showToast('Expanded all variations');
    }
}

function removeVariationCard(cardId) {
    const card = document.getElementById(cardId);
    if (card) {
        card.remove();
        updateWcVarCount();
        if (typeof window.showToast === 'function') {
            window.showToast('Variation removed');
        }
    }
}

function updateWcVarCount() {
    const count = document.querySelectorAll('#wcVariationsList .wc-variation-card').length;
    const badge = document.getElementById('wcVarCountBadge');
    if (badge) badge.textContent = count;
}

function saveWcAttributes() {
    if (typeof window.showToast === 'function') {
        window.showToast('✨ Product attributes saved!');
    }
    switchWcTab('variations');
}

function executeWcVarAction() {
    const action = document.getElementById('wcVarBulkActionSelect')?.value;
    const baseReg = document.getElementById('pFormMrp')?.value || '1000';
    const baseSale = document.getElementById('pFormRetail')?.value || '900';

    if (action === 'generate') {
        if (typeof window.showToast === 'function') {
            window.showToast('✨ Generated 3 variations from attributes!');
        }
    } else if (action === 'add') {
        addSingleWcVariation();
    } else if (action === 'set_prices') {
        const p = prompt('Enter Regular Price (₹) for all variations:', baseReg);
        if (p) {
            document.querySelectorAll('.wc-var-reg').forEach(i => i.value = p);
            window.showToast('Regular prices updated!');
        }
    } else if (action === 'set_sale_prices') {
        const p = prompt('Enter Sale Price (₹) for all variations:', baseSale);
        if (p) {
            document.querySelectorAll('.wc-var-sale').forEach(i => i.value = p);
            window.showToast('Sale prices updated!');
        }
    } else if (action === 'set_stock') {
        const s = prompt('Enter stock quantity for all variations:', '20');
        if (s) {
            document.querySelectorAll('.wc-var-stock').forEach(i => i.value = s);
            window.showToast('Stock quantity updated!');
        }
    }
}

function addSingleWcVariation() {
    const list = document.getElementById('wcVariationsList');
    const newId = 'var-item-' + Date.now();
    const count = list.querySelectorAll('.wc-variation-card').length + 1;
    const baseReg = document.getElementById('pFormMrp')?.value || '1000';
    const baseSale = document.getElementById('pFormRetail')?.value || '900';

    const div = document.createElement('div');
    div.className = 'wc-variation-card';
    div.id = newId;
    div.style.cssText = 'border: 1px solid #c3c4c7; border-radius: 3px; background: #fff;';
    div.innerHTML = `
        <div class="wc-var-header" style="background: #fdfdfd; padding: 6px 10px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f0f0f1; cursor: pointer;" onclick="toggleVariationCard('${newId}')">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="color: #646970; font-size: 13px;">☰</span>
                <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width: 28px; height: 28px; object-fit: cover; border-radius: 2px; border: 1px solid #c3c4c7;" alt="Thumbnail">
                <strong style="font-size: 12.5px; color: #1d2327;">#101-VAR${count} Custom Variation #${count}</strong>
                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10px;">₹${baseSale}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 11.5px; color: #b32d2e;" onclick="event.stopPropagation(); removeVariationCard('${newId}')">Remove</span>
                <span style="font-size: 11px; color: #646970;">▼</span>
            </div>
        </div>
        <div class="wc-var-body" style="padding: 12px; display: flex; flex-direction: column; gap: 10px;">
            <div style="display: flex; gap: 14px; align-items: flex-start;">
                <div style="width: 70px; text-align: center;">
                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="wc-var-preview-img" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #c3c4c7; border-radius: 3px; cursor: pointer;" title="Upload Variation Image" onclick="this.nextElementSibling.click()">
                    <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);window.showToast('Variation photo updated');}">
                    <small style="font-size: 9.5px; color: #2271b1; cursor: pointer; display: block; margin-top: 2px;" onclick="this.previousElementSibling.click()">Set image</small>
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; gap: 12px; margin-bottom: 8px; font-size: 11.5px; color: #2c3338;">
                        <label style="display: flex; align-items: center; gap: 4px;"><input type="checkbox" checked> <span>Enabled</span></label>
                        <label style="display: flex; align-items: center; gap: 4px;"><input type="checkbox" checked> <span>Manage stock?</span></label>
                    </div>
                    <div class="adm-form-grid" style="grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 8px;">
                        <div>
                            <label class="adm-form-label" style="font-size: 11px;">SKU:</label>
                            <input type="text" class="adm-form-input" style="height: 26px; font-size: 11.5px;" value="KLN-SR-111-V${count}">
                        </div>
                        <div>
                            <label class="adm-form-label" style="font-size: 11px;">Regular price (₹):</label>
                            <input type="number" class="adm-form-input wc-var-reg" style="height: 26px; font-size: 11.5px;" value="${baseReg}">
                        </div>
                        <div>
                            <label class="adm-form-label" style="font-size: 11px;">Sale price (₹):</label>
                            <input type="number" class="adm-form-input wc-var-sale" style="height: 26px; font-size: 11.5px; font-weight:700; color:#181512;" value="${baseSale}">
                        </div>
                        <div>
                            <label class="adm-form-label" style="font-size: 11px;">Stock quantity:</label>
                            <input type="number" class="adm-form-input wc-var-stock" style="height: 26px; font-size: 11.5px;" value="10">
                        </div>
                        <div>
                            <label class="adm-form-label" style="font-size: 11px;">Stock status:</label>
                            <select class="adm-form-select" style="height: 26px; font-size: 11px; padding: 0 4px;">
                                <option selected>In stock</option>
                                <option>Out of stock</option>
                                <option>On backorder</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    list.appendChild(div);
    updateWcVarCount();
    if (typeof window.showToast === 'function') {
        window.showToast('✨ New WooCommerce variation added!');
    }
}

function addWcAttributeBox() {
    const val = document.getElementById('wcNewAttrSelect')?.value || 'Custom';
    const container = document.getElementById('wcPanelAttributes');
    const div = document.createElement('div');
    div.className = 'wc-attr-box';
    div.style.cssText = 'border: 1px solid #c3c4c7; border-radius: 3px; margin-bottom: 10px; background: #fff;';
    div.innerHTML = `
        <div style="background: #f6f7f7; padding: 8px 10px; border-bottom: 1px solid #c3c4c7; display: flex; align-items: center; justify-content: space-between; font-size: 12.5px; font-weight: 700; color: #1d2327;">
            <span>${val}</span>
            <div style="display: flex; gap: 8px;">
                <button type="button" style="background:none; border:none; color:#2271b1; cursor:pointer; font-size:11.5px;" onclick="this.closest('.wc-attr-box').querySelector('.wc-attr-body').classList.toggle('hidden')">Toggle</button>
                <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px;" onclick="this.closest('.wc-attr-box').remove(); window.showToast('Attribute removed');">Remove</button>
            </div>
        </div>
        <div class="wc-attr-body" style="padding: 10px 12px;">
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 14px;">
                <div>
                    <label class="adm-form-label" style="font-size: 11.5px;">Name:</label>
                    <input type="text" class="adm-form-input" value="${val}" style="height: 28px; font-size: 12px;">
                    <div style="margin-top: 10px; display: flex; flex-direction: column; gap: 6px; font-size: 11.5px; color: #2c3338;">
                        <label style="display: flex; align-items: center; gap: 4px; cursor: pointer;">
                            <input type="checkbox" checked> <span>Visible on the product page</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 4px; cursor: pointer;">
                            <input type="checkbox" checked class="attr-used-for-var"> <span>Used for variations</span>
                        </label>
                    </div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <label class="adm-form-label" style="font-size: 11.5px; margin: 0;">Value(s):</label>
                        <small style="color: #646970; font-size: 11px;">Separate values with a pipe (|)</small>
                    </div>
                    <textarea class="adm-form-textarea" rows="2" style="font-size: 12px;" placeholder="Option 1 | Option 2"></textarea>
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
    if (typeof window.showToast === 'function') {
        window.showToast(`✨ Attribute "${val}" box added!`);
    }
}
</script>
