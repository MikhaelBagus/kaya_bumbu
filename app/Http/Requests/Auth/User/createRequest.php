<?php

namespace App\Http\Requests\Auth\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Auth\Role;

class createRequest extends FormRequest {
	
	
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		if(request()->role == null){
			return [
	            'name'     => 'required|regex:/(^[A-Za-z0-9_-_ ]+$)+/', //|unique:users
	            'phone'    => 'required|numeric',
	            'email'    => 'required|unique:users|email',
	            'role'     => 'required',
	            'password' => 'required|confirmed|min:8',
			];
		}
		else{
			$roleDb = Role::select('id','slug')->where('id', request()->role)->first();
			if($roleDb == null){
				return [
		            'name'     => 'required|regex:/(^[A-Za-z0-9_-_ ]+$)+/', //|unique:users
		            'phone'    => 'required|numeric',
		            'email'    => 'required|unique:users|email',
		            'role'     => 'required',
		            'password' => 'required|confirmed|min:8',
				];
			}
			else{
				return [
		            'name'     => 'required|regex:/(^[A-Za-z0-9_-_ ]+$)+/', //|unique:users
		            'phone'    => 'required|numeric',
		            'email'    => 'required|unique:users|email',
		            'role'     => 'required',
		            'password' => 'required|confirmed|min:8',
				];
			}
		}
	}
}
