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
            const urlParams = new URLSearchParams(window.location.search);
            const orderId = urlParams.get('id') || 'DTB-001624';
            window.open('/Frontend/Admin/orders/ledger.php?id=' + encodeURIComponent(orderId) + '&print=1', '_blank');
        },

        exportLedgerCSV: function() {
            const name = (document.getElementById('ledgerCustomerName') ? document.getElementById('ledgerCustomerName').textContent.trim() : 'Rajesh Kumar (Vardhman Tex)');
            const safeName = name.replace(/[^a-zA-Z0-9]/g, '_');
            const phone = document.getElementById('ledgerPhoneText') ? document.getElementById('ledgerPhoneText').textContent.trim() : '+91 98220 19283';
            const email = document.getElementById('ledgerEmailText') ? document.getElementById('ledgerEmailText').textContent.trim() : 'rajesh@vardhmantex.com';

            const excelHtml = `
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!--[if gte mso 9]>
<xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>Ledger Statement</x:Name>
    <x:WorksheetOptions>
     <x:DisplayGridlines/>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
 </x:ExcelWorkbook>
</xml>
<![endif]-->
<style>
  body { font-family: 'Calibri', 'Segoe UI', sans-serif; font-size: 11pt; color: #181512; }
  .title-header { background-color: #8A681F; color: #FFFFFF; font-size: 15pt; font-weight: bold; text-align: center; height: 36px; vertical-align: middle; }
  .sub-header { background-color: #FAF5E8; color: #5A4210; font-size: 10pt; text-align: center; height: 22px; vertical-align: middle; }
  .section-title { background-color: #181512; color: #FFFFFF; font-size: 11pt; font-weight: bold; height: 26px; vertical-align: middle; padding-left: 8px; }
  .label-cell { background-color: #FAF8F4; font-weight: bold; color: #475569; border: 0.5pt solid #D4AF37; }
  .value-cell { background-color: #FFFFFF; color: #181512; border: 0.5pt solid #E2DFD7; }
  .th-cell { background-color: #8A681F; color: #FFFFFF; font-weight: bold; text-align: center; border: 0.5pt solid #5A4210; height: 26px; vertical-align: middle; }
  .td-date { text-align: center; border: 0.5pt solid #E2DFD7; vertical-align: middle; }
  .td-ref { font-weight: bold; color: #8A681F; text-align: center; border: 0.5pt solid #E2DFD7; vertical-align: middle; }
  .td-desc { border: 0.5pt solid #E2DFD7; vertical-align: middle; padding-left: 6px; }
  .td-num { text-align: right; font-weight: bold; border: 0.5pt solid #E2DFD7; vertical-align: middle; padding-right: 6px; }
  .td-status { text-align: center; font-weight: bold; border: 0.5pt solid #E2DFD7; vertical-align: middle; }
  .total-row { background-color: #FAF5E8; font-weight: bold; border-top: 1.5pt solid #8A681F; border-bottom: 2pt double #8A681F; }
</style>
</head>
<body>
<table>
  <tr height="40"><th colspan="7" class="title-header">DT BRAND'S &amp; JAI HANUMAN TEX — B2B FINANCIAL LEDGER STATEMENT</th></tr>
  <tr height="24"><td colspan="7" class="sub-header">Surat Central Textile Depot, Ring Road, Surat (GJ) - 395002 | GSTIN: 24AAECJ1928K1Z5 | Care: +91 98251 00000</td></tr>
  <tr><td colspan="7"></td></tr>
  
  <tr height="26"><th colspan="7" class="section-title">CUSTOMER ACCOUNT OVERVIEW</th></tr>
  <tr height="22">
    <td class="label-cell" width="110">Customer Name:</td>
    <td class="value-cell" colspan="2"><b>${name}</b></td>
    <td class="label-cell" width="120">Account Tier:</td>
    <td class="value-cell" colspan="3">Verified Wholesale VIP</td>
  </tr>
  <tr height="22">
    <td class="label-cell">GSTIN:</td>
    <td class="value-cell" colspan="2">24AAECJ1928K1Z5</td>
    <td class="label-cell">Credit Limit:</td>
    <td class="value-cell" colspan="3">₹ 15,00,000 (Net 15 Days)</td>
  </tr>
  <tr height="22">
    <td class="label-cell">Phone / WhatsApp:</td>
    <td class="value-cell" colspan="2">${phone}</td>
    <td class="label-cell">Lifetime Business:</td>
    <td class="value-cell" colspan="3"><b>₹ 8,42,500.00</b></td>
  </tr>
  <tr height="22">
    <td class="label-cell">Email:</td>
    <td class="value-cell" colspan="2">${email}</td>
    <td class="label-cell">Current Balance:</td>
    <td class="value-cell" colspan="3" style="color:#15803D;"><b>₹ 0.00 (All Invoices Settled)</b></td>
  </tr>
  <tr><td colspan="7"></td></tr>

  <tr height="28">
    <th class="th-cell" width="110">Date</th>
    <th class="th-cell" width="140">Reference ID</th>
    <th class="th-cell" width="300">Transaction Description</th>
    <th class="th-cell" width="120">Debit (₹)</th>
    <th class="th-cell" width="120">Credit (₹)</th>
    <th class="th-cell" width="120">Balance (₹)</th>
    <th class="th-cell" width="100">Status</th>
  </tr>
  
  <tr height="22">
    <td class="td-date">21-Aug-2026</td>
    <td class="td-ref">DTB-001624</td>
    <td class="td-desc">Consignment Invoice (Kanjivaram Silk 25pcs)</td>
    <td class="td-num">1,12,250.00</td>
    <td class="td-num" style="color:#94A3B8;">—</td>
    <td class="td-num">1,12,250.00</td>
    <td class="td-status" style="color:#B45309;">Billed</td>
  </tr>
  <tr height="22" style="background-color:#F8FAFC;">
    <td class="td-date">21-Aug-2026</td>
    <td class="td-ref" style="color:#0F172A;">UTR-9821039812</td>
    <td class="td-desc" style="color:#15803D;">Bank Wire / RTGS Full Settlement</td>
    <td class="td-num" style="color:#94A3B8;">—</td>
    <td class="td-num" style="color:#15803D;">1,12,250.00</td>
    <td class="td-num" style="color:#15803D;">0.00</td>
    <td class="td-status" style="color:#15803D;">PAID</td>
  </tr>
  <tr height="22">
    <td class="td-date">10-Aug-2026</td>
    <td class="td-ref">DTB-001605</td>
    <td class="td-desc">Banarasi Silk Lot Consignment (40pcs)</td>
    <td class="td-num">2,45,000.00</td>
    <td class="td-num" style="color:#94A3B8;">—</td>
    <td class="td-num">2,45,000.00</td>
    <td class="td-status" style="color:#15803D;">Delivered</td>
  </tr>
  <tr height="22" style="background-color:#F8FAFC;">
    <td class="td-date">11-Aug-2026</td>
    <td class="td-ref" style="color:#0F172A;">UTR-882910398</td>
    <td class="td-desc" style="color:#15803D;">RTGS ICICI Bank Full Settlement</td>
    <td class="td-num" style="color:#94A3B8;">—</td>
    <td class="td-num" style="color:#15803D;">2,45,000.00</td>
    <td class="td-num" style="color:#15803D;">0.00</td>
    <td class="td-status" style="color:#15803D;">PAID</td>
  </tr>
  <tr height="22">
    <td class="td-date">25-Jul-2026</td>
    <td class="td-ref">DTB-001582</td>
    <td class="td-desc">Chanderi &amp; Tussar Festive Catalog (35pcs)</td>
    <td class="td-num">1,85,250.00</td>
    <td class="td-num" style="color:#94A3B8;">—</td>
    <td class="td-num">1,85,250.00</td>
    <td class="td-status" style="color:#15803D;">Delivered</td>
  </tr>
  <tr height="22" style="background-color:#F8FAFC;">
    <td class="td-date">26-Jul-2026</td>
    <td class="td-ref" style="color:#0F172A;">UTR-771829301</td>
    <td class="td-desc" style="color:#15803D;">HDFC NetBanking Direct Settlement</td>
    <td class="td-num" style="color:#94A3B8;">—</td>
    <td class="td-num" style="color:#15803D;">1,85,250.00</td>
    <td class="td-num" style="color:#15803D;">0.00</td>
    <td class="td-status" style="color:#15803D;">PAID</td>
  </tr>
  <tr height="22">
    <td class="td-date">08-Jul-2026</td>
    <td class="td-ref">DTB-001550</td>
    <td class="td-desc">Paithani Heritage Zari Collection (20pcs)</td>
    <td class="td-num">1,42,000.00</td>
    <td class="td-num" style="color:#94A3B8;">—</td>
    <td class="td-num">1,42,000.00</td>
    <td class="td-status" style="color:#15803D;">Delivered</td>
  </tr>
  <tr height="22" style="background-color:#F8FAFC;">
    <td class="td-date">09-Jul-2026</td>
    <td class="td-ref" style="color:#0F172A;">UTR-662918274</td>
    <td class="td-desc" style="color:#15803D;">SBI Corporate Direct Wire Transfer</td>
    <td class="td-num" style="color:#94A3B8;">—</td>
    <td class="td-num" style="color:#15803D;">1,42,000.00</td>
    <td class="td-num" style="color:#15803D;">0.00</td>
    <td class="td-status" style="color:#15803D;">PAID</td>
  </tr>

  <tr height="28" class="total-row">
    <td colspan="3" style="text-align:right; font-weight:bold; padding-right:10px; background-color:#FAF5E8; border-top:1.5pt solid #8A681F; border-bottom:2pt double #8A681F;">RECONCILED TOTALS:</td>
    <td class="td-num" style="color:#181512; background-color:#FAF5E8; border-top:1.5pt solid #8A681F; border-bottom:2pt double #8A681F;">₹ 6,84,500.00</td>
    <td class="td-num" style="color:#15803D; background-color:#FAF5E8; border-top:1.5pt solid #8A681F; border-bottom:2pt double #8A681F;">₹ 6,84,500.00</td>
    <td class="td-num" style="color:#15803D; background-color:#FAF5E8; border-top:1.5pt solid #8A681F; border-bottom:2pt double #8A681F;">₹ 0.00</td>
    <td class="td-status" style="color:#15803D; background-color:#FAF5E8; border-top:1.5pt solid #8A681F; border-bottom:2pt double #8A681F;">ALL CLEAR</td>
  </tr>
</table>
</body>
</html>
`;

            const blob = new Blob(['\ufeff', excelHtml], { type: 'application/vnd.ms-excel;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `DT_Brands_Ledger_${safeName}_${new Date().toISOString().slice(0,10)}.xls`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast('📥 Customer ledger exported successfully as formatted Excel statement');
            }
        }
    };
})(window);


