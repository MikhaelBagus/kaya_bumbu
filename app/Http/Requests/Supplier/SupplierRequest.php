<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
                'supplier_name'        => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'supplier_description' => 'nullable|regex:/^(?:[^"\'\<>])+$/i',
            ];
        }
        else{
            return [
                'supplier_name'        => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'supplier_description' => 'nullable|regex:/^(?:[^"\'\<>])+$/i',
            ];
        }
    }
}
