import re, pymysql, os
from datetime import datetime

# Connect to MySQL
conn = pymysql.connect(
    host='127.0.0.1', user='root', password='NewPassword123', database='phase-1',
    cursorclass=pymysql.cursors.DictCursor, autocommit=False
)

from scripts.salts_dictionary import (
    CIPLA_PRODUCTS, LUPIN_PRODUCTS, ABBOTT_PRODUCTS, MANKIND_PRODUCTS,
    WALLACE_PRODUCTS, LINCOLN_PRODUCTS, HRK_PRODUCTS, WATERLEY_PRODUCTS,
    PONOOGUN_PRODUCTS, MEDIC_FORGE_PRODUCTS, NOVELTY_PRODUCTS, ALNICHE_PRODUCTS,
    LARENON_PRODUCTS, SUTURE_PLANET_PRODUCTS, QUBIX_PRODUCTS,
    LOTUS_DEFAULT_MAPPING, OTHER_SPECIFIC_PRODUCTS
)

DIRECT_MAP = {}
for d in [
    CIPLA_PRODUCTS, LUPIN_PRODUCTS, ABBOTT_PRODUCTS, MANKIND_PRODUCTS,
    WALLACE_PRODUCTS, LINCOLN_PRODUCTS, HRK_PRODUCTS, WATERLEY_PRODUCTS,
    PONOOGUN_PRODUCTS, MEDIC_FORGE_PRODUCTS, NOVELTY_PRODUCTS, ALNICHE_PRODUCTS,
    LARENON_PRODUCTS, SUTURE_PLANET_PRODUCTS, QUBIX_PRODUCTS, OTHER_SPECIFIC_PRODUCTS
]:
    DIRECT_MAP.update(d)

with conn.cursor() as cur:
    cur.execute("SELECT p.id, p.name, p.image, c.name as company_name FROM products p LEFT JOIN companies c ON p.company_id = c.id ORDER BY p.id;")
    all_products = cur.fetchall()

    cur.execute("SELECT id, name FROM salts;")
    existing_salts = {s['name'].lower().strip(): s['id'] for s in cur.fetchall()}

NAME_LOOKUP = {}
for p in all_products:
    if p['id'] in DIRECT_MAP:
        clean = re.sub(r'^\*+', '', p['name'].upper()).strip()
        NAME_LOOKUP[clean] = DIRECT_MAP[p['id']]

def resolve(p):
    pid = p['id']
    name = p['name']
    cname = p['company_name'] or ''
    clean = re.sub(r'^\*+', '', name.upper()).strip()

    if pid in DIRECT_MAP:
        return DIRECT_MAP[pid]
    
    if clean in NAME_LOOKUP:
        return NAME_LOOKUP[clean]

    if 'LOTUS' in cname.upper():
        for prefix, (salt, comp) in LOTUS_DEFAULT_MAPPING.items():
            if prefix in clean:
                return (salt, f"{comp}")
        return ("Surgical Suture / Hemostat", f"Surgical Suture / Device Material ({clean})")

    if 'QUBIX' in cname.upper() or 'NETSORB' in clean:
        return ("Polyglactin 910", f"Polyglactin 910 Synthetic Suture Material ({clean})")

    if 'SUTURE PLANET' in cname.upper():
        return ("Polyglactin 910", f"Polyglactin 910 Synthetic Absorbable Suture ({clean})")

    # Clean regex pharma rules
    if 'ALBENDAZOL' in clean:
        return ("Albendazole", "Albendazole 400 mg Chewable Tablet")
    if clean.startswith('ALP ') or 'ALPRAZ' in clean:
        return ("Alprazolam", "Alprazolam 0.25 mg / 0.5 mg Tablet")
    if 'AMIJECT' in clean or 'AMIKACIN' in clean:
        return ("Amikacin", "Amikacin Sulphate 500 mg / 2 ml Injection")
    if 'AMITWIX' in clean or 'AMITRIP' in clean:
        return ("Amitriptyline", "Amitriptyline Hydrochloride 10 mg / 25 mg Tablet")
    if 'ANXIMEL' in clean:
        return ("Flupentixol + Melitracen", "Flupentixol 0.5 mg + Melitracen 10 mg Tablet")
    if 'ASTAWIN' in clean or 'ATORVA' in clean or 'ATOR' in clean:
        return ("Atorvastatin", "Atorvastatin Calcium 10 mg / 20 mg Tablet")
    if 'ATRAL' in clean or 'AZITHRO' in clean or 'AZI' in clean:
        return ("Azithromycin", "Azithromycin 500 mg Tablet")
    if 'BACTIPOD' in clean or 'PODCV' in clean or 'CEFPOD' in clean:
        return ("Cefpodoxime Proxetil + Potassium Clavulanate", "Cefpodoxime Proxetil 200 mg + Potassium Clavulanate 125 mg Tablet")
    if 'CLOZE' in clean or 'CLONA' in clean or 'CLONAZ' in clean:
        return ("Clonazepam", "Clonazepam 0.5 mg Mouth Dissolving Tablet")
    if 'DULOX' in clean:
        return ("Duloxetine", "Duloxetine Hydrochloride 20 mg / 30 mg Capsule")
    if 'ESCITAL' in clean:
        return ("Escitalopram", "Escitalopram Oxalate 10 mg Tablet")
    if 'ETIZOL' in clean or 'EZOLENT' in clean:
        return ("Etizolam", "Etizolam 0.5 mg Tablet")
    if 'FLUTEE' in clean or 'FLUOX' in clean:
        return ("Fluoxetine", "Fluoxetine Hydrochloride 20 mg Capsule")
    if 'GLIMITAL' in clean or 'GLIME' in clean:
        return ("Glimepiride + Metformin", "Glimepiride 1 mg / 2 mg + Metformin 500 mg Tablet")
    if 'DOLO' in clean or 'PARACET' in clean or 'PCM' in clean:
        return ("Paracetamol", "Paracetamol 650 mg Tablet")
    if 'PANT' in clean or 'PANSEC' in clean or 'PANTO' in clean:
        return ("Pantoprazole", "Pantoprazole Sodium 40 mg Gastro-resistant Tablet")
    if 'RABE' in clean or 'RABFORGR' in clean or 'RABEP' in clean:
        return ("Rabeprazole", "Rabeprazole Sodium 20 mg Gastro-resistant Tablet")
    if 'ESOM' in clean or 'ESOGRESS' in clean or 'ESOBIZ' in clean:
        return ("Esomeprazole", "Esomeprazole Sodium 40 mg Gastro-resistant Tablet")
    if 'TELMI' in clean:
        return ("Telmisartan", "Telmisartan 40 mg Tablet")
    if 'ROSU' in clean:
        return ("Rosuvastatin", "Rosuvastatin Calcium 10 mg Tablet")
    if 'FARO' in clean:
        return ("Faropenem", "Faropenem Sodium 200 mg Tablet")
    if 'SILO' in clean or 'MYSILO' in clean:
        return ("Silodosin", "Silodosin 8 mg Capsule")
    if 'TAD' in clean or 'TADLONG' in clean:
        return ("Tadalafil", "Tadalafil 10 mg / 20 mg Tablet")
    if 'DROTA' in clean or 'DROTACHEK' in clean:
        return ("Drotaverine", "Drotaverine Hydrochloride 80 mg Tablet")
    if 'ACETO' in clean or 'ACECLO' in clean:
        return ("Aceclofenac + Paracetamol", "Aceclofenac 100 mg + Paracetamol 325 mg Tablet")
    if 'AMLO' in clean:
        return ("Amlodipine", "Amlodipine Besylate 5 mg Tablet")
    if 'AMOX' in clean or 'NOVAMOX' in clean:
        return ("Amoxicillin + Potassium Clavulanate", "Amoxicillin 500 mg + Potassium Clavulanate 125 mg Tablet")
    if 'CEF' in clean or 'CETIL' in clean or 'CIRETA' in clean:
        return ("Cefuroxime / Cefixime", "Cephalosporin Antibiotic Formulation")
    if 'CIPRO' in clean:
        return ("Ciprofloxacin", "Ciprofloxacin Hydrochloride 500 mg Tablet")
    if 'GLUTA' in clean:
        return ("L-Glutathione", "Reduced Glutathione Formulation")
    if 'ITRA' in clean:
        return ("Itraconazole", "Itraconazole 100 mg / 200 mg Capsule")
    if 'LEVO' in clean:
        return ("Levosulpiride / Levocetirizine", "Levosulpiride 25 mg / Levocetirizine 5 mg Tablet")
    if 'MEBE' in clean:
        return ("Mebeverine", "Mebeverine Hydrochloride 200 mg Sustained Release Capsule")
    if 'MERO' in clean:
        return ("Meropenem", "Meropenem 1000 mg IV Injection")
    if 'MESA' in clean:
        return ("Mesalamine", "Mesalamine (5-ASA) 400 mg / 1200 mg Prolonged Release Tablet")
    if 'MIDO' in clean:
        return ("Midodrine", "Midodrine Hydrochloride 5 mg Tablet")
    if 'MONT' in clean:
        return ("Montelukast + Levocetirizine", "Montelukast Sodium 10 mg + Levocetirizine 5 mg Tablet")
    if 'NIFU' in clean:
        return ("Nitrofurantoin", "Nitrofurantoin 100 mg Modified Release Tablet")
    if 'OFLOX' in clean or 'OFX' in clean:
        return ("Ofloxacin", "Ofloxacin 200 mg Tablet")
    if 'PREGAB' in clean:
        return ("Pregabalin + Methylcobalamin", "Pregabalin 75 mg + Methylcobalamin 750 mcg Capsule")
    if 'PRUCA' in clean:
        return ("Prucalopride", "Prucalopride Succinate 1 mg / 2 mg Tablet")
    if 'RAMO' in clean:
        return ("Ramosetron", "Ramosetron Hydrochloride 2.5 mcg / 5 mcg Tablet")
    if 'RIFA' in clean:
        return ("Rifaximin", "Rifaximin 400 mg / 550 mg Film Coated Tablet")
    if 'SOLI' in clean:
        return ("Solifenacin", "Solifenacin Succinate 5 mg / 10 mg Tablet")
    if 'SUCRAL' in clean:
        return ("Sucralfate + Oxetacaine", "Sucralfate 1000 mg + Oxetacaine 20 mg Suspension")
    if 'TAM' in clean:
        return ("Tamsulosin", "Tamsulosin Hydrochloride 0.4 mg Prolonged Release Capsule")
    if 'TENELI' in clean:
        return ("Teneligliptin", "Teneligliptin Hydrobromide 20 mg Tablet")
    if 'TERLI' in clean:
        return ("Terlipressin", "Terlipressin Acetate 1 mg / 2 ml Injection")
    if 'URSO' in clean or 'URSU' in clean:
        return ("Ursodeoxycholic Acid", "Ursodeoxycholic Acid 300 mg Tablet")
    if 'VONO' in clean:
        return ("Vonoprazan", "Vonoprazan Fumarate 20 mg Tablet")
    if 'EVIT' in clean or 'CUTEE' in clean:
        return ("Vitamin E", "Vitamin E (Tocopheryl Acetate) 400 IU Capsule")
    if 'D3' in clean or 'CHOLECAL' in clean or 'SOLYA' in clean:
        return ("Cholecalciferol", "Cholecalciferol (Vitamin D3) 60,000 IU Oral Formulation")
    if 'CAL' in clean or 'OSTEO' in clean:
        return ("Calcium + Vitamin D3", "Calcium Carbonate with Vitamin D3 & Minerals Tablet")
    if 'IRON' in clean or 'FERR' in clean or 'HEM' in clean:
        return ("Ferrous Ascorbate + Folic Acid", "Ferrous Ascorbate 100 mg + Folic Acid 1.5 mg + Zinc Tablet")
    if 'PROBIO' in clean or 'PREBIO' in clean or 'SPOR' in clean:
        return ("Prebiotics & Probiotics", "Multi-strain Probiotics with Prebiotics Formulation")
    if 'PROTEIN' in clean or 'PEP' in clean or 'WHEY' in clean:
        return ("Nutritional Protein Formulation", "High Protein Nutritional Supplement with Essential Micronutrients")
    if 'GEL' in clean or 'OINT' in clean or 'CREAM' in clean:
        return ("Topical Pharmaceutical Formulation", "Topical Formulation for External Use")
    if 'SYP' in clean or 'SUSP' in clean or 'DROP' in clean or 'SOLN' in clean:
        return ("Oral Liquid Formulation", "Oral Pharmaceutical Liquid Formulation")

    return ("Pharmaceutical Formulation", f"Standard Pharmaceutical Formulation ({clean})")

print("Processing products and salts...")
sql_statements = [
    "-- Product Salts & Formulations Update Patch",
    "-- Generated automatically by Phase 1 CPA Catalog Builder",
    "-- Sets active salt_id (referencing salts table) and full composition for products",
    ""
]

new_salts_to_insert = {} # name -> description
product_updates = [] # (pid, salt_name, composition, pname)

for p in all_products:
    salt_name, comp = resolve(p)
    salt_name = salt_name.strip()
    comp = comp.strip()
    s_key = salt_name.lower()

    if s_key not in existing_salts and s_key not in new_salts_to_insert:
        new_salts_to_insert[s_key] = (salt_name, f"Active generic pharmaceutical ingredient / formulation: {salt_name}")

    product_updates.append((p['id'], salt_name, comp, p['name']))

print(f"Total new unique salts to insert: {len(new_salts_to_insert)}")

# Step 1: Insert new salts into MySQL and record their IDs
with conn.cursor() as cur:
    for s_key, (s_name, s_desc) in new_salts_to_insert.items():
        cur.execute(
            "INSERT INTO salts (name, description, created_at, updated_at) VALUES (%s, %s, NOW(), NOW());",
            (s_name, s_desc)
        )
        new_id = cur.lastrowid
        existing_salts[s_key] = new_id
        
        # Add to SQL patch
        escaped_name = s_name.replace("'", "''")
        escaped_desc = s_desc.replace("'", "''")
        sql_statements.append(f"INSERT INTO salts (id, name, description, created_at, updated_at) SELECT {new_id}, '{escaped_name}', '{escaped_desc}', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = {new_id} OR LOWER(TRIM(name)) = '{s_key}');")

    sql_statements.append("")
    sql_statements.append("-- Product Updates")

    # Step 2: Update products in MySQL
    updated_count = 0
    for pid, s_name, comp, pname in product_updates:
        salt_id = existing_salts[s_name.lower()]
        cur.execute(
            "UPDATE products SET salt_id = %s, composition = %s, updated_at = NOW() WHERE id = %s;",
            (salt_id, comp, pid)
        )
        updated_count += 1

        escaped_comp = comp.replace("'", "''")
        escaped_pname = pname.replace("'", "''")
        sql_statements.append(f"UPDATE products SET salt_id = {salt_id}, composition = '{escaped_comp}', updated_at = NOW() WHERE id = {pid}; -- {escaped_pname}")

    conn.commit()

# Step 3: Write database/update_product_salts.sql
sql_file_path = "/home/divyanshuyadav/phase1/new/database/update_product_salts.sql"
with open(sql_file_path, 'w', encoding='utf-8') as f:
    f.write("\n".join(sql_statements) + "\n")

print(f"Successfully updated {updated_count} products in MySQL database!")
print(f"Wrote {len(sql_statements)} lines to {sql_file_path}")

