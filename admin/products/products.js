/**
 * products.js — DT Brand's & Jai Hanuman Tex Products Suite Master JavaScript Engine
 * Zero Raw Dialogs Standard | 100% Styled Modal Dialogs | AJAX Catalog CRUD
 */

(function () {
    'use strict';

    const DTProducts = {
        csrfToken: window.DT_ADMIN_CSRF_TOKEN || '',

        // ── Toast Notification Helper ──
        showToast: function (msg, type = 'info') {
            if (typeof window.showToast === 'function') {
                window.showToast(msg, type);
                return;
            }
            let toastBox = document.getElementById('dtGlobalToastBox');
            if (!toastBox) {
                toastBox = document.createElement('div');
                toastBox.id = 'dtGlobalToastBox';
                toastBox.style.cssText = 'position:fixed; bottom:24px; right:24px; z-index:99999; display:flex; flex-direction:column; gap:8px; pointer-events:none;';
                document.body.appendChild(toastBox);
            }
            const toast = document.createElement('div');
            const bg = type === 'error' ? '#DC2626' : (type === 'success' ? '#15803D' : '#8A681F');
            toast.style.cssText = `background:${bg}; color:#FFF; padding:10px 16px; border-radius:6px; font-size:13px; font-weight:700; box-shadow:0 4px 14px rgba(0,0,0,0.25); opacity:0; transform:translateY(10px); transition:all 0.25s ease; pointer-events:auto; font-family:'Inter', sans-serif; display:flex; align-items:center; gap:8px;`;
            toast.innerHTML = `<span>${msg}</span>`;
            toastBox.appendChild(toast);
            requestAnimationFrame(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateY(0)';
            });
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-10px)';
                setTimeout(() => toast.remove(), 250);
            }, 3500);
        },

        // ── Styled Modal Confirmation System (ZERO Raw confirm()) ──
        confirmModal: function (title, message, onConfirm, confirmBtnText = 'Confirm Action', isDestructive = true) {
            let modal = document.getElementById('dtDynamicConfirmModal');
            if (!modal) {
                modal = document.createElement('div');
                modal.id = 'dtDynamicConfirmModal';
                modal.className = 'dt-modal-backdrop';
                modal.innerHTML = `
                    <div class="dt-modal-dialog">
                        <div class="dt-modal-header">
                            <div class="dt-modal-title" id="dtConfirmModalTitle">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                    <line x1="12" y1="9" x2="12" y2="13"></line>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                                <span id="dtConfirmTitleText">Confirm Action</span>
                            </div>
                            <button type="button" class="dt-modal-close" onclick="DTProducts.closeConfirmModal()">&times;</button>
                        </div>
                        <div class="dt-modal-body" id="dtConfirmModalBody">
                            Are you sure you want to proceed with this operation?
                        </div>
                        <div class="dt-modal-footer">
                            <button type="button" class="dt-btn-pale" onclick="DTProducts.closeConfirmModal()" style="height:32px; padding:0 14px; font-size:12px;">Cancel</button>
                            <button type="button" id="dtConfirmModalBtn" class="dt-btn-gold" style="height:32px; padding:0 16px; font-size:12px;">
                                Confirm
                            </button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
            }

            document.getElementById('dtConfirmTitleText').textContent = title || 'Confirm Action';
            document.getElementById('dtConfirmModalBody').textContent = message || 'Are you sure you want to perform this action?';
            
            const btn = document.getElementById('dtConfirmModalBtn');
            btn.textContent = confirmBtnText;
            if (isDestructive) {
                btn.className = 'dt-btn-crimson';
            } else {
                btn.className = 'dt-btn-gold';
            }

            btn.onclick = function () {
                DTProducts.closeConfirmModal();
                if (typeof onConfirm === 'function') {
                    onConfirm();
                }
            };

            modal.style.display = 'flex';
        },

        closeConfirmModal: function () {
            const modal = document.getElementById('dtDynamicConfirmModal');
            if (modal) {
                modal.style.display = 'none';
            }
        },

        // ── Admin Fetch Wrapper ──
        adminFetch: async function (url, options = {}) {
            const csrf = DTProducts.csrfToken || window.DT_ADMIN_CSRF_TOKEN || '';
            const headers = new Headers(options.headers || {});
            if (csrf) {
                headers.set('X-CSRF-Token', csrf);
            }
            if (!headers.has('Content-Type')) {
                headers.set('Content-Type', 'application/x-www-form-urlencoded');
            }
            return fetch(url, { ...options, headers });
        },

        // ── Trash / Permanently Delete Product ──
        trashProduct: function (rowId, productName) {
            DTProducts.confirmModal(
                'Delete Product from Catalog',
                `Are you sure you want to permanently delete "${productName}" from the database and live storefront? This action cannot be undone.`,
                function () {
                    const row = document.getElementById(rowId);
                    const prodId = rowId.replace('row-prod-', '').replace('card-prod-', '');

                    DTProducts.showToast(`Deleting "${productName}"...`, 'info');

                    DTProducts.adminFetch('/api/products.php', {
                        method: 'POST',
                        body: 'action=delete&id=' + encodeURIComponent(prodId)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (row) {
                                row.style.transition = 'all 0.3s ease';
                                row.style.opacity = '0';
                                row.style.transform = 'scale(0.95)';
                                setTimeout(() => row.remove(), 300);
                            }
                            const card = document.getElementById('card-prod-' + prodId);
                            if (card) {
                                card.style.transition = 'all 0.3s ease';
                                card.style.opacity = '0';
                                card.style.transform = 'scale(0.95)';
                                setTimeout(() => card.remove(), 300);
                            }
                            DTProducts.showToast(`"${productName}" permanently deleted from catalog.`, 'success');
                        } else {
                            DTProducts.showToast(data.message || 'Failed to delete product.', 'error');
                        }
                    })
                    .catch(err => {
                        console.error('Delete error:', err);
                        if (row) row.remove();
                        DTProducts.showToast('Product removed locally.', 'info');
                    });
                },
                'Delete Permanently',
                true
            );
        },

        // ── Duplicate Product Row ──
        duplicateProduct: function (rowId) {
            const prodId = rowId.replace('row-prod-', '').replace('card-prod-', '');
            DTProducts.showToast('Duplicating product in catalog...', 'info');

            DTProducts.adminFetch('/api/products.php', {
                method: 'POST',
                body: 'action=duplicate&id=' + encodeURIComponent(prodId)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    DTProducts.showToast('Product cloned successfully! Reloading...', 'success');
                    setTimeout(() => window.location.reload(), 450);
                } else {
                    DTProducts.showToast('Error duplicating: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(err => {
                console.error(err);
                DTProducts.showToast('Network error while duplicating product', 'error');
            });
        },

        // ── Bulk Delete Products ──
        bulkDelete: function (ids, onDone) {
            if (!ids || ids.length === 0) {
                DTProducts.showToast('No products selected for deletion.', 'info');
                return;
            }

            DTProducts.confirmModal(
                'Bulk Delete Products',
                `Are you sure you want to permanently delete ${ids.length} selected product(s) from the database? This cannot be undone.`,
                function () {
                    DTProducts.showToast(`Deleting ${ids.length} products...`, 'info');

                    DTProducts.adminFetch('/api/products.php', {
                        method: 'POST',
                        body: 'action=bulk_delete&ids=' + encodeURIComponent(ids.join(','))
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            DTProducts.showToast(data.message || `Deleted ${ids.length} products.`, 'success');
                            if (typeof onDone === 'function') {
                                onDone();
                            } else {
                                setTimeout(() => window.location.reload(), 450);
                            }
                        } else {
                            DTProducts.showToast(data.message || 'Bulk delete failed.', 'error');
                        }
                    })
                    .catch(err => {
                        console.error('Bulk delete error:', err);
                        DTProducts.showToast('Network error on bulk delete.', 'error');
                        setTimeout(() => window.location.reload(), 450);
                    });
                },
                `Delete ${ids.length} Products`,
                true
            );
        },

        // ── Toggle Featured Status ──
        toggleFeatured: function (btn, rowId, productName) {
            const prodId = rowId.replace('row-prod-', '');
            const isCurrentlyActive = btn.classList.contains('active');
            const newFeaturedVal = isCurrentlyActive ? 0 : 1;

            btn.classList.toggle('active');

            DTProducts.adminFetch('/api/products.php', {
                method: 'POST',
                body: 'action=quick_edit&id=' + encodeURIComponent(prodId) + '&is_featured=' + newFeaturedVal
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const statusText = newFeaturedVal ? 'marked as Featured' : 'removed from Featured';
                    DTProducts.showToast(`"${productName}" ${statusText}.`, 'success');
                } else {
                    btn.classList.toggle('active');
                    DTProducts.showToast(data.message || 'Failed to update featured status.', 'error');
                }
            })
            .catch(() => {
                DTProducts.showToast('Could not save featured status. Please retry.', 'error');
            });
        },

        // ── WhatsApp B2B Wholesale Share ──
        shareWhatsApp: function (productName, sku, wholesaleRate) {
            const message = encodeURIComponent(`*DT BRAND'S & JAI HANUMAN TEX — WHOLESALE INQUIRY*\n\n` +
                `*Product:* ${productName}\n` +
                `*SKU:* ${sku}\n` +
                `*Wholesale Rate:* ${wholesaleRate}/pc\n\n` +
                `Please send catalog details and minimum lot MOQ availability.`);
            window.open(`https://api.whatsapp.com/send?phone=917046363528&text=${message}`, '_blank');
        },

        // ── Quick Edit Price ──
        quickUpdatePrice: function (prodId, newPrice, onDone) {
            DTProducts.adminFetch('/api/products.php', {
                method: 'POST',
                body: `action=quick_edit&id=${encodeURIComponent(prodId)}&retail_price=${encodeURIComponent(newPrice)}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    DTProducts.showToast('Price updated successfully!', 'success');
                    if (onDone) onDone(data);
                } else {
                    DTProducts.showToast(data.message || 'Price update failed', 'error');
                }
            });
        },

        // ── Quick Adjust Stock ──
        adjustStock: function (prodId, delta, reason, onDone) {
            DTProducts.adminFetch('/api/products.php', {
                method: 'POST',
                body: `action=adjust_stock&id=${encodeURIComponent(prodId)}&delta=${encodeURIComponent(delta)}&reason=${encodeURIComponent(reason || 'Admin Quick Adjust')}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    DTProducts.showToast(`Stock adjusted by ${delta > 0 ? '+' : ''}${delta} units`, 'success');
                    if (onDone) onDone(data);
                } else {
                    DTProducts.showToast(data.message || 'Stock adjustment failed', 'error');
                }
            });
        },

        init: function () {
            // Expose globally for legacy scripts
            window.trashProductRow = function (rowId, productName) {
                DTProducts.trashProduct(rowId, productName);
            };
            window.duplicateProductRow = function (rowId) {
                DTProducts.duplicateProduct(rowId);
            };
            window.shareProductWhatsApp = function (name, sku, rate) {
                DTProducts.shareWhatsApp(name, sku, rate);
            };
            window.toggleFeaturedProduct = function (btn, rowId, productName) {
                DTProducts.toggleFeatured(btn, rowId, productName);
            };
        }
    };

    window.DTProducts = DTProducts;
    document.addEventListener('DOMContentLoaded', function () {
        DTProducts.init();
    });
})();
