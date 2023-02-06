<?php

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

class mediaRequest extends FormRequest
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
                'type'     => 'required',
                'image'    => 'required|mimes:jpg,jpeg,png'
            ];
        }
        else{
            return [
                'type'     => 'required',
                'image'    => 'required|mimes:jpg,jpeg,png'
            ];
        }
    }
}
