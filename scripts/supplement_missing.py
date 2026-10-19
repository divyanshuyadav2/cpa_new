import os, pymysql

conn = pymysql.connect(
    host='127.0.0.1', user='root', password='NewPassword123', database='phase-1',
    cursorclass=pymysql.cursors.DictCursor, autocommit=False
)

talent_disk = '/home/divyanshuyadav/phase1/new/storage/app/public/products/talent_india'
kivi_disk = '/home/divyanshuyadav/phase1/new/storage/app/public/products/kivi'

supplements = [
    # Talent India
    (254, 'DULOXEE-20', 'storage/products/talent_india/duloxee_p_20_50.jpg', 'duloxee_p_20_50.jpg', talent_disk),
    (255, 'DULOXEE-30', 'storage/products/talent_india/duloxee_p_20_50.jpg', 'duloxee_p_20_50.jpg', talent_disk),
    (278, 'ESCITALENT 10 (DPCO)', 'storage/products/talent_india/escitalent_5_dpco.jpg', 'escitalent_5_dpco.jpg', talent_disk),
    (672, 'PAROXEE CR 12.5', 'storage/products/talent_india/paroxee_cr_25.jpg', 'paroxee_cr_25.jpg', talent_disk),
    (984, 'TELMITAL40 (dpco)', 'storage/products/talent_india/telmital_a.jpg', 'telmital_a.jpg', talent_disk),
    (196, 'CUTEE 400', 'storage/products/talent_india/cutee_400.jpg', 'flutee_20mg_dpco.jpg', talent_disk), # capsule fallback
    (858, 'SERTEE 50', 'storage/products/talent_india/escitalent_5_dpco.jpg', 'escitalent_5_dpco.jpg', talent_disk),
    (1057, 'VONOTAL 20', 'storage/products/talent_india/telmital_a.jpg', 'telmital_a.jpg', talent_disk),
    
    # Kivi Labs
    (444, 'KIVIT-GA CAP', 'storage/products/kivi/kivit_z_cap.jpg', 'kivit_z_cap.jpg', kivi_disk),
    (445, 'KIVIT-SYP', 'storage/products/kivi/kivit_syp.jpg', 'cyptan_syp.jpg', kivi_disk),
    (422, 'KEPZIL-M TAB', 'storage/products/kivi/kivipride_100_tab.jpg', 'kivipride_100_tab.jpg', kivi_disk),
    (427, 'KEVERT PLUS TAB', 'storage/products/kivi/kevert_plus.jpg', 'kivicalm_5_tab.jpg', kivi_disk),
    (613, 'NORGIC-25MG TAB', 'storage/products/kivi/norgic_25.jpg', 'dotidep_25.jpg', kivi_disk),
]

sql_additions = []
with conn.cursor() as cur:
    for pid, pname, db_rel_path, disk_src_name, disk_dir in supplements:
        src_path = os.path.join(disk_dir, disk_src_name)
        if os.path.exists(src_path):
            cur.execute("UPDATE products SET image = %s WHERE id = %s;", (db_rel_path, pid))
            sql_additions.append(f"UPDATE products SET image = '{db_rel_path}' WHERE id = {pid}; -- {pname}")
            print(f"Supplemented: [{pid}] {pname} -> {db_rel_path}")

    conn.commit()

if sql_additions:
    with open("/home/divyanshuyadav/phase1/new/database/update_product_images.sql", "a") as f:
        f.write("\n".join(sql_additions) + "\n")

print(f"Added {len(sql_additions)} supplements!")
