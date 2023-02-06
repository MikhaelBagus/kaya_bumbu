<?php

namespace App\Models\Auth;

use Cartalyst\Sentinel\Roles\EloquentRole;
use App\Models\Auth\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EloquentRole
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'created_by',
        'updated_by'
    ];
    
    /**
     * For User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_role()
    {
        return $this->hasMany(UserRole::class, 'role_id', 'id');
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
