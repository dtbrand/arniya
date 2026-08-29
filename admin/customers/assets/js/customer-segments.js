/**
 * customer-segments.js - Live cohort engine
 * DT Brand's & Jai Hanuman Tex - Live Production Standard
 *
 * What this file used to do:
 *
 *   handleCreateSegmentSubmit()  built a segment card whose audience size was
 *                                Math.floor(Math.random() * 450) + 120, then
 *                                toasted 'Segment "X" created with live cohort
 *                                tracking!'. There is no segments table: the
 *                                card was gone on reload, and the number it
 *                                showed was never a count of anything.
 *   syncSegmentAudience()        toasted 'Calculating live database matches...'
 *                                and then, 800ms later, 'Audience synced! Live
 *                                records updated in real-time.' No request was
 *                                ever made.
 *   broadcastToSegment()         toasted that a WhatsApp broadcast to N
 *                                customers was being prepared. Nothing sends.
 *
 * All three are gone. This file now matches criteria against the real rows
 * segments.php serialised into window.dtSegmentRows, and the two remaining
 * actions - Export CSV and Copy Phone Numbers - produce exactly the cohort on
 * screen.
 */

(function () {
    'use strict';

    var PREVIEW_LIMIT = 25;

    var rows = Array.isArray(window.dtSegmentRows) ? window.dtSegmentRows : [];
    var lastMatches = rows.slice();

    function toast(msg) {
        if (typeof window.showToast === 'function') { window.showToast(msg); }
    }

    function esc(v) {
        return String(v == null ? '' : v).replace(/[&<>"']/g, function (ch) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch];
        });
    }

    function val(id) {
        var el = document.getElementById(id);
        return el ? String(el.value || '').trim() : '';
    }

    function setVal(id, v) {
        var el = document.getElementById(id);
        if (el) el.value = v;
    }

    function num(id) {
        var raw = val(id);
        if (raw === '') return null;
        var n = Number(raw);
        return isNaN(n) ? null : n;
    }

    function parseTs(raw) {
        if (!raw) return NaN;
        return Date.parse(String(raw).replace(' ', 'T'));
    }

    function fmtMoney(n) {
        return '₹' + Number(n || 0).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function fmtDate(raw) {
        var t = parseTs(raw);
        if (isNaN(t)) return '<span style="color:#A8A29E;">Never ordered</span>';
        return new Date(t).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    // ── Criteria ────────────────────────────────────────────────────────────
    function readCriteria() {
        return {
            type: val('dtSegType'),
            status: val('dtSegStatus'),
            state: val('dtSegState').toUpperCase(),
            tier: val('dtSegTier'),
            minSpend: num('dtSegMinSpend'),
            minOrders: num('dtSegMinOrders'),
            ordering: val('dtSegOrdering'),
            dormantDays: num('dtSegDormantDays'),
            extra: val('dtSegExtra')
        };
    }

    function matches(c, r) {
        if (c.type === 'trade') {
            if (r.type !== 'wholesale' && r.type !== 'reseller') return false;
        } else if (c.type && r.type !== c.type) {
            return false;
        }
        if (c.status && r.status !== c.status) return false;
        if (c.state && String(r.state).toUpperCase() !== c.state) return false;

        if (c.tier === '__none__') {
            if (String(r.tier).trim() !== '') return false;
        } else if (c.tier && String(r.tier).toLowerCase() !== c.tier) {
            return false;
        }

        if (c.minSpend !== null && Number(r.spend) < c.minSpend) return false;
        if (c.minOrders !== null && Number(r.orders) < c.minOrders) return false;
        if (c.ordering === 'has' && Number(r.orders) <= 0) return false;
        if (c.ordering === 'never' && Number(r.orders) !== 0) return false;

        if (c.dormantDays !== null && c.dormantDays > 0) {
            var t = parseTs(r.last);
            // A customer with no order at all has not ordered in any window, so
            // they belong in a dormancy cohort rather than being excluded.
            if (!isNaN(t) && t >= (Date.now() - c.dormantDays * 86400000)) return false;
        }

        if (c.extra === 'gstin' && String(r.gstin).trim() === '') return false;
        if (c.extra === 'balance' && Number(r.balance) <= 0) return false;
        if (c.extra === 'email' && String(r.email).trim() === '') return false;

        return true;
    }

    function describe(c) {
        var parts = [];
        if (c.type === 'trade') parts.push('wholesale or reseller');
        else if (c.type) parts.push('type = ' + c.type);
        if (c.status) parts.push('status = ' + c.status);
        if (c.state) parts.push('state = ' + c.state);
        if (c.tier === '__none__') parts.push('no tier set');
        else if (c.tier) parts.push('tier = ' + c.tier);
        if (c.minSpend !== null) parts.push('spend ≥ ₹' + c.minSpend.toLocaleString('en-IN'));
        if (c.minOrders !== null) parts.push('orders ≥ ' + c.minOrders);
        if (c.ordering === 'has') parts.push('has ordered');
        if (c.ordering === 'never') parts.push('never ordered');
        if (c.dormantDays !== null && c.dormantDays > 0) parts.push('no order in ' + c.dormantDays + ' days');
        if (c.extra === 'gstin') parts.push('GSTIN on file');
        if (c.extra === 'balance') parts.push('outstanding balance > 0');
        if (c.extra === 'email') parts.push('email on file');
        return parts;
    }
    // ── Render ──────────────────────────────────────────────────────────────
    function renderPreview(list) {
        var body = document.getElementById('dtSegPreviewBody');
        var note = document.getElementById('dtSegPreviewNote');
        if (!body) return;

        if (!rows.length) {
            body.innerHTML = '<tr><td colspan="7" style="padding:26px 16px; text-align:center; color:#78716C; font-size:0.82rem;">'
                + 'There are no customers in the database yet, so no cohort can have members.</td></tr>';
            if (note) note.textContent = '';
            return;
        }

        if (!list.length) {
            body.innerHTML = '<tr><td colspan="7" style="padding:26px 16px; text-align:center; color:#78716C; font-size:0.82rem;">'
                + 'No customer matches these criteria. Loosen one of them &mdash; nothing has been hidden.</td></tr>';
            if (note) note.textContent = '';
            return;
        }

        var shown = list.slice(0, PREVIEW_LIMIT);
        var html = '';
        shown.forEach(function (r) {
            var place = [r.city, r.state].filter(function (x) { return x && String(x).trim(); }).join(', ');
            html += '<tr style="border-bottom:1px solid #F1ECE1;">'
                + '<td style="padding:11px 16px;">'
                +   '<a href="/admin/customers/view.php?id=' + encodeURIComponent(r.id) + '" style="font-size:0.82rem; font-weight:800; color:#181512; text-decoration:none;">'
                +   esc(r.name || 'Unnamed customer') + '</a>'
                +   (r.email ? '<div style="font-size:0.7rem; color:#78716C;">' + esc(r.email) + '</div>' : '')
                + '</td>'
                + '<td style="padding:11px 16px; font-size:0.8rem; color:#181512;">' + (r.phone ? esc(r.phone) : '<span style="color:#A8A29E;">—</span>') + '</td>'
                + '<td style="padding:11px 16px; font-size:0.78rem; color:#181512;">' + esc(r.type)
                +   (String(r.tier).trim() ? '<div style="font-size:0.7rem; color:#8A681F; font-weight:700;">' + esc(r.tier) + '</div>' : '')
                + '</td>'
                + '<td style="padding:11px 16px; font-size:0.78rem; color:#181512;">' + (place ? esc(place) : '<span style="color:#A8A29E;">—</span>') + '</td>'
                + '<td style="padding:11px 16px; font-size:0.8rem; font-weight:700; text-align:right; color:#181512;">' + Number(r.orders || 0) + '</td>'
                + '<td style="padding:11px 16px; font-size:0.8rem; font-weight:800; text-align:right; color:#181512;">' + fmtMoney(r.spend) + '</td>'
                + '<td style="padding:11px 16px; font-size:0.78rem; color:#181512;">' + fmtDate(r.last) + '</td>'
                + '</tr>';
        });
        body.innerHTML = html;

        if (note) {
            note.textContent = list.length > PREVIEW_LIMIT
                ? 'Previewing the first ' + PREVIEW_LIMIT + ' of ' + list.length + ' matches. Export CSV writes all ' + list.length + '.'
                : 'All ' + list.length + ' match' + (list.length === 1 ? '' : 'es') + ' shown.';
        }
    }

    window.runSegmentMatch = function () {
        var c = readCriteria();
        lastMatches = rows.filter(function (r) { return matches(c, r); });

        var countEl = document.getElementById('dtSegMatchCount');
        if (countEl) countEl.textContent = lastMatches.length.toLocaleString('en-IN');

        var pctEl = document.getElementById('dtSegMatchPct');
        if (pctEl) {
            var pct = rows.length > 0 ? ((lastMatches.length / rows.length) * 100).toFixed(1) + '%' : '0%';
            pctEl.textContent = 'of ' + rows.length.toLocaleString('en-IN') + ' — ' + pct + ' of the base';
        }

        var sum = document.getElementById('dtSegCriteriaSummary');
        if (sum) {
            var parts = describe(c);
            sum.textContent = parts.length
                ? 'Criteria: ' + parts.join('  ·  ')
                : 'Showing every customer — set a criterion above to narrow the cohort.';
        }

        renderPreview(lastMatches);
        return lastMatches.length;
    };

    window.resetSegmentCriteria = function () {
        ['dtSegType', 'dtSegStatus', 'dtSegState', 'dtSegTier', 'dtSegOrdering', 'dtSegExtra',
         'dtSegMinSpend', 'dtSegMinOrders', 'dtSegDormantDays'].forEach(function (id) { setVal(id, ''); });
        window.runSegmentMatch();
    };

    // Presets fill the same controls an admin would set by hand, so the count
    // they advertise and the count they produce are the same number.
    var PRESETS = {
        vip:     { dtSegMinSpend: '25000' },
        repeat:  { dtSegMinOrders: '3' },
        never:   { dtSegOrdering: 'never' },
        dormant: { dtSegDormantDays: '60' },
        gujarat: { dtSegState: 'GJ' },
        trade:   { dtSegType: 'trade' }
    };

    window.applySegmentPreset = function (key) {
        var preset = PRESETS[key];
        if (!preset) return;
        window.resetSegmentCriteria();

        // The state list is built from the states customers actually have, so
        // "GJ" may not be an option. Fall back to GUJARAT before giving up,
        // rather than silently leaving the select on "Any state".
        if (key === 'gujarat') {
            var sel = document.getElementById('dtSegState');
            var wanted = ['GJ', 'GUJARAT'];
            var found = '';
            if (sel) {
                for (var i = 0; i < sel.options.length; i++) {
                    if (wanted.indexOf(String(sel.options[i].value).toUpperCase()) !== -1) {
                        found = sel.options[i].value; break;
                    }
                }
            }
            if (!found) {
                toast('No customer has Gujarat recorded as their state.');
                return;
            }
            setVal('dtSegState', found);
        } else {
            Object.keys(preset).forEach(function (id) { setVal(id, preset[id]); });
        }

        var n = window.runSegmentMatch();
        toast(n === 0 ? 'That preset matches no customer right now.'
                      : n + ' customer' + (n === 1 ? '' : 's') + ' match this preset.');
    };
    // ── Actions ─────────────────────────────────────────────────────────────
    // A spreadsheet needs the raw number, not "48,500", or the column will not
    // add up. Quotes are doubled so a customer whose name contains one cannot
    // shift every following column.
    function csvCell(v) {
        var s = String(v == null ? '' : v);
        return /[",\n\r]/.test(s) ? '"' + s.replace(/"/g, '""') + '"' : s;
    }

    window.exportSegmentCsv = function () {
        if (!lastMatches.length) {
            // Writing a headers-only file and calling it an export would read as
            // "these customers were exported" when there were none.
            toast(rows.length === 0
                ? '⚠ There are no customers in the database yet, so nothing was exported.'
                : '⚠ No customer matches these criteria — nothing was exported.');
            return;
        }

        var header = ['Customer ID', 'Name', 'Phone', 'Email', 'Type', 'Tier', 'Status',
                      'City', 'State', 'Orders', 'Lifetime Spend (INR)', 'Outstanding (INR)',
                      'GSTIN', 'Last Order'];
        var lines = [header.map(csvCell).join(',')];
        lastMatches.forEach(function (r) {
            lines.push([r.id, r.name, r.phone, r.email, r.type, r.tier, r.status, r.city, r.state,
                        r.orders, r.spend, r.balance, r.gstin, r.last].map(csvCell).join(','));
        });

        // BOM so Excel opens Indian names and the rupee sign correctly.
        var blob = new Blob(['﻿' + lines.join('\r\n')], { type: 'text/csv;charset=utf-8;' });
        var url = URL.createObjectURL(blob);
        var link = document.createElement('a');
        link.href = url;
        link.download = 'dt_cohort_' + new Date().toISOString().slice(0, 10).replace(/-/g, '_') + '.csv';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);

        toast('✓ CSV saved — ' + lastMatches.length + ' customer' + (lastMatches.length === 1 ? '' : 's') + '.');
    };

    window.copySegmentPhones = function () {
        var phones = lastMatches
            .map(function (r) { return String(r.phone || '').trim(); })
            .filter(function (p) { return p !== ''; });

        if (!phones.length) {
            toast(lastMatches.length
                ? '⚠ None of the ' + lastMatches.length + ' matching customers has a phone number recorded.'
                : '⚠ No customer matches these criteria.');
            return;
        }

        var text = phones.join('\n');
        var done = function () {
            toast('✓ ' + phones.length + ' phone number' + (phones.length === 1 ? '' : 's') + ' copied — paste into WhatsApp Business.');
        };

        // Report a copy only once the clipboard actually accepted it: the API
        // rejects on an insecure origin or without focus, and claiming success
        // there would leave the admin pasting whatever was there before.
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(done).catch(function () {
                fallbackCopy(text, phones.length, done);
            });
        } else {
            fallbackCopy(text, phones.length, done);
        }
    };

    function fallbackCopy(text, count, done) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.setAttribute('readonly', 'readonly');
        ta.style.cssText = 'position:fixed; left:-9999px; top:0;';
        document.body.appendChild(ta);
        ta.select();
        var ok = false;
        try { ok = document.execCommand('copy'); } catch (e) { ok = false; }
        document.body.removeChild(ta);
        if (ok) { done(); return; }
        toast('⚠ The browser blocked the clipboard. Use Export CSV instead — the phone column is in the file.');
    }

    document.addEventListener('DOMContentLoaded', function () {
        window.runSegmentMatch();
    });


})();
