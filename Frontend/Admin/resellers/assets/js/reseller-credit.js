/**
 * reseller-credit.js — DT Brand's & Jai Hanuman Tex
 * B2B Revolving Credit Hub, Live Ledger Search, Settlement Engine & Voucher Generator
 */

(function () {
    'use strict';

    let currentSanctioned = 150000;
    let currentUtilized = 65000;

    // ── Helper to Update Hero Metrics & Progress Bar ──
    function updateHeroCreditMetrics() {
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

    // ── Open Credit Adjustment Modal ──
    window.openCreditAdjustmentModal = function (resellerId, limit, utilized) {
        currentSanctioned = Number(limit) || 150000;
        currentUtilized = Number(utilized) || 65000;

        document.getElementById('adjustResellerId').value = resellerId || 'RES-1048';
        document.getElementById('adjustCurrentLimitDisplay').innerText = '₹' + currentSanctioned.toLocaleString('en-IN');
        document.getElementById('adjustCurrentUtilizedDisplay').innerText = '₹' + currentUtilized.toLocaleString('en-IN');
        document.getElementById('adjustNewLimitInput').value = currentSanctioned;
        document.getElementById('adjustReasonInput').value = '';

        const modal = document.getElementById('dtCreditAdjustmentModal');
        if (modal) modal.style.display = 'flex';
    };

    window.submitCreditAdjustment = function (event) {
        if (event) event.preventDefault();

        const newLimit = parseFloat(document.getElementById('adjustNewLimitInput').value) || currentSanctioned;
        const reason = document.getElementById('adjustReasonInput').value.trim() || 'Annual Partner Limit Review';

        currentSanctioned = newLimit;
        updateHeroCreditMetrics();

        // Add a ledger audit entry
        const tbody = document.getElementById('creditLedgerTbody');
        if (tbody) {
            const tr = document.createElement('tr');
            tr.className = 'ledger-row-item';
            tr.setAttribute('data-type', 'renewal');
            tr.style.borderBottom = '1px solid #F1ECE1';

            const newTxnId = 'TXN-' + Math.floor(1000 + Math.random() * 9000);
            const nowStr = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
            const avail = Math.max(0, currentSanctioned - currentUtilized);

            tr.innerHTML = `
                <td class="ledger-id-cell" style="font-family:monospace; font-weight:800; color:#8A681F;">${newTxnId}</td>
                <td style="color:#78716C; font-size:0.72rem; white-space:nowrap;">${nowStr}</td>
                <td class="ledger-desc-cell" style="font-weight:700; color:#181512;">
                    <div style="display:flex; flex-direction:column;">
                        <span>Sanctioned Credit Limit Adjusted</span>
                        <small style="font-size:0.68rem; color:#78716C; font-weight:600; font-family:monospace;">${reason}</small>
                    </div>
                </td>
                <td style="text-align:right; font-weight:800; font-size:0.85rem; color:#15803D; white-space:nowrap;">+₹${newLimit.toLocaleString('en-IN')}</td>
                <td style="text-align:right; font-weight:800; color:#181512; white-space:nowrap;">₹${currentUtilized.toLocaleString('en-IN')}</td>
                <td style="text-align:right; font-weight:800; color:#15803D; white-space:nowrap;">₹${avail.toLocaleString('en-IN')}</td>
                <td><span class="dt-reseller-badge emerald" style="font-size:0.68rem; font-weight:800;">✓ Completed</span></td>
                <td style="color:#78716C; font-size:0.72rem;">Admin Gautam</td>
                <td style="text-align:right; white-space:nowrap;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="viewTxnVoucher('${newTxnId}', 'Credit Limit Adjusted', '₹${newLimit.toLocaleString('en-IN')}', '${nowStr}', '${reason}', 'Admin Gautam')">
                        <span>Voucher</span>
                    </button>
                </td>
            `;
            tbody.prepend(tr);
        }

        window.closeCreditModal('dtCreditAdjustmentModal');
        window.showToast(`✅ Sanctioned Credit Limit updated to ₹${newLimit.toLocaleString('en-IN')}!`);
    };

    // ── Open Record Settlement Modal ──
    window.openRecordSettlementModal = function (resellerId, utilized) {
        currentUtilized = Number(utilized) || 65000;

        document.getElementById('settleCurrentDueDisplay').innerText = '₹' + currentUtilized.toLocaleString('en-IN');
        document.getElementById('settleAmountInput').value = Math.min(50000, currentUtilized);
        document.getElementById('settleUtrInput').value = '';
        document.getElementById('settleModeSelect').value = 'NEFT/RTGS';

        const modal = document.getElementById('dtRecordSettlementModal');
        if (modal) modal.style.display = 'flex';
    };

    window.submitRecordSettlement = function (event) {
        if (event) event.preventDefault();

        const amount = parseFloat(document.getElementById('settleAmountInput').value) || 0;
        const utr = document.getElementById('settleUtrInput').value.trim() || 'CASH-REC-' + Math.floor(1000 + Math.random() * 9000);
        const mode = document.getElementById('settleModeSelect').value;

        if (amount <= 0) {
            window.showToast('⚠️ Please enter a valid settlement amount.');
            return;
        }

        currentUtilized = Math.max(0, currentUtilized - amount);
        updateHeroCreditMetrics();

        // Add row in ledger
        const tbody = document.getElementById('creditLedgerTbody');
        if (tbody) {
            const tr = document.createElement('tr');
            tr.className = 'ledger-row-item';
            tr.setAttribute('data-type', 'credit');
            tr.style.borderBottom = '1px solid #F1ECE1';

            const newTxnId = 'TXN-' + Math.floor(1000 + Math.random() * 9000);
            const nowStr = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
            const avail = Math.max(0, currentSanctioned - currentUtilized);

            tr.innerHTML = `
                <td class="ledger-id-cell" style="font-family:monospace; font-weight:800; color:#8A681F;">${newTxnId}</td>
                <td style="color:#78716C; font-size:0.72rem; white-space:nowrap;">${nowStr}</td>
                <td class="ledger-desc-cell" style="font-weight:700; color:#181512;">
                    <div style="display:flex; flex-direction:column;">
                        <span>Credit Settlement (${mode})</span>
                        <small style="font-size:0.68rem; color:#78716C; font-weight:600; font-family:monospace;">UTR #${utr}</small>
                    </div>
                </td>
                <td style="text-align:right; font-weight:800; font-size:0.85rem; color:#15803D; white-space:nowrap;">+₹${amount.toLocaleString('en-IN')}</td>
                <td style="text-align:right; font-weight:800; color:#181512; white-space:nowrap;">₹${currentUtilized.toLocaleString('en-IN')}</td>
                <td style="text-align:right; font-weight:800; color:#15803D; white-space:nowrap;">₹${avail.toLocaleString('en-IN')}</td>
                <td><span class="dt-reseller-badge emerald" style="font-size:0.68rem; font-weight:800;">✓ Settled</span></td>
                <td style="color:#78716C; font-size:0.72rem;">Accounts Desk</td>
                <td style="text-align:right; white-space:nowrap;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="viewTxnVoucher('${newTxnId}', 'Credit Settlement (${mode})', '+₹${amount.toLocaleString('en-IN')}', '${nowStr}', 'UTR #${utr}', 'Accounts Desk')">
                        <span>Voucher</span>
                    </button>
                </td>
            `;
            tbody.prepend(tr);
        }

        window.closeCreditModal('dtRecordSettlementModal');
        window.showToast(`✅ Payment of ₹${amount.toLocaleString('en-IN')} recorded & credited!`);
    };

    // ── Live Filter for Credit Ledger ──
    window.filterCreditLedger = function () {
        const query = (document.getElementById('ledgerSearchInput')?.value || '').toLowerCase().trim();
        const typeFilter = document.getElementById('ledgerTypeFilter')?.value || 'all';

        const rows = document.querySelectorAll('#creditLedgerTbody .ledger-row-item');

        rows.forEach((row) => {
            const rowType = row.getAttribute('data-type') || '';
            const idText = (row.querySelector('.ledger-id-cell')?.innerText || '').toLowerCase();
            const descText = (row.querySelector('.ledger-desc-cell')?.innerText || '').toLowerCase();

            const matchesQuery = !query || idText.includes(query) || descText.includes(query);
            const matchesType = (typeFilter === 'all') || (rowType === typeFilter);

            if (matchesQuery && matchesType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    };

    // ── View Digital Audit Voucher Modal ──
    window.viewTxnVoucher = function (txnId, type, amount, date, ref, actor) {
        document.getElementById('voucherTxnId').innerText = txnId;
        document.getElementById('voucherType').innerText = type;
        document.getElementById('voucherAmount').innerText = amount;
        document.getElementById('voucherDate').innerText = date;
        document.getElementById('voucherRef').innerText = ref;
        document.getElementById('voucherActor').innerText = actor;

        const modal = document.getElementById('dtVoucherModal');
        if (modal) modal.style.display = 'flex';
    };

    // ── Export Ledger CSV Statement ──
    window.exportLedgerStatement = function () {
        const rows = [
            ['Transaction ID', 'Date & Time', 'Description', 'Amount (INR)', 'Running Utilized', 'Authorized By'],
            ['TXN-8821', '20 Aug 2026', 'Debit (Order ORD-9842)', '-14800', '65000', 'Automated Order Checkout'],
            ['TXN-8790', '15 Aug 2026', 'Credit Settlement (ICICI Bank Transfer)', '50000', '50200', 'Staff Rajesh (UTR #99824)'],
            ['TXN-8765', '10 Aug 2026', 'Debit (Order ORD-9780 - Silk Lot)', '-38200', '100200', 'B2B Wholesale Portal'],
            ['TXN-8740', '05 Aug 2026', 'Advance RTGS Settlement (HDFC)', '40000', '62000', 'Finance Desk'],
            ['TXN-8712', '01 Aug 2026', 'Monthly Limit Renewal', '150000', '0', 'System Cron']
        ];

        let csvContent = 'data:text/csv;charset=utf-8,' + rows.map(e => e.join(',')).join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'Reseller_Credit_Ledger_RES1048.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        window.showToast('📥 Downloading "Reseller_Credit_Ledger_RES1048.csv"...');
    };

    // ── Close Modals Helper ──
    window.closeCreditModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = 'none';
    };

})();
