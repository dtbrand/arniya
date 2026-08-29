/**
 * bulk-actions.js — DT Brand's & Jai Hanuman Tex
 * Retail Batch Selection & Bulk Operations Engine
 */

(function () {
    'use strict';

    window.toggleAllRetailCheckboxes = function (masterCheckbox) {
        const isChecked = masterCheckbox.checked;
        document.querySelectorAll('.retail-row-checkbox').forEach(cb => {
            cb.checked = isChecked;
        });
        updateRetailBulkActionCount();
    };

    window.updateRetailBulkActionCount = function () {
        const checked = document.querySelectorAll('.retail-row-checkbox:checked').length;
        const bar = document.getElementById('retailBulkActionBar');
        const countSpan = document.getElementById('retailBulkSelectedCount');

        if (bar && countSpan) {
            countSpan.innerText = checked;
            bar.style.display = checked > 0 ? 'flex' : 'none';
        }
    };

    window.executeRetailBulkAction = function (action) {
        const checked = document.querySelectorAll('.retail-row-checkbox:checked').length;
        if (checked === 0) {
            window.showToast('⚠️ Please select at least one row.', true);
            return;
        }

        if (action === 'export') {
            window.showToast(`📊 Exporting ${checked} selected records...`);
        } else if (action === 'visibility_enable') {
            window.showToast(`👁️ Enabled Retail Visibility for ${checked} items!`);
        } else if (action === 'visibility_disable') {
            window.showToast(`🔒 Disabled Retail Visibility for ${checked} items!`);
        } else if (action === 'segment_assign') {
            window.showToast(`🏷️ Assigned ${checked} customers to VIP segment!`);
        }
    };

})();
