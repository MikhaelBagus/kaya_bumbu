<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

class faqRequest extends FormRequest
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
                'question' => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'answer'   => 'required|regex:/^(?:[^"\'\<>])+$/i'
            ];
        }
        else{
            return [
                'question' => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'answer'   => 'required|regex:/^(?:[^"\'\<>])+$/i'
            ];
        }
    }
}
