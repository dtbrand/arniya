# Workspace Instructions & User Preferences

## 👑 DT BRAND'S & JAI HANUMAN TEX — MASTER UI DESIGN SYSTEM & WORKSPACE RULES

> **MANDATORY INSTRUCTION FOR ALL AI AGENTS & DEVELOPERS:**
> This document defines the **Master Design Language, UI Components, Color System, 100% Real Vector SVG Icon Standard, Animated SVG System, Styled Buttons Mandate, Complete Working Logic, Mobile & Tablet Fluid Auto-Sizing Standard, Multi-Gateway Payment Security & Inventory Audit Engine, and Triple-Sync Quality Control Standards** for DT Brand's & Jai Hanuman Tex across all platforms.
> **EVERY AI AGENT MUST STRICTLY FOLLOW THESE RULES ON EVERY CHANGE WITHOUT REVERTING TO GENERIC STYLES.**

---

## 👑 The 8 Master Pillars of DT Brand's Design & Code

1. **🧠 HINDI / TYPO TOLERANCE & PRO ENGLISH**: Understand Hindi/Hinglish queries & typos seamlessly, auto-translate to clear intent, and write 100% professional English in all UI, code, comments, labels, and git commits.
2. **🔤 CLEAN & SHARP TYPOGRAPHY (TAILADMIN BENCHMARK)**: Always use `'Inter'` & `'Plus Jakarta Sans'` with antialiased font smoothing (`-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; letter-spacing: -0.011em;`), and deep contrast `#111827` / `#1F2937` / `#64748B` for crystal-clear legibility across all pages.
3. **🎨 100% STYLED BUTTONS MANDATE**: Never leave any plain, unstyled browser button. Every button must use DT Brand's primary gold gradient (`#8A681F` to `#D4AF37`), dark obsidian hero, emerald WhatsApp, or pale gold pill styling.
4. **⚡ 100% REAL VECTOR SVG ICONS & RUPEE MANDATE**: Zero emojis in core buttons, navigation, or table headers. All icons must be crisp inline SVG vectors (`stroke-width: 2 - 2.8`). **NEVER USE DOLLAR ICONS ($)** — ALWAYS use the 100% Real Indian Rupee (`₹`) Vector SVG across all pricing, valuation, and revenue metrics.
5. **📱 FLUID MOBILE & TABLET AUTO-SIZING**: Wholesale Desktop + Tablet + Mobile responsive layout with auto-fit grids, touch targets, and zero broken/clipped layouts across any device.
6. **🛡️ MULTI-GATEWAY PAYMENT SECURITY & REAL AUDIT**: Instant Direct UPI Deep Linking + Dynamic Laser QR, Razorpay HMAC, Cashfree, COD, WhatsApp Pay, automated inventory stock decrement upon capture, and complete transaction logging in `payment_transactions`.
7. **🚫 ON-DEMAND LIVE PREVIEW ONLY**: NEVER launch browser preview or subagent automatically on routine edits. ONLY open browser when the user EXPLICITLY requests it.
8. **🚀 TRIPLE-SYNC DEPLOYMENT**: Local (Clean) ➔ GitHub ➔ Hostinger Live FTP.

---

## ⚡ 1. 100% Real Vector SVG Icon Standard (MANDATORY)

Every icon across all pages, buttons, headers, navigation bars, modals, tables, and metric cards **MUST ALWAYS** be a clean inline vector SVG:

### 💰 A. Real Indian Rupee (`₹`) Vector SVG (NEVER USE `$`)
```html
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path>
</svg>
```

### ⚡ B. Instant UPI Lightning Bolt Vector SVG
```html
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
</svg>
```

### 💳 C. Cards & Online Payment Gateway Vector SVG
```html
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
    <line x1="1" y1="10" x2="23" y2="10"></line>
</svg>
```

### 🚚 D. Cash on Delivery (COD) Doorstep Vector SVG
```html
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="1" y="3" width="15" height="13"></rect>
    <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
    <circle cx="5.5" cy="18.5" r="2.5"></circle>
    <circle cx="18.5" cy="18.5" r="2.5"></circle>
</svg>
```

### 💬 E. Official WhatsApp Business Concierge Vector SVG
```html
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
</svg>
```

---

## ✨ 2. Animated Real SVG Micro-Interactions & Running Focus Lines

### 🌟 A. Gold & Platinum 360° Running Focus Line
```css
@property --dt-border-angle {
    syntax: "<angle>";
    inherits: false;
    initial-value: 0deg;
}

@keyframes dtBorderRotate {
    to { --dt-border-angle: 360deg; }
}

@keyframes dtGoldPlatinumGlow {
    0% { box-shadow: 0 0 8px rgba(212, 175, 55, 0.45), 0 0 16px rgba(226, 232, 240, 0.35); }
    100% { box-shadow: 0 0 16px rgba(212, 175, 55, 0.75), 0 0 28px rgba(255, 255, 255, 0.6); }
}

input:focus, select:focus, textarea:focus, .dt-input-field:focus, .co-input:focus, .adm-form-input:focus {
    outline: none !important;
    border: 2px solid transparent !important;
    background: linear-gradient(#FFFFFF, #FFFFFF) padding-box,
                conic-gradient(from var(--dt-border-angle), #D4AF37 0deg, #FFFFFF 60deg, #E2E8F0 120deg, #D4AF37 180deg, #FFFFFF 240deg, #B8860B 300deg, #D4AF37 360deg) border-box !important;
    animation: dtBorderRotate 2s linear infinite, dtGoldPlatinumGlow 1.5s ease-in-out infinite alternate !important;
    color: #111827 !important;
}
```

### 🔴 B. Dynamic QR Laser Scanner Ray Animation
```css
@keyframes dtQrScanLaser {
    0% { top: 6px; opacity: 0.8; }
    50% { top: calc(100% - 10px); opacity: 1; }
    100% { top: 6px; opacity: 0.8; }
}

.co-upi-qr-laser {
    position: absolute;
    left: 8px;
    right: 8px;
    height: 2.5px;
    background: linear-gradient(90deg, transparent 0%, #DC2626 50%, transparent 100%);
    box-shadow: 0 0 10px #DC2626, 0 0 20px #DC2626;
    animation: dtQrScanLaser 2.2s ease-in-out infinite;
    pointer-events: none;
}
```

---

## 🔄 3. Triple-Sync Deployment Workflow (Local + Git + FTP)

- **ALWAYS** perform a complete 3-step synchronization for every code change or fix:
  1. **Local**: Edit and validate all files cleanly in the local workspace (`c:\Users\sai\Desktop\WhatsApp CRM`).
  2. **GitHub**: Auto-commit with clear descriptive messages and auto-push to GitHub `origin main`.
  3. **Live FTP Server**: Auto-upload and deploy all modified files via Python `ftplib` directly to Hostinger live server.

### 🌐 Live Server & FTP Details

- **FTP Host / IP**: `147.93.99.134` (Port `21`)
- **FTP Username**: `u602484543.jaihanumantex.in`
- **FTP Password**: `Gautam@9006`
- **Remote Folder**: `/public_html`
- **Live URL**: `https://jaihanumantex.in/`

### 🗄️ Hostinger Live MySQL Database Credentials

- **Database Name**: `u602484543_demodt121`
- **Database User**: `u602484543_demodt121`
- **Database Password**: `Gautam@9006`
- **Database Host**: `localhost` (Port `3306`)
- **Website Base URL**: `https://jaihanumantex.in/`

### 📱 Official DT Brand WhatsApp Master Contact
- **Official WhatsApp Number**: `917046363528` (Formatting: `+91 70463 63528`)
- **Direct WhatsApp API Link**: `https://api.whatsapp.com/send?phone=917046363528&text=...` / `https://wa.me/917046363528`
- **Official UPI VPA**: `917046363528@okaxis` / `dtbrands@icici` (MCC: `5691`)

### 🐙 GitHub Repository Details

- **Repository URL**: `https://github.com/dtbrand/arniya.git`
- **Branch**: `main`

---

## 🎨 Signature Brand Color System & Hierarchy

- **Primary Signature Gold**: `#8A681F` (Master Heritage Gold for Buttons, Accents, Key Text)
- **Radiant Accent Gold**: `#D4AF37` / `#C5A859` (Glows, Borders, Stars, Active Highlights)
- **Deep Bronze Gold**: `#5A4210` / `#705114` (Headings on Cream, Subtle Borders)
- **Pale Gold Tint**: `#FAF5E8` (Card Highlights, Active Pills, Badges)
- **Dark Velvet Obsidian**: `#181512` / `#2A241E` / `#3D342A` (Card Headers, Primary Dark Buttons)
- **Emerald Success**: `#15803D` & `#DCFCE7` (In Stock, WhatsApp Buttons, Approved Badges)
- **Amber Warning**: `#B45309` & `#FEF3C7` (Low Stock, Pending Badges)
- **Crimson Danger**: `#DC2626` & `#FEF2F2` (Out of Stock, Trash Actions)
- **Soft Blue Info**: `#1D4ED8` & `#EFF6FF` (Reply Action Pills, Dispatch Info)

