/**
 * categories.js — Category Management Actions & Live Form Previews
 */
window.DT_CATEGORIES = {
    toggleFeatured: function(btn, catId, catName) {
        const isActive = btn.classList.contains('active');
        if (isActive) {
            btn.classList.remove('active');
            btn.style.color = '#c3c4c7';
            window.DT_CATALOGUE.showToast(`"${catName}" removed from Featured`);
        } else {
            btn.classList.add('active');
            btn.style.color = '#D4AF37';
            window.DT_CATALOGUE.showToast(`🌟 "${catName}" marked as Featured!`);
        }
    },

    saveCategoryForm: function(e) {
        if (e) e.preventDefault();
        const name = document.getElementById('catName')?.value;
        if (!name) {
            alert('Please enter Category Name');
            return false;
        }
        window.DT_CATALOGUE.showToast('✅ Category saved successfully!', 'gold');
        setTimeout(() => {
            window.location.href = '/admin/catalogue/categories/';
        }, 800);
        return false;
    }
};

/**
 * collections.js — Collection Product Assignment & Dual Box Controller
 */
window.DT_COLLECTIONS = {
    addProductToCollection: function(id, name, sku, price, img) {
        const assignedBox = document.getElementById('assignedProductsList');
        if (!assignedBox) return;
        if (document.getElementById('assigned-prod-' + id)) {
            window.DT_CATALOGUE.showToast('Product already assigned to collection');
            return;
        }
        const item = document.createElement('div');
        item.id = 'assigned-prod-' + id;
        item.className = 'dt-assign-item';
        item.innerHTML = `
            <div style="display:flex; align-items:center; gap:8px;">
                <img src="${img}" style="width:28px; height:28px; border-radius:4px; object-fit:cover;">
                <div>
                    <strong>${name}</strong>
                    <div style="font-size:10px; color:#64748b;">${sku} • ${price}</div>
                </div>
            </div>
            <button type="button" class="dt-btn-action-sm danger" onclick="this.closest('.dt-assign-item').remove()" style="height:22px; padding:0 6px; font-size:10px;">Remove</button>
        `;
        assignedBox.appendChild(item);
        window.DT_CATALOGUE.showToast(`Added "${name}" to collection`);
    }
};

/**
 * banners.js — Banner Management
 */
window.DT_BANNERS = {
    toggleStatus: function(btn, bannerTitle) {
        const isLive = btn.textContent.trim().toLowerCase() === 'active';
        if (isLive) {
            btn.className = 'dt-badge red';
            btn.textContent = 'Inactive';
            window.DT_CATALOGUE.showToast(`"${bannerTitle}" deactivated`);
        } else {
            btn.className = 'dt-badge green';
            btn.textContent = 'Active';
            window.DT_CATALOGUE.showToast(`🌟 "${bannerTitle}" activated live!`);
        }
    }
};

/**
 * navigation.js — Visual Menu Builder
 */
window.DT_NAVIGATION = {
    addMenuItem: function() {
        const title = document.getElementById('newMenuTitle')?.value;
        const url = document.getElementById('newMenuUrl')?.value;
        if (!title) {
            alert('Please enter Menu Item Label');
            return;
        }
        const list = document.getElementById('navMenuList');
        if (!list) return;
        const li = document.createElement('li');
        li.className = 'dt-menu-nest-item';
        li.innerHTML = `
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="cursor:grab; color:#94a3b8;">☰</span>
                <strong>${title}</strong>
                <code style="font-size:10.5px; color:#64748b;">${url || '#'}</code>
            </div>
            <div style="display:flex; gap:4px;">
                <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_NAVIGATION.toggleIndent(this)" style="height:24px; padding:0 8px; font-size:10.5px;">Indent</button>
                <button type="button" class="dt-btn-action-sm danger" onclick="this.closest('.dt-menu-nest-item').remove()" style="height:24px; padding:0 8px; font-size:10.5px;">Remove</button>
            </div>
        `;
        list.appendChild(li);
        document.getElementById('newMenuTitle').value = '';
        document.getElementById('newMenuUrl').value = '';
        window.DT_CATALOGUE.showToast(`Added "${title}" to Navigation Menu`);
    },

    toggleIndent: function(btn) {
        const item = btn.closest('.dt-menu-nest-item');
        if (item) {
            item.classList.toggle('is-child');
            window.DT_CATALOGUE.showToast(item.classList.contains('is-child') ? 'Sub-item nested' : 'Item un-nested');
        }
    }
};

/**
 * merchandising.js — Visual Merchandising Pinning & Ordering
 */
window.DT_MERCH = {
    togglePin: function(btn, cardId, prodName) {
        const card = document.getElementById(cardId);
        if (!card) return;
        const isPinned = card.classList.contains('is-pinned');
        if (isPinned) {
            card.classList.remove('is-pinned');
            btn.textContent = '📌 Pin to Top';
            window.DT_CATALOGUE.showToast(`"${prodName}" unpinned`);
        } else {
            card.classList.add('is-pinned');
            btn.textContent = '⭐ Pinned';
            window.DT_CATALOGUE.showToast(`🌟 "${prodName}" pinned to Category Top!`);
        }
    },

    toggleHide: function(btn, cardId, prodName) {
        const card = document.getElementById(cardId);
        if (!card) return;
        const isHidden = card.classList.contains('is-hidden');
        if (isHidden) {
            card.classList.remove('is-hidden');
            btn.textContent = '👁️ Hide';
            window.DT_CATALOGUE.showToast(`"${prodName}" visible in catalogue`);
        } else {
            card.classList.add('is-hidden');
            btn.textContent = '🚫 Hidden';
            window.DT_CATALOGUE.showToast(`"${prodName}" hidden from catalogue view`);
        }
    }
};

/**
 * filters.js — Catalogue Filtering Controller
 */
window.DT_FILTERS = {
    applyStatusFilter: function(status, activeLink) {
        if (activeLink) {
            document.querySelectorAll('.wp-subsubsub a').forEach(a => a.classList.remove('current'));
            activeLink.classList.add('current');
        }
        const rows = document.querySelectorAll('.dt-cat-table tbody tr');
        rows.forEach(r => {
            if (!status) {
                r.style.display = '';
            } else {
                const rStatus = r.getAttribute('data-status') || '';
                r.style.display = rStatus.toLowerCase().includes(status.toLowerCase()) ? '' : 'none';
            }
        });
        window.DT_CATALOGUE.showToast(status ? `Showing ${status} items` : 'Showing all items');
    }
};
