/**
 * wholesale-view.js — DT Brand's & Jai Hanuman Tex
 * 360 Partner Profile Tab Switcher & Dynamic Content Manager
 */

(function () {
    'use strict';

    window.switchWholesaleTab = function (tabId, btnElement) {
        document.querySelectorAll('.dt-wholesale-tab-btn').forEach(btn => btn.classList.remove('active'));
        if (btnElement) btnElement.classList.add('active');

        document.querySelectorAll('.dt-wholesale-tab-pane').forEach(pane => pane.style.display = 'none');
        const activePane = document.getElementById('tabPane_' + tabId);
        if (activePane) activePane.style.display = 'block';
    };

})();
