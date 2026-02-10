<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\IngredientMaster;
use App\Models\IngredientGroup;

class IngredientCategory extends Model
{
    use SoftDeletes;
    protected $table = 'ingredient_master_categories';

    public function ingredient(){
        return $this->hasMany(IngredientMaster::class, 'ingredient_master_category_id', 'id');
    }

    public function ingredient_group(){
        return $this->belongsTo(IngredientGroup::class, 'ingredient_master_group_id', 'id');
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

    public function scopeGroup($query, $group)
    {
        if ($group != null) {
            return $query->where('ingredient_master_group_id', $group);
        }
        return $query;
    }
}
