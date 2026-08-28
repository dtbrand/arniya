<?php
/**
 * DT Brand/shared/auth_modal.php — Universal Authentication & Account Modal
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ════════════ AUTH & ACCOUNT MODAL ════════════ -->
<div class="dt-modal-overlay" id="dtAuthModalOverlay" aria-hidden="true">
    <div class="dt-modal dt-auth-modal" id="dtAuthModal" role="dialog" aria-label="Account Access">
        
        <!-- Header -->
        <div class="dt-modal-header">
            <div class="dt-auth-tabs">
                <button type="button" class="dt-auth-tab-btn active" id="dtTabBtnLogin" onclick="switchAuthTab('login')">Sign In</button>
                <button type="button" class="dt-auth-tab-btn" id="dtTabBtnRegister" onclick="switchAuthTab('register')">Register Partner</button>
            </div>
            <button type="button" class="dt-modal-close" onclick="closeAuthModal()" aria-label="Close">✕</button>
        </div>

        <!-- Body -->
        <div class="dt-modal-body">
            
            <!-- Tab 1: Sign In -->
            <form class="dt-auth-form active" id="dtFormLogin" onsubmit="handleAuthLogin(event)">
                <h4 class="dt-auth-heading">Welcome Back</h4>
                <p class="dt-auth-sub">Access your customer orders, wholesale lot pricing, or reseller dashboard.</p>
                
                <div class="dt-field-group">
                    <label class="dt-field-label">Mobile Number or Email</label>
                    <input type="text" class="dt-input-field" id="dtLoginIdentity" placeholder="e.g. 7046363528" required />
                </div>
                <div class="dt-field-group">
                    <label class="dt-field-label">Password</label>
                    <input type="password" class="dt-input-field" id="dtLoginPassword" placeholder="••••••••" required />
                </div>

                <div class="dt-auth-extra-row">
                    <label class="dt-remember-check">
                        <input type="checkbox" id="dtLoginRemember" checked />
                        <span>Remember Me</span>
                    </label>
                    <a href="javascript:void(0)" onclick="switchAuthTab('forgot')" class="dt-forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" class="dt-btn-gold dt-auth-submit-btn" id="dtLoginSubmitBtn">
                    <span>Sign In to Account</span>
                </button>
            </form>

            <!-- Tab 2: Register -->
            <form class="dt-auth-form" id="dtFormRegister" onsubmit="handleAuthRegister(event)" style="display:none;">
                <h4 class="dt-auth-heading">Create Partner Account</h4>
                <p class="dt-auth-sub">Join as Retail Buyer, Surat Wholesaler, or Zero-Investment Reseller.</p>
                
                <div class="dt-field-group">
                    <label class="dt-field-label">Account Role *</label>
                    <select class="dt-input-field" id="dtRegType" onchange="dtToggleTradeKyc(this.value)">
                        <option value="retail">Retail Shopper (Personal Wear)</option>
                        <option value="wholesale">Wholesaler / Mill Partner (B2B Lots)</option>
                        <option value="reseller">Reseller Partner (Earn Margins on WhatsApp)</option>
                    </select>
                </div>
                <!--
                    Trade credentials, revealed only for wholesale/reseller. Those
                    signups are held for approval and an admin has to verify the GSTIN
                    before mill-rate pricing is switched on.
                -->
                <div class="dt-field-group" id="dtRegTradeKyc" style="display:none;">
                    <label class="dt-field-label">GSTIN (speeds up approval)</label>
                    <input type="text" class="dt-input-field" id="dtRegGstin" placeholder="e.g. 24ABCDE1234F1Z5" maxlength="15" autocomplete="off" oninput="this.value=this.value.toUpperCase().replace(/[^0-9A-Z]/g,'')" />
                    <label class="dt-field-label" style="margin-top:10px; display:block;">PAN (optional)</label>
                    <input type="text" class="dt-input-field" id="dtRegPan" placeholder="e.g. ABCDE1234F" maxlength="10" autocomplete="off" oninput="this.value=this.value.toUpperCase().replace(/[^0-9A-Z]/g,'')" />
                    <p style="font-size:0.74rem; color:#78716C; margin:8px 0 0 0; line-height:1.45; font-weight:500;">
                        Trade accounts are reviewed before wholesale pricing is activated. We'll confirm on WhatsApp — you can shop at retail prices meanwhile.
                    </p>
                </div>
                <div class="dt-field-group">
                    <label class="dt-field-label">Full Name *</label>
                    <input type="text" class="dt-input-field" id="dtRegName" placeholder="e.g. Priya Sharma" required />
                </div>
                <div class="dt-field-group">
                    <label class="dt-field-label">Mobile Number (WhatsApp Enabled) *</label>
                    <input type="tel" class="dt-input-field" id="dtRegPhone" placeholder="e.g. 7046363528" required />
                </div>
                <div class="dt-field-group">
                    <label class="dt-field-label">Email Address</label>
                    <input type="email" class="dt-input-field" id="dtRegEmail" placeholder="e.g. priya@gmail.com" />
                </div>
                <div class="dt-field-group">
                    <label class="dt-field-label">Password * (Min. 6 Characters)</label>
                    <input type="password" class="dt-input-field" id="dtRegPassword" placeholder="••••••••" minlength="6" required />
                </div>

                <button type="submit" class="dt-btn-gold dt-auth-submit-btn" id="dtRegSubmitBtn">
                    <span>Create Free Account</span>
                </button>
            </form>

            <!-- Tab 3: Forgot Password -->
            <div class="dt-auth-form" id="dtFormForgot" style="display:none;">
                <h4 class="dt-auth-heading">Reset Password</h4>
                <p class="dt-auth-sub">Enter your registered mobile number to receive a WhatsApp OTP verification code.</p>
                
                <div class="dt-field-group">
                    <label class="dt-field-label">Mobile Number</label>
                    <input type="tel" class="dt-input-field" id="dtForgotPhone" placeholder="e.g. 7046363528" required />
                </div>

                <button type="button" class="dt-btn-gold dt-auth-submit-btn" onclick="handleAuthForgot()">
                    <span>Send Verification Code</span>
                </button>
                <div style="text-align:center; margin-top:12px;">
                    <a href="javascript:void(0)" onclick="switchAuthTab('login')" class="dt-forgot-link">&larr; Back to Sign In</a>
                </div>
            </div>

        </div>

    </div>
</div>
