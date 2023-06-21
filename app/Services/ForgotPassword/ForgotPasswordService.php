<?php

namespace App\Services\ForgotPassword;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Auth\Role;
use App\Models\Log;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Mail;
use App\Mail\forgotPasswordEmail;
use Hash;

class ForgotPasswordService implements ForgotPasswordServiceContract
{
    public function ForgotPasswordAPI($request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $user = User::where('email', $request->email)->first();
            if($user){
                if($user->user_role->role->slug == 'member'){
                    $user = Sentinel::findByCredentials(['login' => $request->email]);

                    $checkReminder = Reminder::exists($user);
                    if(!$checkReminder){
                        $reminder = Reminder::create($user);
                    }
                    else{
                        $reminder = Reminder::where('user_id',$user->id)->where('completed',0)->first();
                    }
                    $code = $reminder->code;

                    Mail::to($user->email)->send(new forgotPasswordEmail($user, $code));

                    DB::commit();

                    $status = 200;

                    return response()->json([
                        'error'     => false,
                        'message'   => 'Link reset password sudah kami kirim, silahkan cek email Anda',
                        'data'      => '',
                        'status'    => $status
                    ], $status);
                }
                else{
                    return response()->json([
                        'error'     => false,
                        'message'   => 'Email not found',
                        'data'      => '',
                        'status'    => 403
                    ], 403);
                }
            }
            else{
                return response()->json([
                    'error'     => false,
                    'message'   => 'Email not found',
                    'data'      => '',
                    'status'    => 403
                ], 403);
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

    public function SetPasswordAPI($request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            Reminder::removeExpired();
            $user = User::where('id',$request->user_id)->first();

            if(Reminder::exists($user, $request->code)){
                $fullname = explode(" ", $user->name);
                $re = "/^(?=.*[a-z])(?=.*\\d).{8,}$/i";
                
                if(!preg_match($re, $request->password) || !ctype_alnum($request->password) || strpos(strtolower($request->password), strtolower($fullname[0]))){
                    return response()->json([
                        'error'     => true,
                        'message'   => 'New Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum and not contain private content',
                        'data'      => '',
                        'status'    => 403
                    ], 403);
                }
                else if(strpos(strtolower($request->password), strtolower($fullname[0])) === 0){
                    return response()->json([
                        'error'     => true,
                        'message'   => 'New Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum and not contain private content',
                        'data'      => '',
                        'status'    => 403
                    ], 403);
                }
                else{
                    $user->password   = Hash::make($request->password);
                    $user->updated_by = $user->name;
                    $user->save();

                    $status = 200;

                    DB::commit();

                    return response()->json([
                        'error'     => false,
                        'message'   => 'Reset password success',
                        'data'      => '',
                        'status'    => $status
                    ], $status);
                }
            }
            else{
                return response()->json([
                    'error'     => true,
                    'message'   => 'Kode reset tidak valid',
                    'data'      => '',
                    'status'    => 403
                ], 403);
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
