<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Purchase extends Model
{
    use SoftDeletes;

    protected $table = 'purchases';

    // Relationships
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function supplierAccount()
    {
        return $this->belongsTo(SupplierAccount::class, 'supplier_account_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function expenditureType()
    {
        return $this->belongsTo(ExpenditureType::class, 'expenditure_type_id');
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id');
    }

    public function purchaseCosts()
    {
        return $this->hasMany(PurchaseCost::class, 'purchase_id');
    }

    public function purchaseDiscounts()
    {
        return $this->hasMany(PurchaseDiscount::class, 'purchase_id');
    }

    public function purchaseInstalments()
    {
        return $this->hasMany(PurchaseInstalment::class, 'purchase_id');
    }

    // Date accessors
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

    public function scopeSupplier($query, $supplier)
    {
        if ($supplier != null) {
            return $query->where('supplier_id', $supplier);
        }
        return $query;
    }

    public function scopeWallet($query, $wallet)
    {
        if ($wallet != null) {
            return $query->where('wallet_id', $wallet);
        }
        return $query;
    }

    public function scopeWarehouse($query, $warehouse)
    {
        if ($warehouse != null) {
            return $query->where('warehouse_id', $warehouse);
        }
        return $query;
    }

    public function scopeSupplierAccount($query, $supplierAccount)
    {
        if ($supplierAccount != null) {
            return $query->where('supplier_account_id', $supplierAccount);
        }
        return $query;
    }

    public function scopeExpenditureType($query, $expenditureType)
    {
        if ($expenditureType != null) {
            return $query->where('expenditure_type_id', $expenditureType);
        }
        return $query;
    }

    public function scopePaymentMethod($query, $paymentMethod)
    {
        if ($paymentMethod != null) {
            return $query->where('payment_method_id', $paymentMethod);
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
}
