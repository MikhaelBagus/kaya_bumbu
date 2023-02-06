<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\ProductIngredient;
use App\Models\TransactionIngredient;

class Ingredient extends Model
{
    use SoftDeletes;
    protected $table = 'ingredient';

    public function product_ingredient(){
        return $this->hasMany(ProductIngredient::class, 'ingredient_id', 'id');
    }

    public function transaction_ingredient(){
        return $this->hasMany(TransactionIngredient::class, 'ingredient_id', 'id');
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
