/**
 * order-filters.js — Advanced Filter Drawer & Date Range Presets
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    window.DT_ORDER_FILTERS = {
        openDrawer: function() {
            const drawer = document.getElementById('orderFilterDrawer');
            if (drawer) drawer.classList.add('open');
        },

        closeDrawer: function() {
            const drawer = document.getElementById('orderFilterDrawer');
            if (drawer) drawer.classList.remove('open');
        },

        applyFilters: function() {
            this.closeDrawer();
            if (window.DT_ORDER_LIST) window.DT_ORDER_LIST.filterTable();
            if (window.DT_ORDERS) window.DT_ORDERS.showToast('🔍 Advanced filters applied');
        },

        resetFilters: function() {
            const form = document.getElementById('orderFilterForm');
            if (form) form.reset();
            this.closeDrawer();
            if (window.DT_ORDER_LIST) window.DT_ORDER_LIST.filterTable();
            if (window.DT_ORDERS) window.DT_ORDERS.showToast('🔄 Filters reset to default');
        },

        setDatePreset: function(preset) {
            const now = new Date();
            let start = new Date();
            let end = new Date();

            if (preset === 'today') {
                // today
            } else if (preset === 'yesterday') {
                start.setDate(now.getDate() - 1);
                end.setDate(now.getDate() - 1);
            } else if (preset === 'last7') {
                start.setDate(now.getDate() - 7);
            } else if (preset === 'last30') {
                start.setDate(now.getDate() - 30);
            }

            const startInput = document.getElementById('filterStartDate');
            const endInput = document.getElementById('filterEndDate');
            if (startInput) startInput.value = start.toISOString().split('T')[0];
            if (endInput) endInput.value = end.toISOString().split('T')[0];

            if (window.DT_ORDERS) window.DT_ORDERS.showToast(`📅 Date preset set to: ${preset}`);
        }
    };
})();
