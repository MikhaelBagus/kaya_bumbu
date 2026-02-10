<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IngredientMaster;

class PurchaseItem extends Model
{
    protected $table = 'purchase_items';

    // Relationships
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function ingredientMaster()
    {
        return $this->belongsTo(IngredientMaster::class, 'product_id');
    }
}
