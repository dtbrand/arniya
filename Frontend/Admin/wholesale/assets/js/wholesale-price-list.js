/**
 * wholesale-price-list.js
 */

(function () {
    'use strict';

    window.openCreatePriceListModal = function () {
        window.openWholesaleModal('dtCreatePriceListModal');
    };

    window.submitCreatePriceList = function (event) {
        if (event) event.preventDefault();
        const name = document.getElementById('newPriceListName')?.value || 'Custom Catalog';
        window.closeWholesaleModal('dtCreatePriceListModal');
        window.showToast(`✅ Price List "${name}" created successfully!`);
    };

})();
