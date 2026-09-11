/**
 * audit.js — Enterprise Audit Log Admin Client Controller
 * Section 35: Central Enterprise Audit Log Admin
 * DT Brand's & Jai Hanuman Tex
 */

(function () {
    'use strict';

    // Toast notification utility
    window.showAuditToast = function (message, type = 'info') {
        let toast = document.getElementById('auditToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'auditToast';
            toast.className = 'audit-toast';
            document.body.appendChild(toast);
        }

        const iconSvg = type === 'success'
            ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`
            : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>`;

        toast.innerHTML = `${iconSvg} <span>${message}</span>`;
        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
        }, 3200);
    };

    // Copy to clipboard
    window.copyCorrelationId = function (e, corrId) {
        if (e) {
            e.stopPropagation();
        }
        if (!corrId) return;

        navigator.clipboard.writeText(corrId).then(() => {
            window.showAuditToast(`Correlation ID copied: ${corrId}`, 'success');
        }).catch(() => {
            window.showAuditToast(`ID: ${corrId}`, 'info');
        });
    };

    // Close any active modal
    window.closeAuditModal = function () {
        const modals = document.querySelectorAll('.audit-modal-backdrop');
        modals.forEach(m => m.classList.remove('open'));
    };

    // Open Diff Modal for single audit event
    window.inspectAuditDiff = function (logId) {
        const modal = document.getElementById('auditDiffModal');
        const modalBody = document.getElementById('auditDiffModalBody');
        const modalSubtitle = document.getElementById('auditDiffModalSub');

        if (!modal || !modalBody) return;

        modalBody.innerHTML = `
            <div style="text-align:center; padding: 40px 0; color: #64748B;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite; margin-bottom: 8px;">
                    <line x1="12" y1="2" x2="12" y2="6"></line>
                    <line x1="12" y1="18" x2="12" y2="22"></line>
                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                    <line x1="2" y1="12" x2="6" y2="12"></line>
                    <line x1="18" y1="12" x2="22" y2="12"></line>
                </svg>
                <div style="font-weight: 600;">Retrieving forensic audit state diff...</div>
            </div>
        `;
        modal.classList.add('open');

        fetch(`/api/audit.php?action=detail&id=${logId}`)
            .then(res => res.json())
            .then(res => {
                if (!res.success || !res.data) {
                    modalBody.innerHTML = `<div style="color: #DC2626; padding: 20px; text-align: center;">Error loading event: ${res.message || 'Unknown error'}</div>`;
                    return;
                }

                const item = res.data;
                if (modalSubtitle) {
                    modalSubtitle.textContent = `Event #${item.id} — ${item.action} on ${item.entity_type} (${item.entity_id}) by ${item.user_name}`;
                }

                const oldState = item.old_values ? JSON.stringify(item.old_values, null, 2) : 'No prior state recorded (creation / external event)';
                const newState = item.new_values ? JSON.stringify(item.new_values, null, 2) : 'No resulting state recorded (deletion / sign-out)';

                let diffSummaryHtml = '';
                if (item.diff) {
                    const addedCount = Object.keys(item.diff.added || {}).length;
                    const modCount = Object.keys(item.diff.modified || {}).length;
                    const remCount = Object.keys(item.diff.removed || {}).length;

                    diffSummaryHtml = `
                        <div style="display:flex; gap:12px; margin-bottom: 12px; font-size: 0.76rem; font-weight: 700;">
                            <span style="color:#15803D; background:#DCFCE7; padding:2px 8px; border-radius:4px;">+ ${addedCount} Added</span>
                            <span style="color:#B45309; background:#FEF3C7; padding:2px 8px; border-radius:4px;">~ ${modCount} Modified</span>
                            <span style="color:#DC2626; background:#FEF2F2; padding:2px 8px; border-radius:4px;">- ${remCount} Removed</span>
                        </div>
                    `;
                }

                modalBody.innerHTML = `
                    <div style="margin-bottom: 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 12px 16px; font-size: 0.82rem;">
                        <div style="margin-bottom: 4px;"><strong>Details:</strong> ${escapeHtml(item.details || 'No description')}</div>
                        <div style="display: flex; gap: 24px; color: #64748B; font-size: 0.76rem; flex-wrap: wrap;">
                            <span><strong>Correlation ID:</strong> <code>${item.correlation_id || 'N/A'}</code></span>
                            <span><strong>Client IP:</strong> <code>${item.ip_address || 'N/A'}</code></span>
                            <span><strong>Actor Role:</strong> ${item.actor_role || 'admin'}</span>
                            <span><strong>Timestamp:</strong> ${item.created_at || 'N/A'}</span>
                        </div>
                    </div>

                    ${diffSummaryHtml}

                    <div class="diff-container">
                        <div class="diff-box">
                            <div class="diff-box-title before">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                Before State
                            </div>
                            <pre style="margin: 0; white-space: pre-wrap;">${escapeHtml(oldState)}</pre>
                        </div>
                        <div class="diff-box">
                            <div class="diff-box-title after">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                After State
                            </div>
                            <pre style="margin: 0; white-space: pre-wrap;">${escapeHtml(newState)}</pre>
                        </div>
                    </div>
                `;
            })
            .catch(err => {
                modalBody.innerHTML = `<div style="color: #DC2626; padding: 20px; text-align: center;">Network error while fetching diff: ${err.message}</div>`;
            });
    };

    // Open Correlation Trace Modal
    window.inspectCorrelation = function (corrId) {
        if (!corrId) return;

        const modal = document.getElementById('auditTraceModal');
        const modalBody = document.getElementById('auditTraceModalBody');
        const modalSubtitle = document.getElementById('auditTraceModalSub');

        if (!modal || !modalBody) return;

        if (modalSubtitle) modalSubtitle.textContent = `Tracing Request Chain: ${corrId}`;
        modalBody.innerHTML = `<div style="text-align:center; padding: 30px; color:#64748B;">Loading causality chain...</div>`;
        modal.classList.add('open');

        fetch(`/api/audit.php?action=trace&correlation_id=${encodeURIComponent(corrId)}`)
            .then(r => r.json())
            .then(res => {
                if (!res.success || !res.data || res.data.length === 0) {
                    modalBody.innerHTML = `<div style="text-align:center; padding: 20px; color: #64748B;">No chained events found for correlation ID: <code>${escapeHtml(corrId)}</code></div>`;
                    return;
                }

                let listHtml = `
                    <div style="border-left: 2px solid #D4AF37; margin-left: 16px; padding-left: 20px;">
                `;

                res.data.forEach((evt, idx) => {
                    listHtml += `
                        <div style="position: relative; margin-bottom: 20px;">
                            <div style="position: absolute; left: -27px; top: 2px; width: 12px; height: 12px; border-radius: 50%; background: #D4AF37; border: 2px solid #FFFFFF;"></div>
                            <div style="font-size: 0.75rem; color: #64748B; margin-bottom: 2px;">Step ${idx + 1} — ${evt.created_at}</div>
                            <div style="font-weight: 700; color: #111827; font-size: 0.9rem;">
                                <span class="cat-badge ${evt.entity_type}">${evt.entity_type}</span>
                                <span style="margin-left: 4px;">${escapeHtml(evt.action)}</span> — <code>${escapeHtml(evt.entity_id)}</code>
                            </div>
                            <div style="font-size: 0.82rem; color: #334155; margin-top: 4px;">${escapeHtml(evt.details || '')}</div>
                            <div style="font-size: 0.74rem; color: #64748B; margin-top: 4px;">Actor: <strong>${escapeHtml(evt.user_name || 'system')}</strong> (${evt.actor_role}) • IP: <code>${evt.ip_address}</code></div>
                        </div>
                    `;
                });

                listHtml += `</div>`;
                modalBody.innerHTML = listHtml;
            })
            .catch(err => {
                modalBody.innerHTML = `<div style="color:#DC2626; padding:20px; text-align:center;">Failed to trace correlation: ${err.message}</div>`;
            });
    };

    // Helper: HTML entity escaping
    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Keyboard ESC to close modal
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            window.closeAuditModal();
        }
    });
})();
