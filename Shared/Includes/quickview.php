<?php
/**
 * quickview.php — PARTIAL INCLUDE
 * Self-Contained Fully Styled & Dynamic Quick View & Product Details Component for DT Brand's
 * Features Interactive Colour Swatches, Size Selection, and Full Garment Specifications
 */
?>
<style>
/* ── Quick View & Product Details Styles ── */
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(24,20,16,0.72);
    backdrop-filter: blur(8px);
    z-index: 15000;
    display: flex; align-items: center; justify-content: center;
    padding: 16px; opacity: 0; visibility: hidden;
    pointer-events: none;
    transition: opacity 0.32s ease, visibility 0.32s ease;
}
.modal-overlay.open { opacity: 1; visibility: visible; pointer-events: auto; }

.quick-modal {
    background: #FFFFFF;
    border-radius: 16px;
    border: 1.5px solid rgba(138,104,31,0.25);
    width: 100%; max-width: 820px; max-height: 90vh;
    position: relative;
    box-shadow: 0 20px 50px rgba(0,0,0,0.28);
    transform: translateY(20px) scale(0.97);
    transition: transform 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.modal-overlay.open .quick-modal { transform: translateY(0) scale(1); }

.modal-handle { display: none; flex-shrink: 0; }
@media (max-width: 767px) {
    .modal-overlay { align-items: flex-end; padding: 0; }
    .quick-modal { border-radius: 20px 20px 0 0; max-height: 88vh; transform: translateY(100%); }
    .modal-handle { display: block; width: 36px; height: 4px; background: var(--soft-platinum, #E5E3DE); border-radius: 2px; margin: 10px auto 0; }
}

.modal-content { 
    padding: 20px 20px 28px; 
    position: relative; 
    overflow-y: auto; 
    flex: 1; 
}
@media (min-width: 768px) {
    .modal-content {
        padding: 30px 32px;
        display: grid;
        grid-template-columns: 310px 1fr;
        gap: 26px;
        align-items: center;
    }
}

.modal-close-btn {
    position: absolute; top: 14px; right: 18px;
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255, 255, 255, 0.95); border: 1.5px solid var(--soft-platinum, #E5E3DE);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); z-index: 100;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.modal-close-btn:hover { background: var(--dark-gold, #8A681F); color: #FFF; border-color: var(--dark-gold, #8A681F); transform: scale(1.05); }
.modal-close-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }

/* ── Quick View Image Slider & Thumbnail Gallery Styles ── */
.modal-image-area-wrap {
    display: flex;
    flex-direction: column;
    gap: 12px;
    width: 100%;
}

.qv-slider-container {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: var(--off-white-2, #F2EFE8);
    aspect-ratio: 3/4;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    user-select: none;
}

.qv-slider-track {
    display: flex;
    width: 100%;
    height: 100%;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
}
.qv-slider-track::-webkit-scrollbar {
    display: none;
}

.qv-slide-img-wrap {
    flex: 0 0 100%;
    width: 100%;
    height: 100%;
    scroll-snap-align: start;
    position: relative;
}
.qv-slide-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
    display: block;
}

/* Navigation Arrows */
.qv-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(138, 104, 31, 0.25);
    color: var(--dark-gold, #8A681F);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 5;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    opacity: 0;
    pointer-events: none;
}
.qv-slider-container:hover .qv-arrow {
    opacity: 1;
    pointer-events: auto;
}
.qv-prev-arrow {
    left: 12px;
}
.qv-next-arrow {
    right: 12px;
}
.qv-arrow:hover {
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
    transform: translateY(-50%) scale(1.08);
    box-shadow: 0 6px 16px rgba(138, 104, 31, 0.35);
}
.qv-arrow svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    stroke-width: 2.5;
    fill: none;
}

/* Mobile Dot Indicators */
.qv-slider-dots {
    position: absolute;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 6px;
    z-index: 5;
    padding: 4px 8px;
    border-radius: 12px;
    background: rgba(0, 0, 0, 0.25);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}
.qv-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.55);
    transition: all 0.25s ease;
    cursor: pointer;
}
.qv-dot.active {
    background: #FFFFFF;
    width: 14px;
    border-radius: 4px;
}

/* Thumbnail Gallery */
.qv-thumbnails-wrap {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
    overflow-x: auto;
    padding: 2px 0;
    scrollbar-width: none;
}
.qv-thumbnails-wrap::-webkit-scrollbar {
    display: none;
}
.qv-thumb {
    width: 52px;
    height: 68px;
    border-radius: 6px;
    overflow: hidden;
    border: 2px solid #E5E3DE;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    background: var(--off-white, #F8F6F0);
    flex-shrink: 0;
    opacity: 0.65;
}
.qv-thumb:hover {
    opacity: 0.9;
    border-color: var(--dark-gold, #8A681F);
}
.qv-thumb.active {
    border-color: var(--dark-gold, #8A681F);
    opacity: 1;
    box-shadow: 0 4px 10px rgba(138, 104, 31, 0.2);
    transform: translateY(-2px);
}
.qv-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.modal-badge-tag {
    position: absolute; top: 12px; left: 12px;
    background: var(--dark-gold, #8A681F); color: #FFF;
    font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.12em; padding: 4px 10px; border-radius: 4px;
    z-index: 4;
}

@media (max-width: 767px) {
    .qv-arrow {
        opacity: 0.85;
        pointer-events: auto;
        width: 32px;
        height: 32px;
    }
    .qv-arrow svg {
        width: 14px;
        height: 14px;
    }
    .qv-prev-arrow { left: 8px; }
    .qv-next-arrow { right: 8px; }
    .qv-thumbnails-wrap {
        gap: 6px;
    }
    .qv-thumb {
        width: 44px;
        height: 58px;
    }
}

.modal-details { display: flex; flex-direction: column; gap: 10px; }
.modal-brand-name { font-size: 0.65rem; font-weight: 700; color: var(--dark-gold, #8A681F); letter-spacing: 0.16em; text-transform: uppercase; }
.modal-name { font-family: var(--font-serif, 'Cinzel', serif); font-size: 1.25rem; font-weight: 700; color: var(--dark-text, #24211C); margin: 0; line-height: 1.3; }

.modal-price-block { display: flex; flex-direction: column; gap: 2px; }
.modal-price-row { display: flex; align-items: baseline; gap: 10px; }
.modal-price { font-size: 1.35rem; font-weight: 800; color: var(--dark-gold, #8A681F); }
.modal-mrp { font-size: 0.78rem; color: var(--light-text, #9A9490); }
.modal-old-price { text-decoration: line-through; }
.modal-discount-tag { font-size: 0.75rem; font-weight: 700; color: #8A681F; margin-left: 4px; }
.modal-tax-note { font-size: 0.68rem; color: var(--light-text, #9A9490); }

/* ── Colour Option Swatches Styles ── */
.modal-color-section { display: flex; flex-direction: column; gap: 8px; margin-top: 4px; }
.modal-color-header { display: flex; align-items: center; justify-content: space-between; font-size: 0.72rem; font-weight: 700; color: var(--dark-text, #24211C); letter-spacing: 0.08em; text-transform: uppercase; }
.qv-color-name-text { color: var(--dark-gold, #8A681F); font-weight: 800; }

.modal-color-swatches { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
.m-color-btn {
    width: 28px; height: 28px; border-radius: 50%;
    border: 2px solid #FFFFFF; outline: 1.5px solid var(--soft-platinum, #E5E3DE);
    cursor: pointer; transition: all 0.2s ease; position: relative;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
.m-color-btn:hover {
    outline-color: var(--dark-gold, #8A681F); transform: scale(1.12);
}
.m-color-btn.active {
    outline: 2.5px solid var(--dark-gold, #8A681F);
    box-shadow: 0 0 0 2px rgba(138,104,31,0.25), 0 3px 8px rgba(0,0,0,0.2);
    transform: scale(1.15);
}
.m-color-btn.active::after {
    content: '';
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    width: 6px; height: 6px; border-radius: 50%;
    background: #FFFFFF;
    box-shadow: 0 0 2px rgba(0,0,0,0.6);
}

/* ── Size Section Styles ── */
.modal-size-section { display: flex; flex-direction: column; gap: 8px; margin-top: 2px; }
.modal-size-header { display: flex; align-items: center; justify-content: space-between; font-size: 0.72rem; font-weight: 700; color: var(--dark-text, #24211C); letter-spacing: 0.08em; }
.modal-product-details-btn { color: var(--dark-gold, #8A681F); cursor: pointer; transition: text-decoration 0.2s; }
.modal-product-details-btn:hover { text-decoration: underline; }

.modal-size-pills { display: flex; gap: 8px; flex-wrap: wrap; }
.m-size-btn {
    min-width: 40px; height: 36px; border-radius: 8px;
    border: 1.5px solid var(--soft-platinum, #E5E3DE); background: var(--off-white, #F8F6F0);
    font-size: 0.75rem; font-weight: 700; color: var(--dark-text, #24211C);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.2s; padding: 0 10px;
}
.m-size-btn:hover { border-color: var(--dark-gold, #8A681F); color: var(--dark-gold, #8A681F); }
.m-size-btn.active { border-color: var(--dark-gold, #8A681F); background: var(--dark-gold, #8A681F); color: #FFFFFF; box-shadow: 0 2px 8px rgba(138,104,31,0.25); }

.modal-actions-myntra { display: flex; flex-direction: column; gap: 8px; margin-top: 8px; }
.modal-actions-btn-row { display: flex; gap: 8px; width: 100%; }

.modal-add-bag-btn {
    flex: 1.2; padding: 11px 14px; border-radius: 9px;
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
    border: 1px solid #8A681F;
    color: #111827;
    font-family: var(--font-sans, 'Inter', sans-serif); font-size: 0.78rem; font-weight: 800;
    letter-spacing: 0.08em; text-transform: uppercase;
    transition: all 0.22s ease; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 3px 10px rgba(184,134,11,0.28);
}
.modal-add-bag-btn:hover {
    background: linear-gradient(135deg, #C59312 0%, #DFC04E 50%, #F0D77B 100%);
    transform: translateY(-1px);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.5), 0 5px 14px rgba(184,134,11,0.4);
}
.modal-add-bag-btn svg { width: 15px; height: 15px; stroke: #111827; fill: none; stroke-width: 2.2; flex-shrink: 0; }

.modal-buy-now-btn {
    flex: 1.2; padding: 11px 14px; border-radius: 9px;
    background: linear-gradient(135deg, #181512 0%, #2A241E 100%);
    border: 1.2px solid #8A681F;
    color: #FAF5E8;
    font-family: var(--font-sans, 'Inter', sans-serif); font-size: 0.78rem; font-weight: 800;
    letter-spacing: 0.08em; text-transform: uppercase;
    transition: all 0.22s ease; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.25);
}
.modal-buy-now-btn:hover {
    border-color: #D4AF37;
    background: linear-gradient(135deg, #241F1A 0%, #383028 100%);
    transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(0,0,0,0.35);
}
.modal-buy-now-btn svg { width: 14px; height: 14px; fill: currentColor; stroke: currentColor; stroke-width: 1; flex-shrink: 0; }

.modal-actions-sub-row { display: flex; gap: 8px; width: 100%; }

.modal-wishlist-btn {
    flex: 1; padding: 9px 12px; border-radius: 8px;
    background: #FAF8F4; color: var(--dark-text, #24211C);
    border: 1px solid var(--soft-platinum, #E5E3DE);
    font-family: var(--font-sans, 'Inter', sans-serif); font-size: 0.72rem; font-weight: 700;
    letter-spacing: 0.06em; text-transform: uppercase;
    transition: all 0.2s; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 5px;
}
.modal-wishlist-btn:hover { border-color: var(--dark-gold, #8A681F); color: var(--dark-gold, #8A681F); background: #FAF3E0; }
.modal-wishlist-btn.active { border-color: #E53935; color: #E53935; background: #FDE8E8; }
.modal-wishlist-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.modal-wishlist-btn.active svg { fill: #E53935; }

.modal-wa-btn {
    flex: 1.2; padding: 9px 12px; border-radius: 8px;
    background: linear-gradient(135deg, #15803D 0%, #16A34A 100%);
    border: 1px solid #166534;
    color: #FFFFFF;
    font-family: var(--font-sans, 'Inter', sans-serif); font-size: 0.72rem; font-weight: 700;
    letter-spacing: 0.06em; text-transform: uppercase;
    transition: all 0.2s; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 5px;
    text-decoration: none;
}
.modal-wa-btn:hover {
    background: linear-gradient(135deg, #166534 0%, #15803D 100%);
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(22,163,74,0.3);
}
.modal-wa-btn svg { width: 14px; height: 14px; fill: #FFFFFF; flex-shrink: 0; }

.modal-perks { display: flex; flex-direction: column; gap: 6px; margin-top: 4px; padding-top: 8px; border-top: 1px dashed var(--soft-platinum, #E5E3DE); }
.m-perk-item { display: flex; align-items: center; gap: 8px; font-size: 0.72rem; color: var(--mid-text, #5A5348); font-weight: 500; }
.m-perk-item svg { width: 14px; height: 14px; stroke: var(--dark-gold, #8A681F); fill: none; stroke-width: 2; flex-shrink: 0; }

/* ── Product Details Full Specs Backdrop & Content ── */
.product-details-backdrop {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(24, 20, 16, 0.78); backdrop-filter: blur(10px);
    display: flex; align-items: center; justify-content: center;
    z-index: 16000; opacity: 0; visibility: hidden;
    pointer-events: none;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); padding: 16px;
}
.product-details-backdrop.active { opacity: 1; visibility: visible; pointer-events: auto; }

.product-details-content {
    background: linear-gradient(180deg, #FFFFFF 0%, #FAF6EE 100%); width: 100%; max-width: 560px;
    border-radius: 16px; border: 1.5px solid rgba(138,104,31,0.35);
    border-top: 4px solid var(--dark-gold, #8A681F);
    box-shadow: 0 24px 48px rgba(0,0,0,0.3); overflow: hidden;
    transform: translateY(24px) scale(0.96); transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.product-details-backdrop.active .product-details-content { transform: translateY(0) scale(1); }

.pd-header { display: flex; align-items: center; justify-content: space-between; padding: 18px 22px; border-bottom: 2px solid var(--dark-gold, #8A681F); background: #FFFFFF; }
.pd-title { font-family: var(--font-serif, 'Cinzel', serif); font-size: 1.25rem; color: var(--dark-gold, #8A681F); font-weight: 700; margin: 0; }
.pd-subtitle { font-size: 0.68rem; color: var(--mid-text, #5A5348); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; display: block; margin-top: 2px; }
.pd-close-btn { background: none; border: none; font-size: 1.6rem; color: var(--dark-gold, #8A681F); cursor: pointer; transition: all 0.25s; line-height: 1; }
.pd-close-btn:hover { color: var(--dark-text, #24211C); transform: rotate(90deg); }

.pd-body { padding: 20px 22px; display: flex; flex-direction: column; gap: 14px; max-height: 75vh; overflow-y: auto; }
.pd-hero-box { display: flex; gap: 16px; background: #FFFFFF; padding: 16px; border-radius: 12px; border: 1px solid rgba(138,104,31,0.25); border-left: 3px solid var(--dark-gold, #8A681F); align-items: center; box-shadow: 0 4px 12px rgba(138,104,31,0.06); }
.pd-hero-img { width: 92px; height: 118px; object-fit: cover; border-radius: 8px; border: 1.5px solid rgba(138,104,31,0.25); flex-shrink: 0; }
.pd-hero-info { display: flex; flex-direction: column; gap: 7px; flex: 1; }

.pd-price-row { display: flex; align-items: baseline; gap: 10px; flex-wrap: wrap; }
.pd-price { font-size: 1.4rem; font-weight: 800; color: var(--dark-gold, #8A681F); }
.pd-old-price { font-size: 0.82rem; color: var(--light-text, #9A9490); text-decoration: line-through; }
.pd-tag { font-size: 0.68rem; font-weight: 700; color: #8A681F; background: #FAF3E0; padding: 3px 10px; border-radius: 12px; border: 1px solid rgba(138,104,31,0.35); }

.pd-meta-row { display: flex; align-items: center; gap: 8px; font-size: 0.72rem; flex-wrap: wrap; }
.pd-meta-label { font-weight: 700; color: var(--dark-gold, #8A681F); text-transform: uppercase; font-size: 0.65rem; letter-spacing: 0.08em; }
.pd-size-pills { display: flex; gap: 5px; flex-wrap: wrap; }
.pd-size-pill { font-size: 0.65rem; font-weight: 700; background: #FAF3E0; color: var(--dark-gold, #8A681F); padding: 3px 10px; border-radius: 12px; border: 1px solid rgba(138,104,31,0.3); }
.pd-color-badge { display: flex; align-items: center; gap: 6px; font-weight: 700; color: var(--dark-text, #24211C); }
.pd-color-dot { width: 11px; height: 11px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.25); display: inline-block; box-shadow: 0 0 4px rgba(0,0,0,0.2); }

.pd-desc-box { background: #FFFFFF; padding: 16px; border-radius: 12px; border: 1px solid rgba(138,104,31,0.25); border-left: 3px solid var(--dark-gold, #8A681F); }
.pd-section-title { font-size: 0.8rem; font-weight: 700; color: var(--dark-gold, #8A681F); text-transform: uppercase; letter-spacing: 0.1em; margin: 0 0 8px; border-bottom: 1.5px solid rgba(138,104,31,0.2); padding-bottom: 5px; }
.pd-full-desc { font-size: 0.8rem; color: var(--dark-text, #24211C); margin: 0; line-height: 1.65; }

.pd-specs-section { background: #FFFFFF; padding: 16px; border-radius: 12px; border: 1px solid rgba(138,104,31,0.25); border-left: 3px solid var(--dark-gold, #8A681F); }
.pd-specs-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.pd-spec-item { display: flex; flex-direction: column; gap: 2px; }
.pd-spec-label { font-size: 0.65rem; color: var(--dark-gold, #8A681F); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
.pd-spec-val { font-size: 0.8rem; color: var(--dark-text, #24211C); font-weight: 600; }
.pd-assurance-box { display: flex; flex-direction: column; gap: 9px; background: rgba(138,104,31,0.06); border: 1.5px solid rgba(138,104,31,0.25); border-radius: 12px; padding: 14px 16px; }
.pd-assure-item { display: flex; align-items: center; gap: 10px; font-size: 0.75rem; color: var(--dark-text, #24211C); font-weight: 700; }
.pd-assure-item svg { width: 15px; height: 15px; stroke: var(--dark-gold, #8A681F); fill: none; stroke-width: 2; flex-shrink: 0; }
</style>

<!-- ════════════ QUICK VIEW MODAL OVERLAY ════════════ -->
<div class="modal-overlay" id="quickViewOverlay" role="dialog" aria-modal="true" aria-label="Quick view" aria-hidden="true">
    <div class="quick-modal" id="quickModal">
        <div class="modal-handle" aria-hidden="true"></div>
        <button class="modal-close-btn" id="qvClose" aria-label="Close modal">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <div class="modal-content" id="quickModalContent" style="position:relative;"></div>
    </div>
</div>

<!-- ════════════ PRODUCT DETAILS MODAL POPUP ════════════ -->
<div class="product-details-backdrop" id="productDetailsModal" aria-hidden="true" role="dialog" aria-label="Product Details Modal">
    <div class="product-details-content">
        <div class="pd-header">
            <div class="pd-title-wrap">
                <h3 class="pd-title" id="pdTitle">Product Details</h3>
                <span class="pd-subtitle" id="pdCategory">Ethnic Wear Collection</span>
            </div>
            <button class="pd-close-btn" id="closeProductDetailsBtn" aria-label="Close Product Details">&times;</button>
        </div>

        <div class="pd-body">
            <!-- Hero Box -->
            <div class="pd-hero-box">
                <img id="pdImg" src="" alt="Product Image" class="pd-hero-img" />
                <div class="pd-hero-info">
                    <div class="pd-price-row">
                        <span class="pd-price" id="pdPrice">₹0</span>
                        <span class="pd-old-price" id="pdOldPrice"></span>
                        <span class="pd-tag" id="pdDiscountVal">Best Price</span>
                    </div>

                    <div class="pd-meta-row">
                        <span class="pd-meta-label">Available Sizes:</span>
                        <div class="pd-size-pills" id="pdSizesWrap">
                            <span class="pd-size-pill">Free Size</span>
                        </div>
                    </div>

                    <div class="pd-meta-row">
                        <span class="pd-meta-label">Available Colours:</span>
                        <div class="pd-size-pills" id="pdColorsWrap">
                            <span class="pd-size-pill">Maroon</span>
                        </div>
                    </div>

                    <div class="pd-meta-row">
                        <span class="pd-meta-label">Fabric:</span>
                        <span id="pdFabricVal" style="font-weight:700; color:var(--dark-text);">Pure Silk</span>
                    </div>
                </div>
            </div>

            <!-- Full Product Description -->
            <div class="pd-desc-box">
                <h4 class="pd-section-title">✨ Full Product Description</h4>
                <p class="pd-full-desc" id="pdFullDesc">
                    Handcrafted luxury ethnic wear from DT Brand's Heritage Collection. Features premium fabric draping, authentic hand-finished weave, and timeless royal elegance.
                </p>
            </div>

            <!-- Garment Specifications Grid -->
            <div class="pd-specs-section">
                <h4 class="pd-section-title">Garment Specifications</h4>
                <div class="pd-specs-grid">
                    <div class="pd-spec-item">
                        <span class="pd-spec-label">Fabric</span>
                        <span class="pd-spec-val" id="pdSpecFabric">Pure Silk</span>
                    </div>
                    <div class="pd-spec-item">
                        <span class="pd-spec-label">Available Colours</span>
                        <span class="pd-spec-val" id="pdSpecColor">Maroon</span>
                    </div>
                    <div class="pd-spec-item">
                        <span class="pd-spec-label">Category</span>
                        <span class="pd-spec-val" id="pdSpecCategory">Sarees</span>
                    </div>
                    <div class="pd-spec-item">
                        <span class="pd-spec-label">Stock Status</span>
                        <span class="pd-spec-val" id="pdStockVal">In Stock</span>
                    </div>
                    <div class="pd-spec-item">
                        <span class="pd-spec-label">Care Instructions</span>
                        <span class="pd-spec-val">Dry Clean Only</span>
                    </div>
                    <div class="pd-spec-item">
                        <span class="pd-spec-label">Delivery</span>
                        <span class="pd-spec-val">⚡ Fast Express Delivery Across India</span>
                    </div>
                </div>
            </div>

            <!-- Assurance Perks -->
            <div class="pd-assurance-box">
                <div class="pd-assure-item">
                    <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span>✨ 100% Original Product</span>
                </div>
                <div class="pd-assure-item">
                    <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    <span>⚡ Fast Express Delivery & 7-Day Fast Exchange</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/* ── Quick View Controller & State Engine with Colour Option Swatches ── */
(function() {
    var colorHexMap = {
        'Navy': '#1B2A4A',
        'Royal Blue': '#204B8C',
        'Midnight Black': '#1A1A1A',
        'Maroon': '#6D1A24',
        'Deep Wine': '#4A1521',
        'Ruby Red': '#9E1B32',
        'Yellow': '#E5A93B',
        'Golden Ochre': '#C68B29',
        'Emerald Green': '#1E5E3A',
        'Pink': '#E88B9E',
        'Blush Peach': '#F4B2A0',
        'Rose': '#D46A84',
        'Green': '#2D6A4F',
        'Teal': '#1D6870',
        'Mint': '#74B39B',
        'Red': '#B22222',
        'Crimson': '#DC143C',
        'Orange': '#D96B27',
        'Mustard': '#C88A24',
        'Rust Gold': '#A85A1D',
        'White': '#FAF8F5',
        'Ivory': '#FFFFF0',
        'Pearl Cream': '#EFEBD9'
    };

    // Helper to generate photo variations for catalog items
    function getProductImages(p) {
        if (p.gallery && Array.isArray(p.gallery) && p.gallery.length > 0) {
            return p.gallery;
        }
        var baseImg = p.image || '/Frontend/Shop/Asset/images/product1.png';
        var list = [baseImg];
        var pid = parseInt(String(p.id).replace(/[^0-9]/g, ''), 10) || 1;
        var p1 = ((pid) % 8) + 1;
        var p2 = ((pid + 1) % 8) + 1;
        var p3 = ((pid + 2) % 8) + 1;
        list.push('/Frontend/Shop/Asset/images/product' + p1 + '.png');
        list.push('/Frontend/Shop/Asset/images/product' + p2 + '.png');
        list.push('/Frontend/Shop/Asset/images/product' + p3 + '.png');
        return Array.from(new Set(list));
    }

    window.qvSliderInterval = null;

        window.openQV = function(id) {
        var overlay = document.getElementById('quickViewOverlay');
        var content = document.getElementById('quickModalContent');
        if (!overlay || !content) return;

        var products = window.allProducts || window.catalogProducts || window.products || window.shopProductsData || [];
        var p = null;
        if (typeof id === 'object' && id !== null) {
            p = id;
        } else {
            p = products.find(function(x) { 
                return x && (x.id == id || String(x.id) === String(id) || String(x.sku) === String(id) || (x.name && x.name == id)); 
            });
        }
        if (!p) {
            // Fallback product if not in array
            p = {
                id: id,
                name: "DT Brand's Ethnic Saree",
                price: 4999,
                old_price: 6999,
                image: '/Shared/Asset/images/product1.png',
                category: 'Sarees',
                fabric: 'Pure Silk',
                color: 'Gold'
            };
        }

        window.currentQVProduct = p;

        /* Sizes list */
        var sizeArr = Array.isArray(p.size) ? p.size : ['Free Size'];
        var sizeBtnsHtml = sizeArr.map(function(s, idx) {
            return '<button class="m-size-btn ' + (idx === 0 ? 'active' : '') + '" data-sz="' + s + '">' + s + '</button>';
        }).join('');

        /* Colours list */
        var colorArr = Array.isArray(p.colors) ? p.colors : (p.color ? [p.color] : ['Standard']);
        var defaultColor = colorArr[0];

        var colorSwatchesHtml = colorArr.map(function(c, idx) {
            var hex = colorHexMap[c] || '#8A681F';
            return '<button class="m-color-btn ' + (idx === 0 ? 'active' : '') + '" data-color="' + c + '" style="background-color: ' + hex + ';" title="' + c + '" aria-label="' + c + '"></button>';
        }).join('');

        var isWish = false;
        if (Array.isArray(window.wishlistState)) {
            isWish = window.wishlistState.some(function(item) { return item.id == p.id; });
        }

        // Get multiple photos for this product
        var imagesList = getProductImages(p);
        var maxSlides = imagesList.length;
        var currentSlideIndex = 0;

        // Build Slider HTML
        var slidesHtml = '';
        var dotsHtml = '';
        var thumbsHtml = '';

        imagesList.forEach(function(imgUrl, idx) {
            slidesHtml += 
                '<div class="qv-slide-img-wrap">' +
                    '<img class="qv-slide-img" src="' + imgUrl + '" alt="' + p.name + ' - View ' + (idx+1) + '" />' +
                '</div>';
            dotsHtml += '<div class="qv-dot ' + (idx === 0 ? 'active' : '') + '" data-idx="' + idx + '"></div>';
            thumbsHtml += 
                '<div class="qv-thumb ' + (idx === 0 ? 'active' : '') + '" data-idx="' + idx + '">' +
                    '<img src="' + imgUrl + '" alt="Thumb ' + (idx+1) + '" />' +
                '</div>';
        });

        content.innerHTML =
            // Left Column: Interactive Slider + Thumbnails
            '<div class="modal-image-area-wrap">' +
                '<div class="qv-slider-container" id="qvSliderContainer">' +
                    (p.badge ? '<span class="modal-badge-tag">' + p.badge + '</span>' : '') +
                    '<div class="qv-slider-track" id="qvSliderTrack">' +
                        slidesHtml +
                    '</div>' +
                    '<button class="qv-arrow qv-prev-arrow" id="qvPrevArrow" aria-label="Previous image"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg></button>' +
                    '<button class="qv-arrow qv-next-arrow" id="qvNextArrow" aria-label="Next image"><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg></button>' +
                    '<div class="qv-slider-dots" id="qvSliderDots">' + dotsHtml + '</div>' +
                '</div>' +
                '<div class="qv-thumbnails-wrap" id="qvThumbnailsWrap">' +
                    thumbsHtml +
                '</div>' +
            '</div>' +

            // Right Column: Details & Actions
            '<div class="modal-details">' +
                '<div class="modal-brand-name">DT BRAND\'S ETHNIC LUXURY</div>' +
                '<h2 class="modal-name">' + p.name + '</h2>' +

                '<div class="modal-price-block">' +
                    '<div class="modal-price-row">' +
                        '<span class="modal-price">₹' + Number(p.price).toLocaleString('en-IN') + '</span>' +
                        (p.old_price ? '<span class="modal-mrp">MRP <span class="modal-old-price">₹' + Number(p.old_price).toLocaleString('en-IN') + '</span></span>' : '') +
                        (p.discount ? '<span class="modal-discount-tag">(' + p.discount + '% OFF)</span>' : '') +
                    '</div>' +
                    '<span class="modal-tax-note">Exclusive of all taxes</span>' +
                '</div>' +

                '<!-- Colour Option Swatches -->' +
                '<div class="modal-color-section">' +
                    '<div class="modal-color-header">' +
                        '<span>SELECT COLOUR: <strong id="qvSelectedColorName" class="qv-color-name-text">' + defaultColor + '</strong></span>' +
                    '</div>' +
                    '<div class="modal-color-swatches" id="qvColorWrap">' +
                        colorSwatchesHtml +
                    '</div>' +
                '</div>' +

                '<!-- Size Selection -->' +
                '<div class="modal-size-section">' +
                    '<div class="modal-size-header">' +
                        '<span>SELECT SIZE</span>' +
                        '<span class="modal-product-details-btn" id="qvPdBtn">PRODUCT DETAILS ›</span>' +
                    '</div>' +
                    '<div class="modal-size-pills" id="qvSizeWrap">' +
                        sizeBtnsHtml +
                    '</div>' +
                '</div>' +

                '<div class="modal-actions-myntra">' +
                    '<div class="modal-actions-btn-row">' +
                        '<button class="modal-add-bag-btn" id="qvAtc">' +
                            '<svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>' +
                            '<span>ADD TO BAG</span>' +
                        '</button>' +
                        '<button class="modal-buy-now-btn" id="qvBuyNow">' +
                            '<svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>' +
                            '<span>BUY NOW</span>' +
                        '</button>' +
                    '</div>' +
                    '<div class="modal-actions-sub-row">' +
                        '<button class="modal-wishlist-btn ' + (isWish ? 'active' : '') + '" id="qvWishlist">' +
                            '<svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>' +
                            '<span>WISHLIST</span>' +
                        '</button>' +
                        '<a href="https://api.whatsapp.com/send?phone=919876543210&text=' + encodeURIComponent('Hi DT Brand, I am interested in ' + (p.name || 'this product') + ' (₹' + (p.price || 0) + '). Please share details.') + '" target="_blank" class="modal-wa-btn" id="qvWaBtn">' +
                            '<svg viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>' +
                            '<span>WHATSAPP</span>' +
                        '</a>' +
                    '</div>' +
                '</div>' +

                '<div class="modal-perks">' +
                    '<div class="m-perk-item">' +
                        '<svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>' +
                        '<span>100% Original Authentic Product</span>' +
                    '</div>' +
                    '<div class="m-perk-item">' +
                        '<svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>' +
                        '<span>⚡ Fast Express Delivery & Fast Exchange</span>' +
                    '</div>' +
                '</div>' +
            '</div>';

        overlay.classList.add('open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        // Slider Elements Binding
        var sliderContainer = document.getElementById('qvSliderContainer');
        var sliderTrack = document.getElementById('qvSliderTrack');
        var dotsWrap = document.getElementById('qvSliderDots');
        var thumbsWrap = document.getElementById('qvThumbnailsWrap');
        var prevBtn = document.getElementById('qvPrevArrow');
        var nextBtn = document.getElementById('qvNextArrow');

        function gotoSlide(idx) {
            if (idx < 0) idx = maxSlides - 1;
            if (idx >= maxSlides) idx = 0;
            currentSlideIndex = idx;

            var targetImgWrap = sliderTrack.children[currentSlideIndex];
            if (targetImgWrap) {
                sliderTrack.scrollTo({
                    left: targetImgWrap.offsetLeft,
                    behavior: 'smooth'
                });
            }

            // Sync dots
            if (dotsWrap) {
                Array.from(dotsWrap.children).forEach(function(dot, i) {
                    dot.classList.toggle('active', i === currentSlideIndex);
                });
            }

            // Sync thumbs
            if (thumbsWrap) {
                Array.from(thumbsWrap.children).forEach(function(thumb, i) {
                    thumb.classList.toggle('active', i === currentSlideIndex);
                });
            }
        }

        // Swipe Scroll Sync
        sliderTrack.addEventListener('scroll', function() {
            var w = sliderTrack.clientWidth;
            if (w > 0) {
                var idx = Math.round(sliderTrack.scrollLeft / w);
                if (idx !== currentSlideIndex && idx >= 0 && idx < maxSlides) {
                    currentSlideIndex = idx;
                    // Sync active dot
                    if (dotsWrap) {
                        Array.from(dotsWrap.children).forEach(function(dot, i) {
                            dot.classList.toggle('active', i === currentSlideIndex);
                        });
                    }
                    // Sync active thumb
                    if (thumbsWrap) {
                        Array.from(thumbsWrap.children).forEach(function(thumb, i) {
                            thumb.classList.toggle('active', i === currentSlideIndex);
                        });
                    }
                }
            }
        });

        // Arrow navigation clicks
        if (prevBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                gotoSlide(currentSlideIndex - 1);
                restartAutoSlide();
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                gotoSlide(currentSlideIndex + 1);
                restartAutoSlide();
            });
        }

        // Dot navigation clicks
        if (dotsWrap) {
            dotsWrap.querySelectorAll('.qv-dot').forEach(function(dot) {
                dot.addEventListener('click', function(e) {
                    e.stopPropagation();
                    gotoSlide(parseInt(dot.dataset.idx));
                    restartAutoSlide();
                });
            });
        }

        // Thumbnail clicks
        if (thumbsWrap) {
            thumbsWrap.querySelectorAll('.qv-thumb').forEach(function(thumb) {
                thumb.addEventListener('click', function(e) {
                    e.stopPropagation();
                    gotoSlide(parseInt(thumb.dataset.idx));
                    restartAutoSlide();
                });
            });
        }

        // Auto sliding timer functions
        function startAutoSlide() {
            stopAutoSlide();
            window.qvSliderInterval = setInterval(function() {
                gotoSlide(currentSlideIndex + 1);
            }, 3800);
        }
        function stopAutoSlide() {
            if (window.qvSliderInterval) {
                clearInterval(window.qvSliderInterval);
                window.qvSliderInterval = null;
            }
        }
        function restartAutoSlide() {
            stopAutoSlide();
            startAutoSlide();
        }

        // Hover triggers play/pause
        if (sliderContainer) {
            sliderContainer.addEventListener('mouseenter', stopAutoSlide);
            sliderContainer.addEventListener('mouseleave', startAutoSlide);
        }

        // Start auto slide
        startAutoSlide();

        /* Colour Swatches Binding */
        content.querySelectorAll('.m-color-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                content.querySelectorAll('.m-color-btn').forEach(function(b) { b.classList.remove('active'); });
                btn.classList.add('active');
                var colorNameEl = document.getElementById('qvSelectedColorName');
                if (colorNameEl) colorNameEl.textContent = btn.dataset.color;
            });
        });

        /* Size Pill binding */
        content.querySelectorAll('.m-size-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                content.querySelectorAll('.m-size-btn').forEach(function(b) { b.classList.remove('active'); });
                btn.classList.add('active');
            });
        });

        /* Close Quick View */
        var qvClose = document.getElementById('qvClose');
        if (qvClose) qvClose.addEventListener('click', window.closeQV);

        /* Add To Bag with selected size and color */
        var qvAtc = document.getElementById('qvAtc');
        if (qvAtc) {
            qvAtc.addEventListener('click', function() {
                var activeSizeBtn = content.querySelector('.m-size-btn.active');
                var selSize = activeSizeBtn ? activeSizeBtn.dataset.sz : 'Free Size';

                var activeColorBtn = content.querySelector('.m-color-btn.active');
                var selColor = activeColorBtn ? activeColorBtn.dataset.color : (p.color || 'Standard');

                if (typeof window.addToCart === 'function') {
                    window.addToCart(p, selSize, selColor, 1);
                }
                window.closeQV();
            });
        }

        /* Buy Now (Instant Direct Checkout) */
        var qvBuyNow = document.getElementById('qvBuyNow');
        if (qvBuyNow) {
            qvBuyNow.addEventListener('click', function() {
                var activeSizeBtn = content.querySelector('.m-size-btn.active');
                var selSize = activeSizeBtn ? activeSizeBtn.dataset.sz : 'Free Size';

                var activeColorBtn = content.querySelector('.m-color-btn.active');
                var selColor = activeColorBtn ? activeColorBtn.dataset.color : (p.color || 'Standard');

                if (typeof window.addToCart === 'function') {
                    window.addToCart(p, selSize, selColor, 1);
                }
                window.closeQV();
                setTimeout(function() {
                    if (typeof window.openCheckout === 'function') {
                        window.openCheckout();
                    } else if (typeof window.openCheckoutModal === 'function') {
                        window.openCheckoutModal();
                    } else {
                        window.location.href = '/checkout';
                    }
                }, 80);
            });
        }

        /* Wishlist Toggle */
        var qvWish = document.getElementById('qvWishlist');
        if (qvWish) {
            qvWish.addEventListener('click', function() {
                if (typeof window.toggleWishlistProduct === 'function') {
                    var added = window.toggleWishlistProduct(p);
                    qvWish.classList.toggle('active', added);
                    if (typeof window.showToast === 'function') {
                        window.showToast(added ? '♡ Saved to wishlist' : 'Removed from wishlist');
                    }
                }
            });
        }

        /* Product Details Full Spec Modal trigger */
        var qvPdBtn = document.getElementById('qvPdBtn');
        if (qvPdBtn) {
            qvPdBtn.addEventListener('click', function() {
                window.closeQV();
                window.openProductDetails(p.id);
            });
        }
    };

    window.openQuickView = window.openQV;
    window.openQuickViewModal = window.openQV;

    window.closeQV = function() {
        var overlay = document.getElementById('quickViewOverlay');
        if (overlay) {
            overlay.classList.remove('open');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
        if (window.qvSliderInterval) {
            clearInterval(window.qvSliderInterval);
            window.qvSliderInterval = null;
        }
    };
    window.closeQuickView = window.closeQV;
    window.closeQuickViewModal = window.closeQV;

    /* Full Product Details Modal Controller */
    window.openProductDetails = function(id) {
        var modal = document.getElementById('productDetailsModal');
        if (!modal) return;

        var products = window.allProducts || window.catalogProducts || window.products || [];
        var p = products.find(function(x) { return x.id == id || String(x.id) === String(id) || String(x.sku) === String(id); });
        if (!p && typeof id === 'object' && id !== null) p = id;
        if (!p) return;

        document.getElementById('pdTitle').textContent = p.name;
        document.getElementById('pdCategory').textContent = (p.category || 'Ethnic Wear') + ' &bull; DT Brand\'s Luxury';
        document.getElementById('pdImg').src = p.image || '/Shared/Asset/images/product1.png';
        document.getElementById('pdPrice').textContent = '₹' + Number(p.price).toLocaleString('en-IN');
        
        var oldPriceEl = document.getElementById('pdOldPrice');
        if (p.old_price) {
            oldPriceEl.textContent = '₹' + Number(p.old_price).toLocaleString('en-IN');
            oldPriceEl.style.display = 'inline';
        } else {
            oldPriceEl.style.display = 'none';
        }

        var discountEl = document.getElementById('pdDiscountVal');
        if (p.discount) {
            discountEl.textContent = p.discount + '% OFF';
            discountEl.style.display = 'inline-block';
        } else {
            discountEl.textContent = 'Best Luxury Price';
        }

        /* Sizes */
        var sizesWrap = document.getElementById('pdSizesWrap');
        if (sizesWrap) {
            var szs = Array.isArray(p.size) ? p.size : ['Free Size'];
            sizesWrap.innerHTML = szs.map(function(s) { return '<span class="pd-size-pill">' + s + '</span>'; }).join('');
        }

        /* Colours */
        var colorsWrap = document.getElementById('pdColorsWrap');
        if (colorsWrap) {
            var cols = Array.isArray(p.colors) ? p.colors : (p.color ? [p.color] : ['Standard']);
            colorsWrap.innerHTML = cols.map(function(c) {
                var hex = colorHexMap[c] || '#8A681F';
                return '<span class="pd-size-pill" style="display:inline-flex; align-items:center; gap:5px;"><span style="width:8px; height:8px; border-radius:50%; background:' + hex + '; display:inline-block; border:1px solid rgba(0,0,0,0.2);"></span>' + c + '</span>';
            }).join('');
        }

        document.getElementById('pdFabricVal').textContent = p.fabric || 'Pure Silk';
        document.getElementById('pdSpecFabric').textContent = p.fabric || 'Pure Silk';
        document.getElementById('pdSpecColor').textContent = (Array.isArray(p.colors) ? p.colors.join(', ') : (p.color || 'Standard'));
        document.getElementById('pdSpecCategory').textContent = p.category || 'Ethnic Wear';
        document.getElementById('pdStockVal').textContent = (p.in_stock !== false ? 'In Stock (Ready to Ship)' : 'Made to Order');

        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };

    window.closeProductDetails = function() {
        var modal = document.getElementById('productDetailsModal');
        if (modal) {
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
    };

    /* Bind events on DOM ready */
    document.addEventListener('DOMContentLoaded', function() {
        var overlay = document.getElementById('quickViewOverlay');
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) window.closeQV();
            });
        }

        var qvClose = document.getElementById('qvClose');
        if (qvClose) qvClose.addEventListener('click', window.closeQV);

        var pdClose = document.getElementById('closeProductDetailsBtn');
        if (pdClose) pdClose.addEventListener('click', window.closeProductDetails);

        var pdModal = document.getElementById('productDetailsModal');
        if (pdModal) {
            pdModal.addEventListener('click', function(e) {
                if (e.target === pdModal) window.closeProductDetails();
            });
        }
    });
})();
</script>
