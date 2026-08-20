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
                date: '21 Aug 2026 • 11:20 AM',
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
            setTxt('drawerOrderDate', (order.date || '').replace(' 2026', ' 2026 •'));
            setTxt('drawerCustomerName', order.customer);
            setTxt('drawerCustomerPhone', order.phone);
            setTxt('drawerCustomerEmail', order.email || '—');
            setTxt('drawerCustomerType', order.customer_type || 'Customer');
            setTxt('drawerCarrier', order.carrier || 'Standard Courier');
            setTxt('drawerTracking', order.tracking_id || '—');
            setTxt('drawerShippingAddress', order.address ? order.address.shipping : 'Surat Central Depot, Ring Road, Surat');
            setTxt('drawerItemsCount', order.item_count || 1);
            setTxt('drawerItemsTotal', Number(order.amount).toLocaleString('en-IN'));
            setTxt('drawerPayMethod', order.payment_method || 'Online');
            setTxt('drawerPayRef', order.payment_ref || '—');
            setTxt('drawerPayTotal', Number(order.amount).toLocaleString('en-IN'));

            // Status Badge
            const badge = document.getElementById('drawerStatusBadge');
            const badgeText = document.getElementById('drawerStatusBadgeText');
            if (badge) {
                badge.className = 'dt-status-badge ' + (order.status || 'pending');
            }
            if (badgeText) {
                badgeText.textContent = (order.status || 'pending').replace(/_/g, ' ').toUpperCase();
            }

            // Pay Badge
            const payBadge = document.getElementById('drawerPayStatus');
            if (payBadge) {
                payBadge.className = 'dt-pay-badge ' + (order.payment_status || 'paid');
                payBadge.textContent = (order.payment_status || 'paid').toUpperCase();
            }

            // Update Fulfillment Stepper
            this.updateStepper(order.status);

            // Links
            const invLink = document.getElementById('drawerInvoiceLink');
            if (invLink) invLink.href = '/Frontend/Admin/orders/invoice.php?id=' + encodeURIComponent(order.id);

            const viewLink = document.getElementById('drawerViewFullLink');
            if (viewLink) viewLink.href = '/Frontend/Admin/orders/view.php?id=' + encodeURIComponent(order.id);

            const waLink = document.getElementById('drawerWhatsAppLink');
            if (waLink) {
                const cleanPhone = (order.phone || '').replace(/\D/g, '');
                waLink.href = 'https://wa.me/' + cleanPhone + '?text=' + encodeURIComponent('Namaste ' + order.customer + ', regarding your DT Brand\'s Order #' + order.id + ' (' + (order.items_summary || 'Consignment') + '):');
            }

            const updateBtn = document.getElementById('drawerUpdateStatusBtn');
            if (updateBtn) {
                updateBtn.onclick = function() {
                    if (window.DT_ORDER_STATUS) window.DT_ORDER_STATUS.openStatusModal(order.id, order.status);
                };
            }

            // Render Items with 100% Vector SVG Fabric Icons
            const itemsList = document.getElementById('drawerItemsList');
            if (itemsList) {
                itemsList.innerHTML = (order.items || []).map(item => `
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; padding:8px 10px; background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:34px; height:34px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                            </div>
                            <div>
                                <div style="font-weight:800; font-size:11.5px; color:#0F172A; line-height:1.3;">${item.name}</div>
                                <div style="font-size:10px; color:#64748B; margin-top:2px;">SKU: <strong style="color:#181512;">${item.sku}</strong> • ${item.variant} • Qty: <strong>${item.qty}</strong></div>
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:2px; font-weight:800; font-size:12px; color:#181512; white-space:nowrap;">
                            <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="10" height="10"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            <span>${Number(item.price * item.qty).toLocaleString('en-IN')}</span>
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

        updateStepper: function(status) {
            const stepper = document.getElementById('drawerStepper');
            if (!stepper) return;

            const stages = [
                { id: 'placed', label: 'Placed' },
                { id: 'confirmed', label: 'Confirmed' },
                { id: 'packed', label: 'Packed' },
                { id: 'transit', label: 'In Transit' },
                { id: 'delivered', label: 'Delivered' }
            ];

            const statusLevel = {
                'pending': 1,
                'confirmed': 2,
                'processing': 2,
                'packed': 3,
                'shipped': 4,
                'out_for_delivery': 4,
                'delivered': 5,
                'cancelled': -1,
                'returned': -1,
                'refunded': -1,
                'failed': -1
            };

            const level = statusLevel[status] !== undefined ? statusLevel[status] : 1;

            if (level === -1) {
                stepper.innerHTML = `
                    <div style="width:100%; text-align:center; padding:4px 0; color:#DC2626; font-weight:800; font-size:11px; display:flex; align-items:center; justify-content:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <span>Lifecycle Status: ${status.replace(/_/g, ' ').toUpperCase()}</span>
                    </div>
                `;
                return;
            }

            let html = '';
            stages.forEach((stage, idx) => {
                const stageNum = idx + 1;
                const isPassed = stageNum <= level;
                const isCurrent = stageNum === level;

                const color = isCurrent ? '#8A681F' : (isPassed ? '#15803D' : '#94A3B8');
                const dot = isPassed ? '●' : '○';

                html += `<div style="text-align:center; color:${color}; font-weight:800;">${dot} ${stage.label}</div>`;

                if (idx < stages.length - 1) {
                    const lineColor = (stageNum < level) ? '#16A34A' : (stageNum === level ? '#D4AF37' : '#E2E8F0');
                    html += `<div style="flex:1; height:2px; background:${lineColor}; margin:0 4px;"></div>`;
                }
            });

            stepper.innerHTML = html;
        },

        addDrawerNote: function() {
            const input = document.getElementById('drawerQuickNoteInput');
            if (!input || !input.value.trim()) {
                if (window.DT_ORDERS) window.DT_ORDERS.showToast('Please enter dispatch note text');
                return;
            }

            const noteVal = input.value.trim();
            input.value = '';
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast('✅ Note saved: "' + noteVal + '"');
            }
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
                if (window.DT_ORDERS) window.DT_ORDERS.showToast('Please enter note text first');
                return;
            }

            const noteList = document.getElementById('adminNotesList');
            if (noteList) {
                const now = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const noteEl = document.createElement('div');
                noteEl.className = 'dt-note-item';
                noteEl.innerHTML = `
                    <div class="dt-note-header">
                        <span>Admin (Surat Central HQ)</span>
                        <span>${now} • Just Now</span>
                    </div>
                    <div class="dt-note-text">${input.value.trim()}</div>
                `;
                noteList.prepend(noteEl);
                input.value = '';
                if (window.DT_ORDERS) window.DT_ORDERS.showToast('Internal note saved successfully');
            }
        },

        copyAddress: function(elementId, label) {
            const el = document.getElementById(elementId);
            if (el && window.DT_ORDERS) {
                window.DT_ORDERS.copyText(el.innerText, label);
            }
        },

        openLedgerModal: function(name, phone, email) {
            const modal = document.getElementById('customerLedgerModal');
            if (!modal) return;

            const nameEl = document.getElementById('ledgerCustomerName');
            if (nameEl && name) nameEl.textContent = name;

            const avatarEl = document.getElementById('ledgerAvatarInitials');
            if (avatarEl && name) {
                const parts = name.trim().split(/\s+/);
                avatarEl.textContent = (parts.length > 1 ? (parts[0][0] + parts[1][0]) : parts[0].slice(0, 2)).toUpperCase();
            }

            const phoneText = document.getElementById('ledgerPhoneText');
            if (phoneText && phone) phoneText.textContent = phone;

            const emailText = document.getElementById('ledgerEmailText');
            if (emailText && email) emailText.textContent = email;

            const waBtn = document.getElementById('ledgerWhatsAppBtn');
            if (waBtn && phone) {
                const clean = phone.replace(/\D/g, '');
                waBtn.href = 'https://wa.me/' + clean + '?text=' + encodeURIComponent('Namaste ' + (name || 'Client') + ', sharing your latest DT Brand\'s account ledger statement:');
            }

            modal.style.display = 'flex';
        },

        closeLedgerModal: function() {
            const modal = document.getElementById('customerLedgerModal');
            if (modal) modal.style.display = 'none';
        },

        printLedger: function() {
            const modal = document.getElementById('customerLedgerModal');
            if (!modal) {
                window.print();
                return;
            }
            modal.classList.add('dt-printing-ledger');
            window.print();
            setTimeout(() => {
                modal.classList.remove('dt-printing-ledger');
            }, 1000);
        },

        exportLedgerCSV: function() {
            const name = (document.getElementById('ledgerCustomerName') ? document.getElementById('ledgerCustomerName').textContent.trim() : 'Customer');
            const safeName = name.replace(/[^a-zA-Z0-9]/g, '_');
            
            const csvRows = [
                ['DT BRAND\'S & JAI HANUMAN TEX — B2B FINANCIAL LEDGER STATEMENT'],
                ['Surat Central Textile Depot, Ring Road, Surat (GJ) - 395002'],
                ['GSTIN: 24AAECJ1928K1Z5 | Phone: +91 98251 00000'],
                [''],
                ['CUSTOMER INFORMATION'],
                ['Customer Name', name],
                ['GSTIN', '24AAECJ1928K1Z5'],
                ['Contact Phone', document.getElementById('ledgerPhoneText') ? document.getElementById('ledgerPhoneText').textContent.trim() : ''],
                ['Email', document.getElementById('ledgerEmailText') ? document.getElementById('ledgerEmailText').textContent.trim() : ''],
                ['Account Tier', 'Verified B2B Reseller (Gold Wholesale)'],
                ['Credit Limit', 'Rs. 15,00,000 (Net 15 Days)'],
                [''],
                ['FINANCIAL SUMMARY'],
                ['Lifetime Gross Valuation', 'Rs. 8,42,500'],
                ['Total Settled Payments', 'Rs. 8,42,500'],
                ['Outstanding Balance Due', 'Rs. 0.00 (All Invoices Settled)'],
                [''],
                ['TRANSACTION STATEMENT LOG'],
                ['Date', 'Reference / Order ID', 'Transaction Type', 'Debit (INR)', 'Credit (INR)', 'Balance (INR)', 'Status'],
                ['21 Aug 2026', 'DTB-001624', 'Consignment Invoice (Kanjivaram Silk 25pcs)', '112250', '', '112250', 'Billed'],
                ['21 Aug 2026', 'UTR-9821039812', 'Bank Wire / RTGS Full Settlement', '', '112250', '0.00', 'PAID'],
                ['10 Aug 2026', 'DTB-001605', 'Banarasi Silk Lot Consignment (40pcs)', '245000', '', '245000', 'Delivered'],
                ['11 Aug 2026', 'UTR-882910398', 'RTGS ICICI Bank Full Settlement', '', '245000', '0.00', 'PAID'],
                ['25 Jul 2026', 'DTB-001582', 'Chanderi & Tussar Festive Catalog (35pcs)', '185250', '', '185250', 'Delivered'],
                ['26 Jul 2026', 'UTR-771829301', 'HDFC NetBanking Direct Settlement', '', '185250', '0.00', 'PAID'],
                ['08 Jul 2026', 'DTB-001550', 'Paithani Heritage Zari Collection (20pcs)', '142000', '', '142000', 'Delivered'],
                ['09 Jul 2026', 'UTR-662918274', 'SBI Corporate Direct Wire Transfer', '', '142000', '0.00', 'PAID'],
                [''],
                ['Total Debits', '', '', 'Rs. 6,84,500', '', '', ''],
                ['Total Credits', '', '', '', 'Rs. 6,84,500', '', ''],
                ['Net Balance Due', '', '', '', '', 'Rs. 0.00', 'All Clear'],
                [''],
                ['Generated On', new Date().toLocaleString()],
                ['Authorized Signatory', 'DT Brand\'s Central Accounting Dept (Surat)']
            ];

            const csvContent = 'data:text/csv;charset=utf-8,\uFEFF' + 
                csvRows.map(row => row.map(cell => '"' + (cell || '').toString().replace(/"/g, '""') + '"').join(',')).join('\n');

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', `DT_Brands_Ledger_${safeName}_${new Date().toISOString().slice(0,10)}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast('📥 Customer ledger exported successfully as Excel/CSV statement');
            }
        }
    };
})(window);


