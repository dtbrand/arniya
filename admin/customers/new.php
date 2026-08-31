<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

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
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-profile.css?v=<?php echo time(); ?>">
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
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">← Back to Directory</a>
                    </div>
                </div>

                <!-- Add Customer Form Card -->
                <div class="dt-edit-card">
                    <?php /* This form used to carry an inline onsubmit that toasted
                             "Customer Account Created Successfully!" and redirected to the
                             customer list after one second without contacting the server at
                             all. No row was ever inserted, so an admin who registered a
                             walk-in buyer was told the account existed and then could not
                             find it. It now posts to /api/customers.php. */ ?>
                    <form id="dtCustNewForm">
                        
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
                                        <input type="text" id="custNewFirstName" name="first_name" class="dt-input-field" placeholder="e.g. Radhika" required>
                                    </div>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Last Name</label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <input type="text" id="custNewLastName" name="last_name" class="dt-input-field" placeholder="e.g. Verma">
                                    </div>
                                </div>
                            </div>

                            <div class="dt-form-grid-2" style="margin-top:14px;">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Mobile Phone Number <span style="color:#DC2626;">*</span></label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        <input type="tel" id="custNewPhone" name="phone" class="dt-input-field" placeholder="+91 98XXX XXXXX" required>
                                    </div>
                                </div>

                                <?php /* Was a 40-option "Preferred Communication Language" select.
                                         The customers table has no language column and nothing in
                                         the project reads a preferred language, so every choice was
                                         discarded on submit. Replaced with GSTIN, which is stored
                                         and is what a trade account actually needs. */ ?>
                                <div class="dt-form-group">
                                    <label class="dt-form-label">GSTIN (Wholesale / Reseller only)</label>
                                    <input type="text" id="custNewGstin" name="gstin" class="dt-input-field no-icon" placeholder="15-character GSTIN" maxlength="15" style="text-transform:uppercase;">
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
                                        <input type="email" id="custNewEmail" name="email" class="dt-input-field" placeholder="radhika@example.com">
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

                            <?php /* The country picker wrote a country_code field that no table
                                     holds; every account is shipped domestically. Removed so the
                                     form only asks for what it can store. */ ?>
                            <div class="dt-form-grid-2">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Nearby Landmark</label>
                                    <input type="text" id="custNewLandmark" name="landmark" class="dt-input-field no-icon" placeholder="e.g. Near City Bus Stand / Textile Market Gate / Ring Road">
                                </div>
                            </div>

                            <div class="dt-form-group" style="margin-top:14px;">
                                <label class="dt-form-label">Street Address / House No.</label>
                                <input type="text" id="custNewAddress" name="address" class="dt-input-field no-icon" placeholder="House/Flat No., Building Name, Street / Society">
                            </div>

                            <div class="dt-form-grid-3" style="margin-top:14px;">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">City</label>
                                    <input type="text" id="custNewCity" name="city" class="dt-input-field no-icon" placeholder="e.g. Surat, Mumbai, Delhi, Ahmedabad, Jaipur">
                                </div>

                                <div class="dt-form-group">
                                    <label id="custNewStateLabel" class="dt-form-label dt-state-label">State / Union Territory</label>
                                    <select id="custNewState" name="state" class="dt-cust-select dt-state-select" style="width:100%; height:38px;">
                                        <!-- A fixed list. country-picker.js used to rewrite this
                                             select, but it is no longer loaded on this page, so
                                             these nine options are the whole list. -->
                                        <option value="GJ" selected>Gujarat</option>
                                        <option value="MH">Maharashtra</option>
                                        <option value="DL">Delhi NCR</option>
                                        <option value="RJ">Rajasthan</option>
                                        <option value="WB">West Bengal</option>
                                        <option value="KA">Karnataka</option>
                                        <option value="TS">Telangana</option>
                                        <option value="UP">Uttar Pradesh</option>
                                        <option value="">Other / Not listed</option>
                                    </select>
                                </div>

                                <div class="dt-form-group">
                                    <label id="custNewPostalLabel" class="dt-form-label dt-postal-label">PIN Code (6-Digit)</label>
                                    <input type="text" id="custNewPostalCode" name="postal_code" class="dt-input-field no-icon" placeholder="e.g. 395002">
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
                                <?php /* Neither select had a name attribute, so nothing could read
                                         them, and Status offered "Inactive" -- a value the ENUM
                                         (active|pending|suspended) cannot hold and which MySQL would
                                         silently coerce to an empty string. Account Type was missing
                                         altogether, so every customer an admin created was retail
                                         and a wholesale buyer got MRP pricing. */ ?>
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Account Type / Pricing Group</label>
                                    <select id="custNewType" name="type" class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="retail" selected>Retail Shopper (MRP Pricing)</option>
                                        <option value="wholesale">Wholesale Buyer (Trade Pricing)</option>
                                        <option value="reseller">Reseller (Commission Pricing)</option>
                                    </select>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Account Status</label>
                                    <select id="custNewStatus" name="status" class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="active" selected>Active (Can Sign In &amp; Order)</option>
                                        <option value="pending">Pending Approval (Cannot Sign In Yet)</option>
                                        <option value="suspended">Suspended (Blocked)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="dt-form-grid-2" style="margin-top:14px;">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Customer Tier</label>
                                    <select id="custNewTier" name="tier" class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="" selected>No tier assigned</option>
                                        <option value="regular">Regular Direct Retail Shopper</option>
                                        <option value="vip">VIP High-Value Spender</option>
                                        <option value="new">New Registration</option>
                                    </select>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Credit Limit (Trade Accounts)</label>
                                    <input type="number" id="custNewCreditLimit" name="credit_limit" class="dt-input-field no-icon" value="0" min="0" step="100">
                                    <p style="font-size:0.68rem; color:#78716C; margin:5px 0 0 0;">Stock value this buyer may take before paying. Leave 0 for prepaid.</p>
                                </div>
                            </div>

                            <div style="margin-top:14px; background:#FAF8F4; border:1px solid #EAE5D9; border-radius:10px; padding:11px 14px;">
                                <p style="font-size:0.7rem; color:#645D54; margin:0; line-height:1.55;">
                                    No password is set here. A random secret is stored, so the customer
                                    signs in only after a reset you send them over WhatsApp from their profile.
                                </p>
                            </div>
                        </div>

                        <!-- ══ FORM ACTIONS FOOTER ══ -->
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:18px 22px; background:#FAF8F4; border-top:1.5px solid #F1ECE1;">
                            <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="submit" class="dt-btn dt-btn-gold">+ Save &amp; Create Customer</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function dtNewCustToast(message) {
    if (typeof window.showToast === 'function') { window.showToast(message); }
    else { alert(message); }
}

document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('dtCustNewForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        function val(sel) {
            var el = form.querySelector(sel);
            return el ? String(el.value).trim() : '';
        }

        var name = (val('input[name="first_name"]') + ' ' + val('input[name="last_name"]')).trim();
        var phone = val('input[name="phone"]');
        if (!name) { dtNewCustToast('\u26a0 A customer name is required.'); return; }
        if (!phone) { dtNewCustToast('\u26a0 A phone number is required \u2014 it is the login identity.'); return; }

        var params = new URLSearchParams();
        params.append('action', 'create');
        params.append('name', name);
        params.append('phone', phone);
        params.append('email', val('input[name="email"]'));
        params.append('gstin', val('input[name="gstin"]').toUpperCase());
        params.append('type', val('select[name="type"]'));
        params.append('status', val('select[name="status"]'));
        params.append('tier', val('select[name="tier"]'));
        params.append('city', val('input[name="city"]'));
        params.append('state', val('select[name="state"]'));
        params.append('credit_limit', val('input[name="credit_limit"]') || '0');
        params.append('address', val('input[name="address"]'));
        params.append('landmark', val('input[name="landmark"]'));
        params.append('postal_code', val('input[name="postal_code"]'));

        var btn = form.querySelector('button[type="submit"]');
        if (btn) btn.disabled = true;

        /* Only navigate away on a confirmed insert. The duplicate-phone case
           matters here: customers.phone is UNIQUE and is the login identity, so
           a second account on the same number is rejected by the server and the
           admin needs to see that message rather than a success toast. */
        fetch('/api/customers.php', { method: 'POST', body: params, credentials: 'same-origin' })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data && data.success) {
                    dtNewCustToast('\u2728 ' + (data.message || 'Customer created.'));
                    setTimeout(function () {
                        window.location.href = '/admin/customers/view.php?id=' + encodeURIComponent(data.id);
                    }, 700);
                } else {
                    if (btn) btn.disabled = false;
                    dtNewCustToast('\u26a0 ' + ((data && data.message) || 'The customer was NOT created.'));
                }
            })
            .catch(function () {
                if (btn) btn.disabled = false;
                dtNewCustToast('\u26a0 Network error \u2014 the customer was NOT created.');
            });
    });
});
</script>
<script src="/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<?php /* country-picker.js is no longer loaded here — see the note in the address
        section. There is no .dt-country-picker-wrap left on this form for it to
        bind to, and no country column for it to write into. */ ?>
</body>
</html>
