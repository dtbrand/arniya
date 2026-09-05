/**
 * documents.js — Invoice, Packing Slip & Shipping Label Actions
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    window.DT_DOCS = {
        printDoc: function() {
            window.print();
        },

        downloadPdf: function(docType, docId) {
            if (window.DT_ORDERS) {
                const idStr = docId ? ` for ${docId}` : '';
                window.DT_ORDERS.showToast(`Preparing ${docType} document${idStr}...`);
            }
            setTimeout(() => {
                window.print();
            }, 500);
        }
    };
})();
