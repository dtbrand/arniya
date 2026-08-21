/**
 * customer-tags.js — Tag Creation, Assignment & Chip Management
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    window.addCustomerTag = function (e) {
        if (e) e.preventDefault();
        const input = document.getElementById('dtCustNewTagInput');
        if (!input || !input.value.trim()) {
            window.showToast('⚠️ Please enter a tag name', 'danger');
            return;
        }

        const tagsWrap = document.getElementById('dtCustTagsContainer');
        if (tagsWrap) {
            const tagName = input.value.trim();
            const chip = document.createElement('span');
            chip.className = 'dt-cust-tag-chip gold';
            chip.innerHTML = `
                <span>${tagName}</span>
                <button type="button" class="dt-cust-tag-remove" onclick="this.parentElement.remove(); window.showToast('Tag removed');">✕</button>
            `;
            tagsWrap.appendChild(chip);
            input.value = '';
            window.showToast(`✓ Tag "${tagName}" created and assigned!`);
        }
    };

})();
