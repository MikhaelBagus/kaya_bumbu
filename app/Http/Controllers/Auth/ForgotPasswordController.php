<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\redirectTo;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\forgotPasswordEmail;

class ForgotPasswordController extends Controller
{
    use redirectTo;

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
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function sendResetLinkResponse(Request $request)
    {
        $this->validateEmail($request);

        $user = Sentinel::findByCredentials(['login' => $request->email]);

        if (!$user) {
            return $this->redirectSuccessSend(route('auth.forgot.password.form'), __('auth.forgot_password_successful'));
            // return $this->redirectFailed(route('auth.forgot.password.form'), __('auth.forgot_password_email_not_found'));
        }

        if ($user->user_role->role->slug == 'member') {
            // return $this->redirectSuccessSend(route('auth.forgot.password.form'), __('auth.forgot_password_successful'));
            return $this->redirectFailed(route('auth.forgot.password.form'), __('auth.forgot_password_email_not_found'));
        }

        DB::beginTransaction();
        try {
            $checkReminder = Reminder::exists($user);
            if(!$checkReminder){
                $reminder = Reminder::create($user);
            }
            else{
                $reminder = Reminder::where('user_id',$user->id)->where('completed',0)->first();
            }
            $code     = $reminder->code;

            $link     = route('auth.reset.password.form', [$user->getUserId(), $code]);
            $security = route('auth.change.password.form');

            Mail::to($user->email)->send(new forgotPasswordEmail($user, $code));

            DB::commit();

            return $this->redirectSuccessSend(route('auth.forgot.password.form'), __('auth.forgot_password_successful'));

        } catch (\Exception $exception) {

            DB::rollBack();

            dd($exception->getMessage().' '.$exception->getCode());

            return $this->redirectFailed(route('auth.forgot.password.form'), __('auth.forgot_password_unsuccessful'));

        }
    }
}
