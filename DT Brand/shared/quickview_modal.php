<?php
/**
 * DT Brand/shared/quickview_modal.php — Universal Quick View Product Modal
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ════════════ QUICK VIEW MODAL ════════════ -->
<div class="dt-modal-overlay" id="dtQuickViewModalOverlay" aria-hidden="true">
    <div class="dt-modal dt-quickview-modal" id="dtQuickViewModal" role="dialog" aria-label="Quick Product View">
        <button type="button" class="dt-modal-close" onclick="closeQuickView()" aria-label="Close">✕</button>

        <div class="dt-qv-grid" id="dtQvContent">
            <!-- Left: Gallery -->
            <div class="dt-qv-gallery">
                <div class="dt-qv-main-img-wrap">
                    <img src="/Frontend/Shop/Asset/images/product1.png" alt="Product" id="dtQvMainImg" class="dt-qv-main-img" />
                    <span class="dt-qv-badge" id="dtQvBadge" style="display:none;">Bestseller</span>
                </div>
                <div class="dt-qv-thumbs" id="dtQvThumbs"></div>
            </div>

            <!-- Right: Details & Order Stepper -->
            <div class="dt-qv-details">
                <span class="dt-qv-cat" id="dtQvCategory">Kanjivaram Silk</span>
                <h3 class="dt-qv-title" id="dtQvTitle">Nilambari Silk Saree with Rich Zari Pallu</h3>
                <div class="dt-qv-sku-row">
                    <span>SKU: <strong id="dtQvSku">KLN-SR-111</strong></span>
                    <span>&bull;</span>
                    <span class="dt-qv-rating">★ <span id="dtQvRating">4.9</span> (<span id="dtQvReviews">142</span> reviews)</span>
                </div>

                <!-- Price Row -->
                <div class="dt-qv-price-row">
                    <span class="dt-qv-price" id="dtQvPrice">₹4,899</span>
                    <span class="dt-qv-old-price" id="dtQvOldPrice">₹6,500</span>
                    <span class="dt-qv-discount" id="dtQvDiscount">25% OFF</span>
                </div>

                <!-- Lot Selection Tier -->
                <div class="dt-qv-lot-tier">
                    <span class="dt-qv-option-label">Select Lot / Order Type:</span>
                    <div class="dt-qv-lots-grid">
                        <button type="button" class="dt-lot-chip active" data-lot="single" data-moq="1" onclick="selectQvLot(this)">
                            <strong>Single Piece</strong>
                            <span>Retail Sample</span>
                        </button>
                        <button type="button" class="dt-lot-chip" data-lot="half_set" data-moq="4" onclick="selectQvLot(this)">
                            <strong>Half Set (4 Pcs)</strong>
                            <span>Wholesale MOQ</span>
                        </button>
                        <button type="button" class="dt-lot-chip" data-lot="full_set" data-moq="8" onclick="selectQvLot(this)">
                            <strong>Full Set (8 Pcs)</strong>
                            <span>Catalog Box</span>
                        </button>
                    </div>
                </div>

                <!-- Quantity Stepper -->
                <div class="dt-qv-qty-row">
                    <span class="dt-qv-option-label">Quantity:</span>
                    <div class="dt-qty-stepper">
                        <button type="button" onclick="adjustQvQty(-1)">−</button>
                        <input type="number" id="dtQvQtyInput" value="1" min="1" readonly />
                        <button type="button" onclick="adjustQvQty(1)">+</button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="dt-qv-actions">
                    <button type="button" class="dt-btn-gold" id="dtQvAddCartBtn" onclick="addQvToCart()">
                        <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>Add to Bag</span>
                    </button>
                    <a href="/DT Brand/product.php?id=1" id="dtQvFullPageLink" class="dt-btn-pale">Full Details &rarr;</a>
                </div>
            </div>
        </div>

    </div>
</div>
