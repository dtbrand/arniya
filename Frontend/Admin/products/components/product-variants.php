<?php
/**
 * product-variants.php — Next-Level Attributes & Variant Matrix Studio
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
            <span>Attributes &amp; Variant Matrix</span>
        </h3>
        <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
            <button type="button" class="wp-button" onclick="addNewVariantRow()">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Add Variant</span>
            </button>
            <button type="button" class="wp-button primary" onclick="generateAllVariantCombinations()">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                <span>Generate Combinations</span>
            </button>
        </div>
    </div>
    <div class="dt-form-sec-body">
        
        <!-- 1. Interactive Attribute Tags & Selector -->
        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:6px; padding:10px 12px; margin-bottom:12px;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:8px;">
                <div style="font-weight:700; font-size:12px; color:#5A4210; display:flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    <span>Selected Attributes for Variants:</span>
                </div>
                <div style="display:flex; gap:6px;">
                    <input type="text" id="newAttrInput" placeholder="Add custom attribute (e.g. Yellow)..." style="height:24px; font-size:11.5px; padding:0 6px; border:1px solid #c3c4c7; border-radius:3px; outline:none; width:180px;" onkeydown="if(event.key==='Enter'){event.preventDefault();addCustomAttributeTag();}">
                    <button type="button" class="wp-button" style="height:24px; padding:0 8px; font-size:11px;" onclick="addCustomAttributeTag()">+ Add</button>
                </div>
            </div>
            
            <div id="attrChipContainer" style="display:flex; gap:6px; flex-wrap:wrap;">
                <span class="adm-badge gold dt-attr-chip" style="font-size:11px; padding:3px 8px; display:inline-flex; align-items:center; gap:6px;">
                    <span>Color: Crimson Red</span>
                    <span style="cursor:pointer; font-weight:800; color:#b32d2e;" onclick="this.parentElement.remove(); window.showToast('Attribute removed');">✕</span>
                </span>
                <span class="adm-badge gold dt-attr-chip" style="font-size:11px; padding:3px 8px; display:inline-flex; align-items:center; gap:6px;">
                    <span>Color: Bottle Green</span>
                    <span style="cursor:pointer; font-weight:800; color:#b32d2e;" onclick="this.parentElement.remove(); window.showToast('Attribute removed');">✕</span>
                </span>
                <span class="adm-badge gold dt-attr-chip" style="font-size:11px; padding:3px 8px; display:inline-flex; align-items:center; gap:6px;">
                    <span>Color: Royal Blue</span>
                    <span style="cursor:pointer; font-weight:800; color:#b32d2e;" onclick="this.parentElement.remove(); window.showToast('Attribute removed');">✕</span>
                </span>
                <span class="adm-badge gold dt-attr-chip" style="font-size:11px; padding:3px 8px; display:inline-flex; align-items:center; gap:6px;">
                    <span>Size: Free Size (6.3m)</span>
                    <span style="cursor:pointer; font-weight:800; color:#b32d2e;" onclick="this.parentElement.remove(); window.showToast('Attribute removed');">✕</span>
                </span>
            </div>
        </div>

        <!-- 2. Quick Bulk Apply Bar -->
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:8px;">
            <div style="font-size:12px; font-weight:600; color:#1d2327;">Generated Variant Combinations (<span id="variantRowCount">3</span> items)</div>
            <div style="display:flex; align-items:center; gap:6px; font-size:11.5px;">
                <span style="color:#646970;">Bulk Apply:</span>
                <button type="button" class="wp-page-title-action secondary" style="font-size:11px; padding:2px 6px;" onclick="bulkApplyPrice()">Sync Base Price</button>
                <button type="button" class="wp-page-title-action secondary" style="font-size:11px; padding:2px 6px;" onclick="bulkApplyStock()">Set Stock (15)</button>
            </div>
        </div>

        <!-- 3. Variant Matrix Table -->
        <div class="dt-table-wrap" style="overflow-x:auto; border:1px solid #c3c4c7; border-radius:4px;">
            <table class="wp-list-table" id="dtVariantMatrixTable" style="width:100%; border-collapse:collapse; font-size:12px; margin:0;">
                <thead>
                    <tr style="background:#f6f7f7;">
                        <th style="width:36px; padding:6px 6px; text-align:center;">Photo</th>
                        <th style="padding:6px 8px;">Variant Combination</th>
                        <th style="padding:6px 8px;">Variant SKU</th>
                        <th style="padding:6px 8px;">Price (₹)</th>
                        <th style="padding:6px 8px;">Sale Price (₹)</th>
                        <th style="padding:6px 8px;">Stock Qty</th>
                        <th style="padding:6px 8px;">Status</th>
                        <th style="padding:6px 8px; text-align:right; width:40px;">Action</th>
                    </tr>
                </thead>
                <tbody id="dtVariantTableBody">
                    <!-- Variant Row 1 -->
                    <tr id="vrow-1">
                        <td style="padding:4px 6px; text-align:center;">
                            <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:30px; height:30px; object-fit:cover; border-radius:3px; border:1px solid #c3c4c7; cursor:pointer;" title="Click to upload variant photo" onclick="this.nextElementSibling.click()">
                            <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);}">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="text" class="adm-form-input" style="height:26px; padding:0 6px; font-weight:600;" value="Crimson Red / 6.3m">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="text" class="adm-form-input" style="height:26px; padding:0 6px; font-family:monospace;" value="KLN-SR-111-RED">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="number" class="adm-form-input var-mrp" style="width:85px; height:26px; padding:0 6px;" value="1000">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="number" class="adm-form-input var-retail" style="width:85px; height:26px; padding:0 6px; font-weight:700; color:#181512;" value="900">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="number" class="adm-form-input var-stock" style="width:65px; height:26px; padding:0 6px;" value="18">
                        </td>
                        <td style="padding:6px 8px;">
                            <select class="adm-form-select" style="height:26px; font-size:11px; padding:0 4px;">
                                <option selected>In Stock</option>
                                <option>Low Stock</option>
                                <option>Out of Stock</option>
                            </select>
                        </td>
                        <td style="padding:6px 8px; text-align:right;">
                            <button type="button" class="wp-button" style="height:22px; font-size:11px; color:#b32d2e; padding:0 6px;" onclick="deleteVariantRow('vrow-1')">✕</button>
                        </td>
                    </tr>

                    <!-- Variant Row 2 -->
                    <tr id="vrow-2">
                        <td style="padding:4px 6px; text-align:center;">
                            <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" style="width:30px; height:30px; object-fit:cover; border-radius:3px; border:1px solid #c3c4c7; cursor:pointer;" title="Click to upload variant photo" onclick="this.nextElementSibling.click()">
                            <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);}">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="text" class="adm-form-input" style="height:26px; padding:0 6px; font-weight:600;" value="Bottle Green / 6.3m">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="text" class="adm-form-input" style="height:26px; padding:0 6px; font-family:monospace;" value="KLN-SR-111-GRN">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="number" class="adm-form-input var-mrp" style="width:85px; height:26px; padding:0 6px;" value="1000">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="number" class="adm-form-input var-retail" style="width:85px; height:26px; padding:0 6px; font-weight:700; color:#181512;" value="900">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="number" class="adm-form-input var-stock" style="width:65px; height:26px; padding:0 6px;" value="15">
                        </td>
                        <td style="padding:6px 8px;">
                            <select class="adm-form-select" style="height:26px; font-size:11px; padding:0 4px;">
                                <option selected>In Stock</option>
                                <option>Low Stock</option>
                                <option>Out of Stock</option>
                            </select>
                        </td>
                        <td style="padding:6px 8px; text-align:right;">
                            <button type="button" class="wp-button" style="height:22px; font-size:11px; color:#b32d2e; padding:0 6px;" onclick="deleteVariantRow('vrow-2')">✕</button>
                        </td>
                    </tr>

                    <!-- Variant Row 3 -->
                    <tr id="vrow-3">
                        <td style="padding:4px 6px; text-align:center;">
                            <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" style="width:30px; height:30px; object-fit:cover; border-radius:3px; border:1px solid #c3c4c7; cursor:pointer;" title="Click to upload variant photo" onclick="this.nextElementSibling.click()">
                            <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);}">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="text" class="adm-form-input" style="height:26px; padding:0 6px; font-weight:600;" value="Royal Blue / 6.3m">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="text" class="adm-form-input" style="height:26px; padding:0 6px; font-family:monospace;" value="KLN-SR-111-BLU">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="number" class="adm-form-input var-mrp" style="width:85px; height:26px; padding:0 6px;" value="1000">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="number" class="adm-form-input var-retail" style="width:85px; height:26px; padding:0 6px; font-weight:700; color:#181512;" value="900">
                        </td>
                        <td style="padding:6px 8px;">
                            <input type="number" class="adm-form-input var-stock" style="width:65px; height:26px; padding:0 6px;" value="12">
                        </td>
                        <td style="padding:6px 8px;">
                            <select class="adm-form-select" style="height:26px; font-size:11px; padding:0 4px;">
                                <option selected>In Stock</option>
                                <option>Low Stock</option>
                                <option>Out of Stock</option>
                            </select>
                        </td>
                        <td style="padding:6px 8px; text-align:right;">
                            <button type="button" class="wp-button" style="height:22px; font-size:11px; color:#b32d2e; padding:0 6px;" onclick="deleteVariantRow('vrow-3')">✕</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function addCustomAttributeTag() {
    const input = document.getElementById('newAttrInput');
    const val = input.value.trim();
    if (!val) return;

    const container = document.getElementById('attrChipContainer');
    const chip = document.createElement('span');
    chip.className = 'adm-badge gold dt-attr-chip';
    chip.style.cssText = 'font-size:11px; padding:3px 8px; display:inline-flex; align-items:center; gap:6px;';
    chip.innerHTML = `
        <span>${val}</span>
        <span style="cursor:pointer; font-weight:800; color:#b32d2e;" onclick="this.parentElement.remove(); window.showToast('Attribute removed');">✕</span>
    `;
    container.appendChild(chip);
    input.value = '';
    if (typeof window.showToast === 'function') {
        window.showToast(`✨ Attribute "${val}" added!`);
    }
}

function updateVariantRowCount() {
    const rows = document.querySelectorAll('#dtVariantTableBody tr');
    const counter = document.getElementById('variantRowCount');
    if (counter) counter.textContent = rows.length;
}

function addNewVariantRow() {
    const tbody = document.getElementById('dtVariantTableBody');
    const newId = 'vrow-' + Date.now();
    const count = tbody.querySelectorAll('tr').length + 1;
    const basePrice = document.getElementById('pFormMrp')?.value || '1000';
    const baseSalePrice = document.getElementById('pFormRetail')?.value || '900';

    const tr = document.createElement('tr');
    tr.id = newId;
    tr.innerHTML = `
        <td style="padding:4px 6px; text-align:center;">
            <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:30px; height:30px; object-fit:cover; border-radius:3px; border:1px solid #c3c4c7; cursor:pointer;" title="Click to upload variant photo" onclick="this.nextElementSibling.click()">
            <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);}">
        </td>
        <td style="padding:6px 8px;">
            <input type="text" class="adm-form-input" style="height:26px; padding:0 6px; font-weight:600;" value="Custom Variant #${count}">
        </td>
        <td style="padding:6px 8px;">
            <input type="text" class="adm-form-input" style="height:26px; padding:0 6px; font-family:monospace;" value="KLN-SR-111-VAR${count}">
        </td>
        <td style="padding:6px 8px;">
            <input type="number" class="adm-form-input var-mrp" style="width:85px; height:26px; padding:0 6px;" value="${basePrice}">
        </td>
        <td style="padding:6px 8px;">
            <input type="number" class="adm-form-input var-retail" style="width:85px; height:26px; padding:0 6px; font-weight:700; color:#181512;" value="${baseSalePrice}">
        </td>
        <td style="padding:6px 8px;">
            <input type="number" class="adm-form-input var-stock" style="width:65px; height:26px; padding:0 6px;" value="10">
        </td>
        <td style="padding:6px 8px;">
            <select class="adm-form-select" style="height:26px; font-size:11px; padding:0 4px;">
                <option selected>In Stock</option>
                <option>Low Stock</option>
                <option>Out of Stock</option>
            </select>
        </td>
        <td style="padding:6px 8px; text-align:right;">
            <button type="button" class="wp-button" style="height:22px; font-size:11px; color:#b32d2e; padding:0 6px;" onclick="deleteVariantRow('${newId}')">✕</button>
        </td>
    `;
    tbody.appendChild(tr);
    updateVariantRowCount();
    if (typeof window.showToast === 'function') {
        window.showToast('✨ New variant row added!');
    }
}

function generateAllVariantCombinations() {
    const chips = document.querySelectorAll('#attrChipContainer .dt-attr-chip span:first-child');
    if (!chips.length) {
        if (typeof window.showToast === 'function') {
            window.showToast('⚠️ Please add at least 1 attribute first');
        }
        return;
    }

    const tbody = document.getElementById('dtVariantTableBody');
    tbody.innerHTML = '';
    const basePrice = document.getElementById('pFormMrp')?.value || '1000';
    const baseSalePrice = document.getElementById('pFormRetail')?.value || '900';

    chips.forEach((chip, i) => {
        const text = chip.textContent;
        const code = text.replace(/[^a-zA-Z0-9]/g, '').slice(0, 4).toUpperCase();
        const newId = 'vrow-gen-' + (i + 1);

        const tr = document.createElement('tr');
        tr.id = newId;
        tr.innerHTML = `
            <td style="padding:4px 6px; text-align:center;">
                <img src="/Shared/Asset/images/product${(i % 4) + 1}.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:30px; height:30px; object-fit:cover; border-radius:3px; border:1px solid #c3c4c7; cursor:pointer;" title="Click to upload variant photo" onclick="this.nextElementSibling.click()">
                <input type="file" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader();r.onload=e=>this.previousElementSibling.src=e.target.result;r.readAsDataURL(this.files[0]);}">
            </td>
            <td style="padding:6px 8px;">
                <input type="text" class="adm-form-input" style="height:26px; padding:0 6px; font-weight:600;" value="${text}">
            </td>
            <td style="padding:6px 8px;">
                <input type="text" class="adm-form-input" style="height:26px; padding:0 6px; font-family:monospace;" value="KLN-SR-${code}">
            </td>
            <td style="padding:6px 8px;">
                <input type="number" class="adm-form-input var-mrp" style="width:85px; height:26px; padding:0 6px;" value="${basePrice}">
            </td>
            <td style="padding:6px 8px;">
                <input type="number" class="adm-form-input var-retail" style="width:85px; height:26px; padding:0 6px; font-weight:700; color:#181512;" value="${baseSalePrice}">
            </td>
            <td style="padding:6px 8px;">
                <input type="number" class="adm-form-input var-stock" style="width:65px; height:26px; padding:0 6px;" value="15">
            </td>
            <td style="padding:6px 8px;">
                <select class="adm-form-select" style="height:26px; font-size:11px; padding:0 4px;">
                    <option selected>In Stock</option>
                    <option>Low Stock</option>
                    <option>Out of Stock</option>
                </select>
            </td>
            <td style="padding:6px 8px; text-align:right;">
                <button type="button" class="wp-button" style="height:22px; font-size:11px; color:#b32d2e; padding:0 6px;" onclick="deleteVariantRow('${newId}')">✕</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    updateVariantRowCount();
    if (typeof window.showToast === 'function') {
        window.showToast(`✨ Generated ${chips.length} variant combinations!`);
    }
}

function bulkApplyPrice() {
    const basePrice = document.getElementById('pFormMrp')?.value || '1000';
    const baseSale = document.getElementById('pFormRetail')?.value || '900';
    document.querySelectorAll('.var-mrp').forEach(input => input.value = basePrice);
    document.querySelectorAll('.var-retail').forEach(input => input.value = baseSale);
    if (typeof window.showToast === 'function') {
        window.showToast('✨ Prices synced across all variants!');
    }
}

function bulkApplyStock() {
    document.querySelectorAll('.var-stock').forEach(input => input.value = '15');
    if (typeof window.showToast === 'function') {
        window.showToast('✨ Stock set to 15 across all variants!');
    }
}

function deleteVariantRow(id) {
    const row = document.getElementById(id);
    if (row) {
        row.remove();
        updateVariantRowCount();
        if (typeof window.showToast === 'function') {
            window.showToast('Variant removed');
        }
    }
}
</script>
