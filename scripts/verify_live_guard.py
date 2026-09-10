import urllib.request
import urllib.error
import json

domains = [
    'https://harmitethnic.com',
    'https://jaihanumantex.in'
]

print("=== VERIFYING LIVE API GUARD ON PRODUCTION DOMAINS ===")

for base in domains:
    url = f"{base}/api/products.php"
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'Referer': f"{base}/admin/products.php",
        'Cookie': 'PHPSESSID=attacker_spoofed_session_id_999; DTBRANDS_SESS=attacker_fake_cookie',
        'Content-Type': 'application/json'
    }
    payload = json.dumps({'action': 'create', 'name': 'Exploit Test Product'}).encode('utf-8')
    req = urllib.request.Request(url, data=payload, headers=headers, method='POST')
    
    try:
        resp = urllib.request.urlopen(req)
        print(f"[{base}] VULNERABLE! Status: {resp.status}")
    except urllib.error.HTTPError as e:
        body = e.read().decode('utf-8', errors='ignore')
        print(f"[{base}] BLOCKED WITH HTTP {e.code} (SECURE)")
        try:
            data = json.loads(body)
            print(f"  Response JSON: {data}")
        except Exception:
            print(f"  Response body snippet: {body[:150]}")
    except Exception as e:
        print(f"[{base}] Error: {e}")

print("=== VERIFICATION COMPLETE ===")
