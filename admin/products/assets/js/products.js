/**
 * products.js — DT Brand's & Jai Hanuman Tex Products Module Master Controller
 */
(function() {
    'use strict';
    if (!window.DTProducts) {
        // Load master engine if not loaded yet
        var s = document.createElement('script');
        s.src = '/admin/products/products.js?v=' + Date.now();
        document.head.appendChild(s);
    }
})();
