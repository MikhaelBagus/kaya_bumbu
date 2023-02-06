<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\TransactionProduct;
use App\Models\Ingredient;

class TransactionIngredient extends Model
{
    use SoftDeletes;
    protected $table = 'transaction_ingredient';

    public function transaction_product(){
        return $this->belongsTo(TransactionProduct::class, 'transaction_product_id', 'id');
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
