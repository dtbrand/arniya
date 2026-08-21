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

        openAddressEditModal: function(orderId) {
            orderId = orderId || (document.getElementById('editAddressOrderId')?.value) || 'DTB-001620';
            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                customer: document.getElementById('shippingRecipientText')?.textContent.trim() || 'Wholesale Consignee (Surat Depot)',
                phone: document.getElementById('shippingPhoneText')?.textContent.replace('TEL:', '').trim() || '+91 98220 19283',
                gstin: document.getElementById('billingGstinText')?.textContent.replace('GSTIN:', '').trim() || '24AAECJ1928K1Z5',
                address: {
                    shipping: document.getElementById('shippingAddressDisplay')?.textContent.trim() || 'Godown 12, Transport Nagar, Surat, Gujarat - 395010',
                    billing: document.getElementById('billingAddressDisplay')?.textContent.trim() || 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002'
                }
            };

            const orderIdInput = document.getElementById('editAddressOrderId');
            if (orderIdInput) orderIdInput.value = order.id;

            const orderIdText = document.getElementById('editAddressModalOrderIdText');
            if (orderIdText) orderIdText.textContent = order.id;

            // Fill Shipping inputs
            const shipRecipient = document.getElementById('editShippingRecipient');
            if (shipRecipient) shipRecipient.value = order.customer || '';

            const shipPhone = document.getElementById('editShippingPhone');
            if (shipPhone) shipPhone.value = order.phone || '';

            const shipAddr = (order.address && order.address.shipping) ? order.address.shipping : '';
            const shipLine1 = document.getElementById('editShippingLine1');
            if (shipLine1) shipLine1.value = shipAddr.split(',')[0] || 'Godown 12, Sector C, Transport Nagar';

            const shipCity = document.getElementById('editShippingCity');
            if (shipCity) shipCity.value = 'Surat';

            const shipState = document.getElementById('editShippingState');
            if (shipState) shipState.value = 'Gujarat';

            const shipPin = document.getElementById('editShippingPincode');
            if (shipPin) {
                const pinMatch = shipAddr.match(/\b\d{6}\b/);
                shipPin.value = pinMatch ? pinMatch[0] : '395010';
            }

            // Fill Billing inputs
            const billFirm = document.getElementById('editBillingFirm');
            if (billFirm) billFirm.value = document.getElementById('billingFirmText')?.textContent.trim() || order.customer || 'Vardhman Tex Private Limited';

            const billGstin = document.getElementById('editBillingGstin');
            if (billGstin) billGstin.value = order.gstin || '24AAECJ1928K1Z5';

            const billAddr = (order.address && order.address.billing) ? order.address.billing : '';
            const billLine1 = document.getElementById('editBillingLine1');
            if (billLine1) billLine1.value = billAddr.split(',')[0] || 'Shop 42, Ground Floor, Millennium Textile Market';

            const billCity = document.getElementById('editBillingCity');
            if (billCity) billCity.value = 'Surat';

            const billState = document.getElementById('editBillingState');
            if (billState) billState.value = 'Gujarat';

            const billPin = document.getElementById('editBillingPincode');
            if (billPin) {
                const pinMatch = billAddr.match(/\b\d{6}\b/);
                billPin.value = pinMatch ? pinMatch[0] : '395002';
            }

            const sameCheckbox = document.getElementById('sameAsShippingCheckbox');
            if (sameCheckbox) sameCheckbox.checked = false;

            const modal = document.getElementById('orderAddressEditModal');
            if (modal) {
                modal.style.display = 'flex';
                const scrollEl = document.getElementById('orderAddressEditFormScroll');
                if (scrollEl) scrollEl.scrollTop = 0;
            }
        },

        closeAddressEditModal: function() {
            const modal = document.getElementById('orderAddressEditModal');
            if (modal) modal.style.display = 'none';
        },

        copyShippingToBilling: function() {
            const sameCheckbox = document.getElementById('sameAsShippingCheckbox');
            if (!sameCheckbox || !sameCheckbox.checked) return;

            const shipRecipient = document.getElementById('editShippingRecipient')?.value || '';
            const shipLine1 = document.getElementById('editShippingLine1')?.value || '';
            const shipCity = document.getElementById('editShippingCity')?.value || '';
            const shipState = document.getElementById('editShippingState')?.value || '';
            const shipPin = document.getElementById('editShippingPincode')?.value || '';

            const billFirm = document.getElementById('editBillingFirm');
            if (billFirm && shipRecipient) billFirm.value = shipRecipient;

            const billLine1 = document.getElementById('editBillingLine1');
            if (billLine1 && shipLine1) billLine1.value = shipLine1;

            const billCity = document.getElementById('editBillingCity');
            if (billCity && shipCity) billCity.value = shipCity;

            const billState = document.getElementById('editBillingState');
            if (billState && shipState) billState.value = shipState;

            const billPin = document.getElementById('editBillingPincode');
            if (billPin && shipPin) billPin.value = shipPin;
        },

        saveAddressChanges: function(e) {
            if (e && e.preventDefault) e.preventDefault();

            const orderId = document.getElementById('editAddressOrderId')?.value || 'DTB-001620';
            const recipient = document.getElementById('editShippingRecipient')?.value.trim() || 'Wholesale Consignee';
            const phone = document.getElementById('editShippingPhone')?.value.trim() || '+91 98220 19283';
            const shipLine1 = document.getElementById('editShippingLine1')?.value.trim() || '';
            const shipCity = document.getElementById('editShippingCity')?.value.trim() || 'Surat';
            const shipState = document.getElementById('editShippingState')?.value.trim() || 'Gujarat';
            const shipPin = document.getElementById('editShippingPincode')?.value.trim() || '395010';

            const billFirm = document.getElementById('editBillingFirm')?.value.trim() || recipient;
            const billGstin = document.getElementById('editBillingGstin')?.value.trim() || '24AAECJ1928K1Z5';
            const billLine1 = document.getElementById('editBillingLine1')?.value.trim() || '';
            const billCity = document.getElementById('editBillingCity')?.value.trim() || 'Surat';
            const billState = document.getElementById('editBillingState')?.value.trim() || 'Gujarat';
            const billPin = document.getElementById('editBillingPincode')?.value.trim() || '395002';

            const fullShipping = (shipLine1 ? `${shipLine1}, ` : '') + `${shipCity}, ${shipState} - ${shipPin}`;
            const fullBilling = (billLine1 ? `${billLine1}, ` : '') + `${billCity}, ${billState} - ${billPin}`;

            // Update DOM on view.php
            const shipRecEl = document.getElementById('shippingRecipientText');
            if (shipRecEl) shipRecEl.textContent = recipient;

            const shipPhoneEl = document.getElementById('shippingPhoneText');
            if (shipPhoneEl) shipPhoneEl.textContent = `TEL: ${phone}`;

            const shipDispEl = document.getElementById('shippingAddressDisplay');
            if (shipDispEl) shipDispEl.textContent = fullShipping;

            const billFirmEl = document.getElementById('billingFirmText');
            if (billFirmEl) billFirmEl.textContent = billFirm;

            const billGstinEl = document.getElementById('billingGstinText');
            if (billGstinEl) billGstinEl.innerHTML = `GSTIN: <span style="color:#8A681F; font-weight:800; font-family:monospace;">${billGstin}</span>`;

            const billDispEl = document.getElementById('billingAddressDisplay');
            if (billDispEl) billDispEl.textContent = fullBilling;

            // Update drawer if open
            const drawerShipEl = document.getElementById('drawerShippingAddress');
            if (drawerShipEl) drawerShipEl.textContent = fullShipping;

            // Update global order cache in JS
            if (window.DT_ORDERS && window.DT_ORDERS.orders) {
                const targetOrder = window.DT_ORDERS.orders.find(o => o.id === orderId);
                if (targetOrder) {
                    targetOrder.customer = recipient;
                    targetOrder.phone = phone;
                    targetOrder.gstin = billGstin;
                    if (!targetOrder.address) targetOrder.address = {};
                    targetOrder.address.shipping = fullShipping;
                    targetOrder.address.billing = fullBilling;
                }
            }

            this.closeAddressEditModal();

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast('✅ Shipping & Billing addresses updated successfully!');
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
        },

        openInvoiceModal: function(orderId) {
            const modal = document.getElementById('orderInvoiceModal');
            if (!modal) {
                window.location.href = '/Frontend/Admin/orders/invoice.php?id=' + encodeURIComponent(orderId);
                return;
            }

            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                customer: 'Rajesh Kumar',
                firm: 'Vardhman Tex',
                phone: '+91 98220 19283',
                amount: 112250,
                status: 'shipped',
                date: '21 Aug 2026, 11:20 AM',
                payment: 'Bank Wire / RTGS',
                payment_status: 'PAID',
                items: [{ name: 'Kanjivaram Silk Saree Pure Zari Weave', sku: 'KNJ-001', variant: 'Royal Ruby / 5.5m', qty: 25, price: 4490 }]
            };

            const fullPageLink = document.getElementById('invoiceModalFullPageLink');
            if (fullPageLink) fullPageLink.href = '/Frontend/Admin/orders/invoice.php?id=' + encodeURIComponent(order.id);

            const orderIdTitle = document.getElementById('invoiceModalOrderId');
            if (orderIdTitle) orderIdTitle.textContent = order.id;

            const taxable = (Number(order.amount || 112250) / 1.05);
            const cgst = taxable * 0.025;
            const sgst = taxable * 0.025;
            const grandTotal = Number(order.amount || 112250);

            const body = document.getElementById('invoiceModalBody');
            if (body) {
                body.innerHTML = `
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:12px; margin-bottom:14px; padding-right:110px; gap:12px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <img src="/Shared/Asset/images/logo.png" onerror="this.onerror=null; this.src='/Frontend/Shop/Asset/images/logo.png';" style="height:48px; width:auto; display:block; object-fit:contain;">
                            <div>
                                <h2 style="margin:0; font-size:16px; font-weight:800; color:#181512; line-height:1.2;">DT BRAND'S &amp; JAI HANUMAN TEX</h2>
                                <p style="margin:3px 0 0 0; font-size:10.5px; color:#64748B; line-height:1.3;">Surat Central Depot • Ring Road, Surat • GSTIN: 24AAECJ1928K1Z5</p>
                            </div>
                        </div>
                        <div style="text-align:right; flex-shrink:0;">
                            <span style="font-size:10px; font-weight:800; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; padding:2px 6px; border-radius:4px; display:inline-block;">TAX INVOICE</span>
                            <div style="font-size:12px; font-weight:800; color:#181512; margin-top:3px;">INV-${order.id.replace('DTB-', '2026-')}</div>
                            <div style="font-size:10.5px; color:#64748B;">Date: ${order.date || '21 Aug 2026'}</div>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:14px;">
                        <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px;">
                            <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; margin-bottom:4px;">Billed Customer (Consignee)</div>
                            <div style="font-weight:800; font-size:12.5px; color:#181512;">${order.customer}</div>
                            <div style="font-size:11px; color:#475569;">${order.firm || 'Vardhman Tex'}</div>
                            <div style="font-size:11px; color:#475569;">Phone: ${order.phone}</div>
                        </div>
                        <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px;">
                            <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; margin-bottom:4px;">Payment &amp; Clearance Details</div>
                            <div style="font-weight:800; font-size:12px; color:#15803D;">● Settlement: ${order.payment_status || 'PAID & CLEARED'}</div>
                            <div style="font-size:11px; color:#475569;">Mode: ${order.payment || 'Bank Wire / RTGS'}</div>
                            <div style="font-size:11px; color:#475569;">Depot: Surat Central Dock 1</div>
                        </div>
                    </div>

                    <table style="width:100%; border-collapse:collapse; margin-bottom:14px; font-size:11.5px;">
                        <thead>
                            <tr style="background:#181512; color:#FAF5E8;">
                                <th style="padding:6px 8px; text-align:left;">Item &amp; SKU</th>
                                <th style="padding:6px 8px; text-align:center;">Qty</th>
                                <th style="padding:6px 8px; text-align:right;">Rate (₹)</th>
                                <th style="padding:6px 8px; text-align:right;">Taxable (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom:1px solid #E2E8F0;">
                                <td style="padding:8px; display:flex; align-items:center; gap:8px;">
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.onerror=null; this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:36px; height:36px; border-radius:4px; object-fit:cover; border:1px solid #E2DFD7;">
                                    <div>
                                        <strong>Kanjivaram Silk Saree Pure Zari Weave</strong><br>
                                        <small style="color:#64748B;">SKU: KNJ-001 • <span style="display:inline-flex; align-items:center; gap:3px;"><span style="width:6px; height:6px; border-radius:50%; background:#9B111E; display:inline-block;"></span> Royal Ruby / 5.5m</span></small>
                                    </div>
                                </td>
                                <td style="padding:8px; text-align:center; font-weight:800;">${order.items_count || '25 pcs'}</td>
                                <td style="padding:8px; text-align:right;">₹4,490</td>
                                <td style="padding:8px; text-align:right; font-weight:700;">₹${taxable.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="display:flex; justify-content:flex-end;">
                        <div style="width:240px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; padding:10px; font-size:11.5px;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                                <span>Taxable Amount:</span>
                                <strong>₹${taxable.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; margin-bottom:4px; color:#475569;">
                                <span>CGST (2.5%):</span>
                                <span>₹${cgst.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; margin-bottom:6px; color:#475569;">
                                <span>SGST (2.5%):</span>
                                <span>₹${sgst.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; border-top:1.5px solid #8A681F; padding-top:6px; font-size:13px; font-weight:800; color:#181512;">
                                <span>Grand Total:</span>
                                <span style="color:#8A681F;">₹${grandTotal.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</span>
                            </div>
                        </div>
                    </div>
                `;
            }

            modal.style.display = 'flex';
        },

        closeInvoiceModal: function() {
            const modal = document.getElementById('orderInvoiceModal');
            if (modal) modal.style.display = 'none';
        },

        openPackingSlipModal: function(orderId) {
            const modal = document.getElementById('orderPackingSlipModal');
            if (!modal) {
                window.location.href = '/Frontend/Admin/orders/packing-slip.php?id=' + encodeURIComponent(orderId);
                return;
            }

            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                customer: 'Rajesh Kumar',
                firm: 'Vardhman Tex',
                phone: '+91 98220 19283',
                amount: 112250,
                status: 'shipped',
                date: '21 Aug 2026, 11:20 AM',
                shipping: 'VRL Logistics Depot',
                tracking: 'VRL-99821'
            };

            const fullPageLink = document.getElementById('packingModalFullPageLink');
            if (fullPageLink) fullPageLink.href = '/Frontend/Admin/orders/packing-slip.php?id=' + encodeURIComponent(order.id);

            const orderIdTitle = document.getElementById('packingModalOrderId');
            if (orderIdTitle) orderIdTitle.textContent = order.id;

            const body = document.getElementById('packingModalBody');
            if (body) {
                body.innerHTML = `
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:12px; margin-bottom:14px; padding-right:110px; gap:12px;">
                        <div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <h2 style="margin:0; font-size:18px; font-weight:800; color:#181512; letter-spacing:0.02em;">PACKING SLIP</h2>
                                <span style="font-size:9.5px; font-weight:800; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; padding:1px 6px; border-radius:3px;">DEPOT DISPATCH MANIFEST</span>
                            </div>
                            <p style="margin:3px 0 0 0; font-size:11px; color:#64748B;">Surat Central Depot Internal Wholesale Logistics Manifest</p>
                        </div>
                        <div style="text-align:right; flex-shrink:0;">
                            <div style="font-size:13px; font-weight:800; color:#8A681F;">ORDER #${order.id}</div>
                            <div style="font-size:10.5px; color:#64748B;">Manifest Box: <strong>1 of 1</strong></div>
                            <div style="font-size:10.5px; color:#64748B;">Date: ${order.date || '21 Aug 2026'}</div>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:14px;">
                        <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px;">
                            <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; margin-bottom:4px;">1. Billed Customer &amp; Firm</div>
                            <div style="font-weight:800; font-size:13px; color:#181512;">${order.customer}</div>
                            <div style="font-size:11.5px; color:#475569; margin-top:2px;">${order.firm || 'Vardhman Tex'}</div>
                            <div style="margin-top:6px;"><span style="font-size:9.5px; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; padding:1px 5px; border-radius:3px; font-weight:700;">Verified B2B Account</span></div>
                        </div>
                        <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px;">
                            <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; margin-bottom:4px;">2. Shipping Destination (Godown)</div>
                            <div style="font-weight:800; font-size:12px; color:#181512;">Consignee: ${order.customer}</div>
                            <div style="font-size:11px; color:#475569;">Godown 12, Transport Nagar, Surat, Gujarat - 395010</div>
                            <div style="font-size:11px; font-weight:700; color:#8A681F; margin-top:3px;">Contact No: ${order.phone}</div>
                        </div>
                    </div>

                    <table style="width:100%; border-collapse:collapse; margin-bottom:14px; font-size:11.5px;">
                        <thead>
                            <tr style="background:#181512; color:#FAF5E8;">
                                <th style="padding:6px 8px; text-align:center; width:30px;">#</th>
                                <th style="padding:6px 8px; text-align:left;">Item Details &amp; Color</th>
                                <th style="padding:6px 8px; text-align:center;">Packed Qty</th>
                                <th style="padding:6px 8px; text-align:center;">QC Verification</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom:1px solid #E2E8F0;">
                                <td style="padding:8px; text-align:center; font-weight:700;">1</td>
                                <td style="padding:8px; display:flex; align-items:center; gap:8px;">
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.onerror=null; this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:36px; height:36px; border-radius:4px; object-fit:cover; border:1px solid #E2DFD7;">
                                    <div>
                                        <strong>Kanjivaram Silk Saree Pure Zari Weave</strong><br>
                                        <small style="color:#64748B;">SKU: KNJ-001 • <span style="display:inline-flex; align-items:center; gap:3px;"><span style="width:6px; height:6px; border-radius:50%; background:#9B111E; display:inline-block;"></span> Royal Ruby / 5.5m</span></small>
                                    </div>
                                </td>
                                <td style="padding:8px; text-align:center; font-weight:800; font-size:13px; color:#181512;">25 pcs</td>
                                <td style="padding:8px; text-align:center;"><span style="font-size:10px; font-weight:800; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; padding:2px 6px; border-radius:4px;">✓ PASS (Silk Mark)</span></td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:6px; padding:8px 12px; font-size:11px; color:#64748B; display:flex; justify-content:space-between; align-items:center;">
                        <div>Carrier: <strong>${order.shipping || 'VRL Logistics Depot'}</strong> (${order.tracking || 'VRL-99821'})</div>
                        <div style="font-weight:700; color:#15803D;">QC Verification: PASS • Sealed Manifest</div>
                    </div>
                `;
            }

            modal.style.display = 'flex';
        },

        closePackingSlipModal: function() {
            const modal = document.getElementById('orderPackingSlipModal');
            if (modal) modal.style.display = 'none';
        },

        downloadInvoiceExcel: function(orderId) {
            orderId = orderId || document.getElementById('invoiceModalOrderId')?.textContent || 'DTB-001624';
            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                customer: 'Rajesh Kumar',
                firm: 'Vardhman Tex',
                phone: '+91 98220 19283',
                amount: 112250,
                date: '21 Aug 2026',
                payment: 'Bank Wire / RTGS',
                payment_status: 'PAID'
            };

            const taxable = (Number(order.amount || 112250) / 1.05);
            const cgst = taxable * 0.025;
            const sgst = taxable * 0.025;
            const total = Number(order.amount || 112250);

            const excelContent = `
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head><meta charset="utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Tax Invoice</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>
<body>
<table border="1">
    <tr><th colspan="5" style="background:#8A681F; color:#FFFFFF; font-size:16px; height:36px; text-align:center;">DT BRAND'S &amp; JAI HANUMAN TEX — TAX INVOICE</th></tr>
    <tr><td colspan="5" style="text-align:center; font-size:11px; color:#64748B;">Surat Central Depot • Ring Road, Surat • GSTIN: 24AAECJ1928K1Z5</td></tr>
    <tr><td><strong>Invoice No:</strong></td><td colspan="2">INV-${order.id.replace('DTB-', '2026-')}</td><td><strong>Date:</strong></td><td>${order.date}</td></tr>
    <tr><td><strong>Customer Name:</strong></td><td colspan="2">${order.customer} (${order.firm || 'Vardhman Tex'})</td><td><strong>Phone:</strong></td><td>${order.phone}</td></tr>
    <tr style="background:#181512; color:#FAF5E8;"><th>#</th><th>Item Description &amp; SKU</th><th>Qty</th><th>Unit Rate (INR)</th><th>Taxable Amount (INR)</th></tr>
    <tr><td style="text-align:center;">1</td><td>Kanjivaram Silk Saree Pure Zari Weave (KNJ-001)</td><td style="text-align:center;">25 pcs</td><td style="text-align:right;">4,490.00</td><td style="text-align:right;">${taxable.toFixed(2)}</td></tr>
    <tr><td colspan="4" style="text-align:right; font-weight:bold;">Taxable Subtotal:</td><td style="text-align:right; font-weight:bold;">₹ ${taxable.toFixed(2)}</td></tr>
    <tr><td colspan="4" style="text-align:right;">Output CGST @ 2.5%:</td><td style="text-align:right;">₹ ${cgst.toFixed(2)}</td></tr>
    <tr><td colspan="4" style="text-align:right;">Output SGST @ 2.5%:</td><td style="text-align:right;">₹ ${sgst.toFixed(2)}</td></tr>
    <tr style="background:#FAF5E8;"><td colspan="4" style="text-align:right; font-weight:bold; font-size:14px; color:#8A681F;">GRAND TOTAL (INR):</td><td style="text-align:right; font-weight:bold; font-size:14px; color:#8A681F;">₹ ${total.toFixed(2)}</td></tr>
    <tr><td colspan="5" style="font-size:10px; color:#64748B;">Payment Status: ${order.payment_status} via ${order.payment} • Silk Mark Certified</td></tr>
</table>
</body>
</html>`;

            const blob = new Blob(['\ufeff', excelContent], { type: 'application/vnd.ms-excel;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `DT_Brands_Tax_Invoice_${order.id}_${new Date().toISOString().slice(0,10)}.xls`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);

            if (window.DT_ORDERS) window.DT_ORDERS.showToast('📥 Tax Invoice Excel downloaded successfully!');
        },

        downloadInvoicePDF: function(orderId) {
            orderId = orderId || document.getElementById('invoiceModalOrderId')?.textContent || 'DTB-001624';
            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                customer: 'Rajesh Kumar',
                firm: 'Vardhman Tex',
                phone: '+91 98220 19283',
                amount: 112250,
                date: '21 Aug 2026',
                payment: 'Bank Wire / RTGS',
                payment_status: 'PAID'
            };

            const taxable = (Number(order.amount || 112250) / 1.05);
            const cgst = taxable * 0.025;
            const sgst = taxable * 0.025;
            const total = Number(order.amount || 112250);

            // Hidden iframe for direct download without opening new tabs/windows
            let iframe = document.getElementById('dt-direct-pdf-iframe');
            if (iframe) iframe.remove();
            
            iframe = document.createElement('iframe');
            iframe.id = 'dt-direct-pdf-iframe';
            iframe.style.position = 'fixed';
            iframe.style.top = '-9999px';
            iframe.style.left = '-9999px';
            iframe.style.width = '1px';
            iframe.style.height = '1px';
            iframe.style.opacity = '0';
            iframe.style.border = 'none';
            document.body.appendChild(iframe);

            const doc = iframe.contentWindow.document;
            doc.open();
            doc.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Tax Invoice #${order.id} ‹ DT Brand's</title>
                    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
                    <style>
                        @page { size: A4; margin: 15mm; }
                        body { font-family:'Plus Jakarta Sans',sans-serif; margin:0; padding:20px; color:#181512; }
                        table { width:100%; border-collapse:collapse; margin:16px 0; font-size:12px; }
                        th { background:#181512; color:#FAF5E8; padding:8px 10px; text-align:left; }
                        td { padding:8px 10px; border-bottom:1px solid #E2E8F0; }
                    </style>
                </head>
                <body>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:14px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <img src="/Shared/Asset/images/logo.png" onerror="this.onerror=null; this.src='/Frontend/Shop/Asset/images/logo.png';" style="height:48px; width:auto;">
                            <div>
                                <h2 style="margin:0; font-size:18px; font-weight:800;">DT BRAND'S &amp; JAI HANUMAN TEX</h2>
                                <p style="margin:2px 0 0 0; font-size:11px; color:#64748B;">Surat Central Depot • GSTIN: 24AAECJ1928K1Z5</p>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <span style="font-size:11px; font-weight:800; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; padding:2px 6px; border-radius:4px;">TAX INVOICE</span>
                            <div style="font-size:13px; font-weight:800; color:#181512; margin-top:4px;">INV-${order.id.replace('DTB-', '2026-')}</div>
                            <div style="font-size:11px; color:#64748B;">Date: ${order.date}</div>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:16px;">
                        <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px;">
                            <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase;">Billed Consignee</div>
                            <div style="font-weight:800; font-size:14px; margin-top:2px;">${order.customer}</div>
                            <div style="font-size:12px; color:#475569;">${order.firm || 'Vardhman Tex'}</div>
                            <div style="font-size:11.5px; color:#475569;">Contact: ${order.phone}</div>
                        </div>
                        <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px;">
                            <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase;">Payment &amp; Clearance</div>
                            <div style="font-weight:800; font-size:13px; color:#15803D; margin-top:2px;">● Status: ${order.payment_status}</div>
                            <div style="font-size:12px; color:#475569;">Mode: ${order.payment}</div>
                            <div style="font-size:11.5px; color:#475569;">Bank: ICICI Corporate Direct Wire</div>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item &amp; Description</th>
                                <th style="text-align:center;">Qty</th>
                                <th style="text-align:right;">Unit Rate (₹)</th>
                                <th style="text-align:right;">Taxable Total (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><strong>Kanjivaram Silk Saree Pure Zari Weave</strong><br><small style="color:#64748B;">SKU: KNJ-001 • Royal Ruby / 5.5m • Silk Mark Certified</small></td>
                                <td style="text-align:center; font-weight:800;">25 pcs</td>
                                <td style="text-align:right;">₹4,490.00</td>
                                <td style="text-align:right; font-weight:700;">₹${taxable.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="display:flex; justify-content:flex-end;">
                        <div style="width:260px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; padding:12px; font-size:12px;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                                <span>Taxable Amount:</span>
                                <strong>₹${taxable.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; margin-bottom:4px; color:#475569;">
                                <span>Output CGST (2.5%):</span>
                                <span>₹${cgst.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; margin-bottom:6px; color:#475569;">
                                <span>Output SGST (2.5%):</span>
                                <span>₹${sgst.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; border-top:1.5px solid #8A681F; padding-top:6px; font-size:14px; font-weight:800; color:#181512;">
                                <span>Grand Total:</span>
                                <span style="color:#8A681F;">₹${total.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:24px; border-top:1px solid #E2DFD7; padding-top:12px; font-size:10.5px; color:#64748B; display:flex; justify-content:space-between;">
                        <div>Computer Generated Tax Invoice • Surat Central Wholesale Depot</div>
                        <div style="font-weight:700; color:#181512;">Authorised Signatory</div>
                    </div>
                </body>
                </html>
            `);
            doc.close();

            setTimeout(() => {
                try {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                } catch (e) {
                    console.error(e);
                }
            }, 250);

            if (window.DT_ORDERS) window.DT_ORDERS.showToast('📥 Tax Invoice PDF initiated directly!');
        },

        downloadPackingSlipExcel: function(orderId) {
            orderId = orderId || document.getElementById('packingModalOrderId')?.textContent || 'DTB-001624';
            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                customer: 'Rajesh Kumar',
                firm: 'Vardhman Tex',
                phone: '+91 98220 19283',
                shipping: 'VRL Logistics Depot',
                tracking: 'VRL-99821',
                date: '21 Aug 2026'
            };

            const excelContent = `
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head><meta charset="utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Packing Slip</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>
<body>
<table border="1">
    <tr><th colspan="5" style="background:#8A681F; color:#FFFFFF; font-size:16px; height:36px; text-align:center;">PACKING SLIP — DEPOT DISPATCH MANIFEST</th></tr>
    <tr><td colspan="5" style="text-align:center; font-size:11px; color:#64748B;">Surat Central Depot Internal Wholesale Logistics Manifest</td></tr>
    <tr><td><strong>Order ID:</strong></td><td>${order.id}</td><td><strong>Manifest Box:</strong></td><td colspan="2">1 of 1 (Date: ${order.date})</td></tr>
    <tr><td><strong>1. Billed Customer &amp; Firm:</strong></td><td colspan="2">${order.customer} (${order.firm || 'Vardhman Tex'})</td><td><strong>Account Type:</strong></td><td>Verified B2B Account</td></tr>
    <tr><td><strong>2. Shipping Destination (Godown):</strong></td><td colspan="2">Godown 12, Transport Nagar, Surat, Gujarat - 395010</td><td><strong>Contact Phone:</strong></td><td>${order.phone}</td></tr>
    <tr style="background:#181512; color:#FAF5E8;"><th>#</th><th>Item Details &amp; SKU</th><th>Color / Specs</th><th>Packed Qty</th><th>QC Verification</th></tr>
    <tr><td style="text-align:center;">1</td><td>Kanjivaram Silk Saree Pure Zari Weave (KNJ-001)</td><td>Royal Ruby / 5.5m</td><td style="text-align:center; font-weight:bold;">25 pcs</td><td style="text-align:center; color:#15803D; font-weight:bold;">PASS (Silk Mark)</td></tr>
    <tr><td colspan="3" style="text-align:right; font-weight:bold;">TOTAL CONSIGNMENT QUANTITY:</td><td colspan="2" style="font-weight:bold; font-size:13px; color:#8A681F;">25 pcs (1 Bale Packed)</td></tr>
    <tr><td colspan="5" style="font-size:10px; color:#64748B;">Carrier: ${order.shipping || 'VRL Logistics Depot'} (${order.tracking || 'VRL-99821'}) • QC Inspection Officer Verified</td></tr>
</table>
</body>
</html>`;

            const blob = new Blob(['\ufeff', excelContent], { type: 'application/vnd.ms-excel;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `DT_Brands_Packing_Slip_${order.id}_${new Date().toISOString().slice(0,10)}.xls`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);

            if (window.DT_ORDERS) window.DT_ORDERS.showToast('📥 Warehouse Packing Slip Excel downloaded successfully!');
        },

        downloadPackingSlipPDF: function(orderId) {
            orderId = orderId || document.getElementById('packingModalOrderId')?.textContent || 'DTB-001624';
            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                customer: 'Rajesh Kumar',
                firm: 'Vardhman Tex',
                phone: '+91 98220 19283',
                shipping: 'VRL Logistics Depot',
                tracking: 'VRL-99821',
                date: '21 Aug 2026'
            };

            // Hidden iframe for direct download without opening new tabs/windows
            let iframe = document.getElementById('dt-direct-pdf-iframe');
            if (iframe) iframe.remove();
            
            iframe = document.createElement('iframe');
            iframe.id = 'dt-direct-pdf-iframe';
            iframe.style.position = 'fixed';
            iframe.style.top = '-9999px';
            iframe.style.left = '-9999px';
            iframe.style.width = '1px';
            iframe.style.height = '1px';
            iframe.style.opacity = '0';
            iframe.style.border = 'none';
            document.body.appendChild(iframe);

            const doc = iframe.contentWindow.document;
            doc.open();
            doc.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Packing Slip #${order.id} ‹ DT Brand's</title>
                    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
                    <style>
                        @page { size: A4; margin: 15mm; }
                        body { font-family:'Plus Jakarta Sans',sans-serif; margin:0; padding:20px; color:#181512; }
                        table { width:100%; border-collapse:collapse; margin:16px 0; font-size:12px; }
                        th { background:#181512; color:#FAF5E8; padding:8px 10px; text-align:left; }
                        td { padding:8px 10px; border-bottom:1px solid #E2E8F0; }
                    </style>
                </head>
                <body>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:14px;">
                        <div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <h2 style="margin:0; font-size:18px; font-weight:800;">PACKING SLIP</h2>
                                <span style="font-size:10px; font-weight:800; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; padding:2px 6px; border-radius:4px;">DEPOT DISPATCH MANIFEST</span>
                            </div>
                            <p style="margin:3px 0 0 0; font-size:11px; color:#64748B;">Surat Central Depot Internal Wholesale Logistics Manifest</p>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:14px; font-weight:800; color:#8A681F;">ORDER #${order.id}</div>
                            <div style="font-size:11px; color:#64748B;">Manifest Box: <strong>1 of 1</strong></div>
                            <div style="font-size:11px; color:#64748B;">Date: ${order.date}</div>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:16px;">
                        <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px;">
                            <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase;">1. Billed Customer &amp; Firm</div>
                            <div style="font-weight:800; font-size:14px; margin-top:2px;">${order.customer}</div>
                            <div style="font-size:12px; color:#475569;">${order.firm || 'Vardhman Tex'}</div>
                            <div style="margin-top:6px;"><span style="font-size:9.5px; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; padding:1px 5px; border-radius:3px; font-weight:700;">Verified B2B Account</span></div>
                        </div>
                        <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px;">
                            <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase;">2. Shipping Destination (Godown)</div>
                            <div style="font-weight:800; font-size:13px; margin-top:2px;">Consignee: ${order.customer}</div>
                            <div style="font-size:12px; color:#475569;">Godown 12, Transport Nagar, Surat, Gujarat - 395010</div>
                            <div style="font-size:11.5px; font-weight:700; color:#8A681F; margin-top:3px;">Contact No: ${order.phone}</div>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th style="width:30px; text-align:center;">#</th>
                                <th>Item Details &amp; Color</th>
                                <th style="text-align:center;">Packed Qty</th>
                                <th style="text-align:center;">QC Verification</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align:center;">1</td>
                                <td><strong>Kanjivaram Silk Saree Pure Zari Weave</strong><br><small style="color:#64748B;">SKU: KNJ-001 • Royal Ruby / 5.5m</small></td>
                                <td style="text-align:center; font-weight:800; font-size:13px;">25 pcs</td>
                                <td style="text-align:center;"><span style="font-size:10px; font-weight:800; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; padding:2px 6px; border-radius:4px;">✓ PASS (Silk Mark)</span></td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:6px; padding:10px 14px; font-size:11.5px; color:#64748B; display:flex; justify-content:space-between; align-items:center;">
                        <div>Carrier: <strong>${order.shipping || 'VRL Logistics Depot'}</strong> (${order.tracking || 'VRL-99821'})</div>
                        <div style="font-weight:700; color:#15803D;">QC Verification: PASS (Silk Mark Certified) • Sealed Manifest</div>
                    </div>

                    <div style="margin-top:24px; border-top:1px solid #E2DFD7; padding-top:12px; font-size:10.5px; color:#64748B; display:flex; justify-content:space-between;">
                        <div>Confidential Warehouse Dispatch Record • Surat Central Depot</div>
                        <div style="font-weight:700; color:#181512;">Warehouse Dispatch Officer</div>
                    </div>
                </body>
                </html>
            `);
            doc.close();

            setTimeout(() => {
                try {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                } catch (e) {
                    console.error(e);
                }
            }, 250);

            if (window.DT_ORDERS) window.DT_ORDERS.showToast('📥 Warehouse Packing Slip PDF initiated directly!');
        },

        openShippingLabelModal: function(orderId) {
            const modal = document.getElementById('orderShippingLabelModal');
            if (!modal) {
                window.location.href = '/Frontend/Admin/orders/shipping-label.php?id=' + encodeURIComponent(orderId);
                return;
            }

            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId || 'DTB-001624',
                customer: 'Rajesh Kumar (Vardhman Tex)',
                phone: '+91 98220 19283',
                shipping: 'VRL Logistics Depot',
                tracking: 'VRL-99821',
                items_count: 25,
                items_summary: 'Kanjivaram Silk Saree Pure Zari Weave (x25)',
                amount: 112250,
                date: '21 Aug 2026',
                address: {
                    shipping: 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002'
                }
            };

            const fullPageLink = document.getElementById('shippingLabelModalFullPageLink');
            if (fullPageLink) fullPageLink.href = '/Frontend/Admin/orders/shipping-label.php?id=' + encodeURIComponent(order.id);

            const orderIdTitle = document.getElementById('shippingLabelOrderIdTitle');
            if (orderIdTitle) orderIdTitle.textContent = order.id;

            const modalOrderId = document.getElementById('shippingLabelModalOrderId');
            if (modalOrderId) modalOrderId.textContent = order.id;

            const body = document.getElementById('shippingLabelModalBody');
            if (body) {
                const shippingAddr = (order.address && order.address.shipping) ? order.address.shipping : 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002';
                const itemSummary = order.items_summary || 'Kanjivaram Pure Silk Zari Weave Saree';
                const sizeVal = order.size || 'Free Size (6.3m with Blouse)';
                const skuVal = order.sku || ('DTB-KANJI-' + String(order.id || '1624').slice(-4));
                const qtyVal = order.items_count || 25;

                body.innerHTML = `
                    <div class="dt-shipping-label-card" style="max-width:440px; margin:0 auto; background:#FFFFFF; border:2.5px solid #181512; border-radius:8px; padding:16px 20px; font-family:'Plus Jakarta Sans', sans-serif; box-sizing:border-box;">
                        <!-- Header Block -->
                        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #181512; padding-bottom:8px; margin-bottom:10px;">
                            <div>
                                <div style="font-size:16px; font-weight:900; letter-spacing:0.3px; color:#181512; line-height:1.2;">${(order.shipping || 'SURAT CENTRAL DEPOT EXPRESS').toUpperCase()}</div>
                                <div style="font-size:9.5px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:0.5px; margin-top:2px;">SURAT HUB / DOCK 1 • B2B SURFACE LOGISTICS</div>
                            </div>
                            <div style="text-align:right;">
                                <span style="font-size:10.5px; font-weight:800; border:2px solid #181512; padding:3px 10px; border-radius:4px; background:#181512; color:#FFFFFF; letter-spacing:0.5px; display:inline-block;">PREPAID</span>
                            </div>
                        </div>

                        <!-- Barcode Section -->
                        <div style="text-align:center; padding:4px 0 6px 0; width:100%;">
                            <svg viewBox="0 0 450 50" width="100%" height="50" style="display:block; margin:0 auto; width:100%;" preserveAspectRatio="none">
                                <rect x="0" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="7" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="13" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="21" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="27" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="37" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="43" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="54" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="61" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="67" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="77" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="84" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="90" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="101" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="107" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="115" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="122" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="132" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="138" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="146" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="152" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="163" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="170" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="176" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="186" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="192" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="200" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="207" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="218" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="224" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="234" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="241" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="247" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="258" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="265" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="271" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="281" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="288" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="294" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="305" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="312" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="320" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="326" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="336" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="343" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="349" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="360" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="366" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="374" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="381" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="391" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="397" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="405" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="412" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="423" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="429" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="439" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="445" y="0" width="5" height="50" fill="#000000"/>
                            </svg>
                            <div style="font-family:monospace; font-weight:800; font-size:14.5px; letter-spacing:5px; color:#181512; margin-top:4px;">AWB: ${order.tracking || 'VRL-99821'}</div>
                        </div>

                        <!-- Consignee Delivery Destination -->
                        <div style="border-top:2px solid #181512; border-bottom:2px solid #181512; padding:8px 0; margin-bottom:8px; font-size:12px; line-height:1.4;">
                            <div style="font-size:9px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:0.5px; margin-bottom:2px;">DELIVER TO (CONSIGNEE):</div>
                            <div style="font-size:14px; font-weight:800; color:#181512; margin-bottom:2px;">${order.customer}</div>
                            <div style="color:#334155; font-size:11.5px;">${shippingAddr}</div>
                        </div>

                        <!-- Product SKU & Size Table (Meesho Marketplace Format) -->
                        <table style="width:100%; border-collapse:collapse; margin-bottom:8px; font-size:11px;">
                            <thead>
                                <tr style="background:#FAF8F4; border:1px solid #E2DFD7; text-align:left; color:#475569;">
                                    <th style="padding:4px 6px; font-weight:800;">ITEM / SKU</th>
                                    <th style="padding:4px 6px; font-weight:800; text-align:center;">SIZE</th>
                                    <th style="padding:4px 6px; font-weight:800; text-align:center;">QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom:1px solid #E2DFD7;">
                                    <td style="padding:5px 6px;">
                                        <div style="font-weight:800; color:#181512;">${itemSummary}</div>
                                        <div style="font-size:9.5px; color:#64748B; font-family:monospace;">SKU: ${skuVal}</div>
                                    </td>
                                    <td style="padding:5px 6px; text-align:center; font-weight:800; color:#8A681F; white-space:nowrap;">
                                        ${sizeVal}
                                    </td>
                                    <td style="padding:5px 6px; text-align:center; font-weight:900; color:#181512;">
                                        ${qtyVal}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Order Reference & QC Verification -->
                        <div style="display:flex; justify-content:space-between; align-items:center; font-size:11px; color:#475569; border-top:1px solid #E2DFD7; padding-top:6px; font-weight:700;">
                            <div>Order Reference: <strong style="color:#181512;">${order.id}</strong></div>
                            <div style="border:1px solid #181512; padding:2px 8px; border-radius:3px; color:#181512; font-weight:800; font-size:9.5px; text-align:center;">
                                QC PASS • SILK MARK
                            </div>
                        </div>
                    </div>
                `;
            }

            modal.style.display = 'flex';
        },

        closeShippingLabelModal: function() {
            const modal = document.getElementById('orderShippingLabelModal');
            if (modal) modal.style.display = 'none';
        },

        printShippingLabelDirect: function(orderId) {
            orderId = orderId || document.getElementById('shippingLabelModalOrderId')?.textContent || 'DTB-001624';
            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                customer: 'Rajesh Kumar (Vardhman Tex)',
                phone: '+91 98220 19283',
                shipping: 'Surat Central Depot Express',
                tracking: 'VRL-99821',
                items_count: 25,
                items_summary: 'Kanjivaram Pure Silk Zari Weave Saree',
                size: 'Free Size (6.3m with Blouse)',
                sku: 'DTB-KANJI-' + String(orderId || '1624').slice(-4),
                address: {
                    shipping: 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002'
                }
            };

            let iframe = document.getElementById('dtDirectPrintIframe');
            if (!iframe) {
                iframe = document.createElement('iframe');
                iframe.id = 'dtDirectPrintIframe';
                iframe.style.position = 'fixed';
                iframe.style.right = '0';
                iframe.style.bottom = '0';
                iframe.style.width = '0';
                iframe.style.height = '0';
                iframe.style.border = 'none';
                document.body.appendChild(iframe);
            }

            const shippingAddr = (order.address && order.address.shipping) ? order.address.shipping : 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002';
            const itemSummary = order.items_summary || 'Kanjivaram Pure Silk Zari Weave Saree';
            const sizeVal = order.size || 'Free Size (6.3m with Blouse)';
            const skuVal = order.sku || ('DTB-KANJI-' + String(order.id || '1624').slice(-4));
            const qtyVal = order.items_count || 25;

            const doc = iframe.contentWindow.document;
            doc.open();
            doc.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Shipping Label ${order.id}</title>
                    <style>
                        @page { 
                            size: auto; 
                            margin: 6mm 8mm; 
                        }
                        * { box-sizing: border-box; }
                        html, body { 
                            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, Arial, sans-serif; 
                            margin: 0; 
                            padding: 0; 
                            width: 100%;
                            background: #FFF; 
                            color: #000; 
                            -webkit-print-color-adjust: exact !important; 
                            print-color-adjust: exact !important; 
                        }
                        .dt-shipping-label-card { 
                            width: 100% !important; 
                            max-width: 100% !important; 
                            min-width: 100% !important;
                            margin: 0 auto !important; 
                            background: #FFF !important; 
                            border: 2.5px solid #181512 !important; 
                            border-radius: 8px !important; 
                            padding: 16px 20px !important; 
                            box-sizing: border-box !important; 
                            -webkit-print-color-adjust: exact !important; 
                            print-color-adjust: exact !important; 
                        }
                    </style>
                </head>
                <body>
                    <div class="dt-shipping-label-card">
                        <!-- Header Block -->
                        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #181512; padding-bottom:8px; margin-bottom:10px;">
                            <div>
                                <div style="font-size:16px; font-weight:900; letter-spacing:0.3px; color:#181512; line-height:1.2;">${(order.shipping || 'SURAT CENTRAL DEPOT EXPRESS').toUpperCase()}</div>
                                <div style="font-size:9.5px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:0.5px; margin-top:2px;">SURAT HUB / DOCK 1 • B2B SURFACE LOGISTICS</div>
                            </div>
                            <div style="text-align:right;">
                                <span style="font-size:10.5px; font-weight:800; border:2px solid #181512; padding:3px 10px; border-radius:4px; background:#181512; color:#FFFFFF; letter-spacing:0.5px; display:inline-block;">PREPAID</span>
                            </div>
                        </div>

                        <!-- Barcode Section -->
                        <div style="text-align:center; padding:4px 0 6px 0; width:100%;">
                            <svg viewBox="0 0 450 50" width="100%" height="50" style="display:block; margin:0 auto; width:100%;" preserveAspectRatio="none">
                                <rect x="0" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="7" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="13" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="21" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="27" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="37" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="43" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="54" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="61" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="67" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="77" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="84" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="90" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="101" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="107" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="115" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="122" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="132" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="138" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="146" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="152" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="163" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="170" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="176" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="186" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="192" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="200" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="207" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="218" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="224" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="234" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="241" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="247" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="258" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="265" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="271" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="281" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="288" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="294" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="305" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="312" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="320" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="326" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="336" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="343" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="349" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="360" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="366" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="374" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="381" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="391" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="397" y="0" width="5" height="50" fill="#000000"/>
                                <rect x="405" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="412" y="0" width="8" height="50" fill="#000000"/>
                                <rect x="423" y="0" width="3" height="50" fill="#000000"/>
                                <rect x="429" y="0" width="7" height="50" fill="#000000"/>
                                <rect x="439" y="0" width="4" height="50" fill="#000000"/>
                                <rect x="445" y="0" width="5" height="50" fill="#000000"/>
                            </svg>
                            <div style="font-family:monospace; font-weight:800; font-size:14.5px; letter-spacing:5px; color:#181512; margin-top:4px;">AWB: ${order.tracking || 'VRL-99821'}</div>
                        </div>

                        <!-- Consignee Delivery Destination -->
                        <div style="border-top:2px solid #181512; border-bottom:2px solid #181512; padding:8px 0; margin-bottom:8px; font-size:12px; line-height:1.4;">
                            <div style="font-size:9px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:0.5px; margin-bottom:2px;">DELIVER TO (CONSIGNEE):</div>
                            <div style="font-size:14px; font-weight:800; color:#181512; margin-bottom:2px;">${order.customer}</div>
                            <div style="color:#334155; font-size:11.5px;">${shippingAddr}</div>
                        </div>

                        <!-- Product SKU & Size Table (Meesho Marketplace Format) -->
                        <table style="width:100%; border-collapse:collapse; margin-bottom:8px; font-size:11px;">
                            <thead>
                                <tr style="background:#FAF8F4; border:1px solid #E2DFD7; text-align:left; color:#475569;">
                                    <th style="padding:4px 6px; font-weight:800;">ITEM / SKU</th>
                                    <th style="padding:4px 6px; font-weight:800; text-align:center;">SIZE</th>
                                    <th style="padding:4px 6px; font-weight:800; text-align:center;">QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom:1px solid #E2DFD7;">
                                    <td style="padding:5px 6px;">
                                        <div style="font-weight:800; color:#181512;">${itemSummary}</div>
                                        <div style="font-size:9.5px; color:#64748B; font-family:monospace;">SKU: ${skuVal}</div>
                                    </td>
                                    <td style="padding:5px 6px; text-align:center; font-weight:800; color:#8A681F; white-space:nowrap;">
                                        ${sizeVal}
                                    </td>
                                    <td style="padding:5px 6px; text-align:center; font-weight:900; color:#181512;">
                                        ${qtyVal}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Order Reference & QC Verification -->
                        <div style="display:flex; justify-content:space-between; align-items:center; font-size:11px; color:#475569; border-top:1px solid #E2DFD7; padding-top:6px; font-weight:700;">
                            <div>Order Reference: <strong style="color:#181512;">${order.id}</strong></div>
                            <div style="border:1px solid #181512; padding:2px 8px; border-radius:3px; color:#181512; font-weight:800; font-size:9.5px; text-align:center;">
                                QC PASS • SILK MARK
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            `);
            doc.close();

            setTimeout(() => {
                try {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                } catch (e) {
                    console.error(e);
                }
            }, 250);

            if (window.DT_ORDERS) window.DT_ORDERS.showToast(`🖨️ Printing shipping label for ${order.id}`);
        },

        switchDocTab: function(tabName) {
            const orderId = document.getElementById('shippingLabelModalOrderId')?.textContent || 'DTB-001624';
            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const order = orders.find(o => o.id === orderId) || {
                id: orderId,
                customer: 'Rajesh Kumar',
                firm: 'Vardhman Tex',
                phone: '+91 98220 19283',
                shipping: 'VRL Logistics Depot',
                tracking: 'VRL-99821',
                items_count: '25 pcs',
                items_summary: 'Kanjivaram Silk Saree Pure Zari Weave (x25)',
                amount: 112250,
                date: '21 Aug 2026'
            };

            const tabShipping = document.getElementById('tabBtnShippingLabel');
            const tabPacking = document.getElementById('tabBtnPackingSlip');
            const body = document.getElementById('shippingLabelModalBody');
            const footerNote = document.getElementById('shippingLabelFooterNote');
            const printBtnText = document.getElementById('shippingLabelDirectPrintBtnText');
            const printBtn = document.getElementById('shippingLabelDirectPrintBtn');

            if (tabName === 'packing') {
                if (tabShipping) {
                    tabShipping.style.background = '#F1F5F9';
                    tabShipping.style.color = '#64748B';
                    tabShipping.style.borderColor = '#CBD5E1';
                    tabShipping.style.fontWeight = '700';
                }
                if (tabPacking) {
                    tabPacking.style.background = '#FFFFFF';
                    tabPacking.style.color = '#B45309';
                    tabPacking.style.borderColor = '#FCD34D';
                    tabPacking.style.fontWeight = '800';
                }
                if (footerNote) footerNote.textContent = 'Internal Warehouse Dispatch Record • Silk Mark QC Passed';
                if (printBtnText) printBtnText.textContent = 'Print Packing Manifest';
                if (printBtn) printBtn.onclick = () => window.DT_ORDER_VIEW.printPackingSlipDirect(order.id);

                if (body) {
                    body.innerHTML = `
                        <div style="border:1.5px solid #E2DFD7; border-radius:8px; padding:16px; background:#FFFFFF; font-family:'Plus Jakarta Sans', sans-serif;">
                            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:10px; margin-bottom:12px;">
                                <div>
                                    <h3 style="margin:0; font-size:15px; font-weight:800; color:#181512;">WAREHOUSE PACKING MANIFEST</h3>
                                    <p style="margin:2px 0 0 0; font-size:10.5px; color:#64748B;">Surat Central Depot Dock 1 • QC Pass Verified</p>
                                </div>
                                <div style="text-align:right;">
                                    <span style="font-size:10px; font-weight:800; background:#FEF3C7; color:#B45309; border:1px solid #FCD34D; padding:2px 6px; border-radius:4px;">DISPATCH SLIP</span>
                                    <div style="font-size:12px; font-weight:800; color:#181512; margin-top:2px;">${order.id}</div>
                                </div>
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:12px;">
                                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px;">
                                    <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase;">Consignee Destination</div>
                                    <div style="font-weight:800; font-size:12.5px; color:#181512;">${order.customer}</div>
                                    <div style="font-size:11px; color:#475569;">${order.firm || 'Vardhman Tex'}</div>
                                    <div style="font-size:11px; color:#475569;">TEL: ${order.phone}</div>
                                </div>
                                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px;">
                                    <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase;">Carrier &amp; Tracking</div>
                                    <div style="font-weight:800; font-size:12px; color:#181512;">${order.shipping || 'VRL Logistics Depot'}</div>
                                    <div style="font-size:11px; color:#475569;">AWB: ${order.tracking || 'VRL-99821'}</div>
                                    <div style="font-size:10.5px; color:#15803D; font-weight:700;">QC Verification: 100% PASS</div>
                                </div>
                            </div>

                            <table style="width:100%; border-collapse:collapse; margin-bottom:12px; font-size:11.5px;">
                                <thead>
                                    <tr style="background:#181512; color:#FAF5E8;">
                                        <th style="padding:6px 8px; text-align:left;">Item Description &amp; SKU</th>
                                        <th style="padding:6px 8px; text-align:center;">Qty</th>
                                        <th style="padding:6px 8px; text-align:center;">QC Verified</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom:1px solid #E2E8F0;">
                                        <td style="padding:8px;">
                                            <strong>${order.items_summary || 'Kanjivaram Silk Saree Pure Zari Weave'}</strong><br>
                                            <small style="color:#64748B;">Surat Central Depot Sealed Batch</small>
                                        </td>
                                        <td style="padding:8px; text-align:center; font-weight:800;">${order.items_count || '25 pcs'}</td>
                                        <td style="padding:8px; text-align:center; color:#15803D; font-weight:800;">✓ PASS (Silk Mark)</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:6px; padding:8px 12px; display:flex; justify-content:space-between; align-items:center; font-size:11px; color:#64748B;">
                                <div>Total Master Cartons: <strong>2 Boxes</strong> (18.5 Kg)</div>
                                <div style="font-weight:700; color:#181512;">Warehouse Dispatch Lead Verified</div>
                            </div>
                        </div>
                    `;
                }
            } else {
                // Switch back to 4x6 Shipping Label
                if (tabShipping) {
                    tabShipping.style.background = '#FFFFFF';
                    tabShipping.style.color = '#8A681F';
                    tabShipping.style.borderColor = '#D4AF37';
                    tabShipping.style.fontWeight = '800';
                }
                if (tabPacking) {
                    tabPacking.style.background = '#F1F5F9';
                    tabPacking.style.color = '#64748B';
                    tabPacking.style.borderColor = '#CBD5E1';
                    tabPacking.style.fontWeight = '700';
                }
                if (footerNote) footerNote.textContent = 'Official Courier AWB Barcode • 4×6 Standard Label';
                if (printBtnText) printBtnText.textContent = 'Print 4×6 Label';
                if (printBtn) printBtn.onclick = () => window.DT_ORDER_VIEW.printShippingLabelDirect(order.id);

                this.openShippingLabelModal(order.id);
            }
        }
    };
})(window);


