<?php
/**
 * DT Brand/shared/reels_modal.php — Instagram-Style Video Reels Feed & Product Buy Modal
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ════════════ INSTAGRAM REELS VIDEO FEED MODAL ════════════ -->
<div class="dt-reels-modal-overlay" id="dtReelsModalOverlay" aria-hidden="true">
    <div class="dt-reels-container" id="dtReelsContainer">
        <!-- Close Button -->
        <button type="button" class="dt-reels-close-btn" onclick="closeReelsModal()" aria-label="Close Reels">✕</button>

        <!-- Video Reel Card -->
        <div class="dt-reel-card" id="dtCurrentReelCard">
            <!-- Simulated HD Video Background / Animation -->
            <div class="dt-reel-media-wrap">
                <img src="/Frontend/Shop/Asset/images/product1.png" alt="Reel Video" id="dtReelPoster" class="dt-reel-poster" />
                <div class="dt-reel-video-overlay"></div>
                <div class="dt-reel-badge">🎥 Live Mill Weaving</div>
            </div>

            <!-- Right Vertical Action Strip -->
            <div class="dt-reel-actions-side">
                <button type="button" class="dt-reel-action-btn" id="dtReelLikeBtn" onclick="toggleReelLike()">
                    <span class="dt-action-icon">❤️</span>
                    <span class="dt-action-count" id="dtReelLikesCount">2.4k</span>
                </button>
                <button type="button" class="dt-reel-action-btn" onclick="shareCurrentReel()">
                    <span class="dt-action-icon">↗</span>
                    <span class="dt-action-count">Share</span>
                </button>
                <button type="button" class="dt-reel-action-btn" onclick="openQuickView(1)">
                    <span class="dt-action-icon">🛍️</span>
                    <span class="dt-action-count">Buy</span>
                </button>
            </div>

            <!-- Bottom Floating Product Buy Card -->
            <div class="dt-reel-product-floating-card" id="dtReelProductCard">
                <div class="dt-reel-prod-info">
                    <h4 class="dt-reel-prod-title" id="dtReelProdTitle">Nilambari Handloom Silk Saree</h4>
                    <div class="dt-reel-prod-pricing">
                        <span class="dt-reel-price" id="dtReelProdPrice">₹4,899</span>
                        <span class="dt-reel-mrp" id="dtReelProdMrp">₹6,500</span>
                    </div>
                </div>
                <button type="button" class="dt-btn-gold dt-reel-buy-btn" onclick="addCurrentReelToCart()">
                    <span>Add to Bag</span>
                </button>
            </div>

            <!-- Next / Prev Controls -->
            <button type="button" class="dt-reel-nav-arrow up" onclick="navigateReel(-1)" aria-label="Previous Reel">▲</button>
            <button type="button" class="dt-reel-nav-arrow down" onclick="navigateReel(1)" aria-label="Next Reel">▼</button>
        </div>

    </div>
</div>
