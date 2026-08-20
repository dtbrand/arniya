# 👑 DT BRAND'S & JAI HANUMAN TEX — MASTER UI DESIGN SYSTEM & WORKSPACE PROTOCOL

> **ENTERPRISE DESIGN SPECIFICATION & AUTONOMOUS AGENT RULEBOOK**  
> *Author:* DT Brand's & Jai Hanuman Tex Core Engineering  
> *Version:* 3.5 Enterprise Wholesale & Luxury Shop Standard  
> *Target Workspace:* `c:\Users\sai\Desktop\WhatsApp CRM`

---

## 👑 The 7 Master Pillars of DT Brand's Design & Code

1. **🧠 HINDI / TYPO TOLERANCE & PRO ENGLISH**: Understand Hindi/Hinglish queries & typos seamlessly, auto-translate to clear intent, and write 100% professional English in all UI, code, comments, labels, and git commits.
2. **🎨 100% STYLED BUTTONS MANDATE**: Never leave any plain, unstyled browser button. Every button must use DT Brand's primary gold gradient (`#8A681F` to `#D4AF37`), emerald success, soft blue, or pale gold pill styling.
3. **⚡ 100% REAL VECTOR SVG ICONS**: Zero emojis in core buttons, navigation, or table headers. All icons must be crisp inline SVG vectors (`stroke-width: 2 - 2.8`).
4. **📱 FLUID MOBILE & TABLET AUTO-SIZING**: Wholesale Desktop + Tablet + Phone responsive architecture with auto-fit grids, touch targets, and zero broken/clipped layouts across any device.
5. **🎯 100% FULLY WORKING GUARANTEE**: Zero dead buttons or broken actions. Every button, modal, drawer, search input, and filter must have attached working JS and backend logic.
6. **🔍 SCREENSHOT-DRIVEN DEEP AUDIT**: Auto-detect flaws, missing sub-options, clipped dropdowns, and unstyled UI, then build missing parts end-to-end.
7. **🚀 TRIPLE-SYNC DEPLOYMENT**: Local (Clean) ➔ GitHub ➔ Hostinger Live FTP.

---

## 📱 Mobile & Tablet Responsive Auto-Sizing Tokens

```css
/* Responsive KPI Ribbon */
.dt-kpi-grid, [style*="grid-template-columns:repeat(auto-fit"] {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 12px;
}

@media (max-width: 1024px) {
    .dt-kpi-grid, [style*="grid-template-columns:repeat(auto-fit"] {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 10px !important;
    }
}

@media (max-width: 600px) {
    .dt-kpi-grid, [style*="grid-template-columns:repeat(auto-fit"] {
        grid-template-columns: 1fr !important;
        gap: 8px !important;
    }
    
    .wp-tablenav {
        flex-direction: column !important;
        align-items: stretch !important;
    }
    
    .wp-search-box {
        width: 100% !important;
    }
    
    .wp-search-box input {
        width: 100% !important;
    }
}
```

---

## 🎨 Master Color Tokens & Hierarchy

| Token Name | Hex Value | Primary Usage |
| :--- | :--- | :--- |
| **Signature Heritage Gold** | `#8A681F` | Master Primary Buttons, Key Icons, Active State Borders |
| **Radiant Accent Gold** | `#D4AF37` | Button Gradient Stops, Badges, Star Ratings, Glows |
| **Soft Pale Gold Tint** | `#FAF5E8` | Secondary Action Pills, Card Backgrounds, Active Badges |
| **Dark Velvet Obsidian** | `#181512` | Main Text, Headings, Modal Headers, Master Button Text |
| **Emerald Wholesale Success**| `#15803D` | In-Stock Pills, WhatsApp B2B Buttons, Approved Badges |
| **Amber Warning** | `#B45309` | Low Stock Badges, Pending Moderation, Warning Notices |
| **Crimson Danger** | `#DC2626` | Out-of-Stock Badges, Trash / Delete Actions |
| **Soft Blue Info** | `#1D4ED8` | View on Shop Pills, Customer Reply Actions |
