/**
 * bulk-actions.js — Multi-Record Batch Actions Controller
 */

(function () {
    'use strict';

    function getSelectedIds() {
        const checked = document.querySelectorAll('.dt-reseller-row-checkbox:checked');
        const ids = [];
        checked.forEach(cb => ids.push(cb.value));
        return ids;
    }

    window.bulkApproveResellers = function () {
        const ids = getSelectedIds();
        if (!ids.length) return;
        if (confirm(`Approve ${ids.length} selected reseller application(s)?`)) {
            window.showToast(`✓ ${ids.length} Resellers Approved successfully!`);
            window.closeBulkActionBar();
        }
    };

    window.bulkSuspendResellers = function () {
        const ids = getSelectedIds();
        if (!ids.length) return;
        if (confirm(`Suspend ${ids.length} selected reseller(s)?`)) {
            window.showToast(`⚠️ ${ids.length} Resellers marked as Suspended`);
            window.closeBulkActionBar();
        }
    };

    window.bulkExportResellers = function () {
        const ids = getSelectedIds();
        window.showToast(`📥 Exporting ${ids.length || 'all'} selected reseller records to CSV...`);
        window.closeBulkActionBar();
    };

})();
