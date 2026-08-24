/**
 * navigation.js — Interactive Visual Menu Controller & Drag & Drop Engine
 * DT Brand's & Jai Hanuman Tex
 */

window.DT_NAVIGATION = {
    // Quick Add Preset
    quickAdd: function(title, url) {
        this.insertItem(title, url, false);
        if (window.DT_CATALOGUE) window.DT_CATALOGUE.showToast(`✨ Added "${title}" to navigation tree!`);
    },

    // Add Custom Item from Inputs
    addMenuItem: function() {
        const titleInput = document.getElementById('newMenuTitle');
        const urlInput = document.getElementById('newMenuUrl');
        if (!titleInput || !titleInput.value.trim()) {
            alert('Please enter a Link Label.');
            return;
        }

        const title = titleInput.value.trim();
        const url = urlInput && urlInput.value.trim() ? urlInput.value.trim() : '#' + title.toLowerCase().replace(/[^a-z0-9]+/g, '-');

        this.insertItem(title, url, false);

        titleInput.value = '';
        if (urlInput) urlInput.value = '';

        if (window.DT_CATALOGUE) window.DT_CATALOGUE.showToast(`✨ Added "${title}" to navigation tree!`);
    },

    // Insert Item DOM
    insertItem: function(title, url, isChild) {
        const list = document.getElementById('navMenuList');
        if (!list) return;

        const li = document.createElement('li');
        li.className = 'dt-menu-nest-item' + (isChild ? ' is-child' : '');
        li.draggable = true;
        li.id = 'nav-item-' + Date.now();

        li.innerHTML = `
            <div style="display:flex; align-items:center; gap:8px;">
                <span class="dt-menu-drag-grip" title="Drag to reorder">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="9" cy="12" r="1.2"></circle><circle cx="9" cy="5" r="1.2"></circle><circle cx="9" cy="19" r="1.2"></circle><circle cx="15" cy="12" r="1.2"></circle><circle cx="15" cy="5" r="1.2"></circle><circle cx="15" cy="19" r="1.2"></circle></svg>
                </span>
                <strong class="dt-menu-label" style="font-size:12px; color:#181512;">${title}</strong>
                <code class="dt-menu-url" style="font-size:10.5px; color:#64748b;">${url}</code>
            </div>
            <div style="display:flex; gap:4px; align-items:center;">
                <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.toggleIndent(this)" style="height:24px; padding:0 8px; font-size:10.5px;">${isChild ? '← Outdent' : 'Indent →'}</button>
                <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_NAVIGATION.removeItem(this)" style="height:24px; padding:0 6px; font-size:10.5px;">
                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </button>
            </div>
        `;

        list.appendChild(li);
        this.updateBadge();
        this.bindDragEvents(li);
    },

    // Toggle Indent / Outdent Sub-level
    toggleIndent: function(btn) {
        const item = btn.closest('.dt-menu-nest-item');
        if (!item) return;

        if (item.classList.contains('is-child')) {
            item.classList.remove('is-child');
            btn.textContent = 'Indent →';
            if (window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Promoted to Top-Level Menu Link');
        } else {
            item.classList.add('is-child');
            btn.textContent = '← Outdent';
            if (window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Converted to Submenu Item');
        }
        this.updateBadge();
    },

    // Remove Item
    removeItem: function(btn) {
        const item = btn.closest('.dt-menu-nest-item');
        if (!item) return;

        item.style.transition = 'all 0.2s ease';
        item.style.opacity = '0';
        item.style.transform = 'translateX(20px)';
        setTimeout(() => {
            item.remove();
            this.updateBadge();
            if (window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Menu item removed');
        }, 200);
    },

    // Update Top Item Count Badge
    updateBadge: function() {
        const list = document.getElementById('navMenuList');
        const badge = document.getElementById('menuCountBadge');
        if (!list || !badge) return;

        const total = list.querySelectorAll('.dt-menu-nest-item').length;
        const topLevel = list.querySelectorAll('.dt-menu-nest-item:not(.is-child)').length;
        badge.textContent = `${topLevel} Top Links (${total} Total)`;
    },

    // Switch Preview (Desktop Mega Menu vs Mobile Off-Canvas Drawer)
    switchNavPreview: function(device) {
        const btnDesk = document.getElementById('btnNavDesk');
        const btnMob = document.getElementById('btnNavMob');
        const prevDesk = document.getElementById('navPrevDesk');
        const prevMob = document.getElementById('navPrevMob');

        if (device === 'mob') {
            if (btnDesk) btnDesk.classList.remove('active');
            if (btnMob) btnMob.classList.add('active');
            if (prevDesk) prevDesk.style.display = 'none';
            if (prevMob) prevMob.style.display = 'block';
        } else {
            if (btnMob) btnMob.classList.remove('active');
            if (btnDesk) btnDesk.classList.add('active');
            if (prevMob) prevMob.style.display = 'none';
            if (prevDesk) prevDesk.style.display = 'grid';
        }
    },

    // Save Menu
    saveMenu: function() {
        if (window.DT_CATALOGUE) {
            window.DT_CATALOGUE.showToast('✅ Navigation tree & Mega Menu saved live!');
        }
    },

    // Direct Mouse HTML5 Drag and Drop
    draggedItem: null,

    bindDragEvents: function(item) {
        item.addEventListener('dragstart', (e) => {
            this.draggedItem = item;
            item.classList.add('is-dragging');
            e.dataTransfer.effectAllowed = 'move';
        });

        item.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            if (this.draggedItem === item) return;

            const rect = item.getBoundingClientRect();
            const relY = e.clientY - rect.top;
            if (relY < rect.height / 2) {
                item.classList.add('drag-over-top');
                item.classList.remove('drag-over-bottom');
            } else {
                item.classList.add('drag-over-bottom');
                item.classList.remove('drag-over-top');
            }
        });

        item.addEventListener('dragleave', () => {
            item.classList.remove('drag-over-top', 'drag-over-bottom');
        });

        item.addEventListener('drop', (e) => {
            e.preventDefault();
            item.classList.remove('drag-over-top', 'drag-over-bottom');
            if (!this.draggedItem || this.draggedItem === item) return;

            const list = document.getElementById('navMenuList');
            const rect = item.getBoundingClientRect();
            const relY = e.clientY - rect.top;

            if (relY < rect.height / 2) {
                list.insertBefore(this.draggedItem, item);
            } else {
                list.insertBefore(this.draggedItem, item.nextSibling);
            }

            if (window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Menu order updated live!');
        });

        item.addEventListener('dragend', () => {
            if (this.draggedItem) {
                this.draggedItem.classList.remove('is-dragging');
                this.draggedItem = null;
            }
            document.querySelectorAll('.dt-menu-nest-item').forEach(el => {
                el.classList.remove('drag-over-top', 'drag-over-bottom');
            });
        });
    },

    init: function() {
        document.querySelectorAll('.dt-menu-nest-list .dt-menu-nest-item').forEach(item => {
            this.bindDragEvents(item);
        });
        this.updateBadge();
    }
};

document.addEventListener('DOMContentLoaded', () => {
    window.DT_NAVIGATION.init();
});
