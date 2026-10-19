import urllib.request, ssl, re, json, os, pymysql
from concurrent.futures import ThreadPoolExecutor

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
}

# 1. Connect to MySQL
conn = pymysql.connect(
    host='127.0.0.1', user='root', password='NewPassword123', database='phase-1',
    cursorclass=pymysql.cursors.DictCursor, autocommit=False
)

with conn.cursor() as cur:
    cur.execute("SELECT id, name, packing FROM products WHERE company_id = 10 ORDER BY id;")
    talent_products = cur.fetchall()

    cur.execute("SELECT id, name, packing FROM products WHERE company_id = 25 ORDER BY id;")
    kivi_products = cur.fetchall()

# Load 1mg scraped link catalogs
with open('/home/divyanshuyadav/.gemini/antigravity/brain/ee305eac-5028-408c-a2ac-6f28b4870fed/scratch/1mg_talent_links.json') as f:
    talent_1mg_links = json.load(f)

with open('/home/divyanshuyadav/.gemini/antigravity/brain/ee305eac-5028-408c-a2ac-6f28b4870fed/scratch/1mg_kivi_links.json') as f:
    kivi_1mg_links = json.load(f)

# Output directories
talent_dir = '/home/divyanshuyadav/phase1/new/storage/app/public/products/talent_india'
kivi_dir = '/home/divyanshuyadav/phase1/new/storage/app/public/products/kivi'
os.makedirs(talent_dir, exist_ok=True)
os.makedirs(kivi_dir, exist_ok=True)

def find_best_link(pname, catalog):
    # Clean product name
    clean = re.sub(r'\(.*?\)', '', pname).strip().lower()
    clean = re.sub(r'^\*+', '', clean)
    tokens = re.findall(r'[a-z0-9]+', clean)
    if not tokens:
        return None

    main_brand = tokens[0]
    numbers = [t for t in tokens if t.isdigit()]

    candidates = []
    for link, slug in catalog.items():
        slug_lower = slug.lower()
        if slug_lower.startswith(main_brand + '-') or f'-{main_brand}-' in slug_lower or slug_lower == main_brand:
            # Score candidate
            score = 10
            # Check numbers match
            for num in numbers:
                if f'-{num}-' in slug_lower or f'-{num}mg-' in slug_lower or slug_lower.endswith(f'-{num}'):
                    score += 5
            # Check secondary tokens (e.g. plus, sr, forte, er, od, dsr, etc.)
            for tok in tokens[1:]:
                if not tok.isdigit() and tok in slug_lower:
                    score += 3
            candidates.append((score, link))

    if candidates:
        candidates.sort(key=lambda x: -x[0])
        return candidates[0][1]

    return None

def extract_image_url_from_1mg(drug_path):
    url = f'https://www.1mg.com{drug_path}'
    try:
        r = urllib.request.Request(url, headers=headers)
        html = urllib.request.urlopen(r, context=ctx, timeout=8).read().decode('utf-8', errors='ignore')
        
        # Look for 32-char md5 hash jpg/png (1mg high-res drug photo)
        hashes = re.findall(r'([a-f0-9]{32}\.(?:jpg|png|jpeg))', html)
        if hashes:
            return f'https://onemg.gumlet.io/a_ignore,w_480,h_480,c_fit,q_auto,f_auto/{hashes[0]}'

        # Other gumlet drug images
        imgs = re.findall(r'https://onemg\.gumlet\.io/(?:[a-zA-Z0-9_\-\./%,]+/)?([a-zA-Z0-9_\-]+\.(?:jpg|jpeg|png))', html)
        for im in imgs:
            if not any(x in im.lower() for x in ['logo', 'icon', 'diagnostics', 'marketing', 'banner', 'fish', 'oil', 'svg']):
                return f'https://onemg.gumlet.io/a_ignore,w_480,h_480,c_fit,q_auto,f_auto/{im}'
    except Exception as e:
        pass
    return None

def download_and_save_image(img_url, target_path):
    try:
        r = urllib.request.Request(img_url, headers=headers)
        data = urllib.request.urlopen(r, context=ctx, timeout=10).read()
        if len(data) > 1000: # at least 1KB valid image
            with open(target_path, 'wb') as f:
                f.write(data)
            return True
    except Exception as e:
        pass
    return False

print(f"Loaded {len(talent_products)} Talent India products and {len(kivi_products)} Kivi products.")

def process_company(products, catalog, save_dir, dir_prefix):
    updates = [] # (pid, pname, relative_path)
    
    # 1. Map products to link
    mapped = []
    for p in products:
        link = find_best_link(p['name'], catalog)
        mapped.append((p, link))
    
    print(f"[{dir_prefix}] Total products: {len(products)}, Matched links: {sum(1 for _, l in mapped if l)}")

    def fetch_product(item):
        p, link = item
        pid = p['id']
        pname = p['name']
        slug = re.sub(r'[^a-zA-Z0-9]+', '_', pname.lower()).strip('_')
        target_filename = f"{slug}.jpg"
        target_path = os.path.join(save_dir, target_filename)
        rel_path = f"storage/products/{dir_prefix}/{target_filename}"

        if os.path.exists(target_path) and os.path.getsize(target_path) > 1000:
            return (pid, pname, rel_path, True)

        img_url = None
        if link:
            img_url = extract_image_url_from_1mg(link)
        
        if img_url:
            success = download_and_save_image(img_url, target_path)
            if success:
                return (pid, pname, rel_path, True)

        return (pid, pname, None, False)

    print(f"[{dir_prefix}] Downloading images in parallel...")
    with ThreadPoolExecutor(max_workers=8) as ex:
        results = list(ex.map(fetch_product, mapped))

    for pid, pname, rel_path, ok in results:
        if ok and rel_path:
            updates.append((pid, pname, rel_path))

    print(f"[{dir_prefix}] Successfully obtained images for {len(updates)} / {len(products)} products!")
    return updates

print("\n--- Processing Talent India ---")
talent_updates = process_company(talent_products, talent_1mg_links, talent_dir, "talent_india")

print("\n--- Processing Kivi Labs ---")
kivi_updates = process_company(kivi_products, kivi_1mg_links, kivi_dir, "kivi")

all_updates = talent_updates + kivi_updates
print(f"\nTotal updates to apply in database: {len(all_updates)}")

# Apply in MySQL
with conn.cursor() as cur:
    for pid, pname, rel_path in all_updates:
        cur.execute("UPDATE products SET image = %s WHERE id = %s;", (rel_path, pid))
    conn.commit()

print(f"Updated {len(all_updates)} products in MySQL database!")

# Append to database/update_product_images.sql
sql_patch_path = "/home/divyanshuyadav/phase1/new/database/update_product_images.sql"
new_sql_lines = [
    "",
    "-- Talent India & Kivi Labs Product Images",
]
for pid, pname, rel_path in all_updates:
    new_sql_lines.append(f"UPDATE products SET image = '{rel_path}' WHERE id = {pid}; -- {pname}")

with open(sql_patch_path, "a", encoding="utf-8") as f:
    f.write("\n".join(new_sql_lines) + "\n")

print(f"Appended {len(all_updates)} update statements to {sql_patch_path}")

