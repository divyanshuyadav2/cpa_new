import json, re, pymysql

# 1. Connect to Database
conn = pymysql.connect(
    host='127.0.0.1',
    user='root',
    password='NewPassword123',
    database='phase-1',
    cursorclass=pymysql.cursors.DictCursor,
    autocommit=False
)

# 2. Curated & Scraped Dictionaries
# Load scraped Alniche, Waterley, Novelty
with open('/home/divyanshuyadav/.gemini/antigravity/brain/ee305eac-5028-408c-a2ac-6f28b4870fed/scratch/alniche_salts.json') as f:
    alniche_scraped = json.load(f)
with open('/home/divyanshuyadav/.gemini/antigravity/brain/ee305eac-5028-408c-a2ac-6f28b4870fed/scratch/waterley_salts.json') as f:
    waterley_scraped = json.load(f)
with open('/home/divyanshuyadav/.gemini/antigravity/brain/ee305eac-5028-408c-a2ac-6f28b4870fed/scratch/novelty_salts.json') as f:
    novelty_scraped = json.load(f)

print(f"Scraped files loaded: Alniche ({len(alniche_scraped)}), Waterley ({len(waterley_scraped)}), Novelty ({len(novelty_scraped)})")
