/**
 * reseller-list.js — DT Brand's & Jai Hanuman Tex
 * Real-time Debounced Search, Multi-Filter Pipeline, Column Sorting, Row Selection & Pagination
 */

(function () {
    'use strict';

    let activeStatusFilter = 'all';
    let searchQuery = '';
    let currentSort = 'newest';

    // ── Real-Time Debounced Search ──
    let searchTimeout = null;
    window.handleResellerSearch = function (input) {
        clearTimeout(searchTimeout);
        const clearBtn = document.getElementById('dtResellerSearchClearBtn');
        if (clearBtn) {
            clearBtn.style.display = input.value.trim() ? 'flex' : 'none';
        }

        searchTimeout = setTimeout(() => {
            searchQuery = input.value.toLowerCase().trim();
            filterResellersTable();
        }, 150);
    };

    window.clearResellerSearch = function () {
        const input = document.getElementById('dtResellerSearchInput');
        if (input) input.value = '';
        const clearBtn = document.getElementById('dtResellerSearchClearBtn');
        if (clearBtn) clearBtn.style.display = 'none';
        searchQuery = '';
        filterResellersTable();
    };

    // ── Status Filter Pills ──
    window.filterResellersByStatus = function (status, btn) {
        activeStatusFilter = status;
        document.querySelectorAll('.dt-reseller-pill-btn').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');

        document.querySelectorAll('.dt-reseller-kpi-card').forEach(c => c.classList.remove('active'));
        const activeKpi = document.querySelector(`.dt-reseller-kpi-card[data-status="${status}"]`);
        if (activeKpi) activeKpi.classList.add('active');

        filterResellersTable();
    };

    // ── Sorting ──
    window.handleResellerSort = function (select) {
        currentSort = select.value;
        const tbody = document.querySelector('#dtResellersMasterTable tbody');
        if (!tbody) return;

        const rows = Array.from(tbody.querySelectorAll('.dt-reseller-row'));
        rows.sort((a, b) => {
            if (currentSort === 'name-asc') {
                return (a.getAttribute('data-name') || '').localeCompare(b.getAttribute('data-name') || '');
            } else if (currentSort === 'name-desc') {
                return (b.getAttribute('data-name') || '').localeCompare(a.getAttribute('data-name') || '');
            } else if (currentSort === 'purchase-high') {
                return Number(b.getAttribute('data-purchase') || 0) - Number(a.getAttribute('data-purchase') || 0);
            } else if (currentSort === 'purchase-low') {
                return Number(a.getAttribute('data-purchase') || 0) - Number(b.getAttribute('data-purchase') || 0);
            } else if (currentSort === 'orders-high') {
                return Number(b.getAttribute('data-orders') || 0) - Number(a.getAttribute('data-orders') || 0);
            } else if (currentSort === 'oldest') {
                return (a.getAttribute('data-joined') || '').localeCompare(b.getAttribute('data-joined') || '');
            } else {
                return (b.getAttribute('data-joined') || '').localeCompare(a.getAttribute('data-joined') || '');
            }
        });

        rows.forEach(r => tbody.appendChild(r));
        window.showToast(`Sorted by: ${select.options[select.selectedIndex].text}`);
    };

    // ── Filter Pipeline ──
    function filterResellersTable() {
        const rows = document.querySelectorAll('#dtResellersMasterTable tbody tr.dt-reseller-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const status = row.getAttribute('data-status') || '';
            const searchData = (row.getAttribute('data-search') || row.innerText || '').toLowerCase();

            let matchesStatus = (activeStatusFilter === 'all') || (status.toLowerCase() === activeStatusFilter.toLowerCase());
            let matchesSearch = !searchQuery || searchData.includes(searchQuery);

            if (matchesStatus && matchesSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const countEl = document.getElementById('dtResellerFilteredCount');
        if (countEl) {
            countEl.innerText = `Showing ${visibleCount} of ${rows.length} resellers`;
        }

        const emptyState = document.getElementById('dtResellerEmptyState');
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    // ── Checkbox & Bulk Actions ──
    window.toggleAllResellerCheckboxes = function (master) {
        const checkboxes = document.querySelectorAll('.dt-reseller-row-checkbox');
        checkboxes.forEach(cb => {
            const row = cb.closest('tr');
            if (row && row.style.display !== 'none') {
                cb.checked = master.checked;
            }
        });
        updateBulkActionBar();
    };

    window.handleRowCheckboxChange = function () {
        updateBulkActionBar();
    };

    function updateBulkActionBar() {
        const checked = document.querySelectorAll('.dt-reseller-row-checkbox:checked');
        const bar = document.getElementById('dtResellerBulkActionBar');
        const countText = document.getElementById('dtBulkSelectedCount');

        if (bar) {
            if (checked.length > 0) {
                bar.style.display = 'flex';
                if (countText) countText.innerText = `${checked.length} Resellers Selected`;
            } else {
                bar.style.display = 'none';
            }
        }
    }

    window.closeBulkActionBar = function () {
        document.querySelectorAll('.dt-reseller-row-checkbox').forEach(cb => cb.checked = false);
        const master = document.getElementById('dtResellerSelectAll');
        if (master) master.checked = false;
        updateBulkActionBar();
    };

})();
