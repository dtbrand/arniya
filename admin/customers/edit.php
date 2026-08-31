<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * edit.php — Luxury Edit Customer Profile & CRM Preferences
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/CustomerManager.php';

use DTBrand\Database;
use DTBrand\CustomerManager;

$customer_id_raw = isset($_GET['id']) ? trim((string)$_GET['id']) : '';
$customer_id = (int)preg_replace('/[^0-9]/', '', $customer_id_raw);

$dbCust = $customer_id > 0 ? CustomerManager::getById($customer_id) : null;

// A missing customer used to fall through to a complete sample profile
// ("Pooja Sharma", a Rohini address, a date of birth) in an editable form. Hand
// the error to view.php, which states plainly that nothing matches the link.
if ($dbCust === null) {
    header('Location: /admin/customers/view.php?id=' . urlencode($customer_id_raw));
    exit;
}

$page_title = "Edit Customer #" . $customer_id;
$active_nav = "customers";
$active_subnav = "edit";

// Built only from columns that exist on the customers table. Every field below
// used to be overwritten with a literal even when the row was found: a real
// customer's edit form showed 'gender' => 'Female', a 1992 date of birth,
// 'city' => 'Surat', pincode 395002, 'tier' => 'vip', "6 orders" and
// "Rs 28,450" spent, plus a staff memo reading "Customer profile synchronized
// with live MySQL database."
$fullName = trim((string)($dbCust['name'] ?? ''));
$parts  = preg_split('/\s+/', $fullName, 2, PREG_SPLIT_NO_EMPTY) ?: [];
$fName  = $parts[0] ?? '';
$lName  = $parts[1] ?? '';

// The customers table has no address columns -- a shopper's street address
// lives in the `addresses` table, keyed by customer_id. Read the default one so
// the address block can show the real thing instead of a placeholder.
$defaultAddress = null;
$pdo = Database::getConnection();
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->prepare("
            SELECT `recipient_name`, `phone`, `address_line1`, `address_line2`,
                   `city`, `state`, `pincode`, `address_type`
            FROM `addresses`
            WHERE `customer_id` = ?
            ORDER BY `is_default` DESC, `id` ASC
            LIMIT 1
        ");
        $stmt->execute([$customer_id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) $defaultAddress = $row;
    } catch (\Exception $e) {}
}

$cust = [
    'first_name'  => $fName,
    'last_name'   => $lName,
    'initial'     => strtoupper(substr($fName, 0, 1) . substr($lName, 0, 1)) ?: '?',
    'avatarColor' => 'gold',
    'email'       => (string)($dbCust['email'] ?? ''),
    'phone'       => (string)($dbCust['phone'] ?? ''),
    'type'        => (string)($dbCust['type'] ?? 'retail'),
    'status'      => strtolower((string)($dbCust['status'] ?? 'active')),
    'tier'        => (string)($dbCust['tier'] ?? ''),
    'city'        => (string)($dbCust['city'] ?? ''),
    'state'       => (string)($dbCust['state'] ?? ''),
    'gstin'       => (string)($dbCust['gstin'] ?? ''),
    'pan'         => (string)($dbCust['pan'] ?? ''),
    'credit_limit'=> (float)($dbCust['credit_limit'] ?? 0),
    'orders'      => (int)($dbCust['total_orders'] ?? 0),
    'spent'       => '₹' . number_format((float)($dbCust['lifetime_spend'] ?? 0)),
    // The customers table has no address columns; these come from `addresses`
    // and are displayed read-only because no admin endpoint writes them.
    'address'     => $defaultAddress['address_line1'] ?? '',
    'landmark'    => $defaultAddress['address_line2'] ?? '',
    'pincode'     => $defaultAddress['pincode'] ?? '',
    // tier is the only classification with real storage; there is no tags table.
    'tags'        => trim((string)($dbCust['tier'] ?? '')) !== '' ? [trim((string)$dbCust['tier'])] : [],
];
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
        /* ════ MASTER RADIANT GOLD & SILVER LUXURY GLASS HERO BOX ════ */
        @keyframes dtAdminAmbientGlow {
            0% {
                background-position: 0% 0%, 100% 100%, 50% 0%, 0% 0%;
            }
            50% {
                background-position: 100% 50%, 0% 50%, 0% 100%, 0% 0%;
            }
            100% {
                background-position: 0% 0%, 100% 100%, 50% 0%, 0% 0%;
            }
        }

        .dt-hero-luxury-card {
            position: relative;
            background:
                radial-gradient(ellipse at 15% 40%, rgba(212, 175, 55, 0.45) 0%, transparent 65%),
                radial-gradient(ellipse at 85% 60%, rgba(245, 208, 92, 0.35) 0%, transparent 60%),
                radial-gradient(ellipse at 50% 10%, rgba(255, 255, 255, 0.12) 0%, transparent 50%),
                linear-gradient(135deg, rgba(38, 28, 14, 0.96) 0%, rgba(58, 44, 18, 0.92) 40%, rgba(42, 32, 16, 0.94) 75%, rgba(24, 18, 10, 0.98) 100%) !important;
            background-size: 200% 200%, 200% 200%, 200% 200%, 100% 100% !important;
            animation: dtAdminAmbientGlow 8s ease-in-out infinite alternate !important;
            -webkit-backdrop-filter: blur(20px) !important;
            backdrop-filter: blur(20px) !important;
            border: 2px solid #D4AF37 !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 36px rgba(0, 0, 0, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.45), inset 0 0 20px rgba(212, 175, 55, 0.3), 0 0 24px rgba(212, 175, 55, 0.35) !important;
            padding: 15px 20px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            gap: 14px !important;
            overflow: hidden !important;
        }

        .dt-hero-luxury-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, #FFE57F 20%, #FFFFFF 50%, #D4AF37 80%, transparent 100%);
            box-shadow: 0 0 10px rgba(255, 229, 127, 0.9);
            opacity: 1;
            z-index: 1;
        }

        .dt-hero-luxury-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, #D4AF37 30%, #FFE57F 50%, #D4AF37 70%, transparent 100%);
            opacity: 0.6;
            z-index: 1;
        }

        .dt-hero-title {
            font-size: 1.15rem !important;
            color: #FFFFFF !important;
            font-weight: 800 !important;
            letter-spacing: -0.011em !important;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.9) !important;
        }

        .dt-hero-subtitle {
            font-size: 0.78rem !important;
            color: #FEE685 !important;
            margin-top: 3px !important;
            font-weight: 700 !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.8) !important;
        }

        .dt-hero-metric-label {
            font-size: 0.68rem !important;
            color: #F5ECCE !important;
            text-transform: uppercase !important;
            font-weight: 800 !important;
            letter-spacing: 0.06em !important;
            display: block !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.8) !important;
        }

        .dt-hero-metric-gold {
            font-size: 1.28rem !important;
            color: #FFE57F !important;
            font-weight: 900 !important;
            letter-spacing: -0.01em !important;
            text-shadow: 0 2px 10px rgba(255, 229, 127, 0.6), 0 1px 3px rgba(0,0,0,0.9) !important;
        }

        .dt-hero-metric-white {
            font-size: 1.28rem !important;
            color: #FFFFFF !important;
            font-weight: 900 !important;
            letter-spacing: -0.01em !important;
            text-shadow: 0 2px 10px rgba(255, 255, 255, 0.5), 0 1px 3px rgba(0,0,0,0.9) !important;
        }

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
        .dt-email-status-box {
            margin-top: 6px;
            padding: 8px 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.72rem;
        }
        .dt-email-status-box.verified {
            background: #F0FDF4;
            border: 1px solid #86EFAC;
            color: #15803D;
        }
        .dt-email-status-box.missing {
            background: #FEF3C7;
            border: 1px solid #FCD34D;
            color: #B45309;
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
                <!-- Page Top Navigation Bar -->
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Edit Customer Profile</span>
                            <span class="dt-cust-badge gold">#<?php echo $customer_id; ?></span>
                            <?php /* Was a green "● Email Verified" pill shown whenever an email
                                     existed. Nothing verifies an address, so a value typed in by
                                     staff was presented as confirmed by the customer. */ ?>
                            <?php if (empty($cust['email'])): ?>
                                <span class="dt-status-pill inactive" style="font-size:0.65rem; background:#FEF3C7; color:#B45309; border-color:#FCD34D;">⚠️ Missing Email</span>
                            <?php endif; ?>
                        </h1>
                        <p class="dt-cust-subtitle">Update contact details, account type, tier and standing. Addresses are managed on the dossier.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">← Customer List</a>
                        <a href="/admin/customers/view.php?id=<?php echo $customer_id; ?>" class="dt-btn dt-btn-gold">View 360° Dossier ↗</a>
                    </div>
                </div>

                <!-- Customer Identity Quick Hero Bar (Luxury Gold & Silver Glassmorphic Design) -->
                <div class="dt-hero-luxury-card">
                    <div style="display:flex; align-items:center; gap:12px; position:relative; z-index:2;">
                        <div class="dt-cust-avatar <?php echo $cust['avatarColor']; ?>" style="width:46px; height:46px; font-size:1.15rem; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.3); border:1.5px solid rgba(212,175,55,0.4);">
                            <?php echo $cust['initial']; ?>
                        </div>
                        <div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <strong class="dt-hero-title"><?php echo htmlspecialchars(trim($cust['first_name'] . ' ' . $cust['last_name'])); ?></strong>
                                <?php /* A hardcoded "★ VIP" pill used to sit here on every customer,
                                         next to an "Registered Member" line, regardless of tier or
                                         standing. Show the real tier and the real status instead. */ ?>
                                <?php if (trim($cust['tier']) !== ''): ?>
                                    <span class="dt-status-pill vip" style="font-size:0.62rem; padding:2px 7px; background:linear-gradient(135deg, #B8860B 0%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F;"><?php echo htmlspecialchars(strtoupper($cust['tier'])); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="dt-hero-subtitle">
                                <span>Customer Account #<?php echo $customer_id; ?></span>
                                <span style="color:#D4AF37; margin:0 4px;">•</span>
                                <span style="color:#CBD5E1;"><?php echo htmlspecialchars(ucfirst($cust['type'])); ?> · <?php
                                    echo $cust['status'] === 'active' ? 'Active'
                                       : ($cust['status'] === 'pending' ? 'Awaiting Approval' : 'Suspended');
                                ?></span>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; align-items:center; gap:18px; position:relative; z-index:2;">
                        <div style="text-align:right;">
                            <span class="dt-hero-metric-label">Lifetime Value</span>
                            <strong class="dt-hero-metric-gold"><?php echo $cust['spent']; ?></strong>
                        </div>
                        <div style="text-align:right;">
                            <span class="dt-hero-metric-label">Total Orders</span>
                            <strong class="dt-hero-metric-white"><?php echo $cust['orders']; ?> Placed</strong>
                        </div>
                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $cust['phone']); ?>?text=<?php echo rawurlencode('Namaste ' . $cust['first_name']); ?>" target="_blank" class="dt-btn dt-btn-emerald dt-btn-sm" style="padding:6px 12px; font-size:0.75rem;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#FFFFFF" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                </div>

                <!-- Main Form Card -->
                <div class="dt-edit-card">
                    <?php /* This form used to carry an inline onsubmit that toasted
                             "Customer Profile Saved Successfully!" and navigated to the
                             dossier after one second without contacting the server at
                             all. Because an inline handler runs alongside (and before)
                             the addEventListener one further down, it also defeated the
                             real save: the redirect fired whether or not the write had
                             been accepted, so a rejected update looked exactly like a
                             stored one. The single save path is now the submit listener. */ ?>
                    <form id="dtCustEditForm" data-customer-id="<?php echo (int)$customer_id; ?>">
                        
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
                                        <input type="text" id="custEditFirstName" name="first_name" class="dt-input-field" value="<?php echo htmlspecialchars($cust['first_name']); ?>" required>
                                    </div>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Last Name</label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <input type="text" id="custEditLastName" name="last_name" class="dt-input-field" value="<?php echo htmlspecialchars($cust['last_name']); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="dt-form-grid-2" style="margin-top:14px;">
                                <!-- Phone -->
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Mobile Phone (WhatsApp Verified) <span style="color:#DC2626;">*</span></label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        <input type="tel" id="custEditPhone" name="phone" class="dt-input-field" value="<?php echo htmlspecialchars($cust['phone']); ?>" required>
                                    </div>
                                </div>

                                <!-- Preferred Language -->
                                <?php /* This was a 40-option select covering every scheduled Indian
                                         language, bound to a 'language' key the loader invented. The
                                         customers table has no language column and nothing in the
                                         project reads a preferred language, so every choice an admin
                                         made here was discarded on save. Replaced with the account
                                         type's real GST identifiers, which are stored. */ ?>
                                <div class="dt-form-group">
                                    <label class="dt-form-label">GSTIN (Trade Accounts)</label>
                                    <input type="text" id="custEditGstin" name="gstin" class="dt-input-field no-icon" value="<?php echo htmlspecialchars($cust['gstin']); ?>" placeholder="15-character GSTIN" maxlength="15" style="text-transform:uppercase;">
                                    <p style="font-size:0.68rem; color:#78716C; margin:5px 0 0 0;">Required for wholesale and reseller invoicing.</p>
                                </div>
                            </div>

                            <div class="dt-form-grid-1" style="margin-top:14px;">
                                <!-- Email Address & Verification / Missing Handling -->
                                <div class="dt-form-group">
                                    <label class="dt-form-label">
                                        <span>Customer Email Address</span>
                                        <?php /* This said "✓ Verified" whenever an email was present.
                                                 Nothing verifies it: there is no email_verified column
                                                 and no mailer in the project, so an address typed in by
                                                 staff was labelled confirmed by the customer. */ ?>
                                        <?php if (empty($cust['email'])): ?>
                                            <span style="color:#B45309; font-size:0.65rem; font-weight:800;">⚠️ Missing / Unlinked</span>
                                        <?php endif; ?>
                                    </label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <input type="email" id="dtCustEmailField" name="email" class="dt-input-field" placeholder="e.g. customer@gmail.com" value="<?php echo htmlspecialchars($cust['email']); ?>">
                                    </div>

                                    <!-- Email Action / Missing State Box -->
                                    <?php if (!empty($cust['email'])): ?>
                                        <div class="dt-email-status-box verified">
                                            <?php /* Was "Invoices and tracking links are dispatched to this
                                                     email", next to a Resend Verification button that only
                                                     raised a toast. No outbound mail is configured anywhere
                                                     in the project, so nothing was ever dispatched. */ ?>
                                            <span>On file for records. Order updates go out over WhatsApp — no email is sent from this site.</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="dt-email-status-box missing">
                                            <span>⚠️ No email address on file. Customer is registered via WhatsApp only.</span>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:2px 8px; font-size:0.68rem;" onclick="document.getElementById('dtCustEmailField').focus(); window.showToast('Please type customer email address above.');">+ Add Email</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- ══ SECTION 2: LOCATION & DEFAULT SHIPPING ADDRESS ══ -->
                        <?php
                        /*
                         * This section used to present a country picker, a landmark, a street
                         * address and a pincode as editable inputs. None of them can be saved:
                         * the customers table has no address columns, a shopper address lives in
                         * the `addresses` table, and /api/customers.php writes neither. So an
                         * admin correcting a delivery address was told the profile had saved
                         * while the courier kept the old one. Worse, the loader filled them with
                         * an invented Rohini address for every customer.
                         *
                         * The real default address is now shown read-only. City and State stay
                         * editable because those two ARE columns on customers (GST place of
                         * supply and shipping zone) and are included in the save.
                         */
                        $addrLine = trim((string)$cust['address']);
                        $addrMark = trim((string)$cust['landmark']);
                        $addrPin  = trim((string)$cust['pincode']);
                        $hasAddr  = ($addrLine !== '' || $addrMark !== '' || $addrPin !== '');
                        ?>
                        <div class="dt-edit-section">
                            <h3 class="dt-edit-section-title">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Location &amp; Default Shipping Address</span>
                            </h3>

                            <div class="dt-form-grid-2">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">City</label>
                                    <input type="text" id="custEditCity" name="city" class="dt-input-field no-icon" value="<?php echo htmlspecialchars($cust['city']); ?>" placeholder="e.g. Surat">
                                </div>

                                <div class="dt-form-group">
                                    <label id="custEditStateLabel" class="dt-form-label dt-state-label">State / Province</label>
                                    <?php
                                    // The eight options below are a static fallback; country-picker.js
                                    // replaces them when the country changes. A customer whose stored
                                    // state is not among them would have been silently rewritten to
                                    // whichever option came first, so carry the real value through.
                                    $stCur   = trim((string)$cust['state']);
                                    $stCodes = ['DL', 'GJ', 'MH', 'WB', 'RJ', 'KA', 'TS', 'UP'];
                                    $stKnown = in_array(strtoupper($stCur), $stCodes, true);
                                    ?>
                                    <select id="custEditState" name="state" class="dt-cust-select dt-state-select" data-initial-state="<?php echo htmlspecialchars($stCur); ?>" style="width:100%; height:38px;">
                                        <?php if (!$stKnown): ?>
                                            <option value="<?php echo htmlspecialchars($stCur); ?>" selected><?php echo $stCur === '' ? 'Not set' : htmlspecialchars($stCur) . ' (current)'; ?></option>
                                        <?php endif; ?>
                                        <option value="DL" <?php echo strtoupper($stCur) === 'DL' ? 'selected' : ''; ?>>Delhi NCR</option>
                                        <option value="GJ" <?php echo strtoupper($stCur) === 'GJ' ? 'selected' : ''; ?>>Gujarat</option>
                                        <option value="MH" <?php echo strtoupper($stCur) === 'MH' ? 'selected' : ''; ?>>Maharashtra</option>
                                        <option value="WB" <?php echo strtoupper($stCur) === 'WB' ? 'selected' : ''; ?>>West Bengal</option>
                                        <option value="RJ" <?php echo strtoupper($stCur) === 'RJ' ? 'selected' : ''; ?>>Rajasthan</option>
                                        <option value="KA" <?php echo strtoupper($stCur) === 'KA' ? 'selected' : ''; ?>>Karnataka</option>
                                        <option value="TS" <?php echo strtoupper($stCur) === 'TS' ? 'selected' : ''; ?>>Telangana</option>
                                        <option value="UP" <?php echo strtoupper($stCur) === 'UP' ? 'selected' : ''; ?>>Uttar Pradesh</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Default shipping address: read-only, managed on the Addresses tab -->
                            <div style="margin-top:14px; background:#FAF8F4; border:1px solid #EAE5D9; border-radius:10px; padding:12px 16px;">
                                <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px; flex-wrap:wrap;">
                                    <div>
                                        <strong style="font-size:0.78rem; color:#181512; display:block; margin-bottom:4px;">Default Shipping Address</strong>
                                        <?php if ($hasAddr): ?>
                                            <span style="font-size:0.76rem; color:#44403C; line-height:1.6; display:block;"><?php echo htmlspecialchars($addrLine); ?><?php if ($addrMark !== ''): ?><br><?php echo htmlspecialchars($addrMark); ?><?php endif; ?><?php if ($addrPin !== ''): ?><br>PIN <?php echo htmlspecialchars($addrPin); ?><?php endif; ?></span>
                                        <?php else: ?>
                                            <span style="font-size:0.76rem; color:#8C8478;">No saved address. The customer adds one at checkout.</span>
                                        <?php endif; ?>
                                        <span style="font-size:0.68rem; color:#78716C; display:block; margin-top:6px;">
                                            Street addresses are stored per address, not on the profile, so they are not editable here.
                                        </span>
                                    </div>
                                    <a href="/admin/customers/view.php?id=<?php echo (int)$customer_id; ?>" class="dt-btn dt-btn-pale dt-btn-sm" style="white-space:nowrap;">Addresses Tab &rarr;</a>
                                </div>
                            </div>
                        </div>

                        <!-- ══ SECTION 3: ACCOUNT STATUS, TIER & TAGS ══ -->
                        <div class="dt-edit-section">
                            <h3 class="dt-edit-section-title">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span>Account Classification &amp; Assigned Tags</span>
                            </h3>

                            <div class="dt-form-grid-2">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Account Standing / Status</label>
                                    <select id="custEditStatus" name="status" class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="active" <?php echo $cust['status'] === 'active' ? 'selected' : ''; ?>>Active Verified (Full Ordering Access)</option>
                                        <option value="pending" <?php echo $cust['status'] === 'pending' ? 'selected' : ''; ?>>Pending Approval (Cannot Sign In Yet)</option>
                                        <option value="suspended" <?php echo $cust['status'] === 'suspended' ? 'selected' : ''; ?>>Suspended (COD Protection &amp; Blocked)</option>
                                    </select>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Account Type / Pricing Group</label>
                                    <?php /* The form had no account-type control at all, so an approved
                                             trade buyer could not be moved onto wholesale pricing from
                                             here even though the column and the API accept it. */ ?>
                                    <select id="custEditType" name="type" class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="retail" <?php echo $cust['type'] === 'retail' ? 'selected' : ''; ?>>Retail Shopper (MRP Pricing)</option>
                                        <option value="wholesale" <?php echo $cust['type'] === 'wholesale' ? 'selected' : ''; ?>>Wholesale Buyer (Trade Pricing)</option>
                                        <option value="reseller" <?php echo $cust['type'] === 'reseller' ? 'selected' : ''; ?>>Reseller (Commission Pricing)</option>
                                    </select>
                                    <p style="font-size:0.68rem; color:#78716C; margin:5px 0 0 0;">Controls which price list this customer sees on the storefront.</p>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Customer Tier Category</label>
                                    <?php
                                    // tier is a free-text VARCHAR(50), so an existing value need not be
                                    // one of the three below. Carry it through rather than silently
                                    // rewriting it to whichever option happens to be first.
                                    $tierKnown = ['', 'vip', 'regular', 'new'];
                                    $tierCur   = strtolower(trim($cust['tier']));
                                    ?>
                                    <select id="custEditTier" name="tier" class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="" <?php echo $tierCur === '' ? 'selected' : ''; ?>>No tier assigned</option>
                                        <option value="vip" <?php echo $tierCur === 'vip' ? 'selected' : ''; ?>>VIP High-Value Spender</option>
                                        <option value="regular" <?php echo $tierCur === 'regular' ? 'selected' : ''; ?>>Regular Direct Retail Shopper</option>
                                        <option value="new" <?php echo $tierCur === 'new' ? 'selected' : ''; ?>>New Account Registration</option>
                                        <?php if (!in_array($tierCur, $tierKnown, true)): ?>
                                            <option value="<?php echo htmlspecialchars($cust['tier']); ?>" selected><?php echo htmlspecialchars($cust['tier']); ?> (current)</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Assigned Tags -->
                            <?php /* There is no tags table anywhere in the schema, and no column on
                                     customers holds them. The "Add Tag" button built a chip in the DOM
                                     and toasted "Tag added!", so every tag an admin created vanished on
                                     the next page load while they had been told it was assigned. Until
                                     tag storage exists this shows the one classification that is really
                                     stored -- the tier -- and says plainly that nothing else is. */ ?>
                            <div class="dt-form-group" style="margin-top:14px;">
                                <label class="dt-form-label">Assigned Customer Tags</label>
                                <div class="dt-cust-tags-wrap" style="gap:8px; margin-bottom:6px;">
                                    <?php if (count($cust['tags']) === 0): ?>
                                        <span style="font-size:0.74rem; color:#8C8478;">No tier assigned.</span>
                                    <?php else: ?>
                                        <?php foreach ($cust['tags'] as $tag): ?>
                                            <span class="dt-cust-tag-chip gold"><span><?php echo htmlspecialchars($tag); ?></span></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <p style="font-size:0.68rem; color:#78716C; margin:0; line-height:1.5;">
                                    Free-form tags are not stored yet — the database has no tags table, so
                                    anything added here could not be kept. Use <strong>Customer Tier Category</strong>
                                    above, which is saved, or leave an <a href="/admin/customers/view.php?id=<?php echo (int)$customer_id; ?>#notes" style="color:#8A681F; font-weight:700;">internal note</a>.
                                </p>
                            </div>
                        </div>

                        <!-- ══ SECTION 4: SECURITY & INTERNAL STAFF MEMO ══ -->
                        <div class="dt-edit-section">
                            <h3 class="dt-edit-section-title">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <span>Security, Password &amp; Internal Staff Memo</span>
                            </h3>

                            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:10px; padding:12px 16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                                <div>
                                    <strong style="font-size:0.8rem; color:#181512; display:block;">Secure Password Reset</strong>
                                    <span style="font-size:0.72rem; color:#78716C;">No automated SMS/email sender is configured. This opens WhatsApp so you can help the customer reset their password.</span>
                                </div>
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:6px;" onclick="dtSendResetLink('<?php echo htmlspecialchars($cust['phone'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars(addslashes($cust['first_name'] ?? ''), ENT_QUOTES); ?>')">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <span>Reset via WhatsApp</span>
                                </button>
                            </div>

                            <div class="dt-form-group">
                                <label class="dt-form-label">Internal Staff Confidential Memo (Admin Only)</label>
                                <?php /* This textarea was prefilled with the literal "Customer profile
                                         synchronized with live MySQL database." for every customer and
                                         had nowhere to save to. It now writes a real row to
                                         customer_notes when Save is pressed, alongside the profile
                                         update, and appears on the dossier's Notes tab. */ ?>
                                <textarea id="custEditMemo" name="staff_memo" class="dt-input-field no-icon" style="height:70px; resize:none; padding-top:8px;" placeholder="Add an internal note — preferred courier, packaging remarks, call outcome..."></textarea>
                                <p style="font-size:0.68rem; color:#78716C; margin:5px 0 0 0;">
                                    Saved as a new dated note on this customer.
                                    <a href="/admin/customers/view.php?id=<?php echo (int)$customer_id; ?>" style="color:#8A681F; font-weight:700;">View all notes →</a>
                                </p>
                            </div>
                        </div>

                        <!-- ══ FORM ACTIONS FOOTER ══ -->
                        <div style="display:flex; align-items:center; justify-content:space-between; padding:18px 22px; background:#FAF8F4; border-top:1.5px solid #F1ECE1; flex-wrap:wrap; gap:10px;">
                            <button type="button" class="dt-btn dt-btn-danger" style="display:inline-flex; align-items:center; gap:6px;" onclick="dtDeactivateCustomer(<?php echo (int)$customer_id; ?>)">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                <span>Deactivate Account</span>
                            </button>
                            
                            <div style="display:flex; align-items:center; gap:10px;">
                                <a href="/admin/customers/view.php?id=<?php echo $customer_id; ?>" class="dt-btn dt-btn-pale">Cancel</a>
                                <button type="submit" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px;">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span>Save Customer Profile</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function dtCustomerToast(message) {
    if (typeof window.showToast === 'function') { window.showToast(message); }
    else { alert(message); }
}

/* Deactivating suspends the account, which blocks sign-in and (for a trade
   buyer) revokes wholesale/reseller pricing. Confirm the server actually did it
   before saying so — /api/customers.php requires an admin session and will
   answer 401 if it has expired. */
function dtDeactivateCustomer(id) {
    if (!confirm('Deactivate customer account #' + id + '? They will no longer be able to sign in.')) return;

    var params = new URLSearchParams();
    params.append('action', 'update_status');
    params.append('id', id);
    params.append('status', 'suspended');

    fetch('/api/customers.php', { method: 'POST', body: params })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data && data.success) {
                dtCustomerToast('✓ Account #' + id + ' deactivated.');
                setTimeout(function () { window.location.href = '/admin/customers/view.php?id=' + id; }, 600);
            } else {
                dtCustomerToast('⚠ ' + ((data && data.message) || 'The account was NOT deactivated.'));
            }
        })
        .catch(function () {
            dtCustomerToast('⚠ Network error — the account was NOT deactivated.');
        });
}

/* There is no automated SMS/email sender wired up in this project, so this
   cannot silently claim a link was dispatched. Auth::requestPasswordReset
   stores the token; delivery is done by hand over WhatsApp. */
function dtSendResetLink(phone, name) {
    var digits = String(phone || '').replace(/\D+/g, '');
    if (digits.length === 10) { digits = '91' + digits; }
    if (!digits) {
        dtCustomerToast('⚠ This customer has no phone number on file.');
        return;
    }
    var msg = 'Namaste ' + (name || 'ji') + ', this is DT Brand\'s & Jai Hanuman Tex. '
            + 'To reset your account password, please reply here and our team will help you set a new one.';
    window.open('https://wa.me/' + digits + '?text=' + encodeURIComponent(msg), '_blank');
    dtCustomerToast('WhatsApp opened — send the message to start the reset.');
}

document.addEventListener('DOMContentLoaded', function() {
    /* Was document.querySelector('form') -- the first form in the document, which
       is only this one by luck; a search box added to the header would have stolen
       the handler and left Save doing nothing. */
    const editForm = document.getElementById('dtCustEditForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const id = <?= json_encode($customer_id) ?>;

            /* Fields are read by name. The previous version matched on the mock
               placeholders ("Pooja", "Sharma"), and read status with
               select[name="status"] when that select had no name attribute at all
               -- so it always fell back to 'active' and every save silently
               reactivated a suspended customer. */
            const val = (sel) => {
                const el = editForm.querySelector(sel);
                return el ? String(el.value).trim() : '';
            };

            const fName = val('input[name="first_name"]');
            const lName = val('input[name="last_name"]');
            const name  = (fName + ' ' + lName).trim();
            if (!name) {
                dtCustomerToast('⚠ A customer name is required.');
                return;
            }

            const params = new URLSearchParams();
            params.append('action', 'update');
            params.append('id', id);
            params.append('name', name);
            params.append('email', val('input[name="email"]'));
            params.append('phone', val('input[name="phone"]'));
            params.append('status', val('select[name="status"]'));
            /* city, state, tier and type are real columns that /api/customers.php
               accepts, but they were left out of the payload -- the form offered
               them as editable and then dropped every change. */
            params.append('type',  val('select[name="type"]'));
            params.append('tier',  val('select[name="tier"]'));
            params.append('city',  val('input[name="city"]'));
            params.append('state', val('select[name="state"]'));
            params.append('gstin', val('input[name="gstin"]').toUpperCase());

            const memo = val('textarea[name="staff_memo"]');
            const saveBtn = editForm.querySelector('button[type="submit"]');
            if (saveBtn) saveBtn.disabled = true;

            /* Only navigate away on a confirmed save. Previously both .then and
               .catch reported success and redirected, so a rejected write looked
               identical to a stored one and the edits were silently lost. */
            fetch('/api/customers.php', { method: 'POST', body: params, credentials: 'same-origin' })
                .then(res => res.json())
                .then(data => {
                    if (!data || !data.success) {
                        if (saveBtn) saveBtn.disabled = false;
                        dtCustomerToast('⚠ ' + ((data && data.message) || `"${name}" was NOT saved. Your changes are still on screen.`));
                        return;
                    }

                    /* The memo is a separate row in customer_notes, so it is a
                       second request. The profile is already saved at this point;
                       if the note fails, say so instead of implying both stored. */
                    if (!memo) {
                        dtCustomerToast(`✨ Customer "${name}" saved to database!`);
                        setTimeout(() => { window.location.href = `/admin/customers/view.php?id=${id}`; }, 500);
                        return;
                    }

                    fetch('/api/customer_notes.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin',
                        body: JSON.stringify({ customer_id: id, note_text: memo, is_important: 0 })
                    })
                        .then(r => r.json().catch(() => ({ success: false })))
                        .then(nd => {
                            if (nd && nd.success) {
                                dtCustomerToast(`✨ Customer "${name}" and the staff note were saved!`);
                            } else {
                                dtCustomerToast('✓ Profile saved, but the staff note was not: ' + ((nd && nd.message) || 'notes storage is unavailable.'));
                            }
                            setTimeout(() => { window.location.href = `/admin/customers/view.php?id=${id}`; }, 900);
                        })
                        .catch(() => {
                            dtCustomerToast('✓ Profile saved, but the staff note could not be sent.');
                            setTimeout(() => { window.location.href = `/admin/customers/view.php?id=${id}`; }, 900);
                        });
                })
                .catch(() => {
                    if (saveBtn) saveBtn.disabled = false;
                    dtCustomerToast(`⚠ Network error — "${name}" was NOT saved. Your changes are still on screen.`);
                });
        });
    }
});
</script>
<script src="/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<?php /* country-picker.js is no longer loaded here. It drives .dt-country-picker-wrap,
        and this form no longer has one: `customers` has no country column, so the
        picker collected a country that was discarded on save. Its only remaining
        effect would be applyCountryAutoFields() rewriting the State select. */ ?>
</body>
</html>
