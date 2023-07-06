<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\TransactionProduct;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Bank;
use App\Models\City;
use App\Models\Source;
use App\Models\Auth\User;

class Transaction extends Model
{
    use SoftDeletes;
    protected $table = 'transaction';

    public function transaction_product(){
        return $this->hasMany(TransactionProduct::class, 'transaction_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function driver(){
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    public function bank(){
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function customer_city(){
        return $this->belongsTo(City::class, 'customer_city_id', 'id');
    }

    public function source(){
        return $this->belongsTo(Source::class, 'source_id', 'id');
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

    public function scopeDate($query, $orderDateFrom, $orderDateTo)
    {
        if ($orderDateFrom != null && $orderDateTo != null) {
            return $query->whereBetween('date', [$orderDateFrom, $orderDateTo]);
        }
        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if ($status != null) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopePaymentstatus($query, $paymentstatus)
    {
        if ($paymentstatus != null) {
            return $query->where('payment_status', $paymentstatus);
        }
        return $query;
    }

    public function scopeDeliveryoption($query, $deliveryoption)
    {
        if ($deliveryoption != null) {
            return $query->where('delivery_option', $deliveryoption);
        }
        return $query;
    }

    public function scopeDeliverytransport($query, $deliverytransport)
    {
        if ($deliverytransport != null) {
            if($deliverytransport == 'Other'){
                return $query->whereNotIn('delivery_transport', ['-', 'Mobil','Motor']);
            }
            else{
                return $query->where('delivery_transport', $deliverytransport);
            }
        }
        return $query;
    }

    public function scopeDeliverytype($query, $deliverytype)
    {
        if ($deliverytype != null) {
            return $query->where('delivery_type', $deliverytype);
        }
        return $query;
    }

    public function scopeBank($query, $bank)
    {
        if ($bank != null) {
            return $query->where('bank_id', $bank);
        }
        return $query;
    }

    public function scopeSource($query, $source)
    {
        if ($source != null) {
            return $query->where('source_id', $source);
        }
        return $query;
    }

    public function scopeCustomer($query, $customer)
    {
        if ($customer != null) {
            return $query->where('customer_id', $customer);
        }
        return $query;
    }

    public function scopeDriver($query, $driver)
    {
        if ($driver != null) {
            return $query->where('driver_id', $driver);
        }
        return $query;
    }

    public function scopeUser($query, $user)
    {
        if ($user != null) {
            return $query->where('user_id', $user);
        }
        return $query;
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

    public function scopeTransactiontype($query, $transactiontype)
    {
        if ($transactiontype != null) {
            return $query->where('transaction_type', $transactiontype);
        }
        return $query;
    }

    public function scopeGrandprice($query, $grandpricefrom, $grandpriceto)
    {
        if ($grandpricefrom != null && $grandpriceto != null) {
            return $query->whereBetween('grand_price', [$grandpricefrom, $grandpriceto]);
        }
        return $query;
    }
}
