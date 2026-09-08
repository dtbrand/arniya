import urllib.request
import json
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

urls = [
    ('https://harmitethnic.com/wholesale.php', 200, 'html'),
    ('https://harmitethnic.com/retailer.php', 200, 'html'),
    ('https://harmitethnic.com/reseller.php', 200, 'html'),
    ('https://harmitethnic.com/api/wholesale.php?action=get_dashboard', 200, 'json'),
    ('https://harmitethnic.com/api/wholesale.php?action=get_orders', 200, 'json'),
    ('https://harmitethnic.com/api/retailer.php?action=get_dashboard', 200, 'json'),
    ('https://harmitethnic.com/api/retailer.php?action=get_orders', 200, 'json'),
    ('https://harmitethnic.com/api/reseller.php?action=get_dashboard', 200, 'json'),
    ('https://harmitethnic.com/api/reseller.php?action=get_orders', 200, 'json'),
    ('https://harmitethnic.com/admin/login.php', 200, 'html'),
    ('https://harmitethnic.com/admin/orders/index.php', 200, 'redirect_ok'),
    ('https://harmitethnic.com/admin/shipping/index.php', 200, 'redirect_ok'),
    ('https://harmitethnic.com/admin/shipping/tracking.php', 200, 'redirect_ok'),
    ('https://harmitethnic.com/admin/shipping/rates.php', 200, 'redirect_ok'),
    ('https://harmitethnic.com/admin/shipping/methods.php', 200, 'redirect_ok'),
    ('https://harmitethnic.com/admin/payments/index.php', 200, 'redirect_ok'),
    ('https://harmitethnic.com/admin/payments/pending.php', 200, 'redirect_ok'),
    ('https://harmitethnic.com/api/shipping.php?action=get_rates', 200, 'json'),
    ('https://jaihanumantex.in/wholesale.php', 200, 'html'),
    ('https://jaihanumantex.in/retailer.php', 200, 'html'),
    ('https://jaihanumantex.in/reseller.php', 200, 'html'),
    ('https://jaihanumantex.in/api/wholesale.php?action=get_dashboard', 200, 'json'),
    ('https://jaihanumantex.in/api/wholesale.php?action=get_orders', 200, 'json'),
    ('https://jaihanumantex.in/api/retailer.php?action=get_dashboard', 200, 'json'),
    ('https://jaihanumantex.in/api/retailer.php?action=get_orders', 200, 'json'),
    ('https://jaihanumantex.in/api/reseller.php?action=get_dashboard', 200, 'json'),
    ('https://jaihanumantex.in/api/reseller.php?action=get_orders', 200, 'json'),
    ('https://jaihanumantex.in/admin/login.php', 200, 'html'),
    ('https://jaihanumantex.in/admin/orders/index.php', 200, 'redirect_ok'),
    ('https://jaihanumantex.in/admin/shipping/index.php', 200, 'redirect_ok'),
    ('https://jaihanumantex.in/admin/shipping/tracking.php', 200, 'redirect_ok'),
    ('https://jaihanumantex.in/admin/shipping/rates.php', 200, 'redirect_ok'),
    ('https://jaihanumantex.in/admin/shipping/methods.php', 200, 'redirect_ok'),
    ('https://jaihanumantex.in/admin/payments/index.php', 200, 'redirect_ok'),
    ('https://jaihanumantex.in/admin/payments/pending.php', 200, 'redirect_ok'),
    ('https://jaihanumantex.in/api/shipping.php?action=get_rates', 200, 'json'),
]

print('=== VERIFYING LIVE ENDPOINTS ON PRODUCTION SERVERS ===')
all_ok = True
for u, expected_code, check_type in urls:
    try:
        req = urllib.request.Request(u, headers={'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'})
        with urllib.request.urlopen(req, context=ctx, timeout=20) as resp:
            content = resp.read().decode('utf-8', errors='ignore')
            status = resp.status
            if check_type == 'json':
                data = json.loads(content)
                is_success = data.get('success', False)
                print(f"[{status}] {u} -> success: {is_success}, keys: {list(data.keys())[:3]}")
                if not is_success:
                    all_ok = False
            elif check_type == 'redirect_ok':
                final_url = resp.geturl()
                has_error = 'Fatal error' in content or 'Parse error' in content
                print(f"[{status}] {u} -> Final: {final_url} (Error: {has_error})")
                if has_error or status != 200:
                    all_ok = False
            else:
                has_error = 'Fatal error' in content or 'Parse error' in content
                print(f"[{status}] {u} -> Error: {has_error}, HTML length: {len(content)} bytes")
                if has_error or status != 200:
                    all_ok = False
    except Exception as e:
        print(f"[FAIL] {u}: {e}")
        all_ok = False

if all_ok:
    print('\n*** ALL PRODUCTION ENDPOINTS VERIFIED AND RESPONDING 200 OK! ***')
else:
    print('\n*** Some endpoints had issues. Review output above. ***')
