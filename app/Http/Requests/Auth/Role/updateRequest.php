<?php

namespace App\Http\Requests\Auth\Role;

use Illuminate\Foundation\Http\FormRequest;

class updateRequest extends FormRequest {
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
		
		$rules = [
			'name' => 'required|unique:roles,name,' . request()->route()->role . '|regex:/^(?:[^"\'\<>])+$/i',
		];
		
		return $rules;
	}
}
