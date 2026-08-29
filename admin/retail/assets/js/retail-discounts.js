/**
 * retail-discounts.js — DT Brand's & Jai Hanuman Tex
 * Retail Promo Code Creator & Toggle Engine
 */

(function () {
    'use strict';

    window.openCreateDiscountModal = function () {
        window.openRetailModal('dtCreateDiscountModal');
    };

    window.submitCreateDiscount = function (event) {
        if (event) event.preventDefault();
        const code = document.getElementById('newDiscountCode')?.value;
        const val = document.getElementById('newDiscountVal')?.value;

        window.closeRetailModal('dtCreateDiscountModal');
        window.showToast(`🎉 Created promo code "${code}" (${val}% OFF)!`);
    };

    window.toggleDiscountStatus = function (code, currentStatus) {
        const next = currentStatus === 'Active' ? 'Deactivated' : 'Active';
        window.showToast(`Coupon ${code} is now ${next}!`);
    };

})();
