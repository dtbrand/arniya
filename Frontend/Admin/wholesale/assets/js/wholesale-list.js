/**
 * wholesale-list.js — DT Brand's & Jai Hanuman Tex
 * Wholesale Directory Live Search, Quick Tier Filter & Sorting
 */

(function () {
    'use strict';

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

})();
