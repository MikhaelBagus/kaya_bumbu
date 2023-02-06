<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Ingredient;

class ProductIngredient extends Model
{
    use SoftDeletes;
    protected $table = 'product_ingredient';

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function ingredient(){
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'id');
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

    public function getAnswerAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return $value;
        }
    }
}
