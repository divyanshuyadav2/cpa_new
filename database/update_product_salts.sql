-- Product Salts & Formulations Update Patch
-- Generated automatically by Phase 1 CPA Catalog Builder
-- Sets active salt_id (referencing salts table) and full composition for products

INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 11, 'Branched Chain Amino Acids', 'Active generic pharmaceutical ingredient / formulation: Branched Chain Amino Acids', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 11 OR LOWER(TRIM(name)) = 'branched chain amino acids');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 12, 'Cefuroxime Axetil', 'Active generic pharmaceutical ingredient / formulation: Cefuroxime Axetil', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 12 OR LOWER(TRIM(name)) = 'cefuroxime axetil');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 13, 'Pharmaceutical Formulation', 'Active generic pharmaceutical ingredient / formulation: Pharmaceutical Formulation', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 13 OR LOWER(TRIM(name)) = 'pharmaceutical formulation');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 14, 'Esomeprazole', 'Active generic pharmaceutical ingredient / formulation: Esomeprazole', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 14 OR LOWER(TRIM(name)) = 'esomeprazole');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 15, 'Carbohydrates + Electrolytes + Amino Acids', 'Active generic pharmaceutical ingredient / formulation: Carbohydrates + Electrolytes + Amino Acids', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 15 OR LOWER(TRIM(name)) = 'carbohydrates + electrolytes + amino acids');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 16, 'Sodium Alginate + Sodium Bicarbonate + Calcium Carbonate', 'Active generic pharmaceutical ingredient / formulation: Sodium Alginate + Sodium Bicarbonate + Calcium Carbonate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 16 OR LOWER(TRIM(name)) = 'sodium alginate + sodium bicarbonate + calcium carbonate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 17, 'Esomeprazole + Domperidone', 'Active generic pharmaceutical ingredient / formulation: Esomeprazole + Domperidone', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 17 OR LOWER(TRIM(name)) = 'esomeprazole + domperidone');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 18, 'Pantoprazole', 'Active generic pharmaceutical ingredient / formulation: Pantoprazole', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 18 OR LOWER(TRIM(name)) = 'pantoprazole');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 19, 'Coenzyme Q10 + L-Carnitine + Lycopene', 'Active generic pharmaceutical ingredient / formulation: Coenzyme Q10 + L-Carnitine + Lycopene', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 19 OR LOWER(TRIM(name)) = 'coenzyme q10 + l-carnitine + lycopene');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 20, 'Dextrose', 'Active generic pharmaceutical ingredient / formulation: Dextrose', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 20 OR LOWER(TRIM(name)) = 'dextrose');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 21, 'Polyglactin 910', 'Active generic pharmaceutical ingredient / formulation: Polyglactin 910', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 21 OR LOWER(TRIM(name)) = 'polyglactin 910');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 22, 'Drotaverine + Aceclofenac', 'Active generic pharmaceutical ingredient / formulation: Drotaverine + Aceclofenac', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 22 OR LOWER(TRIM(name)) = 'drotaverine + aceclofenac');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 23, 'Acebrophylline', 'Active generic pharmaceutical ingredient / formulation: Acebrophylline', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 23 OR LOWER(TRIM(name)) = 'acebrophylline');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 24, 'Acebrophylline + N-Acetylcysteine', 'Active generic pharmaceutical ingredient / formulation: Acebrophylline + N-Acetylcysteine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 24 OR LOWER(TRIM(name)) = 'acebrophylline + n-acetylcysteine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 25, 'Aceclofenac + Paracetamol + Serratiopeptidase', 'Active generic pharmaceutical ingredient / formulation: Aceclofenac + Paracetamol + Serratiopeptidase', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 25 OR LOWER(TRIM(name)) = 'aceclofenac + paracetamol + serratiopeptidase');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 26, 'Aceclofenac + Paracetamol', 'Active generic pharmaceutical ingredient / formulation: Aceclofenac + Paracetamol', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 26 OR LOWER(TRIM(name)) = 'aceclofenac + paracetamol');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 27, 'Acotiamide', 'Active generic pharmaceutical ingredient / formulation: Acotiamide', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 27 OR LOWER(TRIM(name)) = 'acotiamide');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 28, 'Antioxidants + Multivitamins + Minerals', 'Active generic pharmaceutical ingredient / formulation: Antioxidants + Multivitamins + Minerals', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 28 OR LOWER(TRIM(name)) = 'antioxidants + multivitamins + minerals');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 29, 'Kojic Acid + Glycolic Acid + Vitamin C', 'Active generic pharmaceutical ingredient / formulation: Kojic Acid + Glycolic Acid + Vitamin C', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 29 OR LOWER(TRIM(name)) = 'kojic acid + glycolic acid + vitamin c');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 30, 'Rifampicin + Isoniazid + Pyrazinamide + Ethambutol', 'Active generic pharmaceutical ingredient / formulation: Rifampicin + Isoniazid + Pyrazinamide + Ethambutol', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 30 OR LOWER(TRIM(name)) = 'rifampicin + isoniazid + pyrazinamide + ethambutol');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 31, 'Midodrine', 'Active generic pharmaceutical ingredient / formulation: Midodrine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 31 OR LOWER(TRIM(name)) = 'midodrine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 32, 'Albendazole', 'Active generic pharmaceutical ingredient / formulation: Albendazole', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 32 OR LOWER(TRIM(name)) = 'albendazole');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 33, 'Branched Chain Amino Acids + Protein', 'Active generic pharmaceutical ingredient / formulation: Branched Chain Amino Acids + Protein', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 33 OR LOWER(TRIM(name)) = 'branched chain amino acids + protein');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 34, 'Metadoxine + Silymarin + L-Ornithine L-Aspartate', 'Active generic pharmaceutical ingredient / formulation: Metadoxine + Silymarin + L-Ornithine L-Aspartate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 34 OR LOWER(TRIM(name)) = 'metadoxine + silymarin + l-ornithine l-aspartate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 35, 'L-Ornithine L-Aspartate + Vitamin Kit', 'Active generic pharmaceutical ingredient / formulation: L-Ornithine L-Aspartate + Vitamin Kit', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 35 OR LOWER(TRIM(name)) = 'l-ornithine l-aspartate + vitamin kit');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 36, 'Fat Soluble Vitamins + Minerals', 'Active generic pharmaceutical ingredient / formulation: Fat Soluble Vitamins + Minerals', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 36 OR LOWER(TRIM(name)) = 'fat soluble vitamins + minerals');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 37, 'Levosulpiride', 'Active generic pharmaceutical ingredient / formulation: Levosulpiride', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 37 OR LOWER(TRIM(name)) = 'levosulpiride');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 38, 'Alfuzosin', 'Active generic pharmaceutical ingredient / formulation: Alfuzosin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 38 OR LOWER(TRIM(name)) = 'alfuzosin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 39, 'Alfuzosin + Dutasteride', 'Active generic pharmaceutical ingredient / formulation: Alfuzosin + Dutasteride', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 39 OR LOWER(TRIM(name)) = 'alfuzosin + dutasteride');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 40, 'Alprazolam', 'Active generic pharmaceutical ingredient / formulation: Alprazolam', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 40 OR LOWER(TRIM(name)) = 'alprazolam');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 41, 'Ademetionine', 'Active generic pharmaceutical ingredient / formulation: Ademetionine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 41 OR LOWER(TRIM(name)) = 'ademetionine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 42, 'Amitriptyline', 'Active generic pharmaceutical ingredient / formulation: Amitriptyline', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 42 OR LOWER(TRIM(name)) = 'amitriptyline');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 43, 'Amikacin', 'Active generic pharmaceutical ingredient / formulation: Amikacin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 43 OR LOWER(TRIM(name)) = 'amikacin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 44, 'Essential Amino Acids + Albumin', 'Active generic pharmaceutical ingredient / formulation: Essential Amino Acids + Albumin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 44 OR LOWER(TRIM(name)) = 'essential amino acids + albumin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 45, 'Amitriptyline + Chlordiazepoxide', 'Active generic pharmaceutical ingredient / formulation: Amitriptyline + Chlordiazepoxide', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 45 OR LOWER(TRIM(name)) = 'amitriptyline + chlordiazepoxide');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 46, 'Flupentixol + Melitracen', 'Active generic pharmaceutical ingredient / formulation: Flupentixol + Melitracen', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 46 OR LOWER(TRIM(name)) = 'flupentixol + melitracen');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 47, 'Cefuroxime / Cefixime', 'Active generic pharmaceutical ingredient / formulation: Cefuroxime / Cefixime', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 47 OR LOWER(TRIM(name)) = 'cefuroxime / cefixime');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 48, 'Tamsulosin', 'Active generic pharmaceutical ingredient / formulation: Tamsulosin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 48 OR LOWER(TRIM(name)) = 'tamsulosin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 49, 'L-Arginine + Proanthocyanidins', 'Active generic pharmaceutical ingredient / formulation: L-Arginine + Proanthocyanidins', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 49 OR LOWER(TRIM(name)) = 'l-arginine + proanthocyanidins');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 50, 'L-Arginine + Proanthocyanidins + Zinc', 'Active generic pharmaceutical ingredient / formulation: L-Arginine + Proanthocyanidins + Zinc', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 50 OR LOWER(TRIM(name)) = 'l-arginine + proanthocyanidins + zinc');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 51, 'Biotin + Amino Acids + Vitamins', 'Active generic pharmaceutical ingredient / formulation: Biotin + Amino Acids + Vitamins', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 51 OR LOWER(TRIM(name)) = 'biotin + amino acids + vitamins');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 52, 'Cefpodoxime Proxetil + Potassium Clavulanate', 'Active generic pharmaceutical ingredient / formulation: Cefpodoxime Proxetil + Potassium Clavulanate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 52 OR LOWER(TRIM(name)) = 'cefpodoxime proxetil + potassium clavulanate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 53, 'Bezafibrate', 'Active generic pharmaceutical ingredient / formulation: Bezafibrate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 53 OR LOWER(TRIM(name)) = 'bezafibrate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 54, 'Fat Soluble Vitamins + Zinc', 'Active generic pharmaceutical ingredient / formulation: Fat Soluble Vitamins + Zinc', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 54 OR LOWER(TRIM(name)) = 'fat soluble vitamins + zinc');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 55, 'Oral Liquid Formulation', 'Active generic pharmaceutical ingredient / formulation: Oral Liquid Formulation', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 55 OR LOWER(TRIM(name)) = 'oral liquid formulation');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 56, 'Biotin + Calcium Pantothenate + Zinc', 'Active generic pharmaceutical ingredient / formulation: Biotin + Calcium Pantothenate + Zinc', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 56 OR LOWER(TRIM(name)) = 'biotin + calcium pantothenate + zinc');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 57, 'Colloidal Bismuth Subcitrate', 'Active generic pharmaceutical ingredient / formulation: Colloidal Bismuth Subcitrate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 57 OR LOWER(TRIM(name)) = 'colloidal bismuth subcitrate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 58, 'Cefixime + Moxifloxacin', 'Active generic pharmaceutical ingredient / formulation: Cefixime + Moxifloxacin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 58 OR LOWER(TRIM(name)) = 'cefixime + moxifloxacin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 59, 'Bone Wax', 'Active generic pharmaceutical ingredient / formulation: Bone Wax', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 59 OR LOWER(TRIM(name)) = 'bone wax');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 60, 'Cholecalciferol', 'Active generic pharmaceutical ingredient / formulation: Cholecalciferol', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 60 OR LOWER(TRIM(name)) = 'cholecalciferol');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 61, 'Calcium + Vitamin D3', 'Active generic pharmaceutical ingredient / formulation: Calcium + Vitamin D3', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 61 OR LOWER(TRIM(name)) = 'calcium + vitamin d3');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 62, 'Carica Papaya Leaf Extract', 'Active generic pharmaceutical ingredient / formulation: Carica Papaya Leaf Extract', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 62 OR LOWER(TRIM(name)) = 'carica papaya leaf extract');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 63, 'L-Carnitine + CoQ10 + Zinc', 'Active generic pharmaceutical ingredient / formulation: L-Carnitine + CoQ10 + Zinc', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 63 OR LOWER(TRIM(name)) = 'l-carnitine + coq10 + zinc');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 64, 'Carvedilol', 'Active generic pharmaceutical ingredient / formulation: Carvedilol', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 64 OR LOWER(TRIM(name)) = 'carvedilol');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 65, 'Multivitamins + Minerals', 'Active generic pharmaceutical ingredient / formulation: Multivitamins + Minerals', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 65 OR LOWER(TRIM(name)) = 'multivitamins + minerals');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 66, 'Cefuroxime', 'Active generic pharmaceutical ingredient / formulation: Cefuroxime', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 66 OR LOWER(TRIM(name)) = 'cefuroxime');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 67, 'Cefuroxime Axetil + Potassium Clavulanate', 'Active generic pharmaceutical ingredient / formulation: Cefuroxime Axetil + Potassium Clavulanate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 67 OR LOWER(TRIM(name)) = 'cefuroxime axetil + potassium clavulanate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 68, 'N-Acetylcysteine + Vitamin C', 'Active generic pharmaceutical ingredient / formulation: N-Acetylcysteine + Vitamin C', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 68 OR LOWER(TRIM(name)) = 'n-acetylcysteine + vitamin c');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 69, 'Protein Nutritional Formula', 'Active generic pharmaceutical ingredient / formulation: Protein Nutritional Formula', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 69 OR LOWER(TRIM(name)) = 'protein nutritional formula');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 70, 'Clonazepam', 'Active generic pharmaceutical ingredient / formulation: Clonazepam', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 70 OR LOWER(TRIM(name)) = 'clonazepam');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 71, 'Liquid Paraffin + Milk of Magnesia + Sodium Picosulfate', 'Active generic pharmaceutical ingredient / formulation: Liquid Paraffin + Milk of Magnesia + Sodium Picosulfate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 71 OR LOWER(TRIM(name)) = 'liquid paraffin + milk of magnesia + sodium picosulfate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 72, 'Polyethylene Glycol', 'Active generic pharmaceutical ingredient / formulation: Polyethylene Glycol', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 72 OR LOWER(TRIM(name)) = 'polyethylene glycol');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 73, 'Carbonyl Iron + Folic Acid + Vitamin B12 + Zinc', 'Active generic pharmaceutical ingredient / formulation: Carbonyl Iron + Folic Acid + Vitamin B12 + Zinc', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 73 OR LOWER(TRIM(name)) = 'carbonyl iron + folic acid + vitamin b12 + zinc');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 74, 'Calcium Carbonate + Vitamin D3 + Vitamin K2-7', 'Active generic pharmaceutical ingredient / formulation: Calcium Carbonate + Vitamin D3 + Vitamin K2-7', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 74 OR LOWER(TRIM(name)) = 'calcium carbonate + vitamin d3 + vitamin k2-7');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 75, 'Pregabalin + Methylcobalamin', 'Active generic pharmaceutical ingredient / formulation: Pregabalin + Methylcobalamin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 75 OR LOWER(TRIM(name)) = 'pregabalin + methylcobalamin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 76, 'Pregabalin + Methylcobalamin + Nortriptyline', 'Active generic pharmaceutical ingredient / formulation: Pregabalin + Methylcobalamin + Nortriptyline', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 76 OR LOWER(TRIM(name)) = 'pregabalin + methylcobalamin + nortriptyline');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 77, 'Pancreatin', 'Active generic pharmaceutical ingredient / formulation: Pancreatin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 77 OR LOWER(TRIM(name)) = 'pancreatin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 78, 'DL-Methionine + Vitamins + Antioxidants', 'Active generic pharmaceutical ingredient / formulation: DL-Methionine + Vitamins + Antioxidants', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 78 OR LOWER(TRIM(name)) = 'dl-methionine + vitamins + antioxidants');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 79, 'Antioxidant Formulation + Selenium + Methionine', 'Active generic pharmaceutical ingredient / formulation: Antioxidant Formulation + Selenium + Methionine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 79 OR LOWER(TRIM(name)) = 'antioxidant formulation + selenium + methionine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 80, 'Vitamin E', 'Active generic pharmaceutical ingredient / formulation: Vitamin E', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 80 OR LOWER(TRIM(name)) = 'vitamin e');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 81, 'Cyproheptadine + Tricholine Citrate', 'Active generic pharmaceutical ingredient / formulation: Cyproheptadine + Tricholine Citrate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 81 OR LOWER(TRIM(name)) = 'cyproheptadine + tricholine citrate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 82, 'Diosmin + Hesperidin', 'Active generic pharmaceutical ingredient / formulation: Diosmin + Hesperidin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 82 OR LOWER(TRIM(name)) = 'diosmin + hesperidin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 83, 'Dexlansoprazole', 'Active generic pharmaceutical ingredient / formulation: Dexlansoprazole', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 83 OR LOWER(TRIM(name)) = 'dexlansoprazole');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 84, 'Aluminium Hydroxide + Magnesium Hydroxide + Simethicone + Oxetacaine', 'Active generic pharmaceutical ingredient / formulation: Aluminium Hydroxide + Magnesium Hydroxide + Simethicone + Oxetacaine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 84 OR LOWER(TRIM(name)) = 'aluminium hydroxide + magnesium hydroxide + simethicone + oxetacaine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 85, 'Rifaximin', 'Active generic pharmaceutical ingredient / formulation: Rifaximin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 85 OR LOWER(TRIM(name)) = 'rifaximin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 86, 'Ondansetron', 'Active generic pharmaceutical ingredient / formulation: Ondansetron', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 86 OR LOWER(TRIM(name)) = 'ondansetron');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 87, 'Topical Pharmaceutical Formulation', 'Active generic pharmaceutical ingredient / formulation: Topical Pharmaceutical Formulation', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 87 OR LOWER(TRIM(name)) = 'topical pharmaceutical formulation');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 88, 'Drotaverine', 'Active generic pharmaceutical ingredient / formulation: Drotaverine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 88 OR LOWER(TRIM(name)) = 'drotaverine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 89, 'Drotaverine + Mefenamic Acid', 'Active generic pharmaceutical ingredient / formulation: Drotaverine + Mefenamic Acid', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 89 OR LOWER(TRIM(name)) = 'drotaverine + mefenamic acid');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 90, 'Duloxetine', 'Active generic pharmaceutical ingredient / formulation: Duloxetine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 90 OR LOWER(TRIM(name)) = 'duloxetine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 91, 'Lactulose', 'Active generic pharmaceutical ingredient / formulation: Lactulose', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 91 OR LOWER(TRIM(name)) = 'lactulose');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 92, 'Natural Vitamin E', 'Active generic pharmaceutical ingredient / formulation: Natural Vitamin E', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 92 OR LOWER(TRIM(name)) = 'natural vitamin e');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 93, 'Rabeprazole', 'Active generic pharmaceutical ingredient / formulation: Rabeprazole', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 93 OR LOWER(TRIM(name)) = 'rabeprazole');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 94, 'Rabeprazole + Domperidone', 'Active generic pharmaceutical ingredient / formulation: Rabeprazole + Domperidone', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 94 OR LOWER(TRIM(name)) = 'rabeprazole + domperidone');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 95, 'Rabeprazole + Cinitapride', 'Active generic pharmaceutical ingredient / formulation: Rabeprazole + Cinitapride', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 95 OR LOWER(TRIM(name)) = 'rabeprazole + cinitapride');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 96, 'Pinaverium Bromide', 'Active generic pharmaceutical ingredient / formulation: Pinaverium Bromide', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 96 OR LOWER(TRIM(name)) = 'pinaverium bromide');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 97, 'Rabeprazole + Ondansetron', 'Active generic pharmaceutical ingredient / formulation: Rabeprazole + Ondansetron', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 97 OR LOWER(TRIM(name)) = 'rabeprazole + ondansetron');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 98, 'Bacillus clausii', 'Active generic pharmaceutical ingredient / formulation: Bacillus clausii', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 98 OR LOWER(TRIM(name)) = 'bacillus clausii');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 99, 'Psyllium Husk', 'Active generic pharmaceutical ingredient / formulation: Psyllium Husk', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 99 OR LOWER(TRIM(name)) = 'psyllium husk');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 100, 'Escitalopram', 'Active generic pharmaceutical ingredient / formulation: Escitalopram', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 100 OR LOWER(TRIM(name)) = 'escitalopram');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 101, 'Esomeprazole + Itopride', 'Active generic pharmaceutical ingredient / formulation: Esomeprazole + Itopride', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 101 OR LOWER(TRIM(name)) = 'esomeprazole + itopride');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 102, 'Esomeprazole + Clarithromycin + Amoxicillin', 'Active generic pharmaceutical ingredient / formulation: Esomeprazole + Clarithromycin + Amoxicillin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 102 OR LOWER(TRIM(name)) = 'esomeprazole + clarithromycin + amoxicillin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 103, 'Esomeprazole + Levosulpiride', 'Active generic pharmaceutical ingredient / formulation: Esomeprazole + Levosulpiride', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 103 OR LOWER(TRIM(name)) = 'esomeprazole + levosulpiride');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 104, 'Clarithromycin + Amoxicillin + Esomeprazole', 'Active generic pharmaceutical ingredient / formulation: Clarithromycin + Amoxicillin + Esomeprazole', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 104 OR LOWER(TRIM(name)) = 'clarithromycin + amoxicillin + esomeprazole');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 105, 'Polyester Suture', 'Active generic pharmaceutical ingredient / formulation: Polyester Suture', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 105 OR LOWER(TRIM(name)) = 'polyester suture');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 106, 'Prebiotics + Probiotics', 'Active generic pharmaceutical ingredient / formulation: Prebiotics + Probiotics', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 106 OR LOWER(TRIM(name)) = 'prebiotics + probiotics');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 107, 'Etizolam', 'Active generic pharmaceutical ingredient / formulation: Etizolam', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 107 OR LOWER(TRIM(name)) = 'etizolam');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 108, 'Guar Gum Fiber', 'Active generic pharmaceutical ingredient / formulation: Guar Gum Fiber', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 108 OR LOWER(TRIM(name)) = 'guar gum fiber');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 109, 'Faropenem + Potassium Clavulanate', 'Active generic pharmaceutical ingredient / formulation: Faropenem + Potassium Clavulanate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 109 OR LOWER(TRIM(name)) = 'faropenem + potassium clavulanate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 110, 'Faropenem', 'Active generic pharmaceutical ingredient / formulation: Faropenem', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 110 OR LOWER(TRIM(name)) = 'faropenem');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 111, 'Silymarin + CoQ10 + L-Carnitine', 'Active generic pharmaceutical ingredient / formulation: Silymarin + CoQ10 + L-Carnitine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 111 OR LOWER(TRIM(name)) = 'silymarin + coq10 + l-carnitine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 112, 'Myo-Inositol + D-Chiro Inositol + Melatonin', 'Active generic pharmaceutical ingredient / formulation: Myo-Inositol + D-Chiro Inositol + Melatonin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 112 OR LOWER(TRIM(name)) = 'myo-inositol + d-chiro inositol + melatonin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 113, 'Diltiazem', 'Active generic pharmaceutical ingredient / formulation: Diltiazem', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 113 OR LOWER(TRIM(name)) = 'diltiazem');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 114, 'Flavoxate', 'Active generic pharmaceutical ingredient / formulation: Flavoxate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 114 OR LOWER(TRIM(name)) = 'flavoxate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 115, 'Absorbable Gelatin Sponge', 'Active generic pharmaceutical ingredient / formulation: Absorbable Gelatin Sponge', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 115 OR LOWER(TRIM(name)) = 'absorbable gelatin sponge');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 116, 'Fluoxetine', 'Active generic pharmaceutical ingredient / formulation: Fluoxetine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 116 OR LOWER(TRIM(name)) = 'fluoxetine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 117, 'Methylcobalamin + Alpha Lipoic Acid', 'Active generic pharmaceutical ingredient / formulation: Methylcobalamin + Alpha Lipoic Acid', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 117 OR LOWER(TRIM(name)) = 'methylcobalamin + alpha lipoic acid');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 118, 'Oral Rehydration Salts', 'Active generic pharmaceutical ingredient / formulation: Oral Rehydration Salts', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 118 OR LOWER(TRIM(name)) = 'oral rehydration salts');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 119, 'Branched Chain Amino Acids + Electrolytes', 'Active generic pharmaceutical ingredient / formulation: Branched Chain Amino Acids + Electrolytes', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 119 OR LOWER(TRIM(name)) = 'branched chain amino acids + electrolytes');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 120, 'Nutritional Formulation for Pregnancy', 'Active generic pharmaceutical ingredient / formulation: Nutritional Formulation for Pregnancy', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 120 OR LOWER(TRIM(name)) = 'nutritional formulation for pregnancy');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 121, 'Itopride', 'Active generic pharmaceutical ingredient / formulation: Itopride', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 121 OR LOWER(TRIM(name)) = 'itopride');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 122, 'Itopride + Pantoprazole', 'Active generic pharmaceutical ingredient / formulation: Itopride + Pantoprazole', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 122 OR LOWER(TRIM(name)) = 'itopride + pantoprazole');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 123, 'Glimepiride + Metformin', 'Active generic pharmaceutical ingredient / formulation: Glimepiride + Metformin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 123 OR LOWER(TRIM(name)) = 'glimepiride + metformin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 124, 'L-Glutathione', 'Active generic pharmaceutical ingredient / formulation: L-Glutathione', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 124 OR LOWER(TRIM(name)) = 'l-glutathione');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 125, 'L-Glutamine', 'Active generic pharmaceutical ingredient / formulation: L-Glutamine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 125 OR LOWER(TRIM(name)) = 'l-glutamine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 126, 'Sodium Picosulfate', 'Active generic pharmaceutical ingredient / formulation: Sodium Picosulfate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 126 OR LOWER(TRIM(name)) = 'sodium picosulfate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 127, 'Iron Bisglycinate + L-Methylfolate + Methylcobalamin', 'Active generic pharmaceutical ingredient / formulation: Iron Bisglycinate + L-Methylfolate + Methylcobalamin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 127 OR LOWER(TRIM(name)) = 'iron bisglycinate + l-methylfolate + methylcobalamin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 128, 'L-Ornithine L-Aspartate', 'Active generic pharmaceutical ingredient / formulation: L-Ornithine L-Aspartate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 128 OR LOWER(TRIM(name)) = 'l-ornithine l-aspartate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 129, 'HMB + BCAA', 'Active generic pharmaceutical ingredient / formulation: HMB + BCAA', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 129 OR LOWER(TRIM(name)) = 'hmb + bcaa');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 130, 'Silymarin + L-Ornithine L-Aspartate + B-Complex', 'Active generic pharmaceutical ingredient / formulation: Silymarin + L-Ornithine L-Aspartate + B-Complex', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 130 OR LOWER(TRIM(name)) = 'silymarin + l-ornithine l-aspartate + b-complex');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 131, 'Calcium Carbonate + Vitamin D3 + Zinc', 'Active generic pharmaceutical ingredient / formulation: Calcium Carbonate + Vitamin D3 + Zinc', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 131 OR LOWER(TRIM(name)) = 'calcium carbonate + vitamin d3 + zinc');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 132, 'Catgut Suture', 'Active generic pharmaceutical ingredient / formulation: Catgut Suture', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 132 OR LOWER(TRIM(name)) = 'catgut suture');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 133, 'Sodium Hyaluronate', 'Active generic pharmaceutical ingredient / formulation: Sodium Hyaluronate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 133 OR LOWER(TRIM(name)) = 'sodium hyaluronate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 134, 'Meropenem', 'Active generic pharmaceutical ingredient / formulation: Meropenem', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 134 OR LOWER(TRIM(name)) = 'meropenem');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 135, 'Imipenem + Cilastatin', 'Active generic pharmaceutical ingredient / formulation: Imipenem + Cilastatin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 135 OR LOWER(TRIM(name)) = 'imipenem + cilastatin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 136, 'Ispaghula + Lactitol', 'Active generic pharmaceutical ingredient / formulation: Ispaghula + Lactitol', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 136 OR LOWER(TRIM(name)) = 'ispaghula + lactitol');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 137, 'Teneligliptin', 'Active generic pharmaceutical ingredient / formulation: Teneligliptin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 137 OR LOWER(TRIM(name)) = 'teneligliptin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 138, 'Teneligliptin + Dapagliflozin', 'Active generic pharmaceutical ingredient / formulation: Teneligliptin + Dapagliflozin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 138 OR LOWER(TRIM(name)) = 'teneligliptin + dapagliflozin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 139, 'Teneligliptin + Dapagliflozin + Metformin', 'Active generic pharmaceutical ingredient / formulation: Teneligliptin + Dapagliflozin + Metformin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 139 OR LOWER(TRIM(name)) = 'teneligliptin + dapagliflozin + metformin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 140, 'Teneligliptin + Metformin', 'Active generic pharmaceutical ingredient / formulation: Teneligliptin + Metformin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 140 OR LOWER(TRIM(name)) = 'teneligliptin + metformin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 141, 'Amino Acid IV Infusion', 'Active generic pharmaceutical ingredient / formulation: Amino Acid IV Infusion', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 141 OR LOWER(TRIM(name)) = 'amino acid iv infusion');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 142, 'Specialized Hepatic Amino Acids', 'Active generic pharmaceutical ingredient / formulation: Specialized Hepatic Amino Acids', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 142 OR LOWER(TRIM(name)) = 'specialized hepatic amino acids');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 143, 'Diabetes-Specific Nutritional Supplement', 'Active generic pharmaceutical ingredient / formulation: Diabetes-Specific Nutritional Supplement', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 143 OR LOWER(TRIM(name)) = 'diabetes-specific nutritional supplement');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 144, 'GI Care Enteral Nutrition', 'Active generic pharmaceutical ingredient / formulation: GI Care Enteral Nutrition', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 144 OR LOWER(TRIM(name)) = 'gi care enteral nutrition');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 145, 'Hepatic Nutrition Supplement', 'Active generic pharmaceutical ingredient / formulation: Hepatic Nutrition Supplement', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 145 OR LOWER(TRIM(name)) = 'hepatic nutrition supplement');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 146, 'Drotaverine + Paracetamol', 'Active generic pharmaceutical ingredient / formulation: Drotaverine + Paracetamol', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 146 OR LOWER(TRIM(name)) = 'drotaverine + paracetamol');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 147, 'Oxidized Cellulose', 'Active generic pharmaceutical ingredient / formulation: Oxidized Cellulose', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 147 OR LOWER(TRIM(name)) = 'oxidized cellulose');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 148, 'n-Butyl Cyanoacrylate', 'Active generic pharmaceutical ingredient / formulation: n-Butyl Cyanoacrylate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 148 OR LOWER(TRIM(name)) = 'n-butyl cyanoacrylate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 149, 'Polypropylene Mesh', 'Active generic pharmaceutical ingredient / formulation: Polypropylene Mesh', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 149 OR LOWER(TRIM(name)) = 'polypropylene mesh');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 150, 'Ramosetron', 'Active generic pharmaceutical ingredient / formulation: Ramosetron', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 150 OR LOWER(TRIM(name)) = 'ramosetron');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 151, 'Surgical Suture / Hemostat', 'Active generic pharmaceutical ingredient / formulation: Surgical Suture / Hemostat', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 151 OR LOWER(TRIM(name)) = 'surgical suture / hemostat');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 152, 'Mebeverine', 'Active generic pharmaceutical ingredient / formulation: Mebeverine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 152 OR LOWER(TRIM(name)) = 'mebeverine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 153, 'Mebeverine + Chlordiazepoxide', 'Active generic pharmaceutical ingredient / formulation: Mebeverine + Chlordiazepoxide', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 153 OR LOWER(TRIM(name)) = 'mebeverine + chlordiazepoxide');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 154, 'Omega-3-Acid Ethyl Esters + Vitamin E', 'Active generic pharmaceutical ingredient / formulation: Omega-3-Acid Ethyl Esters + Vitamin E', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 154 OR LOWER(TRIM(name)) = 'omega-3-acid ethyl esters + vitamin e');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 155, 'Melatonin + L-Tryptophan + Peppermint Oil', 'Active generic pharmaceutical ingredient / formulation: Melatonin + L-Tryptophan + Peppermint Oil', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 155 OR LOWER(TRIM(name)) = 'melatonin + l-tryptophan + peppermint oil');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 156, 'Mesalamine', 'Active generic pharmaceutical ingredient / formulation: Mesalamine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 156 OR LOWER(TRIM(name)) = 'mesalamine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 157, 'Mirtazapine', 'Active generic pharmaceutical ingredient / formulation: Mirtazapine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 157 OR LOWER(TRIM(name)) = 'mirtazapine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 158, 'Bilastine + Montelukast', 'Active generic pharmaceutical ingredient / formulation: Bilastine + Montelukast', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 158 OR LOWER(TRIM(name)) = 'bilastine + montelukast');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 159, 'Montelukast + Levocetirizine', 'Active generic pharmaceutical ingredient / formulation: Montelukast + Levocetirizine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 159 OR LOWER(TRIM(name)) = 'montelukast + levocetirizine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 160, 'Multivitamins + Minerals + Antioxidants', 'Active generic pharmaceutical ingredient / formulation: Multivitamins + Minerals + Antioxidants', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 160 OR LOWER(TRIM(name)) = 'multivitamins + minerals + antioxidants');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 161, 'Silodosin', 'Active generic pharmaceutical ingredient / formulation: Silodosin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 161 OR LOWER(TRIM(name)) = 'silodosin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 162, 'Silodosin + Dutasteride', 'Active generic pharmaceutical ingredient / formulation: Silodosin + Dutasteride', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 162 OR LOWER(TRIM(name)) = 'silodosin + dutasteride');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 163, 'Colistimethate Sodium', 'Active generic pharmaceutical ingredient / formulation: Colistimethate Sodium', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 163 OR LOWER(TRIM(name)) = 'colistimethate sodium');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 164, 'N-Acetylcysteine', 'Active generic pharmaceutical ingredient / formulation: N-Acetylcysteine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 164 OR LOWER(TRIM(name)) = 'n-acetylcysteine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 165, 'Fluconazole', 'Active generic pharmaceutical ingredient / formulation: Fluconazole', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 165 OR LOWER(TRIM(name)) = 'fluconazole');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 166, 'GABA + L-Theanine + Magnesium', 'Active generic pharmaceutical ingredient / formulation: GABA + L-Theanine + Magnesium', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 166 OR LOWER(TRIM(name)) = 'gaba + l-theanine + magnesium');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 167, 'Myo-Inositol + D-Chiro Inositol', 'Active generic pharmaceutical ingredient / formulation: Myo-Inositol + D-Chiro Inositol', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 167 OR LOWER(TRIM(name)) = 'myo-inositol + d-chiro inositol');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 168, 'Nitrofurantoin', 'Active generic pharmaceutical ingredient / formulation: Nitrofurantoin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 168 OR LOWER(TRIM(name)) = 'nitrofurantoin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 169, 'Amoxicillin + Potassium Clavulanate', 'Active generic pharmaceutical ingredient / formulation: Amoxicillin + Potassium Clavulanate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 169 OR LOWER(TRIM(name)) = 'amoxicillin + potassium clavulanate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 170, 'Mecobalamin + Alpha Lipoic Acid + Folic Acid', 'Active generic pharmaceutical ingredient / formulation: Mecobalamin + Alpha Lipoic Acid + Folic Acid', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 170 OR LOWER(TRIM(name)) = 'mecobalamin + alpha lipoic acid + folic acid');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 171, 'Obeticholic Acid', 'Active generic pharmaceutical ingredient / formulation: Obeticholic Acid', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 171 OR LOWER(TRIM(name)) = 'obeticholic acid');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 172, 'Sodium Alginate + Magnesium Hydroxide + Simethicone', 'Active generic pharmaceutical ingredient / formulation: Sodium Alginate + Magnesium Hydroxide + Simethicone', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 172 OR LOWER(TRIM(name)) = 'sodium alginate + magnesium hydroxide + simethicone');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 173, 'Calcium + Magnesium + Zinc + Vitamin D3', 'Active generic pharmaceutical ingredient / formulation: Calcium + Magnesium + Zinc + Vitamin D3', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 173 OR LOWER(TRIM(name)) = 'calcium + magnesium + zinc + vitamin d3');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 174, 'Pantoprazole + Levosulpiride', 'Active generic pharmaceutical ingredient / formulation: Pantoprazole + Levosulpiride', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 174 OR LOWER(TRIM(name)) = 'pantoprazole + levosulpiride');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 175, 'Pantoprazole + Domperidone', 'Active generic pharmaceutical ingredient / formulation: Pantoprazole + Domperidone', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 175 OR LOWER(TRIM(name)) = 'pantoprazole + domperidone');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 176, 'Liquid Paraffin + Milk of Magnesia', 'Active generic pharmaceutical ingredient / formulation: Liquid Paraffin + Milk of Magnesia', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 176 OR LOWER(TRIM(name)) = 'liquid paraffin + milk of magnesia');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 177, 'Potassium Magnesium Citrate', 'Active generic pharmaceutical ingredient / formulation: Potassium Magnesium Citrate', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 177 OR LOWER(TRIM(name)) = 'potassium magnesium citrate');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 178, 'L-Carnitine + Vitamin E', 'Active generic pharmaceutical ingredient / formulation: L-Carnitine + Vitamin E', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 178 OR LOWER(TRIM(name)) = 'l-carnitine + vitamin e');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 179, 'L-Ornithine L-Aspartate + Glutathione', 'Active generic pharmaceutical ingredient / formulation: L-Ornithine L-Aspartate + Glutathione', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 179 OR LOWER(TRIM(name)) = 'l-ornithine l-aspartate + glutathione');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 180, 'Potassium Citrate + Magnesium Citrate + Vitamin B6', 'Active generic pharmaceutical ingredient / formulation: Potassium Citrate + Magnesium Citrate + Vitamin B6', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 180 OR LOWER(TRIM(name)) = 'potassium citrate + magnesium citrate + vitamin b6');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 181, 'Probiotics + L-Glutamine', 'Active generic pharmaceutical ingredient / formulation: Probiotics + L-Glutamine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 181 OR LOWER(TRIM(name)) = 'probiotics + l-glutamine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 182, 'Polypropylene', 'Active generic pharmaceutical ingredient / formulation: Polypropylene', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 182 OR LOWER(TRIM(name)) = 'polypropylene');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 183, 'Prucalopride', 'Active generic pharmaceutical ingredient / formulation: Prucalopride', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 183 OR LOWER(TRIM(name)) = 'prucalopride');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 184, 'Polydioxanone', 'Active generic pharmaceutical ingredient / formulation: Polydioxanone', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 184 OR LOWER(TRIM(name)) = 'polydioxanone');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 185, 'Digestive Enzymes', 'Active generic pharmaceutical ingredient / formulation: Digestive Enzymes', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 185 OR LOWER(TRIM(name)) = 'digestive enzymes');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 186, 'Rebamipide', 'Active generic pharmaceutical ingredient / formulation: Rebamipide', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 186 OR LOWER(TRIM(name)) = 'rebamipide');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 187, 'Collagen Peptide + Glucosamine + Rosehip', 'Active generic pharmaceutical ingredient / formulation: Collagen Peptide + Glucosamine + Rosehip', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 187 OR LOWER(TRIM(name)) = 'collagen peptide + glucosamine + rosehip');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 188, 'Palmitoylethanolamide + Alpha Lipoic Acid', 'Active generic pharmaceutical ingredient / formulation: Palmitoylethanolamide + Alpha Lipoic Acid', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 188 OR LOWER(TRIM(name)) = 'palmitoylethanolamide + alpha lipoic acid');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 189, 'Clinical Nutrition Formula for IBD', 'Active generic pharmaceutical ingredient / formulation: Clinical Nutrition Formula for IBD', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 189 OR LOWER(TRIM(name)) = 'clinical nutrition formula for ibd');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 190, 'Peptide-Based Enteral Nutrition', 'Active generic pharmaceutical ingredient / formulation: Peptide-Based Enteral Nutrition', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 190 OR LOWER(TRIM(name)) = 'peptide-based enteral nutrition');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 191, 'Rosuvastatin', 'Active generic pharmaceutical ingredient / formulation: Rosuvastatin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 191 OR LOWER(TRIM(name)) = 'rosuvastatin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 192, 'Ceftriaxone + Sulbactam', 'Active generic pharmaceutical ingredient / formulation: Ceftriaxone + Sulbactam', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 192 OR LOWER(TRIM(name)) = 'ceftriaxone + sulbactam');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 193, 'Ceftriaxone', 'Active generic pharmaceutical ingredient / formulation: Ceftriaxone', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 193 OR LOWER(TRIM(name)) = 'ceftriaxone');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 194, 'Amlodipine', 'Active generic pharmaceutical ingredient / formulation: Amlodipine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 194 OR LOWER(TRIM(name)) = 'amlodipine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 195, 'Ursodeoxycholic Acid', 'Active generic pharmaceutical ingredient / formulation: Ursodeoxycholic Acid', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 195 OR LOWER(TRIM(name)) = 'ursodeoxycholic acid');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 196, 'Lactitol + Ispaghula Husk', 'Active generic pharmaceutical ingredient / formulation: Lactitol + Ispaghula Husk', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 196 OR LOWER(TRIM(name)) = 'lactitol + ispaghula husk');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 197, 'Solifenacin', 'Active generic pharmaceutical ingredient / formulation: Solifenacin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 197 OR LOWER(TRIM(name)) = 'solifenacin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 198, 'Sucralfate + Oxetacaine', 'Active generic pharmaceutical ingredient / formulation: Sucralfate + Oxetacaine', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 198 OR LOWER(TRIM(name)) = 'sucralfate + oxetacaine');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 199, 'Cefoperazone + Sulbactam', 'Active generic pharmaceutical ingredient / formulation: Cefoperazone + Sulbactam', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 199 OR LOWER(TRIM(name)) = 'cefoperazone + sulbactam');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 200, 'Saccharomyces boulardii', 'Active generic pharmaceutical ingredient / formulation: Saccharomyces boulardii', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 200 OR LOWER(TRIM(name)) = 'saccharomyces boulardii');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 201, 'Tadalafil', 'Active generic pharmaceutical ingredient / formulation: Tadalafil', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 201 OR LOWER(TRIM(name)) = 'tadalafil');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 202, 'Tamsulosin + Dutasteride', 'Active generic pharmaceutical ingredient / formulation: Tamsulosin + Dutasteride', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 202 OR LOWER(TRIM(name)) = 'tamsulosin + dutasteride');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 203, 'Piperacillin + Tazobactam', 'Active generic pharmaceutical ingredient / formulation: Piperacillin + Tazobactam', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 203 OR LOWER(TRIM(name)) = 'piperacillin + tazobactam');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 204, 'Teicoplanin', 'Active generic pharmaceutical ingredient / formulation: Teicoplanin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 204 OR LOWER(TRIM(name)) = 'teicoplanin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 205, 'Telmisartan', 'Active generic pharmaceutical ingredient / formulation: Telmisartan', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 205 OR LOWER(TRIM(name)) = 'telmisartan');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 206, 'Telmisartan + Chlorthalidone', 'Active generic pharmaceutical ingredient / formulation: Telmisartan + Chlorthalidone', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 206 OR LOWER(TRIM(name)) = 'telmisartan + chlorthalidone');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 207, 'Alpha Lipoic Acid + Methylcobalamin', 'Active generic pharmaceutical ingredient / formulation: Alpha Lipoic Acid + Methylcobalamin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 207 OR LOWER(TRIM(name)) = 'alpha lipoic acid + methylcobalamin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 208, 'Tocotrienols + Natural Vitamin E', 'Active generic pharmaceutical ingredient / formulation: Tocotrienols + Natural Vitamin E', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 208 OR LOWER(TRIM(name)) = 'tocotrienols + natural vitamin e');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 209, 'Tofacitinib', 'Active generic pharmaceutical ingredient / formulation: Tofacitinib', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 209 OR LOWER(TRIM(name)) = 'tofacitinib');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 210, 'Terlipressin', 'Active generic pharmaceutical ingredient / formulation: Terlipressin', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 210 OR LOWER(TRIM(name)) = 'terlipressin');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 211, 'L-Glutathione + Vitamin C', 'Active generic pharmaceutical ingredient / formulation: L-Glutathione + Vitamin C', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 211 OR LOWER(TRIM(name)) = 'l-glutathione + vitamin c');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 212, 'Tamsulosin + Tadalafil', 'Active generic pharmaceutical ingredient / formulation: Tamsulosin + Tadalafil', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 212 OR LOWER(TRIM(name)) = 'tamsulosin + tadalafil');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 213, 'Potassium Magnesium Citrate + D-Mannose + Cranberry', 'Active generic pharmaceutical ingredient / formulation: Potassium Magnesium Citrate + D-Mannose + Cranberry', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 213 OR LOWER(TRIM(name)) = 'potassium magnesium citrate + d-mannose + cranberry');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 214, 'Potassium Magnesium Citrate + Cranberry', 'Active generic pharmaceutical ingredient / formulation: Potassium Magnesium Citrate + Cranberry', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 214 OR LOWER(TRIM(name)) = 'potassium magnesium citrate + cranberry');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 215, 'Vonoprazan', 'Active generic pharmaceutical ingredient / formulation: Vonoprazan', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 215 OR LOWER(TRIM(name)) = 'vonoprazan');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 216, 'Whey Protein + Multivitamins', 'Active generic pharmaceutical ingredient / formulation: Whey Protein + Multivitamins', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 216 OR LOWER(TRIM(name)) = 'whey protein + multivitamins');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 217, 'High Protein Supplement', 'Active generic pharmaceutical ingredient / formulation: High Protein Supplement', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 217 OR LOWER(TRIM(name)) = 'high protein supplement');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 218, 'Protein + Micronutrients', 'Active generic pharmaceutical ingredient / formulation: Protein + Micronutrients', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 218 OR LOWER(TRIM(name)) = 'protein + micronutrients');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 219, 'Hydrolyzed Whey Peptides', 'Active generic pharmaceutical ingredient / formulation: Hydrolyzed Whey Peptides', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 219 OR LOWER(TRIM(name)) = 'hydrolyzed whey peptides');
INSERT INTO salts (id, name, description, created_at, updated_at) SELECT 220, 'Doxycycline', 'Active generic pharmaceutical ingredient / formulation: Doxycycline', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM salts WHERE id = 220 OR LOWER(TRIM(name)) = 'doxycycline');

-- Product Updates
UPDATE products SET salt_id = 11, composition = 'Branched Chain Amino Acids (L-Leucine, L-Isoleucine, L-Valine) with Micronutrients', updated_at = NOW() WHERE id = 27; -- *BCCA PLUS
UPDATE products SET salt_id = 12, composition = 'Cefuroxime Axetil 500 mg Tablet', updated_at = NOW() WHERE id = 28; -- *CIRETA
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (COLOWIPE NEO)', updated_at = NOW() WHERE id = 29; -- *COLOWIPE NEO
UPDATE products SET salt_id = 14, composition = 'Esomeprazole Sodium 40 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 30; -- *ESOGRESS HP FORT
UPDATE products SET salt_id = 14, composition = 'Esomeprazole Sodium 40 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 31; -- *ESOGRESS HP KIT
UPDATE products SET salt_id = 15, composition = 'Pre-operative & Post-operative Carbohydrate, Electrolyte & Amino Acid Drink', updated_at = NOW() WHERE id = 32; -- *FULLYTE TRIO
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (HEPANICHE)', updated_at = NOW() WHERE id = 33; -- *HEPANICHE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KETRIP-10)', updated_at = NOW() WHERE id = 34; -- *KETRIP-10
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LAMINO 10 %)', updated_at = NOW() WHERE id = 35; -- *LAMINO 10 %
UPDATE products SET salt_id = 16, composition = 'Sodium Alginate 250 mg + Sodium Bicarbonate 133.5 mg + Calcium Carbonate 80 mg Oral Suspension', updated_at = NOW() WHERE id = 36; -- *MAHARAFT
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MESHAHENZ 400)', updated_at = NOW() WHERE id = 37; -- *MESHAHENZ 400
UPDATE products SET salt_id = 17, composition = 'Esomeprazole Magnesium Trihydrate 40 mg + Domperidone 30 mg SR Capsule', updated_at = NOW() WHERE id = 38; -- *NEXBOOK RD
UPDATE products SET salt_id = 18, composition = 'Pantoprazole Sodium 40 mg IV Injection', updated_at = NOW() WHERE id = 39; -- *PANSEC IV
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SEDOGEST -300)', updated_at = NOW() WHERE id = 40; -- *SEDOGEST -300
UPDATE products SET salt_id = 19, composition = 'Ubiquinol (CoQ10) 100 mg + L-Carnitine + Lycopene + Zinc + Astaxanthin Tablet', updated_at = NOW() WHERE id = 41; -- *SPERMIZZ
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (THIOTRESS TAB)', updated_at = NOW() WHERE id = 42; -- *THIOTRESS TAB
UPDATE products SET salt_id = 20, composition = 'Dextrose 5% w/v Intravenous Infusion FFS Pack', updated_at = NOW() WHERE id = 43; -- 5% DEX FFS (SPPL)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Suture Material (AB2347 NETSORB 1 90CM)', updated_at = NOW() WHERE id = 44; -- AB2347 NETSORB 1 90CM
UPDATE products SET salt_id = 22, composition = 'Drotaverine Hydrochloride 80 mg + Aceclofenac 100 mg Tablet', updated_at = NOW() WHERE id = 45; -- ABDOCARE TAB
UPDATE products SET salt_id = 23, composition = 'Acebrophylline 200 mg Sustained Release Tablet', updated_at = NOW() WHERE id = 46; -- ABROLONG SR 200
UPDATE products SET salt_id = 24, composition = 'Acebrophylline 100 mg + N-Acetylcysteine 600 mg Tablet', updated_at = NOW() WHERE id = 47; -- ABROLONG-N
UPDATE products SET salt_id = 25, composition = 'Aceclofenac 100 mg + Paracetamol 325 mg + Serratiopeptidase 15 mg Tablet', updated_at = NOW() WHERE id = 48; -- ACECLIFF-SP
UPDATE products SET salt_id = 26, composition = 'Aceclofenac 100 mg + Paracetamol 325 mg Tablet', updated_at = NOW() WHERE id = 49; -- ACETODOL NR TAB
UPDATE products SET salt_id = 26, composition = 'Aceclofenac 100 mg + Paracetamol 325 mg Tablet', updated_at = NOW() WHERE id = 50; -- ACETODOL TABLET
UPDATE products SET salt_id = 27, composition = 'Acotiamide Hydrochloride Hydrate 300 mg Sustained Release Tablet', updated_at = NOW() WHERE id = 51; -- ACOCARE 300 SR TAB
UPDATE products SET salt_id = 27, composition = 'Acotiamide Hydrochloride Hydrate 100 mg Tablet', updated_at = NOW() WHERE id = 52; -- ACOFORGE TAB
UPDATE products SET salt_id = 27, composition = 'Acotiamide Hydrochloride 100 mg Tablet', updated_at = NOW() WHERE id = 53; -- ACOTIBIEN 100
UPDATE products SET salt_id = 27, composition = 'Acotiamide Hydrochloride Hydrate 300 mg Extended Release Tablet', updated_at = NOW() WHERE id = 54; -- ACOTIBIEN-300 ER
UPDATE products SET salt_id = 28, composition = 'Antioxidants, Essential Multivitamins & Trace Minerals Tablet', updated_at = NOW() WHERE id = 55; -- ACTIVA TAB.(F/P)
UPDATE products SET salt_id = 29, composition = 'Skin Rejuvenating Face Wash with Kojic Acid, Glycolic Acid & Vitamin C', updated_at = NOW() WHERE id = 56; -- ADVANCED WOWGLO FACE WASH
UPDATE products SET salt_id = 30, composition = 'Rifampicin 150 mg + Isoniazid 75 mg + Pyrazinamide 400 mg + Ethambutol 275 mg', updated_at = NOW() WHERE id = 57; -- AKURIT-4 TAB
UPDATE products SET salt_id = 31, composition = 'Midodrine Hydrochloride 5 mg Tablet', updated_at = NOW() WHERE id = 58; -- ALADRINE 5MG TAB
UPDATE products SET salt_id = 32, composition = 'Albendazole 400 mg Chewable Tablet', updated_at = NOW() WHERE id = 59; -- ALBENDAZOL:400MG(TAB)
UPDATE products SET salt_id = 33, composition = 'Specialized Nutritional BCAA Protein Powder for Hepatic Wellness 400 gm', updated_at = NOW() WHERE id = 60; -- ALBUZEST HEPA POWDER 400 GM
UPDATE products SET salt_id = 34, composition = 'Metadoxine 500 mg + Silymarin 140 mg + L-Ornithine L-Aspartate 150 mg + Folic Acid & Pyridoxine Tablet', updated_at = NOW() WHERE id = 61; -- ALCOFIX GOLD TAB
UPDATE products SET salt_id = 35, composition = 'L-Ornithine L-Aspartate Infusion with Multivitamin Injection Combi Kit', updated_at = NOW() WHERE id = 62; -- ALCOFIX-IV KIT
UPDATE products SET salt_id = 34, composition = 'Metadoxine 500 mg + Silymarin 140 mg + L-Ornithine L-Aspartate 150 mg + Folic Acid & Pyridoxine', updated_at = NOW() WHERE id = 63; -- ALCOTRUST
UPDATE products SET salt_id = 36, composition = 'Vitamin A, Vitamin D3, Vitamin E & Vitamin K1 with Zinc & Selenium Tablet', updated_at = NOW() WHERE id = 64; -- ALDEKA TAB
UPDATE products SET salt_id = 37, composition = 'Levosulpiride 25 mg Tablet', updated_at = NOW() WHERE id = 65; -- ALFAPRIDE-25 TAB
UPDATE products SET salt_id = 38, composition = 'Alfuzosin Hydrochloride 10 mg Prolonged Release Tablet', updated_at = NOW() WHERE id = 66; -- ALFUGRESS
UPDATE products SET salt_id = 39, composition = 'Alfuzosin Hydrochloride 10 mg PR + Dutasteride 0.5 mg Tablet', updated_at = NOW() WHERE id = 67; -- ALFUGRESS-D
UPDATE products SET salt_id = 38, composition = 'Alfuzosin Hydrochloride 10 mg Prolonged Release Tablet', updated_at = NOW() WHERE id = 68; -- ALFUTRAK-10
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ALINOL-10MG TAB)', updated_at = NOW() WHERE id = 69; -- ALINOL-10MG TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ALINOL-20MG)', updated_at = NOW() WHERE id = 70; -- ALINOL-20MG
UPDATE products SET salt_id = 40, composition = 'Alprazolam 0.25 mg / 0.5 mg Tablet', updated_at = NOW() WHERE id = 71; -- ALP 0.25 TAB
UPDATE products SET salt_id = 40, composition = 'Alprazolam 0.25 mg / 0.5 mg Tablet', updated_at = NOW() WHERE id = 72; -- ALP 0.5 TAB
UPDATE products SET salt_id = 41, composition = 'Ademetionine (S-Adenosyl L-Methionine) 400 mg Enteric Coated Tablet', updated_at = NOW() WHERE id = 73; -- ALSAME TAB
UPDATE products SET salt_id = 42, composition = 'Amitriptyline Hydrochloride 10 mg Film Coated Tablet', updated_at = NOW() WHERE id = 74; -- AMFORGE 10 MG
UPDATE products SET salt_id = 42, composition = 'Amitriptyline Hydrochloride 25 mg Film Coated Tablet', updated_at = NOW() WHERE id = 75; -- AMFORGE 25 MG
UPDATE products SET salt_id = 43, composition = 'Amikacin Sulphate 500 mg / 2 ml Injection', updated_at = NOW() WHERE id = 76; -- AMIJECT NOVO 500 (2ML)
UPDATE products SET salt_id = 44, composition = 'Essential Amino Acids enriched with Albumin & Antioxidants', updated_at = NOW() WHERE id = 77; -- AMINOZEN ALBU
UPDATE products SET salt_id = 42, composition = 'Amitriptyline Hydrochloride 10 mg / 25 mg Tablet', updated_at = NOW() WHERE id = 78; -- AMITWIX 10 TAN
UPDATE products SET salt_id = 42, composition = 'Amitriptyline Hydrochloride 10 mg / 25 mg Tablet', updated_at = NOW() WHERE id = 79; -- AMITWIX 25
UPDATE products SET salt_id = 45, composition = 'Amitriptyline Hydrochloride 12.5 mg + Chlordiazepoxide 5 mg Tablet', updated_at = NOW() WHERE id = 80; -- AMPAUSE TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ANANDA GB)', updated_at = NOW() WHERE id = 81; -- ANANDA GB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ANANDA GB-100 TAB)', updated_at = NOW() WHERE id = 82; -- ANANDA GB-100 TAB
UPDATE products SET salt_id = 46, composition = 'Flupentixol 0.5 mg + Melitracen 10 mg Tablet', updated_at = NOW() WHERE id = 83; -- ANXIMEL-FM TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (APTIBOOST TAB)', updated_at = NOW() WHERE id = 84; -- APTIBOOST TAB
UPDATE products SET salt_id = 47, composition = 'Cephalosporin Antibiotic Formulation', updated_at = NOW() WHERE id = 85; -- APTOCEF PLUS TAB
UPDATE products SET salt_id = 47, composition = 'Cephalosporin Antibiotic Formulation', updated_at = NOW() WHERE id = 86; -- APTOCEF-500 TAB
UPDATE products SET salt_id = 48, composition = 'Tamsulosin Hydrochloride 0.4 mg Prolonged Release Capsule', updated_at = NOW() WHERE id = 87; -- AQUATAM TAB
UPDATE products SET salt_id = 48, composition = 'Tamsulosin Hydrochloride 0.4 mg Prolonged Release Capsule', updated_at = NOW() WHERE id = 88; -- AQUATAM-D TAB
UPDATE products SET salt_id = 48, composition = 'Tamsulosin Hydrochloride 0.4 mg Prolonged Release Capsule', updated_at = NOW() WHERE id = 89; -- AQUATAM-DF TAB
UPDATE products SET salt_id = 49, composition = 'L-Arginine 3 gm + Proanthocyanidins 75 mg + Zinc Sachet', updated_at = NOW() WHERE id = 90; -- ARGIBUILD
UPDATE products SET salt_id = 50, composition = 'L-Arginine 3 gm + Proanthocyanidins 75 mg + Zinc Effervescent Tablet', updated_at = NOW() WHERE id = 91; -- ARGIFIZZ-10''S
UPDATE products SET salt_id = 4, composition = 'Atorvastatin Calcium 10 mg / 20 mg Tablet', updated_at = NOW() WHERE id = 92; -- ASTAWIN 10 MG
UPDATE products SET salt_id = 4, composition = 'Atorvastatin Calcium 10 mg / 20 mg Tablet', updated_at = NOW() WHERE id = 93; -- ATORTS-10 TAB
UPDATE products SET salt_id = 4, composition = 'Atorvastatin Calcium 10 mg / 20 mg Tablet', updated_at = NOW() WHERE id = 94; -- ATORTS-20 TAB
UPDATE products SET salt_id = 8, composition = 'Azithromycin 500 mg Tablet', updated_at = NOW() WHERE id = 95; -- ATRAL-500 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (AURINORM-D)', updated_at = NOW() WHERE id = 96; -- AURINORM-D
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (AXON-GOLD CAP)', updated_at = NOW() WHERE id = 97; -- AXON-GOLD CAP
UPDATE products SET salt_id = 12, composition = 'Cefuroxime Axetil 500 mg Film Coated Tablet', updated_at = NOW() WHERE id = 98; -- AYEBAC
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (AZEDRA PLUS)', updated_at = NOW() WHERE id = 99; -- AZEDRA PLUS
UPDATE products SET salt_id = 8, composition = 'Azithromycin 500 mg Tablet', updated_at = NOW() WHERE id = 100; -- AZICLIFF 500
UPDATE products SET salt_id = 8, composition = 'Azithromycin 500 mg Tablet', updated_at = NOW() WHERE id = 101; -- AZICLIFF-250
UPDATE products SET salt_id = 8, composition = 'Azithromycin 100 mg / 5 ml Extended Release Oral Suspension', updated_at = NOW() WHERE id = 102; -- AZILIN XL 100
UPDATE products SET salt_id = 8, composition = 'Azithromycin 200 mg / 5 ml Extended Release Oral Suspension', updated_at = NOW() WHERE id = 103; -- AZILIN XL 200
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (AZOTUS-50)', updated_at = NOW() WHERE id = 104; -- AZOTUS-50
UPDATE products SET salt_id = 51, composition = 'Biotin 10 mg + Amino Acids + Vitamins & Minerals Capsule', updated_at = NOW() WHERE id = 105; -- BAAYOTA CAP
UPDATE products SET salt_id = 52, composition = 'Cefpodoxime Proxetil 200 mg + Potassium Clavulanate 125 mg Tablet', updated_at = NOW() WHERE id = 106; -- BACTIPOD-CV TAB
UPDATE products SET salt_id = 53, composition = 'Bezafibrate 200 mg Tablet', updated_at = NOW() WHERE id = 107; -- BENIZEP
UPDATE products SET salt_id = 53, composition = 'Bezafibrate 200 mg Sustained Release Tablet', updated_at = NOW() WHERE id = 108; -- BENIZEP SR 200
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (BENJAMIN CAP)', updated_at = NOW() WHERE id = 109; -- BENJAMIN CAP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (BEPHER TAB)', updated_at = NOW() WHERE id = 110; -- BEPHER TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (BESTPAM LITE)', updated_at = NOW() WHERE id = 111; -- BESTPAM LITE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (BESTPAM PLUS)', updated_at = NOW() WHERE id = 112; -- BESTPAM PLUS
UPDATE products SET salt_id = 54, composition = 'Vitamin A, Vitamin D3, Vitamin E, Vitamin K1, Zinc & Beta-Carotene Tablet', updated_at = NOW() WHERE id = 113; -- BETADEK TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (BILABOSS-M TAB)', updated_at = NOW() WHERE id = 114; -- BILABOSS-M TAB
UPDATE products SET salt_id = 55, composition = 'Oral Pharmaceutical Liquid Formulation', updated_at = NOW() WHERE id = 115; -- BIOLAXIT PLUS SYP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (BIOLAXIT POW)', updated_at = NOW() WHERE id = 116; -- BIOLAXIT POW
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (BIOTEE FORTE)', updated_at = NOW() WHERE id = 117; -- BIOTEE FORTE
UPDATE products SET salt_id = 56, composition = 'Biotin 10 mg + Calcium Pantothenate + Zinc Sulphate & Amino Acids Tablet', updated_at = NOW() WHERE id = 118; -- BIOTIMA PLUS TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (BIOXIDE-H)', updated_at = NOW() WHERE id = 119; -- BIOXIDE-H
UPDATE products SET salt_id = 57, composition = 'Colloidal Bismuth Subcitrate 120 mg Tablet', updated_at = NOW() WHERE id = 120; -- BISTAS 120 MG TAB 8S
UPDATE products SET salt_id = 58, composition = 'Cefixime 200 mg + Moxifloxacin 400 mg Tablet', updated_at = NOW() WHERE id = 121; -- BIXIMOT
UPDATE products SET salt_id = 59, composition = 'Refined White Beeswax, Hard Paraffin & Isopropyl Palmitate (Surgical Bone Wax)', updated_at = NOW() WHERE id = 122; -- BONE MAX LM810 (N)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (BOROX)', updated_at = NOW() WHERE id = 123; -- BOROX
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (BOROX-M)', updated_at = NOW() WHERE id = 124; -- BOROX-M
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 800 IU / ml Oral Drops / Syrup', updated_at = NOW() WHERE id = 125; -- BRAVE-3 SYP
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 60,000 IU Chewable Tablet', updated_at = NOW() WHERE id = 126; -- BRAVE-3 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (C-BUCKTHORN)', updated_at = NOW() WHERE id = 127; -- C-Buckthorn
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (C-BUCKTHORN TABLET)', updated_at = NOW() WHERE id = 128; -- C-BUCKTHORN TABLET
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CABEROLINE:0.5M)', updated_at = NOW() WHERE id = 129; -- CABEROLINE:0.5M
UPDATE products SET salt_id = 61, composition = 'Calcium Carbonate with Vitamin D3 & Minerals Tablet', updated_at = NOW() WHERE id = 130; -- CALCIRAY PLUS TABLET
UPDATE products SET salt_id = 61, composition = 'Calcium Carbonate with Vitamin D3 & Minerals Tablet', updated_at = NOW() WHERE id = 131; -- CALCIRAY SYRUP 200ML
UPDATE products SET salt_id = 61, composition = 'Calcium Carbonate with Vitamin D3 & Minerals Tablet', updated_at = NOW() WHERE id = 132; -- CALCIRAY-D TABLET
UPDATE products SET salt_id = 61, composition = 'Calcium Carbonate with Vitamin D3 & Minerals Tablet', updated_at = NOW() WHERE id = 133; -- CALDIZEN-K2
UPDATE products SET salt_id = 61, composition = 'Calcium Carbonate with Vitamin D3 & Minerals Tablet', updated_at = NOW() WHERE id = 134; -- CALSIKA TAB
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 60,000 IU Oral Formulation', updated_at = NOW() WHERE id = 135; -- CAP RAPIMAX-MD3
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CARESTREAM DENTAL X-RAY FILM)', updated_at = NOW() WHERE id = 136; -- CARESTREAM DENTAL X-RAY FILM
UPDATE products SET salt_id = 62, composition = 'Carica Papaya Leaf Extract 1100 mg Tablet', updated_at = NOW() WHERE id = 137; -- CARIPAPA
UPDATE products SET salt_id = 63, composition = 'L-Carnitine L-Tartrate 500 mg + Coenzyme Q10 100 mg + Zinc Effervescent Tablet', updated_at = NOW() WHERE id = 138; -- CARNIFIZZ
UPDATE products SET salt_id = 64, composition = 'Carvedilol 6.25 mg Tablet', updated_at = NOW() WHERE id = 139; -- CARVIRX 6.25
UPDATE products SET salt_id = 64, composition = 'Carvedilol 3.125 mg Tablet', updated_at = NOW() WHERE id = 140; -- CARVIRX-3.125 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CB-TOR)', updated_at = NOW() WHERE id = 141; -- CB-TOR
UPDATE products SET salt_id = 25, composition = 'Aceclofenac 100 mg + Paracetamol 325 mg + Serratiopeptidase 15 mg Tablet', updated_at = NOW() WHERE id = 142; -- CECLODAY-ED
UPDATE products SET salt_id = 47, composition = 'Cephalosporin Antibiotic Formulation', updated_at = NOW() WHERE id = 143; -- CEFIMAC-O
UPDATE products SET salt_id = 47, composition = 'Cephalosporin Antibiotic Formulation', updated_at = NOW() WHERE id = 144; -- CEFUROLEN 500
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CERETOR FORT)', updated_at = NOW() WHERE id = 145; -- CERETOR FORT
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CERETOR PLUS TAB)', updated_at = NOW() WHERE id = 146; -- CERETOR PLUS TAB
UPDATE products SET salt_id = 65, composition = 'Essential Vitamins, Minerals & Trace Elements Capsule', updated_at = NOW() WHERE id = 147; -- CERTAMIN
UPDATE products SET salt_id = 66, composition = 'Cefuroxime Sodium 1.5 gm IV/IM Injection', updated_at = NOW() WHERE id = 148; -- CETIL 1.5GM
UPDATE products SET salt_id = 12, composition = 'Cefuroxime Axetil 500 mg Film Coated Tablet', updated_at = NOW() WHERE id = 149; -- CETIL-500 TAB
UPDATE products SET salt_id = 67, composition = 'Cefuroxime Axetil 500 mg + Potassium Clavulanate 125 mg Tablet', updated_at = NOW() WHERE id = 150; -- CETIL-CV 500MG TAB
UPDATE products SET salt_id = 68, composition = 'N-Acetylcysteine 600 mg + Vitamin C 40 mg Effervescent Tablet', updated_at = NOW() WHERE id = 151; -- CFIZZ-NAC
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CINLOX-200)', updated_at = NOW() WHERE id = 152; -- CINLOX-200
UPDATE products SET salt_id = 47, composition = 'Cephalosporin Antibiotic Formulation', updated_at = NOW() WHERE id = 153; -- CIOCEF-S 1.5gm
UPDATE products SET salt_id = 69, composition = 'Protein Powder 200 gm with Micronutrients & Antioxidants', updated_at = NOW() WHERE id = 154; -- CIPLUNG 200 GM
UPDATE products SET salt_id = 12, composition = 'Cefuroxime Axetil 500 mg Tablet', updated_at = NOW() WHERE id = 155; -- CIRETA
UPDATE products SET salt_id = 41, composition = 'Ademetionine (S-Adenosyl L-Methionine) 400 mg Enteric Coated Tablet', updated_at = NOW() WHERE id = 156; -- CIRROSAM-400
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CISSRAY TABLET)', updated_at = NOW() WHERE id = 157; -- CISSRAY TABLET
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CLAVTYX-625  TAB)', updated_at = NOW() WHERE id = 158; -- CLAVTYX-625  TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CLINSURE)', updated_at = NOW() WHERE id = 159; -- CLINSURE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CLOTWEET-MD .25)', updated_at = NOW() WHERE id = 160; -- CLOTWEET-MD .25
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CLOTWEET-MD .5)', updated_at = NOW() WHERE id = 161; -- CLOTWEET-MD .5
UPDATE products SET salt_id = 70, composition = 'Clonazepam 0.5 mg Mouth Dissolving Tablet', updated_at = NOW() WHERE id = 162; -- CLOZE 0.50 (NRX) (DPCO)
UPDATE products SET salt_id = 70, composition = 'Clonazepam 0.5 mg Mouth Dissolving Tablet', updated_at = NOW() WHERE id = 163; -- CLOZE MD 0.25 (NRX)
UPDATE products SET salt_id = 70, composition = 'Clonazepam 0.5 mg Mouth Dissolving Tablet', updated_at = NOW() WHERE id = 164; -- CLOZE MD 0.50 (NRX)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (COCID D)', updated_at = NOW() WHERE id = 165; -- COCID D
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (COCID-DSR)', updated_at = NOW() WHERE id = 166; -- COCID-DSR
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (COFIBER)', updated_at = NOW() WHERE id = 167; -- COFIBER
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 60,000 IU Nano Shots Oral Solution 5 ml', updated_at = NOW() WHERE id = 168; -- COLEBRITE D3 NANO SHOTS
UPDATE products SET salt_id = 71, composition = 'Liquid Paraffin 1.25 ml + Milk of Magnesia 3.75 ml + Sodium Picosulfate 3.33 mg / 5 ml Suspension', updated_at = NOW() WHERE id = 169; -- COLOWAX SUSPENSION
UPDATE products SET salt_id = 72, composition = 'Polyethylene Glycol 3350 with Electrolytes Bowel Cleansing Solution', updated_at = NOW() WHERE id = 170; -- COLOWIPE-NEO
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CONASILA-200 TAB)', updated_at = NOW() WHERE id = 171; -- CONASILA-200 TAB
UPDATE products SET salt_id = 72, composition = 'Polyethylene Glycol 3350 with Electrolytes Sachet', updated_at = NOW() WHERE id = 172; -- CONSTICHECK SAC
UPDATE products SET salt_id = 72, composition = 'Polyethylene Glycol 3350 with Electrolytes Oral Solution', updated_at = NOW() WHERE id = 173; -- CONSTICHEK
UPDATE products SET salt_id = 73, composition = 'Carbonyl Iron 50 mg + Folic Acid 0.5 mg + Vitamin B12 + Zinc Sulphate Capsule', updated_at = NOW() WHERE id = 174; -- COPIA CAPS
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (COQZEN GOLD TAB)', updated_at = NOW() WHERE id = 175; -- COQZEN GOLD TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (COQZEN-LC TAB)', updated_at = NOW() WHERE id = 176; -- COQZEN-LC TAB
UPDATE products SET salt_id = 74, composition = 'Calcium Carbonate 1250 mg + Vitamin D3 2000 IU + Vitamin K2-7 50 mcg + Minerals', updated_at = NOW() WHERE id = 177; -- CORCIUM FIT TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CORTYX 6 TAB)', updated_at = NOW() WHERE id = 178; -- CORTYX 6 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (COSIFEX 400)', updated_at = NOW() WHERE id = 179; -- COSIFEX 400
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (COSIFEX 550)', updated_at = NOW() WHERE id = 180; -- COSIFEX 550
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (COURIER CHARGE)', updated_at = NOW() WHERE id = 181; -- COURIER CHARGE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (COXITO-S 10TAB)', updated_at = NOW() WHERE id = 182; -- COXITO-S 10TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (COXITO-S 5TAB)', updated_at = NOW() WHERE id = 183; -- COXITO-S 5TAB
UPDATE products SET salt_id = 75, composition = 'Pregabalin 75 mg + Methylcobalamin 750 mcg Capsule', updated_at = NOW() WHERE id = 184; -- CRAMPAUSE
UPDATE products SET salt_id = 76, composition = 'Pregabalin 75 mg + Methylcobalamin 1500 mcg + Nortriptyline 10 mg Tablet', updated_at = NOW() WHERE id = 185; -- CRAMPAUSE PLUS
UPDATE products SET salt_id = 77, composition = 'Pancreatin (Enteric Coated Pellets) 10,000 USP Units (Lipase, Amylase, Protease) Capsule', updated_at = NOW() WHERE id = 186; -- CREAPASE-10000
UPDATE products SET salt_id = 78, composition = 'DL-Methionine 667 mg, Vitamin A, Vitamin C, Vitamin E, Zinc & Selenium Capsule', updated_at = NOW() WHERE id = 187; -- CREASET GOLD CAP
UPDATE products SET salt_id = 72, composition = 'Polyethylene Glycol 3350 USP 17 gm / dose Oral Solution', updated_at = NOW() WHERE id = 188; -- CREMAPAG SYP
UPDATE products SET salt_id = 72, composition = 'Polyethylene Glycol 3350 USP Oral Powder Solution', updated_at = NOW() WHERE id = 189; -- CREMAPEG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CRESIUM PLUS TAB)', updated_at = NOW() WHERE id = 190; -- CRESIUM PLUS TAB
UPDATE products SET salt_id = 79, composition = 'Organic Selenium, Vitamin C, Beta-Carotene, DL-Methionine, Zinc & Manganese Tablet', updated_at = NOW() WHERE id = 191; -- CRETOX-CP TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CREZYME TAB)', updated_at = NOW() WHERE id = 192; -- CREZYME TAB
UPDATE products SET salt_id = 77, composition = 'Pancreatin 25,000 USP Units Enteric Coated Pellets Capsule', updated_at = NOW() WHERE id = 193; -- CRITIZYME
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CRYPTOVA-1500)', updated_at = NOW() WHERE id = 194; -- CRYPTOVA-1500
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CTPC-500 TAB)', updated_at = NOW() WHERE id = 195; -- CTPC-500 TAB
UPDATE products SET salt_id = 80, composition = 'Vitamin E (Tocopheryl Acetate) 400 IU Capsule', updated_at = NOW() WHERE id = 196; -- CUTEE 400
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CYLNIDA-10 TAB)', updated_at = NOW() WHERE id = 197; -- CYLNIDA-10 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CYLNIDA-5 TAB)', updated_at = NOW() WHERE id = 198; -- CYLNIDA-5 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (CYP APP TAB)', updated_at = NOW() WHERE id = 199; -- CYP APP TAB
UPDATE products SET salt_id = 55, composition = 'Oral Pharmaceutical Liquid Formulation', updated_at = NOW() WHERE id = 200; -- CYPTAN SYP
UPDATE products SET salt_id = 81, composition = 'Cyproheptadine Hydrochloride 2 mg + Tricholine Citrate 275 mg / 5 ml Syrup', updated_at = NOW() WHERE id = 201; -- CYPWALL
UPDATE products SET salt_id = 20, composition = 'Dextrose 5% w/v Intravenous Infusion', updated_at = NOW() WHERE id = 202; -- D-5
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (D-VENTEE 100)', updated_at = NOW() WHERE id = 203; -- D-VENTEE 100
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (D-VENTEE 50)', updated_at = NOW() WHERE id = 204; -- D-VENTEE 50
UPDATE products SET salt_id = 82, composition = 'Micronized Purified Flavonoid Fraction (Diosmin 450 mg + Hesperidin 50 mg) Tablet', updated_at = NOW() WHERE id = 205; -- DAMIR
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DEVEN-LA-100 TAB)', updated_at = NOW() WHERE id = 206; -- DEVEN-LA-100 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DEVEN-LA-50)', updated_at = NOW() WHERE id = 207; -- DEVEN-LA-50
UPDATE products SET salt_id = 83, composition = 'Dexlansoprazole 30 mg Modified Release Capsule', updated_at = NOW() WHERE id = 208; -- DEXOLAN 30
UPDATE products SET salt_id = 83, composition = 'Dexlansoprazole 60 mg Modified Release Capsule', updated_at = NOW() WHERE id = 209; -- DEXOLAN 60MG CAP.
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DEXPRAZ-DSR)', updated_at = NOW() WHERE id = 210; -- DEXPRAZ-DSR
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DEXTROSE IP-5% W/Y 500ML (INJ))', updated_at = NOW() WHERE id = 211; -- DEXTROSE IP-5% W/Y 500ml (inj)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DEXTROSE WITH NACL)', updated_at = NOW() WHERE id = 212; -- DEXTROSE WITH NaCl
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DICLOCLIFF-MR)', updated_at = NOW() WHERE id = 213; -- DICLOCLIFF-MR
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DICYCLOMIN HIDROCHLORIDE:10MG()', updated_at = NOW() WHERE id = 214; -- DICYCLOMIN HIDROCHLORIDE:10MG(
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DIG X RAY CARESTREAM 8X10)', updated_at = NOW() WHERE id = 215; -- DIG X RAY CARESTREAM 8X10
UPDATE products SET salt_id = 81, composition = 'Cyproheptadine Hydrochloride 2 mg + Tricholine Citrate 275 mg / 5 ml Syrup', updated_at = NOW() WHERE id = 216; -- DIGIGARD SYP
UPDATE products SET salt_id = 84, composition = 'Aluminium Hydroxide + Magnesium Hydroxide + Simethicone + Oxetacaine Mango Suspension', updated_at = NOW() WHERE id = 217; -- DIOVOL PLUS FORTE MANG SUS
UPDATE products SET salt_id = 85, composition = 'Rifaximin 400 mg Film Coated Tablet', updated_at = NOW() WHERE id = 218; -- DIRIFA 400MG TAB
UPDATE products SET salt_id = 85, composition = 'Rifaximin 550 mg Film Coated Tablet', updated_at = NOW() WHERE id = 219; -- DIRIFA 550 MG TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DIVAXEE OD 250)', updated_at = NOW() WHERE id = 220; -- DIVAXEE OD 250
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DNS FES(FES))', updated_at = NOW() WHERE id = 221; -- DNS FES(FES)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DNS FFS (SPPL))', updated_at = NOW() WHERE id = 222; -- DNS FFS (SPPL)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOLBINAC INJ.)', updated_at = NOW() WHERE id = 223; -- DOLBINAC INJ.
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOPIVIT)', updated_at = NOW() WHERE id = 224; -- DOPIVIT
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOPIVIT +)', updated_at = NOW() WHERE id = 225; -- DOPIVIT +
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOPIVIT-P PTP)', updated_at = NOW() WHERE id = 226; -- DOPIVIT-P PTP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOPIVIT-PLUS CAP)', updated_at = NOW() WHERE id = 227; -- DOPIVIT-PLUS CAP
UPDATE products SET salt_id = 86, composition = 'Ondansetron Hydrochloride 2 mg / ml (2 ml) IV/IM Injection', updated_at = NOW() WHERE id = 228; -- DOPNAUZ 2ML
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DORCOX TAB)', updated_at = NOW() WHERE id = 229; -- DORCOX TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DORCOX-TH4 TAB)', updated_at = NOW() WHERE id = 230; -- DORCOX-TH4 TAB
UPDATE products SET salt_id = 87, composition = 'Topical Formulation for External Use', updated_at = NOW() WHERE id = 231; -- DORNAC GEL
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DORNAC SP)', updated_at = NOW() WHERE id = 232; -- DORNAC SP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DORNAC SP TAB)', updated_at = NOW() WHERE id = 233; -- DORNAC SP TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DORNAC TH4 TABLET)', updated_at = NOW() WHERE id = 234; -- DORNAC TH4 TABLET
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DORNAC-CR TAB)', updated_at = NOW() WHERE id = 235; -- DORNAC-CR TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOTACID-80)', updated_at = NOW() WHERE id = 236; -- DOTACID-80
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOTECE-80)', updated_at = NOW() WHERE id = 237; -- DOTECE-80
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOTEX-80)', updated_at = NOW() WHERE id = 238; -- DOTEX-80
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOTEX-MF)', updated_at = NOW() WHERE id = 239; -- DOTEX-MF
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOTIDEP 75 TAB)', updated_at = NOW() WHERE id = 240; -- DOTIDEP 75 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOTIDEP-25)', updated_at = NOW() WHERE id = 241; -- DOTIDEP-25
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DOTIDEP-50)', updated_at = NOW() WHERE id = 242; -- DOTIDEP-50
UPDATE products SET salt_id = 31, composition = 'Midodrine Hydrochloride 5 mg Tablet', updated_at = NOW() WHERE id = 243; -- DRINELA 5
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DROLAN 80)', updated_at = NOW() WHERE id = 244; -- DROLAN 80
UPDATE products SET salt_id = 88, composition = 'Drotaverine Hydrochloride 40 mg Tablet', updated_at = NOW() WHERE id = 245; -- DROTACHEK 40
UPDATE products SET salt_id = 88, composition = 'Drotaverine Hydrochloride 80 mg Tablet', updated_at = NOW() WHERE id = 246; -- DROTACHEK 80
UPDATE products SET salt_id = 89, composition = 'Drotaverine Hydrochloride 80 mg + Mefenamic Acid 250 mg Tablet', updated_at = NOW() WHERE id = 247; -- DROTACHEK-M
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DRS.CIODOX-CV)', updated_at = NOW() WHERE id = 248; -- DRS.CIODOX-CV
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DRS.TIOCIF-50)', updated_at = NOW() WHERE id = 249; -- DRS.TIOCIF-50
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (DRWR)', updated_at = NOW() WHERE id = 250; -- DRWR
UPDATE products SET salt_id = 90, composition = 'Duloxetine Hydrochloride 30 mg Gastro-resistant Capsule', updated_at = NOW() WHERE id = 251; -- DUFORGE 30 TAB
UPDATE products SET salt_id = 90, composition = 'Duloxetine Hydrochloride 20 mg / 30 mg Capsule', updated_at = NOW() WHERE id = 252; -- DULOXEE P (20+50)
UPDATE products SET salt_id = 90, composition = 'Duloxetine Hydrochloride 20 mg / 30 mg Capsule', updated_at = NOW() WHERE id = 253; -- DULOXEE P (20+75)
UPDATE products SET salt_id = 90, composition = 'Duloxetine Hydrochloride 20 mg / 30 mg Capsule', updated_at = NOW() WHERE id = 254; -- DULOXEE-20
UPDATE products SET salt_id = 90, composition = 'Duloxetine Hydrochloride 20 mg / 30 mg Capsule', updated_at = NOW() WHERE id = 255; -- DULOXEE-30
UPDATE products SET salt_id = 90, composition = 'Duloxetine Hydrochloride 20 mg / 30 mg Capsule', updated_at = NOW() WHERE id = 256; -- DULOXIT 30 TAB
UPDATE products SET salt_id = 91, composition = 'Lactulose Solution USP 3.335 gm / 5 ml Bulk Pack', updated_at = NOW() WHERE id = 257; -- DUPHALAC BULK SYP
UPDATE products SET salt_id = 91, composition = 'Lactulose Solution USP 3.335 gm / 5 ml (150 ml)', updated_at = NOW() WHERE id = 258; -- DUPHALAC SYP(150 ML)
UPDATE products SET salt_id = 92, composition = 'Wheat Germ Oil & Vitamin E 400 IU Capsule', updated_at = NOW() WHERE id = 259; -- E-PROD TAB
UPDATE products SET salt_id = 87, composition = 'Topical Formulation for External Use', updated_at = NOW() WHERE id = 260; -- EC-FORTE (SOFTGEL
UPDATE products SET salt_id = 93, composition = 'Rabeprazole Sodium 20 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 261; -- EIREF
UPDATE products SET salt_id = 93, composition = 'Rabeprazole Sodium 40 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 262; -- EIREF 40
UPDATE products SET salt_id = 94, composition = 'Rabeprazole Sodium 20 mg + Domperidone 30 mg SR Capsule', updated_at = NOW() WHERE id = 263; -- EIREF D
UPDATE products SET salt_id = 95, composition = 'Rabeprazole Sodium 20 mg + Cinitapride 3 mg ER Capsule', updated_at = NOW() WHERE id = 264; -- EIREF-C
UPDATE products SET salt_id = 96, composition = 'Pinaverium Bromide 50 mg Film Coated Tablet', updated_at = NOW() WHERE id = 265; -- ELDICET TAB.
UPDATE products SET salt_id = 86, composition = 'Ondansetron Hydrochloride 4 mg Orally Disintegrating Tablet', updated_at = NOW() WHERE id = 266; -- EMESET MD 4
UPDATE products SET salt_id = 97, composition = 'Rabeprazole Sodium 20 mg + Ondansetron Hydrochloride 4 mg Tablet', updated_at = NOW() WHERE id = 267; -- EMESET R TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ENCEPHA INJ)', updated_at = NOW() WHERE id = 268; -- ENCEPHA INJ
UPDATE products SET salt_id = 98, composition = 'Spores of Polyantibiotic-resistant Bacillus clausii 2 Billion Spores Capsule', updated_at = NOW() WHERE id = 269; -- ENZISPOR
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (EPIGOLD XR-300 TAB)', updated_at = NOW() WHERE id = 270; -- EPIGOLD XR-300 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (EPIGOLD XR-450 TAB)', updated_at = NOW() WHERE id = 271; -- EPIGOLD XR-450 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (EPIGOLD XR-600 TAB)', updated_at = NOW() WHERE id = 272; -- EPIGOLD XR-600 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (EPIGOLD-XR-150 TAB)', updated_at = NOW() WHERE id = 273; -- EPIGOLD-XR-150 TAB
UPDATE products SET salt_id = 99, composition = 'Isabgol (Psyllium Husk) Pure Soluble Fiber 300 gm', updated_at = NOW() WHERE id = 274; -- ESABPURE PSYLLIUM 300 MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ESCIGOLD 10 TAB)', updated_at = NOW() WHERE id = 275; -- ESCIGOLD 10 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ESCIGOLD 20 TAB)', updated_at = NOW() WHERE id = 276; -- ESCIGOLD 20 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ESCIGOLD PLUS TAB NRX)', updated_at = NOW() WHERE id = 277; -- ESCIGOLD PLUS TAB NRx
UPDATE products SET salt_id = 100, composition = 'Escitalopram Oxalate 10 mg Tablet', updated_at = NOW() WHERE id = 278; -- ESCITALENT 10 (DPCO)
UPDATE products SET salt_id = 100, composition = 'Escitalopram Oxalate 10 mg Tablet', updated_at = NOW() WHERE id = 279; -- ESCITALENT 5(DPCO)
UPDATE products SET salt_id = 100, composition = 'Escitalopram Oxalate 10 mg Tablet', updated_at = NOW() WHERE id = 280; -- ESCITALENT LS (NRX)
UPDATE products SET salt_id = 100, composition = 'Escitalopram Oxalate 10 mg Tablet', updated_at = NOW() WHERE id = 281; -- ESCITALENT PLUS (NRX)
UPDATE products SET salt_id = 17, composition = 'Esomeprazole Sodium 40 mg + Domperidone 30 mg SR Capsule', updated_at = NOW() WHERE id = 282; -- ESOBEXIS -DSR
UPDATE products SET salt_id = 101, composition = 'Esomeprazole Sodium 40 mg + Itopride Hydrochloride 150 mg SR Capsule', updated_at = NOW() WHERE id = 283; -- ESOBEXIS-IT
UPDATE products SET salt_id = 102, composition = 'Esomeprazole 40 mg + Clarithromycin 500 mg + Amoxicillin 750 mg H. Pylori Kit', updated_at = NOW() WHERE id = 284; -- ESOBIZ HP KIT TAB
UPDATE products SET salt_id = 101, composition = 'Esomeprazole Sodium 40 mg + Itopride Hydrochloride 150 mg SR Capsule', updated_at = NOW() WHERE id = 285; -- ESOBIZ IT CAP
UPDATE products SET salt_id = 14, composition = 'Esomeprazole Sodium 40 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 286; -- ESOBIZ TAB
UPDATE products SET salt_id = 17, composition = 'Esomeprazole Sodium 40 mg + Domperidone 30 mg SR Capsule', updated_at = NOW() WHERE id = 287; -- ESOBIZ-DSR
UPDATE products SET salt_id = 103, composition = 'Esomeprazole Sodium 40 mg + Levosulpiride 75 mg SR Capsule', updated_at = NOW() WHERE id = 288; -- ESOBIZ-L CAP
UPDATE products SET salt_id = 101, composition = 'Esomeprazole Sodium 40 mg + Itopride Hydrochloride 150 mg SR Capsule', updated_at = NOW() WHERE id = 289; -- ESOFORGE IT
UPDATE products SET salt_id = 14, composition = 'Esomeprazole Sodium 40 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 290; -- ESOFORGE-40
UPDATE products SET salt_id = 17, composition = 'Esomeprazole Sodium 40 mg + Domperidone 30 mg SR Capsule', updated_at = NOW() WHERE id = 291; -- ESOFORGE-D
UPDATE products SET salt_id = 103, composition = 'Esomeprazole Sodium 40 mg + Levosulpiride 75 mg SR Capsule', updated_at = NOW() WHERE id = 292; -- ESOFORGE-L CAP
UPDATE products SET salt_id = 14, composition = 'Esomeprazole Sodium 20 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 293; -- ESOGRESS 20 TAB
UPDATE products SET salt_id = 104, composition = 'Clarithromycin 500 mg + Amoxicillin 750 mg + Esomeprazole 40 mg Forte Kit', updated_at = NOW() WHERE id = 294; -- ESOGRESS HP FORTE
UPDATE products SET salt_id = 14, composition = 'Esomeprazole Sodium 40 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 295; -- ESOGRESS-40
UPDATE products SET salt_id = 17, composition = 'Esomeprazole Sodium 40 mg + Domperidone 30 mg SR Capsule', updated_at = NOW() WHERE id = 296; -- ESOGRESS-D CAP
UPDATE products SET salt_id = 14, composition = 'Esomeprazole Sodium 40 mg Instant Fast Release Tablet', updated_at = NOW() WHERE id = 297; -- ESOGRESS-FAST 40
UPDATE products SET salt_id = 104, composition = 'Clarithromycin 500 mg + Amoxicillin 750 mg + Esomeprazole 40 mg Triple Therapy Kit', updated_at = NOW() WHERE id = 298; -- ESOGRESS-HP
UPDATE products SET salt_id = 101, composition = 'Esomeprazole Sodium 40 mg + Itopride Hydrochloride 150 mg SR Capsule', updated_at = NOW() WHERE id = 299; -- ESOGRESS-IT
UPDATE products SET salt_id = 103, composition = 'Esomeprazole Sodium 40 mg + Levosulpiride 75 mg SR Capsule', updated_at = NOW() WHERE id = 300; -- ESOGRESS-L
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ESOLAB D CAP)', updated_at = NOW() WHERE id = 301; -- ESOLAB D CAP
UPDATE products SET salt_id = 103, composition = 'Esomeprazole Sodium 40 mg + Levosulpiride 75 mg SR Capsule', updated_at = NOW() WHERE id = 302; -- ESOLAB L CAP
UPDATE products SET salt_id = 105, composition = 'Braided Coated Polyester Synthetic Non-absorbable Surgical Suture', updated_at = NOW() WHERE id = 303; -- ESTERLUS LS 4845
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ETWEET .25)', updated_at = NOW() WHERE id = 304; -- ETWEET .25
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ETWEET .5 TAB)', updated_at = NOW() WHERE id = 305; -- ETWEET .5 TAB
UPDATE products SET salt_id = 106, composition = 'Multi-strain Probiotics (Lactobacillus, Bifidobacterium) + Fructooligosaccharides (FOS) Capsule', updated_at = NOW() WHERE id = 306; -- EUGI CAP
UPDATE products SET salt_id = 106, composition = 'Multi-strain Probiotics + Prebiotics Sachet for Gut Microflora', updated_at = NOW() WHERE id = 307; -- EUGI SACHET
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (EVISTAR 400)', updated_at = NOW() WHERE id = 308; -- EVISTAR 400
UPDATE products SET salt_id = 80, composition = 'Vitamin E (Tocopheryl Acetate) 400 IU Capsule', updated_at = NOW() WHERE id = 309; -- EVITEE-400
UPDATE products SET salt_id = 107, composition = 'Etizolam 0.5 mg Tablet', updated_at = NOW() WHERE id = 310; -- EZOLENT BETA .5 NR
UPDATE products SET salt_id = 108, composition = 'Partially Hydrolyzed Guar Gum (PHGG) 100% Soluble Prebiotic Fiber', updated_at = NOW() WHERE id = 311; -- EZYFIBER
UPDATE products SET salt_id = 109, composition = 'Faropenem Sodium 200 mg + Potassium Clavulanate 125 mg Tablet', updated_at = NOW() WHERE id = 312; -- FAROALFA CV TAB
UPDATE products SET salt_id = 110, composition = 'Faropenem Sodium 300 mg Sustained Release Tablet', updated_at = NOW() WHERE id = 313; -- FAROALFA-SR
UPDATE products SET salt_id = 110, composition = 'Faropenem Sodium 200 mg Tablet', updated_at = NOW() WHERE id = 314; -- FAROBACT 200
UPDATE products SET salt_id = 110, composition = 'Faropenem Sodium 200 mg Tablet', updated_at = NOW() WHERE id = 315; -- FAROTRAK 200 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (FEBUXOCARE TAB)', updated_at = NOW() WHERE id = 316; -- FEBUXOCARE TAB
UPDATE products SET salt_id = 111, composition = 'Silymarin, Coenzyme Q10, L-Carnitine, Lecithin & Antioxidants Softgel Capsule', updated_at = NOW() WHERE id = 317; -- FEGATOFIT CAP
UPDATE products SET salt_id = 109, composition = 'Faropenem Sodium 200 mg + Potassium Clavulanate 125 mg Tablet', updated_at = NOW() WHERE id = 318; -- FEROALFA CV TAB
UPDATE products SET salt_id = 112, composition = 'Myo-Inositol 1000 mg + D-Chiro Inositol 25 mg + Melatonin 1.5 mg + Folic Acid Tablet', updated_at = NOW() WHERE id = 319; -- FERTIPEAK
UPDATE products SET salt_id = 113, composition = 'Diltiazem Hydrochloride 2% w/w Rectal Ointment', updated_at = NOW() WHERE id = 320; -- FIDONAL CREAM
UPDATE products SET salt_id = 114, composition = 'Flavoxate Hydrochloride 200 mg Film Coated Tablet', updated_at = NOW() WHERE id = 321; -- FLAVOTUM
UPDATE products SET salt_id = 115, composition = 'Absorbable Purified Gelatin Sponge USP (Local Hemostatic)', updated_at = NOW() WHERE id = 322; -- FLEX GEL LFLX 3*15
UPDATE products SET salt_id = 115, composition = 'Absorbable Purified Gelatin Sponge USP (Local Hemostatic)', updated_at = NOW() WHERE id = 323; -- FLEX GEL LFLX 5*5
UPDATE products SET salt_id = 116, composition = 'Fluoxetine Hydrochloride 20 mg Capsule', updated_at = NOW() WHERE id = 324; -- FLUOXEE 20 CAP
UPDATE products SET salt_id = 116, composition = 'Fluoxetine Hydrochloride 20 mg Capsule', updated_at = NOW() WHERE id = 325; -- FLUOXEE 40 CAP
UPDATE products SET salt_id = 116, composition = 'Fluoxetine Hydrochloride 20 mg Capsule', updated_at = NOW() WHERE id = 326; -- FLUOXEE 60 CAP
UPDATE products SET salt_id = 116, composition = 'Fluoxetine Hydrochloride 20 mg Capsule', updated_at = NOW() WHERE id = 327; -- FLUTEE (20MG) (DPCO)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (FRAIGHT CHARGE)', updated_at = NOW() WHERE id = 328; -- FRAIGHT CHARGE
UPDATE products SET salt_id = 117, composition = 'Methylcobalamin 1500 mcg + Alpha Lipoic Acid + B-Complex Capsule', updated_at = NOW() WHERE id = 329; -- FRANTIC CAPS
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (FREHIST LC)', updated_at = NOW() WHERE id = 330; -- FREHIST LC
UPDATE products SET salt_id = 61, composition = 'Calcium Carbonate with Vitamin D3 & Minerals Tablet', updated_at = NOW() WHERE id = 331; -- FUJI MEDICAL X-RAY FILM12*15
UPDATE products SET salt_id = 118, composition = 'WHO Formulation Oral Rehydration Electrolyte Solution', updated_at = NOW() WHERE id = 332; -- FULLYTE 3R
UPDATE products SET salt_id = 119, composition = 'BCAA (L-Leucine, L-Isoleucine, L-Valine) with Balanced Electrolytes Drink', updated_at = NOW() WHERE id = 333; -- FULLYTE BCAA+
UPDATE products SET salt_id = 120, composition = 'Essential Micronutrients, DHA, Folic Acid & Protein Powder for Mother', updated_at = NOW() WHERE id = 334; -- FULLYTE MOM
UPDATE products SET salt_id = 15, composition = 'Advanced Carbohydrate, Electrolyte & Amino Acid Clinical Formula', updated_at = NOW() WHERE id = 335; -- FULLYTE TRIO
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (GABA-PAV-M 10*1*10)', updated_at = NOW() WHERE id = 336; -- GABA-PAV-M 10*1*10
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (GABAJAS-M)', updated_at = NOW() WHERE id = 337; -- GABAJAS-M
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (GABETT-300 TAB)', updated_at = NOW() WHERE id = 338; -- GABETT-300 TAB
UPDATE products SET salt_id = 121, composition = 'Itopride Hydrochloride 50 mg Film Coated Tablet', updated_at = NOW() WHERE id = 339; -- GANATON TAB
UPDATE products SET salt_id = 122, composition = 'Itopride Hydrochloride 150 mg SR + Pantoprazole Sodium 40 mg Capsule', updated_at = NOW() WHERE id = 340; -- GANATON TOTEL TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (GEOFORT-LC S/CAP)', updated_at = NOW() WHERE id = 341; -- GEOFORT-LC S/CAP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (GESCLAV 625)', updated_at = NOW() WHERE id = 342; -- GESCLAV 625
UPDATE products SET salt_id = 71, composition = 'Liquid Paraffin 1.25 ml + Milk of Magnesia 3.75 ml + Sodium Picosulfate 3.33 mg / 5 ml Suspension (200 ml)', updated_at = NOW() WHERE id = 343; -- GHUSHOUTSYP200 ML
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (GIRAX)', updated_at = NOW() WHERE id = 344; -- GIRAX
UPDATE products SET salt_id = 123, composition = 'Glimepiride 1 mg / 2 mg + Metformin 500 mg Tablet', updated_at = NOW() WHERE id = 345; -- GLIMITAL M1 (DPCO)
UPDATE products SET salt_id = 123, composition = 'Glimepiride 1 mg / 2 mg + Metformin 500 mg Tablet', updated_at = NOW() WHERE id = 346; -- GLIMITAL M2 (DPCO)
UPDATE products SET salt_id = 124, composition = 'Reduced Glutathione 600 mg IV Injection with Sterile Water', updated_at = NOW() WHERE id = 347; -- GLUTAHENZ-IV
UPDATE products SET salt_id = 124, composition = 'Reduced Glutathione 600 mg Film Coated Tablet', updated_at = NOW() WHERE id = 348; -- GLUTAHIGH
UPDATE products SET salt_id = 124, composition = 'Reduced Glutathione 1200 mg IV Injection with Sterile Water', updated_at = NOW() WHERE id = 349; -- GLUTAHIGH-IV
UPDATE products SET salt_id = 125, composition = 'L-Glutamine 15 gm Powder / Sachet', updated_at = NOW() WHERE id = 350; -- GLUTALEVEN 15 GM
UPDATE products SET salt_id = 125, composition = 'L-Glutamine 15 gm Powder / Sachet', updated_at = NOW() WHERE id = 351; -- GLUTALEVEN 15GM
UPDATE products SET salt_id = 124, composition = 'L-Glutathione 500 mg Film Coated Tablet', updated_at = NOW() WHERE id = 352; -- GLUTAUP TAB
UPDATE products SET salt_id = 125, composition = 'L-Glutamine 10 gm Sachet with Antioxidants 15 gm', updated_at = NOW() WHERE id = 353; -- GLUTAWAY SACHETS 15GM
UPDATE products SET salt_id = 71, composition = 'Liquid Paraffin + Milk of Magnesia + Sodium Picosulfate Laxative Suspension (450 ml)', updated_at = NOW() WHERE id = 354; -- GUSHOUT SYP -450ML
UPDATE products SET salt_id = 126, composition = 'Sodium Picosulfate 10 mg Tablet', updated_at = NOW() WHERE id = 355; -- GUSHOUT TAB
UPDATE products SET salt_id = 106, composition = 'Streptococcus faecalis, Clostridium butyricum, Bacillus mesentericus & Lactic Acid Bacillus Capsule', updated_at = NOW() WHERE id = 356; -- GUTCHAMP CAP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (GUTGUT-8)', updated_at = NOW() WHERE id = 357; -- GUTGUT-8
UPDATE products SET salt_id = 110, composition = 'Faropenem Sodium 200 mg Film Coated Tablet', updated_at = NOW() WHERE id = 358; -- H1- FAROBACT 200 TAB
UPDATE products SET salt_id = 110, composition = 'Faropenem Sodium 300 mg Extended Release Tablet', updated_at = NOW() WHERE id = 359; -- H1-FAROBACT 300 ER TAB
UPDATE products SET salt_id = 109, composition = 'Faropenem Sodium 200 mg + Potassium Clavulanate 125 mg Tablet', updated_at = NOW() WHERE id = 360; -- H1-FAROBACT CV
UPDATE products SET salt_id = 127, composition = 'Iron Bisglycinate 30 mg + L-Methylfolate 1 mg + Methylcobalamin 1500 mcg + Zinc Tablet', updated_at = NOW() WHERE id = 361; -- HbAA+
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (HEFIXIME-O)', updated_at = NOW() WHERE id = 362; -- HEFIXIME-O
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (HEILEN SP)', updated_at = NOW() WHERE id = 363; -- HEILEN SP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (HEILMENTIN CV 625)', updated_at = NOW() WHERE id = 364; -- HEILMENTIN CV 625
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (HEILMENTIN CV 625 LB)', updated_at = NOW() WHERE id = 365; -- HEILMENTIN CV 625 LB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (HEKSI 2 TAB)', updated_at = NOW() WHERE id = 366; -- HEKSI 2 TAB
UPDATE products SET salt_id = 115, composition = 'Absorbable Purified Gelatin Sponge USP Hemostat', updated_at = NOW() WHERE id = 367; -- HEMOLUS LH 1953(N)
UPDATE products SET salt_id = 115, composition = 'Absorbable Purified Gelatin Sponge USP Hemostat', updated_at = NOW() WHERE id = 368; -- HEMOLUS LH1953
UPDATE products SET salt_id = 65, composition = 'Comprehensive Multivitamin, Mineral & Antioxidant Supplement', updated_at = NOW() WHERE id = 369; -- HENZOVIT
UPDATE products SET salt_id = 128, composition = 'L-Ornithine L-Aspartate 5 gm Sachet', updated_at = NOW() WHERE id = 370; -- HEPAGRESS
UPDATE products SET salt_id = 129, composition = 'Calcium Beta-Hydroxy Beta-Methylbutyrate (HMB) with BCAA Sachet for Hepatic Support', updated_at = NOW() WHERE id = 371; -- HEPANICHE HMB SACHET
UPDATE products SET salt_id = 128, composition = 'L-Ornithine L-Aspartate 5 gm Sachet', updated_at = NOW() WHERE id = 372; -- HEPANICHE SACHET
UPDATE products SET salt_id = 128, composition = 'L-Ornithine L-Aspartate 5 gm Sachet', updated_at = NOW() WHERE id = 373; -- HEPFORGE SACHET
UPDATE products SET salt_id = 130, composition = 'Silymarin 140 mg + L-Ornithine L-Aspartate 150 mg + Vitamin B-Complex Capsule', updated_at = NOW() WHERE id = 374; -- HEPGEN
UPDATE products SET salt_id = 34, composition = 'Metadoxine 500 mg + Silymarin 140 mg + L-Ornithine L-Aspartate 150 mg + Folic Acid & Pyridoxine Tablet', updated_at = NOW() WHERE id = 375; -- HEPJOY TAB
UPDATE products SET salt_id = 41, composition = 'Ademetionine (S-Adenosyl L-Methionine) 400 mg Tablet', updated_at = NOW() WHERE id = 376; -- HEPKART 400MG
UPDATE products SET salt_id = 34, composition = 'Metadoxine, Silymarin, L-Ornithine L-Aspartate & Folic Acid Tablet', updated_at = NOW() WHERE id = 377; -- HEPSURE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (HEXYLENT (DPCO))', updated_at = NOW() WHERE id = 378; -- HEXYLENT (DPCO)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (HIXTIN-16)', updated_at = NOW() WHERE id = 379; -- HIXTIN-16
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 60,000 IU Oral Solution 5 ml', updated_at = NOW() WHERE id = 380; -- HNU-D3 60K SOLUTION
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 60,000 IU Chewable Tablet', updated_at = NOW() WHERE id = 381; -- HNU-D3 60K TAB
UPDATE products SET salt_id = 131, composition = 'Calcium Carbonate 1250 mg + Vitamin D3 250 IU + Zinc Sulphate Tablet', updated_at = NOW() WHERE id = 382; -- HR CAL
UPDATE products SET salt_id = 132, composition = 'Chromic / Plain Natural Catgut Absorbable Surgical Suture', updated_at = NOW() WHERE id = 383; -- HTC M-6
UPDATE products SET salt_id = 132, composition = 'Chromic / Plain Natural Catgut Absorbable Surgical Suture', updated_at = NOW() WHERE id = 384; -- HTC-U ML-6 (N)
UPDATE products SET salt_id = 132, composition = 'Chromic / Plain Natural Catgut Absorbable Surgical Suture', updated_at = NOW() WHERE id = 385; -- HTC_UL-6(N)
UPDATE products SET salt_id = 133, composition = 'Sodium Hyaluronate 10 mg/ml Intra-articular Injection', updated_at = NOW() WHERE id = 386; -- HUENA
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (HUNGRY-200)', updated_at = NOW() WHERE id = 387; -- HUNGRY-200
UPDATE products SET salt_id = 31, composition = 'Midodrine Hydrochloride 5 mg Tablet', updated_at = NOW() WHERE id = 388; -- HYPODRIN-5 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (IBANRACE-150 TAB)', updated_at = NOW() WHERE id = 389; -- IBANRACE-150 TAB
UPDATE products SET salt_id = 134, composition = 'Meropenem Trihydrate 1000 mg IV Injection', updated_at = NOW() WHERE id = 390; -- IMELTI-1000
UPDATE products SET salt_id = 134, composition = 'Meropenem Trihydrate 500 mg IV Injection', updated_at = NOW() WHERE id = 391; -- IMELTI-500
UPDATE products SET salt_id = 135, composition = 'Imipenem 500 mg + Cilastatin Sodium 500 mg IV Infusion', updated_at = NOW() WHERE id = 392; -- IMIREN-500
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INJ PIZZO 1.125MG)', updated_at = NOW() WHERE id = 393; -- Inj Pizzo 1.125mg
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INJ..XYLOVIR 250)', updated_at = NOW() WHERE id = 394; -- INJ..XYLOVIR 250
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INJ.COLISTER)', updated_at = NOW() WHERE id = 395; -- INJ.COLISTER
UPDATE products SET salt_id = 47, composition = 'Cephalosporin Antibiotic Formulation', updated_at = NOW() WHERE id = 396; -- INNCEF-O-LB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INNOLOCK SP)', updated_at = NOW() WHERE id = 397; -- INNOLOCK SP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INNOWELL POWDER)', updated_at = NOW() WHERE id = 398; -- INNOWELL POWDER
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INSTAAHEAL FORT TABLET)', updated_at = NOW() WHERE id = 399; -- INSTAAHEAL FORT TABLET
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INSTAAHEAL PLUS)', updated_at = NOW() WHERE id = 400; -- INSTAAHEAL PLUS
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INSTAAHEAL TABLET)', updated_at = NOW() WHERE id = 401; -- INSTAAHEAL TABLET
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INSTABIO SACHET)', updated_at = NOW() WHERE id = 402; -- INSTABIO SACHET
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INSTACUF SYRUP)', updated_at = NOW() WHERE id = 403; -- INSTACUF SYRUP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INSTACUF-LS SYRUP)', updated_at = NOW() WHERE id = 404; -- INSTACUF-LS SYRUP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (INTORAB DSR)', updated_at = NOW() WHERE id = 405; -- INTORAB DSR
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (IQ SHARP 200 ML)', updated_at = NOW() WHERE id = 406; -- IQ SHARP 200 ML
UPDATE products SET salt_id = 136, composition = 'Ispaghula Husk 3.5 gm + Lactitol Monohydrate 10 gm Effervescent Granules', updated_at = NOW() WHERE id = 407; -- ISAB PURE LT
UPDATE products SET salt_id = 99, composition = 'Isabgol (Psyllium Husk) Pure Soluble Fiber 300 gm Jar', updated_at = NOW() WHERE id = 408; -- ISABPURE PSYLLIUM 300GM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ISTRALIN-25)', updated_at = NOW() WHERE id = 409; -- ISTRALIN-25
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ITDOX-O TAB)', updated_at = NOW() WHERE id = 410; -- ITDOX-O TAB
UPDATE products SET salt_id = 121, composition = 'Itopride Hydrochloride 50 mg Film Coated Tablet', updated_at = NOW() WHERE id = 411; -- ITORIHENZ 50
UPDATE products SET salt_id = 121, composition = 'Itopride Hydrochloride 150 mg Sustained Release Capsule', updated_at = NOW() WHERE id = 412; -- ITORIHENZ-150
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (IVALP TAB)', updated_at = NOW() WHERE id = 413; -- IVALP TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (IVALP XP 500 TAB)', updated_at = NOW() WHERE id = 414; -- IVALP XP 500 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (IXIDOL-90)', updated_at = NOW() WHERE id = 415; -- IXIDOL-90
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (JASLOL-SR-40 MG)', updated_at = NOW() WHERE id = 416; -- JASLOL-SR-40 MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (JO-LORAZ 1 MG)', updated_at = NOW() WHERE id = 417; -- JO-LORAZ 1 MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (JO-LORAZ INJ. 2ML)', updated_at = NOW() WHERE id = 418; -- JO-LORAZ INJ. 2ML
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KALCIRAY FORTE TAB)', updated_at = NOW() WHERE id = 419; -- KALCIRAY FORTE TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KALCIRAY NASAL SPRAY)', updated_at = NOW() WHERE id = 420; -- KALCIRAY NASAL SPRAY
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KALCIRAY-K2)', updated_at = NOW() WHERE id = 421; -- KALCIRAY-K2
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KEPZIL-M TAB)', updated_at = NOW() WHERE id = 422; -- KEPZIL-M TAB
UPDATE products SET salt_id = 107, composition = 'Etizolam 0.5 mg Tablet', updated_at = NOW() WHERE id = 423; -- KETIZOLAM MD-.25 TAB
UPDATE products SET salt_id = 107, composition = 'Etizolam 0.5 mg Tablet', updated_at = NOW() WHERE id = 424; -- KETIZOLAM MD-0.50 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KETRIP 10 TAB)', updated_at = NOW() WHERE id = 425; -- KETRIP 10 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KETRIP-25)', updated_at = NOW() WHERE id = 426; -- KETRIP-25
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KEVERT PLUS TAB)', updated_at = NOW() WHERE id = 427; -- KEVERT PLUS TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KILAX TAB)', updated_at = NOW() WHERE id = 428; -- KILAX TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIMITRIP DS TAB)', updated_at = NOW() WHERE id = 429; -- KIMITRIP DS TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIMITRIP-TAB)', updated_at = NOW() WHERE id = 430; -- KIMITRIP-TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIPNOL 10 TAB)', updated_at = NOW() WHERE id = 431; -- KIPNOL 10 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIPNOL 20 TAB)', updated_at = NOW() WHERE id = 432; -- KIPNOL 20 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIPNOL PLUS-10 CAP)', updated_at = NOW() WHERE id = 433; -- KIPNOL PLUS-10 CAP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIPNOL PLUS-5MG TAB)', updated_at = NOW() WHERE id = 434; -- KIPNOL PLUS-5MG TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIPNOL TR40 CAP)', updated_at = NOW() WHERE id = 435; -- KIPNOL TR40 CAP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIPTOIN-100MG TAB)', updated_at = NOW() WHERE id = 436; -- KIPTOIN-100MG TAB
UPDATE products SET salt_id = 26, composition = 'Aceclofenac 100 mg + Paracetamol 325 mg Tablet', updated_at = NOW() WHERE id = 437; -- KITOFLAM-P
UPDATE products SET salt_id = 61, composition = 'Calcium Carbonate with Vitamin D3 & Minerals Tablet', updated_at = NOW() WHERE id = 438; -- KIVICALM 5 TAB
UPDATE products SET salt_id = 61, composition = 'Calcium Carbonate with Vitamin D3 & Minerals Tablet', updated_at = NOW() WHERE id = 439; -- kivicalm h tab
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIVIDOL DT 5 TAB*)', updated_at = NOW() WHERE id = 440; -- KIVIDOL DT 5 TAB*
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIVIDOL DT-1.5 TAB)', updated_at = NOW() WHERE id = 441; -- KIVIDOL DT-1.5 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIVIPRIDE-100 TAB)', updated_at = NOW() WHERE id = 442; -- KIVIPRIDE-100 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIVIPRIDE-200 TAB)', updated_at = NOW() WHERE id = 443; -- KIVIPRIDE-200 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIVIT-GA CAP)', updated_at = NOW() WHERE id = 444; -- KIVIT-GA CAP
UPDATE products SET salt_id = 55, composition = 'Oral Pharmaceutical Liquid Formulation', updated_at = NOW() WHERE id = 445; -- KIVIT-SYP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIVIT-Z CAP)', updated_at = NOW() WHERE id = 446; -- KIVIT-Z CAP
UPDATE products SET salt_id = 137, composition = 'Teneligliptin Hydrobromide Hydrate 20 mg Tablet', updated_at = NOW() WHERE id = 447; -- KIVIZA -1
UPDATE products SET salt_id = 138, composition = 'Teneligliptin 20 mg + Dapagliflozin 10 mg Tablet', updated_at = NOW() WHERE id = 448; -- KIVIZA Cf
UPDATE products SET salt_id = 139, composition = 'Teneligliptin 20 mg + Dapagliflozin 10 mg + Metformin 500 mg ER Tablet', updated_at = NOW() WHERE id = 449; -- KIVIZA Cf Forte
UPDATE products SET salt_id = 140, composition = 'Teneligliptin 20 mg + Metformin Hydrochloride 500 mg Tablet', updated_at = NOW() WHERE id = 450; -- KIVIZA-2
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KIVIZAM 5 TAB)', updated_at = NOW() WHERE id = 451; -- KIVIZAM 5 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KLONAZ .25)', updated_at = NOW() WHERE id = 452; -- KLONAZ .25
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KLONAZ .5)', updated_at = NOW() WHERE id = 453; -- KLONAZ .5
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KLONAZ ES TAB)', updated_at = NOW() WHERE id = 454; -- KLONAZ ES TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KLONAZ ES-H TAB)', updated_at = NOW() WHERE id = 455; -- KLONAZ ES-H TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KLONAZ MD-.25)', updated_at = NOW() WHERE id = 456; -- KLONAZ MD-.25
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KLONAZ-MD.5)', updated_at = NOW() WHERE id = 457; -- KLONAZ-MD.5
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KLOWIN- 0.25MG)', updated_at = NOW() WHERE id = 458; -- KLOWIN- 0.25MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KLOWIN- 0.5 MG)', updated_at = NOW() WHERE id = 459; -- KLOWIN- 0.5 MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KOLA 2.5)', updated_at = NOW() WHERE id = 460; -- KOLA 2.5
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KOLA 5 TAB)', updated_at = NOW() WHERE id = 461; -- KOLA 5 TAB
UPDATE products SET salt_id = 72, composition = 'Polyethylene Glycol 3350 with Electrolytes Powder', updated_at = NOW() WHERE id = 462; -- KOLONOTOX-GI
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KUFMEC-A)', updated_at = NOW() WHERE id = 463; -- KUFMEC-A
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KUFMEC-DX)', updated_at = NOW() WHERE id = 464; -- KUFMEC-DX
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KUFMEC-LS)', updated_at = NOW() WHERE id = 465; -- KUFMEC-LS
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KUFNIM-D)', updated_at = NOW() WHERE id = 466; -- KUFNIM-D
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KVERT 25MG)', updated_at = NOW() WHERE id = 467; -- KVERT 25MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (KVERT PLUS TAB)', updated_at = NOW() WHERE id = 468; -- KVERT PLUS TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LACARNIT INJ)', updated_at = NOW() WHERE id = 469; -- LACARNIT INJ
UPDATE products SET salt_id = 55, composition = 'Oral Pharmaceutical Liquid Formulation', updated_at = NOW() WHERE id = 470; -- LACTOSAN SYP 200 ML
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LAMIACE-DT-25MG)', updated_at = NOW() WHERE id = 471; -- LAMIACE-DT-25MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LAMIACE-DT-50MG)', updated_at = NOW() WHERE id = 472; -- LAMIACE-DT-50MG
UPDATE products SET salt_id = 141, composition = 'Amino Acid 10% IV Infusion with Electrolytes', updated_at = NOW() WHERE id = 473; -- LAMINO 10% PLUS
UPDATE products SET salt_id = 141, composition = 'Amino Acid 8% IV Infusion 200 ml', updated_at = NOW() WHERE id = 474; -- LAMINO 8% INJ-200ML
UPDATE products SET salt_id = 11, composition = 'Branched Chain Amino Acids (L-Leucine, L-Isoleucine, L-Valine) Sachet', updated_at = NOW() WHERE id = 475; -- LAMINO BCAA SACHET
UPDATE products SET salt_id = 142, composition = 'Hepatic-formulated Amino Acids 8% IV Infusion 500 ml', updated_at = NOW() WHERE id = 476; -- LAMINO HEPA-IV-500 ML
UPDATE products SET salt_id = 143, composition = 'High Protein Nutrition with Slow-release Carbohydrates & Fiber for Diabetes', updated_at = NOW() WHERE id = 477; -- LAMINO-DB
UPDATE products SET salt_id = 144, composition = 'Specialized Nutritional Supplement for Gastrointestinal Health 400 gm', updated_at = NOW() WHERE id = 478; -- LAMINO-GI GREEN
UPDATE products SET salt_id = 144, composition = 'Glutamine enriched GI Care Enteral Nutrition Powder 400 gm', updated_at = NOW() WHERE id = 479; -- LAMINO-GI PLUS
UPDATE products SET salt_id = 145, composition = 'BCAA Enriched Nutrition for Chronic Liver Disease & Cirrhosis', updated_at = NOW() WHERE id = 480; -- LAMINO-HEPA
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LANDEX 60MG)', updated_at = NOW() WHERE id = 481; -- LANDEX 60MG
UPDATE products SET salt_id = 146, composition = 'Drotaverine Hydrochloride 80 mg + Paracetamol 325 mg Tablet', updated_at = NOW() WHERE id = 482; -- LAREPASM TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LAXIF 90 GM)', updated_at = NOW() WHERE id = 483; -- LAXIF 90 GM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LAXINATE PLUS SYR)', updated_at = NOW() WHERE id = 484; -- LAXINATE PLUS SYR
UPDATE products SET salt_id = 55, composition = 'Oral Pharmaceutical Liquid Formulation', updated_at = NOW() WHERE id = 485; -- LAXIRIGHT SYP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LAXIT 90 GM)', updated_at = NOW() WHERE id = 486; -- LAXIT 90 GM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LBL LAVANYA)', updated_at = NOW() WHERE id = 487; -- LBL LAVANYA
UPDATE products SET salt_id = 147, composition = 'Oxidized Regenerated Cellulose Absorbable Hemostatic Gauze', updated_at = NOW() WHERE id = 488; -- LEAT 20(N)
UPDATE products SET salt_id = 147, composition = 'Oxidized Regenerated Cellulose Absorbable Hemostat', updated_at = NOW() WHERE id = 489; -- LETT-30
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LEVETEE SYRUP)', updated_at = NOW() WHERE id = 490; -- LEVETEE SYRUP
UPDATE products SET salt_id = 37, composition = 'Levosulpiride 25 mg Tablet', updated_at = NOW() WHERE id = 491; -- LEVFORGE-25MG
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Surgical Suture with Needle', updated_at = NOW() WHERE id = 492; -- LH3D 114
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Surgical Suture with Needle', updated_at = NOW() WHERE id = 493; -- LH3D 225L
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LIBRATE (NRX))', updated_at = NOW() WHERE id = 494; -- LIBRATE (NRX)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LIBRATEX (NRX))', updated_at = NOW() WHERE id = 495; -- LIBRATEX (NRX)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LIBRIC-C TAB NRX)', updated_at = NOW() WHERE id = 496; -- LIBRIC-C TAB NRx
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LIBRIN 10)', updated_at = NOW() WHERE id = 497; -- LIBRIN 10
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LIBRIN 25 TAB)', updated_at = NOW() WHERE id = 498; -- LIBRIN 25 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LIBRIN-T TAB)', updated_at = NOW() WHERE id = 499; -- LIBRIN-T TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LIBROLENT)', updated_at = NOW() WHERE id = 500; -- LIBROLENT
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LINALENT 5)', updated_at = NOW() WHERE id = 501; -- LINALENT 5
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LINALENT-D)', updated_at = NOW() WHERE id = 502; -- LINALENT-D
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LINALENT-M 500)', updated_at = NOW() WHERE id = 503; -- LINALENT-M 500
UPDATE products SET salt_id = 148, composition = 'n-Butyl Cyanoacrylate 0.35 gm Topical Microbial Skin Adhesive', updated_at = NOW() WHERE id = 504; -- LIQUIBAND OPTIMA 0.35G
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 505; -- LM 114-1
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 506; -- LM 150-1
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 507; -- LM 225-1
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 508; -- LM 66-1L
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 509; -- LNW 2180GF-910(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 510; -- LNW 2347 VS
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 511; -- LNW 2347-910
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 512; -- LNW 2347-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 513; -- LNW 5037
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 514; -- LNW 5050
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 515; -- LNW 841
UPDATE products SET salt_id = 150, composition = 'Ramosetron Hydrochloride 0.1 mg / 5 mcg Tablet', updated_at = NOW() WHERE id = 516; -- LOBELONG 0.5
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 517; -- LOGUT LNW 4228 100 CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 518; -- LOGUT LNW 4237 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 519; -- LOGUT LNW 4241(N )
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 520; -- LOGUT LNW 4242 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 521; -- LOGUT lNW 4259 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 522; -- LOGUT LNW 4259L (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 523; -- LOGUT LNW 4280 (N)
UPDATE products SET salt_id = 132, composition = 'Purified Collagen Chromic Catgut Absorbable Surgical Suture', updated_at = NOW() WHERE id = 524; -- LOGUT LOOP WNL 2215(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 525; -- LOGUTLNW 4228 (N)
UPDATE products SET salt_id = 128, composition = 'L-Ornithine L-Aspartate 0.5 gm/ml Infusion Concentrate', updated_at = NOW() WHERE id = 526; -- LORHEP INJ
UPDATE products SET salt_id = 128, composition = 'L-Ornithine L-Aspartate 5 gm Sachet', updated_at = NOW() WHERE id = 527; -- LORHEP SACHET 5MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LOTWEET-1)', updated_at = NOW() WHERE id = 528; -- LOTWEET-1
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LOTWEET-2)', updated_at = NOW() WHERE id = 529; -- LOTWEET-2
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LOXET-20)', updated_at = NOW() WHERE id = 530; -- LOXET-20
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LOXET-30)', updated_at = NOW() WHERE id = 531; -- LOXET-30
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LOZIPAM-1 TAB)', updated_at = NOW() WHERE id = 532; -- LOZIPAM-1 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LOZIPAM-2TAB)', updated_at = NOW() WHERE id = 533; -- LOZIPAM-2TAB
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (LPHS 32)', updated_at = NOW() WHERE id = 534; -- LPHS 32
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (LPSS 35WP)', updated_at = NOW() WHERE id = 535; -- LPSS 35WP
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (LSG 805010 (N))', updated_at = NOW() WHERE id = 536; -- LSG 805010 (N)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (LYPOLACK-F TAB)', updated_at = NOW() WHERE id = 537; -- LYPOLACK-F TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MAHANIF TAB)', updated_at = NOW() WHERE id = 538; -- MAHANIF TAB
UPDATE products SET salt_id = 16, composition = 'Sodium Alginate 250 mg + Sodium Bicarbonate 133.5 mg + Calcium Carbonate 80 mg Oral Suspension', updated_at = NOW() WHERE id = 539; -- MAHARAFT
UPDATE products SET salt_id = 46, composition = 'Flupentixol Dihydrochloride 0.5 mg + Melitracen Hydrochloride 10 mg Tablet', updated_at = NOW() WHERE id = 540; -- MANKIND PLACIDA TAB 1O''S
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 541; -- MASS LNW 9237 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 542; -- MASS LNW 9254(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 543; -- MASS LNW 9262(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 544; -- MASS LNW 9423 (N)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MAVINE C)', updated_at = NOW() WHERE id = 545; -- MAVINE C
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MAXXQ GOLD TAB)', updated_at = NOW() WHERE id = 546; -- MAXXQ GOLD TAB
UPDATE products SET salt_id = 152, composition = 'Mebeverine Hydrochloride 200 mg Sustained Release Capsule', updated_at = NOW() WHERE id = 547; -- MEBEHOPE-200XP CAP
UPDATE products SET salt_id = 153, composition = 'Mebeverine Hydrochloride 135 mg + Chlordiazepoxide 5 mg Tablet', updated_at = NOW() WHERE id = 548; -- MEBEHOPE-C TAB
UPDATE products SET salt_id = 153, composition = 'Mebeverine Hydrochloride 135 mg + Chlordiazepoxide 5 mg Tablet', updated_at = NOW() WHERE id = 549; -- MEBGEN C
UPDATE products SET salt_id = 152, composition = 'Mebeverine Hydrochloride 200 mg Sustained Release Capsule', updated_at = NOW() WHERE id = 550; -- MEBGEN SR CAP
UPDATE products SET salt_id = 73, composition = 'Carbonyl Iron 100 mg + Folic Acid 1.5 mg + Vitamin B12 15 mcg + Zinc Capsule', updated_at = NOW() WHERE id = 551; -- MEDHEM CAP
UPDATE products SET salt_id = 154, composition = 'Omega-3-Acid Ethyl Esters (EPA 460 mg, DHA 380 mg) + Natural Vitamin E Softgel', updated_at = NOW() WHERE id = 552; -- MEGALEY E SOFTGEL CAP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MEGATOLL-E)', updated_at = NOW() WHERE id = 553; -- MEGATOLL-E
UPDATE products SET salt_id = 155, composition = 'Melatonin 3 mg + L-Tryptophan + Peppermint Oil Extended Release Tablet for IBS', updated_at = NOW() WHERE id = 554; -- MELATROP-IBS
UPDATE products SET salt_id = 134, composition = 'Meropenem 1000 mg IV Injection', updated_at = NOW() WHERE id = 555; -- MEROPLAST INJ 125 MG
UPDATE products SET salt_id = 134, composition = 'Meropenem 1000 mg IV Injection', updated_at = NOW() WHERE id = 556; -- MEROPLAST INJ 250
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MERRYCLAV-625)', updated_at = NOW() WHERE id = 557; -- MERRYCLAV-625
UPDATE products SET salt_id = 156, composition = 'Mesalamine (5-Aminosalicylic Acid) 1200 mg Prolonged Release Tablet', updated_at = NOW() WHERE id = 558; -- MESAHENZ-1200
UPDATE products SET salt_id = 156, composition = 'Mesalamine (5-Aminosalicylic Acid) 400 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 559; -- MESAHENZ-400
UPDATE products SET salt_id = 156, composition = 'Mesalamine (5-Aminosalicylic Acid) 1200 mg Prolonged Release Tablet', updated_at = NOW() WHERE id = 560; -- MESAVIN-1200 SR
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (METFORTAL SR 1000(DP)', updated_at = NOW() WHERE id = 561; -- METFORTAL SR 1000(DP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (METFORTAL SR 500)', updated_at = NOW() WHERE id = 562; -- METFORTAL SR 500
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (METRONIDAZOLE:400MG(TAB))', updated_at = NOW() WHERE id = 563; -- METRONIDAZOLE:400MG(TAB)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MEVIN C)', updated_at = NOW() WHERE id = 564; -- MEVIN C
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MEVIN SR 200)', updated_at = NOW() WHERE id = 565; -- MEVIN SR 200
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MICOLIN LC TAB)', updated_at = NOW() WHERE id = 566; -- MICOLIN LC TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MIGRAPAC EC)', updated_at = NOW() WHERE id = 567; -- MIGRAPAC EC
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MIRDEP 15 TAB)', updated_at = NOW() WHERE id = 568; -- MIRDEP 15 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MIRDEP 7.5 TAB)', updated_at = NOW() WHERE id = 569; -- MIRDEP 7.5 TAB
UPDATE products SET salt_id = 157, composition = 'Mirtazapine 15 mg Film Coated Tablet', updated_at = NOW() WHERE id = 570; -- MIRMED 15MG
UPDATE products SET salt_id = 157, composition = 'Mirtazapine 7.5 mg Mouth Dissolving Tablet', updated_at = NOW() WHERE id = 571; -- MIRMED-7.5 MD
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MIRTEE 15)', updated_at = NOW() WHERE id = 572; -- MIRTEE 15
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MIRTEE 7.5)', updated_at = NOW() WHERE id = 573; -- MIRTEE 7.5
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MOEMOE-Z)', updated_at = NOW() WHERE id = 574; -- MOEMOE-Z
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 575; -- MONOLUS LNW 1326
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 576; -- MONOLUS LNW 1326(N)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MONOTOP- 50 MGTAB)', updated_at = NOW() WHERE id = 577; -- MONOTOP- 50 MGTAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (MONOTOP-25)', updated_at = NOW() WHERE id = 578; -- MONOTOP-25
UPDATE products SET salt_id = 158, composition = 'Bilastine 20 mg + Montelukast Sodium 10 mg Tablet', updated_at = NOW() WHERE id = 579; -- MONTEMUNE-B TAB
UPDATE products SET salt_id = 159, composition = 'Montelukast Sodium 10 mg + Levocetirizine 5 mg Tablet', updated_at = NOW() WHERE id = 580; -- MONTERIO-LC TAB
UPDATE products SET salt_id = 55, composition = 'Oral Pharmaceutical Liquid Formulation', updated_at = NOW() WHERE id = 581; -- MUCORAZ SUSP
UPDATE products SET salt_id = 160, composition = 'Therapeutic Multivitamin & Multimineral Softgel Capsule', updated_at = NOW() WHERE id = 582; -- MULTIZOY CAP
UPDATE products SET salt_id = 153, composition = 'Mebeverine Hydrochloride 135 mg + Chlordiazepoxide 5 mg Tablet', updated_at = NOW() WHERE id = 583; -- MYCOLON -C
UPDATE products SET salt_id = 152, composition = 'Mebeverine Hydrochloride 200 mg Sustained Release Capsule', updated_at = NOW() WHERE id = 584; -- MYCOLON-SR CAP
UPDATE products SET salt_id = 161, composition = 'Silodosin 8 mg Capsule', updated_at = NOW() WHERE id = 585; -- MYSILO
UPDATE products SET salt_id = 162, composition = 'Silodosin 8 mg + Dutasteride 0.5 mg Capsule', updated_at = NOW() WHERE id = 586; -- MYSILO-D8 CAP
UPDATE products SET salt_id = 162, composition = 'Silodosin 8 mg + Dutasteride 0.5 mg Capsule', updated_at = NOW() WHERE id = 587; -- MYSILO-D8 CAPS
UPDATE products SET salt_id = 163, composition = 'Colistimethate Sodium 2 Million IU (2 MIU) IV/Inhalation Injection', updated_at = NOW() WHERE id = 588; -- MYXTIN-2 MIU
UPDATE products SET salt_id = 164, composition = 'N-Acetylcysteine 200 mg / ml (5 ml) Infusion Injection', updated_at = NOW() WHERE id = 589; -- NACYRES-5 INJ
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NEEFORTE ULTRA)', updated_at = NOW() WHERE id = 590; -- NEEFORTE ULTRA
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NEOLET-250)', updated_at = NOW() WHERE id = 591; -- NEOLET-250
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NEOLET-500 TAB)', updated_at = NOW() WHERE id = 592; -- NEOLET-500 TAB
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 60,000 IU Oral Formulation', updated_at = NOW() WHERE id = 593; -- NERVEE -CD3
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 60,000 IU Oral Formulation', updated_at = NOW() WHERE id = 594; -- NERVEE-CD3
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NETLOCK DISPOSABLE SKIN STAPLE)', updated_at = NOW() WHERE id = 595; -- NETLOCK DISPOSABLE SKIN STAPLE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NEUSIN-8 TAB)', updated_at = NOW() WHERE id = 596; -- NEUSIN-8 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NEUSIN-D 8 TAB)', updated_at = NOW() WHERE id = 597; -- NEUSIN-D 8 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NEUSIN-SF TAB)', updated_at = NOW() WHERE id = 598; -- NEUSIN-SF TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NEW ITEM)', updated_at = NOW() WHERE id = 599; -- new item
UPDATE products SET salt_id = 165, composition = 'Fluconazole 150 mg Tablet', updated_at = NOW() WHERE id = 600; -- NEXAFLUX
UPDATE products SET salt_id = 17, composition = 'Esomeprazole Magnesium Trihydrate 40 mg + Domperidone 30 mg SR Capsule', updated_at = NOW() WHERE id = 601; -- NEXBOOK-RD
UPDATE products SET salt_id = 166, composition = 'Gamma-Aminobutyric Acid (GABA) 100 mg + L-Theanine 100 mg + Magnesium Glycinate Tablet', updated_at = NOW() WHERE id = 602; -- NHS CALM
UPDATE products SET salt_id = 167, composition = 'Myo-Inositol 550 mg + D-Chiro Inositol 13.8 mg (40:1) with Folic Acid & Vitamin D3 Tablet', updated_at = NOW() WHERE id = 603; -- NHS CHIRO
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NICOBID-5 MG)', updated_at = NOW() WHERE id = 604; -- NICOBID-5 MG
UPDATE products SET salt_id = 168, composition = 'Nitrofurantoin 100 mg Modified Release Tablet', updated_at = NOW() WHERE id = 605; -- NIFUNAR 100
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NINDIA-10 TAB)', updated_at = NOW() WHERE id = 606; -- NINDIA-10 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NINDIA-5 TAB)', updated_at = NOW() WHERE id = 607; -- NINDIA-5 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NISHQ-M)', updated_at = NOW() WHERE id = 608; -- NISHQ-M
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NITASAFE-500)', updated_at = NOW() WHERE id = 609; -- NITASAFE-500
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NO ITEM)', updated_at = NOW() WHERE id = 610; -- NO ITEM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NOMIGAN-10 TAB)', updated_at = NOW() WHERE id = 611; -- NOMIGAN-10 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NOMIGAN-5MG TAB)', updated_at = NOW() WHERE id = 612; -- NOMIGAN-5MG TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NORGIC-25MG TAB)', updated_at = NOW() WHERE id = 613; -- NORGIC-25MG TAB
UPDATE products SET salt_id = 169, composition = 'Amoxicillin Trihydrate 500 mg + Potassium Clavulanate 125 mg Tablet', updated_at = NOW() WHERE id = 614; -- NOVAMOX CV 625
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NS 2180)', updated_at = NOW() WHERE id = 615; -- NS 2180
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 1, 180 cm)', updated_at = NOW() WHERE id = 616; -- Ns 2180 NETSORB 1 180cm
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (NS2180 SORB1 180 CM)', updated_at = NOW() WHERE id = 617; -- NS2180 SORB1 180 CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Suture Material (NS2304 NETSORB 4/0 70CM)', updated_at = NOW() WHERE id = 618; -- NS2304 NETSORB 4/0 70CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 2-0, 90 cm)', updated_at = NOW() WHERE id = 619; -- NS2317 NETSORB 2.0 90 CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 2-0, 45 cm)', updated_at = NOW() WHERE id = 620; -- NS2317 NETSORB 2/0 45 CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 0, 45 cm)', updated_at = NOW() WHERE id = 621; -- NS2346 NETSORB 045 CMS
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 1, 90 cm)', updated_at = NOW() WHERE id = 622; -- NS2347 DA 140 CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 2-0, 90 cm Heavy Needle)', updated_at = NOW() WHERE id = 623; -- NS2347 DA NETSORB 1140CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 3-0, 90 cm)', updated_at = NOW() WHERE id = 624; -- NS2347 NETSORB 1 90 CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 1, 70 cm Round Body)', updated_at = NOW() WHERE id = 625; -- NS2347 NETSORB 3/0 70CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 2-0, 70 cm Round Body)', updated_at = NOW() WHERE id = 626; -- NS2347+
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 3-0, 70 cm Cutting Needle)', updated_at = NOW() WHERE id = 627; -- NS2347+NETSORB
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 3-0, 45 cm Round Body)', updated_at = NOW() WHERE id = 628; -- NS2347+NETSORB 1 115CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 4-0, 70 cm Reverse Cutting)', updated_at = NOW() WHERE id = 629; -- NS2421 NETSORB 1 90CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Fast Absorbable Suture (Size 1, 90 cm)', updated_at = NOW() WHERE id = 630; -- NS2437 NETSORB 3/0 70CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Fast Absorbable Suture (Size 2-0, 90 cm)', updated_at = NOW() WHERE id = 631; -- NS3336 NETPLAST 2/0 110CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Fast Absorbable Suture (Size 3-0, 70 cm)', updated_at = NOW() WHERE id = 632; -- NTP-10 TAB
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Fast Absorbable Suture (Size 4-0, 70 cm)', updated_at = NOW() WHERE id = 633; -- NTP-5 TAB
UPDATE products SET salt_id = 170, composition = 'Mecobalamin 1500 mcg + Alpha Lipoic Acid 100 mg + Benfotiamine + Zinc Tablet', updated_at = NOW() WHERE id = 634; -- NUROKIND FORTE Z TAB 15''S
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture with Needle', updated_at = NOW() WHERE id = 635; -- NYA-D3 S.G
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 1, Loop 150 cm)', updated_at = NOW() WHERE id = 636; -- NYALIV-L TAB
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture with Heavy Needle', updated_at = NOW() WHERE id = 637; -- NYARABI-LS AP
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 2-0 Cutting)', updated_at = NOW() WHERE id = 638; -- NYLUS LNW 3317(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 3-0 Reverse Cutting)', updated_at = NOW() WHERE id = 639; -- NYLUS LNW 3318(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 0 Round Body)', updated_at = NOW() WHERE id = 640; -- NYLUS LNW 3328 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Absorbable Suture (Size 2-0 Round Body)', updated_at = NOW() WHERE id = 641; -- NYLUS LNW 3328L (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 642; -- NYLUS LNW 3328S (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 643; -- NYLUS LNW 3336 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 644; -- NYLUS LNW 3336EL (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 645; -- NYLUS LNW 3336L (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 646; -- NYLUS LNW 3336S (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 647; -- NYLUS LNW 3338 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 648; -- NYLUS LNW 3340(N)
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (NYLUS LNW3336L (N))', updated_at = NOW() WHERE id = 649; -- NYLUS LNW3336L (N)
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (NYLUS NLW 3708 (N))', updated_at = NOW() WHERE id = 650; -- NYLUS NLW 3708 (N)
UPDATE products SET salt_id = 171, composition = 'Obeticholic Acid 5 mg / 10 mg Tablet for Primary Biliary Cholangitis', updated_at = NOW() WHERE id = 651; -- OBEPPARALPHA
UPDATE products SET salt_id = 87, composition = 'Topical Formulation for External Use', updated_at = NOW() WHERE id = 652; -- OCGEL-O
UPDATE products SET salt_id = 6, composition = 'Omeprazole 20 mg Gastro-resistant Capsule', updated_at = NOW() WHERE id = 653; -- OCHEK CAP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (OFOLEN-200)', updated_at = NOW() WHERE id = 654; -- OFOLEN-200
UPDATE products SET salt_id = 41, composition = 'Ademetionine (S-Adenosyl L-Methionine) 400 mg Enteric Coated Tablet', updated_at = NOW() WHERE id = 655; -- OLAKINO 400
UPDATE products SET salt_id = 172, composition = 'Sodium Alginate 250 mg + Magnesium Hydroxide + Simethicone Chewable Tablet', updated_at = NOW() WHERE id = 656; -- OLEBEA GI TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (OLEE-MD 5 TAB)', updated_at = NOW() WHERE id = 657; -- OLEE-MD 5 TAB
UPDATE products SET salt_id = 43, composition = 'Amikacin Sulphate 500 mg / 2 ml IV/IM Injection', updated_at = NOW() WHERE id = 658; -- OMNIKACIN 500 INJ
UPDATE products SET salt_id = 74, composition = 'Calcium Carbonate 1250 mg + Vitamin D3 400 IU + Vitamin K2-7 50 mcg Effervescent Tube', updated_at = NOW() WHERE id = 659; -- OSTEOFIZZ-TUBE
UPDATE products SET salt_id = 173, composition = 'Calcium, Magnesium, Zinc, Vitamin D3 & Cissus quadrangularis Tablet for Pregnancy', updated_at = NOW() WHERE id = 660; -- OSTEOPEAK MOM
UPDATE products SET salt_id = 86, composition = 'Ondansetron Hydrochloride 2 mg / ml (4 mg) IV Injection', updated_at = NOW() WHERE id = 661; -- OTSKI IV
UPDATE products SET salt_id = 77, composition = 'Pancreatin (Enteric Coated Pellets) 10,000 USP Units Capsule', updated_at = NOW() WHERE id = 662; -- PANCREHENZ-10000
UPDATE products SET salt_id = 77, composition = 'Pancreatin (Enteric Coated Pellets) 25,000 USP Units Capsule', updated_at = NOW() WHERE id = 663; -- PANCREHENZ-25000
UPDATE products SET salt_id = 18, composition = 'Pantoprazole Sodium 80 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 664; -- PANSEC 80MG TAB
UPDATE products SET salt_id = 174, composition = 'Pantoprazole Sodium 40 mg + Levosulpiride 75 mg SR Capsule', updated_at = NOW() WHERE id = 665; -- PANSEC L CAP
UPDATE products SET salt_id = 18, composition = 'Pantoprazole Sodium 40 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 666; -- PANSEC TAB
UPDATE products SET salt_id = 175, composition = 'Pantoprazole Sodium 40 mg + Domperidone 30 mg SR Capsule', updated_at = NOW() WHERE id = 667; -- PANSEC-DSR CAP
UPDATE products SET salt_id = 18, composition = 'Pantoprazole Sodium 40 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 668; -- PANTAM 40 MG INJ
UPDATE products SET salt_id = 18, composition = 'Pantoprazole Sodium 40 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 669; -- PANTOACTIVE-DSR CAP
UPDATE products SET salt_id = 18, composition = 'Pantoprazole Sodium 40 mg Gastro-resistant Tablet', updated_at = NOW() WHERE id = 670; -- PANTOCLIFF-D (tab)
UPDATE products SET salt_id = 176, composition = 'Liquid Paraffin 1.25 ml + Milk of Magnesia 3.75 ml / 5 ml Suspension', updated_at = NOW() WHERE id = 671; -- PARAFIREN
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PAROXEE CR 12.5)', updated_at = NOW() WHERE id = 672; -- PAROXEE CR 12.5
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PAROXEE CR 25)', updated_at = NOW() WHERE id = 673; -- PAROXEE CR 25
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PAXITON-CR 12.5CTAB)', updated_at = NOW() WHERE id = 674; -- PAXITON-CR 12.5CTAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PEBON 40 IV)', updated_at = NOW() WHERE id = 675; -- PEBON 40 IV
UPDATE products SET salt_id = 71, composition = 'Liquid Paraffin 1.25 ml + Milk of Magnesia 3.75 ml + Sodium Picosulfate 3.33 mg / 5 ml Suspension', updated_at = NOW() WHERE id = 676; -- PEGEZE PLUS(DRUG)
UPDATE products SET salt_id = 72, composition = 'Polyethylene Glycol 3350 with Potassium Chloride, Sodium Bicarbonate & Sodium Chloride Oral Solution', updated_at = NOW() WHERE id = 677; -- PEGEZE SYP
UPDATE products SET salt_id = 72, composition = 'Polyethylene Glycol 3350 with Electrolytes Oral Solution', updated_at = NOW() WHERE id = 678; -- PEGFLEX SYRP
UPDATE products SET salt_id = 72, composition = 'Polyethylene Glycol 3350 with Balanced Electrolytes Oral Solution', updated_at = NOW() WHERE id = 679; -- PEGOVAG
UPDATE products SET salt_id = 72, composition = 'Polyethylene Glycol 3350 with Electrolytes Powder for Oral Solution', updated_at = NOW() WHERE id = 680; -- PEGOVAG-C
UPDATE products SET salt_id = 177, composition = 'Potassium Magnesium Citrate with Cranberry Extract Tablet', updated_at = NOW() WHERE id = 681; -- PELVI- Q
UPDATE products SET salt_id = 121, composition = 'Itopride Hydrochloride 50 mg Film Coated Tablet', updated_at = NOW() WHERE id = 682; -- PERIKINE
UPDATE products SET salt_id = 121, composition = 'Itopride Hydrochloride 150 mg Sustained Release Capsule', updated_at = NOW() WHERE id = 683; -- PERIKINE SR
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PERNIL LOTION (DPC))', updated_at = NOW() WHERE id = 684; -- PERNIL LOTION (DPC)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PEZTAZ 4.5G INJ)', updated_at = NOW() WHERE id = 685; -- PEZTAZ 4.5g inj
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PEZTAZ INJ 125 MG)', updated_at = NOW() WHERE id = 686; -- PEZTAZ INJ 125 MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PILE-C)', updated_at = NOW() WHERE id = 687; -- PILE-C
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PILOMEC CAPSULE)', updated_at = NOW() WHERE id = 688; -- PILOMEC CAPSULE
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PL 2079)', updated_at = NOW() WHERE id = 689; -- PL 2079
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PL 8709)', updated_at = NOW() WHERE id = 690; -- PL 8709
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PLAIN CUTGUT WN 2005(N))', updated_at = NOW() WHERE id = 691; -- PLAIN CUTGUT WN 2005(N)
UPDATE products SET salt_id = 178, composition = 'L-Carnitine L-Tartrate 800 mg + Natural Vitamin E 400 mg Tablet', updated_at = NOW() WHERE id = 692; -- PONOCARNIT-E 800 TAB
UPDATE products SET salt_id = 179, composition = 'L-Ornithine L-Aspartate + Reduced Glutathione IV Infusion', updated_at = NOW() WHERE id = 693; -- PONOLOA GLUTA IV
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PPMM1515 MACRO.MESH)', updated_at = NOW() WHERE id = 694; -- PPMM1515 MACRO.MESH
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PPMM715 MAC 7.6*15 CM)', updated_at = NOW() WHERE id = 695; -- PPMM715 MAC 7.6*15 CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PRACIN-SP TAB)', updated_at = NOW() WHERE id = 696; -- PRACIN-SP TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PREEGA M-75 SR)', updated_at = NOW() WHERE id = 697; -- PREEGA M-75 SR
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PREEGA-MNT)', updated_at = NOW() WHERE id = 698; -- PREEGA-MNT
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PREEGA-NT)', updated_at = NOW() WHERE id = 699; -- PREEGA-NT
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PREGARIO D-20)', updated_at = NOW() WHERE id = 700; -- PREGARIO D-20
UPDATE products SET salt_id = 180, composition = 'Potassium Citrate 1100 mg + Magnesium Citrate 375 mg + Pyridoxine 20 mg Syrup', updated_at = NOW() WHERE id = 701; -- PREV STONE B6 SYP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PRIDOPRU-2)', updated_at = NOW() WHERE id = 702; -- Pridopru-2
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PRO-AB MESH LAM 150)', updated_at = NOW() WHERE id = 703; -- PRO-AB MESH LAM 150
UPDATE products SET salt_id = 106, composition = 'Lactobacillus acidophilus, Bifidobacterium lactis & Fructooligosaccharides Capsule', updated_at = NOW() WHERE id = 704; -- PROGUT CAP
UPDATE products SET salt_id = 106, composition = 'Multi-strain Probiotics with Zinc & Prebiotics Sachet', updated_at = NOW() WHERE id = 705; -- PROGUT SACHET
UPDATE products SET salt_id = 181, composition = 'Lactic Acid Bacillus with L-Glutamine & Zinc Capsule', updated_at = NOW() WHERE id = 706; -- PROGUT-LB
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PROLAP NOVA TROCAR LNBT 5:1)', updated_at = NOW() WHERE id = 707; -- PROLAP NOVA TROCAR LNBT 5:1
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PROLAP NOVA TROCAR LNBT10:1)', updated_at = NOW() WHERE id = 708; -- PROLAP NOVA TROCAR LNBT10:1
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PROLAP NOVA TROCAR LNBT12:1)', updated_at = NOW() WHERE id = 709; -- PROLAP NOVA TROCAR LNBT12:1
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 710; -- PROLUS LNW 018 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 711; -- PROLUS LNW 802 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 712; -- PROLUS LNW 841 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 713; -- PROLUS LNW 843 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 714; -- PROLUS LNW 846 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 715; -- PROLUS LNW 848 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 716; -- PROLUS LNW 863(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 717; -- PROLUS LNW 881 (N)
UPDATE products SET salt_id = 182, composition = 'Monofilament Polypropylene Synthetic Non-absorbable Surgical Suture', updated_at = NOW() WHERE id = 718; -- PROLUS LPSS P(N)
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 719; -- PROLUS MESH LM 114-1
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 720; -- PROLUS MESH LM 114-6 (N)
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 721; -- PROLUS MESH LM 150-1
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 722; -- PROLUS MESH LM 225
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 723; -- PROLUS MESH LM 225-1
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 724; -- PROLUS MESHLM 114-1
UPDATE products SET salt_id = 182, composition = 'Monofilament Polypropylene Synthetic Non-absorbable Surgical Suture', updated_at = NOW() WHERE id = 725; -- PROLUS PL 8709 (N)
UPDATE products SET salt_id = 182, composition = 'Monofilament Polypropylene Synthetic Non-absorbable Surgical Suture', updated_at = NOW() WHERE id = 726; -- PROLUS PL 8735 (N)
UPDATE products SET salt_id = 182, composition = 'Monofilament Polypropylene Synthetic Non-absorbable Surgical Suture', updated_at = NOW() WHERE id = 727; -- PROLUS PL 878(N)
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 728; -- PROLUSH MESH LM 114-1 (N)
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 729; -- PROLUSH MESH LM 150-1 (N)
UPDATE products SET salt_id = 149, composition = 'Knitted Monofilament Polypropylene Surgical Mesh for Hernia Repair', updated_at = NOW() WHERE id = 730; -- PROLUSH MESH LM 66-1
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PROLYSATE PHR 10 ML(N))', updated_at = NOW() WHERE id = 731; -- PROLYSATE PHR 10 ML(N)
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PROLYSATE PHR 500 ML (N))', updated_at = NOW() WHERE id = 732; -- PROLYSATE PHR 500 ML (N)
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PROLYSTATE PHR 100 ML(N))', updated_at = NOW() WHERE id = 733; -- PROLYSTATE PHR 100 ML(N)
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PROSEC LPHS 32 (N))', updated_at = NOW() WHERE id = 734; -- PROSEC LPHS 32 (N)
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PROSEC LPHS 34(N))', updated_at = NOW() WHERE id = 735; -- PROSEC LPHS 34(N)
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PROSEC LPSS P (N))', updated_at = NOW() WHERE id = 736; -- PROSEC LPSS P (N)
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (PROSEC PREMUM LPSS 35WP)', updated_at = NOW() WHERE id = 737; -- PROSEC PREMUM LPSS 35WP
UPDATE products SET salt_id = 18, composition = 'Pantoprazole Sodium 40 mg Lyophilized IV Injection', updated_at = NOW() WHERE id = 738; -- PROTERA IV
UPDATE products SET salt_id = 175, composition = 'Pantoprazole Sodium 40 mg + Domperidone 30 mg SR Capsule', updated_at = NOW() WHERE id = 739; -- PROTERA-D CAP
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Surgical Suture with Needle', updated_at = NOW() WHERE id = 740; -- PROVICS LH3D225L (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Surgical Suture with Needle', updated_at = NOW() WHERE id = 741; -- PROVISC LH3D 150 (N)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PRUCRIDE - 2 TAB)', updated_at = NOW() WHERE id = 742; -- PRUCRIDE - 2 TAB
UPDATE products SET salt_id = 183, composition = 'Prucalopride Succinate 1 mg Film Coated Tablet', updated_at = NOW() WHERE id = 743; -- PRULAREN-1
UPDATE products SET salt_id = 183, composition = 'Prucalopride Succinate 2 mg Film Coated Tablet', updated_at = NOW() WHERE id = 744; -- PRULAREN-2
UPDATE products SET salt_id = 183, composition = 'Prucalopride Succinate 1 mg Film Coated Tablet', updated_at = NOW() WHERE id = 745; -- PRULITOP-1
UPDATE products SET salt_id = 183, composition = 'Prucalopride Succinate 2 mg Film Coated Tablet', updated_at = NOW() WHERE id = 746; -- PRULITOP-2 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PSYORID-1)', updated_at = NOW() WHERE id = 747; -- PSYORID-1
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PSYORID-PLUS-2MG TAB)', updated_at = NOW() WHERE id = 748; -- PSYORID-PLUS-2MG TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (PXR-12.5 MG)', updated_at = NOW() WHERE id = 749; -- PXR-12.5 MG
UPDATE products SET salt_id = 104, composition = 'Clarithromycin 500 mg + Amoxicillin 750 mg + Esomeprazole 40 mg Combi Kit', updated_at = NOW() WHERE id = 750; -- PYLOCIDE TAB
UPDATE products SET salt_id = 184, composition = 'Polydioxanone (PDO) Knotless Barbed Unidirectional Absorbable Suture (Size 2-0, 30 cm)', updated_at = NOW() WHERE id = 751; -- QBL315U20 PDX BARB 30 CM
UPDATE products SET salt_id = 184, composition = 'Polydioxanone (PDO) Knotless Barbed Unidirectional Absorbable Suture (Size 1-0, 30 cm)', updated_at = NOW() WHERE id = 752; -- QBL316U10 PDX BARB 30 CM
UPDATE products SET salt_id = 184, composition = 'Polydioxanone (PDO) Knotless Barbed Unidirectional Absorbable Suture (Size 1-0, 45 cm)', updated_at = NOW() WHERE id = 753; -- QBL326U10 PDX BARD 45CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Knotless Technology)', updated_at = NOW() WHERE id = 754; -- QL 2615 P KNOTED POLGL91
UPDATE products SET salt_id = 182, composition = 'Knitted Monofilament Polypropylene Surgical Hernia Mesh (15 x 15 cm)', updated_at = NOW() WHERE id = 755; -- QLM 151 PROLENE MESH 15*15 CM
UPDATE products SET salt_id = 182, composition = 'Knitted Monofilament Polypropylene Surgical Hernia Mesh (30 x 30 cm)', updated_at = NOW() WHERE id = 756; -- QLM 303 PROLENE M 30*30CM
UPDATE products SET salt_id = 182, composition = 'Knitted Monofilament Polypropylene Surgical Hernia Mesh (6 x 11 cm)', updated_at = NOW() WHERE id = 757; -- QLM 611-PROLENE MESH 6*11CM
UPDATE products SET salt_id = 182, composition = 'Knitted Monofilament Polypropylene Surgical Hernia Mesh (7.5 x 15 cm)', updated_at = NOW() WHERE id = 758; -- QLM 715-PROLENE MESH 7.6*15 CM
UPDATE products SET salt_id = 184, composition = 'Polydioxanone (PDS) Monofilament Synthetic Absorbable Suture (Size 1, Loop 150 cm)', updated_at = NOW() WHERE id = 759; -- QLMC 15*15 COMP MESH
UPDATE products SET salt_id = 184, composition = 'Polydioxanone (PDS) Monofilament Synthetic Absorbable Suture (Size 1, Loop 150 cm)', updated_at = NOW() WHERE id = 760; -- QLMC 15*20 COMP MESH
UPDATE products SET salt_id = 184, composition = 'Polydioxanone (PDS) Monofilament Synthetic Absorbable Suture (Size 1-0, Loop 150 cm)', updated_at = NOW() WHERE id = 761; -- QLMC 1520
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 1, Loop 150 cm)', updated_at = NOW() WHERE id = 762; -- QLMC 20*25 COMP MESH 20*20
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 1, Loop 150 cm)', updated_at = NOW() WHERE id = 763; -- QN 2180DA POLT1,180RB&T
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 1, 90 cm)', updated_at = NOW() WHERE id = 764; -- QN 2317 Polyglactin2-0, 90CM R
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 1, 90 cm)', updated_at = NOW() WHERE id = 765; -- QN 2347 Polyglactin 1,90 CM RB
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 2-0, 90 cm)', updated_at = NOW() WHERE id = 766; -- QN 2347DA/180
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 2-0, 90 cm)', updated_at = NOW() WHERE id = 767; -- QN 2347VS POLYGLACTIN 1.110CRB
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 0, 90 cm)', updated_at = NOW() WHERE id = 768; -- QN 2382 POLYGLACTIN
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 0, 90 cm)', updated_at = NOW() WHERE id = 769; -- QN 2421 Polyglactin 1, 90 C.R.
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 0, 70 cm)', updated_at = NOW() WHERE id = 770; -- QN 2437
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 0, 70 cm)', updated_at = NOW() WHERE id = 771; -- QN 3328 NYLON3-0,70 3/8 REV.C
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 2-0, 70 cm)', updated_at = NOW() WHERE id = 772; -- QN 3336 NYLON 2-0,70 3/8 REV.C
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 3-0, 70 cm)', updated_at = NOW() WHERE id = 773; -- QN 3336A
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 3-0, 70 cm)', updated_at = NOW() WHERE id = 774; -- QN 3336VS-NYLON 2-0,110CM RC
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 1, 70 cm)', updated_at = NOW() WHERE id = 775; -- QN 3338-NYLON 1, 100CM C.R.C
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 2-0, 70 cm)', updated_at = NOW() WHERE id = 776; -- QN 4228 GUT CHROMIC2 100CM CRB
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 2-0, 70 cm)', updated_at = NOW() WHERE id = 777; -- QN 4228 GUT CHROMIC2,100CM CRB
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 3-0, 70 cm)', updated_at = NOW() WHERE id = 778; -- QN 4241-GUT CHROMIC 2-0,76 R.B
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 3-0, 70 cm)', updated_at = NOW() WHERE id = 779; -- QN 4259-GUT CROMIC 1,76 RB
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 4-0, 70 cm)', updated_at = NOW() WHERE id = 780; -- QN 4259-GUT CROMIC 1,76 RB.
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 4-0, 70 cm)', updated_at = NOW() WHERE id = 781; -- QN 5087
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 1, 90 cm)', updated_at = NOW() WHERE id = 782; -- QN 5333-SILK SIZE 2-0, 76CM CR
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 1, 90 cm)', updated_at = NOW() WHERE id = 783; -- QN 838 70CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 2-0, 90 cm)', updated_at = NOW() WHERE id = 784; -- QN 843-PROLENE 1,70 1/2 R.B
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Suture (Size 2-0, 90 cm)', updated_at = NOW() WHERE id = 785; -- QN 878-PROLENE 6-0 45CM CRC
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Fast Absorbable Suture (Size 2-0, 70 cm)', updated_at = NOW() WHERE id = 786; -- QN01 2347
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Fast Absorbable Suture (Size 2-0, 70 cm)', updated_at = NOW() WHERE id = 787; -- QN30 2437
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Fast Absorbable Suture (Size 3-0, 70 cm)', updated_at = NOW() WHERE id = 788; -- QN40 2304
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Fast Absorbable Suture (Size 3-0, 70 cm)', updated_at = NOW() WHERE id = 789; -- QN40 2305
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Fast Absorbable Suture (Size 4-0, 70 cm)', updated_at = NOW() WHERE id = 790; -- QNT 622
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Fast Absorbable Suture (Size 4-0, 70 cm)', updated_at = NOW() WHERE id = 791; -- QUEENCY 25 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (QUEENCY 50 TAB)', updated_at = NOW() WHERE id = 792; -- QUEENCY 50 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (QUEENCY-SR 100 TAB)', updated_at = NOW() WHERE id = 793; -- QUEENCY-SR 100 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (QUETALENT SR-200)', updated_at = NOW() WHERE id = 794; -- QUETALENT SR-200
UPDATE products SET salt_id = 185, composition = 'Fungal Diastase 50 mg + Pepsin 10 mg Digestive Enzyme Tablet', updated_at = NOW() WHERE id = 795; -- QUROZYMETAB
UPDATE products SET salt_id = 94, composition = 'Rabeprazole Sodium 20 mg + Domperidone 30 mg SR Capsule', updated_at = NOW() WHERE id = 796; -- RABFORGR-D
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RABTYX DSR)', updated_at = NOW() WHERE id = 797; -- RABTYX DSR
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RABTYX-20 TAB)', updated_at = NOW() WHERE id = 798; -- RABTYX-20 TAB
UPDATE products SET salt_id = 150, composition = 'Ramosetron Hydrochloride 2.5 mcg / 5 mcg Tablet', updated_at = NOW() WHERE id = 799; -- RAMLAREN
UPDATE products SET salt_id = 150, composition = 'Ramosetron Hydrochloride 2.5 mcg Tablet', updated_at = NOW() WHERE id = 800; -- RAMOFORGE TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RANHOX-500)', updated_at = NOW() WHERE id = 801; -- RANHOX-500
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RAVE 3 SYRUP 200)', updated_at = NOW() WHERE id = 802; -- RAVE 3 SYRUP 200
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RAYGNEX INJ)', updated_at = NOW() WHERE id = 803; -- RAYGNEX INJ
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 60,000 IU Oral Formulation', updated_at = NOW() WHERE id = 804; -- RAYMIN D3 60K
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RAYMIN GOLD TABLET)', updated_at = NOW() WHERE id = 805; -- RAYMIN GOLD TABLET
UPDATE products SET salt_id = 55, composition = 'Oral Pharmaceutical Liquid Formulation', updated_at = NOW() WHERE id = 806; -- RAYMIN SYP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RAYMIN XT)', updated_at = NOW() WHERE id = 807; -- RAYMIN XT
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RAYMIN-LC)', updated_at = NOW() WHERE id = 808; -- RAYMIN-LC
UPDATE products SET salt_id = 55, composition = 'Oral Pharmaceutical Liquid Formulation', updated_at = NOW() WHERE id = 809; -- RAYMIN-XT-SYP
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 60,000 IU Oral Solution 5 ml', updated_at = NOW() WHERE id = 810; -- RAYSHOT-D3 60K SOL
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (REBIKA D)', updated_at = NOW() WHERE id = 811; -- REBIKA D
UPDATE products SET salt_id = 186, composition = 'Rebamipide 100 mg Film Coated Tablet', updated_at = NOW() WHERE id = 812; -- REBQUENCH
UPDATE products SET salt_id = 187, composition = 'Bioactive Collagen Peptide Type II + Glucosamine Sulphate + Chondroitin + Rosehip Extract Sachet', updated_at = NOW() WHERE id = 813; -- REFLEX 360
UPDATE products SET salt_id = 188, composition = 'Palmitoylethanolamide (PEA) 300 mg + Alpha Lipoic Acid 100 mg + Vitamin B-Complex Tablet', updated_at = NOW() WHERE id = 814; -- REFLEX NEU
UPDATE products SET salt_id = 189, composition = '100% Soy-based Whole Protein Elemental Nutrition for Inflammatory Bowel Disease 400 gm Jar', updated_at = NOW() WHERE id = 815; -- REMATIN IBD400 GM JAR
UPDATE products SET salt_id = 145, composition = 'Specialized Nutritional Supplement for Chronic Liver Disease (Chocolate Flavor) 400 gm Jar', updated_at = NOW() WHERE id = 816; -- REMATIN LIV CHOC JAR
UPDATE products SET salt_id = 145, composition = 'Specialized Nutritional Supplement for Chronic Liver Disease (Vanilla Flavor) 400 gm', updated_at = NOW() WHERE id = 817; -- REMATIN LIV- VANILLA
UPDATE products SET salt_id = 190, composition = '100% Hydrolyzed Whey Peptide High-Calorie Enteral Nutrition', updated_at = NOW() WHERE id = 818; -- REMATIN PLUS PEPTIDE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (REMOIZ-C LOTION 100 ML)', updated_at = NOW() WHERE id = 819; -- REMOIZ-C LOTION 100 ML
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RENOSALT-400)', updated_at = NOW() WHERE id = 820; -- RENOSALT-400
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RESQUE -LS)', updated_at = NOW() WHERE id = 821; -- RESQUE -LS
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RESTORED -C TAB)', updated_at = NOW() WHERE id = 822; -- RESTORED -C TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (REYRAB 20 MG TAB)', updated_at = NOW() WHERE id = 823; -- REYRAB 20 MG TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (REYRAB D CAPSULE)', updated_at = NOW() WHERE id = 824; -- REYRAB D CAPSULE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (REYRAB L CAPSULE)', updated_at = NOW() WHERE id = 825; -- REYRAB L CAPSULE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (REYWELL SAC 3GM)', updated_at = NOW() WHERE id = 826; -- REYWELL SAC 3GM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (REZACORT TABLET)', updated_at = NOW() WHERE id = 827; -- REZACORT TABLET
UPDATE products SET salt_id = 85, composition = 'Rifaximin 400 mg Film Coated Tablet', updated_at = NOW() WHERE id = 828; -- RIFABIZ-400 TAB
UPDATE products SET salt_id = 85, composition = 'Rifaximin 550 mg Film Coated Tablet', updated_at = NOW() WHERE id = 829; -- RIFABIZ-550 TAB
UPDATE products SET salt_id = 85, composition = 'Rifaximin 400 mg Film Coated Tablet', updated_at = NOW() WHERE id = 830; -- RIFALEVEN 400
UPDATE products SET salt_id = 85, composition = 'Rifaximin 550 mg Film Coated Tablet', updated_at = NOW() WHERE id = 831; -- RIFALEVEN-550
UPDATE products SET salt_id = 85, composition = 'Rifaximin 200 mg Film Coated Tablet', updated_at = NOW() WHERE id = 832; -- RIFAXIGRESS 200
UPDATE products SET salt_id = 85, composition = 'Rifaximin 400 mg Film Coated Tablet', updated_at = NOW() WHERE id = 833; -- RIFAXIGRESS 400
UPDATE products SET salt_id = 85, composition = 'Rifaximin 550 mg Film Coated Tablet', updated_at = NOW() WHERE id = 834; -- RIFAXIGRESS 550 TAB
UPDATE products SET salt_id = 85, composition = 'Rifaximin 400 mg / 550 mg Film Coated Tablet', updated_at = NOW() WHERE id = 835; -- RIFAXIWELL-550
UPDATE products SET salt_id = 85, composition = 'Rifaximin 400 mg Film Coated Tablet', updated_at = NOW() WHERE id = 836; -- RIFSET 400
UPDATE products SET salt_id = 85, composition = 'Rifaximin 550 mg Film Coated Tablet', updated_at = NOW() WHERE id = 837; -- RIFSET-550
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RILAXO 100GM)', updated_at = NOW() WHERE id = 838; -- RILAXO 100GM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RIMA-Q TAB)', updated_at = NOW() WHERE id = 839; -- RIMA-Q TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RISPEE 1 TAB)', updated_at = NOW() WHERE id = 840; -- RISPEE 1 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RISPEE FORT TAB)', updated_at = NOW() WHERE id = 841; -- RISPEE FORT TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (RL FFS (SPPL))', updated_at = NOW() WHERE id = 842; -- RL FFS (SPPL)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ROSETYX TAB)', updated_at = NOW() WHERE id = 843; -- ROSETYX TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ROSONIM F10)', updated_at = NOW() WHERE id = 844; -- ROSONIM F10
UPDATE products SET salt_id = 191, composition = 'Rosuvastatin Calcium 10 mg Tablet', updated_at = NOW() WHERE id = 845; -- ROSUFAB F
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ROZY CV 10 MG)', updated_at = NOW() WHERE id = 846; -- ROZY CV 10 MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ROZY CV 20 MG)', updated_at = NOW() WHERE id = 847; -- ROZY CV 20 MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ROZY F)', updated_at = NOW() WHERE id = 848; -- ROZY F
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ROZY GOLD 10)', updated_at = NOW() WHERE id = 849; -- ROZY GOLD 10
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ROZY GOLD 20)', updated_at = NOW() WHERE id = 850; -- ROZY GOLD 20
UPDATE products SET salt_id = 192, composition = 'Ceftriaxone Sodium 1000 mg + Sulbactam Sodium 500 mg (1.5 gm) IV/IM Injection', updated_at = NOW() WHERE id = 851; -- RUAJ S-1.5
UPDATE products SET salt_id = 193, composition = 'Ceftriaxone Sodium 1000 mg (1 gm) IV/IM Injection', updated_at = NOW() WHERE id = 852; -- RUAJ-1
UPDATE products SET salt_id = 194, composition = 'Amlodipine Besylate 5 mg Tablet', updated_at = NOW() WHERE id = 853; -- SAMLOL XP
UPDATE products SET salt_id = 195, composition = 'Ursodeoxycholic Acid 150 mg Tablet', updated_at = NOW() WHERE id = 854; -- SEDOGEST 150
UPDATE products SET salt_id = 195, composition = 'Ursodeoxycholic Acid 300 mg Tablet', updated_at = NOW() WHERE id = 855; -- SEDOGEST 300 TAB
UPDATE products SET salt_id = 195, composition = 'Ursodeoxycholic Acid 450 mg Sustained Release Tablet', updated_at = NOW() WHERE id = 856; -- SEDOGEST 450 SR
UPDATE products SET salt_id = 18, composition = 'Pantoprazole Sodium 40 mg Extended Release Tablet', updated_at = NOW() WHERE id = 857; -- SEGERA ER-40
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SERTEE 50)', updated_at = NOW() WHERE id = 858; -- SERTEE 50
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SERTWEET 50 TAB)', updated_at = NOW() WHERE id = 859; -- SERTWEET 50 TAB
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 860; -- SILKUS LNW 5036 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 861; -- SILKUS LNW 5036L
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 862; -- SILKUS LNW 5062 N
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 863; -- SILKUS LNW 5063 N
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 864; -- SILKUS LNW 5087(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 865; -- SILKUS LNW 5290(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 866; -- SILKUS LNW 5331
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 867; -- SILKUS LNW 5332(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 868; -- SILKUS LNW 5333 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 869; -- SILKUS LNW 5533 (N)
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (SILKUS REEL LR 825(N))', updated_at = NOW() WHERE id = 870; -- SILKUS REEL LR 825(N)
UPDATE products SET salt_id = 98, composition = 'Spores of Polyantibiotic-resistant Bacillus clausii 2 Billion Spores Suspension', updated_at = NOW() WHERE id = 871; -- SIMGUT
UPDATE products SET salt_id = 98, composition = 'Spores of Polyantibiotic-resistant Bacillus clausii 2 Billion Spores Capsule', updated_at = NOW() WHERE id = 872; -- SIMGUT CAP10S
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SITALENT M(50+500))', updated_at = NOW() WHERE id = 873; -- SITALENT M(50+500)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SIZE 2 4228)', updated_at = NOW() WHERE id = 874; -- SIZE 2 4228
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SIZE 2 4228 100)', updated_at = NOW() WHERE id = 875; -- SIZE 2 4228 100
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SKIN GLUE)', updated_at = NOW() WHERE id = 876; -- SKIN GLUE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SOBITAB-1000)', updated_at = NOW() WHERE id = 877; -- SOBITAB-1000
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SOBITAB-500)', updated_at = NOW() WHERE id = 878; -- SOBITAB-500
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SOCIN-10 TAB)', updated_at = NOW() WHERE id = 879; -- SOCIN-10 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SOCIN-5 TAB)', updated_at = NOW() WHERE id = 880; -- SOCIN-5 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SODIUM CHLORIDE:IP-0.9% W/V IN)', updated_at = NOW() WHERE id = 881; -- SODIUM CHLORIDE:IP-0.9% W/V IN
UPDATE products SET salt_id = 196, composition = 'Lactitol Monohydrate 10 gm + Ispaghula Husk 3.5 gm / 15 gm Powder', updated_at = NOW() WHERE id = 882; -- SOFTOLAX LIQUIFIBRE
UPDATE products SET salt_id = 197, composition = 'Solifenacin Succinate 10 mg Film Coated Tablet', updated_at = NOW() WHERE id = 883; -- SOLIBEST 10MG
UPDATE products SET salt_id = 197, composition = 'Solifenacin Succinate 5 mg Film Coated Tablet', updated_at = NOW() WHERE id = 884; -- SOLIBEST 5MG
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (SOLUS LAM 2317-910+(N))', updated_at = NOW() WHERE id = 885; -- SOLUS LAM 2317-910+(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 886; -- SOLUS LNW 2140GF-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 887; -- SOLUS LNW 2180GF (PGA (N))
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 888; -- SOLUS LNW 2303-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 889; -- SOLUS LNW 2304-910(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 890; -- SOLUS LNW 2305-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 891; -- SOLUS LNW 2317-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 892; -- SOLUS LNW 2317M-910(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 893; -- SOLUS LNW 2328-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 894; -- SOLUS LNW 2346-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 895; -- SOLUS LNW 2347 M-910(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 896; -- SOLUS LNW 2347VS (PGA)(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 897; -- SOLUS LNW 2347VS-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 898; -- SOLUS LNW 2352-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 899; -- SOLUS LNW 2359-910
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 900; -- SOLUS LNW 2382-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 901; -- SOLUS LNW 2401-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 902; -- SOLUS LNW 2421-910(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 903; -- SOLUS LNW 2437-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 904; -- SOLUS LNW 2493-910(N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 905; -- SOLUS LNW 2494-910(N)
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (SOLUS LNW2347VS-910 (N))', updated_at = NOW() WHERE id = 906; -- SOLUS LNW2347VS-910 (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 907; -- SOLUS SWFIT LNW 2762 ML (N)
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Braided Coated Synthetic Absorbable Surgical Suture', updated_at = NOW() WHERE id = 908; -- SOLUS SWIFT LNW 2762(N)
UPDATE products SET salt_id = 151, composition = 'Surgical Suture / Device Material (SOLUS WNL 2150-910)', updated_at = NOW() WHERE id = 909; -- SOLUS WNL 2150-910
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 60,000 IU Nano Shots Oral Solution', updated_at = NOW() WHERE id = 910; -- SOLYA D3 NANO
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP 2382)', updated_at = NOW() WHERE id = 911; -- SP 2382
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP 2761F NETCRYL FAST 0 100CM)', updated_at = NOW() WHERE id = 912; -- SP 2761F NETCRYL FAST 0 100CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP 3328 NETPLAST 3/0 100CMS)', updated_at = NOW() WHERE id = 913; -- SP 3328 NETPLAST 3/0 100CMS
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP 3328M 70 CM)', updated_at = NOW() WHERE id = 914; -- SP 3328M 70 CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP 3336 NETPLAST 2/0 110)', updated_at = NOW() WHERE id = 915; -- SP 3336 NETPLAST 2/0 110
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP 3338)', updated_at = NOW() WHERE id = 916; -- SP 3338
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP 4228)', updated_at = NOW() WHERE id = 917; -- SP 4228
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP 4259NETGUT 1 76 CM)', updated_at = NOW() WHERE id = 918; -- SP 4259NETGUT 1 76 CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP 5070 NETSILK 3/0 90 CM)', updated_at = NOW() WHERE id = 919; -- SP 5070 NETSILK 3/0 90 CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP 843 NETLENE)', updated_at = NOW() WHERE id = 920; -- SP 843 NETLENE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP 883 NETLENE 11OO CM)', updated_at = NOW() WHERE id = 921; -- SP 883 NETLENE 11OO CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP-METRO)', updated_at = NOW() WHERE id = 922; -- SP-METRO
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP2382 NETCRY 2-0L 90CM)', updated_at = NOW() WHERE id = 923; -- SP2382 NETCRY 2-0L 90CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP2421 NETCRYL 1 90CM)', updated_at = NOW() WHERE id = 924; -- SP2421 NETCRYL 1 90CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP3317 NETPLAST 5/0)', updated_at = NOW() WHERE id = 925; -- SP3317 NETPLAST 5/0
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP3328)', updated_at = NOW() WHERE id = 926; -- SP3328
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP3328 M NETPLAST3/0 70 CM)', updated_at = NOW() WHERE id = 927; -- SP3328 M NETPLAST3/0 70 CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP3328 M NETPLAST3/0 70CM)', updated_at = NOW() WHERE id = 928; -- SP3328 M NETPLAST3/0 70CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP3328 NETPLAST 3/0 100 CM)', updated_at = NOW() WHERE id = 929; -- SP3328 NETPLAST 3/0 100 CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP3336)', updated_at = NOW() WHERE id = 930; -- SP3336
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP3336 M NETPLAST 2/0 70 CM)', updated_at = NOW() WHERE id = 931; -- SP3336 M NETPLAST 2/0 70 CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP3336 NETPLAST 2/0 110 CMS)', updated_at = NOW() WHERE id = 932; -- SP3336 NETPLAST 2/0 110 CMS
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP3336M NETPLAST 2/0 70 CM)', updated_at = NOW() WHERE id = 933; -- SP3336M NETPLAST 2/0 70 CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP3336NEPT 2/0 70CM)', updated_at = NOW() WHERE id = 934; -- SP3336NEPT 2/0 70CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP4228)', updated_at = NOW() WHERE id = 935; -- SP4228
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP4228 NETGUT 2 100)', updated_at = NOW() WHERE id = 936; -- SP4228 NETGUT 2 100
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP4237)', updated_at = NOW() WHERE id = 937; -- SP4237
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP4241)', updated_at = NOW() WHERE id = 938; -- SP4241
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP4241 NETGUT 2/0 76CM)', updated_at = NOW() WHERE id = 939; -- SP4241 NETGUT 2/0 76CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP4241 NETGUT2/0 76)', updated_at = NOW() WHERE id = 940; -- SP4241 NETGUT2/0 76
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP4242 NETGUT 076)', updated_at = NOW() WHERE id = 941; -- SP4242 NETGUT 076
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP4259 NETGUT 2/0 1 76 CM)', updated_at = NOW() WHERE id = 942; -- SP4259 NETGUT 2/0 1 76 CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP5036 NETSILK 2/0 90CMS)', updated_at = NOW() WHERE id = 943; -- SP5036 NETSILK 2/0 90CMS
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP5037 NETSILK)', updated_at = NOW() WHERE id = 944; -- SP5037 NETSILK
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP5333 NETSILK 2/0 90 CMS)', updated_at = NOW() WHERE id = 945; -- SP5333 NETSILK 2/0 90 CMS
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP841 NETLENE 2/0 90CM)', updated_at = NOW() WHERE id = 946; -- SP841 NETLENE 2/0 90CM
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Absorbable Suture (SP843 NETLENE 100 CMS)', updated_at = NOW() WHERE id = 947; -- SP843 NETLENE 100 CMS
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP843 NETLENE 170 CM)', updated_at = NOW() WHERE id = 948; -- SP843 NETLENE 170 CM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP905 NETPLAST 12*76)', updated_at = NOW() WHERE id = 949; -- SP905 NETPLAST 12*76
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SP9262 NETSYNTH 1 150CM LOOP)', updated_at = NOW() WHERE id = 950; -- SP9262 NETSYNTH 1 150CM LOOP
UPDATE products SET salt_id = 19, composition = 'Ubiquinol 100 mg + L-Carnitine + Lycopene + Zinc + Astaxanthin Tablet', updated_at = NOW() WHERE id = 951; -- SPERMIZZ
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SPLYTE)', updated_at = NOW() WHERE id = 952; -- SPLYTE
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SPM 0815)', updated_at = NOW() WHERE id = 953; -- SPM 0815
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SR TRADING COMPANY)', updated_at = NOW() WHERE id = 954; -- SR TRADING COMPANY
UPDATE products SET salt_id = 21, composition = 'Polyglactin 910 Synthetic Suture Material (SS35WFR-ST.SKIN STAPLERW/O RE)', updated_at = NOW() WHERE id = 955; -- SS35WFR-ST.SKIN STAPLERW/O RE
UPDATE products SET salt_id = 180, composition = 'Potassium Citrate 1100 mg + Magnesium Citrate 375 mg + Pyridoxine HCl 20 mg / 5 ml', updated_at = NOW() WHERE id = 956; -- STONE 1 B6 ORAL SOLN
UPDATE products SET salt_id = 198, composition = 'Sucralfate 1000 mg + Oxetacaine 20 mg / 10 ml Suspension', updated_at = NOW() WHERE id = 957; -- SUCRALHENZ
UPDATE products SET salt_id = 55, composition = 'Oral Pharmaceutical Liquid Formulation', updated_at = NOW() WHERE id = 958; -- SUCRATAL-OSUSP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (SUCROF-O)', updated_at = NOW() WHERE id = 959; -- SUCROF-O
UPDATE products SET salt_id = 199, composition = 'Cefoperazone Sodium 1000 mg + Sulbactam Sodium 500 mg Injection', updated_at = NOW() WHERE id = 960; -- SULTAREN
UPDATE products SET salt_id = 48, composition = 'Tamsulosin Hydrochloride 0.4 mg Prolonged Release Capsule', updated_at = NOW() WHERE id = 961; -- SUMOCETAM SYRUP
UPDATE products SET salt_id = 48, composition = 'Tamsulosin Hydrochloride 0.4 mg Prolonged Release Capsule', updated_at = NOW() WHERE id = 962; -- SUMOCETAM-800
UPDATE products SET salt_id = 200, composition = 'Saccharomyces boulardii 250 mg Probiotic Capsule', updated_at = NOW() WHERE id = 963; -- SYMBULARDI
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TAB. DUTOL)', updated_at = NOW() WHERE id = 964; -- TAB. DUTOL
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TAB.AMOLA-AT)', updated_at = NOW() WHERE id = 965; -- TAB.AMOLA-AT
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TAB.NEURAIN-NT PLUS)', updated_at = NOW() WHERE id = 966; -- TAB.NEURAIN-NT PLUS
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TAB.TELICARD-40)', updated_at = NOW() WHERE id = 967; -- TAB.TELICARD-40
UPDATE products SET salt_id = 201, composition = 'Tadalafil 10 mg Tablet', updated_at = NOW() WHERE id = 968; -- TADLONG 10 MG
UPDATE products SET salt_id = 201, composition = 'Tadalafil 5 mg Tablet', updated_at = NOW() WHERE id = 969; -- TADLONG 5MG
UPDATE products SET salt_id = 201, composition = 'Tadalafil 20 mg Tablet', updated_at = NOW() WHERE id = 970; -- TADLONG-20
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TALMAJAS-40)', updated_at = NOW() WHERE id = 971; -- TALMAJAS-40
UPDATE products SET salt_id = 48, composition = 'Tamsulosin Hydrochloride 0.4 mg Prolonged Release Tablet', updated_at = NOW() WHERE id = 972; -- TAMGRESS-0.4
UPDATE products SET salt_id = 202, composition = 'Tamsulosin Hydrochloride 0.4 mg + Dutasteride 0.5 mg Tablet', updated_at = NOW() WHERE id = 973; -- TAMGRESS-D
UPDATE products SET salt_id = 203, composition = 'Piperacillin Sodium 4000 mg + Tazobactam Sodium 500 mg (4.5 gm) IV Infusion', updated_at = NOW() WHERE id = 974; -- TAZOREN
UPDATE products SET salt_id = 204, composition = 'Teicoplanin 200 mg IV/IM Injection', updated_at = NOW() WHERE id = 975; -- TEICOGRESS-200
UPDATE products SET salt_id = 204, composition = 'Teicoplanin 400 mg IV/IM Injection', updated_at = NOW() WHERE id = 976; -- TEICOGRESS-400
UPDATE products SET salt_id = 205, composition = 'Telmisartan 40 mg Tablet', updated_at = NOW() WHERE id = 977; -- TELMIKIND 40 TAB 10''S
UPDATE products SET salt_id = 206, composition = 'Telmisartan 40 mg + Chlorthalidone 12.5 mg Tablet', updated_at = NOW() WHERE id = 978; -- TELMIKIND CT 40 TAB 10''S
UPDATE products SET salt_id = 205, composition = 'Telmisartan 40 mg Tablet', updated_at = NOW() WHERE id = 979; -- TELMITAL A
UPDATE products SET salt_id = 205, composition = 'Telmisartan 40 mg Tablet', updated_at = NOW() WHERE id = 980; -- TELMITAL BETA 25
UPDATE products SET salt_id = 205, composition = 'Telmisartan 40 mg Tablet', updated_at = NOW() WHERE id = 981; -- TELMITAL CT
UPDATE products SET salt_id = 205, composition = 'Telmisartan 40 mg Tablet', updated_at = NOW() WHERE id = 982; -- TELMITAL LN
UPDATE products SET salt_id = 205, composition = 'Telmisartan 40 mg Tablet', updated_at = NOW() WHERE id = 983; -- TELMITAL LN BETA 25
UPDATE products SET salt_id = 205, composition = 'Telmisartan 40 mg Tablet', updated_at = NOW() WHERE id = 984; -- TELMITAL40 (dpco)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TENEE M-500)', updated_at = NOW() WHERE id = 985; -- TENEE M-500
UPDATE products SET salt_id = 87, composition = 'Topical Formulation for External Use', updated_at = NOW() WHERE id = 986; -- THALAIVA GEL
UPDATE products SET salt_id = 124, composition = 'Reduced Glutathione 600 mg Lyophilized IV Injection', updated_at = NOW() WHERE id = 987; -- THIOHIGH INJ
UPDATE products SET salt_id = 124, composition = 'Reduced Glutathione 600 mg IV Injection with Sterile Water', updated_at = NOW() WHERE id = 988; -- THIOTRES INJ
UPDATE products SET salt_id = 207, composition = 'Alpha Lipoic Acid 100 mg + Methylcobalamin 1500 mcg + Pyridoxine Tablet', updated_at = NOW() WHERE id = 989; -- THIOTRES-TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TIOCIF)', updated_at = NOW() WHERE id = 990; -- TIOCIF
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TITANIA MESH 1''S PACK)', updated_at = NOW() WHERE id = 991; -- TITANIA MESH 1''S PACK
UPDATE products SET salt_id = 85, composition = 'Rifaximin 400 mg Film Coated Tablet', updated_at = NOW() WHERE id = 992; -- TIZIREN
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TOCOFRE-400)', updated_at = NOW() WHERE id = 993; -- TOCOFRE-400
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TOCOFRE-E)', updated_at = NOW() WHERE id = 994; -- TOCOFRE-E
UPDATE products SET salt_id = 208, composition = 'Wheat Germ Oil (Natural Vitamin E) with Tocotrienols 400 mg Softgel', updated_at = NOW() WHERE id = 995; -- TOCOSURE SOFTGEL CAP
UPDATE products SET salt_id = 209, composition = 'Tofacitinib Citrate 5 mg Film Coated Tablet', updated_at = NOW() WHERE id = 996; -- TOFAHENZ
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TRECOCIT PLUS TAB)', updated_at = NOW() WHERE id = 997; -- TRECOCIT PLUS TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TRECOCIT-500 TAB)', updated_at = NOW() WHERE id = 998; -- TRECOCIT-500 TAB
UPDATE products SET salt_id = 137, composition = 'Teneligliptin Hydrobromide Hydrate 20 mg Tablet', updated_at = NOW() WHERE id = 999; -- TRELAHENZ 100
UPDATE products SET salt_id = 137, composition = 'Teneligliptin Hydrobromide Hydrate 20 mg Tablet', updated_at = NOW() WHERE id = 1000; -- TRELAHENZ 50
UPDATE products SET salt_id = 210, composition = 'Terlipressin Acetate 1 mg / 2 ml IV Injection', updated_at = NOW() WHERE id = 1001; -- TRESFIX INJ 2ML
UPDATE products SET salt_id = 210, composition = 'Somatostatin / Vasoactive Peptide Analog Tablet', updated_at = NOW() WHERE id = 1002; -- TRESFIX TAB. 15''S
UPDATE products SET salt_id = 211, composition = 'L-Glutathione 500 mg + Vitamin C + Alpha Lipoic Acid Tablet', updated_at = NOW() WHERE id = 1003; -- TRIGLUTA TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TRIPLENT 10 (DPCO))', updated_at = NOW() WHERE id = 1004; -- TRIPLENT 10 (DPCO)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TRIXIDE H (NRX))', updated_at = NOW() WHERE id = 1005; -- TRIXIDE H (NRX)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TRUZET-D TAB)', updated_at = NOW() WHERE id = 1006; -- TRUZET-D TAB
UPDATE products SET salt_id = 61, composition = 'Calcium Carbonate with Vitamin D3 & Minerals Tablet', updated_at = NOW() WHERE id = 1007; -- TWEECALM PLUS TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TWIGRAIN PLUS TAB)', updated_at = NOW() WHERE id = 1008; -- TWIGRAIN PLUS TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (TWIXIDE-H TAB NRX)', updated_at = NOW() WHERE id = 1009; -- TWIXIDE-H TAB NRx
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (U-OFLO-OZ)', updated_at = NOW() WHERE id = 1010; -- U-OFLO-OZ
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (UBLACTIN APPETIZER)', updated_at = NOW() WHERE id = 1011; -- UBLACTIN APPETIZER
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (UCONJA SG)', updated_at = NOW() WHERE id = 1012; -- UCONJA SG
UPDATE products SET salt_id = 195, composition = 'Ursodeoxycholic Acid 300 mg Film Coated Tablet', updated_at = NOW() WHERE id = 1013; -- UDGRACE-300 TAB
UPDATE products SET salt_id = 195, composition = 'Ursodeoxycholic Acid 300 mg Film Coated Tablet', updated_at = NOW() WHERE id = 1014; -- UDISTRONG
UPDATE products SET salt_id = 168, composition = 'Nitrofurantoin 100 mg Modified Release Tablet', updated_at = NOW() WHERE id = 1015; -- URIFAST TABS
UPDATE products SET salt_id = 48, composition = 'Tamsulosin Hydrochloride 0.4 mg Modified Release Capsule', updated_at = NOW() WHERE id = 1016; -- URIMAX 0.4 MG
UPDATE products SET salt_id = 202, composition = 'Tamsulosin Hydrochloride 0.4 mg + Dutasteride 0.5 mg Tablet', updated_at = NOW() WHERE id = 1017; -- URIMAX D 30S TAB
UPDATE products SET salt_id = 212, composition = 'Tamsulosin Hydrochloride 0.4 mg + Tadalafil 5 mg Tablet', updated_at = NOW() WHERE id = 1018; -- URIMAX T 5 TABS
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (URLO-100 TAB)', updated_at = NOW() WHERE id = 1019; -- URLO-100 TAB
UPDATE products SET salt_id = 213, composition = 'Potassium Magnesium Citrate 978 mg + D-Mannose 300 mg + Cranberry Extract 200 mg Tablet', updated_at = NOW() WHERE id = 1020; -- UROFIZZ AL
UPDATE products SET salt_id = 214, composition = 'Potassium Magnesium Citrate + Cranberry Extract + D-Mannose Effervescent Sachet', updated_at = NOW() WHERE id = 1021; -- UROFIZZ SACHET
UPDATE products SET salt_id = 195, composition = 'Ursodeoxycholic Acid 300 mg Film Coated Tablet', updated_at = NOW() WHERE id = 1022; -- URSNUL TAB
UPDATE products SET salt_id = 195, composition = 'Ursodeoxycholic Acid 300 mg Tablet', updated_at = NOW() WHERE id = 1023; -- URSOPLEX 300
UPDATE products SET salt_id = 195, composition = 'Ursodeoxycholic Acid 450 mg Sustained Release Tablet', updated_at = NOW() WHERE id = 1024; -- URSOPLEX 450
UPDATE products SET salt_id = 195, composition = 'Ursodeoxycholic Acid 300 mg Tablet', updated_at = NOW() WHERE id = 1025; -- URSUWELL -300
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (USIBON-300)', updated_at = NOW() WHERE id = 1026; -- USIBON-300
UPDATE products SET salt_id = 215, composition = 'Vonoprazan Fumarate 20 mg Tablet', updated_at = NOW() WHERE id = 1027; -- V-FORGE TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VALVO 300 (DPCO))', updated_at = NOW() WHERE id = 1028; -- VALVO 300 (DPCO)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VALVO CR-200)', updated_at = NOW() WHERE id = 1029; -- VALVO CR-200
UPDATE products SET salt_id = 48, composition = 'Tamsulosin Hydrochloride 0.4 mg Prolonged Release Capsule', updated_at = NOW() WHERE id = 1030; -- VASOTAM
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VBETA 16TAB)', updated_at = NOW() WHERE id = 1031; -- VBETA 16TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VBETA-24 TAB)', updated_at = NOW() WHERE id = 1032; -- VBETA-24 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VELASOF)', updated_at = NOW() WHERE id = 1033; -- VELASOF
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VETODEP-20 CAP*)', updated_at = NOW() WHERE id = 1034; -- VETODEP-20 CAP*
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VETODEP-40 CAP*)', updated_at = NOW() WHERE id = 1035; -- VETODEP-40 CAP*
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VETODEP-60-CAP)', updated_at = NOW() WHERE id = 1036; -- VETODEP-60-CAP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VIKORATE CHRONO-200*)', updated_at = NOW() WHERE id = 1037; -- VIKORATE CHRONO-200*
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VIKORATE CHRONO-300 TAB)', updated_at = NOW() WHERE id = 1038; -- VIKORATE CHRONO-300 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VIKORATE CHRONO-500TAB*)', updated_at = NOW() WHERE id = 1039; -- VIKORATE CHRONO-500TAB*
UPDATE products SET salt_id = 55, composition = 'Oral Pharmaceutical Liquid Formulation', updated_at = NOW() WHERE id = 1040; -- VIKORATE SYP 200ML*
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VILDEE M 500)', updated_at = NOW() WHERE id = 1041; -- VILDEE M 500
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VINTA CAP)', updated_at = NOW() WHERE id = 1042; -- VINTA CAP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VISERT 25 TAB)', updated_at = NOW() WHERE id = 1043; -- VISERT 25 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VISERT 50TAB)', updated_at = NOW() WHERE id = 1044; -- VISERT 50TAB
UPDATE products SET salt_id = 216, composition = 'Whey Protein with Essential Vitamins, Minerals & Trace Elements Powder', updated_at = NOW() WHERE id = 1045; -- VITCLUD SP
UPDATE products SET salt_id = 217, composition = 'High Protein Nutritional Powder (Vanilla Flavor) with Micronutrients', updated_at = NOW() WHERE id = 1046; -- VITCLUD-HP VANILLA
UPDATE products SET salt_id = 218, composition = 'Specialized Protein Formulation with Antioxidants Powder', updated_at = NOW() WHERE id = 1047; -- VITCLUD-SP
UPDATE products SET salt_id = 65, composition = 'Essential Multivitamins, Minerals with Antioxidants Tablet', updated_at = NOW() WHERE id = 1048; -- VITQUENCH TAB
UPDATE products SET salt_id = 25, composition = 'Aceclofenac 100 mg + Paracetamol 325 mg + Serratiopeptidase 15 mg Tablet', updated_at = NOW() WHERE id = 1049; -- VIVIAN-A PLUS TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VIZEP 10 TAB)', updated_at = NOW() WHERE id = 1050; -- VIZEP 10 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VIZEP 25 TAB)', updated_at = NOW() WHERE id = 1051; -- VIZEP 25 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VIZONIC-25 TAB*)', updated_at = NOW() WHERE id = 1052; -- VIZONIC-25 TAB*
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VOGLITAL 0.2)', updated_at = NOW() WHERE id = 1053; -- VOGLITAL 0.2
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VOGLITAL M 0.2)', updated_at = NOW() WHERE id = 1054; -- VOGLITAL M 0.2
UPDATE products SET salt_id = 215, composition = 'Vonoprazan Fumarate 10 mg Tablet', updated_at = NOW() WHERE id = 1055; -- VONOGRESS 10
UPDATE products SET salt_id = 215, composition = 'Vonoprazan Fumarate 20 mg Tablet', updated_at = NOW() WHERE id = 1056; -- VONOGRESS-20
UPDATE products SET salt_id = 215, composition = 'Vonoprazan Fumarate 20 mg Tablet', updated_at = NOW() WHERE id = 1057; -- VONOTAL 20
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (VORITELMA-40)', updated_at = NOW() WHERE id = 1058; -- VORITELMA-40
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (WALAPAN-IV 40 MG)', updated_at = NOW() WHERE id = 1059; -- WALAPAN-IV 40 MG
UPDATE products SET salt_id = 219, composition = '100% Whey Peptide Advanced Clinical Nutrition Powder', updated_at = NOW() WHERE id = 1060; -- WHEYBIX-PEP POWDER
UPDATE products SET salt_id = 16, composition = 'Sodium Alginate 250 mg + Sodium Bicarbonate 133.5 mg + Calcium Carbonate 80 mg / 5 ml Oral Suspension', updated_at = NOW() WHERE id = 1061; -- WINRAFT
UPDATE products SET salt_id = 220, composition = 'Doxycycline 100 mg Capsule', updated_at = NOW() WHERE id = 1062; -- WOBIDOX
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (X RAY FILM 10*8 (FUJI DRY VIEW)', updated_at = NOW() WHERE id = 1063; -- X RAY FILM 10*8 (Fuji Dry View
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (XITOLONG 50 TAB)', updated_at = NOW() WHERE id = 1064; -- XITOLONG 50 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (XOVA-200 TAB)', updated_at = NOW() WHERE id = 1065; -- XOVA-200 TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (XYLOVIR INJ 250 MG)', updated_at = NOW() WHERE id = 1066; -- XYLOVIR INJ 250 MG
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (XYLOVIR-500 ING)', updated_at = NOW() WHERE id = 1067; -- XYLOVIR-500 ING
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (YUVINIE SUNSCREEN AQ)', updated_at = NOW() WHERE id = 1068; -- YUVINIE SUNSCREEN AQ
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZENOCISS TAB)', updated_at = NOW() WHERE id = 1069; -- ZENOCISS TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZENOHEAL-D TAB)', updated_at = NOW() WHERE id = 1070; -- ZENOHEAL-D TAB
UPDATE products SET salt_id = 55, composition = 'Oral Pharmaceutical Liquid Formulation', updated_at = NOW() WHERE id = 1071; -- ZENOMIN SYP
UPDATE products SET salt_id = 60, composition = 'Cholecalciferol (Vitamin D3) 60,000 IU Oral Formulation', updated_at = NOW() WHERE id = 1072; -- ZENOMIN-D3 S/G CAP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZENOMIN-GOLD)', updated_at = NOW() WHERE id = 1073; -- ZENOMIN-GOLD
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZENOPOD-CV TAB)', updated_at = NOW() WHERE id = 1074; -- ZENOPOD-CV TAB
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZENTAFLAM-SP)', updated_at = NOW() WHERE id = 1075; -- ZENTAFLAM-SP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZEOPLATE+ S/G)', updated_at = NOW() WHERE id = 1076; -- ZEOPLATE+ S/G
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZEOVERIN-MF)', updated_at = NOW() WHERE id = 1077; -- ZEOVERIN-MF
UPDATE products SET salt_id = 199, composition = 'Cefoperazone Sodium 1000 mg + Sulbactam Sodium 500 mg (1.5 gm) IV Injection', updated_at = NOW() WHERE id = 1078; -- ZOACT 1.5
UPDATE products SET salt_id = 199, composition = 'Cefoperazone Sodium 2000 mg + Sulbactam Sodium 1000 mg (3 gm) Forte Injection', updated_at = NOW() WHERE id = 1079; -- ZOACT FORT
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZOLENT 0.25)', updated_at = NOW() WHERE id = 1080; -- ZOLENT 0.25
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZOLENT FORTE(NRX))', updated_at = NOW() WHERE id = 1081; -- ZOLENT FORTE(NRX)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZOLENT PLUS (NRX))', updated_at = NOW() WHERE id = 1082; -- ZOLENT PLUS (NRX)
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZOLPINITE 10 (NRX) (DP)', updated_at = NOW() WHERE id = 1083; -- ZOLPINITE 10 (NRX) (DP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZOOL DSR CAP)', updated_at = NOW() WHERE id = 1084; -- ZOOL DSR CAP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZOOL-LS CAPS)', updated_at = NOW() WHERE id = 1085; -- ZOOL-LS CAPS
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZORO SYRUP)', updated_at = NOW() WHERE id = 1086; -- ZORO SYRUP
UPDATE products SET salt_id = 13, composition = 'Standard Pharmaceutical Formulation (ZWELL)', updated_at = NOW() WHERE id = 1087; -- ZWELL
