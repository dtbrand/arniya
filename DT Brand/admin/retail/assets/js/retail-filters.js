/**
 * retail-filters.js — DT Brand's & Jai Hanuman Tex
 * Retail Drawer Filters & Attribute Slicing
 */

(function () {
    'use strict';

    window.toggleRetailFilterDrawer = function () {
        const drawer = document.getElementById('dtRetailFilterDrawer');
        if (drawer) {
            drawer.style.display = drawer.style.display === 'flex' ? 'none' : 'flex';
        }
    };

    window.resetRetailFilters = function () {
        document.querySelectorAll('.dt-retail-filter-input').forEach(input => {
            if (input.type === 'checkbox' || input.type === 'radio') input.checked = false;
            else input.value = '';
        });
        window.showToast('🔄 Filters cleared!');
    };

    window.applyRetailFilters = function () {
        window.toggleRetailFilterDrawer();
        window.showToast('✅ Filters applied successfully!');
    };

})();
