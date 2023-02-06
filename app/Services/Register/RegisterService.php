<?php

namespace App\Services\Register;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Auth\Role;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Mail;
use App\Mail\activationEmail;

class RegisterService implements RegisterServiceContract
{
    public function RegisterAPI($request)
    {
        DB::beginTransaction();
        $error   = false;
        $message = '';

        try {
            $role = Role::where('slug','member')->first();

            $data = [
                'name'       => $request->name,
                'phone'      => $request->phone,
                'email'      => strtolower($request->email),
                'password'   => $request->password,
                'created_by' => $request->name,
                'updated_by' => '',
            ];

            $fullname = explode(" ", $request->name);
            $re = "/^(?=.*[a-z])(?=.*\\d).{8,}$/i";

            $checkEmail = User::where('email',$request->email)->first();
            if($checkEmail){
                return response()->json([
                    'error'     => true,
                    'message'   => 'Email has been taken',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else if(!preg_match($re, $request->password) || !ctype_alnum($request->password) || strpos(strtolower($request->password), strtolower($fullname[0]))){
                return response()->json([
                    'error'     => true,
                    'message'   => 'Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum and not contain private content',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }
            else if(strpos(strtolower($request->password), strtolower($fullname[0])) === 0){
                return response()->json([
                    'error'     => true,
                    'message'   => 'Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum and not contain private content',
                    'data'      => '',
                    'status'    => 403
                ], 403);
            }

            //Create a new user
            $user = Sentinel::register($data);
            $activation = Activation::create($user);

            //Attach the user to the role
            $role = Sentinel::findRoleById($role->id);
            $role->users()->attach($user);

            Mail::to($user->email)->send(new activationEmail($user, $activation->code));

            DB::commit();

            $status = 201;

            return response()->json([
                'error'     => false,
                'message'   => 'Register success. Please check your email for activation.',
                'data'      => $user,
                'status'    => $status
            ], $status);
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
