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
            

            foreach ($rows as $row) {
                

                DB::commit();
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            dd($e);
        }
    }
}
