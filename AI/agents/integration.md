# AGENT BRIEF · INTEGRATION

> **Scope:** everything the project talks to outside itself. The short version: **WhatsApp, and almost
> nothing else.** There is no payment gateway, no mail transport, no courier API, no SMS provider and no
> analytics SDK.
>
> Read with [INTEGRATIONS.md](../INTEGRATIONS.md).

---

## 1. What exists, and what only looks like it exists

| Integration | Reality |
| :--- | :--- |
| **WhatsApp** | `wa.me` deep links, plus `api/whatsapp.php` writing a `whatsapp_logs` row. **This is the real sales channel** |
| Payment gateway | **none.** Orders settle offline — that is why order creation is public (D-4) |
| Email / SMTP | **none wired.** Password reset stores a token that nothing delivers (KI-11) |
| Courier / tracking | **none.** `OrderManager::getAll():627` synthesises `'DEL-' . rand(10000, 99999)` (KI-3a) |
| Analytics / error reporting | **none.** `shared/sentry.php` and `shared/Includes/sentry.php` are both dead files |
| Wallet / store credit | **does not exist** (KI-12) |
| Google Fonts | the only third-party asset request in the pages |

**Assume nothing exists until you have grepped for it.** Four of the rows above are features that have UI,
have a plausible-looking code path, and reach nothing.

## 2. WhatsApp — the number is already correct

**All 47 raw occurrences are `917046363528`.** Only the *display* formatting varies: `+91 70463 63528` ×135,
`+91 7046363528` ×7, `+917046363528` ×1, bare `7046363528` ×128 (KI-17).

**Do not "fix the number".** A carried-forward note claimed it differed in three places; grepping showed the
change had already been completed in an earlier session. Recording it as a live defect would have sent the
next agent to edit working code.

```bash
grep -ron '917046363528' "DT Brand" | wc -l
```

When adding a WhatsApp entry point: use `wa.me/917046363528`, keep the message prefilled and URL-encoded, and
**never put a customer's data in a link the customer can see and edit.** Note that a grep for `/DT%20Brand/`
also finds 9 legitimate `wa.me` hits — do not "fix" those (KI-10).

## 3. The three features that are wired to nothing

Each has UI, has a code path, and delivers nothing. **Report them; do not quietly implement a provider.**

1. **Password reset (KI-11).** A token is generated and stored; no mail transport exists to send it. Adding
   one is a product decision (which provider, whose credentials, what happens to `reset_expires`) — and the
   credentials involved make it a SEC-1-adjacent change. Ask.
2. **Store settings (KI-8).** `admin/settings/index.php:40` reports `"Saved locally!"` and writes nowhere —
   **there is no `settings` table** in `arniya_master_production.sql`'s 18 tables, despite commit `0f01c6c`
   claiming persistence "directly to MySQL settings table". Either a table is added (owner's decision, plus a
   migration) or the UI stops claiming it saved.
3. **Courier tracking (KI-3a).** There is no carrier integration. The synthesised `DEL-` number **changes on
   every refresh** and an admin can read it out to a customer. Until a real field or provider exists, the
   correct display is empty (D-5).

Two more in the same family: `wishlist_items` is never written (KI-5) and `addresses` is never written (KI-6)
— the browser holds that state.

## 4. Rules for adding an integration

1. **No new dependency, no SDK, no composer package.** There is no autoloader and no build step (D-2). An
   integration here is `curl` or `file_get_contents` in a file that requires nothing new.
2. **Credentials go to `getenv()` with a documented variable name — and never a committed literal.** There
   is **no `.env` loader**, so tell the owner to set it in hPanel, and do not add a `?: '<literal>'` fallback
   containing a real value. Refer to it by variable name only (SEC-1).
3. **Every outbound call gets a timeout and a failure path that shows nothing.** A hung third party must not
   hang a page — the project already has one such pathology in `Database::getConnection()`
   ([performance.md](performance.md) §2).
4. **Log the attempt, not the payload.** `api/whatsapp.php` writing `whatsapp_logs` is the pattern; do not log
   a token, a full customer record, or a credential.
5. **Never transmit project code, customer data or credentials to a third party** without the owner asking
   for that specific thing.
6. **One authority per rule still applies.** If an integration returns a price, a freight charge or a tax
   rate, the server-side authority stays the authority — the integration is an input, not a replacement
   (D-11).
7. **Anything that touches money re-derives server-side.** A callback or webhook is a request, and requests
   are hostile: `unit_price`, `total_amount` and `channel` never come from one (D-4).

## 5. Verification

```bash
/c/xampp/php/php.exe -l "DT Brand/api/whatsapp.php"
```

**No network calls can be tested here**, and no MySQL means `whatsapp_logs` writes are unverifiable (KI-22).
So: `php -l`, a full-path grep to confirm you have found every call site, and a written checklist for the
owner — the exact URL to click, and what should appear on the phone. Report delivery behaviour as
**unverified until the owner tests on live**, and name the files to upload (D-8).

