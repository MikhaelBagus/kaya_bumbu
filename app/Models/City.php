<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Province;

class City extends Model
{
    use SoftDeletes;
    protected $table = 'city';

    public function province(){
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function transaction(){
        return $this->hasMany(Transaction::class, 'city_id', 'id');
    }

    public function customer(){
        return $this->hasMany(Customer::class, 'city_id', 'id');
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

    public function scopeProvince($query, $province)
    {
        if ($province != null) {
            return $query->where('province_id', $province);
        }
        return $query;
    }
}
