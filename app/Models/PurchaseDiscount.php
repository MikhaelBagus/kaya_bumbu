<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDiscount extends Model
{
    protected $table = 'purchase_discounts';

    // Relationships
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
