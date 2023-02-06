<?php

namespace App\Http\Requests\Disclaimer;

use Illuminate\Foundation\Http\FormRequest;

class disclaimerRequest extends FormRequest
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
                'content'    => 'required'
            ];
        }
        else{
            return [
                'content'    => 'required'
            ];
        }
    }
}
