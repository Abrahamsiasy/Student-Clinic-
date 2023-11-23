<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          


            $categories = [
                'Reisparatory Medication',
                'Medicines for Allergies',
                'Antibiotics',
                'Antifungals',
                'Antivirals',
                'Antiprotozoals',
                'Antihelmentics',
                'Antipain',
                'Local Anesthetics',
                'VITAMINS',
                'Medicines used in Allergic Emergencies',
                'CORRECTING FLUID AND ELECTROLYTE',
                'OPHTHALMIC AGENTS',
                'EAR, NOSE AND THROAT PREPARATIONS',
                'DERMATOLOGICAL AGENTS',
                'Antiseptic agents',
                'MISCELLANEOUS',
                'Gastrointestinal Agents',
                'Antihaemorrhoidal Agents',
            ];

            foreach ($categories as $category) {
                Category::firstOrCreate([
                    'name' => $category,
                ]);


            }
    }
}
