<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientMaster extends Model
{
    use HasFactory;

    protected $table = 'ingredient_masters';
    
    protected $fillable = [
        'name',
        'unit',
    ];

    public function productRecipes()
    {
        return $this->hasMany(ProductRecipe::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_recipes')
                    ->withPivot('qty')
                    ->withTimestamps();
    }
}