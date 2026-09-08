/**
 * orders.js — Master Order Management Controller & State Engine
 * DT Brand's & Jai Hanuman Tex
 */

(function(window) {
    'use strict';

    const DT_ORDERS = {
        orders: (window.SERVER_ORDERS && Array.isArray(window.SERVER_ORDERS)) ? window.SERVER_ORDERS : [],

        showToast: function(message, _type) {
            const existing = document.getElementById('dtToastContainer');
            if (existing) existing.remove();

            const toast = document.createElement('div');
            toast.id = 'dtToastContainer';
            toast.style.cssText = 'position:fixed; bottom:24px; right:24px; background:linear-gradient(135deg, #181512 0%, #2A241E 100%); color:#FAF5E8; border:1px solid #8A681F; border-radius:8px; padding:12px 18px; font-size:12.5px; font-weight:700; display:flex; align-items:center; gap:10px; z-index:999999; box-shadow:0 6px 20px rgba(0,0,0,0.35); animation:dtToastIn 0.25s ease-out; font-family:"Plus Jakarta Sans", sans-serif;';
            
            toast.innerHTML = `
                <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#16A34A; box-shadow:0 0 8px #16A34A;"></span>
                <span>${message}</span>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3200);
        },

        copyText: function(text, label) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text);
            } else {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                textArea.remove();
            }
            this.showToast((label || 'Text') + ' copied to clipboard.');
        },

        syncCountersAfterDeletion: function(deletedIds) {
            if (!Array.isArray(deletedIds) || deletedIds.length === 0) return;
            const delSet = new Set(deletedIds.map(String));

            // 1. Filter in-memory orders array
            if (Array.isArray(this.orders)) {
                this.orders = this.orders.filter(o => !delSet.has(String(o.id)));
            }
            if (Array.isArray(window.SERVER_ORDERS)) {
                window.SERVER_ORDERS = window.SERVER_ORDERS.filter(o => !delSet.has(String(o.id)));
            }

            // 2. Count remaining rows in DOM
            const remainingRows = document.querySelectorAll('#ordersTableBody tr.dt-order-row:not([data-deleted="true"])');
            const totalCount = remainingRows.length;

            // 3. Update Page Header Title Counter Badge ("X Total Orders")
            const titleBadgeStrong = document.querySelector('.dt-title-counter-badge strong');
            if (titleBadgeStrong) {
                titleBadgeStrong.textContent = totalCount.toLocaleString();
            }

            // 4. Update Tier-1 KPI Ribbon (Card 1: TOTAL ORDERS)
            const kpiTotalCardNum = document.querySelector('.dt-master-kpi-grid .dt-master-kpi-card:nth-child(1) .dt-kpi-main-number');
            if (kpiTotalCardNum) {
                kpiTotalCardNum.textContent = totalCount.toLocaleString();
            }

            // 5. Update Status Flow Pills
            const statusCounts = { all: totalCount };
            remainingRows.forEach(row => {
                const st = (row.getAttribute('data-status') || '').toLowerCase();
                if (st) {
                    statusCounts[st] = (statusCounts[st] || 0) + 1;
                }
            });

            document.querySelectorAll('.dt-flow-pill').forEach(pill => {
                const key = pill.getAttribute('data-status');
                const countEl = pill.querySelector('.dt-flow-count');
                if (countEl && key) {
                    const count = statusCounts[key] !== undefined ? statusCounts[key] : 0;
                    countEl.textContent = count;
                }
            });

            // 6. Update Active Fulfillment (Card 2), Transit (Card 3), Delivered (Card 4)
            const pendingTotal = (statusCounts['pending'] || 0) + (statusCounts['processing'] || 0) + (statusCounts['confirmed'] || 0) + (statusCounts['packed'] || 0);
            const transitTotal = (statusCounts['shipped'] || 0) + (statusCounts['out_for_delivery'] || 0);
            const deliveredTotal = statusCounts['delivered'] || 0;

            const card2Num = document.querySelector('.dt-master-kpi-grid .dt-master-kpi-card:nth-child(2) .dt-kpi-main-number');
            if (card2Num) card2Num.textContent = pendingTotal.toLocaleString();

            const card3Num = document.querySelector('.dt-master-kpi-grid .dt-master-kpi-card:nth-child(3) .dt-kpi-main-number');
            if (card3Num) card3Num.textContent = transitTotal.toLocaleString();

            const card4Num = document.querySelector('.dt-master-kpi-grid .dt-master-kpi-card:nth-child(4) .dt-kpi-main-number');
            if (card4Num) card4Num.textContent = deliveredTotal.toLocaleString();

            // 7. Update Search count display ("Showing X of Y Orders")
            if (window.DT_ORDER_LIST && typeof window.DT_ORDER_LIST.filterTable === 'function') {
                window.DT_ORDER_LIST.filterTable();
            } else {
                const countDisplay = document.getElementById('ordersCountDisplay');
                if (countDisplay) {
                    countDisplay.textContent = `Showing ${totalCount} of ${totalCount} Orders`;
                }
            }

            // 8. Empty state toggle
            const emptyState = document.getElementById('ordersEmptyState');
            if (emptyState) {
                emptyState.style.display = totalCount === 0 ? 'block' : 'none';
            }
        }
    };

    window.DT_ORDERS = DT_ORDERS;
})(window);
