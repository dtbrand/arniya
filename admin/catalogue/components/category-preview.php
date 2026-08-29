<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * category-preview.php — Frontend-Style Category Landing Preview Simulator
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h4 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
            <span>Live Storefront Landing Simulator</span>
        </h4>
        <div style="display:flex; gap:6px;">
            <button type="button" class="dt-btn-action-sm pale-gold" style="height:26px; font-size:11px;">Desktop 1440p</button>
            <button type="button" class="dt-btn-action-sm pale-gold" style="height:26px; font-size:11px;">Tablet 768p</button>
            <button type="button" class="dt-btn-action-sm pale-gold" style="height:26px; font-size:11px;">Mobile 375p</button>
        </div>
    </div>

    <div style="padding:16px; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
        <!-- Simulated Category Banner (Luxury Gold Glass Style) -->
        <div class="dt-hero-luxury-card" style="padding:24px; margin-bottom:16px; flex-direction:column; align-items:flex-start; gap:8px;">
            <span class="dt-badge gold" style="margin-bottom:4px; font-weight:800; background:linear-gradient(135deg, #FFE57F, #D4AF37, #B8860B); color:#111827;">DT SIGNATURE EXCLUSIVE</span>
            <h2 style="font-family:'Cinzel', serif; font-size:22px; font-weight:800; color:#FFE57F; margin:4px 0; text-shadow:0 2px 5px rgba(0,0,0,0.8);">Pure Silk Sarees &amp; Temple Borders</h2>
            <p style="font-size:12.5px; color:#FAF5E8; max-width:600px; margin:0; line-height:1.5;">Surat Central Depot authentic powerloom and handloom silk collection with silk mark assurance.</p>
        </div>

        <!-- Simulated Product Grid -->
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:12px;">
            <div style="background:#fff; border:1px solid #e2e8f0; border-radius:6px; padding:8px; text-align:center;">
                <img src="/assets/images/product1.png" style="width:100%; height:120px; object-fit:cover; border-radius:4px; margin-bottom:6px;">
                <div style="font-size:11.5px; font-weight:700; color:#181512;">Kanjivaram Gold Zari</div>
                <div style="font-size:12px; font-weight:800; color:#15803D;">₹2,850 <small style="color:#64748b;">(Wholesale)</small></div>
            </div>
            <div style="background:#fff; border:1px solid #e2e8f0; border-radius:6px; padding:8px; text-align:center;">
                <img src="/assets/images/product2.png" style="width:100%; height:120px; object-fit:cover; border-radius:4px; margin-bottom:6px;">
                <div style="font-size:11.5px; font-weight:700; color:#181512;">Banarasi Royal Brocade</div>
                <div style="font-size:12px; font-weight:800; color:#15803D;">₹3,200 <small style="color:#64748b;">(Wholesale)</small></div>
            </div>
            <div style="background:#fff; border:1px solid #e2e8f0; border-radius:6px; padding:8px; text-align:center;">
                <img src="/assets/images/product3.png" style="width:100%; height:120px; object-fit:cover; border-radius:4px; margin-bottom:6px;">
                <div style="font-size:11.5px; font-weight:700; color:#181512;">Temple Border Chanderi</div>
                <div style="font-size:12px; font-weight:800; color:#15803D;">₹2,400 <small style="color:#64748b;">(Wholesale)</small></div>
            </div>
        </div>
    </div>
</div>
