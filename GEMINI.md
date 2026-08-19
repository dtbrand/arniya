# Workspace Instructions & User Preferences

## 👑 DT BRAND'S & JAI HANUMAN TEX — MASTER UI DESIGN SYSTEM & WORKSPACE RULES

> **MANDATORY INSTRUCTION FOR ALL AI AGENTS & DEVELOPERS:**
> This document defines the **Master Design Language, UI Components, Color System, Screenshot-Driven Execution, and Architectural Standards** for DT Brand's & Jai Hanuman Tex across all platforms (Admin Suite, Wholesale Dashboard, Shop, Single Product, Checkout, and Customer Portals).
> **EVERY AI AGENT MUST STRICTLY FOLLOW THESE RULES ON EVERY CHANGE, FEATURE ADDITION, OR UI REFACTOR WITHOUT ASKING OR REVERTING TO GENERIC STYLES.**

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

### 🐙 GitHub Repository Details

- **Repository URL**: `https://github.com/dtbrand/arniya.git`
- **Branch**: `main`
- **Remote Config**: Authenticated with dtbrand Personal Access Token (PAT)

---

## 📸 Screenshot-Driven Autonomous Execution Protocol

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

## 🎨 1. Signature Brand Color System & Hierarchy

DT Brand's visual identity represents **Heritage Indian Luxury & Enterprise B2B Textile Craftsmanship**. Never use generic flat colors (e.g. plain red, default blue, neon green).

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

## 🔍 2. Search Bar Master Placement & Interaction Rule

- **ALWAYS** place the search magnifying glass icon on the **LEFT side** of every search input field across all pages (Wholesaler, Shop, Single Product, Reports, Orders, Header, Modals, Categories, Reviews).
- Ensure proper left padding (`padding-left: ~36px-42px`) so text and placeholders never overlap the left-aligned icon.
- Include a 1-tap clear button (`✕`) on the right side (`right: 8px;`) when text is entered.
- Include a Primary Gold button (`Search`) next to the input for instant filtering.

---

## 🔲 3. Wholesaler Dashboard & Shop Product Card Architecture

Every Product Card (in Wholesale Dashboard, Shop, or Admin Grid) must deliver high-density B2B wholesale intelligence:
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

## 📊 4. Wholesale KPI Summary Metrics Ribbon

Every main module (Products, Categories, Reviews, Featured, Best Sellers, New Arrivals) must open with a **4-Card KPI Ribbon**:
- **Card 1 (Gold Accent)**: Primary Count / Designs (`📦 ACTIVE B2B DESIGNS: 1,240 SKUs`).
- **Card 2 (Emerald Accent)**: Valuation / Approval Rate (`💰 B2B CATALOG VALUATION: ₹48.60 Lakhs` or `APPROVED: 1,380`).
- **Card 3 (Blue Accent)**: Surat Central Depot Inventory (`🏭 SURAT CENTRAL DEPOT: 8,450 Units Ready`).
- **Card 4 (Amber Accent)**: Reorders / Pending Action (`⚠️ LOW STOCK REORDERS: 14 Lots`).

---

## 🔘 5. Interactive Buttons & Action Pills Hierarchy

- **Primary Gold Button**: `linear-gradient(135deg, #8A681F, #B8860B, #D4AF37)` with dark `#181512` bold text (`font-weight: 800`).
- **WhatsApp B2B Button**: `#15803D` with vector WhatsApp SVG.
- **Reply Action Pill**: `#EFF6FF` with `#1D4ED8` text.
- **Approve Action Pill**: `linear-gradient(135deg, #8A681F, #D4AF37)` with dark text.
- **Trash Action Pill**: `#FEF2F2` with `#DC2626` text.

---

## 📋 6. Checkout & Form Fields Architecture

1. **Card Headers**: Signature Velvet Dark gradient (`linear-gradient(135deg, #181512 0%, #2A241E 50%, #3D342A 100%)`) with radiant gold trim (`#D4AF37`) and crisp vector SVGs.
2. **Dropdowns & Selects**:
   - **Never Clip Text**: Always specify adequate `min-width: 160px - 180px` and `height: 32px - 34px` so option labels like *"Filter by star rating"* or *"Filter by stock status"* are never truncated.
3. **Focus States**: On `:focus`: `border-color: #8A681F; box-shadow: 0 0 0 1px #8A681F, 0 0 8px rgba(212,175,55,0.25);`.
4. **Labels & Validation**: Labels: `font-size: 12px; font-weight: 700; color: #181512;`. Required asterisks: `color: #b32d2e; font-weight: 800;`.

---

## ⚡ 7. Vector SVG Icons & Animated Sparkle Standard

- **Zero Emojis in Core Buttons**: Use clean, crisp inline vector SVGs with `stroke-width: 2 - 2.8`.
- **AI Features**: Use multi-sparkle animated SVG icons (`@keyframes dtSparkleFloat`) with signature gold gradients (`#D4AF37` / `#FAF5E8`).

---

## 📱 8. Mobile Auto-Sizing & Responsive Layouts

- **Breakpoints**: Desktop: `1024px+`, Tablet: `768px - 1023px`, Mobile: `< 768px` (Single-column stacked, full-width inputs, touch-friendly tap targets min `38px - 44px`).
- **Zero Horizontal Scroll**: All table containers must use `overflow-x: auto; -webkit-overflow-scrolling: touch;`.

---

## 🛡️ 9. Agent Operating Constraints

1. **Browser Preview Rule**: **NEVER** automatically open the agent browser preview (`browser_subagent`) on every file edit or code change. **ONLY** launch browser preview / testing when the user explicitly asks for it (e.g. "preview check karo", "browser open karo").
2. **Temporary File Cleanup Rule**: **ALWAYS** automatically clean and delete all temporary files, test scripts (`temp_*.js`, `*.tmp`, scratch files) immediately after completing validation or tasks.
