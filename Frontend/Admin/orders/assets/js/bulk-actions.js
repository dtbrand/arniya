/**
 * bulk-actions.js — Multi-Select Checkboxes & Bulk Operations
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    window.DT_BULK_ACTIONS = {
        toggleSelectAll: function(masterCheckbox) {
            const checkboxes = document.querySelectorAll('.dt-order-check');
            checkboxes.forEach(cb => {
                cb.checked = masterCheckbox.checked;
                const row = cb.closest('tr');
                if (row) {
                    if (cb.checked) row.classList.add('selected');
                    else row.classList.remove('selected');
                }
            });
            this.updateBulkBar();
        },

        onRowCheckChange: function(checkbox) {
            const row = checkbox.closest('tr');
            if (row) {
                if (checkbox.checked) row.classList.add('selected');
                else row.classList.remove('selected');
            }
            this.updateBulkBar();
        },

        updateBulkBar: function() {
            const checked = document.querySelectorAll('.dt-order-check:checked');
            const bulkBar = document.getElementById('ordersBulkBar');
            const countText = document.getElementById('bulkSelectedCount');

            if (checked.length > 0) {
                if (bulkBar) bulkBar.classList.add('active');
                if (countText) countText.textContent = `${checked.length} Orders Selected`;
            } else {
                if (bulkBar) bulkBar.classList.remove('active');
            }
        },

        executeBulkStatus: function(newStatus) {
            const checked = document.querySelectorAll('.dt-order-check:checked');
            if (checked.length === 0) return;

            checked.forEach(cb => {
                const row = cb.closest('tr');
                if (row) {
                    const badge = row.querySelector('.dt-status-badge');
                    if (badge) {
                        badge.className = `dt-status-badge ${newStatus}`;
                        badge.innerHTML = `<span class="dt-status-dot"></span><span>${newStatus}</span>`;
                    }
                }
            });

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`⚡ ${checked.length} orders updated to ${newStatus.toUpperCase()}`);
            }
        },

        executeBulkPrint: function() {
            const checked = document.querySelectorAll('.dt-order-check:checked');
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`🖨️ Generating batch invoices for ${checked.length} selected orders...`);
            }
            setTimeout(() => window.print(), 600);
        },

        executeBulkExport: function() {
            const checked = document.querySelectorAll('.dt-order-check:checked');
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`📥 Exporting ${checked.length} selected orders to Excel/CSV format`);
            }
        }
    };
})();
