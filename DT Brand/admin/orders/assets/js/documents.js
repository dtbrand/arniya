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
                window.DT_ORDERS.showToast(`📄 Preparing ${docType} PDF for ${docId || 'DTB-001624'}...`);
            }
            setTimeout(() => {
                window.print();
            }, 500);
        }
    };
})();
