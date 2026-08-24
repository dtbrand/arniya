/**
 * reseller-pricing.js — DT Brand's & Jai Hanuman Tex
 * Tiered Pricing Matrix, Dynamic Tier Switching, Category Margin Editor, SKU Overrides & Live Search
 */

(function () {
    'use strict';

    let pendingTierSwitch = null;
    let editingSkuRow = null;

    // ── Tab Switcher ──
    window.switchPricingTab = function (tabId, btn) {
        document.querySelectorAll('.dt-pricing-tab-pane').forEach((pane) => {
            pane.style.display = 'none';
        });
        document.querySelectorAll('.dt-pricing-tab-btn').forEach((b) => {
            b.classList.remove('active');
        });

        const activePane = document.getElementById(tabId);
        if (activePane) activePane.style.display = 'block';
        if (btn) btn.classList.add('active');
    };

    // ── Switch Tier Confirmation & Dynamic Execution ──
    window.openSwitchTierConfirmation = function (tierId, tierName, discountPct) {
        pendingTierSwitch = { id: tierId, name: tierName, discount: discountPct };

        const modal = document.getElementById('dtSwitchTierModal');
        if (modal) {
            document.getElementById('switchTargetTierName').innerText = tierName;
            document.getElementById('switchTargetTierDisc').innerText = `${discountPct}% OFF MRP`;
            modal.style.display = 'flex';
        } else {
            window.executeTierSwitch();
        }
    };

    window.executeTierSwitch = function () {
        if (!pendingTierSwitch) return;

        const targetCard = document.getElementById(pendingTierSwitch.id);
        if (!targetCard) return;

        // Reset all tier cards to inactive
        document.querySelectorAll('.dt-tier-card').forEach((card) => {
            card.classList.remove('current');
            const ind = card.querySelector('.tier-current-indicator');
            if (ind) ind.innerHTML = '';

            const actionSlot = card.querySelector('.tier-action-slot');
            const cardName = card.querySelector('.tier-name-label') ? card.querySelector('.tier-name-label').innerText : 'Tier';
            const cardId = card.id;
            const discVal = card.querySelector('.tier-disc-val') ? card.querySelector('.tier-disc-val').innerText.replace(/[^0-9]/g, '') : '20';

            if (actionSlot) {
                actionSlot.innerHTML = `
                    <button type="button" class="dt-btn dt-btn-pale tier-btn-switch" style="width:100%;" onclick="openSwitchTierConfirmation('${cardId}', '${cardName}', '${discVal}')">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        <span>Switch to ${cardName}</span>
                    </button>
                `;
            }
        });

        // Set target card as active
        targetCard.classList.add('current');
        const targetInd = targetCard.querySelector('.tier-current-indicator');
        if (targetInd) {
            targetInd.innerHTML = `
                <span class="dt-doc-status-badge" style="background:#DCFCE7; color:#15803D; border-color:#86EFAC; font-size:0.7rem;">
                    ✓ CURRENT TIER
                </span>
            `;
        }

        const targetSlot = targetCard.querySelector('.tier-action-slot');
        if (targetSlot) {
            targetSlot.innerHTML = `
                <button type="button" class="dt-btn dt-btn-dark tier-btn-switch" style="width:100%; font-weight:800;" disabled>
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#FAF5E8" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Active Tier Assigned</span>
                </button>
            `;
        }

        // Auto-recalculate category margins to match new tier
        window.recalculateAllCategoryMargins(pendingTierSwitch.discount);

        window.closePricingModal('dtSwitchTierModal');
        window.showToast(`✅ Reseller successfully upgraded to "${pendingTierSwitch.name}" (${pendingTierSwitch.discount}% OFF MRP)!`);
    };

    // ── Edit Tier Parameters Modal ──
    window.openEditTierModal = function (tierId, name, disc, moq, mov, credit) {
        document.getElementById('editTierId').value = tierId;
        document.getElementById('editTierName').value = name;
        document.getElementById('editTierDisc').value = disc;
        document.getElementById('editTierMoq').value = moq;
        document.getElementById('editTierMov').value = mov;
        document.getElementById('editTierCredit').value = credit;

        const modal = document.getElementById('dtEditTierModal');
        if (modal) modal.style.display = 'flex';
    };

    window.saveTierConfig = function (event) {
        if (event) event.preventDefault();

        const tierId = document.getElementById('editTierId').value;
        const disc = document.getElementById('editTierDisc').value;
        const moq = document.getElementById('editTierMoq').value;
        const mov = document.getElementById('editTierMov').value;
        const credit = document.getElementById('editTierCredit').value;

        const card = document.getElementById(tierId);
        if (card) {
            const discEl = card.querySelector('.tier-disc-val');
            const moqEl = card.querySelector('.tier-moq-val');
            const movEl = card.querySelector('.tier-mov-val');
            const creditEl = card.querySelector('.tier-credit-val');

            if (discEl) discEl.innerText = `${disc}%`;
            if (moqEl) moqEl.innerText = moq;
            if (movEl) movEl.innerText = mov;
            if (creditEl) creditEl.innerText = credit;
        }

        window.closePricingModal('dtEditTierModal');
        window.showToast('✓ Tier rules and margin parameters updated successfully!');
    };

    // ── Category Margin Modal & Live Calculation ──
    window.openEditCategoryMarginModal = function (rowId, catName, baseMrp, marginPct, minLot, ruleStatus) {
        document.getElementById('editCatRowId').value = rowId;
        document.getElementById('editCatName').value = catName;
        document.getElementById('editCatBaseMrp').value = baseMrp;
        document.getElementById('editCatMargin').value = marginPct;
        document.getElementById('editCatMinLot').value = minLot;
        document.getElementById('editCatRuleType').value = ruleStatus.includes('Special') || ruleStatus.includes('Custom') ? 'Special' : 'Default';

        updateLiveNetPriceCalc();

        const modal = document.getElementById('dtEditCategoryMarginModal');
        if (modal) modal.style.display = 'flex';
    };

    window.updateLiveNetPriceCalc = function () {
        const baseMrp = parseFloat(document.getElementById('editCatBaseMrp').value) || 0;
        const marginPct = parseFloat(document.getElementById('editCatMargin').value) || 0;

        const net = Math.round(baseMrp * (1 - (marginPct / 100)));
        const netFormatted = '₹' + net.toLocaleString('en-IN');

        const displayEl = document.getElementById('editCatNetPriceDisplay');
        if (displayEl) {
            displayEl.innerText = netFormatted;
        }
    };

    window.saveCategoryMargin = function (event) {
        if (event) event.preventDefault();

        const rowId = document.getElementById('editCatRowId').value;
        const marginPct = parseFloat(document.getElementById('editCatMargin').value) || 30;
        const minLot = document.getElementById('editCatMinLot').value;
        const ruleType = document.getElementById('editCatRuleType').value;
        const baseMrp = parseFloat(document.getElementById('editCatBaseMrp').value) || 4500;

        const net = Math.round(baseMrp * (1 - (marginPct / 100)));
        const netFormatted = '₹' + net.toLocaleString('en-IN');

        const row = document.getElementById(rowId);
        if (row) {
            row.setAttribute('data-margin', marginPct);
            const rateCell = row.querySelector('.cat-rate-cell');
            const marginCell = row.querySelector('.cat-margin-cell');
            const minLotCell = row.querySelector('.cat-minlot-cell');
            const statusCell = row.querySelector('.cat-status-cell');

            if (rateCell) rateCell.innerText = netFormatted;
            if (marginCell) {
                marginCell.innerHTML = `<span class="dt-reseller-badge gold" style="font-size:0.72rem; font-weight:800;">${marginPct}% OFF</span>`;
            }
            if (minLotCell) minLotCell.innerText = minLot;
            if (statusCell) {
                if (ruleType === 'Special') {
                    statusCell.innerHTML = `<span class="dt-reseller-badge gold" style="font-size:0.7rem; font-weight:800;">★ Special Boost</span>`;
                } else {
                    statusCell.innerHTML = `<span class="dt-reseller-badge emerald" style="font-size:0.7rem; font-weight:800;">✓ Active Tier Rule</span>`;
                }
            }
        }

        const catName = document.getElementById('editCatName').value;
        window.closePricingModal('dtEditCategoryMarginModal');
        window.showToast(`✅ Updated margin for "${catName}": ${marginPct}% OFF (Net: ${netFormatted})`);
    };

    // ── Recalculate All Category Margins ──
    window.recalculateAllCategoryMargins = function (customDisc) {
        let activeDiscount = 30;
        if (customDisc) {
            activeDiscount = parseFloat(customDisc);
        } else {
            const activeCard = document.querySelector('.dt-tier-card.current .tier-disc-val');
            if (activeCard) {
                activeDiscount = parseFloat(activeCard.innerText.replace(/[^0-9]/g, '')) || 30;
            }
        }

        const rows = document.querySelectorAll('#categoryMarginTbody tr');
        rows.forEach((row) => {
            const mrp = parseFloat(row.getAttribute('data-mrp')) || 4500;
            const net = Math.round(mrp * (1 - (activeDiscount / 100)));
            const netFormatted = '₹' + net.toLocaleString('en-IN');

            const rateCell = row.querySelector('.cat-rate-cell');
            const marginCell = row.querySelector('.cat-margin-cell');
            if (rateCell) rateCell.innerText = netFormatted;
            if (marginCell) {
                marginCell.innerHTML = `<span class="dt-reseller-badge gold" style="font-size:0.72rem; font-weight:800;">${activeDiscount}% OFF</span>`;
            }
        });

        window.showToast(`✓ All category wholesale prices updated for ${activeDiscount}% Active Tier discount!`);
    };

    // ── Live SKU Overrides Search Filter ──
    window.filterSkuOverrides = function (query) {
        const q = (query || '').toLowerCase().trim();
        const rows = document.querySelectorAll('#skuOverrideTbody .sku-row-item');

        rows.forEach((row) => {
            const code = (row.querySelector('.sku-code-cell') ? row.querySelector('.sku-code-cell').innerText : '').toLowerCase();
            const name = (row.querySelector('.sku-name-cell') ? row.querySelector('.sku-name-cell').innerText : '').toLowerCase();
            const rule = (row.querySelector('.sku-rule-cell') ? row.querySelector('.sku-rule-cell').innerText : '').toLowerCase();

            if (!q || code.includes(q) || name.includes(q) || rule.includes(q)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    };

    // ── Add / Edit SKU Override Modal & Logic ──
    window.openAddSkuOverrideModal = function () {
        editingSkuRow = null;
        document.getElementById('skuModalTitle').innerText = 'Add SKU-Specific Price Override';
        document.getElementById('skuCodeInput').value = '';
        document.getElementById('skuCodeInput').readOnly = false;
        document.getElementById('skuNameInput').value = '';
        document.getElementById('skuMrpInput').value = '';
        document.getElementById('skuSpecialRateInput').value = '';
        document.getElementById('skuMoqInput').value = '';
        document.getElementById('skuRuleInput').value = '';

        const modal = document.getElementById('dtAddSkuModal');
        if (modal) modal.style.display = 'flex';
    };

    window.openEditSkuModal = function (btn, sku, name, mrp, rate, moq, rule) {
        editingSkuRow = btn ? btn.closest('tr') : null;
        document.getElementById('skuModalTitle').innerText = `Edit Override: ${sku}`;
        document.getElementById('skuCodeInput').value = sku;
        document.getElementById('skuCodeInput').readOnly = true;
        document.getElementById('skuNameInput').value = name;
        document.getElementById('skuMrpInput').value = mrp;
        document.getElementById('skuSpecialRateInput').value = rate;
        document.getElementById('skuMoqInput').value = moq;
        document.getElementById('skuRuleInput').value = rule;

        const modal = document.getElementById('dtAddSkuModal');
        if (modal) modal.style.display = 'flex';
    };

    window.saveNewSkuOverride = function (event) {
        if (event) event.preventDefault();

        const sku = document.getElementById('skuCodeInput').value.trim();
        const name = document.getElementById('skuNameInput').value.trim();
        const mrp = document.getElementById('skuMrpInput').value.trim();
        const rate = document.getElementById('skuSpecialRateInput').value.trim();
        const moq = document.getElementById('skuMoqInput').value.trim();
        const rule = document.getElementById('skuRuleInput').value.trim();

        if (!sku || !name || !rate) {
            window.showToast('⚠️ Please provide SKU, Product Name, and Special Rate.');
            return;
        }

        if (editingSkuRow) {
            // Update existing row
            const nameCell = editingSkuRow.querySelector('.sku-name-cell span:last-child');
            const mrpCell = editingSkuRow.querySelector('.sku-mrp-cell');
            const rateCell = editingSkuRow.querySelector('.sku-rate-cell');
            const moqCell = editingSkuRow.querySelector('.sku-moq-cell');
            const ruleCell = editingSkuRow.querySelector('.sku-rule-cell span');

            if (nameCell) nameCell.innerText = name;
            if (mrpCell) mrpCell.innerText = mrp;
            if (rateCell) rateCell.innerText = rate;
            if (moqCell) moqCell.innerText = moq;
            if (ruleCell) ruleCell.innerText = rule || 'Custom Deal';

            window.showToast(`✅ Special SKU pricing for "${sku}" updated!`);
        } else {
            // Add new row
            const tbody = document.getElementById('skuOverrideTbody');
            if (tbody) {
                const tr = document.createElement('tr');
                tr.className = 'sku-row-item';
                tr.style.borderBottom = '1px solid #F3EFE6';
                tr.innerHTML = `
                    <td class="sku-code-cell" style="padding:12px 14px; font-family:monospace; font-weight:800; color:#8A681F;">${sku}</td>
                    <td class="sku-name-cell" style="padding:12px 14px; font-weight:700; color:#181512;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:28px; height:28px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; font-size:0.68rem; font-weight:900;">
                                SKU
                            </div>
                            <span>${name}</span>
                        </div>
                    </td>
                    <td class="sku-mrp-cell" style="padding:12px 14px; color:#78716C; text-decoration:line-through;">${mrp || '₹4,000'}</td>
                    <td class="sku-rate-cell" style="padding:12px 14px; color:#15803D; font-weight:900; font-size:0.88rem;">${rate}</td>
                    <td class="sku-moq-cell" style="padding:12px 14px; font-weight:700; color:#181512;">${moq || '6 Pcs'}</td>
                    <td class="sku-rule-cell" style="padding:12px 14px;">
                        <span class="dt-reseller-badge gold" style="font-size:0.7rem; font-weight:800;">${rule || 'Custom Deal'}</span>
                    </td>
                    <td style="padding:12px 14px; text-align:right;">
                        <div style="display:inline-flex; align-items:center; gap:6px;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openEditSkuModal(this, '${sku}', '${name.replace(/'/g, "\\'")}', '${mrp}', '${rate}', '${moq}', '${rule.replace(/'/g, "\\'")}')">
                                <span>Edit</span>
                            </button>
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626; border-color:#FECACA;" onclick="removeSkuOverride(this, '${sku}')">
                                <span>Remove</span>
                            </button>
                        </div>
                    </td>
                `;
                tbody.prepend(tr);
            }
            window.showToast(`✅ Special SKU pricing rule for "${sku}" added!`);
        }

        window.closePricingModal('dtAddSkuModal');
    };

    window.removeSkuOverride = function (btn, sku) {
        if (btn && btn.closest('tr')) {
            btn.closest('tr').remove();
            window.showToast(`✓ SKU override rule for "${sku}" removed`);
        }
    };

    // ── Close Modals Helper ──
    window.closePricingModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = 'none';
    };

})();
