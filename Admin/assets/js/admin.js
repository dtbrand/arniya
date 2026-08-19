/**
 * admin.js — ARNIYA Admin Master JavaScript Core Engine
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    // ════ GLOBAL TOAST NOTIFICATION SYSTEM ════
    window.showToast = function(message, type) {
        type = type || 'info';
        const container = document.getElementById('admToastContainer');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'adm-toast ' + type;
        toast.innerHTML = '<span>' + message + '</span>';
        container.appendChild(toast);

        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(function() {
                if (toast.parentNode) toast.parentNode.removeChild(toast);
            }, 300);
        }, 3500);
    };

    // ════ INITIALIZATION ON DOM READY ════
    document.addEventListener('DOMContentLoaded', function() {
        initProfileDropdown();
        initQuickActionDropdown();
        initLiveTickers();
    });

    // Profile Dropdown
    function initProfileDropdown() {
        const trigger = document.getElementById('admProfileTrigger');
        const menu = document.getElementById('admProfileMenu');

        if (trigger && menu) {
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('open');
                const quickMenu = document.getElementById('admQuickActionMenu');
                if (quickMenu) quickMenu.classList.remove('open');
            });

            document.addEventListener('click', function(e) {
                if (!menu.contains(e.target) && !trigger.contains(e.target)) {
                    menu.classList.remove('open');
                }
            });
        }
    }

    // Quick Action Dropdown
    function initQuickActionDropdown() {
        const btn = document.getElementById('admQuickActionBtn');
        const menu = document.getElementById('admQuickActionMenu');

        if (btn && menu) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('open');
                const profMenu = document.getElementById('admProfileMenu');
                if (profMenu) profMenu.classList.remove('open');
            });

            document.addEventListener('click', function(e) {
                if (!menu.contains(e.target) && !btn.contains(e.target)) {
                    menu.classList.remove('open');
                }
            });
        }
    }

    // Live Ticker Mock for Future Real-Time PHP/WebSockets
    function initLiveTickers() {
        const liveUsersEl = document.getElementById('liveUsersCount');
        if (liveUsersEl) {
            setInterval(function() {
                const current = parseInt(liveUsersEl.innerText.replace(/,/g, ''), 10) || 142;
                const change = Math.floor(Math.random() * 5) - 2;
                const updated = Math.max(90, current + change);
                liveUsersEl.innerText = updated.toLocaleString();
            }, 4000);
        }
    }

})();
