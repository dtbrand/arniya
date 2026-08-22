/**
 * reseller-commission.js — Commission Approval & Payout Settlement
 */

(function () {
    'use strict';

    window.settleCommissionPayout = function (commissionId, amount) {
        if (confirm(`Approve and settle payout of ₹${Number(amount).toLocaleString()} for ${commissionId}?`)) {
            window.showToast(`✓ Commission ${commissionId} (₹${Number(amount).toLocaleString()}) approved for bank settlement`);
        }
    };

})();
