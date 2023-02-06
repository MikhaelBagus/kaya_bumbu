<?php

namespace App\Services\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
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
                        'phone'    => $user->phone
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
}
