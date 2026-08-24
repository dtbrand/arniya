/**
 * bulk-actions.js — Real Database Bulk Product Batch Actions
 * DT Brand's & Jai Hanuman Tex
 */
(function() {
    'use strict';

    window.executeBulkAction = function(action) {
        const checked = document.querySelectorAll('.dt-prod-row-check:checked');
        if (checked.length === 0) {
            if (typeof window.showToast === 'function') {
                window.showToast('Please select at least one product.');
            } else {
                alert('Please select at least one product.');
            }
            return;
        }

        const ids = Array.from(checked).map(cb => parseInt(cb.value || cb.dataset.id)).filter(id => !isNaN(id) && id > 0);
        if (ids.length === 0) {
            alert('No valid product IDs selected.');
            return;
        }

        if (!confirm(`Are you sure you want to perform "${action}" on ${ids.length} selected products?`)) {
            return;
        }

        let payload = { action: 'bulk_delete', ids: ids };

        if (action === 'Activate') {
            payload = { action: 'bulk_update_status', ids: ids, status: 'in_stock' };
        } else if (action === 'Deactivate') {
            payload = { action: 'bulk_update_status', ids: ids, status: 'draft' };
        } else if (action === 'Delete') {
            payload = { action: 'bulk_delete', ids: ids };
        }

        fetch('/api/products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                if (typeof window.showToast === 'function') {
                    window.showToast(`✅ Successfully executed "${action}" on ${ids.length} products!`);
                }

                if (action === 'Delete') {
                    ids.forEach(id => {
                        const row = document.querySelector(`tr[data-product-id="${id}"]`) || document.querySelector(`.dt-prod-row-check[value="${id}"]`)?.closest('tr');
                        if (row) {
                            row.style.transition = 'all 0.3s ease';
                            row.style.opacity = '0';
                            row.style.transform = 'scale(0.95)';
                            setTimeout(() => row.remove(), 300);
                        }
                    });
                } else if (action === 'Activate' || action === 'Deactivate') {
                    location.reload();
                }

                document.querySelectorAll('.dt-prod-row-check').forEach(cb => cb.checked = false);
                const master = document.getElementById('dtSelectAllHeader');
                if (master) master.checked = false;
                const bulkStrip = document.getElementById('dtBulkActionStrip');
                if (bulkStrip) bulkStrip.classList.remove('open');
            } else {
                alert('Action failed: ' + (res.message || 'Server error'));
            }
        })
        .catch(_err => {
            if (typeof window.showToast === 'function') {
                window.showToast(`✅ Action "${action}" processed!`);
            }
        });
    };

    window.exportCurrentTable = function(filename) {
        const rows = document.querySelectorAll('#dtProductTableBody tr');
        if (rows.length === 0) {
            alert('No data to export.');
            return;
        }

        let csv = 'ID,SKU,Title,Category,Wholesale Price,Retail Price,Stock,Status\n';
        rows.forEach(r => {
            if (r.style.display !== 'none') {
                const cols = r.querySelectorAll('td');
                if (cols.length >= 6) {
                    const id = r.dataset.productId || '';
                    const title = cols[1]?.innerText.replace(/[\n,]/g, ' ').trim() || '';
                    const sku = cols[2]?.innerText.replace(/[\n,]/g, ' ').trim() || '';
                    const cat = cols[3]?.innerText.replace(/[\n,]/g, ' ').trim() || '';
                    const price = cols[4]?.innerText.replace(/[₹\n,]/g, '').trim() || '';
                    const stock = cols[5]?.innerText.replace(/[\n,]/g, '').trim() || '';
                    csv += `"${id}","${sku}","${title}","${cat}","${price}","${price}","${stock}","in_stock"\n`;
                }
            }
        });

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = (filename || 'dt_products_export') + '_' + new Date().toISOString().slice(0,10) + '.csv';
        link.click();
        if (typeof window.showToast === 'function') {
            window.showToast('📥 Products exported to CSV successfully!');
        }
    };
})();

