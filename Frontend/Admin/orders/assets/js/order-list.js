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
                countDisplay.textContent = 'Showing ' + visibleCount + ' of 1,624 Orders';
            }

            // Show empty state if 0 rows visible
            const emptyState = document.getElementById('ordersEmptyState');
            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        },

        selectStatusPill: function(statusKey, element, event) {
            if (event && !event.ctrlKey && !event.metaKey && !event.shiftKey) {
                event.preventDefault();
            } else {
                return;
            }

            // Update active pill styling
            document.querySelectorAll('.dt-flow-pill').forEach(pill => pill.classList.remove('active'));
            if (element) {
                element.classList.add('active');
                element.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            }

            // Sync with status dropdown filter
            const select = document.getElementById('statusFilterSelect');
            if (select) {
                select.value = statusKey;
            }

            // Filter table instantly in real-time
            this.filterTable();

            // Update URL in browser history silently
            const targetUrl = element ? element.getAttribute('href') : '/Frontend/Admin/orders/index.php';
            if (window.history && window.history.pushState) {
                window.history.pushState({ status: statusKey }, '', targetUrl);
            }

            // Toast notification feedback
            if (window.DT_ORDERS) {
                const count = element?.querySelector('.dt-flow-count')?.textContent || '';
                const label = element?.querySelector('.dt-flow-label')?.textContent || statusKey;
                window.DT_ORDERS.showToast(`📊 Filtered: ${label} (${count} orders)`);
            }
        },

        scrollStatusFlow: function(direction) {
            const scrollContainer = document.querySelector('.dt-status-flow-scroll');
            if (!scrollContainer) return;
            const scrollAmount = 240 * direction;
            scrollContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
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

        toggleColumnMenu: function(event) {
            if (event) event.stopPropagation();
            const menu = document.getElementById('columnVisibilityMenu');
            if (!menu) return;
            const isVisible = menu.style.display === 'block';
            menu.style.display = isVisible ? 'none' : 'block';
        },

        toggleColumn: function(colClass, isChecked) {
            const cells = document.querySelectorAll('.' + colClass);
            cells.forEach(c => c.style.display = isChecked ? '' : 'none');
            
            // Save state in localStorage
            try {
                const hiddenCols = JSON.parse(localStorage.getItem('dt_hidden_order_cols') || '{}');
                hiddenCols[colClass] = !isChecked;
                localStorage.setItem('dt_hidden_order_cols', JSON.stringify(hiddenCols));
            } catch (e) {}

            if (window.DT_ORDERS) {
                const cleanName = colClass.replace('col-', '').toUpperCase();
                window.DT_ORDERS.showToast(isChecked ? '👁️ ' + cleanName + ' column visible' : '🙈 ' + cleanName + ' column hidden');
            }
        },

        resetAllColumns: function() {
            try {
                localStorage.removeItem('dt_hidden_order_cols');
            } catch (e) {}

            const checkboxes = document.querySelectorAll('#columnVisibilityMenu input[type="checkbox"]');
            checkboxes.forEach(cb => {
                cb.checked = true;
                const colClass = cb.dataset.col;
                if (colClass) {
                    const cells = document.querySelectorAll('.' + colClass);
                    cells.forEach(c => c.style.display = '');
                }
            });

            if (window.DT_ORDERS) window.DT_ORDERS.showToast('✅ All columns restored to default view');
        },

        initColumnPreferences: function() {
            try {
                const hiddenCols = JSON.parse(localStorage.getItem('dt_hidden_order_cols') || '{}');
                Object.keys(hiddenCols).forEach(colClass => {
                    const isHidden = hiddenCols[colClass];
                    if (isHidden) {
                        const cells = document.querySelectorAll('.' + colClass);
                        cells.forEach(c => c.style.display = 'none');
                        const cb = document.querySelector(`#columnVisibilityMenu input[data-col="${colClass}"]`);
                        if (cb) cb.checked = false;
                    }
                });
            } catch (e) {}
        }
    };

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('columnVisibilityMenu');
        const wrap = document.querySelector('.dt-col-dropdown-wrap');
        if (menu && wrap && !wrap.contains(e.target)) {
            menu.style.display = 'none';
        }
    });

    // Auto-init on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => window.DT_ORDER_LIST.initColumnPreferences());
    } else {
        window.DT_ORDER_LIST.initColumnPreferences();
    }
})();
