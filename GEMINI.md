# Workspace Instructions & User Preferences

## Agent Browser Preview Rule

- **NEVER** automatically open the agent browser preview (`browser_subagent`) on every file edit or code change.
- **ONLY** launch browser preview / testing when the user explicitly asks for it (e.g. "preview check karo", "browser open karo", "check in preview").
- For regular changes: validate with CLI (`php -l`), commit/push to Git, and provide a direct response.

## Search Bar Icon Placement Rule

- **ALWAYS** place the search magnifying glass icon on the **LEFT side** of every search input field across all pages (Wholesaler, Shop, Single Product, Reports, Orders, Header, Modals, etc.).
- Ensure proper left padding (`padding-left: ~40px-44px`) so text and placeholders never overlap the left-aligned icon.
- Include a 1-tap clear button (`✕`) on the right side when text is entered.
