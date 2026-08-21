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

            const st = order.status || currentStatus;
            const badgeEl = document.getElementById('modalCurrentStatusBadge');
            const badgeTextEl = document.getElementById('modalCurrentStatusBadgeText');
            if (badgeEl) {
                badgeEl.className = `dt-status-badge ${st}`;
            }
            if (badgeTextEl) {
                badgeTextEl.textContent = st.replace(/_/g, ' ').toUpperCase();
            } else if (badgeEl) {
                badgeEl.innerHTML = `<span class="dt-status-dot"></span><span>${st.replace(/_/g, ' ').toUpperCase()}</span>`;
            }

            const newStatusEl = document.getElementById('modalNewStatus');
            if (newStatusEl) newStatusEl.value = st;

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
                window.DT_ORDERS.showToast(`Selected preset: ${status.replace('_', ' ').toUpperCase()}`);
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
                window.DT_ORDERS.showToast(`Generated AWB Number: ${awb}`);
            }
        },

        confirmStatusUpdate: function() {
            const orderId = document.getElementById('modalOrderIdText')?.textContent || 'DTB-001624';
            const newStatus = document.getElementById('modalNewStatus')?.value || 'shipped';
            const carrier = document.getElementById('modalCarrierSelect')?.value || 'VRL Logistics Depot';
            const tracking = document.getElementById('modalTrackingInput')?.value || 'VRL-99821';
            const notifyWA = document.getElementById('modalNotifyWhatsApp')?.checked;

            // Update badge in table row or view page header
            const allBadges = document.querySelectorAll(`#statusBadge_${orderId}, #viewPageStatusBadge, .dt-status-badge[data-order-id="${orderId}"]`);
            allBadges.forEach(b => {
                b.className = `dt-status-badge ${newStatus}`;
                b.innerHTML = `<span class="dt-status-dot"></span><span>${newStatus.replace(/_/g, ' ')}</span>`;
            });

            // Update Stepper Progression Timeline if on view.php
            const statusOrderMap = {'pending': 1, 'confirmed': 2, 'processing': 3, 'packed': 4, 'shipped': 5, 'out_for_delivery': 5, 'delivered': 6};
            const targetRank = statusOrderMap[newStatus] || 1;
            const stepNodes = document.querySelectorAll('.dt-status-stepper .dt-step-node');
            stepNodes.forEach((node, idx) => {
                const nodeRank = idx + 1;
                node.classList.remove('completed', 'current');
                if (targetRank > nodeRank) {
                    node.classList.add('completed');
                    const iconEl = node.querySelector('.dt-step-icon');
                    if (iconEl) iconEl.innerHTML = '<svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#FFFFFF" stroke-width="3" style="margin:auto;"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                } else if (targetRank === nodeRank) {
                    node.classList.add('current');
                    const iconEl = node.querySelector('.dt-step-icon');
                    if (iconEl) iconEl.textContent = nodeRank;
                } else {
                    const iconEl = node.querySelector('.dt-step-icon');
                    if (iconEl) iconEl.textContent = nodeRank;
                }
            });

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
                const waMsg = notifyWA ? ' (WhatsApp alert dispatched to consignee)' : '';
                window.DT_ORDERS.showToast(`Order ${orderId} updated to ${newStatus.toUpperCase()}${waMsg}`);
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
                window.DT_ORDERS.showToast(`Order ${orderId} cancelled (${reason})`);
            }
        }
    };
})();

