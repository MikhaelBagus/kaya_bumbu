<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login\loginRequest;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
	/**
	 * Show the application's login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showLoginForm(){
		if(Sentinel::check()){
			return redirect()->route('dashboard');
		}
		else{
			return view('auth.login');
		}
	}
	
	/**
	 * Handle a login request to the application.
	 *
	 * @param loginRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
	 */
	public function login(loginRequest $request){
		$credentials = array(
			'email'    => $request->email,
			'password' => $request->password,
		);

		$remember = $request->remember == 'On' ? true : false;

		try{
			if(Sentinel::authenticate($credentials, $remember)){
				if(Sentinel::getUser()->user_role->role->slug == 'root' || Sentinel::getUser()->user_role->role->slug !== 'member'){
					Session::flash('success', __('auth.login_successful'));
					if($request->rto !== null){
					    return redirect()->to($request->rto);
	                }
	                else{
	                	return redirect()->route('dashboard');
	                }
				}
				else{
					Sentinel::logout();
					Session::flash('failed', __('auth.login_unsuccessful'));
					return redirect()->route('login.form');
				}
            }
            else{
				Session::flash('failed', __('auth.login_unsuccessful'));
				return redirect()->route('login.form');
			}
		}
		catch(ThrottlingException $ex){
			Session::flash('failed', __('auth.login_timeout'));
			return redirect()->route('login.form');
		}
		catch(NotActivatedException $ex){
			Session::flash('failed', __('auth.login_unsuccessful_not_active'));
			return redirect()->route('login.form');
		}
	}
	
	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request){
		Sentinel::logout();
		Session::flash('success', __('auth.logout_successful'));
		return redirect()->route('login.form');
	}
}
