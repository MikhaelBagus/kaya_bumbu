<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\IngredientCategory;
use App\Models\IngredientMaster;
use App\Models\ProductRecipe;
use Illuminate\Support\Facades\DB;

class ProductIngredientImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        DB::beginTransaction();
        try {
            $productNamePrev = "";
            foreach ($rows as $row) {
                if($row[1] == null){
                    $nameProduct = $productNamePrev;
                }
                else{
                    $nameProduct = $row[1];
                }
                $product = Product::where('name',$nameProduct)->first();

                if($product){
                    $loopRecipes = $product->product_recipes;
                    $loopRecipes->each->forceDelete();

                    $ingredientCategory = IngredientCategory::where('name',$row[5])->first();
                    if($ingredientCategory){

                    }
                    else{
                        $ingredientCategory = new IngredientCategory();
                        $ingredientCategory->name = $row[5];
                        $ingredientCategory->save();
                    }

                    $ingredientMaster = IngredientMaster::where('name',$row[2])->first();
                    if($ingredientMaster){
                        if($ingredientMaster->unit == $row[4]){

                        }
                        else{
                            dd($row, "Unit beda");
                        }
                    }
                    else{
                        $ingredientMaster = new IngredientMaster();
                        $ingredientMaster->ingredient_master_category_id = $ingredientCategory->id;
                        $ingredientMaster->name                          = $row[2];
                        $ingredientMaster->unit                          = $row[4];
                        $ingredientMaster->save();
                    }

                    $productRecipe = new ProductRecipe();
                    $productRecipe->product_id           = $product->id;
                    $productRecipe->ingredient_master_id = $ingredientMaster->id;
                    $productRecipe->qty                  = $row[3];
                    $productRecipe->save();
                }
                else{
                    dd($row, "Product tidak ada");
                }

                $productNamePrev = $nameProduct;

                DB::commit();
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            dd($e);
        }
    }
}
