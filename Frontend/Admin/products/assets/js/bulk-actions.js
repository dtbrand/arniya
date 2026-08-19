/**
 * bulk-actions.js — Bulk Product Batch Actions
 */
(function() {
    'use strict';

    window.executeBulkAction = function(action) {
        const checked = document.querySelectorAll('.dt-prod-row-check:checked');
        if (checked.length === 0) {
            window.showToast('Please select at least one product.');
            return;
        }
        if (confirm(`Are you sure you want to perform "${action}" on ${checked.length} selected products?`)) {
            window.showToast(`✅ Bulk action "${action}" completed for ${checked.length} products!`);
            document.querySelectorAll('.dt-prod-row-check').forEach(cb => cb.checked = false);
            const bulkStrip = document.getElementById('dtBulkActionStrip');
            if (bulkStrip) bulkStrip.classList.remove('open');
        }
    };
})();
