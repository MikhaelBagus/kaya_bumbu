<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\City;

class Customer extends Model
{
    use SoftDeletes;
    protected $table = 'customer';

    public function transaction(){
        return $this->hasMany(Transaction::class, 'customer_id', 'id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'city_id', 'id');
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

    public function scopeCity($query, $city)
    {
        if ($city != null) {
            return $query->where('city_id', $city);
        }
        return $query;
    }

    public function scopeProvince($query, $province)
    {
        if ($province != null) {
            return $query->whereHas('city', function($q) use($province) {
                        $q->where('province_id', $province);
                    });
        }
        return $query;
    }
}
