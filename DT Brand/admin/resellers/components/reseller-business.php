<?php
/**
 * reseller-business.php — DT Brand's & Jai Hanuman Tex
 * Reseller Business Information & GSTIN Tax Component
 */
$reseller = isset($reseller) && is_array($reseller) ? $reseller : [];
?>

<div class="dt-business-grid">
    <!-- Business Legal Profile -->
    <div class="dt-card" style="padding:18px;">
        <h4 class="dt-card-title" style="margin-bottom:14px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
            <span>Legal Business Profile</span>
        </h4>
        <div class="dt-info-row">
            <span class="dt-info-lbl">Registered Business Name</span>
            <span class="dt-info-val"><?php echo htmlspecialchars($reseller['name'] ?? 'Shree Krishna Sarees & Boutique'); ?></span>
        </div>
        <div class="dt-info-row">
            <span class="dt-info-lbl">Constitution of Business</span>
            <span class="dt-info-val">Sole Proprietorship</span>
        </div>
        <div class="dt-info-row">
            <span class="dt-info-lbl">Principal Business Activity</span>
            <span class="dt-info-val">Wholesale &amp; Retail Textile Reselling</span>
        </div>
        <div class="dt-info-row">
            <span class="dt-info-lbl">Year Established</span>
            <span class="dt-info-val">2018 (8 Years in Operation)</span>
        </div>
        <div class="dt-info-row">
            <span class="dt-info-lbl">Annual Resale Turnover</span>
            <span class="dt-info-val" style="color:#8A681F; font-weight:800;">₹45 Lakhs - ₹75 Lakhs</span>
        </div>
    </div>

    <!-- Tax & GSTIN Verification -->
    <div class="dt-card" style="padding:18px;">
        <div class="dt-card-head" style="margin-bottom:14px;">
            <h4 class="dt-card-title">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#15803D" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                <span>Tax &amp; GSTIN Verification</span>
            </h4>
            <span class="dt-gst-verified-pill">✓ Active in GSTN Portal</span>
        </div>

        <div class="dt-gst-verification-box">
            <div style="font-size:0.72rem; color:#78716C; font-weight:700;">GSTIN NUMBER:</div>
            <div style="display:flex; align-items:center; justify-content:space-between; gap:10px;">
                <strong style="font-size:1rem; font-family:monospace; letter-spacing:0.05em; color:#181512;">24AAAPL1234F1Z8</strong>
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="copyToClipboard('24AAAPL1234F1Z8', 'GSTIN')">Copy</button>
            </div>
            <small style="color:#15803D; font-size:0.68rem; font-weight:700;">● Legal Trade Name: SHREE KRISHNA SAREES</small>
        </div>

        <div style="margin-top:12px;">
            <div class="dt-info-row">
                <span class="dt-info-lbl">PAN Number</span>
                <span class="dt-info-val" style="font-family:monospace;">AAAPL1234F</span>
            </div>
            <div class="dt-info-row">
                <span class="dt-info-lbl">Tax Registration State</span>
                <span class="dt-info-val">Gujarat (State Code 24)</span>
            </div>
            <div class="dt-info-row">
                <span class="dt-info-lbl">TDS / TCS Compliance</span>
                <span class="dt-info-val" style="color:#15803D;">Compliant under 194Q</span>
            </div>
        </div>
    </div>
</div>
