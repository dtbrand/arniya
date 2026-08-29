<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * adminheader.php — Luxury Top Header with Shop-Style Clean Desktop & Full-Width Mobile Search Bar
 * DT Brand's & Jai Hanuman Tex
 */
if (!headers_sent()) {
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
}
?>
<style>
/* ════════════════════════════════════════════════════════════════
   ADMIN HEADER — FULL SELF-CONTAINED CSS
   DT Brand's & Jai Hanuman Tex
   ════════════════════════════════════════════════════════════════ */
.adm-header {
    position: sticky;
    top: 0;
    left: 0;
    right: 0;
    z-index: 9998;
    background: #FFFFFF;
    border-bottom: 1.5px solid rgba(212,175,55,0.22);
    box-shadow: 0 2px 14px rgba(138,104,31,0.09);
    font-family: 'Inter','Plus Jakarta Sans',-apple-system,sans-serif;
    -webkit-font-smoothing: antialiased;
}
.adm-header-normal-view {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 0 16px;
    height: 56px;
}
.adm-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    min-width: 0;
}
.adm-header-right {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
/* Mobile Menu Hamburger */
.adm-mobile-menu-btn {
    display: none;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: 1px solid rgba(212,175,55,0.3);
    border-radius: 8px;
    background: #FAF5E8;
    color: #705114;
    cursor: pointer;
    flex-shrink: 0;
    transition: all 0.2s ease;
}
.adm-mobile-menu-btn:hover { background: #F5ECCE; border-color: #D4AF37; }
/* Mobile Brand Link */
.adm-mobile-brand-link {
    display: none;
    align-items: center;
    gap: 7px;
    text-decoration: none;
    flex-shrink: 0;
}
.adm-mobile-logo-img { height: 28px; width: auto; object-fit: contain; }
.adm-mobile-brand-title { font-size: 0.8rem; font-weight: 800; color: #181512; letter-spacing: -0.01em; }
/* Search Container */
.adm-header-search-container { position: relative; flex: 1; max-width: 520px; }
.adm-search-amazon-bar {
    display: flex;
    align-items: center;
    background: #F9F7F3;
    border: 1.5px solid rgba(212,175,55,0.35);
    border-radius: 9px;
    overflow: hidden;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.adm-search-amazon-bar:focus-within { border-color: #D4AF37; box-shadow: 0 0 0 3px rgba(212,175,55,0.15); }
.adm-search-input-wrap { flex: 1; position: relative; display: flex; align-items: center; }
.adm-search-input-amazon {
    width: 100%;
    height: 36px;
    padding: 0 32px 0 14px;
    border: none;
    background: transparent;
    font-size: 0.78rem;
    color: #1F2937;
    font-family: inherit;
    outline: none;
}
.adm-search-clear-btn {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
    display: none;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    border: none;
    background: none;
    color: #64748B;
    cursor: pointer;
    font-size: 0.75rem;
}
.adm-search-submit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: none;
    border-left: 1px solid rgba(212,175,55,0.25);
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 100%);
    color: #181512;
    cursor: pointer;
    flex-shrink: 0;
    transition: background 0.2s ease;
}
.adm-search-submit-btn:hover { background: linear-gradient(135deg, #C59312 0%, #DFC04E 100%); }
.adm-search-submit-btn svg { width: 14px; height: 14px; stroke: #181512; fill: none; stroke-width: 2.3; }
/* Live Search Dropdown */
.adm-live-search-dropdown {
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    right: 0;
    background: #FFFFFF;
    border: 1.5px solid rgba(212,175,55,0.3);
    border-radius: 10px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.16);
    z-index: 99999;
    max-height: 420px;
    overflow-y: auto;
    display: none;
}
/* Header Action Buttons */
.adm-mobile-search-trigger-btn {
    display: none;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: 1px solid rgba(212,175,55,0.25);
    border-radius: 8px;
    background: #FAF5E8;
    color: #705114;
    cursor: pointer;
}
.adm-live-wa-pill {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    background: #F0FDF4;
    border: 1px solid #BBF7D0;
    border-radius: 20px;
    font-size: 0.68rem;
    font-weight: 700;
    color: #15803D;
    white-space: nowrap;
}
.adm-pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #15803D;
    box-shadow: 0 0 0 2px rgba(21,128,61,0.25);
    animation: admPulse 1.8s ease-in-out infinite;
    flex-shrink: 0;
}
@keyframes admPulse { 0%,100%{box-shadow:0 0 0 2px rgba(21,128,61,0.25)} 50%{box-shadow:0 0 0 5px rgba(21,128,61,0.12)} }
.adm-hdr-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border: 1px solid rgba(212,175,55,0.25);
    border-radius: 8px;
    background: #FAF5E8;
    color: #705114;
    cursor: pointer;
    position: relative;
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.adm-hdr-btn:hover { background: #F5ECCE; border-color: #D4AF37; transform: translateY(-1px); }
.adm-hdr-btn svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2.2; }
.adm-hdr-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    min-width: 16px;
    height: 16px;
    background: #DC2626;
    color: #FFF;
    border-radius: 8px;
    font-size: 0.55rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 3px;
    border: 1.5px solid #FFF;
}
/* Primary Gold Button */
.adm-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 0 13px;
    height: 34px;
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
    border: 1px solid #8A681F;
    border-radius: 8px;
    color: #111827;
    font-size: 0.74rem;
    font-weight: 800;
    letter-spacing: -0.01em;
    text-decoration: none;
    cursor: pointer;
    white-space: nowrap;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 2px 8px rgba(184,134,11,0.28);
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.adm-btn-primary:hover { background: linear-gradient(135deg,#C59312 0%,#DFC04E 50%,#F0D77B 100%); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(184,134,11,0.42); }
/* Secondary Button */
.adm-btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 0 11px;
    height: 34px;
    background: linear-gradient(135deg,#181512 0%,#2A241E 100%);
    border: 1.2px solid #8A681F;
    border-radius: 8px;
    color: #FAF5E8;
    font-size: 0.74rem;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.adm-btn-secondary:hover { border-color: #D4AF37; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(0,0,0,0.3); }

/* ══════════════ PROFILE DROPDOWN ══════════════ */
.adm-hdr-profile-wrap {
    position: relative;
    flex-shrink: 0;
}
.adm-hdr-profile {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 10px 4px 5px;
    border: 1.5px solid rgba(212,175,55,0.3);
    border-radius: 10px;
    background: #FAF5E8;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.adm-hdr-profile:hover { background: #F5ECCE; border-color: #D4AF37; box-shadow: 0 2px 10px rgba(212,175,55,0.2); }
.adm-hdr-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #D4AF37;
    flex-shrink: 0;
}
.adm-hdr-user-text { display: flex; flex-direction: column; align-items: flex-start; gap: 1px; }
.adm-hdr-name { font-size: 0.74rem; font-weight: 800; color: #181512; letter-spacing: -0.01em; }
.adm-hdr-title { font-size: 0.62rem; font-weight: 600; color: #8A681F; }
.adm-hdr-caret { transition: transform 0.25s ease; color: #8A681F; }

/* Dropdown Menu Panel */
.adm-profile-dropdown-menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    min-width: 230px;
    background: #FFFFFF;
    border: 1.5px solid rgba(212,175,55,0.35);
    border-radius: 12px;
    box-shadow: 0 16px 48px rgba(0,0,0,0.18), 0 4px 16px rgba(212,175,55,0.15);
    z-index: 99999;
    overflow: hidden;
    animation: admDdFadeIn 0.18s ease;
}
@keyframes admDdFadeIn { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }

/* Dropdown Header */
.adm-dd-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 14px 12px;
    background: linear-gradient(135deg,rgba(38,28,14,0.96) 0%,rgba(58,44,18,0.92) 100%);
    border-bottom: 1px solid rgba(212,175,55,0.3);
}
.adm-dd-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #D4AF37;
    flex-shrink: 0;
}
.adm-dd-identity { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
.adm-dd-name { font-size: 0.82rem; font-weight: 800; color: #FAF5E8; letter-spacing: -0.01em; white-space: nowrap; }
.adm-dd-email { font-size: 0.68rem; color: #C5A859; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.adm-dd-badge {
    display: inline-flex;
    align-items: center;
    padding: 1px 7px;
    background: rgba(212,175,55,0.2);
    border: 1px solid rgba(212,175,55,0.4);
    border-radius: 10px;
    font-size: 0.6rem;
    font-weight: 700;
    color: #D4AF37;
    width: fit-content;
    margin-top: 2px;
}
/* Divider */
.adm-dd-divider { height: 1px; background: rgba(212,175,55,0.15); margin: 0; }

/* Nav List */
.adm-dd-nav-list {
    list-style: none !important;
    margin: 0;
    padding: 6px 0;
}
.adm-dd-nav-list li { list-style: none !important; margin: 0; padding: 0; }
.adm-dd-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 14px;
    text-decoration: none;
    font-size: 0.77rem;
    font-weight: 600;
    color: #1F2937;
    transition: background 0.15s ease, color 0.15s ease;
    cursor: pointer;
    width: 100%;
    box-sizing: border-box;
}
.adm-dd-item svg { flex-shrink: 0; stroke: #64748B; transition: stroke 0.15s ease; }
.adm-dd-item:hover { background: #FAF5E8; color: #705114; }
.adm-dd-item:hover svg { stroke: #8A681F; }

/* Dropdown Footer — Logout Button */
.adm-dd-footer { padding: 8px 10px 10px; }
.adm-dd-logout-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 9px 14px;
    background: linear-gradient(135deg,#FEF2F2 0%,#FEE2E2 100%);
    border: 1.5px solid #FECACA;
    border-radius: 8px;
    color: #DC2626;
    font-size: 0.77rem;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.2s ease;
    letter-spacing: -0.01em;
    font-family: inherit;
}
.adm-dd-logout-btn svg { stroke: #DC2626; }
.adm-dd-logout-btn:hover {
    background: linear-gradient(135deg,#DC2626 0%,#B91C1C 100%);
    border-color: #B91C1C;
    color: #FFF;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(220,38,38,0.35);
}
.adm-dd-logout-btn:hover svg { stroke: #FFF; }

/* ══════════════ LOGOUT CONFIRMATION MODAL ══════════════ */
/* display is controlled via JS (style.display). Do NOT set display here. */
.adm-logout-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(15,10,5,0.72);
    z-index: 999999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}
.adm-logout-modal-backdrop[style*="flex"],
.adm-logout-modal-backdrop.show {
    display: flex !important;
    align-items: center;
    justify-content: center;
}
.adm-logout-modal-card {
    background: #FFFFFF;
    border: 1.5px solid rgba(212,175,55,0.3);
    border-radius: 14px;
    padding: 28px 28px 24px;
    width: 92%;
    max-width: 380px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,0.35);
    animation: admDdFadeIn 0.2s ease;
}
.adm-logout-modal-icon-wrap {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #FEF2F2;
    border: 2px solid #FECACA;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
}
.adm-logout-modal-title { font-size: 1rem; font-weight: 800; color: #111827; margin: 0 0 8px; }
.adm-logout-modal-desc { font-size: 0.8rem; color: #64748B; font-weight: 500; margin: 0 0 20px; line-height: 1.5; }
.adm-logout-modal-actions { display: flex; gap: 10px; }
.adm-logout-cancel-btn {
    flex: 1;
    height: 38px;
    border: 1.5px solid #E5E7EB;
    border-radius: 8px;
    background: #F9FAFB;
    color: #374151;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.15s ease;
}
.adm-logout-cancel-btn:hover { background: #F3F4F6; border-color: #D1D5DB; }
.adm-logout-confirm-btn {
    flex: 1;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg,#DC2626 0%,#B91C1C 100%);
    color: #FFF;
    font-size: 0.8rem;
    font-weight: 800;
    cursor: pointer;
    font-family: inherit;
    box-shadow: 0 3px 10px rgba(220,38,38,0.3);
    transition: all 0.2s ease;
}
.adm-logout-confirm-btn:hover { background: linear-gradient(135deg,#B91C1C 0%,#991B1B 100%); transform: translateY(-1px); box-shadow: 0 5px 16px rgba(220,38,38,0.4); }

/* ══════════════ MOBILE FULL SEARCH BAR OVERLAY ══════════════ */
.adm-mobile-full-search-bar {
    display: none;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    background: #FFFFFF;
    border-top: 1px solid rgba(212,175,55,0.2);
    position: absolute;
    top: 56px;
    left: 0;
    right: 0;
    z-index: 9997;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}
.adm-mobile-search-input-wrap {
    flex: 1;
    display: flex;
    align-items: center;
    background: #F9F7F3;
    border: 1.5px solid rgba(212,175,55,0.3);
    border-radius: 8px;
    overflow: hidden;
    position: relative;
}
.adm-mobile-search-input-field {
    flex: 1;
    height: 36px;
    border: none;
    background: transparent;
    font-size: 0.8rem;
    color: #1F2937;
    outline: none;
    font-family: inherit;
}
.adm-mobile-search-clear-btn {
    width: 28px;
    height: 28px;
    border: none;
    background: none;
    color: #64748B;
    cursor: pointer;
    font-size: 0.8rem;
    display: none;
    align-items: center;
    justify-content: center;
}
.adm-mobile-search-close-btn {
    width: 36px;
    height: 36px;
    border: 1px solid #E5E7EB;
    border-radius: 8px;
    background: #F9FAFB;
    color: #374151;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.adm-mobile-search-close-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.4; }
.adm-mobile-live-search-dropdown {
    position: absolute;
    top: calc(100% + 2px);
    left: 14px;
    right: 14px;
    background: #FFFFFF;
    border: 1.5px solid rgba(212,175,55,0.3);
    border-radius: 10px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.16);
    z-index: 99999;
    max-height: 360px;
    overflow-y: auto;
    display: none;
}
/* Active search state */
.adm-header.mobile-search-active .adm-mobile-full-search-bar { display: flex; }

/* ══════════════ RESPONSIVE ══════════════ */
@media (max-width: 1024px) {
    .adm-mobile-menu-btn { display: flex; }
    .adm-mobile-brand-link { display: flex; }
    .adm-header-search-container { display: none; }
    .adm-mobile-search-trigger-btn { display: flex; }
    .adm-live-wa-pill { display: none; }
    .adm-hdr-user-text { display: none; }
    .adm-btn-text { display: none; }
    .adm-btn-secondary span:not(.adm-btn-text) { display: none; }
}
@media (max-width: 600px) {
    .adm-btn-secondary { display: none; }
    .adm-hdr-btn:not(#admClearCacheBtn) { display: none; }
}
/* Spin animation for cache clear */
@keyframes spin { to { transform: rotate(360deg); } }
</style>
<header class="adm-header" id="admHeaderMain">
    <!-- ══ Normal Header View (Desktop & Mobile Default) ══ -->
    <div class="adm-header-normal-view">
        <div class="adm-header-left">
            <!-- Mobile Toggle Hamburger Button -->
            <button type="button" class="adm-mobile-menu-btn" id="admMobileMenuBtn" onclick="if(typeof window.toggleAdmMobileSidebar==='function') window.toggleAdmMobileSidebar(event);" title="Toggle Navigation Menu">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.4" fill="none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>

            <!-- Mobile Brand Logo Link -->
            <a href="/admin" class="adm-mobile-brand-link" title="DT Brand's Admin CRM">
                <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/Shared/Asset/images/logo.png';" alt="DT Brand's" class="adm-mobile-logo-img">
                <span class="adm-mobile-brand-title">DT Brand's</span>
            </a>

            <!-- ── Clean Luxury Search Bar with Live Results Dropdown (Desktop) ── -->
            <div class="adm-header-search-container" id="admHeaderSearchContainer">
                <div class="adm-search-amazon-bar" id="admDesktopSearchBox">
                    <div class="adm-search-input-wrap">
                        <input type="text" id="admGlobalSearch" class="adm-search-input-amazon" placeholder="Search orders, sarees, customers, SKUs (e.g. KLN-SR-111)..." autocomplete="off" style="padding-left:14px;">
                        <button type="button" id="admGlobalSearchClear" class="adm-search-clear-btn" title="Clear Search">✕</button>
                    </div>

                    <button type="button" class="adm-search-submit-btn" id="admGlobalSearchSubmitBtn" aria-label="Search" onclick="if(typeof window.executeGlobalSearch==='function') window.executeGlobalSearch(document.getElementById('admGlobalSearch').value)">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </div>

                <!-- Next-Level Live Search Dropdown Popup List -->
                <div class="adm-live-search-dropdown" id="admGlobalSearchResults"></div>
            </div>
        </div>

        <div class="adm-header-right">
            <!-- Mobile Search Trigger Icon Button (Visible on <= 1024px) -->
            <button type="button" class="adm-mobile-search-trigger-btn" id="admMobileSearchTriggerBtn" onclick="window.openAdmMobileSearch()" title="Search Admin CRM">
                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.3" fill="none"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>

            <!-- Live WhatsApp CRM Status Indicator -->
            <div class="adm-live-wa-pill" title="WhatsApp Business Cloud Gateway Connected">
                <span class="adm-pulse-dot"></span>
                <span class="adm-wa-text">WhatsApp Live</span>
            </div>

            <!-- Fast Action: ⚡ Clear Cache & Purge Asset Memory -->
            <button type="button" class="adm-hdr-btn" id="admClearCacheBtn" onclick="window.dtAutoClearCache()" title="Purge Cache & Reload Fresh Assets">
                <svg viewBox="0 0 24 24" width="15" height="15" stroke="currentColor" stroke-width="2.2" fill="none"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
            </button>

            <!-- Notification Bell -->
            <button type="button" class="adm-hdr-btn" title="Notifications" onclick="if(typeof window.showToast==='function') window.showToast('🔔 3 new wholesale orders received today!')">
                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.2" fill="none"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <span class="adm-hdr-badge">3</span>
            </button>

            <!-- Fast Action: + Add Product -->
            <a href="/admin/products/add.php" class="adm-btn-primary" title="Add Product">
                <svg viewBox="0 0 24 24" width="13" height="13" stroke="#181512" stroke-width="2.8" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span class="adm-btn-text">Add Product</span>
            </a>

            <!-- Fast Action: Broadcast -->
            <button type="button" class="adm-btn-secondary" onclick="if(typeof switchAdmTab==='function') switchAdmTab('whatsapp'); else window.location.href = '/admin/whatsapp/';" title="Broadcast">
                <svg viewBox="0 0 24 24" width="13" height="13" stroke="currentColor" stroke-width="2.2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                <span>Broadcast</span>
            </button>

            <!-- Admin Profile Dropdown Container -->
            <div class="adm-hdr-profile-wrap" id="admHdrProfileWrap">
                <button type="button" class="adm-hdr-profile" id="admHdrProfileBtn" onclick="window.toggleAdmProfileDropdown(event);" title="Account & Session Menu" aria-haspopup="true" aria-expanded="false">
                    <img src="/assets/images/profile.png" onerror="this.src='/assets/images/product1.png';" alt="Gautam Sethi" class="adm-hdr-avatar">
                    <div class="adm-hdr-user-text">
                        <span class="adm-hdr-name">Gautam Sethi</span>
                        <span class="adm-hdr-title">Super Admin</span>
                    </div>
                    <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor" stroke-width="2.2" fill="none" class="adm-hdr-caret" id="admHdrProfileCaret"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>

                <!-- Next-Level Luxury Profile Dropdown Menu -->
                <div class="adm-profile-dropdown-menu" id="admProfileDropdownMenu" style="display: none;">
                    <div class="adm-dd-header">
                        <img src="/assets/images/profile.png" onerror="this.src='/assets/images/product1.png';" alt="Gautam Sethi" class="adm-dd-avatar">
                        <div class="adm-dd-identity">
                            <div class="adm-dd-name">Gautam Sethi</div>
                            <div class="adm-dd-email">admin@dtbrand.in</div>
                            <div class="adm-dd-badge">👑 Super Admin</div>
                        </div>
                    </div>
                    
                    <div class="adm-dd-divider"></div>

                    <ul class="adm-dd-nav-list">
                        <li>
                            <a href="/admin/settings/" class="adm-dd-item" onclick="if(typeof switchAdmTab==='function'){ switchAdmTab('settings'); window.closeAdmProfileDropdown(); return false; }">
                                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2.2" fill="none"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                <span>Store Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/users/" class="adm-dd-item" onclick="if(typeof switchAdmTab==='function'){ switchAdmTab('users'); window.closeAdmProfileDropdown(); return false; }">
                                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2.2" fill="none"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                                <span>Admin Users &amp; Roles</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/" class="adm-dd-item" onclick="if(typeof switchAdmTab==='function'){ switchAdmTab('system'); window.closeAdmProfileDropdown(); return false; }">
                                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2.2" fill="none"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <span>System Health &amp; Logs</span>
                            </a>
                        </li>
                        <li>
                            <a href="/" target="_blank" class="adm-dd-item">
                                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2.2" fill="none"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                <span>View Live Storefront</span>
                            </a>
                        </li>
                    </ul>

                    <div class="adm-dd-divider"></div>

                    <div class="adm-dd-footer">
                        <button type="button" class="adm-dd-logout-btn" id="admDdLogoutBtn" onclick="window.dtAdminLogout(event);">
                            <svg viewBox="0 0 24 24" width="15" height="15" stroke="currentColor" stroke-width="2.3" fill="none">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span>Sign Out of Admin</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ Mobile Full-Header Search Bar Overlay (Exact Shop Page Header Style) ══ -->
    <div class="adm-mobile-full-search-bar" id="admMobileFullSearchBar">
        <div class="adm-mobile-search-input-wrap">
            <input type="text" id="admMobileGlobalSearch" class="adm-mobile-search-input-field" placeholder="Search orders, sarees, customers, SKUs..." autocomplete="off" style="padding-left:14px;">
            <button type="button" id="admMobileGlobalSearchClear" class="adm-mobile-search-clear-btn" title="Clear Search">✕</button>
        </div>
        <button type="button" class="adm-mobile-search-close-btn" onclick="window.closeAdmMobileSearch()" title="Close Search">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <!-- Mobile Live Search Dropdown Popup List -->
        <div class="adm-mobile-live-search-dropdown" id="admMobileGlobalSearchResults"></div>
    </div>
</header>

<!-- ══ Master Admin Logout Confirmation Modal ══ -->
<div class="adm-logout-modal-backdrop" id="dtAdminLogoutModalBackdrop" role="dialog" aria-modal="true" aria-labelledby="admLogoutTitle" style="display: none;">
    <div class="adm-logout-modal-card">
        <div class="adm-logout-modal-icon-wrap">
            <svg viewBox="0 0 24 24" width="28" height="28" stroke="#DC2626" stroke-width="2.4" fill="none">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
        </div>
        <h3 class="adm-logout-modal-title" id="admLogoutTitle">Sign Out of Admin Console?</h3>
        <p class="adm-logout-modal-desc">Are you sure you want to end your executive session? You will be redirected to the secure login gateway.</p>
        <div class="adm-logout-modal-actions">
            <button type="button" class="adm-logout-cancel-btn" onclick="window.closeDtLogoutModal()">Cancel</button>
            <button type="button" class="adm-logout-confirm-btn" id="admLogoutConfirmBtn" onclick="window.dtExecuteAdminLogout()">
                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2.4" fill="none">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Yes, Sign Out</span>
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    // Fallback Mock Data for Universal Global Search across all Admin pages
    window.DT_GLOBAL_PRODS = [
        { id: 111, sku: 'KLN-SR-111', name: 'Pure Dola Silk Meenakari Saree', category: 'Sarees', wholesale_price: 1399, retail_price: 3499, stock: 95, image: '/assets/images/product2.png' },
        { id: 109, sku: 'KLN-KT-109', name: 'Party Festive Sharara Suit Set', category: 'Kurtis', wholesale_price: 989, retail_price: 2699, stock: 125, image: '/assets/images/product5.png' },
        { id: 110, sku: 'KLN-SR-110', name: 'Paithani Rich Pallu Saree', category: 'Sarees', wholesale_price: 1249, retail_price: 3199, stock: 110, image: '/assets/images/product1.png' },
        { id: 106, sku: 'KLN-SR-106', name: 'Chanderi Silk Festive Saree', category: 'Sarees', wholesale_price: 649, retail_price: 1599, stock: 190, image: '/assets/images/product1.png' },
        { id: 6,   sku: 'KLN-LH-006', name: 'Bridal Zardosi Lehenga Set', category: 'Lehengas', wholesale_price: 16499, retail_price: 24999, stock: 35, image: '/assets/images/product6.png' },
        { id: 114, sku: 'KLN-GW-114', name: 'Indo-Western Embroidered Gown', category: 'Gowns', wholesale_price: 1999, retail_price: 4599, stock: 65, image: '/assets/images/product6.png' },
        { id: 116, sku: 'KLN-DM-116', name: 'Pure Cotton Unstitched Suit Lot', category: 'Dress Materials', wholesale_price: 599, retail_price: 1499, stock: 180, image: '/assets/images/product3.png' }
    ];

    window.DT_GLOBAL_ORDERS = [
        { id: 'DTB-001620', customer: 'Surat Central Depot (Wholesale Consignee)', city: 'Surat, Gujarat', amount: 54900, status: 'Processing' },
        { id: 'ORD-9842',   customer: 'Shree Balaji Sarees (Kolkata Wholesaler)', city: 'Kolkata, WB', amount: 62450, status: 'Processing' },
        { id: 'DTB-001624', customer: 'Kalyan Brocade Hub (Bangalore Depot)', city: 'Bangalore, KA', amount: 38200, status: 'Delivered' },
        { id: 'DTB-001618', customer: 'Mahalakshmi Silk Mart (Varanasi)', city: 'Varanasi, UP', amount: 48900, status: 'Delivered' }
    ];

    window.DT_GLOBAL_PARTNERS = [
        { name: 'Kalyan Brocade Hub', city: 'Surat / Bangalore', phone: '+91 70463 63528', tier: 'Verified Wholesaler' },
        { name: 'Shree Balaji Sarees', city: 'Kolkata Central Market', phone: '+91 70463 63528', tier: 'Gold Distributor' },
        { name: 'Radha Krishna Silks', city: 'Ahmedabad Ring Road', phone: '+91 70463 63528', tier: 'VIP Partner' }
    ];

    // ════ ⚡ UNIVERSAL AUTO CLEAR CACHE ENGINE ════
    window.dtAutoClearCache = function() {
        try {
            // 1. Clear Web Application Cache Storage
            if ('caches' in window) {
                caches.keys().then(function(cacheNames) {
                    return Promise.all(cacheNames.map(function(cName) { return caches.delete(cName); }));
                });
            }
            // 2. Clear Session Storage
            sessionStorage.clear();

            // 3. Clear transient Local Storage while preserving sidebar toggle pref
            const savedSidebarPref = localStorage.getItem('dt_adm_sidebar_collapsed');
            localStorage.clear();
            if (savedSidebarPref !== null) {
                localStorage.setItem('dt_adm_sidebar_collapsed', savedSidebarPref);
            }
            localStorage.setItem('dt_cache_bust', Date.now().toString());

            // 4. Show Instant Feedback Toast
            if (typeof window.showToast === 'function') {
                window.showToast('🧹 Cache successfully purged! Reloading fresh assets...');
            }

            // 5. Force Browser to Request Fresh Uncached Assets with Timestamp
            setTimeout(() => {
                const url = new URL(window.location.href);
                url.searchParams.set('v_fresh', Date.now().toString());
                window.location.href = url.toString();
            }, 350);
        } catch(err) {
            console.error('Cache purge error:', err);
            window.location.reload();
        }
    };

    window.openAdmMobileSearch = function() {
        const header = document.getElementById('admHeaderMain') || document.querySelector('.adm-header');
        if (header) {
            header.classList.add('mobile-search-active');
            setTimeout(() => {
                const input = document.getElementById('admMobileGlobalSearch');
                if (input) {
                    input.focus();
                    input.select();
                }
            }, 60);
        }
    };

    window.closeAdmMobileSearch = function() {
        const header = document.getElementById('admHeaderMain') || document.querySelector('.adm-header');
        if (header) {
            header.classList.remove('mobile-search-active');
            const input = document.getElementById('admMobileGlobalSearch');
            if (input) input.value = '';
            const clearBtn = document.getElementById('admMobileGlobalSearchClear');
            if (clearBtn) clearBtn.style.display = 'none';
            const res = document.getElementById('admMobileGlobalSearchResults');
            if (res) res.style.display = 'none';
        }
    };

    window.handleAdmHeaderLiveSearch = function(query, isMobile) {
        const targetContainer = isMobile 
            ? document.getElementById('admMobileGlobalSearchResults') 
            : document.getElementById('admGlobalSearchResults');

        if (!targetContainer) return;

        if (!query || query.trim().length === 0) {
            targetContainer.style.display = 'none';
            targetContainer.innerHTML = '';
            return;
        }

        const q = query.trim().toLowerCase();
        const prods = (window.products || window.DT_GLOBAL_PRODS || []).filter(p => 
            (p.name && p.name.toLowerCase().includes(q)) || 
            (p.sku && p.sku.toLowerCase().includes(q)) ||
            (p.category && p.category.toLowerCase().includes(q))
        ).slice(0, 4);

        const ords = (window.orders || window.DT_GLOBAL_ORDERS || []).filter(o => 
            (o.id && o.id.toLowerCase().includes(q)) || 
            (o.customer && o.customer.toLowerCase().includes(q)) ||
            (o.city && o.city.toLowerCase().includes(q))
        ).slice(0, 3);

        const parts = (window.partners || window.DT_GLOBAL_PARTNERS || []).filter(pt => 
            (pt.name && pt.name.toLowerCase().includes(q)) || 
            (pt.city && pt.city.toLowerCase().includes(q)) ||
            (pt.phone && pt.phone.toLowerCase().includes(q))
        ).slice(0, 3);

        const totalMatches = prods.length + ords.length + parts.length;

        if (totalMatches === 0) {
            targetContainer.innerHTML = `
                <div class="adm-live-search-empty">
                    <div style="font-size:22px; margin-bottom:6px;">🔍</div>
                    <div style="font-weight:700; color:#181512; margin-bottom:3px;">No direct records for "${query}"</div>
                    <div style="font-size:11px; color:#64748B;">Try searching <i>Saree</i>, <i>KLN-SR-111</i>, or <i>DTB-001620</i>.</div>
                </div>
            `;
            targetContainer.style.display = 'block';
            return;
        }

        let html = `
            <div class="adm-live-search-header">
                <span>🔍 Live Results for "<b>${query}</b>"</span>
                <span class="adm-live-search-count-badge">${totalMatches} Record${totalMatches === 1 ? '' : 's'}</span>
            </div>
        `;

        if (prods.length > 0) {
            html += `
                <div class="adm-live-search-group">
                    <div class="adm-live-search-group-title">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>Products &amp; SKUs (${prods.length})</span>
                    </div>
            `;
            prods.forEach(p => {
                html += `
                    <div class="adm-live-search-item" onclick="window.selectSearchProduct('${p.id}', '${p.sku}')">
                        <img src="${p.image}" onerror="this.src='/assets/images/product1.png';" alt="${p.name}" class="adm-live-search-thumb">
                        <div class="adm-live-search-info">
                            <div class="adm-live-search-title">${p.name}</div>
                            <div class="adm-live-search-sub">
                                <span style="font-weight:700; color:#8A681F;">${p.sku}</span>
                                <span>•</span>
                                <span>${p.category}</span>
                                <span>•</span>
                                <span style="color:#15803D; font-weight:700;">₹${(p.wholesale_price || 0).toLocaleString()} (Wholesale)</span>
                            </div>
                        </div>
                        <span class="adm-live-search-badge" style="background:#DCFCE7; color:#15803D; border:1px solid #BBF7D0;">${p.stock} in Stock</span>
                    </div>
                `;
            });
            html += `</div>`;
        }

        if (ords.length > 0) {
            html += `
                <div class="adm-live-search-group">
                    <div class="adm-live-search-group-title">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Wholesale Orders (${ords.length})</span>
                    </div>
            `;
            ords.forEach(o => {
                const statusColor = o.status === 'Delivered' ? '#15803D' : (o.status === 'Processing' ? '#B45309' : '#1D4ED8');
                const statusBg = o.status === 'Delivered' ? '#DCFCE7' : (o.status === 'Processing' ? '#FEF3C7' : '#EFF6FF');
                html += `
                    <div class="adm-live-search-item" onclick="window.selectSearchOrder('${o.id}')">
                        <div class="adm-live-search-avatar" style="border-radius:6px; font-size:10px;">📦</div>
                        <div class="adm-live-search-info">
                            <div class="adm-live-search-title">Order #${o.id} — ${o.customer}</div>
                            <div class="adm-live-search-sub">
                                <span>${o.city || 'Surat Central Depot'}</span>
                                <span>•</span>
                                <span style="font-weight:700; color:#181512;">₹${(o.amount || 0).toLocaleString()}</span>
                            </div>
                        </div>
                        <span class="adm-live-search-badge" style="background:${statusBg}; color:${statusColor}; border:1px solid ${statusColor}33;">${o.status}</span>
                    </div>
                `;
            });
            html += `</div>`;
        }

        if (parts.length > 0) {
            html += `
                <div class="adm-live-search-group">
                    <div class="adm-live-search-group-title">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>Wholesalers &amp; Partners (${parts.length})</span>
                    </div>
            `;
            parts.forEach(pt => {
                const initials = pt.name ? pt.name.split(' ').map(w => w[0]).join('').substring(0,2).toUpperCase() : 'PT';
                html += `
                    <div class="adm-live-search-item" onclick="window.selectSearchPartner('${pt.name}')">
                        <div class="adm-live-search-avatar">${initials}</div>
                        <div class="adm-live-search-info">
                            <div class="adm-live-search-title">${pt.name}</div>
                            <div class="adm-live-search-sub">
                                <span>${pt.city}</span>
                                <span>•</span>
                                <span>${pt.phone}</span>
                            </div>
                        </div>
                        <span class="adm-live-search-badge" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">${pt.tier || 'Verified Wholesaler'}</span>
                    </div>
                `;
            });
            html += `</div>`;
        }

        html += `
            <div class="adm-live-search-footer">
                <span>Click any record to open</span>
                <span style="color:#8A681F; font-weight:800; cursor:pointer;" onclick="window.executeGlobalSearch('${query}')">View in CRM ➔</span>
            </div>
        `;

        targetContainer.innerHTML = html;
        targetContainer.style.display = 'block';
    };

    window.selectSearchProduct = function(prodId, sku) {
        hideAllLiveSearchResults();
        if (typeof window.switchAdmTab === 'function') {
            window.switchAdmTab('products');
            const searchBox = document.getElementById('admProdSearch');
            if (searchBox) {
                searchBox.value = sku || '';
                if (typeof filterProducts === 'function') filterProducts();
            }
        } else {
            window.location.href = `/admin/admin.php#products`;
        }
        if (window.showToast) window.showToast(`👗 Navigated to Product SKU: ${sku}`);
    };

    window.selectSearchOrder = function(orderId) {
        hideAllLiveSearchResults();
        window.location.href = `/admin/orders/view.php?id=${encodeURIComponent(orderId)}`;
    };

    window.selectSearchPartner = function(partnerName) {
        hideAllLiveSearchResults();
        if (typeof window.switchAdmTab === 'function') {
            window.switchAdmTab('partners');
            const searchBox = document.getElementById('admPartnerSearch');
            if (searchBox) {
                searchBox.value = partnerName || '';
                if (typeof filterPartners === 'function') filterPartners();
            }
        } else {
            window.location.href = `/admin/admin.php#partners`;
        }
        if (window.showToast) window.showToast(`👤 Navigated to Partner: ${partnerName}`);
    };

    window.executeGlobalSearch = function(query) {
        hideAllLiveSearchResults();
        if (!query || !query.trim()) return;
        const q = query.trim().toLowerCase();

        // Check matching order ID
        const ords = (window.orders || window.DT_GLOBAL_ORDERS || []);
        const foundOrder = ords.find(o => o.id.toLowerCase().includes(q) || o.customer.toLowerCase().includes(q));
        if (foundOrder) {
            window.location.href = `/admin/orders/view.php?id=${encodeURIComponent(foundOrder.id)}`;
            return;
        }

        // Check products
        const prods = (window.products || window.DT_GLOBAL_PRODS || []);
        const foundProd = prods.find(p => p.name.toLowerCase().includes(q) || p.sku.toLowerCase().includes(q));
        if (foundProd) {
            if (typeof window.switchAdmTab === 'function') {
                window.switchAdmTab('products');
                const searchBox = document.getElementById('admProdSearch');
                if (searchBox) {
                    searchBox.value = query;
                    if (typeof filterProducts === 'function') filterProducts();
                }
            } else {
                window.location.href = `/admin/admin.php#products`;
            }
            return;
        }

        // Default redirect to Orders or Admin
        if (typeof window.switchAdmTab === 'function') {
            window.switchAdmTab('orders');
            const searchBox = document.getElementById('admOrderSearch');
            if (searchBox) {
                searchBox.value = query;
                if (typeof filterOrders === 'function') filterOrders();
            }
        } else {
            window.location.href = `/admin/orders/view.php?id=DTB-001620`;
        }
    };

    function hideAllLiveSearchResults() {
        const d = document.getElementById('admGlobalSearchResults');
        if (d) d.style.display = 'none';
        const md = document.getElementById('admMobileGlobalSearchResults');
        if (md) md.style.display = 'none';
    }

    // Auto-setup listeners when DOM is loaded
    function setupHeaderSearchEngine() {
        const desktopInput = document.getElementById('admGlobalSearch');
        const desktopClear = document.getElementById('admGlobalSearchClear');
        const mobileInput = document.getElementById('admMobileGlobalSearch');
        const mobileClear = document.getElementById('admMobileGlobalSearchClear');

        if (desktopInput) {
            desktopInput.addEventListener('input', function() {
                if (desktopClear) desktopClear.style.display = this.value.trim() ? 'flex' : 'none';
                window.handleAdmHeaderLiveSearch(this.value, false);
            });
            desktopInput.addEventListener('focus', function() {
                if (this.value.trim().length > 0) window.handleAdmHeaderLiveSearch(this.value, false);
            });
            desktopInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    window.executeGlobalSearch(this.value);
                }
            });
        }

        if (desktopClear) {
            desktopClear.addEventListener('click', function() {
                if (desktopInput) {
                    desktopInput.value = '';
                    desktopClear.style.display = 'none';
                    desktopInput.focus();
                    window.handleAdmHeaderLiveSearch('', false);
                }
            });
        }

        if (mobileInput) {
            mobileInput.addEventListener('input', function() {
                if (mobileClear) mobileClear.style.display = this.value.trim() ? 'flex' : 'none';
                window.handleAdmHeaderLiveSearch(this.value, true);
            });
            mobileInput.addEventListener('focus', function() {
                if (this.value.trim().length > 0) window.handleAdmHeaderLiveSearch(this.value, true);
            });
            mobileInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    window.executeGlobalSearch(this.value);
                }
            });
        }

        if (mobileClear) {
            mobileClear.addEventListener('click', function() {
                if (mobileInput) {
                    mobileInput.value = '';
                    mobileClear.style.display = 'none';
                    mobileInput.focus();
                    window.handleAdmHeaderLiveSearch('', true);
                }
            });
        }

        // Dismiss on Click outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#admHeaderSearchContainer') && !e.target.closest('#admMobileFullSearchBar')) {
                hideAllLiveSearchResults();
            }
        });

        // Dismiss on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideAllLiveSearchResults();
                window.closeAdmMobileSearch();
                window.closeAdmProfileDropdown();
                window.closeDtLogoutModal();
            }
        });
    }

    // ════ 👑 PROFILE DROPDOWN & LOGOUT MODAL CONTROLLERS ════
    window.toggleAdmProfileDropdown = function(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        const menu = document.getElementById('admProfileDropdownMenu');
        const btn = document.getElementById('admHdrProfileBtn');
        const caret = document.getElementById('admHdrProfileCaret');
        if (!menu) return;

        const isOpen = menu.style.display === 'block';
        if (isOpen) {
            window.closeAdmProfileDropdown();
        } else {
            menu.style.display = 'block';
            if (btn) btn.setAttribute('aria-expanded', 'true');
            if (caret) caret.style.transform = 'rotate(180deg)';
        }
    };

    window.closeAdmProfileDropdown = function() {
        const menu = document.getElementById('admProfileDropdownMenu');
        const btn = document.getElementById('admHdrProfileBtn');
        const caret = document.getElementById('admHdrProfileCaret');
        if (menu) menu.style.display = 'none';
        if (btn) btn.setAttribute('aria-expanded', 'false');
        if (caret) caret.style.transform = 'rotate(0deg)';
    };

    window.dtAdminLogout = function(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        window.closeAdmProfileDropdown();
        const modal = document.getElementById('dtAdminLogoutModalBackdrop');
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else {
            window.dtExecuteAdminLogout();
        }
    };

    window.closeDtLogoutModal = function() {
        const modal = document.getElementById('dtAdminLogoutModalBackdrop');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    };

    window.dtExecuteAdminLogout = function() {
        const confirmBtn = document.getElementById('admLogoutConfirmBtn');
        if (confirmBtn) {
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<span style="display:inline-block;animation:spin 1s linear infinite;margin-right:6px;">↻</span> Signing out...';
        }

        // 1. Clear credentials and session tokens from storage
        try {
            sessionStorage.clear();
            localStorage.removeItem('dt_admin_token');
            localStorage.removeItem('dt_admin_user');
            localStorage.removeItem('dt_auth_session');
        } catch(e) {}

        // 2. Call backend logout endpoint
        fetch('/admin/logout.php', { method: 'POST' })
            .catch(() => {})
            .finally(() => {
                window.location.href = '/admin/login/?logged_out=1';
            });
    };

    // Close modal or dropdown on Click outside
    document.addEventListener('click', function(e) {
        const wrap = document.getElementById('admHdrProfileWrap');
        if (wrap && !wrap.contains(e.target)) {
            window.closeAdmProfileDropdown();
        }
        const modal = document.getElementById('dtAdminLogoutModalBackdrop');
        if (modal && e.target === modal) {
            window.closeDtLogoutModal();
        }
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupHeaderSearchEngine);
    } else {
        setupHeaderSearchEngine();
    }
})();
</script>

