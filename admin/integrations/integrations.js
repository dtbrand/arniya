/**
 * DT Brand's & Jai Hanuman Tex — Section 32: Integrations Admin Controller
 * AJAX actions for test connection, safe diagnostics, toggle status, and masked config saving.
 */

(function() {
    'use strict';

    window.testIntegrationConnection = function(slug, btnElement) {
        if (!slug) return;
        const btn = btnElement || event.currentTarget;
        const originalHtml = btn ? btn.innerHTML : '';
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="itg-pulse-dot"></span> Testing...';
        }

        fetch('/api/integrations.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'test_connection', slug: slug })
        })
        .then(response => response.json())
        .then(data => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
            if (data.success) {
                if (typeof window.showToast === 'function') {
                    window.showToast(`${slug.toUpperCase()} Connected! Status: ${data.http_status} OK (${data.latency_ms} ms)`, 'success');
                }
                // Update latency badge on card if present
                const latencyEl = document.getElementById(`latency-${slug}`);
                if (latencyEl) {
                    latencyEl.textContent = `${data.latency_ms} ms`;
                }
            } else {
                var errNotice = `Connection Test Failed for ${slug}: ${data.message || 'Unknown error'}`;
                if (typeof window.showToast === 'function') window.showToast(errNotice, 'error');
                else console.warn(errNotice);
            }
        })
        .catch(err => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
            var netErr = `Network error while testing ${slug}: ` + err.message;
            if (typeof window.showToast === 'function') window.showToast(netErr, 'error');
            else console.warn(netErr);
        });
    };

    window.toggleIntegration = function(slug, isChecked) {
        fetch('/api/integrations.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'toggle',
                slug: slug,
                is_enabled: isChecked ? 1 : 0
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const badge = document.getElementById(`badge-${slug}`);
                if (badge) {
                    if (isChecked) {
                        badge.className = 'itg-status-badge active';
                        badge.innerHTML = '<span class="itg-pulse-dot"></span> Active';
                    } else {
                        badge.className = 'itg-status-badge inactive';
                        badge.innerHTML = 'Inactive';
                    }
                }
            } else {
                var errNotice = 'Failed to update status: ' + (data.message || 'Unknown error');
                if (typeof window.showToast === 'function') window.showToast(errNotice, 'error');
                else console.warn(errNotice);
            }
        })
        .catch(err => {
            var netErr = 'Error toggling integration: ' + err.message;
            if (typeof window.showToast === 'function') window.showToast(netErr, 'error');
            else console.warn(netErr);
        });
    };

    window.openDiagnosticsModal = function(slug, name) {
        const modal = document.getElementById('itgDiagnosticsModal');
        const title = document.getElementById('itgDiagTitle');
        const container = document.getElementById('itgDiagResults');
        if (!modal || !container) return;

        if (title) title.textContent = `Safe Diagnostics: ${name || slug}`;
        container.innerHTML = '<div style="text-align:center; padding: 24px;"><span class="itg-pulse-dot"></span> Running 5-point safe diagnostic tests...</div>';
        modal.style.display = 'flex';

        fetch(`/api/integrations.php?action=diagnostics&slug=${encodeURIComponent(slug)}`)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.checks) {
                let html = '';
                data.checks.forEach(c => {
                    const statusClass = c.status === 'passed' ? 'passed' : (c.status === 'warning' ? 'warning' : 'failed');
                    const icon = c.status === 'passed' 
                        ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>'
                        : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';

                    html += `
                    <div class="itg-diag-item ${statusClass}">
                        <div class="itg-diag-icon">${icon}</div>
                        <div>
                            <div style="font-weight:700; color:#111827; font-size:0.88rem;">${c.name}</div>
                            <div style="font-size:0.8rem; color:#475569; margin-top:2px;">${c.details}</div>
                        </div>
                    </div>`;
                });
                container.innerHTML = html;
            } else {
                container.innerHTML = `<div style="color:#DC2626; padding:16px;">Failed to run diagnostics: ${data.message || 'Unknown'}</div>`;
            }
        })
        .catch(err => {
            container.innerHTML = `<div style="color:#DC2626; padding:16px;">Error: ${err.message}</div>`;
        });
    };

    window.closeDiagnosticsModal = function() {
        const modal = document.getElementById('itgDiagnosticsModal');
        if (modal) modal.style.display = 'none';
    };

    window.openConfigModal = function(slug, name) {
        const modal = document.getElementById('itgConfigModal');
        const title = document.getElementById('itgConfigTitle');
        const container = document.getElementById('itgConfigFields');
        const slugInput = document.getElementById('itgConfigSlug');
        if (!modal || !container) return;

        if (title) title.textContent = `Configure ${name || slug}`;
        if (slugInput) slugInput.value = slug;
        container.innerHTML = '<div style="text-align:center; padding: 24px;"><span class="itg-pulse-dot"></span> Loading credentials...</div>';
        modal.style.display = 'flex';

        fetch(`/api/integrations.php?action=detail&slug=${encodeURIComponent(slug)}`)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.integration) {
                const config = data.integration.config || {};
                let html = '';
                for (const [k, v] of Object.entries(config)) {
                    const isMasked = typeof v === 'string' && v.includes('••••');
                    const label = k.replace(/_/g, ' ').toUpperCase();
                    html += `
                    <div style="margin-bottom:14px;">
                        <label style="display:block; font-size:0.75rem; font-weight:700; color:#475569; margin-bottom:4px;">
                            ${label} ${isMasked ? '<span style="color:#B45309; font-size:0.7rem;">(Protected Secret)</span>' : ''}
                        </label>
                        <input type="text" name="config[${k}]" value="${v}" class="dt-input-field ${isMasked ? 'itg-secret-field' : ''}" style="width:100%;" />
                    </div>`;
                }
                container.innerHTML = html || '<div style="color:#64748B;">No configurable keys available.</div>';
            } else {
                container.innerHTML = `<div style="color:#DC2626;">Error: ${data.message || 'Could not load'}</div>`;
            }
        })
        .catch(err => {
            container.innerHTML = `<div style="color:#DC2626;">Error: ${err.message}</div>`;
        });
    };

    window.closeConfigModal = function() {
        const modal = document.getElementById('itgConfigModal');
        if (modal) modal.style.display = 'none';
    };

    window.saveIntegrationConfig = function(event) {
        if (event) event.preventDefault();
        const form = document.getElementById('itgConfigForm');
        if (!form) return;
        const formData = new FormData(form);
        const slug = formData.get('slug');
        const config = {};

        for (const [key, val] of formData.entries()) {
            if (key.startsWith('config[')) {
                const match = key.match(/config\[(.*?)\]/);
                if (match) {
                    config[match[1]] = val;
                }
            }
        }

        fetch('/api/integrations.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'save_config',
                slug: slug,
                config: config
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (typeof window.showToast === 'function') window.showToast('Credentials and configuration saved securely!', 'success');
                window.closeConfigModal();
            } else {
                var errNotice = 'Failed to save config: ' + (data.message || 'Unknown error');
                if (typeof window.showToast === 'function') window.showToast(errNotice, 'error');
                else console.warn(errNotice);
            }
        })
        .catch(err => {
            var netErr = 'Network error: ' + err.message;
            if (typeof window.showToast === 'function') window.showToast(netErr, 'error');
            else console.warn(netErr);
        });
    };
})();
