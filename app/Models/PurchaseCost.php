<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseCost extends Model
{
    protected $table = 'purchase_costs';

    // Relationships
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
