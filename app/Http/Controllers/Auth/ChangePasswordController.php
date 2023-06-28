<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\changePasswordRequest;
use App\Traits\redirectTo;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ChangePasswordController extends Controller
{
    use redirectTo;

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(){
        if(Sentinel::getUser()->user_role->role->slug != 'member'){
            return view('auth.passwords.change');
        }
        else{
            return redirect()->route('front.home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param changePasswordRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(changePasswordRequest $request){
        $user = Sentinel::getUser();

        $credentials = [
            'email'    => $user->email,
            'password' => $request->old_password,
        ];

        $fullname = explode(" ", $user->name);
        $re = "/^(?=.*[a-z])(?=.*\\d).{8,}$/i";

        if(!preg_match($re, $request->password) || !ctype_alnum($request->password)){
            return $this->redirectFailed(route('auth.change.password.form'), 'New Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum')->withInput($request->all());
        }

        #Password Is Valid For This User
        if(Sentinel::validateCredentials($user, $credentials)) {
            $credentials['password'] = $request->password;

            Sentinel::update($user, $credentials);

            return $this->redirectSuccessUpdate(route('auth.change.password.form'), 'Password');
        }
        else {
            return $this->redirectFailed(route('auth.change.password.form'), 'Your old password mismatch')->withInput($request->all());
        }
    }
}
