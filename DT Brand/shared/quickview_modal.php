<?php
/**
 * DT Brand/shared/quickview_modal.php — Universal Quick View Product Modal
 * DT Brand's & Jai Hanuman Tex
 *
 * Every visible value is now a blank slot filled by openQuickView() in
 * assets/js/modals.js from /api/products.php?id=…
 *
 * What was hardcoded here before, and stayed on screen because the JS never
 * touched it:
 *   - "Nilambari Silk Saree with Rich Zari Pallu", "Kanjivaram Silk",
 *     SKU "KLN-SR-111", "₹4,899", "₹6,500", "25% OFF" and a "Bestseller" badge
 *     — placeholders that flashed on every open;
 *   - "★ 4.9 (142 reviews)" — #dtQvReviews was never assigned by any script, so
 *     every product in the shop quick-viewed as having 142 reviews;
 *   - a #dtQvThumbs strip that nothing ever filled, so extra photos and videos
 *     of a product were unreachable from the quick view;
 *   - fixed lot chips "Half Set (4 Pcs)" / "Full Set (8 Pcs)", which ignored the
 *     product's own moq_half_set / moq_full_set / moq_master_bale.
 * Colours, sizes, stock and video had no slots at all; they do now.
 */
?>
<!-- ════════════ QUICK VIEW MODAL ════════════ -->
<div class="dt-modal-overlay" id="dtQuickViewModalOverlay" aria-hidden="true">
    <div class="dt-modal dt-quickview-modal" id="dtQuickViewModal" role="dialog" aria-label="Quick Product View">
        <button type="button" class="dt-modal-close" onclick="closeQuickView()" aria-label="Close">✕</button>

        <div class="dt-qv-grid" id="dtQvContent">
            <!-- Left: Gallery (photos + video, filled from product_media) -->
            <div class="dt-qv-gallery">
                <div class="dt-qv-main-img-wrap">
                    <img src="/assets/images/no-image.svg" alt="" id="dtQvMainImg" class="dt-qv-main-img" />
                    <video id="dtQvMainVideo" class="dt-qv-main-img" style="display:none;" controls preload="metadata" playsinline></video>
                    <iframe id="dtQvMainEmbed" class="dt-qv-main-img" style="display:none;border:0;" title="Product video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                    <span class="dt-qv-badge" id="dtQvBadge" style="display:none;"></span>
                </div>
                <div class="dt-qv-thumbs" id="dtQvThumbs"></div>
            </div>

            <!-- Right: Details & Order Stepper -->
            <div class="dt-qv-details">
                <span class="dt-qv-cat" id="dtQvCategory" style="display:none;"></span>
                <h3 class="dt-qv-title" id="dtQvTitle"></h3>
                <div class="dt-qv-sku-row">
                    <span id="dtQvSkuWrap" style="display:none;">SKU: <strong id="dtQvSku"></strong></span>
                    <span id="dtQvSkuDot" style="display:none;">&bull;</span>
                    <span class="dt-qv-rating" id="dtQvRatingWrap" style="display:none;">★ <span id="dtQvRating"></span> (<span id="dtQvReviews">0</span> reviews)</span>
                    <span class="dt-qv-rating" id="dtQvNoReviews" style="display:none;opacity:.7;">No reviews yet</span>
                </div>

                <!-- Price Row -->
                <div class="dt-qv-price-row">
                    <span class="dt-qv-price" id="dtQvPrice"></span>
                    <span class="dt-qv-old-price" id="dtQvOldPrice" style="display:none;"></span>
                    <span class="dt-qv-discount" id="dtQvDiscount" style="display:none;"></span>
                </div>

                <!-- Fabric / weave / occasion, only what the row actually holds -->
                <div class="dt-qv-spec-row" id="dtQvSpecs" style="display:none;font-size:.78rem;color:#7A7266;margin:2px 0 6px;"></div>

                <!-- Colours from product_variants -->
                <div class="dt-qv-lot-tier" id="dtQvColorsWrap" style="display:none;">
                    <span class="dt-qv-option-label">Colours:</span>
                    <div id="dtQvColors" style="display:flex;gap:6px;flex-wrap:wrap;"></div>
                </div>

                <!-- Sizes from product_variants -->
                <div class="dt-qv-lot-tier" id="dtQvSizesWrap" style="display:none;">
                    <span class="dt-qv-option-label">Sizes:</span>
                    <div id="dtQvSizes" style="display:flex;gap:6px;flex-wrap:wrap;"></div>
                </div>

                <!-- Lot Selection Tier (chips built from this product's MOQ tiers) -->
                <div class="dt-qv-lot-tier" id="dtQvLotWrap" style="display:none;">
                    <span class="dt-qv-option-label">Select Lot / Order Type:</span>
                    <div class="dt-qv-lots-grid" id="dtQvLots"></div>
                </div>

                <!-- Stock -->
                <div class="dt-qv-stock-row" id="dtQvStock" style="font-size:.78rem;font-weight:700;margin:4px 0;"></div>

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
                    <a href="#" id="dtQvFullPageLink" class="dt-btn-pale">Full Details &rarr;</a>
                </div>
            </div>
        </div>

    </div>
</div>
