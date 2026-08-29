/**
 * wholesale-moq.js & wholesale-discounts.js
 */

(function () {
    'use strict';

    window.openCreateDiscountModal = function () {
        window.openWholesaleModal('dtCreateDiscountModal');
    };

    window.submitCreateDiscount = function (event) {
        if (event) event.preventDefault();
        const name = document.getElementById('newDiscountName')?.value || 'Bulk Booster';
        window.closeWholesaleModal('dtCreateDiscountModal');
        window.showToast(`✅ Wholesale Discount Rule "${name}" created!`);
    };

})();
