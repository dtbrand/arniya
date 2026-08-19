/**
 * navigation.js — ARNIYA Admin Navigation & Sidebar Collapse Controller
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        initSidebarToggle();
        initKeyboardShortcuts();
    });

    function initSidebarToggle() {
        const sidebar = document.getElementById('admSidebar');
        const toggleBtn = document.getElementById('admSidebarToggleBtn');
        const mobToggleBtn = document.getElementById('admMobToggleBtn');
        const overlay = document.getElementById('admSidebarOverlay');
        const sealMini = document.querySelector('.adm-brand-seal-mini');

        // Desktop Collapse / Expand Toggle
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('arni_adm_sidebar_collapsed', sidebar.classList.contains('collapsed') ? '1' : '0');
            });
        }

        // Mini Seal Click in Collapsed Mode expands sidebar
        if (sealMini && sidebar) {
            sealMini.addEventListener('click', function(e) {
                if (sidebar.classList.contains('collapsed')) {
                    e.preventDefault();
                    e.stopPropagation();
                    sidebar.classList.remove('collapsed');
                    localStorage.setItem('arni_adm_sidebar_collapsed', '0');
                }
            });
        }

        // Restore Saved Sidebar State
        if (sidebar && localStorage.getItem('arni_adm_sidebar_collapsed') === '1' && window.innerWidth >= 1200) {
            sidebar.classList.add('collapsed');
        }

        // Mobile Sidebar Open / Close
        if (mobToggleBtn && sidebar) {
            mobToggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
                if (overlay) overlay.classList.toggle('active', sidebar.classList.contains('mobile-open'));
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function() {
                if (sidebar) sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
            });
        }
    }

    // Keyboard Shortcuts: Alt + [ to toggle sidebar, Esc to close modals
    function initKeyboardShortcuts() {
        document.addEventListener('keydown', function(e) {
            if (e.altKey && (e.key === '[' || e.code === 'BracketLeft')) {
                e.preventDefault();
                const sidebar = document.getElementById('admSidebar');
                if (sidebar) {
                    sidebar.classList.toggle('collapsed');
                    localStorage.setItem('arni_adm_sidebar_collapsed', sidebar.classList.contains('collapsed') ? '1' : '0');
                }
            }
        });
    }

})();
