<?php

namespace App\Models\Auth;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use App\Models\Notification;
use App\Models\Auth\UserRole;
use App\Models\KeahlianUser;
use App\Models\ObjectPenilaian;
use App\Models\KJPPUser;
use App\Models\KJPPSurveyor;
use App\Models\UserCity;
use App\Models\City;
use App\Models\JenisKeahlian;
use App\Models\Saldo;
use App\Models\ChatHeader;
use App\Models\UserAddress;
use App\Models\UserRekening;

class User extends EloquentUser implements AuthenticatableUserContract, AuthenticatableContract // implements JWTSubject // Authenticatable implements JWTSubject
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
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

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

    public function notification()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    public function keahlian_user(){
        return $this->hasMany(KeahlianUser::class, 'user_id', 'id');
    }

    public function object_penilaian(){
        return $this->hasMany(ObjectPenilaian::class, 'user_id', 'id');
    }

    public function kjpp_user(){
        return $this->hasOne(KJPPUser::class, 'user_id', 'id');
    }

    public function kjpp_surveyor(){
        return $this->hasOne(KJPPSurveyor::class, 'user_id', 'id');
    }

    public function user_city(){
        return $this->hasOne(UserCity::class, 'user_id', 'id');
    }

    public function saldo(){
        return $this->hasMany(Saldo::class, 'user_id', 'id');
    }

    public function chat_header(){
        return $this->hasMany(ChatHeader::class, 'user_id', 'id');
    }

    public function user_rekening(){
        return $this->hasMany(UserRekening::class, 'user_id', 'id');
    }

    public function user_address(){
        return $this->hasMany(UserAddress::class, 'user_id', 'id');
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

    public function getCityAttribute()
    {
        $user_id = $this->id;
        $city = City::select('id','province_id','name')->whereHas('user_city', function($q) use($user_id) {
                    $q->where('user_id',$user_id);
                })->get();

        return $city;
    }

    public function getJenisKeahlianAttribute()
    {
        $user_id = $this->id;
        $jenis_keahlian = JenisKeahlian::select('id','name')->whereHas('keahlian_user', function($q) use($user_id) {
                    $q->where('user_id',$user_id);
                })->get();

        return $jenis_keahlian;
    }

    public function getSaldoAttribute()
    {
        $user_id = $this->id;
        $saldo = Saldo::where('user_id',$user_id)->whereNotNull('paid_at')->sum('nominal');

        return $saldo;
    }

    public function getAddressAttribute()
    {
        $user_id = $this->id;
        $address = UserAddress::select('id','city_id','address','kecamatan','kelurahan','kode_pos')->where('user_id',$user_id)->get();

        return $address;
    }

    public function getRekeningAttribute()
    {
        $user_id = $this->id;
        $rekening = UserRekening::select('id','bank_id','nama_rekening','no_rekening')->where('user_id',$user_id)->get();

        return $rekening;
    }

    protected $appends = ['city','jenis_keahlian','saldo','address','rekening'];
}
