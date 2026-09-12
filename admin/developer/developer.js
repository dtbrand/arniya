/**
 * admin/developer/developer.js — Interactive Client Engine for Developer & API Admin Suite
 * DT Brand's & Jai Hanuman Tex
 */

(function () {
    'use strict';

    // Toast Notification System
    function devToast(message, type = 'info') {
        let container = document.getElementById('devToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'devToastContainer';
            container.className = 'dev-toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'dev-toast';
        if (type === 'error') {
            toast.style.borderLeftColor = '#DC2626';
        } else if (type === 'success') {
            toast.style.borderLeftColor = '#15803D';
        }

        toast.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <span>${message}</span>
        `;

        container.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }

    // AJAX Helpers
    async function devGet(action, params = {}) {
        const query = new URLSearchParams({ action, ...params }).toString();
        const res = await fetch(`/api/developer.php?${query}`, {
            headers: { 'Accept': 'application/json' }
        });
        return await res.json();
    }

    async function devPost(action, data = {}) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const formData = new FormData();
        formData.append('action', action);
        formData.append('csrf_token', csrfToken);

        for (const [k, v] of Object.entries(data)) {
            if (Array.isArray(v)) {
                v.forEach(item => formData.append(`${k}[]`, item));
            } else {
                formData.append(k, v);
            }
        }

        const res = await fetch('/api/developer.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-Token': csrfToken,
                'Accept': 'application/json'
            }
        });
        return await res.json();
    }

    // Ping Endpoint live
    async function pingEndpoint(endpoint, method = 'GET', targetId = null) {
        const badge = targetId ? document.getElementById(targetId) : null;
        if (badge) {
            badge.innerHTML = '<span class="dev-status dev-status-warning">Pinging...</span>';
        }

        try {
            const res = await devPost('api_ping', { endpoint, method });
            if (res.status === 'success' && res.ping) {
                const p = res.ping;
                const isFast = p.latency_ms < 120;
                const statusClass = p.status_code >= 200 && p.status_code < 400 ? 'dev-status-success' : 'dev-status-danger';
                if (badge) {
                    badge.innerHTML = `
                        <span class="dev-status ${statusClass}">${p.status_code} OK</span>
                        <span style="font-weight:700; font-size:0.8rem; margin-left:6px; color:${isFast ? '#15803D' : '#D97706'};">
                            ${p.latency_ms}ms
                        </span>
                    `;
                }
                devToast(`${endpoint} responded in ${p.latency_ms}ms (${p.status_code})`, 'success');
            } else {
                if (badge) badge.innerHTML = '<span class="dev-status dev-status-danger">Error</span>';
                devToast('Ping failed: ' + (res.message || 'Unknown'), 'error');
            }
        } catch (err) {
            if (badge) badge.innerHTML = '<span class="dev-status dev-status-danger">Offline</span>';
            devToast('Ping request network error', 'error');
        }
    }

    // Copy cURL snippet
    async function copyCurl(endpointKey) {
        try {
            const res = await devGet('curl_snippet', { endpoint: endpointKey });
            if (res.status === 'success' && res.curl) {
                await navigator.clipboard.writeText(res.curl);
                devToast('cURL command copied to clipboard!', 'success');
            } else {
                devToast('Could not generate cURL snippet', 'error');
            }
        } catch (err) {
            devToast('Failed to copy to clipboard', 'error');
        }
    }

    // Modal Inspector
    function showPayloadModal(title, jsonPayload) {
        let modal = document.getElementById('devPayloadModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'devPayloadModal';
            modal.className = 'dev-modal-overlay';
            modal.innerHTML = `
                <div class="dev-modal">
                    <div class="dev-modal-header">
                        <h3 id="devModalTitle">Payload Inspector</h3>
                        <button class="dev-modal-close" onclick="document.getElementById('devPayloadModal').classList.remove('active')">&times;</button>
                    </div>
                    <div class="dev-terminal">
                        <pre id="devModalPre"></pre>
                    </div>
                    <div style="margin-top:16px; display:flex; justify-content:flex-end;">
                        <button class="dt-btn-pale" onclick="document.getElementById('devPayloadModal').classList.remove('active')">Close</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        document.getElementById('devModalTitle').textContent = title;
        let formatted = jsonPayload;
        try {
            const parsed = typeof jsonPayload === 'string' ? JSON.parse(jsonPayload) : jsonPayload;
            formatted = JSON.stringify(parsed, null, 2);
        } catch (e) {
            formatted = String(jsonPayload);
        }

        document.getElementById('devModalPre').textContent = formatted;
        modal.classList.add('active');
    }

    // Retry Webhook
    async function retryWebhook(eventId, btnElem) {
        if (btnElem) {
            btnElem.disabled = true;
            btnElem.textContent = 'Retrying...';
        }

        try {
            const res = await devPost('webhook_retry', { event_id: eventId });
            if (res.status === 'success') {
                devToast(`Webhook ${eventId} redelivered successfully!`, 'success');
                const row = document.getElementById(`wh-row-${eventId}`);
                if (row) {
                    const statusCell = row.querySelector('.wh-status-cell');
                    if (statusCell) {
                        statusCell.innerHTML = '<span class="dev-status dev-status-success">delivered</span>';
                    }
                }
                if (btnElem) btnElem.textContent = 'Retried';
            } else {
                devToast(res.message || 'Retry failed', 'error');
                if (btnElem) {
                    btnElem.disabled = false;
                    btnElem.textContent = 'Retry';
                }
            }
        } catch (e) {
            devToast('Network error retrying webhook', 'error');
            if (btnElem) {
                btnElem.disabled = false;
                btnElem.textContent = 'Retry';
            }
        }
    }

    // Run Queue Job
    async function runQueueJob(jobId, btnElem) {
        if (btnElem) {
            btnElem.disabled = true;
            btnElem.textContent = 'Processing...';
        }

        try {
            const res = await devPost('queue_run', { job_id: jobId });
            if (res.status === 'success') {
                devToast(`Job ${jobId} executed successfully!`, 'success');
                const row = document.getElementById(`job-row-${jobId}`);
                if (row) {
                    const statusCell = row.querySelector('.job-status-cell');
                    if (statusCell) {
                        statusCell.innerHTML = '<span class="dev-status dev-status-success">completed</span>';
                    }
                }
                if (btnElem) btnElem.textContent = 'Done';
            } else {
                devToast(res.message || 'Job run failed', 'error');
                if (btnElem) {
                    btnElem.disabled = false;
                    btnElem.textContent = 'Run Now';
                }
            }
        } catch (e) {
            devToast('Network error running job', 'error');
            if (btnElem) {
                btnElem.disabled = false;
                btnElem.textContent = 'Run Now';
            }
        }
    }

    // Run All Pending Queue Jobs
    async function runAllPendingJobs(btnElem) {
        if (btnElem) {
            btnElem.disabled = true;
            btnElem.textContent = 'Running Queue...';
        }

        try {
            const res = await devPost('queue_run', {});
            if (res.status === 'success') {
                devToast(res.message, 'success');
                setTimeout(() => window.location.reload(), 800);
            } else {
                devToast(res.message || 'Execution error', 'error');
                if (btnElem) {
                    btnElem.disabled = false;
                    btnElem.textContent = 'Run Pending Jobs';
                }
            }
        } catch (e) {
            devToast('Network error processing queue', 'error');
            if (btnElem) {
                btnElem.disabled = false;
                btnElem.textContent = 'Run Pending Jobs';
            }
        }
    }

    // Client-side search filter
    function setupFilter(inputId, tableId) {
        const input = document.getElementById(inputId);
        const table = document.getElementById(tableId);
        if (!input || !table) return;

        input.addEventListener('input', function () {
            const term = this.value.toLowerCase().trim();
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(r => {
                const text = r.textContent.toLowerCase();
                r.style.display = text.includes(term) ? '' : 'none';
            });
        });
    }

    // Expose API globally
    window.DevStudio = {
        toast: devToast,
        get: devGet,
        post: devPost,
        pingEndpoint,
        copyCurl,
        showPayloadModal,
        retryWebhook,
        runQueueJob,
        runAllPendingJobs,
        setupFilter
    };
})();
