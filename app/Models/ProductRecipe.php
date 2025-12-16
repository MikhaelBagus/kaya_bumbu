<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ProductRecipe extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_recipes';

    protected $fillable = [
        'product_id',
        'ingredient_master_id',
        'qty',
    ];

    protected $casts = [
        'qty' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function ingredientMaster()
    {
        return $this->belongsTo(IngredientMaster::class);
    }
}