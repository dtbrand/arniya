/**
 * retail-orders.js — DT Brand's & Jai Hanuman Tex
 * Retail Orders Live Filter & WhatsApp Dispatch Notice Engine
 */

(function () {
    'use strict';

    let currentRetailOrder = {};

    window.filterRetailOrders = function () {
        const query = (document.getElementById('retailOrderSearchInput')?.value || '').toLowerCase().trim();
        const statusFilter = document.getElementById('retailOrderStatusFilter')?.value || 'all';

        const rows = document.querySelectorAll('#retailOrdersTableBody .retail-order-row');

        rows.forEach(row => {
            const id = (row.querySelector('.retail-order-id-cell')?.innerText || '').toLowerCase();
            const customer = (row.querySelector('.retail-order-cust-cell')?.innerText || '').toLowerCase();
            const items = (row.querySelector('.retail-order-items-cell')?.innerText || '').toLowerCase();
            const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();

            const matchesQuery = !query || id.includes(query) || customer.includes(query) || items.includes(query);
            const matchesStatus = (statusFilter === 'all') || (rowStatus === statusFilter.toLowerCase());

            if (matchesQuery && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    };

    window.openRetailOrderQuickView = function (orderId, customer, items, amount, payment, shipping, status, date) {
        currentRetailOrder = { id: orderId, customer, items, amount, payment, shipping, status, date };

        const idEl = document.getElementById('quickRetailOrderId');
        const custEl = document.getElementById('quickRetailOrderCust');
        const itemsEl = document.getElementById('quickRetailOrderItems');
        const amtEl = document.getElementById('quickRetailOrderAmt');
        const payEl = document.getElementById('quickRetailOrderPay');
        const shipEl = document.getElementById('quickRetailOrderShip');
        const statusEl = document.getElementById('quickRetailOrderStatus');

        if (idEl) idEl.innerText = orderId;
        if (custEl) custEl.innerText = customer;
        if (itemsEl) itemsEl.innerText = items;
        if (amtEl) amtEl.innerText = amount;
        if (payEl) payEl.innerText = payment;
        if (shipEl) shipEl.innerText = shipping;
        if (statusEl) statusEl.innerText = status;

        window.openRetailModal('dtRetailOrderModal');
    };

    window.sendRetailWhatsAppNotice = function () {
        const orderId = currentRetailOrder.id || 'ORD-RET-9012';
        const customer = currentRetailOrder.customer || 'Valued Customer';
        const amount = currentRetailOrder.amount || '₹2,450';
        const status = currentRetailOrder.status || 'Dispatched';

        const msg = encodeURIComponent(
            `👑 *DT BRAND'S RETAIL ORDER UPDATE*\n\n` +
            `Namaste *${customer}*,\n` +
            `Your retail order *${orderId}* (${amount}) status is: *${status}*.\n\n` +
            `Thank you for shopping with DT Brand's!`
        );

        window.open(`https://api.whatsapp.com/send?phone=919876543210&text=${msg}`, '_blank');
    };

})();
