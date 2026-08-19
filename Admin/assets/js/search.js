/**
 * search.js — ARNIYA Admin Global Search Engine
 * Features ⌘K shortcut, left icon standard, and 1-tap clear button
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        initGlobalSearch();
    });

    function initGlobalSearch() {
        const searchInput = document.getElementById('admGlobalSearchInput');
        const clearBtn = document.getElementById('admSearchClearBtn');

        if (searchInput) {
            // Live typing & clear button visibility
            searchInput.addEventListener('input', function() {
                if (clearBtn) {
                    clearBtn.style.display = this.value.trim().length > 0 ? 'flex' : 'none';
                }
                handleSearchFiltering(this.value.trim().toLowerCase());
            });

            // 1-Tap Clear Button Click
            if (clearBtn) {
                clearBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    clearBtn.style.display = 'none';
                    searchInput.focus();
                    handleSearchFiltering('');
                });
            }

            // Keyboard shortcut (⌘K / Ctrl+K) to focus search
            document.addEventListener('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && (e.key === 'k' || e.code === 'KeyK')) {
                    e.preventDefault();
                    searchInput.focus();
                    searchInput.select();
                }
            });
        }
    }

    // Dynamic Client Table Filtering
    function handleSearchFiltering(query) {
        const rows = document.querySelectorAll('.adm-searchable-row');
        if (!rows || rows.length === 0) return;

        rows.forEach(function(row) {
            const text = row.innerText.toLowerCase();
            row.style.display = (query === '' || text.indexOf(query) !== -1) ? '' : 'none';
        });
    }

})();
