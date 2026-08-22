/**
 * wholesale-credit.js — DT Brand's & Jai Hanuman Tex
 * Wholesale Revolving Credit Hub, Settlements & High-DPI Voucher PDF Exporter
 */

(function () {
    'use strict';

    let currentSanctioned = 500000;
    let currentUtilized = 210000;
    let currentVoucherData = {
        txnId: 'TXN-WHL-9912',
        type: 'Wholesale Saree Dispatch Debit (Order ORD-WHL-4821)',
        amount: '-₹84,500',
        date: '22 Aug 2026, 05:15 PM',
        ref: 'ORD-WHL-4821',
        actor: 'Wholesale Finance Desk'
    };

    function updateCreditMetrics() {
        const available = Math.max(0, currentSanctioned - currentUtilized);
        const utilPct = Math.min(100, Math.max(0, (currentUtilized / currentSanctioned) * 100)).toFixed(1);
        const availPct = (100 - utilPct).toFixed(1);

        const sancEl = document.getElementById('heroSanctionedLimit');
        const utilEl = document.getElementById('heroUtilizedCredit');
        const availEl = document.getElementById('heroAvailableCredit');
        const barEl = document.getElementById('creditUtilizationProgressBar');
        const pctEl = document.getElementById('progressPctText');
        const availTextEl = document.getElementById('progressAvailText');

        if (sancEl) sancEl.innerText = '₹' + currentSanctioned.toLocaleString('en-IN');
        if (utilEl) utilEl.innerText = '₹' + currentUtilized.toLocaleString('en-IN');
        if (availEl) availEl.innerText = '₹' + available.toLocaleString('en-IN');
        if (barEl) barEl.style.width = `${utilPct}%`;
        if (pctEl) pctEl.innerText = `${utilPct}% Used`;
        if (availTextEl) availTextEl.innerText = `${availPct}% (₹${available.toLocaleString('en-IN')})`;
    }

    window.openCreditAdjustmentModal = function (whlId, limit, utilized) {
        currentSanctioned = Number(limit) || 500000;
        currentUtilized = Number(utilized) || 210000;

        document.getElementById('adjustWholesaleId').value = whlId || 'WHL-8012';
        document.getElementById('adjustCurrentLimitDisplay').innerText = '₹' + currentSanctioned.toLocaleString('en-IN');
        document.getElementById('adjustCurrentUtilizedDisplay').innerText = '₹' + currentUtilized.toLocaleString('en-IN');
        document.getElementById('adjustNewLimitInput').value = currentSanctioned;
        document.getElementById('adjustReasonInput').value = '';

        window.openWholesaleModal('dtCreditAdjustmentModal');
    };

    window.submitCreditAdjustment = function (event) {
        if (event) event.preventDefault();
        const newLimit = parseFloat(document.getElementById('adjustNewLimitInput').value) || currentSanctioned;
        currentSanctioned = newLimit;
        updateCreditMetrics();

        window.closeWholesaleModal('dtCreditAdjustmentModal');
        window.showToast(`✅ Sanctioned Credit Limit updated to ₹${newLimit.toLocaleString('en-IN')}!`);
    };

    window.openRecordSettlementModal = function (whlId, utilized) {
        currentUtilized = Number(utilized) || 210000;
        document.getElementById('settleCurrentDueDisplay').innerText = '₹' + currentUtilized.toLocaleString('en-IN');
        document.getElementById('settleAmountInput').value = Math.min(100000, currentUtilized);
        document.getElementById('settleUtrInput').value = '';
        window.openWholesaleModal('dtRecordSettlementModal');
    };

    window.submitRecordSettlement = function (event) {
        if (event) event.preventDefault();
        const amount = parseFloat(document.getElementById('settleAmountInput').value) || 0;
        currentUtilized = Math.max(0, currentUtilized - amount);
        updateCreditMetrics();

        window.closeWholesaleModal('dtRecordSettlementModal');
        window.showToast(`✅ Credit settlement of ₹${amount.toLocaleString('en-IN')} recorded & credited!`);
    };

    // ── Live Filter for Wholesale Credit Ledger ──
    window.filterWholesaleCreditLedger = function () {
        const query = (document.getElementById('wholesaleLedgerSearchInput')?.value || '').toLowerCase().trim();
        const typeFilter = document.getElementById('wholesaleLedgerTypeFilter')?.value || 'all';

        const rows = document.querySelectorAll('#wholesaleCreditLedgerTbody .wholesale-ledger-row');

        rows.forEach((row) => {
            const rowType = row.getAttribute('data-type') || '';
            const idText = (row.querySelector('.wledger-id-cell')?.innerText || '').toLowerCase();
            const descText = (row.querySelector('.wledger-desc-cell')?.innerText || '').toLowerCase();

            const matchesQuery = !query || idText.includes(query) || descText.includes(query);
            const matchesType = (typeFilter === 'all') || (rowType === typeFilter);

            if (matchesQuery && matchesType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    };

    // ── Export Wholesale Ledger CSV Statement ──
    window.exportWholesaleLedgerStatement = function (whlId) {
        const cleanId = (whlId || 'WHL-8012').replace(/[^a-zA-Z0-9]/g, '');
        const rows = [
            ['Txn Reference', 'Timestamp', 'Narration / Description', 'Debit (INR)', 'Credit (INR)', 'Running Utilized (INR)', 'Available Credit (INR)'],
            ['TXN-WHL-8912', '22 Aug 2026, 05:15 PM', 'Wholesale Saree Dispatch Debit (Order ORD-WHL-8112)', '-84500', '—', '210000', '290000'],
            ['TXN-WHL-8812', '15 Aug 2026, 02:40 PM', 'NEFT Direct Bank Settlement (UTR: HDFC801288)', '—', '150000', '125500', '374500'],
            ['TXN-WHL-8712', '02 Aug 2026, 11:10 AM', 'Wholesale Festive Saree Dispatch Debit (Order ORD-WHL-8062)', '-145000', '—', '270500', '229500'],
            ['TXN-WHL-8640', '28 Jul 2026, 04:30 PM', 'RTGS Wholesaler Clearance (UTR: ICIC771920)', '—', '200000', '125500', '374500'],
            ['TXN-WHL-8500', '01 Jul 2026, 12:00 AM', 'Quarterly Revolving Limit Sanction & Renewal', '—', '500000', '0', '500000']
        ];

        let csvContent = 'data:text/csv;charset=utf-8,' + rows.map(e => e.join(',')).join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', `Wholesale_Credit_Ledger_${cleanId}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        window.showToast(`📊 Exported: Wholesale_Credit_Ledger_${cleanId}.csv`);
    };

    window.viewWholesaleVoucher = function (txnId, type, amount, date, ref, actor, partnerName, partnerGstin, partnerId) {
        currentVoucherData = {
            txnId: txnId || 'TXN-WHL-8912',
            type: type || 'Wholesale Saree Dispatch Debit (Order ORD-WHL-8112)',
            amount: amount || '-₹84,500',
            date: date || '22 Aug 2026, 05:15 PM',
            ref: ref || 'ORD-WHL-8112',
            actor: actor || 'Wholesale Finance Desk',
            partnerName: partnerName || 'Shree Balaji Silk Mills',
            partnerGstin: partnerGstin || '24AABCS1429B1Z2',
            partnerId: partnerId || 'WHL-8012'
        };

        const txnEl = document.getElementById('voucherTxnId');
        const typeEl = document.getElementById('voucherType');
        const amountEl = document.getElementById('voucherAmount');
        const dateEl = document.getElementById('voucherDate');
        const refEl = document.getElementById('voucherRef');
        const actorEl = document.getElementById('voucherActor');
        const nameEl = document.getElementById('voucherPartnerName');
        const subEl = document.getElementById('voucherPartnerSub');

        if (txnEl) txnEl.innerText = currentVoucherData.txnId;
        if (typeEl) typeEl.innerText = currentVoucherData.type;
        if (amountEl) {
            amountEl.innerText = currentVoucherData.amount;
            amountEl.style.color = currentVoucherData.amount.startsWith('-') ? '#DC2626' : '#15803D';
        }
        if (dateEl) dateEl.innerText = currentVoucherData.date;
        if (refEl) refEl.innerText = currentVoucherData.ref;
        if (actorEl) actorEl.innerText = currentVoucherData.actor;
        if (nameEl) nameEl.innerText = currentVoucherData.partnerName;
        if (subEl) subEl.innerText = `ID: ${currentVoucherData.partnerId} • GSTIN: ${currentVoucherData.partnerGstin}`;

        window.openWholesaleModal('dtVoucherModal');
    };

    // ── Print Current Voucher ──
    window.printCurrentVoucher = function () {
        window.print();
    };

    // ── 👑 100% NON-BLANK EXACT SAME UI VOUCHER PDF DOWNLOAD (.pdf) ──
    window.downloadWholesaleVoucherPdf = function () {
        const voucherEl = document.getElementById('dtPrintableVoucher');
        if (!voucherEl) {
            window.showToast('⚠️ Voucher element not found.');
            return;
        }

        const cleanTxnId = (currentVoucherData.txnId || 'TXN8912').replace(/[^a-zA-Z0-9]/g, '');
        const cleanPartnerId = (currentVoucherData.partnerId || 'WHL8012').replace(/[^a-zA-Z0-9]/g, '');
        const pdfFilename = `Wholesale_Credit_Voucher_${cleanTxnId}_${cleanPartnerId}.pdf`;

        // Create temporary visible container in viewport for html2canvas
        const renderBox = document.createElement('div');
        renderBox.id = 'dtVoucherPdfRenderContainer';
        renderBox.style.position = 'fixed';
        renderBox.style.top = '0';
        renderBox.style.left = '0';
        renderBox.style.width = '640px';
        renderBox.style.background = '#FFFFFF';
        renderBox.style.zIndex = '9999999';
        renderBox.style.padding = '12px';
        renderBox.style.boxSizing = 'border-box';
        renderBox.style.boxShadow = '0 10px 40px rgba(0,0,0,0.5)';
        renderBox.innerHTML = voucherEl.outerHTML;

        document.body.appendChild(renderBox);

        window.showToast(`📥 Downloading "${pdfFilename}"...`);

        const hasHtml2Canvas = typeof window.html2canvas === 'function';
        const jsPDFClass = (window.jspdf && window.jspdf.jsPDF) ? window.jspdf.jsPDF : (typeof window.jsPDF === 'function' ? window.jsPDF : null);

        if (hasHtml2Canvas && jsPDFClass) {
            window.html2canvas(renderBox, {
                scale: 2.5,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#FFFFFF',
                logging: false
            }).then(function (canvas) {
                if (renderBox.parentNode) {
                    renderBox.parentNode.removeChild(renderBox);
                }

                const imgData = canvas.toDataURL('image/jpeg', 0.98);
                const pdf = new jsPDFClass({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });

                const pageWidth = pdf.internal.pageSize.getWidth();
                const marginX = 10;
                const marginY = 10;
                const targetWidth = pageWidth - (marginX * 2);
                const targetHeight = (canvas.height * targetWidth) / canvas.width;

                pdf.addImage(imgData, 'JPEG', marginX, marginY, targetWidth, targetHeight);
                pdf.save(pdfFilename);
                window.showToast(`✅ Saved: "${pdfFilename}"`);
            }).catch(function (err) {
                console.error('html2canvas render error:', err);
                if (renderBox.parentNode) {
                    renderBox.parentNode.removeChild(renderBox);
                }
                window.showToast('⚠️ PDF rendering fallback triggered.');
            });
            return;
        }

        // Fallback to print
        if (renderBox.parentNode) {
            renderBox.parentNode.removeChild(renderBox);
        }
        window.print();
    };

})();
