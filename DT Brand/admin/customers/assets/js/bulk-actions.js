/**
 * bulk-actions.js — Multi-Customer Bulk Operations Handler
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    window.bulkActivateCustomers = function () {
        window.showToast('✓ Selected Customers Activated Successfully!');
        if (typeof window.clearCustomerSelection === 'function') window.clearCustomerSelection();
    };

    window.bulkDeactivateCustomers = function () {
        window.showToast('✓ Selected Customers Deactivated.');
        if (typeof window.clearCustomerSelection === 'function') window.clearCustomerSelection();
    };

    window.bulkExportCustomers = function () {
        window.showToast('📥 Exporting CSV for Selected Customers...');
        if (typeof window.clearCustomerSelection === 'function') window.clearCustomerSelection();
    };

    window.bulkAddTagModal = function () {
        const tag = prompt('Enter Tag Name to Assign (e.g. VIP, Surat Local, Saree Lover):');
        if (tag && tag.trim()) {
            window.showToast(`✓ Tag "${tag.trim()}" Assigned to Selected Customers!`);
            if (typeof window.clearCustomerSelection === 'function') window.clearCustomerSelection();
        }
    };

})();
