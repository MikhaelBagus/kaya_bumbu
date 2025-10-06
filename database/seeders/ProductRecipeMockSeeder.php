<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\IngredientMaster;
use App\Models\ProductRecipe;

class ProductRecipeMockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = IngredientMaster::all();
        
        if ($ingredients->isEmpty()) {
            return "No ingredients found. Please run IngredientMasterSeeder first.";
        }

        $products = Product::all();
        
        if ($products->isEmpty()) {
            return "No products found. Please run ProductSeeder first.";
        }

        foreach ($products as $index => $product) {
            $numberOfIngredients = rand(3, 8);
            $selectedIngredients = $ingredients->random($numberOfIngredients);

            foreach ($selectedIngredients as $ingredient) {
                $qty = $this->generateRandomQuantity($ingredient);

                ProductRecipe::updateOrCreate([
                    'product_id' => $product->id,
                    'ingredient_master_id' => $ingredient->id,
                ], [
                    'qty' => $qty
                ]);
            }

        }

        $totalRecipes = ProductRecipe::count();
        return "Product recipes seeded successfully! Total recipes created: {$totalRecipes}";
    }

    private function generateRandomQuantity($ingredient)
    {
        $unit = strtolower($ingredient->unit);

        switch ($unit) {
            case 'grams':
                return round(rand(1, 50) + (rand(0, 99) / 100), 2);
                
            case 'ml':
                return round(rand(10, 200) + (rand(0, 99) / 100), 2);
                
            case 'pieces':
            case 'cloves':
                return rand(1, 10);
                
            case 'stalks':
                return rand(1, 3);
                
            default:
                return round(rand(1, 20) + (rand(0, 99) / 100), 2);
        }
    }
}
