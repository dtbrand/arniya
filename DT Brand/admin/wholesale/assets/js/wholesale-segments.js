/**
 * wholesale-segments.js — DT Brand's & Jai Hanuman Tex
 * Wholesale Performance Cohorts, Accounts Inspector & Segmented WhatsApp Broadcast Engine
 */

(function () {
    'use strict';

    const cohortAccountsData = {
        'SEG-01': {
            title: 'Mega Volume Wholesalers (GMV > ₹20L)',
            accounts: [
                { id: 'WHL-8012', name: 'Shree Balaji Silk Mills Pvt Ltd', city: 'Surat', gmv: '₹28,50,000', tier: 'Platinum VIP' },
                { id: 'WHL-8015', name: 'Kanchipuram Silk Stockists', city: 'Chennai', gmv: '₹24,80,000', tier: 'Platinum VIP' },
                { id: 'WHL-8018', name: 'Varanasi Brocade Guild', city: 'Varanasi', gmv: '₹21,20,000', tier: 'Platinum VIP' }
            ],
            msgTemplate: "👑 *DT BRAND'S EXCLUSIVE WHOLESALE REBATE NOTICE*\n\nNamaste Partner,\nAs a privileged *Mega Volume Partner*, you are eligible for an additional *+6.5% Volume Rebate* on all direct factory container lots booked this week."
        },
        'SEG-02': {
            title: 'High-Frequency Regional Stockists',
            accounts: [
                { id: 'WHL-8013', name: 'Surat Textile Distribution Hub', city: 'Surat', gmv: '₹14,20,000', tier: 'Gold Distributor' },
                { id: 'WHL-8016', name: 'Ahmedabad Cotton & Silk Syndicate', city: 'Ahmedabad', gmv: '₹11,50,000', tier: 'Gold Distributor' }
            ],
            msgTemplate: "✨ *DT BRAND'S FRESH RE-STOCK DISPATCH ALERT*\n\nNamaste Partner,\nFresh festive weaving lots of *Kanjeevaram & Dola Silk* have arrived at Surat Warehouse. Priority 24-hr dispatch is reserved for your regional hub."
        },
        'SEG-03': {
            title: 'Seasonal Festive Buyers',
            accounts: [
                { id: 'WHL-8014', name: 'Jaipur Heritage Sarees & Fabrics', city: 'Jaipur', gmv: '₹8,40,000', tier: 'Silver Bulk' },
                { id: 'WHL-8017', name: 'Kolkata Zari & Silk Traders', city: 'Kolkata', gmv: '₹6,90,000', tier: 'Silver Bulk' }
            ],
            msgTemplate: "🪔 *DT BRAND'S DIWALI & WEDDING SEASON EARLY ACCESS*\n\nNamaste Partner,\nPre-book your bulk festive saree collections with guaranteed delivery before festival rush. View catalog and lock your wholesale lots."
        },
        'SEG-04': {
            title: 'Credit Watch & Dormant Accounts',
            accounts: [
                { id: 'WHL-8019', name: 'Deccan Silk Retailers Association', city: 'Hyderabad', gmv: '₹3,50,000', tier: 'Bronze Starter' }
            ],
            msgTemplate: "🤝 *DT BRAND'S PARTNER RECONNECT & CREDIT RENEWAL*\n\nNamaste Partner,\nYour revolving credit facility is active with pre-sanctioned headroom. Reconnect with our B2B desk for special re-order incentives."
        }
    };

    let activeBroadcastTemplate = '';

    // ── Open Create Cohort Modal ──
    window.openCreateCohortModal = function () {
        window.openWholesaleModal('dtCreateCohortModal');
    };

    // ── Submit Create Cohort ──
    window.submitCreateCohort = function (event) {
        if (event) event.preventDefault();

        const name = document.getElementById('newCohortNameInput').value.trim();
        const criteria = document.getElementById('newCohortCriteriaInput').value.trim();
        const share = document.getElementById('newCohortShareInput').value.trim() || '10% of GMV';
        const partners = document.getElementById('newCohortPartnersInput').value.trim() || '12';

        if (!name || !criteria) {
            window.showToast('⚠️ Please fill in all required cohort fields.');
            return;
        }

        const grid = document.getElementById('wholesaleCohortsGrid');
        if (grid) {
            const card = document.createElement('div');
            card.style.cssText = 'background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:10px; padding:14px; display:flex; flex-direction:column; justify-content:space-between; gap:10px; box-shadow:0 2px 8px rgba(0,0,0,0.02);';

            const newSegId = 'SEG-0' + (document.querySelectorAll('.cohort-card-item').length + 1);
            card.className = 'cohort-card-item';

            card.innerHTML = `
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
                        <strong style="font-size:0.86rem; color:#181512;">${name}</strong>
                        <span class="dt-status-pill-clean gold">${partners} Accounts</span>
                    </div>
                    <div style="font-size:0.7rem; color:#78716C; margin-top:6px;">
                        Revenue Share: <strong style="color:#15803D;">${share}</strong>
                    </div>
                    <p style="font-size:0.72rem; color:#78716C; margin:6px 0 0 0; background:#FAF8F4; padding:6px 8px; border-radius:6px;">
                        ${criteria}
                    </p>
                </div>
                <div style="border-top:1px solid #F1ECE1; padding-top:8px; display:flex; justify-content:space-between; align-items:center; gap:8px;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openCohortAccountsModal('${newSegId}', '${name.replace(/'/g, "\\'")}')">
                        <span>View Accounts</span>
                    </button>
                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="openCohortBroadcastModal('${newSegId}', '${name.replace(/'/g, "\\'")}')">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#FFFFFF" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>WhatsApp Broadcast</span>
                    </button>
                </div>
            `;

            grid.prepend(card);
        }

        window.closeWholesaleModal('dtCreateCohortModal');
        window.showToast(`✅ Created cohort "${name}" successfully!`);
    };

    // ── Open View Accounts Modal ──
    window.openCohortAccountsModal = function (segId, segName) {
        const seg = cohortAccountsData[segId] || {
            title: segName || 'Cohort Wholesalers',
            accounts: [
                { id: 'WHL-8012', name: 'Shree Balaji Silk Mills Pvt Ltd', city: 'Surat', gmv: '₹28,50,000', tier: 'Platinum VIP' },
                { id: 'WHL-8015', name: 'Kanchipuram Silk Stockists', city: 'Chennai', gmv: '₹24,80,000', tier: 'Platinum VIP' }
            ]
        };

        const titleEl = document.getElementById('cohortAccountsModalTitle');
        const listEl = document.getElementById('cohortAccountsListContainer');

        if (titleEl) titleEl.innerText = seg.title;
        if (listEl) {
            listEl.innerHTML = seg.accounts.map(acc => `
                <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px 14px; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                    <div>
                        <strong style="color:#181512; font-size:0.85rem; display:block;">${acc.name}</strong>
                        <div style="font-size:0.7rem; color:#78716C; font-family:monospace; margin-top:2px;">
                            ID: <span style="color:#8A681F; font-weight:800;">${acc.id}</span> • City: ${acc.city} • GMV: <strong style="color:#15803D;">${acc.gmv}</strong>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span class="dt-status-pill-clean gold">${acc.tier}</span>
                        <a href="/DT%20Brand/admin/wholesale/view.php?id=${acc.id}" class="dt-btn dt-btn-pale dt-btn-sm" style="text-decoration:none;">View Dossier</a>
                    </div>
                </div>
            `).join('');
        }

        window.openWholesaleModal('dtViewCohortAccountsModal');
    };

    // ── Open WhatsApp Broadcast Modal ──
    window.openCohortBroadcastModal = function (segId, segName) {
        const seg = cohortAccountsData[segId] || {
            title: segName || 'Wholesale Cohort',
            msgTemplate: "👑 *DT BRAND'S B2B WHOLESALE UPDATE*\n\nNamaste Partner,\nWe have updated commercial lots and credit facilities for your account."
        };

        activeBroadcastTemplate = seg.msgTemplate;

        const titleEl = document.getElementById('broadcastCohortTitle');
        const msgEl = document.getElementById('broadcastMessageTextarea');

        if (titleEl) titleEl.innerText = seg.title;
        if (msgEl) msgEl.value = seg.msgTemplate;

        window.openWholesaleModal('dtCohortBroadcastModal');
    };

    // ── Trigger Segment WhatsApp Broadcast ──
    window.triggerSegmentBroadcast = function () {
        const msg = document.getElementById('broadcastMessageTextarea')?.value || activeBroadcastTemplate;
        const encoded = encodeURIComponent(msg);

        window.open(`https://api.whatsapp.com/send?phone=917046363528&text=${encoded}`, '_blank');
        window.closeWholesaleModal('dtCohortBroadcastModal');
        window.showToast('🚀 WhatsApp Broadcast Campaign Dispatched to Cohort!');
    };

})();
