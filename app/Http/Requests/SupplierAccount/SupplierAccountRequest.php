<?php

namespace App\Http\Requests\SupplierAccount;

use Illuminate\Foundation\Http\FormRequest;

class SupplierAccountRequest extends FormRequest
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
                'supplier_id'    => 'required|exists:supplier,id',
                'account_number' => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'account_name'   => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'bank_name'      => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'description'    => 'nullable|regex:/^(?:[^"\'\<>])+$/i',
            ];
        }
        else{
            return [
                'supplier_id'    => 'required|exists:supplier,id',
                'account_number' => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'account_name'   => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'bank_name'      => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'description'    => 'nullable|regex:/^(?:[^"\'\<>])+$/i',
            ];
        }
    }
}
