<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Carbon\Carbon;

class UserRole extends Model
{
	protected $table = 'role_users';
    protected $fillable = [
        'role_id'
    ];

    public function role(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
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
}