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

    public function getCityNameAttribute()
    {
        $city = City::where('id', $this->city_id)->first();

        if($city){
            return $city->name;
        }
        else{
            return '';
        }
    }

    public function getProvinceIdAttribute()
    {
        $city = City::where('id', $this->city_id)->first();

        if($city){
            return $city->province->id;
        }
        else{
            return '';
        }
    }

    public function getProvinceNameAttribute()
    {
        $city = City::where('id', $this->city_id)->first();

        if($city){
            return $city->province->name;
        }
        else{
            return '';
        }
    }

    public function getLastTransactionAttribute()
    {
        $transaction = Transaction::where('customer_id', $this->id)->orderBy('date','desc')->first();

        if($transaction){
            return $transaction->date;
        }
        else{
            return '';
        }
    }

    protected $appends = ['city_name', 'province_id', 'province_name', 'last_transaction'];
}
