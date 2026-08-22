/**
 * reseller-commission.js — DT Brand's & Jai Hanuman Tex
 * Commission Approval, Weekly Batch Disbursal & High-DPI Payout Advice PDF Generator
 */

(function () {
    'use strict';

    let currentAdviceData = {
        commId: 'COMM-3028',
        orderId: 'ORD-9831',
        amount: '6420',
        date: '18 Aug 2026',
        plan: '10% Tier Bonus',
        bankRef: 'UTR #NEFT998241029'
    };

    let totalDisbursed = 42500;
    let pendingSettlement = 3200;

    // ── Open Single Settle Modal ──
    window.openSettleCommissionModal = function (commId, orderId, amount, rate) {
        document.getElementById('settleCommId').value = commId;
        document.getElementById('settleCommIdDisplay').innerText = commId;
        document.getElementById('settleOrderDisplay').innerText = `Order: ${orderId} (${rate})`;
        document.getElementById('settleAmountDisplay').innerText = '₹' + Number(amount).toLocaleString('en-IN');
        document.getElementById('settleUtrInput').value = '';

        const modal = document.getElementById('dtSettleCommissionModal');
        if (modal) modal.style.display = 'flex';
    };

    window.submitSettleCommission = function (event) {
        if (event) event.preventDefault();

        const commId = document.getElementById('settleCommId').value;
        const utr = document.getElementById('settleUtrInput').value.trim() || 'NEFT' + Math.floor(100000000 + Math.random() * 900000000);

        const row = document.getElementById(commId);
        if (row) {
            row.setAttribute('data-status', 'paid');
            const statusCell = row.querySelector('.comm-status-cell');
            const actionCell = row.querySelector('.comm-action-cell');
            const amountCell = row.querySelector('.comm-amount-cell');
            const orderCell = row.querySelector('.comm-order-cell span');
            const rateCell = row.querySelector('.comm-rate-cell');

            const orderId = orderCell ? orderCell.innerText : 'ORD-9842';
            const rate = rateCell ? rateCell.innerText : '8% Dropship Incentive';
            const amountNum = amountCell ? parseFloat(amountCell.innerText.replace(/[^0-9]/g, '')) || 3200 : 3200;

            if (statusCell) {
                statusCell.innerHTML = `
                    <span class="dt-status-pill-clean emerald">
                        <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>PAID (BANK NEFT)</span>
                    </span>
                `;
            }

            if (actionCell) {
                actionCell.innerHTML = `
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="viewPayoutAdvice('${commId}', '${orderId}', '${amountNum}', 'Today', '${rate}', 'UTR #${utr}')">
                        <span>Payout Advice</span>
                    </button>
                `;
            }

            // Adjust KPI
            totalDisbursed += amountNum;
            pendingSettlement = Math.max(0, pendingSettlement - amountNum);

            const disbEl = document.getElementById('kpiTotalDisbursed');
            const pendEl = document.getElementById('kpiPendingSettlement');
            if (disbEl) disbEl.innerText = '₹' + totalDisbursed.toLocaleString('en-IN');
            if (pendEl) pendEl.innerText = '₹' + pendingSettlement.toLocaleString('en-IN');
        }

        window.closeCommModal('dtSettleCommissionModal');
        window.showToast(`✅ Commission "${commId}" settled via Bank NEFT (UTR: #${utr})`);
    };

    // ── Open Batch Modal ──
    window.openBatchDisburseModal = function () {
        const modal = document.getElementById('dtDisburseBatchModal');
        if (modal) modal.style.display = 'flex';
    };

    window.executeBatchDisbursement = function () {
        const pendingRows = document.querySelectorAll('#commissionTbody tr[data-status="pending"]');

        pendingRows.forEach((row) => {
            const commId = row.id;
            const utr = 'NEFT' + Math.floor(100000000 + Math.random() * 900000000);
            row.setAttribute('data-status', 'paid');

            const statusCell = row.querySelector('.comm-status-cell');
            const actionCell = row.querySelector('.comm-action-cell');
            const amountCell = row.querySelector('.comm-amount-cell');
            const orderCell = row.querySelector('.comm-order-cell span');
            const rateCell = row.querySelector('.comm-rate-cell');

            const orderId = orderCell ? orderCell.innerText : 'ORD-9842';
            const rate = rateCell ? rateCell.innerText : '8% Dropship Incentive';
            const amountNum = amountCell ? parseFloat(amountCell.innerText.replace(/[^0-9]/g, '')) || 3200 : 3200;

            if (statusCell) {
                statusCell.innerHTML = `
                    <span class="dt-status-pill-clean emerald">
                        <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>PAID (BANK NEFT)</span>
                    </span>
                `;
            }

            if (actionCell) {
                actionCell.innerHTML = `
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="viewPayoutAdvice('${commId}', '${orderId}', '${amountNum}', 'Today', '${rate}', 'UTR #${utr}')">
                        <span>Payout Advice</span>
                    </button>
                `;
            }

            totalDisbursed += amountNum;
        });

        pendingSettlement = 0;
        const disbEl = document.getElementById('kpiTotalDisbursed');
        const pendEl = document.getElementById('kpiPendingSettlement');
        if (disbEl) disbEl.innerText = '₹' + totalDisbursed.toLocaleString('en-IN');
        if (pendEl) pendEl.innerText = '₹0';

        window.closeCommModal('dtDisburseBatchModal');
        window.showToast('✅ All pending weekly commission payouts disbursed via automated ICICI Payout Gateway!');
    };

    // ── Live Filter Commissions ──
    window.filterCommissions = function () {
        const query = (document.getElementById('commSearchInput')?.value || '').toLowerCase().trim();
        const statusFilter = document.getElementById('commStatusFilter')?.value || 'all';

        const rows = document.querySelectorAll('#commissionTbody .comm-row-item');

        rows.forEach((row) => {
            const rowStatus = row.getAttribute('data-status') || '';
            const idText = (row.querySelector('.comm-id-cell')?.innerText || '').toLowerCase();
            const orderText = (row.querySelector('.comm-order-cell')?.innerText || '').toLowerCase();
            const rateText = (row.querySelector('.comm-rate-cell')?.innerText || '').toLowerCase();

            const matchesQuery = !query || idText.includes(query) || orderText.includes(query) || rateText.includes(query);
            const matchesStatus = (statusFilter === 'all') || (rowStatus === statusFilter);

            if (matchesQuery && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    };

    // ── View Payout Advice ──
    window.viewPayoutAdvice = function (commId, orderId, amount, date, plan, bankRef) {
        currentAdviceData = {
            commId: commId || 'COMM-3028',
            orderId: orderId || 'ORD-9831',
            amount: String(amount || '6420'),
            date: date || '18 Aug 2026',
            plan: plan || '10% Tier Bonus',
            bankRef: bankRef || 'UTR #NEFT998241029'
        };

        const idEl = document.getElementById('adviceCommId');
        const orderEl = document.getElementById('adviceOrder');
        const amountEl = document.getElementById('adviceAmount');
        const dateEl = document.getElementById('adviceDate');
        const planEl = document.getElementById('advicePlan');
        const bankEl = document.getElementById('adviceBankRef');

        if (idEl) idEl.innerText = currentAdviceData.commId;
        if (orderEl) orderEl.innerText = currentAdviceData.orderId;
        if (amountEl) amountEl.innerText = '+₹' + Number(currentAdviceData.amount).toLocaleString('en-IN');
        if (dateEl) dateEl.innerText = currentAdviceData.date;
        if (planEl) planEl.innerText = currentAdviceData.plan;
        if (bankEl) bankEl.innerText = currentAdviceData.bankRef;

        const modal = document.getElementById('dtPayoutAdviceModal');
        if (modal) modal.style.display = 'flex';
    };

    // ── 👑 100% NON-BLANK EXACT SAME UI PAYOUT ADVICE PDF DOWNLOAD (.pdf) ──
    window.downloadAdvicePdf = function () {
        const adviceEl = document.getElementById('dtPrintableAdvice');
        if (!adviceEl) {
            window.showToast('⚠️ Advice element not found.');
            return;
        }

        const cleanCommId = (currentAdviceData.commId || 'COMM3028').replace(/[^a-zA-Z0-9]/g, '');
        const pdfFilename = `Commission_Payout_Advice_${cleanCommId}_RES1048.pdf`;

        // Create temporary visible render container in viewport for html2canvas
        const renderBox = document.createElement('div');
        renderBox.id = 'dtAdvicePdfRenderContainer';
        renderBox.style.position = 'fixed';
        renderBox.style.top = '0';
        renderBox.style.left = '0';
        renderBox.style.width = '640px';
        renderBox.style.background = '#FFFFFF';
        renderBox.style.zIndex = '9999999';
        renderBox.style.padding = '12px';
        renderBox.style.boxSizing = 'border-box';
        renderBox.style.boxShadow = '0 10px 40px rgba(0,0,0,0.5)';
        renderBox.innerHTML = adviceEl.outerHTML;

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

        // Fallback
        if (renderBox.parentNode) {
            renderBox.parentNode.removeChild(renderBox);
        }
        window.print();
    };

    // ── Close Modals Helper ──
    window.closeCommModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = 'none';
    };

})();
