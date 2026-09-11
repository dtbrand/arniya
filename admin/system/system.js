/**
 * system.js — DT Brand's System Admin Suite JavaScript Controller
 * Section 36 — Enterprise System Governance
 */
'use strict';

/* ══════════════════════════════════════════
   TAB NAVIGATION
══════════════════════════════════════════ */
function sysTab(id) {
    document.querySelectorAll('.sys-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.sys-tab-pane').forEach(p => p.classList.remove('active'));
    const btn  = document.querySelector(`.sys-tab-btn[data-tab="${id}"]`);
    const pane = document.getElementById('sys-pane-' + id);
    if (btn)  btn.classList.add('active');
    if (pane) pane.classList.add('active');
    // Persist in sessionStorage so refresh keeps active tab
    try { sessionStorage.setItem('sysActiveTab', id); } catch (_) {}
}

/* ══════════════════════════════════════════
   DANGER OPERATION — show re-auth modal
══════════════════════════════════════════ */
function sysDangerAction(action, label) {
    if (!confirm('⚠️  Danger: ' + label + '\n\nThis operation is irreversible. Continue to password verification?')) return;
    const modal = document.getElementById('sysDangerModal');
    if (!modal) { alert('Security modal not found.'); return; }
    document.getElementById('sysDangerAction').value = action;
    document.getElementById('sysDangerLabel').textContent = label;
    document.getElementById('sysDangerPwd').value = '';
    modal.style.display = 'flex';
    setTimeout(() => document.getElementById('sysDangerPwd').focus(), 80);
}
function sysCloseDangerModal() {
    const modal = document.getElementById('sysDangerModal');
    if (modal) modal.style.display = 'none';
}

/* ══════════════════════════════════════════
   TOAST NOTIFICATIONS
══════════════════════════════════════════ */
function sysToast(msg, type = 'success') {
    let wrap = document.getElementById('sysToastWrap');
    if (!wrap) {
        wrap = document.createElement('div');
        wrap.id = 'sysToastWrap';
        wrap.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:99999;display:flex;flex-direction:column;gap:8px;max-width:360px;';
        document.body.appendChild(wrap);
    }
    const colors = {
        success: { bg:'#DCFCE7', bd:'#86EFAC', txt:'#15803D' },
        error:   { bg:'#FEF2F2', bd:'#FECACA', txt:'#DC2626' },
        warn:    { bg:'#FEF3C7', bd:'#FDE68A', txt:'#B45309' },
        info:    { bg:'#EFF6FF', bd:'#BFDBFE', txt:'#1D4ED8' },
    };
    const c = colors[type] || colors.info;
    const t = document.createElement('div');
    t.style.cssText = `background:${c.bg};border:1px solid ${c.bd};color:${c.txt};padding:12px 16px;border-radius:10px;font-size:13px;font-weight:700;box-shadow:0 4px 16px rgba(0,0,0,0.1);display:flex;align-items:center;gap:8px;animation:sysSlideIn .25s ease;font-family:'Inter',sans-serif;`;
    t.innerHTML = `<span style="flex:1;">${msg}</span><button onclick="this.parentNode.remove()" style="background:none;border:none;cursor:pointer;color:inherit;font-size:16px;line-height:1;padding:0 2px;">&times;</button>`;
    wrap.appendChild(t);
    setTimeout(() => { t.style.opacity='0'; t.style.transition='opacity .3s'; setTimeout(() => t.remove(), 350); }, 4200);
}
const style = document.createElement('style');
style.textContent = '@keyframes sysSlideIn { from { transform:translateX(30px); opacity:0; } to { transform:translateX(0); opacity:1; } }';
document.head.appendChild(style);

/* ══════════════════════════════════════════
   AJAX HELPER — POST JSON
══════════════════════════════════════════ */
async function sysPost(url, payload) {
    const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify(payload),
    });
    if (!res.ok) throw new Error('HTTP ' + res.status);
    return res.json();
}

/* ══════════════════════════════════════════
   SETTINGS — SAVE SECTION
══════════════════════════════════════════ */
async function sysSaveSettings(section) {
    const form = document.getElementById('sysForm-' + section);
    if (!form) return;
    const btn = form.querySelector('[data-save-btn]');
    if (btn) { btn.disabled = true; btn.textContent = 'Saving…'; }

    const payload = { section };
    new FormData(form).forEach((v, k) => { payload[k] = v; });
    // Collect unchecked checkboxes as '0'
    form.querySelectorAll('input[type="checkbox"]').forEach(cb => {
        if (!cb.checked) payload[cb.name] = '0';
    });

    try {
        const data = await sysPost('/api/system.php', payload);
        sysToast(data.message || 'Settings saved.', data.success ? 'success' : 'error');
    } catch (e) {
        sysToast('Save failed: ' + e.message, 'error');
    } finally {
        if (btn) { btn.disabled = false; btn.textContent = 'Save Changes'; }
    }
}

/* ══════════════════════════════════════════
   FEATURE FLAG — TOGGLE
══════════════════════════════════════════ */
async function sysFlagToggle(key, enabled) {
    try {
        const data = await sysPost('/api/system.php', { action: 'feature_flag_toggle', key, enabled: enabled ? 1 : 0 });
        sysToast(data.message || 'Flag updated.', data.success ? 'success' : 'error');
        if (!data.success) {
            // Revert toggle
            const cb = document.getElementById('flag-' + key);
            if (cb) cb.checked = !enabled;
        }
    } catch (e) {
        sysToast('Toggle failed: ' + e.message, 'error');
    }
}

/* ══════════════════════════════════════════
   CRON — MANUAL RUN
══════════════════════════════════════════ */
async function sysCronRun(jobName) {
    if (!confirm('Manually trigger cron job: ' + jobName + '?')) return;
    try {
        const data = await sysPost('/api/system.php', { action: 'cron_run', job: jobName });
        sysToast(data.message || 'Job queued.', data.success ? 'success' : 'error');
    } catch (e) {
        sysToast('Cron trigger failed: ' + e.message, 'error');
    }
}

/* ══════════════════════════════════════════
   CACHE PURGE — with loading state
══════════════════════════════════════════ */
async function sysPurgeCache(type) {
    const btn = event.currentTarget;
    btn.disabled = true; btn.textContent = 'Purging…';
    try {
        const data = await sysPost('/api/system.php', { action: 'cache_purge', type });
        sysToast(data.message || 'Cache purged.', data.success ? 'success' : 'error');
    } catch (e) {
        sysToast('Purge failed: ' + e.message, 'error');
    } finally {
        btn.disabled = false; btn.textContent = 'Purge';
    }
}

/* ══════════════════════════════════════════
   LOG VIEWER — live tail
══════════════════════════════════════════ */
let sysLogInterval = null;
function sysStartLogTail(level) {
    const pre = document.getElementById('sysLogOutput');
    if (!pre) return;
    if (sysLogInterval) clearInterval(sysLogInterval);
    const load = () => {
        fetch('/api/system.php?action=logs_tail&level=' + encodeURIComponent(level) + '&limit=100')
            .then(r => r.json())
            .then(d => {
                if (d.success && Array.isArray(d.logs)) {
                    pre.innerHTML = d.logs.map(l => {
                        const cls = l.level === 'error' || l.level === 'critical' ? 'log-error'
                                  : l.level === 'warning' ? 'log-warn'
                                  : l.level === 'info' ? 'log-info'
                                  : l.level === 'success' ? 'log-success' : '';
                        const line = `[${l.created_at}] [${l.level.toUpperCase().padEnd(8)}] [${l.channel}] ${l.message}`;
                        return cls ? `<span class="${cls}">${escHtml(line)}</span>` : escHtml(line);
                    }).join('\n') || '(No logs)';
                    pre.scrollTop = pre.scrollHeight;
                }
            }).catch(() => {});
    };
    load();
    sysLogInterval = setInterval(load, 5000);
}
function sysStopLogTail() { if (sysLogInterval) { clearInterval(sysLogInterval); sysLogInterval = null; } }
function escHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/* ══════════════════════════════════════════
   MAINTENANCE MODE
══════════════════════════════════════════ */
async function sysToggleMaintenance(enable) {
    const msg = enable
        ? 'Enable MAINTENANCE MODE? Public-facing site will show a maintenance page.'
        : 'Disable maintenance mode and restore public access?';
    if (!confirm(msg)) return;
    try {
        const data = await sysPost('/api/system.php', { action: 'maintenance_toggle', enable: enable ? 1 : 0 });
        sysToast(data.message || 'Maintenance mode updated.', data.success ? 'success' : 'error');
        if (data.success) setTimeout(() => location.reload(), 1200);
    } catch (e) {
        sysToast('Operation failed: ' + e.message, 'error');
    }
}

/* ══════════════════════════════════════════
   BACKUP — TRIGGER
══════════════════════════════════════════ */
async function sysRunBackup() {
    const btn = event.currentTarget;
    btn.disabled = true; btn.textContent = 'Running…';
    try {
        const data = await sysPost('/api/system.php', { action: 'backup_run' });
        sysToast(data.message || 'Backup initiated.', data.success ? 'success' : 'error');
    } catch (e) {
        sysToast('Backup failed: ' + e.message, 'error');
    } finally {
        btn.disabled = false; btn.textContent = 'Run Backup Now';
    }
}

/* ══════════════════════════════════════════
   HEALTH CHECK — POLL
══════════════════════════════════════════ */
async function sysRefreshHealth() {
    const grid = document.getElementById('sysHealthGrid');
    if (!grid) return;
    try {
        const data = await fetch('/api/system.php?action=health').then(r => r.json());
        if (data.success && data.pillars) {
            data.pillars.forEach(p => {
                const card = document.querySelector(`.sys-health-card[data-pillar="${p.name}"]`);
                if (!card) return;
                card.className = `sys-health-card ${p.status}`;
                const badge = card.querySelector('.sys-health-badge');
                if (badge) { badge.className = `sys-health-badge ${p.status}`; badge.textContent = p.status.toUpperCase(); }
                const val = card.querySelector('.sys-health-value');
                if (val && p.value != null) val.textContent = p.value;
                const meta = card.querySelector('.sys-health-meta');
                if (meta && p.latency) meta.textContent = 'Latency: ' + p.latency + ' ms';
            });
        }
    } catch (_) {}
}

/* ══════════════════════════════════════════
   INIT
══════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {
    // Restore last active tab
    try {
        const lastTab = sessionStorage.getItem('sysActiveTab');
        if (lastTab && document.querySelector(`.sys-tab-btn[data-tab="${lastTab}"]`)) {
            sysTab(lastTab);
        } else {
            const first = document.querySelector('.sys-tab-btn');
            if (first) sysTab(first.dataset.tab);
        }
    } catch (_) {
        const first = document.querySelector('.sys-tab-btn');
        if (first) sysTab(first.dataset.tab);
    }

    // Close danger modal on backdrop click
    const modal = document.getElementById('sysDangerModal');
    if (modal) {
        modal.addEventListener('click', e => { if (e.target === modal) sysCloseDangerModal(); });
    }

    // Auto refresh health every 30 s if health grid is present
    if (document.getElementById('sysHealthGrid')) {
        setInterval(sysRefreshHealth, 30000);
    }

    // Animate storage bars
    document.querySelectorAll('.sys-storage-bar[data-pct]').forEach(bar => {
        const pct = parseFloat(bar.dataset.pct);
        bar.style.width = '0%';
        setTimeout(() => { bar.style.width = pct + '%'; }, 100);
    });
});
