<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\IngredientCategory;
use App\Models\Product;
use App\Models\ProductRecipe;

class IngredientMaster extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'ingredient_masters';

    public function ingredient_category(){
        return $this->belongsTo(IngredientCategory::class, 'ingredient_master_category_id', 'id');
    }

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

    public function getCreatedAtAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
    }

    public function getUpdatedAtAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
    }

    public function getDeletedAtAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
    }

    public function scopeCategory($query, $category)
    {
        if ($category != null) {
            return $query->where('ingredient_master_category_id', $category);
        }
        return $query;
    }
}