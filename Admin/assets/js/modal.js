/**
 * modal.js — ARNIYA Admin Modal Management Controller
 */

(function() {
    'use strict';

    window.openAdmModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeAdmModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    };

    // Close on backdrop click & ESC key
    document.addEventListener('click', function(e) {
        if (e.target.classList && e.target.classList.contains('adm-modal-backdrop')) {
            e.target.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.adm-modal-backdrop').forEach(function(m) {
                m.style.display = 'none';
            });
            document.body.style.overflow = '';
        }
    });

    // Export Trigger Simulation
    window.triggerExportDownload = function() {
        const formatInput = document.querySelector('input[name="export_format"]:checked');
        const format = formatInput ? formatInput.value.toUpperCase() : 'CSV';
        
        window.closeAdmModal('admExportModal');
        window.showToast('📥 Preparing ' + format + ' export file for download...', 'info');

        setTimeout(function() {
            window.showToast('✅ ARNIYA_' + format + '_Report_2026.zip ready and downloaded!', 'emerald');
        }, 1200);
    };

    // Layout Customizer Save & Reset
    window.saveDashboardLayout = function() {
        window.closeAdmModal('admCustomizeModal');
        window.showToast('💾 Dashboard layout configuration saved successfully!', 'emerald');
    };

    window.resetDashboardLayout = function() {
        document.querySelectorAll('.adm-widget-item input').forEach(function(chk) {
            chk.checked = true;
        });
        window.showToast('🔄 Dashboard widgets reset to default layout.', 'info');
    };

})();
