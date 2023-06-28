<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\redirectTo;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use redirectTo;
    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'password' => 'required|confirmed|min:8',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    /**
     *
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm($userId, $code)
    {
        Reminder::removeExpired();

        $userDb = Sentinel::findById($userId);

        if(Reminder::exists($userDb, $code)){
            return view('auth.passwords.reset');
        }

        return $this->redirectFailed(route('auth.forgot.password.form'), 'Invalid or expired reset code.');
    }

    /**
     * Reset the given user's password.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function reset(Request $request)
    {

        $request->validate($this->rules(), $this->validationErrorMessages());

        $user = Sentinel::findById($request->userId);

        if (!$user) {
            return $this->redirectFailed(route('auth.reset.password.form', [$request->userId, $request->code]), __('auth.forgot_password_email_not_found'));
        }

        $fullname = explode(" ", $user->name);
        $re = "/^(?=.*[a-z])(?=.*\\d).{8,}$/i";

        if(!preg_match($re, $request->password) || !ctype_alnum($request->password)){
            return $this->redirectFailed(route('auth.reset.password.form', [$request->userId, $request->code]), 'Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum');
        }
        else{
            if (!Reminder::complete($user, $request->code, $request->password)) {
                return $this->redirectFailed(route('auth.forgot.password.form'), 'Invalid or expired reset code.');
            }

            return $this->redirectSuccessUpdate(route('status.form'), __('auth.forgot_password_successful'));
        }
    }
}
