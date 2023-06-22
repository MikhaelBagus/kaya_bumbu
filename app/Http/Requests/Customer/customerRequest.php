<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class customerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(request()->method == 'POST'){
            return [
                'name'          => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'phone'         => 'required|numeric',
                'city_id'       => 'required|numeric',
            ];
        }
        else{
            return [
                'name'          => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'phone'         => 'required|numeric',
                'city_id'       => 'required|numeric',
            ];
        }
    }
}
