/**
 * reseller-list.js — DT Brand's & Jai Hanuman Tex
 * Real-time Debounced Search, Multi-Filter Pipeline, Column Sorting, Row Selection, Filter Show/Hide, Visible Columns Toggle & Pagination
 */

(function () {
    'use strict';

    let activeStatusFilter = 'all';
    let activeTierFilter = 'all';
    let searchQuery = '';
    let currentSort = 'newest';
    let isStatsHidden = false;

    // ── Toggle Stats & Filters Ribbon ──
    window.toggleResellerStatsAndFilters = function () {
        const kpiGrid = document.getElementById('dtResellerKpiGrid');
        const filterStrip = document.getElementById('dtResellerFilterStrip');
        const toggleBtnText = document.getElementById('toggleStatsText');
        const toggleBtnIcon = document.getElementById('toggleStatsIcon');

        isStatsHidden = !isStatsHidden;

        if (kpiGrid) {
            kpiGrid.style.display = isStatsHidden ? 'none' : 'grid';
        }
        if (filterStrip) {
            filterStrip.style.display = isStatsHidden ? 'none' : 'flex';
        }

        if (toggleBtnText) {
            toggleBtnText.innerText = isStatsHidden ? 'Show Filters' : 'Hide Filters';
        }

        if (toggleBtnIcon) {
            if (isStatsHidden) {
                toggleBtnIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                toggleBtnIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        window.showToast(isStatsHidden ? 'Overview & Filter Strip Hidden' : 'Overview & Filter Strip Visible');
    };

    // ── Toggle Visible Columns Dropdown ──
    window.toggleResellerColumnMenu = function (event) {
        if (event) event.stopPropagation();
        const menu = document.getElementById('dtResellerColumnMenu');
        if (!menu) return;
        const isVisible = menu.style.display === 'block';
        menu.style.display = isVisible ? 'none' : 'block';
    };

    window.toggleResellerColumn = function (colClass, isChecked) {
        const cells = document.querySelectorAll('.' + colClass);
        cells.forEach(c => c.style.display = isChecked ? '' : 'none');

        // Persist in localStorage
        try {
            const hiddenCols = JSON.parse(localStorage.getItem('dt_hidden_reseller_cols') || '{}');
            hiddenCols[colClass] = !isChecked;
            localStorage.setItem('dt_hidden_reseller_cols', JSON.stringify(hiddenCols));
        } catch (e) {}

        const cleanName = colClass.replace('col-', '').toUpperCase();
        window.showToast(isChecked ? '👁️ ' + cleanName + ' column visible' : '🙈 ' + cleanName + ' column hidden');
    };

    window.resetAllResellerColumns = function () {
        try {
            localStorage.removeItem('dt_hidden_reseller_cols');
        } catch (e) {}

        const checkboxes = document.querySelectorAll('#dtResellerColumnMenu input[type="checkbox"]');
        checkboxes.forEach(cb => {
            cb.checked = true;
            const colClass = cb.dataset.col;
            if (colClass) {
                const cells = document.querySelectorAll('.' + colClass);
                cells.forEach(c => c.style.display = '');
            }
        });

        window.showToast('✅ All columns restored to default');
    };

    function restoreResellerColumnPreferences() {
        try {
            const hiddenCols = JSON.parse(localStorage.getItem('dt_hidden_reseller_cols') || '{}');
            Object.keys(hiddenCols).forEach(colClass => {
                if (hiddenCols[colClass]) {
                    const cb = document.querySelector(`#dtResellerColumnMenu input[data-col="${colClass}"]`);
                    if (cb) cb.checked = false;
                    const cells = document.querySelectorAll('.' + colClass);
                    cells.forEach(c => c.style.display = 'none');
                }
            });
        } catch (e) {}
    }

    // Auto-close Column dropdown on outside click
    document.addEventListener('click', function (e) {
        const menu = document.getElementById('dtResellerColumnMenu');
        const btn = document.getElementById('btnToggleResellerCols');
        if (menu && menu.style.display === 'block') {
            if (!menu.contains(e.target) && !btn?.contains(e.target)) {
                menu.style.display = 'none';
            }
        }
    });

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

        // Sync dropdown if exists
        const statusSelect = document.getElementById('dtResellerStatusSelect');
        if (statusSelect) {
            if (status === 'approved' || status === 'Active') statusSelect.value = 'Active';
            else if (status === 'pending' || status === 'Pending') statusSelect.value = 'Pending';
            else if (status === 'suspended' || status === 'Suspended') statusSelect.value = 'Suspended';
            else if (status === 'rejected' || status === 'Rejected') statusSelect.value = 'Rejected';
            else statusSelect.value = 'all';
        }

        document.querySelectorAll('.dt-cust-pill-btn, .dt-reseller-pill-btn').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');

        document.querySelectorAll('.dt-cust-kpi-card, .dt-reseller-kpi-card').forEach(c => c.classList.remove('active'));
        const activeKpi = document.querySelector(`.dt-cust-kpi-card[data-status="${status}"]`);
        if (activeKpi) activeKpi.classList.add('active');

        filterResellersTable();
    };

    // ── Status Dropdown Handler ──
    window.handleResellerStatusDropdown = function (status) {
        activeStatusFilter = status;
        filterResellersTable();
    };

    // ── Tier Dropdown Handler ──
    window.handleResellerTierFilter = function (tier) {
        activeTierFilter = tier;
        filterResellersTable();
    };

    // ── Sorting ──
    window.handleResellerSort = function (select) {
        currentSort = select.value || 'newest';
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
        const selectEl = typeof select === 'object' && select.options ? select.options[select.selectedIndex].text : currentSort;
        window.showToast(`Sorted by: ${selectEl}`);
    };

    // ── Filter Pipeline ──
    function filterResellersTable() {
        const rows = document.querySelectorAll('#dtResellersMasterTable tbody tr.dt-reseller-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const status = (row.getAttribute('data-status') || '').toLowerCase();
            const searchData = (row.getAttribute('data-search') || row.innerText || '').toLowerCase();

            // Status Match
            let matchesStatus = false;
            if (activeStatusFilter === 'all') {
                matchesStatus = true;
            } else if (activeStatusFilter === 'approved' || activeStatusFilter.toLowerCase() === 'active') {
                matchesStatus = (status === 'active' || status === 'approved');
            } else if (activeStatusFilter.toLowerCase() === 'pending') {
                matchesStatus = (status === 'pending');
            } else if (activeStatusFilter.toLowerCase() === 'suspended') {
                matchesStatus = (status === 'suspended');
            } else if (activeStatusFilter.toLowerCase() === 'rejected') {
                matchesStatus = (status === 'rejected');
            } else if (activeStatusFilter === 'platinum') {
                matchesStatus = searchData.includes('platinum');
            } else if (activeStatusFilter === 'credit') {
                matchesStatus = searchData.includes('credit');
            } else {
                matchesStatus = status.includes(activeStatusFilter.toLowerCase());
            }

            // Tier Match
            let matchesTier = false;
            if (activeTierFilter === 'all') {
                matchesTier = true;
            } else {
                matchesTier = searchData.includes(activeTierFilter.toLowerCase());
            }

            // Search Keyword Match
            let matchesSearch = !searchQuery || searchData.includes(searchQuery);

            if (matchesStatus && matchesTier && matchesSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const countEl = document.getElementById('dtResellerFilteredCount');
        if (countEl) {
            countEl.innerHTML = `Showing <strong>1–${visibleCount}</strong> of <strong>${rows.length}</strong> Resellers`;
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

    // Initialize Preferences
    document.addEventListener('DOMContentLoaded', () => {
        restoreResellerColumnPreferences();
    });

})();
