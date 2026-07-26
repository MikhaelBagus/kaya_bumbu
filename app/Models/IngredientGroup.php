<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\IngredientCategory;
use App\Models\Concerns\HasUniqueIngredientName;
use App\Support\IngredientImportNormalizer;

class IngredientGroup extends Model
{
    use HasUniqueIngredientName, SoftDeletes;
    protected $table = 'ingredient_master_groups';

    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = IngredientImportNormalizer::group($value);
    }

    public function category(){
        return $this->hasMany(IngredientCategory::class, 'ingredient_master_group_id', 'id');
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
}
