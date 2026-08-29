/**
 * wholesale-price-list.js & wholesale-tiers.js & wholesale-moq.js
 */

(function () {
    'use strict';

    // Price Lists
    window.openCreatePriceListModal = function () {
        window.openWholesaleModal('dtCreatePriceListModal');
    };

    window.submitCreatePriceList = function (event) {
        if (event) event.preventDefault();
        const name = document.getElementById('newPriceListName')?.value || 'Custom Catalog';
        window.closeWholesaleModal('dtCreatePriceListModal');
        window.showToast(`✅ Price List "${name}" created and assigned to Platinum Tier!`);
    };

    // Tiers
    window.openEditTierModal = function (tierName, discount, minGmv, moq) {
        document.getElementById('editTierNameDisplay').innerText = tierName;
        document.getElementById('editTierDiscountInput').value = discount;
        document.getElementById('editTierGmvInput').value = minGmv;
        document.getElementById('editTierMoqInput').value = moq;
        window.openWholesaleModal('dtEditTierModal');
    };

    window.submitEditTier = function (event) {
        if (event) event.preventDefault();
        const tierName = document.getElementById('editTierNameDisplay').innerText;
        window.closeWholesaleModal('dtEditTierModal');
        window.showToast(`✅ Wholesale Tier "${tierName}" criteria updated!`);
    };

    // MOQ
    window.openEditMoqModal = function (ruleName, currentMoq, currentMov) {
        document.getElementById('editMoqRuleName').innerText = ruleName;
        document.getElementById('editMoqQtyInput').value = currentMoq;
        document.getElementById('editMoqMovInput').value = currentMov;
        window.openWholesaleModal('dtEditMoqModal');
    };

    window.submitEditMoq = function (event) {
        if (event) event.preventDefault();
        const name = document.getElementById('editMoqRuleName').innerText;
        window.closeWholesaleModal('dtEditMoqModal');
        window.showToast(`✅ MOQ Rule "${name}" updated!`);
    };

})();
