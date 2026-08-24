<?php
/**
 * DT Brand/shared/smart_share_modal.php — Meesho-Style WhatsApp Smart Share & Margin Calculator Modal
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ════════════ MEESHO-STYLE WHATSAPP SMART SHARE MODAL ════════════ -->
<div class="dt-modal-overlay" id="dtSmartShareModalOverlay" aria-hidden="true">
    <div class="dt-modal dt-share-modal" id="dtSmartShareModal" role="dialog" aria-label="Smart WhatsApp Share">
        
        <!-- Header -->
        <div class="dt-modal-header">
            <div class="dt-modal-title-wrap">
                <span class="dt-share-icon-badge">💬</span>
                <h3 class="dt-modal-title">WhatsApp Smart Share</h3>
            </div>
            <button type="button" class="dt-modal-close" onclick="closeSmartShareModal()" aria-label="Close">✕</button>
        </div>

        <!-- Body -->
        <div class="dt-modal-body">
            <!-- Product Preview Card -->
            <div class="dt-share-preview-card">
                <img src="/assets/images/product1.png" alt="Product" id="dtShareImg" class="dt-share-thumb" />
                <div class="dt-share-info">
                    <h4 class="dt-share-name" id="dtShareTitle">Nilambari Silk Saree</h4>
                    <div class="dt-share-price-strip">
                        <span>Factory Price: <strong id="dtShareFactoryPrice">₹2,100</strong></span>
                    </div>
                </div>
            </div>

            <!-- Reseller Margin Calculator Box -->
            <div class="dt-margin-calculator-box">
                <h4 class="dt-margin-title">💰 Add Your Reseller Profit Margin</h4>
                <div class="dt-margin-inputs-row">
                    <div class="dt-margin-field">
                        <label>Your Selling Price</label>
                        <div class="dt-input-with-symbol">
                            <span>₹</span>
                            <input type="number" id="dtShareCustomerPrice" value="2800" oninput="calculateShareMargin()" />
                        </div>
                    </div>
                    <div class="dt-margin-field profit-field">
                        <label>Your Net Profit</label>
                        <div class="dt-profit-badge" id="dtShareNetProfit">+ ₹700 (33%)</div>
                    </div>
                </div>
            </div>

            <!-- Share Options & Description Copy -->
            <div class="dt-share-text-box">
                <label class="dt-field-label">WhatsApp Message Preview (Without DT Brand's watermark):</label>
                <textarea class="dt-input-field dt-share-textarea" id="dtShareTextPreview" rows="4" readonly></textarea>
                <button type="button" class="dt-btn-pale copy-desc-btn" onclick="copyShareDescription()">📋 Copy Text Description</button>
            </div>

            <!-- Action Buttons -->
            <div class="dt-share-actions-grid">
                <button type="button" class="dt-btn-emerald dt-share-wa-btn" onclick="shareOnWhatsAppDirect()">
                    <svg viewBox="0 0 24 24"><path fill="#FFF" d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg>
                    <span>Share on WhatsApp</span>
                </button>
                <button type="button" class="dt-btn-gold dt-download-img-btn" onclick="downloadProductImage()">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download Image</span>
                </button>
            </div>

        </div>

    </div>
</div>
