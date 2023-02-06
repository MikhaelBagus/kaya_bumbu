<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class newsRequest extends FormRequest
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
                'title'    => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'content'  => 'required',
                'publish'  => 'required|numeric'
            ];
        }
        else{
            return [
                'title'    => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'content'  => 'required',
                'publish'  => 'required|numeric'
            ];
        }
    }
}
