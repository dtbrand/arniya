# Workspace Instructions & User Preferences

## 👑 DT BRAND'S & JAI HANUMAN TEX — MASTER UI DESIGN SYSTEM & WORKSPACE RULES

> **MANDATORY INSTRUCTION FOR ALL AI AGENTS & DEVELOPERS:**
> This document defines the **Master Design Language, UI Components, Color System, 100% Vector SVG Standard, Styled Buttons Mandate, Complete Working Logic, Mobile & Tablet Fluid Auto-Sizing Standard, Bilingual Comprehension & Professional English Standard, Screenshot-Driven Execution, and Architectural Standards** for DT Brand's & Jai Hanuman Tex across all platforms (Admin Suite, Wholesale Dashboard, Shop, Single Product, Checkout, and Customer Portals).
> **EVERY AI AGENT MUST STRICTLY FOLLOW THESE RULES ON EVERY CHANGE, FEATURE ADDITION, OR UI REFACTOR WITHOUT ASKING OR REVERTING TO GENERIC STYLES.**

---

## 👑 The 8 Master Pillars of DT Brand's Design & Code

1. **🧠 HINDI / TYPO TOLERANCE & PRO ENGLISH**: Understand Hindi/Hinglish queries & typos seamlessly, auto-translate to clear intent, and write 100% professional English in all UI, code, comments, labels, and git commits.
2. **🔤 CLEAN & SHARP TYPOGRAPHY (TAILADMIN BENCHMARK)**: Always use `'Inter'` & `'Plus Jakarta Sans'` with antialiased font smoothing (`-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; letter-spacing: -0.011em;`), and deep contrast `#111827` / `#1F2937` / `#64748B` for crystal-clear legibility across all pages.
3. **🎨 100% STYLED BUTTONS MANDATE**: Never leave any plain, unstyled browser button. Every button must use DT Brand's primary gold gradient (`#8A681F` to `#D4AF37`), emerald success, soft blue, or pale gold pill styling.
4. **⚡ 100% REAL VECTOR SVG ICONS & RUPEE MANDATE**: Zero emojis in core buttons, navigation, or table headers. All icons must be crisp inline SVG vectors (`stroke-width: 2 - 2.8`). **NEVER USE DOLLAR ICONS ($)** — ALWAYS use the 100% Real Indian Rupee (`₹`) Vector SVG (`<path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path>`) across all pricing, valuation, and revenue metrics.
5. **📱 FLUID MOBILE & TABLET AUTO-SIZING**: Wholesale Desktop + Tablet + Mobile responsive layout with auto-fit grids, touch targets, and zero broken/clipped layouts across any device.
6. **🎯 100% FULLY WORKING GUARANTEE**: Zero dead buttons or broken actions. Every button, modal, drawer, search input, and filter must have attached working JS and backend logic.
7. **🚫 ON-DEMAND LIVE PREVIEW ONLY**: NEVER launch browser preview or subagent automatically on routine edits. ONLY open browser when the user EXPLICITLY requests it ("browser open karo", "screenshot dikhao", "live preview check karo").
8. **🚀 TRIPLE-SYNC DEPLOYMENT**: Local (Clean) ➔ GitHub ➔ Hostinger Live FTP.

---

## ✨ Gold & Platinum Animated Running Focus Line Standard

Every input field (`input`, `textarea`, `select`, `.dt-input-field`, `.adm-form-input`, `.dt-cust-select`, `.dt-country-search-input`) across the Admin Panel **MUST ALWAYS** use the **Gold & Platinum Mix Animated Running Border Line** when focused:

```css
@property --dt-border-angle {
    syntax: "<angle>";
    inherits: false;
    initial-value: 0deg;
}

@keyframes dtGoldPlatinumRun {
    to {
        --dt-border-angle: 360deg;
    }
}

input:focus, select:focus, textarea:focus, .dt-input-field:focus, .dt-country-search-input:focus {
    outline: none !important;
    border: 2px solid transparent !important;
    background: linear-gradient(#FFFFFF, #FFFFFF) padding-box,
                conic-gradient(from var(--dt-border-angle), #D4AF37 0deg, #FFFFFF 60deg, #E2E8F0 120deg, #D4AF37 180deg, #FFFFFF 240deg, #B8860B 300deg, #D4AF37 360deg) border-box !important;
    animation: dtGoldPlatinumRun 2s linear infinite !important;
    box-shadow: 0 0 12px rgba(212, 175, 55, 0.45) !important;
    color: #111827 !important;
}
```

---

## 💎 Master Luxury Gold & Silver/Platinum Glass Hero Box Standard

All dark summary boxes, customer identity hero bars, and overview metric strips across the Admin Panel **MUST ALWAYS** use the **Luxury Gold & Silver/Platinum Ambient Lining Glassmorphic Style**:

```css
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

.dt-hero-luxury-card, .adm-hero-dark-box, .dt-cust-hero-banner {
    position: relative;
    background:
        radial-gradient(ellipse at 15% 40%, rgba(212, 175, 55, 0.45) 0%, transparent 65%),
        radial-gradient(ellipse at 85% 60%, rgba(245, 208, 92, 0.35) 0%, transparent 60%),
        radial-gradient(ellipse at 50% 10%, rgba(255, 255, 255, 0.12) 0%, transparent 50%),
        linear-gradient(135deg, rgba(38, 28, 14, 0.96) 0%, rgba(58, 44, 18, 0.92) 40%, rgba(42, 32, 16, 0.94) 75%, rgba(24, 18, 10, 0.98) 100%);
    background-size: 200% 200%, 200% 200%, 200% 200%, 100% 100%;
    animation: dtAdminAmbientGlow 8s ease-in-out infinite alternate;
    -webkit-backdrop-filter: blur(20px);
    backdrop-filter: blur(20px);
    border: 2px solid #D4AF37;
    border-radius: 12px;
    box-shadow: 0 10px 36px rgba(0, 0, 0, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.45), inset 0 0 20px rgba(212, 175, 55, 0.3), 0 0 24px rgba(212, 175, 55, 0.35);
}
```

---

## 📱 Mobile & Tablet Responsive Architecture Rules

- **KPI Metrics Ribbon**: Must use `grid-template-columns: repeat(auto-fit, minmax(220px, 1fr))` on desktop, 2-column on tablet (`max-width: 1024px`), and 1-column on phone (`max-width: 600px`).
- **Toolbars**: Must wrap on mobile and tablet (`flex-wrap: wrap; width: 100%;`) with full-width search input (`flex: 1; width: 100%;`).
- **Tables**: Must be enclosed in an overflow container (`overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;`) with `min-width: 780px` table width to prevent column cramping.
- **Modals**: Must be fluidly centered (`width: 95%; max-width: 520px; max-height: 90vh; overflow-y: auto;`).

---

## 🔄 Triple-Sync Deployment Workflow (Local + Git + FTP)

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
- **Rule**: ALWAYS use `917046363528` across all product pages, reels, quickviews, checkout, wholesale/reseller/retailer concierge, and customer support. NEVER use dummy/placeholder phone numbers.

### 🐙 GitHub Repository Details

- **Repository URL**: `https://github.com/dtbrand/arniya.git`
- **Branch**: `main`
- **Remote Config**: Authenticated with dtbrand Personal Access Token (PAT)

---

## 🎨 Signature Brand Color System & Hierarchy

- **Primary Signature Gold**: `#8A681F` (Master Heritage Gold for Buttons, Accents, Key Text)
- **Radiant Accent Gold**: `#D4AF37` / `#C5A859` (Glows, Borders, Stars, Active Highlights)
- **Deep Bronze Gold**: `#5A4210` / `#705114` (Headings on Cream, Subtle Borders)
- **Pale Gold Tint**: `#FAF5E8` (Card Highlights, Active Pills, Badges)
- **Ultra-Soft Cream**: `#FDFBF7` (Table Rows on hover, Backgrounds)
- **Dark Velvet Obsidian**: `#181512` / `#2A241E` / `#3D342A` (Card Headers, Primary Dark Buttons)
- **Emerald Success**: `#15803D` & `#DCFCE7` (In Stock, WhatsApp Buttons, Approved Badges)
- **Amber Warning**: `#B45309` & `#FEF3C7` (Low Stock, Pending Badges)
- **Crimson Danger**: `#DC2626` & `#FEF2F2` (Out of Stock, Trash Actions)
- **Soft Blue Info**: `#1D4ED8` & `#EFF6FF` (Reply Action Pills, Dispatch Info)

---

## 🎯 Strict Quality & Zero-Regression Standards

1. **Zero Undefined PHP Variables**: Always default component incoming variables safely (e.g. `$collection = (isset($collection) && is_array($collection)) ? $collection : [];`) to guarantee clean execution without warnings.
2. **Dynamic Edit Form Data Prefilling**: All `edit.php?id=X` pages must resolve `$_GET['id']` and populate title, slug, description, and settings matching the target record.
3. **HTML5 Native Direct Mouse Drag & Drop**: Category trees, banner reordering, and item ranking must support native mouse dragging (`draggable="true"`) alongside arrow stepper buttons.
4. **Clean Linter Standard**: Keep `cspell.json` updated with textile and framework terminology; maintain 0 syntax errors across PHP and JS files.
