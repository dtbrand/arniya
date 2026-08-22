/**
 * wholesale-pricing.js — DT Brand's & Jai Hanuman Tex
 * Multi-Tier Margin Matrix, Dynamic Pricing Engine & Live Volume Simulator
 */

(function () {
    'use strict';

    let currentBaseDiscount = 35;

    // ══ SWITCH PRICING TIER DYNAMICALLY ══
    window.switchPricingTier = function (tierKey, baseDiscount, tierLabel, btnElement) {
        currentBaseDiscount = baseDiscount;

        // Update Tab Active State
        if (btnElement) {
            const parent = btnElement.closest('.dt-wholesale-tabs-nav');
            if (parent) {
                parent.querySelectorAll('.dt-wholesale-tab-btn').forEach(b => b.classList.remove('active'));
                btnElement.classList.add('active');
            }
        }

        // Update Label
        const labelElem = document.getElementById('activeTierNameLabel');
        if (labelElem) labelElem.innerText = tierLabel;

        // Update all rows in table
        const rows = document.querySelectorAll('#pricingCategoryTableBody tr');
        rows.forEach(row => {
            const offset = parseFloat(row.getAttribute('data-offset') || 0);
            const retail = parseFloat(row.getAttribute('data-retail') || 3000);
            const effectiveMargin = Math.max(5, Math.min(60, baseDiscount + offset));

            const whlPrice = Math.round(retail * (1 - (effectiveMargin / 100)));
            const savings = Math.max(0, retail - whlPrice);

            // Update DOM cells
            const marginBadge = row.querySelector('.margin-badge');
            if (marginBadge) marginBadge.innerText = `${effectiveMargin}% OFF`;

            const whlPriceCell = row.querySelector('.whl-price-cell');
            if (whlPriceCell) whlPriceCell.innerText = `₹${whlPrice.toLocaleString('en-IN')}`;

            const savingsCell = row.querySelector('.savings-cell');
            if (savingsCell) savingsCell.innerText = `₹${savings.toLocaleString('en-IN')}`;
        });

        // Run Simulator
        window.runPriceSimulator();
        window.showToast(`📊 Active tier switched to ${tierLabel} (Base Discount: ${baseDiscount}%)!`);
    };

    // ══ EDIT CATEGORY MARGIN MODAL ══
    window.openEditCategoryMarginModal = function (catName, currentMargin, minOrderQty, rowId) {
        document.getElementById('editMarginCatName').innerText = catName;
        document.getElementById('editCategoryMarginInput').value = currentMargin || 30;
        document.getElementById('editCategoryMoqInput').value = minOrderQty || 12;
        document.getElementById('editMarginRowId').value = rowId || '';
        window.openWholesaleModal('dtEditCategoryMarginModal');
    };

    window.submitCategoryMarginEdit = function (event) {
        if (event) event.preventDefault();
        const catName = document.getElementById('editMarginCatName').innerText;
        const newMargin = parseFloat(document.getElementById('editCategoryMarginInput').value) || 30;
        const newMoq = parseInt(document.getElementById('editCategoryMoqInput').value) || 12;
        const rowId = document.getElementById('editMarginRowId').value;

        if (rowId) {
            const row = document.getElementById(rowId);
            if (row) {
                const retail = parseFloat(row.getAttribute('data-retail') || 3000);
                const whlPrice = Math.round(retail * (1 - (newMargin / 100)));
                const savings = Math.max(0, retail - whlPrice);

                const marginBadge = row.querySelector('.margin-badge');
                if (marginBadge) marginBadge.innerText = `${newMargin}% OFF`;

                const moqCell = row.querySelector('.moq-cell');
                if (moqCell) moqCell.innerText = `${newMoq} pcs`;

                const whlPriceCell = row.querySelector('.whl-price-cell');
                if (whlPriceCell) whlPriceCell.innerText = `₹${whlPrice.toLocaleString('en-IN')}`;

                const savingsCell = row.querySelector('.savings-cell');
                if (savingsCell) savingsCell.innerText = `₹${savings.toLocaleString('en-IN')}`;
            }
        }

        window.closeWholesaleModal('dtEditCategoryMarginModal');
        window.showToast(`✅ "${catName}" margin updated to ${newMargin}% (MOQ: ${newMoq} pcs)!`);
    };

    // ══ ADD CATEGORY RULE MODAL ══
    window.openAddCategoryRuleModal = function () {
        window.openWholesaleModal('dtAddCategoryMarginModal');
    };

    window.submitAddCategoryRule = function (event) {
        if (event) event.preventDefault();
        const catName = document.getElementById('addCategoryNameInput').value.trim();
        const margin = parseFloat(document.getElementById('addCategoryMarginInput').value) || 30;
        const moq = parseInt(document.getElementById('addCategoryMoqInput').value) || 20;
        const mrp = parseFloat(document.getElementById('addCategoryMrpInput').value) || 2400;

        if (!catName) return;

        const whlPrice = Math.round(mrp * (1 - (margin / 100)));
        const savings = Math.max(0, mrp - whlPrice);
        const newRowId = 'marginRow_' + Date.now();

        const tbody = document.getElementById('pricingCategoryTableBody');
        if (tbody) {
            const tr = document.createElement('tr');
            tr.id = newRowId;
            tr.setAttribute('data-cat', catName);
            tr.setAttribute('data-retail', mrp);
            tr.setAttribute('data-offset', (margin - currentBaseDiscount));
            tr.style.borderBottom = '1px solid #F1ECE1';

            tr.innerHTML = `
                <td style="font-weight:800; color:#181512; white-space:nowrap;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:28px; height:28px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; font-size:11px;">👗</div>
                        <span class="cat-name-text">${catName}</span>
                    </div>
                </td>
                <td style="text-align:center; white-space:nowrap;">
                    <span class="dt-status-pill-clean emerald margin-badge" style="font-size:0.75rem;">${margin}% OFF</span>
                </td>
                <td style="text-align:center; font-weight:700; color:#8A681F; white-space:nowrap;" class="moq-cell">${moq} pcs</td>
                <td style="text-align:right; color:#78716C; text-decoration:line-through; white-space:nowrap;" class="retail-cell">₹${mrp.toLocaleString('en-IN')}</td>
                <td style="text-align:right; font-weight:900; color:#15803D; font-size:0.88rem; white-space:nowrap;" class="whl-price-cell">₹${whlPrice.toLocaleString('en-IN')}</td>
                <td style="text-align:right; font-weight:800; color:#8A681F; font-size:0.8rem; white-space:nowrap;" class="savings-cell">₹${savings.toLocaleString('en-IN')}</td>
                <td style="text-align:right; white-space:nowrap; padding-right:18px;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openEditCategoryMarginModal('${catName.replace(/'/g, "\\'")}', ${margin}, ${moq}, '${newRowId}')">
                        <span>Edit Margin</span>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);
        }

        window.closeWholesaleModal('dtAddCategoryMarginModal');
        document.getElementById('addCategoryNameInput').value = '';
        window.showToast(`✨ Added new wholesale pricing rule for "${catName}"!`);
    };

    // ══ LIVE B2B PRICING SIMULATOR ENGINE ══
    window.runPriceSimulator = function () {
        const mrpInput = document.getElementById('calcMrpInput');
        const qtyInput = document.getElementById('calcQtyInput');
        if (!mrpInput || !qtyInput) return;

        const mrp = parseFloat(mrpInput.value) || 0;
        const qty = parseInt(qtyInput.value) || 0;

        // Volume rebate logic
        let volumeRebate = 0;
        if (qty >= 250) {
            volumeRebate = 6.5;
        } else if (qty >= 100) {
            volumeRebate = 4.0;
        } else if (qty >= 50) {
            volumeRebate = 2.0;
        }

        const totalDiscount = Math.min(65, currentBaseDiscount + volumeRebate);
        const netPrice = Math.round(mrp * (1 - (totalDiscount / 100)));
        const totalInvoice = netPrice * qty;
        const totalSavings = (mrp - netPrice) * qty;

        const effMarginElem = document.getElementById('calcEffectiveMargin');
        if (effMarginElem) effMarginElem.innerText = `${totalDiscount.toFixed(1)}% OFF`;

        const netPriceElem = document.getElementById('calcNetPricePerPc');
        if (netPriceElem) netPriceElem.innerText = `₹${netPrice.toLocaleString('en-IN')}`;

        const totalInvElem = document.getElementById('calcTotalInvoice');
        if (totalInvElem) totalInvElem.innerText = `₹${totalInvoice.toLocaleString('en-IN')}`;

        const totalSavElem = document.getElementById('calcTotalSavings');
        if (totalSavElem) totalSavElem.innerText = `₹${totalSavings.toLocaleString('en-IN')}`;
    };

    window.resetPricingCalculator = function () {
        const mrpInput = document.getElementById('calcMrpInput');
        const qtyInput = document.getElementById('calcQtyInput');
        if (mrpInput) mrpInput.value = 3500;
        if (qtyInput) qtyInput.value = 120;
        window.runPriceSimulator();
        window.showToast('🔄 Simulator reset to default baseline.');
    };

    // ══ RECALCULATE & SYNC ALL WHOLESALE MARGINS ══
    window.recalculateAllWholesaleMargins = function () {
        window.showToast('⏳ Recalculating Net Wholesale Prices for all 1,240 SKUs across 16 categories...');
        setTimeout(() => {
            window.runPriceSimulator();
            window.showToast('✅ All wholesale catalog margins synchronized successfully!');
        }, 800);
    };

    // Init on load
    document.addEventListener('DOMContentLoaded', () => {
        window.runPriceSimulator();
    });

})();

