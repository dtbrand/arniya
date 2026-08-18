<?php
/**
 * account.php — Luxury Account & Authentication Modal Component
 * Features Login, Register, Forgot Password, and My Account Dashboard
 * With Dynamic Country/State Sliders, Auto Flag/Dial Prefix, WhatsApp Validation & Role Selector
 * 100% Fluid Responsive for Desktop & Mobile
 */
?>
<style>
/* ── Account Modal Tokens ── */
:root {
    --ac-gold-primary: #8A681F;
    --ac-gold-deep: #6F5218;
    --ac-gold-light: #C5A859;
    --ac-gold-border: rgba(138, 104, 31, 0.22);
    --ac-dark-text: #24211C;
    --ac-mid-text: #5A5348;
    --ac-light-text: #8E877D;
    --ac-cream-bg: #FCFBF8;
}

/* ── Modal Backdrop ── */
.account-modal-backdrop {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(20, 16, 12, 0.82);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    z-index: 1000001;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.3s ease;
    padding: clamp(10px, 3vw, 20px);
    box-sizing: border-box;
}
.account-modal-backdrop.active {
    opacity: 1;
    visibility: visible;
}

/* ── Account Dialog ── */
.account-dialog {
    background: var(--ac-cream-bg);
    width: 100%;
    max-width: 520px;
    max-height: 92vh;
    border-radius: 16px;
    border: 1.5px solid var(--ac-gold-primary);
    box-shadow: 0 16px 48px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transform: translateY(20px) scale(0.96);
    transition: transform 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
    font-family: var(--font-sans, 'Inter', -apple-system, sans-serif);
    color: var(--ac-dark-text);
}
.account-modal-backdrop.active .account-dialog {
    transform: translateY(0) scale(1);
}

/* ── Dialog Header ── */
.ac-header {
    background: #FFFFFF;
    border-bottom: 1.5px solid var(--ac-gold-border);
    padding: clamp(10px, 2.5vw, 16px) clamp(14px, 3vw, 22px);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}
.ac-brand-group {
    display: flex;
    align-items: center;
    gap: 10px;
}
.ac-avatar-icon {
    width: clamp(32px, 7vw, 40px);
    height: clamp(32px, 7vw, 40px);
    border-radius: 50%;
    background: linear-gradient(135deg, var(--ac-gold-primary) 0%, var(--ac-gold-deep) 100%);
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(138,104,31,0.3);
}
.ac-avatar-icon svg {
    width: clamp(16px, 3.5vw, 20px);
    height: clamp(16px, 3.5vw, 20px);
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
}
.ac-title-wrap h3 {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: clamp(0.95rem, 3vw, 1.15rem);
    font-weight: 700;
    color: var(--ac-gold-primary);
    margin: 0;
    letter-spacing: 0.05em;
}
.ac-title-wrap span {
    font-size: 0.62rem;
    color: var(--ac-mid-text);
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
}
.ac-close-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid var(--ac-gold-border);
    background: #FAF8F4;
    color: var(--ac-gold-primary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}
.ac-close-btn:hover {
    background: var(--ac-gold-primary);
    color: #FFFFFF;
    transform: rotate(90deg);
}

/* ── Tab Switcher Bar ── */
.ac-nav-tabs {
    display: flex;
    background: #FAF6ED;
    border-bottom: 1px solid var(--ac-gold-border);
    padding: 4px 10px 0;
    gap: 4px;
    flex-shrink: 0;
}
.ac-nav-tab {
    flex: 1;
    padding: 8px 6px;
    background: transparent;
    border: none;
    border-bottom: 2.5px solid transparent;
    font-family: var(--font-sans);
    font-size: clamp(0.68rem, 2vw, 0.78rem);
    font-weight: 700;
    color: var(--ac-mid-text);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}
.ac-nav-tab:hover {
    color: var(--ac-gold-primary);
}
.ac-nav-tab.active {
    color: var(--ac-gold-primary);
    border-bottom-color: var(--ac-gold-primary);
    background: #FFFFFF;
    border-radius: 8px 8px 0 0;
}

/* ── Content Panes ── */
.ac-body {
    padding: clamp(14px, 3vw, 24px);
    overflow-y: auto;
    flex: 1;
}
.ac-pane {
    display: none;
    flex-direction: column;
    gap: 14px;
    animation: acPaneFade 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.ac-pane.active {
    display: flex;
}
@keyframes acPaneFade {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ── Input Controls ── */
.ac-form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.ac-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--ac-dark-text);
    letter-spacing: 0.02em;
    display: flex;
    justify-content: space-between;
}
.ac-label .req { color: #D32F2F; margin-left: 2px; }
.ac-input {
    width: 100%;
    height: clamp(38px, 9vw, 42px);
    border: 1.5px solid #DDD8CD;
    border-radius: 8px;
    padding: 0 12px;
    font-family: var(--font-sans);
    font-size: clamp(0.78rem, 2.2vw, 0.88rem);
    color: var(--ac-dark-text);
    background: #FFFFFF;
    outline: none;
    box-sizing: border-box;
    transition: all 0.2s ease;
}
.ac-input:focus {
    border-color: var(--ac-gold-primary);
    box-shadow: 0 0 0 3px rgba(138,104,31,0.15);
}

/* ── Role Selection Cards (Wholesaler, Retailer, Reseller) ── */
.ac-role-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 6px;
    margin-top: 2px;
}
.ac-role-card {
    border: 1.5px solid #DDD8CD;
    border-radius: 8px;
    padding: 8px 4px;
    text-align: center;
    background: #FAF8F4;
    cursor: pointer;
    transition: all 0.2s ease;
}
.ac-role-card:hover {
    border-color: var(--ac-gold-primary);
    background: #FFFFFF;
}
.ac-role-card.selected {
    border-color: var(--ac-gold-primary);
    background: #FAF3E0;
    box-shadow: 0 2px 8px rgba(138,104,31,0.12);
}
.ac-role-icon { font-size: 1.2rem; display: block; margin-bottom: 2px; }
.ac-role-name { font-size: 0.72rem; font-weight: 700; color: var(--ac-dark-text); display: block; }
.ac-role-sub { font-size: 0.56rem; color: var(--ac-gold-primary); font-weight: 600; display: block; }

/* ── Slider Pills Track for Countries & States ── */
.ac-slider-track {
    display: flex;
    gap: 6px;
    overflow-x: auto;
    padding: 3px 2px 6px;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
}
.ac-slider-track::-webkit-scrollbar { display: none; }
.ac-pill {
    flex-shrink: 0;
    padding: 5px 10px;
    border-radius: 16px;
    border: 1.5px solid #DDD8CD;
    background: #FFFFFF;
    color: var(--ac-dark-text);
    font-size: 0.72rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
}
.ac-pill:hover { border-color: var(--ac-gold-primary); color: var(--ac-gold-primary); }
.ac-pill.selected {
    background: var(--ac-gold-primary);
    color: #FFFFFF;
    border-color: var(--ac-gold-primary);
    box-shadow: 0 2px 6px rgba(138,104,31,0.25);
}

/* ── WhatsApp Phone Input with Auto Country Flag ── */
.ac-wa-group {
    display: flex;
    border: 1.5px solid #DDD8CD;
    border-radius: 8px;
    background: #FAF9F5;
    overflow: hidden;
    transition: all 0.2s ease;
}
.ac-wa-group:focus-within {
    border-color: var(--ac-gold-primary);
    background: #FFFFFF;
    box-shadow: 0 0 0 3px rgba(138,104,31,0.15);
}
.ac-wa-group.is-invalid {
    border-color: #D32F2F !important;
}
.ac-wa-prefix {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 0 8px;
    background: #F0EAD8;
    border-right: 1px solid #DDD8CD;
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--ac-gold-primary);
    flex-shrink: 0;
}
.ac-wa-input {
    flex: 1;
    height: 40px;
    border: none;
    outline: none;
    background: transparent;
    padding: 0 10px;
    font-family: var(--font-sans);
    font-size: 0.86rem;
    color: var(--ac-dark-text);
}
.ac-val-err {
    font-size: 0.65rem;
    color: #D32F2F;
    font-weight: 600;
    display: none;
    margin-top: 2px;
}

/* ── Action Buttons ── */
.ac-btn-primary {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: none;
    background: linear-gradient(135deg, var(--ac-gold-primary) 0%, var(--ac-gold-deep) 100%);
    color: #FFFFFF;
    font-family: var(--font-sans);
    font-size: clamp(0.78rem, 2.2vw, 0.88rem);
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(138,104,31,0.25);
    margin-top: 6px;
}
.ac-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(138,104,31,0.38);
}
.ac-btn-link {
    background: none;
    border: none;
    color: var(--ac-gold-primary);
    font-size: 0.72rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: underline;
    padding: 0;
    transition: color 0.2s ease;
}
.ac-btn-link:hover {
    color: var(--ac-gold-deep);
}

.ac-divider {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--ac-light-text);
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    margin: 4px 0;
}
.ac-divider::before, .ac-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--ac-gold-border);
}

/* ── My Account Dashboard View ── */
.ac-profile-header {
    background: linear-gradient(135deg, #FAF6EE 0%, #F5EDE0 100%);
    border: 1.5px solid var(--ac-gold-border);
    border-radius: 12px;
    padding: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.ac-profile-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--ac-gold-primary);
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-serif);
    font-size: 1.2rem;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(138,104,31,0.3);
}
.ac-profile-info {
    flex: 1;
}
.ac-profile-name {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--ac-gold-primary);
}
.ac-profile-phone {
    font-size: 0.72rem;
    color: var(--ac-mid-text);
    font-weight: 600;
    margin-top: 2px;
}
.ac-profile-tier {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 10px;
    background: var(--ac-gold-primary);
    color: #FFFFFF;
    font-size: 0.55rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-top: 4px;
}

.ac-stat-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.ac-stat-card {
    background: #FFFFFF;
    border: 1px solid var(--ac-gold-border);
    border-radius: 10px;
    padding: 10px 12px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
}
.ac-stat-card:hover {
    border-color: var(--ac-gold-primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(138,104,31,0.1);
}
.ac-stat-num {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--ac-gold-primary);
}
.ac-stat-label {
    font-size: 0.65rem;
    color: var(--ac-mid-text);
    font-weight: 600;
    text-transform: uppercase;
    margin-top: 2px;
}

.ac-orders-title {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--ac-gold-primary);
    letter-spacing: 0.05em;
    margin-top: 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ac-order-card {
    background: #FFFFFF;
    border: 1px solid var(--ac-gold-border);
    border-radius: 8px;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}
.ac-order-id {
    font-weight: 700;
    font-size: 0.78rem;
    color: var(--ac-dark-text);
}
.ac-order-status {
    padding: 2px 6px;
    border-radius: 6px;
    background: #E8F5E9;
    color: #2E7D32;
    font-size: 0.6rem;
    font-weight: 700;
}
</style>

<!-- ════════════════════════════════════════════════════
     ACCOUNT MODAL MARKUP
════════════════════════════════════════════════════ -->
<div class="account-modal-backdrop" id="accountModalBackdrop" role="dialog" aria-modal="true" aria-label="Customer Account">
    <div class="account-dialog">
        
        <!-- Header -->
        <div class="ac-header" style="display:flex; align-items:center; justify-content:space-between; padding:12px 18px; border-bottom:1.5px solid var(--ac-gold-primary); background:#FFFFFF;">
            <div class="ac-brand-group" style="display:flex; align-items:center; gap:10px;">
                <img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Shop/Asset/images/logo.png';" alt="Kalaniketan" style="height:32px; width:auto; max-width:130px; object-fit:contain;">
                <div class="ac-title-wrap">
                    <h3 id="acModalHeading" style="margin:0; font-size:0.96rem;">Luxury Member Access</h3>
                    <span style="font-size:0.56rem;">Ethnic Luxury Couture</span>
                </div>
            </div>
            <button class="ac-close-btn" id="closeAccountModalBtn" aria-label="Close Account Modal">✕</button>
        </div>

        <!-- Tab Switcher -->
        <div class="ac-nav-tabs" id="acNavTabs">
            <button class="ac-nav-tab active" data-tab="login" onclick="window.switchAccountTab('login')">Login</button>
            <button class="ac-nav-tab" data-tab="register" onclick="window.switchAccountTab('register')">Register</button>
            <button class="ac-nav-tab" data-tab="forgot" onclick="window.switchAccountTab('forgot')">Forgot</button>
            <button class="ac-nav-tab" data-tab="profile" onclick="window.switchAccountTab('profile')">My Account</button>
        </div>

        <!-- Body -->
        <div class="ac-body">
            
            <!-- 1. LOGIN PANE -->
            <div class="ac-pane active" id="acPaneLogin">
                <form id="acLoginForm" onsubmit="event.preventDefault(); window.handleAccountLogin();">
                    <div class="ac-form-group">
                        <label class="ac-label" for="acLoginEmail">WhatsApp Number or Email</label>
                        <input type="text" id="acLoginEmail" class="ac-input" placeholder="e.g. 9876543210 or radhika@example.com" required>
                    </div>
                    <div class="ac-form-group">
                        <label class="ac-label" for="acLoginPassword">
                            <span>Password</span>
                            <button type="button" class="ac-btn-link" onclick="window.switchAccountTab('forgot')">Forgot Password?</button>
                        </label>
                        <input type="password" id="acLoginPassword" class="ac-input" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="ac-btn-primary">Sign In to Luxury Club</button>
                </form>

                <div class="ac-divider">OR</div>

                <div style="text-align:center; font-size:0.75rem;">
                    Don't have an account? <button type="button" class="ac-btn-link" onclick="window.switchAccountTab('register')">Create an Account</button>
                </div>
            </div>

            <!-- 2. REGISTER PANE -->
            <div class="ac-pane" id="acPaneRegister">
                <form id="acRegisterForm" onsubmit="event.preventDefault(); window.handleAccountRegister();">
                    
                    <!-- Full Name -->
                    <div class="ac-form-group">
                        <label class="ac-label" for="acRegName">Full Name <span class="req">*</span></label>
                        <input type="text" id="acRegName" class="ac-input" placeholder="e.g. Radhika Sharma" required>
                    </div>

                    <!-- Role Option (Retailer, Wholesaler, Reseller) -->
                    <div class="ac-form-group">
                        <label class="ac-label">Account Role / Purpose <span class="req">*</span></label>
                        <div class="ac-role-grid">
                            <div class="ac-role-card selected" data-role="Retailer" onclick="window.selectModalRole('Retailer')">
                                <span class="ac-role-icon">🛍️</span>
                                <span class="ac-role-name">Retailer</span>
                                <span class="ac-role-sub">Personal</span>
                            </div>
                            <div class="ac-role-card" data-role="Wholesaler" onclick="window.selectModalRole('Wholesaler')">
                                <span class="ac-role-icon">📦</span>
                                <span class="ac-role-name">Wholesaler</span>
                                <span class="ac-role-sub">Bulk</span>
                            </div>
                            <div class="ac-role-card" data-role="Reseller" onclick="window.selectModalRole('Reseller')">
                                <span class="ac-role-icon">💼</span>
                                <span class="ac-role-name">Reseller</span>
                                <span class="ac-role-sub">Boutique</span>
                            </div>
                        </div>
                    </div>

                    <!-- Country Option Slider (First Auto-Selected: India 🇮🇳 +91) -->
                    <div class="ac-form-group">
                        <label class="ac-label">
                            <span>Country <span class="req">*</span></span>
                            <span id="acSelectedCountryLabel" style="color:var(--ac-gold-primary); font-weight:700;">🇮🇳 India (+91)</span>
                        </label>
                        <div class="ac-slider-track" id="acCountrySliderTrack">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- State Option Slider -->
                    <div class="ac-form-group">
                        <label class="ac-label">
                            <span>State <span class="req">*</span></span>
                            <span id="acSelectedStateLabel" style="color:var(--ac-gold-primary); font-weight:700;">Maharashtra</span>
                        </label>
                        <div class="ac-slider-track" id="acStateSliderTrack">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- City Input -->
                    <div class="ac-form-group">
                        <label class="ac-label" for="acRegCity">City <span class="req">*</span></label>
                        <input type="text" id="acRegCity" class="ac-input" placeholder="e.g. Mumbai" required value="Mumbai">
                    </div>

                    <!-- WhatsApp Number with Flag Prefix & Validation -->
                    <div class="ac-form-group">
                        <label class="ac-label" for="acRegPhone">
                            <span>WhatsApp Number <span class="req">*</span></span>
                            <span id="acDigitHint" style="font-size:0.65rem; color:var(--ac-light-text);">10 digits</span>
                        </label>
                        <div class="ac-wa-group" id="acWaGroup">
                            <div class="ac-wa-prefix">
                                <span id="acWaFlag">🇮🇳</span>
                                <span id="acWaDial">+91</span>
                            </div>
                            <input type="tel" id="acRegPhone" class="ac-wa-input" placeholder="9876543210" maxlength="12" required oninput="window.validateModalWhatsApp()">
                        </div>
                        <div class="ac-val-err" id="acValErr">⚠️ Please enter a valid 10-digit number.</div>
                    </div>

                    <!-- Email Address -->
                    <div class="ac-form-group">
                        <label class="ac-label" for="acRegEmail">Email Address (Optional)</label>
                        <input type="email" id="acRegEmail" class="ac-input" placeholder="radhika@example.com">
                    </div>

                    <!-- Password -->
                    <div class="ac-form-group">
                        <label class="ac-label" for="acRegPass">Create Password <span class="req">*</span></label>
                        <input type="password" id="acRegPass" class="ac-input" placeholder="Minimum 6 characters" required>
                    </div>

                    <button type="submit" class="ac-btn-primary">Register Luxury Account</button>
                </form>

                <div style="text-align:center; font-size:0.75rem; margin-top:8px;">
                    Already a member? <button type="button" class="ac-btn-link" onclick="window.switchAccountTab('login')">Sign In here</button>
                </div>
            </div>

            <!-- 3. FORGOT PASSWORD PANE -->
            <div class="ac-pane" id="acPaneForgot">
                <p style="font-size:0.76rem; color:var(--ac-mid-text); margin:0 0 10px; line-height:1.4;">
                    Enter your registered WhatsApp Number or Email and we'll instantly send you a password reset OTP on WhatsApp.
                </p>
                <form id="acForgotForm" onsubmit="event.preventDefault(); window.handleAccountForgot();">
                    <div class="ac-form-group">
                        <label class="ac-label" for="acForgotInput">WhatsApp Number / Email</label>
                        <input type="text" id="acForgotInput" class="ac-input" placeholder="e.g. 9876543210" required>
                    </div>
                    <button type="submit" class="ac-btn-primary">Send Reset Link via WhatsApp</button>
                </form>

                <div style="text-align:center; font-size:0.75rem; margin-top:10px;">
                    Remembered password? <button type="button" class="ac-btn-link" onclick="window.switchAccountTab('login')">Back to Login</button>
                </div>
            </div>

            <!-- 4. MY ACCOUNT DASHBOARD PANE -->
            <div class="ac-pane" id="acPaneProfile">
                <div class="ac-profile-header">
                    <div class="ac-profile-avatar" id="acUserInitials">RS</div>
                    <div class="ac-profile-info">
                        <div class="ac-profile-name" id="acUserName">Radhika Sharma</div>
                        <div class="ac-profile-phone" id="acUserPhone">+91 98765 43210</div>
                        <div class="ac-profile-tier" id="acUserTier">👑 Royal Retailer VIP Member</div>
                    </div>
                </div>

                <a href="../Wholesale/wholesale.php" id="acModalWsBtn" style="display:none; text-decoration:none; background:linear-gradient(135deg, #FAF6EE 0%, #F5EDE0 100%); border:1.5px solid var(--ac-gold, #8A681F); border-radius:10px; padding:10px 14px; margin: 10px 0 12px; align-items:center; justify-content:space-between; color:var(--ac-gold, #8A681F); font-weight:700; font-size:0.8rem;">
                    <span>📦 Open Wholesaler B2B Dashboard</span>
                    <span>→</span>
                </a>

                <div class="ac-stat-grid">
                    <div class="ac-stat-card" onclick="if(typeof window.openWishlistDrawer==='function'){window.closeAccountModal();window.openWishlistDrawer();}">
                        <div class="ac-stat-num" id="acStatWishlist">0</div>
                        <div class="ac-stat-label">Saved Items</div>
                    </div>
                    <div class="ac-stat-card" onclick="if(typeof window.openCartDrawer==='function'){window.closeAccountModal();window.openCartDrawer();}">
                        <div class="ac-stat-num" id="acStatCart">0</div>
                        <div class="ac-stat-label">Cart Items</div>
                    </div>
                </div>

                <div class="ac-orders-title">
                    <span>Recent Orders</span>
                    <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20I%20would%20like%20to%20track%20my%20Kalaniketan%20order" target="_blank" class="ac-btn-link">WhatsApp Support</a>
                </div>

                <div class="ac-order-card">
                    <div>
                        <div class="ac-order-id">Order #KLN-847291</div>
                        <div style="font-size:0.68rem; color:var(--ac-mid-text);">Bridal Zardozi Lehenga • 1 Item</div>
                    </div>
                    <span class="ac-order-status">Processing</span>
                </div>

                <div class="ac-order-card">
                    <div>
                        <div class="ac-order-id">Order #KLN-312984</div>
                        <div style="font-size:0.68rem; color:var(--ac-mid-text);">Kanjivaram Silk Saree • 1 Item</div>
                    </div>
                    <span class="ac-order-status" style="background:#E3F2FD; color:#1565C0;">Delivered</span>
                </div>

                <button class="ac-btn-primary" style="background:#FAF8F4; color:#D32F2F; border:1.5px solid #FFCDD2; margin-top:8px;" onclick="window.handleAccountLogout()">
                    Log Out of Account
                </button>
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

    var MODAL_COUNTRIES = [
        { code: 'IN', name: 'India', flag: '🇮🇳', dial: '+91', digits: 10, states: ['Maharashtra', 'Gujarat', 'Rajasthan', 'Delhi (NCT)', 'Karnataka', 'Tamil Nadu', 'Uttar Pradesh', 'West Bengal', 'Telangana', 'Kerala', 'Punjab', 'Andhra Pradesh', 'Madhya Pradesh', 'Bihar', 'Haryana', 'Odisha', 'Assam', 'Goa'] },
        { code: 'AE', name: 'UAE', flag: '🇦🇪', dial: '+971', digits: 9, states: ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman'] },
        { code: 'US', name: 'USA', flag: '🇺🇸', dial: '+1', digits: 10, states: ['California', 'Texas', 'New York', 'Florida', 'Illinois'] },
        { code: 'GB', name: 'UK', flag: '🇬🇧', dial: '+44', digits: 10, states: ['London', 'England', 'Scotland', 'Wales'] },
        { code: 'CA', name: 'Canada', flag: '🇨🇦', dial: '+1', digits: 10, states: ['Ontario', 'British Columbia', 'Quebec'] },
        { code: 'AU', name: 'Australia', flag: '🇦🇺', dial: '+61', digits: 9, states: ['New South Wales', 'Victoria', 'Queensland'] }
    ];

    var modalSelectedRole = 'Retailer';
    var modalSelectedCountry = MODAL_COUNTRIES[0]; // Auto-selected: India (+91)
    var modalSelectedState = modalSelectedCountry.states[0];

    function renderModalCountrySlider() {
        var track = document.getElementById('acCountrySliderTrack');
        if (!track) return;

        var html = '';
        MODAL_COUNTRIES.forEach(function(c) {
            var isSel = c.code === modalSelectedCountry.code;
            html += `<div class="ac-pill ${isSel ? 'selected' : ''}" onclick="window.selectModalCountry('${c.code}')"><span>${c.flag}</span><span>${c.name}</span><span style="opacity:0.7;font-size:0.6rem;">(${c.dial})</span></div>`;
        });
        track.innerHTML = html;

        var lbl = document.getElementById('acSelectedCountryLabel');
        if (lbl) lbl.textContent = `${modalSelectedCountry.flag} ${modalSelectedCountry.name} (${modalSelectedCountry.dial})`;

        var flagEl = document.getElementById('acWaFlag');
        var dialEl = document.getElementById('acWaDial');
        var hint = document.getElementById('acDigitHint');
        if (flagEl) flagEl.textContent = modalSelectedCountry.flag;
        if (dialEl) dialEl.textContent = modalSelectedCountry.dial;
        if (hint) hint.textContent = `${modalSelectedCountry.digits} digits`;

        renderModalStateSlider();
        window.validateModalWhatsApp();
    }

    function renderModalStateSlider() {
        var track = document.getElementById('acStateSliderTrack');
        if (!track) return;

        var html = '';
        modalSelectedCountry.states.forEach(function(st) {
            var isSel = st === modalSelectedState;
            html += `<div class="ac-pill ${isSel ? 'selected' : ''}" onclick="window.selectModalState('${st}')"><span>📍</span><span>${st}</span></div>`;
        });
        track.innerHTML = html;

        var lbl = document.getElementById('acSelectedStateLabel');
        if (lbl) lbl.textContent = modalSelectedState;
    }

    window.selectModalCountry = function(code) {
        var found = MODAL_COUNTRIES.find(function(c){ return c.code === code; });
        if (found) {
            modalSelectedCountry = found;
            modalSelectedState = found.states[0] || 'Default';
            renderModalCountrySlider();
        }
    };

    window.selectModalState = function(st) {
        modalSelectedState = st;
        renderModalStateSlider();
        var cityEl = document.getElementById('acRegCity');
        if (cityEl && !cityEl.value) cityEl.value = st;
    };

    window.selectModalRole = function(role) {
        modalSelectedRole = role;
        document.querySelectorAll('.ac-role-card').forEach(function(c){
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
            err.textContent = `⚠️ Enter ${exp} digits for ${modalSelectedCountry.name}.`;
            return false;
        } else {
            group.classList.remove('is-invalid');
            err.style.display = 'none';
            return clean.length === exp;
        }
    };

    /* Global Open / Close / Switch Tab API */
    window.openAccountModal = function(initialTab) {
        var modal = document.getElementById('accountModalBackdrop');
        if (!modal) return;

        var tab = initialTab || 'login';
        var user = localStorage.getItem('kalaniketan_user');
        if (user && tab === 'login') {
            tab = 'profile';
        }

        window.switchAccountTab(tab);
        renderModalCountrySlider();
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    window.closeAccountModal = function() {
        var modal = document.getElementById('accountModalBackdrop');
        if (modal) modal.classList.remove('active');
        document.body.style.overflow = '';
    };

    window.switchAccountTab = function(tabName) {
        document.querySelectorAll('.ac-nav-tab').forEach(function(tab) {
            tab.classList.toggle('active', tab.dataset.tab === tabName);
        });

        document.querySelectorAll('.ac-pane').forEach(function(pane) {
            pane.classList.remove('active');
        });

        var targetPaneId = 'acPane' + tabName.charAt(0).toUpperCase() + tabName.slice(1);
        var targetPane = document.getElementById(targetPaneId);
        if (targetPane) targetPane.classList.add('active');

        var heading = document.getElementById('acModalHeading');
        if (heading) {
            if (tabName === 'login') heading.textContent = 'Sign In to Kalaniketan';
            else if (tabName === 'register') {
                heading.textContent = 'Create Luxury Account';
                renderModalCountrySlider();
            }
            else if (tabName === 'forgot') heading.textContent = 'Reset Your Password';
            else heading.textContent = 'My Luxury Profile';
        }

        /* Update Profile Counts */
        if (tabName === 'profile') {
            var cart = window.cartState || JSON.parse(localStorage.getItem('kalaniketan_cart') || '[]');
            var wish = JSON.parse(localStorage.getItem('kalaniketan_wishlist') || '[]');
            var userRaw = localStorage.getItem('kalaniketan_user');

            if (userRaw) {
                var user = JSON.parse(userRaw);
                var nameEl = document.getElementById('acUserName');
                var phoneEl = document.getElementById('acUserPhone');
                var initEl = document.getElementById('acUserInitials');
                var tierEl = document.getElementById('acUserTier');

                if (nameEl) nameEl.textContent = user.name || 'Radhika Sharma';
                if (phoneEl) phoneEl.textContent = user.phone || '+91 98765 43210';
                if (tierEl) {
                    var r = user.role || 'Retailer';
                    tierEl.textContent = `👑 Royal ${r} VIP Member`;
                }
                var wsBtn = document.getElementById('acModalWsBtn');
                var role = (user.role || '').toLowerCase();
                if (wsBtn) {
                    if (role === 'wholesaler') {
                        wsBtn.style.display = 'flex';
                        wsBtn.href = '../Wholesale/wholesale.php';
                        wsBtn.innerHTML = '<span>📦 Open Wholesaler B2B Dashboard</span><span>→</span>';
                    } else if (role === 'retailer') {
                        wsBtn.style.display = 'flex';
                        wsBtn.href = '../Retailer/retailer.php';
                        wsBtn.innerHTML = '<span>🛍️ Open Retailer B2B Dashboard</span><span>→</span>';
                    } else if (role === 'reseller') {
                        wsBtn.style.display = 'flex';
                        wsBtn.href = '../Reseller/reseller.php';
                        wsBtn.innerHTML = '<span>💼 Open Reseller B2B Dashboard</span><span>→</span>';
                    } else {
                        wsBtn.style.display = 'none';
                    }
                }

                if (initEl) {
                    var parts = (user.name || 'RS').split(' ');
                    initEl.textContent = (parts[0].charAt(0) + (parts[1] ? parts[1].charAt(0) : '')).toUpperCase();
                }
            }
            
            var cartEl = document.getElementById('acStatCart');
            var wishEl = document.getElementById('acStatWishlist');
            if (cartEl) cartEl.textContent = cart.reduce(function(s, i){ return s + (i.qty||1); }, 0);
            if (wishEl) wishEl.textContent = wish.length;
        }
    };

    window.handleAccountLogin = function() {
        var input = document.getElementById('acLoginEmail').value.trim();
        if (!input) return;

        var name = input.includes('@') ? input.split('@')[0] : 'Luxury Member';
        name = name.charAt(0).toUpperCase() + name.slice(1);

        var userData = {
            name: name,
            phone: input.includes('@') ? '+91 98765 43210' : '+91 ' + input,
            email: input.includes('@') ? input : 'member@kalaniketan.com',
            role: 'Retailer',
            country: 'India',
            state: 'Maharashtra',
            city: 'Mumbai'
        };
        localStorage.setItem('kalaniketan_user', JSON.stringify(userData));

        if (typeof window.showToast === 'function') {
            window.showToast('✨ Welcome back, ' + name + '!');
        }
        window.switchAccountTab('profile');
    };

    window.handleAccountRegister = function() {
        var name = document.getElementById('acRegName').value.trim();
        var phone = document.getElementById('acRegPhone').value.trim();
        var city = document.getElementById('acRegCity').value.trim();
        var email = document.getElementById('acRegEmail').value.trim();

        if (!name) { alert('Please enter your full name'); return; }
        var exp = modalSelectedCountry.digits || 10;
        if (!phone || phone.length !== exp) {
            alert(`Please enter a valid ${exp}-digit WhatsApp number.`);
            return;
        }

        var userData = {
            name: name,
            phone: modalSelectedCountry.dial + ' ' + phone,
            email: email || 'member@kalaniketan.com',
            role: modalSelectedRole,
            country: modalSelectedCountry.name,
            state: modalSelectedState,
            city: city || modalSelectedState
        };
        localStorage.setItem('kalaniketan_user', JSON.stringify(userData));

        if (typeof window.showToast === 'function') {
            window.showToast('🎉 Luxury Account created successfully!');
        }
        window.switchAccountTab('profile');
    };

    window.handleAccountForgot = function() {
        var input = document.getElementById('acForgotInput').value.trim();
        if (!input) return;

        var waUrl = `https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20I%20need%20a%20password%20reset%20link%20for%20my%20Kalaniketan%20account%20(${encodeURIComponent(input)})`;
        window.open(waUrl, '_blank');

        if (typeof window.showToast === 'function') {
            window.showToast('📩 Reset link sent to your WhatsApp!');
        }
    };

    window.handleAccountLogout = function() {
        localStorage.removeItem('kalaniketan_user');
        if (typeof window.showToast === 'function') {
            window.showToast('You have been logged out.');
        }
        window.switchAccountTab('login');
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
