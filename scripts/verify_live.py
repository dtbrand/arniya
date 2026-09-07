import urllib.request
import json
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

urls = [
    'https://harmitethnic.com/wholesale.php',
    'https://harmitethnic.com/retailer.php',
    'https://harmitethnic.com/reseller.php',
    'https://harmitethnic.com/api/wholesale.php?action=get_dashboard',
    'https://harmitethnic.com/api/wholesale.php?action=get_catalog',
    'https://harmitethnic.com/api/retailer.php?action=get_dashboard',
    'https://harmitethnic.com/api/reseller.php?action=get_dashboard',
    'https://jaihanumantex.in/wholesale.php',
    'https://jaihanumantex.in/retailer.php',
    'https://jaihanumantex.in/reseller.php',
    'https://jaihanumantex.in/api/wholesale.php?action=get_dashboard',
    'https://jaihanumantex.in/api/wholesale.php?action=get_catalog',
    'https://jaihanumantex.in/api/retailer.php?action=get_dashboard',
    'https://jaihanumantex.in/api/reseller.php?action=get_dashboard',
]

print('=== VERIFYING LIVE ENDPOINTS ON PRODUCTION SERVERS ===')
all_ok = True
for u in urls:
    try:
        req = urllib.request.Request(u, headers={'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'})
        with urllib.request.urlopen(req, context=ctx, timeout=20) as resp:
            content = resp.read().decode('utf-8', errors='ignore')
            status = resp.status
            if 'api/' in u:
                data = json.loads(content)
                is_success = data.get('success', False)
                print(f"[{status}] {u} -> success: {is_success}, keys: {list(data.keys())[:3]}")
                if not is_success:
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
