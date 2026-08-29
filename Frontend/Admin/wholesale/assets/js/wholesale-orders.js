/**
 * wholesale-orders.js — DT Brand's & Jai Hanuman Tex
 * Wholesale Purchase Orders Management, Live Filter, Modal Viewer & Consignment WhatsApp Dispatch
 */

(function () {
    'use strict';

    let currentOrderData = {};

    // ── Live Filter for Wholesale Orders ──
    window.filterWholesaleOrders = function () {
        const query = (document.getElementById('wholesaleOrderSearchInput')?.value || '').toLowerCase().trim();
        const statusFilter = document.getElementById('wholesaleOrderStatusFilter')?.value || 'all';

        const rows = document.querySelectorAll('#wholesaleOrdersTableBody .wholesale-order-row');

        rows.forEach((row) => {
            const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();
            const idText = (row.querySelector('.order-id-cell')?.innerText || '').toLowerCase();
            const itemsText = (row.querySelector('.order-items-cell')?.innerText || '').toLowerCase();
            const paymentText = (row.querySelector('.order-payment-cell')?.innerText || '').toLowerCase();

            const matchesQuery = !query || idText.includes(query) || itemsText.includes(query) || paymentText.includes(query);
            const matchesStatus = (statusFilter === 'all') || (rowStatus === statusFilter.toLowerCase());

            if (matchesQuery && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    };

    // ── Open Wholesale Order Details Modal ──
    window.openWholesaleOrderModal = function (orderId, orderDate, items, amount, payment, status, partnerName, partnerId) {
        currentOrderData = {
            id: orderId || 'ORD-WHL-8112',
            date: orderDate || '22 Aug 2026',
            items: items || '120 Saree Lots (Pure Kanjeevaram & Banarasi Silk)',
            amount: amount || '₹84,500',
            payment: payment || 'Net 30 Days (Revolving Credit)',
            status: status || 'Processing Dispatch',
            partnerName: partnerName || 'Shree Balaji Silk Mills',
            partnerId: partnerId || 'WHL-8012'
        };

        const idEl = document.getElementById('modalWhlOrderId');
        const dateEl = document.getElementById('modalWhlOrderDate');
        const partnerEl = document.getElementById('modalWhlOrderPartner');
        const itemsEl = document.getElementById('modalWhlOrderItems');
        const amountEl = document.getElementById('modalWhlOrderAmount');
        const payEl = document.getElementById('modalWhlOrderPayment');
        const statusEl = document.getElementById('modalWhlOrderStatus');

        if (idEl) idEl.innerText = currentOrderData.id;
        if (dateEl) dateEl.innerText = currentOrderData.date;
        if (partnerEl) partnerEl.innerText = `${currentOrderData.partnerName} (${currentOrderData.partnerId})`;
        if (itemsEl) itemsEl.innerText = currentOrderData.items;
        if (amountEl) amountEl.innerText = currentOrderData.amount;
        if (payEl) payEl.innerText = currentOrderData.payment;
        if (statusEl) statusEl.innerText = currentOrderData.status;

        window.openWholesaleModal('dtWholesaleOrderModal');
    };

    // ── Export Wholesale Orders CSV ──
    window.exportWholesaleOrdersCsv = function (whlId) {
        const cleanId = (whlId || 'WHL-ALL').replace(/[^a-zA-Z0-9]/g, '');
        const rows = [
            ['PO / Order ID', 'Order Date', 'Partner Name', 'Product Lots & SKUs', 'Order Total (INR)', 'Payment Mode', 'Fulfillment Status'],
            ['ORD-WHL-8112', '22 Aug 2026', 'Shree Balaji Silk Mills', '120 Saree Lots (Pure Kanjeevaram & Banarasi Silk)', '84500', 'Net 30 Days', 'Processing Dispatch'],
            ['ORD-WHL-8062', '10 Aug 2026', 'Shree Balaji Silk Mills', '240 Saree Lots (Surat Dola Silk Jacquard)', '145000', 'Settled via NEFT', 'Delivered & Settled'],
            ['ORD-WHL-8012', '25 Jul 2026', 'Shree Balaji Silk Mills', '300 Saree Lots (Chanderi & Organza Festive)', '192000', 'Settled via RTGS', 'Delivered & Settled']
        ];

        let csvContent = 'data:text/csv;charset=utf-8,' + rows.map(e => e.join(',')).join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', `Wholesale_Orders_${cleanId}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        window.showToast(`📦 Exported Wholesale Orders CSV!`);
    };

    // ── WhatsApp B2B Dispatch Notice ──
    window.sendOrderWhatsAppNotice = function () {
        const orderId = currentOrderData.id || 'ORD-WHL-8112';
        const partner = currentOrderData.partnerName || 'Valued Wholesaler';
        const amount = currentOrderData.amount || '₹84,500';
        const status = currentOrderData.status || 'Dispatched';

        const msg = encodeURIComponent(
            `👑 *DT BRAND'S & JAI HANUMAN TEX — WHOLESALE DISPATCH UPDATE*\n\n` +
            `Namaste *${partner}*,\n` +
            `Your Purchase Order *${orderId}* (${amount}) status is: *${status}*.\n\n` +
            `📦 Consignment is handled under Priority B2B Logistics.\n` +
            `Thank you for your valued partnership!`
        );

        window.open(`https://api.whatsapp.com/send?phone=917046363528&text=${msg}`, '_blank');
    };

})();
