/**
 * refunds.js — Refund Calculation Drawer & Gateway Verification
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    window.DT_REFUNDS = {
        openRefundDrawer: function(orderId, maxAmount) {
            const drawer = document.getElementById('refundDrawer');
            if (!drawer) return;

            const orderIdEl = document.getElementById('refundOrderIdText');
            if (orderIdEl) orderIdEl.textContent = orderId || 'DTB-001624';

            const maxDisplay = document.getElementById('refundMaxAmountDisplay');
            if (maxDisplay) maxDisplay.textContent = '₹' + Number(maxAmount || 112250).toLocaleString('en-IN');

            const amountInput = document.getElementById('refundAmountInput');
            if (amountInput) amountInput.value = maxAmount || 112250;

            drawer.style.display = 'flex';
        },

        closeRefundDrawer: function() {
            const drawer = document.getElementById('refundDrawer');
            if (drawer) drawer.style.display = 'none';
        },

        confirmRefund: function() {
            const orderId = document.getElementById('refundOrderIdText')?.textContent || 'DTB-001624';
            const amount = document.getElementById('refundAmountInput')?.value || '112250';
            const method = document.getElementById('refundMethodSelect')?.value || 'Original Payment Gateway';

            this.closeRefundDrawer();
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast('Refund of ₹' + Number(amount).toLocaleString('en-IN') + ' authorized via ' + method + ' for ' + orderId);
            }
        }
    };
})(window);

