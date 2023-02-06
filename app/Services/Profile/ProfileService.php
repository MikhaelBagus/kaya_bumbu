<?php

namespace App\Services\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\UserAddress;
use App\Models\UserRekening;
use Laravel\Passport\Token;
use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\Hash;

class ProfileService implements ProfileServiceContract
{
    public function ProfileAPI($request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);
                $status = 200;

                DB::commit();

                return response()->json([
                    'error'     => false,
                    'message'   => 'OK',
                    'data'      => [
                        'id'       => $user->id,
                        'name'     => $user->name,
                        'email'    => $user->email,
                        'phone'    => $user->phone,
                        'jenis_keahlian' => $user->jenis_keahlian,
                        'address'  => $user->address,
                        'rekening' => $user->rekening
                    ],
                    'status'    => $status
                ], $status);
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function ChangeProfileAPI($request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);
                $user->name       = $request->name;
                $user->phone      = $request->phone;
                $user->updated_by = $user->name;
                $user->save();

                $status = 200;

                DB::commit();

                return response()->json([
                    'error'     => false,
                    'message'   => 'Change profile success',
                    'data'      => '',
                    'status'    => $status
                ], $status);
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function ChangePasswordAPI($request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);

                $fullname = explode(" ", $user->name);
                $re = "/^(?=.*[a-z])(?=.*\\d).{8,}$/i";
                
                if (Hash::check($request->old_password, $user->password)){
                    if(!preg_match($re, $request->new_password) || !ctype_alnum($request->new_password) || strpos(strtolower($request->new_password), strtolower($fullname[0]))){
                        return response()->json([
                            'error'     => true,
                            'message'   => 'New Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum and not contain private content',
                            'data'      => '',
                            'status'    => 403
                        ], 403);
                    }
                    else if(strpos(strtolower($request->new_password), strtolower($fullname[0])) === 0){
                        return response()->json([
                            'error'     => true,
                            'message'   => 'New Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum and not contain private content',
                            'data'      => '',
                            'status'    => 403
                        ], 403);
                    }
                    else{
                        $user->password   = Hash::make($request->new_password);
                        $user->updated_by = $user->name;
                        $user->save();

                        $status = 200;

                        DB::commit();

                        return response()->json([
                            'error'     => false,
                            'message'   => 'Change password success',
                            'data'      => '',
                            'status'    => $status
                        ], $status);
                    }
                }
                else{
                    DB::rollBack();

                    return response()->json([
                        'error'     => true,
                        'message'   => 'Old Password is wrong',
                        'data'      => '',
                        'status'    => 403
                    ], 403);
                }
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function UserAddressAPI($request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);

                $userAddress = UserAddress::select('id','city_id','address','kecamatan','kelurahan','kode_pos')->where('user_id',$user->id)->orderBy('id','desc')->paginate(100);
                
                if($userAddress->isEmpty()){
                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => [],
                        'current_page' => 1,
                        'total_page'   => 1,
                        'status'       => 200
                    ], 200);
                }
                else{
                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => $userAddress->toArray()['data'],
                        'current_page' => $userAddress->toArray()['current_page'],
                        'total_page'   => $userAddress->toArray()['last_page'],
                        'status'       => 200
                    ], 200);
                }
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function UserAddressDetailAPI($id, $request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);

                $userAddress = UserAddress::select('id','city_id','address','kecamatan','kelurahan','kode_pos')->where('user_id',$user->id)->where('id',$id)->first();
                
                if(!$userAddress){
                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => '',
                        'status'       => 200
                    ], 200);
                }
                else{
                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => $userAddress,
                        'status'       => 200
                    ], 200);
                }
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function UserAddressCreateAPI($request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);

                $userAddress = new UserAddress();
                $userAddress->user_id    = $user->id;
                $userAddress->city_id    = $request->city_id;
                $userAddress->address    = $request->address;
                $userAddress->kecamatan  = $request->kecamatan;
                $userAddress->kelurahan  = $request->kelurahan;
                $userAddress->kode_pos   = $request->kode_pos;
                $userAddress->created_by = $user->name;
                $userAddress->save();
                
                DB::commit();
                return response()->json([
                    'error'        => false,
                    'message'      => 'Created',
                    'data'         => $userAddress,
                    'status'       => 201
                ], 201);
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function UserAddressUpdateAPI($id, $request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);

                $userAddress = UserAddress::where('id',$id)->where('user_id',$user->id)->first();
                if($userAddress){
                    $userAddress->city_id    = $request->city_id;
                    $userAddress->address    = $request->address;
                    $userAddress->kecamatan  = $request->kecamatan;
                    $userAddress->kelurahan  = $request->kelurahan;
                    $userAddress->kode_pos   = $request->kode_pos;
                    $userAddress->updated_by = $user->name;
                    $userAddress->save();

                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => $userAddress,
                        'status'       => 200
                    ], 200);
                }
                else{
                    DB::rollBack();
                    return response()->json([
                        'error'     => true,
                        'message'   => 'Data tidak ditemukan',
                        'data'      => '',
                        'status'    => 403
                    ], 403);
                }
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function UserAddressDeleteAPI($id)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);

                $userAddress = UserAddress::where('id',$id)->where('user_id',$user->id)->first();
                if($userAddress){
                    $userAddress->deleted_by = $user->name;
                    $userAddress->save();

                    $userAddress->delete();

                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => '',
                        'status'       => 200
                    ], 200);
                }
                else{
                    DB::rollBack();
                    return response()->json([
                        'error'     => true,
                        'message'   => 'Data tidak ditemukan',
                        'data'      => '',
                        'status'    => 403
                    ], 403);
                }
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function UserRekeningAPI($request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);

                $userRekening = UserRekening::select('id','bank_id','nama_rekening','no_rekening')->where('user_id',$user->id)->orderBy('id','desc')->paginate(100);
                
                if($userRekening->isEmpty()){
                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => [],
                        'current_page' => 1,
                        'total_page'   => 1,
                        'status'       => 200
                    ], 200);
                }
                else{
                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => $userRekening->toArray()['data'],
                        'current_page' => $userRekening->toArray()['current_page'],
                        'total_page'   => $userRekening->toArray()['last_page'],
                        'status'       => 200
                    ], 200);
                }
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function UserRekeningDetailAPI($id, $request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);

                $userRekening = UserRekening::select('id','bank_id','nama_rekening','no_rekening')->where('user_id',$user->id)->where('id',$id)->first();
                
                if(!$userRekening){
                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => '',
                        'status'       => 200
                    ], 200);
                }
                else{
                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => $userRekening,
                        'status'       => 200
                    ], 200);
                }
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function UserRekeningCreateAPI($request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);

                $userRekening = new UserRekening();
                $userRekening->user_id       = $user->id;
                $userRekening->bank_id       = $request->bank_id;
                $userRekening->nama_rekening = $request->nama_rekening;
                $userRekening->no_rekening   = $request->no_rekening;
                $userRekening->created_by    = $user->name;
                $userRekening->save();
                
                DB::commit();
                return response()->json([
                    'error'        => false,
                    'message'      => 'Created',
                    'data'         => $userRekening,
                    'status'       => 201
                ], 201);
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function UserRekeningUpdateAPI($id, $request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);

                $userRekening = UserRekening::where('id',$id)->where('user_id',$user->id)->first();
                if($userRekening){
                    $userRekening->bank_id       = $request->bank_id;
                    $userRekening->nama_rekening = $request->nama_rekening;
                    $userRekening->no_rekening   = $request->no_rekening;
                    $userRekening->updated_by    = $user->name;
                    $userRekening->save();

                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => $userRekening,
                        'status'       => 200
                    ], 200);
                }
                else{
                    DB::rollBack();
                    return response()->json([
                        'error'     => true,
                        'message'   => 'Data tidak ditemukan',
                        'data'      => '',
                        'status'    => 403
                    ], 403);
                }
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }

    public function UserRekeningDeleteAPI($id)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $bearerToken = request()->bearerToken();
            if($bearerToken == null){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = Token::find($tokenId)->revoked;
            
            if($revoked){
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else{
                $userId = (new Parser())->parse($bearerToken)->getClaim('sub');

                $user = User::find($userId);

                $userRekening = UserRekening::where('id',$id)->where('user_id',$user->id)->first();
                if($userRekening){
                    $userRekening->deleted_by = $user->name;
                    $userRekening->save();

                    $userRekening->delete();

                    DB::commit();
                    return response()->json([
                        'error'        => false,
                        'message'      => 'OK',
                        'data'         => '',
                        'status'       => 200
                    ], 200);
                }
                else{
                    DB::rollBack();
                    return response()->json([
                        'error'     => true,
                        'message'   => 'Data tidak ditemukan',
                        'data'      => '',
                        'status'    => 403
                    ], 403);
                }
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'     => true,
                'message'   => $e->getMessage(),
                'data'      => '',
                'status'    => 403
            ], 403);
        }
    }
}
