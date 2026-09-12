// notifications.js — DT Brand's & Jai Hanuman Tex Multi-Channel Notification Engine Controller
// Section 31 (Notification Admin)
(function() {
    'use strict';

    window.DTNotifications = {
        apiBase: '/api/notifications.php',

        showToast: function(message, type) {
            if (typeof window.showToast === 'function') {
                window.showToast(message, type);
            } else {
                console.warn(message);
            }
        },

        // Test Dispatch Notification
        sendTest: function(channel, recipient, templateKey, variables, options, btnElement) {
            const self = this;
            if (btnElement) {
                btnElement.disabled = true;
                btnElement.dataset.origText = btnElement.innerHTML;
                btnElement.innerHTML = '<span>Sending...</span>';
            }

            const payload = {
                action: 'send_test',
                channel: channel,
                recipient: recipient,
                template_key: templateKey,
                variables: variables || {},
                subject: options?.subject || null,
                recipient_name: options?.recipient_name || null,
                order_id: options?.order_id || null,
                provider: options?.provider || null,
                simulate_fail: options?.simulate_fail || false
            };

            return fetch(this.apiBase, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    self.showToast(`[${channel.toUpperCase()}] Notification dispatched successfully!`);
                } else {
                    self.showToast(`Dispatch failed: ${data.error || 'Gateway error'}`, 'error');
                }
                return data;
            })
            .catch(err => {
                self.showToast(`Dispatch error: ${err.message}`, 'error');
                return { success: false, error: err.message };
            })
            .finally(() => {
                if (btnElement) {
                    btnElement.disabled = false;
                    btnElement.innerHTML = btnElement.dataset.origText;
                }
            });
        },

        // Retry single failed message
        retryMessage: function(logId, btnElement) {
            const self = this;
            if (btnElement) {
                btnElement.disabled = true;
                btnElement.innerHTML = '<span>Retrying...</span>';
            }

            return fetch(this.apiBase, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'retry', log_id: logId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    self.showToast(data.message || 'Message re-delivered successfully via gateway!');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    self.showToast(`Retry failed: ${data.message || 'Unknown error'}`, 'error');
                }
                return data;
            })
            .catch(err => {
                self.showToast(`Retry error: ${err.message}`, 'error');
            })
            .finally(() => {
                if (btnElement) {
                    btnElement.disabled = false;
                    btnElement.innerHTML = '<span>Retry</span>';
                }
            });
        },

        // Batch retry all failed messages
        batchRetry: function(logIds, btnElement) {
            const self = this;
            if (!logIds || logIds.length === 0) {
                self.showToast('No failed messages selected to retry.');
                return;
            }

            if (btnElement) {
                btnElement.disabled = true;
                btnElement.innerHTML = '<span>Recovering DLQ...</span>';
            }

            return fetch(this.apiBase, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'batch_retry', log_ids: logIds })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    self.showToast(data.message || `${data.recovered_count} messages redelivered!`);
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    self.showToast(`Batch recovery failed: ${data.message}`, 'error');
                }
            })
            .catch(err => {
                self.showToast(`Recovery error: ${err.message}`, 'error');
            })
            .finally(() => {
                if (btnElement) {
                    btnElement.disabled = false;
                    btnElement.innerHTML = '<span>Batch Retry All</span>';
                }
            });
        },

        // Test Provider Ping & Latency
        testProvider: function(providerKey, btnElement) {
            const self = this;
            if (btnElement) {
                btnElement.disabled = true;
                btnElement.innerHTML = '<span>Pinging...</span>';
            }

            return fetch(this.apiBase, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'test_provider', provider_key: providerKey })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    self.showToast(`Handshake verified! Latency: ${data.latency_ms}ms`);
                    const latEl = document.getElementById(`latency-${providerKey}`);
                    if (latEl) latEl.textContent = `${data.latency_ms}ms`;
                } else {
                    self.showToast(`Ping failed: ${data.error || 'Unreachable'}`, 'error');
                }
            })
            .catch(err => {
                self.showToast(`Ping error: ${err.message}`, 'error');
            })
            .finally(() => {
                if (btnElement) {
                    btnElement.disabled = false;
                    btnElement.innerHTML = '<span>Ping Gateway</span>';
                }
            });
        },

        // Copy variable into focused textarea/input
        insertVariable: function(targetElementId, varTag) {
            const el = document.getElementById(targetElementId);
            if (!el) return;

            const startPos = el.selectionStart || el.value.length;
            const endPos = el.selectionEnd || el.value.length;
            const val = el.value;

            el.value = val.substring(0, startPos) + `{{${varTag}}}` + val.substring(endPos, val.length);
            el.focus();
            el.selectionStart = el.selectionEnd = startPos + varTag.length + 4;
            el.dispatchEvent(new Event('input'));
        }
    };
})();
