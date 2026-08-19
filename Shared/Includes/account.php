<?php
/**
 * account.php — Luxury Account & Authentication Modal Component
 * Ultra-Luxury High-Fashion Styling with Curved Segmented Tab Pill Bar,
 * Enhanced Typography, Vector Input Icons, Autofill CSS Fix, Show/Hide Password Eye Toggle,
 * Searchable World Countries & States Dropdowns, Animated Vector SVG Role Cards, and Auto Role Dashboard Redirect
 * 100% Fluid Responsive for Desktop & Mobile
 */
?>
<style>
/* ── Account Modal Tokens ── */
:root {
    --ac-gold-primary: #8A681F;
    --ac-gold-hover: #A8832A;
    --ac-gold-deep: #583F0F;
    --ac-gold-light: #C5A859;
    --ac-gold-pale: #FAF5E8;
    --ac-gold-border: rgba(138, 104, 31, 0.28);
    --ac-dark-text: #181512;
    --ac-mid-text: #484136;
    --ac-light-text: #736C61;
    --ac-soft-platinum: #DDD7CB;
    --ac-cream-bg: #FFFFFF;
}

/* ── Modal Backdrop ── */
.account-modal-backdrop {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(16, 12, 8, 0.85);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    z-index: 1000001;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.28s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.28s ease;
    padding: clamp(10px, 3vw, 20px);
    box-sizing: border-box;
}
.account-modal-backdrop.active {
    opacity: 1;
    visibility: visible;
}

/* ── Account Dialog (Curved Luxury Card & Smart Auto Sizing) ── */
.account-dialog {
    background: #FAFDFC;
    width: 100%;
    max-width: 460px;
    max-height: 94vh;
    border-radius: 20px;
    border: 2px solid var(--ac-gold-primary);
    box-shadow: 0 24px 70px rgba(0,0,0,0.42), 0 0 0 1px rgba(255,255,255,0.4) inset;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transform: translateY(18px) scale(0.97);
    transition: transform 0.30s cubic-bezier(0.34, 1.56, 0.64, 1);
    font-family: var(--font-sans, 'Inter', -apple-system, BlinkMacSystemFont, sans-serif);
    color: var(--ac-dark-text);
}
.account-modal-backdrop.active .account-dialog {
    transform: translateY(0) scale(1);
}

/* ── Dialog Header ── */
.ac-header {
    background: linear-gradient(135deg, #FAF4E6 0%, #F6EBCE 50%, #FAF5EA 100%);
    border-bottom: 1.5px solid var(--ac-gold-border);
    padding: 13px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
    position: relative;
}
.ac-header::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent 0%, #C5A859 30%, var(--ac-gold-primary) 50%, #C5A859 70%, transparent 100%);
}
.ac-brand-group {
    display: flex;
    align-items: center;
    gap: 10px;
}
.ac-title-wrap h3 {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: clamp(0.98rem, 3.2vw, 1.15rem);
    font-weight: 800;
    color: var(--ac-gold-primary);
    margin: 0;
    letter-spacing: 0.04em;
    line-height: 1.2;
}
.ac-title-wrap span {
    font-size: 0.60rem;
    color: var(--ac-mid-text);
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    display: block;
    margin-top: 2px;
}
.ac-close-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1.5px solid var(--ac-gold-primary);
    background: #FAF8F4;
    color: var(--ac-gold-primary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 700;
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.ac-close-btn:hover {
    background: var(--ac-gold-primary);
    color: #FFFFFF;
    transform: rotate(90deg);
}

/* ── Modern Curved Segmented Pill Tabs (LOGIN | REGISTER) ── */
.ac-tabs-wrapper {
    padding: 12px 18px 0;
    background: #FAF8F4;
    flex-shrink: 0;
}
.ac-nav-tabs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: #EFE7D5;
    border-radius: 30px;
    padding: 4px;
    border: 1.2px solid var(--ac-gold-border);
    position: relative;
}
.ac-nav-tab {
    width: 100%;
    padding: 9px 12px;
    background: transparent;
    border: none;
    border-radius: 26px;
    font-family: var(--font-sans);
    font-size: 0.82rem;
    font-weight: 800;
    color: #635A4D;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    text-align: center;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.ac-nav-tab:hover {
    color: var(--ac-gold-primary);
}
.ac-nav-tab.active {
    background: linear-gradient(135deg, #B8973E 0%, #8A681F 50%, #634912 100%);
    color: #FFFFFF;
    box-shadow: 0 4px 12px rgba(138, 104, 31, 0.32);
    transform: scale(1.01);
}

/* ── Content Panes & Scrollable Body ── */
.ac-body {
    padding: 16px 18px 20px;
    overflow-y: auto;
    flex: 1;
    scrollbar-width: thin;
    scrollbar-color: var(--ac-gold-light) #FAF6EE;
}
.ac-body::-webkit-scrollbar {
    width: 5px;
}
.ac-body::-webkit-scrollbar-track {
    background: #FAF6EE;
}
.ac-body::-webkit-scrollbar-thumb {
    background: var(--ac-gold-light);
    border-radius: 4px;
}

.ac-pane {
    display: none;
    flex-direction: column;
    gap: 12px;
    animation: acPaneFade 0.22s cubic-bezier(0.16, 1, 0.3, 1);
}
.ac-pane.active {
    display: flex;
}
@keyframes acPaneFade {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ── Form Controls & Typography ── */
.ac-form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
    position: relative;
}
.ac-label {
    font-size: 0.72rem;
    font-weight: 800;
    color: #383025;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ac-label .req { color: #C62828; font-weight: 900; font-size: 0.85rem; margin-left: 2px; }

/* Input Container with Vector Icon Support */
.ac-input-wrap {
    position: relative;
    width: 100%;
    display: flex;
    align-items: center;
}
.ac-input-icon {
    position: absolute;
    left: 12px;
    width: 17px;
    height: 17px;
    stroke: var(--ac-gold-primary);
    fill: none;
    stroke-width: 2;
    pointer-events: none;
    opacity: 0.85;
}
.ac-input {
    width: 100%;
    height: 44px;
    border: 1.8px solid var(--ac-soft-platinum);
    border-radius: 10px;
    padding: 0 13px;
    font-family: var(--font-sans);
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--ac-dark-text);
    background: #FFFFFF;
    outline: none;
    box-sizing: border-box;
    transition: all 0.2s ease;
}
.ac-input.has-icon {
    padding-left: 38px !important;
}
.ac-input::placeholder {
    color: var(--ac-light-text);
    font-weight: 500;
}
.ac-input:focus {
    border-color: var(--ac-gold-primary);
    box-shadow: 0 0 0 3.5px rgba(138,104,31,0.18);
    background: #FCFAF6;
}

/* Chrome Autofill Background Fix */
.ac-input:-webkit-autofill,
.ac-input:-webkit-autofill:hover,
.ac-input:-webkit-autofill:focus,
.ac-wa-input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px #FAF8F4 inset !important;
    -webkit-text-fill-color: var(--ac-dark-text) !important;
    transition: background-color 5000s ease-in-out 0s;
}

/* Password Field with Eye Toggle Button */
.ac-pass-wrap {
    position: relative;
    width: 100%;
    display: flex;
    align-items: center;
}
.ac-pass-input {
    padding-right: 42px !important;
}
.ac-eye-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--ac-gold-primary);
    cursor: pointer;
    padding: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: opacity 0.2s ease;
}
.ac-eye-btn:hover {
    opacity: 0.8;
}
.ac-eye-btn svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
}

/* Side-by-Side Grid for City & State */
.ac-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
@media (max-width: 480px) {
    .ac-grid-2 {
        grid-template-columns: 1fr;
    }
}

/* ── Custom Luxury Dropdown Select Component ── */
.ac-custom-select-box {
    position: relative;
    width: 100%;
}
.ac-custom-select-trigger {
    width: 100%;
    height: 44px;
    border: 1.8px solid var(--ac-soft-platinum);
    border-radius: 10px;
    padding: 0 13px;
    background: #FFFFFF;
    color: var(--ac-dark-text);
    font-size: 0.86rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: all 0.2s ease;
    user-select: none;
    box-sizing: border-box;
}
.ac-custom-select-trigger:hover,
.ac-custom-select-box.active .ac-custom-select-trigger {
    border-color: var(--ac-gold-primary);
    box-shadow: 0 0 0 3.5px rgba(138,104,31,0.18);
    background: #FCFAF6;
}
.ac-custom-select-val {
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ac-select-flag-img {
    width: 22px;
    height: 15px;
    object-fit: cover;
    border-radius: 3px;
    border: 1px solid rgba(0,0,0,0.12);
    flex-shrink: 0;
}
.ac-custom-select-arrow {
    width: 16px;
    height: 16px;
    stroke: var(--ac-gold-primary);
    stroke-width: 2.5;
    fill: none;
    transition: transform 0.2s ease;
    flex-shrink: 0;
}
.ac-custom-select-box.active .ac-custom-select-arrow {
    transform: rotate(180deg);
}

/* Dropdown Menu */
.ac-custom-select-menu {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    background: #FFFFFF;
    border: 2px solid var(--ac-gold-primary);
    border-radius: 12px;
    box-shadow: 0 14px 34px rgba(0,0,0,0.22);
    max-height: 200px;
    z-index: 1000005;
    display: none;
    flex-direction: column;
    overflow: hidden;
    animation: acDropFade 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.ac-custom-select-box.active .ac-custom-select-menu {
    display: flex;
}
@keyframes acDropFade {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
.ac-dropdown-search-box {
    padding: 6px 10px;
    background: #FAF6EE;
    border-bottom: 1.5px solid var(--ac-soft-platinum);
    flex-shrink: 0;
}
.ac-dropdown-search-input {
    width: 100%;
    height: 32px;
    border: 1.5px solid var(--ac-soft-platinum);
    border-radius: 6px;
    padding: 0 8px;
    font-family: var(--font-sans);
    font-size: 0.80rem;
    font-weight: 600;
    color: var(--ac-dark-text);
    outline: none;
    background: #FFFFFF;
    box-sizing: border-box;
}
.ac-dropdown-search-input:focus {
    border-color: var(--ac-gold-primary);
}
.ac-dropdown-options-scroll {
    overflow-y: auto;
    flex: 1;
    padding: 4px 0;
}
.ac-custom-select-option {
    padding: 8px 12px;
    font-size: 0.82rem;
    color: var(--ac-dark-text);
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.15s ease;
}
.ac-custom-select-option:hover {
    background: #FAF3E0;
    color: var(--ac-gold-primary);
    font-weight: 700;
    padding-left: 15px;
}
.ac-custom-select-option.selected {
    background: var(--ac-gold-primary);
    color: #FFFFFF;
    font-weight: 700;
}

/* ── Role Pill Buttons with Real Vector SVGs ── */
.ac-role-pill-group {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 7px;
    margin-top: 2px;
}
.ac-role-pill-btn {
    position: relative;
    padding: 9px 4px;
    border-radius: 10px;
    border: 1.8px solid var(--ac-soft-platinum);
    background: #FFFFFF;
    color: var(--ac-dark-text);
    font-family: var(--font-sans);
    font-size: 0.78rem;
    font-weight: 800;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    transition: all 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
    user-select: none;
    box-shadow: 0 2px 5px rgba(0,0,0,0.03);
}
.ac-role-pill-btn:hover {
    border-color: var(--ac-gold-primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(138,104,31,0.16);
}
.ac-role-pill-btn.selected {
    border-color: var(--ac-gold-primary);
    background: linear-gradient(135deg, #FAF4E5 0%, #F5E8C8 100%);
    color: var(--ac-gold-deep);
    box-shadow: 0 3px 12px rgba(138,104,31,0.22);
    transform: translateY(-1px);
}
.ac-role-pill-btn.selected::after {
    content: '✓';
    position: absolute;
    top: 3px;
    right: 3px;
    width: 13px;
    height: 13px;
    border-radius: 50%;
    background: var(--ac-gold-primary);
    color: #FFFFFF;
    font-size: 0.50rem;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ac-role-svg-icon {
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ac-role-svg-icon svg {
    width: 100%;
    height: 100%;
    display: block;
}

/* ── WhatsApp Phone Input with Auto Country Flag & Prefix ── */
.ac-wa-group {
    display: flex;
    border: 1.8px solid var(--ac-soft-platinum);
    border-radius: 10px;
    background: #FFFFFF;
    overflow: hidden;
    transition: all 0.2s ease;
}
.ac-wa-group:focus-within {
    border-color: var(--ac-gold-primary);
    box-shadow: 0 0 0 3.5px rgba(138,104,31,0.18);
}
.ac-wa-group.is-invalid {
    border-color: #C62828 !important;
    box-shadow: 0 0 0 3.5px rgba(198,40,40,0.18) !important;
}
.ac-wa-prefix {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 0 9px;
    background: #EFE8D6;
    border-right: 1.8px solid var(--ac-soft-platinum);
    font-size: 0.80rem;
    font-weight: 800;
    color: var(--ac-gold-primary);
    flex-shrink: 0;
    user-select: none;
}
.ac-wa-flag-img-preview {
    width: 20px;
    height: 14px;
    object-fit: cover;
    border-radius: 2px;
    border: 1px solid rgba(0,0,0,0.12);
}
.ac-wa-input {
    flex: 1;
    height: 44px;
    border: none;
    outline: none;
    background: transparent;
    padding: 0 11px;
    font-family: var(--font-sans);
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--ac-dark-text);
    width: 100%;
    box-sizing: border-box;
}
.ac-val-err {
    font-size: 0.68rem;
    color: #C62828;
    font-weight: 700;
    display: none;
    margin-top: 2px;
}

/* ── Primary Action Buttons (Luxury Gradient & Elevation) ── */
.ac-btn-primary {
    width: 100%;
    height: 48px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #B8973E 0%, #8A681F 50%, #634912 100%);
    color: #FFFFFF;
    font-family: var(--font-sans);
    font-size: clamp(0.84rem, 2.2vw, 0.90rem);
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.22s ease;
    box-shadow: 0 6px 20px rgba(138, 104, 31, 0.32);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    margin-top: 6px;
}
.ac-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 26px rgba(138, 104, 31, 0.46);
    background: linear-gradient(135deg, #C5A859 0%, #9B7523 50%, #755616 100%);
}
.ac-btn-primary:active {
    transform: translateY(0);
}
.ac-btn-link {
    background: none;
    border: none;
    color: var(--ac-gold-primary);
    font-size: 0.76rem;
    font-weight: 800;
    cursor: pointer;
    text-decoration: underline;
    padding: 0;
    transition: color 0.2s ease;
}
.ac-btn-link:hover {
    color: var(--ac-gold-deep);
}
</style>

<!-- ════════════════════════════════════════════════════
     ACCOUNT MODAL POPUP (HTML STRUCTURE)
════════════════════════════════════════════════════ -->
<div class="account-modal-backdrop" id="accountModalBackdrop" role="dialog" aria-modal="true" aria-labelledby="acModalHeading">
    <div class="account-dialog" id="accountDialog">
        
        <!-- Header -->
        <div class="ac-header">
            <div class="ac-brand-group">
                <img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Shop/Asset/images/logo.png';" alt="DT Brand's" style="height:34px; width:auto; max-width:125px; object-fit:contain;">
                <div class="ac-title-wrap">
                    <h3 id="acModalHeading">Sign In</h3>
                    <span>Ethnic Luxury Couture</span>
                </div>
            </div>
            <button type="button" class="ac-close-btn" id="closeAccountModalBtn" aria-label="Close modal">✕</button>
        </div>

        <!-- Curved Segmented Tabs Wrapper (LOGIN | REGISTER) -->
        <div class="ac-tabs-wrapper">
            <div class="ac-nav-tabs" id="acNavTabs">
                <button type="button" class="ac-nav-tab active" id="acTabBtnLogin" data-tab="login" onclick="window.switchAccountTab('login')">
                    <svg style="width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    <span>LOGIN</span>
                </button>
                <button type="button" class="ac-nav-tab" id="acTabBtnRegister" data-tab="register" onclick="window.switchAccountTab('register')">
                    <svg style="width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2.2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    <span>REGISTER</span>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="ac-body">

                <!-- Role Selection for Login Portal -->
                <div class="ac-form-group" style="margin-bottom: 12px;">
                    <label class="ac-label">Select Business Portal <span class="req">*</span></label>
                    <div class="ac-role-pill-group" id="acLoginRoleGroup">
                        <!-- Retailer -->
                        <div class="ac-role-pill-btn selected" data-role="Retailer" onclick="window.selectModalRole('Retailer')">
                            <div class="ac-role-svg-icon">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" fill="#E3F2FD" stroke="#1976D2" stroke-width="2" stroke-linejoin="round"/>
                                    <line x1="3" y1="6" x2="21" y2="6" stroke="#1976D2" stroke-width="2"/>
                                    <path d="M16 10a4 4 0 0 1-8 0" stroke="#1976D2" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span>Retailer (Shop)</span>
                        </div>

                        <!-- Reseller -->
                        <div class="ac-role-pill-btn" data-role="Reseller" onclick="window.selectModalRole('Reseller')">
                            <div class="ac-role-svg-icon">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="7" width="20" height="14" rx="2" fill="#E8F5E9" stroke="#2E7D32" stroke-width="2"/>
                                    <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" stroke="#2E7D32" stroke-width="2"/>
                                    <line x1="12" y1="12" x2="12" y2="15" stroke="#2E7D32" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="2" y1="12" x2="22" y2="12" stroke="#2E7D32" stroke-width="1.5" stroke-dasharray="2 2"/>
                                </svg>
                            </div>
                            <span>Reseller (Home)</span>
                        </div>

                        <!-- Wholesaler -->
                        <div class="ac-role-pill-btn" data-role="Wholesaler" onclick="window.selectModalRole('Wholesaler')">
                            <div class="ac-role-svg-icon">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" fill="#FFF3E0" stroke="#E65100" stroke-width="2" stroke-linejoin="round"/>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" stroke="#E65100" stroke-width="2"/>
                                    <line x1="12" y1="22.08" x2="12" y2="12" stroke="#E65100" stroke-width="2"/>
                                </svg>
                            </div>
                            <span>Wholesaler</span>
                        </div>
                    </div>
                </div>

                <div class="ac-form-group">
                    <label class="ac-label" for="acLoginEmail">WhatsApp Number or Email <span class="req">*</span></label>
                    <div class="ac-input-wrap">
                        <svg class="ac-input-icon" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <input type="text" id="acLoginEmail" class="ac-input has-icon" placeholder="e.g. 9876543210 or radhika@example.com" autocomplete="username" required>
                    </div>
                </div>

                <div class="ac-form-group">
                    <label class="ac-label" for="acLoginPass">
                        <span>Password <span class="req">*</span></span>
                        <button type="button" class="ac-btn-link" onclick="window.switchAccountTab('forgot')">Forgot Password?</button>
                    </label>
                    <div class="ac-pass-wrap">
                        <svg class="ac-input-icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" id="acLoginPass" class="ac-input has-icon ac-pass-input" placeholder="Enter your password" autocomplete="current-password" required>
                        <button type="button" class="ac-eye-btn" onclick="window.toggleAcPassVisibility('acLoginPass', this)" aria-label="Toggle password visibility">
                            <svg class="eye-open" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-closed" style="display:none;" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>

                <button type="button" class="ac-btn-primary" onclick="window.handleAccountLogin()">
                    <svg style="width:19px;height:19px;stroke:currentColor;fill:none;stroke-width:2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    <span>Sign In & Open Dashboard</span>
                </button>

                <!-- 1-Tap Quick Demo Logins for Instant Testing -->
                <div style="margin-top: 14px; padding-top: 12px; border-top: 1px dashed var(--ac-gold-border, rgba(138,104,31,0.3));">
                    <div style="font-size: 0.70rem; font-weight: 800; color: var(--ac-gold-primary); text-transform: uppercase; letter-spacing: 0.08em; text-align: center; margin-bottom: 8px;">
                        ⚡ 1-Tap Quick Demo Access
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px;">
                        <button type="button" class="ac-demo-btn" onclick="window.quickDemoLogin('Retailer')" style="padding: 7px 4px; font-size: 0.72rem; font-weight: 800; border: 1.5px solid #1976D2; background: #F0F7FF; color: #1565C0; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;">
                            🏪 Retailer
                        </button>
                        <button type="button" class="ac-demo-btn" onclick="window.quickDemoLogin('Reseller')" style="padding: 7px 4px; font-size: 0.72rem; font-weight: 800; border: 1.5px solid #2E7D32; background: #F1F8F1; color: #1B5E20; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;">
                            💼 Reseller
                        </button>
                        <button type="button" class="ac-demo-btn" onclick="window.quickDemoLogin('Wholesaler')" style="padding: 7px 4px; font-size: 0.72rem; font-weight: 800; border: 1.5px solid #E65100; background: #FFF8E1; color: #BF360C; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;">
                            🏭 Wholesale
                        </button>
                    </div>
                </div>

                <div style="text-align:center; font-size:0.80rem; margin-top:10px; color:var(--ac-mid-text); font-weight:600;">
                    Don't have an account? <button type="button" class="ac-btn-link" onclick="window.switchAccountTab('register')">Register Now →</button>
                </div>
            </div>

            <!-- ════════ PANE 2: REGISTER (EXACT MYACCOUNT.PHP UI) ════════ -->
            <div class="ac-pane" id="acPaneRegister">
                
                <!-- Full Name -->
                <div class="ac-form-group">
                    <label class="ac-label" for="acRegName">Full Name <span class="req">*</span></label>
                    <div class="ac-input-wrap">
                        <svg class="ac-input-icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input type="text" id="acRegName" class="ac-input has-icon" placeholder="e.g. Rajan Mehta" required>
                    </div>
                </div>

                <!-- Country Dropdown (All World Countries with Search & Real Flags) -->
                <div class="ac-form-group">
                    <label class="ac-label">Country <span class="req">*</span></label>
                    <div class="ac-custom-select-box" id="acCountrySelectBox">
                        <div class="ac-custom-select-trigger" onclick="window.toggleAcDropdown('acCountrySelectBox')">
                            <div class="ac-custom-select-val" id="acSelectedCountryDisplay">
                                <img src="https://flagcdn.com/w40/in.png" alt="India" class="ac-select-flag-img" id="acDisplayCountryFlag">
                                <span id="acDisplayCountryText">India (+91)</span>
                            </div>
                            <svg class="ac-custom-select-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </div>
                        <div class="ac-custom-select-menu" id="acCountryDropdownMenu">
                            <div class="ac-dropdown-search-box">
                                <input type="text" id="acCountrySearchInput" class="ac-dropdown-search-input" placeholder="🔍 Search world country..." oninput="window.filterAcCountryOptions(this.value)" onclick="event.stopPropagation()">
                            </div>
                            <div class="ac-dropdown-options-scroll" id="acCountryOptionsList">
                                <!-- Populated dynamically by JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile / WhatsApp Number with Flag Prefix -->
                <div class="ac-form-group">
                    <label class="ac-label" for="acRegPhone">
                        <span>Mobile Number <span class="req">*</span></span>
                        <span id="acDigitCountHint" style="font-size:0.65rem; color:var(--ac-light-text); text-transform:none; font-weight:600;">10-digit number</span>
                    </label>
                    <div class="ac-wa-group" id="acWaGroup">
                        <div class="ac-wa-prefix">
                            <img id="acWaFlagImg" class="ac-wa-flag-img-preview" src="https://flagcdn.com/w40/in.png" alt="India Flag">
                            <span id="acWaDialCode">IN +91</span>
                        </div>
                        <input type="tel" id="acRegPhone" class="ac-wa-input" placeholder="10-digit number" maxlength="12" required autocomplete="tel" oninput="window.validateModalWhatsApp()">
                    </div>
                    <div class="ac-val-err" id="acValErr">⚠️ Please enter a valid 10-digit WhatsApp number.</div>
                </div>

                <!-- City & State Side-by-Side -->
                <div class="ac-grid-2">
                    <!-- City -->
                    <div class="ac-form-group">
                        <label class="ac-label" for="acRegCity">City <span class="req">*</span></label>
                        <input type="text" id="acRegCity" class="ac-input" placeholder="e.g. Surat" required value="Surat">
                    </div>

                    <!-- State Dropdown -->
                    <div class="ac-form-group">
                        <label class="ac-label">State <span class="req">*</span></label>
                        <div class="ac-custom-select-box" id="acStateSelectBox">
                            <div class="ac-custom-select-trigger" onclick="window.toggleAcDropdown('acStateSelectBox')">
                                <div class="ac-custom-select-val">
                                    <span id="acDisplayStateText">Maharashtra</span>
                                </div>
                                <svg class="ac-custom-select-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                            <div class="ac-custom-select-menu" id="acStateDropdownMenu">
                                <div class="ac-dropdown-search-box">
                                    <input type="text" id="acStateSearchInput" class="ac-dropdown-search-input" placeholder="🔍 Search state..." oninput="window.filterAcStateOptions(this.value)" onclick="event.stopPropagation()">
                                </div>
                                <div class="ac-dropdown-options-scroll" id="acStateOptionsList">
                                    <!-- Populated dynamically by JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Selection (Pills: Retailer, Wholesaler, Reseller with Real Vector SVG Icons) -->
                <div class="ac-form-group">
                    <label class="ac-label">Your Role <span class="req">*</span></label>
                    <div class="ac-role-pill-group">
                        <!-- Retailer -->
                        <div class="ac-role-pill-btn selected" data-role="Retailer" onclick="window.selectModalRole('Retailer')">
                            <div class="ac-role-svg-icon">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4H6z" fill="#E3F2FD" stroke="#1976D2" stroke-width="2" stroke-linejoin="round"/>
                                    <line x1="3" y1="6" x2="21" y2="6" stroke="#1976D2" stroke-width="2"/>
                                    <path d="M16 10a4 4 0 0 1-8 0" stroke="#1976D2" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span>Retailer</span>
                        </div>

                        <!-- Wholesaler -->
                        <div class="ac-role-pill-btn" data-role="Wholesaler" onclick="window.selectModalRole('Wholesaler')">
                            <div class="ac-role-svg-icon">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" fill="#FFF3E0" stroke="#E65100" stroke-width="2" stroke-linejoin="round"/>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" stroke="#E65100" stroke-width="2"/>
                                    <line x1="12" y1="22.08" x2="12" y2="12" stroke="#E65100" stroke-width="2"/>
                                </svg>
                            </div>
                            <span>Wholesaler</span>
                        </div>

                        <!-- Reseller -->
                        <div class="ac-role-pill-btn" data-role="Reseller" onclick="window.selectModalRole('Reseller')">
                            <div class="ac-role-svg-icon">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="7" width="20" height="14" rx="2" fill="#E8F5E9" stroke="#2E7D32" stroke-width="2"/>
                                    <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" stroke="#2E7D32" stroke-width="2"/>
                                    <line x1="12" y1="12" x2="12" y2="15" stroke="#2E7D32" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="2" y1="12" x2="22" y2="12" stroke="#2E7D32" stroke-width="1.5" stroke-dasharray="2 2"/>
                                </svg>
                            </div>
                            <span>Reseller</span>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="ac-form-group">
                    <label class="ac-label" for="acRegPass">Password <span class="req">*</span></label>
                    <div class="ac-pass-wrap">
                        <svg class="ac-input-icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" id="acRegPass" class="ac-input has-icon ac-pass-input" placeholder="Minimum 6 characters" required>
                        <button type="button" class="ac-eye-btn" onclick="window.toggleAcPassVisibility('acRegPass', this)" aria-label="Toggle password visibility">
                            <svg class="eye-open" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-closed" style="display:none;" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="button" class="ac-btn-primary" onclick="window.handleAccountRegister()">
                    <svg style="width:19px;height:19px;stroke:currentColor;fill:none;stroke-width:2.2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    <span>Create My Account</span>
                </button>

                <div style="text-align:center; font-size:0.80rem; margin-top:6px; color:var(--ac-mid-text); font-weight:600;">
                    Already have an account? <button type="button" class="ac-btn-link" onclick="window.switchAccountTab('login')">Sign In →</button>
                </div>

            </div>

            <!-- ════════ PANE 3: FORGOT PASSWORD ════════ -->
            <div class="ac-pane" id="acPaneForgot">
                <p style="font-size:0.80rem; color:var(--ac-mid-text); margin:0 0 6px 0; line-height:1.4; font-weight:500;">
                    Enter your registered WhatsApp Number or Email and we'll instantly send you a password reset link on WhatsApp.
                </p>

                <div class="ac-form-group">
                    <label class="ac-label" for="acForgotInput">WhatsApp Number / Email <span class="req">*</span></label>
                    <div class="ac-input-wrap">
                        <svg class="ac-input-icon" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <input type="text" id="acForgotInput" class="ac-input has-icon" placeholder="e.g. 9876543210 or radhika@example.com" required>
                    </div>
                </div>

                <button type="button" class="ac-btn-primary" onclick="window.handleAccountForgot()">
                    <svg style="width:19px;height:19px;stroke:currentColor;fill:none;stroke-width:2.2" viewBox="0 0 24 24"><path d="M22 2L11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    <span>Send Reset Link via WhatsApp</span>
                </button>

                <div style="text-align:center; font-size:0.80rem; margin-top:10px; color:var(--ac-mid-text); font-weight:600;">
                    Remembered your password? <button type="button" class="ac-btn-link" onclick="window.switchAccountTab('login')">← Back to Login</button>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- ════════════════════════════════════════════════════
     ACCOUNT JAVASCRIPT CONTROLLER
════════════════════════════════════════════════════ -->
<script>
(function() {
    'use strict';

    /* ── Complete All World Countries & All Indian States Database ── */
    var ALL_WORLD_COUNTRIES = [
        {
            code: 'in', name: 'India', flagImg: 'https://flagcdn.com/w40/in.png', dial: '+91', digits: 10,
            states: [
                'Maharashtra', 'Gujarat', 'Rajasthan', 'Delhi (NCT)', 'Karnataka', 
                'Tamil Nadu', 'Uttar Pradesh', 'West Bengal', 'Telangana', 'Kerala', 
                'Punjab', 'Andhra Pradesh', 'Madhya Pradesh', 'Bihar', 'Haryana', 
                'Odisha', 'Assam', 'Goa', 'Chhattisgarh', 'Himachal Pradesh', 
                'Jharkhand', 'Uttarakhand', 'Jammu & Kashmir', 'Chandigarh'
            ]
        },
        { code: 'ae', name: 'United Arab Emirates', flagImg: 'https://flagcdn.com/w40/ae.png', dial: '+971', digits: 9, states: ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Ras Al Khaimah', 'Fujairah', 'Umm Al Quwain'] },
        { code: 'us', name: 'United States', flagImg: 'https://flagcdn.com/w40/us.png', dial: '+1', digits: 10, states: ['California', 'Texas', 'New York', 'Florida', 'Illinois', 'New Jersey', 'Georgia', 'Washington', 'Ohio', 'Pennsylvania'] },
        { code: 'gb', name: 'United Kingdom', flagImg: 'https://flagcdn.com/w40/gb.png', dial: '+44', digits: 10, states: ['Greater London', 'England', 'Scotland', 'Wales', 'Northern Ireland', 'West Midlands', 'Manchester'] },
        { code: 'ca', name: 'Canada', flagImg: 'https://flagcdn.com/w40/ca.png', dial: '+1', digits: 10, states: ['Ontario', 'British Columbia', 'Quebec', 'Alberta', 'Manitoba', 'Saskatchewan'] },
        { code: 'au', name: 'Australia', flagImg: 'https://flagcdn.com/w40/au.png', dial: '+61', digits: 9, states: ['New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia'] },
        { code: 'sg', name: 'Singapore', flagImg: 'https://flagcdn.com/w40/sg.png', dial: '+65', digits: 8, states: ['Central Region', 'East Region', 'North Region', 'West Region'] },
        { code: 'my', name: 'Malaysia', flagImg: 'https://flagcdn.com/w40/my.png', dial: '+60', digits: 9, states: ['Kuala Lumpur', 'Selangor', 'Penang', 'Johor', 'Perak', 'Sabah'] },
        { code: 'sa', name: 'Saudi Arabia', flagImg: 'https://flagcdn.com/w40/sa.png', dial: '+966', digits: 9, states: ['Riyadh', 'Makkah', 'Eastern Province', 'Madinah', 'Jeddah'] },
        { code: 'qa', name: 'Qatar', flagImg: 'https://flagcdn.com/w40/qa.png', dial: '+974', digits: 8, states: ['Doha', 'Al Rayyan', 'Al Wakrah', 'Al Khor'] },
        { code: 'kw', name: 'Kuwait', flagImg: 'https://flagcdn.com/w40/kw.png', dial: '+965', digits: 8, states: ['Al Asimah', 'Hawalli', 'Al Farwaniyah', 'Al Ahmadi'] },
        { code: 'bh', name: 'Bahrain', flagImg: 'https://flagcdn.com/w40/bh.png', dial: '+973', digits: 8, states: ['Capital Governorate', 'Muharraq', 'Northern', 'Southern'] },
        { code: 'om', name: 'Oman', flagImg: 'https://flagcdn.com/w40/om.png', dial: '+968', digits: 8, states: ['Muscat', 'Dhofar', 'Al Batinah', 'Al Dakhiliyah'] },
        { code: 'nz', name: 'New Zealand', flagImg: 'https://flagcdn.com/w40/nz.png', dial: '+64', digits: 9, states: ['Auckland', 'Canterbury', 'Wellington', 'Waikato'] },
        { code: 'de', name: 'Germany', flagImg: 'https://flagcdn.com/w40/de.png', dial: '+49', digits: 10, states: ['Bavaria', 'Berlin', 'North Rhine-Westphalia', 'Hesse', 'Hamburg'] },
        { code: 'fr', name: 'France', flagImg: 'https://flagcdn.com/w40/fr.png', dial: '+33', digits: 9, states: ['Paris (Île-de-France)', 'Auvergne-Rhône-Alpes', "Provence-Alpes-Côte d'Azur"] },
        { code: 'it', name: 'Italy', flagImg: 'https://flagcdn.com/w40/it.png', dial: '+39', digits: 10, states: ['Lombardy (Milan)', 'Lazio (Rome)', 'Campania', 'Veneto', 'Tuscany'] },
        { code: 'es', name: 'Spain', flagImg: 'https://flagcdn.com/w40/es.png', dial: '+34', digits: 9, states: ['Madrid', 'Catalonia (Barcelona)', 'Andalusia', 'Valencia'] },
        { code: 'nl', name: 'Netherlands', flagImg: 'https://flagcdn.com/w40/nl.png', dial: '+31', digits: 9, states: ['North Holland (Amsterdam)', 'South Holland (Rotterdam)', 'Utrecht'] },
        { code: 'za', name: 'South Africa', flagImg: 'https://flagcdn.com/w40/za.png', dial: '+27', digits: 9, states: ['Gauteng (Johannesburg)', 'Western Cape (Cape Town)', 'KwaZulu-Natal'] },
        { code: 'mu', name: 'Mauritius', flagImg: 'https://flagcdn.com/w40/mu.png', dial: '+230', digits: 8, states: ['Port Louis', 'Plaines Wilhems', 'Flacq', 'Grand Port'] },
        { code: 'ke', name: 'Kenya', flagImg: 'https://flagcdn.com/w40/ke.png', dial: '+254', digits: 9, states: ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru'] },
        { code: 'bd', name: 'Bangladesh', flagImg: 'https://flagcdn.com/w40/bd.png', dial: '+880', digits: 10, states: ['Dhaka', 'Chattogram', 'Sylhet', 'Rajshahi'] },
        { code: 'lk', name: 'Sri Lanka', flagImg: 'https://flagcdn.com/w40/lk.png', dial: '+94', digits: 9, states: ['Colombo (Western)', 'Central (Kandy)', 'Southern (Galle)'] },
        { code: 'np', name: 'Nepal', flagImg: 'https://flagcdn.com/w40/np.png', dial: '+977', digits: 10, states: ['Bagmati (Kathmandu)', 'Gandaki (Pokhara)', 'Lumbini'] }
    ];

    var modalSelectedRole = 'Retailer';
    var modalSelectedCountry = ALL_WORLD_COUNTRIES[0]; // India (+91)
    var modalSelectedState = 'Maharashtra';

    /* Show / Hide Password Helper */
    window.toggleAcPassVisibility = function(inputId, btnEl) {
        var input = document.getElementById(inputId);
        if (!input || !btnEl) return;
        var openIcon = btnEl.querySelector('.eye-open');
        var closedIcon = btnEl.querySelector('.eye-closed');
        
        if (input.type === 'password') {
            input.type = 'text';
            if (openIcon) openIcon.style.display = 'none';
            if (closedIcon) closedIcon.style.display = 'block';
        } else {
            input.type = 'password';
            if (openIcon) openIcon.style.display = 'block';
            if (closedIcon) closedIcon.style.display = 'none';
        }
    };

    /* Toggle Dropdown Menu */
    window.toggleAcDropdown = function(boxId) {
        var box = document.getElementById(boxId);
        if (!box) return;
        var isCurrentlyActive = box.classList.contains('active');
        
        document.querySelectorAll('.ac-custom-select-box').forEach(function(b){
            b.classList.remove('active');
        });

        if (!isCurrentlyActive) {
            box.classList.add('active');
            if (boxId === 'acCountrySelectBox') {
                var sInput = document.getElementById('acCountrySearchInput');
                if (sInput) {
                    sInput.value = '';
                    window.filterAcCountryOptions('');
                    setTimeout(function(){ sInput.focus(); }, 100);
                }
            } else if (boxId === 'acStateSelectBox') {
                var sInput = document.getElementById('acStateSearchInput');
                if (sInput) {
                    sInput.value = '';
                    window.filterAcStateOptions('');
                    setTimeout(function(){ sInput.focus(); }, 100);
                }
            }
        }
    };

    /* Close Dropdown on outside click */
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.ac-custom-select-box')) {
            document.querySelectorAll('.ac-custom-select-box').forEach(function(b){
                b.classList.remove('active');
            });
        }
    });

    /* Filter Country Options */
    window.filterAcCountryOptions = function(query) {
        var q = (query || '').toLowerCase().trim();
        var list = document.getElementById('acCountryOptionsList');
        if (!list) return;

        var filtered = ALL_WORLD_COUNTRIES.filter(function(c) {
            return c.name.toLowerCase().includes(q) || c.dial.includes(q) || c.code.toLowerCase().includes(q);
        });

        var html = '';
        if (filtered.length === 0) {
            html = '<div style="padding:10px; font-size:0.78rem; color:var(--ac-light-text); text-align:center; font-weight:600;">No matching country found</div>';
        } else {
            filtered.forEach(function(c) {
                var isSel = c.code === modalSelectedCountry.code;
                html += '<div class="ac-custom-select-option ' + (isSel ? 'selected' : '') + '" onclick="window.selectModalCountry(\'' + c.code + '\')">' +
                        '<img src="' + c.flagImg + '" alt="' + c.name + '" class="ac-select-flag-img">' +
                        '<span>' + c.name + ' (' + c.dial + ')</span>' +
                        '</div>';
            });
        }
        list.innerHTML = html;
    };

    /* Filter State Options */
    window.filterAcStateOptions = function(query) {
        var q = (query || '').toLowerCase().trim();
        var list = document.getElementById('acStateOptionsList');
        if (!list) return;

        var states = modalSelectedCountry.states || ['Default Region'];
        var filtered = states.filter(function(st) {
            return st.toLowerCase().includes(q);
        });

        var html = '';
        if (filtered.length === 0) {
            html = '<div style="padding:10px; font-size:0.78rem; color:var(--ac-light-text); text-align:center; font-weight:600;">No matching state found</div>';
        } else {
            filtered.forEach(function(st) {
                var isSel = st === modalSelectedState;
                html += '<div class="ac-custom-select-option ' + (isSel ? 'selected' : '') + '" onclick="window.selectModalState(\'' + st.replace(/'/g, "\\'") + '\')">' +
                        '<span>' + st + '</span>' +
                        '</div>';
            });
        }
        list.innerHTML = html;
    };

    /* Render Country & State Dropdowns */
    function renderCountryDropdown() {
        window.filterAcCountryOptions('');

        var flagImg = document.getElementById('acDisplayCountryFlag');
        var txt = document.getElementById('acDisplayCountryText');
        if (flagImg) flagImg.src = modalSelectedCountry.flagImg;
        if (txt) txt.textContent = modalSelectedCountry.name + ' (' + modalSelectedCountry.dial + ')';

        var waFlag = document.getElementById('acWaFlagImg');
        var waDial = document.getElementById('acWaDialCode');
        var hint = document.getElementById('acDigitCountHint');

        if (waFlag) waFlag.src = modalSelectedCountry.flagImg;
        if (waDial) waDial.textContent = modalSelectedCountry.code.toUpperCase() + ' ' + modalSelectedCountry.dial;
        if (hint) hint.textContent = modalSelectedCountry.digits + '-digit number';

        renderStateDropdown();
        window.validateModalWhatsApp();
    }

    function renderStateDropdown() {
        window.filterAcStateOptions('');
        var txt = document.getElementById('acDisplayStateText');
        if (txt) txt.textContent = modalSelectedState;
    }

    window.selectModalCountry = function(code) {
        var found = ALL_WORLD_COUNTRIES.find(function(c) { return c.code === code; });
        if (found) {
            modalSelectedCountry = found;
            modalSelectedState = (found.states && found.states.length > 0) ? found.states[0] : 'Default Region';
            renderCountryDropdown();
        }
        var box = document.getElementById('acCountrySelectBox');
        if (box) box.classList.remove('active');
    };

    window.selectModalState = function(stateName) {
        modalSelectedState = stateName;
        var txt = document.getElementById('acDisplayStateText');
        if (txt) txt.textContent = stateName;

        var box = document.getElementById('acStateSelectBox');
        if (box) box.classList.remove('active');
    };

    window.selectModalRole = function(role) {
        modalSelectedRole = role;
        document.querySelectorAll('.ac-role-pill-btn').forEach(function(c) {
            c.classList.toggle('selected', c.dataset.role === role);
        });
    };

    window.validateModalWhatsApp = function() {
        var input = document.getElementById('acRegPhone');
        var group = document.getElementById('acWaGroup');
        var err = document.getElementById('acValErr');
        if (!input || !group || !err) return true;

        var clean = input.value.replace(/[^0-9]/g, '');
        input.value = clean;
        var exp = modalSelectedCountry.digits || 10;

        if (clean.length > 0 && clean.length !== exp) {
            group.classList.add('is-invalid');
            err.style.display = 'block';
            err.textContent = '⚠️ Enter exactly ' + exp + ' digits for ' + modalSelectedCountry.name + '.';
            return false;
        } else {
            group.classList.remove('is-invalid');
            err.style.display = 'none';
            return clean.length === exp;
        }
    };

    /* ── Current User Helper ── */
    window.getCurrentUser = function() {
        try {
            var raw = localStorage.getItem('dtbrands_user');
            return raw ? JSON.parse(raw) : null;
        } catch(e) { return null; }
    };

    /* ── Role Dashboard URL Mapper ── */
    window.getUserDashboardUrl = function(role) {
        var r = (role || '').toLowerCase();
        if (r === 'reseller') return '/Frontend/Reseller/reseller.php';
        if (r === 'wholesaler' || r === 'wholesale') return '/Frontend/Wholesale/wholesale.php';
        return '/Frontend/Retailer/retailer.php';
    };

    /* ── 1-Tap Quick Demo Logins for Instant Testing ── */
    window.quickDemoLogin = function(role) {
        var targetRole = role || 'Retailer';
        var rLower = targetRole.toLowerCase();
        var userData = {};

        if (rLower === 'reseller') {
            userData = {
                name: 'Pooja Sharma',
                companyName: 'Pooja Boutique & Ethnic Hub',
                phone: '+91 98765 12345',
                rawPhone: '9876512345',
                email: 'pooja.reseller@gmail.com',
                role: 'Reseller',
                gst_type: 'none',
                gst_number: '',
                address: 'Flat 302, Palm Heights, Link Road',
                city: 'Jaipur',
                state: 'Rajasthan',
                pincode: '302001'
            };
        } else if (rLower === 'wholesaler' || rLower === 'wholesale') {
            userData = {
                name: 'Ramesh Patel',
                companyName: 'Surat Loomcraft Mega Traders',
                phone: '+91 98765 88990',
                rawPhone: '9876588990',
                email: 'ramesh@suratloomcraft.com',
                role: 'Wholesaler',
                gst_type: 'gst',
                gst_number: '24AABCU9603R1ZM',
                address: 'Plot No. 108, Phase 2, GIDC Textile Market',
                city: 'Surat',
                state: 'Gujarat',
                pincode: '395002'
            };
        } else {
            userData = {
                name: 'Rajesh Kumar',
                companyName: 'Shree Krishna Silks Pvt Ltd',
                phone: '+91 98765 43210',
                rawPhone: '9876543210',
                email: 'rajesh@shreekrishnasilks.com',
                role: 'Retailer',
                gst_type: 'gst',
                gst_number: '24AABCU9603R1ZM',
                address: 'Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road',
                city: 'Surat',
                state: 'Gujarat',
                pincode: '395002'
            };
        }

        localStorage.setItem('dtbrands_user', JSON.stringify(userData));
        try { window.dispatchEvent(new Event('storage')); } catch(e) {}

        if (typeof window.showToast === 'function') {
            window.showToast('👑 Logged in as Verified ' + userData.role + ' (' + userData.name + ')!');
        }

        window.closeAccountModal();
        window.location.href = window.getUserDashboardUrl(userData.role);
    };

    /* ── Global Role-Based Direct Dashboard Navigation Helper ── */
    window.handleUserWiseAccountNavigation = function(targetRole) {
        var user = window.getCurrentUser();
        if (user && user.role) {
            // If user is already logged in, navigate to their dashboard
            var url = targetRole ? window.getUserDashboardUrl(targetRole) : window.getUserDashboardUrl(user.role);
            window.location.href = url;
            return true;
        }
        // Non-logged-in guest -> Open original Login modal with smart target role
        window.openAccountModal('login', targetRole);
        return false;
    };

    /* ── Global Open / Close / Switch Tab API ── */
    window.openAccountModal = function(initialTab, targetRole) {
        var user = window.getCurrentUser();
        if (user && user.role && !initialTab) {
            window.handleUserWiseAccountNavigation(targetRole);
            return;
        }

        var modal = document.getElementById('accountModalBackdrop');
        if (!modal) return;

        var tab = initialTab || 'login';
        if (targetRole) {
            window.selectModalRole(targetRole);
        }

        window.switchAccountTab(tab);
        renderCountryDropdown();
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    window.closeAccountModal = function() {
        var modal = document.getElementById('accountModalBackdrop');
        if (modal) modal.classList.remove('active');
        document.body.style.overflow = '';
    };

    window.switchAccountTab = function(tabName) {
        var tabBtnLogin = document.getElementById('acTabBtnLogin');
        var tabBtnRegister = document.getElementById('acTabBtnRegister');

        if (tabName === 'login' || tabName === 'forgot') {
            if (tabBtnLogin) tabBtnLogin.classList.add('active');
            if (tabBtnRegister) tabBtnRegister.classList.remove('active');
        } else if (tabName === 'register') {
            if (tabBtnLogin) tabBtnLogin.classList.remove('active');
            if (tabBtnRegister) tabBtnRegister.classList.add('active');
        }

        document.querySelectorAll('.ac-pane').forEach(function(pane) {
            pane.classList.remove('active');
        });

        var targetPaneId = 'acPane' + tabName.charAt(0).toUpperCase() + tabName.slice(1);
        var targetPane = document.getElementById(targetPaneId);
        if (targetPane) targetPane.classList.add('active');

        var heading = document.getElementById('acModalHeading');
        if (heading) {
            if (tabName === 'login') heading.textContent = 'Sign In';
            else if (tabName === 'register') {
                heading.textContent = 'Create Luxury Account';
                renderCountryDropdown();
            }
            else if (tabName === 'forgot') heading.textContent = 'Reset Password';
        }
    };

    window.handleAccountLogin = function() {
        var emailInput = document.getElementById('acLoginEmail');
        var passInput = document.getElementById('acLoginPass');
        var input = emailInput ? emailInput.value.trim() : '';
        var pass = passInput ? passInput.value.trim() : '';

        if (!input) {
            alert('Please enter your WhatsApp number or Email');
            return;
        }
        if (!pass) {
            alert('Please enter your password');
            return;
        }

        var existingUser = window.getCurrentUser();
        var chosenRole = modalSelectedRole || (existingUser && existingUser.role) || 'Retailer';
        var name = (existingUser && existingUser.name) ? existingUser.name : (input.includes('@') ? input.split('@')[0] : 'B2B Member');
        name = name.charAt(0).toUpperCase() + name.slice(1);

        var userData = {
            name: name,
            companyName: (existingUser && existingUser.companyName) ? existingUser.companyName : (name + ' Boutique'),
            phone: input.includes('@') ? (existingUser ? existingUser.phone : '+91 98765 43210') : '+91 ' + input,
            rawPhone: input.replace(/[^0-9]/g, '').slice(-10),
            email: input.includes('@') ? input : (existingUser ? existingUser.email : 'member@dtbrands.com'),
            role: chosenRole,
            country: existingUser ? (existingUser.country || 'India') : modalSelectedCountry.name,
            state: existingUser ? (existingUser.state || 'Maharashtra') : modalSelectedState,
            city: existingUser ? (existingUser.city || 'Surat') : 'Surat'
        };
        localStorage.setItem('dtbrands_user', JSON.stringify(userData));
        try { window.dispatchEvent(new Event('storage')); } catch(e) {}

        if (typeof window.showToast === 'function') {
            window.showToast('✨ Welcome back, ' + name + ' (' + chosenRole + ')!');
        }

        window.closeAccountModal();
        window.location.href = window.getUserDashboardUrl(chosenRole);
    };

    window.handleAccountRegister = function() {
        var nameEl = document.getElementById('acRegName');
        var phoneEl = document.getElementById('acRegPhone');
        var cityEl = document.getElementById('acRegCity');
        var passEl = document.getElementById('acRegPass');

        var name = nameEl ? nameEl.value.trim() : '';
        var phone = phoneEl ? phoneEl.value.trim() : '';
        var city = cityEl ? cityEl.value.trim() : '';
        var pass = passEl ? passEl.value.trim() : '';

        if (!name) { alert('Please enter your full name'); return; }
        var exp = modalSelectedCountry.digits || 10;
        if (!phone || phone.length !== exp) {
            alert('Please enter a valid ' + exp + '-digit WhatsApp number for ' + modalSelectedCountry.name + '.');
            return;
        }
        if (!pass || pass.length < 6) {
            alert('Password must be at least 6 characters.');
            return;
        }

        var chosenRole = modalSelectedRole || 'Retailer';
        var userData = {
            name: name,
            companyName: name + (chosenRole === 'Retailer' ? ' Boutique' : ' Enterprise'),
            phone: modalSelectedCountry.dial + ' ' + phone,
            rawPhone: phone,
            email: 'member@dtbrands.com',
            role: chosenRole,
            country: modalSelectedCountry.name,
            state: modalSelectedState,
            city: city || modalSelectedState
        };
        localStorage.setItem('dtbrands_user', JSON.stringify(userData));
        try { window.dispatchEvent(new Event('storage')); } catch(e) {}

        if (typeof window.showToast === 'function') {
            window.showToast('🎉 Welcome to DT Brand\'s, ' + name + '!');
        }

        window.closeAccountModal();
        window.location.href = window.getUserDashboardUrl(chosenRole);
    };

    window.handleAccountForgot = function() {
        var inputEl = document.getElementById('acForgotInput');
        var input = inputEl ? inputEl.value.trim() : '';
        if (!input) return;

        var waUrl = 'https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20I%20need%20a%20password%20reset%20link%20for%20my%20DT%20Brand%20account%20(' + encodeURIComponent(input) + ')';
        window.open(waUrl, '_blank');

        if (typeof window.showToast === 'function') {
            window.showToast('📩 Reset link sent to your WhatsApp!');
        }
    };

    window.handleAccountLogout = function() {
        localStorage.removeItem('dtbrands_user');
        try { window.dispatchEvent(new Event('storage')); } catch(e) {}
        if (typeof window.showToast === 'function') {
            window.showToast('You have been logged out.');
        }
        window.location.href = '/Frontend/Shop/shop.php';
    };

    /* Bind events */
    document.addEventListener('DOMContentLoaded', function() {
        var closeBtn = document.getElementById('closeAccountModalBtn');
        if (closeBtn) closeBtn.addEventListener('click', window.closeAccountModal);

        var backdrop = document.getElementById('accountModalBackdrop');
        if (backdrop) {
            backdrop.addEventListener('click', function(e) {
                if (e.target === backdrop) window.closeAccountModal();
            });
        }
    });

})();
</script>
