/**
 * customer-segments.js — Segment Rules Engine & Cohort Simulator
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    // ── Open / Close Create Segment Modal ──
    window.openCreateSegmentModal = function () {
        const modal = document.getElementById('dtCreateSegmentModal');
        if (modal) {
            modal.style.display = 'flex';
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100vw';
            modal.style.height = '100vh';
            modal.style.background = 'rgba(0, 0, 0, 0.65)';
            modal.style.backdropFilter = 'blur(6px)';
            modal.style.zIndex = '9999';
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';
            
            const nameInput = document.getElementById('dtSegNameInput');
            if (nameInput) {
                setTimeout(() => nameInput.focus(), 100);
            }
        }
    };

    window.closeCreateSegmentModal = function () {
        const modal = document.getElementById('dtCreateSegmentModal');
        if (modal) {
            modal.style.display = 'none';
        }
    };

    // ── Handle Dynamic Create Segment Submit ──
    window.handleCreateSegmentSubmit = function (event) {
        event.preventDefault();
        const name = (document.getElementById('dtSegNameInput')?.value || '').trim();
        const geo = document.getElementById('dtSegGeoSelect')?.value || 'ALL';
        const tier = document.getElementById('dtSegTierSelect')?.value || 'ALL';
        const minSpend = document.getElementById('dtSegMinSpend')?.value || '';
        const minOrders = document.getElementById('dtSegMinOrders')?.value || '';

        if (!name) {
            window.showToast('⚠️ Please provide a Segment Name');
            return;
        }

        const container = document.getElementById('dtSegmentsGridContainer');
        if (container) {
            const count = Math.floor(Math.random() * 450) + 120;
            const newCard = document.createElement('div');
            newCard.className = 'dt-segment-card';
            newCard.setAttribute('data-segment-title', name);
            newCard.style.animation = 'dtModalPop 0.3s cubic-bezier(0.16, 1, 0.3, 1)';
            newCard.innerHTML = `
                <div class="dt-segment-head">
                    <div class="dt-segment-title-wrap">
                        <div class="dt-segment-icon-box" style="background:#FAF5E8; border-color:#D4AF37; color:#8A681F;">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                        <div>
                            <h4 class="dt-segment-name">${name}</h4>
                            <p class="dt-segment-sub">Custom Audience Cohort • Dynamic Match</p>
                        </div>
                    </div>
                    <span class="dt-status-pill active" style="font-size:0.65rem;">● Active</span>
                </div>

                <div class="dt-segment-conditions">
                    <div class="dt-segment-cond-item">
                        <span>Criteria:</span>
                        ${minSpend ? `<span class="dt-segment-cond-badge">Spend ≥ ₹${Number(minSpend).toLocaleString('en-IN')}</span>` : ''}
                        ${minOrders ? `<span class="dt-segment-cond-badge">Orders ≥ ${minOrders}</span>` : ''}
                        <span class="dt-segment-cond-badge">Market = ${geo}</span>
                        ${tier !== 'ALL' ? `<span class="dt-segment-cond-badge">Tier = ${tier}</span>` : ''}
                    </div>
                </div>

                <div class="dt-segment-stats">
                    <div>
                        <div class="dt-segment-count">${count}</div>
                        <small style="color:#78716C; font-size:0.68rem; font-weight:700;">Matching Shoppers</small>
                    </div>
                    <div style="display:flex; align-items:center; gap:6px;">
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="syncSegmentAudience('${name}')">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                            <span>Sync</span>
                        </button>
                        <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px; padding:4px 8px; font-size:0.72rem;" onclick="broadcastToSegment('${name}', ${count})">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>WhatsApp</span>
                        </button>
                    </div>
                </div>
            `;
            container.prepend(newCard);
        }

        window.closeCreateSegmentModal();
        window.showToast(`✓ Segment "${name}" created with live cohort tracking!`);
        document.getElementById('dtCreateSegmentForm')?.reset();
    };

    // ── Live Segment Search Filtering ──
    window.filterSegmentCards = function (query) {
        const q = (query || '').toLowerCase().trim();
        const cards = document.querySelectorAll('.dt-segment-card');
        cards.forEach(card => {
            const title = (card.getAttribute('data-segment-title') || card.innerText || '').toLowerCase();
            if (!q || title.includes(q)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    };

    // ── Sync Audience Action ──
    window.syncSegmentAudience = function (segName) {
        window.showToast(`🔄 Calculating live database matches for ${segName || 'cohort'}...`);
        setTimeout(() => {
            window.showToast(`✓ Audience synced! Live records updated in real-time.`);
        }, 800);
    };

    // ── WhatsApp Broadcast Action ──
    window.broadcastToSegment = function (segName, count) {
        window.showToast(`💬 Preparing 1-Click WhatsApp Broadcast to ${count || 'all'} customers in "${segName}"...`);
    };

})();

