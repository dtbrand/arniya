/**
 * filters.js — Filter Presets & Filter Drawer
 */
(function() {
    'use strict';

    window.resetFilters = function() {
        document.querySelectorAll('.dt-filter-pill-select').forEach(sel => sel.value = 'all');
        const search = document.getElementById('dtProductSearch');
        if (search) search.value = '';
        if (typeof window.filterProductTable === 'function') window.filterProductTable('');
        window.showToast('Filters reset to default.');
    };
})();
