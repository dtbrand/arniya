/**
 * reseller-pricing.js — Tiered Pricing & Discount Margin Calculator
 */

(function () {
    'use strict';

    window.assignResellerTier = function (tierName, discountPct) {
        if (confirm(`Assign Tier "${tierName}" (${discountPct}% discount) to this reseller?`)) {
            window.showToast(`✓ Reseller tier updated to ${tierName} (${discountPct}% off catalog)`);
        }
    };

    window.saveCustomPricingRule = function (e) {
        if (e) e.preventDefault();
        window.showToast('✓ Custom SKU margin override saved successfully!');
    };

})();
