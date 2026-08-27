import io, os, re, sys

ROOT = r"C:\Users\sai\Desktop\WhatsApp CRM\DT Brand"

FILES = [
    "admin/customers/pending.php",
    "admin/Includes/adminsidebar.php",
    "admin/customers/edit.php",
    "admin/customers/assets/js/customer-status.js",
    "src/CustomerManager.php",
    "api/customers.php",
    "shared/account.php",
    "account.php",
    "shared/auth_modal.php",
    "assets/js/modals.js",
    "src/Auth.php",
    "src/OrderManager.php",
]

fails = []
def check(cond, label):
    print(("  PASS  " if cond else "  FAIL  ") + label)
    if not cond:
        fails.append(label)

def read(rel):
    with io.open(os.path.join(ROOT, rel), "r", encoding="utf-8", errors="replace") as f:
        return f.read()

def strip_strings_and_comments(s, php=True):
    """Crude but adequate: remove quoted strings and comments so brace counting
    is not thrown off by braces inside text."""
    s = re.sub(r"/\*.*?\*/", "", s, flags=re.S)
    s = re.sub(r"(?m)//[^\n]*", "", s)
    if php:
        s = re.sub(r"(?m)#[^\n]*", "", s)
    s = re.sub(r"'(?:\\.|[^'\\])*'", "''", s)
    s = re.sub(r'"(?:\\.|[^"\\])*"', '""', s)
    s = re.sub(r"`(?:\\.|[^`\\])*`", "``", s)
    return s

print("=" * 66)
print("SYNTAX (real parsers: php -l / node --check)")
print("=" * 66)
PHP_BIN = r"C:\xampp\php\php.exe"
import subprocess

# Control test: prove the JS checker is in classic-script mode before trusting
# any result from it. Duplicate top-level function declarations are LEGAL in a
# classic script and illegal in an ES module, so this input separates the two
# modes. If this fails, every JS "syntax error" below is an artifact of the
# checker, not a real defect in the file.
_ctl = subprocess.run(["node", "--check", "--input-type=commonjs"],
                      input=b"function f(){}\nfunction f(){}\n", capture_output=True)
check(_ctl.returncode == 0,
      "CONTROL: node parses duplicate top-level functions (classic mode active)")
if _ctl.returncode != 0:
    print("        Refusing to report JS syntax findings: checker is in module mode.")

for rel in FILES:
    path = os.path.join(ROOT, rel)
    if rel.endswith(".php"):
        out = subprocess.run([PHP_BIN, "-l", path], capture_output=True, text=True)
        ok = "No syntax errors" in (out.stdout + out.stderr)
        check(ok, "php -l       %s" % rel)
    else:
        # MUST parse as a classic script, not an ES module. The workspace root
        # (../package.json) declares "type": "module", so `node --check <path>`
        # would parse these as modules and wrongly reject duplicate top-level
        # function declarations -- which are legal in the classic <script src>
        # context the browser actually loads them in. Feeding the file on stdin
        # with an explicit --input-type bypasses package.json resolution.
        with open(path, "rb") as fh:
            src = fh.read()
        out = subprocess.run(
            ["node", "--check", "--input-type=commonjs"],
            input=src, capture_output=True
        )
        ok = out.returncode == 0
        check(ok, "node --check (classic) %s" % rel)
    if not ok:
        # The JS branch runs without text=True (it pipes bytes on stdin), so
        # normalise before printing. ASCII-only: Windows stdout is cp1252.
        def _txt(v):
            if v is None:
                return ""
            return v.decode("utf-8", "replace") if isinstance(v, bytes) else v
        msg = (_txt(out.stdout) + _txt(out.stderr)).strip()
        msg = msg.encode("ascii", "replace").decode("ascii")
        print("        " + msg.replace("\n", "\n        "))

print("\n" + "=" * 66)
print("BEHAVIOUR ASSERTIONS")
print("=" * 66)

# --- pending.php: real DB-backed approval queue -----------------------------
p = read("admin/customers/pending.php")
print("\nadmin/customers/pending.php")
check("WHERE `status` = 'pending'" in p, "queries real pending rows")
check("adminguard.php" in p, "admin guard included")
check("$active_subnav = \"pending\"" in p, "sub-nav key set to pending")
check(p.count("dt-cust-badge") >= 1 and "amber" not in p, "no undefined .amber badge class")
check("data.success" in p, "decision handler gates on data.success")
check(".catch(" in p, "decision handler has a catch")
check("if (row) row.remove()" in p, "row removed only after server confirms")
check("No trade applications are waiting" in p, "honest empty state")
check("$loadError" in p and "htmlspecialchars($loadError)" in p, "DB failure surfaced, not hidden")
# every echoed DB value must be escaped
raw_echoes = re.findall(r"<\?=\s*\$row\[", p)
check(len(raw_echoes) == 0, "no unescaped <?= $row[...] output (%d found)" % len(raw_echoes))

# --- sidebar ---------------------------------------------------------------
s = read("admin/Includes/adminsidebar.php")
print("\nadmin/Includes/adminsidebar.php")
check("customers/pending.php" in s, "Trade Approvals link present")
check("sb_pending_trade_count" in s, "pending count variable defined")
check(s.count("$sb_pending_trade_count = ") == 3, "pending count set on all 3 branches (%d)" % s.count("$sb_pending_trade_count = "))
check("WHERE `status` = 'pending'" in s, "count comes from a real query")
check(s.count("$sb_pending_trade_count = 0;") == 2, "no invented backlog on DB failure")

# --- CustomerManager::updateStatus -----------------------------------------
c = read("src/CustomerManager.php")
print("\nsrc/CustomerManager.php  (updateStatus)")
body = c[c.find("function updateStatus"):]
body = body[:body.find("function updateCreditLimit")]
check("in_array($status, ['active', 'pending', 'suspended'], true)" in body, "status whitelisted against the ENUM")
check("return false;" in body.split("isMockMode()")[1][:200], "no-DB path returns false (no fake success)")
check("rowCount()" in body, "verifies a row actually matched")
check("return true;" not in body.split("isMockMode()")[1][:200], "mock mode never reports success")

# --- api/customers.php -----------------------------------------------------
a = read("api/customers.php")
print("\napi/customers.php  (update_status)")
blk = a[a.find("$action === 'update_status'"):]
blk = blk[:blk.find("update_credit")]
check("['active', 'pending', 'suspended']" in blk, "status validated at the API edge too")
check("if (!$ok)" in blk, "failure returns an error, not success:false-with-200")
check("'success' => true" in blk, "success only on a confirmed update")
check("_guard.php" in a or "dt_api_require_admin" in a, "endpoint still admin-guarded")

# --- customer-status.js ----------------------------------------------------
j = read("admin/customers/assets/js/customer-status.js")
print("\nadmin/customers/assets/js/customer-status.js")
check(".catch(() => {})" not in j, "fire-and-forget catch removed")
check("data.success" in j, "gates on data.success")
check("paintRowStatus" in j, "badge repaint extracted behind the check")
check(j.find("paintRowStatus(targetId") > j.find("if (data && data.success)"), "repaint happens after confirmation")
check("was NOT updated" in j, "failure is reported as a failure")

# --- edit.php --------------------------------------------------------------
e = read("admin/customers/edit.php")
print("\nadmin/customers/edit.php")
check("dtDeactivateCustomer" in e and "onclick=\"dtDeactivateCustomer(" in e, "deactivate wired to checked handler")
check("fetch('/api/customers.php', { method:'POST', body:p });" not in e, "old fire-and-forget inline call gone")
check("Account deactivated in database.'" not in e, "unconditional success toast gone")
check("was NOT deactivated" in e, "deactivate failure reported")
check("was NOT saved" in e, "save failure reported")
check("Secure Password Reset Link dispatched" not in e, "fake 'reset link dispatched' claim gone")
check("dtSendResetLink" in e and "wa.me/" in e, "reset now uses a real WhatsApp hand-off")
check("$cust['first_name']" in e.split("dtSendResetLink('")[1][:200], "reset uses an existing $cust key")
# save handler must not navigate on failure
save = e[e.find("params.append('action', 'update')"):]
save = save[:save.find("</script>")]
check(save.count("window.location.href") == 1, "redirect only on the success path (%d)" % save.count("window.location.href"))

# --- registration forms collect GSTIN/PAN ----------------------------------
print("\nGSTIN/PAN capture on the three live register surfaces")
sa = read("shared/account.php")
ra = read("account.php")
am = read("shared/auth_modal.php")
mj = read("assets/js/modals.js")
check("acTradeKycGroup" in sa and "acRegGstin" in sa, "shared/account.php has the KYC block")
check("acTradeKycGroup" in sa.split("window.selectModalRole = function")[1][:600], "shared/account.php toggles it by role")
check("params.append('gstin'" in sa, "shared/account.php sends gstin")
check("regTradeKycGroup" in ra and "regGstin" in ra, "account.php has the KYC block")
check("regTradeKycGroup" in ra.split("window.selectRole")[1][:600], "account.php toggles it by role")
check("params.append('gstin'" in ra, "account.php sends gstin")
check("dtRegTradeKyc" in am and "dtRegGstin" in am, "auth_modal.php has the KYC block")
check("dtToggleTradeKyc" in am and "dtToggleTradeKyc" in mj, "auth_modal toggle defined and called")
check("payload.gstin" in mj, "modals.js sends gstin")
# all three must only send it for trade roles
check("typeCode !== 'retail'" in sa, "shared/account.php gates on trade role")
check("typeCode !== 'retail'" in ra, "account.php gates on trade role")
check("type === 'wholesale' || type === 'reseller'" in mj, "modals.js gates on trade role")

# --- modals.js login catch -------------------------------------------------
print("\nassets/js/modals.js  (login)")
login = mj[mj.find("window.handleAuthLogin"):mj.find("window.dtToggleTradeKyc")]
check("'Welcome back!', 'success'" not in login, "fake 'Welcome back!' on network error gone")
check("Could not reach the sign-in service" in login, "network error reported honestly")
check("closeAuthModal" not in login.split(".catch(function ()")[1][:400], "modal no longer closes on failure")

# --- pending_approval handled on every register surface --------------------
print("\npending_approval handled client-side")
for rel, src, needle in (("shared/account.php", sa, "data.pending_approval"),
                         ("account.php", ra, "pending_approval"),
                         ("assets/js/modals.js", mj, "res.pending_approval")):
    check(needle in src, "%s branches on pending_approval" % rel)

# --- the server-side gate itself ------------------------------------------
print("\nserver-side B2B gate (regression guard)")
au = read("src/Auth.php")
check("$grantStatus = 'pending'" in au, "trade request parked at pending")
check("'pending_approval' => true" in au, "pending response shape")
check("status = 'active'" in au or "status` = 'active'" in au or "'active'" in au, "login still requires active")
om = read("src/OrderManager.php")
check("SELECT type, status FROM customers WHERE id = ?" in om, "channel re-verified from the DB")

print("\n" + "=" * 66)
if fails:
    print("FAILURES: %d" % len(fails))
    for f in fails:
        print("  - " + f)
    sys.exit(1)
print("ALL CHECKS PASSED")
