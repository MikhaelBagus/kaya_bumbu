<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Purchase extends Model
{
    use SoftDeletes;

    protected $table = 'purchases';

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

    public function getCreatedAtAttribute($value)
    {
        if ($value == null) {
            return '';
        } else {
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
    }

    public function getUpdatedAtAttribute($value)
    {
        if ($value == null) {
            return '';
        } else {
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
    }

    public function getDeletedAtAttribute($value)
    {
        if ($value == null) {
            return '';
        } else {
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
    }

    public function scopePurchaseDate($query, $purchaseDateFrom, $purchaseDateTo)
    {
        if ($purchaseDateFrom != null && $purchaseDateTo != null) {
            return $query->whereBetween('purchase_date', [$purchaseDateFrom, $purchaseDateTo]);
        }
        return $query;
    }

    public function scopeTotalPurchase($query, $totalPurchaseFrom, $totalPurchaseTo)
    {
        if ($totalPurchaseFrom != null && $totalPurchaseTo != null) {
            return $query->whereBetween('total_purchase', [$totalPurchaseFrom, $totalPurchaseTo]);
        }
        return $query;
    }

    public function scopeInstalmentCount($query, $instalmentCountFrom, $instalmentCountTo)
    {
        if ($instalmentCountFrom != null && $instalmentCountTo != null) {
            return $query->whereBetween('instalment_count', [$instalmentCountFrom, $instalmentCountTo]);
        }
        return $query;
    }

    public function scopeInstalmentLeft($query, $instalmentLeftFrom, $instalmentLeftTo)
    {
        if ($instalmentLeftFrom != null && $instalmentLeftTo != null) {
            return $query->having('instalment_left_count', '>=', $instalmentLeftFrom)
                ->having('instalment_left_count', '<=', $instalmentLeftTo);
        }
        return $query;
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

    public function scopeSupplierAccount($query, $supplierAccount)
    {
        if ($supplierAccount != null) {
            return $query->where('supplier_account_id', $supplierAccount);
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