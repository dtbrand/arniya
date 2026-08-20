/**
 * collections.js — Curated Collections Interactive Controller
 * DT Brand's & Jai Hanuman Tex
 */
window.DT_COLLECTIONS = {
    addProductToCollection: function(id, title, sku, price, img) {
        const list = document.getElementById('assignedProductsList');
        if (!list) return;

        const existing = document.getElementById(`assigned-prod-${id}`);
        if (existing) {
            if (window.DT_CATALOGUE) window.DT_CATALOGUE.showToast(`⚠️ "${title}" is already in this collection`);
            return;
        }

        const item = document.createElement('div');
        item.className = 'dt-assign-item';
        item.id = `assigned-prod-${id}`;
        item.style.animation = 'fadeIn 0.2s ease-out';
        item.innerHTML = `
            <div style="display:flex; align-items:center; gap:8px;">
                <img src="${img}" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:28px; height:28px; border-radius:4px; object-fit:cover;">
                <div>
                    <strong>${title}</strong>
                    <div style="font-size:10px; color:#64748b;">${sku} • ${price}</div>
                </div>
            </div>
            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_COLLECTIONS.removeProductFromCollection('assigned-prod-${id}', '${title.replace(/'/g, "\\'")}')" style="height:22px; padding:0 6px; font-size:10px;">Remove</button>
        `;
        list.appendChild(item);

        if (window.DT_CATALOGUE) {
            window.DT_CATALOGUE.showToast(`✅ Added "${title}" to collection`);
        }
    },

    removeProductFromCollection: function(elementId, title) {
        const el = document.getElementById(elementId);
        if (el) {
            el.style.transition = 'all 0.2s ease';
            el.style.opacity = '0';
            el.style.transform = 'scale(0.95)';
            setTimeout(() => {
                el.remove();
                if (window.DT_CATALOGUE) {
                    window.DT_CATALOGUE.showToast(`Removed "${title}" from collection`);
                }
            }, 200);
        }
    },

    toggleFeatured: function(btn, id, title) {
        const isFeatured = btn.classList.toggle('active');
        if (window.DT_CATALOGUE) {
            window.DT_CATALOGUE.showToast(isFeatured ? `⭐ Marked "${title}" as Featured` : `Removed "${title}" from Featured`);
        }
    }
};
