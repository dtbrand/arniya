/**
 * admin/assets/js/components.js — Client-Side Micro-Engine for UI Component Library
 * DT Brand's & Jai Hanuman Tex — Section 39
 * 
 * Supports: Modals, Confirmation Dialogs, Drawers, Tabs, Toast Notifications,
 * Data Table client sorting & search, Bulk Action Bar, Date Range Presets, Media Uploader,
 * Rupee SVG copy, and Accessibility focus/ESC handling.
 */

(function(window, document) {
    'use strict';

    const DTComponents = {
        /**
         * 1. Toast Notification System
         * @param {string} message 
         * @param {'success'|'danger'|'warning'|'info'} type 
         * @param {number} duration 
         */
        toast: function(message, type = 'info', duration = 3500) {
            let container = document.querySelector('.dt-toast-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'dt-toast-container';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.className = `dt-toast dt-toast-${type}`;

            let iconSvg = '';
            let borderColor = '#D4AF37';

            if (type === 'success') {
                borderColor = '#15803D';
                iconSvg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"></path></svg>';
            } else if (type === 'danger' || type === 'error') {
                borderColor = '#DC2626';
                iconSvg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
            } else if (type === 'warning') {
                borderColor = '#B45309';
                iconSvg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
            } else {
                borderColor = '#D4AF37';
                iconSvg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>';
            }

            toast.style.borderLeftColor = borderColor;
            toast.innerHTML = `
                <div style="display:flex; align-items:center; justify-content:center; flex-shrink:0;">${iconSvg}</div>
                <div style="flex:1; line-height:1.4; font-size:0.85rem;">${message}</div>
                <button type="button" style="background:none; border:none; color:#94A3B8; font-size:1.2rem; cursor:pointer; line-height:1; padding:0 0 0 8px;" onclick="this.parentElement.remove()">&times;</button>
            `;

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.add('show');
            });

            if (duration > 0) {
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => {
                        if (toast.parentElement) toast.remove();
                    }, 300);
                }, duration);
            }
        },

        /**
         * 2. Modal Controls
         * @param {string} modalId 
         */
        openModal: function(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';

            // Focus on first input if present
            const input = modal.querySelector('input:not([type=hidden]), button:not(.dt-modal-close)');
            if (input) setTimeout(() => input.focus(), 50);

            document.dispatchEvent(new CustomEvent('dt:modal:opened', { detail: { id: modalId } }));
        },

        closeModal: function(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.remove('active');

            // Restore scroll if no other active modal/drawer
            if (!document.querySelector('.dt-modal-overlay.active, .dt-drawer-overlay.active')) {
                document.body.style.overflow = '';
            }

            document.dispatchEvent(new CustomEvent('dt:modal:closed', { detail: { id: modalId } }));
        },

        /**
         * 3. Drawer Controls
         * @param {string} drawerId 
         */
        openDrawer: function(drawerId) {
            const drawer = document.getElementById(drawerId);
            if (!drawer) return;
            drawer.classList.add('active');
            document.body.style.overflow = 'hidden';
            document.dispatchEvent(new CustomEvent('dt:drawer:opened', { detail: { id: drawerId } }));
        },

        closeDrawer: function(drawerId) {
            const drawer = document.getElementById(drawerId);
            if (!drawer) return;
            drawer.classList.remove('active');

            if (!document.querySelector('.dt-modal-overlay.active, .dt-drawer-overlay.active')) {
                document.body.style.overflow = '';
            }

            document.dispatchEvent(new CustomEvent('dt:drawer:closed', { detail: { id: drawerId } }));
        },

        /**
         * 4. Tab Switching
         * @param {HTMLElement} btn 
         * @param {string} targetId 
         */
        switchTab: function(btn, targetId) {
            const nav = btn.closest('.dt-tabs-nav') || btn.parentElement;
            if (nav) {
                nav.querySelectorAll('.dt-tab-btn').forEach(b => b.classList.remove('active'));
            }
            btn.classList.add('active');

            // Find matching tab pane
            const container = btn.closest('.dt-tabs-container') || document;
            const panes = container.querySelectorAll('.dt-tab-pane, [data-tab-content]');
            panes.forEach(pane => {
                const paneId = pane.id || pane.getAttribute('data-tab-content');
                if (paneId === targetId || paneId === 'tab-' + targetId) {
                    pane.style.display = 'block';
                    pane.classList.add('active');
                } else if (pane.closest('.dt-tabs-container') === container || container === document) {
                    pane.style.display = 'none';
                    pane.classList.remove('active');
                }
            });

            document.dispatchEvent(new CustomEvent('dt:tab:changed', { detail: { targetId } }));
        },

        /**
         * 5. Date Range Selector Preset
         * @param {HTMLElement} pill 
         * @param {string} rangeKey 
         */
        selectDateRange: function(pill, rangeKey) {
            const wrap = pill.closest('.dt-daterange-wrap');
            if (wrap) {
                wrap.querySelectorAll('.dt-date-pill').forEach(p => p.classList.remove('active'));
            }
            pill.classList.add('active');

            const now = new Date();
            let start = new Date();
            let end = new Date();

            if (rangeKey === 'today') {
                // start and end are today
            } else if (rangeKey === 'yesterday') {
                start.setDate(now.getDate() - 1);
                end.setDate(now.getDate() - 1);
            } else if (rangeKey === '7days') {
                start.setDate(now.getDate() - 7);
            } else if (rangeKey === '30days') {
                start.setDate(now.getDate() - 30);
            } else if (rangeKey === 'month') {
                start = new Date(now.getFullYear(), now.getMonth(), 1);
            }

            const formatDate = (d) => d.toISOString().split('T')[0];
            const startInput = document.getElementById('date-start');
            const endInput = document.getElementById('date-end');
            if (startInput && endInput && rangeKey !== 'custom') {
                startInput.value = formatDate(start);
                endInput.value = formatDate(end);
            }

            DTComponents.toast(`Selected date range: ${pill.textContent.trim()}`, 'info', 2000);
            document.dispatchEvent(new CustomEvent('dt:daterange:changed', { detail: { range: rangeKey, start, end } }));
        },

        /**
         * 6. Bulk Action Bar & Table Checkbox Selection
         * @param {string} tableId 
         */
        initBulkSelection: function(tableId) {
            const table = document.getElementById(tableId);
            if (!table) return;

            const selectAll = table.querySelector('.dt-select-all');
            const rowSelects = table.querySelectorAll('.dt-row-select');
            const bulkBar = document.getElementById(tableId + '-bulk-bar');
            const countLabel = document.getElementById(tableId + '-selected-count');

            const updateState = () => {
                const checked = table.querySelectorAll('.dt-row-select:checked');
                const count = checked.length;

                if (countLabel) countLabel.textContent = count;

                if (bulkBar) {
                    if (count > 0) {
                        bulkBar.style.display = 'flex';
                    } else {
                        bulkBar.style.display = 'none';
                    }
                }

                if (selectAll) {
                    selectAll.checked = count === rowSelects.length && rowSelects.length > 0;
                    selectAll.indeterminate = count > 0 && count < rowSelects.length;
                }
            };

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    rowSelects.forEach(cb => { cb.checked = selectAll.checked; });
                    updateState();
                });
            }

            rowSelects.forEach(cb => {
                cb.addEventListener('change', updateState);
            });
        },

        clearSelection: function(tableId) {
            const table = document.getElementById(tableId);
            if (!table) return;

            const selectAll = table.querySelector('.dt-select-all');
            if (selectAll) {
                selectAll.checked = false;
                selectAll.indeterminate = false;
            }

            const rowSelects = table.querySelectorAll('.dt-row-select');
            rowSelects.forEach(cb => { cb.checked = false; });

            const countLabel = document.getElementById(tableId + '-selected-count');
            if (countLabel) countLabel.textContent = '0';

            const bulkBar = document.getElementById(tableId + '-bulk-bar');
            if (bulkBar) bulkBar.style.display = 'none';
        },

        /**
         * 7. Client-Side Table Search / Filter
         * @param {string} tableId 
         * @param {string} query 
         */
        filterTable: function(tableId, query) {
            const table = document.getElementById(tableId);
            if (!table) return;

            const rows = table.querySelectorAll('tbody tr:not(.dt-no-filter)');
            const q = query.toLowerCase().trim();

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = (q === '' || text.includes(q)) ? '' : 'none';
            });
        },

        /**
         * 8. Client-Side Table Column Sorting
         * @param {string} tableId 
         * @param {number} colIndex 
         */
        sortTable: function(tableId, colIndex) {
            const table = document.getElementById(tableId);
            if (!table) return;

            const tbody = table.querySelector('tbody');
            if (!tbody) return;

            const rows = Array.from(tbody.querySelectorAll('tr'));
            const th = table.querySelectorAll('th')[colIndex];
            const isAsc = th ? !th.classList.contains('dt-sort-asc') : true;

            // Reset sort indicators
            table.querySelectorAll('th').forEach(h => h.classList.remove('dt-sort-asc', 'dt-sort-desc'));
            if (th) th.classList.add(isAsc ? 'dt-sort-asc' : 'dt-sort-desc');

            rows.sort((a, b) => {
                const aVal = (a.children[colIndex] ? a.children[colIndex].textContent.trim() : '');
                const bVal = (b.children[colIndex] ? b.children[colIndex].textContent.trim() : '');

                // Check if numeric or currency
                const aNum = parseFloat(aVal.replace(/[^0-9.-]/g, ''));
                const bNum = parseFloat(bVal.replace(/[^0-9.-]/g, ''));

                if (!isNaN(aNum) && !isNaN(bNum)) {
                    return isAsc ? aNum - bNum : bNum - aNum;
                }
                return isAsc ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
            });

            rows.forEach(r => tbody.appendChild(r));
        },

        /**
         * 9. Clipboard Copy Helper
         * @param {string} text 
         * @param {string} successMessage 
         */
        copyToClipboard: function(text, successMessage = 'Copied to clipboard') {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    DTComponents.toast(successMessage, 'success');
                }).catch(() => {
                    DTComponents._legacyCopy(text, successMessage);
                });
            } else {
                DTComponents._legacyCopy(text, successMessage);
            }
        },

        _legacyCopy: function(text, successMessage) {
            const el = document.createElement('textarea');
            el.value = text;
            el.style.position = 'fixed';
            el.style.left = '-9999px';
            document.body.appendChild(el);
            el.select();
            try {
                document.execCommand('copy');
                DTComponents.toast(successMessage, 'success');
            } catch (err) {
                DTComponents.toast('Failed to copy', 'danger');
            }
            document.body.removeChild(el);
        },

        /**
         * 10. Media Uploader Drag & Drop / Preview Initialization
         * @param {string} uploaderId 
         */
        initMediaUploader: function(uploaderId) {
            const uploader = document.getElementById(uploaderId);
            if (!uploader) return;

            const fileInput = uploader.querySelector('input[type="file"]');
            const previewArea = uploader.querySelector('.dt-media-previews') || document.getElementById(uploaderId + '-previews');

            ['dragenter', 'dragover'].forEach(eventName => {
                uploader.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    uploader.classList.add('dt-dragover');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploader.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    uploader.classList.remove('dt-dragover');
                }, false);
            });

            uploader.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (fileInput) {
                    fileInput.files = files;
                    DTComponents._handleFiles(files, previewArea);
                }
            });

            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    DTComponents._handleFiles(this.files, previewArea);
                });
            }
        },

        _handleFiles: function(files, previewArea) {
            if (!previewArea || !files.length) return;
            previewArea.innerHTML = '';
            Array.from(files).forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    const thumb = document.createElement('div');
                    thumb.style.cssText = 'position:relative; width:64px; height:64px; border-radius:6px; overflow:hidden; border:1px solid #CBD5E1; display:inline-block; margin:4px;';
                    thumb.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;" alt="Preview">`;
                    previewArea.appendChild(thumb);
                };
                reader.readAsDataURL(file);
            });
            DTComponents.toast(`${files.length} file(s) selected for upload`, 'info');
        },

        /**
         * Master Auto-Init for DOM Loaded
         */
        init: function() {
            // 1. Close modal or drawer on backdrop click
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('dt-modal-overlay')) {
                    DTComponents.closeModal(e.target.id);
                }
                if (e.target.classList.contains('dt-drawer-overlay')) {
                    DTComponents.closeDrawer(e.target.id);
                }
            });

            // 2. ESC key closes topmost open modal / drawer
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const openModal = document.querySelector('.dt-modal-overlay.active');
                    if (openModal) {
                        DTComponents.closeModal(openModal.id);
                        return;
                    }
                    const openDrawer = document.querySelector('.dt-drawer-overlay.active');
                    if (openDrawer) {
                        DTComponents.closeDrawer(openDrawer.id);
                    }
                }
            });

            // 3. Auto-init bulk selection on all data tables
            document.querySelectorAll('.dt-component-table').forEach(table => {
                if (table.id) {
                    DTComponents.initBulkSelection(table.id);
                }
            });

            // 4. Auto-init sortable table headers
            document.querySelectorAll('.dt-component-table th.dt-sortable').forEach(th => {
                th.addEventListener('click', function() {
                    const table = this.closest('table');
                    if (!table) return;
                    const colIndex = Array.from(this.parentElement.children).indexOf(this);
                    DTComponents.sortTable(table.id, colIndex);
                });
            });

            // 5. Auto-init media uploaders
            document.querySelectorAll('.dt-media-uploader').forEach(uploader => {
                if (uploader.id) {
                    DTComponents.initMediaUploader(uploader.id);
                }
            });
        }
    };

    // Expose to window
    window.DTComponents = DTComponents;

    // Run init on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', DTComponents.init);
    } else {
        DTComponents.init();
    }
})(window, document);
