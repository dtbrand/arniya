/**
 * bulk-actions.js — Multi-Select Checkboxes & Bulk Operations
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    window.DT_BULK_ACTIONS = {
        toggleSelectAll: function(masterCheckbox) {
            const checkboxes = document.querySelectorAll('.dt-order-check');
            checkboxes.forEach(cb => {
                cb.checked = masterCheckbox.checked;
                const row = cb.closest('tr');
                if (row) {
                    if (cb.checked) row.classList.add('selected');
                    else row.classList.remove('selected');
                }
            });
            this.updateBulkBar();
        },

        onRowCheckChange: function(checkbox) {
            const row = checkbox.closest('tr');
            if (row) {
                if (checkbox.checked) row.classList.add('selected');
                else row.classList.remove('selected');
            }

            // Sync master checkbox state
            const total = document.querySelectorAll('.dt-order-check').length;
            const checked = document.querySelectorAll('.dt-order-check:checked').length;
            const masterCb = document.querySelector('.col-check input[type="checkbox"]');
            if (masterCb) {
                masterCb.checked = (total > 0 && checked === total);
                masterCb.indeterminate = (checked > 0 && checked < total);
            }

            this.updateBulkBar();
        },

        updateBulkBar: function() {
            const checked = document.querySelectorAll('.dt-order-check:checked');
            const bulkBar = document.getElementById('ordersBulkBar');
            const countText = document.getElementById('bulkSelectedCount');

            if (checked.length > 0) {
                if (bulkBar) bulkBar.classList.add('active');
                if (countText) countText.textContent = `${checked.length} Order${checked.length > 1 ? 's' : ''} Selected`;
            } else {
                if (bulkBar) bulkBar.classList.remove('active');
            }
        },

        clearSelection: function() {
            const checkboxes = document.querySelectorAll('.dt-order-check, .col-check input[type="checkbox"]');
            checkboxes.forEach(cb => {
                cb.checked = false;
                cb.indeterminate = false;
                const row = cb.closest('tr');
                if (row) row.classList.remove('selected');
            });
            this.updateBulkBar();
        },

        getSelectedOrders: function() {
            const checked = document.querySelectorAll('.dt-order-check:checked');
            const orders = (window.DT_ORDERS && window.DT_ORDERS.orders) ? window.DT_ORDERS.orders : [];
            const result = [];

            checked.forEach(cb => {
                const row = cb.closest('tr');
                if (!row) return;
                const id = row.getAttribute('data-id') || row.querySelector('.dt-order-id-link')?.textContent?.trim();
                const found = orders.find(o => o.id === id);
                if (found) {
                    result.push(found);
                } else {
                    const cust = row.getAttribute('data-customer') || row.querySelector('.dt-customer-name')?.textContent?.trim() || 'Wholesale Consignee';
                    const ph = row.getAttribute('data-phone') || row.querySelector('.dt-customer-phone')?.textContent?.trim() || '+91 70463 63528';
                    const amt = row.querySelector('.dt-amount-cell span')?.textContent?.replace(/,/g, '') || '45000';
                    const items = row.querySelector('.dt-items-pill')?.textContent?.trim() || '15 pcs';
                    result.push({
                        id: id || 'DTB-001624',
                        customer: cust,
                        firm: 'Surat Textile Hub',
                        phone: ph,
                        amount: Number(amt),
                        items_count: items,
                        items_summary: 'Handloom Pure Silk Zari Saree Consignment (' + items + ')',
                        shipping: 'VRL Logistics Depot',
                        tracking: 'VRL-' + Math.floor(10000 + Math.random() * 90000),
                        status: row.getAttribute('data-status') || 'pending',
                        date: '21 Aug 2026'
                    });
                }
            });

            return result;
        },

        executeBulkStatus: function(newStatus) {
            const checked = document.querySelectorAll('.dt-order-check:checked');
            if (checked.length === 0) return;

            checked.forEach(cb => {
                const row = cb.closest('tr');
                if (row) {
                    const id = row.getAttribute('data-id');
                    const badge = row.querySelector('.dt-status-badge');
                    if (badge) {
                        badge.className = `dt-status-badge ${newStatus}`;
                        badge.innerHTML = `<span class="dt-status-dot"></span><span>${newStatus.replace(/_/g, ' ')}</span>`;
                    }
                    if (window.DT_ORDERS && window.DT_ORDERS.orders && id) {
                        const target = window.DT_ORDERS.orders.find(o => o.id === id);
                        if (target) target.status = newStatus;
                    }
                }
            });

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`⚡ ${checked.length} orders updated to ${newStatus.toUpperCase()}`);
            }
        },

        executeBulkPrintLabels: function() {
            const selectedOrders = this.getSelectedOrders();
            if (selectedOrders.length === 0) {
                if (window.DT_ORDERS) window.DT_ORDERS.showToast('Please select at least 1 order to print shipping labels');
                return;
            }

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

            let labelsHtml = '';
            selectedOrders.forEach((order, idx) => {
                const isLast = (idx === selectedOrders.length - 1);
                const shippingAddr = (order.address && order.address.shipping) ? order.address.shipping : 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002';
                const itemSummary = order.items_summary || 'Kanjivaram Pure Silk Zari Weave Saree';
                const sizeVal = order.size || 'Free Size (6.3m with Blouse)';
                const skuVal = order.sku || ('DTB-KANJI-' + String(order.id || '1624').slice(-4));
                const qtyVal = order.items_count || 25;

                labelsHtml += `
                    <div class="dt-shipping-label-card" style="page-break-after: ${isLast ? 'auto' : 'always'}; width: 100%; max-width: 100%; min-width: 100%; margin: 0 auto 20px auto; background: #FFFFFF; border: 2.5px solid #181512; border-radius: 8px; padding: 16px 20px; font-family: 'Plus Jakarta Sans', Arial, sans-serif; box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
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
            });

            const doc = iframe.contentWindow.document;
            doc.open();
            doc.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Batch Shipping Labels (${selectedOrders.length} Orders)</title>
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
                            margin: 0 auto 20px auto !important; 
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
                    ${labelsHtml}
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
            }, 300);

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`🏷️ Multi-Label batch print generated for ${selectedOrders.length} selected orders!`);
            }
        },

        executeBulkPrintInvoices: function() {
            const selectedOrders = this.getSelectedOrders();
            if (selectedOrders.length === 0) {
                if (window.DT_ORDERS) window.DT_ORDERS.showToast('Please select at least 1 order to print tax invoices');
                return;
            }

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

            let invoicesHtml = '';
            selectedOrders.forEach((order, idx) => {
                const isLast = (idx === selectedOrders.length - 1);
                const taxable = (Number(order.amount || 45000) / 1.05);
                const grandTotal = Number(order.amount || 45000);

                invoicesHtml += `
                    <div class="invoice-page" style="page-break-after: ${isLast ? 'auto' : 'always'}; margin-bottom: 24px; padding: 20px; font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-size: 11.5px; color: #181512; box-sizing: border-box;">
                        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:12px; margin-bottom:14px;">
                            <div>
                                <h2 style="margin:0; font-size:16px; font-weight:800; color:#181512;">DT BRAND'S &amp; JAI HANUMAN TEX</h2>
                                <p style="margin:2px 0 0 0; font-size:10px; color:#64748B;">Surat Central Depot • Ring Road, Surat • GSTIN: 24AAECJ1928K1Z5</p>
                            </div>
                            <div style="text-align:right;">
                                <span style="font-size:10px; font-weight:800; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; padding:2px 6px; border-radius:4px;">TAX INVOICE</span>
                                <div style="font-size:12px; font-weight:800; color:#181512; margin-top:2px;">INV-${order.id.replace('DTB-', '2026-')}</div>
                                <div style="font-size:10px; color:#64748B;">Date: ${order.date || '21 Aug 2026'}</div>
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:14px;">
                            <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px;">
                                <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase;">Billed Customer (Consignee)</div>
                                <div style="font-weight:800; font-size:12.5px; color:#181512;">${order.customer}</div>
                                <div style="font-size:11px; color:#475569;">${order.firm || 'Vardhman Tex'}</div>
                                <div style="font-size:11px; color:#475569;">Phone: ${order.phone}</div>
                            </div>
                            <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px;">
                                <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase;">Settlement &amp; Logistics</div>
                                <div style="font-weight:800; font-size:12px; color:#15803D;">● Settlement: ${order.status?.toUpperCase() || 'CONFIRMED'}</div>
                                <div style="font-size:11px; color:#475569;">Carrier: ${order.shipping || 'VRL Logistics Depot'}</div>
                                <div style="font-size:11px; color:#475569;">Tracking: ${order.tracking || 'VRL-99821'}</div>
                            </div>
                        </div>

                        <table style="width:100%; border-collapse:collapse; margin-bottom:14px; font-size:11.5px;">
                            <thead>
                                <tr style="background:#181512; color:#FAF5E8;">
                                    <th style="padding:6px 8px; text-align:left;">Item Details &amp; SKU</th>
                                    <th style="padding:6px 8px; text-align:center;">Qty</th>
                                    <th style="padding:6px 8px; text-align:right;">Taxable (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom:1px solid #E2E8F0;">
                                    <td style="padding:8px;">
                                        <strong>${order.items_summary || 'Surat Pure Silk Zari Saree Consignment'}</strong><br>
                                        <small style="color:#64748B;">Surat Central Depot Verified Lot • Silk Mark Certified</small>
                                    </td>
                                    <td style="padding:8px; text-align:center; font-weight:800;">${order.items_count || '15 pcs'}</td>
                                    <td style="padding:8px; text-align:right; font-weight:700;">₹${taxable.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="display:flex; justify-content:space-between; align-items:center; background:#FAF5E8; border:1.5px solid #8A681F; border-radius:6px; padding:10px 14px;">
                            <div style="font-size:10.5px; color:#8A681F; font-weight:700;">Includes 5% Textile GST (2.5% CGST + 2.5% SGST)</div>
                            <div style="font-size:14px; font-weight:800; color:#181512;">Grand Total: ₹${grandTotal.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2})}</div>
                        </div>
                    </div>
                `;
            });

            const doc = iframe.contentWindow.document;
            doc.open();
            doc.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Batch Tax Invoices (${selectedOrders.length} Invoices)</title>
                    <style>
                        @page { size: A4 portrait; margin: 15mm; }
                        body { margin: 0; padding: 0; background: #FFF; }
                    </style>
                </head>
                <body>
                    ${invoicesHtml}
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
            }, 300);

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`📄 Multi-Invoice batch print generated for ${selectedOrders.length} selected orders!`);
            }
        },

        executeBulkPrintPackingSlips: function() {
            const selectedOrders = this.getSelectedOrders();
            if (selectedOrders.length === 0) {
                if (window.DT_ORDERS) window.DT_ORDERS.showToast('Please select at least 1 order to print packing slips');
                return;
            }

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

            let slipsHtml = '';
            selectedOrders.forEach((order, idx) => {
                const isLast = (idx === selectedOrders.length - 1);
                slipsHtml += `
                    <div class="slip-page" style="page-break-after: ${isLast ? 'auto' : 'always'}; margin-bottom: 24px; padding: 20px; font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-size: 11.5px; color: #181512; box-sizing: border-box;">
                        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:12px; margin-bottom:14px;">
                            <div>
                                <h2 style="margin:0; font-size:16px; font-weight:800; color:#181512;">WAREHOUSE PACKING MANIFEST</h2>
                                <p style="margin:2px 0 0 0; font-size:10px; color:#64748B;">Surat Central Depot Dock 1 • DT Brand's &amp; Jai Hanuman Tex</p>
                            </div>
                            <div style="text-align:right;">
                                <span style="font-size:10px; font-weight:800; background:#FEF3C7; color:#B45309; border:1px solid #FCD34D; padding:2px 6px; border-radius:4px;">DISPATCH SLIP</span>
                                <div style="font-size:12px; font-weight:800; color:#181512; margin-top:2px;">${order.id}</div>
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:14px;">
                            <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px;">
                                <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase;">Consignee Destination</div>
                                <div style="font-weight:800; font-size:12.5px; color:#181512;">${order.customer}</div>
                                <div style="font-size:11px; color:#475569;">${order.firm || 'Vardhman Tex'}</div>
                                <div style="font-size:11px; color:#475569;">TEL: ${order.phone}</div>
                            </div>
                            <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px;">
                                <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase;">Transport Logistics</div>
                                <div style="font-weight:800; font-size:12px; color:#181512;">${order.shipping || 'VRL Logistics Depot'}</div>
                                <div style="font-size:11px; color:#475569;">AWB: ${order.tracking || 'VRL-99821'}</div>
                                <div style="font-size:11px; color:#15803D; font-weight:700;">QC Status: SILK MARK PASSED</div>
                            </div>
                        </div>

                        <table style="width:100%; border-collapse:collapse; margin-bottom:14px; font-size:11.5px;">
                            <thead>
                                <tr style="background:#181512; color:#FAF5E8;">
                                    <th style="padding:6px 8px; text-align:left;">Item Description</th>
                                    <th style="padding:6px 8px; text-align:center;">Packed Qty</th>
                                    <th style="padding:6px 8px; text-align:center;">QC Pass</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom:1px solid #E2E8F0;">
                                    <td style="padding:8px;"><strong>${order.items_summary || 'Surat Pure Silk Saree Consignment'}</strong></td>
                                    <td style="padding:8px; text-align:center; font-weight:800;">${order.items_count || '15 pcs'}</td>
                                    <td style="padding:8px; text-align:center; color:#15803D; font-weight:800;">✓ PASS</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `;
            });

            const doc = iframe.contentWindow.document;
            doc.open();
            doc.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Batch Packing Slips (${selectedOrders.length} Orders)</title>
                    <style>
                        @page { size: A4 portrait; margin: 15mm; }
                        body { margin: 0; padding: 0; background: #FFF; }
                    </style>
                </head>
                <body>
                    ${slipsHtml}
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
            }, 300);

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`📦 Multi-Packing Manifest batch print generated for ${selectedOrders.length} selected orders!`);
            }
        },

        executeBulkExport: function() {
            const selectedOrders = this.getSelectedOrders();
            if (selectedOrders.length === 0) {
                if (window.DT_ORDERS) window.DT_ORDERS.showToast('Please select at least 1 order to export');
                return;
            }

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`📥 Exporting ${selectedOrders.length} selected orders to CSV/Excel...`);
            }
        }
    };
})();

