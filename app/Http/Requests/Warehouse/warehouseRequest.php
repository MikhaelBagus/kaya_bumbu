<?php

namespace App\Http\Requests\Warehouse;

use Illuminate\Foundation\Http\FormRequest;

class warehouseRequest extends FormRequest
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
                'warehouse_name'        => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'warehouse_description' => 'nullable|regex:/^(?:[^"\'\<>])+$/i',
            ];
        }
        else{
            return [
                'warehouse_name'        => 'required|regex:/^(?:[^"\'\<>])+$/i',
                'warehouse_description' => 'nullable|regex:/^(?:[^"\'\<>])+$/i',
            ];
        }
    }
}
