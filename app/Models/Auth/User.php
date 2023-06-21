<?php

namespace App\Models\Auth;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use App\Models\Auth\UserRole;
use App\Models\Transaction;
use App\Models\Log;

class User extends EloquentUser implements AuthenticatableContract
{
    use Authenticatable, HasApiTokens, SoftDeletes;
    const last_login = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'phone',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function user_role(){
        return $this->hasOne(UserRole::class, 'user_id', 'id');
    }

    public function transaction(){
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    public function log(){
        return $this->hasMany(Log::class, 'user_id', 'id');
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

    public function getLastLoginAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return (new Carbon($value))->timezone('Asia/Jakarta')->toDateTimeString();
        }
    }

    public function getFirebaseDeviceTokenAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return $value;
        }
    }

    public function getPermissionsAttribute($value)
    {
        if($value == null){
            return '';
        }
        else{
            return $value;
        }
    }
}
