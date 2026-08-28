# INTEGRATIONS

> **The live tree makes zero outbound HTTP calls.** Verified 2026-08-29: across all 452 PHP files in
> `DT Brand/` there is not one `curl_init`, `curl_setopt`, `curl_exec`, `fsockopen`,
> `stream_context_create` or `file_get_contents('http…')`, and not one `mail()` call.
> Every "integration" in this project is either a **click-to-chat URL**, a **config file nothing
> reads**, or a **local log table that records events which never actually happened.**
> Read this before promising a customer that any notification will arrive.

---

## 1. Status of every integration named in the codebase

| Integration | Config | Code | Reality |
| :--- | :--- | :--- | :--- |
| **WhatsApp click-to-chat** | — | 76 `wa.me` / `api.whatsapp.com` links | **WORKS.** The only functioning integration |
| WhatsApp Cloud API | `config/whatsapp.php` (**0 requirers**) | none | not integrated. `WHATSAPP_ACCESS_TOKEN` / `_PHONE_ID` / `_WABA_ID` / `_VERIFY_TOKEN` are read by a config file nothing loads |
| Razorpay | `config/payment.php` (**0 requirers**) | none | not integrated. No checkout, no webhook handler, no order-capture. `RAZORPAY_KEY_ID` / `_KEY_SECRET` / `_WEBHOOK_SECRET` go nowhere |
| Delhivery | `config/shipping.php` (2 requirers) | none | a `<option value="delhivery">` in `admin/orders/components/order-filters.php:74`. No API, no label, no tracking pull |
| BlueDart | `config/shipping.php` | none | `order-filters.php:73`. Same |
| TCI Express | `.env.example` `TCI_ACCOUNT_ID` | none | named nowhere else |
| Email / SMTP | `config/mail.php` (**0 requirers**) | **no `mail()` anywhere** | **no email is ever sent by this application** |
| Sentry | `SENTRY_DSN` in `.env.example`; `shared/sentry.php` (**0 requirers**) | none | no error reporting leaves the server. `error_log()` is the whole story |
| CDN | `getenv('CDN_URL')` | read by a dead config | unused |

## 2. `config/` — 7 of 8 files have zero requirers

| File | Lines | Requirers |
| :--- | ---: | ---: |
| `config/shipping.php` | 28 | **2** — `api/cart.php`, `admin/products/components/product-shipping.php` |
| `config/app.php` | 17 | 0 |
| `config/auth.php` | 17 | 0 |
| `config/database.php` | 26 | **0** |
| `config/mail.php` | 18 | 0 |
| `config/payment.php` | 29 | 0 |
| `config/services.php` | 17 | 0 |
| `config/whatsapp.php` | 18 | 0 |

`config/shipping.php` is the only one that does anything. It carries the free-shipping threshold and
courier defaults that `api/cart.php` reads — a real dependency, don't touch it casually.

**`config/database.php` deserves separate attention.** It has zero requirers and it still contains the
live MySQL credentials as literals ([SECURITY.md](SECURITY.md) SEC-1). It is a credential leak with no
functional purpose — the cleanest single deletion in the project, once classified. Every live consumer
goes through `src/Database.php` instead.

The other six are **UNUSED**, not dead: they are a coherent configuration layer somebody wrote for a
front controller that was never built. Classify them in
[FILE_OWNERSHIP.md](FILE_OWNERSHIP.md); do not delete them in a bug-fix task. If a real integration is
ever added, these are the right files to wire up — and they will need an actual loader, because
nothing loads them today and **nothing loads `.env` either** ([DEPLOYMENT.md](DEPLOYMENT.md) §3).
## 3. WhatsApp — what actually works, and the part that lies

**Click-to-chat is the entire WhatsApp integration, and it is genuinely fine.** 76 links across the
tree build a `https://wa.me/917046363528?text=<urlencoded>` or
`https://api.whatsapp.com/send?phone=917046363528&text=…` URL and open it. No API, no token, no
server call — the customer's or admin's own WhatsApp client sends the message. It cannot fail
server-side and it needs no credentials.

Because it is pure URL construction, the two things to get right are the **number** and the
**encoding**:

- The brand number is `917046363528` (displayed `+91 70463 63528`). Verify every entry point uses it;
  it previously differed in three places.
- Message text is `urlencode`d, which is why **9** legitimate `…%20DT%20Brand%27s…` strings exist
  inside `?text=` parameters. Those are correct. Do not confuse them with the 16 broken
  `/DT%20Brand/` **path** prefixes ([FRONTEND.md](FRONTEND.md) §7).

**`api/whatsapp.php` is where it stops being honest.** The file is titled "WhatsApp Cloud API &
Broadcast Telemetry Engine". What it does:

- `GET` — returns the last 50 rows of `whatsapp_logs`, correctly gated on
  `$pdo !== null && !Database::isMockMode()` (`:36`).
- `POST` — `CREATE TABLE IF NOT EXISTS whatsapp_logs` (`:55`), then **inserts rows with
  `status` defaulting to `'sent'`**.

**Nothing sends anything.** There is no Cloud API call in the file or anywhere else. So the admin
WhatsApp console displays a broadcast history of messages marked `sent` that were never transmitted,
and `admin/Asset/js/admin.js`'s `launchBroadcast` reports a reach of "1,420". An admin will believe a
campaign went out. This is the most consequential fabrication in the project after the fake tracking
numbers, because it concerns something the owner will act on commercially.

Credit where due: the endpoint **is** admin-guarded, and its own comment (`:24-27`) records that it
previously was not — "anyone could read the log or forge entries in it". That fix was correct. The
remaining problem is the word `sent`.

Recommended honest fix, smallest version: default the `status` ENUM to `'queued'` and label the UI
"Queued for manual send", until a real Cloud API path exists. That is a schema plus copy change, and
it needs the owner's sign-off because it changes what the console claims.

## 4. Shipping — and why the fake tracking number matters so much

There is no carrier integration of any kind. No label generation, no rate lookup, no tracking pull,
no webhook. `admin/orders/components/order-filters.php:73-74` offers BlueDart and Delhivery as filter
values, and `config/shipping.php` names Delhivery as `default_courier` — that is the whole surface.

Therefore **the only way a real tracking number can ever enter this system is an admin typing it in.**
Which makes `src/OrderManager.php:627` a serious problem rather than a cosmetic one:

```php
'tracking' => $r['tracking_number'] ?? ('DEL-' . rand(10000, 99999))
```

Every order without a manually-entered tracking number gets a plausible, random, **different on every
page refresh** courier ID, on 13 call sites including the order list, payments, reports and shipping
pages ([BACKEND.md](BACKEND.md) §4). There is no integration that could ever reconcile it, and the
prefix `DEL-` implies Delhivery specifically. An admin reading that number to a customer sends them to
a courier site that has never heard of it.

Fix: return `null` and let the UI show "Not dispatched yet".

## 5. Payments

`config/payment.php` names Razorpay and reads three env vars. No file loads it. There is no payment
code path at all: `checkout.php` is 249 lines and collects details; `OrderManager::createOrder()`
writes an order row. **Money is not taken online.** Orders are effectively cash/UPI/offline settled
and reconciled by hand — consistent with a WhatsApp-first wholesale business, but it means:

- the admin "payments" module (`admin/payments/index.php`) reports on data no gateway produced, and
  reads `OrderManager::getAll()` (`:44`), so it inherits the two demo orders;
- `RAZORPAY_WEBHOOK_SECRET` implies a webhook endpoint that does not exist — nothing under `api/`
  handles one;
- the `UTR-9821039812` literal in the `admin/orders/` previews is not a real transaction reference and
  never could be.

## 6. Email

No `mail()`, no PHPMailer, no SMTP client. `config/mail.php` is unused. The consequence is already
recorded in [SECURITY.md](SECURITY.md): `Auth::requestPasswordReset()` (`:572`) writes `reset_token`
and `reset_expires` to `customers` and **nothing delivers the link**, so the reset flow cannot be
completed by a customer and unused tokens accumulate. Order confirmations, shipping notices and trade
approvals are likewise never emailed. WhatsApp click-to-chat is the entire customer-notification
channel, and it requires a human to press send.

## 7. Rules for adding a real integration

1. **Nothing loads `config/` and nothing loads `.env`.** Wire the loader first, or read `getenv()`
   directly with no committed literal fallback. Prove `getenv()` works on Hostinger before relying on
   it ([DEPLOYMENT.md](DEPLOYMENT.md) §3).
2. **Never commit a token.** Not as a literal, not as a `?:` fallback, not in a comment, not in an
   example file. That pattern is exactly how SEC-1 happened.
3. **A log row is not a delivery receipt.** Write the record only after the remote call returns
   success, and store the real remote status — never a hardcoded `'sent'`.
4. **Fail loudly and honestly.** `error_log()` the exception, return
   `['success' => false, 'message' => <fixed string>]`, and let the UI show the failure. Do not return
   `$e->getMessage()` to a client ([API.md](API.md) §7).
5. **Set a timeout on every outbound call.** These are synchronous page renders with no queue; a
   hanging carrier API becomes a hanging storefront, exactly as the missing negative memoisation in
   `Database` already does ([PERFORMANCE.md](PERFORMANCE.md) §3).
6. **Guard the endpoint.** `dt_api_require_admin()` per action, following `api/upload.php` as the
   template — the one fully hardened write path in the project.
7. Record the decision in [DECISIONS.md](DECISIONS.md). Adding the first real outbound dependency
   changes this project's failure modes permanently.

