<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllergenLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allergens = [
            [
                'code' => 'FISH',
                'name_en' => 'Fish',
                'name_nl' => 'Vis',
                'icon_class' => 'fa-fish',
                'is_active' => true,
            ],
            [
                'code' => 'SHELLFISH',
                'name_en' => 'Shellfish / Crustaceans',
                'name_nl' => 'Schelpdieren / Schaaldieren',
                'icon_class' => 'fa-shrimp',
                'is_active' => true,
            ],
            [
                'code' => 'MOLLUSCS',
                'name_en' => 'Molluscs',
                'name_nl' => 'Weekdieren',
                'icon_class' => 'fa-oyster',
                'is_active' => true,
            ],
            [
                'code' => 'GLUTEN',
                'name_en' => 'Gluten (wheat, rye, barley)',
                'name_nl' => 'Gluten (tarwe, rogge, gerst)',
                'icon_class' => 'fa-wheat',
                'is_active' => true,
            ],
            [
                'code' => 'EGGS',
                'name_en' => 'Eggs',
                'name_nl' => 'Eieren',
                'icon_class' => 'fa-egg',
                'is_active' => true,
            ],
            [
                'code' => 'DAIRY',
                'name_en' => 'Milk / Dairy',
                'name_nl' => 'Melk / Zuivel',
                'icon_class' => 'fa-milk',
                'is_active' => true,
            ],
            [
                'code' => 'CELERY',
                'name_en' => 'Celery',
                'name_nl' => 'Selderij',
                'icon_class' => 'fa-leaf',
                'is_active' => true,
            ],
            [
                'code' => 'MUSTARD',
                'name_en' => 'Mustard',
                'name_nl' => 'Mosterd',
                'icon_class' => 'fa-pepper-hot',
                'is_active' => true,
            ],
            [
                'code' => 'SESAME',
                'name_en' => 'Sesame seeds',
                'name_nl' => 'Sesamzaad',
                'icon_class' => 'fa-seedling',
                'is_active' => true,
            ],
            [
                'code' => 'SULPHITES',
                'name_en' => 'Sulphites (SO2)',
                'name_nl' => 'Sulfieten (SO2)',
                'icon_class' => 'fa-flask',
                'is_active' => true,
            ],
        ];

        foreach ($allergens as $allergen) {
            DB::table('allergen_labels')->updateOrInsert(
                ['code' => $allergen['code']],
                array_merge($allergen, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('Allergen labels seeded successfully.');
    }
}
