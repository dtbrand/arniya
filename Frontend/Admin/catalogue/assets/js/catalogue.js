/**
 * catalogue.js — Master JavaScript Controller for DT Brand's Catalogue Module
 * DT Brand's & Jai Hanuman Tex
 */

window.DT_CATALOGUE = {
    // Show Toast notification using Admin Toast or fallback
    showToast: function(msg, type = 'gold') {
        if (typeof window.showToast === 'function') {
            window.showToast(msg);
            return;
        }
        let container = document.getElementById('dtToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'dtToastContainer';
            container.style.cssText = 'position:fixed; bottom:20px; right:20px; z-index:999999; display:flex; flex-direction:column; gap:8px;';
            document.body.appendChild(container);
        }
        const toast = document.createElement('div');
        toast.style.cssText = 'background:#181512; color:#fff; border:1px solid #D4AF37; border-radius:6px; padding:10px 16px; font-size:12px; font-weight:700; box-shadow:0 4px 14px rgba(0,0,0,0.25); display:flex; align-items:center; gap:8px; animation:fadeIn 0.2s ease;';
        toast.innerHTML = `<span style="color:#D4AF37;">✦</span> <span>${msg}</span>`;
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    },

    // Real-time table filter with 1-tap clear button
    filterTable: function(inputId, tableId, clearBtnId) {
        const input = document.getElementById(inputId);
        const table = document.getElementById(tableId);
        const clearBtn = clearBtnId ? document.getElementById(clearBtnId) : null;
        if (!input || !table) return;

        const val = input.value.toLowerCase().trim();
        if (clearBtn) {
            clearBtn.style.display = val.length > 0 ? 'inline' : 'none';
        }

        const rows = table.querySelectorAll('tbody tr');
        let matches = 0;
        rows.forEach(r => {
            const txt = r.textContent.toLowerCase();
            if (txt.includes(val)) {
                r.style.display = '';
                matches++;
            } else {
                r.style.display = 'none';
            }
        });
    },

    // Clear search
    clearSearch: function(inputId, tableId, clearBtnId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.value = '';
            this.filterTable(inputId, tableId, clearBtnId);
            input.focus();
        }
    },

    // Master Select All Checkboxes
    toggleSelectAll: function(master, childClass = 'dt-row-check') {
        const checks = document.querySelectorAll('.' + childClass);
        checks.forEach(c => c.checked = master.checked);
    },

    // Delete row with smooth animation
    deleteRow: function(rowId, itemName) {
        if (!confirm(`Are you sure you want to delete "${itemName}"?`)) return;
        const row = document.getElementById(rowId);
        if (!row) return;

        row.style.transition = 'all 0.25s ease';
        row.style.opacity = '0';
        row.style.transform = 'translateX(20px)';
        setTimeout(() => {
            row.remove();
            this.showToast(`🗑️ "${itemName}" deleted successfully!`);
        }, 250);
    },

    // Image preview helper for file inputs
    previewImage: function(input, targetImgId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(targetImgId);
                if (img) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    },

    // Auto Slug Generator
    generateSlug: function(sourceInputId, targetSlugId) {
        const src = document.getElementById(sourceInputId);
        const tgt = document.getElementById(targetSlugId);
        if (src && tgt) {
            tgt.value = src.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
        }
    }
};
