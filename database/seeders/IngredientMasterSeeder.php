<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IngredientMaster;

class IngredientMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = [
            // Spices and Seasonings
            ['name' => 'Salt', 'unit' => 'grams'],
            ['name' => 'Black Pepper', 'unit' => 'grams'],
            ['name' => 'White Pepper', 'unit' => 'grams'],
            ['name' => 'Turmeric Powder', 'unit' => 'grams'],
            ['name' => 'Coriander Powder', 'unit' => 'grams'],
            ['name' => 'Cumin Powder', 'unit' => 'grams'],
            ['name' => 'Paprika Powder', 'unit' => 'grams'],
            ['name' => 'Chili Powder', 'unit' => 'grams'],
            ['name' => 'Garlic Powder', 'unit' => 'grams'],
            ['name' => 'Onion Powder', 'unit' => 'grams'],
            
            // Fresh Ingredients
            ['name' => 'Fresh Garlic', 'unit' => 'cloves'],
            ['name' => 'Fresh Ginger', 'unit' => 'grams'],
            ['name' => 'Red Onion', 'unit' => 'pieces'],
            ['name' => 'Shallots', 'unit' => 'pieces'],
            ['name' => 'Red Chili', 'unit' => 'pieces'],
            ['name' => 'Green Chili', 'unit' => 'pieces'],
            ['name' => 'Lemongrass', 'unit' => 'stalks'],
            ['name' => 'Kaffir Lime Leaves', 'unit' => 'pieces'],
            ['name' => 'Bay Leaves', 'unit' => 'pieces'],
            ['name' => 'Galangal', 'unit' => 'grams'],
            
            // Oils and Liquids
            ['name' => 'Palm Oil', 'unit' => 'ml'],
            ['name' => 'Coconut Oil', 'unit' => 'ml'],
            ['name' => 'Vegetable Oil', 'unit' => 'ml'],
            ['name' => 'Coconut Milk', 'unit' => 'ml'],
            ['name' => 'Tamarind Water', 'unit' => 'ml'],
            ['name' => 'Sweet Soy Sauce', 'unit' => 'ml'],
            ['name' => 'Fish Sauce', 'unit' => 'ml'],
            
            // Others
            ['name' => 'Brown Sugar', 'unit' => 'grams'],
            ['name' => 'Palm Sugar', 'unit' => 'grams'],
            ['name' => 'Candlenuts', 'unit' => 'pieces'],
        ];

        foreach ($ingredients as $ingredient) {
            IngredientMaster::updateOrCreate(
                ['name' => $ingredient['name']],
                $ingredient
            );
        }
    }
}
