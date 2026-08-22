/**
 * wholesale-list.js — DT Brand's & Jai Hanuman Tex
 * Wholesale Directory Live Search, Quick Tier Filter, Dynamic Column Visibility & Sorting
 */

(function () {
    'use strict';

    // 1. Live Search & Dropdown Filtering
    window.filterWholesaleTable = function () {
        const searchInput = document.getElementById('wholesaleSearchInput');
        const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
        const tierFilter = (document.getElementById('wholesaleTierFilter')?.value || 'all').toLowerCase();
        const statusFilter = (document.getElementById('wholesaleStatusFilter')?.value || 'all').toLowerCase();

        const rows = document.querySelectorAll('#wholesaleTableBody tr.wholesale-row-item');
        let visibleCount = 0;

        rows.forEach((row) => {
            const rowTier = (row.getAttribute('data-tier') || '').toLowerCase();
            const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();
            const idText = (row.querySelector('.whl-id-cell')?.innerText || '').toLowerCase();
            const nameText = (row.querySelector('.whl-name-cell')?.innerText || '').toLowerCase();
            const contactText = (row.querySelector('.whl-contact-cell')?.innerText || '').toLowerCase();

            const matchesQuery = !query || idText.includes(query) || nameText.includes(query) || contactText.includes(query);
            const matchesTier = (tierFilter === 'all') || (rowTier === tierFilter);
            const matchesStatus = (statusFilter === 'all') || (rowStatus === statusFilter);

            if (matchesQuery && matchesTier && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const countBadge = document.getElementById('wholesaleVisibleCountBadge');
        if (countBadge) {
            countBadge.innerText = `Showing ${visibleCount} Wholesalers`;
        }
    };

    window.clearWholesaleSearch = function () {
        const searchInput = document.getElementById('wholesaleSearchInput');
        if (searchInput) {
            searchInput.value = '';
            window.filterWholesaleTable();
        }
    };

    // 2. Column Visibility / Hide-Show Management
    window.toggleWholesaleColumnMenu = function (event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        const menu = document.getElementById('wholesaleColumnVisibilityMenu');
        if (menu) {
            menu.style.display = (menu.style.display === 'none' || !menu.style.display) ? 'block' : 'none';
        }
    };

    window.toggleWholesaleColumn = function (colClass, isChecked) {
        const elements = document.querySelectorAll('.' + colClass);
        elements.forEach(function (el) {
            el.style.display = isChecked ? '' : 'none';
        });

        try {
            const hiddenCols = JSON.parse(localStorage.getItem('dt_whl_hidden_cols') || '[]');
            if (!isChecked && !hiddenCols.includes(colClass)) {
                hiddenCols.push(colClass);
            } else if (isChecked && hiddenCols.includes(colClass)) {
                const idx = hiddenCols.indexOf(colClass);
                if (idx > -1) hiddenCols.splice(idx, 1);
            }
            localStorage.setItem('dt_whl_hidden_cols', JSON.stringify(hiddenCols));
        } catch (e) {}
    };

    window.resetWholesaleColumns = function () {
        document.querySelectorAll('#wholesaleColumnVisibilityMenu input[type="checkbox"]').forEach(function (cb) {
            cb.checked = true;
            const colClass = cb.getAttribute('data-col');
            if (colClass) {
                document.querySelectorAll('.' + colClass).forEach(function (el) {
                    el.style.display = '';
                });
            }
        });
        try {
            localStorage.removeItem('dt_whl_hidden_cols');
        } catch (e) {}
        if (window.showToast) window.showToast('✓ All table columns restored');
    };

    // Restore column preferences on page load
    document.addEventListener('DOMContentLoaded', function () {
        try {
            const hiddenCols = JSON.parse(localStorage.getItem('dt_whl_hidden_cols') || '[]');
            if (Array.isArray(hiddenCols) && hiddenCols.length > 0) {
                hiddenCols.forEach(function (colClass) {
                    const cb = document.querySelector(`#wholesaleColumnVisibilityMenu input[data-col="${colClass}"]`);
                    if (cb) cb.checked = false;
                    document.querySelectorAll('.' + colClass).forEach(function (el) {
                        el.style.display = 'none';
                    });
                });
            }
        } catch (e) {}
    });

    // Close menu when clicking outside
    document.addEventListener('click', function (e) {
        const menu = document.getElementById('wholesaleColumnVisibilityMenu');
        const wrap = document.querySelector('.dt-col-dropdown-wrap');
        if (menu && wrap && !wrap.contains(e.target)) {
            menu.style.display = 'none';
        }
    });

})();
