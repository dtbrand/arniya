/**
 * retail-pricing.js — DT Brand's & Jai Hanuman Tex
 * Retail MRP & Selling Price Quick Edit Engine
 */

(function () {
    'use strict';

    window.openEditRetailPriceModal = function (sku, name, mrp, retailPrice) {
        const skuEl = document.getElementById('editPriceSku');
        const nameEl = document.getElementById('editPriceName');
        const mrpEl = document.getElementById('editPriceMrp');
        const retEl = document.getElementById('editPriceRetail');

        if (skuEl) skuEl.value = sku;
        if (nameEl) nameEl.value = name;
        if (mrpEl) mrpEl.value = mrp;
        if (retEl) retEl.value = retailPrice;

        window.openRetailModal('dtEditRetailPriceModal');
    };

    window.submitEditRetailPrice = function (event) {
        if (event) event.preventDefault();
        const sku = document.getElementById('editPriceSku')?.value;
        const retailPrice = document.getElementById('editPriceRetail')?.value;

        window.closeRetailModal('dtEditRetailPriceModal');
        window.showToast(`✅ Updated ${sku} Retail Price to ₹${Number(retailPrice).toLocaleString('en-IN')}!`);
    };

})();
