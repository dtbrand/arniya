/**
 * reseller-filters.js — Advanced Multi-Dimension Filter Drawer
 */

(function () {
    'use strict';

    window.openResellerFiltersDrawer = function () {
        window.openModal('dtResellerFiltersModal');
    };

    window.applyResellerAdvancedFilters = function (e) {
        if (e) e.preventDefault();
        window.closeModal('dtResellerFiltersModal');
        window.showToast('✓ Advanced filters applied to Resellers list');
    };

    window.resetResellerFilters = function () {
        const form = document.getElementById('dtAdvancedFiltersForm');
        if (form) form.reset();
        window.showToast('Filters reset to default');
    };

})();
