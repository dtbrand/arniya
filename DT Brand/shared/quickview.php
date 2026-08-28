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
/* Uploaded MP4s and pasted embed links play in the same slider as the photos. */
.qv-slide-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    background: #000;
}
.qv-slide-embed {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
    background: #000;
}
.qv-thumb-play {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
    font-weight: 800;
    color: #FFFFFF;
    background: rgba(0, 0, 0, 0.42);
    letter-spacing: 0.06em;
    pointer-events: none;
}
.qv-empty-media {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    font-size: 0.75rem;
    font-weight: 700;
    color: #9A9490;
    background: #F6F2EA;
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

.modal-actions-myntra { display: flex; gap: 12px; margin-top: 6px; }
.modal-add-bag-btn {
    flex: 2; padding: 13px 16px; border-radius: 8px;
    background: var(--dark-gold, #8A681F); color: #FFFFFF;
    font-family: var(--font-sans, 'Inter', sans-serif); font-size: 0.82rem; font-weight: 700;
    letter-spacing: 0.12em; text-transform: uppercase;
    transition: all 0.2s; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(138,104,31,0.25);
}
.modal-add-bag-btn:hover { background: var(--deep-gold, #6F5218); box-shadow: 0 6px 18px rgba(138,104,31,0.35); }
.modal-add-bag-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

.modal-wishlist-btn {
    flex: 1; padding: 13px 14px; border-radius: 8px;
    background: var(--off-white, #F8F6F0); color: var(--dark-text, #24211C);
    border: 1.5px solid var(--soft-platinum, #E5E3DE);
    font-family: var(--font-sans, 'Inter', sans-serif); font-size: 0.78rem; font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase;
    transition: all 0.2s; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
}
.modal-wishlist-btn:hover { border-color: var(--dark-gold, #8A681F); color: var(--dark-gold, #8A681F); background: #FAF3E0; }
.modal-wishlist-btn.active { border-color: #E53935; color: #E53935; background: #FDE8E8; }
.modal-wishlist-btn svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.modal-wishlist-btn.active svg { fill: #E53935; }

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

/* SKU line and the quantity stepper the quick view never had. */
.qv-sku-line { font-size: 0.7rem; letter-spacing: 0.06em; color: #7A7266; font-weight: 700; margin: -4px 0 6px; }
.qv-qty-section { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin: 4px 0 14px; }
.qv-qty-label { font-size: 0.68rem; font-weight: 800; letter-spacing: 0.08em; color: var(--dark-text, #24211C); }
.qv-qty-stepper { display: inline-flex; align-items: center; border: 1.5px solid rgba(138,104,31,0.4); border-radius: 8px; overflow: hidden; background: #FFFFFF; }
.qv-qty-stepper button { width: 32px; height: 34px; border: 0; background: rgba(138,104,31,0.08); color: var(--dark-gold, #8A681F); font-size: 1rem; font-weight: 800; cursor: pointer; line-height: 1; }
.qv-qty-stepper button:hover { background: rgba(138,104,31,0.18); }
.qv-qty-stepper input { width: 52px; height: 34px; border: 0; text-align: center; font-size: 0.85rem; font-weight: 800; color: var(--dark-text, #24211C); background: #FFFFFF; -moz-appearance: textfield; }
.qv-qty-stepper input::-webkit-outer-spin-button, .qv-qty-stepper input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
.qv-qty-note { font-size: 0.68rem; color: #7A7266; font-weight: 700; }
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
                <h3 class="pd-title" id="pdTitle"></h3>
                <span class="pd-subtitle" id="pdCategory"></span>
            </div>
            <button class="pd-close-btn" id="closeProductDetailsBtn" aria-label="Close Product Details">&times;</button>
        </div>

        <div class="pd-body">
            <!-- Hero Box -->
            <div class="pd-hero-box">
                <img id="pdImg" src="/assets/images/no-image.svg" alt="" class="pd-hero-img" />
                <div class="pd-hero-info">
                    <div class="pd-price-row">
                        <span class="pd-price" id="pdPrice"></span>
                        <span class="pd-old-price" id="pdOldPrice" style="display:none;"></span>
                        <span class="pd-tag" id="pdDiscountVal" style="display:none;"></span>
                    </div>

                    <div class="pd-meta-row" id="pdSizesRow" style="display:none;">
                        <span class="pd-meta-label">Available Sizes:</span>
                        <div class="pd-size-pills" id="pdSizesWrap"></div>
                    </div>

                    <div class="pd-meta-row" id="pdColorsRow" style="display:none;">
                        <span class="pd-meta-label">Available Colours:</span>
                        <div class="pd-size-pills" id="pdColorsWrap"></div>
                    </div>

                    <div class="pd-meta-row" id="pdFabricRow" style="display:none;">
                        <span class="pd-meta-label">Fabric:</span>
                        <span id="pdFabricVal" style="font-weight:700; color:var(--dark-text);"></span>
                    </div>
                </div>
            </div>

            <!-- Full Product Description (hidden when the row has none) -->
            <div class="pd-desc-box" id="pdDescBox" style="display:none;">
                <h4 class="pd-section-title">Full Product Description</h4>
                <p class="pd-full-desc" id="pdFullDesc"></p>
            </div>

            <!-- Garment Specifications Grid -->
            <div class="pd-specs-section">
                <h4 class="pd-section-title">Garment Specifications</h4>
                <div class="pd-specs-grid" id="pdSpecsGrid"></div>
                <p id="pdNoSpecs" style="display:none; margin:0; font-size:.78rem; color:#7A7266;">
                    No specifications have been recorded for this product yet.
                </p>
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

    var QV_NO_IMAGE = '/assets/images/no-image.svg';
    var QV_FREE_SHIP_OVER = 1999;

    // Everything below is written into innerHTML, so stored values are escaped.
    function qvEsc(v) {
        return String(v === null || typeof v === 'undefined' ? '' : v)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function qvClean(list) {
        return (Array.isArray(list) ? list : []).filter(function(v) {
            return String(v === null || typeof v === 'undefined' ? '' : v).trim() !== '';
        });
    }

    // The slider shows this product's OWN media: uploaded photos, uploaded MP4s
    // and pasted embed links (YouTube / Instagram), in that order.
    //
    // It used to pad every gallery with three unrelated stock files —
    // '/assets/images/product' + ((id + n) % 8 + 1) + '.png' — so a saree with a
    // single photo quick-viewed as a four-photo product showing other people's
    // sarees, and uploaded video was unreachable from here entirely.
    function qvMediaList(p) {
        var media = [];
        var photos = qvClean(p.images && p.images.length ? p.images : p.gallery);
        if (!photos.length && p.image && p.image !== QV_NO_IMAGE && p.has_photo !== false) {
            photos = [p.image];
        }
        photos.forEach(function(src) {
            if (src !== QV_NO_IMAGE) media.push({ kind: 'image', src: src });
        });

        qvClean(p.videos && p.videos.length ? p.videos : (p.video ? [p.video] : []))
            .forEach(function(src) { media.push({ kind: 'video', src: src }); });

        qvClean(p.embeds && p.embeds.length ? p.embeds : (p.embed ? [p.embed] : []))
            .forEach(function(src) { media.push({ kind: 'embed', src: src }); });

        return media;
    }

    function qvStopMedia(root) {
        if (!root) return;
        root.querySelectorAll('video').forEach(function(v) {
            try { v.pause(); } catch (e) {}
        });
        // Reloading an embed src is the only reliable way to stop a third-party
        // player once the modal closes.
        root.querySelectorAll('iframe').forEach(function(f) {
            var s = f.getAttribute('src');
            if (s) { f.setAttribute('src', s); }
        });
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

        // A product this page does not hold is fetched from the catalogue API. It
        // used to be replaced by an invented "DT Brand's Ethnic Saree" at ₹4,999
        // (MRP ₹6,999), so a stale link opened a saree that does not exist and
        // could be added to the bag.
        if (!p) {
            var wanted = String(id === null || typeof id === 'undefined' ? '' : id).trim();
            if (wanted === '') { return; }
            // Numeric ids go to ?id=, anything else to ?sku= — api/products.php
            // casts ?id= to int, so a SKU sent there returns the whole catalogue.
            var lookupQs = /^[0-9]+$/.test(wanted)
                ? 'id=' + encodeURIComponent(wanted)
                : 'sku=' + encodeURIComponent(wanted);
            fetch('/api/products.php?' + lookupQs)
                .then(function(r) { return r.json(); })
                .then(function(d) {
                    if (d && d.success && d.product) {
                        window.openQV(d.product);
                    } else if (typeof window.showToast === 'function') {
                        window.showToast('Sorry, this product is no longer available.');
                    }
                })
                .catch(function() {
                    if (typeof window.showToast === 'function') {
                        window.showToast('Could not load this product. Please try again.');
                    }
                });
            return;
        }

        window.currentQVProduct = p;

        // Sizes and colours come from product_variants only. Both lists used to be
        // defaulted - to ['Free Size'] and ['Standard'] - so every saree offered a
        // size and a colour that the mill had never entered, and that choice was
        // then written onto the order.
        var sizeArr = qvClean(Array.isArray(p.size) ? p.size : (Array.isArray(p.sizes) ? p.sizes : (p.size ? [p.size] : [])));
        var sizeBtnsHtml = sizeArr.map(function(s, idx) {
            return '<button class="m-size-btn ' + (idx === 0 ? 'active' : '') + '" data-sz="' + qvEsc(s) + '">' + qvEsc(s) + '</button>';
        }).join('');

        var colorArr = qvClean(Array.isArray(p.colors) ? p.colors : (p.color ? [p.color] : []));
        var defaultColor = colorArr.length ? colorArr[0] : '';

        var colorSwatchesHtml = colorArr.map(function(c, idx) {
            var hex = colorHexMap[c] || '#8A681F';
            return '<button class="m-color-btn ' + (idx === 0 ? 'active' : '') + '" data-color="' + qvEsc(c) + '" style="background-color: ' + hex + ';" title="' + qvEsc(c) + '" aria-label="' + qvEsc(c) + '"></button>';
        }).join('');

        var isWish = false;
        if (Array.isArray(window.wishlistState)) {
            isWish = window.wishlistState.some(function(item) { return item.id == p.id; });
        }

        var mediaList = qvMediaList(p);
        var maxSlides = mediaList.length;
        var currentSlideIndex = 0;

        var slidesHtml = '';
        var dotsHtml = '';
        var thumbsHtml = '';
        var pName = qvEsc(p.name || p.title || 'Product');
        var posterImg = '';
        mediaList.some(function(m) { if (m.kind === 'image') { posterImg = m.src; return true; } return false; });

        mediaList.forEach(function(m, idx) {
            var thumbInner;
            if (m.kind === 'video') {
                // An uploaded MP4 plays here instead of being unreachable.
                slidesHtml +=
                    '<div class="qv-slide-img-wrap">' +
                        '<video class="qv-slide-video" src="' + qvEsc(m.src) + '" controls playsinline preload="metadata"' +
                            (posterImg ? ' poster="' + qvEsc(posterImg) + '"' : '') + '></video>' +
                    '</div>';
                thumbInner = posterImg
                    ? '<img src="' + qvEsc(posterImg) + '" alt="' + pName + ' video" /><span class="qv-thumb-play">&#9658;</span>'
                    : '<span class="qv-thumb-play">&#9658;</span>';
            } else if (m.kind === 'embed') {
                slidesHtml +=
                    '<div class="qv-slide-img-wrap">' +
                        '<iframe class="qv-slide-embed" src="' + qvEsc(m.src) + '" title="' + pName + ' video" ' +
                            'allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" ' +
                            'referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy"></iframe>' +
                    '</div>';
                thumbInner = posterImg
                    ? '<img src="' + qvEsc(posterImg) + '" alt="' + pName + ' video" /><span class="qv-thumb-play">&#9658;</span>'
                    : '<span class="qv-thumb-play">&#9658;</span>';
            } else {
                slidesHtml +=
                    '<div class="qv-slide-img-wrap">' +
                        '<img class="qv-slide-img" src="' + qvEsc(m.src) + '" alt="' + pName + ' - View ' + (idx + 1) + '" />' +
                    '</div>';
                thumbInner = '<img src="' + qvEsc(m.src) + '" alt="' + pName + ' thumbnail ' + (idx + 1) + '" />';
            }
            dotsHtml += '<div class="qv-dot ' + (idx === 0 ? 'active' : '') + '" data-idx="' + idx + '"></div>';
            thumbsHtml += '<div class="qv-thumb ' + (idx === 0 ? 'active' : '') + '" data-idx="' + idx + '">' + thumbInner + '</div>';
        });

        // No photo and no video says so, rather than borrowing another saree's
        // picture from /assets/images/.
        if (maxSlides === 0) {
            slidesHtml =
                '<div class="qv-slide-img-wrap">' +
                    '<div class="qv-empty-media">' +
                        '<img src="' + QV_NO_IMAGE + '" alt="" />' +
                        '<span>No photo has been uploaded for this product yet.</span>' +
                    '</div>' +
                '</div>';
        }

        var priceNum = Number(p.price) || 0;
        var oldNum = Number(p.old_price) || 0;
        var discNum = Number(p.discount) || 0;
        var inStock = (p.in_stock !== false) && (typeof p.stock_qty === 'undefined' || Number(p.stock_qty) > 0 || p.in_stock === true);
        var stockQty = (typeof p.stock_qty === 'undefined' || p.stock_qty === null || p.stock_qty === '') ? null : Number(p.stock_qty);
        var priceHtml = priceNum > 0
            ? '<span class="modal-price">&#8377;' + priceNum.toLocaleString('en-IN') + '</span>'
            : '<span class="modal-price">Price on request</span>';

        content.innerHTML =
            // Left Column: Interactive Slider + Thumbnails
            '<div class="modal-image-area-wrap">' +
                '<div class="qv-slider-container" id="qvSliderContainer">' +
                    (p.badge ? '<span class="modal-badge-tag">' + qvEsc(p.badge) + '</span>' : '') +
                    '<div class="qv-slider-track" id="qvSliderTrack">' +
                        slidesHtml +
                    '</div>' +
                    (maxSlides > 1 ? '<button class="qv-arrow qv-prev-arrow" id="qvPrevArrow" aria-label="Previous media"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg></button>' : '') +
                    (maxSlides > 1 ? '<button class="qv-arrow qv-next-arrow" id="qvNextArrow" aria-label="Next media"><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg></button>' : '') +
                    '<div class="qv-slider-dots" id="qvSliderDots">' + (maxSlides > 1 ? dotsHtml : '') + '</div>' +
                '</div>' +
                '<div class="qv-thumbnails-wrap" id="qvThumbnailsWrap">' +
                    (maxSlides > 1 ? thumbsHtml : '') +
                '</div>' +
            '</div>' +

            // Right Column: Details & Actions
            '<div class="modal-details">' +
                '<div class="modal-brand-name">DT BRAND\'S ETHNIC LUXURY</div>' +
                '<h2 class="modal-name">' + pName + '</h2>' +
                (p.sku ? '<div class="qv-sku-line">SKU: ' + qvEsc(p.sku) + '</div>' : '') +

                '<div class="modal-price-block">' +
                    '<div class="modal-price-row">' +
                        priceHtml +
                        (oldNum > priceNum ? '<span class="modal-mrp">MRP <span class="modal-old-price">&#8377;' + oldNum.toLocaleString('en-IN') + '</span></span>' : '') +
                        (discNum > 0 ? '<span class="modal-discount-tag">(' + discNum + '% OFF)</span>' : '') +
                    '</div>' +
                    '<span class="modal-tax-note">' + (priceNum > 0 ? 'Exclusive of all taxes' : 'Contact us on WhatsApp for this product&#39;s rate') + '</span>' +
                '</div>' +

                // Colours only when the product actually has variant colours.
                (colorArr.length
                    ? '<div class="modal-color-section">' +
                        '<div class="modal-color-header">' +
                            '<span>SELECT COLOUR: <strong id="qvSelectedColorName" class="qv-color-name-text">' + qvEsc(defaultColor) + '</strong></span>' +
                        '</div>' +
                        '<div class="modal-color-swatches" id="qvColorWrap">' + colorSwatchesHtml + '</div>' +
                      '</div>'
                    : '') +

                '<div class="modal-size-section">' +
                    '<div class="modal-size-header">' +
                        '<span>' + (sizeArr.length ? 'SELECT SIZE' : 'PRODUCT INFORMATION') + '</span>' +
                        '<span class="modal-product-details-btn" id="qvPdBtn">PRODUCT DETAILS &rsaquo;</span>' +
                    '</div>' +
                    (sizeArr.length ? '<div class="modal-size-pills" id="qvSizeWrap">' + sizeBtnsHtml + '</div>' : '') +
                '</div>' +

                // A real quantity stepper. Quick view had none, so a wholesale
                // buyer could only ever add a single piece from here.
                '<div class="qv-qty-section">' +
                    '<span class="qv-qty-label">QUANTITY</span>' +
                    '<div class="qv-qty-stepper">' +
                        '<button type="button" id="qvQtyMinus" aria-label="Decrease quantity">&minus;</button>' +
                        '<input type="number" id="qvQtyInput" value="' + (Number(p.moq) > 1 ? Number(p.moq) : 1) + '" min="1"' + (stockQty !== null && stockQty > 0 ? ' max="' + stockQty + '"' : '') + ' />' +
                        '<button type="button" id="qvQtyPlus" aria-label="Increase quantity">+</button>' +
                    '</div>' +
                    (Number(p.moq) > 1 ? '<span class="qv-qty-note">MOQ ' + Number(p.moq) + ' pcs</span>' : '') +
                    (stockQty !== null ? '<span class="qv-qty-note">' + (stockQty > 0 ? stockQty + ' pcs in stock' : 'Out of stock') + '</span>' : '') +
                '</div>' +

                '<div class="modal-actions-myntra">' +
                    '<button class="modal-add-bag-btn" id="qvAtc"' + (inStock ? '' : ' disabled style="opacity:.5; cursor:not-allowed;"') + '>' +
                        '<svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>' +
                        (inStock ? 'ADD TO BAG' : 'OUT OF STOCK') +
                    '</button>' +
                    '<button class="modal-wishlist-btn ' + (isWish ? 'active' : '') + '" id="qvWishlist">' +
                        '<svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>' +
                        'WISHLIST' +
                    '</button>' +
                '</div>' +

                '<div class="modal-perks">' +
                    '<div class="m-perk-item">' +
                        '<svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>' +
                        '<span>Direct from our Surat handloom mill</span>' +
                    '</div>' +
                    '<div class="m-perk-item">' +
                        '<svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>' +
                        '<span>Free shipping on orders over &#8377;' + QV_FREE_SHIP_OVER.toLocaleString('en-IN') + '</span>' +
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
            if (maxSlides < 1 || !sliderTrack) return;
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
        if (sliderTrack) sliderTrack.addEventListener('scroll', function() {
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
            if (maxSlides > 1 && !mediaList.some(function(m) { return m.kind !== 'image'; })) {
                startAutoSlide();
            }
        }

        // Hover triggers play/pause
        if (sliderContainer) {
            sliderContainer.addEventListener('mouseenter', stopAutoSlide);
            sliderContainer.addEventListener('mouseleave', function() {
                if (maxSlides > 1 && !mediaList.some(function(m) { return m.kind !== 'image'; })) {
                    startAutoSlide();
                }
            });
        }

        // Auto-advance only for a pure photo gallery. It used to run always, so a
        // slider carrying a video snatched the slide away mid-playback.
        var hasPlayableMedia = mediaList.some(function(m) { return m.kind !== 'image'; });
        if (maxSlides > 1 && !hasPlayableMedia) {
            startAutoSlide();
        }

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

        /* Quantity stepper */
        var qtyInput = document.getElementById('qvQtyInput');
        var qvMinQty = Number(p.moq) > 1 ? Number(p.moq) : 1;
        function qvReadQty() {
            if (!qtyInput) return qvMinQty;
            var n = parseInt(qtyInput.value, 10);
            if (!(n > 0)) n = qvMinQty;
            if (n < qvMinQty) n = qvMinQty;
            if (stockQty !== null && stockQty > 0 && n > stockQty) n = stockQty;
            qtyInput.value = n;
            return n;
        }
        var qtyMinus = document.getElementById('qvQtyMinus');
        var qtyPlus = document.getElementById('qvQtyPlus');
        if (qtyMinus) qtyMinus.addEventListener('click', function() {
            if (qtyInput) { qtyInput.value = Math.max(qvMinQty, (parseInt(qtyInput.value, 10) || qvMinQty) - 1); qvReadQty(); }
        });
        if (qtyPlus) qtyPlus.addEventListener('click', function() {
            if (qtyInput) { qtyInput.value = (parseInt(qtyInput.value, 10) || qvMinQty) + 1; qvReadQty(); }
        });
        if (qtyInput) qtyInput.addEventListener('change', qvReadQty);

        /* Add To Bag with the selected size, colour AND quantity */
        var qvAtc = document.getElementById('qvAtc');
        if (qvAtc && inStock) {
            qvAtc.addEventListener('click', function() {
                // Blank when the mill entered no variants, instead of the old
                // invented 'Free Size' / 'Standard' that then travelled onto the
                // order and the warehouse slip.
                var activeSizeBtn = content.querySelector('.m-size-btn.active');
                var selSize = activeSizeBtn ? (activeSizeBtn.dataset.sz || '') : '';

                var activeColorBtn = content.querySelector('.m-color-btn.active');
                var selColor = activeColorBtn ? (activeColorBtn.dataset.color || '') : '';

                if (typeof window.addToCart === 'function') {
                    window.addToCart(p, { qty: qvReadQty(), size: selSize, color: selColor });
                }
                window.closeQV();
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
                // The product object, not its id: a product fetched from the API is
                // not in window.allProducts, so an id lookup found nothing and the
                // details modal silently refused to open.
                window.openProductDetails(p);
            });
        }
    };

    window.openQuickView = window.openQV;
    window.openQuickViewModal = window.openQV;

    window.closeQV = function() {
        var overlay = document.getElementById('quickViewOverlay');
        // Video kept playing behind the closed overlay before this.
        qvStopMedia(document.getElementById('quickModalContent'));
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

    /* Full Product Details Modal Controller — every field is stored or hidden. */
    window.openProductDetails = function(id) {
        var modal = document.getElementById('productDetailsModal');
        if (!modal) return;

        var products = window.allProducts || window.catalogProducts || window.products || [];
        var p = (typeof id === 'object' && id !== null)
            ? id
            : products.find(function(x) { return x && (x.id == id || String(x.id) === String(id) || String(x.sku) === String(id)); });
        if (!p) return;

        var qvSet = function(elId, text) {
            var el = document.getElementById(elId);
            if (el) el.textContent = text;
        };
        var qvShow = function(elId, on, mode) {
            var el = document.getElementById(elId);
            if (el) el.style.display = on ? (mode || 'flex') : 'none';
        };

        qvSet('pdTitle', p.name || p.title || 'Product');
        // The subtitle used to read 'Ethnic Wear Collection' for uncategorised
        // products, so a product with no category still claimed one.
        var catLine = String(p.category || '').trim();
        qvSet('pdCategory', catLine !== '' ? catLine : (p.sku ? 'SKU ' + p.sku : ''));

        var pdImgEl = document.getElementById('pdImg');
        if (pdImgEl) {
            var heroPhotos = qvClean(p.images && p.images.length ? p.images : p.gallery);
            var hero = heroPhotos.length ? heroPhotos[0] : ((p.image && p.image !== QV_NO_IMAGE && p.has_photo !== false) ? p.image : '');
            pdImgEl.src = hero || QV_NO_IMAGE;
            pdImgEl.alt = String(p.name || p.title || '');
            pdImgEl.style.opacity = hero ? '' : '.45';
        }

        var pdPriceNum = Number(p.price) || 0;
        qvSet('pdPrice', pdPriceNum > 0 ? '₹' + pdPriceNum.toLocaleString('en-IN') : 'Price on request');

        var pdOldNum = Number(p.old_price) || 0;
        var oldPriceEl = document.getElementById('pdOldPrice');
        if (oldPriceEl) {
            if (pdOldNum > pdPriceNum) {
                oldPriceEl.textContent = '₹' + pdOldNum.toLocaleString('en-IN');
                oldPriceEl.style.display = 'inline';
            } else {
                oldPriceEl.textContent = '';
                oldPriceEl.style.display = 'none';
            }
        }

        // Hidden with no discount. It used to fall back to the slogan
        // 'Best Luxury Price', which read like a saving that did not exist.
        var pdDiscNum = Number(p.discount) || 0;
        var discountEl = document.getElementById('pdDiscountVal');
        if (discountEl) {
            discountEl.textContent = pdDiscNum > 0 ? pdDiscNum + '% OFF' : '';
            discountEl.style.display = pdDiscNum > 0 ? 'inline-block' : 'none';
        }

        /* Sizes — the row disappears when the product has none. */
        var pdSizes = qvClean(Array.isArray(p.size) ? p.size : (Array.isArray(p.sizes) ? p.sizes : (p.size ? [p.size] : [])));
        var sizesWrap = document.getElementById('pdSizesWrap');
        if (sizesWrap) {
            sizesWrap.innerHTML = pdSizes.map(function(s) {
                return '<span class="pd-size-pill">' + qvEsc(s) + '</span>';
            }).join('');
        }
        qvShow('pdSizesRow', pdSizes.length > 0);

        /* Colours */
        var pdColors = qvClean(Array.isArray(p.colors) ? p.colors : (p.color ? [p.color] : []));
        var colorsWrap = document.getElementById('pdColorsWrap');
        if (colorsWrap) {
            colorsWrap.innerHTML = pdColors.map(function(c) {
                var hex = colorHexMap[c] || '#8A681F';
                return '<span class="pd-size-pill" style="display:inline-flex; align-items:center; gap:5px;">' +
                       '<span style="width:8px; height:8px; border-radius:50%; background:' + hex + '; display:inline-block; border:1px solid rgba(0,0,0,0.2);"></span>' +
                       qvEsc(c) + '</span>';
            }).join('');
        }
        qvShow('pdColorsRow', pdColors.length > 0);

        /* Fabric */
        var pdFabric = String(p.fabric || '').trim();
        qvSet('pdFabricVal', pdFabric);
        qvShow('pdFabricRow', pdFabric !== '');

        /* Description — hidden when the mill wrote none, instead of the invented
           "Handcrafted luxury ethnic wear from DT Brand's Heritage Collection"
           paragraph that every single product used to display. */
        var pdDesc = String(p.description || '').trim();
        qvSet('pdFullDesc', pdDesc);
        qvShow('pdDescBox', pdDesc !== '', 'block');

        /* Specifications, built only from columns that hold a value. */
        var specPairs = [
            ['Fabric', pdFabric],
            ['Weave', String(p.weave || '').trim()],
            ['Zari', String(p.zari_type || '').trim()],
            ['Pallu', String(p.pallu_style || '').trim()],
            ['Blouse piece', String(p.blouse_piece || '').trim()],
            ['Occasion', String(p.occasion || '').trim()],
            ['Category', catLine],
            ['Colours', pdColors.join(', ')],
            ['SKU', String(p.sku || '').trim()]
        ];
        if (p.in_stock === false) {
            specPairs.push(['Availability', 'Out of stock']);
        } else if (typeof p.stock_qty !== 'undefined' && p.stock_qty !== null && p.stock_qty !== '' && Number(p.stock_qty) > 0) {
            specPairs.push(['Availability', Number(p.stock_qty).toLocaleString('en-IN') + ' pcs in stock']);
        }
        var moqLots = p.moq_lots || {};
        [['Single', moqLots.single], ['Half set', moqLots.half_set], ['Full set', moqLots.full_set], ['Master bale', moqLots.master_bale]]
            .forEach(function(pair) {
                if (Number(pair[1]) > 0) specPairs.push(['MOQ ' + pair[0], Number(pair[1]) + ' pcs']);
            });

        var filledSpecs = specPairs.filter(function(pair) { return pair[1] !== '' && pair[1] !== null && typeof pair[1] !== 'undefined'; });
        var specsGrid = document.getElementById('pdSpecsGrid');
        if (specsGrid) {
            specsGrid.innerHTML = filledSpecs.map(function(pair) {
                return '<div class="pd-spec-item"><span class="pd-spec-label">' + qvEsc(pair[0]) + '</span>' +
                       '<span class="pd-spec-val">' + qvEsc(pair[1]) + '</span></div>';
            }).join('');
            specsGrid.style.display = filledSpecs.length ? '' : 'none';
        }
        qvShow('pdNoSpecs', filledSpecs.length === 0, 'block');

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
