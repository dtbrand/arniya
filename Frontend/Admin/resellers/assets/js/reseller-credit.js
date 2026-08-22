/**
 * reseller-credit.js — Credit Limit, Ledger Adjustment & Wallet Management
 */

(function () {
    'use strict';

    window.openCreditAdjustmentModal = function (resellerId, currentLimit, currentBalance) {
        const idEl = document.getElementById('dtCreditResellerId');
        const limitEl = document.getElementById('dtCreditCurrentLimit');
        const balEl = document.getElementById('dtCreditCurrentBalance');

        if (idEl) idEl.innerText = resellerId || 'RES-1024';
        if (limitEl) limitEl.innerText = `₹${Number(currentLimit || 50000).toLocaleString()}`;
        if (balEl) balEl.innerText = `₹${Number(currentBalance || 35000).toLocaleString()}`;

        window.openModal('dtCreditAdjustmentModal');
    };

    window.submitCreditAdjustment = function (e) {
        if (e) e.preventDefault();
        const type = document.getElementById('dtCreditAdjustType')?.value || 'increase';
        const amount = document.getElementById('dtCreditAdjustAmount')?.value || '0';
        const reason = document.getElementById('dtCreditAdjustReason')?.value || 'Staff Memo';

        window.closeModal('dtCreditAdjustmentModal');
        window.showToast(`✓ Credit ${type === 'increase' ? 'Increased' : 'Decreased'} by ₹${Number(amount).toLocaleString()} (${reason})`);
    };

})();
