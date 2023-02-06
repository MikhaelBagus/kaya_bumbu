<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class transactionRequest extends FormRequest
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
                'date'     => 'required',
                'discount' => 'required|numeric',
                'item'     => 'required'
            ];
        }
        else{
            return [
                'date'     => 'required',
                'discount' => 'required|numeric',
                'item'     => 'required'
            ];
        }
    }
}
