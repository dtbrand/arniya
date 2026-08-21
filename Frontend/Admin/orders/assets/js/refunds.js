/**
 * refunds.js — Refund Calculation Drawer, Search, Filter & Voucher Actions
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    let currentStatusFilter = 'all';
    let currentMethodFilter = 'all';
    let currentSearchQuery = '';

    window.DT_REFUNDS = {
        openRefundDrawer: function(orderId, maxAmount) {
            const drawer = document.getElementById('refundDrawer');
            if (!drawer) return;

            const orderIdEl = document.getElementById('refundOrderIdText');
            if (orderIdEl) orderIdEl.textContent = orderId || 'DTB-001624';

            const maxDisplay = document.getElementById('refundMaxAmountDisplay');
            if (maxDisplay) maxDisplay.textContent = '₹' + Number(maxAmount || 112250).toLocaleString('en-IN');

            const amountInput = document.getElementById('refundAmountInput');
            if (amountInput) amountInput.value = maxAmount || 112250;

            drawer.style.display = 'flex';
        },

        closeRefundDrawer: function() {
            const drawer = document.getElementById('refundDrawer');
            if (drawer) drawer.style.display = 'none';
        },

        confirmRefund: function() {
            const orderId = document.getElementById('refundOrderIdText')?.textContent || 'DTB-001624';
            const amount = document.getElementById('refundAmountInput')?.value || '112250';
            const method = document.getElementById('refundMethodSelect')?.value || 'Original Payment Gateway';

            this.closeRefundDrawer();
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast('Refund of ₹' + Number(amount).toLocaleString('en-IN') + ' authorized via ' + method + ' for ' + orderId);
            } else {
                alert('Refund of ₹' + Number(amount).toLocaleString('en-IN') + ' authorized via ' + method + ' for ' + orderId);
            }
        },

        handleSearch: function(query) {
            currentSearchQuery = (query || '').toLowerCase().trim();
            this.applyFilters();
        },

        filterByStatus: function(status, btnElement) {
            currentStatusFilter = status || 'all';

            // Update tab pills active state
            document.querySelectorAll('.dt-refund-subnav-pill').forEach(btn => btn.classList.remove('active'));
            if (btnElement) btnElement.classList.add('active');

            this.applyFilters();
        },

        filterByMethod: function(method) {
            currentMethodFilter = method || 'all';
            this.applyFilters();
        },

        applyFilters: function() {
            const rows = document.querySelectorAll('#refundTableBody tr');
            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status') || '';
                const rowMethod = row.getAttribute('data-method') || '';
                const rowText = row.textContent.toLowerCase();

                const matchesStatus = (currentStatusFilter === 'all') || (rowStatus === currentStatusFilter);
                const matchesMethod = (currentMethodFilter === 'all') || (rowMethod.includes(currentMethodFilter));
                const matchesSearch = (!currentSearchQuery) || (rowText.includes(currentSearchQuery));

                if (matchesStatus && matchesMethod && matchesSearch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        },

        approveClaim: function(refundId, amount, customer) {
            const row = Array.from(document.querySelectorAll('#refundTableBody tr')).find(r => r.textContent.includes(refundId));
            if (row) {
                const statusCell = row.querySelector('.dt-status-badge');
                if (statusCell) {
                    statusCell.className = 'dt-status-badge delivered';
                    statusCell.innerHTML = '<span class="dt-status-dot"></span><span>Settled</span>';
                }
                row.setAttribute('data-status', 'settled');
            }

            const msg = `Approved claim ${refundId} (₹${Number(amount).toLocaleString('en-IN')}) for ${customer}. Credit Note Issued.`;
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(msg);
            } else {
                alert(msg);
            }
        },

        shareWhatsApp: function(refundId, amount, customer) {
            const text = encodeURIComponent(`*DT BRAND'S & JAI HANUMAN TEX — REFUND SETTLEMENT ADVICE*\n\nDear ${customer},\nYour refund claim *${refundId}* for *₹${Number(amount).toLocaleString('en-IN')}* has been cleared & settled to your account/credit ledger.\n\nSurat Central Depot • Ring Road, Surat\nGSTIN: 24AAECJ1928K1Z5`);
            window.open(`https://api.whatsapp.com/send?text=${text}`, '_blank');
        },

        downloadCreditNotePDF: function(refundId, orderId, amount, customer) {
            let iframe = document.getElementById('dt-direct-pdf-iframe');
            if (!iframe) {
                iframe = document.createElement('iframe');
                iframe.id = 'dt-direct-pdf-iframe';
                iframe.style.position = 'fixed';
                iframe.style.right = '0';
                iframe.style.bottom = '0';
                iframe.style.width = '0';
                iframe.style.height = '0';
                iframe.style.border = 'none';
                document.body.appendChild(iframe);
            }

            const doc = iframe.contentWindow.document;
            doc.open();
            doc.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="utf-8">
                    <title>Credit Note - ${refundId}</title>
                    <style>
                        @page { size: A4; margin: 15mm; }
                        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; color: #181512; margin: 0; padding: 20px; font-size: 13px; }
                        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #8A681F; padding-bottom: 12px; margin-bottom: 16px; }
                        .logo-text { font-size: 18px; font-weight: 800; color: #181512; }
                        .badge { background: #FAF5E8; border: 1px solid #D4AF37; color: #8A681F; font-weight: 800; padding: 4px 8px; border-radius: 4px; display: inline-block; font-size: 11px; }
                        .box { background: #FAF8F4; border: 1px solid #E2DFD7; padding: 12px; border-radius: 6px; margin-bottom: 14px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
                        th, td { border: 1px solid #E2DFD7; padding: 8px 10px; text-align: left; }
                        th { background: #FAF5E8; color: #8A681F; font-weight: 800; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <div>
                            <div class="logo-text">DT BRAND'S & JAI HANUMAN TEX</div>
                            <div style="font-size:11px; color:#64748B; margin-top:3px;">Surat Wholesale Central Depot • Ring Road, Surat • GSTIN: 24AAECJ1928K1Z5</div>
                        </div>
                        <div style="text-align:right;">
                            <span class="badge">CREDIT NOTE / VOUCHER</span>
                            <div style="font-weight:800; margin-top:4px;">${refundId}</div>
                            <div style="font-size:11px; color:#64748B;">Date: 21 Aug 2026</div>
                        </div>
                    </div>
                    <div class="box">
                        <strong>Beneficiary:</strong> ${customer}<br>
                        <strong>Referenced Order:</strong> ${orderId}<br>
                        <strong>Settlement Mode:</strong> Bank Direct RTGS / B2B Credit Ledger
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Description / Item Particulars</th>
                                <th>Reason</th>
                                <th style="text-align:right;">Credit Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Consignment Return / Price Settlement (${orderId})</td>
                                <td>QC Inspected & Approved for Credit Adjustment</td>
                                <td style="text-align:right; font-weight:800; color:#DC2626;">₹${Number(amount).toLocaleString('en-IN')}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin-top:20px; text-align:right; font-weight:800; font-size:15px; color:#15803D;">
                        Total Credit Cleared: ₹${Number(amount).toLocaleString('en-IN')}
                    </div>
                    <div style="margin-top:40px; font-size:11px; color:#64748B; border-top:1px solid #E2DFD7; padding-top:8px;">
                        This is an official system-generated GST Credit Note from DT Brand's & Jai Hanuman Tex Wholesale Central Depot.
                    </div>
                </body>
                </html>
            `);
            doc.close();

            setTimeout(() => {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }, 300);
        }
    };
})();

