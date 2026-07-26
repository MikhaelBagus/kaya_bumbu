<?php

namespace App\Http\Requests\IngredientGroup;

use App\Support\IngredientImportNormalizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ingredientGroupRequest extends FormRequest
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
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => IngredientImportNormalizer::group($this->input('name')),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'regex:/^(?:[^"\'\<>])+$/i',
                Rule::unique('ingredient_master_groups', 'name')
                    ->ignore($this->route('id')),
            ],
        ];
    }
}
