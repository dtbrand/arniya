/**
 * returns.js — Return Authorization, Inspection, Video Evidence & Approval
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    // Comprehensive RMA & Customer Return Evidence Database
    const RMA_DATA = {
        'RMA-9021': {
            id: 'RMA-9021',
            orderId: 'DTB-001618',
            type: 'customer',
            typeLabel: 'Customer RMA Claim',
            customer: 'Shree Saree Niketan',
            contact: '+91 98221 00192',
            city: 'Surat Wholesale Lot',
            product: 'Chanderi Zari Tissue Festive Saree (x5)',
            sku: 'SKU-CHN-ZRI-882',
            amount: '12,450',
            reason: 'Shade Variation in Lot (2 sarees lighter tone than catalog swatch)',
            date: '20 Aug 2026',
            status: 'pending',
            statusLabel: 'Pending Review',
            carrier: 'BlueDart Air Reverse',
            awb: 'BLU-REV-99210',
            note: 'Buyer opened wholesale carton on arrival and noticed color shade deviation across 2 sarees in the 5-piece lot. Unboxing video was recorded continuously without cuts showing carton seal breaking.',
            videoDuration: '0:42 HD (Recorded 20 Aug)',
            photos: [
                { title: 'Defect Saree 1 vs Master Swatch', tag: 'Shade Mismatch', icon: '🎨' },
                { title: 'Defect Saree 2 Border Weave', tag: 'Color Deviation', icon: '🔍' },
                { title: 'Intact Lot Carton Barcode & Seal', tag: 'Outer Box', icon: '📦' }
            ],
            qcChecklist: [
                { item: 'Unbroken Outer Parcel Seal in Video', passed: true },
                { item: 'Original DT Brand Tag & Barcode Attached', passed: true },
                { item: 'Fabric Unwashed / Unworn Condition', passed: true }
            ]
        },
        'RMA-9020': {
            id: 'RMA-9020',
            orderId: 'DTB-001614',
            type: 'customer',
            typeLabel: 'Customer RMA Claim',
            customer: 'Kavita Agarwal',
            contact: '+91 98765 43210',
            city: 'Ahmedabad Retail',
            product: 'Banarasi Katan Silk Handloom (x1)',
            sku: 'SKU-BAN-KTN-104',
            amount: '6,490',
            reason: 'Defective Zari Thread (Pull near Pallu corner)',
            date: '19 Aug 2026',
            status: 'confirmed',
            statusLabel: 'Approved for Pickup',
            carrier: 'Delhivery Surface Reverse',
            awb: 'DLV-REV-88312',
            note: 'Defect identified during pre-draping inspection. Gold zari thread loop pulled out on pallu end. Video shows close-up macro view.',
            videoDuration: '0:35 HD (Recorded 19 Aug)',
            photos: [
                { title: 'Pallu Zari Thread Pull Macro', tag: 'Loom Defect', icon: '🧵' },
                { title: 'Silk Mark Security Hologram', tag: 'Original Tag', icon: '🏷️' }
            ],
            qcChecklist: [
                { item: 'Continuous Unboxing Video Evidence', passed: true },
                { item: 'Silk Mark Certified Hologram Intact', passed: true },
                { item: 'No Alterations or Tailoring Done', passed: true }
            ]
        },
        'RMA-9019': {
            id: 'RMA-9019',
            orderId: 'DTB-001595',
            type: 'rto',
            typeLabel: 'RTO Consignment (Carrier Return)',
            customer: 'Vardhman Tex Godown',
            contact: '+91 98220 19283',
            city: 'Surat Central Depot Dock',
            product: 'Pure Kanjivaram Bridal Silk (x2)',
            sku: 'SKU-KNJ-BRD-550',
            amount: '24,000',
            reason: 'RTO: Consignee Godown Closed after 3 Carrier Attempts',
            date: '17 Aug 2026',
            status: 'shipped',
            statusLabel: 'Depot Dock Inspection',
            carrier: 'VRL Logistics Cargo',
            awb: 'VRL-RTO-77192',
            note: 'Package returned to Surat depot due to destination premises shut. Courier driver unboxing scan recorded at Surat depot inbound receiving bay.',
            videoDuration: '1:10 HD (Depot Bay Scan)',
            photos: [
                { title: 'VRL Cargo Inbound Dock Receipt', tag: 'Dock Seal', icon: '🚛' },
                { title: 'Sealed Security Bag Condition', tag: 'Tamper Intact', icon: '🔒' }
            ],
            qcChecklist: [
                { item: 'Tamper-Proof Courier Bag Untouched', passed: true },
                { item: 'Inbound Depot Weight Verified (4.8 kg)', passed: true },
                { item: 'Both Saree Gift Boxes Mint Condition', passed: true }
            ]
        },
        'RMA-9018': {
            id: 'RMA-9018',
            orderId: 'DTB-001588',
            type: 'customer',
            typeLabel: 'Customer RMA Claim',
            customer: 'Ananya Silks Bangalore',
            contact: '+91 98450 11223',
            city: 'Bangalore Hub',
            product: 'Organza Digital Floral Saree (x10)',
            sku: 'SKU-ORG-FLR-202',
            amount: '18,500',
            reason: 'Wrong Catalog Color Dispatched (Received Pastel Green instead of Rose Gold)',
            date: '15 Aug 2026',
            status: 'delivered',
            statusLabel: 'Completed & Restocked',
            carrier: 'DTDC Express Air',
            awb: 'DTC-REV-39108',
            note: 'Warehouse packing slip human error. Items received back in Surat depot, audited, and credited to buyer B2B ledger.',
            videoDuration: '0:55 HD (Unboxing Verified)',
            photos: [
                { title: 'Pastel Green Batch Received', tag: 'Catalog Check', icon: '👗' },
                { title: 'Restock Bin Scan Barcode', tag: 'Surat Depot', icon: '🏢' }
            ],
            qcChecklist: [
                { item: 'All 10 Pieces Present & Sealed', passed: true },
                { item: 'Original Invoice Enclosed', passed: true },
                { item: 'Ledger Credit Note Settled', passed: true }
            ]
        }
    };

    let activeRmaId = null;

    window.DT_RETURNS = {
        viewRmaDetails: function(returnId) {
            activeRmaId = returnId;
            const data = RMA_DATA[returnId];
            if (!data) return;

            document.getElementById('viewRmaIdText').textContent = data.id + ' • ' + data.typeLabel;

            const modalBody = document.getElementById('viewRmaModalBody');
            // Build Photos HTML with HD preview badges
            let photosHtml = '';
            data.photos.forEach((p, idx) => {
                photosHtml += `
                    <div class="dt-evidence-photo-item" onclick="window.DT_RETURNS.openPhotoLightbox('${p.title}', '${p.tag}', '${data.id}', '${p.icon}')" title="Click to Open Full View: ${p.title}">
                        <div style="width:100%; height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; background:linear-gradient(135deg, #FAF8F4 0%, #F5EFE6 100%); text-align:center; padding:5px; box-sizing:border-box;">
                            <span style="font-size:24px; filter:drop-shadow(0 2px 4px rgba(0,0,0,0.15));">${p.icon}</span>
                            <span style="font-size:8.5px; font-weight:800; color:#8A681F; margin-top:3px; text-transform:uppercase; letter-spacing:0.3px;">${p.tag}</span>
                            <span style="font-size:7.5px; color:#1D4ED8; font-weight:700;">🔍 Click Full View</span>
                        </div>
                    </div>
                `;
            });

            // Build QC checklist HTML
            let qcHtml = '';
            data.qcChecklist.forEach(qc => {
                qcHtml += `
                    <div style="display:flex; align-items:center; gap:6px; font-size:11px; color:#181512;">
                        <span style="color:#15803D; font-weight:800; font-size:12px;">✓</span>
                        <span>${qc.item}</span>
                    </div>
                `;
            });

            modalBody.innerHTML = `
                <!-- Beneficiary & Return Header Card -->
                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px; display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <span style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em;">Customer &amp; Consignee</span>
                        <div style="font-weight:800; font-size:13.5px; color:#181512; margin-top:2px;">${data.customer}</div>
                        <div style="font-size:11px; color:#64748B; margin-top:2px;">${data.city} • <span style="color:#181512; font-weight:600;">${data.contact}</span></div>
                    </div>
                    <div style="text-align:right;">
                        <span style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em;">Order &amp; Valuation</span>
                        <div style="font-weight:800; font-size:14px; color:#DC2626; margin-top:2px;">₹${data.amount}</div>
                        <div style="font-size:11px; color:#64748B; margin-top:2px;">Order Ref: <a href="/DT%20Brand/admin/orders/view.php?id=${data.orderId}" style="color:#1D4ED8; font-weight:700; text-decoration:none;">${data.orderId}</a></div>
                    </div>
                </div>

                <!-- Product & Claim Reason Box -->
                <div style="border-left:3px solid #D4AF37; padding:10px 14px; background:#FAF5E8; border-radius:0 8px 8px 0; border-top:1px solid #EADBBA; border-right:1px solid #EADBBA; border-bottom:1px solid #EADBBA;">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:6px;">
                        <strong style="color:#181512; font-size:13px;">${data.product}</strong>
                        <span style="font-size:10px; font-weight:800; color:#8A681F; background:#FFFFFF; border:1px solid #D4AF37; padding:2px 8px; border-radius:4px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">${data.sku}</span>
                    </div>
                    <div style="margin-top:5px; font-size:11.5px; color:#92400E; font-weight:750;">
                        Reason: ${data.reason}
                    </div>
                    <div style="margin-top:6px; font-size:11px; color:#475569; line-height:1.45;">
                        ${data.note}
                    </div>
                </div>

                <!-- Evidence Section: Photos + Interactive Video Proof -->
                <div style="display:grid; grid-template-columns:1fr 1.2fr; gap:12px;">
                    <!-- Evidence Photos Gallery -->
                    <div class="dt-evidence-box">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:11px; font-weight:800; color:#181512; text-transform:uppercase; letter-spacing:0.3px;">Defect Photos (${data.photos.length})</span>
                            <span style="font-size:10px; color:#8A681F; font-weight:800; background:#FAF5E8; border:1px solid #D4AF37; padding:1px 5px; border-radius:3px;">HD Evidence</span>
                        </div>
                        <div class="dt-evidence-photos">
                            ${photosHtml}
                        </div>
                        <div style="font-size:10.5px; color:#64748B; margin-top:8px; display:flex; align-items:center; gap:4px;">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <span>Click thumbnail for full-screen inspection zoom.</span>
                        </div>
                    </div>

                    <!-- Video Proof Player Card -->
                    <div class="dt-evidence-box">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <span style="font-size:11px; font-weight:800; color:#181512; text-transform:uppercase; letter-spacing:0.3px;">Unboxing Video Proof</span>
                            <span style="font-size:10px; color:#15803D; font-weight:800; background:#DCFCE7; border:1px solid #86EFAC; padding:1px 6px; border-radius:3px;">✓ Verified Seal</span>
                        </div>
                        <div id="rmaVideoPlayerCard" class="dt-video-preview-card" onclick="window.DT_RETURNS.openVideoTheater('${data.id}', '${data.videoDuration}')" title="Click to Open Full Video in Theater Mode">
                            <span class="dt-video-badge">${data.videoDuration}</span>
                            <div id="rmaVideoPlayIcon" class="dt-video-play-btn">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            </div>
                            <div style="font-size:11.5px; font-weight:800; text-shadow:0 1px 4px rgba(0,0,0,0.85);">Play Continuous Unboxing Video</div>
                            <div style="font-size:10px; opacity:0.85; margin-top:2px;">100% Unbroken Seal Verification • Click Theater View</div>
                        </div>
                    </div>
                </div>

                <!-- Reverse Courier Tracking & Surat Depot QC Dock Inspection -->
                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px; display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <span style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em;">Reverse Pickup Logistics</span>
                        <div style="font-weight:750; font-size:12.5px; color:#181512; margin-top:3px;">${data.carrier}</div>
                        <div style="font-size:11px; color:#1D4ED8; font-weight:700; margin-top:2px; display:flex; align-items:center; gap:4px;">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <span>AWB: ${data.awb}</span>
                        </div>
                    </div>
                    <div>
                        <span style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em;">Depot QC Checklist</span>
                        <div style="display:flex; flex-direction:column; gap:4px; margin-top:3px;">
                            ${qcHtml}
                        </div>
                    </div>
                </div>
            `;

            // Wire action buttons
            const approveBtn = document.getElementById('modalApproveBtn');
            const rejectBtn = document.getElementById('modalRejectBtn');
            const whatsappBtn = document.getElementById('modalWhatsAppBtn');

            approveBtn.onclick = () => window.DT_RETURNS.approveReturn(returnId);
            rejectBtn.onclick = () => window.DT_RETURNS.openRejectModal(returnId);
            whatsappBtn.onclick = () => window.DT_RETURNS.shareWhatsApp(returnId);

            modalBody.scrollTop = 0;
            document.getElementById('viewRmaModal').style.display = 'flex';
        },

        closeRmaModal: function() {
            document.getElementById('viewRmaModal').style.display = 'none';
        },

        openPhotoLightbox: function(title, tag, rmaId, icon) {
            const data = RMA_DATA[rmaId] || {};
            const lightbox = document.getElementById('dtMediaLightboxModal');
            const badge = document.getElementById('lightboxTypeBadge');
            const titleEl = document.getElementById('lightboxTitleText');
            const subEl = document.getElementById('lightboxSubText');
            const content = document.getElementById('lightboxMediaContent');
            const footerInfo = document.getElementById('lightboxFooterInfo');

            badge.textContent = `HD Defect Photo • ${tag}`;
            badge.style.background = '#FAF5E8';
            badge.style.color = '#8A681F';
            badge.style.borderColor = '#D4AF37';

            titleEl.textContent = `${title} — ${data.product || rmaId}`;
            subEl.textContent = `Claim ID: ${rmaId} • Consignee: ${data.customer || 'Customer'} • Verified High-Res Weave Inspection`;
            footerInfo.innerHTML = `<span style="color:#22C55E; font-weight:800;">✓ Authenticated Defect Capture</span> • Original Upload Timestamp: <strong>${data.date || '20 Aug 2026'}</strong>`;

            content.innerHTML = `
                <div style="width:100%; display:flex; flex-direction:column; align-items:center; gap:16px;">
                    <div style="position:relative; width:100%; max-width:640px; height:340px; border-radius:10px; background:radial-gradient(circle, #2A241E 0%, #15110E 100%); border:2px solid #D4AF37; box-shadow:0 12px 36px rgba(0,0,0,0.8); display:flex; flex-direction:column; align-items:center; justify-content:center; overflow:hidden;">
                        <!-- Defect Pin Marker -->
                        <div style="position:absolute; top:28%; left:42%; background:rgba(220,38,38,0.92); border:1.5px solid #FFFFFF; border-radius:20px; padding:3px 10px; font-size:10.5px; font-weight:800; color:#FFFFFF; box-shadow:0 4px 12px rgba(0,0,0,0.4); display:flex; align-items:center; gap:4px; z-index:10; animation:pulse 2s infinite;">
                            <span>📍</span>
                            <span>Defect Area: ${tag}</span>
                        </div>

                        <!-- Macro Canvas Simulation -->
                        <div style="font-size:72px; filter:drop-shadow(0 6px 12px rgba(0,0,0,0.5));">${icon || '🎨'}</div>
                        <div style="margin-top:12px; font-size:14px; font-weight:800; color:#FAF5E8; letter-spacing:0.5px;">${title}</div>
                        <div style="font-size:11px; color:#A8A29E; margin-top:4px;">Macro Texture Level • 4000 × 3000 Raw Sensor Data</div>
                        
                        <!-- Zoom Watermark -->
                        <div style="position:absolute; bottom:12px; right:14px; background:rgba(0,0,0,0.7); border:1px solid #D4AF37; padding:2px 8px; border-radius:4px; font-size:10px; font-weight:800; color:#D4AF37;">
                            🔍 5.0× Optical Inspection
                        </div>
                    </div>

                    <!-- Defect Annotation Details -->
                    <div style="background:#241E18; border:1px solid #3D342A; border-radius:8px; padding:10px 16px; width:100%; max-width:640px; box-sizing:border-box; display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <span style="font-size:10px; color:#8A681F; font-weight:800; text-transform:uppercase;">Inspection Finding</span>
                            <div style="font-size:12px; font-weight:700; color:#FAF5E8; margin-top:2px;">${data.reason || 'Defect confirmed via unboxing audit'}</div>
                        </div>
                        <div style="text-align:right;">
                            <span style="font-size:10px; color:#8A681F; font-weight:800; text-transform:uppercase;">QC Result</span>
                            <div style="font-size:12px; font-weight:800; color:#22C55E; margin-top:2px;">✓ Approved for Return</div>
                        </div>
                    </div>
                </div>
            `;

            lightbox.style.display = 'flex';
            if (window.DT_ORDERS) window.DT_ORDERS.showToast(`🔍 Opened Full-Screen Inspection: ${title}`);
        },

        openVideoTheater: function(rmaId, duration) {
            const data = RMA_DATA[rmaId] || {};
            const lightbox = document.getElementById('dtMediaLightboxModal');
            const badge = document.getElementById('lightboxTypeBadge');
            const titleEl = document.getElementById('lightboxTitleText');
            const subEl = document.getElementById('lightboxSubText');
            const content = document.getElementById('lightboxMediaContent');
            const footerInfo = document.getElementById('lightboxFooterInfo');

            badge.textContent = `4K Unboxing Video Stream • ${duration || '0:42 HD'}`;
            badge.style.background = '#DCFCE7';
            badge.style.color = '#15803D';
            badge.style.borderColor = '#86EFAC';

            titleEl.textContent = `Continuous Package Unboxing Stream — ${data.customer || rmaId}`;
            subEl.textContent = `RMA: ${rmaId} • Order: ${data.orderId} • Continuous One-Take Recording (Zero Cuts / Intact Seal)`;
            footerInfo.innerHTML = `<span style="color:#22C55E; font-weight:800;">✓ Official Courier Intake Verified</span> • Video Stream Status: <strong>LIVE PLAYBACK</strong>`;

            content.innerHTML = `
                <div style="width:100%; display:flex; flex-direction:column; align-items:center; gap:16px;">
                    <!-- Theater Video Box -->
                    <div style="position:relative; width:100%; max-width:680px; height:360px; border-radius:12px; background:#000000; border:2px solid #D4AF37; box-shadow:0 14px 44px rgba(0,0,0,0.85); display:flex; flex-direction:column; align-items:center; justify-content:center; overflow:hidden;">
                        <!-- Top HUD Bar -->
                        <div style="position:absolute; top:0; left:0; right:0; padding:10px 14px; background:linear-gradient(rgba(0,0,0,0.85), transparent); display:flex; justify-content:space-between; align-items:center; z-index:10; font-size:11px;">
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#EF4444; animation:pulse 1.2s infinite;"></span>
                                <strong style="color:#FFFFFF; letter-spacing:0.5px;">REC • UNBOXING ONE-TAKE</strong>
                            </div>
                            <span style="background:rgba(21,128,61,0.85); border:1px solid #86EFAC; color:#FFFFFF; font-size:9.5px; font-weight:800; padding:2px 8px; border-radius:4px;">✓ SEAL INTACT</span>
                        </div>

                        <!-- Center Play / Active Display -->
                        <div style="text-align:center; z-index:5;">
                            <div style="width:58px; height:58px; border-radius:50%; background:linear-gradient(135deg, #8A681F 0%, #D4AF37 100%); display:flex; align-items:center; justify-content:center; color:#181512; margin:0 auto 10px auto; box-shadow:0 4px 16px rgba(212,175,55,0.6); cursor:pointer;">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><rect x="6" y="4" width="4" height="16"></rect><rect x="14" y="4" width="4" height="16"></rect></svg>
                            </div>
                            <div style="font-size:14px; font-weight:800; color:#FAF5E8; text-shadow:0 2px 6px rgba(0,0,0,0.9);">Playing Unboxing Video Proof Stream</div>
                            <div style="font-size:11px; color:#D4AF37; font-weight:700; margin-top:3px;">Surat Central Depot Quality Department Audit</div>
                        </div>

                        <!-- Bottom Video Controls & Time Bar -->
                        <div style="position:absolute; bottom:0; left:0; right:0; padding:12px 16px; background:linear-gradient(transparent, rgba(0,0,0,0.95)); display:flex; flex-direction:column; gap:6px; z-index:10;">
                            <div style="display:flex; justify-content:space-between; font-size:10.5px; color:#FFFFFF; font-weight:700;">
                                <span>▶️ 00:24 / ${duration || '00:42'}</span>
                                <span style="color:#D4AF37;">4K Ultra-HD 60fps</span>
                            </div>
                            <div style="width:100%; height:6px; background:rgba(255,255,255,0.25); border-radius:3px; overflow:hidden;">
                                <div style="width:58%; height:100%; background:linear-gradient(90deg, #8A681F, #D4AF37); border-radius:3px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            lightbox.style.display = 'flex';
            if (window.DT_ORDERS) window.DT_ORDERS.showToast(`🎥 Opened 4K Video Theater Mode for ${rmaId}`);
        },

        closeLightbox: function() {
            const lightbox = document.getElementById('dtMediaLightboxModal');
            if (lightbox) lightbox.style.display = 'none';
        },


        openRejectModal: function(returnId) {
            activeRmaId = returnId;
            document.getElementById('rejectRmaIdText').textContent = returnId;
            document.getElementById('rejectRmaModal').style.display = 'flex';
        },

        closeRejectModal: function() {
            document.getElementById('rejectRmaModal').style.display = 'none';
        },

        confirmReject: function(e) {
            if (e) e.preventDefault();
            const rmaId = activeRmaId;
            const reason = document.getElementById('rejectReasonSelect').value;
            const remarks = document.getElementById('rejectRemarksText').value;
            const sendWhatsApp = document.getElementById('rejectSendWhatsApp').checked;

            const row = document.getElementById(`returnRow_${rmaId}`);
            if (row) {
                const badge = row.querySelector('.dt-status-badge');
                if (badge) {
                    badge.className = 'dt-status-badge cancelled';
                    badge.innerHTML = '<span class="dt-status-dot"></span><span>Rejected</span>';
                }
                const actions = row.querySelector('.col-rma-actions');
                if (actions) {
                    actions.innerHTML = `
                        <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:5px;">
                            <button type="button" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 8px; font-size:11px; font-weight:700;" onclick="window.DT_RETURNS.viewRmaDetails('${rmaId}')">
                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <span>View</span>
                            </button>
                            <button type="button" onclick="window.DT_RETURNS.shareWhatsApp('${rmaId}')" class="dt-btn" style="background:#15803D; border:1px solid #166534; color:#FFFFFF; height:28px; padding:0 8px; font-size:11px; font-weight:700;">
                                <span>WhatsApp</span>
                            </button>
                        </div>
                    `;
                }
            }

            this.closeRejectModal();
            this.closeRmaModal();

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`🛑 Return ${rmaId} rejected: ${reason.substring(0, 32)}...`);
            }

            if (sendWhatsApp) {
                this.shareWhatsApp(rmaId, `Return Request ${rmaId} was declined by QC Dept. Reason: ${reason}`);
            }
        },

        approveReturn: function(returnId) {
            const row = document.getElementById(`returnRow_${returnId}`);
            if (row) {
                const badge = row.querySelector('.dt-status-badge');
                if (badge) {
                    badge.className = 'dt-status-badge confirmed';
                    badge.innerHTML = '<span class="dt-status-dot"></span><span>Approved for Pickup</span>';
                }
                const actions = row.querySelector('.col-rma-actions');
                if (actions) {
                    actions.innerHTML = `
                        <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:5px;">
                            <button type="button" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 8px; font-size:11px; font-weight:700;" onclick="window.DT_RETURNS.viewRmaDetails('${returnId}')">
                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <span>View</span>
                            </button>
                            <button type="button" onclick="window.DT_RETURNS.shareWhatsApp('${returnId}')" class="dt-btn" style="background:#15803D; border:1px solid #166534; color:#FFFFFF; height:28px; padding:0 8px; font-size:11px; font-weight:700;">
                                <span>WhatsApp</span>
                            </button>
                        </div>
                    `;
                }
            }

            this.closeRmaModal();

            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`⚡ RMA ${returnId} approved for reverse courier pickup`);
            }
        },

        shareWhatsApp: function(returnId, customNote) {
            const data = RMA_DATA[returnId] || { customer: 'Valued Consignee', amount: '0', orderId: returnId };
            const msgText = customNote || `Namaste ${data.customer},\n\nRegarding your Return Request *${returnId}* for Order *${data.orderId}* (Amount: ₹${data.amount}):\n\nYour evidence photos and unboxing proof have been audited by DT Brand's & Jai Hanuman Tex Surat Central Depot.\n\nFor questions, reply to this official wholesale support channel.\n\n*DT BRAND'S & JAI HANUMAN TEX*`;
            const cleanPhone = (data.contact || '').replace(/[^0-9]/g, '');
            const targetUrl = `https://api.whatsapp.com/send?phone=${cleanPhone || '919822100192'}&text=${encodeURIComponent(msgText)}`;
            window.open(targetUrl, '_blank');
        },

        handleSearch: function(query) {
            const q = query.trim().toLowerCase();
            const rows = document.querySelectorAll('#rmaTableBody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        },

        filterByType: function(type) {
            const rows = document.querySelectorAll('#rmaTableBody tr');
            rows.forEach(row => {
                const rowType = row.dataset.type;
                if (type === 'all' || rowType === type) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        },

        toggleColumnMenu: function(event) {
            if (event) event.stopPropagation();
            const menu = document.getElementById('rmaColumnVisibilityMenu');
            if (!menu) return;
            const isVisible = menu.style.display === 'block';
            menu.style.display = isVisible ? 'none' : 'block';
        },

        toggleColumn: function(colClass, isChecked) {
            const cells = document.querySelectorAll('.' + colClass);
            cells.forEach(c => c.style.display = isChecked ? '' : 'none');
            
            try {
                const hiddenCols = JSON.parse(localStorage.getItem('dt_hidden_rma_cols') || '{}');
                hiddenCols[colClass] = !isChecked;
                localStorage.setItem('dt_hidden_rma_cols', JSON.stringify(hiddenCols));
            } catch (e) {}

            if (window.DT_ORDERS) {
                const cleanName = colClass.replace('col-rma-', '').toUpperCase();
                window.DT_ORDERS.showToast(isChecked ? '👁️ ' + cleanName + ' column visible' : '🙈 ' + cleanName + ' column hidden');
            }
        },

        resetAllColumns: function() {
            try {
                localStorage.removeItem('dt_hidden_rma_cols');
            } catch (e) {}

            const checkboxes = document.querySelectorAll('#rmaColumnVisibilityMenu input[type="checkbox"]');
            checkboxes.forEach(cb => {
                cb.checked = true;
                const colClass = cb.dataset.col;
                if (colClass) {
                    const cells = document.querySelectorAll('.' + colClass);
                    cells.forEach(c => c.style.display = '');
                }
            });

            if (window.DT_ORDERS) window.DT_ORDERS.showToast('✅ All RMA columns restored to default view');
        },

        initColumnPreferences: function() {
            try {
                const hiddenCols = JSON.parse(localStorage.getItem('dt_hidden_rma_cols') || '{}');
                Object.keys(hiddenCols).forEach(colClass => {
                    const isHidden = hiddenCols[colClass];
                    if (isHidden) {
                        const cells = document.querySelectorAll('.' + colClass);
                        cells.forEach(c => c.style.display = 'none');
                        const cb = document.querySelector(`#rmaColumnVisibilityMenu input[data-col="${colClass}"]`);
                        if (cb) cb.checked = false;
                    }
                });
            } catch (e) {}
        }
    };

    // Close dropdown on click outside
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('rmaColumnVisibilityMenu');
        const wrap = document.querySelector('.dt-col-dropdown-wrap');
        if (menu && wrap && !wrap.contains(e.target)) {
            menu.style.display = 'none';
        }
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => window.DT_RETURNS.initColumnPreferences());
    } else {
        window.DT_RETURNS.initColumnPreferences();
    }
})();

