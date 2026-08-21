<?php
/**
 * edit.php — Luxury Edit Customer Profile & CRM Preferences
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$customer_id = isset($_GET['id']) ? htmlspecialchars(trim($_GET['id'])) : 'CUST-1042';
$page_title = "Edit Customer #" . $customer_id;
$active_nav = "customers";
$active_subnav = "edit";

// Mock Database of Customers for Dynamic Prefilling
$customers_db = [
    'CUST-1042' => [
        'first_name' => 'Pooja',
        'last_name' => 'Sharma',
        'initial' => 'PS',
        'avatarColor' => 'gold',
        'email' => 'pooja.sharma92@gmail.com',
        'email_verified' => true,
        'phone' => '+91 98110 29381',
        'gender' => 'Female',
        'dob' => '1992-08-14',
        'anniversary' => '2018-11-25',
        'language' => 'Hindi',
        'type' => 'Retail Verified',
        'status' => 'active',
        'tier' => 'vip',
        'address' => 'Plot No. 42, Pocket B-4, Sector 11',
        'landmark' => 'Opposite Rohini West Metro Station',
        'city' => 'Delhi',
        'state' => 'DL',
        'pincode' => '110085',
        'orders' => 6,
        'spent' => '₹28,450',
        'tags' => ['VIP High-Value', 'Saree Lover', 'Frequent Buyer'],
        'notes' => 'Customer prefers premium gold gift packaging for all wedding sari orders. Always dispatch with DT Brand\'s silk mark certificate.',
        'opt_wa' => true,
        'opt_sms' => true,
        'opt_email' => true
    ],
    'CUST-1041' => [
        'first_name' => 'Ananya',
        'last_name' => 'Roy',
        'initial' => 'AR',
        'avatarColor' => 'emerald',
        'email' => 'ananya.roy.kolkata@yahoo.com',
        'email_verified' => true,
        'phone' => '+91 97118 23901',
        'gender' => 'Female',
        'dob' => '1995-04-12',
        'anniversary' => '',
        'language' => 'Bengali',
        'type' => 'Retail Verified',
        'status' => 'active',
        'tier' => 'regular',
        'address' => 'Flat 3B, Lake View Residency, Salt Lake Sector 5',
        'landmark' => 'Near Karunamoyee Bus Terminus',
        'city' => 'Kolkata',
        'state' => 'WB',
        'pincode' => '700091',
        'orders' => 4,
        'spent' => '₹19,800',
        'tags' => ['Silk Certified', 'High Value'],
        'notes' => 'Verified delivery address with landmark.',
        'opt_wa' => true,
        'opt_sms' => true,
        'opt_email' => false
    ],
    'CUST-1040' => [
        'first_name' => 'Ritu',
        'last_name' => 'Rajvansh',
        'initial' => 'RR',
        'avatarColor' => 'purple',
        'email' => 'ritu.rajvansh@outlook.com',
        'email_verified' => true,
        'phone' => '+91 94250 88219',
        'gender' => 'Female',
        'dob' => '1990-11-08',
        'anniversary' => '2015-02-14',
        'language' => 'Hindi',
        'type' => 'Retail Verified',
        'status' => 'active',
        'tier' => 'vip',
        'address' => 'B-12, Vaishali Nagar, Gandhi Path',
        'landmark' => 'Behind National Handloom',
        'city' => 'Jaipur',
        'state' => 'RJ',
        'pincode' => '302021',
        'orders' => 8,
        'spent' => '₹42,900',
        'tags' => ['VIP', 'Bridal Lehenga', 'Top 1%'],
        'notes' => 'Heavy bridal lehenga buyer. Express priority courier delivery.',
        'opt_wa' => true,
        'opt_sms' => true,
        'opt_email' => true
    ],
    'CUST-1036' => [
        'first_name' => 'Deepika',
        'last_name' => 'Sen',
        'initial' => 'DS',
        'avatarColor' => 'purple',
        'email' => '', // Missing email demonstration
        'email_verified' => false,
        'phone' => '+91 98450 77123',
        'gender' => 'Female',
        'dob' => '',
        'anniversary' => '',
        'language' => 'English',
        'type' => 'Direct Shopper',
        'status' => 'new',
        'tier' => 'regular',
        'address' => '104, 2nd Main, Indiranagar',
        'landmark' => 'Near 100ft Road Metro',
        'city' => 'Bengaluru',
        'state' => 'KA',
        'pincode' => '560038',
        'orders' => 0,
        'spent' => '₹0',
        'tags' => ['New Registration', 'No Orders'],
        'notes' => 'Registered via WhatsApp OTP. Email address not yet linked.',
        'opt_wa' => true,
        'opt_sms' => true,
        'opt_email' => false
    ]
];

// Resolve current customer or fallback to default
$cust = isset($customers_db[$customer_id]) ? $customers_db[$customer_id] : [
    'first_name' => 'Pooja',
    'last_name' => 'Sharma',
    'initial' => 'PS',
    'avatarColor' => 'gold',
    'email' => 'pooja.sharma92@gmail.com',
    'email_verified' => true,
    'phone' => '+91 98110 29381',
    'gender' => 'Female',
    'dob' => '1992-08-14',
    'anniversary' => '2018-11-25',
    'language' => 'Hindi',
    'type' => 'Retail Verified',
    'status' => 'active',
    'tier' => 'vip',
    'address' => 'Plot No. 42, Pocket B-4, Sector 11',
    'landmark' => 'Opposite Rohini West Metro Station',
    'city' => 'Delhi',
    'state' => 'DL',
    'pincode' => '110085',
    'orders' => 6,
    'spent' => '₹28,450',
    'tags' => ['VIP High-Value', 'Saree Lover', 'Frequent Buyer'],
    'notes' => 'Customer prefers premium gold gift packaging for all wedding sari orders.',
    'opt_wa' => true,
    'opt_sms' => true,
    'opt_email' => true
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-profile.css?v=<?php echo time(); ?>">
    <style>
        /* ════ MASTER LUXURY GOLD & SILVER/PLATINUM GLASS HERO BOX ════ */
        @keyframes dtAdminAmbientLiningShimmer {
            0% {
                background-position: 0% 0%, 0% 0%, 0% 0%;
            }
            50% {
                background-position: 0% 0%, 100% 100%, -100% 100%;
            }
            100% {
                background-position: 0% 0%, 0% 0%, 0% 0%;
            }
        }

        .dt-hero-luxury-card {
            position: relative;
            background:
                linear-gradient(135deg, rgba(18, 15, 12, 0.86) 0%, rgba(28, 23, 17, 0.82) 50%, rgba(15, 19, 26, 0.88) 100%),
                repeating-linear-gradient(45deg, rgba(212, 175, 55, 0.20) 0px, rgba(212, 175, 55, 0.20) 1.5px, transparent 1.5px, transparent 16px),
                repeating-linear-gradient(-45deg, rgba(226, 232, 240, 0.16) 0px, rgba(226, 232, 240, 0.16) 1.5px, transparent 1.5px, transparent 16px) !important;
            background-size: 100% 100%, 300% 300%, 300% 300% !important;
            animation: dtAdminAmbientLiningShimmer 10s ease-in-out infinite alternate !important;
            -webkit-backdrop-filter: blur(20px) !important;
            backdrop-filter: blur(20px) !important;
            border: 1.5px solid rgba(212, 175, 55, 0.65) !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 36px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.25), inset 0 -1px 0 rgba(212, 175, 55, 0.3), 0 0 28px rgba(212, 175, 55, 0.2) !important;
            padding: 14px 18px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            gap: 12px !important;
            overflow: hidden !important;
        }

        .dt-hero-luxury-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1.5px;
            background: linear-gradient(90deg, transparent 0%, #D4AF37 25%, #FFFFFF 50%, #E2E8F0 75%, transparent 100%);
            opacity: 0.95;
            z-index: 1;
        }

        .dt-hero-title {
            font-size: 1.12rem !important;
            color: #FFFFFF !important;
            font-weight: 800 !important;
            letter-spacing: -0.011em !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8) !important;
        }

        .dt-hero-subtitle {
            font-size: 0.76rem !important;
            color: #FAF5E8 !important;
            margin-top: 2px !important;
            font-weight: 600 !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6) !important;
        }

        .dt-hero-metric-label {
            font-size: 0.68rem !important;
            color: #E2E8F0 !important;
            text-transform: uppercase !important;
            font-weight: 800 !important;
            letter-spacing: 0.05em !important;
            display: block !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6) !important;
        }

        .dt-hero-metric-gold {
            font-size: 1.2rem !important;
            color: #FDE047 !important;
            font-weight: 900 !important;
            letter-spacing: -0.01em !important;
            text-shadow: 0 2px 8px rgba(253, 224, 71, 0.4), 0 1px 2px rgba(0,0,0,0.8) !important;
        }

        .dt-hero-metric-white {
            font-size: 1.2rem !important;
            color: #FFFFFF !important;
            font-weight: 900 !important;
            letter-spacing: -0.01em !important;
            text-shadow: 0 2px 8px rgba(255, 255, 255, 0.4), 0 1px 2px rgba(0,0,0,0.8) !important;
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
                            <?php if (!empty($cust['email'])): ?>
                                <span class="dt-status-pill active" style="font-size:0.65rem;">● Email Verified</span>
                            <?php else: ?>
                                <span class="dt-status-pill inactive" style="font-size:0.65rem; background:#FEF3C7; color:#B45309; border-color:#FCD34D;">⚠️ Missing Email</span>
                            <?php endif; ?>
                        </h1>
                        <p class="dt-cust-subtitle">Update contact details, verified email credentials, shipping address, customer tier, and staff memos.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/Frontend/Admin/customers/index.php" class="dt-btn dt-btn-pale">← Customer List</a>
                        <a href="/Frontend/Admin/customers/view.php?id=<?php echo $customer_id; ?>" class="dt-btn dt-btn-gold">View 360° Dossier ↗</a>
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
                                <strong class="dt-hero-title"><?php echo $cust['first_name'] . ' ' . $cust['last_name']; ?></strong>
                                <span class="dt-status-pill vip" style="font-size:0.62rem; padding:2px 7px; background:linear-gradient(135deg, #B8860B 0%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F;">★ VIP</span>
                            </div>
                            <div class="dt-hero-subtitle">
                                <span>Customer Account #<?php echo $customer_id; ?></span>
                                <span style="color:#D4AF37; margin:0 4px;">•</span>
                                <span style="color:#CBD5E1;">Registered Member</span>
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
                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $cust['phone']); ?>?text=Hello%20<?php echo urlencode($cust['first_name']); ?>" target="_blank" class="dt-btn dt-btn-emerald dt-btn-sm" style="padding:6px 12px; font-size:0.75rem;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#FFFFFF" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                </div>

                <!-- Main Form Card -->
                <div class="dt-edit-card">
                    <form onsubmit="event.preventDefault(); window.showToast('✓ Customer Profile Saved Successfully!'); setTimeout(() => window.location.href='/Frontend/Admin/customers/view.php?id=<?php echo $customer_id; ?>', 1000);">
                        
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
                                        <input type="text" class="dt-input-field" value="<?php echo htmlspecialchars($cust['first_name']); ?>" required>
                                    </div>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Last Name</label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <input type="text" class="dt-input-field" value="<?php echo htmlspecialchars($cust['last_name']); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="dt-form-grid-2" style="margin-top:14px;">
                                <!-- Phone -->
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Mobile Phone (WhatsApp Verified) <span style="color:#DC2626;">*</span></label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        <input type="tel" class="dt-input-field" value="<?php echo htmlspecialchars($cust['phone']); ?>" required>
                                    </div>
                                </div>

                                <!-- Preferred Language (All Official Indian Languages) -->
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Preferred Communication Language (All Indian Languages)</label>
                                    <select class="dt-cust-select" style="width:100%; height:38px;">
                                        <optgroup label="── Primary Commercial Languages ──">
                                            <option value="Hindi" <?php echo ($cust['language'] === 'Hindi') ? 'selected' : ''; ?>>Hindi (हिंदी)</option>
                                            <option value="Gujarati" <?php echo ($cust['language'] === 'Gujarati') ? 'selected' : ''; ?>>Gujarati (ગુજરાતી)</option>
                                            <option value="English" <?php echo ($cust['language'] === 'English') ? 'selected' : ''; ?>>English (India)</option>
                                            <option value="Hinglish" <?php echo ($cust['language'] === 'Hinglish') ? 'selected' : ''; ?>>Hinglish (Hindi / English)</option>
                                            <option value="Marathi" <?php echo ($cust['language'] === 'Marathi') ? 'selected' : ''; ?>>Marathi (मराठी)</option>
                                            <option value="Marwari" <?php echo ($cust['language'] === 'Marwari') ? 'selected' : ''; ?>>Marwari / Rajasthani (मारवाड़ी)</option>
                                        </optgroup>
                                        <optgroup label="── South Indian Languages ──">
                                            <option value="Tamil" <?php echo ($cust['language'] === 'Tamil') ? 'selected' : ''; ?>>Tamil (தமிழ்)</option>
                                            <option value="Telugu" <?php echo ($cust['language'] === 'Telugu') ? 'selected' : ''; ?>>Telugu (తెలుగు)</option>
                                            <option value="Kannada" <?php echo ($cust['language'] === 'Kannada') ? 'selected' : ''; ?>>Kannada (ಕನ್ನಡ)</option>
                                            <option value="Malayalam" <?php echo ($cust['language'] === 'Malayalam') ? 'selected' : ''; ?>>Malayalam (മലയാളം)</option>
                                        </optgroup>
                                        <optgroup label="── East & North-East Languages ──">
                                            <option value="Bengali" <?php echo ($cust['language'] === 'Bengali') ? 'selected' : ''; ?>>Bengali / Bangla (বাংলা)</option>
                                            <option value="Odia" <?php echo ($cust['language'] === 'Odia') ? 'selected' : ''; ?>>Odia / Oriya (ଓଡ଼ିଆ)</option>
                                            <option value="Assamese" <?php echo ($cust['language'] === 'Assamese') ? 'selected' : ''; ?>>Assamese (অসমীয়া)</option>
                                            <option value="Manipuri" <?php echo ($cust['language'] === 'Manipuri') ? 'selected' : ''; ?>>Manipuri (মৈতৈলোন্)</option>
                                            <option value="Bodo" <?php echo ($cust['language'] === 'Bodo') ? 'selected' : ''; ?>>Bodo (बोडो)</option>
                                            <option value="Santali" <?php echo ($cust['language'] === 'Santali') ? 'selected' : ''; ?>>Santali (संथाली)</option>
                                        </optgroup>
                                        <optgroup label="── North & West Indian Languages ──">
                                            <option value="Punjabi" <?php echo ($cust['language'] === 'Punjabi') ? 'selected' : ''; ?>>Punjabi (ਪੰਜਾਬੀ)</option>
                                            <option value="Bhojpuri" <?php echo ($cust['language'] === 'Bhojpuri') ? 'selected' : ''; ?>>Bhojpuri (भोजपुरी)</option>
                                            <option value="Maithili" <?php echo ($cust['language'] === 'Maithili') ? 'selected' : ''; ?>>Maithili (मैथिली)</option>
                                            <option value="Urdu" <?php echo ($cust['language'] === 'Urdu') ? 'selected' : ''; ?>>Urdu (اردو)</option>
                                            <option value="Sindhi" <?php echo ($cust['language'] === 'Sindhi') ? 'selected' : ''; ?>>Sindhi (सिंधी / سنڌي)</option>
                                            <option value="Konkani" <?php echo ($cust['language'] === 'Konkani') ? 'selected' : ''; ?>>Konkani (कोंकणी)</option>
                                            <option value="Dogri" <?php echo ($cust['language'] === 'Dogri') ? 'selected' : ''; ?>>Dogri (डोगरी)</option>
                                            <option value="Kashmiri" <?php echo ($cust['language'] === 'Kashmiri') ? 'selected' : ''; ?>>Kashmiri (कश्मीरी / کٲشُر)</option>
                                            <option value="Nepali" <?php echo ($cust['language'] === 'Nepali') ? 'selected' : ''; ?>>Nepali (नेपाली)</option>
                                            <option value="Sanskrit" <?php echo ($cust['language'] === 'Sanskrit') ? 'selected' : ''; ?>>Sanskrit (संस्कृतम्)</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="dt-form-grid-1" style="margin-top:14px;">
                                <!-- Email Address & Verification / Missing Handling -->
                                <div class="dt-form-group">
                                    <label class="dt-form-label">
                                        <span>Customer Email Address</span>
                                        <?php if (!empty($cust['email'])): ?>
                                            <span style="color:#15803D; font-size:0.65rem; font-weight:800;">✓ Verified</span>
                                        <?php else: ?>
                                            <span style="color:#B45309; font-size:0.65rem; font-weight:800;">⚠️ Missing / Unlinked</span>
                                        <?php endif; ?>
                                    </label>
                                    <div class="dt-input-icon-wrap">
                                        <svg class="dt-input-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <input type="email" id="dtCustEmailField" class="dt-input-field" placeholder="e.g. customer@gmail.com" value="<?php echo htmlspecialchars($cust['email']); ?>">
                                    </div>

                                    <!-- Email Action / Missing State Box -->
                                    <?php if (!empty($cust['email'])): ?>
                                        <div class="dt-email-status-box verified">
                                            <span>✓ Invoices and tracking links are dispatched to this email.</span>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:2px 8px; font-size:0.68rem;" onclick="window.showToast('✓ Verification link sent to <?php echo htmlspecialchars($cust['email']); ?>!')">Resend Verification</button>
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

                        <!-- ══ SECTION 2: SHIPPING & BILLING ADDRESS ══ -->
                        <div class="dt-edit-section">
                            <h3 class="dt-edit-section-title">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Default Shipping &amp; Courier Address</span>
                            </h3>

                            <div class="dt-form-grid-2">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">Country / Destination (195+ World Markets) <span style="color:#DC2626;">*</span></label>
                                    <div class="dt-country-picker-wrap" id="dtEditCountryPicker" data-selected-code="IN">
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
                                    <input type="text" class="dt-input-field no-icon" value="<?php echo htmlspecialchars($cust['landmark']); ?>" placeholder="e.g. Opposite Metro Station, Near City Mall">
                                </div>
                            </div>

                            <div class="dt-form-group" style="margin-top:14px;">
                                <label class="dt-form-label">Street Address / House No.</label>
                                <input type="text" class="dt-input-field no-icon" value="<?php echo htmlspecialchars($cust['address']); ?>" placeholder="House/Flat No., Building Name, Street">
                            </div>

                            <div class="dt-form-grid-3" style="margin-top:14px;">
                                <div class="dt-form-group">
                                    <label class="dt-form-label">City</label>
                                    <input type="text" class="dt-input-field no-icon" value="<?php echo htmlspecialchars($cust['city']); ?>" placeholder="e.g. Delhi">
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">State / Province</label>
                                    <select class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="DL" <?php echo $cust['state'] === 'DL' ? 'selected' : ''; ?>>Delhi NCR</option>
                                        <option value="GJ" <?php echo $cust['state'] === 'GJ' ? 'selected' : ''; ?>>Gujarat</option>
                                        <option value="MH" <?php echo $cust['state'] === 'MH' ? 'selected' : ''; ?>>Maharashtra</option>
                                        <option value="WB" <?php echo $cust['state'] === 'WB' ? 'selected' : ''; ?>>West Bengal</option>
                                        <option value="RJ" <?php echo $cust['state'] === 'RJ' ? 'selected' : ''; ?>>Rajasthan</option>
                                        <option value="KA" <?php echo $cust['state'] === 'KA' ? 'selected' : ''; ?>>Karnataka</option>
                                        <option value="TS" <?php echo $cust['state'] === 'TS' ? 'selected' : ''; ?>>Telangana</option>
                                        <option value="UP" <?php echo $cust['state'] === 'UP' ? 'selected' : ''; ?>>Uttar Pradesh</option>
                                        <option value="OTHER">Other / International State</option>
                                    </select>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Postal Code / PIN Code</label>
                                    <input type="text" class="dt-input-field no-icon" value="<?php echo htmlspecialchars($cust['pincode']); ?>" placeholder="6-digit Pincode / Zip">
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
                                    <select class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="active" <?php echo $cust['status'] === 'active' ? 'selected' : ''; ?>>Active Verified (Full Ordering Access)</option>
                                        <option value="inactive" <?php echo $cust['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive / Dormant Account</option>
                                        <option value="suspended" <?php echo $cust['status'] === 'suspended' ? 'selected' : ''; ?>>Suspended (COD Protection &amp; Blocked)</option>
                                    </select>
                                </div>

                                <div class="dt-form-group">
                                    <label class="dt-form-label">Customer Tier Category</label>
                                    <select class="dt-cust-select" style="width:100%; height:38px;">
                                        <option value="vip" <?php echo $cust['tier'] === 'vip' ? 'selected' : ''; ?>>VIP High-Value Spender (> ₹25k LTV)</option>
                                        <option value="regular" <?php echo $cust['tier'] === 'regular' ? 'selected' : ''; ?>>Regular Direct Retail Shopper</option>
                                        <option value="new" <?php echo $cust['tier'] === 'new' ? 'selected' : ''; ?>>New Account Registration</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Assigned Tags -->
                            <div class="dt-form-group" style="margin-top:14px;">
                                <label class="dt-form-label">Assigned Customer Tags</label>
                                <div class="dt-cust-tags-wrap" id="dtEditTagsContainer" style="gap:8px; margin-bottom:8px;">
                                    <?php foreach ($cust['tags'] as $tag): ?>
                                        <span class="dt-cust-tag-chip gold">
                                            <span><?php echo htmlspecialchars($tag); ?></span>
                                            <button type="button" class="dt-cust-tag-remove" onclick="this.parentElement.remove(); window.showToast('Tag removed');">✕</button>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                                <div style="display:flex; gap:8px;">
                                    <input type="text" id="dtNewTagInput" class="dt-input-field no-icon" style="max-width:280px;" placeholder="Add custom tag (e.g. Saree Lover)...">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="
                                        const val = document.getElementById('dtNewTagInput').value.trim();
                                        if(val) {
                                            const chip = document.createElement('span');
                                            chip.className = 'dt-cust-tag-chip gold';
                                            chip.innerHTML = `<span>${val}</span><button type='button' class='dt-cust-tag-remove' onclick='this.parentElement.remove()'>✕</button>`;
                                            document.getElementById('dtEditTagsContainer').appendChild(chip);
                                            document.getElementById('dtNewTagInput').value = '';
                                            window.showToast('✓ Tag added!');
                                        }
                                    ">+ Add Tag</button>
                                </div>
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
                                    <span style="font-size:0.72rem; color:#78716C;">Passwords are encrypted. Dispatches a secure 1-time reset link via SMS &amp; Email.</span>
                                </div>
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('✓ Secure Password Reset Link dispatched to <?php echo htmlspecialchars($cust['phone']); ?>!')">Dispatch Reset Link</button>
                            </div>

                            <div class="dt-form-group">
                                <label class="dt-form-label">Internal Staff Confidential Memo (Admin Only)</label>
                                <textarea class="dt-input-field no-icon" style="height:70px; resize:none; padding-top:8px;" placeholder="Add internal customer remarks, preferred courier, packaging notes..."><?php echo htmlspecialchars($cust['notes']); ?></textarea>
                            </div>
                        </div>

                        <!-- ══ FORM ACTIONS FOOTER ══ -->
                        <div style="display:flex; align-items:center; justify-content:space-between; padding:18px 22px; background:#FAF8F4; border-top:1.5px solid #F1ECE1;">
                            <button type="button" class="dt-btn dt-btn-danger" onclick="if(confirm('Are you sure you want to deactivate customer account #<?php echo $customer_id; ?>?')) { window.showToast('Account deactivated.'); }">Deactivate Account</button>
                            
                            <div style="display:flex; align-items:center; gap:10px;">
                                <a href="/Frontend/Admin/customers/view.php?id=<?php echo $customer_id; ?>" class="dt-btn dt-btn-pale">Cancel</a>
                                <button type="submit" class="dt-btn dt-btn-gold">Save Customer Profile</button>
                            </div>
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
