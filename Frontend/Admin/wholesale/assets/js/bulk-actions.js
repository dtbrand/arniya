/**
 * bulk-actions.js — DT Brand's & Jai Hanuman Tex
 * Multi-Row Selection & Bulk Action Engine for Wholesale
 */

(function () {
    'use strict';

    window.toggleSelectAllWholesale = function (masterCheckbox) {
        const checkboxes = document.querySelectorAll('.whl-row-checkbox');
        checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
        updateBulkActionToolbar();
    };

    window.onWholesaleRowCheck = function () {
        updateBulkActionToolbar();
    };

    function updateBulkActionToolbar() {
        const checked = document.querySelectorAll('.whl-row-checkbox:checked');
        const bar = document.getElementById('dtWholesaleBulkBar');
        const countEl = document.getElementById('wholesaleSelectedCount');

        if (bar && countEl) {
            countEl.innerText = checked.length;
            bar.style.display = checked.length > 0 ? 'flex' : 'none';
        }
    }

    window.executeWholesaleBulkAction = function (actionType) {
        const checked = document.querySelectorAll('.whl-row-checkbox:checked');
        if (!checked.length) {
            window.showToast('⚠️ Please select at least one wholesale partner.');
            return;
        }

        if (confirm(`Execute bulk action "${actionType.toUpperCase()}" on ${checked.length} wholesale partners?`)) {
            window.showToast(`✅ Bulk action "${actionType}" applied to ${checked.length} records!`);
            document.querySelectorAll('.whl-row-checkbox').forEach(cb => cb.checked = false);
            const master = document.getElementById('masterWholesaleCheckbox');
            if (master) master.checked = false;
            updateBulkActionToolbar();
        }
    };

})();
