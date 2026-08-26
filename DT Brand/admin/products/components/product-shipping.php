<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-shipping.php — Shipping Dimensions & Weight Specs
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
            <span>Logistics &amp; Parcel Dimensions</span>
        </h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label class="adm-form-label">Dead Weight</label>
                <input type="text" class="adm-form-input" value="750 grams (0.75 kg)">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Dimensions (L × W × H)</label>
                <input type="text" class="adm-form-input" value="35 × 25 × 5 cm">
            </div>
            <div class="adm-form-group full">
                <label class="adm-form-label">Shipping Class</label>
                <select class="adm-form-select">
                    <option selected>Standard Textile Express (Air/Surface)</option>
                    <option>Heavy B2B Consignment (TCI Freight)</option>
                    <option>Fragile Zari Box Parcel</option>
                </select>
            </div>
        </div>
    </div>
</div>
