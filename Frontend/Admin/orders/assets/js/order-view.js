/**
 * order-view.js — Single Order Details, Quick View Drawer, Address Copy & Admin Notes
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    window.DT_ORDER_VIEW = {
        openDrawer: function(orderId) {
            const drawer = document.getElementById('orderQuickViewDrawer');
            if (!drawer) {
                window.location.href = '/Frontend/Admin/orders/view.php?id=' + encodeURIComponent(orderId);
                return;
            }

            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                customer: 'Valued Client',
                customer_type: 'Wholesale B2B',
                phone: '+91 98000 00000',
                email: 'client@dtbrands.in',
                date: '21 Aug 2026, 11:20 AM',
                items: [{ name: 'Surat Handloom Silk Lot', sku: 'LOT-101', variant: 'Standard', qty: 10, price: 3490, img: '' }],
                item_count: 10,
                amount: 34900,
                payment_method: 'Bank Wire / RTGS',
                payment_status: 'paid',
                payment_ref: 'UTR-' + Date.now().toString().slice(-8),
                carrier: 'VRL Logistics',
                tracking_id: 'VRL-' + orderId.replace('DTB-', ''),
                status: 'shipped',
                address: {
                    billing: 'Textile Market, Ring Road, Surat, Gujarat - 395002',
                    shipping: 'Godown 12, Transport Nagar, Surat, Gujarat - 395010'
                }
            };

            // Populate Drawer fields
            const setTxt = (id, txt) => { const el = document.getElementById(id); if (el) el.textContent = txt; };
            setTxt('drawerOrderId', order.id);
            setTxt('drawerOrderDate', order.date);
            setTxt('drawerCustomerName', order.customer);
            setTxt('drawerCustomerPhone', order.phone);
            setTxt('drawerCustomerEmail', order.email || '—');
            setTxt('drawerCustomerType', order.customer_type || 'Customer');
            setTxt('drawerCarrier', order.carrier || 'Standard Courier');
            setTxt('drawerTracking', order.tracking_id || '—');
            setTxt('drawerShippingAddress', order.address ? order.address.shipping : 'Surat Central Depot, Gujarat');
            setTxt('drawerItemsCount', order.item_count || 1);
            setTxt('drawerItemsTotal', '₹' + Number(order.amount).toLocaleString('en-IN'));
            setTxt('drawerPayMethod', order.payment_method || 'Online');
            setTxt('drawerPayRef', order.payment_ref || '—');
            setTxt('drawerPayTotal', '₹' + Number(order.amount).toLocaleString('en-IN'));

            // Status Badge
            const badge = document.getElementById('drawerStatusBadge');
            if (badge) {
                badge.className = 'dt-status-badge ' + (order.status || 'pending');
                badge.textContent = (order.status || 'pending').replace('_', ' ');
            }

            // Pay Badge
            const payBadge = document.getElementById('drawerPayStatus');
            if (payBadge) {
                payBadge.className = 'dt-pay-badge ' + (order.payment_status || 'paid');
                payBadge.textContent = (order.payment_status || 'paid').toUpperCase();
            }

            // Links
            const invLink = document.getElementById('drawerInvoiceLink');
            if (invLink) invLink.href = '/Frontend/Admin/orders/invoice.php?id=' + encodeURIComponent(order.id);

            const viewLink = document.getElementById('drawerViewFullLink');
            if (viewLink) viewLink.href = '/Frontend/Admin/orders/view.php?id=' + encodeURIComponent(order.id);

            const waLink = document.getElementById('drawerWhatsAppLink');
            if (waLink) {
                const cleanPhone = (order.phone || '').replace(/\D/g, '');
                waLink.href = 'https://wa.me/' + cleanPhone + '?text=' + encodeURIComponent('Hello ' + order.customer + ', regarding your DT Brand\'s Order #' + order.id + ':');
            }

            const updateBtn = document.getElementById('drawerUpdateStatusBtn');
            if (updateBtn) {
                updateBtn.onclick = function() {
                    if (window.DT_ORDER_STATUS) window.DT_ORDER_STATUS.openStatusModal(order.id, order.status);
                };
            }

            // Render Items
            const itemsList = document.getElementById('drawerItemsList');
            if (itemsList) {
                itemsList.innerHTML = (order.items || []).map(item => `
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; padding:8px 0; border-bottom:1px dashed #F1EFE9;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; font-weight:800; color:#8A681F; font-size:11px;">
                                👘
                            </div>
                            <div>
                                <div style="font-weight:700; font-size:11.5px; color:#0F172A;">${item.name}</div>
                                <div style="font-size:10px; color:#64748B;">SKU: ${item.sku} • ${item.variant} • Qty: ${item.qty}</div>
                            </div>
                        </div>
                        <div style="font-weight:800; font-size:11.5px; color:#181512; white-space:nowrap;">
                            ₹${Number(item.price * item.qty).toLocaleString('en-IN')}
                        </div>
                    </div>
                `).join('');
            }

            drawer.style.display = 'flex';
        },

        closeDrawer: function() {
            const drawer = document.getElementById('orderQuickViewDrawer');
            if (drawer) drawer.style.display = 'none';
        },

        toggleRowDetails: function(orderId, btn) {
            const row = document.getElementById('detailsRow_' + orderId);
            if (!row) return;

            const isHidden = row.style.display === 'none';
            row.style.display = isHidden ? 'table-row' : 'none';
            if (btn) {
                btn.style.transform = isHidden ? 'rotate(90deg)' : 'rotate(0deg)';
                btn.style.color = isHidden ? '#8A681F' : '#64748B';
            }
        },

        addNote: function() {
            const input = document.getElementById('newAdminNoteInput');
            if (!input || !input.value.trim()) {
                if (window.DT_ORDERS) window.DT_ORDERS.showToast('⚠️ Please enter note text first');
                return;
            }

            const noteList = document.getElementById('adminNotesList');
            if (noteList) {
                const now = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const noteEl = document.createElement('div');
                noteEl.className = 'dt-note-item';
                noteEl.innerHTML = `
                    <div class="dt-note-header">
                        <span>👤 Admin (You)</span>
                        <span>${now} • Just Now</span>
                    </div>
                    <div class="dt-note-text">${input.value.trim()}</div>
                `;
                noteList.prepend(noteEl);
                input.value = '';
                if (window.DT_ORDERS) window.DT_ORDERS.showToast('✅ Internal note added successfully');
            }
        },

        copyAddress: function(elementId, label) {
            const el = document.getElementById(elementId);
            if (el && window.DT_ORDERS) {
                window.DT_ORDERS.copyText(el.innerText, label);
            }
        }
    };
})();
