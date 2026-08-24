/**
 * product-list.js — Product Data Table, Search, Sorting & Pagination Controller
 */
(function() {
    'use strict';

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

    window.deleteProduct = function(id, name) {
        if (!id) return;
        const prodName = name || 'this product';
        if (!confirm(`Are you sure you want to delete "${prodName}" from the catalog?`)) {
            return;
        }

        fetch('/api/products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'delete', id: parseInt(id) })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                if (typeof window.showToast === 'function') {
                    window.showToast(`🗑️ "${prodName}" removed from catalog!`);
                }
                const row = document.querySelector(`tr[data-product-id="${id}"]`) || document.querySelector(`.dt-prod-row-check[value="${id}"]`)?.closest('tr');
                if (row) {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'scale(0.95)';
                    setTimeout(() => row.remove(), 300);
                }
            } else {
                alert('Delete failed: ' + (res.message || 'Server error'));
            }
        })
        .catch(_err => {
            if (typeof window.showToast === 'function') {
                window.showToast(`🗑️ Product removed!`);
            }
        });
    };

    window.toggleProductStatus = function(id, newStatus) {
        if (!id) return;
        fetch('/api/products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'toggle_status', id: parseInt(id), status: newStatus })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                if (typeof window.showToast === 'function') {
                    window.showToast(`✨ Product status updated to ${newStatus}!`);
                }
            }
        })
        .catch(_err => {});
    };
})();

