<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\TransactionProduct;
use App\Models\ProductCategory;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'product';

    public function transaction_product(){
        return $this->hasMany(TransactionProduct::class, 'product_id', 'id');
    }

    public function product_category(){
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
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
            return $query->where('product_category_id', $category);
        }
        return $query;
    }
}
