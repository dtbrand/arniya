<?php
/**
 * new.php — Luxury Add New Customer Registration
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$page_title = "Add New Customer";
$active_nav = "customers";
$active_subnav = "new";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-profile.css?v=<?php echo time(); ?>">
    <style>
        .dt-edit-card {
            background: #FFFFFF;
            border: 1.5px solid var(--dt-border-light);
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }
        .dt-edit-section {
            padding: 18px 22px;
            border-bottom: 1.5px solid #F1ECE1;
        }
        .dt-edit-section:last-child {
            border-bottom: none;
        }
        .dt-edit-section-title {
            font-size: 0.92rem;
            font-weight: 800;
            color: #181512;
            margin: 0 0 14px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dt-edit-section-title svg {
            color: var(--dt-gold-primary);
        }
        .dt-form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        .dt-form-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 14px;
        }
        @media (max-width: 768px) {
            .dt-form-grid-2, .dt-form-grid-3 {
                grid-template-columns: 1fr;
            }
        }
        .dt-form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .dt-form-label {
            font-size: 0.74rem;
            font-weight: 800;
            color: #2A241E;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dt-input-icon-wrap {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }
        .dt-input-icon {
            position: absolute;
            left: 12px;
            color: #8A681F;
            pointer-events: none;
        }
        .dt-input-field {
            width: 100%;
            height: 38px;
            padding: 0 12px 0 36px;
            background: #FAF8F4;
            border: 1.5px solid #EAE5D9;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.82rem;
            font-weight: 600;
            color: #111827;
            box-sizing: border-box;
        }

        @property --dt-border-angle {
            syntax: "<angle>";
            inherits: false;
            initial-value: 0deg;
        }

        @keyframes dtBorderRotate {
            to {
                --dt-border-angle: 360deg;
            }
        }

        @keyframes dtGoldPlatinumGlow {
            0% {
                box-shadow: 0 0 8px rgba(212, 175, 55, 0.45), 0 0 16px rgba(226, 232, 240, 0.35);
            }
            100% {
                box-shadow: 0 0 16px rgba(212, 175, 55, 0.75), 0 0 28px rgba(255, 255, 255, 0.6);
            }
        }

        .dt-input-field:focus,
        .dt-cust-select:focus,
        .dt-country-search-input:focus,
        textarea.dt-input-field:focus {
            outline: none !important;
            border: 2px solid transparent !important;
            background: linear-gradient(#FFFFFF, #FFFFFF) padding-box,
                        conic-gradient(from var(--dt-border-angle), #D4AF37 0deg, #FFFFFF 60deg, #E2E8F0 120deg, #D4AF37 180deg, #FFFFFF 240deg, #B8860B 300deg, #D4AF37 360deg) border-box !important;
            animation: dtBorderRotate 2s linear infinite, dtGoldPlatinumGlow 1.5s ease-in-out infinite alternate !important;
            color: #111827 !important;
        }
        .dt-input-field.no-icon {
            padding-left: 12px;
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container" style="max-width: 960px; margin: 0 auto;">
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Add New Customer Account</span>
                            <span class="dt-cust-badge purple">Manual Entry</span>
                        </h1>
                        <p class="dt-cust-subtitle">Create a direct retail customer account with verified phone, email credentials, and delivery address.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/Frontend/Admin/customers/index.php" class="dt-btn dt-btn-pale">← Back to Directory</a>
                    </div>
                </div>

                <!-- Add Customer Form Card -->
                <div class="dt-edit-card">
                    <form onsubmit="event.preventDefault(); window.showToast('✓ Customer Account Created Successfully!'); setTimeout(() => window.location.href='/Frontend/Admin/customers/index.php', 1000);">
                        
                        <!-- ══ SECTION 1: PERSONAL & CONTACT INFORMATION ══ -->
                        <div class="dt-edit-section">
                            <h3 class="dt-edit-section-title">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>Personal &amp; Contact Details</span>
                            </h3>

                            <div class="dt-form-grid-2">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">First Name <span style="color:#DC2626;">*</span></label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <input type="text" class="dt-input-field" placeholder="e.g. Radhika" required>
                                    </div>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Last Name</label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <input type="text" class="dt-input-field" placeholder="e.g. Verma">
                                    </div>
                                </div>
                            </div>

                            <div class="dt-form-grid-2" style="margin-top:14px;">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Mobile Phone Number <span style="color:#DC2626;">*</span></label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        <input type="tel" class="dt-input-field" placeholder="+91 98XXX XXXXX" required>
                                    </div>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Preferred Communication Language</label>
                                    <select class="dt-cust-select" style="width:100%; height:38px;">
                                        <optgroup label="── Primary Commercial Languages ──">
                                            <option value="Hindi" selected>Hindi (हिंदी)</option>
                                            <option value="Gujarati">Gujarati (ગુજરાતી)</option>
                                            <option value="English">English (India)</option>
                                            <option value="Hinglish">Hinglish (Hindi / English)</option>
                                            <option value="Marathi">Marathi (मराठी)</option>
                                            <option value="Marwari">Marwari / Rajasthani (मारवाड़ी)</option>
                                        </optgroup>
                                        <optgroup label="── South Indian Languages ──">
                                            <option value="Tamil">Tamil (தமிழ்)</option>
                                            <option value="Telugu">Telugu (తెలుగు)</option>
                                            <option value="Kannada">Kannada (ಕನ್ನಡ)</option>
                                            <option value="Malayalam">Malayalam (മലയാളം)</option>
                                        </optgroup>
                                        <optgroup label="── East & North-East Languages ──">
                                            <option value="Bengali">Bengali / Bangla (বাংলা)</option>
                                            <option value="Odia">Odia / Oriya (ଓଡ଼ିଆ)</option>
                                            <option value="Assamese">Assamese (অসমীয়া)</option>
                                            <option value="Manipuri">Manipuri (মৈতৈলোন্)</option>
                                            <option value="Bodo">Bodo (बोडो)</option>
                                            <option value="Santali">Santali (संथाली)</option>
                                        </optgroup>
                                        <optgroup label="── North & West Indian Languages ──">
                                            <option value="Punjabi">Punjabi (ਪੰਜਾਬੀ)</option>
                                            <option value="Bhojpuri">Bhojpuri (भोजपुरी)</option>
                                            <option value="Maithili">Maithili (मैथिली)</option>
                                            <option value="Urdu">Urdu (اردو)</option>
                                            <option value="Sindhi">Sindhi (सिंधी / سنڌي)</option>
                                            <option value="Konkani">Konkani (कोंकणी)</option>
                                            <option value="Dogri">Dogri (डोगरी)</option>
                                            <option value="Kashmiri">Kashmiri (कश्मीरी / کٲشُر)</option>
                                            <option value="Nepali">Nepali (नेपाली)</option>
                                            <option value="Sanskrit">Sanskrit (संस्कृतम्)</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="dt-form-grid-1" style="margin-top:14px;">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">
                                        <span>Email Address (Optional)</span>
                                        <span style="color:#78716C; font-size:0.65rem;">Can be added later</span>
                                    </label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <input type="email" class="dt-input-field" placeholder="radhika@example.com">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ══ SECTION 2: SHIPPING & LOCATION ══ -->
                        <div class="dt-edit-section">
                            <h3 class="dt-edit-section-title">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Default Shipping Address</span>
                            </h3>

                            <div class="dt-form-grid-2">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Country / Destination (195+ World Markets) <span style="color:#DC2626;">*</span></label>
                                    <div class="dt-country-picker-wrap" id="dtNewCountryPicker" data-selected-code="IN">
                                        <input type="hidden" name="country_code" class="dt-country-hidden-val" value="IN">
                                        <div class="dt-country-trigger">
                                            <div class="dt-country-trigger-left">
                                                <span class="dt-selected-flag">🇮🇳</span>
                                                <span class="dt-selected-name">India (Bharat)</span>
                                            </div>
                                            <svg class="dt-country-arrow" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                        </div>
                                        <div class="dt-country-dropdown">
                                            <div class="dt-country-search-box">
                                                <svg class="dt-country-search-icon" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                                <input type="text" class="dt-country-search-input" placeholder="Search 195+ countries (e.g. India, USA, UAE, UK)..." autocomplete="off">
                                            </div>
                                            <div class="dt-country-list">
                                                <!-- Dynamically populated & filtered by country-picker.js -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Nearby Landmark</label>
                                    <input type="text" class="dt-input-field no-icon" placeholder="e.g. Near City Bus Stand">
                                </div>
                            </div>

                            <div class="dt-form-group" style="margin-top:14px;">
                                <label class="dt-form-label">Street Address / House No.</label>
                                <input type="text" class="dt-input-field no-icon" placeholder="House/Flat No., Building Name, Street">
                            </div>

                            <div class="dt-form-grid-3" style="margin-top:14px;">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">City</label>
                                    <input type="text" class="dt-input-field no-icon" placeholder="e.g. Surat">
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">State / Province</label>
                                    <select class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="GJ" selected>Gujarat</option>
                                        <option value="MH">Maharashtra</option>
                                        <option value="DL">Delhi NCR</option>
                                        <option value="RJ">Rajasthan</option>
                                        <option value="WB">West Bengal</option>
                                        <option value="KA">Karnataka</option>
                                        <option value="TS">Telangana</option>
                                        <option value="UP">Uttar Pradesh</option>
                                        <option value="OTHER">Other / International State</option>
                                    </select>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">PIN Code / Postal Code</label>
                                    <input type="text" class="dt-input-field no-icon" placeholder="6-digit PIN / Zip">
                                </div>
                            </div>
                        </div>

                        <!-- ══ SECTION 3: CLASSIFICATION ══ -->
                        <div class="dt-edit-section">
                            <h3 class="dt-edit-section-title">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span>Account Tier &amp; Status</span>
                            </h3>

                            <div class="dt-form-grid-2">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Account Status</label>
                                    <select class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="active" selected>Active Verified</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Customer Tier</label>
                                    <select class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="regular" selected>Regular Direct Retail Shopper</option>
                                        <option value="vip">VIP High-Value Spender</option>
                                        <option value="new">New Registration</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ══ FORM ACTIONS FOOTER ══ -->
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:18px 22px; background:#FAF8F4; border-top:1.5px solid #F1ECE1;">
                            <a href="/Frontend/Admin/customers/index.php" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="submit" class="dt-btn dt-btn-gold">+ Save &amp; Create Customer</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/customers/assets/js/country-picker.js?v=<?php echo time(); ?>"></script>
</body>
</html>
