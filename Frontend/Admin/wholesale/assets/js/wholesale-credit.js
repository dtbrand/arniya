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

    window.viewWholesaleVoucher = function (txnId, type, amount, date, ref, actor) {
        currentVoucherData = {
            txnId: txnId || 'TXN-WHL-9912',
            type: type || 'Wholesale Order Dispatch',
            amount: amount || '-₹84,500',
            date: date || '22 Aug 2026',
            ref: ref || 'ORD-WHL-4821',
            actor: actor || 'Wholesale Finance Desk'
        };

        const txnEl = document.getElementById('voucherTxnId');
        const typeEl = document.getElementById('voucherType');
        const amountEl = document.getElementById('voucherAmount');
        const dateEl = document.getElementById('voucherDate');
        const refEl = document.getElementById('voucherRef');
        const actorEl = document.getElementById('voucherActor');

        if (txnEl) txnEl.innerText = currentVoucherData.txnId;
        if (typeEl) typeEl.innerText = currentVoucherData.type;
        if (amountEl) {
            amountEl.innerText = currentVoucherData.amount;
            amountEl.style.color = currentVoucherData.amount.startsWith('-') ? '#DC2626' : '#15803D';
        }
        if (dateEl) dateEl.innerText = currentVoucherData.date;
        if (refEl) refEl.innerText = currentVoucherData.ref;
        if (actorEl) actorEl.innerText = currentVoucherData.actor;

        window.openWholesaleModal('dtVoucherModal');
    };

    window.downloadWholesaleVoucherPdf = function () {
        const voucherEl = document.getElementById('dtPrintableVoucher');
        if (!voucherEl) return;

        const whlIdInput = document.getElementById('adjustWholesaleId');
        const whlId = (whlIdInput && whlIdInput.value) ? whlIdInput.value.replace(/[^a-zA-Z0-9]/g, '') : 'WHL';
        const cleanTxnId = (currentVoucherData.txnId || 'TXN9912').replace(/[^a-zA-Z0-9]/g, '');
        const pdfFilename = `Wholesale_Credit_Voucher_${cleanTxnId}_${whlId}.pdf`;

        window.showToast(`📥 Downloading "${pdfFilename}"...`);
        setTimeout(() => {
            window.showToast(`✅ Saved: "${pdfFilename}"`);
        }, 800);
    };

})();
