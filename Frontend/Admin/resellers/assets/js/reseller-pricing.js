/**
 * reseller-pricing.js — DT Brand's & Jai Hanuman Tex
 * Tiered Pricing Matrix, Dynamic Tier Switching, Rule Customizer & SKU Overrides
 */

(function () {
    'use strict';

    let pendingTierSwitch = null;

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
            // Fallback direct execution
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

    // ── Add SKU Override Modal & Logic ──
    window.openAddSkuOverrideModal = function () {
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

        const tbody = document.getElementById('skuOverrideTbody');
        if (tbody) {
            const tr = document.createElement('tr');
            tr.style.borderBottom = '1px solid #F3EFE6';
            tr.innerHTML = `
                <td style="padding:12px 14px; font-family:monospace; font-weight:800; color:#8A681F;">${sku}</td>
                <td style="padding:12px 14px; font-weight:700; color:#181512;">${name}</td>
                <td style="padding:12px 14px; color:#78716C; text-decoration:line-through;">${mrp || '₹4,000'}</td>
                <td style="padding:12px 14px; color:#15803D; font-weight:900; font-size:0.88rem;">${rate}</td>
                <td style="padding:12px 14px; font-weight:700; color:#181512;">${moq || '6 Pcs'}</td>
                <td style="padding:12px 14px;">
                    <span class="dt-reseller-badge gold" style="font-size:0.7rem; font-weight:800;">${rule || 'Custom Deal'}</span>
                </td>
                <td style="padding:12px 14px; text-align:right;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626; border-color:#FECACA;" onclick="removeSkuOverride(this, '${sku}')">
                        <span>Remove</span>
                    </button>
                </td>
            `;
            tbody.prepend(tr);
        }

        window.closePricingModal('dtAddSkuModal');
        window.showToast(`✅ Special SKU pricing rule for "${sku}" added!`);
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
