# 👑 DT BRAND'S & JAI HANUMAN TEX — MASTER UI DESIGN SYSTEM & WORKSPACE INSTRUCTIONS

> **MANDATORY INSTRUCTION FOR ALL AI AGENTS & DEVELOPERS:**
> This document defines the **Master Design Language, UI Components, Color System, Screenshot-Driven Execution, and Architectural Standards** for DT Brand's & Jai Hanuman Tex across all platforms (Admin Suite, Wholesale Dashboard, Shop, Single Product, Checkout, and Customer Portals).
> **EVERY AI AGENT MUST STRICTLY FOLLOW THESE RULES ON EVERY CHANGE, FEATURE ADDITION, OR UI REFACTOR WITHOUT ASKING OR REVERTING TO GENERIC STYLES.**

---

## 🎨 1. Signature Brand Color Palette & Tokens

DT Brand's visual identity represents **Heritage Indian Luxury & Enterprise B2B Textile Craftsmanship**. Never use generic flat colors (e.g. plain red, default blue, neon green).

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

## 🔍 2. Search Bar Master Placement & Interaction Rule

- **Icon Position**: **ALWAYS** place the search magnifying glass icon on the **LEFT side** of every search input field across all pages (Wholesale, Shop, Admin Catalog, Categories, Reviews, Header, Modals).
- **Left Padding**: Strictly enforce `padding-left: 36px` to `42px` so placeholder and typed text NEVER overlap the left icon.
- **1-Tap Clear Button (`✕`)**: Include a clickable clear button on the **RIGHT side** (`position: absolute; right: 8px;`) that appears dynamically when text is entered and clears the search in 1 click.
- **Search Button**: Primary Gold Gradient button next to input for instant submission.

---

## 🔲 3. Wholesaler Dashboard & Shop Product Card Architecture

Every Product Card (in Wholesale Dashboard, Shop, or Admin Grid) must deliver high-density B2B wholesale intelligence:

1. **Containment Image & Badges**:
   - Aspect ratio `1:1` or `4:3`, `object-fit: cover`, rounded `8px` with hover elevation (`transform: translateY(-2px); box-shadow: 0 6px 18px rgba(212,175,55,0.18)`).
   - Top-Left Badge: `✨ Best Seller` (`#8A681F`), `🔥 New Arrival` (`#D4AF37`), `👑 Luxury Bridal` (`#B91C1C`), or `⚡ Super Value` (`#0F766E`).
   - Top-Right MOQ Badge: `MOQ: 6 Pcs` or `MOQ: 8 Pcs` (`background: rgba(255,255,255,0.92); color: #15803D; font-weight: 800;`).
2. **Pricing & Resale Margin Box**:
   - Pale Gold background (`#FAF5E8`) with gold border `rgba(212,175,55,0.4)`.
   - **Wholesale Rate ₹**: Bold large font (e.g. `₹2,850 / pc`).
   - **Retail MRP ₹**: Strikethrough gray (e.g. `₹4,490`).
   - **⚡ Resale Margin**: Live green calculation (e.g. `⚡ 36% Resale Margin (+₹1,640/pc)`).
3. **1-Click Action Buttons**:
   - `[✏️ Edit]` / `[👁️ View]`: Polished secondary button.
   - `[💬 WhatsApp Order]`: Emerald green pill with WhatsApp vector icon.

---

## 📊 4. Wholesale KPI Summary Metrics Ribbon

Every main module (Products, Categories, Reviews, Featured, Best Sellers, New Arrivals) must open with a **4-Card KPI Ribbon**:

- **Card 1 (Gold Accent)**: Primary Count / Designs (`📦 ACTIVE B2B DESIGNS: 1,240 SKUs`).
- **Card 2 (Emerald Accent)**: Valuation / Approval Rate (`💰 B2B CATALOG VALUATION: ₹48.60 Lakhs` or `APPROVED: 1,380`).
- **Card 3 (Blue Accent)**: Surat Central Depot Inventory (`🏭 SURAT CENTRAL DEPOT: 8,450 Units Ready`).
- **Card 4 (Amber Accent)**: Reorders / Pending Action (`⚠️ LOW STOCK REORDERS: 14 Lots`).

---

## 🔘 5. Interactive Buttons & Action Pills Hierarchy

| Button Type | Background / Gradient | Border | Text Color | Usage |
| :--- | :--- | :--- | :--- | :--- |
| **👑 Primary Gold** | `linear-gradient(135deg, #8A681F, #B8860B, #D4AF37)` | `1px solid #8A681F` | `#181512` (Bold 800) | `+ Add Product`, `+ Save`, `Apply`, `AI Generate` |
| **💬 WhatsApp B2B** | `#15803D` (or `#DCFCE7` for pill) | `#15803D` / `#86EFAC` | `#ffffff` / `#15803D` | 1-Click WhatsApp Lot Offers & Customer Connect |
| **💬 Reply Action** | `#EFF6FF` | `1px solid #93C5FD` | `#1D4ED8` (Bold 700) | Customer Reviews Reply Drawer |
| **✓ Approve Action** | `linear-gradient(135deg, #8A681F, #D4AF37)` | `1px solid #8A681F` | `#181512` (Bold 800) | Moderation & Review Approvals |
| **🗑️ Danger / Trash** | `#FEF2F2` | `1px solid #FECACA` | `#DC2626` (Weight 600) | Delete / Move to Trash |
| **⚪ Secondary Action**| `#ffffff` | `1px solid #c3c4c7` | `#50575e` (Weight 600) | `Import`, `Export`, `Cancel`, `Back` |

---

## 📸 6. Screenshot-Driven Autonomous Execution Protocol

Whenever the user provides ANY screenshot (e.g. *"ui improment"*, *"check this"*, *"make it like wholesale"*):

1. **Deep Visual & Component Inspection**:
   - Analyze every visible UI element: Header, Breadcrumbs, Input fields, Select dropdowns, Checkboxes, Buttons, Tabs, Icons, Spacing, Padding, and Alignment.
   - Detect visual flaws: Clipped labels (e.g. truncated select options), misaligned search bars, emoji placeholders, poor color contrast, awkward line breaks, or lack of DT Brand luxury gold aesthetics.

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

## 📋 7. Checkout & Form Fields Architecture

1. **Card Headers**: Signature Velvet Dark gradient (`linear-gradient(135deg, #181512 0%, #2A241E 50%, #3D342A 100%)`) with radiant gold trim (`#D4AF37`) and crisp vector SVGs.
2. **Dropdowns & Selects**:
   - **Never Clip Text**: Always specify adequate `min-width: 160px - 180px` and `height: 32px - 34px` so option labels like *"Filter by star rating"* or *"Filter by stock status"* are never truncated.
3. **Focus States**:
   - On `:focus`: `border-color: #8A681F; box-shadow: 0 0 0 1px #8A681F, 0 0 8px rgba(212,175,55,0.25);`.
4. **Labels & Validation**:
   - Labels: `font-size: 12px; font-weight: 700; color: #181512;`.
   - Mandatory asterisks: `color: #b32d2e; font-weight: 800;`.

---

## ⚡ 8. Vector SVG Icons & Animated Sparkle Standard

- **Zero Emojis in Core Buttons**: Use clean, crisp inline vector SVGs with `stroke-width: 2 - 2.8` and `stroke-linecap: round; stroke-linejoin: round;`.
- **AI Features**: Use multi-sparkle animated SVG icons (`@keyframes dtSparkleFloat`) with signature gold gradients (`#D4AF37` / `#FAF5E8`).

---

## 📱 9. Mobile Auto-Sizing & Responsive Layouts

- **Breakpoints**:
  - Desktop: `1024px+` (Multi-column grids, Dual column side-by-side builder).
  - Tablet: `768px - 1023px` (Adaptive 2-column grids).
  - Mobile: `< 768px` (Single-column stacked, full-width inputs, touch-friendly tap targets min `38px - 44px`).
- **Zero Horizontal Scroll**: All table containers must use `overflow-x: auto; -webkit-overflow-scrolling: touch;`.

---

## 🔄 10. Triple-Sync Deployment Workflow (Local + Git + FTP)

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

---

## 🛡️ 11. Agent Operating Constraints

1. **Browser Preview**: **NEVER** automatically open the agent browser preview (`browser_subagent`) unless the user explicitly asks for it (e.g. *"preview check karo"*, *"browser open karo"*).
2. **File Cleanup**: **ALWAYS** delete temporary scripts and test files (`temp_*.js`, `*.tmp`, scratch files) immediately after completing tasks.
