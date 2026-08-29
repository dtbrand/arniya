/**
 * import.js — 7-Step Import Wizard Controller
 */
(function() {
    'use strict';

    window.goToImportStep = function(stepNum) {
        document.querySelectorAll('.dt-import-step-pane').forEach(p => p.style.display = 'none');
        document.querySelectorAll('.dt-step-node').forEach(n => n.classList.remove('active'));

        const targetPane = document.getElementById('dtImportStep' + stepNum);
        const targetNode = document.getElementById('dtStepNode' + stepNum);

        if (targetPane) targetPane.style.display = 'block';
        if (targetNode) targetNode.classList.add('active');

        window.scrollTo({ top: 120, behavior: 'smooth' });
    };
})();
