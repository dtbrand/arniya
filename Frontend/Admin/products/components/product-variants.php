<?php
/**
 * product-variants.php — Modern Color & Style Variations Studio
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <!-- Header with Master Checkbox Toggle -->
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
            <h3 class="dt-form-sec-title" style="margin:0;"><span>Options &amp; Color Variations</span></h3>
        </div>
        <div>
            <label style="display:flex; align-items:center; gap:6px; font-size:12.5px; font-weight:700; color:#1d2327; cursor:pointer; background:#FAF5E8; border:1px solid rgba(212,175,55,0.5); padding:4px 10px; border-radius:4px;">
                <input type="checkbox" id="chkEnableColors" checked onchange="toggleColorVariationsSection(this.checked)" style="cursor:pointer; width:15px; height:15px;">
                <span>Colors Available</span>
            </label>
        </div>
    </div>

    <div class="dt-form-sec-body" id="colorVariationsContainer">
        
        <!-- Action Toolbar: + Add Color Button & Active Swatches -->
        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.45); border-radius:6px; padding:10px 14px; margin-bottom:14px;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <span style="font-size:12px; font-weight:700; color:#5A4210;">Available Colors:</span>
                    <div id="quickSwatchList" style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                        <span class="adm-badge gold" style="display:inline-flex; align-items:center; gap:5px; font-size:11px; padding:3px 8px;">
                            <span style="width:10px; height:10px; border-radius:50%; background:#991b1b; display:inline-block; border:1px solid #fff;"></span>
                            <span>Crimson Red</span>
                        </span>
                        <span class="adm-badge gold" style="display:inline-flex; align-items:center; gap:5px; font-size:11px; padding:3px 8px;">
                            <span style="width:10px; height:10px; border-radius:50%; background:#166534; display:inline-block; border:1px solid #fff;"></span>
                            <span>Bottle Green</span>
                        </span>
                        <span class="adm-badge gold" style="display:inline-flex; align-items:center; gap:5px; font-size:11px; padding:3px 8px;">
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

            <!-- Smart Color Picker Dropdown Box (Opens on click) -->
            <div id="colorPickerBox" style="display:none; margin-top:12px; padding-top:12px; border-top:1px dashed rgba(212,175,55,0.5);">
                <div style="font-size:12px; font-weight:700; color:#1d2327; margin-bottom:8px;">Pick a Color &amp; Add Variation:</div>
                <div style="display:flex; align-items:center; flex-wrap:wrap; gap:10px;">
                    <!-- Color input -->
                    <div style="display:flex; align-items:center; gap:6px;">
                        <input type="color" id="varColorPicker" value="#db2777" style="width:34px; height:32px; padding:0; border:1px solid #c3c4c7; border-radius:4px; cursor:pointer;" onchange="document.getElementById('varColorHex').value=this.value;">
                        <input type="text" id="varColorHex" value="#db2777" style="width:75px; height:30px; font-size:12px; padding:0 6px; border:1px solid #8c8f94; border-radius:3px; font-family:monospace;" oninput="document.getElementById('varColorPicker').value=this.value;">
                    </div>

                    <!-- Preset Color Swatch Circles -->
                    <div style="display:flex; gap:6px; align-items:center;">
                        <span title="Crimson Red" onclick="selectPresetColor('#991b1b', 'Crimson Red')" style="width:20px; height:20px; border-radius:50%; background:#991b1b; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                        <span title="Bottle Green" onclick="selectPresetColor('#166534', 'Bottle Green')" style="width:20px; height:20px; border-radius:50%; background:#166534; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                        <span title="Royal Blue" onclick="selectPresetColor('#1e40af', 'Royal Blue')" style="width:20px; height:20px; border-radius:50%; background:#1e40af; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                        <span title="Mustard Yellow" onclick="selectPresetColor('#d97706', 'Mustard Yellow')" style="width:20px; height:20px; border-radius:50%; background:#d97706; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                        <span title="Rani Pink" onclick="selectPresetColor('#db2777', 'Rani Pink')" style="width:20px; height:20px; border-radius:50%; background:#db2777; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                        <span title="Peacock Teal" onclick="selectPresetColor('#0f766e', 'Peacock Teal')" style="width:20px; height:20px; border-radius:50%; background:#0f766e; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                        <span title="Maroon" onclick="selectPresetColor('#831843', 'Maroon')" style="width:20px; height:20px; border-radius:50%; background:#831843; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                        <span title="Jet Black" onclick="selectPresetColor('#18181b', 'Jet Black')" style="width:20px; height:20px; border-radius:50%; background:#18181b; cursor:pointer; border:2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                    </div>

                    <!-- Color Name Input -->
                    <input type="text" id="varColorName" placeholder="Color Name (e.g. Rani Pink)" style="height:30px; font-size:12.5px; padding:0 8px; border:1px solid #8c8f94; border-radius:3px; width:180px; outline:none;" onkeydown="if(event.key==='Enter'){event.preventDefault();submitNewColorVariation();}">

                    <!-- Confirm Button -->
                    <button type="button" class="wp-button" onclick="submitNewColorVariation()" style="height:30px; font-size:12px; font-weight:600;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Create Color Variation</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- List of Color Variation Cards (Each with Photo, SKU, Price, Sale Price, Stock) -->
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
                    <!-- Photo Uploader -->
                    <div style="width:80px; text-align:center;">
                        <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:70px; height:70px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7; cursor:pointer;" title="Click to upload color photo" onclick="this.nextElementSibling.click()">
                        <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);window.showToast('Crimson Red photo updated');}">
                        <small style="font-size:10px; color:#2271b1; cursor:pointer; display:block; margin-top:3px;" onclick="this.previousElementSibling.click()">+ Add Photo</small>
                    </div>

                    <!-- Fields: SKU, Price, Sale Price, Stock, Status -->
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
                    <!-- Photo Uploader -->
                    <div style="width:80px; text-align:center;">
                        <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" style="width:70px; height:70px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7; cursor:pointer;" title="Click to upload color photo" onclick="this.nextElementSibling.click()">
                        <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);window.showToast('Bottle Green photo updated');}">
                        <small style="font-size:10px; color:#2271b1; cursor:pointer; display:block; margin-top:3px;" onclick="this.previousElementSibling.click()">+ Add Photo</small>
                    </div>

                    <!-- Fields: SKU, Price, Sale Price, Stock, Status -->
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

            <!-- Color Variation 3: Royal Blue -->
            <div class="color-var-card" id="cvar-3" style="border:1px solid #c3c4c7; border-radius:4px; background:#fff; overflow:hidden;">
                <div style="background:#f6f7f7; padding:8px 12px; border-bottom:1px solid #c3c4c7; display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="width:16px; height:16px; border-radius:50%; background:#1e40af; display:inline-block; border:1px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.3);"></span>
                        <strong style="font-size:13px; color:#1d2327;">Royal Blue</strong>
                        <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px;">Sale: ₹900</span>
                    </div>
                    <div>
                        <button type="button" style="background:none; border:none; color:#b32d2e; cursor:pointer; font-size:11.5px; font-weight:600;" onclick="removeColorVariationCard('cvar-3', 'Royal Blue')">✕ Remove</button>
                    </div>
                </div>
                <div style="padding:12px 14px; display:flex; gap:16px; align-items:flex-start; flex-wrap:wrap;">
                    <!-- Photo Uploader -->
                    <div style="width:80px; text-align:center;">
                        <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" style="width:70px; height:70px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7; cursor:pointer;" title="Click to upload color photo" onclick="this.nextElementSibling.click()">
                        <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);window.showToast('Royal Blue photo updated');}">
                        <small style="font-size:10px; color:#2271b1; cursor:pointer; display:block; margin-top:3px;" onclick="this.previousElementSibling.click()">+ Add Photo</small>
                    </div>

                    <!-- Fields: SKU, Price, Sale Price, Stock, Status -->
                    <div style="flex:1; min-width:260px;">
                        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(120px, 1fr)); gap:10px;">
                            <div>
                                <label class="adm-form-label" style="font-size:11px; margin-bottom:2px;">Variant SKU:</label>
                                <input type="text" class="adm-form-input" style="height:28px; font-size:12px;" value="KLN-SR-111-BLU">
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
                                <input type="number" class="adm-form-input" style="height:28px; font-size:12px;" value="12">
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
function toggleColorVariationsSection(enabled) {
    const container = document.getElementById('colorVariationsContainer');
    if (container) {
        container.style.display = enabled ? 'block' : 'none';
    }
    if (typeof window.showToast === 'function') {
        window.showToast(enabled ? '✨ Color Variations enabled' : 'Color Variations disabled');
    }
}

function toggleColorPickerDrawer() {
    const box = document.getElementById('colorPickerBox');
    if (box) {
        box.style.display = (box.style.display === 'none' || !box.style.display) ? 'block' : 'none';
        if (box.style.display === 'block') {
            document.getElementById('varColorName').focus();
        }
    }
}

function selectPresetColor(hex, name) {
    document.getElementById('varColorPicker').value = hex;
    document.getElementById('varColorHex').value = hex;
    document.getElementById('varColorName').value = name;
}

function submitNewColorVariation() {
    const nameInput = document.getElementById('varColorName');
    const colorName = nameInput.value.trim();
    if (!colorName) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Please enter a color name (e.g. Rani Pink)');
        return;
    }
    const colorHex = document.getElementById('varColorHex').value || '#db2777';
    const list = document.getElementById('colorVariationsList');
    const swatchList = document.getElementById('quickSwatchList');
    const newId = 'cvar-' + Date.now();
    const skuCode = 'KLN-SR-' + colorName.replace(/[^a-zA-Z0-9]/g, '').slice(0, 4).toUpperCase();
    const basePrice = document.getElementById('pFormMrp')?.value || '1000';
    const baseSale = document.getElementById('pFormRetail')?.value || '900';

    // 1. Add Swatch Tag
    const chip = document.createElement('span');
    chip.className = 'adm-badge gold';
    chip.id = 'chip-' + newId;
    chip.style.cssText = 'display:inline-flex; align-items:center; gap:5px; font-size:11px; padding:3px 8px;';
    chip.innerHTML = `
        <span style="width:10px; height:10px; border-radius:50%; background:${colorHex}; display:inline-block; border:1px solid #fff;"></span>
        <span>${colorName}</span>
    `;
    swatchList.appendChild(chip);

    // 2. Add Color Card
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
    nameInput.value = '';
    toggleColorPickerDrawer();

    if (typeof window.showToast === 'function') {
        window.showToast(`✨ Color variation "${colorName}" created!`);
    }
}

function removeColorVariationCard(cardId, colorName) {
    const card = document.getElementById(cardId);
    if (card) card.remove();
    const chip = document.getElementById('chip-' + cardId);
    if (chip) chip.remove();
    if (typeof window.showToast === 'function') {
        window.showToast(`Color variation removed`);
    }
}
</script>
