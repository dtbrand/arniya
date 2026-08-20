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

            document.getElementById('refundOrderIdText').textContent = orderId || 'DTB-001624';
            document.getElementById('refundMaxAmountDisplay').textContent = '₹' + (maxAmount || '4,990');
            document.getElementById('refundAmountInput').value = maxAmount || '4990';

            drawer.classList.add('open');
        },

        closeRefundDrawer: function() {
            const drawer = document.getElementById('refundDrawer');
            if (drawer) drawer.classList.remove('open');
        },

        confirmRefund: function() {
            const orderId = document.getElementById('refundOrderIdText').textContent;
            const amount = document.getElementById('refundAmountInput').value;
            const method = document.getElementById('refundMethodSelect')?.value || 'Original Payment Method';

            this.closeRefundDrawer();
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`💸 Refund of ₹${amount} initiated via ${method} for ${orderId}`);
            }
        }
    };
})();
