/**
 * filters.js — Catalogue Filtering Controller
 * DT Brand's & Jai Hanuman Tex
 */

window.DT_FILTERS = {
    // Filter by status (active / inactive / all)
    applyStatusFilter: function(statusVal, tableId = 'catListTable') {
        const table = document.getElementById(tableId);
        if (!table) return;
        const rows = table.querySelectorAll('tbody tr');
        const target = (statusVal || '').toLowerCase().trim();

        let visibleCount = 0;
        rows.forEach(r => {
            const rowStatus = (r.getAttribute('data-status') || '').toLowerCase().trim();
            if (!target || rowStatus === target || target === 'all') {
                r.style.display = '';
                visibleCount++;
            } else {
                r.style.display = 'none';
            }
        });

        if (window.DT_CATALOGUE) {
            const label = target ? target.toUpperCase() : 'ALL';
            window.DT_CATALOGUE.showToast(`Filtered by status: ${label} (${visibleCount} shown)`);
        }
    },

    // Filter by category type
    applyTypeFilter: function(typeVal, tableId = 'catListTable') {
        const table = document.getElementById(tableId);
        if (!table) return;
        const rows = table.querySelectorAll('tbody tr');
        const target = (typeVal || '').toLowerCase().trim();

        rows.forEach(r => {
            const rowText = r.textContent.toLowerCase();
            if (!target || rowText.includes(target)) {
                r.style.display = '';
            } else {
                r.style.display = 'none';
            }
        });
    }
};
