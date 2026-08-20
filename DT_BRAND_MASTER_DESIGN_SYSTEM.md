# 👑 DT BRAND'S & JAI HANUMAN TEX — MASTER UI DESIGN SYSTEM & WORKSPACE INSTRUCTIONS

> **MANDATORY INSTRUCTION FOR ALL AI AGENTS & DEVELOPERS:**
> This document defines the **Master Design Language, UI Components, Color System, 100% Vector SVG Standard, Styled Buttons Mandate, Complete Working Logic, Bilingual Comprehension & Professional English Standard, Screenshot-Driven Execution, and Architectural Standards** for DT Brand's & Jai Hanuman Tex across all platforms (Admin Suite, Wholesale Dashboard, Shop, Single Product, Checkout, and Customer Portals).
> **EVERY AI AGENT MUST STRICTLY FOLLOW THESE RULES ON EVERY CHANGE, FEATURE ADDITION, OR UI REFACTOR WITHOUT ASKING OR REVERTING TO GENERIC STYLES.**

---

## 👑 The 6 Master Pillars of DT Brand's Design & Code

1. **🧠 HINDI / TYPO TOLERANCE & PRO ENGLISH**: Understand Hindi/Hinglish queries & typos seamlessly, auto-translate to clear intent, and write 100% professional English in all UI, code, comments, labels, and git commits.
2. **🎨 100% STYLED BUTTONS MANDATE**: Never leave any plain, unstyled browser button. Every button must use DT Brand's primary gold gradient (`#8A681F` to `#D4AF37`), emerald success, soft blue, or pale gold pill styling.
3. **⚡ 100% REAL VECTOR SVG ICONS**: Zero emojis in core buttons, navigation, or table headers. All icons must be crisp inline SVG vectors (`stroke-width: 2 - 2.8`).
4. **🎯 100% FULLY WORKING GUARANTEE**: Zero dead buttons or broken actions. Every button, modal, drawer, search input, and filter must have attached working JS and backend logic.
5. **🔍 SCREENSHOT-DRIVEN DEEP AUDIT**: Auto-detect flaws, missing sub-options, clipped dropdowns, and unstyled UI, then build missing parts end-to-end.
6. **🚀 TRIPLE-SYNC DEPLOYMENT**: Local (Clean) ➔ GitHub ➔ Hostinger Live FTP.

---

## 🎨 1. Signature Brand Color Palette & Tokens

```css
:root {
    /* ── SIGNATURE GOLD PALETTE ── */
    --dt-gold-primary: #8A681F;          /* Master Heritage Gold (Buttons, Accents, Key Text) */
    --dt-gold-radiant: #D4AF37;          /* Radiant Accent Gold (Glows, Borders, Stars, Highlights) */
    --dt-gold-light: #C5A859;            /* Secondary Warm Gold */
    --dt-gold-dark: #5A4210;             /* Deep Bronze Gold (Headings on Cream, Subtle Borders) */
    --dt-gold-pale: #FAF5E8;             /* Pale Gold Tint (Card Highlights, Active Pills, Badges) */
    --dt-gold-cream: #FDFBF7;            /* Ultra-Soft Cream Background */
    
    /* ── VELVET OBSIDIAN / DARK PALETTE ── */
    --dt-dark-obsidian: #181512;         /* Signature Dark Velvet (Main Headings, Primary Dark Buttons) */
    --dt-dark-charcoal: #2A241E;         /* Card Headers, Secondary Dark */
    --dt-dark-card: #3D342A;             /* Gradient Midpoint for Dark Headers */
    --dt-dark-slate: #0F172A;            /* Backdrop Overlays & Deep Shadows */
    
    /* ── FUNCTIONAL STATUS COLORS ── */
    --dt-success-bg: #DCFCE7;            /* Emerald Pill Background (In Stock, Approved, WhatsApp) */
    --dt-success-text: #15803D;          /* Emerald Pill Text & Border */
    --dt-success-pulse: #16A34A;         /* Live Pulse Dot */
    
    --dt-warning-bg: #FEF3C7;            /* Amber Pill Background (Low Stock, Pending, Draft) */
    --dt-warning-text: #B45309;          /* Amber Pill Text */
    --dt-warning-pulse: #D97706;         /* Warning Pulse Dot */
    
    --dt-danger-bg: #FEF2F2;             /* Crimson Pill Background (Out of Stock, Trash) */
    --dt-danger-text: #DC2626;           /* Crimson Text */
    
    --dt-info-bg: #EFF6FF;               /* Soft Blue Pill Background (Reply, Dispatch) */
    --dt-info-text: #1D4ED8;             /* Blue Text */

    /* ── MASTER BUTTON GRADIENTS ── */
    --dt-gradient-gold: linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%);
    --dt-gradient-dark: linear-gradient(135deg, #181512 0%, #2A241E 50%, #3D342A 100%);
    --dt-gradient-soft: linear-gradient(135deg, #FAF5E8 0%, #FDFBF7 100%);
}
```

---

## 🔘 2. Master Button & Pill Hierarchy

| Button Type | Background / Gradient | Border | Text Color | SVG Icon Stroke |
| :--- | :--- | :--- | :--- | :--- |
| **👑 Primary Gold** | `linear-gradient(135deg, #8A681F, #B8860B, #D4AF37)` | `1px solid #8A681F` | `#181512` (Bold 800) | `#181512` (2.8) |
| **💬 WhatsApp B2B** | `linear-gradient(135deg, #15803D, #16A34A)` | `1px solid #15803D` | `#ffffff` (Bold 700) | `#ffffff` (2.2) |
| **⚪ Secondary Pill** | `#FAF5E8` | `1px solid #D4AF37` | `#8A681F` (Bold 700) | `#8A681F` (2.2) |
| **👁️ Info Pill** | `#EFF6FF` | `1px solid #93C5FD` | `#1D4ED8` (Bold 700) | `#1D4ED8` (2.2) |
| **🗑️ Danger Pill** | `#FEF2F2` | `1px solid #FECACA` | `#DC2626` (Weight 600) | `#DC2626` (2.0) |

---

## ⚡ 3. 100% Vector SVG Icon Standard (Zero Emojis in Buttons)

All buttons and interactive pills MUST use clean inline vector SVGs:

- **Edit**: `<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>`
- **View**: `<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`
- **Delete**: `<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>`
- **Save / Check**: `<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>`
- **Upload / Media**: `<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>`
- **Search (Left-Aligned)**: `<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>`

---

## 🔍 4. Search Bar Master Placement & Interaction Rule

- **Icon Position**: Magnifying glass SVG strictly on the **LEFT side** of every search input field across all pages.
- **Padding**: Strictly enforce `padding-left: 36px` to `42px` so placeholder and typed text NEVER overlap the left icon.
- **1-Tap Clear Button (`✕`)**: Include a clickable clear SVG button on the **RIGHT side** (`position: absolute; right: 8px;`) that appears dynamically when text is entered and clears the search in 1 click.
- **Search Button**: Primary Gold Gradient button next to input for instant submission.

---

## 🔲 5. Wholesaler Dashboard & Shop Product Card Architecture

Every Product Card must deliver high-density B2B wholesale intelligence:

1. **Aspect Ratio & Hover**: `1:1` or `4:3` containment images with `object-fit: cover`, rounded `8px`, with hover elevation (`transform: translateY(-2px); box-shadow: 0 6px 18px rgba(212,175,55,0.18)`).
2. **Badges**:
   - Top-Left: `✨ Best Seller` (`#8A681F`), `🔥 New Arrival` (`#D4AF37`), `👑 Luxury Bridal` (`#B91C1C`), `⚡ Super Value` (`#0F766E`).
   - Top-Right: `MOQ: 6 Pcs` / `MOQ: 8 Pcs` (`background: rgba(255,255,255,0.92); color: #15803D; font-weight: 800;`).
3. **Wholesale Pricing Box**:
   - Pale Gold background (`#FAF5E8`) with gold border `rgba(212,175,55,0.4)`.
   - **Wholesale Rate ₹**: Bold large font (e.g. `₹2,850 / pc`).
   - **Retail MRP ₹**: Strikethrough gray (e.g. `₹4,490`).
   - **⚡ Resale Margin**: Live green calculation (e.g. `⚡ 36% Resale Margin (+₹1,640/pc)`).
4. **1-Click Action Buttons**:
   - `[✏️ Edit]` / `[👁️ View]`
   - `[💬 WhatsApp Order]` (Emerald Green with WhatsApp vector SVG)

---

## 📊 6. Wholesale KPI Summary Metrics Ribbon

Every main module (Products, Categories, Brands, Reviews, Featured, Best Sellers, New Arrivals) must open with a **4-Card KPI Ribbon**:

- **Card 1 (Gold Accent)**: Primary Count / Designs (`📦 ACTIVE B2B DESIGNS: 1,240 SKUs`).
- **Card 2 (Emerald Accent)**: Valuation / Approval Rate (`💰 B2B CATALOG VALUATION: ₹48.60 Lakhs` or `APPROVED: 1,380`).
- **Card 3 (Blue Accent)**: Surat Central Depot Inventory (`🏭 SURAT CENTRAL DEPOT: 8,450 Units Ready`).
- **Card 4 (Amber Accent)**: Reorders / Pending Action (`⚠️ LOW STOCK REORDERS: 14 Lots`).

---

## 📸 7. Screenshot-Driven Autonomous Execution Protocol

Whenever the user provides ANY screenshot:

1. **Deep Visual & Component Inspection**:
   - Analyze every visible UI element: Header, Breadcrumbs, Input fields, Select dropdowns, Checkboxes, Buttons, Tabs, Icons, Spacing, Padding, and Alignment.
   - Detect visual flaws: Clipped labels, unstyled buttons, emojis in buttons, misaligned search bars, poor color contrast, awkward line breaks, or lack of DT Brand luxury gold aesthetics.

2. **Completeness & Missing Features Audit ("Adhura Na Rahe")**:
   - Identify missing options or features that belong to the screen (e.g. Search inputs with 1-tap clear, Bulk Actions, Quick Edit drawers, KPI metrics ribbon, SEO fields, Media upload previews, WhatsApp enquiry buttons, Resale profit margin % indicators).
   - If ANY option is missing or incomplete, the agent MUST autonomously build and integrate it with 100% working functionality.

3. **End-to-End Functional Verification ("Last Tak Working Ho")**:
   - Ensure every button, modal popup, filter dropdown, search input, clear button, and status toggle has functional, working JavaScript and backend logic.
   - Zero non-functional or dead buttons allowed.

4. **Design System & Auto-Sizing Enforcement**:
   - Apply DT Brand's signature colors (`#8A681F`, `#D4AF37`, `#181512`, `#FAF5E8`, `#15803D`).
   - Use 100% real vector SVG icons (`stroke-width: 2 - 2.8`).
   - Enforce fluid auto-sizing, unclipped dropdowns (`min-width: 160px - 180px`), and mobile responsive single-column layouts (`@media (max-width: 768px)`).

5. **Validation, Git Push & Live Hostinger FTP Deployment**:
   - Lint PHP files (`php -l`), commit & push to GitHub `origin main`, and upload directly via FTP to live production.

---

## 🔄 8. Triple-Sync Deployment Workflow (Local + Git + FTP)

- **ALWAYS** perform a complete 3-step synchronization for every code change:
  1. **Local**: Edit and validate all files cleanly in `c:\Users\sai\Desktop\WhatsApp CRM`.
  2. **GitHub**: Auto-commit with clear descriptive messages and auto-push to GitHub `origin main`.
  3. **Live FTP Server**: Auto-upload and deploy all modified files via Python `ftplib` directly to Hostinger live server.

### 🌐 Live Server & FTP Details

- **FTP Host / IP**: `147.93.99.134` (Port `21`)
- **FTP Username**: `u602484543.jaihanumantex.in`
- **FTP Password**: `Gautam@9006`
- **Remote Folder**: `/public_html`
- **Live URL**: `https://jaihanumantex.in/`
