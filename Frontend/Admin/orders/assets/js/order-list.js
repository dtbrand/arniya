/**
 * order-list.js — Table Search, Multi-Filter, Sorting & Column Visibility
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    window.DT_ORDER_LIST = {
        filterTable: function() {
            const query = (document.getElementById('orderSearchInput')?.value || '').toLowerCase().trim();
            const statusFilter = (document.getElementById('statusFilterSelect')?.value || '').toLowerCase();
            const paymentFilter = (document.getElementById('paymentFilterSelect')?.value || '').toLowerCase();
            const rows = document.querySelectorAll('#ordersTableBody tr.dt-order-row');

            let visibleCount = 0;

            rows.forEach(row => {
                const orderId = (row.dataset.id || '').toLowerCase();
                const customer = (row.dataset.customer || '').toLowerCase();
                const phone = (row.dataset.phone || '').toLowerCase();
                const status = (row.dataset.status || '').toLowerCase();
                const payment = (row.dataset.payment || '').toLowerCase();

                const matchesQuery = !query || orderId.includes(query) || customer.includes(query) || phone.includes(query);
                const matchesStatus = !statusFilter || statusFilter === 'all' || status === statusFilter;
                const matchesPayment = !paymentFilter || paymentFilter === 'all' || payment === paymentFilter;

                if (matchesQuery && matchesStatus && matchesPayment) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update visible counts
            const countDisplay = document.getElementById('ordersCountDisplay');
            if (countDisplay) {
                countDisplay.textContent = visibleCount + ' Orders Displayed';
            }

            // Show empty state if 0 rows visible
            const emptyState = document.getElementById('ordersEmptyState');
            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        },

        clearSearch: function() {
            const input = document.getElementById('orderSearchInput');
            if (input) {
                input.value = '';
                input.focus();
            }
            const clearBtn = document.getElementById('orderSearchClear');
            if (clearBtn) clearBtn.classList.remove('visible');
            this.filterTable();
        },

        toggleColumn: function(colClass, isChecked) {
            const cells = document.querySelectorAll('.' + colClass);
            cells.forEach(c => c.style.display = isChecked ? '' : 'none');
            if (window.DT_ORDERS) window.DT_ORDERS.showToast('⚙️ Column visibility updated');
        }
    };
})();
