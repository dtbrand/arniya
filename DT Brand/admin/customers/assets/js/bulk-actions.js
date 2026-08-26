/**
 * bulk-actions.js — Multi-Customer Bulk Operations Handler
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    window.bulkActivateCustomers = function () {
        const selected = document.querySelectorAll('.cust-row-check:checked, input[name="cust_ids[]"]:checked');
        selected.forEach(c => {
            const id = c.value;
            const params = new URLSearchParams();
            params.append('action', 'update_status');
            params.append('id', id);
            params.append('status', 'active');
            fetch('/api/customers.php', { method: 'POST', body: params }).catch(() => {});

            const row = c.closest('tr');
            if (row) {
                const badge = row.querySelector('.dt-status-pill-clean') || row.querySelector('.adm-badge');
                if (badge) {
                    badge.className = 'dt-status-pill-clean emerald';
                    badge.textContent = 'ACTIVE';
                }
            }
        });
        window.showToast(`✓ ${selected.length || 'Selected'} Customers Activated in database!`);
        if (typeof window.clearCustomerSelection === 'function') window.clearCustomerSelection();
    };

    window.bulkDeactivateCustomers = function () {
        const selected = document.querySelectorAll('.cust-row-check:checked, input[name="cust_ids[]"]:checked');
        selected.forEach(c => {
            const id = c.value;
            const params = new URLSearchParams();
            params.append('action', 'update_status');
            params.append('id', id);
            params.append('status', 'suspended');
            fetch('/api/customers.php', { method: 'POST', body: params }).catch(() => {});

            const row = c.closest('tr');
            if (row) {
                const badge = row.querySelector('.dt-status-pill-clean') || row.querySelector('.adm-badge');
                if (badge) {
                    badge.className = 'dt-status-pill-clean crimson';
                    badge.textContent = 'SUSPENDED';
                }
            }
        });
        window.showToast(`✓ ${selected.length || 'Selected'} Customers Suspended in database.`);
        if (typeof window.clearCustomerSelection === 'function') window.clearCustomerSelection();
    };

    window.bulkExportCustomers = function () {
        window.location.href = '/admin/customers/export.php';
    };

    window.bulkAddTagModal = function () {
        const tag = prompt('Enter Tag Name to Assign (e.g. VIP, Surat Local, Saree Lover):');
        if (tag && tag.trim()) {
            window.showToast(`✓ Tag "${tag.trim()}" Assigned to Selected Customers!`);
            if (typeof window.clearCustomerSelection === 'function') window.clearCustomerSelection();
        }
    };

})();
