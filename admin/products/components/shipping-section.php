<?php
/**
 * shipping-section.php — Shipping Dimensions & Weight Specs
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title" style="display:flex; align-items:center; gap:8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
            <span>Logistics &amp; Parcel Dimensions</span>
        </h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label class="adm-form-label">Dead Weight (Grams / Kg)</label>
                <input type="text" class="adm-form-input" value="750 grams (0.75 kg)">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Dimensions (L × W × H cm)</label>
                <input type="text" class="adm-form-input" value="35 × 25 × 5 cm">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Shipping Class</label>
                <select class="adm-form-select">
                    <option>Standard Textile Express</option>
                    <option>Heavy B2B Consignment (TCI Freight)</option>
                    <option>Fragile Zari Box Parcel</option>
                </select>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Delivery Availability</label>
                <select class="adm-form-select">
                    <option>All India 19,000+ Pincodes</option>
                    <option>Metro Cities Only</option>
                </select>
            </div>
        </div>
    </div>
</div>
