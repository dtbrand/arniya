<?php
/**
 * DT Brand/shared/wishlist_drawer.php — Universal Saved Items Wishlist Drawer
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ════════════ WISHLIST DRAWER MODAL ════════════ -->
<div class="dt-drawer-overlay" id="dtWishlistDrawerOverlay" aria-hidden="true">
    <div class="dt-drawer dt-wishlist-drawer" id="dtWishlistDrawer" role="dialog" aria-label="Saved Wishlist">
        
        <!-- Header -->
        <div class="dt-drawer-header">
            <div class="dt-drawer-title-wrap">
                <svg viewBox="0 0 24 24" class="dt-drawer-title-svg"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                <h3 class="dt-drawer-title">Saved Wishlist (<span id="dtWishlistDrawerCount">0</span>)</h3>
            </div>
            <button type="button" class="dt-drawer-close" onclick="closeWishlistDrawer()" aria-label="Close Wishlist">✕</button>
        </div>

        <!-- Body / Items List -->
        <div class="dt-drawer-body" id="dtWishlistItemsList">
            <!-- Dynamically populated from JS -->
            <div class="dt-empty-state" id="dtWishlistEmptyState">
                <div class="dt-empty-icon">♡</div>
                <h4 class="dt-empty-title">Your Wishlist is Empty</h4>
                <p class="dt-empty-desc">Save your favorite handcrafted sarees and designs to view them anytime.</p>
                <a href="/shop.php" class="dt-btn-gold" onclick="closeWishlistDrawer()">Explore Catalog &rarr;</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="dt-drawer-footer" id="dtWishlistDrawerFooter" style="display:none;">
            <button type="button" class="dt-btn-gold dt-move-all-btn" onclick="moveAllWishlistToCart()">
                <span>Move All to Bag</span>
                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path></svg>
            </button>
        </div>

    </div>
</div>
