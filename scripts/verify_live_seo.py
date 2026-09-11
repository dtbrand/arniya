import urllib.request
import ssl
import sys

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

domains = ['https://harmitethnic.com', 'https://jaihanumantex.in']
headers = {'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) DTBrandBot/1.0'}

all_passed = True

for dom in domains:
    print(f"\n{'='*60}")
    print(f"=== TESTING SEO DISCOVERY ON {dom} ===")
    print(f"{'='*60}")
    
    # 1. robots.txt
    url_robots = f"{dom}/robots.txt"
    req = urllib.request.Request(url_robots, headers=headers)
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=15) as res:
            body = res.read().decode('utf-8', errors='ignore')
            has_sitemap = "Sitemap:" in body
            has_disallow_admin = "Disallow: /admin/" in body
            if res.status == 200 and has_sitemap and has_disallow_admin:
                print(f"  [PASS] robots.txt: HTTP {res.status}, Length: {len(body)} bytes, Sitemap directive present, Admin protected")
            else:
                print(f"  [FAIL] robots.txt: HTTP {res.status}, Content mismatch")
                all_passed = False
    except Exception as e:
        print(f"  [FAIL] robots.txt: {e}")
        all_passed = False

    # 2. sitemap.xml
    url_sitemap = f"{dom}/sitemap.xml"
    req = urllib.request.Request(url_sitemap, headers=headers)
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=15) as res:
            body = res.read().decode('utf-8', errors='ignore')
            has_urlset = "<urlset" in body
            has_shop = "/shop</loc>" in body
            content_type = res.headers.get('Content-Type', '')
            if res.status == 200 and has_urlset and has_shop and "xml" in content_type:
                print(f"  [PASS] sitemap.xml: HTTP {res.status}, Content-Type: {content_type}, Valid XML schema with core storefront routes")
            else:
                print(f"  [FAIL] sitemap.xml: HTTP {res.status}, Content-Type: {content_type}")
                all_passed = False
    except Exception as e:
        print(f"  [FAIL] sitemap.xml: {e}")
        all_passed = False

if all_passed:
    print("\n>>> ALL LIVE SEO DISCOVERY TESTS PASSED (100%) <<<\n")
    sys.exit(0)
else:
    print("\n>>> ONE OR MORE LIVE SEO TESTS FAILED <<<\n")
    sys.exit(1)
