/**
 * order-status.js — Status Transitions, Workflow Validation & Update Modal
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    window.DT_ORDER_STATUS = {
        openStatusModal: function(orderId, currentStatus) {
            const modal = document.getElementById('updateStatusModal');
            if (!modal) return;

            document.getElementById('modalOrderIdText').textContent = orderId || 'DTB-001624';
            document.getElementById('modalCurrentStatus').value = currentStatus || 'pending';
            document.getElementById('modalNewStatus').value = currentStatus || 'processing';

            modal.style.display = 'flex';
        },

        closeStatusModal: function() {
            const modal = document.getElementById('updateStatusModal');
            if (modal) modal.style.display = 'none';
        },

        confirmStatusUpdate: function() {
            const orderId = document.getElementById('modalOrderIdText').textContent;
            const newStatus = document.getElementById('modalNewStatus').value;
            const reason = document.getElementById('modalStatusReason')?.value || '';

            // Update badge in UI if present
            const badge = document.getElementById(`statusBadge_${orderId}`);
            if (badge) {
                badge.className = `dt-status-badge ${newStatus}`;
                badge.innerHTML = `<span class="dt-status-dot"></span><span>${newStatus.replace('_', ' ')}</span>`;
            }

            this.closeStatusModal();
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`✅ Order ${orderId} status updated to ${newStatus.toUpperCase()}`);
            }
        },

        openCancelModal: function(orderId) {
            const modal = document.getElementById('cancelOrderModal');
            if (modal) {
                document.getElementById('cancelModalOrderIdText').textContent = orderId || 'DTB-001624';
                modal.style.display = 'flex';
            }
        },

        closeCancelModal: function() {
            const modal = document.getElementById('cancelOrderModal');
            if (modal) modal.style.display = 'none';
        },

        confirmCancelOrder: function() {
            const orderId = document.getElementById('cancelModalOrderIdText').textContent;
            const reason = document.getElementById('cancelReasonSelect')?.value || 'Customer Request';

            const badge = document.getElementById(`statusBadge_${orderId}`);
            if (badge) {
                badge.className = 'dt-status-badge cancelled';
                badge.innerHTML = `<span class="dt-status-dot"></span><span>Cancelled</span>`;
            }

            this.closeCancelModal();
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`🛑 Order ${orderId} cancelled (${reason})`);
            }
        }
    };
})();
