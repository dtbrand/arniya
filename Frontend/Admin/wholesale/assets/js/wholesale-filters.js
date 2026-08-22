/**
 * wholesale-filters.js — DT Brand's & Jai Hanuman Tex
 * Multi-Facet Filter Drawer & Reset Engine
 */

(function () {
    'use strict';

    window.toggleAdvancedFilters = function () {
        const filterBox = document.getElementById('dtWholesaleAdvancedFiltersBox');
        if (filterBox) {
            filterBox.style.display = filterBox.style.display === 'none' ? 'block' : 'none';
        }
    };

    window.resetAdvancedFilters = function () {
        const form = document.getElementById('wholesaleFilterForm');
        if (form) form.reset();
        if (typeof window.filterWholesaleTable === 'function') window.filterWholesaleTable();
        window.showToast('✓ Filter criteria reset to default');
    };

})();
