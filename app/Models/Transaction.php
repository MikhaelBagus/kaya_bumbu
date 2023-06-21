<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\TransactionProduct;
use App\Models\Customer;
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

    public function bank(){
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function source(){
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }

    public function getDateAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return $value;
        }
    }

    public function getStartCookingAtAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
    }

    public function getEndCookingAtAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
    }

    public function getStartDeliveryAtAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
    }

    public function getEndDeliveryAtAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
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
}
