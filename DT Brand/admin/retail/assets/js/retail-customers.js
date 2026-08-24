/**
 * retail-customers.js — DT Brand's & Jai Hanuman Tex
 * Retail Customers Live Search, Status Filter & Quick Inspector
 */

(function () {
    'use strict';

    window.filterRetailCustomers = function () {
        const query = (document.getElementById('retailCustSearchInput')?.value || '').toLowerCase().trim();
        const statusFilter = document.getElementById('retailCustStatusFilter')?.value || 'all';

        const rows = document.querySelectorAll('#retailCustomersTableBody .retail-customer-row');

        rows.forEach(row => {
            const name = (row.querySelector('.retail-cust-name-cell')?.innerText || '').toLowerCase();
            const email = (row.querySelector('.retail-cust-email-cell')?.innerText || '').toLowerCase();
            const phone = (row.querySelector('.retail-cust-phone-cell')?.innerText || '').toLowerCase();
            const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();

            const matchesQuery = !query || name.includes(query) || email.includes(query) || phone.includes(query);
            const matchesStatus = (statusFilter === 'all') || (rowStatus === statusFilter.toLowerCase());

            if (matchesQuery && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    };

    window.openCustomerQuickView = function (name, email, phone, orders, spent, status) {
        const nameEl = document.getElementById('quickCustName');
        const emailEl = document.getElementById('quickCustEmail');
        const phoneEl = document.getElementById('quickCustPhone');
        const ordersEl = document.getElementById('quickCustOrders');
        const spentEl = document.getElementById('quickCustSpent');
        const statusEl = document.getElementById('quickCustStatus');

        if (nameEl) nameEl.innerText = name;
        if (emailEl) emailEl.innerText = email;
        if (phoneEl) phoneEl.innerText = phone;
        if (ordersEl) ordersEl.innerText = orders;
        if (spentEl) spentEl.innerText = spent;
        if (statusEl) statusEl.innerText = status;

        window.openRetailModal('dtRetailCustomerModal');
    };

})();
