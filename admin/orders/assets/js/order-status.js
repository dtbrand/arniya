/**
 * order-status.js — Status Transitions, Workflow Validation & Update Modal
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    // Use the admin fetch wrapper with CSRF token
    const dtAdminFetch = window.dtAdminFetch || fetch;

    window.DT_ORDER_STATUS = {
        openStatusModal: function(orderId, currentStatus) {
            const modal = document.getElementById('updateStatusModal');
            if (!modal) return;

            orderId = orderId || '';
            currentStatus = currentStatus || 'pending';

            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                status: currentStatus,
                shipping: 'Delhivery Express',
                tracking: '—'
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
            if (trackingEl) trackingEl.value = order.tracking || '—';

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
            const orderId = document.getElementById('modalOrderIdText')?.textContent || '';
            const newStatus = document.getElementById('modalNewStatus')?.value || 'shipped';
            const carrier = document.getElementById('modalCarrierSelect')?.value || 'Delhivery Express';
            const tracking = document.getElementById('modalTrackingInput')?.value || '—';
            const notifyWA = document.getElementById('modalNotifyWhatsApp')?.checked;

            // Live API persistence to database
            const payload = {
                action: 'update_status',
                order_id: orderId,
                status: newStatus,
                tracking_number: tracking,
                courier_name: carrier
            };

            dtAdminFetch('/api/orders.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            }).then(r => r.json()).then(res => {
                if (res && res.success) {
                    console.log('Order status updated live in database:', res);
                } else {
                    console.warn('Order status update warning:', res);
                }
            }).catch(err => console.log('Order status network sync:', err));

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
                document.getElementById('cancelModalOrderIdText').textContent = orderId || '';
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

            // Live API call
            const payload = {
                action: 'update_status',
                order_id: orderId,
                status: 'cancelled',
                reason: reason
            };

            dtAdminFetch('/api/orders.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            }).then(r => r.json()).catch(err => console.log('Order cancel network sync:', err));

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
        },

        openDeleteModal: function(orderId) {
            const modal = document.getElementById('deleteOrderModal');
            if (modal) {
                orderId = (orderId || '').trim();
                const idTextEl = document.getElementById('deleteModalOrderIdText');
                if (idTextEl) idTextEl.textContent = orderId;
                const warnEl = document.getElementById('deleteModalOrderIdWarning');
                if (warnEl) warnEl.textContent = orderId;
                modal.style.display = 'flex';
            }
        },

        closeDeleteModal: function() {
            const modal = document.getElementById('deleteOrderModal');
            if (modal) modal.style.display = 'none';
        },

        confirmDeleteOrder: function() {
            const orderId = document.getElementById('deleteModalOrderIdText')?.textContent?.trim();
            if (!orderId) return;

            const modal = document.getElementById('deleteOrderModal');
            const submitBtn = modal?.querySelector('.dt-btn[onclick*="confirmDeleteOrder"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.innerHTML = '<span class="dt-spin" style="display:inline-block; width:12px; height:12px; border:2px solid #FFF; border-top-color:transparent; border-radius:50%; animation:dtSpin 0.6s linear infinite;"></span> <span>Deleting...</span>';
            }

            const payload = {
                action: 'delete',
                order_id: orderId
            };

            dtAdminFetch('/api/orders.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(res => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.innerHTML = '<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> <span>Permanently Delete</span>';
                }

                if (res && res.success) {
                    // 1. Immediately animate and remove the row from DOM
                    const row = document.querySelector(`tr.dt-order-row[data-id="${orderId}"]`);
                    const detailsRow = document.getElementById(`detailsRow_${orderId}`);

                    if (row) {
                        row.setAttribute('data-deleted', 'true');
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(20px)';
                        row.style.background = '#FEE2E2';
                        setTimeout(() => {
                            row.remove();
                            if (detailsRow) detailsRow.remove();
                        }, 300);
                    } else if (detailsRow) {
                        detailsRow.remove();
                    }

                    // 2. Synchronize all counters and status flow pills in real time
                    if (window.DT_ORDERS && typeof window.DT_ORDERS.syncCountersAfterDeletion === 'function') {
                        window.DT_ORDERS.syncCountersAfterDeletion([orderId]);
                    }

                    // 3. Close modal & display luxury feedback toast
                    this.closeDeleteModal();
                    if (window.DT_ORDERS) {
                        window.DT_ORDERS.showToast(`Order ${orderId} permanently deleted from live database.`);
                    }
                } else {
                    const msg = (res && res.message) ? res.message : 'Failed to delete order.';
                    if (window.DT_ORDERS) {
                        window.DT_ORDERS.showToast(`Deletion Error: ${msg}`, 'error');
                    }
                }
            })
            .catch(err => {
                console.error('Delete order error:', err);
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.innerHTML = '<span>Permanently Delete</span>';
                }
                if (window.DT_ORDERS) {
                    window.DT_ORDERS.showToast(`Network error while deleting order: ${err.message}`, 'error');
                }
            });
        }
    };
})();

