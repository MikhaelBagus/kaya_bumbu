<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInstalment extends Model
{
    protected $table = 'purchase_instalments';

    // Relationships
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
