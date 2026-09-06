<?php
/**
 * product-card.php — Grid View Product Card
 */
?>
<div class="adm-card dt-prod-grid-card">
    <div style="position:relative;">
        <img src="/Shared/Asset/images/product1.png" onerror="this.src='/assets/images/product1.png';" style="width:100%; height:180px; object-fit:cover; border-radius:8px 8px 0 0;">
        <span class="adm-badge success" style="position:absolute; top:8px; left:8px;">In Stock (45)</span>
        <span class="adm-badge gold" style="position:absolute; top:8px; right:8px; display:inline-flex; align-items:center; gap:3px;">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="#8A681F" stroke="#8A681F" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            <span>5.0</span>
        </span>
    </div>
    <div style="padding:14px;">
        <div style="font-size:0.72rem; color:#8A681F; font-weight:700;">DT Signature • Silk Sarees</div>
        <h4 style="font-size:0.92rem; font-weight:800; color:#181512; margin:4px 0;">Kanjivaram Pure Silk Gold Zari Saree</h4>
        <div style="font-size:0.75rem; color:#7A7266; margin-bottom:8px;">SKU: KLN-SR-111</div>
        <div style="display:flex; justify-content:space-between; align-items:baseline; margin-bottom:12px;">
            <div><strong style="font-size:1.1rem; color:#181512;">₹4,490</strong> <small style="color:#7A7266;">Retail</small></div>
            <div style="color:#8A681F; font-weight:700; font-size:0.85rem;">₹2,850 <small>Wholesale</small></div>
        </div>
        <div style="display:flex; gap:6px;">
            <a href="/admin/products/view.php?id=101" class="dt-btn dt-btn-pale adm-btn-sm" style="flex:1; justify-content:center;">View</a>
            <a href="/admin/products/edit.php?id=101" class="dt-btn dt-btn-gold adm-btn-sm" style="flex:1; justify-content:center;">Edit</a>
        </div>
    </div>
</div>
