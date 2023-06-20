<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
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
                'price'         => 'required|numeric',
                'unit'          => 'required|regex:/^(?:[^"\'\<>])+$/i'
            ];
        }
        else{
            return [
                'name'          => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'price'         => 'required|numeric',
                'unit'          => 'required|regex:/^(?:[^"\'\<>])+$/i'
            ];
        }
    }
}
