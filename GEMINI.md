# Workspace Instructions & User Preferences

## Triple-Sync Deployment Workflow (Local + Git + FTP)

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

## Agent Browser Preview Rule

- **NEVER** automatically open the agent browser preview (`browser_subagent`) on every file edit or code change.
- **ONLY** launch browser preview / testing when the user explicitly asks for it (e.g. "preview check karo", "browser open karo", "check in preview").
- For regular changes: validate with Node / CLI syntax check, commit/push to Git, upload to FTP, and provide a direct response.

---

## Search Bar Icon Placement Rule

- **ALWAYS** place the search magnifying glass icon on the **LEFT side** of every search input field across all pages (Wholesaler, Shop, Single Product, Reports, Orders, Header, Modals, etc.).
- Ensure proper left padding (`padding-left: ~36px-42px`) so text and placeholders never overlap the left-aligned icon.
- Include a 1-tap clear button (`✕`) on the right side when text is entered.

---

## Temporary File Cleanup Rule

- **ALWAYS** automatically clean and delete all temporary files, test scripts (`temp_*.js`, `*.tmp`, scratch files) immediately after completing validation or tasks.
- Keep the workspace repository 100% clean with zero leftover untracked debug files.
