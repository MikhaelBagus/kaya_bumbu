<?php

namespace App\Services\Logout;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use Laravel\Passport\Token;
use Lcobucci\JWT\Parser;

class LogoutService implements LogoutServiceContract
{
    public function LogoutAPI($request)
    {
        DB::beginTransaction();
        $error   = true;
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

                if ($user == false) {
                    $error      = true;
                    $message    = 'Email not found';
                    $user       = '';
                    $status     = 403;
                }
                else {
                    //revoke available token
                    $userTokens = $user->tokens;
                    foreach ($userTokens as $token) {
                        if (isset($request->device)) {
                            if ($request->device == "mobile") {
                                if ($token->client_id == "2") { //for android device
                                    $token->revoke();
                                }
                            }
                            else {
                                $token->revoke();
                            }
                        }
                        else {
                            $token->revoke();
                        }
                    }

                    $user->firebase_device_token = null;
                    $user->updated_by            = $user->name;
                    $user->save();

                    $error      = false;
                    $message    = 'Logout success';
                    $status     = 200;
                }

                DB::commit();

                return response()->json([
                    'error'      => $error,
                    'message'    => $message,
                    'data'       => '',
                    'status'     => $status
                ], $status);
            }
        }
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error'      => true,
                'message'    => $e->getMessage(),
                'data'       => '',
                'status'     => 403
            ], 403);
        }
    }
}
