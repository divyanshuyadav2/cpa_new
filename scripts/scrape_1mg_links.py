import urllib.request, ssl, re, json
from bs4 import BeautifulSoup
from concurrent.futures import ThreadPoolExecutor

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
}

def get_marketer_drugs(base_url, max_pages=8):
    drugs = {}
    for page in range(1, max_pages + 1):
        url = f'{base_url}?page={page}'
        try:
            req = urllib.request.Request(url, headers=headers)
            html = urllib.request.urlopen(req, context=ctx, timeout=10).read().decode('utf-8', errors='ignore')
            links = re.findall(r'href=\"(/drugs/[^\"]+)\"', html)
            if not links:
                break
            for l in links:
                slug = l.replace('/drugs/', '').split('?')[0]
                drugs[l] = slug
        except Exception as e:
            print(f'Error page {page}: {e}')
            break
    return drugs

print("Collecting Talent India drug links from 1mg...")
talent_links = get_marketer_drugs('https://www.1mg.com/marketer/talent-india-74639', max_pages=8)
print(f"Total Talent India drug links: {len(talent_links)}")

print("Collecting Kivi Labs drug links from 1mg...")
kivi_links = get_marketer_drugs('https://www.1mg.com/marketer/kivi-labs-ltd-73139', max_pages=8)
print(f"Total Kivi Labs drug links: {len(kivi_links)}")

with open('/home/divyanshuyadav/.gemini/antigravity/brain/ee305eac-5028-408c-a2ac-6f28b4870fed/scratch/1mg_talent_links.json', 'w') as f:
    json.dump(talent_links, f, indent=2)

with open('/home/divyanshuyadav/.gemini/antigravity/brain/ee305eac-5028-408c-a2ac-6f28b4870fed/scratch/1mg_kivi_links.json', 'w') as f:
    json.dump(kivi_links, f, indent=2)

print("Saved link catalogs to scratch!")
