<?php
/**
 * product-variants.php — Complete Textile Variations Suite (Colors, Sizes, Blouse, Border)
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <!-- Header with Master Checkboxes for Colors, Sizes, Blouse, Border -->
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
            <h3 class="dt-form-sec-title" style="margin:0;"><span>Product Options &amp; Variations</span></h3>
        </div>
        <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
            <label style="display:flex; align-items:center; gap:4px; font-size:11.5px; font-weight:700; color:#1d2327; cursor:pointer; background:#FAF5E8; border:1px solid rgba(212,175,55,0.5); padding:3px 8px; border-radius:4px;">
                <input type="checkbox" id="chkEnableColors" checked onchange="toggleColorVariationsSection(this.checked)" style="cursor:pointer; width:14px; height:14px;">
                <span>Colors</span>
            </label>
            <label style="display:flex; align-items:center; gap:4px; font-size:11.5px; font-weight:700; color:#1d2327; cursor:pointer; background:#FAF5E8; border:1px solid rgba(212,175,55,0.5); padding:3px 8px; border-radius:4px;">
                <input type="checkbox" id="chkEnableSizes" checked onchange="toggleSizeVariationsSection(this.checked)" style="cursor:pointer; width:14px; height:14px;">
                <span>Sizes</span>
            </label>
            <label style="display:flex; align-items:center; gap:4px; font-size:11.5px; font-weight:700; color:#1d2327; cursor:pointer; background:#FAF5E8; border:1px solid rgba(212,175,55,0.5); padding:3px 8px; border-radius:4px;">
                <input type="checkbox" id="chkEnableBlouse" checked onchange="toggleBlouseVariationsSection(this.checked)" style="cursor:pointer; width:14px; height:14px;">
                <span>Blouse</span>
            </label>
            <label style="display:flex; align-items:center; gap:4px; font-size:11.5px; font-weight:700; color:#1d2327; cursor:pointer; background:#FAF5E8; border:1px solid rgba(212,175,55,0.5); padding:3px 8px; border-radius:4px;">
                <input type="checkbox" id="chkEnableBorder" checked onchange="toggleBorderVariationsSection(this.checked)" style="cursor:pointer; width:14px; height:14px;">
                <span>Border</span>
            </label>
        </div>
    </div>

    <div class="dt-form-sec-body">
        
        <!-- ========================================== -->
        <!-- 1. COLOR VARIATIONS SECTION -->
        <!-- ========================================== -->
        <div id="colorVariationsContainer" style="margin-bottom:20px;">
            <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.45); border-radius:6px; padding:10px 14px; margin-bottom:12px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-size:12px; font-weight:700; color:#5A4210;">Available Colors:</span>
                        <div id="quickSwatchList" style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                            <span class="adm-badge gold" id="chip-cvar-1" style="display:inline-flex; align-items:center; gap:5px; font-size:11px; padding:3px 8px;">
                                <span style="width:10px; height:10px; border-radius:50%; background:#991b1b; display:inline-block; border:1px solid #fff;"></span>
                                <span>Crimson Red</span>
                            </span>
                            <span class="adm-badge gold" id="chip-cvar-2" style="display:inline-flex; align-items:center; gap:5px; font-size:11px; padding:3px 8px;">
                                <span style="width:10px; height:10px; border-radius:50%; background:#166534; display:inline-block; border:1px solid #fff;"></span>
                                <span>Bottle Green</span>
                            </span>
                            <span class="adm-badge gold" id="chip-cvar-3" style="display:inline-flex; align-items:center; gap:5px; font-size:11px; padding:3px 8px;">
                                <span style="width:10px; height:10px; border-radius:50%; background:#1e40af; display:inline-block; border:1px solid #fff;"></span>
                                <span>Royal Blue</span>
                            </span>
                        </div>
                    </div>
                    
                    <button type="button" class="wp-button primary" onclick="toggleColorPickerDrawer()" style="height:30px; padding:0 12px; font-size:12px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Color</span>
                    </button>
                </div>

                <!-- Smart Color Picker Dropdown Box with Auto Name Detection -->
                <div id="colorPickerBox" style="display:none; margin-top:12px; padding-top:12px; border-top:1px dashed rgba(212,175,55,0.5);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <div style="font-size:12px; font-weight:700; color:#1d2327;">Pick a Color &amp; Auto-Detect Original Name:</div>
                        <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10px; padding:2px 6px;">⚡ Auto Name Detection Active</span>
                    </div>
                    <div style="display:flex; align-items:center; flex-wrap:wrap; gap:10px;">
                        <!-- Color input -->
                        <div style="display:flex; align-items:center; gap:6px;">
                            <input type="color" id="varColorPicker" value="#db2777" style="width:34px; height:32px; padding:0; border:1px solid #c3c4c7; border-radius:4px; cursor:pointer;" onchange="handleColorPickerChange(this.value)">
                            <input type="text" id="varColorHex" value="#db2777" style="width:75px; height:30px; font-size:12px; padding:0 6px; border:1px solid #8c8f94; border-radius:3px; font-family:monospace;" oninput="handleHexInputChange(this.value)">
                        </div>

                        <!-- Preset Color Swatches -->
                        <div style="display:flex; gap:6px; align-items:center;">
                            <span title="Crimson Red" onclick="selectPresetColor('#991b1b', 'Crimson Red')" style="width:20px; height:20px; border-radius:50%; background:#991b1b; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                            <span title="Bottle Green" onclick="selectPresetColor('#166534', 'Bottle Green')" style="width:20px; height:20px; border-radius:50%; background:#166534; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                            <span title="Royal Blue" onclick="selectPresetColor('#1e40af', 'Royal Blue')" style="width:20px; height:20px; border-radius:50%; background:#1e40af; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                            <span title="Mustard Yellow" onclick="selectPresetColor('#d97706', 'Mustard Yellow')" style="width:20px; height:20px; border-radius:50%; background:#d97706; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                            <span title="Rani Pink" onclick="selectPresetColor('#db2777', 'Rani Pink')" style="width:20px; height:20px; border-radius:50%; background:#db2777; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                            <span title="Peacock Teal" onclick="selectPresetColor('#0f766e', 'Peacock Teal')" style="width:20px; height:20px; border-radius:50%; background:#0f766e; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                            <span title="Deep Maroon" onclick="selectPresetColor('#831843', 'Deep Maroon')" style="width:20px; height:20px; border-radius:50%; background:#831843; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                            <span title="Jet Black" onclick="selectPresetColor('#18181b', 'Jet Black')" style="width:20px; height:20px; border-radius:50%; background:#18181b; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                        </div>

                        <!-- Auto-Saved / Detected Color Name Input -->
                        <div style="position:relative;">
                            <input type="text" id="varColorName" value="Rani Pink" placeholder="Original Color Name" style="height:30px; font-size:12.5px; font-weight:600; padding:0 8px; border:1px solid #8A681F; border-radius:3px; width:190px; outline:none; background:#fff;" onkeydown="if(event.key==='Enter'){event.preventDefault();submitNewColorVariation();}">
                        </div>

                        <!-- Confirm Add Button -->
                        <button type="button" class="wp-button primary" onclick="submitNewColorVariation()" style="height:30px; font-size:12px; font-weight:600;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>+ Save &amp; Add Color</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- List of Color Variation Cards -->
            <div id="colorVariationsList" style="display:flex; flex-direction:column; gap:10px;">
                
                <!-- Color Variation 1: Crimson Red -->
                <div class="color-var-card" id="cvar-1" style="border:1px solid #c3c4c7; border-radius:4px; background:#fff; overflow:hidden;">
                    <div style="background:#f6f7f7; padding:8px 12px; border-bottom:1px solid #c3c4c7; display:flex; align-items:center; justify-content:space-between;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="width:16px; height:16px; border-radius:50%; background:#991b1b; display:inline-block; border:1px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                            <strong style="font-size:13px; color:#1d2327;">Crimson Red</strong>
                            <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px;">Sale: ₹900</span>
                        </div>
                        <div>
                            <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px; font-weight:600;" onclick="removeColorVariationCard('cvar-1', 'Crimson Red')">✕ Remove</button>
                        </div>
                    </div>
                    <div style="padding:12px 14px; display:flex; gap:16px; align-items:flex-start; flex-wrap:wrap;">
                        <div style="width:80px; text-align:center;">
                            <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:70px; height:70px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7; cursor:pointer;" title="Click to upload color photo" onclick="this.nextElementSibling.click()">
                            <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);window.showToast('Crimson Red photo updated');}">
                            <small style="font-size:10px; color:#2271b1; cursor:pointer; display:block; margin-top:3px;" onclick="this.previousElementSibling.click()">+ Add Photo</small>
                        </div>

                        <div style="flex:1; min-width:260px;">
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(120px, 1fr)); gap:10px;">
                                <div>
                                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Variant SKU:</label>
                                    <input type="text" class="adm-form-input" style="height:28px; font-size:12px;" value="KLN-SR-111-RED">
                                </div>
                                <div>
                                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Price ₹:</label>
                                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="1000">
                                </div>
                                <div>
                                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Sale Price ₹ <span style="color:#b32d2e;">*</span>:</label>
                                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px; font-weight:700; color:#181512;" value="900">
                                </div>
                                <div>
                                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Stock (Units):</label>
                                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="18">
                                </div>
                                <div>
                                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Status:</label>
                                    <select class="adm-form-select" style="height:28px; font-size:11.5px; padding:0 6px;">
                                        <option selected>In Stock</option>
                                        <option>Low Stock</option>
                                        <option>Out of Stock</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Color Variation 2: Bottle Green -->
                <div class="color-var-card" id="cvar-2" style="border:1px solid #c3c4c7; border-radius:4px; background:#fff; overflow:hidden;">
                    <div style="background:#f6f7f7; padding:8px 12px; border-bottom:1px solid #c3c4c7; display:flex; align-items:center; justify-content:space-between;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="width:16px; height:16px; border-radius:50%; background:#166534; display:inline-block; border:1px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                            <strong style="font-size:13px; color:#1d2327;">Bottle Green</strong>
                            <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px;">Sale: ₹900</span>
                        </div>
                        <div>
                            <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px; font-weight:600;" onclick="removeColorVariationCard('cvar-2', 'Bottle Green')">✕ Remove</button>
                        </div>
                    </div>
                    <div style="padding:12px 14px; display:flex; gap:16px; align-items:flex-start; flex-wrap:wrap;">
                        <div style="width:80px; text-align:center;">
                            <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" style="width:70px; height:70px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7; cursor:pointer;" title="Click to upload color photo" onclick="this.nextElementSibling.click()">
                            <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);window.showToast('Bottle Green photo updated');}">
                            <small style="font-size:10px; color:#2271b1; cursor:pointer; display:block; margin-top:3px;" onclick="this.previousElementSibling.click()">+ Add Photo</small>
                        </div>

                        <div style="flex:1; min-width:260px;">
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(120px, 1fr)); gap:10px;">
                                <div>
                                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Variant SKU:</label>
                                    <input type="text" class="adm-form-input" style="height:28px; font-size:12px;" value="KLN-SR-111-GRN">
                                </div>
                                <div>
                                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Price ₹:</label>
                                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="1000">
                                </div>
                                <div>
                                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Sale Price ₹ <span style="color:#b32d2e;">*</span>:</label>
                                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px; font-weight:700; color:#181512;" value="900">
                                </div>
                                <div>
                                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Stock (Units):</label>
                                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="15">
                                </div>
                                <div>
                                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Status:</label>
                                    <select class="adm-form-select" style="height:28px; font-size:11.5px; padding:0 6px;">
                                        <option selected>In Stock</option>
                                        <option>Low Stock</option>
                                        <option>Out of Stock</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 2. SIZE VARIATIONS SECTION -->
        <!-- ========================================== -->
        <div id="sizeVariationsContainer" style="margin-bottom:20px; border-top:1px dashed rgba(212,175,55,0.6); padding-top:14px;">
            <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.45); border-radius:6px; padding:10px 14px; margin-bottom:12px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-size:12px; font-weight:700; color:#5A4210;">Available Sizes:</span>
                        <div id="quickSizeList" style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                            <span class="adm-badge gold" id="chip-svar-1" style="font-size:11px; padding:3px 8px;">Free Size (6.3m)</span>
                            <span class="adm-badge gold" id="chip-svar-2" style="font-size:11px; padding:3px 8px;">XL (42)</span>
                        </div>
                    </div>
                    
                    <button type="button" class="wp-button primary" onclick="toggleSizePickerDrawer()" style="height:30px; padding:0 12px; font-size:12px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Size</span>
                    </button>
                </div>

                <!-- Size Picker Dropdown Box with Quick Preset Pills -->
                <div id="sizePickerBox" style="display:none; margin-top:12px; padding-top:12px; border-top:1px dashed rgba(212,175,55,0.5);">
                    <div style="font-size:12px; font-weight:700; color:#1d2327; margin-bottom:8px;">Select Size Preset or Enter Custom Size:</div>
                    <div style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:10px;">
                        <span class="wp-button" onclick="selectPresetSize('Free Size (6.3m)')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Free Size (6.3m)</span>
                        <span class="wp-button" onclick="selectPresetSize('Standard (5.5m + Blouse)')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Standard (5.5m)</span>
                        <span class="wp-button" onclick="selectPresetSize('Semi-Stitched')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Semi-Stitched</span>
                        <span class="wp-button" onclick="selectPresetSize('Unstitched 2.5m')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Unstitched</span>
                        <span class="wp-button" onclick="selectPresetSize('S (36)')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">S (36)</span>
                        <span class="wp-button" onclick="selectPresetSize('M (38)')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">M (38)</span>
                        <span class="wp-button" onclick="selectPresetSize('L (40)')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">L (40)</span>
                        <span class="wp-button" onclick="selectPresetSize('XL (42)')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">XL (42)</span>
                        <span class="wp-button" onclick="selectPresetSize('XXL (44)')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">XXL (44)</span>
                    </div>

                    <div style="display:flex; align-items:center; flex-wrap:wrap; gap:10px;">
                        <input type="text" id="varSizeName" value="Free Size (6.3m)" placeholder="e.g. Free Size / XL / 42" style="height:30px; font-size:12.5px; font-weight:600; padding:0 8px; border:1px solid #8A681F; border-radius:3px; width:210px; outline:none; background:#fff;" onkeydown="if(event.key==='Enter'){event.preventDefault();submitNewSizeVariation();}">
                        <button type="button" class="wp-button primary" onclick="submitNewSizeVariation()" style="height:30px; font-size:12px; font-weight:600;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>+ Save &amp; Add Size</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- List of Size Variation Cards -->
            <div id="sizeVariationsList" style="display:flex; flex-direction:column; gap:10px;">
                <div class="size-var-card" id="svar-1" style="border:1px solid #c3c4c7; border-radius:4px; background:#fff; overflow:hidden;">
                    <div style="background:#f6f7f7; padding:8px 12px; border-bottom:1px solid #c3c4c7; display:flex; align-items:center; justify-content:space-between;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="adm-badge" style="background:#8A681F; color:#fff; font-size:11px; font-weight:700;">SIZE</span>
                            <strong style="font-size:13px; color:#1d2327;">Free Size (6.3m)</strong>
                            <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px;">Sale: ₹900</span>
                        </div>
                        <div>
                            <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px; font-weight:600;" onclick="removeSizeVariationCard('svar-1')">✕ Remove</button>
                        </div>
                    </div>
                    <div style="padding:12px 14px;">
                        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(130px, 1fr)); gap:10px;">
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Size SKU:</label>
                                <input type="text" class="adm-form-input" style="height:28px; font-size:12px;" value="KLN-SR-111-FS">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Price ₹:</label>
                                <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="1000">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Sale Price ₹ <span style="color:#b32d2e;">*</span>:</label>
                                <input type="number" class="adm-form-input" style="height:28px; font-size:12px; font-weight:700; color:#181512;" value="900">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Stock (Units):</label>
                                <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="25">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Status:</label>
                                <select class="adm-form-select" style="height:28px; font-size:11.5px; padding:0 6px;">
                                    <option selected>In Stock</option>
                                    <option>Low Stock</option>
                                    <option>Out of Stock</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 3. BLOUSE OPTIONS SECTION -->
        <!-- ========================================== -->
        <div id="blouseVariationsContainer" style="margin-bottom:20px; border-top:1px dashed rgba(212,175,55,0.6); padding-top:14px;">
            <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.45); border-radius:6px; padding:10px 14px; margin-bottom:12px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-size:12px; font-weight:700; color:#5A4210;">Blouse Stitching &amp; Fabric Options:</span>
                        <div id="quickBlouseList" style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                            <span class="adm-badge gold" id="chip-bvar-1" style="font-size:11px; padding:3px 8px;">Unstitched (0.8m)</span>
                            <span class="adm-badge gold" id="chip-bvar-2" style="font-size:11px; padding:3px 8px;">Stitched Ready Made (+₹400)</span>
                        </div>
                    </div>
                    
                    <button type="button" class="wp-button primary" onclick="toggleBlousePickerDrawer()" style="height:30px; padding:0 12px; font-size:12px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Blouse Option</span>
                    </button>
                </div>

                <!-- Blouse Picker Dropdown Box with Quick Preset Pills -->
                <div id="blousePickerBox" style="display:none; margin-top:12px; padding-top:12px; border-top:1px dashed rgba(212,175,55,0.5);">
                    <div style="font-size:12px; font-weight:700; color:#1d2327; margin-bottom:8px;">Select Blouse Preset or Enter Custom Option:</div>
                    <div style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:10px;">
                        <span class="wp-button" onclick="selectPresetBlouse('Unstitched Blouse Piece (0.8m)', 0)" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Unstitched (0.8m)</span>
                        <span class="wp-button" onclick="selectPresetBlouse('Stitched Blouse (Ready Made)', 400)" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Stitched (+₹400)</span>
                        <span class="wp-button" onclick="selectPresetBlouse('Heavy Embroidered / Maggam Work', 850)" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Heavy Maggam Work (+₹850)</span>
                        <span class="wp-button" onclick="selectPresetBlouse('Running Contrast Blouse', 150)" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Running Contrast</span>
                        <span class="wp-button" onclick="selectPresetBlouse('Without Blouse Piece', -100)" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Without Blouse</span>
                    </div>

                    <div style="display:flex; align-items:center; flex-wrap:wrap; gap:10px;">
                        <input type="text" id="varBlouseName" value="Heavy Embroidered / Maggam Work" placeholder="e.g. Heavy Maggam Work Blouse" style="height:30px; font-size:12.5px; font-weight:600; padding:0 8px; border:1px solid #8A681F; border-radius:3px; width:250px; outline:none; background:#fff;" onkeydown="if(event.key==='Enter'){event.preventDefault();submitNewBlouseVariation();}">
                        <button type="button" class="wp-button primary" onclick="submitNewBlouseVariation()" style="height:30px; font-size:12px; font-weight:600;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>+ Save &amp; Add Blouse</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- List of Blouse Variation Cards -->
            <div id="blouseVariationsList" style="display:flex; flex-direction:column; gap:10px;">
                <div class="blouse-var-card" id="bvar-1" style="border:1px solid #c3c4c7; border-radius:4px; background:#fff; overflow:hidden;">
                    <div style="background:#f6f7f7; padding:8px 12px; border-bottom:1px solid #c3c4c7; display:flex; align-items:center; justify-content:space-between;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="adm-badge" style="background:#7E22CE; color:#fff; font-size:11px; font-weight:700;">BLOUSE</span>
                            <strong style="font-size:13px; color:#1d2327;">Stitched Ready Made (+₹400)</strong>
                            <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px;">Sale: ₹1300</span>
                        </div>
                        <div>
                            <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px; font-weight:600;" onclick="removeBlouseVariationCard('bvar-1')">✕ Remove</button>
                        </div>
                    </div>
                    <div style="padding:12px 14px;">
                        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(130px, 1fr)); gap:10px;">
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Blouse SKU:</label>
                                <input type="text" class="adm-form-input" style="height:28px; font-size:12px;" value="KLN-SR-111-BLS-STCH">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Price ₹:</label>
                                <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="1500">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Sale Price ₹ <span style="color:#b32d2e;">*</span>:</label>
                                <input type="number" class="adm-form-input" style="height:28px; font-size:12px; font-weight:700; color:#181512;" value="1300">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Stock (Units):</label>
                                <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="20">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Status:</label>
                                <select class="adm-form-select" style="height:28px; font-size:11.5px; padding:0 6px;">
                                    <option selected>In Stock</option>
                                    <option>Low Stock</option>
                                    <option>Out of Stock</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 4. BORDER / PALLU DESIGN OPTIONS SECTION -->
        <!-- ========================================== -->
        <div id="borderVariationsContainer" style="border-top:1px dashed rgba(212,175,55,0.6); padding-top:14px;">
            <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.45); border-radius:6px; padding:10px 14px; margin-bottom:12px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-size:12px; font-weight:700; color:#5A4210;">Border &amp; Zari Weave Options:</span>
                        <div id="quickBorderList" style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                            <span class="adm-badge gold" id="chip-brdvar-1" style="font-size:11px; padding:3px 8px;">Pure Gold Zari Border</span>
                            <span class="adm-badge gold" id="chip-brdvar-2" style="font-size:11px; padding:3px 8px;">Broad Kaddi Border</span>
                        </div>
                    </div>
                    
                    <button type="button" class="wp-button primary" onclick="toggleBorderPickerDrawer()" style="height:30px; padding:0 12px; font-size:12px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Border Option</span>
                    </button>
                </div>

                <!-- Border Picker Dropdown Box with Quick Preset Pills -->
                <div id="borderPickerBox" style="display:none; margin-top:12px; padding-top:12px; border-top:1px dashed rgba(212,175,55,0.5);">
                    <div style="font-size:12px; font-weight:700; color:#1d2327; margin-bottom:8px;">Select Border Preset or Enter Custom Border:</div>
                    <div style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:10px;">
                        <span class="wp-button" onclick="selectPresetBorder('Pure Gold Zari Border')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Pure Gold Zari</span>
                        <span class="wp-button" onclick="selectPresetBorder('Silver Temple Border')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Silver Temple</span>
                        <span class="wp-button" onclick="selectPresetBorder('Broad Kaddi Big Border')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Broad Kaddi Border</span>
                        <span class="wp-button" onclick="selectPresetBorder('Ganga Jamuna Contrast Border')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Ganga Jamuna Border</span>
                        <span class="wp-button" onclick="selectPresetBorder('Cutwork Scallop Border')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Cutwork Scallop</span>
                        <span class="wp-button" onclick="selectPresetBorder('Small Meena Work Border')" style="height:24px; font-size:11px; padding:0 8px; cursor:pointer;">Small Meena Border</span>
                    </div>

                    <div style="display:flex; align-items:center; flex-wrap:wrap; gap:10px;">
                        <input type="text" id="varBorderName" value="Broad Kaddi Big Border" placeholder="e.g. Broad Kaddi Big Border" style="height:30px; font-size:12.5px; font-weight:600; padding:0 8px; border:1px solid #8A681F; border-radius:3px; width:250px; outline:none; background:#fff;" onkeydown="if(event.key==='Enter'){event.preventDefault();submitNewBorderVariation();}">
                        <button type="button" class="wp-button primary" onclick="submitNewBorderVariation()" style="height:30px; font-size:12px; font-weight:600;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>+ Save &amp; Add Border</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- List of Border Variation Cards -->
            <div id="borderVariationsList" style="display:flex; flex-direction:column; gap:10px;">
                <div class="border-var-card" id="brdvar-1" style="border:1px solid #c3c4c7; border-radius:4px; background:#fff; overflow:hidden;">
                    <div style="background:#f6f7f7; padding:8px 12px; border-bottom:1px solid #c3c4c7; display:flex; align-items:center; justify-content:space-between;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="adm-badge" style="background:#0F766E; color:#fff; font-size:11px; font-weight:700;">BORDER</span>
                            <strong style="font-size:13px; color:#1d2327;">Pure Gold Zari Border</strong>
                            <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px;">Sale: ₹900</span>
                        </div>
                        <div>
                            <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px; font-weight:600;" onclick="removeBorderVariationCard('brdvar-1')">✕ Remove</button>
                        </div>
                    </div>
                    <div style="padding:12px 14px;">
                        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(130px, 1fr)); gap:10px;">
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Border SKU:</label>
                                <input type="text" class="adm-form-input" style="height:28px; font-size:12px;" value="KLN-SR-111-BRD-GLD">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Price ₹:</label>
                                <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="1000">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Sale Price ₹ <span style="color:#b32d2e;">*</span>:</label>
                                <input type="number" class="adm-form-input" style="height:28px; font-size:12px; font-weight:700; color:#181512;" value="900">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Stock (Units):</label>
                                <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="30">
                            </div>
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Status:</label>
                                <select class="adm-form-select" style="height:28px; font-size:11.5px; padding:0 6px;">
                                    <option selected>In Stock</option>
                                    <option>Low Stock</option>
                                    <option>Out of Stock</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Authentic Color Palette Dictionary for Textile & Garments
const DT_COLOR_PALETTE = [
    { name: "Crimson Red", hex: "#991b1b" },
    { name: "Ruby Red", hex: "#dc2626" },
    { name: "Cherry Red", hex: "#b91c1c" },
    { name: "Deep Maroon", hex: "#831843" },
    { name: "Wine / Burgundy", hex: "#701a75" },
    { name: "Rani Pink", hex: "#db2777" },
    { name: "Rose Pink", hex: "#f43f5e" },
    { name: "Baby Pink", hex: "#f472b6" },
    { name: "Magenta", hex: "#c026d3" },
    { name: "Peach Coral", hex: "#fb7185" },
    { name: "Rust Orange", hex: "#c2410c" },
    { name: "Tangerine", hex: "#ea580c" },
    { name: "Mustard Yellow", hex: "#d97706" },
    { name: "Golden Yellow", hex: "#eab308" },
    { name: "Lemon Yellow", hex: "#facc15" },
    { name: "Bottle Green", hex: "#166534" },
    { name: "Emerald Green", hex: "#15803d" },
    { name: "Parrot Green", hex: "#22c55e" },
    { name: "Mint Green", hex: "#86efac" },
    { name: "Mehendi Olive", hex: "#65a30d" },
    { name: "Peacock Teal", hex: "#0f766e" },
    { name: "Sea Green", hex: "#14b8a6" },
    { name: "Cyan Aqua", hex: "#06b6d4" },
    { name: "Royal Blue", hex: "#1e40af" },
    { name: "Navy Blue", hex: "#1e3a8a" },
    { name: "Sky Blue", hex: "#38bdf8" },
    { name: "Indigo Blue", hex: "#3730a3" },
    { name: "Lavender Purple", hex: "#9333ea" },
    { name: "Violet / Plum", hex: "#581c87" },
    { name: "Lilac", hex: "#c084fc" },
    { name: "Jet Black", hex: "#18181b" },
    { name: "Charcoal Grey", hex: "#3f3f46" },
    { name: "Silver Grey", hex: "#9ca3af" },
    { name: "Pearl White", hex: "#ffffff" },
    { name: "Off White / Cream", hex: "#fef08a" },
    { name: "Beige / Biscuit", hex: "#d6d3d1" },
    { name: "Chocolate Brown", hex: "#78350f" },
    { name: "Coffee Brown", hex: "#451a03" }
];

function hexToRgb(hex) {
    hex = hex.replace(/^#/, '');
    if (hex.length === 3) hex = hex.split('').map(c => c + c).join('');
    const num = parseInt(hex, 16);
    return {
        r: (num >> 16) & 255,
        g: (num >> 8) & 255,
        b: num & 255
    };
}

function detectOriginalColorName(hex) {
    if (!hex) return "Custom Color";
    const target = hexToRgb(hex);
    let minDistance = Infinity;
    let closestName = "Custom Color";

    for (const c of DT_COLOR_PALETTE) {
        const rgb = hexToRgb(c.hex);
        const dist = Math.sqrt(
            Math.pow(target.r - rgb.r, 2) +
            Math.pow(target.g - rgb.g, 2) +
            Math.pow(target.b - rgb.b, 2)
        );
        if (dist < minDistance) {
            minDistance = dist;
            closestName = c.name;
        }
    }
    return closestName;
}

function handleColorPickerChange(hex) {
    document.getElementById('varColorHex').value = hex;
    const detectedName = detectOriginalColorName(hex);
    document.getElementById('varColorName').value = detectedName;
}

function handleHexInputChange(hex) {
    if (hex.startsWith('#') && (hex.length === 4 || hex.length === 7)) {
        document.getElementById('varColorPicker').value = hex;
        const detectedName = detectOriginalColorName(hex);
        document.getElementById('varColorName').value = detectedName;
    }
}

function selectPresetColor(hex, name) {
    document.getElementById('varColorPicker').value = hex;
    document.getElementById('varColorHex').value = hex;
    document.getElementById('varColorName').value = name;
}

function toggleColorVariationsSection(enabled) {
    const container = document.getElementById('colorVariationsContainer');
    if (container) container.style.display = enabled ? 'block' : 'none';
    if (typeof window.showToast === 'function') window.showToast(enabled ? '✨ Color Variations enabled' : 'Color Variations disabled');
}

function toggleSizeVariationsSection(enabled) {
    const container = document.getElementById('sizeVariationsContainer');
    if (container) container.style.display = enabled ? 'block' : 'none';
    if (typeof window.showToast === 'function') window.showToast(enabled ? '✨ Size Variations enabled' : 'Size Variations disabled');
}

function toggleBlouseVariationsSection(enabled) {
    const container = document.getElementById('blouseVariationsContainer');
    if (container) container.style.display = enabled ? 'block' : 'none';
    if (typeof window.showToast === 'function') window.showToast(enabled ? '✨ Blouse Options enabled' : 'Blouse Options disabled');
}

function toggleBorderVariationsSection(enabled) {
    const container = document.getElementById('borderVariationsContainer');
    if (container) container.style.display = enabled ? 'block' : 'none';
    if (typeof window.showToast === 'function') window.showToast(enabled ? '✨ Border Options enabled' : 'Border Options disabled');
}

function toggleColorPickerDrawer() {
    const box = document.getElementById('colorPickerBox');
    if (box) {
        box.style.display = (box.style.display === 'none' || !box.style.display) ? 'block' : 'none';
        if (box.style.display === 'block') document.getElementById('varColorName').focus();
    }
}

function toggleSizePickerDrawer() {
    const box = document.getElementById('sizePickerBox');
    if (box) {
        box.style.display = (box.style.display === 'none' || !box.style.display) ? 'block' : 'none';
        if (box.style.display === 'block') document.getElementById('varSizeName').focus();
    }
}

function toggleBlousePickerDrawer() {
    const box = document.getElementById('blousePickerBox');
    if (box) {
        box.style.display = (box.style.display === 'none' || !box.style.display) ? 'block' : 'none';
        if (box.style.display === 'block') document.getElementById('varBlouseName').focus();
    }
}

function toggleBorderPickerDrawer() {
    const box = document.getElementById('borderPickerBox');
    if (box) {
        box.style.display = (box.style.display === 'none' || !box.style.display) ? 'block' : 'none';
        if (box.style.display === 'block') document.getElementById('varBorderName').focus();
    }
}

function selectPresetSize(size) {
    document.getElementById('varSizeName').value = size;
}

function selectPresetBlouse(blouse, extraPrice) {
    document.getElementById('varBlouseName').value = blouse;
}

function selectPresetBorder(border) {
    document.getElementById('varBorderName').value = border;
}

function submitNewColorVariation() {
    const nameInput = document.getElementById('varColorName');
    const colorHex = document.getElementById('varColorHex').value || '#db2777';
    let colorName = nameInput.value.trim() || detectOriginalColorName(colorHex);

    const list = document.getElementById('colorVariationsList');
    const swatchList = document.getElementById('quickSwatchList');
    const newId = 'cvar-' + Date.now();
    const skuCode = 'KLN-SR-' + colorName.replace(/[^a-zA-Z0-9]/g, '').slice(0, 4).toUpperCase();
    const basePrice = document.getElementById('pFormMrp')?.value || '1000';
    const baseSale = document.getElementById('pFormRetail')?.value || '900';

    const chip = document.createElement('span');
    chip.className = 'adm-badge gold';
    chip.id = 'chip-' + newId;
    chip.style.cssText = 'display:inline-flex; align-items:center; gap:5px; font-size:11px; padding:3px 8px;';
    chip.innerHTML = `<span style="width:10px; height:10px; border-radius:50%; background:${colorHex}; display:inline-block; border:1px solid #fff;"></span><span>${colorName}</span>`;
    swatchList.appendChild(chip);

    const card = document.createElement('div');
    card.className = 'color-var-card';
    card.id = newId;
    card.style.cssText = 'border:1px solid #c3c4c7; border-radius:4px; background:#fff; overflow:hidden;';
    card.innerHTML = `
        <div style="background:#f6f7f7; padding:8px 12px; border-bottom:1px solid #c3c4c7; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="width:16px; height:16px; border-radius:50%; background:${colorHex}; display:inline-block; border:1px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                <strong style="font-size:13px; color:#1d2327;">${colorName}</strong>
                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px;">Sale: ₹${baseSale}</span>
            </div>
            <div>
                <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px; font-weight:600;" onclick="removeColorVariationCard('${newId}', '${colorName}')">✕ Remove</button>
            </div>
        </div>
        <div style="padding:12px 14px; display:flex; gap:16px; align-items:flex-start; flex-wrap:wrap;">
            <div style="width:80px; text-align:center;">
                <img src="/Shared/Asset/images/product4.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:70px; height:70px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7; cursor:pointer;" title="Click to upload color photo" onclick="this.nextElementSibling.click()">
                <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);window.showToast('${colorName} photo updated');}">
                <small style="font-size:10px; color:#2271b1; cursor:pointer; display:block; margin-top:3px;" onclick="this.previousElementSibling.click()">+ Add Photo</small>
            </div>
            <div style="flex:1; min-width:260px;">
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(120px, 1fr)); gap:10px;">
                    <div>
                        <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Variant SKU:</label>
                        <input type="text" class="adm-form-input" style="height:28px; font-size:12px;" value="${skuCode}">
                    </div>
                    <div>
                        <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Price ₹:</label>
                        <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="${basePrice}">
                    </div>
                    <div>
                        <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Sale Price ₹ <span style="color:#b32d2e;">*</span>:</label>
                        <input type="number" class="adm-form-input" style="height:28px; font-size:12px; font-weight:700; color:#181512;" value="${baseSale}">
                    </div>
                    <div>
                        <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Stock (Units):</label>
                        <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="15">
                    </div>
                    <div>
                        <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Status:</label>
                        <select class="adm-form-select" style="height:28px; font-size:11.5px; padding:0 6px;">
                            <option selected>In Stock</option>
                            <option>Low Stock</option>
                            <option>Out of Stock</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    `;
    list.appendChild(card);
    toggleColorPickerDrawer();
    if (typeof window.showToast === 'function') window.showToast(`✨ Color variation "${colorName}" auto-saved!`);
}

function submitNewSizeVariation() {
    const nameInput = document.getElementById('varSizeName');
    const sizeName = nameInput.value.trim();
    if (!sizeName) return;

    const list = document.getElementById('sizeVariationsList');
    const sizeList = document.getElementById('quickSizeList');
    const newId = 'svar-' + Date.now();
    const skuCode = 'KLN-SR-' + sizeName.replace(/[^a-zA-Z0-9]/g, '').slice(0, 4).toUpperCase();
    const basePrice = document.getElementById('pFormMrp')?.value || '1000';
    const baseSale = document.getElementById('pFormRetail')?.value || '900';

    const chip = document.createElement('span');
    chip.className = 'adm-badge gold';
    chip.id = 'chip-' + newId;
    chip.style.cssText = 'font-size:11px; padding:3px 8px;';
    chip.textContent = sizeName;
    sizeList.appendChild(chip);

    const card = document.createElement('div');
    card.className = 'size-var-card';
    card.id = newId;
    card.style.cssText = 'border:1px solid #c3c4c7; border-radius:4px; background:#fff; overflow:hidden;';
    card.innerHTML = `
        <div style="background:#f6f7f7; padding:8px 12px; border-bottom:1px solid #c3c4c7; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span class="adm-badge" style="background:#8A681F; color:#fff; font-size:11px; font-weight:700;">SIZE</span>
                <strong style="font-size:13px; color:#1d2327;">${sizeName}</strong>
                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px;">Sale: ₹${baseSale}</span>
            </div>
            <div>
                <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px; font-weight:600;" onclick="removeSizeVariationCard('${newId}')">✕ Remove</button>
            </div>
        </div>
        <div style="padding:12px 14px;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(130px, 1fr)); gap:10px;">
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Size SKU:</label>
                    <input type="text" class="adm-form-input" style="height:28px; font-size:12px;" value="${skuCode}">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Price ₹:</label>
                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="${basePrice}">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Sale Price ₹ <span style="color:#b32d2e;">*</span>:</label>
                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px; font-weight:700; color:#181512;" value="${baseSale}">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Stock (Units):</label>
                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="20">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Status:</label>
                    <select class="adm-form-select" style="height:28px; font-size:11.5px; padding:0 6px;">
                        <option selected>In Stock</option>
                        <option>Low Stock</option>
                        <option>Out of Stock</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    list.appendChild(card);
    toggleSizePickerDrawer();
    if (typeof window.showToast === 'function') window.showToast(`✨ Size variation "${sizeName}" added!`);
}

function submitNewBlouseVariation() {
    const nameInput = document.getElementById('varBlouseName');
    const blouseName = nameInput.value.trim();
    if (!blouseName) return;

    const list = document.getElementById('blouseVariationsList');
    const blouseList = document.getElementById('quickBlouseList');
    const newId = 'bvar-' + Date.now();
    const skuCode = 'KLN-SR-111-BLS-' + blouseName.replace(/[^a-zA-Z0-9]/g, '').slice(0, 4).toUpperCase();
    const basePrice = document.getElementById('pFormMrp')?.value || '1000';
    const baseSale = document.getElementById('pFormRetail')?.value || '900';

    const chip = document.createElement('span');
    chip.className = 'adm-badge gold';
    chip.id = 'chip-' + newId;
    chip.style.cssText = 'font-size:11px; padding:3px 8px;';
    chip.textContent = blouseName;
    blouseList.appendChild(chip);

    const card = document.createElement('div');
    card.className = 'blouse-var-card';
    card.id = newId;
    card.style.cssText = 'border:1px solid #c3c4c7; border-radius:4px; background:#fff; overflow:hidden;';
    card.innerHTML = `
        <div style="background:#f6f7f7; padding:8px 12px; border-bottom:1px solid #c3c4c7; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span class="adm-badge" style="background:#7E22CE; color:#fff; font-size:11px; font-weight:700;">BLOUSE</span>
                <strong style="font-size:13px; color:#1d2327;">${blouseName}</strong>
                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px;">Sale: ₹${baseSale}</span>
            </div>
            <div>
                <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px; font-weight:600;" onclick="removeBlouseVariationCard('${newId}')">✕ Remove</button>
            </div>
        </div>
        <div style="padding:12px 14px;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(130px, 1fr)); gap:10px;">
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Blouse SKU:</label>
                    <input type="text" class="adm-form-input" style="height:28px; font-size:12px;" value="${skuCode}">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Price ₹:</label>
                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="${basePrice}">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Sale Price ₹ <span style="color:#b32d2e;">*</span>:</label>
                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px; font-weight:700; color:#181512;" value="${baseSale}">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Stock (Units):</label>
                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="15">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Status:</label>
                    <select class="adm-form-select" style="height:28px; font-size:11.5px; padding:0 6px;">
                        <option selected>In Stock</option>
                        <option>Low Stock</option>
                        <option>Out of Stock</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    list.appendChild(card);
    toggleBlousePickerDrawer();
    if (typeof window.showToast === 'function') window.showToast(`✨ Blouse option "${blouseName}" added!`);
}

function submitNewBorderVariation() {
    const nameInput = document.getElementById('varBorderName');
    const borderName = nameInput.value.trim();
    if (!borderName) return;

    const list = document.getElementById('borderVariationsList');
    const borderList = document.getElementById('quickBorderList');
    const newId = 'brdvar-' + Date.now();
    const skuCode = 'KLN-SR-111-BRD-' + borderName.replace(/[^a-zA-Z0-9]/g, '').slice(0, 4).toUpperCase();
    const basePrice = document.getElementById('pFormMrp')?.value || '1000';
    const baseSale = document.getElementById('pFormRetail')?.value || '900';

    const chip = document.createElement('span');
    chip.className = 'adm-badge gold';
    chip.id = 'chip-' + newId;
    chip.style.cssText = 'font-size:11px; padding:3px 8px;';
    chip.textContent = borderName;
    borderList.appendChild(chip);

    const card = document.createElement('div');
    card.className = 'border-var-card';
    card.id = newId;
    card.style.cssText = 'border:1px solid #c3c4c7; border-radius:4px; background:#fff; overflow:hidden;';
    card.innerHTML = `
        <div style="background:#f6f7f7; padding:8px 12px; border-bottom:1px solid #c3c4c7; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span class="adm-badge" style="background:#0F766E; color:#fff; font-size:11px; font-weight:700;">BORDER</span>
                <strong style="font-size:13px; color:#1d2327;">${borderName}</strong>
                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px;">Sale: ₹${baseSale}</span>
            </div>
            <div>
                <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px; font-weight:600;" onclick="removeBorderVariationCard('${newId}')">✕ Remove</button>
            </div>
        </div>
        <div style="padding:12px 14px;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(130px, 1fr)); gap:10px;">
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Border SKU:</label>
                    <input type="text" class="adm-form-input" style="height:28px; font-size:12px;" value="${skuCode}">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Price ₹:</label>
                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="${basePrice}">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Sale Price ₹ <span style="color:#b32d2e;">*</span>:</label>
                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px; font-weight:700; color:#181512;" value="${baseSale}">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Stock (Units):</label>
                    <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="25">
                </div>
                <div>
                    <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Status:</label>
                    <select class="adm-form-select" style="height:28px; font-size:11.5px; padding:0 6px;">
                        <option selected>In Stock</option>
                        <option>Low Stock</option>
                        <option>Out of Stock</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    list.appendChild(card);
    toggleBorderPickerDrawer();
    if (typeof window.showToast === 'function') window.showToast(`✨ Border option "${borderName}" added!`);
}

function removeColorVariationCard(cardId, colorName) {
    const card = document.getElementById(cardId);
    if (card) card.remove();
    const chip = document.getElementById('chip-' + cardId);
    if (chip) chip.remove();
    if (typeof window.showToast === 'function') window.showToast(`Color variation removed`);
}

function removeSizeVariationCard(cardId) {
    const card = document.getElementById(cardId);
    if (card) card.remove();
    const chip = document.getElementById('chip-' + cardId);
    if (chip) chip.remove();
    if (typeof window.showToast === 'function') window.showToast(`Size variation removed`);
}

function removeBlouseVariationCard(cardId) {
    const card = document.getElementById(cardId);
    if (card) card.remove();
    const chip = document.getElementById('chip-' + cardId);
    if (chip) chip.remove();
    if (typeof window.showToast === 'function') window.showToast(`Blouse option removed`);
}

function removeBorderVariationCard(cardId) {
    const card = document.getElementById(cardId);
    if (card) card.remove();
    const chip = document.getElementById('chip-' + cardId);
    if (chip) chip.remove();
    if (typeof window.showToast === 'function') window.showToast(`Border option removed`);
}
</script>
