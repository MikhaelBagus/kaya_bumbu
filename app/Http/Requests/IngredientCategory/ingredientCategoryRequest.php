<?php

namespace App\Http\Requests\IngredientCategory;

use App\Support\IngredientImportNormalizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ingredientCategoryRequest extends FormRequest
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
            'name' => IngredientImportNormalizer::category($this->input('name')),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'regex:/^(?:[^"\'\<>])+$/i',
                Rule::unique('ingredient_master_categories', 'name')
                    ->ignore($this->route('id')),
            ],
        ];
    }
}
