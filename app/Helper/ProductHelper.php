<?php


namespace App\Helper;

use App\Models\Category;
use App\Models\Product;
use Exception;
use App\Models\Store;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Config;
// use Illuminate\Database\Eloquent\ModelNotFoundException;









class ProductHelper{

    function syncProducts(Store $store){



        $productsData = [
            [
                'category' => 'Reisparatory Medication',
                'products' => [
                    'Dextromethorphan Hydrobromide Syrup, 15mg/5ml',
                    'Paracetamol + Chlorpheniramine + Pseudoephedrine',
                    'Guaifenesin Syrup 100mg/5ml',
                    'Beclomethasone Dipropionate Oral Inhalation',
                    'Salbutamol Oral Inhalation (aerosol), 0.1 mg/dose',
                    'Salbutamol 4mg',
                    'Prednisolone 5mg',
                    'Hydrocortisone Succinate Injection: 40mg/ml, 80mg/2ml',
                ],
            ],
            [
                'category' => 'Medicines for Allergies',
                'products' => [
                    'Loratidine 10mg',
                    'Cetrizine 10mg',
                    'Xylometazoline Nasal drop, 0.05%; 0.1%',
                    'Almethamin 10mg',
                    'Chlorpheniramine malate 4mg',
                    'Diphenhydramine hydrochloride 25mg',
                    'Promethazine Hydrochloride 25 mg',
                ],
            ],
            [
                'category' => 'Antibiotics',
                'products' => [
                    'Amoxicillin Capsule 500mg',
                    'Amoxicillin + Clavulanic Acid',
                    'Penicillin G, Benzathin Injection 1.2 MIU',
                    'Cloxacillin Capsule 500mg',
                    'Ceftriaxone Injection 1g in via',
                    'Ceftriaxone Injection 0.25g in via',
                    'Cephalexin Capsule 500 mg',
                    'Azithromycin Tablet 500mg',
                    'Clarithromycin Table 500mg',
                    'Erythromycin table 500mg',
                    'Gentamicin Injection 80mg/2ml',
                    'Ciprofloxacin Tablet (as hydrochloride) 500mg',
                    'Norfloxacin Tablet 400mg',
                    'Doxycycline Tablet/Capsule 100mg',
                    'Metronidazole Tablet/Capsule 250mg',
                    'Sulphamethoxazole + Trimethoprim 480mg',
                    'Clindimycine Cream',
                ],
            ],
            [
                'category' => 'Antifungals',
                'products' => [
                    'Clotrimazole Mouth paint1%',
                    'Clotrimazole Supository 100mg',
                    'Fluconazole Capsule/Tablet 100mg',
                    'Griseofulvin Tablet 250mg',
                    'Miconazole Oral gel 25mg/ml',
                    'Ketoconazole Cream 1%',
                    'Clotrimazole Cream 1%',
                ],
            ],
            [
                'category' => 'Antivirals',
                'products' => [
                    'Acyclovir Tablet, 200mg',
                    'Acyclovir cream',
                    'Mozbite Cream',
                    'Oropest Cream',
                ],
            ],
            [
                'category' => 'Antiprotozoals',
                'products' => [
                    'Artemether + Lumefantrin 20mg + 120mg Adult',
                    'Chloroquine 250mg, 500mg',
                    'Quinine Injection, 300mg/ml in 1ml',
                    'Quinine- Dihydrochloride 300mg, 600mg',
                    'Tindazole 500mg',
                ],
            ],
            [
                'category' => 'Antihelmentics',
                'products' => [
                    'Praziquantel 600mg',
                    'Albendazol (chewable), 400mg',
                    'Mebendazol 100mg',
                    'Piperazine lixir(Citrate), 500mg/5ml, 750mg/5m',
                ],
            ],
            [
                'category' => 'Antipain',
                'products' => [
                    'Acetaminophen 500mg (paracetamol)',
                    'Acetylsalicylic Acid 300mg, (enteric coated) (ASA)',
                    'Diclofenac 50mg',
                    'Diclofenac 75mg/ml in 3ml',
                    'Ibuprofene 400mg',
                    'Tramadol hydrochloride Injection, 50mg/ml',
                    'Tramadol hydrochloride Tablet/Capsule, 50mg',
                ],
            ],
            [
                'category' => 'Local Anesthetics',
                'products' => [
                    'Lidocaine Hydrochloride + Adrenaline 2%',
                ],
            ],
            [
                'category' => 'VITAMINS',
                'products' => [
                    'Ascorbic acid (Vitamin C) 500mg',
                    'Vitamin B-complex injection',
                    'Vitamin B-complex tablet',
                    'Multivitamin with Minerals',
                ],
            ],
            [
                'category' => 'Medicines used in Allergic Emergencies',
                'products' => [
                    'Adrenaline 0.1% in 1ml 1:1000 1mg/ml',
                    'Dexamethasone 4mg',
                ],
            ],
            [
                'category' => 'CORRECTING FLUID AND ELECTROLYTE',
                'products' => [
                    'Oral Rehydration Salt each sachet for 1 liter contains',
                    'Dextrose 40% in 20ml',
                    'Dextrose in Normal Salin 5% in 1000ml',
                    'Dextrose in Normal Salin 5% in 500ml',
                    'Lactated Ringer’s (Hartmann’s Solution)',
                ],
            ],
            [
                'category' => 'OPHTHALMIC AGENTS',
                'products' => [
                    'Ciprofloxacin Solution (Eye drop): 0.3%',
                    'Tetracycline Eye ointment: 1%',
                    'Dexamethasone Eye drops suspension: 0.1%',
                    'Chloramphenicol + Dexamethasone Eye drops, 0.5% +0.1%',
                    'Ciprofloxacin + Dexamethasone Eye Suspp 0.3%, 0.1%',
                    'Hydrocortisone Acetate + Polymixin B',
                    'Tetracaine Hydrochloride Eye drops: 0.5%',
                ],
            ],
            [
                'category' => 'EAR, NOSE AND THROAT PREPARATIONS',
                'products' => [
                    'Hydrogen Peroxide Solution: 3%',
                ],
            ],
            [
                'category' => 'DERMATOLOGICAL AGENTS',
                'products' => [
                    'Benzoic Acid + Salicylic Acid Whitefield Ointment: 6% + 3%',
                    'Benzyl Benzoate Lotion: 25%',
                    'Nitrofurazone Ointment: 30gm, 45gm',
                    'Fusidic Acid Cream: 2%',
                    'Zinc sulphate 20mg',
                    'Betamethasome Valerate Cream: 0.1%',
                    'Betamethasone Dipropionate Cream: 0.05% w/w',
                    'Hydrocortisone Acetate Cream/ointment: 0.1 %',
                    'Mometasone furaoate Cream / ointment: 0.1%',
                    'Methyl Salicylate Ointment: 25%w/w',
                    'Salicylic Acid Ointment, 2%, 5%, 10%',
                    'Ichthammol',
                    'Zinc Oxide Paste: 20%w/',
                    'Calamine Lotion: 15% w/',
                ],
            ],
            [
                'category' => 'Antiseptic agents',
                'products' => [
                    'Ethyl Alcohol Solution: 70% w/v',
                    'Povidone Iodine Solution: 10%V/V',
                    'Gentian Violet Solution: 1%v/v',
                ],
            ],
            [
                'category' => 'MISCELLANEOUS',
                'products' => [
                    'Water for injict 5ml, 10ml vial',
                    'Silk braided black - Gauge 3, 75cm on 35mm 1/2 circle reverse cutting needle',
                    'Tetanus Anti Toxoid 1500IU',
                    'IV Canula no 18G',
                    'IV Canula no 22G',
                    'Elastic bandage',
                    'Roll bandage 12.5cm x 5m',
                    'Surgical Guaz 90cmx 100m',
                    'Surgical Balade 15G',
                    'Surgical Balade 23G',
                ],
            ],
            [
                'category' => 'Gastrointestinal Agents',
                'products' => [
                    'Aluminum Hydroxide + Magnesium Hydroxide + Simethicone',
                    'Aluminum Hydroxide + Magnesium Trisilicate',
                    'Cimetidine 400mg/ml in 2ml',
                    'Omeprazole Tablet/Capsule 20 mg',
                    'Cimetidine 400mg tablet',
                    'Pantoprazole 40mg',
                    'Hyoscine (Scopolamine) 20mg/ml',
                    'Hyoscine (Scopolamine) 10mg',
                    'Metoclopramide Hydrochloride 10mg',
                    'Metoclopramide Hydrochloride 10mg/2ml',
                    'Bisacody 5mg',
                ],
            ],
            [
                'category' => 'Antihaemorrhoidal Agents',
                'products' => [
                    'Betamethasone Valerate+ Phenylephrine HCl + LidocaineHCl',
                ],
            ],
        ];

        // Seed the products
        foreach ($productsData as $data) {
            $category = Category::firstOrCreate(['name' => $data['category']]);
           $categoryId= $category->id;
    foreach ($data['products'] as $productName) {
        Product::firstOrCreate(
            [
                'name' => $productName,
                'category_id' => $categoryId,
                'store_id' => $store->id, // Replace with your store ID
            ],

        );
    }
        }}
}
