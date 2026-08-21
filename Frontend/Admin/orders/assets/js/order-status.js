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

            orderId = orderId || 'DTB-001624';
            currentStatus = currentStatus || 'pending';

            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                status: currentStatus,
                shipping: 'VRL Logistics Depot',
                tracking: 'VRL-99821'
            };

            const orderIdEl = document.getElementById('modalOrderIdText');
            if (orderIdEl) orderIdEl.textContent = order.id;

            const badgeEl = document.getElementById('modalCurrentStatusBadge');
            if (badgeEl) {
                badgeEl.textContent = (order.status || currentStatus).replace('_', ' ').toUpperCase();
                badgeEl.className = `dt-status-badge ${order.status || currentStatus}`;
            }

            const newStatusEl = document.getElementById('modalNewStatus');
            if (newStatusEl) newStatusEl.value = order.status || currentStatus;

            const carrierEl = document.getElementById('modalCarrierSelect');
            if (carrierEl && order.shipping) carrierEl.value = order.shipping;

            const trackingEl = document.getElementById('modalTrackingInput');
            if (trackingEl) trackingEl.value = order.tracking || `VRL-${Math.floor(10000 + Math.random() * 90000)}`;

            modal.style.display = 'flex';
        },

        closeStatusModal: function() {
            const modal = document.getElementById('updateStatusModal');
            if (modal) modal.style.display = 'none';
        },

        selectPreset: function(status, reason) {
            const newStatusEl = document.getElementById('modalNewStatus');
            if (newStatusEl) newStatusEl.value = status;

            const reasonEl = document.getElementById('modalStatusReason');
            if (reasonEl) reasonEl.value = reason;

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`🎯 Selected preset: ${status.replace('_', ' ').toUpperCase()}`);
            }
        },

        autoGenerateAWB: function() {
            const carrier = document.getElementById('modalCarrierSelect')?.value || 'VRL';
            let prefix = 'VRL';
            if (carrier.includes('BlueDart')) prefix = 'BLU';
            else if (carrier.includes('Delhivery')) prefix = 'DEL';
            else if (carrier.includes('TCI')) prefix = 'TCI';
            else if (carrier.includes('DTDC')) prefix = 'DTC';
            else if (carrier.includes('Safexpress')) prefix = 'SFX';

            const num = Math.floor(100000 + Math.random() * 900000);
            const awb = `${prefix}-${num}`;
            const trackingEl = document.getElementById('modalTrackingInput');
            if (trackingEl) trackingEl.value = awb;

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`⚡ Generated AWB: ${awb}`);
            }
        },

        confirmStatusUpdate: function() {
            const orderId = document.getElementById('modalOrderIdText')?.textContent || 'DTB-001624';
            const newStatus = document.getElementById('modalNewStatus')?.value || 'shipped';
            const carrier = document.getElementById('modalCarrierSelect')?.value || 'VRL Logistics Depot';
            const tracking = document.getElementById('modalTrackingInput')?.value || 'VRL-99821';
            const notifyWA = document.getElementById('modalNotifyWhatsApp')?.checked;

            // Update badge in table row if present
            const badge = document.getElementById(`statusBadge_${orderId}`);
            if (badge) {
                badge.className = `dt-status-badge ${newStatus}`;
                badge.innerHTML = `<span class="dt-status-dot"></span><span>${newStatus.replace('_', ' ')}</span>`;
            }

            // Synchronize in-memory order object
            if (window.DT_ORDERS && window.DT_ORDERS.orders) {
                const targetOrder = window.DT_ORDERS.orders.find(o => o.id === orderId);
                if (targetOrder) {
                    targetOrder.status = newStatus;
                    targetOrder.shipping = carrier;
                    targetOrder.tracking = tracking;
                }
            }

            this.closeStatusModal();

            if (window.DT_ORDERS) {
                const waMsg = notifyWA ? ' • 💬 Customer WhatsApp alert dispatched' : '';
                window.DT_ORDERS.showToast(`✅ Order ${orderId} updated to ${newStatus.toUpperCase()}${waMsg}`);
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

            if (window.DT_ORDERS && window.DT_ORDERS.orders) {
                const targetOrder = window.DT_ORDERS.orders.find(o => o.id === orderId);
                if (targetOrder) targetOrder.status = 'cancelled';
            }

            this.closeCancelModal();
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`🛑 Order ${orderId} cancelled (${reason})`);
            }
        }
    };
})();

