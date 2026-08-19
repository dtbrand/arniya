/**
 * product-list.js — Product Data Table, Search, Sorting & Pagination Controller
 */
(function() {
    'use strict';

    let currentProducts = [
        { id: 101, img: '/Frontend/Shop/Asset/images/product1.png', name: 'Kanjivaram Pure Silk Gold Zari Saree', sku: 'KLN-SR-111', category: 'Silk Sarees', brand: 'DT Signature', variants: '3 Colors', retail: 4490, reseller: 3450, wholesale: 2850, stock: 45, rating: '5.0 ★', status: 'Active', updated: 'Today, 11:20 AM' },
        { id: 102, img: '/Frontend/Shop/Asset/images/product2.png', name: 'Banarasi Royal Brocade Weave Saree', sku: 'BNR-SR-204', category: 'Banarasi', brand: 'Arniya Heritage', variants: '4 Colors', retail: 4990, reseller: 3850, wholesale: 3200, stock: 28, rating: '4.9 ★', status: 'Active', updated: 'Yesterday' },
        { id: 103, img: '/Frontend/Shop/Asset/images/product3.png', name: 'Crimson Bridal Handcrafted Zardosi Lehenga', sku: 'BRD-LH-902', category: 'Bridal Lehengas', brand: 'DT Couture', variants: 'Free Size', retail: 16490, reseller: 13200, wholesale: 11500, stock: 4, rating: '5.0 ★', status: 'Low Stock', updated: '2 days ago' },
        { id: 104, img: '/Frontend/Shop/Asset/images/product4.png', name: 'Chanderi Pure Zari Border Saree', sku: 'CHD-SR-301', category: 'Silk Sarees', brand: 'DT Signature', variants: '6 Colors', retail: 2890, reseller: 2150, wholesale: 1750, stock: 95, rating: '4.8 ★', status: 'Active', updated: '3 days ago' },
        { id: 105, img: '/Frontend/Shop/Asset/images/product5.png', name: 'Designer Anarkali Embroidered Kurti Set', sku: 'DSG-KT-408', category: 'Designer Kurtis', brand: 'DT Prêt', variants: 'M, L, XL, XXL', retail: 2490, reseller: 1850, wholesale: 1450, stock: 62, rating: '4.9 ★', status: 'Active', updated: '5 days ago' }
    ];

    window.filterProductTable = function(query) {
        const q = (query || '').toLowerCase().trim();
        const rows = document.querySelectorAll('#dtProductTableBody tr');
        rows.forEach(r => {
            const text = r.textContent.toLowerCase();
            r.style.display = !q || text.includes(q) ? '' : 'none';
        });
    };

    window.toggleBulkSelectAll = function(masterCheckbox) {
        const isChecked = masterCheckbox.checked;
        const checkboxes = document.querySelectorAll('.dt-prod-row-check');
        checkboxes.forEach(cb => cb.checked = isChecked);
        const bulkStrip = document.getElementById('dtBulkActionStrip');
        if (bulkStrip) {
            bulkStrip.classList.toggle('open', isChecked);
            const countEl = document.getElementById('dtSelectedCount');
            if (countEl) countEl.textContent = isChecked ? checkboxes.length : 0;
        }
    };

    window.handleRowSelect = function() {
        const checked = document.querySelectorAll('.dt-prod-row-check:checked');
        const bulkStrip = document.getElementById('dtBulkActionStrip');
        if (bulkStrip) {
            bulkStrip.classList.toggle('open', checked.length > 0);
            const countEl = document.getElementById('dtSelectedCount');
            if (countEl) countEl.textContent = checked.length;
        }
    };
})();
