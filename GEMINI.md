# Workspace Instructions & User Preferences

## 👑 DT BRAND'S & JAI HANUMAN TEX — MASTER UI DESIGN SYSTEM & WORKSPACE RULES

> **MANDATORY INSTRUCTION FOR ALL AI AGENTS & DEVELOPERS:**
> This document defines the **Master Design Language, UI Components, Color System, 100% Vector SVG Standard, Styled Buttons Mandate, Complete Working Logic, Screenshot-Driven Execution, and Architectural Standards** for DT Brand's & Jai Hanuman Tex across all platforms (Admin Suite, Wholesale Dashboard, Shop, Single Product, Checkout, and Customer Portals).
> **EVERY AI AGENT MUST STRICTLY FOLLOW THESE RULES ON EVERY CHANGE, FEATURE ADDITION, OR UI REFACTOR WITHOUT ASKING OR REVERTING TO GENERIC STYLES.**

---

## 👑 The 5 Master Pillars of DT Brand's Design & Code

1. **🎨 100% STYLED BUTTONS MANDATE**: Never leave any plain, unstyled browser button. Every button must use DT Brand's primary gold gradient (`#8A681F` to `#D4AF37`), emerald success, soft blue, or pale gold pill styling.
2. **⚡ 100% REAL VECTOR SVG ICONS**: Zero emojis in core buttons, navigation, or table headers. All icons must be crisp inline SVG vectors (`stroke-width: 2 - 2.8`).
3. **🎯 100% FULLY WORKING GUARANTEE**: Zero dead buttons or broken actions. Every button, modal, drawer, search input, and filter must have attached working JS and backend logic.
4. **🔍 SCREENSHOT-DRIVEN DEEP AUDIT**: Auto-detect flaws, missing sub-options, clipped dropdowns, and unstyled UI, then build missing parts end-to-end.
5. **🚀 TRIPLE-SYNC DEPLOYMENT**: Local (Clean) ➔ GitHub ➔ Hostinger Live FTP.

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

## 🎨 1. Signature Brand Color System & Hierarchy

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

## 🔘 2. Master Button & Pill Hierarchy

| Button Type | Background / Gradient | Border | Text Color | SVG Icon Stroke |
| :--- | :--- | :--- | :--- | :--- |
| **👑 Primary Gold** | `linear-gradient(135deg, #8A681F, #B8860B, #D4AF37)` | `1px solid #8A681F` | `#181512` (Bold 800) | `#181512` (2.8) |
| **💬 WhatsApp B2B** | `linear-gradient(135deg, #15803D, #16A34A)` | `1px solid #15803D` | `#ffffff` (Bold 700) | `#ffffff` (2.2) |
| **⚪ Secondary Pill**| `#FAF5E8` | `1px solid #D4AF37` | `#8A681F` (Bold 700) | `#8A681F` (2.2) |
| **👁️ Info Pill**    | `#EFF6FF` | `1px solid #93C5FD` | `#1D4ED8` (Bold 700) | `#1D4ED8` (2.2) |
| **🗑️ Danger Pill**  | `#FEF2F2` | `1px solid #FECACA` | `#DC2626` (Weight 600)| `#DC2626` (2.0) |

---

## ⚡ 3. 100% Vector SVG Icon Standard (Zero Emojis in Buttons)

- **NEVER** use emojis (such as ✏️, 👁️, 🗑️, 💾, 📦, 📁, ✕) inside buttons, action links, table rows, or modal headers.
- **ALWAYS** use clean, lightweight, inline vector SVGs with `stroke-width: 2 - 2.8` and `stroke-linecap: round; stroke-linejoin: round;`.

---

## 🔍 4. Search Bar Master Placement & Interaction Rule

- **ALWAYS** place the search magnifying glass SVG icon on the **LEFT side** of every search input field across all pages.
- Ensure proper left padding (`padding-left: ~36px-42px`) so text and placeholders never overlap the left-aligned icon.
- Include a 1-tap clear button (`✕`) on the right side (`right: 8px;`) when text is entered.
- Include a Primary Gold button (`Search`) next to the input for instant filtering.

---

## 🛡️ 5. Agent Operating Constraints

1. **Browser Preview Rule**: **NEVER** automatically open the agent browser preview (`browser_subagent`) on every file edit or code change. **ONLY** launch browser preview / testing when the user explicitly asks for it (e.g. "preview check karo", "browser open karo").
2. **Temporary File Cleanup Rule**: **ALWAYS** automatically clean and delete all temporary files, test scripts (`temp_*.js`, `*.tmp`, scratch files) immediately after completing validation or tasks.
