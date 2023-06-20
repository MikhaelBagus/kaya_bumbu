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
                'customer_id'    => 'required|numeric',
                'bank_id'        => 'required|numeric',
                'city_id'        => 'required|numeric',
                'source_id'      => 'required|numeric',
                'date'           => 'required',
                'address'        => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'discount_price' => 'required|numeric',
                'ongkir_price'   => 'required|numeric',
                'item'           => 'required'
            ];
        }
        else{
            return [
                'customer_id'    => 'required|numeric',
                'bank_id'        => 'required|numeric',
                'city_id'        => 'required|numeric',
                'source_id'      => 'required|numeric',
                'date'           => 'required',
                'address'        => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'discount_price' => 'required|numeric',
                'ongkir_price'   => 'required|numeric',
                'item'           => 'required'
            ];
        }
    }
}
