/**
 * customer-tags.js — Tag Creation, Assignment & Chip Management
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    // ── Add New Tag Dynamically ──
    window.addCustomerTag = function (e) {
        if (e) e.preventDefault();
        const input = document.getElementById('dtCustNewTagInput');
        const catSelect = document.getElementById('dtTagCategorySelect');
        const colorSelect = document.getElementById('dtTagColorSelect');

        const tagName = (input?.value || '').trim();
        const category = catSelect?.value || 'Product Affinity';
        const color = colorSelect?.value || 'gold';

        if (!tagName) {
            window.showToast('⚠️ Please enter a tag name');
            return;
        }

        // Add to Active Cloud
        const tagsWrap = document.getElementById('dtCustTagsContainer');
        if (tagsWrap) {
            const chip = document.createElement('span');
            chip.className = `dt-cust-tag-chip ${color}`;
            chip.style.cursor = 'pointer';
            chip.style.animation = 'dtModalPop 0.25s ease';
            chip.setAttribute('onclick', `filterTagsTable('${tagName}')`);
            chip.innerHTML = `
                <span>${tagName} (0)</span>
                <button type="button" class="dt-cust-tag-remove" onclick="event.stopPropagation(); removeTagChip(this, '${tagName}')">✕</button>
            `;
            tagsWrap.prepend(chip);
        }

        // Add to Master Table
        const tableBody = document.querySelector('#dtTagsMasterTable tbody');
        if (tableBody) {
            const randomId = 'TAG-' + Math.floor(10 + Math.random() * 90);
            const tr = document.createElement('tr');
            tr.className = 'dt-tag-row';
            tr.setAttribute('data-tag-name', (tagName + ' ' + category + ' Custom').toLowerCase());
            tr.style.borderBottom = '1px solid #F1ECE1';
            tr.style.animation = 'dtModalPop 0.25s ease';
            tr.innerHTML = `
                <td style="padding:12px 16px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span class="dt-cust-tag-chip ${color}">
                            <span>${tagName}</span>
                        </span>
                        <span style="font-size:0.68rem; color:#78716C; font-weight:600;">${randomId}</span>
                    </div>
                </td>
                <td style="padding:12px 16px; font-size:0.8rem; font-weight:700; color:#181512;">${category}</td>
                <td style="padding:12px 16px;">
                    <div style="font-size:0.75rem; font-weight:700; color:#181512;">Custom Staff Defined</div>
                    <span class="dt-cust-badge gold" style="font-size:0.62rem; margin-top:2px; display:inline-block;">Active Label</span>
                </td>
                <td style="padding:12px 16px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <strong style="font-size:0.95rem; font-weight:900; color:#181512;">0</strong>
                        <div style="flex:1; max-width:80px; height:6px; background:#EAE5D9; border-radius:3px;"></div>
                    </div>
                </td>
                <td style="padding:12px 16px; text-align:right;">
                    <div style="display:inline-flex; align-items:center; gap:6px;">
                        <a href="/DT%20Brand/admin/customers/index.php" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:3px 8px; font-size:0.72rem; text-decoration:none;">View Customers</a>
                        <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px; padding:3px 8px; font-size:0.72rem;" onclick="broadcastToTaggedGroup('${tagName}', 0)">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>Broadcast</span>
                        </button>
                    </div>
                </td>
            `;
            tableBody.prepend(tr);
        }

        if (input) input.value = '';
        window.showToast(`✓ Tag "${tagName}" created successfully!`);
    };

    // ── Remove Tag Chip ──
    window.removeTagChip = function (btn, name) {
        if (confirm(`Remove tag "${name}" from active cloud?`)) {
            const chip = btn.closest('.dt-cust-tag-chip');
            if (chip) chip.remove();
            window.showToast(`Tag "${name}" removed`);
        }
    };

    // ── Live Table Search Filtering ──
    window.filterTagsTable = function (query) {
        const q = (query || '').toLowerCase().trim();
        const searchInput = document.getElementById('dtTagSearchInput');
        if (searchInput && searchInput.value !== query) {
            searchInput.value = query;
        }

        const rows = document.querySelectorAll('#dtTagsMasterTable tbody tr');
        rows.forEach(row => {
            const data = (row.getAttribute('data-tag-name') || row.innerText || '').toLowerCase();
            if (!q || data.includes(q)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    };

    // ── Broadcast to Tagged Group ──
    window.broadcastToTaggedGroup = function (tagName, count) {
        window.showToast(`💬 Preparing 1-Click WhatsApp Broadcast to ${count || 'all'} customers tagged "${tagName}"...`);
    };

})();

