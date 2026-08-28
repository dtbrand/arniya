/**
 * refunds.js — Refund Calculation Drawer, Search, Filter & Voucher Actions
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    let currentStatusFilter = 'all';
    let currentMethodFilter = 'all';
    let currentSearchQuery = '';

    const refundRecords = {
        'REF-4012': {
            refundId: 'REF-4012',
            orderId: 'DTB-001612',
            customer: 'Meenakshi Silk House',
            contact: '+91 70463 63528',
            location: 'Surat Depot Consignment',
            payoutMethod: 'ICICI Direct Bank Transfer (Corporate RTGS)',
            originalAmount: '1,12,250',
            refundAmount: '14,940',
            remainingBalance: '97,310',
            status: 'settled',
            statusText: 'Settled',
            date: '20 Aug 2026, 04:30 PM',
            utr: 'ICICR52026082001',
            reason: 'Consignment returned to Surat depot intact and passed QC inspection.',
            authorizedBy: 'Gautam Sethi (Super Admin)'
        },
        'REF-4011': {
            refundId: 'REF-4011',
            orderId: 'DTB-001609',
            customer: 'Shweta Joshi',
            contact: '+91 70463 63528',
            location: 'Ahmedabad Retail Order',
            payoutMethod: 'UPI Reversal (PhonePe Instant)',
            originalAmount: '4,990',
            refundAmount: '4,990',
            remainingBalance: '0',
            status: 'processing',
            statusText: 'In Gateway',
            date: '19 Aug 2026, 02:15 PM',
            utr: 'UPI-291084-IN',
            reason: 'Customer cancelled order prior to courier dispatch.',
            authorizedBy: 'Auto-Gateway Trigger'
        },
        'REF-4010': {
            refundId: 'REF-4010',
            orderId: 'DTB-001605',
            customer: 'Kalyan Sarees Wholesale',
            contact: '+91 70463 63528',
            location: 'Kalyan B2B Hub',
            payoutMethod: 'B2B Wholesale Credit Ledger',
            originalAmount: '54,490',
            refundAmount: '4,490',
            remainingBalance: '50,000',
            status: 'pending',
            statusText: 'Pending Approval',
            date: '18 Aug 2026, 11:45 AM',
            utr: 'Pending Admin Authorization',
            reason: 'Loom defect claim on 2 pieces of Banarasi Katan Silk.',
            authorizedBy: 'Awaiting Final Clearance'
        },
        'REF-4009': {
            refundId: 'REF-4009',
            orderId: 'DTB-001598',
            customer: 'Vardhman Tex Godown',
            contact: '+91 70463 63528',
            location: 'Surat Central Depot',
            payoutMethod: 'HDFC Bank Wire Transfer',
            originalAmount: '2,22,500',
            refundAmount: '22,500',
            remainingBalance: '2,00,000',
            status: 'settled',
            statusText: 'Settled',
            date: '17 Aug 2026, 06:10 PM',
            utr: 'HDFCR52026081702',
            reason: 'B2B Short Shipment adjustment against Surat Central Godown invoice.',
            authorizedBy: 'Gautam Sethi (Super Admin)'
        },
        'REF-4008': {
            refundId: 'REF-4008',
            orderId: 'DTB-001590',
            customer: 'Pooja Sharma',
            contact: '+91 70463 63528',
            location: 'Mumbai Online Shop',
            payoutMethod: 'Razorpay Instant Reversal',
            originalAmount: '3,850',
            refundAmount: '3,850',
            remainingBalance: '0',
            status: 'processing',
            statusText: 'In Gateway',
            date: '16 Aug 2026, 01:20 PM',
            utr: 'RZP-REF-771920',
            reason: 'Duplicate payment on checkout payment gateway.',
            authorizedBy: 'Razorpay Webhook Auto'
        },
        'REF-4007': {
            refundId: 'REF-4007',
            orderId: 'DTB-001582',
            customer: 'Ananya Silks Bangalore',
            contact: '+91 70463 63528',
            location: 'Bangalore Commercial Hub',
            payoutMethod: 'B2B Wholesale Credit Ledger',
            originalAmount: '1,85,000',
            refundAmount: '18,200',
            remainingBalance: '1,66,800',
            status: 'settled',
            statusText: 'Settled',
            date: '15 Aug 2026, 03:50 PM',
            utr: 'CR-NOTE-SURAT-099',
            reason: 'Return of 5 Handloom sets due to shade variation; credited to balance.',
            authorizedBy: 'Gautam Sethi (Super Admin)'
        }
    };

    window.DT_REFUNDS = {
        viewRefundDetails: function(refundId) {
            const data = refundRecords[refundId] || refundRecords['REF-4012'];
            const modal = document.getElementById('viewRefundModal');
            const titleEl = document.getElementById('viewRefundIdText');
            const bodyEl = document.getElementById('viewRefundModalBody');
            const whatsappBtn = document.getElementById('viewRefundWhatsAppBtn');
            const downloadBtn = document.getElementById('viewRefundDownloadBtn');

            if (titleEl) titleEl.textContent = data.refundId;

            if (bodyEl) {
                let badgeClass = 'delivered';
                if (data.status === 'pending') badgeClass = 'pending';
                if (data.status === 'processing') badgeClass = 'processing';

                bodyEl.innerHTML = `
                    <!-- Row 1: Summary Cards -->
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px;">
                            <div style="font-size:10.5px; font-weight:800; color:#8A681F; text-transform:uppercase; margin-bottom:6px;">Beneficiary Customer</div>
                            <div style="font-size:13px; font-weight:800; color:#181512;">${data.customer}</div>
                            <div style="font-size:11.5px; color:#475569; margin-top:2px;">Phone: <strong>${data.contact}</strong></div>
                            <div style="font-size:11px; color:#64748B; margin-top:1px;">${data.location}</div>
                        </div>

                        <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px;">
                            <div style="font-size:10.5px; font-weight:800; color:#8A681F; text-transform:uppercase; margin-bottom:6px;">Settlement Gateway &amp; Audit</div>
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                <span style="font-size:11.5px; color:#64748B;">Status:</span>
                                <span class="dt-status-badge ${badgeClass}"><span class="dt-status-dot"></span><span>${data.statusText}</span></span>
                            </div>
                            <div style="font-size:11.5px; color:#475569; margin-top:4px;">Channel: <strong>${data.payoutMethod}</strong></div>
                            <div style="font-size:11px; color:#64748B; margin-top:1px;">UTR / Ref: <strong style="color:#181512;">${data.utr}</strong></div>
                        </div>
                    </div>

                    <!-- Row 2: Financial Calculation Breakdown -->
                    <div style="background:#FFFFFF; border:1.5px solid #E2DFD7; border-radius:8px; padding:14px;">
                        <div style="font-size:11px; font-weight:800; color:#181512; text-transform:uppercase; border-bottom:1px solid #E2DFD7; padding-bottom:6px; margin-bottom:10px; display:flex; justify-content:space-between;">
                            <span>Financial Valuation Breakdown</span>
                            <span>Order Ref: <a href="/admin/orders/view.php?id=${data.orderId}" style="color:#8A681F; font-weight:800; text-decoration:underline;">${data.orderId}</a></span>
                        </div>
                        <div style="display:flex; flex-direction:column; gap:6px; font-size:12px;">
                            <div style="display:flex; justify-content:space-between; color:#475569;">
                                <span>Original Invoice Amount:</span>
                                <strong style="color:#181512;">₹${data.originalAmount}</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; color:#475569;">
                                <span>Restocking / Depot Deductions:</span>
                                <span style="color:#15803D; font-weight:700;">₹0 (100% Full Credit)</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; border-top:1px dashed #E2DFD7; padding-top:6px; margin-top:2px; font-weight:800; font-size:13.5px; color:#DC2626;">
                                <span>Authorized Refund Valuation:</span>
                                <span>₹${data.refundAmount}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:11.5px; color:#15803D; font-weight:700; margin-top:2px;">
                                <span>Remaining Order Ledger Balance:</span>
                                <span>₹${data.remainingBalance}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Internal Remarks & Audit -->
                    <div style="background:#FAF5E8; border:1px solid #D4AF37; border-radius:8px; padding:10px 14px; font-size:11.5px;">
                        <div style="color:#8A681F; font-weight:800; margin-bottom:2px;">QC &amp; Authorization Remarks:</div>
                        <div style="color:#181512;">${data.reason}</div>
                        <div style="font-size:10.5px; color:#64748B; margin-top:4px;">Date: ${data.date} • Authorized By: <strong>${data.authorizedBy}</strong></div>
                    </div>
                `;
            }

            if (whatsappBtn) {
                whatsappBtn.onclick = function() {
                    window.DT_REFUNDS.shareWhatsApp(data.refundId, data.refundAmount.replace(/,/g, ''), data.customer);
                };
            }

            if (downloadBtn) {
                downloadBtn.onclick = function() {
                    window.DT_REFUNDS.downloadCreditNotePDF(data.refundId, data.orderId, data.refundAmount.replace(/,/g, ''), data.customer);
                };
            }

            if (modal) modal.style.display = 'flex';
        },

        closeViewRefundModal: function() {
            const modal = document.getElementById('viewRefundModal');
            if (modal) modal.style.display = 'none';
        },

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

            if (refundRecords[refundId]) {
                refundRecords[refundId].status = 'settled';
                refundRecords[refundId].statusText = 'Settled';
                refundRecords[refundId].utr = 'CR-NOTE-SURAT-' + Math.floor(100 + Math.random() * 900);
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
        },

        toggleColumnMenu: function(event) {
            if (event) event.stopPropagation();
            const menu = document.getElementById('refundColumnVisibilityMenu');
            if (!menu) return;
            const isVisible = menu.style.display === 'block';
            menu.style.display = isVisible ? 'none' : 'block';
        },

        toggleColumn: function(colClass, isChecked) {
            const cells = document.querySelectorAll('.' + colClass);
            cells.forEach(c => c.style.display = isChecked ? '' : 'none');
            
            try {
                const hiddenCols = JSON.parse(localStorage.getItem('dt_hidden_refund_cols') || '{}');
                hiddenCols[colClass] = !isChecked;
                localStorage.setItem('dt_hidden_refund_cols', JSON.stringify(hiddenCols));
            } catch (e) {}

            if (window.DT_ORDERS) {
                const cleanName = colClass.replace('col-ref-', '').toUpperCase();
                window.DT_ORDERS.showToast(isChecked ? '👁️ ' + cleanName + ' column visible' : '🙈 ' + cleanName + ' column hidden');
            }
        },

        resetAllColumns: function() {
            try {
                localStorage.removeItem('dt_hidden_refund_cols');
            } catch (e) {}

            const checkboxes = document.querySelectorAll('#refundColumnVisibilityMenu input[type="checkbox"]');
            checkboxes.forEach(cb => {
                cb.checked = true;
                const colClass = cb.dataset.col;
                if (colClass) {
                    const cells = document.querySelectorAll('.' + colClass);
                    cells.forEach(c => c.style.display = '');
                }
            });

            if (window.DT_ORDERS) window.DT_ORDERS.showToast('✅ All refund columns restored to default view');
        },

        initColumnPreferences: function() {
            try {
                const hiddenCols = JSON.parse(localStorage.getItem('dt_hidden_refund_cols') || '{}');
                Object.keys(hiddenCols).forEach(colClass => {
                    const isHidden = hiddenCols[colClass];
                    if (isHidden) {
                        const cells = document.querySelectorAll('.' + colClass);
                        cells.forEach(c => c.style.display = 'none');
                        const cb = document.querySelector(`#refundColumnVisibilityMenu input[data-col="${colClass}"]`);
                        if (cb) cb.checked = false;
                    }
                });
            } catch (e) {}
        }
    };

    // Close column dropdown menu when clicking outside
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('refundColumnVisibilityMenu');
        const wrap = document.querySelector('.dt-col-dropdown-wrap');
        if (menu && wrap && !wrap.contains(e.target)) {
            menu.style.display = 'none';
        }
    });

    // Auto-init on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => window.DT_REFUNDS.initColumnPreferences());
    } else {
        window.DT_REFUNDS.initColumnPreferences();
    }
})();


